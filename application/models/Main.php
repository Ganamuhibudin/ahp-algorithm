<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Main extends CI_Model{
	
	public function get_index($dok = "", $addHeader = array()){
		if($this->newsession->userdata('logged')){
			if($this->content == "") {
				$dashboard = $this->getDashboard();
				$this->content = $this->load->view('welcome', $dashboard, true);
			}
			$func = get_instance();
			$func->load->model('menu_act');	
			// $menu = $func->menu_act->createMenu();
			// if($this->newsession->userdata("id_user") != "1"){
			// 	$notif = $func->menu_act->notif();
			// }
			$header["addHeader"] = $addHeader;
			$data = array('_content_' => $this->content,
						  '_welcome_' => $this->newsession->userdata('nama'),
						  '_role_' => $this->newsession->userdata('role'),
						  '_divisi_' => $this->newsession->userdata('divisi'),
						  '_header_' => $this->load->view('partials/header',$header,true));
			$this->parser->parse('partials/mainpage', $data);
		}else{
			$this->newsession->sess_destroy();
			$this->load->view('login');
		}
	}

	function getDashboard() {
		# get data barang
		$sqlBarang = "SELECT a.id_barang, a.kode_barang, b.jenis_barang, a.nama_barang,
						a.satuan, a.stock, a.stock_minimum
						FROM tbl_barang a
						LEFT JOIN tbl_jenis_barang b ON b.id_jenis_barang = a.jenis_barang
						ORDER BY a.id_barang ASC";
		$barang = $this->db->query($sqlBarang)->result_array();

		# get stock warning
		$sqlWarning = "SELECT a.id_barang, a.kode_barang, b.jenis_barang, a.nama_barang,
						a.satuan, a.stock, a.stock_minimum
						FROM tbl_barang a
						LEFT JOIN tbl_jenis_barang b ON b.id_jenis_barang = a.jenis_barang
						WHERE a.stock <= a.stock_minimum ORDER BY a.id_barang ASC";
		$barangWarning = $this->db->query($sqlWarning)->result_array();

		# get data distribusi
		$sqlPengeluaran = "SELECT * FROM tbl_pengeluaran";
		$objPengeluran = $this->db->query($sqlPengeluaran)->result_array();
		$distribusi = [];
		$retur = [];
		foreach ($objPengeluran as $pengeluaran) {
			if ($pengeluaran['tipe'] == 'DISTRIBUSI') {
				$distribusi[] = $pengeluaran;
			} elseif ($pengeluaran['tipe'] == 'RETUR') {
				$retur[] = $pengeluaran;
			}
		}
		
		# total distribusi & belum disproses
		$totalDistribusi = 0;
		$belumDiproses = 0;
		$rejected = 0;
		foreach ($distribusi as $dsb) {
			if ($dsb['status'] == 2 || $dsb['status'] == 3) {
				$totalDistribusi++;
			} elseif ($dsb['status'] == 0 || $dsb['status'] == 1) {
				$belumDiproses++;
			} elseif ($dsb['status'] == 4) {
				$rejected++;
			}
		}

		$response['totalPermohonan'] = count($distribusi);
		$response['totalDistribusi'] = $totalDistribusi;
		$response['belumDiproses'] = $belumDiproses;
		$response['rejected'] = $rejected;
		$response['totalRetur'] = count($retur);
		$response['barangWarning'] = $barangWarning;
		$response['barang'] = $barang;
		
		return $response;
	}

	function get_uraian($query, $select){
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$row = $data->row();
			return $row->$select;
		}else{
			return "";
		}
		return 1;
	}
	
	function get_result(&$query){
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$query = $data;
		}else{
			return false;
		}
		return true;
	}
	
	function get_combobox($query, $key, $value, $empty = FALSE, &$disable = ""){
		$combobox = array();
		$data = $this->db->query($query);
		if($empty) $combobox[""] = "&nbsp;";
		if($data->num_rows() > 0){
			$kodedis = "";
			$arrdis = array();
			foreach($data->result_array() as $row){
				if(is_array($disable)){
					if($kodedis==$row[$disable[0]]){
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}else{
						if(!array_key_exists($row[$disable[0]], $combobox)) $combobox[$row[$disable[0]]] = $row[$disable[1]];
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}
					$kodedis = $row[$disable[0]];
					if(!in_array($kodedis, $arrdis)) $arrdis[] = $kodedis;
				}else{
					$combobox[$row[$key]] = str_replace("'", "\'", $row[$value]);
				}
			}
			$disable = $arrdis;
		}
		return $combobox;
	}
	
	function post_to_query($array, $except=""){
		$data = array();
		foreach($array as $a => $b){
			if(is_array($except)){
				if(!in_array($a, $except)) $data[$a] = $b;
			}else{
				$data[$a] = $b;
			}
		}
		return $data;
	}
	
	/////////////////////////////////////////privat2e function:////////////////////////////////////////////////////////////////
	
	function get_car(&$car, $dokumen=""){
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$SQL = "SELECT DOKNAME, SEGMEN1, SEGMEN2, NO_URUT FROM M_TRADER_NO_URUT WHERE KODE_TRADER='".$KODE_TRADER."' 
				AND DOKNAME='".strtoupper($dokumen)."'";
		$rs = $this->db->query($SQL); 
		if($rs->num_rows() > 0){
			$row = $rs->row(); 
			date_default_timezone_set('Asia/Jakarta');
			$NO_URUT = sprintf("%06d", $row->NO_URUT); 
			$KOLOM1 = sprintf("%06d", ($row->SEGMEN1=="")?"000000":$row->SEGMEN1); 
			$KOLOM2 = sprintf("%06d", ($row->SEGMEN2==''||$row->SEGMEN2=='000000')?substr($KODE_TRADER,strlen($KODE_TRADER)-4,4):$row->SEGMEN2); 
			if($row->DOKNAME == "PERMOHONAN"){
				$car = $KOLOM2.date("Ymd").$NO_URUT;
			}else{
				$car = $KOLOM1.$KOLOM2.date("Ymd").$NO_URUT;
			}return true;
		}else{
			return false;
		}
	}
	
	/*function set_car(){
		$this->db->simple_query('UPDATE M_TRADER SET LAST_AJU = LAST_AJU + 1 WHERE KODE_TRADER = '.$this->newsession->userdata('KODE_TRADER'));
		return true;
	}*/
	
	function set_car($DOKNAME=""){
		$kdtrader=$this->newsession->userdata('KODE_TRADER');
		$this->db->simple_query("UPDATE m_trader_no_urut SET NO_URUT=NO_URUT + 1 WHERE KODE_TRADER = '".$kdtrader."' AND DOKNAME='".$DOKNAME."'");
		return true;
	}
	
	function get_lastProsesNo(&$lastProses){
		$kodeTrader = $this->newsession->userdata('KODE_TRADER');
		$sql = "select LAST_PROSES from m_trader where KODE_TRADER='".$kodeTrader."'";
		$result = $this->db->query($sql);
		$row = $result->row();
		$lastNumber = $row->LAST_PROSES;
		$lastProses = date('dmY').str_pad($lastNumber,6,0,STR_PAD_LEFT);
		return true;
	}
	
	function set_lastProses(){
		$kodeTrader = $this->newsession->userdata('KODE_TRADER');
		$this->db->simple_query("UPDATE M_SETTING SET LAST_PROSES = LAST_PROSES + 1 WHERE KODE_TRADER = '".$kodeTrader."'");
		return true;
	}
		
	function get_mtabel($jenis,$by=1,$empty = TRUE,$where="",$viewkode=""){
		if($by==1) $by="KODE+0";
		else $by="URAIAN";
		if(strtoupper($viewkode)=='NO')		
		$combo = $this->get_combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS='".$jenis."'  ".$where." ORDER BY $by ", "KODE", "URAIAN", $empty);
		else
		$combo = $this->get_combobox("SELECT KODE,URAIAN, concat(KODE,' - ',URAIAN) AS KODEUR FROM M_TABEL WHERE JENIS='".$jenis."'  ".$where." ORDER BY $by ", "KODE", "KODEUR", $empty);
		return $combo;
	}
	
	function get_mtabel_store($jenis,$by=1,$empty = TRUE,$where="",$viewkode=""){
		if($by==1) $by="KODE+0";
		else $by="URAIAN";
		if(strtoupper($viewkode)=='NO')		
		$combo = $this->get_combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS='".$jenis."'  ".$where." ORDER BY $by ", "KODE", "URAIAN", $empty);
		else
		$combo = $this->get_combobox("SELECT KODE,URAIAN, URAIAN AS KODEUR FROM M_TABEL WHERE JENIS='".$jenis."'  ".$where." ORDER BY $by ", "KODE", "KODEUR", $empty);
		return $combo;
	}
	
	function get_mtabel_uplift($jenis,$by=1,$empty = TRUE,$where="",$viewkode=""){
		if($by==1) $by="KODE+0";
		else $by="URAIAN";
		if(strtoupper($viewkode)=='NO')		
		$combo = $this->get_combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS='".$jenis."'  ".$where." ORDER BY $by ", "KODE", "URAIAN", $empty);
		else
		$combo = $this->get_combobox("SELECT KODE,URAIAN, URAIAN AS KODEUR FROM M_TABEL WHERE JENIS='".$jenis."'  ".$where." ORDER BY $by ", "KODE", "KODEUR", $empty);
		return $combo;
	}
	
	function get_mrole($jenis,$by=1,$empty = TRUE){
		if($by==1) $by="KODE_ROLE+0";
		else $by="URAIAN";
		$combo = $this->get_combobox("SELECT KODE_ROLE,NAMA, concat(NAMA) AS KODEUR FROM M_ROLE  ORDER BY $by ", "KODE_ROLE", "KODEUR", $empty);
		return $combo;
	}
		
	function getpph(){
			$NOAPI = $this->get_uraian("SELECT NOMOR_API FROM M_TRADER WHERE KODE_TRADER='".$this->newsession->userdata('KODE_TRADER')."'", "NOMOR_API");   
		return ($NOAPI)?'2.5':'7.5';
	}
	
	function getWhere($sql,$uri,$keys){
		if($uri){
			$ada = strpos(strtolower($sql), "where");
			if ( $ada === false )
				$dtWhere .= " WHERE ";
			else
				$dtWhere .= " AND ";
			
			$dtPos = explode("|",$uri);
			if($dtPos[7]=="search"){
				$dtField = $keys[$dtPos[8]];
				$dtSeeks = $dtPos[9];
				
				if ($dtSeeks != "")
				{							
					if (strpos(strtolower($dtSeeks), "tag-tanggal") === false ){								
						$dtSeeks = str_replace("'", "''", $dtSeeks);
						$value = $dtWhere.$dtField." LIKE '%".$dtSeeks."%' "; 
					}else{												
						if (strpos(strtolower($dtSeeks), "tag-tanggal-2field") === false ){																									
							$dtSeeks = str_replace("tag-tanggal;","",strtolower($dtSeeks));
							$arrayCari = explode(";",$dtSeeks);
							$tanggal1  = $arrayCari[0];
							$tanggal2  = $arrayCari[1];
							#for mysql
							$value =  $dtWhere."STR_TO_DATE(".$dtField.",'%Y-%m-%d')"." BETWEEN '".$tanggal1."' AND '".$tanggal2."'";	
						}else{	
							$dtSeeks = str_replace("tag-tanggal-2field;","",strtolower($dtSeeks));
							$arrayCari = explode(";",$dtSeeks);
							$tanggal1  = $arrayCari[0];
							$tanggal2  = $arrayCari[1];
							$dtField = explode(";",$dtField);
							#for mysql
							$value =  $dtWhere."STR_TO_DATE(".$dtField[0].",'%Y-%m-%d') >= '".$tanggal1."' AND STR_TO_DATE(".$dtField[1].",'%Y-%m-%d') <= '".$tanggal2."'";	
						}
						
					}
				}				
			}
			return $value;
		}	
	}
	
	
	function cekkodehs($kodehs="",$serihs="",$sql=""){
		if($kodehs){
			$hs = str_replace(".","",$kodehs);
			$kd = $this->newsession->userdata('KODE_TRADER');
			$query= "SELECT KODE_HS, SERI FROM m_trader_postarif WHERE KODE_HS='".$hs."' AND SERI = '".$serihs."'
					 AND KODE_TRADER = '".$kd."'";
			$data = $this->get_result($query);
			if($data){
				$val["KODE_HS"] = $kodehs;
				$val["SERI"] = $serihs;	
				$val["KODE_TRADER"] = $kd;									
				$this->db->insert('m_trader_postarif', $val);
			}
		}
	}
	
	function cekhanggar($kode="",$uraian=""){
		if($kode && $uraian){
			$query= "SELECT KODE_HANGGAR, URAIAN_HANGGAR FROM M_HANGGAR WHERE KODE_HANGGAR='".$kode."'";
			$data = $this->db->query($query);
			if($data->num_rows() < 1){
				$val["KODE_HANGGAR"] = $kode;	
				$val["URAIAN_HANGGAR"] = $uraian;									
				$this->db->insert('m_hanggar', $val);
			}
		}
	}
	
	function send_mail($to, $nama, $subject, $isi){
		$this->load->library("phpmailer");
		$mailconfig = $this->config->config;
		$mailconfig = $mailconfig['mail_config'];
		$this->phpmailer->Config($mailconfig);
		$this->phpmailer->Subject = $subject;
		$email = explode(";", $to);
		foreach($email as $a){
			$this->phpmailer->AddAddress($a, '');
		}
		/*$body = '<html><body style="background: #ffffff; color: #000000; font-family: arial; font-size: 13px; margin: 20px; color: #363636;"><table style="margin-bottom: 2px"><tr style="font-size: 13px; color: #0b1d90; font-weight: 700; font-family: arial;"><td width="41" style="margin: 0 0 6px 0px;"><img src="'.base_url().'img/logo_email.png" style="vertical-align: middle;" alt="Logo E-inkaber"/></td><td style="font-family: arial; vertical-align: middle; color: #153f6f;">'.$subject.'<br/><span style="color: #858585; font-size: 10px; text-decoration: none;">'.$_SERVER['HTTP_HOST'].'</span></td></tr></table><table width="100%"><tr><td><div style="border-top: 1px solid #dcdcdc; margin-top: 4px; margin-bottom: 10px; padding: 5px; font-family: Verdana; font-size: 11px;  height:20px;text-align:justify;">'.$isi.'</div></td></tr></table><table width="100%"><tr><td><div style="border-top: 1px solid #dcdcdc; clear: both; font-size: 11px; margin-top: 10px; padding-top: 5px;"><div style="font-family: arial; font-size: 10px; color: #a7aaab;">Bonded Zone Inventory Solution</div><a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="http://www.edi-indonesia.co.id/">Website EDII </a> | <a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="'.site_url().'">Website e-INKABER</a></div></td></tr></table></body></html>';*/
		
		$logo = "www.plbinventory.com";
		$slogan = "Bonded Zone Inventory Solution";
		$body = '<html><body bgcolor="#DDDDDD" style="background: #DDDDDD; padding: 0px; margin: 0px auto;">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					  <tr>
						<td bgcolor="#DDDDDD" align="center" style="text-align: center; padding-top: 0px; padding-right: 10px; padding-bottom: 0px; padding-left: 10px; margin: 0px;" ><div align="center">
							<table width="630" border="0" cellpadding="0" cellspacing="0">
							  <tr>
								<td><table width="630" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td align="left" colspan="2" style="border-top: none; border-right: none; border-bottom: 12px solid #586BFC; border-left: none;"><table width="630" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td align="left" valign="middle"><table border="0" cellspacing="30" cellpadding="0" >
												<tr>
												  <td><img src="'.base_url().'img/_logologin.png" alt="'.$logo.'" border="no" style="margin: 0px; padding: 0px; display: block;"/></td>
												</tr>
											  </table></td>
											<td align="right" valign="middle"><table border="0" cellspacing="30" cellpadding="0" >
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; line-height: 20px; color: #222222;">
												  '.$slogan.' 
												  </td>
												</tr>
											  </table></td>
										  </tr>
										</table></td>
									</tr>
									<tr>
									  <td align="left" bgcolor="#FFFFFF" colspan="2" style="border-top: none; border-right: none; border-bottom: 4px solid #DDDDDD; border-left: none;"><table align="left" width="630" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td bgcolor="#FFFFFF" width="210" align="left" valign="top" style="padding: 0px"><table width="209" border="0" cellspacing="0" cellpadding="0">
												<tr>
												  <td align="right" bgcolor="#F1F1F1" style="font-family: Arial,Helvetica,sans-serif; font-size: 16px; line-height: 20px; font-weight: bold; color: #222222; padding-top: 16px; padding-right: 10px; padding-bottom: 16px; padding-left: 24px; ">
												  '.$subject.'<br/><span style="color: #858585; font-size: 10px; text-decoration: none;">'.$_SERVER['HTTP_HOST'].'</span><br/><span style="color: #222222; font-size: 10px; text-decoration: none;">'.$this->newsession->userdata('NAMA_TRADER').'</span>
												  </td>
												</tr>
											  </table></td>
											<td bgcolor="#FFFFFF" width="420" align="left" valign="top" ><table border="0" cellspacing="0" cellpadding="0" >
												<tr>
												  <td align="left" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; padding-top: 12px; padding-right: 24px; padding-bottom: 24px; padding-left: 24px;"><table width="372" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #222222;">
													  <tr>
														<td height="30" align="left" valign="middle">
													  '.$isi.'
													  </td>
													 </tr>
													</table></td>
												</tr>
											  </table></td>
										  </tr>
										</table></td>
									</tr>
									<tr>
									  <td align="left" bgcolor="#FFFFFF" colspan="2" style="border-top: 11px solid #222222; border-right: none; border-bottom: none; border-left: none; font-size: 11px;"><table align="left" width="630" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td bgcolor="#F1F1F1" width="209" align="left" valign="top" style="border-right: 1px solid #DDDDDD;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #999999; ">
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; font-weight: bold; color: #222222; padding-top: 16px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> Head Office</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> PT. EDI Indonesia</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 10px; padding-bottom: 20px; padding-left: 20px;"> Wisma SMR 1st, 3rd, 10th Floor<br>
													Jl Yos Sudaro Kav. 89<br>
													Jakarta 14350, Indonesia</td>
												</tr>
											  </table></td>
											<td bgcolor="#F1F1F1" width="210" align="left" valign="top" ><table width="210" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #999999;">
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; font-weight: bold; color: #222222; padding-top: 16px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> Browse online</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #222222; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;">&#8226; <a href="http://www.edi-indonesia.co.id/" title="Company Profile" target="_blank" style="color: #586BFC; text-decoration: none;">Company Profile</a></td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #222222; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;">&#8226; <a href="'.site_url().'" title="einkaber" target="_blank" style="color: #586BFC; text-decoration: none;">www.plbinventory.com</a></td>
												</tr>
											  </table></td>
											<td bgcolor="#F1F1F1" width="209" align="left" valign="top" style="border-left: 1px solid #DDDDDD;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #999999; ">
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; font-weight: bold; color: #222222; padding-top: 16px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> Customer Support</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;">Phone : +6221-29-606-330</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 1px; padding-bottom: 0px; padding-left: 20px;"><a href="mailto:it-inventory@edi-indonesia.co.id" title="Company Profile" target="_blank" style="color: #586BFC; text-decoration: none;">it-inventory@edi-indonesia.co.id</a></td>
												</tr>
											  </table></td>
										  </tr>
										</table></td>
									</tr>
							</table>
						  </div></td>
					  </tr>
					</table>
					</body></html>';
					
		$this->phpmailer->Body = $body;
		return $this->phpmailer->Send();
		
	}
	
	function send_mail2($to, $nama, $subject, $isi){
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'noreply.gbinventory@gmail.com',
			'smtp_pass' => 'pass123abc',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		$mailconfig = $this->config->config;
		$mailconfig = $mailconfig['mail_config'];
		$this->email->set_newline("\r\n");
		$this->email->from($mailconfig['FROM'], $mailconfig['NAME']);
		$email = str_replace(';', ',', $to);
		$this->email->to($email);
		$bcc = str_replace(';', ',', $mailconfig['BCC']);
		$this->email->bcc($bcc);
		$this->email->subject($subject);
		$body = '<html><body style="background: #ffffff; color: #000000; font-family: arial; font-size: 13px; margin: 20px; color: #363636;"><table style="margin-bottom: 2px"><tr style="font-size: 13px; color: #0b1d90; font-weight: 700; font-family: arial;"><td width="41" style="margin: 0 0 6px 0px;"><img src="'.base_url().'img/logo.png" style="vertical-align: middle;"/></td><td style="font-family: arial; vertical-align: middle; color: #153f6f;">'.$subject.'<br/><span style="color: #858585; font-size: 10px; text-decoration: none;">www.gbinventory.com</span></td></tr></table><div style="background-color: #dee8f4; margin-top: 4px; margin-bottom: 10px; padding: 5px; font-family: Verdana; font-size: 11px; width:600px; height:20px;text-align:justify;">'.$isi.'</div><div style="border-top: 1px solid #dcdcdc; clear: both; font-size: 11px; margin-top: 10px; padding-top: 5px;"><div style="font-family: arial; font-size: 10px; color: #a7aaab;">Bonded Warehouse Inventory<br>Elektronic Data Interchange</div><a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="http://www.edi-indonesia.co.id/">Website EDII </a> | <a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="'.site_url().'">Website GBInventory</a></div></body></html>';
		$this->email->message($body);		
		return $this->email->send();
	}
	
	function send_mail3($to, $nama, $subject, $isi){
		$this->load->library("phpmailer");
		$mailconfig = $this->config->config;
		$mailconfig = $mailconfig['mail_config2'];
		$this->phpmailer->Config($mailconfig);
		$this->phpmailer->Subject = $subject;
		$email = explode(";", $to);
		foreach($email as $a){
			$this->phpmailer->AddAddress($a, '');
		}
		$body = '<html><body style="background: #ffffff; color: #000000; font-family: arial; font-size: 13px; margin: 20px; color: #363636;"><table style="margin-bottom: 2px"><tr style="font-size: 13px; color: #0b1d90; font-weight: 700; font-family: arial;"><td width="41" style="margin: 0 0 6px 0px;"><img src="'.base_url().'img/logo.png" style="vertical-align: middle;"/></td><td style="font-family: arial; vertical-align: middle; color: #153f6f;">'.$subject.'<br/><span style="color: #858585; font-size: 10px; text-decoration: none;">www.gbinventory.com</span></td></tr></table><div style="border-top: 1px solid #dcdcdc; margin-top: 4px; margin-bottom: 10px; padding: 5px; font-family: Verdana; font-size: 11px;  height:20px;text-align:justify;">'.$isi.'</div><div style="border-top: 1px solid #dcdcdc; clear: both; font-size: 11px; margin-top: 10px; padding-top: 5px;"><div style="font-family: arial; font-size: 10px; color: #a7aaab;">Bonded Warehouse Inventory Solution</div><a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="http://www.edi-indonesia.co.id/">Website EDII </a> | <a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="'.site_url().'">Website GBInventory</a></div></body></html>';
		$this->phpmailer->Body = $body;
		return $this->phpmailer->Send();
		
	}
	
	function upload($folder="",$element="",$id=""){
		$error = "";
		$msg = "";
		$arrtype = array("JPG", "JPEG", "GIF", "DOC", "PDF", "RAR", "ZIP", "PNG");
		if($element!=""){
				$ftype = explode(".",$_FILES[$element]['name']);
				$ftype = trim(strtoupper($ftype[count($ftype)-1]));
				if(!empty($_FILES[$element]['error'])){
					if(($_FILES[$element]['error']=="1") || ($_FILES[$element]['error']=="2")){
						$error = "<b>Error :</b><br>Ukuran File ".strtoupper($element)." Terlalu Besar.";
					}else if($_FILES[$element]['error']=="3"){
						$error = "<b>Error :</b><br>File ".strtoupper($element)." Yang Ter-Upload Tidak Sempurna.";
					}else if($_FILES[$element]['error']=="4"){
						$error = "<b>Error :</b><br>File ".strtoupper($element)." Kosong Atau Belum Dipilih.";
					}else if($_FILES[$element]['error']=="6"){
						$error = "<b>Error :</b><br>Direktori Penyimpanan Sementara Tidak Ditemukan.";
					}else if($_FILES[$element]['error']=="7"){
						$error = "<b>Error :</b><br>File ".strtoupper($element)." Gagal Ter-Upload.";
					}else if($_FILES[$element]['error']=="8"){
						$error = "<b>Error :</b><br>Proses Upload File ".strtoupper($element)." Dibatalkan.";
					}else{
						$error = "<b>Error :</b><br>Pesan Error Tidak Ditemukan.";
					}
				}else if(empty($_FILES[$element]['tmp_name']) || ($_FILES[$element]['tmp_name']=='none')){
					$error = "<b>Error :</b><br>File ".strtoupper($element)." Gagal Ter-Upload.";
				}else if(!in_array($ftype, $arrtype)){
					$error = "<b>Error :</b><br>Tipe File ".strtoupper($element)." Salah.<br>Tipe File Yang Diterima : *.JPG, *.JPEG, *.GIF, *.DOC, *.PDF, *.RAR Dan *.ZIP *.PNG";
				}else{
					
					$path = "img/".$folder.'/';
					$cekpath = $this->validate_upload_path($path);
					if($cekpath!=1){
						return  "{error: '$cekpath',\n msg: '$msg'\n}";exit();
					}
					$filename = $path.md5($id).".$ftype";				
					$imagename=str_replace($path,"",$filename);
					if(move_uploaded_file($_FILES[$element]['tmp_name'], $filename)){
						$rstemp = 1;
						if($rstemp==1){
							if($ftype=="JPG"||$ftype=="JPEG"||$ftype=="GIF"||$ftype=="PNG"){
								$msg1 = "<table border='0' cellpadding='0' cellpadding='0'><tr><td><img src=\"".base_url()."img/".$folder.'/'.$imagename."\" alt='' style=\"max-height:181px;max-width:181px;border:solid 1px #CCC\" align=\"middle\"></td><td valign='top'>";
								$msg2 = "</td><tr></table>";
							}
							$msg .= $msg1;
							$msg .= "<table border='0' cellpadding='0' cellpadding='0'><tr><td colspan='3'>Upload File Berhasil.</td></tr>";
							$msg .= '<tr><td>Nama File</td><td>:</td><td>'.$_FILES[$element]['name']."</td></tr>";
							if($element=="logo"){
							$msg .= '<tr><td>Tipe File</td><td>:</td><td>'.$_FILES[$element]['type']."</td></tr>";
							$msg .= '<tr><td>Ukuran File</td><td>:</td><td>'.@filesize($filename)." byte</td></tr>";
							$msg .= "<tr><td colspan=2><a href='javascript:void(0);' class='button del' id='btnupload' onClick=\"deleteFupload(\'".$imagename."\',\'".$element."\')\"><span><span class='icon'></span>&nbsp;Delete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></a></td></tr>";
							}
							$msg .= "</table>";
							if($element=="logo")
							$msg .= "<input type=\"hidden\" name=\"DATA[LOGO]\" id=\"LOGO\" value=\"".$imagename."\"/>";	
							else
							$msg .= "<input type=\"hidden\" name=\"PROFIL[LOGO]\" id=\"LOGO\" value=\"".$imagename."\"/>";	
							$msg .= $msg2;
						}else{
							$error = "<b>Error :</b> File ".strtoupper($element)." Gagal Ter-Upload.";
							@unlink($filename);
						}
					}else{
						$error = "<b>Error :</b> File ".strtoupper($element)." Gagal Ter-Upload.";
					}
					@unlink($_FILES[$element]);
				}
		}else{
			$error = "<b>Error :</b><br>Parameter Tidak Ditemukan.";
		}
		return  "{error: '$error',\n msg: '$msg'\n}";	
	}
	
	function validate_upload_path($upload_path){
		if ($upload_path == ''){
			return 'No filepath 1';
		}
		
		if (function_exists('realpath') AND @realpath($upload_path) !== FALSE){
			$upload_path = str_replace("\\", "/", realpath($upload_path));
		}

		if ( ! @is_dir($upload_path)){
			return 'No filepath 2';
		}

		if ( ! is_really_writable($upload_path)){
			return 'upload Not Writable';
		}

		$upload_path = preg_replace("/(.+?)\/*$/", "\\1/",  $upload_path);
		return '1';
	}
	
	function getIP($type){ 
		 if (getenv("HTTP_CLIENT_IP") 
			 && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
			 $ip = getenv("HTTP_CLIENT_IP"); 
		 else if (getenv("REMOTE_ADDR") 
			 && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
			 $ip = getenv("REMOTE_ADDR"); 
		 else if (getenv("HTTP_X_FORWARDED_FOR") 
			 && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
			 $ip = getenv("HTTP_X_FORWARDED_FOR"); 
		 else if (isset($_SERVER['REMOTE_ADDR']) 
			 && $_SERVER['REMOTE_ADDR'] 
			 && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
			 $ip = $_SERVER['REMOTE_ADDR']; 
		 else { 
			 $ip = "unknown"; 
		 return $ip; 
			 } 
		 if ($type==1) {return md5($ip);} 
		 if ($type==0) {return $ip;}
	} 
	
	function activity_log($ACTION="",$REMARK="",$TIPE=""){	
		date_default_timezone_set('Asia/Jakarta');	
  // 		$data['USER_ID'] = $this->newsession->userdata('USER_ID');
  // 		$data['KODE_TRADER'] = $this->newsession->userdata('KODE_TRADER');
  // 		$data['IP_ADDRESS'] = $this->getIP(0);
  // 		$data['ACTIVITY_DATE'] = date('Y-m-d H:m:i');
  // 		$data['ACTION'] = $ACTION;
  // 		$data['REMARK'] = $REMARK;	
  // 		$data['TIPE'] = $TIPE;		
		// $this->db->insert('t_log_activity',$data);
		$data['id_user'] = $this->newsession->userdata('id_user');
		$data['action'] = $ACTION;
		$data['remark'] = $REMARK;
		$data['activity_date'] = date('Y-m-d H:m:i');
		$this->db->insert('tbl_logs',$data);
	}
	
	function revisi_log($ACTION="",$REMARK="",$KET=""){	
		date_default_timezone_set('Asia/Jakarta');	
  		$data['USER_ID'] = $this->newsession->userdata('USER_ID');
  		$data['KODE_TRADER'] = $this->newsession->userdata('KODE_TRADER');
  		$data['IP_ADDRESS'] = $this->getIP(0);
  		$data['ACTIVITY_DATE'] = date('Y-m-d H:m:i');
  		$data['ACTION'] = $ACTION;
  		$data['REMARK'] = $REMARK;	
  		$data['KETERANGAN'] = $KET;		
		$this->db->insert('t_log_revisi',$data);	
	}

	function cekWhere($sql){
		$ada = strpos(strtolower($sql), "where");
		if ( $ada === false )
			$dtWhere .= " WHERE ";
		else
			$dtWhere .= " AND ";
					
		return $dtWhere;	
	}
}