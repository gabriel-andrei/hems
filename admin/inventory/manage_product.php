<!-- manage_product.php -->
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
			<input type="text" oninput="lettersOnly(this)" name="name" id="name" class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : ''; ?>"  required/>
		</div>
		<div class="row">
			<div class="form-group col-12">
				<label for="engine_model" class="control-label">Engine Model</label>
				<select name="engine_model" id="engine_model" class="form-control form-control-sm rounded-0" required>
					<option value="" disabled selected></option>
					<option value="4D56" <?php echo isset($engine_model)  && $engine_model=='4D56' ? 'selected' : '' ?>>4D56</option>
					<option value="4D33" <?php echo isset($engine_model)  && $engine_model=='4D33' ? 'selected' : '' ?>>4D33</option>
					<option value="4D32" <?php echo isset($engine_model)  && $engine_model=='4D32' ? 'selected' : '' ?>>4D32</option>
					<option value="custom" <?php echo isset($engine_model) ? 'selected' : '' ?>>Custom</option>
					</select>
				</select>
			</div>
			
			<!-- <div class="form-group col-6">
				<label for="" class="control-label">&nbsp;</label>
				<br/>
				<input type="checkbox"name="status" id="status" class="form-check-input form-control form-control-sm rounded-0 w-100" data-on="Yes" data-off="No" data-bootstrap-switch value="status" <?php echo isset($status) && $status == 1 ? 'checked' : ''; ?>  />
				<label for="status" class="form-check-label ml-1">Availability</label>
			</div> -->
		</div>
		<div class="row" id="custom_engine_id">
			<div class="form-group col-12">
					<label for="custom_engine" class="control-label">Specify Engine Model</label>
					<input type="text" oninput="lettersAndNumbers(this)" name="engine_model" id="custom_engine" disabled="disabled" 
					class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($engine_model) ? $engine_model : ''; ?>"  required/>
			</div>
		</div>

		<div class="form-group">
			<label for="base_price" class="control-label">Base Price</label>
			<input type="number" min="1" max="9999999" oninput="numbersOnly(this)" name="base_price" id="base_price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($base_price) ? $base_price : ''; ?>"  required/>
		</div>

		<div class="form-group" id="select_percentage_id">
				<label for="select_percentage" class="control-label">Profit Percentage</label>
				<select id="select_percentage" <?=isset($base_price) && $base_price > 0 ? '': 'disabled="disabled"' ?> class="form-control form-control-sm rounded-0" required>
					<option value="" disabled selected></option>
					<option value="5" <?php echo isset($percentage) && $percentage=='5' ? 'selected' : '' ?>>5%</option>

					<?php $iscustom = true; for($i=10; $i<71; $i+=5): if(isset($percentage) && $percentage==$i ) $iscustom=false; ?>
						<option value="<?= $i?>" <?php echo isset($percentage) && $percentage==$i ? 'selected' : '' ?>><?= $i?>%</option>
					<?php endfor;?>
					<option value="custom" <?php echo isset($percentage) && $percentage=='custom' ? 'selected' : ''  ?>>Custom</option>

				</select>
		</div>

		<div class="row" id="specify_percentage_id">
			<div class="form-group col-12">
					<label for="percentage" class="control-label">Specify Percentage</label>
					<input type="number" min="0" max="100" oninput="numbersOnly(this)" name="percentage" id="percentage" <?=isset($base_price) && $base_price > 0 ? '': '' ?> 
					class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($percentage) ? $percentage : ''; ?>"  required/>
			</div>
		</div>

		<div class="form-group">
			<label for="price" class="control-label">Selling Price</label>
			<input type="number" min="1" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required readonly/>
		</div>

		<div class="row">
			<div class="form-group col-12">
				<label for="unit" class="control-label">Unit</label>
                <select name="unit" id="unit" class="form-control form-control-sm rounded-0 text-left" required>
					<option value="" disabled selected></option>
                    <option value="pieces" <?php echo isset($unit) && $unit=='pieces' ? 'selected' : '' ?>>pieces</option>
                    <option value="liters" <?php echo isset($unit)  && $unit=='liters' ? 'selected' : '' ?>>liters</option>
                    <option value="boxes" <?php echo isset($unit)  && $unit=='boxes' ? 'selected' : '' ?>>boxes</option>
					<option value="custom" <?php echo isset($unit)  && $unit=='custom' ? 'selected' : '' ?>>Custom</option>
                </select>
			</div>
		</div>
		<div class="row" id="specify_unit_id">
			<div class="form-group col-12">
					<label for="custom_unit" class="control-label">Specify Unit</label>
					<input type="text" oninput="lettersOnly(this)" name="unit" id="custom_unit" disabled="disabled" 
					class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($unit) ? $unit : ''; ?>"  required/>
			</div>
		</div>
		<div class="form-group">
				<label for="lowstock" class="control-label">Low Stock (Lowest Limit Value)</label>
				<input type="number" min="1" max="1000" oninput="numbersOnly(this)" name="lowstock" id="lowstock" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($lowstock) ? $lowstock : ''; ?>"  required/>
			</div>
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
	function lettersAndNumbers(input){
			var regex = /[^0-9,^aA-zZ]/g;
			input.value = input.value.replace(regex,"");
	}		
