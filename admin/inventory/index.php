<!-- inventory -->
<!-- index.php -->

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
			<table class="table table-hover table-striped table-bordered table-responsive" id="list">
				<colgroup>
					<!-- <col width="5%"> -->
					<col width="10%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center"  style="display:none">#</th>
						<th class="text-center">Engine Model</th>
						<th class="text-center">Product Name</th>
						<th class="text-center">Available Stock</th>
						<th class="text-center">Price</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						// $qry = $conn->query("SELECT *
						// 	, (coalesce((SELECT SUM(quantity) FROM `inventory_list` where product_id = product_list.id),0) - coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 3),0)) as `available`
						// 	, coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 3),0) as `sold` 
						// 	from `product_list` 
						// 	where delete_flag = 0 
						// 	order by `name` asc ");
						$qry = $conn->query("SELECT a.*, IF((stocks-sold) <= 0 OR (stocks-sold) <= lowstock, 1,0) is_low  FROM (
								SELECT p.*, COALESCE(SUM(i.quantity),0) - COALESCE(SUM(d.damaged),0) stocks , COALESCE(SUM(t.sold),0) sold
								from `product_list` p
								
								LEFT JOIN (SELECT product_id, SUM(quantity) quantity FROM inventory_list GROUP BY product_id) i ON i.product_id=p.id
								LEFT JOIN (SELECT product_id, SUM(quantity) damaged FROM inventory_damaged GROUP BY product_id) d ON d.product_id=p.id
								LEFT JOIN (SELECT product_id, SUM(qty) sold FROM transaction_products GROUP BY product_id) t ON t.product_id=p.id 
								
								where p.delete_flag = 0
								GROUP BY p.id) a
								
							ORDER BY is_low desc");
						while($row = $qry->fetch_assoc()):
							$phasedout = $row['status'] == 0;
							$lowstock = $row['lowstock'];
							$available = $row['stocks']-$row['sold'];
							$lowinstock = $available<$row['lowstock'];
							$nostocks =  $available == 0;
					?>
						<tr class="<?= (!$phasedout && ($lowinstock || $nostocks))? 'bg-red':'' ?>" >
							<td class="text-center" style="display:none"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['engine_model'] ?></td>
							<td class="text-center"><?php echo $row['name'] ?></td>
							<td class="text-center"><?php echo $available ?></td>
							<td class="text-center"><?php echo number_format($row['price'],2) ?></td>
							<td align="center">
								 <button type="button" class="btn btn-default border btn-md rounded-pill btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
									<a class="dropdown-item new_stock" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-plus text-primary"></span> Add Stock</a>
									<div class="dropdown-divider"></div>
									<?php if($available != 0): ?>
										<a class="dropdown-item new_damaged" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-exclamation-circle text-primary"></span> Add Damaged</a>
										<div class="dropdown-divider"></div>
									<?php endif; ?>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
										<div class="dropdown-divider"></div>
									<a class="dropdown-item update_price" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-dollar-sign text-primary"></span> Update Price</a>
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

		
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add New Product","inventory/manage_product.php")
		});
		$('.new_stock').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add New Stock","inventory/view_details.php?id="+$(this).attr('data-id'), 'modal-xl')
			$('#uni_modal #submit').hide();
		});
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Update Product Details","inventory/manage_product.php?id="+$(this).attr('data-id'))
		});
        $('.new_damaged').click(function(){
			uni_modal("<i class='fa fa-plus-square'></i> Add New Damaged","inventory/manage_damaged.php?id="+$(this).attr('data-id'))
			$('#uni_modal #submit').show();
        });
		$('.update_price').click(function(){
			uni_modal("<i class='fa fa-dollar-sign'></i> Update Price","inventory/update_price.php?source='list'&id="+$(this).attr('data-id'))
			$('#uni_modal #submit').show();
		});
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [3] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
	})
</script>