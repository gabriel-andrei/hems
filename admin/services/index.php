<!-- services -->
<!-- index.php -->
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline">
	<div class="card-header">
		<h3 class="card-title">List of Services</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-primary border btn-md rounded-pill"><span class=""></span>  Create New</a>
		</div>
	</div>

	<div class="card-body">
        <div class="container-fluid">
			<div class="row align-items-end mb-2">
                                        <div class="col-3">
                                            <div class="form-group mb-0">
                                                <label for="service_sel" class="control-label">Select Service</label>
                                                <select name="service_sel" id="service_sel" class="form-control form-control-sm rounded-0" >
                                                    <option value="" selected>Show All</option>
                                                    <?php
                                                    $service_qry = $conn->query("SELECT DISTINCT `service` FROM `service_list` where delete_flag = 0 and `status` = 1 order by `service`");
                                                    while($row = $service_qry->fetch_assoc()):
                                                    ?>
                                                    <option value="<?= $row['service'] ?>" <?= (isset($_GET['service']) && $row['service']==$_GET['service'])? 'selected':''?>><?= $row['service'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-3">
                                            <div class="form-group mb-0">
                                                <label for="service_sel_sub" class="control-label">Select Service Sub Category</label>
                                                <?php if(isset($_GET['sub'])):?>
													<select id="service_sel_sub" class="form-control form-control-sm rounded-0" >
														<option value="Show All" >Show All</option>
														<?php
														$service_qry = $conn->query("SELECT DISTINCT service_sub, `price` FROM `service_list` 
														where `service`='{$_GET['service']}' AND delete_flag = 0 and `status` = 1 group by CONCAT(`service`,':',`service_sub`) order by `service_sub`");
														while($row = $service_qry->fetch_assoc()):
														?>
														<option value="<?= $row['service_sub'] ?>" data-price="<?= $row['price'] ?>"  <?= (isset($_GET['sub']) && $row['service_sub']==$_GET['sub'])? 'selected':''?>><?= $row['service_sub'] ?></option>
														<?php endwhile; ?>
													</select>
												<?php else:?>
													<select id="service_sel_sub" class="form-control form-control-sm rounded-0" disabled="">
													</select>
												<?php endif;?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary border btn-sm rounded-pill" type="button" id="reload-list" <?php if(!isset($_GET['sub'])):?> disabled="" <?php endif;?>><i class=""></i> Reload</button>
                                        </div>
                                    </div>
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					    <!-- <col width="5%"> -->
						<?php if (!isset($_GET['service'])): ?>
						<col width="15%">
						<?php endif; ?>
						<?php if (!isset($_GET['sub']) || (isset($_GET['sub']) && $_GET['sub']=='Show All')): ?>
						<col width="15%">
						<?php endif; ?> 
					<col width="10%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center" style="display:none">#</th>
						<?php if (!isset($_GET['service'])): ?>
						<th class="text-center">Service</th>
						<?php endif; ?>
							<?php if (!isset($_GET['sub']) || (isset($_GET['sub']) && $_GET['sub']=='Show All')): ?>
						<th class="text-center">Service Sub Category</th>
						<?php endif; ?>
						<th class="text-center">Cylinder</th>
						<th class="text-center">Price</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$sql = "SELECT * from `service_list` ";
					$sql .= " where delete_flag = 0 ";
					if (isset($_GET['service']))
						$sql .= " AND `service` = '{$_GET['service']}'";
					if (isset($_GET['sub'])  && $_GET['sub']<>'Show All')
						$sql .= " AND service_sub = '{$_GET['sub']}'";
					$sql .= " order by `service` asc, `service_sub` asc, `cylinder` asc  ";
						$qry = $conn->query($sql);
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center" style="display:none"><?php echo $i++; ?></td>
							<?php if (!isset($_GET['service'])): ?>
							<td class="text-center"><?php echo $row['service'] ?></td>
							<?php endif; ?>
							<?php if (!isset($_GET['sub']) || (isset($_GET['sub']) && $_GET['sub']=='Show All')): ?>
							<td class="text-center"><?php echo $row['service_sub'] ?></td>
							<?php endif; ?>
							<td class="text-center"><?php echo $row['cylinder'] ?></td>
							<td class="text-center"><?php echo $row['price'] ?></td>
							<td align="center">
								<button type="button" class="btn btn-default border btn-md rounded-pill btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"> 
									Action <span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item update_price" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-dollar-sign text-primary"></span> Update Price</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		/*$('.delete_data').click(function(){
			_conf("Are you sure to delete this Service permanently?","delete_service",[$(this).attr('data-id')])
		}) */

		$('.update_price').click(function(){
			uni_modal("<i class='fa fa-dollar-sign'></i> Update Price","services/update_price.php?source='list'&id="+$(this).attr('data-id'))
			$('#uni_modal #submit').show();
		})
		$('.service_sub').click(function(){
			uni_modal("<i class='text-center'></i> Service Sub Category","services/service_sub.php?source='list'&id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		})
		$('.view_details').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Transaction Details","transactions/view_details.php?source='list'&id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		})
		$('#create_new').click(function(){
			uni_modal("<i class='text-center'></i> Add New Service","services/manage_service.php")
		})
		$('.view_data').click(function(){
			uni_modal("<i class=''></i> Service Details","services/view_service.php?id="+$(this).attr('data-id'))
		})
		$('.edit_data').click(function(){
			uni_modal("<i class=''></i> Update Service Details","services/manage_service.php?id="+$(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [2] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_service($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_service",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>

<!-- AJAX SCRIPTS -->
<script>
    $(document).ready(function() {
        
        $("#service_sel").change(function() {
            var service = $(this).val();
			if (service == "")
				reloadList();
			else{
				$(this).fadeIn();

				start_loader();
				$.ajax({
					url:_base_url_+"admin/services/ajax-data.php",
					method:"POST",
					data: {
						type: 'service',
						value: service
					},
					dataType:"html",
					error:err=>{
						console.log(err)
						alert_toast("An error occured.",'error');
						end_loader();
					},
					success:function(resp){
						if(resp != ''){
							$("#service_sel_sub").empty();
							 $("#service_sel_sub").prop( "disabled", false );

							$("#reload-list").prop( "disabled", false );

							$("#service_sel_sub").append(resp);

							reloadList();
						}else{
							alert_toast("An error occured.",'error');
						}
						end_loader();
					}
				});
			}
        });
        
        $("#service_sel_sub").change(function() {
			reloadList();
        });

		$("#reload-list").click(function() {
			reloadList();
        });
		function reloadList(){
            var service = $("#service_sel").val();
            var sub = $("#service_sel_sub").val();
			if (service == "")
			location.href = "./?page=services";
			else
			location.href = "./?page=services&service="+service +"&sub="+sub;
		}
     });
</script>