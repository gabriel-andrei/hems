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
						<th class="text-center">Date Created</th>
						<th class="text-center">Payment ID</th>
						<th class="text-center">Client Name</th>
						<th class="text-center">Balance</th>
						<th class="text-center">Total Amount</th>
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
							<td class="text-center"><?php echo $row['payment_id'] ?></td>
							<td class="text-center"><?php echo $row['client_name'] ?></td>
							<td class="text-center"><?php echo $row['balance'] ?></td>
							<td class="text-center"><?php echo $row['total_amount'] ?></td>
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

		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Update Payment Details","payment/manage_payment.php?id="+$(this).attr('data-id'))
		})
	})
	
</script>