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
          <div class="col-12 col-sm-6 col-md-3">
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
          <div class="col-12 col-sm-6 col-md-3">
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
          <div class="col-12 col-sm-6 col-md-3">
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
          <div class="col-12 col-sm-6 col-md-3">
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
          <div class="col-12 col-sm-6 col-md-3">
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
          <div class="col-12 col-sm-6 col-md-3">
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

          <div class="col-12 col-sm-6 col-md-3">
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
          <div class="col-12 col-sm-6 col-md-3">
          <a href="<?php echo base_url ?>admin/?page=inventory" class="nav-link nav-inventory">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-red elevation-1"><i class="fas fa-exclamation-triangle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:black">Low Stock Items</span>
                <span class="info-box-number" style="color:black">
                  <?php 
                  
                    $total = $conn->query("SELECT p.*, COALESCE(SUM(i.quantity),0) - COALESCE(SUM(d.quantity),0) stocks , COALESCE(SUM(t.qty),0) sold 
                    from `product_list` p
                    LEFT JOIN inventory_list i ON p.id=i.product_id
								    LEFT JOIN inventory_damaged d ON d.inventory_id=i.id
                    LEFT JOIN transaction_products t ON p.id=t.product_id 
                    where p.delete_flag = 0 
                    GROUP BY p.id HAVING stocks < stocks-sold OR stocks <= 0
                    ")->num_rows;
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
</div>
<div class="card card-outline card-success">
  <div class="card-header">
		<h3 class="card-title">Monitoring</h3>
	</div>
  <br>
  <?php 
    // $files = array();
    //   $fopen = scandir(base_app.'uploads/banner');
    //   foreach($fopen as $fname){
    //     if(in_array($fname,array('.','..')))
    //       continue;
    //     $files[]= validate_image('uploads/banner/'.$fname);
    //   }
  ?>
  <div class="row">
  <?php
					$i = 1;
						$qry = $conn->query("SELECT m.*
              ,concat(firstname, ' ', coalesce(concat(middlename, ' '),''), lastname) as `name` 
              , MAX(IF(t.`status` =1, t.code, '')) recent_tran
              , MAX(IF(t.`status` =1, t.id, '')) recent_id
              , SUM(IF(t.`status` =2, 1, 0)) accomplished
              , SUM(IF(t.`status` =0, 1, 0)) pending
              , SUM(IF(t.`status` =1, 1, 0)) onprogress
                      from `mechanic_list` m
                      LEFT JOIN `transaction_list` t ON t.mechanic_id=m.id
                      where delete_flag = 0 and m.`status` = 1 
                      GROUP BY m.id
                      order by recent_id desc, `name` asc");
						while($row = $qry->fetch_assoc()):
					?>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="card m-3"> 
                <?php if( $row['recent_tran']==''):?>
                <div class="card-header text-center pt-3 bg-success"  style="height: 4em;">
                  On-Standby
                </div>
                <?php else:?>
                <div class="card-header text-center bg-danger"  style="height: 4em;">
                    Working on 
                    <a class="btn btn-default border btn-md rounded-pill transaction_details" href="javascript:void(0)" data-id="<?php echo $row['recent_id'] ?>">
                    <b class=" text-dark"><?= $row['recent_tran']?></b>
                    </a>
                </div>
                <?php endif;?>
              <div class="text-center h4" style="padding-top: 25px;">
                <?= $row['name']?>
              </div>
              <hr/>
              <ul class="list-group list-group-flush">
                <li class="list-group-item ">
                  <div class="row">
                    <div class="col-10">
                      On-Progress: 
                    </div>
                    <div class="col-2 h4">
                      <span class="badge badge-primary"><?= $row['onprogress']?></span>
                    </div>
                  </div> 
                </li>
                <li class="list-group-item ">
                  <div class="row">
                    <div class="col-10">
                    Pendings: 
                    </div>
                    <div class="col-2 h4">
                      <span class="badge badge-danger"><?= $row['pending']?></span>
                    </div>
                  </div> 
                </li>
                <li class="list-group-item ">
                  <div class="row">
                    <div class="col-10">
                    Accomplished: 
                    </div>
                    <div class="col-2 h4">
                      <span class="badge badge-success "><?= $row['accomplished']?></span>
                    </div>
                  </div> 
                </li>
              </ul>
            </div>
          </div>
					<?php endwhile; ?>
  </div>
</div>


<script>

	$(document).ready(function(){
	  $('.transaction_details').click(function(){
			uni_modal("<i class='fa fa-info-circle'></i> Transaction Details","<?php echo base_url ?>admin/dashboard/transaction_details.php?id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		})
	})
</script>