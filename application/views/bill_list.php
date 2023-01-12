<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header head">
          <h1>Bill Detail</h1>
    </section>
    <div class="box box-default" id="printit">
         <div class="box-body">
         	<form method="post" action="<?php echo base_url();?>supplier/bill_list">
              <div class="row report_header_form"><!-- /ROW start --> 
                   <div class="col-md-2">
                       <div class="form-group">
                       		<label>Company Name</label>
                              <select class="form-control select2" name="company_name" id="company_name">
                              		<option value=''>Select Supplier</option>
                                      <?php 
									  		echo $this->input->post('bill_from');
											foreach ($bill_detail as $r)
											{
												$selected = ($this->input->post('company_name') == $r->account_id) ? 'selected = "selected"':'';
												
												echo "<option value='$r->account_id' ".$selected.">$r->account_title</option>";
											}
									  ?>
                                    </select>
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
                       	<input type="submit" value="Apply Filter" class="btn btn-primary" style="margin-top:25px;">
                       </div>
                   </div>
              </div><!-- end Row--!-->
              </form>
               <section class="content">
                  <div class="row">
           			 <div class="col-xs-12">
                  		<div class="box">
                   	 		<div class="box-body" id="colvis">                                                 
	                             <table id="example1" class="table table-bordered table-striped">
                             		<thead>
                						<tr ><th>Date</th><th>Supplier Name</th><th>Bill#</th><th>Phone#</th><th>Vehical#</th><th>Total Amount</th><th>Paid Amount</th><th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $result=0; 
                                        foreach($bills as $bill){
											$date = explode('-',$bill->bill_date)
                                        ?>
                                        <tr>
                                        	<td><?php echo $date[1].'/'.$date[2].'/'.$date[0];?></td>
                                            <td><?php echo $bill->account_title;?></td>
                                            <td><?php echo $bill->bill_no;?></td>
                                            <td><?php echo $bill->phone_no;?></td>
                                            <td><?php echo $bill->vehical_no;?></td>
                                            <td><?php echo $bill->supplier_total;?></td>
                                            <td><?php echo $bill->paid_amount;?></td>
                                            <td><a class="btn btn-primary" href="<?php base_url()?>view_bill/<?php echo $bill->bill_id;?>">View</a>
                                            	<a class="btn btn-danger" href="<?php base_url()?>delete_bill/<?php echo $bill->bill_id;?>">Delete</a>
                                            </td>
                                        </tr>
                                        
                                        <?php }?>
                                    </tbody>                   
                				</table>
                               </div>
                            </div>
               			</div>
                	</div>
               </section>
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
			
		
	  
	  $(document).ready(function() {
		var table = $('#example1').DataTable( { "lengthMenu": [[50,10, 25, 50,100,-1], [50 , 10, 25, 50,100,"All"]],"order": [[ 0, "desc" ]]} );
	
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
	 
	 $(function(){
	$("#printitbtn").click(function() {
             printElem({ printMode: 'popup' });
         });
})
function printElem(options){
     $('#printit').printElement(options);
 } 
</script>


<?php $this->load->view("partial/footer"); ?>