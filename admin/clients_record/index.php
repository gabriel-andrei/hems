<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	
</style>
<div class="card card-outline card-primary">
<div class="card-header">
		<h3 class="card-title">Client's Record</h3>
	</div>
	<div class="card-body">
		
        <div class="container-fluid" id="printout">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="10%">
					<!-- <col width="10%"> -->
					<col width="20%">
					<!-- <col width="15%"> -->
					<col width="5%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Client Name</th>
						<th class="text-center">Contact #</th>
						<!-- <th class="text-center">TIN #</th> -->
						<th class="text-center">Address</th>
						<th class="text-center">Transactions</th>
						<th class="text-center">Latest Transaction</th>
						<!-- <th class="text-center">Engine Model</th> -->
						<th class="text-center">History</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$i = 1;
						$qry = $conn->query("SELECT c.*, count(t.id) trans, MAX(t.code) latest  FROM `clients_record` c 
						LEFT JOIN transaction_list t ON client_id=c.id
						group by c.id
						order by c.`date_created` desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['client_name'] ?></td>
							<td class="text-center"><?php echo $row['contact'] ?></td>
							<!-- <td class="text-center"><?php echo $row['tin_number'] ?></td> -->
							<td class="text-center"><?php echo $row['address'] ?></td>
							<!-- <td class="text-center"><?php // echo $row['engine_model'] ?></td> -->
							<td class="text-center"><?php echo $row['trans'] ?></td>
							<td class="text-center"><?php echo $row['latest'] ?></td>
							<td align="center">
							<a class="btn btn-default border btn-md rounded-pill view_history" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class=""></span> View</a>
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
		
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')

	$('.view_history').click(function(){
			uni_modal("<i class='fa fa-list'></i> Transaction History","clients_record/view_history.php?id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		})
	$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-list'></i> Update Client Details","clients_record/manage_record.php?id="+$(this).attr('data-id')+"&update")
		})
	$('.view_data').click(function(){
			uni_modal("<i class='fa fa-list'></i> View Client Details","clients_record/manage_record.php?id="+$(this).attr('data-id'))
			$('#uni_modal #submit').hide();
		})
	})
	
</script>