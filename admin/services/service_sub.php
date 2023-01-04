<?php 

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    // $qry = $conn->query("SELECT c.* from `service_list`  c where c.service = '{$_GET['id']}' ");
    // if($qry->num_rows > 0){
    //     foreach($qry->fetch_assoc() as $k => $v){
    //         $$k=$v;
    //     }
    // }
}
?>

<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="table-sub">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Service Sub Category</th>
						<th class="text-center">Cylinder</th>
						<th class="text-center">Price</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT c.* from `service_list` c where c.service = '{$_GET['id']}' AND delete_flag = 0 order by `service_sub` asc, cylinder  asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['service_sub'] ?></td>
							<td class="text-center"><?php echo $row['cylinder'] ?></td>
							<td class="text-center"><?php echo $row['price'] ?></td>
							
							<td align="center">
								<button type="button" class="btn btn-default border btn-md rounded-pill btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"> 
									Action <span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item update_price" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Update Price</a>
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
		$('#table-sub').dataTable({
			columnDefs: [
					{ orderable: false, targets: [2] }
			],
			order:[0,'asc']
		});
		$('.edit_data').click(function(){
			uni_modal("<i class=''></i> Update Service Details","services/manage_service.php?id="+$(this).attr('data-id'))
		})
	})
</script>