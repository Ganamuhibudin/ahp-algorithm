<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemasukan extends CI_Controller
{
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

    function pengadaan($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("pemasukan_act");
            $arrdata = $this->pemasukan_act->list_pengadaan($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function approve($tipe) {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pemasukan_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->pemasukan_act->proses_form('approve_'.$tipe);
            echo $data;
        }
    }

    function toDraft($tipe) {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pemasukan_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->pemasukan_act->proses_form('todraft');
            echo $data;
        }
    }

    function add($tipe) {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("pemasukan_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if ($tipe == "pengadaan") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->pemasukan_act->proses_form($tipe);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Tambah Data Pemasukan',
                'act' => 'save'
            );
            $this->content = $this->load->view('pemasukan/pengadaan/form', $data, true);
            $this->index($tipe);
        }
    }

    function edit($tipe = "", $id = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("pemasukan_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if ($tipe == "pengadaan") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->pemasukan_act->proses_form($tipe);
                echo $data;
                die();
            }
            $pengadaan = $this->pemasukan_act->getData($tipe, $id);
            $details   = $this->pemasukan_act->getData('pengadaan_detail', $id);
            $data = array(
                'judul' => 'Ubah Data Pemasukan',
                'act' => 'update',
                'sess' => $pengadaan,
                'barang' => $details
            );
            $this->content = $this->load->view('pemasukan/pengadaan/form', $data, true);
            $this->index($tipe);
        }
    }

    function delete($tipe = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pemasukan_act");
        $response = $this->pemasukan_act->proses_form($tipe);
        echo $response;
    }
}