<?php 
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT t.*, SUM(p.total_amount) payments FROM `transaction_list` t 
        LEFT JOIN payment_list p ON t.id=p.transaction_id
        where t.id = '{$_GET['id']}'
        group by t.id ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
        $balance = $amount - $payments;
        $date_created = date("m/d/Y", strtotime($date_created));  
        
        if(isset($mechanic_id) && is_numeric($mechanic_id)){
            $mechanic = $conn->query("SELECT concat(firstname,' ', coalesce(concat(middlename,' '),''), lastname) as `name` FROM `mechanic_list` where id = '{$mechanic_id}' ");
            if($mechanic->num_rows > 0){
                $mechanic_name = $mechanic->fetch_array()['name'];
            }
        }
        if(isset($user_id) && is_numeric($user_id)){
            $user = $conn->query("SELECT concat(firstname,' ', lastname) as `name` FROM `users` where id = '{$user_id}' ");
            if($user->num_rows > 0){
                $user_name = $user->fetch_array()['name'];
            }
        }
    }else{
        echo '<script> alert("Unknown Transaction\'s ID."); location.replace("./?page=transactions"); </script>';
    }
}else{
    echo '<script> alert("Transaction\'s ID is required to access the page."); location.replace("./?page=transactions"); </script>';
}
?>
<style>
    .bg-light-blue {
  		background-color: #cae8ff;
	}
    .hidden {
        display: none;
    }
