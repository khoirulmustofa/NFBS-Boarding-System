<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mata_pelajaran_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_total_rows_mata_pelajaran($cari)
    {
        $this->db->like('mata_pelajaran_kode', $cari);
        $this->db->or_like('mata_pelajaran_nama', $cari);
        $this->db->from('mata_pelajaran');
        return $this->db->count_all_results();
    }

    public function get_limit_data_mata_pelajaran($limit, $start = 0, $cari = NULL)
    {
        $this->db->order_by('mata_pelajaran_nama', 'ASC');
        $this->db->like('mata_pelajaran_kode', $cari);
        $this->db->or_like('mata_pelajaran_nama', $cari);
        $this->db->limit($limit, $start);
        return $this->db->get('mata_pelajaran');
    }

    function get_mata_pelajaran_by_id($id)
    {
        $this->db->where('mata_pelajaran_kode', $id);
        return $this->db->get('mata_pelajaran');
    }

    function insert_mata_pelajaran($data)
    {
        $this->db->insert('mata_pelajaran', $data);
    }

    function update_mata_pelajaran($id, $data)
    {
        $this->db->where('mata_pelajaran_kode', $id);
        $this->db->update('mata_pelajaran', $data);
    }

    function delete_mata_pelajaran($id)
    {
        $this->db->where('mata_pelajaran_kode', $id);
        $this->db->delete('mata_pelajaran');
    }    
    
}
