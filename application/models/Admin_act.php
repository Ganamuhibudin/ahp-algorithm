<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_act extends CI_Model{	
	
	function trader($type="",$ajax=""){
		$func = get_instance();
		$func->load->model("main");
		$this->load->library('newtable');					
		if($type=="baru"){
			$judul = "Daftar Perusahaan Baru";
			$SQL = "SELECT KODE_TRADER, ID, CONCAT('&nbsp;',f_ref('KODE_ID',KODE_ID),'<br>',ID) 'Identitas', NAMA 'Nama Perusahaan', 
					ALAMAT 'Alamat Perusahaan', CREATED_TIME 'Tanggal Registrasi' FROM m_trader_temp WHERE STATUS='0'";
			$prosesnya = array( 'Preview' => array('GET2', site_url()."/admin/trader/priview/".$type, '1','icon-eye-open'),	
						        'Approve' => array('PROCESS', site_url().'/admin/settrader/'.$type.'/approve', '1','icon-ok'),
							 	'Reject' => array('PROCESS', site_url().'/admin/settrader/'.$type.'/reject', '1','icon-undo'),
								'Hapus' => array('DELETE', site_url().'/admin/settrader/'.$type.'/delete', 'admin','red icon-remove'));		
		}
		else if($type=="reject"){
			$judul = "Daftar Perusahaan Reject";
			$SQL = "SELECT KODE_TRADER, ID, CONCAT('&nbsp;',f_ref('KODE_ID',KODE_ID),'<br>',ID) 'Identitas', NAMA 'Nama Perusahaan', 
					ALAMAT 'Alamat Perusahaan', CREATED_TIME 'Tanggal Registrasi' FROM m_trader_temp WHERE STATUS='2'";
			$prosesnya = array( 'Preview' => array('GET2', site_url()."/admin/trader/priview/".$type, '1','icon-eye-open'),	
			                    'Approve' => array('PROCESS', site_url().'/admin/settrader/'.$type.'/approve', '1','icon-ok'),
								'Hapus' => array('DELETE', site_url().'/admin/settrader/'.$type.'/delete', 'admin','red icon-remove'));		
		}
		else if($type=="lama"){
			$judul = "Daftar Perusahaan Disetujui";
			$SQL = "SELECT KODE_TRADER, ID, CONCAT('&nbsp;',f_ref('KODE_ID',KODE_ID),'<br>',ID) 'Identitas', NAMA 'Nama Perusahaan', 
					ALAMAT 'Alamat Perusahaan', CREATED_TIME 'Tanggal Disetujui', 
					CASE
						WHEN STATUS = '1' THEN 'AKTIF'
						WHEN STATUS = '0' THEN 'NON AKTIF'
					END AS STATUS FROM m_trader";
			$prosesnya = array( 'Preview' => array('GET2', site_url()."/admin/trader/priview/".$type, '1','icon-eye-open'),	
								'Reject' => array('PROCESS', site_url().'/admin/settrader/'.$type.'/reject', '1','icon-undo'),
								'Hapus' => array('DELETE', site_url().'/admin/settrader/'.$type.'/delete', 'admin','red icon-remove'),
								'Non-Aktif'=>array('PROCESS',site_url().'/admin/settrader/'.$type.'/nonactive','1','icon-remove'),
								'Aktif'=>array('PROCESS',site_url().'/admin/settrader/'.$type.'/active','1','icon-ok'));		
		}		
			
		$this->newtable->search(array(array('ID', 'Nomor Identitas&nbsp;&nbsp;'),
									  array('NAMA', 'Nama Perusahaan&nbsp;&nbsp;'),
									  array('CREATED_TIME', 'Tanggal Registrasi', 'tag-tanggal')
									  ));		
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
		$this->newtable->action(site_url()."/admin/trader/".$type);
		$this->newtable->hiddens(array("KODE_TRADER","ID"));	
		$this->newtable->detail(site_url()."/admin/trader/priview/".$type);	
		$this->newtable->detail_tipe("detil_priview_blank");	
		$this->newtable->keys(array("KODE_TRADER"));
		$this->newtable->tipe_proses('button');
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("ftrader");
		$this->newtable->set_divid("divtrader");
		$this->newtable->rowcount(20);
		$this->newtable->clear(); 
		$this->newtable->menu($prosesnya);
		$tabel = $this->newtable->generate($SQL);			
		$arrdata = array("title" => $judul,
						 "tabel" => $tabel);
		if($this->input->post("ajax")||$ajax) return $tabel;				 
		else return $arrdata;		
	}
	
	function settrader($type="",$act=""){			
		$func =& get_instance();
		$config = $this->config->config;
		$func->load->model("main", "main", true);
		
		if(strtolower($act)=="approve"){
			foreach($this->input->post('tb_chkftrader') as $chkitem){
				$KDTRADER = $chkitem;
			}
			$SQL = "SELECT * FROM m_trader_temp WHERE KODE_TRADER='".$KDTRADER."'";
			$hasil = $func->main->get_result($SQL);
			if($hasil){
				foreach($SQL->result_array() as $row){
					$trader = $row;
					$user = $row;
					$skep = $row;
				}
					unset($trader["USERNAME"]);
					unset($trader["PASSWORD"]);
					unset($trader["NAMA_USER"]);
					unset($trader["ALAMAT_USER"]);
					unset($trader["TELEPON_USER"]);
					unset($trader["JABATAN_USER"]);
					unset($trader["EMAIL_USER"]);  
					unset($trader["KODE_SKEP"]);
					unset($trader["NOMOR_SKEP"]);
					unset($trader["TANGGAL_SKEP"]);
					unset($trader["STATUS"]);     
					unset($trader["PASS"]); 
					unset($trader["NO_REGISTRASI"]);     
					$trader["CREATED_TIME"] = date('Y-m-d H:i:s');
					$trader["STATUS"]='1';
					$exec = $this->db->insert('m_trader', $trader);
					if($exec){
						$datauser["USER_ID"] = (int)$func->main->get_uraian("SELECT MAX(USER_ID) AS MAXSERI FROM T_USER", "MAXSERI") + 1;
						$datauser["KODE_TRADER"]=$KDTRADER;
						$datauser["USERNAME"]=$user["USERNAME"];
						$datauser["PASSWORD"]=$user["PASSWORD"];
						$datauser["NAMA"]=$user["NAMA_USER"];
						$datauser["ALAMAT"]=$user["ALAMAT_USER"];
						$datauser["TELEPON"]=$user["TELEPON_USER"];
						$datauser["JABATAN"]=$user["JABATAN_USER"];
						$datauser["EMAIL"]=$user["EMAIL_USER"];
						$datauser["STATUS"]='1';
						
						#JUST 4 DEV
						date_default_timezone_set('Asia/Jakarta');
						//$expired = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 30, date('Y')));
						//$datauser["EXPIRED_DATE"] = $expired;
						
						$dataskep["KODE_TRADER"]=$KDTRADER;
						$dataskep["KODE_SKEP"]=$skep["KODE_SKEP"];
						$dataskep["NOMOR_SKEP"]=$skep["NOMOR_SKEP"];
						$dataskep["TANGGAL_SKEP"]=$skep["TANGGAL_SKEP"];
						$dataskep["SERI"]='1';
						
						$this->db->insert('m_setting', array('KODE_TRADER'=>$KDTRADER,'LAST_AJU'=>1,'LAST_PROSES'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC16','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC281','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC27','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC40','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC24','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC30','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC282','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC28','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC41','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'BC20','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'SRR','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'PPB','NO_URUT'=>1));
						$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$KDTRADER,'DOKNAME'=>'PPK','NO_URUT'=>1));

						$this->db->insert('t_user', $datauser);
						$this->db->insert('t_user_role', array("USER_ID"=>$datauser["USER_ID"],"KODE_ROLE"=>"3"));
						$this->db->insert('m_trader_skep', $dataskep);
						$this->db->where(array('KODE_TRADER' => $KDTRADER));
						$exec = $this->db->update('m_trader_temp', array("STATUS"=>"1"));
						
						$this->prosesmenu($datauser["USER_ID"]);
						$isi = 'Selamat '.$trader["NAMA"].' , Anda telah terdaftar di '.base_url().'.<br />Berikut Akun silahkan login dengan:<table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">Username</td><td>: <b>'.$datauser["USERNAME"].'</b></td></tr><tr><td>Password</td><td>: <b>'.$user["PASS"].'</b></td></tr></table>lakukan Perubahan Password segera. Terima kasih.';
						$to = $datauser["EMAIL"];
						$func->main->send_mail($to,'', 'Akses Login PLB Inventory', $isi);
																			
						if($exec){
							echo "MSG#OK#Approve data Berhasil#".site_url()."/admin/trader/".$type."/ajax#";
						}else{					
							echo "MSG#ERR#Approve data Gagal#";
						}
					}
			}
		}
		else if(strtolower($act)=="reject"){
			foreach($this->input->post('tb_chkftrader') as $chkitem){
				$KDTRADER = $chkitem;
			}
			$SQL = "SELECT * FROM m_trader_temp WHERE KODE_TRADER='".$KDTRADER."'";
			$hasil = $func->main->get_result($SQL);
			if($hasil){
				foreach($SQL->result_array() as $row){
					$trader = $row;
				}
			}
			
			$SQL = "SELECT * FROM m_trader WHERE KODE_TRADER='".$KDTRADER."'";
			$hasil = $func->main->get_result($SQL);
			if($hasil){
				$this->db->where(array('KODE_TRADER' => $KDTRADER));
				$this->db->delete("m_trader");	
				$this->db->where(array('KODE_TRADER' => $KDTRADER));
				$this->db->delete("m_trader_skep");			
				$SQL = "SELECT USER_ID FROM t_user WHERE KODE_TRADER='".$KDTRADER."'";
				$hasil = $func->main->get_result($SQL);
				if($hasil){
					foreach($SQL->result_array() as $row){	
						$this->db->where($row);
						$this->db->delete("t_user_role");
					}
				}						
				$this->db->where(array('KODE_TRADER' => $KDTRADER));
				$this->db->delete("t_user");		
			}						
			
			
			$this->db->where(array('KODE_TRADER' => $KDTRADER));
			$exec = $this->db->update('m_trader_temp', array("STATUS"=>"2"));
			$isi = '<table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td colspan="2">Registrasi anda dengan data sebagai berikut :</td></tr><tr><td width="65">Nama Perusahaan</td><td>: <b>'.$trader["NAMA"].'</b></td></tr><tr><td>No. Identitas</td><td>: <b>'.$trader["ID"].'</b></td></tr><tr><td colspan="2"><b>Telah ditolak, Mohon hubungi administrator kami.</b></td></tr></table>';
			$func->main->send_mail($trader["EMAIL_USER"],$trader["NAMA"], 'Registrasi GBInventory', $isi);
			/*$SESEMAIL = $this->newsession->userdata("EMAIL");
			$SENAMA = $this->newsession->userdata("NAMA");
			$func->main->send_mail($SESEMAIL,$SENAMA, 'Akses Login GBInventory', $isi);*/
			if($exec){
				echo "MSG#OK#Reject data Berhasil#".site_url()."/admin/trader/".$type."/ajax#";
			}else{					
				echo "MSG#ERR#Reject data Gagal#";
			}
		}
		else if(strtolower($act)=="delete"){
			if($type=="lama") $tabel = "m_trader";
			else $tabel = "m_trader_temp";
			foreach($this->input->post('tb_chkftrader') as $chkitem){
				$this->db->where(array('KODE_TRADER' => $chkitem));
				$exec = $this->db->delete($tabel);	
				if($type=="lama"){
					$this->db->where(array('KODE_TRADER' => $chkitem));
					$this->db->delete("m_trader_skep");			
					$this->db->where(array('KODE_TRADER' => $chkitem));
					$this->db->delete("m_setting");
					$this->db->where(array('KODE_TRADER' => $chkitem));
					$this->db->delete("m_trader_no_urut");	

					$SQL = "SELECT USER_ID FROM t_user WHERE KODE_TRADER='".$chkitem."'";
					$hasil = $func->main->get_result($SQL);
					if($hasil){
						foreach($SQL->result_array() as $row){	
							$this->db->where($row);
							$this->db->delete("t_user_role");
							$this->db->where($row);
							$this->db->delete("m_menu_user");
						}
					}						
					$this->db->where(array('KODE_TRADER' => $chkitem));
					$this->db->delete("t_user");		
					$this->db->where(array('KODE_TRADER' => $chkitem));
					$this->db->update('m_trader_temp', array("STATUS"=>"0","CREATED_TIME" => date('Y-m-d H:i:s')));
					
				} 
			}
			if($exec){
				echo "MSG#OK#Hapus data Berhasil#".site_url()."/admin/trader/".$type."/ajax#";
			}else{					
				echo "MSG#ERR#Hapus data Gagal#";
			}
		}
		else if(strtolower($act)=="nonactive"){
			if($type=="lama") $tabel = "m_trader";
			else $tabel = "m_trader_temp";
			foreach($this->input->post('tb_chkftrader') as $chkitem){
				$this->db->where(array("KODE_TRADER"=>$chkitem));
				$this->db->update($tabel,array("STATUS"=>"0"));
				$this->db->where(array("KODE_TRADER"=>$chkitem));
				$exec = $this->db->update("t_user",array("STATUS"=>"0"));
			}
			if($exec){
				echo "MSG#OK#Nonaktif Perusahaan Berhasil#".site_url()."/admin/trader/".$type."/ajax#";
			}else{					
				echo "MSG#ERR#Nonaktif Perusahaan Gagal#";
			}
		}
		else if(strtolower($act)=="active"){
			if($type=="lama") $tabel = "m_trader";
			else $tabel = "m_trader_temp";
			foreach($this->input->post('tb_chkftrader') as $chkitem){
				$this->db->where(array("KODE_TRADER"=>$chkitem));
				$this->db->update($tabel,array("STATUS"=>"1"));
				$this->db->where(array("KODE_TRADER"=>$chkitem));
				$exec = $this->db->update("t_user",array("STATUS"=>"1"));
			}
			if($exec){
				echo "MSG#OK#Nonaktif Perusahaan Berhasil#".site_url()."/admin/trader/".$type."/ajax#";
			}else{					
				echo "MSG#ERR#Nonaktif Perusahaan Gagal#";
			}
		}
	}
	
	function user($ajax=""){
		$func = get_instance();
		$func->load->model("main");
		$this->load->library('newtable');	
		$judul = "Daftar User Aplikasi";
		$SQL = "SELECT A.USERNAME 'Username', A.NAMA 'Nama lengkap', B.ID 'NOMOR NPWP', B.NAMA 'Nama Perusahaan', 
				CONCAT(D.KODE_ROLE,' - ',D.NAMA) 'Group User',
				IF(a.STATUS=0,'Tidak Aktif','Aktif') 'Status', A.USER_ID FROM T_USER A, M_TRADER B, T_USER_ROLE C, M_ROLE D 
				WHERE A.KODE_TRADER=B.KODE_TRADER AND A.USER_ID=C.USER_ID AND C.KODE_ROLE=D.KODE_ROLE";
				
		$prosesnya = array( 'Tambah' => array('GET2', site_url().'/admin/form/add', '0','icon-plus'),
							'Ubah' => array('EDITJS', site_url()."/admin/form/edit", '1','icon-edit'),
							'Aktif' => array('PROCESS', site_url().'/admin/setuser/aktif', '1','icon-ok'),
							'Non-Aktif' => array('PROCESS', site_url().'/admin/setuser/nonaktif', '1','red icon-remove'),
							'Hapus' => array('DELETE', site_url().'/admin/setuser/delete', 'admin','red icon-remove'),
							'Reset Password' => array('PROCESS', site_url().'/admin/setuser/reset', '1','icon-undo'));	
			
		$this->newtable->search(array(array('A.USERNAME', 'Username&nbsp;&nbsp;'),
									  array('A.NAMA', 'Nama Lengkap'),
									  array('B.NAMA', 'Nama Perusahaan'),
									  array('A.STATUS', 'Status', 'tag-select',array("1"=>"Aktif","0"=>"Tidak Aktif"))
									  ));		
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
		$this->newtable->action(site_url()."/admin/user/");
		$this->newtable->hiddens(array("USER_ID"));			
		$this->newtable->keys(array("USER_ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->orderby(4,7);
		$this->newtable->sortby("ASC");
		$this->newtable->tipe_proses('button');
		$this->newtable->set_formid("fuser");
		$this->newtable->set_divid("divuser");
		$this->newtable->rowcount(25);
		$this->newtable->clear(); 
		$this->newtable->menu($prosesnya);
		$tabel = $this->newtable->generate($SQL);			
		$arrdata = array("title" => $judul,
						 "tabel" => $tabel);
		if($this->input->post("ajax")||$ajax) return $tabel;				 
		else return $arrdata;		
	}
	
	function getuser($type="",$id=""){		
		$func = get_instance();
		$func->load->model("main");
		if($type=="add"){			
			$data = array("judul" => "Tambah Data User","act" => "Save");
		}else{
			#start by pass untuk edit formjs
	    	$generate = $this->input->post('generate');
	    	if($generate == "formjs"){
				$USER_ID = $this->input->post('id1');
			}
			#END
			$SQL = "SELECT A.*,B.KODE_ROLE,C.NAMA NAMA_TRADER 
					FROM t_user A, t_user_role B, m_trader C 
					WHERE A.USER_ID=B.USER_ID AND A.KODE_TRADER=C.KODE_TRADER 
					AND A.USER_ID='".$USER_ID."'";
			$hasil = $func->main->get_result($SQL);
			if($hasil){
				foreach($SQL->result_array() as $row){	
					$dataarray = $row;
				}
			}	
			$data = array("judul" => "Form edit User","act"=>"Update","sess"=>$dataarray,"userid"=>$id,"readonly"=>"readonly");	   	
		}
		$data = array_merge($data,array("KODEROLE" => $func->main->get_combobox("SELECT KODE_ROLE, NAMA FROM M_ROLE
															ORDER BY KODE_ROLE","KODE_ROLE","NAMA", TRUE)));
		return $data;
	}
	
	function setuser($act=""){
		$func = get_instance();
		$func->load->model("main","main", true);
		if(strtolower($this->input->post("act"))=="save"){
			foreach($this->input->post('USER') as $a => $b){
				$USER[$a] = $b;
			}		
			$SESEMAIL = $this->newsession->userdata("EMAIL");
			$SENAMA = $this->newsession->userdata("NAMA");
			$NMTRADER = $this->newsession->userdata("NAMA_TRADER");	
			$this->load->helper('email');
			if(!valid_email($USER["EMAIL"])){echo "MSG#ERR#Email tidak valid, periksa kembali email anda.";die();}
			$KONPASSWORD = $this->input->post('KONPASSWORD');
			$KODETRADER = $this->input->post('KODE_TRADER');
			if($USER["PASSWORD"]===$KONPASSWORD){
				$rs = $this->db->query("SELECT USERNAME FROM T_USER WHERE USERNAME='".$USER["USERNAME"]."'");
				if($rs->num_rows() == 0){
					$KODEROLE = $this->input->post('KODEROLE');
					$USER["STATUS"]='1';
					$USER["KODE_TRADER"]= ($KODETRADER)?$KODETRADER:$this->newsession->userdata('KODE_TRADER');
					$PASS = $USER["PASSWORD"];
					$USER["PASSWORD"] = md5($USER["PASSWORD"]);
					$USER["USER_ID"] = (int)$func->main->get_uraian("SELECT MAX(USER_ID) AS MAXSERI FROM T_USER", "MAXSERI") + 1;
					$exec = $this->db->insert('t_user', $USER);	
					$exec = $this->db->insert('t_user_role', array("USER_ID"=>$USER["USER_ID"],"KODE_ROLE"=>$KODEROLE));	
					if($exec){
						$this->prosesmenu($USER["USER_ID"]);
						$isi = 'User baru telah ditambahkan pada perusahaan '.$NMTRADER.', Berikut Akun Anda di '.base_url().' Silahkan login dengan:<table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">Username</td><td>: <b>'.$USER["USERNAME"].'</b></td></tr><tr><td>Password</td><td>: <b>'.$PASS.'</b></td></tr></table>lakukan Perubahan Password segera. Terima kasih.';				$to = $USER["EMAIL"];
						$func->main->send_mail($to,$USER["NAMA"], 'Akses Login GBInventory', $isi);
						$func->main->send_mail($SESEMAIL,$SENAMA, 'Akses Login GBInventory', $isi);
						echo "MSG#OK#Tambah data Berhasil#".site_url()."/admin/user#";
					}else{					
						echo "MSG#ERR#Tambah data Gagal#";
					}
				}else{
					echo "MSG#ERR#Username Sudah ada.";	
				}
			}else{
				echo "MSG#ERR#Password tidak sama.";
			}
		}else{
			if(strtolower($this->input->post("act"))=="update"){
				foreach($this->input->post('USER') as $a => $b){
					$USER[$a] = $b;
				}
				$KONPASSWORD = $this->input->post('KONPASSWORD');
				if($USER["PASSWORD"]===$KONPASSWORD){
					$KODEROLE = $this->input->post('KODEROLE');
					$this->db->where(array('USER_ID' => $USER["USER_ID"]));
					$exec=$this->db->update('t_user', $USER);
					$this->db->where(array('USER_ID' => $USER["USER_ID"]));
					$exec=$this->db->update('t_user_role', array("KODE_ROLE"=>$KODEROLE));
					if($exec){
						echo "MSG#OK#Proses data Berhasil#".site_url()."/admin/user#";die();
					}else{					
						echo "MSG#ERR#Proses data Gagal#";die();
					}	
				}else{
					echo "MSG#ERR#Password tidak sama.";die();
				}
			}
			else if(strtolower($act)=="aktif"){
				foreach($this->input->post('tb_chkfuser') as $chkitem){
					$this->db->where(array('USER_ID' => $chkitem));
					$exec=$this->db->update('t_user', array("STATUS"=>"1"));
				}
			}
			else if(strtolower($act)=="nonaktif"){
				foreach($this->input->post('tb_chkfuser') as $chkitem){
					$this->db->where(array('USER_ID' => $chkitem));
					$exec=$this->db->update('t_user', array("STATUS"=>"0"));
				}
			}
			else if(strtolower($act)=="delete"){
				foreach($this->input->post('tb_chkfuser') as $chkitem){
					$this->db->where(array('USER_ID' => $chkitem));
					$exec = $this->db->delete('t_user');
					$this->db->where(array('USER_ID' => $chkitem));
					$exec = $this->db->delete('t_user_role');	
					$this->db->where(array('USER_ID' => $chkitem));
					$exec = $this->db->delete('m_menu_user');	
				}
			}
			else if(strtolower($act)=="reset"){
				foreach($this->input->post('tb_chkfuser') as $chkitem){					
					$SQL = "SELECT USERNAME,EMAIL,NAMA FROM T_USER WHERE USER_ID='".$chkitem."'";
					$result = $this->db->query($SQL);
					$row = $result->row();
					$USERNAME = $row->USERNAME;
					$EMAIL = $row->EMAIL;
					$NAMA = $row->NAMA;
					
					$pwd = str_shuffle("0123456789");
					$pwd = substr($pwd, 3, 6);
					$SUBJECT = "Reset Password";
					$isi = 'Password Akun Anda di '.base_url().' telah diubah oleh sistem. Silahkan login dengan:<table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">Username</td><td>: <b>'.$USERNAME.'</b></td></tr><tr><td>Password</td><td>: <b>'.$pwd.'</b></td></tr></table>Terima kasih.';
					if($func->main->send_mail($EMAIL, $NAMA, $SUBJECT, $isi)){
						$this->db->where('USER_ID', $chkitem);
						if($this->db->update('T_USER', array("PASSWORD" => md5($pwd)))) $exec = true;
					}else{
						$exec = false;
					}
				}
			}		
			if($exec){
				echo "MSG#OK#Proses data Berhasil#".site_url()."/admin/user/ajax#";
			}else{					
				echo "MSG#ERR#Proses data Gagal#";
			}
		}		
	}
	
	function get_profiltrader($type="",$kodeTrader=""){
			$conn =& get_instance();
			$conn->load->model("main", "main", true);
			if($type=="baru"||$type=="reject"){
				$query = "SELECT *, f_ref('KODE_ID',KODE_ID) AS URAI_ID, f_ref('API',KODE_API) AS URAI_API
					  	  FROM M_TRADER_TEMP WHERE KODE_TRADER='".$kodeTrader."'";	
			}else{
				$query = "SELECT *, f_ref('KODE_ID',KODE_ID) AS URAI_ID, f_ref('API',KODE_API) AS URAI_API
						  FROM M_TRADER WHERE KODE_TRADER='".$kodeTrader."'";
			}
			$hasil = $conn->main->get_result($query);
			if($hasil){
				foreach($query->result_array() as $row){
					$dataarray = $row;
				}
			}
			$this->db->where('KODE_TRADER',$kodeTrader);
			$this->db->select_max('TANGGAL_SKEP');
			$resultSkep = $this->db->get('m_trader_skep')->row();
			$maxTglSkep = $resultSkep->TANGGAL_SKEP;
			$SQL = "SELECT KODE_SKEP, NOMOR_SKEP, TANGGAL_SKEP, KODE_TRADER, SERI 
					FROM m_trader_skep WHERE KODE_TRADER = '".$kodeTrader."' AND TANGGAL_SKEP='".$maxTglSkep."'";
			$hasil = $conn->main->get_result($SQL);
			if($hasil){
				foreach($SQL->result_array() as $row){
					$SKEP = $row;
				}
			}		
			$arrdata = array('sess' => $dataarray,
							 'SKEP' => $SKEP,
							 'kode_id_trader' => $conn->main->get_mtabel('KODE_ID'),
							 'kode_api_trader' => $conn->main->get_mtabel('API'),
							 'JENIS_TPB' => $conn->main->get_mtabel('JENIS_TPB'),
							 'TIPE_TRADER' => $conn->main->get_mtabel('JENIS_EKSPORTIR'),
							 'type'=>$type,
							 'PROPINSI_GB' => $conn->main->get_combobox("SELECT KODE_DAERAH,URAIAN_DAERAH FROM M_DAERAH 
							 											WHERE SUBSTRING(KODE_DAERAH,3,2)='00'","KODE_DAERAH","URAIAN_DAERAH", TRUE),
							 'KOTA_GB' => $conn->main->get_combobox("SELECT KODE_DAERAH,URAIAN_DAERAH FROM M_DAERAH 
							 											WHERE SUBSTRING(KODE_DAERAH,3,2)!='00'","KODE_DAERAH","URAIAN_DAERAH", TRUE));							 
			return $arrdata;
	}
	
	function getberita($tipe="",$id=""){
		$func = get_instance();
		$func->load->model("main");
		if($tipe=="1") $addsql = " AND IDBERITA='".$id."'";
		$SQL = "SELECT IDBERITA, JUDUL, ISI, CREATED_BY, CREATED_TIME, f_user(CREATED_BY) CREATEDBY, 
				DATE_FORMAT(CREATED_TIME,'%H:%i:%s')  TGL FROM t_berita WHERE TAMPIL='Y' ".$addsql." ORDER BY IDBERITA DESC LIMIT 3 ";
		$hasil = $func->main->get_result($SQL);
		$data="";
		if($tipe=="1"){			
			if($hasil){
				foreach($SQL->result_array() as $row){	
					$data = $row;
				}
			}
			return array("data"=>$data);	
		}else{
			if($hasil){
				foreach($SQL->result_array() as $row){	
					$data .= "<li><div class=\"the-post group\"> 
							  <span class=\"date\">".$this->fungsi->FormatDateIndo($row["CREATED_TIME"]).' '.$row["TGL"]."&nbsp;<img src='".base_url()."img/new.gif'></span><br>
							  <a class=\"title\" href=\"javascript:void(0)\" onclick=\"showberita('".$row["IDBERITA"]."')\">".$row["JUDUL"]."</a>
									<p class=\"comment\">".str_replace("<p>","",str_replace("</p>","",$this->word_limiter($row["ISI"],45)))."...</p>
								</div>
							 </li>";
				}
			}	
			return $data;
		}
	}
	
	function word_limiter($str,$limit=10){
		if(stripos($str," ")){
			$ex_str = explode(" ",$str);
			if(count($ex_str)>$limit){
				for($i=0;$i<$limit;$i++){
					$str_s.=$ex_str[$i]." ";
				}
				return $str_s;
			}else{
				return $str;
			}
		}else{
			return $str;
		}
	}

	function resettrader(){		
		$judul = "Daftar Perusahaan Disetujui";
		$SQL = "SHOW FULL TABLES FROM gbv03 WHERE tables_in_gbv03 not 		
			    in('m_daerah','m_hanggar','m_kemasan','m_kemasan_old','m_kpbc','m_menu','m_menu_role','m_menu_user','m_menu_group','t_log_activity',
			       'm_negara','m_pelabuhan','m_postarif','m_postarifur','m_role','m_satuan','m_satuan_old','m_setting','m_tempat_timbun','m_trader_stockopname_dtl',
		           'm_tabel','m_timbun','m_trader','m_trader_temp','m_valuta','t_berita','t_user','t_user_role','t_srr_dtl','t_trans_uplift_srr_dtl','t_trans_uplift_srr_hdr','M_TRADER_NO_URUT',
				   'm_trader_permohonan_barang','m_trader_skep','t_breakdown_pemasukan','t_breakdown_pengeluaran','t_breakdown_pengeluaran_dok','t_log_reset',
				   't_bc23_cnt','t_bc23_dok','t_bc23_dtl','t_bc23_fas','t_bc23_kms',
				   't_bc23_perubahan','t_bc23_pgt','t_bc23_trf'	
					,'t_bc25_bb','t_bc25_bmtambahan','t_bc25_dok','t_bc25_dtl','t_bc25_fas','t_bc25_kms','t_bc25_pgt',
					 't_bc25_ppn_penyerahan','t_bc25_trf'
					,'t_bc261_bb','t_bc261_bj','t_bc261_bmtambahan','t_bc261_dok','t_bc261_dtl','t_bc261_kms','t_bc261_trf'
					,'t_bc262_bmtambahan','t_bc262_dok','t_bc262_dtl','t_bc262_kms','t_bc262_perubahan','t_bc262_trf'
					,'t_bc27_bb','t_bc27_bj','t_bc27_cnt','t_bc27_dok','t_bc27_dtl','t_bc27_kms','t_bc27_perubahan'
					,'t_bc30_cnt','t_bc30_dok','t_bc30_dtl','t_bc30_kms','t_bc30_pjt','t_bc30_pkb'
					,'t_bc40_dok','t_bc40_dtl','t_bc40_kms','t_bc40_perubahan'
					,'t_bc41_bb','t_bc41_dok','t_bc41_dtl','t_bc41_kms'
					,'t_realisasi_parsial_dtl','t_temp_realisasi_parsial_dtl','t_realisasi_parsial_dok','t_temp_realisasi_parsial_dok')";		
		$rs = $this->db->query($SQL);	
		$no=1;
		$cls="alt";
		$tabel  = '<table class="tabelPopUp" width="100%">';
		$tabel .= '<tr><th width="1%">No</th><th width="1%">';
		$tabel .= "<input type=\"checkbox\" id=\"tb_chkall\" onclick=\"checkall('freset_')\" class=\"tb_chkall\"/>";
		$tabel .= '</th><th style="text-align:left">&nbsp;NAMA TABEL</th>';
		$tabel .= '</th><th style="text-align:left">&nbsp;Tipe Tabel</th></tr>';
		foreach($rs->result_array() as $row){	
			$tabel .= '<tr>';
			$tabel .= '    <td class="'.$cls.'">'.$no.'</td>';
			$tabel .= '    <td class="'.$cls.'"><input type="checkbox" name="tb_chk[]" id="tb_chk" value="'.$row["Tables_in_gbv03"].'"></td>';
			$tabel .= '	   <td class="'.$cls.'">'.strtoupper($row["Tables_in_gbv03"]).'</td>';	
			$tabel .= '	   <td class="'.$cls.'">'.$row["Table_type"].'</td>';			
			$tabel .= '</tr>';
			$no++;
			if($cls=="alt"){$cls="odd";}elseif($cls=="odd"){$cls="alt";}
		}
		$tabel .= "</table>";	
		$arrdata = array("judul" => 'Daftar Tabel :',
						 "tabel" => $tabel);return $arrdata;		
	}
	
	function resettraderproses(){
		$KODE_TRADER = $this->input->post('KODE_TRADER');
		$TBLHEADER = array('T_BC23_HDR','T_BC27_HDR','T_BC30_HDR','T_BC262_HDR','T_BC261_HDR','T_BC40_HDR','T_BC41_HDR','T_BC25_HDR');
		$BC23=array('t_bc23_cnt','t_bc23_dok','t_bc23_dtl','t_bc23_fas','t_bc23_kms','t_bc23_perubahan','t_bc23_pgt','t_bc23_trf',
					't_breakdown_pemasukan');	
		$BC25=array('t_bc25_bb','t_bc25_bmtambahan','t_bc25_dok','t_bc25_dtl','t_bc25_fas','t_bc25_kms','t_bc25_pgt',
				    't_bc25_ppn_penyerahan','t_bc25_trf','t_breakdown_pengeluaran');
		$BC261=array('t_bc261_bb','t_bc261_bj','t_bc261_bmtambahan','t_bc261_dok','t_bc261_dtl','t_bc261_kms','t_bc261_trf',
					 't_breakdown_pengeluaran');		
		$BC262=array('t_bc262_bmtambahan','t_bc262_dok','t_bc262_dtl','t_bc262_kms','t_bc262_perubahan','t_bc262_trf','t_breakdown_pemasukan');
		$BC27=array('t_bc27_bb','t_bc27_bj','t_bc27_cnt','t_bc27_dok','t_bc27_dtl','t_bc27_kms','t_bc27_perubahan','t_breakdown_pemasukan',
					't_breakdown_pengeluaran');
		$BC30=array('t_bc30_cnt','t_bc30_dok','t_bc30_dtl','t_bc30_kms','t_bc30_pjt','t_bc30_pkb','t_breakdown_pengeluaran');
		$BC40=array('t_bc40_dok','t_bc40_dtl','t_bc40_kms','t_bc40_perubahan','t_breakdown_pemasukan');
		$BC41=array('t_bc41_bb','t_bc41_dok','t_bc41_dtl','t_bc41_kms','t_breakdown_pengeluaran');
		
		$RESETTBL="";				
		foreach($this->input->post('tb_chk') as $chkitem){
			if(in_array(strtoupper($chkitem),$TBLHEADER)){
				if(strtoupper($chkitem)=='T_BC23_HDR') $TABEL = $BC23;
				if(strtoupper($chkitem)=='T_BC27_HDR') $TABEL = $BC27;
				if(strtoupper($chkitem)=='T_BC25_HDR') $TABEL = $BC25;
				if(strtoupper($chkitem)=='T_BC30_HDR') $TABEL = $BC30;
				if(strtoupper($chkitem)=='T_BC40_HDR') $TABEL = $BC40;
				if(strtoupper($chkitem)=='T_BC41_HDR') $TABEL = $BC41;
				if(strtoupper($chkitem)=='T_BC262_HDR') $TABEL = $BC262;
				if(strtoupper($chkitem)=='T_BC261_HDR') $TABEL = $BC261;
				foreach($TABEL as $tbl){
					$sql = "DELETE FROM ".$tbl." WHERE nomor_aju IN(SELECT nomor_aju FROM ".$chkitem." 
							WHERE kode_trader='".$KODE_TRADER."')";		
					$this->db->query($sql);									
				}	
				$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
				$this->db->delete($chkitem);				
			}
			elseif(strtolower($chkitem)=='m_trader_permohonan'){
				$rs = $this->db->query("SELECT NOMOR_AJU FROM m_trader_permohonan WHERE KODE_TRADER='".$KODE_TRADER."'");
				if($rs->num_rows()>0){
					if($rs->num_rows()==1){
						$dtrs = $rs->row();
						$noaju = $dtrs->NOMOR_AJU;
					}else{
						$noaju = "";
						foreach ($rs->result_array() as $res) {
							$noaju = $noaju.",".$res['NOMOR_AJU'];
						}
					}
					$this->db->where_in('NOMOR_AJU', $noaju);
					$execmohon = $this->db->delete('m_trader_permohonan_barang');
					if($execmohon){
						$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
						$this->db->delete($chkitem);
					}
				}
			}
			elseif(strtolower($chkitem)=='t_realisasi_parsial_hdr'){
				$sql = "DELETE FROM t_realisasi_parsial_dtl WHERE HDR_REFF IN(SELECT REALISASIID FROM t_realisasi_parsial_hdr 
					 WHERE kode_trader='".$KODE_TRADER."')";		
				$this->db->query($sql);	
				$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
				$this->db->delete($chkitem);				
			}
			elseif(strtolower($chkitem)=='t_temp_realisasi_parsial_hdr'){
				$sql = "DELETE FROM t_temp_realisasi_parsial_dtl WHERE HDR_REFF IN(SELECT REALISASIID FROM t_temp_realisasi_parsial_hdr 
					 WHERE kode_trader='".$KODE_TRADER."')";		
				$this->db->query($sql);	
				$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
				$this->db->delete($chkitem);				
			}
			elseif(strtolower($chkitem)=='m_trader_stockopname'){
				$sql = "DELETE FROM m_trader_stockopname_dtl WHERE IDHDR IN(SELECT ID FROM m_trader_stockopname
					 WHERE kode_trader='".$KODE_TRADER."')";		
				$this->db->query($sql);	
				$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
				$this->db->delete($chkitem);				
			}
			elseif(strtolower($chkitem)=='t_srr_hdr'){
				$sql = "DELETE FROM t_srr_dtl WHERE NO_SRR IN(SELECT NO_SRR FROM t_srr_hdr
					 WHERE kode_trader='".$KODE_TRADER."')";		
				$this->db->query($sql);	
				$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
				$this->db->delete($chkitem);				
			}
			elseif(strtolower($chkitem)=='t_trans_uplift_srr_hdr'){
				$sql = "DELETE FROM t_trans_uplift_srr_dtl WHERE UPLIFT_HDR_REF IN(SELECT UPLIFT_ID FROM t_trans_uplift_srr_hdr
					 WHERE kode_trader='".$KODE_TRADER."')";		
				$this->db->query($sql);	
				$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
				$this->db->delete($chkitem);				
			}

			else{
				$this->db->where(array("KODE_TRADER"=>$KODE_TRADER));		
				$this->db->delete($chkitem);
			}
			$RESETTBL = $RESETTBL.$chkitem.';'; 
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$DATA['TABLE_RESET'] = $RESETTBL;
		$DATA['KODE_TRADER'] = $KODE_TRADER;
		$DATA['RESET_BY'] = $this->newsession->userdata('USER_ID');
		$DATA['RESET_TIME'] = date("Y-m-d H:i:s");
		$this->db->insert('t_log_reset',$DATA);
		echo "MSG#OK#DATA BERHASIL DIPROSES.";
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
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'12',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'13',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'14',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
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
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'35',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w'),
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
							array("KODE_ROLE"=>$row['KODE_ROLE'],"KODE_MENU"=>'65',"USER_ID"=>$row['USER_ID'],"AKSES"=>'w')
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
	
	function tammenu(){
		$func = get_instance();
		$func->load->model("main");
		$SQL = "SELECT a.USER_ID,b.KODE_ROLE FROM t_user a, t_user_role b WHERE a.USER_ID=b.USER_ID";
		if($func->main->get_result($SQL)){
			foreach ($SQL->result_array() as $row){
				$SQ = "SELECT USER_ID FROM M_MENU_USER WHERE KODE_MENU='53' AND USER_ID='".$row["USER_ID"]."'";
				if(!$func->main->get_result($SQ)){
					$SQLS = "INSERT INTO m_menu_user (KODE_ROLE,KODE_MENU,USER_ID)
					  	VALUES ('".$row["KODE_ROLE"]."','53','".$row["USER_ID"]."');";
					$this->db->query($SQLS);
				}

			}
		}
		
	}

	function activitylog(){
		$func = get_instance();
		$func->load->model("main");
		$this->load->library('newtable');	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");	
		
		if(!is_array($ciuri)){
			$url = explode("|",$ciuri);					
		}
				
		if($key = array_search('search', $url)){			
			$cari = $url[$key+2];
			if($cari != ""){
				$SQL = "SELECT LOGID, USER_ID, f_trader(KODE_TRADER) 'TRADER NAME', f_username(USER_ID) USERNAME, IP_ADDRESS 'IP ADDRESS', ACTIVITY_DATE 'ACTIVITY DATE', 
		        		 ACTION, REMARK, TIPE FROM T_LOG_ACTIVITY"; 	
			}else{
				$SQL = "SELECT LOGID, USER_ID, f_trader(KODE_TRADER) 'TRADER NAME', f_username(USER_ID) USERNAME, IP_ADDRESS 'IP ADDRESS', ACTIVITY_DATE 'ACTIVITY DATE', 
		        		 ACTION, REMARK, TIPE FROM T_LOG_ACTIVITY
		        		 WHERE ACTIVITY_DATE > DATE_SUB(SYSDATE(),INTERVAL 30 DAY)"; 			
			}			
		}else{
			$SQL = "SELECT LOGID, USER_ID, f_trader(KODE_TRADER) 'TRADER NAME', f_username(USER_ID) USERNAME, IP_ADDRESS 'IP ADDRESS', ACTIVITY_DATE 'ACTIVITY DATE', 
		        ACTION, REMARK, TIPE FROM T_LOG_ACTIVITY
		        WHERE ACTIVITY_DATE > DATE_SUB(SYSDATE(),INTERVAL 30 DAY)"; 
		}		

		$combo = $func->main->get_combobox("SELECT KODE_TRADER,NAMA FROM M_TRADER ORDER BY NAMA", "KODE_TRADER", "NAMA", TRUE);
						
		$this->newtable->search(array(array('ACTION','ACTION'),			 
									  array('REMARK','REMARK'),
									  array('ACTIVITY_DATE', 'ACTIVITY DATE&nbsp;','tag-tanggal'),
									  array('KODE_TRADER', 'TRADER NAME','tag-select',$combo)
									));
														
			
		$this->newtable->action(site_url()."/admin/activitylog");
		$this->newtable->hiddens(array('LOGID','TIPE','USER_ID'));			
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->set_formid("flog");
		$this->newtable->set_divid("divflog");		
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->rowcount(25);
		$this->newtable->show_chk(false);
		$this->newtable->clear(); 		
		$tabel .= $this->newtable->generate($SQL);			
		$arrdata = array("title" => 'Activity Log',
						 "tabel" => $tabel);
		if($this->input->post("ajax")) return $tabel;				 
		else return $arrdata;
	}
	
	function getposisi($kodeTrader=""){
		$sqlin = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI_BARANG, NAMA_BARANG,
  				  SATUAN, JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO FROM t_logbook_pemasukan WHERE KODE_TRADER='".$kodeTrader."'
				  ORDER BY TGL_DOK, TGL_MASUK, SERI_BARANG ASC";	
		$rsmasuk = $this->db->query($sqlin);
		if($rsmasuk->num_rows()>0){
			echo '<table border="1">';
			foreach($rsmasuk->result_array() as $rowmasuk){
				/*LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI_BARANG, NAMA_BARANG,
  				  SATUAN, JUMLAH, NILAI_PABEAN,NO_DOK_MASUK, TGL_DOK_MASUK, JENIS_DOK_MASUK, SERI_BARANG_MASUK*/
				$sql = "SELECT 'BC25' JENISDOK, A.NOMOR_PENDAFTARAN, A.TANGGAL_PENDAFTARAN,A.TANGGAL_REALISASI, '".$kodeTrader."' KODETRADER, 
						B.KODE_BARANG, B.JNS_BARANG, B.SERI, B.URAIAN_BARANG, B.KODE_SATUAN, B.JUMLAH_SATUAN, B.CIF, 
						'".$rowmasuk["NO_DOK"]."' NODOKMASUK, '".$rowmasuk["TGL_DOK"]."' TGLDOKMASUK, 'BC23' JENISDOKMASUK
						FROM T_BC25_HDR A, T_BC25_DTL B WHERE A.NOMOR_AJU=B.NOMOR_AJU AND A.KODE_TRADER=B.KODE_TRADER
						AND A.KODE_TRADER='".$kodeTrader."'
						AND B.KODE_BARANG='".$rowmasuk["KODE_BARANG"]."' AND B.JNS_BARANG='".$rowmasuk["JNS_BARANG"]."'
						AND B.JUMLAH_SATUAN='".$rowmasuk["JUMLAH"]."' AND B.CIF='".$rowmasuk["NILAI_PABEAN"]."'"; 
						//echo $sql; echo "<br>";
				$rskeluar = $this->db->query($sql);
				if($rskeluar->num_rows()>0){
					foreach($rskeluar->result_array() as $rowkeluar){
						echo '<tr>';
						echo '<td>'.$rowkeluar["JENISDOK"].'</td>';
						echo '<td>'.$rowkeluar["NOMOR_PENDAFTARAN"].'</td>';
						echo '<td>'.$rowkeluar["TANGGAL_PENDAFTARAN"].'</td>';
						echo '<td>'.$rowkeluar["TANGGAL_REALISASI"].'</td>';
						echo '<td>'.$rowkeluar["KODETRADER"].'</td>';
						echo '<td>'.$rowkeluar["KODE_BARANG"].'</td>';
						echo '<td>'.$rowkeluar["JNS_BARANG"].'</td>';
						echo '<td>'.$rowkeluar["SERI"].'</td>';
						echo '<td>'.$rowkeluar["URAIAN_BARANG"].'</td>';
						echo '<td>'.$rowkeluar["KODE_SATUAN"].'</td>';
						echo '<td>'.$rowkeluar["JUMLAH_SATUAN"].'</td>';
						echo '<td>'.$rowkeluar["CIF"].'</td>';
						echo '<td>'.$rowkeluar["NODOKMASUK"].'</td>';
						echo '<td>'.$rowkeluar["TGLDOKMASUK"].'</td>';
						echo '<td>'.$rowkeluar["JENISDOKMASUK"].'</td>';
						echo '</tr>';
					}
				}
			}
			echo '</table>';
		}
	}
	
	function getposisipabean($kodeTrader=""){
		$sqlin = "SELECT 'BC23' JENISDOK, A.NOMOR_PENDAFTARAN, A.TANGGAL_PENDAFTARAN,A.TANGGAL_REALISASI, '".$kodeTrader."' KODETRADER, 
				B.KODE_BARANG, B.JENIS_BARANG, B.SERI, B.URAIAN_BARANG, B.KODE_SATUAN, B.JUMLAH_SATUAN, B.CIF, '1' FLAG, '0' SALDO
				FROM T_BC23_HDR A, T_BC23_DTL B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
				AND A.KODE_TRADER='".$kodeTrader."' AND A.TANGGAL_REALISASI IS NOT NULL ORDER BY A.NOMOR_PENDAFTARAN"; 
		$rsmasuk = $this->db->query($sqlin);
		if($rsmasuk->num_rows()>0){
			echo '<table border="1">';
			$NOIN = 1;
			foreach($rsmasuk->result_array() as $rowmasuk){
				/*echo "INSERT INTO t_logbook_pemasukan VALUES('',";				
				echo "'".$rowmasuk["JENISDOK"]."',";
				echo "'".$rowmasuk["NOMOR_PENDAFTARAN"]."',";
				echo "'".$rowmasuk["TANGGAL_PENDAFTARAN"]."',";
				echo "'".$rowmasuk["TANGGAL_REALISASI"]."',";
				echo "'".$rowmasuk["KODETRADER"]."',";
				echo "'".$rowmasuk["KODE_BARANG"]."',";
				echo "'".$rowmasuk["JENIS_BARANG"]."',";
				echo "'".$rowmasuk["SERI"]."',";
				echo "'".$rowmasuk["URAIAN_BARANG"]."',";
				echo "'".$rowmasuk["KODE_SATUAN"]."',";
				echo "'".$rowmasuk["JUMLAH_SATUAN"]."',";
				echo "'".$rowmasuk["CIF"]."',";
				echo "'".$rowmasuk["FLAG"]."',";
				echo "'".$rowmasuk["SALDO"]."');<br>";*/
				
				
				//echo '<tr>';
//				echo '<td>'.$NOIN.'</td>';
//				echo '<td>'.$rowmasuk["JENISDOK"].'</td>';
//				echo '<td>'.$rowmasuk["NOMOR_PENDAFTARAN"].'</td>';
//				echo '<td>'.$rowmasuk["TANGGAL_PENDAFTARAN"].'</td>';
//				echo '<td>'.$rowmasuk["TANGGAL_REALISASI"].'</td>';
//				echo '<td>'.$rowmasuk["KODETRADER"].'</td>';
//				echo '<td>'.$rowmasuk["KODE_BARANG"].'</td>';
//				echo '<td>'.$rowmasuk["JENIS_BARANG"].'</td>';
//				echo '<td>'.$rowmasuk["SERI"].'</td>';
//				echo '<td>'.$rowmasuk["URAIAN_BARANG"].'</td>';
//				echo '<td>'.$rowmasuk["KODE_SATUAN"].'</td>';
//				echo '<td>'.$rowmasuk["JUMLAH_SATUAN"].'</td>';
//				echo '<td>'.$rowmasuk["CIF"].'</td>';
//				echo '<td>'.$rowmasuk["FLAG"].'</td>';
//				echo '<td>'.$rowmasuk["SALDO"].'</td>';
				
				$sql = "SELECT 'BC25' JENISDOK, A.NOMOR_PENDAFTARAN, A.TANGGAL_PENDAFTARAN,A.TANGGAL_REALISASI, '".$kodeTrader."' KODETRADER, 
						B.KODE_BARANG, B.JNS_BARANG, B.SERI, B.URAIAN_BARANG, B.KODE_SATUAN, B.JUMLAH_SATUAN, B.CIF, 
						'".$rowmasuk["NOMOR_PENDAFTARAN"]."' NODOKMASUK, '".$rowmasuk["TANGGAL_PENDAFTARAN"]."' TGLDOKMASUK, 'BC23' JENISDOKMASUK
						FROM T_BC25_HDR A, T_BC25_DTL B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
						AND A.KODE_TRADER='".$kodeTrader."'
						AND B.KODE_BARANG='".$rowmasuk["KODE_BARANG"]."' AND B.JNS_BARANG='".$rowmasuk["JENIS_BARANG"]."'
						AND B.JUMLAH_SATUAN='".$rowmasuk["JUMLAH_SATUAN"]."' AND B.CIF='".$rowmasuk["CIF"]."'
						AND A.TANGGAL_REALISASI IS NOT NULL
						GROUP BY B.KODE_BARANG, B.JNS_BARANG,B.JUMLAH_SATUAN,B.CIF
						 ORDER BY A.NOMOR_PENDAFTARAN"; 
				$rskeluar = $this->db->query($sql);
				if($rskeluar->num_rows()>0){
					$NOOUT=1;
					foreach($rskeluar->result_array() as $rowkeluar){
						echo "INSERT INTO t_logbook_pengeluaran VALUES('',";				
						echo "'".$rowkeluar["JENISDOK"]."',";
						echo "'".$rowkeluar["NOMOR_PENDAFTARAN"]."',";
						echo "'".$rowkeluar["TANGGAL_PENDAFTARAN"]."',";
						echo "'".$rowkeluar["TANGGAL_REALISASI"]."',";
						echo "'".$rowkeluar["KODETRADER"]."',";
						echo "'".$rowkeluar["KODE_BARANG"]."',";
						echo "'".$rowkeluar["JNS_BARANG"]."',";
						echo "'".$rowkeluar["SERI"]."',";
						echo "'".$rowkeluar["URAIAN_BARANG"]."',";
						echo "'".$rowkeluar["KODE_SATUAN"]."',";
						echo "'".$rowkeluar["JUMLAH_SATUAN"]."',";
						echo "'".$rowkeluar["CIF"]."',";
						echo "'".$rowkeluar["NODOKMASUK"]."',";
						echo "'".$rowkeluar["TGLDOKMASUK"]."',";
						echo "'".$rowkeluar["JENISDOKMASUK"]."','');<br>";
				
						/*echo '<tr>';
						echo '<td>'.$NOOUT.'</td>';
						echo '<td>'.$rowkeluar["JENISDOK"].'</td>';
						echo '<td>'.$rowkeluar["NOMOR_PENDAFTARAN"].'</td>';
						echo '<td>'.$rowkeluar["TANGGAL_PENDAFTARAN"].'</td>';
						echo '<td>'.$rowkeluar["TANGGAL_REALISASI"].'</td>';
						echo '<td>'.$rowkeluar["KODETRADER"].'</td>';
						echo '<td>'.$rowkeluar["KODE_BARANG"].'</td>';
						echo '<td>'.$rowkeluar["JNS_BARANG"].'</td>';
						echo '<td>'.$rowkeluar["SERI"].'</td>';
						echo '<td>'.$rowkeluar["URAIAN_BARANG"].'</td>';
						echo '<td>'.$rowkeluar["KODE_SATUAN"].'</td>';
						echo '<td>'.$rowkeluar["JUMLAH_SATUAN"].'</td>';
						echo '<td>'.$rowkeluar["CIF"].'</td>';
						echo '<td>'.$rowkeluar["NODOKMASUK"].'</td>';
						echo '<td>'.$rowkeluar["TGLDOKMASUK"].'</td>';
						echo '<td>'.$rowkeluar["JENISDOKMASUK"].'</td>';
						echo '</tr>';*/
						$NOOUT++;
					}
				}
				//echo '</tr>';
				$NOIN++;
			}
		}
			echo '</table>';
	}
	
	function setkodebarangdokumen(){
		$KODE_TRADER = $this->input->post('KODE_TRADER');
		$func = get_instance();
		$func->load->model("main");
		$TBLHEADER = array('T_BC23_HDR','T_BC27_HDR','T_BC30_HDR','T_BC262_HDR','T_BC261_HDR','T_BC40_HDR','T_BC41_HDR','T_BC25_HDR');
		$BC23=array('t_bc23_cnt','t_bc23_dok','t_bc23_dtl','t_bc23_fas','t_bc23_kms','t_bc23_perubahan','t_bc23_pgt','t_bc23_trf',
					't_breakdown_pemasukan');	
					
		$BC25=array('t_bc25_bb','t_bc25_bmtambahan','t_bc25_dok','t_bc25_dtl','t_bc25_fas','t_bc25_kms','t_bc25_pgt',
				    't_bc25_ppn_penyerahan','t_bc25_trf','t_breakdown_pengeluaran');
		
		$BC27=array('t_bc27_bb','t_bc27_bj','t_bc27_cnt','t_bc27_dok','t_bc27_dtl','t_bc27_kms','t_bc27_perubahan','t_breakdown_pemasukan',
					't_breakdown_pengeluaran','t_bc27_dokasal');
					
		$BC30=array('t_bc30_cnt','t_bc30_dok','t_bc30_dtl','t_bc30_kms','t_bc30_pjt','t_bc30_pkb','t_breakdown_pengeluaran');		
		
		$SQL = "SELECT KODE_TRADER FROM M_TRADER ORDER BY NAMA";
		$ret = "PROSES GAGAL COY";
		if($func->main->get_result($SQL)){
			$sukses = 0;
			$gagal = 0;
			foreach ($SQL->result_array() as $row){	
				foreach($BC23 as $tbl){					
					$SQL = "UPDATE ".$tbl." SET KODE_TRADER = '".$row["KODE_TRADER"]."' 
							WHERE NOMOR_AJU IN (SELECT NOMOR_AJU FROM T_BC23_HDR WHERE KODE_TRADER='".$row["KODE_TRADER"]."')
							AND KODE_TRADER IS NULL OR KODE_TRADER = ''";
					if($this->db->query($SQL)) $sukses++;
					else $gagal ++;	
				}
				/*foreach($BC30 as $tbl){					
					$SQL = "UPDATE ".$tbl." SET KODE_TRADER = '".$row["KODE_TRADER"]."' 
							WHERE NOMOR_AJU IN (SELECT NOMOR_AJU FROM T_BC30_HDR WHERE KODE_TRADER='".$row["KODE_TRADER"]."')
							AND KODE_TRADER IS NULL OR KODE_TRADER = ''";
					$this->db->query($SQL);	
				}*/
				/*foreach($BC25 as $tbl){					
					$SQL = "UPDATE ".$tbl." SET KODE_TRADER = '".$row["KODE_TRADER"]."' 
							WHERE NOMOR_AJU IN (SELECT NOMOR_AJU FROM T_BC25_HDR WHERE KODE_TRADER='".$row["KODE_TRADER"]."')
							AND KODE_TRADER IS NULL OR KODE_TRADER = ''";
					$this->db->query($SQL);	
				}*/				
				/*foreach($BC27 as $tbl){					
					$SQL = "UPDATE ".$tbl." SET KODE_TRADER = '".$row["KODE_TRADER"]."' 
							WHERE NOMOR_AJU IN (SELECT NOMOR_AJU FROM T_BC27_HDR WHERE KODE_TRADER='".$row["KODE_TRADER"]."')
							AND KODE_TRADER IS NULL OR KODE_TRADER = ''";
					$this->db->query($SQL);	
				}*/
			}
			$ret = "PROSES BERHASIL!";
		}		
		echo $ret;
	}
	
	
	function update_seri(){
		$func = get_instance();
		$func->load->model("main");
		$SQL = "SELECT * FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='EDIKTTR00020'";
		if($func->main->get_result($SQL)){
			foreach ($SQL->result_array() as $row){
				$this->db->where(array("KODE_TRADER"=>"EDIKTTR00020","KODE_BARANG"=>$row["KODE_BARANG"],
									   "JNS_BARANG"=>$row["JNS_BARANG"],"NO_DOK_MASUK"=>$row["NO_DOK"],
									   "TGL_DOK_MASUK"=>$row["TGL_DOK"],"JENIS_DOK_MASUK"=>$row["JENIS_DOK"]));
				$e = $this->db->update('t_logbook_pengeluaran',array("SERI_BARANG_MASUK"=>$row["SERI_BARANG"]));	
			}
			if($e) echo "sip";
		}		
	}
	
	function update_logkeluar(){
		$func = get_instance();
		$func->load->model("main");
		$SQL = "SELECT 
				A.NOMOR_PENDAFTARAN, A. TANGGAL_PENDAFTARAN,
				B.KODE_BARANG AS KDBRGDTL, B.JNS_BARANG AS JNSBRGDTL, B.SERI SERIDTL, B.JUMLAH_SATUAN,
				C.*, D.SERI_BARANG, D.LOGID 
				FROM T_BC25_HDR A, T_BC25_dTL B, T_BC25_BB C, t_logbook_pemasukan D
				WHERE A.KODE_TRADER = B.KODE_TRADER AND A.KODE_TRADER = C.KODE_TRADER
				AND A.KODE_TRADER = D.KODE_TRADER
				AND A.NOMOR_AJU = B.NOMOR_AJU AND A.NOMOR_AJU = C.NOMOR_AJU
				AND C.NOMOR_DOK_ASAL = D.NO_DOK AND C.TANGGAL_DOK_ASAL = D.TGL_DOK
				AND C.KODE_BARANG_BB = D.KODE_BARANG
				AND B.SERI = C.SERI
				AND A.KODE_TRADER='EDIKTTR00020' 
				AND A.TANGGAL_REALISASI IS NOT NULL
				GROUP BY B.NOMOR_AJU, C.SERI
				ORDER BY B.NOMOR_AJU, C.SERI, B.KODE_BARANG";
		if($func->main->get_result($SQL)){
			foreach ($SQL->result_array() as $row){
				$this->db->where(array("KODE_TRADER"=>"EDIKTTR00020","KODE_BARANG"=>$row["KDBRGDTL"],
									   "JNS_BARANG"=>$row["JNSBRGDTL"],"NO_DOK"=>$row["NOMOR_PENDAFTARAN"],
									   "TGL_DOK"=>$row["TANGGAL_PENDAFTARAN"],"JENIS_DOK"=>'BC25',
									   "SERI_BARANG"=>$row["SERIDTL"]));
				$DATA["NO_DOK_MASUK"] = $row["NOMOR_DOK_ASAL"];			
				$DATA["TGL_DOK_MASUK"] = $row["TANGGAL_DOK_ASAL"];			
				$DATA["JENIS_DOK_MASUK"] = "BC23";			
				$DATA["SERI_BARANG_MASUK"] = $row["SERI_BARANG"];			
				$DATA["LOGID_MASUK"] = $row["LOGID"];						
				$DATA["NOMOR_AJU"] = $row["NOMOR_AJU"];					   
				$e = $this->db->update('t_logbook_pengeluaran',$DATA);	
			}
			if($e) echo "sip";
		}		
	}
	
	function tambah_no_urut_manual($KODETRADER=""){
		$func = get_instance();
		$func->load->model("main");
		$SQL = "SELECT KODE_TRADER, NAMA FROM M_TRADER ";
		if($KODETRADER) $SQL .= " WHERE KODE_TRADER='".$KODETRADER."'";
		$ret = "PROSES GAGAL COY";
		if($func->main->get_result($SQL)){	
			foreach ($SQL->result_array() as $row){		
				$KOLOM2 = sprintf("%06d", $row["KODE_TRADER"]);
				$SQD = "SELECT DOKNAME FROM m_trader_no_urut WHERE KODE_TRADER='".$row["KODE_TRADER"]."' AND DOKNAME='BC23'";	
				if(!$func->main->get_result($SQD)){					
					$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$row["KODE_TRADER"],'DOKNAME'=>'BC23','NO_URUT'=>1));
				}
				$SQD = "SELECT DOKNAME FROM m_trader_no_urut WHERE KODE_TRADER='".$row["KODE_TRADER"]."' AND DOKNAME='BC25'";	
				if(!$func->main->get_result($SQD)){
					$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$row["KODE_TRADER"],'DOKNAME'=>'BC25','NO_URUT'=>1));
				}
				$SQD = "SELECT DOKNAME FROM m_trader_no_urut WHERE KODE_TRADER='".$row["KODE_TRADER"]."' AND DOKNAME='BC27'";	
				if(!$func->main->get_result($SQD)){	
					$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$row["KODE_TRADER"],'DOKNAME'=>'BC27','NO_URUT'=>1));
				}
				$SQD = "SELECT DOKNAME FROM m_trader_no_urut WHERE KODE_TRADER='".$row["KODE_TRADER"]."' AND DOKNAME='BC30'";	
				if(!$func->main->get_result($SQD)){	
					$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$row["KODE_TRADER"],'DOKNAME'=>'BC30','NO_URUT'=>1));
				}
				$SQD = "SELECT DOKNAME FROM m_trader_no_urut WHERE KODE_TRADER='".$row["KODE_TRADER"]."' AND DOKNAME='SRR'";	
				if(!$func->main->get_result($SQD)){	
					$this->db->insert('m_trader_no_urut',array('KODE_TRADER'=>$row["KODE_TRADER"],'DOKNAME'=>'SRR','NO_URUT'=>1));
				}
				$trader = $trader.$row["NAMA"]." PROSES BERHASIL<br>";
				$ret = $trader;	
			}
		}
		echo $ret;
	}
	
	function sinkron($KODE_TRADER="",$TANGGAL_AWAL="",$TANGGAL_AKHIR=""){					
		$func = &get_instance();
		$func->load->model("main","main", true);				
		$SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, KODE_HS, URAIAN_BARANG, MERK, TIPE, UKURAN,
				SPFLAIN, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, STOCK_AKHIR 
				FROM M_TRADER_BARANG WHERE KODE_TRADER='".$KODE_TRADER."'";
		$hasil = $func->main->get_result($SQL);
		$ret = "Proses Gagal!";	
		if($hasil){			
			$tglAkhirInOut=date('Y-m-d',strtotime($TANGGAL_AWAL."-1 day"));		
			foreach($SQL->result_array() as $row){
				$KODE_BARANG = $row["KODE_BARANG"];
				$JNS_BARANG = $row["JNS_BARANG"];
				$sqlGetSaldoStock ="SELECT REPLACE(FORMAT(JUMLAH,2),',','') AS 'JUMLAH_STOCK', TANGGAL_STOCK
									FROM m_trader_stockopname
									WHERE KODE_TRADER ='".$KODE_TRADER."' 
									AND TANGGAL_STOCK <= '".$TANGGAL_AWAL."'
									AND KODE_BARANG ='".$KODE_BARANG."'
									AND JNS_BARANG = '".$JNS_BARANG."'
									ORDER BY TANGGAL_STOCK DESC LIMIT 1";				
				$RSSTOCKOPNAME=$this->db->query($sqlGetSaldoStock)->row(); 
				$GETSALDOAWALSTOCK=$RSSTOCKOPNAME->JUMLAH_STOCK;				
				$TGLSTOCK = "";
				if($RSSTOCKOPNAME->TANGGAL_STOCK!=""){ 
					$TGLSTOCK = " BETWEEN '".date('Y-m-d',strtotime($RSSTOCKOPNAME->TANGGAL_STOCK."+1 day"))."' AND '".$tglAkhirInOut."'";
				}else{
					$TGLSTOCK = " <= '".$tglAkhirInOut."'";
				}							 
				$sqlGetSaldoIn = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_IN', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_IN'
								  FROM m_trader_barang_inout
								  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
								  AND KODE_TRADER = '".$KODE_TRADER."'
								  AND KODE_BARANG ='".$KODE_BARANG."'
								  AND JNS_BARANG = '".$JNS_BARANG."'
								  AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')
								  GROUP BY KODE_BARANG, JNS_BARANG";
																  
				$sqlGetSaldoOut ="SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_OUT', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_OUT'
								  FROM m_trader_barang_inout
								  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
								  AND KODE_TRADER = '".$KODE_TRADER."'
								  AND KODE_BARANG ='".$KODE_BARANG."'
								  AND JNS_BARANG = '".$JNS_BARANG."'
								  AND TIPE IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')
								  GROUP BY KODE_BARANG, JNS_BARANG";
				
				$RSGETSALDOAWALIN=$this->db->query($sqlGetSaldoIn)->row();
				$GETSALDOAWALIN=$RSGETSALDOAWALIN->AWAL_SALDO_IN;
				$RSGETSALDOAWALOUT=$this->db->query($sqlGetSaldoOut)->row(); 
				$GETSALDOAWALOUT=$RSGETSALDOAWALOUT->AWAL_SALDO_OUT;
				
				if($GETSALDOAWALSTOCK==""){
					$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT;
				}else{
					if($RSSTOCKOPNAME->TANGGAL_STOCK==$tglAkhirInOut){
						$SALDOAWLGET = $GETSALDOAWALSTOCK;
					}else{
						if($RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALIN->TGL_IN||$RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALOUT->TGL_OUT){
							$SALDOAWLGET = $GETSALDOAWALSTOCK;
						}else{
							$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT;
						}	
					}
				}	
				$SALDO_AWAL = $SALDOAWLGET;
				$TANGGAL_STOCK = $TANGGAL_AWAL;
				#============================
				$SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI, KODE_DOKUMEN, 
						TANGGAL_DOKUMEN, NOMOR_AJU,TIPE, 
						CASE TIPE
						WHEN 'GATE-IN' THEN CONCAT('REALISASI PEMASUKAN (GATE-IN)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
						WHEN 'GATE-OUT' THEN CONCAT('REALISASI PENGELUARAN (GATE-OUT)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
						WHEN 'PROCESS_IN' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI MASUK (-)',CONCAT('PRODUKSI MASUK (-)',' ',NOMOR_PROSES))
						WHEN 'PROCESS_OUT' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI KELUAR (+)',CONCAT('PRODUKSI KELUAR (+)',' ',NOMOR_PROSES))
						WHEN 'SCRAP' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI SISA (+)',CONCAT('PRODUKSI SISA (+)',' ',NOMOR_PROSES)) 
						WHEN 'RUSAK' THEN 'PENGERUSAKAN'
						WHEN 'MUSNAH' THEN 'PEMUSNAHAN' END TIPE_URAIAN,
						REPLACE(FORMAT(JUMLAH,2),',','') AS JUMLAH, DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') TANGGAL, PROCESS_WITH, 
						DATE_FORMAT(CREATED_TIME,'%d-%m-%Y %H:%i:%s') CREATED_TIME 
						FROM M_TRADER_BARANG_INOUT 
						WHERE KODE_BARANG='".$KODE_BARANG."' AND KODE_TRADER='".$KODE_TRADER."'
						AND JNS_BARANG = '".$JNS_BARANG."'
						AND DATE_FORMAT(TANGGAL, '%Y-%m-%d') BETWEEN '".$TANGGAL_AWAL."' AND '".$TANGGAL_AKHIR."'
						ORDER BY DATE_FORMAT(TANGGAL, '%Y-%m-%d') ASC, DATE_FORMAT(TANGGAL, '%H:%i-%s') ASC";	
				$hasil = $func->main->get_result($SQL);					
				$no=2;
				$SALDO = 0;
				$TOTAL_MASUK = 0;
				$TOTAL_KELUAR = 0;
				$TOTAL_SALDO = 0;			
				if($hasil){
					foreach($SQL->result_array() as $row){
						if($row['TIPE']=="GATE-IN"||$row['TIPE']=="PROCESS_OUT"||$row['TIPE']=="SCRAP"||$row['TIPE']=="MOVE-IN"){
							if($no==2){
								$SALDO = (float)$SALDO_AWAL + (float)$row['JUMLAH'];
							}else{
								$SALDO = (float)$SALDO + (float)$row['JUMLAH'];	
							}
							$TOTAL_MASUK = (float)$TOTAL_MASUK+(float)$row['JUMLAH'];
						}else{
							if($no==2){ 
								$SALDO = (float)$SALDO_AWAL - (float)$row['JUMLAH'];
							}else{
								$SALDO = (float)$SALDO - (float)$row['JUMLAH'];
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
						if(number_format($SALDO,2)=='-0.00'){
							$SALDO = '0.00';
						}
						$TOTAL_SALDO = (float)$TOTAL_SALDO+(float)$SALDO;
						$no++;
					}						
				}
				else{
					$SALDO = $SALDO_AWAL;
				}
				$this->db->where(array('KODE_BARANG'=>$KODE_BARANG,'JNS_BARANG'=>$JNS_BARANG,
									   'KODE_TRADER'=>$KODE_TRADER));
				if($this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$SALDO))){
					$ret = "Proses Berhasil!";
				}	
			}
		}
		echo $ret;
	}

}
?>