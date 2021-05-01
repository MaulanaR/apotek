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
          <form>
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
                        <th class="text">Nama</th>
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
                    <tbody id="bodykeranjang">
                    </tbody>
                  </table>
                </div>
                <div class="col-4">
                  <form action="#">
                  <div>
                    <div class="form-group">
                      <label>Total</label>
                      <input type="text" class="form-control form-control-border" placeholder="RP. 000.000,00" name="total" readonly>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="customCheckbox3">
                          <label for="customCheckbox3" class="custom-control-label">PPN 10%</label>
                        </div>
                    </div>
                    <dv class="form-group text-center">
                
                      <h7><b>GRAND TOTAL</b></h7>
                      <h5 id='grandtotal'>Rp. 000.000,00</h5>
                    </dv>
                  </div>
                  <div class="col-12 text-center">
                  <a class="btn btn-app btn-warning">
                  <i class="fas fa-edit"></i> Checkout
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
    var datacari = [];
    var arraybeli = [];
    var bodypencarian = document.getElementById('bodypencarian');
    var bodykeranjang = document.getElementById('bodykeranjang');
    var total;
    var grandtotal;

    $(document).ready(function(){
      //do something
    });


    function clearTabelPencarian(){
      $("#bodypencarian tr").remove();
    }
    function clearTabelKeranjang(){
      $("#bodykeranjang tr").remove();
    }

    function enableTambahkan(x){
      var j = document.querySelector('[name="jumlahobat'+x+'"]').value;
      if(j > 0){
        $("[name='tambahkan"+x+"'").attr('disabled', false);
      }
    }

    function cari(){
      clearTabelPencarian();
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
              datacari = data.data;
              // cycle through the array for each of the presidents
              for (var i = 0; i < data.data.length; ++i) {
                var dat = data.data[i];
                var row = document.createElement('tr');
                var properties = ['nama', 'tgl_kadaluarsa', 'stok', 'harga'];

                for (var j = 0; j < properties.length; ++j) {
                  var cell = document.createElement('td');
                  cell.innerHTML = dat[properties[j]];
                  if(j == properties.length - 1){
                  }
                var inv = document.createElement('input');
                  inv.name = 'tb_id'+i;
                  inv.type = 'hidden';
                  inv.value = dat.tb_id;
                  // add to end of the row
                  cell.appendChild(inv);
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
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
          }
        });
      }
    }

  function tambahkan(x){
    var jumlah = document.querySelector('[name="jumlahobat'+x+'"]').value;
    var xarray = datacari[x];
    var cek;
    var index;
    xarray.jumlah = jumlah;//tambah jumlah ke array obat yang dipilih
    var tb_id = document.querySelector('[name="tb_id'+x+'"]').value;
    for(var i = 0; i < arraybeli.length; i++){
      if(arraybeli[i]['tb_id'] === tb_id){
      //cek apakah sudah ada item yang sama dalam array
        cek = 'ada';
        index = i;
      }
    }
    if(cek == 'ada'){
      //jika ada
      arraybeli[index]['jumlah'] = parseInt(arraybeli[index]['jumlah']) + parseInt(jumlah);//tambah jumlah
    }else{//jika item baru
      arraybeli.push(xarray);//tambah item ke array
    }
    clearTabelPencarian();
    console.log(arraybeli);
    refreshKeranjang();
    hitungTotal();  
  }

  function refreshKeranjang(){
    clearTabelKeranjang();
    var total;
    for (var i = 0; i < arraybeli.length; ++i) {
                var dat = arraybeli[i];
                var row = document.createElement('tr');
                var cell1 = document.createElement('td');
                  cell1.innerHTML = dat['nama'];                
                  row.appendChild(cell1);
                var cell2 = document.createElement('td');
                  cell2.innerHTML = dat['jumlah'];
                  row.appendChild(cell2);
                var cell3 = document.createElement('td');
                  total = dat['jumlah'] * dat['harga'];
                  cell3.innerHTML = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(total);
                row.appendChild(cell3);
                var cell4 = document.createElement('td');
                  cell4.classList.add("text-center");
                var button = document.createElement('button');
                    button.name = 'tambahkan'+i;
                    button.classList.add('addbtn');
                    button.classList.add('btn');
                    button.classList.add('btn-xs');
                    button.classList.add('btn-danger');
                    button.setAttribute('onclick', 'buang('+i+')');
                var tulisan = "Cancel";
                    button.innerHTML = tulisan;
                    cell4.appendChild(button);
                    row.appendChild(cell4);
                    // add new row to table
                    bodykeranjang.appendChild(row);
              }
  }

  function hitungTotal(){
    var temp = 0;
    for(var i = 0; i < arraybeli.length; i++){
        total = (parseInt(arraybeli[i]['jumlah']) * parseInt(arraybeli[i]['harga'])) + temp;
        temp = total;
    }
    $('[name="total"]').attr('value', new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(total));
    document.getElementById('grandtotal').innerHTML = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(total);
  }
  
  </script>
