<div class="content-wrapper" style="min-height: 901px;">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Setting App
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <form action="#" id="formnih" class="form-horizontal" name="formnih" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $data->setting_id;?>">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label ">Nama Apps</label>
                                <input type="text" name="nama_app" class="form-control" placeholder="Nama Apps" value="<?php echo $data->app_nama;?>" autofocus required>
                                <span class="help-block"></span>
                            </div>
                            <?php 
                            if($data->app_logo != '')
                            {?>
                            <div class="form-group text-center">
                                 <img src="<?php echo base_url('assets/logo');?>/<?php echo $data->app_logo;?>" class="img-thumbnail" alt="Logo" width="100px" height="auto">
                            </div>
                            <?php }?>
                            <div class="form-group">
                                <label class="control-label ">Logo Apps</label>
                                <input type="hidden" name="old_logo" value="<?php echo $data->app_logo;?>">
                                <input type="file" name="logo" class="form-control">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-12 pb-3">
                                <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
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

        var formData = new FormData($('form')[0]);
        formData.append(csrf_nm,get_newer());

        $.ajax({
        url: "<?php echo base_url('dashboard/save_setting');?>",
        data: formData,
        type : 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend:function()
        {

        },
        success: function(data) {

          if (data.status) //if success close modal and reload ajax table
          {
            popup_reload('Informasi', 'Data berhasil di Update');
          } else {
            popup('Perhatian', data.msg, 'info');
          }

          $('#btnSave').text('Simpan'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
        }
      });
    }
</script>