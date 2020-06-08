<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Al_quran_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_all_alquran()
    {
        $this->db->order_by('al_quran_urutan', 'ASC');
        return $this->db->get('al_quran');
    }
}
