<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header head">
          <h1>Parta Register</h1>
    </section>
    <form name="form" method="post" action="<?php base_url()?>parta_report">
    <div class="box-body report_header_form">
                  <!-- Date range -->
          <div class="row">             	
            <div class="col-md-3">
            	<div class="form-group">
                  <label>Select Item:</label>                    
                    
                    	<select name="inv_items" id="inv_items" class="form-control select2" onchange="hide()">
                        	<option value=""></option>
                        	<?php
                            	foreach($inv_item as $item)
								{
									if($item->item_id == $this->input->post('inv_items'))
										$selected = 'selected="selected"';
									else
										$selected = '';
										
									echo '<option value="'.$item->item_id.'" '.$selected.'>'.$item->item_title.'</option>';
								}
							?>
                            	
                        </select>
                   <!-- /.input group -->                  
               </div>
            </div>        		
             <div class="col-md-3">
               <div class="form-group">
                  <label>Date range:</label>                    
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
						<input type="text" class="form-control pull-left" id="daterange-btn" name="date_range" value="<?php  echo  $this->input->post('date_range')?>">
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
           <?php foreach($config as $c){} 
		   		$date_range = explode(' - ',$this->input->post('date_range'));
			 $start_date = $date_range[0];
			$end_date = $date_range[1];
		   ?>
      <div class="row">
           		<div class="col-md-12">
                <div class="box box-success">
                	<div class="box-header" style="text-align:center">
                    	<h3 class="box-title" >Trail Balance (Parta Report) OF <?php echo $selected_item->item_title;?> From Date <?php echo $start_date;?> To <?php echo $end_date;?> </h3><br>
                        
                        <h3 class="box-title"><?php echo $config->company_name; ?></h3><br />                        
                    </div>
                     <section class="content">
                  <div class="row">
           			 <div class="col-xs-12">
                  		<div class="box">
                   	 		<div class="box-body" id="colvis">                                                 
	                             <table id="example1" class="table table-bordered table-striped">
                             		<thead>
                                		<tr>
                                        	<th>Sr#</th><th>Date</th><th>Jinis</th><th>Weight</th><th>Amount</th><th>Dhara</th><th>Pre Weight</th><th>Pre Amount</th><th>Dhara</th>
                                        </tr>
                                	</thead>
                                    <tbody>
											<?php
                                            $counter = 1;
                                            foreach($parta_report as $row){ 																
                                            $weight_mun = $row->weight_mun_bag;
                                            $weight = $row->weight;
                                            $total_weight += $weight;
                                            $amount = $row->invoice_total;
                                            $dhara = ($amount/$weight)*$weight_mun;
                                            $pre_weight += $weight;
                                            $pre_amount += $amount;
                                            $dhara1 = ($pre_amount/$pre_weight)*$weight_mun
                                            
                                            ?>
                                   		<tr>
                                            <td><?php echo $counter;?></td>
                                            <td><?php echo date_change_view($row->date);?></td>              	 
                                            <td><?php echo $row->item_title;?></td> 
                                            <td><?php echo $row->weight;?></td>
                                            <td><?php echo $row->invoice_total;?></td>  
                                            <td><?php echo round($dhara,2);?></td>
                                            <?php if($counter == 1){?>
                                            <td><?php echo '0';?></td>
                                            <td><?php echo '0';?></td>
                                            <td><?php echo '0';?></td>
                                            <?php } else {?>
                                            <td><?php echo $pre_weight;?></td>
                                            <td><?php echo $pre_amount;?></td>                                       
                                            <td><?php echo round($dhara1,2);?></td>                                        
                                            <?php }?>
                               				<?php $counter++ ; }?>
                               				<!-- <tr>
                                            --<td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><h3>Total </h3></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>                                    
                                            <td><h3><?php echo $total_bales;?></h3></td>
                                            <td><h3><?php echo $total_weight;?></h3></td>
                                            <td>&nbsp;</td>
                                            <td><h3><?php echo round($total_gros,2);?></h3></td>
                                            <td><h3><?php echo round($total_tax,2);?></h3></td>
                                            <td><h3><?php echo round($total_net,2);?></h3></td>-->
                               			 </tr>
                                      </tbody>
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
		function hide(){
			var items = $('#inv_items').val();
			if(items == 34){
				//alert(items);
				$("#stn").attr('disabled', true);
				$("#ntn").prop('hide', true);
				$("#hide").prop('hide', true);
			}
		}
		
		
		
     
	  
	  $(document).ready(function() {
		var table = $('#example1').DataTable( { "lengthMenu": [[50,10, 25, 50,100,-1], [50 , 10, 25, 50,100,"All"]]} );
	
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