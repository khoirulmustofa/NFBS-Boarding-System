<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siswa_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_all_siswa()
    {
        $this->db->order_by('siswa_nama_lengkap', 'ASC');
        return $this->db->get('siswa')->result();
    }

    public function get_siswa_by_kelas($kelas_id)
    {
        $cariuery = $this->db->query("
        SELECT * FROM siswa
        WHERE kelas_id ='$kelas_id'
        ORDER BY siswa_nama_lengkap ASC");
        return $cariuery;
    }

    function get_total_rows_siswa($cari = NULL)
    {
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.kelas_id = siswa.kelas_id');
        $this->db->like('siswa.siswa_NIS', $cari);
        $this->db->or_like('siswa.siswa_NISN', $cari);
        $this->db->or_like('siswa.siswa_nama_lengkap', $cari);
        $this->db->or_like('kelas.kelas_nama', $cari);
        $query = $this->db->count_all_results();
        return $query;
    }

    function get_limit_data_siswa($limit, $start = 0, $cari = NULL)
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.kelas_id = siswa.kelas_id');
        $this->db->like('siswa.siswa_NIS', $cari);
        $this->db->or_like('siswa.siswa_NISN', $cari);
        $this->db->or_like('siswa.siswa_nama_lengkap', $cari);
        $this->db->or_like('kelas.kelas_nama', $cari);
        $this->db->limit($limit, $start);
        $this->db->order_by('kelas.kelas_nama', 'ASC');
        $this->db->order_by('siswa.siswa_nama_lengkap', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    function insert_siswa($data)
    {
        $this->db->insert('siswa', $data);
    }

    public function get_santri_mushrif_tahfidz_by_mushrif($mushrif_tahfidz_id)
    {
        $this->db->where('mushrif_tahfidz_id', $mushrif_tahfidz_id);
        return $this->db->get('siswa');
    }
}
