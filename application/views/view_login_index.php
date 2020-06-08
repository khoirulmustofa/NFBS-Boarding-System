<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | NFBS Bogor</title>
    <meta name="theme-color" content="#3c8dbc" />
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
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo site_url('public') ?>/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo site_url() ?>">NFBS Bogor</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <?php if ($this->session->userdata('error_message') != '') { ?>
                <div class="callout callout-warning">
                    <p><?php echo $this->session->userdata('error_message') ?></p>
                </div>
            <?php } ?>
            <?php if ($this->session->userdata('success_message') != '') { ?>
                <div class="callout callout-success">
                    <p><?php echo $this->session->userdata('success_message') ?></p>
                </div>
            <?php } ?>
            <?php
            $attribute = array();
            echo form_open('login/action_login', $attribute);
            ?>
            <div class="form-group has-feedback">               
                <input class="form-control" placeholder="Masukan Email ..." name="users_email" type="email" value="<?php echo $users_email ?>" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <?php echo form_error('users_email') ?>
            </div>
            <div class="form-group has-feedback">
                <input class="form-control" placeholder="Masukan Password ..." name="users_password" type="password" value="<?php echo $users_password ?>">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php echo form_error('users_password') ?>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <?php echo form_checkbox('remember', TRUE, $remember) ?> Ingat Saya
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
                </div>
                <!-- /.col -->
            </div>
            <?php echo form_close() ?>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?php echo site_url('public') ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo site_url('public') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo site_url('public') ?>/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
</body>

</html>