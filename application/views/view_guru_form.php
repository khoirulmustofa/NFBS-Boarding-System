<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form role="form" action="<?php echo $action ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label>NIP</label>
                            <?php echo form_error('NIP') ?>
                            <input type="text" name="NIP" class="form-control" value="<?php echo $NIP; ?>" placeholder="Masukan NIP ...">
                        </div>
                        <div class="form-group">
                            <label>Pengguna</label>
                            <?php echo form_error('guru_id') ?>
                            <?php echo cmb_dinamis('users_id', 'auth_users', 'users_nama_lengkap', 'users_id', $users_id, "-- Pilih Pengguna --"); ?>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <?php echo form_error('guru_status') ?>
                            <select name="guru_status" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                <option value="Y" <?php echo $guru_status == "Y" ? "selected" : "" ?>>Aktif</option>
                                <option value="N" <?php echo $guru_status == "N" ? "selected" : "" ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="guru_id" value="<?php echo $guru_id ?>">
                        <a class="btn btn-default" href="<?php echo site_url('guru') ?>">Batal</a>
                        <button type="submit" class="btn btn-success pull-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>