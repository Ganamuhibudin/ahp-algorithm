<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload_act extends CI_Model{
	
	function getDataKodeUpload($tipe="",$tanggal="",$kdbarang="",$jnsbarang="",$seri="",$kdgudang="",$kdrak="",$kdsubrak="",$kondisi="")
	{
		$arrayReturn = array();
		$sql = "";
		switch ($tipe)
		{
			case 'kpbc': 
				 	$sql = "SELECT KODE_KPBC AS code FROM m_kpbc"; break;
			case 'id': 
				 	$sql = "SELECT MAX(ID) AS code FROM m_trader_stockopname"; break;
			case 'barang': 
				 	$sql = "SELECT KODE_BARANG AS code FROM m_trader_barang 
						    WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;	
			case 'partner': 
				 	$sql = "SELECT KODE_PARTNER AS code FROM m_trader_barang 
						    WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;	
			case 'barangAll': 
				 	$sql = "SELECT IFNULL(STOCK_AKHIR,0) AS code FROM m_trader_barang  
						    WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"."
							AND KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."'"; break;
			case 'gudangAll': 
				 	$sql = "SELECT IFNULL(JUMLAH,0) AS code FROM m_trader_barang_gudang  
						    WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"."
							AND KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."' AND KODE_GUDANG='".$kdgudang."'"; break;						
			case 'idDetilStock': 
				 	$sql = "SELECT ID AS code FROM m_trader_stockopname  
						    WHERE KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."'
							AND TANGGAL_STOCK='".$tanggal."'"; break;						
			case 'stock': 
					$sql = "SELECT KODE_BARANG AS code FROM m_trader_stockopname 
							WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"."
							AND TANGGAL_STOCK='".$tanggal."'"; break;
			case 'stockDetil': 
					$sql = "SELECT A.NO_DOK_MASUK AS code FROM m_trader_stockopname_dtl A 
							WHERE A.TGL_DOK_MASUK='".$tanggal."'
							AND A.IDHDR = '".$jnsbarang."' AND A.JENIS_DOK_MASUK = '".$seri."'"; break;
			case 'stockDetilTgl': 
					$sql = "SELECT TGL_DOK_MASUK AS code FROM m_trader_stockopname_dtl"; break;
			case 'stockAll': 
					$sql = "SELECT IFNULL(JUMLAH,0) AS code FROM m_trader_stockopname 
							WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'
							AND KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."'
							AND TANGGAL_STOCK='".$tanggal."'"; break;				
			case 'stockAllDetil': 
					$sql = "SELECT IFNULL(JUMLAH,0) AS code FROM m_trader_stockopname_dtl 
							WHERE TGL_DOK_MASUK='".$tanggal."'
							AND IDHDR = '".$kdbarang."' AND JENIS_DOK_MASUK = '".$jnsbarang."'"; break;				
			case 'satuan': 
					$sql = "SELECT KODE_SATUAN AS code FROM m_satuan"; break;
			case 'transaksi': 
					$sql = "SELECT NOMOR_PROSES AS code FROM m_trader_proses
					 		WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;
			case 'inout': 
					$sql = "SELECT KODE_BARANG AS code FROM m_trader_barang_inout  
						    WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'
							AND KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."' AND SERI='".$seri."'";
					break;	
			case 'car':
					$sql = "SELECT NOMOR_AJU AS code FROM t_bc23_hdr 
							WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND NOMOR_AJU='".$tanggal."'";
					$sql .= "UNION SELECT NOMOR_AJU AS code FROM t_bc27_hdr 
							WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND NOMOR_AJU='".$tanggal."'";
					$sql .= "UNION SELECT NOMOR_AJU AS code FROM t_bc30_hdr 
							WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND NOMOR_AJU='".$tanggal."'";
					$sql .= "UNION SELECT NOMOR_AJU AS code FROM t_bc25_hdr 
							WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND NOMOR_AJU='".$tanggal."'";		
					break;	
			case 'kurs': 
					$sql = "SELECT KODE_VALUTA AS code FROM m_valuta"; break;	
					
			case 'konversi': 
					$sql = "SELECT NOMOR_KONVERSI AS code FROM m_trader_konversi_bj
					 		WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;	
			case 'jenisbarang': 
					$sql = "SELECT KODE AS code FROM m_tabel WHERE JENIS='ASAL_JENIS_BARANG'"; break;	
			case 'penggunaanbarang': 
					$sql = "SELECT KODE AS code FROM m_tabel WHERE JENIS='PENGGUNAAN_BARANG'"; break;
			case 'negara': 
					$sql = "SELECT KODE_NEGARA AS code FROM m_negara"; break;	
			case 'kemasan': 
					$sql = "SELECT KODE_KEMASAN AS code FROM m_kemasan"; break;		
			case 'fasilitas': 
					$sql = "SELECT KODE AS code FROM m_tabel WHERE JENIS='FAS_SKEMA'"; break;												
			case 'carrAll':
					$sql = "SELECT NOMOR_AJU AS code FROM t_bc23_hdr ";
					$sql .= " UNION SELECT NOMOR_AJU AS code FROM t_bc27_hdr ";
					$sql .= " UNION SELECT NOMOR_AJU AS code FROM t_bc262_hdr ";
					$sql .= " UNION SELECT NOMOR_AJU AS code FROM t_bc261_hdr ";
					$sql .= " UNION SELECT NOMOR_AJU AS code FROM t_bc30_hdr ";
					$sql .= " UNION SELECT NOMOR_AJU AS code FROM t_bc40_hdr ";
					$sql .= " UNION SELECT NOMOR_AJU AS code FROM t_bc41_hdr ";
					$sql .= " UNION SELECT NOMOR_AJU AS code FROM t_bc25_hdr ";	
					break;	
					
			case 'pemasok': 
					$sql = "SELECT KODE_PARTNER AS code FROM m_trader_partner
					 		WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;	
			case 'identitas': 
					$sql = "SELECT KODE AS code FROM m_tabel WHERE JENIS='KODE_ID'"; break;	
			case 'jenisperusahaan': 
					$sql = "SELECT KODE AS code FROM m_tabel WHERE JENIS='JENIS_PERUSAHAAN'"; break;	
			case 'statusperusahaan': 
					$sql = "SELECT KODE AS code FROM m_tabel WHERE JENIS='TEMPAT'"; break;		
			case 'idnegara': 
				$sql = "SELECT KODE_NEGARA AS code  
						FROM m_negara WHERE UPPER(URAIAN_NEGARA) LIKE '%".$tanggal."%'
						OR UPPER(URAIAN_NEGARA)='".$tanggal."'"; break;	
			case 'gudang': 
				$sql = "SELECT KODE_GUDANG AS code  
						FROM m_trader_gudang WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;
			case 'rak':
				$sql = "SELECT KODE_RAK AS code FROM M_TRADER_RAK  WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' AND KODE_GUDANG = '". $kdgudang ."'"; break;
			case 'kondisi': 
				$sql = "SELECT KONDISI_BARANG AS code  
						FROM m_trader_barang_gudang WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' 
						AND KODE_BARANG='".$kdbarang."'"; break;
			case 'nomorproses': 
					$sql = "SELECT NOMOR_PROSES AS code FROM m_trader_proses
					 		WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND JENIS_BARANG='masuk'"; break;
			case 'rak1': 
			 	$sql = "SELECT COUNT(KODE_RAK) AS code FROM m_trader_rak 
					    WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND KODE_GUDANG='".$kdgudang."' AND KODE_RAK='".$kdrak."'"; break;
			case 'subrak1': 
			 	$sql = "SELECT COUNT(KODE_SUB_RAK) AS code FROM m_trader_sub_rak 
					    WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' AND KODE_GUDANG='".$kdgudang."' AND KODE_RAK='".$kdrak."' AND KODE_SUB_RAK='".$kdsubrak."'"; break;
			case 'gudang_tiga_level':
				$kode = "B.KODE_GUDANG";
				if($kdrak!="" && $kdsubrak==""){
					$kd_rak = " AND B.KODE_RAK = '".$kdrak."'";
					$kode = "B.KODE_RAK";
				}
				if($kdsubrak!=""){
					$kd_subrak = " AND B.KODE_SUB_RAK = '".$kdsubrak."'";
					$kode = "B.KODE_SUB_RAK";
				}
				$sql = "SELECT ".$kode." AS code FROM M_TRADER_BARANG A INNER JOIN M_TRADER_BARANG_GUDANG B ON A.KODE_TRADER = B.KODE_TRADER 
						AND A.KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' 
						AND A.KODE_BARANG = B.KODE_BARANG AND A.KODE_BARANG = '". $kdbarang ."' AND A.JNS_BARANG = B.JNS_BARANG 
						AND B.JNS_BARANG = '".$jnsbarang."' AND B.KODE_GUDANG = '".$kdgudang."'".$kd_rak." ".$kd_subrak;  
						break;
			#CEK SATUAN DI UPLOAD PRODUKSI
			case 'satuan_prod': 
				$sql = "SELECT A.KODE_SATUAN AS code FROM M_SATUAN A INNER JOIN M_TRADER_BARANG B ON A.KODE_SATUAN = B.KODE_SATUAN
						INNER JOIN M_TRADER_BARANG_GUDANG C ON A.KODE_SATUAN = C.SATUAN AND C.SATUAN = B.KODE_SATUAN AND 
						B.KODE_BARANG = C.KODE_BARANG AND B.JNS_BARANG = C.JNS_BARANG AND B.KODE_BARANG = '".$kdbarang."' AND B.JNS_BARANG =
						'".$jnsbarang."' "; break;	
			#END SATUAN DI UPLOAD PRODUKSI		
			case 'stock_prod':
				$sql = "SELECT b.JUMLAH AS code FROM M_TRADER_BARANG a INNER JOIN M_TRADER_BARANG_GUDANG b ON a.KODE_TRADER = B.KODE_TRADER 
						AND a.KODE_BARANG = b.KODE_BARANG AND b.KODE_BARANG = '".$kdbarang."' AND a.JNS_BARANG = b.JNS_BARANG 
						AND b.JNS_BARANG = '" . $jnsbarang . "' AND b.KODE_GUDANG = '" . $kdgudang . "' AND b.KODE_RAK = '".$kdrak."' 
						AND b.KODE_SUB_RAK = '" . $kdsubrak. "' AND b.KONDISI_BARANG = '".$kondisi."' AND 
						a.KODE_TRADER = '" . $this->newsession->userdata('KODE_TRADER') . "' ";
						break;		
		}
		if ($sql!="")
		{
			$this->db->reconnect();
			$result = $this->db->query($sql);
			foreach ($result->result_array() as $row)
				$arrayReturn[] = strtoupper($row['code']);
		}
		return $arrayReturn;
	}		
	
	function getDataParameter($tipe="",$param1="",$param2="")
	{
		
		if($param1){
			$param1 = str_replace("'","",$param1);
		}
		if($param2){
			$param2 = str_replace("'","",$param2);
		}
		$arrayReturn = array();
		$sql = "";
		switch (strtolower($tipe))
		{
			case 'stock': 
				$sql = "SELECT KODE_BARANG AS code, TANGGAL_STOCK AS tgl  
						FROM m_trader_stockopname WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;		
						
			case 'barang': 
				$sql = "SELECT KODE_SATUAN AS KODE_BESAR, KODE_SATUAN_TERKECIL AS KODE_KECIL  
						FROM m_trader_barang WHERE KODE_BARANG='".$param1."' AND JNS_BARANG='".$param2."'
						AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;	
						
			case 'transaksi': 
				$sql = "SELECT NOMOR_PROSES FROM m_trader_proses
					 		WHERE LOWER(JENIS_BARANG) = '".strtolower($param1)."' AND TANGGAL='".$param2."'
							AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' LIMIT 1 "; break;

			case 'jnsbarang': 
				$sql = "SELECT count(KODE_BARANG) AS COUNT  
						FROM m_trader_barang WHERE KODE_BARANG='".$param2."' AND JNS_BARANG='".$param1."'
						AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;

			case 'urbarang': 
				$sql = "SELECT count(KODE_BARANG) AS COUNT  
						FROM m_trader_barang WHERE KODE_BARANG='".$param2."' AND URAIAN_BARANG='".$param1."'
						AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;

			case 'satuan': 
				$sql = "SELECT count(KODE_BARANG) AS COUNT  
						FROM m_trader_barang WHERE KODE_BARANG='".$param2."' AND KODE_SATUAN_TERKECIL='".$param1."'
						AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'"; break;								
												
		}
		if ($sql!="")
		{
			$this->db->reconnect();
			$result = $this->db->query($sql);
			if($tipe == "stock"){
				if($result->num_rows() > 0){
					foreach ($result->result_array() as $row)
					{
						$arrayReturn['kode'][] = strtoupper($row['code']);
						$arrayReturn['tgl'][] = strtoupper($row['tgl']);
					}
				}else{
					$arrayReturn['kode'][] = '';
					$arrayReturn['tgl'][] = '';
				}
			}	
			elseif($tipe == "barang" || $tipe == "jnsbarang" || $tipe == "urbarang" || $tipe == "satuan"){
				if($result->num_rows() > 0){					
					$arrayReturn = $result->result_array();					
				}else{
					$arrayReturn = "";
				}
			}
			elseif($tipe == "transaksi"){
				if($result->num_rows() > 0){
					$data = $result->row();				
					$arrayReturn = $data->NOMOR_PROSES;					
				}else{
					$arrayReturn = "";
				}
			}			
		}
		return $arrayReturn;
	}	
}
?>