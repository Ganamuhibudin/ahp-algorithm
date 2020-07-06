<span id="DivHeaderForm">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<span id="DivHeaderForm">
<form id="fbc41_" action="<?= site_url()."/pengeluaran/bc41"; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
<input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"];?>" />
<input type="hidden" name="HEADERDOK[NOMOR_AJU]" id="noajudok" value="<?= $aju;?>" />
<input type="hidden"  name="DOKUMEN" value="<?=$dokumen?>"/> 
<input type="hidden"  name="TEMPAT_ASAL" value="<?=$tmp_asal?>"/> 
<input type="hidden"  name="JENIS_BARANG" value="<?=$jns_barang?>"/> 
<span id="divtmp"></span>
<table width="100%" border="0">
	<tr>
		<td width="45%" valign="top">	
			<table width="100%" border="0">
    		<?php if (strtolower($act) == "update") {?>
    			<tr>
        			<td height="25px;">Nomor Aju</td>
        			<?php 
         			 $nomorAju = $this->fungsi->FormatAju($sess['NOMOR_AJU']);
         			 $exp = explode("-", $nomorAju);
          			 $noAju = str_replace("-", "", $nomorAju)
        			?>
       			    <td>
            		<input type="text" id="AJU_1" class="sstext" style="width:20%;" wajib="yes" value="<?= $exp[0] ?>" />
            		<input type="text" id="AJU_2" class="sstext" style="width:20%;" wajib="yes" value="<?= $exp[1] ?>" />
            		<input type ="text" id="AJU_3" class="sstext" style="width:20%;" wajib="yes" value="<?= $exp[2] ?>" />
            		<input type="text" id="AJU_4" class="sstext" style="width:20%;" wajib="yes" value="<?= $exp[3] ?>" /> 
            		<input type="button" class="btn btn-primary btn-xs" style="font-size:11px;height:26px" name="updateAju" id="updateAju" onclick="updateNoaju('BC41','<?= $noAju ?>')" value="Update" />
            		<br/>
            		<div class="msgaju"> </div>
        			</td>
    			</tr>
    		<?php } ?>
    			<tr>
        			<td width="38%">Kantor Pabean</td>
        			<td width="62%">
              <div class="input-group" style="float:left; width:3em; margin-bottom:0px">
              <input type="text"  name="HEADER[KODE_KPBC]" id="kode_kpbc" class="sstext" style="width:80px" value="<?= $sess['KODE_KPBC']; ?>" url="<?= site_url()?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)"/>
              <span class="input-group-btn">
                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc','kode_kpbc;urkt','Kode Kpbc','fbc41_',650,400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
              </div>&nbsp;
        			<span id="urkt"><?= $sess['URAIAN_KPBC']?$sess['URAIAN_KPBC']:$URKANTOR_TUJUAN; ?></span> </td>
    			</tr>
    			<tr>
        			<td>Jenis TPB</td>
        			<td><combo><?= form_dropdown('HEADER[JENIS_TPB]', $jenis_tpb, $sess['JENIS_TPB'], 'id="tujuan" class="mtext" wajib="yes" value="<?= $jenis_tpb; ?>"'); ?></combo></td>
    			</tr>
    			<tr>
        			<td>Tujuan Pengiriman</td>
        			<td><combo><?= form_dropdown('HEADER[TUJUAN_KIRIM]', $tujuan_kirim, $sess['TUJUAN_KIRIM'], 'id="tujuan_kirim" class="mtext" wajib="yes" value="<?= $tujuan_kirim; ?>"'); ?></combo></td>
   				</tr>
			</table>
		</td>
        <td width="55%">
    		<h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5>
    		<table width="80%">
        		<tr>
            		<td width="40%">Nomor Pendaftaran*</td>
            		<td width="60%">
            		<?php if($sess['STATUS_DOK']=="LENGKAP"){?>
            	<input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="8" /><?php }else{?><input type="text" disabled="disabled" class="stext date" maxlength="8" /><?php }?></td>
        		</tr>
       			<tr>
            		<td>Tanggal Pendaftaran*</td>
            		<td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> 
            		<?php if($sess['STATUS_DOK']=="LENGKAP"){?>
            <input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="form-control" style="width:90px" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>" />
            <?php }else{?><input type="text" disabled="disabled" class="form-control" style="width:90px"/><?php }?><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD</td>
        		</tr>
        		<tr>
            		<td>No. Persetujuan Pengeluaran</td>
            		<td>
            		<?php if($sess['STATUS_DOK']=="LENGKAP"){?>
            <input type="text" name="HEADERDOK[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" maxlength="30" /><?php }else{?><input type="text" disabled="disabled" class="text" value="" /><?php }?></td>
        		</tr>
        		<tr>
            		<td>Tanggal Persetujuan Pengeluaran</td>
            		<td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> 
            		<?php if($sess['STATUS_DOK']=="LENGKAP"){?>
            <input type="text" name="HEADERDOK[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="stext date" value="<?= ($sess['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$sess['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');"/>
            		<?php }else{?><input type="text" disabled="disabled" class="form-control" style="width:90px" value="" /><?php }?><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD</td>
        		</tr>
         		<tr>
            		<td>Nama Pejabat BC</td>
            		<td>
            		<?php if($sess['STATUS_DOK']=="LENGKAP"){?>
            <input type="text" name="HEADERDOK[NAMA_PEJABAT_BC]" id="NAMA_PEJABAT_BC" class="text" value="<?= $sess['NAMA_PEJABAT_BC']; ?>" />
            		<?php }else{?><input type="text" disabled="disabled" class="text" value="" /><?php }?></td>
        		</tr>
         		<tr>
            		<td>NIP Pejabat BC</td>
            		<td>
            		<?php if($sess['STATUS_DOK']=="LENGKAP"){?>
            <input type="text" name="HEADERDOK[NIP_PEJABAT_BC]" id="NIP_PEJABAT_BC" class="text" value="<?= $sess['NIP_PEJABAT_BC']; ?>"/>
            		<?php }else{?><input type="text" disabled="disabled" class="text" value="" /><?php }?></td>
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
            <td width="38%">Identitas</td>
            <td width="62%"><combo><?= form_dropdown('HEADER[KODE_ID_TRADER]', $kode_id, $sess['KODE_ID_TRADER'], 'id="kode_id" class="sstext" value="<?= $kode_id; ?>"'); ?> </combo>
            <input type="hidden" name="HEADER[KODE_TRADER]" id="KODE_TRADER" value="<?= $sess['KODE_TRADER']; ?>" class="stext" wajib="yes" maxlength="15" />
            <input type="text" name="HEADER[ID_TRADER]" id="id_trader" value="<?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?>" class="ltext" size="20" wajib="yes" maxlength="15"/></td>
        </tr> 
		<tr>
			<td class="top">Nama </td>
			<td><input type="text" name="HEADER[NAMA_TRADER]" id="nama_trader" value="<?= $sess['NAMA_TRADER']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" class="mtext" wajib="yes"/></td>
		</tr>
		<tr>
			<td>Alamat </td>
			<td><textarea name="HEADER[ALAMAT_TRADER]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')"><?= $sess['ALAMAT_TRADER']; ?></textarea>
            <div id="limitAlamatTrader"></div>
            </td>
		</tr>
        <tr>
			<td class="top">No Ijin TPB </td>
			<td><input type="text" name="HEADER[NOMOR_IZIN_TPB]" id="nomor_izin_tpb" value="<?= $sess['NOMOR_IZIN_TPB']?$sess['NOMOR_IZIN_TPB']:$sess['NOMOR_SKEP']; ?>" maxlength="30" class="mtext" wajib="yes"/></td>
		</tr>
    <tr>
			<td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGANGKUTAN</b></h5></td>
		</tr>
    <tr>
			<td>Jenis Sarana Pengangkut Darat</td>
			<td>
            <input type="text" name="HEADER[JENIS_SARANA_ANGKUT]" id="JENIS_SARANA_ANGKUT" value="<?= $sess['JENIS_SARANA_ANGKUT']; ?>"  maxlength="20"class="mtext" /></td>
		</tr>
		<tr>
			<td>Nomor Polisi </td>
			<td><input type="text" name="HEADER[NOMOR_POLISI]" id="nomor_polisi" value="<?= $sess['NOMOR_POLISI']; ?>" class="stext" maxlength="10" wajib="yes"/></td>
		</tr>
        <tr>
			<td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5></td>
		</tr>
		<tr>
			<td width="139">Harga Penyerahan (Rp) </td>
            <td>
            <input type="text" name="harga" id="harga" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN'],2); ?>" onkeyup="this.value = ThausandSeperator('HARGA_PENYERAHAN',this.value,4);" class="mtext" format="angka" wajib="yes"><input type="hidden" name="HEADER[HARGA_PENYERAHAN]" id="HARGA_PENYERAHAN" class="text" value="<?= $sess['HARGA_PENYERAHAN']; ?>" maxlength="18"/>
		</tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
          <td colspan="2">
          <h5 class="header smaller lighter red"><i>Riwayat Barang Asal BC 4.0</i></h5>
              <table width="100%" border="0" id="TBLASAL">
              <tbody>
              <?php if($act=="update"){ echo $dataasal; ?>              	
              <?php }else{ ?>
              <tr id="trnomor">
                <td width="38%">Nomor</td>
                <td width="62%" id="tdnomor"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
              <input type="text" name="ASAL[NOMOR_DAFTAR][]" id="NOMOR_DAFTAR" value="<?= $sess['NOMOR_DAFTAR']; ?>"  maxlength="8" class="text" />
              <span class="input-group-btn">
                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('BC40ASAL','NOMOR_DAFTAR;TANGGAL_DAFTAR','Dokumen BC 4.0 Asal','fbc41_',650,400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
              </div>
               </td>
              </tr>
              <tr id="trtanggal">
                <td width="37%">Tanggal</td>
                <td width="63%"><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> <input type="text" name="ASAL[TANGGAL_DAFTAR][]" id="TANGGAL_DAFTAR" value="<?= $sess['TANGGAL_BC261']; ?>" class="form-control" style="width:90px" maxlength="10" onclick="ShowDP('TANGGAL_DAFTAR');" onfocus="ShowDP('TANGGAL_DAFTAR');" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
                  &nbsp;&nbsp;YYYY-MM-DD</td>
              </tr>
              <?php } ?>
              </tbody>
              </table>
              <!-- <input type="button" name="Tambah" id="Tambah" class="btn btn-primary btn-xs" onclick="tambahasal()" style="font-size:11px" value="Tambah" /> -->
              <a href="javascript:void(0);" class="btn btn-primary" name="Tambah" style="font-size:12px" id="Tambah" onclick="tambahasal()"><span><i class="fa fa-plus"></i>&nbsp;Tambah</span></a>
          </td>
          </tr>
		</table>
</td>
<td width="55%" valign="top">
		<table width="80%" border="0"> 
        
        <tr>
			<td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
		</tr>
		<tr>
			<td width="40%">Volume (M3) </td>
			<td width="60%"> <input type="text" name="volume" id="volume" value="<?= $this->fungsi->FormatRupiah($sess['VOLUME'],4); ?>" onkeyup="this.value = ThausandSeperator('VOLUME',this.value,4);" class="mtext" format="angka" wajib="yes"><input type="hidden" name="HEADER[VOLUME]" id="VOLUME" class="text" value="<?= $sess['VOLUME']; ?>" maxlength="18"/>
            </td>
		</tr>
        <tr>
			<td width="139">Berat Kotor (Kg) </td>
			<td><input type="text" name="bruto" id="bruto" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'],4); ?>" onkeyup="this.value = ThausandSeperator('BRUTO',this.value,4);" class="mtext" format="angka" wajib="yes"><input type="hidden" name="HEADER[BRUTO]" id="BRUTO" class="text" value="<?= $sess['BRUTO']; ?>" maxlength="18"/>
            </td>
		</tr>
        <tr>
			<td width="139">Berat Bersih (Kg) </td>
			<td><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'],2); ?>&nbsp; Kilogram (KGM)<input type="hidden" name="HEADER[NETTO]" value="<?= $sess['JUM_NETTO']; ?>" class="text"/></td>
		</tr>
        <tr>
			<td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>PENERIMA BARANG</b></h5></td>
		</tr>
		<tr>
            <td>Identitas</td>
            <td><combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_PENERIMA]', $kode_id, $sess['KODE_ID_PENERIMA'], 'id="KODE_ID_PENERIMA" class="sstext" '); ?> </combo>
           <div class="input-group" style="float:left; width:3em; margin-bottom:0px">
            <input type="text" name="HEADER[ID_PENERIMA]" id="ID_PENERIMA" value="<?php if($sess['KODE_ID_PENERIMA']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PENERIMA']);}else{ echo $sess['ID_PENERIMA'];}?>" class="ltext" size="20" wajib="yes" maxlength="20"/>
            <span class="input-group-btn">
                <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pemasok','KODE_ID_PENERIMA;ID_PENERIMA;NAMA_PENERIMA;ALAMAT_PENERIMA','penerima','fbc41_',600,400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
            </div>
	</td>
		<tr>
			<td>Nama</td>
			<td><input type="text" name="HEADER[NAMA_PENERIMA]" id="NAMA_PENERIMA" value="<?= $sess['NAMA_PENERIMA']; ?>" class="mtext" maxlength="50" wajib="yes"/></td>
		</tr>
        <tr>
			<td class="top">Alamat</td>
			<td><textarea name="HEADER[ALAMAT_PENERIMA]" id="ALAMAT_PENERIMA" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPenerima')"><?= $sess['ALAMAT_PENERIMA']; ?></textarea>
            <div id="limitAlamatPenerima"></div>
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
			<td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> <input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" value="<?= ($sess['TANGGAL_TTD'])?$sess['TANGGAL_TTD']:date("Y-m-d"); ?>" wajib="yes" onFocus="ShowDP('tanggal_ttd')" class="form-control" style="width:90px"/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
			&nbsp; YYYY-MM-DD</td>
		</tr>
    <?php if($flagrevisi){ ?>
    <tr>
        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA REVISI</b></h5></td>
    </tr>
    <tr>
        <td>Alasan Revisi</td>
        <td>
            <textarea id="ALASAN" class="mtext" wajib="yes" name="ALASAN"></textarea>
        </td>
    </tr>
    <?php } ?>
    </table>
</td>      
<tr>
 	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
    <a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_header('#fbc41_');"><span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('fbc41_');"><span><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msgheader_" style="margin-left:20px">&nbsp;</span>
	</td>
</tr>
</table>
</table>
</form>
</span>
<script>

function tambahasal(){
	var rand = GetRandomMath();		
	var html = '<tr id="trnomor'+rand+'"><td>Nomor</td><td><div class="input-group" style="float:left; width:3em; margin-bottom:0px"><input type="text" name="ASAL[NOMOR_DAFTAR][]" id="NOMOR_DAFTAR'+rand+'" maxlength="8" class="text"/><span class="input-group-btn"><a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search(\'BC40ASAL\',\'NOMOR_DAFTAR'+rand+';TANGGAL_DAFTAR'+rand+'\',\'Dokumen BC 4.0 Asal\',\'fbc41_\',650,400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span></div></td></tr><tr id="trtanggal'+rand+'"><td>Tanggal</td><td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> <input type="text" name="ASAL[TANGGAL_DAFTAR][]" id="TANGGAL_DAFTAR'+rand+'" class="form-control" style="width:90px" maxlength="10" onFocus="ShowDP(this.id);" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;&nbsp;YYYY-MM-DD&nbsp;<a href="javascript:void(0)" onClick="hapusasal('+rand+')" style="color:red"><img width="16px" height="16px" align="texttop" style="border:none" src="'+base_url+'/img/tbl_delete.png">&nbsp;Hapus</a></td></tr>';	
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



