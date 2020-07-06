<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan_act extends CI_Model{

	function daftar_laporan($tipe="",$tglAwal="",$tglAkhir="",$kodebarang="",$jenis="",$TIPE_TANGGAL="",$TIPE_PERIODE="",$ALL="",$ALL_SALDO=''){
		$func = get_instance();
		$func->load->model("main","main", true);
		$kodeTrader = $this->newsession->userdata('KODE_TRADER');
		if($tipe=='posisi'){
			$SQL = "SELECT A.LOGID LOGID_IN, A.JENIS_DOK JENIS_DOK_IN, A.NO_DOK NO_DOK_IN, A.TGL_DOK TGL_DOK_IN, 
					A.TGL_MASUK TGL_MASUK_IN, A.KODE_BARANG KODE_BARANG_IN, A.JNS_BARANG JNS_BARANG_IN, 
					A.SERI_BARANG SERI_BARANG_IN, A.NAMA_BARANG NAMA_BARANG_IN, A.SATUAN SATUAN_IN, A.JUMLAH JUMLAH_IN, 
					A.NILAI_PABEAN NILAI_PABEAN_IN, A.FLAG_TUTUP, A.SALDO,
					
					B.LOGID LOGID_OUT, B.JENIS_DOK JENIS_DOK_OUT, B.NO_DOK NO_DOK_OUT, B.TGL_DOK TGL_DOK_OUT, 
					B.TGL_MASUK TGL_MASUK_OUT, B.KODE_BARANG KODE_BARANG_OUT, B.JNS_BARANG JNS_BARANG_OUT, B.SERI_BARANG SERI_BARANG_OUT,
					B.NAMA_BARANG NAMA_BARANG_OUT, B.SATUAN SATUAN_OUT, B.JUMLAH JUMLAH_OUT, B.SERI_BARANG_MASUK, B.NILAI_PABEAN NILAI_PABEAN_OUT, 
					B.NO_DOK_MASUK NO_DOK_MASUK_OUT, B.TGL_DOK_MASUK TGL_DOK_MASUK_OUT, B.JENIS_DOK_MASUK JENIS_DOK_MASUK_OUT
					
					FROM t_logbook_pemasukan A LEFT JOIN t_logbook_pengeluaran B
					ON B.NO_DOK_MASUK = A.NO_DOK AND B.TGL_DOK_MASUK = A.TGL_DOK AND B.LOGID_MASUK = A.LOGID AND B.KODE_TRADER = A.KODE_TRADER 
					INNER JOIN m_trader_barang C ON A.KODE_BARANG = C.KODE_BARANG AND A.JNS_BARANG = C.JNS_BARANG AND A.KODE_TRADER = C.KODE_TRADER 
					AND B.KODE_BARANG = B.KODE_BARANG AND B.JNS_BARANG = C.JNS_BARANG AND B.KODE_TRADER = C.KODE_TRADER 
					WHERE A.KODE_TRADER = '".$kodeTrader."' AND C.STATUS = '1' ";
			
			if($TIPE_PERIODE=="IN"){
				$SQL.=" AND A.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."'";
			}
			elseif($TIPE_PERIODE=="OUT"){
				$SQL.=" AND B.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."'";
			}
			else{
				$SQL.=" AND (A.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."' OR B.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."')";
			}	
			
			$SQL.=" GROUP BY B.LOGID, A.LOGID ";
			
			if(!$ALL_SALDO){
				$SQL.=" ORDER BY A.TGL_DOK, A.NO_DOK,  A.SERI_BARANG,  A.TGL_MASUK, A.KODE_BARANG, B.TGL_MASUK";				
			}
			return $SQL;
		}elseif($tipe=="pemasukan"){
			if ($this->input->post('TIPE_PERIODE') == "REALISASI" || $jenis=="REALISASI") {
				$KONDISI = "DATE_FORMAT(TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
			} elseif ($this->input->post('TIPE_PERIODE') == "DOKUMEN" || $jenis=="DOKUMEN") {
				$KONDISI = "DATE_FORMAT(TANGGAL_DOKUMEN,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
			}
			
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
				$jns_dok = $kodebarang;
				$KONDISI_BARANG = $TIPE_TANGGAL;
			}else{
				$jns_dok = $TIPE_TANGGAL;
			}
			
        	$jns_dok = str_replace("!", "", $jns_dok);
			
			if($jns_dok){
				$AND = " AND KODE_DOKUMEN = '".$jns_dok."'";
			}
			
			if($KONDISI_BARANG){
				$AND1 = " AND KONDISI_BARANG = '".$KONDISI_BARANG."'";
			}
			
			$SQL = "SELECT DISTINCT KODE_DOKUMEN, BREAKDOWN_FLAG
					FROM m_trader_barang_inout 
					WHERE ".$KONDISI." AND TIPE = 'GATE-IN' 
					AND KODE_TRADER = '".$kodeTrader."'".$AND.$AND1;
			$query = $this->db->query($SQL);
			if ($query->num_rows() > 0) {
				if ($this->input->post('TIPE_PERIODE') == "REALISASI" || $jenis=="REALISASI") {
					$KONDISI = "DATE_FORMAT(C.TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
					$KONDISI_BREAK = "DATE_FORMAT(A.TANGGAL_REALISASI,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
				} elseif ($this->input->post('TIPE_PERIODE') == "DOKUMEN" || $jenis=="DOKUMEN") {
					$KONDISI = "DATE_FORMAT(C.TANGGAL_DOKUMEN,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
					$KONDISI_BREAK = "DATE_FORMAT(A.TANGGAL_PENDAFTARAN,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
				}
				#=== START BC16===========================================================================================
				$SQL_BC16 = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN,
				IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('1',B.NOMOR_AJU,'BC16',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NOMOR_DOK_INTERNAL),A.NOMOR_DOK_INTERNAL) NOMOR_DOK_INTERNAL,
						IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('2',B.NOMOR_AJU,'BC16',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.TANGGAL_DOK_INTERNAL),A.TANGGAL_DOK_INTERNAL) TANGGAL_DOK_INTERNAL,
						IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('3',B.NOMOR_AJU,'BC16',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NAMA_PENGIRIM),A.NAMA_PENGIRIM) 'PEMASOK/PENGIRIM',
						C.KODE_BARANG, B.URAIAN_BARANG, 
						CASE D.KODE_SATUAN_TERKECIL 
							WHEN 1 THEN B.KODE_SATUAN
							WHEN '' THEN B.KODE_SATUAN
							ELSE D.KODE_SATUAN_TERKECIL 
						END AS KODE_SATUAN, 
						SUM(C.JUMLAH) JUMLAH_SATUAN,  C.KONDISI_BARANG,
						B.CIF_RP  AS 'NILAI','BC16' AS 'JENIS_DOKUMEN', A.NOMOR_AJU, A.KODE_TRADER,
						f_trader(A.KODE_TRADER) NAMA_PEMILIK |
						FROM t_bc16_hdr A, t_bc16_dtl B, m_trader_barang_inout C, m_trader_barang D
						WHERE " . $KONDISI . $AND1 . " 
						AND A.NOMOR_AJU=B.NOMOR_AJU
						AND A.KODE_TRADER=B.KODE_TRADER
						AND A.NOMOR_AJU=C.NOMOR_AJU 
						AND B.KODE_BARANG=C.KODE_BARANG 
						AND B.JNS_BARANG=C.JNS_BARANG 
						AND A.KODE_TRADER=C.KODE_TRADER
						AND C.KODE_BARANG=D.KODE_BARANG 
						AND C.JNS_BARANG=D.JNS_BARANG 
						AND C.KODE_TRADER=D.KODE_TRADER	
						AND B.SERI = C.SERI_DOKUMEN 
						AND A.KODE_TRADER='".$kodeTrader."'
						AND C.KODE_DOKUMEN='BC16' AND C.TIPE = 'GATE-IN'    
						GROUP BY C.SERI_DOKUMEN, B.NOMOR_AJU, C.KONDISI_BARANG ";
						
				$SQL_BC16_BREAK = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, A.NOMOR_DOK_INTERNAL, A.TANGGAL_DOK_INTERNAL,
							A.NAMA_PENGIRIM AS 'PEMASOK/PENGIRIM', B.KODE_BARANG, B.URAIAN_BARANG, 
							B.KODE_SATUAN, B.JUMLAH_SATUAN, '-' AS KONDISI_BARANG, B.CIF_RP  AS NILAI, 'BC16' AS JENIS_DOKUMEN,
							A.NOMOR_AJU, A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
							FROM t_bc16_hdr A, t_bc16_dtl B
							WHERE  " . $KONDISI_BREAK . " AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER
							AND A.KODE_TRADER='".$kodeTrader."' AND B.BREAKDOWN_FLAG='Y' ";											
				#=== END BC16=============================================================================================	
				
				#=== START BC27===========================================================================================
				$SQL_BC27 = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, 
					IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('1',B.NOMOR_AJU,'BC27',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NOMOR_DOK_INTERNAL),A.NOMOR_DOK_INTERNAL) NOMOR_DOK_INTERNAL,
							IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('2',B.NOMOR_AJU,'BC27',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.TANGGAL_DOK_INTERNAL),A.TANGGAL_DOK_INTERNAL) TANGGAL_DOK_INTERNAL,
							IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('3',B.NOMOR_AJU,'BC27',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NAMA_TRADER_ASAL),A.NAMA_TRADER_ASAL) 'PEMASOK/PENGIRIM',
						C.KODE_BARANG, B.URAIAN_BARANG, 
						CASE D.KODE_SATUAN_TERKECIL 
						WHEN 1 THEN B.KODE_SATUAN
						WHEN '' THEN B.KODE_SATUAN
						ELSE D.KODE_SATUAN_TERKECIL END AS KODE_SATUAN, SUM(C.JUMLAH) JUMLAH_SATUAN,  C.KONDISI_BARANG,
						B.HARGA_PENYERAHAN  AS 'NILAI','BC27' AS 'JENIS_DOKUMEN', A.NOMOR_AJU, A.KODE_TRADER,
						f_trader(A.KODE_TRADER) NAMA_PEMILIK |
						FROM t_bc27_hdr A, t_bc27_dtl B, m_trader_barang_inout C, m_trader_barang D
						WHERE " . $KONDISI . $AND1 . " 
						AND A.NOMOR_AJU=B.NOMOR_AJU
						AND A.KODE_TRADER=B.KODE_TRADER
						AND A.NOMOR_AJU=C.NOMOR_AJU 
						AND B.KODE_BARANG=C.KODE_BARANG 
						AND B.JNS_BARANG=C.JNS_BARANG 
						AND A.KODE_TRADER=C.KODE_TRADER
						AND C.KODE_BARANG=D.KODE_BARANG 
						AND C.JNS_BARANG=D.JNS_BARANG 
						AND C.KODE_TRADER=D.KODE_TRADER			
						AND A.KODE_TRADER='".$kodeTrader."'
						AND B.SERI = C.SERI_DOKUMEN 
						AND C.KODE_DOKUMEN='BC27' AND C.TIPE = 'GATE-IN' 
						GROUP BY C.SERI_DOKUMEN, B.NOMOR_AJU, C.KONDISI_BARANG ";
						
				$SQL_BC27_BREAK = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, A.NOMOR_DOK_INTERNAL, A.TANGGAL_DOK_INTERNAL,
							A.NAMA_TRADER_ASAL AS 'PEMASOK/PENGIRIM', B.KODE_BARANG, B.URAIAN_BARANG, 
							B.KODE_SATUAN, B.JUMLAH_SATUAN,'-' AS KONDISI_BARANG, B.HARGA_PENYERAHAN  AS NILAI, 'BC27' AS JENIS_DOKUMEN,
							A.NOMOR_AJU, A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
							FROM t_bc27_hdr A, t_bc27_dtl B
							WHERE  " . $KONDISI_BREAK . " AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER
							AND A.KODE_TRADER='".$kodeTrader."' AND B.BREAKDOWN_FLAG='Y'  ";													
				#=== END BC27=============================================================================================
				
				#=== START BC40===========================================================================================
				$SQL_BC40 = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, 
							IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('1',B.NOMOR_AJU,'BC40',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NOMOR_DOK_INTERNAL),A.NOMOR_DOK_INTERNAL) NOMOR_DOK_INTERNAL,
											IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('2',B.NOMOR_AJU,'BC40',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.TANGGAL_DOK_INTERNAL),A.TANGGAL_DOK_INTERNAL) TANGGAL_DOK_INTERNAL,
											IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('3',B.NOMOR_AJU,'BC40',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NAMA_PENGIRIM),A.NAMA_PENGIRIM) 'PEMASOK/PENGIRIM',
						C.KODE_BARANG, B.URAIAN_BARANG,
						CASE D.KODE_SATUAN_TERKECIL 
							WHEN 1 THEN B.KODE_SATUAN
							WHEN '' THEN B.KODE_SATUAN
						ELSE D.KODE_SATUAN_TERKECIL END AS KODE_SATUAN, SUM(C.JUMLAH) JUMLAH_SATUAN, C.KONDISI_BARANG,
						B.HARGA_PENYERAHAN AS 'NILAI','BC40' AS 'JENIS_DOKUMEN', A.NOMOR_AJU, A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
						FROM t_bc40_hdr A, t_bc40_dtl B, m_trader_barang_inout C, m_trader_barang D
						WHERE " . $KONDISI . $AND1 . " 
						AND A.NOMOR_AJU=B.NOMOR_AJU
						AND A.KODE_TRADER=B.KODE_TRADER
						AND A.NOMOR_AJU=C.NOMOR_AJU 
						AND B.KODE_BARANG=C.KODE_BARANG 
						AND B.JNS_BARANG=C.JNS_BARANG 
						AND A.KODE_TRADER=C.KODE_TRADER
						AND C.KODE_BARANG=D.KODE_BARANG 
						AND C.JNS_BARANG=D.JNS_BARANG 
						AND C.KODE_TRADER=D.KODE_TRADER		
						AND A.KODE_TRADER='".$kodeTrader."'
						AND B.SERI = C.SERI_DOKUMEN 
						AND C.KODE_DOKUMEN='BC40' AND C.TIPE = 'GATE-IN' 
						GROUP BY C.SERI_DOKUMEN, C.NOMOR_AJU, C.KONDISI_BARANG ";	
						
				$SQL_BC40_BREAK = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, A.NOMOR_DOK_INTERNAL, A.TANGGAL_DOK_INTERNAL,
									A.NAMA_PENGIRIM AS 'PEMASOK/PENGIRIM', B.KODE_BARANG, B.URAIAN_BARANG, 
									B.KODE_SATUAN, B.JUMLAH_SATUAN, '-' AS KONDISI_BARANG, B.HARGA_PENYERAHAN  AS NILAI, 'BC40' AS JENIS_DOKUMEN,
									A.NOMOR_AJU, A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
									FROM t_bc40_hdr A, t_bc40_dtl B
									WHERE  " . $KONDISI_BREAK . " AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER
									AND A.KODE_TRADER='".$kodeTrader."' AND B.BREAKDOWN_FLAG='Y' ";											
				#=== END BC40=============================================================================================
				
				#=== START BC30===========================================================================================
				$SQL_BC30 = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, 
							IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('1',B.NOMOR_AJU,'BC30',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NOMOR_DOK_INTERNAL),A.NOMOR_DOK_INTERNAL) NOMOR_DOK_INTERNAL,
											IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('2',B.NOMOR_AJU,'BC30',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.TANGGAL_DOK_INTERNAL),A.TANGGAL_DOK_INTERNAL) TANGGAL_DOK_INTERNAL,
											IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('3',B.NOMOR_AJU,'BC30',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NAMA_PEMBELI),A.NAMA_PEMBELI) 'PEMASOK/PENGIRIM',
						C.KODE_BARANG, B.URAIAN_BARANG1 AS URAIAN_BARANG,
						CASE D.KODE_SATUAN_TERKECIL 
							WHEN 1 THEN B.KODE_SATUAN
							WHEN '' THEN B.KODE_SATUAN
						ELSE D.KODE_SATUAN_TERKECIL END AS KODE_SATUAN, SUM(C.JUMLAH) JUMLAH_SATUAN, C.KONDISI_BARANG,
						(A.NDPBM * B.FOB_PER_BARANG) AS 'NILAI','BC30' AS 'JENIS_DOKUMEN', A.NOMOR_AJU, 
						A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
						FROM t_bc30_hdr A, t_bc30_dtl B, m_trader_barang_inout C, m_trader_barang D
						WHERE " . $KONDISI . $AND1 . " 
						AND A.NOMOR_AJU=B.NOMOR_AJU
						AND A.KODE_TRADER=B.KODE_TRADER
						AND A.NOMOR_AJU=C.NOMOR_AJU 
						AND B.KODE_BARANG=C.KODE_BARANG 
						AND B.JNS_BARANG=C.JNS_BARANG 
						AND A.KODE_TRADER=C.KODE_TRADER
						AND C.KODE_BARANG=D.KODE_BARANG 
						AND C.JNS_BARANG=D.JNS_BARANG 
						AND C.KODE_TRADER=D.KODE_TRADER		
						AND A.KODE_TRADER='".$kodeTrader."'
						AND B.SERI = C.SERI_DOKUMEN 
						AND C.KODE_DOKUMEN='BC30' AND C.TIPE = 'GATE-IN' 
						GROUP BY C.SERI_DOKUMEN, C.NOMOR_AJU, C.KONDISI_BARANG ";	
						
				$SQL_BC30_BREAK = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, A.NOMOR_DOK_INTERNAL, A.TANGGAL_DOK_INTERNAL,
									A.NAMA_PEMBELI AS 'PEMASOK/PENGIRIM', B.KODE_BARANG, B.URAIAN_BARANG1 AS URAIAN_BARANG, 
									B.KODE_SATUAN, B.JUMLAH_SATUAN,'-' AS KONDISI_BARANG, (A.NDPBM * B.FOB_PER_BARANG)  AS NILAI, 'BC30' AS JENIS_DOKUMEN,
									A.NOMOR_AJU, A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
									FROM t_bc30_hdr A, t_bc30_dtl B
									WHERE  " . $KONDISI_BREAK . " AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER
									AND A.KODE_TRADER='".$kodeTrader."' AND B.BREAKDOWN_FLAG='Y' ";											
				#=== END BC30=============================================================================================
						
				if($jns_dok){
					$FLAG = $query->row();				
					if($jns_dok=="BC16"){
						foreach($query->result() as $row){
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC16_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC16;	
							}
						}
					}
					elseif($jns_dok=="BC27"){
						foreach($query->result() as $row){
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27;	
							}
						}
					}
					elseif($jns_dok=="BC40"){
						foreach($query->result() as $row){
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC40_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC40;	
							}
						}
					}
					elseif($jns_dok=="BC30"){
						foreach($query->result() as $row){
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC30_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC30;	
							}
						}
					}
				}else{
					foreach ($query->result() as $row) {
						if($row->KODE_DOKUMEN=="BC16"){ 
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC16_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC16;	
							}	
						}
						elseif($row->KODE_DOKUMEN=="BC27"){ 
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27;	
							}	
						}
						elseif($row->KODE_DOKUMEN=="BC40"){ 
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC40_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC40;	
							}	
						}
						elseif($row->KODE_DOKUMEN=="BC30"){ 
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC30_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC30;	
							}	
						}
					}	
				}
				
				//$SQL1 .= " ORDER BY TANGGAL_PENDAFTARAN, NOMOR_PENDAFTARAN, NOMOR_DOK_INTERNAL ASC";
				return $SQL1;
			}else{
				return false;
			}
		}elseif($tipe=="pengeluaran"){
			if ($this->input->post('TIPE_PERIODE') == "REALISASI" || $jenis=="REALISASI") {
				$KONDISI = "DATE_FORMAT(TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
			} elseif ($this->input->post('TIPE_PERIODE') == "DOKUMEN" || $jenis=="DOKUMEN") {
				$KONDISI = "DATE_FORMAT(TANGGAL_DOKUMEN,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
			}
			if(strtolower($_SERVER['REQUEST_METHOD'])=="post") $jns_dok = $kodebarang;
			else $jns_dok = $TIPE_TANGGAL;
        	$jns_dok = str_replace("!", "", $jns_dok);
			if($jns_dok){
				$AND = " AND KODE_DOKUMEN = '".$jns_dok."'";
			}
			$SQL = "SELECT DISTINCT KODE_DOKUMEN, BREAKDOWN_FLAG
					FROM m_trader_barang_inout 
					WHERE ".$KONDISI." AND TIPE = 'GATE-OUT' 
					AND KODE_TRADER = '".$kodeTrader."'".$AND;
			$query = $this->db->query($SQL);
			if ($query->num_rows() > 0) {
				if ($this->input->post('TIPE_PERIODE') == "REALISASI" || $jenis=="REALISASI") {
					$KONDISI = "DATE_FORMAT(C.TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
					$KONDISI_BREAK = "DATE_FORMAT(A.TANGGAL_REALISASI,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
				} elseif ($this->input->post('TIPE_PERIODE') == "DOKUMEN" || $jenis=="DOKUMEN") {
					$KONDISI = "DATE_FORMAT(C.TANGGAL_DOKUMEN,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
					$KONDISI_BREAK = "DATE_FORMAT(A.TANGGAL_PENDAFTARAN,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
				}
				#=== START BC28===========================================================================================
				$SQL_BC28 = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, A.NAMA_IMPORTIR AS 'PEMBELI/PENERIMA', C.KONDISI_BARANG,
				IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('1',B.NOMOR_AJU,'BC28',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NOMOR_DOK_INTERNAL),A.NOMOR_DOK_INTERNAL) NOMOR_DOK_INTERNAL,
						IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('2',B.NOMOR_AJU,'BC28',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.TANGGAL_DOK_INTERNAL),A.TANGGAL_DOK_INTERNAL) TANGGAL_DOK_INTERNAL,
						C.KODE_BARANG, B.URAIAN_BARANG, 
						CASE D.KODE_SATUAN_TERKECIL 
						WHEN 1 THEN B.KODE_SATUAN
						WHEN '' THEN B.KODE_SATUAN
						ELSE D.KODE_SATUAN_TERKECIL END AS KODE_SATUAN, 
						SUM(C.JUMLAH) JUMLAH_SATUAN, 
						B.CIF_RP  AS 'NILAI','BC28' AS 'JENIS_DOKUMEN', A.NOMOR_AJU, A.KODE_TRADER,
						f_trader(A.KODE_TRADER) NAMA_PEMILIK |
						FROM t_bc28_hdr A, t_bc28_dtl B, m_trader_barang_inout C, m_trader_barang D
						WHERE " . $KONDISI . " 
						AND A.NOMOR_AJU=B.NOMOR_AJU
						AND A.KODE_TRADER=B.KODE_TRADER
						AND A.NOMOR_AJU=C.NOMOR_AJU 
						AND B.KODE_BARANG=C.KODE_BARANG 
						AND B.JNS_BARANG=C.JNS_BARANG 
						AND A.KODE_TRADER=C.KODE_TRADER
						AND C.KODE_BARANG=D.KODE_BARANG 
						AND C.JNS_BARANG=D.JNS_BARANG 
						AND C.KODE_TRADER=D.KODE_TRADER	
						AND B.SERI = C.SERI_DOKUMEN 
						AND A.KODE_TRADER='".$kodeTrader."'
						AND C.KODE_DOKUMEN='BC28' AND C.TIPE = 'GATE-OUT' 
						GROUP BY C.SERI_DOKUMEN, B.NOMOR_AJU ";
						
				$SQL_BC28_BREAK = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, A.NOMOR_DOK_INTERNAL, A.TANGGAL_DOK_INTERNAL, A.NAMA_IMPORTIR AS 'PEMBELI/PENERIMA',
							B.KODE_BARANG, B.URAIAN_BARANG, 
							B.KODE_SATUAN, B.JUMLAH_SATUAN, B.CIF_RP  AS NILAI, 'BC28' AS JENIS_DOKUMEN,
							A.NOMOR_AJU, A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
							FROM t_bc28_hdr A, t_bc28_dtl B
							WHERE  " . $KONDISI_BREAK . " AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER
							AND A.KODE_TRADER='".$kodeTrader."' AND B.BREAKDOWN_FLAG='Y' ";											
				#=== END BC28=============================================================================================	
				#=== START BC27===========================================================================================
				$SQL_BC27 = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, C.KONDISI_BARANG,
					IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('1',B.NOMOR_AJU,'BC27',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NOMOR_DOK_INTERNAL),A.NOMOR_DOK_INTERNAL) NOMOR_DOK_INTERNAL,
							IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('2',B.NOMOR_AJU,'BC27',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.TANGGAL_DOK_INTERNAL),A.TANGGAL_DOK_INTERNAL) TANGGAL_DOK_INTERNAL,
							IF(A.PARSIAL_FLAG='Y',IFNULL(f_dokinternal('3',B.NOMOR_AJU,'BC27',C.KODE_TRADER,C.KODE_BARANG,C.JNS_BARANG,C.JUMLAH,B.KODE_SATUAN),A.NAMA_TRADER_ASAL),A.NAMA_TRADER_ASAL) 'PEMBELI/PENERIMA',
						C.KODE_BARANG, B.URAIAN_BARANG, 
						CASE D.KODE_SATUAN_TERKECIL 
						WHEN 1 THEN B.KODE_SATUAN
						WHEN '' THEN B.KODE_SATUAN
						ELSE D.KODE_SATUAN_TERKECIL END AS KODE_SATUAN, SUM(C.JUMLAH) JUMLAH_SATUAN, 
						B.HARGA_PENYERAHAN  AS 'NILAI','BC27' AS 'JENIS_DOKUMEN', A.NOMOR_AJU, A.KODE_TRADER,
						f_trader(A.KODE_TRADER) NAMA_PEMILIK |
						FROM t_bc27_hdr A, t_bc27_dtl B, m_trader_barang_inout C, m_trader_barang D
						WHERE " . $KONDISI . " 
						AND A.NOMOR_AJU=B.NOMOR_AJU
						AND A.KODE_TRADER=B.KODE_TRADER
						AND A.NOMOR_AJU=C.NOMOR_AJU 
						AND B.KODE_BARANG=C.KODE_BARANG 
						AND B.JNS_BARANG=C.JNS_BARANG 
						AND A.KODE_TRADER=C.KODE_TRADER
						AND C.KODE_BARANG=D.KODE_BARANG 
						AND C.JNS_BARANG=D.JNS_BARANG 
						AND C.KODE_TRADER=D.KODE_TRADER			
						AND A.KODE_TRADER='".$kodeTrader."'
						AND B.SERI = C.SERI_DOKUMEN 
						AND C.KODE_DOKUMEN='BC27' AND C.TIPE = 'GATE-OUT' 
						GROUP BY C.SERI_DOKUMEN, B.NOMOR_AJU ";
						
				$SQL_BC27_BREAK = "SELECT A.NOMOR_PENDAFTARAN |, A.TANGGAL_PENDAFTARAN, A.NOMOR_DOK_INTERNAL, A.TANGGAL_DOK_INTERNAL,
							A.NAMA_TRADER_ASAL AS 'PEMBELI/PENERIMA', B.KODE_BARANG, B.URAIAN_BARANG, 
							B.KODE_SATUAN, B.JUMLAH_SATUAN, B.HARGA_PENYERAHAN  AS NILAI, 'BC27' AS JENIS_DOKUMEN,
							A.NOMOR_AJU, A.KODE_TRADER, f_trader(A.KODE_TRADER) NAMA_PEMILIK |
							FROM t_bc27_hdr A, t_bc27_dtl B
							WHERE  " . $KONDISI_BREAK . " AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER
							AND A.KODE_TRADER='".$kodeTrader."' AND B.BREAKDOWN_FLAG='Y'  ";													
				#=== END BC27=============================================================================================
				if($jns_dok){
					$FLAG = $query->row();				
					if($jns_dok=="BC28"){
						foreach($query->result() as $row){
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC28_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC28;	
							}
						}
					}elseif($jns_dok=="BC27"){
						foreach($query->result() as $row){
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27;	
							}
						}
					}
				}else{
					foreach ($query->result() as $row) {
						if($row->KODE_DOKUMEN=="BC28"){ 
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC28_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC28;	
							}	
						}elseif($row->KODE_DOKUMEN=="BC27"){ 
							if($row->BREAKDOWN_FLAG=='Y'){
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27_BREAK;	
							}else{
								if ($SQL1) $SQL1.=" UNION ALL  ";
								$SQL1 .= $SQL_BC27;	
							}	
						}
					}
				}
				$SQL1 .= " ORDER BY TANGGAL_PENDAFTARAN, NOMOR_PENDAFTARAN, NOMOR_DOK_INTERNAL ASC";
				return $SQL1;
			}else{
				return false;
			}
		}else if($tipe == 'pemusnahan') {
			$kodebarang = str_replace("!", "", $kodebarang);
			if ($kodebarang){
				$addKDbrg = " AND A.KODE_BARANG = '" . $kodebarang . "'";
			}
			$SQL = "SELECT DATE_FORMAT(A.TANGGAL_PEMUSNAHAN, '%d %M %Y') 'TGL', A.KODE_BARANG 'KDBARANG', B.URAIAN_BARANG 'URAIBARANG', 
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'URAIJENIS', A.JUMLAH, f_satuan(A.KODE_SATUAN) 'SATUAN', A.KETERANGAN , A.KODE_TRADER
					FROM T_PEMUSNAHAN_BRG A LEFT JOIN M_TRADER_BARANG B ON B.KODE_BARANG=A.KODE_BARANG AND B.KODE_TRADER=A.KODE_TRADER 
					WHERE A.KODE_TRADER =" . $kodeTrader . $addKDbrg . " 
					AND ". "DATE_FORMAT(A.TANGGAL_PEMUSNAHAN,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'
					ORDER BY A.TANGGAL_PEMUSNAHAN DESC";
			return $SQL;
		}elseif($tipe == "mutasi"){
			$SQH = "SELECT A.ID FROM r_trader_mutasi A WHERE A.TANGGAL_AWAL ='" . $tglAwal . "' AND A.TANGGAL_AKHIR = '" . $tglAkhir . "' AND A.KODE_TRADER='" . $kodeTrader . "' ";	
			$SQH .= " LIMIT 1 ";
            $query = $this->db->query($SQH);
            if ($query->num_rows() == 0) {
				$SQL = "SELECT A.KODE_BARANG |, A.JNS_BARANG, B.URAIAN_BARANG, 
				 		IF(B.KODE_SATUAN_TERKECIL='' OR B.KODE_SATUAN_TERKECIL IS NULL,B.KODE_SATUAN,B.KODE_SATUAN_TERKECIL) KODE_SATUAN,  
						'' PENYESUAIAN, A.KODE_TRADER |
                        FROM m_trader_barang_inout A, m_trader_barang B
                        WHERE A.KODE_TRADER=B.KODE_TRADER AND A.KODE_BARANG = B.KODE_BARANG
                        AND A.JNS_BARANG = B.JNS_BARANG AND DATE_FORMAT(A.TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'
                        AND A.KODE_TRADER ='" . $kodeTrader . "'";
				$SQL .= " GROUP BY A.KODE_BARANG, A.JNS_BARANG";
				if (!$jenis){
                    $SQL .= " ORDER BY A.KODE_BARANG, A.JNS_BARANG";
                }
			}else{
				if ($jenis) {
                	$SQL = "SELECT A.KODE_BARANG |,A.JNS_BARANG,B.URAIAN_BARANG,
							IF(B.KODE_SATUAN_TERKECIL='' OR B.KODE_SATUAN_TERKECIL IS NULL,B.KODE_SATUAN,B.KODE_SATUAN_TERKECIL) KODE_SATUAN, 
							A.PENYESUAIAN, A.KODE_TRADER |
							 FROM r_trader_mutasi A, m_trader_barang B
							 WHERE A.TANGGAL_AWAL ='" . $tglAwal . "' AND A.TANGGAL_AKHIR = '" . $tglAkhir . "'
							 AND A.KODE_TRADER='" . $kodeTrader . "'
							 AND A.KODE_TRADER=B.KODE_TRADER
							 AND A.KODE_BARANG=B.KODE_BARANG 
							 AND A.JNS_BARANG=B.JNS_BARANG ";
                }else {
                    $SQL = "SELECT 	A.ID |,A.TANGGAL_AWAL,A.TANGGAL_AKHIR,A.KODE_TRADER,A.KODE_BARANG,A.JNS_BARANG,
							A.PERIODE_SALDO_AWAL,A.JUMLAH_SALDO_AWAL,A.PEMASUKAN,A.PENGELUARAN,A.PENYESUAIAN,
							A.PERIODE_SALDO_AKHIR,A.JUMLAH_SALDO_AKHIR,A.PERIODE_STOCK_OPNAME,A.STOCK_OPNAME,
						 	A.SELISIH,A.KETERANGAN,B.URAIAN_BARANG,B.KODE_SATUAN |						 
						 	FROM r_trader_mutasi A, m_trader_barang B
						 	WHERE A.TANGGAL_AWAL ='" . $tglAwal . "' AND A.TANGGAL_AKHIR = '" . $tglAkhir . "'
						 	AND A.KODE_TRADER='" . $kodeTrader . "'
						 	AND A.KODE_TRADER=B.KODE_TRADER  
						 	AND A.KODE_BARANG=B.KODE_BARANG 
						 	AND A.JNS_BARANG=B.JNS_BARANG ";
                    $SQL .= " ORDER BY A.KODE_BARANG, A.JNS_BARANG";
                }	
			}
			return $SQL;
		}elseif($tipe == "pembelian"){
			$SQL = "SELECT f_ref('DOKUMEN_UTAMA',A.KODE_DOKUMEN) AS JENIS_DOKUMEN, A.NOMOR AS NO_DOK, A.TANGGAL AS TGL_DOK, 
					B.NAMA_PENGIRIM, B.NAMA_PEMILIK, C.KODE_BARANG, D.URAIAN_BARANG, 
					CASE E.KODE_SATUAN_TERKECIL 
						WHEN 1 THEN D.KODE_SATUAN
						WHEN '' THEN D.KODE_SATUAN
					ELSE E.KODE_SATUAN_TERKECIL END AS KODE_SATUAN, 
					C.JUMLAH, B.KODE_HARGA, B.JENIS_NILAI, B.KODE_VALUTA, D.NILAI
					FROM t_bc16_dok A 
						INNER JOIN t_bc16_hdr B ON A.KODE_TRADER = B.KODE_TRADER AND A.NOMOR_AJU = B.NOMOR_AJU 
						INNER JOIN t_bc16_dtl D ON D.KODE_TRADER = B.KODE_TRADER AND D.NOMOR_AJU = B.NOMOR_AJU 
						INNER JOIN m_trader_barang_inout C ON C.KODE_TRADER = D.KODE_TRADER AND C.NOMOR_AJU = D.NOMOR_AJU 
						AND C.SERI_DOKUMEN = D.SERI AND C.KODE_BARANG = D.KODE_BARANG AND C.JNS_BARANG = D.JNS_BARANG 
						INNER JOIN m_trader_barang E ON E.KODE_TRADER = C.KODE_TRADER AND E.KODE_BARANG = C.KODE_BARANG 
						AND E.JNS_BARANG = C.JNS_BARANG
					WHERE B.KODE_TRADER = '".$kodeTrader."' AND A.KODE_DOKUMEN = '380' AND 
						DATE_FORMAT(C.TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
			return $SQL;
		}elseif($tipe == "penjualan"){
			$SQL = "SELECT f_ref('DOKUMEN_UTAMA',A.KODE_DOKUMEN) AS JENIS_DOKUMEN, A.NOMOR AS NO_DOK, A.TANGGAL AS TGL_DOK, 
					B.NAMA_PENGUSAHA, B.NAMA_PEMILIK, C.KODE_BARANG, D.URAIAN_BARANG, 
					CASE E.KODE_SATUAN_TERKECIL 
						WHEN 1 THEN D.KODE_SATUAN
						WHEN '' THEN D.KODE_SATUAN
					ELSE E.KODE_SATUAN_TERKECIL END AS KODE_SATUAN, 
					C.JUMLAH, B.NILAI, B.JENIS_NILAI, B.KODE_VALUTA, D.CIF
					FROM t_bc28_dok A 
						INNER JOIN t_bc28_hdr B ON A.KODE_TRADER = B.KODE_TRADER AND A.NOMOR_AJU = B.NOMOR_AJU 
						INNER JOIN t_bc28_dtl D ON D.KODE_TRADER = B.KODE_TRADER AND D.NOMOR_AJU = B.NOMOR_AJU 
						INNER JOIN m_trader_barang_inout C ON C.KODE_TRADER = D.KODE_TRADER AND C.NOMOR_AJU = D.NOMOR_AJU 
						AND C.SERI_DOKUMEN = D.SERI AND C.KODE_BARANG = D.KODE_BARANG AND C.JNS_BARANG = D.JNS_BARANG 
						INNER JOIN m_trader_barang E ON E.KODE_TRADER = C.KODE_TRADER AND E.KODE_BARANG = C.KODE_BARANG 
						AND E.JNS_BARANG = C.JNS_BARANG
					WHERE B.KODE_TRADER = '".$kodeTrader."' AND A.KODE_DOKUMEN = '380' AND 
						DATE_FORMAT(C.TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
			return $SQL;
		}
	}
	
	function proses_form($tipe,$jenis){
		$func =&get_instance();
		$func->load->model("main", "main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		if($jenis=='add'){
			if($tipe=='mutasi'){
				$banyakData=$this->input->post('BANYAKDATA');
				$PERIODE_SALDO_AWAL=$this->input->post('PERIODE_SALDO_AWAL');
				$PERIODE_SALDO_AKHIR=$this->input->post('PERIODE_SALDO_AKHIR');
				$TANGGAL_AWAL=$this->input->post('TANGGAL_AWAL');
				$TANGGAL_AKHIR=$this->input->post('TANGGAL_AKHIR');
				$PERIODE_STOCK_OPNAME=$this->input->post('PERIODE_STOCK_OPNAME');
				$ID = (int)$func->main->get_uraian("SELECT MAX(ID) AS ID FROM R_TRADER_MUTASI", "ID") + 1;
				$SQLSELECT="SELECT TANGGAL_AWAL,TANGGAL_AKHIR FROM R_TRADER_MUTASI WHERE TANGGAL_AWAL='".$TANGGAL_AWAL."' AND
								TANGGAL_AKHIR='".$TANGGAL_AKHIR."' AND KODE_TRADER='".$KODE_TRADER."' GROUP BY TANGGAL_AWAL,TANGGAL_AKHIR";
				$getTgl=$this->db->query($SQLSELECT)->row();
				if(($getTgl->TANGGAL_AWAL==$TANGGAL_AWAL) || ($getTgl->TANGGAL_AKHIR==$TANGGAL_AKHIR)){
					return "MSG#ERR#Simpan data Mutasi Bahan Baku Gagal,Tanggal Periode Sudah Pernah Digunakan#";	
				}else{
					for($x=1;$x<=$banyakData;$x++){
					$KODE_BARANG=$this->input->post("KODE_BARANG_".$x);
					$JNS_BARANG=$this->input->post("JNS_BARANG_".$x);
					$JUMLAH_SALDO_AWAL=$this->input->post("JUMLAH_SALDO_AWAL_".$x);
					$PENGELUARAN=$this->input->post("PENGELUARAN_".$x);
					$PEMASUKAN=$this->input->post("PEMASUKAN_".$x);
					$PENYESUAIAN=$this->input->post("PENYESUAIAN_".$x);
					$JUMLAH_SALDO_AKHIR=$this->input->post("JUMLAH_SALDO_AKHIR_".$x);
					$STOCKOPNAME=$this->input->post("STOCKOPNAME_".$x);	
					$SELISIH=$this->input->post("SELISIH_".$x);
					$KETERANGAN=$this->input->post("KETERANGAN_".$x);
					$SQLINSERT="INSERT INTO r_trader_mutasi(ID,TANGGAL_AWAL,TANGGAL_AKHIR,KODE_TRADER,KODE_BARANG,
								JNS_BARANG,PERIODE_SALDO_AWAL,JUMLAH_SALDO_AWAL,PEMASUKAN,PENGELUARAN,PENYESUAIAN,
								PERIODE_SALDO_AKHIR,JUMLAH_SALDO_AKHIR,PERIODE_STOCK_OPNAME,STOCK_OPNAME,SELISIH,KETERANGAN) 
								VALUES('".$ID."','".$TANGGAL_AWAL."','".$TANGGAL_AKHIR."',
								'".$KODE_TRADER."',".$this->db->escape($KODE_BARANG).",'".$JNS_BARANG."',
								'".$PERIODE_SALDO_AWAL."','".str_replace(",","",$JUMLAH_SALDO_AWAL)."',
								'".str_replace(",","",$PEMASUKAN)."','".str_replace(",","",$PENGELUARAN)."',
								'".str_replace(",","",$PENYESUAIAN)."','".$PERIODE_SALDO_AKHIR."',
								'".str_replace(",","",$JUMLAH_SALDO_AKHIR)."','".$PERIODE_STOCK_OPNAME."',
								'".str_replace(",","",$STOCKOPNAME)."','".str_replace(",","",$SELISIH)."',
								'".$KETERANGAN."')";
	
					$exec=$this->db->query($SQLINSERT);
					$ID++;
					}
					if($exec){
						$func->main->activity_log('SAVE LAPORAN','MUTASI, PERIODE '.$TANGGAL_AWAL.'-'.$TANGGAL_AKHIR);
						return "MSG#OK#Simpan data Mutasi Bahan Baku Berhasil#";
					}else{					
						return "MSG#ERR#Simpan data Mutasi Bahan Baku Gagal#";	
					}
				}
			}
		}elseif($jenis=='edit'){
			if($tipe=='mutasi'){
				$banyakData=$this->input->post('BANYAKDATA');//echo $banyakData;exit;
				$TANGGAL_AWAL=$this->input->post('TANGGAL_AWAL');
				$TANGGAL_AKHIR=$this->input->post('TANGGAL_AKHIR');
				for($x=1;$x<=$banyakData;$x++){
					$KODE_BARANG=$this->input->post("KODE_BARANG_".$x);
					$JNS_BARANG=$this->input->post("JNS_BARANG_".$x);
					$JUMLAH_SALDO_AWAL=$this->input->post("JUMLAH_SALDO_AWAL_".$x);
					$PENGELUARAN=$this->input->post("PENGELUARAN_".$x);
					$PEMASUKAN=$this->input->post("PEMASUKAN_".$x);
					$PENYESUAIAN=$this->input->post("PENYESUAIAN_".$x);
					$JUMLAH_SALDO_AKHIR=$this->input->post("JUMLAH_SALDO_AKHIR_".$x);
					$STOCKOPNAME=$this->input->post("STOCKOPNAME_".$x);	
					$SELISIH=$this->input->post("SELISIH_".$x);
					$KETERANGAN=$this->input->post("KETERANGAN_".$x);
					$SQLUPDATE = "UPDATE R_TRADER_MUTASI SET JUMLAH_SALDO_AWAL = ".$this->db->escape($JUMLAH_SALDO_AWAL).",
									   PENGELUARAN = ".$this->db->escape($PENGELUARAN).",
									   PEMASUKAN = ".$this->db->escape($PEMASUKAN).",
									   JUMLAH_SALDO_AKHIR = ".$this->db->escape($JUMLAH_SALDO_AKHIR).",
									   STOCK_OPNAME = ".$this->db->escape($STOCKOPNAME).",
									   SELISIH = ".$this->db->escape($SELISIH).",
									   KETERANGAN = ".$this->db->escape($KETERANGAN)."
								 WHERE TANGGAL_AWAL=".$this->db->escape($TANGGAL_AWAL)." 
								       AND TANGGAL_AKHIR=".$this->db->escape($TANGGAL_AKHIR)."
									   AND KODE_BARANG=".$this->db->escape($KODE_BARANG)."
									   AND JNS_BARANG=".$this->db->escape($JNS_BARANG)."
									   AND KODE_TRADER=".$this->db->escape($KODE_TRADER)."";//echo $sql;	
	
					$exec=$this->db->query($SQLUPDATE);
					}
					if($exec){
					    $func->main->activity_log('UPDATE LAPORAN','MUTASI, PERIODE '.$TANGGAL_AWAL.'-'.$TANGGAL_AKHIR);
						return "MSG#OK#Ubah data Mutasi Bahan Baku Berhasil#";
					}else{					
						return "MSG#ERR#Ubah data Mutasi Bahan Baku Gagal#";	
					}
			}
		}
	}
	
	function getTglStock($tglAwal,$tglAkhir){
		$ARRTGLSTOCK="";
		$sqlGetDataTgl ="SELECT TANGGAL_STOCK FROM m_trader_stockopname
						WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' 
						AND TANGGAL_STOCK BETWEEN '".$tglAwal."' AND '". $tglAkhir."' 
					    GROUP BY TANGGAL_STOCK ORDER BY TANGGAL_STOCK DESC";
	   	$STOCKKK=$this->db->query($sqlGetDataTgl);
		if($STOCKKK->num_rows()>0){
			$DATA = $STOCKKK->row();
			$ARRTGLSTOCK = $DATA->TANGGAL_STOCK;
		}	
		return $ARRTGLSTOCK; 		
	}
	
	function list_laporan($tipe="",$act=""){
		$conn = get_instance();
		$conn->load->model("main");
		$this->load->library('newtable');
		$idTrader = $this->newsession->userdata("KODE_TRADER");
		if($tipe=='mutasi'){
			$namaTabel='R_TRADER_MUTASI';
			$judul="List Laporan Pertanggungjawaban Mutasi Barang";
		}
		$ADDSQL="";
		if($this->input->post('ajax')){
			$POSTURI = $this->input->post("uri");
			$TEMPSQL = "SELECT TANGGAL_AWAL 'PERIODE AWAL',TANGGAL_AKHIR 'PERIODE AKHIR',COUNT(*) 'JUMLAH',
						KODE_TRADER FROM ".$namaTabel."
			            WHERE KODE_TRADER ='".$idTrader. "' GROUP BY TANGGAL_AWAL,TANGGAL_AKHIR";
			$ADDSQL = $conn->main->getWhere($TEMPSQL,$POSTURI,array("TANGGAL_AWAL;TANGGAL_AKHIR;"));
		}	   
	   	$SQL= "SELECT TANGGAL_AWAL 'PERIODE AWAL',TANGGAL_AKHIR 'PERIODE AKHIR',COUNT(*) 'JUMLAH',
			   KODE_TRADER FROM ".$namaTabel."
			   WHERE KODE_TRADER ='".$idTrader. "'".$ADDSQL." GROUP BY TANGGAL_AWAL,TANGGAL_AKHIR";
	  
		$this->newtable->show_chk(false);
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
		$this->newtable->action(site_url()."/laporan/tipe_laporan/".$tipe);	
		$this->newtable->search(array(array('TANGGAL_AWAL;TANGGAL_AKHIR;', 'PERIODE&nbsp;&nbsp;', 'tag-tanggal-2field')));	
		$this->newtable->hiddens(array("KODE_TRADER"));
		$this->newtable->keys(array("PERIODE AWAL","PERIODE AKHIR"));
		$this->newtable->detail_tipe('detil_priview');
		$this->newtable->detail(site_url()."/laporan/tipe_laporan/".$tipe);
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("f".$tipe);
		$this->newtable->set_divid("div".$tipe);
		$this->newtable->rowcount(10);
		$this->newtable->clear(); 
        $this->newtable->show_action(TRUE);
       	$this->newtable->tombol_action(array('Hapus' => array('ajax', site_url() . "/laporan/set_laporan/" . $tipe, 'delete')));
		$this->newtable->menu($prosesnya);
		$tabel .= $this->newtable->generate($SQL);			
		$arrdata = array("title" => $title,
						 "judul" => $judul,
						 "tabel" => $tabel
						);
		if($this->input->post("ajax") || $act == "ajax") return $tabel;				 
		else return $arrdata;	
	}
	
	function set_laporan($tipe = "") {
        $func = &get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $key = $this->input->post('key');
        $act = $this->input->post('act');
        if ($act == "delete") {
            $ret = "MSG#ERR#Hapus data Barang Gagal#";
            if ($tipe == "mutasi") {
                $key = explode("|", $key);
                $TANGGAL_AWAL = $key[0];
                $TANGGAL_AKHIR = $key[1];
                $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'TANGGAL_AWAL' => $TANGGAL_AWAL, 'TANGGAL_AKHIR' => $TANGGAL_AKHIR));
                if ($this->db->delete('r_trader_mutasi')) {
                    $func->main->activity_log('DELETE LAPORAN MUTASI BAHAN BAKU & PENOLONG', 'PERIODE ' . $TANGGAL_AWAL . ' SD ' . $TANGGAL_AKHIR);
                    $ret = "MSG#OK#Hapus data Barang Berhasil#" . site_url() . "/laporan/list_laporan/" . $tipe . "/ajax#";
                }
            }
            echo $ret;
        }
    }
	
	function query_pemasukan($tglAwal="",$tglAkhir="",$TIPE_PERIODE="",$ALL_SALDO='',$WHERE = NULL, $FLAG){	
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');					
		$SQL = "SELECT A.LOGID LOGID_IN, A.JENIS_DOK JENIS_DOK_IN, A.NO_DOK NO_DOK_IN, A.TGL_DOK TGL_DOK_IN, 
				A.TGL_MASUK TGL_MASUK_IN, A.KODE_BARANG KODE_BARANG_IN, A.JNS_BARANG JNS_BARANG_IN, 
				A.SERI_BARANG SERI_BARANG_IN, A.NAMA_BARANG NAMA_BARANG_IN, A.SATUAN SATUAN_IN, A.JUMLAH JUMLAH_IN, 
				A.NILAI_PABEAN NILAI_PABEAN_IN, A.FLAG_TUTUP, A.SALDO				
				FROM t_logbook_pemasukan A 
				INNER JOIN m_trader_barang C ON A.KODE_BARANG = C.KODE_BARANG AND A.JNS_BARANG = C.JNS_BARANG AND A.KODE_TRADER = C.KODE_TRADER 
				WHERE A.KODE_TRADER = '".$KODE_TRADER."' AND C.STATUS = '1' ";
			
		if($TIPE_PERIODE=="IN"){
			$SQL.=" AND A.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."'";
		}
		
		if($FLAG=='FIRST'){
			$SQL.=" AND A.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."'";
		}
		
		if($WHERE){			
			$SQL .= ($WHERE != '') ? 'AND  '.$WHERE : '';
			$SQL .= " GROUP BY A.LOGID";	
		}	
		
		if(!$ALL_SALDO){
			$SQL.=" ORDER BY A.TGL_DOK, A.NO_DOK, A.SERI_BARANG, A.TGL_MASUK, A.KODE_BARANG";				
		}
		
		$sql = $this->db->query($SQL);								
		return $sql->result_array();
	}
	
	
	function query_pengeluaran($tglAwal="",$tglAkhir="",$TIPE_PERIODE="",$ALL_SALDO='',$WHERE = NULL,$FLAG){	
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');					
		$SQL = "SELECT B.LOGID LOGID_OUT, B.JENIS_DOK JENIS_DOK_OUT, B.NO_DOK NO_DOK_OUT, B.TGL_DOK TGL_DOK_OUT, 
				B.TGL_MASUK TGL_MASUK_OUT, B.KODE_BARANG KODE_BARANG_OUT, B.JNS_BARANG JNS_BARANG_OUT, 
				B.SERI_BARANG SERI_BARANG_OUT, B.NAMA_BARANG NAMA_BARANG_OUT, B.SATUAN SATUAN_OUT, B.JUMLAH JUMLAH_OUT, 
				B.SERI_BARANG_MASUK, B.NILAI_PABEAN NILAI_PABEAN_OUT, 
				B.NO_DOK_MASUK NO_DOK_MASUK_OUT, B.TGL_DOK_MASUK TGL_DOK_MASUK_OUT, 
				B.JENIS_DOK_MASUK JENIS_DOK_MASUK_OUT, B.LOGID_MASUK				
				FROM t_logbook_pengeluaran B WHERE B.KODE_TRADER = '".$KODE_TRADER."' ";
			
		if($TIPE_PERIODE=="OUT"){
			$SQL.=" AND B.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."'";
		}		
		
		if($FLAG=='SECOND'){
			$SQL.=" AND B.TGL_DOK BETWEEN '".$tglAwal."' AND '". $tglAkhir."'";
		}
		
		if($WHERE){			
			$SQL .= ($WHERE != '') ? 'AND  '.$WHERE : '';
			$SQL .= " GROUP BY B.LOGID";	
		}	
		
		if(!$ALL_SALDO){
			$SQL.=" ORDER BY B.TGL_DOK, B.NO_DOK, B.SERI_BARANG, B.TGL_MASUK, B.KODE_BARANG";
		}	
		
		$sql = $this->db->query($SQL);								
		return $sql->result_array();
	}
	
	function query_any_saldo_in($tglAwal="",$tglAkhir="",$code=""){	
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$SQL = "SELECT A.LOGID LOGID_IN, A.JENIS_DOK JENIS_DOK_IN, A.NO_DOK NO_DOK_IN, A.TGL_DOK TGL_DOK_IN, 
				A.TGL_MASUK TGL_MASUK_IN, A.KODE_BARANG KODE_BARANG_IN, A.JNS_BARANG JNS_BARANG_IN, 
				A.SERI_BARANG SERI_BARANG_IN, A.NAMA_BARANG NAMA_BARANG_IN, A.SATUAN SATUAN_IN, A.JUMLAH JUMLAH_IN, 
				A.NILAI_PABEAN NILAI_PABEAN_IN, A.FLAG_TUTUP, A.SALDO				
				FROM t_logbook_pemasukan A WHERE A.KODE_TRADER = '".$KODE_TRADER."' 
				AND A.LOGID NOT IN ('".$code."') AND A.SALDO > 0 
				AND A.JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') AND A.TGL_DOK <= '". $tglAkhir."' 
				ORDER BY TGL_DOK_IN, NO_DOK_IN,  SERI_BARANG_IN,  TGL_MASUK_IN, KODE_BARANG_IN";
										
		$sql = $this->db->query($SQL);								
		return $sql->result_array();
	}
	
	function query_any_saldo_out($tglAwal="",$tglAkhir="",$code=""){	
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		$SQL = "SELECT B.LOGID LOGID_OUT, B.JENIS_DOK JENIS_DOK_OUT, B.NO_DOK NO_DOK_OUT, B.TGL_DOK TGL_DOK_OUT, 
				B.TGL_MASUK TGL_MASUK_OUT, B.KODE_BARANG KODE_BARANG_OUT, B.JNS_BARANG JNS_BARANG_OUT, 
				B.SERI_BARANG SERI_BARANG_OUT, B.NAMA_BARANG NAMA_BARANG_OUT, B.SATUAN SATUAN_OUT, B.JUMLAH JUMLAH_OUT, 
				B.SERI_BARANG_MASUK, B.NILAI_PABEAN NILAI_PABEAN_OUT, 
				B.NO_DOK_MASUK NO_DOK_MASUK_OUT, B.TGL_DOK_MASUK TGL_DOK_MASUK_OUT, 
				B.JENIS_DOK_MASUK JENIS_DOK_MASUK_OUT, B.LOGID_MASUK				
				FROM t_logbook_pengeluaran B JOIN t_logbook_pemasukan A
				ON B.LOGID_MASUK = A.LOGID
				AND B.KODE_TRADER = A.KODE_TRADER
				WHERE B.KODE_TRADER = '".$KODE_TRADER."' 
				AND B.LOGID_MASUK NOT IN ('".$code."') AND A.SALDO > 0 
				AND A.JENIS_DOK NOT IN ('PROCESS_IN','PROCESS_OUT','SCRAP') AND B.TGL_DOK <= '". $tglAkhir."' 
				ORDER BY A.TGL_DOK, A.NO_DOK,  A.SERI_BARANG, A.TGL_MASUK, A.KODE_BARANG";
				
		$sql = $this->db->query($SQL);								
		return $sql->result_array();
	}
	
}
?>
