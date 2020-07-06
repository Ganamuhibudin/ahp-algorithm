// JavaScript Document
$(document).ready(function(){
	formID="fbc30_";
	val=$("#"+formID+" #KATEGORI_EKSPOR").val();
	getQQ=$("#"+formID+" #KODE_ID_QQ").val();
	if(val=='21' || val=='22' || val=='23'){
		$("#PKB").show();
	}else{
		$("#PKB").hide();
	}

	if(getQQ!=''){
		$("#QQcheckBox").empty().append("<input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\" name=\"QQCheck\" id=\"QQCheck\" value=\"QQ\"/>");		
	}else{
		$("#QQcheckBox").empty().append("<input type=\"checkbox\" disabled=\"disabled\" name=\"QQCheck\" id=\"QQCheck\" value=\"QQ\"/>");
	}
	
});
function cekTarif(){
		var id = $("#KODE_PE").val();
  		if(id==1){
			if ($("#tarif_1").css("display") == "none")
				{
					$(".detTarif1").hide();
					$("#tarif_1").show();
					$(".msg_load").html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
					$(".msg_load").fadeIn('slow');
					
					page=site_url+'/pemasukan/getTarif/bc30/advolarum';//alert(page);return false;
					$('#beaAdvolarum').load(page);
					$(".msg_load").fadeOut('slow');
					$("#tarif_2").hide();	
					
				}

			
		}else if(id==2){
			if ($("#tarif_2").css("display") == "none")
				{
					$(".detTarif2").hide();
					$("#tarif_2").show();
					$(".msg_load").html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
					$(".msg_load").fadeIn('slow');
					page=site_url+'/pemasukan/getTarif/bc30/spesifik';//alert(page);return false;
					$('#beaSpesifik').load(page);
					$(".msg_load").fadeOut('slow');
					$("#tarif_1").hide();	
					
				}

		}else{
			$("#tarif_1").hide("slow");
			$("#tarif_2").hide("slow");
		}	
}
function isNumber(n) 
{
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function getTarif(id)
{	
	alert('test');	
	if(id == 2){
		
		$('#tarf').show();
	}else{
		$('#KD_SAT_CUKAI').val('');
		$('#JUMLAH_CUKAI').val('');
		$('#tarf').hide();
	}
	
}
function prosesPE()
{
	var KODE_PE = $("#KODE_PE").val();//alert(KODE_PE);
	var HARGA_PATOK = eval($("#HARGA_PATOK").val())?$("#HARGA_PATOK").val():0;
	var JUMLAH_SATUAN_PE = eval($("#JUMLAH_SATUAN_PE").val())?$("#JUMLAH_SATUAN_PE").val():0;
	var NILAI_VALUTA_PE = eval($("#NILAI_VALUTA_PE").val())?$("#NILAI_VALUTA_PE").val():0;
	var HARGA_PATOK_SP = eval($("#HARGA_PATOK_SP").val())?$("#HARGA_PATOK_SP").val():0;
	var JUMLAH_SATUAN_PE_SP = eval($("#JUMLAH_SATUAN_PE_SP").val())?$("#JUMLAH_SATUAN_PE_SP").val():0;
	var NILAI_VALUTA_PE_SP = eval($("#NILAI_VALUTA_PE_SP").val())?$("#NILAI_VALUTA_PE_SP").val():0;

	if(KODE_PE==1){
		TARIF_PE= eval($("#TARIF_PE").val()/100)?$("#TARIF_PE").val():0;
		$("#NILAI_PE").val(HARGA_PATOK * JUMLAH_SATUAN_PE * NILAI_VALUTA_PE *TARIF_PE);	
		$("#NILAI_PE_CON").val(ThausandSeperator('',HARGA_PATOK * JUMLAH_SATUAN_PE * NILAI_VALUTA_PE *TARIF_PE,4));
	}else if(KODE_PE==2){
		TARIF_PE_SP= eval($("#TARIF_PE_SP").val())?$("#TARIF_PE_SP").val():0;//(TARIF_PE);
		$("#NILAI_PE_SP").val(HARGA_PATOK_SP * NILAI_VALUTA_PE_SP *TARIF_PE_SP);
		$("#NILAI_PE_CON_SP").val(ThausandSeperator('',HARGA_PATOK_SP * NILAI_VALUTA_PE_SP *TARIF_PE_SP,4));	
	}
}
function hitungan(form,jenis)
{
	var asuransi=$('#ASURANSI').val();//alert(asuransi);
	var freight=$('#FREIGHT').val();
	var kodeHarga=$('#KODE_HARGA').val();
	var fob=$('#FOB').val();
	var cif=$('#N_CIF').val();
	var invoice=$('#N_INVOICE').val();

	var addUrl1='';
	var addUrl2='';
	var addUrl3='';
	var addUrl4='';
	var addUrl5='';
	var addUrl6='';
	if(asuransi!='')
		addUrl1='/'+asuransi;	
	if(freight!='')
		addUrl2='/'+freight;
	if(kodeHarga!='')
		addUrl3='/'+kodeHarga;
	if(fob!='')
		addUrl4='/'+fob;
	if(cif!='')
		addUrl5='/'+cif;
	if(invoice!='')
		addUrl6='/'+invoice;	
	URL = site_url + '/pemasukan/popup/'+form+'/'+jenis+addUrl1+addUrl2+addUrl3+addUrl4+addUrl5+addUrl6;//alert(URL);
	Dialog(URL, 'divharga','FORM HARGA ',530, 250);
}
function getPkb(val){
	if(val=='21' || val=='22' || val=='23'){
		$("#PKB").show();
	}else{
		$("#PKB").hide();
	}
}
function PKBInput(form,jenis,aju){
	var addUrl="";var KodePKB="";
	var ValPKB=$("#fbc30_ #KATEGORI_EKSPOR").val();
	if(ValPKB=='21') KodePKB='A';
	else if(ValPKB=='22') KodePKB='B';
	else if(ValPKB=='23') KodePKB='C';
	if(KodePKB!="")addUrl="/"+KodePKB+"/"+ValPKB+"/"+aju;
	URL = site_url + '/pemasukan/popup/'+form+'/'+jenis+addUrl;//alert(URL);
	Dialog(URL, 'divPKB','FORM INPUT PKB ',800, 400);
}
function QQInput(form,jenis)
{
	URL = site_url + '/pemasukan/popup/'+form+'/'+jenis;
	DialogQQ(URL, 'divppjk','FORM INPUT IDENTOR / QQ ',460, 280);
}
function DialogQQ(url,Divid,title,width,height){
	var kode_id_qq=$('#KODE_ID_QQ').val();//alert(kode_id_qq);
	var id_qq=$('#ID_QQ').val();
	var nama_qq=$('#NAMA_QQ').val();
	var alamat_qq=$('#ALAMAT_QQ').val();
	var niper_qq=$('#NIPER_QQ').val();
	c_dialog(Divid, ':: '+title+' ::', '<div id="idv_popup"></div>', width, height, "run-in", true, false);
	$("#"+Divid).html('<center><img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...</center>');
	$('#'+Divid).load(url, { kode_id_qq: kode_id_qq, id_qq: id_qq, nama_qq: nama_qq, alamat_qq: alamat_qq, niper_qq: niper_qq });				
}
function satuan(){	
	var jumsat = ($('#JUMLAH_SATUAN').val())?$('#JUMLAH_SATUAN').val():0;
	if($("#fbc30_").find("#KODE_HARGA").val()=='1'){		
		var CIF = ($('#INVOICE').val())?$('#INVOICE').val():0;
		$('#FOB_PER_BARANG').val(CIF);
		$('#FOB_DTL').val(ThausandSeperator('',CIF,4));		
	}
	var FOB_PER_BARANG = ($('#FOB_PER_BARANG').val())?$('#FOB_PER_BARANG').val():0;
	var tot = parseFloat(FOB_PER_BARANG)/parseFloat(jumsat);			
	$('#FOB_PER_SATUAN').val(ThausandSeperator('',tot,4));
}
function harga_satuan(){
	$('#FOB_PER_SATUAN').val();
}
function prosesHarga1(form)
{
	var KDHARGA = $("#"+form+" #KODE_HARGA").val();//alert('sini');
	var NILAI_INVOICE = ($("#"+form+" #NILAI_INVOICE_HRG").val())?$("#"+form+" #NILAI_INVOICE_HRG").val():0;
	var NILAI_ASURANSI = ($("#"+form+" #NILAI_ASURANSI").val())?$("#"+form+" #NILAI_ASURANSI").val():0;
	var NILAI_FREIGHT = ($("#"+form+" #NILAI_FREIGHT").val())?$("#"+form+" #NILAI_FREIGHT").val():0;
	
	
	if(KDHARGA==3){//alert('sini');money_format
		HITUNG_HARGA=parseFloat(NILAI_ASURANSI)+parseFloat(NILAI_FREIGHT)+parseFloat(NILAI_INVOICE);
		$("#"+form+" #FOB").val(parseFloat(NILAI_INVOICE));
		$("#"+form+" #CIF").val(HITUNG_HARGA);	
		$("#"+form+" #FOB_CON").val(ThausandSeperator('',parseFloat(NILAI_INVOICE),4));
		$("#"+form+" #CIF_CON").val(ThausandSeperator('',HITUNG_HARGA,4));	
	}else if(KDHARGA==1){
		HITUNG_HARGA=(parseFloat(NILAI_INVOICE))-(parseFloat(NILAI_ASURANSI)-parseFloat(NILAI_FREIGHT));
		$("#"+form+" #CIF").val(parseFloat(NILAI_INVOICE));
		$("#"+form+" #FOB").val(HITUNG_HARGA);
		$("#"+form+" #FOB_CON").val(ThausandSeperator('',parseFloat(NILAI_INVOICE),4));
		$("#"+form+" #CIF_CON").val(ThausandSeperator('',HITUNG_HARGA,4));
	}

}

function getHarga(form){
	var nilaiInvoice = ($("#"+form+" #NILAI_INVOICE_HRG").val());
	var kdHarga = $("#"+form+" #KODE_HARGA").val();
	var nilaiAsuransi = $("#"+form+" #NILAI_ASURANSI").val();
	var nilaiFreight = $("#"+form+" #NILAI_FREIGHT").val();
	var FOB = $("#"+form+" #FOB").val();
	var CIF = $("#"+form+" #CIF").val();
	//alert(kdHarga);
		if(kdHarga != ""){	
			if(kdHarga==3){
				 document.fbc30_.FOB.value = FOB;
				 document.fbc30_.FREIGHT.value = nilaiFreight;
				 document.fbc30_.ASURANSI.value = nilaiAsuransi;
				 document.fbc30_.FOB_CONV.value = ThausandSeperator('',FOB,4);
				 document.fbc30_.FREIGHT_CONV.value = ThausandSeperator('',nilaiFreight,4);
				 document.fbc30_.ASURANSI_CONV.value = ThausandSeperator('',nilaiAsuransi,4);
				 document.fbc30_.KODE_HARGA.value = kdHarga;
				 document.fbc30_.N_INVOICE.value = nilaiInvoice;
				 document.fbc30_.N_CIF.value = CIF;
			}else if(kdHarga==1){
				 document.fbc30_.FOB.value = CIF;
				 document.fbc30_.FREIGHT.value = nilaiFreight;
				 document.fbc30_.ASURANSI.value = nilaiAsuransi;
				 document.fbc30_.FOB_CONV.value = ThausandSeperator('',CIF,4);
				 document.fbc30_.FREIGHT_CONV.value = ThausandSeperator('',nilaiFreight,4);
				 document.fbc30_.ASURANSI_CONV.value = ThausandSeperator('',nilaiAsuransi,4);
				 document.fbc30_.KODE_HARGA.value = kdHarga;
				 document.fbc30_.N_INVOICE.value = nilaiInvoice;
				 document.fbc30_.N_CIF.value = FOB;
			}
		}
	closedialog('divharga');
	if(kdHarga=="1"){
		$("#taghargacif").show();	
	}else{
		$("#taghargacif").hide();	
	}
	satuan();
}
function getPopup(form){
	var kode_id = $("#"+form+" #KODE_ID_QQ").val();
	var id = $("#"+form+" #ID_QQ").val();
	var nama = $("#"+form+" #NAMA_QQ").val();
	var alamat = $("#"+form+" #ALAMAT_QQ").val();
	var niper = $("#"+form+" #NIPER_QQ").val();	
	getQQ=$("#"+form+" #KODE_ID_QQ").val();
	if(getQQ!=''){
		$("#QQcheckBox").empty().append("<input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\" name=\"QQCheck\" id=\"QQCheck\" value=\"QQ\"/>");		
	}else{
		$("#QQcheckBox").empty().append("<input type=\"checkbox\" disabled=\"disabled\" name=\"QQCheck\" id=\"QQCheck\" value=\"QQ\"/>");
	}
	 document.fbc30_.KODE_ID_QQ.value = kode_id;
	 document.fbc30_.ID_QQ.value = id;
	 document.fbc30_.NAMA_QQ.value = nama;
	 document.fbc30_.ALAMAT_QQ.value = alamat;
	 document.fbc30_.NIPER_QQ.value = niper;
	 closedialog('divppjk');
		 
}


