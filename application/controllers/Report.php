<?php
class Report extends CI_Controller {
 
    /*	
	 *	@author 	: Tahir Iqbal
	 *	date		: 03 March, 2016
	 *	Ginners Accounts Managements System
	 *	www.idlbridge.com
	 *  Mob : 03457050405
	 *  Email: tahiriqbal09@gmail.com
	 */
    public function __construct()
    {
        parent::__construct();		
		$this->load->library('grocery_CRUD');
		$this->load->library('pagination');
		$this->load->model('report_model');
		$this->load->model('items_model');
		$this->load->model('config_model');
		$this->load->model('accounts_model');
		$this->load->helper('user_helper');
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {	
		if (!islogged()) {
			redirect('login/login_form');
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['date_range'])) {
			$start_date = date_range_db1($this->input->post('date_range'));
			$end_date = date_range_db2($this->input->post('date_range'));
			$start_date1 = date_change_db($start_date);
			$end_date1 = date_change_db($end_date);
			$inv_item = $this->input->post('inv_items');
			$data['date_report'] = $this->report_model->get_weight_item($inv_item, $start_date1, $end_date1);
			$data['selected_item'] = $this->items_model->get_inv_item($inv_item);
			$data['inv_items'] = $this->items_model->inv_items();
    		$this->load->view('Reports/report', $data);
		}
		else {
			$data['inv_items'] = $this->items_model->inv_items();		
			$this->load->view('Reports/report', $data);
		}
	}
	
