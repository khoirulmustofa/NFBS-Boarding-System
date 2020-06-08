<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Level_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_all_level()
    {
        $this->db->order_by('level_nama', 'ASC');
        return $this->db->get('auth_level');
    }

    public function get_total_rows_level($cari)
    {
        $this->db->like('level_nama', $cari);
        $this->db->from('auth_level');
        return $this->db->count_all_results();
    }

    public function get_limit_data_level($limit, $start = 0, $cari = NULL)
    {
        $this->db->order_by('level_nama', 'ASC');
        $this->db->like('level_nama', $cari);
        $this->db->limit($limit, $start);
        return $this->db->get('auth_level');
    }

    function get_level_by_id($id)
    {
        $this->db->where('level_id', $id);
        return $this->db->get('auth_level');
    }

    function insert_level($data)
    {
        $this->db->insert('auth_level', $data);
    }

    function update_level($id, $data)
    {
        $this->db->where('level_id', $id);
        $this->db->update('auth_level', $data);
    }

    function delete_level($id)
    {
        $this->db->where('level_id', $id);
        $this->db->delete('auth_level');
    }
}
