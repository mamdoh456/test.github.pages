<?php
class Customer extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();		
		$this->load->library('grocery_CRUD');
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

       		$crud = new grocery_CRUD();
			$crud->set_table('customers');
			$crud->columns('name','company','phone','address','opening_balance','opening_balance_date','status');
			$crud->required_fields('name');
			$crud->display_as('name','Customer Name');
			$crud->display_as('opening_balance','Opening Blance');
			$crud->display_as('opening_balance_date','Opening Blance as of');
			$crud->unset_columns('customer_id');
			$crud->set_subject('Customer');
			//$crud->callback_column('total_purchasing',array($this,'total_purchasing'));
			//$crud->callback_column('total_payment',array($this,'total_payment'));
			//$crud->callback_column('total',array($this,'total'));
			//$crud->callback_column('transaction',array($this,'_callback_webpage_url'));
			$html_title = 'Customer Managment';
			$this->load->vars( array( 'html_title' => $html_title) );
			$output = $crud->render();
        	$this->load->view('template.php', $output);  

    }//index
	
	
}