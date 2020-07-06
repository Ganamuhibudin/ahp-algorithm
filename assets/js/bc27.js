// JavaScript Document
$(document).ready(function(){	
	var JenisTarif = $('#KODE_TARIF_CUKAI').val();	
	var JenisTarifBm = $('#KODE_TARIF_BM').val();
	if(JenisTarif == 2)
		tarif(JenisTarif);
	if(JenisTarifBm == 2){
		$('#bmHidden').show();	
		tarifBm(JenisTarifBm)
	}
});

 
function isNumber(n){
  return !isNaN(parseFloat(n)) && isFinite(n);
}



function popup__(id){
	jConfirm('Ini untuk melakukan pengisian tarif Spesifik misalnya beras gula dan tarif berdasarkan satuan lainnya Teruskan?', ":: GB Inventory ::", 
		function(r){if(r==true){	
		$('#bmHidden').show();
	}else{return false;}});			
}

function hitungan(id){
	var valuta = $("#valuta").val();
	var ndpbm = $("#ndpbm").val();
	var fob = $("#fob").val();
	var freight = $("#freight").val();
	var asuransi = $("#asuransi").val();
	var cif = $("#cif").val();
	var cifrp = $("#cifrp").val();
	var kode_asuransi = $("#kode_asuransi").val();
	var tambahan = $("#tambahan").val();
	var diskon = $("#diskon").val();
	var kodeharga = $("#kodeharga").val();
	var nilaiinvoice = $("#nilaiinvoice").val();
	
		
	var width = 600;
	var height = 400;
	var winl = (screen.width - width) / 2;
	var wint = (screen.height - height) / 2;
	URL = site_url + '/pemasukan/hitungan/'+id+'/'+valuta+'/'+ndpbm+'/'+fob+'/'+freight+'/'+asuransi+'/'+cif+'/'+cifrp+'/'+kode_asuransi+'/'+tambahan+'/'+diskon+'/'+kodeharga+'/'+nilaiinvoice;
	window.open(URL,"myWindow","status=0,left="+winl+",top="+wint+",height="+height+",width="+width+",resizable=0,scrollbars=1");
}


function prosesHarga(form){
	var INVOICE  = ($("#"+form+" #INVOICE").val())?$("#"+form+" #INVOICE").val():0;
	var JUMLAH_SATUAN  = ($("#"+form+" #JUMLAH_SATUAN").val())?$("#"+form+" #JUMLAH_SATUAN").val():0;
	var NDPBM = ($("#"+form+" #NDPBM").val())?$("#"+form+" #NDPBM").val():0;
	var DISKON = ($("#"+form+" #DISKON").val())?$("#"+form+" #DISKON").val():0;
	var HFREIGHT = ($("#"+form+" #HFREIGHT").val())?$("#"+form+" #HFREIGHT").val():0;
	var HASURANSI = ($("#"+form+" #HASURANSI").val())?$("#"+form+" #HASURANSI").val():0;
	var HARGA_SATUAN  = (parseFloat(INVOICE)-parseFloat(DISKON))/parseFloat(JUMLAH_SATUAN);
	var HRGSAT = (HARGA_SATUAN=="Infinity"||isNaN(HARGA_SATUAN))?0:HARGA_SATUAN;
	$("#"+form+" #HARGA_SATUAN").val(HRGSAT);
	$("#"+form+" #FOB").val(INVOICE);
	$("#"+form+" #CIF").val((parseFloat(INVOICE)-parseFloat(DISKON))*parseFloat(NDPBM));
	$("#"+form+" #FREIGHT").val(parseFloat(INVOICE)*parseFloat(HFREIGHT));
	$("#"+form+" #ASURANSI").val(parseFloat(INVOICE)*parseFloat(HASURANSI));
	$("#"+form+" #HARGA_CIF").val(parseFloat(INVOICE)+(parseFloat(INVOICE)*parseFloat(HFREIGHT))+(parseFloat(INVOICE)*parseFloat(HASURANSI)));
}
function prosesHarga1(form)
{
	var KDHARGA = $("#"+form+" #KODE_HARGA").val();
	if(KDHARGA !=""){
	var NDPBM = ($("#"+form+" #NDPBM").val())?$("#"+form+" #NDPBM").val():0;
	var HARGA_CIF = ($("#"+form+" #HARGA_CIF").val())?$("#"+form+" #HARGA_CIF").val():0;
	var BIAYA = ($("#"+form+" #BIAYA").val())?$("#"+form+" #BIAYA").val():0;
	var DISCOUNT = ($("#"+form+" #DISCOUNT").val())?$("#"+form+" #DISCOUNT").val():0;
	var NILAI_ASURANSI = ($("#"+form+" #NILAI_ASURANSI").val())?$("#"+form+" #NILAI_ASURANSI").val():0;
	var NILAI_FREIGHT = ($("#"+form+" #NILAI_FREIGHT").val())?$("#"+form+" #NILAI_FREIGHT").val():0;
	
	if (!isNumber(NDPBM)){
		alert("NDPBM harus diisi dengan angka");		
		$("#"+form+" #NDPBM").val(0);
	}if (!isNumber(HARGA_CIF)){
		alert("HARGA CIF harus diisi dengan angka");
		$("#"+form+" #HARGA_CIF").val(0);
	}	if (!isNumber(BIAYA)){
		alert("BIAYA harus diisi dengan angka");
		$("#"+form+" #BIAYA").val(0);
	}if (!isNumber(DISCOUNT)){
		alert("DISCOUNT harus diisi dengan angka");
		$("#"+form+" #DISCOUNT").val(0);
	}if (!isNumber(NILAI_ASURANSI)){
		alert("NILAI ASURANSI harus diisi dengan angka");
		$("#"+form+" #NILAI_ASURANSI").val(0);
	}if (!isNumber(NILAI_FREIGHT)){
		alert("FREIGHT harus diisi dengan angka");
		$("#"+form+" #NILAI_FREIGHT").val(0);
	}	
		
	$("#"+form+" #FOB").val(parseFloat(HARGA_CIF)+parseFloat(BIAYA)-parseFloat(DISCOUNT));
	$("#"+form+" #CIF").val(parseFloat(NILAI_ASURANSI)+parseFloat(HARGA_CIF)+parseFloat(NILAI_FREIGHT)+parseFloat(BIAYA)-parseFloat(DISCOUNT));	
	$("#"+form+" #CIFRP").val(parseFloat(NDPBM)*parseFloat($("#"+form+" #CIF").val()));
	}
}

