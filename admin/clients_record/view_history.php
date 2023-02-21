<!-- view_history.php -->
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
			<table id="trans-table" class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Date</th>
						<th class="text-center">Vehicle Type</th>
						<th class="text-center">Engine Model</th>
						<th class="text-center">Machinist</th>
						<th class="text-center">Amount</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						$qry = $conn->query("SELECT t.*, concat(firstname, ' ', lastname) mechanic, s.status_desc 
						FROM `transaction_list` t 
						LEFT JOIN mechanic_list m ON m.id=mechanic_id
						LEFT JOIN tbl_status s ON s.status_id=t.status
						where client_id={$id} 
						order by unix_timestamp(t.date_updated) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['date_created'] ?></p></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['vehicle_type'] ?></p></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['engine_model'] ?></p></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['mechanic'] ?></p></td>
							<td class="text-center"><?= format_num($row['amount']) ?></td>
							<td class="text-center"><p class="m-0 truncate-1"><?= $row['status_desc'] ?></p></td>
							<td align="center">
								<a class="btn btn-default border btn-md rounded-pill history_details" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class=""></span> View</a>
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
		
		$('#trans-table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		// $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
		
	$('.history_details').click(function(){
			uni_modal("<i class='fa fa-info-circle'></i> Transaction Details","clients_record/history_details.php?id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		})
	})
</script>