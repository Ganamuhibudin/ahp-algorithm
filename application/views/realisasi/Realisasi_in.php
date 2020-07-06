<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="save"){
	$event="tb_search('realisasi_in','NOMOR_DAFTAR;TANGGAL_DAFTAR;KODE_DOKUMEN;PEMASOK;KODE_TRADER;JUMLAH;NOMOR_AJU;KODE_BARANG;JNS_BARANG;SERI_BARANG','PEMASUKAN',this.form.id,650,445)";
	$event2="tb_search('realisasi_in_withparsial','NOMOR_DAFTAR;TANGGAL_DAFTAR;KODE_DOKUMEN;PEMASOK;KODE_TRADER;JUMLAH;NOMOR_AJU;KODE_BARANG;JNS_BARANG;SERI_BARANG','PEMASUKAN',this.form.id,650,445)";
	if($PARSIAL){
		$event = $event2;	
	}else{
		$event = $event;	
	}
	$tbl='<input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" onclick="'.$event.'" value="...">';	
	$readonly="readonly=readonly";
  	$ajuOld = '<input type="hidden" name="NOMOR_AJU_OLD" class="text" id="NOMOR_AJU_OLD"/>';
	$onfocus = 'getBarang()';
}else{
	$event="";
	$readonly="readonly=readonly";
	$disabled="disabled=disabled";
 	$ajuOld = '';
	$onfocus = '';
}
?>

<div class="header">
	<h3><i class="fa fa-file-text"></i>&nbsp;<strong>Realisasi Pemasukan</strong></h3>
