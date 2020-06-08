let table;
$(document).ready(function () {
    table = $('#data_santri').DataTable({
        "searching": false,
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + "tahfidz/json_daftar_santri",
            "type": "POST"
        },
        oLanguage: { sProcessing: '<div class="overlay">        <i class="fa fa-refresh fa-spin"></i>      </div>' },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        },],
    });
});

function reload_table() {
    table.ajax.reload(null, false);
}

$('#data_santri').on('click', '#hadir_absensi_tahfidz', function () {
    let tahfidz_id = $(this).data('tahfidz_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/hadir_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id
        },
        success: function (response) {
            if (response.status) {
                $.notify({
                    title: '<strong>PESAN : </strong>',
                    message: "Status Absensi " + siswa_nama_lengkap + ' Hadir'
                }, {
                    type: 'success',
                    delay: 100,
                });
            }
            reload_table();
        }
    });
    return false;
});

$('#data_santri').on('click', '#telat_absensi_tahfidz', function () {
    let tahfidz_id = $(this).data('tahfidz_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/telat_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id
        },
        success: function (response) {
            if (response.status) {
                $.notify({
                    title: '<strong>PESAN : </strong>',
                    message: "Status Absensi " + siswa_nama_lengkap + ' Telat'
                }, {
                    type: 'success',
                    delay: 100,
                });
            }
            reload_table();
        }
    });
    return false;
});

$('#data_santri').on('click', '#sakit_absensi_tahfidz', function () {
    let tahfidz_id = $(this).data('tahfidz_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/sakit_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id
        },
        success: function (response) {
            if (response.status) {
                $.notify({
                    title: '<strong>PESAN : </strong>',
                    message: "Status Absensi " + siswa_nama_lengkap + ' Sakit'
                }, {
                    type: 'success',
                    delay: 100,
                });
            }
            reload_table();
        }
    });
    return false;
});

$('#data_santri').on('click', '#ijin_absensi_tahfidz', function () {
    let tahfidz_id = $(this).data('tahfidz_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/ijin_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id
        },
        success: function (response) {
            if (response.status) {
                $.notify({
                    title: '<strong>PESAN : </strong>',
                    message: "Status Absensi " + siswa_nama_lengkap + ' Ijin'
                }, {
                    type: 'success',
                    delay: 100,
                });
            }
            reload_table();
        }
    });
    return false;
});

$('#data_santri').on('click', '#absen_absensi_tahfidz', function () {
    let tahfidz_id = $(this).data('tahfidz_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/absen_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id
        },
        success: function (response) {
            if (response.status) {
                $.notify({
                    title: '<strong>PESAN : </strong>',
                    message: "Status Absensi " + siswa_nama_lengkap + ' Absen'
                }, {
                    type: 'success',
                    delay: 100,
                });
            }
            reload_table();
        }
    });
    return false;
});

$('#data_santri').on('click', '#edit_absensi_tahfidz', function () {
    $(".alert-dismissible").css('display', 'none');
    let tahfidz_id = $(this).data('tahfidz_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    let tahfidz_absensi_status = $(this).data('tahfidz_absensi_status');
    let tahfidz_absensi_keterangan = $(this).data('tahfidz_absensi_keterangan');
    $('#modal_form').modal('show');
    $('[name="tahfidz_id"]').val(tahfidz_id);
    $('[name="siswa_nama_lengkap"]').val(siswa_nama_lengkap);
    $('[name="tahfidz_absensi_status"]').val(tahfidz_absensi_status);
    $('[name="tahfidz_absensi_keterangan"]').val(tahfidz_absensi_keterangan);
    $('.modal-title').html("Edit Status Absensi : " + siswa_nama_lengkap);

    return false;
});

$('#btnSaveAbsensiTahfidz').on('click', function () {
    let tahfidz_id = $('[name="tahfidz_id"]').val();
    let siswa_nama_lengkap = $('[name="siswa_nama_lengkap"]').val();
    let tahfidz_absensi_status = $('[name="tahfidz_absensi_status"]').val();
    let tahfidz_absensi_keterangan = $('[name="tahfidz_absensi_keterangan"]').val();
    $('#btnSaveAbsensiTahfidz').text('Sedang menyimpan ...');
    $('#btnSaveAbsensiTahfidz').attr('disabled', true);
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/simpan_status_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id,
            tahfidz_absensi_status: tahfidz_absensi_status,
            tahfidz_absensi_keterangan: tahfidz_absensi_keterangan
        },
        success: function (response) {
            if (response.status) {
                $.notify({
                    title: '<strong>PESAN : </strong>',
                    message: "Status Absensi " + siswa_nama_lengkap + ' Berhasil Diupdate'
                }, {
                    type: 'success',
                    delay: 100,
                });
                $(".alert-dismissible").css('display', 'none');
                $('#modal_form').modal('hide');
                reload_table();
            } else {
                $(".alert-dismissible").css('display', 'block');
                $(".alert-dismissible").html(response.errors);
            }
            $('#btnSaveAbsensiTahfidz').text('Simpan'); //change button text
            $('#btnSaveAbsensiTahfidz').attr('disabled', false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            $('#btnSaveAbsensiTahfidz').text('Simpan'); //change button text
            $('#btnSaveAbsensiTahfidz').attr('disabled', false); //set button enable 
        }
    });
});

