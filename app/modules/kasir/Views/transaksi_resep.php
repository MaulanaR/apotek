  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Tebus Resep
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
                    <button type="button" id="btn-cari" class="btn btn-success btn-flat" onclick="cari()">Cari</button>
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
                        <th class="text">Item ID</th>
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
            <h7>Kode Transaksi : <b><?php echo $uniqid; ?></b></h7>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="card col-md-8" style="border: none;">
                  <form action="#">
                    <div>
                      <div class="form-group">
                      <label>Instansi Penerbit Resep</label>
                      <input type="text" name="namaPenerbit" class="form-control form-control-border" placeholder="Nama Instansi Penerbit Resep" name="total" required="">
                      </div>
                      <div class="form-group">
                      <label>Nama Dokter</label>
                      <input type="text" name="namaDokter" class="form-control form-control-border" placeholder="Nama Instansi/Dokter Penerbit Resep" name="total" required="">
                      </div>
                      <div class="form-group">
                      <label>Tanggal Resep</label>
                        <input type="date" name="tanggalResep" class="form-control form-control-border">
                      </div>
                      <div class="form-group">
                      <label>Apoteker</label>
                      <select name="apoteker" class='form-control' required="">
                  <?php
                    foreach ($this->db->get('m_apoteker')->result() as $key => $value) {
                    echo '<option value="' . $value->ma_id . '">' . $value->ma_nama.'</option>';
                     }
                    ?>
                </select>
                      </div>
                    </div>
                  </form>
                  <table id="table" class="table table-bordered table-hover dataTable dtr-inline">
                    <thead>
                      <tr>
                        <th class="text">Item ID</th>
                        <th class="text">Nama</th>
                        <th class="text">Jumlah</th>
                        <th class="text">PPN <small>10%</small></th>
                        <th class="text">Sub Total</th>
                        <th class="text-center"></th>
                      </tr>
                    </thead>
                    <tbody id="bodykeranjang">
                    </tbody>
                  </table>
                </div>
                <div class="card col-md-4" style="border: none;">
                  <form action="#">
                  <div>
                    <div class="form-group">
                      <label>Total</label>
                      <input type="text" class="form-control form-control-border" placeholder="RP. 000.000,00" name="total" readonly>
                    </div>
                    <div class="form-group">
                      <label>Total PPN</label>
                      <input type="text" class="form-control form-control-border" placeholder="RP. 000.000,00" name="ppn" readonly> 
                    </div>
                    <dv class="form-group text-center">
                
                      <h7><b>GRAND TOTAL</b></h7>
                      <h5 id='grandtotal'>Rp. 000.000,00</h5>
                    </dv>
                    <div class="form-group">
                      <label>Nominal Pembayaran</label>
                      <input type="number" class="form-control form-control-border" min="0" placeholder="RP. 000.000,00" name="nominal_bayar" onkeyup="hitungBayar()"> 
                    </div>
                    <div class="form-group">
                      <label>Kembalian</label>
                      <input type="text" class="form-control form-control-border" placeholder="RP. 000.000,00" name="nominal_kembalian"> 
                    </div>
                  </div>
                  <div id="checkoutWrapper" class="col-12 text-center">
                  <a id="checkoutButton" class="btn btn-app btn-warning" onclick="checkout()">
                  <i class="fas fa-check"></i> Checkout
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

  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="#" id="formdebit" class="form-horizontal" name="formnih">
        <div class="modal-header">
          <h3 class="modal-title">Bayar dengan Debit/Kredit</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body form">
            <div class="form-body">
              <div class="form-group">
                <label class="control-label ">Due</label>
                <input type="text" name="amount_due" class="form-control" placeholder="Rp. 000,00" disabled="">
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <label class="control-label ">Akun Bank</label>
                <select name="akun" class='form-control'>
                  <?php
                    foreach ($this->db->get('m_akun_bank')->result() as $key => $value) {
                    echo '<option value="' . $value->mab_id . '">Bank ' . $value->mab_bank . ' a/n '.$value->mab_nama_nasabah.' '.$value->mab_nomor_rekening.'</option>';
                     }
                    ?>
                </select>
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <label class="control-label ">Nomor Referensi Pembayaran</label>
                <input type="text" id="ref" name="ref" class="form-control" value="" required="">
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnSave" class="btn btn-primary">Proses</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
      </form>
    </div><!-- /.modal-dialog -->
  </div>
  <!-- / Modal -->

  <script type="text/javascript">
    var kode_inv = '<?php echo $uniqid; ?>';
    var availRek = '<?php echo $avail_rek; ?>';
    var datacari = [];
    var arraybeli = [];
    var bodypencarian = document.getElementById('bodypencarian');
    var bodykeranjang = document.getElementById('bodykeranjang');
    var total;
    var grandtotal;
    var n_ppn;
    var bayar;
    var kembalian;
    var cantCheckout = false;
    var tipePembayaran = 0;//tipe pembayaran sealau cash kecuali diubah oleh proses
    var noRef = null;//no ref selalu null kecuali diubah oleh proses
    var mabId = null;//mabId selalu null kecuali diubah oleh proses
    var status = false;
    var penerbit;
    var dokter;
    var tanggalResep;
    var apoteker;

    $(document).ready(function(){
      //do something
      $("[name='nominal_bayar']").attr('disabled', true);
      $("[name='nominal_kembalian']").attr('disabled', true);
      $("#formdebit").submit(function(e) {
            e.preventDefault();
            proses('debit');
        });
      $("#ref").on({
        keydown: function(e) {
          if (e.which === 32)
            return false;
        },
        change: function() {
          this.value = this.value.replace(/\s/g, "");
        }
        });
    });

    $("#inputbar").on('keypress', function(e) {
      if (e.which == 13) {
        // alert('You pressed enter!');
        e.preventDefault();
        cari();
      }
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

    function rupiah(x){
      var z = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(x);
      return z;
    }

    function hitungBayar(){
      bayar = $("[name='nominal_bayar']").val();
      kembalian = bayar - grandtotal;
      $('[name="nominal_kembalian"]').val(rupiah(kembalian));
    }

    function cari(){
      clearTabelPencarian();
      var bodypencarian = document.getElementById('bodypencarian');
      var par = document.querySelector('[name="inputbar"]').value;
      if(/^\s*$/.test(par)){
        console.log('param null');
      }else{
        $.ajax({
          url: "<?php echo site_url('kasir/cari_data_resep/'); ?>"+par,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if(data.status){
              datacari = data.data;
              // cycle through the array for each of the presidents
              for (var i = 0; i < data.data.length; ++i) {
                var dat = data.data[i];
                var row = document.createElement('tr');

                var cel = document.createElement('td');
                  cel.innerHTML = dat['tb_id'];                
                  row.appendChild(cel);
                var inv = document.createElement('input');
                  inv.name = 'tb_id'+i;
                  inv.type = 'hidden';
                  inv.value = dat.tb_id;
                  // add to end of the row
                  cel.appendChild(inv);
                var inv2 = document.createElement('input');
                  inv2.name = 'mo_id' + i;
                  inv2.type = 'hidden';
                  inv2.value = dat.mo_id;
                  // add to end of the row
                  cel.appendChild(inv2);

                var inv3 = document.createElement('input');
                  inv3.name = 'ppn_item' + i;
                  inv3.type = 'hidden';
                  inv3.value = dat.mo_ppn_10;
                  // add to end of the row
                  cel.appendChild(inv3);

                var properties = ['nama', 'tgl_kadaluarsa', 'stok', 'harga'];
                for (var j = 0; j < properties.length; ++j) {
                  var cell = document.createElement('td');
                  cell.innerHTML = dat[properties[j]];
                  if(j == properties.length - 1){
                  }
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
            }else{
              console.log(par);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
          }
        });
      }
    }

  function tambahkan(x){
    var status_ppn = document.querySelector('[name="ppn_item' + x + '"]').value;
    var jumlah = document.querySelector('[name="jumlahobat'+x+'"]').value;
    var xarray = datacari[x];
    var cek;
    var index;
    xarray.jumlah = jumlah;//tambah jumlah ke array obat yang dipilih
    var ppn = 0;
      if(status_ppn == 1){
        ppn = parseInt(xarray.harga) * 0.1;//dikali 10%
      }
    xarray.ppn_item = ppn;
    xarray.ppn_status = status_ppn;
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

  function buang(x){
    arraybeli.splice(x, 1);
    hitungTotal();
    refreshKeranjang();
  }

  function refreshKeranjang(){
    clearTabelKeranjang();
    var total;
    for (var i = 0; i < arraybeli.length; ++i) {
                var dat = arraybeli[i];
                var row = document.createElement('tr');
                var cell = document.createElement('td');
                  cell.innerHTML = dat['tb_id'];                
                  row.appendChild(cell);
                var cell1 = document.createElement('td');
                  cell1.innerHTML = dat['nama'];                
                  row.appendChild(cell1);
                var cell2 = document.createElement('td');
                  cell2.innerHTML = dat['jumlah'];
                  row.appendChild(cell2);
                var cell5 = document.createElement('td');
                  cell5.innerHTML = dat['jumlah'] * dat['ppn_item'];
                  row.appendChild(cell5);
                var cell3 = document.createElement('td');
                  total = dat['jumlah'] * dat['harga'];
                  cell3.innerHTML = rupiah(total);
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
    var temp2 = 0;
    var total_ppn = 0;
    var temp = 0;
    var ppn = 0.1;
    total = 0;
    for(var i = 0; i < arraybeli.length; i++){
        temp2 = (parseInt(arraybeli[i]['jumlah']) * parseInt(arraybeli[i]['ppn_item'])) + total_ppn;
        total_ppn = temp2;
        total = (parseInt(arraybeli[i]['jumlah']) * parseInt(arraybeli[i]['harga'])) + temp;
        temp = total;
    }
    $('[name="total"]').attr('value', rupiah(total));

    n_ppn = total_ppn;
    $('[name="ppn"]').attr('value', rupiah(n_ppn));

    grandtotal = total + n_ppn;
    document.getElementById('grandtotal').innerHTML = rupiah(grandtotal);
  }

  function checkout(){
    $.ajax({
        url: "<?php echo base_url('kasir/ajax_checkout') ?>",
        type: "POST",
        data: {data : arraybeli},
        dataType: "JSON",
        success: function(data) {

          if (data.status) //if success close modal and reload ajax table
          {
            var isi = data.data;
            console.log(isi);
            isi.forEach(cekArrayBeli);
            prosesCheckout();

          } else {
            alert('Ajax error!');
          }
        }
      });
  }

  function tombolProses(){
      $('#checkoutButton').remove();
      $('#checkoutWrapper').append('<a id="checkoutButton" class="btn btn-app btn-warning" onclick="batal()"><i class="fa fa-undo"></i> Batalkan</a><a id="prosesButton" class="btn btn-app btn-warning" onclick="proses(\'cash\')"><i class="fas fa-check"></i> Bayar</a><hr/><b>Cashless :</b><br/><a id="debitButton" class="btn btn-app" onclick="showFormDebit()"><i class="fas fa-credit-card"></i> Debit/Kredit</a>');
  }
  
  function cekArrayBeli(item, index, arr){
    if(item.statusitem == false){
      alert("Stok tidak mencukupi untuk item : "+item.nama);
      cantCheckout = true;
    }
  }

  function prosesCheckout(){
    if(cantCheckout == true){
      alert("Cannot Proceed");
      cantCheckout = false; 
    }else{
      $("[name='nominal_bayar']").attr('disabled', false);
      clearTabelPencarian();
      $("#btn-cari").attr('disabled', true);
      tombolProses(true);
    }
  }

  function validateForm(){
    /***** VARIABEL TRANSAKSI RESEP *****/
    var statusForm = false;
    penerbit = document.querySelector('[name="namaPenerbit"]').value;
    dokter = document.querySelector('[name="namaDokter"]').value;
    tanggalResep = document.querySelector('[name="tanggalResep"]').value;
    apoteker = document.querySelector('[name="apoteker"]').value;
    if(penerbit == ''){
      alert('Instansi Penerbit resep belum diisi!');
    }else if(dokter == ''){
      alert('Nama Dokter belum diisi!');
    }else if(tanggalResep == ''){
      alert('Tanggal resep belum dipilih!');
    }else if(apoteker == ''){
      alert('Apoteker belum dipilih!');
    }else{
      statusForm = true;
    }
    return statusForm;
  }

  function prosesBayar(){
    
    var x = validateForm();
    if(x){
      var dataPembelian = {'kode_inv' : kode_inv,
       'subtotal' : total,
       'ppn_nilai' : n_ppn,
       'grandtotal' : grandtotal,
       'nominal_bayar' : bayar,
       'nominal_kembalian' : kembalian,
       'tipe_pembayaran' : tipePembayaran,
       'no_ref_pembayaran' : noRef,
       'mab_id' : mabId,
       'resep' : 1, //ini adalah transaksi resep
       'penerbit' : penerbit,
       'dokter' : dokter,
       'resep_tgl' : tanggalResep,
       'ma_id' : apoteker,
     };

      console.log(arraybeli);
      var x = JSON.stringify(dataPembelian);
      var y = JSON.stringify(arraybeli);

      $.ajax({
          url: "<?php echo base_url('kasir/save_transaksi') ?>",
          type: "POST",
          data: {data : x, item : y},
          dataType: "JSON",
          success: function(data) {

            if (data.status) //if success exit
            {
              popup('Informasi', 'Berhasil');
              setTimeout(function (){
                exit();
              }, 1000);
            } else {
             popup('Perhatian', data.msg, 'info');
            }
          }
        });
    }
  }

  function showFormDebit(){
    if(availRek){
        $('[name="amount_due"]').val(grandtotal);
        $('#modal_form').modal('show');
      }else{
        popup('Perhatian', 'Belum ada akun yang terdaftar!', 'info');
      }
  }

  function proses(con){
    if (confirm('Psoses Transaksi ?')) {
      if(con == 'cash'){
        bayar = document.querySelector('[name="nominal_bayar"]').value;
        if(bayar < grandtotal){
          popup('Perhatian', 'Pembayaran Kurang!', 'info');
        }else{
          prosesBayar();
        }
      }else if(con == 'debit'){
        kembalian = 0;
        tipePembayaran = 1;
        bayar = grandtotal;
        noRef = document.querySelector('[name="ref"]').value;
        mabId = document.querySelector('[name="akun"]').value;
        prosesBayar();
      }
    }

  }

  function exit(){
    window.location = '<?php echo base_url('kasir/invoice_detail/'); ?>'+kode_inv;
  }

  function batal(){
    location.reload();
  }
  </script>
