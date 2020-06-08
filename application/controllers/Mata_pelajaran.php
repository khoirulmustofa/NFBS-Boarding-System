<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mata_pelajaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mata_pelajaran_model');
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
            $config['base_url'] = base_url() . 'mata_pelajaran?cari=' . urlencode($cari);
            $config['first_url'] = base_url() . 'mata_pelajaran?cari=' . urlencode($cari);
        } else {
            $config['base_url'] = base_url() . 'mata_pelajaran';
            $config['first_url'] = base_url() . 'mata_pelajaran';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Mata_pelajaran_model->get_total_rows_mata_pelajaran($cari);
        $mata_pelajaran = $this->Mata_pelajaran_model->get_limit_data_mata_pelajaran($config['per_page'], $start, $cari);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['menu'] = "Mata Pelajaran";
        $data['page'] = "Daftar Mata Pelajaran";
        $data['load_css_js'] = "";
        $data['mata_pelajaran_data'] = $mata_pelajaran->result();
        $data['cari'] = $cari;
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $start;

        $this->template->load('template/main_template', 'view_mata_pelajaran_index', $data);
    }

    public function create()
    {
        $data['menu'] = "Mata Pelajaran";
        $data['page'] = "Tambah Mata Pelajaran";
        $data['load_css_js'] = "";
        $data['action'] = site_url('mata_pelajaran/create_action');
        $data['mata_pelajaran_kode'] = set_value('mata_pelajaran_kode');
        $data['mata_pelajaran_nama'] = set_value('mata_pelajaran_nama');
        $this->template->load('template/main_template', 'view_mata_pelajaran_form', $data);
    }

    public function create_action()
    {
        $this->form_validation->set_rules('mata_pelajaran_nama', 'Nama Mata Pelajaran', 'trim|required');
        $this->form_validation->set_rules('mata_pelajaran_kode', 'Kode Mata Pelajaran', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'mata_pelajaran_kode' => $this->input->post('mata_pelajaran_kode', TRUE),
                'mata_pelajaran_nama' => $this->input->post('mata_pelajaran_nama', TRUE),
            );

            $this->Mata_pelajaran_model->insert_mata_pelajaran($data);
            $this->session->set_flashdata('success_message', 'Menambah Mata Pelajaran Berhasil');
            redirect(site_url('mata_pelajaran'));
        }
    }

    public function update($id)
    {
        $row = $this->Mata_pelajaran_model->get_mata_pelajaran_by_id($id)->row();

        if ($row) {
            $data['menu'] = "Mata Pelajaran";
            $data['page'] = "Tambah Mata Pelajaran";
            $data['load_css_js'] = "";
            $data['action'] = site_url('mata_pelajaran/update_action');
            $data['mata_pelajaran_kode'] = set_value('mata_pelajaran_kode', $row->mata_pelajaran_kode);
            $data['mata_pelajaran_nama'] = set_value('mata_pelajaran_kode', $row->mata_pelajaran_nama);

            $this->template->load('template/main_template', 'view_mata_pelajaran_form', $data);
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('mata_pelajaran'));
        }
    }

    public function update_action()
    {
        $this->form_validation->set_rules('mata_pelajaran_nama', 'Nama Mata Pelajaran', 'trim|required');
        $this->form_validation->set_rules('mata_pelajaran_kode', 'Kode Mata Pelajaran', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('mata_pelajaran_kode', TRUE));
        } else {
            $data = array(
                'mata_pelajaran_kode' => $this->input->post('mata_pelajaran_kode', TRUE),
                'mata_pelajaran_nama' => $this->input->post('mata_pelajaran_nama', TRUE),
            );

            $this->Mata_pelajaran_model->update_mata_pelajaran($this->input->post('mata_pelajaran_kode', TRUE), $data);
            $this->session->set_flashdata('success_message', 'Mengupdate Mata Pelajaran Berhasil');
            redirect(site_url('mata_pelajaran'));
        }
    }

    public function delete($id) 
    {
        $row = $this->Mata_pelajaran_model->get_mata_pelajaran_by_id($id)->row();

        if ($row) {
            $this->Mata_pelajaran_model->delete_mata_pelajaran($id);
            $this->session->set_flashdata('success_message', 'Menghapus Mata Pelajaran Berhasil');
            redirect(site_url('mata_pelajaran'));
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('mata_pelajaran'));
        }
    }
}
