 <?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class M_login extends CI_Model

{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function takeUser($username, $password)	
	{	
		$this->db->select('username');	
		$this->db->from('employee');	
		$this->db->where('username', $username);	
		$this->db->where('password', $password);	
		$query = $this->db->get();	
		return $query->num_rows();	
	}
	
	public function userData($username)	
	{	
		$this->db->select('username');	
		$this->db->select('name');	
		$this->db->where('username', $username);	
		$query = $this->db->get('employee');	
		return $query->row();	
	}

}

