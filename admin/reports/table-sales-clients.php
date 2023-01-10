<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Customer Name</th>
						<th class="text-center">No. of Products</th>
						<th class="text-center">Amount</th>
						<th class="text-center">Output Vat</th>
						<th class="text-center">Total Sales</th>
					</tr>
				</thead>
				<tbody>
					<?php 
                    $qry = $conn->query("SELECT client_id, client_name, COUNT(DISTINCT product_id) AS products, SUM(price) AS total 
                    FROM (
                        SELECT tp.*, tl.client_id, tl.client_name, tl.tin_number ,pl.name as product,tl.date_created 
                        , tl.amount, (SELECT SUM(p.total_amount) payments
                        FROM payment_list p WHERE p.transaction_id=tp.transaction_id
                        GROUP BY p.transaction_id) as payments
                        FROM `transaction_products` tp 
                        inner join transaction_list tl on tp.transaction_id = tl.id 
                        inner join product_list pl on tp.product_id = pl.id 
                        where tl.status != 3 and date(tl.date_created) <= '{$date}' 
                        HAVING amount=payments
                    ) a
                    GROUP BY client_id
                    order by products desc");
                    while($row = $qry->fetch_assoc()):
                        $row_amount = $row['total'] ;
                        $vat_amount = ($row_amount/1.12) * 0.12;
                        $sales_amount =  $row_amount -  $vat_amount ;
                        $total += $sales_amount;
                        $total_amount += $row_amount;
                        $total_vat += $vat_amount;
						$total_count += $row['products'] ;
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?= $row['client_name'] ?></td>
							<td class="text-center"><?= $row['products'] ?></td>
							<td class="text-center"><?= format_num($row_amount,2) ?></td>
							<td class="text-center"><?= format_num($vat_amount,2) ?></td>
							<td class="text-center"><?= format_num($sales_amount,2) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
                <tfoot>
                    <th class="py-1 text-right" colspan="2">Grand Totals</th>
                    <th class="py-1 text-center"><?= ($total_count) ?></th>
                    <th class="py-1 text-center"><?= format_num($total_amount,2) ?></th>
                    <th class="py-1 text-center"><?= format_num($total_vat,2) ?></th>
                    <th class="py-1 text-center"><?= format_num($total,2) ?></th>
                </tfoot>
			</table>
<noscript id="print-header">
        <div>
            <div class="d-flex w-100">
                <div class="col-2 text-center">
                    <img style="height:auto;width:auto!important;object-fit:cover;object-position:center center" src="<?= validate_image('/dist/img/print-logo.png') ?>" alt="" class="w-100 rounded-circle">
                </div>
                <div class="col-8 text-center">
                    <div style="line-height:1em">
                        <h4 class="text-center mb-0"><img style="height:1in;width:100%!important;object-position:center center" src="<?= validate_image('/dist/img/print-header.png') ?>" alt="" class="w-100"></h4>
                        <h3 class="text-center mb-0"><b>CLIENTS STATEMENT OF ACCOUNT REPORT</b></h3>
                        <div class="text-center"></div>
                        <h4 class="text-center mb-0">as of <b><u><?= date("F d, Y", strtotime($date)) ?></u></b></h4>
                    </div>
                </div>
            </div>
            <div class="mt-5">
        </div>
</noscript>