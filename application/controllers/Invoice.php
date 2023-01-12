<?php
class Invoice extends CI_Controller {
 
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
		$this->load->model('invoice_model');
		$this->load->model('items_model');
		$this->load->model('accounts_model');
		$this->load->model('m_supplier');
		$this->load->model('transaction_model');
		$this->load->helper('user_helper');
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {
		if(!islogged()){
			redirect('login/login_form');
		}
		
		$data["error_message"] = $this->session->flashdata('error');
		$data['inv_items']= $this->items_model->inv_items();
		$data['serv_items']= $this->items_model->serv_items();
		$data['customer']= $this->accounts_model->get_customers();
		$data['accounts']= $this->accounts_model->get_bankgeneral_accounts();
		$data['broker']= $this->accounts_model->get_brokers();
		$data['account']= $this->accounts_model->get_accounts();
		$data['get_fixed']= $this->items_model->get_fixed();
		$this->load->view('invoice',$data);
       		

    }

	
	/*
	*function to add/eidt invoice
	*/
	
	public function invoice_add_edit($id = ''){
		
		$edit_flag = 0;
		if(!empty($id))
		{
			$invoice_id = (int)$id;
			$edit_flag = 1;
		}
		$invoice_no = $this->input->post('invoice_no');
		$buyer = $this->input->post('company_name');
		$vehical_no = $this->input->post('vehical_no');
		$date = date_change_db($this->input->post('invoice_date'));
		$invoice_total = $this->input->post('grand_total');
		$phone_no = $this->input->post('phone');
		$detail = $this->input->post('detail');
		$amount = $this->input->post('payment');
		$seller = $this->input->post('accounts');
		$invoice_form = $this->input->post('invoice_form');
		$gate_pass = $this->input->post('gate_pass');
		$broker_id = $this->input->post('broker_id');
		$bales = $this->input->post('bales');
		$lot_no = $this->input->post('lot_no');
		$tax_amount = $this->input->post('tax_amount');
		$tax = $this->input->post('tax_ratio');
		$customer_total = $this->input->post('supplier_total');
		$sale_type = $this->input->post('sale_type');
		$submit = $this->input->post('submit');
					if($sale_type == 'return')
					{
						$customer_total = $customer_total-$customer_total*2;
						$invoice_total = $invoice_total-$invoice_total*2;
					}						
					else
					{
						$customer_total = $customer_total;
						$invoice_total = $invoice_total;
					}						
		$invoice_head=array(
			'invoice_no'=>$invoice_no,
			'invoice_to'=>$buyer,
			'invoice_from'=>$invoice_form,
			'vehical_no'=>$vehical_no,
			'date'=>$date,
			'invoice_total'=>$invoice_total,
			'customer_total'=>$customer_total,
			'phone_no'=>$phone_no,
			'gate_pass' => $gate_pass,
			'broker_id' => $broker_id,
			'bales' =>$bales,
			'paid_amount'=> $amount,
			'lot_no'=> $lot_no,
			'tax_amount'=> $tax_amount,
			'tax_ratio'=> $tax,
			'sale_type'=> $sale_type
		);
		
		$this->db->trans_start();
		
		if($invoice_id)
		{
			$this->invoice_model->update_invoice_header($invoice_id,$invoice_head);
			$this->invoice_model->delete_inv_ser_items($invoice_id);
			
		}
		else
			$invoice_id = $this->invoice_model->invoice_heading($invoice_head);  //insert to invoice head
		
		$save_detail = $detail.'--'.'<a href="/accounts_managment/invoice/view_invoice/'.$invoice_id.'">Invoice # '.$invoice_no.'</a>';
		
		// credit grand total to company 
		$payment=array(
		'amount' => $customer_total,
		'payment_type' => 'Dr',
		'payment_from' => $invoice_form,
		'bill_invoice_id' => $invoice_id,
		'type' => 'invoice',
		'payment_to' => $buyer,
		'detail' => $save_detail,
		'date' => $date
		);
		$this->invoice_model->transection($payment);   // insert to transaction
		
		//debit to the supplier company but first check in payment is greater than zero
		
		if($amount > 0)
		{
			$payment=array(
				'amount' => $amount,
				'payment_type' => 'Dr',
				'payment_from' => $buyer,
				'bill_invoice_id' => $invoice_id,
				'type' => 'invoice',
				'payment_to' => $seller,
				'detail' => $save_detail,
				'date' => $date
				);
				$this->invoice_model->transection($payment);  
			
		}
		
		
		
		
		$inv_item_productids = $this->input->post('inv_item_productid');
		$inv_item_quantity = $this->input->post('inv_item_quantity');
		$inv_item_price = $this->input->post('inv_item_price');
		$sev_item_product = $this->input->post('sev_item_product');
		$sev_item_price = $this->input->post('sev_item_price');
		$sev_account = $this->input->post('sev_account');
		//$inv_item_kaats = $this->input->post('inv_item_kaat');				
		
		foreach($inv_item_productids  as $key=>$val){
			
				$weight = 0.000;
				$inv_item = explode('~',$inv_item_productids[$key]);
				if($inv_item[1] == 3)
				{
					if($inv_item[3] == 0.000){
						$quantity = $inv_item_quantity[$key];
						}
					else{
						$quantity = $inv_item_quantity[$key]*$inv_item[3];
						}					
					
					$weight = $inv_item[3];
				}
				else
				{
					$quantity = $inv_item_quantity[$key];
					$weight = $inv_item[3];
				}
				
				if($sale_type == 'return')
				{
					$quantity = $quantity-$quantity*2;					
				}
				
				$invoice_detail=array(
				'invoice_id'=>$invoice_id,
				'inv_name'=>$inv_item[0],
				'inv_quantity'=>$quantity,
				'inv_price'=>$inv_item_price[$key],
				'kat'=>$weight);		
			if($inv_item_productids[$key]!=''){
				$this->invoice_model->invoice_inventory($invoice_detail);
			}
		}
		
		$sev_item_products = $this->input->post('sev_item_product');
		$add_to_bill_from = $this->input->post('add_to_bill_from');
		$subtract_from_bill = $this->input->post('subtract_from_bill');
		
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
			
			if($add_to_bill_from[$key] > 0)
				{
					$account = $invoice_form;
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
				if($sale_type == 'return')
					$price1 = $sev_item_price[$key]-$sev_item_price[$key]*2; 
				else
					$price1 = $sev_item_price[$key];
				
				$sev_detail = array(
				'invoice_id'=>$invoice_id,
				'sev_name'=>$sev_item[0],
				'account_id'=>$account,
				'check_value'=>$add_to_bill_from[$key],
				'sev_price'=>$price1,
				'ratio'=>$sev_item[1],
				'subtract_from_bill'=>$subtract_from_bill[$key]);
			if($sev_item_product[$key]!=''){
				$this->invoice_model->invoice_services($sev_detail);			
			}			
		}
		
		foreach ($sev_item_product as $key=>$val){
			if($sale_type == 'return')
				$amnt = $sev_item_price[$key]-$sev_item_price[$key]*2;
			else
				$amnt = $sev_item_price[$key];
				
			$payment = array(
				'amount' => $amnt,
				'payment_to'=>$invoice_form,
				'bill_invoice_id'=>$invoice_id,
				'type'=>'invoice',
				'payment_from'=>$sev_account[$key],
				'detail'=>$save_detail,
				'date'=>$date
			);
			if($sev_item_product[$key]!='' && $sev_account[$key]!=''){
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
				$this->session->set_flashdata('success', 'Invoice Edited Successfully');
			else
				$this->session->set_flashdata('success', 'Invoice Genrated Successfully');
			
			if($submit == 'Add Invoice')
				redirect('/invoice');
			else	
				redirect('/invoice/invoice_print/'.$invoice_id, 'refresh');
		}
		
	}

	
	public function customer_bill($name){
		$data[]=$this->m_supplier->customer_total_bill($name);
		foreach ($data as $r)
		{
			echo $r->bill_from;
		}
		
	}

	/*
		function to view list of all invoices
	*/
	public function invoices_list(){
		$customer = ($this->input->post('customer'))? $this->input->post('customer'): '';
		$date = ($this->input->post('date_range'))? $this->input->post('date_range'): '';
		
		if($date)
			$date_range = explode(' - ',$date);
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			//$date = date_change_db($date);
			
		$data['invoices'] = $this->invoice_model->invoices_list($customer,$start_date,$end_date);
		$data['customers'] = $this->accounts_model->get_customers();
		$this->load->view('invoice_view',$data);
	}
	
	/*
		function to edit or view full detail of invoice
	*/
	
	public function view_invoice($id){
		if(empty($id))
		{
			//echo 'error';
			$this->session->set_flashdata('error', 'Data is not available in database Please select some id');
			redirect('/invoice');
		}
		else
		{
			$data["success_message"] = $this->session->flashdata('success');
			$data['invoice_head'] = $this->invoice_model->get_header($id);
			$data['invoice_inv'] = $this->invoice_model->get_inv_items($id);
			$data['invoice_sev'] = $this->invoice_model->get_sev_items($id);
			$data['invoice_transection'] = $this->invoice_model->get_transection($id);
			$data['inv_items']= $this->items_model->inv_items();
			$data['serv_items']= $this->items_model->serv_items();
			$data['customer']= $this->accounts_model->get_customers();
			$data['accounts']= $this->accounts_model->get_bankgeneral_accounts();
			$data['broker']= $this->accounts_model->get_brokers();
			$data['account']= $this->accounts_model->get_accounts();
			$data['get_fixed']= $this->items_model->get_fixed();
		}
		$this->load->view('edit_invoice',$data);
	}
	
	public function invoice_print($id)
	{
		$data['invoice_head'] = $this->invoice_model->get_header($id);
		$in = $data['invoice_head'];
		$customer_id = $in->invoice_to;
		$data['invoice_inv'] = $this->invoice_model->get_inv_items($id);
		$data['invoice_sev'] = $this->invoice_model->get_sev_items($id);
		$data['invoice_transection'] = $this->invoice_model->get_transection($id);
		$data['total'] = $this->accounts_model->get_total($customer_id);
		$data['total_dr'] = $this->accounts_model->get_total_dr($customer_id);
		$this->load->view('invoice_print',$data);
	}
	public function invoice_delete($id)
	{
		$data = array(
		'deleted'=>'yes'
		);
		$this->invoice_model->invoice_delete($id,$data);
		
		redirect('invoice/invoices_list');
	}
	
	public function quick_sale(){
		if($this->input->post()){
			
			$item_id = $this->input->post('item_id');
			$quantity = $this->input->post('quantity');
			$price = $this->input->post('price');
			$weight_mun_bag = $this->input->post('weight_mun_bag');
			$discount = $this->input->post('discount');
			$total = $this->input->post('total');
			
			if(!$discount){
					$discount = 0;
				}
			
			if($type == 3){
					$weight = $quantity*$weight_mun_bag;
				}
			else 
				$weight = $quantity;
				
				
				$sale_detail = array(
				'item_id'=> $item_id,
				'quantity' => $quantity,
				'price' => $price,
				'weight_mun_bag' => $weight_mun_bag,
				'discount' => $discount,
				'total' => $total
				);
				
			if($this->invoice_model->quick_sale($sale_detail))
				echo 'ok';
			else
				echo 'nok';

			exit();
			}
			else
			{
				$data['quick_sale'] = $this->items_model->quick_sale();
				$this->load->view('quick_sale', $data);
			}
	}
}