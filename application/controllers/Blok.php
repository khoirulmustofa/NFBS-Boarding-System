<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blok extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['menu'] = "Blok";
        $data['page'] = "Error 404";

        $this->load->view('view_blok_index', $data);
    }
}
