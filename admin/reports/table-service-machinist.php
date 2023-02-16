<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Machinist Name</th>
						<th class="text-center">No. of Transactions</th>
						<th class="text-center">Total Sales</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$sql = "SELECT mechanic_id, NAME,  COUNT(*) AS services, SUM(price) AS total 
                    FROM ( SELECT ts.*, tl.mechanic_id, CONCAT(m.firstname, ' ', LEFT(m.middlename,1), ', ', m.lastname) name,sl.service as `service`,tl.date_created , tl.amount
                    , (SELECT SUM(p.total_amount) payments FROM payment_list p WHERE p.transaction_id=ts.transaction_id GROUP BY p.transaction_id) as payments 
                    FROM `transaction_services` ts 
                    inner join transaction_list tl on ts.transaction_id = tl.id 
                    inner join service_list sl on ts.service_id = sl.id 
                    INNER JOIN mechanic_list m ON m.id=tl.mechanic_id
                            where tl.status != 3 and 
                        ";
                    if($filterperiod == 'daily'){
                        $sql .= "date(tl.date_created) = '{$date}' ";
                    }else if($filterperiod == 'weekly'){
                        $sql .= "date(tl.date_created) BETWEEN '{$date}' AND DATE_ADD('{$date}', INTERVAL 6 DAY) ";
                    }else if($filterperiod == 'monthly'){
                        $sql .= "MONTH(tl.date_created) = MONTH('{$date}') AND  YEAR(tl.date_created) = YEAR('{$date}')";
                    }else if($filterperiod == 'yearly'){
                        $sql .= "YEAR(tl.date_created) = YEAR('{$date}')";
                    }
                    $sql .= "
                            HAVING amount=payments
                        ) a
                        GROUP BY mechanic_id
                        order by services desc ";
                    
                    $qry = $conn->query($sql);
                    while($row = $qry->fetch_assoc()):
                        $row_amount = $row['total'] ;
                        $total_amount += $row_amount;
						$total_count += $row['services'] ;
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?= $row['NAME'] ?></td>
							<td class="text-center"><?= $row['services'] ?></td>
							<td class="text-center"><?= format_num($row_amount,2) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
                <tfoot>
                    <th class="py-1 text-right" colspan="2">Grand Totals</th>
                    <th class="py-1 text-center"><?= ($total_count) ?></th>
                    <th class="py-1 text-center"><?= format_num($total_amount,2) ?></th>
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