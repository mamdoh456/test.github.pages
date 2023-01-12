 <?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Report_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_weight_item($item='',$start_date='',$end_date='')
	{
		$this->db->select('*,sum(i.inv_quantity) as total_weight');
		$this->db->from('supplier_bill s');
		$this->db->where('s.deleted','no');
		if($item)
			$this->db->where('inv_name',$item);
			
		if($start_date)		
			$this->db->where('bill_date >=',$start_date);
			
		if($end_date)
			$this->db->where('bill_date <=',$end_date);
			
		$this->db->join('supplier_bill_inv i','i.bill_id=s.bill_id');
		$this->db->join('accounts a','a.account_id=s.bill_from');
		$this->db->group_by('i.bill_id');
		$this->db->order_by('s.bill_date','desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getcr($start_date = '',$end_date='')
	{
		$this->db->select('* , c.account_type')
			->from('transection t')
			->join('accounts a', 't.payment_from = a.account_id')
			->join('accounts_type c' , 'c.type_id = a.account_type');
			$this->db->where('t.deleted','no');
			if(!empty($start_date) && !empty($end_date))
				$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
				
			$query = $this->db->get();
			return $query->result();
	}
	public function getdr($start_date = '',$end_date='')
	{
		$this->db->select('* , c.account_type')
			->from('transection t')
			->join('accounts a', 't.payment_to = a.account_id')
			->join('accounts_type c' , 'c.type_id = a.account_type');
			$this->db->where('t.deleted','no');
			if(!empty($start_date) && !empty($end_date))
				$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
								
			$query = $this->db->get();
			return $query->result();
	}
	public function get_quick_sale($start_date = '')
	{
			$this->db->select('* , sum(s.total) as total')
			->from('quick_sale s')
			->join('items i', 'i.item_id = s.item_id');
			$this->db->group_by('s.item_id');
			if(!empty($start_date))
				$this->db->like("sale_date",$start_date);
				
			$query = $this->db->get();
			return $query->result();
	}
	public function get_bale($customer='',$inv_items='',$start_date='',$end_date='')
	{
		$this->db->select('invoice_to,a.account_title,bales,s.weight_mun_bag,date,sum(n.inv_quantity) as weight,n.inv_price,i.tax_amount,i.invoice_no,i.lot_no,i.customer_total,s.item_type,s.item_title,i.deleted')
		->from('invoice i')
		->join('accounts a','i.invoice_to=a.account_id')
		->join('invoice_inventory n','i.invoice_id=n.invoice_id')
		->join('items s','s.item_id=n.inv_name');
		$this->db->where('i.deleted','no');
		$this->db->group_by('i.invoice_id');
		$this->db->order_by('date','desc');
		if($customer)
			$this->db->where('invoice_to',$customer);
			
		if($inv_items)
			$this->db->where('n.inv_name',$inv_items);
			
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
			if(sizeof($query->result())>0)
				return $query->result();
			else {
				echo $this->db->error();
				return false;
			}
	}
	public function parta_report($inv_items='',$start_date='',$end_date='')
	{	
		$this->db->select('invoice_to,invoice_total,s.item_title,a.account_title,bales,s.weight_mun_bag,date,sum(n.inv_quantity) as weight,n.inv_price,i.tax_amount,i.invoice_no,i.lot_no')
		->from('invoice i')
		->join('accounts a','i.invoice_to=a.account_id')
		->join('invoice_inventory n','i.invoice_id=n.invoice_id')
		->join('items s','s.item_id=n.inv_name');
		$this->db->where('i.deleted','no');
		$this->db->group_by('i.invoice_id');
		$this->db->order_by('date','desc');
		if($customer)
			$this->db->where('invoice_to',$customer);
			
		if($inv_items)
			$this->db->where('n.inv_name',$inv_items);
			
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
			if(sizeof($query->result())>0)
				return $query->result();
			else {
				echo $this->db->error();
				return false;
			}
	}
	public function get_purcahse($supplier='',$inv_items='',$start_date='',$end_date='')
	{
		$this->db->select('bill_from,a.account_title,bales,bill_date,sum(n.inv_quantity) as weight,n.inv_price,s.tax_amount,s.bill_no,s.supplier_total,t.item_type,n.weight_mun_bag,t.item_title')
		->from('supplier_bill s')
		->join('accounts a','s.bill_from=a.account_id')
		->join('supplier_bill_inv n','s.bill_id=n.bill_id')
		->join('items t','t.item_id=n.inv_name');
		$this->db->where('s.deleted','no');
		$this->db->group_by('s.bill_id');
		$this->db->order_by('bill_date','desc');
		if($supplier)
			$this->db->where('bill_from',$supplier);
	
		if($inv_items)
			$this->db->where('n.inv_name',$inv_items);
	
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("bill_date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
			if(sizeof($query->result())>0)
				return $query->result();
			else {
				echo $this->db->error();
				return false;
			}
	}
	public function broker_report($inv_items='',$broker='',$start_date='',$end_date='')
	{
		$this->db->select('invoice_to,sum(n.inv_price) as rate,a.account_title,s.account_title as broker,bales,date,sum(n.inv_quantity) as weight,i.lot_no,i.invoice_total,')
		->from('invoice i')
		->join('accounts a','i.invoice_to=a.account_id')
		->join('accounts s','i.broker_id=s.account_id')
		->join('invoice_inventory n','i.invoice_id=n.invoice_id');
		$this->db->where('i.deleted','no');
		$this->db->group_by('i.invoice_id');
		if($broker)
			$this->db->where('broker_id',$broker);
	
		if($inv_items)
			$this->db->where('inv_name',$inv_items);
	
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
			if(sizeof($query->result())>0)
				return $query->result();
			else {
				return false;
			}
	}
	public function broker_bill_report($inv_items='',$broker='',$start_date='',$end_date='')
	{
		$this->db->select('bill_from,sum(n.inv_price) as rate,a.account_title,b.account_title as broker,bales,bill_date,sum(n.inv_quantity) as weight,s.supplier_total')
		->from('supplier_bill s')
		->join('accounts a','s.bill_from=a.account_id')
		->join('accounts b','s.broker_id=b.account_id')
		->join('supplier_bill_inv n','s.bill_id=n.bill_id');
		$this->db->where('s.deleted','no');
		$this->db->group_by('s.bill_id');
		if($broker)
			$this->db->where('broker_id',$broker);
	
		if($inv_items)
			$this->db->where('inv_name',$inv_items);
	
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("bill_date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
			if(sizeof($query->result())>0)
				return $query->result();
			else {
				return false;
			}
	}
	
	public function record_count() 
	{
		return $this->db->count_all("supplier_bill_sev");
		}
	
	public function services_report($services='',$account_name='',$start_date='',$end_date='')
	{		
		$this->db->select('i.item_title,s.sev_price,a.account_title,t.account_type,b.bill_date')
		->from('supplier_bill_sev s')
		->join('accounts a','a.account_id=s.account_id')
		->join('items i','i.item_id=s.sev_name')
		->join('accounts_type t','t.type_id=a.account_type')
		->join('supplier_bill b','s.bill_id = b.bill_id');
		$this->db->where('b.deleted','no');
		$this->db->order_by('b.bill_date','desc');
		if($services)
			$this->db->where('sev_name',$services);
			
		if($account_name)
			$this->db->where('s.account_id',$account_name);
			
		if(!empty($start_date) && !empty($end_date)) {
				$this->db->where("b.bill_date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
		if(sizeof($query->result())>0)
				return $query->result();
			else {
				echo $this->db->error();
				return false;
			}
	}
	
	public function services_report_sale($services='',$account_name='',$start_date='',$end_date='')
	{		
		$this->db->select('i.item_title,s.sev_price,a.account_title,t.account_type,b.date')
		->from('invoice_services s')
		->join('accounts a','a.account_id=s.account_id')
		->join('items i','i.item_id=s.sev_name')
		->join('accounts_type t','t.type_id=a.account_type')
		->join('invoice b','s.invoice_id = b.invoice_id');
		$this->db->order_by('b.date','desc');
		$this->db->where('b.deleted','no');
		if($services)
			$this->db->where('sev_name',$services);
			
		if($account_name)
			$this->db->where('s.account_id',$account_name);
			
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("b.date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
		if(sizeof($query->result())>0)
				return $query->result();
			else {
				echo $this->db->error();
				return false;
			}
	}
	public function quick_sale_report($inv_items='',$start_date='',$end_date='')
	{
		$this->db->select('*')
		->from('quick_sale s')
		->join('items i','i.item_id=s.item_id');
		$this->db->order_by('i.item_title');
		if($inv_items)
			$this->db->where('s.item_id',$inv_items);
			
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->like("sale_date ",$start_date);
		}
		$query = $this->db->get();
			if(sizeof($query->result())>0)
				return $query->result();
			else {
				echo $this->db->error();
				return false;
			}
	}
	
	public function get_account_cr($start_date = '',$end_date='')
	{
			$this->db->select('a.account_title ,a.account_id, c.account_type,sum(amount)as amount')
			->from('transection t')
			->join('accounts a', 't.payment_from = a.account_id')
			->join('accounts_type c' , 'c.type_id = a.account_type');
			$this->db->where('t.deleted','no');
			if(!empty($start_date) && !empty($end_date))
				$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
				
			$this->db->group_by('a.account_id');
			$query = $this->db->get();
			return $query->result();
	}
	public function get_account_dr($start_date = '',$end_date='')
	{
			$this->db->select('a.account_title,a.account_id, c.account_type , sum(amount) as amount')
			->from('transection t')
			->join('accounts a', 't.payment_to = a.account_id')
			->join('accounts_type c' , 'c.type_id = a.account_type');
			$this->db->where('t.deleted','no');
			if(!empty($start_date) && !empty($end_date))
				$this->db->where("date BETWEEN '$start_date' AND '$end_date'");				
			
			$this->db->group_by('a.account_id');
			$query = $this->db->get();
			return $query->result();
	}
	
	
	public function get_items($customer='',$inv_items='',$start_date='',$end_date='')
	{
		$this->db->select('invoice_to,a.account_title,bales,s.weight_mun_bag,date,sum(n.inv_quantity) as weight,n.inv_price,i.tax_amount,i.invoice_no,i.lot_no,i.customer_total,s.item_type,s.item_title,i.deleted,n.kat,n.inv_name')
		->from('invoice i')
		->join('accounts a','i.invoice_to=a.account_id')
		->join('invoice_inventory n','i.invoice_id=n.invoice_id')
		->join('items s','s.item_id=n.inv_name');
		$this->db->where('i.deleted','no');
		if($inv_items == '')
			$this->db->group_by('n.inv_name');

		$this->db->order_by('date','desc');
		if($customer)
			$this->db->where('invoice_to',$customer);
	
		if($inv_items) {
			$this->db->where('n.inv_name',$inv_items);
			$this->db->group_by('i.invoice_id');
		}
		if(!empty($start_date) && !empty($end_date)) {
			$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
		}
		$query = $this->db->get();
			if(sizeof($query->result())>0)
				return $query->result();
			else {
				echo $this->db->error();
				return false;
			}
	}
		
}