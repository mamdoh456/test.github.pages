<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url();?>assets/js/bill.js"></script>
	<section class="content-header">
    <?php if(isset($success_message)){  ?>
		<div class="alert alert-success alert-dismissable">
        	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
       		<?php echo $success_message;?>        
        </div>
	<?php } ?>
          <h1>Bill</h1>
    </section>
    <?php foreach($bill_head as $row){}  echo $success;?>
    <form style="form-inline"  id="supplierbill" method="post" action="<?php echo base_url()?>supplier/bill_insertion/<?php echo $row->bill_id?>">
    	
    	<div class="box box-default">
            <div class="box-body">
                <div class="row"><!-- /ROW start -->                     
                    <div class="col-md-3">
                         <div class="form-group">
                                <label>Company Name(Bill From)</label>
                               <!-- <input type="text" class="form-control" name="bill_from" value="<?php echo $row->bill_from;?>" >-->
                                 <select class="form-control select2" name="company_name" id="company_name" style="width: 100%; " required onchange="check_accounts()">
                                      <?php 
										foreach ($customer as $r)
										{
											if($r->account_id == $row->bill_from) $selected = 'selected="selected"';
											else $selected = '';
											echo "<option value='$r->account_id' $selected>$r->account_title</option>";
										}
									  ?>
                                    </select>  
                         </div><!-- /.form-group -->                     
                    </div><!-- /col 4 end --> 
                        <div class="col-md-3">
                         <div class="form-group">
                                <label>Bill To:</label>
                               <!-- <input type="text" class="form-control" name="bill_from" ng-model="bill_from" >-->
                                    <select class="form-control select2" name="bill_to"  id="bill_to" style="width: 100%; " required onchange="check_accounts()" >
                                    <option value="">Select Bill to Account</option>
                                     <?php 
									 	foreach($accounts as $ac){
											if($ac->account_id == $row->bill_to) $selected = 'selected="selected"';
											else $selected = '';	
										?>
										<option value="<?php echo $ac->account_id;?>" <?php echo $selected;?>><?php echo $ac->account_title;?></option>
										<?php }?>
                                    </select>
                         </div><!-- /.form-group -->                     
                    </div>
                            
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
                                	<option value="sale" <?php if($row->sale_type == 'sale') echo "selected='selected'"?> >Sale</option>
                                    <option value="return" <?php if($row->sale_type == 'return') echo "selected='selected'"?>>Return</option>
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
                           <input  type="text" class="form-control"id="example1" name="bill_date" value="<?php echo date_change_view($row->bill_date)?>" required >
                        </div><!-- /.input group -->
                      </div>    
                     </div>    
                            
                </div><!-- /ROW end -->                                   
                 <div class="row">
                 	<div class="col-md-2">
                         <div class="form-group">
                                <label>Bill No.</label>
                                <input type="text" class="form-control" name="bill_no" id="invoice-number" value="<?php echo $row->bill_no;?>" required>
                         </div><!-- /.form-group -->                     
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                	
                        <label>Vehicle No.</label>
                        <input type="text" class="form-control" name="vehical_no" value="<?php echo $row->vehical_no;?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                	
                        <label>Phone No.</label>
                        <input type="text" class="form-control" name="phone" id="phone_no" value="<?php echo $row->phone_no;?>">
                        </div>
                    </div>
                     <div class="col-md-2">
                         <div class="form-group">
                                <label>Broker Name</label>
                                <select class="form-control select2" name="broker" id="broker" >
                                      <?php 
									  	echo "<option value='$row->account_id'>$row->account_title</option>";
											foreach ($broker as $br)
										echo "<option value='$br->account_id'>$br->account_title</option>";
									  ?>
                                    </select>
                         </div><!-- /.form-group -->                     
                    </div> 
                     <div class="col-md-2">
                         <div class="form-group">
                                <label>No of Bales / Bags</label>
                                <input type="text" class="form-control" name="bales" id="bales" value="<?php echo $row->bales;?>" >
                         </div><!-- /.form-group -->                     
                    </div> 
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>Gate Pass#</label>
                                <input type="text" class="form-control" name="gate_pass" id="gate_pass" value="<?php echo $row->gate_pass;?>">
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
                            <div class="col-md-2"><label>Price</label></div>
                            <div class="col-md-2"><label>Total</label></div>
       					 </div>
                         <?php 
						 $counter=0;
						 foreach($bill_inv as $row){ ?>
						<div class="form-group" >
                    	<div class="row">
                            <div class="col-md-3">
                            <select name="inv_item_productid[]" id="<?php echo 'productid_'.$counter?>" class="form-control required" >
                            <?php
									echo "<option value='$row->item_id~$row->item_type~$row->price~$row->weight_mun_bag'>$row->item_title</option>";
									foreach ($inv_items as $r)
										//echo "<option value='$r->item_id'>$r->item_title</option>";
										echo "<option value='$r->item_id~$r->item_type~$r->price~$r->weight_mun_bag'>$r->item_title</option>";
									
								?>  
                              </select>                         
                            </div>
                            <div class="col-md-2">
                            <?php 
								
								if($row->item_type == 3){
									if((int)$row->weight === 0)
										$weight = $row->inv_quantity;
									else
										$weight = $row->inv_quantity/$row->weight;
									}
								else
									$weight = $row->inv_quantity;
							?>
                                <input type="text" class="form-control onchange quantity required" id="<?php echo 'inv_item_quantity_'.$counter;?>" name="inv_item_quantity[]" placeholder="Quantity" value="<?php echo $weight?>" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange price required" id="<?php echo 'inv_item_price_'.$counter;?>" name="inv_item_price[]" placeholder="Price" value="<?php echo $row->inv_price?>" />
                            </div>
                            <?php 
								if($row->item_type == 3){
									$result = $weight*$row->inv_price;
								}
								elseif($row->item_type == 4)
									$result = $row->inv_quantity*$row->inv_price;
								else{
									$quantity = $row->inv_quantity;
									$price = $row->inv_price;
									$kat = $row->weight_mun_bag;
									$result = ($quantity/$kat)*$price;
								}
							?>
                            <div class="col-md-2"><input type="text" value="<?php echo round($result,2)?>" id="<?php echo 'inv_item_total_'.$counter;?>" class="subtotal inv_subtotal"  style="background: white; border: 0" readonly/></div>
                            <div class="col-md-2">
                            	<?php if($counter == 0){?>
                                <!--<button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>-->
                                <?php } else{ ?>
                                	<button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                 <?php } ?>
                            </div>

                         </div>
                         
                         </div>
                         <?php $counter++; } ?>
                        <!-- The template for adding new field -->
                        <div class="form-group hide" id="bookTemplate">
                        	<div class="row">
                           	 <div class="col-md-3 ">
                             <select name="inv_item_productid[]" id="productid" class="form-control required">
                            <?php
									echo "<option value=''>Select Inventiories</option>";
									foreach ($inv_items as $r){
									//echo "<option value='$r->item_id'>$r->item_title</option>";
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
                             <div class="col-md-2"><input type="text" id="inv_item_total" class="subtotal inv_subtotal" readonly style="background: white; border: 0" /></div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="bookTemplate">
                    	<div class="row">
                        	<div class="col-md-3 text-right"><h4>Sub Total</h4></div>
                            <div class="col-md-2 text-center" ><h4 id="quantity_total"></h4></div>
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-2 text-center" ><h4 id="inv_subtotal"></h4></div>
                        </div>
                     </div>
                     <div class="col-md-1">
                     <button type="button" class="btn btn-success addButton"><i class="fa fa-plus"></i> Add Row</button>
                     </div>                    
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-5">
            	<div class="box box-default">
            		<div class="box-body">
                		 <div class="row">
                         	<div class="col-md-1">&nbsp;</div>
				        	<div class="col-md-3"><label>Discription</label></div>
                            <div class="col-md-3"><label>Accounts</label></div>
            				<div class="col-md-3"><label>Amount</label></div>
        				  </div>
                          <?php 
						  	$counter1=0;
						 foreach($bill_sev as $ro){
						  ?>
                        <div class="form-group1 form-group">					
                    	<div class="row">
                        <div class="col-md-1 ">
                        	<?php if($ro->check_value == -1){?>
                            	<input type="checkbox" value="<?php echo $counter1;?>" class="onchange add_to_bill" name="add_to_bill_from[]" id="<?php echo 'add_to_bill_from_'.$counter1;?>"  />
                                <?php } else { ?>
                                <input type="checkbox" value="<?php echo $counter1;?>" class="onchange add_to_bill" name="add_to_bill_from[]" id="<?php echo 'add_to_bill_from_'.$counter1;?>"  checked/>
                                <?php }?>
                            </div>
                            <div class="col-md-3">                          
                            <select name="sev_item_product[]" id="<?php echo 'sev_item_product_'.$counter1?>" class="form-control required sev_items search_data" >
                            <?php
									echo "<option value='$ro->item_id~$ro->ratio'>$ro->item_title</option>";
									foreach ($serv_items as $r)
										echo "<option value='$r->item_id~$r->ratio'>$r->item_title</option>";
									
								?>
                            </select>
                             
                            </div>
                            <div class="col-md-3">
                            <?php if($ro->check_value == -1){?>
                            <select name="sev_account[]" id="<?php echo 'sev_account_'.$counter1;?>" class="form-control sev_accounts required " byuser="no" >                            	
                            <?php
									echo "<option value='$ro->account_id'>$ro->account_title</option>";
									foreach ($account as $ac)
										echo "<option value='$ac->account_id'>$ac->account_title</option>";
								?>
                                </select>
                                <?php } else {?>
                                <select name="sev_account[]" id="<?php echo 'sev_account_'.$counter1;?>" class="form-control sev_accounts required " byuser="no" readonly >                            	
                            <?php
									echo "<option value='$ro->account_id'>$ro->account_title</option>";
									foreach ($account as $ac)
										echo "<option value='$ac->account_id'>$ac->account_title</option>";
								?>
                                </select>
                                <?php }?>
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control sev_onchange required subtotal sev_subtotal valid user_change" id="<?php echo 'sev_item_price_'.$counter1;?>" name="sev_item_price[]" placeholder="Amount" value="<?php echo $ro->sev_price?>" byuserr="no"/>
                            </div>
                            <div class="col-md-1">
                            	<?php if($counter1 == 0){?>
                                <!--<button type="button" class="btn btn-default addButton1"><i class="fa fa-plus"></i></button>-->
                                <?php } else {?>
                                <button type="button" class="btn btn-danger removeButton1"><i class="fa fa-minus"></i></button>
                                <?php }?>
                            </div>
                            <div class="col-md-1 ">
                            <?php if($ro->subtract_from_bill == -1){?>
                            	<input type="checkbox" class="onchange subtract_from_bill" name="subtract_from_bill[]" id="<?php echo 'subtract_from_bill_'.$counter1;?>" value="<?php echo $counter1;?>" />
                            <?php } else {?>
                            <input type="checkbox" class="onchange subtract_from_bill" name="subtract_from_bill[]" id="<?php echo 'subtract_from_bill_'.$counter1;?>" value="<?php echo $counter1;?>"  checked="checked"/>
                            <?php }?>
                            </div> 
                         </div>
                         </div>
                         <?php $counter1++; }?>
                        <!-- The template for adding new field -->
                        <div class="form-group1 form-group hide" id="bookTemplate1">
                        	<div class="row">
                            <div class="col-md-1 ">
                            	<input type="checkbox" class="onchange add_to_bill" name="add_to_bill_from[]" id="add_to_bill_from" value="0"  />
                            </div>
                           	 <div class="col-md-3 ">
                             
                             <select name="sev_item_product[]" id="sev_item_product" class="form-control sev_items search_data">
                             <option value="">Select Services</option>
                            <?php
									
									foreach ($serv_items as $r){
									echo "<option value='$r->item_id~$r->ratio'>$r->item_title</option>";
									}
								?>
                                </select>
                                </div>
                                <div class="col-md-3">
                            <select name="sev_account[]" id="sev_account" class="form-control required sev_accounts" byuser="no">
                            	<option value="">Select Account</option>
                            <?php									
									foreach ($account as $ac)
										echo "<option value='$ac->account_id'>$ac->account_title</option>";
								?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control sev_onchange subtotal sev_subtotal user_change" id="sev_item_price" name="sev_item_price[]" placeholder="Price" byuserr="no" />
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
	                     <button type="button" class="btn btn-success addButton1"><i class="fa fa-plus"></i> Add Row</button>
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
                        <?php foreach($bill_head as $row){}?>
                        <div class="col-md-2 text-right"><h3>Total Bill from(<span id="totl_bill_from_name" class="small">---</span>)</h3></div>
                            <div class="col-md-2"><input type="text" name="supplier_total" value="<?php echo $row->supplier_total;?>" id="supplier_total" class="form-comtrol" readonly style="background: white; border: 0; margin-top: 23px; font-size: 23px; color:red; font-weight:bold;" /></div>
                    		<div class="col-md-2 "><h3>Total Bill to (<span id="totl_bill_to_name" class="small">---</span>)</h3></div>
                    		<div class="col-md-2" ><input type="text" name="grand_total" value="<?php echo $row->grand_total;?>" id="grand_total" class="form-control" readonly style="background: white; border: 0; margin-top: 23px; font-size: 23px; color:red; font-weight:bold;"/></div>
                    	<div class="col-md-2">
                            	 <div class="form-group">
                                    <label>Tax Ratio</label>
                                    <input type="text" class="tax form-control onchange" value="<?php echo $row->tax_ratio?>" name="tax_ratio" id="tax_ratio"  >
                            	 </div><!-- /.form-group -->                     
                       		 </div>
                             <div class="col-md-2">
                            	 <div class="form-group">
                                    <label>Tax Amount</label>
                                    <input type="text" class="form-control onchange" value="<?php echo $row->tax_amount?>" name="tax_amount" id="tax_amount" readonly="readonly" style="background:#FFF; border:0" >
                            	 </div><!-- /.form-group -->                     
                       		 </div>
                        
                        </div>
                        <hr />
                    		
                        <div class="row">
                        	<div class="col-md-5 text-right"><h3>Payment From:</h3></div>
                            <div class="col-md-2" style="line-height:70px;">
                            	<select name="payment_from" id="payment_from" class="form-control select2">
                                	<?php 
										foreach($accounts as $ac){ 
											if($row->payment_from == $ac->account_id) $selected = 'selected="selected"';
											else $selected = '';
										?>
										<option value="<?php echo $ac->account_id;?>" <?php echo $selected;?>><?php echo $ac->account_title;?></option>
										<?php }?>
                                </select>
                            </div>
                        	<div class="col-md-2 text-right"><h3>Amount:</h3></div>                            
                            <div class="col-md-2"><input type="text" name="payment" value="<?php echo $row->paid_amount;?>" class="form-control" style="margin-top:25px"></div>
                      		 
                        </div>
                        <div class="clearfixe">&nbsp;</div>
                        <div class="row">
                        	<div class="col-md-6 text-right"><h3>Detail</h3></div>
                            <div class="col-md-6"><textarea cols="61" rows="2" name="detail" class="form_control"><?php echo detail_db($tr->detail);?></textarea></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        	<!--<div class="col-md-1">
                <input type="submit" name="submit" value="Add Bill" class="btn btn-success">
            </div>
            <div class="col-md-1">
                <input type="submit" name="submit" value="Add/Edit Bill" class="btn btn-primary">
            </div>-->
            <div class="col-md-1">
            	<a href="<?php echo base_url()?>supplier/bill_print/<?php echo $row->bill_id; ?>">
                	<div class="btn btn-info">Print</div>
                </a>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        </form>
        
        <script>
		sevIndex = <?php echo --$counter1;?>;
		invIndex = <?php echo --$counter;?>;
		</script>
 
<!-- Modal -->
<div id="myModal" class="modal">
<div class="modal-dialog">

    <!-- Modal content  data-target="#myModal"-->
    <div class="modal-content">
      <div class="modal-header">
      	<input type="hidden" id="active_row" />
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Calculate Dami</h4>
      </div>
      <div class="modal-body">
        Dami Ratio:<input type="text" name="dami_ratio" id="dami_ratio" onkeyup="calcdami();">&nbsp;&nbsp;&nbsp;&nbsp; Total Dami:<div id="total_dami"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="filldami()">Fill Dami</button>
      </div>
    </div>
  </div>
 </div>          
<?php $this->load->view("partial/footer"); ?>
