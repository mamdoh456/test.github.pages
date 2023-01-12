<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');	
		$this->load->helper('url');
	}
	public function index()
	{
		$session = $this->session->userdata('isLogin');
		if($session == FALSE)
		{
			redirect('login/login_form');
		}
		else{
			redirect('welcome');
		}
	}
	public function login_form()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	
		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('login');
		}
		else{
			$username = $this->input->post('username');
			$password1 = $this->input->post('password');
			$password = md5($password1);
			$cek = $this->m_login->takeUser($username, $password);
			if($cek <> 0)
			{
				$this->session->set_userdata('isLogin', TRUE);
				$this->session->set_userdata('username',$username);
				redirect('welcome');
			}
			else{
		?>
			<script>			
			alert('Failed Login: Check your username and password!');		
			history.go(-1);			
			</script>	
		<?php	
			}	
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login/login_form');
	}
}