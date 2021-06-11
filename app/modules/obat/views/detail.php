  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Data Obat
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class='row'>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-pills"></i>
                  <?php echo $mo_nama; ?>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-8">Nomor barcode <a href="" onclick="printBarcode()"><i class="fas fa-print"></i></a></dt>
                  <dd class="col-sm-12 text-center" id="imgbarcode"><p style="text-align: center;"><img class="img" src="<?php echo base_url('assets/barcode/barcode.php?codetype=codabar&print=false&size=35&sizefactor=3&text=').$mo_barcode;?>'"><br/><strong style="letter-spacing: 4px;"><?php echo $mo_barcode; ?></strong></p></dd>
                  <dt class="col-sm-8">Penyimpanan</dt>
                  <dd class="col-sm-8"><?php echo $mo_penyimpanan; ?></dd>
                  <dt class="col-sm-8">Kategori</dt>
                  <dd class="col-sm-8"><?php echo $mk_nama; ?></dd>
                  <dt class="col-sm-8">Pajak</dt>
                    <?php
                      $a = "";
                      if($mo_ppn_10 == 1){
                        $a = "checked";
                      }
                    ?>
                    <dd class="col-sm-8">
                      <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                          <input type="checkbox" class="custom-control-input" id="switchPPN" onclick="ubah_ppn()" <?php echo $a;?>>
                          <label class="custom-control-label" for="switchPPN">PPN 10%</label>
                        </div>
                      </div>
                    </dd>
                  <dt class="col-sm-8">Deskripsi</dt>
                  <dd class="col-sm-8"><?php echo $mo_deskripsi; ?>
                  </dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                <i class="fas fa-file-medical"></i>
                Stok Obat</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                <div id="accordion">
                  Berikut adalah Stok Obat ini berdasarkan Tanggal Kadaluarsa.
                  <!-- blok data stok -->
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div><!-- /.row -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    
    function printBarcode(){
      var barcode = document.getElementById('imgbarcode');
      var print = window.open();
      print.document.write('<html><head><style>@page { size: auto;  margin: 0mm;}</style></head><body style="float: left;">');
      print.document.write(barcode.innerHTML);
      print.document.write('</body></html>');
      print.document.close();
      
      setTimeout(function() {
        print.focus();
        print.print();
        print.close();
      }, 100);
      
    }

    function ubah_ppn(){
      $.ajax({
        url: "<?php echo site_url('Obat/ajax_ubah_ppn_10/') . $mo_id . ""; ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {

          if (data.status) //if success close modal and reload ajax table
          {
            popup('Informasi', 'Berhasil!');
            setTimeout(function (){
              window.location.reload();
              }, 2000);

          } else {
            popup('Perhatian', 'Gagal mengubah status PPN!', 'info');
            
          }
        }
      });
    }

    $(document).ready(function() {

      $.ajax({
        url: "<?php echo site_url('Obat/ajax_stok_obat_by_id/') . $mo_id . ""; ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          i = 0;
          $.each(data.data, function(index, val) {

            i++;
            update = '';
            if (val[4]) {
              a = 'danger';
              b = 'Obat Kadaluarsa!';
              update = 'disabled';
            } else {
              if (val[6] == 'Ok') {
                a = 'primary';
                b = val[5] + ' hari sebelum kadaluarsa.';
              } else {
                a = 'warning';
                b = val[5] + ' hari sebelum kadaluarsa.';
              }
            }
            $('#accordion').append('<div class="card card-' + a + '"><div class="card-header"><h4 class="card-title w-100"><a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse' + i + '" aria-expanded="false">' + val[1] + '</a></h4></div><div id="collapse' + i + '" class="collapse" data-parent="#accordion" style=""><div class="card-body"><div class="row" style="text-align:center;"><div class="col-sm-12"><h4>' + val[2] + '</h4><h6>' + val[7] + '</h6></div></div><div class="col-sm-12">' + b + '</div><div class="col-sm-12">Harga Jual <b> Rp. '+val[9].toLocaleString()+'</b></div><div class="col-sm-12">Disuplai oleh <b>'+val[10]+'</b></div><hr noshade/><a href="<?php echo base_url();?>obat/input_stock/<?php echo $mo_id;?>?tbid='+val[3]+'" class="btn btn-block bg-gradient-success btn-sm"' + update + '>Ubah Stok</a><a href="<?php echo base_url();?>obat/input_stock/<?php echo $mo_id;?>?tipe=pengurangan&tbid='+val[3]+'" class="btn btn-block bg-gradient-danger btn-sm">Hapus Stok</a></div></div></div>')
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });

    });
  </script>