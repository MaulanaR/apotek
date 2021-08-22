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
                <div class='card-header'>
                    <span>Form Retur Pembelian <?php echo $kode; ?></span>
                </div>
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
                                <label class="control-label ">Pilih Batch</label>
                                <select class="sel form-control" onchange="setItem()" name="id_obat" id="obatid" require>
                                    <option value="" tgl="" stok="" nama="" moId="">Pilih Item</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label ">Masukan Jumlah</label>
                                <input type='number' id="returQty" class='form-control' max="100" />
                                <button class="btn btn-primary" id="btnAdd" style="margin-top:5px;" disabled>Tambah ke Daftar</button>
                            </div>
                            <div class="form-group">
                                <label class="control-label" id="supplierTerpilih">Supplier: </label><br/>
                                <label class="control-label">Batch Terpilih</label>
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
                            <div class="col-12 pb-3">
                                <button type="button" class="btn btn-primary" id="btnSave" onclick="saveReturPembelian()">Update</button>
                                <button type="button" class="btn btn-danger" id="btnCancel" onclick="window.history.go(-1)">Batal</button>
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
    const input = $("#returQty");
    const btnAdd = $("#btnAdd");
    const uniqid = '<?php echo $kode; ?>';
    let id_supplier = null;
    let mo_nama_pilihan = null;
    let id_item_pilihan = null;
    let tb_id_pilihan = null;
    let tgl_pilihan = null;
    let stok_pilihan = null;
    let list_pilihan = [];
    $("#btnAdd").on("click", function(){finishStage2()});
    input.on("keyup", function(){userInput(this.value)});
    $("btnSave").on("click", function(){saveReturPembelian()});

    $(document).ready(function() {
        $("#formnih").submit(function(e) {
            e.preventDefault();
        });
        $("#btnAdd").attr('disabled', true);
        input.val(0);
        input.attr('disabled', true);
        $('#btnSave').attr('disabled', true);

    });

    function addToList(){
        let obj = {
            batchId : tb_id_pilihan,
            itemId : id_item_pilihan,
            nama : mo_nama_pilihan,
            tgl : tgl_pilihan,
            quantity : stok_pilihan
        };

        const x = list_pilihan.push(obj);
        return (x - 1) ;
    }

    function checkList(id){
        let match = false;
        if(id){
            if(list_pilihan.length > 0){
                for(let i = 0; i < list_pilihan.length; i++){
                    if(list_pilihan[i].batchId == id){
                        match = true;
                    }
                }
            }
        }
        return match;
    }

    function removeFromList(index){
        list_pilihan.splice(parseInt(index), 1);
        renderTable();
    }

    function userInput(i){
        if(i > parseInt(stok_pilihan)){
            input.val(stok_pilihan);
        }else if(i < 0){
            input.val(1);
        }else{
            input.val(parseInt(i));
        }
    }

    function contentChecker(){
        if(list_pilihan.length > 0){
            $('#btnSave').attr('disabled', false);
        }else{
            $('#btnSave').attr('disabled', true);
        }
    }

    function setSupplier(){
        id_supplier = $('option:selected', sElem).attr('value');
        const nama_supplier = $('option:selected', sElem).attr('nama_supplier');
        sElem.attr('disabled', true);
        sElem.selectpicker('refresh');
        $('#supplierTerpilih').append(nama_supplier);
        generateListObat();
    }

    function setItem(){
        tb_id_pilihan = $('option:selected', iElem).attr('value');
        if(tb_id_pilihan){
            id_item_pilihan = $('option:selected', iElem).attr('moId');
            mo_nama_pilihan = $('option:selected', iElem).attr('nama');
            tgl_pilihan = $('option:selected', iElem).attr('tgl');
            stok_pilihan = $('option:selected', iElem).attr('stok');
            if(checkList(tb_id_pilihan)){
                popup('Perhatian', 'Batch '+tb_id_pilihan+' sudah ada dalam daftar!', 'info');
            }else{
                prepareInputStok(stok_pilihan);
            }
            iElem.selectpicker('deselectAll');
            iElem.find('option').attr('selected', false);
        }
    }

    function finishStage2(){
        console.log('add'+input.val());
        if(input.val() | parseInt(input.val()) != 0){
            if(parseInt(input.val()) <= parseInt(stok_pilihan)){
                stok_pilihan = input.val();
                addToList();
                emptyTemp();
                renderTable();
                resetInputStok();
                iElem.attr('disabled', false);
            }
        }
    }

    function prepareInputStok(stok){
        input.val(stok);
        input.attr('max', stok);
        input.attr('min', '1');
        input.attr('disabled', false);
        btnAdd.attr('disabled', false);
    }

    function resetInputStok(){
        input.val(0);
        input.attr('min', '1');
        input.attr('disabled', true);
        btnAdd.attr('disabled', true);
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
            url: "<?php echo base_url();?>retur_pembelian/get_batch_by_supplier_id/",
            data: {ms_id : id_supplier},
            dataType: "json",
            success: function (response) {
                obatid.find('option').remove();
                $.each(response.data, function (indexInArray, valueOfElement){
                    let tb_id = valueOfElement.tb_id;
                    let tb_tgl_masuk = valueOfElement.tb_tgl_masuk;
                    let stok = valueOfElement.stok;
                    let mu_nama = valueOfElement.mu_nama;
                    let mo_nama = valueOfElement.mo_nama;
                    let mo_id = valueOfElement.mo_id;
                    if(stok != '0'){
                    obatid.append('<option value="'+tb_id+'" tgl="'+tb_tgl_masuk+'" stok="'+stok+'" nama="'+mo_nama+'" moId="'+mo_id+'">'+mo_nama+', ID : '+tb_id+', Stok : '+stok+' '+mu_nama+', Tanggal : '+tb_tgl_masuk+'</option>');
                    }
                });
                obatid.selectpicker('refresh');
            },
            error: function (){
                alert('error!');
            }
        });
    }

    const checkStok = new Promise((resolve, reject) =>{
          $.ajax({
            url: "<?php echo base_url('retur_pembelian/ajax_cek_stok') ?>",
            type: "POST",
            data: {
              data : JSON.stringify(list_pilihan)
            },
            dataType: "JSON",
            success: function(data) {
              if (data.status)
              {
                resolve('Sukses');
              } else {
                reject('Ada item yang melebihi stok!');
              }
            },
            error: function(error){
                reject('Tidak Bisa cek stok!');
            }
          });
    });

    function saveReturPembelian(){
            checkStok.then((msg) => {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url();?>retur_pembelian/save_retur_pembelian/",
                    data: {
                        kode : uniqid,
                        ms_id : id_supplier,
                        data : JSON.stringify(list_pilihan)
                    },
                    dataType: "json",
                    success: function (response) {
                        popup('info', response.msg);
                        if(response.status){
                            setTimeout(function(){
                                exit();
                            }, 2000);
                        }
                    },
                    error: function (){
                        popup('error', response.msg);
                    }
                });
            }).catch((e)=>{
                popup('error', e);
            });

    }

    function renderTable(){
        const tableBody =  document.getElementById('tableBody');
        tableBody.innerHTML = '';
        $.each(list_pilihan, (a,b) => {
            const baris = document.createElement('tr');
            const sel1 = document.createElement('td');
            const sel2 = document.createElement('td');
            const sel3 = document.createElement('td');
            const sel4 = document.createElement('td');
            const sel5 = document.createElement('td');
            const sel6 = document.createElement('td');

            sel1.innerHTML = a+1;
            sel2.innerHTML = b.batchId;
            sel3.innerHTML = b.nama;
            sel4.innerHTML = b.tgl;
            sel5.innerHTML = b.quantity;

            sel6.innerHTML = "<button class='btn btn-danger' onclick='removeFromList("+a+")'>Hapus</button>";

            baris.appendChild(sel1);
            baris.appendChild(sel2);
            baris.appendChild(sel3);
            baris.appendChild(sel4);
            baris.appendChild(sel5);
            baris.appendChild(sel6);

            tableBody.appendChild(baris);
        });
        contentChecker();
    }

    function exit(){
        window.location = '<?php echo base_url('retur_pembelian/retur_pembelian_detail/'); ?>' + uniqid;
    }

</script>