$('#data_santri').on('click', '#serot_tahfidz', function () {
    $('#modal_form_setor').modal('show');
    $(".alert-dismissible").css('display', 'none');
    let tahfidz_id = $(this).data('tahfidz_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    let tahfidz_absensi_status = $(this).data('tahfidz_absensi_status');
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/setor_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id
        },
        success: function (response) {
            if (response.status) {
                $('#modal_form_setor').modal('show');
                $('[name="tahfidz_id"]').val(tahfidz_id);
                $('[name="siswa_nama_lengkap"]').val(siswa_nama_lengkap);
                $('#tahfidz_absensi_status').html(response.tahfidz_absensi_status);
                $('.modal-title').html("Setor Absensi : " + siswa_nama_lengkap);
                $('#surah_terakhir').text(response.al_quran_surah);
                $('#ayat_terakhir').text(response.ayat_terakhir);
                $('#al_quran_select').html(response.al_quran_select);
                $('[name="ayat_terakhir_input"]').val('');
                $('[name="tahfidz_baris_input"]').val('');
            }

        }
    });
    return false;
});

$('#btnSaveSetorTahfidz').on('click', function () {
    let tahfidz_id = $('[name="tahfidz_id"]').val();
    let siswa_nama_lengkap = $('[name="siswa_nama_lengkap"]').val();    
    let al_quran_id_setor = $("div#al_quran_select select").val();
    let ayat_terakhir_input = $('[name="ayat_terakhir_input"]').val();
    let tahfidz_baris_input = $('[name="tahfidz_baris_input"]').val();
    $('#btnSaveSetorTahfidz').text('Sedang menyimpan ...');
    $('#btnSaveSetorTahfidz').attr('disabled', true);
    console.log(tahfidz_id);
    console.log(al_quran_id_setor);
    console.log(ayat_terakhir_input);
    console.log(tahfidz_baris_input);
    $.ajax({
        type: "POST",
        url: base_url + "tahfidz/simpan_setor_tahfidz",
        dataType: "JSON",
        data: {
            tahfidz_id: tahfidz_id,
            al_quran_id_setor: al_quran_id_setor,
            ayat_terakhir_input: ayat_terakhir_input,
            tahfidz_baris_input: tahfidz_baris_input
        },
        success: function (response) {
            if (response.status) {
                $(".alert-dismissible").css('display', 'none');
                $('#modal_form_setor').modal('hide');
                $.notify({
                    title: '<strong>PESAN : </strong>',
                    message: "Setor Tahfidz " + siswa_nama_lengkap + ' Berhasil'
                }, {
                    type: 'success',
                    delay: 100,
                });
                reload_table();
            } else {
                $(".alert-dismissible").css('display', 'block');
                $(".alert-dismissible").html(response.errors);
            }
            $('#btnSaveSetorTahfidz').text('Simpan');
            $('#btnSaveSetorTahfidz').attr('disabled', false);
            console.log(response.status);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            $('#btnSaveSetorTahfidz').text('Simpan');
            $('#btnSaveSetorTahfidz').attr('disabled', false);
        }
    });
});
