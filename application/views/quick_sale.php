<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url()?>plugins/jqvalidation/moment.min.js"></script>

<div id="container">
	<h1 align="center">Quick Sale </h1>

	<div id="body">
		<div class="box-body">
              <table width="100%" cellpadding="0" cellspacing="4" class="table">
              	 <tr>
              	<?php $counter = 0; foreach($quick_sale as $row){
					$id = $row->item_id;
					$name = $row->item_title;
					$price = $row->price;
					$weight = $row->weight_mun_bag;
					$item_type = $row->item_type;
					if(!$weight)
						$weight = 0;
						
					if($item_type == 3)
						$type = 'Bag';
					else if($item_type == 4)
						$type = 'Kg';
					else
						$type = 'Mun';
					
					
											
				
				?>
               
                	<td>
                    <div id="selector_<?php echo $id?>">
                	<!--<form action="<?php echo base_url()?>invoice/quick_sale" id="<?php echo $id;?>" method="post">-->
                    	<table cellspacing="4" cellpadding="4" class="table">
                        <tr>
                            	<td class="avoid-this">
                                	Item Name
                                </td>
                                <td>
                                	<input type="text" id="<?php echo 'item_name_'.$id?>" name="<?php echo 'item_name'?>" class="form-control" value="<?php echo $name.' : '.$price.'/'.$type;?>" readonly style="background: none; border: 0; font-size: 23px; color:red; font-weight:bold;">
                                    <input type="hidden" name="item_name" value="<?php echo $id.'~'.$weight.'~'.$item_type;?>">
                                </td>
                            </tr>
                            
                        	<tr>
                            	<td>
                                	Weight / Bag
                                </td>
                                <td>
                                	<input type="text" id="<?php echo 'item_weight_'.$id?>" name="<?php echo 'item_weight'?>" class="form-control " onkeyup="calculate_amount(event,<?php echo $id.','.$item_type.','.$weight.','.$price;?>)" required="required"  autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Amount
                                </td>
                                <td>
                                	<input type="text" id="<?php echo 'item_price_'.$id?>" name="<?php echo 'item_price'?>" class="form-control calculate" onkeyup="calculate_weight(event,<?php echo $id.','.$item_type.','.$weight.','.$price;?>)" required="required" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Discount
                                </td>
                                <td>
                                	<input type="text" id="<?php echo 'item_discount_'.$id?>" name="<?php echo 'item_discount'?>" class="form-control calculate" onkeyup="discount(event,<?php echo $id.','.$item_type.','.$weight.','.$price;?>)"  autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Total
                                </td>
                                <td>
                                	<input type="text" id="<?php echo 'item_total_'.$id?>" name="<?php echo 'item_total'?>" class="form-control" readonly style="background: none; border: 0; font-size: 23px; color:red; font-weight:bold;">
                                </td>
                            </tr>
                            <!--<tr>
                            	<td>&nbsp;</td>
                            	<td>
                                	<input type="submit" name="save" value="save" class="btn btn-large btn-primary" onclick="">
                                   <!-- <input type="submit" value="Print" class="simplePrint " onclick="jQuery.print('#selector_'+<?php echo $id;?>)"/>-
                                </td>                                
                            </tr>-->
                        </table>
                    <!--</form>-->
                    </div>
                    </td>
                   
                
                <?php 
				$counter++;
				if($counter%3==0)
					echo "<tr></tr>";	
				 }?>
                 </tr>
              </table>                  
        </div>
	</div>
</div>
<input type="button" value="print" id="printitbtn"/>
<div style="display:none">
<table id="printit">
	<tr><td><h2>IDLBridge </h2></td></tr>
	<tr><td><h3>Lahore (Punjab Pakistan)</h3></td></tr>	
    <tr><td>Item</td><td id="prntname"></td></tr>
    <tr><td>Weight/Qty</td><td id="prntqty"></td></tr>
    <tr><td>Aamount</td><td id="prntamount"></td></tr>
    <tr><td>Discount</td><td id="prntdisc"></td></tr>
    <tr><td>Total</td><td id="prntttl"></td></tr>
</table>
</div>
<script>
$(function(){
	$("#printitbtn").click(function() {
             printElem({ printMode: 'popup' });
         });
})
function printElem(options){
     $('#printit').printElement(options);
 }
function calculate_amount(event,id,type,weight,price){
	if(event.keyCode == 13){
        $('#item_discount_'+id).focus();
    }
	var name = $('#item_name_'+id).val();
	var discount = $('#item_discount_'+id).val();
	var quantity = $('#item_weight_'+id).val();
	var new_total = 0;
	if(type == 3 || type == 4){		
			var total = quantity*price;
			$('#item_total_'+id).val(total);
			$('#item_price_'+id).val(total);
			new_total = total;	
	}
	else
	{
			var total = (quantity/weight)*price;
			$('#item_total_'+id).val(total);
			$('#item_price_'+id).val(total);
			new_total = total;
	}
	if(discount){
		var new_total = $('#item_price_'+id).val()-discount;
		$('#item_total_'+id).val(new_total);
	}
	
	$("#prntname").html(name);
	$("#prntqty").html(quantity);
	$("#prntamount").html(total);
	$("#prntdisc").html(discount);
	$("#prntttl").html(new_total);
}

function discount(event,id,item_type,weight,price){
		var name = $('#item_name_'+id).val();
		var discount = $('#item_discount_'+id).val();
		var quantity = $('#item_weight_'+id).val();
		var new_total = $('#item_price_'+id).val()-discount;		
		$('#item_total_'+id).val(new_total);
		
		$("#prntname").html(name);
		$("#prntdisc").html(discount);
		$("#prntttl").html(new_total);
		
		
		if(event.keyCode == 13){
        	$.ajax({
			  method: "POST",
			  url: "<?php echo site_url()?>invoice/quick_sale",
			  data: { item_id:id,quantity: quantity,price:price,weight_mun_bag:weight,discount:discount,total:new_total }
			})
		  .done(function( msg ) {
			alert( "Data Saved: " + msg );
		  });
		 // $("#printitbtn").submit(function(){
			   printElem({ printMode: 'popup' });
			//  });
    	}
		
		
	}


function calculate_weight(event,id,type,weight,price){
	
	if(event.keyCode == 13){
        $('#item_discount_'+id).focus();
    }
	var name = $('#item_name_'+id).val();
	var discount = $('#item_discount_'+id).val();
	var amount = $('#item_price_'+id).val();
	var new_total = 0;
	
	if(type == 3 || type == 4){		
		var quantity = amount/price;
		//$('#item_total_'+id).val(total);
		$('#item_weight_'+id).val(quantity);
		$('#item_total_'+id).val(amount);
		new_total = amount;
	}
	else
	{
		var quantity = (amount/price)*weight;
		$('#item_weight_'+id).val(quantity);
		$('#item_total_'+id).val(amount);
		new_total = amount;
	}
	if(discount){
		var new_total = $('#item_price_'+id).val()-discount;
		$('#item_total_'+id).val(new_total);
	}
		
		$("#prntname").html(name);
		$("#prntqty").html(quantity);
		$("#prntamount").html(amount);
		$("#prntdisc").html(discount);
		$("#prntttl").html(new_total);
}
function fun(){
	alert('test');}

</script>



<?php $this->load->view("partial/footer"); ?>