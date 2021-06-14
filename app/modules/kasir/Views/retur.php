  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Retur Produk
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card lg-md-2 p-2">
            <div class="row">
            <input type="text" class="col-6 m-2" name="inputbar" value="" placeholder="Scan atau input kode Invoice di sini." required/>
            <span style="width:10px;display: block;"></span>
            <button id="buttonCari" class="btn btn-block btn-xs btn-success col-2 m-2" onclick="cari()">Cari</button>
          </div>
        </div>
        <div class="card lg-md-2 p-2">
          <div class="card-header text-right">
            <div class="btn-group">
              <button class="btn btn-sm btn-default" onclick="reset()"><i class="fas fa-retweet"></i> Reset</button>
            </div>
          </div>
          <div class="card-body" style="width: 100%;height: 100%;overflow: hidden;">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-12">
                  <table id="tabelpencarian" class="table table-bordered table-hover dataTable dtr-inline">
                    <thead id="headpencarian">
                      <tr>
                        <th class="text">Item</small></th>
                        <th class="text">Qty</th>
                        <th class="text">Deskripsi</th>
                        <th class="text" id="headRetur">Retur</th>
                      </tr>
                    </thead>
                    <tbody id="bodypencarian">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div id="proseswrapper" class="card-footer text-center">
            <div class="btn-group">
              <button id="btnproses" class="btn btn-sm btn-primary" onclick="proses()"><i class="fa fa-save"></i> Proses</button>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="" id="bodyinfo" style="height: 0px; overflow: hidden;">
          <div class="card-header">
            <p><H3>Informasi Retur</H3></p>
          </div>
          <div class="card-body">
            <form action="#" id="formretur" class="form-horizontal" name="formnih">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label ">Dari Transaksi : <strong id='kodewrapper'></strong></label>
                                <p>
                                  Per tanggal : <span id='tglwrapper'></span><br>
                                </p>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Total Harga</label>
                                <h5 id='totalwrapper'></h5>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Total PPN</label>
                                <h5 id='totalppnwrapper'></h5>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Grandtotal</label>
                                <h5 id='grandwrapper'></h5>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                  <input type="checkbox" class="custom-control-input" id="ubahppn" onclick="ubah_ppn()">
                                  <label class="custom-control-label" for="ubahppn">Kembalikan PPN</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Nilai Pengembalian Uang</label>
                                <input type="text" name="nilaipengembalian" class="form-control" placeholder="Lokasi Penyimpanan" disabled="">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Keterangan Pengembalian</label>
                                <textarea name="Keterangan" class="form-control" placeholder="Keterangan pengembalian produk"></textarea>
                                <span class="help-block"></span>
                            </div>
                            <!-- input fake resep-->
                            <div class="col-12 pb-3">
                                <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
                                <a class="btn btn-danger" href="#" onclick="reset()">Cancel</a>
                            </div>
                        </div>
                    </form>
          </div>
          <!-- /.card-body -->
        </div>
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    var par;
    var ids;
    var arrayRetur = [];
    var arrayCari = [];
    var tglTransaksi;
    var total;
    var totalppn = 0;
    var grandtotal = 0;
    var nilaipengembalian = 0;
    var ppn_status = true;

    $(document).ready(function(){
      $("#btnproses").attr('disabled', true);
      $("#formretur").submit(function(e) {
        e.preventDefault();
        save_retur();
      });
    });

    function rupiah(x) {
      var z = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
      }).format(x);
      return z;
    }

    function enable(){
      $("#btnproses").attr('disabled', false);
    }

    function removeproseswrapper(){
      $("#proseswrapper").remove();
    }

    function hitung(){
      var temp;
      var temp2;
      var tempppn;
      var tempharga;
      var totalharga = 0;
      var ppn_item;
      for (var i = 0; i < arrayRetur.length; ++i) {
        var dat = arrayRetur[i];
        tempppn = parseInt(dat.ppn_item) * parseInt(dat.qty);
        temp = tempppn + totalppn;
        totalppn = temp;
        tempharga = parseInt(dat.harga) * parseInt(dat.qty);
        temp2 = tempharga + totalharga;
        totalharga = temp2;
      }
      total = totalharga;
      grandtotal = totalharga + totalppn;
      nilaipengembalian = grandtotal;
      $("#kodewrapper").append(par);
      $("#grandwrapper").append(rupiah(grandtotal));
      $("#tglwrapper").append(tglTransaksi);
      $("#totalwrapper").append(rupiah(total));
      $("#totalppnwrapper").append(rupiah(totalppn));
      $('[name="nilaipengembalian"]').val(rupiah(nilaipengembalian));
      if(totalppn > 0){
        $("#ubahppn").attr('checked', true);
      }
    }

    function cari(){
      var bodypencarian = document.getElementById('bodypencarian');
      par = document.querySelector('[name="inputbar"]').value;
      if(/^\s*$/.test(par)){
        popup('Info', 'Masukan Kode Invoice!', 'info');
      }else{
        $.ajax({
          url: "<?php echo site_url('kasir/cari_data_invoice/'); ?>"+par,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if(data.status){
              $("#buttonCari").attr('disabled', true);
              $("[name='inputbar']").attr('disabled', true);
                ids = data.data.ti_id;
                var i = data.data.ti_tgl.split(" ");
                tglTransaksi = i[0];
                generateData();
              }else{
                popup('Info', data.msg, 'info');
                setTimeout(function (){
                  reset();
                }, 1000);
                
              }
            
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
          }
        });
      }
    }
    
    function generateData(){
      $.ajax({
        url: "<?php echo base_url('kasir/ajax_detail_items') ?>",
        type: "POST",
        data: {id : ids},
        dataType: "JSON",
        success: function(data) {

          if (data.status)
          {
            //console.log(data.data);
            arrayCari = data.data;
            var a = 0;
            $.each(data.data, function(index, val) {
              $('#bodypencarian').append('<tr id="row'+a+'"><td>'+val.nama+'</td><td id="inputnumber"><input type="number" class="col-4" name="qty'+a+'" min="1" max="'+val.qty+'" value="'+val.qty+'" required></td><td>'+val.deskripsi+'</td><td id="buttonwrap"><button  class="addbtn btn btn-xs btn-primary" onclick="pilih('+a+')">Pilih</button></td></tr>');
              a++;
            });
          } else {
            alert('Ajax error!');
          }
        }
      });
    }

    function rearrangeTable(){
      var ppn_item = 0;
      var bodypencarian = document.getElementById('bodypencarian');
      var newth = '<th>No</th><th>Nama</th><th>Deskripsi</th><th>Qty</th><th>Harga</th><th>PPN</th><th>Subtotal</th>';
      $("#headpencarian tr").remove();
      $("#headpencarian").append(newth);
      $("#bodypencarian tr").remove();
      for (var i = 0; i < arrayRetur.length; ++i) {
        var dat = arrayRetur[i];
        var row = document.createElement('tr');
        var td1 = document.createElement('td');
        td1.innerHTML = (i+1)+'.';
        var td2 = document.createElement('td');
        td2.innerHTML = dat.nama;
        var td3 = document.createElement('td');
        td3.innerHTML = dat.deskripsi;
        var td4 = document.createElement('td');
        td4.innerHTML = dat.qty;
        var td5 = document.createElement('td');
        td5.innerHTML = rupiah(parseInt(dat.harga));
        if(dat.ppn_status == 1){
                ppn_item = parseInt(dat.harga) * 0.1;
              }else{
                ppn_item = 0;
              }
        arrayRetur[i].ppn_item = ppn_item;
        var td6 = document.createElement('td');
        td6.innerHTML = rupiah(ppn_item);
        var td7 = document.createElement('td');
        td7.innerHTML = rupiah((parseInt(dat.harga) * parseInt(dat.qty)) + (ppn_item * parseInt(dat.qty)));
        row.appendChild(td1);
        row.appendChild(td2);
        row.appendChild(td3);
        row.appendChild(td4);
        row.appendChild(td5);
        row.appendChild(td6);
        row.appendChild(td7);
        bodypencarian.appendChild(row);
      }
    }

    function pilih(a){
      var qty = document.querySelector('[name="qty'+a+'"]').value;
      if(confirm('Pilih item: '+qty +' '+arrayCari[a].nama)){
        arrayCari[a].qty = qty;
        arrayRetur.push(arrayCari[a]);
        //console.log(arrayRetur);
        $("#row"+a).remove();
        enable();
      }
    }

    function proses(){
      rearrangeTable();
      removeproseswrapper();
      $("#bodyinfo").addClass('card lg-md-2 p-2');
      $("#bodyinfo").css({"height": "100%", "transition": "height 2s"});
      hitung();
    }

    function ubah_ppn(){
      const cb = document.getElementById('ubahppn');
      if(cb.checked){
        nilaipengembalian = total + totalppn;
      }else{
        nilaipengembalian = total;
      }
      $('[name="nilaipengembalian"]').val(rupiah(nilaipengembalian));
    }

    function reset(){
      window.location.reload();
    }

    function save_retur() {
      var dataRetur = {
        'id' : ids,
        'kode_inv': par,
        'total': total,
        'ppn_status' : ppn_status,
        'total_ppn': totalppn,
        'nilaipengembalian': nilaipengembalian,
      };

      console.log(dataRetur);
      console.log(arrayRetur);
      var x = JSON.stringify(dataRetur);
      var y = JSON.stringify(arrayRetur);

      /*
      $.ajax({
        url: "<?php //echo base_url('kasir/save_retur') ?>",
        type: "POST",
        data: {
          data: x,
          item: y
        },
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
      */
    }

    function exit(){
      window.location.reload();
    }

  </script>