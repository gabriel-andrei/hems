<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.prod-img{
		width: 5em;
    	max-height: 8em;
		object-fit:scale-down;
		object-position:center center;
	}

</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Inventory</h3>
		
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" style="margin:0px" class="btn btn-primary border btn-md rounded-pill"><span class=""></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Engine Model</th>
						<th class="text-center">Product Name</th>
						<th class="text-center">Available Stock</th>
						<th class="text-center">Stocks Status</th>
						<th class="text-center">Price</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						// $qry = $conn->query("SELECT *
						// 	, (coalesce((SELECT SUM(quantity) FROM `inventory_list` where product_id = product_list.id),0) - coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 4),0)) as `available`
						// 	, coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 4),0) as `sold` 
						// 	from `product_list` 
						// 	where delete_flag = 0 
						// 	order by `name` asc ");
						$qry = $conn->query("SELECT p.*, SUM(i.quantity) stocks , SUM(t.qty) sold 
							from `product_list` p
							LEFT JOIN inventory_list i ON p.id=i.product_id
							LEFT JOIN transaction_products t ON p.id=t.product_id 
							where p.delete_flag = 0 
							GROUP BY p.id
							order by p.`name` asc ");
						while($row = $qry->fetch_assoc()):
							$lowstock = $row['lowstock'];
							$available = $row['stocks']-$row['sold'];
							$lowinstock = $available<$row['lowstock'];
							$nostocks =  $available == 0;
					?>
						<tr >
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['engine_model'] ?></td>
							<td class="text-center"><?php echo $row['name'] ?></td>
							<td class="text-center"><?php echo $available ?></td>
							<td class="text-center" style="font-size:1.1em;"><?php echo ($lowinstock || $nostocks)?
								'<span class="badge badge-danger rounded-pill" style="padding: 5px 10px;"> Low in stock (<'.$lowstock.') </span>':
								'<span class="badge badge-success rounded-pill" style="padding: 5px 10px;"> Sufficient (>'.$lowstock.') </span>'; ?>
							</td>
							<td class="text-center"><?php echo number_format($row['price'],2) ?></td>
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
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Product permanently?","delete_product",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add New Product","inventory/manage_product.php")
		})
		$('.new_stock').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add New Stock","inventory/view_details.php")
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Update Product Details","inventory/manage_product.php?id="+$(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_product($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_product",
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