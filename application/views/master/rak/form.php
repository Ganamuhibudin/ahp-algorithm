<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);			  	
?>
<div class="header">
	<h3><strong><?=$judul?></strong></h3>
</div>
<div class="content">
	<?php
		if (strtolower($act) == "save") {
			$action = "add";
			$readonly = "";
		} else {
			$action = "edit";
			$readonly = "readonly";
		}
	?>
	<form name="frak" id="frak" action="<?= site_url()."/master/".$action."/rak"?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
        <input type="hidden" name="KODE_GUDANG" id="KODE_GUDANG_HIDE" value="<?=$sess["KODE_GUDANG"];?>">
        <input type="hidden" name="KODE_RAK" id="KODE_RAK_HIDE" value="<?=$sess["KODE_RAK"];?>">
<table width="100%">
	<tr>
    	<td width="15%">Kode Gudang</td>
		<td width="85%"><input name="DATA[KODE_GUDANG]" id="KODE_GUDANG" value="<?= $sess['KODE_GUDANG']; ?>" class="stext date ac_input" style="width:15%" type="text" wajib="yes" <?= $readonly; ?>>
				<button class="btn btn-primary btn-xs" style="vertical-align:top" type="button" <?= ($readonly=="") ? "onclick=\"tb_search('gudang','KODE_GUDANG','Kode Gudang',this.form.id,650,400)\"" : ""; ?>><i class="fa fa-search"></i></button></td>
	</tr>
    <tr>
		<td>Kode Rak</td>
		<td><input name="DATA[KODE_RAK]" maxlength="10" id="KODE_RAK" value="<?= $sess['KODE_RAK']; ?>" class="stext date ac_input" type="text" style="width:15%" wajib="yes" <?= $readonly; ?>></td>
    </tr>
    <tr>
		<td>Nama Rak</td>
		<td><input name="DATA[NAMA_RAK]" maxlength="30" id="NAMA_RAK" wajib="yes" value="<?= $sess['NAMA_RAK']; ?>" class="stext date ac_input" style="width:30%" type="text"></td>
	</tr>
    <tr>
		<td>Keterangan</td>
		<td><textarea name="DATA[KETERANGAN]" maxlength="100" id="KETERANGAN" class="form-control" style="width:30%"><?= $sess['KETERANGAN']; ?></textarea></td>
	</tr>		
	<tr>
		<td colspan="2">&nbsp;</td>
	<tr>
	<tr>
		<td colspan="2"><a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#frak')">
			<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
			</a>
			<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="cancel('frak')"><i class="fa icon-undo"></i>Cancel</a>
			<span class="msg_" id="msg_">&nbsp;</span>
		</td>
	</tr>
</table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>