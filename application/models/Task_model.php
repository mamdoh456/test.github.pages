<?php

class Task_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_all()
	{
		$query = $this->db->get('task');
		return $query->result();
	}
	
	public function get_task($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('task');
		return $query->result();
	}
	
	public function get_items($title)
	{
		$this->db->select('item_title');
		$where = "item_title like '%".$title."%' and item_type in (3,4,5)";
		$this->db->where($where);
		$query = $this->db->get('items');
		return $query->result();
	}
	
	public function delete_task($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('task');
	}
	
	public function update_task($id, $data)
	{
		$this->db->where('id',$id);
		$this->db->update('task',$data);
	}
}