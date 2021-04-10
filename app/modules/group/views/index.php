  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Groups
        </h1>        
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="callout callout-info">
          <p>Gunakan Panel Admin sebagaimana anda bertanggung jawab dalam memutuskan tindakan yang anda lakukan .</p>
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
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-12">
                    <table id="table" class="table table-bordered table-hover dataTable dtr-inline">
                      <thead>
                      <tr>
                        <th class="text">Nama Group</th>
                        <th class="text">Deskripsi</th>
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
            <div class="modal-header">
                <h3 class="modal-title">Tambah Group</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" name="formnih">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label ">Nama Group</label>
                                <input type="text" name="group_nama" class="form-control" placeholder="Nama Group">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Deskripsi Group</label>
                                <input type="text" name="des_group" class="form-control" placeholder="Deskripsi Group">
                                <span class="help-block"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- / Modal -->


<!--Modal hak akses-->
<div class="modal fade" id="modal_formakses" role="dialog">
    <div class="modal-dialog modal-lg" style="width:97%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Hak Akses Group</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="aksesnih">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  onclick="savehak()">Save !</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="tutuphak()">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- / Modal -->
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        scrollX : true,
        scroller:true,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('group/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 2,3,4 ], //last column
            "orderable": false, //set not orderable
            "className":"text-center",
        },
        ],
        "lengthMenu" : [[10, 25, 100, 1000, -1], [10, 25, 100,1000, "All"]],
    });
    $('#psv').change(function(){
      $(this).attr('value', $('#psv').val());
    });
    $('#pev').change(function(){
      $(this).attr('value', $('#pev').val());
    });
    $('#psed').change(function(){
      $(this).attr('value', $('#psed').val());
    });
    $('#peed').change(function(){
      $(this).attr('value', $('#peed').val());
    });
});
 
 function openform(id) {
  $.ajax({
        url: "<?php echo base_url('group/hak_akses')?>/"+id,
        beforeSend: function() 
        { $("#load_ajax").show(); },
        complete: function() 
        { $("#load_ajax").hide(); },
        cache: false,
        success: function(msg){
          $("#modal_formakses").modal("show");
          $("#aksesnih").html(msg);
        }
    
    });
  }

function tutuphak()
  {
    $("#modal_formakses").modal("hide");
  }

 function savehak() {
  var form=$("#hak");
  $.ajax({
        type:"POST",
        url:form.attr("action"),
        dataType:"JSON",
        beforeSend: function() 
        { $("#load_ajax").show(); },
        complete: function() 
        { $("#load_ajax").hide(); },
        data:form.serialize(),
        success: function(msg){
          
          if(msg.status) //if success close modal and reload ajax table
            {
                tutuphak();
                popup('Informasi','Data berhasil simpan');
                reload_table();
            }else{
                popup('Perhatian',data.msg,'info');
                reload_table();
            }
        }
    
    });
  }

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Group'); // Set Title to Bootstrap modal title
}
 
function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('group/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="group_nama"]').val(data.name);
            $('[name="des_group"]').val(data.description);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Group'); // Set title to Bootstrap modal title
 
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
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('group/ajax_add')?>";
    } else {
        url = "<?php echo site_url('group/ajax_update')?>";
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
            }else{
                popup('Perhatian',data.msg,'info');
                reload_table();
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
            url : "<?php echo site_url('group/ajax_delete')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               if(data.status) //if success close modal and reload ajax table
              {
                  $('#modal_form').modal('hide');
                  popup('Informasi','Berhasil');
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
<?php function is_not_null($var)
    { return !is_null($var); } 
    ?>

