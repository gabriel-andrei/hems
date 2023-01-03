<?php
require_once('../../config.php');

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *
	, (coalesce((SELECT SUM(quantity) FROM `inventory_list` where product_id = product_list.id),0) 
		- coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 3),0)) as `available`
	,coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 3),0) as `sold` 
	from `product_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
    .bg-light-blue {
  		background-color: #cae8ff;
	}
</style>



<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Product Details</h3>
		<div class="card-tools">
			<button class="btn btn-primary border btn-md rounded-pill create_new" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-plus text-primary"></span> Add Stock</button>

            <a class="btn btn-default border btn-md rounded-pill" href="./?page=inventory" ><i class="fa fa-angle-left"></i> Back To List</a>
        </div>
	</div>
    <div class="card-body">
            <div class="container-fluid" id="printout">
                <div class="row mb-0">
                    <div class="col-4 py-1 px-2 border border-blue text-center bg-light-blue mb-0"><b>Product Name</b></div>
                    <div class="col-4 py-1 px-2 border border-blue text-center bg-light-blue mb-0"><b>Price</b></div>
					<div class="col-4 py-1 px-2 border border-blue text-center bg-light-blue mb-0"><b>Available Stock</b></div>

					<div class="col-4 py-1 px-2 border text-center mb-0"><?= isset($name) ? $name : '' ?></div>
                    <div class="col-4 py-1 px-2 border text-center mb-0"><?= isset($price) ? $price : '' ?></div>
                    <div class="col-4 py-1 px-2 border text-center mb-0"><?= isset($available) ? $available : '' ?></div>
            </div>
        </div>
    </div>
</div>


<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Stock-In Records</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="50%">
					<col width="25%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">Stock-In Date</th>
                        <th class="text-center">Quantity</th>
						<th class="text-center">Unit</th>
					</tr>
				</thead>
				<tbody>
                            <?php 
                                $inv_qry = $conn->query("SELECT * FROM `inventory_list` where product_id = '{$id}' order by unix_timestamp(`stock_date`) asc ");
                                while($row = $inv_qry->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="text-center"><?= date("M d, Y", strtotime($row['stock_date'])) ?></td>
                                <td class="text-center"><?= format_num($row['quantity']) ?></td>
                                <td class="text-center"><?= ($row['unit']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if($inv_qry->num_rows <= 0): ?>
                            <tr>
                                <th class="py-1 text-center" colspan="3">No data</th>
                            </tr>
                        <?php endif; ?>
                    </tbody>
			</table>
		</div>
		</div>
	</div>
</div>

<script>
    $(function(){
        $('.create_new').click(function(){
			uni_modal("<i class='fa fa-plus-square'></i> Add New Stock","inventory/manage_stock.php?source='list'&id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
        })
        $('.edit_data').click(function(){
            uni_modal('<i class="far fa-edit-square"></i> Edit Stock', 'inventory/manage_stock.php?product_id=<?= isset($id) ? $id : '' ?>&id='+$(this).attr('data-id'))
        })
    })

    $(document).ready(function(){
		$('.table').dataTable({
			stateSave: true,
    		"bDestroy": true,
			columnDefs: [
					{ orderable: false, targets: [2] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
    })

    function delete_inventory($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_inventory",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
