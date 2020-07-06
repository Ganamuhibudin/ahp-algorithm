<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register_act extends CI_Model{	

	function get_data(){
			$conn =& get_instance();
			$conn->load->model("main", "main", true);				
			$arrdata = array(
							'act' => 'proses',
							'judul' => 'Registrasi Perusahaan',
							'kode_id_trader' => $conn->main->get_mtabel('KODE_ID'),
            				'kode_api_trader' => $conn->main->get_mtabel('API'),
            				'JENIS_TPB' => $conn->main->get_mtabel('JENIS_TPB'),
            				'TIPE_TRADER' => $conn->main->get_mtabel('JENIS_EKSPORTIR'),
							'PROPINSI_GB' => $conn->main->get_combobox("SELECT KODE_DAERAH,URAIAN_DAERAH FROM M_DAERAH WHERE SUBSTRING(KODE_DAERAH,3,2)='00' ORDER BY URAIAN_DAERAH ","KODE_DAERAH","URAIAN_DAERAH", TRUE),
							'KOTA_GB' => $conn->main->get_combobox("SELECT KODE_DAERAH,URAIAN_DAERAH FROM M_DAERAH WHERE SUBSTRING(KODE_DAERAH,3,2)!='00' ORDER BY URAIAN_DAERAH ","KODE_DAERAH","URAIAN_DAERAH", TRUE),
							'JENIS_PLB' => $conn->main->get_combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PLB' AND KODE<>'01' ORDER BY KODE ","KODE","URAIAN", TRUE)
							);							 
			return $arrdata;
	}
	
	function setdata(){
		foreach($this->input->post('PENYELENGGARA') as $a => $b){
			$arrPenyelenggara[$a] = $b;
		}		
		$this->load->helper('email');
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
				$exec = $this->db->insert('m_trader_temp', $arrPenyelenggara);
				if($exec){
					$isi = '<p>Selamat '.$arrPenyelenggara["NAMA"].' , Anda telah berhasil melakukan registrasi.<br />
								Email dan no registrasi anda :<br />
								Email : '.$arrPenyelenggara["EMAIL_USER"].'<br />
								No registrasi : '.$NOREGISTRASI.'
							</p>								
							<p>Apabila Bapak/Ibu masih membutuhkan informasi lainnya terkait aplikasi PLB Inventory ini dapat menghubungi PIC kami sebagai berikut :</p>
							<ul>
								<li>Rossa 
									<ul>
										<li>Telp : +6221 650 5829 ext 8121</li>
										<li>Email : <a href="mailto:rossa@edi-indonesia.co.id">rossa@edi-indonesia.co.id</a></li>
									</ul>
								</li>		
								<li>Ginanjar Anggi Wiratmoko 
									<ul>
										<li>Telp : +6221 650 5829 ext 8211</li> 
										<li>Email : <a href="mailto:ginanjar@edi-indonesia.co.id">ginanjar@edi-indonesia.co.id</a></li>
									</ul>
								</li>
							</ul>		
							';												
					$this->send_mail($arrPenyelenggara["EMAIL_USER"],'', 'Konfirmasi Registrasi PLB Inventory', $isi);
					$ret =  "MSG#OK#Register perusahaan sukses. Silakan tunggu untuk proses persetujuan terlebih dahulu.#".site_url()."/#";
				}else{					
					$ret = "MSG#ERR#Register perusahaan Gagal#";
				}	 
			}else{
				$ret = "MSG#ERR#Password tidak sama.";
			}				
		}
		return $ret;
	}
	
	function send_mail($to, $nama, $subject, $isi,$flag=""){
		$this->load->library("phpmailer");
		$mailconfig = $this->config->config;
		$mailconfig = $mailconfig['mail_config'];
		$this->phpmailer->Config($mailconfig);
		$this->phpmailer->Subject = $subject;
		$path = "/home/inkaber/uploads/Formulir Belangganan Jasa EDI e-INKABER.xls";
		$email = explode(";", $to);
		foreach($email as $a){
			$this->phpmailer->AddAddress($a, '');
		}
		$logo = "PLB Inventory";
		$body = '<html><body bgcolor="#DDDDDD" style="background: #DDDDDD; padding: 0px; margin: 0px;">
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
												  <td><img src="'.base_url().'img/logo-login_2x.png" alt="'.$logo.'" border="no" style="margin: 0px; padding: 0px; display: block;"/></td>
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
												  '.$subject.'<br/><span style="color: #858585; font-size: 10px; text-decoration: none;">'.$_SERVER['HTTP_HOST'].'</span>
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
									  <td align="left" bgcolor="#FFFFFF" colspan="2" style="border-top: 12px solid #222222; border-right: none; border-bottom: none; border-left: none;"><table align="left" width="630" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td bgcolor="#F1F1F1" width="209" align="left" valign="top" style="border-right: 1px solid #DDDDDD;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; ">
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; font-weight: bold; color: #222222; padding-top: 16px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> Head Office</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> PT. EDI Indonesia</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 10px; padding-bottom: 20px; padding-left: 20px;"> Wisma SMR 1st, 3rd, 10th Floor<br>
													Jl Yos Sudaro Kav. 89<br>
													Jakarta 14350, Indonesia</td>
												</tr>
											  </table></td>
											<td bgcolor="#F1F1F1" width="210" align="left" valign="top" ><table width="210" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999;">
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; font-weight: bold; color: #222222; padding-top: 16px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> Browse online</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #222222; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;">&#8226; <a href="http://www.edi-indonesia.co.id/" title="Company Profile" target="_blank" style="color: #586BFC; text-decoration: none;">Company Profile</a></td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #222222; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;">&#8226; <a href="'.site_url().'" title="PLB Inventory" target="_blank" style="color: #586BFC; text-decoration: none;">PLB Inventory</a></td>
												</tr>
											  </table></td>
											<td bgcolor="#F1F1F1" width="209" align="left" valign="top" style="border-left: 1px solid #DDDDDD;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; ">
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; font-weight: bold; color: #222222; padding-top: 16px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"> Customer Support</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;">Phone : +6221 652 1010</td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 24px; padding-bottom: 0px; padding-left: 20px;"><a href="mailto:support@edi-indonesia.co.id" title="Company Profile" target="_blank" style="color: #586BFC; text-decoration: none;">support@edi-indonesia.co.id</a></td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 10px; padding-bottom: 0px; padding-left: 20px;"><a href="mailto:callcenter@edi-indonesia.co.id" title="Company Profile" target="_blank" style="color: #586BFC; text-decoration: none;">callcenter@edi-indonesia.co.id</a></td>
												</tr>
												<tr>
												  <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #999999; padding-top: 0px; padding-right: 1px; padding-bottom: 0px; padding-left: 20px;"><a href="mailto:it-inventory@edi-indonesia.co.id" title="Company Profile" target="_blank" style="color: #586BFC; text-decoration: none;">it-inventory@edi-indonesia.co.id</a></td>
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
}
?>