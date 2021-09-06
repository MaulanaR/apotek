<div class="content-wrapper" style="min-height: 901px;">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Import Obat
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <table id="tbl1" class="" style="display: none;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
		                $master = $this->db->get('m_kategori')->result();
                        $master_kat = array();
		                foreach ($master as $key => $value) {
                            array_push($master_kat, $value->mk_id);
                    ?>
                        <tr>
                            <td><?php echo $value->mk_id;?></td>
                            <td><?php echo $value->mk_nama;?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <table id="tbl2" class="" style="display: none;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Unit/Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
		                $master_unit = $this->db->get('m_unit')->result();
                        $master_un = array();
		                foreach ($master_unit as $key => $value_unit) {
                            array_push($master_un, $value_unit->mu_id);
                    ?>
                        <tr>
                            <td><?php echo $value_unit->mu_id;?></td>
                            <td><?php echo $value_unit->mu_nama;?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="card">
                <div class="card-body">
                    <label for="">*Silahkan download template terlebih dahulu..</label>
                    <div class="text-center">
                        <a href="<?php echo base_url('assets/Template_Import.xlsx');?>" class="btn btn-md btn-primary"><i class="fas fa-download"></i> Unduh Template Import</a>
                        <button onclick="tablesToExcel(['tbl1','tbl2'], ['Master Kategori','Master Unit'], 'Master_data.xls', 'Excel')" class="btn btn-md btn-warning"><i class="fas fa-download"></i> Unduh ID Master Kategori & Unit</button>
                        <!-- <a href="<?php echo base_url('obat/unduh_template_unit');?>" class="btn btn-md btn-success"><i class="fas fa-download"></i> Unduh ID Master Unit/Satuan</a> -->

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Import From Excel </h3>
                    <form action="#" id="formnih" class="form-horizontal" name="formnih">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Upload File (* .Xlsx / .xls) <br><small style="color:red">Wajib menggunakan template yang disediakan pada halaman ini</small></label>
                                <input  type="file" class="form-control btn btn-sm btn-default" id="excelfile" onChange="ExportToTable()"/>
                                </div>
                                <div class="form-group">
                                <h5 class="text-center danger" id="alertmsg" style="display: none;">Preview <span id="totaldatalbl"></span>  <br> <small style="color:red">* Jika terdapat kotak merah, maka ID kategori / ID unit tidak sesuai dengan data yang ada di database. Harap pastikan nilai sudah ada di database</small></h5>
                                <div style="overflow-y:scroll;width:100%;height:400px;">
                                    <table id="exceltable" class="table table-bordered">
                                    </table>
                                </div>
                                </div>

                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-primary" id="upbtn" onclick="save()"><i class="fa fa-upload"></i> Import</button>
                                <a class="btn btn-danger" href="<?php echo base_url('obat'); ?>">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#formnih").submit(function(e) {
            e.preventDefault();
            save();
        });
    });

    function save() {
        $('#upbtn').text('menyimpan...'); //change button text
        $('#upbtn').attr('disabled', true); //set button disable 

        $.ajax({
            url: "<?php echo base_url('obat/save_obat_import'); ?>",
            type: "POST",
            data: $('#formnih').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    if(data.withError){
                        popup('Perhatian', data.msg +"<br>"+data.list , 'info');
                    }else{
                        popup('Informasi', data.msg);
                    }
                    
                } else {
                    popup('Perhatian', data.msg, 'info');
                }

                $('#upbtn').text('Import'); //change button text
                $('#upbtn').attr('disabled', false); //set button enable 
            },
            error: function () {
                popup('Error !', 'Data kosong/ aksi dilarang', 'error');
                $('#upbtn').text('Import'); //change button text
                $('#upbtn').attr('disabled', false); //set button enable 
            }
        });
    }

    var tablesToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , tmplWorkbookXML = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
      + '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>'
      + '<Styles>'
      + '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
      + '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
      + '</Styles>' 
      + '{worksheets}</Workbook>'
    , tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>'
    , tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(tables, wsnames, wbname, appname) {
      var ctx = "";
      var workbookXML = "";
      var worksheetsXML = "";
      var rowsXML = "";

      for (var i = 0; i < tables.length; i++) {
        if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
        for (var j = 0; j < tables[i].rows.length; j++) {
          rowsXML += '<Row>'
          for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
            var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
            var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
            var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
            dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
            var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
            dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
            ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date')?' ss:StyleID="'+dataStyle+'"':''
                   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
                   , data: (dataFormula)?'':dataValue
                   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
                  };
            rowsXML += format(tmplCellXML, ctx);
          }
          rowsXML += '</Row>'
        }
        ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
        worksheetsXML += format(tmplWorksheetXML, ctx);
        rowsXML = "";
      }

      ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
      workbookXML = format(tmplWorkbookXML, ctx);



      var link = document.createElement("A");
      link.href = uri + base64(workbookXML);
      link.download = wbname || 'Workbook.xls';
      link.target = '_blank';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  })();
