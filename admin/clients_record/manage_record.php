<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `clients_record` where id = '{$_GET['id']}' ");
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
	<form action="" id="client-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="client_name" class="control-label">Name</label><br>
				<input type="text" name="client_name" id="client_name" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($client_name) ? $client_name : ''; ?>" <?=(isset($_GET['update'])?'required':'readonly')?> />

		</div>	
		<div class="form-group">
			<label for="email" class="control-label">Email</label><br>
				<input type="text" name="email" id="email" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($email) ? $email : ''; ?>" <?=(isset($_GET['update'])?'required':'readonly')?> />
		</div>	
		<div class="form-group">
			<label for="contact" class="control-label">Contact Number</label><br>
				<input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($contact) ? $contact : ''; ?>" <?=(isset($_GET['update'])?'required':'readonly')?> />
		</div>	
		<div class="form-group">
			<label for="tin_number" class="control-label">Tin Number</label><br>
				<input type="text" name="tin_number" id="tin_number" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($tin_number) ? $tin_number : ''; ?>" <?=(isset($_GET['update'])?'required':'readonly')?> />
		</div>	
		<div class="form-group">
			<label for="address" class="control-label">Address</label><br>
				<input type="text" name="address" id="contact" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($address) ? $address : ''; ?>" <?=(isset($_GET['update'])?'required':'readonly')?> />
		</div>	
		<div class="form-group">
			<label for="engine_model" class="control-label">Engine Model</label>
			<input type="text" name="engine_model" id="engine_model" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($engine_model) ? $engine_model : ''; ?>" <?=(isset($_GET['update'])?'required':'readonly')?> />
		</div>
		
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#client-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_client",
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