</script>
<script>

	$(document).ready(function(){
		$("#custom_engine_id").attr( "class", 'collapse' );
		$("#specify_unit_id").attr( "class", 'collapse' );
		$("#specify_percentage_id").attr( "class", 'collapse' );

		<?php if(isset($id)): ?>
			$("#product-form #base_price").prop( "readonly", true );
			$("#product-form #select_percentage").prop( "disabled", true );
			$("#product-form #percentage").prop( "disabled", true );
		<?php endif; ?>
		
		$('[data-mask]').inputmask();
		
		$("input[data-bootstrap-switch]").each(function(){
			$(this).bootstrapSwitch();
		})
			$(".bootstrap-switch-handle-on").html('Available');
			$(".bootstrap-switch-handle-off").html('Phased.Out');
		function computePrice(){
			var base = $('#base_price').val() * 1;
			var perc = $('#percentage').val() * 1;

			var amount = (base * (perc/100)).toFixed(2) * 1;
			var price = base + amount;
			$('#price').val(price);
		}
		
		$('#product-form #base_price').change(function(e){
			var base = $('#base_price').val();
			if(base == 0 ){
				// $('#percentage').prop('disabled', true);
				$('#select_percentage').prop('disabled', true);
				$('#select_percentage_id').val('');
			}else{
				// $('#percentage').prop('disabled', false);
				$('#select_percentage').prop('disabled', false);

			}
            computePrice();
		});

		$('#product-form #percentage').change(function(e){
            computePrice();
		});

		$('#product-form #select_percentage').change(function(e){
			var select = $('#select_percentage').val();
			if(select == 'custom' ){
				// $('.group-percentage').show();
				$('#percentage').prop('readonly', false);
				$('#percentage').val(<?=isset($percentage) ? $percentage : ''?>);
				$("#specify_percentage_id").attr( "class", 'row' );

			}else{
				// $('.group-percentage').hide();
				$('#percentage').prop('readonly', true);
				$('#percentage').val(select);
				$("#specify_percentage_id").attr( "class", 'collapse' );

			}
			computePrice();
		});

		$('#engine_model').change(function(e){
			var select = $('#engine_model').val();
			if(select == 'custom' ){
				// $('.group-percentage').show();
				$('#custom_engine').prop('disabled', false);
				$("#custom_engine_id").attr( "class", 'row' );

			}else{
				// $('.group-percentage').hide();
				$('#custom_engine').prop('disabled', true);
				$('#engine_model').val(select);
				$("#custom_engine_id").attr( "class", 'collapse' );
			}
		});

		$('#unit').change(function(e){
			var select = $('#unit').val();
			if(select == 'custom' ){
				// $('.group-percentage').show();
				$('#custom_unit').prop('disabled', false);
				$("#specify_unit_id").attr( "class", 'row' );

			}else{
				// $('.group-percentage').hide();
				$('#custom_unit').prop('disabled', true);
				$('#unit').val(select);
				$("#specify_unit_id").attr( "class", 'collapse' );

			}
		});

        $('#engine_model').select2({
            placeholder:"Select Engine Model",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        });
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
                    }else{
						alert_toast("An error occured",'error');
					}
					end_loader();
				}
			})
		})

	})
</script>