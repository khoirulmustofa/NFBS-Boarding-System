<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form role="form" action="<?php echo $action ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Kode Mata Pelajaran</label>
                            <?php echo form_error('mata_pelajaran_kode') ?>
                            <input type="text" name="mata_pelajaran_kode" class="form-control" value="<?php echo $mata_pelajaran_kode; ?>" placeholder="Masukan Kode Mata Pelajaran ...">
                        </div>
                        <div class="form-group">
                            <label>Nama Mata Pelajaran</label>
                            <?php echo form_error('mata_pelajaran_nama') ?>
                            <input type="text" name="mata_pelajaran_nama" class="form-control" value="<?php echo $mata_pelajaran_nama; ?>" placeholder="Masukan Nama Mata Pelajaran ...">
                        </div>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-default" href="<?php echo site_url('mata_pelajaran') ?>">Batal</a>
                        <button type="submit" class="btn btn-success pull-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>