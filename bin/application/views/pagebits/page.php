<?php 

	$this->load->view('pagebits/header');
	if(isset($error_content)){
		$this->load->view('error/' . $error_content);
	}
	$this->load->view($page_content);
	$this->load->view('pagebits/footer'); 
	
?>