<?php
require APPPATH.'/libraries/REST_Controller.php';

class Itemsapi extends REST_Controller {
 
    public function __construct()
    {
        parent::__construct();	
		$this->load->model('items_model');	
		
    }
	
	public function inventory_items_get()
	{
		$result = $this->items_model->inventory_items();
		
		if($result)
		{
			$message = array($result);
			$this->response($message, 200); // 200 being the HTTP response code
		}
		else
		{
			$this->response(array('error' => 'something is wrong while saving data'), 400);
		}
		
	}
	
	
}