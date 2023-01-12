<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url();?>assets/js/invoice.js"></script>
	<section class="content-header">
    <?php if(isset($error_message)){  ?>
		<div class="alert alert-danger alert-dismissable">
        	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
       		<?php echo $error_message;?>        
        </div>
	<?php } ?>
          <h1>Invoice</h1>
    </section>
    <form style="form-inline"  id="supplierbill" method="post" action="<?php echo base_url()?>invoice/invoice_add_edit">
    	<!--<input type="hidden" name="bill_id" ng-model="bill_id" />-->
    	<div class="box box-default">
            <div class="box-body">
                <div class="row"><!-- /ROW start --> 
                    <div class="col-md-3">
                         <div class="form-group">
                                <label>Company Name (Invoice To)</label>
                               <!-- <input type="text" class="form-control" name="bill_from" ng-model="bill_from" >-->
                                    <select class="form-control select2" name="company_name" id="company_name" style="width: 100%; " required onchange="check_accounts()" >
                                      <?php 
									  	echo "<option value=''>Select Name</option>";
											foreach ($customer as $r)
										echo "<option value='$r->account_id'>$r->account_title</option>";
									  ?>
                                    </select>
                         </div><!-- /.form-group -->                     
                    </div><!-- /col 4 end --> 
                    <div class="col-md-3">
                         <div class="form-group">
                                <label>Invoice From</label>
                               <!-- <input type="text" class="form-control" name="bill_from" ng-model="bill_from" >-->
                                    <select class="form-control select2" name="invoice_form" id="invoice_form" style="width: 100%; " required onchange="check_accounts()" >
                                      <?php 
									  	echo "<option value=''>Select Name</option>";
											foreach ($accounts as $a)
										echo "<option value='$a->account_id'>$a->account_title</option>";
									  ?>
                                    </select>
                         </div><!-- /.form-group -->                     
                    </div><!-- /col 4 end --> 
                       
                    <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#example1').datepicker({
                    format: "dd/mm/yyyy",
					autoclose: true
					
                });  				           
            });
        </script>
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>Sale Type</label>
                                <select name="sale_type" class="form-control" required>
                                	<option value="">Selecte here</option>
                                	<option value="sale">Sale</option>
                                    <option value="return">Return</option>
                                </select>
                         </div><!-- /.form-group -->                     
                    </div> 
                     <div class="col-md-2">
                      <div class="form-group">
                        <label>Select Date:</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar" ></i>
                          </div>
                           <input  type="text" class="form-control"id="example1" value="<?php echo date('d/m/Y')?>" name="invoice_date" required>
                        </div><!-- /.input group -->
                      </div>    
                     </div>    
                      
                      <div class="col-md-2">
                         <div class="form-group">
                                <label>Lot. No</label>
                                <input type="text" class="form-control" name="lot_no" id="lot_no"  >
                         </div><!-- /.form-group -->                     
                    </div><!-- /ecd col md 2 -->   
                            
                </div><!-- /ROW end -->                                   
                 <div class="row">
                 	<div class="col-md-2">
                         <div class="form-group">
                                <label>Invoice No.</label>
                                <input type="text" class="form-control" name="invoice_no" id="invoice_no"  required>
                         </div><!-- /.form-group -->                     
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                	
                        <label>Vehicle No.</label>
                        <input type="text" class="form-control" name="vehical_no" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                	
                        <label>Phone No.</label>
                        <input type="text" class="form-control" name="phone" id="phone_no" >
                        </div>
                    </div>
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>Broker Name</label>
                                <select class="form-control select2" name="broker_id" id="broker" >
                                      <?php 
									  	echo "<option value=''>Select Name</option>";
											foreach ($broker as $br)
										echo "<option value='$br->account_id'>$br->account_title</option>";
									  ?>
                                    </select>
                         </div><!-- /.form-group -->                     
                    </div>
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>No of Bales / Bags</label>
                                <input type="text" class="form-control" name="bales" id="bales"  >
                         </div><!-- /.form-group -->                     
                    </div> 
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>Gate Pass#</label>
                                <input type="text" class="form-control" name="gate_pass" id="gate_pass"  >
                         </div><!-- /.form-group -->                     
                    </div>                      
                 </div>
            </div>
     	</div>
        <div class="row">
        	<div class="col-md-7">
            	<div class="box box-default">
            		<div class="box-body">
                		 <div class="row">
                            <div class="col-md-3"><label>Discription</label></div>
                            <div class="col-md-2"><label>Quantity</label></div>
                            <!--<div class="col-md-2"><label>Weight/pice</label></div>-->
                            <div class="col-md-2"><label>Price</label></div>
                            <div class="col-md-2"><label>Total</label></div>
       					 </div>
						<div class="form-group">
                    	<div class="row">
                            <div class="col-md-3">
                            <select name="inv_item_productid[]" id="productid_0" class="form-control required" >
                            	<option value=''>Select Inventories</option>
                            	<?php
									foreach ($inv_items as $r)
										echo "<option value='$r->item_id~$r->item_type~$r->price~$r->weight_mun_bag'>$r->item_title</option>";
								?>
                                </select>                           
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange quantity required" id="inv_item_quantity_0" name="inv_item_quantity[]" placeholder="Quantity" />
                            </div>                            
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange price required" id="inv_item_price_0" name="inv_item_price[]" placeholder="Price" />
                            </div>
                            <div class="col-md-2"><input type="text" id="inv_item_total_0" style="background: white; border: 0" class="subtotal inv_subtotal form-control" readonly /></div>
                            

                         </div>
                         
                         </div>
                        <!-- The template for adding new field -->
                        <div class="form-group hide" id="bookTemplate">
                        	<div class="row">
                           	 <div class="col-md-3 ">
                             <select name="inv_item_productid[]" id="productid" class="form-control required">
                             	<option value=''>Select Inventiories</option>
                            <?php
									foreach ($inv_items as $r){
										echo "<option value='$r->item_id~$r->item_type~$r->price~$r->weight_mun_bag'>$r->item_title</option>";
									}

								?>
                                </select>                              
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange quantity required" id="inv_item_quantity" name="inv_item_quantity[]" placeholder="Quantity" />
                            </div>
                            
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange price required" id="inv_item_price" name="inv_item_price[]" placeholder="Price" />
                            </div>
                            <div class="col-md-2"><input type="text" id="inv_item_total" class="subtotal form-control inv_subtotal" readonly style="background: white; border: 0"/></div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group" id="bookTemplate">
                    	<div class="row">
                        	<div class="col-md-2 text-right"><h4>Sub Total</h4></div>
                            <div class="col-md-2 text-center" ><h4 id="quantity_total"></h4></div>
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-2 text-center" ><h4 id="inv_subtotal"></h4></div>
                            <div class="col-md-2"><h4 id="after_tax"></h4></div>
                        </div>
                     </div>
                     		<div class="col-md-2">
                                <button type="button" class="btn btn-success addButton"><i class="fa fa-plus"></i>Add Row</button>
                            </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-5">
            	<div class="box box-default">
            		<div class="box-body">
                		 <div class="row">
				        	<div class="col-md-5"><label>Discription</label></div>
                            <div class="col-md-5"><label>Account</label></div>
            				<div class="col-md-5"><label>Price</label></div>
        				  </div>
                          <?php $count = 0; foreach($get_fixed as $fix){ ?>                 
                        <div class="form-group">                        					
                    	<div class="row">                        	                       
                        	<div class="col-md-1">
                       				<input type="checkbox" class="onchange add_to_bill" name="add_to_bill_from[]" id="<?php echo 'add_to_bill_from_'.$count;?>" value="<?php echo $count;?>" checked/>
                            </div>
                            <div class="col-md-3">
                            <select name="sev_item_product[]" id="<?php echo 'sev_item_product_'.$count;?>" class="form-control required sev_items search_data"  disabled>
                            	<option value="<?php echo $fix->item_id.'~'.$fix->ratio;?>"><?php echo $fix->item_title?></option>
                            <?php
									foreach ($serv_items as $r)
										echo "<option value='$r->item_id~$r->ratio'>$r->item_title</option>";
								?>
                                </select>
                                <input type="hidden" name="sev_item_product[]" id="<?php echo 'sev_item_product_'.$count;?>" value="<?php echo $fix->item_id.'~'.$fix->ratio;?>" />
                            </div>
                            <div class="col-md-3">
                            <select name="sev_account[]" id="<?php echo 'sev_account_'.$count;?>" class="form-control sev_accounts" byuser="no" readonly >
                            	<option value="">Select Account</option>
                            <?php
									foreach ($account as $ac)
										echo "<option value='$ac->account_id'>$ac->account_title</option>";
								?>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                              <input type="text" class="form-control sev_onchange  subtotal sev_subtotal calc_price valid user_change" id="<?php echo 'sev_item_price_'.$count;?>" name="sev_item_price[]" placeholder="Amount" byuserr="no" value="" ratio="<?php echo $fix->ratio;?>"/>
                            </div>
                            <!--<div class="col-md-1"> &nbsp;
                            </div>-->
                            <div class="col-md-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>   
                             <div class="col-md-1">
                            	<input type="checkbox" class="onchange subtract_from_bill" name="subtract_from_bill[]" id="<?php echo 'subtract_from_bill_'.$count;?>" value="<?php echo $count;?>" />
                            </div>                                           
                        </div>
                         </div>                      
                         <?php $count++; }?>
                        <!-- The template for adding new field -->
                        <div class="form-group1 form-group hide" id="bookTemplate1">
                        	<div class="row">
                            <div class="col-md-1 ">
                            	<input type="checkbox" class="onchange add_to_bill" name="add_to_bill_from[]" id="add_to_bill_from" value="0" />
                            </div>
                           	 <div class="col-md-3 ">
                             <select name="sev_item_product[]" id="sev_item_product" class="form-control required sev_items search_data"  >
                             	<option value=''>Select Services</option>
                            <?php
									foreach ($serv_items as $r){
									echo "<option value='$r->item_id~$r->ratio'>$r->item_title</option>";
									}
								?>
                                	</select>
                                </div>
                                <div class="col-md-3">
                                 <select name="sev_account[]" id="sev_account" class="form-control required sev_accounts"  byuser="no" readonly >
                            		<option value="">Select Account</option>
									<?php
                                        foreach ($account as $ac)
                                            echo "<option value='$ac->account_id'>$ac->account_title</option>";
                                    ?>
                                </select>
                            </div>                                
                            <div class="col-md-3">
                                <input type="text" class="form-control sev_onchange subtotal sev_subtotal valid user_change" id="sev_item_price" name="sev_item_price[]" placeholder="Amount" value="" byuserr="no"/>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger removeButton1"><i class="fa fa-minus"></i></button>
                            </div>
                            <div class="col-md-1 ">
                            	<input type="checkbox" class="onchange subtract_from_bill" name="subtract_from_bill[]" id="subtract_from_bill" value="0" />
                            </div>                         
                        </div>
                    </div>                    
                    <div class="form-group" id="bookTemplate1">
                    	<div class="row">
                        	<div class="col-md-4 text-right"><h4>Sub Total</h4></div>
                            <div class="col-md-6 text-center" ><h4 id="sev_subtotal"></h4></div>

                        </div>
                     </div>
                     <div class="col-md-2">
                                <button type="button" class="btn btn-success addButton1"><i class="fa fa-plus"></i>Add Row</button>
                     </div>
                    </div>
                </div>
            </div>            
         </div>
         <div class="row">
         	<div class="col-md-12">
                <div class="box box-default">
                	<div class="box-body">
                    	<div class="row">
                        	<div class="col-md-2 text-right"><h3>Total Invoice To(<span id="totl_bill_from_name" class="small">---</span>)</h3></div>
                            <div class="col-md-2"><input type="text" name="supplier_total" id="grand_total" class="form-comtrol" readonly style="background: white; border: 0; margin-top: 23px; font-size: 23px; color:red; font-weight:bold;" /></div>
                    		<div class="col-md-2 "><h3>Total Invoice From (<span id="totl_bill_to_name" class="small">---</span>)</h3></div>
                    		<div class="col-md-2" ><input type="text" name="grand_total" id="supplier_total" class="form-control" readonly style="background: white; border: 0; margin-top: 23px; font-size: 23px; color:red; font-weight:bold;"/></div>
                            <div class="col-md-2">
                            	 <div class="form-group">
                                    <label>Tax Ratio</label>
                                    <input type="text" class="tax form-control onchange" name="tax_ratio" id="tax_ratio"  >
                            	 </div><!-- /.form-group -->                     
                       		 </div>
                             <div class="col-md-2">
                            	 <div class="form-group">
                                    <label>Tax Amount</label>
                                    <input type="text" class="form-control onchange" name="tax_amount" id="tax_amount" readonly="readonly" style="background:#FFF; border:0" >
                            	 </div><!-- /.form-group -->                     
                       		 </div>
                    	</div>
                        <hr />
                         <div class="row">
                        	<div class="col-md-6 text-right"><h3>Payment To:</h3></div>
                            <div class="col-md-2" style="line-height:70px">
                            	<select name="accounts" id="accounts" class="form-control select2" style="margin-top:25px">
                                	<?php foreach($accounts as $ac){?>
										<option value="<?php echo $ac->account_id;?>"><?php echo $ac->account_title;?></option>
										<?php }?>
                                </select>
                            </div> 
                        	<div class="col-md-2 text-right"><h3>Payment:</h3></div>
                            <div class="col-md-2"><input type="text" name="payment" class="form-control" style="margin-top:20px"></div>
      						               
                        </div>
                        <div class="clearfixe">&nbsp;</div>
                        <div class="row">
                        	<div class="col-md-6 text-right"><h2>Detail</h2></div>
                            <div class="col-md-6"><textarea cols="61" rows="2" name="detail" class="form_control"></textarea></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-1">
                <input type="submit" name="submit" value="Add Invoice" class="btn btn-success">
            </div>
            &nbsp;
            <div class="col-md-1">
                <input type="submit" name="submit" value="Add & Print" class="btn btn-primary">
            </div>
        </div>
        <div class="row"><div class="col-md-3">&nbsp;</div></div>
        </form>
        <script>
		sevIndex = <?php echo --$count;?>;
		invIndex = 0;
		</script>
      
         
<?php $this->load->view("partial/footer"); ?>
