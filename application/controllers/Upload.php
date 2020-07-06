<?php
//error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('memory_limit','-1');
set_time_limit(0); 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends CI_Controller{
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
	
	function adddate($vardate,$added){
		if($vardate!=""){
			$data = explode("-", $vardate);
			$date = new DateTime();
			$date->setDate($data[2], $data[1], $data[0]);
			$date->modify("".$added."");
			$day= $date->format("Y-m-d");
			return $day;
		}
	}
	
	function getColoumn($tableName,$object,$r){ 
		$i = 1;
		foreach($object as $k => $v){ 
			$sColumns[(odbc_field_name($r,$i))]=true; 		
			$i++; 
		}    
		return $sColumns; 
	} 	

	function changeDateFormat($date){
       	if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $date)){ //Check if $date is valid date
           	preg_match('/(?P<date>\w+)\/(?P<month>\w+)\/(?P<year>\w+)/', $date, $match);
           	$date = $match['month'] . "/" . $match['date'] . "/" . $match['year'];
       	}
      		return date('Y-m-d', strtotime($date));
   	}

	function dateValidate($str) {
		if (strlen($str) == 0) {
			return TRUE;
		}
		return preg_match('/^(\d{1,2})\/(\d{1,2})\/((?:\d{2}){1,2})$/', $str, $match) && checkdate($match[2], $match[1], $match[3]) && $match[2] <= 2030;
	}

	function replace_charackter($str=""){
		#replace semua karakter khusus kecuali - dan _
		if($str){
			//$str = preg_replace('/[^A-Za-z0-9\-_,]/', '', $str);	
			//$str = str_replace(' ', '', $str);	
		}
		return $str;
	}

	function cekTipe($data){
		if($data!=""){
			switch(strtolower($data)){
				case "masuk"; $tp = "PROCESS_IN";break; 	
				case "keluar"; $tp = "PROCESS_OUT";break; 	
				case "sisa"; $tp = "SCRAP";break; 
				default: $tp = true;break;					
			}
		}
		return $tp;
	}
	
	function cekDatasama($data){
		$sama = false;
		$array_temp = array();
		foreach($data as $nilai){
			if($nilai!=""){
				if(in_array($nilai,$array_temp)){
					$sama = true;
					break;
				}
				$array_temp[] = $nilai;
			}
		}
		if($sama){
			return true;
		}	
	}
	
	function cekDataKosong($data){
		$lastproses = substr($this->produksi_act->get_lastProses(),9,6);		
		$no=1;
		foreach($data as $nilai){
			if($nilai==""){
				$vallast = $lastproses+$no;
				$no++;	
			}
		}
		return $vallast;
	}	
	
	
	
///////////////////////////	START STOCKOPNAME ///////////////////////////////////////////////////////////////////////////////////////////////	
	
	function upload_stockopname(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_stockopname');
	}
	
	public function konfirmasi_stockopname()
	{
		$this->load->model('upload_act');
		$this->load->library('upload');
		$idHeader = $this->input->post('id');
		if ($idHeader == "")
			redirect('upload/upload_data','refresh');
		
		$uploadPath = "file/upload";
		$namaFileGoods = md5($idHeader.'goods').".xls";
		$config['upload_path'] = './'.$uploadPath;
		$config['allowed_types'] = 'xls';
		$config['max_size'] = '3000'; //300 KB
		$config['encrypt_name'] = TRUE;
		$config['file_name'] = $namaFileGoods;
		$config['overwrite'] = TRUE;
		$this->upload->initialize($config);
		
		if ($this->upload->do_upload('fileUpload'))
		{
			$this->load->library('excel_reader');		
			$this->excel_reader->setOutputEncoding('CP1251');			
			$file = $uploadPath."/".$namaFileGoods;
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);
			$dataExcel = $this->excel_reader->sheets[0];
			$data = array();

			$totalRowTemp = 10000;
			$rowsAwal = 2;
			$colsTransaksi = 6;
			$colsAwal = 1;
			$colsAkhir = 10;
			$rowsAkhir = 2;
			$arrayDataSend = array();
			$banyakError = 0;
			$banyakAda = 0;
			
			$DateXls=$dataExcel['cells'][2][5];
			$DataDateXls = str_replace("/","-",$DateXls);
			$DataDateXls = $this->adddate($DataDateXls,'-1 day');
			$DateXls = explode("-",$DataDateXls);
			$tglstock=$DataDateXls = $DateXls[0]."-".($DateXls[1])."-".$DateXls[2];
			
			$arrayStokBarang = $this->upload_act->getDataKodeUpload('stock',$tglstock);
			$arrayKodeSatuan = $this->upload_act->getDataKodeUpload('satuan');
			$arrayKodePartner = $this->upload_act->getDataKodeUpload('partner');
			$arrayKodeBarang = $this->upload_act->getDataKodeUpload('barang');
			$ARRAYTIPEDOK = array('BC23','BC27');
			
			for ($i = $rowsAwal; $i<=$totalRowTemp; $i++)
			{
				$tempTransaksi = $dataExcel['cells'][$i][$colsTransaksi];
				if ((trim($tempTransaksi) == "")&&($i!=2))
				{
					$rowsAkhir = ($i-1);
					break;
				}
			}
			
			for ($i = $rowsAwal; $i<=$rowsAkhir; $i++)
			{
				for ($c = $colsAwal; $c<=$colsAkhir; $c++)
				{
					$tempData = strtoupper($dataExcel['cells'][$i][$c]);
					$class = "";
					$title = "";
					$align = "left";
					if ($c == 1)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							if (in_array($tempData,$arrayStokBarang))
							{
								$class = "alertClass";
								$title = "Tanggal dan Barang Stock Opname tersebut sudah ada dalam database";
								$banyakAda++;
							}
							if (!in_array(str_replace(" ","",trim($this->replace_charackter($tempData))),$arrayKodeBarang))
							{
								$class = "errorClass";
								$title = "Kode Barang tidak dikenali";
								$banyakError++;
							}
						}
					}
					else if ($c == 4)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array($tempData,$arrayKodeSatuan))
							{
								$class = "errorClass";
								$title = "Satuan tidak dikenali";
								$banyakError++;
							}
						}
					}
					if ($c == 6)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array(str_replace(".","",str_replace(" ","",trim($tempData))),$ARRAYTIPEDOK))
							{
								$class = "errorClass";
								$title = "Kode Dok Masuk Tidak dikenali";
								$banyakError++;
							}
						}
					}
					else if (($c==5) && ($tempData !="") &&($i==2))
					{
						$tempDataDate = str_replace("/","-",$tempData);
						$tempDataDate = $this->adddate($tempDataDate,'-1 day');
						$Date = explode("-",$tempDataDate);
						$tempDataDate = $Date[1]."-".($Date[2].$a)."-".$Date[0];
						$tempData = $tempDataDate;
					}
					$arrayData[$i][$c] = array('align'=>$align,'isi'=>$tempData,'class'=>$class,'title'=>$title);
				}
			}
			
			$arrayAlign = array('center','center','center','center','','center','center','center','center','center','center','');
			$data['rowsAwal'] = $rowsAwal;
			$data['rowsAkhir'] = $rowsAkhir;
			$data['banyakData'] = ($rowsAkhir - $rowsAwal) + 1;
			$data['colsAkhir'] = $colsAkhir;
			$data['colsAwal'] = $colsAwal;
			$data['arrayData'] = $arrayData;
			$data['arrayAlign'] = $arrayAlign;
			$data['banyakError'] = $banyakError;
			$data['banyakAda'] = $banyakAda;
			$data['id'] = $idHeader;
			$hasil = $this->load->view('upload/form_upload_stockopname_preview',$data);
			return $hasil;
		}
		else
		{
			echo $this->upload->display_errors();
		}

	}
	
	function insert_upload_stockopname()
	{
		$this->load->model('upload_act');
		$this->load->library('upload');
		
		$rowsAwal = $this->input->post('rowsAwal');
		$rowsAkhir = $this->input->post('rowsAkhir');
		$colsAwal = $this->input->post('colsAwal');
		$colsAkhir = $this->input->post('colsAkhir');
		$banyakData = $this->input->post('banyakData');
		$idHeader = $this->input->post('id');
		
		if ($idHeader == "")
			redirect('upload/upload_data','refresh');
		
		$uploadPath = "file/upload";
		$namaFile = md5($idHeader.'goods').".xls";
		$this->load->library('excel_reader');
		$this->excel_reader->setOutputEncoding('CP1251');			
		$file = $uploadPath."/".$namaFile;
		$this->excel_reader->read($file);
		error_reporting(E_ERROR);
		$dataExcel = $this->excel_reader->sheets[0];
		$data = array();
		$nomorIndex = 0;
				
		$arrayStock = array('KODE_TRADER','KODE_BARANG','JNS_BARANG','TANGGAL_STOCK','JUMLAH','KETERANGAN','ID');
		$arrayStockDetil = array('IDHDR','JENIS_DOK_MASUK','NO_DOK_MASUK','TGL_DOK_MASUK','JUMLAH','KETERANGAN');

		$indexStock= 0;
		$indexStockDetil= 0;		
		$array_data_stock = array();
		$array_data_stock_detil = array();
		$kodeTrader = $this->newsession->userdata("KODE_TRADER");		
		$id = $this->upload_act->getDataKodeUpload('id');		
		$id = $id[0]+1;
		

		$arraytemp = array();
		for ($i = 3; $i<=$rowsAkhir; $i++)
		{
			if($i==3){
				$idhdr = $id;
			}
			$dateStock = $dataExcel['cells'][2][5];
			$repdateStock = str_replace("/","-",$dateStock);
			$repdateStock = $this->adddate($repdateStock,'-1 day');
			$Date = explode("-",$repdateStock);
			$dateStock = $Date[0]."-".$Date[1]."-".$Date[2];
			
			$dateStockDetil = $dataExcel['cells'][$i][8];
			$repdateStockDetil = str_replace("/","-",$dateStockDetil);
			$repdateStockDetil = $this->adddate($repdateStockDetil,'');
			$DateDetil = explode("-",$repdateStockDetil);
			$dateStockDetil = $DateDetil[0]."-".$DateDetil[1]."-".$DateDetil[2];
			
			$awal = strtoupper(trim($dataExcel['cells'][$i][$colsAwal]));
			//$akhir = strtoupper(trim($dataExcel['cells'][$i+1][$colsAwal]));
			//$sebelum = strtoupper(trim($dataExcel['cells'][$i-1][$colsAwal]));
			
			if(strtoupper(trim($awal)) == "") $id = $id-1;
			
			for ($c = $colsAwal+1; $c<=$colsAkhir; $c++)
			{
				$tempData = strtoupper(trim($dataExcel['cells'][$i][$c]));
				
				if (strtoupper(trim($dataExcel['cells'][$i][$colsAwal])) != "")
				{
						$indexStockJml = $indexStock-1;		
						$array_data_stock[$indexStock][$arrayStock[0]] = $idHeader;
						$array_data_stock[$indexStock][$arrayStock[1]]= strtoupper(trim($dataExcel['cells'][$i][1]));
						$array_data_stock[$indexStock][$arrayStock[2]]= strtoupper(trim($dataExcel['cells'][$i][2]));
						$array_data_stock[$indexStock][$arrayStock[3]] = $dateStock;
						$array_data_stock[$indexStock][$arrayStock[4]]= $dataExcel['cells'][$i][5];
						$array_data_stock[$indexStock][$arrayStock[5]]= strtoupper(trim($dataExcel['cells'][$i][10]));
						$array_data_stock[$indexStock][$arrayStock[6]]= $id;
						
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[0]] = $id;
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[1]]= str_replace(" ","",str_replace(".","",strtoupper(trim($dataExcel['cells'][$i][6]))));
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[2]]= strtoupper(trim($dataExcel['cells'][$i][7]));
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[3]] = $dateStockDetil;
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[4]]= strtoupper(trim($dataExcel['cells'][$i][9]));
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[5]]= strtoupper(trim($dataExcel['cells'][$i][10]));

				}else{
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[0]] = $id;
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[1]]= str_replace(" ","",str_replace(".","",strtoupper(trim($dataExcel['cells'][$i][6]))));
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[2]]= strtoupper(trim($dataExcel['cells'][$i][7]));
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[3]] = $dateStockDetil;
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[4]]= strtoupper(trim($dataExcel['cells'][$i][9]));
						$array_data_stock_detil[$indexStockDetil][$arrayStockDetil[5]]= strtoupper(trim($dataExcel['cells'][$i][10]));

				}
								
				$indexKolom++;
			}
			/*
			if(in_array($array_data_stock[$indexStock]['KODE_BARANG'].'_'.$array_data_stock[$indexStock]['JNS_BARANG'].'_'.$array_data_stock[$indexStock]['TANGGAL_STOCK'],$arraytemp)){
				if($i==4){
					 $idhdr =  $idhdr-1;
				}

				$array_data_stock_detil[$indexStockDetil]['IDHDR'] = $idhdr;
			}else{*/

				$idhdr++;	
			//}

			array_push($arraytemp,$array_data_stock[$indexStock]['KODE_BARANG'].'_'.$array_data_stock[$indexStock]['JNS_BARANG'].'_'.$array_data_stock[$indexStock]['TANGGAL_STOCK']);
			
			//print_r($arraytemp);die();
			$id++;
			$nomorIndex++;
			$indexStock++;
			$indexStockDetil++;
		}
		//print_r($array_data_stock);
		//print_r($array_data_stock_detil);die();
		$exec = $this->getInsertStockOpname($array_data_stock,$array_data_stock_detil);		
		
		unlink($file);
		if($exec =="sukses"){
			$hasil = "Data Berhasil disimpan";
		}else{
			$hasil = "Data Gagal disimpan";
		}
		echo json_encode($hasil);
	}
	
	function getInsertStockOpname($array_data_stock,$array_data_stock_detil){
		$this->load->model("main");
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$arrayParameter = $this->upload_act->getDataParameter('stock');
		$arrayStockBrg = array();
		$STOCKB=0;
		
		foreach($array_data_stock as $data){
						
			/*if ((in_array($data['KODE_BARANG'],$arrayParameter['kode'])) && (in_array($data['TANGGAL_STOCK'],$arrayParameter['tgl'])))
			{		
				$ket = "sukses"; 
			}else{*/										
				$STOCKB = $this->upload_act->getDataKodeUpload('stockAll',$data['TANGGAL_STOCK'],$data['KODE_BARANG'],$data['JNS_BARANG'],'');					
				if(empty($STOCKB)){	
					$data['KODE_BARANG'] = $this->replace_charackter($data['KODE_BARANG']);
					$exec = $this->db->insert("m_trader_stockopname",$data);	
					$this->main->activity_log('ADD STOCKOPNAME','TANGGAL_STOCK='.$data['TANGGAL_STOCK'].', KODE_BARANG='.$data['KODE_BARANG'].', JNS_BARANG='.$data['JNS_BARANG'],'UPLOAD');	
				}else{
					$VAF["JUMLAH"] = $data["JUMLAH"]+$STOCKB[0];
					$this->db->where(array('KODE_BARANG'=>$data['KODE_BARANG'],'KODE_TRADER'=>$kode_trader,'JNS_BARANG'=>$data['JNS_BARANG'],'TANGGAL_STOCK'=>$data['TANGGAL_STOCK']));
					$exec = $this->db->update('m_trader_stockopname', $VAF);
					$this->main->activity_log('EDIT STOCKOPNAME','TANGGAL_STOCK='.$data['TANGGAL_STOCK'].', KODE_BARANG='.$data['KODE_BARANG'].', JNS_BARANG='.$data['JNS_BARANG'],'UPLOAD');
				}				
			}
		//}
		
		foreach($array_data_stock_detil as $data){													
			//$arrayParameterDetil = $this->upload_act->getDataKodeUpload('stockDetil',$data['TGL_DOK_MASUK'],'',$data['IDHDR'],$data['JENIS_DOK_MASUK']);
			//$STOCKB_DETIL = $this->upload_act->getDataKodeUpload('stockAllDetil',$data['TGL_DOK_MASUK'],$data['IDHDR'],$data['JENIS_DOK_MASUK'],'');
			
			//if(empty($arrayParameterDetil)){
				if($data["NO_DOK_MASUK"]){
					$this->db->insert("m_trader_stockopname_dtl",$data);		
				}
			/* }else{
				 $VAF["JUMLAH"] = $data["JUMLAH"]+$STOCKB_DETIL[0];
				 $this->db->where(array('JENIS_DOK_MASUK'=>$data['JENIS_DOK_MASUK'],'NO_DOK_MASUK'=>$data['NO_DOK_MASUK'],'TGL_DOK_MASUK'=>$data['TGL_DOK_MASUK']));
				 $exec = $this->db->update('m_trader_stockopname_dtl', $VAF);
			 }	*/		
		}
				
		
		if($exec){
			return "sukses";
		}else{
			return "gagal";
		}
	}
	
	
///////////////////////////	END STOCKOPNAME ///////////////////////////////////////////////////////////////////////////////////////////////	

