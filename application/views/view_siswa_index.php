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
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-1">
                            <a class="btn btn-success" href="<?php echo site_url('siswa/create') ?>">Tambah</a>
                        </div>
                        <div class="col-md-7">

                        </div>
                        <div class="col-md-4 text-right">
                            <form action="<?php echo site_url('siswa'); ?>" class="form-inline" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cari" value="<?php echo $cari; ?>">
                                    <span class="input-group-btn">
                                        <?php
                                        if ($cari != '') {
                                        ?>
                                            <a href="<?php echo site_url('siswa'); ?>" class="btn btn-default">Reset</a>
                                        <?php
                                        }
                                        ?>
                                        <button class="btn btn-primary" type="submit">Search</button>
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
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($siswa_data as $data) { ?>
                                <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $data->siswa_NIS ?></td>
                                    <td><?php echo $data->siswa_NISN ?></td>
                                    <td><?php echo $data->siswa_nama_lengkap ?></td>
                                    <td><?php echo $data->kelas_nama ?></td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="<?php site_url('siswa/update/') . $data->siswa_NIS ?>">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="<?php site_url('siswa/delete/') . $data->siswa_NIS ?>" data-confirm='Anda yakin akan menghapus data Mata Pelajaran <?php echo $data->siswa_nama ?>'>Hapus</a>
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
    </div>
</section>