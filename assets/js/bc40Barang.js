// JavaScript Document
$(document).ready(function(){
	var JenisTarif = $('#KD_TRF_CUKAI').val();	
	var JenisTarifBm = $('#KD_TRF_BM').val();
	if(JenisTarif == 2)
		tarif(JenisTarif);
	if(JenisTarifBm == 2){
		$('#bmHidden').show();	
		tarifBm(JenisTarifBm)
	}
});

function total(tot){
	var cif = tot*200;
	
	if (!isNumber(tot)){
		alert("Total/Detil CIF harus diisi dengan angka");
		$('#INVOICE').val('');
	}else{
		$('#FOB').val(tot);
		$('#ASURANSI').val(0);
		$('#FREIGHT').val(0);
		$('#CIF').val(tot);
		$('#CIFRP').val(cif);
	}
}
function satuan(data){
	
	var CIF = $('#INVOICE').val();
	var tot = CIF/data;
	
		if (data != "" )
			$('#HARGA_SATUAN').val(tot);
		if (data == 0)
			$('#HARGA_SATUAN').val(0);
}

function isNumber(n) 
{
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function tarif(id)
{
	
	if(id == 2){
		
		$('#tarf').show();
	}else{
		$('#KD_SAT_CUKAI').val('');
		$('#JUMLAH_CUKAI').val('');
		$('#tarf').hide();
	}
	
}
function tarifBm(id)
{
	
	if(id == 2){		
		$('.dtl').show();
	}else{		
		//$('#KD_SAT_BM').val('');
		$('#JUMLAH_BM').val('');
		$('.dtl').hide();
	}
	
}
