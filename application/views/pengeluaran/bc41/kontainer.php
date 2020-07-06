<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fkontainer_form">
<?php if(!$list){?>
<h4><span class="info_2">&nbsp;</span>Detil Kontainer </h4>
<form id="fkontainer_" action="<?= site_url()."/pengeluaran/kontainer/bc41"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pengeluaran/detil/kontainer/bc41" ?>">
<input type="hidden" name="act" value="<?= $act; ?>" />
<input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
<input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
<table>
    <tr>
        <td width="145">Nomor </td>
        <td><input type="text" name="KONTAINER[NOMOR]" id="NOMOR" class="text" value="<?= $sess['NOMOR']; ?>" maxlength="30" wajib="yes"/></td>
    </tr>
    <tr>
        <td>Ukuran </td>
        <td><?= form_dropdown('KONTAINER[UKURAN]', $UKURAN, $sess['UKURAN'], 'id="UKURAN" class="text" wajib="yes" '); ?></td>
    </tr>
    <tr>
        <td>Tipe </td>
            <td><?= form_dropdown('KONTAINER[TIPE]', $TIPE, $sess['TIPE'], 'id="TIPE" class="text" wajib="yes" '); ?></td>
    </tr> 
<tr>
 	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="3">
  <a href="javascript:void(0);" class="button save" id="ok_" onclick="save_detil('#fkontainer_','msgkontainer_');"><span><span class="icon"></span>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="button cancel" id="cancel_" onclick="cancel('fkontainer_');"><span><span class="icon"></span>&nbsp;Cancel&nbsp;</span></a><span class="msgkontainer_" style="margin-left:20px">&nbsp;</span>
	</td>
</tr>	        
</table>
</form>
<?php } ?>
</span>
<?php if(!$edit){ ?>
<div id="fkontainer_list" style="margin-top:10px"><?= $list ?></div>
<?php } ?>
<script>
$(function(){FormReady();})
</script>