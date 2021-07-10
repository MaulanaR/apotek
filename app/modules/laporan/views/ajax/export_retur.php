<?php
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=Laporan_Retur_" . $awal . "_sampai_" . $akhir . ".xls");
print "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">

<style>

@page
    {margin:1.0in .75in 1.0in .75in;
    mso-header-margin:.5in;
    mso-footer-margin:.5in;}
tr
    {mso-height-source:auto;}
col
    {mso-width-source:auto;}
br
    {mso-data-placement:same-cell;
    }

.style0
    {mso-number-format:General;
    text-align:general;
    vertical-align:bottom;
    white-space:nowrap;
    mso-rotate:0;
    mso-background-source:auto;
    mso-pattern:auto;
    color:windowtext;
    font-size:10.0pt;
    font-weight:400;
    font-style:normal;
    text-decoration:none;
    font-family:Arial;
    mso-generic-font-family:auto;
    mso-font-charset:0;
    border:none;
    mso-protection:locked visible;
    mso-style-name:Normal;
    mso-style-id:0;}
td
    {mso-style-parent:style0;
    padding-top:1px;
    padding-right:1px;
    padding-left:1px;
    mso-ignore:padding;
    color:windowtext;
    font-size:10.0pt;
    font-weight:400;
    font-style:normal;
    text-decoration:none;
    font-family:Arial;
    mso-generic-font-family:auto;
    mso-font-charset:0;
    mso-number-format:General;
    text-align:general;
    vertical-align:bottom;
    border:none;
    mso-background-source:auto;
    mso-pattern:auto;
    mso-protection:locked visible;
    white-space:nowrap;
    mso-rotate:0;}
.grids
    {mso-style-parent:style0;
    border:.5pt solid windowtext;}.head{
    font-weight:bold;
}

</style>
<head>
<!--[if gte mso 9]><xml>
<x:ExcelWorkbook>
<x:ExcelWorksheets>
<x:ExcelWorksheet>
<x:Name>Apotek</x:Name>
<x:WorksheetOptions>
<x:Print>
</x:Print>
</x:WorksheetOptions>
</x:ExcelWorksheet>
</x:ExcelWorksheets>
</x:ExcelWorkbook> 
</xml>
<![endif]--> 
</head>
<body>";
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style type="text/css">
        body {
            font-family: arial;
            margin: 0px;
        }

        html {
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <table class="table table-bordered table-strip">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal Retur</th>
                <th>Kode Invoice</th>
                <th>Pengembalian PPN</th>
                <th>Total Nilai Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data as $key => $value) { ?>
                <tr>
                    <td><?= $no;?></td>
                    <td><?= $value->tr_tgl;?></td>
                    <td class="text-center"><?= $value->tr_ti_nomor_inv;?></td>
                    <td class="text-center"><?php 
                    if($value->tr_ppn_kembali == '1'){
                        echo 'Ya';
                    }else{
                        echo 'Tidak';
                    }
                        ?></td>                    
                    <td><?= $this->alus_auth->rupiahrp($value->tr_nilai_pengembalian);?></td>
                </tr>
            <?php $no++;
            } ?>
        </tbody>
    </table>
</body>

</html>