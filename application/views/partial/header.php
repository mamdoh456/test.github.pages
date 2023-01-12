<!DOCTYPE html>
<html data-ng-app="accountingApp">
  <head>
  	<title>Accounts Managment</title>
    <?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?php  if(!sizeof($js_files))
			echo '<script src="'.base_url().'/plugins/jQuery/jQuery-2.1.4.min.js"></script>';?>
            <script src="<?php echo base_url()?>assets/js/typeahead.js"></script>
            <script src="<?php echo base_url()?>plugins/jqvalidation/jquery.validate.min.js"></script>
            <script src="<?php echo base_url()?>assets/js/chart.min.js"></script>
     <link rel="stylesheet" href="<?php echo base_url();?>/plugins/datatables/dataTables.bootstrap.css">       
    <link rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap/css/custom.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>/css/fontawesome45/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url();?>/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url();?>/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url();?>/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo base_url();?>/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?php echo base_url();?>/plugins/timepicker/bootstrap-timepicker.min.css">
       <link rel="stylesheet" href="<?php echo base_url();?>/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min">
    <link rel="stylesheet" href="<?php echo base_url();?>/plugins/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/plugins/datepicker/bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url();?>/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    
    <link rel="stylesheet" href="<?php echo base_url();?>/dist/css/skins/_all-skins.min.css">
    <!--<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>-->
    <script src="<?php echo site_url('assets/js/jquery-migrate-1.0.0.js');?>"></script>
    
    <script src="<?php echo site_url('assets/js/jquery.printElement.min.js');?>"></script>
  </head>
    <body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">
    <header class="main-header head">
        <!-- Logo -->
        <a href="<?php echo base_url();?>index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Accounts</b>Managment</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
              		<a href="<?php echo base_url()?>login/logout"><i class="fa  fa-sign-out"></i>Sign Out</a>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="<?php echo base_url()?>company_config"><i class="fa fa-gears"></i> Settings</a>
              </li>              
            </ul>
          </div>
        </nav>
      </header>
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="treeview">
              <a href="<?php echo  base_url()?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> </i>
              </a>
            </li>
            <li class="treeview active">
             	<a href="#">
                <i class="fa fa-users"></i>
             	<span>Accounts</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
               <ul class="treeview-menu">
               	 <li>
             	 <a href="<?php echo base_url();?>accounts">
               	 <i class="fa fa-users"></i> <span>Accounts</span> 
             	 </a>
             	 </li>             	 
             	 <li><a href="<?php echo base_url();?>accounts/account_type">
                 <i class="fa fa-user-plus"></i> <span>Add/View Account Type</span> </a> </li>
              </ul>
            </li>             
            
            <!--<li class="treeview">
            	<a href="#">
                	<i class="fa fa-user"></i> <span> Employee</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                    <ul class="treeview-menu">
                    	<li>
              				<a href="<?php echo base_url();?>employee">
                			<i class="fa fa-user"></i> <span>Employee</span> 
              				</a>
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>employee/employee_salary">
                			<i class="fa fa-money "></i> <span>Employee salary</span> 
              				</a>
            			</li>
                     </ul>
             </li>-->
             <li class="treeview">
            	<a href="#">
                	<i class="fa fa-credit-card "></i> <span> Expences</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                    <ul class="treeview-menu">
                    	<li>
                        	<a href="<?php echo base_url();?>expence/expence">
                			<i class="fa fa-money"></i> <span>View/Add Expence</span> 
              				</a>
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>expence">
                			<i class="fa fa-list-alt  "></i> <span>Add Expence Type</span> 
              				</a>
              				
            			</li>
                     </ul>
             </li>
            <li>
              <a href="<?php echo base_url();?>items">
                <i class="fa fa-gift"></i> <span>Items</span> 
              </a>
            </li>
            <li>
            	<a href="<?php echo base_url();?>supplier">
            		<i class="fa fa-fax "></i> <span>Add Purchase</span> 
            	</a> 
            </li>
            <li>
            	<a href="<?php echo base_url();?>supplier/bill_list">
            		<i class="fa fa-list"></i> <span>View Purchase List</span> 
            	</a> 
            </li>
            <li>
              <a href="<?php echo base_url();?>invoice">
                <i class="fa fa-calculator"></i> <span>Add Sale</span> 
              </a>
            </li>
            <li>
              <a href="<?php echo base_url();?>invoice/invoices_list">
                <i class="fa fa-file-o"></i> <span>View Sale List</span> 
              </a>
            </li>
            <li>
              <a href="<?php echo base_url();?>transactions">
                <i class="fa fa-calendar-plus-o"></i> <span>Transection</span> 
              </a>
            </li>
            <li>
              <a href="<?php echo base_url();?>invoice/quick_sale">
                <i class="fa fa-shopping-cart "></i> <span>Quick Sale</span> 
              </a>
            </li>
            <li>
              	<a href="<?php echo base_url();?>report/drcr_report">
                	<i class="fa fa-list-alt  "></i> <span>Dr/Cr Report</span> 
              	</a>
              				
            </li>
            <li>
              	<a href="<?php echo base_url();?>report/accounts_final_report">
                	<i class="fa fa-television"></i> <span>Accounts Final Report</span> 
              	</a>
              				
            </li>
            <li class="treeview active">
            	<!--<a href="#">
                	<i class="fa fa-bar-chart-o"></i> <span> Reports</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu active ">
                	<li >-->
                    	<a href="#">
                        	<i class="fa fa-outdent"></i> <span>Sales Reports</span>
                   			<i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu active">
                    	
                        
                        <li>
              				<a href="<?php echo base_url();?>report/bale_report">
                			<i class="fa fa-list-alt  "></i> <span>Sale Report</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/item_report">
                			<i class="fa fa-list-alt  "></i> <span>Items Report</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/services_report_sale">
                			<i class="fa fa-list-alt  "></i> <span>Services Report</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/broker_report_sale">
                			<i class="fa fa-list-alt  "></i> <span>Broker Report Sale</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/parta_report">
                			<i class="fa fa-list-alt  "></i> <span>Parta Report</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/daily_ledger">
                			<i class="fa fa-list-alt  "></i> <span>Daily Sale Report</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/quick_sale_report">
                			<i class="fa fa-list-alt  "></i> <span>Quick Sale Report</span> 
              				</a>              				
            			</li>
                     </ul>
                    </li>
               <!-- </ul>
                <ul class="treeview-menu active">-->
                	<li class="treeview active">
                    	<a href="#">
                        	<i class="fa fa-indent "></i> <span>purchase Reports</span>
                   			<i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu menu-open">
                    	<li>
                        	<a href="<?php echo base_url();?>report">
                			<i class="fa fa-money"></i> <span>Weight Report</span> 
              				</a>
            			</li>
                        
                        <li>
              				<a href="<?php echo base_url();?>report/purchase_report">
                			<i class="fa fa-list-alt  "></i> <span>Purchase Report</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/broker_report_purchase">
                			<i class="fa fa-list-alt  "></i> <span>Broker Report Purchase</span> 
              				</a>              				
            			</li>
                        <li>
              				<a href="<?php echo base_url();?>report/services_report">
                			<i class="fa fa-list-alt  "></i> <span>Services Report</span> 
              				</a>              				
            			</li>
                     </ul>
                    </li>
               <!-- </ul>-->
                    
             </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
  			<div ng-view></div>
            <div id="print_header">
            	<h2 align="center">IDLBridge</h2>
                <h3 align="center">Lahore (Punjab Pakistan)</h3>                
            </div>