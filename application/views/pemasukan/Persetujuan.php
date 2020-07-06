<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<form name="fbc_" id="fbc_" action="<?= site_url()."/pemasukan/setujui" ?>" method="post" class="form-horizontal" autocomplete="off">
    <input type="hidden" name="DOK" id="DOK" value="<?=$dokumen?>" />
    <input type="hidden" name="CAR" id="CAR" value="<?=$noaju?>" />
    <h5 class="header smaller lighter red"> <i class="icon-edit"></i> Informasi Bea dan Cukai </h4>
    <table width="100%" border="0">
        <tr>
            <td width="40%">Nomor Pendaftaran</td>
            <td width="60%"><input type="text" name="DATA[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $DATA['NOMOR_PENDAFTARAN']; ?>" maxlength="6" wajib="yes" /></td>
        </tr>
        <tr>
            <td>Tanggal Pendaftaran</td>
            <td>
            	<input type="text" name="DATA[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $DATA['TANGGAL_PENDAFTARAN']; ?>" wajib="yes"/>
        		&nbsp;YYYY-MM-DD
       		</td>
        </tr>
        <? if(!in_array($dokumen,array("ppb-plb","ppk-plb"))){ ?>
        <tr>
            <td>No. Persetujuan Pemasukan</td>
            <td><input type="text" name="DATA[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="text" value="<?= $DATA['NOMOR_DOK_PABEAN']; ?>" maxlength="30"/></td>
        </tr>
        <tr>
            <td>Tanggal Persetujuan Pemasukan</td>
            <td>
            	<input type="text" name="DATA[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="stext date" value="<?= ($DATA['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$DATA['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');"/>
            	&nbsp;YYYY-MM-DD
         	</td>
        </tr>
        <? } if($dokumen=="bc40"){?>
        <tr>
          <td>Nama Pejabat BC</td>
          <td><input type="text" name="DATA[NAMA_PEJABAT_BC]" id="NAMA_PEJABAT_BC" class="text" value="<?= $DATA['NAMA_PEJABAT_BC']; ?>" /></td>
        </tr>
        <tr>
          <td>NIP Pejabat BC</td>
          <td><input type="text" name="DATA[NIP_PEJABAT_BC]" id="NIP_PEJABAT_BC" class="text" value="<?= $DATA['NIP_PEJABAT_BC']; ?>"/></td>
        </tr>
        <? } ?>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td >
                <a href="javascript:void(0)" class="btn btn-sm btn-success" style="color:#FFFFFF" onclick="save_popup('#fbc_','msgdetil_','<?=$div?>')">
                	<i class="icon-save bigger-125"></i>&nbsp;Save
                </a>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning" style="color:#FFFFFF" onclick="cancel('fbc_');closedialog('dialog-tbl');">
                	<i class="icon-remove bigger-125"></i>&nbsp;Cancel 
                </a>
                &nbsp;<span class="msgdetil_" id="msg_">&nbsp;</span>
            </td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
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
</script> 
