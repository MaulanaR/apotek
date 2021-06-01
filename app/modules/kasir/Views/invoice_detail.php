<div class="content-wrapper" style="min-height: 2644px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url("kasir"); ?>">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>
            <div class="row">
            <div class="col-4 text-left">
              <p><a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> Ukuran Normal</p>
            </div>
            <div class="col-4 text-center">
              <p><a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> Ukuran Kecil</p>
            </div>
            <div class="col-4 text-right">
              <?php
              if($resep == 1){
              ?>
              <p><a href="print_salinan_resep/<?php echo $kode_inv; ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> Salinan Resep</p>
            <?php } ?>
            </div>
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Apotek APP
                    <?php
                      $a = explode(" ", $tgl);
                    ?>
                    <small class="float-right">Date: <?php  echo $a[0]?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong><?php echo $username; ?></strong><br>
                    <?php echo $job; ?><br>
                    Kota, Kode POS 22114466<br>
                    Telepon: (000) 1112223<br>
                    Email: cs@appapotek
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <strong>Invoice #<?php echo $id; ?></strong><br>
                  Order ID:<strong> <?php echo $kode_inv; ?></strong><br>
                  Tipe pembayaran : <strong><?php echo $tipe_pembayaran; ?></strong><br>
                  No Ref : <strong><?php echo $no_ref; ?></strong>
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
                      <th>Qty</th>
                      <th>Produk</th>
                      <th>Deskripsi</th>
                      <th>Harga</th>
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
                      <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><?php echo $subtotal; ?></td>
                      </tr>
                      <tr>
                        <th>PPN (10%)</th>
                        <td><?php echo $ppn_nilai; ?></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td><b><?php echo $grandtotal; ?></b></td>
                      </tr>
                      <tr>
                        <th>Bayar:</th>
                        <td><?php echo $nominal_bayar; ?></td>
                      </tr>
                      <tr>
                        <th>Kembalian:</th>
                        <td><?php echo $nominal_kembalian; ?></td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                   Terima kasih atas pembeliannya!
                  </p>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
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
    $(document).ready(function(){
      //do something
      generateData();
    });

    function rupiah(x){
      var z = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(x);
      return z;
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
            $.each(data.data, function(index, val) {

            $('#bodyItem').append('<tr><td>'+val.qty+'</td><td>'+val.nama+'</td><td>'+val.deskripsi+'</td><td>'+rupiah(val.harga)+'</td><td>'+rupiah(val.total)+'</td></tr>')
          });
          } else {
            alert('Ajax error!');
          }
        }
      });
    }
  </script>