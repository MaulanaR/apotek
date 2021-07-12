  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Obat Kadaluarsa
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- <div class="callout callout-info">
          <p>Gunakan Panel Admin sebagaimana anda bertanggung jawab dalam memutuskan tindakan yang anda lakukan .</p>
        </div> -->
        <div class="card">
          <div class="card-header text-left">
            <div class="btn-group">
              <button class="btn btn-sm btn-danger" onclick="toogleTable()"><i class="fas fa-file-medical"></i>Obat Kadaluarsa</button>
              <button class="btn btn-sm btn-warning" onclick="toogleTable()"><i class="fas fa-history"></i> Obat Hampir Kadaluarsa</button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-12">
                  <table id="table1" class="table table-bordered table-hover" style="width:100%;">
                    <thead>
                      <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text">Nama Obat</th>
                        <th class="text">Stok</th>
                        <th class="text">Expired Date</th>
                        <th class="text" width="5%"></th>
                      </tr>
                    </thead>
                    <tbody id='listkadaluarsa'>
                      <tr>
                        <td colspan="5" class="text-center">No Data</td>
                      </tr>
                    </tbody>
                  </table>
                  <table id="table2" class="table table-bordered table-hover" style="width:100%;display: none;">
                    <thead>
                      <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text">Nama Obat</th>
                        <th class="text">Stok</th>
                        <th class="text">Expired Date</th>
                        <th class="text" width="5%"></th>
                      </tr>
                    </thead>
                    <tbody id='listhampir'>
                      <tr>
                        <td colspan="5" class="text-center">No Data</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <!--Modal -->


  <script type="text/javascript">
  var listkadaluarsa = document.getElementById('listkadaluarsa');
  var listhampir = document.getElementById('listhampir');
  var table1 = document.getElementById('table1');
  var table2 = document.getElementById('table2');

    $(document).ready(function() {
      cekKadaluarsa();
    });

    function cekKadaluarsa(){
      $.ajax({
        url: "<?php echo base_url('obat/ajax_list_kadaluarsa'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          console.log(data.status);
          if(data.status){
            var totalitem = 0;
           if(data.statuskd){ 
            var dat = data.datakd;
            for (var i = 0; i < dat.length; ++i) {
              var x = dat[i];
              var temp = totalitem + parseInt(x[2]);
              totalitem = temp;
            }
            showNotif(2, 'Ada '+totalitem+' obat kadaluarsa!');
            appendToTable(data.datakd, 'kd');
            }
           if(data.statushr){
            showNotif(1, 'Ada obat hampir kadaluarsa');
            appendToTable(data.datahr, 'hr');
            }
          }
        }
      });
    }

    function appendToTable(data, table){
      var t;
      var limit = 5;//limit jumlah data yang ditampilkan
      var x = limit;
      if(table == 'kd'){
        t = listkadaluarsa;
      }else if(table == 'hr'){
        t = listhampir;
      }
      t.innerHTML = '';
      if(data.length < limit) x = data.length;
      for (var i = 0; i < x; ++i) {
        var dat = data[i];
        var row = document.createElement('tr');

        var cel = document.createElement('td');
            cel.innerHTML = i+1;
            row.appendChild(cel);
        var cel2 = document.createElement('td');
            cel2.innerHTML = '<a href=" <?php echo base_url('obat/detail');?>/'+dat[7]+'">'+dat[0]+'</a>';
            row.appendChild(cel2);
        var cel5 = document.createElement('td');
            cel5.innerHTML = dat[2];
            row.appendChild(cel5);    
        var cel3 = document.createElement('td');
            cel3.innerHTML = dat[1];
            row.appendChild(cel3);
        var cel4 = document.createElement('td');
            cel4.innerHTML = '<a><i class="fa fa-search"></i></a>';
            row.appendChild(cel4);
        t.appendChild(row);
      }
    }

    function showNotif(a,b){
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
      switch(a) {
        case 0:
          toastr.success(b);
          break;
        case 1:
          toastr.warning(b);
          break;
        case 2:
          toastr.error(b);
          break;
        case 3:
          toastr.info(b);
          break;
        default:
          // code block
      }
    }

    function toogleTable(){
      if(window.getComputedStyle(table2).display !== 'none') {
          table1.style.display = 'block';
          table2.style.display = 'none';
        }else{
          table1.style.display = 'none';
          table2.style.display = 'block';
        }
    }
  </script>