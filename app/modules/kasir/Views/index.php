  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?php echo date("Y-m-d H:i:s");?>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="card col-md-8 m-2">
            <div class="card-header text-left">
              <p>Selamat datang dan selamat bekerja <b>Kasir</b>!</p>
            </div>
            <div class="card-body">
              <a class="btn btn-app bg-success" href="<?php echo base_url('kasir/transaksi'); ?>">
                  <i class="fas fa-inbox"></i> Transaksi Baru
              </a>
              <a class="btn btn-app bg-secondary"  href="<?php echo base_url('kasir/cari_produk'); ?>">
                  <i class="fas fa-barcode"></i>Cek Produk
              </a>
            </div>
          </div>
          <div class="card col-md-3 m-2" alt="Max-width 100%">
            <div class="card-header text-center">
              <h7><b>Saldo</b>
              </h7>
            </div>
            <div class="card-body">
              <div class="text-center">
                <h5><b>Rp. 000.000,00</b></h5>
              </div>
              <hr />
              <div class="text-center">
                <button class="btn btn-lg btn-danger" onclick="">Akhiri Shift</button>
              </div>
            </div>
          </div>
          <div class="card col-md-12 m-2">
            <div class="card-header text-left">
              <h7>Transaksi pada sesi ini :</h7>
            </div>
            <div class="card-body">
             <table id="tabelTransaksi" class="table table-bordered table-hover dataTable dtr-inline">
                    <thead>
                      <tr>
                        <th class="text">No Invoice</th>
                        <th class="text">Jumlah Item</th>
                        <th class="text">Grand Total</th>
                        <th class="text">Status</th>
                        <th class="text">Kasir</th>
                        <th class="text"></th>
                      </tr>
                    </thead>
                    <tbody id="bodyTransaksi">
                      <tr>
                        <td class="text">FCA67B8Y</td>
                        <td class="text">3</td>
                        <td class="text">Rp. 25.000,00</td>
                        <td class="text">Finished</td>
                        <td class="text">Kasir 1</td>
                        <td class="text">
                          <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        </td>
                      </tr>
                      <tr>
                        <td class="text">FCA67B8Y</td>
                        <td class="text">3</td>
                        <td class="text">Rp. 25.000,00</td>
                        <td class="text">Finished</td>
                        <td class="text">Kasir 1</td>
                        <td class="text">
                          <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        </td>
                      </tr>
                      <tr>
                        <td class="text">FCA67B8Y</td>
                        <td class="text">3</td>
                        <td class="text">Rp. 25.000,00</td>
                        <td class="text">Finished</td>
                        <td class="text">Kasir 1</td>
                        <td class="text">
                          <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        </td>
                      </tr> 
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
