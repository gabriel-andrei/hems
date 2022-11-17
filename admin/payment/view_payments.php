<?php 

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT c.* from `clients_record`  c where c.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="card card-primary m-1">
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="10%">
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
						<th class="text-center">Payment</th>
						<th class="text-center">Balance</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$i = 1;
						$qry = $conn->query("SELECT * FROM `payment_list` 
							WHERE transaction_id={$id}
							order by `date_created` desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['date_created'] ?></td>
							<td class="text-center"><?php echo $row['ornumber'] ?></td>
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
		
		$('#trans-table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		// $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
		
	})
</script>