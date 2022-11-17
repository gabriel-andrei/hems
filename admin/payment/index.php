<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Transactions</h3>
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
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Client Name</th>
						<th class="text-center">Invoice Number</th>
						<th class="text-center">Amount</th>
						<th class="text-center">Balance</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						$qry = $conn->query("SELECT t.*, COALESCE(SUM(p.total_amount)) payment
						FROM `transaction_list` t LEFT JOIN payment_list p ON t.id=p.transaction_id
						where t.`status` > 0 
						order by unix_timestamp(t.date_updated) desc ");
						while($row = $qry->fetch_assoc()):
							$balance = $row['amount']-$row['payment'];
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['client_name'] ?></p></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['code'] ?></p></td>
							<td class="text-center"><?= number_format($row['amount'],2) ?></td>
							<td class="text-center"><?= number_format($balance,2) ?></td>
							<td class="text-center">
								<?php
								switch($row['status']){
									case 0:
										echo '<span class="">Pending</span>';
										break;
									case 1:
										echo '<span class="">On-Progress</span>';
										break;
									case 2:
										echo '<span class="">Done</span>';
										break;
									case 3:
										echo '<span class="">Paid</span>';
										break;
									case 4:
										echo '<span class="">Cancelled</span>';
										break;
								}
								?>
                            </td>
							<td align="center">
								<?php if($balance != 0 ): ?>
									<a class="btn btn-default border btn-md rounded-pill pay_now" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class=""></span> Pay Now</a>
								<?php else: ?>
									<a class="btn btn-default border btn-md rounded-pill view_payments" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class=""></span> Payments</a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>

<div class="card card-outline card-success">
	<div class="card-header">
		<h3 class="card-title">Payments History</h3>
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
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Date</th>
						<th class="text-center">OR Number</th>
						<th class="text-center">Client Name</th>
						<th class="text-center">Payment</th>
						<th class="text-center">Balance</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$i = 1;
						$qry = $conn->query("SELECT * FROM `payment_list` order by `date_created` desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['date_created'] ?></td>
							<td class="text-center"><?php echo $row['ornumber'] ?></td>
							<td class="text-center"><?php echo $row['client_name'] ?></td>
							<td class="text-center"><?php echo $row['total_amount'] ?></td>
							<td class="text-center"><?php echo $row['balance'] ?></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="">Active</span>
                                <?php else: ?>
                                    <span class="">Inactive</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								<a class="btn btn-default border btn-md rounded-pill edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class=""></span> View</a>
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

		$('.pay_now').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add Payment","payment/pay_now.php?id="+$(this).attr('data-id'))
		})
		$('.view_payments').click(function(){
			uni_modal("<i class='fa fa-eye'></i> Payments History","payment/view_payments.php?id="+$(this).attr('data-id'), 'modal-xl')
		})
		// $('.edit_data').click(function(){
		// 	uni_modal("<i class='fa fa-edit'></i> View Payment Details","payment/manage_payment.php?id="+$(this).attr('data-id'))
		// })
	})
	
</script>