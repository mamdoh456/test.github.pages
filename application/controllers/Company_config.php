<?php
class Company_config extends CI_Controller {
 
    /*	
	 *	@author 	: Tahir Iqbal
	 *	date		: 03 March, 2016
	 *	Ginners Accounts Managements System
	 *	www.idlbridge.com
	 *  Mob : 03457050405
	 */
    public function __construct()
    {
        parent::__construct();		
		$this->load->model('config_model');             
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {
		if(!islogged()){
			redirect('login/login_form');
		}
		
		if(isset($_POST['update']))
		{
			$data = array(
				'company_name'=>$this->input->post('company_name'),
				'phone_no'=>$this->input->post('phone_no'),
				'address'=>$this->input->post('address'),
				's_t_r_no'=>$this->input->post('s_t_r_no'),
				'ntn_no'=>$this->input->post('ntn_no'),
				'broker_ratio'=>$this->input->post('broker_ratio'),
				'broker_tax_ratio'=>$this->input->post('broker_tax_ratio')
			);
			
			$this->config_model->updateconfig($data);
		}
		$data['config'] = $this->config_model->get_config_data();
        $this->load->view('config',$data);

    }//index
	
	function _callback_webpage_url($value, $row)
	{
		return "<a href='".site_url('accounts/account_detail/'.$row->account_id)."'>View Transactions</a>";
	}
	
	public function account_type()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('accounts_type');
		$crud->columns('type_id','account_type');	
		$crud->required_fields('account_type');	
		$crud->display_as('account_type','Account Type');
		$crud->callback_before_delete(array($this,'log_user_before_delete'));
		$crud->set_subject('Accounts Type');
		$html_title = 'Accounts Types Management';
		$this->load->vars( array( 'html_title' => $html_title) );
		$output = $crud->render();
        $this->load->view('template.php', $output);  
	}
	
	public function account_detail($account_id)
	{
		$account_id = (int)$account_id;
		$data['account_id'] = $account_id;
		$data['account_details'] = $this->accounts_model->get_account($account_id);
		$data['opening_balance'] = $this->accounts_model->get_opening_balace($account_id);
		$orderby  = 'date';
		$data['drcr'] = $this->accounts_model->get_drcr($account_id,$orderby);
		//echo '<pre>';
		//print_r($data);
		$this->load->view('account_detail', $data); 
	}
	
	function log_user_before_delete($primary_key)
	{
		$ids = array(1,2,3,4,5);
		if(in_array($primary_key,$ids))
		return false;
		else
		return true;    	
	}
	
	
	function backup_db()
    {
    		$this->load->dbutil();
    		$prefs = array(
				'format'      => 'zip',
				'filename'    => 'ams.sql'
    		);
    		 
    		$backup =& $this->dbutil->backup($prefs);
    		 
			$file_name = 'accountsmanagemts-' . date("Y-m-d-H-i-s") .'.zip';
    		$save = 'uploads/'.$file_name;
    		$this->load->helper('download');
    		while (ob_get_level()) {
    			ob_end_clean();
    		}
    		force_download($file_name, $backup);
    }
	
}