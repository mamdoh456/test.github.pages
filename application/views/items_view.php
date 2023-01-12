<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><?php $this->load->view("partial/header"); ?>
	 <section class="content-header">
          <h1>
            Add/Edit Items
            <small>Inventory and Survices items</small>
          </h1>
        </section>
        <section class="content" data-ng-controller="ItemsCtrl">

          <!-- SELECT2 EXAMPLE -->
          <div class="row">
          <div class="col-md-6">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Item Detail</h3>
            </div><!-- /.box-header -->
            <?php
				//echo sizeof($item);
            	if(sizeof($item)>0)
				{					
					$serv = '';
					$invent = '';
					$fixed = '';
					$item_title = ($item->item_title)? $item->item_title : '';
					if($item->group_id == 1)
					{ 
						$ratio = '';
						$serv = 'checked="checked"'; 
						$serv_item = '';
						$invent_item = 'disabled="disabled"';
						$weight_mun = 'disabled="disabled"'; 
						$price_mun = 'disabled="disabled"';
					}
					else 
					{													
						if($item->item_type == 5 || $item->item_type == 3){
							$weight_mun = '';
							}
						else
						$weight_mun = 'disabled="disabled"'; 
						
						$invent = 'checked="checked"';
						$serv_item = 'disabled="disabled"';
						$ratio = 'disabled="disabled"';
						$invent_item = '';						
					}
					
					$action = base_url().'items/update_item';
				}
				else
					$action = base_url().'items/add_item';
			?>
            <form style="form-inline" method="post" action="<?php echo $action?>" >
            <input type="hidden" name="item_id" value="<?php echo $item->item_id?>" />
            <div class="box-body">
            	<div class="row">
                	<div class="col-md-6">
                          <div class="form-group">
                            <label>Item Title</label>
                            <input type="text" class="form-control" name="item_title" value="<?php echo $item_title;?>"  required>
                          </div><!-- /.form-group -->
                     </div>
                </div>
                <div class="row">
                     <div class="col-md-3">
                     	  <div class="form-group">
                            <label>
                              <input type="radio" name="r2" class=" services" <?php echo $serv?>>
                              Services
                            </label>
                          </div><!-- /.form-group -->
                          <div class="form-group">
                            <label>Select Services</label>
                            <select class="form-control services_select" name="item_type" style="width: 100%;" <?php echo $serv_item;?> required>
                             <?php 
							if($item->item_type){
								echo '<option value="'.$item->item_type.'">'.$item->title.'</option>';
								}
							else
								{
									echo '<option value="1">add to bill</option>';
								}
							?>
                              <option value="1">add to bill</option>
                              <option value="2">subtract from bill</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>
                            <?php if($item->fixed){?>
                              <input type="checkbox" name="fixed" class="fixed" id="fixed" value="yes" checked>
                              <?php } else {?>
                              <input type="checkbox" name="fixed" class="fixed" id="fixed" value="yes" >
                              <?php }?>
                              Show on Front
                            </label>
                          </div><!-- /.form-group -->
                          <div class="form-group">
                          <label>
                          Ratio 
                          <input type="text" class="form-control ratio" name="ratio" id="ratio" <?php echo $ratio;?> required="required" value="<?php echo $item->ratio;?>">                          
                          </label>                           
                          </div>
                     </div>
                     <div class="col-md-3">
                     	<div class="form-group">
                            <label>
                              <input type="radio" name="r2" class="inventory" <?php echo $invent?>>
                              Inventory Items
                            </label>
                          </div><!-- /.form-group -->
                          <div class="form-group">
                            <label>Select Inventory Items</label>
                            <select class="form-control inventory_select" onchange="weight()" id="item_type" name="item_type" style="width: 100%;" <?php echo $invent_item ;?>>
                            <?php 
							if($item->item_type){
								echo '<option value="'.$item->item_type.'">'.$item->title.'</option>';
								}
							else
								{
									echo '<option value="3">one Bag</option>';
								}
							?>
                              <option value="3">one Bag</option>
                              <option value="4">weight in kg</option>
                              <option value="5">weight in mun</option>
                            </select>
                          </div>
                          <div class="form-group">
                          <label id="label_show"></label>                          
                          <input type="text" class="form-control wieght_mun" name="weight_mun_bag" id="weight_mun" <?php echo $weight_mun;?> required="required" value="<?php echo $item->weight_mun_bag;?>">                          
                          
                          </div>
                          <div class="form-group">
                          <label id="show_label_price"></label>                          
                          <input type="text" class="form-control price_mun" name="price_mun" id="price_mun" <?php echo $price_mun;?> required="required" value="<?php echo $item->price;?>">                                                    
                          </div>
                          <div class="form-group">
                            <label>
                            <?php if($item->quick_sale == 'yes'){?>
                              <input type="checkbox" name="quick_sale" class="quick_sale" id="quick_sale" value="yes" checked>
                              <?php } else {?>
                              <input type="checkbox" name="quick_sale" class="quick_sale" id="quick_sale" value="yes" >
                              <?php }?>
                              Show as Quick Sale
                            </label>
                          </div><!--form group-->
                     </div>                     
                </div><!--end row-->
                <div class="row">
                	<div class="col-md-3">
                    	<input type="submit" value="submit" class="btn btn-primary">
                    </div>
                </div>
            </div> <!--end box body-->
            </form>
         </div>
         </div><!--end box-->
         <div class="col-md-6">
         <div class="box box-primary">
         	<div class="box-header with-border">
              <h3 class="box-title">Item Detail</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	<table class="table table-hover">
					<thead>
						<tr>
							<th style="width:50px">#</th>
							<th width="20%">Item Title</th>
							<th style="width:20%; text-align:center">Item Type</th>
                            <th style="width:20%; text-align:center">Type Group</th>
							<th style="width:20%; text-align:center">Action</th>
						</tr>
					</thead>
					<tbody>
                    	<?php $count = 1; foreach($items as $item) : ?>
						<tr data-ng-repeat="task in tasks track by $index">                        	
							<td><?php echo $count;?></td>
							<td><?php echo $item->item_title?></td>
							<td style="text-align:center"><?php echo $item->title?></td>
                            <td style="text-align:center"><?php echo ($item->group_id == 1)? 'Services':'Inventory'?></td>
							<td style="text-align:center"><a class="btn btn-xs btn-success" href="<?php echo base_url()?>items/item_update/<?php echo $item->item_id?>" title="Edit Item"><span class="fa fa-edit "></span></a>
                            <a class="btn btn-xs btn-danger" onclick="return confirm('Do you really want to delete item')" href="<?php echo base_url()?>items/item_delete/<?php echo $item->item_id?>" title="Delete Item"><span class="glyphicon glyphicon-trash"></span></a> </td>
						</tr>
                        <?php $count++; endforeach;?>
					</tbody>
				</table>
            </div>
         </div>
         </div>
         </div>
       </section> <!--end section content-->
