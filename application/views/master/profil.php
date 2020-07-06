<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

if ($act=="Ubah"){
	$disable = "disabled=disabled";	
	$skep = "Nomor/Tanggal SKEP";
	$produksi = "Jenis Hasil Produksi";
}else{
	$disable = "";
	$url = "../edit/profil";
	$skep = "<span style=\"color:#09F;cursor:pointer\" onclick=\"Dialog('".site_url()."/master/listdatapopup/skep','Dialog-skep','DAFTAR DATA SKEP',550,500);\" title=\"Klik untuk melihat daftar SKEP\">Nomor/Tanggal SKEP</span>";
	$produksi = "<span class=\"fontBlueColor\" onclick=\"Dialog('".site_url()."/master/listdatapopup/produksi','Dialog-produksi','DAFTAR DATA JENIS HASIL PRODUKSI',550,500);\" title=\"Klik untuk Jenis Hasil Produksi\">Jenis Hasil Produksi</span>";
}
?>
<div style="cursor:pointer" class="header">
	<h3><strong><i class="fa fa-home"></i>&nbsp;Profil Perusahaan</strong></h3>
</div>
<div class="content">
<form id="fprofil_" class="form-horizontal" action="<?= $url; ?>" method="post" autocomplete="off">
<table width="100%">
<tr>
	<td valign="top" width="40%">
    	<table width="100%">
		<tr>
			<td width="40%">Identitas</td>
    		<td width="60%"><combo><?= form_dropdown('PROFIL[KODE_ID]', $kode_id_trader, $sess['KODE_ID'], 'id="kode_id_trader" class="stext date ac_input" style="width:34%" '.$disable.''); ?></combo>
			<input type="text" name="PROFIL[ID]" id="ID" class="stext date ac_input" style="width:50%" value="<?php echo $sess['ID']; ?>" <?= $disable; ?>/>
    		</td>
		</tr>
        <tr>
    		<td>Nama</td>
    		<td><input type="text" name="PROFIL[NAMA]" id="NAMA" class="form-control" style="width:85%" value="<?=$sess['NAMA']?>" readonly <?= $disable; ?>/></td>
		</tr>
        <tr>
   			<td>Alamat</td>
    		<td><textarea name="PROFIL[ALAMAT]" id="ALAMAT" class="form-control" style="width:85%"  <?= $disable; ?>><?=$sess['ALAMAT']?></textarea></td>
		</tr>
        <tr>
			<td>Nomor Telephon</td>
    		<td><input type="text" name="PROFIL[TELEPON]" id="TELEPON" class="form-control" style="width:85%" value="<?=$sess['TELEPON']?>"  <?= $disable; ?>/></td>
		</tr>
		<tr>
			<td>Nomor FAX </td>
    		<td><input type="text" name="PROFIL[FAX]" id="FAX" class="form-control" style="width:85%" value="<?=$sess['FAX']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr> 
			<td>Bidang Usaha </td>
    		<td><input type="text" name="PROFIL[BIDANG_USAHA]" id="BIDANG_USAHA" class="form-control" style="width:85%" value="<?=$sess['BIDANG_USAHA']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>Status Usaha </td>
   			<td><combo><?= form_dropdown('PROFIL[STATUS_TRADER]',$TIPE_TRADER,$sess['STATUS_TRADER'],'wajib="yes" id="STATUS_TRADER" class="text" style="width:85%" '.$disable.''); ?></combo></td>
		</tr>
        <tr>
    		<td>Nomor</td>
    		<td><?= form_dropdown('PROFIL[KODE_API]', $kode_api_trader, $sess['KODE_API'], 'id="kode_api_trader" class="stext date ac_input" style="width:34%" '.$disable.''); ?>\
			  <input type="text" name="PROFIL[NOMOR_API]" id="NOMOR_API" class="stext date ac_input" style="width:50%" value="<?=$sess['NOMOR_API'];?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>Nomor SRP/SIP </td>
    		<td><input type="text" name="PROFIL[NOMOR_SRP]" id="NOMOR_SRP" class="form-control" style="width:85%" value="<?=$sess['NOMOR_SRP']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>NIPER </td>
    		<td><input type="text" name="PROFIL[NIPER]" id="NIPER" class="form-control" style="width:85%" value="<?=$sess['NIPER']?>"  <?= $disable; ?> maxlength="4"/></td>
		</tr>
        </table>
    </td>
    <td valign="top" width="60%">'
    	<table width="70%">
        <tr>
    		<td width="40%">Nama Pemilik/Penanggung jawab</td>
    		<td width="60%"><input type="text" name="PROFIL[NAMA_PENANGGUNGJAWAB]" id="NAMA_PENANGGUNGJAWAB" class="form-control" style="width:85%" value="<?=$sess['NAMA_PENANGGUNGJAWAB']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>Alamat Pemilik</td>
			<td><textarea name="PROFIL[ALAMAT_PENANGGUNGJAWAB]" id="ALAMAT_PENANGGUNGJAWAB" class="form-control" style="width:85%" <?= $disable; ?>><?=$sess['ALAMAT_PENANGGUNGJAWAB']?></textarea></td>
		</tr>
        <tr>
			<td><?= $skep; ?></td>
			<td><input type="text" name="SKEP[NOMOR_SKEP]" id="NOMOR_SKEP" class="stext date ac_input" style="width:54%" value="<?=$SKEP['NOMOR_SKEP']?>" readonly <?= $disable; ?>/>
    		<input type="text" name="SKEP[TANGGAL_SKEP]" id="TANGGAL_SKEP" class="stext date ac_input" style="width:30%" value="<?=$SKEP['TANGGAL_SKEP'];?>" readonly <?= $disable; ?>/></td>
		</tr>
        </table>
    </td>
