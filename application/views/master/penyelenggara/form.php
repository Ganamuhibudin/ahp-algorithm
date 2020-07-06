<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

/*if (strtolower($act) == "save") {
			$action = "add";
			$readonly = "";
	} else {
			$action = "edit";
			$readonly = "readonly";
}*/
if (strtolower($act) == "save") {
			$action = "add";
			$readonly = "";
			$url = site_url()."/master/".$action."/penyelenggara";
} else if(strtolower($act=="update")) {
			$action = "edit";
			$readonly = "readonly";
			$url = site_url()."/master/".$action."/penyelenggara";
} else {
			$url = current_url()."/setdata/";
}
?>
<div class="header">
<h3><i class="fa fa-home"></i>&nbsp;<strong><?= $judul; ?></strong></h3>
</div>
<div class="content">
<form name="fpenyelenggara" id="fpenyelenggara" action="<?= $url; ?>" method="post" autocomplete="off" role="form">
<!--<input type="hidden" name="PENYELENGGARA['JENIS_PLB']" value="00">-->
<input type="hidden" name="act" value="<?= $act; ?>">
<input type="hidden" name="KODE_TRADER" id="KODE_TRADER_HIDE" value="<?= $sess['KODE_TRADER']; ?>">
<table width="100%" border="0">
	<tr>
		<td width="40%" valign="top">
    		<table width="100%" border="0">
            	<tr>
            		<td colspan="2"><h4 class="smaller lighter blue"><b>Data Perusahaan :</b></h4></td>            		
        		</tr>
                <tr>
                	<td> Jenis PLB </td>
                    <td><combo><?= form_dropdown('PENYELENGGARA[JENIS_PLB]', $JENIS_PLB, $sess['JENIS_PLB'], 'id="JENIS_PLB" class="text" style="width:85%" wajib="yes"'); ?></combo></td>
                </tr>
        		<tr>
            		<td width="40%">Identitas</td>
            		<td width="60%">
					<combo><?= form_dropdown('PENYELENGGARA[KODE_ID]', $kode_id_trader, $sess['KODE_ID'], 'id="kode_id_trader" class="stext date ac_input" style="width:40%" wajib="yes"'); ?></combo>&nbsp;
            		  <input type="text" wajib="yes" name="PENYELENGGARA[ID]" maxlength="15" id="ID" class="stext date ac_input" value="<?php if($sess['KODE_ID']==5){ echo $this->fungsi->FORMATNPWP($sess['ID']);}else{ echo $sess['ID'];}?>" <?= $disable; ?> style="width:41%"/></td>
        		</tr>
        		<tr>
            		<td>Nama</td>
            		<td><input type="text" name="PENYELENGGARA[NAMA]" id="NAMA" class="form-control" value="<?=$sess['NAMA']?>" style="width:85%" maxlength="50" wajib="yes" /></td>
        		</tr>
        		<tr>
            		<td>Alamat</td>
            		<td><textarea name="PENYELENGGARA[ALAMAT]" id="ALAMAT" wajib="yes" maxlength="70" class="form-control" style="width:85%"><?=$sess['ALAMAT']?></textarea></td>
        		</tr>
        		<tr>
            		<td>Nomor Telepon</td>
            		<td><input type="text" name="PENYELENGGARA[TELEPON]" id="TELEPON" class="form-control" style="width:85%" maxlength="15" value="<?=$sess['TELEPON']?>" wajib="yes" /></td>
        		</tr>
        		<tr>
            		<td>Nomor Fax</td>
            		<td><input type="text" name="PENYELENGGARA[FAX]" id="FAX" class="form-control" style="width:85%" maxlength="15" value="<?=$sess['FAX']?>" wajib="yes" /></td>
        		</tr>
        		<tr>
            		<td>Bidang Usaha</td>
            		<td><input type="text" name="PENYELENGGARA[BIDANG_USAHA]" id="BIDANG_USAHA" class="form-control" maxlength="30" style="width:85%" value="<?=$sess['BIDANG_USAHA']?>" wajib="yes"/></td>
        		</tr>
        		<tr>
            		<td>Jenis Usaha</td>
            		<td><combo><?= form_dropdown('PENYELENGGARA[JENIS_TRADER]', $JENIS_TPB, $sess['JENIS_TRADER'], 'id="JENIS_TRADER" class="text" style="width:85%" wajib="yes"'); ?></combo></td>
        		</tr>
        		<tr>
            		<td>Status Usaha</td>
            		<td><combo><?= form_dropdown('PENYELENGGARA[STATUS_TRADER]',$TIPE_TRADER,$sess['STATUS_TRADER'],'id="STATUS_TRADER" class="text" style="width:85%" wajib="yes"'); ?></combo></td>
        </tr>
        		<tr>
            		<td>Nomor</td>
            		<td><combo><?= form_dropdown('PENYELENGGARA[KODE_API]', $kode_api_trader, $sess['KODE_API'], 'id="kode_api_trader" class="stext date ac_input" style="width:30%"'); ?></combo>&nbsp;
            		  <input type="text" name="PENYELENGGARA[NOMOR_API]" id="NOMOR_API" class="stext date ac_input" style="width:51%" value="<?=$sess['NOMOR_API'];?>"/></td>
        		</tr>
        		<tr>
            		<td>Nomor SRP/SIP</td>
            		<td><input type="text" name="PENYELENGGARA[NOMOR_SRP]" maxlength="30" id="NOMOR_SRP" class="form-control" style="width:85%" value="<?=$sess['NOMOR_SRP']?>"/></td>
        		</tr>
                <tr>
            		<td>Jenis Barang Timbun</td>
            		<td><input type="text" name="PENYELENGGARA[JENIS_BARANG_TIMBUN]" id="JENIS_BARANG_TIMBUN" class="form-control" style="width:85%" value="<?=$sess['JENIS_BARANG_TIMBUN']?>" maxlength="100"/></td>
        		</tr>
                <tr>
            		<td>Tujuan Diatribusi</td>
            		<td><input type="text" name="PENYELENGGARA[TUJUAN_DISTRIBUSI]" id="TUJUAN_DISTRIBUSI" class="form-control" style="width:85%" value="<?=$sess['TUJUAN_DISTRIBUSI']?>" maxlength="100"/></td>
        		</tr>
                <!--<tr>
            		<td>NIPER</td>
            		<td><input type="text" name="PENYELENGGARA[NIPER]" id="NIPER" class="form-control" style="width:85%" value="<?= $sess['NIPER']?>" maxlength="4"/></td>
        		</tr>-->
                <tr>
            		<td colspan="2"><h4 class="smaller lighter blue"><b>Data Lokasi :</b></h4></td>            		
        		</tr>
                <tr>
            		<td>Lokasi</td>
            		<td><input type="text" name="PENYELENGGARA[LOKASI_GB]" id="LOKASI_GB" class="form-control" style="width:85%" value="<?= $sess['LOKASI_GB']?>" maxlength="70"/></td>
        		</tr>
                <tr>
            		<td>Desa/Kelurahan</td>
            		<td><input type="text" name="PENYELENGGARA[DESA_KEL_GB]" id="DESA_KEL_GB" class="form-control" style="width:85%" value="<?=$sess['DESA_KEL_GB']?>" maxlength="30"/></td>
        		</tr>
                <tr>
            		<td>Kecamatan</td>
            		<td><input type="text" name="PENYELENGGARA[KECAMATAN_GB]" id="KECAMATAN_GB" class="form-control" style="width:85%" value="<?=$sess['KECAMATAN_GB']?>" maxlength="30"/></td>
        		</tr>
                <tr>
            		<td>Kota</td>
            		<td><!--<input type="text" name="PENYELENGGARA[KOTA_GB]" id="KOTA_GB" class="form-control" style="width:85%" value="<?=$sess['KOTA_GB']?>" maxlength="30"/>-->
                    <combo><?= form_dropdown('PENYELENGGARA[KOTA_GB]', $KOTA_GB, $sess['KOTA_GB'], 'id="KOTA_GB" class="text" style="width:85%"'); ?></combo>
                    </td>
        		</tr>
                <tr>
            		<td>Provinsi</td>
            		<td>
                    <combo><?= form_dropdown('PENYELENGGARA[PROPINSI_GB]', $PROPINSI_GB, $sess['PROPINSI_GB'], 'id="PROPINSI_GB" class="text" style="width:85%"'); ?></combo>
                    <!--<input name="PENYELENGGARA[PROPINSI_GB]" id="KODE_DAERAH" value="<?php //echo $sess['PROPINSI_GB']; ?>" class="stext date ac_input" type="text" style="width:70%" maxlength="30">
                    <button class="btn btn-primary btn-xs" style="width:11%" type="button" onclick="tb_search('daerah','KODE_DAERAH','Uraian Daerah',this.form.id,650,400)">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>-->
                    </td>
        		</tr>               
        		
        		<tr>
            		<td colspan="7">&nbsp;</td>
        			</tr>
    		</table>    
		</td>
		<td width="60%" valign="top">
			<table width="70%" border="0">
            	<tr>
            		<td colspan="2"><h4 class="smaller lighter blue"><b>Data Pemilik :</b></h4></td>            		
        		</tr>
        		<tr>
            		<td width="40%">Nama Pemilik</td>
            		<td width="60%"><input type="text" name="PENYELENGGARA[NAMA_PENANGGUNGJAWAB]" id="NAMA_PENANGGUNGJAWAB" class="form-control" style="width:85%" maxlength="50" value="<?=$sess['NAMA_PENANGGUNGJAWAB']?>" wajib="yes"/>
            		</td>
        		</tr>
      <!--  <tr>
            <td>Tempat/Tanggal Lahir Pemilik</td>
            <td>: <input type="text" name="PENYELENGGARA[TEMPAT_LAHIR_PEMILIK]" id="TEMPAT_LAHIR_PEMILIK" class="dtext" value="<?=$sess['TEMPAT_LAHIR_PEMILIK']?>"  <?= $disable; ?>/>&nbsp;<input type="text" name="PENYELENGGARA[TANGGAL_LAHIR_PEMILIK]" id="TANGGAL_LAHIR_PEMILIK" class="stext date" value="<?=$sess['TANGGAL_LAHIR_PEMILIK'];?>" onfocus="ShowDP(this.id)" <?= $disable; ?>/></td>
        </tr>-->
        		<tr>
            		<td>Alamat Pemilik</td>
            		<td><textarea name="PENYELENGGARA[ALAMAT_PENANGGUNGJAWAB]" id="ALAMAT_PENANGGUNGJAWAB" class="form-control" style="width:85%" maxlength="50" wajib="yes" ><?=$sess['ALAMAT_PENANGGUNGJAWAB']?></textarea></td>
        		</tr>
      <!--  <tr>
        	<td>EDI Number</td>
        	<td>: <input type="text" name="PENYELENGGARA[EDINUMBER]" id="EDINUMBER" class="mtext" value="<?=$sess['EDINUMBER']?>" <?= $disable; ?>/></td>
        </tr>-->
        		<tr>
            		<td>Kode Skep</td>
            		<td><input type="text" name="PENYELENGGARA[KODE_SKEP]" id="KODE_SKEP" class="stext date ac_input" style="width:70%" value="<?=$sess['KODE_SKEP']?>" maxlength="2"/>
                     <button class="btn btn-primary btn-xs" style="vertical-align:top" type="button" onclick="tb_search('skep','KODE_SKEP;URSKEP','Skep Perusahaan',this.form.id,650,430)"><i class="fa fa-search"></i></button>
            		</td>
        		</tr>
                <tr>
            		<td>&nbsp;</td>
            		<td><textarea name="URSSKEP" id="URSKEP" class="form-control" style="width:85%"><?= $sess['NAMA_SKEP']; ?></textarea></td>
        		</tr>
                <tr>
            		<td>Nomor Skep</td>
            		<td><input type="text" name="PENYELENGGARA[NOMOR_SKEP]" id="NOMOR_SKEP" class="form-control" style="width:85%" value="<?=$sess['NOMOR_SKEP']?>" maxlength="30"/>
            		</td>
        		</tr>
                <tr>
            		<td>Tanggal Skep</td>
            		<td>
                    <input type="text" name="PENYELENGGARA[TANGGAL_SKEP]" id="TANGGAL" class="stext date ac_input" style="width:60%" value="<?= $sess['TANGGAL_SKEP']; ?>" onfocus="ShowDP(this.id);" placeholder="YYYY-MM-DD"/>
            		</td>
        		</tr>
       <!-- <tr>
            <td><?$produksi ?></td>
            <td>&nbsp;</td>
        </tr>-->
        		<tr>
        			<td colspan="2">&nbsp;</td>
        		</tr>
                <tr>
            		<td colspan="2"><h4 class="smaller lighter blue"><b>Data Penanggung Jawab :</b></h4></td>            		
        		</tr>
                <tr>
            		<td>Nama</td>
            		<td><input type="text" name="PENYELENGGARA[NAMA_USER]" id="NAMA_USER" class="form-control" style="width:85%" value="<?=$sess['NAMA_USER']?>" maxlength="50" wajib="yes"/>
            		</td>
        		</tr>
                <tr>
            		<td>Alamat</td>
            		<td>
                    <textarea name="PENYELENGGARA[ALAMAT_USER]" id="ALAMAT_USER" wajib="yes" maxlength="70" class="form-control" style="width:85%"><?=$sess['ALAMAT_USER']?></textarea>
            		</td>
        		</tr>
                <tr>
            		<td>Nomer Telephon</td>
            		<td><input type="text" name="PENYELENGGARA[TELEPON_USER]" id="TELEPON_USER" class="form-control" style="width:85%" value="<?=$sess['TELEPON_USER']?>" maxlength="25"/>
            		</td>
        		</tr>
                <tr>
            		<td>Email</td>
            		<td><input type="text" name="PENYELENGGARA[EMAIL_USER]" id="EMAIL_USER" class="form-control" style="width:85%" value="<?=$sess['EMAIL_USER']?>" maxlength="70" wajib="yes"/>
            		</td>
        		</tr>
                <tr>
            		<td>Jabatan</td>
            		<td><input type="text" name="PENYELENGGARA[JABATAN_USER]" wajib="yes" id="JABATAN_USER" class="form-control" style="width:85%" value="<?=$sess['JABATAN_USER']?>" maxlength="50"/>
            		</td>
        		</tr>
                <tr>
            		<td colspan="2"><h4 class="smaller lighter blue"><b>Data User Admin :</b></h4></td>            		
        		</tr>
                <tr>
            		<td>Username</td>
            		<td><input type="text" name="PENYELENGGARA[USERNAME]" id="USERNAME" class="form-control" style="width:85%" value="<?=$sess['USERNAME']?>" maxlength="30" wajib="yes"/>
            		</td>
        		</tr>
                <tr>
            		<td>Password</td>
            		<td><input type="password" name="PENYELENGGARA[PASSWORD]" id="PASSWORD" class="form-control" style="width:85%" value="<?=$sess['PASSWORD']?>" maxlength="100" wajib="yes"/>
            		</td>
        		</tr>
                <tr>
            		<td>Konfirmasi Password</td>
            		<td><input type="password" name="KONFPASSWORD" id="KONFPASSWORD" class="form-control" style="width:85%" value="<?= isset($sess['PASS']) ? md5($sess['PASS']) : $sess['PASS']; ?>" maxlength="100" wajib="yes"/>
            		</td>
        		</tr>
                
    		</table>
		</td>
	</tr>
