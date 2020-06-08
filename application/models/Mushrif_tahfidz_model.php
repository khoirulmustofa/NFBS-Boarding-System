<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mushrif_tahfidz_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_mushrif_tahfidz_user_users_id($users_id)
    {
        $this->db->select('*');
        $this->db->from('mushrif_tahfidz');
        $this->db->join('auth_users', 'auth_users.users_id = mushrif_tahfidz.users_id');
        $this->db->where('mushrif_tahfidz.users_id', $users_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_total_rows_mushrif_tahfidz_user($cari = null)
    {
        $this->db->from('mushrif_tahfidz');
        $this->db->join('auth_users', 'auth_users.users_id = mushrif_tahfidz.users_id');
        $this->db->like('auth_users.users_nama_lengkap', $cari);
        $this->db->or_like('mushrif_tahfidz.mushrif_tahfidz_status', $cari);
        return $this->db->count_all_results();
    }

    public function get_limit_data_mushrif_tahfidz_user($limit, $start = 0, $cari = NULL)
    {
        $this->db->select('*');
        $this->db->from('mushrif_tahfidz');
        $this->db->join('auth_users', 'auth_users.users_id = mushrif_tahfidz.users_id');
        $this->db->like('auth_users.users_nama_lengkap', $cari);
        $this->db->or_like('mushrif_tahfidz.mushrif_tahfidz_status', $cari);
        $this->db->limit($limit, $start);
        $query= $this->db->get();
        return $query;
    }

    function get_mushrif_tahfidz_user_id($users_id)
    {
        $this->db->where('users_id', $users_id);
        $query = $this->db->get('mushrif_tahfidz');
        return $query;
    }

    function insert_mushrif_tahfidz($data)
    {
        $this->db->insert('mushrif_tahfidz', $data);
    }

}