<script>
jQuery(function(){
	jQuery('input:radio').click(function() { 
	  if($(this).hasClass('services')) {
		  jQuery(".services_select").prop("disabled",false);
		  jQuery(".inventory_select").prop("disabled",true);
		  $("#weight_mun").attr('disabled', true);
		  $("#price_mun").attr('disabled', true);
		  $("#quick_sale").attr('disabled', true);
		  $("#ratio").attr('disabled', false);
		 // weight();
	  }
	  else
	  {
	  	jQuery(".inventory_select").prop("disabled",false);
		jQuery(".services_select").prop("disabled",true);		
		$("#weight_mun").attr('disabled', true);
		$("#ratio").attr('disabled', true);
		$("#price_mun").attr('disabled', false);
		$("#quick_sale").attr('disabled', false);
		weight()
	  }
	});
});
function weight(){
	var val = $('#item_type').val();
	if(val == 3)
	{
		$("#label_show").html('Wieght of Bag');
		$("#show_label_price").html('Price per Bag');		
	}
	else if(val == 5)
	{
		$("#label_show").html('Weight of Mun');
		$("#show_label_price").html('Price per Mun');
	}
	else
	{
		$("#label_show").html('');
		$("#show_label_price").html('Price per Kg');
	}
	
	if(val == 5 || val==3){
		$("#weight_mun").attr('disabled', false);
		}
	else
		$("#weight_mun").attr('disabled', true);
	//alert(''+val);
	}
</script>
<?php $this->load->view("partial/footer"); ?>