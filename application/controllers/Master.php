<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller {

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

    function divisi($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("master_act");
            $arrdata = $this->master_act->list_divisi($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function jenis_barang($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("master_act");
            $arrdata = $this->master_act->list_jenis($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function barang($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("master_act");
            $arrdata = $this->master_act->list_barang($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function so($tipe = "", $ajax = "", $id = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["ui"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->addHeader["autocomplete"] = 1;
            $this->load->model("master_act");
            $arrdata = $this->master_act->list_so($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        } elseif ($tipe == "load_barang") {
            $this->load->model("master_act");
            $act = $ajax;
            echo $this->master_act->brgstockopname($id, $act);
        } elseif ($tipe == "detil_so") {
            $act = $ajax;
            if ($act == "save") {
                $arrdata = array(
                    "act" => $act, 
                    "judul" => "Form Detil Stok Opname"
                );
            } else {
                $this->load->model("master_act");
                $arrdata = array(
                    "act" => $act, 
                    "judul" => "Form Detil Stok Opname",
                    "sess" => $this->master_act->getData($tipe, $id)
                );
            }
            echo $this->load->view('master/stockopname/form_barang', $arrdata, true);
        } elseif ($tipe == "update_tanggal") {
            $this->load->model("master_act");
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
        } else {
            # update stock by stock opname
            $this->load->model("master_act");
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
            }
        }
    }

    function add($tipe = "", $id = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("master_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if ($tipe == "divisi") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Tambah Data Divisi',
                'act' => 'save'
            );
            $this->content = $this->load->view('master/divisi/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "jenis_barang") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Tambah Data Jenis Barang',
                'act' => 'save'
            );
            $this->content = $this->load->view('master/jenis_barang/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "barang") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $allJenisBarang = $this->master_act->getData('all_jenis_barang');
            $jenis_barang = array();
            foreach ($allJenisBarang as $value) {
                $jenis_barang[$value['id_jenis_barang']] = $value['jenis_barang'];
            }
            $data = array(
                'judul' => 'Tambah Data Barang',
                'act' => 'save',
                'jenis_barang' => $jenis_barang
            );
            $this->content = $this->load->view('master/barang/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "so") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Form Stock Opname',
                'act' => 'save',
                "DETIL" => $this->master_act->brgstockopname($id)
            );
            $this->content = $this->load->view('master/stockopname/form', $data, true);
            $this->index($tipe);
        }
    }

    function edit($tipe = "", $id = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("master_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if ($tipe == "divisi") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id_divisi = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $getData = $this->master_act->getData($tipe, $id_divisi);
            $data = array(
                'judul' => 'Ubah Data Divisi',
                'act' => 'update',
                'sess' => $getData
            );
            $this->content = $this->load->view('master/divisi/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "jenis_barang") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $getData = $this->master_act->getData($tipe, $id);
            $data = array(
                'judul' => 'Ubah Data Jenis Barang',
                'act' => 'update',
                'sess' => $getData
            );
            $this->content = $this->load->view('master/jenis_barang/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "barang") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $allJenisBarang = $this->master_act->getData('all_jenis_barang');
            $jenis_barang = array();
            foreach ($allJenisBarang as $value) {
                $jenis_barang[$value['id_jenis_barang']] = $value['jenis_barang'];
            }
            $getData = $this->master_act->getData($tipe, $id);
            $data = array(
                'judul' => 'Ubah Data Barang',
                'act' => 'update',
                'sess' => $getData,
                'jenis_barang' => $jenis_barang
            );
            $this->content = $this->load->view('master/barang/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "so") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->master_act->proses_form($tipe);
                echo $data;
                die();
            }
            $data  = array(
                "act" => "edit",
                "TANGGAL_STOCK" => $id,
                "DETIL" => $this->master_act->brgstockopname($id),
                "judul" => "Form Stock Opname"
            );
            $this->content = $this->load->view('master/stockopname/form', $data, true);    
            $this->index($tipe);
        }
    }

    function delete($tipe = "") {
        $this->load->model("master_act");
        $ret = $this->master_act->proses_form($tipe);
    }
}

?>