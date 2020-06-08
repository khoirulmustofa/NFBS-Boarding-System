<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Hak_akses_model');
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
            $config['base_url'] = base_url() . 'users?cari=' . urlencode($cari);
            $config['first_url'] = base_url() . 'users?cari=' . urlencode($cari);
        } else {
            $config['base_url'] = base_url() . 'users';
            $config['first_url'] = base_url() . 'users';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Users_model->get_total_rows_users($cari);
        $users = $this->Users_model->get_limit_data_users($config['per_page'], $start, $cari);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['menu'] = "Master";
        $data['page'] = "Daftar Pengguna";
        $data['load_css_js'] = "";
        $data['users_data'] = $users->result();
        $data['cari'] = $cari;
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $start;

        $this->template->load('template/main_template', 'view_users_index', $data);
    }

    public function create()
    {
        $data['menu'] = "Master";
        $data['page'] = "Tambah users";
        $data['load_css_js'] = "";
        $data['action'] = site_url('users/create_action');
        $data['users_id'] = set_value('users_id');
        $data['users_email'] = set_value('users_email');
        $data['users_nama_lengkap'] = set_value('users_nama_lengkap');
        $data['users_status'] = set_value('users_status');
        $this->template->load('template/main_template', 'view_users_form', $data);
    }

    public function create_action()
    {
        $this->form_validation->set_rules('users_email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('users_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('ulangi_users_password', 'Verifikasi Password', 'trim|required|matches[users_password]');
        $this->form_validation->set_rules('users_nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('users_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('users_id', 'users_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $password = $this->input->post('users_password', TRUE);
            $options = array("cost" => 10);
            $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);

            $data['users_id'] = insert_uuid();
            $data['users_email'] = $this->input->post('users_email', TRUE);
            $data['users_password'] = $hashPassword;
            $data['users_nama_lengkap'] = $this->input->post('users_nama_lengkap', TRUE);
            $data['users_status'] = $this->input->post('users_status', TRUE);
            $data['users_update_waktu'] = date('Y-m-d H:i:s');

            $this->Users_model->insert_users($data);
            $this->session->set_flashdata('success_message', 'Data Pengguna Berhasil Ditambah');
            redirect(site_url('users'));
        }
    }

    public function update($id)
    {
        $row = $this->Users_model->get_users_by_users_id($id)->row();

        if ($row) {
            $data['menu'] = "Master";
            $data['page'] = "Edit Pengguna";
            $data['load_css_js'] = "";
            $data['action'] = site_url('users/update_action');
            $data['users_id'] = set_value('users_id', $row->users_id);
            $data['users_email'] = set_value('users_email', $row->users_email);
            $data['users_nama_lengkap'] = set_value('users_nama_lengkap', $row->users_nama_lengkap);
            $data['users_status'] = set_value('users_status', $row->users_status);

            $this->template->load('template/main_template', 'view_users_form', $data);
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('users'));
        }
    }

    public function update_action()
    {
        $this->form_validation->set_rules('users_email', 'Email', 'trim|required|valid_email');
        if ($this->input->post('users_password', TRUE)) {
            $this->form_validation->set_rules('users_password', 'Password', 'trim|required');
            $this->form_validation->set_rules('ulangi_users_password', 'Verifikasi Password', 'trim|required|matches[users_password]');
        }
        $this->form_validation->set_rules('users_nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('users_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('users_id', 'users_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('users_id', TRUE));
        } else {
            $data['users_email'] = $this->input->post('users_email', TRUE);
            if ($this->input->post('users_password', TRUE)) {
                $data['users_password'] = $this->input->post('users_password', TRUE);
            }
            $data['users_nama_lengkap'] = $this->input->post('users_nama_lengkap', TRUE);
            $data['users_status'] = $this->input->post('users_status', TRUE);
            $data['users_update_waktu'] = date('Y-m-d H:i:s');

            $this->Users_model->update_users($this->input->post('users_id', TRUE), $data);
            $this->session->set_flashdata('success_message', 'Data Pengguna Berhasil Diupdate');
            redirect(site_url('users'));
        }
    }

    public function hak_akses($id)
    {
        $row = $this->Users_model->get_users_by_users_id($id)->row();

        if ($row) {
            $data['menu'] = "Master";
            $data['page'] = "Edit Hak Akses Pengguna : " . $row->users_nama_lengkap;
            $data['load_css_js'] = "";
            $data['action'] = site_url('users/tambah_hak_akses');
            $data['users_id'] = set_value('users_id', $row->users_id);
            $data['hak_akses_data'] = $this->Hak_akses_model->get_all_hak_akses()->result();
            $data['hak_akses_users_id_data'] = $this->Hak_akses_model->get_hak_akses_users_id($row->users_id)->result();
            $this->template->load('template/main_template', 'view_users_hak_akses', $data);
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('users'));
        }
    }

    public function tambah_hak_akses()
    {
        $this->form_validation->set_rules('hak_akses_id', 'Hal Akses', 'trim|required');
        $this->form_validation->set_rules('users_id', 'users_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->hak_akses($this->input->post('users_id', TRUE));
        } else {
            $hak_akses_id = $this->input->post('hak_akses_id', TRUE);
            $users_id = $this->input->post('users_id', TRUE);
            $row_hak_akses = $this->Hak_akses_model->get_hak_akses_user_hak_akses($hak_akses_id, $users_id)->row();

            if ($row_hak_akses) {
                $this->session->set_flashdata('error_message', 'Data Hak Akses Pengguna Sudah Ada');
                redirect(site_url('users/hak_akses/' . $users_id));
            } else {
                $data['users_hak_akses_id'] = insert_uuid();
                $data['users_id'] = $users_id;
                $data['hak_akses_id'] = $this->input->post('hak_akses_id', TRUE);
                $this->Hak_akses_model->insert_hak_akses_users($data);
                $this->session->set_flashdata('success_message', 'Hak Akses Berhasil Ditambahkan');
                redirect(site_url('users/hak_akses/' . $users_id));
            }
        }
    }

    public function hapus_hak_akses($id)
    {
        $row = $this->Hak_akses_model->get_hak_akses_users($id)->row();

        if ($row) {
            $this->Hak_akses_model->delete_hak_akses_user($id);
            $this->session->set_flashdata('success_message', 'Data Hak Akses Pengguna Berhasil Dihapus');
            redirect(site_url('users/hak_akses/' . $row->users_id));
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('users/hak_akses/' . $row->users_id));
        }
    }

    public function delete($id)
    {
        $row = $this->Users_model->get_users_by_users_id($id)->row();

        if ($row) {
            $this->Users_model->delete_users($id);
            $this->session->set_flashdata('success_message', 'Data Pengguna Berhasil Dihapus');
            redirect(site_url('users'));
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('users'));
        }
    }
}
