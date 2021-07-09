<?php
$ar = $data['data'];
$totalitem = 0;
$other = 0;
$stok_obat_terbanyak = 0;
$ar2 = $this->alus_auth->filter_array_2d_not_match($ar, 11, $id_alkes);//filter alkes
$arr = $this->alus_auth->filter_array_2d_not_match($ar2, 4, TRUE);//filter kadaluarsa
for($i = 0; $i < count($arr); $i++){
	if((int)$arr[$i][2] > $stok_obat_terbanyak){
		$stok_obat_terbanyak = (int)$arr[$i][2];
		$obat_terbanyak = $arr[$i][0];
		$unit_obat_terbanyak = $arr[$i][7];
	}
	$temp = $totalitem + (int)$arr[$i][2];
	$totalitem = $temp;
}
?>
<div class="row" style="min-height: 400px;">
    <div class="col-md-9" style="border: 1px solid grey;" id="pieobat"></div>
    <div class="col-md-3">
        <h4>Export Laporan</h4>
        <hr>
        <div class="btn-group-vertical btn-block">
            <button class="btn btn-sm btn-primary" onclick="export_x('excel')">Export to Excel</button>
            <button class="btn btn-sm btn-warning" onclick="export_x('pdf')">Export to PDF</button>
        </div>
    </div>
</div>
<div class='row col-12 p-0'>
	<div class='col-12'>
		<p><h3>Summary</h3></p>
	</div>
	<div class='card mr-2 pt-2' style='width:32%'>
		<dl>
			<dt class='text-center'><p>Jumlah Item Terdaftar</p></dt>
			<dd class='text-center'><p>&nbsp;</p></dd>
			<dd class='text-center'><p><h4><?php echo $totalitem; ?></h4> Item</p></dd>
		</dl>
	</div>
	<div class='card mr-2 pt-2' style='width:32%'>
		<dl>
			<dt class='text-center'><p>Terbaru</p></dt>
			<dd class='text-center'><p><?php echo $obat_terbaru; ?></p></dd>
			<dd class='text-center'><p><h4><?php echo $stok_obat_terbaru; ?></h4> <?php echo $unit_obat_terbaru; ?></p></dd>
		</dl>
	</div>
	<div class='card mr-2 pt-2' style='width:32%'>
		<dl>
			<dt class='text-center'><p>Stok Paling Banyak</p></dt>
			<dd class='text-center'><p><?php echo $obat_terbanyak; ?></p></dd>
			<dd class='text-center'><p><h4><?php echo $stok_obat_terbanyak; ?></h4> <?php echo $unit_obat_terbanyak; ?></p></dd>
		</dl>
	</div>
	<div class='card mr-2 pt-2' style='width:32%'>
		<dl>
			<dt class='text-center'><p>Paling Sering Terjual <small>(Item)</small></p></dt>
			<dd class='text-center'><p>Placeholder</p></dd>
			<dd class='text-center'><p><h4>00</h4> Item</p></dd>
		</dl>
	</div>
	<div class='card mr-2 pt-2' style='width:32%'>
		<dl>
			<dt class='text-center'><p>Paling Banyak Terjual <small>(Item)</small></p></dt>
			<dd class='text-center'><p>Placeholder</p></dd>
			<dd class='text-center'><p><h4>00</h4> Item</p></dd>
		</dl>
	</div>
	<div class='card mr-2 pt-2' style='width:32%'>
		<dl>
			<dt class='text-center'><p>Terakhir dijual</p></dt>
			<dd class='text-center'><p>Placeholder</p></dd>
			<dd class='text-center'><p><h4>00</h4> Item</p></dd>
		</dl>
	</div>
</div>	
<div class='row col-12 p-0'>
	<div class='col-12'>
		<p><h3 onclick="shtable()" style="cursor:pointer;">Data Table <i id="datatablearrow" class="fas fa-angle-down" aria-hidden="true"></i></h3></p>
	</div>
	<div class='col-12' id='divtable' style="display:none;visibility: none;">
	<table id="table" class="table table-bordered table-hover dataTable dtr-inline" style="width: 100%">
	     <thead>
	     <tr>
	       <th>No</th>
	       <th>Nama</th>
	       <th>Batch ID</th>
	       <th>Stok</th>
	     </tr>
	     </thead>
	     <tbody>
	      <?php
	       for($i = 0; $i < count($arr); $i++){
		        echo "
		         <tr>
		          <td>".($i + 1)."</td>
		          <td>".$arr[$i][0]."</td>
		          <td>".$arr[$i][3]."</td>
		          <td>".$arr[$i][2]." ".$arr[$i][7]."</td>
		         </tr>
		        ";
	       }
			$arrayItem = array();
			for($i = 0; $i < count($arr); $i++){

						$y = ((int)$arr[$i][2] / $totalitem) * 100;
						if($y < 2){//jika persentasi kurang dari 2%
							$temp = $other + $y;//tambah ke persentasi other
							$other = $temp;
						}else{
							$row['nama'] = $arr[$i][0]." [".$arr[$i][2]." ".$arr[$i][7]."]";
							$row['y'] = $y;
							$arrayItem[] = $row;
						}

			}
			if($other != 0 | $other != null){//jika other tidak kosong
					$c = count($arrayItem);
					$arrayItem[$c]['nama'] = "Obat Lainnya";
					$arrayItem[$c]['y'] = $other;
				}
	      ?>
	     </tbody>
	</table>
	</div>
</div>
                 
<script type="text/javascript">
$(document).ready(function() {

});

function shtable(){
	var ea = document.getElementById('datatablearrow');
	var el = document.getElementById('divtable');
	if(window.getComputedStyle(el).display !== 'none') {
        el.style.display = 'none';
        ea.classList.remove('fa-angle-up');
		ea.classList.add('fa-angle-down');
    }else{
    	el.style.display = 'block';
        ea.classList.remove('fa-angle-down');
		ea.classList.add('fa-angle-up');
    }
}

	Highcharts.chart('pieobat', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Persentasi Jumlah Obat'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
      }
    }
  },
  series: [{
    name: 'Persentasi',
    colorByPoint: true,
    data: [<?php 
    	foreach($arrayItem as $item){
    		echo " {name: '".$item['nama']."',y: ".$item['y']."},";
    	}
    ?>]
  }]
});
	function export_x(par) {
        // Opens a new window
        myWindow = window.open("<?php echo base_url('laporan/export_stok/');?>?jenis="+par+"&content=obat", "Export", "width=800, height=600");
        // myWindow.close();
    }
    
</script>