<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if(strtolower($ACT)=="save"){
	$event = "tb_search('barang_popup','KODE_BARANG_BREAK;URAIAN_BARANG;JNS_BARANG_BREAK;JENIS_BARANG;KODE_SATUAN;uraisatdet','Kode  Barang',this.form.id,600,400)";
	$btn = '<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="'.$event.'" value="...">';				  
}
$readonly="readonly=readonly";	
?>
<div class="content_luar">
	<div class="content_dalam">
		<form name="fBreakdownOut" id="fBreakdownOut" action="<?= site_url()."/realisasi/breakdownout_prosesForm" ?>" method="post" autocomplete="off">
            <input type="hidden" name="act" id="act" value="<?= $ACT;?>" readonly />
            <input type="hidden" name="DATA[NOMOR_AJU]" id="NOMOR_AJU" value="<?= $AJU;?>" readonly />
            <input type="hidden" name="DATA[SERI]" id="SERI" value="<?= $SERI;?>" readonly />
            <input type="hidden" name="DATA[JNS_BARANG]" id="JNS_BARANG_BREAK" value="<?= $sess['JNS_BARANG'];?>" />
            <input type="hidden" name="JMLHEAD" id="JMLHEAD" value="<?= $JMLHEAD;?>" readonly />
            <input type="hidden" name="JMLDTL" id="JMLDTL" value="<?= $JMLDTL;?>" readonly />
            <input type="hidden" name="KDBARANG_EDIT" id="KDBARANG_EDIT" value="<?= $KDBARANG_EDIT;?>" readonly />
            <input type="hidden" name="HARGA" id="HARGA" value="<?= $CIF;?>" readonly />
            <input type="hidden" name="HARGA_HEAD" id="HARGA_HEAD" value="<?= $CIF_HEAD;?>" readonly />
            <input type="hidden" name="JNSBARANG_EDIT" id="JNSBARANG_EDIT" value="<?= $JNSBARANG_EDIT;?>" readonly />
            <input type="hidden" name="DOKUMEN" id="DOKUMEN" value="<?= $DOKUMEN;?>" readonly />
            <input type="hidden" name="KODE_BARANG_BREAK_OLD" id="KODE_BARANG_BREAK_OLD" value="<?= $KDBARANG_EDIT; ?>" readonly />
			<span id="divtmp"></span>
            <table width="100%" border="0">
            	<tr>
            		<td width="45%" valign="top">
            			<h5 class="smaller lighter green"><strong>Data Barang</strong></h5>
                        <table width="100%" border="0">
                       		<tr>
                                <td width="263">Kode Barang </td>
                                <td width="820">
                                	<input type="text" name="DATA[KODE_BARANG]" id="KODE_BARANG_BREAK" <?= $readonly;?> onclick="<?= $event;?>" class="mtext" value="<?= $sess['KODE_BARANG']; ?>" wajib="yes" onFocus="getGudang('#fBreakdownOut');"/>&nbsp;<?=$btn?>
                                </td>
                            </tr> 
                            <tr>
                                <td width="263">Uraian Barang </td>
                                <td width="820"><textarea name="URAIAN_BARANG" id="URAIAN_BARANG" wajib="yes" <?= $readonly;?> class="mtext"><?= $sess['URAIAN']; ?></textarea></td>
                          	</tr>
                            <tr>
                                <td width="263">Jenis Barang</td>
                                <td width="820">
                                	<input type="text" name="JENIS_BARANG" id="JENIS_BARANG" <?= $readonly;?> class="mtext" value="<?= $sess['JENIS BARANG']; ?>" wajib="yes"/>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td width="263">Harga Satuan</td>
                                <td width="820">
                                	<input type="text" id="UR_HARGA_SATUAN"  class="stext" value="<?= $sess['HARGA_SATUAN']; ?>" onkeyup="this.value = ThausandSeperator('HARGA_SATUAN',this.value,4);" wajib="yes" format="angka"/>
                                    <input type="hidden" readonly name="DATA[HARGA_SATUAN]" id="HARGA_SATUAN" />
                                </td>
                            </tr>  -->
                            <tr>
                                <td width="263">Satuan</td>
                                <td width="820"><input type="text" name="DATA[KODE_SATUAN]" id="KODE_SATUAN"  class="ssstext" value="<?= $sess['KODE_SATUAN']; ?>" wajib="yes" <?= $readonly;?> />&nbsp;
                                	<span id="uraisatdet"><?= $sess['URAIAN SATUAN']; ?></span>
                                </td>
                            </tr>
                        </table>
            		</td>
            	</tr>
            	<tr>
            		<td colspan="2">&nbsp;</td>
            	</tr>
                <? if($ACT == "save"){ ?>
                <tr id="table-data">
                	<td colspan="2" id="data-gudang" style="display:none;">
                		<h5 class="smaller lighter green"><strong>Data Gudang</strong></h5>
                    	<table class="tabelajax" id="tbl-break">
                        	<tbody>
                            	<tr class="thead">
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Gudang Tujuan</th>
                                    <th width="7%">Kondisi Barang</th>
                                    <th>Rak</th>
                                    <th>Sub Rak</th>
                                    <th>Action</th>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
            		<td colspan="2">&nbsp;</td>
            	</tr>
                <tr id="table-dokin">
                	<td colspan="2" id="data-dokin">
                		<h5 class="smaller lighter green"><strong>Data Dokumen Pemasukan</strong></h5>
                		<div style="float: left; margin-bottom: 10px;">
                			<a id="button-add-dok" class="btn btn-primary btn-sm" title="Tambah Dokumen" onclick="addDokIn()" href="javascript:void(0)">
								<i class="icon-plus"></i> Tambah Dokumen
							</a>
						</div>
                		<table class="tabelajax" id="tbl-dokin">
                        	<tbody>
                            	<tr class="thead">
                                    <th>Nomor Dokumen</th>
                                    <th>Tgl Dokumen</th>
                                    <th width="15%">Saldo</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="10%">Satuan</th>
                                    <th width="10%">Dokumen</th>
                                    <th width="12%">Action</th>
                                </tr>
                            </tbody>
                        </table>
                	</td>
                </tr>
                <?php 
				}elseif($ACT == "update" && $DATADTL){ 
					echo $DATADTL;
				}
				?>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <?php
                	if ($ACT == "update" && $DATADOKUMEN) {
                		echo $DATADOKUMEN;
                	}
                ?>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            	<tr id="tr-button" style="display:none;">
            		<td>
            			<table width="100%" border="0">
                            <tr>
                                <td width="28%">
                                <a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_breakdown('#fBreakdownOut','breakdownmsg_','divbreakdownbrgpop','DETILBARANG','<?= $ACT; ?>');"><i class="icon-save"></i>&nbsp;<?= ucwords($ACT); ?></a>&nbsp;
                                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fBreakdownOut');"><i class="icon-remove"></i>&nbsp;Reset&nbsp;</a>&nbsp;<span class="breakdownmsg_"></span>
                                </td>
                            </tr>
            			</table>
            		</td>
            	</tr>
            </table>
		</form>
	</div>
