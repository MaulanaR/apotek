<table class="table table-bordered table-strip">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Nomor Inv</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Total Barang</th>
            <th class="text-right">Grand Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $key => $value) { ?>
            <tr>
                <td class="text-center"><?php echo $no; ?></td>
                <td class="text-center"><?php echo $value->ti_nomor_inv; ?></td>
                <td class="text-center"><?php echo date('d-m-Y H:i:s', strtotime($value->ti_tgl)); ?></td>
                <td class="text-center"><?php echo $value->ti_total_barang; ?></td>
                <td class="text-right"><?php echo $this->alus_auth->rupiahrp($value->ti_grandtotal); ?></td>
            </tr>
        <?php $no++;
        } ?>
    </tbody>
</table>