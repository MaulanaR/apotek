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
                    <dt class="col-sm-8">Nomor barcode <a href="" onclick="printBarcode()"><i class="fas fa-print"></i></a></dt>
                    <dd class="col-sm-8 text-center" id="imgbarcode"><p style="text-align: center;"><img class="img" src="<?php echo base_url('assets/barcode/barcode.php?codetype=codabar&print=false&size=35&sizefactor=3&text=').$mo_barcode;?>'"><br/><strong style="letter-spacing: 4px;"><?php echo $mo_barcode; ?></strong></p></dd>
                    <dt class="col-sm-8">Penyimpanan</dt>
                    <dd class="col-sm-8"><?php echo $mo_penyimpanan; ?></dd>
                    <dt class="col-sm-8">Kategori</dt>
                    <dd class="col-sm-8"><?php echo $mk_nama; ?></dd>
                    <dt class="col-sm-8">Pajak</dt>
                    <?php
                      $a = "";
                      if($mo_ppn_10 == 1){
                        $a = "checked";
                      }
                    ?>
                    <dd class="col-sm-8">
                      <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                          <input type="checkbox" class="custom-control-input" id="customSwitch3" <?php echo $a;?>>
                          <label class="custom-control-label" for="customSwitch3">PPN 10%</label>
                        </div>
                      </div>
                    </dd>
                    <dt class="col-sm-8">Deskripsi</dt>
                    <dd class="col-sm-8"><?php echo $mo_deskripsi; ?>
                    </dd>
                    <dt class="col-sm-8">Harga Beli</dt>
                  <dd class="col-sm-8">
                    <div id="hargabeli"></div>
                  </dd>
                  <dt class="col-sm-8">Harga Jual <a href="#" data-toogle='modal' data-target='#modal_harga' onclick="adj_harga()"><i class='fas fa-edit'></i></a></dt>
                  <dd class="col-sm-8">
                    <div id="hargajual"></div>
                  </dd>
                  </dl>
                  <div class="row">
                  <button type="button" class="btn btn-xs bg-gradient-success col-sm-2" onclick="edit()"><i class="fa fa-pencil-alt"></i>Edit</button>
                  </div>
                </div>
              </div>
              <div class='col-md-4'>
                <div class="card card-primary m-2">
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
                  <div class="card-body">
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item">Disuplai oleh <b id="supplier"></b></li>
                    </ul>
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
              <div id="fgroup1" class="form-group">
                
              </div>
              <div id="fgroup2" class="form-group">
                
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

  var aksi;
  var hargajual;

  load_data();

  $("#formaddstok").submit(function(e){
        e.preventDefault();
        save();
      });
  
});

function reset_field(){
  //reset semua dynamic field
  $('#tb_id').attr('value', '0');
  $("#stok").empty();
  $("#hargabeli").empty();
  $("#hargajual").empty();
  $("#supplier").empty();
}

function printBarcode(){
      var barcode = document.getElementById('imgbarcode');
      var print = window.open();
      print.document.write('<html><head><style>@page { size: auto;  margin: 0mm;}</style></head><body style="float: left;">');
      print.document.write(barcode.innerHTML);
      print.document.write('</body></html>');
      print.document.close();
      
      setTimeout(function() {
        print.focus();
        print.print();
        print.close();
      }, 100);
      
    }

function load_data(){
  reset_field();//reset sebelum diisi data
  $.ajax({
        url : "<?php echo site_url('alkes/ajax_stok_obat_by_id/'). $mo_id .""; ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $.each(data.data, function(index, val){
            var a = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(val[8]);
            hargajual = val[9];
            var b = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(val[9]);
            $('#tb_id').attr('value', val[3]);
            $("#stok").append("<h1><b>"+val[2]+"</b></h1><h6>"+val[7]+"</h6>");
            $("#hargabeli").append("<b>"+a+"</b>");
            $("#hargajual").append("<b>"+b+"</b>");
            $("#supplier").append(val[10]);
          });
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function add_stok(id) {
      aksi= 'insert';
      $('#formaddstok')[0].reset(); // reset form on modals
      $('.form-group').empty();//reset input container
      $('.form-group').removeClass('has-error'); // clear error class
      $('#fgroup1').append('<label class="control-label ">Jumlah</label><input type="number" name="jumlah" class="form-control" min="1" required><span class="help-block"></span>');
      $('#fgroup2').append('<label class="control-label ">Keterangan</label><textarea name="keterangan" class="form-control"></textarea><span class="help-block"></span>');
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
      $('.modal-title').text('Tambah Stok'); // Set title to Bootstrap modal title
}

function min_stok(id) {
      aksi= 'take';
      $('#formaddstok')[0].reset(); // reset form on modals
      $('.form-group').empty();//reset input container
      $('.form-group').removeClass('has-error'); // clear error class
      $('#fgroup1').append('<label class="control-label ">Jumlah</label><input type="number" name="jumlah" class="form-control" min="1" required><span class="help-block"></span>');
      $('#fgroup2').append('<label class="control-label ">Keterangan</label><textarea name="keterangan" class="form-control"></textarea><span class="help-block"></span>');
      $('.help-block').empty(); // clear error string
  
      $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
      $('.modal-title').text('Kurangi Stok'); // Set title to Bootstrap modal title
}

function adj_harga() {
      aksi = 'ubah_harga';
      $('#formaddstok')[0].reset(); // reset form on modals
      $('.form-group').empty();//reset input container
      $('#fgroup1').append('<label class="control-label ">Masukan Harga Baru</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">Rp.</span></div><input type="number" name="harga" min="1" class="form-control col-sm-6" value="'+ hargajual +'" required><div class="input-group-append"><span class="input-group-text">,00</span></div><span class="help-block"></span></div>');
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
  
      $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
      $('.modal-title').text('Ubah Harga Jual'); // Set title to Bootstrap modal title
}

function save() {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled', true); //set button disable 
      var url;

      if (aksi == 'insert') {
        url = "<?php echo base_url('alkes/ajax_add_stok') ?>";
      } else if (aksi == 'take'){
        url = "<?php echo base_url('alkes/ajax_min_stok') ?>";
      } else {
        url = "<?php echo base_url('alkes/ajax_adj_harga') ?>";
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
            load_data();
          } else {
            popup('Perhatian', data.msg, 'info');
            load_data();
            
          }

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
        }
      });
    }

    function edit(){
      window.location = "<?php echo base_url('alkes/index_edit/'). $mo_id ; ?>";
    }

  </script>