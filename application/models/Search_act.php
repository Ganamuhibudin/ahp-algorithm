<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search_act extends CI_Model{	

	function search($tipe="",$indexField="",$formName="",$getdata=""){
		$func = get_instance();
		$func->load->model("main","main", true);
		$this->load->library('newtable');
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$rowcount = 8;
		switch($tipe) {
			case "barang":
				$data 	= str_replace(";","",$getdata);
				$judul 	= "Pencarian Data Barang";
				if ($formName == "fpengadaan" || $formName == "fdistribusi" || $formName == "fretur") {
					$SQL = "SELECT a.id_barang, a.kode_barang 'Kode Barang', b.jenis_barang 'Jenis Barang',
							a.nama_barang 'Nama Barang', a.uraian 'Uraian', a.satuan 'Satuan', FORMAT(a.stock,0) 'Stock'
							FROM tbl_barang a 
							LEFT JOIN tbl_jenis_barang b ON b.id_jenis_barang = a.jenis_barang";
					$key    = array("id_barang","Kode Barang","Jenis Barang","Nama Barang", "Uraian","Satuan");	
				} else {
					$SQL = "SELECT a.id_barang, a.kode_barang 'Kode Barang', a.nama_barang 'Nama Barang', 
							b.jenis_barang 'Jenis Barang', a.satuan 'Satuan'
							FROM tbl_barang a 
							LEFT JOIN tbl_jenis_barang b ON b.id_jenis_barang = a.jenis_barang";
					$key    = array("id_barang","Kode Barang","Nama Barang","Jenis Barang","Satuan");	
				}
				$order  = "2";
				$hidden = array("id_barang");
				$sort   = "ASC";
				$search = array(array('kode_barang', 'Kode Barang'),
								array('nama_barang', 'Nama Barang')
								);		
				$sort   = "ASC";											
				$field  = explode(";",$indexField);	
				$show_search=true;				
				break;
			case "qc":
				$SQL = "SELECT id_pemasukan, nomor_pengadaan 'Nomor Pengadaan', tanggal, nomor_invoice 'Nomor Invoice', vendor 'Nama Vendor'
						FROM tbl_pemasukan WHERE status_qc = '1'";
				$key    = array("id_pemasukan","Nomor Pengadaan");
				$order  = "1";
				$hidden = array("id_pemasukan");
				$sort   = "ASC";
				$search = array(
					array('nomor_pengadaan', 'Nomor Pengadaan'),
					array('nomor_invoice', 'Nomor Invoice'),
					array('vendor', 'Nama vendor'),
				);												
				$field  = explode(";",$indexField);	
				$show_search=true;				
			break;
						
			default:
				$judul = "Failed";
			break;
		} 
		$ciuri = $this->input->post("uri");		
		$this->newtable->action(site_url()."/search/getsearch/".$tipe."/".$indexField."/".$formName."/".$getdata);
		$this->newtable->hiddens($hidden);			
		$this->newtable->keys($key);			
		$this->newtable->indexField($field);
		$this->newtable->formField($formName);		
		$this->newtable->orderby($order);
		$this->newtable->sortby($sort);
		$this->newtable->detail_tipe('pilih');
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->show_search($show_search);
		$this->newtable->search($search);
		$this->newtable->show_chk(false);
		$this->newtable->field_order(false);		
		$this->newtable->set_formid("fdetildok");
		$this->newtable->set_divid("divfdetildok");
		$this->newtable->header_bg('#62A8D1');
		$this->newtable->rowcount($rowcount);
		$this->newtable->clear();  
		$tabel = $this->newtable->generate($SQL);
		$arrdata = array("judul" => $judul,"tabel" => $tabel);
		if($this->input->post("ajax")) return $tabel;				 
		else return $arrdata;		
	}
	
}