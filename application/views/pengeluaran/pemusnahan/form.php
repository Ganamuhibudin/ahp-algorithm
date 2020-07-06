<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="save"){
	$disable ="";
	$readonly="";
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;KODE_SATUAN;ursatuan','BARANG',this.form.id,650,445)";
	$addUrl="add/pemusnahan";
	$action="save_detil('#fpemusnahan','msg_')";
	$tbl='<input type="button" name="cari" id="cari" class="btn btn-primary btn-sm" onclick="'.$event.'" value="...">';
}else{
	$disable ="readonly=readonly";
	$readonly="readonly=readonly";
	$addUrl="editPengrusakan/pemusnahan";
	$action="save_post('#fpemusnahan')";
	$tbl='';
}
?>	
<a href="javascript:void(0)" 
onclick="window.location.href='<?= site_url()."/pengeluaran/pemusnahan/draftPemusnahan"?>'" style="float:right;margin:5px 0px 0px 0px" class="btn btn-success btn-sm prev" id="ok_"><span><i class="icon-arrow-left"></i>&nbsp;Selesai&nbsp;</span></a>
<div class="header">
	<h3><i class="fa fa-file-text"></i>&nbsp;<strong><?= $judul;?></strong></h3>
</div>
<div class="content">
	<form name="fpemusnahan" id="fpemusnahan" action="<?= site_url()."/pengeluaran/".$addUrl; ?>" method="post" autocomplete="off">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="idData" id="idData" value="<?= $sess['ID'];?>" /><input type="hidden" name="jumlah" id="jumlah" value="<?= $sess['JUMLAH'];?>" />
		<span id="divtmp"></span>
			<table width="100%" border="0">
				<tr>
					<td width="40%" valign="top">	
						<table width="100%" border="0">
							<tr>
								<td width="32%">Tanggal Pemusnahan </td>
								<td width="68%">
								<input type="text" name="RUSAK[TANGGAL_PEMUSNAHAN]" id="tanggal" value="<?= $sess['TANGGAL_PEMUSNAHAN']?>" onfocus="ShowDP('tanggal')" class="stext date">&nbsp; YYYY-MM-DD</td>
							</tr>
							<tr>
								<td>Kode Barang </td>
								<td>        
								<input type="text" name="RUSAK[KODE_BARANG]" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text"  wajib="yes" onfocus="getGudangPemusnahan()" urai="URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;KODE_SATUAN;ursatuan;"  <?=$disable;?> <?= $event;?> />&nbsp;<?=$tbl?></td>
							</tr>
							 <tr>
								<td>Uraian Barang </td>
								<td>
								<textarea class="text" name="RUSAK1[URAIAN_BARANG]" id="URAIAN_BARANG" readonly><?= $sess['URAIAN_BARANG'];?></textarea></td>
							</tr>   
							<tr>
								<td>Jenis Barang </td>
								<td>
								<input type="hidden" name="RUSAK[JNS_BARANG]" id="JNS_BARANG" class="stext date" value="<?= $sess['JNS_BARANG']; ?>" />
								<input type="text" name="JENIS_BARANG" id="JENIS_BARANG" class="text" value="<?= $sess['JENIS_BARANG']; ?>" readonly />
								</td>
							</tr> 
							<tr>
								<td width="20%">Jumlah </td>
								<td width="80%">
								<input type="text" name="JUMLAH" id="JUMLAH" onkeyup="this.value = ThausandSeperator('JML',this.value,4);" class="text" value="<?= $sess['JUMLAH']; ?>" wajib="yes" format="angka"/> <input type="hidden" name="RUSAK[JUMLAH]" id="JML" value="<?= $sess['JUMLAH']?>" /></td>
							</tr>
							 <tr>
								<td>Jenis Satuan </td>
								<td>
								<input type="text" name="RUSAK[KODE_SATUAN]" id="KODE_SATUAN" class="stext date" value="<?= $sess['KODE_SATUAN']; ?>" wajib="yes" url="<?= site_url()?>/autocomplete/satuan" urai="ursatuan;" readonly />
								&nbsp;<span id="ursatuan"><?= $sess['URAIAN_SATUAN']==''?$URAIAN_SATUAN:$sess['URAIAN_SATUAN']; ?></span></td>
							</tr>  
						</table>
					</td>
					<td width="60%" valign="top">
						<table width="100%" border="0">
							<tr>
								<td valign="top">Keterangan </td>
								<td>
								<textarea class="text" name="RUSAK[KETERANGAN]" id="KETERANGAN" wajib="yes"><?= $sess['KETERANGAN'];?></textarea></td>
							</tr>
							<tr>
								<td>Gudang </td>
								<td id="td-gudang-bb"><combo id="gud"><?= form_dropdown('RUSAK[KODE_GUDANG]',array_merge(array(""=>"-- Pilih --"),$KODE_GUDANG), $sess['KODE_GUDANG'], 'id="KODE_GUDANG" class="text" wajib="yes" onClick="getKondisiPemusnahan(this.value)" '.$disabled); ?></combo>
								</td>
							</tr>  
							<tr>
								<td>Kondisi </td>
								<td id="td-kondisi-bb">
								 <combo id="kon"><?= form_dropdown('RUSAK[KONDISI_BARANG]',array_merge(array(""=>"-- Pilih --"),$KONDISI_BARANG), $sess['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="text" wajib="yes" onClick="getRakPemusnahan(this.value)"'.$disabled); ?></combo>
								</td>
							</tr>       
							<tr>
								<td>Rak </td>
								<td id="td-rak-bb">
								<combo id="rak"><?= form_dropdown('RUSAK[KODE_RAK]',array_merge(array(""=>"-- Pilih --"),$KODE_RAK), $sess['KODE_RAK'], 'id="KODE_RAK" class="text" onChange="getSubRakPemusnahan()"'.$disabled); ?></combo>
								</td>
							</tr>
							<tr>
								<td>Sub Rak </td>
								<td id="td-subrak-bb">
								<combo id="subrak"><?= form_dropdown('RUSAK[KODE_SUB_RAK]',array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), $sess['KODE_SUB_RAK'], 'id="KODE_SUB_RAK" class="text"'.$disabled); ?></combo>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tr>
			<? if($act!="priview"){?>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="2">
				<a href="javascript:void(0);" class="btn btn-success btn save" id="ok_" onclick="<?=$action?>"><span><i class="fa fa-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning btn-l cancel" id="cancel_" onclick="cancel('fpemusnahan');"><span><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msg_" style="margin-left:20px">&nbsp;</span>
				</td>
			</tr>
			<? }?>
		</table>
	</form>
