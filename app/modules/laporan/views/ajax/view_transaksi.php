<div class="row" style="min-height: 400px;">
    <div class="col-md-9" style="border: 1px solid grey;" id="chartview"></div>
    <div class="col-md-3">
        <h4>Export Laporan</h4>
        <hr>
        <div class="btn-group-vertical btn-block">
            <input type="hidden" id="tgl_awal_trans" value="<?php echo $tgl_awal;?>">
            <input type="hidden" id="tgl_akhir_trans" value="<?php echo $tgl_akhir;?>">
            <input type="hidden" id="kelompokx" value="<?php echo $kelompok;?>">
            <button class="btn btn-sm btn-primary" onclick="export_x('excel')">Export to Excel</button>
            <button class="btn btn-sm btn-warning" onclick="export_x('pdf')">Export to PDF</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-5">
    <table class="table table-bordered table-strip">
        <thead>
            <tr>
                <th>No.</th>
                <th>Bulan/Tanggal</th>
                <th>Jumlah Transaksi</th>
                <th>Total Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data as $key => $value) { ?>
                <tr>
                    <td><?= $no;?></td>
                    <td><?= $value->tgl_inv;?></td>
                    <td class="text-center"><?= $value->total_order;?></td>
                    <td><?= $this->alus_auth->rupiahrp($value->total_uang);?></td>
                </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
    </div>
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

    function export_x(par) {
        // Opens a new window
        myWindow = window.open("<?php echo base_url('laporan/export_transaksi/');?>?kelompok="+$("#kelompokx").val()+"&jenis="+par+"&awal="+$("#tgl_awal_trans").val()+"&akhir="+$("#tgl_akhir_trans").val(), "Export", "width=200, height=100");
        // myWindow.close();
    }
</script>