</table>   
<table width="100%" border="0">
	<tr>
    	<td width="40%" valign="top">
    		<table width="100%" border="0">
    			<tr>
        			<td colspan="2">Luas Lokasi Keseluruhan GB (Penyelenggara GB)&nbsp;: 
        	  <input type="text" name="PENYELENGGARA[LUAS_LOKASI_GB]" id="LUAS_LOKASI_GB" class="stext date ac_input" style="width:10%" value="<?=$sess['LUAS_LOKASI_GB']?>"/>&nbsp;M<sup>2</sup></td>
        		</tr>
    			<tr>
        			<td colspan="2"><h4 class="smaller lighter blue"><b>Batas - batas Lokasi :</b></h4></td>
        		</tr>
        		<tr>
           		  <td width="40%">Sebelah Barat</td>
           		  <td width="60%"><input type="text" name="PENYELENGGARA[BATAS_BARAT_GB]" id="BATAS_BARAT_GB" class="form-control" style="width:85%" maxlength="30" value="<?=$sess['BATAS_BARAT_GB']?>"/>
            		</td>
        		</tr>
        		<tr>
            		<td>Sebelah Timur</td>
            		<td><input type="text" name="PENYELENGGARA[BATAS_TIMUR_GB]" id="BATAS_TIMUR_GB" class="form-control" maxlength="30" style="width:85%" value="<?=$sess['BATAS_TIMUR_GB']?>"/></td>
        		</tr>
        		<tr>
            		<td>Sebelah Utara</td>
            		<td><input type="text" name="PENYELENGGARA[BATAS_UTARA_GB]" id="BATAS_UTARA_GB" class="form-control" maxlength="30" style="width:85%" value="<?=$sess['BATAS_UTARA_GB']?>"/></td>
        		</tr>
        		<tr>
            		<td>Sebelah Selatan</td>
            		<td><input type="text" name="PENYELENGGARA[BATAS_SELATAN_GB]" id="BATAS_SELATAN_GB" class="form-control" maxlength="30" style="width:85%" value="<?=$sess['BATAS_SELATAN_GB']?>" /></td>
        		</tr>
    		</table>
		</td>
    	<td width="60%" valign="top">
    		<table width="70%" border="0">
    			<tr>
        			<td colspan="2">Luas Lokasi Keseluruhan GB yg diusahakan sendiri (Pengusaha GB)&nbsp;: 
        	  <input type="text" name="PENYELENGGARA[LUAS_LOKASI_PDGB]" id="LUAS_LOKASI_PDGB" class="stext date ac_input"  style="width:10%" value="<?=$sess['LUAS_LOKASI_PDGB']?>"/>&nbsp;M<sup>2</sup></td>
        		</tr>
    			<tr>
        			<td colspan="2"><h4 class="smaller lighter blue"><b>Batas - batas Lokasi :</b></h4></td>
        		</tr>
        		<tr>
            		<td width="40%">Sebelah Barat</td>
            		<td width="60%"><input type="text" name="PENYELENGGARA[BATAS_BARAT_PDGB]" id="BATAS_BARAT_PDGB" class="form-control" style="width:85%" maxlength="30" value="<?=$sess['BATAS_BARAT_PDGB']?>" /></td>
        		</tr>
        		<tr>
            		<td>Sebelah Timur</td>
            		<td><input type="text" name="PENYELENGGARA[BATAS_TIMUR_PDGB]" id="BATAS_TIMUR_PDGB" class="form-control" maxlength="30" style="width:85%" value="<?=$sess['BATAS_TIMUR_PDGB']?>"/></td>
        		</tr>
        		<tr>
            		<td>Sebelah Utara</td>
            		<td><input type="text" name="PENYELENGGARA[BATAS_UTARA_PDGB]" id="BATAS_UTARA_PDGB" class="form-control" maxlength="30" style="width:85%" value="<?=$sess['BATAS_UTARA_PDGB']?>"/></td>
        		</tr>
        		<tr>
            		<td>Sebelah Selatan</td>
            		<td><input type="text" name="PENYELENGGARA[BATAS_SELATAN_PDGB]" id="BATAS_SELATAN_PDGB" maxlength="30" class="form-control" style="width:85%" value="<?=$sess['BATAS_SELATAN_PDGB']?>"/></td>
        		</tr>
    		</table>
		</td>    
	</tr>
</table>    

<table width="100%" border="0">
	<tr>
    	<td  colspan="7">&nbsp;</td>
	</tr>
<?php if($this->newsession->userdata('KODE_ROLE')!='5'){#ROLE BUKAN BC?>
	<tr>
    	<td colspan="7">
      		<a href="javascript:void(0)" class="btn btn-success btn-l" onclick="save_post('#fpenyelenggara')">
					<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
	  		</a>&nbsp; &nbsp; 
      		<a href="javascript:void(0)" class="btn btn-warning btn-l" onclick="cancel('fpenyelenggara')"><i class="fa icon-undo"></i>Reset</a>&nbsp;
      <span class="msg_" id="msg_" align="left"  style="margin-left:20px">&nbsp;</span>
      	</td>      
	</tr>
<?php }?>
</table>    
</form>
</div>
<script>
	FormReady();
</script>