<div class="content_luar">
<div class="content_dalam">
<h4><span class="info_2">&nbsp;</span><?= $judul;?></h4>
<input type="hidden" id="type" name="type" value="<?= $type;?>"/>
<form name="f_cariListInv" id="f_cariListInv" action="<?php echo site_url('inventory/getListInv')?>" method="post">
<table class="tabelPopUp" width="100%">
<tr>	
    <td align="right">
    <select name="TIPE_CARI" id="TIPE_CARI">
        <option value="KODE_BARANG">Kode Barang</option>
        <option value="URAIAN_BARANG">Uraian Barang</option>
    </select>
    <input type="text" name="URAI_CARI" id="URAI_CARI" class="tb_cari">
    <input type="button" name="cari" id="cari" class="btn" onclick="cariData()" value="Cari">
    </td>
</tr>
</table>
</form>
<div id="dataListInv" style="display:none"></div>
</div>
</div>
<script>
// JavaScript Document
$(document).ready(function(){
	loadData('<?= $type?>','<?= $jenis?>');
});
function cariData()
{
	  //alert(aju+'\n'+seri);//return false;
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();//alert('sini');
    $.ajax({
      url: site_url+"/inventory/getListInv",
      type: "POST",
      data: {index:1,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
	  success:function(data)
	  {
		$('#dataListInv').show();
		$('#dataListInv').html(data);
	  }
    });

}
function loadData(index)
{
	  //alert($("#type").val());//return false;
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
    $.ajax({
      url: site_url+"/inventory/getListInv",
      type: "POST",
      data: {index:1,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
	  success:function(data)
	  {
		$('#dataListInv').show();
		$('#dataListInv').html(data);
	  }
    });

}
function get_next_data(index)
{
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();//alert(typeCari+'/n'+uraiCari);//return false;
    $.ajax({
      url: site_url+"/inventory/getListInv",
      type: "POST",
      data: {index:index,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
	  success:function(data)
		{
			$('#dataListInv').show();
			$('#dataListInv').html(data);
		}
    });

}
function goToPage()
{
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
	var index =  $("input#txtGoTo").val();
	index = parseInt(index);
	$.ajax({
	url: site_url+"/inventory/getListInv",
	type: "POST",
	data: {index:index,type:type,typeCari:typeCari,uraiCari:uraiCari},
	beforeSend: function(){jloadings();},
	complete: function(){Clearjloadings();},
	success:function(data)
		{
			$('#dataListInv').show();
			$('#dataListInv').html(data);
		}
	});

}
function getPopupRealInv(kodeBrg,UrBrg,UrJns,kodeJns){
	//alert(kodeBrg);return false;
	var kode_Brg= kodeBrg;
	var Ur_Brg = UrBrg;
	var Ur_Jns = UrJns;
	var kode_Jns = kodeJns;
	 
	document.fstock.KODE_BARANG.value = kodeBrg;
	document.fstock.URAIAN_BARANG.value = UrBrg;
	document.fstock.JENIS_BARANG.value = Ur_Jns;
	document.fstock.JNS_BARANG.value = kode_Jns;
	closedialog('divStock');
}
function getPopupRealKnv(kodeBrg,UrBrg,UrJns,kodeJns,Mrk,Tpe,Ukrn,Spf,kdSat,UrSat){
	//alert(kodeBrg);return false;
	var form="fkonvdet";
	var KodeSatuan=($("#"+form+" #KODE_SATUAN").val());
	if(KodeSatuan==""){
		$('#uraisatdet').append(UrSat);
	}else{
		$('#uraisatdet').empty().append(UrSat);
	}
	document.fkonvdet.KODE_BARANG.value = kodeBrg;
	document.fkonvdet.URAIAN_BARANG.value = UrBrg;
	document.fkonvdet.JENIS_BARANG.value = UrJns;
	document.fkonvdet.JNS_BARANG.value = kodeJns;
	document.fkonvdet.MERK.value = Mrk;
	document.fkonvdet.TIPE.value = Tpe;
	document.fkonvdet.UKURAN.value = Ukrn;
	document.fkonvdet.SPF.value = Spf;
	document.fkonvdet.KODE_SATUAN.value = kdSat;
	document.fkonvdet.URAIAN_SATUAN.value = UrSat;
	closedialog('divKonv');
}
function getPopupRealKnvSub(kodeBrg,UrBrg,UrJns,kodeJns,Mrk,Tpe,Ukrn,Spf,kdSat,UrSat){
	var form="fkonvsubdet";
	var KodeSatuan=($("#"+form+" #KODE_SATUAN").val());
	if(KodeSatuan==""){
		$('#uraisatdet').append(UrSat);
	}else{
		$('#uraisatdet').empty().append(UrSat);
	}
	document.fkonvsubdet.KODE_BARANG.value = kodeBrg;
	document.fkonvsubdet.URAIAN_BARANG.value = UrBrg;
	document.fkonvsubdet.JENIS_BARANG.value = UrJns;
	document.fkonvsubdet.JNS_BARANG.value = kodeJns;
	document.fkonvsubdet.MERK.value = Mrk;
	document.fkonvsubdet.TIPE.value = Tpe;
	document.fkonvsubdet.UKURAN.value = Ukrn;
	document.fkonvsubdet.SPF.value = Spf;
	document.fkonvsubdet.KODE_SATUAN.value = kdSat;
	document.fkonvsubdet.URAIAN_SATUAN.value = UrSat;
	closedialog('divKonvSub');
}
function getPopupKnv(kodeBrg,UrBrg,UrJns,kodeJns,Mrk,Tpe,Ukrn,Spf,kdSat,UrSat){
	//alert(kodeBrg);return false;
	document.fKonv.KODE_BARANG.value = kodeBrg;
	document.fKonv.URAIAN_BARANG.value = UrBrg;
	document.fKonv.JENIS_BARANG.value = UrJns;
	document.fKonv.JNS_BARANG.value = kodeJns;
	document.fKonv.MERK.value = Mrk;
	document.fKonv.TIPE.value = Tpe;
	document.fKonv.UKURAN.value = Ukrn;
	document.fKonv.SPF.value = Spf;
	document.fKonv.KODE_SATUAN.value = kdSat;
	document.fKonv.URAIAN_SATUAN.value = UrSat;
	closedialog('divKonvBB');
}
function getPopupBB(kodeBrg,UrBrg,UrJns,kodeJns,kdSat,UrSat){
	//alert(kdSat);return false;
	var form="fBahanBaku";
	var KodeSatuan=($("#"+form+" #KODE_SATUAN").val());
	if(KodeSatuan==""){
		$('#uraisatdet').append(UrSat);
	}else{
		$('#uraisatdet').empty().append(UrSat);
	}
	document.fBahanBaku.KODE_BARANG.value = kodeBrg;
	document.fBahanBaku.URAIAN_BARANG.value = UrBrg;
	document.fBahanBaku.JENIS_BARANG.value = UrJns;
	document.fBahanBaku.JNS_BARANG.value = kodeJns;
	document.fBahanBaku.KODE_SATUAN.value = kdSat;
	//document.fBahanBaku.URAIAN_SATUAN.value = UrSat;
	closedialog('divBahanBaku');
}
function getPopupProd(kodeBrg,UrBrg,UrJns,kodeJns,kdSat,UrSat){
	var form="fHasilProduksi";
	var KodeSatuan=($("#"+form+" #KODE_SATUAN").val());
	if(KodeSatuan==""){
		$('#uraisatdet').append(UrSat);
	}else{
		$('#uraisatdet').empty().append(UrSat);
	}
	document.fHasilProduksi.KODE_BARANG.value = kodeBrg;
	document.fHasilProduksi.URAIAN_BARANG.value = UrBrg;
	document.fHasilProduksi.JENIS_BARANG.value = UrJns;
	document.fHasilProduksi.JNS_BARANG.value = kodeJns;
	document.fHasilProduksi.KODE_SATUAN.value = kdSat;
	closedialog('divProsesProd');
}
function getPopupSisa(kodeBrg,UrBrg,UrJns,kodeJns,kdSat,UrSat){
	
	var form="fHasilSisa";
	var KodeSatuan=($("#"+form+" #KODE_SATUAN").val());
	if(KodeSatuan==""){
		$('#uraisatdet').append(UrSat);
	}else{
		$('#uraisatdet').empty().append(UrSat);
	}
	document.fHasilSisa.KODE_BARANG.value = kodeBrg;
	document.fHasilSisa.URAIAN_BARANG.value = UrBrg;
	document.fHasilSisa.JENIS_BARANG.value = UrJns;
	document.fHasilSisa.JNS_BARANG.value = kodeJns;
	document.fHasilSisa.KODE_SATUAN.value = kdSat;
	closedialog('divProsesSisa');
}
function getPopupPengrusakan(kodeBrg,UrBrg,kdSat,UrSat,UrJns,kodeJns){
	//alert(kdSat);return false;
	document.fpengrusakan.KODE_BARANG.value = kodeBrg;
	document.fpengrusakan.URAIAN_BARANG.value = UrBrg;
	document.fpengrusakan.JENIS_BARANG.value = UrJns;
	document.fpengrusakan.JNS_BARANG.value = kodeJns;
	document.fpengrusakan.KODE_SATUAN.value = kdSat;
	//document.fpengrusakan.URAIAN_SATUAN.value = UrSat;
	$('#ursatuan').append(UrSat);
	closedialog('divPengrusakan');
}

function getPopupPemusnahan(kodeBrg,UrBrg,kdSat,UrSat,UrJns,kodeJns){
	//alert(kdSat);return false;
	document.fpemusnahan.KODE_BARANG.value = kodeBrg;
	document.fpemusnahan.URAIAN_BARANG.value = UrBrg;
	document.fpemusnahan.JENIS_BARANG.value = UrJns;
	document.fpemusnahan.JNS_BARANG.value = kodeJns;
	document.fpemusnahan.KODE_SATUAN.value = kdSat;
	//document.fpemusnahan.URAIAN_SATUAN.value = UrSat;
	$('#ursatuan').append(UrSat);
	closedialog('divPemusnahan');
}

function getPopupMapping(kodeBrg,UrBrg,kdSat,UrSat,UrJns,kodeJns,merk){
	//alert(kdSat);return false;
	document.fMapp.KODE_BARANG.value = kodeBrg;
	document.fMapp.URAIAN_BARANG.value = UrBrg;
	document.fMapp.JENIS_BARANG.value = UrJns;
	document.fMapp.JNS_BARANG.value = kodeJns;
	document.fMapp.MERK.value = merk;
	//document.fMapp.KODE_SATUAN.value = kdSat;
	//document.fpemusnahan.URAIAN_SATUAN.value = UrSat;
	$('#ursatuan').append(UrSat);
	closedialog('divMapping');
}
</script>