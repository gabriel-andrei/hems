<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php $date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d"); ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Daily Sales Report</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid mb-3">
            <fieldset class="px-2 py-1 border">
                <div class="container-fluid">
                    <form action="" id="filter-form">
                        <div class="row align-items-end">
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="filter" class="control-label">Filter by</label>
                                    <select name="filtertype" id="filtertype" class="form-control form-control-sm rounded-0" required>
                                        <option value="" disabled selected></option>
                                        <option value="daily" <?php echo isset($filtertype) ? 'selected' : '' ?>>Daily</option>
                                        <option value="weekly" <?php echo isset($filtertype) ? 'selected' : '' ?>>Weekly</option>
                                        <option value="monthly" <?php echo isset($filtertype) ? 'selected' : '' ?>>Monthly</option>
                                        <option value="yearly" <?php echo isset($filtertype) ? 'selected' : '' ?>>Yearly</option>
                                        <option value="best_selling" <?php echo isset($filtertype) ? 'selected' : '' ?>>Best Selling</option>
                                        </select>                                
                                    </div>
                                </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="date" class="control-label">Choose Date</label>
                                    <input type="date" disabled="disabled" class="form-control form-control-sm rounded-0" name="date" id="date" value="<?= date("Y-m-d", strtotime($date)) ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-primary border btn-sm rounded-pill"><i class="fa fa-filter"></i> Filter</button>
                                    <button class="btn btn-default border btn-sm rounded-pill" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
		</div>
        <div class="container-fluid" id="printout">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">OR#/JO#</th>
						<th class="text-center">Tin # of Customer</th>
						<th class="text-center">Customer Name</th>
						<th class="text-center">Particulars</th>
						<th class="text-center">Amount</th>
						<th class="text-center">Output Vat</th>
						<th class="text-center">Total Sales</th>
					</tr>
				</thead>
				<tbody>
					<?php 
                    $total=$total_amount=$total_vat = 0;
					$i = 1;
                    $qry = $conn->query("SELECT tp.*
                        , tl.code, tl.client_name, tl.tin_number ,pl.name as product,tl.date_created 
                        , tl.amount, (SELECT SUM(p.total_amount) payments
									FROM payment_list p WHERE p.transaction_id=tp.transaction_id
									GROUP BY p.transaction_id) as payments
                        FROM `transaction_products` tp 
                        inner join transaction_list tl on tp.transaction_id = tl.id 
                        inner join product_list pl on tp.product_id = pl.id 
                        where tl.status != 3 and date(tl.date_created) = '{$date}' 
                        HAVING amount=payments
                        order by unix_timestamp(tl.date_updated) asc ");
                    while($row = $qry->fetch_assoc()):
                        $row_amount = $row['price'] * $row['qty'];
                        $vat_amount = ($row_amount/1.12) * 0.12;
                        $sales_amount =  $row_amount -  $vat_amount ;
                        $total += $sales_amount;
                        $total_amount += $row_amount;
                        $total_vat += $vat_amount;
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?= $row['code'] ?></td>
							<td class="text-center"><?= $row['tin_number'] ?></td>
							<td class="text-center"><?= $row['client_name'] ?></td>
							<td class="text-center"><?= $row['product'] ?></td>
							<td class="text-center"><?= format_num($row_amount,2) ?></td>
							<td class="text-center"><?= format_num($vat_amount,2) ?></td>
							<td class="text-center"><?= format_num($sales_amount,2) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
                <tfoot>
                    <th class="py-1 text-right" colspan="5">Grand Totals</th>
                    <th class="py-1 text-center"><?= format_num($total_amount,2) ?></th>
                    <th class="py-1 text-center"><?= format_num($total_vat,2) ?></th>
                    <th class="py-1 text-center"><?= format_num($total,2) ?></th>
                </tfoot>
			</table>
		</div>
	</div>
</div>
<noscript id="print-header">
        <div>
            <div class="d-flex w-100">
                <div class="col-2 text-center">
                    <img style="height:auto;width:auto!important;object-fit:cover;object-position:center center" src="<?= validate_image('/dist/img/print-logo.png') ?>" alt="" class="w-100 rounded-circle">
                </div>
                <div class="col-8 text-center">
                    <div style="line-height:1em">
                        <h4 class="text-center mb-0"><img style="height:1in;width:100%!important;object-position:center center" src="<?= validate_image('/dist/img/print-header.png') ?>" alt="" class="w-100"></h4>
                        <h3 class="text-center mb-0"><b>DAILY SALES REPORT</b></h3>
                        <div class="text-center"></div>
                        <h4 class="text-center mb-0">for <b><u><?= date("F d, Y", strtotime($date)) ?></u></b></h4>
                    </div>
                </div>
            </div>
            <div class="mt-5">
        </div>
</noscript>
<noscript id="print-footer">
    <div>
        <div class="container-fluid mt-5" >
            <div class="row">
                <div class="col-2 text-center">
                    <b>Prepared by:</b>
                </div>
                <div class="col-4 text-center">
                    <b>_________________________________________</b>
                    <div class="">
                        <b class="w-100">Secretary In-Charge</b>
                    </div>
                </div>
            </div>
		</div>
    </div>
</noscript>
<script>
	$(document).ready(function(){
		$('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=reports/daily_sales_report&"+$(this).serialize()
        })
        $('#filtertype').select2({
            placeholder:"Choose Filter",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#print').click(function(){
            var h = $('head').clone()
            var ph = $($('noscript#print-header').html()).clone()
            var pf = $($('noscript#print-footer').html()).clone()
            var p = $('#printout').clone()
            h.find('title').text('Daily Sales Report - Print View')

            start_loader()
            var nw = window.open("", "_blank", "width="+($(window).width() * .8)+", height="+($(window).height() * .8)+", left="+($(window).width() * .1)+", top="+($(window).height() * .1))
                     nw.document.querySelector('head').innerHTML = h.html()
                     nw.document.querySelector('body').innerHTML = ph.html()
                     nw.document.querySelector('body').innerHTML += p[0].outerHTML
                     nw.document.querySelector('body').innerHTML += pf.html()
                     nw.document.close()
            setTimeout(() => {
                         nw.print()
                         setTimeout(() => {
                             nw.close()
                             end_loader()
                         }, 300);
                     }, 300);
        })
	})
	
</script>