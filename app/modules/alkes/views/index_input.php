<div class="content-wrapper" style="min-height: 901px;">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Input Alat Kesehatan Baru
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <form action="#" id="formnih" class="form-horizontal" name="formnih">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label ">Nama Item</label>
                                <input type="text" name="nama_obat" class="form-control" placeholder="Nama item" autofocus required>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Deskripsi Item</label>
                                <input type="text" name="des_obat" class="form-control" placeholder="Deskripsi item">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Kategori Item</label>
                                <select class="sel form-control" name="kategori_obat">
                                    <option value="3" selected>Alat Kesehatan</option>
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
                                <label class="control-label ">Supplier</label>
                                <select class="sel form-control" name="supplier">
                                <?php
                                    foreach ($this->db->get('m_supplier')->result() as $key => $value_unit) {
                                        echo '<option value="' . $value_unit->ms_id . '">' . $value_unit->ms_nama . '</option>';
                                    }
                                    ?>
                                </select required>
                                <span class="help-block"></span>
                            </div>
                             <div class="form-group">
                                <label class="control-label ">Stock Awal</label>
                                <input type="number" name="stock" class="form-control" placeholder="Lokasi Penyimpanan" value='1' min-value='1' required>
                                <span class="help-block"></span>
                            </div>
                             <div class="form-group">
                                <label class="control-label ">Harga Beli</label>
                                <input type="number" name="beli" class="form-control" placeholder="Harga Beli" value='1' min-value='1' required>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Harga Jual</label>
                                <input type="number" name="jual" class="form-control" placeholder="Harga Jual" value='1' min-value='1' required>
                                <span class="help-block"></span>
                            </div>
                            <?php
                            $temp = $this->alus_auth->getAlkesOrItemID('Item');
                            ?>
                            <!-- input id item ke tabel m_obat, SESUAIKAN dengan ID item di tabel m_unit-->
                            <input type="hidden" class="form-control" name="unit" value="<?php echo $temp->mu_id; ?>">
                            <input type='hidden' name='resep' value='0'>
                            <!-- input fake resep-->
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
        url: "<?php echo base_url('alkes/save_obat_new');?>",
        type: "POST",
        data: $('#formnih').serialize(),
        dataType: "JSON",
        success: function(data) {

          if (data.status) //if success close modal and reload ajax table
          {
            popup('Informasi', 'Data berhasil di simpan');
            setTimeout(function (){
              window.location = "<?php echo base_url('alkes/detail/');?>" + data.id;
              }, 2000);
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