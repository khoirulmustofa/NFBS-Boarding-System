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
                                <label>Mata Pelajaran</label>
                                <?php echo form_error('mata_pelajaran_id') ?>
                                <?php echo cmb_dinamis_double('mata_pelajaran_id', 'mata_pelajaran', 'mata_pelajaran_kode', 'mata_pelajaran_nama', 'mata_pelajaran_id', $mata_pelajaran_id, '-- Pilih Mata Pelajaran --');   ?>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <?php echo form_error('kelas_id') ?>
                                <?php echo cmb_dinamis('kelas_id', 'kelas', 'kelas_nama', 'kelas_id', $kelas_id, '-- Pilih Kelas --');   ?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="guru_id" value="<?php echo $guru_id; ?>" />
                            <a class="btn btn-default" href="<?php echo site_url('guru') ?>">Batal</a>
                            <button type="submit" class="btn btn-success pull-right">Tambah</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table id="table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pelajaran</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $start = 0; ?>
                            <?php foreach ($mape_kelas_data as $data) { ?>
                                <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $data->mata_pelajaran_kode ?></td>
                                    <td><?php echo $data->mata_pelajaran_nama ?></td>
                                    <td><?php echo $data->kelas_nama ?></td>
                                    <td>
                                        <?php if ($data->mata_pelajaran_guru_kelas_status == 'Y') { ?>
                                            <a class="btn btn-success btn-sm">Aktif</a>
                                        <?php } else { ?>
                                            <a class="btn btn-danger btn-sm">Tidak Aktif</a>
                                        <?php } ?>
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