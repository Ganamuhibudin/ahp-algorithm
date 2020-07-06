<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<h5 class="header smaller lighter green"><strong>Dokumen <?=strtoupper($DOKUMEN)?></strong></h5>
<form name="fdokin_" id="fdokin_" action="<?= site_url()."/realisasi/getDokIn" ?>" method="post" autocomplete="off">
	<input type="hidden" name="KODE_BARANG_DOK" id="KODE_BARANG_DOK" value="<?=$KODE_BARANG?>" readonly />
	<input type="hidden" name="JNS_BARANG_DOK" id="JNS_BARANG_DOK" value="<?=$JNS_BARANG?>" readonly />
	<input type="hidden" name="JUM_SAT" id="JUM_SAT" value="<?=$JUMLAH_SATUAN?>" readonly />
	<input type="hidden" name="SERI_BARANG_DOK" id="SERI_BARANG_DOK" value="<?=$SERI?>" readonly />
	<input type="hidden" name="NOMOR_AJU_DOK" id="NOMOR_AJU_DOK" value="<?=$AJU?>" readonly />
	<input type="hidden" name="DOKUMEN" id="DOKUMEN" value="<?=$DOKUMEN?>" readonly />
	<input type="hidden" name="LOGID_TEMP" id="LOGID_TEMP" readonly />
	<input type="hidden" name="act" id="act" value="save" readonly />
    <table width="100%" class="tabelPopUp">
        <tr>
            <td width="21%">Nomor Aju</td>
            <td width="79%">: <?= $this->fungsi->FormatAju($AJU)?></td>
        </tr>
        <tr>
            <td width="21%">Kode Barang</td>
            <td width="79%">: <?=$KODE_BARANG?></td>
        </tr>
        <tr>
            <td width="21%">Jenis Barang</td>
            <td width="79%">: <?=$JENIS_BARANG?></td>
        </tr>
        <tr>
            <td width="21%">Seri Barang</td>
            <td width="79%">: <?=$SERI?></td>
        </tr>
        <tr>
            <td width="21%">Jumlah Satuan</td>
            <td width="79%">: <?=number_format($JUMLAH_SATUAN,2)?></td>
        </tr>
    </table><br />
    <table id="tbldokin" class="tabelajax" width="70%">      
        <tbody>
            <tr class="thead">
            	<th>Jenis Dokumen</th>
                <th>No Dok Masuk</th>
                <th>Tgl Dok Masuk</th>
                <th>Saldo Awal</th>
                <th>Sisa Saldo</th>
                <th>Jumlah</th>
                <th>Action</th>
            </tr>
            <?php
			if(!$resultData){
			?>
            <tr class="parent" id="tr-1">
            	<td id="jns-dok-1">
                	<input id="JENIS_DOK_MASUK_1" type="text" readonly name="DOKIN[JENIS_DOK_MASUK][]" style="border-style: none;background-color: transparent; width:100%" onfocus="getLOGID(1);">
                    <input id="SERI_BARANG_MASUK_1" type="hidden" readonly name="DOKIN[SERI_BARANG_MASUK][]" />
                </td>
                <td id="no-dok-1">
                	<input id="NO_DOK_MASUK_1" type="text" readonly name="DOKIN[NO_DOK_MASUK][]" style="border-style: none;background-color: transparent; width:100%">
                    <input id="LOGID_MASUK_1" type="hidden" readonly name="DOKIN[LOGID_MASUK][]" />
                </td>
                <td id="tgl-dok-1">
                	<input id="TGL_DOK_MASUK_1" type="text" readonly name="DOKIN[TGL_DOK_MASUK][]" style="border-style: none;background-color: transparent; width:100%">
                </td>
                <td id="saldo-awal-1">
                	<input id="SALDO_AWAL_1" type="text" readonly style="border-style: none;background-color: transparent; width:100%">
                </td>
                <td id="sisa-saldo-1">
                	<input id="SISA_SALDO_1" type="text" readonly style="border-style: none;background-color: transparent; width:100%">
                </td>
                <td id="jumlah-1">
                	<input id="JUMLAH_MASUK_1" type="text" name="DOKIN[JUMLAH_MASUK][]" class="stext date" wajib="yes" style="padding:0px 5px 0px 5px;" onkeypress="return intInput(event, /[.0-9]/)" key="jumlah" onChange="getTotal(1);" onMouseOver="getTotal(1);">
               	</td>
                <td width="20%" align="center" id="button-1">
                	<a href="javascript:void(0)" id="btn-search-1" class="btn btn-primary btn-sm" title="Cari Dokumen Pemasukan" onClick="tb_searchtwo('search/getsearch_two/dok_in','JENIS_DOK_MASUK_1;SERI_BARANG_MASUK_1;NO_DOK_MASUK_1;LOGID_MASUK_1;TGL_DOK_MASUK_1;SALDO_AWAL_1;SISA_SALDO_1','Pencarian Nomor Dokumen Masuk','fdokin_',60,500,'KODE_BARANG_DOK;JNS_BARANG_DOK;LOGID_TEMP;');" >&nbsp;<i class="icon-search"></i></a>&nbsp;
                	<a href="javascript:void(0)" id="btn-add-1" class="btn btn-success btn-sm" title="Tambah Dokumen Pemasukan" onClick="addRow(1)">&nbsp;<i class="icon-plus"></i></a>
                </td>
            </tr>
            <?php 
			}else{
				$no = 1; 
				foreach($resultData as $data){
					if($no==1){
						$class = 'parent';
						$i = $no;
					}else{
						$i = $no+1;
						$class = 'child';
					}
					echo '<tr  class="'.$class.'" id="tr-'.$i.'">';
					echo '<td id="jns-dok-'.$i.'"><input id="JENIS_DOK_MASUK_'.$i.'" type="text" value="'.$data["JENIS_DOK_MASUK"].'" readonly name="DOKIN[JENIS_DOK_MASUK][]" style="border-style: none;background-color: transparent; width:100%" onfocus="getLOGID('.$i.');"><input id="SERI_BARANG_MASUK_'.$i.'" type="hidden" readonly name="DOKIN[SERI_BARANG_MASUK][]" value="'.$data["SERI_BARANG_MASUK"].'" /></td>';
					echo '<td id="no-dok-'.$i.'"><input id="NO_DOK_MASUK_'.$i.'" type="text" readonly name="DOKIN[NO_DOK_MASUK][]" style="border-style: none;background-color: transparent; width:100%" value="'.$data["NO_DOK_MASUK"].'"><input id="LOGID_MASUK_'.$i.'" type="hidden" readonly name="DOKIN[LOGID_MASUK][]" value="'.$data["LOGID_MASUK"].'" /></td>';
					echo '<td id="tgl-dok-'.$i.'"><input id="TGL_DOK_MASUK_'.$i.'" type="text" readonly name="DOKIN[TGL_DOK_MASUK][]" style="border-style: none;background-color: transparent; width:100%" value="'.$data["TGL_DOK_MASUK"].'"></td>';
					echo '<td id="saldo-awal-'.$i.'"><input id="SALDO_AWAL_'.$i.'" type="text" readonly style="border-style: none;background-color: transparent; width:100%" value="'.$data["SALDO_AWAL"].'"></td>';
					echo '<td id="sisa-saldo-'.$i.'"><input id="SISA_SALDO_'.$i.'" type="text" readonly style="border-style: none;background-color: transparent; width:100%" value="'.$data["SISA_SALDO"].'"></td>';
					echo '<td id="jumlah-'.$i.'"><input id="JUMLAH_MASUK_'.$i.'" type="text" name="DOKIN[JUMLAH_MASUK][]" class="stext date" wajib="yes" style="padding:0px 5px 0px 5px;" onkeypress="return intInput(event, /[.0-9]/)" key="jumlah" onChange="getTotal('.$i.');" onMouseOver="getTotal('.$i.');" value="'.$data["JUMLAH_MASUK"].'" /></td>';
					if($no==1){
						echo '<td width="20%" align="center" id="button-'.$i.'"><a href="javascript:void(0)" id="btn-search-'.$i.'" class="btn btn-primary btn-sm" title="Cari Dokumen Pemasukan" onClick="tb_searchtwo(\'search/getsearch_two/dok_in\',\'JENIS_DOK_MASUK_'.$i.';SERI_BARANG_MASUK_'.$i.';NO_DOK_MASUK_'.$i.';LOGID_MASUK_'.$i.';TGL_DOK_MASUK_'.$i.';SALDO_AWAL_'.$i.';SISA_SALDO_'.$i.'\',\'Pencarian Nomor Dokumen Masuk\',\'fdokin_\',60,500,\'KODE_BARANG_DOK;JNS_BARANG_DOK;LOGID_TEMP;\');" >&nbsp;<i class="icon-search"></i></a>&nbsp;<a href="javascript:void(0)" id="btn-add-'.$i.'" class="btn btn-success btn-sm" title="Tambah Dokumen Pemasukan" onClick="addRow('.$i.')">&nbsp;<i class="icon-plus"></i></a></td>';
					}else{
						echo '<td align="center" id="button-'.$i.'"><a title="Cari Dokumen Pemasukan" class="btn btn-primary btn-sm" href="javascript:void(0)" id="btn-search-'.$i.'" onclick="tb_searchtwo(\'search/getsearch_two/dok_in\',\'JENIS_DOK_MASUK_'.$i.';SERI_BARANG_MASUK_'.$i.';NO_DOK_MASUK_'.$i.';LOGID_MASUK_'.$i.';TGL_DOK_MASUK_'.$i.';SALDO_AWAL_'.$i.';SISA_SALDO_'.$i.'\',\'Pencarian Nomor Dokumen Masuk\',\'fdokin_\',60,500,\'KODE_BARANG_DOK;JNS_BARANG_DOK;LOGID_TEMP;\')">&nbsp;<i class="icon-search"></i></a>&nbsp;<a href="javascript:void(0)" id="btn-add-'.$i.'" class="btn btn-danger btn-sm" onclick="delPemasukan('.$i.')" title="Hapus Data">&nbsp;<i class="icon-trash"></i></a></td>';
					}
					echo '</tr>';
					$no++;
				}
			} 
			?>
        </tbody>
    </table>
    <div class="button" style="padding-top:10px;">
    	<a href="javascript:void(0);" class="btn btn-success btn-m" onClick="save_dokin('#fdokin_','msgdokin_');"><i class="icon-save"></i>&nbsp;Save</a>
        <a href="javascript:void(0);" class="btn btn-warning btn-m" ><i class="icon-remove"></i>&nbsp;Cancel</a>
        <span class="msgdokin_"></span>
    </div>
    <div style="margin-top:10px;" class="red">
    	* Note : Total Inputan Jumlah tidak boleh melebihi Jumlah satuan pada detil barang.
    </div>
