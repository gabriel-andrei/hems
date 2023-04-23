<!-- update_price.php -->

<?php 
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `product_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="update_price-form">
        <input type="hidden" name="user_id" value="<?= $_settings->userdata('id') ?>">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" name="old_price" value="<?= isset($price) ? $price : '' ?>">
        <input type="hidden" name="old_base_price" value="<?= isset($base_price) ? $base_price : '' ?>">
        <input type="hidden" name="old_percentage" value="<?= isset($percentage) ? $percentage : '' ?>">
        <div class="row">
            
            <div class="form-group mb-3 col-6">
                <label for="base_price" class="control-label">Base Price</label>
                <input type="number" min="1" max="9999999" oninput="numbersOnly(this)" name="base_price" id="base_price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($base_price) ? $base_price : ''; ?>"  required/>
            </div>


            <div class="form-group mb-3 col-6">
                <div class="form-group">
                        <label for="select_percentage" class="control-label">Profit Percentage</label>
                        <select id="select_percentage" <?=isset($base_price) && $base_price>0 ? '': 'disabled="disabled"' ?> class="form-control form-control-sm rounded-0" required>
                        <option value="" disabled selected></option>
                        <?php $iscustom = true; for($i=5; $i<71; $i+=5): if(isset($percentage) && $percentage==$i ) $iscustom=false; ?>
                            <option value="<?= $i?>" <?php echo isset($percentage) && $percentage==$i ? 'selected' : '' ?>><?= $i?>%</option>
                        <?php endfor;?>
                        <option value="custom" <?php echo isset($percentage) && $percentage=='custom' ? 'selected' : ''  ?>>Custom</option>
                        </select>
                </div>

                <div class="row" id="specify_percentage_id">
                    <div class="form-group col-12">
                            <label for="percentage" class="control-label">Specify Percentage</label>
                            <input type="number" min="0" max="100" oninput="numbersOnly(this)" name="percentage" id="percentage" <?=isset($base_price) && $base_price>0 ? '': 'readonly' ?> 
                            class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($percentage) ? $percentage : ''; ?>"  required/>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 col-6">
                <label for="price" class="control-label">Selling Price</label>
                <input type="number" min="1" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required readonly/>
            </div>

            <div class="form-group mb-3 col-6">
                <label for="date_effect" class="control-label">Effectivity Date</label>
                <input type="date" name="date_effect" id="date_effect" class="form-control form-control-sm rounded-0 text-left" required="required">
            </div>
        </div>
    </form>
    <div class="">
        <bold>Price History</bold>
        <hr/>
                                    <table class="table table-striped table-bordered" id="product-list">
                                        <colgroup>
                                            <col width="30%">
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="15%">
                                        </colgroup>
                                        <thead>
                                            <tr class="bg-light-blue">
                                                <th class="text-center">Date Effect</th>
                                                <th class="text-center">Old</th>
                                                <th class="text-center">New</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $tp_qry = $conn->query("SELECT l.*
                                                FROM product_price_logs l
                                                where prod_id = '{$id}' 
                                                ORDER BY l.date_effect DESC");
                                            while($row = $tp_qry->fetch_assoc()):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?=$row['date_effect']  ?></td>
                                                <td class="text-center"><?=$row['from_price']  ?></td>
                                                <td class="text-center"><?=$row['new_price']  ?></td>
                                                <td class="text-center"><?=$row['is_applied']==0?'Pending':'Applied'  ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
    </div>
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
			$("#specify_percentage_id").attr( "class", 'collapse' );

		function computePrice(){
			var base = $('#base_price').val() * 1;
			var perc = $('#percentage').val() * 1;

			var amount = (base * (perc/100)).toFixed(2) * 1;
			var price = base + amount;
			$('#price').val(price);
		}
		
		$('#update_price-form #base_price').change(function(e){
			var base = $('#base_price').val();
			if(base == 0 ){
				$('#select_percentage').prop('disabled', true);
			}else{
				$('#select_percentage').prop('disabled', false);
			}
            computePrice();
		});

		$('#update_price-form #percentage').change(function(e){
            computePrice();
		});
        
		$('#update_price-form #select_percentage').change(function(e){
			var select = $('#select_percentage').val();
			if(select == 'custom' ){
				$('#percentage').prop('readonly', false);
				$('#percentage').val(<?=isset($percentage) ? $percentage : ''?>);
				$("#specify_percentage_id").attr( "class", 'row' );

			}else{
				$('#percentage').prop('readonly', true);
				$('#percentage').val(select);
				$("#specify_percentage_id").attr( "class", 'collapse' );

			}
            computePrice();
		});



		$('#update_price-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
            if(_this.validate().form()) {
                $('.err-msg').remove();
                start_loader();
                $.ajax({
                    url:_base_url_+"classes/Master.php?f=update_price_product",
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
                                $("html, body, .modal").scrollTop(0);
                                end_loader()
                        }else{
                            alert_toast("An error occured",'error');
                            end_loader();
                        }
                    }
                })
            }
		})

	})
</script>