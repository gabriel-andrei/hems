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
					<!-- <col width="5%"> -->
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center" style="display:none">#</th>
						<th class="text-center">Transaction Number</th>
						<th class="text-center">Status</th>
						<th class="text-center">Balance</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						// if($_settings->userdata('type') == 3):
						// $qry = $conn->query("SELECT t.*, s.status_desc FROM `transaction_list` t
						// 	LEFT JOIN tbl_status s ON s.status_id=t.status
						// 	where tech_id = '{$_settings->userdata('id')}' order by unix_timestamp(date_updated) desc ");
						// else:
						// $qry = $conn->query("SELECT t.*, s.status_desc FROM `transaction_list` t
						// 	LEFT JOIN tbl_status s ON s.status_id=t.status
						// 	where `status` < 2
						// 	order by unix_timestamp(date_updated) desc ");
						// endif;
						
						$qry = $conn->query("SELECT t.*, s.status_desc , COALESCE(SUM(p.total_amount), 0) payment, t.amount-COALESCE(SUM(p.total_amount), 0) balance
							FROM `transaction_list` t 
							LEFT JOIN payment_list p ON t.id=p.transaction_id
								LEFT JOIN tbl_status s ON s.status_id=t.status
							GROUP BY t.id
							HAVING t.`status` < 2 OR (t.status =2 AND balance > 0)
							order by unix_timestamp(t.date_updated) desc ");

						while($row = $qry->fetch_assoc()):
							$balance = $row['balance'];
							$payments = $row['payment'];
					?>
						<tr>
							<td class="text-center" style="display:none"><?php echo $i++; ?></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['code'] ?></p></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['status_desc'] ?></p></td>
							<td class="text-center"><?= ($balance==0? 'Fully Paid' : number_format($balance,2)) ?></td>
							
							<td align="center">
								 <button type="button" class="btn btn-default border btn-md rounded-pill btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	
									<a class="dropdown-item view_details" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
				                    <div class="dropdown-divider"></div>
									<?php if($balance != 0 && ($row['status'] > 0 && $row['status'] < 3) ): ?>
										<a class="dropdown-item pay_now" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-cash-register text-primary"></span> Pay Now</a>
										<div class="dropdown-divider"></div>
									<?php endif; ?>
									<a class="dropdown-item update_status" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Update Status</a>
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
					{ orderable: false, targets: [3] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')

		$('.view_details').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Transaction Details","transactions/view_details.php?source='list'&id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		})

		$('.update_status').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Update Status","transactions/update_status.php?source='list'&id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').show();
		})

		$('.pay_now').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add Payment","payment/pay_now.php?id="+$(this).attr('data-id'))
			$('#uni_modal #submit').show();
		})
		$('.view_payments').click(function(){
			uni_modal("<i class='fa fa-eye'></i> Payments History","payment/view_payments.php?id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		})
	})
	
</script>