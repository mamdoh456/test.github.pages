<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url();?>assets/js/invoice.js"></script>
	<section class="content-header">
    <?php if(isset($success_message)){  ?>
		<div class="alert alert-success alert-dismissable">
        	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
       		<?php echo $success_message;?>        
        </div>
	<?php } ?>
          <h1>Invoice</h1>
    </section>
    <?php $ro = $invoice_head;?>
    <form style="form-inline"  id="supplierbill" method="post" action="<?php echo base_url()?>invoice/invoice_add_edit/<?php echo $ro->invoice_id;?>">
    	<!--<input type="hidden" name="bill_id" ng-model="bill_id" />-->
    	<div class="box box-default">
            <div class="box-body">
                <div class="row"><!-- /ROW start --> 
                    <div class="col-md-3">
                         <div class="form-group">
                                <label>Company Name</label>
                               <!-- <input type="text" class="form-control" name="bill_from" ng-model="bill_from" >-->
                         			<select class="form-control select2" name="company_name" id="company_name" style="width: 100%; " required onchange="check_accounts()">
                                      <?php 									  
											foreach ($customer as $r){
										if($r->account_id == $ro->invoice_to) $selected = 'selected="selected"';
											else $selected = '';
									 ?>
										<option value="<?php echo $r->account_id;?>" <?php echo $selected;?>><?php echo $r->account_title;?></option>
										<?php }?>
                                    </select>
                         </div><!-- /.form-group -->                     
                    </div><!-- /col 4 end --> 
                         <div class="col-md-3">
                         <div class="form-group">
                                <label>Invoice From</label>                             
                                    <select class="form-control select2" name="invoice_form" id="invoice_form" style="width: 100%; " required onchange="check_accounts()" >
                                      <?php 									
											foreach ($accounts as $a){
											if($a->account_id == $ro->invoice_from) $selected = 'selected="selected"';
											else $selected = '';
									 ?>
										<option value="<?php echo $a->account_id;?>" <?php echo $selected;?>><?php echo $a->account_title;?></option>
										<?php }?>
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
                                <select name="sale_type" class="form-control" required="required" >
                                	<option value="">Selecte here</option>
                                	<option value="sale" <?php if($ro->sale_type == 'sale') echo "selected='selected'";?>>Sale</option>
                                    <option value="return" <?php if($ro->sale_type == 'return') echo "selected='selected'";?>>Return</option>
                                </select>
                         </div><!-- /.form-group -->                     
                    </div>
                     
                     <div class="col-md-2">
                      <div class="form-group">
                        <label>Date range:</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar" ></i>
                          </div>
                           <input  type="text" class="form-control"id="example1" value="<?php  echo date_change_view($ro->date);?>" name="invoice_date" required>
                        </div><!-- /.input group -->
                      </div>    
                     </div>    
                        
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>Lot. No</label>
                                <input type="text" class="form-control" name="lot_no" id="lot_no" value="<?php echo $ro->lot_no;?>" >
                         </div><!-- /.form-group -->                     
                    </div><!-- /ecd col md 2 -->  
                            
                </div><!-- /ROW end -->                                   
                 <div class="row">
                 	<div class="col-md-2">
                         <div class="form-group">
                                <label>Invoice No.</label>
                                <input type="text" class="form-control" name="invoice_no" id="invoice_no" value="<?php echo $ro->invoice_no;?>" required>
                         </div><!-- /.form-group -->                     
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                	
                        <label>Vehicle No.</label>
                        <input type="text" class="form-control" name="vehical_no" value="<?php echo $ro->vehical_no;?>" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                	
                        <label>Phone No.</label>
                        <input type="text" class="form-control" name="phone_no" id="phone_no"  value="<?php echo $ro->phone_no;?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>Broker Name</label>
                                <select class="form-control select2" name="broker_id" id="broker" >
                                      <?php 
									  	echo "<option value=''>Select Name</option>";
											foreach ($broker as $br)
											{
												if($br->account_id == $ro->broker_id) $selected = 'selected="selected"'; else $selected = '';
												echo "<option value='$br->account_id' $selected>$br->account_title</option>";
											}
									  ?>
                                    </select>
                         </div><!-- /.form-group -->                     
                    </div>
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>No of Bales / Bags</label>
                                <input type="text" class="form-control" name="bales" id="bales"  value="<?php echo $ro->bales;?>" >
                         </div><!-- /.form-group -->                     
                    </div> 
                    <div class="col-md-2">
                         <div class="form-group">
                                <label>Gate Pass#</label>
                                <input type="text" class="form-control" name="gate_pass" id="gate_pass"    value="<?php echo $ro->gate_pass;?>">
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
                            <div class="col-md-2"><label>Weight</label></div>
                           <!-- <div class="col-md-2"><label>Kaat/Mun</label></div>-->
                            <div class="col-md-2"><label>Price</label></div>
                            <div class="col-md-2"><label>Total</label></div>
       					 </div>
                         <?php 
						 	$counter = 0;
							foreach ($invoice_inv as $row){ 
						 ?>
						<div class="form-group">
                    	<div class="row">
                            <div class="col-md-3">
                            <select name="inv_item_productid[]" id="<?php echo 'productid_'.$counter;?>" class="form-control required" >
                            	<!--<option value='<?php echo $row->inv_name;?>'><?php echo $row->item_title;?></option>-->
                            	<?php
									echo "<option value='$row->item_id~$row->item_type~$row->price~$row->weight_mun_bag'>$row->item_title</option>";
									foreach ($inv_items as $r)
										echo "<option value='$r->item_id~$r->item_type~$r->price~$r->weight_mun_bag'>$r->item_title</option>";
								?>
                                </select>                           
                            </div>
                            <div class="col-md-2">
                            <?php 
								if($row->item_type == 3){
									if((int)$row->weight === 0){
										$weight = $row->inv_quantity;
										}
									else{										
										$weight = $row->inv_quantity/$row->weight;
									}
									}
								else
									$weight = $row->inv_quantity;
							?>
                                <input type="text" class="form-control onchange quantity required" id="<?php echo 'inv_item_quantity_'.$counter;?>" name="inv_item_quantity[]" placeholder="Weight" value="<?php echo $weight;?>" />
                            </div>
                           <!-- <div class="col-md-2">
                                <input type="text" class="form-control onchange kaat required" id="inv_item_kaat_0" name="inv_item_kaat[]" placeholder="Kaat per Mun" value="<?php echo $row->kat;?>" />
                            </div>-->
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange price required" id="<?php echo 'inv_item_price_'.$counter;?>" name="inv_item_price[]" placeholder="Price" value="<?php echo $row->inv_price;?>"/>
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
									$kat = $row->kat;
									$result = ($quantity/$kat)*$price;
								}
							?>
                            <div class="col-md-2"><input type="text" value="<?php echo round($result,2)?>" id="<?php echo 'inv_item_total_'.$counter;?>" style="background: white; border: 0" class="subtotal inv_subtotal form-control" readonly /></div>
                            <div class="col-md-2">
                            <?php if($counter == 0){?>
                                <!--<button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>-->
                                <?php } else {?>
                                <button type="button" class="btn btn-danger removeButton"><i class="fa fa-minus"></i></button>
                                <?php }?>
                            </div>

                         </div>
                         
                         </div>
                         <?php $counter++; }?>
                        <!-- The template for adding new field -->
                        <div class="form-group hide" id="bookTemplate">
                        	<div class="row">
                           	 <div class="col-md-3">
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
                            <!--<div class="col-md-2">
                                <input type="text" class="form-control onchange kaat" id="inv_item_kaat" name="inv_item_kaat[]" placeholder="Kaat per Mun" />
                            </div>-->
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange price required" id="inv_item_price" name="inv_item_price[]" placeholder="Price" />
                            </div>
                            <div class="col-md-2"><input type="text" id="inv_item_total" class="subtotal form-control inv_subtotal" readonly style="background: white; border: 0"/></div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger removeButton"><i class="fa fa-minus"></i></button>
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
                     <!--<div class="col-md-2">-->
                     	<div class="col-md-2">
                            <button type="button" class="btn btn-success addButton"><i class="fa fa-plus"></i>Add Row</button>
                        </div>
                    <!-- </div>-->
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
                          <?php 
						  	$counter1 = 0;
							foreach ($invoice_sev as $sv){
						  ?>
                        <div class="form-group form-group1">					
                    	<div class="row">
                        <div class="col-md-1 ">
                        	<?php if($sv->check_value == -1){?>
                            	<input type="checkbox" value="<?php echo $counter1;?>" class="onchange add_to_bill" name="add_to_bill_from[]" id="<?php echo 'add_to_bill_from_'.$counter1;?>"  />
                                <?php } else { ?>
                                <input type="checkbox" value="<?php echo $counter1;?>" class="onchange add_to_bill" name="add_to_bill_from[]" id="<?php echo 'add_to_bill_from_'.$counter1;?>"  checked/>
                                <?php }?>
                            </div>
                            <div class="col-md-3">
                            <select name="sev_item_product[]" id="sev_item_product_0" class="form-control required sev_items search_data">
                            	<!--<option value="<?php echo $sv->item_id;?>"><?php echo $sv->item_title;?></option>-->
                            <?php
								echo "<option value='$sv->item_id~$sv->ratio'>$sv->item_title</option>";
									foreach ($serv_items as $r)
										echo "<option value='$r->item_id~$r->ratio'>$r->item_title</option>";
								?>
                                </select>
                            </div>
                            <div class="col-md-3">
                            <?php if($sv->check_value == -1){?>
                            <select name="sev_account[]" id="<?php echo 'sev_account_'.$counter1;?>" class="form-control sev_accounts required " byuser="no" >                            	
                            <?php
									echo "<option value='$sv->account_id'>$sv->account_title</option>";
									foreach ($account as $ac)
										echo "<option value='$ac->account_id'>$ac->account_title</option>";
								?>
                                </select>
                                <?php } else {?>
                                <select name="sev_account[]" id="<?php echo 'sev_account_'.$counter1;?>" class="form-control sev_accounts required " byuser="no" readonly >                            	
                            <?php
									echo "<option value='$sv->account_id'>$sv->account_title</option>";
									foreach ($account as $ac)
										echo "<option value='$ac->account_id'>$ac->account_title</option>";
								?>
                                </select>
                                <?php }?>
                            </div>
                            <div class="col-md-3">
                              <input type="text" class="form-control sev_onchange required subtotal sev_subtotal valid user_change" id="<?php echo 'sev_item_price_'.$counter1;?>" name="sev_item_price[]" placeholder="Amount" value="<?php echo $sv->sev_price;?>" byuserr="no"/>
                            </div>
                            <div class="col-md-1">
                            	<?php if($counter1 == 0){?>
                                <!--<button type="button" class="btn btn-default addButton1"><i class="fa fa-plus"></i></button>-->
                                <?php } else {?>
                                <button type="button" class="btn btn-danger removeButton1"><i class="fa fa-minus"></i></button>
                                <?php }?>
                            </div>
                            <div class="col-md-1 ">
                            <?php if($sv->subtract_from_bill == -1){?>
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
                            	<input type="checkbox" class="onchange add_to_bill" name="add_to_bill_from[]" id="add_to_bill_from" value="0" />
                            </div>
                           	 <div class="col-md-3 ">
                             <select name="sev_item_product[]" id="sev_item_product" class="form-control required sev_items search_data">
                             	<option value=''>Select Services</option>
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
                                <input type="text" class="form-control sev_onchange subtotal sev_subtotal user_change" id="sev_item_price" name="sev_item_price[]" placeholder="Price" byuserr = "no"/>
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
                        <?php foreach($bill_head as $row){}?>
                        <div class="col-md-2 text-right"><h3>Total Invoice to(<span id="totl_bill_from_name" class="small">---</span>)</h3></div>
                            <div class="col-md-2"><input type="text" name="supplier_total" value="<?php echo $ro->customer_total;?>" id="grand_total" class="form-comtrol" readonly style="background: white; border: 0; margin-top: 23px; font-size: 23px; color:red; font-weight:bold;" /></div>
                    		<div class="col-md-2 "><h3>Total Invoice from(<span id="totl_bill_to_name" class="small">---</span>)</h3></div>
                    		<div class="col-md-2" ><input type="text" name="grand_total" value="<?php echo $ro->invoice_total;?>" id="supplier_total" class="form-control" readonly style="background: white; border: 0; margin-top: 23px; font-size: 23px; color:red; font-weight:bold;"/></div>
                    	<div class="col-md-2">
                            	 <div class="form-group">
                                    <label>Tax Ratio</label>
                                    <input type="text" class="tax form-control onchange" value="<?php echo $ro->tax_ratio?>" name="tax_ratio" id="tax_ratio"  >
                            	 </div><!-- /.form-group -->                     
                       		 </div>
                             <div class="col-md-2">
                            	 <div class="form-group">
                                    <label>Tax Amount</label>
                                    <input type="text" class="form-control onchange" value="<?php echo $ro->tax_amount?>" name="tax_amount" id="tax_amount" readonly="readonly" style="background:#FFF; border:0" >
                            	 </div><!-- /.form-group -->                     
                       		 </div>
                        
                        </div>
                        <hr />
                         <div class="row">
                         <?php foreach ($invoice_transection as $tr) {echo $tr->payment_to;}?>
                        	<div class="col-md-6 text-right"><h3>Payment To:</h3></div>
                            <div class="col-md-2" style="line-height:70px;">
                            	<!--<select name="accounts" id="accounts" class="form-control select2" style="margin-top:25px">
                                	
                                	<?php foreach($accounts as $ac){?>
										<option value="<?php echo $ac->account_id;?>" <?php if($tr->payment_to == $ac->account_id) echo 'selected="selected"'?>><?php echo $ac->account_title;?></option>
										<?php }?>
                                </select>-->
                                
                                <select name="accounts" id="accounts" class="form-control select2">
                                	<?php 
										foreach($accounts as $ac){ 
											if($tr->payment_to == $ac->account_id) $selected = 'selected="selected"';
											else $selected = '';
										?>
										<option value="<?php echo $ac->account_id;?>" <?php echo $selected;?>><?php echo $ac->account_title;?></option>
										<?php }?>
                                </select>
                            </div> 
                        	<div class="col-md-2 text-right"><h3>Payment:</h3></div>
                            <div class="col-md-2"><input type="text" name="payment" value="<?php echo $ro->paid_amount;?>" class="form-control" style="margin-top:20px"></div>
      						               
                        </div>
                        <div class="clearfixe">&nbsp;</div>
                        <div class="row">
                        	<div class="col-md-6 text-right"><h2>Detail</h2></div>
                            <div class="col-md-6">
                            <textarea cols="61" rows="2" name="detail" class="form_control"><?php echo detail_db($tr->detail);?></textarea></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        	<!--<div class="col-md-1">
                <input type="submit" name="submit" value="Add Invoice" class="btn btn-success">
            </div>
        	<div class="col-md-2">
                <input type="submit" name="submit" value="Add/Edit Invoice" class="btn btn-primary">
            </div> -->
            &nbsp;
            <div class="col-md-1">
            	<a href="<?php echo base_url()?>invoice/invoice_print/<?php echo $ro->invoice_id; ?>">
                	<div class="btn btn-info">Print</div>
                </a>
            </div>           
        </div>
        <div class="row"><div class="col-md-3">&nbsp;</div></div>
        </form>
        <script>
		sevIndex = <?php echo --$counter1;?>;
		invIndex = <?php echo --$counter;?>;
		</script>
      
<!-- <script>
function calctotal()
{
	var grand_total = 0;
	var quantity_totall = 0;
	var inv_subtotall = 0;
	var sev_subtotal = 0;
	var tax =0;	
	
	$(".subtotal").each(function(index, element) {
		 if($.isNumeric($(element).val()))
		 {
			grand_total += parseFloat($(element).val());
			//grand_total = grand_total.toFixed(2);
		 }		
		
		});
	$(".quantity").each(function(index, element) {		
        if($.isNumeric($(element).val()))
		 {
			quantity_totall += parseFloat($(element).val());	
		 }
    });
	$('.inv_subtotal').each(function(index, element) {
       if($.isNumeric($(element).val()))
		 {
			inv_subtotall += parseFloat($(element).val());
			inv_balance_after_tax = inv_subtotall;
		 } 
    });
	
	if($.isNumeric($("#tax_ratio").val()))
	{
		var tax = (inv_subtotall*($("#tax_ratio").val()/100));
		inv_balance_after_tax = inv_subtotall-tax;
		$("#tax_amount").val(tax.toFixed(2));
		grand_total = grand_total-tax;
	}
	
	$('.sev_subtotal').each(function(index, element) {
       if($.isNumeric($(element).val()))
		 {
			sev_subtotal += parseFloat($(element).val());
		 } 
    });
	// $('#after_tax').html(after_tax.toFixed(2));
	$('#sev_subtotal').html(sev_subtotal.toFixed(2));
	$('#quantity_total').html(quantity_totall.toFixed(2));
	$('#inv_subtotal').html(inv_subtotall.toFixed(2));
	$('#inv_balance_after_tax').val(inv_balance_after_tax.toFixed(2))
	$('#grand_total').val(grand_total.toFixed(2));
}
$(document).ready(function() {
  
  var grand_total = 0;
  var mun = 40;
  $grand_total_ele = $('#grand_total');
  $('.onchange').keyup(function(){
	  		console.log('keypressed');
		  var ele = $(this);
		  var get_id = ele.attr('id').split('_');
		  var id = get_id[get_id.length-1];
		  
		  var quantity = $('#inv_item_quantity_'+id);
		  var kaat = parseFloat($('#inv_item_kaat_'+id).val());
		  //alert(kaat);
		  if($.isNumeric(kaat))
		  	mun = kaat;
		  else
		  	mun = 40;
			
		  var price = $('#inv_item_price_'+id);
		  var price = $('#inv_item_price_'+id);
		  
		  var total = (((parseFloat(quantity.val())/mun))*parseFloat(price.val()));
		  
		  if($.isNumeric(total))
		  {
			  $('#inv_item_total_'+id).val(total);
			  calctotal();
		  }		  
	});
	
	  
	var sev_total = 0;
	
  	$('.sev_onchange').keyup(function(){
	  	calctotal()
	});
	$('.tax').keyup(function(){
	  	calctotal()
	});
	
	
        bookIndex = <?php echo --$counter;?>;
    $('#supplierbill')
        .on('click', '.addButton', function() {
            bookIndex++;
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone(true)
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);

            // Update the name attributes  
            $clone
                .find('[id="inv_item_quantity"]').attr('id', 'inv_item_quantity_'+bookIndex).end()
				.find('[id="inv_item_kaat"]').attr('id', 'inv_item_kaat_'+bookIndex).end()
                .find('[id="inv_item_price"]').attr('id', 'inv_item_price_' + bookIndex).end()
				.find('[id="inv_item_total"]').attr('id', 'inv_item_total_' + bookIndex).end()

            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
          
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row  = $(this).parents('.form-group'),
            index = $row.attr('data-book-index');
			$row.remove();
			calctotal();
           
        });
		
		bookIndex = <?php echo --$counter1;?>;

    $('#supplierbill')
        .on('click', '.addButton1', function() {
            bookIndex++;
            var $template = $('#bookTemplate1'),
                $clone    = $template
                                .clone(true)
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index1', bookIndex)
                                .insertBefore($template);

            // Update the name attributes
            $clone
                .find('[id="sev_item_price"]').attr('id', 'sev_item_price_' + bookIndex ).end();

            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
          
        })

        // Remove button click handler
        .on('click', '.removeButton1', function() {
            var $row  = $(this).parents('.form-group1'),
            index = $row.attr('data-book-index1');
			$row.remove();
			calctotal();
        });
		
		$(".select2").select2();
		
		
		$("#supplierbill").validate({
								  rules: {
									company_name: {
									  required: true
									},
									bill_no: {
									  required: true
									}
								  }
								});
		jQuery.validator.addClassRules("required", {
			  required: true
			});
		
		
		
        $('#supplierbill').on('submit', function(event) {

            // adding rules for inputs with class 'comment'
            $('input.required').each(function() {
                $(this).rules("add", 
                    {
                        required: true
                    })
            });            

            // prevent default submit action         
           
        })

								
});
</script>-->          
<?php $this->load->view("partial/footer"); ?>
