<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header">
          <h1>Accounts Debit/Credit Report</h1>
    </section>
    <form name="form" method="post" action="<?php base_url()?>accounts_final_report">                  <!-- Date range -->
           <div class="row">           		
             <div class="col-md-3">
               <div class="form-group">
                  <label>Select Date range:</label>                    
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
						<input type="text" class="form-control pull-left" id="daterange" name="date_range">
                    </div><!-- /.input group -->                  
               </div><!-- /.form group -->
             </div>
             <div class="col-md-2">
             	<div class="form-group">
                <label>&nbsp;</label>
             	<input type="submit" name="dat_range" value="Search" class="btn btn-primary" style="margin-top:25px;">
                </div>
             </div>
           </div><!-- /.row -->
           <div class="row">
           		<div class="col-md-12">
                	<div class="box box-warning">
                    	<div class="box-body">
                        	<?php
								$date_rang = (!empty($this->input->post('date_range')))? $this->input->post('date_range'): 'Please select date range';
                            ?>
                        	Date Rang: <?php echo  $this->input->post('date_range')?>
                        </div>
                    </div>
                </div>
           </div>
           <div class="row">
               <div class="box box-warning">
                	<!--<div class="box-header">
                    	<h3 class="box-title">Credited</h3>
                    </div>-->
                     <section class="content">                  
                  		<div class="box">
                   	 		<div class="box-body" id="colvis">                                                 
	                             <table id="example1" class="table table-bordered table-striped">
                                 	<thead>
                                    	<tr>
                                        	<th>Name</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th>Balance Credit</th>
                                            <th>Balance Debit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                             		<?php 
										foreach($credits as $cr){
											foreach($debits as $dr){
												//echo $cr->account_id;
												if($cr->account_id == $dr->account_id){
													$amount = $cr->amount - $dr->amount;
													if($amount >0){
														$total_credit += $amount;
														echo "<tr><td><a href='".base_url().'accounts/account_detail/'.$cr->account_id."'>$cr->account_title($cr->account_type)</a></td><td>$cr->amount</td><td>$dr->amount</td><td>$amount</td><td></td></tr>";
													}
												else {
													$total_debit += $amount;
													echo "<tr><td><a href='".base_url().'accounts/account_detail/'.$cr->account_id."'>$dr->account_title($dr->account_type)</a></td><td>$cr->amount</td><td>$dr->amount</td><td></td><td>$amount</td></tr>";
												}
												}
												
												}
												
											}
									?>
                                    </tbody>
                                    <tfoot>
                                    	<tr>
                                        	<td colspan="3"><strong>Total Balance Credit & Debit</strong></td><td><strong><?php echo $total_credit;?></strong></td><td><strong><?php echo $total_debit;?></strong></td>
                                        </tr>                                       
                                        <tr>
                                            <td colspan="4"><strong>Total Balance </strong></td><td><strong><?php echo round(($total_credit+$total_debit),2);?></strong></td>
                                        </tr>
                                    </tfoot>
                            	</table>
                            </div>
                         </div>                        
                  </section>
               </div>
     	  </div>
    <script>
    	$(function () {

        $('#daterange').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#daterange').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        }
        );
	});
	
	 $(document).ready(function() {
		var table = $('#example1').DataTable( { 
					"lengthMenu": [[50,10, 25, 50,100,-1], [50 , 10, 25, 50,100,"All"]],
					"order": [[ 4, "asc" ]]
				} );
	
			// for each column in header add a togglevis button in the div
			$("#example1 thead th").each( function ( i ) {
				var name = table.column( i ).header();
				var spanelt = document.createElement( "button" );
				spanelt.innerHTML = name.innerHTML;						
		
				$(spanelt).addClass("colvistoggle");
				$(spanelt).addClass("btn btn-primary");
				$(spanelt).attr("colidx",i);		// store the column idx on the button
		
				$(spanelt).on( 'click', function (e) {
				e.preventDefault(); 
				// Get the column API object
				var column = table.column( $(this).attr('colidx') );
				// Toggle the visibility
				column.visible( ! column.visible() );
				if($(spanelt).hasClass('btn-danger'))
					$(spanelt).removeClass('btn-danger');
				else
				$(spanelt).addClass("btn btn-danger");
			});
				$("#colvis").append($(spanelt));
		});
	} );
	
	
    </script>
     
<?php $this->load->view("partial/footer"); ?>