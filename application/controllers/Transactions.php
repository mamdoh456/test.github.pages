<?php
class Transactions extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();		
		$this->load->library('grocery_CRUD');
		$this->load->helper('user_helper');
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
			$crud->fields('payment_from','payment_to','amount','detail','date');
			$crud->columns('payment_from','payment_to','amount','detail','date');
			$crud->set_table('transection');
			$crud->where('type',' ');
    		//$crud->where('type ','!= invoice');
			$crud->set_relation('payment_from','accounts','account_title');
			$crud->set_relation('payment_to','accounts','account_title');
			$crud->display_as('payment_to','Payment To');
			$crud->display_as('payment_from','Payment From');
			$crud->display_as('payment_type','Payment Type');
			$crud->required_fields('payment_from','payment_to','amount','detail','date');
			$crud->set_subject('Transection');			
			//$crud->set_theme('datatables');
			$crud->callback_before_insert(array($this, 'callback_before_insert'));	
			//$crud->callback_before_insert(array($this, 'callback_before_insert_amount'));		
			
			//$crud->callback_before_update(array($this, 'callback_before_insert_amount'));
			$crud->callback_before_update(array($this, 'callback_before_insert'));
			$crud->callback_before_delete(array($this,'log_user_before_delete'));
			$crud->callback_column('detail', array($this, '_full_text'));
			$html_title = 'Transection Managment';
			$this->load->vars( array( 'html_title' => $html_title) );
			$output = $crud->render();
        	$this->load->view('template.php', $output);  

    }//index
	
	
	function _callback_before_insert()
	{
		$this->form_validation->set_message('payment_to', 'A user with this firstname, lastname and date of birth already exists');
    	return FALSE;
	}
	function callback_before_insert($post_array){
		//$amount = $post_array['amount'];
		//$post_array['amount'] = amount($amount);
		//$date_db = $post_array['date'];		
		//$post_array['date'] = date_change_db($date_db);
		$payment_to = $post_array['payment_to'];
		$payment_from = $post_array['payment_from'];
		if(strcmp($payment_to,$payment_from) == 0){
				return false;
			}
		else {			
		$amount = $post_array['amount'];
		$post_array['amount'] = amount($amount);
		return $post_array;			}
		 //return true;
	}
	
	function _full_text($value, $row)
	{
			return $value = wordwrap($row->detail, 50, "<br>", true);
	}
	function log_user_before_delete()
	{
		//$ids = array(1,2,3,4,5,6);
		//if(in_array($primary_key,$ids))
		return false;
    	
	}
	function callback_before_insert_date($post_array){
		$date_db = $post_array['date'];
		$post_array['date'] = date_change_crud($date_db);
		return $post_array;
	}
	function callback_before_insert_amount($post_array){
		$amount = $post_array['amount'];
		$post_array['amount'] = amount($amount);
		return $post_array;
	}
	
	
}

