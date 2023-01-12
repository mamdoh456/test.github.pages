<?php
class Expence extends CI_Controller {
 
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
		if(!islogged()){
			redirect('login/login_form');
		}

       		$crud = new grocery_CRUD();
			$crud->set_table('expence_type');
			$crud->columns('type');
			$crud->required_fields('type');
			$crud->display_as('type','Expence Type');			
			$crud->set_subject('Expence Type');
			$html_title = 'Expences Type Managment';
			$this->load->vars( array( 'html_title' => $html_title) );
			$output = $crud->render();
        	$this->load->view('template.php', $output);  

    }//index
	
	public function expence()
	{
		$crud = new grocery_CRUD();
		$crud->columns('amount','expences_type','detail','date');
		$crud->set_table('expence');
		$crud->required_fields('expences_type','amount');
		$crud->set_relation('expences_type','expence_type','type');
		$crud->display_as('espences_type','Expence Type');
		$crud->set_subject('Expence');
		$html_title = 'Expences Managment';
		$this->load->vars( array( 'html_title' => $html_title) );
		$output = $crud->render();
        $this->load->view('template.php', $output);  
	}
	
	
}