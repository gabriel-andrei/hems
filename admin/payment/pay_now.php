<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
	$qry = $conn->query("SELECT t.*, COALESCE(SUM(p.total_amount)) payment
	FROM `transaction_list` t LEFT JOIN payment_list p ON t.id=p.transaction_id
	where t.id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
		$balance = $amount - $payment;
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
		<input type="hidden" name="transaction_id" id="id" class="form-control " value="<?php echo isset($id) ? $id : '' ?>"/>
		<div class="row">
                        <div class="col-8"><h3 class="text-black text-left">Remaining Balance:</h4></div>
                        <div class=""><h3 class="text-black text-right"> <b id="amount"><?= isset($amount) ? format_num($amount) : "0.00" ?></b></h4></div>
        </div>
		<hr>
                        
		<div class="row">
			<div class="form-group col-12">
				<label for="client_name" class="control-label">Client Name</label><br>
					<input type="text" name="client_name" id="client_name" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($client_name) ? $client_name : ''; ?>"  readonly/>
			</div>	
		</div>
		<div class="row">
			<div class="form-group col-6">
				<label for="code" class="control-label">Invoice Number</label><br>
					<input type="text" id="code" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($code) ? $code : ''; ?>"  readonly/>
			</div>	
			<div class="form-group col-6">
				<label for="date_created" class="control-label">Invoice Date</label><br>
					<input type="date" id="date_created" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($date_created) ?  date("Y-m-d", strtotime($date_created))  : ''; ?>"  readonly/>
			</div>	
		</div>
		<div class="row">
			<div class="form-group col-6">
				<label for="amount" class="control-label">Total Amount</label><br>
					<input type="number" id="amount" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($amount) ? $amount : ''; ?>"  readonly/>
			</div>	
			<div class="form-group col-6">
				<label for="payment" class="control-label">Total Payments</label><br>
					<input type="number" id="payment" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($payment) ? $payment : ''; ?>"  readonly/>
			</div>	
		</div>
		<input type="hidden" name="balance" id="balance" class="form-control " value="<?php echo isset($amount) ? $amount : '' ?>"/>

		<div class="row">
			<div class="form-group col-6">
				<label for="payment_type" class="control-label">Payment Type</label>
					<select name="payment_type" id="payment_type" class="form-control form-control-sm rounded-0" required>
					<option value="" disabled selected></option>
					<option value="Downpayment" <?php echo isset($payment_type) ? 'selected' : '' ?>>Downpayment</option>
					<option value="Full Payment" <?php echo isset($payment_type) ? 'selected' : '' ?>>Full Payment</option>
					</select>
				</select>
			</div>
			<div class="form-group col-6">
				<label for="engine_model" class="control-label">Payment Method</label>
					<select name="payment_method" id="payment_method" class="form-control form-control-sm rounded-0" required>
					<option value="" disabled selected></option>
					<option value="Cash on hand" <?php echo isset($payment_method) ? 'selected' : '' ?>>Cash on hand</option>
					<option value="Cheque" <?php echo isset($payment_method) ? 'selected' : '' ?>>Cheque</option>
					</select>
				</select>
			</div>
		</div>
		<div class="row " id="cheque-payment">
			<div class="form-group col-6">
				<label for="bank_id" class="control-label">Payor's Bank</label>
					<select name="bank_id" id="payment_bank" class="form-control form-control-sm rounded-0" >
					<option value="" disabled selected></option>
					<?php
					$product_qry = $conn->query("SELECT * FROM `bank_list` ");
					while($row = $product_qry->fetch_assoc()):
					?>
					<option value="<?= $row['id'] ?>"><?= $row['bank_name'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group col-6">
				<label for="cheque_number" class="control-label">Cheque Number</label><br>
				<input type="text" name="cheque_number" id="cheque_number" class="form-control form-control-sm rounded-0 text-left" value="" />
			</div>
		</div>
		<div class="row">
			<div class="form-group col-6">
				<label for="ornumber" class="control-label">OR Number</label><br>
					<input type="text" name="ornumber" id="ornumber" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($ornumber) ? $ornumber : ''; ?>" placeholder="(Optional)"/>
			</div>	
			<div class="form-group col-6">
				<label for="total_amount" class="control-label">Amount Paid</label>
				<input type="currency" name="total_amount" id="total_amount" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required/>
			</div>
		</div>
		
	</form>
</div>
<script>

	$(function(){
        $('#payment_method').select2({
            placeholder:"Select Payment Method",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
		$('#payment_method').change(function() {
            var selected = $(this).val();
			if(selected == "Cheque"){
				$("#cheque-payment").attr( "class", 'row' );
				$("#payment_bank").prop( "required", true );
				$("#cheque_number").prop( "required", true );
			}else{
				$("#cheque-payment").attr( "class", 'collapse' );
				$("#payment_bank").prop( "required", false );
				$("#cheque_number").prop( "required", false );
			}
		})
		$('#payment_type').select2({
            placeholder:"Select Payment Type",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
		$('#payment_type').change(function() {
            var selected = $(this).val();
			if (selected=='Full Payment')
				$("#total_amount").val($("#balance").val());
			else
				$("#total_amount").val($("#balance").val()/2);
		})
		$('#payment_bank').select2({
            placeholder:"Select Payor's Bank",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
		$("#cheque-payment").attr( "class", 'row collapse' );
	})

	$(document).ready(function(){
		$('#product-form').submit(function(e){
			e.preventDefault();
			if(!e.target.reportValidity())
			{
				return;
			}
            var _this = $(this);
			if (!$('#cheque-payment').hasClass('collapse')){
				if ($('#cheque_number').val() == ''){
					alert_toast("Please specify cheque number",'error');
					return;
				}
				if ($('#payment_bank').val() == ''){
					alert_toast("Please select payor's bank",'error');
					return;
				}
			}
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_payment",
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