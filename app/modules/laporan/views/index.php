  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Buat Laporan
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="card">
            <div class="card-header">
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
             <div class="btn-group">
                 <form>
                  <div class="form-group">
                   <label for="jenisLaporan">Jenis laporan</label> <select id="jenisLaporan" name="jenisLaporan" class="form-control" onselect="pilihLaporan()">
                     <option>Persediaan Obat</option>
                     <option>Persediaan Alkes</option>
                     <option>Obat Kadaluarsa</option>
                     <option>Transaksi</option>
                     <option>Retur Penjualan</option>
                     <option>Retur Pembelian</option>
                     <option>Saldo Kasir</option>
                     <option>Neraca</option>
                   </select>
                 </div>
                 <div class="form-group">
                   <label for="tglAwal">Dari</label><input type="date" id="tglAwal" name="tglAwal" class="form-control" required="">
                 </div>
                 <div class="form-group">
                   <label for="tglAkhir">Sampai</label><input type="date" id="tglAkhir" name="tglAkhir" class="form-control" required="">
                </div>
                <p class="text-right">
                   <button class="btn btn-flat btn-primary" onclick="proses()"><i class='fa fa-search'></i> Cari</button>
                 </p>
                 </form>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
<!--Modal -->
<div class="modal" id="modal_form">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
                <form action="#" id="form" class="form-horizontal" name="formnih">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label ">Nama Kategori Obat</label>
                            
                                <input type="text" name="name" class="form-control" placeholder="Nama">
                                <span class="help-block"></span>
                            
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave" onclick="save()" >Save</button>
              </div>
            </div>

          </div>

        </div>

  <script type="text/javascript">
 
 
$(document).ready(function() {

    
});


</script>