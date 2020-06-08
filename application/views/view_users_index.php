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
                    <div class="row">
                        <div class="col-md-1">
                            <a class="btn btn-success" href="<?php echo site_url('users/create') ?>">Tambah</a>
                        </div>
                        <div class="col-md-7">

                        </div>
                        <div class="col-md-4 text-right">
                            <form action="<?php echo site_url('users'); ?>" class="form-inline" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cari" value="<?php echo $cari; ?>">
                                    <span class="input-group-btn">
                                        <?php
                                        if ($cari != '') {
                                        ?>
                                            <a href="<?php echo site_url('users'); ?>" class="btn btn-default">Reset</a>
                                        <?php
                                        }
                                        ?>
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nama Lengkap</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users_data as $data) { ?>
                                <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $data->users_email ?></td>
                                    <td><?php echo $data->users_nama_lengkap ?></td>
                                    <td>
                                        <?php if ($data->users_status == 'Y') { ?>
                                            <a class="btn btn-success btn-sm">Aktif</a>
                                        <?php } else { ?>
                                            <a class="btn btn-danger btn-sm">Tidak Aktif</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="<?php echo site_url('users/hak_akses/') . $data->users_id ?>">Hak Akses</a>
                                        <a class="btn btn-info btn-sm" href="<?php echo site_url('users/update/') . $data->users_id ?>">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="<?php echo site_url('users/delete/') . $data->users_id ?>" data-confirm='Anda yakin akan menghapus data Mata Pelajaran <?php echo $data->users_nama_lengkap ?>'>Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="col-md-6">
                        <p>Total Record : <?php echo $total_rows ?></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>