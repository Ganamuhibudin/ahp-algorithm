<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {

	public function __construct() {        
	    parent::__construct();
	}
	
	function ceklogin($sessid="", $isajax=""){
		error_reporting(E_ALL ^ E_NOTICE);
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			echo "2|Login gagal, mohon coba lagi";
			exit();
		}else{
			$uid = $this->input->post('_usr');
			$pwd = $this->input->post('_pass');
			$code = $this->input->post('_code');
			if(strtolower($code) == $this->session->userdata('captkodex')){
				$this->load->model('user_act');
				$hasil = $this->user_act->login($uid, md5($pwd));
				if($hasil=="1"){
					echo "1|please wait..";
					exit();
				}else if($hasil=="2"){
					echo "0|User Anda sudah Kadaluarsa.<br>Silahkan Hubungi User Administrator anda";
					exit();
				}else if($hasil=="3"){
					echo "0|User Anda sudah Tidak Aktif.<br>Silahkan Hubungi User Administrator anda";
					exit();
				}else{ 
					echo "0|Username atau Password Salah";
					exit();
				}
			}else{
				echo "0|Kode yang anda masukan Salah";
				exit();
			}			
		}
	}
	
	function forgot($sessid="", $isajax=""){
		$ret = "";
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post") $ret = "NO";
		$uid = $this->input->post('uid_');
		$npwp = $this->input->post('npwp_');
		if($ret==""){
			$this->load->model('user_act');
			$ret = $this->user_act->forgot($uid, $npwp);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function password($isajax=""){
		$ret = "";
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post") $ret = "NO";
		if($ret==""){
			$this->load->model('user_act');
			$ret = $this->user_act->ubahpassword($isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function data($isajax=""){
		$ret = "";
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post") $ret = "NO";
		if($ret==""){
			$this->load->model('user_act');
			$ret = $this->user_act->ubahprofil($isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function lostpassword($type="",$isajax=""){
		if($type=="view"){
			echo $this->load->view('login/lost', '', true);
		}else{
			if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){ 
				redirect(base_url());
				exit();
			}else{
				$kode = $this->input->post('kode');
				if(strtolower($kode)===$_SESSION['captkodex2']){
					$this->load->model('user_act');
					$hasil = $this->user_act->forgot();
					echo $hasil;
					exit();
				}else{
					echo "0|Kode yang anda masukan Salah";
					exit();
				}			
				
			}
		}
	}
}