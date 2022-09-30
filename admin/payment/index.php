<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	
</style>
<div class="card card-outline card-primary">
<div class="card-header">
		<h3 class="card-title">Payments</h3>
	</div>
	<div class="card-body">
		
        <div class="container-fluid" id="printout">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="10%">

					<col width="15%">
			
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Code</th>

						<th class="text-center">Date Time</th>
						<th class="text-center">Amount</th>
						
					</tr>
				</thead>
				<tbody>
					
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=reports/daily_sales_report&"+$(this).serialize()
        })
        $('#print').click(function(){
            var h = $('head').clone()
            var ph = $($('noscript#print-header').html()).clone()
            var p = $('#printout').clone()
            h.find('title').text('Daily Sales Report - Print View')

            start_loader()
            var nw = window.open("", "_blank", "width="+($(window).width() * .8)+", height="+($(window).height() * .8)+", left="+($(window).width() * .1)+", top="+($(window).height() * .1))
                     nw.document.querySelector('head').innerHTML = h.html()
                     nw.document.querySelector('body').innerHTML = ph.html()
                     nw.document.querySelector('body').innerHTML += p[0].outerHTML
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