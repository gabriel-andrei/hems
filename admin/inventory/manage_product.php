<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT p.*, COALESCE(SUM(quantity),0) available from `product_list` p
		LEFT JOIN inventory_list i ON p.id=i.product_id
		where p.id = '{$_GET['id']}' 
		GROUP BY p.id");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
	#cimg{
		width:100%;
		max-height:20vh;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="container-fluid">
	<form action="" id="product-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="engine_model" class="control-label">Engine Model</label>
				<select name="engine_model" id="engine_model" class="form-control form-control-sm rounded-0" required>
				<option value="" disabled selected></option>
				<option value="4D56" <?php echo isset($engine_model) ? 'selected' : '' ?>>4D56</option>
				<option value="4D33" <?php echo isset($engine_model) ? 'selected' : '' ?>>4D33</option>
				<option value="4D32" <?php echo isset($engine_model) ? 'selected' : '' ?>>4D32</option>
				</select>
			</select>
		</div>
		<div class="form-group">
			<label for="base_price" class="control-label">Base Price</label>
			<input type="number" min="1" name="base_price" id="base_price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($base_price) ? $base_price : ''; ?>"  required/>
		</div>
		<div class="row">
			<div class="form-group col-6">
				<label for="unit" class="control-label">Selling Price %</label>
				<input type="text" name="percentage" id="percentage" disabled="disabled" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($percentage) ? $percentage : ''; ?>"  required/>
			</div>
			<div class="form-group col-6">
				<label for="" class="control-label">%</label>
				<select name="percentage" id="percentage" disabled="disabled" class="form-control form-control-sm rounded-0" required>
				<option value="" disabled selected></option>
				<option value="5" <?php echo isset($percentage) ? 'selected' : '' ?>>5%</option>
				<option value="10" <?php echo isset($percentage) ? 'selected' : '' ?>>10%</option>
				<option value="15" <?php echo isset($percentage) ? 'selected' : '' ?>>15%</option>
				<option value="20" <?php echo isset($percentage) ? 'selected' : '' ?>>20%</option>
				<option value="25" <?php echo isset($percentage) ? 'selected' : '' ?>>25%</option>
				<option value="30" <?php echo isset($percentage) ? 'selected' : '' ?>>30%</option>
				<option value="40" <?php echo isset($percentage) ? 'selected' : '' ?>>40%</option>
				<option value="50" <?php echo isset($percentage) ? 'selected' : '' ?>>50%</option>
				<option value="60" <?php echo isset($percentage) ? 'selected' : '' ?>>60%</option>
				<option value="70" <?php echo isset($percentage) ? 'selected' : '' ?>>70%</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Selling Price</label>
			<input type="number" min="1" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required/>
		</div>
		<div class="row">
			<div class="form-group col-6">
				<label for="unit" class="control-label">Unit</label>
				<input type="text" name="unit" id="unit" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($unit) ? $unit : ''; ?>"  required/>
			</div>
			<div class="form-group col-6">
				<label for="lowstock" class="control-label">Low On Stock (Threshold Value)</label>
				<input type="number" min="1" name="lowstock" id="lowstock" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($lowstock) ? $lowstock : ''; ?>"  required/>
			</div>
		</div>
		
	</form>
</div>
<script>
	
	$(function(){
        $('#engine_model').select2({
            placeholder:"Select Engine Model",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
	
	})
	$(document).ready(function(){
		$('#product-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_product",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
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
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
					}
				}
			})
		})

	})
</script>