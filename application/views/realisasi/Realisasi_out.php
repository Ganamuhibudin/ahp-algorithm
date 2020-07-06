<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
if ($act == "save") {
    $event = "tb_searchtwo('search/getsearch_two/realisasi_out','NOMOR_AJU;NOMOR_DAFTAR;TANGGAL_DAFTAR;KODE_DOKUMEN;PEMASOK;KODE_TRADER;JUMLAH;KODE_BARANG;JNS_BARANG;SERI_BARANG','PENGELUARAN',this.form.id,75,370)";
    $event2 = "tb_search('realisasi_out_withparsial','NOMOR_AJU;NOMOR_DAFTAR;TANGGAL_DAFTAR;KODE_DOKUMEN;PEMASOK;KODE_TRADER;JUMLAH;KODE_BARANG;JNS_BARANG;SERI_BARANG','PENGELUARAN',this.form.id,650,445)";
    $eventmasuk = "tb_search('dokumen_masuk','NOMOR_DAFTAR_MASUK;TANGGAL_DAFTAR_MASUK;KODE_DOKUMEN_MASUK','DOKUMEN PEMASUKAN',this.form.id,650,445)";
    if ($PARSIAL) {
        $event = $event2;
    } else {
        $event = $event;
    }
    $tbl = '<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="' . $event . '" value="...">';
    $tblmasuk = '<input type="button" name="cari" id="cari" class="button" onclick="' . $eventmasuk . '" value="...">';
    $readonly = "readonly=readonly";
	$display = ' style="display:none;"';
} else {
    $event = "";
    $readonly = "readonly=readonly";
    $disabled = "disabled=disabled";
	$display = '';
}
?>
<div class="header">
	<h3>
        <i class="fa fa-file-text"></i>&nbsp;<strong>Realisasi Pengeluaran</strong>
        <a href="javascript:void(0)" onclick="window.location.href = '<?= site_url() . "/realisasi/out" ?>'" style="float:right;" class="btn btn-success btn-sm" id="ok_">
        	<i class="icon-info"></i>&nbsp;Selesai&nbsp;
        </a>
  	</h3>
