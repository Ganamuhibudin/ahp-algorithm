<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
$event="tb_search('barang_gudang','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;KODE_SATUAN;uraisatdet;STOCK_AKHIR','Kode Barang',this.form.id,600,400)";
$btn='<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="'.$event.'" value="...">';	
if($act=="save"){
    $KODE_GUDANG = "";//array(""=>" -- Pilih --");
    $KONDISI_BARANG = "";//array(""=>"-- Pilih --");
	$KODE_RAK = "";//array(""=>"-- Pilih --");
	$KODE_SUB_RAK = "";//array(""=>"-- Pilih --");
}			  	
?>
<!-- <h4 class="header smaller green">Form Detil Barang</h4> -->
<form name="fBahanBaku" id="fBahanBaku" autocomplete="off">
    <input type="hidden" name="act" id="act" value="<?= $act;?>" readonly />
    <input type="hidden" name="JNS_BARANG" id="JNS_BARANG" value="<?=$sess["JNS_BARANG"];?>" readonly>
    <input type="hidden" name="STOCK_AKHIR" id="STOCK_AKHIR" value="<?= $sess["STOCK_AKHIR"];?>" readonly>
    <br>
    <table width="100%" border="0">
        <tr>
            <td width="45%" valign="top">	
                <table width="100%" border="0">
                    <tr>
                        <td width="263">Kode Barang </td>
                        <td width="820">
                        <input type="text" name="KODE_BARANG" id="KODE_BARANG" onFocus="getGudangBarang()" readonly onclick="<?= $event;?>" class="stext" value="<?= $sess['KODE_BARANG']; ?>" wajib="yes"/>&nbsp;<?=$btn?>
                    </tr> 
                    <tr>
                        <td width="263">Uraian Barang </td>
                        <td width="820">
                        <textarea name="URAIAN_BARANG" id="URAIAN_BARANG" readonly class="mtext"><?= $sess['URAIAN_BARANG']; ?></textarea></tr>
                    <tr>
                        <td width="263">Jenis Barang</td>
                        <td width="820">
                        <input type="text" name="JENIS_BARANG" id="JENIS_BARANG" readonly class="mtext" value="<?= $sess['JENIS_BARANG']; ?>" wajib="yes" style="width:62%"/>
                    </tr> 
                    <tr>
                        <td>Gudang</td>
                        <td id="td-gudang-bb">
                            <combo id="gud"><?= form_dropdown('KODE_GUDANG',array_merge(array(""=>"-- Pilih --"),$KODE_GUDANG), $sess['KODE_GUDANG'], 'id="KODE_GUDANG" class="text" wajib="yes" onChange="getRak()" style="width:62%"'.$disabled); ?></combo>
                        </td>
                    </tr>
                    <tr>
                        <td>Rak</td>
                        <td id="td-rak-bb"><combo id="rak"><?= form_dropdown('KODE_RAK',array_merge(array(""=>"-- Pilih --"),$KODE_RAK), $sess['KODE_RAK'], 'id="KODE_RAK" class="text" onChange="getSubRak()" style="width:62%"'.$disabled); ?></combo>
                        </td>
                    </tr>
                    <tr>
                        <td>Sub Rak</td>
                        <td id="td-subrak-bb"><combo id="subrak"><?= form_dropdown('KODE_SUB_RAK',array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), $sess['KODE_SUB_RAK'], 'id="KODE_SUB_RAK" class="text" style="width:62%"'.$disabled); ?></combo>
                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi</td>
                        <td id="td-kondisi-bb">
                            <combo id="kon"><?= form_dropdown('KONDISI_BARANG',array_merge(array(""=>"-- Pilih --"),$KONDISI_BARANG), $sess['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="text" wajib="yes" style="width:62%"'.$disabled); ?></combo>
                        </td>
                    </tr>
                     <tr>
                        <td width="263">Jumlah</td>
                        <td width="820">
                        <input type="text" name="JUMLAH" id="JUMLAH"  class="stext" value="<?= $sess['JUMLAH']; ?>" wajib="yes" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,4);"/> <input type="hidden" name="JUMLAH_SATUAN" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH']?>" />    </td>
                    </tr> 
                    <tr>
                        <td width="263">Satuan</td>
                        <td width="820">
                        <input type="text" name="BBDET[KODE_SATUAN]" id="KODE_SATUAN"  class="stext" style="width:11%" value="<?= $sess['KODE_SATUAN']; ?>" wajib="yes" readonly />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="uraisatdet" class="uraian"><?= $sess['URAIAN_SATUAN']; ?></span></td>
                    </tr>
                    <tr>
                        <td width="263">Keterangan</td>
                        <td width="820">
                        <textarea name="BBDET[KETERANGAN]" id="KETERANGAN"  class="mtext"><?= $sess['KETERANGAN']; ?></textarea>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
      
        <tr>
            <td>
             <table width="100%" border="0">
                <tr>
                    <td width="100%"> <hr style="margin-bottom:10px;margin-top:20px">				
                       <a href="javascript:void(0);" class="btn btn-success btn-sm save" style="color:#FFFFFF" id="ok_" onclick="save_produksi('#fBahanBaku','<?=$sess['ID']?>')"><span><i class="fa fa-save"></i>&nbsp;<?= ucfirst($act);?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning btn-sm cancel" style="color:#FFFFFF" id="cancel_" onclick="cancel('fBahanBaku');"><span><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msgdetil_">&nbsp;</span>
                    </td>
                </tr>
            </table>
            </td>
        </tr>
    </table>
