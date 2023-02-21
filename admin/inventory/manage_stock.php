<!-- manage_stock.php -->
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
		<input type="hidden" name ="product_id" value="<?php echo isset($id) ? $id : (isset($_GET['id']) ? $_GET['id'] : '') ?>">
		
		<div class="form-group">
			<label class="control-label">Product Name</label>
			<input type="text" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($name) ? $name : ''; ?>"  readonly/>
		</div>
		<div class="form-group">
			<label for="quantity" class="control-label">Quantity</label>
			<input type="number" min="1" max="100" oninput="numbersOnly(this)" min="1" name="quantity" id="quantity" class="form-control form-control-sm rounded-0 text-left" value=""  required/>
		</div>
		<div class="form-group">
			<label for="unit" class="control-label">Unit</label>
			<input type="text" name="unit" id="unit" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($unit) ? $unit : ''; ?>"  readonly/>
		</div>
		<div class="form-group">
			<label for="stock_date" class="control-label">Stock-In Date</label>
			<input type="date" name="stock_date" id="stock_date" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($stock_date) ? date("Y-m-d", strtotime($stock_date)) : ""; ?>" max="<?= date("Y-m-d") ?>"  required/>
		</div>
		<!--<div class="form-group col-6">
				<label for="effective_date" class="control-label">Effectivity Date</label>
				<input type="date" name="effective_date" id="effective_date" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($effective_date) ? date("Y-m-d", strtotime($effective_date)) : ""; ?>" required/>
		</div> -->
	</form>
</div>
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
		$('#inventory-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_inventory",
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