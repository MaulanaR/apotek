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
	<table id="table" class="table table-bordered table-striped" style="width: 100%">
	     <thead>
	     <tr>
	       <th rowspan="2" class="text-center" >No</th>
	       <th rowspan="2" class="text-center" >Batch ID</th>
	       <th colspan="2" class="text-center" >Tanggal</th>
	       <th rowspan="2" class="text-center" >Stok</th>
	     </tr>
	     <tr>
	     	<th class="text-center" >Input</th>
	        <th class="text-center" >Kadaluarsa</th>
	     </tr>
	     </thead>
	     <tbody id="dataBody">
	     </tbody>
	 </table>
</div>
</div>
<script type="text/javascript">
	let moId = <?php echo $mo_id ?>;
	$(document).ready(function() {
		$.ajax({
        url: "<?php echo site_url('Obat/ajax_stok_obat_by_id/') . $mo_id . ""; ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          if(data.status == true){
          i = 0;
          console.log(data);
          $.each(data.data, function(index, val) {

            i++;
            let html = `
            	<tr>
            	 <td>${i}</td>
            	 <td>${val[3]}</td>
            	 <td>${val[12]}</td>
            	 <td>${val[1]}</td>
            	 <td>${val[2]}</td>
            	</tr>
            `;
            $('#dataBody').append(html);
          });
          }else{
          	popup('info', 'Item tidak memiliki batch yang terdaftar!');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });
	});

	function export_x(par) {
        myWindow = window.open("<?php echo base_url('laporan/export_stok_individual/');?>?jenis="+par+"&id="+moId, "Export", "width=800, height=600");
    }

	
</script>