</form>
<script>
function getGudangBarang(){
	//alert('test');
   var kdBrg = $("#KODE_BARANG").val();
    var jnsBrg = $("#JNS_BARANG").val();
    var kdBrgOld = $("#KODE_BARANG_OLD").val();
	//$(':input','#'+'fBahanBaku') .not(':button, :submit, :reset, :hidden') .val('') .removeAttr('checked') .removeAttr('selected');
	$("#KODE_GUDANG").empty();
	$("#KODE_RAK").empty();
	$("#KODE_SUB_RAK").empty();
    if (kdBrg != "" && kdBrg != kdBrgOld) {
        $("#KODE_BARANG_OLD").val(kdBrg);
        $.ajax({
            type: 'post',
            url: site_url + '/produksi/getGudangBarang',
            data: {kode_barang:kdBrg, jns_barang: jnsBrg},
            success: function(data) {
                var arrdata = data.split("#");
                $("#td-gudang-bb #KODE_GUDANG").remove();
                $("#td-gudang-bb #gud").append(arrdata[0]);
                $("#td-kondisi-bb #KONDISI_BARANG").remove();
                $("#td-kondisi-bb #kon").append(arrdata[1]);
            }
        });
    }
}

/* Tambahan untuk select rak berdasarkan gudang */
function getRak(){
	//alert('apa');
	var kdBrg = $("#KODE_BARANG").val();
	var jnsBrg = $("#JNS_BARANG").val();
	var kdGudang = $("#KODE_GUDANG").val();	
    //alert(document.getElementById("KODE_GUDANG").options[1]);return false;
		$.ajax({
			type: 'post',
			url: site_url + '/produksi/getRak',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang},
			success: function(data){
				var arrdata = data.split("#");
				$("#td-rak-bb #KODE_RAK").remove();
				$("#td-rak-bb #rak").append(arrdata[0]);
                if(kdGudang==""){
                 var i;
                 for(i=document.getElementById("KODE_SUB_RAK").options.length-1;i>=0;i--)
                 {
                     document.getElementById("KODE_SUB_RAK").options.remove(i);
                     $("#td-subrak-bb #KODE_SUB_RAK").removeAttr("wajib");
                 }
                }
			}
		});
}
function getSubRak(){
	//alert('apa');
	var kdBrg = $("#KODE_BARANG").val();
	var jnsBrg = $("#JNS_BARANG").val();
	var kdGudang = $("#KODE_GUDANG").val();	
	var kdRak	 = $("#KODE_RAK").val();
	if(kdRak!=""){
		$.ajax({
			type: 'post',
			url: site_url + '/produksi/getSubRak',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kode_rak:kdRak},
			success: function(data){
				var arrdata = data.split("#");
				$("#td-subrak-bb #KODE_SUB_RAK").remove();
				$("#td-subrak-bb #subrak").append(arrdata[0]);
			}
		});
	}
}
/* END */
</script> 