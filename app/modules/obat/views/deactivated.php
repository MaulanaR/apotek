<div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Obat Nonaktif</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url("obat"); ?>">Master Obat</a></li>
              <li class="breadcrumb-item active">Nonaktif</li>
            </ol>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- <div class="callout callout-info">
          <p>Gunakan Panel Admin sebagaimana anda bertanggung jawab dalam memutuskan tindakan yang anda lakukan .</p>
        </div> -->
        <div class="card">
          <div class="card-header text-left">
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="col-12">
                  <table id="table1" class="table table-bordered table-hover" style="width:100%;">
                    <thead>
                      <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text">Nama Obat</th>
                        <th class="text-center">Batch ID</th>
                        <th class="text-center">Expired Date</th>
                        <th class="text" width="5%"></th>
                      </tr>
                    </thead>
                    <tbody id='list'>
                      <tr>
                        <td colspan="5" class="text-center">No Data</td>
                      </tr>
                    </tbody>
                  </table>    
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
  var list = document.getElementById('list');
  var table1 = document.getElementById('table1');

    $(document).ready(function() {
      load();
    });

    function load(){
      $.ajax({
        url: "<?php echo base_url('obat/ajax_list_nonaktif'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          //console.log(data.datakd);
          if(data.status){
           appendToTable(data.data);
          }
        }
      });
    }

    function appendToTable(data){
      var limit = 5;//limit jumlah data yang ditampilkan
      var x = limit;
      list.innerHTML = '';
      if(data.length < limit) x = data.length;
      for (var i = 0; i < x; ++i) {
        var dat = data[i];
        var row = document.createElement('tr');

        var cel = document.createElement('td');
            cel.innerHTML = i+1;
            row.appendChild(cel);
        var cel2 = document.createElement('td');
            cel2.innerHTML = '<a href=" <?php echo base_url('obat/detail');?>/'+dat[0]+'">'+dat[2]+'</a>';
            row.appendChild(cel2);
        var cel6 = document.createElement('td');
            cel6.innerHTML = dat[1];
            row.appendChild(cel6);
        var cel5 = document.createElement('td');
            cel5.innerHTML = dat[3];
            row.appendChild(cel5);    
        var cel4 = document.createElement('td');
            cel4.innerHTML = '<a href="<?php echo base_url("obat/batch_detail");?>/'+dat[0]+'?tbid='+dat[1]+'"><i class="fa fa-search"></i></a>';
            row.appendChild(cel4);
        list.appendChild(row);
      }
    }
  </script>