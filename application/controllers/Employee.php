<?php
class Employee extends CI_Controller {
 
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
			$crud->set_table('employee');
			$crud->columns('name','gender','phone','address','status');
			$crud->required_fields('name','username','password');
			$crud->display_as('name','Employee Name');
			$crud->display_as('gender','Gender');
			$crud->unset_columns('employee_id');
			$crud->set_subject('Employee');
			//$crud->callback_column('total_purchasing',array($this,'total_purchasing'));
			//$crud->callback_column('total_payment',array($this,'total_payment'));
			//$crud->callback_column('total',array($this,'total'));
			//$crud->callback_column('transaction',array($this,'_callback_webpage_url'));
			$html_title = 'Employees Managment';
			$this->load->vars( array( 'html_title' => $html_title) );
			$output = $crud->render();
        	$this->load->view('template.php', $output);  

    }//index
	
	public function employee_salary()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('employee_salary');
		$crud->set_relation('empolyee_id','employee','name');		
		$crud->display_as('empolyee_id','Employee Name');
		$crud->display_as('salary_type','Salary Type');
		$html_title = 'Employee Salary Management';
		$this->load->vars( array( 'html_title' => $html_title) );
		$output = $crud->render();
        $this->load->view('template.php', $output);  
	}
	
	
}