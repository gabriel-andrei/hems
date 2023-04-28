<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
$filterreport = isset($_GET['filterreport'])?$_GET['filterreport'] : 'all';
$filtertype = isset($_GET['filtertype'])?$_GET['filtertype'] : '';
$filterperiod = isset($_GET['filterperiod'])?$_GET['filterperiod'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
$user_name = isset($_GET['name']) ? $_GET['name'] : '';

?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Reports</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid mb-3">
            <fieldset class="px-2 py-1 border">
                <div class="container-fluid">
                    <form action="" id="filter-form">
                        <div class="row align-items-end">
                            <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="filterreport" class="control-label">Reports</label>
                                    <select name="filterreport" id="filterreport" class="form-control form-control-sm rounded-0" required>
                                        <option value="all" <?php echo isset($filterreport) && $filterreport=='all' ?  'selected' : '' ?>>All (Transactions)</option>
                                        <option value="sales" <?php echo isset($filterreport) && $filterreport=='sales' ? 'selected' : '' ?>>Sales</option>
                                        <option value="service" <?php echo isset($filterreport) && $filterreport=='service' ? 'selected' : '' ?>>Service</option>    
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="filter" class="control-label">Filter by</label>
                                    <select name="filtertype" id="filtertype" class="form-control form-control-sm rounded-0" required>
                                        <option value="all" <?php echo !isset($filtertype) ? 'selected' : '' ?>>All</option>
                                        <option id='opt-bs' value="best_selling" <?php echo isset($filtertype) && $filtertype=='best_selling'? 'selected' : '' ?>>Best Selling</option>
                                        <option value="clients" <?php echo isset($filtertype) && $filtertype=='clients' ? 'selected' : '' ?>>Clients</option>
                                        <option id='opt-mc' value="machinist" <?php echo isset($filtertype) && $filtertype=='machinist' ? 'selected' : '' ?>>Machinist</option>
                                        <option id='opt-vt' value="vehicle" <?php echo isset($filtertype) && $filtertype=='vehicle' ? 'selected' : '' ?>>Vehicle Type</option>
                                        <option id='opt-st' value="status" <?php echo isset($filtertype) && $filtertype=='status' ? 'selected' : '' ?>>Transaction Status</option>
                                        <option id='opt-en' value="engine" <?php echo isset($filtertype) && $filtertype=='engine' ? 'selected' : '' ?>>Engine Model</option>
                                        </select>                                
                                    </div>
                                </div>
                            <div class="col-lg-1 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="filter" class="control-label">Filter Period</label>
                                    <select name="filterperiod" id="filterperiod" class="form-control form-control-sm rounded-0" required>
                                        <option value="daily" <?php echo !isset($filterperiod) ? 'selected' : '' ?>>Daily</option>
                                        <option value="weekly" <?php echo isset($filterperiod) && $filterperiod=='weekly' ? 'selected' : '' ?>>Weekly</option>
                                        <option value="monthly" <?php echo isset($filterperiod) && $filterperiod=='monthly' ? 'selected' : '' ?>>Monthly</option>
                                        <option value="yearly" <?php echo isset($filterperiod) && $filterperiod=='yearly' ? 'selected' : '' ?>>Yearly</option>
                                        </select>                                
                                    </div>
                                </div>
                            <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12 date-view">
                                <div class="form-group">
                                    <label for="date" class="control-label date-label">Choose Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="date" id="date" value="<?= date("Y-m-d", strtotime($date)) ?>" >
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
			<?php 
            
            $total=$total_amount=$total_vat=$total_count = 0;
            $i = 1;
            $file_name = '';
            if($filtertype == 'all'){
                if($filtertype == 'all'){
                    $filename = $filterreport.'-'.$filterperiod;
                }else{
                    $filename = $filtertype.'-'.$filterperiod;
                }
            }else{
                $filename = $filterreport.'-'.$filtertype;
            }
            if (file_exists (base_app.'admin/reports/table-'.$filename.'.php')){
                require_once('table-'.$filename.'.php');
            }else{
                echo '<h4 class="text-center">Sorry, the report you have selected is unavailable!</h4>';
            }


            ?>
		</div>
	</div>
</div>
<noscript id="print-footer">
    <div>
        <div class="container-fluid mt-5" >
            <div class="row">
                <div class="col-2 text-center">
                    <b>Prepared by:</b>
                </div>
                <div class="col-4 text-center">
                    <b> ________________________________</b>
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

        $('#opt-bs').attr('disabled', 'disabled');

		$('#filterreport').change(function(e){
            e.preventDefault()

			var select = $('#filterreport').val();
            $('#opt-bs').removeAttr('disabled');
            $('#opt-st').removeAttr('disabled');
            $('#opt-mc').removeAttr('disabled');
            $("#filtertype").select2("val", "0");

			if(select == 'all' ){
                $('#opt-bs').attr('disabled', 'disabled');
			}else if(select == 'sales' ){
                $('#opt-mc').attr('disabled', 'disabled');
                $('#opt-st').attr('disabled', 'disabled');
                $('#opt-bs').removeAttr('disabled');
			}else if(select == 'service' ){
                $('#opt-en').attr('disabled', 'disabled');
                $('#opt-st').attr('disabled', 'disabled');
                $('#opt-bs').removeAttr('disabled');
			}
		});
        
		$('#filterperiod').change(function(e){
			var select = $('#filterperiod').val();
			$('.date-view').show();
			if(select == 'daily' ){
                $('.date-label').html('Choose Date');
			}else if(select == 'weekly' ){
                $('.date-label').html('Choose Start Date');
			}else if(select == 'monthly' ){
                $('.date-label').html('Choose Month/Year');
			}else if(select == 'yearly' ){
                $('.date-label').html('Choose Year');
            }else{
                $('.date-label').html('Choose as-of Date');
			}
		});
        

		$('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=reports/daily_sales_report&"+$(this).serialize()

            if(select == 'all' ){
                $('#opt-bs').attr('disabled', 'disabled');
			}else if(select == 'sales' ){
                $('#opt-mc').attr('disabled', 'disabled');
                $('#opt-st').attr('disabled', 'disabled');
                $('#opt-bs').removeAttr('disabled');
			}else if(select == 'service' ){
                $('#opt-en').attr('disabled', 'disabled');
                $('#opt-st').attr('disabled', 'disabled');
                $('#opt-bs').removeAttr('disabled');
			}
        })
        $('#filterreport').select2({
            placeholder:"Choose Filter",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#filtertype').select2({
            placeholder:"Choose Filter",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
        $('#filterperiod').select2({
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