<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
    }
	
	// get all tasks if no parameter supplied
	public function tasks_get()
	{
		$tasks = $this->items_model->get_all();
/*		if(! $this->get('id'))
		{
			// get all record
			$tasks = $this->task_model->get_all();
		} else {
			// get a record based on ID
			$tasks = $this->task_model->get_task($this->get('id'));
		}*/

		if($tasks)
		{
			$this->response($tasks, 200); // 200 being the HTTP response code
		} else {
			$this->response([], 404);
		}
	}
	
	public function tasks_post()
	{
		if(! $this->post('title') || !$this->post('itemtype'))
		{
			$this->response(array('error' => 'Missing post data: title'), 400);
		}
		else{
			$data = array(
				'item_title' => $this->post('title'),
				'item_type' => $this->post('itemtype')
			);
		}
		$this->db->insert('items',$data);
		if($this->db->insert_id() > 0)
		{
			$message = array('id' => $this->db->insert_id(), 'title' => $this->post('title'));
			$this->response($message, 200); // 200 being the HTTP response code
		}
	}
	
	public function items_delete($id=NULL)
	{
		if($id == NULL)
		{
			$message = array('error' => 'Missing delete data: id');
			$this->response($message, 400);
		} else {
			$this->items_model->delete_item($id);
			$message = array('id' => $id, 'message' => 'DELETED!');
			$this->response($message, 200); // 200 being the HTTP response code
		}
		
	}
	
	public function tasks_put()
	{
		//perform validation
		if(! $this->put('title'))
		{
			$this->response(array('error' => 'Task title is required'), 400);
		}
		
		$data = array(
			'title'		=> $this->put('title'),
			'status'	=> $this->put('status')
		);
		$this->task_model->update_task($this->put('id'), $data);
		$message = array('success' => $this->put('title').' Updated!');
		$this->response($message, 200);
	}
	
	
	public function get_inv_items_post()
	{
		//perform validation
		if(!$this->post('title'))
		{
			$this->response(array('error' => 'Task title is required'), 400);
		}
		$title = $this->post('title');
		$items = $this->task_model->get_items($title);
		if($items)
		{
			$this->response($items, 200); // 200 being the HTTP response code
		} else {
			$this->response([], 400);
		}
	}

}