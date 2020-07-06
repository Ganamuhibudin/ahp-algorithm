<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Realisasi extends CI_Controller
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
	
	#=========================================== REALISASI IN =====================================================
	function in($tipe="",$dok="",$aju=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["ui"] = 1;
		if(in_array($tipe,array("save","update","delete"))){
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
				$this->set_realisasi_in($tipe,$dok,$aju);
			}else{
				redirect(site_url()."/realisasi/in");
			}
		}else{			
			$this->load->model("realisasiin_act");
			$arrdata = $this->realisasiin_act->in($dok,$aju);
			$data = $this->load->view('box-pabean', $arrdata, true);
			if($this->input->post("ajax")){
				echo  $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function daftar_dok($tipe,$jenis,$dok){
		$this->load->model($tipe);
		$arrdata = $this->$tipe->$jenis($dok);
		echo $this->load->view('dok', $arrdata, true);
	}
	
	function set_realisasi_in($act="",$dok="",$aju=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("main");
		$data = array("act"=>$act, "PARSIAL"=>$this->input->post("PARSIAL"), "BREAK"=>$this->input->post("BREAK"));
		if($act=="update"){			
			$this->load->model("realisasiin_act");
			$get = $this->realisasiin_act->get_realisasi();
			$data = array_merge(array("DATA"=>$get),$data);
		}
		$this->content = $this->load->view('realisasi/Realisasi_in', $data, true);	
		$this->index($dok);			
	}
	
	function detil_in($tipe="",$data=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->model("realisasiin_act");
		echo $this->realisasiin_act->detil_in($tipe,$data);	
	}

	function detil_out($tipe="",$data=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->model("realisasiout_act");
		echo $this->realisasiout_act->detil_out($tipe,$data);	
	}
	
	function getBarangIn() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiin_act");
			$data = $this->realisasiin_act->getBarang();
			echo $data;
		} else {
			echo "<center><b>Data tidak ditemukan.<b></center>";
		}
	}
	
	function getGudang(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiin_act");
			$data = $this->realisasiin_act->getGudang();
			echo $data;
		} else {
			redirect(base_url());
		}
	}
	
	function getKondisiIn() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiin_act");
			$data = $this->realisasiin_act->getKondisi();
			echo $data;
		} else {
			redirect(base_url());
		}
	}
	
	function getRakIn() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiin_act");
			$data = $this->realisasiin_act->getRak();
			echo $data;
		} else {
			redirect(base_url());
		}
	}
	
	function getSubRakIn() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiin_act");
			$data = $this->realisasiin_act->getSubRak();
			echo $data;
		} else {
			redirect(base_url());
		}
	}
	
	function breakdown_proses($tipe="",$AJU="",$SERI="",$JUMLAH="",$dok=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($dok=="in")){
			if(strtoupper($tipe)=="BC281") $JNS = ", f_ref('ASAL_JENIS_BARANG',JENIS_BARANG) 'JNSBARANG'";
			else $JNS = ", f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JNSBARANG'";
			$SQL = "SELECT * ".$JNS." FROM T_".$tipe."_DTL WHERE NOMOR_AJU='".$AJU."' AND SERI='".$SERI."'";	
			$VAL=$this->db->query($SQL);	
			$ROW=$VAL->result_array();	
			$this->load->model("realisasiin_act");
			$DETILBARANG = $this->realisasiin_act->breakdownDtlBarang($AJU,$SERI,$JUMLAH,$tipe);
			$arraydata = array("DOKUMEN"=>$tipe,"AJU"=>$AJU,"SERI"=>$SERI,"ROW"=>$ROW[0],"DETILBARANG"=>$DETILBARANG,"JUMLAH"=>$JUMLAH);
			echo $this->load->view('realisasi/Breakdown_proses_in', $arraydata, true);
		} elseif ($dok == "out") {
			if(strtoupper($tipe)=="BC281"){
				$JNS = ", f_ref('ASAL_JENIS_BARANG',JENIS_BARANG) 'JNSBARANG'";
			} else {
				$JNS = ", f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JNSBARANG'";
			}
			$SQL = "SELECT * ".$JNS." FROM T_".$tipe."_DTL WHERE NOMOR_AJU='".$AJU."' AND SERI='".$SERI."'";	
			$VAL = $this->db->query($SQL);	
			$ROW = $VAL->result_array();	
			$this->load->model("realisasiout_act");
			$DETILBARANG = $this->realisasiout_act->breakdownDtlBarang($AJU, $SERI, $JUMLAH, $tipe);
			$arraydata = array("DOKUMEN" => $tipe, 
								"AJU" => $AJU,
								"SERI" => $SERI,
								"ROW" => $ROW[0],
								"DETILBARANG" => $DETILBARANG,
								"JUMLAH" => $JUMLAH);
			echo $this->load->view('realisasi/Breakdown_proses_in', $arraydata, true);
		}
	}
	
	function page_break($AJU="",$SERI="",$JUMLAH="",$DOKUMEN="",$dok=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($dok=="in")){
			$this->load->model("realisasiin_act");
			$arrdata = $this->realisasiin_act->breakdownDtlBarang($AJU,$SERI,$JUMLAH,$DOKUMEN);
			if($this->input->post("ajax")){
				echo  $arrdata;
			}
		}
	}

	function breakdownin_prosesForm($ACT="",$AJU="",$SERI="",$JMLHEAD="",$JMLDTL="",$DOKUMEN="",$HARGA="",$KEY=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$func = get_instance();
		$func->load->model("main");	
		$KODETRADER=$this->newsession->userdata('KODE_TRADER');
		$KEY = explode("|",$KEY); $KODE_BARANG=$KEY[0]; $JNS_BARANG=$KEY[1];
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){		
			if(strtolower($ACT)=="save"){
				if($DOKUMEN=="bc40") $CIF = " HARGA_PENYERAHAN AS CIF";
				elseif($DOKUMEN=="bc30") $CIF = " FOB_PER_BARANG AS CIF";
				elseif($DOKUMEN=="bc16") $CIF = " CIF_RP AS CIF";
				else $CIF = " CIF";
				$HARGA_BARANG = $func->main->get_uraian("SELECT ".$CIF." FROM t_".$DOKUMEN."_dtl WHERE KODE_TRADER = '".$KODETRADER."' AND NOMOR_AJU = '".$AJU."' AND SERI = ".$SERI,"CIF");
				$arr = array("ACT"=>$ACT,"AJU"=>$AJU,"SERI"=>$SERI,"JMLHEAD"=>$JMLHEAD,"JMLDTL"=>$JMLDTL,"DOKUMEN"=>$DOKUMEN,"CIF"=>$HARGA,"CIF_HEAD"=>$HARGA_BARANG);
			}else{
				$SQL = "SELECT A.HDRID, A.NOMOR_AJU, A.SERI, A.KODE_BARANG, A.JNS_BARANG, A.KODE_SATUAN,A.JUMLAH, A.HARGA_SATUAN,
						f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS BARANG',f_barang(A.KODE_BARANG,A.JNS_BARANG,'".$KODETRADER."') URAIAN,
						B.KODE_GUDANG, B.KONDISI_BARANG, B.JUMLAH AS JUMGUDANG, B.KODE_RAK, B.KODE_SUB_RAK
						FROM t_breakdown_pemasukan A LEFT JOIN t_breakdown_gudang B ON B.HDRID = A.HDRID AND B.NOMOR_AJU = A.NOMOR_AJU
						AND B.KODE_TRADER = A.KODE_TRADER AND B.KODE_BARANG = A.KODE_BARANG AND B.JNS_BARANG = A.JNS_BARANG AND 
						B.SERI = A.SERI
						WHERE A.NOMOR_AJU='".$AJU."' AND A.SERI='".$SERI."'
						AND A.KODE_BARANG='".$KODE_BARANG."' AND A.JNS_BARANG='".$JNS_BARANG."'
						AND A.KODE_TRADER = '".$KODETRADER."'";
				$hasil = $func->main->get_result($SQL);								
				if($hasil){
					$html .= '<tr id="table-data" >';
					$html .= '<td id="data-gudang" colspan="2">';
					$html .= '<table id="tbl-break" class="tabelajax">';
					$html .= '<tbody>';
					$html .= '<tr class="thead">';
					$html .= '<th>Jumlah</th>';
					$html .= '<th>Gudang Tujuan</th>';
					$html .= '<th>Kondisi Barang</th>';
					$html .= '<th>Action</th>';
					$no = 1;
					foreach($SQL->result_array() as $row){
						$data = array('sess'=>$row);
						if($no==1) $class = 'class="parent"';
						else $class = 'class="child"';
						$SQL = "SELECT KODE_GUDANG, f_gudang(KODE_GUDANG,KODE_TRADER) AS NAMA_GUDANG, KODE_RAK, KODE_SUB_RAK
								FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODETRADER."' 
								AND KODE_BARANG = '".$row["KODE_BARANG"]."' AND JNS_BARANG = '".$row["JNS_BARANG"]."'";
						$GUDANG = $func->main->get_combobox($SQL,"KODE_GUDANG","NAMA_GUDANG",FALSE);
						$RAK = $func->main->get_combobox($SQL,"KODE_RAK","KODE_RAK",FALSE);
						$SUBRAK = $func->main->get_combobox($SQL,"KODE_SUB_RAK","KODE_SUB_RAK",FALSE);
						$html .= '<tr id="tr-break-'.$no.'" '.$class.'>';
						$html .= '<td id="td-jumlah-break-'.$no.'"><input type="text" onkeypress="return intInput(event, /[.0-9]/)" wajib="yes" style="text-align:right; height:27px;" class="stext date" id="JUMLAH-'.$no.'" value="'.$row["JUMGUDANG"].'" name="DATABREAK[JUMLAH][]"></td>';
						$html .= '<td id="td-gudang-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KODE_GUDANG][]', $GUDANG, $row["KODE_GUDANG"], 'id="gudang-break-'.$no.'" class="text select" wajib="yes" onchange="getKondisiBreak(this.value,'.$no.')"').'</combo></td>';
						$html .= '<td id="td-kondisi-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KONDISI_BARANG][]',array("BAIK"=>"BAIK","RUSAK"=>"RUSAK"),$row["KONDISI_BARANG"],'id="kondisi-break-'.$no.'" class="stext select" wajib="yes" onchange="getRakBreak('.$no.')"').'</combo></td>';
						$html .= '<td id="td-rak-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KODE_RAK][]',$RAK,$row["KODE_RAK"],'id="rak-break-'.$no.'" class="stext select" wajib="yes" onchange="getSubRakBreak('.$no.')"').'</combo></td>';
						$html .= '<td id="td-subrak-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KODE_SUB_RAK][]',$SUBRAK,$row["KODE_SUB_RAK"],'id="rak-subbreak-'.$no.'" class="stext select" wajib="yes"').'</combo></td>';
						if(count($GUDANG)>1){
							if($no==1){
								$html .= '<td id="td-button-break-'.$no.'"><a id="button-add-'.$no.'" class="btn btn-success btn-sm" title="Tambah Gudang" onclick="addgudang_break(\''.count($GUDANG).'\')" href="javascript:void(0)">&nbsp;<i class="icon-plus"></i></a></td>';
							}else{
								$html .= '<td id="td-button-break-'.$no.'"><a id="button-add-'.$no.'" class="btn btn-danger btn-sm" title="Hapus Gudang" onclick="RemovegudangBreak('.$no.')" href="javascript:void(0)">&nbsp;<i class="icon-minus"></i></a></td>';
							}
						}else{
							$html .= '<td id="td-button-break-'.$no.'">&nbsp;</td>';
						}
						$html .= '</tr>';
						$no++;
					}
					$html .= '</tr>';
					$html .= '</tbody>';
					$html .= '<table>';
					$html .= '</td>';
					$html .= '</tr>';
				}
				$arr = array_merge($data,array("ACT"=>$ACT,"AJU"=>$AJU,"SERI"=>$SERI,"JMLHEAD"=>$JMLHEAD,"JMLDTL"=>$JMLDTL,
							 			       "KDBARANG_EDIT"=>$KODE_BARANG,"JNSBARANG_EDIT"=>$JNS_BARANG,"DOKUMEN"=>$DOKUMEN,
											   "DATADTL"=>$html));	
			}
			echo $this->load->view('realisasi/Breakdown_prosesForm_in', $arr, true);
		}else{
			$this->load->model("realisasiin_act");
			$this->realisasiin_act->set_breakdown($this->input->post("act"),$ACT);
		}
	}

	function breakdownout_prosesForm($ACT = "",$AJU = "", $SERI = "", $JMLHEAD = "", $JMLDTL = "", $DOKUMEN = "", $KEY = ""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$func = get_instance();
		$func->load->model("main");	
		$KODETRADER = $this->newsession->userdata('KODE_TRADER');
		$KEY = explode("|",$KEY);
		$KODE_BARANG = $KEY[0];
		$JNS_BARANG = $KEY[1];
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post"){
			if(strtolower($ACT) == "save") {
				if($DOKUMEN == "bc40") {
					$CIF = " HARGA_PENYERAHAN AS CIF";
				} elseif($DOKUMEN == "bc30") {
					$CIF = " FOB_PER_BARANG AS CIF";
				} else {
					$CIF = " CIF";
				}
				$HARGA_BARANG = $func->main->get_uraian("SELECT ".$CIF." FROM t_".$DOKUMEN."_dtl WHERE KODE_TRADER = '".$KODETRADER."' AND NOMOR_AJU = '".$AJU."' AND SERI = ".$SERI,"CIF");
				$arr = array("ACT" => $ACT,
							"AJU" => $AJU,
							"SERI" => $SERI,
							"JMLHEAD" => $JMLHEAD,
							"JMLDTL" => $JMLDTL,
							"DOKUMEN" => $DOKUMEN,
							"CIF" => $HARGA,
							"CIF_HEAD" => $HARGA_BARANG);
			} else {
				$SQL = "SELECT A.ID, A.NOMOR_AJU, A.SERI, A.KODE_BARANG, A.JNS_BARANG, A.KODE_SATUAN,A.JUMLAH,
						f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS BARANG',
						f_barang(A.KODE_BARANG,A.JNS_BARANG,'".$KODETRADER."') URAIAN,
						B.KODE_GUDANG, B.KONDISI_BARANG, B.JUMLAH AS JUMGUDANG, B.KODE_RAK, B.KODE_SUB_RAK
						FROM t_breakdown_pengeluaran A 
						LEFT JOIN t_breakdown_gudang_out B ON B.HDRID = A.ID 
						AND B.NOMOR_AJU = A.NOMOR_AJU
						AND B.KODE_TRADER = A.KODE_TRADER 
						AND B.KODE_BARANG = A.KODE_BARANG 
						AND B.JNS_BARANG = A.JNS_BARANG 
						AND B.SERI = A.SERI
						WHERE A.NOMOR_AJU='".$AJU."' AND A.SERI='".$SERI."'
						AND A.KODE_BARANG='".$KODE_BARANG."' AND A.JNS_BARANG='".$JNS_BARANG."'
						AND A.KODE_TRADER = '".$KODETRADER."'";
				$hasil = $func->main->get_result($SQL);								
				if($hasil) {
					$html .= '<tr id="table-data" >';
					$html .= '<td id="data-gudang" colspan="2">';
					$html .= '<h5 class="smaller lighter green"><strong>Data Gudang</strong></h5>';
					$html .= '<table id="tbl-break" class="tabelajax">';
					$html .= '<tbody>';
					$html .= '<tr class="thead">';
					$html .= '<th>Jumlah</th>';
					$html .= '<th>Gudang Tujuan</th>';
					$html .= '<th>Kondisi Barang</th>';
					$html .= '<th>Rak</th>';
					$html .= '<th>Sub Rak</th>';
					// $html .= '<th>Action</th>';
					$no = 1;
					foreach($SQL->result_array() as $row){
						$data = array('sess'=>$row);
						if($no==1) $class = 'class="parent"';
						else $class = 'class="child"';
						$SQL = "SELECT KODE_GUDANG, f_gudang(KODE_GUDANG,KODE_TRADER) AS NAMA_GUDANG, KODE_RAK, KODE_SUB_RAK
								FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODETRADER."' 
								AND KODE_BARANG = '".$row["KODE_BARANG"]."' AND JNS_BARANG = '".$row["JNS_BARANG"]."'";
						$GUDANG = $func->main->get_combobox($SQL,"KODE_GUDANG","NAMA_GUDANG",FALSE);
						$RAK = $func->main->get_combobox($SQL,"KODE_RAK","KODE_RAK",FALSE);
						$SUBRAK = $func->main->get_combobox($SQL,"KODE_SUB_RAK","KODE_SUB_RAK",FALSE);
						$html .= '<tr id="tr-break-'.$no.'" '.$class.'>';
						$html .= '<td id="td-jumlah-break-'.$no.'"><input type="text" onkeypress="return intInput(event, /[.0-9]/)" wajib="yes" style="text-align:right; height:27px;" class="stext date" id="JUMLAH-'.$no.'" value="'.$row["JUMGUDANG"].'" name="DATABREAK[JUMLAH][]"></td>';
						$html .= '<td id="td-gudang-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KODE_GUDANG][]', $GUDANG, $row["KODE_GUDANG"], 'id="gudang-break-'.$no.'" class="text select" wajib="yes" onchange="getKondisiBreak(this.value,'.$no.')"').'</combo></td>';
						$html .= '<td id="td-kondisi-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KONDISI_BARANG][]',array("BAIK"=>"BAIK","RUSAK"=>"RUSAK"),$row["KONDISI_BARANG"],'id="kondisi-break-'.$no.'" class="stext select" wajib="yes" onchange="getRakBreak('.$no.')"').'</combo></td>';
						$html .= '<td id="td-rak-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KODE_RAK][]',$RAK,$row["KODE_RAK"],'id="rak-break-'.$no.'" class="stext select" wajib="yes" onchange="getSubRakBreak('.$no.')"').'</combo></td>';
						$html .= '<td id="td-subrak-break-'.$no.'"><combo>'.form_dropdown('DATABREAK[KODE_SUB_RAK][]',$SUBRAK,$row["KODE_SUB_RAK"],'id="rak-subbreak-'.$no.'" class="stext select" wajib="yes"').'</combo></td>';
						if(count($GUDANG)>1){
							if($no==1){
								//$html .= '<td id="td-button-break-'.$no.'"><a id="button-add-'.$no.'" class="btn btn-success btn-sm" title="Tambah Gudang" onclick="addgudang_break(\''.count($GUDANG).'\')" href="javascript:void(0)">&nbsp;<i class="icon-plus"></i></a></td>';
							}else{
								//$html .= '<td id="td-button-break-'.$no.'"><a id="button-add-'.$no.'" class="btn btn-danger btn-sm" title="Hapus Gudang" onclick="RemovegudangBreak('.$no.')" href="javascript:void(0)">&nbsp;<i class="icon-minus"></i></a></td>';
							}
						}else{
							$html .= '<td id="td-button-break-'.$no.'">&nbsp;</td>';
						}
						$html .= '</tr>';
						$no++;
					}
					$html .= '</tr>';
					$html .= '</tbody>';
					$html .= '<table>';
					$html .= '</td>';
					$html .= '</tr>';
				}
				#get data dokumen pemasukan breakdown pengeluaran
				$sql = "SELECT a.ID, a.BREAKDOWNID, a.LOGID, a.NO_DAFTAR, a.TGL_DAFTAR, a.JUMLAH, a.SATUAN, a.DOKUMEN, a.SERI_BARANG
						FROM t_breakdown_pengeluaran_dok a
						LEFT JOIN t_breakdown_pengeluaran b ON b.ID = a.BREAKDOWNID
						AND b.KODE_TRADER = a.KODE_TRADER
						WHERE b.NOMOR_AJU = '" . $AJU . "' AND b.SERI = '" . $SERI . "'
						AND b.KODE_BARANG = '" . $KODE_BARANG . "' AND b.JNS_BARANG = '" . $JNS_BARANG . "'
						AND b.KODE_TRADER = '" . $KODETRADER . "'";
				$objSql = $this->db->query($sql);
				if ($objSql->num_rows() > 0) {
					$addHtml = '<tr id="table-dokin" >';
					$addHtml .= '<td id="data-dokin" width="1000px">';
					$addHtml .= '<h5 class="smaller lighter green"><strong>Data Dokumen Pemasukan</strong></h5>';
					$addHtml .= '<table id="tbl-dokin" class="tabelajax">';
					$addHtml .= '<tbody>';
					$addHtml .= '<tr class="thead">';
					$addHtml .= '<th>Nomor Dokumen</th>';
					$addHtml .= '<th>Tgl Dokumen</th>';
					$addHtml .= '<th width="12%">Jumlah</th>';
					$addHtml .= '<th width="15%">Satuan</th>';
					$addHtml .= '<th width="15%">Dokumen</th>';
					$addHtml .= '</tr>';
					foreach ($objSql->result_array() as $row) {
						$addHtml .= '<tr class="parent">';
						$addHtml .= '<td><span>' . $row['NO_DAFTAR'] . '</span></td>';
						$addHtml .= '<td><span>' . $row['TGL_DAFTAR'] . '</span></td>';
						$addHtml .= '<td><input type="text" name="DOKIN[JUMLAH][]" wajib="yes" class="stext date" onkeypress="return intInput(event, /[.0-9]/)" value="' . $row['JUMLAH'] . '" ></td>';
						$addHtml .= '<td><span>' . $row['SATUAN'] . '</span></td>';
						$addHtml .= '<td><span>' . $row['DOKUMEN'] . '</span></td>';
						$addHtml .= '</tr>';
					}
					$addHtml .= '</tbody>';
					$addHtml .= '<table>';
					$addHtml .= '</td>';
					$addHtml .= '</tr>';
				}
				$arr = array_merge($data,array("ACT" => $ACT, "AJU" => $AJU, "SERI" => $SERI, "JMLHEAD" => $JMLHEAD,
												"JMLDTL" => $JMLDTL, "KDBARANG_EDIT" => $KODE_BARANG, "JNSBARANG_EDIT" => $JNS_BARANG,
												"DOKUMEN" => $DOKUMEN, "DATADTL" => $html, "DATADOKUMEN" => $addHtml));	
			}
			echo $this->load->view('realisasi/Breakdown_prosesForm_out', $arr, true);				
		}else{
			$this->load->model("realisasiout_act");
			$this->realisasiout_act->set_breakdown($this->input->post("act"), $ACT);
		}
	}
	
	function show_detilbarang($AJU="",$SERI="",$JMLHEAD="",$DOKUMEN="",$DEL=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->model("realisasiin_act");
		echo $this->realisasiin_act->breakdownDtlBarang($AJU,$SERI,$JMLHEAD,$DOKUMEN,$DEL);		
	}
	
	function show_detilbarang_out($AJU = "", $SERI = "", $JMLHEAD = "", $DOKUMEN = "", $DEL = "") {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$this->load->model("realisasiout_act");
		echo $this->realisasiout_act->breakdownDtlBarang($AJU, $SERI, $JMLHEAD, $DOKUMEN, $DEL);
	}
	
	function breakdown_proses_detil_in($KEY=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("realisasiin_act");	
		$this->realisasiin_act->breakdown_proses_detil($KEY);
	}

	function breakdown_proses_detil_out($KEY=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("realisasiout_act");	
		$this->realisasiout_act->breakdown_proses_detil($KEY);
	}
	
	function parsialin($tipe="",$aju="",$parsial="",$break="",$seri=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			$JNS = ", f_ref('ASAL_JENIS_BARANG',B.JNS_BARANG) 'JNSBARANG',B.JNS_BARANG JBRG";
			$JENIS = "B.JNS_BARANG";
			
			if(strtoupper($tipe)=="BC16"){								
				$NILAI_BARANG = ",B.CIF_RP AS NILAI_BARANG";
			}
			elseif(strtoupper($tipe)=="BC30"){							
				$NILAI_BARANG = ",B.FOB_PER_BARANG AS NILAI_BARANG";	
			}
			elseif(strtoupper($tipe)=="BC27" || strtoupper($tipe)=="BC40"){				
				$NILAI_BARANG = ",B.HARGA_PENYERAHAN AS NILAI_BARANG";	
			}
			else{				
				$NILAI_BARANG = ",B.CIF AS NILAI_BARANG";	
			}
									
			$SQL = "SELECT B.*, A.NOMOR_AJU, A.NOMOR_PENDAFTARAN, A.TANGGAL_PENDAFTARAN 
					".$JNS.", B.KODE_SATUAN, IFNULL(f_jum_inout('".$aju."','".$tipe."','".$KODE_TRADER."',B.KODE_BARANG,".$JENIS.",
					B.KODE_SATUAN, B.SERI),0) AS JUMLAH_INOUT ".$NILAI_BARANG.",".$JENIS." AS JNS_BARANG, 
					IFNULL(f_jum_inout_nilaibrg('MASUK',A.NOMOR_PENDAFTARAN, A.TANGGAL_PENDAFTARAN,'".$tipe."','".$KODE_TRADER."',
					B.KODE_BARANG,".$JENIS.",B.SERI),0) AS NILAIBRG_INOUT
					FROM T_".$tipe."_HDR A, T_".$tipe."_DTL B
					WHERE A.KODE_TRADER = B.KODE_TRADER AND A.NOMOR_AJU=B.NOMOR_AJU AND A.NOMOR_AJU='".$aju."' 
					AND A.KODE_TRADER='".$KODE_TRADER."' AND B.SERI = '".$seri."'";
			$rs = $this->db->query($SQL);
			$row = "";		
			if($rs->num_rows()>0){
				$this->load->model("main");
				$row = $rs->result_array();
				$data = $rs->row();
				$KODE_BARANG = $data->KODE_BARANG;
				$JNS_BARANG = $data->JNS_BARANG;
				$QUERY = "SELECT A.KODE_GUDANG, IFNULL(B.NAMA_GUDANG,'UTAMA') AS NAMA_GUDANG, A.KONDISI_BARANG, A.KODE_RAK, A.KODE_SUB_RAK
						  FROM m_trader_barang_gudang A LEFT JOIN m_trader_gudang B
						  ON A.KODE_TRADER = B.KODE_TRADER AND A.KODE_GUDANG = B.KODE_GUDANG 
						  WHERE A.KODE_TRADER = '".$KODE_TRADER."' 
						  AND A.KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."'";
				$GUDANG = $this->main->get_combobox($QUERY,"KODE_GUDANG","NAMA_GUDANG",FALSE);
				$KONDISI = $this->main->get_combobox($QUERY,"KONDISI_BARANG","KONDISI_BARANG",FALSE);
				$RAK = $this->main->get_combobox($QUERY,"KODE_RAK","KODE_RAK",TRUE);
				$SUBRAK = $this->main->get_combobox($QUERY,"KODE_SUB_RAK","KODE_SUB_RAK",TRUE);
			}
			$arraydata = array(
							"DOKUMEN"=>$tipe,
							"AJU"=>$aju,
							"ROW"=>$row,
							"parsial"=>$parsial,
							"break"=>$break,
							"GUDANG"=>$GUDANG,
							"KONDISI"=>$KONDISI,
							"RAK"=>$RAK,
							"SUBRAK"=>$SUBRAK
						);
			echo $this->load->view('realisasi/Breakdown', $arraydata, true);	
		}else{
			$this->load->model("realisasiin_act");
			$this->realisasiin_act->parsial($this->input->post("act"));	
		}
	}
	#====================================================== END REALISASI IN ================================================
	
	#====================================================== START REALISASI OUT =============================================
	
	function out($tipe="",$dok="",$aju=""){
		$this->addHeader["newtable"] = 1;
		$this->addHeader["alert"]    = 1;
		$this->addHeader["ui"] = 1;
		if(in_array($tipe,array("save","update","delete"))){
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
				$this->set_realisasi_out($tipe,$dok,$aju);
			}else{
				redirect(site_url()."/realisasi/out");
			}
		}else{			
			$this->load->model("realisasiout_act");
			$arrdata = $this->realisasiout_act->out($dok,$aju);
			$data = $this->load->view('box-pabean', $arrdata, true);
			if($this->input->post("ajax")){
				echo  $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function set_realisasi_out($act="",$dok="",$aju=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("main");
		$data = array("act"=>$act, "PARSIAL"=>$this->input->post("PARSIAL"), "BREAK"=>$this->input->post("BREAK"));
		if($act=="update"){			
			$this->load->model("realisasiout_act");
			$get = $this->realisasiout_act->get_realisasi();
			$data = array_merge(array("DATA"=>$get),$data);
		}
		$this->content = $this->load->view('realisasi/Realisasi_out', $data, true);	
		$this->index($dok);			
	}
	
	function getBarangOut() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiout_act");
			$data = $this->realisasiout_act->getBarang();
			echo $data;
		} else {
			echo "<center><b>Data tidak ditemukan.<b></center>";
		}
	}
	
	function getKondisiOut() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiout_act");
			$data = $this->realisasiout_act->getKondisi();
			echo $data;
		} else {
			redirect(base_url());
		}
	}
	
	function getRakOut() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiout_act");
			$data = $this->realisasiout_act->getRak();
			echo $data;
		} else {
			redirect(base_url());
		}
	}
	
	function getSubRakOut() {
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			$this->load->model("realisasiout_act");
			$data = $this->realisasiout_act->getSubRak();
			echo $data;
		} else {
			redirect(base_url());
		}
	}
	
	function getBreakOut(){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
			$arrdata = explode("~",$this->input->post("id"));
			$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
			$JNS = ", f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JNSBARANG'";
			
			$SQL = "SELECT * ".$JNS." FROM T_".strtoupper($arrdata[0])."_DTL 
					WHERE NOMOR_AJU='".$arrdata[1]."' AND SERI='".$arrdata[2]."' AND KODE_TRADER = '".$KODE_TRADER."'";
			$VAL = $this->db->query($SQL);	
			$ROW = $VAL->result_array();	
			$this->load->model("realisasiout_act");
			$DETILBARANG = $this->realisasiout_act->breakdownDtlBarang($arrdata[1], $arrdata[2], $arrdata[3], $arrdata[0]);
			$arraydata = array("DOKUMEN" => $arrdata[0],
								"AJU" => $arrdata[1],
								"SERI" => $arrdata[2],
								"ROW" => $ROW[0],
								"DETILBARANG" => $DETILBARANG,
								"JUMLAH" => $arrdata[3]);
			echo $this->load->view('realisasi/Breakdown_proses_in', $arraydata, true);
		}
	}
	
	#====================================================== END REALISASI OUT ===============================================
	
	function proses_realisasi($type="",$ajax=""){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
			if($type=="in"){
				$this->load->model("realisasiin_act");
				$data = $this->realisasiin_act->proses_realisasi();
			}elseif($type=="out"){
				$this->load->model("realisasiout_act");
				$data = $this->realisasiout_act->proses_realisasi();
			}
			echo $data;
		}
	}
	
	function getDokIn(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("realisasiout_act");
		$this->load->model("main");
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			$act = $this->input->post("act");
			if($act=="save"){
				$data = $this->realisasiout_act->getDokIn($act);
				echo $data;
			}else{
				$data = $this->input->post("id");
				$param = explode("~",$data);
				$arrdata["resultData"]		= $this->realisasiout_act->getDokIn($act);
				$arrdata["AJU"] 			= $param[1];
				$arrdata["SERI"] 			= $param[2];
				$arrdata["KODE_BARANG"] 	= $param[3];
				$arrdata["JNS_BARANG"] 		= $param[4];
				$arrdata["JENIS_BARANG"]	= $this->main->get_uraian("SELECT f_ref('ASAL_JENIS_BARANG',".$arrdata["JNS_BARANG"].") AS JENIS_BARANG FROM DUAL","JENIS_BARANG");
				$arrdata["JUMLAH_SATUAN"] 	= $param[5];
				$arrdata["DOKUMEN"]		 	= $param[0];
				echo $this->load->view('realisasi/form-dokin', $arrdata, true);
			}
		}else{
			echo base_url();
		}
	}
	
	function getBB(){
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("realisasiout_act");
		$this->load->model("main");
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			if($this->input->post("act")=="getBB"){
				$data = $this->input->post("id");
				$param = explode("~",$data);
				$arrdata["AJU"] 			= $param[1];
				$arrdata["SERI"] 			= $param[2];
				$arrdata["KODE_BARANG"] 	= $param[3];
				$arrdata["JNS_BARANG"] 		= $param[4];
				$arrdata["JENIS_BARANG"]	= $this->main->get_uraian("SELECT f_ref('ASAL_JENIS_BARANG',".$arrdata["JNS_BARANG"].") AS JENIS_BARANG FROM DUAL","JENIS_BARANG");
				$arrdata["JUMLAH_SATUAN"] 	= $param[5];
				$arrdata["DOKUMEN"]		 	= $param[0];
				$arrdata["resultData"]		= $this->realisasiout_act->getBB($this->input->post("act"),$param[1],$param[2],$param[0]);
				echo $this->load->view('realisasi/form-bb', $arrdata, true);
			}else{
				$act 	= $this->input->post("act");
				$aju 	= $this->input->post("AJU");
				$seri 	= $this->input->post("SERI");
				$dok 	= $this->input->post("DOKUMEN");
				$data 	= $this->realisasiout_act->getBB($act,$aju,$seri,$dok);
				echo $data;
			}
		}else{
			echo base_url();
		}
	}
	
	function parsialout($tipe="",$aju="",$parsial="",$break="",$seri=""){	
		if(!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			$JNS = ", f_ref('ASAL_JENIS_BARANG',B.JNS_BARANG) 'JNSBARANG',B.JNS_BARANG JBRG";
			$JENIS = "B.JNS_BARANG";
			
			if(strtoupper($tipe)=="BC30"){							
				$NILAI_BARANG = ",B.FOB_PER_BARANG AS NILAI_BARANG";	
			}
			elseif(strtoupper($tipe)=="BC27" || strtoupper($tipe)=="BC41"){				
				$NILAI_BARANG = ",B.HARGA_PENYERAHAN AS NILAI_BARANG";	
			}
			else{				
				$NILAI_BARANG = ",B.CIF AS NILAI_BARANG";	
			}
									
			$SQL = "SELECT B.*, A.NOMOR_AJU, A.NOMOR_PENDAFTARAN, A.TANGGAL_PENDAFTARAN 
					".$JNS.", B.KODE_SATUAN, IFNULL(f_jum_inout('".$aju."','".$tipe."','".$KODE_TRADER."',B.KODE_BARANG,".$JENIS.",
					B.KODE_SATUAN, B.SERI),0) AS JUMLAH_INOUT ".$NILAI_BARANG.",".$JENIS." AS JNS_BARANG, 
					IFNULL(f_jum_inout_nilaibrg('MASUK',A.NOMOR_PENDAFTARAN, A.TANGGAL_PENDAFTARAN,'".$tipe."','".$KODE_TRADER."',
					B.KODE_BARANG,".$JENIS.",B.SERI),0) AS NILAIBRG_INOUT
					FROM T_".$tipe."_HDR A, T_".$tipe."_DTL B
					WHERE A.KODE_TRADER = B.KODE_TRADER AND A.NOMOR_AJU=B.NOMOR_AJU AND A.NOMOR_AJU='".$aju."' 
					AND A.KODE_TRADER='".$KODE_TRADER."' AND B.SERI = '".$seri."'";
			$rs = $this->db->query($SQL);
			$row = "";		
			if($rs->num_rows()>0){
				$this->load->model("main");
				$row = $rs->result_array();
				$data = $rs->row();
				$KODE_BARANG = $data->KODE_BARANG;
				$JNS_BARANG = $data->JNS_BARANG;
				$QUERY = "SELECT A.KODE_GUDANG, IFNULL(B.NAMA_GUDANG,'UTAMA') AS NAMA_GUDANG, A.KONDISI_BARANG, A.KODE_RAK, A.KODE_SUB_RAK
						  FROM m_trader_barang_gudang A LEFT JOIN m_trader_gudang B
						  ON A.KODE_TRADER = B.KODE_TRADER AND A.KODE_GUDANG = B.KODE_GUDANG 
						  WHERE A.KODE_TRADER = '".$KODE_TRADER."' 
						  AND A.KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."'";
				$GUDANG = $this->main->get_combobox($QUERY,"KODE_GUDANG","NAMA_GUDANG",FALSE);
				$KONDISI = $this->main->get_combobox($QUERY,"KONDISI_BARANG","KONDISI_BARANG",FALSE);
				$RAK = $this->main->get_combobox($QUERY,"KODE_RAK","KODE_RAK",FALSE);
				$SUBRAK = $this->main->get_combobox($QUERY,"KODE_SUB_RAK","KODE_SUB_RAK",FALSE);
			}
			$arraydata = array("DOKUMEN"=>$tipe,"AJU"=>$aju,"ROW"=>$row,"parsial"=>$parsial,"break"=>$break,"GUDANG"=>$GUDANG,"KONDISI"=>$KONDISI,"RAK"=>$RAK,"SUBRAK"=>$SUBRAK);
			echo $this->load->view('realisasi/parsialout', $arraydata, true);	
		}else{
			$this->load->model("realisasiout_act");
			$this->realisasiout_act->parsial($this->input->post("act"));	
		}
	}
}
?>