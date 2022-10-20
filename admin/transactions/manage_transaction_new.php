<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `transaction_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }else{
        echo '<script> alert("Unknown Transaction\'s ID."); location.replace("./?page=transactions"); </script>';
    }
}
?>
<style>
	.bg-light-blue {
  		background-color: #cae8ff;
	}
	.span{
       display: inline-block;
       width: 9em;
       text-align: center;
       white-space: normal;
       word-break: break-word;
    }
</style>
<div class="content py-3">
    <div class="container-fluid">
        <div class="card card-outline card-outline rounded-0 shadow blur">
            <div class="card-header">
                <h5 class="card-title"><?= isset($id) ? "Update ". $code . " Transaction" : "New Transaction" ?></h5>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="transaction-form">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                        <input type="hidden" name="amount" value="<?= isset($amount) ? $amount : '' ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="client_name" class="control-label">Client Full Name</label>
                                    <input type="text" name="client_name" id="client_name" class="form-control form-control-sm rounded-0" value="<?= isset($client_name) ? $client_name : "" ?>" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="contact" class="control-label">Client Contact #</label>
                                    <input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" value="<?= isset($contact) ? $contact : "" ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="email" class="control-label">Client Email</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" value="<?= isset($email) ? $email : "" ?>" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="address" class="control-label">Address</label>
                                    <textarea name="address" id="address" class="form-control form-control-sm rounded-0" required="required"><?= isset($address) ? $address : "" ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="engine_model" class="control-label">Engine Model</label>
                                    <input type="engine_model" name="engine_model" id="engine_model" class="form-control form-control-sm rounded-0" value="<?= isset($engine_model) ? $engine_model : "" ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group mb-3">
                                    <label for="job_order" class="control-label">Job Order #</label>
                                    <input type="job_order" name="job_order" id="job_order" class="form-control form-control-sm rounded-0" required="required"><?= isset($job_order) ? $job_order : "" ?>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <fieldset class="px-2 py-1 border">
                                    <legend class="w-auto px-3">Services</legend>
                                    <div class="row align-items-end">
                                        <div class="col">
                                            <div class="form-group mb-0">
                                                <label for="service_sel" class="control-label">Service</label>
                                                <select name="service_sel" id="service_sel" class="form-control form-control-sm rounded-0" onchange="handleCategoryChange(this)" required>
                                                  <option value="">Select Service</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group mb-0">
                                                <label for="service_sel_sub" class="control-label">Select Service Sub Category</label>
                                                <select name="service_sel_sub" id="service_sel_sub" class="form-control form-control-sm rounded-0" onchange="disableCylinder(this)" disabled="">
                                                  <option value="">Select Service Sub</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mb-0">
                                                <label for="cylinder_sel" class="control-label">Cylinder</label>
                                                <select name="cylinder_sel" id="cylinder_sel" class="form-control form-control-sm rounded-0" onchange="disableAddServiceBtn(this)" disabled="">
                                                <option value="" disabled selected></option>
                                                <option value="1 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>1 Cylinder</option>
                                                <option value="2 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>2 Cylinder</option>
                                                <option value="3 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>3 Cylinder</option>
                                                <option value="4 Small" <?php echo isset($cylinder) ? 'selected' : '' ?>>4 Small</option>
                                                <option value="4 Big" <?php echo isset($cylinder) ? 'selected' : '' ?>>4 Big</option>
                                                <option value="6 Cylinder" <?php echo isset($cylinder) ? 'selected' : '' ?>>6 Cylinder</option>
                                                <option value="Heavy" <?php echo isset($cylinder) ? 'selected' : '' ?>>Heavy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary border btn-sm rounded-pill" type="button" id="add_service" disabled=""><i class=""></i> Add</button>
                                        </div>
                                    </div>
                                    <div class="clear-fix mb-2"></div>
                                    <table class="table table-striped table-bordered" id="service-list">
                                        <colgroup>
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="5%">
                                        </colgroup>
                                        <thead>
                                            <tr class="bg-light-blue">
                                                <th class="text-center">Service</th>
                                                <th class="text-center">Service Sub</th>
                                                <th class="text-center">Cylinder</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $service_amount = 0;
                                            if(isset($id)):
                                            $ts_qry = $conn->query("SELECT ts.*, s.service as `service` FROM `transaction_services` ts inner join `service_list` s on ts.service_id = s.id where ts.`transaction_id` = '{$id}' ");
                                            while($row = $ts_qry->fetch_assoc()):
                                                $service_amount += $row['price'];
                                            ?>
                                            <tr>
                                                <td class="text-center">
                                                    <input type="hidden" name="service_id[]" value="<?= $row['service_id'] ?>">
                                                    <input type="hidden" name="service_price[]" value="<?= $row['price'] ?>">
                                                    <span class="service_name"><?= $row['service'] ?></span>
                                                </td>
                                                <td class="text-center service_sub_name"></td>
                                                <td class="text-center service_cylinder_name"></td>
                                                <td class="text-center service_price"><?= format_num($row['price']) ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-danger btn-sm rounded-0 rem-service" type="button"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gradient-secondary">

                                                <th colspan="3" class="text-center">Total</th>
                                                <th class="text-center" id="service_total"><?= isset($service_amount) ? format_num($service_amount): 0 ?></th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <fieldset class="px-2 py-1 border">
                                    <legend class="w-auto px-3">Products</legend>
                                    <div class="row align-items-end">
                                        <div class="col">
                                            <div class="form-group mb-0">
                                                <label for="engine_model_sel" class="control-label">Select Engine Model</label>
                                                <select name="engine_model_sel" id="engine_model_sel" class="form-control form-control-sm rounded-0" onchange="disableProduct(this)" required>
                                                <option value="" disabled selected></option>
                                                <?php
                                                    $product_qry = $conn->query("SELECT * FROM `product_list` where delete_flag = 0 and `status` = 1 and (coalesce((SELECT SUM(quantity) FROM `inventory_list` where product_id = product_list.id),0) - coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 4),0)) > 0 ".(isset($id) ? " or id = '{$id}' " : "")." order by `engine_model`");
                                                    while($row = $product_qry->fetch_assoc()):
                                                    ?>
                                                    <option value="<?= $row['id'] ?>" data-price = "<?= $row['price'] ?>"><?= $row['engine_model'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mb-0">
                                                <label for="product_sel" class="control-label">Select Product</label>
                                                <select id="product_sel" class="form-control form-control-sm rounded" onchange="disableAddProductBtn(this)" disabled="">
                                                    <option value="" disabled selected></option>
                                                    <?php
                                                    $product_qry = $conn->query("SELECT * FROM `product_list` where delete_flag = 0 and `status` = 1 and (coalesce((SELECT SUM(quantity) FROM `inventory_list` where product_id = product_list.id),0) - coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp inner join `transaction_list` tl on tp.transaction_id = tl.id where tp.product_id = product_list.id and tl.status != 4),0)) > 0 ".(isset($id) ? " or id = '{$id}' " : "")." order by `name`");
                                                    while($row = $product_qry->fetch_assoc()):
                                                    ?>
                                                    <option value="<?= $row['id'] ?>" data-price = "<?= $row['price'] ?>"><?= $row['name'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary border btn-sm rounded-pill" type="button" id="add_product" disabled=""><i class=""></i> Add</button>
                                        </div>
                                    </div>
                                    <div class="clear-fix mb-2"></div>
                                    <table class="table table-striped table-bordered" id="product-list">
                                        <colgroup>
                                            <col width="30%">
                                            <col width="30%">
                                            <col width="15%">
                                            <col width="20%">
                                            <col width="5%">
                                        </colgroup>
                                        <thead>
                                            <tr class="bg-light-blue">
                                                <th class="text-center">Engine Model</th>
                                                <th class="text-center">Product</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center"></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $product_total = 0;
                                            if(isset($id)):
                                            $tp_qry = $conn->query("SELECT tp.*, p.name as `product` FROM `transaction_products` tp inner join `product_list` p on tp.product_id = p.id where tp.`transaction_id` = '{$id}' ");
                                            while($row = $tp_qry->fetch_assoc()):
                                                $product_total += ($row['price'] * $row['qty']);
                                        ?>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="product_id[]" value="<?= $row['product_id'] ?>">
                                                    <input type="hidden" name="product_price[]" value="<?= $row['price'] ?>">
                                                    <span class="product_name"><?= $row['product'] ?></span>
                                                </td>
                                                <td class="text-center"><input type="number" min="1" class="form-control form-control-sm rounded-0 text-center" name="product_qty[]" value="<?= $row['qty'] ?>"></td>
                                                <td class="text-center product_price"><?= format_num($row['price']) ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-danger btn-sm rounded-0 rem-product" type="button"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gradient-secondary">


                                                <th colspan="3" class="text-center">Total</th>


                                                <th class="text-center" id="product_total"><?= isset($product_total) ? format_num($product_total): 0 ?></th>
                                                <th class="text-center"></th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="clear-fix mb-3"></div>
                        <h4 class="text-black text-right">Total Payable Amount: <b id="amount"><?= isset($amount) ? format_num($amount) : "0.00" ?></b></h4>
                        <hr>
                        <?php if($_settings->userdata('type') == 3 && !isset($id)): ?>
                            <input type="hidden" name="mechanic_id" value="<?= $_settings->userdata('id') ?>">
                        <?php endif; ?>
                        <?php if($_settings->userdata('type') != 3): ?>
                        <fieldset>
                            <legend>Assign</legend>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <select name="mechanic_id" id="mechanic_id" class="form-control form-control rounded-0">
                                        <option value="" disabled <?= !isset($mechanic_id) ? "selected" : "" ?>></option>
                                        <option value="" <?= isset($mechanic_id) && in_array($mechanic_id,[null,""]) ? "selected" : "" ?>>Unset</option>
                                        <?php
                                        $mechanic_qry = $conn->query("SELECT *,concat(firstname,' ', coalesce(concat(middlename,' '),''), lastname) as `name` FROM `mechanic_list` where delete_flag = 0 and `status` = 1 ".(isset($mechanic_id) && !is_null($mechanic_id) ? " or id = '{$mechanic_id}' " : '')." order by `name` asc");
                                        while($row = $mechanic_qry->fetch_array()):
                                        ?>
                                        <option value="<?= $row['id'] ?>" <?= isset($mechanic_id) && $mechanic_id == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <div class="card-footer py-2 text-right">
                <button class="btn btn-primary border btn-md rounded-pill" form="transaction-form">Save Transaction</button>
                <?php if(!isset($id)): ?>
                <a class="btn btn-default border btn-md rounded-pill" href="./?page=transactions">Cancel</a>
                <?php else: ?>
                <a class="btn btn-default border btn-md rounded-pill" href="./?page=transactions/view_details&id=<?= $id ?>">Cancel</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<noscript id="service-clone">
    <tr>
        <td>
            <input type="hidden" name="service_id[]" value="">
            <input type="hidden" name="service_price[]" value="0">
            <span class="service_name"></span>
        </td>
        <td class="text-center service_sub_name"></td>
        <td class="text-center service_cylinder_name"></td>
        <td class="text-center service_price"></td>
        <td class="text-center">
            <button class="btn btn-outline-danger btn-sm rounded-0 rem-service" type="button"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
</noscript>
<noscript id="product-clone">
    <tr>
        <td class="text-center engineModelName"></td>
        <td>
            <input type="hidden" name="product_id[]" value="">
            <input type="hidden" name="product_price[]" value="0">
            <span class="product_name"></span>
        </td>
        <td class=""><input type="number" min="1" class="form-control form-control-sm rounded-0 text-center" name="product_qty[]" value="1"></td>
        <td class="text-center product_price"></td>
        <td class="text-center">
            <button class="btn btn-outline-danger btn-sm rounded-0 rem-product" type="button"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
</noscript>
<script type="text/javascript">
    const category = document.getElementById("service_sel");
    const subCategory = document.getElementById("service_sel_sub");

    const categories = ([
        "Connecting Rod",
        "Crankshaft",
        "Cylinder Head",
        "Engine Block"
    ])

    const subCategories = ([
        {
            category: "Connecting Rod",
            subCategory: [
              "Alignmentx",
              "Piston Pin Bushing Replace",
              "Sleeving of Piston Pin Bushing Housing",
              "Resizing",
              "Build up of Bearing Housing",
              "Fitting of Piston",
              "Conversion",
              "Press of Piston",
              "Alignmentx",
              "Piston Pin Bushing Replace",
              "Sleeving of Piston Pin Bushing Housing",
              "Resizing",
              "Build up of Bearing Housing",
              "Fitting of Piston",
              "Conversion",
              "Press of Piston",
              "Alignmentx",
              "Piston Pin Bushing Replace",
              "Sleeving of Piston Pin Bushing Housing",
              "Resizing",
              "Build up of Bearing Housing",
              "Fitting of Piston",
              "Conversion",
              "Press of Piston",
              "Alignmentx",
              "Piston Pin Bushing Replace",
              "Sleeving of Piston Pin Bushing Housing",
              "Resizing",
              "Build up of Bearing Housing",
              "Fitting of Piston",
              "Conversion",
              "Press of Piston",
              "Alignmentx",
              "Piston Pin Bushing Replace",
              "Sleeving of Piston Pin Bushing Housing",
              "Resizing",
              "Build up of Bearing Housing",
              "Fitting of Piston",
              "Conversion",
              "Press of Piston",
              "Alignmentx",
              "Piston Pin Bushing Replace",
              "Sleeving of Piston Pin Bushing Housing",
              "Resizing",
              "Build up of Bearing Housing",
              "Fitting of Piston",
              "Conversion",
              "Press of Piston",
              "Alignmentx",
              "Piston Pin Bushing Replace",
              "Sleeving of Piston Pin Bushing Housing",
              "Resizing",
              "Build up of Bearing Housing",
              "Fitting of Piston",
              "Conversion",
              "Press of Piston",
              "Sample"
            ]
        },
        {
            category: "Crankshaft",
            subCategory: [
              "Polished",
              "Regrind of Main and Con journal",
              "Trust side machining",
              "Build up of Thrust side",
              "Oil Seal Build Up",
              "Fitting of Main and Con",
              "Alignment",
              "Rebabbit of Thrust Washer",
              "Balancer Bushing Replace",
              "Polished",
              "Regrind of Main and Con journal",
              "Trust side machining",
              "Build up of Thrust side",
              "Oil Seal Build Up",
              "Fitting of Main and Con",
              "Alignment",
              "Rebabbit of Thrust Washer",
              "Balancer Bushing Replace",
              "Polished",
              "Regrind of Main and Con journal",
              "Trust side machining",
              "Build up of Thrust side",
              "Oil Seal Build Up",
              "Fitting of Main and Con",
              "Alignment",
              "Rebabbit of Thrust Washer",
              "Polished",
              "Regrind of Main and Con journal",
              "Trust side machining",
              "Build up of Thrust side",
              "Oil Seal Build Up",
              "Fitting of Main and Con",
              "Alignment",
              "Rebabbit of Thrust Washer",
              "Balancer Bushing Replace ",
              "Polished",
              "Regrind of Main and Con journal",
              "Trust side machining",
              "Build up of Thrust side",
              "Oil Seal Build Up",
              "Fitting of Main and Con",
              "Alignment",
              "Rebabbit of Thrust Washer",
              "Balancer Bushing Replace",
              "Polished",
              "Regrind of Main and Con journal",
              "Trust side machining",
              "Build up of Thrust side",
              "Oil Seal Build Up",
              "Fitting of Main and Con",
              "Alignment",
              "Rebabbit of Thrust Washer",
              "Balancer Bushing Replace",
              "Polished",
              "Regrind of Main and Con journal",
              "Trust side machining",
              "Build up of Thrust side",
              "Oil Seal Build Up",
              "Fitting of Main and Con",
              "Alignment",
              "Rebabbit of Thrust Washer",
              "Balancer Bushing Replace"
            ]
        },
        {
            category: "Cylinder Head",
            subCategory: [
              "Valve seat ring insert",
              "Valve Seat Ring Insert",
              "Valve Seat Replace/ Lapping",
              "Valve Guide Replace",
              "Resurface",
              "Valve Reface",
              "Cold Welding",
              "Hydrotest",
              "Tappet Clearance Setting and Assembling",
              "Line Boring of Camshaft Housing",
              "Valve Seat Ring Insert",
              "Valve Seat Replace/ Lapping",
              "Valve Guide Replace",
              "Resurface",
              "Valve Reface",
              "Cold Welding",
              "Hydrotest",
              "Tappet Clearance Setting and Assembling",
              "Line Boring of Camshaft Housing",
              "Valve Seat Ring Insert",
              "Valve Seat Replace/ Lapping ",
              "Valve Guide Replace",
              "Resurface",
              "Valve Reface",
              "Cold Welding ",
              "Hydrotest",
              "Tappet Clearance Setting and Assembling",
              "Line Boring of Camshaft Housing",
              "Valve Seat Ring Insert",
              "Valve Seat Replace/ Lapping",
              "Valve Guide Replace",
              "Resurface",
              "Valve Reface",
              "Cold Welding",
              "Hydrotest",
              "Tappet Clearance Setting and Assembling",
              "Line Boring of Camshaft Housing",
              "Valve Seat Ring Insert",
              "Valve Seat Replace/ Lapping",
              "Valve Guide Replace",
              "Resurface",
              "Valve Reface",
              "Cold Welding",
              "Hydrotest",
              "Tappet Clearance Setting and Assembling",
              "Line Boring of Camshaft Housing",
              "Valve Seat Ring Insert",
              "Valve Seat Replace/ Lapping",
              "Valve Guide Replace ",
              "Resurface",
              "Valve Reface",
              "Cold Welding",
              "Hydrotest",
              "Tappet Clearance Setting and Assembling",
              "Line Boring of Camshaft Housing",
              "Valve Seat Ring Insert",
              "Valve Seat Replace/ Lapping",
              "Valve Guide Replace",
              "Resurface",
              "Valve Reface",
              "Cold Welding",
              "Hydrotest",
              "Tappet Clearance Setting and Assembling",
              "Line Boring of Camshaft Housing"
            ]
        },
        {
            category: "Engine Block",
            subCategory: [
              "Rebore",
              "Rebore",
              "Sleeve Rebore",
              "Counterbore",
              "Liner Replace",
              "Block Reface",
              "Camshaft Bushing Replace",
              "Line Boring of Main Housing",
              "Build up of Main Saddle",
              "Build of Trust Side",
              "Washing",
              "Rebore",
              "Sleeve Rebore",
              "Counterbore",
              "Liner Replace",
              "Block Reface",
              "Camshaft Bushing Replace",
              "Line Boring of Main Housing",
              "Build up of Main Saddle",
              "Build of Trust Side",
              "Washing",
              "Rebore",
              "Sleeve Rebore",
              "Counterbore",
              "Liner Replace",
              "Block Reface",
              "Camshaft Bushing Replace",
              "Build up of Main Saddle",
              "Build of Trust Side",
              "Washing",
              "Rebore",
              "Sleeve Rebore",
              "Counterbore",
              "Liner Replace",
              "Block Reface",
              "Camshaft Bushing Replace",
              "Line Boring of Main Housing",
              "Build up of Main Saddle",
              "Build of Trust Side",
              "Washing",
              "Rebore",
              "Sleeve Rebore",
              "Counterbore",
              "Liner Replace",
              "Block Reface",
              "Camshaft Bushing Replace",
              "Line Boring of Main Housing",
              "Build up of Main Saddle",
              "Build of Trust Side",
              "Washing",
              "Rebore",
              "Sleeve Rebore",
              "Counterbore",
              "Liner Replace",
              "Block Reface",
              "Camshaft Bushing Replace",
              "Line Boring of Main Housing",
              "Build up of Main Saddle",
              "Build of Trust Side",
              "Washing",
              "Rebore",
              "Sleeve Rebore",
              "Counterbore",
              "Liner Replace",
              "Block Reface",
              "Camshaft Bushing Replace",
              "Line Boring of Main Housing",
              "Build up of Main Saddle",
              "Build of Trust Side",
              "Washing"
            ]
        }
    ])

    categories.map((x) => {
        var option = document.createElement('option');
        option.value = x;
        option.innerHTML = x;
        category.append(option);
    });

    async function handleCategoryChange(e) {
        document.getElementById('service_sel_sub').disabled = false;
        subCategory.innerHTML = "";
        const data = subCategories.filter((x) => x.category === e.value);
        data[0].subCategory.map((x) => {
            var option = document.createElement('option');
            option.value = x;
            option.innerHTML = x;
            subCategory.append(option);
        })
    }

</script>
<script>
    function getServiceText(getSrvc){
            var selectService = document.getElementById('service_sel');
            var serviceText = selectService.options[selectService.selectedIndex].text;
    }
    function disableCylinder(dsCylinder){
            document.getElementById('cylinder_sel').disabled = false
    }
    function disableProduct(dsProduct){
            document.getElementById('product_sel').disabled = false
            var service = $('#service_sel').text()
    }
    function disableAddServiceBtn(dsAddService){
            document.getElementById('add_service').disabled = false

    }
    function disableAddProductBtn(dsAddProduct){
            document.getElementById('add_product').disabled = false
    }
    function calc_total_amount(){
        var total = 0;
        $('#service-list tbody tr').each(function(){
            total += parseFloat($(this).find('[name="service_price[]"]').val())
        })
        $('#product-list tbody tr').each(function(){
            var qty = $(this).find('[name="product_qty[]"]').val()
            qty = qty > 0 ? qty : 0
            total += (parseFloat($(this).find('[name="product_price[]"]').val()) * parseFloat(qty))
        })
        $('[name="amount"]').val(parseFloat(total))
        $('#amount').text(parseFloat(total).toLocaleString('en-US'))
    }
    function calc_service(){
        var total = 0;
        $('#service-list tbody tr').each(function(){
            total += parseFloat($(this).find('[name="service_price[]"]').val())
        })
        $('#service_total').text(parseFloat(total).toLocaleString('en-US'))
        calc_total_amount()
    }
    function calc_product(){
        var total = 0;

        $('#product-list tbody tr').each(function(){
            var qty = $(this).find('[name="product_qty[]"]').val()
            qty = qty > 0 ? qty : 0
            total += (parseFloat($(this).find('[name="product_price[]"]').val()) * parseFloat(qty))
        })
        $('#product_total').text(parseFloat(total).toLocaleString('en-US'))
        calc_total_amount()
    }
    $(function(){
        $('select#mechanic_id').select2({
            placeholder:"Select Machinist",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#engine_model_sel').select2({
            placeholder:"Select Engine Model",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#service_sel').select2({
            placeholder:"Select Service",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#service_sel_sub').select2({
            placeholder:"Select Service Sub",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#cylinder_sel').select2({
            placeholder:"Select Cylinder",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#product_sel').select2({
            placeholder:"Select Product",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#service-list tbody tr').find('.rem-service').click(function(){
            var tr = $(this).closest('tr')
            if(confirm("Are you sure to remove "+(tr.find('.service_name').text())+" from service list?") === true){
                tr.remove()
                calc_service()
            }
        })
        $('#product-list tbody tr').find('.rem-product').click(function(){
            var tr = $(this).closest('tr')
            if(confirm("Are you sure to remove "+(tr.find('.product_name').text())+" from product list?") === true){
                tr.remove()
                calc_product()
            }
        })
        $('#product-list tbody tr').find('[name="product_qty[]"]').on('input change', function(){
            var tr = $(this).closest('tr')
            var qty = $(this).val()
            qty = qty > 0 ? qty : 0
            var total = parseFloat(qty) * parseFloat(price)
            tr.find('.product_total').text(parseFloat(total).toLocaleString())
            calc_product()

        })
        $('#add_service').click(function(){
            if($('#service_sel').val() == null || $('#service_sel_sub').val() == null || $('#cylinder_sel').val() == null)
            return false;
            var id = $('#service_sel').val()
            var id2 = $('#service_sel_sub').val()
            var id3 = $('#cylinder_sel').val()

            if($('#service-list tbody tr input[name="service_id[]"][value="'+id+'"]').length > 0){
                alert("Service already on the list.")
                return false;
            }
            var name = $('#service_sel option[value="'+id+'"]').text()
            var serviceSub = $('#service_sel_sub option[value="'+id2+'"]').text()
            var cylinderSel = $('#cylinder_sel option[value="'+id3+'"]').text()
            var price = $('#service_sel option[value="'+id+'"]').attr('data-price')
            var tr = $($('noscript#service-clone').html()).clone()
            tr.find('input[name="service_id[]"]').val(id)
            tr.find('input[name="service_price[]"]').val(price)
            tr.find('.service_name').text(name)
            tr.find('.service_sub_name').text(serviceSub)
            tr.find('.service_cylinder_name').text(cylinderSel)
            tr.find('.service_price').text(parseFloat(price).toLocaleString())
            $('#service-list tbody').append(tr)
            calc_service()
            tr.find('.rem-service').click(function(){
                if(confirm("Are you sure to remove "+name+" | "+serviceSub+" | "+cylinderSel+" from service list?") === true){
                    tr.remove()
                    calc_service()
                }
            })

            $('#service_sel').val('').trigger("change")
            $('#service_sel_sub').val('').trigger("change")
            $('#cylinder_sel').val('').trigger("change")
            document.getElementById('cylinder_sel').disabled = true
            document.getElementById('service_sel_sub').disabled = true
            document.getElementById('add_service').disabled = true
        })
        $('#add_product').click(function(){
            if($('#product_sel').val() == null)
            return false;
            var id = $('#product_sel').val()
            var id2 = $('#engine_model_sel').val()

            if($('#product-list tbody tr input[name="product_id[]"][value="'+id+'"]').length > 0){
                alert("Product already on the list.")
                return false;
            }
            var name = $('#product_sel option[value="'+id+'"]').text()
            var engineModelName = $('#engine_model_sel option[value="'+id2+'"]').text()

            var price = $('#product_sel option[value="'+id+'"]').attr('data-price')
            var tr = $($('noscript#product-clone').html()).clone()
            tr.find('input[name="product_id[]"]').val(id)
            tr.find('input[name="product_price[]"]').val(price)
            tr.find('.engineModelName').text(engineModelName)
            tr.find('.product_name').text(name)

            tr.find('.product_price').text(parseFloat(price).toLocaleString())
            tr.find('.product_total').text(parseFloat(price).toLocaleString())
            $('#product-list tbody').append(tr)
            calc_product()
            tr.find('.rem-product').click(function(){
                if(confirm("Are you sure to remove "+name+" from product list?") === true){
                    tr.remove()
                    calc_product()
                }
            })
            tr.find('[name="product_qty[]"]').on('input change', function(){
                var qty = $(this).val()
                qty = qty > 0 ? qty : 0
                var total = parseFloat(qty) * parseFloat(price)
                tr.find('.product_total').text(parseFloat(total).toLocaleString())
                calc_product()

            })
            $('#product_sel').val('').trigger("change")
            $('#engine_model_sel').val('').trigger("change")

            document.getElementById('product_sel').disabled = true
        })
        $('#product-list, #service-list').find('td, th').addClass('px-2 py-1 align-middle')
        $('#transaction-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_transaction",
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
						location.href = "./?page=transactions/view_details&id="+resp.tid
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
