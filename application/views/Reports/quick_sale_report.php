<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header head">
          <h1>Quick Sale Report</h1>
    </section>
    <form name="form" method="post" action="<?php base_url()?>quick_sale_report">
    <div class="box-body report_header_form">
                  <!-- Date range -->
          <div class="row">             	
            <div class="col-md-3">
            	<div class="form-group">
                  <label>Select Item:</label>                    
                    
                    	<select name="inv_items" id="inv_items" class="form-control select2" >
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
                	<div class="box-header report_header_form" style="text-align:center">
                    	<h3 class="box-title" >Quick Sale Report OF <?php echo $selected_item->item_title;?> From Date <?php echo $start_date;?> To <?php echo $end_date;?> </h3><br>
                        
                        <h3 class="box-title"><?php echo $config->company_name; ?></h3><br />                        
                    </div>
                     <section class="content">
                  <div class="row">
           			 <div class="col-xs-12">
                  		<div class="box">
                   	 		<div class="box-body">                                                 
	                             <table class="table">
                             		<thead>
                                		<tr>
                                        	<th>Sr#</th><th>Date</th><th>Weight</th><th>Amount</th><th>Discount</th><th>Total</th>
                                        </tr>
                                	</thead>
                                    	<tbody>											
                                        	<?php
												$title_flg = '';												
                                            	foreach($quick_sale as $sale)
												{
													$item_title = $sale->item_title;
													$date = explode(' ',$sale->sale_date);
													if($title_flg != $item_title && !empty($title_flg))
													{ ?>
                                                    	<tr>
                                                        	<td>&nbsp;</td>
                                                            <td><h3>Total</h3></td>
                                                        	<td><h3><?php echo $item_total_quantity?></h3></td>
                                                            <td><h3><?php echo $item_total_price?></h3></td>
                                                            <td><h3><?php echo $item_total_discount?></h3></td>
                                                            <td><h3><?php echo $item_total?></h3></td>
                                                        </tr>
                                                        
														<tr>
															<td><?php echo $item_title?></td>
                                                        </tr>
                                                     <?php
														$title_flg = $item_title;
														$item_total_quantity = 0;
														$item_total_discount = 0;
														$item_total_price = 0;
														$item_total = 0;
													}
													else if(empty($title_flg))
													{ ?>
                                                    	<tr>
															<td><?php echo $item_title.'1'?></td>
                                                        </tr>
														
													<?php 
														$title_flg = $item_title;
													}
													?>
                                                    <tr>
                                                    		<td>&nbsp;</td>
                                                            <td><?php echo date_change_view($date[0]);?></td>
                                                        	<td><?php echo $sale->quantity;?></td>
                                                            <td><?php echo $sale->price;?></td>
                                                            <td><?php echo $sale->discount;?></td>
                                                            <td><?php echo $sale->total;?></td>
                                                    </tr>
                                                   
                                                    <?php 
													$item_total_quantity += $sale->quantity;
													$item_total_discount += $sale->discount;
													$item_total_price += $sale->price;
													$item_total += $sale->total;
													
													$grand_total_quantity += $sale->quantity;
													$grand_total_discount += $sale->discount;
													$grand_total_price += $sale->price;
													$grand_total += $sale->total;
													
												}
											?>
                                             		<tr>                                                    		
                                                            <td><h2>Grand Total</h2></td>
                                                            <td>&nbsp;</td>
                                                        	<td><h2><?php echo $grand_total_quantity?></h2></td>
                                                            <td><h2><?php echo $grand_total_price?></h2></td>
                                                            <td><h2><?php echo $grand_total_discount?></h2></td>
                                                            <td><h2><?php echo $grand_total?></h2></td>
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
			
			 $("#example1").DataTable();
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
		
    </script>
     
<?php $this->load->view("partial/footer"); ?>