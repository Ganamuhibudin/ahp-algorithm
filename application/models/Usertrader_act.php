<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usertrader_act extends CI_Model{	

	function proses_form($tipe="", $id=""){
		$func = get_instance();
		$func->load->model("main","main", true);
		$kodeTrader = $this->newsession->userdata("KODE_TRADER");
		$SESEMAIL = $this->newsession->userdata("EMAIL");
		$NMTRADER = $this->newsession->userdata("NAMA_TRADER");
		$idUser = $this->newsession->userdata("USER_ID");
		
		if($tipe=="profil"){	
			foreach($this->input->post('PROFIL') as $a => $b){
				$arrProf[$a] = $b;
			}
			$this->db->where(array('KODE_TRADER' => $kodeTrader, 'USER_ID' => $idUser));
			$exec = $this->db->update('t_user', $arrProf);								
			if($exec){
				$usernames = $func->main->get_uraian("SELECT USERNAME FROM T_USER WHERE USER_ID='".$idUser."'", "USERNAME");
				$func->main->activity_log('EDIT PROFIL USER','USERNAME='.$usernames);
				echo "MSG#OK#Pengubahan Data Berhasil.#".site_url()."/user/profil/lihat#";
			}else{					
				echo "MSG#ERR#Pengubahan Data Gagal";
			}
		}
		elseif($tipe=="user"){
			$act=$this->input->post('act');									
			foreach($this->input->post('USER') as $a => $b){
				$arrUser[$a] = $b;
			}
			foreach($this->input->post('USER_ROLE') as $a1 => $b1){
				$arrRole[$a1] = $b1;
			}
			$this->load->helper('email');
			if(!valid_email($arrUser["EMAIL"])){echo "MSG#ERR#Email tidak valid, periksa kembali email anda.";die();}
			
			if($act =="save"){
				$SQL = "SELECT USERNAME FROM t_user WHERE USERNAME='".$arrUser["USERNAME"]."'";
				$data = $this->db->query($SQL);
				if($data->num_rows() > 0){
					echo "MSG#ERR#Username sudah ada";
				}else{	
					$KONFPASSWORD = $this->input->post('KONFPASSWORD');
					if($arrUser["PASSWORD"]==$KONFPASSWORD){								
						$USER_ID = (int)$func->main->get_uraian("SELECT MAX(USER_ID) AS MAXSERI FROM t_user", "MAXSERI") + 1;						
						$arrRole['USER_ID']= $USER_ID;
						$exec = $this->db->insert('t_user_role', $arrRole);									
						$arrUser['KODE_TRADER']= $kodeTrader;
						$arrUser['USER_ID']= $USER_ID;
						$PASS = $arrUser['PASSWORD'];
						$arrUser['PASSWORD'] = md5($arrUser['PASSWORD']);
						$arrUser['EXPIRED_DATE'] = $arrUser['EXPIRED_DATE'] ? $arrUser['EXPIRED_DATE'] : null;
						$exec = $this->db->insert('t_user', $arrUser);
												
						foreach($this->input->post('checkmenu') as $index=>$val){
							$AKSES = $this->input->post('akses_'.$val);
							$menu["AKSES"] = strtolower($AKSES[0]);
							$menu["KODE_ROLE"] = $arrRole["KODE_ROLE"];
							$menu["USER_ID"] = $USER_ID;
							$menu["KODE_MENU"] = $val;
							$this->db->insert('m_menu_user', $menu);
						}
						
						if($exec){
							$isi = 'User baru telah ditambahkan pada perusahaan '.$NMTRADER.', Berikut Akun Anda di '.$_SERVER['HTTP_HOST'].' Silahkan login dengan:
									<table style="margin: 4px 4px 4px 0px; font-family: arial; font-size:12px; font-weight: 700;">
									<tr>
										<td width="65">Username</td>
										<td>: <b>'.$arrUser["USERNAME"].'</b></td>
									</tr>
									<tr>
										<td>Password</td>
										<td>: <b>'.$PASS.'</b></td>
									</tr>
									</table>Lakukan Perubahan Password segera. Terima kasih.';
							$to = $arrUser["EMAIL"].';'.$SESEMAIL;
							$func->main->send_mail($to,$arrUser["NAMA"], 'Akses Login PLB Inventory', $isi);
							$func->main->activity_log('ADD USER','USERNAME='.$arrUser["USERNAME"]);
							echo "MSG#OK#Simpan data User Berhasil#".site_url()."/user/userlist/draftUser#";
						}else{					
							echo "MSG#ERR#Simpan data User Gagal";
						}
					}else{
						echo "MSG#ERR#Password tidak sama";				
					}	
				}					
			}else{
				$this->db->where(array('USER_ID' => $id));
				$exec = $this->db->update('t_user_role', $arrRole);				
				$this->db->where(array('KODE_TRADER' => $kodeTrader, 'USER_ID' => $id));
				$exec = $this->db->update('t_user', $arrUser);	
				
				if($this->db->delete('m_menu_user',array("USER_ID"=>$id))){
					foreach($this->input->post('checkmenu') as $index=>$val){
						$AKSES = $this->input->post('akses_'.$val);
						$menu["AKSES"] = strtolower($AKSES[0]);
						$menu["KODE_ROLE"] = $arrRole["KODE_ROLE"];
						$menu["USER_ID"] = $id;
						$menu["KODE_MENU"] = $val;
						$this->db->insert('m_menu_user', $menu);
					}
				}
						
				if($exec){
					$usernames = $func->main->get_uraian("SELECT USERNAME FROM T_USER WHERE USER_ID='".$id."'", "USERNAME");
					$func->main->activity_log('EDIT USER','USERNAME='.$usernames);
					echo "MSG#OK#Ubah data User Berhasil#".site_url()."/user/userlist/draftUser#";
				}else{					
					echo "MSG#ERR#Ubah data User Gagal";
				}
			}
							
		}
	}

	function get_profil($aksi=""){
		$conn =& get_instance();
		$conn->load->model("main", "main", true);
		$kodeTrader=$this->newsession->userdata("KODE_TRADER");
		$idUser=$this->newsession->userdata("USER_ID");
		$query = "SELECT a.USER_ID, a.NAMA, a.ALAMAT, a.TELEPON, a.EMAIL, a.JABATAN, a.USERNAME, b.KODE_ROLE
					FROM T_USER a  
					INNER JOIN t_user_role b ON b.USER_ID=a.USER_ID  
					INNER JOIN m_role c ON c.KODE_ROLE=b.KODE_ROLE
				  WHERE a.KODE_TRADER='".$kodeTrader."' AND a.USER_ID='".$idUser."'";	
		$hasil = $conn->main->get_result($query);
				if($hasil){
					foreach($query->result_array() as $row){
						$dataarray = $row;
					}
				}
		if($aksi=="view"){
			$act = "Ubah";	
		}elseif($aksi=="edit"){
			$act = "Simpan";
		}
		$arrdata = array('act' => $act,
						 'sess'  => $dataarray,
						 'kode_role' => $conn->main->get_mrole());							 
		return $arrdata;
	}
	
	function get_password($aksi=""){
		$conn =& get_instance();
		$conn->load->model("main", "main", true);
		$kodeTrader=$this->newsession->userdata("KODE_TRADER");
		$idUser=$this->newsession->userdata("USER_ID");			
		$act = "Ok";
		$arrdata = array('act' => $act);							 
		return $arrdata;
	}
	
	function updatePass(){
		$func =& get_instance();
		$func->load->model("main", "main", true);
		$captchaSesi = $this->newsession->userdata('capt_login');
		$passSesi= $this->newsession->userdata("PASSWORD");
		$oldPass = md5($this->input->post('oldPass'));
		$newPass = $this->input->post('newPass');
		$renewPass = $this->input->post('renewPass');
		
		$kodeTrader=$this->newsession->userdata("KODE_TRADER");
		$idUser=$this->newsession->userdata("USER_ID");
		
		if($passSesi!=$oldPass){
			echo "MSG#ERR#Password lama tidak cocok#";
		}else{
			if($newPass != $renewPass){
				echo "MSG#ERR#Ulangi Password baru tidak cocok#";
			}else{
				
				$arrPass['PASSWORD'] = md5($newPass);
				$this->db->where(array('KODE_TRADER' => $kodeTrader, 'USER_ID' => $idUser));
				$this->db->update('t_user', $arrPass);
				$newPassSesi['PASSWORD'] =  md5($newPass);
				$this->newsession->set_userdata($newPassSesi);	
				$func->main->activity_log('UBAH PASSWORD');				
				echo "MSG#OK#Ubah data User Berhasil#".site_url()."/user/password#";
			}
		}	
	}	
	
	function daftar($tipe=""){
		$this->load->library('newtable');
		if($tipe!="priview"){
			if($tipe=="draftUser"){
				$WHERE = " WHERE C.KODE_TRADER ='".$this->newsession->userdata('KODE_TRADER')."' ";	
				$prosesnya = array(	'Tambah' => array('GET2', site_url()."/user/add/user", '0','icon-plus'),
									'Ubah' => array('GET2', site_url()."/user/editUser/user", '1','icon-edit'),
									'Hapus' => array('DELETE', site_url().'/user/set_user/'.$tipe, 'user','red icon-remove'),
									'Reset Password' => array('PROCESS', site_url().'/user/set_user/reset', '1','icon-undo'));
			
				$judul = "List Data User";			
				$SQL = "SELECT C.KODE_TRADER, C.USER_ID, C.NAMA AS 'Nama', C.USERNAME AS 'User ID',
						(SELECT B.nama FROM t_user_role A LEFT JOIN m_role B ON A.KODE_ROLE=B.KODE_ROLE WHERE A.USER_ID=C.USER_ID GROUP BY A.USER_ID ) AS 'User Role', 
				f_ref('STATUS_USER', C.STATUS) AS 'Status'
						FROM T_USER C ";	
						$SQL .=	$WHERE;	
												
			$this->newtable->search(array(array('NAMA', 'Nama'),array('USERNAME', 'User ID')));
			
			}
				
			$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
			$this->newtable->hiddens(array('KODE_TRADER','USER_ID'));			
			$this->newtable->keys("USER_ID");		
			$this->newtable->tipe_proses('button');
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($ciuri);
			$this->newtable->orderby(2);
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("f".$tipe);
			$this->newtable->set_divid("div".$tipe);
			$this->newtable->rowcount(10);
			$this->newtable->clear();  
			$this->newtable->menu($prosesnya);
			$tabel .= $this->newtable->generate($SQL);
			$arrdata = array("title" => "List Data User",
							 "judul" => $judul,
							 "tabel" => $tabel,
							 "jenis" => $jenis,
							 "tipe" => $tipe);
			if($this->input->post("ajax")) return $tabel;				 
			else return $arrdata;	
		
		}else{
			redirect(base_url());
			exit();
		}						
	}
	
	function getData($tipe,$id){
		$conn = get_instance();
		$conn->load->model("main");
		$idTrader=$this->newsession->userdata("KODE_TRADER");
		if($tipe=="user"){
				$query = "SELECT A.*, B.KODE_ROLE FROM t_user A,t_user_role B 			  
						  WHERE A.USER_ID=B.USER_ID AND A.USER_ID='".$id."' 
						  AND A.KODE_TRADER='".$idTrader."'";
		}
		$hasil = $conn->main->get_result($query);
		if($hasil){
			foreach($query->result_array() as $row){
				$dataarray = $row;
			}
		}	
		return $dataarray;
	}
	
	function set_user($action="", $tipe=""){
		$func = get_instance();
		$func->load->model("main","main", true);
		if($action=="delete"){ 
			$ret = "MSG#Hapus data Gagal";
			if($tipe=="draftUser"){
				$dataCheck = $this->input->post('tb_chkfdraftUser');
				foreach($dataCheck as $chkitem){			
					$usernames = $func->main->get_uraian("SELECT USERNAME FROM T_USER WHERE USER_ID='".$id."'", "USERNAME");
					$func->main->activity_log('DELETE USER','USERNAME='.$usernames);
					$arrchk = explode("|", $chkitem);
					$id = strtolower($arrchk[0]);				
					$this->db->where(array('USER_ID' => $id));
					$this->db->delete('t_user'); 						
					$this->db->where(array('USER_ID' => $id));
					$this->db->delete('t_user_role');					
					$this->db->where(array('USER_ID' => $id));
					$this->db->delete('m_menu_user');		
				}
				$ret = "MSG#OK#Hapus data Berhasil#".site_url()."/user/user_dok/draftUser#";
			    echo $ret;
			}	
		}else if($tipe=="reset"){
			foreach($this->input->post('tb_chkfdraftUser') as $chkitem){					
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
			$func->main->activity_log('DELETE USER','USERNAME='.$USERNAME);
			echo "MSG#OK#Reset Password Berhasil#".site_url()."/user/user_dok/draftUser#";
		}else{					
			echo "MSG#ERR#Reset password Gagal#";
		}
	}
	
	function menu_management($userid=""){
		$func = get_instance();
		$func->load->model("main");
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');			
		$jenisgroup = $this->input->post("jenisgroup");
		$ajax = $this->input->post("ajax");
		if($userid==""){
			$userid = $this->input->post("userid");
		}
		if($ajax){
			if($jenisgroup){
				$ADDSQL = "AND B.KODE_ROLE = '".$jenisgroup."'";	
			}			
			if($userid){
				$checkeduser = " , f_menuchecked(A.KODE_MENU,".$userid.") AS CHECKED ";
			}
		}else{
			if($userid){
				$rs = $this->db->get_where('T_USER_ROLE', array('USER_ID' => $userid))->row();
				$ADDSQL = "AND B.KODE_ROLE = '".$rs->KODE_ROLE."'";	
				$checkeduser = " , f_menuchecked(A.KODE_MENU,".$userid.") AS CHECKED ";
			}else{
				$ADDSQL = "AND B.KODE_ROLE = '3'";	
			}	
		}
		
		$SQL = "SELECT A.KODE_MENU, A.JUDUL, A.SUB_JUDUL, A.URL, A.URL_TIPE, A.KODE_MENU_PARENT, A.TAMPIL_FLAG, A.KETERANGAN ".$checkeduser."	
				FROM m_menu A , m_menu_group B WHERE A.TAMPIL_FLAG = 'Y' AND A.KODE_MENU_PARENT = '1' AND A.KODE_MENU=B.KODE_MENU ".$ADDSQL." 
				ORDER BY A.KODE_MENU_PARENT, A.INDEX ASC";	
						
		if($func->main->get_result($SQL)){
			$first=1;
			$second=2;
			$html = '<table class="tabelPopUp" width="100%" id="treeView">';
			$html.= '<thead>';
			$html.= '<tr>';
			$html.= '	<th width="2%"><input type="checkbox" name="checkAllmenu" id="checkAllmenu" class="tb_chk" onclick="menucheckAll(\'fuser\')"/></th>';
			$html.= '	<th width="35%">NAMA MENU</th>';
			$html.= '	<th width="20%">HAK AKSES</th>';
			$html.= '	<th width="53%">KETERANGAN</th>';
			$html.= '</tr>';
			$html.= '</thead>';
			$html.= '</tbody>';
			$akses="";
			foreach($SQL->result_array() as $parent){
				$html .= '<tr id="node-'.$first.'">';
				$html .= '<td><input type="checkbox" name="checkmenu[]" id="checkmenuParent_'.$parent["KODE_MENU"].'" class="tb_chk" value="'.$parent["KODE_MENU"].'" onclick="menucheckParent(\'fuser\',\''.$parent["KODE_MENU"].'\')" '.$parent["CHECKED"].'/></td>';	
				$html .= '<td>'.strtoupper($parent["JUDUL"]).'</td>';	
				$html .= '<td><input type="hidden" name="akses_'.$parent["KODE_MENU"].'[]" id="akses'.$parent["KODE_MENU"].'" class="akses_w" value="w" /></td>';
				$html .= '<td>'.strtoupper($parent["KETERANGAN"]).'</td>';
				$html .= '</tr>';
								
				if($userid){
					$akses = " , f_menuakses(B.KODE_ROLE,A.KODE_MENU,".$userid.") AS ASKSESMENU ";
				}
		
				$query = "SELECT A.KODE_MENU, A.JUDUL, A.SUB_JUDUL, A.URL, A.URL_TIPE, A.KODE_MENU_PARENT, A.TAMPIL_FLAG, A.KETERANGAN ".$akses."
						  ".$checkeduser." FROM m_menu A , m_menu_group B WHERE A.KODE_MENU=B.KODE_MENU 
						  AND A.KODE_MENU_PARENT='".$parent["KODE_MENU"]."' AND A.TAMPIL_FLAG = 'Y' 
						  ".$ADDSQL." ORDER BY A.KODE_MENU_PARENT, A.INDEX ASC";	
					  
				$child_w="";$child_r="";		  												  							
				if($func->main->get_result($query)){
					foreach($query->result_array() as $child){
						if($child["ASKSESMENU"]){
							if($child["ASKSESMENU"]=="w"){
								$child_w = 'checked="checked"';
							}else{ $child_w =""; }
							if($child["ASKSESMENU"]=="r"){
								$child_r = 'checked="checked"';
							}else{$child_r =""; }
						}
						if($first>1) $second = $second+1;
						$html .= '<tr id="node-'.$second.'" class="child-of-node-'.$first.'">';		
						$html .= '<td><input type="checkbox" name="checkmenu[]" id="checkmenuChild_'.$child["KODE_MENU_PARENT"].'" class="checkmenuChild_'.$child["KODE_MENU_PARENT"].'" value="'.$child["KODE_MENU"].'" onclick="menucheckChild(\'fuser\',\''.$child["KODE_MENU_PARENT"].'\')"  '.$child["CHECKED"].'/></td>';				
						$html .= '<td style="background-color:#FFFFCC"><span class="file">&nbsp;&nbsp;'.strtoupper($child["JUDUL"]).'</span></td>';
						$html .= '<td style="background-color:#FFFFCC" align="center">';
						
						if($jenisgroup){
							if(!in_array($jenisgroup,array("5","3"))){
								$html .= '<input type="radio" name="akses_'.$child["KODE_MENU"].'[]" id="akses'.$child["KODE_MENU"].'" class="akses_w" value="w" '.$child_w.'/>Write';	
							}
							
							if($jenisgroup=="3" and in_array($child["KODE_MENU"],array("63","38"))){
								$html .= '<input type="radio" name="akses_'.$child["KODE_MENU"].'[]" id="akses'.$child["KODE_MENU"].'" class="akses_w" value="w" '.$child_w.'/>Write';	
							}
						}else{
							if(!in_array($child["KODE_ROLE"],array("5"))){
								$html .= '<input type="radio" name="akses_'.$child["KODE_MENU"].'[]" id="akses'.$child["KODE_MENU"].'" class="akses_w" value="w" '.$child_w.'/>Write';	
							}	
						}						
						
						$html .= '&nbsp;';
						$html .= '<input type="radio" name="akses_'.$child["KODE_MENU"].'[]" id="akses'.$child["KODE_MENU"].'" class="akses_r" value="r" '.$child_r.'/> Read';	
						$html .= '</td>';
						$html .= '<td style="background-color:#FFFFCC">'.strtoupper($child["KETERANGAN"]).'</td>';
						$html .= '</tr>';
						$second++;
					}
				}
				$first = $second-1;
				$first++;
			}			
			$html .= '</tbody>';
			$html .= '</table>';
			if($ajax){
				$html .= '<script type="text/javascript">$(document).ready(function(){$("#treeView").treeTable();});</script>';				
				$html .= '<script type="text/javascript">$(document).ready(function(){';
				if($userid){
					$rs = $this->db->get_where('T_USER_ROLE', array('USER_ID' => $userid))->row();
					if($jenisgroup!=$rs->KODE_ROLE){
						$html .= '	$("#checkAllmenu").attr(\'checked\',true);';	
						if($jenisgroup=="5"){
							$html .= '$(".akses_r").attr(\'checked\',true);';	
						}else{
							$html .= '$(".akses_w").attr(\'checked\',true);';
						}
					}
				}else{					
					$html .= '	$("#checkAllmenu").attr(\'checked\',true);';	
					if($jenisgroup=="5"){
						$html .= '$(".akses_r").attr(\'checked\',true);';	
					}else{
						$html .= '$(".akses_w").attr(\'checked\',true);';
					}
					$html .= 'menucheckAll(\'fuser\')';
				}
				$html .= '});</script>';						  
			}
		}
		return $html;
	}	
}
?>