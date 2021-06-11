<script src="<?php echo base_url('assets/temaalus/dist/currencyjs/autoNumeric.js'); ?>"></script>
  
  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <!-- Content Header (Page header) -->
    <section class="content-header text-right">
      <h1 id="clock">
        <?php echo date("Y-m-d H:i:s"); ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="card col-md-8 m-2">
          <div class="card-header text-left">
            <p>Selamat datang dan selamat bekerja <b><?php echo $this->session->userdata('username') ?></b>!</p>
          </div>
          <div class="card-body">
            <a class="btn btn-app bg-success" href="<?php echo base_url('kasir/transaksi'); ?>">
              <i class="fas fa-laptop-medical"></i> Transaksi Baru
            </a>
            <a class="btn btn-app bg-primary" href="<?php echo base_url('kasir/transaksi_resep'); ?>">
              <i class="fas fa-notes-medical"></i>Tebus Resep
            </a>
            <a class="btn btn-app bg-secondary" href="<?php echo base_url('kasir/cari_produk'); ?>">
              <i class="fas fa-barcode"></i>Cek Produk
            </a>
            <a class="btn btn-app bg-secondary" href="<?php echo base_url('kasir/cari_produk'); ?>">
              <i class="fas fa-outdent"></i>Retur Transaksi
            </a>
          </div>
        </div>
        <div class="card col-md-3 m-2" alt="Max-width 100%">
          <div class="card-header text-center">
            <h7><b>Saldo</b>
            </h7>
          </div>
          <div class="card-body">
            <div class="text-center">
              <?php
              if ($this->session->userdata('sesi_saldo')) { ?>
                <h5><b>Rp. <span id="saldox"><?php echo $this->session->userdata('sesi_saldo'); ?></span></b></h5>

              <?php } else {
                // do something when doesn't exist
                echo "Belum Mulai Sesi";
              }
              ?>
            </div>
            <hr />
            <div class="text-center">
              <button class="btn btn-sm btn-danger" onclick="end_sesi()"><i class="fas fa-sign-out-alt"></i> Akhiri Shift</button>
            </div>
          </div>
        </div>
        <div class="card col-12 m-2">
          <div class="card-header text-left">
            <h7>Transaksi pada sesi ini :</h7>
          </div>
          <div class="card-body">
            <div class="row">
              <div class='col-md-8 m-2'>
                <table id="tabelTransaksi" class="table table-bordered table-hover dataTable dtr-inline" >
                  <thead>
                    <tr>
                      <th class="text">ID</th>
                      <th class="text">Invoice ID</th>
                      <th class="text">Item</th>
                      <th class="text">Total</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="bodyTransaksi">
                    
                  </tbody>
                </table>
              </div>
              <div class="col-md-3 m-2">
                <div class="form-group">
                  <form action="#">
                    <label for="inputCariInvoice">Cari Invoice</label>
                    <input type="text" class="form-group" id="inputCariInvoice" name="cariInvoice" required="">
                    <button class="btn btn-sm btn-success" onclick="cariTransaksi()">
                    <strong><i class="fa fa-search" aria-hidden="true"></i> Cari</strong>
                    </button>
                  </form>
                </div>
              </div>
            </div><!-- /.row -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <script>
    function checkTime(i) {
      if (i<10) {
        i = "0" + i;
      }
      return i;
    }
    function startTime() {
      var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      var Y = today.getFullYear();
      var mt = today.getMonth();
      var d = today.getDate();
      var dnow = today.getDay();
      var dname = days[dnow];
      // add a zero in front of numbers<10
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById("clock").innerHTML = dname + " " + d + "/" + mt + "/" + Y + " " + h + ":" + m + ":" + s;
      t = setTimeout(function(){ startTime() }, 500);
    }

    $(document).ready(function() {

      startTime();
      //datatables
      table = $('#tabelTransaksi').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        scrollX: true,
        scroller: true,
        stateSave: true,
        searchDelay: 3050,

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo base_url('kasir/ajax_transaksi_sesi') ?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [{
          "targets": [1, 2, 3], //last column
          "orderable": true, //set not orderable
          "className": "text-center",
        }, ],
        "lengthMenu": [
          [10, 25, 100, 1000, -1],
          [10, 25, 100, 1000, "All"]
        ],
      });

    });

  $("#saldox").autoNumeric('init');
    function end_sesi() {
      var r = confirm("Apakah anda yakin ingin menyelesaikan sesi saat ini?");
      if (r == true) {
        $.ajax({
          type: "GET",
          url: "<?php echo base_url(); ?>kasir/end_sesi",
          success: function(response) {
            location.reload();
          }
        });
      } else {
        popup('Info','Dibatalkan','info');
      }
    }

  function cariTransaksi(){
    var par = document.querySelector('[name="cariInvoice"]').value;
      if(/^\s*$/.test(par)){
        console.log('param null');
      }else{
        $.ajax({
          url: "<?php echo site_url('kasir/cari_data_invoice/'); ?>"+par,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if(data.status){
                window.location.replace("<?php echo base_url('kasir/invoice_detail/'); ?>"+par);
              }else{
                popup('Info', data.msg, 'info');
                window.location.replace("<?php echo base_url('kasir/'); ?>");
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
          }
        });
      }
  }
  </script>
  <!-- /.content-wrapper -->