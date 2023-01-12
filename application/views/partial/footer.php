	       </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>RG93bmxvYWRlZCBmcm9tIENPREVMSVNULkND</strong>
      </footer>
      
          <!-- jQuery 2.1.4 -->
    
    <!-- Bootstrap 3.3.5 -->
   
    <script src="<?php echo base_url();?>/css/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/css/bootstrap/js/jquery.form-3.51.js" language="javascript"></script>
    <!-- Select2 -->
   <!--<script src="<?php echo site_url('assets/js/angular.min.js') ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0rc1/angular-route.min.js"></script>
	<script src="<?php echo site_url('assets/js/app.js') ?>"></script>-->
		
    <script src="<?php echo base_url();?>plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url();?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>plugins/datatables/dataTables.bootstrap.min.js"></script>    
    <!--date-range-picker-->   
    <script src="<?php echo base_url();?>plugins/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url();?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap time picker -->  
    <script src="<?php echo base_url();?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo base_url();?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>dist/js/app.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/autoNumeric.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jQuery.print.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/printPreview.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/main.js"></script>

    <!--<script src="<?php // echo  base_url();?>plugins/daterangepicker.js"></script>-->
    <?php  if(!sizeof($js_files))
    echo '<script src="'.base_url().'/plugins/datepicker/bootstrap-datepicker.js"></script>';?>
    <!--<script src="<?php echo base_url();?>plugins/datepicker/bootstrap-datepicker.js"></script>-->
   <!-- <script src="<?php //echo base_url();?>plugins/typehead.js"></script>-->
     
  </body>
</html>