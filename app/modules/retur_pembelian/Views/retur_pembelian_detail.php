 <?php
    $tr = explode(" ", $tgl);
  ?>
<div class="content-wrapper" style="min-height: 2644px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url("retur_pembelian"); ?>">Home</a></li>
              <li class="breadcrumb-item active">Retur Pembelian</li>
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
                <div class="col-sm-4 invoice-col">
                  <address>
                    Kepada :
                    <?php echo "
                    <h4>".$ms_nama."</h4>
                    ".$ms_alamat." ".$ms_kodepos."<br>
                    Telepon: ".$ms_telp."<br>";
                    ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h4>Retur Pembelian</h4>
                  <strong> #<?php echo $kode; ?></strong><br>
                  Tanggal Retur : <strong> <?php echo $tr[0]; ?></strong><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Batch ID</th>
                      <th>Item</th>
                      <th>Tanggal Input</th>
                      <th>Qty</th>
                    </tr>
                    </thead>
                    <tbody id="bodyItem">
                        <!-- Isi Item List -->
                        <?php
                        $i = 0;
                        foreach ($data as $value) {
                          $i += 1;
                          echo  "<tr>
                                  <td>".$i."</td>
                                  <td>".$value->trpd_tb_id."</td>
                                  <td>".$value->mo_nama."</td>
                                  <td>".$value->trpd_tgl_input."</td>
                                  <td>".$value->trpd_qty."</td>
                                 </tr>";
                        }
                        ?>
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
    function print(size){
      var windownow = window.location.href;
      var content = document.getElementById('printarea');
      var print_area = window.open();
      print_area.document.write('<html><head>');

      var scripts = document.getElementsByTagName("link");
      if(size){
        print_area.document.write(`
          <style>
          @page {
            size: 21.00cm auto;
            margin:0;
                }
          @media print{
            body{
              padding: 10px;
            }
          }
          </style>`
          );
        for (var i = 0; i < scripts.length; i++) {
          if (scripts[i].href) print_area.document.write('<link rel="stylesheet" type="text/css" href="'+scripts[i].href+'">')
          else console.log(i, scripts[i].innerHTML)
        }
      }else{
        print_area.document.write(`
          <style>
          @page {
            size: 80mm auto;
            margin:0;
                }
          @media print{
            body{
              margin: 5px;
            }
            *{
              font-family: sans-serif;
              font-weight:normal;
              font-size: 7px;
              line-height: 1;
            }
          }
          </style>`
          );
      }
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