</div>
<div class="content">
	<form name="frealisasi_in" id="frealisasi_in" action="<?= site_url()."/realisasi/proses_realisasi/in" ?>" method="post" autocomplete="off">
        <input type="hidden" name="ajuEdit" id="ajuEdit" value="<?= $DATA['NOMOR_AJU'];?>" />
        <input type="hidden" name="act" id="act" value="<?= $act;?>" />
        <input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $DATA["STATUS_DOK"];?>" />
        <input type="hidden" name="SERI" id="SERI" value="<?= $sessIN["SERI"];?>" />
        <input type="hidden" name="KODE_TRADER" id="KODE_TRADER"/>
        <input type="hidden" name="NOMOR_AJU" class="text" id="NOMOR_AJU"/>
        <input type="hidden" name="KODE_BARANG" class="text" id="KODE_BARANG"/>
        <input type="hidden" name="JNS_BARANG" class="text" id="JNS_BARANG"/>
        <input type="hidden" name="SERI_BARANG" id="SERI_BARANG"/>
        <input type="hidden" name="PARSIAL" id="PARSIAL" value="<?=$PARSIAL;?>" />
        <input type="hidden" name="BREAK" id="BREAK" value="<?=$BREAK;?>" />
        <?=$ajuOld?>
        <span id="divtmp"></span>
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                    <h5 class="smaller lighter green"><strong>Pilih Dokumen Pemasukan :</strong></h5>
                    <table width="100%" border="0">
                        <tr>
                            <td width="30%">Nomor Daftar </td>
                            <td width="70%">
                                <input type="text" name="NOMOR_DAFTAR" readonly id="NOMOR_DAFTAR" value="<?= $DATA['NOMOR_PENDAFTARAN']; ?>" onclick="<?= $event;?>"  class="text" wajib="yes" <?= $readonly;?> onFocus="<?=$onfocus?>"/>
                                &nbsp;<?=$tbl?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Tanggal Daftar </td>
                            <td><input type="text" name="TANGGAL_DAFTAR" readonly id="TANGGAL_DAFTAR" value="<?= $DATA['TANGGAL_PENDAFTARAN']; ?>" class="text date"  wajib="yes" <?= $readonly;?>/></td>
                        </tr>
                        <tr>
                            <td valign="top">Jenis Dokumen</td>
                            <td><input type="text" name="KODE_DOKUMEN" readonly id="KODE_DOKUMEN" value="<?= $DATA['DOKUMEN']; ?>" class="text"  <?= $readonly;?>/></td>
                        </tr>
                        <tr>
                            <td valign="top">Pemasok / Pengirim</td>
                            <td><textarea name="PEMASOK" id="PEMASOK" readonly class="text"  <?= $readonly;?> ><?= $DATA['PEMASOK/PENGIRIM']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="top">Jumlah Detil Barang</td>
                            <td><input type="text" name="JUMLAH" readonly id="JUMLAH" value="<?= $DATA['DETIL_BARANG']; ?>" class="stext date" wajib="yes" <?= $readonly;?>/></td>
                        </tr>
                	</table>
				</td>
                <td valign="top" width="50%">
                	<h5 class="smaller lighter green"><strong>Bukti Penerimaan :</strong></h5>
                    <table width="100%" border="0">
                        <tr>
                            <td width="30%">Nomor Bukti Penerimaan </td>
                            <td width="70%"><input type="text"  name="HEADER[NOMOR_DOK_INTERNAL]" id="NOMOR_DOK_INTERNAL" class="text" value="<?= $DATA['NOMOR_DOK_INTERNAL']; ?>" wajib="yes"/>
                            &nbsp;</td>
                        </tr>
                        <tr>
                            <td>Tanggal Bukti Penerimaan </td>
                            <td><input type="text"  name="HEADER[TANGGAL_DOK_INTERNAL]" id="TANGGAL_DOK_INTERNAL" class="stext date" value="<?= $DATA['TANGGAL_DOK_INTERNAL']; ?>" onfocus="ShowDP('TANGGAL_DOK_INTERNAL')" wajib="yes"/>
                            &nbsp;YYYY-MM-DD</td>
                        </tr>
                        <tr>
                            <td valign="top">Tanggal Realisasi</td>
                            <td><input type="text" name="TANGGAL_REALISASI" id="TANGGAL_REALISASI" value="<?= $DATA['TANGGAL_REALISASI']; ?>" class="stext date" onfocus="ShowDP(this.id)" <?=$disabled?>>
                            &nbsp;
                            <input type="text" name="WAKTU" id="WAKTU" value="<?= $DATA['WAKTU']; ?>" class="ssstext" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)" <?=$disabled?>/>
                            &nbsp;&nbsp; YYYY-MM-DD HH:MI *<br>
                            *<i class="red">Tanggal saat ini, jika tidak diisi</i></td>
                        </tr>
                    </table>
                </td>
			</tr>
		</table>
		<? if($PARSIAL){ ?>
        	<span id="span-msg" style="display:none; color:red;">* Note : Jika checkbox tidak di centang maka akan diangap sebagai realisasi biasa dan akan di realisasikan semuan jumlah barangnya.</span>
        <? } ?>

        <div id="data_barang" style="display:none; padding-top:1%;">
            <h5 class="header smaller lighter green"><strong>Data barang yang akan diproses : </strong></h5>
            <table id="tblBarang" class="tabelajax">
                <tr class="thead">
                    <th width="3%">No</th>
                    <th width="15%">Kode Barang</th>
                    <th width="10%">Jenis Barang</th>
                    <th width="6%">Satuan</th>
                    <th width="10%">Jumlah</th>
                    <th width="30%">Gudang Tujuan</th>
                    <th width="12%">Kondisi Barang</th>
                    <th>Kode Rak</th>
                    <th>Kode Sub Rak</th>
                    <?php if($BREAK){ ?>
                    <th width="6%">Break</th>
                    <?php }elseif($PARSIAL){ ?>
                    <th width="6%">Parsial</th>
                    <?php } ?>
                </tr>
                <tr class="additional"></tr>
            </table>
        </div>
        <table style="margin-top:2%;" width="100%">
        	<?php if($act=="save"){ ?>
            <tr id="tr-button" style="display:none">
                <td colspan="2">
                    <a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_realisasi('#frealisasi_in','msgrealisasi_');">
                        <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>
                    </a>
                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('frealisasi_in');">
                        <i class="icon-undo"></i>&nbsp;Reset
                    </a>&nbsp;<span class="msgrealisasi_" >&nbsp;</span>
                </td>
            </tr>
            <?php }else{ ?>
            <tr>
            	<td width="15%">&nbsp;</td>
                <td width="85">
                    <a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_realisasi('#frealisasi_in','msgrealisasi_');">
                        <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>
                    </a>
                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('frealisasi_in');">
                        <i class="icon-undo"></i>&nbsp;Reset
                    </a>&nbsp;<span class="msgrealisasi_" >&nbsp;</span>
                </td>
            </tr>
            <?php } ?>
        </table>
	</form>