</div>
<script>
$(function(){FormReady();})

function getGudangPemusnahan(){
	//alert('test');
   	var kdBrg = $("#KODE_BARANG").val();
    var jnsBrg = $("#JNS_BARANG").val();
    
	$("#KODE_GUDANG").empty();
	$("#KODE_RAK").empty();
	$("#KODE_SUB_RAK").empty();
    if (kdBrg != "") {
        $.ajax({
            type: 'post',
            url: site_url + '/pengeluaran/getGudangPemusnahan',
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
function getKondisiPemusnahan(val){
	var kdBrg = $("#KODE_BARANG").val();
	var jnsBrg = $("#JNS_BARANG").val();
	var kdGudang = val;	
	if(kdGudang!=""){
		$.ajax({
			type: 'post',
			url: site_url + '/pengeluaran/getKondisiPemusnahan',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang},
			success: function(data){
				var arrdata = data.split("#");
				$("#td-kondisi-bb #kon #KONDISI_BARANG").remove();
				$("#td-kondisi-bb #kon").append(arrdata[0]);
				$("#td-rak-bb #rak #KODE_RAK").remove();
				$("#td-rak-bb #rak").html('<select name="RUSAK[KODE_RAK]" id="KODE_RAK" class="text"><option value="">-- Pilih --</option></select>');
                $("#td-subrak-bb #rak #KODE_SUB_RAK").remove();
				$("#td-subrak-bb #subrak").html('<select name="RUSAK[KODE_SUB_RAK]" id="KODE_SUB_RAK" class="text"><option value="">-- Pilih --</option></select>');
			}
		});
	}
}
function getRakPemusnahan(val){
	var kdBrg = $("#KODE_BARANG").val();
	var jnsBrg = $("#JNS_BARANG").val();
	var kdGudang = $("#KODE_GUDANG").val();	
	if(kdGudang!=""){
		$.ajax({
			type: 'post',
			url: site_url + '/pengeluaran/getRakPemusnahan',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi_barang:val},
			success: function(data){
				var arrdata = data.split("#");
				$("#td-rak-bb #rak #KODE_RAK").remove();
				$("#td-rak-bb #rak").append(arrdata[0]);
			}
		});
	}
}
function getSubRakPemusnahan(){
	//alert('apa');
	var kdBrg = $("#KODE_BARANG").val();
	var jnsBrg = $("#JNS_BARANG").val();
	var kdGudang = $("#KODE_GUDANG").val();	
	var kdRak	 = $("#KODE_RAK").val();
	if(kdRak!=""){
		$.ajax({
			type: 'post',
			url: site_url + '/pengeluaran/getSubRakPemusnahan',
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
