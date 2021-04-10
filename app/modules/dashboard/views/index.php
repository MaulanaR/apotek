  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <?php 
          $group = $this->alus_auth->get_users_groups()->row();
          if($group->name == "administrator" || $group->name == "ask")
          {
          ?>
          <div class="col-md-4">
            <div class="info-box mb-3 bg-primary">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Upload Data Baru</span>
                <span class="info-box-number">
                  <?php
                  $this->db->select('count(*) as total');
                  $this->db->where('tnsap_approval_status', 0);
                  $c = $this->db->get('t_ns_anak_perusahaan')->row();
                  echo $c->total;
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-eye"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Upload Data Revisi</span>
                <span class="info-box-number">
                  <?php
                  $this->db->select('count(*) as total');
                  $this->db->where('tnsap_approval_status', 3);
                  $c = $this->db->get('t_ns_anak_perusahaan')->row();
                  echo $c->total;
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          <div class="col-md-4">
          </div>
          <?php 
            }
          ?>
        </div>
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
