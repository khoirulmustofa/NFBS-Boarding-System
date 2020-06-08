<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mushrif_tahfidz extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mushrif_tahfidz_model');
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
            $config['base_url'] = base_url() . 'mushrif_tahfidz?cari=' . urlencode($cari);
            $config['first_url'] = base_url() . 'mushrif_tahfidz?cari=' . urlencode($cari);
        } else {
            $config['base_url'] = base_url() . 'mushrif_tahfidz';
            $config['first_url'] = base_url() . 'mushrif_tahfidz';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Mushrif_tahfidz_model->get_total_rows_mushrif_tahfidz_user($cari);
        $mushrif_tahfidz = $this->Mushrif_tahfidz_model->get_limit_data_mushrif_tahfidz_user($config['per_page'], $start, $cari);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['menu'] = "Master";
        $data['page'] = "Daftar Mushrif Tahfidz";
        $data['load_css_js'] = "";
        $data['mushrif_tahfidz_data'] = $mushrif_tahfidz->result();
        $data['cari'] = $cari;
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $start;
        $this->template->load('template/main_template', 'view_mushrif_tahfidz_index', $data);
    }

    public function create()
    {
        $data['menu'] = "Master";
        $data['page'] = "Tambah Mushrif Tahfidz";
        $data['load_css_js'] = "";
        $data['action'] = site_url('mushrif_tahfidz/create_action');
        $data['mushrif_tahfidz_id'] = set_value('mushrif_tahfidz_id');
        $data['users_id'] = set_value('users_id');
        $data['mushrif_tahfidz_status'] = set_value('mushrif_tahfidz_status');

        $this->template->load('template/main_template', 'view_mushrif_tahfidz_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $users_id = $this->input->post('users_id', TRUE);
            $mushrif = $this->Mushrif_tahfidz_model->get_mushrif_tahfidz_user_id($users_id);
            if ($mushrif->num_rows() > 0) {
                $this->session->set_flashdata('error_message', 'Musrif Tahrif sudah Ditambahkan');
                redirect(site_url('mushrif_tahfidz'));
            } else {
                $data['mushrif_tahfidz_id'] = insert_uuid();
                $data['users_id'] = $users_id;
                $data['mushrif_tahfidz_status'] = $this->input->post('mushrif_tahfidz_status', TRUE);
                $this->Mushrif_tahfidz_model->insert_mushrif_tahfidz($data);
                $this->session->set_flashdata('success_message', 'Musrif Tahrif Berhasil Ditambahkan');
                redirect(site_url('mushrif_tahfidz'));
            }
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('users_id', 'User', 'trim|required');
        $this->form_validation->set_rules('mushrif_tahfidz_status', 'Status', 'trim|required');

        $this->form_validation->set_rules('mushrif_tahfidz_id', 'mushrif_tahfidz_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
