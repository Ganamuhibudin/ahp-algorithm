<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="Save"){
	$addUrl="add/mappingPOPN/".$idPartner;
	$div="divAddMap";
	$jenis="add";
}elseif($act=="update"){
	$addUrl="edit/mappingPOPN/".$idPartner;
	$div="divEditMapping";
	$jenis="edit";
}
$MSG="msgKonv_";
?>	
<div class="block-flat" style="margin:10px;background-color:#F6F6F6">
<h4 class="header smaller green"><?= $judul;?></h4>
<form name="fMapp" id="fMapp" class="form-horizontal" action="<?= site_url()."/master/".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="MAPPING[KODE_PARTNER]" id="idPartner" value="<?= $idPartner?>" />
<input type="hidden" name="IDMAPPING" id="IDMAPPING" value="<?= $idMapping?>" />
<input type="hidden" name="MAPPING[JNS_BARANG]" id="JNS_BARANG" value="<?= $sess['JNS_BARANG']?$sess['JNS_BARANG']:"";?>">
<span id="divtmp"></span>
<table width="100%">
    <tr>
    	<td width="35%">Kode Barang Pemasok</td>
    	<td width="65%"><input type="text" name="MAPPING[KODE_BARANG_PARTNER]" id="KODE_BARANG_PARTNER"  class="stext date ac_input" style="width:50%" value="<?= $sess['KODE_BARANG_PARTNER']; ?>" wajib="yes"/></td>
    </tr>
    <tr>
		<td>Kode Barang Internal</td>
    	<td><input type="text" name="MAPPING[KODE_BARANG]" id="KODE_BARANG" <?= $event;?> class="stext date ac_input" style="width:50%" value="<?= $sess['KODE_BARANG']; ?>" wajib="yes" readonly/>
    <!--<button class="btn btn-primary btn-sm" type="button" onclick="tb_search('barang_maping','KODE_BARANG;URAIAN_BARANG;JENIS_BARANG','Kode Barang',this.form.id,650,445)"><i class="fa fa-search"></i></button>-->
    <!--<button class="btn btn-primary btn-sm" type="button" onclick="tb_search('barang_maping','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG','Kode Barang',this.form.id,650,445)">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>-->
    <button class="btn btn-primary btn-sm" type="button" onclick="tb_search('barang_maping','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG','Kode Barang',this.form.id,650,400)">&nbsp;<i class="fa fa-search"></i>&nbsp;</button></td>
    </tr> 
	<tr>
    	<td>Uraian Barang </td>
   		<td><textarea name="URAIAN_BARANG" id="URAIAN_BARANG" wajib="yes" readonly class="stext date ac_input" style="width:70%"><?= $sess['URAIAN_BARANG']; ?></textarea></td>
    </tr>
	<tr>
    	<td>Jenis Barang</td>
    	<td><input type="text" name="JENIS_BARANG" id="JENIS_BARANG"  class="stext date ac_input" style="width:70%" value="<?= $sess['JENIS_BARANG']; ?>" readonly/></td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
    	<td colspan="2">
    <?php if($act=="Save"){?>
    <a href="javascript:void(0);" style="color:#FFFFFF"  class="btn btn-success" id="ok_" onclick="save_popup('#fMapp','<?= $MSG;?>','mappDetil','<?= base_url()."index.php/master/mapping_dok/mapping/".$idPartner;?>','<?= $jenis;?>','<?= $div;?>');"><span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;
	<?php }else{ ?>
    <a href="javascript:void(0);" class="btn btn-success" id="ok_" style="color:#FFFFFF"  onclick="save_popup('#fMapp','<?= $MSG;?>','mappDetil','<?= base_url()."index.php/master/mapping_dok/mapping/".$idPartner;?>','<?= $jenis;?>','<?= $div;?>');"><span><i class="fa fa-save"></i>&nbsp;<?= $act=="save new"?"save":"update"; ?>&nbsp;</span></a>&nbsp;
    <?php }?>
    <a href="javascript:;" class="btn btn-warning" style="color:#FFFFFF" id="cancel_" onclick="cancel('fMapp');"><span><i class="icon-undo"></i>&nbsp;reset&nbsp;</span></a><span class="<?= $MSG;?>" style="margin-left:20px">&nbsp;</span>
		</td>
    </tr>
</table>
</div>
</form>
