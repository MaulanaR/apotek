<div class="content-wrapper" style="min-height: 901px;">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Alat Kesehatan
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <form action="#" id="formnih" class="form-horizontal" name="formnih">
                        <div class="form-body">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $mo_id; ?>">
                                <label class="control-label ">Nama Item</label>
                                <input type="text" name="nama_obat" class="form-control" placeholder="Nama item" value="<?php echo $mo_nama; ?>" autofocus required>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Deskripsi Item</label>
                                <textarea name="des_obat" class="form-control" placeholder="Deskripsi item"><?php echo $mo_deskripsi; ?></textarea>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Kategori Item</label>
                                <input type="hidden" name="f_kat" class="form-control" value="<?php echo $mo_id; ?>" disabled>
                                <input type="text" class="form-control" value="Alat Kesehatan" disabled>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Barcode</label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="hidden" name="old_barcode" class="form-control" value="<?php echo $mo_barcode; ?>">
                                        <input type="text" name="barcode" class="form-control" value="<?php echo $mo_barcode; ?>" required>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-sm bg-navy" onclick="get_barcode()"><i class="fa fa-retweet"></i> Auto Generate</button>
                                    </div>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Penyimpanan</label>
                                <input type="text" name="penyimpanan" class="form-control" placeholder="Lokasi Penyimpanan" value="<?php echo $mo_penyimpanan; ?>">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-12 pb-3">
                                <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
                                <a class="btn btn-danger" href="<?php echo base_url('alkes'); ?>">Cancel</a>
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
        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "<?php echo base_url('alkes/ajax_update') ?>";

        $.ajax({
        url: url,
        type: "POST",
        data: $('#formnih').serialize(),
        dataType: "JSON",
        success: function(data) {

          if (data.status) //if success close modal and reload ajax table
          {
            popup('Informasi', 'Data berhasil di update');
            setTimeout(function (){
              window.location = "<?php echo base_url('alkes/detail/'). $mo_id ; ?>";
              }, 2000);
            
          } else {
            popup('Perhatian', data.msg, 'info');
          }
        }
      });
    }

    function get_barcode() {
        $.ajax({
        url: "<?php echo base_url('alkes/get_barcode');?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="barcode"]').val(data);
        },
        error: function(){
            popup("Error","Tidak dapat generate barcode","danger");
        }
      });
    }
</script>