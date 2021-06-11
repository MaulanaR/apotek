  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Master Alat Kesehatan
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header text-right">
            <div class="btn-group">
              <?php if ($can_add == 1) { ?>
                <a href="<?php echo base_url('alkes/input'); ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah</a>
              <?php } ?>
              <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="fas fa-retweet"></i> Reload</button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-12">
                  <table id="table" class="table table-bordered table-hover dataTable dtr-inline">
                    <thead>
                      <tr>
                        <th class="text">Nama Item</th>
                        <th class="text">Deskripsi</th>
                        <th class="text">Barcode</th>
                        <th class="text">Penyimpanan</th>
                        <th class="text">Unit</th>
                        <th class="text-center" width="5%"></th>
                        <th class="text-center" width="5%"></th>
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
  <!--Modal -->


  <script type="text/javascript">
    var table;

    $(document).on("preInit.dt", function () {
    var $sb = $(".dataTables_filter input[type='search']");
    // remove current handler
    $sb.off();
    // Add key hander
    $sb.on("keypress", function (evtObj) {
        if (evtObj.keyCode == 13) {
            table.search($sb.val()).draw();
        }
    });
});

    $(document).ready(function() {
      $("#formnih").submit(function(e){
        e.preventDefault();
        save();
      });
      //datatables
      table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        scrollX: true,
        scroller: true,
        stateSave: true,
        searchDelay: 3050,

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo base_url('alkes/ajax_list') ?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [{
          "targets": [2, 3, 4, 5], //last column
          "orderable": true, //set not orderable
          "className": "text-center",
        }, ],
        "lengthMenu": [
          [10, 25, 100, 1000, -1],
          [10, 25, 100, 1000, "All"]
        ],
      });

    });

    function edit_person(id) {
      window.location = "<?php echo base_url('alkes/index_edit/')?>" + id;
    }

    function reload_table() {
      table.ajax.reload(null, false); //reload datatable ajax 
    }

    function delete_person(id) {
      if (confirm('Apakah anda yakin ingin menghapus data?')) {
        // ajax delete data to database
        $.ajax({
          url: "<?php echo base_url('alkes/ajax_delete') ?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if (data.status) //if success close modal and reload ajax table
            {
              popup('Informasi', 'Berhasil');
              reload_table();
            } else {
              popup('Perhatian', data.msg, 'info');
              reload_table();
            }
          }
        });

      }
    }
  </script>