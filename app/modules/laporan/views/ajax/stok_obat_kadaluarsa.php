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
<div class='row'>
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
	      $ar = $data['data'];
	      $totalitem = 0;
	      $other = 0;
	      $ar2 = $this->alus_auth->filter_array_2d_not_match($ar, 11, $id_alkes);//filter alkes
	      $arr = $this->alus_auth->filter_array_2d_match($ar2, 4, TRUE);//filter kadaluarsa
	      $arrayItem = array();
	       for($i = 0; $i < count($arr); $i++){
	       	if((int)$arr[$i][2] > 0){//jika stok lebih dari 0
				        echo "
				         <tr>
				          <td>".($i + 1)."</td>
				          <td>".$arr[$i][0]."</td>
				          <td>".$arr[$i][3]."</td>
				          <td>".$arr[$i][2]." ".$arr[$i][7]."</td>
				         </tr>
				        ";
				        $temp = $totalitem + (int)$arr[$i][2];
						$totalitem = $temp;

				}
	       }
			for($i = 0; $i < count($arr); $i++){
				if((int)$arr[$i][2] > 0){ //jika stok lebih dari 0
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
                 
<script type="text/javascript">
	Highcharts.chart('pieobat', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Persentasi Jumlah Obat kadaluarsa'
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
        myWindow = window.open("<?php echo base_url('laporan/export_stok/');?>?jenis="+par+"&content=obatkd", "Export", "width=200, height=100");
        // myWindow.close();
    }
</script>