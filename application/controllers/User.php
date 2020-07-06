<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    var $content = "";
	var $addHeader = array();
    function index($dok = "") {
        if($this->newsession->userdata('logged')){
            $this->load->model('main');
            $this->main->get_index($dok,$this->addHeader);  
        }else{
            $this->newsession->sess_destroy();      
            redirect(base_url());
        }
    }

    function profile() {
		if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("user_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        $id_user = $this->newsession->userdata('id_user');

        $divisi = $this->user_act->getData('divisi');
        $role = $this->user_act->getData('role');
        $user = $this->user_act->getData('user', $id_user);
        $data = array(
            'judul' => 'Profile Saya',
            'act' => 'update',
            'sess' => $user,
            'divisi' => $divisi,
            'role' => $role
        );

        $this->content = $this->load->view('user/profil', $data, true);
        $this->index($tipe);
    }

    function userlist($ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
        if ($this->newsession->userdata('id_role') == 1 || $this->newsession->userdata('id_role') == 2) {
            $this->load->model("user_act");
            $arrdata = $this->user_act->daftar($ajax);
            $data = $this->content = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        } else {
            $this->index();
            return;
        }
    }

    function create() {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("user_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->user_act->proses_form();
            echo $data;
            die();
        }
        $divisi = $this->user_act->getData('divisi');
        $role = $this->user_act->getData('role');
        $data = array(
            'judul' => 'Tambah Data User',
            'act' => 'save',
            'divisi' => $divisi,
            'role' => $role
        );
        $this->content = $this->load->view('user/form', $data, true);
        $this->index($tipe);
    }

    function edit($id="") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("user_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        $generate = $this->input->post('generate');
        if($generate == "formjs"){
            $id_user = $this->input->post('id1');
        }
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
            $data = $this->user_act->proses_form();
            echo $data;
            die();
        }
        $divisi = $this->user_act->getData('divisi');
        $role = $this->user_act->getData('role');
        $user = $this->user_act->getData('user', $id_user);
        $data = array(
            'judul' => 'Ubah Data User',
            'act' => 'update',
            'sess' => $user,
            'divisi' => $divisi,
            'role' => $role
        );

        $this->content = $this->load->view('user/form', $data, true);
        $this->index($tipe);
    }

    function delete() {
        $this->load->model("user_act");
        $ret = $this->user_act->proses_form();
    }

    function resetPassword() {
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $this->load->model("user_act");
            echo $this->user_act->proses_form();
        }
    }

    function set_user($tipe = "") {
        $this->load->model("usertrader_act");
        $ret = $this->usertrader_act->set_user($this->input->post("act"), $tipe);
    }

    function user_dok($tipe = "") {
        $this->load->model("usertrader_act");
        $arrdata = $this->usertrader_act->daftar($tipe);
        echo $this->load->view('user/inv', $arrdata, true);
    }

    function password() {
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => '../sys/fonts/texb.ttf',
            'img_height' => 35,
            'img_width' => 110,
            'expiration' => 120
        );
        $cap = create_captcha($vals);
        $this->newsession->set_userdata('capt_login', $cap['word']);


        $this->load->model("usertrader_act");
        $data = $this->usertrader_act->get_password();
        $data['cap'] = $cap['image'];
        $this->content = $this->load->view('user/password', $data, true);
        $this->index();
    }

    public function reload_captcha() {
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => '../sys/fonts/texb.ttf',
            'img_height' => 35,
            'img_width' => 110,
            'expiration' => 120
        );
        $cap = create_captcha($vals);
        $this->newsession->set_userdata('capt_login', $cap['word']);
        echo $cap['image'];
    }

    function updatePass() {
        $this->load->model("usertrader_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->usertrader_act->updatePass();
            echo $data;
        }
    }

    /////////////////////////// NEW ///////////////////////////

    function add($tipe = "", $id = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("master_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->master_act->proses_form($tipe);
            echo $data;
            die();
        }
        $data = array(
            'judul' => 'Tambah Data User',
            'act' => 'save'
        );
        $this->content = $this->load->view('user/form', $data, true);
        $this->index($tipe);
    }

    function getmenu() {
        $this->load->model("usertrader_act");
        echo $this->usertrader_act->menu_management();
    }

    function editUser($tipe = "", $id = "") {
        $func = get_instance();
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["ui"] = 1;
        $func->load->model("main", "main", true);
        $this->load->model("usertrader_act");
        if ($tipe == "user") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $id = $this->input->post('idUser');
                $data = $this->usertrader_act->proses_form($tipe, $id);
                echo $data;
            }
            $judul = "Ubah Data User";
        }
        $menu_management = $this->usertrader_act->menu_management($id);
        $resultdata = $this->usertrader_act->getData($tipe, $id);
		if(!$this->newsession->userdata("JENIS_PLB")){
			$SQL = "SELECT KODE_ROLE, NAMA FROM m_role WHERE KODE_ROLE IN('5','6','7') ORDER BY KODE_ROLE";
		}else{
			$SQL = "SELECT KODE_ROLE, NAMA FROM m_role WHERE KODE_ROLE IN('3','4','5') ORDER BY KODE_ROLE";
		}
        $data = array("menu" => $menu_management,
            "judul" => $judul,
            "act" => "update",
            "dokumen" => $dok,
            "sess" => $resultdata,
            'kode_role' => $func->main->get_combobox($SQL, "KODE_ROLE", "NAMA", TRUE),
            'status_user' => $func->main->get_mtabel('STATUS_USER'));
        $this->content = $this->load->view('user/form', $data, true);
        $this->index($tipe);
    }

    function activitylog() {
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
        if ($this->newsession->userdata('LOGGED') && ($this->newsession->userdata('KODE_ROLE') == 3 or $this->newsession->userdata('KODE_ROLE') == 5 or $this->newsession->userdata('KODE_ROLE') == 4)) {
            $this->load->model("user_act");
            $arrdata = $this->user_act->activitylog();
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")) {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        } else {
            $this->newsession->sess_destroy();
            $this->index();
            return;
        }
    }

    function revisilog() {
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
        if ($this->newsession->userdata('LOGGED') && $this->newsession->userdata('KODE_ROLE') == 3) {
            $this->load->model("user_act");
            $arrdata = $this->user_act->revisilog();
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")) {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        } else {
            $this->newsession->sess_destroy();
            $this->index();
            return;
        }
    }

}

?>