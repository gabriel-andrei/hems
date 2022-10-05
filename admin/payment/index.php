<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	
</style>
<div class="card card-outline card-primary">
<div class="card-header">
		<h3 class="card-title">Payments</h3>
	</div>
	<div class="card-body">	
        <div class="container-fluid" id="printout">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="10%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Date Updated</th>
						<th class="text-center">Payment ID</th>
						<th class="text-center">Client</th>
						<th class="text-center">Balance</th>
						<th class="text-center">Total Amount</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$i = 1;
						$qry = $conn->query("SELECT * FROM `payment_list` where status = 1 order by `client_name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['engine_model'] ?></td>

							<td class="text-center"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class="text-center">
								<img class="img-thumbnail prod-img" src="<?= validate_image($row['image_path']) ?>" alt="">
							</td>
							<td class="text-center"><?php echo $row['name'] ?></td>
							<td class="text-center"><?php echo $row['available'] ?></td>
							<td class="text-center"><?php echo $row['sold'] ?></td>
							<td class="text-center"><?php echo $row['price'] ?></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-default border btn-md rounded-pill btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
									<a class="dropdown-item new_stock" href="./?page=inventory/view_details&id=<?= $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-plus text-dark"></span> Add Stock</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	
</script>