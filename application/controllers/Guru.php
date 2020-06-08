<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Guru extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_model');
        $this->load->model('Users_model');
        is_login();
        $hak_akses = $this->router->fetch_class() . "_" . $this->router->fetch_method();
        if (have_access($hak_akses) == 'N') {            
            $this->load->view('view_blok_index');           
        }
    }

    public function index()
    {
        $cari = urldecode($this->input->get('cari', TRUE));
        $start = intval($this->input->get('start'));

        if ($cari <> '') {
            $config['base_url'] = base_url() . 'guru?cari=' . urlencode($cari);
            $config['first_url'] = base_url() . 'guru?cari=' . urlencode($cari);
        } else {
            $config['base_url'] = base_url() . 'guru';
            $config['first_url'] = base_url() . 'guru';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Guru_model->get_total_rows_guru($cari);
        $guru = $this->Guru_model->get_limit_data_guru($config['per_page'], $start, $cari);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['menu'] = "Master";
        $data['page'] = "Daftar Guru";
        $data['load_css_js'] = "";
        $data['guru_data'] = $guru->result();
        $data['cari'] = $cari;
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $start;

        $this->template->load('template/main_template', 'view_guru_index', $data);
    }

    public function create()
    {
        $data['menu'] = "Master";
        $data['page'] = "Tambah Guru";
        $data['load_css_js'] = "";
        $data['action'] = site_url('guru/create_action');
        $data['guru_id'] = set_value('guru_id');
        $data['NIP'] = set_value('NIP');
        $data['users_id'] = set_value('users_id');
        $data['users_sata'] = $this->Users_model->get_get_users_all()->result();
        $data['guru_status'] = set_value('guru_status');
        $this->template->load('template/main_template', 'view_guru_form', $data);
    }

    public function create_action()
    {
        $this->form_validation->set_rules('NIP', 'NIP', 'trim|required');
        $this->form_validation->set_rules('users_id', 'Pengguna', 'trim|required');
        $this->form_validation->set_rules('guru_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('guru_id', 'guru_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $users_id = $this->input->post('users_id', TRUE);
            $guru_row = $this->Guru_model->get_guru_user_id($users_id)->row();
            if ($guru_row) {
                $this->session->set_flashdata('error_message', 'Data Pengguna Sudah Ditambahkan Dalam Data Guru');
                redirect(site_url('guru'));
            } else {
                $data = array(
                    'guru_id' => insert_uuid(),
                    'NIP' => $this->input->post('NIP', TRUE),
                    'users_id' => $users_id,
                    'guru_status' => $this->input->post('guru_status', TRUE),
                );
                $this->Guru_model->insert_guru($data);
                $this->session->set_flashdata('success_message', 'Data Guru Berhasil Ditambah');
                redirect(site_url('guru'));
            }
        }
    }

    public function update($id)
    {
        $row = $this->Guru_model->get_guru_by_id($id)->row();

        if ($row) {
            $data['menu'] = "Mater";
            $data['page'] = "Update Guru";
            $data['load_css_js'] = "";
            $data['action'] = site_url('guru/update_action');
            $data['guru_id'] = set_value('guru_id', $row->guru_id);
            $data['NIP'] = set_value('NIP', $row->NIP);
            $data['users_id'] = set_value('users_id', $row->users_id);
            $data['guru_status'] = set_value('guru_status', $row->guru_status);

            $this->template->load('template/main_template', 'view_Guru_form', $data);
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih Tidak Ada Dalam Sistem');
            redirect(site_url('guru'));
        }
    }

    public function update_action()
    {
        $this->form_validation->set_rules('NIP', 'nip', 'trim|required');
        $this->form_validation->set_rules('users_id', 'users id', 'trim|required');
        $this->form_validation->set_rules('guru_status', 'guru status', 'trim|required');
        $this->form_validation->set_rules('guru_id', 'guru_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('guru_id', TRUE));
        } else {
            // $users_id = $this->input->post('users_id', TRUE);
            $guru_id = $this->input->post('guru_id', TRUE);
            // $guru_row = $this->Guru_model->get_guru_user_id_guru_id($users_id, $guru_id)->row();
            // if ($guru_row) {
            //     $this->session->set_flashdata('error_message', 'Data Pengguna Sudah Ditambahkan Dalam Data Guru');
            //     redirect(site_url('guru'));
            // } else {
            $data = array(
                'NIP' => $this->input->post('NIP', TRUE),
                'guru_status' => $this->input->post('guru_status', TRUE),
            );
            $this->Guru_model->update_guru($guru_id, $data);
            $this->session->set_flashdata('success_message', 'Data Guru Berhasil Diupdate');
            redirect(site_url('guru'));
            // }
        }
    }

    public function mapel_kelas($guru_id)
    {
        $row = $this->Guru_model->get_guru_by_id($guru_id)->row();

        if ($row) {
            $user_row = $this->Guru_model->get_users_by_guru($row->guru_id)->row();
            $data['menu'] = "Mater";
            $data['page'] = "Mata Pelajaran dan Kelas Guru " . $user_row->users_nama_lengkap;
            $data['load_css_js'] = "";
            $data['action'] = site_url('guru/mapel_kelas_action');
            $data['guru_id'] = $row->guru_id;
            $data['mata_pelajaran_id'] = set_value('mata_pelajaran_id');
            $data['kelas_id'] = set_value('kelas_id');
            $data['mape_kelas_data'] = $this->Guru_model->get_mapel_kelas_guru($row->guru_id)->result();

            $this->template->load('template/main_template', 'view_guru_mapel_kelas', $data);
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih Tidak Ada Dalam Sistem');
            redirect(site_url('guru'));
        }
    }

    public function mapel_kelas_action()
    {
        $this->form_validation->set_rules('mata_pelajaran_id', 'Mata pelajaran', 'trim|required');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'trim|required');

        $this->form_validation->set_rules('guru_id', 'guru_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->mapel_kelas($this->input->post('guru_id', TRUE));
        } else {
            $mata_pelajaran_id = $this->input->post('mata_pelajaran_id', TRUE);
            $kelas_id = $this->input->post('kelas_id', TRUE);
            $guru_id = $this->input->post('guru_id', TRUE);
            $mata_pelajaran_guru_kelas = $this->Guru_model->get_check_mata_pelajaran_guru_kelas($mata_pelajaran_id, $kelas_id, $guru_id);
            if ($mata_pelajaran_guru_kelas->num_rows() > 0) {
                $this->session->set_flashdata('error_message', 'Mata Pelajaran Dan Kelas Sudah Ditambahkan');
                redirect(site_url('guru/mapel_kelas/' . $guru_id));
            } else {
                $data = array(
                    'mata_pelajaran_guru_kelas_id' => insert_uuid(),
                    'mata_pelajaran_id' => $mata_pelajaran_id,
                    'kelas_id' => $kelas_id,
                    'guru_id' => $guru_id,
                    'mata_pelajaran_guru_kelas_status' => 'Y',
                );

                $this->Guru_model->insert_mapel_kelas_guru($data);
                $this->session->set_flashdata('success_message', 'Mata Pelajaran Kelas Berhasil Ditambah');
                redirect(site_url('guru/mapel_kelas/' . $guru_id));
            }
        }
    }

    // public function delete($id)
    // {
    //     $row = $this->Guru_model->get_Guru_by_id($id)->row();

    //     if ($row) {
    //         $this->Guru_model->delete_Guru($id);
    //         $this->session->set_flashdata('success_message', 'Data Guru Berhasil Dihapus');
    //         redirect(site_url('guru'));
    //     } else {
    //         $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih Tidak Ada Dalam Sistem');
    //         redirect(site_url('guru'));
    //     }
    // }
}
