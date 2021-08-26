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
                    <option>--Option--</option>
                    <option value="StokObat">Persediaan Obat</option>
                    <option value="StokAlkes">Persediaan Alkes</option>
                    <option value="StokIndividual">Persediaan Individual</option>
                    <option value="StokObatKd">Obat Kadaluarsa</option>
                    <option value="Transaksi">Transaksi</option>
                    <option value="Retur">Retur</option>
                    <option value="kasir">Saldo Kasir</option>
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
          <button class="btn btn-flat btn-md btn-primary" type="button" id="Tampilkan"><i class='fa fa-search'></i> Tampilkan</button>
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
    $("#Tampilkan").click(function(){
      var par = $('#jenisLaporan').val();
        proses(par);
      });
  });

  function dateinput(a){
    $("#tglAwal").attr('disabled', a);
    $("#tglAkhir").attr('disabled', a);
  }

  function proses(par) {
    // $("#isichart").empty();
    if(par == 'Transaksi'){
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
    }else if(par == 'StokObat'){
      $("#isitable").empty();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>laporan/generate",
        data: {
          'jenis': $("#jenisLaporan").val()
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
    else if(par == 'StokObatKd'){
      $("#isitable").empty();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>laporan/generate",
        data: {
          'jenis': $("#jenisLaporan").val()
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
    else if(par == 'StokAlkes'){
      $("#isitable").empty();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>laporan/generate",
        data: {
          'jenis': $("#jenisLaporan").val()
        },
        dataType: "html",
        success: function(response) {
          $("#isitable").html(response);
        },
        error: function(xhr, err, x) {
          popup('Perhatian', 'Gagal mengambil data', 'error');
        }
      });
    }if(par == 'Retur'){
      $("#isitable").empty();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>laporan/generate",
        data: {
          'jenis': $("#jenisLaporan").val(),
          'tgl_awal': $("#tglAwal").val(),
          'tgl_akhir': $("#tglAkhir").val()
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
    if(par == 'kasir'){
      $("#isitable").empty();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>laporan/generate",
        data: {
          'jenis': $("#jenisLaporan").val(),
          'tgl_awal': $("#tglAwal").val(),
          'tgl_akhir': $("#tglAkhir").val()
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
    if(par == 'StokIndividual'){
      $("#isitable").empty();
      const selected = $("#itemList option").filter(':selected').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>laporan/generate",
        data: {
          'jenis': $("#jenisLaporan").val(),
          'mo_id': selected
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
  }

  function pilihLaporan(va) {
    if (va == 'Transaksi') {
      dateinput(false);
      $("#filter_tambahan").empty();
      $("#filter_tambahan").append(
        '<div class="col-md-12">' +
        '<div class="form-group">' +
        '<label for="tglAwal">Kelompokan Berdasarkan : </label>' +
        '<select class="form-control" id="kelompok"><option value="harian">Transaksi Harian</option><option value="bulanan">Transaksi Bulanan</option></select>' +
        '</div>' +
        '</div>'
      );
    }else if (va == 'StokObat') {
      dateinput(true);
      $("#filter_tambahan").empty();
    }else if (va == 'StokAlkes') {
      dateinput(true);
      $("#filter_tambahan").empty();
    }else if (va == 'StokObatKd') {
      dateinput(true);
      $("#filter_tambahan").empty();
    }else if (va == 'Retur') {
      dateinput(false);
      $("#filter_tambahan").empty();
    }else if (va == 'kasir') {
      dateinput(false);
      $("#filter_tambahan").empty();
    }else if (va == 'StokIndividual'){
      dateinput(true);
      $("#filter_tambahan").empty();
      <?php
        $this->db->select('mo_id, mo_nama');
        $query = $this->db->get('m_obat');
        $data = $query->result();
      ?>
      $("#filter_tambahan").append(
        '<div class="col-md-12">' +
        '<div class="form-group">' +
        '<label for="tglAwal" class="control-label">Item : </label>' +
        '<select class="sel form-control" id="itemList" data-live-search="true" required><option disabled>Pilih Item</option><?php foreach ($data as $v){
           echo '<option value="'.$v->mo_id.'">'.$v->mo_nama.'</option>'; 
        }?></select>' +
        '</div>' +
        '</div>'
      );
      $("#itemList").selectpicker('refresh');
      $("#itemList").selectpicker('render');
    }
  }
</script>