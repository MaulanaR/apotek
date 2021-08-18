<div class="content-wrapper" style="min-height: 901px;">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Buat Retur Pembelian
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <form action="#" id="formnih" class="form-horizontal" name="formnih">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label ">Pilih Supplier</label>
                                <select class="sel form-control" onchange="setSupplier()" name="id_supplier" id="supplierid" require>
                                    <option satuan_obat="" kateg_obat="" desk_obat="" nama_obat="" value="">-- pilih Supplier --</option>
                                    <?php
                                    foreach ($list_supplier->result() as $key => $value_supplier) {
                                        $x = null;
                                        if ($value_supplier->ms_id == $id) {
                                            $x = 'selected';
                                        }
                                        echo '<option nama_supplier="' . $value_supplier->ms_nama . '" value="' . $value_supplier->ms_id . '" ' . $x . '>' . $value_supplier->ms_nama . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Pilih Item</label>
                                <select class="sel form-control" onchange="setItem()" name="id_obat" id="obatid" require>
                                    <option  nama_obat="" value="">-- pilih Item --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Pilih Batch Tersedia</label>
                                <select class="sel form-control" onchange="setBatch()" name="id_batch" id="batchid" require>
                                    <option value="" tgl="" stok="">-- pilih Batch --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Masukan Jumlah</label>
                                <input type='number' id="returQty" class='form-control' max="100" />
                                <button class="btn btn-primary" id="btnAdd" style="margin-top:5px;" disabled>Tambah ke Daftar</button>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Batch Terpilih</label><br/>
                                <label class="control-label" id="supplierTerpilih">Supplier: </label>
                                <table id='tablePilihan' class='table table-bordered table-hover dataTable dtr-inline'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bacth ID</th>
                                            <th>Nama Item</th>
                                            <th>Tanggal Input Batch</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Konfirmasi</label>
                                <input type='checkbox' name="returConsent" class='form-control' max="100" />
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
<script type="text/javascript">
    const sElem = $("#supplierid");
    const iElem = $("#obatid");
    const bElem = $("#batchid");
    const input = $("#returQty");
    let id_supplier = null;
    let mo_nama_pilihan = null;
    let id_item_pilihan = null;
    let tb_id_pilihan = null;
    let tgl_pilihan = null;
    let stok_pilihan = null;
    let list_pilihan = [];
    $("#btnAdd").on("click", function(){finishStage2()});

    $(document).ready(function() {
        $("#formnih").submit(function(e) {
            e.preventDefault();
        });
        $("#btnAdd").attr('disabled', true);
        input.val(0);
        input.attr('disabled', true);

    });

    function setSupplier(){
        id_supplier = $('option:selected', sElem).attr('value');
        const nama_supplier = $('option:selected', sElem).attr('nama_supplier');
        sElem.attr('disabled', true);
        $('#supplierTerpilih').append(nama_supplier);
        generateListObat();
    }

    function setItem(){
        id_item_pilihan = $('option:selected', iElem).attr('value');
        mo_nama_pilihan = $('option:selected', iElem).attr('nama_obat');
        if(id_item_pilihan){
            generateListBatch(id_item_pilihan);
        }
    }

    function setBatch(){
        tb_id_pilihan = $('option:selected', bElem).attr('value');
        tgl_pilihan = $('option:selected', bElem).attr('tgl');
        stok_pilihan = $('option:selected', bElem).attr('stok');
        if(tb_id_pilihan){
            prepareInputStok(stok_pilihan);
            freezeStage2();
        }
    }

    function finishStage2(){
        if(input.val() | input.val() != 0){
            stok_pilihan = input.val();
            addToList();
            emptyTemp();
            console.log(list_pilihan);
            renderTable();
            openStage2();
        }
    }

    function prepareInputStok(stok){
        input.val(stok);
        input.attr('max', stok);
        input.attr("disabled", false);
        $("#btnAdd").attr('disabled', false);
    }

    function freezeStage2(){
        iElem.attr("disabled", true);
        bElem.attr("disabled", true);
    }

    function openStage2(){
        iElem.attr("disabled", false);
        bElem.attr("disabled", false);
        bElem.val('default').selectpicker("refresh");
        $("#btnAdd").attr('disabled', true);
        input.val(0);
        input.attr("disabled", true);
    }

    function emptyTemp(){
        mo_nama_pilihan = null;
        id_item_pilihan = null;
        tb_id_pilihan = null;
        tgl_pilihan = null;
        stok_pilihan = null;
    }

    function generateListObat(){
        const obatid = $("#obatid");
        $.ajax({
            type: "post",
            url: "<?php echo base_url();?>retur_pembelian/get_obat_by_supplier/",
            data: {ms_id : id_supplier},
            dataType: "json",
            success: function (response) {
               console.log('called');
               console.log(response.data);
               $.each(response.data, function (indexInArray, valueOfElement){
                let mo_id = valueOfElement.mo_id;
                let mo_nama = valueOfElement.mo_nama;
                obatid.append('<option value="'+mo_id+'" nama_obat="'+mo_nama+'">'+mo_nama+'</option>');
               });
                obatid.selectpicker('refresh');
            },
            error: function (){
                alert('error!');
            }
        });
    }

    function generateListBatch(id){
        const batchid = $("#batchid");
        $.ajax({
            type: "post",
            url: "<?php echo base_url();?>retur_pembelian/get_batch_by_obat_id/",
            data: {mo_id : id},
            dataType: "json",
            success: function (response) {
               console.log('called');
               console.log(response.data);
               $.each(response.data, function (indexInArray, valueOfElement){
                let tb_id = valueOfElement.tb_id;
                let tb_tgl_masuk = valueOfElement.tb_tgl_masuk;
                let stok = valueOfElement.stok;
                let mu_nama = valueOfElement.mu_nama;
                batchid.append('<option value="'+tb_id+'" tgl="'+tb_tgl_masuk+'" stok="'+stok+'">ID : '+tb_id+' - Stok : '+stok+' '+mu_nama+' - Tanggal : '+tb_tgl_masuk+'</option>');
               });
                batchid.selectpicker('refresh');
            },
            error: function (){
                alert('error!');
            }
        });
    }

    function addToList(){
        let obj = {
            batch_id : tb_id_pilihan,
            item_id : id_item_pilihan,
            nama : mo_nama_pilihan,
            tgl : tgl_pilihan,
            quantity : stok_pilihan
        };

        const x = list_pilihan.push(obj);
        return (x - 1) ;
    }

    function renderTable(){
        const tableBody =  document.getElementById('tableBody');
        tableBody.innerHTML = '';
        let i = 0;
        $.each(list_pilihan, (a,b) => {
            i += 1;
            const baris = document.createElement('tr');
            const sel1 = document.createElement('td');
            const sel2 = document.createElement('td');
            const sel3 = document.createElement('td');
            const sel4 = document.createElement('td');
            const sel5 = document.createElement('td');
            const sel6 = document.createElement('td');

            sel1.innerHTML = i;
            sel2.innerHTML = b.batch_id;
            sel3.innerHTML = b.nama;
            sel4.innerHTML = b.tgl;
            sel5.innerHTML = b.quantity;
            sel6.innerHTML = "<button>Hapus</button>";

            baris.appendChild(sel1);
            baris.appendChild(sel2);
            baris.appendChild(sel3);
            baris.appendChild(sel4);
            baris.appendChild(sel5);
            baris.appendChild(sel6);

            tableBody.appendChild(baris);
        });
    }

</script>