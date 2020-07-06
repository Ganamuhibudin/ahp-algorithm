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
		} else {
			$action = "edit";
		}
	?>
	<form name="formjenisbarang" id="formjenisbarang" action="<?= site_url()."/master/".$action."/jenis_barang"?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="id_jenis_barang" id="id_jenis_barang" value="<?= $sess['id_jenis_barang']?>" />
		<table width="50%">
        	<tr>
            	<td width=15%">Jenis Barang</td>
				<td width="85%">
					<input type="text" name="data[jenis_barang]" id="jenis_barang" <?= $readonly; ?> value="<?= $sess['jenis_barang']?>" class="mtext" wajib="yes">
				</td>
			</tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
			<tr>
				<td colspan="2">
				<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#formjenisbarang')">
					<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
				</a>
				<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="cancel('formjenisbarang')"><i class="fa icon-undo"></i>Cancel</a>
				<span class="msg_" id="msg_">&nbsp;</span>
				</td>
			</tr>
        </table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>