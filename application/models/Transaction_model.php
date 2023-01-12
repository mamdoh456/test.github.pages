 <?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Transaction_model extends CI_Model
{
	private $table = 'transection';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function add_transaction($data)
	{
		if($this->db->insert($this->table,$data))
			return true;
		else
		{
			echo $this->db->_error_message();
			return false;
		}
	}

	
}