</tr>
<tr>
	<td valign="top" width="40%">
    	<table width="100%">
        <tr>
			<td colspan="2">Luas Lokasi keseluruhan GB(Penyelenggara GB)
    		<input type="text" name="PROFIL[LUAS_LOKASI_GB]" id="LUAS_LOKASI_GB" class="stext date ac_input" style="width:10%" value="<?=$sess['LUAS_LOKASI_GB']?>"  <?= $disable; ?>/>
			M<sup>2</sup>
    		</td>
		</tr>
        <tr>
   			<td colspan="2"><h5 class="smaller lighter green"><b>Batas Batas Lokasi</b></h5></td>
		</tr>
        <tr>
			<td width="20%">Sebelah Barat</td>
    		<td width="30%"><input type="text" name="PROFIL[BATAS_BARAT_GB]" id="BATAS_BARAT_GB" class="form-control" style="width:85%" value="<?=$sess['BATAS_BARAT_GB']?>"  <?= $disable; ?>/></td>
		</tr>
		<tr>
			<td>Sebelah Timur </td>
    		<td><input type="text" name="PROFIL[BATAS_TIMUR_GB]" id="BATAS_TIMUR_GB" class="form-control" style="width:85%" value="<?=$sess['BATAS_TIMUR_GB']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>Sebelah Utara </td>
    		<td><input type="text" name="PROFIL[BATAS_UTARA_GB]" id="BATAS_UTARA_GB" class="form-control" style="width:85%" value="<?=$sess['BATAS_UTARA_GB']?>"  <?= $disable; ?>/></td>
		</tr>
		<tr>
			<td>Sebelah Selatan </td>
   			<td><input type="text" name="PROFIL[BATAS_SELATAN_GB]" id="BATAS_SELATAN_GB" class="form-control" style="width:85%" value="<?=$sess['BATAS_SELATAN_GB']?>"  <?= $disable; ?>/></td>
		</tr>
        </table>
    </td>
    <td valign="top" width="60%">
    	<table width="70%">
        <tr>
			<td colspan="2">Luas Lokasi keseluruhan GB yang di usahakan sendiri(Pengusaha GB)
    		<input type="text" name="PROFIL[LUAS_LOKASI_PDGB]" id="LUAS_LOKASI_PDGB" class="stext date ac_input" style="width:10%" value="<?=$sess['LUAS_LOKASI_PDGB']?>" <?= $disable; ?> />
			M<sup>2</sup>
    		</td>
		</tr>
        <tr>
			<td colspan="2"><h5 class="smaller lighter green"><b>Batas Batas Lokasi</b></h5></td>
		</tr>
        <tr>
			<td width="20%">Sebelah Barat </td>
    		<td width="30%"><input type="text" name="PROFIL[BATAS_BARAT_PDGB]" id="BATAS_BARAT_PDGB" class="form-control" style="width:85%" value="<?=$sess['BATAS_BARAT_PDGB']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>Sebelah Timur</td>
    		<td><input type="text" name="PROFIL[BATAS_TIMUR_PDGB]" id="BATAS_TIMUR_PDGB" class="form-control" style="width:85%" value="<?=$sess['BATAS_TIMUR_PDGB']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>Sebelah Utara </td>
    		<td><input type="text" name="PROFIL[BATAS_UTARA_PDGB]" id="BATAS_UTARA_PDGB" class="form-control" style="width:85%" value="<?=$sess['BATAS_UTARA_PDGB']?>"  <?= $disable; ?>/></td>
		</tr>
        <tr>
			<td>Sebelah Seletan </td>
    		<td><input type="text" name="PROFIL[BATAS_SELATAN_PDGB]" id="BATAS_SELATAN_PDGB" style="width:85%" class="form-control" value="<?=$sess['BATAS_SELATAN_PDGB']?>"  <?= $disable; ?>/></td>
		</tr>
        </table>
    </td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
<?php if($this->newsession->userdata('KODE_ROLE')!='5'){ #ROLE BUKAN BC ?>
      <a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="rubah('#fprofil_');"><i class="fa fa-save"></i>&nbsp;<?=$act;?>&nbsp;</a>&nbsp;<?php if($act!="Ubah"){ ?><a href="javascript:void(0);" class="btn btn-danger btn-sm" id="ok_" onclick="window.location.href='<?php echo site_url('master/profil/lihat'); ?>'"><i class="fa fa-times"></i>&nbsp;Batal&nbsp;</a><?php } ?>&nbsp;
      <span class="msgheader_" align="left"  style="margin-left:20px">&nbsp;</span>
<?php } ?>
	</td>
</tr>  
</table>  
</form>
</div>

<script>
function rubah(formid){
	<?php if($act=="Ubah"){ ?>
	window.location = site_url+"/master/profil/ubah";
	<?php }else{ ?>
		save_header(formid)
	<?php }?>
}	
</script>
