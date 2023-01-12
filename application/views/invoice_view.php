<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<section class="content-header head">
          <h1>Invoices List</h1>
    </section>
    <div class="box box-default">
          <div class="box-body">
         	<form method="post" action="<?php echo base_url();?>invoice/invoices_list">
              <div class="row report_header_form"><!-- /ROW start --> 
                   <div class="col-md-2">
                       <div class="form-group">
                       		<label>Customer Name</label>
                              <select class="form-control select2" name="customer" id="customer">
                              		<option value=''>Select Customer</option>
                                      <?php 
									  		echo $this->input->post('bill_from');
											foreach ($customers as $r)
											{
												$selected = ($this->input->post('customer') == $r->account_id) ? 'selected = "selected"':'';
												
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
                   	 		<div class="box-body">                                                 
	                             <table id="example1" class="table table-bordered table-striped">
                             		<thead>
                						<tr>
                                        	<th>Date</th><th>Invoice#</th><th>Customer Name</th><th>Phone No</th><th>Total Bill</th><th>Payment</th><th>Status</th><th>Action</th>
                    					</tr>
                                    </thead>
                                    <tbody>
										<?php $result=0; foreach($invoices as $row){
											$date = explode('-',$row->date)?>
                                        <tr>
                                        	<!--<td><?php echo date_change_view($row->date);?></td>-->
                                            <td><?php echo $date[1].'/'.$date[2].'/'.$date[0];?></td>
                                            <td><?php echo $row->invoice_no;?></td>
                                            <td><?php echo $row->account_title;?></td>
                                            <td><?php echo $row->phone_no;?></td>
                                            <td><?php echo $row->invoice_total;?></td>
                                            <td><?php echo $row->amount;?></td>
                                            <?php
                                                $pay = $row->amount;							
                                                $total = $row->invoice_total;
                                                if(strcmp($pay,$total) != 0){ $res = $total-$pay;
                                            ?>
                                            <td><?php echo $res;?></td>
                                            <td><a class="btn btn-primary" href="<?php base_url()?>view_invoice/<?php echo $row->invoice_id?>">View</a>
                                            	<a class="btn btn-danger" href="<?php base_url()?>invoice_delete/<?php echo $row->invoice_id?>">Delete</a>
                                            </td>
                                            <?php } else {?>
                                            <td colspan="2">Paid</td>
                                            <?php }?>
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
		$(function () {
        $("#example1").DataTable({ 
					"lengthMenu": [[50,10, 25, 50,100,-1], [50 , 10, 25, 50,100,"All"]],
					"order": [[ 0, "desc" ]]
				});
      });
</script>
<?php $this->load->view("partial/footer"); ?>