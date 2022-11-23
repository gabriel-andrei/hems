<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
	$qry = $conn->query("SELECT p.*, t.id trans_id, t.code, t.amount, COALESCE(SUM(p.total_amount)) payment, b.bank_name
	FROM payment_list p LEFT JOIN `transaction_list` t ON t.id=p.transaction_id
	LEFT JOIN `bank_list` b ON b.id=p.bank_id
	where p.id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
			// echo $k . ' = ' . $v;
			// echo '<br/>';
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
		<?php if(!isset($_GET['source'])): ?>
		<div class="card-tools d-flex justify-content-end">
			<a class="btn btn-default border btn-md rounded-pill back-to-list" id="back-to-list" href="javascript:void(0)" data-id="<?php echo $client_id ?>"><i class="fa fa-angle-left"></i> Back to List</a>
		</div>
		<?php endif; ?>
		
		<input type="hidden" name="transaction_id" id="id" class="form-control " value="<?php echo isset($trans_id) ? $trans_id : '' ?>"/>
                        
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
				<label for="payment_type" class="control-label">Payment Type</label><br>
					<input type="text" id="payment_type" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($payment_type) ? $payment_type : ''; ?>"  readonly/>
			</div>	
			<div class="form-group col-6">
				<label for="payment_method" class="control-label">Payment Method</label><br>
					<input type="text" id="payment_method" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($payment_method) ? $payment_method : ''; ?>"  readonly/>
			</div>	
		</div>

		<?php if($payment_method=='Cheque'): ?>
		<div class="row " id="cheque-payment">
			
			<div class="form-group col-6">
				<label for="bank_name" class="control-label">Payor's Bank</label><br>
					<input type="text" id="bank_name" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($bank_name) ? $bank_name : ''; ?>"  readonly/>
			</div>	
			<div class="form-group col-6">
				<label for="cheque_number" class="control-label">Cheque Number</label><br>
					<input type="text" id="cheque_number" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($cheque_number) ? $cheque_number : ''; ?>"  readonly/>
			</div>	
		</div>
		<?php endif; ?>

		<div class="row">
			<div class="form-group col-6">
				<label for="ornumber" class="control-label">OR Number</label><br>
					<input type="text" name="ornumber" id="ornumber" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($ornumber) ? $ornumber : ''; ?>" placeholder="(Optional)" readonly/>
			</div>	
			<div class="form-group col-6">
				<label for="total_amount" class="control-label">Amount Paid</label>
				<input type="currency" name="total_amount" id="total_amount" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($total_amount) ? $total_amount : ''; ?>"  readonly/>
			</div>
		</div>
	</form>
</div>
<script>

$(document).ready(function(){
		$('.back-to-list').click(function(){
				uni_modal("<i class='fa fa-eye'></i> Payments History","payment/view_payments.php?id=<?=$trans_id?>", 'modal-xl')
				$('#uni_modal #cancel').show();
		})
	})
</script>