</style>
<div class="content py-3">
    <div class="card card-outline card-blue rounded-0 shadow  m-1">
        <div class="card-header">
            <h4 class="card-title">Transaction Details: <b><?= isset($code) ? $code : "" ?></b></h4>
        </div>
        <div class="card-body">
            <div class="container-fluid" id="printout">
                <div class="row mb-0">
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Invoice Number</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= isset($code) ? $code : '' ?></div>
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Date</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= isset($date_created) ? $date_created : '' ?></div>
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Status</b></div>
                    <div class="col-9 py-1 px-2 border mb-0">
                        <?php 
                        $status = isset($status) ? $status : '';
                        switch($status){
                            case 0:
                                echo '<span class="">Pending</span>';
                                break;
                            case 1:
                                echo '<span class="">On-Progress</span>';
                                break;
                            case 2:
                                echo '<span class="">Done</span>';
                                break;
                            case 3:
                                echo '<span class="">Cancelled</span>';
                                break;
                        }
                        if ($balance ==0)
                        echo ' | Fully Paid';
                        ?>
                    </div>
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Client Name</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= isset($client_name) ? $client_name : '' ?></div>
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Contact #</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= isset($contact) ? $contact : '' ?></div>
                    <!-- <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Email</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= ''// isset($email) ? $email : '' ?></div>
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Address</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= ''// isset($address) ? $address : '' ?></div> -->
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Assigned Machinist</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= isset($mechanic_name) ? $mechanic_name : '' ?></div>
                    <div class="col-3 py-1 px-2 border border-blue bg-light-blue mb-0"><b>Prepared By</b></div>
                    <div class="col-9 py-1 px-2 border mb-0"><?= isset($user_name) ? $user_name : '' ?></div>
                </div>
                <div class="clear-fix mb-2"></div>
                <?php 
                    $ts_qry = $conn->query("SELECT ts.*, s.service as `service` , s.service_sub, s.cylinder FROM `transaction_services` ts inner join `service_list` s on ts.service_id = s.id where ts.`transaction_id` = '{$id}' ");
                    $count = mysqli_num_rows($ts_qry);
                    ?>
                <div class="row <?= $count==0? 'hidden':''?>">     
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <fieldset class="px-2 py-1 border">
                        <legend class="w-auto px-3">Services</legend>
                        <div class="clear-fix mb-2"></div>
                        <table class="table table-striped table-bordered" id="service-list">
                            <colgroup>
                                <col width="30%">
                                <col width="30%">
                                <col width="20%">
                                <col width="20%">
                            </colgroup>
                            <thead>
                                <tr class="bg-light-blue text-center">
                                    <th class="text-center">Service</th>
                                    <th class="text-center">Details</th>
                                    <th class="text-center">Cylinder</th>
                                    <th class="text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $service_amount = 0;
                                $ts_qry = $conn->query("SELECT ts.*, s.service as `service` , s.service_sub, s.cylinder FROM `transaction_services` ts inner join `service_list` s on ts.service_id = s.id where ts.`transaction_id` = '{$id}' ");
                                while($row = $ts_qry->fetch_assoc()):
                                    $service_amount += $row['price'];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $row['service'] ?></td>
                                    <td class="text-center"><?= $row['service_sub'] ?></td>
                                    <td class="text-center"><?= $row['cylinder'] ?></td>
                                    <td class="text-center service_price"><?= format_num($row['price']) ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-gradient-secondary">
                                    <th colspan="3" class="text-center">Total</th>
                                    <th class="text-center" id="service_total"><?= isset($service_amount) ? format_num($service_amount): 0 ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </fieldset>
                </div>
                </div>
                <?php 
                    $tp_qry = $conn->query("SELECT tp.*, p.name as `product` FROM `transaction_products` tp inner join `product_list` p on tp.product_id = p.id where tp.`transaction_id` = '{$id}' ");
                    $count = mysqli_num_rows($tp_qry);
                    ?>
                <div class="row <?= $count==0? 'hidden':''?>">                        
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <fieldset class="px-2 py-1 border">
                    <legend class="w-auto px-3">Products</legend>
                        <div class="clear-fix mb-2"></div>
                        <table class="table table-striped table-bordered" id="product-list">
                            <colgroup>
                                <col width="45%">
                                <col width="15%">
                                <col width="20%">
                                <col width="20%">
                            </colgroup>
                            <thead>
                                <tr class="bg-light-blue">
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                            <?php 
                                $product_total = 0;
                                while($row = $tp_qry->fetch_assoc()):
                                    $product_total += ($row['price'] * $row['qty']);
                            ?>
                                <tr>
                                    <td class="text-center"><?= $row['product'] ?></td>
                                    <td class="text-center"><?= $row['qty'] ?></td>
                                    <td class="text-center product_price"><?= format_num($row['price']) ?></td>
                                    <td class="text-center product_total"><?= format_num($row['price'] * $row['qty']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        
                            <tfoot>
                                <tr class="bg-gradient-secondary">
                                    <th colspan="3" class="text-center">Total</th>
                                    <th class="text-center" id="product_total"><?= isset($product_total) ? format_num($product_total): 0 ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </fieldset>
                </div>
                </div>
                <hr>
                <div class="clear-fix mb-3"></div>
                <div class="d-flex row">
                        <div class="col-3 offset-7"><h4 class="text-black text-right">Total Payable Amount:</h4></div>
                        <div class="col-2"><h4 class="text-black text-right pr-2"> <b id="amount"><?= isset($amount) ? format_num($amount) : "0.00" ?></b></h4></div>
                </div>
                <?php if($payments>0):?>
                <div class="d-flex row">
                        <div class="col-3 offset-7"><h4 class="text-black text-right">Total Payments:</h4></div>
                        <div class="col-2"><h4 class="text-black text-right pr-2"> <b id="payments"><?= isset($payments) ? format_num($payments) : "0.00" ?></b></h4></div>
                </div>
                <div class="d-flex row">
                        <hr class="col-5 offset-7"/>
                </div>
                <div class="d-flex row">
                        <div class="col-3 offset-7"><h4 class="text-black text-right">Balance:</h4></div>
                        <div class="col-2"><h4 class="text-black text-right pr-2"> <b id="balance"><?= isset($balance) ? number_format($balance, 2) : "0.00" ?></b></h4></div>
                </div>
                <?php endif; ?>
            </div>
            <hr>
        </div>
    </div>
</div>
<script>

	$(document).ready(function(){
	})
</script>