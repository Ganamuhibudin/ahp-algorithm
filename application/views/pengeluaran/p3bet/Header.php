<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<span id="DivHeaderForm">
	<form id="fp3bet" name="fp3bet" action="<?= site_url()."/pengeluaran/p3bet"; ?>" method="post" class="form-horizontal" autocomplete="off">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
		<input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"];?>" />
		<span id="divtmp"></span>
		<table width="100%" border="0">
			<tr>
            	<td width="45%" valign="top">
                	<table width="100%" border="0">
                        <h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5>
                        <tr>
                            <td>Kantor Pabean Pengawasan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text"  name="HEADER[KPBC_PENGAWAS]" id="kpbc_awas" value="<?= $sess['KPBC_PENGAWAS']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" urai="ur_kpbawas;" wajib="yes" onfocus="Autocomp(this.id)" class="stext date" maxlength="6" format="angka" <?=$readonly?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc','kpbc_awas;ur_kpbcawas','Kode Kpbc','fp3bet',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                                &nbsp;<span id="ur_kpbcawas"><?= $sess['URAIAN_KPBC_AWAS']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Kantor Pabean Pemuatan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text"  name="HEADER[KPBC_MUAT]" id="kpbc_muat" value="<?= $sess['KPBC_MUAT']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" urai="ur_kpbawas;" wajib="yes" onfocus="Autocomp(this.id)" class="stext date" maxlength="6" format="angka" <?=$readonly?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc','kpbc_muat;ur_kpbcmuat','Kode Kpbc','fp3bet',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                                &nbsp;<span id="ur_kpbcmuat"><?= $sess['URAIAN_KPBC_MUAT']; ?></span>
                            </td>
                        </tr>
                    	<tr>
                            <td>Tempat Stuffing</td>
                            <td>
                                <input type="text" name="HEADER[LOKASI_STUFFING]" id="LOKASI_STUFFING" value="<?= $sess['LOKASI_STUFFING']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$readonly?> >
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Tanggal Struffing</td>
                            <td width="69%">
                                <input type="text" name="HEADER[TANGGAL_STUFFING]" id="TANGGAL_STUFFING" onfocus="ShowDP('TANGGAL_STUFFING');" value="<?php echo $sess['TANGGAL_STUFFING']; ?>" class="form-control" style="width:100px" <?=$disabled?>/>
							</td>
                        </tr>
                        <tr>
                            <td width="30%">Tanggal Perkiraan Muat</td>
                            <td width="69%">
                                <input type="text" name="HEADER[TANGGAL_PERKIRAAN_MUAT]" id="TANGGAL_PERKIRAAN_MUAT" onfocus="ShowDP('TANGGAL_PERKIRAAN_MUAT');" value="<?php echo $sess['TANGGAL_PERKIRAAN_MUAT']; ?>" class="form-control" style="width:100px" <?=$disabled?>/>
                            </td>
                        </tr>
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
                            <td><combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_TRADER]', $kode_id_trader, $sess['KODE_ID_TRADER'], 'id="kode_id_trader" class="sstext" '.$disabled); ?> </combo>
                                <div class="input-group" style="width:3em; margin-bottom:0px;">
                               <input type="text" name="HEADER[ID_TRADER]" id="id_trader" value="<?php if($sess['ID_TRADER']=="5"){ echo $this->fungsi->FORMATNPWP($sess['ID_TRADER']);}else{ echo $sess['ID_TRADER']; } ?>" class="ltext" size="20" maxlength="15" <?=$readonly?> />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('PDPLB', 'kode_id_trader;id_trader;nama_trader;alamat_trader', 'PENGUSAHA', 'fp3bet', 600, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                          	</td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_TRADER]" id="nama_trader" value="<?= $sess['NAMA_TRADER']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$readonly?> >
                           	</td>
                        </tr> 
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_TRADER]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPengusaha')" <?=$disabled?>><?= $sess['ALAMAT_TRADER']; ?></textarea>
                            	<div id="limitAlamatPengusaha"></div>
                           	</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"  style="line-height:30px">
                            	<h5 class="smaller lighter blue"><b>PENERIMA BARANG</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_PENERIMA]" id="nama_penerima" value="<?= $sess['NAMA_PENERIMA']; ?>" wajib="yes" class="mtext" <?=$disabled?>/>
                           	</td>
                        </tr>
                        
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_PENERIMA]" id="alamat_penerima" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPemilik')" <?=$disabled?>><?= $sess['ALAMAT_PENERIMA']; ?></textarea>
                            	<div id="limitAlamatPemilik"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                                <h5 class="smaller lighter blue"><b>PEMILIK BARANG</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td><combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_PEMILIK]', $kode_id_trader, $sess['KODE_ID_PEMILIK'], 'id="kode_id_pemilik" class="sstext" '.$disabled); ?> </combo>
                                <div class="input-group" style="width:3em; margin-bottom:0px;">
                               <input type="text" name="HEADER[ID_PEMILIK]" id="id_pemilik" value="<?php if($sess['ID_PEMILIK']=="5"){ echo $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']);}else{ echo $sess['ID_PEMILIK']; } ?>" class="ltext" size="20" maxlength="15" <?=$readonly?> />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('PDPLB', 'kode_id_pemilik;id_pemilik;nama_pemilik;alamat_pemilik', 'PEMILIK', 'fp3bet', 600, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td>
                                <input type="text" name="HEADER[NAMA_PEMILIK]" id="nama_pemilik" value="<?= $sess['NAMA_PEMILIK']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$readonly?> >
                            </td>
                        </tr> 
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                                <textarea name="HEADER[ALAMAT_PEMILIK]" id="alamat_pemilik" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPemilik')" <?=$disabled?>><?= $sess['ALAMAT_PEMILIK']; ?></textarea>
                                <div id="limitAlamatPemilik"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA SARANA ANGKUT</b></h5></td>
                        </tr>
                        <tr>
                            <td>Moda Transportasi</td>
                            <td>
                                <combo><?= form_dropdown('HEADER[MODA]', $cara_angkut, $sess['MODA'], 'wajib="yes" id="cara_angkut" class="mtext" '.$disabled); ?></combo>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Sarana Angkut </td>
                            <td>
                                <input type="text" name="HEADER[NAMA_ANGKUT]" id="nama_angkut" value="<?= $sess['NAMA_ANGKUT']; ?>" wajib="yes" class="mtext"  <?=$readonly?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Voy/Flight </td>
                            <td>
                                <input type="text" name="HEADER[NOMOR_ANGKUT]" id="nomor_voy" value="<?= $sess['NOMOR_ANGKUT']; ?>" class="mtext" maxlength="7" wajib="yes" <?=$readonly?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Call Sign </td>
                            <td>
                                <input type="text" name="HEADER[CALL_SIGN]" id="nomor_voy" value="<?= $sess['CALL_SIGN']; ?>" class="mtext" maxlength="7" wajib="yes" <?=$readonly?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Negara Tujuan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[NEGARA_TUJUAN]" id="negara_tujuan" value="<?= $sess['NEGARA_TUJUAN']; ?>" class="ssstext" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" urai="urbendera;"  <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','negara_tujuan;urbendera','Kode Negara','fp3bet',650,400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>&nbsp;<span id="urbendera"><?= $sess['URAIAN_NEGARA_TUJUAN']; ?></span>
                            </td>
                        </tr>
                   	</table>
             	</td>
                <td width="55%" valign="top">
                    <table width="100%" border="0">                    
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PELABUHAN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Muat </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[KODE_PEL_MUAT]" id="pelabuhan_muat" value="<?= $sess['KODE_PEL_MUAT']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_muat;" class="sstext date" wajib="yes" maxlength="5" <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan','pelabuhan_muat;urpelabuhan_muat','Kode Pelabuhan','fp3bet',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_muat"><?= $sess['UR_PELABUHAN_MUAT']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Bongkar</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[KODE_PEL_BONGKAR]" id="pelabuhan_bongkar" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_bongkar;" class="stext date" value="<?= $sess['KODE_PEL_BONGKAR']; ?>" maxlength="5" <?=$readonly?> wajib="yes" />
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan','pelabuhan_bongkar;urpelabuhan_bongkar','Kode Pelabuhan','fp3bet',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_bongkar"><?= $sess['UR_PELABUHAN_BONGKAR']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Tujuan </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[KODE_PEL_TUJUAN]" id="pelabuhan_tujuan" value="<?= $sess['KODE_PEL_TUJUAN']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan/dalam" onfocus="Autocomp(this.id)" urai="urpelabuhan_tujuan;" class="stext date" wajib="yes" maxlength="5" <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan','pelabuhan_tujuan;urpelabuhan_tujuan','Kode Pelabuhan','fp3bet',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_tujuan"><?= $sess['UR_PELABUHAN_TUJUAN']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                             	<h5 class="smaller lighter blue"><b>INFORMASI LAIN</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor BC 1.1 </td>
                            <td>
                                <input type="text" name="HEADER[NOMOR_BC11]" id="nomor_bc11" class="stext" value="<?= $sess['NOMOR_BC11']; ?>" maxlength="30" wajib="yes" <?=$disabled?>/>
                          	</td>
                        </tr>
                        <tr>
                            <td>Tanggal BC 1.1</td>
                            <td>
                                <input type="text" name="HEADER[TANGGAL_BC11]" id="tanggal_bc11" onfocus="ShowDP('tanggal_bc11');" value="<?php echo $sess['TANGGAL_BC11']; ?>" class="sstext" <?=$disabled?>/>
                              
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor POS </td>
                            <td>
                                <input type="text" name="HEADER[NOMOR_POS]" id="nomor_pos" class="stext" value="<?= $sess['NOMOR_POS']; ?>" maxlength="30" wajib="yes" <?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor Sub POS </td>
                            <td>
                                <input type="text" name="HEADER[NOMOR_SUB_POS]" id="nomor_sub_pos" class="stext" value="<?= $sess['NOMOR_SUB_POS']; ?>" maxlength="30" wajib="yes" <?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Bruto </td>
                            <td><input type="text" name="BRUTOUR" id="BRUTOUR" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'],2); ?>" class="stext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('BRUTO',this.value,2);"  <?=$readonly?>/>&nbsp; Kilogram (KGM)
                            <input type="hidden" name="HEADER[BRUTO]" id="BRUTO" value="<?= $sess['BRUTO']?>" /></td>
                        </tr>
                        <tr>
                            <td>Jumlah Tanda Pengaman </td>
                            <td><input type="text" name="UR_JUMLAH_TANDA_PENGAMAN" id="UR_JUMLAH_TANDA_PENGAMAN" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_TANDA_PENGAMAN'],2); ?>" class="stext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('JUMLAH_TANDA_PENGAMAN',this.value,2);"  <?=$readonly?>/>
                            <input type="hidden" name="HEADER[JUMLAH_TANDA_PENGAMAN]" id="JUMLAH_TANDA_PENGAMAN" value="<?= $sess['JUMLAH_TANDA_PENGAMAN']?>" /></td>
                        </tr>
                        <tr>
                            <td>Jenis Tanda Pengaman </td>
                            <td>
                                <input type="text" name="HEADER[JENIS_TANDA_PENGAMAN]" id="JENIS_TANDA_PENGAMAN" class="stext" value="<?= $sess['JENIS_TANDA_PENGAMAN']; ?>" maxlength="30" wajib="yes" <?=$disabled?>/>
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
                            	<input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" onfocus="ShowDP('tanggal_ttd');" value="<?php if($act=="save") echo date("Y-m-d"); else echo $sess['TANGGAL_TTD']; ?>" class="sstext" <?=$disabled?>/>&nbsp; YYYY-MM-DD
                              
                            </td>
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
                	<a href="javascript:void(0);" class="btn btn-success btn-l" id="ok_" onclick="save_header('#fp3bet');"><i class="icon-save"></i>&nbsp;<?=ucwords($act)?></a>&nbsp;
                    <a href="javascript:;" class="btn btn-warning btn-l" id="cancel_" onclick="cancel('fp3bet');"><i class="icon-undo"></i>Reset</a>&nbsp;
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
<? if($priview){ ?>
$('#fp3bet input:visible, #fp3bet select').attr('disabled',true);
<? } ?>
</script>