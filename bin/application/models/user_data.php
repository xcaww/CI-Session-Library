<?php

class User_data extends CI_Model {

    function __construct(){

        parent::__construct();
		
    }
	
	function build_user_data($user_id){

		$this->db->where('ID', $user_id);
		$query = $this->db->get($this->config->item('xsession_users_table'));
		
		if($query->num_rows == 1){
		
			foreach($query->result_array() as $row_data){
			
				$user['username'] = $row_data['username'];
				$user['email'] = $row_data['email'];
				
			}
			
		}
		
		$this->db->where('user_id', $user_id);
		$this->db->order_by('last_activity', 'desc');
		$query = $this->db->get($this->config->item('xsession_session_table'));
		
		if($query->num_rows > 0){
		
			$i = 0;
			
			foreach($query->result_array() as $row_data){
			
				$user['sessions'][$i]['user_id'] = $row_data['user_id'];
				$user['sessions'][$i]['session_id'] = $row_data['session_id'];
				$user['sessions'][$i]['ip_address'] = $row_data['ip_address'];
				$user['sessions'][$i]['user_agent'] = $row_data['user_agent'];
				$user['sessions'][$i]['last_activity'] = $row_data['last_activity'];
				$user['sessions'][$i]['time_created'] = $row_data['time_created'];
				$i++;
				
			}
			
		}

		return $user;		
	
	}
	
}

/* End of file user_data.php */
/* Location: ./application/models/user_data.php */