<section class="content">
    <div class="row">
        <?php
        foreach ($mata_pelajaran_guru_data as $mata_pelajaran) {
        ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?php echo site_url('absensi_pelajaran/daftar_siswa?mata_pelajaran_guru_kelas='.$mata_pelajaran->mata_pelajaran_guru_kelas_id)?>">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo  $mata_pelajaran->kelas_nama ?> | <?php echo  $mata_pelajaran->mata_pelajaran_kode ?></h3>
                            <h4><?php echo $mata_pelajaran->mata_pelajaran_nama  ?></h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-fw fa-book"></i>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
    </div>
</section>
