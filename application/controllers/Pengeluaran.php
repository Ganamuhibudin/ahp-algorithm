<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengeluaran extends CI_Controller
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

    function distribusi($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("pengeluaran_act");
            $arrdata = $this->pengeluaran_act->list_distribusi($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function retur($tipe = "", $ajax = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        if ($tipe == "list") {
            $this->addHeader["newtable"] = 1;
            $this->addHeader["alert"]    = 1;
            $this->load->model("pengeluaran_act");
            $arrdata = $this->pengeluaran_act->list_retur($tipe, $ajax);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax")||$ajax=="ajax") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function review($tipe = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("pengeluaran_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if ($tipe == "distribusi") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->pengeluaran_act->proses_form($tipe);
                echo $data;
                die();
            }
            
            $distribusi = $this->pengeluaran_act->getData($tipe, $id);
            $details    = $this->pengeluaran_act->getData('distribusi_detail', $id);
            $data = array(
                'judul' => 'Approve Data Permohonan',
                'act' => 'approve',
                'sess' => $distribusi,
                'barang' => $details,
            );
            $this->content = $this->load->view('pengeluaran/distribusi/form', $data, true);
            $this->index($tipe);
        }
    }

    function approve($tipe, $divisi="") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pengeluaran_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            if ($divisi != "") {
                $data = $this->pengeluaran_act->proses_form('approve_' . $tipe . '_' . $divisi);
            } else {
                $data = $this->pengeluaran_act->proses_form('approve_marketing');
            }
            
            echo $data;
        }
    }

    function delivery($key="") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pengeluaran_act");
        if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
            echo $this->pengeluaran_act->proses_form('delivery');
        }else{
            $data['key'] = $key;
            echo $this->load->view('pengeluaran/distribusi/delivery', $data); 
        }
    }

    function reject($tipe) {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pengeluaran_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->pengeluaran_act->proses_form('reject_' . $tipe);
            echo $data;
        }
    }

    function toDraft($tipe, $divisi) {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pengeluaran_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $data = $this->pengeluaran_act->proses_form('todraft_' . $tipe . '_' . $divisi);
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
        $this->load->model("pengeluaran_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        $divisi = $this->newsession->userdata('divisi');
        $nik = $this->newsession->userdata('nik');
        $nama = $this->newsession->userdata('nama');
        if ($tipe == "distribusi") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->pengeluaran_act->proses_form($tipe);
                echo $data;
                die();
            }
            $nomorPermohonan = "DIST/" . date("Y/m/d") . "/" . date('His');
            $sess['nomor_transaksi'] = $nomorPermohonan;
            $sess['divisi']          = $divisi;
            $sess['nik']             = $nik;
            $sess['nama']            = $nama;
            $data = array(
                'judul' => 'Form Permohonan Marketing Tools',
                'act' => 'save',
                'sess' => $sess
            );
            $this->content = $this->load->view('pengeluaran/distribusi/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "retur") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->pengeluaran_act->proses_form($tipe);
                echo $data;
                die();
            }
            $nomorTransaksi = "RET/" . date("Y/m/d") . "/" . date('His');
            $sess['nomor_transaksi'] = $nomorTransaksi;
            $data = array(
                'judul' => 'Form Retur Barang',
                'act' => 'save',
                'sess' => $sess
            );
            $this->content = $this->load->view('pengeluaran/retur/form', $data, true);
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
        $this->load->model("pengeluaran_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        if ($tipe == "distribusi") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->pengeluaran_act->proses_form($tipe);
                echo $data;
                die();
            }
            
            $distribusi = $this->pengeluaran_act->getData($tipe, $id);
            $details    = $this->pengeluaran_act->getData('distribusi_detail', $id);
            $data = array(
                'judul' => 'Ubah Data Permohonan',
                'act' => 'update',
                'sess' => $distribusi,
                'barang' => $details
            );
            $this->content = $this->load->view('pengeluaran/distribusi/form', $data, true);
            $this->index($tipe);
        } elseif ($tipe == "retur") {
            $generate = $this->input->post('generate');
            if($generate == "formjs"){
                $id = $this->input->post('id1');
            }
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
                $data = $this->pengeluaran_act->proses_form($tipe);
                echo $data;
                die();
            }
            
            $retur   = $this->pengeluaran_act->getData($tipe, $id);
            $details = $this->pengeluaran_act->getData('retur_detail', $id);
            $data = array(
                'judul' => 'Ubah Data Retur Barang',
                'act' => 'update',
                'sess' => $retur,
                'barang' => $details
            );
            $this->content = $this->load->view('pengeluaran/retur/form', $data, true);
            $this->index($tipe);
        }
    }

    function delete($tipe = "") {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pengeluaran_act");
        $response = $this->pengeluaran_act->proses_form($tipe);
        echo $response;
    }

    function checkStock($id_barang, $jumlah) {
        if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("pengeluaran_act");
        $barang = $this->pengeluaran_act->getData('stock_barang', $id_barang);
        $sisa = $barang['stock'] - $jumlah;
        if ($sisa < 0) {
            $response = "Stock dengan Kode Barang " . $barang['kode_barang'] . " tidak mencukupi";
        } else {
            $response = "Stock mencukupi";
        }
        echo $response;
    }
}