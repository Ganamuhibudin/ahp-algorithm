<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);


?>
<h5 class="header smaller lighter green"><strong>Dokumen <?=strtoupper($DOKUMEN)?></strong></h5>
<form name="fparsialout_" id="fparsialout_" action="<?= site_url()."/realisasi/parsialout" ?>" method="post" autocomplete="off">
    <input type="hidden" name="DOKUMEN" readonly value="<?=$DOKUMEN?>" />
    <input type="hidden" name="NOMOR_AJU" readonly value="<?=$AJU?>" />
    <input type="hidden" name="SERI" readonly value="<?=$ROW[0]["SERI"]?>" />
    <table width="100%" class="tabelPopUp">
        <tr>
            <td width="21%">Nomor Aju</td>
            <td width="79%">: <?= $this->fungsi->FormatAju($AJU)?></td>
        </tr>
        <tr>
            <td width="21%">Nomor Pendaftaran</td>
            <td width="79%">: <?=$ROW[0]["NOMOR_PENDAFTARAN"]?></td>
        </tr>
        <tr>
            <td width="21%">Tanggal Pendaftaran</td>
            <td width="79%">: <?=$this->fungsi->FormatDateIndo($ROW[0]["TANGGAL_PENDAFTARAN"])?></td>
        </tr>
    </table>
    <h5 class="header smaller lighter orange"><strong>Detil Barang</strong></h5>
    <table width="100%">
        <tr>
            <td colspan="2">
                <table class="tabelPopUp" width="100%">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Jenis Barang</th>
                        <th>Uraian</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Jml. A</th>
                        <th>Jml. B</th>
                        <th>Nilai Barang</th>
                    </tr>
                    <?php
                    $banyakData=count($ROW);
                    if($banyakData>0){
                        $no=1;
                        $disabled="";
                        foreach($ROW as $data){
							$KODE_BARANG = strpos($data["KODE_BARANG"], '+') !== false ? str_replace("+","!!!",$data["KODE_BARANG"]) : $data["KODE_BARANG"];
							
							if($data["JUMLAH_INOUT"]=='0') $JUMLAH = $data["JUMLAH_SATUAN"];
                            else $JUMLAH = $data["JUMLAH_SATUAN"] - $data["JUMLAH_INOUT"];
                            
                            //if($data["NILAIBRG_INOUT"]=='0') $NILAI_BRG = $data["NILAI_BARANG"];
                            //else $NILAI_BRG = $data["NILAI_BARANG"] - $data["NILAIBRG_INOUT"];
							if($data["JUMLAH_INOUT"]=='0') $NILAI_BRG = $data["NILAI_BARANG"];
                            else $NILAI_BRG = ($data["NILAI_BARANG"] / $data["JUMLAH_SATUAN"]) * $JUMLAH;
							
                    ?>
                    <input type="hidden" name="hidejumlah<?=$no?>" id="hidejumlah<?=$no?>" no="<?=$no?>" value="<?=$JUMLAH?>">
					<input type="hidden" id="KODE_BARANG_PARSIAL2" value="<?=$KODE_BARANG;?>">
                    <tr>
						
                        <td><?=$data["KODE_BARANG"]; ?><input type="hidden" id="KODE_BARANG_PARSIAL" readonly value="<?= $data["KODE_BARANG"];?>" name="PARSIAL[KODE_BARANG]"></td>
                        <td><?=$data["JNSBARANG"]?><input type="hidden" readonly id="JNS_BARANG_PARSIAL" value="<?=$data["JNS_BARANG"]?>" name="PARSIAL[JNS_BARANG]"></td>
                        <td><?=$data["URAIAN_BARANG"]?></td>
                        <td id="td_jum" align="center"><?=$data["JUMLAH_SATUAN"]?><input type="hidden" id="JUMLAH_SATUAN" readonly value="<?=$data["JUMLAH_SATUAN"]?>" name="PARSIAL[JUMLAH_SATUAN]"></td>
                        <td align="center"><?=$data["KODE_SATUAN"]?><input type="hidden" id="KODE_SATUAN" readonly value="<?=$data["KODE_SATUAN"]?>" name="PARSIAL[KODE_SATUAN]" ></td>
                        <td id="td_a" align="center"><?=$data["JUMLAH_INOUT"]?><input type="hidden" id="JUMLAH_SUDAH_PARSIAL" readonly value="<?=$data["JUMLAH_INOUT"]?>" ></td>
                        <td align="center"><input type="text" id="UR_JUMLAH_B<?=$no?>" value="<?=$this->fungsi->FormatRupiah($JUMLAH,2)?>" class="stext date" style="text-align:right;" wajib="yes" onkeyup="this.value = ThausandSeperator('jumlahparsial',this.value,2);"/><input type="hidden" id="jumlahparsial" value="<?=$JUMLAH?>" name="PARSIAL[JUMLAH]" /></td>
                        <?php
                        if($JUMLAH==0){
                            $disabled = 'disabled="disabled"';
                        }
                        ?>
                        <td align="center"><input type="text" name="PARSIAL[NILAI_BARANG]" id="NILAI_BRG<?=$no?>" value="<?=$NILAI_BRG?>" class="stext date" style="text-align:right;" wajib="yes" no="<?=$no?>" onKeyPress="return intInput(event, /[.0-9]/)"/></td>
                    </tr>
                    <?php		
                            $no++;
                        }
                    }
                    ?>
                </table>
            </td>
        </tr>
    </table>
    <?php if($JUMLAH!="0"){ ?>
    <h5 class="header smaller lighter blue"><strong>Gudang Barang</strong></h5>
    <table class="tabelPopUp" width="100%" id="tbl-parisal">
        <tr>
            <th>Kode Gudang</th>
            <th>Kondisi Barang</th>
            <th>Kode Rak</th>
            <th>Kode Sub Rak</th>
            <th>Action</th>
        </tr>
        <tr id="tr-parsial-1">
            <td id="td-tujuan-parsial-1">
                <combo><?=form_dropdown('DATAPARSIAL[KODE_GUDANG][]', array_merge(array(""=>"--Pilih--"),$GUDANG), '', 'wajib="yes" id="gudang-parsial-1" class="text" onChange="getKondisiParsial(this.value,1)"')?></combo>
            </td>
            <td id="td-kondisi-parsial-1">
                <combo><?=form_dropdown('DATAPARSIAL[KONDISI_BARANG][]', array_merge(array(""=>"--Pilih--"),$KONDISI), '', 'wajib="yes" id="kondisi-parsial-1" class="stext"')?></combo>
            </td>
            <td id="td-rak-parsial-1">
            	<combo><?=form_dropdown('DATAPARSIAL[KODE_RAK][]', $RAK, '', 'id="rak-parsial-1" class="stext"')?></combo>
            </td>
            <td id="td-subrak-parsial-1">
            	<combo><?=form_dropdown('DATAPARSIAL[KODE_SUB_RAK][]', $SUBRAK, '', 'id="subrak-parsial-1" class="stext"')?></combo>
            </td>
            <?php if(count($GUDANG) > 1 || count($KONDISI)>1 || count($RAK)>1 || count($SUBRAK)>1){ ?>
                <td id="action-parsial-1" align="center">
                    <a href="javascript:void(0);" onclick="addGudangParsial(1);" class="btn btn-success btn-sm" id="btn-add-parsial-1">&nbsp;<i class="fa fa-plus"></i></a>
                </td>
            <?php }else{ ?>
            	<td>&nbsp;</td>
            <?php } ?>
        </tr>
    </table>
    <?php } ?>
	<table width="100%">
		<tr id="table-dokin">
			<td colspan="2" id="data-dokin">
				<h5 class="header smaller lighter red"><strong>Data Dokumen Pemasukan</strong></h5>
				<div style="float: left; margin-bottom: 10px;">
					<a id="button-add-dok" class="btn btn-primary btn-sm" title="Tambah Dokumen" onclick="addDokInParsial()" href="javascript:void(0)">
						<i class="icon-plus"></i> Tambah Dokumen
					</a>
				</div>
				<table class="tabelPopUp" id="tbl-dokin">
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
	</table>
	<br />
    <table>
        <?php if($JUMLAH!="0"){ ?>
        <tr>
            <td colspan="2">
                <a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="breakdown_finish('#fparsialout_'); cektotal();">
                    <i class="icon-check"></i>Save
                </a>&nbsp;<span class="msg_break"></span>
        	</td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        <td colspan="2" style="font-style:italic">
            <b>Keterangan :</b><br>
            Jml. A = Jumlah Barang yang sudah direalisasi<br>
            Jml. B = Jumlah barang yang akan direalisasi
        </td>
        </tr>
    </table>
</form>
<script>
	$(".breakchk").each(function(index, element) {
		if($(this).attr("checked")==true){
			$("#breaktbl"+$(this).attr("no")).show();
			$(this).parent().parent().addClass("selected");
		}
	});
	
	function cektotal() {
		var c = "<?=$ROW[0]["SERI"]?>";
		var values = parseInt($("#frealisasi_out #TOTALPARSIAL").val());
		var x = $('#jumlahparsial').val();
		
		if ($('#frealisasi_out #breakchk' + c).is(":checked") ==true){
			if($('#jumlahparsial').val() < 1) {
				$('#tr_'+c).removeClass("selected-break");
				$("#frealisasi_out #breakchk"+c).attr('checked', false);
				showbuttonbreak(c);
			}
		}
	}
	
	function showbutton(val){
		if(!$("#breakchk"+val).attr('checked')==true){
			$("#fparsialout_ #breakchk"+val).parent().parent().removeClass("selected");
			$("#breaktbl"+val).hide();
		}else{
			if($('#JUMLAH_B'+val).val()>0){
				$("#fparsialout_ #breakchk"+val).parent().parent().addClass("selected");
				$("#breaktbl"+val).show();
			}else{
				jAlert('Jumlah Kurang!','PLB INVENTORY');	
				$("#breakchk"+val).attr('checked',false)
			}
		}
	}
	
	function cekbreak(id,val){
		if(val==0){
			$("#breakchk"+id).attr('checked',false)
			$("#breaktbl"+id).hide();	
			$("#fparsialout_ #breakchk"+id).parent().parent().removeClass("selected");
		}
		if(val==""){
			$('#JUMLAH_B'+id).val(0);	
		}
		if(parseFloat(val)>parseFloat($("#hidejumlah"+id).val())){
			$('#JUMLAH_B'+id).val(parseFloat($("#hidejumlah"+id).val()));	
		}
	}
	
	function addGudangParsial(id){
		var kuota = $("#tr-parsial-"+id+" #gudang-parsial-"+id+" option").size(); 
		var item = $('select[name="DATAPARSIAL[KODE_GUDANG][]"]').length;
		if (item < (kuota * 2)) {
			var no = GetRandomMath();
			var html = "<tr id='tr-parsial-"+no+"' parent-id='"+id+"' class='child-parsial'>";
			html += "<td id='td-tujuan-parsial-"+no+"'>&nbsp;</td>";
			html += "<td id='td-kondisi-parsial-"+no+"'>&nbsp;</td>";
			html += "<td id='td-rak-parsial-"+no+"'>&nbsp;</td>";
			html += "<td id='td-subrak-parsial-"+no+"'>&nbsp;</td>";
			html += "<td id='action-parsial-"+no+"' align=\"center\">&nbsp;</td>";
			html += "</tr>";
			$("#tr-parsial-"+id).after(html);
			var xTujuan = $("#td-tujuan-parsial-"+id).html();
			var xKondisi = $("#td-kondisi-parsial-"+id).html();
			var xRak = $("#td-rak-parsial-"+id).html();
			var xSubRak = $("#td-subrak-parsial-"+id).html();
			var xAction = $("#action-parsial-"+id).html();
			xTujuan = xTujuan.replace("gudang-parsial-"+id, "gudang-parsial-"+no);
			xKondisi = xKondisi.replace("kondisi-parsial-"+id, "kondisi-parsial-"+no);
			xRak = xRak.replace("rak-parsial-"+id, "rak-parsial-"+no);
			xSubRak = xSubRak.replace("subrak-parsial-"+id, "subrak-parsial-"+no);
			xAction = xAction.replace("action-parsial-"+id, "action-parsial-"+no);
			if(item==1){
				$('#td-tujuan-parsial-'+id+' #gudang-parsial-'+id).before('<input type="text" wajib="yes" id="ur-jumlah-'+id+'" class="stext date" onkeyup="this.value = ThausandSeperator(\'jumlah-'+id+'\',this.value,2);" /><input id="jumlah-'+id+'" type="hidden" value="0" name="DATAPARSIAL[JUMLAH][]" >&nbsp;');
			}
			$("#td-tujuan-parsial-"+no).html(xTujuan);
			$("#td-kondisi-parsial-"+no).html(xKondisi);
			$("#td-rak-parsial-"+no).html(xRak);
			$("#td-subrak-parsial-"+no).html(xSubRak);
			$("#action-parsial-"+no).html(xAction);
			$("#tr-parsial-"+no+" #btn-add-parsial-"+id).removeAttr('class').attr('class', 'btn btn-danger btn-sm').removeAttr('onclick').attr('onClick','delGudangParsial('+no+','+id+')');
			$("#tr-parsial-"+no+" #btn-add-parsial-"+id+" i").removeAttr('class').attr('class','icon-trash');
			$("#td-tujuan-parsial-"+no+" #gudang-parsial-"+no).removeAttr('onChange').attr('onChange', 'getKondisiParsial(this.value,'+no+')');
			if(item==1){
				$('#td-tujuan-parsial-'+no+' #gudang-parsial-'+no).before('<input type="text" wajib="yes" id="ur-jumlah-'+no+'" class="stext date" onkeyup="this.value = ThausandSeperator(\'jumlah-'+no+'\',this.value,2);" /><input id="jumlah-'+no+'" type="hidden" value="0" name="DATAPARSIAL[JUMLAH][]" >&nbsp;');
			}
		}
	}
	
	function delGudangParsial (id,no) {
		var item = $('select[name="GUDANG['+no+'][]"]').length;
		if(item==2){
			$("#ur-jumlah-"+no).remove();
			$("#jumlah-"+no).remove();
		}
		$("#tr-parsial-"+id).remove();
	}
	
	function getKondisiParsial(val,id){
		var kdBrg = $('#KODE_BARANG_PARSIAL').val();
	 	var jnsBrg = $('#JNS_BARANG_PARSIAL').val();
	  	$.ajax({
			type: 'post',
			url: site_url + '/realisasi/getKondisiIn',
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:val, id:id, no:'parsial',tipe:'out'},
			success: function(data) {
				$("#td-kondisi-parsial-"+id+" combo").remove();
				$("#td-kondisi-parsial-"+id).append(data);
				$("#td-rak-parsial-"+id+" combo").html('<select name="DATAPARSIAL[KODE_RAK][]" id="rak-parsial-'+id+'" class="stext"><option value="">-- Pilih --</option></select>');
				$("#td-subrak-parsial-"+id+" combo").html('<select name="DATAPARSIAL[KODE_SUB_RAK][]" id="subrak-parsial-'+id+'" class="stext"><option value="">-- Pilih --</option></select>');
        	}
      	});
	}
	
	function getRakParsial(kdGudang,kondisi,id){
	  var kdBrg = $('#KODE_BARANG_PARSIAL').val();
	  var jnsBrg = $('#JNS_BARANG_PARSIAL').val();
	  $.ajax({
        type: 'post',
        url: site_url + '/realisasi/getRakIn',
        data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, id:id, no:'parsial',tipe:'out'},
        success: function(data) {
			$("#td-rak-parsial-"+id+" combo").remove();
		  	$("#td-rak-parsial-"+id).append(data);
        }
      });
  }
  
  function getSubRakParsial(kdGudang,kondisi,rak,id){
	  var kdBrg = $('#KODE_BARANG_PARSIAL').val();
	  var jnsBrg = $('#JNS_BARANG_PARSIAL').val();
	  $.ajax({
        type: 'post',
        url: site_url + '/realisasi/getSubRakIn',
        data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, rak:rak, id:id, no:'parsial',tipe:'out'},
        success: function(data) {
			$("#td-subrak-parsial-"+id+" combo").remove();
		  	$("#td-subrak-parsial-"+id).append(data);
        }
      });
  }
  function addDokInParsial() {
		var kode_barang = $('#KODE_BARANG_PARSIAL').val();
		var jenis_barang = $('#JNS_BARANG_PARSIAL').val();
		if (kode_barang != "") {
			var no = GetRandomMath();
			var html = '<tr id="tr-dokin-' + no + '" class="parent">';
			html += '<td align="center"><span id="ur-nodaftar-' + no + '"></span>';
			html += '<input type="hidden" id="nodaftar-' + no + '" name="DOKIN[NO_DOK][]"></td>';
			html += '<td align="center"><span id="ur-tgldaftar-' + no + '"></span>';
			html += '<input type="hidden" id="tgldaftar-' + no + '" name="DOKIN[TGL_DOK][]"></td>';
			html += '<td align="center"><span id="ur-saldo-' + no + '"></span>';
			html += '<input type="hidden" id="saldo-' + no + '" name="DOKIN[SALDO][]"></td>';
			html += '<td>';
			html += '<input type="text" id="jumlah-' + no + '" name="DOKIN[JUMLAH][]" wajib="yes" class="stext date" onkeypress="return intInput(event, /[.0-9]/)" ></td>';
			html += '<td align="center"><span id="ur-satuan-' + no + '"></span>';
			html += '<input type="hidden" id="satuan-' + no + '" name="DOKIN[SATUAN][]"></td>';
			html += '<td align="center"><span id="ur-dokumen-' + no + '"></span>';
			html += '<input type="hidden" onFocus="filledParsial(' + no + ')" id="dokumen-' + no + '" name="DOKIN[DOKUMEN][]"></td>';
			html += '<td><a id="button-del-dok" class="btn btn-danger btn-sm" title="Hapus Dokumen" onclick="removeDokInParsial(' + no + ')" href="javascript:void(0)">&nbsp;<i class="icon-minus"></i></a>&nbsp;';
			html += '<a id="button-brw-dok" class="btn btn-warning btn-sm" title="Browse Dokumen" onclick="srcDokInParsial(' + no + ')" href="javascript:void(0)">&nbsp;<i class="icon-search"></i></a>'
			html += '<input type="hidden" id="seri-barang-' + no + '" name="DOKIN[SERI_BARANG][]">';
			html += '<input type="hidden" id="logid-' + no + '" name="DOKIN[LOGID][]">';
			html += '</td></tr>';
			$('#tbl-dokin').append(html);
		} else {
			jAlert('Silahkan Memilih Data Barang Terlebih Dahulu !', "PLB Inventory");
		}
	}
	function removeDokInParsial(id) {
		$('#tbl-dokin #tr-dokin-' + id).remove();
	}
	function srcDokInParsial(id) {
		tb_search('search_dokin', 'dokumen-' + id + ';seri-barang-' + id + ';nodaftar-' + id + ';logid-' + id + ';tgldaftar-' + id + ';satuan-' + id + ';saldo-' + id, 'Dokumen Pemasukan', 'fparsialout_', 600, 400,'KODE_BARANG_PARSIAL2;JNS_BARANG_PARSIAL;');
	}
	function filledParsial(id) {
		var flag = $('#dokumen-' + id).val();
		if (flag != "") {
			$('#ur-nodaftar-' + id).html($('#nodaftar-' + id).val());
			$('#ur-tgldaftar-' + id).html($('#tgldaftar-' + id).val());
			$('#ur-saldo-' + id).html($('#saldo-' + id).val());
			$('#ur-satuan-' + id).html($('#satuan-' + id).val());
			$('#ur-dokumen-' + id).html($('#dokumen-' + id).val());
		}
	}
</script> 
