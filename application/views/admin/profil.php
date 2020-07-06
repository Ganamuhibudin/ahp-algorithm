<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
$disable = "disabled=disabled";	
$skep = "Nomor/Tanggal SKEP";
$produksi = "Jenis Hasil Produksi";
?>
<style>input[readonly],textarea[readonly],select[readonly],input[disabled],textarea[disabled],select[disabled]{background-color:#F5F5F5;color:#333}</style>
<div class="header">	
    <a href="javascript:void(0)" onclick="window.location.href='<?= site_url()."/admin/".$this->uri->segment(2)."/".$type ?>'" style="float:right;margin:-5px 4px 0px 0px" class="btn btn-success btn-sm prev" id="ok_"><span><i class="icon-arrow-left"></i>&nbsp;Kembali&nbsp;</span></a>
    <h3><strong>Profil Perusahaan</strong></h3>
</div>
<div class="content">
<form id="fprofil_" action="<?= $url; ?>" method="post" autocomplete="off">
<table width="100%" border="0">
<tr><td width="40%" valign="top">
    <table width="100%" border="0">
     	<tr>
            <td colspan="2"><h5 class="smaller lighter blue"><b>DATA PERUSAHAAN :</b></h5></td>
        </tr>
        <tr>
            <td width="30%">Identitas</td>
            <td width="70%"> <?= form_dropdown('DATA[KODE_ID]', $kode_id_trader,$sess['KODE_ID'], 'id="kode_id_trader" class="sstext"'); ?>&nbsp;<input type="text" name="DATA[ID]" id="ID" class="ltext" value="<?php if($sess['KODE_ID']==5){echo $this->fungsi->FORMATNPWP($sess['ID']);}else{ echo $sess['ID'];}?>" maxlength="15" style="width:51%"/></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td> <input type="text" value="<?=$sess['NAMA']?>" name="DATA[NAMA]" id="NAMA" class="mtext"/></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><textarea name="DATA[ALAMAT]" id="ALAMAT" class="mtext"><?=$sess['ALAMAT']?></textarea></td>
        </tr>
        <tr>
            <td>Nomor Telepon</td>
            <td><input type="text" value="<?=$sess['TELEPON']?>" name="DATA[TELEPON]" id="TELEPON" class="mtext"/></td>
        </tr>
        <tr>
            <td>Nomor Fax</td>
            <td><input type="text" value="<?=$sess['FAX']?>" name="DATA[FAX]" id="FAX" class="mtext"/></td>
        </tr>
        <tr>
            <td>Bidang Usaha</td>
            <td><input type="text" value="<?=$sess['BIDANG_USAHA']?>" name="DATA[BIDANG_USAHA]" id="BIDANG_USAHA" class="mtext" maxlength="30"/></td>
        </tr>
        <tr>
            <td>Jenis Usaha</td>
            <td><?= form_dropdown('DATA[JENIS_TRADER]', $JENIS_TPB, $sess['JENIS_TRADER'], ' id="JENIS_TRADER" class="mtext"'); ?></td>
        </tr>
        <tr>
            <td>Status Usaha</td>
            <td><?= form_dropdown('DATA[STATUS_TRADER]',$TIPE_TRADER,$sess['STATUS_TRADER'],' id="STATUS_TRADER" class="mtext"'); ?></td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td><?= form_dropdown('DATA[KODE_API]', $kode_api_trader, $sess['KODE_API'], 'id="kode_api_trader" class="sstext" '); ?>&nbsp;
              <input type="text" value="<?=$sess['ALAMAT']?>" name="DATA[NOMOR_API]" id="NOMOR_API" class="ltext" style="width:50%" /></td>
        </tr>
        <tr>
            <td>Nomor SRP/SIP</td>
            <td><input type="text" value="<?=$sess['NOMOR_SRP']?>" name="DATA[NOMOR_SRP]" id="NOMOR_SRP" class="mtext" maxlength="30"/></td>
        </tr>
        <tr>
            <td>Jenis Barang DItimbun</td>
            <td><input type="text" value="<?=$sess['JENIS_BARANG_TIMBUN']?>" name="DATA[JENIS_BARANG_TIMBUN]" id="JENIS_BARANG_TIMBUN" class="mtext" maxlength="100"/></td>
        </tr>
        <tr>
            <td>Tujuan Distribusi</td>
            <td><input type="text" value="<?=$sess['TUJUAN_DISTRIBUSI']?>" name="DATA[TUJUAN_DISTRIBUSI]" id="TUJUAN_DISTRIBUSI" class="mtext" maxlength="100"/></td>
        </tr>
        <tr>
            <td colspan="7">&nbsp;</td>
        </tr>
    </table>    
</td>
<td width="60%" valign="top">
	<table width="100%" border="0">
   	 	<tr>
            <td colspan="2"><h5 class="smaller lighter blue"><b>DATA PEMILIK :</b></h5></td>
        </tr>
        <tr>
            <td width="27%">Nama Pemilik/Penanggung Jawab</td>
            <td width="73%"><input type="text" value="<?=$sess['NAMA_PENANGGUNGJAWAB']?>" name="DATA[NAMA_PENANGGUNGJAWAB]" id="NAMA_PENANGGUNGJAWAB" class="mtext" maxlength="50"/>
            </td>
        </tr>
        <tr>
            <td>Alamat Pemilik</td>
            <td><textarea name="DATA[ALAMAT_PENANGGUNGJAWAB]" id="ALAMAT_PENANGGUNGJAWAB" class="mtext"><?=$sess['ALAMAT_PENANGGUNGJAWAB']?></textarea></td>
        </tr>
         <tr>
            <td>Kode Skep</td>
            <td><input type="text" value="<?=$sess['KODE_SKEP']?>" name="DATA[KODE_SKEP]" id="KODE_SKEP" class="text date"/></td>
        </tr>
         <tr>
            <td>&nbsp;</td>
            <td><textarea name="URSKEP" id="URSKEP" class="mtext"><?=$sess['URSKEP']?></textarea></td>
        </tr>
        <tr>
            <td>Nomor Skep</td>
            <td><input type="text" value="<?=$sess['NOMOR_SKEP']?>" name="DATA[NOMOR_SKEP]" id="NOMOR_SKEP" class="dtext" maxlength="30"/></td>
        </tr>
        <tr>
            <td>Tanggal Skep</td>
            <td><input type="text" value="<?=$sess['TANGGAL_SKEP']?>" name="DATA[TANGGAL_SKEP]" id="TANGGAL_SKEP" class="stext date" onfocus="ShowDP(this.id)"/></td>
        </tr>
    </table>
    <table width="100%" border="0">
     	<tr>
            <td colspan="2"><h5 class="smaller lighter blue"><b>DATA LOKASI :</b></h5></td>
        </tr>
       <tr>
            <td width="27%">Lokasi</td>
            <td width="73%"><input type="text" value="<?=$sess['LOKASI_GB']?>" name="DATA[LOKASI_GB]" id="LOKASI_GB" class="mtext" maxlength="70"/></td>
        </tr>
        <tr>
            <td>Desa/Kelurahan</td>
            <td><input type="text" value="<?=$sess['DESA_KEL_GB']?>" name="DATA[DESA_KEL_GB]" id="DESA_KEL_GB" class="mtext" maxlength="70"/></td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td><input type="text" value="<?=$sess['KECAMATAN_GB']?>" name="DATA[KECAMATAN_GB]" id="KECAMATAN_GB" class="mtext" maxlength="30"/></td>
        </tr>
        <tr>
            <td>Kota</td>
            <td><?= form_dropdown('DATA[KOTA_GB]',$KOTA_GB,$sess['KOTA_GB'],'id="KOTA_GB" class="mtext"'); ?></td>
        </tr>
        <tr>
            <td>Propinsi</td>
            <td><?= form_dropdown('DATA[PROPINSI_GB]',$PROPINSI_GB,$sess['PROPINSI_GB'],'id="PROPINSI_GB" class="mtext"'); ?></td>
        </tr>
    </table>
</td></tr></table>    

<table width="100%" border="0">
<tr><td width="40%" valign="top">
    <table width="100%" border="0">
     	<tr>
            <td colspan="2"><h5 class="smaller lighter blue"><b>DATA PENANGGUNGJAWAB :</b></h5></td>
        </tr>
       <tr>
            <td width="30%">Nama</td>
            <td width="70%"><input type="text" value="<?=$sess['NAMA_USER']?>" name="DATA[NAMA_USER]" id="NAMA_USER" class="mtext" maxlength="50"/></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><textarea name="DATA[ALAMAT_USER]" id="ALAMAT_USER" class="mtext" ><?=$sess['ALAMAT_USER']?></textarea></td>
        </tr>
        <tr>
            <td>Nomor Telepon</td>
            <td><input type="text" value="<?=$sess['TELEPON_USER']?>" name="DATA[TELEPON_USER]" id="TELEPON_USER" class="mtext" /></td>
        </tr>  
        <tr>
            <td>Email</td>
            <td><input type="text" value="<?=$sess['EMAIL_USER']?>" name="DATA[EMAIL_USER]" id="EMAIL_USER" class="mtext" maxlength="70"/></td>
        </tr>   
        <tr>
            <td>Jabatan</td>
            <td><input type="text" value="<?=$sess['JABATAN_USER']?>" name="DATA[JABATAN_USER]" id="JABATAN_USER" class="mtext" maxlength="50"/></td>
        </tr>    
    </table>    
</td>
<td width="60%" valign="top">
	<table width="100%" border="0">
   	 	<tr>
            <td colspan="2"><h5 class="smaller lighter blue"><b>DATA USER ADMIN :</b></h5></td>
        </tr>
        <tr>
            <td width="27%">Username</td>
            <td width="73%"><input type="text" value="<?=$sess['USERNAME']?>" name="DATA[USERNAME]" id="USERNAME" class="mtext" maxlength="30"/>
            </td>
        </tr>     
        <tr>
            <td>Password</td>
            <td><input type="password" name="DATA[PASSWORD]" id="PASSWORD" class="mtext" maxlength="100" value="<?=$sess['PASSWORD']?>" /></td>
        </tr>      
        <tr>
            <td>Konfirmasi Password</td>
            <td><input type="password" name="KONFPASSWORD" id="KONFPASSWORD" class="mtext" maxlength="100" value="<?=$sess['PASSWORD']?>" /></td>
        </tr>  
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr> 
    </table>
</td></tr><tr><td colspan="2">&nbsp;</td></tr></table>

<table width="100%" border="0">
<tr><td width="40%" valign="top">
        
</td>
<td width="60%" valign="top">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr></table>

<table width="100%" border="0">
<tr>
    <td colspan="2"><h4 class="header smaller green">DATA LUAS LOKASI</h4></td>
</tr>
<tr><td width="40%" valign="top">
    <table width="100%" border="0">
    	<tr>
        	<td colspan="2">Luas Lokasi Keseluruhan GB (Penyelenggara GB)&nbsp;: <input type="text" value="<?=$sess['ALAMAT']?>" name="DATA[LUAS_LOKASI_GB]" id="LUAS_LOKASI_GB" class="sstext"  />&nbsp;M<sup>2</sup></td>
        </tr>
    	<tr>
        	<td><h5 class="smaller lighter blue"><b>Batas - batas Lokasi :</b></h5></td><td>&nbsp;</td>
        </tr>
        <tr>
            <td width="30%">Sebelah Barat</td>
            <td width="70%"><input type="text" value="<?=$sess['BATAS_BARAT_GB']?>" name="DATA[BATAS_BARAT_GB]" id="BATAS_BARAT_GB" class="mtext" /></td>
        </tr>
        <tr>
            <td>Sebelah Timur</td>
            <td><input type="text" value="<?=$sess['BATAS_TIMUR_GB']?>" name="DATA[BATAS_TIMUR_GB]" id="BATAS_TIMUR_GB" class="mtext"  /></td>
        </tr>
        <tr>
            <td>Sebelah Utara</td>
            <td><input type="text" value="<?=$sess['BATAS_UTARA_GB']?>" name="DATA[BATAS_UTARA_GB]" id="BATAS_UTARA_GB" class="mtext" /></td>
        </tr>
        <tr>
            <td>Sebelah Selatan</td>
            <td><input type="text" value="<?=$sess['BATAS_SELATAN_GB']?>" name="DATA[BATAS_SELATAN_GB]" id="BATAS_SELATAN_GB" class="mtext"/></td>
        </tr>
         <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
	</td>
    <td width="60%" valign="top">
    <table width="100%" border="0">
    	<tr>
        	<td colspan="2">Luas Lokasi Keseluruhan GB yg diusahakan sendiri (Pengusaha GB)&nbsp;: <input type="text" value="<?=$sess['ALAMAT']?>" name="DATA[LUAS_LOKASI_PDGB]" id="LUAS_LOKASI_PDGB" class="sstext" />&nbsp;M<sup>2</sup></td>
        </tr>
    	<tr>
        	<td><h5 class="smaller lighter blue"><b>Batas - batas Lokasi :</b></h5></td><td>&nbsp;</td>
        </tr>
        <tr>
            <td width="27%">Sebelah Barat</td>
            <td width="73%"><input type="text" value="<?=$sess['BATAS_BARAT_PDGB']?>" name="DATA[BATAS_BARAT_PDGB]" id="BATAS_BARAT_PDGB" class="mtext"  /></td>
        </tr>
        <tr>
            <td>Sebelah Timur</td>
            <td><input type="text" value="<?=$sess['BATAS_TIMUR_PDGB']?>" name="DATA[BATAS_TIMUR_PDGB]" id="BATAS_TIMUR_PDGB" class="mtext"  /></td>
        </tr>
        <tr>
            <td>Sebelah Utara</td>
            <td><input type="text" value="<?=$sess['BATAS_UTARA_PDGB']?>" name="DATA[BATAS_UTARA_PDGB]" id="BATAS_UTARA_PDGB" class="mtext"  /></td>
        </tr>
        <tr>
            <td>Sebelah Selatan</td>
            <td><input type="text" value="<?=$sess['BATAS_SELATAN_PDGB']?>" name="DATA[BATAS_SELATAN_PDGB]" id="BATAS_SELATAN_PDGB" class="mtext"   /></td>
        </tr>
    </table>
	</td>    
</tr></table>    

<table width="100%" border="0">
<tr>
    <td  colspan="7">&nbsp;</td>
</tr>
</table>       
</form>
</div>
<script>
$("input,textarea,select").attr('disabled',true);
</script>
