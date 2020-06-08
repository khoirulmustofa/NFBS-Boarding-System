<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page ?> | NFBS Bogor</title>
  <meta name="theme-color" content="#3c8dbc" />
  <link rel="shortcut icon" href="<?php echo site_url('public/dist/img/favicon-16x16.png') ?>" />
  <script type="text/javascript">
    let base_url = '<?php echo site_url(); ?>'
  </script>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo site_url('public') ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo site_url('public') ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo site_url('public') ?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo site_url('public') ?>/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo site_url('public') ?>/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo site_url('public') ?>/dist/css/custom.css">
  <?php include('load_css.php') ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav fixed"> 
  <div class="wrapper">
    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <a href="<?php echo site_url() ?>" class="navbar-brand">
              NFBS Bogor</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="<?php echo $menu == "Dashboard" ? "active" : ""; ?>"><a href="<?php echo site_url() ?>">Dashboard</a></li>
              <li ><a href="#"><?php echo sesi_tahfidz()." | ".date('H') ?></a></li>
              <li class="dropdown <?php echo $menu == "Master" ? "active" : ""; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo site_url('users') ?>">Pengguna</a></li>
                  <li><a href="<?php echo site_url('hak_akses') ?>">Hak Akses</a></li>
                  <li><a href="<?php echo site_url('guru') ?>">Guru</a></li>
                  <li><a href="<?php echo site_url('mata_pelajaran') ?>">Mata Pelajaran</a></li>
                  <li><a href="<?php echo site_url('siswa') ?>">Siswa</a></li>
                  <li><a href="<?php echo site_url('mushrif_tahfidz') ?>">Mushrif Tahfidz</a></li>
                </ul>
              </li>
              <li class="dropdown <?php echo $menu == "Pesantren" ? "active" : ""; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pesantren<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo site_url('tahfidz') ?>">Tahfidz</a></li>
                </ul>
              </li>
              <li class="dropdown <?php echo $menu == "Sekolah" ? "active" : ""; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sekolah<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo site_url('absensi_pelajaran') ?>">Pelajaran</a></li>
                </ul>
              </li>
              <li class="dropdown <?php echo $menu == "Report" ? "active" : ""; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Report<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Report Absensi Sholat Subuh</a></li>
                  <li><a href="#">Report Absensi Apel Pagi</a></li>
                  <li><a href="<?php echo site_url('report/absensi_pelajaran') ?>">Report Absensi Pelajaran</a></li>
                  <li><a href="#">Report Ansensi Sholat Magrib</a></li>
                  <li><a href="<?php echo site_url('report/absensi_tahfidz') ?>">Report Absensi Tahfidz</a></li>
                  <li><a href="<?php echo site_url('report/tahfidz') ?>">Report Tahfidz</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Notifications Menu -->
              <li class="dropdown tasks-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  <li>
                    <!-- Inner menu: contains the tasks -->
                    <ul class="menu">
                      <li>
                        <!-- Task item -->
                        <a href="#">
                          <!-- Task title and progress text -->
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <!-- The progress bar -->
                          <div class="progress xs">
                            <!-- Change the css width attribute to simulate progress -->
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php echo site_url('public') ?>/dist/img/avatar_man.png" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $this->session->userdata('users_nama_lengkap'); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?php echo site_url('public') ?>/dist/img/avatar_man.png" class="img-circle" alt="User Image">

                    <p>
                      <?php echo $this->session->userdata('users_nama_lengkap'); ?>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo site_url('logout') ?>" class="btn btn-default btn-flat">Keluar</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
      </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
      <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $page ?>
          </h1>
        </section>

        <!-- Main content -->
        <?php echo $contents ?>

        <!-- /.content -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="container">
        <div class="pull-right hidden-xs">
          Page rendered in <strong>{elapsed_time}</strong> seconds. <strong>Developed By LRC NFBS Bogor</strong>
        </div>
        <strong>Copyright &copy; <?php echo date('Y') ?> <a href="#">NFBS Bogor</a></strong>

      </div>
      <!-- /.container -->
    </footer>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 3 -->
  <script src="<?php echo site_url('public') ?>/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo site_url('public') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?php echo site_url('public') ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo site_url('public') ?>/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo site_url('public') ?>/dist/js/adminlte.min.js"></script>
  <script src="<?php echo site_url('public') ?>/build/js/bootstrap-notify.min.js"></script>
  <script src="<?php echo site_url('public') ?>/custom/confirmation.js"></script>
  <?php include('load_js.php') ?>
</body>

</html>