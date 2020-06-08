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
                        <label>Email</label>
                        <?php echo form_error('users_email') ?>
                        <input type="text" name="users_email" class="form-control" value="<?php echo $users_email; ?>" placeholder="Masukan Email ...">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <?php echo form_error('users_nama_lengkap') ?>
                        <input type="text" name="users_nama_lengkap" class="form-control" value="<?php echo $users_nama_lengkap; ?>" placeholder="Masukan Nama Lengkap ...">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <?php echo form_error('users_password') ?>
                        <input type="password" name="users_password" class="form-control" placeholder="Masukan Password ...">
                    </div>
                    <div class="form-group">
                        <label>Verifikasi Password</label>
                        <?php echo form_error('ulangi_users_password') ?>
                        <input type="password" name="ulangi_users_password" class="form-control" placeholder="Masukan Ulangi Password ...">
                    </div>                    
                    <div class="form-group">
                        <label>Status</label>
                        <?php echo form_error('users_status') ?>
                        <select name="users_status" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="Y" <?php echo $users_status == "Y" ? "selected" : "" ?>>Aktif</option>
                            <option value="N" <?php echo $users_status == "N" ? "selected" : "" ?>>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="users_id" value="<?php echo $users_id?>">
                    <a class="btn btn-default" href="<?php echo site_url('users') ?>">Batal</a>
                    <button type="submit" class="btn btn-success pull-right">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>