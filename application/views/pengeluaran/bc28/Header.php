<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<span id="DivHeaderForm">
	<form id="fbc28" name="fbc28" action="<?= site_url()."/pengeluaran/bc28"; ?>" method="post" class="form-horizontal" autocomplete="off">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
		<input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"];?>" />
		<input type="hidden" name="HEADERDOK[NOMOR_AJU]" id="noajudok" value="<?= $aju;?>" />
		<span id="divtmp"></span>
		<table width="100%" border="0">
			<tr>
            	<td width="45%" valign="top">
                	<table width="100%" border="0">
                    	<tr>
                            <td>Kantor Pabean </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                            	<input type="text"  name="HEADER[KODE_KANTOR_PABEAN]" id="kpbc_daftar" value="<?= $sess['KODE_KANTOR_PABEAN']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)" class="stext date" maxlength="6" format="angka" <?=$readonly?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc','kpbc_daftar;urkt','Kode Kpbc','fbc28',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                            	&nbsp;<span id="urkt"><?= $sess['URAIAN_KODE_KANTOR_PABEAN']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KODE_KANTOR_PABEAN']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Jenis BC 2.8</td>
                            <td width="69%">
								<combo><?= form_dropdown('HEADER[JENIS_BC28]', $jenis_bc28, $sess['JENIS_BC28'], 'id="jenis_tpb" class="mtext"  wajib="yes" '.$disabled); ?></combo>
							</td>
                        </tr>
                        <tr>
                            <td>Jenis Impor</td>
                            <td>
								<combo><?= form_dropdown('HEADER[JENIS_IMPOR]', $jenis_impor, $sess['JENIS_IMPOR'], 'id="jenis_tpb" class="mtext"  wajib="yes" '.$disabled); ?></combo>
							</td>
                        </tr>
                        <tr>
                        	<td>Cara Pembayaran</td>
                            <td>
								<combo><?= form_dropdown('HEADER[CARA_PEMBAYARAN]', $cara_pembayaran, $sess['CARA_PEMBAYARAN'], 'id="CARA_PEMBAYARAN" class="mtext" '.$disabled); ?></combo>
							</td>
                     	</tr>
                        <tr><td>&nbsp;</td><td><span id="4th"></span></td></tr>
					</table>
				<td width="55%" valign="top">
					<h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5>
                    <table width="80%">
                        <tr>
                            <td>Nomor Pendaftaran</td>
                            <td>
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                                <input type="hidden" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6"  <?=$readonly?>/>
                                <input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN_EDIT]" id="NOMOR_PENDAFTARAN_EDIT" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6"  <?=$readonly?>/>
							<?php }else{?>
                            	<input type="text" disabled="disabled" class="stext date" maxlength="6" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>"/>
							<?php }?>
                         	</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran</td>
                            <td>
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                                <input type="hidden" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"  <?=$readonly?>/>
                            	<input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN_EDIT]" id="TANGGAL_PENDAFTARAN_EDIT" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"  <?=$readonly?>/>
                            <?php }else{?>
                            	<input type="text" disabled="disabled" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"/><?php }?>&nbsp;YYYY-MM-DD
                        	</td>
                        </tr>
                        <tr>
                            <td>No. Persetujuan Pengeluaran</td>
                            <td>
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                            	<input type="text" name="HEADERDOK[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" maxlength="30"  <?=$readonly?>/>
							<?php }else{?>
                            	<input type="text" disabled="disabled" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" />
							<?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Persetujuan Pengeluaran</td>
                            <td>
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                            	<input type="text" name="HEADERDOK[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="stext date" value="<?= ($sess['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$sess['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');"  <?=$readonly?>/>
                            <?php }else{?>
                            	<input type="text" disabled="disabled" class="stext date" value="<?= ($sess['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$sess['TANGGAL_DOK_PABEAN']; ?>"/>
							<?php }?>&nbsp;YYYY-MM-DD
                            </td>
                        </tr>
                    </table>
				</td>
        	</tr>
    	</table>
        <h5 class="header smaller lighter green"><b>DATA PEMBERITAHUAN</b></h5>
        <table width="100%" border="0">
			<tr>
            	<td width="45%" valign="top">
					<table width="100%" border="0">
						<tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>PENGUSAHA PLB/PDLB</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td><combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_PENGUSAHA]', $kode_id_trader, $sess['KODE_ID_PENGUSAHA'], 'id="kode_id_pengusaha" class="sstext" '.$disabled); ?> </combo>
                                <div class="input-group" style="width:3em; margin-bottom:0px;">
                               <input type="text" name="HEADER[ID_PENGUSAHA]" id="id_pengusaha" value="<?php if($sess['ID_PENGUSAHA']=="5"){ echo $this->fungsi->FORMATNPWP($sess['ID_PENGUSAHA']);}else{ echo $sess['ID_PENGUSAHA']; } ?>" class="ltext" size="20" maxlength="15" <?=$readonly?> />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('PDPLB', 'kode_id_pengusaha;id_pengusaha;nama_pengusaha;ALAMAT_PENGUSAHA', 'PENGUSAHA', 'fbc28', 600, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                          	</td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_PENGUSAHA]" id="nama_pengusaha" value="<?= $sess['NAMA_PENGUSAHA']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$readonly?> > <!--onclick="tb_search('PDPLB', 'kode_id_pengusaha;id_pengusaha;nama_pengusaha;ALAMAT_PENGUSAHA', 'penerima', 'fbc28', 600, 400)"-->
                           	</td>
                        </tr> 
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_PENGUSAHA]" id="ALAMAT_PENGUSAHA" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPengusaha')" <?=$disabled?>><?= $sess['ALAMAT_PENGUSAHA']; ?></textarea>
                            	<div id="limitAlamatPengusaha"></div>
                           	</td>
                        </tr>
                        
                        <tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>PENJUAL</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td>
								<combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_PENJUAL]', $kode_id_trader, $sess['KODE_ID_PENJUAL'], 'id="kode_id_penjual" class="sstext" '.$disabled); ?> </combo>
								<div class="input-group" style="width:3em; margin-bottom:0px;">
                                    <input type="text" name="HEADER[ID_PENJUAL]" id="kode_penjual" value="<?php if($sess['ID_PENJUAL']=="5"){ echo $this->fungsi->FORMATNPWP($sess['ID_PENJUAL']);}else{ echo $sess['ID_PENJUAL']; } ?>" class="ltext" size="20" maxlength="15" <?=$readonly?> />
                                    <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pembeli', 'nama_penjual;ALAMAT_PENJUAL;negara_penjual;urnegara_asalpenjual', 'PENJUAL', 'fbc28', 600, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_PENJUAL]" id="nama_penjual" value="<?= $sess['NAMA_PENJUAL']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$readonly?>/>
                           	</td>
                        </tr> 
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_PENJUAL]" id="ALAMAT_PENJUAL" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamaPenjual')" <?=$disabled?>><?= $sess['ALAMAT_PENJUAL']; ?></textarea>
                            	<div id="limitAlamaPenjual"></div>
                           	</td>
                        </tr>
                        <tr>
                            <td valign="top">Negara</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="HEADER[NEGARA_PENJUAL]" id="negara_penjual" value="<?= $sess['NEGARA_PENJUAL']; ?>" url="<?=site_url();?>/autocomplete/negara" onfocus="Autocomp(this.id)" class="ssstext ac_input" urai="urnegara_asalpenjual;" wajib="yes" autocomplete="off">
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','negara_penjual;urnegara_asalpenjual','Kode Negara','fbc28',650,470)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urnegara_asalpenjual"><?=$sess["URAIAN_NEGARA_PENJUAL"]?></span>
                           	</td>
                        </tr>
                        
                        <tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>IMPORTIR</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td>
								<combo><?= form_dropdown('HEADER[KODE_ID_IMPORTIR]', $kode_id_trader, $sess['KODE_ID_IMPORTIR'], 'id="kode_id_importir" class="sstext" '.$disabled); ?> </combo>
								<input type="text" name="HEADER[ID_IMPORTIR]" id="id_importir" value="<?= $this->fungsi->FORMATNPWP($sess['ID_IMPORTIR']); ?>" class="ltext" size="20" maxlength="15" <?=$readonly?>/>
                          	</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_IMPORTIR]" id="nama_importir" value="<?= $sess['NAMA_IMPORTIR']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$readonly?>/>
                           	</td>
                        </tr> 
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_IMPORTIR]" id="ALAMAT_IMPORTIR" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamaImportir')" <?=$disabled?>><?= $sess['ALAMAT_IMPORTIR']; ?></textarea>
                            	<div id="limitAlamaImportir"></div>
                           	</td>
                        </tr>
                        <tr>
                        	<td>Status</td>
                        	<td>
                        		<combo><?= form_dropdown('HEADER[STATUS_IMPORTIR]', array('1'=>'1- AEO','2'=>'2- Mitra Utama','3'=>'3- Lainnya'), $sess['STARUS_IMPORTIR'], 'id="STARUS_IMPORTIR" class="sstext" '.$disabled); ?></combo>
                                <input type="text" name="HEADER[NIK_IMPORTIR]" id="NIK_IMPORTIR" value="<?= $sess['NIK_IMPORTIR']; ?>" class="ltext" <?=$disabled?>/>
                        	</td>
                        </tr>
                        <tr>
                            <td>APIU/P</td>
                            <td>
								<combo><?= form_dropdown('HEADER[KODE_API]', $kode_api, $sess['KODE_API'], 'id="KODE_API" class="sstext" '.$disabled); ?></combo>
								<input type="text" name="HEADER[NOMOR_API]" id="NOMOR_API" value="<?= $sess['NOMOR_API']; ?>" class="ltext" <?=$disabled?>/>
                          	</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"  style="line-height:30px">
                            	<h5 class="smaller lighter blue"><b>PEMILIK BARANG</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td>
								<combo><?= form_dropdown('HEADER[KODE_ID_PEMILIK]', $kode_id, $sess['KODE_ID_PEMILIK'], 'id="KODE_ID_PEMILIK" class="sstext"  '.$disabled); ?> </combo>
								<input type="text" name="HEADER[ID_PEMILIK]" id="ID_PEMILIK" value="<?php if($sess['KODE_ID_PEMILIK']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']);}else{ echo $sess['ID_PEMILIK'];}?>" class="ltext" size="20" wajib="yes" maxlength="20"<?=$disabled?>/>&nbsp;<a class="btn btn-sm btn-danger" style="height:19pt; vertical-align:top;" title="Copy dari PDPLB" onclick="copydataPDPLB();" href="javascript:void(0)"><i class="icon-copy"></i>&nbsp;Copy Data Importir</a>
                          	</td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_PEMILIK]" id="NAMA_PEMILIK" value="<?= $sess['NAMA_PEMILIK']; ?>" wajib="yes" class="mtext" <?=$disabled?>/>
                           	</td>
                        </tr>
                        
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_PEMILIK]" id="ALAMAT_PEMILIK" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPemilik')" <?=$disabled?>><?= $sess['ALAMAT_PEMILIK']; ?></textarea>
                            	<div id="limitAlamatPemilik"></div>
                            </td>
                        </tr>
                   	</table>
             	</td>
                <td width="55%" valign="top">
                    <table width="100%" border="0">
                    	 <tr>
                        	<td>Tempat Timbun</td>
                            <td><div class="input-group" style="width:3em; margin-bottom:-20px;">
                                    <input type="text" maxlength="4" wajib="yes" class="stext date" urai="urtempat_timbun;" onfocus="Autocomp(this.id)" url="<?=site_url();?>/autocomplete/timbun" value="<?=$sess["KODE_TIMBUN"]?>" id="tempat_timbun" name="HEADER[KODE_TIMBUN]">
                                    <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('timbun','tempat_timbun;urtempat_timbun','Kode Timbun','fbc28',650,470)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urtempat_timbun" style="margin-left:120px"><?=$sess["URAIAN_TIMBUN"]?></span>
							</td>
                        </tr>
                        <tr>
                            <td>Moda Transportasi</td>
                            <td>
								<combo><?= form_dropdown('HEADER[MODA]', $cara_angkut, $sess['MODA'], 'wajib="yes" id="cara_angkut" class="mtext" '.$disabled); ?></combo>
                           	</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                             	<h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Valuta Asing </td>
                            <td><div class="input-group" style="width:3em; margin-bottom:0px; float:left">
                                    <input type="text" name="HEADER[KODE_VALUTA]" id="kode_valuta" value="<?= $sess['KODE_VALUTA']?>" class="stext date" url="<?= site_url(); ?>/autocomplete/valuta" urai="valuta;kdvaluta;" wajib="yes" onfocus="Autocomp(this.id)"<?=$disabled?>/>
                                    <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('valuta','kode_valuta;valuta','Kode Valuta','fbc28',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="valuta"><?= $sess['URAIAN_VALUTA'] ?></span>
                          	</td>
                        </tr>
                        <tr>
                            <td>NDPBM (Kurs) </td>
                            <td>
                               <input type="text" name="NILAI_NDPBM" id="ndpbm_nilai" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['NDPBM'],4); ?>" maxlength="30" wajib="yes" onkeyup="this.value = ThausandSeperator('ndpbm',this.value,4);ProsesHeader()"<?=$disabled?>/>
                               <input type="hidden" name="HEADER[NDPBM]" id="ndpbm" value="<?= $sess['NDPBM']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Nilai </td>
                            <td>
                            	<combo><?= form_dropdown('HEADER[JENIS_NILAI]', $jenis_nilai, $sess['JENIS_NILAI'], 'id="jenis_nilai" class="mtext date" '.$disabled); ?></combo>
                            </td>
                        </tr>
                        <tr>
                        	<td>Nilai</td>
                            <td>
                            	<combo><?= form_dropdown('HEADER[NILAI]', $kode_harga, $sess['NILAI'], 'id="kode_harga" class="mtext date" '.$disabled); ?></combo>
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai CIF <span id="kdvaluta" style="padding-left:55px;"></span></td>
                            <td>
                               <input type="text" name="CIF_TARIF" id="cifTarif" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['NILAI_CIF'],2); ?>" maxlength="30" wajib="yes" onkeyup="this.value = ThausandSeperator('cif',this.value,2);ProsesHeader();" <?=$disabled?>/>
                               <input type="hidden" name="HEADER[NILAI_CIF]" id="cif" value="<?= $sess['NILAI_CIF']?>" <?=$disabled?>/>
                            </td>
                        </tr>
                    	<tr>
                            <td><span style="float:right">Rp</span></td>
                            <td>
                                <input type="text"  id="CIFRPUR" name="CIFRPUR" class="mtext" readonly value="<?= $this->fungsi->FormatRupiah($sess['CIF_RP'],4) ?>" >
                                <input type="hidden" name="HEADER[CIF_RP]" id="CIF_RP" value="<?= $sess['CIF_RP']?>" <?=$disabled?>/>
                            </td>
  		             	</tr>
                        <tr>
                            <td>Bruto </td>
                            <td>
                            	<input type="text" name="brutour" id="brutour" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'],2); ?>" class="stext date" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('bruto',this.value,2)"<?=$disabled?>/>&nbsp; Kilogram (KGM)
                            	<input type="hidden" name="HEADER[BRUTO]" id="bruto" value="<?= $sess['BRUTO']?>" <?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td class="rowheight">Netto</td>
                            <td><?= $sess['JUM_NETTO']; ?>&nbsp; Kilogram (KGM)
                            	<input type="hidden" name="HEADER[NETTO]" value="<?= $sess['JUM_NETTO']; ?>" class="text" wajib="yes"<?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Otomatis terisi dari jumlah total Netto Detil Barang</td>
                        </tr>
                        <tr>
                        	<td>Pembayaran</td>
                            <td>
                            	<combo><?= form_dropdown('HEADER[KODE_PEMBAYARAN]', $methode_bayar, $sess['KODE_PEMBAYARAN'], 'id="kode_harga" class="mtext date" '.$disabled); ?></combo>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>PENANDATANGANAN</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[PEMBERITAHU]" id="nama_ttd" value="<?= $sess['PEMBERITAHU']; ?>" class="mtext" <?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>
                            	<input type="text" name="HEADER[JABATAN]" id="nama_ttd" value="<?= $sess['JABATAN']; ?>" class="mtext" <?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td>
                            	<input type="text" name="HEADER[KOTA_TTD]" id="kota_ttd" value="<?= $sess['KOTA_TTD']; ?>" class="mtext" <?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>
                            	<div class="input-group" style="width:3em;float:left"><input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" onfocus="ShowDP('tanggal_ttd');" value="<?php if($act=="save") echo date("Y-m-d"); else echo $sess['TANGGAL_TTD']; ?>" class="form-control" style="width:150px" <?=$disabled?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD
                              
                            </td>
                        </tr>
                    </table>
             	</td>
          	</tr>
            <tr>
            	<td colspan="2">
                	<h5 class="smaller lighter blue"><b>DATA PUNGUTAN :</b></h5>
                    <table border="0" width="100%" cellpadding="5" cellspacing="0" class="table-striped table-bordered no-margin-bottom">
                        <tr>
                            <td width="10%"  align="center" class="border-brlt">Jenis Pungutan</td>
                            <td width="15%" align="center" class="border-brt">Dibayar (Rp) </td>
                            <td width="15%" align="center" class="border-brt">Ditanggung (Rp)</td>
                            <td width="15%" align="center" class="border-brt">Ditunda (Rp)</td>
                            <td width="15%" align="center" class="border-brt">Tdk Dpgt (Rp)</td>
                            <td width="15%" align="center" class="border-brt">Dibebaskan (Rp)</td>
                            <td width="15%" align="center" class="border-brt">Sudah Dilunasi (Rp)</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;" class="border-brl">BM</td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$A =($sess['PGT_BM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$AA =($sess['PGT_BM_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_DIT_PEM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$AAA =($sess['PGT_BM_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_DITUNDA'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$AAAA =($sess['PGT_BM_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_TDK_DIPUNGUT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$AAAAA =($sess['PGT_BM_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_BEBAS'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$AAAAAA =($sess['PGT_BM_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_LUNAS'],0):0;?></td>
                        </tr>                        
                        <tr>
                            <td style="padding-left:20px;" class="border-brl">BM KITE</td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$B =($sess['PGT_BMKITE']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$BB =($sess['PGT_BMKITE_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_DIT_PEM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$BBB =($sess['PGT_BMKITE_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_DITUNDA'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$BBBB =($sess['PGT_BMKITE_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_TDK_DIPUNGUT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$BBBBB =($sess['PGT_BMKITE_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_BEBAS'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$BBBBBB =($sess['PGT_BMKITE_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_LUNAS'],0):0;?></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;" class="border-brl">BMT</td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$C =($sess['PGT_BMT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$CC =($sess['PGT_BMT_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_DIT_PEM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$CCC =($sess['PGT_BMT_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_DITUNDA'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$CCCC =($sess['PGT_BMT_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_TDK_DIPUNGUT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$CCCCC =($sess['PGT_BMT_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_BEBAS'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$CCCCCC =($sess['PGT_BMT_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_LUNAS'],0):0;?></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;" class="border-brl">Cukai</td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$D =($sess['PGT_CUKAI']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$DD =($sess['PGT_CUKAI_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_DIT_PEM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$DDD =($sess['PGT_CUKAI_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_DITUNDA'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$DDDD =($sess['PGT_CUKAI_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_TDK_DIPUNGUT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$DDDDD =($sess['PGT_CUKAI_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_BEBAS'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$DDDDDD =($sess['PGT_CUKAI_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_LUNAS'],0):0;?></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;" class="border-brl">PPN</td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$E =($sess['PGT_PPN']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$EE =($sess['PGT_PPN_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_DIT_PEM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$EEE =($sess['PGT_PPN_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_DITUNDA'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$EEEE =($sess['PGT_PPN_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_TDK_DIPUNGUT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$EEEEE =($sess['PGT_PPN_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_BEBAS'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$EEEEEE =($sess['PGT_PPN_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_LUNAS'],0):0;?></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;" class="border-brl">PPnBM</td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$F =($sess['PGT_PPNBM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$FF =($sess['PGT_PPNBM_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_DIT_PEM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$FFF =($sess['PGT_PPNBM_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_DITUNDA'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$FFFF =($sess['PGT_PPNBM_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_TDK_DIPUNGUT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$FFFFF =($sess['PGT_PPNBM_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_BEBAS'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$FFFFFF =($sess['PGT_PPNBM_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_LUNAS'],0):0;?></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;" class="border-brl">PPh</td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$G =($sess['PGT_PPH']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$GG =($sess['PGT_PPH_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_DIT_PEM'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$GGG =($sess['PGT_PPH_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_DITUNDA'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$GGGG =($sess['PGT_PPH_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_TDK_DIPUNGUT'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$GGGGG =($sess['PGT_PPH_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_BEBAS'],0):0;?></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><?=$GGGGGG =($sess['PGT_PPH_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_LUNAS'],0):0;?></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;" class="border-brl"><strong>TOTAL</strong></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$A)+str_replace(',','',$B)+str_replace(',','',$C)+str_replace(',','',$D)+str_replace(',','',$E)+str_replace(',','',$F)+str_replace(',','',$G),0)?></b></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AA)+str_replace(',','',$BB)+str_replace(',','',$CC)+str_replace(',','',$DD)+str_replace(',','',$EE)+str_replace(',','',$FF)+str_replace(',','',$GG),0)?></b></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAA)+str_replace(',','',$BBB)+str_replace(',','',$CCC)+str_replace(',','',$DDD)+str_replace(',','',$EEE)+str_replace(',','',$FFF)+str_replace(',','',$GGG),0)?></b></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAAA)+str_replace(',','',$BBBB)+str_replace(',','',$CCCC)+str_replace(',','',$DDDD)+str_replace(',','',$EEEE)+str_replace(',','',$FFFF)+str_replace(',','',$GGGG),0)?></b></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAAAA)+str_replace(',','',$BBBBB)+str_replace(',','',$CCCCC)+str_replace(',','',$DDDDD)+str_replace(',','',$EEEEE)+str_replace(',','',$FFFFF)+str_replace(',','',$GGGGG),0)?></b></td>
                            <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAAAAA)+str_replace(',','',$BBBBBB)+str_replace(',','',$CCCCCC)+str_replace(',','',$DDDDDD)+str_replace(',','',$EEEEEE)+str_replace(',','',$FFFFFF)+str_replace(',','',$GGGGGG),0)?></b></td>
                        </tr>
                	</table>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php if(!$priview){?>
            <tr>
                <td colspan="2">
                	<a href="javascript:void(0);" class="btn btn-success btn-l" id="ok_" onclick="save_header('#fbc28');"><i class="icon-save"></i>&nbsp;<?=ucwords($act)?></a>&nbsp;
                    <a href="javascript:;" class="btn btn-warning btn-l" id="cancel_" onclick="cancel('fbc28');"><i class="icon-undo"></i>Reset</a>&nbsp;
                    <span class="msgheader_" style="margin-left:20px">&nbsp;</span>
                </td>
            </tr>
            <?php } ?>
    	</table>
	</form>
</span>
<?php  
if($priview){
	echo $DETILPRIVIEW;
} 
?>
<script>
$(function(){FormReady();})
$(document).ready(function(){
	// jkwaktu();
});
function copydataPDPLB(){
	$("#KODE_ID_PEMILIK").val($("#kode_id_importir").val());
	$("#ID_PEMILIK").val($("#id_importir").val());
	$("#NAMA_PEMILIK").val($("#nama_importir").val());
	$("#ALAMAT_PEMILIK").val($("#ALAMAT_IMPORTIR").val());
}
// function jkwaktu(){
// 	if($('#jenis_impor').val()=='2'){
// 		$('#jangkawaktu').show();
// 	}else{
// 		$('#jangkawaktu').hide();
// 	}
// }
<? if($priview){ ?>
$('#fbc28 input:visible, #fbc28 select').attr('disabled',true);
<? } ?>
</script>