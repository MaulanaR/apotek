 <?php
    $ti = explode(" ", $tgl);
  ?>
<div class="content-wrapper" style="min-height: 2644px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Salinan Resep</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url("resep"); ?>">Home</a></li>
              <li class="breadcrumb-item active">Salinan Resep</li>
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
                  Invoice ID:<strong> <?php echo $kode_inv; ?></strong><br>
                  Tanggal Invoice : <strong> <?php echo $ti[0]; ?></strong><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="col-12 text-center">
                      <h4>SALINAN RESEP</h4>
              </div>
              <div class="col-12">
                  <table class="table table-hovered" border="1px" style="width:100%; border:solid 1px gray;">
                      <tr>
                       <td style="width: 30%;">Instansi Penerbit</td>
                        <td><?php echo $resep_penerbit; ?></td>
                      </tr>
                      <tr>
                        <td>Dokter</td>
                        <td><?php echo $resep_dokter; ?></td>
                      </tr>
                      <tr>
                        <td>Tanggal Resep</td>
                        <td><?php $d = explode(" ", $resep_tgl); echo $d[0]; ?></td>
                      </tr>
                  </table>
              </div>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="resep" aria-describecby="resep_info" class="table table-striped">
                    <thead>
                    <tr>
                      <th>Item</th>
                      <th>Deskripsi</th>
                      <th>Qty</th>
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
                  
                </div>
                <!-- /.col -->
                <div class="col-6 text-center">
                  <span style="display:block;height:auto;">
                    <p><?php echo $keterangan; ?></p>
                  </span>
                    <p>
                      <strong>Apoteker,</strong><br/>
                      <br/>
                      <br/>
                      <strong><?php echo $username; ?></strong><br>
                      <?php echo $job; ?><br>
                    </p>
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
        url: "<?php echo base_url('resep/ajax_detail_items') ?>",
        type: "POST",
        data: {id : ids},
        dataType: "JSON",
        success: function(data) {

          if (data.status)
          {
            $.each(data.data, function(index, val) {

            $('#bodyItem').append('<tr><td>'+val.nama+'</td><td>'+val.deskripsi+'</td><td>'+val.qty+'</td></tr>')
          });

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