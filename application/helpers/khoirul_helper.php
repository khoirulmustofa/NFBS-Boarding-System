<?php

function sesi_tahfidz()
{
    $jam = date('H');
    if ($jam <= 12) {
        $sesi = "Subuh";
    } elseif ($jam > 12) {
        $sesi = "Magrib";
    }else{
        $sesi = "Tidak Ada Jadwal";
    }
    return $sesi;
}

function date_to_eng($tanggal)
{
    $tgl = date('Y-m-d', strtotime($tanggal));
    if ($tgl == '1970-01-01') {
        return '';
    } else {
        return $tgl;
    }
}

function tgl_indo($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulann(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function getBulann($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function is_login()
{
    $ci = &get_instance();
    if ($ci->session->userdata('logged_in') != true) {
        redirect(site_url('login/login'));
    }
}

function have_access($hak_akses)
{
    $ci = &get_instance();
    $ci->db->select('*');
    $ci->db->from('auth_users_hak_akses');
    $ci->db->join('auth_hak_akses', 'auth_hak_akses.hak_akses_id = auth_users_hak_akses.hak_akses_id');
    $ci->db->where('auth_hak_akses.hak_akses_nama', $hak_akses);
    $ci->db->where('auth_users_hak_akses.users_id', $ci->session->userdata('users_id'));
    $query = $ci->db->get();
    // $ci->db->get();
    // $query = $ci->db->last_query();
    // print_r($query->num_rows());
    // exit();
    if ($query->num_rows() < 1) {
        $hasil = 'N';
    } else {
        $hasil = 'Y';
    }
    return $hasil;
}

function cmb_dinamis($name, $table, $field, $pk, $selected, $pilihan)
{
    $ci = &get_instance();
    $cmb = "<select name='$name' class='form-control select2'> <option value='' selected> $pilihan </option>";
    $ci->db->order_by($field, 'ASC');
    $data = $ci->db->get($table)->result();
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
        $cmb .= ">" . ucwords($d->$field) . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function cmb_dinamis_double($name, $table, $field1, $field2, $pk, $selected, $pilihan)
{
    $ci = &get_instance();
    $cmb = "<select name='$name' class='form-control select2'> <option value='' selected> $pilihan </option>";
    $ci->db->order_by($field2, 'ASC');
    $data = $ci->db->get($table)->result();
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
        $cmb .= ">" . $d->$field1 . " (" . $d->$field2 . ")" . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function km_encrypt($value)
{
    $key = "KhoirulMutofajossg4ndo55R3w0rew0";
    return urlencode(base64_encode($key . $value));
}

function km_decrypt($string)
{
    $key = "KhoirulMutofajossg4ndo55R3w0rew0";
    $urldecode = urldecode($string);
    $base64_decode = base64_decode($urldecode);
    $hasil = str_replace($key, "", $base64_decode);
    return urldecode($hasil);
}

function insert_uuid()
{
    return uniqid("nfbs-");
}