///////////////////////////	START DATA BARANG ///////////////////////////////////////////////////////////////////////////////////////////////
	
	function upload_barang(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_barang');
	}
	
	public function konfirmasi_barang()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('upload_act');
		$this->load->library('upload');
		$idHeader = $this->input->post('id');
		
		if ($idHeader == "")
			redirect('upload/upload_data','refresh');
		
		$uploadPath = "assets/file/upload";
		$namaFileGoods = md5($idHeader.'goods').".xls";
		
		$config['upload_path'] = './'.$uploadPath;
		$config['allowed_types'] = 'xls';
		$config['max_size'] = '3000'; //300 KB
		$config['encrypt_name'] = TRUE;
		$config['file_name'] = $namaFileGoods;
		$config['overwrite'] = TRUE;
		$this->upload->initialize($config);
	
		
		if ($this->upload->do_upload('fileUpload'))
		{
			$this->load->library('excel_reader');
		
			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');			
			$file = $uploadPath."/".$namaFileGoods;
			$this->excel_reader->read($file);
			$dataExcel = $this->excel_reader->sheets[0];
			
			$data = array();
			$totalRowTemp = 20000;
			$rowsAwal = 2;
			$colsTransaksi = 1;//KODE BARANG
			$colsAwal = 1;
			$colsAkhir = 16;
			$rowsAkhir = 2;
			$arrayDataSend = array();
			$banyakError = 0;
			$banyakError = 0;
			$banyakAda = 0;
			$kondisi = array('BAIK','RUSAK','');
			
			$arrayKodeBarang = $this->upload_act->getDataKodeUpload('barang');
			$arrayKodeSatuan = $this->upload_act->getDataKodeUpload('satuan');
			$arrayDataGudang = $this->upload_act->getDataKodeUpload('gudang');
			/*$arrayDataRak = $this->upload_act->getDataKodeUpload('rak');
			$arrayDataSubRak = $this->upload_act->getDataKodeUpload('subrak');*/
			$arrayJNS_BARANG = array('1','2','3','4','5');

			
			for ($i = $rowsAwal; $i<=$totalRowTemp; $i++)
			{
				$tempTransaksi = $dataExcel['cells'][$i][$colsTransaksi];
				if ((trim($tempTransaksi) == "")&&($i!=2))
				{
					$rowsAkhir = ($i-1);
					break;
				}
			}
			
			for ($i = $rowsAwal; $i<=$rowsAkhir; $i++)
			{
				for ($c = $colsAwal; $c<=$colsAkhir; $c++)
				{
					$tempData = (string)strtoupper($dataExcel['cells'][$i][$c]);
					$class = "";
					$title = "";
					$align = "left";
					if ($c == 2)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							$addtitle="";
							$tempData = $this->replace_charackter((string)$tempData);
							if(strlen($tempData)>35){
								$addtitle = ', Kode barang lebih dari 35 Karakter, data dikenali 35 karakter dan akan terpotong otomatis menjadi 35 karakter';	
							}
							if (in_array($tempData,$arrayKodeBarang))
							{
								$class = "alertClass";
								$title = "Kode Barang sudah ada dalam database ".$addtitle;
								$banyakAda++;
							}
						}
					}
					else if ($c == 3)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array($tempData,$arrayJNS_BARANG))
							{
								$class = "errorClass";
								$title = "Jenis Barang tidak dikenali";
								$banyakError++;
							}
						}
					}

					else if ($c == 4)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							$hs = str_replace('.',"",$tempData);
							$tempData = $hs;
							if (!is_numeric($tempData))
							{
								$class = "errorClass";
								$title = "HS harus dalam bentuk angka";
								$banyakError++;
							}
							
						}
					}
					else if ($c == 10 || $c == 11)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array($tempData,$arrayKodeSatuan))
							{
								$class = "errorClass";
								$title = "Satuan tidak dikenali";
								$banyakError++;
							}
						}
					}
					
					else if($c == 13 ){
						if(trim($tempData)=="" && ($i!=2)){
							$class = "errorClass";
							$title = "Kode Gudang wajib diisi";
							$banyakError++;
						}
						else if(trim($tempData)!="" && !in_array(trim($tempData), $arrayDataGudang)){
							$class = "errorClass";
							$title = "Kode Gudang tidak terdaftar";
							$banyakError++;
						}
					}	
					else if ($c == 14 ){
						if (!in_array(trim($tempData), $kondisi)){
							$class = "errorClass";
							$title = "Kondisi Barang tidak dikenali";
							$banyakError++;
						}
						if (trim($tempData) == "" && ($i!=2)){
							$tempData = "BAIK";
						}
					}
					else if($c == 15 ){
						$kdgudang = (string)strtoupper($dataExcel['cells'][$i][13]);
						$dataRak = $this->upload_act->getDataKodeUpload('rak1','','','','',$kdgudang,$tempData,'');
						if(trim($tempData)=="" && ($i!=2)){
							$class = "errorClass";
							$title = "Kode Rak wajib diisi";
							$banyakError++;
						}
						else if(trim($tempData)!="" && $dataRak[0]=="0"){
							$class = "errorClass";
							$title = "Kode Rak tidak terdaftar pada gudang ".$kdgudang;
							$banyakError++;
						}
					}	
					else if($c == 16 ){
						$kdgudang = (string)strtoupper($dataExcel['cells'][$i][13]);
						$kdRak = (string)strtoupper($dataExcel['cells'][$i][15]);
						$dataSubRak = $this->upload_act->getDataKodeUpload('subrak1','','','','',$kdgudang,$kdRak,$tempData);
						if(trim($tempData)=="" && ($i!=2)){
							$class = "errorClass";
							$title = "Kode Sub Rak wajib diisi";
							$banyakError++;
						}
						else if(trim($tempData)!="" && $dataSubRak[0]=="0"){
							$class = "errorClass";
							$title = "Kode Sub Rak tidak terdaftar pada gudang ".$kdgudang." atau rak ".$kdRak;
							$banyakError++;
						}
					}	
					
					$arrayData[$i][$c] = array('align'=>$align,'isi'=>$tempData,'class'=>$class,'title'=>$title);
				}
			}
			$arrayAlign = array('','','center','center','center','center','center','center','center','center','center','center','center','center','center','center');
			$data['rowsAwal'] = $rowsAwal;
			$data['rowsAkhir'] = $rowsAkhir;
			$data['banyakData'] = ($rowsAkhir - $rowsAwal)+1;
			$data['colsAkhir'] = $colsAkhir;
			$data['colsAwal'] = $colsAwal;
			$data['arrayData'] = $arrayData;
			$data['arrayAlign'] = $arrayAlign;
			$data['banyakError'] = $banyakError;
			$data['banyakAda'] = $banyakAda;
			$data['id'] = $idHeader;
			$hasil = $this->load->view('upload/form_upload_barang_preview',$data);
			return $hasil;
		}
		else
		{
			echo $this->upload->display_errors();
		}
	}
	
	function insert_upload_Barang()
	{
		$this->load->model('upload_act');
		$this->load->model("main");
		$this->load->library('upload');
		
		$rowsAwal = $this->input->post('rowsAwal');
		$rowsAkhir = $this->input->post('rowsAkhir');
		$colsAwal = $this->input->post('colsAwal');
		$colsAkhir = $this->input->post('colsAkhir');
		$banyakData = $this->input->post('banyakData');
		$idHeader = $this->input->post('id');
		
		if ($idHeader == "")
			redirect('upload/upload_data','refresh');
		
		$uploadPath = "assets/file/upload";		
		$namaFile = md5($idHeader.'goods').".xls";		
		$this->load->library('excel_reader');		
		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');			
		$file = $uploadPath."/".$namaFile;
		$this->excel_reader->read($file);
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		// Baca Sheet 1
		$dataExcel = $this->excel_reader->sheets[0];
		$data = array();
		
		$arrayBarang = array('KODE_TRADER','KODE_PARTNER','KODE_BARANG','JNS_BARANG','KODE_HS','URAIAN_BARANG','MERK','UKURAN','TIPE','SPFLAIN','KODE_SATUAN','KODE_SATUAN_TERKECIL','JML_SATUAN_TERKECIL','GUDANG','KONDISI','RAK','SUB_RAK');	
		//$arrayStock = array('KODE_TRADER','KODE_PARTNER','KODE_BARANG','JNS_BARANG','KODE_HS','URAIAN_BARANG','MERK','UKURAN','TIPE','SPFLAIN','KODE_SATUAN','KODE_SATUAN_TERKECIL','JML_SATUAN_TERKECIL','JUMLAH','KODE_GUDANG','KONDISI_BARANG','TANGGAL_STOCK');
		$arrayGudang = array('KODE_TRADER','KODE_PARTNER','KODE_BARANG','JNS_BARANG','KODE_HS','URAIAN_BARANG','MERK','UKURAN','TIPE','SPFLAIN','SATUAN','KODE_SATUAN_TERKECIL','JML_SATUAN_TERKECIL','KODE_GUDANG','KONDISI_BARANG','KODE_RAK','KODE_SUB_RAK');			
		
		$nomorIndex = 0;
		$indexBarang = 0;
		$indexStock= 0;
		$indexGudang= 0;
		
		$array_data_barang = array();
		$array_data_stock = array();
		$array_data_gudang = array();
		$kodeTrader = $this->newsession->userdata("KODE_TRADER");		
		
		for ($i = $rowsAwal; $i<=$rowsAkhir; $i++)
		{
			/*$dateStock = $dataExcel['cells'][2][13];
			$repdateStock = str_replace("/","-",$dateStock);
			$repdateStock = $this->adddate($repdateStock,'-1 day');
			$Date = explode("-",$repdateStock);
			$dateStock = $Date[0]."-".$Date[1]."-".$Date[2];		*/		
			
			for ($c = $colsAwal; $c<=$colsAkhir; $c++)
			{
				$tempData = strtoupper(trim($dataExcel['cells'][$i][$c]));

				if ($c == 4)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							$hs = str_replace('.',"",$tempData);
							$tempData = $hs;
							if (!is_numeric($tempData))
							{
								$class = "errorClass";
								$title = "HS harus dalam bentuk angka";
								$banyakError++;
							}
						}
					}
					else if ($c == 14){
						if (trim($tempData) == ""){
							$tempData = "BAIK";
						}
					}
				
				if ((strtoupper(trim($tempData)) != ""))
				{
					
													
					$array_data_barang[$indexBarang][$arrayBarang[0]] = $kodeTrader;
					$array_data_barang[$indexBarang][$arrayBarang[$c]] = $tempData;

					$array_data_gudang[$indexGudang][$arrayGudang[0]] = $kodeTrader;
					$array_data_gudang[$indexGudang][$arrayGudang[$c]] = $tempData;					
											
					/*$array_data_stock[$indexStock][$arrayStock[0]] = $kodeTrader;
					$array_data_stock[$indexStock][$arrayStock[16]] = $dateStock;
					$array_data_stock[$indexStock][$arrayStock[$c]] = $tempData;*/
					
				}				
				$indexKolom++;
			}
		
			$nomorIndex++;
			$indexBarang++;
			// $indexStock++;
			$indexGudang++;
		}
		
		$exec = $this->getInsertBarang($array_data_barang, $array_data_gudang);
		//print_r($array_data_stock);
		unlink($file);
		
		if($exec =="sukses"){
			$hasil = "Data Berhasil disimpan";
		}else{
			$hasil = "Data Gagal disimpan";
		}

		echo json_encode($hasil);
	}
	
	function getInsertBarang($array_data_barang, $array_data_gudang){
		#print_r($array_data_barang);print_r($array_data_gudang);die();
		$arrayParameter = $this->upload_act->getDataParameter('stock');
		$arrayKodeBarang = $this->upload_act->getDataKodeUpload('barang');
		$kode_trader = $this->newsession->userdata('KODE_TRADER');

		$arraykdbrg = array();
		$STOCKA=0;
		foreach($array_data_barang as $data){
			unset($data['SERI']);
			unset($data['GUDANG']);
			unset($data['KONDISI']);
			unset($data['RAK']);
			unset($data['SUB_RAK']);
			

			$data['KODE_BARANG'] = (string)$this->replace_charackter($data['KODE_BARANG']);
			$data['KODE_HS'] = $this->replace_charackter($data['KODE_HS']);
			if(in_array(substr($data['KODE_BARANG'],0,15),$arrayKodeBarang)){		
				$ket = "sukses";
			}else{
				$STOCKA = $this->upload_act->getDataKodeUpload('barangAll','',$data['KODE_BARANG'],$data['JNS_BARANG'],'','');
				if(empty($STOCKA)){			
					$exec = $this->db->insert('m_trader_barang',$data);
					$this->main->activity_log('ADD DATA BARANG','KODE_BARANG='.$data['KODE_BARANG'].', JNS_BARANG='.$data['JNS_BARANG'],'UPLOAD');
				}else{
					$VAL["STOCK_AKHIR"] = $data["STOCK_AKHIR"]+$STOCKA[0];
					$this->db->where(array('KODE_BARANG'=>$data['KODE_BARANG'],'KODE_TRADER'=>$kode_trader,'JNS_BARANG'=>$data['JNS_BARANG']));
					$exec = $this->db->update('m_trader_barang', $VAL);
					$this->main->activity_log('EDIT DATA BARANG','KODE_BARANG='.$data['KODE_BARANG'].', JNS_BARANG='.$data['JNS_BARANG'],'UPLOAD');
				}
				if($exec){
					$ket = "sukses";
				}else{
					$ket = "gagal";
				}
			}
		}
		$arrayStockBrg = array();
		$STOCKB=0;
		
	/*	$this->load->model('upload_act');
		$id = $this->upload_act->getDataKodeUpload('id');		
		$idhdr = $id[0]+1;	*/	

		/*foreach($array_data_stock as $data){
			unset($data['KODE_HS']);
			unset($data['SERI']);
			unset($data['URAIAN_BARANG']);
			unset($data['MERK']);
			unset($data['UKURAN']);
			unset($data['TIPE']);
			unset($data['SPFLAIN']);
			unset($data['KODE_SATUAN']);
			unset($data['KODE_SATUAN_TERKECIL']);
			unset($data['JML_SATUAN_TERKECIL']);
			unset($data['KODE_PARTNER']);

			$data['ID'] = $idhdr;
			
			$data['KODE_BARANG'] = $this->replace_charackter($data['KODE_BARANG']);
			
			if ((in_array($data['KODE_BARANG'],$arrayParameter['kode'])) && (in_array($data['TANGGAL_STOCK'],$arrayParameter['tgl'])))
			{		
				$ket = "sukses";
			}else{										
				$STOCKB = $this->upload_act->getDataKodeUpload('stockAll',$data['TANGGAL_STOCK'],$data['KODE_BARANG'],$data['JNS_BARANG'],'','');	
				if(empty($STOCKB)){	
					$exec = $this->db->insert('m_trader_stockopname',$data);		
				}else{
					$VAF["JUMLAH"] = $data["JUMLAH"]+$STOCKB[0];
					$this->db->where(array('KODE_BARANG'=>$data['KODE_BARANG'],'KODE_TRADER'=>$kode_trader,'JNS_BARANG'=>$data['JNS_BARANG'],'TANGGAL_STOCK'=>$data['TANGGAL_STOCK']));
					$exec = $this->db->update('m_trader_stockopname', $VAF);
				}				
				if($exec){
					$ket = "sukses";
				}else{
					$ket = "gagal";
				}
			}
			$idhdr++;
		}*/

		$STOCKC=0;
		foreach($array_data_gudang as $data){
			unset($data['KODE_PARTNER']);
			unset($data['KODE_HS']);
			unset($data['URAIAN_BARANG']);
			unset($data['MERK']);
			unset($data['UKURAN']);
			unset($data['TIPE']);
			unset($data['SPFLAIN']);
			unset($data['KODE_SATUAN_TERKECIL']);
			unset($data['JML_SATUAN_TERKECIL']);
		

			#print_r($data);die();
			$STOCKC = $this->upload_act->getDataKodeUpload('gudangAll','',$data['KODE_BARANG'],$data['JNS_BARANG'],'',$data['KODE_GUDANG']);
			if(empty($STOCKC)){	
				$exec = $this->db->insert('m_trader_barang_gudang',$data);		
			}else{
				$VAK["JUMLAH"] = $data["JUMLAH"]+$STOCKC[0];
				$this->db->where(array('KODE_BARANG'=>$data['KODE_BARANG'],'KODE_TRADER'=>$kode_trader,'JNS_BARANG'=>$data['JNS_BARANG'],'KODE_GUDANG'=>$data['KODE_GUDANG']));
				$exec = $this->db->update('m_trader_barang_gudang', $VAK);
			}				
			if($exec){
				$ket = "sukses";
			}else{
				$ket = "gagal";
			}
		}
		return $ket;		
	}
	
///////////////////////////	END DATA BARANG ///////////////////////////////////////////////////////////////////////////////////////////////				


