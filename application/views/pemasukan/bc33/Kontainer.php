<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fkontainer_form">
<?php if(!$list){
if($act=='update') $readonly="readonly=readonly";
else $readonly="";
?>
	<h5 class="header smaller lighter green"><b>DETIL KONTAINER</b></h5>
	<form id="fkontainer_" action="<?= site_url()."/pemasukan/kontainer/bc33"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pemasukan/detil/kontainer/bc33" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="nomor" id="nomor" value="<?= $nomor; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <table>
            <tr>
                <td width="145">Nomor </td>
                <td><input type="text" name="NOMOR" id="NOMOR" class="text" value="<?= $sess['NOMOR']; ?>" <?= $readonly;?> maxlength="15" wajib="yes"/></td>
            </tr>
             <tr>
                <td width="145">Nomor Segel </td>
                <td><input type="text" name="KONTAINER[NOMOR_SEGEL]" id="NOMOR_SEGEL" class="text" value="<?= $sess['NOMOR_SEGEL']; ?>" maxlength="30" /></td>
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
                <td>Stuff </td>
               	<td><combo><?= form_dropdown('KONTAINER[STUFF]', $STUFF, $sess['STUFF'], 'id="STUFF" class="text" wajib="yes" '); ?></combo></td>
            </tr>
            <tr>
                <td>JNPartOF </td>
                <td><combo><?= form_dropdown('KONTAINER[JNPARTOF]', $JNPARTOF, $sess['JNPARTOF'], 'id="JNPARTOF" class="text" wajib="yes" '); ?></combo></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
              		<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fkontainer_','msgkontainer_');">
                    	<i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>
                   	</a>
                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fkontainer_');">
                    	<i class="icon-undo"></i>&nbsp;Reset
                   	</a>
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