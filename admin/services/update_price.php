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
    <form action="" id="update_price-form">
        <input type="hidden" name="user_id" value="<?= $_settings->userdata('id') ?>">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" name="old_price" value="<?= isset($price) ? $price : '' ?>">
        <div class="row">
            <div class="form-group mb-3 col-6">
                <label for="price" class="control-label">Price</label>
                <input type="text" name="price" id="price" class="form-control form-control-sm rounded-0 text-left" value="<?php echo isset($price) ? $price : ''; ?>"  required/>
            </div>
            <div class="form-group mb-3 col-6">
                <label for="date_effect" class="control-label">Date/Time</label>
                <input type="datetime-local" name="date_effect" id="date_effect" class="form-control rounded-0" required="required">
            </div>
        </div>
    </form>
    <div class="">
        <bold>Pricing History</bold>
        <hr/>
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
</div>
<script>
	$(document).ready(function(){
		$('#update_price-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=update_price",
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
		})

	})
</script>