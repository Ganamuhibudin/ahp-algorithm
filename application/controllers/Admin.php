<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller{
	var $content = "";
	var $addHeader = array();
	function index($dok = "") {
        if($this->newsession->userdata('LOGGED')){
			$this->load->model('main');
			$this->main->get_index($dok,$this->addHeader);	
		}else{
			$this->newsession->sess_destroy();		
			redirect(base_url());
		}
    }	
	function trader($tipe="",$ajax="",$id=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		if($tipe=="priview"){
			if($id==""){$this->index();return;}
			$this->load->model("admin_act");
			$data = $this->admin_act->get_profiltrader($ajax,$id);
			$this->content = $this->load->view('admin/profil', $data, true);	
			$this->index();
		}else{
			$this->load->model("admin_act");
			$arrdata = $this->admin_act->trader($tipe,$ajax);		
			$data = $this->load->view('list', $arrdata, true);
			if($this->input->post("ajax")||$ajax){
				echo  $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	function settrader($type="",$act=""){		
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{	
			$this->load->model("admin_act");	
			$this->admin_act->settrader($type,$act);		
		}
	}
	
	function user($ajax=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->model("admin_act");
		$arrdata = $this->admin_act->user($ajax);		
		$data = $this->load->view('boxTwo', $arrdata, true);
		if($this->input->post("ajax")||$ajax){
			echo  $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	
	function form($type="",$id=""){
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->model("admin_act");
		$arrdata = $this->admin_act->getuser($type,$id);		
		$this->content = $this->load->view('admin/user',$arrdata, true);
		$this->index();		
	}
	
	function setuser($act=""){		
		$generate = $this->input->post('generate');
	    	if($generate == "formjs"){
				$kode_partner = $this->input->post('id1');
			}
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post" && ($generate != "formjs")){
			$this->load->model("admin_act");				
			$this->admin_act->setuser($act);
		}else{				
			redirect(base_url());
			exit();	
		}
	}		
	
	function default_data_berita($post_array){
		$post_array['CREATED_TIME'] = date("Y-m-d H:i:s");	
		$post_array['CREATED_BY'] = $this->newsession->userdata('USER_ID');		
		return $post_array;
	}
	
	function showberita($id=""){
		$this->load->model('admin_act');		
		$arrdata = $this->admin_act->getberita('1',$id);
		echo $this->load->view('admin/beritaview', $arrdata, true);	
	}

	function resettrader(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}			
		$this->load->model("admin_act");
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			echo $this->admin_act->resettraderproses();				
		}else{
			$arrdata = $this->admin_act->resettrader();		
			$this->content = $this->load->view('admin/resetform', $arrdata, true);
			$this->index();		
		}
	}
	
	function prosesmenu($id=""){
		$this->load->model('admin_act');
		$this->admin_act->prosesmenu($id);
	}
	
	function proseshargapenyerahan(){
		$this->load->model("main");
		$SQL = "SELECT NOMOR_AJU FROM T_BC27_HDR";
		$hasil = $this->main->get_result($SQL);
		if($hasil){
			foreach($SQL->result_array() as $row){	
				$query = "SELECT f_jumcif_bc27('".$row["NOMOR_AJU"]."') AS JUM FROM DUAL";	
				$rs = $this->db->query($query)->row();	
				$this->db->where(array('NOMOR_AJU' => $row["NOMOR_AJU"]));	
				$exec = $this->db->update("t_bc27_hdr",array("CIF"=>$rs->JUM));	
			}
			if($exec){
				echo "proses berhasil";
			}else{
				echo "proses gagal";
			}
		}		
	}	

	function tammenu(){
		$this->load->model("admin_act");
		$this->admin_act->tammenu();		
	}

	function activitylog(){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
		if($this->newsession->userdata('LOGGED') && ($this->newsession->userdata('KODE_ROLE')==1)){	
			$this->load->model("admin_act");
			$arrdata = $this->admin_act->activitylog();		
			$data = $this->load->view('boxTwo', $arrdata, true);
			if($this->input->post("ajax")){
				echo  $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}else{
			$this->newsession->sess_destroy();	
			$this->index();
			return;	
		}			
	}
	
	function getposisi($kode=""){
		$this->load->model("admin_act");
		$this->admin_act->getposisi($kode);				
	}
	
	
	function getposisipabean($kode=""){
		$this->load->model("admin_act");
		$this->admin_act->getposisipabean($kode);				
	}
	
	function setkodebarangdokumen(){
		$this->load->model('admin_act');
		$this->admin_act->setkodebarangdokumen();
	}
	
	function update_seri(){
		$this->load->model('admin_act');
		$this->admin_act->update_seri();
	}
		
	function update_logkeluar(){
		$this->load->model('admin_act');
		$this->admin_act->update_logkeluar();
	}
	
	
	function tambah_no_urut_manual($KODETRADER=""){
		$this->load->model("admin_act");
		$this->admin_act->tambah_no_urut_manual($KODETRADER);		
	}
}
?>