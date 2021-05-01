  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Cari Produk
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card lg-md-2 p-2">
            <div class="row">
            <input type="text" class="col-6 m-2" name="inputbar" value="" placeholder="Scan barcode atau input nama produk di sini." required/>
            <span style="width:10px;display: block;"></span>
            <button class="btn btn-block btn-xs btn-success col-2 m-2" onclick="cari()">Cari</button>
          </div>
        </div>
        <div class="card lg-md-2 p-2">
          <div class="card-header text-right">
            <div class="btn-group">
              <button class="btn btn-sm btn-default" onclick="clearTabelPencarian()"><i class="fas fa-retweet"></i> Reset</button>
            </div>
          </div>
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-12">
                  <table id="tabelpencarian" class="table table-bordered table-hover dataTable dtr-inline">
                    <thead>
                      <tr>
                        <th class="text">Nama</th>
                        <th class="text">Tanggal Kadaluarsa</th>
                        <th class="text">Stok</th>
                        <th class="text">Harga</th>
                      </tr>
                    </thead>
                    <tbody id="bodypencarian">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    function clearTabelPencarian(){
      $("#bodypencarian tr").remove();
    }

    $(document).ready(function(){
      //do something
    });

    function cari(){
      clearTabelPencarian()
      var bodypencarian = document.getElementById('bodypencarian');
      var par = document.querySelector('[name="inputbar"]').value;
      if(/^\s*$/.test(par)){
        console.log('param null');
      }else{
        $.ajax({
          url: "<?php echo site_url('kasir/cari_data/'); ?>"+par,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if(data.status){
              // cycle through the array for each of the presidents
              for (var i = 0; i < data.data.length; ++i) {
                // keep a reference to an individual president object
                var dat = data.data[i];

                // create a row element to append cells to
                var row = document.createElement('tr');

                // properties of the array elements
                var properties = ['nama', 'tgl_kadaluarsa', 'stok', 'harga'];

                // append each one of them to the row in question, in order
                for (var j = 0; j < properties.length; ++j) {
                  // create new data cell for names
                  var cell = document.createElement('td');
                  // set name of property using bracket notation (properties[j] is a string,
                  // which can be used to access properties of president)
                  cell.innerHTML = dat[properties[j]];
                  if(j == properties.length - 1){
                  }
                  // add to end of the row
                  row.appendChild(cell);
                }
              bodypencarian.appendChild(row);
              }
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
          }
        });
      }
    }

  </script>
