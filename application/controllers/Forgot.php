<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Forgot extends CI_Controller{
	var $content = "";
	var $appname = "";	
	var $addHeader = array();
	function index(){
		$this->forgoten();
	}
	
	function forgoten(){
		$addHeader["ui"] = 1;
		$addHeader["alert"]    = 1;
		$head = array("addHeader" => $addHeader,"dokumen"=>"bc41");
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			redirect(base_url());	
			exit();
		}else{	
			if(!$this->newsession->userdata('LOGGED')){
				$this->content = $this->load->view('forgot','',true);		
				$data = array('_content_' => $this->content,
							  '_welcome_' => "",
							  '_header_' => $this->load->view('partials/header', $head, true));
				$this->parser->parse('register', $data);	
			}else{
				redirect(base_url());	
				exit();
			}
		}
	}
	
	function setdata(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			echo "MSG#ERR#Proses Gagal";
			exit();
		}else{
			$this->load->model("user_act");
			echo $this->user_act->forgot();
		}		
	}	
}
?>