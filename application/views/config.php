<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<form action="<?php echo base_url()?>company_config" method="post">
<div class="row">
   		  <div class="col-md-12">
                <div class="box box-success">
                	<div class="box-header">
                    	<h3 class="box-title">System Configuration</h3>
                    </div>
                    <div class="box-body">
                    	<div class="form-group">
                        <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">Company Name:</div>
                             <div class="col-md-3"><input type="text" name="company_name" value="<?php  echo $config->company_name?>" class="form-control" /></div> 
                       </div>
                       </div>
                       <div class="form-group">
                        <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">Phone#:</div>
                             <div class="col-md-3"><input type="text" name="phone_no" value="<?php  echo $config->phone_no?>" class="form-control" /></div> 
                       </div>
                       </div>
                       <div class="form-group">
                        <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">Address#:</div>
                             <div class="col-md-3"><input type="text" name="address" value="<?php  echo $config->address?>" class="form-control" /></div> 
                       </div>
                       </div>
                       <div class="form-group">
                        <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">S.T.Reg. No.:</div>
                             <div class="col-md-3"><input type="text" name="s_t_r_no" value="<?php  echo $config->s_t_r_no?>" class="form-control" /></div> 
                       </div>
                       </div>
                       <div class="form-group">
                       <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">NTN#s:</div>
                             <div class="col-md-3"><input type="text" name="ntn_no" value="<?php  echo $config->ntn_no?>" class="form-control" /></div> 
                       </div>
                       </div>
                       <div class="form-group">
                       <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">Broker Ratio:</div>
                             <div class="col-md-3"><input type="text" name="broker_ratio" value="<?php  echo $config->broker_ratio?>" class="form-control" /></div> 
                       </div>
                       </div>
                       <div class="form-group">
                       <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">Broker Tax Ratio:</div>
                             <div class="col-md-3"><input type="text" name="broker_tax_ratio" value="<?php  echo $config->broker_tax_ratio?>" class="form-control" /></div> 
                       </div>
                       </div>
                       <div class="form-group">
                       <div class="row"><!-- /ROW start --> 
                             <div class="col-md-3">&nbsp;</div>
                             <div class="col-md-3"><input type="Submit" name="update" value="Update Config" class="btn btn-primary" /></div> 
                       </div>
                       </div>
                    </div>
                </div>
           </div>
          </div> 
    </form> 
    <input type="button" id="backup_db" class="btn btn-danger" value="Backup Database" />
    <script>
    	$(function () {
			$("#backup_db").click(function() {
				window.location='<?php echo site_url('company_config/backup_db') ?>';
			});
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