<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fkemasan_form">
	<?php if(!$list){
	if($act=='update'){ 
		$readonly="";
		$autocomplete="onfocus=Autocomp(this.id)";
	}else{
		$readonly="";
		$autocomplete="onfocus=Autocomp(this.id)";
	}
	?>
    <form id="fkemasan_" action="<?= site_url()."/pengeluaran/kemasan/bc41"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pengeluaran/detil/kemasan/bc41" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="kode_kemas" id="kode_kemas" value="<?= $kode_kemas; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL KEMASAN</b></h5>
        <table width="100%">
            <tr>
                <td width="145">Merk </td>
                <td><input type="text" name="KEMASAN[MERK_KEMASAN]" id="MERK_KEMASAN" class="text" value="<?= $sess['MERK_KEMASAN']; ?>" wajib="yes" maxlength="30"/></td>
            </tr>
            <tr>
                <td>Jumlah </td>
                <td>
                	<input type="text" name="JUM_KEMAS" id="JUM_KEMAS" value="<?=$sess['JUMLAH']; ?>" onkeyup="this.value = ThausandSeperator('JUMLAHA',this.value,4);" class="text" format="angka" wajib="yes">
					<input type="hidden" name="KEMASAN[JUMLAH]" id="JUMLAHA" class="text" value="<?= $sess['JUMLAH']; ?>" />
            	</td>
            </tr>
            <tr>
                <td>Jenis Kemasan </td>
                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                       <input type="text" name="KEMASAN[KODE_KEMASAN]" id="KODE_KEMASAN" wajib="yes" <?= $readonly;?> url="<?= site_url(); ?>/autocomplete/kemasan" class="stext date" value="<?= $sess['KODE_KEMASAN']; ?>" urai="urjenis_kemasan;" <?= $autocomplete;?> />
                      <span class="input-group-btn">
                          <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan','KODE_KEMASAN;urjenis_kemasan','Kode Kemasan','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                    </div>&nbsp;
                    <span id="urjenis_kemasan" class="uraian"><?= $sess['URAIAN_KEMASAN']==''?$URAIAN_KEMASAN:$sess['URAIAN_KEMASAN']; ?></span>
                </td>
            </tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                	<a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_detil('#fkemasan_','msgkemasan_');">
                    	<i class="fa fa-save"></i>&nbsp;<?= ucwords($act); ?>
                   	</a>
                    <a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('fkemasan_');">
                    	<i class="icon-undo"></i>&nbsp;Reset
                   	</a>
                    &nbsp;<span class="msgkemasan_" style="margin-left:20px">&nbsp;</span>
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
<script type="text/javascript">
	$(document).ready(function(){
		if ($('#revisi_kms').length > 0) {
			$('#tralasan_kms').show();
			$('#tdrevisi_kms').html('<input type="text" name="flagrevisi" value="1" />');
		}
	});
</script>
