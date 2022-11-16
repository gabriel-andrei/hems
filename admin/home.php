<div class="card card-outline card-primary">
<div class="card-header">
		<h3 class="card-title">Dashboard</h3>
	</div>
  <br>
<style>
  .info-box:hover {
  background-color: #F0EFEF;
}
</style>
<div class="row">
          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=transactions" class="nav-link nav-transactions">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-calendar-minus"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="color:black">Pending Transaction</span>
                <span class="info-box-number" style="color:black">
                  <?php 						
                    $total = $conn->query("SELECT * FROM transaction_list where `status` = 0 ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                  
                </span>
                
              </div>
              
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=transactions" class="nav-link nav-transactions">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-spinner"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:black">On-Progress</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                    $total = $conn->query("SELECT * FROM transaction_list where `status` = 1 ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>  
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=transactions" class="nav-link nav-transactions">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-file-invoice"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:black">Finished Transaction</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                    $total = $conn->query("SELECT * FROM transaction_list where `status` = 2 ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          
          
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=inventory" class="nav-link nav-inventory">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-cogs"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:black">Product List</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                    $total = $conn->query("SELECT * FROM product_list where `delete_flag` = 0 ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <?php if($_settings->userdata('type') == 1): ?>
          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=services" class="nav-link nav-services">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-blue elevation-1"><i class="fas fa-cogs"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="color:black">Service List</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                    $service = $conn->query("SELECT * FROM service_list where delete_flag = 0 and `status` = 1")->num_rows;
                    echo format_num($service);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>  
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=mechanics" class="nav-link nav-mechanics">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-user-friends"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:black">Mechanic List</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                    $total = $conn->query("SELECT * FROM mechanic_list where `delete_flag` = 0 ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>

          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=user" class="nav-link nav-user">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-maroon elevation-1"><i class="fas fa-users-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:black">User List</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                    $total = $conn->query("SELECT * FROM users ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <?php endif; ?>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=inventory" class="nav-link nav-inventory">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-red elevation-1"><i class="fas fa-exclamation-triangle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:black">Low Stock Items</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                    $total = $conn->query("SELECT * FROM users ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
        </div>
<div class="container">
  <?php 
    // $files = array();
    //   $fopen = scandir(base_app.'uploads/banner');
    //   foreach($fopen as $fname){
    //     if(in_array($fname,array('.','..')))
    //       continue;
    //     $files[]= validate_image('uploads/banner/'.$fname);
    //   }
  ?>
</div>
</div>