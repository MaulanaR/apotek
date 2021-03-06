  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Obat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="<?php echo base_url("obat/deactivated"); ?>">Lihat Obat Nonaktif</a></li>
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
          <div class="card-header ">
            <div class="row">
              <div class="col-md-6 text-left">
                <a href="<?php echo base_url('obat/import');?>" class="btn btn-sm btn-warning"><i class="fas fa-file-import"></i> Import Excel</a>
              </div>
              <div class="col-md-6 text-right">
                <div class="btn-group">
                  <?php if ($can_add == 1) { ?>
                    <a href="<?php echo base_url('obat/input'); ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah</a>
                  <?php } ?>
                  <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="fas fa-retweet"></i> Reload</button>
                </div>
              </div>
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
                        <th class="text">Nama Obat</th>
                        <th class="text">Deskripsi</th>
                        <th class="text">Kategori</th>
                        <th class="text">Barcode</th>
                        <th class="text">Penyimpanan</th>
                        <th class="text">Unit</th>
                        <th class="text">Resep</th>
                        <th class="text-center" width="5%"></th>
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

  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="#" id="formnih" class="form-horizontal" name="formnih">
          <div class="modal-header">
            <h3 class="modal-title">Edit Master Obat</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body form">
            <input type="hidden" value="" name="id" required />
            <div class="form-body">
              <div class="form-group">
                <label class="control-label ">Nama Obat</label>
                <input type="text" name="nama_obat" class="form-control" placeholder="Nama Obat" required>
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <label class="control-label ">Deskripsi Obat</label>
                <input type="text" name="des_obat" class="form-control" placeholder="Deskripsi Obat">
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <label class="control-label ">Kategori Obat</label>
                <select class="sel form-control" name="kategori_obat" required>
                  <?php
                  foreach ($this->db->get('m_kategori')->result() as $key => $value_kategori) {
                    if ($value_kategori->mk_id != $this->alus_auth->getAlkesOrItemID('Alkes')->mk_id) {
                      echo '<option value="' . $value_kategori->mk_id . '">' . $value_kategori->mk_nama . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label ">Barcode</label>
                <input type="hidden" name="old_barcode" class="form-control" placeholder="Barcode" required>
                <input type="text" name="barcode" class="form-control" placeholder="Barcode" required>
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <label class="control-label ">Penyimpanan</label>
                <input type="text" name="penyimpanan" class="form-control" placeholder="Lokasi Penyimpanan">
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <label class="control-label ">Unit/ Satuan</label>
                <select class="sel form-control" name="unit" required>
                  <?php
                  foreach ($this->db->get('m_unit')->result() as $key => $value_unit) {
                    echo '<option value="' . $value_unit->mu_id . '">' . $value_unit->mu_nama . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label ">Apakah obat ini perlu resep?</label>
                <select class="sel form-control" name="resep">
                  <option value="1">Ya</option>
                  <option value="0">Tidak</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnSave" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
      </div><!-- /.modal-content -->
      </form>
    </div><!-- /.modal-dialog -->
  </div>
  <!-- / Modal -->

  <script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).on("preInit.dt", function() {
      var $sb = $(".dataTables_filter input[type='search']");
      // remove current handler
      $sb.off();
      // Add key hander
      $sb.on("keypress", function(evtObj) {
        if (evtObj.keyCode == 13) {
          table.search($sb.val()).draw();
        }
      });
    });

    $(document).ready(function() {
      $("#formnih").submit(function(e) {
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
          "url": "<?php echo base_url('obat/ajax_list') ?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [{
          "targets": [2, 3, 4, 5, 6], //last column
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
      save_method = 'update';
      $('#formnih')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
        url: "<?php echo base_url('obat/ajax_edit/') ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('[name="id"]').val(data.mo_id);
          $('[name="nama_obat"]').val(data.mo_nama);
          $('[name="des_obat"]').val(data.mo_deskripsi);
          $('[name="kategori_obat"]').val(data.mo_mk_id);
          $('[name="barcode"]').val(data.mo_barcode);
          $('[name="old_barcode"]').val(data.mo_barcode);
          $('[name="penyimpanan"]').val(data.mo_penyimpanan);
          $('[name="unit"]').val(data.mo_mu_id);
          $('[name="resep"]').val(data.mo_resep);

          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          //$('.modal-title').text('Edit Group'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });
    }

    function reload_table() {
      table.ajax.reload(null, false); //reload datatable ajax 
    }



    function save() {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled', true); //set button disable 
      var url;

      if (save_method == 'add') {
        url = "<?php echo base_url('obat/ajax_add') ?>";
      } else {
        url = "<?php echo base_url('obat/ajax_update') ?>";
      }

      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#formnih').serialize(),
        dataType: "JSON",
        success: function(data) {

          if (data.status) //if success close modal and reload ajax table
          {
            popup('Informasi', 'Data berhasil di update');
            $('#modal_form').modal('hide');
            reload_table();
          } else {
            popup('Perhatian', data.msg, 'info');
            reload_table();
          }

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
        }
      });
    }

    function delete_person(id) {
      if (confirm('Apakah anda yakin ingin menghapus data?')) {
        // ajax delete data to database
        $.ajax({
          url: "<?php echo base_url('obat/ajax_delete') ?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if (data.status) //if success close modal and reload ajax table
            {
              //$('#modal_form').modal('hide');
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