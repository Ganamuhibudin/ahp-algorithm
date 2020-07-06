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
			$readonly ="";
		} else {
			$action = "edit";
			$readonly = "readonly";
		}
	?>
	<form name="formpemasok" id="formpemasok" action="<?= site_url()."/master/".$action."/pemasok"?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
        <input type="hidden" name="KODE_PARTNER" id="KODE_PARTNER_HIDE" value="<?=$sess["KODE_PARTNER"];?>">
		<table width="100%">
        	<tr>
            	<td width="15%">Kode Perusahaan</td>
				<td width="85%"><input name="DATA[KODE_PARTNER]" id="KODE_PARTNER" <?= $readonly; ?> value="<?= $sess['KODE_PARTNER']?>" class="stext date ac_input" style="width:20%" type="text" wajib="yes"></td>
			</tr>
           	<tr>
				<td>Identitas</td>
				<td><?php echo "<combo>".form_dropdown('DATA[KODE_ID_PARTNER]', $kode_id, $sess['KODE_ID_PARTNER'], 'id="KODE_ID_PARTNER" class="stext date ac_input" style="width:11%"')."</combo>"; ?>			
				<input  name="DATA[ID_PARTNER]" id="ID_PARTNER" value="<?= $sess['ID_PARTNER']?>" class="stext date ac_input" style="width:18%" maxlength="15" type="text"></td>
			</tr>
            <tr>
				<td>Nama Perusahaan</td>
				<td><input name="DATA[NAMA_PARTNER]" id="NAMA_PARTNER" value="<?= $sess['NAMA_PARTNER']; ?>" class="stext date ac_input" style="width:30%" type="text" wajib="yes"></td>
			</tr>
            <tr>
				<td>Alamat Perusahaan</td>
				<td><textarea name="DATA[ALAMAT_PARTNER]" id="ALAMAT_PARTNER" class="stext date ac_input" style="width:30%"><?= $sess['ALAMAT_PARTNER']; ?></textarea></td>
			</tr>
			<tr>
				<td>Jenis Perusahaan</td>
				<td><combo><?php echo form_dropdown('DATA[JENIS_PARTNER]', $jenis_partner, $sess['JENIS_PARTNER'], 'id="JENIS_PARTNER" class="stext date ac_input" style="width:30%" wajib="yes"') ?></combo></td>
			</tr>
			<tr>
				<td>Status Perusahaan</td>
				<td><combo><?php echo form_dropdown('DATA[STATUS_PARTNER]', $status_partner, $sess['STATUS_PARTNER'], 'id="STATUS_PARTNER" class="stext date ac_input" style="width:30%" wajib="yes"') ?></combo></td>
			</tr>
            <tr>
				<td>Negara Perusahaan</td>
				<td><input name="DATA[NEGARA_PARTNER]" id="NEGARA_PARTNER" value="<?= $sess['NEGARA_PARTNER']; ?>" class="stext date ac_input" style="width:15%" type="text">
					<button class="btn btn-primary btn-xs" style="vertical-align:top" type="button" onclick="tb_search('negara','NEGARA_PARTNER;urnegara','Kode Negara',this.form.id,700,470)"><i class="fa fa-search"></i></button>
              &nbsp;
              <span id="urnegara">
              <?= $sess['URAIAN_BENDERA']==''?$URAIAN_NEGARA:$sess['URAIAN_BENDERA']; ?>
              </span>
              </td>
			</tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
			<tr>
				<td colspan="2">
				<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#formpemasok')">
					<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
				</a>
				<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="cancel('formpemasok')"><i class="fa icon-undo"></i>Cancel</a>
				<span class="msg_" id="msg_">&nbsp;</span>
				</td>
			</tr>
        </table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>