<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller{
	var $content = "";
	var $dokumen = "";
	var $addHeader = array();
	function index($dok = "") {
        if($this->newsession->userdata('LOGGED')){
			$this->load->model('main');
			$this->dokumen = $dok;
			$this->main->get_index($dok,$this->addHeader);	
		}else{
			$this->newsession->sess_destroy();		
			redirect(base_url());
		}
    }
	
	function add($tipe=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}		
		$this->load->model("main","main", true);
		$this->load->model("inventory_act");	
		$this->load->model('pengeluaran_act');
		if($tipe=="barang"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}			
			$resultTrader=$this->inventory_act->getData($tipe,$key1,$key2);
			$NAMA_TRADER = $this->newsession->userdata('NAMA_TRADER');
			$KODETRADE = substr(str_replace(array("PT","pt",".",","," "),"",trim($NAMA_TRADER)),0,3);
			$DTPARTNER = $this->pengeluaran_act->get_partner('','1');
			if($DTPARTNER){
				$PARTNER = array_merge(array($KODETRADE=>$NAMA_TRADER.' ('.$KODETRADE.')'),$DTPARTNER);
			}else{
				$PARTNER = array($KODETRADE=>$NAMA_TRADER.' ('.$KODETRADE.')');
			}
			$COMBOGDG = $this->main->get_combobox("SELECT KODE_GUDANG,CONCAT(NAMA_GUDANG,' (',KODE_GUDANG,')') URAIAN FROM M_TRADER_GUDANG 
					                           	   WHERE KODE_TRADER = '".$this->newsession->userdata("KODE_TRADER")."' 
											       ORDER BY KODE_GUDANG ","KODE_GUDANG", "URAIAN", TRUE);
			$data = array("judul"=>"Tambah Data Barang",
						  "act"=>"save",
						  "dokumen"=>$dok,
						  "resultTrader"=>$resultTrader,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG'),
						  "PARTNER" => $PARTNER,
						  "KODE_GUDANG" => $COMBOGDG); 
			$this->content = $this->load->view('inventory/barang/form_inv', $data, true);
			$this->index($tipe);			
		}elseif($tipe=="stockopname"){
			$this->content = $this->load->view('inventory/stock_opname/detil_stok','',true);
			$this->index();	
		}
		elseif($tipe=="detilkonversi"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
		}
		elseif($tipe=="detilkonversi_sub"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
		}
		elseif($tipe=="stock_list_detil"){
			$type="stock_detil";
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);			
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$arrdata = $this->inventory_act->detil($type,$idTrader,$tgl);
			$arrdata["judul"]="Detil Stock Opname";
	 		$list = $this->load->view('list', $arrdata, true);
			if($this->input->post("ajax")){
			echo  $arrdata;
			}else{
			echo $list;}

		}
		elseif($tipe=="konversi_view" || $tipe=="konversi_sub_view"){
			$IDBJ=$this->uri->segment(4);
			$KODE=$this->uri->segment(5);
			$resultdata=$this->inventory_act->getData($tipe,$IDBJ,$KODE);
			$arrdata=$this->inventory_act->detil($tipe,$IDBJ,$KODE);
			$arrdata['judul']="Detil Data Konversi";
	 		$list = $this->load->view('inventory/inv', $arrdata, true);
			$data = array("judul"=>"View Data Konversi",
						  "act"=>"view",
						  "tanggal"=>$tgl,
						  "idTrader"=>$idTrader,
						  "list"=>$list,
						  "sess"=>$resultdata,
						  "resultTrader"=>$resultTrader				  
						  );
			if($tipe=="konversi_view")$this->content = $this->load->view('inventory/konversi/detil_konversi', $data, true);	
			else $this->content = $this->load->view('inventory/konversi_sub/detil_konversi_sub', $data, true);
			$this->index($tipe);	
		}
		elseif($tipe=="konversiPOPN" || $tipe=="konversi_subPOPN"){
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$getID = (int)$this->main->get_uraian("SELECT MAX(IDBJ) AS MAXSERI FROM M_TRADER_KONVERSI_BJ", "MAXSERI");
			$getIDNEW = (int)$this->main->get_uraian("SELECT MAX(IDBJ) AS MAXSERI FROM M_TRADER_KONVERSI_BJ", "MAXSERI");
			$queryKODE = "SELECT KODE_TRADER FROM M_TRADER_KONVERSI_BJ WHERE IDBJ='$getID'";
			$hasil = $this->main->get_result($queryKODE);
			if($hasil){
				foreach($queryKODE->result_array() as $row){
					$dataarray = $row;
				}
			}
			$getKODE=$dataarray['KODE_TRADER'];
			$resultTrader=$this->inventory_act->getData($tipe,$getID,$getKODE);
			$data = array("judul"=>"Tambah Data Bahan Baku",
						  "act"=>"save new",
						  "idBJ"=>$getID,
						  "idBJ"=>$getIDNEW,
						  "kode"=>$getKODE,
						  "resultTrader"=>$resultTrader,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );
			if($tipe=="konversiPOPN")$this->load->view('inventory/konversi/form_konversi', $data);
			else $this->load->view('inventory/konversi_sub/form_konversi_sub', $data);	
		}elseif($tipe=="konversiPOP"||$tipe=="konversi_subPOP"){
			$IDBJ=$this->uri->segment(4);
			$KODE=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultTrader=$this->inventory_act->getData($tipe,$IDBJ,$KODE);
			$data = array("judul"=>"Tambah Data Bahan Baku",
						  "act"=>"save",
						  "idBJ"=>$IDBJ,
						  "kode"=>$KODE,
						  "resultTrader"=>$resultTrader,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );
			if($tipe=="konversiPOP")$this->load->view('inventory/konversi/form_konversi', $data);
			else $this->load->view('inventory/konversi_sub/form_konversi_sub', $data);	
		}elseif($tipe=="konversi_new"|| $tipe=="konversi_sub_new"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultTrader=$this->inventory_act->getData($tipe,$key1,$key2);
			$resultdata=$this->inventory_act->getData($tipe,$getID,$getKODE);
			$arrdata=$this->inventory_act->detil($tipe,$getID,$getKODE);
			if($tipe=="konversi_new")$judul="Tambah Data Konversi";
			else $judul="Tambah Data Konversi Subkontrak";
	 		$list = $this->load->view('list', $arrdata, true);
			$data = array("judul"=>$judul,
						  "act"=>"save new",
						  "IDBJ"=>$getID,
						  "KODE"=>$getKODE,
						  "list"=>$list,
						  "sess"=>$resultdata,
						  "resultTrader"=>$resultTrader
						  );
			if($tipe=="konversi_new")$this->content = $this->load->view('inventory/konversi/detil_konversi', $data, true);	
			else{$this->content = $this->load->view('inventory/konversi_sub/detil_konversi_sub', $data, true);}
			$this->index($tipe);		
		}
		elseif($tipe=="Konversi_New" || $tipe=="Konversi_Sub_New"){
			if($tipe=="Konversi_New")$type="konversi_new";
			else{$type="konversi_sub_new";}
			$getID = (int)$this->main->get_uraian("SELECT MAX(IDBJ) AS MAXSERI FROM M_TRADER_KONVERSI_BJ", "MAXSERI");
			$queryKODE = "SELECT KODE_TRADER FROM m_trader_konversi_bj WHERE IDBJ='$getID'";
			$hasil = $this->main->get_result($queryKODE);
			if($hasil){
				foreach($queryKODE->result_array() as $row){
					$dataarray = $row;
				}
			}
			$getKODE=$dataarray['KODE_TRADER'];
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultTrader=$this->inventory_act->getData($type,$key1,$key2);
			$resultdata=$this->inventory_act->getData($type,$getID,$getKODE);
			$arrdata=$this->inventory_act->detil($type,$getID,$getKODE);
			if($tipe=="Konversi_New"){
				$judul="Tambah Data Konversi";
				$arrdata["judul"]="Data Detil Bahan Baku";
			}else{
				$judul="Tambah Data Konversi Subkontrak";
				$arrdata["judul"]="Data Detil Bahan Baku";
			}
	 		$list = $this->load->view('list', $arrdata, true);
			$data = array("judul"=>$judul,
						  "act"=>"save new",
						  "IDBJ"=>$getID,
						  "KODE"=>$getKODE,
						  "list"=>$list,
						  "sess"=>$resultdata,
						  "resultTrader"=>$resultTrader,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );
			if($tipe=="Konversi_New")$this->content = $this->load->view('inventory/konversi/detil_konversi', $data, true);	
			else{$this->content = $this->load->view('inventory/konversi_sub/detil_konversi_sub', $data, true);}	
			$this->index($tipe);	
		}
		elseif($tipe=="konversi_detil"){
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultTrader=$this->inventory_act->getData($tipe,$key1,$key2);
			$arrdata=$this->inventory_act->detil($tipe,$idTrader,$tgl);//print_r($resultdata);die();
			$arrdata['judul']="Detil Data Konversi";
	 		$list = $this->load->view('list', $arrdata, true);
			$data = array("judul"=>"Tambah Data Konversi",
						  "act"=>"save",
						  "tanggal"=>$tgl,
						  "idTrader"=>$idTrader,
						  "list"=>$list,
						  "sess"=>$resultdata,
						  "resultTrader"=>$resultTrader,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );
			$this->content = $this->load->view('inventory/konversi/detil_konversi', $data, true);	
			$this->index($tipe);	
		}
		elseif($tipe=="konversi_list_detil"){
			$type="konversi_detil";
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$arrdata = $this->inventory_act->detil($type,$idTrader,$tgl);
			$arrdata["judul"]="Detil Konversi";
	 		$list = $this->load->view('list', $arrdata, true);
			if($this->input->post("ajax"))echo  $arrdata;
			else echo $list;
		}
		elseif($tipe=="konversi_list_new" || $tipe=="konversi_sub_list_new"){
			if($tipe=="konversi_list_new")$type="konversi_new";
			else $type="konversi_sub_new";
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$arrdata = $this->inventory_act->detil($type,$idTrader,$tgl);
			$arrdata["judul"]="Detil Konversi";
	 		$list = $this->load->view('inventory/inv', $arrdata, true);
			if($this->input->post("ajax")) echo  $arrdata;
			else echo $list;
		}
	}
	
	function set_inventory($tipe=""){
		$this->load->model("inventory_act");
		$ret = $this->inventory_act->set_inventory($this->input->post("act"), $tipe);
	}
	
	function edit($tipe="",$key1="",$key2="", $kdbarang=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("main","main", true);
		$this->load->model("inventory_act");
		$this->load->model('pengeluaran_act');
		if($tipe=="barang"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$find = array('^','|@|','~');
			$replacer = array('/','.',' ');
			$key1 = str_replace($find, $replacer, $key1);
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$NAMA_TRADER = $this->newsession->userdata('NAMA_TRADER');
			$KODETRADE = substr(str_replace(array("PT","pt",".",","," "),"",trim($NAMA_TRADER)),0,3);
			$COMBOGDG = $this->main->get_combobox("SELECT KODE_GUDANG,CONCAT(NAMA_GUDANG,' (',KODE_GUDANG,')') URAIAN FROM M_TRADER_GUDANG 
					                           	   WHERE KODE_TRADER = '".$this->newsession->userdata("KODE_TRADER")."' 
											       ORDER BY KODE_GUDANG ","KODE_GUDANG", "URAIAN", TRUE);
			$data = array("judul"=>"Ubah Data Barang",
						  "act"=>"update",
						  "dokumen"=>$dok,
						  "sess"=>$resultdata,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG'),
						  "PARTNER" => array_merge(array($KODETRADE=>$NAMA_TRADER.' ('.$KODETRADE.')'),$this->pengeluaran_act->get_partner('','1')),
						  "KODE_GUDANG" => $COMBOGDG);
			$this->content = $this->load->view('inventory/barang/form_inv', $data, true);	
			$this->index($tipe);
		}
		elseif($tipe=="barangview"){

			$find = array('^','|@|');
			$replacer = array('/','.');
			$key1 = str_replace($find, $replacer, $key1);
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$data = array("judul"=>"Preview Data Barang",
						  "act"=>"priview",
						  "dokumen"=>$dok,
						  "sess"=>$resultdata				  
						  );	
			$this->content = $this->load->view('inventory/barang/form_inv', $data, true);	
			$this->index($tipe);
		}
		elseif($tipe=="detilstock"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
		}elseif($tipe=="updatestock"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
		}
		elseif($tipe=="detilkonversi" || $tipe=="detilkonversi_sub"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
		}
		elseif($tipe=="detilkonversi_sub"){
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
		}
		elseif($tipe=="stock"){
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$data = array("judul"=>"Ubah Data Stock",
						  "act"=>"update",
						  "tanggal"=>$tgl,
						  "idTrader"=>$idTrader,
						  "sess"=>$resultdata,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );	
			$this->content = $this->load->view('inventory/stock_opname/form_stock', $data, true);	
			$this->index($tipe);
		}
		elseif($tipe=="stockPOP"){
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
			}
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2,$kdbarang);
			$data = array("judul"=>"Ubah Data Stock",
						  "act"=>"update",
						  "tanggal"=>$tgl,
						  "idTrader"=>$idTrader,
						  "sess"=>$resultdata,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );	
			$this->load->view('inventory/stock_opname/form_stock', $data);	
		}
		elseif($tipe=="stockPOPDtl2"){
			$idTrader=$this->uri->segment(5);
			$tgl=$this->uri->segment(4);
			
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultTrader=$this->inventory_act->getData($tipe,$idTrader,$key2);
			
			$data = array("judul"=>"Tambah Detil Barang",
						  "act"=>"update",
						  "tanggal"=>$idTrader,
						  "data"=>$resultTrader,
						  "hidden"=>$tgl
						  );	
			$this->load->view('inventory/stock_opname/form_stock_detil', $data);	
		}
		elseif($tipe=="stockPOPN"){
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
			}
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$data = array("judul"=>"Ubah Data Stock",
						  "act"=>"update",
						  "tanggal"=>$tgl,
						  "idTrader"=>$idTrader,
						  "sess"=>$resultdata,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );	
			$this->load->view('inventory/stock_opname/form_stock', $data);	
		}
		elseif($tipe=="stock_detil"){
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultTrader=$this->inventory_act->getData($tipe,$key1,$key2);
			$arrdata = $this->inventory_act->detil($tipe,$idTrader,$tgl);
			$SQL = "SELECT MAX(ID)+1 AS ID FROM m_trader_stockopname";
			$result = $this->db->query($SQL);
			$hidden = $result->row();
			
			$arrdata["judul"]="Detil Barang";
	 		$list = $this->load->view('list', $arrdata, true);
			$data = array("judul"=>"Ubah Data Stock Opname",
						  "act"=>"update",
						  "tanggal"=>$tgl,
						  "idTrader"=>$idTrader,
						  "list"=>$list,
						  "sess"=>$resultdata,
						  "resultTrader"=>$resultTrader,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG'),
						  "hidden"=>$hidden
						  );	
			$this->content = $this->load->view('inventory/stock_opname/detil_stok', $data, true);	
			$this->index($tipe);
		}
		elseif($tipe=="stock_list_detil" || $tipe=="stock_list_view" || $tipe=="stockPOPDtl"){
			if($tipe=="stock_list_detil")$type="stock_detil";
			if($tipe=="stock_list_view")$type="stock_view";
			if($tipe=="stockPOPDtl")$type="stockPOPDtl";
			$idTrader=$this->uri->segment(4);
			$tgl=$this->uri->segment(5);
			
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$arrdata = $this->inventory_act->detil($type,$idTrader,$tgl);
	 		$list = $this->load->view('inventory/inv', $arrdata, true);
			if($this->input->post("ajax")){
				echo  $arrdata;
			}else{
				echo $list;
			}
		}
		elseif($tipe=="konversiPOP" || $tipe=="konversi_subPOP"){
			$type="konversiPOPget";//die('sini');
			$IDBJ=$this->uri->segment(4);//echo $key1;//die();
			$KODE=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultdata=$this->inventory_act->getData($type,$IDBJ,$KODE);//print_r($resultdata);
			$data = array("judul"=>"Ubah Data Bahan Baku",
						  "act"=>"update",
						  "idBJ"=>$IDBJ,
						  "kode"=>$KODE,
						  "sess"=>$resultdata,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );	
			$this->load->view('inventory/konversi/form_konversi', $data);	
		}elseif($tipe=="konversiPOPN" ||$tipe=="konversi_subPOPN"){
			$type="konversiPOPget";
			$IDBJ=$this->uri->segment(4);//echo $key1;//die();
			$KODE=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$data=$this->inventory_act->proses_form($tipe);
				echo $data;
			}
			$resultdata=$this->inventory_act->getData($type,$IDBJ,$KODE);
			$data = array("judul"=>"Ubah Data Bahan Baku",
						  "act"=>"update new",
						  "idBJ"=>$IDBJ,
						  "kode"=>$KODE,
						  "sess"=>$resultdata,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG')				  
						  );	
			if($tipe=="konversiPOPN")$this->load->view('inventory/konversi/form_konversi', $data);
			else $this->load->view('inventory/konversi_sub/form_konversi_sub', $data);	
		}
		elseif($tipe=="konversi_detil" || $tipe=="konversi_sub_detil"){
			$idBJ=$this->uri->segment(4);
			$kodeTrader=$this->uri->segment(5);
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){//die('sini');
				if($tipe=="konversi_detil")$type="detilkonversi";
				else $type="detilkonversi_sub";//echo $type;exit;
				$data=$this->inventory_act->proses_form($type);
				echo $data;
			}
			$resultdata=$this->inventory_act->getData($tipe,$idBJ,$kodeTrader);
			$resultTrader=$this->inventory_act->getData($tipe,$idBJ,$kodeTrader);
			$arrdata = $this->inventory_act->detil($tipe,$idBJ,$kodeTrader);
			$arrdata["judul"]="Detil Bahan Baku";
	 		$list = $this->load->view('list', $arrdata, true);
			$data = array("judul"=>"Ubah Data Konversi",
						  "act"=>"update",
						  "tanggal"=>$tgl,
						  "idTrader"=>$idTrader,
						  "list"=>$list,
						  "sess"=>$resultdata,
						  "resultTrader"=>$resultTrader				  
						  );
			if($tipe=="konversiPOPN" || $tipe=="konversi_detil"){
				$this->content = $this->load->view('inventory/konversi/detil_konversi', $data, true);
			}else{ 
				$this->content = $this->load->view('inventory/konversi_sub/detil_konversi_sub', $data, true);	
			}				
			$this->index($tipe);
		}
		elseif($tipe=="konversi_list_detil" ||$tipe=="konversi_sub_list_detil" || $tipe=="detil_list_konversi"){
			if($tipe=="konversi_list_detil")$type="konversi_detil";
			elseif($tipe=="konversi_sub_list_detil")$type="konversi_sub_detil";
			elseif($tipe=="detil_list_konversi")$type="detil_konversi";
			$IDBJ=$this->uri->segment(4);
			$KODE=$this->uri->segment(5);
			
			$resultdata=$this->inventory_act->getData($tipe,$key1,$key2);
			$arrdata = $this->inventory_act->detil($type,$IDBJ,$KODE);
	 		$list = $this->load->view('inventory/inv', $arrdata, true);
			if($this->input->post("ajax")){
				echo  $arrdata;
			}else{
				echo $list;
			}
		}	
	}
	
	function daftar($tipe=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("inventory_act");
		$idTrader=$this->uri->segment(4);
		$tgl=$this->uri->segment(5);
		if($tipe=="stock_detil"){
			$arrdata = $this->inventory_act->detil($tipe,$idTrader,$tgl);
		}else{ 
			$arrdata = $this->inventory_act->daftar_inventory($tipe);
		}
		$data = $this->load->view('boxTwo', $arrdata, true);
		if($this->input->post("ajax")){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	
	function daftar_dok($tipe=""){
		$this->load->model("inventory_act");
		$key1=$this->uri->segment(4);
		$key2=$this->uri->segment(5);
		if($tipe=="stock_detil"||$tipe=="stock_new"||$tipe=="konversi_new"||$tipe=="konversi_detil" ||$tipe=="konversi_sub_new"||$tipe=="konversi_sub_detil"||$tipe=="stockPOPDtl")$arrdata = $this->inventory_act->detil($tipe,$key1,$key2);
		else $arrdata = $this->inventory_act->daftar_inventory($tipe);
		echo $this->load->view('inventory/inv', $arrdata, true);
	}
	
	function detil($type=""){
		$this->load->model("inventory_act");	
		$arrdata = $this->inventory_act->detil($type);
	 	echo $this->load->view('list', $arrdata, true);		
	}
	
	function popup($type,$jenis){
		$this->load->model('main');
		if($type=='stock' || $type=='konversi' || $type=='konversi_sub'){
			if($jenis=='add'){
				if($type=="stock" || $type=='konversi' || $type=='konversi_sub'){
					$judul="List Barang";	
				}
				$data = array('type' =>$type,'judul' =>$judul);							  
				$this->load->view('inventory/barang/list_brg',$data);
			}
		}elseif($type=='konversiBB'||$type="konversi_subBB"){
			if($jenis=='add'){	
				$judul="List Barang";
				$data = array('type' =>$type,'judul' =>$judul);						  
				$this->load->view('inventory/konversi/list_pop_knv',$data);
			}
		}
	}
	function getListInv(){
		$this->load->model("inventory_act");
		$type=$this->input->post("type");
		$index=$this->input->post('index');
		$typeCari=$this->input->post("typeCari");
		$uraiCari=$this->input->post("uraiCari");
		$banyakIndex = $this->inventory_act->gettotalListInv($typeCari,$uraiCari);
		$resultListInv= array();
		$index = intval($index);
		if ($index < 0)
			$index = 0;
		else if ($index > $banyakIndex)
			$index = $banyakIndex;
		
		$indexcari = ($index==0)?$index:($index-1);
		$indexsekarang = ($index==0)?1:$index;
		$mulai = ($indexcari*DATA_PER_PAGE);

		if ($banyakIndex > 0)
			$resultListInv = $this->inventory_act->getlistDataInv($mulai,$typeCari,$uraiCari);
		
		$mulai_nomor = ($indexcari * DATA_PER_PAGE) + 1;
		$data=array('resultListInv'=>$resultListInv,
					'banyakIndex'=>$banyakIndex,
					'indexSekarang'=>$indexsekarang,
					'mulai_nomor'=>$mulai_nomor,
					'type'=>$type);
	 	$this->load->view('inventory/barang/get_list_inv',$data);	
	}

	function getPopKnv(){
		$this->load->model("inventory_act");
		$type=$this->input->post("type");
		$index=$this->input->post('index');
		$typeCari=$this->input->post("typeCari");
		$uraiCari=$this->input->post("uraiCari");
		$banyakIndex = $this->inventory_act->gettotalListInv($typeCari,$uraiCari);
		$resultListInv= array();
		
		$index = intval($index);
		
		if ($index < 0)
			$index = 0;
		else if ($index > $banyakIndex)
			$index = $banyakIndex;
		
		$indexcari = ($index==0)?$index:($index-1);
		$indexsekarang = ($index==0)?1:$index;
		$mulai = ($indexcari*DATA_PER_PAGE);

		if ($banyakIndex > 0)
			$resultListInv = $this->inventory_act->getlistDataInv($mulai,$typeCari,$uraiCari);
		
		$mulai_nomor = ($indexcari * DATA_PER_PAGE) + 1;
		$data=array('resultListInv'=>$resultListInv,
					'banyakIndex'=>$banyakIndex,
					'indexSekarang'=>$indexsekarang,
					'mulai_nomor'=>$mulai_nomor,
					'type'=>$type);
	 	$this->load->view('inventory/konversi/get_pop_knv',$data);	
	}
	
	function cetak($tipe="",$cetak=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$nama = $this->newsession->userdata('NAMA_TRADER');
		if($this->uri->segment(4)!="excel"){
			if($this->uri->segment(4)){
				$ext = "pdf";
				$getTglStock = $this->uri->segment(4);
			}else{
				$ext = "xls";
			}
		}else{
			if($tipe=='stock_opname'){
				if($cetak != "excel"){
					if($this->uri->segment(4)){
						$ext = "pdf";
						$getTglStock = $this->uri->segment(4);
					}
				}else{
					if($this->uri->segment(5)){
						$ext = "xls";
						$getTglStock = $this->uri->segment(5);
					}
				}
			}	
		}
		ini_set("display_errors", 1);
		ini_set('memory_limit','-1');
		set_time_limit(0); 
		$this->load->library('mpdf');
		$this->mpdf=new mPDF('UTF-8','A4-L','','',8,8,35,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->SetAuthor("AIGB");
		$this->mpdf->SetCreator("AIGB");
		$this->mpdf->SetTitle("STOCKOPNAME_".$getTglStock);
		$this->mpdf->SetSubject($nama);
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		
		if($tipe=='barang'){
			$this->mpdf->SetHTMLHeader('<div align="justify" style="margin-bottom:5px;">PUSAT LOGISTIK BERIKAT '.$nama.'<br />LAPORAN DATA BARANG<div align="right">Halaman {PAGENO} dari [pagetotal]</div>','0',true);			
			$SQL= "SELECT KODE_BARANG,KODE_HS,URAIAN_BARANG,
				   f_ref('ASAL_JENIS_BARANG',JNS_BARANG) JNS_BARANG,MERK,TIPE,STOCK_AKHIR,
				   KODE_SATUAN FROM M_TRADER_BARANG 
				   WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'";
			
			//echo $SQL;die();
			$QUERYTEMP=$this->db->query($SQL);	
			$resultRow=$QUERYTEMP->result_array();
			
			$data = array("tipe"=>$tipe, 
						  "nama"=>$nama,  
						  "page"=>$page, 
						  "resultData"=>$resultRow,
						  "EXCEL"=>$cetak);
		}elseif($tipe=='stock_opname'){
			$this->mpdf->SetHTMLHeader(
			'<div align="justify" style="margin-bottom:5px;">
			PUSAT LOGISTIK BERIKAT '.$nama.'<br />
			DATA STOCKOPNAME TANGGAL '.strtoupper($this->fungsi->FormatDateIndo($getTglStock)).'
			<div align="right">Halaman {PAGENO} dari [pagetotal]</div>'
			,'0',true);	
			
			$this->load->model("inventory_act");
			$resultTrader=$this->inventory_act->getData('stock_view','','$getTglStock');
			$data=$this->inventory_act->detil('stock_view','',$getTglStock);
																				
			$data = array("tipe"=>$tipe, 
						  "nama"=>$nama,  
						  "page"=>$page, 
						  "list"=>$data, 
						  "resultTrader"=>$resultTrader,
						  "cetak"=>$cetak,
						  "xls"=>$ext,
						  "tglstok"=>$getTglStock);
		}
		
		$html=$this->load->view("laporan/print", $data,true);
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		if($cetak=="excel"){
			$this->cetakexcell('data_'.$tipe,$html);
		}else{
			$this->mpdf->Output();		
		}
		exit;
	}
	
	function cetakexcell($filename="",$contents=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		
	 	#$html .= '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/newtable.css" />';			
		$html .= '<style> td{mso-number-format:"\@";}</style>';
		$html .= $contents;
		$filename = str_replace(" ","_",$filename).".xls";
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		header("Content-Transfer-Encoding: binary"); 
		echo $html;
	}
	
	#NEW ========================================================================================================================
	#====================== FUNCTION BARANG =======================
	function barang($tipe="",$kode_barang="",$jns_barang=""){		
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		if(in_array($tipe,array("save","update","delete"))){
			$this->set_barang($tipe,$kode_barang,$jns_barang);
		}else{
			$this->load->model("inventory_act");
			$arrdata = $this->inventory_act->barang();
			$data = $this->load->view('boxTwo', $arrdata, true);
			if($this->input->post("ajax")){
				echo  $this->inventory_act->barang($tipe);
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	function set_barang($act="",$kode_barang="",$jns_barang=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		$this->load->model("inventory_act");
		#start by pass untuk edit formjs
		$generate = $this->input->post('generate');
		if($generate == "formjs"){
			$kode_barang = $this->input->post('id1');
			$jns_barang  = $this->input->post('id2');
			#echo $kode_barang.$jns_barang;die();
		}
		#end by pass untuk edit formjs
		$find = array('^','`','~');
		$replacer = array('/','"',' ');
		$kode_barang = str_replace($find, $replacer, $kode_barang);
		if((strtolower($_SERVER['REQUEST_METHOD'])=="post") && ($generate != "formjs")){
			$this->inventory_act->set_barang($act,$kode_barang,$jns_barang);
		}else{
			$this->load->model("pengeluaran_act");
			$arrdata = $this->inventory_act->getData('barang',$kode_barang,$jns_barang);
			$NAMA_TRADER = $this->newsession->userdata('NAMA_TRADER');
			$KODETRADE = substr(str_replace(array("PT","pt",".",","," "),"",trim($NAMA_TRADER)),0,3);
			$DTPARTNER = $this->pengeluaran_act->get_partner('','1');
			if($DTPARTNER){
				$PARTNER = array_merge(array($KODETRADE=>$NAMA_TRADER.' ('.$KODETRADE.')'),$DTPARTNER);
			}else{
				$PARTNER = array($KODETRADE=>$NAMA_TRADER.' ('.$KODETRADE.')');
			}
			$GUDANG = "SELECT KODE_GUDANG,CONCAT(NAMA_GUDANG,' (',KODE_GUDANG,')') URAIAN FROM M_TRADER_GUDANG 
					   WHERE KODE_TRADER = '".$KODE_TRADER."' ORDER BY KODE_GUDANG";
			$COMBOGDG = $this->main->get_combobox($GUDANG,"KODE_GUDANG", "URAIAN", FALSE);
			if($act=="save") $judul = "Tambah Data Barang";
			elseif($act=="update") $judul = "Ubah Data Barang";
			$data = array("judul"=>$judul,
						  "act"=>$act,
						  "id"=>$id,
						  "DATA"=>$arrdata,
						  "JENIS_BRG" => $this->main->get_mtabel('ASAL_JENIS_BARANG'),
						  "PARTNER" => $PARTNER,
						  "KODE_GUDANG" => $COMBOGDG);	#print_r($datax);die();
			$this->content = $this->load->view('inventory/barang/form-barang', $data, true);
			$this->index($tipe);	
		}
	}
	
	function view_barang($tipe=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("inventory_act");
		echo $this->inventory_act->barang($tipe);	
	}	
	
	function barang_detil($data="",$ajax=""){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$this->load->model("inventory_act");	
		$this->inventory_act->barang_detil($data,$ajax) ;
	}
	
	#============================== END FUNCTION BARANG ==========================================#
	
	function stockopname($tipe="",$id=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(in_array($tipe,array("save","update","delete"))){
			$this->set_stockopname($tipe,$id);
		}else{
			$this->load->model("inventory_act");
			$arrdata = $this->inventory_act->stockopname($id);
			$data = $this->load->view('boxTwo', $arrdata, true);
			if($this->input->post("ajax") || $id=="ajax"){
				echo  $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	function popstockopname($tipe="",$act="",$id=""){
		$this->load->model("inventory_act");
		if($tipe=="barang"){
			$arrdata = $this->inventory_act->getstockopname('detil',$act,$id);
			#print_r($arrdata);die();
			echo $this->load->view('inventory/stock_opname/form-stock-barang', $arrdata, true);
		}
		elseif($tipe=="load_barang"){
			echo $this->inventory_act->brgstockopname($id,$act);
		}
	}
	
	function set_stockopname($act="",$id=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("inventory_act");
		$generate = $this->input->post('generate');
		if($generate == "formjs"){
			$act = $this->input->post('action');
			$id  = $this->input->post('id1');
		}	
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post" && ($generate != "formjs")){
			$this->inventory_act->set_stockopname($act,$id);
		}else{
			$this->load->model("main","main", true);
			$arrdata = $this->inventory_act->getstockopname('header',$act,$id);
			$this->content = $this->load->view('inventory/stock_opname/form-stock', $arrdata, true);	
			$this->index($tipe);
		}
	}

	function popupcetak($tipe="",$jns=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$tipe = $this->input->post('tipe');
			$jns = $this->input->post('jns');
			$val="";
			foreach($this->input->post('checkcetak') as $data){
				$val = $val.$data."-";	
			}		
			if($val){
				$val = substr($val,0,strlen($val)-1);	
				echo "MSG#OK#OK#".site_url()."/inventory/cetakdata/".$tipe."/".$val."/".$jns;	
			}else{
				echo "MSG#ERR#Silahkan pilih salah satu#";	
			}
			die();
		}
		echo $this->load->view('inventory/cetak',array("tipe"=>$tipe,"jns"=>$jns),true);
	}
	
	function cetakdata($tipe="",$data="",$jns=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		ini_set("display_errors", 1);
		ini_set('memory_limit','-1');
		set_time_limit(0); 		
		$nama = $this->newsession->userdata('NAMA_TRADER');
		if($tipe=='barang'){	
			$in = explode("-",$data);
			$SQL= "SELECT KODE_PARTNER,KODE_BARANG,KODE_HS,URAIAN_BARANG,
				   f_ref('ASAL_JENIS_BARANG',JNS_BARANG) JNS_BARANG,MERK,TIPE,STOCK_AKHIR,
				   KODE_SATUAN,KODE_SATUAN_TERKECIL,JML_SATUAN_TERKECIL,UKURAN FROM M_TRADER_BARANG 
				   WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'
				   AND JNS_BARANG IN ('".implode("','",$in)."') ORDER BY KODE_PARTNER";
		}
		$QUERYTEMP=$this->db->query($SQL);	
		$resultRow=$QUERYTEMP->result_array();
		if($jns == "excel"){				
			$data = array("tipe"=>$tipe, "nama"=>$nama, "resultData"=>$resultRow, "xls"=>'xls');
			$html=$this->load->view("laporan/print", $data,true);
			$this->cetakexcell('data_'.$tipe,$html);
			exit;
		}else{
			$this->load->library('mpdf');
			$this->mpdf=new mPDF('UTF-8','A4-L','','',8,8,35,25,10,13); 
			$this->mpdf->useOnlyCoreFonts = true;
			$this->mpdf->SetProtection(array('print'));
			$this->mpdf->SetAuthor("PLB");
			$this->mpdf->SetCreator("PLB");
			$this->mpdf->SetTitle($tittle);
			$this->mpdf->SetSubject($nama);
			$this->mpdf->list_indent_first_level = 0; 
			$this->mpdf->SetDisplayMode('fullpage');
			$page=$this->mpdf->AliasNbPages('[pagetotal]');
			$this->mpdf->SetHTMLHeader('<div align="justify" style="margin-bottom:5px;">PUSAT LOGISTIK BERIKAT '.$nama.'<br />LAPORAN DATA BARANG<div align="right">Halaman {PAGENO} dari [pagetotal]</div>','0',true);	
			
			$data = array("tipe"=>$tipe, "nama"=>$nama,  "page"=>$page, "resultData"=>$resultRow);
			$html=$this->load->view("laporan/print", $data,true);
			$stylesheet = file_get_contents('assets/css/newtable.css');
			$this->mpdf->WriteHTML($stylesheet,1);
			$this->mpdf->WriteHTML($html,2);
			$this->mpdf->Output();					
			exit;
		}
	}	

	function inoutbrg($tipe=""){
		$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("inventory_act");
		$arrdata = $this->inventory_act->tab_inoutbrg();
		$data = $this->load->view('inventory/inout', $arrdata, true);
		if($this->input->post("ajax")){
			echo  $this->inventory_act->list_inoutbrg($tipe);
		}else{
			$this->content = $data;
			$this->index();
		}
	}	
	
	function cetak_inout($tglawal="",$tglakhir="",$kodebarang="",$jnsbarang="",$tipe=""){
		$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$func = &get_instance();
		$func->load->model("main","main", true);
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		$JENISBARANG = $func->main->get_uraian("SELECT URAIAN FROM m_tabel WHERE jenis = 'ASAL_JENIS_BARANG' AND KODE = '".$jnsbarang."'","URAIAN");
		
		$this->load->library('mpdf');
		$this->mpdf=new mPDF('UTF-8','A4-L','','',8,8,42,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetTitle('PLB_Penelusuran_'.$tglawal.'-'.$tglakhir.'.pdf');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML('<style>@page{odd-header-name: html_myHeader1;even-header-name: html_myHeader2; 
										odd-footer-name: html_myFooter1;
										even-footer-name: html_myFooter2;}</style>
										<htmlpageheader name="myHeader1" style="display:none">
										<div style="text-align:left;font-size:9pt;">
										DATA PENELUSURAN KELUAR MASUK BARANG <br />
										'.$this->newsession->userdata('NAMA_TRADER').'<br /><br />
										PERIODE '.strtoupper($this->fungsi->FormatDateIndo($tglawal)).' S.D '.strtoupper($this->fungsi->FormatDateIndo($tglakhir)).' <br />
										KODE BARANG   : '.$kodebarang.'<br />
										JENIS BARANG  : '.$jnsbarang.' - '.$JENISBARANG.'
										</div>
										</htmlpageheader>
										<htmlpageheader name="myHeader2" style="display:none">
										<div style="text-align:center;font-size:11pt;">
										LEMBAR KONVERSI PEMAKAIAN BAHAN
										</div>
										</htmlpageheader>							
										<htmlpagefooter name="myFooter1" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>									
										</tr></table>
										</htmlpagefooter>
										<htmlpagefooter name="myFooter2" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>		
										</tr></table>
										</htmlpagefooter>');
		
		$SQLS = "SELECT JUMLAH, DATE_FORMAT(MIN(TANGGAL_STOCK),'%d-%m-%Y') TANGGAL_STOCK 
				 FROM M_TRADER_STOCKOPNAME 
				 WHERE KODE_TRADER='".$KODE_TRADER."' AND KODE_BARANG='".$kodebarang."' AND JNS_BARANG='".$jnsbarang."' 
				  GROUP BY KODE_BARANG, KODE_TRADER LIMIT 1";
		$RS = $this->db->query($SQLS);
		$SALDO_AWAL = 0;
		$TANGGAL_STOCK = 0;
		/*if($RS->num_rows()>0){
			$DT = $RS->row();
			$SALDO_AWAL = $DT->JUMLAH;
			$TANGGAL_STOCK = $DT->TANGGAL_STOCK;
		}*/
		$tglAkhirInOut=date('Y-m-d',strtotime($tglawal."-1 day"));
		$sqlGetSaldoStock ="SELECT REPLACE(FORMAT(JUMLAH,2),',','') AS 'JUMLAH_STOCK', TANGGAL_STOCK
							FROM m_trader_stockopname
							WHERE KODE_TRADER ='".$KODE_TRADER."' 
							AND TANGGAL_STOCK <= '".$tglawal."'
							AND KODE_BARANG ='".$kodebarang."'
							AND JNS_BARANG = '".$jnsbarang."'
							ORDER BY TANGGAL_STOCK DESC LIMIT 1";
		
		$RSSTOCKOPNAME=$this->db->query($sqlGetSaldoStock)->row(); 
		$GETSALDOAWALSTOCK=$RSSTOCKOPNAME->JUMLAH_STOCK;
		
		$TGLSTOCK = "";
		if($RSSTOCKOPNAME->TANGGAL_STOCK!=""){ 
			$TGLSTOCK = " BETWEEN '".date('Y-m-d',strtotime($RSSTOCKOPNAME->TANGGAL_STOCK))."' AND '".$tglAkhirInOut."'";
		}else{
			$TGLSTOCK = " <= '".$tglAkhirInOut."'";
		}
					 
		$sqlGetSaldoIn = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_IN', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_IN'
						  FROM m_trader_barang_inout
						  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
						  AND KODE_TRADER = '".$KODE_TRADER."'
						  AND KODE_BARANG ='".$kodebarang."'
						  AND JNS_BARANG = '".$jnsbarang."'
						  AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')
						  GROUP BY KODE_BARANG, JNS_BARANG";
						  
		$sqlGetSaldoOut ="SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_OUT', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_OUT'
						  FROM m_trader_barang_inout
						  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
						  AND KODE_TRADER = '".$KODE_TRADER."'
						  AND KODE_BARANG ='".$kodebarang."'
						  AND JNS_BARANG = '".$jnsbarang."'
						  AND TIPE IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')
						  GROUP BY KODE_BARANG, JNS_BARANG";
		
		$RSGETSALDOAWALIN=$this->db->query($sqlGetSaldoIn)->row();
		$GETSALDOAWALIN=$RSGETSALDOAWALIN->AWAL_SALDO_IN;
		$RSGETSALDOAWALOUT=$this->db->query($sqlGetSaldoOut)->row(); 
		$GETSALDOAWALOUT=$RSGETSALDOAWALOUT->AWAL_SALDO_OUT;
		
		if($GETSALDOAWALSTOCK==""){ 
			$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT; 
			//if($SALDOAWLGET<0) $SALDOAWLGET = "0";
		}else{ 
			if($RSSTOCKOPNAME->TANGGAL_STOCK==$tglAkhirInOut){
				$SALDOAWLGET = $GETSALDOAWALSTOCK;
			}else{
				if($RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALIN->TGL_IN||$RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALOUT->TGL_OUT){
					$SALDOAWLGET = $GETSALDOAWALSTOCK;
				}else{
					$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT;
					//if($SALDOAWLGET<0) $SALDOAWLGET = "0";
				}	
			}
		}	
		$SALDO_AWAL = $SALDOAWLGET;
		$TANGGAL_STOCK = $TANGGAL_AWAL;
		#============================
		$SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI, KODE_DOKUMEN,TANGGAL_DOKUMEN, NOMOR_AJU,TIPE, 
				CASE TIPE
				WHEN 'GATE-IN' THEN CONCAT('REALISASI PEMASUKAN (GATE-IN)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
				WHEN 'GATE-OUT' THEN CONCAT('REALISASI PENGELUARAN (GATE-OUT)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
				WHEN 'PROCESS_IN' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI MASUK (-)',CONCAT('PRODUKSI MASUK (-)',' ',NOMOR_PROSES))
				WHEN 'PROCESS_OUT' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI KELUAR (+)',CONCAT('PRODUKSI KELUAR (+)',' ',NOMOR_PROSES))
				WHEN 'SCRAP' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI SISA (+)',CONCAT('PRODUKSI SISA (+)',' ',NOMOR_PROSES)) 
				WHEN 'RUSAK' THEN 'PENGERUSAKAN'
				WHEN 'MUSNAH' THEN 'PEMUSNAHAN'
				WHEN 'MOVE-IN' THEN CONCAT('PEMINDAHAN BARANG MASUK',' (NO TRANSAKSI : ',NOMOR_PROSES,')')
				WHEN 'MOVE-OUT' THEN CONCAT('PEMINDAHAN BARANG KELUAR',' (NO TRANSAKSI : ',NOMOR_PROSES,')') END TIPE_URAIAN,
				REPLACE(FORMAT(JUMLAH,2),',','') AS JUMLAH, DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') TANGGAL, PROCESS_WITH, 
				DATE_FORMAT(CREATED_TIME,'%d-%m-%Y %H:%i:%s') CREATED_TIME 
				FROM M_TRADER_BARANG_INOUT 
				WHERE KODE_BARANG='".$kodebarang."' AND KODE_TRADER='".$KODE_TRADER."'
				AND JNS_BARANG = '".$jnsbarang."'
				AND DATE_FORMAT(TANGGAL, '%Y-%m-%d') BETWEEN '".$tglawal."' AND '".$tglakhir."'
				ORDER BY DATE_FORMAT(TANGGAL, '%Y-%m-%d') ASC, DATE_FORMAT(TANGGAL, '%H:%i-%s') ASC";
				
	 	$hasil = $func->main->get_result($SQL);
	 	
		$html .= '<span class="btn"></span>';	
		$html .= '<table class="tabelajax">';
		$html .= '<thead>';
		if($tipe=="excel"){
			$html .= '<tr><th colspan="7">DATA PENELUSURAN KELUAR MASUK BARANG</th></tr>';
			$html .= '<tr><th colspan="7">'.$this->newsession->userdata('NAMA_TRADER').'</th></tr>';
			$html .= '<tr><th colspan="7">PERIODE : '.strtoupper($this->fungsi->FormatDateIndo($tglawal)).' S.D '.strtoupper($this->fungsi->FormatDateIndo($tglakhir)).'</th></tr>';
			$html .= '<tr><th colspan="7">KODE BARANG : '.$kodebarang.'</th></tr>';
			$html .= '<tr><th colspan="7">JENIS BARANG  : '.$jnsbarang.' - '.$JENISBARANG.'</th></tr>';
			$html .= '<tr><th colspan="7">&nbsp;</th></tr>';
		}
		$html .= '<tr>';
		$html .= '<th width="1px">No</th>';
		$html .= '<th>TANGGAL PROSES</th>';
		$html .= '<th>TANGGAL REALISASI</th>';
		$html .= '<th>KETERANGAN</th>';
		$html .= '<th>PEMASUKAN</th>';
		$html .= '<th>PENGELUARAN</th>';
		$html .= '<th>SALDO</th>';
		$html .= '</tr>';	
		$html .= '</thead>';
		$html .= '<tbody>';	
		$html .= '<tr><td>1</td>';
		$html .= '<td colspan="2">&nbsp;</td>';			
		$html .= '<td><b><i>SALDO AWAL : '.$this->fungsi->dateformat($TANGGAL_STOCK).'</i></b></td>';			
		$html .= '<td>&nbsp;</td>';				
		$html .= '<td>&nbsp;</td>';			
		$html .= '<td align="right">'.number_format($SALDO_AWAL,3).'</td>';			
		$html .= '</tr>';
			
		if($hasil){
			$no=2;
			$SALDO = 0;
			$TOTAL_MASUK = 0;
			$TOTAL_KELUAR = 0;
			$TOTAL_SALDO = 0;
			foreach($SQL->result_array() as $row){	
				$html .= '<tr>';
				$html .= '<td>'.$no.'</td>';
				$html .= '<td>'.$row['CREATED_TIME'].'</td>';
				$html .= '<td>'.$row['TANGGAL'].'</td>';
				$html .= '<td>'.$row['TIPE_URAIAN'].'</td>';
				if($row['TIPE']=="GATE-IN"||$row['TIPE']=="PROCESS_OUT"||$row['TIPE']=="SCRAP"||$row['TIPE']=="MOVE-IN"){
					$html .= '<td align="right">'.number_format($row['JUMLAH'],3).'</td>';
					$html .= '<td>&nbsp;</td>';
					if($no==2){
						$SALDO = (float)$SALDO_AWAL+(float)$row['JUMLAH'];
					}else{
						$SALDO = (float)$SALDO+(float)$row['JUMLAH'];	
					}
					$TOTAL_MASUK = (float)$TOTAL_MASUK+(float)$row['JUMLAH'];
				}else{
					$html .= '<td>&nbsp;</td>';
					$html .= '<td align="right">'.number_format($row['JUMLAH'],3).'</td>';
					if($no==2){
						$SALDO = (float)$SALDO_AWAL-(float)$row['JUMLAH'];
					}else{
						$SALDO = (float)$SALDO-(float)$row['JUMLAH'];	
					}
					$TOTAL_KELUAR = (float)$TOTAL_KELUAR+(float)$row['JUMLAH'];
				}
				$TOTAL_SALDO = (float)$TOTAL_SALDO+(float)$SALDO;
				$html .= '<td align="right">'.number_format($SALDO,3).'</td>';
				$html .= '</tr>';	
				$no++;
			}
			$html .= '<tr>';		
			$html .= '<td colspan="4" align="right"><strong>TOTAL :</strong></td>';		
			$html .= '<td align="right"><strong>'.number_format($TOTAL_MASUK,3).'</strong></td>';		
			$html .= '<td align="right"><strong>'.number_format($TOTAL_KELUAR,3).'</strong></td>';		
			$html .= '<td align="right"><strong>'.number_format($SALDO,3).'</strong></td>';
			$html .= '<tr>';
		}else{
			$html .= '<tr>';
			$html .= '<td colspan="7">Data tidak ditemukan</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';	
		$html .= '</table>';
		
		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		if($tipe=="excel"){
			$tittle = "DATA PENELUSURAN KELUAR MASUK BARANG";
			$per = "(".$this->fungsi->dateformat($tglawal).'s.d'.$this->fungsi->dateformat($tglakhir).")";
			$this->cetakexcell($tittle.$per,$html);
		}else{
			$this->mpdf->Output('PLB_Penelusuran_'.$tglawal.'/'.$tglakhir.'.pdf','D');
		}
		exit;
	}

	function popupcetak_inout($cetak="",$tipe=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		if($cetak=="cetak"){
			if(in_array($tipe,array('GATE-IN','GATE-OUT'))){				   
				$SQL = "SELECT KODE_BARANG, f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JNS_BARANG', 
						KODE_DOKUMEN, DATE_FORMAT(TANGGAL_DOKUMEN,'%d %M %Y') 'TANGGAL_DOKUMEN', NOMOR_AJU, 
						FORMAT(JUMLAH,2) JUMLAH, DATE_FORMAT(TANGGAL,'%d %M %Y') 'TANGGAL_REALISASI' 
						FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'
						AND TIPE='".$tipe."' ORDER BY TANGGAL ASC";
			}else{
				$SQL = "SELECT KODE_BARANG, f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JNS_BARANG', 
						FORMAT(JUMLAH,2) JUMLAH, DATE_FORMAT(TANGGAL,'%d %M %Y') 'TANGGAL_REALISASI' 
						FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'
						AND TIPE='".$tipe."'  ORDER BY TANGGAL ASC";
			}		
			$rs = $this->db->query($SQL);	
			$resultrow = $rs->result_array();	
			$data = array("tipe"=>$tipe, "resultData"=>$resultrow);
			$html=$this->load->view("inventory/inoutprint", $data,true);
			$this->cetakexcell($tipe.'_'.$this->newsession->userdata('NAMA_TRADER'),$html);
			exit;							
		}else{
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$REPORT = $this->input->post('REPORT');
				if($REPORT){
					echo "MSG#OK#OK#".site_url()."/inventory/popupcetak_inout/cetak/".$REPORT;	
				}else{
					echo "MSG#ERR#Silahkan pilih salah satu";	
				}
				die();
			}
			echo $this->load->view('inventory/inoutcetak','',true);
		}
	}

	function inout($tipe=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$this->load->model('inventory_act');
			echo $this->inventory_act->inout();
		}else{
			$data = $this->load->view('inventory/inout_new', '', true);		
			$this->content = $data;
			$this->index();		
		}
	}

	function delinout(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("inventory_act");
		$this->inventory_act->delinout();
	}
	
	function cekStockMinimum($tipe=""){	
		$this->load->model('inventory_act');
		echo $this->inventory_act->cekStockMinimum();
	}
	
	function updatestock(){
		#$saldo = $this->input->post('saldo');	
		$kode_barang = $this->input->post('kode_barang');	
		$jns_barang = $this->input->post('jns_barang');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$this->load->model("inventory_act");
		echo $this->inventory_act->updatestock($kode_barang,$jns_barang,$tgl_awal,$tgl_akhir);
	}
	
	public function outOfDate() {
		$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("inventory_act");
        $arrdata = $this->inventory_act->detil_tab();
        $data = $this->load->view('inventory/list_barang_outofdate', $arrdata, true);
        $this->content = $data;
        $this->index();
    }
    
    public function list_kadaluarsa($tipe){
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("inventory_act");
        echo $this->inventory_act->outOfDate($tipe);
    }
	
	function rinci(){
		$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("inventory_act");
        $mdldata = $this->inventory_act->rinci();			
		$data = $this->load->view('boxTwo', $mdldata, true);
		if($this->input->post("ajax")){
			echo $mdldata;
		}else{
			$this->content = $data;
			$this->index();
		}		
	}
	
	function updatesaldo(){
		$KODE_TRADER =$this->newsession->userdata('KODE_TRADER');
		$logid = $this->input->post('logid');
		$saldo = $this->input->post('saldo');
		$this->load->model("main");
		if($saldo==0) $flag = '1';
		else $flag = '(NULL)';
		$this->main->activity_log('UPDATE SALDO PEMASUKAN','LOGID='.$logid);
		$exec = $this->db->query("UPDATE T_LOGBOOK_PEMASUKAN SET SALDO = ".(float)$saldo.", FLAG_TUTUP = ".$flag." WHERE LOGID = ".$logid." AND KODE_TRADER = '".$KODE_TRADER."'");
		if($exec){			
			echo "Proses Berhasil!";
		}else{
			echo "Proses Gagal!";	
		}
	}
	
	function pindah_gudang($kode_barang, $jns_barang){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"] = 1;
		$this->addHeader["autocomplete"] = 1;
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$this->load->model('inventory_act');
		$model = $this->inventory_act->pindah_gudang($kode_barang, $jns_barang);
		if($_SERVER['REQUEST_METHOD']=="POST"){ 
			echo $model;
		}else{ 
			$this->content = $this->load->view('inventory/barang/pindah_gudang',$model,true);
			$this->index();
		}
	}
	
	function get_jumlah(){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }		
		$this->load->model('inventory_act');
		$this->inventory_act->get_jumlah();	
	}
	
	function getGudang(){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$this->load->model('inventory_act');
		$model = $this->inventory_act->getGudang();
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){ 
			echo $model;
		}
	}
	
	public function getGudangBarang(){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$this->load->model('inventory_act');
		$model = $this->inventory_act->getGudangBarang();
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){ 
			echo $model;
		}
	}
	
	public function getRak($tipe=""){
		$this->load->model('inventory_act');
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$kode_gudang = $this->input->post('kode_gudang');
			$id = $this->input->post('tdId');
			$target = $this->input->post('trget');
			$kdbarang = $this->input->post('kdbarang');
			$jnsbarang = $this->input->post('jnsBrg');
			echo $this->inventory_act->getRak($kode_gudang,$id,$tipe,$target,$kdbarang,$jnsbarang);
			
		}
	}
	
	public function getSubrak($tipe=""){
		$this->load->model('inventory_act');
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$kode_gudang = $this->input->post('kode_gudang');
			$kondisi = $this->input->post('kondisi');
			$kode_rak = $this->input->post('kode_rak');
			$id = $this->input->post('tdId');
			$target = $this->input->post('trget');
			$kdbarang = $this->input->post('kdbarang');
			$jnsbarang = $this->input->post('jnsBrg');
			echo $this->inventory_act->getSubrak($kode_rak,$kode_gudang,$id,$tipe,$target,$kdbarang,$jnsbarang,$kondisi);
			
		}
	}

	public function getKondisi($tipe=""){
		$this->load->model('inventory_act');
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$kode_gudang = $this->input->post('kode_gudang');
			$id = $this->input->post('tdId');
			$target = $this->input->post('trget');
			$kdbarang = $this->input->post('kdbarang');
			$jnsbarang = $this->input->post('jnsBrg');
			echo $this->inventory_act->getKondisi($kode_gudang,$id,$tipe,$target,$kdbarang,$jnsbarang);
			
		}
	}
	
	function status(){
		if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }		
		$this->load->model('inventory_act');
		echo $this->inventory_act->status();	
	}
}
	
?>