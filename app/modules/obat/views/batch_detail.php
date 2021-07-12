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
                      <h4>Batch History</h4>
                      </div>
                      <div style="width:50%" class="text-right">
                        <button class="btn btn-sm btn-default" onclick="fetchData()"> Lihat Data </button>
                      </div>
                  </div>
                  <div class="card-body">
                    
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

    function fetchData(){
      $.ajax({
        url: "<?php echo base_url('Obat/ajax_batch_history') ?>",
        type: "POST",
        data: {
          id: tb_id
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
  </script>