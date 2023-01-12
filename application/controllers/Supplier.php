<?php
class Supplier extends CI_Controller {
 
        /*	
	 *	@author 	: Tahir Iqbal
	 *	date		: 03 March, 2016
	 *	Ginners Accounts Managements System
	 *	www.idlbridge.com
	 *  Mob : 03457050405
	 */
    public function __construct()
    {
        parent::__construct();		
		$this->load->library('grocery_CRUD');
		$this->load->model('m_supplier');
		$this->load->model('accounts_model');
		$this->load->helper('user_helper');
		$this->load->model('transaction_model');
		$this->load->model('items_model');
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    
    public function index()
    {

       		$crud = new grocery_CRUD();
			$crud->set_table('supplier');
			$crud->columns('name','company','phone','address','opening_balance','opening_balance_date','status');
			$crud->required_fields('name');
			$crud->display_as('name','Supllier Name');
			$crud->display_as('opening_balance','Opening Blance');
			$crud->display_as('opening_balance_date','Opening Blance as of');
			$crud->unset_columns('supplier_id');
			$crud->set_subject('Supplier');
			//$crud->callback_column('total_purchasing',array($this,'total_purchasing'));
			//$crud->callback_column('total_payment',array($this,'total_payment'));
			//$crud->callback_column('total',array($this,'total'));
			//$crud->callback_column('transaction',array($this,'_callback_webpage_url'));
			$html_title = 'Supplier Managment';
			$this->load->vars( array( 'html_title' => $html_title) );
			$output = $crud->render();
        	$this->load->view('template.php', $output);  

    }//index */
	public function index()
	{
		if(!islogged()){
			redirect('login/login_form');
		}
		$data["error_message"] = $this->session->flashdata('error');
		$data['inv_items']= $this->items_model->inv_items();
		$data['serv_items']= $this->items_model->serv_items();
		$data['customer']= $this->accounts_model->get_suppliers();
		$data['accounts']= $this->accounts_model->get_bankgeneral_accounts();
		$data['broker']= $this->accounts_model->get_brokers();
		$data['account']= $this->accounts_model->get_accounts();
		$data['get_fixed']= $this->items_model->get_fixed();
		$this->load->view('bill',$data);
	}
	public function get_data()
	{
		$this->load->model('m_supplier');
		$cek = $this->m_supplier->get_name($supplier_name);
		if($cek <> 0)
		{
			$this->load->view('bill');
		}
	}
	
	public function bill_post()
	{
		$this->response('21', 200);
		exit();
	}
	
	public function bill_insertion($id = ''){
		/*echo "<pre>";
		print_r($this->input->post());
		$pointer1 = 0;
		$sev_item_products = $this->input->post('sev_item_product');
		$add_to_bill_from = $this->input->post('add_to_bill_from');
		$subtract_from_bill = $this->input->post('subtract_from_bill');
		$subtract_from_bill_copy = $subtract_from_bill;
		foreach ($sev_item_products as $key=>$val){
			if($subtract_from_bill_copy[$pointer1] == $key)
			{
				$subtract_from_bill[$key] = $subtract_from_bill_copy[$pointer1];
				$pointer1++;
				
			}
			else
				echo $subtract_from_bill[$key] = -1;
			
		}
		print_r($subtract_from_bill);
		if($subtract_from_bill == '')
				$subtract_from_bill[$key] = -1;
		foreach ($subtract_from_bill as $key =>$val){							
				echo $subtract_from_bill[$key]."<br>";
			}
		$pointer = 0;
		$add_to_bill_from_copy = $add_to_bill_from;
		foreach ($sev_item_products as $key=>$val){
			if($add_to_bill_from_copy[$pointer] == $key)
			{
				$add_to_bill_from[$key] = $add_to_bill_from_copy[$pointer];
				$pointer++;
			}
			else
				$add_to_bill_from[$key] = -1;
			
		}
		print_r($add_to_bill_from);
		exit;
		$id = $this->input->post('inv_item_productid');
		foreach($id  as $key=>$val){		
		echo $id[$key]."<br>";
		$id1 = explode('~',$id[$key]);
		echo $id1[0]."<br>";
		echo $id1[1]."<br>";
		echo $id1[2]."<br>";
		echo $id1[3]."<br>";
			if($id1[1] == 3)
			{
				echo $id1[1];
			}
			else
			{
				echo $id1[3];
			}
		}
		exit;
		$sev_item_products = $this->input->post('sev_item_product');
		$add_to_bill_from = $this->input->post('add_to_bill_from');
		$sev_account = $this->input->post('sev_account');
		$pointer = 0;
		$add_to_bill_from_copy = $add_to_bill_from;
		foreach ($sev_item_products as $key=>$val){
			if($add_to_bill_from_copy[$pointer] == $key)
			{
				$add_to_bill_from[$key] = $add_to_bill_from_copy[$pointer];
				$pointer++;
			}
			else
				$add_to_bill_from[$key] = -1;
			
		}
		foreach ($sev_item_product as $key=>$va){
			if($add_to_bill_from[$key] == $sev_account[$key])
			echo $add_to_bill_from[$key] .''.$sev_account[$key].'<br>';
			else
			echo $add_to_bill_from[$key].'<br>';
			}
		print_r($add_to_bill_from);
		
		exit;*/		
		$edit_flag = 0;
		if($id)
		{
			$bill_id = (int)$id;
			$edit_flag = 1;
		}
		
		$bill_no = $this->input->post('bill_no');
		$company_name = $this->input->post('company_name');
		$bill_to = $this->input->post('bill_to');
		$vehical_no = $this->input->post('vehical_no');
		$bill_date = date_change_db($this->input->post('bill_date'));
		$grand_total = $this->input->post('grand_total');
		$supplier_total = $this->input->post('supplier_total');
		$phone_no = $this->input->post('phone');
		$amount = $this->input->post('payment');
		$payment_from = $this->input->post('payment_from');
		$date = date_change_db($this->input->post('bill_date'));
		$detail = $this->input->post('detail');
		$gate_pass = $this->input->post('gate_pass');
		$broker = $this->input->post('broker');
		$bales = $this->input->post('bales');
		$tax_amount = $this->input->post('tax_amount');
		$tax = $this->input->post('tax_ratio');
		$submit = $this->input->post('submit');
		$sale_type = $this->input->post('sale_type');
		
		if($sale_type == 'return')
		{
			$supplier_total = $supplier_total-$supplier_total*2;
			$grand_total = $grand_total-$grand_total*2;
		}
				
		$bill_head=array(
			'bill_no' => $bill_no,
			'bill_from '=> $company_name,
			'bill_to '=> $bill_to,
			'vehical_no' => $vehical_no,
			'bill_date' => $bill_date,
			'grand_total' => $grand_total,
			'supplier_total'=> $supplier_total,
			'phone_no' => $phone_no,
			'payment_from' => $payment_from,
			'paid_amount'=>$amount,
			'gate_pass'=>$gate_pass,
			'broker_id'=>$broker,
			'bales'=>$bales,
			'tax_amount'=>$tax_amount,
			'tax_ratio'=>$tax,
			'sale_type'=>$sale_type
		);
		
		$this->db->trans_start();
		
		if($bill_id){
			$this->m_supplier->update_bill_header($bill_head,$bill_id);
			$this->m_supplier->delete_inv_sev_bill($bill_id);
		}
		else
			$id = $this->m_supplier->supplier_bill_heading($bill_head);
			
		//echo $id. '------id';
		
		//exit;
			
		$save_detail = $detail.'--'.'<a href="'.base_url().'supplier/view_bill/'.$id.'">Detail Bill# '.$bill_no.'</a>';
		// debit grand total to company 
		$payment = array(
			'amount'=>$supplier_total,
			'payment_to'=>$bill_to,
			'payment_from'=>$company_name,
			'bill_invoice_id'=>$id,
			'detail'=>$save_detail,
			'type'=>'bill',
			'date'=>$date		
		);
		
		$this->transaction_model->add_transaction($payment);
		
		//credit to the supplier company but first check in payment is greater than zero
		
		if($amount > 0)
		{
			$payment = array(
				'amount' => $amount,
				'payment_to'=>$company_name,
				'bill_invoice_id'=>$id,
				'type'=>'bill',
				'payment_from'=>$payment_from,
				'detail'=>$save_detail,
				'date'=>$date
			);
			$this->transaction_model->add_transaction($payment);
		}
		
		$inv_item_productids = $this->input->post('inv_item_productid');
		$inv_item_quantity = $this->input->post('inv_item_quantity');
		$inv_item_price = $this->input->post('inv_item_price');
		$sev_item_product = $this->input->post('sev_item_product');
		$sev_item_price = $this->input->post('sev_item_price');
		$sev_account = $this->input->post('sev_account');
		//$add_to_bill_from = $this->input->post('add_to_bill_from');
		foreach($inv_item_productids  as $key=>$val){
				$weight = 0.000;
				$inv_item = explode('~',$inv_item_productids[$key]);
				if($inv_item[1] == 3)
				{
					if($inv_item[3] == 0.000)
						$quantity = $inv_item_quantity[$key];
					else
						$quantity = $inv_item_quantity[$key]*$inv_item[3];
						
					$weight = $inv_item[3];
				}
				else
				{
					$quantity = $inv_item_quantity[$key];
					$weight = $inv_item[3];
				}
				
				if($sale_type == 'return')
					$quantity = $quantity-$quantity*2;
						
				
				$bill_detail=array(
				'bill_id'=>$id,
				'inv_name'=>$inv_item[0],
				'inv_quantity'=>$quantity,
				'inv_price'=>$inv_item_price[$key],				
				'weight_mun_bag'=>$weight);		
			if($inv_item_productids[$key]!=''){
				$this->m_supplier->supplier_bill_inventory($bill_detail);
			}
		}
		$sev_item_products = $this->input->post('sev_item_product');
		$add_to_bill_from = $this->input->post('add_to_bill_from');
		$subtract_from_bill = $this->input->post('subtract_from_bill');
		//$sev_account = $this->input->post('sev_account');  
		$pointer = 0;
		$add_to_bill_from_copy = $add_to_bill_from;
		foreach ($sev_item_products as $key=>$val){
			if($add_to_bill_from_copy[$pointer] == $key)
			{
				$add_to_bill_from[$key] = $add_to_bill_from_copy[$pointer];
				$pointer++;
			}
			else
				$add_to_bill_from[$key] = -1;
			
		}
		
		$pointer1 = 0;
		$subtract_from_bill_copy = $subtract_from_bill;
		foreach ($sev_item_products as $key=>$val){
			if($subtract_from_bill_copy[$pointer1] == $key)
			{
				$subtract_from_bill[$key] = $subtract_from_bill_copy[$pointer1];
				$pointer1++;
			}
			else
				$subtract_from_bill[$key] = -1;
			
		}
		
		foreach ($sev_item_product as $key=>$val){
				if($add_to_bill_from[$key] >= 0)
				{
					$account = $company_name;
				}
				else
				{
					$account = $sev_account[$key];
				}
				$sev_item = explode('~',$sev_item_product[$key]);
				
				if($add_to_bill_from[$key] == ''){
					$add_to_bill_from[$key] = -1;
				}
				
				if($subtract_from_bill[$key] == ''){
					$subtract_from_bill[$key] = -1;
				}
				
				if($sale_type = 'return')
					$price = $sev_item_price[$key]-$sev_item_price[$key]*2;
				else
					$price = $sev_item_price[$key];
													
				$sev_detail = array(
				'bill_id'=>$id,
				'sev_name'=>$sev_item[0],
				'account_id'=>$account,
				'check_value'=>$add_to_bill_from[$key],
				'sev_price'=>$price,
				'ratio'=>$sev_item[1],
				'subtract_from_bill'=>$subtract_from_bill[$key]);
			if($sev_item_product[$key]!=''){
				$this->m_supplier->supplier_bill_services($sev_detail);			
			}			
		}
		
		
		foreach ($sev_item_product as $key=>$val){
			if($sale_type = 'return')
					$price1 = $sev_item_price[$key]-$sev_item_price[$key]*2;
			else
				$price1 = $sev_item_price[$key];
					
			$payment = array(
				'amount' => $price1,
				'payment_to'=>$bill_to,
				'bill_invoice_id'=>$id,
				'type'=>'bill',
				'payment_from'=>$sev_account[$key],
				'detail'=>$save_detail,
				'date'=>$date
			);
			if($add_to_bill_from[$key]<0 && $sev_item_product[$key]!='' && $sev_account[$key]!=''){
				$this->transaction_model->add_transaction($payment);
			}
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			//echo $this->db->_error_message();
		} 
		else
		{
			$this->db->trans_commit();
			if($edit_flag)			
				$this->session->set_flashdata('success', 'Bill Edited Successfully');
			else
				$this->session->set_flashdata('success', 'Bill Genrated Successfully');
			if($submit == 'Add Bill')
				redirect('/supplier');
			else	
				redirect('/supplier/bill_print/'.$id, 'refresh');
		}
	}

	
	public function supplier_bill(){
		$name = $this->input->post('company_name');
		$data = $this->m_supplier->supplier_total_bill($name);
		foreach ($data as $r)
		{
			$res = $r->grand_total;
			$pay = $r->payment;
			$payment += $pay;
			$result += $res;
		}
		if(strcmp($payment,$result)!= 0){
		$r = $result-$payment;
		echo "Deu Payment ".$r; }
	}
	public function bill_list(){
		
		$supplier = ($this->input->post('company_name'))? $this->input->post('company_name'): '';
		$date = ($this->input->post('date_range'))? $this->input->post('date_range'): '';
		
		if($date)
			$date_range = explode(' - ',$date);
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			//$date = date_change_db($date);
			
		$data['bills'] = $this->m_supplier->get_supplier_bills($supplier,$start_date,$end_date);
		$data['bill_detail'] = $this->accounts_model->get_suppliers();
		$this->load->view('bill_list',$data);
	}
	public function bill_detail_view(){
		$name = $this->input->get('company_name');
		$data['bill_detail_view'] = $this->m_supplier->bill_detail_view($name);
		$data['bill_detail'] = $this->m_supplier->bill_view();
		$this->load->view('bill_view',$data);
		
	}
	public function view_bill($id){
		if(empty($id))
		{
			//echo 'error';
			$this->session->set_flashdata('error', 'Data is not available in database Please select some id');
			redirect('/supplier');
		}
		else
		{
			$id = (int)$id;
			$data["success_message"] = $this->session->flashdata('success');
			$data['bill_head'] = $this->m_supplier->edit_bill_head($id);
			$data['bill_inv'] = $this->m_supplier->edit_bill_inv($id);
			$data['bill_sev'] = $this->m_supplier->edit_bill_sev($id);
			$data['bill_transection'] = $this->m_supplier->edit_transection($id);
			$data['inv_items']= $this->items_model->inv_items();
			$data['serv_items']= $this->items_model->serv_items();
			$data['customer']= $this->accounts_model->get_suppliers();
			$data['accounts']= $this->accounts_model->get_bankgeneral_accounts();
			$data['broker']= $this->accounts_model->get_brokers();
			$data['account']= $this->accounts_model->get_accounts();
		}
		$this->load->view('edit_bill',$data);
	}
	public function bill_print($id)
	{
		$data['bill_head'] = $this->m_supplier->edit_bill_head($id);
		foreach($data['bill_head'] as $in){}
			$supplier_id = $in->bill_from;
		
		$data['bill_inv'] = $this->m_supplier->edit_bill_inv($id);
		$data['bill_sev'] = $this->m_supplier->edit_bill_sev($id);
		$data['bill_transection'] = $this->m_supplier->edit_transection($id);
		$data['total'] = $this->accounts_model->get_total($supplier_id);
		$data['total_dr'] = $this->accounts_model->get_total_dr($supplier_id);
		$this->load->view('bill_print',$data);
	}
	public function delete_bill($id)
	{
		$data = array(
		'deleted'=>'yes'
		);
		$this->m_supplier->bill_delete($id,$data);

		$this->m_supplier->bill__transection_delete($id,$data);
		
		redirect('supplier/bill_list');
	}

}