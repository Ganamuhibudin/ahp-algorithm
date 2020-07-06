<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fdokumen_form">
<?php if(!$list){?>
    <form id="fdokumen_" action="<?= site_url()."/pemasukan/dokumen/bc40"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pemasukan/detil/dokumen/bc40" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL DOKUMEN</b></h5>
        <table>
            <tr>
                <td width="145">Jenis Dokumen</td>
                <td>
                <? // form_dropdown('DOKUMEN[KODE_DOKUMEN]', $KODE, $sess['KODE_DOKUMEN'], 'id="KODE_DOKUMEN" class="text" wajib="yes" '); 
                     if($act=="update"){ echo "<combo>".form_dropdown('KODE_DOKUMEN_COMBO', $kode_dokumen, $sess['KODE_DOKUMEN'], 'value="<?= $kode_dokumen;?>" id="kode_dokumen" disabled class="text" wajib="yes"')."</combo>";echo "<input type=hidden name=KODE_DOKUMEN id=KODE_DOKUMEN value=$sess[KODE_DOKUMEN]>";
                     }else{ echo "<combo>".form_dropdown('KODE_DOKUMEN', $kode_dokumen, $sess['KODE_DOKUMEN'], '" id="kode_dokumen"  class="text" wajib="yes"')."</combo>";}?>
                </td>
            </tr>
            <tr>
                <td>Nomor Dokumen</td>
                <td><input type="text" name="DOKUMEN[NOMOR]" id="NOMOR" class="text" value="<?= $sess['NOMOR']; ?>" maxlength="30" wajib="yes"/></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td><input type="text" name="DOKUMEN[TANGGAL]" id="TANGGAL" onfocus="ShowDP('TANGGAL')" onmouseover="ShowDP(this.id);" value="<?= $sess['TANGGAL']; ?>" class="stext date" wajib="yes"/>&nbsp; YYYY-MM-DD</td>
            </tr>      
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
              		<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fdokumen_','msgdokumen_');">
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
	if($edit) echo '<h5 class="header smaller lighter green"><b>&nbsp;</b></h5>';
?>
<?php if(!$edit){ ?>
<div id="fdokumen_list"><?= $list ?></div>
<?php } ?>
<script>
$(function(){FormReady();})
</script>
