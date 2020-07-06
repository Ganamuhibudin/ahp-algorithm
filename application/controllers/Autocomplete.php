<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller{
	/*function Autocomplete(){
		parent::Controller();
	}	*/
	
	function index(){}
	
	function kpbc(){
		$key = strtolower($_REQUEST['q']);
		$this->load->model('main');
		$data = "SELECT KODE_KPBC,URAIAN_KPBC FROM M_KPBC WHERE (LOWER(KODE_KPBC) LIKE '%$key%' OR LOWER(URAIAN_KPBC) LIKE '%$key%') LIMIT 10";
		$res = $this->main->get_result($data);
		if($res){
			foreach($data->result_array() as $row){
				echo "<b>".strtoupper($row['KODE_KPBC'])."</b><br>".strtoupper($row['URAIAN_KPBC'])."|".strtoupper($row['KODE_KPBC'])."|".ucwords(strtolower($row['URAIAN_KPBC']))."\n";
			}
		}
		echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function hanggar(){
		$key = strtolower($_REQUEST['q']);
		$this->load->model('main');
		$data = "SELECT KODE_HANGGAR,URAIAN_HANGGAR FROM M_HANGGAR WHERE (LOWER(KODE_HANGGAR) LIKE '%$key%' OR LOWER(URAIAN_HANGGAR) LIKE '%$key%') LIMIT 10";
		$res = $this->main->get_result($data);
		if($res){
			foreach($data->result_array() as $row){
				echo "<b>".strtoupper($row['KODE_HANGGAR'])."</b><br>".strtoupper($row['URAIAN_HANGGAR'])."|".strtoupper($row['KODE_HANGGAR'])."|".ucwords(strtolower($row['URAIAN_HANGGAR']))."\n";
			}
		}
		echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function valuta(){
		$key = strtolower($_REQUEST['q']);
		$this->load->model('main');
		$data = "SELECT KODE_VALUTA, URAIAN_VALUTA FROM M_VALUTA WHERE (LOWER(KODE_VALUTA) LIKE '%$key%' OR LOWER(URAIAN_VALUTA) LIKE '%$key%') LIMIT 10";
		$res = $this->main->get_result($data);
		if($res){
			foreach($data->result_array() as $row){
				echo "<b>".strtoupper($row['KODE_VALUTA'])."</b><br>".strtoupper($row['URAIAN_VALUTA'])."|".strtoupper($row['KODE_VALUTA'])."|".ucwords(strtolower($row['URAIAN_VALUTA']))."\n";
			}
		}
		echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	function valuta_BC30(){
		$key = strtolower($_REQUEST['q']);
		$this->load->model('main');
		$data = "SELECT KODE_VALUTA, URAIAN_VALUTA FROM M_VALUTA WHERE (LOWER(KODE_VALUTA) LIKE '%$key%' OR LOWER(URAIAN_VALUTA) LIKE '%$key%') LIMIT 10";
		$res = $this->main->get_result($data);
		if($res){
			foreach($data->result_array() as $row){
				echo "<b>".strtoupper($row['KODE_VALUTA'])."</b><br>".strtoupper($row['URAIAN_VALUTA'])."|".strtoupper($row['KODE_VALUTA'])."|".ucwords(strtolower($row['URAIAN_VALUTA']))."|".ucwords(strtoupper($row['KODE_VALUTA']))."\n";
			}
		}
		echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function barang(){
		$key = strtolower($_REQUEST['q']);
		$this->load->model('main');
		$data = "SELECT KODE_BARANG, URAIAN_BARANG, MERK, TIPE, SPFLAIN, UKURAN FROM M_TRADER_BARANG WHERE (LOWER(KODE_BARANG) LIKE '%$key%' OR LOWER(URAIAN_BARANG) LIKE '%$key%') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
		//$data .= " AND KODE_TRADER = '".$_SESSION['TPB_KODETRADER']."' ";
		$res = $this->main->get_result($data);
		if($res){
			foreach($data->result_array() as $row){
				echo "<b>".strtoupper($row['KODE_BARANG'])."</b><br>".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['MERK'])."|".strtoupper($row['TIPE'])."|".strtoupper($row['SPFLAIN'])."|".strtoupper($row['KODE_BARANG'])."|".strtoupper($row['UKURAN'])."\n";
			}
		}
		echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function barang_ALL(){
		$key = strtolower($_REQUEST['q']);
		$this->load->model('main');
		$data ="SELECT KODE_TRADER ,KODE_BARANG ,f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JenisBarang',JNS_BARANG,
			   URAIAN_BARANG,MERK,TIPE,UKURAN,SPFLAIN,FORMAT(STOCK_AKHIR,0) 'StockAkhir',KODE_HS,SERI
			   FROM M_TRADER_BARANG  WHERE (LOWER(KODE_BARANG) LIKE '%$key%' OR LOWER(URAIAN_BARANG) LIKE '%$key%') 
			   AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
		//echo $data;$die();
		//$data .= " AND KODE_TRADER = '".$_SESSION['TPB_KODETRADER']."' ";
		$res = $this->main->get_result($data);
		if($res){
			foreach($data->result_array() as $row){
				echo "<b>".strtoupper($row['KODE_BARANG'])." - ".strtoupper($row['JENIS_BARANG'])."</b><br>".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['KODE_BARANG'])."|".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['MERK'])."|".strtoupper($row['TIPE'])."|".strtoupper($row['UKURAN'])."|".strtoupper($row['SPFLAIN'])."|".strtoupper($row['JNS_BARANG'])."|".strtoupper($row['KODE_HS'])."|".strtoupper($row['SERI'])."\n";
			}
		}
		echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	function barang_bc23(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_BARANG, URAIAN_BARANG, MERK, TIPE, SPFLAIN, f_ref('ASAL_JENIS_BARANG',JNS_BARANG) JENIS_BARANG, JNS_BARANG FROM M_TRADER_BARANG  WHERE (LOWER(KODE_BARANG) LIKE '%$key%' OR LOWER(URAIAN_BARANG) LIKE '%$key%') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
			//echo $data;$die();
			//$data .= " AND KODE_TRADER = '".$_SESSION['TPB_KODETRADER']."' ";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_BARANG'])." - ".strtoupper($row['JENIS_BARANG'])."</b><br>".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['KODE_BARANG'])."|".strtoupper($row['MERK'])."|".strtoupper($row['TIPE'])."|".strtoupper($row['SPFLAIN'])."|".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['JNS_BARANG'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function barang2(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_BARANG, URAIAN_BARANG, MERK, TIPE, SPFLAIN FROM M_TRADER_BARANG WHERE (LOWER(KODE_BARANG) LIKE '%$key%' OR LOWER(URAIAN_BARANG) LIKE '%$key%') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
			//$data .= " AND KODE_TRADER = '".$_SESSION['TPB_KODETRADER']."' ";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_BARANG'])."</b><br>".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['KODE_BARANG'])."|".strtoupper($row['URAIAN_BARANG'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function barang_262()
	{
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_BARANG, URAIAN_BARANG, MERK, TIPE, UKURAN, SPFLAIN FROM M_TRADER_BARANG WHERE (LOWER(KODE_BARANG) LIKE '%$key%' OR LOWER(URAIAN_BARANG) LIKE '%$key%') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
			//$data .= " AND KODE_TRADER = '".$_SESSION['TPB_KODETRADER']."' ";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_BARANG'])."</b><br>".strtoupper($row['URAIAN_BARANG'])."|".strtoupper($row['KODE_BARANG'])."|".ucwords(strtolower($row['URAIAN_BARANG']))."|".ucwords(strtolower($row['MERK']))."|".ucwords(strtolower($row['TIPE']))."|".ucwords(strtolower($row['UKURAN']))."|".ucwords(strtolower($row['SPFLAIN']))."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function kemasan(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_KEMASAN,URAIAN_KEMASAN FROM M_KEMASAN WHERE (LOWER(KODE_KEMASAN) LIKE '%$key%') LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_KEMASAN'])."</b><br>".strtoupper($row['URAIAN_KEMASAN'])."|".strtoupper($row['KODE_KEMASAN'])."|".ucwords(strtolower($row['URAIAN_KEMASAN']))."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function pemasok(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT NAMA_PARTNER, ALAMAT_PARTNER, NEGARA_PARTNER, f_negara(NEGARA_PARTNER) 'URAIAN_NEGARA' FROM m_trader_partner WHERE (LOWER(NAMA_PARTNER) LIKE '%$key%' OR LOWER(ALAMAT_PARTNER) LIKE '%$key%') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['NAMA_PARTNER']."</b><br>".substr($row['ALAMAT_PARTNER'], 0, 38)."|".$row['NAMA_PARTNER']."|".$row['ALAMAT_PARTNER']."|".strtoupper($row['NEGARA_PARTNER'])."|".strtoupper($row['URAIAN_NEGARA'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function pemasokmaster(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT KODE_PARTNER, NAMA_PARTNER FROM m_trader_partner WHERE (LOWER(NAMA_PARTNER) LIKE '%$key%' OR LOWER(KODE_PARTNER) LIKE '%$key%' AND KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['KODE_PARTNER']."</b><br>".substr($row['NAMA_PARTNER'], 0, 38)."|".$row['KODE_PARTNER']."|".$row['NAMA_PARTNER']."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function negara(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_NEGARA, URAIAN_NEGARA FROM M_NEGARA WHERE (LOWER(KODE_NEGARA) LIKE '%$key%' OR LOWER(URAIAN_NEGARA) LIKE '%$key%') LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_NEGARA'])."</b><br>".strtoupper($row['URAIAN_NEGARA'])."|".strtoupper($row['KODE_NEGARA'])."|".strtoupper($row['URAIAN_NEGARA'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function daerah(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_DAERAH, URAIAN_DAERAH FROM M_DAERAH WHERE (LOWER(KODE_DAERAH) LIKE '%$key%' OR LOWER(URAIAN_DAERAH) LIKE '%$key%') LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_DAERAH'])."</b><br>".strtoupper($row['URAIAN_DAERAH'])."|".strtoupper($row['KODE_DAERAH'])."|".strtoupper($row['URAIAN_DAERAH'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function angkut(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT NAMA_ANGKUT, NOMOR_ANGKUT, BENDERA, URAIAN_NEGARA FROM M_TRADER_ANGKUT A LEFT JOIN M_NEGARA B ON A.BENDERA = B.KODE_NEGARA WHERE (LOWER(NAMA_ANGKUT) LIKE '%$key%' OR LOWER(NOMOR_ANGKUT) LIKE '%$key%') AND A.KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['NAMA_ANGKUT']."</b><br>".substr($row['NOMOR_ANGKUT'], 0, 38)."|".$row['NAMA_ANGKUT']."|".$row['NOMOR_ANGKUT']."|".strtoupper($row['BENDERA'])."|".strtoupper($row['URAIAN_NEGARA'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
		
	function timbun(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_TIMBUN, URAIAN_TIMBUN FROM M_TIMBUN WHERE (LOWER(KODE_TIMBUN) LIKE '%$key%' OR LOWER(URAIAN_TIMBUN) LIKE '%$key%') LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_TIMBUN'])."</b><br>".strtoupper($row['URAIAN_TIMBUN'])."|".strtoupper($row['KODE_TIMBUN'])."|".strtoupper($row['URAIAN_TIMBUN'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
		
	function pelabuhan($lokasi=""){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			if($lokasi=="dalam")
				$data = "SELECT KODE_PELABUHAN, URAIAN_PELABUHAN FROM M_PELABUHAN WHERE (LOWER(KODE_PELABUHAN) LIKE '%$key%' OR LOWER(URAIAN_PELABUHAN) LIKE '%$key%') AND SUBSTR(LOWER(KODE_PELABUHAN), 1, 2) = 'id' LIMIT 10";
			else
				$data = "SELECT KODE_PELABUHAN, URAIAN_PELABUHAN FROM M_PELABUHAN WHERE (LOWER(KODE_PELABUHAN) LIKE '%$key%' OR LOWER(URAIAN_PELABUHAN) LIKE '%$key%') LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_PELABUHAN'])."</b><br>".strtoupper($row['URAIAN_PELABUHAN'])."|".strtoupper($row['KODE_PELABUHAN'])."|".strtoupper($row['URAIAN_PELABUHAN'])."\n";
				}
			}
	}
	
	function hs(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT KODE_HS, SERI, KODE_TRADER, KODE_TARIF_BM, TARIF_BM, TARIF_PPN, KODE_SATUAN_BM, TARIF_PPNBM, KODE_CUKAI, TARIF_CUKAI, 
					 KODE_TARIF_CUKAI, AWAL_BERLAKU, KODE_SATUAN_CUKAI, AKHIR_BERLAKU, KET_PPNBM, KETERANGAN, TGL_SKEP, KD_TARIF 
					 FROM m_trader_postarif WHERE (LOWER(KODE_HS)) LIKE '%$key%' 
					 AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."</b>/ ".strtoupper($row['SERI'])."|".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."|".strtoupper($row['SERI'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function hs_n_tarif(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT KODE_HS, SERI, KODE_TRADER, KODE_TARIF_BM, TARIF_BM, TARIF_PPN, KODE_SATUAN_BM, TARIF_PPNBM, KODE_CUKAI, TARIF_CUKAI, 
					 KODE_TARIF_CUKAI, AWAL_BERLAKU, KODE_SATUAN_CUKAI, AKHIR_BERLAKU, KET_PPNBM, KETERANGAN, TGL_SKEP, KD_TARIF 
					 FROM m_trader_postarif WHERE (LOWER(KODE_HS)) LIKE '%$key%' 
					 AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."</b>/ ".strtoupper($row['SERI'])."|".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."|".strtoupper($row['SERI'])."|".$row['TARIF_BM']."|".$row['TARIF_PPN']."|".$row['TARIF_PPNBM']."|".$row['TARIF_CUKAI']."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function hs_n_urai(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_HS, SERI, KODE_TRADER, KODE_TARIF_BM, TARIF_BM, TARIF_PPN, KODE_SATUAN_BM, TARIF_PPNBM, KODE_CUKAI, TARIF_CUKAI, 
					 KODE_TARIF_CUKAI, AWAL_BERLAKU, KODE_SATUAN_CUKAI, AKHIR_BERLAKU, KET_PPNBM, KETERANGAN, TGL_SKEP, KD_TARIF 
					 FROM m_trader_postarif WHERE (LOWER(KODE_HS)) LIKE '%$key%' 
					 AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";		
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."</b>/ ".strtoupper($row['SERI'])."|".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."|".strtoupper($row['SERI'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function satuan(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_SATUAN, URAIAN_SATUAN FROM M_SATUAN WHERE (LOWER(KODE_SATUAN) LIKE '%$key%' OR LOWER(URAIAN_SATUAN) LIKE '%$key%') LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".strtoupper($row['KODE_SATUAN'])."</b><br>".strtoupper($row['URAIAN_SATUAN'])."|".strtoupper($row['KODE_SATUAN'])."|".strtoupper($row['URAIAN_SATUAN'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function trader(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT A.ID, A.NAMA, A.ALAMAT FROM M_TRADER A LEFT JOIN T_TPB B ON B.ID_TRADER=A.ID WHERE (LOWER(A.NAMA) LIKE '%$key%' OR LOWER(A.ALAMAT) LIKE '%$key%' OR A.ID LIKE '%$key%') GROUP BY A.ID LIMIT 10";
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['NAMA']."</b><br>".substr($row['ALAMAT'], 0, 38)."|".$row['ID']."|".$row['NAMA']."|".$row['ALAMAT']."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function hsAll(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_HS, SERI, KODE_TRADER, KODE_TARIF_BM, TARIF_BM, TARIF_PPN, KODE_SATUAN_BM, TARIF_PPNBM, KODE_CUKAI, TARIF_CUKAI, 
					 KODE_TARIF_CUKAI, AWAL_BERLAKU, KODE_SATUAN_CUKAI, AKHIR_BERLAKU, KET_PPNBM, KETERANGAN, TGL_SKEP, KD_TARIF 
					 FROM m_trader_postarif WHERE (LOWER(KODE_HS)) LIKE '%$key%' 
					 AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
		
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."</b>/ ".strtoupper($row['SERI'])."|".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."|".strtoupper($row['SERI'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function hsFor(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');
			$data = "SELECT KODE_HS, SERI, KODE_TRADER, KODE_TARIF_BM, TARIF_BM, TARIF_PPN, KODE_SATUAN_BM, TARIF_PPNBM, KODE_CUKAI, TARIF_CUKAI, 
					 KODE_TARIF_CUKAI, AWAL_BERLAKU, KODE_SATUAN_CUKAI, AKHIR_BERLAKU, KET_PPNBM, KETERANGAN, TGL_SKEP, KD_TARIF 
					 FROM m_trader_postarif WHERE (LOWER(KODE_HS)) LIKE '%$key%' 
					 AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";
		
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."</b>/ ".strtoupper($row['SERI'])."|".$this->fungsi->FormatHS(strtoupper($row['KODE_HS']))."|".strtoupper($row['SERI'])."\n";
				}
			}
			echo "<b>Masukkan Data Baru</b><br/>Jika Belum Ada Pada Daftar Di Atas|||||||\n";
	}
	
	function penerima_bc25(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT NAMA_PENERIMA, ALAMAT_PENERIMA, NIPER_PENERIMA, KODE_ID_PENERIMA, ID_PENERIMA FROM t_bc25_hdr WHERE (LOWER(NAMA_PENERIMA) LIKE '%$key%' OR LOWER(ALAMAT_PENERIMA) LIKE '%$key%' OR LOWER(NIPER_PENERIMA) LIKE '%$key%') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['NAMA_PENERIMA']."</b><br>".substr($row['ALAMAT_PENERIMA'], 0, 38)."|".$row['NAMA_PENERIMA']."|".$row['ALAMAT_PENERIMA']."|".$row['NIPER_PENERIMA']."|".$row['ID_PENERIMA']."\n";
				}
			}
	}
	
	function pengirim_bc40(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT KODE_ID_PENGIRIM, ID_PENGIRIM,  NAMA_PENGIRIM, ALAMAT_PENGIRIM FROM t_bc40_hdr WHERE (LOWER(NAMA_PENGIRIM) LIKE '%$key%' OR LOWER(ALAMAT_PENGIRIM) LIKE '%$key%' OR LOWER(ID_PENGIRIM) LIKE '%$key%') AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['ID_PENGIRIM']."</b><br>".$row['NAMA_PENGIRIM']."<br>".substr($row['ALAMAT_PENGIRIM'], 0, 38)."|".$row['NAMA_PENGIRIM']."|".$row['ID_PENGIRIM']."|".$row['ALAMAT_PENGIRIM']."\n";
				}
			}
	}
	
	function perusahaan(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT NAMA 'Nama Perusahaan',KODE_TRADER,ID FROM M_TRADER WHERE (LOWER(NAMA) LIKE '%$key%') LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['Nama Perusahaan']."</b>|".$row['Nama Perusahaan']."|".$row['KODE_TRADER']."\n";
				}
			}
	}
	
	function kodebarang(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT KODE_BARANG 'Kode Barang',URAIAN_BARANG 'Uraian Barang' FROM m_trader_barang 
					 WHERE (LOWER(KODE_BARANG) LIKE '%$key%' OR LOWER(URAIAN_BARANG) LIKE '%$key%') 
					 AND KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['Kode Barang']."</b><br>".$row['Uraian Barang']."|".$row['Kode Barang']."|".$row['Uraian Barang']."\n";
				}
			}
	}
	
	function barangsatuan(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT KODE_TRADER 'Kode Trader',KODE_BARANG 'Kode Barang',f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 
				           'Jenis Barang',JNS_BARANG 'jns_barang',URAIAN_BARANG 'Uraian Barang',MERK 'Merk',TIPE 'Tipe',
						   UKURAN 'Ukuran',SPFLAIN 'Spf Lain',KODE_SATUAN 'Kode Satuan',f_satuan(KODE_SATUAN) 'Uraian Satuan',
						   FORMAT(STOCK_AKHIR,0) 'Stock Akhir' 
						   FROM m_trader_barang WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['Kode Barang']."</b><br>".$row['Uraian Barang']."|".$row['Kode Barang']."|".$row['Uraian Barang']."|".$row['jns_barang']."|".$row['Jenis Barang']."|".$row['Kode Satuan']."|".$row['Uraian Satuan']."\n";
				}
			}
	}
	
	function barangmusnah(){
			$key = strtolower($_REQUEST['q']);
			$this->load->model('main');			
			$data = "SELECT KODE_TRADER 'Kode Trader',KODE_BARANG 'Kode Barang',f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 
				           'Jenis Barang',JNS_BARANG 'jns_barang',URAIAN_BARANG 'Uraian Barang',MERK 'Merk',TIPE 'Tipe',KODE_SATUAN_TERKECIL,
						   UKURAN 'Ukuran',SPFLAIN 'Spf Lain',KODE_SATUAN 'Kode Satuan',f_satuan(KODE_SATUAN_TERKECIL) 'Uraian Satuan',
						   FORMAT(STOCK_AKHIR,0) 'Stock Akhir' 
						   FROM m_trader_barang WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."' LIMIT 10";			
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>".$row['Kode Barang']."</b><br>".$row['Uraian Barang']."|".$row['Kode Barang']."|".$row['Uraian Barang']."|".$row['jns_barang']."|".$row['Jenis Barang']."|".$row['KODE_SATUAN_TERKECIL']."|".$row['Uraian Satuan']."\n";
				}
			}
	}
}
?>