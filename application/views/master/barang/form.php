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
	<form name="formbarang" id="formbarang" action="<?= site_url()."/master/".$action."/barang"?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="id_barang" id="id_barang" value="<?= $sess['id_barang']?>" />
		<table width="50%">
        	<tr>
            	<td width=15%">Kode Barang</td>
				<td width="85%">
					<input type="text" name="data[kode_barang]" id="kode_barang" value="<?= $sess['kode_barang']?>" class="mtext" wajib="yes" maxlength="35">
				</td>
			</tr>
			<tr>
            	<td width=15%">Jenis Barang</td>
				<td width="85%">
					<combo><?= form_dropdown('data[jenis_barang]', $jenis_barang, $sess['jenis_barang'], 'id="jenis_barang" class="mtext" wajib="yes"'); ?></combo>
				</td>
			</tr>
			<tr>
            	<td width=15%">Nama Barang</td>
				<td width="85%">
					<input type="text" name="data[nama_barang]" id="nama_barang" value="<?= $sess['nama_barang']?>" class="mtext" wajib="yes">
				</td>
			</tr>
			<tr>
            	<td width=15%">Uraian</td>
				<td width="85%">
					<textarea type="text" name="data[uraian]" id="uraian" class="mtext"><?= $sess['uraian']?></textarea>
				</td>
			</tr>
			<tr>
            	<td width=15%">Satuan</td>
				<td width="85%">
					<input type="text" name="data[satuan]" id="satuan" class="stext date ac_input" value="<?= $sess['satuan']; ?>" wajib="yes" urai="ursatuan;" />
                    <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('satuan','satuan;ursatuan','Kode Satuan',this.form.id,650,400)" value="...">
                    &nbsp;<span id="ursatuan" class="uraian">
				</td>
			</tr>
			<tr>
            	<td width=15%">Merk</td>
				<td width="85%">
					<input type="text" name="data[merk]" id="merk" value="<?= $sess['merk']?>" class="mtext">
				</td>
			</tr>
			<tr>
            	<td width=15%">Stock Minimum</td>
				<td width="85%">
					<input type="text" name="stock_minimum" id="stock_minimum_ur" value="<?= $sess['stock_minimum']?>" class="stext" onkeyup="this.value = ThausandSeperator('stock_minimum',this.value,2);">
					<input type="hidden" id="stock_minimum" name="data[stock_minimum]" value="<?= $sess['stock_minimum']?>" />
				</td>
			</tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
			<tr>
				<td colspan="2">
					<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#formbarang')">
						<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
					</a>
					<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="cancel('formbarang')"><i class="fa icon-undo"></i>Cancel</a>
					<span class="msg_" id="msg_">&nbsp;</span>
				</td>
			</tr>
        </table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>