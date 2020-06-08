<?php if ($load_css_js == "dashboard_index") { ?>
    <script src="<?php echo site_url('public') ?>/bower_components/raphael/raphael.min.js"></script>
    <script src="<?php echo site_url('public') ?>/bower_components/morris.js/morris.min.js"></script>
    <script type="text/javascript">
        Morris.Bar({
            element: 'graph_7a',
            data: <?php echo json_encode($data_kelas_7a) ?>,
            xkey: 'jam_ke',
            ykeys: ['total_siswa', 'total_hadir', 'total_telat', 'total_sakit', 'total_ijin', 'total_absen'],
            labels: ['Total', 'Hadir', 'Telat', 'Sakit', 'Ijin', 'Absen'],
            barColors: ['#3c8dbc', '#00a65a', '#001F3F', '#f39c12', '#00c0ef', '#dd4b39'],
        });
        Morris.Bar({
            element: 'graph_7b',
            data: <?php echo $data_kelas_7b; ?>,
            xkey: 'jam_ke',
            ykeys: ['total_siswa', 'total_hadir', 'total_telat', 'total_sakit', 'total_ijin', 'total_absen'],
            labels: ['Total', 'Hadir', 'Telat', 'Sakit', 'Ijin', 'Absen'],
            barColors: ['#3c8dbc', '#00a65a', '#001F3F', '#f39c12', '#00c0ef', '#dd4b39'],
        });
        Morris.Bar({
            element: 'graph_7c',
            data: <?php echo $data_kelas_7c; ?>,
            xkey: 'jam_ke',
            ykeys: ['total_siswa', 'total_hadir', 'total_telat', 'total_sakit', 'total_ijin', 'total_absen'],
            labels: ['Total', 'Hadir', 'Telat', 'Sakit', 'Ijin', 'Absen'],
            barColors: ['#3c8dbc', '#00a65a', '#001F3F', '#f39c12', '#00c0ef', '#dd4b39'],
        });
        Morris.Bar({
            element: 'graph_7d',
            data: <?php echo $data_kelas_7d; ?>,
            xkey: 'jam_ke',
            ykeys: ['total_siswa', 'total_hadir', 'total_telat', 'total_sakit', 'total_ijin', 'total_absen'],
            labels: ['Total', 'Hadir', 'Telat', 'Sakit', 'Ijin', 'Absen'],
            barColors: ['#3c8dbc', '#00a65a', '#001F3F', '#f39c12', '#00c0ef', '#dd4b39'],
        });
    </script>
<?php } ?>
<?php if ($load_css_js == "absensi_pelajaran_daftar_siswa") { ?>
    <script src="<?php echo site_url('public') ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url('public') ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo site_url('public/custom/absensi_pelajaran.js') ?>"></script>
<?php } ?>
<?php if ($load_css_js == "report_absensi_pelajaran_guru_kelas") { ?>
    <!-- bootstrap datepicker -->
    <script src="<?php echo site_url('public') ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        var d = new Date();
        var currMonth = d.getMonth();
        var currYear = d.getFullYear();
        var startDate = new Date(currYear, currMonth, 1);
        var endDate = new Date(currYear, currMonth, 31);

        $('#tgl_mulai').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true,
        });
        $('#tgl_akhhir').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true,
        });

        // $("#tgl_mulai").datepicker("setDate", startDate);
        // $("#tgl_akhhir").datepicker("setDate", endDate);
    </script>
<?php } ?>
<?php if ($load_css_js == "tahfidz_daftar_santri") { ?>
    <script src="<?php echo site_url('public') ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url('public') ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo site_url('public/custom/tahfidz.js') ?>"></script>
<?php } ?>