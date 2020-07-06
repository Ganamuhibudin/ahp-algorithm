<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<div class="content">
<a href="javascript: window.history.go(-1)" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-sm btn-success"><i class="icon-arrow-left"></i>&nbsp;Back</a>
<form name="fpindahgudang_" id="fpindahgudang_" action="<?= site_url()."/inventory/pindah_gudang/".$KODE_BARANG."/".$JNS_BARANG; ?>" method="post" autocomplete="off">
<div class="header"><h3><i class="icon-list"></i><strong>&nbsp;Pindah Gudang</strong></h3></div>
<br><br>
<input type="hidden" name="KODE_BARANG" value="<?=$KODE_BARANG?>" readonly />
<input type="hidden" name="JNS_BARANG" value="<?=$JNS_BARANG?>" readonly />
<input type="hidden" name="JUMGUDANG" value="<?=count($KODE_GUDANG)?>" readonly />
<table width="100%" border="0">
    <tr>
        <td>
            <table>
                <tr>
                    <td>Nomor Transaksi</td>
                    <td width="30%">
                        <input type="text" wajib="yes" name="NOMOR_PROSES" class="mtext" maxlength="14" />
                    </td>
                    <td>&nbsp;&nbsp;Tanggal / Jam</td>
                    <td>
                        <input id="TANGGAL_PROSES" class="stext date" type="text" wajib="yes" onfocus="ShowDP('TANGGAL_PROSES');" onmouseover="ShowDP('TANGGAL_PROSES');" name="TANGGAL_PROSES">
                    </td>
                    <td>
                        <input id="WAKTU" class="stext" style="width:50px" type="text" onmouseover="ShowTime(this.id)" onfocus="ShowTime(this.id)" onclick="ShowTime(this.id)" name="WAKTU">
                    </td>
                    <td>YYYY-MM-DD HH:MI</td>
                </tr>
                <tr>
                	<td valign="top">Keterangan</td>
                    <td>
                    	<textarea name="KETERANGAN" class="mtext"></textarea>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td><hr style="border: 0.5px solid #ccc;" /></td>
    </tr>
    <tr>
        <td>
            <div style="float:left;">
            	<b>Kode Barang : [ <span style="color:#D35400"><?=strtoupper($KODE_BARANG)?></span> ]</b> dengan 
            	<b>Jenis Barang : [ <span style="color:#D35400"><?=$UR_JENIS_BARANG?> </span>]</b> dan 
                <b>Jumah Stock Tersedia : [ <span style="color:#D35400"><?= $STOCK_AKHIR." ".$KODE_SATUAN ?></span> ]</b>
            </div>
            <div style="float:right;">
                <a class="btn btn-sm btn-success" id="TAMBAH_GUDANG" onclick="gudang_all(1);" href="javascript:void(0);">
                    <i class="fa fa-plus"></i>&nbsp; Tambah Gudang
                </a>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <table id="tbl-gudang" class="tabelajax" width="100%">
                <tr>
                    <th width="2%">No</th>
                    <th>Gudang Asal</th>
                    <th>Kondisi Barang</th>
                    <th>Rak Asal</th>
                    <th>Subrak Asal</th>
                    <th>Jumlah Tersedia</th>
                    <th>Gudang Tujuan</th>
                    <th>Kondisi Barang</th>
                    <th>Rak Tujuan</th>
                    <th>Subrak Tujuan</th>
                    <th colspan="2">Jumlah</th>
                </tr>
                <tr id="tr-1" class="data">
                    <td class="alt"><span class="nop">1</span></td>
                    <td class="alt" style="border-right:none;" id="gdasal1">
                        <combo id="gdasal1"><?php  echo form_dropdown('GUDANG_ASAL[1][]', $KODE_GUDANG, '', 'wajib="yes" id="GUDANG_ASAL1" class="sstext" onChange="getjumlah(\'1\');getKondisi(1,\'asal\')"') ?></combo>
                    </td>
                    <td class="alt" style="border-left:none; border-right:none;" id="kondisiasal1">
                    	<combo id="kdasal1"><?php  echo form_dropdown('KONDISI_ASAL[1][]', array(""=>""), '', 'wajib="yes" id="KONDISI_ASAL1" class="sstext" onChange="getRak(1,\'asal\');getjumlah(\'1\')"') ?></combo>
                    </td>
                    <!-- RAK DAN SUBRAK ASAL -->
                     <td class="alt" style="border-left:none; border-right:none;" id="rakasal1">
                    	<combo id="rakasal1"><?php  echo form_dropdown('RAK_ASAL[1][]', $RAK, '', 'id="RAK_ASAL1" class="sstext"') ?></combo>
                    </td>
                     <td class="alt" style="border-left:none; border-right:none;" id="srakasal1">
                    	<combo id="srakasal1"><?php  echo form_dropdown('SUBRAK_ASAL[1][]', $SUBRAK, '', 'id="SUBRAK_ASAL1" class="sstext"') ?></combo>
                    </td>
                    <!-- -------------- -->
                    <td class="alt" style="border-left:none;">
                        <input type="text" readonly name="JUMLAH_ASAL_HIDE" id="JUMLAH_ASAL_HIDE1" class="stext" style="text-align:right" />
                        <input type="hidden" name="JUMLAH_ASAL[1][]" id="JUMLAH_ASAL1" />
                    </td>
                    <td class="alt" style="border-right:none;background-color:#F6F6E0" id="kdgdtujuan1">
                        
                           <combo id="gdtujuan1"><?php  echo form_dropdown('GUDANG_TUJUAN[1][]', $KODE_GUDANG, '', 'wajib="yes" id="GUDANG_TUJUAN1" class="sstext" onclick="getKondisi(1,\'tujuan\')"') ?></combo> 
                       
                    </td>
                    <td class="alt" style="border-left:none;border-right:none;background-color:#F6F6E0" id="kondisitujuan1">
                    	<combo id="kondisitujuan1"><?php  echo form_dropdown('KONDISI_TUJUAN[1][]', array(""=>""), '', 'wajib="yes" id="KONDISI_TUJUAN1" class="sstext"') ?></combo>
                    </td>
                    <!-- RAK DAN SUBRAK TUJUAN -->
                     <td class="alt" style="border-left:none; border-right:none;background-color:#F6F6E0" id="raktuju1">
                    	<combo id="raktuju1"><?php  echo form_dropdown('RAK_TUJU[1][]', $RAK, '', 'id="RAK_TUJU1" class="sstext" onChange="getjumlah2(this.value,\'1\')"') ?></combo>
                    </td>
                     <td class="alt" style="border-left:none; border-right:none;background-color:#F6F6E0" id="sraktuju1">
                    	<combo id="sraktuju1"><?php  echo form_dropdown('SUBRAK_TUJU[1][]', $SUBRAK, '', 'id="SUBRAK_TUJU1" class="sstext" onChange="getjumlah2(this.value,\'1\')"') ?></combo>
                    </td>
                    <!-- -------------- -->
                    <td class="alt" style="border-left:none;border-right:none;background-color:#F6F6E0">
                        <input type="text" name="JUMLAH_TUJUAN[1][]" id="JUMLAH_TUJUAN1" class="stext" style="text-align:right;" wajib="yes" onKeyPress="return intInput(event, /[.0-9]/)" />
                        <input type="hidden" name="LOOPS[]" id="LOOPS1" value="1" />
                    </td>
                    <td class="alt" style="border-left:none;background-color:#F6F6E0">
                        <a onclick="gudang_list(1);" href="javascript:void(0);" style="color:#60C060;font-size:22px">
                            <i class="fa fa-plus-circle"></i>
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
</table>
<a id="ok_" class="btn btn-success" onclick="save_post('#fpindahgudang_');" href="javascript:void(0);">
    <i class="fa fa-save"></i>&nbsp;Proses
