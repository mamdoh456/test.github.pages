 <?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');

class Config_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_config_data(){
		$this->db->select('*');
		$this->db->from('company_config');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->row();
	}
	public function updateconfig($data)
	{
		$this->db->update('company_config',$data);
		//echo $this->db->last_query();
	}
}