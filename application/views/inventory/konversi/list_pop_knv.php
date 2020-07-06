<div class="content_luar">
<div class="content_dalam">
<h4><span class="info_2">&nbsp;</span><?= $judul;?></h4>
<input type="hidden" id="type" name="type" value="<?= $type;?>"/>
<form name="f_cariListInv" id="f_cariListInv" action="<?php echo site_url('inventory/getPopKnv')?>" method="post">
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
<div id="dataListPopKnv" style="display:none"></div>
</div>
</div>
<script>
// JavaScript Document
$(document).ready(function(){
	loadData();
});
function cariData()
{
	  //alert(aju+'\n'+seri);//return false;
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();//alert('sini');
    $.ajax({
      url: site_url+"/inventory/getPopKnv",
      type: "POST",
      data: {index:1,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
	  success:function(data)
	  {
		$('#dataListPopKnv').show();
		$('#dataListPopKnv').html(data);
	  }
    });

}

function loadData(index)
{
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
    $.ajax({
      url: site_url+"/inventory/getPopKnv",
      type: "POST",
      data: {index:1,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
  	  success:function(data)
  		{
			$('#dataListPopKnv').show();
			$('#dataListPopKnv').html(data);
  		}
    });

}
function get_next_data(index)
{
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
	$('#divLoading').html('<img src="'+base_url+'images/loading.gif">');  
    $.ajax({
      url: site_url+"/inventory/getPopKnv",
      type: "POST",
      data: {index:index,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
		success:function(data)
		{
			$('#dataListPopKnv').show();
			$('#dataListPopKnv').html(data);
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
	$('#divLoading').html('<img src="'+base_url+'images/loading.gif">');   
	$.ajax({
	url: site_url+"/inventory/getPopKnv",
	type: "POST",
	data: {index:index,type:type,typeCari:typeCari,uraiCari:uraiCari},
	beforeSend: function(){jloadings();},
	complete: function(){Clearjloadings();},
		success:function(data)
		{
			$('#dataListPopKnv').show();
			$('#dataListPopKnv').html(data);
		}
	});

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
	$('#uraisatknv').append(UrSat);
	closedialog('divKonvBB');
		 
}
function getPopupSubKnv(kodeBrg,UrBrg,UrJns,kodeJns,Mrk,Tpe,Ukrn,Spf,kdSat,UrSat){
	//alert(kodeBrg);return false;
	 
	document.fKonvSub.KODE_BARANG.value = kodeBrg;
	document.fKonvSub.URAIAN_BARANG.value = UrBrg;
	document.fKonvSub.JENIS_BARANG.value = UrJns;
	document.fKonvSub.JNS_BARANG.value = kodeJns;
	document.fKonvSub.MERK.value = Mrk;
	document.fKonvSub.TIPE.value = Tpe;
	document.fKonvSub.UKURAN.value = Ukrn;
	document.fKonvSub.SPF.value = Spf;
	document.fKonvSub.KODE_SATUAN.value = kdSat;
	document.fKonvSub.URAIAN_SATUAN.value = UrSat;
	$('#uraisatSubknv').append(UrSat);
	closedialog('divKonvSubBB');
		 
}
</script>