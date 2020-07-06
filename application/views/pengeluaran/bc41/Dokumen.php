<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fdokumen_form">
	<?php if(!$list){?>
        <form id="fdokumen_" action="<?= site_url()."/pengeluaran/dokumen/bc41"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pengeluaran/detil/dokumen/bc41" ?>">
            <input type="hidden" name="act" value="<?= $act; ?>" />
            <input type="hidden" name="kode_dok" id="kode_dok" value="<?= $kode_dok; ?>" />
            <input type="hidden" name="NOMOR" id="NOMOR" value="<?= $sess['NOMOR']; ?>" />
            <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
            <h5 class="header smaller lighter green"><b>DETIL DOKUMEN</b></h5>
            <table>
                <tr>
                    <td width="145">Jenis Dokumen</td>
                    <td>
						<?php if($act=="update") echo "<combo>".form_dropdown('KODE_DOKUMEN', $kode_dokumen, $sess['KODE_DOKUMEN'], 'value="<?= $kode_dokumen;?>" id="kode_dokumen" class="text" wajib="yes" disabled')."</combo>";
                        else echo "<combo>".form_dropdown('KODE_DOKUMEN', $kode_dokumen, $sess['KODE_DOKUMEN'], 'value="<?= $kode_dokumen;?>" id="kode_dokumen"  class="text" wajib="yes"')."</combo>";?>
                    </td>
                </tr>
                <tr>
                    <td>Nomor Dokumen</td>
                    <td><input type="text" name="DOKUMEN[NOMOR]" id="NOMOR" class="text" value="<?= $sess['NOMOR']; ?>" maxlength="30" wajib="yes"/></td>
                </tr>
                <tr>
                    <td>Tanggal*</td>
                    <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> <input type="text" name="DOKUMEN[TANGGAL]" id="TANGGAL" onfocus="ShowDP('TANGGAL')" onMouseOver="ShowDP('TANGGAL')" value="<?= $sess['TANGGAL']; ?>" class="form-control" style="width:90px" wajib="yes"/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD</td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                    	<a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_detil('#fdokumen_','msgdokumen_');">
                        	<i class="fa fa-save"></i>&nbsp;<?= ucwords($act); ?>
                       	</a>
                        <a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('fdokumen_');">
                        	<i class="icon-undo"></i>&nbsp;Reset
                       	</a>
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
</script>
<script type="text/javascript">
	$(document).ready(function(){
		if ($('#revisi_dok').length > 0) {
			$('#tralasan_dok').show();
			$('#tdrevisi_dok').html('<input type="text" name="flagrevisi" value="1" />');
		}
	});
</script>
