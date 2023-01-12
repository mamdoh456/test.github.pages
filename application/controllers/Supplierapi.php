<?php
require APPPATH.'/libraries/REST_Controller.php';

class Supplierapi extends REST_Controller{
 
    function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
    }
	
	
	public function bill_post()
	{
		$dataheader = array(
			'bill_from'=>$this->post('bill_from'),
			'bill_no'=>$this->post('bill_no'),
			'vehical_no'=>$this->post('vehical_no'),
			'driver_name'=>$this->post('driver_name'),
			'phone_no'=>$this->post('phone_no'),
			'paid_amount'=>$this->post('paid_amount'),
			'bill_date'=>$this->post('bill_date')
		);
		
		$dataproducts = array();
		
		if($bill_id = $this->post('bill_id'))
			$result = $this->supplier_model->update_bill($dataheader,$dataproducts,$bill_id);
		else
			$result = $this->supplier_model->save_bill($dataheader,$dataproducts);
		
		if($result)
		{
			$message = array('id' => $this->db->insert_id(), 'title' => $this->post('bill_from'),'message',$result);
			$this->response($message, 200); // 200 being the HTTP response code
		}
		else
		{
			$this->response(array('error' => 'something is wrong while saving data'), 400);
		}

	}
	
	public function get_inventory_items()
	{
		$this->load->model('m_items');
		$result = $this->supplier_model->inventory_itemsl($dataheader,$dataproducts,$bill_id);
		
		if($result)
		{
			$message = array('id' => $this->db->insert_id(), 'title' => $this->post('bill_from'),'message',$result);
			$this->response($message, 200); // 200 being the HTTP response code
		}
		else
		{
			$this->response(array('error' => 'something is wrong while saving data'), 400);
		}

	}
	
}