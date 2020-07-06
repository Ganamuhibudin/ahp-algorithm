<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Surat_act extends CI_Model{
	
	function print_surat($aju=""){
		$func = get_instance();
		$func->load->model("main");
		$this->load->library('fungsi');
		$SQL = "SELECT NOMOR_AJU, f_kpbc(KANTOR_TUJUAN) KANTOR_TUJUAN, KODE_TRADER, NO_PERMOHONAN, TGL_PERMOHONAN, LAMPIRAN, 
				PERIHAL, TUJUAN_PERMOHONAN, URAIAN_SURAT, NAMA_PEMOHON, NOID_PEMOHON, NO_SRT_TUGAS, TELP_PEMOHON, EMAIL_PEMOHON 
				FROM m_trader_permohonan WHERE NOMOR_AJU='".$aju."'";
		$SURAT = $func->main->get_result($SQL);
		if($SURAT){
			foreach($SQL->result_array() as $row){
				$dataSurat = $row;
			}
			if($dataSurat["LAMPIRAN"]!="")
				$lamp = $dataSurat["LAMPIRAN"];
			else
				$lamp = "''";	
			$SQL = "SELECT URAIAN FROM m_tabel WHERE JENIS='LAMPIRAN' AND KODE IN (".$lamp.") ORDER BY KODE ASC ";
			$lam = $func->main->get_result($SQL);
			if($lam){
				$LIST = '<ol type="1" style="margin:0px 0 1px 20px">';
				foreach($SQL->result_array() as $DATA){
					$LIST .= "<li>".ucwords(strtolower($DATA["URAIAN"]))."</li>";
				}
				$LIST .= '</ol>';
			}	
			$query = "SELECT A.KODE_TRADER, A.KODE_ID 'KODE_ID_TRADER', A.ID, 
						  A.NAMA 'NAMA_TRADER', A.ALAMAT 'ALAMAT_TRADER', A.TELEPON,
						  B.NOMOR_SKEP 'REGISTRASI', C.NAMA 'NAMA_CP', C.TELEPON 'TELP_CP', 
						  C.EMAIL 'EMAIL_CP', ID AS 'ID_TRADER', D.NAMA_TTD, D.KOTA_TTD,
						  0 AS 'FOB', 0 AS 'FREIGHT', 0 AS 'ASURANSI', 0 AS 'CIF', 0 AS 'CIFRP', 
						  0 AS 'BRUTO', 0 AS 'NETTO', 0 AS 'TAMBAHAN', 0 AS 'DISKON', 
						  0 AS 'NILAI_INVOICE', 0 AS 'NDPBM'
						  FROM M_TRADER A 
						  INNER JOIN T_USER C ON A.KODE_TRADER=C.KODE_TRADER 
						  LEFT JOIN M_TRADER_SKEP B ON A.KODE_TRADER=B.KODE_TRADER 
						  LEFT JOIN M_SETTING D ON A.KODE_TRADER=D.KODE_TRADER
						WHERE A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=C.KODE_TRADER
						AND A.KODE_TRADER='".$dataSurat["KODE_TRADER"]."' 
						AND C.USER_ID = '".$this->newsession->userdata("USER_ID")."'";
						  			
			$hasil = $func->main->get_result($query);
			if($hasil){
				foreach($query->result_array() as $row){
					$TRADER = $row;
				}
			}	
			$JMLLAMPIRAN = count(explode(",",$dataSurat["LAMPIRAN"]))." Lembar";
			$data = array('LAMPIRAN' => $LIST,
						  'TRADER' => $TRADER,
						  'SURAT' => $dataSurat,
						  "JMLLAMPIRAN" => $JMLLAMPIRAN,
						  "TGL" => $this->fungsi->FormatDate($dataSurat["TGL_PERMOHONAN"]),
						  "pagebreak" => 1 );
			return $data;
		}
	}
}
?>