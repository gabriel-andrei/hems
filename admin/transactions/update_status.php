<?php 
require_once('../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `transaction_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="update_status-form">
        <input type="hidden" name="user_id" value="<?= $_settings->userdata('id') ?>">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" name="old_status" value="<?= isset($status) ? $status : '' ?>">
        <div class="row">
            <div class="form-group mb-3 col-6">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="form-control rounded-0">
                    <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Pending</option>
                    <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>On-Progress</option>
                    <option value="2" <?= isset($status) && $status == 2 ? "selected" : "" ?>>Done</option>
                    <option value="3" <?= isset($status) && $status == 3 ? "selected" : "" ?>>Cancelled</option>
                </select>
            </div>
            <div class="form-group mb-3 col-6">
                <label for="date_effect" class="control-label">Date/Time</label>
                <input type="datetime-local" name="date_effect" id="date_effect" class="form-control rounded-0" required="required">
            </div>
        </div>
    </form>
    <div class="">
        <bold>Status History</bold>
        <hr/>
                                    <table class="table table-striped table-bordered" id="product-list">
                                        <colgroup>
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="30%">
                                        </colgroup>
                                        <thead>
                                            <tr class="bg-light-blue">
                                                <th class="text-center">Previous</th>
                                                <th class="text-center">Present</th>
                                                <th class="text-center">Date/Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $tp_qry = $conn->query("SELECT l.*, new.status_desc as new_status_desc, old.status_desc as old_status_desc
                                                FROM trans_status_logs l
                                                LEFT JOIN tbl_status new ON l.new_status=new.status_id
                                                LEFT JOIN tbl_status old ON l.from_status=old.status_id
                                                where trans_id = '{$id}' 
                                                ORDER BY l.date_effect DESC");
                                            while($row = $tp_qry->fetch_assoc()):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?=$row['old_status_desc']  ?></td>
                                                <td class="text-center"><?=$row['new_status_desc']  ?></td>
                                                <td class="text-center"><?=$row['date_effect']  ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('#update_status-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=update_status",
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