	public function drcr_report()
	{
		if ($this->input->post('date_range')) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$data['credits'] = $this->report_model->getcr($start_date, $end_date);
			$data['debits'] = $this->report_model->getdr($start_date, $end_date);
			
		}
		$this->load->view('Reports/report_drcr', $data);
	}
	public function bale_report()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$customer = $this->input->post('customer');
			$inv_items = $this->input->post('inv_items');
			$data['bale_report'] = $this->report_model->get_bale($customer, $inv_items, $start_date, $end_date);
			$data['customer']= $this->accounts_model->get_customers();
			$data['config'] = $this->config_model->get_config_data();
			$data['selected_item'] = $this->items_model->get_inv_item($inv_items);
			$data['acnt'] = $this->accounts_model->get_account($customer);
			$data['inv_item'] = $this->items_model->inv_items();
			$data['total'] = $this->accounts_model->get_total($customer);
			$data['total_dr'] = $this->accounts_model->get_total_dr($customer);
			$this->load->view('Reports/bales_report',$data);
		}
		else {
			$data['customer']= $this->accounts_model->get_customers();
			$data['config'] = $this->config_model->get_config_data();
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/bales_report',$data);
		}
	}
	public function purchase_report()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$supplier = $this->input->post('supplier');
			$inv_items = $this->input->post('inv_items');
			$data['bale_report'] = $this->report_model->get_purcahse($supplier,$inv_items,$start_date,$end_date);
			$data['supplier']= $this->accounts_model->get_suppliers();
			$data['config'] = $this->config_model->get_config_data();
			$data['selected_item'] = $this->items_model->get_inv_item($inv_items);
			$data['acnt'] = $this->accounts_model->get_account($supplier);
			$data['inv_item'] = $this->items_model->inv_items();
			$data['total'] = $this->accounts_model->get_total($supplier);
			$data['total_dr'] = $this->accounts_model->get_total_dr($supplier);
			$this->load->view('Reports/report_purchase',$data);
		}
		else {
			$data['supplier']= $this->accounts_model->get_suppliers();
			$data['config'] = $this->config_model->get_config_data();
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/report_purchase', $data);
		}
	}
	public function parta_report()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['inv_items'])) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$inv_items = $this->input->post('inv_items');
			$data['parta_report'] = $this->report_model->parta_report($inv_items, $start_date, $end_date);
			//$data['supplier']= $this->accounts_model->get_suppliers();
			$data['config'] = $this->config_model->get_config_data();
			$data['selected_item'] = $this->items_model->get_inv_item($inv_items);
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/report_prta', $data);
		}
		else {
			//$data['supplier']= $this->accounts_model->get_suppliers();
			$data['config'] = $this->config_model->get_config_data();
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/report_prta', $data);
		}
		
	}
	public function broker_report_purchase()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$broker = $this->input->post('broker');
			$inv_items = $this->input->post('inv_items');			
			$data['broker_bill_report'] = $this->report_model->broker_bill_report($inv_items, $broker, $start_date, $end_date);
			$data['broker']= $this->accounts_model->get_brokers();
			$data['broker_name']= $this->accounts_model->get_brokers_name($broker);
			$data['selected_item'] = $this->items_model->get_inv_item($inv_items);
			$data['inv_item'] = $this->items_model->inv_items();
			$data['config'] = $this->config_model->get_config_data();
			$this->load->view('Reports/broker_report_purchase',$data);
		}
		else {
			$data['broker']= $this->accounts_model->get_brokers();
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/broker_report_purchase', $data);
		}
	}
	public function broker_report_sale()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$broker = $this->input->post('broker');
			$inv_items = $this->input->post('inv_items');
			$data['broker_report'] = $this->report_model->broker_report($inv_items, $broker, $start_date, $end_date);			
			$data['broker']= $this->accounts_model->get_brokers();
			$data['broker_name']= $this->accounts_model->get_brokers_name($broker);
			$data['selected_item'] = $this->items_model->get_inv_item($inv_items);
			$data['inv_item'] = $this->items_model->inv_items();
			$data['config'] = $this->config_model->get_config_data();
			$this->load->view('Reports/broker_report_sale',$data);
		}
		else {
			$data['broker']= $this->accounts_model->get_brokers();
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/broker_report_sale', $data);
		}
	}
	public function services_report()
	{		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$services = $this->input->post('services');
			$account_name = $this->input->post('account_name');
			$data['sev_report'] = $this->report_model->services_report($services, $account_name, $start_date, $end_date);
			$data['sev_items']= $this->items_model->serv_items();
			$data['accounts']= $this->accounts_model->get_accounts();			
			$this->load->view('Reports/report_services', $data);
		}
		else {
			$data['sev_items']= $this->items_model->serv_items();
			$data['accounts']= $this->accounts_model->get_accounts();		
			$this->load->view('Reports/report_services', $data);
		}
	}
	public function services_report_sale()
	{		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$services = $this->input->post('services');
			$account_name = $this->input->post('account_name');
			$data['sev_report'] = $this->report_model->services_report_sale($services, $account_name, $start_date, $end_date);
			$data['sev_items']= $this->items_model->serv_items();
			$data['accounts']= $this->accounts_model->get_accounts();			
			$this->load->view('Reports/report_services_sale',$data);
		}
		else {
			$data['sev_items']= $this->items_model->serv_items();
			$data['accounts']= $this->accounts_model->get_accounts();		
			$this->load->view('Reports/report_services_sale', $data);
		}
	}
	public function daily_ledger()
	{
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d');
			$data['credits'] = $this->report_model->getcr($start_date, $end_date);
			$data['debits'] = $this->report_model->getdr($start_date, $end_date);
			$data['quick_sale'] = $this->report_model->get_quick_sale($start_date);
			
			$this->load->view('Reports/daily_ledger', $data);
	}
	
	public function quick_sale_report(){
		//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$inv_items = $this->input->post('inv_items');
			$data['quick_sale'] = $this->report_model->quick_sale_report($inv_items, $start_date, $end_date);
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/quick_sale_report', $data);
		/*}
		else {
			//$data['supplier']= $this->accounts_model->get_suppliers();
			//$data['config'] = $this->config_model->get_config_data();
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/quick_sale_report',$data);
		}*/
		
	}
	public function accounts_final_report()
	{	
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$data['credits'] = $this->report_model->get_account_cr($start_date, $end_date);
			$data['debits'] = $this->report_model->get_account_dr($start_date, $end_date);
		$this->load->view('Reports/accounts_final_report', $data);
	}
	
	public function item_report()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$date_range = explode(' - ',$this->input->post('date_range'));
			$start_date = date_change_db($date_range[0]);
			$end_date = date_change_db($date_range[1]);
			$customer = $this->input->post('customer');
			$inv_items = $this->input->post('inv_items');
			$data['bale_report'] = $this->report_model->get_items($customer, $inv_items, $start_date, $end_date);
			//$data['customer']= $this->accounts_model->get_customers();
			//$data['config'] = $this->config_model->get_config_data();
			$data['selected_item'] = $this->items_model->get_inv_item($inv_items);
			//$data['acnt'] = $this->accounts_model->get_account($customer);
			$data['inv_item'] = $this->items_model->inv_items();
			//$data['total'] = $this->accounts_model->get_total($customer);
			//$data['total_dr'] = $this->accounts_model->get_total_dr($customer);
			$this->load->view('Reports/item_report',$data);
		}
		else {
			$data['bale_report'] = $this->report_model->get_items($customer, $inv_items, $start_date, $end_date);
			//$data['customer']= $this->accounts_model->get_customers();
			//$data['config'] = $this->config_model->get_config_data();
			$data['inv_item'] = $this->items_model->inv_items();
			$this->load->view('Reports/item_report',$data);
		}
	}
	
	
}