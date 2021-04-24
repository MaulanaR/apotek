  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Manajemen Kategori Obat
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="callout callout-info">
          <p>Lorem ipsum dolor .</p>
        </div>
          <div class="card">
            <div class="card-header text-right">
              <div class="btn-group">
                  <?php if($can_add == 1){?>
                  <button class="btn btn-sm btn-success" onclick="add_person()"><i class="fas fa-plus"></i> Tambah</button>
                  <?php } ?>
                  <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="fas fa-retweet"></i> Reload</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-12">
                    <table id="table" class="table table-bordered table-hover dataTable dtr-inline" style="width: 100%">
                      <thead>
                      <tr>
                        <th>Nama Kategori Obat</th>
                        <th width='5%'></th>
                        <th width='5%'></th>
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
<div class="modal" id="modal_form">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
                <form action="#" id="form" class="form-horizontal" name="formnih">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label ">Nama Kategori Obat</label>
                            
                                <input type="text" name="name" class="form-control" placeholder="Nama">
                                <span class="help-block"></span>
                            
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave" onclick="save()" >Save</button>
              </div>
            </div>

          </div>

        </div>

  <script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {

    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        scroller:true,
        scrollX : true,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Kategori_obat/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 1,2 ], //last column
            "orderable": false, //set not orderable
            "className":"text-center",
        },
        { 
            "targets": [1], //last column
            "className":"text-center",
        },
        ],
    });

});
 
function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Menu'); // Set Title to Bootstrap modal title
}
 
function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Kategori_obat/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.data.mk_id);
            $('[name="name"]').val(data.nama);
            //document.formnih.parent.value=data.data.menu_parent;
            //document.formnih.icon.value=data.data.menu_icon;

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kategori Obat'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
    //refresh_menu_list();
}

/*function refresh_menu_list() {
     $.ajax({
          type:"GET",
          url: "<?php //echo base_url('Kategori Obat/refresh_menu_list/');?>",
          dataType:"JSON",
          beforeSend: function() 
          { 
           },
          success: function(json){
            $('#treenih').append('<tr><td class="text-right"><input type="radio" class="radio" name="parent" value="0" checked></td><td>Ini Parent Menu</td></tr>');
            $.each(json['data'], function(j, value) {
                  $('#treenih').append('<tr><td class="text-right"><input type="radio" class="radio" name="parent" value="'+value.menu_id+'"></td><td>'+value.menu_nama+'</td></tr>');
                });
          }
      });
}*/
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('Kategori_obat/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Kategori_obat/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                popup('Informasi','Data berhasil simpan');
                $('#modal_form').modal('hide');
                reload_table();
                //$("#treenih").empty();
                //refresh_menu_list();
            }else{
                popup('Perhatian',data.msg,'info');
                reload_table();
                //$("#treenih").empty();
                //refresh_menu_list();
            }
 
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        }
    });
}
 
function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Kategori_obat/ajax_delete')?>/",
            type: "POST",
            data:{'id' : id},
            dataType: "JSON",
            success: function(data)
            {
               if(data.status) //if success close modal and reload ajax table
              {
                  $('#modal_form').modal('hide');
                  popup('Informasi','Data berhasil dihapus');
                  reload_table();
              }else{
                  popup('Perhatian',data.msg,'info');
                  reload_table();
              }
            }
        });
 
    }
}


</script>