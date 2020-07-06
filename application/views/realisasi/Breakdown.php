<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<h5 class="header smaller lighter green"><strong>Dokumen <?=strtoupper($DOKUMEN)?></strong></h5>
<form name="fbreakdown_" id="fbreakdown_" action="<?= site_url()."/realisasi/parsialin" ?>" method="post" autocomplete="off">
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
    <br />
    <h5 class="header smaller lighter green"><strong>Detil Barang</strong></h5>
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
                            if($data["JUMLAH_INOUT"]=='0') $JUMLAH = $data["JUMLAH_SATUAN"];
                            else $JUMLAH = $data["JUMLAH_SATUAN"] - $data["JUMLAH_INOUT"];
                            
                            if($data["NILAIBRG_INOUT"]=='0') $NILAI_BRG = $data["NILAI_BARANG"];
                            else $NILAI_BRG = $data["NILAI_BARANG"] - $data["NILAIBRG_INOUT"];
                    
                    ?>
                    <input type="hidden" name="hidejumlah<?=$no?>" id="hidejumlah<?=$no?>" no="<?=$no?>" value="<?=$JUMLAH?>">
                    <tr>
                        <td><?=$data["KODE_BARANG"]?><input type="hidden" id="KODE_BARANG_PARSIAL" readonly value="<?=$data["KODE_BARANG"]?>" name="PARSIAL[KODE_BARANG]"></td>
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
    <br />
    <h5 class="header smaller lighter green"><strong>Gudang Barang</strong></h5>
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
                <combo><?=form_dropdown('GUDANG[1][]', array_merge(array(""=>"--Pilih--"),$GUDANG), '', 'wajib="yes" id="gudang-parsial-1" class="text" onChange="getKondisiParsial(this.value,1)"')?></combo>
            </td>
            <td id="td-kondisi-parsial-1">
                <combo><?=form_dropdown('KONDISI[1][]', array_merge(array(""=>"--Pilih--"),$KONDISI), '', 'wajib="yes" id="kondisi-parsial-1" class="stext"')?></combo>
            </td>
            <td id="td-rak-parsial-1">
            	<combo><?=form_dropdown('RAK[1][]', $RAK, '', 'id="rak-parsial-1" class="stext"')?></combo>
            </td>
            <td id="td-subrak-parsial-1">
            	<combo><?=form_dropdown('SUBRAK[1][]', $SUBRAK, '', 'id="subrak-parsial-1" class="stext"')?></combo>
            </td>
            <?php if(count($SUBRAK) > 1){ ?>
                <td id="action-parsial-1" align="center">
                    <a href="javascript:void(0);" onclick="addGudangParsial(1);" class="btn btn-success btn-sm" id="btn-add-parsial-1">&nbsp;<i class="fa fa-plus"></i></a>
                </td>
            <?php }else{ ?>
            	<td>&nbsp;</td>
            <?php } ?>
        </tr>
    </table>
    <?php } ?>
    <br />
    <table>
        <?php if($JUMLAH!="0"){ ?>
        <tr>
            <td colspan="2">
                <a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="breakdown_finish('#fbreakdown_')">
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
	
	function showbutton(val){
		if(!$("#breakchk"+val).attr('checked')==true){
			$("#fbreakdown_ #breakchk"+val).parent().parent().removeClass("selected");
			$("#breaktbl"+val).hide();
		}else{
			if($('#JUMLAH_B'+val).val()>0){
				$("#fbreakdown_ #breakchk"+val).parent().parent().addClass("selected");
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
			$("#fbreakdown_ #breakchk"+id).parent().parent().removeClass("selected");
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
		var item = $('select[name="GUDANG['+id+'][]"]').length;
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
				$('#td-tujuan-parsial-'+id+' #gudang-parsial-'+id).before('<input type="text" wajib="yes" id="ur-jumlah-'+id+'" class="stext date" onkeyup="this.value = ThausandSeperator(\'jumlah-'+id+'\',this.value,2);" /><input id="jumlah-'+id+'" type="hidden" value="0" name="jumlah['+id+'][]" >&nbsp;');
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
				$('#td-tujuan-parsial-'+no+' #gudang-parsial-'+no).before('<input type="text" wajib="yes" id="ur-jumlah-'+no+'" class="stext date" onkeyup="this.value = ThausandSeperator(\'jumlah-'+no+'\',this.value,2);" /><input id="jumlah-'+no+'" type="hidden" value="0" name="jumlah['+id+'][]" >&nbsp;');
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
			data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:val, id:id, no:'parsial'},
			success: function(data) {
				$("#td-kondisi-parsial-"+id+" combo").remove();
				$("#td-kondisi-parsial-"+id).append(data);
				$("#td-rak-parsial-"+id+" combo").html('<select name="RAK['+id+'][]" id="rak-parsial-'+id+'" class="stext"><option value="">-- Pilih --</option></select>');
				$("#td-subrak-parsial-"+id+" combo").html('<select name="SUBRAK['+id+'][]" id="subrak-parsial-'+id+'" class="stext"><option value="">-- Pilih --</option></select>');
        	}
      	});
	}
	
	function getRakParsial(kdGudang,kondisi,id){
	  var kdBrg = $('#KODE_BARANG_PARSIAL').val();
	  var jnsBrg = $('#JNS_BARANG_PARSIAL').val();
	  $.ajax({
        type: 'post',
        url: site_url + '/realisasi/getRakIn',
        data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, id:id, no:'parsial'},
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
        data: {kode_barang:kdBrg, jns_barang: jnsBrg, kode_gudang:kdGudang, kondisi:kondisi, rak:rak, id:id, no:'parsial'},
        success: function(data) {
			$("#td-subrak-parsial-"+id+" combo").remove();
		  	$("#td-subrak-parsial-"+id).append(data);
        }
      });
  }
</script> 
