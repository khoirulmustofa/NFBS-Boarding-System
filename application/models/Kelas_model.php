<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelas_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_kelas($data)
    {
        $this->db->insert('kelas', $data);
    }

}