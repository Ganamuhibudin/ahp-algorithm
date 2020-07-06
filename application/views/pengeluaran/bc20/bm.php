<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form id="fbm_" method="post" autocomplete="off" class="form-horizontal">
<table width="100%">
	<tr>
        <td width="17%">Jenis Tarif</td>
        <td width="83%"><span id="jenis-tarif"></span></td>
    </tr>     
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>  
</table>

<span id="Advolorum">
<h4 class="smaller lighter blue">&nbsp;Tarif Advolorum (%)</h4>
<table width="100%">
	<tr>
    	<td width="17%">Besar Tarif </td>
        <td width="83%"><input type="text" name="TARIF_BM" id="TARIF_BM" value="<?= $sess['TARIF_BM']; ?>" class="ssstext" maxlength="3"/> %</td>
	</tr>
</table>
</span>
<span id="Spesifik" style="display:none">
<h4 class="smaller lighter blue">&nbsp;Tarif Spesifik (Satuan)</h4>
<table width="100%">
	<tr>
    	<td width="17%">Besar Tarif </td>
        <td width="83%"><input type="text" name="TARIF_BM2" id="TARIF_BM2" value="<?= $sess['TARIF_BM']; ?>" class="sstext"/>
        &nbsp;Per : &nbsp;<input type="text" name="KODE_SATUAN_BM" id="KODE_SATUAN_BM" value="<?= $sess['KODE_SATUAN_BM'];?>" class="ssstext" url="<?= site_url(); ?>/autocomplete/satuan" urai="urai_Sat;" onfocus="Autocomp(this.id);"/>&nbsp;<span id="urai_Sat"></span></td>
	</tr>
    <tr>
       <td>Jumlah </td>
       <td><input type="text" name="JUMLAH_BM" id="JUMLAH_BM" value="<?= $sess['JUMLAH_BM'];?>" class="sstext" /></td>
    </tr>   
</table>
</span>

<table width="100%">    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
      	<a href="javascript:void(0);" class="button save" id="ok_" onclick="Addbm()"><span><span class="icon"></span>&nbsp;Ok&nbsp;</span></a>
        </td>
    </tr>	        
</table>
</form>
</div></div>
<script>
$(function(){FormReady();})
$(function(){ 
	changeBM($("#fbarang_ #KODE_TARIF_BM").val());
	$("#fbm_ ").find("#TARIF_BM").val($("#fbarang_ #TARIF_BM").val());		
	$("#fbm_ ").find("#TARIF_BM2").val($("#fbarang_ #TARIF_BM").val());		
	$("#fbm_ ").find("#KODE_SATUAN_BM").val($("#fbarang_ #KODE_SATUAN_BM").val());
	$("#fbm_ ").find("#JUMLAH_BM").val($("#fbarang_ #JUMLAH_BM").val());
	if($("#fbarang_ #KODE_TARIF_BM").val()==2){
		$("#fbm_ ").find("#jenis-tarif").html('<select id="KODE_TARIF_BM" onchange="changeBM(this.value)" class="text"><option value="1">1 - ADVALORUM</option><option value="2" selected>2 - SPESIFIK</option></select>');	
	}else{		
		$("#fbm_ ").find("#jenis-tarif").html('<select id="KODE_TARIF_BM" onchange="changeBM(this.value)" class="text"><option value="1" selected>1 - ADVALORUM</option><option value="2">2 - SPESIFIK</option></select>');
	}
})

function Addbm(){
	var jenis = $("#fbm_ #KODE_TARIF_BM").val();
	if(jenis==1){
		$("#fbarang_ #TARIF_BM").val($("#fbm_ #TARIF_BM").val());
		$("#tipebm").html('Advolorum<input type="hidden" name="TARIF[KODE_TARIF_BM]" id="KODE_TARIF_BM" value="'+jenis+'">');	
		$("#tipespesifik").html('');
	}else{
		var kodesatu = $("#fbm_ #KODE_SATUAN_BM").val();
		var jumlahbm = $("#fbm_ #JUMLAH_BM").val();
		$("#tipespesifik").html('<table><tr><td align="right">Per</td><td><input type="text" name="TARIF[KODE_SATUAN_BM]" id="KODE_SATUAN_BM" class="ssstext" value="'+kodesatu+'"/>&nbsp;&nbsp;Jumlah Satuan&nbsp;<input type="text" name="BARANG[JUMLAH_BM]" id="JUMLAH_BM" class="stext" value="'+jumlahbm+'"/></td></tr></table>');	
		$("#tipebm").html('Spesifik<input type="hidden" name="TARIF[KODE_TARIF_BM]" id="KODE_TARIF_BM" value="'+jenis+'">');	
		$("#fbarang_ #TARIF_BM").val($("#fbm_ #TARIF_BM2").val());
	}
	closedialog('dialog-bm');
}
</script>