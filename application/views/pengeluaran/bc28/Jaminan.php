<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fjaminan_form">
	<?php if(!$list){?>
        <h5 class="header smaller lighter green"><b>DATA JAMINAN</b></h5>
        <form id="fjaminan_" action="<?= site_url()."/pengeluaran/jaminan/bc28"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pengeluaran/detil/jaminan/bc28" ?>">
            <input type="hidden" name="act" value="<?= $act; ?>" />
            <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
            <input type="hidden" name="NOMOR_JAMINAN1" id="NOMOR_JAMINAN1" readonly value="<?= $sess['NOMOR_JAMINAN']; ?>" />
            <input type="hidden" name="JENIS_JAMINAN1" id="JENIS_JAMINAN1" readonly value="<?= $sess['JENIS_JAMINAN']; ?>" />
            <table width="100%">
            	<tr>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td width="170">Jenis Jaminan</td>
                                <td>
                                    <?php echo "<combo>".form_dropdown('JAMINAN[JENIS_JAMINAN]', $JENIS_JAMINAN, $sess['JENIS_JAMINAN'], 'id="JENIS_JAMINAN" class="text" ')."</combo>";?>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Jaminan</td>
                                <td><input type="text" name="JAMINAN[NOMOR_JAMINAN]" id="NOMOR_JAMINAN" class="text" value="<?= $sess['NOMOR_JAMINAN']; ?>" maxlength="30" /></td>
                            </tr>
                            <tr>
                                <td>Tanggal Jaminan</td>
                                <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"><input type="text" name="JAMINAN[TANGGAL_JAMINAN]" id="TANGGAL_JAMINAN" onfocus="ShowDP('TANGGAL_JAMINAN')" onMouseOver="ShowDP('TANGGAL_JAMINAN')" value="<?= $sess['TANGGAL_JAMINAN']; ?>" class="form-control" style="width:95px" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD </td>
                            </tr>
                            <tr>
                                <td>Nilai Jaminan</td>
                                <td><input type="text" name="UR_NILAI_JAMINAN" id="UR_NILAI_JAMINAN"  class="text" value="<?= $this->fungsi->FormatRupiah($sess['NILAI_JAMINAN'],2); ?>" maxlength="18" onkeyup="this.value = ThausandSeperator('NILAI_JAMINAN',this.value,2);"/><input type="hidden" name="JAMINAN[NILAI_JAMINAN]" id="NILAI_JAMINAN" value="<?= $sess['NILAI_JAMINAN']?>" /></td>
                            </tr>
                        </table>
					</td>
                    <td width="50%">
                    	<table>
                        	<tr>
                            	<tr>
                                    <td width="190">Tanggal Jatuh Tempo</td>
                                    <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"><input type="text" name="JAMINAN[TGL_JATUH_TEMPO]" id="TGL_JATUH_TEMPO" onfocus="ShowDP('TGL_JATUH_TEMPO')" onMouseOver="ShowDP('TGL_JATUH_TEMPO')" value="<?= $sess['TGL_JATUH_TEMPO']; ?>" class="form-control" style="width:95px" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD </td>
                                </tr>
                                <tr>
                                    <td width="170">Penjamin</td>
                                    <td><input type="text" name="JAMINAN[PENJAMIN]" id="PENJAMIN" value="<?= $sess['PENJAMIN']; ?>" class="text" /></td>
                                </tr>
                                <tr>
                                    <td width="170">No. Bukti Penerimaan Jaminan</td>
                                    <td><input type="text" name="JAMINAN[NO_BUKTI_PENERIMAAN_JAMINAN]" id="NO_BUKTI_PENERIMAAN_JAMINAN" value="<?= $sess['NO_BUKTI_PENERIMAAN_JAMINAN']; ?>" class="text" /></td>
                                </tr>
                                <tr>
                                    <td width="190">Tgl. Bukti Penerimaan Jaminan</td>
                                    <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"><input type="text" name="JAMINAN[TGL_BUKTI_PENERIMAAN_JAMINAN]" id="TGL_BUKTI_PENERIMAAN_JAMINAN" onfocus="ShowDP('TGL_BUKTI_PENERIMAAN_JAMINAN')" onMouseOver="ShowDP('TGL_BUKTI_PENERIMAAN_JAMINAN')" value="<?= $sess['TGL_BUKTI_PENERIMAAN_JAMINAN']; ?>" class="form-control" style="width:95px" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD </td>
                                </tr>
                            </tr>
                        </table>
                    </td>
				</tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                    	<a href="javascript:void(0);" class="btn btn-success btn-l save" id="ok_" onclick="save_detil('#fjaminan_','msgdokumen_');">
                        	<i class="fa fa-save"></i>&nbsp;<?= ucwords($act); ?>
                       	</a>&nbsp;
                        <a href="javascript:;" class="btn btn-warning btn-l cancel" id="cancel_" onclick="cancel('fjaminan_');">
                        	<i class="icon-undo"></i>&nbsp;Reset
                      	</a>&nbsp;<span class="msgdokumen_" style="margin-left:20px">&nbsp;</span>
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
	<div id="fjaminan_list"><?= $list ?></div>
<?php } ?>
<script>
	$(function(){FormReady();})
</script>
