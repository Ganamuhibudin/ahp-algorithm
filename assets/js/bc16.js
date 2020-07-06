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

function total(tot){
	var ndpbm = $("#ndpbm").val();
	var cif = parseFloat(tot) * parseFloat(ndpbm);
	$('#FOB').val(tot);				
	$('#CIFUR').val(ThausandSeperator('',tot,2));			
	$('#CIF').val(tot);
	$('#CIFRPUR').val(ThausandSeperator('',cif,2));
	$('#CIFRP').val(cif);
}
function satuan(data){	
	var CIF = $('#INVOICE').val();
	var tot = CIF/data;		
	if (data != "" )
		$('#HARGA_SATUAN').val(tot);
		$('#HARGA_SATUANUR').val(ThausandSeperator('',tot,2));
	if (data == 0)
		$('#HARGA_SATUAN,#HARGA_SATUANUR').val(0);
}

function cekAngka(evt){
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 35 && (charCode < 48 || charCode > 57))
		return false;
	 return true;
} 
function isNumber(n){
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function tarif(id){	
	if(id == 2){		
		$('#tarf').show();
		$('#persens').html('');
	}else{
		$('#persens').html('%');
		$('#tarf').hide();
	}	
}
/*function tarifBm(id){	
	if(id == 2){
		$('.judul').html('Spesifik(Satuan)');		
		$('.dtl').show();
	}else{
		$('.judul').html('');		
		//$('#KD_SAT_BM').val('');
		//$('#JUMLAH_BM').val('');
		$('.dtl').hide();
	}	
}*/

function tarifBm(id,value){	
	var TARIF_BM1  = ($("#TARIF_BM1").val())?$("#TARIF_BM1").val():0;		
	if(id==1){		
		$('.persen').html('&nbsp;&nbsp;%=Rp&nbsp;');
		$('.persen2').html('&nbsp;%&nbsp;');
		$(".jml-sat").html('<input type="text" id="TARIF_BM1UR" class="stext" readonly="readonly" value="'+value+'"  wajib=\"yes\"/><input type="hidden" id="TARIF_BM1UR_hide" value="'+value+'"/>');
		$('.dtl').hide();
		$('.dtl_bottom').hide();
		BesarTarif(TARIF_BM1,1);		
	}else{				
		$('.persen').html('&nbsp;Jumlah');
		$('.persen2').html('&nbsp;&nbsp;&nbsp;&nbsp;');
		$(".jml-sat").html("<input type=\"text\" name=\"JUMLAH_SATUAN_BM_UR\" id=\"JUMLAH_SATUAN_BM_UR\" onkeyup=\"this.value = ThausandSeperator('JUMLAH_SATUAN_BM',this.value,2);BesarTarif(this.value,2);$('#JUMLAH_SATUAN_BM_BOTTOM').val(this.value.toUpperCase())\" class=\"stext\" value=\""+ThausandSeperator('',value,2)+"\"/><input type=\"hidden\"  name=\"BARANG[JUMLAH_SATUAN_BM]\" id=\"JUMLAH_SATUAN_BM\" value=\""+value+"\"/>");
		$('.dtl').show();
		$('.dtl_bottom').show();		
		BesarTarif(TARIF_BM1,1)		
	}	
}

function showBM(){
	jConfirm('Ini untuk melakukan pengisian tarif Spesifik misalnya beras gula dan tarif berdasarkan satuan lainnya.<br> Teruskan?', ":: PLB Inventory ::", 
	function(r){if(r==true){	
		Dialog(site_url+"/pemasukan/getBm", 'dialog-bm','Form Bea Masuk',450, 250);	
	}else{return false;}});			
}
function changeBM(id){
	if(id==2){
		$("#Advolorum").hide();	
		$("#Spesifik").show();	
	}else{
		$("#Spesifik").hide();	
		$("#Advolorum").show();
	}
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
function prosesHarga1(form){
	var KDHARGA = $("#"+form+" #KODE_HARGA").val();
	if(KDHARGA !=""){
		var NDPBM = ($("#"+form+" #NDPBM").val())?$("#"+form+" #NDPBM").val():0;
		var HARGA_CIF = ($("#"+form+" #HARGA_CIF").val())?$("#"+form+" #HARGA_CIF").val():0;
		var BIAYA = ($("#"+form+" #BIAYA").val())?$("#"+form+" #BIAYA").val():0;
		var DISCOUNT = ($("#"+form+" #DISCOUNT").val())?$("#"+form+" #DISCOUNT").val():0;
		var NILAI_ASURANSI = ($("#"+form+" #NILAI_ASURANSI").val())?$("#"+form+" #NILAI_ASURANSI").val():0;
		var NILAI_FREIGHT = ($("#"+form+" #NILAI_FREIGHT").val())?$("#"+form+" #NILAI_FREIGHT").val():0;			
		//if(KDHARGA!=1)
		$("#"+form+" #FOB").val(parseFloat(HARGA_CIF)+parseFloat(BIAYA)-parseFloat(DISCOUNT));	
		$("#"+form+" #FOBUR").val(ThausandSeperator('',parseFloat(HARGA_CIF)+parseFloat(BIAYA)-parseFloat(DISCOUNT),4));	
		$("#"+form+" #CIF").val(parseFloat(NILAI_ASURANSI)+parseFloat(HARGA_CIF)+parseFloat(NILAI_FREIGHT)+parseFloat(BIAYA)-parseFloat(DISCOUNT));	
		$("#"+form+" #CIFUR").val(ThausandSeperator('',parseFloat(NILAI_ASURANSI)+parseFloat(HARGA_CIF)+parseFloat(NILAI_FREIGHT)+parseFloat(BIAYA)-parseFloat(DISCOUNT),4));	
		$("#"+form+" #CIFRP").val(parseFloat(NDPBM)*parseFloat($("#"+form+" #CIF").val()));
		$("#"+form+" #CIFRPUR").val(ThausandSeperator('',Math.round(parseFloat(NDPBM)*parseFloat($("#"+form+" #CIF").val()))));
	}
}
function prosesHargaHeader(form){
	var NDPBM = ($("#"+form+" #ndpbm").val())?$("#"+form+" #ndpbm").val():0;
	var HARGA_FOB = ($("#"+form+" #fob").val())?$("#"+form+" #fob").val():0;
	var NILAI_ASURANSI = ($("#"+form+" #asuransi").val())?$("#"+form+" #asuransi").val():0;
	var NILAI_FREIGHT = ($("#"+form+" #freight").val())?$("#"+form+" #freight").val():0; 
	if($("#"+form+" #kodeharga").val()=="1"){
		$("#"+form+" #cif").val(parseFloat(HARGA_FOB));		
	}else if($("#"+form+" #kodeharga").val()=="2"){
		$("#"+form+" #cif").val(parseFloat(NILAI_ASURANSI)+parseFloat(HARGA_FOB));	
	}else{
		$("#"+form+" #cif").val(parseFloat(NILAI_ASURANSI)+parseFloat(HARGA_FOB)+parseFloat(NILAI_FREIGHT));		
	}	
	$("#"+form+" #cifrp").val(ThausandSeperator('',Math.round(parseFloat(NDPBM)*parseFloat($("#"+form+" #cif").val()))));
}
function getHarga(form){	
	var kdHarga = ($("#"+form+" #KODE_HARGA").val())?$("#"+form+" #KODE_HARGA").val():0;
	var hargaCIF = ($("#"+form+" #HARGA_CIF").val())?$("#"+form+" #HARGA_CIF").val():0;
	var HARGA_CIFUR = ($("#"+form+" #HARGA_CIFUR").val())?$("#"+form+" #HARGA_CIFUR").val():0;
	var kdValuta = ($("#"+form+" #KODE_VALUTA").val())?$("#"+form+" #KODE_VALUTA").val():0;
	var ndpbm = ($("#"+form+" #NDPBM").val())?$("#"+form+" #NDPBM").val():0;
	var NDPBMUR = ($("#"+form+" #NDPBMUR").val())?$("#"+form+" #NDPBMUR").val():0;
	var biaya = ($("#"+form+" #BIAYA").val())?$("#"+form+" #BIAYA").val():0;
	var discount = ($("#"+form+" #DISCOUNT").val())?$("#"+form+" #DISCOUNT").val():0;
	var kdAsuransi = ($("#"+form+" #KODE_ASURANSI").val())?$("#"+form+" #KODE_ASURANSI").val():0;
	var nilaiAsuransi = ($("#"+form+" #NILAI_ASURANSI").val())?$("#"+form+" #NILAI_ASURANSI").val():0;
	var NILAI_ASURANSIUR = ($("#"+form+" #NILAI_ASURANSIUR").val())?$("#"+form+" #NILAI_ASURANSIUR").val():0;
	var nilaiFreight = ($("#"+form+" #NILAI_FREIGHT").val())?$("#"+form+" #NILAI_FREIGHT").val():0;
	var NILAI_FREIGHTUR = ($("#"+form+" #NILAI_FREIGHTUR").val())?$("#"+form+" #NILAI_FREIGHTUR").val():0;
	var FOB = ($("#"+form+" #FOB").val())?$("#"+form+" #FOB").val():0;
	var FOBUR = ($("#"+form+" #FOBUR").val())?$("#"+form+" #FOBUR").val():0;
	var cif = ($("#"+form+" #CIF").val())?$("#"+form+" #CIF").val():0;	
	var CIFUR = ($("#"+form+" #CIFUR").val())?$("#"+form+" #CIFUR").val():0;	
	var cifRpUr = ($("#"+form+" #CIFRPUR").val())?$("#"+form+" #CIFRPUR").val():0;	
	var cifRp = ($("#"+form+" #CIFRP").val())?$("#"+form+" #CIFRP").val():0;
	if(kdHarga != ""){	
	 $('#fbc281 #fob').val(FOB);
	 $('#fbc281 #fobur').val(FOBUR);
	 $('#fbc281 #cif').val(cif);
	 $('#fbc281 #cifur').val(CIFUR);
	 $('#fbc281 #freight').val(nilaiFreight);
	 $('#fbc281 #freightur').val(NILAI_FREIGHTUR);
	 $('#fbc281 #asuransi').val(nilaiAsuransi);
	 $('#fbc281 #asuransiur').val(NILAI_ASURANSIUR);
	 $('#fbc281 #cifrpur').val(cifRpUr);
	 $('#fbc281 #cifrp').val(cifRp);
	 $('#fbc281 #ndpbm').val(ndpbm);
	 $('#fbc281 #nilai_ndpbm').val(NDPBMUR);
	 $('#fbc281 #valuta').val(kdValuta);
	 $('#fbc281 #kode_asuransi').val(kdAsuransi);
	 $('#fbc281 #tambahan').val(biaya);
	 $('#fbc281 #diskon').val(discount);
	 $('#fbc281 #kodeharga').val(kdHarga);
	 $('#fbc281 #nilaiinvoice').val(hargaCIF);
	 if(kdHarga==2){
		 var span22 = "CNF";
	 }else{
		 var span22 = "FOB";
	 }
	 $("#22").html(span22);
	}
	closedialog('divHitung');
	$("#BRUTOUR").focus();
}

function kode(data){
	 if(data == 1){	
		$("#harga").find("#KODE_ASURANSI,#NILAI_ASURANSI,#NILAI_FREIGHT,#FOB").val('');
		$('#KODE_ASURANSI').attr('disabled',"true");
		$('#NILAI_ASURANSI,#NILAI_ASURANSIUR').attr('disabled',"true");
		$('#NILAI_FREIGHT,#NILAI_FREIGHTUR').attr('disabled',"true");
		$('.hargacif').html('Harga CIF');
		$('.fob').html('FOB');
		$("#harga #NILAI_ASURANSI,#NILAI_ASURANSIUR").val(0);
		$("#harga #NILAI_FREIGHT,#NILAI_FREIGHTUR").val(0);
		$("#harga #FOB").val(0);
		prosesHarga1('harga');
	}else if(data == 2){
		$('#KODE_ASURANSI').removeAttr("disabled");
		$('#NILAI_ASURANSI,#NILAI_ASURANSIUR').removeAttr("disabled");
		$('#NILAI_FREIGHT,#NILAI_FREIGHTUR').attr('disabled',"true");
		$('.hargacif').html('Harga CNF');
		$('.fob').html('CNF');
		$("#harga #NILAI_FREIGHT,#NILAI_FREIGHTUR").val(0);
		$("#harga #FOB").val($('#HARGA_CIF').val());
		prosesHarga1('harga');
	}else if(data == 3){
		$('#KODE_ASURANSI').removeAttr("disabled");
		$('#NILAI_ASURANSI,#NILAI_ASURANSIUR').removeAttr("disabled");
		$('#NILAI_FREIGHT,#NILAI_FREIGHTUR').removeAttr("disabled");
		$('.hargacif').html('Harga FOB');
		$('.fob').html('FOB');
		$("#harga #FOB").val($('#HARGA_CIF').val());
		prosesHarga1('harga');
	}
}
/////////NEW UCUP//////
function EditHarga(inputField,formName){
	//var kdHarga = $("#fbc23_ #kodeharga").val();
	//alert(kdHarga);	
	var id = inputField.split(";");
	var data=""; 
	for(var a=0;a<id.length;a++){
		 data += $('#'+id[a]).val()+";";
	}
	Dialog(site_url+'/pemasukan/hitungan/bc281/'+data,'divHitung','FORM EDIT HARGA ',600, 370);
	//kode(kdHarga);
}	
function BesarTarif(value,type){
	var jns = $("#KODE_TARIF_BM").val();
	if(jns==1){
		var CIFRP  = ($("#CIF_RP").val())?$("#CIF_RP").val():0;
		var val = parseFloat(value/100);
		$("#TARIF_BM1UR").val(ThausandSeperator('TARIF_BM1UR_hide',parseFloat(val*CIFRP),4));
		$("#KD_SAT_BM,#KD_SAT_BM_hide").val(0);
	}else{
		var trfbm1  = ($("#TARIF_BM1").val())?$("#TARIF_BM1").val():0;
		var jmlsat  = ($("#JUMLAH_SATUAN_BM").val())?$("#JUMLAH_SATUAN_BM").val():0;		
		$("#KD_SAT_BM").val(ThausandSeperator('KD_SAT_BM_hide',parseFloat(trfbm1)*parseFloat(jmlsat),4));
	}	
	if(type==1){
		$("#TARIF_BM").val(value);
	}
	totbm();
}
function BTambahan(value,target){
	var NDPBM  = ($("#CIF_RP").val())?$("#CIF_RP").val():0;
	var BM_BB = 0;
	if(target=="PPN_BB"||target=="PPH_BB"){
		BM_BB = ($("#BM_BB").val())?$("#BM_BB").val():0;
		var CIFRP  = parseFloat(NDPBM)+multiReplace(BM_BB,',','');
	}else{
		var CIFRP  = parseFloat(NDPBM);	
	}	
	var val = parseFloat(value/100);
	$("#"+target).val(ThausandSeperator(target+'_hide',parseFloat(val*CIFRP),4));	
	totbm();
}
function BTambahan_bb(value,target){
	var NDPBM  = ($('#fbc25_').find("#ndpbm").val())?$('#fbc25_').find("#ndpbm").val():0; 
	var CIF  = ($('#Frm_BB').find("#CIF_BB").val())?$('#Frm_BB').find("#CIF_BB").val():0;
	var BM_BB = 0;
	if(target=="PPN_BB"||target=="PPH_BB"){
		BM_BB = ($('#Frm_BB').find("#BM_BB").val())?$('#Frm_BB').find("#BM_BB").val():0;
		var CIFRP  = (parseFloat(CIF)*parseFloat(NDPBM))+parseFloat(multiReplace(BM_BB,',',''));
	}else{
		var CIFRP  = (parseFloat(CIF)*parseFloat(NDPBM));	
	}	
	var val = parseFloat(value/100);
	$("#"+target).val(ThausandSeperator('',parseFloat(val*CIFRP),4));	
	//totbm();
	console.log(NDPBM+'*'+CIF+'*'+val+'='+val+'<=>'+CIFRP+' =>'+target)
}
function totbm(){
	var a  = ($("#TARIF_BM1UR_hide").val())?$("#TARIF_BM1UR_hide").val():0;
	var b  = ($("#KD_SAT_BM_hide").val())?$("#KD_SAT_BM_hide").val():0;
	var c  = ($("#BM_ANTI_DUMPINGUR_hide").val())?$("#BM_ANTI_DUMPINGUR_hide").val():0;
	var d  = ($("#BM_IMBALANUR_hide").val())?$("#BM_IMBALANUR_hide").val():0;
	var e  = ($("#BM_PENGAMANANUR_hide").val())?$("#BM_PENGAMANANUR_hide").val():0;
	var f  = ($("#BM_PEMBALASANUR_hide").val())?$("#BM_PEMBALASANUR_hide").val():0;
	$("#TOTBM").val(ThausandSeperator('',parseFloat(a)+parseFloat(b)+parseFloat(c)+parseFloat(d)+parseFloat(e)+parseFloat(f),4));	
}