<div class="row" style="min-height: 25em;">
    <div class="col-md-9" style="border: 1px solid grey;" id="chartview"></div>
    <div class="col-md-3">
        <h4>Export Laporan</h4>
        <hr>
        <div class="form-group">
            <button class="btn btn-sm btn-primary">Export to Excel</button>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-primary">Export to PDF</button>
        </div>
    </div>
</div>

<div>
    <table></table>
</div>
<script>
    Highcharts.chart('chartview', {

        title: {
            text: 'Laporan Transaksi'
        },

        subtitle: {
            text: 'Range tanggal : <?php echo date('d-m-Y', strtotime($tgl_awal)); ?> s/d <?php echo date('d-m-Y', strtotime($tgl_akhir)); ?>'
        },

        yAxis: {
            title: {
                text: 'Number of Employees'
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2017'
            },
            categories: <?php echo json_encode($datex); ?>
        },

        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'bottom'
        },

        series: [{
            name: 'Total Transaksi',
            data: <?php echo json_encode($count_order); ?>
        }, {
            name: 'Total Uang Masuk',
            data: <?php echo json_encode($sum_order); ?>
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>