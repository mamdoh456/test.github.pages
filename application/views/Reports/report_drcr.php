<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header">
          <h1>Debit/Credit Report</h1>
    </section>
    <form name="form" method="post" action="<?php base_url()?>drcr_report">                  <!-- Date range -->
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
           		<div class="col-md-6">
                <div class="box box-warning">
                	<div class="box-header">
                    	<h3 class="box-title">Credited</h3>
                    </div>
                     <section class="content">
                  <div class="row">
           			 <div class="col-xs-12">
                  		<div class="box">
                   	 		<div class="box-body" id="colvis">                                                 
	                             <table id="example1" class="table table-bordered table-striped">
                             		<thead>
                            			<tr>
                                            <th>Credit From</th>
                                            <th>Amount</th>
                                            <th>Details</th>
                               			 </tr>
                                    </thead>
                                    <tbody>
										<?php 
                                            $credit_sub = 0;
                                            $debit_sub = 0;
                                            foreach($credits as $credit):
                                                $credit_sub += $credit->amount;
                                        ?>
                                        <tr>
                                            <td><?php echo $credit->account_title.'('.$credit->account_type.')';?></td>
                                            <td><?php echo $credit->amount?></td>
                                            <td><?php echo $credit->detail?></td>
                                        </tr>
                                        <?php endforeach?>
                                     </tbody>
                                     <tfoot>
                                        <tr>
                                            <td class="text-right"><b>Sub Total:</b></td>
                                            <td><strong><?php echo $credit_sub;?></strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                            	</table>
                              </div>
                            </div>
                        </div>
                    </div>
                 </section>
               </div>
           </div>
           		<div class="col-md-6">
                <div class="box box-warning">
                	<div class="box-header">
                    	<h3 class="box-title">Debited</h3>
                    </div>
                     <section class="content">
                  <div class="row">
           			 <div class="col-xs-12">
                  		<div class="box">
                   	 		<div class="box-body" id="colvis1">                                                 
	                             <table id="example2" class="table table-bordered table-striped">
                             		<thead>
                                        <tr>
                                            <th>Debit From</th>
                                            <th>Amount</th>
                                            <th>Details</th>
                                        </tr>
                                     </thead>
                                     <tbody>
										<?php 
                                            foreach($debits as $debit):
                                                $debit_sub += $debit->amount;
                                        ?>
                                        <tr>
                                            <td><?php echo $debit->account_title.'('.$credit->account_type.')';?></td>
                                            <td><?php echo $debit->amount?></td>
                                            <td><?php echo $debit->detail?></td>
                                        </tr>
                                        <?php endforeach?>
                                      </tbody>
                                      <tfoot>
                                         <tr>
                                            <td class="text-right"><b>Sub Total:</b></td>
                                            <td><strong><?php echo $debit_sub;?></strong></td>
                                            <td></td>
                                        </tr>
                                     </tfoot>                                        
                            	</table>
                              </div>
                            </div>
                        </div>
                    </div>
                  </section>
                </div>
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
					"lengthMenu": [[50,10, 25, 50,100,-1], [50 , 10, 25, 50,100,"All"]]
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
	
	$(document).ready(function() {
		var table = $('#example2').DataTable( { 
					"lengthMenu": [[50,10, 25, 50,100,-1], [50 , 10, 25, 50,100,"All"]]
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
				$("#colvis1").append($(spanelt));
		});
	} );
    </script>
     
<?php $this->load->view("partial/footer"); ?>