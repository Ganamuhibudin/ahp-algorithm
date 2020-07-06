<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengrusakan_act extends CI_Model
{
	function set_pengrusakan($action="", $tipe=""){
		$func = get_instance();
		$func->load->model("main","main", true);
		if($action=="delete"){ 
			$ret = "MSG#Hapus data Gagal";
			if($tipe=="draftPengrusakan"){
				$dataCheck = $this->input->post('tb_chkfdraftPengrusakan');
				foreach($dataCheck as $chkitem){
					$arrchk = explode(".", $chkitem);
					$id = strtolower($arrchk[0]);				
					$this->db->where(array('ID' => $id));
					$this->db->delete('t_pengrusakan_brg'); 	
					$func->main->activity_log('DELETE DATA PENGRUSAKAN','ID='.$id);			  
				}
				$ret = "MSG#OK#Hapus data Berhasil#".site_url()."/pengeluaran/pengrusakan_dok/draftPengrusakan#";
			    echo $ret;
				
			}elseif($tipe=="draftPemusnahan"){	
				$dataCheck = $this->input->post('tb_chkfdraftPemusnahan');
				foreach($dataCheck as $chkitem){
					$arrchk = explode(".", $chkitem);
					$id = strtolower($arrchk[0]);				
					$this->db->where(array('ID' => $id));
					$this->db->delete('t_pemusnahan_brg'); 	
					$func->main->activity_log('DELETE DATA PEMUSNAHAN','ID='.$id);			  
				}
				$ret = "MSG#OK#Hapus data Berhasil#".site_url()."/pengeluaran/pengrusakan_dok/draftPemusnahan#";
			    echo $ret;
			}			
		}
	}
	
	function daftar($tipe="",$id="",$isajax=""){
		$this->load->library('newtable');
		if($tipe=="draftPemusnahan"){
			$judul = "Data Pemusnahan";	
			$WHERE = " WHERE A.KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'";
			if($this->newsession->userdata('KODE_ROLE')!='5'){#ROLE BUKAN BC
				$prosesnya = array(	'Tambah' => array('GET', site_url()."/pengeluaran/add/pemusnahan", '0','icon-plus'),
									'Ubah' => array('EDITJS', site_url()."/pengeluaran/editPengrusakan/pemusnahan", '1','icon-edit'));
									//'Hapus' => array('DELETE', site_url().'/pengeluaran/set_pengrusakan/'.$tipe, 'pemusnahan'));
			}elseif($this->newsession->userdata('KODE_ROLE')=='5'){#ROLE BC
				$prosesnya="";
			}
				
			$SQL = "SELECT ID AS KODE_ID, DATE_FORMAT(A.TANGGAL_PEMUSNAHAN, '%d %M %Y') AS 'TANGGAL PEMUSNAHAN', 
					A.KODE_BARANG AS 'KODE BARANG', B.URAIAN_BARANG AS 'URAIAN BARANG',
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'URAIAN JENIS', A.JUMLAH, f_satuan(A.KODE_SATUAN) AS 'URAIAN SATUAN',
					A.KETERANGAN FROM T_PEMUSNAHAN_BRG A
					LEFT JOIN M_TRADER_BARANG B ON B.KODE_BARANG=A.KODE_BARANG AND B.KODE_TRADER=A.KODE_TRADER ";	
					$SQL .=	$WHERE;	
					
		}elseif($tipe=="draftPengrusakan"){	
			$judul = "Data Pengrusakan";
			$WHERE = " WHERE A.KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."'";		
			if($this->newsession->userdata('KODE_ROLE')!='5'){#ROLE BUKAN BC
				$prosesnya = array(	'Tambah' => array('GET', site_url()."/pengeluaran/add/pengrusakan", '0'),
									'Ubah' => array('GET', site_url()."/pengeluaran/editPengrusakan/pengrusakan", '1'));
									//'Hapus' => array('DELETE', site_url().'/pengeluaran/set_pengrusakan/'.$tipe, 'pengrusakan'));
			}elseif($this->newsession->userdata('KODE_ROLE')=='5'){#ROLE BC
				$prosesnya="";
			}		
			$SQL = "SELECT ID AS KODE_ID, DATE_FORMAT(A.TANGGAL_PENGRUSAKAN, '%d %M %Y') AS 'TANGGAL PENGRUSAKAN', 
					A.KODE_BARANG AS 'KODE BARANG', B.URAIAN_BARANG AS 'URAIAN BARANG',	
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'URAIAN JENIS', A.JUMLAH, f_satuan(A.KODE_SATUAN) AS 'URAIAN SATUAN',
					A.KETERANGAN FROM T_PENGRUSAKAN_BRG A
					LEFT JOIN M_TRADER_BARANG B ON B.KODE_BARANG=A.KODE_BARANG AND B.KODE_TRADER=A.KODE_TRADER ";	
					$SQL .=	$WHERE;	
					
		}elseif($tipe=="surat"){	
			$pjang = ($id==9)?"Pemusnahan":"Pengrusakan";
			$judul = "Data Surat Permohonan ".$pjang;	
			$prosesnya = array(	'Tambah' => array('GET2', site_url()."/pengeluaran/surat/".$id."", '0','icon-plus'),
								'Ubah' => array('GET2', site_url()."/pengeluaran/surat", '1','icon-edit'),
								'Hapus' => array('DELETE', site_url().'/pengeluaran/set_surat', 'pengrusakan','red icon-remove'),
								'Cetak Dokumen' => array('GETNEW', site_url()."/pengeluaran/print_surat", '1','icon-print'));	
				
			$SQL = "SELECT NO_PERMOHONAN 'NO SURAT', DATE_FORMAT(TGL_PERMOHONAN,'%d %M %Y') 'TANGGAL', 
					CONCAT(KANTOR_TUJUAN,' - ',f_kpbc(KANTOR_TUJUAN)) 'KANTOR TUJUAN', PERIHAL, 
					NAMA_PEMOHON 'NAMA PEMOHON', NOID_PEMOHON 'NO. IDENTITAS', NO_SRT_TUGAS 'NO. SURAT', 
					TUJUAN_PERMOHONAN,NOMOR_AJU FROM m_trader_permohonan ";
			$SQL .=	"WHERE KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."' AND TUJUAN_PERMOHONAN='".$id."'";
		}		
		if($tipe=="surat"){	
			$this->newtable->search(array(array('NO_PERMOHONAN', 'NO SURAT&nbsp;&nbsp;')));	
			$this->newtable->keys(array("TUJUAN_PERMOHONAN","NOMOR_AJU"));
			$this->newtable->hiddens(array("TUJUAN_PERMOHONAN","NOMOR_AJU"));			
		}else{
			$this->newtable->search(array(array('A.KODE_BARANG', 'Kode Barang&nbsp;')));		
			$this->newtable->keys("KODE_ID");
			$this->newtable->hiddens('KODE_ID');	
		}
		$ciuri = (!$this->input->post("ajax") || $isajax=="ajax")?$this->uri->segment_array():$this->input->post("uri");		
		//$this->newtable->action(site_url()."/pemasukan/daftar/".$tipe."/".$dokumen."");
		if($this->newsession->userdata('KODE_ROLE')=='5')$this->newtable->show_chk(FALSE);
		$this->newtable->cidb($this->db);
		$this->newtable->tipe_proses('button');
		$this->newtable->ciuri($ciuri);
		$this->newtable->orderby(2);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("f".$tipe);
		$this->newtable->set_divid("div".$tipe);
		$this->newtable->rowcount(10);
		$this->newtable->clear();  
		$this->newtable->menu($prosesnya);
		
		if(!$this->input->post("ajax") || $isajax=="ajax"){
			if($this->newsession->userdata('KODE_ROLE')!='5'){
				if($tipe!="surat"){
				$tp = trim(strtolower(str_replace('Data','',$judul)));
				$tj = ($tp=="pengrusakan")?"10":"9";				
				$tabel .= "<a href=\"javascript:void(0)\" onclick=\"window.location.href='".site_url()."/pengeluaran/laporan/".$tp."'\" style=\"margin-bottom:5px\" class=\"btn btn-primary btn-sm next\" id=\"ok_\"><span><i class=\"fa fa-arrow-circle-right\"></i>&nbsp;Laporan ".$tp."</span></a>&nbsp;";
				$tabel .= "<a href=\"javascript:void(0)\" onclick=\"window.location.href='".site_url()."/pengeluaran/surat/".$tj."'\" style=\"margin-bottom:5px\" class=\"btn btn-primary btn-sm add\" id=\"ok_\"><span><i class=\"fa fa-plus-circle\"></i>&nbsp;Buat Surat Permohonan</span></a>&nbsp;";
				$tabel .= "<a href=\"javascript:void(0)\" onclick=\"window.location.href='".site_url()."/pengeluaran/".$tp."/surat/".$tj."'\" style=\"margin-bottom:5px\" class=\"btn btn-primary btn-sm next\" id=\"ok_\"><span><i class=\"fa fa-arrow-circle-right\"></i>&nbsp;Daftar Surat Permohonan</span></a>";
				}
			}
		}
		
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $title,
						 "judul" => $judul,
						 "tabel" => $tabel,
						 "jenis" => $jenis,
						 "tipe" => $tipe,
						 "isajax" => $isajax);
		if($this->input->post("ajax") || $isajax=="ajax") return $tabel;				 
		else return $arrdata;	
					
	}
	
	function proses_form($tipe, $id){
		$func =&get_instance();
		$func->load->model("main", "main", true);
		$kodeTrader = $this->newsession->userdata('KODE_TRADER');		
		$seriInOut = (int)$func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM m_trader_barang_inout", "MAXSERI") + 1;		
		if($tipe=="pengrusakan"){
			$act=$this->input->post('act');
			foreach($this->input->post('RUSAK') as $a => $b){
				$arrInvBrg[$a] = $b;
			}
			$SQL1="SELECT STOCK_AKHIR FROM M_TRADER_BARANG WHERE KODE_TRADER='".$kodeTrader."' 
					  AND KODE_BARANG='".$arrInvBrg['KODE_BARANG']."'";
			$result=$this->db->query($SQL1)->row(); 
			$stok = $result->STOCK_AKHIR;
			$kodeBarang = $arrInvBrg['KODE_BARANG'];
			if($act=="save"){
					$jumlanNew = $arrInvBrg['JUMLAH'];												
					$arrInvBrg["KODE_TRADER"]= $kodeTrader;
					$exec = $this->db->insert('t_pengrusakan_brg', $arrInvBrg);					
					$arrBrgInout["KODE_TRADER"]= $kodeTrader;
					$arrBrgInout["SERI"]= $seriInOut;
					$arrBrgInout["KODE_BARANG"]= $arrInvBrg['KODE_BARANG'];
					$arrBrgInout["JNS_BARANG"]= $arrInvBrg['JNS_BARANG'];
					$arrBrgInout["TANGGAL"]= $arrInvBrg['TANGGAL_PENGRUSAKAN'];
					$arrBrgInout["TIPE"]= "RUSAK";
					$arrBrgInout["JUMLAH"]= $arrInvBrg['JUMLAH'];					
					$exec = $this->db->insert('m_trader_barang_inout', $arrBrgInout);					
					$arrUpdateBrg = array("STOCK_AKHIR"=>$stok-$jumlanNew);
					$this->db->where(array('KODE_BARANG' => $kodeBarang, 'KODE_TRADER' => $kodeTrader));
					$exec = $this->db->update('m_trader_barang', $arrUpdateBrg);					
					if($exec){
						$func->main->activity_log('ADD PENGERUSAKAN','KODE_BARANG='.$arrInvBrg['KODE_BARANG'].', JNS_BARANG='.$arrInvBrg['JNS_BARANG'].', JUMLAH MASUK='.$jumlanNew.', JUMLAH SEBELUM='.$stok.', STOCK AKHIR='.$stok-$jumlanNew);
						echo "MSG#OK#Simpan data Barang Berhasil#stop#";
					}else{					
						echo "MSG#ERR#Simpan data Barang Gagal#";
					}
			}else{
				$jumlah = $this->input->post('jumlah');
				$jumlanNew = $arrInvBrg['JUMLAH'];
				if ($jumlah > $jumlanNew){
					$selisih = $jumlah-$jumlanNew;
					$newStok = $stok+$selisih;
					$arrBrgInout["JUMLAH"]= "-".$selisih;
				}elseif($jumlah < $jumlanNew){
					$selisih = $jumlanNew-$jumlah;
					$newStok = $stok-$selisih;
					$arrBrgInout["JUMLAH"]= $selisih;
				}else{
					$newStok = $stok;
				}
				$this->db->where(array('ID' => $id));
				$exec = $this->db->update('t_pengrusakan_brg', $arrInvBrg);				
				if($newStok != $stok){
					$arrBrgInout["KODE_TRADER"]= $kodeTrader;
					$arrBrgInout["SERI"]= $seriInOut;
					$arrBrgInout["KODE_BARANG"]= $arrInvBrg['KODE_BARANG'];
					$arrBrgInout["JNS_BARANG"]= $arrInvBrg['JNS_BARANG'];
					$arrBrgInout["TANGGAL"]= $arrInvBrg['TANGGAL_PENGRUSAKAN'];
					$arrBrgInout["TIPE"]= "RUSAK";
					$exec = $this->db->insert('m_trader_barang_inout', $arrBrgInout);
				}
				$arrUpdateBrg = array("STOCK_AKHIR"=>$newStok);
				$this->db->where(array('KODE_BARANG' => $kodeBarang, 'KODE_TRADER' => $kodeTrader));
				$exec = $this->db->update('m_trader_barang', $arrUpdateBrg);								
				if($exec){
					echo "MSG#OK#Ubah data Barang Berhasil#".site_url()."/pengeluaran/pengrusakan/draftPengrusakan#";
				}else{					
					echo "MSG#ERR#Ubah data Barang Gagal#";
				}
			}
			
		}
		elseif($tipe=="pemusnahan"){
			$act=$this->input->post('act');
			foreach($this->input->post('RUSAK') as $a => $b){
				$arrInvBrg[$a] = $b;
			}
			$SQL1="SELECT STOCK_AKHIR FROM M_TRADER_BARANG WHERE KODE_TRADER='".$kodeTrader."' 
				   AND KODE_BARANG='".$arrInvBrg['KODE_BARANG']."'";
				
			$result  = $this->db->query($SQL1)->row(); 
			$stok = $result->STOCK_AKHIR;
			if($arrInvBrg["JUMLAH"] > $stok){
				echo "MSG#ERR#Stock Tidak Mencukupi";die();
			}
			$kodeBarang = $arrInvBrg['KODE_BARANG'];			
			if($act=="save"){
					$jumlanNew = $arrInvBrg['JUMLAH'];
					/* INSERT K T_PEMUSNAHAN_BRG */
					$arrBrgPms["KODE_TRADER"]= $kodeTrader;
					$arrBrgPms["KODE_BARANG"]= $arrInvBrg['KODE_BARANG'];
					$arrBrgPms["JNS_BARANG"]= $arrInvBrg['JNS_BARANG'];
					$arrBrgPms["TANGGAL_PEMUSNAHAN"] = $arrInvBrg['TANGGAL_PEMUSNAHAN'];
					$arrBrgPms["JUMLAH"]= $arrInvBrg['JUMLAH'];
					$arrBrgPms["KODE_SATUAN"]= $arrInvBrg['KODE_SATUAN'];
					$arrBrgPms["KODE_GUDANG"]= $arrInvBrg['KODE_GUDANG'];	
					$arrBrgPms["KODE_RAK"]= $arrInvBrg['KODE_RAK'];	
					$arrBrgPms["KODE_SUB_RAK"]= $arrInvBrg['KODE_SUB_RAK'];
					$arrBrgPms["KONDISI_BARANG"]= $arrInvBrg['KONDISI_BARANG'];
					$arrBrgPms["KETERANGAN"]= $arrInvBrg['KETERANGAN'];
					$exec = $this->db->insert('t_pemusnahan_brg', $arrBrgPms);
					/* INSERT KE M_TRADER_BARANG_INOUT */					
					$arrBrgInout["KODE_TRADER"]= $kodeTrader;
					$arrBrgInout["SERI"]= $seriInOut;
					$arrBrgInout["KODE_BARANG"]= $arrInvBrg['KODE_BARANG'];
					$arrBrgInout["JNS_BARANG"]= $arrInvBrg['JNS_BARANG'];
					$arrBrgInout["TANGGAL"] = $arrInvBrg['TANGGAL_PEMUSNAHAN'];
					$arrBrgInout["TIPE"]= "MUSNAH";
					$arrBrgInout["JUMLAH"]= $arrInvBrg['JUMLAH'];
					$arrBrgInout["KODE_GUDANG"]= $arrInvBrg['KODE_GUDANG'];	
					$arrBrgInout["KODE_RAK"]= $arrInvBrg['KODE_RAK'];	
					$arrBrgInout["KODE_SUB_RAK"]= $arrInvBrg['KODE_SUB_RAK'];
					$arrBrgInout["KONDISI_BARANG"]= $arrInvBrg['KONDISI_BARANG'];			
					$exec = $this->db->insert('m_trader_barang_inout', $arrBrgInout);					
					/* update barang yang ada di gudang */					
					if($exec){
						$this->db->set("JUMLAH","JUMLAH - ".$jumlanNew,FALSE);
						$this->db->where(array(
												'KODE_BARANG' 		=> $kodeBarang,
												'JNS_BARANG' 		=> $arrInvBrg['JNS_BARANG'],
												'KODE_GUDANG' 		=> $arrInvBrg['KODE_GUDANG'],
												'KODE_RAK'	 		=> $arrInvBrg['KODE_RAK'],
												'KODE_SUB_RAK' 		=> $arrInvBrg['KODE_SUB_RAK'],
												'KONDISI_BARANG' 	=> $arrInvBrg['KONDISI_BARANG'],
												'KODE_TRADER' 		=> $kodeTrader
												)
										);
						$this->db->update('m_trader_barang_gudang');					
						$func->main->activity_log('ADD PEMUSNAHAN','KODE_BARANG='.$arrInvBrg['KODE_BARANG'].', JNS_BARANG='.$arrInvBrg['JNS_BARANG'].', JUMLAH MASUK='.$jumlanNew.', JUMLAH SEBELUM='.$stok.', STOCK AKHIR='.$stok-$jumlanNew);
						echo "MSG#OK#Proses data Berhasil#stop#";
					}else{					
						echo "MSG#ERR#Proses data Gagal#";
					}
			}else{
				$jumlah = $this->input->post('jumlah');
				$jumlanNew = $arrInvBrg['JUMLAH'];
				if ($jumlah > $jumlanNew){
					$selisih = $jumlah-$jumlanNew;
					$newStok = $stok+$selisih;
					$newStok_gudang = $stok_gudang+$selisih;
					$arrBrgInout["JUMLAH"]= "-".$selisih;
				}elseif($jumlah < $jumlanNew){
					$selisih = $jumlanNew-$jumlah;
					$newStok = $stok-$selisih;
					$newStok_gudang = $stok_gudang-$selisih;
					$arrBrgInout["JUMLAH"]= $selisih;
				}else{
					$newStok = $stok;
					$newStok_gudang = $stok_gudang;
				}				
				$this->db->where(array('ID' => $id));
				$exec = $this->db->update('t_pemusnahan_brg', $arrInvBrg);				
				if($newStok != $stok){
					$arrBrgInout["KODE_TRADER"]= $kodeTrader;
					$arrBrgInout["SERI"]= $seriInOut;
					$arrBrgInout["KODE_BARANG"]= $arrInvBrg['KODE_BARANG'];
					$arrBrgInout["JNS_BARANG"]= $arrInvBrg['JNS_BARANG'];
					$arrBrgInout["TANGGAL"]= $arrInvBrg['TANGGAL_PEMUSNAHAN'];
					$arrBrgInout["TIPE"]= "MUSNAH";
					$arrBrgInout["KODE_GUDANG"]= $arrInvBrg['KODE_GUDANG'];	
					$arrBrgInout["KODE_RAK"]= $arrInvBrg['KODE_RAK'];	
					$arrBrgInout["KODE_SUB_RAK"]= $arrInvBrg['KODE_SUB_RAK'];
					$arrBrgInout["KONDISI_BARANG"]= $arrInvBrg['KONDISI_BARANG'];
					$exec = $this->db->insert('m_trader_barang_inout', $arrBrgInout);
				}				
				$arrUpdateBrg = array("STOCK_AKHIR"=>$newStok);
				$this->db->where(array('KODE_BARANG' => $kodeBarang, 'KODE_TRADER' => $kodeTrader));
				$exec = $this->db->update('m_trader_barang', $arrUpdateBrg);
				if($exec){
					$this->db->where(array('KODE_BARANG' => $kodeBarang,
											'JNS_BARANG' => $arrInvBrg['JNS_BARANG'],
											'KODE_GUDANG' => $arrInvBrg['KODE_GUDANG'],
											'KODE_RAK'	 => $arrInvBrg['KODE_RAK'],
											'KODE_SUB_RAK' => $arrInvBrg['KODE_SUB_RAK'],
											'KONDISI_BARANG' => $arrInvBrg['KONDISI_BARANG'],
											'KODE_TRADER' => $kodeTrader));
						$this->db->update('m_trader_barang_gudang', array("JUMLAH"=>$newStok_gudang));
					echo "MSG#OK#Ubah data Berhasil#".site_url()."/pengeluaran/pemusnahan/draftPemusnahan#";
				}else{					
					echo "MSG#ERR#Ubah data Gagal#";
				}
			}
		}
	}
	
	function getData($tipe,$id){
		$conn = get_instance();
		$conn->load->model("main");
		$idTrader=$this->newsession->userdata("KODE_TRADER");
		if($tipe=="pengrusakan"){
				$query = "SELECT *, f_satuan(A.KODE_SATUAN) AS 'URAIAN_SATUAN', B.URAIAN_BARANG, 
						  f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS_BARANG'
						  FROM T_PENGRUSAKAN_BRG A
						  LEFT JOIN M_TRADER_BARANG B ON B.KODE_BARANG=A.KODE_BARANG AND B.KODE_TRADER=A.KODE_TRADER
						  WHERE A.ID=".$id."  AND A.KODE_TRADER='".$idTrader."'";//echo $query;		
		}elseif($tipe=="pemusnahan"){
				$query = "SELECT *, f_satuan(A.KODE_SATUAN) AS 'URAIAN_SATUAN', B.URAIAN_BARANG, 
						  f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS_BARANG'
						  FROM T_PEMUSNAHAN_BRG A
						  LEFT JOIN M_TRADER_BARANG B ON B.KODE_BARANG=A.KODE_BARANG AND B.KODE_TRADER=A.KODE_TRADER
						  WHERE A.ID=".$id."  AND A.KODE_TRADER='".$idTrader."'";#echo $query;die();
		}
		$hasil = $conn->main->get_result($query);
					if($hasil){
						foreach($query->result_array() as $row){
							$dataarray = $row;
						}
					}	
		return $dataarray;
	}
	
	function getGudangPemusnahan(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		
		$SQL = "SELECT KODE_GUDANG, KONDISI_BARANG, IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA') AS NAMA_GUDANG 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' ORDER BY KODE_GUDANG DESC";
				
		$GUDANG = $func->main->get_combobox($SQL,"KODE_GUDANG","NAMA_GUDANG",FALSE);
		$KONDISI = $func->main->get_combobox($SQL,"KONDISI_BARANG","KONDISI_BARANG",FALSE);
		return form_dropdown('RUSAK[KODE_GUDANG]', array_merge(array(""=>"-- Pilih --"),$GUDANG), $sess['KODE_GUDANG'], 'id="KODE_GUDANG" class="text" wajib="yes" onclick="getKondisiPemusnahan(this.value)"')."#".form_dropdown('RUSAK[KONDISI_BARANG]', array_merge(array(""=>"-- Pilih --"),$KONDISI), $sess['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="text" wajib="yes"');
	}
	
	function getKondisiPemusnahan(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_GUDANG = $this->input->post("kode_gudang");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		
		$SQL = "SELECT KONDISI_BARANG 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' AND KODE_GUDANG='".$KODE_GUDANG."' ORDER BY KODE_RAK DESC";				
		$KONDISI = $func->main->get_combobox($SQL,"KONDISI_BARANG","KONDISI_BARANG",FALSE);
		return form_dropdown('RUSAK[KONDISI_BARANG]', array_merge(array(""=>"-- Pilih --"),$KONDISI), $sess['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="text" wajib="yes" onChange="getRakPemusnahan(this.value)"')."#"."";
	}
	
	function getRakPemusnahan(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_GUDANG = $this->input->post("kode_gudang");
		$KONDISI_BARANG = $this->input->post("kondisi_barang");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		$wajib = 'wajib="yes"';
		$SQL = "SELECT KODE_RAK, IFNULL(f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER),'-') AS NAMA_RAK 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' AND KODE_GUDANG='".$KODE_GUDANG."' 
				AND KONDISI_BARANG = '".$KONDISI_BARANG."' ORDER BY KODE_RAK DESC";				
		$RAK = $func->main->get_combobox($SQL,"KODE_RAK","NAMA_RAK",FALSE);
		$val = $func->main->get_uraian($SQL,"KODE_RAK");
		if($val==""){
			$RAK = array();
			$wajib = 'wajib="no"';
		}
		return form_dropdown('RUSAK[KODE_RAK]', array_merge(array(""=>"-- Pilih --"),$RAK), $sess['KODE_RAK'], 'id="KODE_RAK" class="text" '.$wajib.' onChange="getSubRakPemusnahan()"')."#"."";
	}
	function getSubRakPemusnahan(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_GUDANG = $this->input->post("kode_gudang");
		$KODE_RAK = $this->input->post("kode_rak");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		
		$SQL = "SELECT KODE_SUB_RAK, IFNULL(f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER),'NULL') AS NAMA_SUB_RAK 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' AND KODE_GUDANG='".$KODE_GUDANG."' 
				AND KODE_RAK = '".$KODE_RAK."' ORDER BY KODE_SUB_RAK DESC";
		//echo $SQL;
		//die();				
		$SUB_RAK = $func->main->get_combobox($SQL,"KODE_SUB_RAK","NAMA_SUB_RAK",FALSE);
		return form_dropdown('RUSAK[KODE_SUB_RAK]', array_merge(array(""=>"-- Pilih --"),$SUB_RAK), $sess['KODE_SUB_RAK'], 'id="KODE_SUB_RAK" class="text" wajib="yes"')."#"."";
	}
}
?>