<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fkemasan_form">
	<?php if(!$list){
		if($act=='update'){ 
			$readonly="readonly=readonly";
			$autocomplete="";
		}else{
			$readonly="";
			$autocomplete="onfocus=Autocomp(this.id)";
		}
	?>
	<form id="fkemasan_" action="<?= site_url()."/pengeluaran/kemasan/bc28"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pengeluaran/detil/kemasan/bc28" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="kode_kemas" id="kode_kemas" value="<?= $sess["KODE_KEMASAN"]; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <table width="100%">
            <tr>
                <td width="145">Merk </td>
                <td><input type="text" name="KEMASAN[MERK_KEMASAN]" id="MERK_KEMASAN" class="text" wajib="yes" value="<?= $sess['MERK_KEMASAN']; ?>" maxlength="30"/></td>
            </tr>
            <tr>
                <td>Jumlah </td>
                <td><input type="text" name="JUMLAHUR" id="JUMLAHUR" wajib="yes" class="text" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH'],2); ?>" maxlength="18" onkeyup="this.value = ThausandSeperator('JUMLAH',this.value,2);"/><input type="hidden" name="KEMASAN[JUMLAH]" id="JUMLAH" value="<?= $sess['JUMLAH']?>" /></td>
            </tr>
            <tr>
                <td>Jenis Kemasan </td>
                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                      <input type="text" wajib="yes" name="KEMASAN[KODE_KEMASAN]" id="KODE_KEMASAN" <?= $readonly;?> url="<?= site_url(); ?>/autocomplete/kemasan" class="stext date" value="<?= $sess['KODE_KEMASAN']; ?>" urai="urjenis_kemasan;" <?= $autocomplete;?> />
                    <span class="input-group-btn">
                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan','KODE_KEMASAN;urjenis_kemasan','Kode Kemasan','fkemasan_',650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                    </div>&nbsp;
                    <span id="urjenis_kemasan" class="uraian"><?= $sess['URAIAN']==''?$URAIAN_KEMASAN:$sess['URAIAN']; ?></span>
           		</td>
            </tr> 
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
                	<a href="javascript:void(0);" class="btn btn-success btn-l save" id="ok_" onclick="save_detil('#fkemasan_','msgkemasan_');">
                    	<span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span>
                   	</a>
                  	<a href="javascript:;" class="btn btn-warning btn-l cancel" id="cancel_" onclick="cancel('fkemasan_');">
                    	<span><i class="icon-undo"></i>&nbsp;reset&nbsp;</span>
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
