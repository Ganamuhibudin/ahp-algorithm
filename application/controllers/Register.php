<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends CI_Controller{
	var $content = "";
	var $appname = "";	
	var $addHeader = array();
	function index(){
		$this->baru();
	}
	
	function baru(){
		$addHeader["newtable"] = 1;
		$addHeader["ui"] = 1;
		$addHeader["alert"]    = 1;
		$addHeader["autocomplete"] = 1;
		$head = array("addHeader" => $addHeader,"dokumen"=>"bc41");
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			redirect(base_url());	
			exit();
		}else{	
			if(!$this->newsession->userdata('LOGGED')){	
				$this->load->model("register_act");
				$data = $this->register_act->get_data();
				$this->content = $this->load->view('master/penyelenggara/form',$data,true);		
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
	
	function setdata($sessid=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			echo "MSG#ERR#Proses Gagal";
			exit();
		}else{				
			$this->load->model("register_act");
			$kode = $this->input->post('kode');			
			echo $this->register_act->setdata();
			exit();	
		}		
	}	
}
?>