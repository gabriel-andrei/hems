<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT p.*, SUM(quantity) available from `product_list` p
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
			<label for="price" class="control-label">Price</label>
			<input type="number" min="1" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required/>
		</div>
		<div class="row">
			<div class="form-group col-6">
				<label for="unit" class="control-label">Unit</label>
				<input type="text" name="unit" id="unit" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($unit) ? $unit : ''; ?>"  required/>
			</div>
			<div class="form-group col-6">
				<label for="lowstock" class="control-label">Low Stock Value</label>
				<input type="number" min="1" name="lowstock" id="lowstock" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($lowstock) ? $lowstock : ''; ?>"  required/>
			</div>
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
				<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
			</select>
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