<script src="<?php echo base_url('assets/temaalus/dist/currencyjs/autoNumeric.js'); ?>"></script>
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
                                <select class="sel form-control" onchange="get_sel()" name="id_obat" id="obatid" require>
                                    <option satuan_obat="" kateg_obat="" desk_obat="" nama_obat="" value="">-- pilih obat --</option>
                                    <?php
                                    foreach ($list_obat->result() as $key => $value_obat) {
                                        $x = null;
                                        if ($value_obat->mo_id == $id) {
                                            $x = 'selected';
                                        }
                                        echo '<option satuan_obat="' . $value_obat->mu_nama . '" kateg_obat="' . $value_obat->mk_nama . '" desk_obat="' . $value_obat->mo_deskripsi . '" nama_obat="' . $value_obat->mo_nama . '" value="' . $value_obat->mo_id . '" ' . $x . '>' . $value_obat->mo_barcode . ' - ' . $value_obat->mo_nama . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <table class="table table-hovered" border="1px" style="width: 50%;">
                                    <tr>
                                        <td class="bg-olive" style="width: 50%;">Nama Obat</td>
                                        <td id="info_nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-olive" style="width: 50%;">Deskripsi Obat</td>
                                        <td id="info_desk"></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-olive" style="width: 50%;">Kategori Obat</td>
                                        <td id="info_kategori"></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-olive" style="width: 50%;">Unit/Satuan Obat</td>
                                        <td id="info_satuan"></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group">
                                <label class="control-label ">Tanggal Batch/Kadaluarsa Tersedia</label>
                                <div class="row">
                                    <div class="col-8">
                                        <select name="tgl_tersedia" id="tgl_tersedia" class="sel form-control">
                                            
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button id="tambah" type="button" class="btn btn-sm bg-navy" Onclick="tambah_batch()"><i class="fa fa-star"></i> Tambah batch baru</button>
                                        <button id="cancel" type="button" class="btn btn-sm bg-red" style="display: none;" Onclick="cancel_batch()"><i class="fa fa-star"></i> Cancel batch baru</button>
                                    </div>
                                </div>
                                <span class="help-block"></span>
                            </div>

                            <div id="sudah_ada" style="display: none;border:1px solid red; margin-bottom:5px" class="p-5">

                                <div class="form-group">
                                    <label class="control-label ">Tanggal Batch</label>
                                    <input type="date" class="form-control" name="tanggal" id="tgl">
                                    <input type="hidden" class="form-control" name="baru" value="0" id="baru">
                                    <span class="help-block"></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label ">Supplier</label>
                                    <select class="sel form-control" name="supplier">
                                        <?php
                                        foreach ($list_suppliers->result() as $key => $value_supplier) {
                                            echo '<option value="' . $value_supplier->ms_id . '">' . $value_supplier->ms_nama . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label ">Harga Beli</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" name="harga_beli" id="harga_beli" class="form-control" placeholder="Harga Beli">
                                    </div>
                                    <span class="help-block"></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label ">Harga Jual</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" name="harga_jual" id="harga_jual" class="form-control" placeholder="Harga Jual">
                                    </div>
                                    <span class="help-block"></span>
                                </div>

                            </div>
                            <div class="form-group" id="perubahan">
                                <label class="control-label ">Jenis Perubahan</label>
                                <select class="sel form-control" name="jenis" required>
                                    <option value="penambahan">Penambahan Stock</option>
                                    <option value="pengurangan" <?php if(isset($_GET['tipe']) && $_GET['tipe'] == "pengurangan"){ echo 'selected'; } ?> >Pengurangan Stock </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label ">Stock</label>
                                <input type="number" min="0" name="stock" class="form-control" placeholder="Stock (number)" require>
                            </div>

                            <div class="form-group">
                                <label class="control-label ">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="keterangan" cols="3" rows="4"></textarea>
                            </div>

                            <div class="col-12 pb-3">
                                <button type="submit" class="btn btn-primary" id="btnSave">Update</button>
                                <button type="button" class="btn btn-danger" onclick="window.history.go(-1)">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    var tp = null;
    $(document).ready(function() {
        tp = "<?php if(isset($_GET['tbid'])){echo $_GET['tbid'];}else{echo 'null';}?>";
        $("#formnih").submit(function(e) {
            e.preventDefault();
            save();
        });

        get_sel();
        $("#harga_jual").autoNumeric('init');
        $("#harga_beli").autoNumeric('init');
    });

    function tambah_batch() {
        $("#cancel").show();
        $("#perubahan").hide();
        $("#sudah_ada").show();
        $("#tambah").hide();
        $("#baru").val('1');
    }

    function cancel_batch() {
        $("#tambah").show();
        $("#cancel").hide();
        $("#sudah_ada").hide();
        $("#perubahan").show();
        $("#baru").val('0');

    }

    function save() {
        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        $.ajax({
            url: "<?php echo base_url('obat/save_stock'); ?>",
            type: "POST",
            data: $('#formnih').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    popup('Informasi', 'Data berhasil di simpan');
                    window.history.go(-1);
                } else {
                    popup('Perhatian', data.msg, 'info');
                }

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function get_sel() {
        var c = $("#obatid");
        var nama_obat = $('option:selected', c).attr('nama_obat');
        var satuan_obat = $('option:selected', c).attr('satuan_obat');
        var kateg_obat = $('option:selected', c).attr('kateg_obat');
        var desk_obat = $('option:selected', c).attr('desk_obat');
        var valx = $('option:selected', c).attr('value');

        $("#info_nama").text(nama_obat);
        $("#info_desk").text(desk_obat);
        $("#info_kategori").text(kateg_obat);
        $("#info_satuan").text(satuan_obat);

        $("#tgl_tersedia").empty();
        $.ajax({
            type: "get",
            url: "<?php echo base_url();?>obat/get_batch/"+valx,
            dataType: "json",
            success: function (response) {
                $("#tgl_tersedia").append('<option value="">-- pilih tanggal batch --</option>');
                $.each(response.data, function (indexInArray, valueOfElement) { 
                    if(valueOfElement.tb_id == tp)
                    {
                        $("#tgl_tersedia").append('<option value="'+valueOfElement.tb_id+'" selected>'+valueOfElement.tb_tgl_kadaluarsa+'</option>');
                    }else{
                        $("#tgl_tersedia").append('<option value="'+valueOfElement.tb_id+'">'+valueOfElement.tb_tgl_kadaluarsa+'</option>');
                    }
                });
                $('#tgl_tersedia').selectpicker('refresh');
                $('#tgl_tersedia').selectpicker('render');
            }
        });
    }
</script>