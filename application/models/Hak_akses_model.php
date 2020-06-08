<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hak_akses_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_all_hak_akses()
    {
        $this->db->order_by('hak_akses_nama', 'ASC');
        return $this->db->get('auth_hak_akses');
    }

    function get_hak_akses_user_hak_akses($hak_akses_id, $users_id)
    {
        $this->db->where('hak_akses_id', $hak_akses_id);
        $this->db->where('users_id', $users_id);
        return $this->db->get('auth_users_hak_akses');
    }

    function get_hak_akses_users_id($users_id)
    {
        $this->db->select('auth_users_hak_akses.users_hak_akses_id,auth_hak_akses.hak_akses_id');
        $this->db->select('auth_hak_akses.hak_akses_nama,auth_hak_akses.hak_akses_keterangan');
        $this->db->from('auth_users_hak_akses');
        $this->db->join('auth_hak_akses', 'auth_hak_akses.hak_akses_id = auth_users_hak_akses.hak_akses_id');
        $this->db->where('auth_users_hak_akses.users_id', $users_id);
        $this->db->order_by('auth_hak_akses.hak_akses_nama', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    function total_hak_akses_rows($cari = NULL)
    {
        $this->db->like('hak_akses_nama', $cari);
        $this->db->from('auth_hak_akses');
        return $this->db->count_all_results();
    }

    function get_hak_akses_limit_data($limit, $start = 0, $cari = NULL)
    {
        $this->db->order_by('hak_akses_nama', 'ASC');
        $this->db->like('hak_akses_nama', $cari);
        $this->db->limit($limit, $start);
        return $this->db->get('auth_hak_akses');
    }


    function get_hak_akses_users($users_hak_akses_id)
    {
        $this->db->where('users_hak_akses_id', $users_hak_akses_id);
        return $this->db->get('auth_users_hak_akses');
    }

    function get_hak_akses_by_id($hak_akses_id)
    {
        $this->db->where('hak_akses_id', $hak_akses_id);
        return $this->db->get('auth_hak_akses');
    }

    function insert_hak_akses($data)
    {
        $this->db->insert('auth_hak_akses', $data);
    }

    function update_hak_akses($id, $data)
    {
        $this->db->where('hak_akses_id', $id);
        $this->db->update('auth_hak_akses', $data);
    }

    function delete_hak_akses($hak_akses_id)
    {
        $this->db->where('hak_akses_id', $hak_akses_id);
        $this->db->delete('auth_hak_akses');
    }

    function delete_hak_akses_user($users_hak_akses_id)
    {
        $this->db->where('users_hak_akses_id', $users_hak_akses_id);
        $this->db->delete('auth_users_hak_akses');
    }

    function insert_hak_akses_users($data)
    {
        $this->db->insert('auth_users_hak_akses', $data);
    }

    function get_hak_akses_by_nama($hak_akses_nama){
        $this->db->where('hak_akses_nama', $hak_akses_nama);
        return $this->db->get('auth_hak_akses');
    }
}
