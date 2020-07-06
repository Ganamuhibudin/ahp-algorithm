<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fdokumen_form">
<?php if(!$list){?>
<form id="fdokumen_" action="<?= site_url()."/pemasukan/dokumen/bc20"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pemasukan/detil/dokumen/bc20" ?>" class="form-horizontal">
<input type="hidden" name="act" value="<?= $act; ?>" />
<input type="hidden" name="seri" id="seri" value="<?= $sess['DOKNO'] ?>" />
<input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
<h5 class="header smaller lighter green"><b>DETIL DOKUMEN</b></h5> 
<table>
	<tr>
        <td>Kode Dokumen </td>
        <td>
		
		<?php  if($act=="update"){ echo "<combo>".form_dropdown('KODE_DOKUMEN_COMBO', $KODE, $sess['DOKKD'], 'id="kode_dokumen" disabled class="text" wajib="yes" onchange="testhidden()"')."</combo>";echo "<input type=hidden name=DOKKD id=DOKKD value=$sess[DOKKD]>";
		 }else{ echo "<combo>".form_dropdown('DOKKD', $KODE, $sess['DOKKD'], ' id="kode_dokumen"  class="text" wajib="yes" onchange="testhidden()"')."</combo>";}?><br />
         
         <span id="pengecualian">
         <input type="text" name="DOKNO" id="KODE" value="<?= substr($sess['DOKNO'],0,5); ?>" url="<?= site_url(); ?>/autocomplete/dokumen_izin" onfocus="Autocomp(this.id)" class="ssstext" urai="URAIAN;" />
         <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('dokumen_izin','KODE','KODE',this.form.id,650,400)" value="...">&nbsp;
            <span id="KODE"><?= $sess['DOKNO']; ?></span>
          </span>
        </td>
    </tr>
     <tr>
        <td width="145">Nomor </td>
      <td>
 <input type="text" name="DOKUMEN[DOKNO]" id="DOKNO" class="text" value="<? if($sess['DOKKD']=='888') echo substr($sess['DOKNO'],5); else echo $sess['DOKNO'];  ?>" maxlength="30" wajib="yes"/></td>
    </tr>
    <tr>
        <td>Tanggal </td>
            <td><input type="text" name="DOKUMEN[DOKTG]" id="DOKTG" class="sstext" value="<?= $sess['DOKTG']; ?>" maxlength="30" onfocus="ShowDP(this.id);" onmouseover="ShowDP(this.id);" wajib="yes"/>&nbsp; YYYY-MM-DD</td>
    </tr>
<tr>
 	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="3">
  <a href="javascript:void(0);" class="btn btn-sm btn-success" id="ok_" onclick="save_detil('#fdokumen_','msgdokumen_');"><span><i class="icon-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-sm btn-warning" id="cancel_" onclick="cancel('fdokumen_');"><span><i class="icon-undo"></i>&nbsp;reset&nbsp;</span></a><span class="msgdokumen_" style="margin-left:20px">&nbsp;</span>
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
<div id="fdokumen_list" style="margin-top:10px"><?= $list ?></div>
<?php } ?>
<script>
$(function(){
	FormReady();
	testhidden();
})
	function testhidden(){
		if($('#kode_dokumen').val()=='888'){
			$('#pengecualian').show();
		}else{
			$('#pengecualian').val('');
			$('#pengecualian').hide();
		}
	}
</script>