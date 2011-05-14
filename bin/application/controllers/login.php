<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index(){

		$data['page_content'] = 'login_form';
		$this->load->view('pagebits/page', $data);
		
	}
	
	public function error(){

		$data['error_content'] = $this->uri->segment(3);
		if($data['error_content'] != 'incorrect_combo' && $data['error_content'] != 'system_error' && $data['error_content'] != 'unauthorised'){
			unset($data['error_content']);
		}
		$data['page_content'] = 'login_form';
		$this->load->view('pagebits/page', $data);
		
	}
	
	public function quit(){
	
		$this->xsession->destroy_session();
		redirect('login');
	
	}
	
	public function authenticate(){
		
		if($this->xsession->verify_login() == true){
			
			redirect('sessions');
			
		}else{
			
			redirect('login/access_denied');
			
		}
		
	}
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */