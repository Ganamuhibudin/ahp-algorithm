<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">
	<h4>Form Skep Perusahaan</h4>
    <hr />
</div>
<form id="fskep_" action="<?= site_url()."/master/listdatapopup/skep"; ?>" method="post" class="form-horizontal" autocomplete="off" list="<?= site_url()."/master/listdatapopup/skep"; ?>">
<input type="hidden" name="act" value="<?= $act; ?>" />
<input type="hidden" name="seri" id="seri" value="<?= $seri; ?>"/>

<div class="form-group">
        <label class="col-sm-3 control-label">Kode Skep </label>
       <div class="col-sm-4">
	   <?= form_dropdown('skep[KODE_SKEP]', $KODE_SKEP, $skep['KODE_SKEP'], 'id="KODE_SKEP" class="form-control" wajib="yes" '); ?>
       </div>
</div>
<div class="form-group">
        <label class="col-sm-3 control-label">Nomor Skep</label>
        <div class="col-sm-4"><input type="text" name="skep[NOMOR_SKEP]" id="NOMOR_SKEP" class="form-control" value="<?= $skep['NOMOR_SKEP']; ?>" maxlength="30" wajib="yes"/></div>
        <div class="col-sm-1"></div>
</div>
<div class="form-group">
       <label class="col-sm-3 control-label">Tanggal Skep</label>
        <div class="col-sm-4"><input type="text" name="skep[TANGGAL_SKEP]" id="TANGGAL" class="form-control" value="<?= $skep['TANGGAL_SKEP']; ?>" onfocus="ShowDP(this.id);" wajib="yes"/>&nbsp;YYYY-MM-DD</div> 
</div>
<!--<div class="form-group">
 		<div class="col-sm-7"></div>
</div>-->
<div class="form-group">
	<div class="col-sm-7">
  <a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_dialog('#fskep_','msgskep_');"><span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-danger" id="cancel_" onclick="cancel('fskep_');$('#fskep_form').html('')"><span><i class="fa fa-times"></i>&nbsp;Cancel&nbsp;</span></a><span class="msgskep_" style="margin-left:20px">&nbsp;</span>
	</div>
</div>  
<div class="form-group">
        <div class="col-sm-7">&nbsp;</div>
</div>
</form>