<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
	<section class="content-header">
    <?php if(isset($message)){ echo $message;} ?>
          <h1><small>Account Details of</small>  "<?php echo $account_details[0]->account_title?>"</h1>
    </section>
    	<div class="box box-primary">
            <div class="box-body">
                <div class="row" id="colvis"><!-- /ROW start -->
                <table id="example1" class="table table-bordered table-striped">
                <!--------->
		<thead>
                	<tr>
                    	<th>Date</th>
                        <th>Detail</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Sub Total</th>
                    </tr></thead><tbody> 
                    <?php
						 
						$total = 0;
						$total += $account_details[0]->opening_balance;
						foreach($drcr as $t):
						?>
                       
                    <tr>
                    	<td><?php echo date_change_view($t->date)?></td>
                        <td><?php echo $t->detail?></td>
                        <?php 
							if($account_id == $t->payment_to)
							{
									$p_type  = 'Dr';
									$total -= $t->amount;
							}
							else
							{
									$p_type  = 'Cr';
									$total += $t->amount;
							}
							
						?>
                        <?php 
							if($p_type == 'Cr') $cr = $t->amount; else $cr = '';
							if($p_type == 'Dr') $dr = $t->amount; else $dr = '';
						
						?>
                        <td><?php echo $dr?></td>
                        <td><?php echo $cr?></td>
                        <td><?php echo $total?></td>
                    </tr>
		
                    <?php endforeach;?>
		</tbody>
		<tfoot>
		<tr>
                	<tr><td><h3>Opening Balance: <?php echo $account_details[0]->opening_balance?></h3></td></tr>                
                </tr>
</tfoot>
                </table> 
 
                            
                </div><!-- /ROW end -->                                   
            </div>
     	</div>
         
         
<?php $this->load->view("partial/footer"); ?>

