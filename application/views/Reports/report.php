<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header head">
          <h1>Weight Report</h1>
    </section>
    <form name="form" method="post" action="<?php base_url()?>report">
    <div class="box-body report_header_form">
                  <!-- Date range -->
           <div class="row">  
           	<div class="col-md-3">
            	<div class="form-group">
                  <label>Select Item:</label>                    
                    <div class="input-group">
                    	<select name="inv_items" class="form-control select2">
                        	<?php
                            	foreach($inv_items as $item)
								{
									if($item->item_id == $this->input->post('inv_items'))
										$selected = 'selected="selected"';
									else
										$selected = '';
										
									echo '<option value="'.$item->item_id.'" '.$selected.'>'.$item->item_title.'</option>';
								}
							?>
                            	
                        </select>
                    </div><!-- /.input group -->                  
               </div>
            </div>         		
             <div class="col-md-3">
               <div class="form-group">
                  <label>Date range:</label>                    
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
						<input type="text" class="form-control pull-left" id="daterange-btn" name="date_range" value="<?php echo  $this->input->post('date_range')?>">
                    </div><!-- /.input group -->                  
               </div><!-- /.form group -->
             </div>
             <div class="col-md-2">
             	<div class="form-group">
                <label>&nbsp;</label>
             	<input type="submit" name="dat_range" value="Search" class="btn btn-primary" style="margin-top:25px;" >
                </div>
             </div>
           </div><!-- /.row -->
     </div> <!-- box body--> 
     </form>
     <div class="row">
           		<div class="col-md-12">
                	<div class="box box-warning">
                    	<div class="box-body">
                        	<?php
								$date_rang = (!empty($this->input->post('date_range')))? $this->input->post('date_range'): 'Please select date range';
                            ?>
                        	Selected Item: <strong><?php echo $selected_item->item_title?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-right">Date Rang: <strong><?php echo  $this->input->post('date_range')?></strong></span>
                        </div>
                    </div>
                </div>
           </div>
      <div class="row">
           		<div class="col-md-12">
                <div class="box box-success">
                	<div class="box-header">
                    	<h3 class="box-title">Weight Collection Report</h3>
                    </div>
                     <section class="content">
                  		<div class="row">
           					<div class="col-xs-12">
                  				<div class="box">
                   	 				<div class="box-body" id="colvis">                                                 
	                            		<table id="example1" class="table table-bordered table-striped">
                             				<thead>                             
                                				<tr>
					                                <th>Date</th><th>Name</th><th>Weight</th><th>Total Weight</th><th>Amount</th><th>Dhara</th></tr>
                                             </thead>
                                             <tbody>
												<?php foreach($date_report as $row){ 
                                                $quantity = $row->total_weight;                                
                                                $total_quantity += $quantity;
                                                $amount = $row->grand_total;
                                                $dara = ($amount/$quantity)*40;
                                                ?>
                                   				 <tr>
                                                    <td><?php echo date_change_view($row->bill_date);?></td>             	 
                                                    <td><?php echo $row->account_title;?></td> 
                                                    <td><?php echo $row->total_weight;?></td>               
                                                    <td><?php echo $total_quantity;?></td>
                                                    <td><?php echo $row->grand_total;?></td>
                                                    <td><?php echo round($dara,2);?></td>
                                   				 </tr>
                               				 <?php  }?>
                                             </tbody>
                                             <tfoot></tfoot>
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
			$(".select2").select2();
			 //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
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
          $('#reportrange span').html(start.format('DDDD M, YYYY') + ' - ' + end.format('DDDD M, YYYY'));
        }
        );
			});
			
		$(function () {
        //$("#example1").DataTable();
      });
	  
	  $(document).ready(function() {
		var table = $('#example1').DataTable( { 
					"lengthMenu": [[50,10, 25, 50,100,-1], [50 , 10, 25, 50,100,"All"]],
					"order": [[ 3, "asc" ]]
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