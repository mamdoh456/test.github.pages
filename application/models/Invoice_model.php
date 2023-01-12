 <?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Invoice_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function invoice_heading($bill_head)
	{		
		$this->db->insert('invoice',$bill_head);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	}
	public function update_invoice_header($id,$data)
	{
		$this->db->where('invoice_id', $id);
		$this->db->update('invoice', $data);
	}
	public function delete_inv_ser_items($id)
	{
		$this->db->where('invoice_id',$id);
		$this->db->delete('invoice_inventory');
		$this->db->where('invoice_id',$id);
		$this->db->delete('invoice_services');
		$this->db->where('bill_invoice_id',$id);
		$this->db->delete('transection');
	}
	
	public function transection($payment)
	{
		$this->db->insert('transection',$payment);
	}
	public function invoice_inventory($bill_detail)
	{
		$this->db->insert('invoice_inventory',$bill_detail);
	}
	public function invoice_services($sev_detail)
	{
		$this->db->insert('invoice_services',$sev_detail);
	}
	public function get_header($id)
	{
		$this->db->select('*');
		$this->db->from('invoice');
		$this->db->where('invoice_id',$id);
		$this->db->join('accounts','invoice_to=account_id');
		$query = $this->db->get();
		return $query->row();
	}
	public function get_transection($id)
	{
		$this->db->select('*');
		$this->db->from('transection t');		
		$this->db->where('bill_invoice_id',$id);
		$this->db->where('type','invoice');	
		$this->db->join('accounts a','t.payment_from=a.account_id');	
		$query = $this->db->get();
		return $query->result();
	}
	public function get_inv_items($id)
	{
		$this->db->select('* ,t.weight_mun_bag as weight');
		$this->db->from('invoice_inventory i');		
		$this->db->where('i.invoice_id',$id);
		$this->db->join('items t','t.item_id=i.inv_name');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_sev_items($id)
	{
		$this->db->select('*');
		$this->db->from('invoice_services s');
		$this->db->where('invoice_id',$id);
		$this->db->join('items i','i.item_id=s.sev_name');
		$this->db->join('accounts a','a.account_id=s.account_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function invoice_head_update($id,$bill_head)
	{
		$this->db->where('invoice_id',$id);
		$this->db->delete('invoice');
		$this->db->where('invoice_id',$id);
		$this->db->delete('invoice_inventory');
		$this->db->where('invoice_id',$id);
		$this->db->delete('invoice_services');
		$this->db->where('bill_invoice_id',$id);
		$this->db->delete('transection');
	}
	public function customer_total_bill($name)
	{
		$this->db->select('*');
		$this->db->from('supplier_bill');
		$this->db->where('bill_from',$name);
		$query=$this->db->get();
		return $query->result();
	}

	public function invoices_list($customer='',$start_date='',$end_date='')
	{
		$this->db->select('*')
		->from('invoice')
		->join('accounts','invoice_to=account_id')
		->order_by('date','asc');
		$this->db->where('deleted','no');
		if(!empty($customer))
			$this->db->where('invoice_to',$customer);
			
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
		return $query->result();
	}
	public function quick_sale($sale_detail)
	{
		$this->db->insert('quick_sale',$sale_detail);
	}
	public function invoice_delete($id,$data)
	{	
		$this->db->where('bill_invoice_id',$id);
		$this->db->where('type','invoice');
		$this->db->update('transection',$data);
		
		$this->db->where('invoice_id',$id);
		$this->db->update('invoice',$data);
	}
}