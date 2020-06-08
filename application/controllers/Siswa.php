<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model');
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
            $config['base_url'] = base_url() . 'siswa?cari=' . urlencode($cari);
            $config['first_url'] = base_url() . 'siswa?cari=' . urlencode($cari);
        } else {
            $config['base_url'] = base_url() . 'siswa';
            $config['first_url'] = base_url() . 'siswa';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Siswa_model->get_total_rows_siswa($cari);
        $siswa = $this->Siswa_model->get_limit_data_siswa($config['per_page'], $start, $cari);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['menu'] = "Master";
        $data['page'] = "Daftar Siswa";
        $data['load_css_js'] = "";
        $data['siswa_data'] = $siswa->result();
        $data['cari'] = $cari;
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $start;
        $this->template->load('template/main_template', 'view_siswa_index', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('siswa/create_action'),
            'siswa_NIS' => set_value('siswa_NIS'),
            'siswa_NISN' => set_value('siswa_NISN'),
            'siswa_nama_lengkap' => set_value('siswa_nama_lengkap'),
            'kelas_id' => set_value('kelas_id'),
        );
        $this->load->view('siswa/siswa_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'siswa_NISN' => $this->input->post('siswa_NISN', TRUE),
                'siswa_nama_lengkap' => $this->input->post('siswa_nama_lengkap', TRUE),
                'kelas_id' => $this->input->post('kelas_id', TRUE),
            );

            $this->Siswa_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('siswa'));
        }
    }

    public function update($id)
    {
        $row = $this->Siswa_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('siswa/update_action'),
                'siswa_NIS' => set_value('siswa_NIS', $row->siswa_NIS),
                'siswa_NISN' => set_value('siswa_NISN', $row->siswa_NISN),
                'siswa_nama_lengkap' => set_value('siswa_nama_lengkap', $row->siswa_nama_lengkap),
                'kelas_id' => set_value('kelas_id', $row->kelas_id),
            );
            $this->load->view('siswa/siswa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('siswa_NIS', TRUE));
        } else {
            $data = array(
                'siswa_NISN' => $this->input->post('siswa_NISN', TRUE),
                'siswa_nama_lengkap' => $this->input->post('siswa_nama_lengkap', TRUE),
                'kelas_id' => $this->input->post('kelas_id', TRUE),
            );

            $this->Siswa_model->update($this->input->post('siswa_NIS', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('siswa'));
        }
    }

    public function delete($id)
    {
        $row = $this->Siswa_model->get_by_id($id);

        if ($row) {
            $this->Siswa_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('siswa'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('siswa_NISN', 'siswa nisn', 'trim|recariuired');
        $this->form_validation->set_rules('siswa_nama_lengkap', 'siswa nama lengkap', 'trim|recariuired');
        $this->form_validation->set_rules('kelas_id', 'kelas id', 'trim|recariuired');

        $this->form_validation->set_rules('siswa_NIS', 'siswa_NIS', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
