<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_get_users_all()
    {
        $this->db->order_by('users_nama_lengkap', 'ASC');
        return $this->db->get('auth_users');
    }

    function get_all_users()
    {
        $this->db->order_by('users_id', 'ASC');
        return $this->db->get('auth_users');
    }

    function get_users_by_users_cookie($users_cookie)
    {
        $this->db->select('*');
        $this->db->from('auth_users');
        $this->db->where('users_cookie', $users_cookie);
        $query = $this->db->get(); 
        // $this->db->get();
        // $query = $this->db->last_query();       
        return $query;
    }

    function login($users_email)
    {
        $this->db->select('*');
        $this->db->from('auth_users');
        $this->db->where('users_email', $users_email);
        $query = $this->db->get();      
        return $query;
    }

    function update_users($users_id, $data)
    {
        $this->db->where('users_id', $users_id);
        $this->db->update('auth_users', $data);
    }
    
    function insert_users($data)
    {
        $this->db->insert('auth_users', $data);
    }

    function delete_users($id)
    {
        $this->db->where('users_id', $id);
        $this->db->delete('auth_users');
    }

    function get_total_rows_users($cari = NULL)
    {        
        $this->db->from('auth_users');        
        $this->db->like('users_email', $cari);
        $this->db->or_like('users_nama_lengkap', $cari);
        return $this->db->count_all_results();
    }

    function get_limit_data_users($limit, $start = 0, $cari = NULL)
    {
        $this->db->select('*');
        $this->db->from('auth_users');        
        $this->db->like('users_email', $cari);
        $this->db->or_like('users_nama_lengkap', $cari);
        $this->db->order_by('users_nama_lengkap', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query;
    }

    function get_users_by_users_id($users_id)
    {
        $this->db->where('users_id', $users_id);
        return $this->db->get('auth_users');
    }    

}
