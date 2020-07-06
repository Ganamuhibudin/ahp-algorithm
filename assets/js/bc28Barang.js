// JavaScript Document
function get_next_data(index){
	var aju =$("#NOMOR_AJU").val();
	var seri=$("#seri").val();
	$.ajax({
		url: site_url+"/pengeluaran/getListData/bc282/listBB/"+aju+"/"+seri,
		type: "POST",
		data: {index:index},
		success:function(data)
		{
			$('#dataBB').show();
			$('#dataBB').html(data);
		}
	});
}
function ProsesHeader(){
	var NDPBM  = ($("#ndpbm").val())?$("#ndpbm").val():0;
	var CIF  = ($("#cif").val())?$("#cif").val():0;
	var CIFRP  = (parseFloat(NDPBM)*parseFloat(CIF));
	$("#CIFRPUR").val(ThausandSeperator('',CIFRP,4));
	$("#CIF_RP").val(CIFRP);
}

function ProsesCIF(){
	var NDPBM  = ($("#ndpbm").val())?$("#ndpbm").val():0;
	var CIF  = ($("#ciff").val())?$("#ciff").val():0;//alert(CIF);
	var CIFRP  = (parseFloat(CIF)*parseFloat(NDPBM));
	$("#CIFRPBRG").val(ThausandSeperator('',CIFRP,4));
	BesarTarif($("#TARIF_BM1").val(),1);
}
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
function BesarTarif(value,type){
	var jns = $("#KODE_TARIF_BM").val();
	if(jns==1){
		var NDPBM  = ($("#ndpbm").val())?$("#ndpbm").val():0;
		var CIF  = ($("#ciff").val())?$("#ciff").val():0;
		var CIFRP  = (parseFloat(CIF)*parseFloat(NDPBM));
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
	var NDPBM  = ($('#fbc28').find("#ndpbm").val())?$('#fbc28').find("#ndpbm").val():0; 
	var CIF  = ($("#CIF_NILAI").val())?$("#CIF_NILAI").val():0;
	var CIFRP  = (parseFloat(CIF)*parseFloat(NDPBM));
	var val = parseFloat(value/100);
	$("#"+target).val(ThausandSeperator(target+'_hide',parseFloat(val*CIFRP),4));	
	totbm();
	console.log(NDPBM+'*'+CIF+'*'+val+'='+parseFloat(val*CIFRP))
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
function tarif(id,tarif,satuan,satuanur){	
    if(tarif=='')tarif=0;
	if(satuan=='')satuan='';
	if(id == 1){		
	     $("#tarif").html('<input type="text" name="TARIF[TARIF_CUKAI]" id="TARIF_CUKAI" class="sstext" value="'+tarif+'">&nbsp;<span id="cukai">%</span>');
		 $("#cukai").html(' % ');
		 $('#tarf,#valcukai').hide();
		 $('#jml-cukai').html('');
	}else if(id == 2 ){
		$("#tarif").html('<input type="text" name="TARIF[TARIF_CUKAI]" id="TARIF_CUKAI" class="sstext" value="'+tarif+'">&nbsp;<span id="cukai">%</span>');
	    $("#cukai").html(' / <input type="text" class="ssstext" name="TARIF[KODE_SATUAN_CUKAI]" id="KODE_SATUAN_CUKAI" maxlength="3" url="'+site_url+'/autocomplete/satuan" urai="urai_Sat_cukai;" onfocus="Autocomp(this.id);" value="'+satuan+'"/>&nbsp;<span id="urai_Sat_cukai">'+satuanur+'</span>');
		$('#tarf,#valcukai').show();
		$('#jml-cukai').html('Jumlah');
	}else if(id == 3 ){
		 $("#tarif").html(' Rp. <input type="text" class="stext" name="TARIF[TARIF_CUKAI]" id="TARIF_CUKAI" value="'+tarif+'"/>');
		 $('#tarf,#valcukai').hide();
		 $('#jml-cukai').html('');
	}
}
function Showdokumen(){
	var dokumen = $("#KODE_DOK_ASAL_BB").val();
	Dialog(site_url+"/pengeluaran/dokpabean/"+dokumen, 'Dialog-dok','FORM DOKUMEN PABEAN',800, 510);	
	return false;
}
function nilaiBM(){
	var NDPBM  = ($("#ndpbm").val())?$("#ndpbm").val():0;
	var CIF  = ($("#CIF_BB").val())?$("#CIF_BB").val():0;
	var CIFRP  = (parseFloat(CIF)*parseFloat(NDPBM));
	var arr = Array("TARIF_BM_BB","TARIF_CUKAI_BB","TARIF_PPN_BB","TARIF_PPNBM_BB","TARIF_PPH_BB");
	var input="";
	for(var a=0;a<=4;a++){		
		var val = parseFloat($("#"+arr[a]).val()/100);
		input = arr[a].replace("TARIF_","");
		$("#"+input).val(ThausandSeperator('',parseFloat(val*CIFRP),4));		
	}
}
function pilihfasskema(formid){
	var length = $("#tb_chk"+formid+":checked").length;	
	var dataCheck = "";var dataTexts = "";
	$("#tb_chk"+formid+":checked").each(function(){
		var arr = $(this).val().split("|");
		dataTexts += arr[0];
		dataCheck += $(this).val().replace("|"," - ") + "<br>";
	});
	if(length==0){
		jAlert('Maaf, Data belum dipilih.','PLB Inventory');
		return false;
	}else if(length > 3){
		jAlert('Maaf, Data yang bisa dipilih hanya 3 (Tiga).','PLB Inventory');
		return false;
	}else{
		$("#divfaskema").html(dataCheck);
		$("#fbarang_ #KODE_FASILITAS").val(dataTexts);
		closedialog('dialog-fas');
	}
}
function bbcif(){
	var NDPBM  = ($("#ndpbm").val())?$("#ndpbm").val():0;
	var CIF  = ($("#CIF_BB").val())?$("#CIF_BB").val():0;
	var CIFRP  = (parseFloat(CIF)*parseFloat(NDPBM));
	$("#CIFRP_BB").val(CIFRP);
}
function addRowPPN(tableId,tbody_id){
	var content="";
	var nilai = $("#"+tableId+" tbody tr").size();
	var Mathrandom = GetRandomMath();	
	var NO = parseFloat($("span #no:last").html().replace('.',''))+1;			
	content= "<tr id=\"tr_"+Mathrandom+"\"><td class=\"alt2 bright\"><span id=\"no\">"+NO+"</span></td><td class=\"alt2 bright\"><input type=\"text\" name=\"PPN[BIAYA][]\" id=\"BIAYA"+Mathrandom+"\" class=\"mtext\" style=\"width:100%;height:20px\" maxlength=\"30\" wajib=\"yes\"/></td><td class=\"alt2 bright\"><input type=\"text\" name=\"JUMLAH_BIAYA_UR\" id=\"JUMLAH_BIAYA_UR"+Mathrandom+"\" class=\"stext\" style=\"width:100%;text-align:right;height:20px\" wajib=\"yes\" onkeyup=\"this.value = ThausandSeperator('JUMLAH_BIAYA"+Mathrandom+"',this.value,2);\"/><input type=\"hidden\" name=\"PPN[JUMLAH_BIAYA][]\" id=\"JUMLAH_BIAYA"+Mathrandom+"\"/></td><td class=\"alt2 bright\"><input type=\"text\" name=\"PPN[KETERANGAN][]\" id=\"KETERANGAN"+Mathrandom+"\" class=\"mtext\" style=\"width:100%;height:20px\" maxlength=\"50\"/></td><td class=\"alt2 right\"><a href=\"javascript:void(0)\" onclick=\"removeRowPPN('"+tableId+"','"+tbody_id+"','"+Mathrandom+"')\" title=\"Hapus Detil\" class=\"del\"  style=\"color:#DF4B33;font-size:22px;text-align:center\"><span><i class=\"fa fa-minus-circle\"></i>&nbsp;</span></a></td></tr>";
		 
	$("#"+tableId+" tbody:first").append(content);
}
function removeRowPPN(tableId,tBodyId,id){ 
	$("#"+tableId+" tr[id=tr_"+id+"]").remove();
	$("span #no").each(function(index, element) {
        $(this).html(parseFloat(index)+1);
    });	
}	
