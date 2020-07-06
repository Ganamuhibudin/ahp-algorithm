<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan extends CI_Controller{
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
	
	function tipe_laporan($tipe=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader =$this->newsession->userdata('KODE_TRADER');
		
		$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["autocomplete"] = 1;
		
		$this->load->model("laporan_act");
		$data = array("judul"=>"Laporan");	
		if($tipe=="mutasi"){
			$arrdata=$this->laporan_act->list_laporan($tipe,$kode_trader);
	 		$list = $this->load->view('list', $arrdata, true);
			$data = array("judul"=>"Laporan","list" =>$list);
			if($this->input->post("ajax")){
				echo  $arrdata;
			}else{
				$this->content = $this->load->view('laporan/mutasi', $data, true);	
				$this->index($tipe);
			}
		}else{
			$this->content = $this->load->view('laporan/'.$tipe, $data, true);	
			$this->index($tipe);
		}
	}
	
	function add($tipe=""){
		$this->load->model("laporan_act");
		$jenis="add";
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$data=$this->laporan_act->proses_form($tipe,$jenis);
			echo $data;
		}
	}
	function edit($tipe=""){
		$this->load->model("laporan_act");
		$jenis="edit";
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$data=$this->laporan_act->proses_form($tipe,$jenis);
			echo $data;
		}
	}
	
	function daftar_dok($tipe="",$tglAwal="",$tglAkhir="",$nama="",$kodebarang="",$jenisdokumen="",$ALL="",$TIPE_PERIODE="",$ALL_SALDO="",$cetak=""){
		#echo $kodebarang;die();
		error_reporting(E_ERROR);
		$this->load->model("laporan_act");
		$NAMATRADER = $this->newsession->userdata('NAMA_TRADER');
		$kodeTrader = $this->newsession->userdata('KODE_TRADER');
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$tglAwal=$this->input->post("TANGGAL_AWAL");
			$tglAkhir=$this->input->post("TANGGAL_AKHIR");
			$kodebarang=$this->input->post("KODE_BARANG");
			$jenis=$this->input->post("JENIS");
			$TIPE_TANGGAL=$this->input->post("TIPE_TANGGAL");
			$TIPE_PERIODE = $this->input->post('TIPE_PERIODE');
			$ALL = $this->input->post("ALL");
			$ALL_SALDO = $this->input->post("ALL_SALDO");
			if($tipe=="posisiharian"){
				$tglAwal = $this->input->post("KODE_DOKUMEN");
				$tglAkhir = $this->input->post("NOMOR_DAFTAR");
				$kodebarang = $this->input->post("TANGGAL_DAFTAR");
			}
		}else{
			if($cetak){
				ini_set("display_errors", 1);
				ini_set('memory_limit','-1');
				set_time_limit(0);
				if($tipe=='pemasukan'){
					$tittle="Laporan Pemasukan";
				}elseif($tipe=='pengeluaran'){
					$tittle="Laporan Pengeluaran";
				}elseif($tipe=='posisi'){
					$tittle="Laporan Posisi Barang Per Dokumen Pabean";
				}elseif($tipe=='mutasi'){
					$tittle="Laporan Pertanggungjawaban Mutasi Barang";
				}elseif($tipe=='pemusnahan'){
					$tittle="Laporan Pemusnahan Barang";
				}elseif($tipe=='produksi'){
					$tittle="Laporan Pengerjaan Sederhana";
				}elseif($tipe=='posisiharian'){
					$tittle="Laporan Posisi Barang Per Dokumen Pabean Harian";
				}
			}
		}
		
		if($tipe=="posisi"){
			$DATA_HEADER = array();
			$LOGID = array();
			$DATA_HEADER_IN = array();
			$DATA_HEADER_OU = array();
			$DATA_HEADER_INOUT_IN = array();
			$DATA_HEADER_INOUT_OUT = array();
			
			#PERIODE PEMASUKAN ================================================================================================
			if($TIPE_PERIODE=='IN' || $TIPE_PERIODE=='INOUT')
			{	
				$FLAG = ($TIPE_PERIODE=='INOUT') ? 'FIRST' : '';		
				$code = '';
				if($ALL_SALDO){				
					$GET_PEMASUKAN = $this->laporan_act->query_pemasukan($tglAwal,$tglAkhir,$TIPE_PERIODE,$ALL_SALDO,NULL,$FLAG);
					foreach($GET_PEMASUKAN as $row)
					{
						$LOGID[] = $row['LOGID_IN'];
					}
					if($LOGID != NULL){
						$code = implode("','",$LOGID);
					}
					$GET_ALL_SALDO = $this->laporan_act->query_any_saldo_in($tglAwal,$tglAkhir,$code);
					$GET_PEMASUKAN = array_merge($GET_ALL_SALDO,$GET_PEMASUKAN);
				}
				else{
					$GET_PEMASUKAN = $this->laporan_act->query_pemasukan($tglAwal,$tglAkhir,$TIPE_PERIODE,$ALL_SALDO,NULL,$FLAG);								
				}
				$LOGID = array();
				foreach($GET_PEMASUKAN as $row)
				{
					$LOGID[] = $row['LOGID_IN'];
					$DATA_HEADER[$row['LOGID_IN']] = array(
															'LOGID_IN' 			=> $row['LOGID_IN'],
															'JENIS_DOK_IN'		=> $row['JENIS_DOK_IN'],
															'NO_DOK_IN'			=> $row['NO_DOK_IN'],
															'TGL_DOK_IN'		=> $row['TGL_DOK_IN'],
															'TGL_MASUK_IN'		=> $row['TGL_MASUK_IN'],
															'KODE_BARANG_IN'	=> $row['KODE_BARANG_IN'],
															'JNS_BARANG_IN'		=> $row['JNS_BARANG_IN'],
															'SERI_BARANG_IN'	=> $row['SERI_BARANG_IN'],
															'NAMA_BARANG_IN'	=> $row['NAMA_BARANG_IN'],
															'SATUAN_IN'			=> $row['SATUAN_IN'],
															'JUMLAH_IN'			=> $row['JUMLAH_IN'],
															'NILAI_PABEAN_IN'	=> $row['NILAI_PABEAN_IN'],
															'FLAG_TUTUP'		=> $row['FLAG_TUTUP'],
															'SALDO'				=> $row['SALDO']
														);
				}
				if($LOGID != NULL){
					$code = implode("','",$LOGID);
				}
				
				$WHERE_1 = "(B.LOGID_MASUK IN ('".$code."'))";
				
				$GET_PENGELUARAN = $this->laporan_act->query_pengeluaran($tglAwal,$tglAkhir,$TIPE_PERIODE,$ALL_SALDO,$WHERE_1,$FLAG);	
				foreach($GET_PENGELUARAN as $row)
				{				
					$DATA_HEADER[$row['LOGID_MASUK']]['KELUAR'][] = array(
																		'LOGID_IN' 				=> $row['LOGID_MASUK'],
																		'LOGID_OUT' 			=> $row['LOGID_OUT'],
																		'JENIS_DOK_OUT' 		=> $row['JENIS_DOK_OUT'],
																		'NO_DOK_OUT' 			=> $row['NO_DOK_OUT'],
																		'TGL_DOK_OUT' 			=> $row['TGL_DOK_OUT'],
																		'TGL_MASUK_OUT' 		=> $row['TGL_MASUK_OUT'],
																		'KODE_BARANG_OUT' 		=> $row['KODE_BARANG_OUT'],
																		'JNS_BARANG_OUT' 		=> $row['JNS_BARANG_OUT'],
																		'SERI_BARANG_OUT' 		=> $row['SERI_BARANG_OUT'],
																		'NAMA_BARANG_OUT' 		=> $row['NAMA_BARANG_OUT'],
																		'SERI_BARANG_MASUK' 	=> $row['SERI_BARANG_MASUK'],
																		'NILAI_PABEAN_OUT' 		=> $row['NILAI_PABEAN_OUT'],
																		'NO_DOK_MASUK_OUT' 		=> $row['NO_DOK_MASUK_OUT'],
																		'TGL_DOK_MASUK_OUT' 	=> $row['TGL_DOK_MASUK_OUT'],
																		'JENIS_DOK_MASUK_OUT' 	=> $row['JENIS_DOK_MASUK_OUT'],
																		'SATUAN_OUT' 			=> $row['SATUAN_OUT'],
																		'JUMLAH_OUT' 			=> $row['JUMLAH_OUT'],
																		);
				}
				
				if($TIPE_PERIODE=='INOUT')
				{
					$DATA_HEADER_INOUT_IN = $DATA_HEADER;
				}
			}
					
			
			#PERIODE PENGELUARAN ================================================================================================
			$LOGID = array();
			if($TIPE_PERIODE=='OUT' || $TIPE_PERIODE=='INOUT')
			{	
				$FLAG = ($TIPE_PERIODE=='INOUT') ? 'SECOND' : '';
				$code = '';
				if($ALL_SALDO){				
					$GET_PENGELUARAN = $this->laporan_act->query_pengeluaran($tglAwal,$tglAkhir,$TIPE_PERIODE,$ALL_SALDO,NULL,$FLAG);
					foreach($GET_PENGELUARAN as $row)
					{
						$LOGID[] = $row['LOGID_MASUK'];
					}
					if($LOGID != NULL){
						$code = implode("','",$LOGID);
					}
					$GET_ALL_SALDO = $this->laporan_act->query_any_saldo_out($tglAwal,$tglAkhir,$code);
					$GET_PENGELUARAN = array_merge($GET_ALL_SALDO,$GET_PENGELUARAN);
				}
				else{
					$GET_PENGELUARAN = $this->laporan_act->query_pengeluaran($tglAwal,$tglAkhir,$TIPE_PERIODE,$ALL_SALDO,NULL,$FLAG);								
				}	
				$LOGID = array();				
				foreach($GET_PENGELUARAN as $row)
				{				
					$LOGID[] = $row['LOGID_MASUK'];
					$DATA_HEADER_OU[$row['LOGID_MASUK']]['KELUAR'][] = array(
																			'LOGID_IN' 				=> $row['LOGID_MASUK'],
																			'LOGID_OUT' 			=> $row['LOGID_OUT'],
																			'JENIS_DOK_OUT' 		=> $row['JENIS_DOK_OUT'],
																			'NO_DOK_OUT' 			=> $row['NO_DOK_OUT'],
																			'TGL_DOK_OUT' 			=> $row['TGL_DOK_OUT'],
																			'TGL_MASUK_OUT' 		=> $row['TGL_MASUK_OUT'],
																			'KODE_BARANG_OUT' 		=> $row['KODE_BARANG_OUT'],
																			'JNS_BARANG_OUT' 		=> $row['JNS_BARANG_OUT'],
																			'SERI_BARANG_OUT' 		=> $row['SERI_BARANG_OUT'],
																			'NAMA_BARANG_OUT' 		=> $row['NAMA_BARANG_OUT'],
																			'SERI_BARANG_MASUK' 	=> $row['SERI_BARANG_MASUK'],
																			'NILAI_PABEAN_OUT' 		=> $row['NILAI_PABEAN_OUT'],
																			'NO_DOK_MASUK_OUT' 		=> $row['NO_DOK_MASUK_OUT'],
																			'TGL_DOK_MASUK_OUT' 	=> $row['TGL_DOK_MASUK_OUT'],
																			'JENIS_DOK_MASUK_OUT' 	=> $row['JENIS_DOK_MASUK_OUT'],
																			'SATUAN_OUT' 			=> $row['SATUAN_OUT'],
																			'JUMLAH_OUT' 			=> $row['JUMLAH_OUT'],
																			);
				}				
				if($LOGID != NULL){
					$code = implode("','",$LOGID);
				}
				
				$WHERE_1 = "(A.LOGID IN ('".$code."'))";
							
				$GET_PEMASUKAN = $this->laporan_act->query_pemasukan($tglAwal,$tglAkhir,$TIPE_PERIODE,$ALL_SALDO,$WHERE_1,$FLAG);
				foreach($GET_PEMASUKAN as $row)
				{
					$DATA_HEADER_IN[$row['LOGID_IN']] = array(
																'LOGID_IN' 			=> $row['LOGID_IN'],
																'JENIS_DOK_IN'		=> $row['JENIS_DOK_IN'],
																'NO_DOK_IN'			=> $row['NO_DOK_IN'],
																'TGL_DOK_IN'		=> $row['TGL_DOK_IN'],
																'TGL_MASUK_IN'		=> $row['TGL_MASUK_IN'],
																'KODE_BARANG_IN'	=> $row['KODE_BARANG_IN'],
																'JNS_BARANG_IN'		=> $row['JNS_BARANG_IN'],
																'SERI_BARANG_IN'	=> $row['SERI_BARANG_IN'],
																'NAMA_BARANG_IN'	=> $row['NAMA_BARANG_IN'],
																'SATUAN_IN'			=> $row['SATUAN_IN'],
																'JUMLAH_IN'			=> $row['JUMLAH_IN'],
																'NILAI_PABEAN_IN'	=> $row['NILAI_PABEAN_IN'],
																'FLAG_TUTUP'		=> $row['FLAG_TUTUP'],
																'SALDO'				=> $row['SALDO']
															);
				}
				
				#KELOMPOKAN DATA
				$DATA_HEADER = array();
				foreach($DATA_HEADER_IN as $DATA_IN)
				{					
					$DATA_HEADER[$DATA_IN['LOGID_IN']] = array_merge($DATA_IN,$DATA_HEADER_OU[$DATA_IN['LOGID_IN']]);	
				}
				if($TIPE_PERIODE=='INOUT')
				{
					$DATA_HEADER_INOUT_OUT = $DATA_HEADER;
				}
			}
			
			if($TIPE_PERIODE=='INOUT')
			{
				foreach($DATA_HEADER_INOUT_IN as $DATAINOUT_IN)
				{				
					array_push($DATA_HEADER, array_merge((array)$DATAINOUT_IN,(array)$DATA_HEADER_INOUT_OUT[$DATAINOUT_IN['LOGID_IN']]));
				}
				$DATA_HEADER = array_filter($DATA_HEADER);
				$DATA_HEADER = array_unique($DATA_HEADER, SORT_REGULAR);
				
			}
			
			
			$data = array(
							"tipe"=>$tipe,
						  	"dataRec"=>$dataRec,
						  	"tglAwal"=>$tglAwal,
						  	"tglAkhir"=>$tglAkhir,
						  	"kodebarang"=>$kodebarang,
						  	"jenis"=>$jenis,
						  	"nama"=>$NAMATRADER,
						  	"TGLSTOCK"=>$TGLSTOCK,
						  	"TIPE_TANGGAL"=>$TIPE_TANGGAL,
						  	"resultData"=>$DATA_HEADER,
						  	"TIPE_PERIODE"=>$TIPE_PERIODE,
						  	"ALL"=>$ALL,
						  	"INDATA"=>$indata,
						  	"INARRAY"=>$INARRAY,
						  	"ALL_SALDO"=>$ALL_SALDO,
							"cetak"=>$cetak
						);
			if($cetak){
				$html = $this->load->view('laporan/laporan_v2', $data, true);
				$stylesheet = file_get_contents('assets/css/newtable.css');
				$this->load->library('mpdf');
				$this->mpdf=new mPDF('UTF-8','A4-L','','',8,8,35,25,10,13); 
				$this->mpdf->useOnlyCoreFonts = true;
				$this->mpdf->SetProtection(array('print'));
				$this->mpdf->SetAuthor("PLBINVENTORY");
				$this->mpdf->SetCreator("PLBINVENTORY");
				$this->mpdf->SetTitle($tittle);
				$this->mpdf->SetSubject($nama);
				$this->mpdf->list_indent_first_level = 0; 
				$this->mpdf->SetDisplayMode('fullpage');
				$page=$this->mpdf->AliasNbPages('[pagetotal]');
				$this->mpdf->SetHTMLHeader('<div align="justify">GUDANG BERIKAT '.strtoupper($nama).'<br />LAPORAN POSISI BARANG PER DOKUMEN PABEAN<br />PERIODE '.$this->fungsi->FormatDate($tglAwal).' S.D '.$this->fungsi->FormatDate($tglAkhir).'<br /></div><div align="right">Halaman {PAGENO} dari [pagetotal]</div>','0',true);
				$this->mpdf->WriteHTML($stylesheet,1);
				$this->mpdf->WriteHTML($html,2);
				if($cetak=="xls"){
					$per = "(".$this->fungsi->dateformat($tglAwal).'s.d'.$this->fungsi->dateformat($tglAkhir).")";
					$this->cetakexcell($tittle.$per,$html);
				}else{
					$this->mpdf->Output();
				}
				exit;
			}else{
				$this->load->view('laporan/laporan_v2', $data);
			}
		}
		elseif($tipe=="pemasukan" || $tipe=="pengeluaran" || $tipe=="mutasi" || $tipe=="pembelian" || $tipe=="penjualan"){
			$jns_dok 			= $this->input->post("JENIS_DOKUMEN");
			$showpage 			= $this->input->post("showpage");
			$JUMPAGES 			= $this->input->post("JUMPAGES");
        	$ALL 				= $this->input->post("ALL");
			$KONDISI_BARANG 	= $this->input->post("KONDISI_BARANG");
			if($tipe=="pemasukan" || $tipe=="pengeluaran" || $tipe=="pembelian" || $tipe=="penjualan"){
				$showpage = true;
			}
			
			$SQL = $this->laporan_act->daftar_laporan($tipe,$tglAwal,$tglAkhir,$jns_dok,$ALL,$KONDISI_BARANG);
			if ($SQL) {	
				if($ALL){
					$QUERY = $this->db->query(str_replace("|","",$SQL));	
					$rs = $QUERY->result_array();
					foreach($rs as $dt){
						$VALIN = $VALIN."'".$dt["KODE_BARANG"]."'," ;
						$INARRAY[] = $dt["KODE_BARANG"];
					}
					$indata = substr($VALIN,0,strlen($VALIN)-1);
					if(!$indata) $indata="''";
					$jndata = "(JNS_BARANG IN('1','2','3','4','5'))";
	
					$SQL .= " UNION SELECT KODE_BARANG | , JNS_BARANG, URAIAN_BARANG, 
							  IF(KODE_SATUAN_TERKECIL='' OR KODE_SATUAN_TERKECIL IS NULL,KODE_SATUAN,
                                KODE_SATUAN_TERKECIL) KODE_SATUAN,
							  '' PENYESUAIAN, KODE_TRADER |
							  FROM m_trader_barang WHERE kode_trader='".$kodeTrader."' AND ".$jndata." ";
					if($indata!=''){
						$SQL .= " AND KODE_BARANG NOT IN(".$indata.") ";	
					}									
				}
				if($showpage){
					$this->baris = $JUMPAGES;
					if(strpos(strtoupper($SQL),"UNION")==false){
						$SQL_EXP = explode("|",$SQL);
						$SQL_EXP_TMP = $SQL_EXP[0].' '.$SQL_EXP[2];
					}else{
						$EXP_UNION = explode("UNION",$SQL);
						foreach($EXP_UNION as $UNION){
							$SQL_EXP = explode("|",$UNION);
							$SQL_EXP_TMP .= $SQL_EXP[0].' '.$SQL_EXP[2].' UNION ';
						}						
						if(strpos(strtoupper($SQL_EXP_TMP),"ORDER")==false){
							$SQL_EXP_TMP = substr($SQL_EXP_TMP,0,-6);	
						}else{							
							$SQL_EXP_TMP = substr_replace($SQL_EXP_TMP,'',strpos(strtoupper($SQL_EXP_TMP),"ORDER"));						
						}
					} 
					
					$table_count = $this->db->query("SELECT COUNT(*) AS JML FROM ($SQL_EXP_TMP) AS TBL");
					if($table_count){
						$table_count = $table_count->row();
						$total_record = $table_count = $table_count->JML;
					}else{
						$total_record = 0;
					}
					$table_count = ceil($table_count / $this->baris);
					$hal = $this->input->post('hal');
					if($hal < 1) $hal = 1;
					if($hal > $table_count) $hal = $table_count;
					if($hal<=1){
						$dari = 0;
						$sampai = $this->baris;
					}else{
						$dari = ($hal - 1) * $this->baris;
						$sampai = $this->baris;
					}
					/*if($tipe=="pemasukan" || $tipe=="pengeluaran"){
						$SQL .= " ORDER BY 2,1,3";
					}*/
					$SQL .= " LIMIT $dari, $sampai";
					
					$datast = ($hal - 1);
					if($datast<1) $datast = 1;
					else $datast = $datast * $this->baris + 1;
					$dataen = $datast + $this->baris - 1;
					if($total_record < $dataen) $dataen = $total_record;
					if($total_record==0) $datast = 0;
					
					if($hal<=1)
						$no = 1;			
					else
						$no = ($hal - 1) * $this->baris + 1;
						
					$out .='<tr class="head">
								<th colspan="14">
								<input type="hidden" class="tb_text" id="tb_view" value="'.$this->baris.'" readonly/> 
								<span style="float:left">&nbsp;'.$this->baris.' Data Per Halaman. Menampilkan '.$datast.' - '.$dataen.' Dari '.number_format($total_record).' Data.</span>';
					
					if($total_record > $this->baris){ 
						$actions = site_url()."/laporan/daftar_dok/".$tipe;
						$prev = $hal-1;
						$next = $hal+1;
						$firsExec = "lap_pagging('".$actions."', 'divLapMutasi', '1', 'frmLaporan');";
						$prevExec = "lap_pagging('".$actions."', 'divLapMutasi', '".$prev."', 'frmLaporan');";
						$nextExec = "lap_pagging('".$actions."', 'divLapMutasi', '".$next."', 'frmLaporan');";
						$lastExec = "lap_pagging('".$actions."', 'divLapMutasi', '".$total_record."', 'frmLaporan');";
						$forgo = "lap_pagging('".$actions."', 'divLapMutasi', document.getElementById('tb_halfrmLaporan').value, 'frmLaporan');";
						$out .="<span>";
						if ($hal != "1"){
							$out .="<a href=\"javascript:void(0)\" onclick=\"".$firsExec."\" title=\"First\" class=\"paging\">&laquo;</a>&nbsp;";
							$out .="<a href=\"javascript:void(0)\" onclick=\"".$prevExec."\" title=\"Prev\" class=\"paging\">&lsaquo;&nbsp;</a>&nbsp;";
						}else{
							$out .="<font class=\"pdisabled\">&laquo;</font>&nbsp;";
							$out .="<font class=\"pdisabled\">&lsaquo;&nbsp;</font>&nbsp;";
						}
						
						$out .="Halaman <input type=\"text\" class=\"tb_text\" name=\"tb_halfrmLaporan\" id=\"tb_halfrmLaporan\" title=\"Masukkan nomor halaman yang diinginkan kemudian tekan Go\" value=\"".$hal."\" ".$disabled." style=\"width:30px;text-align:right;\"/>"; 
						
						$out .="&nbsp;<input type=\"button\" style=\"margin-top:-3px;\" class=\"btn btn-sm btn-primary\" OnClick=\"".$forgo."\" value=\"Go\">";
						$out .=" Dari ".$table_count;
						
						if ($hal != ($table_count)){
							$out .="<a href=\"javascript:void(0)\" onclick=\"".$nextExec."\" title=\"Next\" class=\"paging\">&nbsp;&rsaquo;</a>&nbsp;";
							$out .="<a href=\"javascript:void(0)\" onclick=\"".$lastExec."\" title=\"Last\" class=\"paging\">&raquo;</a>&nbsp;";	
						}else{
							$out .="<font class=\"pdisabled\">&nbsp;&rsaquo;</font>&nbsp;";
							$out .="<font class=\"pdisabled\">&raquo;</font>&nbsp;";
						}
						$out .="</span>";
					}else{
						$out .="<input type=\"hidden\" class=\"tb_text\" id=\"tb_halfrmLaporan\" value=\"".$hal."\" ".$disabled."  ondblclick=\"".$nextExec."\" style=\"width:30px;text-align:right;\"/>"; 	
					}
						
					$out .='</th></tr>';
				}else{
					$no = 1;	
				}
				$rs = $this->db->query(str_replace("|","",$SQL));	
				$resultRow = $rs->result_array();
			}
			if ($tipe == 'mutasi') {
                $tabel = 'r_trader_mutasi';
                $arrayKey = array('TANGGAL_AWAL' => $tglAwal, 'TANGGAL_AKHIR' => $tglAkhir, 'KODE_TRADER' => $kodeTrader);
                $this->db->where($arrayKey);
                $this->db->from($tabel);
                $dataRec = $this->db->count_all_results();
            }
			$data = array(
							"dokumen"		=> $this->input->post("JENIS_DOKUMEN"),
							"tipe" 			=> $tipe,
							"dataRec" 		=> $dataRec,
							"tglAwal" 		=> $tglAwal,
							"tglAkhir" 		=> $tglAkhir,
							"kodebarang" 	=> $kodebarang,
							"jenisdokumen" 	=> $this->input->post("TIPE_PERIODE"),
							"resultData" 	=> $resultRow,
							"ALL" 			=> $ALL,
							"nama"			=> $NAMATRADER,
							"INDATA" 		=> $indata,
							"INARRAY" 		=> $INARRAY,
							"PAGING_TOP"	=> $out,
							"PAGING_BOT"	=> $out,
							"no"			=> $no,
							"showpage"		=> $showpage,
							"halaman"		=> $hal,
							"JUMPAGES"		=> $JUMPAGES
						);#print_r($data);die();
			$this->load->view('laporan/laporan', $data); 
		}
	}
	
	function print_dok($tipe="",$tglAwal="",$tglAkhir="",$nama="",$jenisdokumen="",$dok="",$showpage="",$halaman="",$JUMPAGES="",$cetak="") {
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		ini_set('memory_limit','-1');
		set_time_limit(0);
		if($tipe=='pemasukan'){
			$showpage = true;
			$tittle="Laporan Pemasukan";
		}elseif($tipe=='pengeluaran'){
			$showpage = true;
			$tittle="Laporan Pengeluaran";
		}elseif($tipe=='mutasi'){
			$tittle="Laporan Pertanggungjawaban Mutasi Barang";
		}elseif($tipe=="pembelian"){
			$tittle="Laporan Pembelian";
		}elseif($tipe=="penjualan"){
			$tittle="Laporan Penjualan";
		}
		$kodeTrader = $this->newsession->userdata('KODE_TRADER');
		$this->load->model("laporan_act");
        #GET DATA
        $SQLTEMP = $this->laporan_act->daftar_laporan($tipe, $tglAwal, $tglAkhir, $nama, $jenisdokumen, $dok);
		if($SQLTEMP){
			if($showpage){
				$this->baris = $JUMPAGES;
				if(strpos(strtoupper($SQLTEMP),"UNION")==false){
					$SQL_EXP = explode("|",$SQLTEMP);
					$SQL_EXP_TMP = $SQL_EXP[0].' '.$SQL_EXP[2];
				}else{
					$EXP_UNION = explode("UNION",$SQLTEMP);
					foreach($EXP_UNION as $UNION){
						$SQL_EXP = explode("|",$UNION);
						$SQL_EXP_TMP .= $SQL_EXP[0].' '.$SQL_EXP[2].' UNION ';
					}						
					if(strpos(strtoupper($SQL_EXP_TMP),"ORDER")==false){
						$SQL_EXP_TMP = substr($SQL_EXP_TMP,0,-6);	
					}else{							
						$SQL_EXP_TMP = substr_replace($SQL_EXP_TMP,'',strpos(strtoupper($SQL_EXP_TMP),"ORDER"));						
					}
				} 
				$table_count = $this->db->query("SELECT COUNT(*) AS JML FROM ($SQL_EXP_TMP) AS TBL");
				if($table_count){
					$table_count = $table_count->row(); 
					$total_record = $table_count = $table_count->JML;
				}else{
					$total_record = 0;
				}
				$table_count = ceil($table_count / $this->baris);
				$hal = $halaman;
				if($hal < 1) $hal = 1;
				if($hal > $table_count) $hal = $table_count;
				if($hal<=1){
					$dari = 0;
					$sampai = $this->baris;
				}else{
					$dari = ($hal - 1) * $this->baris;
					$sampai = $this->baris;
				}
				$SQLTEMP .= " LIMIT $dari, $sampai";
				
				$datast = ($hal - 1);
				if($datast<1) $datast = 1;
				else $datast = $datast * $this->baris + 1;
				$dataen = $datast + $this->baris - 1;
				if($total_record < $dataen) $dataen = $total_record;
				if($total_record==0) $datast = 0;
				
				if($hal<=1)
					$no = 1;			
				else
					$no = ($hal - 1) * $this->baris + 1;														
			}else{
				$no = 1;	
			}
			#=================================================================================			
			
            $QUERYTEMP = $this->db->query(str_replace("|","",$SQLTEMP));
            $resultRow = $QUERYTEMP->result_array();
        }
        $page = "";
		
		#GET DATA TANGGAL STOCK
		$TGLSTOCK = $this->laporan_act->getTglStock($tglAwal,$tglAkhir);
		#LOAD LIBRARY MPDF
		$this->load->library('mpdf');
		$this->mpdf=new mPDF('UTF-8','A4-L','','',8,8,35,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->SetAuthor("GBINVENTORY");
		$this->mpdf->SetCreator("GBINVENTORY");
		$this->mpdf->SetTitle($tittle);
		$this->mpdf->SetSubject($nama);
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$data = array(
						"tipe"			=>$tipe,
					  	"tglAwal"		=>$tglAwal,
					  	"tglAkhir"		=>$tglAkhir,
					  	"nama"			=>$nama,
					  	"TGLSTOCK"		=>$TGLSTOCK,
					  	"page"			=>$page,
				  	  	"resultData"	=>$resultRow,
					  	"ALL"			=>$ALL,
					  	"INDATA"		=>$indata,
					  	"INARRAY"		=>$INARRAY,
					  	"TIPE_PERIODE"	=>$TIPE_PERIODE,
					  	"xls"			=>$cetak,
					  	"title"			=>$tittle,
						"no"			=>$no,
						"dok"			=>$dok
					);
		$html=$this->load->view("laporan/print", $data,true);
		$stylesheet = file_get_contents('assets/css/newtable.css');
		if ($tipe == 'pemasukan' || $tipe == 'pengeluaran') {
                $this->mpdf->SetHTMLHeader('<div align="justify" style="margin-bottom:5px;">
				PUSAT LOGISTIK BERIKAT ' . $nama . '<br />
				LAPORAN ' . strtoupper($tipe) . ' BARANG PER DOKUMEN PABEAN<br />
				PERIODE ' . $this->fungsi->FormatDate($tglAwal) . ' S.D ' . $this->fungsi->FormatDate($tglAkhir) . '<br /></div>
				<div align="right">Halaman {PAGENO} dari [pagetotal]</div>'
                        , '0', true);
      	}elseif($tipe=='mutasi'){
			$this->mpdf->SetHTMLHeader(
			'<div align="justify">
			GUDANG BERIKAT '.strtoupper($nama).'<br />
			LAPORAN PERTANGGUNGJAWABAN MUTASI BARANG<br />
			PERIODE '.strtoupper($this->fungsi->FormatDateIndo($tglAwal)).' S.D '.strtoupper($this->fungsi->FormatDateIndo($tglAkhir)).'<br />
			</div>
			<div align="right">Halaman {PAGENO} dari [pagetotal]</div>'
			,'0',true);
		}elseif ($tipe == 'pembelian') {
                $this->mpdf->SetHTMLHeader('<div align="justify" style="margin-bottom:5px;">
				PUSAT LOGISTIK BERIKAT ' . $nama . '<br />
				LAPORAN ' . strtoupper($tipe) . '<br />
				PERIODE ' . $this->fungsi->FormatDate($tglAwal) . ' S.D ' . $this->fungsi->FormatDate($tglAkhir) . '<br /></div>
				<div align="right">Halaman {PAGENO} dari [pagetotal]</div>', '0', true);
      	}elseif ($tipe == 'penjualan') {
                $this->mpdf->SetHTMLHeader('<div align="justify" style="margin-bottom:5px;">
				PUSAT LOGISTIK BERIKAT ' . $nama . '<br />
				LAPORAN ' . strtoupper($tipe) . '<br />
				PERIODE ' . $this->fungsi->FormatDate($tglAwal) . ' S.D ' . $this->fungsi->FormatDate($tglAkhir) . '<br /></div>
				<div align="right">Halaman {PAGENO} dari [pagetotal]</div>', '0', true);
      	}
		
		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		if($cetak=="xls"){
			$per = "(".$this->fungsi->dateformat($tglAwal).'s.d'.$this->fungsi->dateformat($tglAkhir).")";
			$this->cetakexcell($tittle.$per,$html);
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
		//$html .= '<style> td{mso-number-format:"\@";}</style>';
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
	
	function set_laporan($tipe = "") {
        $this->load->model("laporan_act");
        $this->laporan_act->set_laporan($tipe);
    }
	
	function list_laporan($tipe = "", $act = "") {
        $this->load->model("laporan_act");
        echo $this->laporan_act->list_laporan($tipe, $act);
    }
}
?>