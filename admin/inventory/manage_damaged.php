<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT i.* from `product_list` i where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
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
			<input type="number" min="1" name="quantity" id="quantity" class="form-control form-control-sm rounded-0 text-left" value=""  required/>
		</div>
		<div class="form-group">
			<label for="unit" class="control-label">Unit</label>
			<input type="text" name="unit" id="unit" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($unit) ? $unit : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="inventory_id" class="control-label">Select Stock Batch</label>
			<select name="inventory_id" id="inventory_id" class="form-control form-control-sm rounded-0" required>
			<option value="" disabled selected></option>

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
			
		})

	})
</script>