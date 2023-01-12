<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header head">
          <h1>Sale Report</h1>
    </section>
    <form name="form" method="post" action="<?php base_url()?>item_report">
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
			$item_name = $selected_item->item_title;
			foreach($acnt as $acn){}
		   ?>
           <input type="hidden" id="item1" name="item1" value="<?php echo $item_name;?>"/>
           <input type="hidden" id="date1" name="date1" value="<?php echo $start_date;?>"/>
      <div class="row">
           		<div class="col-md-12">
                <div class="box box-success">
                	<div class="box-header" style="text-align:center">
                    	<h3 class="box-title" id="item">SUPPLY OF <?php echo $item_name;?></h3><h3 id="date"> From Date <?php echo $start_date;?> To <?php echo $end_date;?> </h3><br>
                        <div id="hide">
                        <h3 class="box-title"><?php echo $config->company_name; ?></h3><br />
                        
                        <h3 class="box-title" id="stn"> STN:<?php echo $config->s_t_r_no; ?></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 class="box-title" id="ntn">NTN:<?php echo $config->ntn_no; ?></h3>
                      </div>
                    </div>
                    <h3>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ' '. $acn->account_title;?></h3>
               <section class="content">
                  <div class="row">
           			 <div class="col-xs-12">
                  		<div class="box">
                   	 		<div class="box-body" id="colvis">                                                 
	                             <table id="example1" class="table table-bordered table-striped">
                             		<thead>                            
                                		<tr>
                                        	<th>Sr#</th><th>Item Name</th><th>Bags/Mun</th><th>Weight</th><th>Rate</th><th>Amount</th>
                                         </tr>
                                     </thead>
                                     <tbody>                                                                     
										<?php
                                        $counter = 1;echo '<pre>';
                                        foreach($bale_report as $row){
										$weight_mun = $row->kat; 								
                                        $bales = $row->bales;                                
                                        
                                        $weight = $row->weight;
										$item_type = $row->item_type;
										if($item_type != 4)
											$bags = weight_convert($item_type,$weight,$weight_mun);
										else
											$bags = $row->weight;
											
										$total_bales += $bags;											
                                        $total_weight += $weight;
                                        $tax = $row->tax_amount;
                                        $total_tax += $tax;
                                        $rate = $row->inv_price;
                                        
                                        $gross_amount = $row->customer_total;
                                        $total_gros += $gross_amount;
                                        $net_amount = $gross_amount-$tax;
                                        $total_net += $net_amount;
										$amounnt = $bags * $row->inv_price;
										$total_amount += $amounnt;
										
										
                                        ?>
                                   		 <tr>
                                            <td><?php echo $counter;?></td>
                                            <td><?php echo $row->item_title;?></td>
                                            <td><?php echo $bags;?></td>
                                            <td><?php echo $row->weight;?></td>
                                            <td><?php echo $row->inv_price;?></td>
                                            <td><?php echo round($amounnt,3);?></td>
                                  		  </tr>
                               			 <?php $counter++ ; }?>
                                         </tbody>
                                         <tfoot>
                               			  <tr>
                                            <td>&nbsp;</td>
                                            <td><h3>Total </h3></td>                                  
                                            <td><h3><?php echo $total_bales;?></h3></td>
                                            <td><h3><?php echo $total_weight;?></h3></td>
                                            <td>&nbsp;</td>
                                            <td><h3><?php echo round($total_amount,2);?></h3></td>
                                		</tr>
                                        </tfoot>
                            		 
                                      <button type="button" name="ntn" id="ntn" onclick="ntn()" class="btn btn-primary colvistoggle">NTN</button>  
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
			var items = $('#item1').val();
			var start_date = $('#date1').val();
			console.log(items);
			if(!items){
				//alert(items);
				$('#item').html('');
			}
			if(!start_date){
				$('#date').html('');
				}
		});
		
	$(document).ready(function() {
		ntn();
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
	function ntn(){
		 // alert('Test');
		 $('#hide').toggle();
		// $('#hide').html('');
		  }
    </script>
     
<?php $this->load->view("partial/footer"); ?>