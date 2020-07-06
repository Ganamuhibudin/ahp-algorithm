<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fkontainer_form">
<?php if(!$list){?>
	<form id="fkontainer_" action="<?= site_url()."/pemasukan/kontainer/ppk"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pemasukan/detil/kontainer/ppk" ?>">
    	<input type="hidden" readonly name="act" value="<?= $act; ?>" />
        <input type="hidden" readonly name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" readonly name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL KONTAINER</b></h5>
        <table>
            <tr>
                <td width="145">Nomor </td>
                <td><input type="text" name="KONTAINER[NOMOR]" id="NOMOR" class="text" value="<?= $sess['NOMOR']; ?>" maxlength="17" wajib="yes"/></td>
            </tr>
            <tr>
                <td>Ukuran </td>
                <td><combo><?= form_dropdown('KONTAINER[UKURAN]', $UKURAN, $sess['UKURAN'], 'id="UKURAN" class="text" wajib="yes" '); ?></combo></td>
            </tr>
            <tr>
                <td>Tipe </td>
                    <td><combo><?= form_dropdown('KONTAINER[TIPE]', $TIPE, $sess['TIPE'], 'id="TIPE" class="text" wajib="yes" '); ?></combo></td>
            </tr> 
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
                	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fkontainer_','msgkontainer_');"><i class="icon-save"></i>&nbsp;<?=ucwords($act)?></a>&nbsp;
                  	<a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fkontainer_');"><i class="icon-undo"></i>&nbsp;Reset</a>
                    <span class="msgkontainer_" style="margin-left:20px">&nbsp;</span>
                </td>
            </tr>	        
        </table>
    </form>
<?php } ?>
</span>
<?php 
if($edit){
	echo '<h5 class="header smaller lighter green"><b>&nbsp;</b></h5>';
}
?>
<?php if(!$edit){ ?>
<div id="fkontainer_list"><?= $list ?></div>
<?php } ?>
<script>
$(function(){FormReady();})
</script>