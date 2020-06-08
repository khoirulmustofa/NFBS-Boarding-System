<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome_model extends CI_Model
{

    public $table = 'mata_pelajaran';
    public $id = 'guru_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
}