</div>
<?php if($act=="save"){?>
	<script>
    	function getBarang() {
        	var nomor_aju = $("#NOMOR_AJU").val();
			var nomor_aju_old = $("#NOMOR_AJU_OLD").val();
			var parsial = $("#PARSIAL").val();
			var breakdown = $("#BREAK").val();
			var kode_dokumen = $("#KODE_DOKUMEN").val().toLowerCase();
        	if (nomor_aju != "" && nomor_aju != nomor_aju_old) {
          		$("#NOMOR_AJU_OLD").val(nomor_aju);
          		jloadings();
          		$.ajax({
            		type: 'post',
					url: site_url + '/realisasi/getBarangIn',
					data: {nomor_aju:nomor_aju, kode_dokumen: kode_dokumen, breakdown:breakdown, parsial:parsial},
					success: function(data) {
						Clearjloadings();
					  	var arr = data.split("#");
					  	if (arr[0] == "OK") {
							<?php if($PARSIAL){ ?>
							$("#span-msg").show(); 
							$("#tblBarang .selected-break").remove();
							<?php } ?>
							$("#tr-button").show();
							$("#data_barang").show();
							$("#tblBarang .parent").remove();
							$("#tblBarang .child").remove();
							$("#tblBarang").append(arr[1]);
					  	} else {
							<?php if($PARSIAL){ ?>
							$("#span-msg").hide();
							$("#tblBarang .selected-break").remove();
							<?php } ?>
							$("#tr-button").hide();
							$("#data_barang").show();
							$("#tblBarang .parent").remove();
							$("#tblBarang .child").remove();
							$("#tblBarang").append(arr[1]);
					  	}
            		}
          		});
        	}
      	}
      
      	function addGudang(id) {
			var breakdown = $("#BREAK").val();
			var parsial = $("#PARSIAL").val();
			var kondisi = $("#tr_"+id+" #kondisi_"+id+" option").size();
			var kuota = $("#tr_"+id+" #gudang_"+id+" option").size();
			var item = $('select[name="gudang['+id+'][]"]').length;
			if (item < (kuota * 2)) {
				var no = GetRandomMath();
				var html = "<tr id='tr_"+no+"' parent-id='"+id+"' class='child'>";
				html += "<td colspan='5'>&nbsp;</td>";
				html += "<td id='tdtujuan_"+no+"'>&nbsp;</td>";
				html += "<td id='tdkondisi_"+no+"'>&nbsp;</td>";
				html += "<td id='tdrak_"+no+"'>&nbsp;</td>";
				html += "<td id='tdsubrak_"+no+"'>&nbsp;</td>";
				html += "</tr>";
				$("#tr_"+id).after(html);
				var xTujuan = $("#tdtujuan_"+id).html();
				var xKondisi = $("#tdkondisi_"+id).html();
				var xRak = $("#tdrak_"+id).html();
				var xSubRak = $("#tdsubrak_"+id).html();
				xTujuan = xTujuan.replace("gudang_"+id, "gudang_"+no);
				xKondisi = xKondisi.replace("kondisi_"+id, "kondisi_"+no);
				xRak = xRak.replace("rak_"+id, "rak_"+no);
				xRak = xRak.replace("subrak_"+id, "subrak_"+no);
				if(item==1){
					$('#tdtujuan_'+id+' #gudang_'+id).before('<input type="text" wajib="yes" id="ur_jumlah_'+id+'" class="stext date" style="height:26px; text-align:right;" onkeyup="this.value = ThausandSeperator(\'jumlah_'+id+'\',this.value,2);" /><input id="jumlah_'+id+'" type="hidden" value="0" name="jumlah['+id+'][]" >&nbsp;');
				}
				$("#tdtujuan_"+no).html(xTujuan);
				$("#tdkondisi_"+no).html(xKondisi);
				$("#tdrak_"+no).html(xRak);
				$("#tdsubrak_"+no).html(xSubRak);
				$("#tr_"+no+" #ur_jumlah_"+id).removeAttr('id').attr('id','ur_jumlah_'+no).removeAttr('onkeyup').attr('onKeyUp',"this.value = ThausandSeperator('jumlah_"+no+"',this.value,2);");
				$("#tr_"+no+" #jumlah_"+id).removeAttr('id').attr('id','jumlah_'+no);
				$("#tr_"+no+" #btnAdd_"+id).removeAttr('onclick').attr('onClick','delGudang('+no+','+id+')');
				$("#tr_"+no+" i").removeAttr('class').attr('class','fa fa-minus-circle red').removeAttr('title').attr('title','Hapus Gudang');
				$("#tr_"+no+" #gudang_"+no).removeAttr('onChange').attr('onChange', 'getKondisi(this.value,'+id+','+no+')');
				if(item==1){
					$('#tdtujuan_'+no+' #gudang_'+no).before('<input type="text" wajib="yes" id="ur_jumlah_'+no+'" class="stext date" style="height:26px; text-align:right;" onkeyup="this.value = ThausandSeperator(\'jumlah_'+no+'\',this.value,2);" /><input id="jumlah_'+no+'" type="hidden" value="0" name="jumlah['+id+'][]" >&nbsp;');
				}
			}
      	}
      
		function delGudang(id,no) {
			var item = $('select[name="gudang['+no+'][]"]').length;
			if(item==2){
				$("#ur_jumlah_"+no).remove();
				$("#jumlah_"+no).remove();
			}
			$("#tr_"+id).remove();
		}
      
      	function getKondisi(kdgudang,id,no){
        	var kdBrg = $('input[name="BARANG['+id+'][KODE_BARANG]"]').val();
         	var jnsBrg = $('input[name="BARANG['+id+'][JNS_BARANG]"]').val();
          	$.ajax({
				type: 'post',
				url: site_url + '/realisasi/getKondisiIn',
				data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdgudang, id:id, no:no},
				success: function(data) {
					$("#tdkondisi_"+no+" combo").remove();
					$("#tdkondisi_"+no+" #kondisi_"+no).remove();
					$("#tdkondisi_"+no).append(data);
					$("#tdrak_"+no+" combo").html('<select name="rak['+no+'][]" id="rak_'+no+'" class="stext"><option value="">--Pilih--</option></select>');
					$("#tdsubrak_"+no+" combo").html('<select name="subrak['+no+'][]" id="subrak_'+no+'" class="stext"><option value="">--Pilih--</option></select>');
				}
	      	});
      	}
      
      	function getRak(kdGudang,kondisi,id,no){
          	var kdBrg = $('input[name="BARANG['+id+'][KODE_BARANG]"]').val();
          	var jnsBrg = $('input[name="BARANG['+id+'][JNS_BARANG]"]').val();
          	$.ajax({
				type: 'post',
				url: site_url + '/realisasi/getRakIn',
				data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, id:id, no:no},
				success: function(data) {
					$("#tdrak_"+no+" combo").remove();
					$("#tdrak_"+no+" #rak_"+no).remove();
					$("#tdrak_"+no).append(data);
				}
          	});
      	}
      
      	function getSubRak(kdGudang,kondisi,rak,id,no){
          	var kdBrg = $('input[name="BARANG['+id+'][KODE_BARANG]"]').val();
          	var jnsBrg = $('input[name="BARANG['+id+'][JNS_BARANG]"]').val();
          	$.ajax({
				type: 'post',
				url: site_url + '/realisasi/getSubRakIn',
				data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, rak:rak, id:id, no:no},
				success: function(data) {
					$("#tdsubrak_"+no+" combo").remove();
					$("#tdsubrak_"+no+" #subrak_"+no).remove();
					$("#tdsubrak_"+no).append(data);
				}
          	});
      	}
      
      	function showbuttonbreak(id){
        	var chk = $('#breakchk' + id).is(":checked");
			if (chk == true) {
				$("#frealisasi_in #breaktbl"+id).show();
				$("#frealisasi_in #btnAdd_"+id).hide();
				$("#frealisasi_in #jumlah_"+id).attr('disabled', true).removeAttr('wajib').val("");
				$("#frealisasi_in #gudang_"+id).attr('disabled', true);
				$("#frealisasi_in #kondisi_"+id).attr('disabled', true);
                $("#frealisasi_in #gudang_"+id).removeAttr('wajib');
                $("#frealisasi_in #kondisi_"+id).removeAttr('wajib');
				$("#frealisasi_in #rak_"+id).attr('disabled', true);
				$("#frealisasi_in #subrak_"+id).attr('disabled', true);
				$("#frealisasi_in tr[parent-id='"+id+"']").remove();
				$("#frealisasi_in #ur_jumlah_"+id).remove();
				$("#frealisasi_in #jumlah_"+id).remove();
				$("#frealisasi_in #tr_"+id).removeAttr("class").attr('class','selected-break');
			} else {
				$("#frealisasi_in #breaktbl"+id).hide();
				$("#frealisasi_in #btnAdd_"+id).show();
				$("#frealisasi_in #gudang_"+id).removeAttr('disabled', false);
				$("#frealisasi_in #kondisi_"+id).removeAttr('disabled', false);
                $("#frealisasi_in #gudang_"+id).attr('wajib', 'yes');
                $("#frealisasi_in #kondisi_"+id).attr('wajib', 'yes');
				$("#frealisasi_in #rak_"+id).attr('disabled', false);
				$("#frealisasi_in #subrak_"+id).attr('disabled', false);
				$("#frealisasi_in #tr_"+id).removeAttr("class").attr('class','parent');
			}
      	}
      	FormReady();
    </script>
<?php } ?>