</form>
<script type="text/javascript">
	function addRow(id){
		var jmlRow = parseFloat(id);
		var x = parseFloat($('#fdokin_ #tbldokin tr').length);
		var no = parseFloat($('#fdokin_ #tbldokin tr').length)+1;
		var html = "<tr id='tr-"+no+"' class='child'>";
		html += '<td id="jns-dok-'+no+'">&nbsp;</td>';
		html += '<td id="no-dok-'+no+'">&nbsp;</td>';
	 	html += '<td id="tgl-dok-'+no+'">&nbsp;</td>';
	 	html += '<td id="saldo-awal-'+no+'">&nbsp;</td>';
	 	html += '<td id="sisa-saldo-'+no+'">&nbsp;</td>';
	 	html += '<td id="jumlah-'+no+'">&nbsp;</td>';
	 	html += '<td id="button-'+no+'" align="center">&nbsp;</td>';
		
		if(no==3){
			$("#tr-1").after(html);
		}else{
			$("#tr-"+x).after(html);
		}
			
		var xJnsDok = $("#jns-dok-1").html();
		var xNoDok = $("#no-dok-1").html();
		var xTglDok = $("#tgl-dok-1").html();
		var xSaldoAwal = $("#saldo-awal-1").html();
		var xSisaSaldo = $("#sisa-saldo-1").html();
		var xJumlah = $("#jumlah-1").html();
		var xButton = $("#button-1").html();
		
		xJnsDok = xJnsDok.replace("jns-dok-1", "jns-dok-"+no);
		xNoDok = xNoDok.replace("no-dok-1", "no-dok-"+no);
		xTglDok = xTglDok.replace("tgl-dok-1", "tgl-dok-"+no);
		xSaldoAwal = xSaldoAwal.replace("saldo-awal-1", "saldo-awal-"+no);
		xSisaSaldo = xSisaSaldo.replace("sisa-saldo-1", "sisa-saldo-"+no);
		xJumlah = xJumlah.replace("jumlah-1", "jumlah-"+no);
		xButton = xButton.replace("button-1", "button-"+no);
		
		$("#jns-dok-"+no).html(xJnsDok);
		$("#no-dok-"+no).html(xNoDok);
		$("#tgl-dok-"+no).html(xTglDok);
		$("#saldo-awal-"+no).html(xSaldoAwal);
		$("#sisa-saldo-"+no).html(xSisaSaldo);
		$("#jumlah-"+no).html(xJumlah);
		$("#button-"+no).html(xButton);
		
		$("#jns-dok-"+no+" input[type=text]").removeAttr("id").attr("id","JENIS_DOK_MASUK_"+no).removeAttr('onFocus').attr('onFocus','getLOGID('+no+')').removeAttr('value');
		$("#jns-dok-"+no+" input[type=hidden]").removeAttr("id").attr("id","SERI_BARANG_MASUK_"+no).removeAttr('value');
		$("#no-dok-"+no+" input[type=text]").removeAttr("id").attr("id","NO_DOK_MASUK_"+no).removeAttr('value');
		$("#no-dok-"+no+" input[type=hidden]").removeAttr("id").attr("id","LOGID_MASUK_"+no).removeAttr('value');
		$("#tgl-dok-"+no+" input[type=text]").removeAttr("id").attr("id","TGL_DOK_MASUK_"+no).removeAttr('value');
		$("#saldo-awal-"+no+" input[type=text]").removeAttr("id").attr("id","SALDO_AWAL_"+no).removeAttr('value');
		$("#sisa-saldo-"+no+" input[type=text]").removeAttr("id").attr("id","SISA_SALDO_"+no).removeAttr('value');
		$("#jumlah-"+no+" input[type=text]").removeAttr("id").attr("id","JUMLAH_MASUK_"+no).removeAttr('onChange').attr('onChange','getTotal('+no+');').removeAttr('onMouseOver').attr('onMouseOver','getTotal('+no+');').removeAttr('value');
		
		$("#button-"+no+" #btn-search-1").removeAttr("id").attr("id","btn-search-"+no).removeAttr("onClick").attr("onCLick","tb_searchtwo('search/getsearch_two/dok_in','JENIS_DOK_MASUK_"+no+";SERI_BARANG_MASUK_"+no+";NO_DOK_MASUK_"+no+";LOGID_MASUK_"+no+";TGL_DOK_MASUK_"+no+";SALDO_AWAL_"+no+";SISA_SALDO_"+no+"','Pencarian Nomor Dokumen Masuk','fdokin_',60,500,'KODE_BARANG_DOK;JNS_BARANG_DOK;LOGID_TEMP;')");
		$("#button-"+no+" #btn-add-1").removeAttr("id").attr("id","btn-add-"+no).removeAttr("class").attr("class","btn btn-danger btn-sm").removeAttr("onclick").attr("onClick","delPemasukan("+no+")").removeAttr("title").attr("title","Hapus Data");
		$("#button-"+no+" #btn-add-"+no+" i").removeAttr("class").attr("class","icon-trash");
	}
	
	function delPemasukan(id){
		var valTemp = $('#LOGID_TEMP').val();
		valTemp = multiReplace(valTemp, ',' + $('#LOGID_MASUK_' + id).val(), '');
		$('#LOGID_TEMP').val(valTemp);
		$("#tr-"+id).remove();
	}
	
	function getLOGID(id){
		var valTemp = $('#LOGID_TEMP').val();
		valTemp = multiReplace(valTemp, ',' + $('#LOGID_MASUK_' + id).val(), '');
        valTemp = valTemp + ',' + $('#LOGID_MASUK_' + id).val();
		$('#LOGID_TEMP').val(valTemp);
	}
	
	function getTotal(id){
		var jumInput   = parseFloat($("#JUMLAH_MASUK_"+id).val());
		var jumDokumen = parseFloat($("#SISA_SALDO_"+id).val());
		if(jumInput > jumDokumen){
			jAlert('Jumlah Satuan melebihi sisa saldo yang Ada.\n Sisal saldo yang ada adalah : <b>'+jumDokumen+'</b>','PLB Inventory');
			$("#JUMLAH_MASUK_"+id).val(jumDokumen);
		}
	}
	
	function save_dokin(formid,msg){
		if(validasi(msg,formid)){
			$.ajax({
				type: 'POST',
				url: $(formid).attr('action'),
				data: $(formid).serialize(),
				success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							$("."+msg).css('color', 'green');
							$("."+msg).html(arrdata[2]);
						}else{
							$("."+msg).css('color', 'red');
							$("."+msg).html(arrdata[2]);
						}
						Clearjloadings();
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html('Proses Gagal.');
						Clearjloadings();
					}
				}
			});	
		}return false;	
	}
</script>