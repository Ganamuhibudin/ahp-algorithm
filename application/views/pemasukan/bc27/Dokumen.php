<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fdokumen_form">
<?php if(!$list){?>
    <form id="fdokumen_" action="<?= site_url()."/pemasukan/dokumen/bc27"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pemasukan/detil/dokumen/bc27" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="kd_dok" id="kd_dok" value="<?=$sess['KODE_DOKUMEN']?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL DOKUMEN</b></h5>
        <table>
            <tr>
                <td>Kode Dokumen </td>
                <td><combo><? if($act=="update"){ echo "<combo>".form_dropdown('KODE_DOKUMEN_COMBO', $KODE, $sess['KODE_DOKUMEN'], 'value="<?= $kode_dokumen;?>" id="kode_dokumen" disabled class="text" wajib="yes"')."</combo>";echo "<input type=hidden name=KODE_DOKUMEN id=KODE_DOKUMEN value=$sess[KODE_DOKUMEN]>";
                 }else{ echo "<combo>".form_dropdown('KODE_DOKUMEN', $KODE, $sess['KODE_DOKUMEN'], 'value="<?= $kode_dokumen;?>" id="kode_dokumen"  class="text" wajib="yes"')."</combo>";} ?></combo></td>
            </tr>
            <tr>
                <td width="145">Nomor </td>
                <td><input type="text" name="DOKUMEN[NOMOR]" id="NOMOR" class="text" value="<?= $sess['NOMOR']; ?>" maxlength="30" wajib="yes"/>
                <input style="margin-left:5px;display:none" type="button" name="cari" id="cari23" class="btn btn-primary btn-xs" onclick="tb_search('BC23ASAL','NOMOR;TANGGAL','Dokumen BC 2.3 Asal',this.form.id,650,470)" value="...">
                </td>
            </tr>
            
            <tr>
                <td>Tanggal </td>
                    <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"><input type="text" name="DOKUMEN[TANGGAL]" id="TANGGAL" class="form-control" style="width:100px" value="<?= $sess['TANGGAL']; ?>" maxlength="30" onfocus="ShowDP(this.id);" onmouseover="ShowDP(this.id);" wajib="yes"/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;YYYY-MM-DD</td>
            </tr> 
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="2"><a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fdokumen_','msgdokumen_');">
                        <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;
                    </a>
                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fdokumen_');">
                        <i class="icon-undo"></i>&nbsp;Reset&nbsp;
                    </a>&nbsp;
                    <span class="msgdokumen_" style="margin-left:20px">&nbsp;</span>
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
<div id="fdokumen_list"><?= $list ?></div>
<?php } ?>
<script>
$(function(){FormReady();})
function dokumen(){
	var dok = $("#KODE_DOKUMEN").val();
	if(dok=="B23"){
		$("#cari23").show();
		$("#NOMOR").attr("readonly","readonly");
		$("#TANGGAL").attr("readonly","readonly");
	}else{ 
		$("#cari23").hide();	
		$("#NOMOR").removeAttr("readonly");
		$("#TANGGAL").removeAttr("readonly");
	}
	return false;
}
</script>