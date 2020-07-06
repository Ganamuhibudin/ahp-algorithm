<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/*if($act=="save"){
	$addUrl="add/skep/";
	//$div="divAddMap";
	$jenis="add";
}elseif($act=="update"){
	$addUrl="edit/skep/".$KODE_SKEP;
	$div="divEditMapping";
	$jenis="edit";
}*/
?>
<div class="header">
	<h4 class="header smaller lighter blue">Form Skep Perusahaan</h4>
</div>
<form id="fskep_" action="<?= site_url()."/master/listdatapopup/skep"; ?>" method="post" class="form-horizontal" autocomplete="off" list="<?= site_url()."/master/listdatapopup/skep"; ?>">
<input type="hidden" name="act" value="<?= $act; ?>" />
<input type="hidden" name="seri" id="seri" value="<?= $seri; ?>"/>
<table width="100%">
	<tr>
    	<td width="30%">Kode Skep </td>
       	<td width="70%"><?= form_dropdown('skep[KODE_SKEP]', $KODE_SKEP, $skep['KODE_SKEP'], 'id="KODE_SKEP" class="form-control" wajib="yes" style="width:70%" '); ?></td>
    </tr>
	<tr>
    	<td>Nomor Skep</td>
        <td><input type="text" name="skep[NOMOR_SKEP]" id="NOMOR_SKEP" class="form-control" value="<?= $skep['NOMOR_SKEP']; ?>" maxlength="30" style="width:70%" wajib="yes"/></td>
    </tr>
    <tr>
    	<td>Tanggal Skep</td>
        <td><input type="text" name="skep[TANGGAL_SKEP]" id="TANGGAL" class="stext date ac_input" value="<?= $skep['TANGGAL_SKEP']; ?>" onfocus="ShowDP(this.id);" style="width:40%" wajib="yes"/>&nbsp;YYYY-MM-DD</td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2"><a href="javascript:void(0);" class="btn btn-success btn-sm" style="color:#fff" id="ok_" onclick="save_dialog('#fskep_','msgskep_');"><span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-danger btn-sm" style="color:#fff" id="cancel_" onclick="cancel('fskep_');$('#fskep_form').html('')"><span><i class="fa fa-times"></i>&nbsp;Cancel&nbsp;</span></a><span class="msgskep_" style="margin-left:20px">&nbsp;</span></td>
   	</tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>