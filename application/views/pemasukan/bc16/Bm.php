<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form id="fbmbc16" method="post" autocomplete="off">
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
    	<h5 class="smaller lighter blue"><b>Tarif Advolorum (%)</b></h5>
        <table width="100%">
            <tr>
                <td width="17%">Besar Tarif </td>
                <td width="83%"><input type="text" name="TARIF_BM" id="TARIF_BM" value="<?= $sess['TARIF_BM']; ?>" class="ssstext" maxlength="3"/> %</td>
            </tr>
        </table>
    </span>
    
    <span id="Spesifik" style="display:none">
    	<h5 class="smaller lighter blue"><b>Tarif Spesifik (Satuan)</b></h5>
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
            	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="Addbm()"><i class="icon-ok"></i>&nbsp;OK</a>
            </td>
        </tr>	        
    </table>
</form>
<script>
$(function(){FormReady();})
$(function(){ 
	changeBM($("#fbarangbc16 #KODE_TARIF_BM").val());
	$("#fbmbc16 ").find("#TARIF_BM").val($("#fbarangbc16 #TARIF_BM").val());		
	$("#fbmbc16 ").find("#TARIF_BM2").val($("#fbarangbc16 #TARIF_BM").val());		
	$("#fbmbc16 ").find("#KODE_SATUAN_BM").val($("#fbarangbc16 #KODE_SATUAN_BM").val());
	$("#fbmbc16 ").find("#JUMLAH_BM").val($("#fbarangbc16 #JUMLAH_BM").val());
	if($("#fbarangbc16 #KODE_TARIF_BM").val()==2){
		$("#fbmbc16 ").find("#jenis-tarif").html('<select id="KODE_TARIF_BM" onchange="changeBM(this.value)" class="text"><option value="1">1 - ADVALORUM</option><option value="2" selected>2 - SPESIFIK</option></select>');	
	}else{		
		$("#fbmbc16 ").find("#jenis-tarif").html('<select id="KODE_TARIF_BM" onchange="changeBM(this.value)" class="text"><option value="1" selected>1 - ADVALORUM</option><option value="2">2 - SPESIFIK</option></select>');
	}
})

function Addbm(){
	var jenis = $("#fbmbc16 #KODE_TARIF_BM").val();
	if(jenis==1){
		$("#fbarangbc16 #TARIF_BM").val($("#fbmbc16 #TARIF_BM").val());
		$("#tipebm").html('Advolorum<input type="hidden" name="TARIF[KODE_TARIF_BM]" id="KODE_TARIF_BM" value="'+jenis+'">');	
		$("#tipespesifik").html('');
	}else{
		var kodesatu = $("#fbmbc16 #KODE_SATUAN_BM").val();
		var jumlahbm = $("#fbmbc16 #JUMLAH_BM").val();
		$("#tipespesifik").html('<table><tr><td align="right">Per</td><td><input type="text" name="TARIF[KODE_SATUAN_BM]" id="KODE_SATUAN_BM" class="ssstext" value="'+kodesatu+'"/>&nbsp;&nbsp;Jumlah Satuan&nbsp;<input type="text" name="BARANG[JUMLAH_BM]" id="JUMLAH_BM" class="stext" value="'+jumlahbm+'"/></td></tr></table>');	
		$("#tipebm").html('Spesifik<input type="hidden" name="TARIF[KODE_TARIF_BM]" id="KODE_TARIF_BM" value="'+jenis+'">');	
		$("#fbarangbc16 #TARIF_BM").val($("#fbmbc16 #TARIF_BM2").val());
	}
	closedialog('dialog-bm');
}
</script>