<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Dashboard_model');
        is_login();
        $hak_akses = $this->router->fetch_class() . "_" . $this->router->fetch_method();
        if (have_access($hak_akses) == 'N') {            
            $this->load->view('view_blok_index');           
        }   
    }

    public function index()
    {
        $date_now = date('Y-m-d');
        // kelas  1  7A 
        $kelas_7a = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a97e064', $date_now)->result();
        $kelas_7b = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a96dcd1', $date_now)->result();
        $kelas_7c = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a963398', $date_now)->result();
        $kelas_7d = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a95f871', $date_now)->result();
        $kelas_8a = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a9513d9', $date_now)->result();
        $kelas_8b = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a949202', $date_now)->result();
        $kelas_8c = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a944afa', $date_now)->result();
        $kelas_8d = $this->Dashboard_model->get_dash_absensi_pelajaran_perkelas('nfbs-5ecf85a940fae', $date_now)->result();

        $data['menu'] = "Dashboard";
        $data['page'] = "Dashboard";
        $data['load_css_js'] = "dashboard_index";
        $data['data_kelas_7a'] = $kelas_7a;
        $data['data_kelas_7b'] = json_encode($kelas_7b);
        $data['data_kelas_7c'] = json_encode($kelas_7c);
        $data['data_kelas_7d'] = json_encode($kelas_7d);
        $data['data_kelas_8a'] = json_encode($kelas_8a);
        $data['data_kelas_8b'] = json_encode($kelas_8b);
        $data['data_kelas_8c'] = json_encode($kelas_8c);
        $data['data_kelas_8d'] = json_encode($kelas_8d);

        $this->template->load('template/main_template', 'view_dashboard_index', $data);
    }

    public function cek_fungsi()
    {
        $controler = $this->router->fetch_class();
        $fungsi = $this->router->fetch_method();
        $hak_akses = $controler . '_' . $fungsi;
        print_r($hak_akses);
        exit();
    }
}
