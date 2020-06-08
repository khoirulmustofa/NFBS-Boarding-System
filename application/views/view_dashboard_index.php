<section class="content">
    <div class="row">
        <section class="col-lg-12 connectedSortable">
            <?php if ($this->session->userdata('success_message') != '') { ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p><?php echo $this->session->userdata('success_message') ?></p>
                </div>
            <?php } ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header"><i class="fa fa-fw fa-bar-chart"></i> Absensi Pelajaran Kelas 7A</li>
                </ul>
                <div class="tab-content table-responsive">
                    <div id="graph_7a"></div>
                </div>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header"><i class="fa fa-fw fa-bar-chart"></i> Absensi Pelajaran Kelas 7B</li>
                </ul>
                <div class="tab-content table-responsive">
                    <div id="graph_7b"></div>
                </div>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header"><i class="fa fa-fw fa-bar-chart"></i> Absensi Pelajaran Kelas 7C</li>
                </ul>
                <div class="tab-content table-responsive">
                    <div id="graph_7c"></div>
                </div>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header"><i class="fa fa-fw fa-bar-chart"></i> Absensi Pelajaran Kelas 7D</li>
                </ul>
                <div class="tab-content table-responsive">
                    <div id="graph_7d"></div>
                </div>
            </div>
        </section>
    </div>
</section>