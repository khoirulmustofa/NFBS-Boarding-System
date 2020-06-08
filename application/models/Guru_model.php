<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Guru_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_total_rows_guru($cari)
    {
        $this->db->select('guru.users_id,guru.guru_status,guru.NIP');
        $this->db->select('users.users_nama_lengkap');
        $this->db->from('guru');
        $this->db->join('auth_users', 'auth_users.users_id = guru.users_id');
        $this->db->like('auth_users.users_nama_lengkap', $cari);
        return $this->db->count_all_results();
    }

    public function get_limit_data_guru($limit, $start = 0, $cari = NULL)
    {

        $this->db->select('guru.users_id,guru.guru_status,guru.NIP');
        $this->db->select('guru.guru_id,auth_users.users_nama_lengkap');
        $this->db->from('guru');
        $this->db->join('auth_users', 'auth_users.users_id = guru.users_id');
        $this->db->order_by('auth_users.users_nama_lengkap', 'ASC');
        $this->db->like('auth_users.users_nama_lengkap', $cari);
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query;
    }

    function get_guru_by_id($id)
    {
        $this->db->where('guru_id', $id);
        return $this->db->get('guru');
    }

    function get_guru_user_id_guru_id($users_id, $guru_id)
    {
        $this->db->where('guru_id', $guru_id);
        $this->db->where('users_id', $users_id);
        return $this->db->get('guru');
    }

    function insert_guru($data)
    {
        $this->db->insert('guru', $data);
    }


    function update_guru($id, $data)
    {
        $this->db->where('guru_id', $id);
        $this->db->update('guru', $data);
    }

    function delete_guru($id)
    {
        $this->db->where('guru_id', $id);
        $this->db->delete('guru');
    }

    function get_guru_user_id($users_id)
    {
        $this->db->where('users_id', $users_id);
        return $this->db->get('guru');
    }

    function get_mapel_kelas_guru($guru_id)
    {
        $this->db->select('mata_pelajaran_guru_kelas.mata_pelajaran_guru_kelas_id,mata_pelajaran_guru_kelas.mata_pelajaran_id,mata_pelajaran_guru_kelas.kelas_id,mata_pelajaran_guru_kelas.mata_pelajaran_guru_kelas_status');
        $this->db->select('kelas.kelas_nama');
        $this->db->select('mata_pelajaran.mata_pelajaran_kode,mata_pelajaran.mata_pelajaran_nama');
        $this->db->from('mata_pelajaran_guru_kelas');
        $this->db->join('kelas', 'kelas.kelas_id = mata_pelajaran_guru_kelas.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.mata_pelajaran_id = mata_pelajaran_guru_kelas.mata_pelajaran_id');
        $this->db->where('mata_pelajaran_guru_kelas.guru_id', $guru_id);
        $query = $this->db->get();
        return $query;
    }

    function get_users_by_guru($guru_id)
    {
        $this->db->select('guru.guru_id,auth_users.users_nama_lengkap');
        $this->db->from('guru');
        $this->db->join('auth_users', 'auth_users.users_id = guru.users_id');
        $this->db->where('guru.guru_id', $guru_id);
        $query = $this->db->get();
        return $query;
    }

    public function insert_mapel_kelas_guru($data)
    {
        $this->db->insert('mata_pelajaran_guru_kelas', $data);
    }

    public function get_check_mata_pelajaran_guru_kelas($mata_pelajaran_id, $kelas_id, $guru_id)
    {
        $this->db->where('mata_pelajaran_id', $mata_pelajaran_id);
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('guru_id', $guru_id);
        return $this->db->get('mata_pelajaran_guru_kelas');
    }
    
}
