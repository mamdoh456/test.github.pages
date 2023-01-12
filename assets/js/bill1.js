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
//			 alert($("#sev_item_price_"+thisid).is(':checked'));
			 if($(this).hasClass("sev_subtotal") && $("#add_to_bill_from_"+thisid).is(':checked'))
				supplier_total += parseFloat($(element).val());
			else if($(this).hasClass("inv_subtotal"))
				supplier_total += parseFloat($(element).val());
			
			grand_total += parseFloat($(element).val());
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
		var tax = (inv_subtotall*($("#tax_ratio").val()/100)).toFixed(2);
		//inv_balance_after_tax = inv_subtotall-tax;
		$("#tax_amount").val(tax);
		grand_total = grand_total-tax;
	}
	$('.sev_subtotal').each(function(index, element) {						
       if($.isNumeric($(element).val()))
		 {
			sev_subtotal += parseFloat($(element).val());
		 } 

    });

	$('#supplier_total').val(supplier_total.toFixed(2));
	$('#sev_subtotal').html(sev_subtotal.toFixed(2));
	$('#quantity_total').html(quantity_totall.toFixed(2));
	$('#inv_subtotal').html(inv_subtotall.toFixed(2));
	$('#grand_total').val(grand_total.toFixed(2));
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
  $('.onchange').keyup(function(){
		  var ele = $(this);
		  var get_id = ele.attr('id').split('_');
		  var id = get_id[get_id.length-1];
		  
		  var quantity = $('#inv_item_quantity_'+id);
		  var price = $('#inv_item_price_'+id);
		  
		  var total = (((parseFloat(quantity.val())/40).toFixed(3))*parseFloat(price.val())).toFixed(2);
		  
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
		 if(checkUnique(val))
		 {
			alert('selecte services should be unique');
			$(this).val('')
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