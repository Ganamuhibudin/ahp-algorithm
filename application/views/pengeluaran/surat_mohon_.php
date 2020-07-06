<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<div class="header">
    <a href="javascript:void(0)" 
    onclick="window.location.href='<?= site_url()."/pengeluaran/pemusnahan/surat/".$tujuan?>'" style="float:right;margin:-7px 0px 0px 0px" class="btn btn-success btn-sm prev" id="ok_"><span><i class="icon-backward"></i>&nbsp;Selesai&nbsp;</span></a>
    <h3><strong><?= $judul.""; ?></strong></h3>
</div>
<div class="content">
<form id="fsurat_" method="post" action="<?= site_url()."/pengeluaran/set_surat"; ?>" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="ADASURAT" value="1" />
<input type="hidden"  name="SURAT[KODE_TRADER]" value="<?= $this->newsession->userdata('KODE_TRADER') ?>"/> 
<input type="hidden"  name="SURAT[TUJUAN_PERMOHONAN]" value="<?=$tujuan?>"/> 
<input type="hidden"  name="DOKUMEN" value="<?=$dokumen?>"/> 
<input type="hidden"  name="TEMPAT_ASAL" value="<?=$tmp_asal?>"/> 
<input type="hidden"  name="JENIS_BARANG" value="<?=$jns_barang?>"/> 
<input type="hidden" name="SURAT[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
<table width="100%" border="0">
<tr><td width="45%" valign="top">
    <table width="100%" border="0">
    <tr>
        <td width="22%">Tanggal Surat</td>
        <td width="78%">
        <input type="text" name="SURAT[TGL_PERMOHONAN]" class="stext date" id="TGL_PERMOHONAN" value="<?= $DATA['TGL_PERMOHONAN'];?>" onFocus="ShowDP('TGL_PERMOHONAN')"  wajib="yes"/>&nbsp; YYYY-MM-DD </td>
    </tr>
    <tr>
        <td>Nomor Surat </td>
        <td><input type="text" name="SURAT[NO_PERMOHONAN]" id="NO_PERMOHONAN" value="<?= $DATA['NO_PERMOHONAN'];?>" class="text"  wajib="yes"/></td>
    </tr>
    <tr>
        <td>Perihal </td>
        <td><input type="text" name="SURAT[PERIHAL]" id="PERIHAL" value="<?= $DATA['PERIHAL'];?>" class="text"  wajib="yes"/></td>
    </tr>
     <tr>
        <td>Kantor Tujuan</td>
        <td><input type="text"  name="SURAT[KANTOR_TUJUAN]" id="kpbc" class="stext date" value="<?= $DATA['KANTOR_TUJUAN']; ?>" url="<?= site_url()?>/autocomplete/kpbc" urai="urkt;NAMA_PEMOHON;" wajib="yes" onfocus="Autocomp(this.id)"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-sm" onclick="tb_search('kpbc','kpbc;urkt','Kode Kpbc',this.form.id,650,445)" style="vertical-align:top" value="...">&nbsp;<span id="urkt"><?= $URKANTOR_TUJUAN; ?></span>		 		</td>
 	</tr>  
    <tr>
        <td>Nama Pemohon</td>
        <td><input type="text" name="SURAT[NAMA_PEMOHON]" id="NAMA_PEMOHON" value="<?= $DATA['NAMA_PEMOHON'];?>" class="text"  wajib="yes"/></td>
    </tr>
    <tr>
        <td>No. Identitas </td>
        <td><input type="text" name="SURAT[NOID_PEMOHON]" id="NOID_PEMOHON" value="<?= $DATA['NOID_PEMOHON'];?>" class="text"  wajib="yes"/></td>
    </tr>
    <tr>
        <td> <? if($LAMPIRAN!="none"){ echo "Lampiran ";}?> </td>
        <td>
		<? 
			if($act=="save"){
				if($LAMPIRAN!="none"){
					$val = explode("~",$LAMPIRAN); 
					echo $val[1];
				}
				echo '<input type="hidden" name="SURAT[LAMPIRAN]" id="LAMPIRAN" value="'.$val[0].'"/>';
			}else{
				echo $LAMPIRAN;
				echo '<input type="hidden" name="SURAT[LAMPIRAN]" id="LAMPIRAN" value="'.$DATA['LAMPIRAN'].'"/>';
			}
		
		?>        
        </td>
    </tr>
    </table>
</td>
<td width="55%" valign="top">
	<table width="100%" border="0">      
    <tr>
        <td width="22%">No. Surat Tugas/Kuasa </td>
        <td width="78%"><input type="text" name="SURAT[NO_SRT_TUGAS]" id="NO_SRT_TUGAS" value="<?= $DATA['NO_SRT_TUGAS'];?>" class="text"  wajib="yes"/></td>
    </tr>  
    <tr>
        <td>Telepon </td>
        <td><input type="text" name="SURAT[TELP_PEMOHON]" id="TELP_PEMOHON" value="<?= $DATA['TELP_PEMOHON'];?>" class="text"  wajib="yes"/></td>
    </tr>
    <tr>
        <td>Email </td>
        <td><input type="text" name="SURAT[EMAIL_PEMOHON]" id="email" value="<?= $DATA['EMAIL_PEMOHON'];?>" class="text"  wajib="yes"/></td>
    </tr>
     <tr>
        <td>Alasan Pemusnahan</td>
        <td><input type="text" name="SURAT[ALASAN_PEMUSNAHAN]" id="ALASAN_PEMUSNAHAN" value="<?= $DATA['ALASAN_PEMUSNAHAN'];?>" class="text"  wajib="yes"/></td>
    </tr>
     <tr>
        <td>Cara Pemusnahan</td>
        <td><input type="text" name="SURAT[CARA_PEMUSNAHAN]" id="CARA_PEMUSNAHAN" value="<?= $DATA['CARA_PEMUSNAHAN'];?>" class="text"  wajib="yes"/></td>
    </tr>
     <tr>
        <td>Lokasi Pemusnahan</td>
        <td><input type="text" name="SURAT[LOKASI_PEMUSNAHAN]" id="LOKASI_PEMUSNAHAN" value="<?= $DATA['LOKASI_PEMUSNAHAN'];?>" class="text"  wajib="yes"/></td>
    </tr>
    </table>
