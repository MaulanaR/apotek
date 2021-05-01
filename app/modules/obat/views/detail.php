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
                  <i class="fas fa-text-width"></i>
                  <?php echo $mo_nama . " " . $mo_id; ?>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-8">Nomor barcode</dt>
                  <dd class="col-sm-8"><?php echo $mo_barcode; ?></dd>
                  <dt class="col-sm-8">Penyimpanan</dt>
                  <dd class="col-sm-8"><?php echo $mo_penyimpanan; ?></dd>
                  <dt class="col-sm-8">Kategori</dt>
                  <dd class="col-sm-8"><?php echo $mk_nama; ?></dd>
                  <dt class="col-sm-8">Deskripsi</dt>
                  <dd class="col-sm-8"><?php echo $mo_deskripsi; ?>
                  </dd>
                </dl>
                <button type="button" class="btn btn-block bg-gradient-success btn-sm">Edit</button><button type="button" class="btn btn-block bg-gradient-danger btn-sm">Hapus</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Stok Obat</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                <div id="accordion">
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
            if (val[4] == 'true') {
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
            $('#accordion').append('Berikut adalah Stok Obat ini berdasarkan Tanggal Kadaluarsa.<div class="card card-' + a + '"><div class="card-header"><h4 class="card-title w-100"><a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse' + i + '" aria-expanded="false">' + val[1] + '</a></h4></div><div id="collapse' + i + '" class="collapse" data-parent="#accordion" style=""><div class="card-body"><div class="row" style="text-align:center;"><div class="col-sm-12"><h4>' + val[2] + '</h4><h6>' + val[7] + '</h6></div></div><div class="col-sm-12">' + b + '</div><div class="col-sm-12">Harga Jual <b> Rp. '+val[9].toLocaleString()+'</b></div><div class="col-sm-12">Disuplai oleh <b>'+val[10]+'</b></div><hr noshade/><a href="<?php echo base_url();?>obat/input_stock/<?php echo $mo_id;?>?tbid='+val[3]+'" class="btn btn-block bg-gradient-success btn-sm"' + update + '>Ubah Stok</a><a href="<?php echo base_url();?>obat/input_stock/<?php echo $mo_id;?>?tipe=pengurangan&tbid='+val[3]+'" class="btn btn-block bg-gradient-danger btn-sm">Hapus Stok</a></div></div></div>')
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });

    });
  </script>