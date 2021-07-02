<script src="https://code.highcharts.com/highcharts.js"></script>
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
        <!-- /.card-header -->
        <div class="card-body">
          <form id="filter">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="jenisLaporan">Jenis laporan</label>
                  <select id="jenisLaporan" name="jenisLaporan" class="form-control" onchange="pilihLaporan(this.value)">
                    <option value="">- Pilih Jenis -</option>
                    <option value="persediaan_obat">Persediaan Obat</option>
                    <option>Persediaan Alkes</option>
                    <option>Obat Kadaluarsa</option>
                    <option value="Transaksi">Transaksi</option>
                    <option>Retur Penjualan</option>
                    <option>Retur Pembelian</option>
                    <option>Saldo Kasir</option>
                    <option>Neraca</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tglAwal">Dari</label><input type="date" id="tglAwal" name="tglAwal" class="form-control" required="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tglAkhir">Sampai</label><input type="date" id="tglAkhir" name="tglAkhir" class="form-control" required="">
                </div>
              </div>
            </div>
            <div class="row" id="filter_tambahan">

            <div>

          </form>

        </div>
        <!-- /.card-body -->
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <button class="btn btn-flat btn-md btn-primary" onclick="proses()" type="button"><i class='fa fa-search'></i> Tampilkan</button>
        </div>
      </div>
      <!-- /.card -->
    </section>
    <section class="content" id="isi">
      <div class="card">
        <div class="card-body" id="isitable">
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.container -->
</div>
<!-- /.content-wrapper -->
<!--Modal -->

<script type="text/javascript">
  $(document).ready(function() {

  });

  function proses() {
    // $("#isichart").empty();
    $("#isitable").empty();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>laporan/generate",
      data: {
        'jenis': $("#jenisLaporan").val(),
        'tgl_awal': $("#tglAwal").val(),
        'tgl_akhir': $("#tglAkhir").val(),
        'kelompok' : $("#kelompok").val()
      },
      dataType: "html",
      success: function(response) {
        $("#isitable").html(response);
      },
      error: function(xhr, err, x) {
        popup('Perhatian', 'Gagal mengambil data', 'error');
      }
    });
  }

  function pilihLaporan(va) {
    if (va == 'Transaksi') {
      $("#filter_tambahan").empty();
      $("#filter_tambahan").append(
        '<div class="col-md-12">' +
        '<div class="form-group">' +
        '<label for="tglAwal">Kelompokan Berdasarkan : </label>' +
        '<select class="form-control" id="kelompok"><option value="harian">Transaksi Harian</option><option value="bulanan">Transaksi Bulanan</option></select>' +
        '</div>' +
        '</div>'
      );
    }else{
      $("#filter_tambahan").empty();

    }
  }
</script>