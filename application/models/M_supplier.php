 <?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class M_supplier extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_name($supplier_name)
	{
		$this->db->select('*');
		$this->db->from('supplier');
		$this->db->like('name', $supplier_name);
		return $this->db->get()->result_array();
	}

	public function supplier_bill_heading($bill_head)
	{		
		$this->db->insert('supplier_bill',$bill_head);
		if($this->db->last_query())
			return $this->db->insert_id();
		
	}
	public function update_bill_header($bill_head,$bill_id)
	{
		$this->db->where('bill_id',$bill_id);
		$this->db->update('supplier_bill',$bill_head);
	}
	public function transection($payment)
	{
		$this->db->insert('transection',$payment);
	}
	public function supplier_bill_inventory($bill_detail)
	{
		$this->db->insert('supplier_bill_inv',$bill_detail);
	}
	public function supplier_bill_services($sev_detail)
	{
		$this->db->insert('supplier_bill_sev',$sev_detail);
	}
	public function edit_bill_head($id)
	{
		$this->db->select('*');
		$this->db->from('supplier_bill');
		$this->db->where('bill_id',$id);
		$this->db->join('accounts','account_id=bill_from');
		$query = $this->db->get();
		return $query->result();
	}
	public function edit_bill_inv($id)
	{
		$this->db->select('*,s.weight_mun_bag as weight');
		$this->db->from('supplier_bill_inv s');		
		$this->db->where('bill_id',$id);
		$this->db->join('items i','i.item_id=s.inv_name');
		$query = $this->db->get();
		return $query->result();
	}
	public function edit_transection($id)
	{
		$this->db->select('*');
		$this->db->from('transection t');		
		$this->db->where('bill_invoice_id',$id);	
		$this->db->where('type','bill');	
		$query = $this->db->get();
		return $query->result();
	}
	public function edit_bill_sev($id)
	{
		$this->db->select('*');
		$this->db->from('supplier_bill_sev s');
		$this->db->where('bill_id',$id);
		$this->db->join('items i','i.item_id=s.sev_name');
		$this->db->join('accounts a','a.account_id=s.account_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function delete_inv_sev_bill($id)
	{				
		$this->db->where('bill_id',$id);
		$this->db->delete('supplier_bill_inv');
		
		$this->db->where('bill_id',$id);
		$this->db->delete('supplier_bill_sev');
		
		$this->db->where('bill_invoice_id',$id);
		$this->db->delete('transection');
	}
	public function supplier_total_bill($name)
	{
		$this->db->select('*');
		$this->db->from('supplier_bill');
		$this->db->where('bill_from',$name);
		$query=$this->db->get();
		return $query->result();
	}
	public function get_supplier_bills($customer,$start_date,$end_date)
	{
		$this->db->select('*');
		$this->db->from('supplier_bill sb')
		->join('accounts a','a.account_id=sb.bill_from');
		$this->db->where('sb.deleted','no');
		if(!empty($customer))
			$this->db->where('bill_from',$customer);
			
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("sb.bill_date BETWEEN '$start_date' AND '$end_date'");
		}
			
		$query = $this->db->get();
		return $query->result();
	}
	public function bill_detail_view($name)
	{
		$this->db->select('*');
		$this->db->from('supplier_bill');
		$this->db->where('bill_from',$name);
		$this->db->join('accounts','bill_from=account_id');
		$this->db->join('transection','bill_id=bill_invoice_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function bill_list_view()
	{
		$this->db->select('*');
		$this->db->from('supplier_bill');
		$this->db->join('accounts','bill_from=account_id');
		$this->db->join('transection','bill_id=bill_invoice_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function bill_delete($id,$data)
	{		
		$this->db->where('bill_id',$id);
		$this->db->update('supplier_bill',$data);
	}
	public function bill__transection_delete($id,$data)
	{		
		$this->db->where('bill_invoice_id',$id);
		$this->db->where('type','bill');
		$this->db->update('transection',$data);
	}

	
}