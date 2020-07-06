<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<div class="block-flat" style="margin:10px;background-color:#F6F6F6">
<form name="cetak_" id="cetak_" action="<?= site_url()."/inventory/popupcetak/".$tipe ?>" method="post" autocomplete="off">
<input type="hidden" name="tipe" id="tipe" value="<?=$tipe?>" />
<input type="hidden" name="jns" id="jns" value="<?=$jns?>" />
<h4 class="header smaller green"><b>Cetak Data <?=ucwords(strtolower($tipe))?></b></h4>
<table width="100%" border="0">
<tr>
    <td width="40%">Jenis Barang :</td>
    <td width="60%"><input type="checkbox"  name="all" id="all" onclick="checkall()"/>&nbsp;All</td>
</tr>
<?php
$func = get_instance();
$func->load->model("main");
$query = "SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ASAL_JENIS_BARANG'";
$hasil = $func->main->get_result($query);
if($hasil){		
foreach($query->result_array() as $row){	
?>
<tr>
    <td>&nbsp;</td>
    <td><input type="checkbox"  name="checkcetak[]" id="<?=$row["KODE"]?>" value="<?=$row["KODE"]?>"/>&nbsp; <?=ucwords(strtolower($row["URAIAN"]))?></td>
</tr>
<? } }?>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
     <a href="javascript:void(0);" class="btn btn-primary"  id="ok_" onclick="save_post('#cetak_');cekproses()" style="color:#fff"><i class="fa fa-print"></i>&nbsp;Cetak&nbsp;</a>&nbsp;<span class="msg_" style="margin-left:20px">&nbsp;</span>
     </td>
</tr>
</table>
</form>
</div>
<script>
function checkall(){
	$("#cetak_").find(':checkbox').attr('checked', $("#all").attr('checked'));
}
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
