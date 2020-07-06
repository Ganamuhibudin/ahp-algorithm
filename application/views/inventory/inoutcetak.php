<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	
<div class="block-flat" style="margin:10px;background-color:#F6F6F6">
	<h4 class="header smaller green">Cetak Pencatatan Mutasi Barang</h4>
<form name="cetak_" id="cetak_" action="<?= site_url()."/inventory/popupcetak_inout"?>" method="post" autocomplete="off">

<table width="100%" border="0">
<tr>
    <td width="27%">Jenis Mutasi :</td>
    <td width="73%"><input type="radio"  name="REPORT" value="GATE-IN"/>&nbsp;Realisasi Pemasukan (GATE-IN)</td>
</tr>
<tr>
    <td width="27%">&nbsp;</td>
    <td width="73%"><input type="radio"  name="REPORT" value="GATE-OUT"/>&nbsp;Realisasi Pengeluaran (GATE-OUT)</td>
</tr>
<tr>
    <td width="27%">&nbsp;</td>
    <td width="73%"><input type="radio"  name="REPORT" value="PROCESS_IN"/>&nbsp;Barang yang Diproses (-)</td>
</tr>
<tr>
    <td width="27%">&nbsp;</td>
    <td width="73%"><input type="radio"  name="REPORT" value="PROCESS_OUT"/>&nbsp;Hasil Pengerjaan (+)</td>
</tr>
<tr>
    <td width="27%">&nbsp;</td>
    <td width="73%"><input type="radio"  name="REPORT" value="SCRAP"/>&nbsp;Sisa Produksi/Scrap (+)</td>
</tr>
<tr>
    <td width="27%">&nbsp;</td>
    <td width="73%"><input type="radio"  name="REPORT" value="MUSNAH"/>&nbsp;Pemusnahan</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
     <a href="javascript:void(0);" id="ok_" onclick="save_post('#cetak_');cekproses()" class="btn btn-sm btn-success"><span style="color:#fff"><i class="icon-print"></i>&nbsp;Cetak&nbsp;</span></a>&nbsp;<span class="msg_" style="margin-left:20px">&nbsp;</span>
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
