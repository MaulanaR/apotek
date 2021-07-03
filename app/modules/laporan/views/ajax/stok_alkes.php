<div class='row'>
	<div class="col-md-12" id="pieobat"></div>
	<table id="table" class="table table-bordered table-hover dataTable dtr-inline" style="width: 100%">
	     <thead>
	     <tr>
	       <th>No</th>
	       <th>Nama</th>
	       <th>Batch ID</th>
	       <th>Stok</th>
	       <th>Status</th>
	     </tr>
	     </thead>
	     <tbody>
	      <?php
	      $ar = $data['data'];
	      $totalitem = 0;
	      $other = 0;
	      $arr = $this->alus_auth->filter_array_2d_match($ar, 11, $id_alkes);//filter alkes
	       for($i = 0; $i < count($arr); $i++){
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
			$arrayItem = array();
			for($i = 0; $i < count($arr); $i++){
				$y = ((int)$arr[$i][2] / $totalitem) * 100;
				if($y < 2){//jika persentasi kurang dari 5%
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
                 
<script type="text/javascript">
	Highcharts.chart('pieobat', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Persentasi Jumlah Item'
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
</script>