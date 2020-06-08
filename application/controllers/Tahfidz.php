<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tahfidz extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mushrif_tahfidz_model');
        $this->load->model('Siswa_model');
        $this->load->model('Tahfidz_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Al_quran_model');
    }

    public function index()
    {
        $users_id = $this->session->userdata('users_id');
        $mushrif_tahfidz_row = $this->Mushrif_tahfidz_model->get_mushrif_tahfidz_user_users_id($users_id)->row();
        $mushrif_tahfidz_id = $mushrif_tahfidz_row->mushrif_tahfidz_id;
        $date_now = date('Y-m-d');
        $tahfidz_sesi = sesi_tahfidz();
        $tahfidz = $this->Tahfidz_model->get_tahfidz3_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $tahfidz_sesi, $date_now);
        if ($tahfidz->num_rows() < 1) {
            $result_santri = $this->Siswa_model->get_santri_mushrif_tahfidz_by_mushrif($mushrif_tahfidz_id)->result();
            foreach ($result_santri as $santri) {
                $data_santri = array(
                    'tahfidz_id' => insert_uuid(),
                    'siswa_NIS' => $santri->siswa_NIS,
                    'mushrif_tahfidz_id' => $mushrif_tahfidz_id,
                    'tahfidz_sesi' =>  $tahfidz_sesi,
                    'tahfidz_absensi_status' =>  'B',
                    'tahfidz_buat_waktu' => date('Y-m-d H:i:s'),
                    'tahfidz_buat_oleh' => $this->session->userdata('users_nama_lengkap'),
                );
                $this->Tahfidz_model->insert_tahfidz($data_santri);
            }
        }
        $data['menu'] = "Pesantren";
        $data['page'] = "Daftar Santri Tahfidz Ustadz/ah " . $mushrif_tahfidz_row->users_nama_lengkap . " | Tanggal : " . tgl_indo(date('Y-m-d'));
        $data['load_css_js'] = "tahfidz_daftar_santri";
        $data['mushrif_tahfidz_id'] = $mushrif_tahfidz_id;
        //$data['al_quran_data'] = $this->Al_quran_model->get_all_alquran()->result();

        $this->session->set_userdata('mushrif_tahfidz_id', $mushrif_tahfidz_id);

        $this->template->load('template/main_template', 'view_tahfidz_index', $data);
    }

    public function json_daftar_santri()
    {
        $mushrif_tahfidz_id = $this->session->userdata('mushrif_tahfidz_id');
        $date_now = date('Y-m-d');
        $tahfidz_sesi = sesi_tahfidz();
        $result_absensi_tahfidz = $this->Tahfidz_model->get_tahfidz_santri_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $tahfidz_sesi, $date_now);
        $data = array();
        $no = $_POST['start'];
        foreach ($result_absensi_tahfidz->result() as $siswa) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $siswa->siswa_NIS;

            if ($siswa->tahfidz_absensi_status == "B") {
                $row[] = $siswa->siswa_nama_lengkap;
            } elseif ($siswa->tahfidz_absensi_status == "H") {
                $row[] = '<span class="label label-success lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->tahfidz_absensi_status == "T") {
                $row[] = '<span class="label bg-navy lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->tahfidz_absensi_status == "S") {
                $row[] = '<span class="label label-warning lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->tahfidz_absensi_status == "I") {
                $row[] = '<span class="label label-info lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            } elseif ($siswa->tahfidz_absensi_status == "A") {
                $row[] = '<span class="label label-danger lbl-nama">' . $siswa->siswa_nama_lengkap . '</span>';
            }
            // Tambah Kolom Aksi
            if ($siswa->tahfidz_absensi_status == "B") {
                $row[] = '<a class="btn btn-sm btn-success mb3" href="javascript:void(0)" title="Hadir" id="hadir_absensi_tahfidz" data-tahfidz_id="' . $siswa->tahfidz_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Hadir</a>
                <a class="btn btn-sm bg-navy mb3" href="javascript:void(0)" title="Telat" id="telat_absensi_tahfidz" data-tahfidz_id="' . $siswa->tahfidz_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Telat</a>
                <a class="btn btn-sm btn-warning mb3" href="javascript:void(0)" title="Sakit" id="sakit_absensi_tahfidz" data-tahfidz_id="' . $siswa->tahfidz_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Sakit</a>
                <a class="btn btn-sm btn-info mb3" href="javascript:void(0)" title="Ijin" id="ijin_absensi_tahfidz" data-tahfidz_id="' . $siswa->tahfidz_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Ijin</a>
                <a class="btn btn-sm btn-danger mb3" href="javascript:void(0)" title="Absen" id="absen_absensi_tahfidz" data-tahfidz_id="' . $siswa->tahfidz_id . '" data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '">Absen</a>';
            } else {
                if ($siswa->al_quran_id != null) {
                    $row[] = '<span class="label label-default lbl-nama">Sudah Setor</span>';
                }else{
                    $row[] = '<a class="btn bg-purple btn-sm" href="javascript:void(0)" title="Edit" id="edit_absensi_tahfidz" 
                data-tahfidz_id="' . $siswa->tahfidz_id . '" 
                data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '"
                data-tahfidz_absensi_status="' . $siswa->tahfidz_absensi_status . '"
                data-tahfidz_absensi_keterangan="' . $siswa->tahfidz_absensi_keterangan . '">Edit Status Absensi</a>
                <a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Setor Tahfidz" id="serot_tahfidz" 
                data-tahfidz_id="' . $siswa->tahfidz_id . '" 
                data-siswa_nama_lengkap="' . $siswa->siswa_nama_lengkap . '"
                data-tahfidz_absensi_status="' . $siswa->tahfidz_absensi_status . '">Setor Tahfidz</a>';
                }                
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

    public function hadir_tahfidz()
    {
        $tahfidz_id = $this->input->post('tahfidz_id', TRUE);
        $data['tahfidz_absensi_status'] = "H";
        $data['tahfidz_update_waktu'] = date('Y-m-d H:i:s');
        $data['tahfidz_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Tahfidz_model->update_status_tahfidz($tahfidz_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function telat_tahfidz()
    {
        $tahfidz_id = $this->input->post('tahfidz_id', TRUE);
        $data['tahfidz_absensi_status'] = "T";
        $data['tahfidz_update_waktu'] = date('Y-m-d H:i:s');
        $data['tahfidz_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Tahfidz_model->update_status_tahfidz($tahfidz_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function sakit_tahfidz()
    {
        $tahfidz_id = $this->input->post('tahfidz_id', TRUE);
        $data['tahfidz_absensi_status'] = "S";
        $data['tahfidz_update_waktu'] = date('Y-m-d H:i:s');
        $data['tahfidz_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Tahfidz_model->update_status_tahfidz($tahfidz_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ijin_tahfidz()
    {
        $tahfidz_id = $this->input->post('tahfidz_id', TRUE);
        $data['tahfidz_absensi_status'] = "I";
        $data['tahfidz_update_waktu'] = date('Y-m-d H:i:s');
        $data['tahfidz_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Tahfidz_model->update_status_tahfidz($tahfidz_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function absen_tahfidz()
    {
        $tahfidz_id = $this->input->post('tahfidz_id', TRUE);
        $data['tahfidz_absensi_status'] = "A";
        $data['tahfidz_update_waktu'] = date('Y-m-d H:i:s');
        $data['tahfidz_update_oleh'] = $this->session->userdata('users_nama_lengkap');
        $this->Tahfidz_model->update_status_tahfidz($tahfidz_id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function simpan_status_tahfidz()
    {
        $this->form_validation->set_rules('tahfidz_id', 'Pelajaran ID', 'trim');
        $this->form_validation->set_rules('tahfidz_absensi_status', 'Status Absesni', 'trim|required');
        $this->form_validation->set_rules('tahfidz_absensi_keterangan', 'Keterangan', 'trim|required');
        //$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if ($this->form_validation->run()) {
            $data = array(
                'tahfidz_absensi_status' => $this->input->post('tahfidz_absensi_status', true),
                'tahfidz_absensi_keterangan' => ucwords($this->input->post('tahfidz_absensi_keterangan', true))
            );
            $this->Tahfidz_model->update_status_tahfidz($this->input->post('tahfidz_id', true), $data);
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

    public function kirim_tahfidz()
    {
        $mushrif_tahfidz_id = urldecode($this->input->get('mushrif_tahfidz', TRUE));
        $waktu = date('Y-m-d');
        $sesi_tahfidz = sesi_tahfidz();
        $tahfidz_cek =  $this->Tahfidz_model->get_check_absensi_santri_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $waktu, $sesi_tahfidz);

        if ($tahfidz_cek->num_rows() > 0) {
            $this->session->set_flashdata('error_message', 'Ada santri yang belum terabsensi. Mohon lebih teliti.');
            redirect(site_url('tahfidz'));
        }
        $dashboard_tahfidz = $this->Dashboard_model->get_dashboard_tahfidz_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $waktu, $sesi_tahfidz);
        //var_dump($dashboard_tahfidz);        
        $time_now = date('Y-m-d H:i:s');
        if ($dashboard_tahfidz->num_rows() > 0) {
            // Update                    
            $data_update['total_santri'] = $this->Tahfidz_model->get_all_absensi_santri_by_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, $sesi_tahfidz)->num_rows();
            $data_update['total_hadir'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "H", $sesi_tahfidz)->num_rows();
            $data_update['total_telat'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "T", $sesi_tahfidz)->num_rows();
            $data_update['total_sakit'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "S", $sesi_tahfidz)->num_rows();
            $data_update['total_ijin'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "I", $sesi_tahfidz)->num_rows();
            $data_update['total_absen'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "A", $sesi_tahfidz)->num_rows();
            $data_update['dashboard_absensi_tahfid_update_waktu'] = $time_now;
            $data_update['dashboard_absensi_tahfid_update_oleh'] = $this->session->userdata('users_nama_lengkap');
            $this->Dashboard_model->update_dashboard_tahfidz($mushrif_tahfidz_id, $waktu, $sesi_tahfidz, $data_update);
            $this->session->set_flashdata('success_message', 'Anda telah melakukan update absensi tahfidz');
            redirect(site_url('dashboard'));
        } else {
            // Insert
            $data_dash['dashboard_absensi_tahfid_id'] = insert_uuid();
            $data_dash['mushrif_tahfidz_id'] = $mushrif_tahfidz_id;
            $data_dash['tahfidz_sesi'] = $sesi_tahfidz;
            $data_dash['total_santri'] = $this->Tahfidz_model->get_all_absensi_santri_by_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, $sesi_tahfidz)->num_rows();
            $data_dash['total_hadir'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "H", $sesi_tahfidz)->num_rows();
            $data_dash['total_telat'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "T", $sesi_tahfidz)->num_rows();
            $data_dash['total_sakit'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "S", $sesi_tahfidz)->num_rows();
            $data_dash['total_ijin'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "I", $sesi_tahfidz)->num_rows();
            $data_dash['total_absen'] = $this->Tahfidz_model->get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, "A", $sesi_tahfidz)->num_rows();
            $data_dash['dashboard_absensi_tahfid_buat_waktu'] = $time_now;
            $data_dash['dashboard_absensi_tahfid_buat_oleh'] = $this->session->userdata('users_nama_lengkap');
            $this->Dashboard_model->insert_dashboard_tahfidz($data_dash);
            $this->session->set_flashdata('success_message', 'Terima kasih telah melakukan absensi pelajaran');
            redirect(site_url('dashboard'));
        }
    }

    public function setor_tahfidz()
    {
        $tahfidz_id = $this->input->post('tahfidz_id', TRUE);
        // $tahfidz_id = "nfbs-5ed9710468d27";
        $tahfidz_row = $this->Tahfidz_model->get_tahfidz_siswa_by_tahfidz_id($tahfidz_id)->row();

        if ($tahfidz_row) {
            $santri_row = $this->Tahfidz_model->get_al_quran_terakhir_setor($tahfidz_row->siswa_NIS)->row();
            // print_r($santri_row);
            if ($santri_row->tahfidz_absensi_status == "H") {
                $absensi_status = '<label  class="btn btn-sm btn-success mb3"  title="Hadir">Hadir</label>';
            } elseif ($santri_row->tahfidz_absensi_status == "T") {
                $absensi_status = '<label  class="btn btn-sm bg-navy mb3"  title="Telat">Telat</label>';
            } elseif ($santri_row->tahfidz_absensi_status == "S") {
                $absensi_status = '<label  class="btn btn-sm btn-warning mb3"  title="Sakit">Sakit</label>';
            } elseif ($santri_row->tahfidz_absensi_status == "I") {
                $absensi_status = '<label  class="btn btn-sm btn-info mb3"  title="Ijin">Ijin</label>';
            } elseif ($santri_row->tahfidz_absensi_status == "A") {
                $absensi_status = '<label  class="btn btn-sm btn-danger mb3"  title="Absen">Absen</label>';
            }

            $al_quran_id = $santri_row->al_quran_id;
            if ($al_quran_id == null) {
                $al_quran_surah = "Belum Ada Surat Yang Disetor";
            } else {
                $al_quran_surah = $santri_row->al_quran_surah;
            }

            $ayat_terakhir = $santri_row->ayat_terakhir;
            if ($ayat_terakhir < 1) {
                $ayat_terakhir = "Belum Ada Ayat Yang Disetor";
            } else {
                $ayat_terakhir = $ayat_terakhir;
            }

            $al_quran_data = $this->Al_quran_model->get_all_alquran()->result();
            $al_quran_select = '<select class="form-control" id="al_quran_id_setor" name="al_quran_id_setor"><option value="">--Pilih Surah Al Qur`an--</option>';
            foreach ($al_quran_data as $al_quran) {
                $al_quran_select .= '<option value="' . $al_quran->al_quran_id . '">' . $al_quran->al_quran_surah . ' (' . $al_quran->al_quran_arab . ')' . '</option>';
            }
            $al_quran_select .= '</select>';
            echo json_encode(array(
                "status" => TRUE,
                "tahfidz_absensi_status" => $santri_row->tahfidz_absensi_status,
                "al_quran_surah" => $al_quran_surah,
                "ayat_terakhir" => $ayat_terakhir,
                "al_quran_select" => $al_quran_select
            ));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mata_pelajaran'));
        }
    }

    public function simpan_setor_tahfidz()
    {
        $this->form_validation->set_rules('tahfidz_id', 'Pelajaran ID', 'trim');
        $this->form_validation->set_rules('al_quran_id_setor', 'Al Qur`an', 'trim|required');
        $this->form_validation->set_rules('ayat_terakhir_input', 'Ayat Terakhir Input', 'trim|required|numeric');
        $this->form_validation->set_rules('tahfidz_baris_input', 'Jumlah Baris Terakhir Input', 'trim|required|numeric');

        if ($this->form_validation->run()) {
            $data = array(
                'al_quran_id' => $this->input->post('al_quran_id_setor', true),
                'ayat_terakhir' => $this->input->post('ayat_terakhir_input', true),
                'tahfidz_baris' => ucwords($this->input->post('tahfidz_baris_input', true)),
                'tahfidz_update_waktu' => date('Y-m-d H:i:s'),
                'tahfidz_update_oleh' => $this->session->userdata('users_nama_lengkap'),
            );
            $this->Tahfidz_model->update_status_tahfidz($this->input->post('tahfidz_id', true), $data);
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
}
