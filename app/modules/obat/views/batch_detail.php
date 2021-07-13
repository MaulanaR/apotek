  <?php
    $d = 'Nonaktif';
    if($toggle_status){$a = 'checked';$d = 'Aktif';}
    if($toggle_stok){$b = 'disabled'; $c = "<div class='callout callout-warning'>Stok Belum Kosong!</div>";}
  ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Batch Detail
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-12 card-body">
                  <table class="table table-hovered" border="1px" style="width: 50%;">
                    <tr>
                      <td class="bg-olive" style="width: 50%;">Batch ID</td>
                      <td id="info_tb_id"><?php echo $tb_id; ?></td>
                    </tr>
                    <tr>
                      <td class="bg-olive" style="width: 50%;">Expired</td>
                      <td id="info_expired"><?php echo $tb_tgl_kadaluarsa; ?></td>
                    </tr>
                    <tr>
                      <td class="bg-olive" style="width: 50%;">Nama Obat</td>
                      <td id="info_nama"><?php echo $mo_nama; ?></td>
                    </tr>
                    <tr>
                      <td class="bg-olive" style="width: 50%;">Deskripsi Obat</td>
                      <td id="info_desk"><?php echo $mo_deskripsi; ?></td>
                    </tr>
                    <tr>
                      <td class="bg-olive" style="width: 50%;">Supplier</td>
                      <td id="info_kategori"><?php echo $ms_nama; ?></td>
                    </tr>
                    <tr>
                      <td class="bg-olive" style="width: 50%;">Stok Tersedia</td>
                      <td id="info_satuan"><?php echo $stok." ".$mu_nama; ?></td>
                    </tr>
                </table>
                </div>
                <div class="col-12">
                  <div class="card-header">
                    <div style="width:50%" class="text-left">
                      <h4>Nonaktifkan Batch</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                          <input type="checkbox" class="custom-control-input" id="switchPPN" onclick="ubah_status()" <?php echo $a." ".$b;?>>
                          <label class="custom-control-label" for="switchPPN"><?php echo $d;?></label> <small><i class="fa fa-question-circle" aria-hidden="true" onclick="toogleInfo()"></i></small>
                        </div><?php echo $c;?>
                        <div class="callout callout-info" id="nonaktifInfo" style="height:1px;opacity: 0;">
                          <p>Harap Diperhatikan!</p>
                          <p>Apabila anda menonaktifkan batch ini, maka :</p>
                          <p>1. Batch ini tidak akan digunakan untuk operasi apapun.</p>
                          <p>2. Batch ini tidak bisa ditambah stoknya sebelum diaktifkan kembali.</p>
                          <p>3. Batch ini hanya dapat diakses melalui daftar Obat Nonaktif.</p>
                          <p>Untuk menonaktifkan batch, jumlah stok pada batch ini harus 0 (kosong).</p>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="card-header">
                      <div style="width:50%" class="text-left">
                      <h4>Batch History</h4>
                      </div>
                      <div class="row">
                      <div class="col-md-4">
                      <div class="form-group">
                        <label for="tglAwal">Dari</label><input type="date" id="tglAwal" name="tglAwal" class="form-control" required="">
                      </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="tglAkhir">Sampai</label><input type="date" id="tglAkhir" name="tglAkhir" class="form-control" required="">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="btnTampil" style="display:block;height:24px;"></label><button id="btnTampil" name="btnTampil" class="btn btn-md btn-default" onclick="fetchData()"> Lihat Data </button>
                        </div>
                      </div>
                      </div>
                  </div>
                  <div class="card-body">
                  <table id="tablehistory" class="table table-bordered table-hover" style="width:100%;display: none">
                    <thead>
                      <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text">Tanggal</th>
                        <th class="text">Masuk</th>
                        <th class="text">Keluar</th>
                        <th class="text">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody id='listdata'>
                      <tr>
                        <td colspan="5" class="text-center">No Data</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <!--Modal -->

  <script type="text/javascript">
    var tb_id = '<?php echo $tb_id; ?>';
    var mo_id = '<?php echo $mo_id; ?>';
    var tablehistory = document.getElementById('tablehistory');
    var listdata = document.getElementById('listdata');

    $(document).ready(function() {
      $("#nonaktifInfo").click(function(){
        $(this).animate({'height': '1px', 'opacity': '0'}, 100);
      });
    });

    function fetchData(){
      if(checkForm()){
      $.ajax({
        url: "<?php echo base_url('Obat/ajax_batch_history') ?>",
        type: "POST",
        data: {
          id: tb_id,
          tglAwal: $("#tglAwal").val(),
          tglAkhir: $("#tglAkhir").val()
        },
        dataType: "JSON",
        success: function(data) {
          listdata.innerHTML = '';
          for(var i = 0; i < data.length; i++){
            var d = data[i];
            var row = document.createElement('tr');

            var cel1 = document.createElement('td');
            cel1.innerHTML = i + 1;
            row.append(cel1);
            var cel = document.createElement('td');
            cel.innerHTML = d.tgl;
            row.append(cel);
            var cel2 = document.createElement('td');
            cel2.innerHTML = d.tj_masuk;
            row.append(cel2);
            var cel3 = document.createElement('td');
            cel3.innerHTML = d.tj_keluar;
            row.append(cel3);
            var cel4 = document.createElement('td');
            cel4.innerHTML = d.tj_keterangan;
            row.append(cel4);

            listdata.append(row);
          }
          tablehistory.style.display = 'block';
        }
      });
      }
    }

    function checkForm(){
      var a = $("#tglAwal").val();
      var b = $("#tglAkhir").val();
      if(a){
        if(b){
          return true;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

    function toogleInfo(){
        $("#nonaktifInfo").animate({'height': '100%', 'opacity': '1'}, 100);
    }

    function ubah_status(){
      if(confirm('Anda Yakin untuk mengubah status Batch Ini ?')){
      $.ajax({
        url: "<?php echo site_url('Obat/ajax_ubah_status_batch/') . $tb_id . ""; ?>",
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
            popup('Perhatian', 'Gagal mengubah status Batch!', 'info');
            
          }
        }
      });
      }
    }
  </script>