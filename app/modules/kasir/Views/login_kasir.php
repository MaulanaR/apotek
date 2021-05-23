<script src="<?php echo base_url('assets/temaalus/dist/currencyjs/autoNumeric.js'); ?>"></script>
  
  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Main content -->
      <section class="content">
        <div class="row align-items-center" style="min-height:600px;">
        <div class="col-md-12" >
          <form action="#">
            <div class="card col-md-5 card-info mx-auto" style="padding-left: 0px;padding-right: 0px;">
              <div class="card-header">
                <h3 class="card-title">Mulai Sesi</h3>
              </div>
              <div class="card-body">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" placeholder="password" id="pass">
                </div>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp.</span>
                  </div>
                  <input type="text" class="form-control" min='1000' placeholder="Saldo" id="saldo">
                  <!-- <div class="input-group-append">
                    <span class="input-group-text">,00</span>
                  </div> -->
                </div>
                <hr />
                <div class="input-group text-center">
                  <button type="button" class="btn btn-primary btn-block" onclick="go_login()"><i class="fa fa-sign-in" aria-hidden="true"></i> Mulai Sesi</button>
                </div>

                <!-- /input-group -->
              </div>
              <!-- /.card-body -->
            </div>
          </form>
        </div>
      </div>
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">

    $(document).ready(function(){
      //do something
      $("#saldo").autoNumeric('init');
    });

    function go_login() {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>kasir/cek_login",
        data: {'pass' : $("#pass").val(), 'saldo' : $("#saldo").val()},
        dataType: "json",
        success: function (response) {
          if(response.status)
          {
            window.location.href = "<?php echo base_url();?>kasir/";
          }else{
            popup_reload('Peringatan',response.msg,'error');
          }
        }
      });
    }

  </script>
