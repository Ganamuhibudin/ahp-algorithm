<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
	var $content = "";
		
	public function __construct() {        
	    parent::__construct();
	}

	function index($dok = "") {
		if ($this->newsession->userdata('logged')) {
			$this->load->model('main');
			$this->main->get_index($dok);
		} else {
			$this->newsession->sess_destroy();
			$this->load->view('login');
		}
	}
	
	function logout() {
		$this->newsession->sess_destroy();		
		redirect(base_url());
	}
}
?>