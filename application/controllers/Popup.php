<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Popup extends CI_Controller{
	
	function getPopUp($type,$jenis){
		$this->load->model('main');
		if($type=='poplist'){
			if($jenis=='kemasan' || $jenis=="kemasanBrg"){
				$judul="Daftar Jenis Kemasan";
			}elseif(($jenis=='pemasokBC27') || ($jenis=='pemasokBC261') || ($jenis=='pemasokBC262') || ($jenis=='pemasokBC41')|| ($jenis=='pemasokBC40')){
				$judul="Daftar Jenis Pemasok/Penerima";
			}elseif(($jenis=='barang_jadi') ||($jenis=='bhnBku27') ||($jenis=='bhnBku261')){
				$judul="Daftar Barang";
			}elseif(($jenis=='zoning_bc30')){
				$judul="Daftar Zoning KITE";
			}elseif(($jenis=='jns_PKB')){
				$judul="Daftar Jenis Barang";
			}elseif(($jenis=='gdng_PKB')){
				$judul="Daftar Gudang / Tempat Penyimpanan";
			}elseif(($jenis=='cara_STUFF')){
				$judul="Daftar Cara Stuffing";
			}elseif(($jenis=='jnpartof')){
				$judul="Daftar JNPARTOF";
			}elseif(($jenis=='satuanBrg')){
				$judul="Daftar Jenis Satuan";
			}elseif(($jenis=='konversi')){
				$judul="Daftar Konversi Barang";
				$idValue=$this->uri->segment(5);//echo $idValue;exit;
			}elseif(($jenis=='kpbc')){
				$judul="Daftar Jenis KPBC";
				$idValue=$this->uri->segment(5);
			}
		$data = array('type' =>$type,
		              'jenis' =>$jenis,
					  'idValue' =>$idValue,
					  'judul' =>$judul);							  
		$this->load->view('popup/list_popup',$data);
		}
	}
	
	function getListPopUp(){//tampil list pop up
		$this->load->model("popup_act");
		$key=$this->input->post("key");
		$type=$this->input->post("type");
		$jenis=$this->input->post("jenis");//echo $jenis.'XXXX';
		$index=$this->input->post("index");//echo $index;
		$typeCari=$this->input->post("typeCari");
		$uraiCari=$this->input->post("uraiCari");
		$banyakIndex = $this->popup_act->gettotalListPopUp($typeCari,$uraiCari);//echo $banyakIndex;
		$resultListPopUp= array();
		//$mulai=1;
		
		$index = intval($index);
		
		if ($index < 0)
			$index = 0;
		else if ($index > $banyakIndex)
			$index = $banyakIndex;
		
		$indexcari = ($index==0)?$index:($index-1);
		$indexsekarang = ($index==0)?1:$index;
		$mulai = ($indexcari*DATA_PER_PAGE);

		if ($banyakIndex > 0)
			$resultListPopUp = $this->popup_act->getlistDataPopUp($mulai,$typeCari,$uraiCari);
		
		$mulai_nomor = ($indexcari * DATA_PER_PAGE) + 1;
		

		//$resultListInv = $this->inventory_act->getlistDataInv();
		$data=array('resultListPopUp'=>$resultListPopUp,
					'banyakIndex'=>$banyakIndex,
					'indexSekarang'=>$indexsekarang,
					'mulai_nomor'=>$mulai_nomor,
					'jenis'=>$jenis,
					'idValue'=>$key,
					'type'=>$type);
	 	$this->load->view('popup/get_list_popup',$data);	
	}
	

}