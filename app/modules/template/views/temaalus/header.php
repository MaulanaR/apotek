<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php echo $this->alus_auth->description_application();?>">
  <meta name="keywords" content="<?php echo $this->alus_auth->keyword_application();?>">
  <meta name="author" content="<?php echo $this->alus_auth->author_application();?>">
  
  <link rel="icon" href="<?php echo base_url('assets/logo/askrindo-mini.png'); ?>" type="image/gif" sizes="20x20">
  <title><?php echo $title; ?> | <?php echo $this->alus_auth->name_application();?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/plugins/datatables-scroller/css/scroller.bootstrap4.min.css">

  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/dist/css/AdminLTE.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/temaalus/plugins/summernote/summernote-bs4.css">
  <!-- alert -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.min.css">


  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/temaalus/dist/css/bootstrap-datetimepicker.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/plugins/bootstrap-select/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/temaalus/dist/css/bank_indonesia.css">
  <link href="<?php echo base_url(); ?>assets/toastr/toastr.css" rel="stylesheet"/>

  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/jQuery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/temaalus/dist/js/jquery.cookie.js"></script>
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/datatables-scroller/js/scroller.bootstrap4.min.js"></script>
  <!-- alert -->
  <script src="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/highcharts/highcharts.js"></script>
  <script src="<?php echo base_url(); ?>assets/highcharts/modules/series-label.js"></script>
  <script src="<?php echo base_url(); ?>assets/highcharts/modules/exporting.js"></script>
  <script src="<?php echo base_url(); ?>assets/highcharts/modules/export-data.js"></script>
  <script src="<?php echo base_url(); ?>assets/highcharts/modules/accessibility.js"></script>
  <script src="<?php echo base_url(); ?>assets/toastr/toastr.min.js"></script>

<style>
#loading {
  display: none; /* Hidden by default */
  position: fixed; /* Fixed/sticky position */
  bottom: 20px; /* Place the button at the bottom of the page */
  right: 30px; /* Place the button 30px from the right */
  z-index: 99; /* Make sure it does not overlap */
  border: 1px solid grey; /* Remove borders */
  outline: none; /* Remove outline */
  background-color: white; /* Set a background color */
  color: white; /* Text color */
  cursor: pointer; /* Add a mouse pointer on hover */
  padding: 10px; /* Some padding */
  border-radius: 10px; /* Rounded corners */
  font-size: 15px; /* Increase font size */
  color:#494E54;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
</head>


<body class="hold-transition sidebar-mini layout-fixed <?php if($this->db->get('setting_app')->row()->sidebar == 1){echo 'sidebar-collapse';};?>" id="bodyhtml" >
<div class="wrapper">
<div id="loading" title="Go to top"><span class="spinner-border text-primary spinner-border-sm"></span> Loading..</div> 
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <?php if($this->alus_auth->in_group('admin')){?> 
      <li class="nav-item dropdown">
        <a class="btn btn-sm btn-block btn-outline-success" href="<?php echo base_url('setting');?>">
          Setting
        </a>
      </li>&nbsp;
      <?php } ?>
      <li class="nav-item dropdown">
        <a class="btn btn-sm btn-block btn-outline-info" href="<?php echo base_url('user_profile');?>">
          Profile
        </a>
      </li>&nbsp;
      <li class="nav-item dropdown">
        <a class="btn btn-sm btn-block btn-outline-danger" href="<?php echo base_url('admin/login/logout');?>">
          Logout
        </a>
      </li>
    </ul>
  </nav>

   <aside class="main-sidebar sidebar-dark-warning elevation-4">
    <a href="<?php echo base_url();?>" class="brand-link">
      <img src="<?php echo base_url('assets/logo').'/'.$this->db->get('setting_app')->row()->app_logo;?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $this->db->get('setting_app')->row()->app_nama;?></span>
    </a>
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if(file_exists("./assets/avatar/".$this->session->userdata('avatar'))){?>
          <img src="<?php echo base_url('assets/avatar')."/".$this->session->userdata('avatar');?>" class="img-circle elevation-2" alt="User Image">
          <?php }else{?>
          <img src="<?php echo base_url('assets/avatar');?>/avatar_default.png" class="img-circle elevation-2" alt="User Image">
          <?php }?>
        </div>
        <div class="info">
          <a href="<?php echo base_url('user_profile');?>" class="d-block"><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name') ;?></a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <?php echo $this->Alus_hmvc->get_menu(); ?>
        </ul>
      </nav>
      
      <ul class="sidebar-menu" data-widget="tree">
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

 <script>
    var csrf_nm = '<?php echo $this->config->item("csrf_token_name");?>';
    var csrf_ck = '<?php echo $this->config->item("csrf_cookie_name");?>';
    var loadingx ;
    $.ajaxSetup({
      headers: {
        '<?php echo $this->config->item("csrf_token_name");?>': get_newer()
        },
      beforeSend: function(xhr, settings) {
        //  loadingx = Swal.fire({
        //     position: 'center',
        //     title: 'Loading',
        //     html: '<img src="<?php echo base_url();?>assets/logo/loading.gif">',
        //     showConfirmButton: false,
        //     allowOutsideClick: false
        //   });
          $("#loading").show();

          switch (settings.type) {
            case "POST": settings.data += "&"+csrf_nm+"="+get_newer(); break;
          }
          
          return true;
      },
      complete: function(data)
      {
        // loadingx.close();
        $("#loading").hide();
      },
      error: function()
      {
        console.log('error');
        $("#loading").hide();

        // loadingx.close();
      }
    });

    function get_newer()
    {
      return $.cookie(csrf_ck);
    }

    function popup(judul = null,msg= null, tipe='success', red = false) {
      let timerInterval
      Swal.fire({
        title: judul,
        html: msg+'<br><br><small>Pop Up tertutup otomatis dalam <span></span></small>',
        type: tipe,
        timer: 300000,
        timerProgressBar: true,
        onBeforeOpen: () => {
          timerInterval = setInterval(() => {
            const content = Swal.getContent()
            if (content) {
              const b = content.querySelector('span')
              if (b) {
                b.textContent = Swal.getTimerLeft()
              }
            }
          }, 100)
        },
        onClose: () => {
          clearInterval(timerInterval);
          if(red)
          {
            window.location.href = "<?php echo base_url();?>"+red;
          }
        }
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          if(red)
          {
            window.location.href = "<?php echo base_url();?>"+red;
          }
        }
      })
    }

    function popup_reload(judul = null,msg= null, tipe='success') {
      let timerInterval
          Swal.fire({
            title: judul,
            html: msg+'<br><br><small>Pop Up tertutup otomatis dalam <span></span></small>',
            type: tipe,
            allowOutsideClick: false,
            allowEnterKey: false,
            allowEscapeKey: false,
            timer: 6000,
            timerProgressBar: true,
            onBeforeOpen: () => {
              timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                  const b = content.querySelector('span')
                  if (b) {
                    b.textContent = Swal.getTimerLeft()
                  }
                }
              }, 100)
            },
            onClose: () => {
              clearInterval(timerInterval);
              location.reload();
            }
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              location.reload();
            }
          })
        }
  
    $(function() {
        $('.sel').selectpicker({
          'liveSearch': true
        });
    });
  </script>