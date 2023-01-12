<?php $this->load->view('partial/header')?>
<?php
echo form_open('suppliers/save/'.$person_info->person_id,array('id'=>'supplier_form'));
?>
<div id="required_fields_message"><?php echo 'Fields in red are required'; ?></div>
<ul id="error_message_box" class="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend>Supplier Information</legend>

<div class="field_row clearfix">	
<?php echo form_label('Company Name'.':', 'company_name', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'company_name',
		'id'=>'company_name_input',
		'class'=>'form-control',
		'value'=>$person_info->company_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Agency Name</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'agency_name',
		'id'=>'agency_name_input',
		'class'=>'form-control',
		'value'=>$person_info->agency_name)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('First Name'.':', 'first_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'first_name',
		'id'=>'first_name',
		'class'=>'form-control',
		'value'=>$person_info->first_name)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Last Name'.':', 'last_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'id'=>'last_name',
		'class'=>'form-control',
		'value'=>$person_info->last_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Gender'.':', 'gender',
!empty($basic_version) ? array('class'=>'required') : array()); ?>
	<div class='form_field'>
	<?php echo form_radio(array(
		'name'=>'gender',
		'type'=>'radio',
		'id'=>'gender',
		'class'=>'required',
		'value'=>1,
		'checked'=>$person_info->gender === '1')
	);
	echo '&nbsp;' . 'Male'. '&nbsp;';
	echo form_radio(array(
		'name'=>'gender',
		'type'=>'radio',
		'id'=>'gender',
		'value'=>0,
		'checked'=>$person_info->gender === '0')
	);
	echo '&nbsp;' . 'Female';
	?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Email</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'class'=>'form-control',
		'value'=>$person_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Phone Number</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number',
		'class'=>'form-control',
		'value'=>$person_info->phone_number));?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Address</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address',
		'id'=>'address',
		'class'=>'form-control',
		'value'=>$person_info->address));?>
	</div>
</div>

<div class="field_row clearfix">	
<label>City</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'city',
		'id'=>'city',
		'class'=>'form-control',
		'value'=>$person_info->city));?>
	</div>
</div>

<div class="field_row clearfix">	
<label>State</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'state',
		'id'=>'state',
		'class'=>'form-control',
		'value'=>$person_info->state));?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Zip</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'zip',
		'id'=>'postcode',
		'class'=>'form-control',
		'value'=>$person_info->zip));?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Country</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'country',
		'id'=>'country',
		'class'=>'form-control',
		'value'=>$person_info->country));?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Account Number</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'account_number',
		'id'=>'account_number',
		'class'=>'form-control',
		'value'=>$person_info->account_number)
	);?>
	</div>
</div>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>'Submit',
	'class'=>'btn btn-danger')
);
?>
</fieldset>
<?php 
echo form_close();
?>
<?php $this->load->view('partial/footer')?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('#supplier_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_person_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			company_name: "required",
			first_name: "required",
			last_name: "required",
			email: "email"
   		},
		messages: 
		{
			company_name: "<?php echo $this->lang->line('suppliers_company_name_required'); ?>",
			last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
			email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
		}
	});
});

</script>
<script type='text/javascript' language="javascript">
//validation and submit handling
$(document).ready(function()
{
	nominatim.init({
		fields : {
			postcode : {  
				dependencies :  ["postcode", "city", "state", "country"], 
				response : {  
					field : 'postalcode', 
					format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"] 
				}
			},
	
			city : {
				dependencies :  ["postcode", "city", "state", "country"], 
				response : {  
					format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"] 
				}
			},
	
			state : {
				dependencies :  ["state", "country"]
			},
	
			country : {
				dependencies :  ["state", "country"] 
			}
			
		},
		language : '<?php echo $this->config->item('language');?>'
	});

});
</script>