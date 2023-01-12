<?php
class Items extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');		
		
    }
 
    public function index()
    {
		if(!islogged()){
			redirect('login/login_form');
		}
		
		$data['items'] = $this->items_model->get_all();
		$this->load->view('items_view',$data);
    }//index
	public function add_item()
	{
		/*echo "<pre>";
		print_r($this->input->post());
		exit;*/
		$item_title = $this->input->post('item_title');
		$item_type = $this->input->post('item_type');
		$weight_mun_bag = $this->input->post('weight_mun_bag');
		$fixed = $this->input->post('fixed');
		$ratio = $this->input->post('ratio');
		$price_mun = $this->input->post('price_mun');
		$quick_sale = $this->input->post('quick_sale');
		if(!$quick_sale)
			$quick_sale = 'no';

		if(!$ratio)
			$ratio = '0.000';
			
		if(!$price_mun)
			$price_mun = '0.000';
		
		$data = array(
			'item_title'=>$item_title,
			'item_type'=>$item_type,
			'weight_mun_bag'=>$weight_mun_bag,
			'fixed'=>$fixed,
			'ratio'=>$ratio,
			'price'=>$price_mun,
			'quick_sale'=>$quick_sale
		);
		$this->items_model->insert_item($data);
		redirect('/items', 'refresh');
		
	}
	public function item_delete($id)
	{
		$id = (int)$id;
		$this->items_model->delete_item($id);
		redirect('/items', 'refresh');
		
	}
	public function update_item()
	{
		
		$item_id = $this->input->post('item_id');
		$item_title = $this->input->post('item_title');
		$item_type = $this->input->post('item_type');
		$weight_mun_bag = $this->input->post('weight_mun_bag');
		$fixed = $this->input->post('fixed');
		$ratio = $this->input->post('ratio');
		$price_mun = $this->input->post('price_mun');
		$quick_sale = $this->input->post('quick_sale');
		if(!$quick_sale)
			$quick_sale = 'no';

		if(!$ratio)
			$ratio = '0.000';

		if(!$price_mun)
			$price_mun = '0.000';
			
		
		$data = array(
			'item_title'=>$item_title,
			'item_type'=>$item_type,
			'weight_mun_bag'=>$weight_mun_bag,
			'fixed'=>$fixed,
			'ratio'=>$ratio,
			'price'=>$price_mun,
			'quick_sale'=>$quick_sale
		);
		$this->items_model->update_item($item_id,$data);
		redirect('/items', 'refresh');
		
	}
	public function item_update($id)
	{
		$id = (int)$id;
		$data['item'] = $this->items_model->get_item($id);
		$data['items'] = $this->items_model->get_all();
		$this->load->view('items_view',$data);
			
	}
	public function item_type(){
		$this->load->model('m_items');
		$data['mydata']=$this->m_items->items_type();
		$this->load->view('items_view',$data);
		}
		
	public function search_ratio()
    {
        $search_data = $this->input->post('search_data');
        $query = $this->items_model->search_ratio($search_data);

        foreach ($query as $row):
            echo $row->ratio;
        endforeach;
    }
	
	
}