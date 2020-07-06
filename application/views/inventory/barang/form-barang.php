<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="save"){
	$readonly="";
	$action="save_detil('#finventory','msg_')";
}else{
	$readonly="readonly=readonly";
	$action="save_post('#finventory')";
}
?>
<a href="javascript: window.history.go(-1)" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-success">
	<i class="icon-arrow-left"></i>Back
</a>
<div class="header">
	<h3 class="blue"><i class="fa fa-file-text-o"></i>&nbsp;<strong><?=$judul?></strong></h3>
</div>
<div class="content">
	<form name="finventory" id="finventory" action="<?= site_url()."/inventory/set_barang/".$act ?>" method="post" autocomplete="off">
        <input type="hidden" name="HIDE_KODE_BARANG" id="HIDE_KODE_BARANG" value="<?= $DATA['KODE_BARANG'];?>" />
        <input type="hidden" name="HIDE_JNS_BARANG" id="HIDE_JNS_BARANG" value="<?= $DATA['JNS_BARANG'];?>" />
        <input type="hidden" name="jnsbrg" id="jnsbrg" value="<?=$DATA['JNS_BARANG'];?>">
        <table width="100%" border="0">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" border="0">
                        <tr>
                            <td>Kode Perusahaan</td>
                            <td>
                                <combo><?php echo form_dropdown('INVBRG[KODE_PARTNER]', $PARTNER, $DATA['KODE_PARTNER'], 'id="KODE_PARTNER" class="mtext" style="white-space:normal;" wajib="yes"'); 
                                ?></combo>
                            </td>
                        </tr>
                        <tr>
                            <td width="28%">Kode Barang </td>
                            <td width="72%">
                                <input type="text" name="INVBRG[KODE_BARANG]" id="KODE_BARANG" <?= $readonly;?> class="mtext" value="<?= str_replace('"','&quot;',$DATA['KODE_BARANG']); ?>" wajib="yes" maxlength="35"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Kode HS</td>
                            <td>
                                <input type="text" name="INVBRG[KODE_HS]" id="KODE_HS" url="<?= site_url(); ?>/autocomplete/hs" class="form-control" style="width:40%" value="<?= $DATA['KODE_HS']; ?>" onfocus="Autocomp(this.id, this.form.id)" urai="SERI;KODE_HS;" maxlength="15" /><input type="hidden" name="SERI" id="SERI" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Uraian Barang</td>
                            <td>
                                <textarea class="mtext" name="INVBRG[URAIAN_BARANG]" id="URAIAN_BARANG" wajib="yes"><?= $DATA['URAIAN_BARANG'];?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Merk Barang</td>
                            <td><input type="text" name="INVBRG[MERK]" id="MERK" class="mtext" value="<?= $DATA['MERK']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Tipe Barang</td>
                            <td><input type="text" name="INVBRG[TIPE]" id="TIPE" class="mtext" value="<?= $DATA['TIPE']; ?>" /></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%">
                        <tr>
                            <td width="20%">Ukuran Barang</td>
                            <td width="80%"><input type="text" name="INVBRG[UKURAN]" id="UKURAN" class="mtext" value="<?= $DATA['UKURAN']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Spesifikasi Lain</td>
                            <td><input type="text" name="INVBRG[SPFLAIN]" id="SPFLAIN" class="mtext" value="<?= $DATA['SPFLAIN']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Jenis Barang</td>
                            <td><combo><?= form_dropdown('INVBRG[JNS_BARANG]', $JENIS_BRG, $DATA['JNS_BARANG'], 'id="tujuan" class="mtext" wajib="yes"'); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Satuan Terbesar</td>
                            <td><input type="text" name="INVBRG[KODE_SATUAN]" id="KODE_SATUAN" class="stext date ac_input" value="<?= $DATA['KODE_SATUAN']; ?>" wajib="yes" url="<?= site_url()?>/autocomplete/satuan" urai="ursatuan;" onfocus="Autocomp(this.id);ket_konversi();"/>
                            <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('satuan','KODE_SATUAN;ursatuan','Kode Satuan',this.form.id,650,400)" value="...">
                            &nbsp;<span id="ursatuan" class="uraian">
                            <?= $DATA['URAIAN_SATUAN']==''?$URAIAN_SATUAN:$DATA['URAIAN_SATUAN']; ?>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Satuan Terkecil</td>
                            <td><input type="text" name="INVBRG[KODE_SATUAN_TERKECIL]" id="KODE_SATUAN_TERKECIL" class="stext date ac_input" value="<?= $DATA['KODE_SATUAN_TERKECIL']; ?>" url="<?= site_url()?>/autocomplete/satuan" urai="ursatuanterkecil;" onfocus="Autocomp(this.id);ket_konversi();"/>
                            <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('satuan','KODE_SATUAN_TERKECIL;ursatuanterkecil','Kode Satuan',this.form.id,650,400)" value="...">
                            &nbsp;<span id="ursatuanterkecil" class="uraian">
                            <?= $DATA['URAIAN_SATUAN_TERKECIL']==''?$URAIAN_SATUAN_TERKECIL:$DATA['URAIAN_SATUAN_TERKECIL']; ?>
                            </span></td>
                        </tr>
                        <tr>
                            <td>Konversi Nilai Satuan</td>
                            <td><input type="text" name="INVBRG[JML_SATUAN_TERKECIL]" id="JML_SATUAN_TERKECIL" class="mtext" value="<?= $DATA['JML_SATUAN_TERKECIL']; ?>" onkeyup="ket_konversi()"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><span style="font-style:italic" id="ket"></span></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>
                <td colspan="2">
                    <table width="100%" border="0" id="tableGudang">
                        <tbody>
                            <tr>
                                <td colspan="10">
                                    <h5 class="header smaller lighter red"><b>Gudang dan Kondisi Barang</b></h5>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <? if($act=="save" || $DATA["DATADTL"] == ""){ ?>
                            <tr class="trGudang1">
                                <td>
                                    <table border="0" id="TblGdg">
                                        <tr>
                                            <td>Gudang <span class="Gno">1</span></td>
                                            <td>:</td>
                                            <td id="tdGudang1"><combo><?= form_dropdown('DATADTL[KODE_GUDANG][]',array_merge(array(""=>"-- Pilih --"),$KODE_GUDANG), $DATA['KODE_GUDANG'], 'id="KODE_GUDANG" class="text date ac_input"  wajib="yes" onChange="getRak(\'finventory\',1)" '.$disabled); ?></combo></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table border="0" id="TblKds">
                                        <tr>
                                            <td>Kondisi  <span class="Kno">1</span></td>
                                            <td>:</td>
                                            <td id="tdKondisi1"><combo><?= form_dropdown('DATADTL[KONDISI_BARANG][]',array('BAIK'=>'BAIK',"RUSAK"=>"RUSAK"), $DATA['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="stext" wajib="yes" '.$disabled); ?></combo></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table id="TblRak">
                                        <tr>
                                            <td>Rak <span class="Rno">1</span></td>
                                            <td>:</td>
                                            <td id="tdRak1"><combo><?= form_dropdown('DATADTL[KODE_RAK][]',array(''=>'-- Pilih --'), $DATA['KODE_RAK'], 'id="KODE_RAK" class="text date ac_input" onChange="getSubrak(\'finventory\',1)" '.$disabled); ?></combo></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table id="TblSRak">
                                        <tr>
                                            <td>Sub Rak <span class="SRno">1</span></td>
                                            <td>:</td>
                                            <td id="tdSubRak1"><combo><?= form_dropdown('DATADTL[KODE_SUB_RAK][]',array(''=>'-- Pilih --'), $DATA['KODE_SUB_RAK'], 'id="KODE_SUB_RAK" class="text date ac_input" '.$disabled); ?></combo></td>
                                            <td><a href="javascript:void(0)" onclick="addgudang('1')" style="margin-left:20px;color:#60C060;font-size:22px" title="Tambah" id="Tambah"><i class="fa fa-plus-circle"></i></a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <? 
                            }else{
                                echo $DATA["DATADTL"];
                            }
                            ?>
                        </tbody>
                    </table>
                </td>
            </tr>            
            <tr>
                <td colspan="10">
                    <h5 class="header smaller lighter red">&nbsp;</h5>
                </td>
            </tr>
        </table>
        <? if($act!="priview"){?>
        <a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="<?=$action;?>">
        <i class="fa fa-save"></i>&nbsp;<?= ucwords($act); ?>
       </a>&nbsp;<a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('finventory');"><i class="fa fa-undo"></i>&nbsp;Reset</a>&nbsp;<span class="msg_" style="margin-left:20px">&nbsp;</span>
        <? }?>
	</form>
</div>
	
<script>
FormReady();
<? if($act!="save"){?>ket_konversi();<? } ?>
	function ket_konversi(){
		var KODE_SATUAN = $("#KODE_SATUAN").val();
		var KODE_SATUAN_TERKECIL = $("#KODE_SATUAN_TERKECIL").val();
		var JML_SATUAN_TERKECIL = $("#JML_SATUAN_TERKECIL").val();
		if(KODE_SATUAN && KODE_SATUAN_TERKECIL && JML_SATUAN_TERKECIL){
		$("#ket").html('Ket: 1 '+KODE_SATUAN+" = "+JML_SATUAN_TERKECIL+" "+KODE_SATUAN_TERKECIL);
	}
}
function addgudang(id){
	var content="";
	var nilai = $("#tableGudang .child").size()+1;
	var Mathrandom = GetRandomMath();					
	content= "<tr class=\"trGudang"+id+" child\" id=\"tr_"+Mathrandom+"\"><td><table border=\"0\"><tr><td>Gudang <span class=\"Gno\">"+(nilai + 1)+"</span></td><td>:</td><td id=\"tdGudang"+Mathrandom+"\"></td></tr></table></td><td><table border=\"0\"><tr><td>Kondisi <span class=\"Kno\">"+(nilai + 1)+"</span></td><td>:</td><td id=\"tdKondisi"+Mathrandom+"\"></td></tr></table></td><td><table><tr><td>Rak <span class=\"Rno\">"+(nilai + 1)+"</span></td><td>:</td><td id=\"tdRak"+Mathrandom+"\"></td></tr></table></td><td><table><tr><td>Sub Rak <span class=\"SRno\">"+(nilai + 1)+"</span></td><td>:</td><td id=\"tdSubRak"+Mathrandom+"\"></td><td><a href=\"javascript:void(0)\" onclick=\"Removegudang('"+Mathrandom+"')\" title=\"Hapus\" style=\"margin-left:20px;color:#DF4B33;font-size:22px\"><i class=\"fa fa-minus-circle\"></i></a></td></tr></table></td></tr>";		 
	$("#tableGudang tbody:first").append(content);
	$("table#tableGudang td#tdGudang"+id).clone(true).removeAttr('id').appendTo('td#tdGudang'+Mathrandom+'');
    $("table#tableGudang td#tdKondisi"+id).clone(true).removeAttr('id').appendTo('td#tdKondisi'+Mathrandom+'');
    $("table#tableGudang td#tdRak"+id).clone(true).removeAttr('id').appendTo('td#tdRak'+Mathrandom+'');

    $("table#tableGudang td#tdSubRak"+id).clone(true).removeAttr('id').appendTo('td#tdSubRak'+Mathrandom+'');
	$('td#tdGudang'+Mathrandom+'').find(".JUMLAHHIDES").val('0');
	
    $("table#tableGudang td#tdGudang"+Mathrandom+" #KODE_GUDANG").removeAttr('onchange').attr('onchange',"getRak(\'finventory\',"+Mathrandom+")");
	$("table#tableGudang td#tdRak"+Mathrandom+" #KODE_RAK").removeAttr('onchange').attr('onchange',"getSubrak(\'finventory\',"+Mathrandom+")");
    $("table#tableGudang td#tdGudang"+Mathrandom+" #KODE_GUDANG").prepend($('<option>', { value : "" }).text("-- Pilih --")) .removeAttr('selected');
    $("table#tableGudang td#tdGudang"+Mathrandom+" #KODE_GUDANG").val('');
    $('table#tableGudang td#tdRak'+Mathrandom+' #KODE_RAK').empty();
	$("table#tableGudang td#tdRak"+Mathrandom+" #KODE_RAK").removeAttr('wajib').append($('<option>', { value : "" }).text("-- Pilih --"));
    $('table#tableGudang td#tdSubRak'+Mathrandom+' #KODE_SUB_RAK').empty();
    $("table#tableGudang td#tdSubRak"+Mathrandom+" #KODE_SUB_RAK").removeAttr('wajib').append($('<option>', { value : "" }).text("-- Pilih --"));
	
}
function Removegudang(id){ 
	var kdBrg = $("#finventory #KODE_BARANG").val();
	var jnsBrg = $("#finventory #HIDE_JNS_BARANG").val();
	var kdGudang = $("#tr_"+id+" #tdGudang"+id+" #KODE_GUDANG").val();
	var kondisiBrg = $("#tr_"+id+" #tdKondisi"+id+" #KONDISI_BARANG").val();
	$.ajax({
		type: 'post',
		url: site_url + '/inventory/getGudang',
		data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang: kdGudang, kondisi_barang: kondisiBrg},
		success: function(data) {
			if(data=="ok"){
				jAlert('Hapus Gudang Gagal. \n Kode Gudang dan Kondisi Barang tersebut sudah ada Mutasi.','PLB Inventory');
				return false;
			}else{
				$("#tableGudang tr[id=tr_"+id+"]").remove();	
				$(".Gno").each(function(index, element) {
					$(this).html(parseFloat(index)+1);
				});
				$(".Kno").each(function(index, element) {
					$(this).html(parseFloat(index)+1);
				});	
				$(".Rno").each(function(index, element) {
					$(this).html(parseFloat(index)+1);
				});	
				$(".SRno").each(function(index, element) {
					$(this).html(parseFloat(index)+1);
				});	
			}
		}
	});
}
</script> 
