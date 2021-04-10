  <!-- Full Width Column -->
  <div class="content-wrapper" style="min-height: 901px;">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Manajemen Menus
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
              <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-12">
                    <table id="table" class="table table-bordered table-hover dataTable dtr-inline" style="width: 100%">
                      <thead>
                      <tr>
                        <th>Nama Menu</th>
                        <th>URI</th>
                        <th>Order</th>
                        <th>Tools</th>
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
                            <label class="control-label ">Nama Menu</label>
                            
                                <input type="text" name="name" class="form-control" placeholder="Nama">
                                <span class="help-block"></span>
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label ">URI Menu (controller / folder)</label>
                            
                                <input type="text" name="uri" class="form-control" placeholder="URI">
                                <span class="help-block"></span>
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Order Number</label>
                            
                                <input type="number" name="order" class="form-control" placeholder="Order Number">
                                <span class="help-block"></span>
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Target Menu</label>
                            
                                <select name="target" class="form-control">
                          <option value="">This Page</option>
                          <option value="_blank">New Tab Page</option>
                      </select>
                                <span class="help-block"></span>
                            
                        </div>
                  <div class="form-group">
                    <label class="control-label " >Parent Menu</label>
                    <div style="border:0px solid #ccc; width:99% ; height: 170px; overflow-y: scroll; padding-left: 10px;">
                      <div class="contain">
                          <table class="table table-bordered table-striped"> 
                            <thead>
                              <tr>
                                <th width="2%"></th>
                                <th class="text-left">Menu</th>
                              </tr>
                            </thead>
                          <tbody id="treenih">
                      <tr>
                       <td class="text-right">
                        <input type="radio" class="radio" name="parent" value="0" checked>
                        </td>
                       <td>Ini Parent Menu</td>
                      </tr>
                  <?php 
                      foreach ($tree as $tre) {
                       ?>
                      <tr>
                        <td class="text-right">
                          <input type="radio" class="radio" name="parent" value="<?php echo $tre->menu_id ;?>">
                        </td>
                        <td>
                          <?php echo $tre->menu_nama;?>
                        </td>
                      </tr>
                       <?php }; ?>
                       </tbody>                       
                      </table>
                  </div>
                  </div>
              </div>
              <div style="overflow:scroll; height: 200px;">
  <div class="form-group">
              <label class="control-label">Icon Menu</label>
              <div class="row">
              <div class="col-sm-1"><input type="radio" name="icon" value="" checked><strong>None</strong></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-home fa-fw"><i class="fas fa-home xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-book fa-fw"><i class="fas fa-book xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-users fa-fw"><i class="fas fa-users xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-fax fa-fw"><i class="fas fa-fax xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-folder fa-fw"><i class="fas fa-folder xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-folder-open  fa-fw"><i class="fas fa-folder-open  xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-folder-o fa-fw"><i class="fas fa-folder-o xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user fa-fw"><i class="fas fa-user xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cloud fa-fw"><i class="fas fa-cloud xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calendar fa-fw"><i class="fas fa-calendar xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-building fa-fw"><i class="fas fa-building xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bars fa-fw"><i class="fas fa-bars xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-archive fa-fw"><i class="fas fa-archive xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-briefcase fa-fw"><i class="fas fa-briefcase xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="  fas fa-bank fa-fw"><i class=" fas fa-bank xxx" aria-hidden="true"></i></div>
             <div class="col-sm-1"><input type="radio" name="icon" value="  fas fa-bar-chart fa-fw"><i class=" fas fa-bar-chart xxx" aria-hidden="true"></i></div>
            <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bell fa-fw"><i class="fas fa-bell xxx" aria-hidden="true"></i></div>
            <div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bookmark fa-fw"><i class="fas fa-bookmark xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bookmark-o fa-fw"><i class="fas fa-bookmark-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bug fa-fw"><i class="fas fa-bug xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bullhorn fa-fw"><i class="fas fa-bullhorn xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-check-square fa-fw"><i class="fas fa-check-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cogs fa-fw"><i class="fas fa-cogs xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-comments fa-fw"><i class="fas fa-comments xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cube fa-fw"><i class="fas fa-cube xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cubes fa-fw"><i class="fas fa-cubes xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-database fa-fw"><i class="fas fa-database xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-desktop fa-fw"><i class="fas fa-desktop xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-diamond fa-fw"><i class="fas fa-diamond xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-envelope fa-fw"><i class="fas fa-envelope xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-exclamation-circle fa-fw"><i class="fas fa-exclamation-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-exclamation-triangle fa-fw"><i class="fas fa-exclamation-triangle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-eye fa-fw"><i class="fas fa-eye xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-graduation-cap fa-fw"><i class="fas fa-graduation-cap xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-heart fa-fw"><i class="fas fa-heart xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-laptop fa-fw"><i class="fas fa-laptop xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-recycle fa-fw"><i class="fas fa-recycle xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-rss fa-fw"><i class="fas fa-rss xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-rss-square fa-fw"><i class="fas fa-rss-square xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-server fa-fw"><i class="fas fa-server xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-shield fa-fw"><i class="fas fa-shield xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-signal fa-fw"><i class="fas fa-signal xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-star fa-fw"><i class="fas fa-star xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thumb-tack fa-fw"><i class="fas fa-thumb-tack xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-warning fa-fw"><i class="fas fa-warning xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-secret fa-fw"><i class="fas fa-user-secret xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-plus fa-fw"><i class="fas fa-user-plus xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-unlock-alt fa-fw"><i class="fas fa-unlock-alt xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-trash fa-fw"><i class="fas fa-trash xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thumbs-o-up fa-fw"><i class="fas fa-thumbs-o-up xxx" aria-hidden="true"></i></div> 
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tags fa-fw"><i class="fas fa-tags xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-address-book fa-fw"><i class="fas fa-address-book xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-address-book-o fa-fw"><i class="fas fa-address-book-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-address-card fa-fw"><i class="fas fa-address-card xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-address-card-o fa-fw"><i class="fas fa-address-card-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-adjust fa-fw"><i class="fas fa-adjust xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-american-sign-language-interpreting fa-fw"><i class="fas fa-american-sign-language-interpreting xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-anchor fa-fw"><i class="fas fa-anchor xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-archive fa-fw"><i class="fas fa-archive xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-area-chart fa-fw"><i class="fas fa-area-chart xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-arrows fa-fw"><i class="fas fa-arrows xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-arrows-h fa-fw"><i class="fas fa-arrows-h xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-arrows-v fa-fw"><i class="fas fa-arrows-v xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-asl-interpreting fa-fw"><i class="fas fa-asl-interpreting xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-assistive-listening-systems fa-fw"><i class="fas fa-assistive-listening-systems xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-asterisk fa-fw"><i class="fas fa-asterisk xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-at fa-fw"><i class="fas fa-at xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-automobile fa-fw"><i class="fas fa-automobile xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-audio-description fa-fw"><i class="fas fa-audio-description xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-balance-scale fa-fw"><i class="fas fa-balance-scale xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-ban fa-fw"><i class="fas fa-ban xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bank fa-fw"><i class="fas fa-bank xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bar-chart fa-fw"><i class="fas fa-bar-chart xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bar-chart-o fa-fw"><i class="fas fa-bar-chart-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-barcode fa-fw"><i class="fas fa-barcode xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bars fa-fw"><i class="fas fa-bars xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bath fa-fw"><i class="fas fa-bath xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bathtub fa-fw"><i class="fas fa-bathtub xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-0 fa-fw"><i class="fas fa-battery-0 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-1 fa-fw"><i class="fas fa-battery-1 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-2 fa-fw"><i class="fas fa-battery-2 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-3 fa-fw"><i class="fas fa-battery-3 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-4 fa-fw"><i class="fas fa-battery-4 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-empty fa-fw"><i class="fas fa-battery-empty xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-full fa-fw"><i class="fas fa-battery-full xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-half fa-fw"><i class="fas fa-battery-half xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-quarter fa-fw"><i class="fas fa-battery-quarter xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-battery-three-quarters fa-fw"><i class="fas fa-battery-three-quarters xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bed fa-fw"><i class="fas fa-bed xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-beer fa-fw"><i class="fas fa-beer xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bell fa-fw"><i class="fas fa-bell xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bell-o fa-fw"><i class="fas fa-bell-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bell-slash fa-fw"><i class="fas fa-bell-slash xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bell-slash-o fa-fw"><i class="fas fa-bell-slash-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bicycle fa-fw"><i class="fas fa-bicycle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-binoculars fa-fw"><i class="fas fa-binoculars xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-birthday-cake fa-fw"><i class="fas fa-birthday-cake xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-blind fa-fw"><i class="fas fa-blind xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bolt fa-fw"><i class="fas fa-bolt xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bomb fa-fw"><i class="fas fa-bomb xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-book fa-fw"><i class="fas fa-book xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bookmark fa-fw"><i class="fas fa-bookmark xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bookmark-o fa-fw"><i class="fas fa-bookmark-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-braille fa-fw"><i class="fas fa-braille xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-briefcase fa-fw"><i class="fas fa-briefcase xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bug fa-fw"><i class="fas fa-bug xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-building fa-fw"><i class="fas fa-building xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-building-o fa-fw"><i class="fas fa-building-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bullhorn fa-fw"><i class="fas fa-bullhorn xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bullseye fa-fw"><i class="fas fa-bullseye xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-bus fa-fw"><i class="fas fa-bus xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cab fa-fw"><i class="fas fa-cab xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calculator fa-fw"><i class="fas fa-calculator xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calendar fa-fw"><i class="fas fa-calendar xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calendar-o fa-fw"><i class="fas fa-calendar-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calendar-check-o fa-fw"><i class="fas fa-calendar-check-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calendar-minus-o fa-fw"><i class="fas fa-calendar-minus-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calendar-plus-o fa-fw"><i class="fas fa-calendar-plus-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-calendar-times-o fa-fw"><i class="fas fa-calendar-times-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-camera fa-fw"><i class="fas fa-camera xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-camera-retro fa-fw"><i class="fas fa-camera-retro xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-car fa-fw"><i class="fas fa-car xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-caret-square-o-down fa-fw"><i class="fas fa-caret-square-o-down xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-caret-square-o-left fa-fw"><i class="fas fa-caret-square-o-left xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-caret-square-o-right fa-fw"><i class="fas fa-caret-square-o-right xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-caret-square-o-up fa-fw"><i class="fas fa-caret-square-o-up xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cart-arrow-down fa-fw"><i class="fas fa-cart-arrow-down xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cart-plus fa-fw"><i class="fas fa-cart-plus xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cc fa-fw"><i class="fas fa-cc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-certificate fa-fw"><i class="fas fa-certificate xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-check fa-fw"><i class="fas fa-check xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-check-circle fa-fw"><i class="fas fa-check-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-check-circle-o fa-fw"><i class="fas fa-check-circle-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-check-square fa-fw"><i class="fas fa-check-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-check-square-o fa-fw"><i class="fas fa-check-square-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-child fa-fw"><i class="fas fa-child xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-circle fa-fw"><i class="fas fa-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-circle-o fa-fw"><i class="fas fa-circle-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-circle-o-notch fa-fw"><i class="fas fa-circle-o-notch xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-circle-thin fa-fw"><i class="fas fa-circle-thin xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-clock-o fa-fw"><i class="fas fa-clock-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-clone fa-fw"><i class="fas fa-clone xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-close fa-fw"><i class="fas fa-close xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cloud fa-fw"><i class="fas fa-cloud xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cloud-download fa-fw"><i class="fas fa-cloud-download xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cloud-upload fa-fw"><i class="fas fa-cloud-upload xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-code fa-fw"><i class="fas fa-code xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-code-fork fa-fw"><i class="fas fa-code-fork xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-coffee fa-fw"><i class="fas fa-coffee xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cog fa-fw"><i class="fas fa-cog xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cogs fa-fw"><i class="fas fa-cogs xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-comment fa-fw"><i class="fas fa-comment xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-comment-o fa-fw"><i class="fas fa-comment-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-comments fa-fw"><i class="fas fa-comments xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-comments-o fa-fw"><i class="fas fa-comments-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-commenting fa-fw"><i class="fas fa-commenting xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-commenting-o fa-fw"><i class="fas fa-commenting-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-compass fa-fw"><i class="fas fa-compass xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-copyright fa-fw"><i class="fas fa-copyright xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-credit-card fa-fw"><i class="fas fa-credit-card xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-credit-card-alt fa-fw"><i class="fas fa-credit-card-alt xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-creative-commons fa-fw"><i class="fas fa-creative-commons xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-crop fa-fw"><i class="fas fa-crop xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-crosshairs fa-fw"><i class="fas fa-crosshairs xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cube fa-fw"><i class="fas fa-cube xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cubes fa-fw"><i class="fas fa-cubes xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-cutlery fa-fw"><i class="fas fa-cutlery xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-dashboard fa-fw"><i class="fas fa-dashboard xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-database fa-fw"><i class="fas fa-database xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-deaf fa-fw"><i class="fas fa-deaf xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-deafness fa-fw"><i class="fas fa-deafness xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-desktop fa-fw"><i class="fas fa-desktop xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-diamond fa-fw"><i class="fas fa-diamond xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-dot-circle-o fa-fw"><i class="fas fa-dot-circle-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-download fa-fw"><i class="fas fa-download xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-drivers-license fa-fw"><i class="fas fa-drivers-license xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-drivers-license-o fa-fw"><i class="fas fa-drivers-license-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-edit fa-fw"><i class="fas fa-edit xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-ellipsis-h fa-fw"><i class="fas fa-ellipsis-h xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-ellipsis-v fa-fw"><i class="fas fa-ellipsis-v xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-envelope fa-fw"><i class="fas fa-envelope xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-envelope-o fa-fw"><i class="fas fa-envelope-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-envelope-open fa-fw"><i class="fas fa-envelope-open xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-envelope-open-o fa-fw"><i class="fas fa-envelope-open-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-envelope-square fa-fw"><i class="fas fa-envelope-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-eraser fa-fw"><i class="fas fa-eraser xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-exchange fa-fw"><i class="fas fa-exchange xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-exclamation fa-fw"><i class="fas fa-exclamation xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-exclamation-circle fa-fw"><i class="fas fa-exclamation-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-exclamation-triangle fa-fw"><i class="fas fa-exclamation-triangle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-external-link fa-fw"><i class="fas fa-external-link xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-external-link-square fa-fw"><i class="fas fa-external-link-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-eye fa-fw"><i class="fas fa-eye xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-eye-slash fa-fw"><i class="fas fa-eye-slash xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-eyedropper fa-fw"><i class="fas fa-eyedropper xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-fax fa-fw"><i class="fas fa-fax xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-female fa-fw"><i class="fas fa-female xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-fighter-jet fa-fw"><i class="fas fa-fighter-jet xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-archive-o fa-fw"><i class="fas fa-file-archive-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-audio-o fa-fw"><i class="fas fa-file-audio-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-code-o fa-fw"><i class="fas fa-file-code-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-excel-o fa-fw"><i class="fas fa-file-excel-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-image-o fa-fw"><i class="fas fa-file-image-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-movie-o fa-fw"><i class="fas fa-file-movie-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-pdf-o fa-fw"><i class="fas fa-file-pdf-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-photo-o fa-fw"><i class="fas fa-file-photo-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-picture-o fa-fw"><i class="fas fa-file-picture-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-powerpoint-o fa-fw"><i class="fas fa-file-powerpoint-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-sound-o fa-fw"><i class="fas fa-file-sound-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-video-o fa-fw"><i class="fas fa-file-video-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-word-o fa-fw"><i class="fas fa-file-word-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-file-zip-o fa-fw"><i class="fas fa-file-zip-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-film fa-fw"><i class="fas fa-film xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-filter fa-fw"><i class="fas fa-filter xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-fire fa-fw"><i class="fas fa-fire xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-fire-extinguisher fa-fw"><i class="fas fa-fire-extinguisher xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-flag fa-fw"><i class="fas fa-flag xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-flag-checkered fa-fw"><i class="fas fa-flag-checkered xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-flag-o fa-fw"><i class="fas fa-flag-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-flash fa-fw"><i class="fas fa-flash xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-flask fa-fw"><i class="fas fa-flask xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-folder fa-fw"><i class="fas fa-folder xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-folder-o fa-fw"><i class="fas fa-folder-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-folder-open fa-fw"><i class="fas fa-folder-open xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-folder-open-o fa-fw"><i class="fas fa-folder-open-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-frown-o fa-fw"><i class="fas fa-frown-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-futbol-o fa-fw"><i class="fas fa-futbol-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-gamepad fa-fw"><i class="fas fa-gamepad xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-gavel fa-fw"><i class="fas fa-gavel xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-gear fa-fw"><i class="fas fa-gear xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-gears fa-fw"><i class="fas fa-gears xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-genderless fa-fw"><i class="fas fa-genderless xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-gift fa-fw"><i class="fas fa-gift xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-glass fa-fw"><i class="fas fa-glass xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-globe fa-fw"><i class="fas fa-globe xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-graduation-cap fa-fw"><i class="fas fa-graduation-cap xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-group fa-fw"><i class="fas fa-group xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hard-of-hearing fa-fw"><i class="fas fa-hard-of-hearing xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hdd-o fa-fw"><i class="fas fa-hdd-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-handshake-o fa-fw"><i class="fas fa-handshake-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hashtag fa-fw"><i class="fas fa-hashtag xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-headphones fa-fw"><i class="fas fa-headphones xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-heart fa-fw"><i class="fas fa-heart xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-heart-o fa-fw"><i class="fas fa-heart-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-heartbeat fa-fw"><i class="fas fa-heartbeat xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-history fa-fw"><i class="fas fa-history xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-home fa-fw"><i class="fas fa-home xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hotel fa-fw"><i class="fas fa-hotel xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass fa-fw"><i class="fas fa-hourglass xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass-1 fa-fw"><i class="fas fa-hourglass-1 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass-2 fa-fw"><i class="fas fa-hourglass-2 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass-3 fa-fw"><i class="fas fa-hourglass-3 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass-end fa-fw"><i class="fas fa-hourglass-end xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass-half fa-fw"><i class="fas fa-hourglass-half xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass-o fa-fw"><i class="fas fa-hourglass-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-hourglass-start fa-fw"><i class="fas fa-hourglass-start xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-i-cursor fa-fw"><i class="fas fa-i-cursor xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-id-badge fa-fw"><i class="fas fa-id-badge xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-id-card fa-fw"><i class="fas fa-id-card xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-id-card-o fa-fw"><i class="fas fa-id-card-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-image fa-fw"><i class="fas fa-image xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-incard fa-fw"><i class="fas fa-incard xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-industry fa-fw"><i class="fas fa-industry xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-info fa-fw"><i class="fas fa-info xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-info-circle fa-fw"><i class="fas fa-info-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-institution fa-fw"><i class="fas fa-institution xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-key fa-fw"><i class="fas fa-key xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-keyboard-o fa-fw"><i class="fas fa-keyboard-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-language fa-fw"><i class="fas fa-language xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-laptop fa-fw"><i class="fas fa-laptop xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-leaf fa-fw"><i class="fas fa-leaf xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-legal fa-fw"><i class="fas fa-legal xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-lemon-o fa-fw"><i class="fas fa-lemon-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-level-down fa-fw"><i class="fas fa-level-down xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-level-up fa-fw"><i class="fas fa-level-up xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-life-bouy fa-fw"><i class="fas fa-life-bouy xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-life-buoy fa-fw"><i class="fas fa-life-buoy xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-life-ring fa-fw"><i class="fas fa-life-ring xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-life-saver fa-fw"><i class="fas fa-life-saver xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-lightbulb-o fa-fw"><i class="fas fa-lightbulb-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-line-chart fa-fw"><i class="fas fa-line-chart xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-location-arrow fa-fw"><i class="fas fa-location-arrow xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-lock fa-fw"><i class="fas fa-lock xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-low-vision fa-fw"><i class="fas fa-low-vision xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-magic fa-fw"><i class="fas fa-magic xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-magnet fa-fw"><i class="fas fa-magnet xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-mail-forward fa-fw"><i class="fas fa-mail-forward xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-mail-reply fa-fw"><i class="fas fa-mail-reply xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-mail-reply-all fa-fw"><i class="fas fa-mail-reply-all xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-male fa-fw"><i class="fas fa-male xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-map fa-fw"><i class="fas fa-map xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-map-o fa-fw"><i class="fas fa-map-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-map-pin fa-fw"><i class="fas fa-map-pin xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-map-signs fa-fw"><i class="fas fa-map-signs xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-map-marker fa-fw"><i class="fas fa-map-marker xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-meh-o fa-fw"><i class="fas fa-meh-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-microchip fa-fw"><i class="fas fa-microchip xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-microphone fa-fw"><i class="fas fa-microphone xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-microphone-slash fa-fw"><i class="fas fa-microphone-slash xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-minus fa-fw"><i class="fas fa-minus xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-minus-circle fa-fw"><i class="fas fa-minus-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-minus-square fa-fw"><i class="fas fa-minus-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-minus-square-o fa-fw"><i class="fas fa-minus-square-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-mobile fa-fw"><i class="fas fa-mobile xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-mobile-phone fa-fw"><i class="fas fa-mobile-phone xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-money fa-fw"><i class="fas fa-money xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-moon-o fa-fw"><i class="fas fa-moon-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-mortar-board fa-fw"><i class="fas fa-mortar-board xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-motorcycle fa-fw"><i class="fas fa-motorcycle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-mouse-pointer fa-fw"><i class="fas fa-mouse-pointer xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-music fa-fw"><i class="fas fa-music xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-navicon fa-fw"><i class="fas fa-navicon xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-newspaper-o fa-fw"><i class="fas fa-newspaper-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-object-group fa-fw"><i class="fas fa-object-group xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-object-ungroup fa-fw"><i class="fas fa-object-ungroup xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-paint-brush fa-fw"><i class="fas fa-paint-brush xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-paper-plane fa-fw"><i class="fas fa-paper-plane xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-paper-plane-o fa-fw"><i class="fas fa-paper-plane-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-paw fa-fw"><i class="fas fa-paw xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-pencil fa-fw"><i class="fas fa-pencil xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-pencil-square fa-fw"><i class="fas fa-pencil-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-pencil-square-o fa-fw"><i class="fas fa-pencil-square-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-percent fa-fw"><i class="fas fa-percent xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-phone fa-fw"><i class="fas fa-phone xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-phone-square fa-fw"><i class="fas fa-phone-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-photo fa-fw"><i class="fas fa-photo xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-picture-o fa-fw"><i class="fas fa-picture-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-pie-chart fa-fw"><i class="fas fa-pie-chart xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-plane fa-fw"><i class="fas fa-plane xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-plug fa-fw"><i class="fas fa-plug xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-plus fa-fw"><i class="fas fa-plus xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-plus-circle fa-fw"><i class="fas fa-plus-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-plus-square fa-fw"><i class="fas fa-plus-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-plus-square-o fa-fw"><i class="fas fa-plus-square-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-podcast fa-fw"><i class="fas fa-podcast xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-power-off fa-fw"><i class="fas fa-power-off xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-print fa-fw"><i class="fas fa-print xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-puzzle-piece fa-fw"><i class="fas fa-puzzle-piece xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-qrcode fa-fw"><i class="fas fa-qrcode xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-question fa-fw"><i class="fas fa-question xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-question-circle fa-fw"><i class="fas fa-question-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-question-circle-o fa-fw"><i class="fas fa-question-circle-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-quote-left fa-fw"><i class="fas fa-quote-left xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-quote-right fa-fw"><i class="fas fa-quote-right xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-random fa-fw"><i class="fas fa-random xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-recycle fa-fw"><i class="fas fa-recycle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-refresh fa-fw"><i class="fas fa-refresh xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-registered fa-fw"><i class="fas fa-registered xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-remove fa-fw"><i class="fas fa-remove xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-reorder fa-fw"><i class="fas fa-reorder xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-reply fa-fw"><i class="fas fa-reply xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-reply-all fa-fw"><i class="fas fa-reply-all xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-retweet fa-fw"><i class="fas fa-retweet xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-road fa-fw"><i class="fas fa-road xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-rocket fa-fw"><i class="fas fa-rocket xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-rss fa-fw"><i class="fas fa-rss xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-rss-square fa-fw"><i class="fas fa-rss-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-s15 fa-fw"><i class="fas fa-s15 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-search fa-fw"><i class="fas fa-search xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-search-minus fa-fw"><i class="fas fa-search-minus xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-search-plus fa-fw"><i class="fas fa-search-plus xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-send fa-fw"><i class="fas fa-send xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-send-o fa-fw"><i class="fas fa-send-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-server fa-fw"><i class="fas fa-server xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-share fa-fw"><i class="fas fa-share xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-share-alt fa-fw"><i class="fas fa-share-alt xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-share-alt-square fa-fw"><i class="fas fa-share-alt-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-share-square fa-fw"><i class="fas fa-share-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-share-square-o fa-fw"><i class="fas fa-share-square-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-shield fa-fw"><i class="fas fa-shield xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-ship fa-fw"><i class="fas fa-ship xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-shopping-bag fa-fw"><i class="fas fa-shopping-bag xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-shopping-basket fa-fw"><i class="fas fa-shopping-basket xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-shopping-cart fa-fw"><i class="fas fa-shopping-cart xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-shower fa-fw"><i class="fas fa-shower xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sign-in fa-fw"><i class="fas fa-sign-in xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sign-out fa-fw"><i class="fas fa-sign-out xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sign-language fa-fw"><i class="fas fa-sign-language xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-signal fa-fw"><i class="fas fa-signal xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-signing fa-fw"><i class="fas fa-signing xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sitemap fa-fw"><i class="fas fa-sitemap xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sliders fa-fw"><i class="fas fa-sliders xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-smile-o fa-fw"><i class="fas fa-smile-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-snowflake-o fa-fw"><i class="fas fa-snowflake-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-soccer-ball-o fa-fw"><i class="fas fa-soccer-ball-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort fa-fw"><i class="fas fa-sort xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-alpha-asc fa-fw"><i class="fas fa-sort-alpha-asc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-alpha-desc fa-fw"><i class="fas fa-sort-alpha-desc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-amount-asc fa-fw"><i class="fas fa-sort-amount-asc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-amount-desc fa-fw"><i class="fas fa-sort-amount-desc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-asc fa-fw"><i class="fas fa-sort-asc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-desc fa-fw"><i class="fas fa-sort-desc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-down fa-fw"><i class="fas fa-sort-down xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-numeric-asc fa-fw"><i class="fas fa-sort-numeric-asc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-numeric-desc fa-fw"><i class="fas fa-sort-numeric-desc xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sort-up fa-fw"><i class="fas fa-sort-up xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-space-shuttle fa-fw"><i class="fas fa-space-shuttle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-spinner fa-fw"><i class="fas fa-spinner xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-spoon fa-fw"><i class="fas fa-spoon xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-square fa-fw"><i class="fas fa-square xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-square-o fa-fw"><i class="fas fa-square-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-star fa-fw"><i class="fas fa-star xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-star-half fa-fw"><i class="fas fa-star-half xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-star-half-empty fa-fw"><i class="fas fa-star-half-empty xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-star-half-full fa-fw"><i class="fas fa-star-half-full xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-star-half-o fa-fw"><i class="fas fa-star-half-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-star-o fa-fw"><i class="fas fa-star-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sticky-note fa-fw"><i class="fas fa-sticky-note xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sticky-note-o fa-fw"><i class="fas fa-sticky-note-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-street-view fa-fw"><i class="fas fa-street-view xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-suitcase fa-fw"><i class="fas fa-suitcase xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-sun-o fa-fw"><i class="fas fa-sun-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-support fa-fw"><i class="fas fa-support xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tablet fa-fw"><i class="fas fa-tablet xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tachometer fa-fw"><i class="fas fa-tachometer xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tag fa-fw"><i class="fas fa-tag xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tags fa-fw"><i class="fas fa-tags xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tasks fa-fw"><i class="fas fa-tasks xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-taxi fa-fw"><i class="fas fa-taxi xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-television fa-fw"><i class="fas fa-television xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-terminal fa-fw"><i class="fas fa-terminal xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer fa-fw"><i class="fas fa-thermometer xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-0 fa-fw"><i class="fas fa-thermometer-0 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-1 fa-fw"><i class="fas fa-thermometer-1 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-2 fa-fw"><i class="fas fa-thermometer-2 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-3 fa-fw"><i class="fas fa-thermometer-3 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-4 fa-fw"><i class="fas fa-thermometer-4 xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-empty fa-fw"><i class="fas fa-thermometer-empty xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-full fa-fw"><i class="fas fa-thermometer-full xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-half fa-fw"><i class="fas fa-thermometer-half xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-quarter fa-fw"><i class="fas fa-thermometer-quarter xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thermometer-three-quarters fa-fw"><i class="fas fa-thermometer-three-quarters xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thumb-tack fa-fw"><i class="fas fa-thumb-tack xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thumbs-down fa-fw"><i class="fas fa-thumbs-down xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thumbs-o-up fa-fw"><i class="fas fa-thumbs-o-up xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-thumbs-up fa-fw"><i class="fas fa-thumbs-up xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-ticket fa-fw"><i class="fas fa-ticket xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-times fa-fw"><i class="fas fa-times xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-times-circle fa-fw"><i class="fas fa-times-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-times-circle-o fa-fw"><i class="fas fa-times-circle-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-times-rectangle fa-fw"><i class="fas fa-times-rectangle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-times-rectangle-o fa-fw"><i class="fas fa-times-rectangle-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tint fa-fw"><i class="fas fa-tint xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-toggle-down fa-fw"><i class="fas fa-toggle-down xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-toggle-left fa-fw"><i class="fas fa-toggle-left xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-toggle-right fa-fw"><i class="fas fa-toggle-right xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-toggle-up fa-fw"><i class="fas fa-toggle-up xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-toggle-off fa-fw"><i class="fas fa-toggle-off xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-toggle-on fa-fw"><i class="fas fa-toggle-on xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-trademark fa-fw"><i class="fas fa-trademark xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-trash fa-fw"><i class="fas fa-trash xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-trash-o fa-fw"><i class="fas fa-trash-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tree fa-fw"><i class="fas fa-tree xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-trophy fa-fw"><i class="fas fa-trophy xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-truck fa-fw"><i class="fas fa-truck xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tty fa-fw"><i class="fas fa-tty xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-tv fa-fw"><i class="fas fa-tv xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-umbrella fa-fw"><i class="fas fa-umbrella xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-universal-access fa-fw"><i class="fas fa-universal-access xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-university fa-fw"><i class="fas fa-university xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-unlock fa-fw"><i class="fas fa-unlock xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-unlock-alt fa-fw"><i class="fas fa-unlock-alt xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-unsorted fa-fw"><i class="fas fa-unsorted xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-upload fa-fw"><i class="fas fa-upload xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user fa-fw"><i class="fas fa-user xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-circle fa-fw"><i class="fas fa-user-circle xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-circle-o fa-fw"><i class="fas fa-user-circle-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-o fa-fw"><i class="fas fa-user-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-plus fa-fw"><i class="fas fa-user-plus xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-secret fa-fw"><i class="fas fa-user-secret xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-user-times fa-fw"><i class="fas fa-user-times xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-users fa-fw"><i class="fas fa-users xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-vcard fa-fw"><i class="fas fa-vcard xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-vcard-o fa-fw"><i class="fas fa-vcard-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-video-camera fa-fw"><i class="fas fa-video-camera xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-volume-control-phone fa-fw"><i class="fas fa-volume-control-phone xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-volume-down fa-fw"><i class="fas fa-volume-down xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-volume-off fa-fw"><i class="fas fa-volume-off xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-volume-up fa-fw"><i class="fas fa-volume-up xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-warning fa-fw"><i class="fas fa-warning xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-wheelchair fa-fw"><i class="fas fa-wheelchair xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-wheelchair-alt fa-fw"><i class="fas fa-wheelchair-alt xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-window-close fa-fw"><i class="fas fa-window-close xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-window-close-o fa-fw"><i class="fas fa-window-close-o xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-window-maximize fa-fw"><i class="fas fa-window-maximize xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-window-minimize fa-fw"><i class="fas fa-window-minimize xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-window-restore fa-fw"><i class="fas fa-window-restore xxx" aria-hidden="true"></i></div>
<div class="col-sm-1"><input type="radio" name="icon" value="fas fa-wifi fa-fw"><i class="fas fa-wifi xxx" aria-hidden="true"></i></div>
</div>
        </div>
        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave" onclick="save()" >Save</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<!-- / Modal -->

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
            "url": "<?php echo site_url('menus/ajax_list')?>",
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
            "targets": [2], //last column
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
        url : "<?php echo site_url('menus/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.data.menu_id);
            $('[name="name"]').val(data.nama);
            $('[name="uri"]').val(data.uri);
            $('[name="order"]').val(data.data.order_num);
            $('[name="target"]').val(data.data.menu_target);
            document.formnih.parent.value=data.data.menu_parent;
            document.formnih.icon.value=data.data.menu_icon;

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
 
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

function refresh_menu_list() {
     $.ajax({
          type:"GET",
          url: "<?php echo base_url('menus/refresh_menu_list/');?>",
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
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('menus/ajax_add')?>";
    } else {
        url = "<?php echo site_url('menus/ajax_update')?>";
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
                $("#treenih").empty();
                refresh_menu_list();
            }else{
                popup('Perhatian',data.msg,'info');
                reload_table();
                $("#treenih").empty();
                refresh_menu_list();
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
            url : "<?php echo site_url('menus/ajax_delete')?>/",
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