</script>
<script type="text/javascript">
  const master_kat = <?php echo json_encode($master_kat);?>;
  const master_un = <?php echo json_encode($master_un);?>;
  var err_;
  function ExportToTable() {  
        err_ = [];
        $("#upbtn").hide();
        $('#exceltable').empty();
         var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;  
         /*Checks whether the file is a valid excel file*/  
         if (regex.test($("#excelfile").val().toLowerCase())) {  
             var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/  
             if ($("#excelfile").val().toLowerCase().indexOf(".xlsx") > 0) {  
                 xlsxflag = true;  
             }  
             /*Checks whether the browser supports HTML5*/  
             if (typeof (FileReader) != "undefined") {  
                 var reader = new FileReader();  
                 reader.onload = function (e) {  
                     var data = e.target.result;  
                     /*Converts the excel data in to object*/  
                     if (xlsxflag) {  
                         var workbook = XLSX.read(data, { type: 'binary' });  
                     }  
                     else {  
                         var workbook = XLS.read(data, { type: 'binary' });  
                     }  
                     /*Gets all the sheetnames of excel in to a variable*/  
                     var sheet_name_list = workbook.SheetNames;  
      
                     var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/  
                     sheet_name_list.forEach(function (y) { /*Iterate through all sheets*/  
                         /*Convert the cell value to Json*/  
                         if (xlsxflag) {  
                             var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);  
                         }  
                         else {  
                             var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);  
                         }  
                         if (exceljson.length > 0 && cnt == 0) {  
                             BindTable(exceljson, '#exceltable');  
                             cnt++;  
                         }  
                     });  
                     $('#exceltable').show();
                     $("#upbtn").show();
                     if(err_.length > 0)
                        {
                        $("#upbtn").hide();
                        var err_note = '';
                        $.each( err_, function( key, value ) {
                            err_note += "<br>"+(key+1)+". "+value;
                        });
                        popup("Peringatan","Pada excel yang anda upload terdapat ID Kategori / ID Unit satuan yang belum terdaftar pada database","error");
                        } 
                 }  
                 if (xlsxflag) {/*If excel file is .xlsx extension than creates a Array Buffer from excel*/  
                     reader.readAsArrayBuffer($("#excelfile")[0].files[0]);  
                 }  
                 else {  
                     reader.readAsBinaryString($("#excelfile")[0].files[0]);  
                 }  
             }  
             else {  
                 alert("Sorry! Your browser does not support HTML5!");  
             }  
         }  
         else {  
             alert("Please upload a valid Excel file!");  
         }  
     }  
 
   function BindTable(jsondata, tableid) {/*Function used to convert the JSON array to Html Table*/  
        $("#alertmsg").show();
         var columns = BindTableHeader(jsondata, tableid);
         $("#totaldatalbl").empty();
         $("#totaldatalbl").text('( Total Data : '+jsondata.length+')');
         let nama; /*Gets all the column headings of Excel*/  
         for (var i = 0; i < jsondata.length; i++) {  
             var row$ = $('<tr/>');  
             for (var colIndex = 0; colIndex < columns.length; colIndex++) {  
                 var cellValue = jsondata[i][columns[colIndex]];  
                 if (cellValue == null)  
                     cellValue = "";  
                //  row$.append($('<td/>').html(cellValue));  
                switch (columns[colIndex]) {
                    case "Nama Obat":
                        nama = 'nama_obat'
                        break;
                    case "Deksripsi":
                        nama = 'deskripsi'
                        break;
                    case "ID Kategori":
                        nama = 'id_kategori'
                        break;
                    case "Penyimpanan":
                        nama = 'penyimpanan'
                        break;
                    case "ID Unit/ Satuan":
                        nama = 'id_satuan'
                        break;
                    case "Perlu Resep ? 1 = Ya, 0 = Tidak":
                        nama = 'resep'
                        break;
                    default:
                        nama = columns[colIndex]
                        break;
                }

                if(columns[colIndex] == "ID Kategori" && $.inArray(cellValue, master_kat) == -1){
                      //tidak ada di master !
                      err_.push(cellValue);
                      row$.append($('<td style="background-color:red; color:white;"/>').html("<input type='hidden' name='"+nama+"[]' value='"+cellValue+"'>"+cellValue));
                }else if(columns[colIndex] == "ID Unit/ Satuan" && $.inArray(cellValue, master_un) == -1){
                    
                      //tidak ada di master !
                      err_.push(cellValue);
                      row$.append($('<td style="background-color:red; color:white;"/>').html("<input type='hidden' name='"+nama+"[]' value='"+cellValue+"'>"+cellValue));
                    
                }else{
                    row$.append($('<td/>').html("<input type='hidden' name='"+nama+"[]' value='"+cellValue+"'>"+cellValue));
                }
             }  
             $(tableid).append(row$);  
         }  
     }  
     function BindTableHeader(jsondata, tableid) {/*Function used to get all column names from JSON and bind the html table header*/  
         var columnSet = [];  
         var headerTr$ = $('<tr/>');  
         for (var i = 0; i < jsondata.length; i++) {  
             var rowHash = jsondata[i];  
             for (var key in rowHash) {  
                 if (rowHash.hasOwnProperty(key)) {  
                     if ($.inArray(key, columnSet) == -1) {/*Adding each unique column names to a variable array*/  
                         columnSet.push(key);  
                         headerTr$.append($('<th/>').html(key));  
                     }  
                 }  
             }  
         }  
         $(tableid).append(headerTr$);  
         return columnSet;  
     }  


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>