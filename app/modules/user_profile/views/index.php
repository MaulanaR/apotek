  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
<?php 
if($this->session->flashdata('err_'))
{
  echo "<script>
  popup('Perhatian','".$this->session->flashdata('err_')."','warning')
  </script>";
}

if($this->session->flashdata('success_'))
{
 echo "<script>
  popup('Informasi','".$this->session->flashdata('success_')."','success')
  </script>"; 
}
?>

      <!-- Main content -->
      <section class="content pt-1">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <center>
              <?php
              if(file_exists("./assets/avatar/".$this->session->userdata('avatar'))){?>
                   <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/avatar')."/".$this->session->userdata('avatar');?>" alt="User profile picture" height="90" width="90" >
                <?php }else{?>
                   <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/avatar');?>/avatar_default.png" alt="User profile picture" height="90" width="90" >
                <?php }?>
              </center>
              <form action="<?php echo base_url('user_profile/update');?>" method="POST" id="upuser" class="form-horizontal" enctype="multipart/form-data">
              <h3 class="profile-username text-center"><?php echo $data->first_name." ".$data->last_name;?></h3>

              <p class="text-muted text-center"><?php echo $data->job_title;?></p>
              <div class="list-group list-group-unbordered">
                <div class="form-group">
                    <label class=" control-label">First Name</label>
                    <div class="">
                      <input class="form-control" id="first" name="first_name" type="text" value="<?php echo $data->first_name;?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class=" control-label">Last Name</label>
                    <div class="">
                      <input class="form-control" id="last" name="last_name" type="text" value="<?php echo $data->last_name;?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class=" control-label">Email</label>
                    <div class="">
                      <input class="form-control" name="email" id="email" type="text" value="<?php echo $this->alus_auth->decrypt($data->abc);?>">
                      <input type="hidden" name="id" value="<?php $this->session->userdata('user_id');?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class=" control-label">Password</label>
                    <div class="">
                      <input class="form-control" id="pw" name="password" type="password" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class=" control-label">Re-Type Password</label>
                    <div class="">
                      <input class="form-control" id="repassword" name="repassword" type="password" value="">
                    </div>
                  </div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <div class="form-group">
                    <label class=" control-label">Phone</label>
                    <div class="">
                      <input class="form-control" name="phone" id="phone" type="text" value="<?php echo $data->phone;?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class=" control-label">Picture</label>
                    <div class="">
                      <input class="" id="picture" type="file" name="userfile">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class=" col-sm-offset-2">
                      <input type="submit" class="btn btn-primary btn-block" value="Save Update">
                      <input type="button" onclick="window.history.back()" class="btn btn-danger btn-block" value="Cancel">
                    </div>
                  </div>
              </div>
              </form>
            </div>
          </div>
          <!-- /.card -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

