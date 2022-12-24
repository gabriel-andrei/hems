<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Transactions</h3>
		<div class="card-tools">
			<a href="./?page=transactions/manage_transaction" id="create_new" class="btn btn-primary border btn-md rounded-pill"><span class=""></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="20%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Client Name</th>
						<th class="text-center">Code</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						if($_settings->userdata('type') == 3):
						$qry = $conn->query("SELECT t.*, s.status_desc FROM `transaction_list` t
							LEFT JOIN tbl_status s ON s.status_id=t.status
							where tech_id = '{$_settings->userdata('id')}' order by unix_timestamp(date_updated) desc ");
						else:
						$qry = $conn->query("SELECT t.*, s.status_desc FROM `transaction_list` t
							LEFT JOIN tbl_status s ON s.status_id=t.status
							order by unix_timestamp(date_updated) desc ");
						endif;
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['client_name'] ?></p></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['code'] ?></p></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['status_desc'] ?></p></td>
							
							<td align="center">
								 <button type="button" class="btn btn-default border btn-md rounded-pill btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
									<a class="dropdown-item view_details" href="./?page=transactions/view_details&id=<?= $row['id'] ?>" data-id="<?php $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>

				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item update_status" href="./?page=transactions/update_status&id=<?= $row['id'] ?>" data-id="<?php $row['id']?>"><span class="fa fa-edit text-primary"></span>Update Status</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	
</script>