</a>
<span class="msg_" style="margin-left:20px">&nbsp;</span>
</form>
</div>

<script>
$(function(){FormReady();})
</script>
<script type="text/javascript">
	if($("#JUMGUDANG").val() < 2){	
		closedialog('dialog-tbl');
		jAlert("Data tidak dapat dipindahkan.<br>Kode Barang hanya memiliki 1 (satu) gudang saja.","PLB Inventory");
	}
    function getjumlah(urut){
    	var gudangasal = $("#GUDANG_ASAL"+urut).val();
		var kondisiasal = $("#KONDISI_ASAL"+urut).val();
		var rakasal = $("#RAK_ASAL"+urut).val();
		var srakasal = $("#SRAK_ASAL"+urut).val();
		$.ajax({
			type: 'POST',
			url: site_url+"/inventory/get_jumlah",
			data: "kdbrg=<?=$KODE_BARANG?>&jnsbrg=<?=$JNS_BARANG?>&kdgdng="+gudangasal+"&kondisi="+kondisiasal+"&rak="+rakasal+"&srak="+srakasal,
			dataType:'json',
			success: function(data){
				$("#JUMLAH_ASAL_HIDE"+urut).val(data.JUM);
				$("#JUMLAH_ASAL"+urut).val(data.JUMLAH);
			}
		});		
	}
	
	/*function getjumlah2(val,urut){
		var gudangasal = $("#GUDANG_ASAL"+urut).val();
		$.ajax({
			type: 'POST',
			url: site_url+"/inventory/get_jumlah",
			data: "kdbrg=<?=$KODE_BARANG?>&jnsbrg=<?=$JNS_BARANG?>&kdgdng="+gudangasal+"&kondisi="+val,
			dataType:'json',
			success: function(data){
				$("#JUMLAH_ASAL_HIDE"+urut).val(data.JUM);
				$("#JUMLAH_ASAL"+urut).val(data.JUMLAH);
			}
		});		
	}*/
	
	function gudang_all(urut){	
		var no = $("tr.data").length+1; 
		//var rand = GetRandomMath();	
		var cnt = urut + 1; 			
		var jumall = <?= count($KODE_GUDANG)?>; 
		if((no-1)!=jumall){
			var html = '<tr id="tr-'+cnt+'" class="data">\
								<td class="alt"><span class="nop">'+no+'</span></td>\
								<td class="alt" id="kdgasal'+cnt+'" style="border-right:none;"><combo id="gdasal'+cnt+'"></combo></td>\
								<td class="alt" id="kondisiasal'+cnt+'" style="border-left:none; border-right:none;"><combo id="kdasal'+cnt+'"></combo></td>\
								<td class="alt" id="rakasal'+cnt+'" style="border-left:none; border-right:none;"><combo id="rakasal'+cnt+'"><select name="RAK_ASAL[1][]" id="RAK_ASAL'+cnt+'" class="sstext" onChange="getjumlah2(this.value,\''+cnt+'\')"></select></combo></td>\
								<td class="alt" id="srakasal'+cnt+'" style="border-left:none; border-right:none;"><combo id="srakasal'+cnt+'"><select name="SRAK_ASAL[1][]" id="SRAK_ASAL'+cnt+'" class="sstext" onChange="getjumlah2(this.value,\''+cnt+'\')"></select></combo></td>\
								<td class="alt" style="border-left:none;">\
								<input type="text" name="JUMLAH_ASAL_HIDE" id="JUMLAH_ASAL_HIDE'+cnt+'" class="stext" style="text-align:right;" readonly="readonly"/><input type="hidden" name="JUMLAH_ASAL['+cnt+'][]" id="JUMLAH_ASAL'+cnt+'" /></td>\
								<td class="alt" id="kdgtuju'+cnt+'" style="border-right:none;background-color:#F6F6E0"><combo id="gdtuju'+cnt+'"></combo></td>\
								<td class="alt" id="kondisituju'+cnt+'" style="border-left:none;border-right:none;background-color:#F6F6E0"><combo id="kdtuju'+cnt+'"></combo></td>\
								<td class="alt" id="raktuju'+cnt+'" style="border-left:none; border-right:none; background-color:#F6F6E0"><combo id="raktuju'+cnt+'"><select name="RAK_TUJU[1][]" id="RAK_TUJU'+cnt+'" class="sstext"></select></combo></td>\
								<td class="alt" id="sraktuju'+cnt+'" style="border-left:none; border-right:none; background-color:#F6F6E0"><combo id="sraktuju'+cnt+'"><select name="SRAK_TUJU[1][]" id="SRAK_TUJU'+cnt+'" class="sstext"></select></combo></td>\
								<td class="alt" style="border-left:none;border-right:none;background-color:#F6F6E0"><input type="text" name="JUMLAH_TUJUAN['+cnt+'][]" id="JUMLAH_TUJUAN'+cnt+'" class="stext" wajib="yes"  style="text-align:right;" onKeyPress="return intInput(event, /[.0-9]/)"/>\
								<input type="hidden" name="LOOPS[]" id="LOOPS1" value="'+cnt+'" />\
								<td class="alt" style="border-left:none;background-color:#F6F6E0"><a onclick="gudang_list('+cnt+')" style="color:#60C060;font-size:22px;cursor:pointer"> <i class="fa fa-plus-circle"></i></a>&nbsp;<a style="color:#DF4B33;font-size:22px;cursor:pointer" onclick="hapus_gudangrow('+cnt+')"><i class="fa fa-minus-circle"></i></a></td></tr>';
			$("#tbl-gudang").append(html);

			$("#GUDANG_ASAL1").clone(true).removeAttr('id').attr('id','GUDANG_ASAL'+cnt)
			.removeAttr('onChange').attr('onChange','getjumlah('+cnt+');getRak('+cnt+',\'asal\')')
			.removeAttr('name').attr('name','GUDANG_ASAL['+cnt+'][]')
			.appendTo('#kdgasal'+cnt+' #gdasal'+cnt);
			
			$("#KONDISI_ASAL1").clone(true).removeAttr('id').attr('id','KONDISI_ASAL'+cnt)
			.removeAttr('onChange').attr('onChange','getjumlah('+cnt+')')
			.removeAttr('name').attr('name','KONDISI_ASAL['+cnt+'][]')
			.appendTo('#kondisiasal'+cnt+' #kdasal'+cnt);

		/*	$("#RAK_ASAL1").clone(true).removeAttr('id').attr('id','RAK_ASAL'+cnt)	
			.removeAttr('name').attr('name','RAK_ASAL['+cnt+'][]')
			.appendTo('#rakasal'+cnt+' #rakasal'+cnt);

			$("#SUBRAK_ASAL1").clone(true).removeAttr('id').attr('id','SUBRAK_ASAL'+cnt)	
			.removeAttr('name').attr('name','SRAK_ASAL['+cnt+'][]')
			.appendTo('#srakasal'+cnt+' #srakasal'+cnt);*/
			
			$("#GUDANG_TUJUAN1").clone(true).removeAttr('id').attr('id','GUDANG_TUJUAN'+cnt)
			.removeAttr('onChange').attr('onChange','getRak('+cnt+',\'tuju\')')		
			.removeAttr('name').attr('name','GUDANG_TUJUAN['+cnt+'][]')
			.appendTo('#kdgdtujuan'+cnt+' #gdtujuan'+cnt);
			
			$("#KONDISI_TUJUAN1").clone(true).removeAttr('id').attr('id','KONDISI_TUJUAN'+cnt)
			.removeAttr('name').attr('name','KONDISI_TUJUAN['+cnt+'][]')
			.appendTo('#kondisitujuan'+cnt+' #kdtujuan'+cnt);

			$("#RAK_TUJUAN1").clone(true).removeAttr('id').attr('id','RAK_TUJUAN'+cnt)	
			.removeAttr('name').attr('name','RAK_TUJUAN['+cnt+'][]')
			.appendTo('#raktuju'+cnt+' #raktuju'+cnt);

			$("#SUBRAK_TUJUAN1").clone(true).removeAttr('id').attr('id','SUBRAK_TUJUAN'+cnt)	
			.removeAttr('name').attr('name','SRAK_TUJUAN['+cnt+'][]')
			.appendTo('#sraktuju'+cnt+' #sraktuju'+cnt);

			$("#TAMBAH_GUDANG").removeAttr('onclick').attr('onclick','gudang_all('+cnt+')');
		}else{
			jAlert("Maksimal "+jumall+" pilihan.<br>Gudang tujuan hanya punya "+jumall+" Gudang","PLB Inventory");return false;  
		}
	}
	
	function gudang_list(urut){
		var no = $("tr.child").length+1; 
		//var rand = GetRandomMath()+1;			
		var jumall = <?= count($KODE_GUDANG) ?>;
		var urutid = (urut+'-'+no);
		var cnt = urut + 1; 
		if((no)!=jumall){
			var html = '<tr id="tr-'+cnt+'" class="child">\
							<td class="alt"><span class="nopx"></span></td>\
							<td class="alt" style="border-right:none;"></td>\
							<td class="alt" style="border-left:none; border-right:none;"></td>\
							<td class="alt" style="border-left:none; border-right:none;"></td>\
							<td class="alt" style="border-left:none; border-right:none;"></td>\
							<td class="alt" style="border-left:none;"></td>\
							<td class="alt" id="kdgtuju'+cnt+'" style="border-right:none;background-color:#F6F6E0"><combo id="gdtuju'+cnt+'"></combo></td>\
							<td class="alt" id="kondisituju'+cnt+'" style="border-left:none;border-right:none;background-color:#F6F6E0"><combo id="kdtuju'+cnt+'"></td>\
							<td class="alt" style="border-left:none; border-right:none;background-color:#F6F6E0" id="raktuju'+cnt+'"><combo id="raktuju'+cnt+'"></combo></td>\
							<td class="alt" style="border-left:none; border-right:none;background-color:#F6F6E0" id="sraktuju'+cnt+'"><combo id="sraktuju'+cnt+'"></combo></td>\
							<td class="alt" style="border-left:none;border-right:none;background-color:#F6F6E0"><input type="text" name="JUMLAH_TUJUAN['+urut+'][]" id="JUMLAH_TUJUAN'+cnt+'"  class="stext" style="text-align:right;" wajib="yes" onKeyPress="return intInput(event, /[.0-9]/)"/>\
							<td class="alt" style="border-left:none;background-color:#F6F6E0"><a style="color:#DF4B33;font-size:22px;cursor:pointer" onclick="hapus_gudangrow('+cnt+')"><i class="fa fa-minus-circle"></i></a></td></tr>';
			$("#tr-"+urut).after(html);
			
			$("#GUDANG_TUJUAN1").clone(true).removeAttr('id').attr('id','GUDANG_TUJUAN'+cnt)
			.removeAttr('onChange').attr('onChange','getRak('+cnt+',\'tuju\')')	
			.removeAttr('name').attr('name','GUDANG_TUJUAN['+urut+'][]')
			.appendTo('#kdgdtujuan'+cnt+' #gdtujuan'+cnt);
			
			$("#KONDISI_TUJUAN1").clone(true).removeAttr('id').attr('id','KONDISI_TUJUAN'+cnt)	
			.removeAttr('name').attr('name','KONDISI_TUJUAN['+urut+'][]')
			.appendTo('#kondisitujuan'+cnt+' #kdtujuan'+cnt);

			$("#RAK_TUJUAN1").clone(true).removeAttr('id').attr('id','RAK_TUJU'+cnt)	
			.removeAttr('name').attr('name','RAK_TUJU['+urut+'][]')
			.appendTo('#raktuju'+cnt+' #raktuju'+cnt);

			$("#SUBRAK_TUJUAN1").clone(true).removeAttr('id').attr('id','SUBRAK_TUJU'+cnt)	
			.removeAttr('name').attr('name','SRAK_TUJU['+urut+'][]')
			.appendTo('#sraktuju'+cnt+' #sraktuju'+cnt);

			$("#TAMBAH_GUDANG").removeAttr('onclick').attr('onclick','gudang_all('+cnt+')');
		}else{
			jAlert("Maksimal "+jumall+" pilihan.<br>Gudang tujuan hanya punya "+jumall,"PLB Inventory");return false;  
		}			
	}
	
	function hapus_gudangrow(no){
	  $("#tr-"+no).remove();
		$("#tbl-gudang tbody tr .nop").each(function(index, element) {
			$(this).html(parseFloat(index)+1);
		});	
	}

	function getRak(id,target,value){
		var kdGudang = $("#gd"+target+id+" #GUDANG_"+target.toUpperCase()+id).val();
		var kdBarang = "<?=$KODE_BARANG?>";
		var jnsbrg = "<?=$JNS_BARANG?>";
		$.ajax({
			type: 'post',
			url: site_url + '/inventory/getRak/pindah_gudang',
			data: {kode_gudang:kdGudang,tdId:id,trget:target,kdbarang:kdBarang,jnsBrg:jnsbrg,kondisi_barang:value},
			success: function(data) {
				$("table#tbl-gudang td#rak"+target+id).html(data);  
			}
		});
		
	}

	function getKondisi(id,target){
		var kdGudang = $("#gd"+target+id+" #GUDANG_"+target.toUpperCase()+id).val();
		var kdBarang = "<?=$KODE_BARANG?>";
		var jnsbrg = "<?=$JNS_BARANG?>";
		$.ajax({
			type: 'post',
			url: site_url + '/inventory/getKondisi/pindah_gudang',
			data: {kode_gudang:kdGudang,tdId:id,trget:target,kdbarang:kdBarang,jnsBrg:jnsbrg},
			success: function(data) {
				$("table#tbl-gudang td#kondisi"+target+id).html(data);  
			}
		});
		
	}

	function getSubrakPindah(id,target,value){
		var kdGudang = $("#gd"+target+id+" #GUDANG_"+target.toUpperCase()+id).val();
		var kondisi = $("#kondisi"+target+id+" #KONDISI_"+target.toUpperCase()+id).val();
		var kdBarang = "<?=$KODE_BARANG?>";
		var jnsbrg = "<?=$JNS_BARANG?>";
		$.ajax({
			type: 'post',
			url: site_url + '/inventory/getSubrak/pindah_gudang',
			data: {kode_gudang:kdGudang,kondisi:kondisi,tdId:id,trget:target,kdbarang:kdBarang,jnsBrg:jnsbrg,kode_rak:value},
			success: function(data) {
				$("table#tbl-gudang td#srak"+target+id).html(data);  
			}
		});
		
	}
</script>