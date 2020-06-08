<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hak_akses extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Hak_akses_model');
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
            $config['base_url'] = base_url() . 'hak_akses?cari=' . urlencode($cari);
            $config['first_url'] = base_url() . 'hak_akses?cari=' . urlencode($cari);
        } else {
            $config['base_url'] = base_url() . 'hak_akses';
            $config['first_url'] = base_url() . 'hak_akses';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Hak_akses_model->total_hak_akses_rows($cari);
        $hak_akses = $this->Hak_akses_model->get_hak_akses_limit_data($config['per_page'], $start, $cari)->result();

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['menu'] = "Master";
        $data['page'] = "Daftar Hak Akses";
        $data['load_css_js'] = "";
        $data['cari'] = $cari;
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $start;
        $data['hak_akses_data'] = $hak_akses;

        $this->template->load('template/main_template', 'view_hak_akses_index', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('auth_hak_akses/create_action'),
            'hak_akses_id' => set_value('hak_akses_id'),
            'hak_akses_nama' => set_value('hak_akses_nama'),
            'hak_akses_keterangan' => set_value('hak_akses_keterangan'),
        );

        $data['menu'] = "Master";
        $data['page'] = "Tambah Hak Akses";
        $data['load_css_js'] = "";
        $data['action'] = site_url('hak_akses/create_action');
        $data['hak_akses_id'] = set_value('hak_akses_id');
        $data['hak_akses_nama'] = set_value('hak_akses_nama');
        $data['hak_akses_keterangan'] = set_value('hak_akses_keterangan');

        $this->template->load('template/main_template', 'view_hak_akses_form', $data);
    }

    public function create_action()
    {
        $this->form_validation->set_rules('hak_akses_nama', 'hak akses nama', 'trim|required');
        $this->form_validation->set_rules('hak_akses_keterangan', 'hak akses keterangan', 'trim|required');
        $this->form_validation->set_rules('hak_akses_id', 'hak_akses_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $hak_akses_nama = strtolower(trim($this->input->post('hak_akses_nama', TRUE)));
            $hak_akses = $this->Hak_akses_model->get_hak_akses_by_nama($hak_akses_nama);
            if ($hak_akses->num_rows() > 0) {
                $this->session->set_flashdata('error_message', 'Hak Akses Dengan Nama Tersebut Sudah Ada ');
                redirect(site_url('hak_akses'));
            } else {
                $data = array(
                    'hak_akses_id' => insert_uuid(),
                    'hak_akses_nama' => $hak_akses_nama,
                    'hak_akses_keterangan' => ucwords(strtolower(str_replace('_', ' ', $this->input->post('hak_akses_keterangan', TRUE)))),
                );
                $this->Hak_akses_model->insert_hak_akses($data);
                $this->session->set_flashdata('success_message', 'Hak Akses berhasil Ditambahkan');
                redirect(site_url('hak_akses'));
            }
        }
    }

    public function update($id)
    {
        $row = $this->Hak_akses_model->get_hak_akses_by_id($id)->row();

        if ($row) {
            $data = array(
                'menu' => "Master",
                'page' => "Update Hak Akses",
                'load_css_js' => "",
                'action' => site_url('hak_akses/update_action'),
                'hak_akses_id' => set_value('hak_akses_id', $row->hak_akses_id),
                'hak_akses_nama' => set_value('hak_akses_nama', $row->hak_akses_nama),
                'hak_akses_keterangan' => set_value('hak_akses_keterangan', $row->hak_akses_keterangan),
            );
            $this->template->load('template/main_template', 'view_hak_akses_form', $data);
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('hak_akses'));
        }
    }

    public function update_action()
    {
        $this->form_validation->set_rules('hak_akses_nama', 'hak akses nama', 'trim|required');
        $this->form_validation->set_rules('hak_akses_keterangan', 'hak akses keterangan', 'trim|required');
        $this->form_validation->set_rules('hak_akses_id', 'hak_akses_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('hak_akses_id', TRUE));
        } else {
            $data = array(
                'hak_akses_nama' => $this->input->post('hak_akses_nama', TRUE),
                'hak_akses_keterangan' => ucwords(strtolower(str_replace('_', ' ', $this->input->post('hak_akses_keterangan', TRUE)))),
            );

            $this->Hak_akses_model->update_hak_akses($this->input->post('hak_akses_id', TRUE), $data);
            $this->session->set_flashdata('success_message', 'Update Data Hak Akses Berhasil');
            redirect(site_url('hak_akses'));
        }
    }

    public function delete($id)
    {
        $row = $this->Hak_akses_model->get_hak_akses_by_id($id)->row();

        if ($row) {
            $this->Hak_akses_model->delete_hak_akses($id);
            $this->session->set_flashdata('success_message', 'Hapus Data Hak Akses Berhasil');
            redirect(site_url('hak_akses'));
        } else {
            $this->session->set_flashdata('error_message', 'Maaf Data Yang Anda Pilih TIdak Ada Dalam Sistem');
            redirect(site_url('hak_akses'));
        }
    }
}
