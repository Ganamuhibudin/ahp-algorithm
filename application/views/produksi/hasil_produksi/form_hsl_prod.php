<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="save"){
	//$event="onclick=popup('proses_produksi','add')";
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;KODE_SATUAN;uraisatdet',
	                  'Kode  Barang',this.form.id,650,445)";
	$btn='<input type="button" name="cari" id="cari" class="btn btn-primary" style="vertical-align:top" onclick="'.$event.'" value="...">';				  
	$readonly="readonly=readonly";
	$addUrl="add/hasil_prodPOP";
	$div="divAddHasilProduksi";
	$jenis="add";
	$MSG="msgKonv_";
}elseif($act=="save new"){
	//$event="onclick=popup('proses_produksi','add')";
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;KODE_SATUAN;uraisatdet',
	                  'Kode  Barang',this.form.id,650,445)";
	$btn='<input type="button" name="cari" id="cari" class="btn btn-primary" style="vertical-align:top" onclick="'.$event.'" value="...">';	
	$readonly="readonly=readonly";
	$addUrl="add/hasil_prodPOPN";
	$div="divAddHasilProduksi";
	$jenis="addKnv";
	$MSG="msgKonv_";
}elseif($act=="update new"){
	$event="";
	$readonly="readonly=readonly";
	$addUrl="edit/hasil_prodPOPN";
	$div="divEditHslProd";
	$jenis="edit";
	$MSG="msgKonv_";
}else{
	$event="";
	$readonly="readonly=readonly";
	$addUrl="edit/hasil_prodPOP";
	$div="divEditHslProd";
	$jenis="edit";
	$MSG="msgKonv_";
}//echo $TANGGAL.' '.$WAKTU;
?>
<div class="content_luar">
<div class="content_dalam">
<? if($act=="save new" || $act=="update new"){?>
<a href="javascript:void(0)" 
onclick="ClosePopUp('<?= base_url()."index.php/produksi/add/Hsl_Prod_New"?>','<?= $div;?>','<?= $jenis;?>');" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success prev" id="ok_"><span><i class="icon-arrow-left"></i>&nbsp;Selesai&nbsp;</span></a>
<? }else{?>
<a href="javascript:void(0)" 
onclick="ClosePopUp('<?= base_url()."index.php/produksi/edit/hsl_prod_detil/".$NOMOR_PROSES."/".$KODE_TRADER;?>','<?= $div;?>','<?= $jenis;?>');" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success prev" id="ok_"><span><i class="icon-arrow-left"></i>&nbsp;Selesai&nbsp;</span></a>
<? }?>
<h4><span class="info_2">&nbsp;</span><?= $judul;?></h4>
<form name="fHasilProduksi" id="fHasilProduksi" action="<?= site_url()."/produksi/".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="NOMOR_PROSES" id="NOMOR_PROSES" value="<?= $sess['NOMOR_PROSES']?$sess['NOMOR_PROSES']:$NOMOR_PROSES?>" />
<input type="hidden" name="SERI" id="SERI" value="<?= $sess['SERI'];?>" />
<input type="hidden" name="KODE_TRADER" id="KODE_TRADER" value="<?= $sess['KODE_TRADER']?$sess['KODE_TRADER']:$KODE_TRADER;?>">
<input type="hidden" name="JNS_BARANG" id="JNS_BARANG" value="<?= $sess['JNS_BARANG']?$sess['JNS_BARANG']:"";?>">
<input type="hidden" name="TANGGAL" id="TANGGAL" value="<?= $TANGGAL;?>">
<input type="hidden" name="WAKTU" id="WAKTU" value="<?= $WAKTU;?>">
<span id="divtmp"></span>
<table width="100%" border="0">
<tr>
	<td width="45%" valign="top">	
	<table width="100%" border="0">
	<tr>
        <td width="294">Kode Barang </td>
        <td width="789">
        <input type="text" name="KODE_BARANG" id="KODE_BARANG" <?= $readonly;?> onclick="<?= $event;?>" class="stext" value="<?= $sess['KODE_BARANG']; ?>" wajib="yes"/>&nbsp;<?=$btn?>
    </tr> 
    <tr>
        <td width="294">Uraian Barang </td>
        <td width="789">
        <textarea name="URAIAN_BARANG" id="URAIAN_BARANG" wajib="yes" <?= $readonly;?> class="mtext"><?= $sess['URAIAN BARANG']; ?></textarea></tr>
    <tr>
        <td width="294">Jenis Barang</td>
        <td width="789">
        <input type="text" name="JENIS_BARANG" id="JENIS_BARANG" <?= $readonly;?> class="mtext" value="<?= $sess['JENIS BARANG']; ?>" wajib="yes"/>
    </tr> 
     <tr>
        <td width="294">Jumlah</td>
        <td width="789">
        <input type="text" name="JUMLAH" id="JUMLAH"  class="stext" value="<?= $sess['JUMLAH']; ?>" wajib="yes" format="angka"/>
        <input type="hidden" name="JUMLAH_AWAL" id="JUMLAH_AWAL"  class="numtext" value="<?= $sess['JUMLAH']; ?>"/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" <?= $readonly;?> value="<?= $sess['SATUAN'];?>" name="URAIAN_SATUAN" class="stext date" /><span id="uraisatknv"><?= $sess['SATUAN']; ?></td>
    </tr> 
    <tr>
        <td width="294">Satuan</td>
        <td width="789">
        <input type="text" name="PRODDET[KODE_SATUAN]" id="KODE_SATUAN"  class="numtext" value="<?= $sess['KODE_SATUAN']; ?>" wajib="yes" readonly/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" <?= $readonly;?> value="<?= $sess['URAIAN SATUAN'];?>" name="URAIAN_SATUAN" class="stext date" /><span id="uraisatdet"><?= $sess['URAIAN SATUAN']; ?></span></td>
    </tr>
    <tr>
        <td width="294">Keterangan</td>
        <td width="789">
        <textarea name="PRODDET[KETERANGAN]" id="KETERANGAN" wajib="no"  class="mtext"><?= $sess['KETERANGAN']; ?></textarea></tr>
	</table>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>
     <table width="100%" border="0">
     	<tr>
     		<td width="28%">
			<? if($act=="save" || $act=="update"){?>
            <a href="javascript:void(0);" class="btn btn-success save" id="ok_" onclick="save_POP('#fHasilProduksi','<?= $MSG;?>','divhsl_prod_detil','<?= base_url()."index.php/produksi/daftar_dok/hsl_prod_detil/".$NOMOR_PROSES."/".$KODE_TRADER;?>','<?= $jenis;?>','<?= $div;?>');"><span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;
            <? }else{?>
            <a href="javascript:void(0);" class="btn btn-success save" id="ok_" onclick="save_POP('#fHasilProduksi','<?= $MSG;?>','divhsl_prod_new','<?= base_url()."index.php/produksi/daftar_dok/hsl_prod_new/".$NOMOR_PROSES."/".$KODE_TRADER;?>','<?= $jenis;?>','<?= $div;?>');"><span><i class="fa fa-save"></i>&nbsp;<?= $act=="save new"?"save":"update"; ?>&nbsp;</span></a>&nbsp;
            <? }?>
            <a href="javascript:;" class="btn btn-warning cancel" id="cancel_" onclick="cancel('fHasilProduksi');"><span><i class="icon-undo"></i>&nbsp;reset&nbsp;</span></a>
    		</td>
    		<td width="72%"><span class="<?= $MSG;?>"></span></td>
		</tr>
	</table>
    </td>
</tr>
</table>
</form>
</div></div>
<script>
$('#divAddHasilProduksi,#divEditHslProd').live("dialogclose", function(){
  var aksi=$("#act").val();
  if(aksi=="save new" || aksi=="update new"){
  	location.href= "<?= base_url()."index.php/produksi/add/Hsl_Prod_New"?>";	 
  }else{
  	location.href= "<?= base_url()."index.php/produksi/edit/hsl_prod_detil/".$NOMOR_PROSES."/".$KODE_TRADER;?>";  
  }
});
</script>
