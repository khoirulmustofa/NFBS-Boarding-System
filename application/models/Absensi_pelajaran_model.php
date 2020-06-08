<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absensi_pelajaran_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_absensi_siswa_by_mapel_guru($mata_pelajaran_guru_kelas_id, $date_now)
    {
        $query = $this->db->query("
        SELECT ap.absensi_pelajaran_id,ap.siswa_NIS,ap.absensi_pelajaran_status,ap.absensi_pelajaran_keterangan,
        s.siswa_nama_lengkap
        FROM absensi_pelajaran AS ap
        JOIN siswa AS s
        ON s.siswa_NIS = ap.siswa_NIS
        WHERE ap.mata_pelajaran_guru_kelas_id = '$mata_pelajaran_guru_kelas_id'
        AND DATE(ap.absensi_pelajaran_buat_waktu) = '$date_now'
        ORDER BY s.siswa_nama_lengkap ASC");
        return $query;
    }

    public function insert_absensi_pelajaran($data)
    {
        $this->db->insert('absensi_pelajaran', $data);
    }

    public function update_status_absensi_pelajaran($id, $data)
    {
        $this->db->where('absensi_pelajaran_id', $id);
        $this->db->update('absensi_pelajaran', $data);
    }

    public function get_absensi_pelajaran_by_absensi_pelajaran_id($absensi_pelajaran_id)
    {
        $query = $this->db->query("
        SELECT ap.absensi_pelajaran_id,ap.siswa_NIS,ap.absensi_pelajaran_status,ap.absensi_pelajaran_keterangan,
        s.siswa_nama_lengkap
        FROM absensi_pelajaran AS ap
        JOIN siswa AS s
        ON s.siswa_NIS = ap.siswa_NIS
        WHERE ap.absensi_pelajaran_id = '$absensi_pelajaran_id'");
        return $query;
    }

    public function get_check_absensi_siswa_by_mapel_guru($mata_pelajaran_guru_kelas_id, $date_now)
    {
        $query = $this->db->query("
        SELECT ap.absensi_pelajaran_id,ap.siswa_NIS,ap.absensi_pelajaran_status,ap.absensi_pelajaran_keterangan,
        s.siswa_nama_lengkap
        FROM absensi_pelajaran AS ap
        JOIN siswa AS s
        ON s.siswa_NIS = ap.siswa_NIS
        WHERE (ap.mata_pelajaran_guru_kelas_id = '$mata_pelajaran_guru_kelas_id'
        AND DATE(ap.absensi_pelajaran_buat_waktu) = '$date_now')
        AND ap.absensi_pelajaran_status = 'B'");
        return $query;
    }

    public function get_total_all_check_absensi_siswa_by_mapel_guru($mata_pelajaran_guru_kelas_id, $date_now)
    {
        $query = $this->db->query("
        SELECT ap.absensi_pelajaran_id,ap.siswa_NIS,ap.absensi_pelajaran_status,ap.absensi_pelajaran_keterangan,
        s.siswa_nama_lengkap
        FROM absensi_pelajaran AS ap
        JOIN siswa AS s
        ON s.siswa_NIS = ap.siswa_NIS
        WHERE (ap.mata_pelajaran_guru_kelas_id = '$mata_pelajaran_guru_kelas_id'
        AND DATE(ap.absensi_pelajaran_buat_waktu) = '$date_now')");
        return $query;
    }

    public function get_total_check_absensi_siswa_by_mapel_guru($mata_pelajaran_guru_kelas_id, $date_now, $absensi_pelajaran_status)
    {
        $this->db->select('*');
        $this->db->from('absensi_pelajaran');
        $this->db->where('mata_pelajaran_guru_kelas_id', $mata_pelajaran_guru_kelas_id);
        $this->db->where('DATE(absensi_pelajaran_buat_waktu)', $date_now);
        $this->db->where('absensi_pelajaran_status', $absensi_pelajaran_status);
        $query = $this->db->get();        
        return $query;
    }

    public function insert_dashboard_absensi_pelajaran($data_dash)
    {
        $this->db->insert('dashboard_absensi_pelajaran', $data_dash);
    }

    public function get_dashboard_absensi_pelajaran_by_pelajaran($mata_pelajaran_guru_kelas_id, $waktu)
    {
        $this->db->where('mata_pelajaran_guru_kelas_id', $mata_pelajaran_guru_kelas_id);
        $this->db->where('DATE(dashboard_absensi_pelajaran_waktu)', $waktu);
        $this->db->from('dashboard_absensi_pelajaran');
        $query = $this->db->get();
        return $query;
    }

    public function update_dashboard_absensi_pelajaran($kode, $date, $data_dash)
    {
        $this->db->where('mata_pelajaran_guru_kelas_id', $kode);
        $this->db->where('DATE(dashboard_absensi_pelajaran_waktu)', $date);
        $this->db->update('dashboard_absensi_pelajaran', $data_dash);
    }

    function get_report_absensi_mata_pelajaran_kelas_guru($mata_pelajaran_guru_kelas_id, $tgl_mulai, $tgl_akhir)
    {
        $query = $this->db->query("
        SELECT ap.siswa_NIS,s.siswa_nama_lengkap,
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 1, ap.absensi_pelajaran_status, NULL)) AS 'T1',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 2, ap.absensi_pelajaran_status, NULL)) AS 'T2',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 3, ap.absensi_pelajaran_status, NULL)) AS 'T3',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 4, ap.absensi_pelajaran_status, NULL)) AS 'T4',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 5, ap.absensi_pelajaran_status, NULL)) AS 'T5',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 6, ap.absensi_pelajaran_status, NULL)) AS 'T6',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 7, ap.absensi_pelajaran_status, NULL)) AS 'T7',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 8, ap.absensi_pelajaran_status, NULL)) AS 'T8',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 9, ap.absensi_pelajaran_status, NULL)) AS 'T9',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 10, ap.absensi_pelajaran_status, NULL)) AS 'T10',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 11, ap.absensi_pelajaran_status, NULL)) AS 'T11',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 12, ap.absensi_pelajaran_status, NULL)) AS 'T12',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 13, ap.absensi_pelajaran_status, NULL)) AS 'T13',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 14, ap.absensi_pelajaran_status, NULL)) AS 'T14',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 15, ap.absensi_pelajaran_status, NULL)) AS 'T15',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 16, ap.absensi_pelajaran_status, NULL)) AS 'T16',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 17, ap.absensi_pelajaran_status, NULL)) AS 'T17',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 18, ap.absensi_pelajaran_status, NULL)) AS 'T18',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 19, ap.absensi_pelajaran_status, NULL)) AS 'T19',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 20, ap.absensi_pelajaran_status, NULL)) AS 'T20',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 21, ap.absensi_pelajaran_status, NULL)) AS 'T21',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 22, ap.absensi_pelajaran_status, NULL)) AS 'T22',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 23, ap.absensi_pelajaran_status, NULL)) AS 'T23',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 24, ap.absensi_pelajaran_status, NULL)) AS 'T24',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 25, ap.absensi_pelajaran_status, NULL)) AS 'T25',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 26, ap.absensi_pelajaran_status, NULL)) AS 'T26',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 27, ap.absensi_pelajaran_status, NULL)) AS 'T27',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 28, ap.absensi_pelajaran_status, NULL)) AS 'T28',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 29, ap.absensi_pelajaran_status, NULL)) AS 'T29',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 30, ap.absensi_pelajaran_status, NULL)) AS 'T30',
        GROUP_CONCAT(IF(DAY(ap.absensi_pelajaran_buat_waktu) = 31, ap.absensi_pelajaran_status, NULL)) AS 'T31',
        COUNT(IF(ap.absensi_pelajaran_status = 'H', ap.absensi_pelajaran_status, NULL)) AS 'total_hadir',
        COUNT(IF(ap.absensi_pelajaran_status = 'T', ap.absensi_pelajaran_status, NULL)) AS 'total_telat',
        COUNT(IF(ap.absensi_pelajaran_status = 'S', ap.absensi_pelajaran_status, NULL)) AS 'total_sakit',
        COUNT(IF(ap.absensi_pelajaran_status = 'I', ap.absensi_pelajaran_status, NULL)) AS 'total_ijin',
        COUNT(IF(ap.absensi_pelajaran_status = 'A', ap.absensi_pelajaran_status, NULL)) AS 'total_absen'
        FROM mata_pelajaran_guru_kelas AS mpgk
        JOIN absensi_pelajaran AS ap
        ON ap.mata_pelajaran_guru_kelas_id = mpgk.mata_pelajaran_guru_kelas_id
        JOIN kelas AS k
        ON k.kelas_id = mpgk.kelas_id
        JOIN mata_pelajaran AS mp
        ON mp.mata_pelajaran_id = mpgk.mata_pelajaran_id
        JOIN siswa AS s
        ON s.siswa_NIS = ap.siswa_NIS
        WHERE mpgk.mata_pelajaran_guru_kelas_id = '$mata_pelajaran_guru_kelas_id'
        AND DATE(ap.absensi_pelajaran_buat_waktu) BETWEEN '$tgl_mulai' AND '$tgl_akhir'
        GROUP BY ap.siswa_NIS
        ORDER BY s.siswa_nama_lengkap");
        return $query;
    }

    public function get_guru_guru_id($users_id)
    {
        $this->db->where('users_id', $users_id);
        return $this->db->get('guru');
    }

    function get_mata_pelajaran_by_guru($guru_id)
    {
        $this->db->select('mata_pelajaran_guru_kelas.*');
        $this->db->select('mata_pelajaran.mata_pelajaran_kode,mata_pelajaran.mata_pelajaran_nama');
        $this->db->select('kelas.kelas_nama');
        $this->db->from('mata_pelajaran_guru_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.mata_pelajaran_id = mata_pelajaran_guru_kelas.mata_pelajaran_id');
        $this->db->join('kelas', 'kelas.kelas_id = mata_pelajaran_guru_kelas.kelas_id');
        $this->db->join('guru', 'guru.guru_id = mata_pelajaran_guru_kelas.guru_id');
        $this->db->where('mata_pelajaran_guru_kelas.guru_id', $guru_id);
        $query = $this->db->get();
        return $query;
        // $this->db->get();
        // return $this->db->last_query();
        
    }

    function get_mata_pelajaran_guru_kelas_id($mata_pelajaran_guru_kelas_id)
    {
        $this->db->select('mata_pelajaran_guru_kelas.*');
        $this->db->select('mata_pelajaran.mata_pelajaran_kode,mata_pelajaran.mata_pelajaran_nama');
        $this->db->select('kelas.kelas_nama');
        $this->db->from('mata_pelajaran_guru_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.mata_pelajaran_id = mata_pelajaran_guru_kelas.mata_pelajaran_id');
        $this->db->join('kelas', 'kelas.kelas_id = mata_pelajaran_guru_kelas.kelas_id');
        $this->db->where('mata_pelajaran_guru_kelas.mata_pelajaran_guru_kelas_id', $mata_pelajaran_guru_kelas_id);
        $query = $this->db->get();
        return $query;
    }

}
