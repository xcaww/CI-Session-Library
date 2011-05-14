<?php

class Session_data extends CI_Model {

    function __construct(){

        parent::__construct();
		
    }
	
	function gather_overview_data(){
	
		$this->db->order_by('last_activity', 'desc');
		$query = $this->db->get($this->config->item('xsession_session_table'));
		
		if($query->num_rows > 0){
		
			$i = 0;
		
			foreach($query->result_array() as $row_data){
			
				$overview['sessions'][$i]['session_id'] = $row_data['session_id'];
				$overview['sessions'][$i]['ip_address'] = $row_data['ip_address'];
				$overview['sessions'][$i]['user_agent'] = $row_data['user_agent'];
				$overview['sessions'][$i]['last_activity'] = $row_data['last_activity'];
				$overview['sessions'][$i]['user_id'] = $row_data['user_id'];
				$overview['sessions'][$i]['time_created'] = $row_data['time_created'];
				$i++;
				
			}
			
		}
		
		$query = $this->db->get($this->config->item('xsession_users_table'));
		
		if($query->num_rows > 0){
			
			foreach($query->result_array() as $row_data){
			
				$overview['users'][$row_data['ID']]['username'] = $row_data['username'];
				
			}
			
		}

		return $overview;		
	
	}
	
	function build_overview_data(){
	
		$overview = $this->gather_overview_data();
		$i = 0;
		
		foreach($overview['sessions'] as $data){
		
			$overview_data[$i]['session_id'] = $data['session_id'];
			$overview_data[$i]['ip_address'] = $data['ip_address'];
			$overview_data[$i]['user_agent'] = $data['user_agent'];
			$overview_data[$i]['last_activity'] = $data['last_activity'];
			$overview_data[$i]['time_created'] = $data['time_created'];
			$overview_data[$i]['user_id'] = $data['user_id'];
			$overview_data[$i]['username'] = $overview['users'][$data['user_id']]['username'];
			$i++;
		
		}
		
		return $overview_data;
		
	}
	
}
/* End of file session_data.php */
/* Location: ./application/models/session_data.php */