<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends CI_Controller {


	public function index(){

		$this->load->model('session_data');
		$this->xsession->gather_user_data();
		$data['sessions'] = $this->session_data->build_overview_data();
		$data['page_content'] = 'sessions_overview';
		$this->load->view('pagebits/page', $data);
		
	}
	
	// session/$session_id
	public function session(){
	
	}
	
	// user/$user_id
	public function user(){
	
		if($this->uri->segment(3) == true){
		
			$this->load->model('user_data');
			$this->xsession->gather_user_data();
			$data['user'] = $this->user_data->build_user_data($this->uri->segment(3));
			$data['page_content'] = 'sessions_user';
			$this->load->view('pagebits/page', $data);
			
		}else{
		
			redirect('sessions');
			
		}
		
	}
	
	// edit/$type/$id
	// edit/$function
	public function edit(){
	
		$this->xsession->gather_user_data();
		
		if($this->uri->segment(3) == true){
		
			switch($this->uri->segment(3)){
			
				case 'user':
					$this->load->model('user_data');
					$data['user'] = $this->user_data->build_user_data($this->uri->segment(4));
					$data['page_content'] = 'sessions_edit_user';
					break;
				case 'session';
					//$this->load->model('session_data');
					//$data['sessions'] = $this->session_data->build_session_data();
					$data['page_content'] = 'sessions_edit_session';
					break;
				default:
					redirect('sessions');
					exit();
					break;
					
			}
			
		}
		
		
		$this->load->view('pagebits/page', $data);
	
	}
	
	// add
	public function add_user(){
	
		$this->xsession->gather_user_data();
		$data['page_content'] = 'sessions_add_user';
		$this->load->view('pagebits/page', $data);
		
	}
	
	// search
	public function search(){
	
		$this->xsession->gather_user_data();
		$data['page_content'] = 'sessions_search';
		$this->load->view('pagebits/page', $data);
		
	}	

	
}
/* End of file sessions.php */
/* Location: ./application/controllers/sessions.php */