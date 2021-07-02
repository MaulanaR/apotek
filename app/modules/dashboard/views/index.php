  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="col-lg-12 col-xl-2">
                <div class="card mb-2">
                  <img class="card-img-top" src="<?php echo base_url('assets/logo/front_panel_background.png'); ?>" alt="Selamat Datang">
                  <div class="card-img-overlay">
                    <h1 class="card-title text-white">Selamat datang pengguna.</h1>
                    <p class="card-text pb-1 pt-1 text-white">
                      <?php echo $this->alus_auth->name_application();?> menyediakan fungsi dan fasilitas <br>
                      untuk memudahkan manajemen <br/>dan memenuhi kebutuhan apotek anda.
                    </p>
                  </div>
                </div>
              </div>
          <div class="row">
          <div class="card col-md-6 m-2">
            <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-pills"></i>
                  Daftar Obat Hampir Kadaluarsa
                </h3>
            </div>
            <div class='card-body'>
              <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Expired Date</th>
                </tr>
                </thead>
                <tbody id='listhampir'>
                  <tr>
                    <td colspan="3" align="center" class="temp">Tidak Ada Data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card col-md-5 m-2">
            <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-pills"></i>
                  Daftar Obat Kadaluarsa
                </h3>
            </div>
            <div class='card-body'>
              <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Expired Date</th>
                </tr>
                </thead>
                <tbody id='listkadaluarsa'>
                  <tr>
                    <td colspan="3" align="center" class="temp">Tidak Ada Data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
  </div>
  <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    var listkadaluarsa = document.getElementById('listkadaluarsa');
    var listhampir = document.getElementById('listhampir');

    $(document).ready(function() {
      cekKadaluarsa();
    });

    function cekKadaluarsa(){
      $.ajax({
        url: "<?php echo base_url('Dashboard/ajax_cek_kadaluarsa_all'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          console.log(data.status);
          if(data.status){
            var totalitem = 0;
           if(data.statuskd){ 
            var dat = data.datakd;
            for (var i = 0; i < dat.length; ++i) {
              var x = dat[i];
              var temp = totalitem + parseInt(x[2]);
              totalitem = temp;
            }
            showNotif(2, 'Ada '+totalitem+' obat kadaluarsa!');
            appendToTable(data.datakd, 'kd');
            }
           if(data.statushr){
            showNotif(1, 'Ada obat hampir kadaluarsa');
            appendToTable(data.datahr, 'hr');
            }
          }
        }
      });
    }

    function appendToTable(data, table){
      var t;
      var limit = 5;//limit jumlah data yang ditampilkan
      var x = limit;
      if(table == 'kd'){
        t = listkadaluarsa;
      }else if(table == 'hr'){
        t = listhampir;
      }
      t.innerHTML = '';
      if(data.length < limit) x = data.length;
      for (var i = 0; i < x; ++i) {
        var dat = data[i];
        var row = document.createElement('tr');

        var cel = document.createElement('td');
            cel.innerHTML = i+1;
            row.appendChild(cel);
        var cel2 = document.createElement('td');
            cel2.innerHTML = '<a href=" <?php echo base_url('obat/detail');?>/'+dat[7]+'">'+dat[0]+'</a>';
            row.appendChild(cel2);
        var cel3 = document.createElement('td');
            cel3.innerHTML = dat[1];
            row.appendChild(cel3);
        t.appendChild(row);
      }
    }

    function showNotif(a,b){
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
      switch(a) {
        case 0:
          toastr.success(b);
          break;
        case 1:
          toastr.warning(b);
          break;
        case 2:
          toastr.error(b);
          break;
        case 3:
          toastr.info(b);
          break;
        default:
          // code block
      }
    }

  </script>
