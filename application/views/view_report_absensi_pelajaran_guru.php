<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($this->session->userdata('error_message') != '') { ?>
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p><?php echo $this->session->userdata('error_message') ?></p>
                </div>
            <?php } ?>
            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">
                        <form action="<?php echo site_url('report/absensi_pelajaran_guru_kelas') ?>" method="get">
                            <input type="hidden" name="kode_mapel_guru" class="form-control pull-right" value="<?php echo $kode_mapel_guru ?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Mulai</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tgl_mulai" value="<?php echo $tgl_mulai ?>" class="form-control pull-right" id="tgl_mulai" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Sampai</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tgl_akhir" value="<?php echo $tgl_akhir ?>" class="form-control pull-right" id="tgl_akhhir" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class=" btn btn-primary" name="proses" type="submit" value="proses">Proses</button>
                                <?php if ($data_absensi_pelajaran->num_rows() >= 0) { ?>
                                    <button class=" btn btn-success" name="download_excel" value="download_excel" type="submit"><i class="fa fa-fw fa-file-excel-o"></i> Download Excel</button>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if ($data_absensi_pelajaran->num_rows() > 0) { ?>
                    <div class="callout callout-success">
                        <h4><i class="icon fa fa-fw fa-table"></i>Laporan Absensi Pelajaran <?php echo $mata_pelajaran_nama ?> Kelas <?php echo $kelas_nama ?>, Periode <?php echo tgl_indo(date_to_eng($tgl_mulai)) ?> Sampai <?php echo tgl_indo(date_to_eng($tgl_akhir)) ?></h4>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th>7</th>
                                    <th>8</th>
                                    <th>9</th>
                                    <th>10</th>
                                    <th>11</th>
                                    <th>12</th>
                                    <th>13</th>
                                    <th>14</th>
                                    <th>15</th>
                                    <th>16</th>
                                    <th>17</th>
                                    <th>18</th>
                                    <th>19</th>
                                    <th>20</th>
                                    <th>21</th>
                                    <th>22</th>
                                    <th>23</th>
                                    <th>24</th>
                                    <th>25</th>
                                    <th>26</th>
                                    <th>27</th>
                                    <th>28</th>
                                    <th>29</th>
                                    <th>30</th>
                                    <th>31</th>
                                    <th>Hadir</th>
                                    <th>Telat</th>
                                    <th>Sakit</th>
                                    <th>Ijin</th>
                                    <th>Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data_absensi_pelajaran->result() as $data) { ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $data->siswa_NIS ?></td>
                                        <td><?php echo $data->siswa_nama_lengkap ?></td>
                                        <td><?php echo $data->T1 ?></td>
                                        <td><?php echo $data->T2 ?></td>
                                        <td><?php echo $data->T3 ?></td>
                                        <td><?php echo $data->T4 ?></td>
                                        <td><?php echo $data->T5 ?></td>
                                        <td><?php echo $data->T6 ?></td>
                                        <td><?php echo $data->T7 ?></td>
                                        <td><?php echo $data->T8 ?></td>
                                        <td><?php echo $data->T9 ?></td>
                                        <td><?php echo $data->T10 ?></td>
                                        <td><?php echo $data->T11 ?></td>
                                        <td><?php echo $data->T12 ?></td>
                                        <td><?php echo $data->T13 ?></td>
                                        <td><?php echo $data->T14 ?></td>
                                        <td><?php echo $data->T15 ?></td>
                                        <td><?php echo $data->T16 ?></td>
                                        <td><?php echo $data->T17 ?></td>
                                        <td><?php echo $data->T18 ?></td>
                                        <td><?php echo $data->T19 ?></td>
                                        <td><?php echo $data->T20 ?></td>
                                        <td><?php echo $data->T21 ?></td>
                                        <td><?php echo $data->T22 ?></td>
                                        <td><?php echo $data->T23 ?></td>
                                        <td><?php echo $data->T24 ?></td>
                                        <td><?php echo $data->T25 ?></td>
                                        <td><?php echo $data->T26 ?></td>
                                        <td><?php echo $data->T27 ?></td>
                                        <td><?php echo $data->T28 ?></td>
                                        <td><?php echo $data->T29 ?></td>
                                        <td><?php echo $data->T30 ?></td>
                                        <td><?php echo $data->T31 ?></td>
                                        <td><?php echo $data->total_hadir ?></td>
                                        <td><?php echo $data->total_telat ?></td>
                                        <td><?php echo $data->total_sakit ?></td>
                                        <td><?php echo $data->total_ijin ?></td>
                                        <td><?php echo $data->total_absen ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>