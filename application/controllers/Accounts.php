<?php
class Accounts extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();		
		$this->load->library('grocery_CRUD');
		$this->load->model('accounts_model');             
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

       		$crud = new grocery_CRUD();
			$crud->set_table('accounts');
			$crud->set_relation('account_type','accounts_type','account_type');	
			$crud->columns('account_title','account_type','phone','address','opening_balance','view_transaction','status','created_at');
			$crud->fields('account_title','account_type','phone','address','opening_balance','status','reg_no','ntn_no');
			$crud->required_fields('account_title','account_type','status');
			$crud->display_as('account_title','Account Title');
			$crud->display_as('reg_no','Registration No.');
			$crud->display_as('ntn_no','NTN No.');
			$crud->display_as('account_type','Account Type');
			$crud->display_as('opening_balance','Opening Balance');
			$crud->callback_column('view_transaction',array($this,'_callback_webpage_url'));
			$crud->unset_columns('employee_id');
			$crud->set_subject('Accounts');			
			$html_title = 'Accounts Managment';
			$this->load->vars( array( 'html_title' => $html_title) );
			$output = $crud->render();
        	$this->load->view('template.php', $output);  

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
		$ids = array(1,2,3,4,5,6,7);
		if(in_array($primary_key,$ids))
		return false;
		else
		return true;    	
	}
	
}