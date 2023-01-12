<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_all()
	{
		$this->db->select('*')
		->from('items')
		->join('items_type', 'items.item_type = items_type.id')
		->order_by('item_title','asc');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function inv_items()
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->order_by('item_title','asc');
		$this->db->where('item_type', '3');
		$this->db->or_where('item_type', '4');
		$this->db->or_where('item_type', '5');
		$query= $this->db->get();
		return $query->result();
	}
	
	public function get_inv_item($id)
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->or_where('item_id', $id);
		$query= $this->db->get();
		return $query->row();
	}
	
	public function serv_items()
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->where('item_type', '1');
		$this->db->or_where('item_type', '2');
		$query= $this->db->get();
		return $query->result();
	}
	
	public function get_fixed()
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->where('fixed', 'yes');
		$this->db->where_in('item_type', array(1,2));
		$query= $this->db->get();
		return $query->result();
	}
	
	public function insert_item($data)
	{
		$this->db->insert('items',$data);		
	}
	
	public function get_item($id)
	{
		$this->db->select('*')
		->from('items')
		->join('items_type', 'items.item_type = items_type.id')
		->where('item_id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function delete_item($id)
	{
		$this->db->where('item_id',$id);
		$this->db->delete('items');
	}
	
	public function update_item($id, $data)
	{
		$this->db->where('item_id',$id);
		$this->db->update('items',$data);
	}
	
	public function inventory_items()
	{
		$this->db->select('item_id, item_title');
		$this->db->from('items');
		$query = $this->db->get();
		return $query->result();
	}
	public function search_ratio($val)
	{
		$this->db->select('item_id, ratio');
		$this->db->from('items');
		$this->db->where('item_id',$val);
		$query = $this->db->get();		
		return $query->result();
	}
	public function quick_sale()
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->where('quick_sale', 'yes');
		$this->db->where_in('item_type', array(3,4,5));
		$query= $this->db->get();
		return $query->result();
	}
}