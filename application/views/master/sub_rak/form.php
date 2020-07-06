<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);			  	
?>
<script type="text/javascript">
function reset_rak(){
		$("#KODE_RAK").val('');			
	}
</script>
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
	<form name="fsub_rak" id="fsub_rak" action="<?= site_url()."/master/".$action."/sub_rak"?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
        <input type="hidden" name="KODE_GUDANG" id="KODE_GUDANG_HIDE" value="<?=$sess["KODE_GUDANG"];?>">
        <input type="hidden" name="KODE_RAK" id="KODE_RAK_HIDE" value="<?=$sess["KODE_RAK"];?>">
        <input type="hidden" name="KODE_SUB_RAK" id="KODE_SUB_RAK_HIDE" value="<?=$sess["KODE_SUB_RAK"];?>">
<table width="100%">
	<tr>
    	<td width="15%">Kode Gudang</td>
		<td width="85%"><input name="DATA[KODE_GUDANG]" id="KODE_GUDANG" value="<?php $ac=$sess['KODE_GUDANG']; echo $ac; ?>" class="stext date ac_input" style="width:15%" type="text" wajib="yes" <?= $readonly; ?> onFocus="reset_rak()">
			<button class="btn btn-primary btn-xs" style="vertical-align:top" type="button" <?= ($readonly=="") ? "onclick=\"tb_search('gudang','KODE_GUDANG','Kode Gudang',this.form.id,650,400)\"" : ""; ?>><i class="fa fa-search"></i></button></td>         
            <!--<input type="text" id="Nm_gd">-->
	</tr>		
	<tr>
		<td>Kode Rak</td>
		<td><input name="DATA[KODE_RAK]" wajib="yes" id="KODE_RAK" value="<?= $sess['KODE_RAK']; ?>" class="stext date ac_input" style="width:15%" type="text" <?= $readonly; ?>>
			<button class="btn btn-primary btn-xs" style="vertical-align:top" type="button" <?= ($readonly=="") ? "onclick=\"tb_search('rak','KODE_RAK','Kode Rak',this.form.id,650,400,'KODE_GUDANG;')\"" : ""; ?>><i class="fa fa-search"></i></button></td>
	</tr>
    <tr>
    	<td>Kode Sub Rak</td>
		<td><input name="DATA[KODE_SUB_RAK]" maxlength="15" id="KODE_SUB_RAK" value="<?= $sess['KODE_SUB_RAK']; ?>" class="stext date ac_input" style="width:15%" type="text" wajib="yes" <?= $readonly; ?>></td>
	</tr>
    <tr>
        <td>Nama Sub Rak</td>
		<td><input name="DATA[NAMA_SUB_RAK]" wajib="yes" maxlength="30" id="NAMA_SUB_RAK" value="<?= $sess['NAMA_SUB_RAK']; ?>" class="stext date ac_input" style="width:30%" type="text"></td>
	</tr>
    <tr>
		<td>Keterangan</td>
		<td><textarea name="DATA[KETERANGAN]" maxlength="100" id="KETERANGAN" class="form-control" style="width:30%"><?= $sess['KETERANGAN']; ?></textarea></td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    <tr>
		<td colspan="2">
        	<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#fsub_rak')">
				<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
			</a>
			<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="cancel('fsub_rak')"><i class="fa icon-undo"></i>Cancel</a>
				<span class="msg_" id="msg_">&nbsp;</span>
		</td>
    </tr>
</table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
	
</script>