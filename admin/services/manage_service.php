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
			<label for="service" class="control-label">Service</label>
			<select name="service" id="service" class="form-control form-control-sm rounded-0" required>
			<option value="Cylinder Head" <?php echo isset($service) ? 'selected' : '' ?>>Cylinder Head</option>
			<option value="Engine Block" <?php echo isset($service) ? 'selected' : '' ?>>Engine Block</option>
			<option value="Crankshaft" <?php echo isset($service) ? 'selected' : '' ?>>Crankshaft</option>
			<option value="Connecting Rod" <?php echo isset($service) ? 'selected' : '' ?>>Connecting Rod</option>
			</select>
		</div>
		<div class="form-group">
			<label for="service_sub" class="control-label">Service Sub Category</label>
			<textarea type="text" name="service_sub" id="service_sub" class="form-control form-control-sm rounded-0" required><?php echo isset($service_sub) ? $service_sub : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="cylinder" class="control-label">Cylinder</label>
			<select name="cylinder" id="cylinder" class="form-control form-control-sm rounded-0" required>
			<option value="1 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>1 Cylinder</option>
			<option value="2 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>2 Cylinder</option>
			<option value="3 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>3 Cylinder</option>
			<option value="4 Small" <?php echo isset($cylinder) ? 'selected' : '' ?>>4 Small</option>
			<option value="4 Big" <?php echo isset($cylinder) ? 'selected' : '' ?>>4 Big</option>
			<option value="6 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>6 Cylinder</option>
			<option value="Heavy" <?php echo isset($cylinder) ? 'selected' : '' ?>>Heavy</option>
			</select>
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea type="text" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Price</label>
			<input type="text" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Available</option>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Not Available</option>
			</select>
		</div>
	</form>
</div>
<script>
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