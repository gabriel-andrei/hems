<!-- manage_damaged.php -->
<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT p.*, COALESCE(SUM(i.quantity),0) - COALESCE(SUM(d.quantity),0) stocks , COALESCE(SUM(t.qty),0) sold 
	from `product_list` p
	LEFT JOIN inventory_list i ON p.id=i.product_id
	LEFT JOIN inventory_damaged d ON d.inventory_id=i.id
	LEFT JOIN transaction_products t ON p.id=t.product_id 
	where p.delete_flag = 0 and p.id = '{$_GET['id']}'
	GROUP BY p.id");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
	$available = $stocks-$sold;
}
?>

<div class="container-fluid">
	<form action="" id="inventory-form">
		<input type="hidden" name ="id" value="">
        <input type="hidden" name="user_id" value="<?= $_settings->userdata('id') ?>">
		<input type="hidden" name ="product_id" value="<?php echo isset($id) ? $id : (isset($_GET['id']) ? $_GET['id'] : '') ?>">
		
		<div class="form-group">
			<label class="control-label">Product Name</label>
			<input type="text" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($name) ? $name : ''; ?>"  readonly/>
		</div>
		<div class="form-group">
			<label for="quantity" class="control-label">Quantity</label>
			<input type="number" oninput="numbersOnly(this)" min="1" max="<?=$available?>" name="quantity" id="quantity" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($quantity) ? $quantity : ''; ?>"   required/>
		</div>
		<div class="form-group">
			<label for="unit" class="control-label">Unit</label>
			<input type="text" oninput="lettersOnly(this)" name="unit" id="unit" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($unit) ? $unit : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="inventory_id" class="control-label">Select Stock Batch</label>
			<select name="inventory_id" id="inventory_id" class="form-control form-control-sm rounded-0" required >
				<?php
					$service_qry = $conn->query("SELECT  id, stock_date 
						,  CONCAT(RIGHT(CONCAT('0000', product_id), 4),'-', RIGHT(CONCAT('00000', id), 5)) code
						FROM `inventory_list` 
						WHERE product_id ='{$id}'
						order by `stock_date` desc, id desc 
						LIMIT 20");
					while($row = $service_qry->fetch_assoc()): ?>
				<option value="<?= $row['id'] ?>" ><?= $row['code']?> [ Stock Date: <?= $row['stock_date']?> ]</option>
				<?php endwhile; ?>
			</select>
		</div>
	</form>
</div>
<style>
	.error{
		color:red;
	}
</style>
<script type="text/javascript">
	function lettersOnly(input){
			var regex = /[^a-z, ]/gi;
			input.value = input.value.replace(regex,"");
	}	
	function numbersOnly(input){
			var regex = /[^0-9]/g;
			input.value = input.value.replace(regex,"");
	}			
</script>
<script>
	$(document).ready(function(){
	    $('#inventory_id').select2({
            placeholder:"Select Stock Batch",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        	})
		$('#inventory-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			if(_this.validate().form()) {
				$('.err-msg').remove();
				start_loader();
				$.ajax({
					url:_base_url_+"classes/Master.php?f=save_damaged",
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					dataType: 'json',
					error:err=>{
						console.log(err)
						alert_toast(" An error occured",'error');
						end_loader();
					},
					success:function(resp){
						if(typeof resp =='object' && resp.status == 'success'){
							location.reload()
						}else if(resp.status == 'failed' && !!resp.msg){
							var el = $('<div>')
								el.addClass("alert alert-danger err-msg").text(resp.msg)
								_this.prepend(el)
								el.show('slow')
								$("html, body,.modal").scrollTop(0);
						}else{
							alert_toast("An error occured",'error');
						}
						end_loader();
					}
				})
			} else {
				return false;
			}
		})

	})
</script>