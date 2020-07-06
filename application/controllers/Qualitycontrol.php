<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qualitycontrol extends CI_Controller
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

    function pembobotan() {
    	if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("qualitycontrol_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->qualitycontrol_act->proses_form('pembobotan');
            echo $data;
            die();
        }
        $nilai_kriteria = $this->qualitycontrol_act->getData('nilai');
        foreach ($nilai_kriteria as $value) {
        	$nilai[$value['id']] = $value['nilai'];
        }
        $kriterias = $this->qualitycontrol_act->getData('kriteria');
        $nilaiKriteria = array();
        foreach ($kriterias as $kriteria) {
        	if ($kriteria['id'] == "k1") {
        		$nilaiKriteria[] = $kriteria['k2'];
        		$nilaiKriteria[] = $kriteria['k3'];
        		$nilaiKriteria[] = $kriteria['k4'];
        		$nilaiKriteria[] = $kriteria['k5'];
        	} elseif ($kriteria['id'] == "k2") {
        		$nilaiKriteria[] = $kriteria['k3'];
        		$nilaiKriteria[] = $kriteria['k4'];
        		$nilaiKriteria[] = $kriteria['k5'];
        	} elseif ($kriteria['id'] == "k3") {
        		$nilaiKriteria[] = $kriteria['k4'];
        		$nilaiKriteria[] = $kriteria['k5'];
        	} elseif ($kriteria['id'] == "k4") {
        		$nilaiKriteria[] = $kriteria['k5'];
        	}
        }
        $data = array(
            'judul' => 'Nilai Perbandingan Kriteria',
            'act' => 'update',
            'nilai' => $nilai,
            'nilaiKriteria' => $nilaiKriteria,
        );
        $this->content = $this->load->view('qc/pembobotan', $data, true);
        $this->index($tipe);
    }

    function nilai($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("qualitycontrol_act");
            $arrdata = $this->qualitycontrol_act->list_nilai($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function qc($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("qualitycontrol_act");
            $arrdata = $this->qualitycontrol_act->list_qc($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function edit($tipe = "", $id = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("qualitycontrol_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if ($tipe == "nilai_max") {
	        if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
	            echo $this->qualitycontrol_act->proses_form('update_nilai');
	        }else{
	            $data['id'] = $id;
	            echo $this->load->view('qc/nilai_kriteria', $data); 
	        }
        } elseif ($tipe == "qc_barang") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->qualitycontrol_act->proses_form($tipe);
                echo $data;
                die();
            }
            $pengadaan = $this->qualitycontrol_act->getData('pengadaan', $id);
            $details = $this->qualitycontrol_act->getData('pemasukan_detail', $id);
            $data = array(
                'judul' => 'Form Quality Control',
                'act' => 'qc',
                'sess' => $pengadaan,
                'details' => $details
            );
            $this->content = $this->load->view('qc/qc_pemasukan', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "show_qc_barang") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            $pengadaan = $this->qualitycontrol_act->getData('pengadaan', $id);
            $details = $this->qualitycontrol_act->getData('pemasukan_detail', $id);
            $data = array(
                'judul' => 'Form Quality Control',
                'act' => 'show',
                'sess' => $pengadaan,
                'details' => $details
            );
            $this->content = $this->load->view('qc/qc_pemasukan', $data, true);
            $this->index($tipe);
        }
    }
}