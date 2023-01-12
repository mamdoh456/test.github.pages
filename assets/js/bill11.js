var inv_subtotall = 0;
function calctotal()
{
	var grand_total = 0;
	var quantity_totall = 0;
	var inv_subtotall = 0;
	var sev_subtotal = 0;
	var supplier_total = 0;
	var tax = 0;
	$(".subtotal").each(function(index, element) {
		 if($.isNumeric($(element).val()))
		 {
			 var id_attr = $(this).attr("id");
			 var get_id = id_attr.split('_');
			 var thisid = get_id[get_id.length-1];
			 grand_total += parseFloat($(element).val());

			if($("#subtract_from_bill_"+thisid).is(':checked') && $("#add_to_bill_from_"+thisid).prop('checked', false) && $(this).hasClass("sev_subtotal"))
			{
				supplier_total -= parseFloat($(element).val());
				grand_total -= parseFloat($(element).val());
			}
			if($(this).hasClass("sev_subtotal") && $("#add_to_bill_from_"+thisid).is(':checked'))
				supplier_total += parseFloat($(element).val());
			else if($(this).hasClass("inv_subtotal"))
				supplier_total += parseFloat($(element).val());				
			
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
			//inv_balance_after_tax = inv_subtotall;
		 } 
    });
	if($.isNumeric($("#tax_ratio").val()))
	{
		var tax = (inv_subtotall*($("#tax_ratio").val()/100));
		//inv_balance_after_tax = inv_subtotall-tax;
		$("#tax_amount").val(tax.toFixed(2));
		grand_total = grand_total-tax;
	}
	$('.sev_subtotal').each(function(index, element) {						
       if($.isNumeric($(element).val()))
		 {
			sev_subtotal += parseFloat($(element).val());
		 } 

    });
	
	

	$('#supplier_total').val(supplier_total.toFixed(2));
	//$('#sev_subtotal').html(sev_subtotal.toFixed(2));
	$('#quantity_total').html(quantity_totall.toFixed(2));
	$('#inv_subtotal').html(inv_subtotall.toFixed(2));
	$('#grand_total').val(grand_total.toFixed(2));
	
	
	$('.sev_items').each(function(index, element) {
        if($(element).val())
		 {
			 var id_attre = $(this).attr("id");
			 var get_idd = id_attre.split('_');
			 var this_id = get_idd[get_idd.length-1];
			 var items = $('#sev_item_product_'+this_id).val().split('~');
			 var ratio = parseFloat(items[1]);
			
			 if(($('#sev_item_price_'+this_id).attr('byuserr') == 'no') && (ratio != 0.00)){
				 var item_price = ($('#inv_subtotal').html()*ratio)/100;
				 $('#sev_item_price_'+this_id).val(item_price.toFixed(2));
			 }
			 /*else if(($('#sev_item_price_'+this_id).attr('byuserr') == 'no') && (ratio != 0.00) && (calc_weight == 'yes')){
			 	var item_price1 = (parseFloat($('#quantity_total').html())*ratio);
				$('#sev_item_price_'+this_id).val(item_price1.toFixed(2));
			 }*/
			 //alert(item_price);
		 }
    });
	$('#sev_subtotal').html(sev_subtotal.toFixed(2));
}

