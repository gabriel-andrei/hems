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
					<col width="15%">
					<col width="20%">
					<col width="10%">
					<col width="20%">
					<col width="15%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Date Time</th>
						<th class="text-center">Client</th>
						<th class="text-center">Contact #</th>
						<th class="text-center">Address</th>
						<th class="text-center">Engine Model</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					
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