  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
           <?php echo $mo_nama; ?>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">    
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                  Detail Alat Kesehatan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class='row'>
              <div class="col-md-8">
                <div class="card-body">
                  <dl class="row">
                    <dt class="col-sm-8">Nomor barcode</dt>
                    <dd class="col-sm-8"><?php echo $mo_barcode; ?></dd>
                    <dt class="col-sm-8">Penyimpanan</dt>
                    <dd class="col-sm-8"><?php echo $mo_penyimpanan; ?></dd>
                    <dt class="col-sm-8">Kategori</dt>
                    <dd class="col-sm-8"><?php echo $mk_nama; ?></dd>
                    <dt class="col-sm-8">Deskripsi</dt>
                    <dd class="col-sm-8"><?php echo $mo_deskripsi; ?>
                    </dd>
                    <dt class="col-sm-8">Harga Beli</dt>
                  <dd class="col-sm-8">
                    <div id="hargabeli"></div>
                  </dd>
                  <dt class="col-sm-8">Harga Jual <a href="#" onclick="adj_harga()"><i class='fas fa-edit'></i></a></dt>
                  <dd class="col-sm-8">
                    <div id="hargajual"></div>
                  </dd>
                  </dl>
                  <div class="row">
                  <button type="button" class="btn btn-xs bg-gradient-success col-sm-2"><i class="fa fa-pencil-alt"></i>Edit</button>
                  <span style="width:15px"></span>
                  <button type="button" class="btn btn-xs bg-gradient-danger col-sm-2"><i class="fa fa-trash"></i>Hapus</button>
                  </div>
                </div>
              </div>
              <div class='col-md-4'>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title"><li class='fa fa-th-list'></li> Stok Tersedia</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body text-center">
                    <div id="stok">
                    </div>
                    <div class="btn-group">
                          <button type="button" class="btn btn-danger" onclick="min_stok()">Kurangi</button>
                          <button type="button" class="btn btn-warning" onclick="add_stok()">Tambah</button>
                    </div>
                  </div>
                </div>
              </div>

        
             </div><!-- /.row -->
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

  <!-- modal stok -->
  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form action="#" id="formaddstok" class="form-horizontal" name="formaddstok">
        <div class="modal-header">
          <h3 class="modal-title"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body form">
            <input type="hidden" value="<?php echo $mo_id; ?>" name="id" required/>
            <input type="hidden" id="tb_id" name="tb_id" required/>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label ">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
                <span class="help-block"></span>
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnSave" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>

   <div class="modal fade" id="modal_harga" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <form action="#" id="formharga" class="form-horizontal" name="formharga">
        <div class="modal-header">
          <h3 class="modal-title"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body form">
                    <div class='form-group'>
                      <label class="control-label ">Masukan Harga Baru</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="number" min='0' class="form-control col-sm-6">
                        <div class="input-group-append">
                          <span class="input-group-text">,00</span>
                        </div>
                        <span class="help-block"></span>
                      </div>
                    </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnSave" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>

  <script type="text/javascript">
    
$(document).ready(function() {

  var aksi_stok;

  $("#formaddstok").submit(function(e){
        e.preventDefault();
        save();
      });

  $.ajax({
        url : "<?php echo site_url('alkes/ajax_stok_obat_by_id/'). $mo_id .""; ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $.each(data.data, function(index, val){
            var a = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(val[8]);
            var b = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(val[9]);
            $('#tb_id').attr('value', val[3]);
            $("#stok").append("<h1><b>"+val[2]+"</b></h1><h6>"+val[7]+"</h6>");
            $("#hargabeli").append("<b>"+a+"</b>");
            $("#hargajual").append("<b>"+b+"</b>");
          });
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
});

function add_stok(id) {
      aksi_stok= 'insert';
      $('#formaddstok')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
      $('.modal-title').text('Tambah Stok'); // Set title to Bootstrap modal title

    }

function min_stok(id) {
      aksi_stok= 'take';
      $('#formaddstok')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
  
      $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
      $('.modal-title').text('Kurangi Stok'); // Set title to Bootstrap modal title
}

function adj_harga() {
      $('#formharga')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
  
      $('#modal_harga').modal('show'); // show bootstrap modal when complete loaded
      $('.modal-title').text('Ubah Harga Jual'); // Set title to Bootstrap modal title
}

function save() {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled', true); //set button disable 
      var url;

      if (aksi_stok == 'insert') {
        url = "<?php echo base_url('alkes/ajax_add_stok') ?>";
      } else {
        url = "<?php echo base_url('alkes/ajax_min_stok') ?>";
      }

      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#formaddstok').serialize(),
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

  </script>