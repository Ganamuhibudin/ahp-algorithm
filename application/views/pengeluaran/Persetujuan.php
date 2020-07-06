<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<form name="fbc_" id="fbc_" action="<?= site_url()."/pengeluaran/setujui" ?>" method="post" autocomplete="off">
    <input type="hidden" name="DOK" id="DOK" value="<?=$dokumen?>" />
    <input type="hidden" name="CAR" id="CAR" value="<?=$noaju?>" />
    <h4 class="header smaller lighter green">Informasi Bea dan Cukai</h4>
    <table width="100%" border="0">
        <tr>
            <td width="40%">Nomor Pendaftaran</td>
            <td width="60%">
            <input type="text" name="DATA[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $DATA['NOMOR_PENDAFTARAN']; ?>" maxlength="6" wajib="yes" /></td>
        </tr>
        <tr>
            <td>Tanggal Pendaftaran</td>
            <td>           
            <input type="text" name="DATA[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?=($DATA['TANGGAL_PENDAFTARAN']=='0000-00-00')?'':$DATA['TANGGAL_PENDAFTARAN'];?>" wajib="yes"/>&nbsp;YYYY-MM-DD</td>
        </tr>
        <tr>
            <td>No. Persetujuan Pengeluaran</td>
            <td>
            <input type="text" name="DATA[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="text" value="<?= $DATA['NOMOR_DOK_PABEAN']; ?>" maxlength="30"/>
            </td>
        </tr>
        <tr>
            <td>Tanggal Persetujuan Pengeluaran</td>
            <td>
            <input type="text" name="DATA[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="stext date" value="<?= ($DATA['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$DATA['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');"/>&nbsp;YYYY-MM-DD</td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td>
            	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_popup('#fbc_','msg_','<?=$div?>')">
                	<span class="icon-save" style="color:#fff"></span><span style="color:#fff">&nbsp;Save&nbsp;</span>
               	</a>&nbsp;
                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbc_');">
                	<span class="icon-undo" style="color:#fff"></span><span style="color:#fff">&nbsp;Reset&nbsp;</span>
              	</a>
                <span class="msg_" style="margin-left:20px">&nbsp;</span>
            </td>
        </tr>
    </table>
</form>
<script>
$("input, textarea, select").focus(function(){
	if($(this).attr('wajib')=="yes"){
		$(".msg_").fadeOut('slow');
		$(this).removeClass('wajib');
	}
});
FormReady();
</script>
