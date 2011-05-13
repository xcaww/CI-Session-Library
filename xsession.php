<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class xsession {

	var $user_data = array();
	var $cookie_sent = false;	
	var $is_logging_in = false;
	var $user_data_names = array("last_activity", "ip_address", "user_agent", "user_id");
    	
	function __construct(){
	
		$this->object =& get_instance();
		log_message('debug', "xsession Class Initialized");
		$this->last_activity = time();
		
	}
	
	function destroy_session(){
	
		delete_cookie('ci_userX');
		delete_cookie('ci_userY');
	
	}
	
	function user_data_ready(){
	
		if(isset($this->session_data['user_id']) && isset($this->user_data['username']) && isset($this->user_data['email'])){
		
			return true;
		
		}else{
		
			return false;
			
		}
		
	}

	function session_data_ready(){
	
		if(isset($this->session_data['session_id']) && isset($this->session_data['last_activity']) && isset($this->session_data['ip_address']) && isset($this->session_data['user_agent'])){
		
			return true;
		
		}else{
		
			return false;
			
		}		
	
	}
	
	function gather_cookie_data(){
	
		$this->cookies = array('ci_userX', 'ci_userY');
		
		foreach($this->cookies as $this->cookie){

			if($this->object->input->cookie($this->cookie) != false){
			
				$this->session_cookie[$this->cookie] = $this->object->input->cookie($this->cookie);
				
			}
			
		}
		
	}
	
	function match_session_id(){
	
		if($this->check_cookies('X')){
		
			$this->object->db->where('session_id', $this->session_data['session_id']);
			$query = $this->object->db->get($this->object->config->item('xsession_session_table'));
			
			if($query->num_rows == 1){
				
				return true;
				
			}else{
			
				return false;
				
			}
		
		}else{
		
			return false;
			
		}
	
	}
	
	function match_user_data(){
	
		if($this->check_cookies('Y')){
			
			$this->object->db->where('ip_address', $this->session_data['ip_address']);
			$this->object->db->where('user_agent', $this->session_data['user_agent']);
			$this->object->db->where('last_activity', $this->session_data['last_activity']);
			$query = $this->object->db->get($this->object->config->item('xsession_session_table'));
			
			if($query->num_rows > 0){
			
				foreach($query->result_array() as $row){
			
					if($this->session_data['session_id'] != $row['session_id']){
					
						return false;
						
					}
					
					return true;
					
				}
				
			}else{
				
				return false;
				
			}
			
		}
	}	
	
	function update_database_session(){
	
		$this->packed_user_data = $this->session_data['packed_user_data'];
		unset($this->session_data['packed_user_data']);
		$this->object->db->query($this->object->db->update_string($this->object->config->item('xsession_session_table'), $this->session_data, "session_id = '" . $this->session_data['session_id'] . "'"));
		$this->session_data['packed_user_data'] = $this->packed_user_data;
		unset($this->packed_user_data);
	
	}
	
	function create_database_session(){
	
		if(!$this->session_id_exist()){
		
			if($this->is_logging_in == true){
	
				unset($this->session_data['packed_user_data']);
				$this->session_data['time_created'] = $this->session_data['last_activity'];
				$this->object->db->query($this->object->db->insert_string($this->object->config->item('xsession_session_table'), $this->session_data));
			
			}else{
			
				redirect('login/error/system_error');
				
			}
		
		}else{
		
			$this->create_database_session();
			
		}
			
	}
	
	function session_id_exist(){
	
		if(isset($this->session_data['session_id'])){
		
			$this->object->db->where('session_id', $this->session_data['session_id']);
			$query = $this->object->db->get($this->object->config->item('xsession_session_table'));
			
			if($query->num_rows == 1){
			
				$this->reset_session_id();
				return true;
			
			}else{
			
				
				return false;
				
			}
			
		}else{
			
			$this->reset_session_id();
			return false;
		
		}
		
	}
	
	function reset_session_id(){
	
		$this->session_data['session_id'] = md5($this->session_data['user_id'] . "xsession" . time());
	
	}
	
	function check_cookies($verifyCookies){
	
		$cookieID = explode(", ", $verifyCookies);
		
		foreach($cookieID as $ID){

			$this->cookieName = "ci_user" . $ID;

			if(!isset($this->session_cookie[$this->cookieName])){
			
				return false;
				
			}
			
		}
		
		return true;
		
	}
	
	function set_cookies(){
	
		setcookie(
			"ci_userX", 
			$this->session_data['session_id'],
			$this->last_activity + 3600, 
			$this->object->config->item('cookie_path'), 
			$this->object->config->item('cookie_domain'), 
			0
		);
		
		setcookie(
			"ci_userY", 
			$this->session_data['packed_user_data'],
			$this->last_activity + 3600, 
			$this->object->config->item('cookie_path'), 
			$this->object->config->item('cookie_domain'), 
			0
		);
		
		$this->cookie_sent = TRUE;
		
	}
	
	function update_user_data(){
	
		if((time() - $this->session_data['last_activity']) > 10){

			$this->session_data['ip_address'] = $this->object->input->ip_address();
			$this->session_data['user_agent'] = substr($this->object->input->user_agent(), 0, 50);
			$this->session_data['last_activity'] = time();
			$this->session_data['packed_user_data'] = $this->pack_user_data();
			$this->set_cookies();
			$this->update_database_session();
			
		}
	
	}
	
	function pack_user_data(){
	
		if(isset($this->session_data['last_activity']) && isset($this->session_data['ip_address']) && isset($this->session_data['user_agent']) && isset($this->session_data['user_id'])){
		
			return $this->object->encrypt->encode($this->session_data['last_activity'] . "@@" . $this->session_data['ip_address'] . "@@" . $this->session_data['user_agent'] . "@@" . $this->session_data['user_id']);
			
		}else{
		
			redirect('login/error/system_error');
			
		}
	
	}
	
	function unpack_user_data(){

		if($this->check_cookies('Y')){
		
			$unpacked_data = explode("@@", $this->object->encrypt->decode($this->session_cookie['ci_userY']));
			$i = 0;
			
			foreach($unpacked_data as $data){
			
				$this->session_data[$this->user_data_names[$i]] = $data;
				$i++;
				
			}
			
			if(time() - $this->session_data['last_activity'] > 3600){
			
				//moldy cookie!
				redirect('login/error/unauthorised');
			
			}
		
		}else{
			
			redirect('login/error/unauthorised');
			
		}
	
	}
	
	function gather_user_data(){
		
		$this->gather_cookie_data();
		
		if($this->is_logging_in == false && $this->check_cookies('X, Y') == true){
		
			$this->session_data['session_id'] = $this->session_cookie['ci_userX'];
			$this->unpack_user_data();
			$this->update_user_data();
			
			if($this->match_session_id() != true || $this->match_user_data() != true){
			
				redirect('login/error/unauthorised');
				
			}
			
			$this->object->db->where('ID', $this->session_data['user_id']);
			
		}elseif($this->is_logging_in == true){
	
			$this->object->db->where('ID', $this->session_data['user_id']);
			$this->session_data['last_activity'] = $this->last_activity;
			$this->session_data['ip_address'] = $this->object->input->ip_address();
			$this->session_data['user_agent'] = substr($this->object->input->user_agent(), 0, 50);
			$this->session_data['packed_user_data'] = $this->pack_user_data();
			
		}else{
			
			redirect('login/error/unauthorised');
			
		}
		
		$query = $this->object->db->get($this->object->config->item('xsession_users_table'));
	
		if($query->num_rows == 1){
			
			foreach ($query->result_array() as $row){
				
				$this->user_data['username'] = $row['username'];
				$this->user_data['email'] = $row['email'];
				
			}
			
		}
		
		return true;
		
	}
	
	function verify_login(){
	
		$this->is_logging_in = true;
		$this->object->db->where('username', $this->object->input->post('username'));
		$this->object->db->where('password', md5($this->object->input->post('password')));
		$query = $this->object->db->get($this->object->config->item('xsession_users_table'));

		if($query->num_rows == 1){

			foreach ($query->result_array() as $row){
			
				$this->session_data['session_id'] = md5($row['username'] . "xsession" . time());
				$this->session_data['user_id'] = $row['ID'];
				$this->gather_user_data();
				$this->set_cookies();
				$this->create_database_session();	
				
				return true;
				
			}
			
		}else{
		
			redirect('login/error/incorrect_combo');
			
		}
		
		redirect('login/error/system_error');
		
	}
	
}
	
?>