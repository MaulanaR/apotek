  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Transaksi baru
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card lg-md-2 px-2">
          <form action="#">
            <div class="row">
              <div class="input-group">
                  <input type="text" class="form-control" name="inputbar" placeholder="Scan barcode atau input nama produk di sini." />
                  <span class="input-group-append">
                    <button type="button" class="btn btn-success btn-flat" onclick="cari()">Cari</button>
                  </span>
                </div>
            </div>
          </form>
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
                        <th class="text">Nama Obat</th>
                        <th class="text">Tanggal Kadaluarsa</th>
                        <th class="text">Stok</th>
                        <th class="text">Harga</th>
                        <th class="text">Jumlah Pembelian</th>
                        <th class="text-center"></th>
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
        <div class="card lg-md-2 p-2">
          <div class="card-header">
            <h7>Transaksi No: <b>FCA54Y7E</b></h7>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-8">
                  <table id="table" class="table table-bordered table-hover dataTable dtr-inline">
                    <thead>
                      <tr>
                        <th class="text">Nama Obat</th>
                        <th class="text">Jumlah</th>
                        <th class="text">Sub Total</th>
                        <th class="text-center"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>fake data</td>
                        <td>20 Unit</td>
                        <td>1.000.000</td>
                        <td class="text-center"><button class="btn  btn-xs btn-danger">Cancel</button></td>
                      </tr>
                      <tr>
                        <td>fake data</td>
                        <td>20 Unit</td>
                        <td>1.000.000</td>
                        <td class="text-center"><button class="btn  btn-xs btn-danger">Cancel</button></td>
                      </tr>
                      <tr>
                        <td>fake data</td>
                        <td>20 Unit</td>
                        <td>1.000.000</td>
                        <td class="text-center"><button class="btn  btn-xs btn-danger">Cancel</button></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-4">
                  <form action="#">
                  <div>
                    <div class="form-group">
                      <label>Total</label>
                      <input type="text" class="form-control form-control-border" placeholder="RP. 000.000,00">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="customCheckbox3">
                          <label for="customCheckbox3" class="custom-control-label">PPN 10%</label>
                        </div>
                    </div>
                    <dv class="form-group text-center">
                
                      <h7><b>GRAND TOTAL</b></h7>
                      <h5>Rp. 000.000,00</h5>
                    </dv>
                    <div class="form-group">
                      <label>Jumlah Bayar</label>
                      <input type="number" min="1" class="form-control rounded-0" placeholder="0000000" required>
                    </div>
                    <div class="form-group">
                      <label>Kembalian</label>
                      <input type="number" min="1" class="form-control rounded-0" placeholder="0000000" required>
                    </div>
                  </div>
                  <div class="col-12">
                  <a class="btn btn-app btn-warning">
                  <i class="fas fa-edit"></i> Batalkan tansaksi
                  </a>
                  <a class="btn btn-app btn-success">
                  <i class="fas fa-edit"></i> Bayar
                  </a>
                  </div>
                  </form>
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
    var datacari = [{
        nama: 'Fake obat',
        tgl_kadaluarsa: '10-10-2021',
        stok: '200',
        harga: '50000'
      },{
        nama: 'Fake obat 2',
        tgl_kadaluarsa: '10-10-2030',
        stok: '50',
        harga: '25000'
      }];
    var tabelpencarian = document.getElementById('tabelpencarian');
    var bodypencarian = document.getElementById('bodypencarian');

    $(document).ready(function(){
      //do something
    });


    function clearTabelPencarian(){
      $("#bodypencarian tr").remove();
    }

    function enableTambahkan(x){
      var j = document.querySelector('[name="jumlahobat'+x+'"]').value;
      if(j > 0){
        $("[name='tambahkan"+x+"'").attr('disabled', false);
      }
    }

    function cari(){
      clearTabelPencarian();

      // cycle through the array for each of the presidents
      for (var i = 0; i < datacari.length; ++i) {
        // keep a reference to an individual president object
      var data = datacari[i];

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
        cell.innerHTML = data[properties[j]];
        if(j == properties.length - 1){
        }
        // add to end of the row
        row.appendChild(cell);
      }
      var cell2 = document.createElement('td');
      cell2.classList.add("text-center");
      var jumlah = document.createElement('input');
          jumlah.type = "number";
          jumlah.min = "1";
          jumlah.name = "jumlahobat"+i;
          jumlah.classList.add('col-4');
          jumlah.setAttribute('onchange', 'enableTambahkan(\"'+i+'\")');
          cell2.appendChild(jumlah);
          row.appendChild(cell2);
      var cell3 = document.createElement('td');
      cell3.classList.add("text-center");
      var button = document.createElement('button');
          button.name = 'tambahkan'+i;
          button.classList.add('addbtn');
          button.classList.add('btn');
          button.classList.add('btn-xs');
          button.classList.add('btn-primary');
          button.setAttribute('onclick', 'tambahkan('+i+')');
          button.setAttribute('disabled', true);
          var tulisan = "Tambahkan ";
          button.innerHTML = tulisan;
          cell3.appendChild(button);
          row.appendChild(cell3);

    // add new row to table
    bodypencarian.appendChild(row);

    }
  }

  function tambahkan(x){
    var jumlah = document.querySelector('[name="jumlahobat'+x+'"]').value;
    var xarray = datacari[x];
    xarray.jumlah = jumlah;//tambah jumlah ke array obat yang dipilih
    console.log(xarray);
    clearTabelPencarian();
  }
  </script>
