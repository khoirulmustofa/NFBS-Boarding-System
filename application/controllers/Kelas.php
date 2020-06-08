<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kelas_model');
        is_login();
        $hak_akses = $this->router->fetch_class() . "_" . $this->router->fetch_method();
        if (have_access($hak_akses) == 'N') {            
            $this->load->view('view_blok_index');           
        }
    }
    
}