///////////////////////////	START PEMASOK ////////////////////////////////////////////////////////////////////////////////			
			
	function upload_pemasok()
	{
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_pemasok');
	}
	
	public function konfirmasi_pemasok(){
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('upload_act');
		$this->load->library('upload');
		$idHeader = $this->input->post('id');
		
		if ($idHeader == "")
			redirect('upload/upload_pemasok','refresh');
		
		$uploadPath = "assets/file/upload";		
		$namaFileGoods = md5($idHeader.'pemasok').".xls";
		
		$config['upload_path'] = './'.$uploadPath;
		$config['allowed_types'] = 'xls';
		$config['max_size'] = '4000'; //on KB
		$config['encrypt_name'] = TRUE;
		$config['file_name'] = $namaFileGoods;
		$config['overwrite'] = TRUE;
		$this->upload->initialize($config);	
		
		if ($this->upload->do_upload('fileUpload')){
			$this->load->library('excel_reader');		
			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');			
			$file = $uploadPath."/".$namaFileGoods;
			$this->excel_reader->read($file);
			// Baca Sheet 1
			$dataExcel = $this->excel_reader->sheets[0];
			$data = array();

			$totalRowTemp = 20000;
			$rowsAwal = 2;
			$colsNoUrut = 1;
			$colsAwal = 1;
			$colsAkhir = 8;
			$rowsAkhir = 2;
			$arrayDataSend = array();
			$banyakError = 0;
			$banyakAda = 0;
			
			$arrayKodePartner = $this->upload_act->getDataKodeUpload('pemasok');
			$arrayidentitas = $this->upload_act->getDataKodeUpload('identitas');
			$arrayjenisperusahaan = $this->upload_act->getDataKodeUpload('jenisperusahaan');
			$arraystatusperusahaan = $this->upload_act->getDataKodeUpload('statusperusahaan');
			//$arrayKodeNegara = $this->upload_act->getDataKodeUpload('negara');
						
			for ($i = $rowsAwal; $i<=$totalRowTemp; $i++)
			{
				$tempNoUrut = $dataExcel['cells'][$i][$colsNoUrut];
				if (trim($tempNoUrut) == "")
				{
					$rowsAkhir = ($i-1);
					break;
				}
			}
			
			for ($i = $rowsAwal; $i<=$rowsAkhir; $i++)
			{
				for ($c = $colsAwal; $c<=$colsAkhir; $c++)
				{
					$tempData = strtoupper($dataExcel['cells'][$i][$c]);
					$class = "";
					$title = "";
					$align = "left";
					
					if ($c == 1)
					{
						$align = "center";
						if (trim($tempData)!="")
						{														
							if (in_array($tempData,$arrayKodePartner))
							{
								$class = "alertClass";
								$title = "Kode Perusahaan sudah ada dalam database";
								$banyakAda++;
							}
						}
					}
					elseif ($c == 2)
					{
						$align = "center";
						if (trim($tempData)!="")
						{												
							if (!in_array($tempData,$arrayidentitas))
							{
								$class = "errorClass";
								$title = "Kode Identitas tidak dikenali";
								$banyakError++;
							}
						}
					}
					else if ($c == 4 )
					{
						$align = "center";
						if (trim($tempData)=="")
						{							
							$class = "errorClass";
							$title = "Nama Perusahaan Tidak boleh kosong";
							$banyakError++;							
						}
					}
					elseif ($c == 6)
					{
						$align = "center";
						if (trim($tempData)!="")
						{														
							if (!in_array($tempData,$arrayjenisperusahaan))
							{
								$class = "errorClass";
								$title = "Kode Jenis Perusahaan tidak dikenali";
								$banyakError++;
							}
						}
					}
					elseif ($c == 7)
					{
						$align = "center";
						if (trim($tempData)!="")
						{														
							if (!in_array($tempData,$arraystatusperusahaan))
							{
								$class = "errorClass";
								$title = "Status Perusahaan tidak dikenali";
								$banyakError++;
							}
						}
					}
					/*else if ($c == 8)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array($tempData,$arrayKodeNegara))
							{
								$class = "errorClass";
								$title = "Kode Negara tidak dikenali";
								$banyakError++;
							}
						}
					}*/
					$arrayData[$i][$c] = array('align'=>$align,'isi'=>$tempData,'class'=>$class,'title'=>$title);
				}
			}
			$arrayAlign = array('','','left','center','center','center','center','center','center','center','center','center','center','center',
								'center','center','center','center','center','center','center','center','center','center','center','center','center');
			$data['rowsAwal'] = $rowsAwal;
			$data['rowsAkhir'] = $rowsAkhir;
			$data['banyakData'] = ($rowsAkhir - $rowsAwal) + 1;
			$data['colsAkhir'] = $colsAkhir;
			$data['colsAwal'] = $colsAwal;
			$data['arrayData'] = $arrayData;
			$data['arrayAlign'] = $arrayAlign;
			$data['banyakError'] = $banyakError;
			$data['banyakAda'] = $banyakAda;
			$data['id'] = $idHeader;
			$hasil = $this->load->view('upload/form_upload_pemasok_preview',$data);
			return $hasil;
		}
		else
		{
			echo $this->upload->display_errors();
		}
	}
	
	function insert_upload_pemasok()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('upload_act');
		$this->load->library('upload');
		$this->load->model("main");

		
		$rowsAwal = $this->input->post('rowsAwal');
		$rowsAkhir = $this->input->post('rowsAkhir');
		$colsAwal = $this->input->post('colsAwal');
		$colsAkhir = $this->input->post('colsAkhir');
		$banyakData = $this->input->post('banyakData');
		$idHeader = $this->input->post('id');
		
		if ($idHeader == "")
			redirect('upload/upload_pemasok','refresh');
		
		$uploadPath = "assets/file/upload";		
		$namaFile = md5($idHeader.'pemasok').".xls";		
		$this->load->library('excel_reader');		
		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');			
		$file = $uploadPath."/".$namaFile;
		$this->excel_reader->read($file);
		// Baca Sheet 1
		$dataExcel = $this->excel_reader->sheets[0];
		$data = array();	
						
		$indexPemasok= 0;
		$arrayPemasok = array('KODE_TRADER','KODE_PARTNER','KODE_ID_PARTNER','ID_PARTNER','NAMA_PARTNER',
							  'ALAMAT_PARTNER','JENIS_PARTNER','STATUS_PARTNER','NEGARA_PARTNER');		
		$array_data_pemasok = array();
		$kodeTrader = $this->newsession->userdata("KODE_TRADER");				   			
		
		for ($i = $rowsAwal; $i<=$rowsAkhir; $i++)
		{						
			
			for ($c = $colsAwal; $c<=$colsAkhir; $c++)
			{
				$tempData = strtoupper(trim($dataExcel['cells'][$i][$c]));
				
				if ((strtoupper(trim($dataExcel['cells'][$i][$colsAwal])) != ""))
				{						
					$array_data_pemasok[$indexPemasok][$arrayPemasok[0]] = $kodeTrader;
					$array_data_pemasok[$indexPemasok][$arrayPemasok[1]] = strtoupper(trim($dataExcel['cells'][$i][1]));
					$array_data_pemasok[$indexPemasok][$arrayPemasok[2]] = strtoupper(trim($dataExcel['cells'][$i][2]));
					$array_data_pemasok[$indexPemasok][$arrayPemasok[3]] = strtoupper(trim(str_replace(".","",str_replace("-","",$dataExcel['cells'][$i][3]))));
					$array_data_pemasok[$indexPemasok][$arrayPemasok[4]] = strtoupper($dataExcel['cells'][$i][4]);
					$array_data_pemasok[$indexPemasok][$arrayPemasok[5]] = strtoupper($dataExcel['cells'][$i][5]);		
					$array_data_pemasok[$indexPemasok][$arrayPemasok[6]] = strtoupper($dataExcel['cells'][$i][6]);	
					$array_data_pemasok[$indexPemasok][$arrayPemasok[7]] = strtoupper($dataExcel['cells'][$i][7]);	
					$array_data_pemasok[$indexPemasok][$arrayPemasok[8]] = strtoupper($dataExcel['cells'][$i][8]);					
				}
								
				$indexKolom++;
			}
		
			$indexPemasok++;
		}
		
		$exec = $this->getInsert_pemasok($array_data_pemasok);
		//print_r($array_data_pemasok);die();
		unlink($file);
				
		if($exec =="sukses"){
			$hasil = "Data Berhasil disimpan";
		}else{
			$hasil = "Data Gagal disimpan";
		}
		echo json_encode($hasil);
	}
	
	function getInsert_pemasok($array_data_pemasok)
	{
		$arrayKodePartner = $this->upload_act->getDataKodeUpload('pemasok');
		$kodeTrader = $this->newsession->userdata("KODE_TRADER");
		
		foreach($array_data_pemasok as $data){		
			if(in_array($data['KODE_PARTNER'],$arrayKodePartner)){	
				$ket = "sukses";
			}else{
				//echo $data["NEGARA_PARTNER"]; die();
				$IDNEGARA = $this->upload_act->getDataKodeUpload('idnegara',$data["NEGARA_PARTNER"]);
				if(empty($IDNEGARA)){
					$data["NEGARA_PARTNER"] = "";
				}else{
					$data["NEGARA_PARTNER"] = $IDNEGARA[0];
				}
				$exec = $this->db->insert("m_trader_partner",$data);
				$this->main->activity_log('ADD PEMASOK','KODE PARTNER='.$arrayKodePartner,'UPLOAD');	
			}
		}
		
		if($exec)
			return "sukses";
		else
			return "gagal";		
	}
	
///////////////////////////	END UPLOAD PEMASOK ////////////////////////////////////////////////////////////////////////////////		

///////////////////////////	START KONVERSI ////////////////////////////////////////////////////////////////////////////////			
			
	function upload_konversi()
	{
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_konversi');
	}
	
	public function konfirmasi_konversi(){
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('upload_act');
		$this->load->library('upload');
		$idHeader = $this->input->post('id');
		
		if ($idHeader == "")
			redirect('upload/upload_konversi','refresh');
		
		$uploadPath = "assets/file/upload";		
		$namaFileGoods = md5($idHeader.'konversi').".xls";
		
		$config['upload_path'] = './'.$uploadPath;
		$config['allowed_types'] = 'xls';
		$config['max_size'] = '3000'; //on KB
		$config['encrypt_name'] = TRUE;
		$config['file_name'] = $namaFileGoods;
		$config['overwrite'] = TRUE;
		$this->upload->initialize($config);	
		
		if ($this->upload->do_upload('fileUpload')){
			$this->load->library('excel_reader');		
			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');			
			$file = $uploadPath."/".$namaFileGoods;
			$this->excel_reader->read($file);
			// Baca Sheet 1
			$dataExcel = $this->excel_reader->sheets[0];
			$data = array();

			$totalRowTemp = 20000;
			$rowsAwal = 2;
			$colsNoUrut = 10;
			$colsAwal = 2;
			$colsAkhir = 16;
			$rowsAkhir = 2;
			$arrayDataSend = array();
			$banyakError = 0;
			$banyakAda = 0;
			
			$arrayNokonversi = $this->upload_act->getDataKodeUpload('konversi');
			$arrayKodeBarang = $this->upload_act->getDataKodeUpload('barang');
			$arrayJenisBarang = $this->upload_act->getDataKodeUpload('jenisbarang');
			$arrayKodeSatuan = $this->upload_act->getDataKodeUpload('satuan');
			
			for ($i = $rowsAwal; $i<=$totalRowTemp; $i++)
			{
				$tempNoUrut = $dataExcel['cells'][$i][$colsNoUrut];
				if (trim($tempNoUrut) == "")
				{
					$rowsAkhir = ($i-1);
					break;
				}
			}
			
			for ($i = $rowsAwal; $i<=$rowsAkhir; $i++)
			{
				for ($c = $colsAwal; $c<=$colsAkhir; $c++)
				{
					$tempData = strtoupper($dataExcel['cells'][$i][$c]);
					$class = "";
					$title = "";
					$align = "left";
					
					if ($c == 2)
					{
						$align = "center";
						if (trim($tempData)!="")
						{														
							if (in_array($tempData,$arrayNokonversi))
							{
								$class = "alertClass";
								$title = "Nomor Konversi sudah ada dalam database";
								$banyakAda++;
							}
						}
					}
					else if ($c == 3 || $c == 11)
					{
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array($tempData,$arrayKodeBarang))
							{
								$class = "errorClass";
								$title = "Kode Barang tidak dikenali";
								$banyakError++;
							}
						}
					}
					else if ($c == 4 || $c == 12)
					{
						if($c==4){
							$cekJnsBrg = $this->upload_act->getDataParameter('jnsbarang',$tempData,strtoupper($dataExcel['cells'][$i][3]));
						}else{
							$cekJnsBrg = $this->upload_act->getDataParameter('jnsbarang',$tempData,strtoupper($dataExcel['cells'][$i][11]));
						}
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array($tempData,$arrayJenisBarang)||$cekJnsBrg[0]["COUNT"]<1)
							{
								$class = "errorClass";
								$title = "Jenis Barang tidak dikenali";
								$banyakError++;
							}
						}
					}
					else if ($c == 5 || $c == 13)
					{
						if($c==5){
							$cekUrBrg = $this->upload_act->getDataParameter('urbarang',$tempData,strtoupper($dataExcel['cells'][$i][3]));
						}else{
							$cekUrBrg = $this->upload_act->getDataParameter('urbarang',$tempData,strtoupper($dataExcel['cells'][$i][11]));
						}
						$align = "center";
						if (trim($tempData)!="")
						{
							if ($cekUrBrg[0]["COUNT"]<1)
							{
								$class = "errorClass";
								$title = "Uraian Barang tidak sesuai";
								$banyakError++;
							}
						}
					}
					else if ($c == 7 || $c == 15)
					{
						if($c==7){
							$cekSatuan = $this->upload_act->getDataParameter('satuan',$tempData,strtoupper($dataExcel['cells'][$i][3]));
						}else{
							$cekSatuan = $this->upload_act->getDataParameter('satuan',$tempData,strtoupper($dataExcel['cells'][$i][11]));
						}
						$align = "center";
						if (trim($tempData)!="")
						{
							if (!in_array($tempData,$arrayKodeSatuan)||$cekSatuan[0]["COUNT"]<1)
							{
								$class = "errorClass";
								$title = "Satuan tidak dikenali";
								$banyakError++;
							}
						}
					}
					$arrayData[$i][$c] = array('align'=>$align,'isi'=>$tempData,'class'=>$class,'title'=>$title);
				}
			}
			$arrayAlign = array('','','left','center','center','center','center','center','center','center','center','center','center','center',
								'center','center','center','center','center','center','center','center','center','center','center','center','center');

			$data['rowsAwal'] = $rowsAwal;
			$data['rowsAkhir'] = $rowsAkhir;
			$data['banyakData'] = ($rowsAkhir - $rowsAwal) + 1;
			$data['colsAkhir'] = $colsAkhir;
			$data['colsAwal'] = $colsAwal;
			$data['arrayData'] = $arrayData;
			$data['arrayAlign'] = $arrayAlign;
			$data['banyakError'] = $banyakError;
			$data['banyakAda'] = $banyakAda;
			$data['id'] = $idHeader;
			$hasil = $this->load->view('upload/form_upload_konversi_preview',$data);
			return $hasil;
		}
		else
		{
			echo $this->upload->display_errors();
		}
	}
	
	function insert_upload_konversi()
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('upload_act');
		$this->load->library('upload');
		$this->load->model("main");

		
		$rowsAwal = $this->input->post('rowsAwal');
		$rowsAkhir = $this->input->post('rowsAkhir');
		//$colsAwal = $this->input->post('colsAwal');
		$colsAwal = 1;
		$colsAkhir = $this->input->post('colsAkhir');
		$banyakData = $this->input->post('banyakData');
		$idHeader = $this->input->post('id');
		
		if ($idHeader == "")
			redirect('upload/upload_konversi','refresh');
		
		$uploadPath = "assets/file/upload";		
		$namaFile = md5($idHeader.'konversi').".xls";	
		$this->load->library('excel_reader');		
		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');			
		$file = $uploadPath."/".$namaFile;
		$this->excel_reader->read($file);
		// Baca Sheet 1
		$dataExcel = $this->excel_reader->sheets[0];
		$data = array();
		
		$arrayReturnHeader = array();
		$arrayReturnDetil = array();
		$nomorIndex = 0;
		
		$indexDetil = 0;
		$indexbb = 0;
		$array_data_detil = array();
		$array_data_bb = array();
		$no = 1;
		$id = 0;
		
		$this->load->model('main');
		$IDBJ = (int)$this->main->get_uraian("SELECT MAX(IDBJ) AS IDBJ FROM m_trader_konversi_bj", "IDBJ")+1;     
		
		for ($i = $rowsAwal; $i<=$rowsAkhir; $i++)
		{
			
			if (strtoupper(trim($dataExcel['cells'][$i][$colsAwal])) != ""){
					$seri = strtoupper(trim($dataExcel['cells'][$i][1]));
					if($i!=2){
						$no=1;
					}
					
			}else{									
					$seri = strtoupper(trim($dataExcel['cells'][($i-($i-($i-$no)))][1]));
					$no++;
			}
			
			
			$arrayDetil = array('IDBJ','NO','NOMOR_KONVERSI','KODE_BARANG','JNS_BARANG','URAIAN','JUMLAH','KODE_SATUAN',
								'SUBKONTRAK','KETERANGAN');
									
			$arraybb = array('IDBJ','','','','','','','','','','IDBB','KODE_BARANG','JNS_BARANG','URAIAN','JUMLAH',
								'KODE_SATUAN','KETERANGAN');		
			
			$NEXTIDBJ = $IDBJ+$id;
			
			for ($c = $colsAwal; $c<=$colsAkhir; $c++)
			{
				$tempData = strtoupper(trim($dataExcel['cells'][$i][$c]));
				
				if (strtoupper(trim($dataExcel['cells'][$i][$colsAwal])) != "")
				{
					// detil
					if ($c < 10){
						$array_data_detil[$indexDetil][$arrayDetil[0]] = $NEXTIDBJ;
						$array_data_detil[$indexDetil][$arrayDetil[$c]] = $tempData;
						
						$array_data_bb[$indexbb][$arraybb[0]] = $NEXTIDBJ;
					}else{
						$array_data_bb[$indexbb][$arraybb[0]] = $NEXTIDBJ;
						$array_data_bb[$indexbb][$arraybb[$c]] = $tempData;
						
					}
				}
				else
				{
					if ($c > 9){
						$array_data_bb[$indexbb][$arraybb[0]] = $NEXTIDBJ;	
						$array_data_bb[$indexbb][$arraybb[$c]] = $tempData;
									
					}
				}				
				$indexKolom++;
			}
			
			if (strtoupper(trim($dataExcel['cells'][$i+1][$colsAwal])) != ""){
				$id++;	
			}
			
			$nomorIndex++;
			$indexDetil++;
			$indexbb++;			
		}
		
		$exec = $this->getInsert_konversi($array_data_detil, $array_data_bb);
		//print_r($array_data_detil);die();
		unlink($file);
				
		if($exec =="sukses"){
			$hasil = "Data Berhasil disimpan";
		}else{
			$hasil = "Data Gagal disimpan";
		}
		echo json_encode($hasil);
	}
	
	function getInsert_konversi($array_data_detil, $array_data_bb)
	{
		
		$kodeTrader = $this->newsession->userdata("KODE_TRADER");
		
		foreach($array_data_detil as $data){
			unset($data["NO"]);
			unset($data["URAIAN"]);
			$data["KODE_TRADER"]=$kodeTrader;
			$exec = $this->db->insert("m_trader_konversi_bj",$data);
		}
		foreach($array_data_bb as $data){
			unset($data["URAIAN"]);
			$data["KODE_TRADER"]=$kodeTrader;
			$exec = $this->db->insert("m_trader_konversi_bb",$data);
		}
		
		if($exec){
			$this->main->activity_log('ADD KONVERSI','','UPLOAD');	
			return "sukses";
		}
		else{
			return "gagal";		
		}
	}
	