</div>
<script>
	function getGudang(formid){
		var kdBrg_old = $("#KODE_BARANG_BREAK_OLD").val();
		var kdBrg = $("#KODE_BARANG_BREAK").val();
		var jnsBrg = $("#JNS_BARANG_BREAK").val();
		if (kdBrg != "" && kdBrg != kdBrg_old) {
			$("#KODE_BARANG_BREAK_OLD").val(kdBrg);
			$.ajax({
				type: 'post',
				url: site_url + '/realisasi/getGudang',
				data: {kode_barang:kdBrg, jns_barang: jnsBrg},
				success: function(data) {
					$(formid+" #tr-button").show();
					$(formid+" #data-gudang").show();
					$("#tbl-break .parent").remove();
					$("#tbl-break .child").remove();
					$("#tbl-break").append(data);
				}
			});
		}
	}
	function addDokIn() {
		var kode_barang = $('#KODE_BARANG_BREAK').val();
		var jenis_barang = $('#JNS_BARANG_BREAK').val();
		if (kode_barang != "") {
			var no = GetRandomMath();
			var html = '<tr id="tr-dokin-' + no + '" class="parent">';
			html += '<td><span id="ur-nodaftar-' + no + '"></span>';
			html += '<input type="hidden" id="nodaftar-' + no + '" name="DOKIN[NO_DOK][]"></td>';
			html += '<td><span id="ur-tgldaftar-' + no + '"></span>';
			html += '<input type="hidden" id="tgldaftar-' + no + '" name="DOKIN[TGL_DOK][]"></td>';
			html += '<td><span id="ur-saldo-' + no + '"></span>';
			html += '<input type="hidden" id="saldo-' + no + '" name="DOKIN[SALDO][]"></td>';
			html += '<td>';
			html += '<input type="text" id="jumlah-' + no + '" name="DOKIN[JUMLAH][]" wajib="yes" class="stext date" onkeypress="return intInput(event, /[.0-9]/)" ></td>';
			html += '<td><span id="ur-satuan-' + no + '"></span>';
			html += '<input type="hidden" id="satuan-' + no + '" name="DOKIN[SATUAN][]"></td>';
			html += '<td><span id="ur-dokumen-' + no + '"></span>';
			html += '<input type="hidden" onFocus="filled(' + no + ')" id="dokumen-' + no + '" name="DOKIN[DOKUMEN][]"></td>';
			html += '<td><a id="button-del-dok" class="btn btn-danger btn-sm" title="Hapus Dokumen" onclick="removeDokIn(' + no + ')" href="javascript:void(0)">&nbsp;<i class="icon-minus"></i></a>&nbsp;';
			html += '<a id="button-brw-dok" class="btn btn-warning btn-sm" title="Browse Dokumen" onclick="srcDokIn(' + no + ')" href="javascript:void(0)">&nbsp;<i class="icon-search"></i></a>'
			html += '<input type="hidden" id="seri-barang-' + no + '" name="DOKIN[SERI_BARANG][]">';
			html += '<input type="hidden" id="logid-' + no + '" name="DOKIN[LOGID][]">';
			html += '</td></tr>';
			$('#tbl-dokin').append(html);
		} else {
			jAlert('Silahkan Memilih Data Barang Terlebih Dahulu !', "PLB Inventory");
		}
	}
	function removeDokIn(id) {
		$('#tbl-dokin #tr-dokin-' + id).remove();
	}
	function srcDokIn(id) {
		tb_search('search_dokin', 'dokumen-' + id + ';seri-barang-' + id + ';nodaftar-' + id + ';logid-' + id + ';tgldaftar-' + id + ';satuan-' + id + ';saldo-' + id, 'Dokumen Pemasukan', 'fBreakdownOut', 600, 400,'KODE_BARANG_BREAK;JNS_BARANG_BREAK;');
	}
	function filled(id) {
		var flag = $('#dokumen-' + id).val();
		if (flag != "") {
			$('#ur-nodaftar-' + id).html($('#nodaftar-' + id).val());
			$('#ur-tgldaftar-' + id).html($('#tgldaftar-' + id).val());
			$('#ur-saldo-' + id).html($('#saldo-' + id).val());
			$('#ur-satuan-' + id).html($('#satuan-' + id).val());
			$('#ur-dokumen-' + id).html($('#dokumen-' + id).val());
		}
	}
	function addgudang_break(jumgudang){
		var jmlGudang = parseFloat(jumgudang);
		var jml = parseFloat($('#fBreakdownOut #tbl-break tr').length - 1);
		if(jml < (jmlGudang*2)){
			var no = GetRandomMath();
	 		 var html = "<tr id='tr-break-"+no+"' class='child'>";
			 html += '<td id="td-jumlah-break-'+no+'">&nbsp;</td>';
			 html += '<td id="td-gudang-break-'+no+'">&nbsp;</td>';
			 html += '<td id="td-kondisi-break-'+no+'">&nbsp;</td>';
			 html += '<td id="td-rak-break-'+no+'">&nbsp;</td>';
			 html += '<td id="td-subrak-break-'+no+'">&nbsp;</td>';
			 html += '<td id="td-button-break-'+no+'" align="center">&nbsp;</td>';
			 html += "</tr>";
			 $("#tr-break-1").after(html);
			 var xJumlah = $("#td-jumlah-break-1").html();
			 var xTujuan = $("#td-gudang-break-1").html();
			 var xKondisi = $("#td-kondisi-break-1").html();
			 var xRak = $("#td-rak-break-1").html();
			 var xSubRak = $("#td-subrak-break-1").html();
			 var xButtonAdd = $("#td-button-break-1").html();
			 xJumlah = xJumlah.replace("jumlah-break-1", "jumlah-break-"+no);
			 xTujuan = xTujuan.replace("gudang-break-1", "gudang-break-"+no);
			 xKondisi = xKondisi.replace("kondisi-break-1", "kondisi-break-"+no);
			 xRak = xRak.replace("rak-break-1", "rak-break-"+no);
			 xSubRak = xSubRak.replace("subrak-break-1", "subrak-break-"+no);
			 xButtonAdd = xButtonAdd.replace("button-add-1", "button-add-"+no);
			 $("#td-jumlah-break-"+no).html(xJumlah);
			 $("#td-gudang-break-"+no).html(xTujuan);
			 $("#td-kondisi-break-"+no).html(xKondisi);
			 $("#td-rak-break-"+no).html(xRak);
			 $("#td-subrak-break-"+no).html(xSubRak);
			 $("#td-button-break-"+no).html(xButtonAdd);
			 $("#td-gudang-break-"+no+" #gudang-break-"+no).removeAttr('onChange').attr('onChange', 'getKondisiBreak(this.value,'+no+')');
			 $("#td-jumlah-break-"+no+" #JUMLAH-1").removeAttr('id').attr('id', 'JUMLAH-'+(jml+1));
			 $("#td-button-break-"+no+" #button-add-"+no+" i").removeAttr('class').attr('class','icon-minus');
			 $("#td-button-break-"+no+" #button-add-"+no).removeAttr('class').attr('class', 'btn btn-danger btn-sm').removeAttr('onclick').attr('onClick','RemovegudangBreak('+no+')').removeAttr('title').attr('title','Hapus Gudang');
		}
	}
	function RemovegudangBreak(id){ 
		$("#tr-break-"+id).remove();
	}
	
	function getKondisiBreak(kdgudang,id){
	  var kdBrg = $('#KODE_BARANG_BREAK').val();
	  var jnsBrg = $('#JNS_BARANG_BREAK').val();
	  $.ajax({
        type: 'post',
        url: site_url + '/realisasi/getKondisiIn',
        data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdgudang, id:id, no:''},
        success: function(data) {
			$("#td-kondisi-break-"+id+" combo").remove();
          	$("#td-kondisi-break-"+id+" #kondisi-break-"+id).remove();
		  	$("#td-kondisi-break-"+id).append(data);
			$("#td-rak-break-"+id+" combo").html('<select name="DATABREAK[KODE_RAK][]" id="rak-break-'+id+'" class="stext"><option value="">-- Pilih --</option></select>');
			$("#td-subrak-break-"+id+" combo").html('<select name="DATABREAK[KODE_SUB_RAK][]" id="subrak-break-'+id+'" class="stext"><option value="">-- Pilih --</option></select>');
        }
      });
  }
  
  function getRakBreak(kdGudang,kondisi,id){
	  var kdBrg = $('#KODE_BARANG_BREAK').val();
	  var jnsBrg = $('#JNS_BARANG_BREAK').val();
	  $.ajax({
        type: 'post',
        url: site_url + '/realisasi/getRakIn',
        data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, id:id, no:''},
        success: function(data) {
			$("#td-rak-break-"+id+" combo").remove();
          	$("#td-rak-break-"+id+" #rak-break-"+id).remove();
		  	$("#td-rak-break-"+id).append(data);
        }
      });
  }
  
  function getSubRakBreak(kdGudang,kondisi,rak,id){
	  var kdBrg = $('#KODE_BARANG_BREAK').val();
	  var jnsBrg = $('#JNS_BARANG_BREAK').val();
	  $.ajax({
        type: 'post',
        url: site_url + '/realisasi/getSubRakIn',
        data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, rak:rak, id:id, no:''},
        success: function(data) {
			$("#td-subrak-break-"+id+" combo").remove();
          	$("#td-subrak-break-"+id+" #subrak-break-"+id).remove();
		  	$("#td-subrak-break-"+id).append(data);
        }
      });
  }
</script>