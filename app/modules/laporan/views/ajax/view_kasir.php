<div class="row" style="min-height: 400px;">
    <div class="col-md-12">
        <h4>Export Laporan</h4>
        <hr>
        <div class="btn-group mb-2">
            <input type="hidden" id="tgl_awal_trans" value="<?php echo $tgl_awal;?>">
            <input type="hidden" id="tgl_akhir_trans" value="<?php echo $tgl_akhir;?>">
            <button class="btn btn-sm btn-primary" onclick="export_x('excel')">Export to Excel</button>
            <button class="btn btn-sm btn-warning" onclick="export_x('pdf')">Export to PDF</button>
        </div>
    <table class="table table-bordered table-strip">
        <thead>
            <tr>
                <th rowspan="2" class="text-center">No.</th>
                <th rowspan="2" class="text-center">Kasir</th>
                <th colspan="2" class="text-center">Sesi</th>
                <th rowspan="2" class="text-right">Saldo Awal</th>
                <th rowspan="2" class="text-right">Saldo Akhir</th>
                <th rowspan="2" class="text-right">Pemasukan</th>
            </tr>
            <tr>
                <th class="text-center">Masuk</th>
                <th class="text-center">Keluar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data as $key => $value) { ?>
                <tr>
                    <td class="text-center"><?php echo $no;?></td>
                    <td class="text-center" onclick="open_modal('<?php echo $value->tsu_id;?>')" style="cursor: pointer;color:blue"><?php echo $value->first_name;?></td>
                    <td class="text-center"><?php echo date('d-m-Y H:i:s',strtotime($value->tsu_jam_masuk));?></td>
                    <td class="text-center"><?php echo date('d-m-Y H:i:s',strtotime($value->tsu_jam_keluar));?></td>
                    <td class="text-right"><?php echo $this->alus_auth->rupiahrp($value->tsu_saldo_awal);?></td>
                    <td class="text-right"><?php echo $this->alus_auth->rupiahrp($value->tsu_saldo_akhir);?></td>
                    <td class="text-right"><?php echo $this->alus_auth->rupiahrp(($value->tsu_saldo_akhir - $value->tsu_saldo_awal));?></td>
                </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
    </div>
</div>

<div class="modal fade" id="modallaporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalbod">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

    function export_x(par) {
        // Opens a new window
        myWindow = window.open("<?php echo base_url('laporan/export_kasir/');?>?jenis="+par+"&awal="+$("#tgl_awal_trans").val()+"&akhir="+$("#tgl_akhir_trans").val(), "Export", "width=800, height=600");
        // myWindow.close();
    }

    function open_modal(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url();?>laporan/detail_kasir/"+id,
            dataType: "html",
            success: function (data) {
                $("#modallaporan").modal('show');
                $("#modalbod").empty();
                $("#modalbod").html(data);
            }
        });
    }
</script>