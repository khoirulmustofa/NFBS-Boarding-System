<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <?php
                $attribute = array('role' => 'form');
                echo form_open($action, $attribute);
                ?>
                <div class="box-body">
                    <div class="form-group">
                        <label>Hak Akses</label>
                        <?php echo form_error('hak_akses_nama') ?>
                        <input type="text" name="hak_akses_nama" class="form-control" value="<?php echo $hak_akses_nama; ?>" placeholder="Masukan Hak Akses ...">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <?php echo form_error('hak_akses_keterangan') ?>
                        <input type="text" name="hak_akses_keterangan" class="form-control" value="<?php echo $hak_akses_keterangan; ?>" placeholder="Masukan Keterangan ...">
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="hak_akses_id" value="<?php echo $hak_akses_id ?>">
                    <a class="btn btn-default" href="<?php echo site_url('hak_akses') ?>">Batal</a>
                    <button type="submit" class="btn btn-success pull-right">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>