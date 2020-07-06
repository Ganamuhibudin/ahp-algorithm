<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Uploadnew extends CI_Controller{
	var $content = "";
	
	function index($dok=""){
		if($this->newsession->userdata('LOGGED')){
			$this->load->model('main');
			$this->main->get_index($dok,$this->addHeader);	
		}else{
			$this->newsession->sess_destroy();		
			redirect(base_url());
		}
	}	
	
	function cekDatasama($data1,$data2){
		$sama="";$datasama="";
		$array_temp1 = array();
		$array_temp2 = array();
		$data = array();
		foreach($data2 as $nilai2){
			if($nilai2!=""){
				$array_temp2[] = $nilai2;
			}
		}
		$index=0;
		foreach($data1 as $nilai1){			
			if($nilai1!=""){
				if(in_array($nilai1,$array_temp1)){
					$self = explode("|",$array_temp2[$index]);		
					for($a=1;$a<count($array_temp2);$a++){
						$other = explode("|",$array_temp2[$a]);
						$sama = 0;	
						if($self[0]==$other[0]){
							if($self[1]==$other[1] && $self[2]==$other[2]){
								$sama = 0;		
							}else{
								$sama = 1;	
								break;	
							}													
						}	
					}
					if($sama==1){
						$notsame = 1;
						if(!in_array($nilai1,$data)){
							$datasama = $datasama.$nilai1.", ";															
						}
						$data[] = $nilai1;
					}
				}
				$array_temp1[] = $nilai1;
			}
			$index++;
		}
		if($notsame==1){
			return $datasama;
		}else{
			return false;	
		}
	}
	
	function cekbarang($kdbarang,$jnsbarang){
		$this->load->model("main");
		$this->db->reconnect();
		$SQL =" SELECT KODE_BARANG FROM M_TRADER_BARANG 
				WHERE KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."' 
				AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
		$hasil = $this->main->get_result($SQL);	
		if($hasil){
			return false;	
		}else{
			return true;
		}
	}
	
	function ceklastproses($data){
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
	
	
	function replace_character($string=""){
		if($string){
			$string=strip_tags($string,"");
			$string = preg_replace('/[^A-Za-z0-9\s.\s-]/','',$string); 
			return $string = str_replace( array( '-', '.' ), '', $string);	
		}
	}
	
	function check_character($string=""){
		$ret = false;
		if($string){
			if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string)){
				$ret = true;
			}	
		}
		return $ret;
	}
	
	function cek_noaju($noaju,$BC=""){
		$this->load->model("main");
		$this->db->reconnect();
		$return = FALSE;
		$tipe = array('BC16','BC20','BC24','BC27','BC28','BC30','BC40','BC41');
		if($BC){
			if(in_array($BC,$tipe))	{
				$Q = "";
				$QUERY = "SELECT DISTINCT NOMOR_AJU AS CODE FROM T_".$BC."_HDR WHERE NOMOR_AJU='".$noaju."' AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'";
				$hasil = $this->main->get_result($QUERY);	
				if($hasil){
					$return = TRUE;	
				}
			}
		}
		return $return;		
	}
	
	#START PRODUKSI
	
	function produksi(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/produksi',array("proses"=>""),false);
	}
	
	function proses_produksi(){		
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0); 
		$this->load->model("main");
		$this->load->model('upload_act');
		$this->load->model('produksi_act');	
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');	
		$valmasuk = $this->input->post('masuk');	
		if($idHeader=="")redirect('uploadnew/produksi','refresh');
		#constanta validasi 4 produksi
		$highestColumn = 16;		
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');	
		$datatipe = array("masuk","keluar","sisa");
		$mandatory = array("0","1","3","5","8","9","10","13","14");
		//$kdsatuan = $this->upload_act->getDataKodeUpload('satuan');
		$notransaksi = $this->upload_act->getDataKodeUpload('transaksi');
		//$kdgudang = $this->upload_act->getDataKodeUpload('gudang');
		$noproses = $this->upload_act->getDataKodeUpload('nomorproses');
		
		$field = array("TIPE","NO_TRANSAKSI","NO_TRANSAKSI_MASUK","TANGGAL","JAM","KODE_BARANG",
					   "KODE_HS","URAIAN","JNS_BARANG","JUMLAH","SATUAN","KETERANGAN","KODE_GUDANG","KODE_RAK","KODE_SUB_RAK","KONDISI_BARANG");
		#================================	
		$KOLOM = array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E","6"=>"F","7"=>"G","8"=>"H","9"=>"I",
					   "10"=>"J","11"=>"K","12"=>"L","13"=>"M","14"=>"N","15"=>"O","16"=>"P");	
		$namaFile= $idHeader;
		$file = "assets/file/upload/";
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);	
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."produksi.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);	
		$this->upload->display_errors('' ,'' );
		if(!$this->upload->do_upload("fileUpload")){
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			$data = $this->upload->data();			
			$file = $file.$data['file_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 	$proses = FALSE;
			$kosong = FALSE;
			$tipe = FALSE;
			$masuk = FALSE;
			$barang = FALSE;
			$satuan = FALSE;
			$transaksi = FALSE;			
			foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow         = $worksheet->getHighestRow(); 
				$highestColumn      = $worksheet->getHighestColumn(); 
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				for($row=2; $row <= $highestRow; $row++){					
					for($col=0; $col <= ($highestColumnIndex-1); $col++){
						#cek mandatory
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						if($valmasuk=="tidak"){
							unset($mandatory[1]);
						}
						if(in_array($col,$mandatory)){
							if(trim($cell->getCalculatedValue())==""){
								$kosong = TRUE;	
								$msgkosong = $msgkosong."KOLOM:[".$KOLOM[$col+1].",".$row."], ";
							}
						}
					}				
					#cek tipe
					$cell_tipe = $worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue();
					if(!in_array(strtolower($cell_tipe),$datatipe)){
						$tipe = TRUE;
						$msgtipe = $msgtipe.$cell_tipe." (KOLOM:[A".",".$row."]), ";
					}
					#cek no transaksi dah ada di db blum
					$cell_transaksi = $worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
					$cekDataTransaksi[] = $cell_transaksi;	
					if(in_array(trim($cell_transaksi),$notransaksi)){
						$transaksi = TRUE;
						$msgtransaksi = $msgtransaksi.$cell_transaksi." (KOLOM:[B".",".$row."]), ";
					}					
					#cek transaksi masuk
					if($valmasuk=="ya"){
						$cell_tran_masuk = $worksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue();	
						if(strtolower($cell_tipe)=="keluar"||strtolower($cell_tipe)=="sisa"){
							if($cell_tran_masuk==""){
								$masuk = TRUE;	
								$msgmasuk = $msgmasuk."KOLOM:[C".",".$row."], ";						
							}else{
								$expl = explode(';',$cell_tran_masuk);
								for($a=0;$a<=count($expl)-1;$a++){
									if(!in_array($expl[$a], $noproses)){
										$proses_nomor = TRUE;
										$msgproses_nomor .= $msgproses_nomor.$expl[$a]." (KOLOM:[C".",".$row."]), ";
									}
								}
							}
						}
					}
					#cek same date					
					//$cell_date =PHPExcel_Shared_Date::ExcelToPHPObject($worksheet->getCellByColumnAndRow(3,$row)->getCalculatedValue())->format('Y-m-d');
		
					$cell_date = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(3,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
					if(strpos($cell_date,"/")===false){
						$cell_date = $cell_date;	
					}else{
						$cell_date = $this->fungsi->dateformat($cell_date);		
					}	

					$arrayTransaksi[] = strtolower($cell_transaksi);
					$arrayBanding[] = strtolower($cell_transaksi."|".$cell_tipe."|".$cell_date);
					#cek kode barang
					$cell_barang = $worksheet->getCellByColumnAndRow(5, $row)->getCalculatedValue();	
					$cell_jenis = $worksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();	
					if($this->cekbarang($cell_barang,$cell_jenis)){
						$barang = TRUE;
						$msgbarang = $msgbarang."Kode Barang: ".$cell_barang." dgn Jenis Barang: ".$cell_jenis.", ";
					}
					#cek satuan
					$cell_satuan = $worksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue();
					$kdsatuan = $this->upload_act->getDataKodeUpload('satuan_prod','',$cell_barang,$cell_jenis);
					if(!in_array(strtoupper($cell_satuan),$kdsatuan)){
						$satuan = TRUE;
						$msgsatuan = $msgsatuan.$cell_satuan." (KOLOM:[K".",".$row."]), ";
					}
					#cek GUDANG
					$cell_gudang = $worksheet->getCellByColumnAndRow(12, $row)->getCalculatedValue();
					$kdgudang = $this->upload_act->getDataKodeUpload('gudang_tiga_level','',$cell_barang,$cell_jenis,'',$cell_gudang);
					if(!in_array(strtoupper($cell_gudang),$kdgudang)  && $cell_gudang!="" && strtolower($cell_gudang)!="utama"){
						$gdg = TRUE;
						$msggdg = $msggdg.$cell_gudang." (KOLOM:[M".",".$row."]), ";
					}
					
					#cek RAK
					$cell_kdrak = $worksheet->getCellByColumnAndRow(13,$row)->getCalculatedValue();
					if($cell_kdrak){						
						$dtrak		= $this->upload_act->getDataKodeUpload('gudang_tiga_level','',$cell_barang,$cell_jenis,'',$cell_gudang,
						$cell_kdrak);
						if(!in_array($cell_kdrak,$dtrak)){
							$koderak= TRUE;
							$msgkoderak = $msgkoderak.$cell_kdrak."(KOLOM:[N,".$row."]) di gudang ".$cell_gudang." (KOLOM:[M,".$row."]), ";
						}
					}					
					#cek SUBRAK
					$cell_kdsubrak = $worksheet->getCellByColumnAndRow(14,$row)->getCalculatedValue();
					//echo $cell_kdsubrak;die();
					if($cell_kdsubrak){						
						$dtsubrak = $this->upload_act->getDataKodeUpload('gudang_tiga_level','',$cell_barang,$cell_jenis,'',$cell_gudang,
						$cell_kdrak,$cell_kdsubrak);
						if(!in_array($cell_kdsubrak,$dtsubrak)){
							$kodesubrak= TRUE;
							$msgkodesubrak = $msgkodesubrak.$cell_kdsubrak."(KOLOM:[O,".$row."]) di rak ".$cell_kdrak.", ";
						}
					}
					#cek kondisi barang
					$cell_kondisi = $worksheet->getCellByColumnAndRow(15, $row)->getCalculatedValue();
					$cek_kondisi = $this->upload_act->getDataKodeUpload('kondisi','',$cell_barang,'','','');
					if(!in_array(strtoupper($cell_kondisi),$cek_kondisi)){
						$kndisi = TRUE;
						$msgkondisi = $msgkondisi.$cell_kondisi." (KOLOM:[P,".$row."]), ";
					}
					#cek stok barang
					//$cell_jumlah = $worksheet->getCellByColumnAndRow(9, $row)->getCalculatedValue();
					$cell_jumlah = (float)str_replace(",","",str_replace("'","",$worksheet->getCellByColumnAndRow(9,$row)->getOldCalculatedValue()));
					if(empty($cell_jumlah)){
						$cell_jumlah = (float)str_replace(",","",str_replace("'","",$worksheet->getCellByColumnAndRow(9,$row)->getCalculatedValue()));
					}
					if(!$tipe && $cell_tipe == 'Masuk'){
						//echo $cell_tipe; die();
						$cekstok = $this->upload_act->getDataKodeUpload('stock_prod','',$cell_barang,$cell_jenis,'',$cell_gudang,$cell_kdrak,
								$cell_kdsubrak,$cell_kondisi);
						
						if($cell_jumlah > $cekstok[0]){
							$stock = TRUE;
							$msgstock = $msgstock."Kode Barang : ".$cell_barang." jumlah yang akan di proses ".$cell_jumlah.
							"(KOLOM:[J,".$row."]), ";
						}			
					}
					
				}
				$cekDatasama = $this->cekDatasama($arrayTransaksi,$arrayBanding);
				if($kosong){
					$msg = "Terdapat data yang kosong pada kolom yang harus diisi: ".$msgkosong;	
					$error .= $this->fungsi->msg("error",$msg);		
				}
				if($cekDatasama){
					$msg = "Terdapat Duplikat Nomor Transaksi namun tidak dengan Tipe dan Tanggal yang sama: ".$cekDatasama;
					$error .= $this->fungsi->msg("warning",$msg);	
				}
				if($tipe){
					$msg ="Tipe tidak dikenali: ".$msgtipe;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($transaksi){
					$msg ="Nomor Transaksi sudah ada di database anda: ".$msgtransaksi;	
					$error .= $this->fungsi->msg("warning",$msg);	
				}
				if($masuk){
					$msg ="Tipe Keluar dan Sisa harus mengisi Nomor Transaksi Masuk: ".$msgmasuk;	
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($satuan){
					$msg ="Satuan tidak dikenali: ".$msgsatuan;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($kndisi){
					$msg ="Kondisi barang tidak sesuai: ".$msgkondisi;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($gdg){
					$msg ="Kode gudang tidak tersedia: ".$msggdg;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($koderak){
					$msg = "Terdapat kode rak tidak tersedia : ".$msgkoderak;
					$error .= $this->fungsi->msg("error",$msg);
				}
				if($kodesubrak){
					$msg = "Terdapat kode sub rak tidak tersedia : ".$msgkodesubrak;
					$error .= $this->fungsi->msg("error",$msg);
				}
				if($barang){
					$msg = "Terdapat Kode Barang yang tidak dikenali: ".$msgbarang;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($stock){
					$msg = "Stock Barang tidak mencukupi yaitu ".$msgstock;
					$error .= $this->fungsi->msg("error",$msg);
				}
				if($proses_nomor){
					$msg ="Terdapat Nomor Transaksi Masuk yang tidak dikenali: ".$msgproses_nomor;
					$error .= $this->fungsi->msg("error",$msg);	
				}
					
				if(!$error){
					$proses = TRUE;
					$index = 0;
					for($row=2; $row <= $highestRow; $row++){
						for($col=0; $col <= ($highestColumnIndex-1); $col++){
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$cell_tgl = $worksheet->getCellByColumnAndRow(3,$row)->getCalculatedValue();
							//$TGL=PHPExcel_Shared_Date::ExcelToPHPObject($cell_tgl)->format('Y-m-d');

							$TGL = PHPExcel_Style_NumberFormat::toFormattedString($cell_tgl,PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL,"/")===false){
								$TGL = $TGL;	
							}else{
								$TGL = $this->fungsi->dateformat($TGL);		
							}
							$JAM = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(4,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);		
							$DATAEXCEL[$index]['TANGGAL'] = $TGL;
							$DATAEXCEL[$index]['JAM'] = $JAM;
							$ISI = $cell->getCalculatedValue();
							if($col==12 && $cell->getCalculatedValue()==""){
								$ISI = "UTAMA";
							}
							/*if($col==13 && $cell->getCalculatedValue()==""){
								$ISI = "BAIK";
							}*/
							$DATAEXCEL[$index][$field[$col]] = strtoupper($ISI);
						}
						$index++;
					}
					if($proses){
						$nextNoproses = $this->ceklastproses($cekDataTransaksi);
						$lstnopro=0;
						$indexno=0;
						$lastprosesnew = false;
						$temparray1 = array();
						$temparray2 = array();
						foreach($DATAEXCEL as $VAL){
							$tipetgl = strtolower($VAL["TIPE"]).$VAL["TANGGAL"];							
							if($VAL["NO_TRANSAKSI"]==""){
								if(in_array($tipetgl,$temparray1)){
									$lastproses = $temparray2[$indexno-1];
								}else{
									$lastproses = date('dmY')."".sprintf("%06d",(substr($this->produksi_act->get_lastProses(),9,6)+$lstnopro))."";
									$lstnopro++;	
									$lastprosesnew = true;
								}
								$temparray1[] = $tipetgl;
								$temparray2[] = $lastproses;
								$indexno++;
								$PROCESSHEADER["NOMOR_PROSES"] = $lastproses;	
							}else{
								$PROCESSHEADER["NOMOR_PROSES"] = $VAL["NO_TRANSAKSI"];									
							}
							if(strtolower($VAL["TIPE"]) == "masuk"){
								$VAL["NO_TRANSAKSI_MASUK"] = NULL;
							}								
							$PROCESSHEADER["KODE_TRADER"] = $kodetrader;
							$PROCESSHEADER["NOMOR_PROSES_ASAL"] = $VAL["NO_TRANSAKSI_MASUK"];
							$PROCESSHEADER["TANGGAL"] = $VAL["TANGGAL"];
							$PROCESSHEADER["WAKTU"] = $VAL["JAM"];
							$PROCESSHEADER["JENIS_BARANG"] = strtolower($VAL["TIPE"]);
							$PROCESSHEADER["KETERANGAN"] = $VAL["KETERANGAN"];
							//print_r($PROCESSHEADER); die();
							if(strtolower($VAL["TIPE"]) != "masuk" && $valmasuk == "ya"){
								$PROCESSHEADER["FLAG_PENUTUP"] = "1";
							}
							$PROCESSHEADER["STATUS"] = "0";	
							
							$SQL = "SELECT NOMOR_PROSES FROM m_trader_proses WHERE NOMOR_PROSES='".$PROCESSHEADER["NOMOR_PROSES"]."'
									AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
							$hasil = $this->main->get_result($SQL);	
							if(!$hasil){
								$exec = $this->db->insert("m_trader_proses",$PROCESSHEADER);
								$this->main->activity_log('ADD PRODUKSI '.strtoupper($VAL["TIPE"]),'NOMOR TRANSAKSI='.$PROCESSHEADER["NOMOR_PROSES"],'UPLOAD');
							}								
							$seri=(int)$this->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM m_trader_proses_dtl 
																WHERE NOMOR_PROSES = '".$PROCESSHEADER["NOMOR_PROSES"]."'","MAXSERI")+1;
																
							$PROCESSDETIL["NOMOR_PROSES"] = $PROCESSHEADER["NOMOR_PROSES"];
							$PROCESSDETIL["KODE_TRADER"] = $kodetrader;
							$PROCESSDETIL["SERI"] = $seri;
							$PROCESSDETIL["KODE_BARANG"] = $VAL["KODE_BARANG"];
							$PROCESSDETIL["JNS_BARANG"] = $VAL["JNS_BARANG"];
							$PROCESSDETIL["JUMLAH"] = $VAL["JUMLAH"];
							$PROCESSDETIL["KODE_SATUAN"] = $VAL["SATUAN"];
							$PROCESSDETIL["KETERANGAN"] = $VAL["KETERANGAN"];
							$PROCESSDETIL["KODE_GUDANG"] = $VAL["KODE_GUDANG"];
							$PROCESSDETIL["KODE_RAK"] = $VAL["KODE_RAK"];
							$PROCESSDETIL["KODE_SUB_RAK"] = $VAL["KODE_SUB_RAK"];
							$PROCESSDETIL["KONDISI_BARANG"] = $VAL["KONDISI_BARANG"];	
							//print_r($PROCESSDETIL); die();		
							if($exec){	
								$exec = $this->db->insert("m_trader_proses_dtl",$PROCESSDETIL);	
								#UNTUK STATUS REALISASI
								if ($this->input->post('realisasi') == 'setujui') {                                  
                                    $DETILLOG = "";
                                    $SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
                                               FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $VAL["KODE_BARANG"] . "' 
                                               AND JNS_BARANG='" . $VAL["JNS_BARANG"] . "' AND KODE_TRADER='" . $kodetrader . "'";
                                    $VALBRG = $this->db->query($SQLBRG)->row();
                                    $JUMBRG = $VALBRG->STOCK_AKHIR;

                                    $SQLBRGGDG = "SELECT JUMLAH FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '" . $VAL["KODE_BARANG"] . "' 
                                               AND JNS_BARANG = '" . $VAL["JNS_BARANG"] . "' AND KODE_GUDANG = '" . $VAL["KODE_GUDANG"] . "' 
											   AND KODE_RAK = '" . $VAL["KODE_RAK"] . "' AND KODE_SUB_RAK = '" . $VAL["KODE_SUB_RAK"] . "' 
											   AND KONDISI_BARANG = '".$VAL["KONDISI_BARANG"]."' AND KODE_TRADER = '" . $kodetrader . "'";
                                    $TMP = $this->db->query($SQLBRGGDG)->row();
                                    $JMLBG = $TMP->JUMLAH;
									
									if(strtolower($VAL["TIPE"]) == "masuk"){
										$tipe = "PROCESS_IN";
									}else if(strtolower($VAL["TIPE"]) == "keluar"){
										$tipe = "PROCESS_OUT";
									}else{
										$tipe = "SCRAP";
									}									
                                    $INOUT["NOMOR_PROSES"] = $PROCESSHEADER["NOMOR_PROSES"];
                                    $INOUT["CREATED_TIME"] = date("Y-m-d H:i:s");
                                    $INOUT["TIPE"] = $tipe;
                                    $INOUT["KODE_TRADER"] = $kodetrader;
                                    $INOUT["KODE_BARANG"] = $VAL["KODE_BARANG"];
                                    $INOUT["JNS_BARANG"] = $VAL["JNS_BARANG"];
                                    $INOUT["JUMLAH"] = $VAL["JUMLAH"];
                                    $INOUT["TANGGAL"] = $VAL["TANGGAL"] . " " . $VAL["JAM"] . ":00";
                                    $INOUT["KODE_GUDANG"] = $VAL["KODE_GUDANG"];
									$INOUT["KODE_RAK"] = $VAL["KODE_RAK"];
									$INOUT["KODE_SUB_RAK"] = $VAL["KODE_SUB_RAK"];
                                    $INOUT["KONDISI_BARANG"] = $VAL["KONDISI_BARANG"];
									
									if(strtolower($VAL["TIPE"]) == 'masuk'){																			
										/*$this->db->where(array("KODE_BARANG" => $VAL["KODE_BARANG"],
											"JNS_BARANG" => $VAL["JNS_BARANG"],
											"KODE_TRADER" => $kodetrader));
										$this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG - $VAL["JUMLAH"]));*/
										//-------------------------
										$this->db->where(array("KODE_BARANG" => $VAL["KODE_BARANG"],
											"KODE_GUDANG" => $VAL["KODE_GUDANG"],
											"KODE_RAK" => $VAL["KODE_RAK"],
											"KODE_SUB_RAK" => $VAL["KODE_SUB_RAK"],
											"KONDISI_BARANG" => $VAL["KONDISI_BARANG"],
											"KODE_TRADER" => $kodetrader));
										$this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $JMLBG - $VAL["JUMLAH"]));
										//-------------------------
										$exec1 = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
										if ($exec1) {
											$this->db->where(array("NOMOR_PROSES" => $PROCESSHEADER["NOMOR_PROSES"],
											"KODE_TRADER" => $kodetrader));
											$exec1 = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
										}
										$STKLOG = "";
										$STKLOG = $JUMBRG + $data["JUMLAH"];
										$DETILLOG = $DETILLOG . '- KODE BRG=' . $VAL['KODE_BARANG'] . ', JNS BRG=' . $VAL['JNS_BARANG'] . ', 
										JML MASUK=' . $VAL["JUMLAH"] . ', JML SEBELUM=' . $JUMBRG . ', STOCK AKHIR=' . $STKLOG . ";<br>";
									
										if ($exec1) {
											$this->main->activity_log('SETUJUI DATA BARANG YANG DIPROSES [INPUT]', 'NOMOR TRANSAKSI=' . $PROCESSHEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
										}
									}else if(strtolower($VAL["TIPE"]) == 'keluar' || strtolower($VAL["TIPE"]) == 'sisa'){
										/*$this->db->where(array("KODE_BARANG" => $VAL["KODE_BARANG"],
											"JNS_BARANG" => $VAL["JNS_BARANG"],
											"KODE_TRADER" => $kodetrader));
										$this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG + $VAL["JUMLAH"]));*/
										//-------------------------
										$this->db->where(array("KODE_BARANG" => $VAL["KODE_BARANG"],
											"KODE_GUDANG" => $VAL["KODE_GUDANG"],
											"KODE_RAK" => $VAL["KODE_RAK"],
											"KODE_SUB_RAK" => $VAL["KODE_SUB_RAK"],
											"KONDISI_BARANG" => $VAL["KONDISI_BARANG"],
											"KODE_TRADER" => $kodetrader));
										$this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $JMLBG + $VAL["JUMLAH"]));
										//-------------------------
										$exec1 = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
										if ($exec1) {
											$this->db->where(array("NOMOR_PROSES" => $PROCESSHEADER["NOMOR_PROSES"],
											 "KODE_TRADER" => $kodetrader));
											$exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
										}
										$STKLOG = "";
										$STKLOG = $JUMBRG - $VAL["JUMLAH"];
										$DETILLOG = $DETILLOG . '- KODE BRG=' . $VAL['KODE_BARANG'] . ', JNS BRG=' . $VAL['JNS_BARANG'] . ',
										 JML MASUK=' . $VAL["JUMLAH"] . ', JML SEBELUM=' . $JUMBRG . ', STOCK AKHIR=' . $STKLOG . ";<br>";
									
										if ($exec1) {
											if(strtolower($VAL["TIPE"]) == "keluar"){
											$this->main->activity_log('SETUJUI DATA BARANG HASIL PENGERJAAN [OUTPUT]', 'NOMOR TRANSAKSI=' .
											 $HEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
											}else{
											$this->main->activity_log('SETUJUI DATA BARANG SISA PENGERJAAN/SCRAP', 'NOMOR TRANSAKSI=' .
											 $PROCESSHEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
											}
										}
										
									}
	
								}
								#END REALISASI				
							}
						}	
						if($exec){
							if($lastprosesnew){
								$this->db->where(array('KODE_TRADER' => $this->newsession->userdata('KODE_TRADER')));
								$this->db->update('m_trader', array("LAST_PROSES"=>$nextNoproses)); 		
							}
							$sukses = $this->fungsi->msg("done","Data Berhasil diproses");	
						}else{
							$error = $this->fungsi->msg("error","Data Gagal diproses");	 
						}
					}
				}								
				break;
			}			
		}
		if($error){
			echo $this->load->view('upload/produksi',array("proses"=>"error","msg"=>$error),true);
			unlink($file);
		}else{
			echo $this->load->view('upload/produksi',array("proses"=>"sukses","msg"=>$sukses),true);
			unlink($file);
		}
	}
	
	///////////////////////////	END PRODUKSI ///////////////////////////////////////////////////////////////////////////////////////////////	

	
	///////////////////////////	START PABEAN ///////////////////////////////////////////////////////////////////////////////////////////////	
	
	function pabean(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/pabean',array("proses"=>""),false);
	}
	
	function proses_pabean(){		
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0); 
		$this->load->model("main");
		$this->load->model('upload_act');
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');	
		if($idHeader=="")redirect('uploadnew/pabean','refresh');
		#constanta validasi 4 pabean
		$highestColumn = 28;		
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');	
		$mandatory = array("13","14","16","17","18","19","20","23","24");
		$mandatory_conditional = array("1","2","3","8","9","10","11","12");
		$datatipe = array('BC16'/*,'BC24'*/,'BC27MASUK','BC27KELUAR','BC28','BC30MASUK','BC30KELUAR','BC40','BC41');
		$getin = array('BC16','BC24','BC27MASUK','BC30MASUK','BC40');
		$getout = array('BC27KELUAR','BC28','BC30KELUAR','BC41');
		$datakpbc = $this->upload_act->getDataKodeUpload('kpbc');
		$datasatuan = $this->upload_act->getDataKodeUpload('satuan');
		$datavaluta = $this->upload_act->getDataKodeUpload('kurs');
		$datajenisbarang = $this->upload_act->getDataKodeUpload('jenisbarang');
		$fieldHeader = array('KODE_DOK','NOMOR_AJU','KODE_KPBC','NAMA_PEMASOK','NOMOR_PENDAFTARAN','TANGGAL_PENDAFTARAN','NOMOR_DOK_PABEAN', 
					         'TANGGAL_DOK_PABEAN','NOMOR_DOK_INTERNAL','TANGGAL_DOK_INTERNAL','KODE_VALUTA','NDPBM','JUMLAH_DTL');
		$fieldDetil = array('SERI','KODE_BARANG','KODE_HS','URAIAN_BARANG','JENIS_BARANG','JUMLAH_SATUAN','KODE_SATUAN','CIF');			
		$fieldInOut = array('SERI','KODE_BARANG','','URAIAN_BARANG','JNS_BARANG','JUMLAH','KODE_SATUAN','CIF');		   
		#================================			
		$KOLOM = array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E","6"=>"F","7"=>"G","8"=>"H","9"=>"I",
					   "10"=>"J","11"=>"K","12"=>"L","13"=>"M","14"=>"N","15"=>"O","16"=>"P","17"=>"Q","18"=>"R",
					   "19"=>"S","20"=>"T","21"=>"U","22"=>"V","23"=>"W","24"=>"X","25"=>"Y","26"=>"Z","27"=>"AA","28"=>"AB","29"=>"AC");
		$namaFile= $idHeader;
		$file = "assets/file/upload/";
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);	
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."produksi.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);	
		$this->upload->display_errors('' ,'' );
		if(!$this->upload->do_upload("fileUpload")){
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			$data = $this->upload->data();			
			$file = $file.$data['file_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 	$proses = FALSE;
			$kosong = FALSE;
			$tipe = FALSE;
			$ajuvalid = FALSE;
			$noaju = FALSE;		
			$kpbc = FALSE;
			$valuta = FALSE;	
			$satuan = FALSE;	
			$ajukosong  = FALSE;
			$duplicatAjuOnFile = FALSE;	
			$jenisbarang = FALSE;
			$satuanbarang = FALSE;
			$logmasuk = FALSE;	
			$logmasuk_fifo = FALSE;	
			$saldomasuk = FALSE;
			$stock = FALSE;
			$gdg = FALSE;
			$koderak = FALSE;
			$kodesubrak = FALSE;
			$kndisi = FALSE;
			$arrayNoAju = array();
			foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow         = $worksheet->getHighestRow(); 
				$highestColumn      = $worksheet->getHighestColumn(); 
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$arraytemp = array();
				$arraytemp_jumlah = array();
				$arraytemp_pabean = array();
				$arraytemp_jumlah_pabean = array();
				$xy = 1;
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
					
					#membuat cell tipe
					if($worksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue()){
						$JENISDOKUMEN = strtoupper($this->replace_character(str_replace(array(" ","."),array("",""),$worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue())));
						if($row!=2){
							$xy=1;
						}
					}else{
						$Y = $row-($row-($row-$xy));
						$JENISDOKUMEN = strtoupper($this->replace_character(str_replace(array(" ","."),array("",""),$worksheet->getCellByColumnAndRow(0, $Y)->getCalculatedValue())));
						$xy++;
					}
					
					#cek kode dokumen			
					/*
					$cell_tipe = str_replace(" ","",$worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue());
					if($cell_tipe){
						if(!in_array(trim(strtoupper($cell_tipe)),$datatipe)){
							$tipe = TRUE;
							$msgtipe = $msgtipe.$cell_tipe." (KOLOM:[A".",".$row."]), ";
						}
					}*/
					$cell_tipe = str_replace(" ","",$worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue());
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
					
					$cell_parsial = strtoupper($worksheet->getCellByColumnAndRow(21, $row)->getCalculatedValue());										
					
					#cek nomor aju dah ada di db blum
					$cell_noaju = $this->replace_character($worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
					$cell_noaju = substr($cell_noaju,0,26);
					if($cell_noaju!=""){		
						if(substr($cell_tipe,0,4)=="BC27"){
							$BC = substr($cell_tipe,0,4);		
						}else{
							$BC = $cell_tipe;		
						}
						#CEK PARSIAL OR NOT
						if($cell_parsial!="YA"){								
							if($this->cek_noaju($cell_noaju,$BC)){
								$noaju = TRUE;
								$msgnoaju = $msgnoaju.$BC.": ".$cell_noaju." (KOLOM:[B".",".$row."]), ";
							}
						}
					}
					#cek nomor aju double di file					
					if($cell_noaju){
						#CEK PARSIAL OR NOT
						if($cell_parsial!="YA"){								
							if(in_array(trim($cell_noaju),$arrayNoAju,TRUE)){
								$duplicatAjuOnFile = TRUE;
								$msgnoajuDuplicat = $msgnoajuDuplicat.$cell_noaju." (KOLOM:[B".",".$row."]), ";
							}else{
								$arrayNoAju[] = $cell_noaju;	
							}	
						}
					}
					#cek kpbc
					$cell_kpbc = $worksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue();
					if($cell_kpbc){
						if(!in_array(trim($cell_kpbc),$datakpbc)){
							$kpbc = TRUE;
							$msgkpbc = $msgkpbc.$cell_kpbc." (KOLOM:[C".",".$row."]), ";
						}	
					}
					#cek valuta
					$cell_valuta = $worksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue();
					if($cell_valuta){
						if(!in_array(trim($cell_valuta),$datavaluta)){
							$valuta = TRUE;
							$msgvaluta = $msgvaluta.$cell_valuta." (KOLOM:[K".",".$row."]), ";
						}	
					}
					#cek kode barang
					$cell_barang = $worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue();	
					$cell_jenis = $worksheet->getCellByColumnAndRow(17, $row)->getCalculatedValue();	
					if($this->cekbarang($cell_barang,$cell_jenis)){
						$barang = TRUE;
						$msgbarang = $msgbarang."Kode Barang: ".$cell_barang." dgn Jenis Barang: ".$cell_jenis.", ";
					}
					#cek jenis barang
					if($cell_jenis){
						if(!in_array(trim($cell_jenis),$datajenisbarang)){
							$jenisbarang = TRUE;
							$msgjenisbarang = $msgjenisbarang.$cell_jenis." (KOLOM:[R".",".$row."]), ";
						}
					}

					#cek GUDANG
					$cell_gudang = $worksheet->getCellByColumnAndRow(23, $row)->getCalculatedValue();
					$kdgudang = $this->upload_act->getDataKodeUpload('gudang_tiga_level','',$cell_barang,$cell_jenis,'',$cell_gudang);
					if(!in_array(strtoupper($cell_gudang),$kdgudang)  && $cell_gudang!="" && strtolower($cell_gudang)!="utama"){
						$gdg = TRUE;
						$msggdg = $msggdg.$cell_gudang." (KOLOM:[M".",".$row."]), ";
					}
					
					#cek RAK
					$cell_kdrak = $worksheet->getCellByColumnAndRow(24,$row)->getCalculatedValue();
					if($cell_kdrak){						
						$dtrak		= $this->upload_act->getDataKodeUpload('gudang_tiga_level','',$cell_barang,$cell_jenis,'',$cell_gudang,
						$cell_kdrak);
						if(!in_array($cell_kdrak,$dtrak)){
							$koderak= TRUE;
							$msgkoderak = $msgkoderak.$cell_kdrak."(KOLOM:[N,".$row."]) di gudang ".$cell_gudang." (KOLOM:[M,".$row."]), ";
						}
					}					
					#cek SUBRAK
					$cell_kdsubrak = $worksheet->getCellByColumnAndRow(25,$row)->getCalculatedValue();
					if($cell_kdsubrak){						
						$dtsubrak = $this->upload_act->getDataKodeUpload('gudang_tiga_level','',$cell_barang,$cell_jenis,'',$cell_gudang,
						$cell_kdrak,$cell_kdsubrak);
						if(!in_array($cell_kdsubrak,$dtsubrak)){
							$kodesubrak= TRUE;
							$msgkodesubrak = $msgkodesubrak.$cell_kdsubrak."(KOLOM:[O,".$row."]) di rak ".$cell_kdrak.", ";
						}
					}
					#cek kondisi barang
					$cell_kondisi = $worksheet->getCellByColumnAndRow(22, $row)->getCalculatedValue();
					$cek_kondisi = $this->upload_act->getDataKodeUpload('kondisi','',$cell_barang,$cell_jenis,'',$cell_gudang,$cell_kdrak,$cell_kdsubrak,$cell_kondisi);
					if(!in_array(strtoupper($cell_kondisi),$cek_kondisi)){
						$kndisi = TRUE;
						$msgkondisi = $msgkondisi.$cell_kondisi." (KOLOM:[P,".$row."]), ";
					}

					#cek satuan
					$cell_satuan = $worksheet->getCellByColumnAndRow(19, $row)->getCalculatedValue();
					if($cell_satuan){
						if(!in_array(strtoupper($cell_satuan),$datasatuan)){
							$satuan = TRUE;
							$msgsatuan = $msgsatuan.$cell_satuan." (KOLOM:[T".",".$row."]), ";
						}	
						$inarraysatuan = $this->upload_act->getDataParameter('barang',$cell_barang,$cell_jenis);	
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
					if(in_array(trim(strtoupper($JENISDOKUMEN)),array('BC30','BC25','BC27KELUAR'))){
						$SQL =" SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL FROM M_TRADER_BARANG 
								WHERE KODE_BARANG='".$cell_barang."' AND JNS_BARANG='".$cell_jenis."' 
								AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
						$VAL=$this->db->query($SQL)->row(); 
						$STOCK_AKHIR = $VAL->STOCK_AKHIR;
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
						
						$arraytemp[] = $cell_barang.'|#|'.$cell_jenis;
						$arraytemp_jumlah[$cell_barang.'|#|'.$cell_jenis]["jumlah"][] = $JUMSSATS;														
						$JUMAKHIR = array_sum($arraytemp_jumlah[$cell_barang."|#|".$cell_jenis]["jumlah"]);
	
						if($JUMAKHIR > $STOCK_AKHIR){
							$stock = TRUE;
							$msgstock = $msgstock."Kode Barang: ".$cell_barang." dgn Jenis Barang: ".$cell_jenis.", ";
						}
						
						#cek saldo pemasukan
						$cell_kdmasuk = strtoupper($this->replace_character($worksheet->getCellByColumnAndRow(26, $row)->getCalculatedValue()));
						$cell_nomasuk = $this->replace_character($worksheet->getCellByColumnAndRow(27, $row)->getCalculatedValue());	
						$cell_tgmasuk = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(28,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);								
						if(strpos($cell_tgmasuk,"/")===false){
							$cell_tgmasuk = $cell_tgmasuk;	
						}else{
							$cell_tgmasuk = $this->fungsi->dateformat($cell_tgmasuk);		
						}
						
						if($cell_kdmasuk && $cell_nomasuk && $cell_tgmasuk){
							$SQL = "SELECT LOGID FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$kodetrader."' 
									AND JENIS_DOK='".$cell_kdmasuk."' AND NO_DOK='".$cell_nomasuk."' 
									AND TGL_DOK='".$cell_tgmasuk."' AND KODE_BARANG = '".$cell_barang."' 
									AND JNS_BARANG = '".$cell_jenis."'"; 
							if(!$this->main->get_result($SQL)){
								$logmasuk = TRUE;
								$msglogmasuk = $msglogmasuk."Dokumen ".$cell_kdmasuk." dgn Nomor Pendaftaran: ".$cell_nomasuk." dan Tanggal Pendaftaran : ".$cell_tgmasuk." dan Kode Barang : ".$cell_barang." dan Jenis Barang : ".$cell_jenis.".<br>";
							}
							
							#cek salo dokumen pemasukan
							$QUERY_SALDO = "SELECT SUM(SALDO) AS SALDO
											FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$kodetrader."' 
											AND (KODE_BARANG='".$cell_barang."' OR KODE_BARANG IN 
											(SELECT A.KODE_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B 
											WHERE A.IDBJ=B.IDBJ 
											AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER='".$kodetrader."' 
											AND (B.KODE_BARANG='". $cell_barang ."' OR 
											A.KODE_BARANG='". $cell_barang ."') AND 
											(A.JNS_BARANG = '".$cell_jenis."' OR B.JNS_BARANG = '".$cell_jenis."')))									
											AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') 
											AND JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') 
											AND NO_DOK = '".$cell_nomasuk."' AND TGL_DOK = '".$cell_tgmasuk."' 
											AND JENIS_DOK = '".$cell_kdmasuk."' 
											GROUP BY TGL_DOK,NO_DOK ASC ";
							$rs = $this->db->query($QUERY_SALDO);
							$arraytemp_pabean[] = $cell_barang.'|#|'.$cell_jenis.'|#|'.$cell_kdmasuk.'|#|'.$cell_nomasuk.'|#|'.$cell_tgmasuk;
							$arraytemp_jumlah_pabean[$cell_barang.'|#|'.$cell_jenis.'|#|'.$cell_kdmasuk.'|#|'.$cell_nomasuk.'|#|'.$cell_tgmasuk]["jumlahpabean"][] = $JUMSSATS;														
							$JUMAKHIR_PABEAN = array_sum($arraytemp_jumlah_pabean[$cell_barang.'|#|'.$cell_jenis.'|#|'.$cell_kdmasuk.'|#|'.$cell_nomasuk.'|#|'.$cell_tgmasuk]["jumlahpabean"]);
							if($rs->num_rows()>0){
								$data = $rs->row(); 
								$SALDO_MASUK = $data->SALDO;
								if($JUMAKHIR_PABEAN > $SALDO_MASUK){
									$saldomasuk = TRUE;
									$msgsaldomasuk = $msgsaldomasuk."Kode Barang = ".$cell_barang." dan Jenis Barang = ".$cell_jenis." dengan Nomor Pemasukan = ".$cell_nomasuk." dan Tanggal Pemasukan = ".$cell_tgmasuk." saldo yang tersedia adalah: ".$SALDO_MASUK." dan yang akan dikeluarkan sebesar: ".$JUMAKHIR_PABEAN."<br>";
								}
							}
						}else{
							$SQL = "SELECT JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO 
									FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$kodetrader."' 
									AND (KODE_BARANG='".$cell_barang."' OR KODE_BARANG IN 
						(SELECT A.KODE_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						 AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER='".$kodetrader."' 
						 AND (B.KODE_BARANG='". $cell_barang ."' OR A.KODE_BARANG='". $cell_barang ."')))									
									AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') AND JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') 
									ORDER BY TGL_DOK,NO_DOK,SERI_BARANG ASC";	
							if(!$this->main->get_result($SQL)){
								$logmasuk_fifo = TRUE;
								$msglogmasuk_fifo = $msglogmasuk_fifo."Kode Barang: ".$cell_barang."<br>";
							}				
						}
					}
					
					if($this->replace_character($worksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue())==""){
						break;	
					}						
				}
				if($kosong){
					$msg = "Terdapat data yang kosong pada kolom yang harus diisi, yaitu:<br> ".$msgkosong;	
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
				if($tipe){
					$msg ="Kode Dokumen tidak dikenali, yaitu:<br> ".$msgtipe;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($ajuvalid){
					$msg ="Nomor Aju hanya bisa berisi Numerik (angka), Terdapat Nomor Aju yang tidak valid, yaitu:<br> ".$msgajuvalid;	
					$error .= $this->fungsi->msg("warning",$msg);	
				}				
				if($noaju){
					$msg ="Nomor Aju sudah ada dalam database* (User anda atau user perusahaan lain), yaitu:<br> ".$msgnoaju;	
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
				if($logmasuk){
					$msg ="Terdapat Dokumen Pemasukan yang tidak dikenali, yaitu:<br> ".$msglogmasuk;
					$error .= $this->fungsi->msg("error",$msg);	
				}		
				if($logmasuk_fifo){
					$msg ="Kode Barang Berikut tidak ditemukan Saldo Dokumen pemasukannya, yaitu:<br> ".$msglogmasuk_fifo;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($saldomasuk){
					$msg ="Terdapat Saldo Pemasukan Barang yang tidak mencukupi , yaitu:<br> ".$msgsaldomasuk;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($stock){
					$msg ="Stock Barang tidak mencukupi (*perhatikan Jumlah konversi satuannya), yaitu:<br> ".$msgstock;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($kndisi){
					$msg ="Kondisi barang tidak sesuai: ".$msgkondisi;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($gdg){
					$msg ="Kode gudang berikut tidak tersedia: ".$msggdg;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				if($koderak){
					$msg = "Kode rak berikut tidak tersedia : ".$msgkoderak;
					$error .= $this->fungsi->msg("error",$msg);
				}
				if($kodesubrak){
					$msg = "Kode sub rak berikut tidak tersedia : ".$msgkodesubrak;
					$error .= $this->fungsi->msg("error",$msg);
				}			
				if($error){
					unlink($file);
					echo $this->load->view('upload/pabean',array("proses"=>"error","msg"=>$error),true);
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
							$KDDOK = strtoupper(str_replace(" ","",$worksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue()));
							$CAR = $this->replace_character($worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());											
							$TGL1 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(5,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);								
							if(strpos($TGL1,"/")===false){
								$TGL1 = $TGL1;	
							}else{
								$TGL1 = $this->fungsi->dateformat($TGL1);		
							}											
							$TGL3 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(9,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL3,"/")===false){
								$TGL3 = $TGL3;	
							}else{
								$TGL3 = $this->fungsi->dateformat($TGL3);		
							}							
							$NODAFTAR = $worksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue();
							$PARSIAL = strtoupper($worksheet->getCellByColumnAndRow(21, $row)->getCalculatedValue());
							$NODOKINTERNAL = $worksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();
							$PEMASOK = $worksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
							$KONDISI = $worksheet->getCellByColumnAndRow(22, $row)->getCalculatedValue();
							$KD_GUDANG = $worksheet->getCellByColumnAndRow(23, $row)->getCalculatedValue();
							$KD_RAK = $worksheet->getCellByColumnAndRow(24, $row)->getCalculatedValue();
							$KD_SUB_RAK = $worksheet->getCellByColumnAndRow(25, $row)->getCalculatedValue();
							
							#==================================================================================================================
							/*$KD_DOKMASUK = strtoupper($this->replace_character($worksheet->getCellByColumnAndRow(22,$row)->getCalculatedValue()));
							$NO_DOKMASUK = $this->replace_character($worksheet->getCellByColumnAndRow(23, $row)->getCalculatedValue());	
							$TG_DOKMASUK = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(24,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TG_DOKMASUK,"/")===false){
								$TG_DOKMASUK = $TG_DOKMASUK;	
							}else{
								$TG_DOKMASUK = $this->fungsi->dateformat($TG_DOKMASUK);		
							}*/	
							#==================================================================================================================
							
							
							if($row!=2){
								$no=1;
							}						
						}else{
							$X = $row-($row-($row-$no));
							$KDDOK = strtoupper(str_replace(" ","",$worksheet->getCellByColumnAndRow(0, $X)->getCalculatedValue()));
							$CAR = $this->replace_character($worksheet->getCellByColumnAndRow(1, $X)->getCalculatedValue());															
							$TGL1 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(5, $X)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL1,"/")===false){
								$TGL1 = $TGL1;	
							}else{
								$TGL1 = $this->fungsi->dateformat($TGL1);		
							}
							$TGL3 = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(9,$X)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TGL3,"/")===false){
								$TGL3 = $TGL3;	
							}else{
								$TGL3 = $this->fungsi->dateformat($TGL3);		
							}	
							$NODAFTAR = $worksheet->getCellByColumnAndRow(4, $X)->getCalculatedValue();
							$PARSIAL = strtoupper($worksheet->getCellByColumnAndRow(21, $X)->getCalculatedValue());
							$NODOKINTERNAL = $worksheet->getCellByColumnAndRow(8, $X)->getCalculatedValue();
							$PEMASOK = $worksheet->getCellByColumnAndRow(3, $X)->getCalculatedValue();
							$KONDISI = $worksheet->getCellByColumnAndRow(22, $X)->getCalculatedValue();
							$KD_GUDANG = $worksheet->getCellByColumnAndRow(23, $X)->getCalculatedValue();
							$KD_RAK = $worksheet->getCellByColumnAndRow(24, $X)->getCalculatedValue();
							$KD_SUB_RAK = $worksheet->getCellByColumnAndRow(25, $X)->getCalculatedValue();
							
							#==================================================================================================================
							/*$KD_DOKMASUK = strtoupper($this->replace_character($worksheet->getCellByColumnAndRow(22, $X)->getCalculatedValue()));
							$NO_DOKMASUK = $this->replace_character($worksheet->getCellByColumnAndRow(23, $X)->getCalculatedValue());	
							$TG_DOKMASUK = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(24,$X)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TG_DOKMASUK,"/")===false){
								$TG_DOKMASUK = $TG_DOKMASUK;	
							}else{
								$TG_DOKMASUK = $this->fungsi->dateformat($TG_DOKMASUK);		
							}*/	
							#==================================================================================================================
							
							
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
							if(substr($KDDOK,0,4)=="BC27" || substr($KDDOK,0,4)=="BC30"){
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
								$DATADETAIL[$index]['PARSIAL_FLAG'] = $PARSIAL;
								$DATADETAIL[$index]['NOMOR_AJU'] = $CAR;
								$DATADETAIL[$index]['KODE_DOK'] = $KDDOK;
								$DATADETAIL[$index]['SERI'] = $SERIAL;	
								$DATADETAIL[$index][$fieldDetil[$indexDetail]] = $cell->getCalculatedValue();							
								
								$DATAINOUT[$index]['PARSIAL_FLAG'] = $PARSIAL;														
								$DATAINOUT[$index]['NOMOR_AJU'] = $CAR;
								$DATAINOUT[$index]['KODE_DOK'] = $KDDOK;
								$DATAINOUT[$index]['TANGGAL_DOKUMEN'] = $TGL1;
								$DATAINOUT[$index]['TANGGAL'] = $TGL3;
								$DATAINOUT[$index]['TANGGAL_PENDAFTARAN'] = $TGL1;
								$DATAINOUT[$index]['NOMOR_PENDAFTARAN'] = $NODAFTAR;
								$DATAINOUT[$index]['SERI'] = $SERIAL;	
								$DATAINOUT[$index]['KONDISI_BARANG'] = $KONDISI;
								$DATAINOUT[$index]['KODE_GUDANG'] = $KD_GUDANG;
								$DATAINOUT[$index]['KODE_RAK'] = $KD_RAK ;
								$DATAINOUT[$index]['KODE_SUB_RAK'] = $KD_SUB_RAK;
								$DATAINOUT[$index][$fieldInOut[$indexDetail]] = $cell->getCalculatedValue();																											
								
							#==================================================================================================================
							$KD_DOKMASUK = strtoupper($this->replace_character($worksheet->getCellByColumnAndRow(26,$row)->getCalculatedValue()));
							$NO_DOKMASUK = $this->replace_character($worksheet->getCellByColumnAndRow(27, $row)->getCalculatedValue());	
							$TG_DOKMASUK = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(28,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
							if(strpos($TG_DOKMASUK,"/")===false){
								$TG_DOKMASUK = $TG_DOKMASUK;	
							}else{
								$TG_DOKMASUK = $this->fungsi->dateformat($TG_DOKMASUK);		
							}	
							#==================================================================================================================
							
							
								$DATAINOUT[$index]['KODE_DOK_MASUK'] = $KD_DOKMASUK;	
								$DATAINOUT[$index]['NOMOR_DOK_MASUK'] = $NO_DOKMASUK;	
								$DATAINOUT[$index]['TANGGAL_DOK_MASUK'] = $TG_DOKMASUK;		
									
								if($worksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue()){	
									//if($index>0){
										$recordparsial = true;
									//}
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
									$DATAPARSIAL[$index]['SERI'] = $SERIAL;
									$DATAPARSIAL[$index]['KONDISI_BARANG'] = $KONDISI;
									$DATAPARSIAL[$index]['KODE_GUDANG'] = $KD_GUDANG;
									$DATAPARSIAL[$index]['KODE_RAK'] = $KD_RAK ;
									$DATAPARSIAL[$index]['KODE_SUB_RAK'] = $KD_SUB_RAK;	
									$DATAPARSIAL[$index][$fieldInOut[$indexDetail]] = $cell->getCalculatedValue();										
								}
								$indexDetail++;		
							}
						}
						$index++;
						$SERIARRAY[] = $CAR;
						$NEXTSARRAY[$CAR] = $SERIAL;
					}
					//print_r($DATAINOUT);die();
					if($proses){
						$query = "SELECT KODE_ID, ID, NAMA, ALAMAT, TELEPON, FAX, STATUS_TRADER, BIDANG_USAHA, 
								  KODE_API, NOMOR_API, NOMOR_SRP, NIPER FROM M_TRADER 
								  WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";	  		
						$rstrader=$this->db->query($query)->row(); 
						foreach($DATAHEADER as $VALHEADER){	
							$query1 = "SELECT * FROM M_TRADER_PARTNER WHERE NAMA_PARTNER='".$VALHEADER["NAMA_PEMASOK"]."'";	  		
							$rspartner = $this->db->query($query1)->row(); 

							unset($PROCESSHEADER);
							if(substr($VALHEADER["KODE_DOK"],0,4)=="BC27" || substr($VALHEADER["KODE_DOK"],0,4)=="BC30"){
								$DOKBC = substr($VALHEADER["KODE_DOK"],0,4);		
							}else{
								$DOKBC = $VALHEADER["KODE_DOK"];		
							}

							if($VALHEADER["NDPBM"]=="-"){
								$VALHEADER["NDPBM"] = NULL;
							}
							if($VALHEADER["PARSIAL_FLAG"]=="YA"){
								$FLAG = "Y";
							}
							
							$PROCESSHEADER["PARSIAL_FLAG"] = $FLAG;
							$PROCESSHEADER["KODE_TRADER"] = $kodetrader;
							$PROCESSHEADER["NOMOR_AJU"] = $VALHEADER["NOMOR_AJU"];
							$PROCESSHEADER["NOMOR_PENDAFTARAN"] = $VALHEADER["NOMOR_PENDAFTARAN"];
							$PROCESSHEADER["TANGGAL_PENDAFTARAN"] = $VALHEADER["TANGGAL_PENDAFTARAN"];
							$PROCESSHEADER["NOMOR_DOK_PABEAN"] = $VALHEADER["NOMOR_DOK_PABEAN"];
							$PROCESSHEADER["TANGGAL_DOK_PABEAN"] = $VALHEADER["TANGGAL_DOK_PABEAN"];
							$PROCESSHEADER["TANGGAL_DOK_PABEAN"] = $VALHEADER["TANGGAL_DOK_PABEAN"];
							$PROCESSHEADER["NOMOR_DOK_INTERNAL"] = $VALHEADER["NOMOR_DOK_INTERNAL"];
							$PROCESSHEADER["TANGGAL_DOK_INTERNAL"] = $VALHEADER["TANGGAL_DOK_INTERNAL"];
							$PROCESSHEADER["KODE_VALUTA"] = $VALHEADER["KODE_VALUTA"];
							$PROCESSHEADER["NDPBM"] = $VALHEADER["NDPBM"]?$VALHEADER["NDPBM"]:'0';
							$PROCESSHEADER["JUMLAH_DTL"] = $VALHEADER["JUMLAH_DTL"];
							$PROCESSHEADER["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
							$PROCESSHEADER["CREATED_BY"]= $this->newsession->userdata('USER_ID');
							
							if($DOKBC=="BC27"){
								$TIPE_DOK = str_replace(" ","",substr($VALHEADER["KODE_DOK"],4,strlen($VALHEADER["KODE_DOK"])-1));
								$PROCESSHEADER["KODE_KPBC_ASAL"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER['TIPE_DOK'] = $TIPE_DOK; 
								if($TIPE_DOK=="MASUK"){
									$PROCESSHEADER["NAMA_TRADER_ASAL"] = $VALHEADER["NAMA_PEMASOK"];
									if($rspartner){
										$PROCESSHEADER["KODE_ID_TRADER_ASAL"] = $rspartner->KODE_ID_PARTNER;
										$PROCESSHEADER["ID_TRADER_ASAL"] = $rspartner->ID_PARTNER;
										$PROCESSHEADER["ALAMAT_TRADER_ASAL"] = $rspartner->ALAMAT_PARTNER;
									}	
									$PROCESSHEADER["KODE_ID_TRADER_TUJUAN"] = $rstrader->KODE_ID;
									$PROCESSHEADER["ID_TRADER_TUJUAN"] = $rstrader->ID;
									$PROCESSHEADER["NAMA_TRADER_TUJUAN"] = $rstrader->NAMA;
									$PROCESSHEADER["ALAMAT_TRADER_TUJUAN"] = $rstrader->ALAMAT;
									$PROCESSHEADER["NOMOR_IZIN_TPB_TUJUAN"] = $rstrader->NIPER;
								}
								elseif($TIPE_DOK=="KELUAR"){	
									$PROCESSHEADER["NAMA_TRADER_TUJUAN"] = $VALHEADER["NAMA_PEMASOK"];
									if($rspartner){
										$PROCESSHEADER["KODE_ID_TRADER_TUJUAN"] = $rspartner->KODE_ID_PARTNER;
										$PROCESSHEADER["ID_TRADER_TUJUAN"] = $rspartner->ID_PARTNER;
										$PROCESSHEADER["ALAMAT_TRADER_TUJUAN"] = $rspartner->ALAMAT_PARTNER;
									}		
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
								$PROCESSHEADER["STATUS_TRADER"]	= $rstrader->STATUS_TRADER;
								$PROCESSHEADER["NIPER"]	= $rstrader->NIPER;
								$PROCESSHEADER["NAMA_PEMBELI"] = $VALHEADER["NAMA_PEMASOK"];
							}
							elseif($DOKBC=='BC16'){
								unset($PROCESSHEADER["NDPBM"]);
								unset($PROCESSHEADER["JUMLAH_DTL"]);
								$PROCESSHEADER["KODE_ID_TRADER"] = $rstrader->KODE_ID;
								$PROCESSHEADER["ID_TRADER"]	= $rstrader->ID;
								$PROCESSHEADER["NAMA_TRADER"] = $rstrader->NAMA;	
								$PROCESSHEADER["ALAMAT_TRADER"] = $rstrader->ALAMAT;
								$PROCESSHEADER["KODE_ID_PEMILIK"] = $rstrader->KODE_ID;
								$PROCESSHEADER["ID_PEMILIK"] = $rstrader->ID;
								$PROCESSHEADER["NAMA_PEMILIK"] = $rstrader->NAMA;	
								$PROCESSHEADER["ALAMAT_PEMILIK"] = $rstrader->ALAMAT;	
								$PROCESSHEADER["KODE_KPBC_BONGKAR"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["NAMA_PENGIRIM"] = $VALHEADER["NAMA_PEMASOK"];
								if($rspartner){
									$PROCESSHEADER["ALAMAT_PENGIRIM"] = $rspartner->ALAMAT_PARTNER;
									$PROCESSHEADER["NEGARA_PENGIRIM"] = $rspartner->NEGARA_PARTNER;	
								}
							}#--------------------------------------
							elseif($DOKBC=='BC24'){

							}
							#---------------------------------------
							elseif($DOKBC=='28'){
								$PROCESSHEADER["KODE_KANTOR_PABEAN"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["KODE_ID_IMPORTIR"] = $rstrader->KODE_ID;
								$PROCESSHEADER["ID_IMPORTIR"]	= $rstrader->ID;
								$PROCESSHEADER["NAMA_IMPORTIR"] = $rstrader->NAMA;	
								$PROCESSHEADER["ALAMAT_IMPORTIR"] = $rstrader->ALAMAT;		
								$PROCESSHEADER["STATUS_IMPORTIR"]	= $rstrader->STATUS_TRADER;
								$PROCESSHEADER["KODE_API"] = $rstrader->KODE_API;
								$PROCESSHEADER["NOMOR_API"] = $rstrader->NOMOR_API;
								$PROCESSHEADER["NAMA_PENJUAL"] = $VALHEADER["NAMA_PEMASOK"];
								if($rspartner){
									$PROCESSHEADER["KODE_ID_PENJUAL"] = $rspartner->KODE_ID_PARTNER;
									$PROCESSHEADER["ID_PENJUAL"] = $rspartner->ID_PARTNER;
									$PROCESSHEADER["ALAMAT_PENJUAL"] = $rspartner->ALAMAT_PARTNER;
									$PROCESSHEADER["NEGARA_PENJUAL"] = $rspartner->NEGARA_PARTNER;
								}
							}
							elseif($DOKBC=='BC41'){
								$PROCESSHEADER["KODE_ID_TRADER"] = $rstrader->KODE_ID;
								$PROCESSHEADER["ID_TRADER"]	= $rstrader->ID;
								$PROCESSHEADER["NAMA_TRADER"] = $rstrader->NAMA;	
								$PROCESSHEADER["ALAMAT_TRADER"] = $rstrader->ALAMAT;	
								$PROCESSHEADER["KODE_KPBC"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["NOMOR_IZIN_TPB"] = $rstrader->NIPER;
								$PROCESSHEADER["NAMA_PENERIMA"] = $VALHEADER["NAMA_PEMASOK"];	
							}
							elseif($DOKBC=='BC40'){
								$PROCESSHEADER["KODE_KPBC"] = $VALHEADER["KODE_KPBC"];
								$PROCESSHEADER["NOMOR_IZIN_TPB"] = $rstrader->NIPER;
								$PROCESSHEADER["NAMA_PENGIRIM"] = (string)$VALHEADER["NAMA_PEMASOK"];	
							}

							if($VALHEADER["PARSIAL_FLAG"]=="YA" || $VALHEADER["PARSIAL_FLAG"]=="Y"){																		
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
								$PROCESSDETIL["KODE_BARANG"] = $VALDETAIL["KODE_BARANG"];
								$PROCESSDETIL["JUMLAH_SATUAN"] = $VALDETAIL["JUMLAH_SATUAN"];
								$PROCESSDETIL["KODE_SATUAN"] = $VALDETAIL["KODE_SATUAN"];
								$PROCESSDETIL["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
								
								if(substr($VALDETAIL["KODE_DOK"],0,4)=="BC27" || substr($VALDETAIL["KODE_DOK"],0,4)=="BC30"){
									$DOKBC = substr($VALDETAIL["KODE_DOK"],0,4);		
								}else{
									$DOKBC = $VALDETAIL["KODE_DOK"];		
								}			
								
								//$SERIDTL = (int)$this->main->get_uraian("SELECT MAX(SERI) AS MAX FROM T_".$DOKBC."_DTL WHERE NOMOR_AJU='".$VALDETAIL["NOMOR_AJU"]."'", "MAX") + 1;
								$PROCESSDETIL["SERI"] = $VALDETAIL["SERI"];	
								
								if($DOKBC=="BC16"){								
									$PROCESSDETIL["HARGA_CIF"] = $VALDETAIL["CIF"];
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];
									$PROCESSDETIL["URAIAN_BARANG"] = $VALDETAIL["URAIAN_BARANG"];
									$PROCESSDETIL["KODE_HS"] = $VALDETAIL["KODE_HS"];
								}
								elseif($DOKBC=="BC24"){
									$PROCESSDETIL["HARGA_PENYERAHAN_DTL"] = $VALDETAIL["CIF"];	
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];
									$PROCESSDETIL["URAIAN_BARANG"] = $VALDETAIL["URAIAN_BARANG"];
									$PROCESSDETIL["NOHS"] = $VALDETAIL["KODE_HS"];
								}
								elseif($DOKBC=="BC27"){			
									$PROCESSDETIL["HARGA_PENYERAHAN"] = $VALDETAIL["CIF"];	
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];
									$PROCESSDETIL["URAIAN_BARANG"] = $VALDETAIL["URAIAN_BARANG"];
									$PROCESSDETIL["KODE_HS"] = $VALDETAIL["KODE_HS"];	
								}
								elseif($DOKBC=="BC28"){			
									$PROCESSDETIL["CIF"] = $VALDETAIL["CIF"];	
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];
									$PROCESSDETIL["URAIAN_BARANG"] = $VALDETAIL["URAIAN_BARANG"];
									$PROCESSDETIL["KODE_HS"] = $VALDETAIL["KODE_HS"];	
								}
								elseif($DOKBC=="BC30"){											
									$PROCESSDETIL["INVOICE"] = $VALDETAIL["CIF"];				
									$PROCESSDETIL["FOB_PER_BARANG"] = $VALDETAIL["CIF"];
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];	
									$PROCESSDETIL['URAIAN_BARANG1'] = $VALDETAIL["URAIAN_BARANG"];
									$PROCESSDETIL["KODE_HS"] = $VALDETAIL["KODE_HS"];
								}
								elseif($DOKBC=="BC40"){											
									$PROCESSDETIL["HARGA_PENYERAHAN"] = $VALDETAIL["CIF"];				
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];	
									$PROCESSDETIL['URAIAN_BARANG'] = $VALDETAIL["URAIAN_BARANG"];
									$PROCESSDETIL["KODE_HS"] = $VALDETAIL["KODE_HS"];
								}
								else{
									$PROCESSDETIL["CIF"] = $VALDETAIL["CIF"];	
									$PROCESSDETIL["JNS_BARANG"] = $VALDETAIL["JENIS_BARANG"];	
									$PROCESSDETIL["URAIAN_BARANG"] = $VALDETAIL["URAIAN_BARANG"];	
								}
								$PROCESSDETIL["STATUS"]="04";
								$execdetil = $this->db->insert("T_".$DOKBC."_DTL",$PROCESSDETIL);															    			
								$this->main->activity_log('ADD DETIL '.$DOKBC,'CAR='.$VALDETAIL["NOMOR_AJU"].', SERI='.$VALDETAIL["SERI"],'UPLOAD');
							}
						}
						if($execdetil){
							foreach($DATAHEADER as $VALHEAD){	
								if(substr($VALHEAD["KODE_DOK"],0,4)=="BC27" || substr($VALHEAD["KODE_DOK"],0,4)=="BC30"){
									$DOKBC = substr($VALHEAD["KODE_DOK"],0,4);		
								}else{
									$DOKBC = $VALHEAD["KODE_DOK"];		
								}	
								$this->db->where('NOMOR_AJU',$VALHEAD["NOMOR_AJU"]);
								$JUMLAH_DTL = $this->db->count_all_results("T_".$DOKBC."_DTL");								
								$SQL = "SELECT f_jumcif_".strtolower($DOKBC)."('".$VALHEAD["NOMOR_AJU"]."') AS JUM FROM DUAL";	
								$rs = $this->db->query($SQL)->row();		
								if($DOKBC=="BC30"){
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"]));
									$this->db->update("T_".$DOKBC."_HDR",array("FOB"=>$rs->JUM,"JUMLAH_DTL"=>$JUMLAH_DTL));														
								}
								elseif($DOKBC=="BC16"){
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"]));
									$this->db->update("T_".$DOKBC."_HDR",array("CIF_RP"=>$rs->JUM));																	
								}
								elseif($DOKBC=="BC24"){
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"]));
									$this->db->update("T_".$DOKBC."_HDR",array("HARGA_PENYERAHAN"=>$rs->JUM));																	
								}
								elseif($DOKBC=="BC40" || $DOKBC=="BC41"){
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"]));
									$this->db->update("T_".$DOKBC."_HDR",array("HARGA_PENYERAHAN"=>$rs->JUM,"JUMLAH_DTL"=>$JUMLAH_DTL));																	
								}
								elseif($DOKBC=="BC27" || $DOKBC=="BC28"){		
									$this->db->where(array('NOMOR_AJU' => $VALHEAD["NOMOR_AJU"]));
									$this->db->update("T_".$DOKBC."_HDR",array("CIF"=>$rs->JUM,"JUMLAH_DTL"=>$JUMLAH_DTL));	
								}
							}		
						}
						if($execdetil){
							#============PARSIAL========================================================================
							$NEXTID=1;
							foreach($DATAPARSIAL as $VALPARSIAL){															
								if($VALPARSIAL["PARSIAL_FLAG"]=="YA" || $VALPARSIAL["PARSIAL_FLAG"]=="Y"){
									if($this->replace_character($VALPARSIAL['NOMOR_PENDAFTARAN'])!="" && $VALPARSIAL['TANGGAL_PENDAFTARAN']!=""){																							
										if(substr($VALPARSIAL["KODE_DOK"],0,4)=="BC27" || substr($VALPARSIAL["KODE_DOK"],0,4)=="BC30"){
											$DOKBC = substr($VALPARSIAL["KODE_DOK"],0,4);		
										}else{
											$DOKBC = $VALPARSIAL["KODE_DOK"];		
										}		
										$SQL = "SELECT REALISASIID FROM t_temp_realisasi_parsial_hdr 
												WHERE NOMOR_AJU='".$VALPARSIAL["NOMOR_AJU"]."' 
												AND JENIS_DOK='".$DOKBC."'
												AND NO_DOK_INTERNAL='".$VALPARSIAL["NO_DOK_INTERNAL"]."' 
												AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
										$rs = $this->db->query($SQL);
										$SQL1 = "SELECT IFNULL(MAX(REALISASIDTLID)+1,0) AS REALISASIDTLID FROM T_TEMP_REALISASI_PARSIAL_DTL";
										$QUERY = $this->db->query($SQL1);
										$DTLID = $QUERY->REALISASIDTLID;
										if($rs->num_rows()>0){
											$data = $rs->row(); 
											$RELID = $data->REALISASIID;
											$DETIL["HDR_REFF"] = $RELID;
											$DETIL["REALISASIDTLID"] = $DTLID;	
											$DETIL["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
											$DETIL["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];	
											$DETIL["SATUAN"] = $VALPARSIAL["KODE_SATUAN"];	
											$DETIL["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
											$DETIL["SERI"] = $VALPARSIAL["SERI"];	
											$DETIL["NILAI_BARANG"] = (float)$VALPARSIAL["CIF"]/(float)$VALPARSIAL["JUMLAH"];
											$GUDANG["REALISASIDTLID"] = $DTLID;
											$GUDANG["HDR_REFF"] = $RELID;
											$GUDANG["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
											$GUDANG["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];
											$GUDANG["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
											$GUDANG["SERI"] = $VALPARSIAL["SERI"];
											$GUDANG["KODE_GUDANG"] = $VALPARSIAL["KODE_GUDANG"];
											$GUDANG["KONDISI_BARANG"] = $VALPARSIAL["KONDISI_BARANG"];
											$GUDANG["KODE_RAK"] = $VALPARSIAL["KODE_RAK"];
											$GUDANG["KODE_SUB_RAK"] = $VALPARSIAL["KODE_SUB_RAK"];
											$this->db->insert('t_temp_realisasi_parsial_dtl',$DETIL);
											$this->db->insert('t_temp_realisasi_parsial_gudang',$GUDANG);
										}else{	
											$RELID = $this->newsession->userdata('USER_ID').date('ymdHis').sprintf("%06d", $NEXTID);
											$HEADER["REALISASIID"] = $RELID;
											$HEADER["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
											$HEADER["NOMOR_AJU"] = $VALPARSIAL["NOMOR_AJU"];
											$HEADER["JENIS_DOK"] = $DOKBC;
											if($this->db->insert('t_temp_realisasi_parsial_hdr',$HEADER)){											
												$DETIL["HDR_REFF"] = $RELID;
												$DETIL["REALISASIDTLID"] = $DTLID;	
												$DETIL["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
												$DETIL["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];	
												$DETIL["SATUAN"] = $VALPARSIAL["KODE_SATUAN"];	
												$DETIL["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
												$DETIL["SERI"] = $VALPARSIAL["SERI"];	
												$DETIL["NILAI_BARANG"] = (float)$VALPARSIAL["CIF"]/(float)$VALPARSIAL["JUMLAH"];	
												$GUDANG["REALISASIDTLID"] = $DTLID;
												$GUDANG["HDR_REFF"] = $RELID;
												$GUDANG["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
												$GUDANG["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];
												$GUDANG["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
												$GUDANG["SERI"] = $VALPARSIAL["SERI"];
												$GUDANG["KODE_GUDANG"] = $VALPARSIAL["KODE_GUDANG"];
												$GUDANG["KONDISI_BARANG"] = $VALPARSIAL["KONDISI_BARANG"];
												$GUDANG["KODE_RAK"] = $VALPARSIAL["KODE_RAK"];
												$GUDANG["KODE_SUB_RAK"] = $VALPARSIAL["KODE_SUB_RAK"];
												$this->db->insert('t_temp_realisasi_parsial_dtl',$DETIL);
												$this->db->insert('t_temp_realisasi_parsial_gudang',$GUDANG);
											}
											$NEXTID++;	
										}
									}
								}
							}
							#==========================================================================================	
						}
						if($execdetil){		
							$INDEXPARSIAL=0;					
							foreach($DATAINOUT as $VALINOUT){	
								unset($PROCESSINOUT);	
								if($this->replace_character($VALINOUT['NOMOR_PENDAFTARAN'])!="" && $VALINOUT['TANGGAL_PENDAFTARAN']!=""){
									#PROSES MASUK									
									$KODE_DOK = $VALINOUT["KODE_DOK"];
									if(in_array($KODE_DOK,$getin)){	
										$PROCESSINOUT["TIPE"] = "GATE-IN";  
										if(substr($VALINOUT["KODE_DOK"],0,4)=="BC27" || substr($VALINOUT["KODE_DOK"],0,4)=="BC30"){
											$DOKBC = substr($VALINOUT["KODE_DOK"],0,4);		
										}else{
											$DOKBC = $VALINOUT["KODE_DOK"];		
										}																				
										$PROCESSINOUT["PROCESS_WITH"] = "UPLOAD";	
										$PROCESSINOUT["KODE_TRADER"] = $kodetrader;	
										$PROCESSINOUT["KODE_BARANG"] = $VALINOUT['KODE_BARANG'];
										$PROCESSINOUT["JNS_BARANG"] = $VALINOUT['JNS_BARANG'];
										$PROCESSINOUT["KODE_DOKUMEN"] = $DOKBC;
										$PROCESSINOUT["TANGGAL_DOKUMEN"] = $VALINOUT['TANGGAL_PENDAFTARAN'];
										$PROCESSINOUT["NOMOR_AJU"] = $VALINOUT['NOMOR_AJU'];
										$PROCESSINOUT["JUMLAH"] = $VALINOUT['JUMLAH'];
										$PROCESSINOUT["TANGGAL"] = $VALINOUT['TANGGAL'];
										$PROCESSINOUT["SERI_DOKUMEN"] = $VALINOUT['SERI'];
										$PROCESSINOUT["KONDISI_BARANG"] = $VALINOUT['KONDISI_BARANG'];
										$PROCESSINOUT["KODE_GUDANG"] = $VALINOUT['KODE_GUDANG'];
										$PROCESSINOUT["KODE_RAK"] = $VALINOUT['KODE_RAK'];
										$PROCESSINOUT["KODE_SUB_RAK"] = $VALINOUT['KODE_SUB_RAK'];
										$PROCESSINOUT["PARSIAL_FLAG"] = $VALINOUT['PARSIAL_FLAG'];
										
										$SQL2="SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
											   FROM M_TRADER_BARANG WHERE KODE_BARANG='".$VALINOUT["KODE_BARANG"]."' 
											   AND JNS_BARANG='".$VALINOUT["JNS_BARANG"]."' 
											   AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
											   
										$VALBRG=$this->db->query($SQL2)->row(); 
										$STOCK_AKHIR = $VALBRG->STOCK_AKHIR;
										$kdsatuanBesar = $VALBRG->KODE_SATUAN;
										$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
										$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
																				
										if($VALINOUT["PARSIAL_FLAG"]=="YA" || $VALINOUT["PARSIAL_FLAG"]=="Y"){
											$SQLINOUT = "SELECT IFNULL(f_jum_inout('".$VALINOUT['NOMOR_AJU']."','".$DOKBC."','".$kodetrader."','".$VALINOUT["KODE_BARANG"]."','".$VALINOUT["JNS_BARANG"]."','".$VALINOUT['KODE_SATUAN']."','".$VALINOUT["SERI"]."'),0) AS JUMLAH_INOUT FROM DUAL";
											#echo $SQLINOUT;die();
											$RSINOUT = $this->db->query($SQLINOUT);	
											$JUMUDAHINOUT=0;
											if($RSINOUT->num_rows()>0){
												$VALINOUT_OLD = $RSINOUT->row();	
												$JUMUDAHINOUT = $VALINOUT_OLD->JUMLAH_INOUT;
											}
											$VALINOUT['JUMLAH'] = $VALINOUT["JUMLAH"]-$JUMUDAHINOUT;
										}else{
											$VALINOUT['JUMLAH'] = $VALINOUT["JUMLAH"];
										}
		
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
										
										$STKLOG = "";
										/*$this->db->where(array("KODE_BARANG"=>$VALINOUT['KODE_BARANG'],
															   "JNS_BARANG"=>$VALINOUT['JNS_BARANG'],
															   "KODE_TRADER"=>$kodetrader));
										$exec = $this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$STOCK_AKHIR+$JUMLAH_BARANG));*/
										/*$exec = $this->db->query("UPDATE M_TRADER_BARANG 
														SET STOCK_AKHIR = STOCK_AKHIR + ".$JUMLAH_BARANG." 
														WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'
														AND KODE_BARANG = '".$VALINOUT['KODE_BARANG']."'
														AND JNS_BARANG = '".$VALINOUT['JNS_BARANG']."'");*/
										#update stock barang gudang
										$sqlUpdate = "UPDATE M_TRADER_BARANG_GUDANG 
													SET JUMLAH = JUMLAH + ".$JUMLAH_BARANG." 
													WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'
													AND KODE_BARANG = '".$VALINOUT['KODE_BARANG']."'
													AND JNS_BARANG = '".$VALINOUT['JNS_BARANG']."'
													AND KODE_GUDANG = '".$VALINOUT['KODE_GUDANG']."'
													AND KONDISI_BARANG = '".$VALINOUT['KONDISI_BARANG']."'";
										if($VALINOUT['KODE_RAK']!=""){
											$sqlUpdate .= " AND KODE_RAK='".$VALINOUT['KODE_RAK']."'";
										}
										if($VALINOUT['KODE_SUB_RAK']!=""){
											$sqlUpdate .= " AND KODE_SUB_RAK='".$VALINOUT['KODE_SUB_RAK']."'";
										}

										$exec1 = $this->db->query($sqlUpdate);											
										$STKLOG = $STOCK_AKHIR+$JUMLAH_BARANG;
										
										if($exec1){	
											$PROSESPARSIAL = FALSE;									
											if($VALINOUT["PARSIAL_FLAG"]=="YA" || $VALINOUT["PARSIAL_FLAG"]=="Y"){								
												$SQL = "SELECT TANGGAL_REALISASI, STATUS FROM T_".$DOKBC."_HDR WHERE NOMOR_AJU='".$VALINOUT["NOMOR_AJU"]."' AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
												$rs=$this->db->query($SQL)->row(); 
												if($rs->TANGGAL_REALISASI!="" && $rs->STATUS=="07"){								
													$exechdr = true;
												}else{
													$this->db->where(array("NOMOR_AJU"=>$VALINOUT['NOMOR_AJU'],"KODE_TRADER"=>$kodetrader));
													$DATAHDR = array("STATUS"=>"19","TANGGAL_REALISASI"=>$VALINOUT['TANGGAL'],
																	 "PARSIAL_FLAG"=>"Y");
													$exechdr = $this->db->update("T_".$DOKBC."_hdr",$DATAHDR);											
												}												
												$INOUT["TIPE"] = "GATE-IN";  
												$INOUT["KODE_TRADER"] = $kodetrader;	
												$INOUT["KODE_DOKUMEN"] = $DOKBC;
												$INOUT["TANGGAL_DOKUMEN"] = $VALINOUT['TANGGAL_PENDAFTARAN'];
												$INOUT["NOMOR_AJU"] = $VALINOUT['NOMOR_AJU'];
												$INOUT["PROCESS_WITH"] = "UPLOAD";
												$INOUT["TANGGAL"] = $VALINOUT['TANGGAL'];
												$INOUT["SERI_DOKUMEN"] = $VALINOUT['SERI'];
												$INOUT["KONDISI_BARANG"] = $VALINOUT['KONDISI_BARANG'];
												$INOUT["KODE_GUDANG"] = $VALINOUT['KODE_GUDANG'];
												$INOUT["KODE_RAK"] = $VALINOUT['KODE_RAK'];
												$INOUT["KODE_SUB_RAK"] = $VALINOUT['KODE_SUB_RAK'];
												$INOUT["PARSIAL_FLAG"] = $VALINOUT['PARSIAL_FLAG'];
												
												$LOG["JENIS_DOK"] = $DOKBC;
												$LOG["NO_DOK"] = $VALINOUT['NOMOR_PENDAFTARAN'];
												$LOG["TGL_DOK"] = $VALINOUT['TANGGAL_PENDAFTARAN'];
												$LOG["TGL_MASUK"] = $VALINOUT['TANGGAL'];
												$LOG["KODE_TRADER"] = $kodetrader;
												$LOG["SERI_BARANG"] = $VALINOUT['SERI'];
												
												$execp=$this->proses_realisasi_parsial_in($DOKBC,$VALINOUT['NOMOR_AJU'],$VALINOUT,$VALINOUT,$INOUT,$LOG);	
												if($execp){
													if($execp=="CEKKEBIASA"){
														$execfinal = $this->proses_realisasi_biasa($DOKBC,$VALINOUT['NOMOR_AJU'],$VALINOUT,$INOUT,$LOG);
													}
													$execfinal = true;
												}									
												$SQLINOUT = $this->db->query("SELECT IFNULL(f_jum_inout('".$VALINOUT['NOMOR_AJU']."','".$DOKBC."','".$kodetrader."','".$VALINOUT['KODE_BARANG']."','".$VALINOUT['JNS_BARANG']."','".$VALINOUT['KODE_SATUAN']."','".$VALINOUT['SERI']."'),0) AS JUMLAH_INOUT FROM DUAL");
												$JUMLAH_INOUT=0;
												if($SQLINOUT->num_rows()>0){
													$RS = $SQLINOUT->row();
													$JUMLAH_INOUT = $RS->JUMLAH_INOUT;
												}
												if($JUMLAH_INOUT==$VALINOUT["JUMLAH"]){
													$this->db->where(array('NOMOR_AJU'=>$VALINOUT['NOMOR_AJU']));
													$this->db->update('t_'.strtolower($DOKBC).'_hdr', array("STATUS_REALISASI"=>"1"));	
												}

												//$INDEXPARSIAL++;
											}else{
												$this->db->where(array("NOMOR_AJU"=>$VALINOUT['NOMOR_AJU'],"KODE_TRADER"=>$kodetrader));
												$DATAHDR = array("STATUS"=>"19","TANGGAL_REALISASI"=>$VALINOUT['TANGGAL'],
																 "STATUS_REALISASI"=>"1");
												$exehdr = $this->db->update("T_".$DOKBC."_hdr",$DATAHDR);
											}																				
										}
										if($exehdr){
											$seriInOut = (int)$this->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_barang_inout", "MAX") + 1;
											$PROCESSINOUT["SERI"] = $seriInOut;
											$PROCESSINOUT["JUMLAH"] = $JUMLAH_BARANG;
											$PROCESSINOUT["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
											$execfinal = $this->db->insert("m_trader_barang_inout",$PROCESSINOUT);		
											
											if($PROCESSINOUT["TIPE"]=="GATE-IN"){											
												$LOG["JENIS_DOK"] = $DOKBC;
												$LOG["NO_DOK"] = $VALINOUT['NOMOR_PENDAFTARAN'];
												$LOG["TGL_DOK"] = $VALINOUT['TANGGAL_PENDAFTARAN'];
												$LOG["TGL_MASUK"] = $VALINOUT['TANGGAL'];
												$LOG["KODE_TRADER"] = $kodetrader;
												$LOG["KODE_BARANG"] = $VALINOUT["KODE_BARANG"];
												$LOG["JNS_BARANG"] = $VALINOUT["JNS_BARANG"];
												$LOG["SERI_BARANG"] = $VALINOUT['SERI'];
												$LOG["NAMA_BARANG"] = $VALINOUT["URAIAN_BARANG"];
												$LOG["SATUAN"] = $kdsatuanKecil;
												$LOG["JUMLAH"] = $JUMLAH_BARANG;		
												$LOG["SALDO"] = $JUMLAH_BARANG;	
												$LOG["NILAI_PABEAN"] = $VALINOUT["CIF"];
												$LOG["NOMOR_AJU"] = $VALINOUT["NOMOR_AJU"];
												$this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);		
											}								
										}		
									}
									elseif(in_array($KODE_DOK, $getout)){
										#PROSES KELUAR
										if(substr($VALINOUT["KODE_DOK"],0,4)=="BC27" || substr($VALINOUT["KODE_DOK"],0,4)=="BC30"){
											$DOKBC = substr($VALINOUT["KODE_DOK"],0,4);		
										}else{
											$DOKBC = $VALINOUT["KODE_DOK"];		
										}	
																				
										/*$SERIBARANG = (int)$this->main->get_uraian("SELECT SERI FROM T_".$DOKBC."_DTL WHERE NOMOR_AJU='".$VALINOUT["NOMOR_AJU"]."' AND KODE_BARANG='".$VALINOUT["KODE_BARANG"]."' AND JNS_BARANG='".$VALINOUT["JNS_BARANG"]."'", "SERI");*/
											
										$INOUT["TIPE"] = "GATE-OUT";
										$INOUT["KODE_TRADER"] = $kodetrader;	
										$INOUT["KODE_DOKUMEN"] = $DOKBC;
										$INOUT["TANGGAL_DOKUMEN"] = $VALINOUT['TANGGAL_PENDAFTARAN'];
										$INOUT["NOMOR_AJU"] = $VALINOUT['NOMOR_AJU'];
										$INOUT["PROCESS_WITH"] = "UPLOAD";
										$INOUT["TANGGAL"] = $VALINOUT['TANGGAL'];
										$INOUT["SERI_DOKUMEN"] = $VALINOUT['SERI'];
										
										
										$LOG["JENIS_DOK"] = $DOKBC;
										$LOG["NO_DOK"] = $VALINOUT['NOMOR_PENDAFTARAN'];
										$LOG["TGL_DOK"] = $VALINOUT['TANGGAL_PENDAFTARAN'];
										$LOG["TGL_MASUK"] = $VALINOUT['TANGGAL'];
										$LOG["KODE_TRADER"] = $kodetrader;
										$LOG["SERI_BARANG"] = $VALINOUT['SERI'];
										$LOG["NOMOR_AJU"] = $VALINOUT['NOMOR_AJU'];
										
										if($VALINOUT["PARSIAL_FLAG"]=="YA" || $VALINOUT["PARSIAL_FLAG"]=="Y"){																			
											/*if($INDEXPARSIAL==0){
												$this->db->where(array("NOMOR_AJU"=>$VALINOUT['NOMOR_AJU'],"KODE_TRADER"=>$kodetrader));
												$DATAHDR = array("STATUS"=>"19","TANGGAL_REALISASI"=>$VALINOUT['TANGGAL'],
																	 "PARSIAL_FLAG"=>"Y");
												$exechdr = $this->db->update("T_".$DOKBC."_hdr",$DATAHDR);	
											}else{
												$exechdr = true;	
											}*/
											
											if($VALINOUT['KODE_DOK_MASUK'] && $VALINOUT['NOMOR_DOK_MASUK'] && $VALINOUT['TANGGAL_DOK_MASUK']){
												$execfinal = $this->realisasi_have_dokmasuk($DOKBC,$VALINOUT['NOMOR_AJU'],$VALINOUT,$INOUT,$LOG);
											}else{
												$execp=$this->proses_realisasi_parsial_out($DOKBC,$VALINOUT['NOMOR_AJU'],$VALINOUT,$VALINOUT,$INOUT,$LOG);											
												if($execp){
													if($execp=="CEKKEBIASA"){
														$execfinal = $this->proses_realisasi_biasa($DOKBC,$VALINOUT['NOMOR_AJU'],$VALINOUT,$INOUT,$LOG);
													}
												}
												$execfinal = true;
											}
												
											$SQLINOUT = $this->db->query("SELECT IFNULL(f_jum_inout('".$VALINOUT['NOMOR_AJU']."','".$DOKBC."','".$kodetrader."','".$VALINOUT['KODE_BARANG']."','".$VALINOUT['JNS_BARANG']."','".$VALINOUT['KODE_SATUAN']."','".$VALINOUT['SERI']."'),0) AS JUMLAH_INOUT FROM DUAL");
											$JUMLAH_INOUT=0;
											if($SQLINOUT->num_rows()>0){
												$RS = $SQLINOUT->row();
												$JUMLAH_INOUT = $RS->JUMLAH_INOUT;
											}
											if($JUMLAH_INOUT==$VALINOUT["JUMLAH"]){
												$this->db->where(array('NOMOR_AJU'=>$VALINOUT['NOMOR_AJU']));
												$this->db->update('t_'.strtolower($DOKBC).'_hdr', array("STATUS_REALISASI"=>"1"));	
											}	
											
											$SQL = "SELECT TANGGAL_REALISASI, STATUS FROM T_".$DOKBC."_HDR WHERE NOMOR_AJU='".$VALINOUT["NOMOR_AJU"]."' AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
											$rs=$this->db->query($SQL)->row(); 
											if($rs->TANGGAL_REALISASI!="" && $rs->STATUS=="07"){								
												$exechdr = true;
											}else{
												$this->db->where(array("NOMOR_AJU"=>$VALINOUT['NOMOR_AJU'],"KODE_TRADER"=>$kodetrader));
												$DATAHDR = array("STATUS"=>"19","TANGGAL_REALISASI"=>$VALINOUT['TANGGAL'],
																 "PARSIAL_FLAG"=>"Y");
												$exechdr = $this->db->update("T_".$DOKBC."_hdr",$DATAHDR);											
											}
															
											//$INDEXPARSIAL++;
										}else{
											if($VALINOUT['KODE_DOK_MASUK'] && $VALINOUT['NOMOR_DOK_MASUK'] && $VALINOUT['TANGGAL_DOK_MASUK']){
												$execfinal = $this->realisasi_have_dokmasuk($DOKBC,$VALINOUT['NOMOR_AJU'],$VALINOUT,$INOUT,$LOG);
											}else{
												$execfinal = $this->proses_realisasi_biasa($DOKBC,$VALINOUT['NOMOR_AJU'],$VALINOUT,$INOUT,$LOG);	
											}	
											if($execfinal){
												$this->db->where(array("NOMOR_AJU"=>$VALINOUT['NOMOR_AJU'],"KODE_TRADER"=>$kodetrader));
												$DATAHDR = array("STATUS"=>"19","TANGGAL_REALISASI"=>$VALINOUT['TANGGAL']);
												$this->db->update("T_".$DOKBC."_hdr",$DATAHDR);
											}
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
								if($VALPARSIAL["PARSIAL_FLAG"]=="YA"){
									if($this->replace_character($VALPARSIAL['NOMOR_PENDAFTARAN'])!="" && $VALPARSIAL['TANGGAL_PENDAFTARAN']!=""){	
									
										if(substr($VALPARSIAL["KODE_DOK"],0,4)=="BC27" || substr($VALPARSIAL["KODE_DOK"],0,4)=="BC30"){
											$DOKBC = substr($VALPARSIAL["KODE_DOK"],0,4);		
										}else{
											$DOKBC = $VALPARSIAL["KODE_DOK"];		
										}	
										
										$SQL = "SELECT REALISASIID FROM t_temp_realisasi_parsial_hdr 
												WHERE NOMOR_AJU='".$VALPARSIAL["NOMOR_AJU"]."' 
												AND JENIS_DOK='".$DOKBC."'
												AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
										$hasil = $this->main->get_result($SQL);
										if($hasil){
											foreach($SQL->result_array() as $row){
												$this->db->where(array('HDR_REFF'=>$row['REALISASIID']));
												$this->db->delete('t_temp_realisasi_parsial_dtl');	
												$this->db->where(array('REALISASIID'=>$row['REALISASIID']));
												$this->db->delete('t_temp_realisasi_parsial_hdr');	
											}
										}												
																																									
										$SQL = "SELECT REALISASIID FROM t_realisasi_parsial_hdr 
												WHERE NOMOR_AJU='".$VALPARSIAL["NOMOR_AJU"]."' 
												AND JENIS_DOK='".$DOKBC."'
												AND NO_DOK_INTERNAL='".$VALPARSIAL["NO_DOK_INTERNAL"]."' 
												AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
										$rs = $this->db->query($SQL);
										$SQLID = "SELECT IFNULL(MAX(REALISASIDTLID)+1,0) AS REALISASIDTLID FROM T_REALISASI_PARSIAL_DTL";
										$QUE = $this->db->query($SQLID);
										$DTL_ID = $QUE->REALISASIDTLID;
										if($rs->num_rows()>0){
											$data = $rs->row(); 
											$RELID = $data->REALISASIID;
											$DETIL["HDR_REFF"] = $RELID;	
											$DETIL["REALISASIDTLID"] = $DTL_ID;
											$DETIL["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
											$DETIL["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];	
											$DETIL["SATUAN"] = $VALPARSIAL["KODE_SATUAN"];	
											$DETIL["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
											$DETIL["NILAI_BARANG"] = (float)$VALPARSIAL["CIF"]/(float)$VALPARSIAL["JUMLAH"];
											$GUDANG["REALISASIDTLID"] = $DTL_ID;
											$GUDANG["HDR_REFF"] = $RELID;
											$GUDANG["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
											$GUDANG["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];
											$GUDANG["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
											$GUDANG["SERI"] = $VALPARSIAL["SERI"];
											$GUDANG["KODE_GUDANG"] = $VALPARSIAL["KODE_GUDANG"];
											$GUDANG["KONDISI_BARANG"] = $VALPARSIAL["KONDISI_BARANG"];
											$GUDANG["KODE_RAK"] = $VALPARSIAL["KODE_RAK"];
											$GUDANG["KODE_SUB_RAK"] = $VALPARSIAL["KODE_SUB_RAK"];
											$this->db->insert('t_realisasi_parsial_gudang',$GUDANG);	
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
											$HEADER["NAMA_TRADER"] = $VALPARSIAL['NAMA_TRADER'];
											$HEADER["TGL_TRANSAKSI"] = date('Y-m-d H:m:s');
											if($this->db->insert('t_realisasi_parsial_hdr',$HEADER)){											
												$DETIL["HDR_REFF"] = $RELID;	
												$DETIL["REALISASIDTLID"] = $DTL_ID;
												$DETIL["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
												$DETIL["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];	
												$DETIL["SATUAN"] = $VALPARSIAL["KODE_SATUAN"];	
												$DETIL["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
												$DETIL["NILAI_BARANG"] = (float)$VALPARSIAL["CIF"]/(float)$VALPARSIAL["JUMLAH"];
												$GUDANG["REALISASIDTLID"] = $DTL_ID;
												$GUDANG["HDR_REFF"] = $RELID;
												$GUDANG["KODE_BARANG"] = $VALPARSIAL["KODE_BARANG"];
												$GUDANG["JNS_BARANG"] = $VALPARSIAL["JNS_BARANG"];
												$GUDANG["JUMLAH"] = $VALPARSIAL["JUMLAH"];	
												$GUDANG["SERI"] = $VALPARSIAL["SERI"];
												$GUDANG["KODE_GUDANG"] = $VALPARSIAL["KODE_GUDANG"];
												$GUDANG["KONDISI_BARANG"] = $VALPARSIAL["KONDISI_BARANG"];
												$GUDANG["KODE_RAK"] = $VALPARSIAL["KODE_RAK"];
												$GUDANG["KODE_SUB_RAK"] = $VALPARSIAL["KODE_SUB_RAK"];
												$this->db->insert('t_realisasi_parsial_gudang',$GUDANG);	
												$this->db->insert('t_realisasi_parsial_dtl',$DETIL);
											}
											$NEXTID++;	
										}
									}
								}
							}
							#==========================================================================================	
						}
						if($execfinal){
							$sukses = $this->fungsi->msg("done","Data Berhasil diproses");	
						}else{
							$error = $this->fungsi->msg("error","Data Gagal diproses realisasi. Dokumen masuk ke draft.");	 
						}
					}
				}								
				break;
			}			
		}
		if($error){
			echo $this->load->view('upload/pabean',array("proses"=>"error","msg"=>$error),true);
			unlink($file);
		}else{
			echo $this->load->view('upload/pabean',array("proses"=>"sukses","msg"=>$sukses),true);
			unlink($file);
		}			
	} 

	function proses_realisasi_biasa($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$INOUT,$LOG){	
		$func = get_instance();
		$func->load->model("main","main", true);	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');		
		$SQSTOK = "SELECT ID,JUMLAH,TANGGAL_STOCK FROM M_TRADER_STOCKOPNAME WHERE KODE_TRADER='".$KODE_TRADER."' 
				   AND KODE_BARANG='".$DETIL["KODE_BARANG"]."' AND JNS_BARANG='".$DETIL["JNS_BARANG"]."' 
				   ORDER BY TANGGAL_STOCK DESC LIMIT 1";
		//$RSSTOCK = $this->db->query($SQSTOK);
		$JUMSTOCK = 0;
		/*if($RSSTOCK->num_rows()>0){
			$VALSTOCK = $RSSTOCK->row();
			$IDSTOCK = $VALSTOCK->ID;	
			$JUMSTOCK = $VALSTOCK->JUMLAH;	
			$TGLSTOCK = $VALSTOCK->TANGGAL_STOCK;
		}*/
		$SQLOUT = "SELECT SUM(JUMLAH) JUMLAH, TANGGAL FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' 
				   AND KODE_BARANG='".$DETIL["KODE_BARANG"]."' AND JNS_BARANG='".$DETIL["JNS_BARANG"]."' 
				   AND TIPE IN ('GATE-OUT','PROCESS_IN') AND DATE_FORMAT(TANGGAL,'%Y-%m-%d') > '".$TGLSTOCK."' LIMIT 1";
		$RSOUT = $this->db->query($SQLOUT);
		$JUMOUT = 0;
		if($RSOUT->num_rows()>0){
			$VALOUT = $RSOUT->row();
			$JUMOUT = $VALOUT->JUMLAH;	
		}

		$SQLBRG = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, URAIAN_BARANG
			   	   FROM M_TRADER_BARANG WHERE KODE_BARANG='".$DETIL["KODE_BARANG"]."' 
			       AND JNS_BARANG='".$DETIL["JNS_BARANG"]."' AND KODE_TRADER='".$KODE_TRADER."'";																
		$VALBRG=$this->db->query($SQLBRG)->row(); 
		$JUMBRG = $VALBRG->STOCK_AKHIR;
		$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
		$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;	
		$uraianbarang = $VALBRG->URAIAN_BARANG;								
		
		if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
		$JUMLAH_BARANG = $DETIL["JUMLAH"] * $jmlsatuanKecil;
		
		if($kdsatuanKecil){
			if(strtoupper($DETIL["KODE_SATUAN"])==strtoupper($kdsatuanKecil)){
				$JUMLAH_BARANG = $DETIL["JUMLAH"];
			}else{					
				if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
				$JUMLAH_BARANG = $DETIL["JUMLAH"] * $jmlsatuanKecil;
			}
		}else{
			$JUMLAH_BARANG = $DETIL["JUMLAH"];	
		}

		/*if($JUMSTOCK > $JUMOUT){
			$SELISIHLEBIH = $JUMSTOCK - $JUMOUT;
			if($SELISIHLEBIH >= $DETIL["JUMLAH"]){
				$JUMLAHREALISASI = $SELISIHLEBIH;
				return $this->eksekusi_realisasi($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$INOUT,$LOG,$IDSTOCK);
			}else{
				$HSLLOOP = $this->proses_saldo($JUMSTOCK,$DETIL["JUMLAH"],$DETIL["KODE_BARANG"],$DETIL["JNS_BARANG"]);				
				if($HSLLOOP=="FALSE"){
					return false;	
				}else{
					return $this->eksekusi_realisasi($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$INOUT,$LOG,'',$HSLLOOP);
				}
			}
		}else{*/
			//$HSLLOOP = $this->proses_saldo(0,$DETIL["JUMLAH"],$DETIL["KODE_BARANG"],$DETIL["JNS_BARANG"]);
			$HSLLOOP = $this->proses_saldo(0,$JUMLAH_BARANG,$DETIL["KODE_BARANG"],$DETIL["JNS_BARANG"]);			
			if($HSLLOOP=="FALSE"){
				return false;	
			}else{
				return $this->eksekusi_realisasi($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$INOUT,$LOG,'',$HSLLOOP);
			}			 
		//}											
	}
	
	function proses_saldo($JUMSTOCK,$JUMLAH_SATUAN,$KODE_BARANG,$JNS_BARANG){
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$RET = "FALSE";
				
		#sementara			 
		/*if($KODE_TRADER=='EDIWORL00040'){			 
			$SQLSALDO = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI_BARANG, NAMA_BARANG,
						 SATUAN, JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$KODE_TRADER."' 
						 AND (KODE_BARANG='".$KODE_BARANG."' OR KODE_BARANG IN 
							(SELECT A.KODE_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
							 AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER='".$KODE_TRADER."' 
							 AND (B.KODE_BARANG='". $KODE_BARANG ."' OR A.KODE_BARANG='". $KODE_BARANG ."')))						  
						 AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') AND JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') 
						 ORDER BY TGL_DOK,NO_DOK,SERI_BARANG ASC";				 
		}else{*/
			$SQLSALDO = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI_BARANG, NAMA_BARANG,
  					 SATUAN, JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$KODE_TRADER."' 
					 AND KODE_BARANG='".$KODE_BARANG."' AND JNS_BARANG='".$JNS_BARANG."' 
					 AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') AND JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') 
					 ORDER BY TGL_DOK,NO_DOK,SERI_BARANG ASC";		
		// }		 
					 
		$RSSALDO = $this->db->query($SQLSALDO);	
		$numrows = $RSSALDO->num_rows();	
		if($numrows>0){
			$JUMSALDO = 0;
			$DATAMASUK = array();
            $SALDOSEBELUM = array();
			$NO = 1;
			foreach($RSSALDO->result_array() as $DATA){
				$JUMSALDO = $DATA["SALDO"];	
				$LOGID = $DATA["LOGID"];	
				
				$JUMSTOCKNSALDO = $JUMSTOCKNSALDO + ($JUMSTOCK + $JUMSALDO);
				if($JUMLAH_SATUAN >= $JUMSTOCKNSALDO){
					$JUMPAKAI = $JUMSALDO;
				}
				else{ 
					if($NO > 1) $JUMPAKAI = $JUMLAH_SATUAN - ((float)end($SALDOSEBELUM));	
					else $JUMPAKAI = $JUMLAH_SATUAN;	
				}	
				$SALDOSEBELUM[] = $JUMSTOCKNSALDO;	
					
				$DATAMASUK[] = array("JENIS_DOK"=>$DATA["JENIS_DOK"],"NO_DOK"=>$DATA["NO_DOK"],"TGL_DOK"=>$DATA["TGL_DOK"],
									 "SERI_BARANG"=>$DATA["SERI_BARANG"],"LOGID"=>$DATA["LOGID"],"JUMLAH_OUT"=>$JUMPAKAI);
									 					
				if($JUMSTOCKNSALDO >= $JUMLAH_SATUAN){
					$SALDOAKHIR = $JUMSTOCKNSALDO - $JUMLAH_SATUAN;
					$this->db->where("LOGID",$LOGID);
					if($SALDOAKHIR>0){
						$exec = $this->db->update('T_LOGBOOK_PEMASUKAN',array('SALDO'=>$SALDOAKHIR));	
					}else{
						$exec = $this->db->update('T_LOGBOOK_PEMASUKAN',array('FLAG_TUTUP'=>'1','SALDO'=>$SALDOAKHIR));		
					}
					if($exec){				
						$RET = $DATAMASUK; 
						break;
					}		
				}
				else{
					if($numrows>1){
						$this->db->where("LOGID",$LOGID);
						$this->db->update('T_LOGBOOK_PEMASUKAN',array('FLAG_TUTUP'=>'1','SALDO'=>0));
					}
				}		
				$NO++;	
			}	
		}
		return $RET;
	}
	
	function eksekusi_realisasi($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$INOUT,$LOG,$IDSTOCK="",$DATALOGMASUK=""){	
		$func = get_instance();
		$func->load->model("main","main", true);	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$SERIINOUT = (int)$func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM m_trader_barang_inout", "MAXSERI") + 1; 			
																							
		$SQLBRG = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, URAIAN_BARANG
			   	   FROM M_TRADER_BARANG WHERE KODE_BARANG='".$DETIL["KODE_BARANG"]."' 
			       AND JNS_BARANG='".$DETIL["JNS_BARANG"]."' AND KODE_TRADER='".$KODE_TRADER."'";																
		$VALBRG=$this->db->query($SQLBRG)->row(); 
		$JUMBRG = $VALBRG->STOCK_AKHIR;
		$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
		$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;	
		$uraianbarang = $VALBRG->URAIAN_BARANG;								
		
		if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
		$JUMLAH_BARANG = $DETIL["JUMLAH"] * $jmlsatuanKecil;
		
		if($kdsatuanKecil){
			if(strtoupper($DETIL["KODE_SATUAN"])==strtoupper($kdsatuanKecil)){
				$JUMLAH_BARANG = $DETIL["JUMLAH"];
			}else{					
				if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
				$JUMLAH_BARANG = $DETIL["JUMLAH"] * $jmlsatuanKecil;
			}
		}else{
			$JUMLAH_BARANG = $DETIL["JUMLAH"];	
		}
		$INOUT["KODE_BARANG"] = $DETIL["KODE_BARANG"];
		$INOUT["JNS_BARANG"] = $DETIL["JNS_BARANG"];
		$INOUT["SERI"] = $SERIINOUT;
		$INOUT["JUMLAH"] = $JUMLAH_BARANG;	
		$INOUT["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
		$INOUT["SERI_DOKUMEN"] = $DETIL["SERI"];

		
		$LOG["KODE_BARANG"] = $DETIL["KODE_BARANG"];
		$LOG["JNS_BARANG"] = $DETIL["JNS_BARANG"];
		$LOG["JUMLAH"] = $JUMLAH_BARANG;	
		$LOG["NILAI_PABEAN"] = $DETIL["CIF"];
		$LOG["SATUAN"] = $kdsatuanKecil;
		$LOG["NAMA_BARANG"] = $uraianbarang;	
		$LOG["SERI_BARANG"] = $DETIL["SERI"];
		$LOG["NOMOR_AJU"] = $NOMOR_AJU;		
		$LOG["METHOD"] = "FIFO";			
		unset($LOG["SALDO"]);
		/*$this->db->where(array("KODE_BARANG"=>$DETIL["KODE_BARANG"],
							   "JNS_BARANG"=>$DETIL["JNS_BARANG"],
							   "KODE_TRADER"=>$KODE_TRADER));
		$this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$JUMBRG-$JUMLAH_BARANG));*/
		$exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);	
		
		if($DATALOGMASUK){
			for($z=0;$z < count($DATALOGMASUK);$z++){
				$LOG["NO_DOK_MASUK"] = $DATALOGMASUK[$z]["NO_DOK"];
				$LOG["TGL_DOK_MASUK"] = $DATALOGMASUK[$z]["TGL_DOK"];
				$LOG["JENIS_DOK_MASUK"] = $DATALOGMASUK[$z]["JENIS_DOK"];
				$LOG["SERI_BARANG_MASUK"] = $DATALOGMASUK[$z]["SERI_BARANG"];
				$LOG["LOGID_MASUK"] = $DATALOGMASUK[$z]["LOGID"];
				$LOG["JUMLAH"] = $DATALOGMASUK[$z]["JUMLAH_OUT"];
				$exec = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
			}
		}
		if($exec) return true;
		else return false;		
	}		
	
	function proses_realisasi_parsial_out($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$HEADER,$INOUT,$LOG){
		$func = get_instance();
		$func->load->model("main","main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$SQLP = "SELECT A.REALISASIID, B.KODE_BARANG, B.JNS_BARANG, B.JUMLAH JUMLAH_SATUAN, B.SATUAN KODE_SATUAN, B.NILAI_BARANG
				 FROM t_temp_realisasi_parsial_hdr A, t_temp_realisasi_parsial_dtl B 
				 WHERE A.REALISASIID=B.HDR_REFF AND
				 A.NOMOR_AJU='".$NOMOR_AJU."' 
				 AND A.KODE_TRADER='".$KODE_TRADER."' AND A.NO_DOK_INTERNAL IS NULL
				 AND B.KODE_BARANG='".$DETIL["KODE_BARANG"]."' AND B.JNS_BARANG='".$DETIL["JNS_BARANG"]."'
				 AND B.SERI='".$DETIL["SERI"]."'"; 
		$rs = $this->db->query($SQLP);					
		if($rs->num_rows()>0){	
			$VALPARSIAL = $rs->row(); 	
			$REALISASIID = $VALPARSIAL->REALISASIID;																													
			$jumlah1 = $VALPARSIAL->JUMLAH_SATUAN;
			$kdsatuan1 = $VALPARSIAL->KODE_SATUAN;
			$DETIL_PARSIAL = $rs->result_array();
			$DETIL = array_merge($DETIL,$DETIL_PARSIAL[0]);
			#============================================================================================================
			#AMBIL JUMLAH STOCKOPNAME TERAKHIR	
			$SQSTOK = "SELECT ID,JUMLAH,TANGGAL_STOCK FROM M_TRADER_STOCKOPNAME WHERE KODE_TRADER='".$KODE_TRADER."' 
					   AND KODE_BARANG='".$VALPARSIAL->KODE_BARANG."' AND JNS_BARANG='".$VALPARSIAL->JNS_BARANG."' 
					   ORDER BY TANGGAL_STOCK DESC LIMIT 1";
			//$RSSTOCK = $this->db->query($SQSTOK);
			$JUMSTOCK = 0;
			
			#AMBIL JUMLAH BARANG OUT > TGL.STOCOPNAME
			$SQLOUT = "SELECT SUM(JUMLAH) JUMLAH, TANGGAL FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' 
					   AND KODE_BARANG='".$VALPARSIAL->KODE_BARANG."' AND JNS_BARANG='".$VALPARSIAL->JNS_BARANG."' 
					   AND TIPE IN ('GATE-OUT','PROCESS_IN') 
					   AND DATE_FORMAT(TANGGAL,'%Y-%m-%d') BETWEEN '".$TGLSTOCK."' AND NOW() LIMIT 1";														
			$RSOUT = $this->db->query($SQLOUT);
			$JUMOUT = 0;
			if($RSOUT->num_rows()>0){
				$JUMOUT = $RSOUT->row()->JUMLAH;
			}	
			#BANDINGKAN JUM STOCK VS OUT
			/*if($JUMSTOCK > $JUMOUT){
				$SELISIHLEBIH = $JUMSTOCK - $JUMOUT;
				if($SELISIHLEBIH >= $DETIL["JUMLAH_SATUAN"]){
					$JUMLAHREALISASI = $SELISIHLEBIH;
					$rets = $this->eksekusi_parsial($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$HEADER,$INOUT,$LOG,$IDSTOCK);
					if($rets){
						$rets = $REALISASIID;
					}
					return $rets;
				}else{
					$HSLLOOP = $this->proses_saldo($JUMSTOCK,$DETIL["JUMLAH_SATUAN"],$DETIL["KODE_BARANG"],$DETIL["JNS_BARANG"]);				
					if($HSLLOOP=="FALSE"){
						return false;	
					}else{
						$rets = $this->eksekusi_parsial($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$HEADER,$INOUT,$LOG,'',$HSLLOOP);
						if($rets){
							$rets = $REALISASIID;
						}
						return $rets;
					}
				}
			}else{*/
				$HSLLOOP = $this->proses_saldo(0,$DETIL["JUMLAH_SATUAN"],$DETIL["KODE_BARANG"],$DETIL["JNS_BARANG"]);				
				if($HSLLOOP=="FALSE"){
					return false;	
				}else{
					$rets = $this->eksekusi_parsial($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$HEADER,$INOUT,$LOG,'',$HSLLOOP);
					if($rets){					
						$rets = $REALISASIID;
					}
					return $rets;
				}			 
			//}
			#==========================================================================================================																			
		}
		else{
			return "CEKKEBIASA";
		}		
	}
	
	function eksekusi_parsial($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$HEADER,$INOUT,$LOG,$IDSTOCK="",$DATALOGMASUK=""){	
		$func = get_instance();
		$func->load->model("main","main", true);	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$SERIINOUT = (int)$func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM m_trader_barang_inout", "MAXSERI") + 1; 
																							
		$SQLBRG = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, URAIAN_BARANG
			   	   FROM M_TRADER_BARANG WHERE KODE_BARANG='".$DETIL["KODE_BARANG"]."' 
			       AND JNS_BARANG='".$DETIL["JNS_BARANG"]."' AND KODE_TRADER='".$KODE_TRADER."'";																
		$VALBRG=$this->db->query($SQLBRG)->row(); 
		$JUMBRG = $VALBRG->STOCK_AKHIR;
		$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
		$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;	
		$uraianbarang = $VALBRG->URAIAN_BARANG;	
			
		if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
		$JUMLAH_BARANG = $DETIL["JUMLAH_SATUAN"] * $jmlsatuanKecil;
		
		if($kdsatuanKecil){
			if(strtoupper($DETIL["KODE_SATUAN"])==strtoupper($kdsatuanKecil)){
				$JUMLAH_BARANG = $DETIL["JUMLAH_SATUAN"];
			}else{					
				if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
				$JUMLAH_BARANG = $DETIL["JUMLAH_SATUAN"] * $jmlsatuanKecil;
			}
		}else{
			$JUMLAH_BARANG = $DETIL["JUMLAH_SATUAN"];	
		}
		$INOUT["TIPE"] = "GATE-OUT";
		$INOUT["KODE_BARANG"] = $DETIL["KODE_BARANG"];
		$INOUT["JNS_BARANG"] = $DETIL["JNS_BARANG"];
		$INOUT["SERI"] = $SERIINOUT;
		$INOUT["JUMLAH"] = $JUMLAH_BARANG;	
		$INOUT["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
		$INOUT["SERI_DOKUMEN"] = $DETIL["SERI"];
		$INOUT["KONDISI_BARANG"] = $DETIL['KONDISI_BARANG'];
		$INOUT["KODE_GUDANG"] = $DETIL['KODE_GUDANG'];
		$INOUT["KODE_RAK"] = $DETIL['KODE_RAK'];
		$INOUT["KODE_SUB_RAK"] = $DETIL['KODE_SUB_RAK'];
		$INOUT["PARSIAL_FLAG"] = $DETIL['PARSIAL_FLAG'];
		
		$LOG["KODE_BARANG"] = $DETIL["KODE_BARANG"];
		$LOG["JNS_BARANG"] = $DETIL["JNS_BARANG"];
		$LOG["JUMLAH"] = $JUMLAH_BARANG;	
		$LOG["NILAI_PABEAN"] = (float)$DETIL["CIF"]/(float)$DETIL["JUMLAH_SATUAN"];	
		$LOG["SATUAN"] = $kdsatuanKecil;
		$LOG["NAMA_BARANG"] = $uraianbarang;
		$LOG["SERI_BARANG"] = $DETIL["SERI"];
		$LOG["NOMOR_AJU"] = $NOMOR_AJU;			
		
		/*$this->db->where(array("KODE_BARANG"=>$DETIL["KODE_BARANG"],
							   "JNS_BARANG"=>$DETIL["JNS_BARANG"],
							   "KODE_TRADER"=>$KODE_TRADER));
		$this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$JUMBRG-$JUMLAH_BARANG));*/
		$sqlUpdate = "UPDATE M_TRADER_BARANG_GUDANG 
					SET JUMLAH = JUMLAH - ".$JUMLAH_BARANG." 
					WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'
					AND KODE_BARANG = '".$DETIL['KODE_BARANG']."'
					AND JNS_BARANG = '".$DETIL['JNS_BARANG']."'
					AND KODE_GUDANG = '".$DETIL['KODE_GUDANG']."'
					AND KONDISI_BARANG = '".$DETIL['KONDISI_BARANG']."'";
		if($DETIL['KODE_RAK']!=""){
			$sqlUpdate .= " AND KODE_RAK='".$DETIL['KODE_RAK']."'";
		}
		if($DETIL['KODE_SUB_RAK']!=""){
			$sqlUpdate .= " AND KODE_SUB_RAK='".$DETIL['KODE_SUB_RAK']."'";
		}

		$exec1 = $this->db->query($sqlUpdate);	
		$exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);	
		
		/*if($IDSTOCK){
			$SQLDTLSTOCK = "SELECT IDDTL, IDHDR, JENIS_DOK_MASUK, NO_DOK_MASUK, TGL_DOK_MASUK, JUMLAH, JUMLAH_SISA 
							FROM M_TRADER_STOCKOPNAME_DTL WHERE IDHDR='".$IDSTOCK."' ORDER BY TGL_DOK_MASUK ASC";	
			$RSDTLSTOCK = $this->db->query($SQLDTLSTOCK);											
			if($RSDTLSTOCK->num_rows()>0){
				$JUMDTL=0;
				$BREAK=FALSE;
				foreach($RSDTLSTOCK->result_array() as $ROWSTOCKDTL){	
					if($ROWSTOCKDTL["JUMLAH_SISA"]>0){
						$JUMSTOCKDTL = $ROWSTOCKDTL["JUMLAH_SISA"];
					}else{
						$JUMSTOCKDTL = $ROWSTOCKDTL["JUMLAH"];
					}
					if($JUMLAH_BARANG<=$JUMSTOCKDTL){
						$LOG["JUMLAH"] = $JUMLAH_BARANG;
						$SISASTOCK = $ROWSTOCKDTL["JUMLAH"]-$JUMLAH_BARANG;
						$BREAK=TRUE;
					}
					else if($JUMLAH_BARANG>$ROWSTOCKDTL["JUMLAH"]){
						$LOG["JUMLAH"] = $ROWSTOCKDTL["JUMLAH"];
						$SISASTOCK = 0;
					}																												
					$LOG["NO_DOK_MASUK"] = $ROWSTOCKDTL["NO_DOK_MASUK"];
					$LOG["TGL_DOK_MASUK"] = $ROWSTOCKDTL["TGL_DOK_MASUK"];
					$LOG["JENIS_DOK_MASUK"] = $ROWSTOCKDTL["JENIS_DOK_MASUK"];
					$exec = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);	
					if($exec){
						$this->db->where(array("IDDTL"=>$ROWSTOCKDTL["IDDTL"]));	
						$this->db->update('M_TRADER_STOCKOPNAME_DTL',array("JUMLAH_SISA"=>$SISASTOCK));
					}	
					if($BREAK) break;
				}
			}
		}*/
		if($DATALOGMASUK){
			for($z=0;$z<count($DATALOGMASUK);$z++){
				$LOG["NO_DOK_MASUK"] = $DATALOGMASUK[$z]["NO_DOK"];
				$LOG["TGL_DOK_MASUK"] = $DATALOGMASUK[$z]["TGL_DOK"];
				$LOG["JENIS_DOK_MASUK"] = $DATALOGMASUK[$z]["JENIS_DOK"];
				$LOG["SERI_BARANG_MASUK"] = $DATALOGMASUK[$z]["SERI_BARANG"];
				$LOG["LOGID_MASUK"] = $DATALOGMASUK[$z]["LOGID"];
				$LOG["JUMLAH"] = $DATALOGMASUK[$z]["JUMLAH_OUT"];
				$exec = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
			}
		}
		if($exec) return true;
		else return false;		
	}		
	
	function proses_realisasi_parsial_in($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$HEADER,$INOUT,$LOG){
		$func = get_instance();
		$func->load->model("main","main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$SQLP = "SELECT A.REALISASIID, B.KODE_BARANG, B.JNS_BARANG, B.JUMLAH, B.SATUAN, B.NILAI_BARANG, C.SERI, C.KODE_GUDANG, C.KONDISI_BARANG, C.KODE_RAK, C.KODE_SUB_RAK
				 FROM t_temp_realisasi_parsial_hdr A, t_temp_realisasi_parsial_dtl B,  t_temp_realisasi_parsial_gudang C 
				 WHERE A.REALISASIID=B.HDR_REFF AND B.REALISASIDTLID=C.REALISASIDTLID AND
				 A.NOMOR_AJU='".$NOMOR_AJU."' 
				 AND A.KODE_TRADER='".$KODE_TRADER."' AND A.NO_DOK_INTERNAL IS NULL
				 AND B.KODE_BARANG='".$DETIL["KODE_BARANG"]."' AND B.JNS_BARANG='".$DETIL["JNS_BARANG"]."'
				 AND B.SERI='".$DETIL["SERI"]."'";  
		$rs = $this->db->query($SQLP);					
		if($rs->num_rows()>0){	
			$VALPARSIAL = $rs->row(); 	
			$REALISASIID = $VALPARSIAL->REALISASIID;																													
			$jumlah1 = $VALPARSIAL->JUMLAH;
			$kdsatuan1 = $VALPARSIAL->SATUAN;
			
			/*$SQL1 = "SELECT IFNULL(MAX(REALISASIDTLID)+1,0) AS REALISASIDTLID FROM T_REALISASI_PARSIAL_DTL";
			$QUERY = $this->db->query($SQL1);
			$DTLID = $QUERY->REALISASIDTLID;	
			$QUERY = "SELECT REALISASIID FROM t_realisasi_parsial_hdr
					  WHERE REALISASIID = '".$VALPARSIAL->REALISASIID."'";
			if(!$func->main->get_result($QUERY)){
				$datahdr["REALISASIID"] = $VALPARSIAL->REALISASIID;
				$datahdr["KODE_TRADER"] = $KODE_TRADER;
				$datahdr["NOMOR_AJU"] = $NOMOR_AJU;
				$datahdr["JENIS_DOK"] = $KODE_DOKUMEN;
				$datahdr["NO_DOK_INTERNAL"] = $HEADER["NOMOR_DOK_INTERNAL"];
				$datahdr["TGL_DOK_INTERNAL"] = $HEADER["TANGGAL_DOK_INTERNAL"];
				$datahdr["TGL_REALISASI"] = $HEADER["TANGGAL_REALISASI"];
				$datahdr["TGL_TRANSAKSI"] = date("Y-m-d H:i:s");
				$this->db->insert('t_realisasi_parsial_hdr',$datahdr);
			}	
			$datadtl["HDR_REFF"] = $VALPARSIAL->REALISASIID;
			$datadtl["KODE_BARANG"] = $VALPARSIAL->KODE_BARANG;
			$datadtl["JNS_BARANG"] = $VALPARSIAL->JNS_BARANG;
			$datadtl["JUMLAH"] = $jumlah1;
			$datadtl["SATUAN"] = $kdsatuan1;
			$datadtl["NILAI_BARANG"] = $VALPARSIAL->NILAI_BARANG;
			$datagdg["REALISASIDTLID"] = $DTLID;
			$datagdg["HDR_REFF"] = $VALPARSIAL->REALISASIID;
			$datagdg["KODE_BARANG"] = $VALPARSIAL->KODE_BARANG;
			$datagdg["JNS_BARANG"] = $VALPARSIAL->JNS_BARANG;
			$datagdg["JUMLAH"] = $jumlah1;	
			$datagdg["SERI"] = $VALPARSIAL->SERI;
			$datagdg["KODE_GUDANG"] = $VALPARSIAL->KODE_GUDANG;
			$datagdg["KONDISI_BARANG"] = $VALPARSIAL->KONDISI_BARANG;
			$datagdg["KODE_RAK"] = $VALPARSIAL->KODE_RAK;
			$datagdg["KODE_SUB_RAK"] = $VALPARSIAL->KODE_SUB_RAK;
			$this->db->insert('t_realisasi_parsial_gudang',$datagdg);
			$this->db->insert('t_realisasi_parsial_dtl',$datadtl);*/
																		
			$SERIINOUT = (int)$func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_barang_inout","MAX")+1; 
									
			$SQL2="SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, URAIAN_BARANG
				   FROM M_TRADER_BARANG WHERE KODE_BARANG='".$VALPARSIAL->KODE_BARANG."' 
				   AND JNS_BARANG='".$VALPARSIAL->JNS_BARANG."' AND KODE_TRADER='".$KODE_TRADER."'";	  
										
			$VALBRG=$this->db->query($SQL2)->row(); 
			$jumlah2 = $VALBRG->STOCK_AKHIR;
			$kdsatuan2 = $VALBRG->KODE_SATUAN;
			$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
			$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
			$uraianbarang = $VALBRG->URAIAN_BARANG;
						
				if(empty($jmlsatuanKecil)){ 
					$jmlsatuanKecil=1;
				}
				$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
				
				if($kdsatuanKecil){
					if(strtoupper($kdsatuan1)==strtoupper($kdsatuanKecil)){
						$JUMLAH_BARANG = $jumlah1;
					}else{					
						if(empty($jmlsatuanKecil)){$jmlsatuanKecil=1;}
						$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
					}
				}else{
					$JUMLAH_BARANG = $jumlah1;	
				}
			
			$INOUT["KODE_BARANG"] = $VALPARSIAL->KODE_BARANG;
			$INOUT["JNS_BARANG"] = $VALPARSIAL->JNS_BARANG;
			$INOUT["SERI"] = $SERIINOUT;
			$INOUT["JUMLAH"] = $JUMLAH_BARANG;		
			$INOUT["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
			$INOUT["SERI_DOKUMEN"] = $DETIL["SERI"];
			$INOUT["KONDISI_BARANG"] = $DETIL['KONDISI_BARANG'];
			$INOUT["KODE_GUDANG"] = $DETIL['KODE_GUDANG'];
			$INOUT["KODE_RAK"] = $DETIL['KODE_RAK'];
			$INOUT["KODE_SUB_RAK"] = $DETIL['KODE_SUB_RAK'];
			$INOUT["PARSIAL_FLAG"] = $DETIL['PARSIAL_FLAG'];

							
			$LOG["KODE_BARANG"] = $VALPARSIAL->KODE_BARANG;
			$LOG["JNS_BARANG"] = $VALPARSIAL->JNS_BARANG;
			$LOG["SERI_BARANG"] = $DETIL["SERI"];
			$LOG["JUMLAH"] = $JUMLAH_BARANG;		
			$LOG["SALDO"] = $JUMLAH_BARANG;	
			$LOG["SATUAN"] = $kdsatuanKecil;
			$LOG["NAMA_BARANG"] = $uraianbarang;
			$LOG["NOMOR_AJU"] = $NOMOR_AJU;			
											
            $LOG["NILAI_PABEAN"] = $VALPARSIAL->NILAI_BARANG?$VALPARSIAL->NILAI_BARANG:$DETIL["CIF"];
			
			/*$this->db->where(array("KODE_BARANG"=>$VALPARSIAL->KODE_BARANG,
								   "JNS_BARANG"=>$VALPARSIAL->JNS_BARANG,
								   "KODE_TRADER"=>$KODE_TRADER));
			$this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$JUMLAH_BARANG+$jumlah2));*/
			$this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);	
			$exec = $this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);							
			if($exec) {$RET = TRUE;}
			else {$RET = FALSE;}
		}
		else{
			$RET = "CEKKEBIASA";
		}	
		return $RET;		
	}
	
	function realisasi_have_dokmasuk($KODE_DOKUMEN,$NOMOR_AJU,$DETIL,$INOUT,$LOG){	
		$func = get_instance();
		$func->load->model("main","main", true);	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$SERIINOUT = (int)$func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM m_trader_barang_inout", "MAXSERI") + 1; 																										
		$SQLBRG = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, URAIAN_BARANG
			   	   FROM M_TRADER_BARANG WHERE KODE_BARANG='".$DETIL["KODE_BARANG"]."' 
			       AND JNS_BARANG='".$DETIL["JNS_BARANG"]."' AND KODE_TRADER='".$KODE_TRADER."'";																
		$VALBRG=$this->db->query($SQLBRG)->row(); 
		$JUMBRG = $VALBRG->STOCK_AKHIR;
		$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
		$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;	
		$uraianbarang = $VALBRG->URAIAN_BARANG;								
		
		if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
		$JUMLAH_BARANG = $DETIL["JUMLAH"] * $jmlsatuanKecil;
		
		if($kdsatuanKecil){
			if(strtoupper($DETIL["KODE_SATUAN"])==strtoupper($kdsatuanKecil)){
				$JUMLAH_BARANG = $DETIL["JUMLAH"];
			}else{					
				if(empty($jmlsatuanKecil)) $jmlsatuanKecil=1;
				$JUMLAH_BARANG = $DETIL["JUMLAH"] * $jmlsatuanKecil;
			}
		}else{
			$JUMLAH_BARANG = $DETIL["JUMLAH"];	
		}
		$INOUT["KODE_BARANG"] = $DETIL["KODE_BARANG"];
		$INOUT["JNS_BARANG"] = $DETIL["JNS_BARANG"];
		$INOUT["SERI"] = $SERIINOUT;
		$INOUT["JUMLAH"] = $JUMLAH_BARANG;	
		$INOUT["CREATED_TIME"]= date('Y-m-d H:i:s',time()-60*60*1);
		$INOUT["SERI_DOKUMEN"] = $DETIL["SERI"];
		$INOUT["KONDISI_BARANG"] = $DETIL['KONDISI_BARANG'];
		$INOUT["KODE_GUDANG"] = $DETIL['KODE_GUDANG'];
		$INOUT["KODE_RAK"] = $DETIL['KODE_RAK'];
		$INOUT["KODE_SUB_RAK"] = $DETIL['KODE_SUB_RAK'];
		$INOUT["PARSIAL_FLAG"] = $DETIL['PARSIAL_FLAG'];
		
		$LOG["KODE_BARANG"] = $DETIL["KODE_BARANG"];
		$LOG["JNS_BARANG"] = $DETIL["JNS_BARANG"];
		$LOG["NILAI_PABEAN"] = (float)$DETIL["CIF"];
		$LOG["SATUAN"] = $kdsatuanKecil;
		$LOG["NAMA_BARANG"] = $uraianbarang;
		$LOG["NOMOR_AJU"] = $NOMOR_AJU;							
		
		/*$this->db->where(array("KODE_BARANG"=>$DETIL["KODE_BARANG"],
							   "JNS_BARANG"=>$DETIL["JNS_BARANG"],
							   "KODE_TRADER"=>$KODE_TRADER));
		$this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$JUMBRG-$JUMLAH_BARANG));*/
		$sqlUpdate = "UPDATE M_TRADER_BARANG_GUDANG 
					SET JUMLAH = JUMLAH - ".$JUMLAH_BARANG." 
					WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."'
					AND KODE_BARANG = '".$DETIL['KODE_BARANG']."'
					AND JNS_BARANG = '".$DETIL['JNS_BARANG']."'
					AND KODE_GUDANG = '".$DETIL['KODE_GUDANG']."'
					AND KONDISI_BARANG = '".$DETIL['KONDISI_BARANG']."'";
		if($DETIL['KODE_RAK']!=""){
			$sqlUpdate .= " AND KODE_RAK='".$DETIL['KODE_RAK']."'";
		}
		if($DETIL['KODE_SUB_RAK']!=""){
			$sqlUpdate .= " AND KODE_SUB_RAK='".$DETIL['KODE_SUB_RAK']."'";
		}

		$exec1 = $this->db->query($sqlUpdate);	
		$exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);	
		
		#======
		 $SQLSALDO = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, 
		 			 JNS_BARANG, SERI_BARANG, NAMA_BARANG,
  					 SATUAN, JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO
		 			 FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$KODE_TRADER."' 
					 AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') AND JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') 
					 AND (KODE_BARANG='".$DETIL["KODE_BARANG"]."' OR KODE_BARANG IN 
					      (SELECT A.KODE_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER='".$KODE_TRADER."' 
						   AND (B.KODE_BARANG='".$DETIL["KODE_BARANG"]."' OR A.KODE_BARANG='".$DETIL["KODE_BARANG"]."'))
						 ) 					 
					 AND (JNS_BARANG='".$DETIL["JNS_BARANG"]."' OR JNS_BARANG IN 
					 	  (SELECT A.JNS_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER='".$KODE_TRADER."' 
						   AND (B.JNS_BARANG='".$DETIL["JNS_BARANG"]."' OR A.JNS_BARANG='".$DETIL["JNS_BARANG"]."'))
						 )  AND JENIS_DOK='".$DETIL["KODE_DOK_MASUK"]."' AND NO_DOK='".$DETIL["NOMOR_DOK_MASUK"]."' 
					 AND TGL_DOK='".$DETIL["TANGGAL_DOK_MASUK"]."' ORDER BY TGL_MASUK, SERI_BARANG ASC LIMIT 1";
						 
		/*$SQLSALDO = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI_BARANG, NAMA_BARANG,
  					 SATUAN, JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$KODE_TRADER."' 
					 AND KODE_BARANG='".$DETIL["KODE_BARANG"]."' AND JNS_BARANG='".$DETIL["JNS_BARANG"]."' 
					 AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') AND JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') 
					 AND JENIS_DOK='".$DETIL["KODE_DOK_MASUK"]."' AND NO_DOK='".$DETIL["NOMOR_DOK_MASUK"]."' 
					 AND TGL_DOK='".$DETIL["TANGGAL_DOK_MASUK"]."'
					 ORDER BY TGL_MASUK, SERI_BARANG ASC LIMIT 1";*/
		$RSSALDO = $this->db->query($SQLSALDO);	
		$numrows = $RSSALDO->num_rows();	
		if($numrows > 0){
			$JUMSALDO = 0;
			$DATAMASUK = array();
			foreach($RSSALDO->result_array() as $DATA){
				$JUMSALDO = $DATA["SALDO"];	
				$LOGID = $DATA["LOGID"];	
				$SERI_BARANG_MASUK = $DATA["SERI_BARANG"];		
				$JUMSTOCKNSALDO = $JUMSTOCKNSALDO + $JUMSALDO;	
				if($JUMSTOCKNSALDO >= $JUMLAH_BARANG){
					$SALDOAKHIR = $JUMSTOCKNSALDO - $JUMLAH_BARANG;
					$this->db->where("LOGID",$LOGID);
					if($SALDOAKHIR > 0){
						$exec = $this->db->update('T_LOGBOOK_PEMASUKAN',array('SALDO'=>$SALDOAKHIR));	
						$JUMLAH_BARANG_PAKAI = $JUMLAH_BARANG;
						$ERR = "1. SALDO BARANG = ".$JUMSALDO.", LOGID = ".$LOGID.", SERI BARANG MASUK = ".$SERI_BARANG_MASUK.", JUMSTOCKNSALDO = ".$JUMSTOCKNSALDO.", SALDO AKHIR = ".$SALDOAKHIR.", JUMLAH BARANG PAKAI = ".$JUMLAH_BARANG_PAKAI;
					}else{
						$JUMPAKAI = $JUMSTOCKNSALDO - $JUMSALDO;
						if($SALDOAKHIR == 0) {
							$JUMPAKAI = $JUMLAH_BARANG;
						}
						$JUMLAH_BARANG_PAKAI = $JUMPAKAI;
						$exec = $this->db->update('T_LOGBOOK_PEMASUKAN',array('FLAG_TUTUP'=>'1','SALDO'=>$SALDOAKHIR));
						
						$ERR = "2. SALDO BARANG = ".$JUMSALDO.", LOGID = ".$LOGID.", SERI BARANG MASUK = ".$SERI_BARANG_MASUK.", JUMSTOCKNSALDO = ".$JUMSTOCKNSALDO.", SALDO AKHIR = ".$SALDOAKHIR.", JUMLAH BARANG PAKAI = ".$JUMLAH_BARANG_PAKAI;
					}
				}else{
					if($numrows>1){
						$this->db->where("LOGID",$LOGID);
						$this->db->update('T_LOGBOOK_PEMASUKAN',array('FLAG_TUTUP'=>'1','SALDO'=>0));
						$JUMLAH_BARANG_PAKAI = $JUMSTOCKNSALDO;	
						if($JUMSALDO <= $JUMSTOCKNSALDO){
							$JUMLAH_BARANG_PAKAI = $JUMSALDO;
						}
						
						$ERR = "3. SALDO BARANG = ".$JUMSALDO.", LOGID = ".$LOGID.", SERI BARANG MASUK = ".$SERI_BARANG_MASUK.", JUMSTOCKNSALDO = ".$JUMSTOCKNSALDO.", SALDO AKHIR = ".$SALDOAKHIR.", JUMLAH BARANG PAKAI = ".$JUMLAH_BARANG_PAKAI;
					}
				}			
			}	
		}
		#======
		
		$LOG["NO_DOK_MASUK"] 		= $DETIL["NOMOR_DOK_MASUK"];
		$LOG["TGL_DOK_MASUK"] 		= $DETIL["TANGGAL_DOK_MASUK"];
		$LOG["JENIS_DOK_MASUK"] 	= $DETIL["KODE_DOK_MASUK"];
		$LOG["JUMLAH"] 				= $JUMLAH_BARANG_PAKAI;
		$LOG["SERI_BARANG_MASUK"] 	= $SERI_BARANG_MASUK;
		$LOG["LOGID_MASUK"] 		= $LOGID;	
		//$LOG["ERR"] 				= $ERR;	
		$LOG["METHOD"] 				= "DOK-IN";
		$exec = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);	
					
		if($exec) return true;
		else return false;		
	}
	///////////////////////////	END PABEAN ///////////////////////////////////////////////////////////////////////////////////////////////

	#STRART STOCKOPNAME
	function stockopname(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/stockopname',array("proses"=>""),false);
	}
	
	function proses_stockopname(){		
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0); 
		$this->load->model("main");
		$this->load->model('upload_act');	
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');
		if($idHeader=="")redirect('uploadnew/stockopname','refresh');
		#constanta validasi 4 stockopname
		$highestColumn = 13;	
		$optional = $this->input->post('optional');
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');
		$ARRAYTIPEDOK = array('BC23','BC27');
		$datajenisbarang = array('1','2','3','4','5');
		$datasatuan = $this->upload_act->getDataKodeUpload('satuan');
		$datagudang = $this->upload_act->getDataKodeUpload('gudang');
		$mandatory = array("0","1","3","4","5","6","7","8","9","10");
		$HDRID = $this->main->get_uraian("SELECT MAX(ID) AS JUMLAH FROM M_TRADER_STOCKOPNAME","JUMLAH");
		$mandatory_conditional = array("0","1","3","4");
		$fieldHeader = array("KODE_BARANG","JNS_BARANG","URAIAN_BARANG","KODE_SATUAN","JUMLAH_STOCK");
		$fieldDetail = array("JENIS_DOK_MASUK","NO_DOK_MASUK","TGL_DOK_MASUK","JUMLAH","KETERANGAN");
		#================================	
		$KOLOM = array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E","6"=>"F","7"=>"G","8"=>"H","9"=>"I","10"=>"J","11"=>"K","12"=>"L","13"=>"M");	
		$namaFile= $idHeader;
		$file = "assets/file/upload/";
		chmod($file,0777);
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);	
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."stockopname.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);	
		$this->upload->display_errors('' ,'' );
		if(!$this->upload->do_upload("fileUpload")){
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			$data = $this->upload->data();			
			$file = $file.$data['file_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 	$proses = FALSE;
			$kosong = FALSE;
			$header = FALSE;
			$barang = FALSE;
			$kode_barang = FALSE;
			$jenisbarang = FALSE;
			$satuan = FALSE;
			$dok_masuk = FALSE;
			$gudang1 = FALSE;
			$rak = FALSE;
			$subrak = FALSE;
			foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow         = $worksheet->getHighestRow(); 
				$highestColumn      = $worksheet->getHighestColumn(); 
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$arraytemp = array();
				$arraytemp_jumlah = array();
				for($row=3; $row <= $highestRow; $row++){
					for($col=0; $col <= ($highestColumnIndex-1); $col++){
						#cek mandatory
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						if(in_array($col,$mandatory)){
							if(trim($cell->getCalculatedValue())==""){
								$kosong = TRUE;	
								$msgkosong = $msgkosong."KOLOM:[".$KOLOM[$col+1].",".$row."], ";
							}
						}
					}
					#cek kode barang dengan tanggal stockopname sudah ada di database
					$cell_barang = $this->replace_kdbarang($worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue());
					if($cell_barang){
						for($col=0; $col <= ($highestColumnIndex-1); $col++){
							#cek mandatory conditional;
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							if(in_array($col,$mandatory_conditional)){
								if(strval($cell->getCalculatedValue())==""){
									$header= TRUE;	
									$msgheader = $msgheader."KOLOM:[".($KOLOM[$col+1]).",".$row."], ";
								}
							}
						}	
					}
					
					$cell_jenis = $this->replace_character($worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
					$cell_date = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(4,2)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
					if(strpos($cell_date,"/")===false){
						$cell_date = $cell_date;	
					}else{
						$cell_date = $this->fungsi->dateformat($cell_date);		
					}
					
					/*if($this->cekbarangstock($cell_date,$cell_barang,$cell_jenis)){
						$barang = TRUE;
						$msgbarang = $msgbarang."Tanggal: ".$cell_date." dan Barang: ".$cell_barang." Stock Opname tersebut sudah ada di database <br /> ";
					}*/
					
					#CEK CODE BARANG
					if($cell_barang){
						if($this->cekbarang($cell_barang,$cell_jenis)){
							$kode_barang = TRUE;
							$msgkodebarang = $msgkodebarang."Kode Barang: ".$cell_barang." dengan Jenis Barang: ".$cell_jenis."<br />";
						}
					}
					
					#CEK JENIS BARANG
					if($cell_jenis){
						if(!in_array(trim($cell_jenis),$datajenisbarang)){
							$jenisbarang = TRUE;
							$msgjenisbarang = $msgjenisbarang.$cell_jenis." (KOLOM:[B".",".$row."]), ";
						}
					}
					
					#CEK SATUAN
					$cell_satuan = $worksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
					if($cell_satuan){
						if(!in_array(trim($cell_satuan),$datasatuan)){
							$satuan = TRUE;
							$msgsatuan = $msgsatuan.$cell_satuan." (KOLOM:[D".",".$row."]), ";
						}
					}
					
					#CEK KODE DOK MASUK
					$cell_dok_masuk = str_replace(".","",$worksheet->getCellByColumnAndRow(5, $row)->getCalculatedValue());
					if($cell_dok_masuk){
						if(!in_array(trim($cell_dok_masuk),$ARRAYTIPEDOK)){
							$dok_masuk = TRUE;
							$msgdokmasuk = $msgdokmasuk.$cell_dok_masuk." (KOLOM:[D".",".$row."]), ";
						}
					}

					#KODE GUDANG
					$cellgudang = $worksheet->getCellByColumnAndRow(9, $row)->getCalculatedValue();
					if($cellgudang){
						if(!in_array(trim($cellgudang),$datagudang)){
							$gudang1 = TRUE;
							$msggudang = $msggudang.$cellgudang." (KOLOM:[J".",".$row."]), ";
						}
					}

					#KODE RAK
					$cell_rak = $worksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue();
					if($cell_rak&&$gudang1==FALSE){
						$cek_rak = $this->db->query('SELECT COUNT(KODE_RAK) AS COUNT FROM m_trader_barang_gudang WHERE KODE_BARANG = "'.$cell_barang.'" AND KODE_GUDANG = "'.$cellgudang.'" AND KODE_RAK = "'.$cell_rak.'" ')->result_array();

						if($cek_rak[0]['COUNT']==0){
							$rak = TRUE;
							$msgrak = $msgrak.$cell_rak." (KOLOM:[K".",".$row."]), ";
						}
					}

					#KODE SUBRAK
					$cell_subrak = $worksheet->getCellByColumnAndRow(11, $row)->getCalculatedValue();
					if($cell_subrak){
						$cek_subrak = $this->db->query('SELECT COUNT(KODE_SUB_RAK) AS COUNT FROM m_trader_barang_gudang WHERE KODE_BARANG = "'.$cell_barang.'" AND KODE_GUDANG = "'.$cellgudang.'" AND KODE_RAK = "'.$cell_rak.'" AND KODE_SUB_RAK = "'.$cell_subrak.'" ')->result_array();
						if($cek_subrak[0]['COUNT']==0){
							$subrak = TRUE;
							$msgsubrak = $msgsubrak.$cell_subrak." (KOLOM:[L".",".$row."]), ";
						}
					}
				}
				
				if($kosong){
					$msg = "Terdapat data Pemasukan yang kosong pada kolom yang harus diisi: ".$msgkosong;	
					$error .= $this->fungsi->msg("error",$msg);		
				}
				
				if($header){
					$msg = "Terdapat data Barang yang kosong pada kolom yang harus diisi: ".$msgheader;	
					$error .= $this->fungsi->msg("error",$msg);
				}
				
				if($rak){
					$msg = "Terdapat kode rak yang tidak sesuai: <br />".$msgrak;
					$error .= $this->fungsi->msg("error",$msg);	
				}

				if($subrak){
					$msg = "Terdapat kode sub rak/sub lokasi yang tidak sesuai: <br />".$msgsubrak;
					$error .= $this->fungsi->msg("error",$msg);	
				}

				if($barang){
					$msg = $msgbarang;
					$error .= $this->fungsi->msg("warning",$msg);	
				}
				
				if($kode_barang){
					$msg ="Kode Barang tidak dikenali yaitu: <br />".$msgkodebarang;
					$error .= $this->fungsi->msg("error",$msg);	
				}

				if($gudang1){
					$msg ="Kode Gudang tidak dikenali yaitu: <br />".$msgkodebarang;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				
				if($jenisbarang){
					$msg ="Jenis Barang tidak dikenali yaitu: ".$msgjenisbarang;	
					$error .= $this->fungsi->msg("warning",$msg);	
				}
				
				if($satuan){
					$msg ="Satuan tidak dikenali yaitu: ".$msgsatuan;	
					$error .= $this->fungsi->msg("error",$msg);	
				}
				
				if($dok_masuk){
					$msg ="Kode Dok Masuk tidak dikenali yaitu: ".$msgdokmasuk;
					$error .= $this->fungsi->msg("error",$msg);	
				}
				
				if(!$error){
					$proses = TRUE;
					$index = 0;
					$no = 1;
					for($row=3; $row <= $highestRow; $row++){
						$indexHeader = 0;
						$indexDetail = 0;
						if($worksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue()){
							$KDBARANG = strtoupper(str_replace(" ","",$worksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue()));
							$HDRID++;
							if($row!=3){
								$no=1;
							}						
						}else{
							$X = $row-($row-($row-$no));
							$KDBARANG = strtoupper(str_replace(" ","",$worksheet->getCellByColumnAndRow(0, $X)->getCalculatedValue()));
							$HDRID+$X;
							$no++;
						}
						
						
						for($col=0; $col <=4; $col++){	
							if(trim($worksheet->getCellByColumnAndRow(0,$row)->getValue())){
								$TGL_STOCK = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(4,2)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
								if(strpos($TGL_STOCK,"/")===false){
									$TGL_STOCK = $TGL_STOCK;	
								}else{
									$TGL_STOCK = $this->fungsi->dateformat($TGL_STOCK);		
								}
								$KETERANGAN = $worksheet->getCellByColumnAndRow(13,$row)->getValue();
								$KONDISI = $worksheet->getCellByColumnAndRow(12,$row)->getValue();
								if($KONDISI==""){
									$KONDISI = "BAIK";
								}
								$DATAHEADER[$index]['ID'] = $HDRID;
								$DATAHEADER[$index]['TANGGAL_STOCK'] = $TGL_STOCK;
								$DATAHEADER[$index]['KETERANGAN'] = $KETERANGAN;
								$DATAHEADER[$index]['KODE_GUDANG'] = $worksheet->getCellByColumnAndRow(9,$row)->getValue();
								$DATAHEADER[$index]['KODE_RAK'] = $worksheet->getCellByColumnAndRow(10,$row)->getValue();
								$DATAHEADER[$index]['KODE_SUB_RAK'] = $worksheet->getCellByColumnAndRow(11,$row)->getValue();
								$DATAHEADER[$index]['KONDISI_BARANG'] = $KONDISI;
								$DATAHEADER[$index][$fieldHeader[$col]] = $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();		

							}
							$indexHeader++;
						}
						
						for($col=5; $col <= 8; $col++){
							if($KDBARANG!="!XXI!"){
								$TGL_DOK = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(7,$row)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
								if(strpos($TGL_DOK,"/")===false){
									$TGL_DOK = $TGL_DOK;	
								}else{
									$TGL_DOK = $this->fungsi->dateformat($TGL_DOK);		
								}
								$DATADETAIL[$index]['TGL_DOK_MASUK'] = $TGL_DOK;
								$DATADETAIL[$index]['IDHDR'] = $HDRID;
								$DATADETAIL[$index][$fieldDetail[$indexDetail]] = $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
								
								$indexDetail++;
							}
						}
						$index++;
					}
					if($proses){
						$indexno=0;
						$STOCKB = 0;
						$STOCKC = 0;
						foreach($DATAHEADER as $VAL){
							unset($PROCESSDATA);
							
							$KODE_BARANG = $this->replace_kdbarang($VAL['KODE_BARANG']);
							$JNS_BARANG = $this->replace_character($VAL['JNS_BARANG']);
								
							$STOCKB = $this->upload_act->getDataKodeUpload('stockAll',$VAL['TANGGAL_STOCK'],$KODE_BARANG,$JNS_BARANG,'');
							if(empty($STOCKB)){
								$PROCESSDATA['KODE_TRADER'] = $this->newsession->userdata('KODE_TRADER');
								$PROCESSDATA['KODE_BARANG'] = $KODE_BARANG;
								$PROCESSDATA['JNS_BARANG'] = $JNS_BARANG;
								$PROCESSDATA['ID'] = $VAL["ID"];
								$PROCESSDATA['TANGGAL_STOCK'] = $VAL['TANGGAL_STOCK'];
								$PROCESSDATA['JUMLAH'] = str_replace(',','.',$VAL['JUMLAH_STOCK']);
								$PROCESSDATA['KETERANGAN'] = $VAL['KETERANGAN'];
								$PROCESSDATA['KODE_GUDANG'] = $VAL['KODE_GUDANG'];
								$PROCESSDATA['KODE_RAK'] = $VAL['KODE_RAK'];
								$PROCESSDATA['KODE_SUB_RAK'] = $VAL['KODE_SUB_RAK'];
								$PROCESSDATA['KONDISI_BARANG'] = $VAL['KONDISI_BARANG'];

								$execHeader = $this->db->insert("m_trader_stockopname",$PROCESSDATA);	
								$this->main->activity_log('ADD STOCKOPNAME','KODE_BARANG='.$KODE_BARANG.', JNS_BARANG='.$JNS_BARANG,'UPLOAD');
							}else{
								if($optional=="KALKULASI"){
									$VAF["JUMLAH"] = str_replace(',','.',$VAL['JUMLAH_STOCK'])+$STOCKB[0];
								}elseif($optional=="REPLACE"){
									$VAF["JUMLAH"] = str_replace(',','.',$VAL['JUMLAH_STOCK']);
								}else{
									$VAF["JUMLAH"] = str_replace(',','.',$VAL['JUMLAH_STOCK']);
								}
								$this->db->where(array('KODE_BARANG'=>$KODE_BARANG,'KODE_TRADER'=>$kodetrader,'JNS_BARANG'=>$JNS_BARANG,'TANGGAL_STOCK'=>$VAL['TANGGAL_STOCK']));
								$execHeader = $this->db->update('m_trader_stockopname', $VAF);
								$this->main->activity_log('EDIT STOCKOPNAME','KODE_BARANG='.$KODE_BARANG.', JNS_BARANG='.$JNS_BARANG,'UPLOAD');
							}
						}
						if($execHeader){
							foreach($DATADETAIL as $VALDETIL){
								unset($PROCESSDATADETAIL);									
								$STOCKC = $this->upload_act->getDataKodeUpload('stockAllDetil',$VALDETIL['TGL_DOK_MASUK'],$VALDETIL["IDHDR"],$VALDETIL["JENIS_DOK_MASUK"],'');
								
								if(empty($STOCKC)){
									$PROCESSDATADETAIL['KODE_TRADER'] = $this->newsession->userdata('KODE_TRADER');
									$PROCESSDATADETAIL['IDHDR'] = $VALDETIL['IDHDR'];
									$PROCESSDATADETAIL['JENIS_DOK_MASUK'] = $VALDETIL["JENIS_DOK_MASUK"];
									$PROCESSDATADETAIL['NO_DOK_MASUK'] = $VALDETIL["NO_DOK_MASUK"];
									$PROCESSDATADETAIL['TGL_DOK_MASUK'] = $VALDETIL["TGL_DOK_MASUK"];
									$PROCESSDATADETAIL['JUMLAH'] = str_replace(",",".",$VALDETIL["JUMLAH"]);
									$PROCESSDATADETAIL['JUMLAH_SISA'] = str_replace(",",".",$VALDETIL["JUMLAH"]);
									$PROCESSDATADETAIL['KETERANGAN'] = $VALDETIL["KETERANGAN"];
									$execDetail = $this->db->insert("m_trader_stockopname_dtl",$PROCESSDATADETAIL);
								}else{
									if($optional=="KALKULASI"){
										$VAF["JUMLAH"] = str_replace(',','.',$VALDETIL['JUMLAH'])+$STOCKC[0];
									}elseif($optional=="REPLACE"){
										$VAF["JUMLAH"] = str_replace(',','.',$VALDETIL['JUMLAH']);
									}else{
										$VAF["JUMLAH"] = str_replace(',','.',$VALDETIL['JUMLAH']);
									}
									$this->db->where(array('JENIS_DOK_MASUK'=>$VALDETIL["JENIS_DOK_MASUK"],'KODE_TRADER'=>$kodetrader,'NO_DOK_MASUK'=>$VALDETIL["NO_DOK_MASUK"],'TGL_DOK_MASUK'=>$VALDETIL['TGL_DOK_MASUK']));
									$execDetail = $this->db->update('m_trader_stockopname_dtl', $VAF);
								}
							}
						}
						if($execDetail){
							$sukses = $this->fungsi->msg("done","Data Berhasil diproses");	
						}else{
							$error = $this->fungsi->msg("error","Data Gagal diproses");	 
						}
					}
				}								
				break;
			}			
		}
		if($error){
			echo $this->load->view('upload/stockopname',array("proses"=>"error","msg"=>$error),true);
			unlink($file);
		}else{
			echo $this->load->view('upload/stockopname',array("proses"=>"sukses","msg"=>$sukses),true);
			unlink($file);
		}
	}
	
	#END STOCKOPNAME
	
	function tess(){
		$JUMSTOCK=0; $JUMLAH_SATUAN='177720';
		$SQLSALDO = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI_BARANG, NAMA_BARANG,
SATUAN, JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='EDIILAUT0000' 
AND KODE_BARANG='STEELSCRAP' AND JNS_BARANG='1' 
AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') ORDER BY TGL_MASUK ASC;";	
		$RSSALDO = $this->db->query($SQLSALDO);		
		if($RSSALDO->num_rows()>0){
			$JUMSALDO = 0;
			$DATAMASUK = array();
			$JUMSTOCKNSALDO=0;
			foreach($RSSALDO->result_array() as $DATA){
				$JUMSALDO = $DATA["SALDO"];	
				$LOGID = $DATA["LOGID"];	
				$DATAMASUK[] = array("JENIS_DOK"=>$DATA["JENIS_DOK"],"NO_DOK"=>$DATA["NO_DOK"],"TGL_DOK"=>$DATA["TGL_DOK"]);	
				$JUMSTOCKNSALDO = $JUMSTOCKNSALDO + ($JUMSTOCK + $JUMSALDO);	
echo $JUMSTOCKNSALDO." ".$JUMLAH_SATUAN;
				if($JUMSTOCKNSALDO >= $JUMLAH_SATUAN){	
					echo "siini";

					$SALDOAKHIR = $JUMSTOCKNSALDO - $JUMLAH_SATUAN;
					$this->db->where("LOGID",$LOGID);
					echo $SALDOAKHIR;	
					echo "siini";
				}else{
					echo "situ";
				}			
			}	
		}

	}
	
	function replace_kdbarang($string=""){
		if($string){
			$string = strip_tags($string,"");
			//$string = preg_replace('/[^A-Za-z0-9\s.\s-\-_,]/','',$string); 
			//return $string = str_replace( array('', "'", "`",' ','"'), '', $string);
			return $string = str_replace( array('', "'", "`",'"'), '', $string);
		}
	}

	//START UPLOAD GUDANG
	function gudang(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/gudang',array("proses"=>""),false);
	}
	
	function proses_gudang(){		
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0); 
		$this->load->model("main");
		$this->load->model('upload_act');	
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');
		if($idHeader=="")redirect('uploadnew/gudang','refresh');
		$highestColumn = 2;	
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');
		$dtgudang = $this->upload_act->getDataKodeUpload('gudang');
		$mandatory = array("0","1");
		#================================	
		$KOLOM = array("1"=>"A","2"=>"B","3"=>"C");	
		$namaFile= $idHeader;
		$file = "assets/file/upload/";
		chmod($file,0777);
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."gudang.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);	
		$this->upload->display_errors('' ,'' );
		if(!$this->upload->do_upload("fileUpload")){
			//echo "tampilll"; die();
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			$data = $this->upload->data();			
			$file = $file.$data['file_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 	$proses = FALSE;
			$kosong = FALSE;
			$kodegudang = FALSE;
			$dok_masuk = FALSE;
			foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow         = $worksheet->getHighestRow(); 
				$highestColumn      = $worksheet->getHighestColumn(); 
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$arraytemp = array();
				$arraytemp_jumlah = array();
				for($row=2; $row <= $highestRow; $row++){
					for($col=0; $col <= ($highestColumnIndex-1); $col++){
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						if(in_array($col,$mandatory)){
							if(trim($cell->getCalculatedValue())==""){
								$kosong = TRUE;	
								$msgkosong = $msgkosong."KOLOM:[".$KOLOM[$col+1].",".$row."], ";
							}
						}
					}
					
					$cell_kdgudang = $worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue();
					if($cell_kdgudang){
						if(in_array($cell_kdgudang,$dtgudang)){
							$kodegudang= TRUE;	
							$msgkodegudang = $msgkodegudang."KOLOM:[A,".$row."], ";
						}
					}
				}
				
				if($kosong){
					$msg = "Terdapat data Gudang yang kosong pada kolom yang harus diisi: ".$msgkosong;	
					$error .= $this->fungsi->msg("error",$msg);		
				}
				
				if($kodegudang){
					$msg = "Terdapat kode gudang yang sama dengan yang sudah ada di Database : ".$msgkodegudang;	
					$error .= $this->fungsi->msg("error",$msg);
				}
			
				if(!$error){
					$proses = TRUE;
					for($row=2; $row <= $highestRow; $row++){
						$DATAGUDANG['KODE_TRADER'] = strtoupper($kodetrader);
						$DATAGUDANG['KODE_GUDANG'] = strtoupper($worksheet->getCellByColumnAndRow(0,$row)->getValue());
						$DATAGUDANG['NAMA_GUDANG'] = strtoupper($worksheet->getCellByColumnAndRow(1,$row)->getValue());
						$DATAGUDANG['KETERANGAN'] = strtoupper($worksheet->getCellByColumnAndRow(2,$row)->getValue());
						$exec = $this->db->insert("m_trader_gudang",$DATAGUDANG);
						$this->main->activity_log('ADD GUDANG','KODE_GUDANG='.$DATAGUDANG['KODE_GUDANG'].', NAMA_GUDANG='.$DATAGUDANG['NAMA_GUDANG'],'UPLOAD');
					}
					if($exec){
						$sukses = $this->fungsi->msg("done","Data Berhasil diproses");	
					}else{
						$error = $this->fungsi->msg("error","Data Gagal diproses");	 
					}
			
				}								
				break;
			}			
		}
		if($error){
			echo $this->load->view('upload/gudang',array("proses"=>"error","msg"=>$error),true);
			unlink($file);
		}else{
			echo $this->load->view('upload/gudang',array("proses"=>"sukses","msg"=>$sukses),true);
			unlink($file);
		}
	}
	//END UPLOAD GUDANG 
	
	//START UPLOAD GUDANG
	function rak(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->view('upload/rak',array("proses"=>""),false);
	}
	function proses_rak(){
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0); 
		$this->load->model("main");
		$this->load->model('upload_act');	
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');
		if($idHeader=="")redirect('uploadnew/rak','refresh');
		$highestColumn = 2;	
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');
		$dtgudang = $this->upload_act->getDataKodeUpload('gudang');
		//$dtrak = $this->upload_act->getDataKodeUpload('rak');
		$mandatory = array("0","1","2");
		#================================	
		$KOLOM = array("1"=>"A","2"=>"B","3"=>"C","4"=>"D");	
		$namaFile= $idHeader;
		$file = "assets/file/upload/";
		chmod($file,0777);
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."rak.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);	
		$this->upload->display_errors('' ,'' );
		if(!$this->upload->do_upload("fileUpload")){
			//echo "tampilll"; die();
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			$data = $this->upload->data();			
			$file = $file.$data['file_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 	$proses = FALSE;
			$kosong = FALSE;
			$kodegudang = FALSE;
			$dok_masuk = FALSE;
			foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow         = $worksheet->getHighestRow(); 
				$highestColumn      = $worksheet->getHighestColumn(); 
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$arraytemp = array();
				$arraytemp_jumlah = array();
				for($row=2; $row <= $highestRow; $row++){
					for($col=0; $col <= ($highestColumnIndex-1); $col++){
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						if(in_array($col,$mandatory)){
							if(trim($cell->getCalculatedValue())==""){
								$kosong = TRUE;	
								$msgkosong = $msgkosong."KOLOM:[".$KOLOM[$col+1].",".$row."], ";
							}
						}
					}
					$cell_kdgudang = $worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue();
					if($cell_kdgudang){
						if(!in_array($cell_kdgudang,$dtgudang)){
							$kodegudang= TRUE;	
							$msgkodegudang = $msgkodegudang."KOLOM:[A,".$row."], ";
						}
					}
					$cell_kdrak = $worksheet->getCellByColumnAndRow(1,$row)->getCalculatedValue();
					if($cell_kdrak){						
						$dtrak		= $this->upload_act->getDataKodeUpload('rak','','','','',$cell_kdgudang);
						if(in_array($cell_kdrak,$dtrak)){
							$koderak= TRUE;
							$msgkoderak = $msgkoderak."KOLOM:[B,".$row."], ";
						}
					}	
				}
				
				if($kosong){
					$msg = "Terdapat data Rak yang kosong pada kolom yang harus diisi: ".$msgkosong;	
					$error .= $this->fungsi->msg("error",$msg);		
				}
				
				if($kodegudang){
					$msg = "Terdapat kode gudang yang belum terdaftar di Database : ".$msgkodegudang;	
					$error .= $this->fungsi->msg("error",$msg);
				}
				
				if($koderak){
					$msg = "Terdapat kode rak yang sama di gudang yang sama dengan yang sudah ada di Database : ".$msgkoderak;
					$error .= $this->fungsi->msg("error",$msg);
				}
			
				if(!$error){
					$proses = TRUE;
					for($row=2; $row <= $highestRow; $row++){
						$DATARAK['KODE_TRADER'] = strtoupper($kodetrader);
						$DATARAK['KODE_GUDANG'] = strtoupper($worksheet->getCellByColumnAndRow(0,$row)->getValue());
						$DATARAK['KODE_RAK']	= strtoupper($worksheet->getCellByColumnAndRow(1,$row)->getValue());
						$DATARAK['NAMA_RAK'] 	= strtoupper($worksheet->getCellByColumnAndRow(2,$row)->getValue());
						$DATARAK['KETERANGAN'] 	= strtoupper($worksheet->getCellByColumnAndRow(3,$row)->getValue());
						$exec = $this->db->insert("m_trader_rak",$DATARAK);
						$this->main->activity_log('ADD RAK','KODE_RAK='.$DATARAK['KODE_RAK'].', NAMA_RAK='.$DATARAK['NAMA_RAK'],'UPLOAD');
					}
					if($exec){
						$sukses = $this->fungsi->msg("done","Data Berhasil diproses");	
					}else{
						$error = $this->fungsi->msg("error","Data Gagal diproses");	 
					}
			
				}								
				break;
			}			
		}
		if($error){
			echo $this->load->view('upload/rak',array("proses"=>"error","msg"=>$error),true);
			unlink($file);
		}else{
			echo $this->load->view('upload/rak',array("proses"=>"sukses","msg"=>$sukses),true);
			unlink($file);
		}		
	}
	//END UPLOAD RAK
	
	//START UPLOAD SUB RAK
	function subrak(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->view('upload/subrak',array("proses"=>""),false);
	}
	function proses_subrak(){
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0); 
		$this->load->model("main");
		$this->load->model('upload_act');	
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');
		if($idHeader=="")redirect('uploadnew/subrak','refresh');
		$highestColumn = 2;	
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');
		$dtgudang = $this->upload_act->getDataKodeUpload('gudang');
		//$dtrak = $this->upload_act->getDataKodeUpload('rak');
		$mandatory = array("0","1","2","3");
		#================================	
		$KOLOM = array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E");	
		$namaFile= $idHeader;
		$file = "assets/file/upload/";
		chmod($file,0777);
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."subrak.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);	
		$this->upload->display_errors('' ,'' );
		if(!$this->upload->do_upload("fileUpload")){
			//echo "tampilll"; die();
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			$data = $this->upload->data();			
			$file = $file.$data['file_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 	$proses = FALSE;
			$kosong = FALSE;
			$kodegudang = FALSE;
			$dok_masuk = FALSE;
			foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow         = $worksheet->getHighestRow(); 
				$highestColumn      = $worksheet->getHighestColumn(); 
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$arraytemp = array();
				$arraytemp_jumlah = array();
				for($row=2; $row <= $highestRow; $row++){
					for($col=0; $col <= ($highestColumnIndex-1); $col++){
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						if(in_array($col,$mandatory)){
							if(trim($cell->getCalculatedValue())==""){
								$kosong = TRUE;	
								$msgkosong = $msgkosong."KOLOM:[".$KOLOM[$col+1].",".$row."], ";
							}
						}
					}
					$cell_kdgudang = $worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue();
					if($cell_kdgudang){
						if(!in_array($cell_kdgudang,$dtgudang)){
							$kodegudang= TRUE;	
							$msgkodegudang = $msgkodegudang."KOLOM:[A,".$row."], ";
						}
					}					
					$cell_kdrak = $worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
					if($cell_kdrak){
						$dtrak = $this->upload_act->getDataKodeUpload('rak','','','','',$cell_kdgudang);
						if(!in_array($cell_kdrak,$dtrak)){
							$koderak = TRUE;	
							$msgkoderak = $msgkoderak."KOLOM:[B,".$row."], ";
						}
					}
					$cell_kdsubrak = $worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();
					if($cell_kdsubrak){						
						$dtsubrak = $this->upload_act->getDataKodeUpload('subrak','','','','',$cell_kdgudang,$cell_kdrak);
						if(in_array($cell_kdsubrak,$dtsubrak)){
							$kodesubrak= TRUE;
							$msgkodesubrak = $msgkodesubrak."KOLOM:[C,".$row."], ";
						}
					}	
				}
				
				if($kosong){
					$msg = "Terdapat data Sub Rak yang kosong pada kolom yang harus diisi: ".$msgkosong;	
					$error .= $this->fungsi->msg("error",$msg);		
				}
				
				if($kodegudang){
					$msg = "Terdapat kode gudang yang belum terdaftar di Database : ".$msgkodegudang;	
					$error .= $this->fungsi->msg("error",$msg);
				}
				
				if($koderak){
					$msg = "Terdapat kode rak yang belum terdaftar di Database : ".$msgkoderak;	
					$error .= $this->fungsi->msg("error",$msg);
				}
				
				if($kodesubrak){
					$msg = "Terdapat kode sub rak yang sama di gudang dan rak yang sama dengan yang sudah ada di Database : ".$msgkodesubrak;
					$error .= $this->fungsi->msg("error",$msg);
				}
			
				if(!$error){
					$proses = TRUE;
					for($row=2; $row <= $highestRow; $row++){
						$DATASUBRAK['KODE_TRADER'] = strtoupper($kodetrader);
						$DATASUBRAK['KODE_GUDANG'] = strtoupper($worksheet->getCellByColumnAndRow(0,$row)->getValue());
						$DATASUBRAK['KODE_RAK']		= strtoupper($worksheet->getCellByColumnAndRow(1,$row)->getValue());
						$DATASUBRAK['KODE_SUB_RAK']	= strtoupper($worksheet->getCellByColumnAndRow(2,$row)->getValue());
						$DATASUBRAK['NAMA_SUB_RAK'] = strtoupper($worksheet->getCellByColumnAndRow(3,$row)->getValue());
						$DATASUBRAK['KETERANGAN'] 	= strtoupper($worksheet->getCellByColumnAndRow(4,$row)->getValue());
						$exec = $this->db->insert("m_trader_sub_rak",$DATASUBRAK);
						$this->main->activity_log('ADD RAK','KODE_SUB_RAK='.$DATASUBRAK['KODE_SUB_RAK'].', NAMA_SUB_RAK='.$DATASUBRAK['NAMA_SUB_RAK'],'UPLOAD');
					}
					if($exec){
						$sukses = $this->fungsi->msg("done","Data Berhasil diproses");	
					}else{
						$error = $this->fungsi->msg("error","Data Gagal diproses");	 
					}
			
				}								
				break;
			}			
		}
		if($error){
			echo $this->load->view('upload/subrak',array("proses"=>"error","msg"=>$error),true);
			unlink($file);
		}else{
			echo $this->load->view('upload/subrak',array("proses"=>"sukses","msg"=>$sukses),true);
			unlink($file);
		}		
	}
	
	function bc16(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_bc16',array("proses"=>""));
	}
	
	function proses_upload_bc16() {
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0);
		//$this->db->trans_begin();
		$this->load->model("main");
		$this->load->model('upload_act');
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');
		if($idHeader=="")redirect('uploadnew/bc16','refresh');
		#constanta validasi 4 pabean
		$highestColumn = 135;		
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');	
		$fieldHeader = array('NOMOR_AJU','KODE_KPBC_BONGKAR','KODE_KPBC_AWAS','NAMA_PENGIRIM','ALAMAT_PENGIRIM','NAMA_PENJUAL','ALAMAT_PENJUAL','NEGARA_PENJUAL','KODE_ID_TRADER','ID_TRADER','NAMA_TRADER','ALAMAT_TRADER','KODE_ID_PEMILIK','ID_PEMILIK','NAMA_PEMILIK','ALAMAT_PEMILIK','MODA','NAMA_ANGKUT','BENDERA','PELABUHAN_MUAT','PELABUHAN_TRANSIT','PELABUHAN_BONGKAR','PERKIRAAN_TGL_TIBA','NOMOR_PENUTUP','TANGGAL_PENUTUP','NOMOR_POS','SUB_POS','SUB_SUB_POS','KODE_VALUTA','KODE_HARGA','JENIS_NILAI','NILAI','CIF_RP','BRUTO','NETTO','PEMBERITAHU','JABATAN','KOTA_TTD','TANGGAL_TTD','NOMOR_PENDAFTARAN','TANGGAL_PENDAFTARAN','NOMOR_ANGKUT','NEGARA_PENGIRIM','NEGARA_PEMILIK','KODE_TIMBUN','KODE_PENUTUP');
		$colHeader = array('0','69','1','93','10','3','7','73','57','36','2','11','54','33','90','8','47','92','46','78','79','77','122','101','114','110','112','113','88','52','65','20','21','19','97','95','38','89','123','103','117','108','74','75','83','87');
		
		$fieldBarang = array('NOMOR_AJU','SERI','HARGA_CIF','CIF_RP','JUMLAH_KEMASAN','JUMLAH_SATUAN','PENGGUNAAN','KODE_BARANG','KODE_FAS','JENIS_NILAI','KODE_KEMASAN','NEGARA_ASAL','KODE_SATUAN','MERK','NETTO','NILAI','SPF','TIPE','UKURAN','URAIAN_BARANG','KODE_HS');
		$colBarang = array('0','1','3','3','15','16','18','20','21','23','24','26','27','31','32','3','38','40','41','42','36');
		
		$fieldDok = array('NOMOR_AJU','KODE_DOKUMEN','NOMOR','TANGGAL');
		$colDok = array('0','3','4','5');
		
		$fieldKms = array('NOMOR_AJU','KODE_KEMASAN','JUMLAH','MERK_KEMASAN');
		$colKms = array('0','5','2','6');
		
		$fieldCnt = array('NOMOR_AJU','NOMOR','UKURAN','TIPE');
		$colCnt = array('0','10','6','5');
		
		$fieldFas = array("NOMOR_AJU","SERI","KODE_FAS_BM","FAS_BM");
		$colFas = array("0","1","4","12");
		
		$fieldTrf = array("NOMOR_AJU","JENIS_TARIF","KODE_TARIF_BM","KODE_SATUAN_BM","TARIF_BM","JUMLAH_SATUAN_BM","SERI");
		$colTrf = array("0","2","7","6","11","4","1");
		
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
		$aju = array();
		if(!$this->upload->do_upload("fileUpload")){
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 
			$this->db->reconnect();
			# START SHEET HEADER
			$inputFileType = 'Excel5'; 
			$sheetname = 'Header'; 
			$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
			$objReader->setLoadSheetsOnly($sheetname); 
			$objHeader = $objReader->load($file);
			foreach($objHeader->getWorksheetIterator() as $workSheet){
				$highestRows = $workSheet->getHighestRow();
				$idx = 0;

				for ($x=2; $x <= $highestRows; $x++) {
					for($y = 0; $y < count($colHeader); $y++){
						$dataHeader[$idx][$fieldHeader[$y]] = $workSheet->getCellByColumnAndRow($colHeader[$y], $x)->getCalculatedValue();
					}
					$cek_aju = $this->cek_noaju($dataHeader[$idx]["NOMOR_AJU"],"BC16");
					
					if($dataHeader[$idx]["CIF_RP"]==""){
						$dataHeader[$idx]["CIF_RP"] = NULL;
					}
					if($dataHeader[$idx]['TANGGAL_PENDAFTARAN']==""){
						$dataHeader[$idx]['TANGGAL_PENDAFTARAN'] = NULL;
					}else{
						$dataHeader[$idx]['TANGGAL_PENDAFTARAN'] = $this->fungsi->formatshortdate($dataHeader[$idx]['TANGGAL_PENDAFTARAN']);
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
					if($cek_aju==TRUE){
						$error .= $dataHeader[$idx]["NOMOR_AJU"].", ";
						array_push($aju, $dataHeader[$idx]["NOMOR_AJU"]);
					}else{
						$exe = $this->db->insert('T_BC16_HDR',$dataHeader[$idx]); 
						if($exe){
							$oke = TRUE;
							$sukses = "Upload sukses";
						}
					}
					
					$idx++;
				}
					if($error){
						$error = "Nomor Aju berikut sudah ada dalam database : <strong>".$error."</strong>";
					}
			}
				
			if($oke==TRUE){
				# START SHEET BARANG
				$inputFileType = 'Excel5'; 
				$sheetname = 'Barang'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objBarang = $objReader->load($file);
				foreach($objBarang->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colBarang); $y++){
							$dataBarang[$idx][$fieldBarang[$y]] = $workSheet->getCellByColumnAndRow($colBarang[$y], $x)->getCalculatedValue();
						}
						
						if(in_array($dataBarang[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataBarang[$idx]['JNS_BARANG'] = $this->main->get_uraian("SELECT JNS_BARANG FROM m_trader_barang WHERE KODE_BARANG = '".$dataBarang[$idx]['KODE_BARANG']."' AND KODE_TRADER = '".$kodetrader."'","JNS_BARANG");
						$dataBarang[$idx]['KODE_TRADER'] = $kodetrader;
						$dataBarang[$idx]['STATUS'] = '04';
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC16_DTL',$dataBarang[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}

				# START SHEET FAS
				$inputFileType = 'Excel5'; 
				$sheetname = 'BarangTarif'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objTarif = $objReader->load($file);
				foreach($objTarif->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colFas); $y++){
							$dataFas[$idx][$fieldFas[$y]] = $workSheet->getCellByColumnAndRow($colFas[$y], $x)->getCalculatedValue();
						}
						
						if(in_array($dataFas[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataFas[$idx]['KODE_TRADER'] = $kodetrader;
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC16_FAS',$dataFas[$idx]); 
						}
						
						$idx++;
					}
					if($exe){
						$sukses = "Upload sukses";
					}
				}
				
				# START SHEET TARIF
				$inputFileType = 'Excel5'; 
				$sheetname = 'BarangTarif'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objTarif = $objReader->load($file);
				foreach($objTarif->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colTrf); $y++){
							$dataTrf[$idx][$fieldTrf[$y]] = $workSheet->getCellByColumnAndRow($colTrf[$y], $x)->getCalculatedValue();
						}
						
						if(in_array($dataTrf[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataTrf[$idx]['KODE_TRADER'] = $kodetrader;
						$dataTrf[$idx]['KODE_HS'] = $this->main->get_uraian("SELECT KODE_HS FROM t_bc16_dtl WHERE NOMOR_AJU = '".$dataTrf[$idx]["NOMOR_AJU"]."' AND SERI = '".$dataTrf[$idx]["SERI"]."' AND KODE_TRADER = '".$kodetrader."'","KODE_HS");
						
						$this->db->where(array("NOMOR_AJU"=>$dataTrf[$idx]["NOMOR_AJU"],"SERI"=>$dataTrf[$idx]["SERI"],"KODE_TRADER"=>$kodetrader));
						$this->db->update("t_bc16_dtl",array("JUMLAH_SATUAN_BM"=>$dataTrf[$idx]["JUMLAH_SATUAN_BM"]));
						
						if($cek_aju==FALSE){
							unset($dataTrf[$idx]["JUMLAH_SATUAN_BM"]);
							$exe = $this->db->insert('T_BC16_TRF',$dataTrf[$idx]); 
						}
						
						$idx++;
					}
					if($exe){
						$sukses = "Upload sukses";
					}
				}

				# START SHEET DOKUMEN
				$inputFileType = 'Excel5'; 
				$sheetname = 'Dokumen'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objDokumen = $objReader->load($file);
				foreach($objDokumen->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colDok); $y++){
							$dataDokumen[$idx][$fieldDok[$y]] = $workSheet->getCellByColumnAndRow($colDok[$y], $x)->getCalculatedValue();
						}
						$dataDokumen[$idx]["TANGGAL"] = $this->fungsi->formatshortdate($dataDokumen[$idx]["TANGGAL"]);
						if(in_array($dataDokumen[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataDokumen[$idx]['KODE_TRADER'] = $kodetrader;
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC16_DOK',$dataDokumen[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}

				# START SHEET KEMASAN
				$inputFileType = 'Excel5'; 
				$sheetname = 'Kemasan'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objKemasan = $objReader->load($file);
				foreach($objKemasan->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colKms); $y++){
							$dataKemasan[$idx][$fieldKms[$y]] = $workSheet->getCellByColumnAndRow($colKms[$y], $x)->getCalculatedValue();
						}
						if(in_array($dataKemasan[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataKemasan[$idx]['KODE_TRADER'] = $kodetrader;
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC16_KMS',$dataKemasan[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}

				# START SHEET KONTAINER
				$inputFileType = 'Excel5'; 
				$sheetname = 'Kontainer'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objKontainer = $objReader->load($file);
				foreach($objKontainer->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colCnt); $y++){
							$dataKontainer[$idx][$fieldCnt[$y]] = $workSheet->getCellByColumnAndRow($colCnt[$y], $x)->getCalculatedValue();
						}
						if(in_array($dataKontainer[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataKontainer[$idx]['KODE_TRADER'] = $kodetrader;
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC16_CNT',$dataKontainer[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}
				// if($this->db->trans_status() === FALSE){
				//     $this->db->trans_rollback();
				// }else{
				//     $this->db->trans_commit();
				// }
			}		
		}
		if($error){
			unlink('/home/inguber/assets/file/upload/'.$file);
			echo $this->load->view('upload/form_upload_bc16',array("proses"=>"error","error"=>$error,"sukses"=>$sukses),true);
		}else{
			unlink('/home/inguber/assets/file/upload/'.$file);
			echo $this->load->view('upload/form_upload_bc16',array("proses"=>"sukses","error"=>$error,"sukses"=>$sukses),true);
		}
	}

	function bc28(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->view('upload/form_upload_bc28',array("proses"=>""));
	}
	
	function proses_upload_bc28() {
		ini_set('memory_limit','-1');
		ini_set('upload_max_filesize', '20M');
		set_time_limit(0);
		$this->db->trans_begin();
		$this->load->model("main");
		$this->load->model('upload_act');
		$this->load->library('newphpexcel');
		$idHeader = $this->input->post('id');
		if($idHeader=="")redirect('upload/upload_bc28','refresh');
		#constanta validasi 4 pabean
		$highestColumn = 145;		
		$kodetrader = $this->newsession->userdata("KODE_TRADER");	
		$userid = $this->newsession->userdata('USER_ID');	
		$fieldHeader = array('NOMOR_AJU','KODE_KANTOR_PABEAN','NAMA_PENGUSAHA','NAMA_PENJUAL','ALAMAT_IMPORTIR','ALAMAT_PENJUAL','ALAMAT_PEMILIK','ALAMAT_PENGUSAHA','NOMOR_API','BRUTO','NILAI_CIF','CIF_RP','ID_IMPORTIR','ID_PENJUAL','ID_PEMILIK','ID_PENGUSAHA','JABATAN','MODA','CARA_PEMBAYARAN','NILAI','KODE_ID_IMPORTIR','KODE_ID_PENJUAL','KODE_ID_PEMILIK','KODE_ID_PENGUSAHA','KODE_API','JENIS_IMPOR','JENIS_BC28','JENIS_NILAI','KODE_PEMBAYARAN','NEGARA_PENJUAL','STATUS_IMPORTIR','KODE_VALUTA','KOTA_TTD','NAMA_IMPORTIR','NAMA_PEMILIK','PEMBERITAHU','NDPBM','NETTO','NIK_IMPORTIR','TANGGAL_TTD','KODE_TIMBUN','NOMOR_PENDAFTARAN','TANGGAL_PENDAFTARAN');
		$colHeader = array('0','1','2','3','7','8','9','12','14','21','22','23','33','35','36','39','41','50','51','55','56','57','58','61','64','70','71','72','78','79','87','95','96','97','98','103','104','105','106','132','90','112','126');
		$fieldBarang = array('NOMOR_AJU','SERI','CIF','CIF_RP','LARTAS','HARGA_SATUAN','TGL_JATUH_TEMPO','JUMLAH_KEMASAN','JUMLAH_SATUAN','KODE_BARANG','KODE_FASILITAS','JENIS_NILAI','KODE_KEMASAN','NEGARA_ASAL','KODE_SATUAN','SKEMA','MERK','NETTO','NILAI_TAMBAHAN','KODE_HS','SERI_HS','SPF','TIPE','UKURAN','URAIAN_BARANG');
		$colBarang = array('0','1','3','4','6','13','16','19','21','25','26','28','29','31','32','33','36','37','39','43','44','45','47','48','49');
		$fieldDok = array('NOMOR_AJU','KODE_DOKUMEN','NOMOR','TANGGAL');
		$colDok = array('0','4','5','6');
		$fieldKms = array('NOMOR_AJU','KODE_KEMASAN','JUMLAH','MERK_KEMASAN');
		$colKms = array('0','5','2','6');
		$fieldCnt = array('NOMOR_AJU','NOMOR','UKURAN','TIPE');
		$colCnt = array('0','10','6','5');
		
		$namaFile = $idHeader;
		$file = "assets/file/upload/";
		$error = "";
		$config['upload_path'] = $file;
		$config['allowed_types'] = 'xls|xlsx';
		$config['remove_spaces'] = TRUE;
		$config['max_size']	= '20000';
		$config['encrypt_name'] = TRUE;
		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);	
		$config['file_name'] = date("Ymd")."_".date("His")."_".$kodetrader."_".$userid."BC28.".$ext;
		$config['overwrite'] = TRUE;
		$this->load->library('upload' , $config);
		$data = $this->upload->data();			
		$file = $file.$data['file_name'];	
		$this->upload->display_errors('' ,'' );
		$aju = array();
		if(!$this->upload->do_upload("fileUpload")){
			$error = $this->fungsi->msg("error",str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors())));
		}else{
			
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$objPHPExcel->setActiveSheetIndex(0);
		 
			$this->db->reconnect();
			# START SHEET HEADER
			$inputFileType = 'Excel5'; 
			$sheetname = 'Header'; 
			$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
			$objReader->setLoadSheetsOnly($sheetname); 
			$objHeader = $objReader->load($file);
			foreach($objHeader->getWorksheetIterator() as $workSheet){
				$highestRows = $workSheet->getHighestRow();
				$idx = 0;

				for ($x=2; $x <= $highestRows; $x++) {
					for($y = 0; $y < count($colHeader); $y++){
						$dataHeader[$idx][$fieldHeader[$y]] = $workSheet->getCellByColumnAndRow($colHeader[$y], $x)->getCalculatedValue();
					}
					$cek_aju = $this->cek_noaju($dataHeader[$idx]["NOMOR_AJU"],"BC28");
					
					if($dataHeader[$idx]["CIF_RP"]==""){
						$dataHeader[$idx]["CIF_RP"] = NULL;
					}
					if($dataHeader[$idx]['TANGGAL_PENDAFTARAN']==""){
						$dataHeader[$idx]['TANGGAL_PENDAFTARAN'] = NULL;
					}else{
						$dataHeader[$idx]['TANGGAL_PENDAFTARAN'] = $this->fungsi->formatshortdate($dataHeader[$idx]['TANGGAL_PENDAFTARAN']);
					}
					$tgl_aju = substr($dataHeader[$idx]['NOMOR_AJU'], 12, 8);
					$dataHeader[$idx]['TANGGAL_AJU'] = substr($tgl_aju, 0, 4)."-".substr($tgl_aju, 4, 2)."-".substr($tgl_aju, 6, 2);
					$dataHeader[$idx]['TANGGAL_TTD'] = $this->fungsi->formatshortdate($dataHeader[$idx]['TANGGAL_TTD']);
					$dataHeader[$idx]['KODE_TRADER'] = $kodetrader;
					$dataHeader[$idx]['STATUS'] = '00';
					$dataHeader[$idx]['CREATED_BY'] = $userid;
					$dataHeader[$idx]['CREATED_TIME'] = date('Y-m-d H:i:s',time()-60*60*1);
					if($cek_aju==TRUE){
						$error .= $dataHeader[$idx]["NOMOR_AJU"].", ";
						array_push($aju, $dataHeader[$idx]["NOMOR_AJU"]);
					}else{#print_r($dataHeader[$idx]);die();
						$exe = $this->db->insert('T_BC28_HDR',$dataHeader[$idx]);
						if($exe){
							$oke = TRUE;
							$sukses = "Upload sukses";
						}
					}
					
					$idx++;
				}
					if($error){
						$error = "Nomor Aju berikut sudah ada dalam database : <strong>".$error."</strong>";
					}
			}
				
			if($oke==TRUE){
				# START SHEET BARANG
				$inputFileType = 'Excel5'; 
				$sheetname = 'Barang'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objBarang = $objReader->load($file);
				foreach($objBarang->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colBarang); $y++){
							$dataBarang[$idx][$fieldBarang[$y]] = $workSheet->getCellByColumnAndRow($colBarang[$y], $x)->getCalculatedValue();
						}
						$dataBarang[$idx]['JNS_BARANG'] = $this->main->get_uraian("SELECT JNS_BARANG FROM m_trader_barang WHERE KODE_BARANG = '".$dataBarang[$idx]['KODE_BARANG']."' AND KODE_TRADER = '".$kodetrader."'","JNS_BARANG");
						if(in_array($dataBarang[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						if($dataBarang[$idx]['LARTAS']=="N"){
							$dataBarang[$idx]['LARTAS'] = "0";
						}elseif($dataBarang[$idx]['LARTAS']=="Y"){
							$dataBarang[$idx]['LARTAS'] = "1";
						}else{
							$dataBarang[$idx]['LARTAS'] = NULL;
						}
						$dataBarang[$idx]['TGL_JATUH_TEMPO'] = $this->fungsi->formatshortdate($dataBarang[$idx]['TGL_JATUH_TEMPO']);
						$dataBarang[$idx]['KODE_TRADER'] = $kodetrader;
						$dataBarang[$idx]['STATUS'] = '04';
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC28_DTL',$dataBarang[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}

				# START SHEET TARIF
				/*$inputFileType = 'Excel5'; 
				$sheetname = 'BarangTarif'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objTarif = $objReader->load($file);
				foreach($objTarif->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colBarang); $y++){
							$dataBarang[$idx][$fieldBarang[$y]] = $workSheet->getCellByColumnAndRow($colBarang[$y], $x)->getCalculatedValue();
						}
						
						if(in_array($dataBarang[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataBarang[$idx]['KODE_TRADER'] = $kodetrader;
						$dataBarang[$idx]['STATUS'] = '04';
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC16_DTL',$dataBarang[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}*/

				# START SHEET DOKUMEN
				$inputFileType = 'Excel5'; 
				$sheetname = 'Dokumen'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objDokumen = $objReader->load($file);
				foreach($objDokumen->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colDok); $y++){
							$dataDokumen[$idx][$fieldDok[$y]] = $workSheet->getCellByColumnAndRow($colDok[$y], $x)->getCalculatedValue();
						}
						$dataDokumen[$idx]["TANGGAL"] = $this->fungsi->formatshortdate($dataDokumen[$idx]["TANGGAL"]);
						if(in_array($dataDokumen[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataDokumen[$idx]['KODE_TRADER'] = $kodetrader;
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC28_DOK',$dataDokumen[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}

				# START SHEET KEMASAN
				$inputFileType = 'Excel5'; 
				$sheetname = 'Kemasan'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objKemasan = $objReader->load($file);
				foreach($objKemasan->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colKms); $y++){
							$dataKemasan[$idx][$fieldKms[$y]] = $workSheet->getCellByColumnAndRow($colKms[$y], $x)->getCalculatedValue();
						}
						if(in_array($dataKemasan[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataKemasan[$idx]['KODE_TRADER'] = $kodetrader;
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC28_KMS',$dataKemasan[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}

				# START SHEET KONTAINER
				$inputFileType = 'Excel5'; 
				$sheetname = 'Kontainer'; 
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setLoadSheetsOnly($sheetname); 
				$objKontainer = $objReader->load($file);
				foreach($objKontainer->getWorksheetIterator() as $workSheet){
					$highestRows = $workSheet->getHighestRow();
					$idx = 0;
					for ($x=2; $x <= $highestRows; $x++) {
						for($y = 0; $y < count($colCnt); $y++){
							$dataKontainer[$idx][$fieldCnt[$y]] = $workSheet->getCellByColumnAndRow($colCnt[$y], $x)->getCalculatedValue();
						}
						if(in_array($dataKontainer[$idx]["NOMOR_AJU"], $aju)){
							$cek_aju = TRUE;
						}else{
							$cek_aju = FALSE;
						}
						$dataKontainer[$idx]['KODE_TRADER'] = $kodetrader;
						if($cek_aju==FALSE){
							$exe = $this->db->insert('T_BC28_CNT',$dataKontainer[$idx]); 
						}
						
						$idx++;
					}
						if($exe){
							$sukses = "Upload sukses";
						}
				}
				if($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				}else{
				    $this->db->trans_commit();
				}
			}		
		}
		if($error){
			unlink('/home/dev/plb/'.$file);
			echo $this->load->view('upload/form_upload_bc28',array("proses"=>"error","error"=>$error,"sukses"=>$sukses),true);
		}else{
			unlink('/home/dev/plb/'.$file);
			echo $this->load->view('upload/form_upload_bc28',array("proses"=>"sukses","error"=>$error,"sukses"=>$sukses),true);
		}
	}

}

?>