</div>
<div class="content">
    <form name="frealisasi_out" id="frealisasi_out" action="<?= site_url() . "/realisasi/proses_realisasi/out"; ?>" method="post" autocomplete="off">
        <input type="hidden" name="ajuEdit" id="ajuEdit" value="<?= $DATA['NOMOR_AJU']; ?>" />
        <input type="hidden" name="act" id="act" value="<?= $act; ?>" />
        <input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $DATA["STATUS_DOK"]; ?>" />
        <input type="hidden" name="KODE_TRADER" id="KODE_TRADER"/>
        <input type="hidden" name="KODE_BARANG" class="text" id="KODE_BARANG"/>
        <input type="hidden" name="JNS_BARANG" class="text" id="JNS_BARANG"/>
        <input type="hidden" name="JUMLAH_SATUAN" class="text" id="JUMLAH_SATUAN"/>
        <input type="hidden" name="SERI_BARANG" id="SERI_BARANG"/>
        <input type="hidden" name="PARSIAL" id="PARSIAL" value="<?= $PARSIAL; ?>" />
        <input type="hidden" name="BREAK" id="BREAK" value="<?= $BREAK; ?>" />
        <input type="hidden" id="duplikatNoAju" value="" />
        <input type="hidden" id="NOMOR_AJU_OLD" readonly />
		<input type="hidden" name="TOTALPARSIAL" id="TOTALPARSIAL"/>
        <span id="divtmp"></span>            
        <table width="100%" border="0">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" border="0">
                        <?php ($PARSIAL ? $notparsial = 'onfocus="getBarangOut()"' : $notparsial = 'onfocus="getBarangOut()"'); ?>
                        <tr>
                            <td width="30%">Nomor Aju</td>
                            <td width="70%"><input type="text" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $DATA['NOMOR_AJU']; ?>" onclick="<?= $event; ?>" <?= $notparsial ?>  class="text" wajib="yes" <?= $readonly; ?>/>&nbsp;<?= $tbl ?></td>
                        </tr>
                        <tr>
                            <td>Nomor Daftar</td>
                            <td><input type="text" name="NOMOR_DAFTAR" id="NOMOR_DAFTAR" value="<?= $DATA['NOMOR_PENDAFTARAN']; ?>" class="text" wajib="yes" <?= $readonly; ?>/></td>
                        </tr>
                        <tr>
                            <td class="top">Tanggal Daftar </td>
                            <td><input type="text" name="TANGGAL_DAFTAR" id="TANGGAL_DAFTAR" value="<?= $DATA['TANGGAL_PENDAFTARAN']; ?>" class="text" wajib="yes" <?= $readonly; ?>/></td>
                        </tr>
                        <tr>
                            <td class="top">Jenis Dokumen</td>
                            <td><input type="text" name="KODE_DOKUMEN" id="KODE_DOKUMEN" value="<?= $DATA['DOKUMEN']; ?>" class="text"  <?= $readonly; ?>/></td>
                        </tr>
                        <tr>
                            <td class="top">Pembeli / Penerima</td>
                            <td><input type="text" name="PEMASOK" id="PEMASOK" value="<?= $DATA['PENERIMA']; ?>" class="text"  <?= $readonly; ?>/></td>
                        </tr>
                        <tr>
                            <td class="top">Jumlah Detil Barang</td>
                            <td>
                                <input type="text" name="JUMLAH" id="JUMLAH" value="<?= $DATA['DETIL_BARANG']; ?>" class="stext date" wajib="yes" <?= $readonly; ?>/></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>              
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" border="0">
                        <tr>
                            <td width="28%">Nomor Bukti Pengeluaran </td>
                            <td width="72%"><input type="text"  name="HEADER[NOMOR_DOK_INTERNAL]" id="NOMOR_DOK_INTERNAL" class="text" value="<?= $DATA['NOMOR_DOK_INTERNAL']; ?>" wajib="yes"/>
                                &nbsp; 
                        </tr>
                        <tr>
                            <td>Tanggal Bukti Pengeluaran </td>
                            <td><input type="text"  name="HEADER[TANGGAL_DOK_INTERNAL]" id="TANGGAL_DOK_INTERNAL" class="stext date" value="<?= $DATA['TANGGAL_DOK_INTERNAL']; ?>" onfocus="ShowDP('TANGGAL_DOK_INTERNAL')" wajib="yes"/>
                                &nbsp;YYYY-MM-DD 
                        </tr>
                        <tr>
                            <td valign="top">Tanggal Realisasi</td>
                            <td>
                            	<input type="text" name="TANGGAL_REALISASI" id="TANGGAL_REALISASI" value="<?= $DATA['TANGGAL_REALISASI']; ?>" class="stext date" onfocus="ShowDP(this.id)" <?= $disabled ?>>
                                &nbsp;
                                <input type="text" name="WAKTU" id="WAKTU" value="<?= $DATA['WAKTU']; ?>" class="ssstext" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)" <?= $disabled ?>/>
                                &nbsp;&nbsp; YYYY-MM-DD HH:MI *<br>
                                *<i class="red">Tanggal saat ini, jika tidak diisi</i>
                          	</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <? if($PARSIAL){ ?>
        	<span id="span-msg" style="display:none; color:red;">* Note : Jika checkbox tidak di centang maka akan diangap sebagai realisasi biasa dan akan di realisasikan semuan jumlah barangnya.</span><br>
        <? } ?>
		<span id="msgfifo" style="display:none; color:red;">* Note : Jika tidak memilih <span class="blue"><b>Methode</b></span> pemilihan, maka realisasi akan dianggap <b>Fifo</b>.</span>
        <div id="data_barang" style="display:none; padding-top:1%;">
            <h5 class="header smaller lighter green"><strong>Data barang yang akan diproses : </strong></h5>
            <table id="tblBarang" class="tabelajax">
                <tr class="thead">
                    <th width="3%">No</th>
                    <th width="15%">Kode Barang</th>
                    <th width="10%">Jenis Barang</th>
                    <th width="5%">Satuan</th>
                    <th width="6%">Jml</th>
                    <th width="32%">Gudang Asal</th>
                    <th width="12%">Kondisi Barang</th>
                    <th>Kode Rak</th>
                    <th>Kode Sub Rak</th>
                    <th>Methode</th>
                    <?php if($BREAK){ ?>
                    <th width="6%">Break</th>
                    <?php }elseif($PARSIAL){ ?>
                    <th width="6%">Parsial</th>
                    <?php } ?>
                </tr>
                <tr class="additional"></tr>
            </table>
        </div>
        <br />
        <table width="100%" id="tr-button" <?=$display;?>>
            <tr>
                <td colspan="2">
                    <a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_realisasi('#frealisasi_out', 'msgrealisasi_');">
                        <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;
                    </a>&nbsp;
                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('frealisasi_out');">
                        <i class="icon-undo"></i>&nbsp;Reset&nbsp;
                    </a>
                    <span class="msgrealisasi_">&nbsp;</span>
                </td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
        </table>
    </form>
