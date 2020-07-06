<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Master_act extends CI_Model 
{
    function list_divisi($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        if ($tipe) {
            $title = "List Data Divisi";
            $prosesnya = array(
                'Tambah' => array('GET',site_url().'/master/add/pemasok', '0','icon-plus'),
                'Ubah'   => array('EDITJS', site_url().'/master/edit/pemasok', '1','icon-edit'),
                'Hapus'  => array('DELETE', site_url().'/master/delete/pemasok', 'pemasok','red icon-remove'
            ));
            $SQL = "SELECT id_divisi, divisi AS 'Nama Divisi' FROM tbl_divisi WHERE id_divisi <> 1";
            $this->newtable->search(array(
                array('divisi', 'Nama Divisi')
            ));
            $this->newtable->action(site_url() . "/master/divisi/list");
            $this->newtable->hiddens(array('id_divisi'));
            $this->newtable->keys(array('id_divisi'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("ASC");
            $this->newtable->set_formid("fdivisi");
            $this->newtable->set_divid("divdivisi");
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "jenis" => $jenis,
                "tipe" => "divisi"
            );
            if ($this->input->post("ajax")||$ajax=="ajax"){
                return $tabel;
            } else {
                return $arrdata;
            }
        } else {
            redirect(base_url());
            exit();
        }
    }
    function proses_form($tipe = "", $id = "",  $id2 = "") {
        $conn = get_instance();
        $conn->load->model("main");
        $kodeTrader = $this->newsession->userdata("KODE_TRADER");
        if($tipe == "profil"){
            foreach ($this->input->post('PROFIL') as $a => $b){
                $arrProf[$a] = $b;
            }
            $arrProf["ID"] = str_replace("-", "", str_replace(".", "", $arrProf["ID"]));
            $this->db->where(array('KODE_TRADER' => $kodeTrader));
            $exec = $this->db->update('m_trader', $arrProf);
			
			$ses['LOGO'] = $arrProf['LOGO'];
            $this->newsession->set_userdata($ses);
            
			if($exec){
                $conn->main->activity_log('EDIT PROFIL', '');
                echo "MSG#OK#Ubah Data Berhasil.#" . site_url() . "/master/profil/lihat#";
            }else{
                echo "MSG#ERR#Ubah Data Gagal.#" . site_url() . "/master/profil/lihat#";
            }
        }elseif($tipe == "pemasok"){
            $act = $this->input->post('act');
            foreach ($this->input->post('DATA') as $a => $b){
                $arrPemasok[$a] = $b;
            }
            if($act == "save"){
                $arrPemasok['KODE_TRADER'] = $kodeTrader;
                $exec = $this->db->insert('m_trader_partner', $arrPemasok);
                if ($exec) {
                    $conn->main->activity_log('ADD PEMASOK', '');
                    echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/daftar/pemasok#";
                } else {
                    echo "MSG#ERR#Simpan data Gagal#".site_url()."/master/daftar/pemasok#";
                }
            } elseif ($act == "update") {
                $this->db->where(array('KODE_TRADER' => $kodeTrader, 'KODE_PARTNER' => $id));
                $exec = $this->db->update('m_trader_partner', $arrPemasok);
                if ($exec) {
                    echo "MSG#OK#Ubah data Berhasil#" . site_url() . "/master/daftar/pemasok#";
                } else {
                    echo "MSG#ERR#Ubah data Gagal#".site_url()."/master/daftar/pemasok#";
                }
            } else {
                $ret = "MSG#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfpemasok');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode(".", $chkitem);
                    $id = strtolower($arrchk[0]);
                    $this->db->where(array('KODE_PARTNER' => $id, 'KODE_TRADER' => $kodeTrader));
                    $this->db->delete('m_trader_partner');
                    $conn->main->activity_log('DELETE PEMASOK', 'KODE_PARTNER=' . $id);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/daftar/pemasok/ajax";
                echo $ret;
            }
        } elseif ($tipe == "draftMapping") {
            $act = $this->input->post('act');
            foreach ($this->input->post('DATA') as $a => $b) {
                $arrMapping[$a] = $b;
            }
            if ($act == "save") {
                $SQL = "SELECT IDMAPPING FROM m_trader_mapping_brg 
						WHERE KODE_PARTNER='" . $arrMap["KODE_PARTNER"] . "' AND KODE_BARANG_PARTNER='" . $arrMap["KODE_BARANG_PARTNER"] . "'";
                $data = $this->db->query($SQL);
                if ($data->num_rows() > 0) {
                    echo "MSG#ERR#Kode Barang Pemasok sudah pernah digunakan.#" . site_url() . "/master/daftar/draftMapping#";
                    die();
                }

                $SQL = "SELECT IDMAPPING FROM m_trader_mapping_brg 
						WHERE KODE_PARTNER='" . $arrMap["KODE_PARTNER"] . "' AND KODE_BARANG='" . $arrMap["KODE_BARANG"] . "'";
                $data = $this->db->query($SQL);
                if ($data->num_rows() > 0) {
                    echo "MSG#ERR#Kode Barang Internal sudah pernah digunakan.#" . site_url() . "/master/daftar/draftMapping#";
                    die();
                }
                $arrMap['KODE_TRADER'] = $kodeTrader;
                $exec = $this->db->insert('m_trader_mapping_brg', $arrMap);
                if ($exec) {
                    echo "MSG#OK#Simpan data Mapping Berhasil#";
                } else {
                    echo "MSG#ERR#Simpan data Mapping Gagal#";
                }
            } elseif ($act == "update") {
                $this->db->where(array('KODE_TRADER' => $kodeTrader, 'KODE_PARTNER' => $id));
                $exec = $this->db->update('m_trader_partner', $arrMapping);
                if ($exec) {
                    echo "MSG#OK#Ubah data Berhasil#" . site_url() . "/master/daftar/draftMapping#";
                } else {
                    echo "MSG#ERR#Ubah data Gagal#" . site_url() . "/master/daftar/draftMapping#";
                }
            } elseif ($act == "delete") {
				$ret = "MSG#Hapus data Gagal";
                $kodeTrader = $this->newsession->userdata('KODE_TRADER');
                $dataCheck = $this->input->post('tb_chkfdraftMapping');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode(".", $chkitem);
                    $idPartner = strtolower($arrchk[0]);
                    $this->db->where(array('KODE_PARTNER' => $idPartner, 'KODE_TRADER' => $kodeTrader));
                    $this->db->delete('m_trader_mapping_brg');
                    $conn->main->activity_log('DELETE MAPPING BARANG', 'KODE_PARTNER=' . $idPartner);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/daftar/draftMapping/ajax";
                echo $ret;
            }
        } elseif ($tipe == "mapping") {
            $act = $this->input->post('act');
            foreach ($this->input->post('MAPPING') as $a => $b) {
                $arrMap[$a] = $b;
            }
            if (strtolower($act) == "save") {
                $SQL = "SELECT IDMAPPING FROM m_trader_mapping_brg 
						WHERE KODE_PARTNER='" . $arrMap["KODE_PARTNER"] . "' AND KODE_BARANG_PARTNER='" . $arrMap["KODE_BARANG_PARTNER"] . "'";
                $data = $this->db->query($SQL);
                if ($data->num_rows() > 0) {
                    echo "MSG#ERR#Kode Barang Pemasok sudah pernah digunakan.#". site_url() . "/master/mapping_dok/mapping/" . $arrMap["KODE_PARTNER"] . "/save#";
                    die();
                }

                $SQL = "SELECT IDMAPPING FROM m_trader_mapping_brg 
						WHERE KODE_PARTNER='" . $arrMap["KODE_PARTNER"] . "' AND KODE_BARANG='" . $arrMap["KODE_BARANG"] . "'";
                $data = $this->db->query($SQL);
                if ($data->num_rows() > 0) {
                    echo "MSG#ERR#Kode Barang Internal sudah pernah digunakan.#". site_url() . "/master/mapping_dok/mapping/" . $arrMap["KODE_PARTNER"] . "/save#";
                    die();
                }
                $arrMap['KODE_TRADER'] = $kodeTrader;
                $exec = $this->db->insert('m_trader_mapping_brg', $arrMap);
                if ($exec) {
                    echo "MSG#OK#Simpan data Mapping Berhasil#". site_url() . "/master/mapping_dok/mapping/" . $arrMap["KODE_PARTNER"] . "/save#";
                } else {
                    echo "MSG#ERR#Simpan data Mapping Gagal#". site_url() . "/master/mapping_dok/mapping/" . $arrMap["KODE_PARTNER"] . "/save#";
                }
            } elseif (strtolower($act) == "update") {
                $SQL = "SELECT IDMAPPING FROM m_trader_mapping_brg 
						WHERE KODE_PARTNER='" . $arrMap["KODE_PARTNER"] . "' AND KODE_BARANG_PARTNER='" . $arrMap["KODE_BARANG_PARTNER"] . "'";
                $data = $this->db->query($SQL);
                if ($data->num_rows() > 0) {
                    echo "MSG#ERR#Kode Barang Pemasok sudah pernah digunakan.#". site_url() . "/master/mapping_dok/mapping/" . $arrMap["KODE_PARTNER"] . "/update#";
                    die();
                }

                $idMapping = $this->input->post('idMapping');
                $this->db->where(array('KODE_TRADER' => $kodeTrader, 'IDMAPPING' => $idMapping));
                $exec = $this->db->update('m_trader_mapping_brg', $arrMap);
                if ($exec) {
                    echo "MSG#OK#Ubah data Mapping Berhasil#". site_url() . "/master/mapping_dok/mapping/" . $arrMap["KODE_PARTNER"] . "/update#";
                } else {
                    echo "MSG#ERR#Ubah data Mapping Gagal#". site_url() . "/master/mapping_dok/mapping/" . $arrMap["KODE_PARTNER"] . "/update#";
                }
            } elseif (strtolower($act) == "delete") {
				$ret = "MSG#Hapus data Gagal";
				$kodeTrader = $this->newsession->userdata('KODE_TRADER');
                $dataCheck = $this->input->post('tb_chkfmapping');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $id = strtolower($arrchk[0]);
                    $idPartner = strtolower($arrchk[1]);
                    $this->db->where(array('IDMAPPING' => $id, 'KODE_PARTNER' => $idPartner, 'KODE_TRADER' => $kodeTrader));
                    $this->db->delete('m_trader_mapping_brg');
                    $conn->main->activity_log('DELETE DETIL MAPPING BARANG', 'KODE_PARTNER=' . $idPartner . ', SERI=' . $id);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/mapping_dok/mapping/" . $idPartner . "/delete#";
                echo $ret;				
			}
        } elseif ($tipe == "gudang") {
            $act = $this->input->post('act');
            foreach ($this->input->post('DATA') as $a => $b) {
                $arrGudang[$a] = $b;
            }
            if ($act == "save") {
                $arrGudang['KODE_TRADER'] = $kodeTrader;
				#untuk cek gudang
				$SQL = "SELECT KODE_GUDANG FROM m_trader_gudang WHERE KODE_TRADER = '".$arrGudang['KODE_TRADER']."' 
						AND KODE_GUDANG = '".$arrGudang["KODE_GUDANG"]."'";
				$data1 = $this->db->query($SQL);
				if ($data1->num_rows() > 0) {
                    echo "MSG#ERR#Kode Gudang sudah ada di dalam aplikasi.";
					die();
                }else{
					$exec = $this->db->insert('m_trader_gudang', $arrGudang);
					if ($exec) {
						$conn->main->activity_log('ADD GUDANG', '');
						echo "MSG#OK#Simpan data Berhasil#" .site_url()."/master/daftar/gudang#";
					} else {
						echo "MSG#ERR#Simpan data Gagal#";
					}
				}
            } elseif ($act == "update") {
                $this->db->where(array('KODE_TRADER' => $kodeTrader, 'KODE_GUDANG' => $id));
                $exec = $this->db->update('m_trader_gudang', $arrGudang);
                if ($exec) {
                    echo "MSG#OK#Ubah data Berhasil#" . site_url() . "/master/daftar/gudang#";
                } else {
                    echo "MSG#ERR#Ubah data Gagal#";
                }
            } else {				
				foreach($this->input->post("tb_chkfgudang") as $chk){
					$SQL = "SELECT KODE_GUDANG FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER = '".$kodeTrader."' AND KODE_GUDANG = '".$chk."'";
					$rs = $this->db->query($SQL);
					if($rs->num_rows()==0){
						$this->db->where(array('KODE_GUDANG'=>$chk, 'KODE_TRADER'=>$kodeTrader));	
						$this->db->delete('M_TRADER_GUDANG');					
						$conn->main->activity_log('DELETE DATA GUDANG','KODE GUDANG = '.$chk);
						$ret = "MSG#OK#Hapus Data Gudang Berhasil#". site_url()."/master/daftar/gudang/ajax";
					}else{
						$ret = "MSG#ERR#Hapus Gagal. Data sudah terdapat mutasi#";	
					}
				}
				echo $ret;
            }
		} elseif ($tipe == "rak") {
            $act = $this->input->post('act');
            foreach ($this->input->post('DATA') as $a => $b) {
                $arrRak[$a] = $b;
            }
            if ($act == "save") {
                $arrRak['KODE_TRADER'] = $kodeTrader;
				$SQL = "SELECT KODE_GUDANG,KODE_RAK FROM m_trader_rak WHERE KODE_TRADER = '".$arrRak['KODE_TRADER'] 						."' AND KODE_GUDANG = '".$arrRak["KODE_GUDANG"]."' AND KODE_RAK = '".$arrRak['KODE_RAK']."'";
				$data1 = $this->db->query($SQL);
				if($data1->num_rows() > 0){
					echo "MSG#ERR#Kode Rak sudah ada di dalam aplikasi.#".site_url()."/master/daftar/rak#";
					die();
				}else{
                	$exec = $this->db->insert('m_trader_rak', $arrRak);
                	if ($exec) {
                    		$conn->main->activity_log('ADD RAK', '');
                    		echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/daftar/rak#";
                	} else {
                    		echo "MSG#ERR#Simpan data Gagal#";
                	}
				}
            } elseif ($act == "update") {
                $this->db->where(array('KODE_TRADER' => $kodeTrader, 'KODE_GUDANG'=>$id, 'KODE_RAK' => $id2));
                $exec = $this->db->update('m_trader_rak', $arrRak);
                if ($exec) {
                    echo "MSG#OK#Ubah data Berhasil#" . site_url() . "/master/daftar/rak#";
                } else {
                    echo "MSG#ERR#Ubah data Gagal#" . site_url() . "/master/daftar/rak#";
                }
            } else {
                $ret = "MSG#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfrak');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $kodeGudang = strtolower($arrchk[0]);
					$kodeRak	= strtolower($arrchk[1]);
                    $this->db->where(array('KODE_GUDANG' => $kodeGudang, 'KODE_RAK' => $kodeRak, 'KODE_TRADER' => $kodeTrader));
                    $this->db->delete('m_trader_rak');
                    $conn->main->activity_log('DELETE RAK', 'KODE_RAK=' . $id);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/daftar/rak/ajax";
                echo $ret;
            }
	    } elseif ($tipe == "sub_rak") {
            $act = $this->input->post('act');
            foreach ($this->input->post('DATA') as $a => $b) {
                $arrSubRak[$a] = $b;
            }
            if ($act == "save") {
                $arrSubRak['KODE_TRADER'] = $kodeTrader;
		        $SQL = "SELECT KODE_GUDANG,KODE_RAK,KODE_SUB_RAK FROM m_trader_sub_rak WHERE KODE_TRADER = '".$arrSubRak['KODE_TRADER'] ."' AND KODE_GUDANG = '".$arrSubRak["KODE_GUDANG"]."' AND KODE_RAK = '".$arrSubRak['KODE_RAK']."' AND KODE_SUB_RAK = '".$arrSubRak['KODE_SUB_RAK']."'";
		        $data1 = $this->db->query($SQL);
        		if($data1->num_rows() > 0){
        			echo "MSG#ERR#Kode Sub Rak sudah ada di dalam aplikasi.#".site_url()."/master/daftar/sub_rak#";
        			die();
        		}else{
                        	$exec = $this->db->insert('m_trader_sub_rak', $arrSubRak);
                        	if ($exec) {
                            		$conn->main->activity_log('ADD RAK', '');
                            		echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/daftar/sub_rak#";
                        	} else {
                            		echo "MSG#ERR#Simpan data Gagal#";
                        	}
        		}
            } elseif ($act == "update") {
		      $kode_sub_rak = $this->input->post('KODE_SUB_RAK');
                $this->db->where(array('KODE_TRADER' => $kodeTrader, 'KODE_GUDANG'=>$id, 'KODE_RAK' => $id2, 'KODE_SUB_RAK'=>$kode_sub_rak));
                $exec = $this->db->update('m_trader_sub_rak', $arrSubRak);
                if ($exec) {
                    echo "MSG#OK#Ubah data Berhasil#" . site_url() . "/master/daftar/sub_rak#";
                } else {
                    echo "MSG#ERR#Ubah data Gagal#" . site_url() . "/master/daftar/sub_rak#";
                }
            } else {
                $ret = "MSG#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfsub_rak');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $kodeGudang = strtolower($arrchk[0]);
					$kodeRak	= strtolower($arrchk[1]);
					$kodeSubRak	= strtolower($arrchk[2]);
                    $this->db->where(array('KODE_GUDANG' => $kodeGudang, 'KODE_RAK' => $kodeRak, 'KODE_TRADER' => $kodeTrader, 'KODE_SUB_RAK' => $kodeSubRak));
                    $this->db->delete('m_trader_sub_rak');
                    $conn->main->activity_log('DELETE SUB RAK', 'KODE_SUB_RAK=' . $id);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/daftar/sub_rak/ajax";
                echo $ret;
            }
	    } elseif ($tipe == "penyelenggara") {
            $act = $this->input->post('act');
            foreach ($this->input->post('PENYELENGGARA') as $a => $b) {
               	$arrPenyelenggara[$a] = $b;
            }
			$this->load->helper('email');
            if ($act == "save") {				
				if(!valid_email($arrPenyelenggara["EMAIL_USER"])){
					echo "MSG#ERR#Email tidak valid, periksa kembali email anda.";		
					die();			
				}
				//tambahan
				$NPWP = str_replace(".","",str_replace("-","",$arrPenyelenggara["ID"]));
				$SQL = "SELECT USERNAME FROM T_USER WHERE USERNAME='".$arrPenyelenggara["USERNAME"]."' UNION 
						SELECT ID FROM M_TRADER_TEMP WHERE USERNAME='".$arrPenyelenggara["USERNAME"]."'";
				$cek = $this->db->query($SQL);
				if($cek->num_rows() > 0){
					$ret = "MSG#ERR#Username sudah ada.";
				} else {		
					$KONFPASSWORD = $this->input->post('KONFPASSWORD');
					if($arrPenyelenggara["PASSWORD"]==$KONFPASSWORD){					
						$arrPenyelenggara["CREATED_TIME"] = date('Y-m-d H:i:s');		
						$arrPenyelenggara["PASS"] = $arrPenyelenggara["PASSWORD"];
						$arrPenyelenggara["PASSWORD"] = md5($arrPenyelenggara["PASSWORD"]);	
						$arrPenyelenggara["ID"]=$NPWP;
					
						$NOREGISTRASI="";
						for($i = 0; $i < 6; $i++) {
							$NOREGISTRASI .= rand(97, 122);
						}
						$arrPenyelenggara["NO_REGISTRASI"] = $NOREGISTRASI;
					
						$SQL1 = "SELECT MAX(SUBSTRING(KODE_TRADER,9,4))+1 MAXKODE FROM M_TRADER WHERE KODE_TRADER <> 'EDIINDONESIA'";
						$SQL2 = "SELECT MAX(SUBSTRING(KODE_TRADER,9,4))+1 MAXKODE FROM M_TRADER_TEMP";
						$rs1 = $this->db->query($SQL1);
						$rs2 = $this->db->query($SQL2);
						if($rs1->num_rows()>0) $MAXKODE_1 = (int)$rs1->row()->MAXKODE;
						if($rs2->num_rows()>0) $MAXKODE_2 = (int)$rs2->row()->MAXKODE;
						if($MAXKODE_1>=$MAXKODE_2) $NEXTID = $MAXKODE_1;
						else $NEXTID = $MAXKODE_2;
						$SISIP = substr(str_replace(array("PT","pt",".",","," "),"",$arrPenyelenggara["NAMA"]),0,4);
						$arrPenyelenggara["KODE_TRADER"] = "EDI".$SISIP.sprintf("%05d", $NEXTID);
						//echo $arrPenyelenggara;
						//die();						
						$exec = $this->db->insert('m_trader_temp', $arrPenyelenggara);
						if($exec){
							$isi = '<p>Selamat '.$arrPenyelenggara["NAMA"].' , Anda telah berhasil melakukan registrasi.<br />
									Email dan no registrasi anda :<br />
									Email : '.$arrPenyelenggara["EMAIL_USER"].'<br />
									No registrasi : '.$NOREGISTRASI.'
								</p>
								<p>Langkah selanjutnya adalah mempersiapkan dokumen pendukung dengan melengkapi:<br />
								1. NPWP<br />
								2. Ijin Domisili<br />
								3. SIUP<br />
								4. SK-Gudang Berikat<br />
								7. API<br />
								<p>Dokumen pendukung tersebut di atas dapat dikirimkan kepada :<br />PT EDI INDONESIA</p>
								<p>Wisma SMR 10th Fl<br />Jl Yos Sudarso Kav. 89<br />Jakarta Utara &ndash; 14350</p>
								<p>email : &nbsp;<a href="mailto:customs2@edi-indonesia.co.id">customs2@edi-indonesia.co.id</a></p>
								<p>telepon : 021 6505829</p>
								<p><br />Apabila Bapak/Ibu masih membutuhkan informasi lainnya terkait aplikasi GBInventory ini dapat menghubungi PIC kami sebagai berikut :</p>
								<ul><li>Rossa telp 021 650 5829 ext 8121 email : <a href="mailto:rossa@edi-indonesia.co.id">rossa@edi-indonesia.co.id</a></li><li>Ginanjar Anggi Wiratmoko telp 021 650 5829 ext 8211 email : <a href="mailto:ginanjar@edi-indonesia.co.id">ginanjar@edi-indonesia.co.id</a></li></ul>
								';											

							if($this->send_mail($arrPenyelenggara["EMAIL_USER"],'', 'Konfirmasi Registrasi PLBInventory', $isi,'')){
						}
							$ret = "MSG#OK#Register perusahaan Berhasil.<br>Silahkan cek email anda untuk proses lebih lanjut.<br>Terimakasih.#".site_url()."/master/daftar/penyelenggara#";
						}else{					
							$ret = "MSG#ERR#Register perusahaan Gagal#";
						}	 
					}else{
						$ret = "MSG#ERR#Password tidak sama.";
					}				
				}
				echo $ret;
				die();			
		          //} 
		
				/*$arrPenyelenggara['JENIS_PLB'] = '00';							
				$exec = $this->db->insert('m_trader_temp', $arrPenyelenggara);
				if ($exec) {
					$conn->main->activity_log('ADD TRADER', '');
					echo "MSG#OK#Simpan data Berhasil#" .site_url()."/master/daftar/penyelenggara#";
				} else {
						echo "MSG#ERR#Simpan data Gagal#";
				}*/				
            } elseif ($act == "update") {
				$KODE_TRADER = $this->input->post('KODE_TRADER');
				if(!valid_email($arrPenyelenggara["EMAIL_USER"])){
					echo "MSG#ERR#Email tidak valid, periksa kembali email anda.";		
					die();		
				}
				$NPWP = str_replace(".","",str_replace("-","",$arrPenyelenggara["ID"]));
				$arrPenyelenggara["ID"]=$NPWP;
				$this->db->where('KODE_TRADER',$KODE_TRADER);			
				$exec = $this->db->update('m_trader_temp', $arrPenyelenggara);
				if ($exec) {
					$conn->main->activity_log('UPDATE TRADER', '');
					echo "MSG#OK#Simpan data Berhasil#" .site_url()."/master/daftar/penyelenggara#";
				} else {
						echo "MSG#ERR#Simpan data Gagal#";
				}				
            } else {
				$ret = "MSG#ERR#Hapus Gagal#";	
				foreach($this->input->post("tb_chkfpenyelenggara") as $chk){					
						$this->db->where(array('KODE_TRADER'=>$chk));	
						$this->db->delete('M_TRADER_TEMP');					
						$conn->main->activity_log('DELETE DATA TRADER','KODE_TRADER = '.$chk);
						$ret = "MSG#OK#Hapus Data Gudang Berhasil#". site_url()."/master/daftar/penyelenggara/ajax";
						
				}
				echo $ret;
			}
	    } elseif ($tipe == "anggota") {
            $act = $this->input->post('act');
            foreach ($this->input->post('ANGGOTA') as $a => $b) {
                $arrAnggota[$a] = $b;
            }
			$this->load->helper('email');
            if ($act == "save") {
				if(!valid_email($arrAnggota["EMAIL_USER"])){
					echo "MSG#ERR#Email tidak valid, periksa kembali email anda.";die();			
				}
				$NPWP = str_replace(".","",str_replace("-","",$arrAnggota["ID"]));
				$SQL = "SELECT USERNAME FROM T_USER WHERE USERNAME='".$arrAnggota["USERNAME"]."' 
						UNION 
						SELECT ID FROM M_TRADER_TEMP WHERE USERNAME='".$arrAnggota["USERNAME"]."'";
				$cek = $this->db->query($SQL);
				if($cek->num_rows() > 0){
					$ret = "MSG#ERR#Username sudah ada.";
				} else {		
					$KONFPASSWORD = $this->input->post('KONFPASSWORD');
					if($arrAnggota["PASSWORD"]==$KONFPASSWORD){					
						$SQL1 = "SELECT MAX(SUBSTRING(KODE_TRADER,9,4))+1 MAXKODE FROM M_TRADER WHERE KODE_TRADER <> 'EDIINDONESIA'";
						$SQL2 = "SELECT MAX(SUBSTRING(KODE_TRADER,9,4))+1 MAXKODE FROM M_TRADER_TEMP";
						$rs1 = $this->db->query($SQL1);
						$rs2 = $this->db->query($SQL2);
						if($rs1->num_rows()>0) $MAXKODE_1 = (int)$rs1->row()->MAXKODE;
						if($rs2->num_rows()>0) $MAXKODE_2 = (int)$rs2->row()->MAXKODE;
						if($MAXKODE_1>=$MAXKODE_2) $NEXTID = $MAXKODE_1;
						else $NEXTID = $MAXKODE_2;
						$SISIP = substr(str_replace(array("PT","pt",".",","," "),"",$arrAnggota["NAMA"]),0,4);
						
						$trader["KODE_TRADER"] 				= "EDI".$SISIP.sprintf("%05d", $NEXTID);
						$trader["JENIS_PLB"] 				= "01";
						$trader["INDUK_PLB"] 				= $this->newsession->userdata("KODE_TRADER");
						$trader["KODE_ID"] 					= $arrAnggota["KODE_ID"];
						$trader["ID"] 						= $arrAnggota["ID"];
						$trader["NAMA"] 					= $arrAnggota["NAMA"];
						$trader["ALAMAT"] 					= $arrAnggota["ALAMAT"];
						$trader["TELEPON"] 					= $arrAnggota["TELEPON"];
						$trader["FAX"] 						= $arrAnggota["FAX"];
						$trader["STATUS_TRADER"] 			= $arrAnggota["STATUS_TRADER"];
						$trader["BIDANG_USAHA"] 			= $arrAnggota["BIDANG_USAHA"];
						$trader["JENIS_TRADER"] 			= $arrAnggota["JENIS_TRADER"];
						$trader["JENIS_BARANG_TIMBUN"] 		= $arrAnggota["JENIS_BARANG_TIMBUN"];
						$trader["TUJUAN_DISTRIBUSI"] 		= $arrAnggota["TUJUAN_DISTRIBUSI"];
						$trader["LOKASI_GB"] 				= $arrAnggota["LOKASI_GB"];
						$trader["DESA_KEL_GB"] 				= $arrAnggota["DESA_KEL_GB"];
						$trader["KOTA_GB"] 					= $arrAnggota["KOTA_GB"];
						$trader["PROPINSI_GB"] 				= $arrAnggota["PROPINSI_GB"];
						$trader["LUAS_LOKASI_GB"] 			= $arrAnggota["LUAS_LOKASI_GB"];
						$trader["BATAS_BARAT_GB"] 			= $arrAnggota["BATAS_BARAT_GB"];
						$trader["BATAS_TIMUR_GB"] 			= $arrAnggota["BATAS_TIMUR_GB"];
						$trader["BATAS_UTARA_GB"] 			= $arrAnggota["BATAS_UTARA_GB"];
						$trader["BATAS_SELATAN_GB"] 		= $arrAnggota["BATAS_SELATAN_GB"];
						$trader["LUAS_LOKASI_PDGB"] 		= $arrAnggota["LUAS_LOKASI_PDGB"];
						$trader["BATAS_BARAT_PDGB"] 		= $arrAnggota["BATAS_BARAT_PDGB"];
						$trader["BATAS_TIMUR_PDGB"] 		= $arrAnggota["BATAS_TIMUR_PDGB"];
						$trader["BATAS_UTARA_PDGB"] 		= $arrAnggota["BATAS_UTARA_PDGB"];
						$trader["BATAS_SELATAN_PDGB"] 		= $arrAnggota["BATAS_SELATAN_PDGB"];
						$trader["KODE_API"] 				= $arrAnggota["KODE_API"];
						$trader["NOMOR_API"] 				= $arrAnggota["NOMOR_API"];
						$trader["NOMOR_SRP"] 				= $arrAnggota["NOMOR_SRP"];
						$trader["NAMA_PENANGGUNGJAWAB"] 	= $arrAnggota["NAMA_PENANGGUNGJAWAB"];
						$trader["ALAMAT_PENANGGUNGJAWAB"] 	= $arrAnggota["ALAMAT_PENANGGUNGJAWAB"];
						$trader["CREATED_TIME"] 			= date('Y-m-d H:i:s');	
						$trader["STATUS"] 					= 1;
						$exec = $this->db->insert('m_trader', $trader);
						if($exec){
							$datauser["USER_ID"] 		= (int)$conn->main->get_uraian("SELECT MAX(USER_ID) AS MAXSERI FROM T_USER", "MAXSERI") + 1;
							$datauser["KODE_TRADER"]	= $trader["KODE_TRADER"];
							$datauser["USERNAME"]		= $arrAnggota["USERNAME"];
							$datauser["PASSWORD"]		= md5($arrAnggota["PASSWORD"]);
							$datauser["NAMA"]			= $arrAnggota["NAMA_USER"];
							$datauser["ALAMAT"]			= $arrAnggota["ALAMAT_USER"];
							$datauser["TELEPON"]		= $arrAnggota["TELEPON_USER"];
							$datauser["JABATAN"]		= $arrAnggota["JABATAN_USER"];
							$datauser["EMAIL"]			= $arrAnggota["EMAIL_USER"];
							$datauser["STATUS"]			= '1';
							
							#JUST 4 DEV
							date_default_timezone_set('Asia/Jakarta');
							
							$dataskep["KODE_TRADER"]	= $trader["KODE_TRADER"];
							$dataskep["KODE_SKEP"]		= $arrAnggota["KODE_SKEP"];
							$dataskep["NOMOR_SKEP"]		= $arrAnggota["NOMOR_SKEP"];
							$dataskep["TANGGAL_SKEP"]	= $arrAnggota["TANGGAL_SKEP"];
							$dataskep["SERI"]			= '1';
							
							$this->db->insert('m_setting', array('KODE_TRADER'=>$trader["KODE_TRADER"],'LAST_AJU'=>1,'LAST_PROSES'=>1));
							$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$trader["KODE_TRADER"],'DOKNAME'=>'BC281','NO_URUT'=>1));
							$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$trader["KODE_TRADER"],'DOKNAME'=>'BC27','NO_URUT'=>1));
							$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$trader["KODE_TRADER"],'DOKNAME'=>'BC30','NO_URUT'=>1));
							$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$trader["KODE_TRADER"],'DOKNAME'=>'BC282','NO_URUT'=>1));
							$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$trader["KODE_TRADER"],'DOKNAME'=>'BC40','NO_URUT'=>1));
							$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$trader["KODE_TRADER"],'DOKNAME'=>'BC24','NO_URUT'=>1));
							$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$trader["KODE_TRADER"],'DOKNAME'=>'BC41','NO_URUT'=>1));
							
							$this->db->insert('t_user', $datauser);
							$this->db->insert('t_user_role', array("USER_ID"=>$datauser["USER_ID"],"KODE_ROLE"=>"6"));
							$this->db->insert('m_trader_skep', $dataskep);
							
							$this->prosesmenu($datauser["USER_ID"]);
							
							$isi = 'Anngota baru telah ditambahkan pada perusahaan '.$this->newsession->userdata("NAMA_TRADER").', 
									Berikut Akun Anda di '.$_SERVER['HTTP_HOST'].' Silahkan login dengan:
									<table style="margin: 4px 4px 4px 0px; font-family: arial; font-size:12px; font-weight: 700;">
									<tr>
										<td>Nama Anggota</td>
										<td>'.$arrAnggota["NAMA"].'</td>
									</tr>
									<tr>
										<td width="75">Username</td>
										<td>: <b>'.$arrAnggota["USERNAME"].'</b></td>
									</tr>
									<tr>
										<td>Password</td>
										<td>: <b>'.$arrAnggota["PASSWORD"].'</b></td>
									</tr>
									<tr><td colspan="2">&nbsp;</td></tr>
									<tr><td colspan="2"><span style="color:red">Note : Anda terdaftar sebagai Administrator Anggota.</span></td></tr>
									</table>Lakukan Perubahan Password segera. Terima kasih.';

							if($conn->main->send_mail($arrAnggota["EMAIL_USER"],'', 'Konfirmasi Registrasi PLBInventory', $isi,'')){
						}
							$ret = "MSG#OK#Register Anggota Berhasil. Terimakasih.#".site_url()."/master/daftar/anggota#";
						}else{					
							$ret = "MSG#ERR#Register perusahaan Gagal#";
						}	 
					}else{
						$ret = "MSG#ERR#Password tidak sama.";
					}				
				}
				echo $ret; die();	
            } elseif ($act == "update") {
				$KODE_TRADER = $this->input->post('KODE_TRADER');
				if(!valid_email($arrAnggota["EMAIL_USER"])){
					echo "MSG#ERR#Email tidak valid, periksa kembali email anda.";		
					die();
				}
				$NPWP = str_replace(".","",str_replace("-","",$arrAnggota["ID"]));
				$arrAnggota["ID"]=$NPWP;
				$KODE_TRADER = $this->input->post('KODE_TRADER');
				$this->db->where('KODE_TRADER',$KODE_TRADER);			
				$exec = $this->db->update('m_trader_temp', $arrAnggota);
				if ($exec) {
					$conn->main->activity_log('UPDATE TRADER', '');
					echo "MSG#OK#Simpan data Berhasil#" .site_url()."/master/daftar/anggota#";
				} else {
						echo "MSG#ERR#Simpan data Gagal#";
				}				
            } else {
				$ret = "MSG#ERR#Hapus Gagal#";	
				foreach($this->input->post("tb_chkfanggota") as $chk){					
						$this->db->where(array('KODE_TRADER'=>$chk));	
						$this->db->delete('M_TRADER_TEMP');		
                        $this->db->where(array('KODE_TRADER'=>$chk));   
                        $this->db->delete('M_TRADER');			
						$conn->main->activity_log('DELETE DATA TRADER','KODE_TRADER = '.$chk);
						$ret = "MSG#OK#Hapus Data Anggota Berhasil#". site_url()."/master/daftar/anggota";	
				}
				echo $ret;
			}
		}
    }
	
	function prosesmenu($id=""){			
		$func = get_instance();
		$func->load->model("main");
		if($id) $and = "AND a.USER_ID='".$id."'";
		$SQL = "SELECT a.USER_ID,b.KODE_ROLE 
				FROM t_user a, t_user_role b WHERE a.USER_ID=b.USER_ID ".$and;
		if($func->main->get_result($SQL)){
			foreach ($SQL->result_array() as $row){
				$data = array(
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'1',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'2',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'3',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'4',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'5',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'6',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'7',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'8',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'9',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'10',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'11',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'12',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'13',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'14',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'15',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'16',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'17',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'18',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'19',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'20',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'21',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'22',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'23',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'24',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'25',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'26',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'27',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'28',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'29',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'30',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'31',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'32',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'33',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'34',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'36',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'37',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'38',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'39',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'40',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'41',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'42',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'43',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'44',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'45',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'46',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'47',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'48',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'49',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'50',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'51',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'52',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'53',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'54',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'55',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'56',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'57',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'58',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'59',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'60',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'61',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'64',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'65',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'66',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
						);
				
				for($a=0;$a<count($data);$a++){
					$exec = $this->db->insert('m_menu_user',$data[$a]);
				}
				
			}
			if($exec){
				echo "proses berhasil";	
			}else{
				echo "proses gagal";	
			}
		}				
	}
    
    function send_mail($to, $nama, $subject, $isi, $flag){
    	$this->load->library("phpmailer");
    	$mailconfig = $this->config->config;
    	$mailconfig = $mailconfig['mail_config'];
    	$this->phpmailer->Config($mailconfig);
    	$this->phpmailer->Subject = $subject;
    		//$path = "D:\Web\aikbci\\uploads\\Formulir Belangganan Jasa EDI e-INKABER.xls";
    	if($flag!='weare'){
    		$path = "/home/inguber/file/Formulir Belangganan Jasa EDI GBInventory.xls";
    		$this->phpmailer->AddAttachment($path, 'Formulir Belangganan Jasa EDI GBInventory.xls');
    	}
    	$email = explode(";", $to);
    	foreach($email as $a){
    		$this->phpmailer->AddAddress($a, '');
    	}		
    	$body = '<html><body style="background: #ffffff; color: #000000; font-family: arial; font-size: 13px; margin: 20px; color: #363636;"><table style="margin-bottom: 2px"><tr style="font-size: 13px; color: #0b1d90; font-weight: 700; font-family: arial;"><td width="41" style="margin: 0 0 6px 0px;"><img src="'.base_url().'img/logo.png" style="vertical-align: middle;"/></td><td style="font-family: arial; vertical-align: middle; color: #153f6f;">'.$subject.'<br/><span style="color: #858585; font-size: 10px; text-decoration: none;">www.plbnventory.com</span></td></tr></table><div style="border-top: 1px solid #dcdcdc; margin-top: 4px; margin-bottom: 10px; padding: 5px; font-family: Verdana; font-size: 12px;  height:20px;text-align:justify;">'.$isi.'</div><div style="border-top: 1px solid #dcdcdc; clear: both; font-size: 11px; margin-top: 10px; padding-top: 5px;"><div style="font-family: arial; font-size: 10px; color: #a7aaab;">Bonded PLB Inventory Solution</div><a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="http://www.edi-indonesia.co.id/">Website EDII </a> | <a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="'.site_url().'">Website PLB Inventory</a></div></body></html>';
    	$this->phpmailer->Body = $body;
    	return $this->phpmailer->Send();		
    }

    function daftar($tipe = "",$ajax="") {
        $this->load->library('newtable');
        if ($tipe) {
            if ($tipe == "pemasok") {
                $title = "List Data Pemasok dan Pembeli/Penerima";
                $WHERE = " WHERE KODE_TRADER ='" . $this->newsession->userdata('KODE_TRADER') . "' ";
                if ($this->newsession->userdata('KODE_ROLE') != '5') {
                    $prosesnya = array('Tambah'=>array('GET',site_url().'/master/add/pemasok', '0','icon-plus'),
                                   'Ubah'=>array('EDITJS', site_url().'/master/edit/pemasok', '1','icon-edit'),
                                   'Hapus'=>array('DELETE', site_url().'/master/delete/pemasok', 'pemasok','red icon-remove'));
                }
                $SQL = "SELECT KODE_PARTNER AS 'Kode Perusahaan',NAMA_PARTNER AS 'Nama Perusahaan',ALAMAT_PARTNER 
                        AS 'Alamat Perusahaan',
                        f_negara(NEGARA_PARTNER) AS 'Negara',
                        CONCAT(f_ref('TEMPAT',STATUS_PARTNER),' (',STATUS_PARTNER,')') 'Status Perusahaan' , 
                        f_ref('JENIS_PERUSAHAAN',JENIS_PARTNER) 'Jenis Perusahaan' ,
                        KODE_TRADER,KODE_PARTNER,KODE_ID_PARTNER,ID_PARTNER
                        FROM m_trader_partner ";
                $SQL .= $WHERE;
                $this->newtable->search(array(array('KODE_PARTNER', 'Kode Perusahaan'), array('NAMA_PARTNER', 'Nama Perusahaan'),
                    array('ALAMAT_PARTNER', 'Alamat Perusahaan')));
                $this->newtable->action(site_url() . "/master/daftar/pemasok");
                $this->newtable->hiddens(array('KODE_TRADER', 'KODE_PARTNER', 'KODE_ID_PARTNER', 'ID_PARTNER'));
                $this->newtable->keys(array("KODE_PARTNER"));
            } elseif ($tipe == "draftMapping") {
               $WHERE = " WHERE A.KODE_TRADER ='" . $this->newsession->userdata('KODE_TRADER') . "' ";
                if ($this->newsession->userdata('KODE_ROLE') != '5') {
                    $prosesnya = array('Tambah' => array('DIALOG', site_url() . "/master/partner", '0', 'icon-plus'),
                        'Preview' => array('GET2', site_url() . "/master/preview/mapping", '1', 'icon-edit'),
                        'Ubah' => array('GET2', site_url() . "/master/edit/mapping", '1', 'icon-edit'),
                        'Hapus' => array('DELETE', site_url() . '/master/delete/' . $tipe, 'mapping', 'red icon-remove'));
                }
                $title = "List Mapping Kode Barang";
                $SQL = "SELECT DISTINCT A.KODE_PARTNER, A.KODE_PARTNER AS 'Kode Perusahaan', B.NAMA_PARTNER AS 'Nama Perusahaan', 
						(SELECT COUNT(KODE_PARTNER) FROM M_TRADER_MAPPING_BRG C 
						WHERE C.KODE_PARTNER=A.KODE_PARTNER) AS 'Jumlah Mapping Kode Barang'
						FROM M_TRADER_MAPPING_BRG A INNER JOIN m_trader_partner B ON B.KODE_PARTNER=A.KODE_PARTNER ";
                $SQL .= $WHERE;
                $this->newtable->action(site_url() . "/master/daftar/draftMapping/");
                $this->newtable->search(array(array('A.KODE_PARTNER', 'Kode Perusahaan'), array('B.NAMA_PARTNER', 'Nama Perusahaan')));
                $this->newtable->hiddens(array('KODE_PARTNER'));
                $this->newtable->keys("Kode Perusahaan");
            } elseif ($tipe == "gudang") {
                $title = "List Data Gudang";
                $WHERE = " WHERE KODE_TRADER ='" . $this->newsession->userdata('KODE_TRADER') . "' ";
                if ($this->newsession->userdata('KODE_ROLE') != '5') {
                    $prosesnya = array('Tambah'=>array('GET',site_url().'/master/add/gudang', '0','icon-plus'),
                                   'Ubah'=>array('EDITJS', site_url().'/master/edit/gudang', '1','icon-edit'),
                                   'Hapus'=>array('DELETE', site_url().'/master/delete/gudang', 'gudang','red icon-remove'));
                }
                $SQL = "SELECT KODE_TRADER ,KODE_GUDANG AS 'KODE GUDANG', NAMA_GUDANG AS 'NAMA GUDANG', KETERANGAN FROM m_trader_gudang ";
                $SQL .= $WHERE;
                $this->newtable->search(array(array('KODE_GUDANG', 'KODE GUDANG'), array('NAMA_GUDANG', 'Nama GUDANG')));
                $this->newtable->action(site_url() . "/master/daftar/gudang");
                $this->newtable->hiddens(array('KODE_TRADER','KODE_GUDANG'));
                $this->newtable->keys(array("KODE GUDANG"));
            } elseif ($tipe == "rak"){
				$title = "List Data Rak";
				$WHERE = " WHERE KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "' ";
				if($this->newsession->userdata('KODE_ROLE') != '5'){
					$prosesnya = array('Tambah'=>array('GET2',site_url().'/master/add/'.$tipe,'0','icon-plus'),
							'Ubah'=>array('EDITJS',site_url().'/master/edit/'.$tipe,'1','icon-edit'),
							'Hapus'=>array('DELETE',site_url().'/master/delete/'.$tipe,'rak','red icon-remove')
							);
				}
				$SQL = "SELECT KODE_TRADER ,KODE_GUDANG AS 'KODE GUDANG' ,KODE_RAK AS 'KODE RAK' ,NAMA_RAK AS 'NAMA RAK' ,KETERANGAN FROM m_trader_rak";
				$SQL .= $WHERE;
				$this->newtable->search(array(array('KODE_GUDANG', 'KODE GUDANG'),array('KODE_RAK', 'KODE RAK'),array('NAMA_RAK', 'Nama Rak')));
				$this->newtable->action(site_url() . "/master/daftar/rak");
				$this->newtable->hiddens('KODE_TRADER');
				$this->newtable->keys(array("KODE GUDANG","KODE RAK"));
	    	} elseif ($tipe == "sub_rak"){
				$title = "List Data Sub Rak";
				$WHERE = " WHERE KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "' ";
				if($this->newsession->userdata('KODE_ROLE') != '5'){
					$prosesnya = array('Tambah'=>array('GET2',site_url().'/master/add/'.$tipe,'0','icon-plus'),
							'Ubah'=>array('EDITJS',site_url().'/master/edit/'.$tipe,'1','icon-edit'),
							'Hapus'=>array('DELETE',site_url().'/master/delete/'.$tipe,'sub_rak','red icon-remove')
							);
					}
				$SQL = "SELECT KODE_TRADER ,KODE_GUDANG AS 'KODE GUDANG' ,KODE_RAK AS 'KODE RAK' ,KODE_SUB_RAK AS 'KODE SUB RAK' ,NAMA_SUB_RAK AS 'NAMA SUB RAK' ,KETERANGAN FROM m_trader_sub_rak";
				$SQL .= $WHERE;
				$this->newtable->search(array(array('KODE_GUDANG', 'Kode Gudang'),array('KODE_RAK', 'Kode Rak'),array('KODE_SUB_RAK', 'Kode Sub Rak'),array('NAMA_SUB_RAK', 'Nama Sub Rak')));
				$this->newtable->action(site_url() . "/master/daftar/".$tipe);
				$this->newtable->hiddens('KODE_TRADER');
				$this->newtable->keys(array("KODE GUDANG","KODE RAK","KODE SUB RAK"));
			} elseif($tipe == "penyelenggara"){
				$title = "List Data Penyelenggara";
				$SQL = "SELECT KODE_TRADER, NAMA AS 'Nama', f_ref('JENIS_TPB',JENIS_TRADER) AS 'Jenis Trader', ALAMAT AS 'Alamat', TELEPON AS 'Telepon', FAX AS 'Fax', NAMA_PENANGGUNGJAWAB AS 'Penanggung Jawab', STATUS AS 'Status' FROM M_TRADER_TEMP WHERE JENIS_PLB = '00'";
				if($this->newsession->userdata('KODE_ROLE') != '5'){
					$prosesnya = array('Tambah'=>array('GET',site_url().'/master/add/'.$tipe,'0','icon-plus'),
							'Ubah'=>array('EDITJS',site_url().'/master/edit/'.$tipe,'1','icon-edit'),
							'Hapus'=>array('DELETE',site_url().'/master/delete/'.$tipe,'penyelenggara','red icon-remove')
							);
				}
				$this->newtable->search(array(array('KODE_TRADER', 'Kode Trader'),array('NAMA', 'Nama'),array('BIDANG_USAHA', 'Bidang Usaha')));
				$this->newtable->action(site_url() . "/master/daftar/".$tipe);
				$this->newtable->hiddens('KODE_TRADER');
				$this->newtable->keys(array("KODE_TRADER"));	        						
			} elseif($tipe == "anggota"){
				$title = "List Data Anggota";
					$SQL = "SELECT KODE_TRADER, NAMA AS 'Nama Anggota', ALAMAT AS 'Alamat', TELEPON AS 'Telepon', FAX AS 'Fax', 
							BIDANG_USAHA 'Bidang Usaha',NAMA_PENANGGUNGJAWAB AS 'Penanggung Jawab' 
							FROM M_TRADER WHERE JENIS_PLB = '01'";
				if($this->newsession->userdata('KODE_ROLE') != '5'){
					$prosesnya = array('Tambah'=>array('GET',site_url().'/master/add/'.$tipe,'0','icon-plus'),
							'Ubah'=>array('EDITJS',site_url().'/master/edit/'.$tipe,'1','icon-edit'),
							'Hapus'=>array('DELETE',site_url().'/master/delete/'.$tipe,'anggota','red icon-remove')
							);
				}
				$this->newtable->search(array(array('KODE_TRADER', 'Kode Trader'),array('NAMA', 'Nama'),array('BIDANG_USAHA', 'Bidang Usaha')));
				$this->newtable->action(site_url() . "/master/daftar/".$tipe);
				$this->newtable->hiddens('KODE_TRADER');
				$this->newtable->keys(array("KODE_TRADER"));	        						
			}           
	    	$ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(2);
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("f" . $tipe);
            $this->newtable->set_divid("div" . $tipe);
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array("title" => $title,
                "tabel" => $tabel,
                "jenis" => $jenis,
                "tipe" => $tipe);
            if ($this->input->post("ajax")||$ajax=="ajax")
                return $tabel;
            else
                return $arrdata;
        }else {
            redirect(base_url());
            exit();
        }
    }

    function getData($tipe, $id,  $id2="" , $id3="") {
        $conn = get_instance();
        $conn->load->model("main");
        $idTrader = $this->newsession->userdata("KODE_TRADER");
        if ($tipe == "pemasok") {
            $query = "SELECT *, f_negara(NEGARA_PARTNER) AS 'URAIAN_BENDERA'
					  FROM m_trader_partner					  
					  WHERE KODE_PARTNER='" . $id . "'  AND KODE_TRADER='" . $idTrader . "'";
        } elseif ($tipe == "mapping") {
            $query = "SELECT IDMAPPING, KODE_PARTNER, NAMA_PARTNER
					  FROM M_TRADER_MAPPING_BRG
					  WHERE IDMAPPING=" . $id . "  AND KODE_TRADER='" . $idTrader . "'";
        } elseif ($tipe == "mappingPOPN") {
            $query = "SELECT IDMAPPING, KODE_PARTNER, NAMA_PARTNER
					  FROM M_TRADER_MAPPING_BRG
					  WHERE IDMAPPING=" . $id . "  AND KODE_TRADER='" . $idTrader . "'";
        } elseif ($tipe == "mappingPOPget") {
            $query = "SELECT A.KODE_BARANG, A.JNS_BARANG, A.KODE_BARANG_PARTNER, B.URAIAN_BARANG, B.MERK, 
					 f_ref('ASAL_JENIS_BARANG', B.JNS_BARANG) AS 'JENIS_BARANG' FROM m_trader_mapping_brg A 
					 LEFT JOIN m_trader_barang B ON A.KODE_BARANG=B.KODE_BARANG
					 WHERE A.IDMAPPING='" . $id . "'";
        } elseif($tipe == "gudang"){
            $query = "SELECT KODE_GUDANG, NAMA_GUDANG, KETERANGAN
					  FROM m_trader_gudang
					  WHERE KODE_GUDANG = '".$id."'  AND KODE_TRADER = '".$idTrader."'";
        } elseif($tipe == "rak"){
            $query = "SELECT KODE_GUDANG, KODE_RAK ,NAMA_RAK, KETERANGAN
					  FROM m_trader_rak
					  WHERE KODE_GUDANG = '".$id."'  AND KODE_TRADER = '".$idTrader."' AND KODE_RAK='".$id2."'";
        } elseif($tipe == "sub_rak"){
            $query = "SELECT KODE_GUDANG, KODE_RAK , KODE_SUB_RAK , NAMA_SUB_RAK, KETERANGAN
					  FROM m_trader_sub_rak
					  WHERE KODE_GUDANG = '".$id."'  AND KODE_TRADER = '".$idTrader."' AND KODE_RAK='".$id2."' AND KODE_SUB_RAK = '".$id3."'";
        } elseif($tipe == "penyelenggara"){
            $query = "SELECT KODE_TRADER, JENIS_PLB, INDUK_PLB, KODE_ID, ID, NAMA, ALAMAT,TELEPON, FAX, STATUS_TRADER, BIDANG_USAHA, JENIS_TRADER, JENIS_BARANG_TIMBUN,TUJUAN_DISTRIBUSI, LOKASI_GB, DESA_KEL_GB, KECAMATAN_GB, KOTA_GB, PROPINSI_GB, NIPER, LUAS_LOKASI_GB, BATAS_BARAT_GB, BATAS_TIMUR_GB, BATAS_UTARA_GB, BATAS_SELATAN_GB, LUAS_LOKASI_PDGB, BATAS_BARAT_PDGB, BATAS_TIMUR_PDGB, BATAS_UTARA_PDGB, BATAS_SELATAN_PDGB, KODE_API, NOMOR_API, NOMOR_SRP, NAMA_PENANGGUNGJAWAB, ALAMAT_PENANGGUNGJAWAB, STATUS, USERNAME, PASSWORD, PASS, NAMA_USER, ALAMAT_USER, TELEPON_USER, JABATAN_USER, EMAIL_USER, KODE_SKEP, NOMOR_SKEP,TANGGAL_SKEP, NO_REGISTRASI , f_ref('FAS_SKEMA',KODE_SKEP) AS 'NAMA_SKEP' FROM M_TRADER_TEMP WHERE KODE_TRADER = '".$id."' AND JENIS_PLB='00'";
        } elseif($tipe == "anggota"){
            $query = "SELECT KODE_TRADER, JENIS_PLB, INDUK_PLB, KODE_ID, ID, NAMA, ALAMAT,TELEPON, FAX, STATUS_TRADER, BIDANG_USAHA, 
						JENIS_TRADER, JENIS_BARANG_TIMBUN,TUJUAN_DISTRIBUSI, LOKASI_GB, DESA_KEL_GB, KECAMATAN_GB, KOTA_GB, 
						PROPINSI_GB, NIPER, LUAS_LOKASI_GB, BATAS_BARAT_GB, BATAS_TIMUR_GB, BATAS_UTARA_GB, BATAS_SELATAN_GB, LUAS_LOKASI_PDGB, 
						BATAS_BARAT_PDGB, BATAS_TIMUR_PDGB, BATAS_UTARA_PDGB, BATAS_SELATAN_PDGB, KODE_API, NOMOR_API, NOMOR_SRP, 
						NAMA_PENANGGUNGJAWAB, ALAMAT_PENANGGUNGJAWAB, STATUS
					FROM M_TRADER WHERE KODE_TRADER = '".$id."' AND JENIS_PLB='01'";
        }
        $hasil = $conn->main->get_result($query);
        if ($hasil) {
            foreach ($query->result_array() as $row) {
                $dataarray = $row;
            }
        }
        return $dataarray;
    }

    #untuk set nomer aju
    function setnomor() {
        $func = & get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        foreach ($this->input->post('DATA') as $a => $b) {
            $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'DOKNAME' => $a));
            $exec = $this->db->update('m_trader_no_urut', $b);
            $log = $log . $a . '=' . $b . ', ';
        }
        if ($exec) {
            $func->main->activity_log('SET NOMOR AJU', $log);
            echo "MSG#OK#Setting berhasil";
            die();
        } else {
            echo "MSG#ERR#Setting Gagal";
            die();
        }
    }
    #end

    #untuk list pop up
    function listdatapopup($tipe = "", $ajax="") {
        $this->load->library('newtable');
        if ($tipe == "skep") {
            $judul = "Daftar Data SKEP";
            $SQL = "SELECT KODE_SKEP 'Kode SKEP', NOMOR_SKEP 'Nomor SKEP', DATE_FORMAT(TANGGAL_SKEP, '%d %M %Y %H:%m:%s') 'Tanggal SKEP', 
					KODE_TRADER, SERI FROM m_trader_skep 
					WHERE KODE_TRADER = '" . $this->newsession->userdata('KODE_TRADER') . "'";
            $this->newtable->search(array(array('KODE_SKEP', 'KODE SKEP'), array('NOMOR_SKEP', 'NOMOR SKEP')));
            $this->newtable->orderby(5);
        }
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->action(site_url() . "/master/listdatapopup/" . $tipe);
        $this->newtable->keys(array("KODE_TRADER", "SERI"));
        $this->newtable->hiddens(array("KODE_TRADER", "SERI"));
        $this->newtable->show_chk(true);
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->sortby("DESC");
        $this->newtable->tipe_proses('button');
        $this->newtable->set_formid("f" . $tipe);
        $this->newtable->set_divid("div" . $tipe);
        $this->newtable->rowcount(5);
        $this->newtable->clear();
        $process = array('Tambah' => array('ADD', site_url() . '/master/listdatapopup/' . $tipe, '0', 'icon-plus'),
            'Ubah' => array('EDIT', site_url() . '/master/listdatapopup/' . $tipe, 'N', 'icon-edit'),
            'Hapus' => array('DELETE', site_url() . '/master/listdatapopup/' . $tipe, 'skep', 'red icon-remove'));
        $this->newtable->menu($process);
        $generate = $this->newtable->generate($SQL);
        $tabel .= '<span id="f' . $tipe . '_form"></span>';
        $tabel .= '<div class="header">';
        $tabel .= '<h4><span class="info_2">&nbsp;</span>' . $judul . '</h4><hr />';
		$tabel .= '</div">';
		$tabel .= '<div class="content">';
        $tabel .= $generate;
        $tabel .= '</div>';
        $arrdata = array("tabel" => $tabel);
        if ($this->input->post("ajax") || $ajax=="ajax")
            return $generate;
        else
            return $arrdata;
    	}
    function get_datapopup($tipe = "", $seri = "") {
        $data = array();
        $conn = get_instance();
        $conn->load->model("main");
        if ($seri!="") {
            if ($tipe == "skep") {
                $query = "SELECT KODE_TRADER, SERI, KODE_SKEP, NOMOR_SKEP, TANGGAL_SKEP FROM m_trader_skep 
						  WHERE KODE_TRADER = '" . $this->newsession->userdata('KODE_TRADER') . "' AND SERI ='" . $seri . "'";
                $hasil = $conn->main->get_result($query);
                if ($hasil) {
                    foreach ($query->result_array() as $row) {
                        $data = array('act' => 'update', 'skep' => $row, 'seri' => $seri);
                    }
                }
            }
        } else {
            $data = array('act' => 'save');
        }
        $data = array_merge($data, array('KODE_SKEP' => $conn->main->get_mtabel('JENIS_SKEP')));
        return $data;
    	}

    function set_datapopup($tipe = "", $act = "") {
        if ($act == "save" || $act == "update") {
            $func = & get_instance();
            $func->load->model("main", "main", true);
            foreach ($this->input->post($tipe) as $a => $b) {
                $value[$a] = $b;
            }
            if ($act == "save") {
                if ($tipe == "skep") {
                    $SQL = "SELECT MAX(SERI) AS MAXSERI FROM m_trader_skep 
							WHERE KODE_TRADER = '" . $this->newsession->userdata('KODE_TRADER') . "'";
                    $seri = (int) $func->main->get_uraian($SQL, "MAXSERI") + 1;
                    $value["KODE_TRADER"] = $this->newsession->userdata('KODE_TRADER');
                    $value["SERI"] = $seri;
                    $exec = $this->db->insert('m_trader_skep', $value);
                }
                if ($exec) {
                    echo "MSG#OK#Simpan data Berhasil#". site_url() . "/master/listdatapopup/" . $tipe."/ajax";
                } else {
                    echo "MSG#ERR#Simpan data Gagal#";
                }
            } else {
                $SERI = $this->input->post('seri');
                $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
                $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'SERI' => $SERI));
                if ($tipe == "skep")
                    $exec = $this->db->update('m_trader_skep', $value);
                else
                    $exec = $this->db->update('m_trader_hproduksi', $value);
                if ($exec) {
                    echo "MSG#OK#Update data Berhasil#";
                } else {
                    echo "MSG#ERR#Update data Gagal#";
                }
            }
        } else if ($act == "delete") {
            $checkbox = $this->input->post('tb_chkf' . $tipe);
            foreach ($checkbox as $chkitem) {
                $arrchk = explode("|", $chkitem);
				
                $KODE_TRADER = $arrchk[0];
                $SERI = $arrchk[1];		
				
                $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'SERI' => $SERI));
                if ($tipe == "skep")
                    $exec = $this->db->delete('m_trader_skep');
                else
                    $exec = $this->db->delete('m_trader_hproduksi');
            }
            if ($exec) {
                echo "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/listdatapopup/" . $tipe . "/ajax";
            } else {
                echo "MSG#ERR#Hapus data Gagal#";
            }
        }
    }    
    #end pop up
    
    #detil untuk mapping
    function detil($type = "", $id = "", $act = "") {
        $this->load->library('newtable');
        if ($type == "mapping") {
            $judul = "Daftar Kode Barang";
            $SQL = "SELECT A.KODE_BARANG_PARTNER AS 'Kode Barang Pemasok', 
					A.KODE_BARANG AS 'Kode Barang Internal', B.URAIAN_BARANG AS 'Uraian Barang', 
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) AS 'Jenis Barang',
					A.IDMAPPING, A.KODE_PARTNER, A.KODE_BARANG_PARTNER, A.KODE_TRADER 
					FROM m_trader_mapping_brg A, m_trader_barang B 
					WHERE A.KODE_BARANG=B.KODE_BARANG AND A.JNS_BARANG=B.JNS_BARANG
					AND A.KODE_TRADER=B.KODE_TRADER
					AND A.KODE_TRADER ='" . $this->newsession->userdata('KODE_TRADER') . "' AND A.KODE_PARTNER='" . $id . "' ";
            if ($act != "preview") {
                $process = array('Tambah' => array('DIALOG', site_url() . "/master/add/mappingPOPN/". $id, '0', 'icon-plus'),
                    'Ubah' => array('GET2POP', site_url() . "/master/edit/mappingPOPN", '1', 'icon-edit'),
                    'Hapus' => array('DELETE', site_url() . '/master/delete/mapping', 'mapping', 'icon-remove'));
                $this->newtable->action(site_url() . "/master/mapping_dok/mapping/" . $id);
            } else {
                $process = "";
                $this->newtable->action(site_url() . "/master/mapping_dok/mapping/" . $id . "/preview");
            }
            $this->newtable->search(array(array('A.KODE_BARANG_PARTNER', 'Kode Barang Pemasok'),
                array('A.KODE_BARANG', 'Kode Barang Internal'), array('B.URAIAN_BARANG', 'Uraian Barang')));
            $this->newtable->keys(array('IDMAPPING', 'KODE_PARTNER'));
            $this->newtable->hiddens(array('KODE_TRADER', 'KODE_PARTNER', 'IDMAPPING', 'KODE_BARANG_PARTNER'));
        }

        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("f" . $type);
        $this->newtable->set_divid("div" . $type);
        $this->newtable->tipe_proses('button');
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby(1);
        $this->newtable->sortby("ASC");
        $this->newtable->clear();
        $this->newtable->rowcount(10);
        $this->newtable->menu($process);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("judul" => $judul,
            "tabel" => $tabel);
        if ($this->input->post("ajax") || $act == "delete")
            return $tabel;
        else
            return $arrdata;
    }
    #end detil

    #untuk lihat profil
	function get_profil($aksi = "") {
        $conn = & get_instance();
        $conn->load->model("main", "main", true);
        $kodeTrader = $this->newsession->userdata("KODE_TRADER");
        $query = "SELECT *, f_ref('KODE_ID',KODE_ID) AS URAI_ID, f_ref('API',KODE_API) AS URAI_API
					  FROM M_TRADER WHERE KODE_TRADER='" . $kodeTrader . "'";
        $hasil = $conn->main->get_result($query);
        if ($hasil) {
            foreach ($query->result_array() as $row) {
                $dataarray = $row;
            }
        }
        $this->db->where('KODE_TRADER', $this->newsession->userdata('KODE_TRADER'));
        $this->db->select_max('TANGGAL_SKEP');
        $resultSkep = $this->db->get('m_trader_skep')->row();
        $maxTglSkep = $resultSkep->TANGGAL_SKEP; //exit;
        $SQL = "SELECT KODE_SKEP, NOMOR_SKEP, TANGGAL_SKEP, KODE_TRADER, SERI 
					FROM m_trader_skep WHERE KODE_TRADER = '" . $this->newsession->userdata('KODE_TRADER') . "' AND TANGGAL_SKEP='" . $maxTglSkep . "'"; //echo $SQL;exit;
        $hasil = $conn->main->get_result($SQL);
        if ($hasil) {
            foreach ($SQL->result_array() as $row) {
                $SKEP = $row;
            }
        }
        if ($aksi == "view") {
            $act = "Ubah";
        } elseif ($aksi == "edit") {
            $act = "Simpan";
        }
        $arrdata = array('act' => $act,
            'sess' => $dataarray,
            'SKEP' => $SKEP,
            'kode_id_trader' => $conn->main->get_mtabel('KODE_ID'),
            'kode_api_trader' => $conn->main->get_mtabel('API'),
            'JENIS_TPB' => $conn->main->get_mtabel('JENIS_TPB'),
            'TIPE_TRADER' => $conn->main->get_mtabel('JENIS_EKSPORTIR'));
        return $arrdata;
    }
    #end profil
    
    #untuk mapping
	function cekpartner() {
        foreach ($this->input->post('DATA') as $a => $b) {
            $DATA[$a] = $b;
        }
        $rs = $this->db->query("SELECT KODE_PARTNER FROM m_trader_mapping_brg WHERE KODE_PARTNER='" . $DATA["KODE_PARTNER"] . "'");
        if ($rs->num_rows() > 0) {
            echo "MSG#ERR#<br>Perusahaan :" . $DATA["NAMA_PARTNER"] . " dengan Kode Perusahaan " . $DATA["KODE_PARTNER"] . " Sudah pernah dipakai#".site_url() . "/master/daftar/draftMapping#";
        } else {
            echo "MSG#OK#Proses Berhasil#" . site_url() . "/master/add/mapping/" . $DATA["KODE_PARTNER"] . "/" . $DATA["NAMA_PARTNER"] . "#";
        }
    }
    #end mapping
}

?>