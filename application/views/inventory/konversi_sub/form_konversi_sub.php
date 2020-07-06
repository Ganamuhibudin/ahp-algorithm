<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="save"){
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;MERK;TIPE;UKURAN;SPF;KODE_SATUAN','Kode Barang',this.form.id,650,445)";
	$btn='<input type="button" name="cari" id="cari" class="button" onclick="'.$event.'" value="...">';
	//$event="onclick=popup('konversi_subBB','add')";
	$readonly="readonly=readonly";
	$addUrl="add/konversi_subPOP";
	$div="divAddKonversiSub";
	$jenis="add";
	$MSG="msgKonv_";
}elseif($act=="save new"){
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;MERK;TIPE;UKURAN;SPF;KODE_SATUAN','Kode Barang',this.form.id,650,445)";
	$btn='<input type="button" name="cari" id="cari" class="button" onclick="'.$event.'" value="...">';
	//$event="onclick=popup('konversi_subBB','add')";
	$readonly="readonly=readonly";
	$addUrl="add/konversi_subPOPN";
	$div="divAddKonversiSub";
	$jenis="addKnv";
	$MSG="msgKonv_";
}elseif($act=="update new"){
	$event="";
	$readonly="readonly=readonly";
	$addUrl="edit/konversi_subPOPN";
	$div="divEditKonversiSub";
	$jenis="edit";
	$MSG="msgKonv_";
}else{
	$event="";
	$readonly="readonly=readonly";
	$addUrl="edit/konversi_subPOP";
	$div="divEditKonversiSub";
	$jenis="edit";
	$MSG="msgKonv_";
}//echo $kode;
?>	
<div class="content_luar">
<div class="content_dalam">
<? if($act=="save new"){?>
<a href="javascript:void(0)" 
onclick="ClosePopUp('<?= base_url()."index.php/inventory/add/Konversi_Sub_New/".$idBJ."/".$kode;?>','<?= $div;?>','<?= $jenis;?>');" style="float:right;margin:-5px 0px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Selesai&nbsp;</span></a>
<? }else{?>
<a href="javascript:void(0)" 
onclick="ClosePopUp('<?= base_url()."index.php/inventory/edit/konversi_sub_detil/".$idBJ."/".$kode;?>','<?= $div;?>','<?= $jenis;?>');" style="float:right;margin:-5px 0px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Selesai&nbsp;</span></a>
<? }?>
<h4><span class="info_2">&nbsp;</span><?= $judul;?></h4>
<form name="fKonvSub" id="fKonvSub" action="<?= site_url()."/inventory/".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="IDBJ" id="IDBJ" value="<?= $idBJ?>" />
<input type="hidden" name="IDBB" id="IDBB" value="<?= $sess['IDBB'];?>" />
<input type="hidden" name="KODE_TRADER" id="KODE_TRADER" value="<?= $sess['KODE_TRADER']?$sess['KODE_TRADER']:$kode;?>">
<input type="hidden" name="JNS_BARANG" id="JNS_BARANG" value="<?= $sess['JNS_BARANG']?$sess['JNS_BARANG']:"";?>">
<input type="hidden" name="KONVBB[KODE_SATUAN]" id="KODE_SATUAN" value="<?= $sess['KODE_SATUAN']?>">
<span id="divtmp"></span>
<table width="100%" border="0">
<tr><td width="48%" valign="top">	
<table width="100%" border="0">
	<tr>
        <td width="180">Kode Barang</td>
        <td width="299">
        <input type="text" name="KODE_BARANG" id="KODE_BARANG" <?= $readonly;?> onclick="<?= $event;?>" class="stext" value="<?= $sess['KODE_BARANG']; ?>" wajib="yes"/>&nbsp;<?=$btn?>
    </tr> 
    <tr>
        <td>Uraian Barang </td>
        <td>
        <textarea name="URAIAN_BARANG" id="URAIAN_BARANG" wajib="yes" <?= $readonly;?> class="text"><?= $sess['URAIAN_BARANG']; ?></textarea></tr>
    <tr>
        <td>Jenis Barang</td>
        <td>
        <input type="text" name="JENIS_BARANG" id="JENIS_BARANG" <?= $readonly;?> class="text" value="<?= $sess['JENIS BARANG']; ?>" wajib="yes"/>
    </tr> 
     <tr>
        <td>Jumlah</td>
        <td>
        <input type="text" name="KONVBB[JUMLAH]" id="JUMLAH"  class="stext date" value="<?= $sess['JUMLAH']; ?>" wajib="yes" format="angka"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" <?= $readonly;?> value="<?= $sess['SATUAN'];?>" name="URAIAN_SATUAN" class="stext date" /><span id="uraisatSubknv"><?= $sess['SATUAN']; ?></span></td>
    </tr>  
