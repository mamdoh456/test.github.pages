<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<script src="<?php echo base_url()?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<title> Invoice</title>
	
	 <link rel="stylesheet" href="<?php echo base_url();?>/plugins/print.css">
	
</head>

<body>

	<div id="page-wrap">
<?php // print_r($invoice_transection); 
foreach($invoice_transection as $tr);?>

		<textarea id="header">Invoice</textarea>
		
		<div id="identity" style="font-weight:bold; text-align:center; font-size:20px;">
         	<h1>IDLBridge</h1>
            <div >
            	Lahore (Punjab Pakistan)<br>
            </div>
		</div>
		
		<div style="clear:both; padding-bottom:25px"></div>
		
		<div id="customer">
			<?php $ro = $invoice_head;?>
            <div id="customer-title">
            	Name: <?php echo $ro->account_title.'<br>';?>
				Address: <?php echo $ro->address.'<br>';?>
                Phone #: <?php echo $ro->phone; ?>
            </div>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><?php echo $ro->invoice_no;?></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id="date"><?php echo date_change_view($ro->date);?></textarea></td>
                </tr>              

            </table>
		
		</div>
		
		<table id="items">
			<tr><th colspan="4">Inventories</th></tr>
		  <tr>
		      <th class="item-name">Item</th>
		      <th>Weight</th>
		      <th>Rate</th>
		      <th>Total</th>
		  </tr>
		  <?php foreach($invoice_inv as $inv){
			  if($inv->item_type == 3)
			  {	
			  		if((int)$inv->kat === 0){
						$quantity = $inv->inv_quantity;
						$weight = $inv->inv_quantity;
					}
					else {
						$quantity = $inv->inv_quantity/$inv->kat;
						$weight  = $inv->inv_quantity/$inv->kat;
					}
				
				}
			else
			{
				$quantity = $inv->inv_quantity/$inv->kat;
				$weight = 	$inv->inv_quantity;			
			}
			$total1 = $quantity * $inv->inv_price;
			$inv_total += $total1;
			$total_weight += $weight;
			
			?>
            <tr class="item-row">
		      <td class="item-name"><?php echo $inv->item_title;?></td>
		      <td><?php echo $weight;?></td>
		      <td><?php echo $inv->inv_price;?></td>
		      <td><?php echo round($total1,2);?></td>
		  </tr>
          
			<?php }?>
            <tr>
            	<td>Total Weight/Bags</td>
                <td><?php echo round($total_weight,2);?></td>
            	<td>Total Inventories</td>
                <td><?php echo round($inv_total,2);?></td>
            </tr>		  
		  <tr><th colspan="4">Services</th></tr>
          <tr>
          	<th colspan="2">Service Name</th>
            <!--<th colspan="2">Account</th>-->
            <th colspan="2">Amount</th>
          </tr>
          <?php $total_sub1 = 0; foreach($invoice_sev as $sev){
			  $sev_total += $sev->sev_price;
			  $subtract = $sev->subtract_from_bill;
			  if($sev->account_id == $ro->account_id)
			  {
				 $total_sub1 += $sev->sev_price;  
			}
			//else echo "not";
			
			  ?>
              <tr class="item-row">
                  <td class="item-name" colspan="2"><?php echo $sev->item_title;?></td>
                  <!--<td colspan="2" class="item-name"><?php echo $sev->account_title;?></td>-->
                  <?php if($subtract >=0){
					  $total_sub += $sev->sev_price;
					  ?>
                  		<td colspan="2"><?php echo -$sev->sev_price;?></td>
                  		<?php } else{
							$total_add += $sev->sev_price;
							?>
                  		<td colspan="2"><?php echo $sev->sev_price;?></td>
                  		<?php }?>
              </tr>
			  <?php } 
			  		$sev_total1 = $total_add - $total_sub;
			  ?>              
		  
          <tr>
		      <td colspan="2" class="blank"> </td>
		      <td  class="total-line">Services Subtract total</td>
		      <td class="total-value"><div id="subtotal">Rs. <?php echo $total_sub;?></div></td>
		  </tr>
          <tr>
		      <td colspan="2" class="blank"> </td>
		      <td  class="total-line">Services Add Subtotal</td>
		      <td class="total-value"><div id="subtotal">Rs. <?php echo $total_add;?></div></td>
		  </tr>
          <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="1" class="total-line">Tax</td>
		      <td class="total-value"><?php echo $ro->tax_amount;?></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="1" class="total-line">Total Invoice</td>
		      <td class="total-value"><div id="total"><?php echo $total_inv = $ro->customer_total-$total_sub1;?></div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="1" class="total-line">Amount Paid</td>
		      <td class="total-value"><?php echo $ro->paid_amount;?></td>
		  </tr>
          
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="1" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due"><?php echo $total_inv-$ro->paid_amount;?></div></td>
		  </tr>
		<?php foreach($total as $tt) ?>
        <?php foreach($total_dr as $ttt)
			$total_due = $ttt->amount_sum - $tt->amount_sum;
		?>
		</table>
        <table id="items">
        	<tr>
            	<td style="text-align:right" class="balance">Total Dr.</td>
                <td colspan="1"><?php echo $ttt->amount_sum;?></td>
            </tr>
            <tr>
            	<td class="balance"style="text-align:right">Total Cr.</td>
                <td colspan="1"><?php echo $tt->amount_sum;?></td>
            </tr>
            <tr>
            	<td class="balance"style="text-align:right">Total Due</td>
                <td colspan="1"><?php echo round($total_due,2);?></td>
            </tr>
        </table>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <!--<div>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</div>-->
		</div>
		<div id="footer">Powerd By IDLBridge Phone # 03457050405</div>
	</div>
	
    <script>
$(document).ready(function(){
     window.print() ;
}); 

</script>
</body>

</html>