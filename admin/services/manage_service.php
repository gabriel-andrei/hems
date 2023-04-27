<!-- manage_service.php -->

<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `service_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="service-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="select_service" class="control-label">Service Name</label>
			<select id="select_service" class="form-control form-control rounded-0" >
				<OPTGROUP LABEL="">
					<option value="" >New Service Name</option>
				</OPTGROUP>
				<OPTGROUP LABEL="Existing Services">
					<?php 
						$mechanic_qry = $conn->query("SELECT distinct `service`
							from `service_list` 
							order by 1 asc");
						while($row = $mechanic_qry->fetch_array()):
						?>
					<option value="<?= $row['service'] ?>" <?= isset($service) && $service == $row['service'] ? "selected" : "" ?> >
					<?= $row['service']?>
					</option>
					<?php endwhile; ?>
				</OPTGROUP>
			</select>
		</div>
		<div class="form-group group-service" id="select_service_id">
			<label for="percentage" class="control-label">Specify Service Name</label>
			<input type="service" oninput="lettersOnly(this)" name="service" id="service" 
				class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($service) ? $service : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="service_sub" class="control-label">Service Sub Category</label>
			<textarea type="text" oninput="lettersAndNumbers(this)" name="service_sub" id="service_sub" class="form-control form-control-sm rounded-0" required><?php echo isset($service_sub) ? $service_sub : ''; ?></textarea>
		</div>
		<div class="form-group" id="cylinder_id">
			<label for="cylinder" class="control-label">Cylinder</label>
			<select name="cylinder" id="cylinder" class="form-control form-control-sm rounded-0" required>
			<option value="1 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>1 Cylinder</option>
			<option value="2 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>2 Cylinder</option>
			<option value="3 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>3 Cylinder</option>
			<option value="4 Small" <?php echo isset($cylinder) ? 'selected' : '' ?>>4 Small</option>
			<option value="4 Big" <?php echo isset($cylinder) ? 'selected' : '' ?>>4 Big</option>
			<option value="6 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>6 Cylinder</option>
			<option value="Heavy" <?php echo isset($cylinder) ? 'selected' : '' ?>>Heavy</option>
			<option value="custom" <?php echo isset($cylinder) ? 'selected' : ''  ?>>Custom</option>

			</select>
		</div>

		<div class="row" id="select_cylinder_id">
			<div class="form-group col-12">
					<label for="cylinder" class="control-label">Specify Cylinder</label>
					<input type="text" oninput="lettersAndNumbers(this)" name="cylinder" id="cylinder" 
					class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($cylinder) ? $cylinder : ''; ?>"  required/>
			</div>
		</div>

		<div class="form-group">
			<label for="price" class="control-label">Price</label>
			<input type="text" oninput="numbersOnly(this)" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required/>
		</div>
			<!--
		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Available</option>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Not Available</option>
			</select>
		</div>
		
		<?php if(isset($id)):?>
		<hr/>
		<div class="">
			<label for="" class="">Price History</label>
            <table class="table table-striped table-bordered" id="product-list">
                <colgroup>
                <col width="30%">
                <col width="15%">
                <col width="15%">
                </colgroup>
                    <thead>
                        <tr class="bg-light-blue">
							<th class="text-center">Date/Time</th>
							<th class="text-center">Old</th>
							<th class="text-center">New</th>
                        </tr>
                    </thead>
                <tbody>
                                        <?php 
                                            $tp_qry = $conn->query("SELECT l.*
                                                FROM service_price_logs l
                                                where serv_id = '{$id}' 
                                                ORDER BY l.date_effect DESC");
                                            while($row = $tp_qry->fetch_assoc()):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?=$row['date_effect']  ?></td>
                                                <td class="text-center"><?=$row['from_price']  ?></td>
                                                <td class="text-center"><?=$row['new_price']  ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                </tbody>
            </table>
    	</div>
	<?php endif; ?>
	-->
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
			var regex = /[^0-9,^aA-zZ ]/g;
			input.value = input.value.replace(regex,"");
	}	
</script>
<script>
		<?php if(isset($service)):?>
			$('.group-service').hide();
		<?php else:?>
			$('.group-service').show();
		<?php endif;?>

		$("#select_cylinder_id").attr( "class", 'collapse' );

		$('#cylinder_id').change(function(e){
			var select = $('#cylinder').val();
			if(select == 'custom' ){
				// $('.group-percentage').show();
				$("#select_cylinder_id").attr( "class", 'row' );

			}else{
				// $('.group-percentage').hide();
			
				$("#select_cylinder_id").attr( "class", 'collapse' );
			}
		});

		$('#service-form #select_service').change(function(e){
			var select = $('#select_service').val();
			if(select == '' ){
				$('.group-service').show();
				$('#service').val('<?=isset($service) ? $service : ''?>');
			}else{
				$('.group-service').hide();
				$('#service').val(select);
			}
		});
        $('select#select_service').select2({
            placeholder:"Select Service Name",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
	$(document).ready(function(){
		$('#service-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_service",
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
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>