<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fkemasan_form">
<?php if(!$list){?>
	<form id="fkemasan_" action="<?= site_url()."/pemasukan/kemasan/ppb"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pemasukan/detil/kemasan/ppb" ?>">
    	<input type="hidden" readonly name="act" value="<?= $act; ?>" />
        <input type="hidden" readonly name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" readonly name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL KEMASAN</b></h5>
        <table>
            <tr>
                <td width="145">Merk </td>
                <td><input type="text" name="KEMASAN[MERK_KEMASAN]" id="MERK_KEMASAN" class="text" value="<?= $sess['MERK_KEMASAN']; ?>" maxlength="30" wajib="yes" /></td>
            </tr>
            <tr>
                <td>Jumlah </td>
                <td><input type="text" name="JUMLAHUR" id="JUMLAHUR" wajib="yes" class="text" value="<?= $sess['JUMLAH']; ?>" maxlength="18" onkeyup="this.value = ThausandSeperator('JUMLAH',this.value,2);"/><input type="hidden" name="KEMASAN[JUMLAH]" id="JUMLAH" value="<?= $sess['JUMLAH']?>" /></td>
            </tr>
            <tr>
                <td>Jenis Kemasan </td>
                    <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                      <input type="text" name="KEMASAN[KODE_KEMASAN]" id="KODE_KEMASAN" url="<?= site_url(); ?>/autocomplete/kemasan" class="sstext" value="<?= $sess['KODE_KEMASAN']; ?>" onfocus="Autocomp(this.id,this.form.id)" urai="urjenis_kemasan;" wajib="yes"/>
                      <span class="input-group-btn">
                          <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan','KODE_KEMASAN;urjenis_kemasan','Kode Kemasan','fkemasan_',650,445)"><i class="fa fa-ellipsis-h"></i></a></span>
                      </div>&nbsp;
                    <span id="urjenis_kemasan" class="uraian"><?= $sess["URAIAN"]; ?></span></td>
            </tr> 
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
              		<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fkemasan_','msgkemasan_');"><i class="icon-save"></i>&nbsp;<?=ucwords($act)?></a>&nbsp;
                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fkemasan_');"><i class="icon-undo"></i>&nbsp;Reset</a>&nbsp;
                    <span class="msgkemasan_" style="margin-left:20px">&nbsp;</span>
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
<div id="fkemasan_list"><?= $list ?></div>
<?php } ?>

<script>
$(function(){FormReady();})
</script>