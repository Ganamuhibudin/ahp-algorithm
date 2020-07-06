<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
$event="tb_search('barang_gudang','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;SATUAN;ur_satuan','Kode Barang',this.form.id,680,445)";
$btn='<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="'.$event.'" value="...">';
if($act=="save"){
    $GUDANG = array(""=>"Silahkan Pilih Barang Terlebih Dahulu");
    $KONDISI = array(""=>"Silahkan Pilih Barang Terlebih Dahulu");
    $KODE_RAK = "";//array(""=>"-- Pilih --");
    $KODE_SUB_RAK = "";//array(""=>"-- Pilih --");
}else{
    $wajib = "wajib='yes'";
}

?>  
	<div class="header">
		<h4 class="header smaller green"><?= $judul;?></h4>
	</div>
	<div class="content" style="padding-left:10px">
		<form name="fstock-barang" id="fstock-barang" action="<?= site_url()."/inventory/set_stockopname/".$act; ?>" method="post" autocomplete="off">
            <input type="hidden" name="GUDANG" id="GUDANG" readonly />
            <input type="hidden" name="act" id="act" value="<?=$act;?>" />
            <input type="hidden" name="ID" id="ID" value="<?=$DATA["ID"];?>">
            <input type="hidden" name="DATA[JNS_BARANG]" id="JNS_BARANG" value="<?=$DATA["JNS_BARANG"];?>">
        	<input type="hidden" name="DATA[TANGGAL_STOCK]" id="TANGGAL_STOCK" value="<?=$DATA["TANGGAL_STOCK"];?>">
            <input type="hidden" name="KODE_BARANG_OLD" id="KODE_BARANG_OLD" readonly value="<?= $DATA['KODE_BARANG']; ?>" />
			<span id="divtmp"></span>
			<table width="100%" border="0">
    			<tr>
        			<td>Kode Barang</td>
                    <td>
                        <input type="text" name="DATA[KODE_BARANG]" id="KODE_BARANG" onclick="<?=$event?>" onFocus="getGudangBarang()" readonly class="stext" value="<?= $DATA['KODE_BARANG']; ?>" wajib="yes"/>&nbsp;<?=$btn?>
                    </td>
                </tr>
                <tr>
                    <td>Uraian Barang</td>
                    <td><textarea class="mtext" name="URAIAN_BARANG" readonly id="URAIAN_BARANG" wajib="no"><?= $DATA['URAIAN_BARANG'];?></textarea></td>
                </tr>
                 <tr>
                    <td>Jenis Barang</td>
                    <td><input type="text" name="JENIS_BARANG" id="JENIS_BARANG" readonly class="mtext" value="<?= $DATA['JENIS_BARANG']; ?>" wajib="yes"/></td>
                </tr>
                 <tr>
                    <td>Jumlah</td>
                    <td><input type="text" name="DATA[JUMLAH]" id="JUMLAH" class="mtext"  value="<?= $DATA['JUMLAH']; ?>" wajib="yes" format="angka"/></td>
                </tr>
                <tr>
                    <td>Satuan</td>
                    <td><input type="text" name="SATUAN" id="SATUAN" readonly class="mtext"  value="<?= $DATA['KODE_SATUAN']; ?>" wajib="yes" />&nbsp;<span id="ur_satuan"><?=$DATA["URAIAN_SATUAN"]?></span></td>
                </tr>
                <tr>
                    <td>Gudang</td>
                    <td id="tdGudang1"><combo id="gud"><?= form_dropdown('KODE_GUDANG',array_merge(array(""=>"-- Pilih --"),$GUDANG), $DATA['KODE_GUDANG'], 'id="KODE_GUDANG" class="mtext" wajib="yes" onChange="getRak(\'fstock-barang\',\'1\')" '.$disabled); ?></combo>
                </tr>
                <tr>
                    <td>Rak</td>
                    <td id="tdRak1"><combo id="rak"><?= form_dropdown('DATA[KODE_RAK]',array_merge(array(""=>"-- Pilih --"),$KODE_RAK), $DATA['KODE_RAK'], 'id="KODE_RAK" class="mtext" onChange="getSubrak(\'fstock-barang\',\'1\')" '.$wajib.' '.$disabled); ?></combo>
                    </td>
                </tr>
                <tr>
                    <td>Sub Rak</td>
                    <td id="tdSubRak1"><combo id="subrak"><?= form_dropdown('DATA[KODE_SUB_RAK]',array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), $DATA['KODE_SUB_RAK'], 'id="KODE_SUB_RAK" class="mtext" '.$wajib.' '.$disabled); ?></combo>
                    </td>
                </tr>
                <tr>
                    <td>Kondisi</td>
                    <td id="td-kondisi-stock"><combo id="kon"><?= form_dropdown('DATA[KONDISI_BARANG]',array_merge(array(""=>"-- Pilih --"),$KONDISI), $DATA['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="mtext" wajib="yes" '.$disabled); ?></combo>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>
                   <textarea class="mtext" name="DATA[KETERANGAN]" id="KETERANGAN" wajib="no" maxlength="100"><?= $DATA['KETERANGAN'];?></textarea>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>           
				<tr>
                	<td colspan="2">
                    	<a href="javascript:void(0);" class="btn btn-sm btn-success" onclick="save_popup('#fstock-barang','msgdtl_','divfstockdetil');" style="color:#fff"><i class="fa fa-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;</a>&nbsp;
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="cancel('fstock-barang');closedialog('dialog-produksi');" style="color:#fff"><i class="fa fa-times"></i>&nbsp;Cancel&nbsp;</a>
                  </td>
				</tr>
                <tr>
					<td width="31%" valign="top" colspan="2"><span class="msgdtl_"></span></td>
                </tr>    
			</table>
		</form>
	</div>

<script>
$(function(){
	$("#fstock-barang").find("#TANGGAL_STOCK").val($("#fstock").find("#TANGGAL_STOCK").val());
})

function getGudangBarang(){
    var kdBrg = $("#KODE_BARANG").val();
    var jnsBrg = $("#JNS_BARANG").val();
    var kdBrgOld = $("#KODE_BARANG_OLD").val();
    $("#KODE_RAK").empty();
    $("#KODE_SUB_RAK").empty();
    if (kdBrg != "" && kdBrg != kdBrgOld) {
        $("#KODE_BARANG_OLD").val(kdBrg);
        $.ajax({
            type: 'post',
            url: site_url + '/inventory/getGudangBarang',
            data: {kode_barang:kdBrg, jns_barang: jnsBrg, formid:'fstock-barang'},
            success: function(data) {
                var arrdata = data.split("#");
                $("#tdGudang1 #KODE_GUDANG").remove();
                $("#tdGudang1 #gud").append(arrdata[0]);
                $("#td-kondisi-stock #KONDISI_BARANG").remove();
                $("#td-kondisi-stock #kon").append(arrdata[1]); 
				
            }
        });
    }
}
</script> 