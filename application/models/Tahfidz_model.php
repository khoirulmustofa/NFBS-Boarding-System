<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tahfidz_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_tahfidz3_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $tahfidz_sesi, $date_now)
    {
        $this->db->select('*');
        $this->db->from('tahfidz');
        $this->db->where('mushrif_tahfidz_id', $mushrif_tahfidz_id);
        $this->db->where('tahfidz_sesi', $tahfidz_sesi);
        $this->db->where('DATE(tahfidz_buat_waktu)', $date_now);
        $query = $this->db->get();
        return $query;
    }

    public function get_tahfidz_santri_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $tahfidz_sesi, $date_now)
    {
        // $this->set_number();
        // $this->db->select('(@row_number:=@row_number + 1) AS no_urut');
        $this->db->select('tahfidz.tahfidz_id,tahfidz.siswa_NIS,tahfidz.tahfidz_absensi_status,tahfidz.tahfidz_absensi_keterangan,tahfidz.al_quran_id');
        $this->db->select('siswa.siswa_nama_lengkap');
        $this->db->from('tahfidz');
        $this->db->join('siswa', 'siswa.siswa_NIS = tahfidz.siswa_NIS');
        $this->db->where('tahfidz.mushrif_tahfidz_id', $mushrif_tahfidz_id);
        $this->db->where('tahfidz.tahfidz_sesi', $tahfidz_sesi);
        $this->db->where('DATE(tahfidz.tahfidz_buat_waktu)', $date_now);
        $query = $this->db->get();
        return $query;
        
    }

    private function set_number()
    {
        $this->db->query("SET @row_number = 0;");
    }

    function insert_tahfidz($data)
    {
        $this->db->insert('tahfidz', $data);
    }

    function update_status_tahfidz($id, $data)
    {
        $this->db->where('tahfidz_id', $id);
        $this->db->update('tahfidz', $data);
    }

    public function update_status_absensi_tahfidz($tahfidz_id, $data)
    {
        $this->db->where('tahfidz_id', $tahfidz_id);
        $this->db->update('tahfidz', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_tahfidz_siswa_by_tahfidz_id($tahfidz_id)
    {
        $this->db->select('tahfidz.*');
        $this->db->select('siswa.siswa_NIS,siswa.siswa_nama_lengkap');
        $this->db->from('tahfidz');
        $this->db->join('siswa', 'siswa.siswa_NIS = tahfidz.siswa_NIS');
        $this->db->where('tahfidz.tahfidz_id', $tahfidz_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_check_absensi_santri_by_mushrif_tahfidz_id($mushrif_tahfidz_id, $waktu, $sesi_tahfidz)
    {
        $this->db->where('tahfidz_absensi_status', 'B');
        $this->db->where('mushrif_tahfidz_id', $mushrif_tahfidz_id);
        $this->db->where('tahfidz_sesi', $sesi_tahfidz);
        $this->db->where('DATE(tahfidz_buat_waktu)', $waktu);
        $query = $this->db->get('tahfidz');
        return $query;
    }

    public function get_status_absensi_tahfidz_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, $tahfidz_absensi_status, $sesi_tahfidz)
    {
        $this->db->where('tahfidz_absensi_status', $tahfidz_absensi_status);
        $this->db->where('mushrif_tahfidz_id', $mushrif_tahfidz_id);
        $this->db->where('tahfidz_sesi', $sesi_tahfidz);
        $this->db->where('DATE(tahfidz_buat_waktu)', $waktu);
        $query = $this->db->get('tahfidz');
        return $query;
    }

    public function get_all_absensi_santri_by_mushrif_tahfidz($mushrif_tahfidz_id, $waktu, $sesi_tahfidz)
    {
        $this->db->where('mushrif_tahfidz_id', $mushrif_tahfidz_id);
        $this->db->where('tahfidz_sesi', $sesi_tahfidz);
        $this->db->where('DATE(tahfidz_buat_waktu)', $waktu);
        $query = $this->db->get('tahfidz');
        return $query;
    }

    public function get_al_quran_terakhir_setor($siswa_NIS)
    {
        $this->db->select('*');
        $this->db->from('tahfidz');
        $this->db->join('al_quran', 'al_quran.al_quran_id = tahfidz.al_quran_id','LEFT');
        $this->db->where('tahfidz.siswa_NIS', $siswa_NIS);
        $this->db->where('tahfidz.al_quran_id IS NULL', null, false);
        $this->db->order_by('tahfidz.tahfidz_buat_waktu', 'DEC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
        // $this->db->get();
        // return $this->db->last_query();
    }

    public function get_report_absensi_tahfidz($mushrif_tahfidz_id,$tgl_mulai,$tgl_akhir)
    {
        $query = $this->db->query("
        SELECT t.siswa_NIS,s.siswa_nama_lengkap,
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 1, t.tahfidz_absensi_status, NULL)) AS 'T1',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 2, t.tahfidz_absensi_status, NULL)) AS 'T2',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 3, t.tahfidz_absensi_status, NULL)) AS 'T3',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 4, t.tahfidz_absensi_status, NULL)) AS 'T4',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 5, t.tahfidz_absensi_status, NULL)) AS 'T5',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 6, t.tahfidz_absensi_status, NULL)) AS 'T6',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 7, t.tahfidz_absensi_status, NULL)) AS 'T7',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 8, t.tahfidz_absensi_status, NULL)) AS 'T8',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 9, t.tahfidz_absensi_status, NULL)) AS 'T9',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 10, t.tahfidz_absensi_status, NULL)) AS 'T10',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 11, t.tahfidz_absensi_status, NULL)) AS 'T11',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 12, t.tahfidz_absensi_status, NULL)) AS 'T12',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 13, t.tahfidz_absensi_status, NULL)) AS 'T13',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 14, t.tahfidz_absensi_status, NULL)) AS 'T14',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 15, t.tahfidz_absensi_status, NULL)) AS 'T15',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 16, t.tahfidz_absensi_status, NULL)) AS 'T16',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 17, t.tahfidz_absensi_status, NULL)) AS 'T17',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 18, t.tahfidz_absensi_status, NULL)) AS 'T18',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 19, t.tahfidz_absensi_status, NULL)) AS 'T19',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 20, t.tahfidz_absensi_status, NULL)) AS 'T20',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 21, t.tahfidz_absensi_status, NULL)) AS 'T21',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 22, t.tahfidz_absensi_status, NULL)) AS 'T22',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 23, t.tahfidz_absensi_status, NULL)) AS 'T23',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 24, t.tahfidz_absensi_status, NULL)) AS 'T24',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 25, t.tahfidz_absensi_status, NULL)) AS 'T25',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 26, t.tahfidz_absensi_status, NULL)) AS 'T26',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 27, t.tahfidz_absensi_status, NULL)) AS 'T27',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 28, t.tahfidz_absensi_status, NULL)) AS 'T28',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 29, t.tahfidz_absensi_status, NULL)) AS 'T29',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 30, t.tahfidz_absensi_status, NULL)) AS 'T30',
        GROUP_CONCAT(IF(DAY(t.tahfidz_buat_waktu) = 31, t.tahfidz_absensi_status, NULL)) AS 'T31',
        COUNT(IF(t.tahfidz_absensi_status = 'H', t.tahfidz_absensi_status, NULL)) AS 'total_hadir',
        COUNT(IF(t.tahfidz_absensi_status = 'T', t.tahfidz_absensi_status, NULL)) AS 'total_telat',
        COUNT(IF(t.tahfidz_absensi_status = 'S', t.tahfidz_absensi_status, NULL)) AS 'total_sakit',
        COUNT(IF(t.tahfidz_absensi_status = 'I', t.tahfidz_absensi_status, NULL)) AS 'total_ijin',
        COUNT(IF(t.tahfidz_absensi_status = 'A', t.tahfidz_absensi_status, NULL)) AS 'total_absen'
        FROM tahfidz AS t
        JOIN siswa AS s
        ON s.siswa_NIS = t.siswa_NIS
        WHERE t.mushrif_tahfidz_id = '$mushrif_tahfidz_id'
        AND DATE(t.tahfidz_buat_waktu) BETWEEN '$tgl_mulai' AND '$tgl_akhir'
        GROUP BY t.siswa_NIS
        ORDER BY s.siswa_nama_lengkap");
        return $query;
    }

    public function get_report_tahfidz($mushrif_tahfidz_id,$tgl_mulai,$tgl_akhir)
    {
        $query = $this->db->query("
        SELECT t.siswa_NIS,s.siswa_nama_lengkap,
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 1, t.tahfidz_baris, 0)) AS 'T1',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 2, t.tahfidz_baris, 0)) AS 'T2',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 3, t.tahfidz_baris, 0)) AS 'T3',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 4, t.tahfidz_baris, 0)) AS 'T4',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 5, t.tahfidz_baris, 0)) AS 'T5',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 6, t.tahfidz_baris, 0)) AS 'T6',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 7, t.tahfidz_baris, 0)) AS 'T7',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 8, t.tahfidz_baris, 0)) AS 'T8',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 9, t.tahfidz_baris, 0)) AS 'T9',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 10, t.tahfidz_baris, 0)) AS 'T10',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 11, t.tahfidz_baris, 0)) AS 'T11',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 12, t.tahfidz_baris, 0)) AS 'T12',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 13, t.tahfidz_baris, 0)) AS 'T13',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 14, t.tahfidz_baris, 0)) AS 'T14',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 15, t.tahfidz_baris, 0)) AS 'T15',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 16, t.tahfidz_baris, 0)) AS 'T16',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 17, t.tahfidz_baris, 0)) AS 'T17',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 18, t.tahfidz_baris, 0)) AS 'T18',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 19, t.tahfidz_baris, 0)) AS 'T19',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 20, t.tahfidz_baris, 0)) AS 'T20',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 21, t.tahfidz_baris, 0)) AS 'T21',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 22, t.tahfidz_baris, 0)) AS 'T22',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 23, t.tahfidz_baris, 0)) AS 'T23',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 24, t.tahfidz_baris, 0)) AS 'T24',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 25, t.tahfidz_baris, 0)) AS 'T25',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 26, t.tahfidz_baris, 0)) AS 'T26',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 27, t.tahfidz_baris, 0)) AS 'T27',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 28, t.tahfidz_baris, 0)) AS 'T28',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 29, t.tahfidz_baris, 0)) AS 'T29',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 30, t.tahfidz_baris, 0)) AS 'T30',
        SUM(IF(DAY(t.tahfidz_buat_waktu) = 31, t.tahfidz_baris, 0)) AS 'T31',
        SUM(t.tahfidz_baris) AS 'total_baris'
        FROM tahfidz AS t
        JOIN siswa AS s
        ON s.siswa_NIS = t.siswa_NIS
        WHERE t.mushrif_tahfidz_id = '$mushrif_tahfidz_id'
        AND DATE(t.tahfidz_buat_waktu) BETWEEN '$tgl_mulai' AND '$tgl_akhir'
        GROUP BY t.siswa_NIS
        ORDER BY s.siswa_nama_lengkap");
        return $query;
    }
}
// $this->db->get();,,$tgl_akhir
        // return $this->db->last_query();  