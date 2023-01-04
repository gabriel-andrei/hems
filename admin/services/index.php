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
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">

					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Service Name</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `service_list` where delete_flag = 0 order by `service` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['service'] ?></td>
							<td align="center">
								<a class="btn btn-default border btn-md rounded-pill service_sub" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class=""></span> View</a>
				            	 </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>



	<!-- 
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Service Name</th>
						<th class="text-center">Service Sub Category</th>
						<th class="text-center">Cylinder</th>
						<th class="text-center">Price</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `service_list` where delete_flag = 0 order by `service` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['service'] ?></td>
							<td class="text-center"><?php echo $row['service_sub'] ?></td>
							<td class="text-center"><?php echo $row['cylinder'] ?></td>
							<td class="text-center"><?php echo $row['price'] ?></td>
							
							<td align="center">
								<a class="btn btn-default border btn-md rounded-pill edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class=""></span> Edit</a>
				            	 </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div> -->
</div>
<script>
	$(document).ready(function(){
		/*$('.delete_data').click(function(){
			_conf("Are you sure to delete this Service permanently?","delete_service",[$(this).attr('data-id')])
		}) */
		$('#service_sub').click(function(){
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