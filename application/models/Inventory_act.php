<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inventory_act extends CI_Model
{
	function daftar_inventory($tipe=""){		
		$conn = get_instance();
		$conn->load->model("main");
		$this->load->library('newtable');
		if($tipe=="stock_opname"){						
			$SQL="SELECT ID,KODE_TRADER,JNS_BARANG,TANGGAL_STOCK,DATE_FORMAT(TANGGAL_STOCK, '%d %M %Y') AS 'TANGGAL STOCK OPNAME',
					COUNT(*) AS 'JUMLAH ITEM BARANG'	
					FROM M_TRADER_STOCKOPNAME
					WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'
					GROUP BY KODE_TRADER,TANGGAL_STOCK,DATE_FORMAT(TANGGAL_STOCK, '%d %M %Y')";


			if($this->newsession->userdata('KODE_ROLE')!='5'){#ROLE BUKAN BC
				$prosesnya = array('Tambah' => array('GET2', site_url()."/inventory/add/stockopname", '0','fa fa-plus'),	
								'Preview' => array('GET2', site_url()."/inventory/add/stock_view", '1','fa fa-edit'),								
								'Ubah' => array('GET2', site_url()."/inventory/edit/stock_detil", '1','fa fa-edit'),
								'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$tipe, 'inventory','fa fa-times'),
								'Cetak' => array('GETNEW', site_url()."/inventory/cetak/stock_opname", '2','tbl_pdf.png'),
								'Cetak Excel' => array('GETNEW', site_url()."/inventory/cetak/stock_opname/excel", '1','tbl_xls.png'));
			}elseif($this->newsession->userdata('KODE_ROLE')=='5'){#ROLE BC
				$prosesnya = array('Preview Data Stock' => array('GET2', site_url()."/inventory/add/stock_view", '1','fa fa-edit'));
			}
			$title = "Data Stock Opname";
			$this->newtable->search(array(array('TANGGAL_STOCK', 'TANGGAL STOCK&nbsp;', 'tag-tanggal')
										  //array('JNS_BARANG', 'JENIS BARANG','tag-select',$conn->main->get_mtabel('ASAL_JENIS_BARANG'))
										  ));
			$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
			$this->newtable->action(site_url()."/inventory/daftar/".$tipe);	
			$this->newtable->hiddens(array("ID","KODE_TRADER","JNS_BARANG","TANGGAL_STOCK"));
			$this->newtable->keys(array("ID","TANGGAL_STOCK","KODE_TRADER"));
			$this->newtable->tipe_proses('button');
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($ciuri);
			$this->newtable->orderby("4");
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("f".$tipe);
			$this->newtable->set_divid("div".$tipe);
			$this->newtable->rowcount(15);
			$this->newtable->clear(); 
			$this->newtable->menu($prosesnya);
			$tabel = $this->newtable->generate($SQL); 
			$arrdata = array("title" => $title,
							 "tabel" => $tabel,
							 "jenis" => $jenis,
							 "tipe" => $tipe);
			if($this->input->post("ajax")) return $tabel;				 
			else return $arrdata;	
	
		}elseif($tipe=="konversi" || $tipe=="konversi_sub"){
			if($tipe=="konversi"){
				$WHERE=" WHERE B.KODE_BARANG=A.KODE_BARANG AND A.SUBKONTRAK='N' AND A.KODE_TRADER=B.KODE_TRADER
				         AND A.KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
				if($this->newsession->userdata('KODE_ROLE')!='5'){#ROLE BUKAN BC
					$prosesnya = array(	'Preview' => array('GET2', site_url()."/inventory/add/konversi_view", '1','fa fa-file-text-o'),
										'Tambah' => array('GET2', site_url()."/inventory/add/konversi_new", '0','icon-plus'),
										'Ubah' => array('GET2', site_url()."/inventory/edit/konversi_detil", '1','icon-edit'),
										'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$tipe, 'inventory','icon-remove'));
				}elseif($this->newsession->userdata('KODE_ROLE')=='5'){#ROLE BC
					$prosesnya = array('Preview Data Konversi' => array('GET2', site_url()."/inventory/add/konversi_view", '1','fa fa-edit'));
				}
				$title = "Data Konversi";
				$SQL = "SELECT A.NOMOR_KONVERSI 'NOMOR KONVERSI',A.IDBJ,A.KODE_TRADER, A.KODE_BARANG 'KODE BARANG',
						B.URAIAN_BARANG 'URAIAN BARANG', A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,
						A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						IFNULL(f_jumBB(A.IDBJ),0) AS 'JUMLAH ITEM BAHAN BAKU' ,A.KETERANGAN 
						FROM M_TRADER_KONVERSI_BJ A, M_TRADER_BARANG B".$WHERE;
				$this->newtable->hiddens(array("IDBJ","KODE_TRADER","JNS_BARANG"));	
				$this->newtable->keys(array("IDBJ","KODE_TRADER"));
				$this->newtable->search(array(array('A.NOMOR_KONVERSI', 'NOMOR KONVERSI'),
											  array('A.KODE_BARANG', 'KODE BARANG')));
				$this->newtable->tipe_proses('button');
			}elseif($tipe=="konversi_sub"){
				$WHERE=" WHERE A.KODE_TRADER=B.KODE_TRADER AND B.KODE_BARANG=A.KODE_BARANG 
						 AND A.SUBKONTRAK='Y' AND A.KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";
				if($this->newsession->userdata('KODE_ROLE')!='5'){#ROLE BUKAN BC
					$prosesnya = array(	'Preview' => array('GET2', site_url()."/inventory/add/konversi_sub_view", '1','fa fa-edit'),
									'Tambah' => array('GET2', site_url()."/inventory/add/konversi_sub_new", '0','fa fa-plus'),
									'Ubah' => array('GET2', site_url()."/inventory/edit/konversi_sub_detil", '1','fa fa-edit'),
									'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$tipe, 'inventory','fa fa-times'));
				}elseif($this->newsession->userdata('KODE_ROLE')=='5'){#ROLE BC
					$prosesnya = array('Preview' => array('GET2', site_url()."/inventory/add/konversi_sub_view", '1','fa fa-edit'));
				}
				$title = "Data Konversi Subkontrak";
				$SQL = "SELECT A.NOMOR_KONVERSI 'NOMOR KONVERSI',A.IDBJ,A.KODE_TRADER, A.KODE_BARANG 'KODE BARANG',
						B.URAIAN_BARANG 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						IFNULL(f_jumBB(A.IDBJ),0) AS 'JUMLAH ITEM BAHAN BAKU' ,A.KETERANGAN 
						FROM M_TRADER_KONVERSI_BJ A,M_TRADER_BARANG B".$WHERE;
				$this->newtable->hiddens(array("IDBJ","KODE_TRADER","JNS_BARANG"));		
				$this->newtable->keys(array("IDBJ","KODE_TRADER"));
				$this->newtable->search(array(array('A.NOMOR_KONVERSI', 'NOMOR KONVERSI'),
											  array('A.KODE_BARANG', 'KODE BARANG')));
			}				
			$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
			$this->newtable->action(site_url()."/inventory/daftar/".$tipe);			
			$this->newtable->tipe_proses('button');
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($ciuri);
			$this->newtable->orderby(2);
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("f".$tipe);
			$this->newtable->set_divid("div".$tipe);
			$this->newtable->rowcount(20);
			$this->newtable->clear(); 
			$this->newtable->menu($prosesnya);
			$tabel .= $this->newtable->generate($SQL);	
			$arrdata = array("title" => $title,
							 "tabel" => $tabel,
							 "jenis" => $jenis,
							 "tipe" => $tipe);
			if($this->input->post("ajax")) return $tabel;				 
			else return $arrdata;	
		}				
	}
	
	function proses_form($tipe){
		$func =&get_instance();
		$func->load->model("main", "main", true);
		$kdtrader = $this->newsession->userdata('KODE_TRADER');			
		if($tipe=="barang"){
			$kode_barang 	= $this->input->post('KODE_BARANG');
			$act			= $this->input->post('act');
			$jnsbrg			= $this->input->post('JNS_BARANG');
			foreach($this->input->post('INVBRG') as $a => $b){
				$arrInvBrg[$a] = $b;
			}
			$arrdetil = $this->input->post('DATADTL');
			$ret = "MSG#ERR#Proses Data Gagal.#";
			if($act=="save"){
				$SQL = "SELECT KODE_SATUAN_TERKECIL FROM M_TRADER_BARANG WHERE KODE_BARANG='".trim($kode_barang)."' 
						AND JNS_BARANG = '".$jnsbrg."' AND KODE_TRADER ='".$kdtrader."'";
				$rs = $this->db->query($SQL);				
				if($rs->num_rows()>0){
					$SATUAN_TERKECIL = $rs->row()->KODE_SATUAN_TERKECIL;			
					$URUT = 0;
					$arrkeys = array_keys($arrdetil);
					$countdtl = count($arrdetil[$arrkeys[0]]);
					for($i=0;$i<$countdtl;$i++){
						for($j=0;$j<count($arrkeys);$j++){
							$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
						}
						$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='".trim($kode_barang)."' 
								AND JNS_BARANG = '".$jnsbrg."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
								AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' 
								AND KODE_TRADER ='".$kdtrader."'";
						$rs = $this->db->query($SQL);		
						if($rs->num_rows()>0){
							$URUT++;	
						}else{															
							$DATAGUDANG["KODE_TRADER"] 		= $kdtrader;
							$DATAGUDANG["KODE_BARANG"] 		= trim($kode_barang);
							$DATAGUDANG["JNS_BARANG"] 		= $jnsbrg;
							$DATAGUDANG["KODE_GUDANG"] 		= $DATADTL["KODE_GUDANG"];
							$DATAGUDANG["KONDISI_BARANG"] 	= $DATADTL["KONDISI_BARANG"];
							$DATAGUDANG["SATUAN"] 			= $SATUAN_TERKECIL;	
							$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);					
							$func->main->activity_log('TAMBAH DATA BARANG','KODE_BARANG='.trim($kode_barang).', JNS_BARANG='.$jnsbrg);
							$ret = "MSG#OK#Penyimpanan Data Berhasil. Silahkan masukan lagi jika ingin menambahkan data barang lainnya.#";
						}					
						if($URUT==$countdtl){
							$ret =  "MSG#ERR#Kode Barang dengan Jenis Barang, Kode Gudang, Kondisi barang tersebut sudah ada#";	
						}										
					}
				}else{
					$arrkeys = array_keys($arrdetil);
					$countdtl = count($arrdetil[$arrkeys[0]]);
					for($i=0;$i<$countdtl;$i++){
						for($j=0;$j<count($arrkeys);$j++){
							$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
						}
						$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '".trim($kode_barang)."' 
								AND JNS_BARANG = '".$jnsbrg."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
								AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' 
								AND KODE_TRADER = '".$kdtrader."'";
						$rs = $this->db->query($SQL);
						if($rs->num_rows()==0){
							$DATAGUDANG["KODE_TRADER"] 	= $kdtrader;
							$DATAGUDANG["KODE_BARANG"] = trim($kode_barang);
							$DATAGUDANG["JNS_BARANG"] = $jnsbrg;
							$DATAGUDANG["KODE_GUDANG"] = $DATADTL["KODE_GUDANG"];
							$DATAGUDANG["KONDISI_BARANG"] = $DATADTL["KONDISI_BARANG"];
							$DATAGUDANG["SATUAN"] = $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];				
							$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);	
						}
					}
					$arrInvBrg["KODE_HS"] 				= str_replace(".","",$arrInvBrg["KODE_HS"]);
					$arrInvBrg["KODE_BARANG"]			= trim($kode_barang);
					$arrInvBrg["JNS_BARANG"]			= $jnsbrg;
					$arrInvBrg["KODE_TRADER"]			= $kdtrader;
					$arrInvBrg["KODE_SATUAN_TERKECIL"]	= $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
					
					$arrInvBrg["JML_SATUAN_TERKECIL"] 	= $arrInvBrg["JML_SATUAN_TERKECIL"]?$arrInvBrg["JML_SATUAN_TERKECIL"]:1;
					$exec = $this->db->insert('M_TRADER_BARANG', $arrInvBrg);
					$func->main->activity_log('TAMBAH DATA BARANG','KODE_BARANG='.trim($kode_barang).', JNS_BARANG='.$jnsbrg);
					$ret = "MSG#OK# Penyimpanan Data Berhasil. Silahkan masukan lagi jika ingin menambahkan data barang lainnya.#";
				}
				echo $ret;
			}else{				
				$HIDE_KODE_BARANG = $this->input->post('HIDE_KODE_BARANG');
				$HIDE_JNS_BARANG  = $this->input->post('HIDE_JNS_BARANG');
				
				$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$kdtrader."'
						AND KODE_BARANG = '".$HIDE_KODE_BARANG."' AND JNS_BARANG = '".$HIDE_JNS_BARANG."'";
				$rs = $this->db->query($SQL);
				if($rs->num_rows()>0){
					$DATABRG["KODE_HS"] = str_replace(".","",$arrInvBrg["KODE_HS"]);
					$DATABRG["URAIAN_BARANG"] = $arrInvBrg["URAIAN_BARANG"];
					$DATABRG["MERK"] = $arrInvBrg["MERK"];
					$DATABRG["TIPE"] = $arrInvBrg["TIPE"];
					$DATABRG["UKURAN"] = $arrInvBrg["UKURAN"];
					$DATABRG["SPFLAIN"] = $arrInvBrg["SPFLAIN"];
					
					$this->db->where(array('KODE_BARANG' => $HIDE_KODE_BARANG,'JNS_BARANG'=> $HIDE_JNS_BARANG, 'KODE_TRADER'=>$kdtrader));
					$exec = $this->db->update('M_TRADER_BARANG', $DATABRG);	
					if($exec){
						$this->db->where(array('KODE_BARANG'=>$HIDE_KODE_BARANG,'JNS_BARANG'=>$HIDE_JNS_BARANG,'KODE_TRADER'=>$kdtrader));	
						if($this->db->delete('M_TRADER_BARANG_GUDANG')){				   		
							$arrkeys = array_keys($arrdetil);
							$countdtl = count($arrdetil[$arrkeys[0]]);
							for($i=0;$i<$countdtl;$i++){
								for($j=0;$j<count($arrkeys);$j++){
									$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
								}
								$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='".$HIDE_KODE_BARANG."' 
										AND JNS_BARANG = '".$HIDE_JNS_BARANG."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
										AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' 
										AND KODE_TRADER ='".$kdtrader."'";
								$rs = $this->db->query($SQL);				
								if($rs->num_rows()==0){
									$DATAGUDANG["KODE_TRADER"] = $kdtrader;
									$DATAGUDANG["KODE_BARANG"] = $HIDE_KODE_BARANG;
									$DATAGUDANG["JNS_BARANG"] = $HIDE_JNS_BARANG;
									$DATAGUDANG["KODE_GUDANG"] = $DATADTL["KODE_GUDANG"];
									$DATAGUDANG["KONDISI_BARANG"] = $DATADTL["KONDISI_BARANG"];
									$DATAGUDANG["JUMLAH"] = $DATADTL["JUMLAH_HIDE"]?$DATADTL["JUMLAH_HIDE"]:0;
									$DATAGUDANG["SATUAN"] = $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
									$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);	
								}
							}
						}	
						$func->main->activity_log('EDIT DATA BARANG','KODE_BARANG='.$HIDE_KODE_BARANG.', JNS_BARANG='.$HIDE_JNS_BARANG);
						$ret = "MSG#OK#Kode Barang dan Jenis Barang ini sudah ada mutasi.
							  <br><p style=\"margin-left:175px;\">Hanya Kode HS, Seri HS, Uraian, Merk, Tipe, Ukuran dan Spesifikasi Lain yang dapat berubah</p>.#".site_url()."/inventory/barang#";
					}										
				}else{
					$this->db->where(array('KODE_BARANG'=>$HIDE_KODE_BARANG,'JNS_BARANG'=>$HIDE_JNS_BARANG,'KODE_TRADER'=>$kdtrader));	
					if($this->db->delete('M_TRADER_BARANG_GUDANG')){
						$arrkeys = array_keys($arrdetil);
						$countdtl = count($arrdetil[$arrkeys[0]]);
						for($i=0;$i<$countdtl;$i++){
							for($j=0;$j<count($arrkeys);$j++){
								$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
							}
							$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='".trim($kode_barang)."' 
									AND JNS_BARANG = '".$jnsbrg."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
									AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' 
									AND KODE_TRADER ='".$kdtrader."'";
							$rs = $this->db->query($SQL);				
							if($rs->num_rows()==0){
								$DATAGUDANG["KODE_TRADER"] = $kdtrader;
								$DATAGUDANG["KODE_BARANG"] = trim($kode_barang);
								$DATAGUDANG["JNS_BARANG"] = $jnsbrg;
								$DATAGUDANG["KODE_GUDANG"] = $DATADTL["KODE_GUDANG"];
								$DATAGUDANG["KONDISI_BARANG"] = $DATADTL["KONDISI_BARANG"];
								$DATAGUDANG["JUMLAH"] = $DATADTL["JUMLAH_HIDE"]?$DATADTL["JUMLAH_HIDE"]:0;
								$DATAGUDANG["SATUAN"] = $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
								$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);	
							}
						}
					}
					$arrInvBrg["KODE_HS"] = str_replace(".","",$arrInvBrg["KODE_HS"]);
					$arrInvBrg["KODE_BARANG"]=$kode_barang;
					$arrInvBrg["JNS_BARANG"]=$jnsbrg;
					$arrInvBrg["KODE_SATUAN_TERKECIL"]=$arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
					$arrInvBrg["JML_SATUAN_TERKECIL"]=$arrInvBrg["JML_SATUAN_TERKECIL"]?$arrInvBrg["JML_SATUAN_TERKECIL"]:1;
					$this->db->where(array('KODE_BARANG' => $HIDE_KODE_BARANG,'JNS_BARANG'=> $HIDE_JNS_BARANG, 'KODE_TRADER'=>$kdtrader));
					$exec = $this->db->update('m_trader_barang', $arrInvBrg);	
					if($exec){
						$func->main->activity_log('EDIT DATA BARANG','KODE_BARANG='.$HIDE_KODE_BARANG.', JNS_BARANG='.$HIDE_JNS_BARANG);
						$ret = "MSG#OK#Perubahan Data Berhasil.#".site_url()."/inventory/barang#";
					}
				}
				echo $ret;
			}
		}
		elseif($tipe=="updatestock"){
			$keyTgl=$this->uri->segment(4);	
			$SQLSTOCK="SELECT KODE_TRADER,KODE_BARANG,JNS_BARANG,JUMLAH FROM M_TRADER_STOCKOPNAME 
					   WHERE TANGGAL_STOCK='".$keyTgl."' AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'";
		    $hasil = $func->main->get_result($SQLSTOCK);
			if($hasil){
				foreach($SQLSTOCK->result_array() as $row){
					$this->db->where(array("KODE_TRADER"=>$kdtrader,"KODE_BARANG"=>$row['KODE_BARANG'],"JNS_BARANG"=>$row['JNS_BARANG']));
					$exec=$this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$row['JUMLAH']));
				}
				if($exec){
					$func->main->activity_log('UPDATE STOCK BARANG DARI STOCKOPNAME','TANGGAL_STOCK='.$keyTgl);
					echo "MSG#OK#Pengubahan Data Stock Barang Berhasil.#";
				}else{					
					echo "MSG#ERR#Pengubahan Data Stock Barang Gagal.#";
				}
			}
		}
		elseif($tipe=="stock" || $tipe=="stock_new" || $tipe=="stockPOP" || $tipe=="stockPOPDtl2"){//die('sini');
			$id=$this->input->post('ID');
			$tglEdit=$this->input->post('TANGGAL');
			//$tglInput=$this->input->post('TANGGAL_STOCKALL');
			$kode_trader=$this->input->post('KODE_TRADER');
			$jnsbrg=$this->input->post('JNS_BARANG');
			$kode_barang=$this->input->post('KODE_BARANG');
			$KETERANGAN=$this->input->post('KETERANGAN');
			$GUDANG=$this->input->post('GUDANG');
			$KONDISI_BRG=$this->input->post('KONDISI_BARANG');
			$act=$this->input->post('act');//echo $tglInput;die();
			foreach($this->input->post('STOCK') as $a => $b){
					$arrStock[$a] = $b;
			}
			if($tipe!="stockPOPDtl2"){
				if($act=="save" || $act=="save new"){//echo 'tes';die();
					$arrStock["ID"]=$id;
					$arrStock["KODE_TRADER"]=$kode_trader;
					$SQL="SELECT KODE_BARANG,JNS_BARANG FROM m_trader_stockopname 
						  WHERE KODE_BARANG='".$kode_barang."' 
						  AND JNS_BARANG='".$jnsbrg."' AND TANGGAL_STOCK='".$tglEdit."' 
						  AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'";
					$hasil = $func->main->get_result($SQL);
					if($hasil){
						foreach($SQL->result_array() as $row){
							$dataarray = $row;
						}
					}
					$jumDt = (int)$func->main->get_uraian("SELECT COUNT(*) AS JUM FROM m_trader_stockopname 
								  WHERE KODE_BARANG='$kode_barang' AND JNS_BARANG = '".$jnsbrg."' AND TANGGAL_STOCK='".$tanggal."'
								  AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'", "JUM");	
								  
					if($jumDt > 0|| ($dataarray['KODE_BARANG']==$kode_barang && $dataarray['JNS_BARANG']==$jnsbrg)){
						echo "MSG#ERR#Kode Barang dan Jenis Barang sudah ada#";
					}else{
						$arrStock["KODE_BARANG"]=$kode_barang;
						$arrStock["JNS_BARANG"]=$jnsbrg;
						$arrStock["TANGGAL_STOCK"]=$tglEdit;
						$arrStock["KODE_GUDANG"]=$GUDANG;
						$arrStock["KONDISI_BARANG"]=$KONDISI_BRG;

						$exec = $this->db->insert('m_trader_stockopname', $arrStock);
						if($exec){
							$func->main->activity_log('ADD STOCKOPNAME','TANGGAL_STOCK='.$tglEdit);
							echo "MSG#OK#Penyimpanan Data Berhasil.#ID#";
						}else{					
							echo "MSG#ERR#Penyimpanan Data Gagal.#";
						}
					}

				}else{
					$arrStock["KODE_BARANG"]=$kode_barang;
					$arrStock["JNS_BARANG"]=$jnsbrg;

					$this->db->where(array('ID' => $id,'KODE_TRADER'=> $kode_trader));
					$exec = $this->db->update('m_trader_stockopname', $arrStock);	
					if($exec){
						$func->main->activity_log('EDIT STOCKOPNAME','TANGGAL_STOCK='.$tglEdit);
						echo "MSG#OK#Pengubahan Data Berhasil.#";
						
					}else{					
						echo "MSG#ERR#Pengubahan Data Gagal.#";
					}
				}
			}else{
				if($act=="save"){
					$datas = explode('.',$id);
					$id = $datas[0];
					$tgl = $datas[1];
					$kodeTrader = $datas[2];
					$kode_barang = $datas[3];
					
					$JNS_DOK=$this->input->post('JNS_DOK');
					$NO_DOK_MASUK=$this->input->post('NO_DOK_MASUK');
					$TGL_DOK_MASUK=$this->input->post('TGL_DOK_MASUK');
					$JUMLAH=$this->input->post('JUMLAH');
					$KETERANGAN=$this->input->post('KETERANGAN');

					
					$SQL = "SELECT JUMLAH FROM M_TRADER_STOCKOPNAME WHERE KODE_TRADER='".$kdtrader."' AND ID = '".$id."'";
					$rs = $this->db->query($SQL);	
					$JUMLAHHDR=0;	
					if($rs->num_rows()>0){
						$JUMLAHHDR = $rs->row()->JUMLAH;
					}
					$SQL = "SELECT JUMLAH FROM M_TRADER_STOCKOPNAME_DTL WHERE IDHDR = '".$id."'";
					$JUMLAHDTL=0;
					if($func->main->get_result($SQL)){
						foreach($SQL->result_array() as $row){
							$JUMLAHDTL = $JUMLAHDTL+$row['JUMLAH'];
						}
					}	
					$SISA = $JUMLAHHDR-$JUMLAHDTL;				
					if($JUMLAH>$SISA){
						echo "MSG#ERR#Proses Data Gagal. Sisa yang ada adalah: ".$SISA." #";die();
					}
					
					$data['IDHDR'] = $id;
					$data['JENIS_DOK_MASUK'] = $JNS_DOK;
					$data['NO_DOK_MASUK'] = $NO_DOK_MASUK;
					$data['TGL_DOK_MASUK'] = $TGL_DOK_MASUK;
					$data['JUMLAH'] = $JUMLAH;
					$data['JUMLAH_SISA'] = $JUMLAH;
					$data['KETERANGAN'] = $KETERANGAN;

					$exec = $this->db->insert('m_trader_stockopname_dtl', $data);
					if($exec){
						echo "MSG#OK#Penyimpanan Data Berhasil.#";
					}else{					
						echo "MSG#ERR#Penyimpanan Data Gagal.#";
					}
				}else{
					$id = $this->input->post('TANGGAL');
					$expl = explode(",",$id);
					$id = $expl[0];
					$idhdr = $expl[1];
					
					$JNS_DOK=$this->input->post('JNS_DOK');
					$NO_DOK_MASUK=$this->input->post('NO_DOK_MASUK');
					$TGL_DOK_MASUK=$this->input->post('TGL_DOK_MASUK');
					$JUMLAH=$this->input->post('JUMLAH');
					$KETERANGAN=$this->input->post('KETERANGAN');

					
					$SQL = "SELECT JUMLAH FROM M_TRADER_STOCKOPNAME WHERE KODE_TRADER='".$kdtrader."' AND ID = '".$idhdr."'";
					$rs = $this->db->query($SQL);	
					$JUMLAHHDR=0;	
					if($rs->num_rows()>0){
						$JUMLAHHDR = $rs->row()->JUMLAH;
					}
					$SQL = "SELECT JUMLAH FROM M_TRADER_STOCKOPNAME_DTL WHERE IDDTL <> '".$id."' AND IDHDR='".$idhdr."'";
					$JUMLAHDTL=0;
					if($func->main->get_result($SQL)){
						foreach($SQL->result_array() as $row){
							$JUMLAHDTL = $JUMLAHDTL+$row['JUMLAH'];
						}
					}	
					$SISA = $JUMLAHHDR-$JUMLAHDTL;				
					if($JUMLAH>$SISA){
						echo "MSG#ERR#Jumlah yg dapat dimasukan maks: ".$SISA." #";die();
					}
					
					$data['JENIS_DOK_MASUK'] = $JNS_DOK;
					$data['NO_DOK_MASUK'] = $NO_DOK_MASUK;
					$data['TGL_DOK_MASUK'] = $TGL_DOK_MASUK;
					$data['JUMLAH'] = $JUMLAH;
					$data['KETERANGAN'] = $KETERANGAN;

					
					$this->db->where("IDDTL",$id);
					$exec = $this->db->update('m_trader_stockopname_dtl', $data);
					
					if($exec){
						echo "MSG#OK#Pengubahan Data Berhasil.#";
						
					}else{					
						echo "MSG#ERR#Pengubahan Data Gagal.#";
					}
				}
			}
		}elseif($tipe=="stock_tgl"){
			$act=$this->input->post('act');
			$tgl=$this->input->post('TANGGAL_STOCK');
			echo $tgl;
		}elseif($tipe=="detilstock"){
			$act=$this->input->post('act');
			$tglDefault=date("Y_m-d H:i:s");
			$tanggal=$this->input->post('TANGGAL_STOCKALL');
			$tglEdit=$this->input->post('TANGGAL_EDIT');
			$kode_trader=$this->input->post('KODE_TRADER');
			if($act=="update"){
				$arrDetStock['TANGGAL_STOCK']=$tanggal;
				$this->db->where(array('TANGGAL_STOCK' => $tglEdit,'KODE_TRADER'=> $kode_trader));
				$exec = $this->db->update('m_trader_stockopname', $arrDetStock);	
				if($exec){
					echo "MSG#OK#Pengubahan Data Berhasil.#";					
				}else{					
					echo "MSG#ERR#Pengubahan Data Gagal.#";
				}
			}elseif($act=="save"){
				$query = "SELECT COUNT(*) AS JUM FROM m_trader_stockopname 
						  WHERE TANGGAL_STOCK='".$tanggal."' AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'";
				$jumDt = (int)$func->main->get_uraian($query, "JUM");	
				if($jumDt == 0){
					echo "MSG#ERR#Penyimpanan Data Gagal. Harap Isi Detil Barang Terlebih Dahulu!#";
				}else{
					if($tanggal==""){
						echo "MSG#ERR#Harap Isi Tanggal Stock Opname!#";die();
					}							
					$arrDetStock['TANGGAL_STOCK']=$tanggal;
					$this->db->where(array('TANGGAL_STOCK' => "0000-00-00",'KODE_TRADER'=> $kode_trader));
					$exec = $this->db->update('m_trader_stockopname', $arrDetStock);	
					if($exec){
						echo "MSG#OK#Penyimpanan Data Berhasil.#";
					}else{					
						echo "MSG#ERR#Penyimpanan Data Gagal.#";
					}
				}
			}
		
		}elseif($tipe=="detilkonversi" || $tipe=="detilkonversi_sub"){
			$act=$this->input->post('act');
			$kode_trader=$this->input->post('KODE_TRADER');
			$jenis_brg=$this->input->post('JNS_BARANG');
			$kode_barang=$this->input->post('KODE_BARANG');
			$IDBJ=$this->input->post('IDBJ');
			if($tipe=="detilkonversi_sub")$subkontrak="Y";
			else $subkontrak="N";
			if($act=="save new")$IDBJ="0";
			else $IDBJ=$this->input->post('IDBJ');
			foreach($this->input->post('KONV') as $a => $b){
				$arrKonv[$a] = $b;
			}
			if($act=="save" || $act=="save new"){
				if($tipe=="detilkonversi"){
					$jumDt = (int)$func->main->get_uraian("SELECT COUNT(*) AS JUM FROM m_trader_konversi_bj
							  WHERE KODE_BARANG='$kode_barang' AND JNS_BARANG='$jenis_brg' AND IDBJ='$IDBJ'
							  AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'", "JUM");
				}elseif($tipe=="detilkonversi_sub"){
					$jumDt = (int)$func->main->get_uraian("SELECT COUNT(*) AS JUM FROM m_trader_konversi_bj
							  WHERE KODE_BARANG='$kode_barang' AND JNS_BARANG='$jenis_brg' AND IDBJ='$IDBJ' AND SUBKONTRAK='Y'
							  AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'", "JUM");	
				}					
				if($jumDt > 0){
					echo "MSG#ERR#Kode Barang dan Jenis Barang Sudah Pernah digunakan#";
				}else{
					$arrKonv["SUBKONTRAK"]=$subkontrak;
					$arrKonv["KODE_TRADER"]=$kode_trader;
					$arrKonv["KODE_BARANG"]=$kode_barang;
					$arrKonv["JNS_BARANG"]=$jenis_brg;
					$exec = $this->db->insert('m_trader_konversi_bj', $arrKonv);
					if($exec){
						echo "MSG#OK#Simpan data Konversi Berhasil#";
					}else{					
						echo "MSG#ERR#Simpan data Konversi Gagal#";	
					}
				}
			}else{
				$this->db->where(array('IDBJ' => $IDBJ,'KODE_TRADER'=> $kode_trader));
				$exec = $this->db->update('m_trader_konversi_bj', $arrKonv);	
				if($exec){
					echo "MSG#OK#Ubah data Konversi Berhasil#";
					
				}else{					
					echo "MSG#ERR#Ubah data Konversi Gagal#";
				}	
			}
		}elseif($tipe=="konversiPOPN" || $tipe=="konversiPOP"  || $tipe=="konversi_subPOP" || $tipe="konversi_subPOPN"){
			$act=$this->input->post('act');//echo $act;die();
			$idBJ=$this->input->post('IDBJ');
			$idBB=$this->input->post('IDBB');
			$kode_trader=$this->input->post('KODE_TRADER');
			$jenis_brg=$this->input->post('JNS_BARANG');
			$kode_barang=$this->input->post('KODE_BARANG');
			foreach($this->input->post('KONVBB') as $a => $b){
				$arrKonvBB[$a] = $b;
			}
			if($act=="save" || $act=="save new"){
				$SQL="SELECT KODE_BARANG,JNS_BARANG FROM m_trader_konversi_bj where IDBJ='$idBJ' AND 
					  KODE_BARANG='$kode_barang' AND JNS_BARANG='$jenis_brg' AND IDBJ='$idBJ'
					  AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'";
				$hasil = $func->main->get_result($SQL);
				if($hasil){
					foreach($SQL->result_array() as $row){
						$dataarray = $row;
					}
				}
				$jumDt = (int)$func->main->get_uraian("SELECT COUNT(*) AS JUM FROM m_trader_konversi_bb
							  WHERE KODE_BARANG='$kode_barang' AND JNS_BARANG='$jenis_brg' AND IDBJ='$idBJ'
							  AND KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'", "JUM");
					
				if($jumDt > 0 || ($dataarray['KODE_BARANG']==$kode_barang && $dataarray['JNS_BARANG']==$jenis_brg)){
					echo "MSG#ERR#Kode Barang dan Jenis Barang Sudah Pernah digunakan#";
				}else{						
					$arrKonvBB["KODE_TRADER"]=$kode_trader;
					$arrKonvBB["KODE_BARANG"]=$kode_barang;
					$arrKonvBB["JNS_BARANG"]=$jenis_brg;
					$arrKonvBB["IDBJ"]=$idBJ;
					$exec = $this->db->insert('m_trader_konversi_bb', $arrKonvBB);
					if($exec){
						echo "MSG#OK#Simpan data Konversi Berhasil#";
					}else{					
						echo "MSG#ERR#Simpan data Konversi Gagal#";	
					}
				}
			}else{
				$this->db->where(array('IDBB' => $idBB,'IDBJ' => $idBJ,'KODE_TRADER'=> $kode_trader));
				$exec = $this->db->update('m_trader_konversi_bb', $arrKonvBB);




				if($exec){
					echo "MSG#OK#Ubah data Konversi Berhasil#";
				}else{					
					echo "MSG#ERR#Ubah data Konversi Gagal#";	
				}
			}
		}
	}
	
	function getData($tipe,$key1,$key2,$kdbaranag=""){
		#echo $tipe.",".$key1.",".$key2;die();
		$conn = get_instance();
		$conn->load->model("main");
		$idTrader=$this->newsession->userdata("KODE_TRADER");
		if($tipe=="barang" || $tipe=="barangview"){
			if($key1 && $key2){
				$query = "SELECT *,f_ref('ASAL_JENIS_BARANG',JNS_BARANG) AS 'URAIAN_JENIS',f_satuan(KODE_SATUAN) AS 'URAIAN_SATUAN' 
						  FROM M_TRADER_BARANG WHERE KODE_BARANG='".$key1."' AND JNS_BARANG='".$key2."' AND KODE_TRADER='".$idTrader."'";
						  #echo $query;die();
						
				$COMBOGDG = $conn->main->get_combobox("SELECT KODE_GUDANG,CONCAT(NAMA_GUDANG,' (',KODE_GUDANG,')') URAIAN FROM M_TRADER_GUDANG 
													   WHERE KODE_TRADER='".$idTrader."' 
													   ORDER BY KODE_GUDANG ","KODE_GUDANG", "URAIAN", FALSE);
				
			}else{
				$query = "SELECT A.KODE_TRADER, A.KODE_ID 'KODE_ID_TRADER', A.ID, A.NAMA 'NAMA_TRADER', A.ALAMAT 'ALAMAT_TRADER', A.TELEPON, 
						  B.NOMOR_SKEP 'REGISTRASI', C.NAMA 'NAMA_CP', C.TELEPON 'TELP_CP', C.EMAIL 'EMAIL_CP',
						  ID AS 'ID_TRADER',
						  0 AS 'FOB', 0 AS 'FREIGHT', 0 AS 'ASURANSI', 0 AS 'CIF', 0 AS 'CIFRP', 0 AS 'BRUTO', 0 AS 'NETTO', 0 AS 'TAMBAHAN',
						  0 AS 'DISKON', 0 AS 'NILAI_INVOICE', 0 AS 'NDPBM'
						  FROM M_TRADER A, M_TRADER_SKEP B, T_USER C WHERE A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=C.KODE_TRADER
						  AND A.KODE_TRADER='$idTrader'";
			}
			$hasil = $conn->main->get_result($query);
			if($hasil){
				foreach($query->result_array() as $row){
					$dataarray = $row;
					if($key1 && $key2){
						$SQD = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, KODE_GUDANG, KODE_RAK, KODE_SUB_RAK,
								KONDISI_BARANG, JUMLAH, SATUAN, f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER) AS 'RAK', f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER) AS 'SUB_RAK' FROM M_TRADER_BARANG_GUDANG
								WHERE KODE_TRADER='".$idTrader."' 
								AND KODE_BARANG='".$key1."' 
								AND JNS_BARANG='".$key2."' ORDER BY ID ASC";
						#echo $SQD;die();
						$rs = $conn->main->get_result($SQD);
						$DATADTL = "";
						if($rs){
							$a = 1;
							foreach($SQD->result_array() as $data){
								$RAK = $conn->main->get_combobox("SELECT KODE_RAK,NAMA_RAK FROM M_TRADER_RAK WHERE KODE_GUDANG='".$data['KODE_GUDANG']."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."'", "KODE_RAK", "NAMA_RAK", FALSE);
								$SUBRAK = $conn->main->get_combobox("SELECT KODE_SUB_RAK,NAMA_SUB_RAK FROM M_TRADER_SUB_RAK WHERE KODE_GUDANG='".$data['KODE_GUDANG']."' AND KODE_RAK='".$data['KODE_RAK']."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."'", "KODE_SUB_RAK", "NAMA_SUB_RAK", FALSE);
								$child = "";
								if($a!=1) $child = 'child';
								$DATADTL .= '<tr class="trGudang'.$a.' '.$child.'" id="tr_'.$a.'">
												<td valign="top">
													<table border="0" id="TblGdg">
														<tr>
											  				<td>Gudang <span class="Gno">'.$a.'</span></td>
															 <td>:</td>
											  				<td id="tdGudang'.$a.'"><combo>'.form_dropdown('DATADTL[KODE_GUDANG][]',$COMBOGDG, $data['KODE_GUDANG'], 'id="KODE_GUDANG" class="mtext date ac_input" onChange="getRak('.$a.')" wajib="yes" ').'</combo><input type="hidden" name="DATADTL[KODE_GUDANG_HIDE][]" value="'.$data['KODE_GUDANG'].'"><input type="hidden" name="DATADTL[JUMLAH_HIDE][]" value="'.$data['JUMLAH'].'" class="JUMLAHHIDES"></td>
														</tr>
										  			</table>
												</td>
												<td valign="top">
													<table border="0" id="TblKds">
														<tr>
											  				<td>Kondisi <span class="Kno">'.$a.'</span></td>
															 <td>:</td>
											  				<td id="tdKondisi'.$a.'"><combo>'.form_dropdown('DATADTL[KONDISI_BARANG][]',array('BAIK'=>'BAIK','RUSAK'=>'RUSAK'), $data['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="stext date ac_input" wajib="yes"').'</combo><input type="hidden" name="DATADTL[KONDISI_BARANG_HIDE][]" value="'.$data['KONDISI_BARANG'].'"></td>
														</tr>
													</table>
												</td>			
												<td valign="top">
													<table id="TblRak">
														<tr>
															<td>Rak <span class="Rno">'.$a.'</span></td>
															<td>:</td>
															<td id="tdRak'.$a.'"><combo>'.form_dropdown('DATADTL[KODE_RAK][]',$RAK, $data['RAK'], 'id="KODE_RAK" class="text date ac_input" wajib="yes" onChange="getSubrak('.$a.')" '.$disabled).'</combo><input type="hidden" name="DATADTL[KODE_RAK_HIDE][]" value="'.$data['KODE_RAK'].'"></td>
														</tr>
													</table>
												</td>
												<td valign="top">
													<table id="TblSRak">
														<tr>
															<td>Sub Rak <span class="SRno">'.$a.'</span></td>
															<td>:</td>
															<td id="tdSubRak'.$a.'"><combo>'.form_dropdown('DATADTL[KODE_SUB_RAK][]',$SUBRAK, $data['SUB_RAK'], 'id="KODE_SUB_RAK" class="text date ac_input" wajib="yes" '.$disabled).'</combo><input type="hidden" name="DATADTL[KODE_SUB_RAK_HIDE][]" value="'.$data['KODE_SUB_RAK'].'"></td>
															
														<td>';
								if($a==1){					  
									$DATADTL .= '<a href="javascript:void(0)" onclick="addgudang(1)" style="margin-left:20px;color:#60C060;font-size:22px" title="Tambah" id="Tambah"><i class="fa fa-plus-circle"></i></a>';
								}else{
									$DATADTL .= '<a href="javascript:void(0)" onclick="Removegudang(\''.$a.'\')" title="Hapus" style="margin-left:20px;color:#DF4B33;font-size:22px"><i class="fa fa-minus-circle"></i></a>';	
								}
								$DATADTL .= '</td>
											</tr>
											</table>
											</td>
												
											</tr>';
								$a++;	
							}
						}
					}
				}
			}
			return array_merge($dataarray,array("DATADTL"=>$DATADTL));
		}
		elseif($tipe=="stock" || $tipe=="stock_new"|| $tipe=="stockPOP" || $tipe=="stock_detil" || $tipe=="stockPOPN"|| $tipe=="stock_view" || $tipe=="stockPOPDtl"){
			if($key1){
				if($tipe!="stockPOP") $KONDISI = "AND A.KODE_BARANG = '".$kdbaranag."'";
				$query="SELECT A.ID,A.KODE_TRADER,A.KODE_BARANG,A.JNS_BARANG,A.TANGGAL_STOCK,A.JUMLAH,A.KETERANGAN,B.URAIAN_BARANG,
						f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS_BARANG' FROM M_TRADER_STOCKOPNAME A ,M_TRADER_BARANG B
						WHERE A.ID='".$key1."' AND B.KODE_BARANG=A.KODE_BARANG 
						AND B.KODE_TRADER='".$idTrader."' ".$KONDISI." AND A.KODE_TRADER= B.KODE_TRADER";
			}else{
				$query = "SELECT A.KODE_TRADER, A.KODE_ID 'KODE_ID_TRADER', A.ID, A.NAMA 'NAMA_TRADER', A.ALAMAT 'ALAMAT_TRADER', A.TELEPON, 
						  A.KODE_API, A.NOMOR_API,
						  B.NOMOR_SKEP 'REGISTRASI', C.NAMA 'NAMA_CP', C.TELEPON 'TELP_CP', C.EMAIL 'EMAIL_CP',
						  ID AS 'ID_TRADER',
						  0 AS 'FOB', 0 AS 'FREIGHT', 0 AS 'ASURANSI', 0 AS 'CIF', 0 AS 'CIFRP', 0 AS 'BRUTO', 0 AS 'NETTO', 0 AS 'TAMBAHAN',
						  0 AS 'DISKON', 0 AS 'NILAI_INVOICE', 0 AS 'NDPBM'
						  FROM M_TRADER A, M_TRADER_SKEP B, T_USER C WHERE A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=C.KODE_TRADER
						  AND A.KODE_TRADER='$idTrader'";
			}
			$hasil = $conn->main->get_result($query);
			if($hasil){
				foreach($query->result_array() as $row){
					$dataarray = $row;
				}
			}
			#echo "sini sini";
			return $dataarray;
		}
		elseif($tipe=="stockPOPDtl2"){
			$expl = explode(",",$key1);
			$id = $expl[0];
			$idHdr = $expl[1];
			
			$SQL = "SELECT IDHDR, JENIS_DOK_MASUK, NO_DOK_MASUK, TGL_DOK_MASUK, JUMLAH, KETERANGAN
					FROM m_trader_stockopname_dtl
					WHERE IDDTL = '".$id."' AND IDHDR = '".$idHdr."'";//echo $SQL;die();
			$hasil = $this->db->query($SQL);
			$data = $hasil->row();
			
			return $data;
		}
		elseif($tipe=="konversi_new" || $tipe=="konversi_detil" || $tipe=="konversiPOP" || $tipe=="konversiPOPN"|| $tipe=="konversiPOPget" || $tipe=="konversi_view"|| $tipe=="konversi_subPOPN"|| $tipe=="konversi_sub_new" || $tipe=="konversi_sub_detil" ||$tipe=="konversi_subPOP" || $tipe=="konversi_sub_view"){
			if($tipe=="konversiPOPget"){
				$IDBB=$this->uri->segment(6);
				$query= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER,A.KODE_SATUAN,A.KODE_BARANG,B.URAIAN_BARANG,
						 B.MERK,B.TIPE,B.UKURAN,B.SPFLAIN,A.JNS_BARANG,
						 f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						 f_jumBB(A.IDBJ) AS 'JUMLAH ITEM BAHAN BAKU' ,A.KETERANGAN 
						 FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B 
						 WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
						 AND A.KODE_TRADER=B.KODE_TRADER
						 AND A.IDBB='$IDBB' AND B.KODE_TRADER='".$idTrader."'";
			}
			elseif($key1){
				$query= "SELECT A.NOMOR_KONVERSI,A.IDBJ,A.KODE_TRADER, A.KODE_BARANG,B.URAIAN_BARANG,A.KODE_SATUAN,
						 B.MERK,B.TIPE,B.UKURAN,B.SPFLAIN,A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,
						 A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',f_jumBB(A.IDBJ) AS 'JUMLAH ITEM BAHAN BAKU' ,A.KETERANGAN 
						 FROM M_TRADER_KONVERSI_BJ A, M_TRADER_BARANG B 
						 WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
						 AND A.KODE_TRADER=B.KODE_TRADER
						 AND A.KODE_TRADER='".$idTrader."'"; 
			}else{
				$query = "SELECT A.KODE_TRADER, A.KODE_ID 'KODE_ID_TRADER', A.ID, A.NAMA 'NAMA_TRADER', A.ALAMAT 'ALAMAT_TRADER', A.TELEPON, 
						  A.KODE_API, A.NOMOR_API,
						  B.NOMOR_SKEP 'REGISTRASI', C.NAMA 'NAMA_CP', C.TELEPON 'TELP_CP', C.EMAIL 'EMAIL_CP',
						  ID AS 'ID_TRADER',
						  0 AS 'FOB', 0 AS 'FREIGHT', 0 AS 'ASURANSI', 0 AS 'CIF', 0 AS 'CIFRP', 0 AS 'BRUTO', 0 AS 'NETTO', 0 AS 'TAMBAHAN',
						  0 AS 'DISKON', 0 AS 'NILAI_INVOICE', 0 AS 'NDPBM'
						  FROM M_TRADER A, M_TRADER_SKEP B, T_USER C WHERE A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=C.KODE_TRADER
						  AND A.KODE_TRADER='$idTrader' GROUP BY A.KODE_TRADER";
			}
			$hasil = $conn->main->get_result($query);
			if($hasil){
				foreach($query->result_array() as $row){
					$dataarray = $row;
				}
			}	
			return $dataarray;

		}
	}
	
	function set_inventory($action="", $tipe=""){
		$func = get_instance();
		$func->load->model("main","main", true);
		$KODE_TRADER=$this->newsession->userdata("KODE_TRADER");
		if($action=="delete"){
			$ret = "MSG#ERR#Hapus data gagal";
			if($tipe=="stock_opname"){
				$dataCheck = $this->input->post('tb_chkfstock_opname');
				foreach($dataCheck as $chkitem){
					$arrchk = explode(".", $chkitem);
					$TGL = $arrchk[1];
					$KODE = $arrchk[2];		
					$SQL = "SELECT ID FROM M_TRADER_STOCKOPNAME WHERE TANGGAL_STOCK='".$TGL."' AND KODE_TRADER='".$KODE_TRADER."'";
					$rs = $this->db->query($SQL);
					if($rs->num_rows()>0){
						foreach($rs->result_array() as $data){
							$this->db->where(array('IDHDR'=>$data['ID']));	
							$this->db->delete('m_trader_stockopname_dtl');
						}
					}			
					$this->db->where(array('TANGGAL_STOCK'=>$TGL,'KODE_TRADER'=>$KODE_TRADER));	
					$exec = $this->db->delete('m_trader_stockopname');										
				}
				if($exec){
					$func->main->activity_log('DELETE DATA STOCKOPNAME','TANGGAL_STOCK='.$TGL);
					$ret = "MSG#OK#Hapus data Stock Berhasil#".site_url()."/inventory/daftar_dok/stock_opname#";
				}
				echo $ret;
			}elseif($tipe=="stockPOPDtl"){
				$dataCheck = $this->input->post('tb_chkfstockPOPDtl');
				foreach($dataCheck as $chkitem){
					$arrchk = explode(".", $chkitem);
					$ID = $arrchk[0];
					$IDHDR = $arrchk[1];	
					$this->db->where(array('IDHDR'=>$IDHDR,'IDDTL'=>$ID));	
					$exec = $this->db->delete('m_trader_stockopname_dtl');
					if($exec){
						$SQL = "SELECT KODE_BARANG,JNS_BARANG,TANGGAL_STOCK 
								FROM M_TRADER_STOCKOPNAME WHERE ID='".$IDHDR."' AND KODE_TRADER='".$KODE_TRADER."'";
						$rsx = $this->db->query($SQL);
						if($rsx->num_rows()>0){
							$data = $rsx->row();
							$func->main->activity_log('DELETE DATA DOKUMEN DETIL STOCKOPNAME','TANGGAL_STOCK='.$data->TANGGAL_STOCK.',KODE_BARANG='.$data->KODE_BARANG.',JNS_BARANG='.$data->JNS_BARANG);
						}											
						$ret = "MSG#OK#Hapus data Stock Berhasil#".site_url()."/inventory/edit/stockPOPDtl/".$this->uri->segment(4)."#";
					}
				}
				echo $ret;
			}elseif($tipe=="konversi" || $tipe=="konversi_sub"){
				if($tipe=="konversi"){
					$dataCheck = $this->input->post('tb_chkfkonversi');
					$FLAG="N";
				}
				else{
					$dataCheck = $this->input->post('tb_chkfkonversi_sub');
					$FLAG="Y";
				}
				foreach($dataCheck as $chkitem){
					$arrchk = explode("|", $chkitem);
					$ID = $arrchk[0];
					$KODE = $arrchk[1];
					$SQL = "SELECT NOMOR_KONVERSI FROM M_TRADER_KONVERSI_BJ WHERE IDBJ='".$ID."' AND KODE_TRADER='".$KODE_TRADER."'";
					$rsx = $this->db->query($SQL);
					if($rsx->num_rows()>0){
						$NOKONV = $rsx->row()->NOMOR_KONVERSI;
					}
					$this->db->where(array('IDBJ' => $ID,'KODE_TRADER'=>$KODE));	
					$this->db->delete('m_trader_konversi_bb');
					$this->db->where(array('IDBJ' => $ID,'KODE_TRADER'=>$KODE,'SUBKONTRAK'=>$FLAG));	
					$this->db->delete('m_trader_konversi_bj');
					if($tipe=="konversi")$ret = "MSG#OK#Hapus data Konversi Berhasil#".site_url()."/inventory/daftar_dok/konversi#";
					elseif($tipe=="konversi_sub")$ret = "MSG#OK#Hapus data Konversi Subkontrak Berhasil#".site_url()."/inventory/daftar_dok/konversi_sub#";
					$func->main->activity_log('DELETE DATA KONVERSI','NOMOR_KONVERSI='.$NOKONV);
				}
				echo $ret;
			}
			elseif($tipe=="stock_detil"){
				$dataCheck = $this->input->post('tb_chkfstock_detil');
				foreach($dataCheck as $chkitem){
					$arrchk = explode(".", $chkitem);
					$ID = $arrchk[0];
					$TGL = $arrchk[1];
					$KODE = $arrchk[2];	
					$SQL = "SELECT  KODE_BARANG, JNS_BARANG, TANGGAL_STOCK, JUMLAH
							FROM M_TRADER_STOCKOPNAME WHERE ID='".$ID."' AND KODE_TRADER='".$KODE_TRADER."'";
					$rsx = $this->db->query($SQL);
					if($rsx->num_rows()>0){
						$data = $rsx->row();
						$KODE_BARANG = $data->KODE_BARANG;
						$JNS_BARANG = $data->JNS_BARANG;
						$TANGGAL_STOCK = $data->TANGGAL_STOCK;
						$JUMLAH = $data->JUMLAH;
					}			
					$this->db->where(array('IDHDR' => $ID));	
					$this->db->delete('m_trader_stockopname_dtl');	
					$this->db->where(array('ID' => $ID,'TANGGAL_STOCK' => $TGL,'KODE_TRADER'=>$KODE));	
					$this->db->delete('m_trader_stockopname');
					
					$func->main->activity_log('DELETE DATA DETIL STOCKOPNAME','KODE_BARANG='.$KODE_BARANG.',JNS_BARANG='.$JNS_BARANG.',TANGGAL_STOCK='.$TANGGAL_STOCK.',JUMLAH='.$JUMLAH);
					$ret = "MSG#OK#Hapus data Stock Berhasil#".site_url()."/inventory/edit/stock_list_detil/".$ID."/".$TGL."#";
				}
				echo $ret;
			}
			elseif($tipe=="stock_new"){
				$dataCheck = $this->input->post('tb_chkfstock_new');
				foreach($dataCheck as $chkitem){
					$arrchk = explode("|", $chkitem);
					$ID = $arrchk[0];
					$TGL = $arrchk[1];
					$KODE = $arrchk[2];				
					$this->db->where(array('ID' => $ID,'TANGGAL_STOCK' => $TGL,'KODE_TRADER'=>$KODE));	
					$this->db->delete('m_trader_stockopname');
					$this->db->where(array('IDHDR' => $ID));	
					$this->db->delete('m_trader_stockopname_dtl');
					$func->main->activity_log('DELETE DATA STOCKOPNAME','TANGGAL_STOCK='.$TGL);
					$ret = "MSG#OK#Hapus data Stock Berhasil#".site_url()."/inventory/edit/stock_list_detil/".$ID."/".$TGL."#";
				}
				echo $ret;
			}
			elseif($tipe=="konversi_detil" || $tipe=="konversi_sub_detil"){
				if($tipe=="konversi_detil")$dataCheck = $this->input->post('tb_chkfkonversi_detil');
				else $dataCheck = $this->input->post('tb_chkfkonversi_sub_detil');
				foreach($dataCheck as $chkitem){
					$arrchk = explode("|", $chkitem);
					$IDBJ = $arrchk[0];
					$KODE = $arrchk[1];
					$IDBB = $arrchk[2];	
					/*$SQL = "SELECT KODE_BARANG, JNS_BARANG, TANGGAL_STOCK, JUMLAH
							FROM m_trader_konversi_bb WHERE IDBJ='".$IDBJ."' AND KODE_TRADER='".$KODE."' AND IDBB='".$IDBB."'";
					$rs = $this->db->query($SQL);
					if($rs->num_rows()>0){
						$data = $rs->row();
					}				
					
					$SQL = "SELECT NOMOR_KONVERSI FROM m_trader_konversi_bb WHERE IDBJ='".$IDBJ."' 
							AND KODE_TRADER='".$KODE_TRADER."' AND IDBB='".$IDBB."'";
					$rsx = $this->db->query($SQL);
					if($rsx->num_rows()>0){
						$NOKONV = $rsx->row()->NOMOR_KONVERSI;
					}*/
					
					$this->db->where(array('IDBJ'=>$IDBJ,'KODE_TRADER'=>$KODE,'IDBB'=>$IDBB));	
					$this->db->delete('m_trader_konversi_bb');					
					if($tipe=="konversi_detil")
					$ret = "MSG#OK#Hapus data Konversi Berhasil#".site_url()."/inventory/edit/konversi_list_detil/".$IDBJ."/".$KODE."#";
					else
					$ret = "MSG#OK#Hapus data Konversi Berhasil#".site_url()."/inventory/edit/konversi_sub_list_detil/".$IDBJ."/".$KODE."#";
					$func->main->activity_log('DELETE DATA KONVERSI BAHAN BAKU','NOMOR_KONVERSI='.$NOKONV);		
				}
				echo $ret;
			}
			elseif($tipe=="konversi_new" || $tipe=="konversi_sub_new"){
				if($tipe=="konversi_new")$dataCheck = $this->input->post('tb_chkfkonversi_new');
				else $dataCheck = $this->input->post('tb_chkfkonversi_sub_new');
				foreach($dataCheck as $chkitem){
					$arrchk = explode("|", $chkitem);
					$IDBJ = $arrchk[0];
					$KODE = $arrchk[1];
					$IDBB = $arrchk[2];	
					$SQL = "SELECT B.NOMOR_KONVERSI AS 'NK' FROM m_trader_konversi_bb A 
							INNER JOIN m_trader_konversi_bj B ON B.IDBJ=A.IDBJ WHERE A.IDBJ='".$IDBJ."' 
							AND A.KODE_TRADER='".$KODE_TRADER."' AND A.IDBB='".$IDBB."'";
					$rsx = $this->db->query($SQL);
					if($rsx->num_rows()>0){
						$NOKONV = $rsx->row()->NK;
					}
						
					$this->db->where(array('IDBJ' => $IDBJ,'KODE_TRADER' => $KODE,'IDBB'=>$IDBB));	
					$this->db->delete('m_trader_konversi_bb');
					if($tipe=="konversi_new")
					$ret = "MSG#OK#Hapus data Konversi Berhasil#".site_url()."/inventory/add/konversi_list_new/".$IDBJ."/".$KODE."#";
					else
					$ret = "MSG#OK#Hapus data Konversi Berhasil#".site_url()."/inventory/add/konversi_sub_list_new/".$IDBJ."/".$KODE."#";
					$func->main->activity_log('DELETE DATA KONVERSI BAHAN BAKU','NOMOR_KONVERSI='.$NOKONV);	
				}
				echo $ret;
			}
		}
	}
	
	function getlistDataInv($mulai,$typeCari,$uraiCari){
		$type=$this->input->post('type');
		$addSql = "";
		$addWhere="";
		$addAnd="";
		if($type=="proses_produksi"){
			$addWhere="JNS_BARANG='6'";
		}elseif($type=="bahanBaku"){
			$addWhere="JNS_BARANG NOT IN ('6')";
		}elseif($type=="proses_sisa"){
			$addWhere="JNS_BARANG='7'";
		}
		if (trim($typeCari) != ""){
			if($addWhere!="") $addAnd=" AND ";
			if($typeCari=="KODE_BARANG"){
				$addSql =$addAnd."KODE_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
			}elseif($typeCari=="URAIAN_BARANG"){
				$addSql =$addAnd."URAIAN_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
			}
		}
		if (trim($addSql) != ""|| trim($addWhere) != ""){
			$addSql = " WHERE KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."' AND ".$addWhere.$addSql;//echo $addSql;die();
		}
		$SQL="SELECT KODE_BARANG,URAIAN_BARANG,JNS_BARANG,f_ref('ASAL_JENIS_BARANG',JNS_BARANG) AS 'JENIS_BARANG',
			  STOCK_AKHIR,MERK,TIPE,UKURAN,KODE_SATUAN,SPFLAIN,f_satuan(KODE_SATUAN) AS 'URAIAN_SATUAN' 
			  FROM M_TRADER_BARANG".$addSql." LIMIT ".$mulai.", ".DATA_PER_PAGE;//echo $SQL;//die();
		$result = $this->db->query($SQL);	
		return $result->result_array();	
	}
	
	function gettotalListInv($typeCari,$uraiCari){
		$type=$this->input->post('type');
		$addSql = "";
		$addWhere="";
		$addAnd="";
		if($type=="proses_produksi"){
			$addWhere="JNS_BARANG='6'";
		}elseif($type=="bahanBaku"){
			$addWhere="JNS_BARANG NOT IN ('6')";
		}elseif($type=="proses_sisa"){
			$addWhere="JNS_BARANG='7'";
		}else{
			$addWhere="";
		}
		if (trim($typeCari) != ""){
			if($addWhere!="") $addAnd=" AND ";
			if($typeCari=="KODE_BARANG"){
				$addSql =$addAnd."KODE_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
			}elseif($typeCari=="URAIAN_BARANG"){
				$addSql =$addAnd."URAIAN_BARANG LIKE '%".trim(addslashes($uraiCari))."%'";
			}
		}
		if (trim($addSql) != "" || trim($addWhere) != ""){
			$addSql = " WHERE KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."' AND ".$addWhere.$addSql;
		}
		$sql = "SELECT COUNT(*) AS banyak FROM
                M_TRADER_BARANG".$addSql;
		$result = $this->db->query($sql);
		$row = $result->row();
		$banyak = $row->banyak;
		$banyakIndex = ceil(($banyak/DATA_PER_PAGE));
		return $banyakIndex;;
	}
	
	function detil($type="",$key1="",$key2=""){
		$tipe="barang";
		$conn = get_instance();
		$conn->load->model("main");
		$this->load->library('newtable');
		$KODETRADER = $this->newsession->userdata('KODE_TRADER');
		if($type=="stock_detil" || $type=="stock_new" || $type=="stock_view" || $type=="stockPOPDtl"){
			if($type=="stock_detil"){
				$SQL= "SELECT A.ID,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH AS 'STOCK OPNAME',
						A.KETERANGAN,TANGGAL_STOCK, A.KODE_BARANG
						FROM M_TRADER_STOCKOPNAME A,M_TRADER_BARANG B WHERE A.TANGGAL_STOCK='$key2' 
						AND B.KODE_BARANG=A.KODE_BARANG AND A.JNS_BARANG=B.JNS_BARANG AND A.KODE_TRADER=B.KODE_TRADER 
						AND A.KODE_TRADER='".$KODETRADER."'";
				$process = array('Tambah' => array('DIALOG-500;500', site_url()."/inventory/add/stockPOP/".$key1."/".$key2, '0','fa fa-plus'),
					 			 'Ubah' => array('DIALOG-500;500', site_url()."/inventory/edit/stockPOP", '1','fa fa-edit'),
					 			 'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$type, 'stock_detil','fa fa-times'));
				$this->newtable->action(site_url()."/inventory/edit/stock_list_detil/".$key1."/".$key2);
				$this->newtable->tipe_proses('button');
				$this->newtable->detail(site_url()."/inventory/add/stockPOPDtl");
				$this->newtable->detail_tipe("detil_priview_bottom");		
				$this->newtable->orderby("1");
			}elseif($type=="stock_new"){
				$SQL= "SELECT A.ID,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
					   A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH AS 'STOCK OPNAME',
					   A.KETERANGAN,TANGGAL_STOCK FROM M_TRADER_STOCKOPNAME A,M_TRADER_BARANG B 
					   WHERE A.TANGGAL_STOCK='".$this->uri->segment(4)."' AND B.KODE_BARANG=A.KODE_BARANG AND A.JNS_BARANG=B.JNS_BARANG 
					   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER='".$KODETRADER."'";
				$process = array('Tambah' => array('GET2POP', site_url()."/inventory/add/stockPOPN/".$key1."/".$key2, '0','fa fa-plus'),
					 			 'Ubah' => array('GET2POP', site_url()."/inventory/edit/stockPOPN", '1','fa fa-edit'),
					 			 'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$type, 'stock_detil','fa fa-times'));
				$this->newtable->action(site_url()."/inventory/edit/stock_list_detil/".$key1."/".$key2);
				$this->newtable->tipe_proses('button');
				$this->newtable->detail(site_url()."/inventory/add/stockPOPDtl");
				$this->newtable->detail_tipe("detil_priview_bottom");
			}elseif($type=="stockPOPDtl"){
				$data = explode('.',$key1);
				$id = $data[0];
				$tgl = $data[1];
				$kodeTrader = $data[2];
				$kode_barang = $data[3];
				
				$SQL= "SELECT A.JENIS_DOK_MASUK 'Jenis Dokumen', A.NO_DOK_MASUK 'Nomor Dokumen',						 		   
					   A.TGL_DOK_MASUK 'Tanggal Dokumen', A.JUMLAH 'Jumlah', A.KETERANGAN, A.IDDTL, A.IDHDR
					   FROM m_trader_stockopname_dtl A LEFT JOIN m_trader_stockopname B ON A.IDHDR = B.ID
					   WHERE A.IDHDR = '".$id."' AND B.KODE_BARANG = '".$kode_barang."' AND B.KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'";

				$process = array('Tambah' => array('DIALOG_STOCK', site_url()."/inventory/add/stockPOPDtl2/".$key1, '0','fa fa-plus'),
					 			 'Ubah' => array('DIALOG_STOCK', site_url()."/inventory/edit/stockPOPDtl2/".$key1, '1','fa fa-edit'),
					 			 'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$type."/".$key1, 'stock_detil','fa fa-times'));
				$this->newtable->action(site_url()."/inventory/edit/stockPOPDtl/".$key1."/".$key2);
				$this->newtable->tipe_proses('button');
				$this->newtable->keys(array('IDDTL','IDHDR'));
				$this->newtable->hiddens(array('IDDTL','IDHDR'));
			}elseif($type=="stock_view"){
				$SQL = "SELECT A.ID, A.KODE_TRADER, B.KODE_PARTNER, A.KODE_BARANG,
						f_ref('ASAL_JENIS_BARANG', A.JNS_BARANG) AS JENIS_BARANG,
						B.URAIAN_BARANG, B.KODE_SATUAN , A.JUMLAH, A.KETERANGAN, 
						A.TANGGAL_STOCK 
					   	FROM M_TRADER_STOCKOPNAME A,M_TRADER_BARANG B 
					  	WHERE A.TANGGAL_STOCK='$key2' AND A.JNS_BARANG=B.JNS_BARANG 
						AND A.KODE_TRADER=B.KODE_TRADER AND B.KODE_BARANG=A.KODE_BARANG 
						AND A.KODE_TRADER='".$KODETRADER."'
						ORDER BY B.KODE_PARTNER, A.KODE_BARANG";
				$result = $this->db->query($SQL);	
				$row = $result->result_array();
				$kirim = array('header'=>$row);					
				return $kirim;	
			}			
			if($type!="stockPOPDtl"){
				$this->newtable->search(array(array('A.KODE_BARANG', 'KODE BARANG'), 
									  array('B.URAIAN_BARANG', 'URAIAN BARANG'),
									  array('A.JNS_BARANG', 'JENIS BARANG','tag-select',$conn->main->get_mtabel('ASAL_JENIS_BARANG'))));
			}else{
				$this->newtable->search(array(array('A.JENIS_DOK_MASUK', 'Jenis Dokumen'), 
									  array('A.NO_DOK_MASUK', 'Nomor Dokumen')));
			}
			if($type!="stockPOPDtl") $this->newtable->keys(array("ID","TANGGAL_STOCK","KODE_TRADER","KODE BARANG"));
			if($type == "stckPOP")
				$this->newtable->keys(array("ID","TANGGAL_STOCK","KODE_TRADER","KODE_BARANG"));
			$this->newtable->hiddens(array('ID','KODE_TRADER','JNS_BARANG','TANGGAL_STOCK', 'KODE_BARANG'));			
		}
		elseif($type=="konversi_new" || $type=="konversi_detil" || $type=="konversi_view" || $type=="konversi_sub_new" || $type=="konversi_sub_detil" || $type=="konversi_sub_view" || $type=="detil_konversi"){
			if($type=="konversi_new"){
				$SQL= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
						AND A.KODE_TRADER='$key2' AND A.KODE_TRADER=B.KODE_TRADER ";

				$process = array('Tambah' => array('GET2POP', site_url()."/inventory/add/konversiPOPN/".$key1."/".$key2, '0','fa fa-plus'),
							 'Ubah' => array('GET2POP', site_url()."/inventory/edit/konversiPOPN", '1','fa fa-edit'),
							 'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$type, 'konversi_detil','fa fa-times'));
			}

			elseif($type=="konversi_detil"){
				$SQL= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND 
						A.KODE_TRADER=B.KODE_TRADER AND A.IDBJ='$key1' AND A.KODE_TRADER='$key2'";//echo $SQL;
				$process = array('Tambah' => array('GET2POP', site_url()."/inventory/add/konversiPOP/".$key1."/".$key2, '0','fa fa-plus'),
							 'Ubah' => array('GET2POP', site_url()."/inventory/edit/konversiPOP", '1','fa fa-edit'),
							 'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$type, 'konversi_detil','fa fa-times'));
			}
			elseif($type=="konversi_view"){
				$SQL= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
						AND A.KODE_TRADER='$key2' AND A.KODE_TRADER=B.KODE_TRADER ";#echo $SQL;die();
				$process = "";
				$this->newtable->show_chk(FALSE);
			}
			elseif($type=="detil_konversi"){
				$SQL= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
						AND A.KODE_TRADER='$key2' AND A.KODE_TRADER=B.KODE_TRADER ";//echo $SQL;
				$process = "";
				$this->newtable->show_chk(FALSE);
			}
			elseif($type=="konversi_sub_new"){
				$SQL= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1'
				 		AND A.KODE_TRADER='$key2' AND A.KODE_TRADER=B.KODE_TRADER ";//echo $SQL;
				$process = array('Tambah' => array('GET2POP', site_url()."/inventory/add/konversi_subPOPN/".$key1."/".$key2, '0','fa fa-plus'),
							 'Ubah' => array('GET2POP', site_url()."/inventory/edit/konversi_subPOPN", '1','fa fa-edit'),
							 'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$type, 'konversi_sub_detil','fa fa-times'));
			}
			elseif($type=="konversi_sub_detil"){
				$POSTURI = $this->input->post("uri");
				if($POSTURI){
					$TEMPSQL="SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
							  A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
							  A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
							  AND A.KODE_TRADER='$key2' GROUP BY A.KODE_BARANG";
					$ADDSQL = $conn->main->getWhere($TEMPSQL,$POSTURI,array("A.KODE_BARANG","B.URAIAN_BARANG"));//echo $ADDSQL;			
				}
				
				$SQL= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
						AND A.KODE_TRADER='$key2'";//echo $SQL;
				$SQL .=$ADDSQL." GROUP BY A.KODE_BARANG";
				$process = array('Tambah' => array('GET2POP', site_url()."/inventory/add/konversi_subPOPN/".$key1."/".$key2, '0','fa fa-plus'),
							 'Ubah' => array('GET2POP', site_url()."/inventory/edit/konversi_subPOPN", '1','fa fa-edit'),
							 'Hapus' => array('DELETE', site_url().'/inventory/set_inventory/'.$type, 'konversi_sub_detil','fa fa-times'));
			}
			elseif($type=="konversi_sub_view"){
				$SQL= "SELECT A.IDBJ,A.IDBB,A.KODE_TRADER, A.KODE_BARANG AS 'KODE BARANG',B.URAIAN_BARANG AS 'URAIAN BARANG',
						A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'JENIS BARANG' ,A.JUMLAH,f_satuan(A.KODE_SATUAN) AS 'SATUAN',
						A.KETERANGAN FROM M_TRADER_KONVERSI_BB A,M_TRADER_BARANG B WHERE B.KODE_BARANG=A.KODE_BARANG AND A.IDBJ='$key1' 
						AND A.KODE_TRADER='$key2'";//echo $SQL;
				$process = "";
				$this->newtable->show_chk(FALSE);
			}
			
			if($type!='detil_konversi') 
				$this->newtable->action(site_url()."/inventory/edit/konversi_list_detil/".$key1."/".$key2);
			elseif($type=='detil_konversi') 
				$this->newtable->action(site_url()."/inventory/edit/detil_list_konversi/".$key1."/".$key2);
				
			$this->newtable->search(array(array('A.KODE_BARANG', 'KODE BARANG'), array('B.URAIAN_BARANG', 'URAIAN BARANG')));
			$this->newtable->keys(array('IDBJ','KODE_TRADER','IDBB'));
			$this->newtable->hiddens(array('IDBJ','IDBB','KODE_TRADER','JNS_BARANG'));
			$this->newtable->tipe_proses('button');
			
		}else{
			return "Failed";exit();
		}		
		if($type!="stock_view"){
			$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
			$this->newtable->cidb($this->db);
			$this->newtable->set_formid("f".$type);
			$this->newtable->set_divid("div".$type);
			$this->newtable->ciuri($ciuri);
			$this->newtable->orderby("1");
			$this->newtable->sortby("ASC");
			$this->newtable->clear();
			$this->newtable->rowcount(20);		
			$this->newtable->menu($process);
			$tabel .= $this->newtable->generate($SQL);			
			$arrdata = array("judul" => $judul,
							 "tabel" => $tabel);
			if($this->input->post("ajax") || $this->input->post("act")=="delete") return $tabel;				 
			else return $arrdata;
		}
	} 
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function barang($tipe=""){
		$func = get_instance();
		$func->load->model("main");
		$this->load->library('newtable');
		$kode_role = $this->newsession->userdata('KODE_ROLE');
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		if(!in_array($kode_role,array("3","5"))){#ROLE BUKAN BC DAN BUKAN ADMIN PENYELENGGARA
			$prosesnya = array(	
								'Add' 		=> array('GET2', site_url()."/inventory/barang/save", '0','icon-plus'),
								'Edit' 		=> array('EDITJS', site_url()."/inventory/barang/update", '1','icon-edit'),
								'Delete' 	=> array('DELETE', site_url().'/inventory/barang/delete', 'barang','red icon-trash'),
								'Print PDF' => array('DIALOG-500;350', site_url()."/inventory/popupcetak/barang/pdf", '0','red icon-print'),
								'Print XLS' => array('DIALOG-500;350', site_url()."/inventory/popupcetak/barang/excel", '0','green icon-print'),
								'Warehouse' => array('GET2', site_url()."/inventory/pindah_gudang",'1','icon-exchange'),
								'Active' 	=> array('ACTIVE', site_url()."/inventory/status",'active','green icon-check'),
								'Inactive' 	=> array('ACTIVE', site_url()."/inventory/status",'inactive','red icon-remove')
							);
			$this->newtable->keys(array("KODE_BRG","JNS_BARANG"));
		}else{
			$prosesnya = array(	
								'Print PDF' => array('DIALOG-500;300', site_url()."/inventory/popupcetak/barang/pdf", '0','red icon-print'),
								'Print XLS' => array('DIALOG-500;300', site_url()."/inventory/popupcetak/barang/excel", '0','green icon-print')
							);
			$this->newtable->keys(array("KODE_BRG","JNS_BARANG","KODE_TRADER"));
		}
		if(!in_array($kode_role,array("3"))){
			$FIELD = "";
			$WHERE = " WHERE KODE_TRADER = '".$kode_trader."'";
		}else{
			$FIELD = " ,f_trader(KODE_TRADER) AS 'NAMA ANGGOTA'";
			$WHERE = " WHERE KODE_TRADER = '".$this->newsession->userdata("ANGGOTA_PLB")."' ";
		}
		$SQL= 'SELECT KODE_PARTNER "KODE PERUSAHAAN", KODE_BARANG "KODE BARANG",URAIAN_BARANG "NAMA BARANG",
			   f_ref("ASAL_JENIS_BARANG",JNS_BARANG) "JENIS BARANG",KODE_TRADER,
			   f_formaths(KODE_HS) "KODE HS", MERK, UKURAN,  KODE_SATUAN "SATUAN TERBESAR", 
			   KODE_SATUAN_TERKECIL "SATUAN TERKECIL", 
			   CONCAT("1 ",KODE_SATUAN," = ",JML_SATUAN_TERKECIL," ",KODE_SATUAN_TERKECIL) 
			   "KONVERSI NILAI SATUAN",
			   CONCAT(IF(STOCK_AKHIR!=0,FORMAT(STOCK_AKHIR,2),STOCK_AKHIR)," ",KODE_SATUAN_TERKECIL) "STOCK GUDANG",IF(STATUS=1,"<span style=color:green>ACTIVE</span>","<span style=color:red>INACTIVE</span>") "STATUS",
			   REPLACE(REPLACE(REPLACE(KODE_BARANG, "\"", "`"), "/", "^"), " ", "~") AS "KODE_BRG", JNS_BARANG '.$FIELD.'
			   FROM M_TRADER_BARANG'.$WHERE;	

		foreach($this->input->post('CARI') as $a=>$b){
			$CARI[$a] = $b;
		}	
		if($CARI["KODE_PARTNER"]!=""&&$CARI["KODE_PARTNER"]!="0"){
			$SQL .= " AND KODE_PARTNER = '".$CARI["KODE_PARTNER"]."'";
		}
		if($CARI["URAIAN_BARANG"]!=""){
			$SQL .= " AND URAIAN_BARANG LIKE '%".$CARI["URAIAN_BARANG"]."%'";
		}
		if($CARI["KODE_BARANG"]!=""){
			$SQL .= " AND KODE_BARANG LIKE '%".$CARI["KODE_BARANG"]."%'";
		}
		if($CARI["JNS_BARANG"]!=""&&$CARI["JNS_BARANG"]!="0"){
			$SQL .= " AND JNS_BARANG = '".$CARI["JNS_BARANG"]."'";
		}
		if($CARI["MERK"]!=""){
			$SQL .= " AND MERK LIKE '%".$CARI["MERK"]."%'";
		}
		if($CARI["KODE_HS"]!=""){
			$SQL .= " AND KODE_HS LIKE '%".$CARI["KODE_HS"]."%'";
		}
		if($CARI["KODE_TRADER"]!=""){
				$SQL .= " AND KODE_TRADER = '".$CARI["KODE_TRADER"]."'";
			}
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
		$this->newtable->action(site_url()."/inventory/barang/");
		$this->newtable->detail(site_url()."/inventory/barang_detil");
		$this->newtable->detail_tipe("detil_priview_bottom");						
		$this->newtable->search(array(array('KODE_BARANG', 'KODE BARANG'), 
									  array('URAIAN_BARANG', 'URAIAN BARANG'), 
									  array('KODE_SATUAN', 'SATUAN TERBESAR&nbsp;'), 
									  array('KODE_SATUAN_TERKECIL', 'SATUAN TERKECIL&nbsp;'), 
									  array('JNS_BARANG', 'JENIS BARANG','tag-select',$func->main->get_mtabel('ASAL_JENIS_BARANG'))
									  ));	
		$this->newtable->hiddens(array("JNS_BARANG","KODE_BRG","KODE_TRADER"));
		$this->newtable->count_keys(array("KODE_BRG"));
		$this->newtable->tipe_proses('button');	
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->show_search(false);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->header_bg("#438EB9");
		$this->newtable->set_formid("fBarang");
		$this->newtable->set_divid("divBarang");
		$this->newtable->rowcount(20);
		$this->newtable->clear(); 
		$this->newtable->menu($prosesnya);	
		
		if(!($this->input->post("ajax") || $tipe=="ajax")){			
			$func->load->model('pengeluaran_act');
			$NAMA_TRADER = $this->newsession->userdata('NAMA_TRADER');
			$KODETRADE = substr(str_replace(array("PT","pt",".",","," "),"",trim($NAMA_TRADER)),0,3);
			$PARTNER =  array_merge(array("0"=>"Pilih Semua"),array($KODETRADE=>$NAMA_TRADER.' ('.$KODETRADE.')'),$func->pengeluaran_act->get_partner('','1'));			
			$JNS_BARANG = array_merge(array("0"=>"Pilih Semua"),$func->main->get_mtabel('ASAL_JENIS_BARANG',1,FALSE));
			$SQ = "SELECT KODE_TRADER, NAMA FROM M_TRADER WHERE INDUK_PLB='".$kode_trader."' ORDER BY NAMA";
			$LOKASI = $func->main->get_combobox($SQ, "KODE_TRADER", "NAMA", TRUE);
			
			$tabel .= '<form name="tblCari" id="tblCari" method="post" class="form-horizontal" action="inventory/barang" onsubmit="return frm_Cari(\'divBarang\',\'tblCari\')">';
			$tabel .= '<table width="100%">';
			$tabel .= '<tr>';
			$tabel .= '<td><strong>Kode Perusahaan</strong></td>';
			$tabel .= '<td>:</td>';
			$tabel .= '<td><combo>'.form_dropdown('CARI[KODE_PARTNER]',$PARTNER, '', 'id="KODE_PARTNER" class="mtext"').'</combo></td>';
			$tabel .= '<td><strong>Nama Barang</strong></td>';
			$tabel .= '<td>:</td>';
			$tabel .= '<td><input type="text"  name="CARI[URAIAN_BARANG]" id="URAIAN_BARANG" class="mtext" /></td>';
			$tabel .= '<td><strong>Kode HS</strong></td>';
			$tabel .= '<td>:</td>';
			$tabel .= '<td><input type="text"  name="CARI[KODE_HS]" id="KODE_HS" class="mtext" /></td>';
			$tabel .= '</tr>';
			$tabel .= '<tr>';
			$tabel .= '<td><strong>Kode Barang</strong></td>';
			$tabel .= '<td>:</td>';
			$tabel .= '<td><input type="text"  name="CARI[KODE_BARANG]" id="KODE_BARANG" class="mtext" /></td>';
			$tabel .= '<td><strong>Jenis Barang</strong></td>';
			$tabel .= '<td>:</td>';
			$tabel .= '<td><combo>'.form_dropdown('CARI[JNS_BARANG]', $JNS_BARANG, '', 'id="JNS_BARANG" class="mtext"').'</combo></td>';
			$tabel .= '<td><strong>Merk</strong></td>';
			$tabel .= '<td>:</td>';
			$tabel .= '<td><input type="text"  name="CARI[MERK]" id="MERK" class="mtext" /></td>';
			$tabel .= '</tr>';
			if($kode_role=="3"){
				$tabel .= '<tr>';
				$tabel .= '<td><strong>Nama Anggota</strong></td>';
				$tabel .= '<td>:</td>';
				$tabel .= '<td colspan="8">'.form_dropdown('CARI[KODE_TRADER]', $LOKASI, '', 'id="KODE_TRADER" class="mtext"').'</td>';
				$tabel .= '</tr>';
			}
			$tabel .= '<tr>';
			$tabel .= '<td>&nbsp;</td>';
			$tabel .= '<td>&nbsp;</td>';
			$tabel .= '<td><input type="submit" style="display:none"><a href="javascript:void(0);" class="btn btn-primary btn-sm" id="ok_" onclick="frm_Cari(\'divBarang\',\'tblCari\')" ><i class="icon-search"></i>&nbsp;Search</a>&nbsp;<a href="javascript:void(0);" class="btn btn-danger btn-sm" id="ok_" onclick="cancel(\'tblCari\')"><i class="icon-remove"></i>&nbsp;Clear</a></td>';
			$tabel .= '</tr>';
			$tabel .= '</table>';
			$tabel .= '</form><br />';
		}
			
		$tabel .= $this->newtable->generate($SQL);	
		$arrdata = array("title" => 'Data Barang',
						 "tabel" => $tabel);
		if($this->input->post("ajax") || $tipe=="ajax") return  $tabel;			 
		else return $arrdata;
	}
	
	function barang_detil($data="",$ajax=""){			
		$func = get_instance();
		$func->load->model("main");	
		$this->load->library('newtable');
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$KODE_ROLE 	 = $this->newsession->userdata('KODE_ROLE');
		$arr = explode("|",$data);
		$KODE_BARANG = str_replace("|@|",".",str_replace("^","/",str_replace("~"," ",$arr[0])));
		$JNS_BARANG = $arr[1];
		if(in_array($KODE_ROLE,array("3","5"))){
			$KODE_TRADER = $arr[2];
		}
		$SQL = "SELECT CONCAT(KODE_GUDANG,' - ',IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA')) AS 'GUDANG', 
				IFNULL(CONCAT(KODE_RAK,' - ',f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER)),'-') AS 'RAK', 
				IFNULL(CONCAT(KODE_SUB_RAK,' - ',f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER)),'-') AS 'SUB RAK', 
				".$ASAL." KONDISI_BARANG AS KONDISI, CONCAT('<span style=\"float:right\">',JUMLAH,' ',SATUAN,'</span>') 'JUMLAH'
				FROM M_TRADER_BARANG_GUDANG WHERE KODE_TRADER='".$KODE_TRADER."'
				AND JNS_BARANG='".$JNS_BARANG."' AND KODE_BARANG='".$KODE_BARANG."'";
				
		$GUDANG = "SELECT KODE_GUDANG,CONCAT(NAMA_GUDANG,' - ',KODE_GUDANG) URAIAN FROM M_TRADER_GUDANG 
				   WHERE KODE_TRADER = '".$KODE_TRADER."' ORDER BY KODE_GUDANG";
		$COMBOGDG = $func->main->get_combobox($GUDANG,"KODE_GUDANG", "URAIAN", FALSE);		
		
		$this->newtable->search(
								array(
									array('KONDISI_BARANG', 'KONDISI BARANG'),
									array('KODE_GUDANG', 'KODE GUDANG','tag-select',array_merge(array("UTAMA"=>"UTAMA"),$COMBOGDG))
								));	
									  
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
		$this->newtable->action(site_url()."/inventory/barang_detil/".$data);	
		$this->newtable->orderby('KODE_BARANG');
		$this->newtable->sortby("ASC");
		$this->newtable->keys(array("KONDISI BARANG"));
		$this->newtable->header_bg("rgb(98,155,88)");
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->set_formid("fdtlbarang");
		$this->newtable->set_divid("divdtlbarang");
		$this->newtable->rowcount(10);
		$this->newtable->show_chk(false);
		$this->newtable->clear(); 
		$table = $this->newtable->generate($SQL);	
		if($this->input->post("ajax")){
			echo $table;
		}else{
			$data = '<div class="header">
						<div class="widget-header widget-header-flat">
						  <h4 class="lighter"> <i class="icon-th" style="color:orange;"></i> Daftar Group Barang </h4>
						</div>
					  </div><div class="content">'.$table.'</div>';
			echo $data;
		}
	}
	
	function set_barang($action="", $tipe=""){
		$func = get_instance();
		$func->load->model("main","main", true);
		$KODETRADER = $this->newsession->userdata('KODE_TRADER');
		$ret = "MSG#ERR#Proses Data Gagal.#";
		if($action=="save" || $action=="update"){
			foreach($this->input->post('INVBRG') as $a => $b){
				$arrInvBrg[$a] = $b;
			}
			$arrdetil = $this->input->post('DATADTL');
			if($action=="save"){
				$SQL = "SELECT KODE_SATUAN_TERKECIL FROM M_TRADER_BARANG WHERE KODE_BARANG='".trim($arrInvBrg["KODE_BARANG"])."' 
						AND JNS_BARANG = '".$arrInvBrg["JNS_BARANG"]."' AND KODE_TRADER ='".$KODETRADER."'";
				$rs = $this->db->query($SQL);				
				if($rs->num_rows()>0){
					$SATUAN_TERKECIL = $rs->row()->KODE_SATUAN_TERKECIL;			
					$URUT = 0;
					$arrkeys = array_keys($arrdetil);
					$countdtl = count($arrdetil[$arrkeys[0]]);
					for($i=0;$i<$countdtl;$i++){
						for($j=0;$j<count($arrkeys);$j++){
							$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
						}
						$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '".trim($arrInvBrg["KODE_BARANG"])."' 
								AND JNS_BARANG = '".$arrInvBrg["JNS_BARANG"]."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
								AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' AND KODE_RAK = '".$DATADTL["KODE_RAK"]."'
								AND KODE_SUB_RAK = '".$DATADTL["KODE_SUB_RAK"]."' AND KODE_TRADER = '".$KODETRADER."'";
						$rs = $this->db->query($SQL);		
						if($rs->num_rows()>0){
							$URUT++;	
						}else{															
							$DATAGUDANG["KODE_TRADER"] 		= $KODETRADER;
							$DATAGUDANG["KODE_BARANG"] 		= trim($arrInvBrg["KODE_BARANG"]);
							$DATAGUDANG["JNS_BARANG"] 		= $arrInvBrg["JNS_BARANG"];
							$DATAGUDANG["KODE_GUDANG"] 		= $DATADTL["KODE_GUDANG"];
							$DATAGUDANG["KONDISI_BARANG"] 	= $DATADTL["KONDISI_BARANG"];
							$DATAGUDANG["KODE_RAK"] 		= $DATADTL["KODE_RAK"];
							$DATAGUDANG["KODE_SUB_RAK"] 	= $DATADTL["KODE_SUB_RAK"];
							$DATAGUDANG["SATUAN"] 			= $SATUAN_TERKECIL;
							
							$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);					
							$func->main->activity_log('TAMBAH DATA BARANG','KODE_BARANG='.trim($arrInvBrg["KODE_BARANG"]).', JNS_BARANG='.$arrInvBrg["KODE_BARANG"]);
							$ret = "MSG#OK#Penyimpanan Data Berhasil. Silahkan masukan lagi jika ingin menambahkan data barang lainnya.#";
						}					
						if($URUT==$countdtl){
							$ret =  "MSG#ERR#Kode Barang dengan Jenis Barang, Kode Gudang, Kondisi barang tersebut sudah ada#";	
						}										
					}
				}else{
					$arrkeys = array_keys($arrdetil);
					$countdtl = count($arrdetil[$arrkeys[0]]);
					for($i=0;$i<$countdtl;$i++){
						for($j=0;$j<count($arrkeys);$j++){
							$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
						}
						$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '".trim($arrInvBrg["KODE_BARANG"])."' 
								AND JNS_BARANG = '".$arrInvBrg["JNS_BARANG"]."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
								AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' AND KODE_RAK = '".$DATADTL["KODE_RAK"]."'
								AND KODE_SUB_RAK = '".$DATADTL["KODE_SUB_RAK"]."' AND KODE_TRADER = '".$KODETRADER."'";
						$rs = $this->db->query($SQL);
						if($rs->num_rows()==0){
							$DATAGUDANG["KODE_TRADER"] 		= $KODETRADER;
							$DATAGUDANG["KODE_BARANG"]		= trim($arrInvBrg["KODE_BARANG"]);
							$DATAGUDANG["JNS_BARANG"] 		= $arrInvBrg["JNS_BARANG"];
							$DATAGUDANG["KODE_GUDANG"] 		= $DATADTL["KODE_GUDANG"];
							$DATAGUDANG["KONDISI_BARANG"] 	= $DATADTL["KONDISI_BARANG"];
							$DATAGUDANG["KODE_RAK"] 		= $DATADTL["KODE_RAK"];
							$DATAGUDANG["KODE_SUB_RAK"] 	= $DATADTL["KODE_SUB_RAK"];
							$DATAGUDANG["SATUAN"] 			= $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
							$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);	
						}
					}
					$arrInvBrg["KODE_HS"] 				= str_replace(".","",$arrInvBrg["KODE_HS"]);
					$arrInvBrg["KODE_BARANG"]			= trim($arrInvBrg["KODE_BARANG"]);
					$arrInvBrg["JNS_BARANG"]			= $arrInvBrg["JNS_BARANG"];
					$arrInvBrg["KODE_TRADER"]			= $KODETRADER;
					$arrInvBrg["KODE_SATUAN_TERKECIL"]	= $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
					
					$arrInvBrg["JML_SATUAN_TERKECIL"] 	= $arrInvBrg["JML_SATUAN_TERKECIL"]?$arrInvBrg["JML_SATUAN_TERKECIL"]:1;
					$exec = $this->db->insert('M_TRADER_BARANG', $arrInvBrg);
					$func->main->activity_log('TAMBAH DATA BARANG','KODE_BARANG='.trim($arrInvBrg["KODE_BARANG"]).', JNS_BARANG='.$arrInvBrg["JNS_BARANG"]);
					$ret = "MSG#OK# Penyimpanan Data Berhasil. Silahkan masukan lagi jika ingin menambahkan data barang lainnya.#";
				}
			}else{				
				$HIDE_KODE_BARANG = $this->input->post('HIDE_KODE_BARANG');
				$HIDE_JNS_BARANG  = $this->input->post('HIDE_JNS_BARANG');
				
				$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODETRADER."'
						AND KODE_BARANG = '".$HIDE_KODE_BARANG."' AND JNS_BARANG = '".$HIDE_JNS_BARANG."'";
				$rs = $this->db->query($SQL);
				if($rs->num_rows()>0){
					$DATABRG["KODE_HS"] = str_replace(".","",$arrInvBrg["KODE_HS"]);
					$DATABRG["URAIAN_BARANG"] = $arrInvBrg["URAIAN_BARANG"];
					$DATABRG["MERK"] = $arrInvBrg["MERK"];
					$DATABRG["TIPE"] = $arrInvBrg["TIPE"];
					$DATABRG["UKURAN"] = $arrInvBrg["UKURAN"];
					$DATABRG["SPFLAIN"] = $arrInvBrg["SPFLAIN"];
					
					$this->db->where(array('KODE_BARANG' => $HIDE_KODE_BARANG,'JNS_BARANG'=> $HIDE_JNS_BARANG, 'KODE_TRADER'=>$KODETRADER));
					$exec = $this->db->update('M_TRADER_BARANG', $DATABRG);	
					if($exec){
						$this->db->where(array('KODE_BARANG'=>$HIDE_KODE_BARANG,'JNS_BARANG'=>$HIDE_JNS_BARANG,'KODE_TRADER'=>$KODETRADER));	
						if($this->db->delete('M_TRADER_BARANG_GUDANG')){				   		
							$arrkeys = array_keys($arrdetil);
							$countdtl = count($arrdetil[$arrkeys[0]]);
							for($i=0;$i<$countdtl;$i++){
								for($j=0;$j<count($arrkeys);$j++){
									$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
								}
								$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '".trim($arrInvBrg["KODE_BARANG"])."' 
										AND JNS_BARANG = '".$arrInvBrg["JNS_BARANG"]."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
										AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' AND KODE_RAK = '".$DATADTL["KODE_RAK"]."'
										AND KODE_SUB_RAK = '".$DATADTL["KODE_SUB_RAK"]."' AND KODE_TRADER = '".$KODETRADER."'";
								$rs = $this->db->query($SQL);				
								if($rs->num_rows()==0){
									$DATAGUDANG["KODE_TRADER"] = $KODETRADER;
									$DATAGUDANG["KODE_BARANG"] = $HIDE_KODE_BARANG;
									$DATAGUDANG["JNS_BARANG"] = $HIDE_JNS_BARANG;
									$DATAGUDANG["KODE_GUDANG"] = $DATADTL["KODE_GUDANG"];
									$DATAGUDANG["KONDISI_BARANG"] = $DATADTL["KONDISI_BARANG"];
									$DATAGUDANG["KODE_RAK"] 		= $DATADTL["KODE_RAK"];
									$DATAGUDANG["KODE_SUB_RAK"] 	= $DATADTL["KODE_SUB_RAK"];
									$DATAGUDANG["JUMLAH"] = $DATADTL["JUMLAH_HIDE"]?$DATADTL["JUMLAH_HIDE"]:0;
									$DATAGUDANG["SATUAN"] = $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
									$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);	
								}
							}
						}	
						$func->main->activity_log('EDIT DATA BARANG','KODE_BARANG='.$HIDE_KODE_BARANG.', JNS_BARANG='.$HIDE_JNS_BARANG);
						$ret = "MSG#OK#Kode Barang dan Jenis Barang ini sudah ada mutasi.
							  <br><p style=\"margin-left:175px;\">Hanya Kode HS, Seri HS, Uraian, Merk, Tipe, Ukuran dan Spesifikasi Lain yang dapat berubah</p>.#".site_url()."/inventory/barang#";
					}										
				}else{
					$this->db->where(array('KODE_BARANG'=>$HIDE_KODE_BARANG,'JNS_BARANG'=>$HIDE_JNS_BARANG,'KODE_TRADER'=>$KODETRADER));	
					if($this->db->delete('M_TRADER_BARANG_GUDANG')){
						$arrkeys = array_keys($arrdetil);
						$countdtl = count($arrdetil[$arrkeys[0]]);
						for($i=0;$i<$countdtl;$i++){
							for($j=0;$j<count($arrkeys);$j++){
								$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
							}
							$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '".trim($arrInvBrg["KODE_BARANG"])."' 
									AND JNS_BARANG = '".$arrInvBrg["JNS_BARANG"]."' AND KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."'  
									AND KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' AND KODE_RAK = '".$DATADTL["KODE_RAK"]."'
									AND KODE_SUB_RAK = '".$DATADTL["KODE_SUB_RAK"]."' AND KODE_TRADER = '".$KODETRADER."'";
							$rs = $this->db->query($SQL);				
							if($rs->num_rows()==0){
								$DATAGUDANG["KODE_TRADER"] = $KODETRADER;
								$DATAGUDANG["KODE_BARANG"] = trim($arrInvBrg["KODE_BARANG"]);
								$DATAGUDANG["JNS_BARANG"] = $arrInvBrg["JNS_BARANG"];
								$DATAGUDANG["KODE_GUDANG"] = $DATADTL["KODE_GUDANG"];
								$DATAGUDANG["KONDISI_BARANG"] = $DATADTL["KONDISI_BARANG"];
								$DATAGUDANG["KODE_RAK"] 		= $DATADTL["KODE_RAK"];
								$DATAGUDANG["KODE_SUB_RAK"] 	= $DATADTL["KODE_SUB_RAK"];
								$DATAGUDANG["JUMLAH"] = $DATADTL["JUMLAH_HIDE"]?$DATADTL["JUMLAH_HIDE"]:0;
								$DATAGUDANG["SATUAN"] = $arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
								$this->db->insert('M_TRADER_BARANG_GUDANG', $DATAGUDANG);	
							}
						}
					}
					$arrInvBrg["KODE_HS"] = str_replace(".","",$arrInvBrg["KODE_HS"]);
					$arrInvBrg["KODE_BARANG"] = $arrInvBrg["KODE_BARANG"];
					$arrInvBrg["JNS_BARANG"] = $arrInvBrg["JNS_BARANG"];
					$arrInvBrg["KODE_SATUAN_TERKECIL"]=$arrInvBrg["KODE_SATUAN_TERKECIL"]?$arrInvBrg["KODE_SATUAN_TERKECIL"]:$arrInvBrg["KODE_SATUAN"];
					$arrInvBrg["JML_SATUAN_TERKECIL"]=$arrInvBrg["JML_SATUAN_TERKECIL"]?$arrInvBrg["JML_SATUAN_TERKECIL"]:1;
					$this->db->where(array('KODE_BARANG' => $HIDE_KODE_BARANG,'JNS_BARANG'=> $HIDE_JNS_BARANG, 'KODE_TRADER'=>$KODETRADER));
					$exec = $this->db->update('m_trader_barang', $arrInvBrg);	
					if($exec){
						$func->main->activity_log('EDIT DATA BARANG','KODE_BARANG='.$HIDE_KODE_BARANG.', JNS_BARANG='.$HIDE_JNS_BARANG);
						$ret = "MSG#OK#Perubahan Data Berhasil.#".site_url()."/inventory/barang#";
					}
				}
			}
		}elseif($action=="delete"){			
			$dataCheck = $this->input->post('tb_chkfBarang'.$tipe);
			foreach($dataCheck as $chkitem){
				$arrchk = explode("|", $chkitem);
				$find = array('^','|@|','~');
				$replacer = array('/','.',' ');
				$KODE_BRG = str_replace($find, $replacer, $arrchk[0]);
				$JENIS_BRG = $arrchk[1];
				$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER = '".$KODE_TRADER."'
						AND KODE_BARANG = '".$KODE_BRG."' AND JNS_BARANG = '".$JENIS_BRG."'";
				$rs = $this->db->query($SQL);
				if($rs->num_rows()==0){
					$this->db->where(array('KODE_BARANG'=>$KODE_BRG,'JNS_BARANG'=>$JENIS_BRG,'KODE_TRADER'=>$KODETRADER));	
					if($this->db->delete('M_TRADER_BARANG_GUDANG')){										
						$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_GUDANG WHERE KODE_TRADER='".$KODETRADER."'
								AND KODE_BARANG = '".$KODE_BRG."' AND JNS_BARANG = '".$JENIS_BRG."'";
						$rs = $this->db->query($SQL);
						if($rs->num_rows()==0){			
							$this->db->where(array('KODE_BARANG'=>$KODE_BRG,'JNS_BARANG'=>$JENIS_BRG,'KODE_TRADER'=>$KODETRADER));	
							$this->db->delete('M_TRADER_BARANG');	
						}
					}																
					$func->main->activity_log('DELETE DATA BARANG','KODE_BARANG='.$KODE_BRG.', JNS_BARANG='.$JENIS_BRG);
					$ret = "MSG#OK#Hapus data Barang Berhasil#".site_url()."/inventory/view_barang/ajax";
				}else{
					$ret = "MSG#ERR#Hapus Gagal. Data sudah terdapat mutasi#";	
				}	
			}		
		}
		echo $ret;
	}
	
	function stockopname($tipe=""){
		$func = &get_instance();
		$func->load->model("main","main", true);
		$this->load->library('newtable');	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$SQL = "SELECT ID,DATE_FORMAT(TANGGAL_STOCK, '%d %M %Y') AS 'TANGGAL STOCK OPNAME',
				COUNT(*) AS 'JUMLAH ITEM BARANG',TANGGAL_STOCK	
				FROM M_TRADER_STOCKOPNAME
				WHERE KODE_TRADER='".$KODE_TRADER."'";
		foreach($this->input->post('CARI') as $a=>$b){
			$CARI[$a] = $b;
		}	
		if($CARI["TGL_DOK1"]!=""&&$CARI["TGL_DOK2"]!=""){
			$SQL .= $func->main->cekWhere($SQL);
			$SQL .= "TANGGAL_STOCK BETWEEN '".$CARI["TGL_DOK1"]."' AND '".$CARI["TGL_DOK2"]."'";
		}
		$SQL .= " GROUP BY KODE_TRADER,TANGGAL_STOCK";
		
		if($this->newsession->userdata('KODE_ROLE')!='5'){#ROLE BUKAN BC
			$prosesnya = array( 'Tambah' => array('GET2', site_url()."/inventory/stockopname/save", '0','fa fa-plus'),							
								'Ubah' => array('EDITJS', site_url()."/inventory/stockopname/update", '1','fa fa-edit'),
								'Hapus' => array('DELETE', site_url().'/inventory/set_stockopname/delheader', 'inventory','fa fa-trash-o red'),
								'Cetak PDF' => array('GETNEW', site_url()."/inventory/cetak/stock_opname", '2','fa fa-print red'),
								'Cetak Excel' => array('GETNEW', site_url()."/inventory/cetak/stock_opname/excel", '1','fa fa-print green'));
		}elseif($this->newsession->userdata('KODE_ROLE')=='5'){#ROLE BC
			$prosesnya = array();
		}
		$title = "Data Stock Opname";
		$this->newtable->search(array(array('TANGGAL_STOCK', 'TANGGAL STOCK&nbsp;', 'tag-tanggal')));
		$this->newtable->show_search(false);
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
		$this->newtable->action(site_url()."/inventory/stockopname");
		$this->newtable->detail(site_url()."/inventory/popstockopname/load_barang/view");
		$this->newtable->detail_tipe("detil_priview_bottom");
		$this->newtable->hiddens(array("ID","TANGGAL_STOCK"));
		$this->newtable->keys(array("TANGGAL_STOCK"));
		$this->newtable->tipe_proses('button');
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("fstockopaname");
		$this->newtable->set_divid("divstockopaname");
		$this->newtable->rowcount(10);
		$this->newtable->clear(); 
		$this->newtable->menu($prosesnya);
		if(!($this->input->post("ajax")||$tipe=="ajax")){
			$tabel .= '<form name="tblCari" id="tblCari" method="post" action="inventory/stockopname" onsubmit="return frm_Cari(\'divstockopaname\',\'tblCari\')">		
						<table border="0" cellpadding="0" cellspacing="2" width="100%" style="margin-bottom:10px">';
			$tabel .= '	<tr>
							<td width="14%"><strong>Tanggal Stock Opname</strong></td>
							<td>:</td>
							<td>'.form_input('CARI[TGL_DOK1]','','id="TGL_DOK1" class="text date" onfocus="ShowDP(this.id)"').' s/d 
								'.form_input('CARI[TGL_DOK2]','','id="TGL_DOK2" class="text date" onfocus="ShowDP(this.id)"').'	</td>
						</tr>';
			$tabel .= '	<tr><td colspan="3">&nbsp;<input type="submit" style="display:none"></td></tr>';						
			$tabel .= '	<tr>
							<td colspan="3">';
			$tabel .= "     <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-primary\" id=\"ok_\" onclick=\"frm_Cari('divstockopaname','tblCari')\"><i class=\"icon-search\"></i>&nbsp;Search</a>&nbsp;";
			$tabel .= "		<a href=\"javascript:void(0);\" class=\"btn btn-sm btn-danger\" id=\"ok_\" onclick=\"cancel('tblCari')\"><span><i class=\"icon-remove\"></i>&nbsp;Clear</a>";
			$tabel .= '		</td>
						</tr>';							
			$tabel .= '	 </table>
						</form>';					
		}
		$tabel .= $this->newtable->generate($SQL); 
		$arrdata = array("title" => $title,
						 "tabel" => $tabel);
		if($this->input->post("ajax")||$tipe=="ajax") return $tabel;				 
		else return $arrdata;
	}
	
	function getstockopname($tipe="",$act="",$id=""){
		$func = get_instance();
		$func->load->model("main");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		$NIPER = $this->newsession->userdata("NIPER");
		$DATA = array();
		if($tipe=="header"){
			$ret  = array("act" => $act,"TANGGAL_STOCK" => $id,"DETIL"=>$this->brgstockopname($id),"judul"=>"Form Stock Opname");	
		}else{
			if($act=="update"){
				$ID = explode(",",$id);
				$ID = $ID[0];
				$SQL = "SELECT A.ID, A.KODE_BARANG, A.JNS_BARANG, A.KODE_GUDANG, A.TANGGAL_STOCK, A.JUMLAH, A.KETERANGAN,
						B.URAIAN_BARANG, B.KODE_SATUAN_TERKECIL KODE_SATUAN, f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS_BARANG',
						f_gudang(A.KODE_GUDANG,A.KODE_TRADER) 'GUDANG',
						 A.KONDISI_BARANG, A.KODE_GUDANG, f_satuan(B.KODE_SATUAN_TERKECIL) AS 'URAIAN_SATUAN', A.KODE_RAK, A.KODE_SUB_RAK  
						FROM M_TRADER_STOCKOPNAME A, M_TRADER_BARANG B
						WHERE A.KODE_TRADER=B.KODE_TRADER
						AND A.KODE_BARANG=B.KODE_BARANG AND A.JNS_BARANG=B.JNS_BARANG
						AND A.KODE_TRADER='".$KODE_TRADER."' AND A.ID='".$ID."'";
				$hasil = $func->main->get_result($SQL);
				if($hasil){
					foreach($SQL->result_array() as $row){
						$DATA = $row;
					}
				}			
				$SQL_GUDANG = "SELECT KODE_GUDANG, IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA') AS NAMA_GUDANG, KODE_RAK, f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER) AS NAMA_RAK,
							   KODE_SUB_RAK, f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER) AS NAMA_SUB_RAK
							   FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
							   AND KODE_BARANG = '".$DATA["KODE_BARANG"]."' AND JNS_BARANG = '".$DATA["JNS_BARANG"]."' 
							   AND KONDISI_BARANG = '".$DATA["KONDISI_BARANG"]."' AND KODE_RAK = '".$DATA["KODE_RAK"]."' AND KODE_SUB_RAK = '".$DATA["KODE_SUB_RAK"]."'
							   ORDER BY KODE_GUDANG DESC";
				#echo $SQL_GUDANG;die();
				$ret = array("act" => $act,"DATA" => $DATA, "judul" => "Form Detil Stok Opname",
							 "GUDANG"=>$func->main->get_combobox($SQL_GUDANG,"KODE_GUDANG","NAMA_GUDANG",TRUE),
							 "KODE_RAK"=>$func->main->get_combobox($SQL_GUDANG,"KODE_RAK","NAMA_RAK",TRUE),
							 "KODE_SUB_RAK"=>$func->main->get_combobox($SQL_GUDANG,"KODE_SUB_RAK","NAMA_SUB_RAK",TRUE),
							 "KONDISI"=>array("BAIK"=>"BAIK","RUSAK"=>"RUSAK"));	
			}else{
				$ret = array("act" => $act, "judul" => "Form Detil Stok Opname");
			}
		}
		return $ret ;		
	}
	
	function brgstockopname($id="",$act=""){			
		$func = &get_instance();
		$func->load->model("main","main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$this->load->library('newtable');	
		$SQL = "SELECT ID, KODE_BARANG 'KODE BARANG', f_barang(KODE_BARANG, JNS_BARANG,KODE_TRADER) 'URAIAN BARANG', 
				f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JENIS BARANG', 
				concat(KODE_GUDANG,' - ',IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA')) GUDANG, 
				KONDISI_BARANG AS KONDISI,TANGGAL_STOCK, JUMLAH, KETERANGAN
				FROM M_TRADER_STOCKOPNAME WHERE KODE_TRADER='".$KODE_TRADER."' 
				AND TANGGAL_STOCK='".$id."'";  
		if($act!="view"){					
			$prosesnya = array( 'Tambah'=>array('DIALOGPINDAH-550;510',site_url().'/inventory/popstockopname/barang/save', '0','fa fa-plus','brgstock'),									
						   		'Ubah'=>array('DIALOGPINDAH-550;510', site_url().'/inventory/popstockopname/barang/update', '1','fa fa-edit'),
						   		'Hapus'=>array('DELETE', site_url().'/inventory/set_stockopname/delete', 'brgstockopname','fa fa-trash-o red'));	
		}else{			
			$this->newtable->show_chk(false);
		}
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
		$this->newtable->action(site_url()."/inventory/popstockopname/load_barang/load/".$id);					
		$this->newtable->search(array(array('KODE_BARANG', 'KODE BARANG'), 
									  array('URAIAN_BARANG', 'URAIAN BARANG'), 
									  array('KODE_GUDANG', 'KODE GUDANG')
									  ));	
		$this->newtable->count_keys(array("ID"));
		$this->newtable->hiddens(array("ID","TANGGAL_STOCK"));
		$this->newtable->keys(array("ID","TANGGAL_STOCK"));
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->orderby("ID DESC, KODE_BARANG");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("fstockdetil");
		$this->newtable->set_divid("divfstockdetil");
		$this->newtable->rowcount(20);
		$this->newtable->tipe_proses('button');
		$this->newtable->count_keys(array("ID"));
		$this->newtable->header_bg("#3f51b5");
		$this->newtable->menu($prosesnya);			
		$this->newtable->clear(); 
		$generate = $this->newtable->generate($SQL);			
		$table = '<div class="header">
						<div class="widget-header widget-header-flat">
						  <h4 class="lighter"> <i class="icon-th" style="color:orange;"></i>&nbsp;Detil Barang</span></h4>
						</div>
				  </div>'.$generate.'</div>
				<div class="space-7"></div>';
		if($act=="view") return $table;
		else return $generate;
	}
	
	function set_stockopname($act=""){
		$func =&get_instance();
		$func->load->model("main", "main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		if($act==""){
			$act = $this->input->post('act');
		}
		$UPDATE_TANGGAL = $this->input->post('UPDATE_TANGGAL');				
		foreach($this->input->post('DATA') as $a => $b){
			$DATA[$a] = $b;
		}
		$ret = "MSG#ERR#Proses Data Gagal.#";
		if($UPDATE_TANGGAL){ 
			$this->db->where(array('KODE_TRADER'=>$KODE_TRADER,'TANGGAL_STOCK'=>$this->input->post('TANGGAL_HIDE')));
			$exec = $this->db->update('M_TRADER_STOCKOPNAME', array('TANGGAL_STOCK'=>$DATA["TANGGAL_STOCK"]));	
			$ret = "MSG#OK#Proses Update Data Berhasil";
		}
		elseif($act=="delheader"){	
			$dataCheck = $this->input->post('tb_chkfstockopaname');
			foreach($dataCheck as $chkitem){
				$this->db->where(array('TANGGAL_STOCK'=>$chkitem,'KODE_TRADER'=>$KODE_TRADER));
				$this->db->delete('M_TRADER_STOCKOPNAME');			
				$ret = "MSG#OK#Proses Data Berhasil#".site_url()."/inventory/stockopname/delheader/ajax";
			}		
		}
		else{
			if($act=="save"||$act=="update"){
				$SQL1= "SELECT * FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='".$DATA["KODE_BARANG"]."' 
						AND JNS_BARANG = '".$DATA["JNS_BARANG"]."' AND KODE_GUDANG = '".$DATA["KODE_GUDANG"]."' 
						AND KONDISI_BARANG = '".$DATA["KONDISI_BARANG"]."' 
						AND KODE_TRADER ='".$KODE_TRADER."' ";
				$rs = $this->db->query($SQL1);				
				if($rs->num_rows()==0){
					$ret =  "MSG#ERR#Kode Barang ".$DATA["KODE_BARANG"]." dengan Jenis Barang " .$DATA["JNS_BARANG"]." dan Gudang " .$DATA["KODE_GUDANG"]. " serta Kondisi Barang ".$DATA["KONDISI_BARANG"]." belum terdaftar di Inventori Data Barang";
				}else{
					if($act=="save"){
						$SQL = "SELECT ID FROM M_TRADER_STOCKOPNAME WHERE KODE_BARANG='".$DATA["KODE_BARANG"]."' 
								AND JNS_BARANG = '".$DATA["JNS_BARANG"]."' AND KODE_GUDANG = '".$DATA["KODE_GUDANG"]."' 
								AND KONDISI_BARANG = '".$DATA["KONDISI_BARANG"]."' 
								AND KODE_TRADER ='".$KODE_TRADER."' 
								AND TANGGAL_STOCK='".$DATA["TANGGAL_STOCK"]."'";
						$rs = $this->db->query($SQL);				
						if($rs->num_rows()>0){
							$ret =  "MSG#ERR#Kode Barang tersebut sudah ada";
						}else{
							$ID = (int)$func->main->get_uraian("SELECT MAX(ID) AS MAX FROM M_TRADER_STOCKOPNAME","MAX") + 1;						
							$DATA["ID"] = $ID;			
							$DATA["KODE_TRADER"] = $KODE_TRADER;				
							$exec = $this->db->insert('M_TRADER_STOCKOPNAME', $DATA);
							$ret = "MSG#OK#Proses Data Berhasil#".site_url()."/inventory/popstockopname/load_barang/".$act."/".$DATA["TANGGAL_STOCK"];
						}
					}elseif($act=="update"){
						$ID = $this->input->post('ID');
						$this->db->where(array('ID'=>$ID,'KODE_TRADER'=>$KODE_TRADER));
						$exec = $this->db->update('M_TRADER_STOCKOPNAME', $DATA);	
						$ret = "MSG#OK#Proses Data Berhasil#".site_url()."/inventory/popstockopname/load_barang/".$act."/".$DATA["TANGGAL_STOCK"];
					}
				}
			}elseif($act=="delete"){		
				$dataCheck = $this->input->post('tb_chkfstockdetil');
				foreach($dataCheck as $chkitem){
					$arrchk = explode(".", $chkitem);
					$ID = $arrchk[0];
					$TGL = $arrchk[1];
					$this->db->where(array('ID'=>$ID,'KODE_TRADER'=>$KODE_TRADER));
					$this->db->delete('M_TRADER_STOCKOPNAME');			
					$ret = "MSG#OK#Proses Data Berhasil#".site_url()."/inventory/popstockopname/load_barang/".$ID."/".$TGL;
				}		
			}
		}
		echo $ret;
	}

	function list_inoutbrg($tipe,$id){			
		$func = &get_instance();
		$func->load->model("main","main", true);
		$this->load->library('newtable');	
		$judul = "Pencatatan Keluar Masuk Barang";	
		$prosesnya = array('Cetak Excel' => array('DIALOG', site_url()."/inventory/popupcetak/barang/excel", '0','tbl_ok.png','400,350'));

					
		if(in_array($tipe,array('GATE-IN','GATE-OUT'))){				   
			$SQL = "SELECT TANGGAL, KODE_BARANG 'KODE BARANG', f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JENIS BARANG', 
					KODE_DOKUMEN 'DOKUMEN PABEAN', DATE_FORMAT(TANGGAL_DOKUMEN,'%d %M %Y') 'TANGGAL DOKUMEN', NOMOR_AJU 'NOMOR AJU', 
					FORMAT(JUMLAH,2) JUMLAH, DATE_FORMAT(TANGGAL,'%d %M %Y') 'TANGGAL REALISASI' 
					FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'
					AND TIPE='".$tipe."'";
			$this->newtable->search(array(array('KODE_BARANG', 'KODE BARANG'),
							  array('NOMOR_AJU', 'NOMOR AJU'),
							  array('TANGGAL', 'TANGGAL REALISASI', 'tag-tanggal'))); #echo $SQL;exit;
		}else{
			$SQL = "SELECT TANGGAL, KODE_BARANG 'KODE BARANG', f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JENIS BARANG', 
					FORMAT(JUMLAH,2) JUMLAH, DATE_FORMAT(TANGGAL,'%d %M %Y') 'TANGGAL REALISASI' 
					FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'
					AND TIPE='".$tipe."'";
			$this->newtable->search(array(array('KODE_BARANG', 'KODE BARANG'),
					          array('TANGGAL', 'TANGGAL REALISASI', 'tag-tanggal')));

		}
		$this->newtable->hiddens(array("TANGGAL"));					
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
		$this->newtable->action(site_url()."/inventory/inoutbrg/".$tipe);	
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->show_chk(false);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("finout".$tipe.$id);
		$this->newtable->set_divid("divinout".$tipe.$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->rowcount(25);
		$this->newtable->menu($prosesnya);	
		$this->newtable->show_menu(false);			
		$this->newtable->clear(); 		
		return $this->newtable->generate($SQL);	
	}
	
	function tab_inoutbrg(){
		$func = get_instance();
		$func->load->model("main");					
		$tab = '<div class="tabbable"><ul class="nav nav-tabs" id="myTab">';
		$no=1;
		$tipe=array( 'GATE-IN' => 'Realisasi Pemasukan (GATE IN)',
				 	 'GATE-OUT' => 'Realisasi Pengeluaran (GATE OUT)',
					 'PROCESS_IN' => 'Barang yang diproses (-)',
					 'PROCESS_OUT' => 'Hasil Pengerjaan (+)',
					 'SCRAP' => 'Sisa Produksi/Scrap (+)',
					 'MUSNAH' => 'Pemusnahan');
		foreach($tipe as $row=>$data){
			if($row=="GATE-IN"){
				$tab .= '<li class="active">';
			}else{
				$tab .= '<li>';
			}
			$tab .= '<a data-toggle="tab" href="#tab-'.$no.'">';
			$tab .= $data;
			$tab .= '</a></li>';
			$no++;
		}
		$tab .= '</ul>';
		$nos=1;
		$tab.= '<div class="tab-content">';
		foreach($tipe as $row=>$data){
			if($row=="GATE-IN"){
				$tab .= '<div id="tab-'.$nos.'" class="tab-pane active">';
			}else{
				$tab .= '<div id="tab-'.$nos.'" class="tab-pane">';
			}
			$tab .= $this->list_inoutbrg($row,$nos).'</div>';
			$nos++;
		}
		$tab .= "</div></div>";
		$tab .= '<script>$(function(){$("#tabs").tabs();})</script>';
		$arrdata = array("judul" => "Pencatatan Keluar Masuk Barang",
						 "content" => $tab);		 
		return $arrdata;				
	}
	
	function inout(){					
		$func = &get_instance();
		$func->load->model("main","main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$KODE_BARANG = $this->input->post('KODE_BARANG');
		$TANGGAL_AWAL = $this->input->post('TANGGAL_AWAL');
		$TANGGAL_AKHIR = $this->input->post('TANGGAL_AKHIR');
		$JENIS_BARANG = $this->input->post('JENIS_BARANG');
		$SQLS = "SELECT REPLACE(FORMAT(JUMLAH,2),',','') AS JUMLAH, DATE_FORMAT(MIN(TANGGAL_STOCK),'%d-%m-%Y') TANGGAL_STOCK 
				 FROM M_TRADER_STOCKOPNAME 
				 WHERE KODE_TRADER='".$KODE_TRADER."' AND KODE_BARANG='".$KODE_BARANG."' AND JNS_BARANG = '".$JENIS_BARANG."' LIMIT 1";
		#$RS = $this->db->query($SQLS);
		$SALDO_AWAL = 0;
		$TANGGAL_STOCK = 0;
		/*if($RS->num_rows()>0){
			$DT = $RS->row();
			$SALDO_AWAL = $DT->JUMLAH;
			$TANGGAL_STOCK = $DT->TANGGAL_STOCK;
		}*/	
		$tglAkhirInOut=date('Y-m-d',strtotime($TANGGAL_AWAL."-1 day"));		
		$sqlGetSaldoStock ="SELECT REPLACE(FORMAT(JUMLAH,2),',','') AS 'JUMLAH_STOCK', TANGGAL_STOCK
							FROM m_trader_stockopname
							WHERE KODE_TRADER ='".$KODE_TRADER."' 
							AND TANGGAL_STOCK <= '".$TANGGAL_AWAL."'
							AND KODE_BARANG ='".$KODE_BARANG."' AND JNS_BARANG = '".$JENIS_BARANG."'
						    ORDER BY TANGGAL_STOCK DESC LIMIT 1";
		
		$RSSTOCKOPNAME=$this->db->query($sqlGetSaldoStock)->row(); 
		$GETSALDOAWALSTOCK=$RSSTOCKOPNAME->JUMLAH_STOCK;
		
		$TGLSTOCK = "";
		if($RSSTOCKOPNAME->TANGGAL_STOCK!=""){
			$TGLSTOCK = " BETWEEN '".date('Y-m-d',strtotime($RSSTOCKOPNAME->TANGGAL_STOCK."+1 day"))."' AND '".$tglAkhirInOut."'";
		}else{
			$TGLSTOCK = " <= '".$tglAkhirInOut."'";
		}
		
		$sqlGetSaldoIn = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_IN', STR_TO_DATE(TANGGAL,'%Y-%m-%d') 'TGL_IN'
						  FROM m_trader_barang_inout
						  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
						  AND KODE_TRADER = '".$KODE_TRADER."'
						  AND KODE_BARANG ='".$KODE_BARANG."' AND JNS_BARANG = '".$JENIS_BARANG."'
						  AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')
						  GROUP BY KODE_BARANG, JNS_BARANG"; 
		
		$sqlGetSaldoOut ="SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_OUT', STR_TO_DATE(TANGGAL,'%Y-%m-%d') 'TGL_OUT'
						  FROM m_trader_barang_inout
						  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
						  AND KODE_TRADER = '".$KODE_TRADER."'
						  AND KODE_BARANG ='".$KODE_BARANG."' AND JNS_BARANG = '".$JENIS_BARANG."'
						  AND TIPE IN ('GATE-OUT','PROCESS_IN','MUSNAH','MOVE-OUT')
   					      GROUP BY KODE_BARANG, JNS_BARANG";
						  
		$RSGETSALDOAWALIN=$this->db->query($sqlGetSaldoIn)->row();
		$GETSALDOAWALIN=$RSGETSALDOAWALIN->AWAL_SALDO_IN;
		$RSGETSALDOAWALOUT=$this->db->query($sqlGetSaldoOut)->row(); 
		$GETSALDOAWALOUT=$RSGETSALDOAWALOUT->AWAL_SALDO_OUT;
		
		if($GETSALDOAWALSTOCK==""){
			$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT;
			//if($SALDOAWLGET<0) $SALDOAWLGET = "0";
		}else{
			if($RSSTOCKOPNAME->TANGGAL_STOCK==$tglAkhirInOut){
				$SALDOAWLGET = $GETSALDOAWALSTOCK;
			}else{
				if($RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALIN->TGL_IN||$RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALOUT->TGL_OUT){
					$SALDOAWLGET = $GETSALDOAWALSTOCK;
				}else{
					$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT;
					//if($SALDOAWLGET<0) $SALDOAWLGET = "0";
				}	
			}
		}	
		$SALDO_AWAL = $SALDOAWLGET;
		$TANGGAL_STOCK = $TANGGAL_AWAL;
		
		$SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI, KODE_DOKUMEN, 
				TANGGAL_DOKUMEN, NOMOR_AJU, TIPE, KODE_GUDANG, KONDISI_BARANG, KODE_RAK, KODE_SUB_RAK,
				CASE TIPE
				WHEN 'GATE-IN' THEN CONCAT('REALISASI PEMASUKAN (GATE-IN)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
				WHEN 'GATE-OUT' THEN CONCAT('REALISASI PENGELUARAN (GATE-OUT)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
				WHEN 'PROCESS_IN' THEN 'BARANG YANG DIPROSES (-)'
				WHEN 'PROCESS_OUT' THEN 'HASIL PENGERJAAN (+)'
				WHEN 'SCRAP' THEN 'SISA PRODUKSI/SCRAP (+)'
				WHEN 'MUSNAH' THEN 'PEMUSNAHAN'
				WHEN 'MOVE-IN' THEN CONCAT('PINDAH GUDANG',' ( ',NOMOR_PROSES,' )')
				WHEN 'MOVE-OUT' THEN CONCAT('PINDAH GUDANG',' ( ',NOMOR_PROSES,' )') END TIPE_URAIAN,
				REPLACE(FORMAT(JUMLAH,2),',','') AS JUMLAH, DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') TANGGAL, PROCESS_WITH, CREATED_TIME,
				JUMLAH AS JUMLAHNYA 
				FROM M_TRADER_BARANG_INOUT 
				WHERE KODE_BARANG='".$KODE_BARANG."' AND KODE_TRADER='".$KODE_TRADER."' AND JNS_BARANG = '".$JENIS_BARANG."'
				AND DATE_FORMAT(TANGGAL, '%Y-%m-%d') BETWEEN '".$TANGGAL_AWAL."' AND '".$TANGGAL_AKHIR."'
				ORDER BY DATE_FORMAT(DATE(TANGGAL), '%Y-%m-%d')";	
	 	$hasil = $func->main->get_result($SQL);	
		if($hasil){
			$html .= '<br><table width="100%"><tr><td><span style="color: #438EB9;font-weight: bold;font-size: 12px;"><a href="'.site_url().'/inventory/cetak_inout/'.$TANGGAL_AWAL.'/'.$TANGGAL_AKHIR.'/'.$KODE_BARANG.'/'.$JENIS_BARANG.'/pdf" target="blank_"><img src="'.base_url().'/img/tbl_pdf.png" width="16px" height="16px" title="Cetak Dokumen PDF" align="absmiddle" />&nbsp;Cetak Dokumen PDF</a>&nbsp;&nbsp;<a href="'.site_url().'/inventory/cetak_inout/'.$TANGGAL_AWAL.'/'.$TANGGAL_AKHIR.'/'.$KODE_BARANG.'/'.$JENIS_BARANG.'/excel" target="blank_"><img src="'.base_url().'/img/tbl_xls.png" width="16px" height="16px" title="Cetak Dokumen Excel" align="absmiddle" />&nbsp;Cetak Dokumen Excel</a></span></td>';			if(in_array($this->newsession->userdata('KODE_ROLE'),array("3","4","6","7"))){#ROLE ADMIN
				$html .= '<td align="right"><a class="btn btn-info" onclick="updateinout();" href="javascript:void(0);" style="font-size:12px;font-weight:bold"><i class="fa fa-exchange"></i> Update Stock Akhir</a></td></tr></table>';
			}
		}
		$html .= '<span class="buton"></span>';	
		$html .= '<table class="tabelajax">';
		$html .= '<th width="1px">No</th>';
		$html .= '<th>TANGGAL</th>';
		$html .= '<th>KETERANGAN</th>';
		$html .= '<th>PEMASUKAN</th>';
		$html .= '<th>PENGELUARAN</th>';
		$html .= '<th>SALDO</th>';
		$html .= '</tr>';		
		$html .= '<tr><td>1</td>';
		$html .= '<td>'.$TANGGAL_STOCK.'</td>';		
		$html .= '<td>SALDO AWAL</td>';			
		$html .= '<td>&nbsp;</td>';				
		$html .= '<td>&nbsp;</td>';			
		$html .= '<td align="right">'.number_format($SALDO_AWAL,2).'</td>';		
		$html .= '<td align="right" width="7%">&nbsp;</td>';					
		$html .= '</tr>';		
		
		if($hasil){
			$no=2;
			$SALDO = 0;
			$TOTAL_MASUK = 0;
			$TOTAL_KELUAR = 0;
			$TOTAL_SALDO = 0;
			foreach($SQL->result_array() as $row){	//echo $row['JUMLAHNYA'];
				$html .= '<tr>';
				$html .= '<td>'.$no.'</td>';
				$html .= '<td>'.$row['TANGGAL'].'</td>';
				$html .= '<td>'.$row['TIPE_URAIAN'].'</td>';
				if($row['TIPE']=="GATE-IN"||$row['TIPE']=="PROCESS_OUT"||$row['TIPE']=="SCRAP"||$row['TIPE']=="MOVE-IN"){
					$html .= '<td align="right">'.number_format($row['JUMLAH'],2).'</td>';
					$html .= '<td>&nbsp;</td>';
					if($no==2){
						$SALDO = (float)$SALDO_AWAL+(float)$row['JUMLAH'];
					}else{
						$SALDO = (float)$SALDO+(float)$row['JUMLAH'];	
					}
					$TOTAL_MASUK = (float)$TOTAL_MASUK+(float)$row['JUMLAH'];
				}else{
					$html .= '<td>&nbsp;</td>';
					$html .= '<td align="right">'.number_format($row['JUMLAH'],2).'</td>';
					if($no==2){
						$SALDO = (float)$SALDO_AWAL-(float)$row['JUMLAH'];
					}else{
						$SALDO = (float)$SALDO-(float)$row['JUMLAH'];	
					}
					$TOTAL_KELUAR = (float)$TOTAL_KELUAR+(float)$row['JUMLAH'];
				}
				$hastak = ".";
				$x = strpos($SALDO,$hastak);
				if($x !== false){
					$explode = explode(".",$SALDO);
					if(strlen($explode[1]) == 1){
						$SALDO = $SALDO."0";
					}else{
						$SALDO = $SALDO;
					}
				}else{
					$SALDO = $SALDO.".00";
				}
				$TOTAL_SALDO = (float)$TOTAL_SALDO+(float)$SALDO;
				$html .= '<td align="right">'.number_format($SALDO,2).'</td>';
				$html .= "<td align=\"center\"><a href=\"javascript:void(0);\" class=\"btn btn-danger btn-sm\" onclick=\"deltelusur('".$row['TIPE']."','".$row['KODE_BARANG']."','".$row['JNS_BARANG']."','".$row['SERI']."','".$row['KONDISI_BARANG']."','".$row['KODE_GUDANG']."','".$row['KODE_RAK']."','".$row['KODE_SUB_RAK']."','".$row['NOMOR_AJU']."','".$row['NOMOR_PRODUKSI']."','".$row['NOMOR_PPBKB']."','".$row['KODE_DOKUMEN']."')\"><i class=\"icon-trash\"></i>Hapus</a></td>";	
				$html .= '</tr>';	
				$no++;
			}					
			$html .= '<tr>';		
			$html .= '<td colspan="3" align="right"><strong>TOTAL :</strong></td>';		
			$html .= '<td align="right"><strong>'.number_format($TOTAL_MASUK,2).'</strong></td>';		
			$html .= '<td align="right"><strong>'.number_format($TOTAL_KELUAR,2).'</strong></td>';		
			$html .= '<td align="right"><strong>'.number_format($SALDO,2).'</strong></td>';	
			$html .= '<td>&nbsp;</td>';
			
			$html .= '<input type="hidden" readonly="readonly" id="KODEBARANG" name="KODEBARANG" value="'.$row['KODE_BARANG'].'">';
			$html .= '<input type="hidden" readonly="readonly" id="JNSBARANG" name="JNSBARANG" value="'.$row['JNS_BARANG'].'">';
			$html .= '<input type="hidden" readonly="readonly" id="JUMSALDO" name="JUMSALDO" value="'.$SALDO.'">';
				
			$html .= '<tr>';		
		}
		$html .= '<table>';
		/*if($this->newsession->userdata('KODE_ROLE')=="3"){#ROLE ADMIN		
			$html .= "<script>$('.buton').html('&nbsp;<a style=\"float:right;margin-bottom:5px\" href=\"javascript:void(0);\" class=\"btn btn-success btn-sm next\" onclick=\"updateinout()\"><i class=\"fa fa-arrow-right\"></i><span>&nbsp;Update Stock Akhir</span></a>')</script>";
		}*/
		echo $html;
	}
	
	function updatestock($kode="",$jns="",$awal="",$akhir=""){
		$KODE_TRADER =$this->newsession->userdata('KODE_TRADER');
		$this->load->model("main");
		$saldoawal = $this->main->get_uraian("SELECT STOCK_AKHIR FROM m_trader_barang WHERE KODE_TRADER = '".$KODE_TRADER."' 
											  AND KODE_BARANG = '".$kode."' AND JNS_BARANG = '".$jns."'","STOCK_AKHIR");
		$cek_stockopname =  $this->db->query("SELECT * FROM M_TRADER_STOCKOPNAME WHERE 
											  TANGGAL_STOCK=DATE_ADD('".$awal."',INTERVAL -1 DAY) AND KODE_TRADER='".$KODE_TRADER."' 
											  AND KODE_BARANG='".$kode."' AND JNS_BARANG='".$jns."'");
		if($cek_stockopname->num_rows()>0){
			$idx = 0;
			foreach($cek_stockopname->result_array() as $a => $b ){
				$stockopname[$a] = $b;
				$this->db->where(array(
										'KODE_TRADER'		=> $KODE_TRADER,
										'KODE_BARANG'		=> $stockopname[$idx]["KODE_BARANG"],
										'JNS_BARANG'		=> $stockopname[$idx]["JNS_BARANG"],
										'KODE_GUDANG'		=> $stockopname[$idx]["KODE_GUDANG"],
										'KODE_RAK'			=> $stockopname[$idx]["KODE_RAK"],
										'KODE_SUB_RAK'		=> $stockopname[$idx]["KODE_SUB_RAK"],
										'KONDISI_BARANG'	=> $stockopname[$idx]["KONDISI_BARANG"]
										)
									);
				$this->db->update('M_TRADER_BARANG_GUDANG',array("JUMLAH"=>$stockopname[$idx]["JUMLAH"])); 
				$idx++;
			}

		}else{
			$query_inout = $this->db->query("SELECT KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG,SUM(JUMLAH) AS SALDO 
											 FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' 
											 AND DATE_FORMAT(TANGGAL,'%Y-%m-%d')<'".$awal."' AND KODE_BARANG='".$kode."' 
											 AND JNS_BARANG='".$jns."' GROUP BY KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG");
			
			if($query_inout->num_rows()>0){
				$idx = 0;
				foreach($query_inout->result_array() as $a => $b ){
					$inout[$a] = $b; 
					$this->db->where(array(
											'KODE_TRADER'		=> $KODE_TRADER,
											'KODE_BARANG'		=> $kode,
											'JNS_BARANG'		=> $jns,
											'KODE_GUDANG'		=> $inout[$idx]["KODE_GUDANG"],
											'KODE_RAK'			=> $inout[$idx]["KODE_RAK"],
											'KODE_SUB_RAK'		=> $inout[$idx]["KODE_SUB_RAK"],
											'KONDISI_BARANG'	=> $inout[$idx]["KONDISI_BARANG"]
											)
										);
					$this->db->update('M_TRADER_BARANG_GUDANG',array("JUMLAH"=>$inout[$idx]["SALDO"]));
					$idx++;
				}

			}else{
				$query_inout = $this->db->query("SELECT KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG 
												 FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' 
												 AND KODE_BARANG='".$kode."' AND JNS_BARANG='".$jns."' 
												 GROUP BY KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG");
				$idx = 0;
				foreach($query_inout->result_array() as $a => $b ){
					$inout[$a] = $b; 
					$this->db->where(array(
											'KODE_TRADER'		=> $KODE_TRADER,
											'KODE_BARANG'		=> $kode,
											'JNS_BARANG'		=> $jns,
											'KODE_GUDANG'		=> $inout[$idx]["KODE_GUDANG"],
											'KODE_RAK'			=> $inout[$idx]["KODE_RAK"],
											'KODE_SUB_RAK'		=> $inout[$idx]["KODE_SUB_RAK"],
											'KONDISI_BARANG'	=> $inout[$idx]["KONDISI_BARANG"]
											)
										);
					$this->db->update('M_TRADER_BARANG_GUDANG',array("JUMLAH"=>'0'));
					$idx++;
				}
			}
		}
		$query = $this->db->query("SELECT * FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' 
								   AND DATE_FORMAT(TANGGAL,'%Y-%m-%d') BETWEEN '".$awal."' AND '".$akhir."' 
								   AND KODE_BARANG='".$kode."' AND JNS_BARANG='".$jns."'");
		$idx = 0;
		foreach($query->result_array() as $a => $b ){
			$data[$a] = $b;
			if(in_array($data[$idx]["TIPE"], array('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN'))){
				$this->db->where(array(
										'KODE_TRADER'		=> $KODE_TRADER,
										'KODE_BARANG'		=> $kode,
										'JNS_BARANG'		=> $jns,
										'KODE_GUDANG'		=> $data[$idx]["KODE_GUDANG"],
										'KODE_RAK'			=> $data[$idx]["KODE_RAK"],
										'KODE_SUB_RAK'		=> $data[$idx]["KODE_SUB_RAK"],
										'KONDISI_BARANG'	=> $data[$idx]["KONDISI_BARANG"]
										)
									);
				$this->db->set('JUMLAH', 'JUMLAH+'.(float)$data[$idx]["JUMLAH"],false);
				$exe = $this->db->update('M_TRADER_BARANG_GUDANG');
			}elseif(in_array($data[$idx]["TIPE"], array('GATE-OUT','PROCESS_IN','MUSNAH','MOVE-OUT'))){
				$this->db->where(array(
										'KODE_TRADER'		=> $KODE_TRADER,
										'KODE_BARANG'		=> $kode,
										'JNS_BARANG'		=> $jns,
										'KODE_GUDANG'		=> $data[$idx]["KODE_GUDANG"],
										'KODE_RAK'			=> $data[$idx]["KODE_RAK"],
										'KODE_SUB_RAK'		=> $data[$idx]["KODE_SUB_RAK"],
										'KONDISI_BARANG'	=> $data[$idx]["KONDISI_BARANG"]
										)
									);
				$this->db->set('JUMLAH', 'JUMLAH-'.(float)$data[$idx]["JUMLAH"],false);
				$exe = $this->db->update('M_TRADER_BARANG_GUDANG');
			}
			$idx++;
		}
		$exe = true;
		$saldoakhir = $this->main->get_uraian("SELECT STOCK_AKHIR FROM m_trader_barang WHERE KODE_TRADER = '".$KODE_TRADER."' 
											   AND KODE_BARANG = '".$kode."' AND JNS_BARANG = '".$jns."'","STOCK_AKHIR");
		$this->main->activity_log('UPDATE DATA STOCKOPNAME','SALDO AWAL = '.(float)$saldoawal.', SALDO SETELAH UPDATE = '.(float)$saldoakhir.', KODE BARANG =  '.$kode);
		if($exe){			
			$msg = "Proses Berhasil!";
		}else{
			$msg = "Proses Gagal!";	
		}
		return $msg;
	}
	function delinout(){
		$func = &get_instance();
		$func->load->model('main');	
		$KODE_BARANG = $this->input->post("KODE_BARANG");
		$JNS_BARANG = $this->input->post("JNS_BARANG");
		$KONDISI_BARANG = $this->input->post("KONDISI_BARANG");
		$KODE_GUDANG = $this->input->post("KODE_GUDANG");
		$KODE_RAK = $this->input->post("KODE_RAK");
		$KODE_SUB_RAK = $this->input->post("KODE_SUB_RAK");
		$TIPE = $this->input->post("TIPE");
		$AJU = $this->input->post("AJU");
		$NOPRODUK = $this->input->post("NOPRODUK");
		$NOPPBKB = $this->input->post("NOPPBKB");
		$KDDOK = $this->input->post("KDDOK");
		$SERI = $this->input->post("SERI");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		/*$this->db->where(array("KODE_BARANG"=>$KODE_BARANG,"JNS_BARANG"=>$JNS_BARANG,"SERI"=>$SERI,"KODE_TRADER"=>$KODE_TRADER));
		if($this->db->delete("M_TRADER_BARANG_INOUT")){
			$func->main->activity_log('HAPUS DATA PENELUSURAN','KODE_BARANG='.$KODE_BARANG.', JNS_BARANG='.$JNS_BARANG.', SERI='.$SERI);
			echo "MSG#OK#Proses berhasil!";		
		}else{
			echo "MSG#ERR#Proses gagal!";
		}*/
		$this->db->where(array("KODE_BARANG"=>$KODE_BARANG,"JNS_BARANG"=>$JNS_BARANG,"SERI"=>$SERI,"KODE_TRADER"=>$KODE_TRADER,"KONDISI_BARANG"=>$KONDISI_BARANG,"KODE_GUDANG"=>$KODE_GUDANG,"KODE_RAK"=>$KODE_RAK,"KODE_SUB_RAK"=>$KODE_SUB_RAK));
		if($this->db->delete("M_TRADER_BARANG_INOUT")){
			$EMPTY = FALSE;
			switch($TIPE){
				case "GATE-IN" : case "GATE-OUT":
					$SQL = "SELECT SERI FROM M_TRADER_BARANG_INOUT WHERE NOMOR_AJU='".$AJU."' 
							AND KODE_DOKUMEN='".$KDDOK."' AND KODE_TRADER='".$KODE_TRADER."'";
					$rs = $this->db->query($SQL);

					if($rs->num_rows()==0){
						if($KDDOK=="PPB-PLB"||$KDDOK=="PPK-PLB"){
							$DOK = explode("-", $KDDOK);
							$KDDOK = $DOK[0];
						}
						$this->db->where(array("NOMOR_AJU"=>$AJU,"KODE_TRADER"=>$KODE_TRADER));	
						$this->db->update("T_".$KDDOK."_HDR",array("TANGGAL_REALISASI"=>NULL,"STATUS"=>"00"));
						$EMPTY = TRUE;
					}
				break;
				case "PROCESS_IN": case "PROCESS_OUT": case "SCRAP":
					$SQL = "SELECT SERI FROM M_TRADER_BARANG_INOUT WHERE NOMOR_PROSES='".$NOPRODUK."' AND KODE_TRADER='".$KODE_TRADER."'";
					$rs = $this->db->query($SQL);
					if($rs->num_rows()==0){
						$this->db->where(array("NOMOR_PROSES"=>$NOPRODUK,"KODE_TRADER"=>$KODE_TRADER));	
						$this->db->update("M_TRADER_PROSES",array("STATUS"=>"0"));
						$EMPTY = TRUE;
					}
				break;
			}
			$func->main->activity_log('HAPUS DATA PENELUSURAN','NO.TRANSAKSI='.$AJU.$NOPRODUK.', KODE_BARANG='.$KODE_BARANG.', JNS_BARANG='.$JNS_BARANG.', SERI='.$SERI);
			if($EMPTY) echo "MSG#OK#[Proses berhasil] Data tersebut sudah habis data Realisasinya maka data dikembalikan ke Draft!";		
			else echo "MSG#OK#Proses berhasil!";		
		}else{
			echo "MSG#ERR#Proses gagal!";
		}
	}


	function barangKadaluarsa($kd_trader) {
        $sql = "SELECT LOGID, TGL_DOK FROM t_logbook_pemasukan WHERE SALDO > '0' AND KODE_TRADER = '" . $kd_trader . "'";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $now = date("Y-m-d");
            $jml = array();
            foreach ($res->result_array() as $row) {
                $tgl = $row['TGL_DOK'];
                $thn = substr($tgl, 0, 4) + 1;
                $bln = substr($tgl, 5, 2);
                $blnNow = substr($now, 5, 2) - 1;
                if (count($blnNow) <= 1)
                    $blnNow = "0" . $blnNow;
                if (($thn == date("Y")) && ($bln == $blnNow)) {
                    $jml[] = $row['LOGID'];
                }
            }
            $jml = count($jml);
            if ($jml > 0) {
                $rtn = "<p><b>Anda memiliki (" . $jml . ") dokumen pemasukan yang hampir 1 tahun tetapi saldo belum habis.";
                $rtn .= " Klik tombol dibawah ini untuk melihat lebih detail.</b></p>";
                $rtn .= '<center><a id="ok_" class="button search" onclick="showBarang()" href="javascript:void(0);">
                        <span><span class="icon"></span>Details</span></a></center>';
            } else {
                $rtn = "false";
            }
            return $rtn;
        }
    }

    function outOfDate($tipe = "") {
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $sqlBarang = "SELECT LOGID, TGL_DOK FROM t_logbook_pemasukan WHERE SALDO > '0' AND KODE_TRADER = '" . $KODE_TRADER . "'";
        $res = $this->db->query($sqlBarang);
        if ($res->num_rows() > 0) {
            $now = date("Y-m-d");
            foreach ($res->result_array() as $row) {
                $tgl = $row['TGL_DOK'];
                $thn = substr($tgl, 0, 4) + 1;
                if ($tipe == "hampir") {
                    $bln = substr($tgl, 5, 2);
                    $blnNow = substr($now, 5, 2) + 1;
                    $blnNow = "0" . $blnNow;
                    #echo $thn.",".date("Y").",".$bln.",".$blnNow;die();
                    if (($thn == date("Y")) && ($bln == $blnNow)) {
                        $logid = $logid . $row['LOGID'] . ",";
                    }
                } else {
                    $tgl_banding = substr_replace($tgl, $thn, 0, 4);

                    if ($tgl_banding <= $now) {
                        $logid = $logid . $row['LOGID'] . ",";
                    }
                }
            }
            $logid = rtrim($logid, ",");
        }
        if(empty($logid)){
            return "<center><b>Data tidak ditemukan</b></center>";
            die();
        }
        $SQL = "SELECT LOGID, JENIS_DOK 'Dokumen', NO_DOK 'Nomor Pendaftaran', DATE_FORMAT(TGL_DOK,'%d %b %Y') 'Tanggal Pendaftaran', 
				KODE_BARANG 'Kode Barang', 
                NAMA_BARANG 'Nama Barang', SATUAN 'Satuan', SALDO 'Saldo',
				CONCAT((CONCAT(TIMESTAMPDIFF(YEAR,TGL_DOK,NOW()), ' Tahun ')), (CONCAT(TIMESTAMPDIFF(MONTH, TGL_DOK, NOW())%12,' Bulan ')), 
				(CONCAT(FLOOR(TIMESTAMPDIFF(DAY,TGL_DOK,NOW()))%30,' Hari'))) 'UMUR BARANG'
                FROM t_logbook_pemasukan WHERE SALDO > '0' AND LOGID IN(" . $logid . ") AND KODE_TRADER = '" . $KODE_TRADER . "'";
                #echo $SQL;die();
        $this->newtable->search(array(array('NO_DOK', 'NOMOR PENDAFTARAN'), array('KODE_BARANG', 'KODE BARANG'),
            array('JENIS_DOK', 'DOKUMEN')));
        $this->newtable->action(site_url() . "/inventory/list_kadaluarsa/".$tipe);
        $this->newtable->hiddens(array('LOGID'));
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->set_formid("f".$tipe);
        $this->newtable->set_divid("div".$tipe);
        $this->newtable->orderby(4);
        $this->newtable->sortby("DESC");
        $this->newtable->rowcount(25);
        $this->newtable->show_chk(false);
        $this->newtable->clear();
        $tabel .= $this->newtable->generate($SQL);
        return $tabel;
    }

    function detil_tab() {
        $data = array('hampir' => $this->outOfDate("hampir"), 'kadaluarsa' => $this->outOfDate("kadaluarsa"));
        return $data;
    }
	
	function rinci(){
		$func =&get_instance();
		$func->load->model("main", "main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$tabel = "";
		if(!$this->input->post("ajax")){			
			$tabel .= "<form name=\"tblCari\" id=\"tblCari\" method=\"post\" action=\"inventory/rinci\" onsubmit=\"return frm_Cari('divrinci','tblCari')\">";		
			$tabel .= '	<table border="0" cellpadding="2" cellspacing="2" width="100%" style="margin-bottom:10px">';
			$tabel .= '	<tr>
							<td width="10%">Nomor Pendaftaran</td>
							<td width="1%">:</td>
							<td width="1%"><input type="text"  name="CARI[NO_DAFTAR]" id="NO_DAFTAR" class="text"></td>
							<td>&nbsp;</td>
							<td width="10%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td>&nbsp;</td>
							<td width="10%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
						</tr>';	
			$tabel .= '	<tr>
							<td width="10%">Tanggal Pendaftaran</td>
							<td width="1%">:</td>
							<td width="1%"><input type="text" name="CARI[TGL_DAFTAR]" id="TGL_DAFTAR" onFocus="ShowDP(\'TGL_DAFTAR\');" class="stext date"></td>
							<td>&nbsp;</td>
							<td width="10%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td>&nbsp;</td>
							<td width="10%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
						</tr>';	
			$tabel .= '	<tr>
							<td width="10%">Kode Barang</td>
							<td width="1%">:</td>
							<td width="1%"><input type="text"  name="CARI[KODE_BARANG]" id="KODE_BARANG" class="text"></td>
							<td>&nbsp;</td>
							<td width="10%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td>&nbsp;</td>
							<td width="10%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
							<td width="1%">&nbsp;</td>
						</tr>';	
			$tabel .= '	<tr><td colspan="11">&nbsp;<input type="submit" style="display:none"></td></tr>';						
			$tabel .= '	<tr>
							<td colspan="11">';
			$tabel .= "     <a href=\"javascript:void(0);\" class=\"btn btn-primary btn-sm\" id=\"ok_\" onclick=\"frm_Cari('divrinci','tblCari')\"><i class=\"icon-search\"></i>Search</a>&nbsp;";
			$tabel .= "		<a href=\"javascript:void(0);\" class=\"btn btn-danger btn-sm\" id=\"ok_\" onclick=\"cancel('tblCari')\"><i class=\"icon-remove\"></i>Clear</a>";
			$tabel .= '		</td>
						</tr>';							
			$tabel .= '	 </table></form>';					
		}
		
		$SQL = "SELECT A.LOGID LOGID_IN, A.JENIS_DOK JENIS_DOK_IN, A.NO_DOK NO_DOK_IN, A.TGL_DOK TGL_DOK_IN, 
				A.TGL_MASUK TGL_MASUK_IN, A.KODE_BARANG KODE_BARANG_IN, A.JNS_BARANG JNS_BARANG_IN, 
				A.SERI_BARANG SERI_BARANG_IN, A.NAMA_BARANG NAMA_BARANG_IN, A.SATUAN SATUAN_IN, A.JUMLAH JUMLAH_IN, 
				A.NILAI_PABEAN NILAI_PABEAN_IN, A.FLAG_TUTUP, A.SALDO SALDO_IN,
				f_getaju(A.JENIS_DOK,A.NO_DOK,A.TGL_DOK,A.KODE_TRADER) NOMOR_AJU_IN,
				f_getseri(A.JENIS_DOK,A.NO_DOK,A.TGL_DOK,A.KODE_TRADER,A.KODE_BARANG,A.JNS_BARANG) SERIS_IN,
				
				B.LOGID LOGID_OUT, B.JENIS_DOK JENIS_DOK_OUT, B.NO_DOK NO_DOK_OUT, B.TGL_DOK TGL_DOK_OUT, 
				B.TGL_MASUK TGL_MASUK_OUT, B.KODE_BARANG KODE_BARANG_OUT, B.JNS_BARANG JNS_BARANG_OUT, B.SERI_BARANG SERI_BARANG_OUT,
				B.NAMA_BARANG NAMA_BARANG_OUT, B.SATUAN SATUAN_OUT, B.JUMLAH JUMLAH_OUT, B.SERI_BARANG_MASUK, B.NILAI_PABEAN NILAI_PABEAN_OUT, 
				B.NO_DOK_MASUK NO_DOK_MASUK_OUT, B.TGL_DOK_MASUK TGL_DOK_MASUK_OUT, B.JENIS_DOK_MASUK JENIS_DOK_MASUK_OUT,
				f_getaju(B.JENIS_DOK,B.NO_DOK,B.TGL_DOK,B.KODE_TRADER) NOMOR_AJU_OUT,
				f_getseri(B.JENIS_DOK,B.NO_DOK,B.TGL_DOK,B.KODE_TRADER,B.KODE_BARANG,B.JNS_BARANG) SERIS_OUT
				
				FROM t_logbook_pemasukan A INNER JOIN t_logbook_pengeluaran B
				ON B.NO_DOK_MASUK = A.NO_DOK
				AND B.TGL_DOK_MASUK = A.TGL_DOK 
				AND B.LOGID_MASUK = A.LOGID
				AND B.KODE_TRADER = A.KODE_TRADER ";
								
		$SQL .= " WHERE A.KODE_TRADER = '".$KODE_TRADER."' ";
			
		foreach($this->input->post('CARI') as $a=>$b){
			$CARI[$a] = $b;
		}	
		if($CARI["KODE_BARANG"]!=""){
			$SQL .= " AND A.KODE_BARANG = '".$CARI["KODE_BARANG"]."'";
		}
		if($CARI["NO_DAFTAR"]!=""){
			$SQL .= " AND A.NO_DOK LIKE '%".$CARI["NO_DAFTAR"]."%'";
		}	
		if($CARI["TGL_DAFTAR"]!=""){
			$SQL .= " AND A.TGL_DOK LIKE '%".$CARI["TGL_DAFTAR"]."%'";
		}	
		
		/*if($KODE_TRADER=='EDIICITR0000'||$KODE_TRADER=='EDIKTTR00020'||$KODE_TRADER=='EDIIAkin0000'){
			$SQL.=" GROUP BY A.NO_DOK, A.JENIS_DOK, A.KODE_BARANG, A.JNS_BARANG, A.SERI_BARANG, ";
			$SQL.=" B.NO_DOK_MASUK, B.TGL_DOK_MASUK, B.JENIS_DOK_MASUK, B.KODE_BARANG, B.JNS_BARANG";
		}
		else{
			$SQL.=" GROUP BY B.LOGID, A.LOGID ";	
		}		*/
		$SQL.=" GROUP BY B.LOGID, A.LOGID ";	
		$SQL.=" ORDER BY A.TGL_DOK, A.NO_DOK,  A.SERI_BARANG,  A.TGL_MASUK, A.KODE_BARANG, B.TGL_MASUK";		
			
		#echo $SQL;die();	
			
		$baris = 20;		
		$table_count = $this->db->query("SELECT COUNT(*) AS JML FROM ($SQL) AS TBL");
		if($table_count){
			$table_count = $table_count->row();
			$total_record = $table_count = $table_count->JML;
		}else{
			$total_record = 0;
		}
		$table_count = ceil($table_count / $baris);
		$hal = $this->input->post('hal');
		if($hal < 1) $hal = 1;
		if($hal > $table_count) $hal = $table_count;
		if($hal <= 1){
			$dari = 0;
			$sampai = $baris;
		}else{
			$dari = ($hal - 1) * $baris;
			$sampai = $baris;
		}
		$SQL .= " LIMIT $dari, $sampai";
		
		$datast = ($hal - 1);
		if($datast<1) $datast = 1;
		else $datast = $datast * $baris + 1;
		$dataen = $datast + $baris - 1;
		if($total_record < $dataen) $dataen = $total_record;
		if($total_record==0) $datast = 0;
		
		if($hal<=1)	$no = 1;			
		else $no = ($hal - 1) * $baris + 1;
		
		$tabel .= '<span id="divrinci" class="divrinci"><table class="tabelPopUp" width="100%">';	
		
		//$tabel .= '<a href="'.site_url().'/inventory/cetak_rinci/rinci/excel"><img src="'.base_url().'/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;Cetak Excel</a>';
							
		$tabel .= '<tr><th colspan="9">DOKUMEN PEMASUKAN</td><th colspan="6">DOKUMEN PENGELUARAN</td></tr>
				  <tr>
				  	<th>NO</th><th>DOKUMEN</th><th>NOMOR AJU</th><th>NOMOR<br>PENDAFTARAN</th>	
				  	<th>TANGGAL<br>PENDAFTARAN</th><th>DETIL</th><th>KODE BARANG</th>	
				  	<th>JUMLAH ASAL</th><th>SALDO BARANG</th><th>NO</th><th>DOKUMEN</th>	
				  	<th>NOMOR AJU</th><th>DETIL</th><th>KODE BARANG</th><th>JUMLAH</th>		
				  </tr>	';	
		$LOGID_1 = array();
		$LOGID_2 = array();
	  	if($func->main->get_result($SQL)){
			$no_in = $no;
			foreach($SQL->result_array() as $row){
					$LOGID_2[] = $row["LOGID_IN"];
			}
			$d=array_count_values($LOGID_2); 
			foreach($SQL->result_array() as $row){
				if(!in_array($row["LOGID_IN"],$LOGID_1)){
					$LOGID_1[] = $row["LOGID_IN"];
					$style ="";
					if($d[$row["LOGID_IN"]]>1){
						$style = 'style="border-bottom:none"';
					}
					$tabel .= '<tr>';
					$tabel .= '<td '.$style.'>'.$no_in.'</td>';
					$tabel .= '<td '.$style.'>'.$row["JENIS_DOK_IN"].'</td>';
					$tabel .= '<td '.$style.'>'.$row["NOMOR_AJU_IN"].'</td>';
					$tabel .= '<td '.$style.'>'.$row["NO_DOK_IN"].'</td>';
					$tabel .= '<td '.$style.'>'.$row["TGL_DOK_IN"].'</td>';
					$tabel .= '<td '.$style.'>'.$row["SERI_BARANG_IN"].'</td>';
					$tabel .= '<td '.$style.'>'.$row["KODE_BARANG_IN"].'</td>';
					$tabel .= '<td align="right" '.$style.'><b>'.number_format($row["JUMLAH_IN"],2).'</b></td>';
					$tabel .= '<td align="right" '.$style.'><b>'.number_format($row["SALDO_IN"],2).'</b>';						
					$no_in++;
					$no_out = 1;
					$Total = 0;
				}else{
					$style2 ="";
					if($d[$row["LOGID_IN"]]!=$no_out) $style2 = 'style="border-bottom:none;"';
					$tabel .= '<tr>';
					$tabel .= '<td '.$style2.'>&nbsp;</td>';
					$tabel .= '<td '.$style2.'>&nbsp;</td>';	
					$tabel .= '<td '.$style2.'>&nbsp;</td>';	
					$tabel .= '<td '.$style2.'>&nbsp;</td>';	
					$tabel .= '<td '.$style2.'>&nbsp;</td>';	
					$tabel .= '<td '.$style2.'>&nbsp;</td>';	
					$tabel .= '<td '.$style2.'>&nbsp;</td>';	
					$tabel .= '<td '.$style2.'>&nbsp;</td>';	
					$tabel .= '<td '.$style2.'>&nbsp;</td>';		
				}
				$tabel .= '<td>'.$no_out.'</td>';
				$tabel .= '<td>'.$row["JENIS_DOK_OUT"].'</td>';
				$tabel .= '<td>'.$row["NOMOR_AJU_OUT"].'</td>';
				$tabel .= '<td>'.$row["SERI_BARANG_OUT"].'</td>';
				$tabel .= '<td>'.$row["KODE_BARANG_OUT"].'</td>';
				$tabel .= '<td align="right">'.number_format($row["JUMLAH_OUT"],2).'</td>';
				$tabel .= '</tr>';
				
				$Total = $Total+$row["JUMLAH_OUT"];	
				$SISA = (float)$row["JUMLAH_IN"]-$Total;			
				if($d[$row["LOGID_IN"]]==$no_out){ 
					$tabel .= '<tr>';
					$tabel .= '<th colspan="12" style="text-align:left">Sisa Saldo Barang Aktual : '.number_format($row["JUMLAH_IN"],2).' - '.number_format($Total,2).' = '.number_format(((float)$row["JUMLAH_IN"]-$Total),2);
					
					$tabel .= "<br><a href=\"javascript:void(0);\" class=\"btn btn-primary btn-sm\" onclick=\"updatesaldo('".$row['LOGID_IN']."','".$SISA."')\">&nbsp;Update Saldo&nbsp</span></a></th>";
					
					$tabel .= '<th colspan="2" valign="top">Total :</th>';
					$tabel .= '<th align="right" valign="top">'.number_format($Total,2).'</th>';			
					$tabel .= '</tr>';
				}
				
				$no_out++;
			}							  	
			$tabel .='<tr class="head">
						<th colspan="15">
						<input type="hidden" class="tb_text" id="tb_view" value="'.$this->baris.'" readonly/> 
						<span style="float:left">&nbsp;'.$this->baris.' Data Pemasukan Per Halaman. Menampilkan '.$datast.' - '.$dataen.' Dari '.number_format($total_record).' Data.</span>';
			
			if($total_record > $this->baris){ 
				$actions = site_url()."/inventory/rinci";
				$prev = $hal-1;
				$next = $hal+1;
				$firsExec = "lap_pagging('".$actions."', 'divrinci', '1', 'tblCari');";
				$prevExec = "lap_pagging('".$actions."', 'divrinci', '".$prev."', 'tblCari');";
				$nextExec = "lap_pagging('".$actions."', 'divrinci', '".$next."', 'tblCari');";
				$lastExec = "lap_pagging('".$actions."', 'divrinci', '".$total_record."', 'tblCari');";
				$forgo = "lap_pagging('".$actions."', 'divrinci', document.getElementById('tb_halfrmLaporan').value, 'tblCari');";
				$tabel .="<span>";
				if ($hal != "1"){
					$tabel .="<a href=\"javascript:void(0)\" onclick=\"".$firsExec."\" title=\"First\" class=\"paging\">&laquo;</a>&nbsp;";
					$tabel .="<a href=\"javascript:void(0)\" onclick=\"".$prevExec."\" title=\"Prev\" class=\"paging\">&lsaquo;&nbsp;</a>&nbsp;";
				}else{
					$tabel .="<font class=\"pdisabled\">&laquo;</font>&nbsp;";
					$tabel .="<font class=\"pdisabled\">&lsaquo;&nbsp;</font>&nbsp;";
				}
				
				$tabel .="Halaman <input type=\"text\" class=\"tb_text\" name=\"tb_halfrmLaporan\" id=\"tb_halfrmLaporan\" title=\"Masukkan nomor halaman yang diinginkan kemudian tekan Go\" value=\"".$hal."\" ".$disabled." style=\"width:30px;text-align:right;\"/>"; 
				
				$tabel .="&nbsp;<input type=\"button\" class=\"btn btn-primary btn-xs\" OnClick=\"".$forgo."\" value=\"&nbsp;Go&nbsp;\">";
				$tabel .=" Dari ".$table_count;
				
				if ($hal != ($table_count)){
					$tabel .="<a href=\"javascript:void(0)\" onclick=\"".$nextExec."\" title=\"Next\" class=\"paging\">&nbsp;&rsaquo;</a>&nbsp;";
					$tabel .="<a href=\"javascript:void(0)\" onclick=\"".$lastExec."\" title=\"Last\" class=\"paging\">&raquo;</a>&nbsp;";	
				}else{
					$tabel .="<font class=\"pdisabled\">&nbsp;&rsaquo;</font>&nbsp;";
					$tabel .="<font class=\"pdisabled\">&raquo;</font>&nbsp;";
				}
				$tabel .="</span>";
			}else{
				$tabel .="<input type=\"hidden\" class=\"tb_text\" id=\"tb_halfrmLaporan\" value=\"".$hal."\" ".$disabled."  ondblclick=\"".$nextExec."\" style=\"width:30px;text-align:right;\"/>"; 	
			}			
			$tabel .='</th></tr>';
			$tabel .= "</table></span>";
		}
		else{
			$tabel .= '<tr><td colspan="15" align="center">Data tidak ditemukan</td><tr>';
			$tabel .= "</table></span>";	
		}
				
		
		$arrdata = array("title" => "Perincian Penggunaan Bahan Baku <i>(*data mulai April 2015)</i>",
						 "tabel" => $tabel);
		if($this->input->post("ajax")) return $tabel;				 
		else return $arrdata;	
	}
	
	function pindah_gudang($kode_barang, $jns_barang){
		$func = &get_instance();
		$func->load->model("main");	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');	
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$LOOPS = $this->input->post("LOOPS");
			$GUDANG_ASAL = $this->input->post("GUDANG_ASAL");
			$GUDANG_TUJUAN = $this->input->post("GUDANG_TUJU");
			$JUMLAH_ASAL = $this->input->post("JUMLAH_ASAL");
			$JUMLAH_TUJUAN = $this->input->post("JUMLAH_TUJUAN");
			$KODE_BARANG = $this->input->post("KODE_BARANG");
			$JNS_BARANG = $this->input->post("JNS_BARANG");
			$NOMOR_PROSES = $this->input->post("NOMOR_PROSES");
			$TANGGAL_PROSES = $this->input->post("TANGGAL_PROSES");
			$WAKTU = $this->input->post("WAKTU");
			$KETERANGAN = $this->input->post("KETERANGAN");
			$KONDISI_ASAL = $this->input->post("KONDISI_ASAL");
			$KONDISI_TUJUAN = $this->input->post("KONDISI_TUJUAN");
			$RAK_ASAL = $this->input->post("RAK_ASAL");
			$RAK_TUJU = $this->input->post("RAK_TUJU");
			$SRAK_ASAL = $this->input->post("SRAK_ASAL");
			$SRAK_TUJU = $this->input->post("SRAK_TUJU");
			$BOL_GDG = FALSE;
			$EXIST = FALSE;
			$EXIST_1 = FALSE;
			$TOTAL = FALSE;
			$LOG = "KODE BARANG: ".$KODE_BARANG." JENIS BARANG: ".$JNS_BARANG."<br>";
			$TANGGAL = $TANGGAL_PROSES != "" ?  $TANGGAL_PROSES.' '.$WAKTU : date("Y-m-d H:i:s");
			foreach($LOOPS as $IDLOOPS){
				$GUDANG_PINDAH = $GUDANG_TUJUAN[$IDLOOPS];
				$KONDISI_PINDAH = $KONDISI_TUJUAN[$IDLOOPS];
				$RAK_PINDAH = $RAK_TUJU[$IDLOOPS];
				$SRAK_PINDAH = $SRAK_TUJU[$IDLOOPS];
				$JUMLAH_PINDAH = $JUMLAH_TUJUAN[$IDLOOPS];
				$JUM_PROSES_TOT = 0;
				for($a=0;$a<count($GUDANG_PINDAH);$a++){
					if(($GUDANG_PINDAH[$a] === $GUDANG_ASAL[$IDLOOPS][0]) && ($KONDISI_PINDAH[$a] === $KONDISI_ASAL[$IDLOOPS][0]) && ($RAK_PINDAH[$a] === $RAK_ASAL[$IDLOOPS][0]) && ($SRAK_PINDAH[$a] === $SRAK_ASAL[$IDLOOPS][0])){
						$BOL_GDG = TRUE;
						$MSG_GDG = $MSG_GDG.$GUDANG_PINDAH[$a]." dan Kondisi Tujuan ".$KONDISI_PINDAH[$a].", ";	
					}
					#CEK GUDANG TUJUAN
					$SQL = "SELECT * FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '".$kode_barang."' AND JNS_BARANG = '".$jns_barang."' 
							AND KODE_GUDANG = '".$GUDANG_PINDAH[$a]."' AND KONDISI_BARANG = '".$KONDISI_PINDAH[$a]."'";
					$RS = $this->db->query($SQL);
					if($RS->num_rows()==0){
						$EXIST = TRUE;
						$MSG_EXIST = $MSG_EXIST.$GUDANG_PINDAH[$a]." dan Kondisi Tujuan ".$KONDISI_PINDAH[$a].", ";
					}
					
					#CEK GUDANG ASAL
					$SQL_ASAL = "SELECT * FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '".$kode_barang."' AND JNS_BARANG = '".$jns_barang."' 
								 AND KODE_GUDANG = '".$GUDANG_ASAL[$IDLOOPS][0]."' AND KONDISI_BARANG = '".$KONDISI_ASAL[$IDLOOPS][0]."'";
					$RS_ASAL = $this->db->query($SQL_ASAL);
					if($RS_ASAL->num_rows()==0){
						$EXIST_1 = TRUE;
						$MSG_EXIST_1 = $MSG_EXIST1.$GUDANG_ASAL[$IDLOOPS][0]." dan Kondisi Asal ".$KONDISI_ASAL[$IDLOOPS][0].", ";
					}
					
					$JUM_PROSES_TOT = $JUM_PROSES_TOT + (float)$JUMLAH_PINDAH[$a];	
					if($JUM_PROSES_TOT > (float)$JUMLAH_ASAL[$IDLOOPS][0]){
						$TOTAL = TRUE;
						$MSG_TOTAL = $MSG_TOTAL.$GUDANG_ASAL[$IDLOOPS][0].", ";
					}
				}
			}	
			if($TOTAL){
				echo "MSG#ERR#Total Jumlah Tujuan lebih besar dari jumlah tersedia di Gudang ".substr($MSG_TOTAL,0,-2);
				die();
			}elseif($BOL_GDG){
				echo "MSG#ERR#Gudang Tujuan tidak boleh sama dengan Gudang Asalnya, yaitu : ".substr($MSG_GDG,0,-2);
				die();
			}elseif($EXIST){
				echo "MSG#ERR#Kode Gudang dan Kondisi Barang belum terdaftar di Inventory Data Barang yaitu : ".$MSG_EXIST;
				die();
			}elseif($EXIST_1){
				echo "MSG#ERR#Kode Gudang dan Kondisi Barang belum terdaftar di Inventory Data Barang yaitu : ".$MSG_EXIST_1;
				die();
			}else{
				foreach($LOOPS as $IDLOOPS){
					$GUDANG_PINDAH = $GUDANG_TUJUAN[$IDLOOPS];
					$KONDISI_PINDAH = $KONDISI_TUJUAN[$IDLOOPS];
					$JUMLAH_PINDAH = $JUMLAH_TUJUAN[$IDLOOPS];
					$RAK_PINDAH = $RAK_TUJU[$IDLOOPS];
					$SRAK_PINDAH = $SRAK_TUJU[$IDLOOPS];
					$JUM_PROSES_TOT = 0;
					$JUM_PINDAH_TOT = 0;
					
					$LOG = "GUDANG ASAL: ".$GUDANG_ASAL[$IDLOOPS][0].", KONDISI ASAL: ".$KONDISI_ASAL[$IDLOOPS][0].", RAK ASAL: ".$RAK_ASAL[$IDLOOPS][0].", SUBRAK ASAL: ".$SRAK_ASAL[$IDLOOPS][0].", JUMLAH ASAL: ".$JUMLAH_ASAL[$IDLOOPS][0]."<br>";
					
					#INSERT GUDANG ASAL				
					$IDHDR = (int)$func->main->get_uraian("SELECT MAX(IDHDR) IDHDR FROM M_TRADER_PINDAH_ASAL", "IDHDR") + 1; 
					$PHDR["IDHDR"] = $IDHDR;
					$PHDR["NOMOR_PROSES"] = $NOMOR_PROSES;
					$PHDR["KODE_TRADER"] = $KODE_TRADER;
					$PHDR["TANGGAL_PROSES"] = $TANGGAL;
					$PHDR["KODE_BARANG"] = $kode_barang;
					$PHDR["JNS_BARANG"] = $jns_barang;
					$PHDR["KONDISI_BARANG"] = $KONDISI_ASAL[$IDLOOPS][0];
					$PHDR["KODE_GUDANG_ASAL"] = $GUDANG_ASAL[$IDLOOPS][0];
					$PHDR["KODE_RAK_ASAL"] = $RAK_ASAL[$IDLOOPS][0];
					$PHDR["KODE_SUBRAK_ASAL"] = $SRAK_ASAL[$IDLOOPS][0];
					$PHDR["JUMLAH"] = (float)$JUMLAH_ASAL[$IDLOOPS][0];
					$PHDR["KETERANGAN"] = $KETERANGAN;					
					for($a=0;$a<count($GUDANG_PINDAH);$a++){
						$JUM_PROSES_TOT = $JUM_PROSES_TOT + (float)$JUMLAH_PINDAH[$a];
						$SQL = "UPDATE M_TRADER_BARANG_GUDANG SET JUMLAH = (JUMLAH + ".(float)$JUMLAH_PINDAH[$a].") 
								WHERE KODE_BARANG = '".$kode_barang."' AND JNS_BARANG = '".$jns_barang."' 
								AND KODE_GUDANG = '".$GUDANG_PINDAH[$a]."' 
								AND KODE_TRADER = '".$KODE_TRADER."' AND KONDISI_BARANG = '".$KONDISI_PINDAH[$a]."'";
						if($this->db->query($SQL)){
							$JUM_PINDAH_TOT = $JUM_PINDAH_TOT + (float)$JUMLAH_PINDAH[$a];	
							$LOGG = $LOGG." KE GUDANG: ".$GUDANG_PINDAH[$a]." dengan Kondisi Barang: ".$KONDISI_PINDAH[$a]." JUMLAH :".(float)$JUMLAH_PINDAH[$a]."<br>";							
							#INSERT INOUT
							$IN["KODE_TRADER"] = $KODE_TRADER;
							$IN["KODE_BARANG"] = $KODE_BARANG;
							$IN["JNS_BARANG"] = $JNS_BARANG;
							$IN["NOMOR_PROSES"] = $NOMOR_PROSES;	
							$IN["TIPE"] = "MOVE-IN";
							$IN["JUMLAH"] = (float)$JUMLAH_PINDAH[$a];
							$IN["KODE_GUDANG"] = $GUDANG_PINDAH[$a];
							$IN["KONDISI_BARANG"] = $KONDISI_PINDAH[$a];
							$IN["KODE_RAK"] = $RAK_PINDAH[$a];
							$IN["KODE_SUB_RAK"] = $SRAK_PINDAH[$a];
							$IN["TANGGAL"] = $TANGGAL;
							$IN["PROCESS_WITH"] = "FORM";
							$this->db->insert('M_TRADER_BARANG_INOUT', $IN);	
							
							#INSERT GUDANG TUJU		
							$PDTL["IDHDR"] = $IDHDR;
							$PDTL["NOMOR_PROSES"] = $NOMOR_PROSES;
							$PDTL["TANGGAL_PROSES"] = $TANGGAL;
							$PDTL["KODE_TRADER"] = $KODE_TRADER;
							$PDTL["KODE_GUDANG_TUJU"] = $GUDANG_PINDAH[$a];
							$PDTL["KONDISI_BARANG_TUJU"] = $KONDISI_PINDAH[$a];
							$PDTL["KODE_RAK_TUJU"] = $RAK_PINDAH[$a];
							$PDTL["KODE_SUBRAK_TUJU"] = $SRAK_PINDAH[$a];
							$PDTL["JUMLAH"] = (float)$JUMLAH_PINDAH[$a];
							$this->db->insert('M_TRADER_PINDAH_TUJU', $PDTL);		
						}					
					}
					$PHDR["JUMLAH_SISA"] = (float)$JUMLAH_ASAL[$IDLOOPS][0] - $JUM_PROSES_TOT;
					$this->db->insert('M_TRADER_PINDAH_ASAL', $PHDR);		
						
					$SQL = "UPDATE M_TRADER_BARANG_GUDANG SET JUMLAH = (JUMLAH - ".(float)$JUM_PINDAH_TOT.")  
							WHERE KODE_BARANG = '".$kode_barang."' AND JNS_BARANG = '".$jns_barang."' 
							AND KODE_GUDANG = '".$GUDANG_ASAL[$IDLOOPS][0]."' AND KONDISI_BARANG = '".$KONDISI_ASAL[$IDLOOPS][0]."'
							AND KODE_TRADER = '".$KODE_TRADER."'";
					if($this->db->query($SQL)){
						$SQL = "SELECT SUM(JUMLAH) AS JUMLAH FROM M_TRADER_BARANG_GUDANG
								WHERE KODE_BARANG = '".$kode_barang."' AND JNS_BARANG = '".$jns_barang."'
								AND KODE_TRADER = '".$KODE_TRADER."'";
						$rs = $this->db->query($SQL);	
						if($rs->num_rows()>0){
							$DATA = $rs->row();
							$JUMLAH_BARANG["STOCK_AKHIR"] = (float)$DATA->JUMLAH;
							$DATA = array("KODE_BARANG"=>$KODE_BARANG,
										  "JNS_BARANG"=>$JNS_BARANG,
										  "KODE_TRADER"=>$KODE_TRADER);
							$this->db->where($DATA);			  
							$exec = $this->db->update("M_TRADER_BARANG",$JUMLAH_BARANG);
						}												
						#INSERT INOUT
						$OUT["KODE_TRADER"] = $KODE_TRADER;
						$OUT["KODE_BARANG"] = $kode_barang;
						$OUT["JNS_BARANG"] = $jns_barang;
						$OUT["NOMOR_PROSES"] = $NOMOR_PROSES;	
						$OUT["TIPE"] = "MOVE-OUT";
						$OUT["JUMLAH"] = (float)$JUM_PINDAH_TOT;
						$OUT["TANGGAL"] = $TANGGAL;
						$OUT["PROCESS_WITH"] = "FORM";
						$OUT["KODE_GUDANG"] = $GUDANG_ASAL[$IDLOOPS][0];
						$OUT["KONDISI_BARANG"] = $KONDISI_ASAL[$IDLOOPS][0];
						$OUT["KODE_RAK"] = $RAK_ASAL[$IDLOOPS][0];
						$OUT["KODE_SUB_RAK"] = $SRAK_ASAL[$IDLOOPS][0];
						$this->db->insert('M_TRADER_BARANG_INOUT', $OUT);		
					}
				}
				$exec = true;
			}
			if($exec){
				$LOG .= $LOGG;
				$func->main->activity_log('PINDAH GUDANG BARANG',$LOG);
				echo "MSG#OK#Proses Berhasil#".site_url()."/inventory/barang#edit#";
			}else{
				echo "MSG#ERR#Proses Gagal";	
			}
		}
		else{
			$ids = explode(",",$id);
			$finder = array('|@|','^','~');
			$replacer = array('.','/',' ');
			$KODE_BARANG = str_replace($finder,$replacer,$kode_barang);
			$JNS_BARANG = $jns_barang;
			$SQL = "SELECT IFNULL(FORMAT(STOCK_AKHIR,2),0)STOCK_AKHIR, KODE_SATUAN_TERKECIL,
					f_ref('ASAL_JENIS_BARANG', JNS_BARANG) AS JENIS_BARANG, KODE_BARANG FROM M_TRADER_BARANG 
					WHERE KODE_BARANG='".$KODE_BARANG."' AND JNS_BARANG='".$JNS_BARANG."' 
					AND KODE_TRADER='".$KODE_TRADER."'";
			$STOCK_AKHIR = 0;		
			$RS = $this->db->query($SQL);
			if($RS->num_rows()>0){
				$data = $RS->row();
				$STOCK_AKHIR = $data->STOCK_AKHIR;	
				$KODE_SATUAN = $data->KODE_SATUAN_TERKECIL;	
				$UR_JENIS_BARANG = $data->JENIS_BARANG;		
				$KODE_BARANG = $data->KODE_BARANG;	
			}
			$SQG = "SELECT A.KODE_GUDANG, A.KODE_GUDANG NAMA_GUDANG
					FROM M_TRADER_GUDANG A, M_TRADER_BARANG_GUDANG B 
					WHERE B.KODE_TRADER='".$KODE_TRADER."'
					AND A.KODE_TRADER = B.KODE_TRADER AND A.KODE_GUDANG = B.KODE_GUDANG
					AND B.KODE_BARANG='".$KODE_BARANG."' AND B.JNS_BARANG='".$JNS_BARANG."'
					ORDER BY A.KODE_GUDANG";
			$KODE_GUDANG = $func->main->get_combobox($SQG,"KODE_GUDANG", "NAMA_GUDANG", false);
			
			$DATAARR['STOCK_AKHIR'] = $STOCK_AKHIR;
			$DATAARR['KODE_SATUAN'] = $KODE_SATUAN;
			$DATAARR['KODE_GUDANG'] = $KODE_GUDANG;
			$DATAARR['KODE_BARANG'] = $KODE_BARANG;
			$DATAARR['JNS_BARANG'] = $JNS_BARANG;
			$DATAARR['UR_JENIS_BARANG'] = $UR_JENIS_BARANG;
			return $DATAARR;
		}
	}
	
	function get_jumlah(){
		$SQL = "SELECT IFNULL(SUM(JUMLAH),'0') AS JUMLAH, FORMAT(IFNULL(SUM(JUMLAH),'0'),2) AS JUM FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' 
				AND KODE_BARANG='".$this->input->post("kdbrg")."' 
				AND JNS_BARANG='".$this->input->post("jnsbrg")."'";

		if($this->input->post("kdgdng")!=""&&$this->input->post("kdgdng")!="0"&&$this->input->post("kdgdng")!="undefined"){
			$SQL .=	"AND KODE_GUDANG='".$this->input->post("kdgdng")."'";
		}
		if($this->input->post("kondisi")!=""&&$this->input->post("kondisi")!="0"&&$this->input->post("kondisi")!="undefined"){
			$SQL .=	"AND KONDISI_BARANG = '".$this->input->post("kondisi")."'";
		}
		if($this->input->post("rak")!=""&&$this->input->post("rak")!="0"&&$this->input->post("rak")!="undefined"){
			$SQL .=	"AND KODE_RAK = '".$this->input->post("rak")."'";
		}
		if($this->input->post("srak")!=""&&$this->input->post("srak")!="0"&&$this->input->post("srak")!="undefined"){
			$SQL .=	"AND KODE_SUB_RAK = '".$this->input->post("srak")."'";
		}
		#echo $SQL;die();
		$JUMLAH = 0;$JUM = 0;		
		$RS = $this->db->query($SQL);
		if($RS->num_rows()>0){
			$data = $RS->row();
			$JUMLAH = $data->JUMLAH;
			$JUM = $data->JUM;	
		}	
		$DATA =  array("JUMLAH"=>$JUMLAH,"JUM"=>$JUM);	
		echo json_encode($DATA);
	}
	
	function getGudang(){
		$SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_INOUT
				WHERE KODE_TRADER = '".$this->newsession->userdata('KODE_TRADER')."' 
				AND KODE_BARANG='".$this->input->post("kode_barang")."' 
				AND JNS_BARANG='".$this->input->post("jns_barang")."' 
				AND KODE_GUDANG='".$this->input->post("kode_gudang")."'
				AND KONDISI_BARANG = '".$this->input->post("kondisi_barang")."'";
		$RS = $this->db->query($SQL);
		if($RS->num_rows()>0){
			return "ok";
		}else{
			return "err";
		}
	}

	function getGudangBarang(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		
		$SQL = "SELECT KODE_GUDANG, KONDISI_BARANG, IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA') AS NAMA_GUDANG 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' ORDER BY KODE_GUDANG DESC";
		$GUDANG = array_merge(array(''=>"--Pilih--"),$func->main->get_combobox($SQL,"KODE_GUDANG","NAMA_GUDANG",FALSE));
		$KONDISI = $func->main->get_combobox($SQL,"KONDISI_BARANG","KONDISI_BARANG",FALSE);
		if($this->input->post('formid')=='fstock-barang'){
			return form_dropdown('DATA[KODE_GUDANG]', $GUDANG, $DATA['KODE_GUDANG'], 'id="KODE_GUDANG" class="mtext" onChange="getRak(\'fstock-barang\',\'1\')" wajib="yes" ')."#".form_dropdown('DATA[KONDISI_BARANG]', $KONDISI, $DATA['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="mtext" wajib="yes" ');
		}else{
			return form_dropdown('DATA[KODE_GUDANG]', $GUDANG, $DATA['KODE_GUDANG'], 'id="KODE_GUDANG" class="mtext" onChange="getRak()" wajib="yes" ')."#".form_dropdown('DATA[KONDISI_BARANG]', $KONDISI, $DATA['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="mtext" wajib="yes" ');
		}
	}
	
	function getRak($kode,$id="",$tipe="",$target="",$kdbarang="",$jnsbarang=""){
		$func = get_instance();
		$func->load->model("main");
		$wajib = "";
		$formid = $this->input->post('formId');
		if($tipe=="pindah_gudang"){
			$name = "RAK_".strtoupper($target)."[1][]";
			$class = "sstext";
			$comboid = "RAK_".strtoupper($target).$id;
			$tgt = ",'".$target."'";
			if($target="asal"){
				$getjml= ";getjumlah('1')";
			}
		}else{
			$name = "DATADTL[KODE_RAK][]";
			$comboid = "KODE_RAK";
			if($formid=="fstock-barang"){
				$class = "mtext";
			}elseif($formid=="finventory"){
				$class = "text date ac_input";
			}else{
				$class = "text";
			}
		}
		$html = "";
		if($tipe=="pindah_gudang"){
			$RAK = $func->main->get_combobox("SELECT KODE_RAK, f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER) AS NAMA_RAK FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."' AND KODE_GUDANG='".$kode."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."' AND KONDISI_BARANG = '".$this->input->post('kondisi_barang')."' GROUP BY KODE_GUDANG,KODE_RAK,KODE_SUB_RAK", "KODE_RAK", "NAMA_RAK", FALSE);
			$onChange = 'onchange="getSubrakPindah('.$id.$tgt.',this.value)'.$getjml.'" ';
		}else{
			$RAK = $func->main->get_combobox("SELECT KODE_RAK,NAMA_RAK FROM M_TRADER_RAK WHERE KODE_GUDANG='".$kode."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."'", "KODE_RAK", "NAMA_RAK", FALSE);
			$VAL = $func->main->get_uraian("SELECT KODE_RAK FROM M_TRADER_RAK WHERE KODE_GUDANG='".$kode."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."'","KODE_RAK"); 
			if($VAL!=""){
				$wajib = 'wajib="yes"';
			}
			$onChange = 'onchange="getSubrak(\''.$formid.'\','.$id.$tgt.')"';
		}
		$html .= "<combo>";
		$html .= form_dropdown($name,array_merge(array("" => '-- Pilih --'),$RAK), $DATA['KODE_RAK'], 'id="'.$comboid.'" class="'.$class.'" '.$wajib.' '.$disabled.' '.$onChange);
		$html .= "</combo>";
		return $html;
	}
	
	function getSubrak($kdRak,$kdGudang,$id="",$tipe="",$target="",$kdbarang="",$jnsbarang="",$kondisi=""){
		$func = get_instance();
		$func->load->model("main");
		$formid = $this->input->post('formId');
		if($tipe=="pindah_gudang"){
			$name = "SRAK_".strtoupper($target)."[1][]";
			$class = "sstext";
			$comboid = "SRAK_".strtoupper($target).$id;
			$wajib = "no";
			if($target="asal"){
				$getjml= "onchange=\"getjumlah('1')\"";
			}
		}else{
			$name = "DATADTL[KODE_SUB_RAK][]";
			$comboid = "KODE_SUB_RAK";
			if($formid=="fstock-barang"){
				$class = "mtext";
			}elseif($formid=="finventory"){
				$class = "text date ac_input";
			}else{
				$class = "text";
			}
		}
		$html = "";
		if($tipe=="pindah_gudang"){
			$SUBRAK = $func->main->get_combobox("SELECT KODE_SUB_RAK, f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER) AS NAMA_SUB_RAK FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."' AND KODE_GUDANG='".$kdGudang."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."' AND KODE_RAK='".$kdRak."' AND KONDISI_BARANG = '".$kondisi."' GROUP BY KODE_GUDANG,KODE_RAK,KODE_SUB_RAK", "KODE_SUB_RAK", "NAMA_SUB_RAK", FALSE);
		}else{
			$SUBRAK = $func->main->get_combobox("SELECT KODE_SUB_RAK,NAMA_SUB_RAK FROM M_TRADER_SUB_RAK WHERE KODE_GUDANG='".$kdGudang."' AND KODE_RAK='".$kdRak."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."'", "KODE_SUB_RAK", "NAMA_SUB_RAK", FALSE);
			if(count($SUBRAK)>0){
				$wajib = "yes";
			}else{
				$wajib = "no";
			}
		}
		$html .= "<combo>";
		$html .= form_dropdown($name,array_merge(array("" => '-- Pilih --'),$SUBRAK), $DATA['KODE_SUB_RAK'], 'id="'.$comboid.'" class="'.$class.'" wajib="'.$wajib.'" '.$getjml.' '.$disabled);
		$html .= "</combo>";
		return $html;
	}

	function getKondisi($kode,$id="",$tipe="",$target="",$kdbarang="",$jnsbarang=""){
		$func = get_instance();
		$func->load->model("main");
		$wajib = "";
		$formid = $this->input->post('formId');
		if($tipe=="pindah_gudang"){
			$name = "KONDISI_".strtoupper($target)."[1][]";
			$class = "sstext";
			$comboid = "KONDISI_".strtoupper($target).$id;
			$tgt = ",'".$target."'";
			$wajib = 'wajib="yes"';
			if($target="asal"){
				$getjml= ";getjumlah('1')";
			}
		}else{
			$name = "DATADTL[KONDISI_BARANG][]";
			$comboid = "KONDISI_BARANG";
			if($formid=="fstock-barang"){
				$class = "mtext";
			}elseif($formid=="finventory"){
				$class = "text date ac_input";
			}else{
				$class = "text";
			}
		}
		$html = "";
		if($tipe=="pindah_gudang"){
			$SQL = "SELECT KONDISI_BARANG FROM M_TRADER_BARANG_GUDANG 
					WHERE KODE_BARANG='".$kdbarang."' AND JNS_BARANG='".$jnsbarang."' AND KODE_GUDANG='".$kode."' 
					AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."' GROUP BY KODE_GUDANG";
			$KONDISI = $func->main->get_combobox($SQL, "KONDISI_BARANG", "KONDISI_BARANG", FALSE);
		}else{
			$SQL = "SELECT KONDISI_BARANG FROM M_TRADER_BARANG_GUDANG 
					WHERE KODE_GUDANG='".$kode."' AND KODE_TRADER='".$this->newsession->userdata("KODE_TRADER")."'";
			$KONDISI = $func->main->get_combobox($SQL, "KONDISI_BARANG", "KONDISI_BARANG", FALSE);
			$VAL = $func->main->get_uraian($SQL,"KONDISI_BARANG"); 
			if($VAL!=""){
				$wajib = 'wajib="yes"';
			}
		}
		$html .= "<combo>";
		$html .= form_dropdown($name,array_merge(array("" => '-- Pilih --'),$KONDISI), $DATA['KODE_RAK'], 'id="'.$comboid.'" class="'.$class.'" '.$wajib.' onchange="getRak('.$id.$tgt.',this.value)'.$getjml.'" '.$disabled);
		$html .= "</combo>";
		return $html;
	}
	
	function status(){					
		$func = &get_instance();
		$func->load->model("main","main", true);
		$status = $this->input->post("status");
		if($status=="active"){
			$active = "1";
		}else{
			$active = "0";
		}
		$dataCheck = $this->input->post('tb_chkfBarang');
		foreach($dataCheck as $chkitem){
			$kode = explode('|',$chkitem);
			$kd_barang = $kode[0];
			$jns_barang = $kode[1];
			$this->db->where(array('KODE_TRADER'=>$this->newsession->userdata("KODE_TRADER"),'KODE_BARANG'=>$kd_barang,'JNS_BARANG'=>$jns_barang));
			$exec = $this->db->update('m_trader_barang',array('STATUS'=>$active));
		}
		if($exec){
			$ret = "MSG#OK#Hapus data Barang Berhasil#".site_url()."/inventory/view_barang/ajax";
		}else{
			$ret = "MSG#ERR#Proses gagal#";
		}
		return $ret;
		
	}
}
?>