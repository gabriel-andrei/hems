<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Date</th>
						<th class="text-center">Done</th>
						<th class="text-center">Pending</th>
						<th class="text-center">On-Progress</th>
						<th class="text-center">Cancelled</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$sql = "SELECT tl.code, tl.client_name, tl.tin_number,tl.date_created, tl.status
					, tl.amount, (SELECT SUM(p.total_amount) payments
								FROM payment_list p WHERE p.transaction_id=tl.id
								GROUP BY p.transaction_id) as payments
					FROM  transaction_list tl 
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
					GROUP BY tl.id
					HAVING amount=payments
					";

					$sql = "SELECT DATE(date_created) 'date'
					, SUM(IF(status=0, 1, 0)) 'pending'
					, SUM(IF(status=1, 1, 0)) 'progress'
					, SUM(IF(status=2, 1, 0)) 'done'
					, SUM(IF(status=3, 1, 0)) 'cancelled'
					FROM ($sql) a
					GROUP BY `date`
					 order BY 1 asc 
					";

					$qry = $conn->query($sql);

					$total_done =0;
					$total_pending =0;
					$total_progress =0;
					$total_cancelled =0;
                    while($row = $qry->fetch_assoc()):
                        $pending = $row['pending'];
                        $progress = $row['progress'];
                        $done = $row['done'];
                        $cancelled = $row['cancelled'];
                        $subtotal = $pending + $progress +$done +$cancelled;
                        $total += $subtotal;
                        $total_done += $done;
                        $total_pending += $pending;
                        $total_progress += $progress;
                        $total_cancelled += $cancelled;
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?=$row['date'] ?></td>
							<td class="text-center"><?= format_num($done,0) ?></td>
							<td class="text-center"><?= format_num($pending,0) ?></td>
							<td class="text-center"><?= format_num($progress,0) ?></td>
							<td class="text-center"><?= format_num($cancelled,0) ?></td>
							<td class="text-center"><?= format_num($subtotal,0) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
                <tfoot>
                    <th class="py-1 text-right" colspan="2">Grand Totals</th>
							<td class="text-center"><?= format_num($total_done,0) ?></td>
							<td class="text-center"><?= format_num($total_pending,0) ?></td>
							<td class="text-center"><?= format_num($total_progress,0) ?></td>
							<td class="text-center"><?= format_num($total_cancelled,0) ?></td>
							<td class="text-center"><?= format_num($total,0) ?></td>
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
                        <h3 class="text-center mb-0"><b>STATUS REPORT</b></h3>
                        <div class="text-center"></div>
                        <h4 class="text-center mb-0">for <b><u><?= date("F d, Y", strtotime($date)) ?></u></b></h4>
                    </div>
                </div>
            </div>
            <div class="mt-5">
        </div>
</noscript>