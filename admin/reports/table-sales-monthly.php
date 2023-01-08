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
						<th class="text-center">Date</th>
						<th class="text-center">No. of Products Sold</th>
						<th class="text-center">Amount</th>
						<th class="text-center">Output Vat</th>
						<th class="text-center">Total Sales</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					$sql = "SELECT report_date, SUM(qty) as products, SUM(price) as total FROM (
								SELECT ts.*, DATE(tl.date_created) report_date
									, tl.amount, (SELECT SUM(p.total_amount) payments
										FROM payment_list p WHERE p.transaction_id=ts.transaction_id
										GROUP BY p.transaction_id) as payments
								FROM `transaction_products` ts 
								inner join transaction_list tl on ts.transaction_id = tl.id 
								where tl.status != 3 and MONTH(tl.date_created) = MONTH('{$date}') AND  YEAR(tl.date_created) = YEAR('{$date}')
								HAVING amount=payments
								) a
							GROUP BY report_date
							order by report_date asc ";
					$qry = $conn->query($sql);
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
							<td class="text-center"><?= date('M d, Y', strtotime($row['report_date'])) ?></td>
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
                        <h3 class="text-center mb-0"><b>MONTHLY SERVICES INCOME REPORT</b></h3>
                        <div class="text-center"></div>
                        <h4 class="text-center mb-0">for the month of <b><u><?= date("F, Y",strtotime($date)) ?></u></b></h4>
                    </div>
                </div>
            </div>
            <div class="mt-5">
        </div>
</noscript>
