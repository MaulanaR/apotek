  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Manajemen Users
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
            <div class="card-body">
              <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-12">
                    <table id="table" class="table table-bordered table-hover dataTable dtr-inline">
                      <thead>
                      <tr>
                        <th class="text">First Name</th>
                        <th class="text">Last Name</th>
                        <th class="text">Email</th>
                        <th class="text">Groups</th>
                        <th class="text-center" width="15%">Tools</th>
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
                <h3 class="modal-title">Tambah User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" name="formnih">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="" name="elama"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label ">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="username">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Job title</label>
                                <input type="text" name="job" class="form-control" placeholder="Job title">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" id="pw">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Re-Type Password</label>
                                <input type="password" name="re_password" class="form-control" placeholder="Re-Type Password" id="repw">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Active</label>
                            <select name="active" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="control-label ">HT</label>
                            <select name="ht" class="form-control">
                                <option value="1">Active</option>
                                <option value="0" selected="">Deactive</option>
                            </select>
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                    <label class="control-label " >Groups</label>
                    <div style="border:0px solid #ccc; width:98% ; height: 170px; overflow-y: scroll; padding-left: 10px;">
                      <div class="contain">
                          <table class="table table-striped table-bordered table-hover"> 
                            <thead>
                              <tr>
                                <th width="2%"></th>
                                <th class="text-left">Name</th>
                                <th class="text-center">Description</th>
                              </tr>
                            </thead>
                            <tbody>
                               <?php foreach ($list->result() as $key) {
                                    ?>
                                    <tr>
                                    <td class="text-right">
                                     <input type="checkbox" class="groups" name="group[]" value="<?php echo $key->id ;?>">
                                     </td>
                                    <td><?php echo $key->name;?></td>
                                   <td><?php echo $key->description;?></td>
                                   </tr>
                                    <?php }; ?>
                            </tbody>
                      </table>
                  </div>
                  </div>
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
</div><!-- /.modal -->

<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('users/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
            "className":"text-center",
        },
        { 
            "targets": [4], //last column
            "className":"text-center",
        },

        ],
        "lengthMenu" : [[10, 25, 100, 1000, -1], [10, 25, 100,1000, "All"]],
        
    });

});
 
function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
}
 
function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('users/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.data.id);
            $('[name="elama"]').val(data.email);
            $('[name="username"]').val(data.data.username);
            $('[name="job"]').val(data.data.job_title);
            $('[name="email"]').val(data.email);
            $('[name="password"]').val();
            $('[name="re_password"]').val();
            $('[name="first_name"]').val(data.data.first_name);
            $('[name="last_name"]').val(data.data.last_name);
            $('[name="phone"]').val(data.data.phone);
            $('[name="active"]').val(data.data.active);
            $('[name="ht"]').val(data.data.ht);
            $('#form').find(':checkbox[name^="group"]').each(function () {
                    $(this).prop("checked", ($.inArray($(this).val(), data.grup) != -1));
                });
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title
 
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
        url = "<?php echo site_url('users/ajax_add')?>";
    } else {
        url = "<?php echo site_url('users/ajax_update')?>";
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
            url : "<?php echo site_url('users/ajax_delete')?>/"+id,
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