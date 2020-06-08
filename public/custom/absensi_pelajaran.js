let table;
$(document).ready(function () {
    table = $('#data_siswa').DataTable({
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
            "url": base_url + "absensi_pelajaran/json_daftar_siswa",
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

$('#data_siswa').on('click', '#hadir_absensi_pelajaran', function () {
    let absensi_pelajaran_id = $(this).data('absensi_pelajaran_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "absensi_pelajaran/hadir_absensi_pelajaran",
        dataType: "JSON",
        data: {
            absensi_pelajaran_id: absensi_pelajaran_id
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

$('#data_siswa').on('click', '#telat_absensi_pelajaran', function () {
    let absensi_pelajaran_id = $(this).data('absensi_pelajaran_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "absensi_pelajaran/telat_absensi_pelajaran",
        dataType: "JSON",
        data: {
            absensi_pelajaran_id: absensi_pelajaran_id
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

$('#data_siswa').on('click', '#sakit_absensi_pelajaran', function () {
    let absensi_pelajaran_id = $(this).data('absensi_pelajaran_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "absensi_pelajaran/sakit_absensi_pelajaran",
        dataType: "JSON",
        data: {
            absensi_pelajaran_id: absensi_pelajaran_id
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

$('#data_siswa').on('click', '#ijin_absensi_pelajaran', function () {
    let absensi_pelajaran_id = $(this).data('absensi_pelajaran_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "absensi_pelajaran/ijin_absensi_pelajaran",
        dataType: "JSON",
        data: {
            absensi_pelajaran_id: absensi_pelajaran_id
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

$('#data_siswa').on('click', '#absen_absensi_pelajaran', function () {
    let absensi_pelajaran_id = $(this).data('absensi_pelajaran_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    $.ajax({
        type: "POST",
        url: base_url + "absensi_pelajaran/absen_absensi_pelajaran",
        dataType: "JSON",
        data: {
            absensi_pelajaran_id: absensi_pelajaran_id
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

$('#data_siswa').on('click', '#edit_absensi_pelajaran', function () {
    $('#form')[0].reset();
    $(".alert-dismissible").css('display', 'none');
    let absensi_pelajaran_id = $(this).data('absensi_pelajaran_id');
    let siswa_nama_lengkap = $(this).data('siswa_nama_lengkap');
    let absensi_pelajaran_status = $(this).data('absensi_pelajaran_status');
    let absensi_pelajaran_keterangan = $(this).data('absensi_pelajaran_keterangan');
    $('#modal_form').modal('show');
    $('[name="absensi_pelajaran_id"]').val(absensi_pelajaran_id);
    $('[name="siswa_nama_lengkap"]').val(siswa_nama_lengkap);
    $('[name="absensi_pelajaran_status"]').val(absensi_pelajaran_status);
    $('[name="absensi_pelajaran_keterangan"]').val(absensi_pelajaran_keterangan);
    $('.modal-title').html("Edit Status Absensi " + siswa_nama_lengkap);

    return false;
});

$('#btnSaveAbsensiPelajaran').on('click', function () {
    var absensi_pelajaran_id = $('[name="absensi_pelajaran_id"]').val();
    var siswa_nama_lengkap = $('[name="siswa_nama_lengkap"]').val();
    var absensi_pelajaran_status = $('[name="absensi_pelajaran_status"]').val();
    var absensi_pelajaran_keterangan = $('[name="absensi_pelajaran_keterangan"]').val();
    console.log(absensi_pelajaran_id);
    console.log(siswa_nama_lengkap);
    console.log(absensi_pelajaran_status);
    console.log(absensi_pelajaran_keterangan);
    $('#btnSaveAbsensiPelajaran').text('Sedang menyimpan ...');
    $('#btnSaveAbsensiPelajaran').attr('disabled', true);
    $.ajax({
        type: "POST",
        url: base_url + "absensi_pelajaran/simpan_status_absensi_pelajaran",
        dataType: "JSON",
        data: {
            absensi_pelajaran_id: absensi_pelajaran_id,
            absensi_pelajaran_status: absensi_pelajaran_status,
            absensi_pelajaran_keterangan: absensi_pelajaran_keterangan
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
            $('#btnSaveAbsensiPelajaran').text('Simpan'); //change button text
            $('#btnSaveAbsensiPelajaran').attr('disabled', false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            $('#btnSaveAbsensiPelajaran').text('Simpan'); //change button text
            $('#btnSaveAbsensiPelajaran').attr('disabled', false); //set button enable 

        }
    });

});