$(document).ready(function() {
	
  $(".add_to_bill").change(function(){
	   var id_attr = $(this).attr("id");
	   var get_id = id_attr.split('_');
	   var thisid = get_id[get_id.length-1];
	   if ($(this).is(':checked'))
	   {
			$("#sev_account_"+thisid).attr('readonly', true);
			//$("#sev_account_"+thisid+'[value="'+company_name.val()+'"]').attr('selected',true);
			$("#sev_account_"+thisid).val($("#company_name").val());   
	   }
	   else
	   		$("#sev_account_"+thisid).attr('readonly', false);
			
	   calctotal();
	});
  
  var grand_total = 0;
  $grand_total_ele = $('#grand_total');
  
  $(".onchange").bind("keyup change", function(e) {
    
	  	var ratio = 40;
		  var ele = $(this);
		  var get_id = ele.attr('id').split('_');
		  var id = get_id[get_id.length-1];
		  if($("#productid_"+id).val())
		  {
		  var inv_item = $("#productid_"+id).val().split('~');
		  var item_type = inv_item[1];
		  var db_price = (inv_item[2] != 0)? inv_item[2]: 0;
		  var quantity = $('#inv_item_quantity_'+id);
		  var price = 0;
		  var total = 0;
		  
		  $('#inv_item_price_'+id).attr('readonly', false);
		  switch(item_type) {
			case '3':
							
				if(db_price)
					$('#inv_item_price_'+id).val(db_price).attr('readonly', true);
					
		  		price = (db_price)?db_price:$('#inv_item_price_'+id).val();		  
		  		total = (((parseFloat(quantity.val())))*parseFloat(price));
				break;
			case '4':
							
				if(db_price)
					$('#inv_item_price_'+id).val(db_price).attr('readonly', true);;
					
		  		price = (db_price)?db_price:$('#inv_item_price_'+id).val();		  
		  		total = (((parseFloat(quantity.val())))*parseFloat(price));
				break;
			case '5':
							
				if(db_price)
					$('#inv_item_price_'+id).val(db_price).attr('readonly', true);;
					
		  		price = (db_price)?db_price:$('#inv_item_price_'+id).val();		  
				var ratio = (inv_item[3] != 0)? inv_item[3]: ratio;
		  		total = (((parseFloat(quantity.val())/ratio))*parseFloat(price));
				break;
			default:
				
		} 
		  }
		  
		  if($.isNumeric(total))
		  {
			  $('#inv_item_total_'+id).val(total);
			 
		  }		  
		   calctotal();
	
	})
  
  
  //$('').keyup(function(){});
	
	  
	var sev_total = 0;
  $('.sev_onchange').keyup(function(){	  
	  	 calctotal()
		 
	});

	$('.search_data').change(function(){
		  var ele = $(this);
		  var get_id = ele.attr('id').split('_');
		  var id = get_id[get_id.length-1];
		  var sev_item = $("#sev_item_product_"+id).val().split('~');
		 // var item_type = sev_item[1];
		  var ratio = (sev_item[1] != 0)? sev_item[1]: 0;
		  var calc_weight = sev_item[2];
		  //alert(calc_weight);		  
		  //if(ele.attr('byuserr') == 'no'){
		  if(($('#sev_item_price_'+id).attr('byuserr') == 'no') && (ratio != 0.00)){
		  		var sev_amount = ($('#inv_subtotal').html()*ratio)/100;
		 		$('#sev_item_price_'+id).val(sev_amount.toFixed(2));
		  }		  
		  
		 calctotal()
	});

	/*$('.calc_price').focus(function(){
		var el = $(this);
		  var get_idd = el.attr('id').split('_');
		  var idd = get_idd[get_idd.length-1];
		  var sev_items = $("#sev_item_product_"+idd).val().split('~');
		  var ratioo = el.attr('ratio');
		  if(el.attr('byuserr') == 'no'){
		  var sev_amountt = ($('#inv_subtotal').html()*ratioo)/100;		  
		 $('#sev_item_price_'+idd).val(sev_amountt.toFixed(2));
		  }
		calctotal()
		 
	});*/

	$('.user_change').keyup(function(){
		$(this).attr('byuserr','yes');
	});
		
	$('.tax').keyup(function(){
	  	calctotal()		
	});
	
       // invIndex = 0;
    $('#supplierbill')
        .on('click', '.addButton', function() {
            invIndex++;
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone(true)
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', invIndex)
                                .insertBefore($template);

            // Update the name attributes  
            $clone
				.find('[id="productid"]').attr('id', 'productid_'+invIndex).end()
                .find('[id="inv_item_quantity"]').attr('id', 'inv_item_quantity_'+invIndex).end()
                .find('[id="inv_item_price"]').attr('id', 'inv_item_price_' + invIndex).end()
				.find('[id="inv_item_total"]').attr('id', 'inv_item_total_' + invIndex).end()

            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
          
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row  = $(this).parents('.form-group'),
            index = $row.attr('data-book-index');
			$row.remove();
			calctotal();
			//ajaxSearch();
           
        });
		
		//sevIndex = 0;

    $('#supplierbill')
        .on('click', '.addButton1', function() {
            sevIndex++;			 
            var $template = $('#bookTemplate1'),			
                $clone    = $template
                                .clone(true)
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index1', sevIndex)
                                .insertBefore($template);

            // Update the name attributes sev_account 
            $clone
				.find('[id="add_to_bill_from"]').attr('id', 'add_to_bill_from_' + sevIndex ).end()
				.find('[id="subtract_from_bill"]').attr('id', 'subtract_from_bill_' + sevIndex ).end()
				.find('[value="0"]').attr('value','' + sevIndex ).end()
				.find('[id="sev_item_product"]').attr('id', 'sev_item_product_' + sevIndex ).end()
                .find('[id="sev_item_price"]').attr('id', 'sev_item_price_' + sevIndex ).end()
				.find('[id="sev_account"]').attr('id', 'sev_account_' + sevIndex ).end()
				.find('[id="check"]').attr('id', 'check_' + sevIndex ).end();
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
									bill_to: {
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

	$("#company_name").change(function(){
		var company_name = $(this);
		$("#totl_bill_from_name").html($("#company_name option:selected").text());
		$(".sev_accounts").each(function(index, element) {
			if($(this).val() == "" || ($(this).attr('byuser') == 'no') )
				$('[value="'+company_name.val()+'"]',this).attr('selected',true);
            	//$(this).val(company_name.val());
        });
	})
	$("#bill_to").change(function(){
		var bill_to = $(this);
		$("#totl_bill_to_name").html($("#bill_to option:selected").text());
	})
	
	$(".sev_accounts").change(function(){
		if($(this).val() != "")
			$(this).attr('byuser','yes');	
	})
	
	$(".sev_items").change(function(){
		var id = $(this).attr('id')
		var val = $(this).val();
		var get_id = id.split('_');
		 var idd = get_id[get_id.length-1];
		 $("#active_row").val(idd); //set id in model so can fill next price box
		 $("#active").val(idd); //set id
		 if(checkUnique(val))
		 {
			alert('selecte services should be unique');
			$(this).val('');
			$('#sev_item_price_'+idd).val('');
		 }
		else
		 if(val == 10)
		 {
			 $("#myModal").modal({
				show: true
			});
		 }
	})
							
});
    
function calcdami()
{
	console.log('test');
	var total_raqam = $("#inv_subtotal").html();
	console.log(total_raqam);	
	var percent_val = $("#dami_ratio").val();
	console.log(percent_val);
	//alert(''+total_raqam);
	if($.isNumeric(total_raqam) && $.isNumeric(percent_val))
	{
		var dami = ((parseFloat(total_raqam))*(parseFloat(percent_val))/100);
		$("#total_dami").html(dami.toFixed(2));
	}
}
function filldami()
{
	var total_dami = parseFloat($("#total_dami").html());
	if($.isNumeric(total_dami))
	{
		var fill_to = parseInt($("#active_row").val());
		var fieldname = "#sev_item_price_"+fill_to;
		//alert($(fieldname).attr('id'));
		$(fieldname).val(total_dami);
		$("#myModal").modal('hide');
	}
}

function checkUnique(val) {
        var ret = false;
		var count = 0;
        $(".sev_items").each(function() {
            if ($(this).val() === val) {
                count++;
            }
        });
		if(count > 1)
			ret = true;
			
        return ret;
}
