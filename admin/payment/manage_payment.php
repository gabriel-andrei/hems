<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `payment_list` where id = '{$_GET['id']}' ");
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
			<label for="clients_name" class="control-label">Client's Name</label><br>
				<input type="text" name ="client_name" value="<?php echo isset($client_name) ? $client_name : '' ?>" readonly>
		</div>	
		<div class="form-group">
			<label for="engine_model" class="control-label">Payment Method</label>
				<select name="payment_method" id="payment_method" class="form-control form-control-sm rounded-0" required>
				<option value="" disabled selected></option>
				<option value="Cash on hand" <?php echo isset($payment_method) ? 'selected' : '' ?>>Cash on hand</option>
				<option value="Cheque" <?php echo isset($payment_method) ? 'selected' : '' ?>>Cheque</option>
				</select>
			</select>
		</div>
		<div class="form-group">
			<label for="cheque_number" class="control-label">Cheque Number</label>
			<textarea type="text" name="cheque_number" id="cheque_number" class="form-control form-control-sm rounded-0" required><?php echo isset($cheque_number) ? $cheque_number : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="engine_model" class="control-label">Payment Type</label>
				<select name="payment_type" id="payment_type" class="form-control form-control-sm rounded-0" required>
				<option value="" disabled selected></option>
				<option value="Downpayment" <?php echo isset($payment_type) ? 'selected' : '' ?>>Downpayment</option>
				<option value="Full Payment" <?php echo isset($payment_type) ? 'selected' : '' ?>>Full Payment</option>
				</select>
			</select>
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Amount Paid</label>
			<input type="text" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="total_amount" class="control-label">Total Amount</label><br>
				<input type="text" name ="total_amount" value="<?php echo isset($total_amount) ? $total_amount : '' ?>" readonly>
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