<div class="header">
	<h3><?= $judul;?></h3>
</div>
<div class="content">
<input type="hidden" id="type" name="type" value="<?= $type;?>"/>
<form name="f_cariListProd" id="f_cariListProd" action="<?php echo site_url('produksi/getListProd')?>" method="post">
<table class="tabelPopUp" width="100%">
<tr>	
    <td align="right">
    <select name="TIPE_CARI" id="TIPE_CARI">
        <option value="NOMOR_PROSES">Nomor Proses</option>
    </select>
    <input type="text" name="URAI_CARI" id="URAI_CARI" class="tb_cari">
    <input type="button" name="cari" id="cari" class="btn" onclick="cariData()" value="Cari">
    </td>
</tr>
</table>
</form>
<div id="dataListPopProd" style="display:none"></div>
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
      url: site_url+"/produksi/getListProd",
      type: "POST",
      data: {index:1,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
	  success:function(data)
	  {
		$('#dataListPopProd').show();
		$('#dataListPopProd').html(data);
	  }
    });

}

function loadData(index)
{
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
    $.ajax({
      url: site_url+"/produksi/getListProd",
      type: "POST",
      data: {index:1,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
  	  success:function(data)
  		{
			$('#dataListPopProd').show();
			$('#dataListPopProd').html(data);
  		}
    });

}
function get_next_data(index)
{
	var type=$("#type").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
    $.ajax({
      url: site_url+"/produksi/getListProd",
      type: "POST",
      data: {index:index,type:type,typeCari:typeCari,uraiCari:uraiCari},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
		success:function(data)
		{
			$('#dataListPopProd').show();
			$('#dataListPopProd').html(data);
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
      url: site_url+"/produksi/getListProd",
	type: "POST",
	data: {index:index,type:type,typeCari:typeCari,uraiCari:uraiCari},
	beforeSend: function(){jloadings();},
	complete: function(){Clearjloadings();},
		success:function(data)
		{
			$('#dataListPopProd').show();
			$('#dataListPopProd').html(data);
		}
	});

}

function getPopupProd(nomorProses){
	document.fHasilProdDet.NOMOR_PROSES_ASAL.value = nomorProses;
	closedialog('divHasilProd');
}
function getPopupSisa(nomorProses){
	document.fHasilSisaDet.NOMOR_PROSES_ASAL.value = nomorProses;
	closedialog('divHasilSisa');
}

</script>