<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="save"){
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;MERK;TIPE;UKURAN;SPF;KODE_SATUAN','Kode Barang',this.form.id,650,445)";
	//$event="popup('konversiBB','add')";
	$readonly="readonly=readonly";
	$addUrl="add/konversiPOP";
	$div="divAddKonversi";
	$jenis="add";
	$MSG="msgKonv_";
}elseif($act=="save new"){
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;MERK;TIPE;UKURAN;SPF;KODE_SATUAN','Kode Barang',this.form.id,650,445)";
	//$event="popup('konversiBB','add')";
	$readonly="readonly=readonly";
	$addUrl="add/konversiPOPN";
	$div="divAddKonversi";
	$jenis="addKnv";
	$MSG="msgKonv_";
}elseif($act=="update new"){
	$event="";
	$readonly="readonly=readonly";
	$addUrl="edit/konversiPOPN";
	$div="divEditKonversi";
	$jenis="edit";
	$MSG="msgKonv_";
}else{
	$event="";
	$readonly="readonly=readonly";
	$addUrl="edit/konversiPOP";
	$div="divEditKonversi";
	$jenis="edit";
	$MSG="msgKonv_";
}//echo $addUrl;
?>	
<div class="content">
<!--<? if($act=="save new"){?>
<a href="javascript:void(0)" 
onclick="ClosePopUp('<?= base_url()."index.php/inventory/add/Konversi_New/".$idBJ."/".$kode;?>','<?= $div;?>','<?= $jenis;?>');" style="float:right;margin:-5px 0px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Selesai&nbsp;</span></a>
<? }else{?>
<a href="javascript:void(0)" 
onclick="ClosePopUp('<?= base_url()."index.php/inventory/edit/konversi_detil/".$idBJ."/".$kode;?>','<?= $div;?>','<?= $jenis;?>');" style="float:right;margin:-5px 0px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Selesai&nbsp;</span></a>
<? }?>-->
<div class="header"><h4><?= $judul;?></h4></div><br>
<form name="fKonv" id="fKonv" action="<?= site_url()."/inventory/".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="IDBJ" id="IDBJ" value="<?= $idBJ?>" />
<input type="hidden" name="IDBB" id="IDBB" value="<?= $sess['IDBB'];?>" />
<input type="hidden" name="KODE_TRADER" id="KODE_TRADER" value="<?= $sess['KODE_TRADER']?$sess['KODE_TRADER']:$resultTrader['KODE_TRADER'];?>">
<input type="hidden" name="JNS_BARANG" id="JNS_BARANG" value="<?= $sess['JNS_BARANG']?$sess['JNS_BARANG']:"";?>">
<input type="hidden" name="KONVBB[KODE_SATUAN]" id="KODE_SATUAN" value="<?= $sess['KODE_SATUAN']?>">
<span id="divtmp"></span>
<table width="100%" border="0">
<tr><td width="48%" valign="top">	
<table width="100%" border="0">
	<tr>
        <td width="180">Kode Barang </td>
        <td width="299">
        <input type="text" name="KODE_BARANG" id="KODE_BARANG" onclick="<?= $event;?>" class="stext" <?= $readonly;?> value="<?= $sess['KODE_BARANG']; ?>" wajib="yes"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="<?= $event;?>" value="&bull;&bull;&bull;">
    </tr> 
    <tr>
        <td width="180">Uraian Barang </td>
        <td width="299">
        <textarea name="URAIAN_BARANG" id="URAIAN_BARANG" wajib="yes" <?= $readonly;?> class="text"><?= $sess['URAIAN_BARANG']; ?></textarea></tr>
    <tr>
        <td width="180">Jenis Barang</td>
        <td width="299">
        <input type="text" name="JENIS_BARANG" id="JENIS_BARANG" <?= $readonly;?> class="text" value="<?= $sess['JENIS BARANG']; ?>" wajib="yes"/>
    </tr> 
     <tr>
        <td width="180">Jumlah</td>
        <td width="299">
        <input type="text" name="KONVBB[JUMLAH]" id="JUMLAH"  class="stext date" value="<?= $sess['JUMLAH']; ?>" wajib="yes" format="angka"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" <?= $readonly;?> value="<?= $sess['SATUAN'];?>" name="URAIAN_SATUAN" class="stext date" /><span id="uraisatknv"><?= $sess['SATUAN']; ?></td>
    </tr>  
</table>
</td><td width="52%">
<table width="100%" border="0">
    <tr>
        <td width="20%">Merk Barang</td>
        <td width="33%">
            <input type="text" name="MERK" id="MERK" <?= $readonly;?> class="text" value="<?= $sess['MERK']; ?>" wajib="no"/>
       </td>
    </tr> 
    <tr>
        <td>Tipe Barang</td>
        <td>
        <input type="text" name="TIPE" id="TIPE" wajib="no" <?= $readonly;?> class="text" value="<?= $sess['TIPE']; ?>">
        </td>
     </tr>
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
    </tr>  
</table>
</td></tr></table></td>
</tr>

<td width="55%" valign="top"></td>		
</table>

</td><td width="21%"></td></tr></table></td>
</tr>
<tr>
	<td colspan="2"><!--save_POP(formid,msg,divData,page,jenis,divDialog){-->
 
	</td>
</tr>
<td width="55%" valign="top"></td>		
</table>
</div>
   <? if($act=="save" || $act=="update"){?>
    <a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_POP('#fKonv','<?= $MSG;?>','divkonversi_detil','<?= base_url()."index.php/inventory/daftar_dok/konversi_detil/".$idBJ."/".$kode;?>','<?= $jenis;?>','<?= $div;?>');"><span style="color:#fff"><i class="fa fa-save"></i>&nbsp;<?= ucfirst($act); ?></span></a>&nbsp;
    <? }else{?>
    <a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_POP('#fKonv','<?= $MSG;?>','divkonversi_new','<?= base_url()."index.php/inventory/daftar_dok/konversi_new/".$idBJ."/".$kode;?>','<?= $jenis;?>','<?= $div;?>');"><span style="color:#fff"><i class="fa fa-save"></i>&nbsp;<?= $act=="save new"?"Save":"Update"; ?></span>&nbsp;</a>&nbsp;
    <? }?>
    <a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('fKonv');"><span style="color:#fff"><i class="fa fa-undo"></i>Reset</span></a>&nbsp;<span class="<?= $MSG;?>" style="margin-left:20px">&nbsp;</span>
</form>

<script>
$('#divAddKonversi,#divEditKonversi').live("dialogclose", function(){
  var aksi=$("#act").val();
  if(aksi=="save new" || aksi=="update new"){
  	location.href= "<?= base_url()."index.php/inventory/add/Konversi_New/".$idBJ."/".$kode;?>";	 
  }else{
  	location.href= "<?= base_url()."index.php/inventory/edit/konversi_detil/".$idBJ."/".$kode;?>";  
  }
});
</script>