</table>
</td><td width="52%">
<table width="100%" border="0">
	<tr>
        <td width="20%">Merk Barang</td>
        <td width="33%">
        <input type="text" name="MERK" id="MERK" <?= $readonly;?> class="text" value="<?= $sess['MERK']; ?>" wajib="no"/></td>
    </tr> 
    <tr>
        <td>Tipe Barang</td>
        <td>
        <input type="text" name="TIPE" id="TIPE" wajib="no" <?= $readonly;?> class="text" value="<?= $sess['TIPE']; ?>">
        </td>
    <tr>
        <td>Ukuran Barang</td>
        <td>
        <input type="text" name="UKURAN" id="UKURAN" <?= $readonly;?> class="text" value="<?= $sess['UKURAN']; ?>" wajib="no"/>
        </td>
    </tr> 
     <tr>
        <td>Spesifikasi Lain</td>
        <td>
        <input type="text" name="SPF" id="SPF" <?= $readonly;?> class="text" value="<?= $sess['SPFLAIN']; ?>" wajib="no"/>
        </td>
    </tr> 
    <tr>
        <td>Keterangan</td>
        <td>
        <textarea name="KONVBB[KETERANGAN]" id="KETERANGAN" wajib="no" class="text"><?= $sess['KETERANGAN']; ?></textarea>
        </td>
</table>
</td></tr></table></td>
</tr>

<td width="55%" valign="top"></td>		
</table>

</td><td width="21%"></td></tr></table></td>
</tr>
<tr>
	<td colspan="2"><!--save_POP(formid,msg,divData,page,jenis,divDialog){-->
    <? if($act=="save" || $act=="update"){?>
    <a href="javascript:void(0);" class="button save" id="ok_" onclick="save_POP('#fKonvSub','<?= $MSG;?>','divkonversi_sub_detil','<?= base_url()."index.php/inventory/daftar_dok/konversi_sub_detil/".$idBJ."/".$kode;?>','<?= $jenis;?>','<?= $div;?>');"><span><span class="icon"></span>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;
	<? }else{?>
    <a href="javascript:void(0);" class="button save" id="ok_" onclick="save_POP('#fKonvSub','<?= $MSG;?>','divkonversi_sub_new','<?= base_url()."index.php/inventory/daftar_dok/konversi_sub_new/".$idBJ."/".$kode;?>','<?= $jenis;?>','<?= $div;?>');"><span><span class="icon"></span>&nbsp;<?= $act=="save new"?"save":"update"; ?>&nbsp;</span></a>&nbsp;
    <? }?>
    <a href="javascript:;" class="button cancel" id="cancel_" onclick="cancel('fKonvSub');"><span><span class="icon"></span>&nbsp;reset&nbsp;</span></a><span class="<?= $MSG;?>" style="margin-left:20px">&nbsp;</span>
	</td>
</tr>
<td width="55%" valign="top"></td>		
</table>
</form>
</div></div>
<script>
$('#divAddKonversiSub,#divEditKonversiSub').live("dialogclose", function(){
  var aksi=$("#act").val();
  if(aksi=="save new" || aksi=="update new"){
  	location.href= "<?= base_url()."index.php/inventory/add/Konversi_Sub_New/".$idBJ."/".$kode;?>";	 
  }else{
  	location.href= "<?= base_url()."index.php/inventory/edit/konversi_sub_detil/".$idBJ."/".$kode;?>";  
  }
});
</script>
