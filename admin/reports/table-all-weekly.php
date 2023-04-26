<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<!-- <col width="15%"> -->
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="10%">

				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">OR#</th>
						<!-- <th class="text-center">Tin # of Customer</th> -->
						<th class="text-center">Customer Name</th>
						<th class="text-center">Total Sales And Services</th>
						<th class="text-center">Output Vat</th>
						<th class="text-center">Total Sales</th>
					</tr>
				</thead>
				<tbody>
					<?php 
                    // $qry = $conn->query("SELECT -- tp.*, 
					// 	tp.price, tp.qty,
					// 	tl.code, tl.client_name, tl.tin_number ,pl.name as product,tl.date_created 
                    //     , tl.amount, (SELECT SUM(p.total_amount) payments
					// 				FROM payment_list p WHERE p.transaction_id=tp.transaction_id
					// 				GROUP BY p.transaction_id) as payments
                    //     FROM `transaction_products` tp 
                    //     inner join transaction_list tl on tp.transaction_id = tl.id 
                    //     inner join product_list pl on tp.product_id = pl.id 
                    //     where tl.status != 3 and date(tl.date_created) = '{$date}' 
                    //     HAVING amount=payments
					// 	UNION
					// 	SELECT -- ts.*, 
					// 	ts.price, 1 qty,
					// 	tl.code, tl.client_name, tl.tin_number,sl.service as `service`,tl.date_created 
                    //             , tl.amount, (SELECT SUM(p.total_amount) payments
                    //                 FROM payment_list p WHERE p.transaction_id=ts.transaction_id
                    //                 GROUP BY p.transaction_id) as payments
                    //         FROM `transaction_services` ts 
                    //         inner join transaction_list tl on ts.transaction_id = tl.id 
                    //         inner join service_list sl on ts.service_id = sl.id 
                    //         where tl.status != 3 and date(tl.date_created) = '{$date}' 
                    //         HAVING amount=payments
 					// 	order BY unix_timestamp(date_created), code asc 
					// 	");
					$sql = "SELECT tl.code, tl.client_name, tl.tin_number,tl.date_created 
					, tl.amount, (SELECT SUM(p.total_amount) payments
								FROM payment_list p WHERE p.transaction_id=tl.id
								GROUP BY p.transaction_id) as payments
					FROM  transaction_list tl 
					where tl.status != 3 and date(tl.date_created) BETWEEN '{$date}' AND DATE_ADD('{$date}', INTERVAL 6 DAY)
					HAVING amount=payments
					 order BY unix_timestamp(date_created), code asc
					";

					$qry = $conn->query($sql);

                    while($row = $qry->fetch_assoc()):
                        $row_amount = $row['amount'];
                        $vat_amount = ($row_amount/1.12) * 0.12;
                        $sales_amount =  $row_amount -  $vat_amount ;
                        $total += $sales_amount;
                        $total_amount += $row_amount;
                        $total_vat += $vat_amount;
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?=$row['code'] ?></td>
							<td class="text-center"><?= $row['client_name'] ?></td>
							<td class="text-center"><?= format_num($row_amount,2) ?></td>
							<td class="text-center"><?= format_num($vat_amount,2) ?></td>
							<td class="text-center"><?= format_num($sales_amount,2) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
                <tfoot>
                    <th class="py-1 text-right" colspan="3">Grand Totals</th>
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
                        <h3 class="text-center mb-0"><b>WEEKLY SALES REPORT</b></h3>
                        <div class="text-center"></div>
                        <h4 class="text-center mb-0">for <b><u><?= date("F d, Y", strtotime($date)) ?></u></b></h4>
                    </div>
                </div>
            </div>
            <div class="mt-5">
        </div>
</noscript>