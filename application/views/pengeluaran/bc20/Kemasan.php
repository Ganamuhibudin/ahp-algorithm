<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<span id="fkemasan_form">
<?php if(!$list){
?>
<form id="fkemasan_" action="<?= site_url()."/pengeluaran/kemasan/bc20"; ?>" method="post" class="form-horizontal"  autocomplete="off" list="<?= site_url()."/pengeluaran/detil/kemasan/bc20" ?>">
  <input type="hidden" name="act" value="<?= $act; ?>" />
  <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
  <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
  <h5 class="header smaller lighter green"><b>DETIL KEMASAN</b></h5>            
  <table>
    <tr>
      <td width="145">Merk </td>
      <td><input type="text" name="KEMASAN[MERKKEMAS]" id="MERKKEMAS" class="text" value="<?= $sess['MERKKEMAS']; ?>" maxlength="30" wajib="yes" /></td>
    </tr>
    <tr>
      <td>Jumlah </td>
      <td><input type="text" name="JUMLAHUR" id="JUMLAHUR" wajib="yes" class="text" value="<?= $sess['JMKEMAS']; ?>" maxlength="18" onkeyup="this.value = ThausandSeperator('JMKEMAS',this.value,2);"/>
        <input type="hidden" name="KEMASAN[JMKEMAS]" id="JMKEMAS" value="<?= $sess['JMKEMAS']?>" /></td>
    </tr>
    <tr>
      <td>Jenis Kemasan </td>
      <td><input type="text" name="KEMASAN[JNKEMAS]" id="JNKEMAS" url="<?= site_url(); ?>/autocomplete/kemasan" class="sstext" value="<?= $sess['JNKEMAS']; ?>" onfocus="Autocomp(this.id,this.form.id)" urai="urjenis_kemasan;" wajib="yes"/>
        <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('kemasan','JNKEMAS;urjenis_kemasan','Kode Kemasan',this.form.id,650,400)" value="...">
        &nbsp; <span id="urjenis_kemasan" class="uraian">
        <?= $sess['URAIAN']; ?>
        </span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><a href="javascript:void(0);" class="btn btn-sm btn-success" id="ok_" onclick="save_detil('#fkemasan_','msgkemasan_');"><i class="icon-save"></i>&nbsp;<?= $act; ?></a>&nbsp;<a href="javascript:;" class="btn btn-sm btn-warning" id="cancel_" onclick="cancel('fkemasan_');"><i class="icon-undo"></i>&nbsp;reset</a>&nbsp;<span class="msgkemasan_" style="margin-left:20px">&nbsp;</span></td>
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
