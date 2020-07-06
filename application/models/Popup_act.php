<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Popup_act extends CI_Model{	
    function getlistDataPopUp($mulai,$typeCari,$uraiCari){
		$type=$this->input->post('type'); 
		$jenis=$this->input->post('jenis');//echo $jenis.'XX';exit;
		$addSql = "";
		$addWhere="";
		if($jenis=="konversi"){
			$addWhere="B.KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND";
		}
		if($jenis=="barang_jadi"){
			$addWhere="KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND";
		}
		if(($jenis=="pemasokBC27") || ($jenis=="pemasokBC261") || ($jenis=="pemasokBC262") || ($jenis=='pemasokBC41') || ($jenis=='pemasokBC40')){
			$addWhere="KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND";
		}
		if (trim($typeCari) != "")
		{
			if(($jenis=="kemasan") || ($jenis=="kemasanBrg")){
				if($typeCari=="KODE_KEMASAN"){
					$addSql = " KODE_KEMASAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_KEMASAN"){
					$addSql = " URAIAN_KEMASAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="satuanBrg")){
				if($typeCari=="KODE_SATUAN"){
					$addSql = " KODE_SATUAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_SATUAN"){
					$addSql = " URAIAN_SATUAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="konversi")){
				if($typeCari=="NOMOR_KONVERSI"){
					$addSql = " A.NOMOR_KONVERSI LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="KODE_BARANG"){
					$addSql = " A.KODE_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_BARANG"){
					$addSql = " B.URAIAN_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="pemasokBC27") || ($jenis=="pemasokBC261") || ($jenis=="pemasokBC262") || ($jenis=='pemasokBC41') || ($jenis=='pemasokBC40')){
				if($typeCari=="ID_PARTNER"){
					$addSql = " ID_PARTNER LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="NAMA_PARTNER"){
					$addSql = " NAMA_PARTNER LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="ALAMAT_PARTNER"){
					$addSql = " ALAMAT_PARTNER LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="barang_jadi") || ($jenis=='bhnBku27') ||($jenis=='bhnBku261')){
				if($typeCari=="KODE_BARANG"){
					$addSql = " KODE_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_BARANG"){
					$addSql = " URAIAN_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="zoning_bc30") || ($jenis=="jns_PKB") || ($jenis=="gdng_PKB")|| ($jenis=="cara_STUFF") || ($jenis=="jnpartof")){
				if($jenis=="zoning_bc30"){
					$addSql = "JENIS = 'ZONING_KITE'";
				}if($jenis=="jns_PKB"){
					$addSql = "JENIS = 'JNS_BRG_PKB'";
				}if($jenis=="gdng_PKB"){
					$addSql = "JENIS = 'TEMPAT_PKB'";
				}if($jenis=="cara_STUFF"){
					$addSql = "JENIS = 'JENIS_STUFF'";
				}if($jenis=="jnpartof"){
					$addSql = "JENIS = 'PART_OF'";
				}if($typeCari=="KODE"){
					$addSql .= " AND KODE LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN"){
					$addSql .= " AND URAIAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}
		}
		if (trim($addSql) != "" || trim($addWhere) != "")
		{
			$addSql = " WHERE ".$addWhere.$addSql;//echo $addSql;exit;
		}
		if($jenis=="kemasan" || $jenis=="kemasanBrg"){
			$SQL="SELECT * FROM M_KEMASAN".$addSql." LIMIT ".$mulai.", ".DATA_PER_PAGE;//echo $SQL;die();
		}elseif($jenis=="satuanBrg"){
			$SQL="SELECT * FROM M_SATUAN".$addSql." LIMIT ".$mulai.", ".DATA_PER_PAGE;//echo $SQL;die();
		}elseif($jenis=="konversi"){
			$SQL="SELECT A.*,IFNULL(f_jumkonversi_bb(A.IDBJ),0) AS 'JUMLAH_BB',B.URAIAN_BARANG FROM M_TRADER_KONVERSI_BJ A
				 INNER JOIN M_TRADER_BARANG B ON B.KODE_BARANG=A.KODE_BARANG
				 ".$addSql." LIMIT ".$mulai.", ".DATA_PER_PAGE;//echo $SQL;die();
		}elseif(($jenis=="pemasokBC27") || ($jenis=="pemasokBC261") || ($jenis=="pemasokBC262") || ($jenis=='pemasokBC41') || ($jenis=='pemasokBC40')){
			$SQL="SELECT *,f_ref('KODE_ID',KODE_ID_PARTNER) AS UR_ID FROM M_TRADER_PEMASOK".$addSql." LIMIT ".$mulai.", ".DATA_PER_PAGE;//echo $SQL;die();
		}elseif(($jenis=="barang_jadi") || ($jenis=="bhnBku27") ||($jenis=='bhnBku261')){
			$SQL="SELECT KODE_BARANG,URAIAN_BARANG,JNS_BARANG,f_ref('ASAL_JENIS_BARANG',JNS_BARANG) AS 'JENIS_BARANG',STOCK_AKHIR,MERK,TIPE,UKURAN,KODE_SATUAN,SPFLAIN,f_satuan(KODE_SATUAN) AS 'URAIAN_SATUAN' FROM M_TRADER_BARANG".$addSql." LIMIT ".$mulai.", ".DATA_PER_PAGE;
		}elseif(($jenis=="zoning_bc30") || ($jenis=="jns_PKB") || ($jenis=="gdng_PKB")|| ($jenis=="cara_STUFF") || ($jenis=="jnpartof")){
			$SQL="SELECT * FROM M_TABEL".$addSql." LIMIT ".$mulai.", ".DATA_PER_PAGE;//echo $SQL;die();	
		}
		$result = $this->db->query($SQL);	
		return $result->result_array();	
	}
	function gettotalListPopUp($typeCari,$uraiCari){
		$type=$this->input->post('type');//echo $type.'XX'; 
		$jenis=$this->input->post('jenis');
		$addSql = "";
		$addWhere="";
		$jenis=$this->input->post('jenis');//echo $jenis.'XX';
		
		if($jenis=="konversi"){
			$addWhere=" B.KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND";
		}
		if($jenis=="barang_jadi"){
			$addWhere="KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND";
		}
		if(($jenis=="pemasokBC27") || ($jenis=="pemasokBC261") || ($jenis=="pemasokBC262") || ($jenis=='pemasokBC41') || ($jenis=='pemasokBC40')){
			$addWhere="KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND";
		}
		if (trim($typeCari) != "")
		{
			if($jenis=="kemasan" || $jenis=="kemasanBrg"){
				if($typeCari=="KODE_KEMASAN"){
					$addSql = " KODE_KEMASAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_KEMASAN"){
					$addSql = " URAIAN_KEMASAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="satuanBrg")){
				if($typeCari=="KODE_SATUAN"){
					$addSql = " KODE_SATUAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_SATUAN"){
					$addSql = " URAIAN_SATUAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="konversi")){
				if($typeCari=="NOMOR_KONVERSI"){
					$addSql = " A.NOMOR_KONVERSI LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="KODE_BARANG"){
					$addSql = " A.KODE_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_BARANG"){
					$addSql = " B.URAIAN_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="pemasokBC27") || ($jenis=="pemasokBC261") || ($jenis=='pemasokBC262')|| ($jenis=='pemasokBC41')|| ($jenis=='pemasokBC40')){
				if($typeCari=="ID_PARTNER"){
					$addSql = " ID_PARTNER LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="NAMA_PARTNER"){
					$addSql = " NAMA_PARTNER LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="ALAMAT_PARTNER"){
					$addSql = " ALAMAT_PARTNER LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="barang_jadi") || ($jenis=="bhnBku27") ||($jenis=='bhnBku261')){
				if($typeCari=="KODE_BARANG"){
					$addSql = " KODE_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN_BARANG"){
					$addSql = " URAIAN_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}elseif(($jenis=="zoning_bc30") || ($jenis=="jns_PKB") || ($jenis=="gdng_PKB")|| ($jenis=="cara_STUFF") || ($jenis=="jnpartof")){
				if($jenis=="zoning_bc30"){
					$addSql = "JENIS = 'ZONING_KITE'";
				}if($jenis=="jns_PKB"){
					$addSql = "JENIS = 'JNS_BRG_PKB'";
				}if($jenis=="gdng_PKB"){
					$addSql = "JENIS = 'TEMPAT_PKB'";
				}if($jenis=="cara_STUFF"){
					$addSql = "JENIS = 'JENIS_STUFF'";
				}if($jenis=="jnpartof"){
					$addSql = "JENIS = 'PART_OF'";
				}if($typeCari=="KODE"){
					$addSql .= " AND KODE LIKE '%".trim(addslashes($uraiCari))."%'";
				}elseif($typeCari=="URAIAN"){
					$addSql .= " AND URAIAN LIKE '%".trim(addslashes($uraiCari))."%'";
				}
			}
		}
		if (trim($addSql) != "" || trim($addWhere) != "")
		{
			$addSql = " WHERE ".$addWhere.$addSql;//echo $addSql;exit;
		}
		if($jenis=="kemasan" || $jenis=="kemasanBrg"){
			$sql = "SELECT COUNT(*) AS banyak FROM
					M_KEMASAN".$addSql;//echo $sql;
		}elseif($jenis=="satuanBrg"){
			$sql = "SELECT COUNT(*) AS banyak FROM
					M_SATUAN".$addSql;//echo $sql;
		}elseif($jenis=="konversi"){
			$sql = "SELECT COUNT(*) AS banyak FROM
					M_TRADER_KONVERSI_BJ A LEFT JOIN M_TRADER_BARANG B ON B.KODE_BARANG = A.KODE_BARANG".$addSql;//echo $sql;EXIT;
		}elseif(($jenis=="pemasokBC27") || ($jenis=="pemasokBC261") || ($jenis=='pemasokBC262')|| ($jenis=='pemasokBC41')|| ($jenis=='pemasokBC40')){
			$sql = "SELECT COUNT(*) AS banyak FROM
					M_TRADER_PEMASOK".$addSql;//echo $sql;
		}elseif(($jenis=="barang_jadi") || ($jenis=="bhnBku27" ||($jenis=='bhnBku261'))){
			$sql = "SELECT COUNT(*) AS banyak FROM
					M_TRADER_BARANG".$addSql;//echo $sql;
		}elseif(($jenis=="zoning_bc30") || ($jenis=="jns_PKB") || ($jenis=="gdng_PKB")|| ($jenis=="cara_STUFF") || ($jenis=="jnpartof")){
			$sql = "SELECT COUNT(*) AS banyak FROM
					M_TABEL".$addSql;//echo $sql;
		}
		$result = $this->db->query($sql);
		$row = $result->row();
		$banyak = $row->banyak;
		$banyakIndex = ceil(($banyak/DATA_PER_PAGE));
		return $banyakIndex;;
	}
	
}