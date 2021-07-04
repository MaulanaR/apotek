<!-- Product Alus Solution Licenced PHP Script -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?php echo base_url('assets/logo/askrindo-mini.png'); ?>" type="image/gif" sizes="20x20">
  <title>Login | <?php echo $this->alus_auth->name_application();?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Font Awesome -->
  <!-- Icon Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/temaalus/img/favicon.png">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/plugins/iCheck/square/blue.css">
  <!-- toasty notif -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/temaalus/dist/css/toasty.css" >

  <style type="text/css">
  .cover{
    background: rgba(147,206,222,1);
    background-size: cover;
  }
  </style>
</head>

<body class="hold-transition login-page cover">
<div class="card">
    <div class="card-body login-card-body">
      <img src="<?php echo base_url('assets/logo').'/'.$this->db->get('setting_app')->row()->app_logo;?>" class="p-3" style="width: 100%; align:center">
      <p class="mt-2 text-center" style="font-weight:bold"><?php echo $this->db->get('setting_app')->row()->app_nama;?></p>
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="<?php echo base_url('admin/Login/login'); ?>" method="post" id="form">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="identity">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="button" class="btn btn-primary btn-block" id="submitform">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/jquery.cookie.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- maul login -->
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/m_login.js"></script>
<!-- Toasty Notif -->
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/toasty.js"></script>
</body>
</html>