///////////////////////////	END UPLOAD KONVERSI ////////////////////////////////////////////////////////////////////////////////

///////////////////////////	START UPLOAD BC 3.0 WS (ATAS) ////////////////////////////////////////////////////////////////////////////////		
	function upload_bc30(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_bc30',array("confirm"=>""));
	}			
		
	
	public function konfirmasi_bc30(){	
		$tipe_dok = $this->input->post('tipe');
		$this->load->library('Upload');
		$this->load->model("main");

		$idHeader = $this->input->post('id');
		error_reporting(E_ALL & ~E_DEPRECATED ^ (E_NOTICE | E_WARNING));	
		date_default_timezone_set('Asia/Jakarta');
		
		if ($idHeader == "") redirect('upload/upload_data','refresh');
		$uploadPath = "assets/file/upload";						
		$namaFileGoods = md5($idHeader.date('dmYHis').'bc30').".bue";
		$config['upload_path'] = './'.$uploadPath;
		$config['allowed_types'] = 'bue';
		$config['max_size'] = '3000'; //KB
		$config['encrypt_name'] = TRUE;
		$config['file_name'] = $namaFileGoods;
		$config['overwrite'] = TRUE;
		$this->upload->initialize($config);
		if ($this->upload->do_upload('fileUpload')){
			$ftp_server = "10.1.5.78";
			$ftp_user_name = "Administrator";
			$ftp_user_pass = "Bismillah";
			$remote_file = "/wseinkaber/fileplb/";
			
			$file = "/home/inguber/assets/file/upload/".$namaFileGoods;	
			$conn_id = ftp_connect($ftp_server);
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);	
			if ((!$conn_id) || (!$login_result)){
				echo "failed to connect: check hostname, username & password";
			}
			else{ 			
				ftp_chdir($conn_id, '/wseinkaber/fileplb/'); 			
				if(ftp_put($conn_id, $namaFileGoods, $file, FTP_BINARY)) {
					$varconfirm = $this->sendCommand($namaFileGoods,"BC30",$tipe_dok);	
					$confirm="";
					if($varconfirm){
						$data = explode(";",$varconfirm);
						$data_ok = $data[0];
						$data_exist = $data[1];
						$data_faild = $data[2];
						if(strpos($data_ok,"|")===false){
							$confirm .="";
						}else{
							$jum = count(explode("|",$data_ok))-1;
							$confirm .= $jum." Nomor Aju Berhasil diproses.";
							$this->main->activity_log('UPLOAD DOKUMEN PABEAN BC30','FILE NAME='.$namaFileGoods);
						} 
						if(strpos($data_exist,"|")===false){
							$confirm .="";
						}else{
							$arrexist = explode("|",str_replace("exist#","",$data_exist));
							$jum = count($arrexist)-1;
							$confirm .= $jum." Nomor Aju Sudah ada, yaitu :<br>";
							for($a=0;$a<$jum;$a++){
								$confirm .= $arrexist[$a].", ";	
							}					
						} 
						if(strpos($data_faild,"|")===false){
							$confirm .="";
						}else{
							$arrfaild = explode("|",str_replace("faild#","",$data_faild));
							$jum = count($arrfaild)-1;
							$confirm .= $jum." Nomor Aju Gagal diproses, yaitu :<br>";
							for($a=0;$a<$jum;$a++){
								$confirm .= $arrfaild[$a].", ";	
							}
						} 
					}else{
						$confirm = "Data gagal diproses, Cek kembali file anda";	
					}
					$arradata = array("confirm"=>$confirm);
					$this->load->view("upload/form_upload_bc30",$arradata);
				} else {
					echo "There was a problem while uploading $file\n";
				}					
			}
			ftp_close($conn_id);
		}
		else
		{
			echo $this->upload->display_errors();
		}		
	}	

	///////////////////////////	END UPLOAD BC 3.0 WS (ATAS) ////////////////////////////////////////////////////////////////////////////////
	
	///////////////////////////	START UPLOAD BC 1.6 ////////////////////////////////////////////////////////////////////////////////		
	function upload_bc16(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_bc16',array("proses"=>""));
	}			
	
	/// START PROSES UPLOAD BC 1.6 ///
	function proses_upload_bc16() {
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0);
		$this->db->trans_begin();
		$this->load->model("main");
		$this->load->model('upload_act');
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');
		if($idHeader=="")redirect('upload/upload_bc16','refresh');
		#constanta validasi 4 pabean
		$highestColumn = 135;		
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');	
		$fieldHeader = array('NOMOR_AJU','KODE_KPBC_BONGKAR','KODE_KPBC_AWAS','NAMA_PENGIRIM','ALAMAT_PENGIRIM','NAMA_PENJUAL','ALAMAT_PENJUAL','NEGARA_PENJUAL','KODE_ID_TRADER','ID_TRADER','NAMA_TRADER','ALAMAT_TRADER','KODE_ID_PEMILIK','ID_PEMILIK','NAMA_PEMILIK','ALAMAT_PEMILIK','MODA','NAMA_ANGKUT','BENDERA','PELABUHAN_MUAT','PELABUHAN_TRANSIT','PELABUHAN_BONGKAR','PERKIRAAN_TGL_TIBA','NOMOR_PENUTUP','TANGGAL_PENUTUP','NOMOR_POS','SUB_POS','SUB_SUB_POS','KODE_VALUTA','KODE_HARGA','JENIS_NILAI','NILAI','CIF_RP','BRUTO','NETTO','PEMBERITAHU','JABATAN','KOTA_TTD','TANGGAL_TTD','NOMOR_PENDAFTARAN','TANGGAL_PENDAFTARAN');
		$colHeader = array('0','69','1','90','10','3','7','72','57','36','2','11','54','33','87','8','47','89','46','75','76','74','119','98','111','107','109','110','85','52','65','95','21','19','94','92','38','86','120','100','114');
		$fieldDetil = array('SERI','KODE_BARANG','KODE_HS','URAIAN_BARANG','JENIS_BARANG','JUMLAH_SATUAN','KODE_SATUAN','CIF');
		$fieldInOut = array('SERI','KODE_BARANG','','','JNS_BARANG','JUMLAH','KODE_SATUAN','','','KODE_LOKASI');
		$fieldKemasan = array('KODE_DOK', 'NOMOR_AJU', 'KODE_KEMASAN', 'JUMLAH', 'MERK_KEMASAN');
		$namaFile = $idHeader;
		$file = "assets/file/upload/";
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);	
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."BC16.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);
		$data = $this->upload->data();			
		$file = $file.$data['file_name'];	
		$this->upload->display_errors('' ,'' );
		if(!$this->upload->do_upload("fileUpload")){
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 
			$this->db->reconnect();
			# get additional data header from xls -> sheet Header
			$inputFileType = 'Excel5'; 
			$sheetname = 'Header'; 
			$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
			$objReader->setLoadSheetsOnly($sheetname); 
			$objHeader = $objReader->load($file);
			foreach($objHeader->getWorksheetIterator() as $workSheet){
				$highestRows = $workSheet->getHighestRow();
				$highestColumns = $workSheet->getHighestColumn(); 
				$highestColumnIndexs = PHPExcel_Cell::columnIndexFromString($highestColumns);
				$addHeader = array();
				$idx = 0;
				for ($x=2; $x <= $highestRows; $x++) {
					for($y = 0; $y < count($colHeader); $y++){
						//$cellAju = $workSheet->getCellByColumnAndRow(0, $x)->getCalculatedValue();
						$dataHeader[$idx][$fieldHeader[$y]] = $workSheet->getCellByColumnAndRow($colHeader[$y], $x)->getCalculatedValue();
					}
					$tgl_aju = substr($dataHeader[$idx]['NOMOR_AJU'], 12, 8);
					$dataHeader[$idx]['TANGGAL_AJU'] = substr($tgl_aju, 0, 4)."-".substr($tgl_aju, 4, 2)."-".substr($tgl_aju, 6, 2);
					$dataHeader[$idx]['PERKIRAAN_TGL_TIBA'] = $this->fungsi->formatshortdate($dataHeader[$idx]['PERKIRAAN_TGL_TIBA']);
					$dataHeader[$idx]['TANGGAL_PENUTUP'] = $this->fungsi->formatshortdate($dataHeader[$idx]['TANGGAL_PENUTUP']);
					$dataHeader[$idx]['TANGGAL_TTD'] = $this->fungsi->formatshortdate($dataHeader[$idx]['TANGGAL_TTD']);
					$dataHeader[$idx]['KODE_TRADER'] = $kodetrader;
					$dataHeader[$idx]['STATUS'] = '00';
					$dataHeader[$idx]['CREATED_BY'] = $userid;
					$dataHeader[$idx]['CREATED_TIME'] = date('Y-m-d H:i:s',time()-60*60*1);
					#print_r($dataHeader[$idx]);die();
					$exe = $this->db->insert('T_BC16_HDR',$dataHeader[$idx]); 
					#echo $this->db->last_query();die();
					$idx++;
				}
					if($exe){
						$sukses = "Berhasil upload";
					}else{
						$error = true;
					}
				
			}
			# get dokumen from xls -> sheet Dokumen
			/*$inputFileType = 'Excel5'; 
			$sheetname = 'Dokumen'; 
			$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
			$objReader->setLoadSheetsOnly($sheetname); 
			$objDokumen = $objReader->load($file);
			foreach($objDokumen->getWorksheetIterator() as $workSheet){
				$highestRows = $workSheet->getHighestRow();
				$highColDok = $workSheet->getHighestColumn(); 
				$highColDokIdx = PHPExcel_Cell::columnIndexFromString($highColDok);
				$dataDokumen = array();
				$idx = 0;
				for ($x=2; $x <= $highestRows; $x++) {
					for($y = 0; $y < ($highColDokIdx - 1); $y++){
						$cellKodeDokumen = $workSheet->getCellByColumnAndRow(0, $x)->getCalculatedValue();
						if (in_array(strtoupper($cellKodeDokumen), $datatipe)) {
							$dataDokumen[$idx]['TANGGAL'] = PHPExcel_Style_NumberFormat::toFormattedString($workSheet->getCellByColumnAndRow(4, $x)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							$dataDokumen[$idx][$fieldDokumen[$y]] = $workSheet->getCellByColumnAndRow($y, $x)->getCalculatedValue();
						}
					}
					$idx++;
				}
				break;
			}*/
			# get dokumen from xls -> sheet Kemasan
			/*$inputFileType = 'Excel5'; 
			$sheetname = 'Kemasan'; 
			$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
			$objReader->setLoadSheetsOnly($sheetname); 
			$objKemasan = $objReader->load($file);
			foreach($objKemasan->getWorksheetIterator() as $workSheet){
				$highestRows = $workSheet->getHighestRow();
				$highColKemasan = $workSheet->getHighestColumn(); 
				$highColKemasanIdx = PHPExcel_Cell::columnIndexFromString($highColKemasan);
				$dataKemasan = array();
				$idx = 0;
				for ($x=2; $x <= $highestRows; $x++) {
					for($y = 0; $y <= ($highColKemasanIdx - 1); $y++){
						$cellKodeDokumen = $workSheet->getCellByColumnAndRow(0, $x)->getCalculatedValue();
						if (in_array(strtoupper($cellKodeDokumen), $datatipe)) {
							$dataKemasan[$idx][$fieldKemasan[$y]] = $workSheet->getCellByColumnAndRow($y, $x)->getCalculatedValue();
						}
					}
					$idx++;
				}
				break;
			}*/
		
			/*foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				if($highestRow>10000){
					unlink($file);
					$error = $this->fungsi->msg("error","File Upload tidak boleh melebih 10.000 baris.");
					break;exit();
				}
				$highestColumn = $worksheet->getHighestColumn(); 
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$arraytemp = array();
				$arraytemp_jumlah = array();
				for($row=2; $row <= $highestRow; $row++){
					for($col=0; $col <= ($highestColumnIndex-1); $col++){
						#cek mandatory
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						if(in_array($col,$mandatory)){
							if(strval($cell->getCalculatedValue())==""){
								$kosong = TRUE;	
								$msgkosong = $msgkosong."KOLOM:[".($KOLOM[$col+1]).",".$row."], ";
							}
						}
					}				
					#cek kode dokumen
					$cell_tipe = $this->replace_character(str_replace(array(" ","."),array("",""),$worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue()));
					if($cell_tipe){
						for($col=0; $col <= ($highestColumnIndex-1); $col++){
							#cek mandatory conditional;
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							if(in_array($col,$mandatory_conditional)){
								if(strval($cell->getCalculatedValue())==""){
									$ajukosong= TRUE;	
									$msgajukosong = $msgajukosong."KOLOM:[".($KOLOM[$col+1]).",".$row."], ";
								}
							}
						}	
					}
					if($cell_tipe){
						if(!in_array(trim(strtoupper($cell_tipe)),$datatipe)){
							$tipe = TRUE;
							$msgtipe = $msgtipe.$cell_tipe." (KOLOM:[A".",".$row."]), ";
						}					
					}
					#cek nomor aju ada karakter tertentu
					$cell_ajuvalid = $worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
					if($cell_ajuvalid){
						if($this->check_character($cell_ajuvalid)){
							$ajuvalid = TRUE;
							$msgajuvalid = $msgajuvalid.$cell_ajuvalid." (KOLOM:[B".",".$row."]), ";
						}					
					}
					$cell_parsial = strtoupper($worksheet->getCellByColumnAndRow(23, $row)->getCalculatedValue());
					if($cell_parsial!=""){
						if(strtoupper(trim($cell_parsial))!="YA"){
							if(strtoupper(trim($cell_parsial))!="Y"){
								$PARSIALCEK = TRUE;
								$PARSIALCEKS = $PARSIALCEKS." - (KOLOM:[X".",".$row."]), ";
							}
						}
					}
					#cek nomor aju dah ada di db blum
					$cell_noaju = $this->replace_character($worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
					$cell_noaju = substr($cell_noaju, 0, 28);
					$this->db->reconnect();
					if($cell_noaju != ""){		
						if(substr($cell_tipe, 0, 4) == "BC27"){
							$BC = substr($cell_tipe, 0, 4);		
						}else{
							$BC = $cell_tipe;		
						}
						#CEK PARSIAL OR NOT
						if(strtoupper(trim($cell_parsial))!="YA"){
							if(strtoupper(trim($cell_parsial))!="Y"){								
								if($this->cek_noaju($cell_noaju, $BC)){
									$noaju = TRUE;
									$msgnoaju = $msgnoaju.$BC.": ".$cell_noaju." (KOLOM:[B".",".$row."]), ";
								}
							}else{
								if($this->cek_noaju($cell_noaju, $BC)){
									$noaju = TRUE;
									$msgnoaju = $msgnoaju.$BC.": ".$cell_noaju." (KOLOM:[B".",".$row."]), ";
								}
							}
						}
					}
					#cek nomor dok internal di DB
					$cell_nodok = $worksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();#echo $cell_nodok;die();
					$this->db->reconnect();
					if($cell_nodok != ""){		
						if(substr($cell_tipe, 0, 4) == "BC27"){
							$BC = substr($cell_tipe, 0, 4);		
						}else{
							$BC = $cell_tipe;		
						}
					
						if($this->cek_dok_internal($cell_nodok, $BC)){
							$nodok = TRUE;
							$msgnodok = $msgnodok.$BC.": ".$cell_nodok." (KOLOM:[I".",".$row."]), ";
						}
					}
					#cek nomor aju double di file					
					if($cell_noaju && $cell_nodok){
						#CEK PARSIAL OR NOT
						$pars = strtoupper(trim($cell_parsial));
						if($pars!="YA"){
							if($pars!="Y"){								
								if(in_array(trim($cell_noaju),$arrayNoAju,TRUE)){
									$duplicatAjuOnFile = TRUE;
									$msgnoajuDuplicat = $msgnoajuDuplicat.$cell_noaju." (KOLOM:[B".",".$row."]), ";
								}else{
									$arrayNoAju[] = $cell_noaju;	
								}	
							}
						}
						if(in_array(trim($cell_nodok),$arrayNoDok,TRUE)){
							$duplicatNoDokOnFile = TRUE;
							$msgNoDokDuplicat = $msgNoDokDuplicat.$cell_nodok." (KOLOM:[I".",".$row."]), ";
						}else{
							$arrayNoDok[] = $cell_nodok;	
						}	
						

					}
					#cek kpbc
					$cell_kpbc = $this->replace_character($worksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue());
					if($cell_kpbc){
						if(!in_array(trim($cell_kpbc),$datakpbc)){
							$kpbc = TRUE;
							$msgkpbc = $msgkpbc.$cell_kpbc." (KOLOM:[C".",".$row."]), ";
						}	
					}
					#cek valuta
					$cell_valuta = $this->replace_character($worksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue());
					if($cell_valuta){
						if(!in_array(trim($cell_valuta),$datavaluta)){
							$valuta = TRUE;
							$msgvaluta = $msgvaluta.$cell_valuta." (KOLOM:[K".",".$row."]), ";
						}	
					}
					#cek kode barang
					$cell_barang = $this->replace_kdbarang($worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue());
					$cell_jenis = $worksheet->getCellByColumnAndRow(17, $row)->getCalculatedValue();					
					#cek kode lokasi
					$cell_lokasi = $worksheet->getCellByColumnAndRow(24, $row)->getCalculatedValue();
					if($cell_lokasi){
						if(!in_array(trim($cell_lokasi),$kodelokasi)){
							$lokasi = TRUE;
							$msglokasi = $msglokasi.$cell_lokasi." (KOLOM:[Y".",".$row."]), ";
						}	
					}
					#cek gudang
					$cell_gudang = $this->replace_kdbarang($worksheet->getCellByColumnAndRow(21, $row)->getCalculatedValue());
					if(empty($cell_gudang)){
						$cell_gudang = 'UTAMA';
					}
					#cek kondisi
					$cell_kondisi = $this->replace_kdbarang($worksheet->getCellByColumnAndRow(22, $row)->getCalculatedValue());
					if(empty($cell_kondisi)){
						$cell_kondisi = 'BAIK';						
					}
					if($this->cekbarang($cell_barang,$cell_jenis,$cell_lokasi,$cell_gudang,$cell_kondisi)){
						$CELLLOK = "";
						if($cell_lokasi){
							$CELLLOK = " dan lokasi barang:".$cell_lokasi;
						}
						$barang = TRUE;
						$msgbarang = $msgbarang."Kode Barang: ".$cell_barang." dgn Jenis Barang: ".$cell_jenis.$CELLLOK.", di gudang ".$cell_gudang.", kondisi ".$cell_kondisi;
					}
					#cek jenis barang
					if($cell_jenis){
						if(!in_array(trim($cell_jenis),$datajenisbarang)){
							$jenisbarang = TRUE;
							$msgjenisbarang = $msgjenisbarang.$cell_jenis." (KOLOM:[R".",".$row."]), ";
						}
					}
					#cek satuan
					$cell_satuan = strtoupper($this->replace_character($worksheet->getCellByColumnAndRow(19, $row)->getCalculatedValue()));
					if($cell_satuan){
						if(!in_array(strtoupper($cell_satuan),$datasatuan)){
							$satuan = TRUE;
							$msgsatuan = $msgsatuan.$cell_satuan." (KOLOM:[T".",".$row."]), ";
						}
						
						if($cell_lokasi==""){
							$TEMPAT = "PUSAT";
						}else{
							$TEMPAT = $cell_lokasi;
						}
						
						$inarraysatuan = $this->upload_act->getDataParameter('barang',$cell_barang,$cell_jenis,$TEMPAT);	
						if($inarraysatuan){			
							$satbesar = $inarraysatuan[0]['KODE_BESAR'];
							$satkecil = $inarraysatuan[0]['KODE_KECIL'];
							if($satkecil=="") $sat = $satbesar;
							else $sat = $satbesar.' dan '.$satkecil;
							if(!in_array($cell_satuan,$inarraysatuan[0])){								
								$satuanbarang = TRUE;
								$msgsatuanbarang = $msgsatuanbarang.$cell_barang." = ".$sat." (KOLOM:[T".",".$row."]), ";
							}
						}
					}
					$cell_jumlah =(float)str_replace(",","",str_replace("'","",$worksheet->getCellByColumnAndRow(18,$row)->getCalculatedValue()));
					if(in_array(trim(strtoupper($cell_tipe)),array('BC30','BC25','BC27KELUAR','BC41','BC261'))){
						if(!$cell_lokasi) $cell_lokasi = 'PUSAT';
						$SQL ="SELECT a.STOCK_AKHIR, a.KODE_SATUAN, a.KODE_SATUAN_TERKECIL, a.JML_SATUAN_TERKECIL, b.JUMLAH FROM M_TRADER_BARANG a INNER JOIN M_TRADER_BARANG_GUDANG b ON a.KODE_BARANG=b.KODE_BARANG AND 
						a.KODE_BARANG='".$cell_barang."' AND a.JNS_BARANG=b.JNS_BARANG AND a.JNS_BARANG='".$cell_jenis."' 
						AND a.KODE_LOKASI=b.KODE_LOKASI AND a.KODE_TRADER=b.KODE_TRADER AND a.KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND a.KODE_LOKASI='".$cell_lokasi."'";
						$VAL=$this->db->query($SQL)->row(); 
						$STOCK_AKHIR = $VAL->STOCK_AKHIR;
						$JUMLAH_AKHIR = $VAL->JUMLAH;
						$KODE_SATUAN = $VAL->KODE_SATUAN;
						$KODE_SATUAN_TERKECIL = $VAL->KODE_SATUAN_TERKECIL;
						$JML_SATUAN_TERKECIL = $VAL->JML_SATUAN_TERKECIL;
						
						if($KODE_SATUAN_TERKECIL){
							if(strtoupper($cell_satuan)==strtoupper($KODE_SATUAN_TERKECIL)){
								$JUMSSATS = $cell_jumlah;
							}else{					
								if(empty($JML_SATUAN_TERKECIL)) $JML_SATUAN_TERKECIL=1;
								$JUMSSATS = $cell_jumlah * $JML_SATUAN_TERKECIL;
							}
						}else{
							$JUMSSATS = $cell_jumlah;	
						}
						$arraytemp[] = $cell_barang.'|#|'.$cell_jenis.'|#|'.$cell_lokasi.'|#|'.$cell_gudang.'|#|'.$cell_kondisi;
						$arraytemp_jumlah[$cell_barang.'|#|'.$cell_jenis.'|#|'.$cell_lokasi.'|#|'.$cell_gudang.'|#|'.$cell_kondisi]["jumlah"][] = $JUMSSATS;														
						$JUMAKHIR = array_sum($arraytemp_jumlah[$cell_barang."|#|".$cell_jenis.'|#|'.$cell_lokasi.'|#|'.$cell_gudang.'|#|'.$cell_kondisi]["jumlah"]);
	
						if($this->str2num((float)$JUMAKHIR) > $this->str2num((float)$JUMLAH_AKHIR)){ //aslanya STOCK_AKHIR
							$stock = TRUE;
							$msgstock = $msgstock."Kode Barang: ".$cell_barang." dgn Jenis Barang: ".$cell_jenis.", ";
						}
					}	
					if($this->replace_character($worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue())==""){
						break;	
					}					
				}
				if($kosong){
					$msg = "Terdapat data Detil Barang yang kosong, yaitu:<br> ".$msgkosong;	
					$error .= $this->fungsi->msg("error",$msg);		
				}
				if($ajukosong){
					$msg = "Terdapat data Header yang kosong, yaitu:<br> ".$msgajukosong;	
					$error .= $this->fungsi->msg("error",$msg);		
				}		
				if($duplicatAjuOnFile){
					$msg = "Terdapat Nomor Aju yang sama dalam file anda (* Nomor Aju yg dikenali 26 Digit), yaitu:<br> ".$msgnoajuDuplicat;
					$error .= $this->fungsi->msg("warning",$msg);	
				}
				if($duplicatNoDokOnFile){
					$msg = "Terdapat Nomor Bukti Penerimaan/Pengeluaran yang sama dalam file anda, yaitu:<br> ".$msgNoDokDuplicat;
					$error .= $this->fungsi->msg("warning",$msg);	
				}
				if($nodok){
					$msg ="Nomor Bukti Penerimaan/Pengeluaran sudah ada dalam database e-inkaber, yaitu:<br> ".$msgnodok;	
					$error .= $this->fungsi->msg("warning",$msg);	
				}			
				if($tipe){
					$msg ="Kode Dokumen tidak dikenali, yaitu:<br> ".$msgtipe;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($ajuvalid){
					$msg ="Nomor Aju hanya bisa berisi Numerik (angka), Terdapat Nomor Aju yang tidak valid, yaitu:<br> ".$msgajuvalid;	
					$error .= $this->fungsi->msg("warning",$msg);	
				}				
				if($noaju){
					$msg ="Nomor Aju sudah ada dalam database e-inkaber* (User anda atau user perusahaan lain), yaitu:<br> ".$msgnoaju;	
					$error .= $this->fungsi->msg("warning",$msg);	
				}	
					
				if($satuan){
					$msg ="Satuan tidak dikenali, yaitu:<br> ".$msgsatuan;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($satuanbarang){
					$msg ="Satuan tidak dikenali pada Kode Barang dan Jenis Barang ini,\nSatuan barang ini adalah:<br> ".$msgsatuanbarang;
					$error .= $this->fungsi->msg("warning",$msg);	
				}
				if($jenisbarang){
					$msg ="Jenis Barang tidak dikenali, yaitu:<br> ".$msgjenisbarang;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($barang){
					$msg ="Terdapat Kode barang yang tidak dikenali, yaitu:<br> ".$msgbarang;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($kpbc){
					$msg ="Terdapat Kode KPBC yang tidak dikenali, yaitu:<br> ".$msgkpbc;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($valuta){
					$msg ="Terdapat Kode Valuta yang tidak dikenali, yaitu:<br> ".$msgvaluta;
					$error .= $this->fungsi->msg("error",$msg);	
				}				
				if($stock){
					$msg ="Stock Barang tidak mencukupi (*perhatikan Jumlah konversi satuannya), yaitu:<br> ".$msgstock;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($lokasi){
					$msg ="Kode Lokasi tidak dikenali, yaitu:<br> ".$msglokasi;
					$error .= $this->fungsi->msg("error",$msg);
				}	
				if($PARSIALCEK){
					$msg ="Kode Parsial tidak dikenali, Silahkan isi 'YA/Y':<br> ".$PARSIALCEKS;
					$error .= $this->fungsi->msg("error",$msg);
				}		
				if($error){
					unlink($file);
					echo $this->load->view('upload/pabean_new',array("proses"=>"error","msg"=>$error),true);
					exit();
				}else{
					$proses = TRUE;
					$index = 0;
					$no = 1;
					$SERIARRAY = array();
					$NEXTSARRAY = array();
					$FIRSTLOOP = 0;
					for($row=2; $row <= $highestRow; $row++){
						$indexHeader = 0;
						$indexDetail = 0;
						if($worksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue()){
							$KDDOK = strtoupper($this->replace_character(str_replace(array(" ","."),array("",""),$worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue())));							
							$CAR = $this->replace_character($worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
							$TGL1 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(5,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL1,"/") === false){
								$TGL1 = $TGL1;
							}else{
								$TGL1 = $this->fungsi->dateformat($TGL1);
							}
							$TGL3 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(9,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL3,"/")===false){
								$TGL3 = date('Y-m-d',strtotime($TGL3));
							}else{
								$TGL3 = $this->fungsi->dateformat($TGL3);		
							}							
							$NODAFTAR = $worksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue();
							$PARSIAL = strtoupper($worksheet->getCellByColumnAndRow(23, $row)->getCalculatedValue());
							$NODOKINTERNAL = $worksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();
							$PEMASOK = $worksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
							if($row!=2){
								$no=1;
							}						
						}else{
							$X = $row-($row-($row-$no));
							$KDDOK = strtoupper($this->replace_character(str_replace(array(" ","."),array("",""),$worksheet->getCellByColumnAndRow(0, $X)->getCalculatedValue())));	
							$CAR = $this->replace_character($worksheet->getCellByColumnAndRow(1, $X)->getCalculatedValue());
							$TGL1 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(5, $X)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL1,"/") === false){
								$TGL1 = $TGL1;
							}else{
								$TGL1 = $this->fungsi->dateformat($TGL1);
							}
							$TGL3 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(9,$X)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL3,"/")===false){
								$TGL3 = date('Y-m-d',strtotime($TGL3));
							}else{
								$TGL3 = $this->fungsi->dateformat($TGL3);		
							}	
							$NODAFTAR = $worksheet->getCellByColumnAndRow(4, $X)->getCalculatedValue();
							$PARSIAL = strtoupper($worksheet->getCellByColumnAndRow(23, $X)->getCalculatedValue());
							$NODOKINTERNAL = $worksheet->getCellByColumnAndRow(8, $X)->getCalculatedValue();
							$PEMASOK = $worksheet->getCellByColumnAndRow(3, $X)->getCalculatedValue();
							$no++;
						}
						for($col=0; $col <=12; $col++){	
							if(trim($worksheet->getCellByColumnAndRow(0,$row)->getValue())){
							$TGL2 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(7,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL2,"/")===false){
								$TGL2 = $TGL2;	
							}else{
								$TGL2 = $this->fungsi->dateformat($TGL2);		
							}	
							$DATAHEADER[$index]['PARSIAL_FLAG'] = $PARSIAL;
							$DATAHEADER[$index]['TANGGAL_PENDAFTARAN'] = $TGL1;
							$DATAHEADER[$index]['TANGGAL_DOK_PABEAN'] = $TGL2;
							$DATAHEADER[$index]['TANGGAL_DOK_INTERNAL'] = $TGL3;
							$DATAHEADER[$index]['NOMOR_AJU'] = $CAR;
							$DATAHEADER[$index]['KODE_DOK'] = $KDDOK;
							$DATAHEADER[$index][$fieldHeader[$col]] = $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();														
							}
							$indexHeader++;
						}
						#NGECEK DATA SUDAH ADA BUAT SERI SELANJUTNYA
						if($FIRSTLOOP==0){
							if(substr($KDDOK,0,4)=="BC27"){
								$DOKUMEN1 = substr($KDDOK,0,4);		
							}else{
								$DOKUMEN1 = $KDDOK;
							}
							$SERIDTL = $this->main->get_uraian("SELECT MAX(SERI) AS MAX FROM T_".$DOKUMEN1."_DTL 
									   						    WHERE NOMOR_AJU='".$CAR."' AND KODE_TRADER='".$kodetrader."'", "MAX");								
							if($SERIDTL){
								$SER = $SERIDTL+1;
								$FIRSTLOOP++;
							}else{
								$SER = 1;
							}
						}else{
							$SER = 1;	
						}
						if(count(array_intersect(array($CAR), $SERIARRAY))>0){							
							$SERIAL = $NEXTSARRAY[$CAR]+1;					
						}else{		
							$SERIAL = $SER;						
						}		
						for($col=13; $col <= 20; $col++){	
							if($KDDOK!="KODEDOKUMEN"){
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								if($PARSIAL == "YA" || $PARSIAL == "Y"){									
									if($col == 13){
										$SERIAL = $worksheet->getCellByColumnAndRow($col, $row);
									}
								}
								//kolom 13,row
								//jika parsial = ya, seri mengikuti kolom N pada excel
								$DATADETAIL[$index]['PARSIAL_FLAG'] = $PARSIAL;
								$DATADETAIL[$index]['NOMOR_AJU'] = $CAR;
								$DATADETAIL[$index]['KODE_DOK'] = $KDDOK;
								$DATADETAIL[$index]['KODE_BARANG'] = $this->replace_kdbarang($worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue());	
								$DATADETAIL[$index]['SERI'] = $SERIAL;	
								$DATADETAIL[$index][$fieldDetil[$indexDetail]] = $cell->getCalculatedValue();
								$DATAINOUT[$index]['PARSIAL_FLAG'] = $PARSIAL;
								$DATAINOUT[$index]['NOMOR_AJU'] = $CAR;
								$DATAINOUT[$index]['KODE_DOK'] = $KDDOK;
								$DATAINOUT[$index]['TANGGAL_DOKUMEN'] = $TGL1;
								$DATAINOUT[$index]['TANGGAL'] = $TGL3;
								$DATAINOUT[$index]['TANGGAL_PENDAFTARAN'] = $TGL1;
								$DATAINOUT[$index]['NOMOR_PENDAFTARAN'] = $NODAFTAR;
								$DATAINOUT[$index]['KODE_BARANG'] = $this->replace_kdbarang($worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue());	
								$DATAINOUT[$index]['SERI'] = $SERIAL;	
								$DATAINOUT[$index][$fieldInOut[$indexDetail]] = $cell->getCalculatedValue();

								if($worksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue()){	
									if($index>0){
										$recordparsial = true;
									}
								}
								if($recordparsial){
									$DATAPARSIAL[$index]['PARSIAL_FLAG'] = $PARSIAL;
									$DATAPARSIAL[$index]['NOMOR_AJU'] = $CAR;
									$DATAPARSIAL[$index]['KODE_DOK'] = $KDDOK;		
									$DATAPARSIAL[$index]['TANGGAL_PENDAFTARAN'] = $TGL1;
									$DATAPARSIAL[$index]['TANGGAL'] = $TGL3;
									$DATAPARSIAL[$index]['NOMOR_PENDAFTARAN'] = $NODAFTAR;
									$DATAPARSIAL[$index]["NO_DOK_INTERNAL"] =  $NODOKINTERNAL;
									$DATAPARSIAL[$index]['TGL_DOK_INTERNAL'] = $TGL3;
									$DATAPARSIAL[$index]['NAMA_TRADER'] = $PEMASOK;	
									$DATAPARSIAL[$index]['KODE_BARANG'] = $this->replace_kdbarang($worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue());	
									$DATAPARSIAL[$index]['SERI'] = $SERIAL;	
									$DATAPARSIAL[$index][$fieldInOut[$indexDetail]] = $cell->getCalculatedValue();
								}
								$indexDetail++;		
							}
						}
						$index++;
						$SERIARRAY[] = $CAR;
						$NEXTSARRAY[$CAR] = $SERIAL;
						if($this->replace_character($worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue())==""){
							break;	
						}	
					}					
					if($proses){
						$this->db->reconnect();
						$query = "SELECT KODE_ID, ID, NAMA, ALAMAT, TELEPON, FAX, TIPE_TRADER, JENIS_TPB, BIDANG_USAHA, 
								  KODE_API, NOMOR_API, NOMOR_SRP, NIPER, NAMA_TTD, KOTA_TTD FROM M_TRADER 
								  WHERE KODE_TRADER=".$this->newsession->userdata('KODE_TRADER');	  		
						$rstrader=$this->db->query($query)->row(); 
						foreach($DATAHEADER as $VALHEADER){	
							unset($PROCESSHEADER);
							if(substr($VALHEADER["KODE_DOK"],0,4)=="BC27"){
								$DOKBC = substr($VALHEADER["KODE_DOK"],0,4);		
							}else{
								$DOKBC = $VALHEADER["KODE_DOK"];		
							}
							if($VALHEADER["PARSIAL_FLAG"]=="YA"||$VALHEADER["PARSIAL_FLAG"]=="Y"){
								$FLAG = "Y";
							}
							if($VALHEADER["NDPBM"]=="-"){
								$VALHEADER["NDPBM"] = NULL;
							}
							$PROCESSHEADER["PARSIAL_FLAG"] = $VALHEADER["PARSIAL_FLAG"];
							$PROCESSHEADER["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
							$PROCESSHEADER["NOMOR_AJU"] = $VALHEADER["NOMOR_AJU"];
							$PROCESSHEADER["NOMOR_PENDAFTARAN"] = $VALHEADER["NOMOR_PENDAFTARAN"];
							$PROCESSHEADER["TANGGAL_PENDAFTARAN"] = $VALHEADER["TANGGAL_PENDAFTARAN"];
							$PROCESSHEADER["NOMOR_DOK_PABEAN"] = (string)$VALHEADER["NOMOR_DOK_PABEAN"];
							$PROCESSHEADER["TANGGAL_DOK_PABEAN"] = $VALHEADER["TANGGAL_DOK_PABEAN"];
							$PROCESSHEADER["TANGGAL_DOK_PABEAN"] = $VALHEADER["TANGGAL_DOK_PABEAN"];
							$PROCESSHEADER["NOMOR_DOK_INTERNAL"] = (string)$VALHEADER["NOMOR_DOK_INTERNAL"];
							$PROCESSHEADER["TANGGAL_DOK_INTERNAL"] = $VALHEADER["TANGGAL_DOK_INTERNAL"];
							$PROCESSHEADER["KODE_VALUTA"] = (string)$VALHEADER["KODE_VALUTA"];
							$PROCESSHEADER["NDPBM"] = $VALHEADER["NDPBM"]?$VALHEADER["NDPBM"]:'0';
							$PROCESSHEADER["JUMLAH_DTL"] = $VALHEADER["JUMLAH_DTL"];
							$PROCESSHEADER["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
							$PROCESSHEADER["CREATED_BY"]= $this->newsession->userdata('USER_ID');
							if($DOKBC=="BC27"){
								$TIPE_DOK = strtoupper(substr(str_replace(" ","",$VALHEADER["KODE_DOK"]),4,strlen(str_replace(" ","",$VALHEADER["KODE_DOK"]))-1));
								$PROCESSHEADER["KODE_KPBC_ASAL"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER['TIPE_DOK'] = $TIPE_DOK; 
								if($TIPE_DOK=="MASUK"){
									$PROCESSHEADER["NAMA_TRADER_ASAL"] = (string)$VALHEADER["NAMA_PEMASOK"];	
									$PROCESSHEADER["KODE_ID_TRADER_TUJUAN"] = $rstrader->KODE_ID;
									$PROCESSHEADER["ID_TRADER_TUJUAN"] = $rstrader->ID;
									$PROCESSHEADER["NAMA_TRADER_TUJUAN"] = $rstrader->NAMA;
									$PROCESSHEADER["ALAMAT_TRADER_TUJUAN"] = $rstrader->ALAMAT;
									$PROCESSHEADER["NOMOR_IZIN_TPB_TUJUAN"] = $rstrader->NIPER;
								}
								elseif($TIPE_DOK=="KELUAR"){	
									$PROCESSHEADER["NAMA_TRADER_TUJUAN"] = $VALHEADER["NAMA_PEMASOK"];		
									$PROCESSHEADER["KODE_ID_TRADER_ASAL"] = $rstrader->KODE_ID;
									$PROCESSHEADER["ID_TRADER_ASAL"] = $rstrader->ID;
									$PROCESSHEADER["NAMA_TRADER_ASAL"] = $rstrader->NAMA;
									$PROCESSHEADER["ALAMAT_TRADER_ASAL"] = $rstrader->ALAMAT;
									$PROCESSHEADER["NOMOR_IZIN_TPB_ASAL"] = $rstrader->NIPER;
								}							
							}
							elseif($DOKBC=='BC30'){
								$PROCESSHEADER["KODE_ID_TRADER"] = $rstrader->KODE_ID;
								$PROCESSHEADER["ID_TRADER"]	= $rstrader->ID;
								$PROCESSHEADER["NAMA_TRADER"] = $rstrader->NAMA;	
								$PROCESSHEADER["ALAMAT_TRADER"] = $rstrader->ALAMAT;		
								$PROCESSHEADER["KODE_KPBC"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["STATUS_TRADER"]	= $rstrader->TIPE_TRADER;
								$PROCESSHEADER["NIPER"]	= $rstrader->NIPER;
								$PROCESSHEADER["NAMA_PEMBELI"] = $VALHEADER["NAMA_PEMASOK"];
							}
							elseif($DOKBC=='BC23'){
								$PROCESSHEADER["KODE_ID_TRADER"] = $rstrader->KODE_ID;
								$PROCESSHEADER["ID_TRADER"]	= $rstrader->ID;
								$PROCESSHEADER["NAMA_TRADER"] = $rstrader->NAMA;	
								$PROCESSHEADER["ALAMAT_TRADER"] = $rstrader->ALAMAT;	
								$PROCESSHEADER["KODE_KPBC"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["STATUS_TRADER"]	= $rstrader->TIPE_TRADER;	
								$PROCESSHEADER["KODE_API"] = $rstrader->KODE_API;	
								$PROCESSHEADER["NOMOR_API"] = $rstrader->NOMOR_API;
								$PROCESSHEADER["KODE_TPB"] = $rstrader->JENIS_TPB;
								$PROCESSHEADER["NAMA_PEMASOK"] = (string)$VALHEADER["NAMA_PEMASOK"];	
							}
							elseif($DOKBC=='BC25'||$DOKBC=='BC261'||$DOKBC=='BC41'){
								$PROCESSHEADER["KODE_ID_TRADER"] = $rstrader->KODE_ID;
								$PROCESSHEADER["ID_TRADER"]	= $rstrader->ID;
								$PROCESSHEADER["NAMA_TRADER"] = $rstrader->NAMA;	
								$PROCESSHEADER["ALAMAT_TRADER"] = $rstrader->ALAMAT;	
								$PROCESSHEADER["KODE_KPBC"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["NOMOR_IZIN_TPB"] = $rstrader->NIPER;
								$PROCESSHEADER["NAMA_PENERIMA"] = $VALHEADER["NAMA_PEMASOK"];
								$PROCESSHEADER["JENIS_TPB"] = $rstrader->JENIS_TPB;	
							}
							elseif($DOKBC=='BC262'||$DOKBC=='BC40'){
								$PROCESSHEADER["KODE_KPBC"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["NOMOR_IZIN_TPB"] = $rstrader->NIPER;
								$PROCESSHEADER["NAMA_PENGIRIM"] = (string)$VALHEADER["NAMA_PEMASOK"];	
							}
							if($VALHEADER["PARSIAL_FLAG"]=="YA"||$VALHEADER["PARSIAL_FLAG"]=="Y"){
								$SQL = "SELECT NOMOR_AJU FROM T_".$DOKBC."_HDR WHERE NOMOR_AJU='".$VALHEADER["NOMOR_AJU"]."' 
										AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; 
								$rs = $this->db->query($SQL);
								if($rs->num_rows()==0){
									$execheader = $this->db->insert("T_".$DOKBC."_HDR",$PROCESSHEADER);		
									$this->main->activity_log('ADD HEADER '.$DOKBC,'CAR='.$VALHEADER["NOMOR_AJU"].', PARSIAL');
								}else{
									$execheader = true;	
								}
							}else{
								$execheader = $this->db->insert("T_".$DOKBC."_HDR",$PROCESSHEADER);
								$this->main->activity_log('ADD HEADER '.$DOKBC,'CAR='.$VALHEADER["NOMOR_AJU"],'UPLOAD');
								
							}
						}
						if($execheader){
							foreach($DATADETAIL as $VALDETAIL){		
								unset($PROCESSDETIL);										
								$PROCESSDETIL["NOMOR_AJU"] = $VALDETAIL["NOMOR_AJU"];								
								$PROCESSDETIL["KODE_BARANG"] = $this->replace_kdbarang($VALDETAIL["KODE_BARANG"]);
								$PROCESSDETIL["KODE_HS"] = $VALDETAIL["KODE_HS"];
								$PROCESSDETIL["JUMLAH_SATUAN"] = $VALDETAIL["JUMLAH_SATUAN"];
								$PROCESSDETIL["KODE_SATUAN"] = strtoupper((string)$VALDETAIL["KODE_SATUAN"]);
								if(substr($VALDETAIL["KODE_DOK"],0,4)=="BC27"){
									$DOKBC = substr($VALDETAIL["KODE_DOK"],0,4);		
								}else{
									$DOKBC = $VALDETAIL["KODE_DOK"];		
								}		
								$PROCESSDETIL["SERI"] = $VALDETAIL["SERI"];
								if($DOKBC=="BC23"){
									$PROCESSDETIL["CIF"] = $VALDETAIL["CIF"];	
									$PROCESSDETIL["JENIS_BARANG"] = $VALDETAIL["JENIS_BARANG"];
									$PROCESSDETIL["URAIAN_BARANG"] = str_replace("'","",str_replace('"','',$VALDETAIL["URAIAN_BARANG"]));		
								}
								elseif($DOKBC=="BC30"){
									$PROCESSDETIL["INVOICE"] = $VALDETAIL["CIF"];				
									$PROCESSDETIL["FOB_PER_BARANG"] = $VALDETAIL["CIF"];
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];	
									$PROCESSDETIL['URAIAN_BARANG1'] = str_replace("'","",str_replace('"','',$VALDETAIL["URAIAN_BARANG"]));
								}
								elseif($DOKBC=="BC40"||$DOKBC=="BC41"||$DOKBC=="BC27"){
									$PROCESSDETIL["HARGA_PENYERAHAN"] = $VALDETAIL["CIF"];	
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];
									$PROCESSDETIL["URAIAN_BARANG"] = str_replace("'","",str_replace('"','',$VALDETAIL["URAIAN_BARANG"]));	
								}
								else{
									$PROCESSDETIL["CIF"] = $VALDETAIL["CIF"];	
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];	
									$PROCESSDETIL["URAIAN_BARANG"] = str_replace("'","",str_replace('"','',$VALDETAIL["URAIAN_BARANG"]));	
								}
								$PROCESSDETIL["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
								$PROCESSDETIL["STATUS"]="04";
								if($DOKBC == "BC23"){
									$JNS_BARANG = "JENIS_BARANG = '".$PROCESSDETIL['JENIS_BARANG']."' ";
								}else{
									$JNS_BARANG = "JNS_BARANG = '".$PROCESSDETIL['JNS_BARANG']."' ";
								}
								$sqlcek = "SELECT NOMOR_AJU , JUMLAH_SATUAN FROM T_".$DOKBC."_DTL 
										WHERE KODE_TRADER = '".$kodetrader."' 
										AND NOMOR_AJU = '".$PROCESSDETIL["NOMOR_AJU"]."' 
										AND SERI = '".$PROCESSDETIL["SERI"]."' 
										AND KODE_BARANG = '".$PROCESSDETIL["KODE_BARANG"]."' 
										AND ".$JNS_BARANG." ";
								$res = $this->db->query($sqlcek);
								if($res->num_rows() > 0){
									if($PARSIAL == "YA"||$PARSIAL == "Y"){
										$objData = $res->row();
										$currentJumlah = $objData->JUMLAH_SATUAN;									
										$sqlUpludeJml = "UPDATE T_".$DOKBC."_DTL SET JUMLAH_SATUAN = ".$currentJumlah." + 
														".$VALDETAIL["JUMLAH_SATUAN"]."
														 WHERE KODE_TRADER = '".$kodetrader."' AND NOMOR_AJU = '".$VALDETAIL['NOMOR_AJU']."' 
														AND SERI = '".$VALDETAIL['SERI']."' ";
										$execdetil = $this->db->query($sqlUpludeJml);
									} else {
										$msg ="Duplikat Enty :<br> Nomor aju:".$VALDETAIL['NOMOR_AJU']." ,SERI:".$VALDETAIL['SERI'].", Kode barang:".$PROCESSDETIL["KODE_BARANG"].", Jenis barang:".$PROCESSDETIL["JNS_BARANG"]." ";
										$error .= $this->fungsi->msg("error",$msg);	
										unlink($file);
										echo $this->load->view('upload/pabean_new',array("proses"=>"error","msg"=>$error),true);
										exit();
									}
								}else{
									if($PARSIAL == "YA"||$PARSIAL == "Y"){
										//kasih pesan error duplikat
										$SQLcekDtl = "SELECT NOMOR_AJU , SERI, KODE_TRADER FROM T_".$DOKBC."_DTL 
										WHERE KODE_TRADER = '".$kodetrader."' AND NOMOR_AJU = '".$PROCESSDETIL["NOMOR_AJU"]."' 
										AND SERI = '".$PROCESSDETIL["SERI"]."' ";
										$cekDtl = $this->db->query($SQLcekDtl);										
										if($cekDtl->num_rows() > 0){
											$msg ="Duplikat Enty :<br> Nomor aju:".$VALDETAIL['NOMOR_AJU']." ,SERI:".$VALDETAIL['SERI'].", Kode barang:".$PROCESSDETIL["KODE_BARANG"].", Jenis barang:".$PROCESSDETIL["JNS_BARANG"]." ";
											$error .= $this->fungsi->msg("error",$msg);
											unlink($file);
											echo $this->load->view('upload/pabean_new',array("proses"=>"error","msg"=>$error),true);
											exit();
										}else{
											$execdetil = $this->db->insert("T_".$DOKBC."_DTL",$PROCESSDETIL);
											$this->main->activity_log('ADD DETIL '.$DOKBC,'CAR='.$VALDETAIL["NOMOR_AJU"].', SERI='.$VALDETAIL["SERI"],'UPLOAD');
										}										
									}else{
										$execdetil = $this->db->insert("T_".$DOKBC."_DTL",$PROCESSDETIL);
										$this->main->activity_log('ADD DETIL '.$DOKBC,'CAR='.$VALDETAIL["NOMOR_AJU"].', SERI='.$VALDETAIL["SERI"],'UPLOAD');
									}
								}
							}
						}
						if($execdetil){
							foreach($DATAHEADER as $VALHEAD){	
								if(substr($VALHEAD["KODE_DOK"],0,4)=="BC27"){
									$DOKBC = substr($VALHEAD["KODE_DOK"],0,4);		
								}else{
									$DOKBC = $VALHEAD["KODE_DOK"];		
								}	
								$this->db->where('NOMOR_AJU',$VALHEAD["NOMOR_AJU"]);
								$JUMLAH_DTL = $this->db->count_all_results("T_".$DOKBC."_DTL");
								if(strtoupper($DOKBC)=="BC27"){								
									$SQL = "SELECT f_jumcif_bc27('".$VALHEAD["NOMOR_AJU"]."','".$this->newsession->userdata('KODE_TRADER')."') AS JUM,
										 f_jumhrg_serah_bc27('".$VALHEAD["NOMOR_AJU"]."','".$this->newsession->userdata('KODE_TRADER')."') AS JUMHRG FROM DUAL";	
								}
								elseif(strtoupper($DOKBC)=="BC40"){	
									$SQL = "SELECT f_jumcif_".strtolower($DOKBC)."('".$VALHEAD["NOMOR_AJU"]."','".$this->newsession->userdata('KODE_TRADER')."') AS JUM FROM DUAL";	
								}else{
									$SQL = "SELECT f_jumcif_".strtolower($DOKBC)."('".$VALHEAD["NOMOR_AJU"]."') AS JUM FROM DUAL";	
								}
								$rs = $this->db->query($SQL)->row();		
								if($DOKBC=="BC30"){
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"],'KODE_TRADER'=>$this->newsession->userdata('KODE_TRADER')));
									$this->db->update("T_".$DOKBC."_HDR",array("FOB"=>$rs->JUM,"JUMLAH_DTL"=>$JUMLAH_DTL));	
								}elseif($DOKBC=="BC40"||$DOKBC=="BC41"){		
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"],'KODE_TRADER'=>$this->newsession->userdata('KODE_TRADER')));
									$this->db->update("T_".$DOKBC."_HDR",array("HARGA_PENYERAHAN"=>$rs->JUM,"JUMLAH_DTL"=>$JUMLAH_DTL));										
								}elseif($DOKBC=="BC27"){		
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"],'KODE_TRADER'=>$this->newsession->userdata('KODE_TRADER')));
									$this->db->update("T_".$DOKBC."_HDR",array("HARGA_PENYERAHAN"=>$rs->JUMHRG,"CIF"=>$rs->JUM,"JUMLAH_DTL"=>$JUMLAH_DTL));																		
								}else{		
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"],'KODE_TRADER'=>$this->newsession->userdata('KODE_TRADER')));
									$this->db->update("T_".$DOKBC."_HDR",array("CIF"=>$rs->JUM,"JUMLAH_DTL"=>$JUMLAH_DTL));	
								}
							}		
						}
						if($execdetil){		
							$INDEXPARSIAL=0;					
							foreach($DATAINOUT as $VALINOUT){	
								unset($PROCESSINOUT);	
								if($VALINOUT['NOMOR_PENDAFTARAN']!="" && $VALINOUT['TANGGAL_PENDAFTARAN']!=""){
									$KODE_DOK = strtoupper(str_replace(" ","",trim($VALINOUT["KODE_DOK"])));
  									if($KODE_DOK=="BC23"||$KODE_DOK=="BC262"||$KODE_DOK=="BC40"||$KODE_DOK=="BC27MASUK"){
										$PROCESSINOUT["TIPE"] = "GATE-IN";  
									}
									elseif($KODE_DOK=="BC25"||$KODE_DOK=="BC261"||$KODE_DOK=="BC41"||$KODE_DOK=="BC27KELUAR"||$KODE_DOK=="BC30"){
										$PROCESSINOUT["TIPE"] = "GATE-OUT"; 	
									}
									if(substr($VALINOUT["KODE_DOK"],0,4)=="BC27"){
										$DOKBC = substr($VALINOUT["KODE_DOK"],0,4);		
									}else{
										$DOKBC = $VALINOUT["KODE_DOK"];		
									}
									if($VALINOUT['KODE_LOKASI']==""){
										$VALINOUT['KODE_LOKASI']="PUSAT";
									}
									$SQL2="SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
										   FROM M_TRADER_BARANG WHERE KODE_BARANG='".$VALINOUT["KODE_BARANG"]."' 
										   AND JNS_BARANG='".$VALINOUT["JNS_BARANG"]."' 
										   AND KODE_LOKASI='".$VALINOUT["KODE_LOKASI"]."' 
										   AND KODE_TRADER=".$this->newsession->userdata('KODE_TRADER');
										   
						   			$VALBRG=$this->db->query($SQL2)->row(); 
									$STOCK_AKHIR = $VALBRG->STOCK_AKHIR;
									$kdsatuanBesar = $VALBRG->KODE_SATUAN;
									$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
									$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
									
									if($kdsatuanKecil){
										if(strtoupper($VALINOUT['KODE_SATUAN'])==strtoupper($kdsatuanKecil)){
											$JUMLAH_BARANG = $VALINOUT['JUMLAH'];
										}else{					
											if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
											$JUMLAH_BARANG = $VALINOUT['JUMLAH'] * $jmlsatuanKecil;
										}
									}else{
										$JUMLAH_BARANG = $VALINOUT['JUMLAH'];
									}
									
									$PROCESSINOUT["PROCESS_WITH"] = "UPLOAD";	
									$PROCESSINOUT["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');	
									$PROCESSINOUT["KODE_BARANG"] = $this->replace_kdbarang($VALINOUT['KODE_BARANG']);
									$PROCESSINOUT["JNS_BARANG"] = $VALINOUT['JNS_BARANG'];
									$PROCESSINOUT["KODE_DOKUMEN"] = $DOKBC;
									$PROCESSINOUT["TANGGAL_DOKUMEN"] = $VALINOUT['TANGGAL_PENDAFTARAN'];
									$PROCESSINOUT["NOMOR_AJU"] = $VALINOUT['NOMOR_AJU'];
									$PROCESSINOUT["JUMLAH"] = $JUMLAH_BARANG;
									$PROCESSINOUT["TANGGAL"] = $VALINOUT['TANGGAL'];
									$PROCESSINOUT["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
									$PROCESSINOUT["KODE_LOKASI"]= $VALINOUT['KODE_LOKASI'];
									
									$this->db->where(array("KODE_BARANG"=>$VALINOUT['KODE_BARANG'],
														   "JNS_BARANG"=>$VALINOUT['JNS_BARANG'],
														   "KODE_TRADER"=>$this->newsession->userdata('KODE_TRADER'),
														   "KODE_LOKASI"=>$VALINOUT['KODE_LOKASI']));														   				    
									$STKLOG = "";
									if($PROCESSINOUT["TIPE"]=="GATE-IN"){	
										$exec = $this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$STOCK_AKHIR+$JUMLAH_BARANG));	
										#update stock barang gudang
										$sqlUpdate = "UPDATE M_TRADER_BARANG_GUDANG 
													SET JUMLAH = JUMLAH + ".$JUMLAH_BARANG.
													" WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'
													AND KODE_BARANG = '".$VALINOUT['KODE_BARANG']."'
													AND JNS_BARANG = '". $VALINOUT['JNS_BARANG']."'
													AND KODE_LOKASI = '".$VALINOUT['KODE_LOKASI']."'";
										$this->db->query($sqlUpdate);
										 
										$STKLOG = $STOCK_AKHIR+$JUMLAH_BARANG;
										$this->main->activity_log('UPDATE STOCK AKHIR BARANG','REALISASI PEMASUKAN '.$DOKBC.' CAR='.$VALINOUT['NOMOR_AJU'].', KODE_BARANG='.$VALINOUT['KODE_BARANG'].', JNS_BARANG='.$VALINOUT['JNS_BARANG'].', JUMLAH MASUK='.$JUMLAH_BARANG.', JUMLAH SEBELUM='.$STOCK_AKHIR.', STOCK AKHIR='.$STKLOG,'UPLOAD');
									}
									else if($PROCESSINOUT["TIPE"]=="GATE-OUT"){	
										$exec = $this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$STOCK_AKHIR-$JUMLAH_BARANG));
										#update stock barang gudang
										$sqlUpdate = "UPDATE M_TRADER_BARANG_GUDANG 
													SET JUMLAH = JUMLAH - ".$JUMLAH_BARANG.
													" WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'
													AND KODE_BARANG = '".$VALINOUT['KODE_BARANG']."'
													AND JNS_BARANG = '". $VALINOUT['JNS_BARANG']."'
													AND KODE_LOKASI = '".$VALINOUT['KODE_LOKASI']."'";
										$this->db->query($sqlUpdate);
										
										$STKLOG = $STOCK_AKHIR-$JUMLAH_BARANG;
										$this->main->activity_log('UPDATE STOCK AKHIR BARANG','REALISASI PENGELUARAN '.$DOKBC.' CAR='.$VALINOUT['NOMOR_AJU'].', KODE_BARANG='.$VALINOUT['KODE_BARANG'].', JNS_BARANG='.$VALINOUT['JNS_BARANG'].', JUMLAH KELUAR='.$JUMLAH_BARANG.', JUMLAH SEBELUM='.$STOCK_AKHIR.', STOCK AKHIR='.$STKLOG,'UPLOAD');
									}	
									if($exec){
										$SQL = "SELECT TANGGAL_REALISASI, STATUS FROM T_".$DOKBC."_HDR 
												WHERE NOMOR_AJU='".$VALINOUT["NOMOR_AJU"]."' 
												AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
										$rs=$this->db->query($SQL)->row(); 
										if($rs->TANGGAL_REALISASI!="" && $rs->STATUS=="07"){								
											$exechdr = true;
										}else{
											$this->db->where(array("NOMOR_AJU"=>$VALINOUT['NOMOR_AJU'],"KODE_TRADER"=>$this->newsession->userdata('KODE_TRADER')));
											$DATAHDR = array("STATUS"=>"07","TANGGAL_REALISASI"=>$VALINOUT['TANGGAL']);
											$exechdr = $this->db->update("T_".$DOKBC."_hdr",$DATAHDR);
										}	
										if($exechdr){
											$seriInOut = (int)$this->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_barang_inout", "MAX") + 1;
											$PROCESSINOUT["SERI"] = $seriInOut;
											$PROCESSINOUT["SERI_DOK_PABEAN"] = $VALINOUT["SERI"];
											$execfinal = $this->db->insert("m_trader_barang_inout",$PROCESSINOUT);																			
										}																			
									}								
								}else{
									$execfinal = true;	
								}								
								
							}
						}
						if($execfinal){
							#============PARSIAL========================================================================
							$NEXTID=1;
							foreach($DATAPARSIAL as $VALPARSIAL){															
								if($VALPARSIAL["PARSIAL_FLAG"]=="YA"||$VALPARSIAL["PARSIAL_FLAG"]=="Y"){
									if($VALPARSIAL['NOMOR_PENDAFTARAN']!="" && $VALPARSIAL['TANGGAL_PENDAFTARAN']!=""){																							
										if(substr(strtoupper($VALPARSIAL["KODE_DOK"]),0,4)=="BC27"){
											$DOKBC = substr($VALPARSIAL["KODE_DOK"],0,4);		
										}else{
											$DOKBC = $VALPARSIAL["KODE_DOK"];		
										}	
										$SQL = "SELECT REALISASIID FROM t_realisasi_parsial_hdr 
												WHERE NOMOR_AJU='".$VALPARSIAL["NOMOR_AJU"]."' 
												AND JENIS_DOK='".$DOKBC."'
												AND NO_DOK_INTERNAL='".$VALPARSIAL["NO_DOK_INTERNAL"]."' 
												AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
										$rs = $this->db->query($SQL);
										if($rs->num_rows()>0){
											$data = $rs->row(); 
											$RELID = $data->REALISASIID;
											$DETIL["HDR_REFF"] = $RELID;	
											$DETIL["KODE_BARANG"] = $this->replace_kdbarang($VALPARSIAL["KODE_BARANG"]);
											$DETIL["NOMOR_AJU"] = $VALPARSIAL["NOMOR_AJU"];
											$DETIL["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];	
											$DETIL["SATUAN"] = strtoupper($VALPARSIAL["KODE_SATUAN"]);	
											$DETIL["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
											$DETIL["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
											//$DETIL["SERI_BARANG"] = $this->update_seri_pabean($DOKBC,$VALPARSIAL["KODE_BARANG"],$VALPARSIAL["JNS_BARANG"],$VALPARSIAL["NOMOR_AJU"]);
											$DETIL["SERI_BARANG"] = $VALPARSIAL["SERI"];

											$this->db->insert('t_realisasi_parsial_dtl',$DETIL);
										}else{	
											$RELID = $this->newsession->userdata('USER_ID').date('ymdHis').sprintf("%06d", $NEXTID);
											$HEADER["REALISASIID"] = $RELID;
											$HEADER["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
											$HEADER["NOMOR_AJU"] = $VALPARSIAL["NOMOR_AJU"];
											$HEADER["JENIS_DOK"] = $DOKBC;
											$HEADER["NO_DOK_INTERNAL"] = $VALPARSIAL["NO_DOK_INTERNAL"];	
											$HEADER["TGL_DOK_INTERNAL"] = $VALPARSIAL["TGL_DOK_INTERNAL"];	
											$HEADER["TGL_REALISASI"] = $VALPARSIAL['TANGGAL'];
											$HEADER["NAMA_TRADER"] = (string)$VALPARSIAL['NAMA_TRADER'];
											$HEADER["TGL_TRANSAKSI"] = date('Y-m-d H:m:s');
											if($this->db->insert('t_realisasi_parsial_hdr',$HEADER)){											
												$DETIL["HDR_REFF"] = $RELID;	
												$DETIL["KODE_BARANG"] = $this->replace_kdbarang($VALPARSIAL["KODE_BARANG"]);
												$DETIL["NOMOR_AJU"] = $VALPARSIAL["NOMOR_AJU"];
												$DETIL["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];	
												$DETIL["SATUAN"] = strtoupper($VALPARSIAL["KODE_SATUAN"]);	
												$DETIL["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
												$DETIL["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
												//$DETIL["SERI_BARANG"] = $this->update_seri_pabean($DOKBC,$VALPARSIAL["KODE_BARANG"],$VALPARSIAL["JNS_BARANG"],$VALPARSIAL["NOMOR_AJU"]);
												$DETIL["SERI_BARANG"] = $VALPARSIAL["SERI"];
												$this->db->insert('t_realisasi_parsial_dtl',$DETIL);
											}
											$NEXTID++;	
										}
									}
								}
							}
							#==========================================================================================	
						}
						
						if($this->db->trans_status()===FALSE){
							$this->db->trans_rollback();
							$error = $this->fungsi->msg("error","Data Gagal diproses");	 
						}else{
							$this->db->trans_commit();
							if($execfinal){
								$sukses = $this->fungsi->msg("done","Data Berhasil diproses");	
							}else{
								$error = $this->fungsi->msg("error","Data Gagal diproses");	 
							}
							# menambahkan data header, dokumen, dan kemasan
							if ($sukses) {
								$kodeTrader = $this->newsession->userdata('KODE_TRADER');
								# additional header
								if (count($addHeader) > 0) {
									$arrTujuan = array('1', '2', '3', '4', '5', '6', '7', '8');
									$arrTujuanKirim = array('01', '02', '03', '04', '05', '06', '07', '08', '09');
									$moda = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
									$pemasok = $this->upload_act->getDataKodeUpload('pemasok');
									$pelabuhan = $this->upload_act->getDataKodeUpload('pelabuhan');
									$timbun = $this->upload_act->getDataKodeUpload('timbun');
									foreach ($addHeader as $dataHdr) {
										$kode_dokumen = strtoupper($dataHdr['KODE_DOK']);
										if ($kode_dokumen == 'BC27MASUK' || $kode_dokumen == 'BC27KELUAR') {
											$bc = 'bc27';
											$sqlSelect = "SELECT NOMOR_AJU, TIPE_DOK FROM t_" . $bc . "_hdr 
														WHERE KODE_TRADER = '" . $kodeTrader . "'
														AND NOMOR_AJU = '" . $dataHdr['NOMOR_AJU'] . "'";
											$doSelect = $this->db->query($sqlSelect);
											$rowHdr = $doSelect->row();
											$tipeDok = $rowHdr->TIPE_DOK;
										} else {
											$bc = strtolower($kode_dokumen);
											$sqlSelect = "SELECT NOMOR_AJU FROM t_" . $bc . "_hdr 
														WHERE KODE_TRADER = '" . $kodeTrader . "'
														AND NOMOR_AJU = '" . $dataHdr['NOMOR_AJU'] . "'";
											$doSelect = $this->db->query($sqlSelect);
										}
										if ($doSelect->num_rows() > 0) {
											$cancel = false;
								            if ($bc == 'bc23') {
								            	if (!in_array($dataHdr['KODE_KPBC_BONGKAR'], $datakpbc)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['KPBC_PENGAWAS'], $datakpbc)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['TUJUAN'], $arrTujuan)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['TUJUAN_KIRIM'], $arrTujuanKirim)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['MODA'], $moda)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['PELABUHAN_MUAT'], $pelabuhan)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['PELABUHAN_BONGKAR'], $pelabuhan)) {
								            		$cancel = true;
								            	}
								            	if (!in_array($dataHdr['KODE_TIMBUN'], $timbun)) {
								            		$cancel = true;
								            	}
								            	# jika tidak ada error
								            	if (!$cancel) {
								            		$HDR['KODE_KPBC_BONGKAR'] = $dataHdr['KODE_KPBC_BONGKAR'];
								            		$HDR['KODE_KPBC_AWAS'] = $dataHdr['KPBC_PENGAWAS'];
										            $HDR['TUJUAN'] = $dataHdr['TUJUAN'];
										            $HDR['TUJUAN_KIRIM'] = $dataHdr['TUJUAN_KIRIM'];
										            $HDR['MODA'] = $dataHdr['MODA'];
										            $HDR['NAMA_ANGKUT'] = $dataHdr['NAMA_ANGKUT'];
										            $HDR['NOMOR_ANGKUT'] = substr($dataHdr['NOMOR_ANGKUT'], 0, 7);
										            $HDR['PELABUHAN_MUAT'] = $dataHdr['PELABUHAN_MUAT'];
										            $HDR['PELABUHAN_BONGKAR'] = $dataHdr['PELABUHAN_BONGKAR'];
										            $HDR['KODE_TIMBUN'] = $dataHdr['KODE_TIMBUN'];
										            $HDR['BRUTO'] = $dataHdr['BRUTO'];
										            $HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
										            # get data partner
										            $sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
					 								if ($getData->num_rows() > 0) {
					 									foreach ($getData->result_array() as $objPemasok) {
					 										$HDR['NAMA_PEMASOK'] = $objPemasok['NAMA_PARTNER'];
					 										$HDR['ALAMAT_PEMASOK'] = $objPemasok['ALAMAT_PARTNER'];
					 										$HDR['NEGARA_PEMASOK'] = $objPemasok['NEGARA_PARTNER'];
					 									}
					 								}
					 								# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            } elseif ($bc == 'bc27') {
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!$cancel) {
								            		$HDR['VOLUME'] = $dataHdr['VOLUME'];
								            		$HDR['BRUTO'] = $dataHdr['BRUTO'];
								            		$HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
								            		$HDR['NOMOR_SEGEL_BC'] = $dataHdr['NOMOR_SEGEL_BC'];
								            		# get data partner
										            $sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
								            		if ($tipeDok = 'MASUK') {
									            		if ($getData->num_rows() > 0) {
						 									foreach ($getData->result_array() as $objPemasok) {
						 										$HDR['KODE_ID_TRADER_ASAL'] = $objPemasok['KODE_ID_PARTNER'];
						 										$HDR['ID_TRADER_ASAL'] = $objPemasok['ID_PARTNER'];
						 										$HDR['NAMA_TRADER_ASAL'] = $objPemasok['NAMA_PARTNER'];
						 										$HDR['ALAMAT_TRADER_ASAL'] = $objPemasok['ALAMAT_PARTNER'];
						 									}
						 								}
									            	} else {
									            		if ($getData->num_rows() > 0) {
						 									foreach ($getData->result_array() as $objPemasok) {
						 										$HDR['KODE_ID_TRADER_TUJUAN']=$objPemasok['KODE_ID_PARTNER'];
						 										$HDR['ID_TRADER_TUJUAN'] = $objPemasok['ID_PARTNER'];
						 										$HDR['NAMA_TRADER_TUJUAN'] = $objPemasok['NAMA_PARTNER'];
						 										$HDR['ALAMAT_TRADER_TUJUAN'] = $objPemasok['ALAMAT_PARTNER'];
						 									}
						 								}
									            	}
									            	# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            } elseif ($bc == 'bc40') {
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!$cancel) {
								            		$HDR['JENIS_SARANA_ANGKUT'] = $dataHdr['NAMA_ANGKUT'];
									            	$HDR['NOMOR_POLISI'] = $dataHdr['NOMOR_ANGKUT'];
									            	$HDR['VOLUME'] = $dataHdr['VOLUME'];
									            	$HDR['BRUTO'] = $dataHdr['BRUTO'];
									            	$HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
									            	# get data partner
									            	$sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
								            		if ($getData->num_rows() > 0) {
					 									foreach ($getData->result_array() as $objPemasok) {
					 										$HDR['KODE_ID_PENGIRIM'] = $objPemasok['KODE_ID_PARTNER'];
					 										$HDR['ID_PENGIRIM'] = $objPemasok['ID_PARTNER'];
					 										$HDR['NAMA_PENGIRIM'] = $objPemasok['NAMA_PARTNER'];
					 										$HDR['ALAMAT_PENGIRIM'] = $objPemasok['ALAMAT_PARTNER'];
					 									}
					 								}
					 								# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            } elseif ($bc == 'bc262') {
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!$cancel) {
								            		$HDR['JENIS_SARANA_ANGKUT'] = $dataHdr['NAMA_ANGKUT'];
									            	$HDR['NOMOR_POLISI'] = $dataHdr['NOMOR_ANGKUT'];
									            	$HDR['VOLUME'] = $dataHdr['VOLUME'];
									            	$HDR['BRUTO'] = $dataHdr['BRUTO'];
									            	$HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
									            	# get data partner
									            	$sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
								            		if ($getData->num_rows() > 0) {
					 									foreach ($getData->result_array() as $objPemasok) {
					 										$HDR['KODE_ID_PENGIRIM'] = $objPemasok['KODE_ID_PARTNER'];
					 										$HDR['ID_PENGIRIM'] = $objPemasok['ID_PARTNER'];
					 										$HDR['NAMA_PENGIRIM'] = $objPemasok['NAMA_PARTNER'];
					 										$HDR['ALAMAT_PENGIRIM'] = $objPemasok['ALAMAT_PARTNER'];
					 									}
					 								}
					 								# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            } elseif ($bc == 'bc25') {
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!$cancel) {
									            	$HDR['VOLUME'] = $dataHdr['VOLUME'];
									            	$HDR['BRUTO'] = $dataHdr['BRUTO'];
									            	$HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
									            	# get data partner
									            	$sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
								            		if ($getData->num_rows() > 0) {
					 									foreach ($getData->result_array() as $objPemasok) {
					 										$HDR['KODE_ID_PENERIMA'] = $objPemasok['KODE_ID_PARTNER'];
					 										$HDR['ID_PENERIMA'] = $objPemasok['ID_PARTNER'];
					 										$HDR['NAMA_PENERIMA'] = $objPemasok['NAMA_PARTNER'];
					 										$HDR['ALAMAT_PENERIMA'] = $objPemasok['ALAMAT_PARTNER'];
					 									}
					 								}
					 								# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            } elseif ($bc == 'bc261') {
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!$cancel) {
									            	$HDR['JENIS_SARANA_ANGKUT'] = $dataHdr['NAMA_ANGKUT'];
									            	$HDR['NOMOR_POLISI'] = $dataHdr['NOMOR_ANGKUT'];
									            	$HDR['VOLUME'] = $dataHdr['VOLUME'];
									            	$HDR['BRUTO'] = $dataHdr['BRUTO'];
									            	$HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
									            	$HDR['TUJUAN_KIRIM'] = $dataHdr['TUJUAN_KIRIM'];
									            	# get data partner
									            	$sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
								            		if ($getData->num_rows() > 0) {
					 									foreach ($getData->result_array() as $objPemasok) {
					 										$HDR['KODE_ID_PENERIMA'] = $objPemasok['KODE_ID_PARTNER'];
					 										$HDR['ID_PENERIMA'] = $objPemasok['ID_PARTNER'];
					 										$HDR['NAMA_PENERIMA'] = $objPemasok['NAMA_PARTNER'];
					 										$HDR['ALAMAT_PENERIMA'] = $objPemasok['ALAMAT_PARTNER'];
					 									}
					 								}
					 								# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            } elseif ($bc == 'bc30') {
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!$cancel) {
									            	$HDR['NAMA_ANGKUT'] = $dataHdr['NAMA_ANGKUT'];
									            	$HDR['NOMOR_ANGKUT'] = $dataHdr['NOMOR_ANGKUT'];
									            	$HDR['VOLUME'] = $dataHdr['VOLUME'];
									            	$HDR['BRUTO'] = $dataHdr['BRUTO'];
									            	$HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
									            	# get data partner
									            	$sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
								            		if ($getData->num_rows() > 0) {
					 									foreach ($getData->result_array() as $objPemasok) {
					 										$HDR['NAMA_PEMBELI'] = $objPemasok['NAMA_PARTNER'];
					 										$HDR['ALAMAT_PEMBELI'] = $objPemasok['ALAMAT_PARTNER'];
					 										$HDR['NEGARA_PEMBELI'] = $objPemasok['NEGARA_PARTNER'];
					 									}
					 								}
					 								# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            } elseif ($bc == 'bc41') {
								            	if (!in_array($dataHdr['KODE_PARTNER'], $pemasok)) {
								            		$cancel = true;
								            	}
								            	if (!$cancel) { #print_r($dataHdr);die(); #echo "xxx";die();
									            	$HDR['JENIS_SARANA_ANGKUT'] = $dataHdr['NAMA_ANGKUT'];
									            	$HDR['NOMOR_POLISI'] = $dataHdr['NOMOR_ANGKUT'];
									            	$HDR['VOLUME'] = $dataHdr['VOLUME'];
									            	$HDR['BRUTO'] = $dataHdr['BRUTO'];
									            	$HDR['NAMA_TTD'] = $dataHdr['NAMA_TTD'];
									            	$HDR['TUJUAN_KIRIM'] = $dataHdr['TUJUAN_KIRIM'];
									            	# get data partner
									            	$sql = "SELECT KODE_ID_PARTNER, ID_PARTNER, NAMA_PARTNER, ALAMAT_PARTNER,
										            		NEGARA_PARTNER, STATUS_PERUSAHAAN 
										            		FROM m_trader_pemasok
					 										WHERE KODE_TRADER = '" . $kodeTrader . "'
					 										AND KODE_PARTNER = '" . $dataHdr['KODE_PARTNER'] . "'";
					 								$getData = $this->db->query($sql);
								            		if ($getData->num_rows() > 0) {
					 									foreach ($getData->result_array() as $objPemasok) {
					 										$HDR['KODE_ID_PENERIMA'] = $objPemasok['KODE_ID_PARTNER'];
					 										$HDR['ID_PENERIMA'] = $objPemasok['ID_PARTNER'];
					 										$HDR['NAMA_PENERIMA'] = $objPemasok['NAMA_PARTNER'];
					 										$HDR['ALAMAT_PENERIMA'] = $objPemasok['ALAMAT_PARTNER'];
					 									}
					 								}
					 								# update data
										            $this->db->where(array('KODE_TRADER' => $kodeTrader,
										            						'NOMOR_AJU' => $dataHdr['NOMOR_AJU']));
										            $this->db->update('t_' . $bc . '_hdr', $HDR);
								            	}
								            }
										}
									}
								}
								# additional dokumen
								if (count($dataDokumen) > 0) {
									foreach ($dataDokumen as $dataDok) {
										$kode_dokumen = strtoupper($dataDok['KODE_DOK']);
										if (strtoupper($kode_dokumen) == 'BC27MASUK' || strtoupper($kode_dokumen) == 'BC27KELUAR') {
											$bc = 'bc27';
										} else {
											$bc = strtolower($kode_dokumen);
										}
										$sqlCek = "SELECT NOMOR_AJU FROM t_" . $bc . "_dok 
													WHERE KODE_TRADER = '" . $kodeTrader . "'
													AND NOMOR_AJU = '" . $dataDok['NOMOR_AJU'] . "'
													AND KODE_DOKUMEN = '" . $dataDok['KODE_DOKUMEN'] . "'
													AND NOMOR = '" . $dataDok['NOMOR'] . "'";
										$doCek = $this->db->query($sqlCek);
										if ($doCek->num_rows() < 1) {
											# insert data
											$DOK['NOMOR_AJU'] = $dataDok['NOMOR_AJU'];
											$DOK['KODE_DOKUMEN'] = $dataDok['KODE_DOKUMEN'];
											$DOK['NOMOR'] = $dataDok['NOMOR'];
											$DOK['TANGGAL'] = $dataDok['TANGGAL'];
											$DOK['KODE_TRADER'] = $kodeTrader;
											$this->db->insert('t_' . $bc . '_dok', $DOK);
										}
									}
								}
								# additional kemasan
								if (count($dataKemasan) > 0) {
									foreach ($dataKemasan as $dataKms) {
										$kode_dokumen = strtoupper($dataKms['KODE_DOK']);
										if (strtoupper($kode_dokumen) == 'BC27MASUK' || strtoupper($kode_dokumen) == 'BC27KELUAR') {
											$bc = 'bc27';
										} else {
											$bc = strtolower($kode_dokumen);
										}
										$sqlCek = "SELECT NOMOR_AJU FROM t_" . $bc . "_kms 
													WHERE KODE_TRADER = '" . $kodeTrader . "'
													AND NOMOR_AJU = '" . $dataKms['NOMOR_AJU'] . "'
													AND KODE_KEMASAN = '" . $dataKms['KODE_KEMASAN'] . "'";
										$doCek = $this->db->query($sqlCek);
										if ($doCek->num_rows() < 1) {
											# insert data
											$KMS['NOMOR_AJU'] = $dataKms['NOMOR_AJU'];
											$KMS['KODE_KEMASAN'] = $dataKms['KODE_KEMASAN'];
											$KMS['JUMLAH'] = $dataKms['JUMLAH'];
											$KMS['MERK_KEMASAN'] = $dataKms['MERK_KEMASAN'];
											$KMS['KODE_TRADER'] = $kodeTrader;
											$this->db->insert('t_' . $bc . '_kms', $KMS);
										}
									}
								}
							}
						}
					}
				}								
				break;
			}*/			
		}
		if($error){
			unlink('/home/dev/plb/'.$file);
			echo $this->load->view('upload/form_upload_bc16',array("proses"=>"error","msg"=>$error),true);
		}else{
			unlink('/home/dev/plb/'.$file);
			echo $this->load->view('upload/form_upload_bc16',array("proses"=>"sukses","msg"=>$sukses),true);
		}
	}
/// END PROSES UPLOAD BC 1.6 ///

	function sendCommand($filename,$dok,$tipe_dok){						
		$this->load->library("nusoap");
		$URLWSDL = "http://10.1.6.41/wseinkaber/server_plb_dev.php?WSDL";

		$kodeTrader = $this->newsession->userdata('KODE_TRADER');
		$UserID = $this->newsession->userdata('USER_ID');
		
		$xml = "<?xml version='1.0' encoding='ISO-8859-1'?>
				<UploadDokumen>
					<result>TRUE</result>
					<customer>plbInventory</customer>
					<dokumen>".$dok."</dokumen>
					<fileName>".$filename."</fileName>
					<kodeTrader>".$kodeTrader."</kodeTrader> 
					<UserID>".$UserID."</UserID>
					<TipeDok>".$tipe_dok."</TipeDok>
				</UploadDokumen>";
				
		$param = array( 'string0' => 'plbInventory','string1' => 'plb1nv3nt0ry','string2' => $xml);
		$client = new nusoap_client($URLWSDL);
		return $result = $client->call('executefile',$param);
	}
			
}
?>