</div>
<script type="text/javascript">
	function getBarangOut(){
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
				url: site_url + '/realisasi/getBarangOut',
				data: {nomor_aju:nomor_aju, kode_dokumen: kode_dokumen, breakdown:breakdown, parsial:parsial},
				success: function(data) {
					Clearjloadings();
			  		var arr = data.split("#");
			  		if (arr[0] == "OK") {
						<?php if($PARSIAL){ ?>
						$("#span-msg").show(); 
						$("#tblBarang .selected-break").remove();
						<?php } ?>
						$("#msgfifo").show();
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
						$("#msgfifo").hide();
						$("#tr-button").hide();
						$("#data_barang").show();
						$("#tblBarang .parent").remove();
						$("#tblBarang .child").remove();
						$("#tblBarang").append(arr[1]);
			  		}
					var jum = 1;
					$("#frealisasi_out  input:checkbox").each(function(index, element) {
						if($(this).attr('checked')==true||$(this).attr('checked')=='checked'){
							jum = jum + index++ ;
						}
					});
					if(jum == 1) {
						$("#TOTALPARSIAL").val($('#JUMLAH').val());
					}
					else {
						var total = Number($('#JUMLAH').val() - jum);
						$("#TOTALPARSIAL").val(total);
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
			html += "<td id='method_"+no+"'>&nbsp;</td>";
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
			url: site_url + '/realisasi/getKondisiOut',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdgudang, id:id, no:no},
			success: function(data) {
				$("#tdkondisi_"+no+" combo").remove();
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
			url: site_url + '/realisasi/getRakOut',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, id:id, no:no},
			success: function(data) {
				$("#tdrak_"+no+" combo").remove();
				$("#tdrak_"+no).append(data);
			}
		});
	}
  
	function getSubRak(kdGudang,kondisi,rak,id,no){
		var kdBrg = $('input[name="BARANG['+id+'][KODE_BARANG]"]').val();
		var jnsBrg = $('input[name="BARANG['+id+'][JNS_BARANG]"]').val();
		$.ajax({
			type: 'post',
			url: site_url + '/realisasi/getSubRakOut',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, rak:rak, id:id, no:no},
			success: function(data) {
				$("#tdsubrak_"+no+" combo").remove();
				$("#tdsubrak_"+no).append(data);
			}
		});
	}
	
	function getDokIn(dok,aju,seri,kdBarang,jnsBarang,jumlah){
		jpopup(site_url+'/realisasi/getDokIn','Pilih Dokumen Pemasukan','id='+dok+'~'+aju+'~'+seri+'~'+kdBarang+'~'+jnsBarang+'~'+jumlah+'&act=getDataDokin',60, 480);
		//Dialog(site_url+'/realisasi/getDokIn/'+dok+'/'+aju+'/'+seri+'/'+kdBarang+'/'+jnsBarang+'/'+jumlah,'DivDokIn','Pilih Dokumen Pemasukan',750, 480);
	}
	
	function getBB(dok,aju,seri,kdBarang,jnsBarang,jumlah){
		jpopup(site_url+'/realisasi/getBB','Bahan Baku '+dok.toUpperCase(),'id='+dok+'~'+aju+'~'+seri+'~'+kdBarang+'~'+jnsBarang+'~'+jumlah+'&act=getBB',60, 480);
	}
	
	function breakdown_proses_out(id,controller,tipe){
		var jumlah = $("#JUMLAH_B"+id).val();
		var arr = $("#breakchk"+id).val().split("|");
		var DOK=arr[0]; var AJU=arr[1];var SERI=arr[2];
		jpopup(site_url+'/realisasi/getBreakOut','Proses Breakdown Detil Barang','id='+DOK+'~'+AJU+'~'+SERI+'~'+jumlah+'&act=getBreak',60, 480);
	}
	
	function showbuttonbreak(id){
		var values = parseInt($("#frealisasi_out #TOTALPARSIAL").val());
		var chk = $('#breakchk' + id).is(":checked");
		if (chk == true) {
			var x = values - 1;
			$("#frealisasi_out #TOTALPARSIAL").val(x);
			$("#frealisasi_out #breaktbl"+id).show();
			$("#frealisasi_out #btnAdd_"+id).hide();
			$("#frealisasi_out #jumlah_"+id).attr('disabled', true).removeAttr('wajib').val("");
			$("#frealisasi_out #gudang_"+id).attr('disabled', true);
			$("#frealisasi_out #kondisi_"+id).attr('disabled', true);
			$("#frealisasi_out #gudang_"+id).removeAttr('wajib');
            $("#frealisasi_out #kondisi_"+id).removeAttr('wajib');
			$("#frealisasi_out #rak_"+id).attr('disabled', true);
			$("#frealisasi_out #subrak_"+id).attr('disabled', true);
			$("#frealisasi_out tr[parent-id='"+id+"']").remove();
			$("#frealisasi_out #ur_jumlah_"+id).remove();
			$("#frealisasi_out #jumlah_"+id).remove();
			$("#frealisasi_out #tr_"+id).removeAttr("class").attr('class','selected-break');
			$("#frealisasi_out #tdmethode_"+id+" #m_dok_"+id).attr('disabled', true);
			$("#frealisasi_out #tdmethode_"+id+" #m_bb_"+id).attr('disabled', true);
		} else {
			var x = values + 1;
			$("#frealisasi_out #TOTALPARSIAL").val(x);
			$("#frealisasi_out #breaktbl"+id).hide();
			$("#frealisasi_out #btnAdd_"+id).show();
			$("#frealisasi_out #gudang_"+id).removeAttr('disabled', false);
			$("#frealisasi_out #kondisi_"+id).removeAttr('disabled', false);
			$("#frealisasi_out #gudang_"+id).attr('wajib', 'yes');
            $("#frealisasi_out #kondisi_"+id).attr('wajib', 'yes');
			$("#frealisasi_out #rak_"+id).attr('disabled', false);
			$("#frealisasi_out #subrak_"+id).attr('disabled', false);
			$("#frealisasi_out #tr_"+id).removeAttr("class").attr('class','parent');
			$("#frealisasi_out #tdmethode_"+id+" #m_dok_"+id).attr('disabled', false);
			$("#frealisasi_out #tdmethode_"+id+" #m_bb_"+id).attr('disabled', false);
		}
	}
</script>