function getHarga(form){	
	var kdHarga = $("#"+form+" #KODE_HARGA").val();
	var hargaCIF = $("#"+form+" #HARGA_CIF").val();
	var kdValuta = $("#"+form+" #KODE_VALUTA").val();
	var ndpbmm = $("#"+form+" #NDPBM").val();
	var biaya = $("#"+form+" #BIAYA").val();
	var discount = $("#"+form+" #DISCOUNT").val();
	var kdAsuransi = $("#"+form+" #KODE_ASURANSI").val();
	var nilaiAsuransi = $("#"+form+" #NILAI_ASURANSI").val();
	var nilaiFreight = $("#"+form+" #NILAI_FREIGHT").val();
	var FOB = $("#"+form+" #FOB").val();
	var cif = $("#"+form+" #CIF").val();	
	var cifRp = $("#"+form+" #CIFRP").val();
	if(kdHarga != ""){	
	 document.getElementById('fob').value = FOB;
	 document.getElementById('cif').value = cif;
	 document.getElementById('freight').value = nilaiFreight;
	 document.getElementById('asuransi').value = nilaiAsuransi;
	 document.getElementById('cifrp').value = cifRp;
	 document.getElementById('ndpbm').value = ndpbmm;
	 document.getElementById('valuta').value = kdValuta;
	 document.getElementById('kode_asuransi').value = kdAsuransi;
	 document.getElementById('tambahan').value = biaya;
	 document.getElementById('diskon').value = discount;
	 document.getElementById('kodeharga').value = kdHarga;
	 document.getElementById('nilaiinvoice').value = hargaCIF;
	}
	closedialog('divHitung');
}
/////////NEW UCUP//////
function EditHarga(inputField,formName){
	var id = inputField.split(";");
	var data=""; 
	for(var a=0;a<id.length;a++){
		data += document.getElementById(id[a]).value+';'		
	}
	Dialog(site_url+'/pemasukan/hitungan/bc23/'+data,'divHitung','FORM EDIT HARGA ',600, 360);
}

function satuan(data){	
	var CIF = $('#CIF').val();
	var tot = CIF/data;		
	if (data != "" )
		$('#HARGA_SATUAN').val(tot);
		$('#HARGA_SATUANUR').val(ThausandSeperator('',tot,2));
	if (data == 0)
		$('#HARGA_SATUAN,#HARGA_SATUANUR').val(0);
}	
