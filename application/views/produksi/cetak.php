<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<div class="block-flat" style="margin:10px;background-color:#F6F6F6">
<h4 class="header smaller green">Cetak Produksi <?= $tipe; ?> </h4>
<form name="cetak_" id="cetak_" action="<?= site_url()."/produksi/cetak/".$tipe ?>" method="post" autocomplete="off">
<input type="hidden" name="tipe" id="tipe" value="<?=$tipe?>" />
<table width="100%" border="0">
<tr>
    <td>Tanggal</td>
    <td>           
    <input type="text" name="TANGGAL_1" id="TANGGAL_1" onfocus="ShowDP('TANGGAL_1');" class="stext date" wajib="yes"/>&nbsp;&nbsp;s/d&nbsp;&nbsp;<input type="text" name="TANGGAL_2" id="TANGGAL_2" onfocus="ShowDP('TANGGAL_2');" class="stext date" wajib="yes"/></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
     <a href="javascript:void(0);" class="btn btn-success btn-sm save" id="ok_" style="color:#FFFFFF" onclick="save_post('#cetak_');cekproses()"><span><i class="icon-print"></i>&nbsp;Cetak&nbsp;</span></a>&nbsp;<span class="msg_" style="margin-left:20px">&nbsp;</span>
     </td>
</tr>
</table>
</form>
</div>
<script>
function cekproses(){
	setTimeout(function(){				
		if($('.msg_').html()=='OK'){
			closedialog('dialog-tbl');	
		}
	}, 1000);	
	return false;
}
$("input, textarea, select").focus(function(){
	if($(this).attr('wajib')=="yes"){
		$(".msg_").fadeOut('slow');
		$(this).removeClass('wajib');
	}
});
</script>
