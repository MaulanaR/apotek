 <?php
    if($ppn_kembali != 0){
      $teksppn = "Ya";
      $row = "<tr>
                <th>Total PPN</th>
                <td>".$ppn_nilai."</td>
              </tr>";
    }else{
      $teksppn = "Tidak";
      $row = "";
    }
    $ti = explode(" ", $tgl_invoice);
    $tr = explode(" ", $tgl);
  ?>
<div class="content-wrapper" style="min-height: 2644px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Retur Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url("retur"); ?>">Home</a></li>
              <li class="breadcrumb-item active">Retur</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="row">
            <div class="col-4 text-left">
              <p><a rel="noopener" class="btn btn-default" onclick="print(true)"><i class="fas fa-print"></i> Print</a> Ukuran Normal</p>
            </div>
            <div class="col-4 text-center">
              <!--<p><a rel="noopener" class="btn btn-default" onclick="print(false)"><i class="fas fa-print"></i> Print</a> Ukuran Kecil</p>-->
            </div>
            <div class="col-4 text-right">
            </div>
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3" id="printarea">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <img src="<?php echo base_url('assets/logo/askrindo-mini.png'); ?>" width="30px" height="30px"> Apotek APP 
                    <?php
                      $a = explode(" ", $tgl);
                    ?>
                    <span class="float-right">
                      <img class="img" src="<?php echo base_url('assets/barcode/barcode.php?codetype=codabar&print=false&size=35&sizefactor=3&text=').$kode_inv;?>'">
                    </span>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <address>
                    <h4>RETUR ITEM</h4>
                    Kota, Kode POS 22114466<br>
                    Telepon: (000) 1112223<br>
                    Email: cs@appapotek
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col text-center">
                </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <strong>Retur dari Invoice #<?php echo $id; ?></strong><br>
                  Invoice ID:<strong> <?php echo $kode_inv; ?></strong><br>
                  Tanggal Invoice : <strong> <?php echo $ti[0]; ?></strong><br>
                  Tanggal Retur : <strong> <?php echo $tr[0]; ?></strong><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Deskripsi</th>
                      <th>Harga</th>
                      <th>PPN</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody id="bodyItem">
                        <!-- Isi Item List -->
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  
                  <p class="lead">Amount</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                        <th>Total</th>
                        <td id="totalwrapper"></td>
                      </tr>
                      <tr>
                        <th>Pengembalian PPN</th>
                        <td><?php echo $teksppn; ?></td>
                      </tr>
                      <?php echo $row; ?>
                      <tr>
                        <th>Total Refund</th>
                        <td><b><?php echo $nilai_pengembalian; ?></b></td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <span style="display:block;height:auto;">
                    <p><?php echo $keterangan; ?></p>
                  </span>
                  <div style="width:100%">
                  <span style="display:block;width:100px; height: 200px; margin: 0 auto;text-align: center;">
                    <p>
                      <strong>Petugas</strong><br/>
                      <br/>
                      <br/>
                      <strong><?php echo $username; ?></strong><br>
                      <?php echo $job; ?><br>
                    </p>
                  </span>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


  <script type="text/javascript">
    var ids = '<?php echo $id; ?>';
    var kode_inv = '<?php echo $kode_inv; ?>';
    var total = 0;
    $(document).ready(function(){
      //do something
      generateData();
    });

    function rupiah(x){
      var z = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(x);
      return z;
    }

    function generateData(){
      var ppn_item = 0;
      var subtotal = 0;
      var tmp = 0;
      $.ajax({
        url: "<?php echo base_url('retur/ajax_detail_items') ?>",
        type: "POST",
        data: {id : ids},
        dataType: "JSON",
        success: function(data) {

          if (data.status)
          {
            $.each(data.data, function(index, val) {
              if(val.ppn_status == 1){
                ppn_item = parseInt(val.harga) * 0.1;
              }else{
                ppn_item = 0;
              }
              subtotal = parseInt(val.total);
              tmp = subtotal + total;
              total = tmp;
            $('#bodyItem').append('<tr><td>'+val.nama+'</td><td>'+val.qty+'</td><td>'+val.deskripsi+'</td><td>'+rupiah(val.harga)+'</td><td>'+rupiah(ppn_item)+'</td><td>'+rupiah(subtotal)+'</td></tr>')
          });
            $("#totalwrapper").append(rupiah(total));
          } else {
            alert('Ajax error!');
          }
        }
      });
    }

    function print(size){
      var windownow = window.location.href;
      var content = document.getElementById('printarea');
      var print_area = window.open();
      print_area.document.write('<html><head>');

      var scripts = document.getElementsByTagName("link");
      if(size){
        for (var i = 0; i < scripts.length; i++) {
          if (scripts[i].href) print_area.document.write('<link rel="stylesheet" type="text/css" href="'+scripts[i].href+'">')
          else console.log(i, scripts[i].innerHTML)
        }
      }
      print_area.document.write('<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/temaalus/dist/css/print.css">');
      print_area.document.write('</head><body>');
      print_area.document.write(content.innerHTML);
      print_area.document.write('</body></html>');
      print_area.document.close();
      setTimeout(function (){

        print_area.focus();
        print_area.print();
        print_area.close();

      }, 500);

      }
      
  </script>