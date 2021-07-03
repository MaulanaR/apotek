<div class="content-wrapper" style="min-height: 901px;">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Input Obat Baru
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <form action="#" id="formnih" class="form-horizontal" name="formnih">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label ">Nama Obat</label>
                                <input type="text" name="nama_obat" class="form-control" placeholder="Nama Obat" autofocus required>
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
                                        if($value_kategori->mk_id != $this->alus_auth->getAlkesOrItemID('Alkes')->mk_id){
                                        echo '<option value="' . $value_kategori->mk_id . '">' . $value_kategori->mk_nama . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Barcode</label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" name="barcode" class="form-control" placeholder="Barcode" required>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-sm bg-navy" onclick="get_barcode()"><i class="fa fa-retweet"></i> Auto Generate</button>
                                    </div>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Penyimpanan</label>
                                <input type="text" name="penyimpanan" class="form-control" placeholder="Lokasi Penyimpanan">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Unit/ Satuan</label>
                                <select class="sel form-control" name="unit" required>
                                    <?php
                                    foreach ($this->db->get('m_unit')->result() as $key => $value_unit) {
                                        echo '<option value="' . $value_unit->mu_id . '">' . $value_unit->mu_nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="sel control-label ">Apakah obat ini perlu resep?</label>
                                <select class="form-control" name="resep">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="col-12 pb-3">
                                <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
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
        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        $.ajax({
        url: "<?php echo base_url('obat/save_obat_new');?>",
        type: "POST",
        data: $('#formnih').serialize(),
        dataType: "JSON",
        success: function(data) {

          if (data.status) //if success close modal and reload ajax table
          {
            popup('Informasi', 'Data berhasil di simpan');
          } else {
            popup('Perhatian', data.msg, 'info');
          }

          $('#btnSave').text('Simpan'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
        }
      });
    }

    function get_barcode() {
        $.ajax({
        url: "<?php echo base_url('obat/get_barcode');?>",
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