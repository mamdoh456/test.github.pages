<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
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
		return true;
	}
}