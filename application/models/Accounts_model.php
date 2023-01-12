<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_account($account_id)
	{
		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->where('account_id',$account_id);		
		$query = $this->db->get();
		return $query->result();
		
	}
	public function get_customers()
	{
		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->where_in('account_type',array(1,7)); //type 1  for customers
		$this->db->where('status','enable');		
		$query=$this->db->get();
		return $query->result();
	}
	public function get_suppliers()
	{
		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->where_in('account_type',array(2,7)); //type 2 for suppliers
		$this->db->where('status','enable');		
		$query=$this->db->get();
		return $query->result();
	}
	public function get_bankgeneral_accounts()
	{
		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->or_where_in('account_type',array(4,5,7));   //4,5 bank and general accounts		
		$query=$this->db->get();
		return $query->result();
		
	}
	public function get_brokers()
	{
		$this->db->select('account_title,account_id');
		$this->db->from('accounts');
		$this->db->where('account_type','6');
		$this->db->where('status','enable');		
		$query=$this->db->get();
		return $query->result();
	}
	public function get_accounts()
	{
		$this->db->select('account_title,account_id');
		$this->db->from('accounts');
		//$this->db->where('account_type','6');
		$this->db->where('status','enable');		
		$query=$this->db->get();
		return $query->result();
	}
	public function get_brokers_name($broker)
	{
		$this->db->select('account_title,account_id');
		$this->db->from('accounts');
		$this->db->or_where('account_id',$broker);
		//$this->db->where('status','enable');		
		$query=$this->db->get();
		echo $this->db->last_query();
		return $query->result();
	}
	public function get_opening_balace($account_id)
	{
		$this->db->select('opening_balance');
		$this->db->from('accounts');
		$this->db->where('account_id',$account_id);
		$query = $this->db->get();
		return $query->result();
	}

	
	public function get_drcr($account_id,$orderby = '')
	{
		$this->db->select('amount,`payment_from`,`payment_to`,payment_type,detail,date,deleted')
		->from('transection')
		->where("(`payment_from` = $account_id OR `payment_to` = $account_id) and deleted='no'");
		//->where('payment_from',$account_id);		
		//->or_where('payment_to',$account_id);
		if($orderby)
			$this->db->order_by('date', 'desc');
		
		//$this->db->where('deleted','no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
	}
	public function save_bill($dataheader,$products)
	{
		$this->db->insert('supplier_bill',$dataheader);
		$bill_id = $this->db->insert_id();			
		$this->db->insert('supplier_bill_detail',$products);
		
		if($bill_id > 0)
			return true;
		else
			return false;
	}
	
	public function update_bill($dataheader,$products,$bill_id)
	{
		$this->db->where('bill_id',$bill_id);
		$this->db->update('supplier_bill',$dataheader);			
		//$this->db->insert('supplier_bill_detail',$products);
		return true;
	}
	public function get_total($id)
	{
		$this->db->select('payment_to,amount, sum(amount) as amount_sum')
			->from('transection')
			->where('payment_from',$id)
			->where('deleted','no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();			
	}
	public function get_total_dr($id)
	{
		$this->db->select('payment_to,amount, sum(amount) as amount_sum')
			->from('transection')
			->where('payment_to',$id)
			->where('deleted','no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();			
	}
}