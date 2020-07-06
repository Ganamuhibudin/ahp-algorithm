<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<span id="DivHeaderForm">
	<form id="fbc40_" action="<?= site_url()."/pemasukan/bc40"; ?>" method="post" autocomplete="off">
        <input type="hidden" readonly name="act" id="act" value="<?= $act;?>" />
        <input type="hidden" readonly name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
        <input type="hidden" readonly name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"];?>" />
        <input type="hidden" readonly name="HEADERDOK[NOMOR_AJU]" id="noajudok" value="<?= $aju;?>" />
        <input type="hidden" readonly name="DOKUMEN" value="<?=$dokumen?>"/> 
        <input type="hidden" readonly name="TEMPAT_ASAL" value="<?=$tmp_asal?>"/> 
        <input type="hidden" readonly name="JENIS_BARANG" value="<?=$jns_barang?>"/> 
		<span id="divtmp"></span>
		<table width="100%" border="0">
			<tr>
            	<td width="45%" valign="top">	
					<table width="100%" border="0">
						<?php if($sess['NOMOR_AJU']){?>
                        <tr>
                            <td>Nomor Aju</td>
                            <td><?=$this->fungsi->FormatAju($sess["NOMOR_AJU"]);?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td width="32%" >Kantor Pabean</td>
                            <td width="68%">
                            <div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                            <input type="text"  name="HEADER[KODE_KPBC]" id="kode_kpbc" class="stext date" value="<?= $sess['KODE_KPBC']; ?>" url="<?= site_url()?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)"/>
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc','kode_kpbc;urkt','Kode Kpbc','fbc40_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                            </div> &nbsp;
                            <span id="urkt"><?= $sess['URAIAN_KPBC']?$sess['URAIAN_KPBC']:$URKANTOR_TUJUAN; ?></span> </td>
                        </tr>
                        <tr>
                            <td>Jenis TPB</td>
                            <td><combo><?= form_dropdown('HEADER[JENIS_TPB]', $jenis_tpb, $sess['JENIS_TPB'], 'id="tujuan" class="text" wajib="yes" '); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Tujuan Pengiriman</td>
                            <td><combo><?= form_dropdown('HEADER[TUJUAN_KIRIM]', $tujuan_kirim, $sess['TUJUAN_KIRIM'], 'id="tujuan_kirim" class="text" wajib="yes" '); ?></combo></td>
                        </tr>
					</table>
				</td>
                <td width="55%" valign="top">
                	<h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5>
                    <table width="80%">
                        <tr>
                            <td>Nomor Pendaftaran*</td>
                            <td>
                            <? if($sess['STATUS_DOK']=="LENGKAP"){?>
                            <input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="8" /><? }else{?><input type="text" disabled="disabled" class="stext date" maxlength="8" /><? }?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran*</td>
                            <td>
                            <? if($sess['STATUS_DOK']=="LENGKAP"){?>
                            <input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= ($sess['TANGGAL_PENDAFTARAN']=='0000-00-00')?'':$sess['TANGGAL_PENDAFTARAN']; ?>"/>
                            <? }else{?><input type="text" disabled="disabled" class="stext date"/><? }?>&nbsp; YYYY-MM-DD</td>
                        </tr>
                        <tr>
                            <td>No. Persetujuan Pemasukan</td>
                            <td>
                            <? if($sess['STATUS_DOK']=="LENGKAP"){?>
                            <input type="text" name="HEADERDOK[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" maxlength="30" /><? }else{?><input type="text" disabled="disabled" class="text" value="" /><? }?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Persetujuan Pemasukan</td>
                            <td>
                            <? if($sess['STATUS_DOK']=="LENGKAP"){?>
                            <input type="text" name="HEADERDOK[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="stext date" value="<?= ($sess['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$sess['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');"/>
                            <? }else{?><input type="text" disabled="disabled" class="stext date" value="" /><? }?>&nbsp; YYYY-MM-DD</td>
                        </tr>
                         <tr>
                            <td>Nama Pejabat BC</td>
                            <td>
                            <? if($sess['STATUS_DOK']=="LENGKAP"){?>
                            <input type="text" name="HEADERDOK[NAMA_PEJABAT_BC]" id="NAMA_PEJABAT_BC" class="text" value="<?= $sess['NAMA_PEJABAT_BC']; ?>" />
                            <? }else{?><input type="text" disabled="disabled" class="text" value="" /><? }?></td>
                        </tr>
                         <tr>
                            <td>NIP Pejabat BC</td>
                            <td>
                            <? if($sess['STATUS_DOK']=="LENGKAP"){?>
                            <input type="text" name="HEADERDOK[NIP_PEJABAT_BC]" id="NIP_PEJABAT_BC" class="text" value="<?= $sess['NIP_PEJABAT_BC']; ?>"/>
                            <? }else{?><input type="text" disabled="disabled" class="text" value="" /><? }?></td>
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
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>PENGUSAHA TPB</b></h5></td>
                        </tr>
                        <tr>
                            <td width="33%">Identitas</td>
                            <td width="67%"><combo><?= form_dropdown('HEADER[KODE_ID_TRADER]', $kode_id, $sess['KODE_ID_TRADER'], 'id="kode_id" class="sstext" '); ?></combo> 
                            <input type="hidden" name="HEADER[KODE_TRADER]" id="KODE_TRADER" value="<?= $sess['KODE_TRADER']; ?>" class="stext" wajib="yes" maxlength="15" />
                            <input type="text" name="HEADER[ID_TRADER]" id="id_trader" value="<?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?>" class="ltext" size="20" wajib="yes" maxlength="15"/>
                            </td>
                        </tr> 
                        <tr>
                            <td class="top">Nama </td>
                            <td><input type="text" name="HEADER[NAMA_TRADER]" id="nama_trader" value="<?= $sess['NAMA_TRADER']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" class="mtext" wajib="yes"/></td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat </td>
                            <td><textarea name="HEADER[ALAMAT_TRADER]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')"><?= $sess['ALAMAT_TRADER']; ?></textarea>
                            <div id="limitAlamatTrader"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="top">No Ijin TPB </td>
                            <td><input type="text" name="HEADER[NOMOR_IZIN_TPB]" id="nomor_izin_tpb" value="<?= $sess['NOMOR_IZIN_TPB']?$sess['NOMOR_IZIN_TPB']:$sess['NOMOR_SKEP']; ?>" maxlength="30" class="mtext" wajib="yes"/>
                            </td>
                        </tr>
                       <!-- <tr>
                            <td colspan="3" class="rowheight"><h5>Riwayat Barang</h5></td>
                        </tr>
                        <tr>			<td>Nomor BC 4.0 Asal</td>
                            <td><input type="text" name="HEADERX[NOMOR_BC]" id="nomor_bc" value="<?$sessX['NOMOR_BC']; ?>"  maxlength="20"class="mtext" /></td>
                        </tr>
                        <tr>
                            <td>Tanggal BC 4.0 Asal</td>
                            <td><input type="text" name="HEADERX[TANGGAL_BC]" id="tanggal_bc" value="<?$sessX['TANGGAL_BC']; ?>"  maxlength="20"class="sstext" onfocus="ShowDP('tanggal_bc');" /></td>
                        </tr>-->
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGANGKUT</b></h5></td>
                        </tr>
                        <tr>
                            <td>Jenis Sarana Pengangkut Darat </td>
                            <td>
                            <input type="text" name="HEADER[JENIS_SARANA_ANGKUT]" id="JENIS_SARANA_ANGKUT" class="mtext" maxlength="20" value="<?= $sess['JENIS_SARANA_ANGKUT']; ?>" wajib="yes"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor Polisi </td>
                            <td><input type="text" name="HEADER[NOMOR_POLISI]" id="nomor_polisi" value="<?= $sess['NOMOR_POLISI']; ?>" class="mtext" maxlength="100" wajib="yes"/></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5></td>
                        </tr>
                        <tr>
                            <td width="139">Harga Penyerahan (Rp) </td>
                            <td><input type="text" name="harga" id="harga" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN'],2); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('HARGA_PENYERAHAN',this.value,4);"/>
                            <input type="hidden" name="HEADER[HARGA_PENYERAHAN]" id="HARGA_PENYERAHAN" value="<?= $sess['HARGA_PENYERAHAN']?>" /></td>
                        </tr>
        				<tr><td colspan="2">&nbsp;</td></tr>
        				<tr>
                        	<td colspan="2">
                            	<h5 class="smaller lighter red"><b>RIWAYAT BARANG ASAL BC 4.1</b></h5>
                                <table width="100%" border="0" id="TBLASAL">
                                    <tbody>
                                        <? if($act=="update"){ echo $dataasal; ?>              	
                                        <? }else{ ?>
                                        <tr id="trnomor">
                                            <td width="180">Nomor</td>
                                            <td id="tdnomor"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                            <input type="text" name="ASAL[NOMOR_DAFTAR][]" id="NOMOR_DAFTAR" value="<?= $sess['NOMOR_DAFTAR']; ?>"  maxlength="8" class="text" />
                                            <span class="input-group-btn">
                                                <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('BC41ASAL','NOMOR_DAFTAR;TANGGAL_DAFTAR','Dokumen BC 4.1 Asal','fbc40_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                            </div></td>
                                        </tr>
                                        <tr id="trtanggal">
                                            <td width="180">Tanggal</td>
                                            <td id="tdtanggal">
                                                <input type="text" name="ASAL[TANGGAL_DAFTAR][]" id="TANGGAL_DAFTAR" value="<?= $sess['TANGGAL_BC261']; ?>" class="sstext" maxlength="10" onFocus="ShowDP(this.id);" />
                                                &nbsp;&nbsp;YYYY-MM-DD
                                            </td>
                                        </tr>
                                        <? } ?>
                                    </tbody>
                                </table>
                                <input type="button" name="Tambah" id="Tambah" class="btn btn-info btn-sm" onclick="tambahasal()" value="Tambah" />
                          	</td>
         				</tr>
					</table>
				</td>
				<td width="55%" valign="top">
                    <table width="100%" border="0"> 
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td width="139">Volume (M3) </td>
                            <td><input type="text" name="VOLUMEUR" id="VOLUMEUR" value="<?= $this->fungsi->FormatRupiah($sess['VOLUME'],4); ?>" format="angka" class="mtext" wajib="yes"  onkeyup="this.value = ThausandSeperator('VOLUME',this.value,4);"/>
                            <input type="hidden" name="HEADER[VOLUME]" id="VOLUME" value="<?= $sess['VOLUME']?$sess['VOLUME']:0;?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Berat Kotor (Kg) </td>
                            <td><input type="text" name="BRUTOUR" id="BRUTOUR" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'],4); ?>" format="angka" class="mtext" wajib="yes" onkeyup="this.value = ThausandSeperator('BRUTO',this.value,4);"/>
                             <input type="hidden" name="HEADER[BRUTO]" id="BRUTO" value="<?= $sess['BRUTO']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Berat Bersih (Kg) </td>
                            <td><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'],4); ?>&nbsp; Kilogram (KGM)<input type="hidden" name="HEADER[NETTO]" value="<?= $sess['JUM_NETTO']; ?>" class="text"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>PENGIRIM BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td><combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_PENGIRIM]', $kode_id, $sess['KODE_ID_PENGIRIM'], 'id="KODE_ID_PENGIRIM" class="sstext" '); ?></combo> 
                           <div class="input-group" style=" width:3em; margin-bottom:0px">
                            <input type="text" name="HEADER[ID_PENGIRIM]" id="ID_PENGIRIM" value="<?php if($sess['KODE_ID_PENGIRIM']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PENGIRIM']);}else{ echo $sess['ID_PENGIRIM'];}?>" class="ltext" size="20" wajib="yes" maxlength="20"/>
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pemasok','KODE_ID_PENGIRIM;ID_PENGIRIM;NAMA_PENGIRIM;ALAMAT_PENGIRIM','penerima','fbc40_',600,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                            </div>
                            &nbsp;
                          
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="HEADER[NAMA_PENGIRIM]" id="NAMA_PENGIRIM" value="<?= $sess['NAMA_PENGIRIM']; ?>" class="mtext" maxlength="50" wajib="yes" url="<?= site_url(); ?>/autocomplete/pengirim_bc40" urai="id_pengirim;alamat_pengirim;" onfocus="Autocomp(this.id)" />
                            </td>
                        </tr>
                        <tr>
                            <td class="top">Alamat</td>
                            <td><textarea name="HEADER[ALAMAT_PENGIRIM]" id="ALAMAT_PENGIRIM" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPengirim')"><?= $sess['ALAMAT_PENGIRIM']; ?></textarea>
                            <div id="limitAlamatPengirim"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>TANDA TANGAN PENGUSAHA TPB</b></h5></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="HEADER[NAMA_TTD]" id="nama_ttd" value="<?= $sess['NAMA_TTD']; ?>" class="mtext" wajib="yes"/></td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td><input type="text" name="HEADER[KOTA_TTD]" id="tempat_ttd" value="<?= $sess['KOTA_TTD']; ?>" class="mtext" wajib="yes"/></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" value="<?php if($act=="save") echo date("Y-m-d"); else echo $sess['TANGGAL_TTD']; ?>" wajib="yes" onFocus="ShowDP('tanggal_ttd')" class="stext date"/>
                            &nbsp; YYYY-MM-DD</td>
                        </tr>
                    </table>
				</td>      
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <?php if(!$priview){ ?>
                <tr>
                    <td width="45%">
                    	<table width="100%">
                        	<tr>
                                <td width="180">&nbsp;</td>
                            	<td>
                                	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_header('#fbc40_');">
                                        <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;
                                    </a>
                                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbc40_');">
                                        <i class="icon-undo"></i>&nbsp;Reset&nbsp;
                                    </a>&nbsp;
                                    <span class="msgheader_">&nbsp;</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                	<td  width="55%">&nbsp;</td>
                </tr>
                <?php } ?>
			</table>
		</table>
		<input type="hidden"  name="HEADERX[JENIS_BARANG]" value="<?=$jns_barang?>"/> 
	</form>
</span>
<?php if($priview){
	echo '<h4 class="header smaller lighter green"><b>Detil Dokumen</b></h4>'.$DETILPRIVIEW;
}?>
<script>
<? if($priview){ ?>
	$('#fbc40_ input:visible, #fbc40_  select').attr('disabled',true);
<? } ?>
function tambahasal(){
	var rand = GetRandomMath();		
	var html = '<tr id="trnomor'+rand+'"><td>Nomor</td><td><div class="input-group" style=" width:3em; margin-bottom:0px"><input type="text" name="ASAL[NOMOR_DAFTAR][]" id="NOMOR_DAFTAR'+rand+'" maxlength="8" class="text"/><span class="input-group-btn"><a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search(\'BC41ASAL\',\'NOMOR_DAFTAR'+rand+';TANGGAL_DAFTAR'+rand+'\',\'Dokumen BC 4.1 Asal\',\'fbc40_\',650,400)"><i class="fa fa-ellipsis-h"></i></a></span></div></td></tr><tr id="trtanggal'+rand+'"><td>Tanggal</td><td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> <input type="text" name="ASAL[TANGGAL_DAFTAR][]" id="TANGGAL_DAFTAR'+rand+'" class="form-control" style="width:90px" maxlength="10" onFocus="ShowDP(this.id);" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;&nbsp;YYYY-MM-DD&nbsp;<a href="javascript:void(0)" onClick="hapusasal('+rand+')"><img width="16px" height="16px" align="texttop" style="border:none" src="'+base_url+'/img/tbl_delete.png">&nbsp;Hapus</a></td></tr>';	
	$("#TBLASAL tbody:last").append(html);
}
function hapusasal(id){ 
	$("#TBLASAL tr[id=trnomor"+id+"]").remove();
	$("#TBLASAL tr[id=trtanggal"+id+"]").remove();
}	
</script>
<script>
  $(document).ready(function(){
    for (var i = 1; i <= 4; i++) {
      if (i != 3) {
        $('#AJU_'+i).attr('maxlength', 6);
      } else {
        $('#AJU_'+i).attr('maxlength', 8);
        $('#AJU_'+i).attr('onClick','ShowDP(\'AJU_3\')');
        $('#AJU_'+i).attr('onChange','formatDate(\'AJU_3\')');
      }
    };
  });
</script>