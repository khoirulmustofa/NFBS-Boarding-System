<section class="content">
    <div class="row">
        <?php
        foreach ($mata_pelajaran_guru_data as $mata_pelajaran) {
        ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?php echo site_url('report/absensi_pelajaran_guru_kelas?kode_mapel_guru=') . $mata_pelajaran->mata_pelajaran_guru_kelas_id ?>">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $mata_pelajaran->kelas_nama ." | ". $mata_pelajaran->mata_pelajaran_kode?></h3>
                            <h4><?php echo $mata_pelajaran->mata_pelajaran_nama  ?></h4>
                        </div>
                        <div class="icon">
                            <i class="fa fa-fw fa-server"></i>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
    </div>
</section>