<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Produksi extends CI_Controller 
{
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

    function add($tipe = "") {
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("produksi_act");
        if ($tipe == "bhn_baku_view" || $tipe == "hsl_prod_view" || $tipe == "hsl_sisa_view") {
            //$this->insert_id();
            //$NOMOR_PROSES = $this->uri->segment(4);
            //$KODE_TRADER = $this->uri->segment(5); //echo $IDBJ.'-'.$KODE;
			#start by pass untuk edit formjs
			$generate = $this->input->post('generate');
			if($generate == "formjs"){
				$NOMOR_PROSES = $this->input->post('id1');
				$KODE_TRADER = $this->input->post('id2');
			}else{
				$NOMOR_PROSES = "";	
				$KODE_TRADER = "";	
			}
	    	#end by pass untuk edit formjs

            $resultdata = $this->produksi_act->getData($tipe, $NOMOR_PROSES, $KODE_TRADER);
            $arrdata = $this->produksi_act->detil($tipe, $NOMOR_PROSES, $KODE_TRADER); //print_r($arrdata);

            if ($tipe == "bhn_baku_view") {
                $arrdata['judul'] = "Detil Data Penggunaan Bahan Baku";
                $judul = "View Data Bahan Baku";
            } elseif ($tipe == "hsl_prod_view") {
                $arrdata['judul'] = "Detil Data Hasil Produksi";
                $judul = "View Data Hasil Produksi";
            } elseif ($tipe == "hsl_sisa_view") {
                $arrdata['judul'] = "Detil Data Hasil Sisa Produksi";
                $judul = "View Data Hasil Sisa Produksi";
            }
            $list = $this->load->view('list', $arrdata, true);

            $data = array("judul" => $judul,
                "act" => "view",
                "NOMOR_PROSES" => $NOMOR_PROSES,
                "KODE_TRADER" => $KODE_TRADER,
                "list" => $list,
                "sess" => $resultdata,
                "JENIS_BRG" => $func->main->get_mtabel('ASAL_JENIS_BARANG')
            );
            if ($tipe == "bhn_baku_view")
                $this->content = $this->load->view('produksi/bahan_baku/detil_bhn_baku', $data, true);
            elseif ($tipe == "hsl_prod_view")
                $this->content = $this->load->view('produksi/hasil_produksi/detil_hsl_prod', $data, true); 
			elseif ($tipe == "hsl_sisa_view")
                $this->content = $this->load->view('produksi/hasil_sisa/detil_hsl_sisa', $data, true);
            $this->index($tipe);
        }
        elseif ($tipe == "bahan_bakuPOPN" || $tipe == "hasil_prodPOPN" || $tipe == "hasil_sisaPOPN") {//die('sini');
            $tanggal = $this->uri->segment(6);
            $waktu = $this->uri->segment(7); //echo $tanggal.' '.$waktu;exit;
            $prevProses = $this->produksi_act->get_prevProses();
            $kodeTrader = $this->newsession->userdata('KODE_TRADER'); //echo $lastProses;
            $queryJenis = "SELECT JENIS_BARANG FROM M_TRADER_PROSES WHERE NOMOR_PROSES='$prevProses'"; //echo $queryJenis;
            $hasil = $func->main->get_result($queryJenis);
            if ($hasil) {
                foreach ($queryJenis->result_array() as $row) {
                    $dataarray = $row;
                }
            }
            $getJENIS = $dataarray['JENIS_BARANG'];
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->produksi_act->proses_form($tipe);
                echo $data;
            }
            $resultTrader = $this->produksi_act->getData($tipe, $prevProses, $kodeTrader); //print_r($resultTrader);die();
            if ($tipe == "bahan_bakuPOPN") {
                $judul = "Tambah Data Penggunaan Bahan Baku";
            } elseif ($tipe == "hasil_prodPOPN") {
                $judul = "Tambah Data Hasil Produksi";
            } elseif ($tipe == "hasil_sisaPOPN") {
                $judul = "Tambah Data Hasil Sisa Produksi";
            }
            $data = array("judul" => $judul,
                "TANGGAL" => $tanggal,
                "WAKTU" => $waktu,
                "act" => "save new",
                "NOMOR_PROSES" => $prevProses,
                "KODE_TRADER" => $kodeTrader,
                "JENIS_BRG" => $getJENIS
            );
            if ($tipe == "bahan_bakuPOPN")
                $this->load->view('produksi/bahan_baku/form_bhn_baku', $data);
            elseif ($tipe == "hasil_prodPOPN")
                $this->load->view('produksi/hasil_produksi/form_hsl_prod', $data);
            elseif ($tipe == "hasil_sisaPOPN")
                $this->load->view('produksi/hasil_sisa/form_hsl_sisa', $data);
        }
        elseif ($tipe == "bahan_bakuPOP" || $tipe == "hasil_prodPOP" || $tipe == "hasil_sisaPOP") {
            $NOMOR_PROSES = $this->uri->segment(4); //echo $NOMOR_PROSES;
            $KODE_TRADER = $this->uri->segment(5);
            $tanggal = $this->uri->segment(6);
            $waktu = $this->uri->segment(7);
            $prevProses = $this->produksi_act->get_prevProses();
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->produksi_act->proses_form($tipe);
                echo $data;
            }
            if ($tipe == "bahan_bakuPOP")
                $judul = "Tambah Data Penggunaan Bahan Baku";
            elseif ($tipe == "hasil_prodPOP")
                $judul = "Tambah Data Hasil Produksi";
            elseif ($tipe == "hasil_sisaPOP")
                $judul = "Tambah Data Hasil Sisa Produksi";
            $resultTrader = $this->produksi_act->getData($tipe, $NOMOR_PROSES, $KODE_TRADER);
            $data = array("judul" => $judul,
                "TANGGAL" => $tanggal,
                "WAKTU" => $waktu,
                "act" => "save",
                "NOMOR_PROSES" => $NOMOR_PROSES,
                "KODE_TRADER" => $KODE_TRADER,
                "JENIS_BRG" => $func->main->get_mtabel('ASAL_JENIS_BARANG')
            );
            if ($tipe == "bahan_bakuPOP")
                $this->load->view('produksi/bahan_baku/form_bhn_baku', $data);
            elseif ($tipe == "hasil_prodPOP")
                $this->load->view('produksi/hasil_produksi/form_hsl_prod', $data);
            elseif ($tipe == "hasil_sisaPOP")
                $this->load->view('produksi/hasil_sisa/form_hsl_sisa', $data);
        }
        elseif ($tipe == "bhn_baku_new" || $tipe == "hsl_prod_new" || $tipe == "hsl_sisa_new") {
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->produksi_act->proses_form($tipe);
                echo $data;
            }//die('tes');
            $kodeTrader = $this->newsession->userdata('KODE_TRADER');
            $lastProses = $this->produksi_act->get_lastProses(); //echo $lastProses;
            $queryJenis = "SELECT JENIS_BARANG FROM m_trader_proses WHERE NOMOR_PROSES='$lastProses'"; //echo $queryJenis;
            $hasil = $func->main->get_result($queryJenis);
            if ($hasil) {
                foreach ($queryJenis->result_array() as $row) {
                    $dataarray = $row;
                }
            }//print_r($getKODE);die();
            $getJENIS = $dataarray['JENIS_BARANG']; //echo $getJENIS;
            $arrdata = $this->produksi_act->detil($tipe, $lastProses, $kodeTrader); //print_r($arrdata);die();
            if ($tipe == "bhn_baku_new") {
                $arrdata['judul'] = "Detil Penggunaan Barang Yang Diproses";
                $judul = "Tambah Data Barang Yang Diproses";
            } elseif ($tipe == "hsl_prod_new") {
                $arrdata['judul'] = "Detil Hasil Pengerjaan";
                $judul = "Tambah Data Hasil Pengerjaan";
            } elseif ($tipe == "hsl_sisa_new") {
                $arrdata['judul'] = "Detil Sisa Pengerjaan";
                $judul = "Tambah Data Sisa Pengerjaan";
            }
            $list = $this->load->view('list', $arrdata, true);
            $data = array("judul" => $judul,
                "act" => "save new",
                "list" => $list,
                "NOMOR_PROSES" => $lastProses,
                "KODE_TRADER" => $kodeTrader,
                "JENIS_BARANG" => $getJENIS
            );
            if ($tipe == "bhn_baku_new")
                $this->content = $this->load->view('produksi/bahan_baku/detil_bhn_baku', $data, true);
            elseif ($tipe == "hsl_prod_new")
                $this->content = $this->load->view('produksi/hasil_produksi/detil_hsl_prod', $data, true);
            elseif ($tipe == "hsl_sisa_new")
                $this->content = $this->load->view('produksi/hasil_sisa/detil_hsl_sisa', $data, true);
            $this->index($tipe);
        }
        elseif ($tipe == "Bhn_Baku_New" || $tipe == "Hsl_Prod_New" || $tipe == "Hsl_Sisa_New") {//reload ajax form konversi
            if ($tipe == "Bhn_Baku_New")
                $type = "bhn_baku_new";
            elseif ($tipe == "Hsl_Prod_New")
                $type = "hsl_prod_new";
            elseif ($tipe == "Hsl_Sisa_New")
                $type = "hsl_sisa_new";
            $prevProses = $this->produksi_act->get_prevProses();
            $lastProses = $this->produksi_act->get_lastProses();
            $kodeTrader = $this->newsession->userdata('KODE_TRADER'); //echo $lastProses;
            $queryJenis = "SELECT JENIS_BARANG FROM m_trader_proses WHERE NOMOR_PROSES='$prevProses'"; //echo $queryJenis;
            $hasil = $func->main->get_result($queryJenis);
            if ($hasil) {
                foreach ($queryJenis->result_array() as $row) {
                    $dataarray = $row;
                }
            }//print_r($getKODE);die();
            $getJENIS = $dataarray['JENIS_BARANG'];
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->produksi_act->proses_form($tipe);
                echo $data;
            }
            $resultdata = $this->produksi_act->getData($type, $prevProses, $kodeTrader);
            $arrdata = $this->produksi_act->detil($type, $prevProses, $kodeTrader); //print_r($resultdata);die();
            if ($tipe == "Bhn_Baku_New") {
                $judul = "Tambah Data Penggunaan Bahan Baku";
                $arrdata["judul"] = "Data Detil Penggunaan Bahan Baku";
            } elseif ($tipe == "Hsl_Prod_New") {
                $judul = "Tambah Data Hasil Produksi";
                $arrdata["judul"] = "Data Detil Hasil Produksi";
            } elseif ($tipe == "Hsl_Sisa_New") {
                $judul = "Tambah Data Hasil Sisa Produksi";
                $arrdata["judul"] = "Data Detil Hasil Sisa Produksi";
            }
            $list = $this->load->view('list', $arrdata, true);
            $data = array("judul" => $judul,
                "act" => "save new",
                "list" => $list,
                "NOMOR_PROSES" => $prevProses,
                "KODE_TRADER" => $kodeTrader,
                "JENIS_BARANG" => $getJENIS,
                "sess" => $resultdata,
                "DIRECT" => "YES"
            );
            if ($tipe == "Bhn_Baku_New")
                $this->content = $this->load->view('produksi/bahan_baku/detil_bhn_baku', $data, true);
            elseif ($tipe == "Hsl_Prod_New")
                $this->content = $this->load->view('produksi/hasil_produksi/detil_hsl_prod', $data, true);
            elseif ($tipe == "Hsl_Sisa_New")
                $this->content = $this->load->view('produksi/hasil_sisa/detil_hsl_sisa', $data, true);
            $this->index($tipe);
        }
        elseif ($tipe == "bhn_baku_list_new" || $tipe == "hsl_prod_list_new" || $tipe == "hsl_sisa_list_new") {
            if ($tipe == "bhn_baku_list_new")
                $type = "bhn_baku_new";
            elseif ($tipe == "hsl_prod_list_new")
                $type = "hsl_prod_new";
            elseif ($tipe == "hsl_sisa_list_new")
                $type = "hsl_sisa_new";
            $NOMOR_PROSES = $this->uri->segment(4);
            $KODE_TRADER = $this->uri->segment(5);

            //$resultdata=$this->produksi_act->getData($tipe,$NOMOR_PROSES,$KODE_TRADER);
            $arrdata = $this->produksi_act->detil($type, $NOMOR_PROSES, $KODE_TRADER);
            if ($tipe == "bhn_baku_list_new")
                $arrdata["judul"] = "Data Detil Bahan Baku";
            elseif ($tipe == "hsl_prod_list_new")
                $arrdata["judul"] = "Data Detil Produksi Baku";
            elseif ($tipe == "hsl_sisa_list_new")
                $arrdata["judul"] = "Data Detil Hasil Sisa/Scrap";

            $list = $this->load->view('produksi/prod', $arrdata, true);
            if ($this->input->post("ajax")) {
                echo $arrdata;
            } else {
                echo $list;
            }
        }
    }

    function set_produksi($tipe = "", $revisi="") {
        $this->load->model("produksi_act");
        $ret = $this->produksi_act->set_produksi($this->input->post("act"), $tipe, $revisi);
    }

    function edit($tipe = "", $key1 = "", $key2 = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("produksi_act");
        if ($tipe == "bahan_bakuPOP" || $tipe == "hasil_prodPOP" || $tipe == "hasil_sisaPOP") {
            $type = "bahanBakuPOPget"; //die('sini');
            $NOMOR_PROSES = $this->uri->segment(4); //echo $key1;//die();
            $KODE_TRADER = $this->uri->segment(5);
            $SERI = $this->uri->segment(6);
            $tanggal = $this->uri->segment(7);
            $waktu = $this->uri->segment(8); //echo $tanggal.' '.$waktu;exit;
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->produksi_act->proses_form($tipe);
                echo $data;
            }
            $resultdata = $this->produksi_act->getData($type, $NOMOR_PROSES, $KODE_TRADER); //print_r($resultdata);
            if ($tipe == "bahan_bakuPOP")
                $judul = "Ubah Data Penggunaan Bahan Baku";
            elseif ($tipe == "hasil_prodPOP")
                $judul = "Ubah Data Hasil Produksi";
            elseif ($tipe == "hasil_sisaPOP")
                $judul = "Ubah Data Hasil Sisa Produksi";
            $data = array("judul" => $judul,
                "act" => "update",
                "NOMOR_PROSES" => $NOMOR_PROSES,
                "KODE_TRADER" => $KODE_TRADER,
                "SERI" => $SERI,
                "TANGGAL" => $tanggal,
                "WAKTU" => $waktu,
                "sess" => $resultdata,
                "JENIS_BRG" => $func->main->get_mtabel('ASAL_JENIS_BARANG')
            );
            if ($tipe == "bahan_bakuPOP")
                $this->load->view('produksi/bahan_baku/form_bhn_baku', $data);
            elseif ($tipe == "hasil_prodPOP")
                $this->load->view('produksi/hasil_produksi/form_hsl_prod', $data);
            elseif ($tipe == "hasil_sisaPOP")
                $this->load->view('produksi/hasil_sisa/form_hsl_sisa', $data);
        }elseif ($tipe == "bahan_bakuPOPN" || $tipe == "hasil_prodPOPN" || $tipe == "hasil_sisaPOPN") {//die('sinivvvv');
            $type = "bahanBakuPOPget";
            $NOMOR_PROSES = $this->uri->segment(4); //echo $key1;//die();
            $KODE_TRADER = $this->uri->segment(5);
            $SERI = $this->uri->segment(6);
            $tanggal = $this->uri->segment(7);
            $waktu = $this->uri->segment(8); //echo $tanggal.' '.$waktu;exit;
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->produksi_act->proses_form($tipe);
                echo $data;
            }
            $resultdata = $this->produksi_act->getData($type, $NOMOR_PROSES, $KODE_TRADER); //print_r($resultdata);
            if ($tipe == "bahan_bakuPOPN")
                $judul = "Ubah Data Penggunaan Bahan Baku";
            elseif ($tipe == "hasil_prodPOPN")
                $judul = "Ubah Data Hasil Produksi";
            elseif ($tipe == "hasil_sisaPOPN")
                $judul = "Ubah Data Hasil Sisa Produksi";
            $data = array("judul" => $judul,
                "act" => "update new",
                "NOMOR_PROSES" => $NOMOR_PROSES,
                "KODE_TRADER" => $KODE_TRADER,
                "SERI" => $SERI,
                "TANGGAL" => $tanggal,
                "WAKTU" => $waktu,
                "sess" => $resultdata,
                "JENIS_BRG" => $func->main->get_mtabel('ASAL_JENIS_BARANG')
            );
            if ($tipe == "bahan_bakuPOPN")
                $this->load->view('produksi/bahan_baku/form_bhn_baku', $data);
            elseif ($tipe == "hasil_prodPOPN")
                $this->load->view('produksi/hasil_produksi/form_hsl_prod', $data);
            elseif ($tipe == "hasil_sisaPOPN")
                $this->load->view('produksi/hasil_sisa/form_hsl_sisa', $data);
        }
        elseif ($tipe == "bhn_baku_detil" || $tipe == "hsl_prod_detil" || $tipe == "hsl_sisa_detil") {
            $NOMOR_PROSES = $this->uri->segment(4); //echo $NOMOR_PROSES;//die();
            $KODE_TRADER = $this->uri->segment(5);
            if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->produksi_act->proses_form($tipe);
                echo $data;
            }
            $resultdata = $this->produksi_act->getData($tipe, $NOMOR_PROSES, $KODE_TRADER);
            $arrdata = $this->produksi_act->detil($tipe, $NOMOR_PROSES, $KODE_TRADER);
            if ($tipe == "bhn_baku_detil") {
                $arrdata["judul"] = "Detil Penggunaan Bahan Baku";
                $judul = "Ubah Data Penggunaan Bahan Baku";
            } elseif ($tipe == "hsl_prod_detil") {
                $arrdata["judul"] = "Detil Hasil Produksi";
                $judul = "Ubah Data Hasil Produksi";
            } elseif ($tipe == "hsl_sisa_detil") {
                $arrdata["judul"] = "Detil Hasil Sisa Produksi";
                $judul = "Ubah Data Hasil Sisa Produksi";
            }
            $list = $this->load->view('list', $arrdata, true); //echo $list;die();
            $data = array("judul" => $judul,
                "act" => "update",
                "NOMOR_PROSES" => $NOMOR_PROSES,
                "KODE_TRADER" => $KODE_TRADER,
                "list" => $list,
                "sess" => $resultdata,
                "JENIS_BRG" => $func->main->get_mtabel('ASAL_JENIS_BARANG')
            );
            if ($tipe == "bhn_baku_detil")
                $this->content = $this->load->view('produksi/bahan_baku/detil_bhn_baku', $data, true);
            elseif ($tipe == "hsl_prod_detil")
                $this->content = $this->load->view('produksi/hasil_produksi/detil_hsl_prod', $data, true); elseif ($tipe == "hsl_sisa_detil")
                $this->content = $this->load->view('produksi/hasil_sisa/detil_hsl_sisa', $data, true);

            $this->index($tipe);
        }
        elseif ($tipe == "bhn_baku_list_detil" || $tipe == "bhn_baku_list_detil_get" || $tipe == "bhn_baku_list_new" || $tipe == "bhn_baku_list_view" || $tipe == "hsl_prod_list_view" || $tipe == "hsl_prod_list_detil" || $tipe == "hsl_prod_list_new" || $tipe == "hsl_sisa_list_detil" || $tipe == "hsl_sisa_list_view" || $tipe == "hsl_sisa_list_new") {
            if ($tipe == "bhn_baku_list_detil")
                $type = "bhn_baku_detil";
            elseif ($tipe == "bhn_baku_list_detil_get")
                $type = "bhn_baku_detil";
            elseif ($tipe == "bhn_baku_list_new")
                $type = "bhn_baku_new";
            elseif ($tipe == "bhn_baku_list_view")
                $type = "bhn_baku_view";
            elseif ($tipe == "hsl_prod_list_new")
                $type = "hsl_prod_new";
            elseif ($tipe == "hsl_prod_list_detil")
                $type = "hsl_prod_detil";
            elseif ($tipe == "hsl_prod_list_view")
                $type = "hsl_prod_view";
            elseif ($tipe == "hsl_sisa_list_detil")
                $type = "hsl_sisa_detil";
            elseif ($tipe == "hsl_sisa_list_view")
                $type = "hsl_sisa_view";
            elseif ($tipe == "hsl_sisa_list_new")
                $type = "hsl_sisa_new";
            $NOMOR_PROSES = $this->uri->segment(4);
            $KODE_TRADER = $this->uri->segment(5);

            $resultdata = $this->produksi_act->getData($tipe, $NOMOR_PROSES, $KODE_TRADER);
            $arrdata = $this->produksi_act->detil($type, $NOMOR_PROSES, $KODE_TRADER);
            if ($tipe == 'bhn_baku_list_detil_get') {
                $arrdata['judul'] = "Detil Penggunaan Bahan Baku";
                $list = $this->load->view('list', $arrdata, true);
            } else {
                $list = $this->load->view('produksi/prod', $arrdata, true);
            }
            if ($this->input->post("ajax")) {
                echo $arrdata;
            } else {
                echo $list;
            }
        }
    }

    function daftar($tipe = "") {
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("produksi_act");
        $key1 = $this->uri->segment(4);
        $key2 = $this->uri->segment(5);
        //$arrdata = $this->inventory_act->daftar_inventory($tipe);
        if ($tipe == "stock_detil")
            $arrdata = $this->produksi_act->detil($tipe, $key1, $key2);
        else
            $arrdata = $this->produksi_act->daftar_produksi($tipe);
            $data = $this->content = $this->load->view('boxTwo', $arrdata, true);
        if ($this->input->post("ajax")) {
            echo $arrdata;
        } else {
            $this->content = $data;
            $this->index();
        }
    }

    function daftar_dok($tipe = "") {
        $this->load->model("produksi_act");
        $key1 = $this->uri->segment(4);
        $key2 = $this->uri->segment(5);
        if ($tipe == "bhn_baku_new" || $tipe == "bhn_baku_detil" || $tipe == "hsl_prod_new" || $tipe == "hsl_prod_detil" || $tipe == "hsl_sisa_new" || $tipe == "hsl_sisa_detil")
            $arrdata = $this->produksi_act->detil($tipe, $key1, $key2);
        else
            $arrdata = $this->produksi_act->daftar_produksi($tipe);
        echo $this->load->view('produksi/prod', $arrdata, true);
    }

    function detil($type = "") {
        $this->load->model("produksi_act");
        $arrdata = $this->produksi_act->detil($type);
        echo $this->load->view('list', $arrdata, true);
    }

    function popup($type, $jenis) {
        $this->load->model('main');
        if ($type == 'bahanBaku' || $type == 'proses_produksi' || $type == "proses_sisa") {
            if ($jenis == 'add') {
                if ($type == 'bahanBaku' || $type == 'proses_produksi' || $type == 'proses_sisa') {
                    $judul = "List Barang";
                }
                $data = array('type' => $type, 'judul' => $judul);
                $this->load->view('inventory/barang/list_brg', $data);
            }
        } elseif ($type == 'hasil_produksi' || $type = "hasil_sisa") {
            if ($jenis == 'add') {
                $judul = "List Nomor Proses";
                $data = array('type' => $type, 'judul' => $judul);
                $this->load->view('produksi/hasil_produksi/list_pop_prod', $data);
            }
        }
    }

    function getKonversi($key1 = "", $key2 = "") {
        $this->load->model("produksi_act");
        $data = $this->produksi_act->getDataKonversi($key1, $key2);
        echo $data;
    }

    function getDetilKonversi($key1 = "", $key2 = "") {
        $this->load->model("inventory_act");
        $data = $this->inventory_act->detil("detil_konversi", $key1, $key2);
        $list = $this->load->view('inventory/inv', $data, true);
        echo $list;
    }

    function prosesproduksi($type = "", $id = "") {
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("produksi_act");
		#start by pass untuk edit formjs
	    $generate = $this->input->post('generate');
	    if($generate == "formjs"){
			$nomor_transaksi = $this->input->post('id1');
	    }else{
			$nomor_transaksi = "";	
		}
	    #end by pass untuk edit formjs
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && ($generate != "formjs")) {
            $this->produksi_act->prosesproduksi($type);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            if ($type == "bahan_baku") {
                $judul = "Penggunaan Barang Yang Diproses";
                $jenis = "masuk";
            } elseif ($type == "hasil_produksi") {
                $judul = "Hasil Pengerjaan";
                $jenis = "keluar";
            } else {
                $judul = "Sisa Pengerjaan/Scrap";
                $jenis = "sisa";
            }
            if ($nomor_transaksi) {
                $lastProses = $nomor_transaksi;
                $data = $this->produksi_act->get_dataproduksi($nomor_transaksi);
            } else {
                $lastProses = $this->produksi_act->get_lastProses();
                $data = array('action' => 'save', 'TANGGAL' => date("Y-m-d"), 'WAKTU' => date("H:i"),
                    'HEADER' => '', 'DETIL' => '', 'KETERANGAN' => '', 'NOMOR_PROSES_ASAL' => '');
            }
            $arraydata = array_merge($data, array("NOMOR_PROSES" => $lastProses, "type" => $type, "judul" => $judul, "jenis" => $jenis));
            $this->content = $this->load->view('produksi/proses_produksi', $arraydata, true);
            $this->index();
        }
    }

    function prosesproduksipopup($type = "", $act = "") { //echo $this->uri->segment(11);die();
		
		$this->addHeader["newtable"] = 1;
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
        $kdbarang = $this->uri->segment(6);
        $kdbarang = str_replace('^', '/', $kdbarang);
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("main");
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $query = "SELECT f_barang('" . $kdbarang . "','" . $this->uri->segment(7) . "','" . $KODE_TRADER . "') URAIAN_BARANG,
				f_ref('ASAL_JENIS_BARANG','" . $this->uri->segment(7) . "') JENIS_BARANG,
				f_satuan('" . $this->uri->segment(9) . "') URAIAN_SATUAN, 
				CONCAT('".$this->uri->segment(11)."',' - ',IFNULL(f_gudang('".$this->uri->segment(11)."','".$KODE_TRADER."'),'UTAMA')) AS UR_GUDANG 
				FROM dual";
		//echo $this->uri->segment(10)." ".$this->uri->segment(11); die();
        $hasil = $this->main->get_result($query);
        if ($hasil) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }
		$jnsbarang = $this->uri->segment(7);
		$kdgudang	= $this->uri->segment(11);
		$kdrak		= $this->uri->segment(12);
		$SQL_GUDANG = "SELECT KODE_GUDANG, KONDISI_BARANG, IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA') AS NAMA_GUDANG 
						FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
						AND KODE_BARANG = '".$kdbarang."' AND JNS_BARANG = '".$jnsbarang."' ORDER BY KODE_GUDANG DESC";
		$SQL_RAK	= "SELECT KODE_RAK, IFNULL(f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER),'NULL') AS NAMA_RAK 
						FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
						AND KODE_BARANG = '".$kdbarang."' AND JNS_BARANG = '".$jnsbarang."' AND KODE_GUDANG='".$kdgudang."'
						 ORDER BY KODE_RAK DESC";
		$SQL_SUB_RAK = "SELECT KODE_SUB_RAK, IFNULL(f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER),'NULL') AS NAMA_SUB_RAK 
						FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
						AND KODE_BARANG = '".$kdbarang."' AND JNS_BARANG = '".$jnsbarang."' AND KODE_GUDANG='".$kdgudang."' 
						AND KODE_RAK = '".$kdrak."' ORDER BY KODE_SUB_RAK DESC";
        $data = array_merge($data, array(
										"act"=>$act,
										"ID" => $this->uri->segment(5),
										"KODE_BARANG" => $kdbarang,
										"JNS_BARANG" => $jnsbarang,
										"JUMLAH" => $this->uri->segment(8),
										"KODE_SATUAN" => $this->uri->segment(9),
										"STOCK_AKHIR" => $this->uri->segment(10),										
										"KODE_GUDANG" => $kdgudang,
										"KODE_RAK" => $kdrak,
										"KODE_SUB_RAK" => $this->uri->segment(13),
										"KONDISI_BARANG" => $this->uri->segment(14),							
										"KETERANGAN" => $this->uri->segment(15)
										));
        $arraydata = array("act" => $act,
						   "sess" => $data,
						   "KODE_GUDANG" => $this->main->get_combobox($SQL_GUDANG,"KODE_GUDANG","NAMA_GUDANG",FALSE),
						   "KODE_RAK" => $this->main->get_combobox($SQL_RAK,"KODE_RAK","NAMA_RAK",FALSE),
						   "KODE_SUB_RAK" => $this->main->get_combobox($SQL_SUB_RAK,"KODE_SUB_RAK","NAMA_SUB_RAK",FALSE),
						   "KONDISI_BARANG" => $this->main->get_combobox($SQL_GUDANG,"KONDISI_BARANG","KONDISI_BARANG",FALSE)
						   );
        echo $this->load->view('produksi/' . $type . '/proses_produksi_popup', $arraydata, true);
    }

    function prosesproduksikonversi($IDBJ = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("main");
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $query = "SELECT IDBB,IDBJ,KODE_TRADER,KODE_BARANG,f_barang(KODE_BARANG,JNS_BARANG,'" . $KODE_TRADER . "') URAIAN_BARANG,
				JNS_BARANG,f_ref('ASAL_JENIS_BARANG',JNS_BARANG) JENIS_BARANG,f_satuan(KODE_SATUAN) URAIAN_SATUAN,
				JUMLAH,KODE_SATUAN,KETERANGAN,f_stockakhir_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) AS STOCKAKHIR
				FROM m_trader_konversi_bb WHERE IDBJ='" . $IDBJ . "'";
        $hasil = $this->main->get_result($query);
        if ($hasil) {
            $no = 1;
            $data = "<tr id=\"tr_hdr\"><th width=\"1\">No</th><th>Kode Barang</th><th>Uraian Barang</th><th>Jenis Barang</th><th>Gudang</th><th>Rak</th><th>Subrak</th><th>Jumlah</th><th>Satuan</th><th>Keterangan</th><th>&nbsp;</th></tr>";
            foreach ($query->result_array() as $row) {
                $data.="<tr id=\"tr_dtl" . $no . "\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\"><td class=\"alt\"><span class=\"nop\">" . $no . "</span></td><td class=\"alt\">" . $row["KODE_BARANG"] . "</td>
				<td class=\"alt\">" . $row["URAIAN_BARANG"] . "</td><td class=\"alt\">" . $row["JENIS_BARANG"] . "</td><td class=\"alt\">&nbsp;</td><td class=\"alt\">&nbsp;</td><td class=\"alt\">&nbsp;</td><td class=\"alt\">" . $row["JUMLAH"] . "</td><td class=\"alt\">" . $row["KODE_SATUAN"] . " - " . $row["URAIAN_SATUAN"] . "</td><td class=\"alt\">" . $row["KETERANGAN"] . "</td><td class=\"alt\" width=\"115\" style=\"text-align:center\"><a href=\"javascript:void(0)\" class=\"btn btn-sm btn-info\" onclick=\"prosesproduksi('#fprdbahanbaku_','update','" . $no . "')\"><i class=\"icon-edit bigger-120\"></i></a>&nbsp;<a href=\"javascript:void(0)\" class=\"btn btn-sm btn-danger\" onclick=\"remove_produksi(" . $no . ")\" value=\"Delete\"><i class=\"icon-trash bigger-120\"></i></a><input type=\"hidden\" name=\"DETIL[KODE_BARANG][]\" id=\"KODE_BARANG" . $no . "\" value=\"" . $row["KODE_BARANG"] . "\" class=\"kdbarang\"/><input type=\"hidden\" name=\"DETIL[JNS_BARANG][]\" id=\"JNS_BARANG" . $no . "\" value=\"" . $row["JNS_BARANG"] . "\"  class=\"jnsbarang\"/><input type=\"hidden\" name=\"DETIL[JUMLAH][]\" id=\"JUMLAH" . $no . "\" value=\"" . $row["JUMLAH"] . "\" /><input type=\"hidden\" name=\"DETIL[KODE_SATUAN][]\" id=\"KODE_SATUAN" . $no . "\" value=\"" . $row["KODE_SATUAN"] . "\" /><input type=\"hidden\" name=\"DETIL[KETERANGAN][]\" id=\"KETERANGAN" . $no . "\" value=\"" . $row["KETERANGAN"] . "\"/><input type=\"hidden\" name=\"STOCKAKHIR\" id=\"STOCKAKHIR" . $no . "\" value=\"" . $row["STOCKAKHIR"] . "\" /></td></tr>";
                $no++;
            }
            echo $data;
        }
    }
	function getGudangBarang(){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$this->load->model('produksi_act');
		$model = $this->produksi_act->getGudangBarang();
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){ 
			echo $model;
		}
	}
	function getRak(){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$this->load->model('produksi_act');
		$model = $this->produksi_act->getRak();
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){ 
			echo $model;
		}
	}
	function getSubRak(){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$this->load->model('produksi_act');
		$model = $this->produksi_act->getSubRak();
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){ 
			echo $model;
		}
	}
	
    function prosesmasuk() {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("produksi_act");
        $arrdata = $this->produksi_act->prosesmasuk();
        $data = $this->load->view("list", $arrdata, true);
        if ($this->input->post("ajax"))
            echo $arrdata;
        else
            echo $data;
    }

    function priviewproduksi($tipe = "", $data = "") {
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $data = explode("|", urldecode($data));
        $NOMOR_PROSES = $data[0];
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $this->db->select("NOMOR_PROSES,NOMOR_PROSES_ASAL,TANGGAL,WAKTU,KETERANGAN")->from("M_TRADER_PROSES");
        $row = $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES))->get()->row(); // next_row();
        $DATA["NOMOR_PROSES"] = $row->NOMOR_PROSES;
        $DATA["NOMOR_PROSES_ASAL"] = $row->NOMOR_PROSES_ASAL;
        $DATA["TANGGAL"] = $row->TANGGAL;
        $DATA["WAKTU"] = $row->WAKTU;
        $DATA["KETERANGAN"] = $row->KETERANGAN;
        $this->load->model("produksi_act");
        $arrdata = $this->produksi_act->detil($tipe, $NOMOR_PROSES, $KODE_TRADER);
        $arrdata = array_merge($arrdata, array("DATA" => $DATA, "TIPE" => $tipe));
        echo $this->load->view('produksi/produksi_priview', $arrdata, true);
    }

    function popupcetak($tipe = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		//echo $tipe; die();
        echo $this->load->view('produksi/cetak', array('tipe' => $tipe), true);
    }

    function cetak($tipe = "", $tgl1 = "", $tgl2 = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $tipe = $this->input->post('tipe');
            $TANGGAL_1 = $this->input->post('TANGGAL_1');
            $TANGGAL_2 = $this->input->post('TANGGAL_2');
            echo "MSG#OK#OK#" . site_url() . "/produksi/cetak/" . $tipe . "/" . $TANGGAL_1 . "/" . $TANGGAL_2;
            die();
        }
        ini_set("display_errors", 1);
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $nama = $this->newsession->userdata('NAMA_TRADER');
        $SQL = " SELECT A.NOMOR_PROSES,CONCAT(DATE_FORMAT(A.TANGGAL,'%d-%m-%Y'),' ',WAKTU) AS TANGGAL, A.JENIS_BARANG AS TIPE,
				IF(A.STATUS=0,'DRAFT','DISETUJUI') AS STATUS,
				B.KODE_BARANG, f_ref('ASAL_JENIS_BARANG',B.JNS_BARANG) AS JNS_BARANG, B.JUMLAH,B.KODE_SATUAN,A.KETERANGAN, 
				f_barang(B.KODE_BARANG,B.JNS_BARANG,A.KODE_TRADER) URAIAN_BARANG FROM M_TRADER_PROSES A, M_TRADER_PROSES_DTL B 
				WHERE A.NOMOR_PROSES=B.NOMOR_PROSES AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "' 
				AND A.JENIS_BARANG='" . strtolower($tipe) . "'
				AND a.TANGGAL BETWEEN '" . $tgl1 . "' AND '" . $tgl2 . "' ORDER BY A.TANGGAL ASC";
	   #echo $SQL; die();
        $rs = $this->db->query($SQL);
        $resultRow = $rs->result_array();
        $data = array("tipe" => "produksi", "nama" => $nama, "resultData" => $resultRow, "xls"=>"xls");
        $html = $this->load->view("laporan/print", $data, true);
        $this->cetakexcell('produksi_' . $tipe . '_' . $tgl1 . '_sd_' . $tgl2, $html);
        exit;
    }

    function cetakexcell($filename = "", $contents = "") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $html .= '<style> td{mso-number-format:"\@";}</style>';
        $html .= $contents;
        $filename = str_replace(" ", "_", $filename) . ".xls";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        header("Content-Transfer-Encoding: binary");
        echo $html;
    }

    function revisi($tipe="", $type="") {
        if ($tipe != "ubah") {
            $this->load->model("produksi_act");
            $arrdata = $this->produksi_act->revisi_produksi($tipe,$type);
            $data = $this->load->view('boxTwo', $arrdata, true);
            if($this->input->post("ajax") || $type=="ajax"){
                echo $arrdata;
            }else{
                echo $data;
            }
        }else{
            if(!empty($type)){
                $this->load->model("produksi_act");
                date_default_timezone_set('Asia/Jakarta');
                if ($type == "bahan_baku") {
                    $judul = "Penggunaan Barang Yang Diproses";
                    $jenis = "masuk";
                    $key = $this->input->post('tb_chkfrevisi_bb');
                    foreach ($key as $datacheck){
                        $arrchk = explode(".", $datacheck);
                    }
                    $id = $arrchk[0];
                } elseif ($type == "hasil_produksi") {
                    $judul = "Hasil Pengerjaan";
                    $jenis = "keluar";
                    $key = $this->input->post('tb_chkfrevisi_hp');
                    foreach ($key as $datacheck){
                        $arrchk = explode(".", $datacheck);
                    }
                    $id = $arrchk[0];
                } else {
                    $judul = "Sisa Pengerjaan/Scrap";
                    $jenis = "sisa";
                    $key = $this->input->post('tb_chkfrevisi_ss');
                    foreach ($key as $datacheck){
                        $arrchk = explode(".", $datacheck);
                    }
                    $id = $arrchk[0];
                }
                if ($id) {
                    $lastProses = $id;
                    $data = $this->produksi_act->get_dataproduksi($id);
                } else {
                    $lastProses = $this->produksi_act->get_lastProses();
                    $data = array('action' => 'save', 'TANGGAL' => date("Y-m-d"), 'WAKTU' => date("H:i"),
                        'HEADER' => '', 'DETIL' => '', 'KETERANGAN' => '', 'NOMOR_PROSES_ASAL' => '');
                }
                $arrdata = array_merge($data, array("NOMOR_PROSES" => $lastProses, 
                                                    "type" => $type, 
                                                    "judul" => $judul, 
                                                    "jenis" => $jenis,
                                                    "act" => "revisi"));
                echo $this->content = $this->load->view('produksi/proses_produksi', $arrdata, true);
            }
        }
    }

}

?>