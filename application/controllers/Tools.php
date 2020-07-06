<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller {

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

    function sinkron() {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('tools_act');
        echo $this->tools_act->sinkron();
    }

    function cctv($tipe = "", $ids = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("tools_act");
        if ($tipe == "show") {
            $this->content = $this->tools_act->show_cctv('all');
            $this->index();
        } elseif ($tipe == "frame") {
            $arrdata = $this->tools_act->show_cctv($tipe, $ids);
            $data = $this->load->view('tools/frame', array('url' => $arrdata), true);
            if ($this->input->post("ajax") || $tipe == "back") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        } else {
			$this->addHeader["newtable"] = 1;
			$this->addHeader["alert"]    = 1;
			$this->addHeader["ui"] = 1;
            $arrdata = $this->tools_act->cctv($tipe);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if ($this->input->post("ajax") || $tipe == "back") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function set_cctv($act = "", $divid = "", $id = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('main');
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $this->load->model("tools_act");
            echo $this->tools_act->set_cctv($act);
        } else {
            $DATA = array();
            if ($act == "update") {
                $SQL = "SELECT * FROM m_trader_cctv	WHERE CCTVID='" . $divid . "'";
                $hasil = $this->main->get_result($SQL);
                if ($hasil) {
                    foreach ($SQL->result_array() as $row) {
                        $DATA = $row;
                    }
                }
            }
            $mdldata = array('act' => $act, 'DATA' => $DATA);
            echo $this->load->view("tools/cctv", $mdldata, true);
        }
    }

    function showpop($divid = "", $id = "") {
        $this->load->model('tools_act');
        echo $this->tools_act->show_cctv('popup', $id);
    }

    function viewrevisidokumen($dok = "", $aju = "", $bagian = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("tools_act");
        $this->tools_act->viewrevisidokumen($dok, $aju, $bagian);
    }

    function eksekusirevisidokumen($act = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("tools_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $this->tools_act->eksekusirevisidokumen($act);
        }
    }

    function revisinull($aju="",$kode_barang="",$seri_barang=""){
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("tools_act");
        echo $this->tools_act->revisinull($aju,$kode_barang,$seri_barang)."##".$aju."##".$kode_barang."##".$seri_barang;
    }

    function revisi($tipe = "", $dokumen = "", $number = "", $ajax = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
        $this->load->model("tools_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post" && $tipe!="ajax") {
            $arrdata = $this->tools_act->tab($tipe);
            $data = $this->load->view('tools/list_revisi', $arrdata, true);
            $this->content = $data;
             $this->index();
        } else{
            if($tipe="ajax")$ajax=$tipe;
            echo $this->tools_act->daftar_revisi($tipe,$dokumen,'','1',$ajax);
        }
        
    }

    function revisidelete($tipe = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("tools_act");
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            if ($this->input->post("act")=="delete") {
                echo $this->tools_act->deleterevisidokumen();
            }
        }
    }

    function revisidraft($tipe=""){
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            #echo $this->input->post("act")."#".$this->input->post("datarevisi")."#".$this->input->post("alasan");die();
            $this->load->model("tools_act");
            if($this->input->post("act")=="todraft"){  
                $data   = explode('|', $this->input->post("datarevisi"));#echo $data[0].'#'. $data[1].'#'.$this->input->post("alasan");die();
                $alasan = $this->input->post("alasan");
                echo $this->tools_act->revisidraft($data[0],$data[1],$alasan);
            }
        }
    }

    function setalasan($act, $param) {
        $data = array(
            'data' => $param,
            'act' => $act);
        echo $this->load->view('tools/alasan_revisi', $data, true);
    }

}

?>