</td>
</tr>
<tr>
 	<td colspan="2">&nbsp;</td>
</tr>
<tr>
 	<td colspan="2">
   	<h5 class="header smaller lighter green">&nbsp;Detil Barang</h5>
   	<table width="100%" cellpadding="2" cellspacing="2" border="1" class="" id="tableBarang" bordercolor="#C4BEBE" style="border-color:#CAE8E3;text-align:center;">
        <thead>
        <tr align="center">
            <td width="84%"><strong>Kode & Nama Barang</strong></td>
            <td width="2%"><strong>Jenis Barang</strong></td>
            <td width="2%"><strong>Kondisi</strong></td>
            <td width="2%"><strong>Gudang</strong></td>
            <td width="2%"><strong>Rak</strong></td>
            <td width="2%"><strong>Sub Rak</strong></td>
            <td width="2%"><strong>Jumlah</strong></td>
            <td width="1%"><strong>Satuan</strong></td>
            <td width="3%">
             <a href="javascript:void(0)" onclick="addRowBarang('tableBarang','tr_barang')" title="Tambah Barang" class="add" style="color:#30AB12;font-size:22px;text-align:center"><i class="fa fa-plus-circle"></i></a>
            </td>
        </tr>
        </thead>
        <tbody>
       <? if($act=="save" || !$DETILBARANG){ ?>
        <tr id="tr_barang">
            <td class="alt2 left bright">
            <input type="text" name="DTLSURAT[KODE_BARANG][]" id="KODE_BARANGSRT1" style="width:10%;" class="text" url="<?= site_url()?>/autocomplete/barang2" urai="NM_BARANG;" onfocus="Autocomp(this.id)" />&nbsp;<input type="text" name="NM_BARANG[]" id="NM_BARANG" style="width:60%;" class="text"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-sm" onclick="tb_search('kodebarang','KODE_BARANGSRT1;NM_BARANG','Kode Barang',this.form.id,600,400)" style="width:4.5%;height:10%;vertical-align:top" value="...">
            </td>
            <td id="tdJenisBarang" class="alt2 bright">
            <?= form_dropdown('DTLSURAT[JNS_BARANG][]', array_merge(array(""=>"- Pilih -"),$JENIS_BRG), '', 'id="JENIS" class="stext" ');?>
            </td>
            <td id="tdKondisiBarang" class="alt2 bright">
            <?= form_dropdown('DTLSURAT[KONDISI][]', array_merge(array(""=>"- Pilih -"),$KONDISI_BARANG), '', 'id="KONDISI" class="sstext" ');?>
            </td>
            <td class="alt2 bright">
            <?= form_dropdown('DTLSURAT[KODE_GUDANG][]', array_merge(array(""=>"- Pilih -"),$GUDANG), '', 'id="KODE_GUDANG" class="sstext" ');?>
            </td>
            <td class="alt2 bright">
            <?= form_dropdown('DTLSURAT[KODE_RAK][]', array_merge(array(""=>"- Pilih -"),$RAK), '', 'id="KODE_RAK" class="sstext" ');?>
            </td>
            <td class="alt2 bright">
            <?= form_dropdown('DTLSURAT[KODE_SUB_RAK][]', array_merge(array(""=>"- Pilih -"),$SUB_RAK), '', 'id="KODE_SUB_RAK" class="sstext" ');?>
            </td>
            <td class="alt2 bright">
            <input type="text" name="DTLSURAT[JUMLAH][]" id="JUMLAH_BARANG" class="stext" />
            </td>
            <td class="alt2 bright">
            <input type="text" name="DTLSURAT[KODE_SATUAN][]" id="KODE_SATUAN" class="ssstext" url="<?= site_url()?>/autocomplete/satuan" urai="" onfocus="Autocomp(this.id)"/>
            </td>
            <td class="alt2 right">&nbsp;</td>
        </tr>    
        <? 
		 }else{ 
		 	echo $DETILBARANG;
		 }
		?>
        </tbody>
	</table>    
    </td>
</tr>
<tr>
 	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
    <a href="javascript:void(0);" class="btn btn-success btn-sm save" id="ok_" onclick="save_post('#fsurat_');"><span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning btn-sm cancel" id="cancel_" onclick="cancel('fsurat_');"><span><i class="icon-undo"></i>&nbsp;cancel&nbsp;</span></a><span class="msg_" style="margin-left:20px">&nbsp;</span>
	</td>
</tr>
</table>
</form>
</div>