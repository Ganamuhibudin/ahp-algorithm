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
	<form name="fgudang" id="fgudang" action="<?= site_url()."/master/".$action."/gudang"?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
        <input type="hidden" name="KODE_GUDANG" id="KODE_GUDANG_HIDE" value="<?=$sess["KODE_GUDANG"];?>">
<table width="100%">
	<tr>
    	<td width="15%">Kode Gudang</td>
		<td width="85%"><input name="DATA[KODE_GUDANG]" maxlength="30" id="KODE_GUDANG" value="<?= $sess['KODE_GUDANG']?>" class="stext date ac_input" <?= $readonly; ?> type="text" style="width:20%" wajib="yes"></td>
	</tr>
    <tr>	
		<td>Nama Gudang</td>
		<td><input name="DATA[NAMA_GUDANG]" maxlength="30" id="NAMA_GUDANG" value="<?= $sess['NAMA_GUDANG']; ?>" class="form-control" type="text" style="width:30%" wajib="yes"></td>
	</tr>
	<tr>
    	<td>Keterangan</td>
		<td><textarea name="DATA[KETERANGAN]" maxlength="100" id="KETERANGAN" class="form-control" style="width:30%"><?= $sess['KETERANGAN']; ?></textarea></td>
	</tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>		
		<td colspan="2"><a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#fgudang')">
					<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
			</a>
			<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="cancel('fgudang')"><i class="fa icon-undo"></i> Cancel</a>
				<span class="msg_" id="msg_">&nbsp;</span>
			
		</td>
    </tr>
</table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>