<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Controller{
	
	function index(){}

	function getsearch($tipe="",$indexField="",$formName="",$getdata=""){
		// echo $tipe . "|" . $indexField . "|" . $formName; die();
		$this->load->model("search_act");
		$arrdata = $this->search_act->search($tipe,$indexField,$formName,$getdata);
		$data =  $this->load->view("list", $arrdata, true);
		if($this->input->post("ajax")){
			echo $arrdata;
		}else{
			echo $data;
		}
	}
	
	function getsearch_two($tipe=""){
		$this->load->model("search_act");
		$id = explode("~",$this->input->post('id'));
		$indexField = ($id[0])?$id[0]:"";
		$formName = ($id[1])?$id[1]:"";
		if(count($id)>2){
			$getdata = ($id[2])?$id[2]:"";
		}else{
			$getdata="";
		}
		$arrdata = $this->search_act->search($tipe,$indexField,$formName,$getdata);
		$data =  $this->load->view("list", $arrdata, true);
		if($this->input->post("ajax")){
			echo $arrdata;
		}else{
			echo $data;
		}
	}
}
?>