  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Retur Pembelian
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="callout callout-info">
          <p>Berikut adalah daftar produk/item yang telah diretur.</p>
        </div>
          <div class="card">
            <div class="card-header text-right">
              <div class="btn-group">
                  <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="fas fa-retweet"></i> Reload</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-12">
                    <table id="table" class="table table-bordered table-hover dataTable dtr-inline" style="width: 100%">
                      <thead>
                      <tr>
                        <th width='5%'>No</th>
                        <th width='5%'>ID</th>
                        <th width='5%'>Batch ID</th>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Supplier</th>
                        <th width='5%'></th>
                      </tr>
                      </thead>
                      <tbody>

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


  <script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {

    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        scroller:true,
        scrollX : true,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('retur_pembelian/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [1,2,3,4,5], //last column
            "orderable": false, //set not orderable
            "className":"text-center",
        },
        { 
            "targets": [5], //last column
            "className":"text-center",
        },
        ],
    });
});
 
function detail(a){
  window.location = '<?php echo base_url('retur/retur_detail/'); ?>' + a;
}
 
function reload_table()
{
    table.ajax.reload(null,false); 
}

function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('unit/ajax_delete')?>/",
            type: "POST",
            data:{'id' : id},
            dataType: "JSON",
            success: function(data)
            {
               if(data.status) //if success close modal and reload ajax table
              {
                  $('#modal_form').modal('hide');
                  popup('Informasi','Data berhasil dihapus');
                  reload_table();
              }else{
                  popup('Perhatian',data.msg,'info');
                  reload_table();
              }
            }
        });
 
    }
}


</script>