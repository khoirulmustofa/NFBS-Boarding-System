<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($this->session->userdata('success_message') != '') { ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $this->session->userdata('success_message') ?></h4>
                </div>
            <?php } ?>
            <?php if ($this->session->userdata('error_message') != '') { ?>
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> <?php echo $this->session->userdata('error_message') ?></h4>
                </div>
            <?php } ?>
            <div class="box box-primary">
                <div class="box-header">
                    <form role="form" action="<?php echo $action ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Hak Akses</label>
                                <?php echo form_error('hak_akses_id') ?>
                                <select name="hak_akses_id" class="form-control">
                                    <option value="">-- Pilih Hak Akses --</option>
                                    <?php foreach ($hak_akses_data as $hak_akses) { ?>
                                        <option value="<?php echo $hak_akses->hak_akses_id ?>"><?php echo $hak_akses->hak_akses_nama ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />
                            <a class="btn btn-default" href="<?php echo site_url('users') ?>">Batal</a>
                            <button type="submit" class="btn btn-success pull-right">Tambah</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table id="table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hak Akses</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $start = 0; ?>
                            <?php foreach ($hak_akses_users_id_data as $data) { ?>
                                <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $data->hak_akses_nama ?></td>
                                    <td><?php echo $data->hak_akses_keterangan ?></td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" href="<?php echo site_url('users/hapus_hak_akses/') . $data->users_hak_akses_id ?>" data-confirm='Anda yakin akan menghapus <?php echo $data->hak_akses_nama ?>'>Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>