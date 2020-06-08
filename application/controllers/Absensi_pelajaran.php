<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absensi_pelajaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_pelajaran_model');
        $this->load->model('Siswa_model');
        is_login();
        $hak_akses = $this->router->fetch_class() . "_" . $this->router->fetch_method();
        if (have_access($hak_akses) == 'N') {            
            $this->load->view('view_blok_index');           
        } 
    }

    public function index()
    {
        $users_id = $this->session->userdata('users_id');
        $guru = $this->Absensi_pelajaran_model->get_guru_guru_id($users_id);

        if ($guru->num_rows() > 0) {
            $guru_row = $guru->row();
            $mata_pelajaran_guru = $this->Absensi_pelajaran_model->get_mata_pelajaran_by_guru($guru_row->guru_id);
            $data['menu'] = "Sekolah";
            $data['page'] = "Absensi Pelajaran";
            $data['load_css_js'] = "";
            $data['mata_pelajaran_guru_data'] = $mata_pelajaran_guru->result();
            $this->template->load('template/main_template', 'view_absensi_pelajaran_index', $data);
        }
    }

    public function daftar_siswa()
    {
        $absensi_pelajaran_id = urldecode($this->input->get('mata_pelajaran_guru_kelas', TRUE));

        $row_pelajaran = $this->Absensi_pelajaran_model->get_mata_pelajaran_guru_kelas_id($absensi_pelajaran_id)->row();
        $data['menu'] = "Sekolah";
        $data['page'] = "Daftar Absensi Siswa Mata Pelajaran " . $row_pelajaran->mata_pelajaran_nama . ' | Kelas ' . $row_pelajaran->kelas_nama;
        $data['load_css_js'] = "absensi_pelajaran_daftar_siswa";
        $data['kode_mata_pelajaran_guru'] = $absensi_pelajaran_id;
        // set seesion untuk digunakan JS
        $this->session->set_userdata('mata_pelajaran_guru_kelas', $absensi_pelajaran_id);
        // cek dan isi table absen pelajaran
        $mata_pelajaran_guru_kelas_id = $row_pelajaran->mata_pelajaran_guru_kelas_id;
        $kelas_id = $row_pelajaran->kelas_id;
        $date_now = date('Y-m-d');
        // cek data absensi_pelajaran sesui degan mata_pelajaran_guru_kelas_id dan waktu
        $siswa = $this->Absensi_pelajaran_model->get_absensi_siswa_by_mapel_guru($mata_pelajaran_guru_kelas_id, $date_now)->num_rows();
        if ($siswa < 1) {
            // insert absensi siswa
            $result_siswa = $this->Siswa_model->get_siswa_by_kelas($kelas_id)->result();
            $waktu = date('Y-m-d H:i:s');

            foreach ($result_siswa as $siswa) {
                $data_insert['absensi_pelajaran_id'] = insert_uuid();
                $data_insert['siswa_NIS'] = $siswa->siswa_NIS;
                $data_insert['mata_pelajaran_guru_kelas_id'] = $mata_pelajaran_guru_kelas_id;
                $data_insert['absensi_pelajaran_status'] = "B";
                $data_insert['absensi_pelajaran_buat_waktu'] = $waktu;
                $data_insert['absensi_pelajaran_buat_oleh'] = $this->session->userdata('users_nama_lengkap');
                $this->Absensi_pelajaran_model->insert_absensi_pelajaran($data_insert);
            }
        }
        $this->template->load('template/main_template', 'view_absensi_pelajaran_daftar_absensi', $data);
    }

    public function json_daftar_siswa()
    {
        $mata_pelajaran_guru_kelas_id = $this->session->userdata('mata_pelajaran_guru_kelas');
        $date_now = date('Y-m-d');
        $row_absensi_siswa = $this->Absensi_pelajaran_model->get_absensi_siswa_by_mapel_guru($mata_pelajaran_guru_kelas_id, $date_now)->result();
        // print_r($recordsTotal.' | '.$recordsFiltered);
        // exit();
        $data = array();
        $no = $_POST['start'];
        foreach ($row_absensi_siswa as $siswa) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $siswa->siswa_NIS;

            if ($siswa->absensi_pelajaran_status == "B") {
                $row[] = $siswa->siswa_nama_lengkap;
            } elseif ($siswa->absensi_pelajaran_status == "H") {
                $row[] = '<span class="label label-success lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->absensi_pelajaran_status == "T") {
                $row[] = '<span class="label bg-navy lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->absensi_pelajaran_status == "S") {
                $row[] = '<span class="label label-warning lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->absensi_pelajaran_status == "I") {
                $row[] = '<span class="label label-info lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->absensi_pelajaran_status == "A") {
                $row[] = '<span class="label label-danger lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            }

            // Tambah Kolom Aksi
            if ($siswa->absensi_pelajaran_status == "B") {
                $row[] = '<a class="btn btn-sm btn-success mb3" href="javascript:void(0)" title="Hadir" id="hadir_absensi_pelajaran" data-absensi_pelajaran_id="' . $siswa->absensi_pelajaran_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Hadir</a>
                <a class="btn btn-sm bg-navy mb3" href="javascript:void(0)" title="Telat" id="telat_absensi_pelajaran" data-absensi_pelajaran_id="' . $siswa->absensi_pelajaran_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Telat</a>
                <a class="btn btn-sm btn-warning mb3" href="javascript:void(0)" title="Sakit" id="sakit_absensi_pelajaran" data-absensi_pelajaran_id="' . $siswa->absensi_pelajaran_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Sakit</a>
                <a class="btn btn-sm btn-info mb3" href="javascript:void(0)" title="Ijin" id="ijin_absensi_pelajaran" data-absensi_pelajaran_id="' . $siswa->absensi_pelajaran_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Ijin</a>
                <a class="btn btn-sm btn-danger mb3" href="javascript:void(0)" title="Absen" id="absen_absensi_pelajaran" data-absensi_pelajaran_id="' . $siswa->absensi_pelajaran_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Absen</a>';
            } else {
                $row[] = '<a class="btn bg-purple btn-sm" href="javascript:void(0)" title="Edit" id="edit_absensi_pelajaran" 
                data-absensi_pelajaran_id="' . $siswa->absensi_pelajaran_id . '" 
                data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '"
                data-absensi_pelajaran_status="' . $siswa->absensi_pelajaran_status . '"
                data-absensi_pelajaran_keterangan="' . $siswa->absensi_pelajaran_keterangan . '">Edit Status Absensi</a>';
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => 10,
            "recordsFiltered" => 10,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function hadir_absensi_pelajaran()
    {
        $absensi_pelajaran_id = $this->input->post('absensi_pelajaran_id', TRUE);
        $data['absensi_pelajaran_status'] = "H";
        $data['absensi_pelajaran_update_waktu'] = date('Y-m-d H:i:s');
        $data['absensi_pelajaran_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Absensi_pelajaran_model->update_status_absensi_pelajaran($absensi_pelajaran_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function telat_absensi_pelajaran()
    {
        $absensi_pelajaran_id = $this->input->post('absensi_pelajaran_id', TRUE);
        $data['absensi_pelajaran_status'] = "T";
        $data['absensi_pelajaran_update_waktu'] = date('Y-m-d H:i:s');
        $data['absensi_pelajaran_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Absensi_pelajaran_model->update_status_absensi_pelajaran($absensi_pelajaran_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function sakit_absensi_pelajaran()
    {
        $absensi_pelajaran_id = $this->input->post('absensi_pelajaran_id', TRUE);
        $data['absensi_pelajaran_status'] = "S";
        $data['absensi_pelajaran_update_waktu'] = date('Y-m-d H:i:s');
        $data['absensi_pelajaran_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Absensi_pelajaran_model->update_status_absensi_pelajaran($absensi_pelajaran_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ijin_absensi_pelajaran()
    {
        $absensi_pelajaran_id = $this->input->post('absensi_pelajaran_id', TRUE);
        $data['absensi_pelajaran_status'] = "I";
        $data['absensi_pelajaran_update_waktu'] = date('Y-m-d H:i:s');
        $data['absensi_pelajaran_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Absensi_pelajaran_model->update_status_absensi_pelajaran($absensi_pelajaran_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function absen_absensi_pelajaran()
    {
        $absensi_pelajaran_id = $this->input->post('absensi_pelajaran_id', TRUE);
        $data['absensi_pelajaran_status'] = "A";
        $data['absensi_pelajaran_update_waktu'] = date('Y-m-d H:i:s');
        $data['absensi_pelajaran_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Absensi_pelajaran_model->update_status_absensi_pelajaran($absensi_pelajaran_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function simpan_status_absensi_pelajaran()
    {
        $this->form_validation->set_rules('absensi_pelajaran_id', 'Pelajaran ID', 'trim');
        $this->form_validation->set_rules('absensi_pelajaran_status', 'Status Absesni', 'trim|required');
        $this->form_validation->set_rules('absensi_pelajaran_keterangan', 'Keterangan', 'trim|required');
        //$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if ($this->form_validation->run()) {
            $data = array(
                'absensi_pelajaran_status' => $this->input->post('absensi_pelajaran_status', true),
                'absensi_pelajaran_keterangan' => ucwords($this->input->post('absensi_pelajaran_keterangan', true))
            );
            $this->Absensi_pelajaran_model->update_status_absensi_pelajaran($this->input->post('absensi_pelajaran_id', true), $data);
            echo json_encode(array("status" => true));
        } else {
            $errors = validation_errors();
            $array = array(
                'status'   => false,
                'errors' => $errors,
            );
            echo json_encode($array);
        }
    }

    public function kirim_absensi_pelajaran()
    {
        $absensi_pelajaran_id = urldecode($this->input->get('mata_pelajaran_guru_kelas', TRUE));
        $waktu = date('Y-m-d');
        $siswa =  $this->Absensi_pelajaran_model->get_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu);
        if ($siswa->num_rows() > 0) {
            $this->session->set_flashdata('error_message', 'Ada Siswa yang belum terabsensi. Mohon lebih teliti.');
            redirect(site_url('absensi_pelajaran/daftar_siswa?mata_pelajaran_guru_kelas=') . $absensi_pelajaran_id);
        }


        $dashboard_absensi_pelajaran = $this->Absensi_pelajaran_model->get_dashboard_absensi_pelajaran_by_pelajaran($absensi_pelajaran_id, $waktu);

        $time_now = date('Y-m-d H:i:s');
        if ($dashboard_absensi_pelajaran->num_rows() > 0) {
            // Update                    
            $data_dash['total_siswa'] = $this->Absensi_pelajaran_model->get_total_all_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu)->num_rows();
            $data_dash['total_hadir'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "H")->num_rows();
            $data_dash['total_telat'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "T")->num_rows();
            $data_dash['total_sakit'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "S")->num_rows();
            $data_dash['total_ijin'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "I")->num_rows();
            $data_dash['total_absen'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "A")->num_rows();
            $data_dash['dashboard_absensi_pelajaran_waktu'] = $time_now;
            $this->Absensi_pelajaran_model->update_dashboard_absensi_pelajaran($absensi_pelajaran_id, $waktu, $data_dash);
            $this->session->set_flashdata('success_message', 'Anda telah melakukan update absensi pelajaran');
            redirect(site_url('dashboard'));
        } else {
            // Insert
            $data_dash['dashboard_absensi_pelajaran_id'] = insert_uuid();
            $data_dash['mata_pelajaran_guru_kelas_id'] = $absensi_pelajaran_id;
            $data_dash['total_siswa'] = $this->Absensi_pelajaran_model->get_total_all_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu)->num_rows();
            $data_dash['total_hadir'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "H")->num_rows();
            $data_dash['total_telat'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "T")->num_rows();
            $data_dash['total_sakit'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "S")->num_rows();
            $data_dash['total_ijin'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "I")->num_rows();
            $data_dash['total_absen'] = $this->Absensi_pelajaran_model->get_total_check_absensi_siswa_by_mapel_guru($absensi_pelajaran_id, $waktu, "A")->num_rows();
            $data_dash['dashboard_absensi_pelajaran_waktu'] = $time_now;
            $this->Absensi_pelajaran_model->insert_dashboard_absensi_pelajaran($data_dash);
            $this->session->set_flashdata('success_message', 'Terima kasih telah melakukan absensi pelajaran');
            redirect(site_url('dashboard'));
        }
    }
}
