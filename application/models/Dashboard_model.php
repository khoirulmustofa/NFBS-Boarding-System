<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_dash_absensi_pelajaran_perkelas($kelas_id, $date_now)
    {
        $this->set_number();
        $query = $this->db->query("        
        SELECT CONCAT('Jam Ke ',(@row_number:=@row_number + 1)) AS jam_ke ,dap.* ,mpgk.*
        FROM dashboard_absensi_pelajaran AS dap
        JOIN mata_pelajaran_guru_kelas AS mpgk
        ON mpgk.mata_pelajaran_guru_kelas_id = dap.mata_pelajaran_guru_kelas_id
        WHERE mpgk.kelas_id= '$kelas_id'
        AND DATE(dashboard_absensi_pelajaran_waktu) = '$date_now'
        ORDER BY dashboard_absensi_pelajaran_waktu ASC");
        return $query;
    }

    private function set_number()
    {
        $this->db->query("SET @row_number = 0");
    }

    public function get_dashboard_tahfidz_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $waktu, $sesi_tahfidz)
    {
        $this->db->where('mushrif_tahfidz_id', $mushrif_tahfidz_id);
        $this->db->where('tahfidz_sesi', $sesi_tahfidz);
        $this->db->where('DATE(dashboard_absensi_tahfid_buat_waktu)', $waktu);
        $query = $this->db->get('dashboard_absensi_tahfid');
        return $query;
        // // $this->db->get();
        // return $this->db->last_query();
    }

    public function update_dashboard_tahfidz($mushrif_tahfidz_id, $waktu, $sesi_tahfidz, $data_update)
    {
        $this->db->where('mushrif_tahfidz_id', $mushrif_tahfidz_id);
        $this->db->where('DATE(dashboard_absensi_tahfid_buat_waktu)', $waktu);
        $this->db->where('tahfidz_sesi', $sesi_tahfidz);
        $this->db->update('dashboard_absensi_tahfid', $data_update);
    }

    public function insert_dashboard_tahfidz($data_dash)
    {
        $this->db->insert('dashboard_absensi_tahfid', $data_dash);
    }
}
