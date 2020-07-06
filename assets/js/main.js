/* Delete Unnecessary Script! */
$(document).ready(function(){
	var theurl;
	$('a.minibutton, input, textarea').bind({mousedown: function() {
		$(this).addClass('mousedown');
	},focus: function(){
		$(this).addClass('mousedown');
	},click: function(){
		$(this).addClass('mousedown');
	},blur: function(){
		$(this).removeClass('mousedown');
	},mouseup: function(){
		$(this).removeClass('mousedown');
	}});	
	$("#prev_").click(function(){
		location.href = $(this).attr('url');
	});
	$(".tampil").click(function(){
		theurl = $(this).parent().children().val();
		window.open(theurl, '_blank');
		return false;
	});
	$(".hapus").click(function(){
		if(confirm('Hapus File Terpilih sekarang?')){
			theurl = $(this).parent().children().val();
			theurl = theurl.split('/');
			theurl = theurl[theurl.length-1];
			$("#freg_").attr("action", $("#freg_").attr("action") + '/delete/' + theurl);
			$("#freg_").submit();
		}
		return false;
	});
	$("#filenya").change(function(){
		if(confirm('Upload File Pendukung Anda sekarang?')){
			$("#freg_").attr("action", $("#freg_").attr("action") + '/upload');
			$("#freg_").submit();
		}
		return false;
	});
	$("input, textarea, select").focus(function(){
		if($(this).attr('wajib')=="yes"){
			$(".msg_").fadeOut('slow');
			$("#msg_").fadeOut('slow');
			$(this).removeClass('wajib');
		}
	});
	
	$('#tab div').hide();
	$('#tab div:first').show();
	$('#tab ul li:first').addClass('current');
	$('#tab ul li a').click(function(){ 
		$('#tab ul li').removeClass('current');
		$(this).parent().addClass('current'); 
		$('#tab div').hide();
		var currentTab = $(this).attr('href'); 
		$(currentTab).show();
		return false;
	});	
	//FormReady();
});
function FormReady(){
	$("form :input:not(input:password,#EMAIL_USER,#EMAIL,#USERNAME)").change(function() {toUpper(this);});
}
function toUpper(obj) {
	var mystring = obj.value;
	newstring = mystring.toUpperCase();;
	obj.value = newstring;
	return true;  
}
function Autocomp(id,form){
	if(typeof(form)=='undefined'){var formid=""; }else{ var formid = "#"+form;}
	$(formid+" #"+id).autocomplete($(formid+" #"+id).attr('url'), {width: 226, selectFirst: false});
	$(formid+" #"+id).result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			var m = $(this).attr("urai").split(";");
			var a = 2;
			for(var c=0;c<(m.length)-1;c++){
				var tipe = $("#"+m[c]).get(0).tagName;
				if(tipe=='INPUT'){
					$(formid+' #'+m[c]).val(data[a]);
				}else{
					$(formid+' #'+m[c]).html(data[a]);
				}
				a++;
			}
		}
	});	
}
function validasi(divid,formid){	
	if(formid==""||typeof(formid)=="undefined") formid = "";	
	else formid = formid;		
	if(divid==""||typeof(divid)=="undefined") divid = "msg_";	
	else divid = divid;		
	$(formid+" ."+divid).hide();
	$(formid+" ."+divid).css('color', '');
	$(formid+" ."+divid).html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
	/*jloadings();*/
	$(formid+" ."+divid).fadeIn('slow');	
	var notvalid = 0;var notnumber = 0;var notaju = 0;var jumAju=26;
	var regNumber =/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
	$.each($(formid+" input:visible, "+formid+" select:visible, "+formid+" textarea:visible, "+formid+" input:checkbox, "+formid+" input:radio"), function(n,element){
		if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
			$(this).addClass('wajib');
			notvalid++;			
		}
		if($(this).attr('format')=="angka" && (!regNumber.test($(this).val()) && $(this).val()!="")){
			$(this).addClass('format');
			notnumber++;
		}
		if($(this).attr('aju')=="isi" && (this.value.length != jumAju && $(this).val()!="")){
			$(this).addClass('aju');
			notaju++;
		}
	});
	if(notvalid>0 || notnumber >0){
		var val1="";var val2="";var val3="";var pisah="";var pisah1="";
		if(notvalid>0){
		 	val1 ='Ada ' + notvalid + ' Kolom Yang Harus Diisi';
		}
		if(notnumber >0){
			val2 ='Ada '+notnumber+' Kolom Yang Harus Diisi Dengan Angka';	
		}
		if(notaju >0){
			val3 ='Ada '+notaju+' Kolom Yang Formatnya Tidak Valid';	
		}
		if(notvalid>0 && notnumber>0){
			pisah =' Dan ';
		}
		if(notnumber>0 && notaju>0){
			pisah1 =' Dan ';
		}
		if(notvalid>0 && notaju>0){
			pisah1 =' Dan ';
		}
		Clearjloadings();	
		$(formid+" ."+divid).css('color', 'red');
		$(formid+" ."+divid).html(val1+pisah+val2+pisah1+val3);
		$(formid+" ."+divid).fadeIn('slow');
		return false;
	}else{
		return true;	
	}		
	return false;
}
function ShowTime(obj_time){
	$('#'+obj_time).timepicker();
}
function ShowDP(id){
	$("#"+id).datepicker({onClose: function (){this.focus();},changeMonth: true, changeYear: true,  dateFormat: 'yy-mm-dd'});
}
function cancel(formid){
	$("input, textarea, select").removeClass('wajib');
	$("#"+formid+" span.uraian").html('');
	document.getElementById(formid).reset();
	return false;
}
function findInpWithTxt(txt) {
	 var t = null; 
	 $("input[type=text]").each(function(){ 
		 if ($(this).val().indexOf(txt) >= 0){ 
		 t = this; 
	 return false; 
		 } 
	 }); 
	 return t;
}
function Clearjloadings(){$("#popup_container").remove();$("#popup_overlay").remove();}
function c_div(id, inner){
	div = document.createElement("div");	
	div.innerHTML = '<div id="'+id+'" style="display: none;">'+inner+'</div>';
	document.body.appendChild(div);
}
function add_hidden(formname, key, value) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    'name-as-seen-at-the-server';
    input.value = value;
    formname.appendChild(input);
}
function c_dialog(id, title, inner, width, height, clobtn, modal, resize){
	$('#'+id).remove();
	c_div(id, '<div style="margin:20px 25px 5px 12px;">'+inner+'</div>');
	$("#"+id).dialog({bgiframe:true,resizable:false,autoOpen:true, modal: modal, title: title, height: height, width: width, resize: resize, 
		clobtn: clobtn,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		show:{ effect: 'drop', direction: "up" },
		hide:{ effect: 'drop', direction: "up" },
		close:function(){
    		$(this).dialog('destroy').remove();
  		}	 		 
		// effect: drop,explode,slide,Fade,Fold,highlight,Pulsate,Scale,Shake,Transfer
	});
}	
function Dialog(url,Divid,title,width,height){
	c_dialog(Divid, title, '<div id="idv_popup"></div>', width, height, "run-in", true, false);
	$("#"+Divid).html('<center><img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...</center>');
	$('#'+Divid).load(url);				
}
function Dialog_view(html,Divid,title,width,height){
	c_dialog(Divid, ':: '+title+' ::', '<div id="idv_popup"></div>', width, height, "run-in", true, false);
	$("#"+Divid).html(html);
}
function closedialog(id){$("#"+id).dialog('close');}
function print_(url, id, kodebarang, jenisdokumen, All, TIPE_PERIODE, ALL_SALDO,cetak) {
    if (typeof (kodebarang) == 'undefined')
        kodebarang = '';
    if (typeof (jenisdokumen) == 'undefined')
        jenisdokumen = '';
    if (typeof (All) == 'undefined' || All == '')
        All = 'FALSE';
    if (typeof (TIPE_PERIODE) == 'undefined')
        TIPE_PERIODE = '';
    if (kodebarang == "")
        kodebarang = "!";
    if (jenisdokumen == "")
        jenisdokumen = "!";
	
    window.open(url + '/' + id + '/' + kodebarang + '/' + jenisdokumen + '/' + All + '/' + TIPE_PERIODE + '/' + ALL_SALDO+'/'+cetak, '_blank', 'width=800, height=650,toolbar=0,location=0,menubar=0');
}
function GetRandomMath(){
	var Mathrandom = Math.floor(Math.random()*1001);
	return Mathrandom;
}
function viewrevisi(kode,no){
	$("#tab-"+no).removeClass('tabnotaktif');
	$(".tabnotaktif").html('');
	$("#tab-"+no).html('<br><br><center><img src=\"'+base_url+'img/_ldg.gif\" alt=\"\" /></center><br><br>');
	$.ajax({
		type: 'POST',
		url: site_url+"/revisi/data/"+kode,
		data: "ajax=1&view=1",
		success: function(data){
			$("#tab-"+no).html(data);	
			$("#tab-"+no).addClass('tabnotaktif');		
		}
	});
	if (kode == 1) {
		$('#jns_dok').html("Jenis Dokumen");
		$('#tipeNomor').html("Nomor Aju");
		$('#capNodaftar').html("Nomor Pendaftaran");
		$('#tdNodaftar').html("<input type='text' name='src[noPendaftaran]' id='noPendaftaran' class='text' />");
		$('#tdAwalAkhir').html("Tanggal Pendaftaran");
		$('#numberKey').attr('value', '');
		$('#tanggalAwal').attr('value', '');
		$('#tanggalAkhir').attr('value', '');
		$('#revisiJenisDok').html("<select id='jenisDok' class='mtext' name='src[jenisDok]'>\n\
									<option value='bc20'>1 - BC 2.0</option>\n\
									<option value='bc21'>2 - BC 2.1</option>\n\
									<option value='bc24'>3 - BC 2.4</option>\n\
									<option value='bc25'>4 - BC 2.5</option>\n\
									<option value='bc30'>5 - BC 3.0</option>\n\
									<option value='bc40'>6 - BC 4.0</option>\n\
									<option value='bc41'>7 - BC 4.1</option>\n\
									</select>");
		$('#btnDosearch').html("<a class='btn btn-small btn-primary' onclick='searchRevisi(\"#frmSearchRevisi\",\"1\")' href='javascript:void(0);' style='float:left'><i class='icon-search'></i>Search</a>");
	} else {
		$('#jns_dok').html("Tipe Dokumen");
		$('#tipeNomor').html("Nomor Transaksi");
		$('#capNodaftar').html("&nbsp;");
		$('#tdNodaftar').html("&nbsp;");
		$('#tdAwalAkhir').html("Tanggal Transaksi");
		$('#numberKey').attr('value', '');
		$('#tanggalAwal').attr('value', '');
		$('#tanggalAkhir').attr('value', '');
		$('#revisiJenisDok').html("<select id='jenisDok' class='mtext' name='src[jenisDok]'>\n\
									<option value='masuk'>1 - Bahan Untuk Diproses</option>\n\
									<option value='keluar'>3 - Hasil Produksi</option>\n\
									<option value='sisa'>4 - Scrap/Sisa Produksi</option>\n\
									</select>");
		$('#btnDosearch').html("<a class='btn btn-small btn-primary' onclick='searchRevisi(\"#frmSearchRevisi\",\"2\")' href='javascript:void(0);' style='float:left'><i class='icon-search'></i>Search</a>");
	}
	return false;
}
function searchRevisi(formid, tipe) {
	if ($('#tanggalAkhir').attr('wajib') == "yes") {
		if ($('#tanggalAkhir').val() == "") {
			$(".msg_").css('color', 'red');
			$(".msg_").html("Terdapat data yang belum di isi.");
			return false;
		}
	}
	$.ajax({
		type: 'post',
		url: site_url + '/revisi/data/' + tipe,
		data: 'ajax=1&'+$(formid).serialize(),
		success: function(data) {
			$('#divRevisi'+tipe).html(data);
		}
	});
}
function addWajib(id) {
	var dt = $(id).val();
	if (dt != "") {
		$('#tanggalAkhir').attr('wajib', 'yes');
	} else {
		$('#tanggalAkhir').attr('wajib', '');
	}
}
/*function addRowBarang(tableId,tbody_id){
	var content="";
	var nilai = $("#"+tableId+" tbody tr").size();
	var Mathrandom = GetRandomMath();				
	content= "<tr id=\"tr_"+Mathrandom+"\"><td class=\"alt2 left bright\"><input type=\"text\" name=\"DTLSURAT[KODE_BARANG][]\" id=\"KODE_BARANG"+Mathrandom+"\" style=\"width:10%;\" class=\"text\"  url=\""+site_url+"/autocomplete/barang2\" urai=\"NM_BARANG"+Mathrandom+";\" onfocus=\"Autocomp(this.id)\" />&nbsp;<input type=\"text\" name=\"NM_BARANG[]\" id=\"NM_BARANG"+Mathrandom+"\" style=\"width:80%;\" class=\"text\"/>&nbsp;<input type=\"button\" name=\"cari\" id=\"cari"+Mathrandom+"\" class=\"button\" onclick=\"tb_search('kodebarang','KODE_BARANG"+Mathrandom+";NM_BARANG"+Mathrandom+"','Kode Barang',this.form.id,600,400)\" value=\"...\"></td><td id=\"tdJenisBarang"+Mathrandom+"\" class=\"alt2 bright\"></td><td id=\"tdKondisiBarang"+Mathrandom+"\" class=\"alt2 bright\"></td><td class=\"alt2 bright\"><input type=\"text\" name=\"DTLSURAT[JUMLAH][]\" id=\"JUMLAH_BARANG\" class=\"stext\" /></td><td class=\"alt2 bright\"><input type=\"text\" name=\"DTLSURAT[KODE_SATUAN][]\" id=\"KODE_SATUAN"+Mathrandom+"\" class=\"ssstext\"  url=\""+site_url+"/autocomplete/satuan\" urai=\"\" onfocus=\"Autocomp(this.id)\"/></td><td class=\"alt2 right\"><a href=\"javascript:void(0)\" onclick=\"removeRowBarang('"+tableId+"','"+tbody_id+"','"+Mathrandom+"')\" title=\"Hapus Barang\" class=\"del\" style=\"color:#f00;font-size:22px;text-align:center\"><span><i class=\"fa fa-minus-circle\"></i></span></a></td></tr>";		 
	$("#"+tableId+" tbody:first").append(content);
	$("table#"+tableId+" td#tdJenisBarang").clone(true).removeAttr('id').appendTo('td#tdJenisBarang'+Mathrandom+'').removeClass('alt2');
	$("table#"+tableId+" td#tdKondisiBarang").clone(true).removeAttr('id').appendTo('td#tdKondisiBarang'+Mathrandom+'').removeClass('alt2');
}*/

//ASAL PAKE YANG BAWAH
/*function addRowBarang(tableId,tbody_id){
	var content="";
	var nilai = $("#"+tableId+" tbody tr").size();
	var Mathrandom = GetRandomMath();				
	content= "<tr id=\"tr_"+Mathrandom+"\"><td class=\"alt2 left bright\"><input type=\"text\" name=\"DTLSURAT[KODE_BARANG][]\" id=\"KODE_BARANG"+Mathrandom+"\" style=\"width:10%;\" class=\"text\"  url=\""+site_url+"/autocomplete/barang2\" urai=\"NM_BARANG"+Mathrandom+";\" onfocus=\"Autocomp(this.id)\" />&nbsp;<input type=\"text\" name=\"NM_BARANG[]\" id=\"NM_BARANG"+Mathrandom+"\" style=\"width:60%;\" class=\"text\"/>&nbsp;<input type=\"button\" name=\"cari\" id=\"cari"+Mathrandom+"\" class=\"btn btn-primary btn-sm\" onclick=\"tb_search('kodebarang','KODE_BARANG"+Mathrandom+";NM_BARANG"+Mathrandom+"','Kode Barang',this.form.id,600,400)\" value=\"...\"></td><td id=\"tdJenisBarang"+Mathrandom+"\" class=\"alt2 bright\"></td><td id=\"tdKondisiBarang"+Mathrandom+"\" class=\"alt2 bright\"></td><td class=\"alt2 bright\"><input type=\"text\" name=\"DTLSURAT[JUMLAH][]\" id=\"JUMLAH_BARANG\" class=\"stext\" /></td><td class=\"alt2 bright\"><input type=\"text\" name=\"DTLSURAT[KODE_SATUAN][]\" id=\"KODE_SATUAN"+Mathrandom+"\" class=\"ssstext\"  url=\""+site_url+"/autocomplete/satuan\" urai=\"\" onfocus=\"Autocomp(this.id)\"/></td><td class=\"alt2 right\"><a href=\"javascript:void(0)\" onclick=\"removeRowBarang('"+tableId+"','"+tbody_id+"','"+Mathrandom+"')\" title=\"Hapus Barang\" class=\"del\" style=\"color:#f00;font-size:22px;text-align:center\"><span><i class=\"fa fa-minus-circle\"></i></span></a></td></tr>";		 
	$("#"+tableId+" tbody:first").append(content);
	$("table#"+tableId+" td#tdJenisBarang").clone(true).removeAttr('id').appendTo('td#tdJenisBarang'+Mathrandom+'').removeClass('alt2');
	$("table#"+tableId+" td#tdKondisiBarang").clone(true).removeAttr('id').appendTo('td#tdKondisiBarang'+Mathrandom+'').removeClass('alt2');
}*/
function addRowBarang(tableId,tbody_id){
	var content="";
	var nilai = $("#"+tableId+" tbody tr").size();
	var Mathrandom = GetRandomMath();				
	content= "<tr id=\"tr_"+Mathrandom+"\"><td id=\"tdBarang"+Mathrandom+"\" class=\"alt2 left bright\"><input type=\"mtext\" name=\"DTLSURAT[KODE_BARANG][]\" wajib=\"yes\" readonly id=\"KODE_BARANGSRT"+Mathrandom+"\" style=\"width:15%;\" class=\"text\"  url=\""+site_url+"/autocomplete/barang2\" urai=\"NM_BARANG"+Mathrandom+";\" onfocus=\"getGudangBarang("+Mathrandom+")\" />&nbsp;<input type=\"text\" name=\"NM_BARANG[]\" id=\"NM_BARANG"+Mathrandom+"\" style=\"width:60%;\" class=\"text\"/>&nbsp;<input type=\"button\" name=\"cari\" id=\"cari"+Mathrandom+"\" class=\"btn btn-primary btn-xs\" onclick=\"tb_search('barang_gudang','KODE_BARANGSRT"+Mathrandom+";NM_BARANG"+Mathrandom+";JNS_BARANG"+Mathrandom+";JENIS_BARANG"+Mathrandom+"','Kode Barang',this.form.id,600,400)\" value=\"&nbsp;...&nbsp;\"></td><td id=\"tdJenisBarang"+Mathrandom+"\" class=\"alt2 bright\"><input type=\"hidden\" id=\"JNS_BARANG"+Mathrandom+"\" name=\"DTLSURAT[JNS_BARANG][]\"/><input type=\"text\" id=\"JENIS_BARANG"+Mathrandom+"\" wajib=\"yes\" class=\"stext\" /></td><td id=\"tdKondisiBarang"+Mathrandom+"\" class=\"alt2 bright\"></td><td id=\"tdGudang"+Mathrandom+"\" class=\"alt2 bright\"></td><td id=\"tdRak"+Mathrandom+"\" class=\"alt2 bright\"></td><td id=\"tdSubRak"+Mathrandom+"\" class=\"alt2 bright\"></td><td class=\"alt2 bright\"><input type=\"text\" id=\"JUMLAH\" onkeyup=\"this.value = ThausandSeperator('JUMLAH_BARANG"+Mathrandom+"',this.value,4);\" class=\"stext\" /> <input type=\"hidden\" value=\"\" name=\"DTLSURAT[JUMLAH][]\" id=\"JUMLAH_BARANG"+Mathrandom+"\" /></td><td class=\"alt2 bright\"><input type=\"text\" name=\"DTLSURAT[KODE_SATUAN][]\" id=\"KODE_SATUAN"+Mathrandom+"\" class=\"ssstext\"  url=\""+site_url+"/autocomplete/satuan\" wajib=\"yes\" urai=\"\" onfocus=\"Autocomp(this.id)\"/></td><td class=\"alt2 right\"><a href=\"javascript:void(0)\" onclick=\"removeRowBarang('"+tableId+"','"+tbody_id+"','"+Mathrandom+"')\" title=\"Hapus Barang\" class=\"del\" style=\"color:#f00;font-size:22px;text-align:center\"><span><i class=\"fa fa-minus-circle\"></i></span></a></td></tr>";		 
	$("#"+tableId+" tbody:first").append(content);
	//$("table#"+tableId+" td#tdJenisBarang1").clone(true).removeAttr('id').appendTo('td#tdJenisBarang'+Mathrandom+'').removeClass('alt2');
	$("table#"+tableId+" td#tdKondisiBarang1").clone(true).removeAttr('id').appendTo('td#tdKondisiBarang'+Mathrandom+'').removeClass('alt2 bright');
	$("table#"+tableId+" td#tdKondisiBarang"+Mathrandom+" #KONDISI_BARANG1").removeAttr('id').attr('id',"KONDISI_BARANG"+Mathrandom+"");
	$("#KONDISI_BARANG"+Mathrandom+"").empty();
	$("#KONDISI_BARANG"+Mathrandom+"").append($('<option>', { value : "BAIK" }).text("BAIK"),$('<option>', { value : "RUSAK" }).text("RUSAK")); 
	
	$("table#"+tableId+" td#tdGudang1").clone(true).removeAttr('id').appendTo('td#tdGudang'+Mathrandom+'').removeClass('alt2 bright');
	$("table#"+tableId+" td#tdGudang"+Mathrandom+" #KODE_GUDANG1").removeAttr('onchange').attr('onchange',"getRak('"+Mathrandom+"')");
	$("table#"+tableId+" td#tdGudang"+Mathrandom+" #KODE_GUDANG1").removeAttr('id').attr('id',"KODE_GUDANG"+Mathrandom+"");
	$("#KODE_GUDANG"+Mathrandom+"").empty();	
	
	$("table#"+tableId+" td#tdRak1").clone(true).removeAttr('id').appendTo('td#tdRak'+Mathrandom+'').removeClass('alt2 bright');
	$("table#"+tableId+" td#tdRak"+Mathrandom+" #KODE_RAK1").removeAttr('onchange').attr('onchange',"getSubrak('"+Mathrandom+"')");
	$("table#"+tableId+" td#tdRak"+Mathrandom+" #KODE_RAK1").removeAttr('id').attr('id',"KODE_RAK"+Mathrandom+"");
	$("#KODE_RAK"+Mathrandom+"").empty();
	$("table#"+tableId+" td#tdSubRak1").clone(true).removeAttr('id').appendTo('td#tdSubRak'+Mathrandom+'').removeClass('alt2 bright');
	$("table#"+tableId+" td#tdSubRak"+Mathrandom+" #KODE_SUB_RAK1").removeAttr('id').attr('id',"KODE_SUB_RAK"+Mathrandom+"");
	$("#KODE_SUB_RAK"+Mathrandom+"").empty();
		
}
function getRak(formid,id){/*alert(formid+"."+id);return false;*/
	var kdGudang = $("#tdGudang"+id+" #KODE_GUDANG").val();
	$.ajax({
		type: 'post',
		url: site_url + '/inventory/getRak/barang',
		data: {kode_gudang:kdGudang,tdId:id,formId:formid},
		success: function(data) {
			if(formid=="finventory"){
				$("table#tableGudang td#tdRak"+id).html(data);
				$('table#tableGudang td#tdSubRak'+id+' #KODE_SUB_RAK').empty();
				$('table#tableGudang td#tdSubRak'+id+' #KODE_SUB_RAK').removeAttr('wajib').append($('<option>', { value : "" }).text("-- Pilih --"));
			}
			if(formid=='fsurat_'){
				$('table#tableBarang td#tdRak'+id+' #KODE_RAK1').html(data);
			}
			if(formid=='fstock-barang'){
				data = data.replace('<combo>',"\n");
				data = data.replace('</combo>',"\n");
				$('td#tdRak'+id+' #KODE_RAK').remove();
                $('td#tdRak'+id+' #rak').append(data);
				$('td#tdSubRak'+id+' #KODE_SUB_RAK').empty();
				$('td#tdSubRak'+id+' #KODE_SUB_RAK').removeAttr('wajib');
			}
		}
	});
	
}

function getSubrak(formid,id){
	var kdGudang = $("#tdGudang"+id+" #KODE_GUDANG").val();
	var kdRak = $("#tdRak"+id+" #KODE_RAK").val();
	$.ajax({
		type: 'post',
		url: site_url + '/inventory/getSubrak/barang',
		data: {kode_gudang:kdGudang,kode_rak:kdRak,formId:formid},
		success: function(data) {
			if(formid=="finventory"){
				$("table#tableGudang td#tdSubRak"+id).html(data); 

			}
			if(formid=='fstock-barang'){
				data = data.replace('<combo>',"\n");
				data = data.replace('</combo>',"\n");
				$('td#tdSubRak'+id+' #KODE_SUB_RAK').remove();
				$('td#tdSubRak'+id+' #subrak').append(data);
			} 
		}
	});
	
}
function getGudangBarang(id){
    var kdBrg = $("#tdBarang"+id+" #KODE_BARANGSRT"+id).val();
    var jnsBrg = $("#tdJenisBarang"+id+" #JNS_BARANG"+id).val();
    if (kdBrg != "") {        
        $.ajax({
            type: 'post',
            url: site_url + '/pengeluaran/getGudangBarang',
            data: {kode_barang:kdBrg, jns_barang: jnsBrg, tdId:id},
            success: function(data) {
                var arrdata = data.split("#");
				$("table#tableBarang td#tdGudang"+id).html(arrdata[0]);  
				$("table#tableBarang td#tdKondisiBarang"+id).html(arrdata[1]);  
            }
        });
    }
}
function removeRowBarang(tableId,tBodyId,id){
	$("#"+tableId+" tr[id=tr_"+id+"]").remove();	
}	
function save_post(formid){	
	if(formid==""||typeof(formid)=="undefined") formid = "";	
	else formid = formid;	
	if(validasi('',formid)){
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			success: function(data){
				Clearjloadings();	
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$(".msg_").css('color', 'green');
						$(".msg_").html(arrdata[2]);
					}else{
						$(".msg_").css('color', 'red');
						$(".msg_").html(arrdata[2]);
					}
					if(arrdata.length>3){
						setTimeout(function(){location.href = arrdata[3];}, 2000);
						return false;
					}
				}else{
					$(".msg_").css('color', 'red');
					$(".msg_").html('Proses Gagal.');
				}
			}
		});
	}return false;
}
function save_surat(formid){	
	$(".msgsurat_").hide();
	$(".msgsurat_").css('color', '');
	$(".msgsurat_").html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
	$(".msgsurat_").fadeIn('slow');
	var notvalid = 0;
	$.each($("input:visible, select:visible, textarea:visible"), function(){
		if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
			$(this).addClass('wajib');
			notvalid++;
		}
	});
	if(notvalid>0){
		$(".msgsurat_").css('color', 'red');
		$(".msgsurat_").html('Ada ' + notvalid + ' Kolom Yang Harus Diisi');
		$(".msgsurat_").fadeIn('slow');
		return false;
	}else{
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action') + '/ajax',
			data: $(formid).serialize(),
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$(".msgsurat_").css('color', 'green');
						$(".msgsurat_").html(arrdata[2]);
						$("#divtmp").html('<input type="hidden" name="TMP_DATA" id="TMP_DATA" value="1">');
						$("#tabs").tabs( "enable" , 1 )
						$("#tabs").tabs( "select" , 1 )
						$("form").find("#noaju").val(arrdata[3]);
						$("form").find("#noajuIn").val(arrdata[3]);
						$("form").find("#noajuIn").attr("readonly",true)
						$("form").find("#act").val('update');
					}else{
						$(".msgsurat_").css('color', 'red');
						$(".msgsurat_").html(arrdata[2]);
					}
				}else{
					$(".msghemsgsurat_ader_").css('color', 'red');
					$(".msgsurat_").html('Proses Gagal.');
				}
			}
		});	
	}			
	return false;
}
function save_header(formid){
	if($(formid).find("#saved").length > 0){
		jAlert("Data sudah pernah disimpan.<br>Silahkan lengkapi Data detil atau Buat Permohonan baru.","PLB Inventory")
	}else{	
		if(validasi("msgheader_")){	
			jConfirm('Anda yakin Akan memproses data ini?', " PLB Inventory ", 
			function(r){if(r==true){	
				if($("#TMP_DATA").length > 0){ 
					var arrdt = $('#fsurat_').serialize()+"&"+$(formid).serialize();
				}else{
					var arrdt = $(formid).serialize();	
				}
				$.ajax({
					type: 'POST',
					url: $(formid).attr('action') + '/ajax',
					data: arrdt,
					success: function(data){	
						Clearjloadings();				
						if(data.search("MSG")>=0){
							arrdata = data.split('#');
							if(arrdata[1]=="OK"){
								$(".msgheader_").css('color', 'green');
								$(".msgheader_").html(arrdata[2]);
								if($("#TMP_DATA").length > 0){
									$("ul.nav li a").removeClass('disabled');
									$(".nav-tabs li").removeClass('active');
									$(".nav-tabs li:eq(1)").addClass('active');
									$(".tab-content div").removeClass('active');
									$("#tabBarang").addClass('active');
									$("form").find("#NOMOR_AJU").val(arrdata[3]);
									$(formid).find("#divtmp").append('<input type="hidden" name="saved" id="saved" value="1">');
								}else{					
									$("ul.nav li a").removeClass('disabled');
									$(".nav-tabs li").removeClass('active');
									$(".nav-tabs li:eq(1)").addClass('active');
									$(".tab-content div").removeClass('active');
									$("#tabBarang").addClass('active');
									$("form").find("#NOMOR_AJU").val(arrdata[3]);
								}
								if(((formid=='#fpengrusakan') || (formid=='#fpemusnahan') || (formid=='#fprofil_') || (formid=='#fpemasok') || (formid=='#fuser') || (formid=='#fmapping') || (formid=='#fkonversihp') || (formid=='#fgudang')) && arrdata[3] !='stop'){
									setTimeout(function(){location.href = arrdata[3];}, 2000);
								}								
								if(arrdata[4])$("#DivHeaderForm").load(arrdata[4]);
								if(arrdata[5]=='bc28' || arrdata[5]=='bc41'){
									var tipe = 'pengeluaran';
								}else{var tipe = 'pemasukan';}				
								$("#SpanStatus").html("<a href=\"javascript:void(0)\" onclick=\"Cekstatus('"+site_url+"/"+tipe+"/cekstatus/"+arrdata[3]+"/"+arrdata[5]+"');\" style=\"float:right;margin:4px 4px 0px 0px\" class=\"btn btn-sm btn-warning\" id=\"ok_\"><span><i class=\"icon-info-sign\"></i>&nbsp;Cek Status&nbsp;</a>");
							}else{
								$(".msgheader_").css('color', 'red');
								$(".msgheader_").html(arrdata[2]);
							}
						}else{
							$(".msgheader_").css('color', 'red');
							if(formid=='#fpass')
								$(".msgheader_").html(arrdata[2]);
								
							$(".msgheader_").html('Proses Gagal.');
						}
					}
				});
			 }else{return false;}});
		}return false;	
   }
}
function save_detil(formid,msg){
	if(validasi(msg)){		
		if($('#fperbaikan_').serialize()){			
			var data = $(formid).serialize()+"&"+$('#fperbaikan_').serialize();
		}else{
			var data = $(formid).serialize();	
		}		
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action') + '/ajax',
			data: data,
			success: function(data){
				Clearjloadings();	
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$("."+msg).css('color', 'green');
						$("."+msg).html(arrdata[2]);
										
						var perbaikan="";
						if($("#fperbaikan_ #PERBAIKAN_KODE_KPBC").val()){
							perbaikan = "/perbaikan";
						}
						
						$(formid+"list").load($(formid).attr('list')+"/"+$(formid).find("#NOMOR_AJU").val()+""+perbaikan, function() {
							 $(formid+"list").append('<script type="text/javascript" src="'+base_url+'/assets/js/newtable.js"></script>');
							  if(arrdata[3]=="edit"){
								  $(formid+"form").html('');
							  }
						});
						if(arrdata[4])$("#DivHeaderForm").load(arrdata[4]);
						cancel(formid.replace("#",""));
						$("#notify").fadeIn('Slow'); 
						if(formid=='#frealisasi_in'||formid=='#frealisasi_out'){
							$(formid).find('#TOTALPARSIAL').val('');
						}
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
}
function save_dialog(formid,msg){
	if(validasi(msg)){		
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
						$(".view").load($(formid).attr('list'));
						Clearjloadings();
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
}
function Cekstatus(url){
	jloadings();
	$.ajax({
		url: url,
		success: function(data){
			jAlert(data,"PLB Inventory");
			return false;
		}
	});	
}
function list_tbl(dok,divid,url){
	jloadings();
	page=url+"/"+dok;
	$('#'+divid).load(page,function(){
		Clearjloadings();	
	});
};
function goToPage(urlLoad,divData,msg){
	var index =  $("input#txtGoTo").val();
	index = parseInt(index);
	jloadings();
    $.ajax({
      url: urlLoad,
      type: "POST",
      data: {index:index},
	  success:function(data){
		$('#'+divData).show();
		$('#'+divData).html(data);
		Clearjloadings();
	}
    });
}
/* number format*/
String.prototype.reverse = function(){
    var s = "";
    var i = this.length;
    while (i>0) {
        s += this.substring(i-1,i);
        i--;
    }
    return s;
} 
/*using by function ThausandSeperator!!*/
function removeCharacter(v, ch){
	var tempValue = v+"";
	var becontinue = true;
		while(becontinue == true){
			var point = tempValue.indexOf(ch);
			if( point >= 0 ){
				var myLen = tempValue.length;
				tempValue = tempValue.substr(0,point)+tempValue.substr(point+1,myLen);
				becontinue = true;
			}else{
			becontinue = false;
		}
	}
	return tempValue;
}
function characterControl(value){
	var tempValue = "";
	var len = value.length;
	for(i=0; i<len; i++){
		var chr = value.substr(i,1);
		if( (chr < '0' || chr > '9') && chr != '.' && chr != ',' ){
			chr = '';
		}   
		tempValue = tempValue + chr;
	}
	return tempValue;
}
function ThausandSeperator(hidden,value, digit){
	var thausandSepCh = ",";
	var decimalSepCh = ".";
	var tempValue = "";
	var realValue = value+"";
	var devValue = "";
	if(digit=="")digit=3;
	realValue = characterControl(realValue);
	var comma = realValue.indexOf(decimalSepCh);
	if(comma != -1 ){
		tempValue = realValue.substr(0,comma);
		devValue = realValue.substr(comma);
		devValue = removeCharacter(devValue,thausandSepCh);
		devValue = removeCharacter(devValue,decimalSepCh);
		devValue = decimalSepCh+devValue;
		if( devValue.length > digit){
			devValue = devValue.substr(0,digit+1);
		}
	}else{
		tempValue = realValue;
	}
	tempValue = removeCharacter(tempValue,thausandSepCh);	
	var result = "";
	var len = tempValue.length;
	while(len > 3){
		result = thausandSepCh+tempValue.substr(len-3,3)+result;
		len -=3;
	}
	result = tempValue.substr(0,len)+result;	
	if(hidden!=""){
		$("#"+hidden).val(tempValue+devValue);	
	}
	return result+devValue;
}

function save_POP(formid, msg, divData, page, jenis, divDialog) {

    if (validasi(msg, formid)) {
        $.ajax({
            type: 'POST',
            url: $(formid).attr('action'),
            data: $(formid).serialize(),
            success: function(data) {
                if (data.search("MSG") >= 0) {
                    arrdata = data.split('#');
                    if (arrdata[1] == "OK") {//alert(page);return false;
                        if (arrdata[3] == "ID") {
                            $.ajax({
                                type: 'POST',
                                url: site_url + '/inventory/add/stockPOPN',
                                data: $(formid).serialize(),
                                success: function(data) {
                                    var tes = $('#fstock #ID').val();//alert(tes);return false;
                                    var val = parseInt(tes) + 1;//alert(val);return false;
                                    $('#fstock #ID').val(val);
                                }
                            });
                        }

                        $("#" + divData).load(page);
                        if (jenis == 'update') {//alert('sini');
                            closedialog(divDialog);
                            $("#" + divData).load(page);
                        }
                        if (jenis == 'edit') {//alert(divDialog);
                            closedialog(divDialog);
                        }
                        $("." + msg).css('color', 'green');
                        $("." + msg).html(arrdata[2]);

                        cancel(formid.replace("#", ""));
                        $("#" + formid + " #uraisatdet").empty().append("");
                    } else {
                        $("." + msg).css('color', 'red');
                        $("." + msg).html(arrdata[2]);
                    }
                } else {
                    $("." + msg).css('color', 'red');
                    $("." + msg).html('Proses Gagal.');
                }
                Clearjloadings();
            }
        });
    }
    return false;

}

function save_popup(formid,msg,div){ 
	if(validasi(msg)){	
		jloadings();	
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
					if(arrdata.length>3){
						$('#'+div).load(arrdata[3]);
						closedialog('dialog-tbl');
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
				Clearjloadings();
			}
		});	
	}return false;	
}
function save_popup_freeze(formid,msg,div){
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
						cancel(formid.replace('#',''));
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}					
					if(arrdata.length>3){ //alert(arrdata[3]);
						$('#'+div).load(arrdata[3]); //alert(ihp[0]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
}
function update_stock(tgl){
	jConfirm('PERHATIAN!<br>PROSES INI AKAN MERUBAH JUMLAH STOCK AKHIR BARANG ANDA SAMA DENGAN JUMLAH STOCKOPNAME BERIKUT<br>DENGAN MENGABAIKAN MUTASI YANG SUDAH TERJADI! ANDA YAKIN AKAN MELANJUTKAN PROSES INI?', " PLB Inventory ", 
	function(r){if(r==true){	
		jloadings();
		$.ajax({
		type: 'POST',
		url: site_url + '/inventory/update_stock',
		data: 'TANGGAL='+tgl,
		success: function(data){
			if(data.search("MSG")>=0){
				arrdata = data.split('#');
				jAlert(arrdata[2],'PLB Inventory');
			}else{	
				jAlert('Proses Gagal!','PLB Inventory');
			}
		}
	});		
	}else{return false;}});	
}
function save_Detil2(formid,msg,page,act,direct){
	jConfirm('Anda yakin Akan memproses data ini?', " PLB Inventory ", 
	function(r){if(r==true){
	if(validasi(msg)){		
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			beforeSend: function(){jloadings();},
			complete: function(){Clearjloadings();},
			success: function(data){
				//alert(data);return false;
				if(data.search("MSG")>=0){
					arrdata = data.split('#');//alert(arrdata);
					if(arrdata[1]=="OK"){
						$("."+msg).css('color', 'green');
						$("."+msg).html(arrdata[2]);
						if(act=='edit'){
							closedialog(divDialog);
						}else if(act=='addKnv'){
							location.href= site_url+'/inventory/add/Konversi_New';
						}else if(act=='addKnvSub'){
							location.href= site_url+'/inventory/add/Konversi_Sub_New';
						}else if(act=='addBBAKU'){//alert('sini');
							if(typeof(direct)=="undefined"||direct==""){
								location.href= site_url+'/produksi/add/Bhn_Baku_New';
							}else{
								location.href= site_url+'/produksi/daftar/bahan_baku';
							}
						}else if(act=='addHSLPROD'){							
							if(typeof(direct)=="undefined"||direct==""){
								location.href= site_url+'/produksi/add/Hsl_Prod_New';
							}else{
								location.href= site_url+'/produksi/daftar/hasil_produksi';
							}
						}else if(act=='addHSLSISA'){
							if(typeof(direct)=="undefined"||direct==""){
								location.href= site_url+'/produksi/add/Hsl_Sisa_New';
							}else{
								location.href= site_url+'/produksi/daftar/hasil_sisa';
							}
						}else if(act=='addMutasiBB' || act=='addMutasiBJ' || act=='addMutasiBS' || act=='addMutasiMS'){
						}else{
							location.href = page;	
							cancel(formid.replace("#",""));
						}
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
	}else{return false;}});	
}
function ClosePopUp(page,divDialog,jenis){
	if(jenis=="edit")closedialog(divDialog); 
	location.href=page;	
}
function Laporan(formid,msg,divData,page,jenis){
	if(validasi(formid)){
		jloadings();
		$.ajax({
			type: 'POST',
			url: page,
			data: $('#'+formid).serialize(),
			success: function(data){				
				$("#"+divData).html(data);
				Clearjloadings();
			}
		})
	}return false;	
}
function cetak_laporan(tipe,jenis){
	document.frmLaporanPros.action = site_url + "/laporan/proses/"+tipe+"/1/"+jenis+'/'+tipe;
	document.frmLaporanPros.method = "POST";
	document.frmLaporanPros.target = "_blank";
	document.frmLaporanPros.submit();
}
function LaporanList(formid,msg,divData,divHide,hideBtn,page,jenis){
	$("#CETAKAWAL").hide();	
	$("#"+divData).show();
	$("#"+hideBtn).show();
	$("#"+divHide).hide();
	if(validasi(formid)){
		jloadings();
		$.ajax({
			type: 'POST',
			url: page,
			data: $('#'+formid).serialize(),
			success: function(data){
				//console.log(data);				
				$("#"+divData).html(data);
				Clearjloadings();
			}
		})
	}return false;	
}
function multiReplace(str, match, repl) {
    do {
        str = str.replace(match, repl);
    } while(str.indexOf(match) !== -1);
    return str;
}
function FormatHS(varnohs){
	if (varnohs!=""){
		varnohs = multiReplace(varnohs,'.','');
		var varresult = '';
		var varresult = varnohs.substr(0,4)+"."+varnohs.substr(4,2)+"."+varnohs.substr(6,2)+"."+varnohs.substr(8,2);
		return varresult;
	}
}
function HitungMutasi(formid,nomor,tipe){	
	if(tipe=='mutasiBB' || tipe=='mutasiBJ' || tipe=='mutasiBS' || tipe=='mutasiMS'){
		var JUMLAH_SALDO_AWAL=($("#"+formid+" #JUMLAH_SALDO_AWAL_"+nomor).val()!=""?multiReplace($("#"+formid+" #JUMLAH_SALDO_AWAL_"+nomor).val(),',',''):0);
		var PEMASUKAN=($("#"+formid+" #PEMASUKAN_"+nomor).val()!=""?multiReplace($("#"+formid+" #PEMASUKAN_"+nomor).val(),',',''):0);
		var PENGELUARAN=($("#"+formid+" #PENGELUARAN_"+nomor).val()!=""?multiReplace($("#"+formid+" #PENGELUARAN_"+nomor).val(),',',''):0);
		var PENYESUAIAN=($("#"+formid+" #PENYESUAIAN_"+nomor).val()!=""?multiReplace($("#"+formid+" #PENYESUAIAN_"+nomor).val(),',',''):0);
		var STOCKOPNAME=($("#"+formid+" #STOCKOPNAME_"+nomor).val()!=""?multiReplace($("#"+formid+" #STOCKOPNAME_"+nomor).val(),',',''):0);
		var JUMLAH_SALDO_AKHIR=($("#"+formid+" #JUMLAH_SALDO_AKHIR_"+nomor).val()!=""?multiReplace($("#"+formid+" #JUMLAH_SALDO_AKHIR_"+nomor).val(),',',''):0);
		
		var JUM_SALDO_AKHIR=parseFloat(JUMLAH_SALDO_AWAL)+parseFloat(PEMASUKAN)-parseFloat(PENGELUARAN)+parseFloat(PENYESUAIAN);
		console.log(JUMLAH_SALDO_AWAL+'+'+PEMASUKAN+'-'+PENGELUARAN+'+'+PENYESUAIAN+'='+JUM_SALDO_AKHIR)
		if(STOCKOPNAME==""){
			var SELISIH ="";
		}else{
			var SELISIH=parseFloat(STOCKOPNAME)-parseFloat(JUM_SALDO_AKHIR)+parseFloat(PENYESUAIAN);
		}
		var separator1="";var separator2="";
		if(SELISIH<0)  separator1 = "-";
		if(JUM_SALDO_AKHIR<0)  separator2 = "-";
		($("#"+formid+" #JUMLAH_SALDO_AKHIR_"+nomor).val(separator2+''+ThausandSeperator('',JUM_SALDO_AKHIR,2)));
		($("#"+formid+" #SELISIH_"+nomor).val(separator1+''+ThausandSeperator('',SELISIH,2)));
		$("#"+formid+" #KETERANGAN_"+nomor).val(getKeterangan(SELISIH));
	}	
}
function getKeterangan(jml){
	if(jml<0) return "SELISIH KURANG";
	if(jml>0) return "SELISIH LEBIH";
	if(jml==0) return "SESUAI";
}
function getDataCombo(form,val,get){
	var getVal=$("#"+form+" #"+val).val();
	$("#"+form+" #"+get).val(getVal);
}
function uploadData(data){
	var namaForm = 'btnUploadData';
	var width = 800;
	var height = 300;
	var winl = (screen.width - width) / 2;
	var wint = (screen.height - height) / 2;
	var url = site_url + '/upload/upload_'+data;
	var popupname = 'upload_goods';
	popupWindow = window.open(url, popupname, 'left='+winl+',top='+wint+',width='+width+', height='+height+',scrollbars=yes,resizable=yes,statusbar=yes');
}
function limitChars(textid, limit, infodiv){
	var text = $('#'+textid).val(); 
	var textlength = text.length;
	if(textlength > limit){
		$('#' + infodiv).html('<font color="red">Tidak bisa lebih dari '+limit+' karakter!</font>');
		$('#'+textid).val(text.substr(0,limit));
		return false;
	}else{
		$('#' + infodiv).html('<font color="green">'+(limit - textlength) +' karakter yang tersisa.</font>');
		return true;
	}
}
//registr
function change_captcha(){
	document.getElementById('captcha').src=base_url+"app/libraries/captcha/captcha.php?rnd=" + Math.random();
}	
function savereg(formid){	
	jConfirm('Anda yakin Akan memproses data ini?', " PLB Inventory ", 
	function(r){if(r==true){	
		if(validasi()){
			$.ajax({
				type: 'POST',
				url: $(formid).attr('action'),
				data: $(formid).serialize(),
				success: function(data){
					Clearjloadings();
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							$(".msg_").css('color', 'green');
							$(".msg_").html(arrdata[2]);
						}else{
							$(".msg_").css('color', 'red');
							$(".msg_").html(arrdata[2]);
						}
						if(arrdata.length>3){
							setTimeout(function(){location.href = arrdata[3];}, 5000);
							return false;
						}
					}else{
						$(".msg_").css('color', 'red');
						$(".msg_").html('Proses Gagal.');
					}
				}
			});
		}return false;
	}else{return false;}})
}
function uploadlogo(folder,element,id){ //alert('tes');
	$('#Uploads').ajaxStart(function(){
        $(this).html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
      })
      .ajaxComplete(function(){
         $(this).hide();
      });
	$.ajaxFileUpload({ 
		url: site_url+'/register/uploadlogo/'+folder+'/'+element+'/'+id,
		secureuri:false,
		fileElementId:element,
		dataType:'json',
		success:function(data, status){ 
			if(typeof(data.error)!='undefined'){
				if(data.error!=''){
					jAlert(data.error,'PLB Inventory');
				}else{
					if(element=='logoprofil'){
						$('#FileUpload').html(data.msg);
						$('#Filelogo').html("<input type=\"file\" id=\""+element+"\" name=\""+element+"\" onchange=\"getElementById('btnupload').value = getElementById('"+element+"').value;\" size=\"10\" class=\"logo\"/><div id=\"BrowserVisible\"><a href=\"javascript:void(0);\" class=\"button add\" id=\"btnupload\"><span><span class=\"icon\"></span>&nbsp;Browse&nbsp;</span></a>&nbsp;<span id=\"Uploads\"></span></div><script>$('input[name="+element+"]').change(function(){if($('#ID').val()==''){jAlert('Mohon lengkapi data terlebih dahulu','PLB Inventory');}else{uploadlogo('logo','"+element+"',$('#ID').val());}});</script>");	
					}else{
						$('#FileUpload').html('<div id="BrowserVisible" style="top:-50px;left:5px">'+data.msg+'</div>');
					}
				}
			}
		},
		error: function(data, status, e){
			jAlert(e,'PLB Inventory');
		}
	})
}
function deleteFupload(filename,element){
	$.ajax({
		url: site_url+'/register/deletelogo/'+filename,
		beforeSend: function(){
				$("#BrowserVisible").html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
			},			
		success: function(data){
			if(data=='gagal'){
				jAlert("Can not delete file");
			}else{
				$("#FileUpload").html("<input type=\"file\" id=\""+element+"\" name=\""+element+"\" onchange=\"getElementById('btnupload').value = getElementById('"+element+"').value;\" size=\"10\" class=\"logo\"/><div id=\"BrowserVisible\">: <a href=\"javascript:void(0);\" class=\"button add\" id=\"btnupload\"><span><span class=\"icon\"></span>&nbsp;Browse&nbsp;</span></a>&nbsp;<span id=\"Uploads\"></span></div><script>$('input[name="+element+"]').change(function(){if($('#ID').val()==''){jAlert('Mohon lengkapi data terlebih dahulu','PLB Inventory');}else{uploadlogo('logo','"+element+"',$('#ID').val());}});</script>");	
			}
		}	
	});	
}
function mapCekpartner(formid){
	if(validasi()){
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$(".msg_").css('color', 'green');
						$(".msg_").html(arrdata[2]);
						location.href = arrdata[3]
					}else{
						$(".msg_").css('color', 'red');
						$(".msg_").html(arrdata[2]);
					}
				}else{
					$(".msg_").css('color', 'red');
					$(".msg_").html('Proses Gagal.');
				}
			}
		});
	}return false;
}
function save_BB_load(formid,msg,divData,page,jenis,divDialog,urlForm){
	var JUMBB=$("#JUMLAH_BB").val();//alert(JUMBB);return false;
	var input = $("#JUMLAH_BB");
	var JUM_BHNBKU=$("#JUMLAH_BHNBKU").val();//alert(JUMBB);return false;
	var inputBhnBku = $("#JUMLAH_BHNBKU");
	//if(validasi(msg)){		
	$("."+msg).hide();
	$("."+msg).css('color', '');
	$("."+msg).html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
	$("."+msg).fadeIn('slow');
	var notvalid = 0;
	$.each($(formid+" input:visible,"+formid+" select:visible,"+formid+" textarea:visible"), function(){
		if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
			$(this).addClass('wajib');
			notvalid++;
		}
	});
	if(notvalid>0){
		$("."+msg).css('color', 'red');
		$("."+msg).html('Ada ' + notvalid + ' Kolom Yang Harus Diisi');
		$("."+msg).fadeIn('slow');
		return false;
	}else{
		$.ajax({
			type: 'POST',
			url:urlForm,
			data: $(formid).serialize(),
			success: function(data){
				//alert(data);
				if(data.search("MSG")>=0){
					arrdata = data.split('#');//alert(arrdata);
					if(arrdata[1]=="OK"){
						$("."+msg).css('color', 'green');
						$("."+msg).html(arrdata[2]);
						$("#"+divData).load(page);
						if(jenis=='save'){
							input.val(parseFloat(JUMBB)+1);
							inputBhnBku.val(parseFloat(JUM_BHNBKU)+1);
						}
						if(jenis=='edit'){
							closedialog(divDialog);
							$("#"+divData).load(page);
						}	
						cancel(formid.replace("#",""));
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
}
function cekperbaikan(formid){
	if(validasi()){
		$(formid).submit();	
	}return false;
}
function intInput(event, keyRE) {
	if ( String.fromCharCode(((navigator.appVersion.indexOf('MSIE') != (-1)) ? event.keyCode : event.charCode)).search(keyRE) != (-1)
		|| ( navigator.appVersion.indexOf('MSIE') == (-1)
			&& ( event.keyCode.toString().search(/^(8|9|13|45|46|35|36|37|39)$/) != (-1) 
				|| event.ctrlKey || event.metaKey ) ) ) {
		return true;
	} else {
		return false;
	}
}
function setnomor(){
	Dialog(site_url+'/master/setnomor', 'DivSetNomor','Setting Nomor',520, 380);
}
function editaju(tipe, nomorAju){
	Dialog(site_url+'/master/updateAju/'+tipe+'/'+nomorAju, 'DivSetAju','Edit Nomor Aju',520, 190);
}
function changeValue(id, target) {
	var resource = $('#'+id).val();
	if (target == "jumlah_satuan") {
		resource = resource.replace(",", "");
		if (resource.indexOf('.') !== -1) {
			newresource = resource.split(".");
			$('#'+target).val(newresource[0]);
		} else {
			$('#'+target).val(resource);
		}
	} else if (target == "rev_kodebarang") {
		if (resource != $('#'+target).val()) {
			var kode_satuan = $('#KDSAT').val();
			var jenis_barang = $('#fbarang_form #JNS_BARANG').val();
			if (typeof(kode_satuan) == "undefined") {
				kode_satuan = $('#KODE_SATUAN').val();
			}
			$('#rev_kodebarang').val(resource);
			$('#rev_kodebarang_ur').html(resource);
			$('#rev_jenisbarang_ur').html(jenis_barang);
			$('#rev_kodesatuan_ur').html(kode_satuan);
			changeBarang(resource, jenis_barang);
		}
	} else if (target == "rev_kodesatuan_ur") {
		$('#rev_kodesatuan_ur').html(resource);
	}
}
function changeBarang(kode_barang, jenis_barang) {
	$.ajax({
		type: 'post',
		url: site_url + '/master/getBarangRevisi',
		data: {kode_barang: kode_barang, jenis_barang: jenis_barang},
		success: function(data) {
			var arrReturn = data.split('~');
            $('#gudang1').html(arrReturn[0]);
            $('#kondisi1').html(arrReturn[1]);
            $('#asal1').html(arrReturn[2]);
		}
	});
}
function setpenandatangan(){
	Dialog(site_url+'/master/setpenandatangan', 'DivSetNomor','Setting Penandatangan',400, 200);
}

function breakdown(formaid){
	var NOMOR_AJU = $("#NOMOR_AJU").val();
	var KODE_DOKUMEN = $("#KODE_DOKUMEN").val();
	var PARSIAL = ($("#PARSIAL").val())?$("#PARSIAL").val():0;
	var BREAK = ($("#BREAK").val())?$("#BREAK").val():0;
	if($("#NOMOR_DAFTAR").val()==""){
		jAlert('Silahkan Pilih dokumen terlebih dahulu.','PLB Inventory');	
		return false;
	}else{
		Dialog(site_url+'/'+formaid+'/breakdown/'+KODE_DOKUMEN+'/'+NOMOR_AJU+'/'+PARSIAL+'/'+BREAK, 'Divbreakdown','Breakdown Detil Barang',890, 580);	
		return true;
	}
}
function breakdown_proses(id,controler,tipe){
	var jumlah = $("#JUMLAH_B"+id).val();
	var arr = $("#breakchk"+id).val().split("|");
	var DOK=arr[0]; var AJU=arr[1];var SERI=arr[2];
	Dialog(site_url+'/'+controler+'/breakdown_proses/'+DOK+'/'+AJU+'/'+SERI+'/'+jumlah+'/'+tipe,'Divbreakdownprs','Proses Breakdown Detil Barang',650, 460);
}
function save_breakdown(formid,msg,divDialog,divLoad,act){	
	var id=2;
	var hasil=0;
	$("#fbreakdownbrg tbody tr").each(function(index, element) {		
		if(act=="update"){
			var data = $("#fbreakdownbrg tbody tr:eq("+id+"):not(.selected) td:eq(5)").html();
		}else{
			var data = $("#fbreakdownbrg tbody tr:eq("+id+") td:eq(5)").html();
		}
		if(data!=null){
			hasil = parseFloat(hasil)+parseFloat(data);
		}
		id++;
	});	
	var baru = parseFloat(hasil)+parseFloat($(formid+" #JUMLAH").val());
	var lama = parseFloat($(formid+" #JMLHEAD").val());	
	if(parseFloat($(formid+" #JUMLAH").val())>parseFloat($(formid+" #STOKAKHIR").val())){
		jAlert('Tidak dapat diproses.\nJumlah Stock tidak mencukupi. Jumlah Stock yang ada adalah :'+parseFloat($(formid+" #STOKAKHIR").val()), "PLB Inventory");
		return false
	}else if($(formid+" #JUMLAH").val()==0){
		jAlert("Jumlah tidak boleh kosong!","PLB Inventory");
		return false
	}else if(baru>lama){
		jAlert('Tidak dapat diproses.\nJumlah Satuan Barang sudah Melebihi Jumlah Satuan Barang awal Anda.\nJumlah awal = '+lama+'\nJumlah Baru = '+baru, "PLB Inventory");
		return false
	}else{
		proses_breakdown(formid,msg,divDialog,divLoad);	
		return true
	}				
}
function proses_breakdown(formid,msg,divDialog,divLoad){
	if(validasi(msg,formid)){		
		$.ajax({
		type: 'POST',
		url: $(formid).attr('action'),
		data: $(formid).serialize(),
		success: function(data){
			Clearjloadings();
			if(data.search("MSG")>=0){
				arrdata = data.split('#');
				if(arrdata[1]=="OK"){
					$("."+msg).css('color', 'green');
					$("."+msg).html(arrdata[2]);						
					closedialog(divDialog);
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html(arrdata[2]);
				}	
				if(arrdata.length>3){
					$("#"+divLoad).load(arrdata[3]);
					return false;
				}				
			}else{
				$("."+msg).css('color', 'red');
				$("."+msg).html('Proses Gagal.');
			}
		}
	});	
	}return false;	
}
function breakdown_finish(formid){	
	if(formid==""||typeof(formid)=="undefined") formid = "";	
	else formid = formid;	
	if(validasi('',formid)){			
		var Breakchecked="";
		var BreakNotchecked="";
		$(".breakchk").each(function(index, element) {
			if($(this).attr("checked")=="checked"){
				Breakchecked = Breakchecked+"datachecked[]="+$(this).val()+"&";
			}else{
				BreakNotchecked = BreakNotchecked+"dataNotchecked[]="+$(this).val()+"&";	
			}
		});
		
		var Parsialchecked="";
		var ParsialNotchecked="";
		$(".parsialchk").each(function(index, element) {
			if($(this).attr("checked")=="checked" && $(this).attr("disabled")!='disabled'){
				Parsialchecked = Parsialchecked+"Parsialchecked[]="+$(this).val()+'|'+$("#JUMLAH_B"+$(this).attr("no")).val()+"&";
			}else{
				if($(this).attr("disabled")!='disabled'){
					ParsialNotchecked = ParsialNotchecked+"ParsialNotchecked[]="+$(this).val()+"&";	
				}
			}
		});
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: Breakchecked+""+BreakNotchecked+""+Parsialchecked+""+ParsialNotchecked+""+$(formid).serialize(),
			success: function(data){
				Clearjloadings();
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$(".msg_break").css('color', 'green');
						$(".msg_break").html(arrdata[2]);
						closedialog("Divbreakdown");
					}else{
						$(".msg_break").css('color', 'red');
						$(".msg_break").html(arrdata[2]);
					}				
				}else{
					$(".msg_break").css('color', 'red');
					$(".msg_break").html('Proses Gagal.');
				}
			}
		});
	}return false;
}
function uploadDetilbc25(data){
	var namaForm = 'btnUploadData';
	var width = 800;
	var height = 300;
	var winl = (screen.width - width) / 2;
	var wint = (screen.height - height) / 2;
	var url = site_url + '/upload/upload_detilbc25/'+data;
	var popupname = 'upload_goods';
	popupWindow = window.open(url, popupname, 'left='+winl+',top='+wint+',width='+width+', height='+height+',scrollbars=yes,resizable=yes,statusbar=yes');
}
function save_data(formid){	
	if(formid==""||typeof(formid)=="undefined") formid = "";	
	else formid = formid;	
	if(validasi('',formid)){		
		$('.msg_').fadeIn('Slow').delay(8000);
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$(".msg_").css('color', 'green');
						$(".msg_").html(arrdata[2]);
						$(".msg_").fadeOut('Slow') ;
						Clearjloadings();
					}else{
						$(".msg_").css('color', 'red');
						$(".msg_").html(arrdata[2]);
					}
				}else{
					$(".msg_").css('color', 'red');
					$(".msg_").html('Proses Gagal.');
				}
			}
		});
	}return false;
}
function prosesproduksi(formid, act, id) {
    var url = $(formid).attr('popup');//alert(url);return false;
    var TANGGAL = $(formid + " #TANGGAL").val();
    var WAKTU = $(formid + " #WAKTU").val();
    var addurl = "";
    if (act == "update") {
        var KODE_BARANG = $("#KODE_BARANG" + id).val();
        var KODE_BARANG = KODE_BARANG.replace("/", "^");
        var JNS_BARANG = $("#JNS_BARANG" + id).val();
        var JUMLAH = $("#JUMLAH" + id).val();
        var KODE_SATUAN = $("#KODE_SATUAN" + id).val();
        var STOCKAKHIR = $("#STOCKAKHIR" + id).val();
        var KODE_GUDANG = $("#KODE_GUDANG" + id).val();
        var KONDISI_BARANG = $("#KONDISI_BARANG" + id).val();
		var KODE_RAK	= $("#KODE_RAK" + id).val();
		var KODE_SUB_RAK = $("#KODE_SUB_RAK" + id).val();		
        var KETERANGAN = $("#KETERANGAN" + id).val();
        var addurl = "/" + id + "/" + KODE_BARANG + "/" + JNS_BARANG + "/" + JUMLAH + "/" + KODE_SATUAN + "/" + STOCKAKHIR + "/" + KODE_GUDANG + "/" + KODE_RAK + "/" +  KODE_SUB_RAK + "/" + KONDISI_BARANG + "/" + KETERANGAN;
    }
    Dialog(url + "/" + act + addurl, 'dialog-produksi', 'TAMBAH DETIL BARANG', 600, 480);
}

function save_produksi(formid,ID){	
	if(validasi('msgdetil_',formid)){		
		var act = $(formid+" #act").val();
		if(act=="update"){
			var a=0;var b=0;		
			$(".kdbarang").not("#KODE_BARANG"+ID).each(function(index, element) {
				if($(this).val()==$(formid+" #KODE_BARANG").val()){
					a++;
				}
			});
			$(".jnsbarang").not("#JNS_BARANG"+ID).each(function(index, element) {
				if($(this).val()==$(formid+" #JNS_BARANG").val()){
					b++;
				}
			});				
		}else{
			var a=0;var b=0;		
			$(".kdbarang").each(function(index, element) {
				if($(this).val()==$(formid+" #KODE_BARANG").val()){
					a++;
				}
			});
			$(".jnsbarang").each(function(index, element) {
				if($(this).val()==$(formid+" #JNS_BARANG").val()){
					b++;
				}
			});	
		}
		var jum = $(formid+" #JUMLAH_SATUAN").val();
		var stk = $(formid+" #STOCK_AKHIR").val();	
		var tipe = $(formid+" #TIPE").val();	
		if(a>0 && b>0){
			$(".msgdetil_").css('color', 'red');
			$(".msgdetil_").html("Kode Barang dan Jenis Barang yang sama sudah dipakai");
			Clearjloadings();
			return false;
		}else{
			var Header="";var detil="";
			//TAMABHAN KHARIRI
			var tr_detil = $("#Tbldetilbahanbaku tbody #tr_detil").size();
			var dtl = $("#Tbldetilbahanbaku tbody #dtl").size();
			var nilai1 = $("#Tbldetilbahanbaku tbody tr").size();
			var tr_hdr = $("#Tbldetilbahanbaku tbody #tr_hdr").size();
			if(nilai1>2){ 
				var dtltam = $("#dtl").remove();								
			}
			if(tr_detil==1){
				var tr_detil = $("#tr_detil").remove();		
				var nilai1 = nilai1 -1;		
			}
			if(dtl==1&&tr_hdr==1){
				var nilai1 = nilai1 -1;	
			}
			//END TAMBAHAN
			var nilai = $("#Tbldetilbahanbaku tbody tr").size();
			//alert(nilai);
			var Mathrandom = GetRandomMath();					
			Header="<tr id=\"tr_hdr\"><th width=\"2%\">No</th><th width=\"10%\">Kode Barang</th><th width=\"15%\">Uraian Barang</th><th width=\"9%\">Jenis Barang</th><th width=\"9%\">Gudang</th><th width=\"9%\">Rak</th><th width=\"9%\">Sub Rak</th><th width=\"9%\">Jumlah</th><th width=\"9%\">Satuan</th><th width=\"10%\">Keterangan</th><th width=\"8%\">&nbsp;</th></tr>";			
			detil="<tr id=\"tr_dtl"+Mathrandom+"\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\"><td class=\"alt\"><span class=\"nop\">"+nilai1+"</span></td><td class=\"alt\">"+$(formid+" #KODE_BARANG").val()+"</td><td class=\"alt\">"+$(formid+" #URAIAN_BARANG").val()+"</td><td class=\"alt\">"+$(formid+" #JENIS_BARANG").val()+"</td><td class=\"alt\">"+$(formid+" #KODE_GUDANG").val()+"</td><td class=\"alt\">"+$(formid+" #KODE_RAK").val()+"</td><td class=\"alt\">"+$(formid+" #KODE_SUB_RAK").val()+"</td><td class=\"alt\">"+$(formid+" #JUMLAH_SATUAN").val()+"</td><td class=\"alt\">"+$(formid+" #KODE_SATUAN").val()+"</td><td class=\"alt\">"+$(formid+" #KETERANGAN").val()+"</td><td align=\"center\" class=\"alt\" width=\"70\"><a href=\"javascript:void(0)\" class=\"btn btn-sm btn-info\" onclick=\"prosesproduksi('#fprdbahanbaku_','update','"+Mathrandom+"')\"><i class=\"icon-edit bigger-120\"></i></a>&nbsp;<a href=\"javascript:void(0)\" class=\"btn btn-sm btn-danger\" onclick=\"remove_produksi("+Mathrandom+")\"><i class=\"icon-trash bigger-120\"></i></a><input type=\"hidden\" name=\"DETIL[KODE_BARANG][]\" id=\"KODE_BARANG"+Mathrandom+"\" value=\""+$(formid+" #KODE_BARANG").val()+"\" class=\"kdbarang\"/><input type=\"hidden\" name=\"DETIL[JNS_BARANG][]\" id=\"JNS_BARANG"+Mathrandom+"\" value=\""+$(formid+" #JNS_BARANG").val()+"\"  class=\"jnsbarang\"/><input type=\"hidden\" name=\"DETIL[JUMLAH][]\" id=\"JUMLAH"+Mathrandom+"\" value=\""+$(formid+" #JUMLAH_SATUAN").val()+"\" /><input type=\"hidden\" name=\"DETIL[KODE_SATUAN][]\" id=\"KODE_SATUAN"+Mathrandom+"\" value=\""+$(formid+" #KODE_SATUAN").val()+"\" /><input type=\"hidden\" name=\"DETIL[KETERANGAN][]\" id=\"KETERANGAN"+Mathrandom+"\" value=\""+$(formid+" #KETERANGAN").val()+"\"/><input type=\"hidden\" name=\"STOCKAKHIR\" id=\"STOCKAKHIR"+Mathrandom+"\" value=\""+$(formid+" #STOCK_AKHIR").val()+"\" /><input type=\"hidden\" name=\"DETIL[NOMOR_KONVERSI][]\" id=\"NOMOR_KONVERSI"+Mathrandom+"\" value=\""+$(formid+" #NOMOR_KONVERSI").val()+"\"/><input type=\"hidden\" name=\"DETIL[KODE_GUDANG][]\" id=\"KODE_GUDANG"+Mathrandom+"\" value=\""+$(formid+" #KODE_GUDANG").val()+"\" /><input type=\"hidden\" name=\"DETIL[KODE_RAK][]\" id=\"KODE_RAK"+Mathrandom+"\" value=\""+$(formid+" #KODE_RAK").val()+"\" /><input type=\"hidden\" name=\"DETIL[KODE_SUB_RAK][]\" id=\"KODE_SUB_RAK"+Mathrandom+"\" value=\""+$(formid+" #KODE_SUB_RAK").val()+"\" /><input type=\"hidden\" name=\"DETIL[KONDISI_BARANG][]\" id=\"KONDISI_BARANG"+Mathrandom+"\" value=\""+$(formid+" #KONDISI_BARANG").val()+"\" /></td></tr>";
			
			if(act=="update"){
				$("#Tbldetilbahanbaku tbody #tr_dtl"+ID).replaceWith(detil);	
				$("#Tbldetilbahanbaku tbody tr .nop").each(function(index, element) {
					$(this).html(parseFloat(index)+1);
				});	
				$(".msgdetil_").css('color', 'green');
				$(".msgdetil_").html("Update data berhasil.");
				closedialog('dialog-produksi');
			}else{
				if(nilai==1){
					$("#tr_detil").remove();					
					$("#Tbldetilbahanbaku tbody:first").append(Header+""+detil);
				}else{
					$("#Tbldetilbahanbaku tbody:first").append(detil);	
				}	
				cancel(formid.replace('#',''));
				$(".msg_").html('');
				$(".msgdetil_").css('color', 'green');
				$(".msgdetil_").html("Silahkan masukan lagi jika ingin menambahkan data barang lainnya.");				
			}
			Clearjloadings();
		}		
		return false;
	}
}
function remove_produksi(id){ 
	$("#Tbldetilbahanbaku tr[id=tr_dtl"+id+"]").remove();
	
	var nilai = $("#Tbldetilbahanbaku tbody tr").size();
	//TAMBAHAN SCRIPT KHARIRI
	var hdr = $("#Tbldetilbahanbaku tbody #tr_hdr").size();
	var dtl = $("#dtl").size(); // tambahan	
	if(nilai==2&&hdr==1&&dtl==1){
		$("#tr_hdr").remove();
		var nilai=1;
	}
	if(dtl==0){ // tambahan
			$("#Tbldetilbahanbaku tbody:first").append('<tr id="dtl"></tr>'); //tambahan
	}
	//END TAMBAHAN
	if(nilai==1||nilai==0){ //asalnya tidak ada nilai==0
		$("#tr_hdr").remove();
		$("#Tbldetilbahanbaku tbody:first").append('<tr id="tr_detil"><td align="center" style="background:#438EB9" colspan="11"><h6 style="color:#FFF"><b>Data Tidak Ditemukan</b></h6></td></tr>');	
	}
	$("#Tbldetilbahanbaku tbody tr .nop").each(function(index, element) {
        $(this).html(parseFloat(index)+1);
    });	
}	

function pilihprosesmasuk(id){ 	
	if($("#NOMOR_PROSES_ASAL").attr("value")==""){
		Dialog(site_url+"/produksi/prosesmasuk", 'dialog-proses','Nomor Proses Masuk',700, 450);	
	}else{
		Dialog(site_url+"/produksi/prosesmasuk", 'dialog-proses','Nomor Proses Masuk',700, 450);
		var splitdata = $("#NOMOR_PROSES_ASAL").attr("value").split(';');
		for(var a=0;a<(splitdata.length)-1;a++){ 
			$('#dialog-proses').live("change", function(){ 
				if(!$("input[value="+splitdata[a]+"]").is(':checked')){
					$("input[value="+splitdata[a]+"]").attr('checked', 'checked');
				}
			})			
		}
	}
}
function prosesmasuk(formid){
	var length = $("#tb_chk"+formid+":checked").length;	
	var dataCheck = "";
	$("#tb_chk"+formid+":checked").each(function(){
		dataCheck += $(this).val()+";";
	});
	if(length==0){
		jAlert('Maaf, Data belum dipilih.','PLB Inventory');
		return false;
	}else{
		var databefore = $("#fprdbahanbaku_ #NOMOR_PROSES_ASAL").attr("value");
		$("#fprdbahanbaku_ #NOMOR_PROSES_ASAL").val(dataCheck+''+databefore);
		closedialog('dialog-proses');
	}
}
/* function popup */
function popup(form, jenis) {
    if (form == 'realisasi_in') {
        URL = site_url + '/realisasi_in/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divListIn', 'FORM LIST PEMASUKAN', 800, 360);
    }
    else if (form == 'realisasi_out') {
        URL = site_url + '/realisasi_out/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divListOut', 'FORM LIST PENGELUARAN', 800, 360);
    }
    else if (form == 'upload') {
        URL = site_url + '/upload/upload_data';//alert(URL);
        Dialog(URL, 'divUpload', 'FORM UPLOAD DATA', 800, 360);
    }
    else if (form == 'stock') {
        URL = site_url + '/inventory/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divStock', 'FORM LIST BARANG', 800, 360);
    } else if (form == 'konversi') {
        URL = site_url + '/inventory/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divKonv', 'FORM LIST BARANG', 800, 360);
    } else if (form == 'konversi_sub') {
        URL = site_url + '/inventory/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divKonvSub', 'FORM LIST BARANG', 800, 360);
    } else if (form == 'konversiBB') {	//alert('sini');
        URL = site_url + '/inventory/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divKonvBB', 'FORM LIST BARANG', 800, 400);
    } else if (form == 'konversi_subBB') {	//alert('sini');
        URL = site_url + '/inventory/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divKonvSubBB', 'FORM LIST BARANG', 800, 400);
    } else if (form == 'bahanBaku') {	//alert('sini');
        URL = site_url + '/produksi/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divBahanBaku', 'FORM LIST BARANG', 800, 400);
    } else if (form == 'hasil_produksi') {	//alert('sini');
        URL = site_url + '/produksi/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divHasilProd', 'FORM LIST BARANG', 800, 400);
    } else if (form == 'proses_produksi') {	//alert('sini');
        URL = site_url + '/produksi/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divProsesProd', 'FORM LIST BARANG', 800, 400);
    } else if (form == 'hasil_sisa') {	//alert('sini');
        URL = site_url + '/produksi/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divHasilSisa', 'FORM LIST BARANG', 800, 400);
    } else if (form == 'proses_sisa') {	//alert('sini');
        URL = site_url + '/produksi/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divProsesSisa', 'FORM LIST BARANG', 800, 400);
    } else if (form == 'pengrusakan') {
        URL = site_url + '/pengeluaran/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divPengrusakan', 'FORM LIST BARANG', 800, 360);
    } else if (form == 'pemusnahan') {
        URL = site_url + '/pengeluaran/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divPemusnahan', 'FORM LIST BARANG', 800, 360);
    } else if (form == 'mappingBB') {
        URL = site_url + '/pengeluaran/popup/' + form + '/' + jenis;//alert(URL);
        Dialog(URL, 'divMapping', 'FORM LIST BARANG', 800, 360);
    } else if (form = 'poplist') {
        //console.log(jenis);
        if (jenis == 'kemasan' || jenis == 'kemasanBrg') {
            URL = site_url + '/popup/getPopUp/' + form + '/' + jenis;//alert(URL);
            Dialog(URL, 'divKemasan', 'FORM LIST KEMASAN', 800, 400);
        } else if (jenis == 'satuanBrg') {
            URL = site_url + '/popup/getPopUp/' + form + '/' + jenis;//alert(URL);
            Dialog(URL, 'divSatuan', 'FORM LIST SATUAN', 800, 400);
        } else if (jenis == 'zoning_bc30' || jenis == 'jns_PKB' || jenis == 'gdng_PKB' || jenis == 'cara_STUFF' || jenis == 'jnpartof') {
            if (jenis == 'zoning_bc30')
                judul = "FORM LIST ZONING KITE";
            else if (jenis == 'jns_PKB')
                judul = "FORM LIST JENIS BARANG PKB";
            else if (jenis == 'gdng_PKB')
                judul = "FORM LIST GUDANG PKB";
            else if (jenis == 'cara_STUFF')
                judul = "FORM LIST CARA STUFFING";
            else if (jenis == 'jnpartof')
                judul = "FORM LIST JNPARTOF";
            URL = site_url + '/popup/getPopUp/' + form + '/' + jenis;//alert(URL);
            Dialog(URL, 'divMTabel', judul, 800, 400);
        } else if (jenis == 'pemasokBC27' || jenis == 'pemasokBC261' || jenis == 'pemasokBC262' || jenis == 'pemasokBC41' || jenis == 'pemasokBC40') {
            URL = site_url + '/popup/getPopUp/' + form + '/' + jenis;//alert(URL);
            Dialog(URL, 'divPemasok', 'FORM LIST PEMASOK/PENERIMA', 800, 400);
        } else if (jenis == 'barang_jadi' || jenis == 'bhnBku27' || jenis == 'bhnBku261') {
            URL = site_url + '/popup/getPopUp/' + form + '/' + jenis;//alert(URL);
            Dialog(URL, 'divBarang', 'FORM LIST BARANG', 800, 400);
        } else if (jenis == 'kpbc;kpbc_daftar') {//alert('sini');
            q = jenis.split(';');
            jenis = q[0];
            valueID = q[1];//alert(jenis+'\n'+valueID);
            URL = site_url + '/popup/getPopUp/' + form + '/' + jenis + '/' + valueID;//alert(URL);
            Dialog(URL, 'divKPBC', 'FORM LIST KPBC', 800, 400);
        }
    }
}
function popKonversi(form, jenis, key) {
    URL = site_url + '/popup/getPopUp/' + form + '/' + jenis + '/' + key;//alert(URL);
    Dialog(URL, 'divKonversi', 'FORM LIST KONVERSI BARANG', 800, 400);
}
function checkall(formid){
	$("#"+formid).find(':checkbox').attr('checked', $("#tb_chkall").attr('checked'));
	if(!$("#tb_chkall").attr('checked')=='checked'){
		$("#"+formid+" input:checkbox:not(#tb_chkall)").parent().parent().removeClass("selected");
	}else{
		$("#"+formid+" input:checkbox:not(#tb_chkall)").parent().parent().addClass("selected");
	}
}
function reset_proses(){	
	chk = $("#tb_chk:checked").length;
	if(chk==0){
		jAlert('Maaf, Data belum dipilih.','PLB Inventory');
		return false;
	}
	jConfirm('Anda yakin Akan mereset data ini?', " PLB Inventory ", 
	function(r){if(r==true){	
		var formid = "#freset_";
		if(formid==""||typeof(formid)=="undefined") var formid = "";	
		else var formid = formid;	
		if(validasi('',formid)){
			$.ajax({
				type: 'POST',
				url: $(formid).attr('action'),
				data: $(formid).serialize(),
				success: function(data){
					Clearjloadings();
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							$(".msg_").css('color', 'green');
							$(".msg_").html(arrdata[2]);
						}else{
							$(".msg_").css('color', 'red');
							$(".msg_").html(arrdata[2]);
						}
					}else{
						$(".msg_").css('color', 'red');
						$(".msg_").html('Proses Gagal.');
					}
				}
			});
		}return false;	
	}else{return false;}});
}
function save_laporan(formid,msg,url){
	jConfirm('Anda yakin Akan memproses data ini?', " PLB Inventory ", 
	function(r){if(r==true){
	if(validasi(msg)){		
		$.ajax({
			type: 'POST',
			url: url,
			data: $(formid).serialize(),
			beforeSend: function(){jloadings();},
			complete: function(){Clearjloadings();},
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
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
	}else{return false;}});	
}

/* fungsi Bahan Baku*/
function save_BB(formid,msg,divData,page,jenis,divDialog){
	var JUMBB=$("#JUMLAH_BB").val();//alert(JUMBB);return false;
	var input = $("#JUMLAH_BB");
	var JUM_BHNBKU=$("#JUMLAH_BHNBKU").val();//alert(JUMBB);return false;
	var inputBhnBku = $("#JUMLAH_BHNBKU");
	$("."+msg).hide();
	$("."+msg).css('color', '');
	$("."+msg).html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
	$("."+msg).fadeIn('slow');
	var notvalid = 0;
	$.each($(formid+" input:visible,"+formid+" select:visible,"+formid+" textarea:visible"), function(){
		if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
			$(this).addClass('wajib');
			notvalid++;
		}
	});
	if(notvalid>0){
		$("."+msg).css('color', 'red');
		$("."+msg).html('Ada ' + notvalid + ' Kolom Yang Harus Diisi');
		$("."+msg).fadeIn('slow');
		return false;
	}else{
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			success: function(data){
				//alert(data);
				if(data.search("MSG")>=0){
					arrdata = data.split('#');//alert(arrdata);
					if(arrdata[1]=="OK"){
						$("."+msg).css('color', 'green');
						$("."+msg).html(arrdata[2]);
						$("#"+divData).load(page);
						if(jenis=='save'){
							input.val(parseFloat(JUMBB)+1);
							inputBhnBku.val(parseFloat(JUM_BHNBKU)+1);
							cancel(formid.replace("#",""));
						}
						if(jenis=='edit'){
							closedialog(divDialog);
							$("#"+divData).load(page);
						}							
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
}
function BahanBaku(urlLoad,key,jenis,divDialog){
	addUrl1="";
	if(key!=""){
		addUrl1="/"+key;
	}
	URL = urlLoad+addUrl1;//alert(URL);return false;
	Dialog(URL, divDialog,'FORM BAHAN BAKU',800, 500);
}
function ListBahanBaku(urlLoad,divData,classCss,idCss,msg){//alert(urlLoad);return false;
	if ($("#"+idCss).css("display") == "none"){
		$("."+classCss).hide();
		$("#"+idCss).show();
		$("."+msg).html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
		$("."+msg).fadeIn('slow');
		$('#'+divData).load(urlLoad);
		$(".msg_load").fadeOut('slow');					
	}else{
		$("."+classCss).hide();
		$("#"+idCss).hide();
	}
}
function deleteBB(urlProses,div,urlLoad){
	var JUMBB=$("#JUMLAH_BB").val();
	var input = $("#JUMLAH_BB");
	var JUM_BHNBKU=$("#JUMLAH_BHNBKU").val();
	var inputBhnBku = $("#JUMLAH_BHNBKU");
	jConfirm('Anda yakin Akan menghapus data ini?', " PLB Inventory ", 
	function(r){if(r==true){
		jloadings();
		$('#'+div).load(urlProses,function(data){
			if(data.search("MSG")>=0){
				Clearjloadings();
				arrdata = data.split('#');
				if(arrdata[1]=="OK"){
					jAlert('Data berhasil di Hapus','PLB Inventory');
					input.val(parseFloat(JUMBB)-1);
					inputBhnBku.val(parseFloat(JUM_BHNBKU)-1);
					$('#'+div).load(urlLoad);
					
				}else{
					jAlert('Data Gagal di Hapus','PLB Inventory');
				}
			}else{
				jAlert('Data Gagal di Hapus','PLB Inventory');	
			}
		});
	}else{return false;}});
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function menucheckAll(formid){
	if($("#checkAllmenu").attr('checked')=="checked") var checked = "checked";
	else checked = false;
	$("#"+formid).find(':checkbox').attr('checked', checked);	
}
function menucheckParent(formid,id){
	if($("#checkmenuParent_"+id).attr('checked')=="checked") var checked = true;
	else checked = false;
	$("#"+formid).find('#checkmenuChild_'+id).attr('checked',checked);	
}
function menucheckChild(formid,id){ 
	var numchecked = 0;
	$(".checkmenuChild_"+id).each(function(index, element){
    	if($(this).attr('checked')=='checked'){
			numchecked++;
		}    
    });
	if(numchecked>0){
		$("#"+formid).find('#checkmenuParent_'+id).attr('checked',true);	
	}else{		
		$("#"+formid).find('#checkmenuParent_'+id).attr('checked',false);		
	}
}
function save_user(formid){	
	if(formid==""||typeof(formid)=="undefined") formid = "";	
	else formid = formid;	
	if(validasi('',formid)){		
		var checked = 0; 
		$(formid).find(':checkbox').each(function(index, element){ 
			if($(this).attr('checked')=="checked"){
				checked++;
			}    
		});
		if(checked==0){
			$(".msg_").css('color', 'red');
			$(".msg_").html('Anda belum memilih Hak Akses Menu.');	
			Clearjloadings();
			return false;
		}else{		
			$.ajax({
				type: 'POST',
				url: $(formid).attr('action'),
				data: $(formid).serialize(),
				success: function(data){
					Clearjloadings();
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							$(".msg_").css('color', 'green');
							$(".msg_").html(arrdata[2]);
						}else{
							$(".msg_").css('color', 'red');
							$(".msg_").html(arrdata[2]);
						}
						if(arrdata.length>3){
							setTimeout(function(){location.href = arrdata[3];}, 2000);
							return false;
						}
					}else{
						$(".msg_").css('color', 'red');
						$(".msg_").html('Proses Gagal.');
					}
				}
			});
		}
	}return false;
}
function changeHakAkses(val,userid){	
	$.ajax({
		type: 'POST',
		url: site_url+"/user/getmenu",
		data: "jenisgroup="+val+"&ajax=1&userid="+userid,
		success: function(data){
			$("#spanHakAkses").html(data);			
		}
	});
}
function uploadnew(data){
	var namaForm = 'btnUploadData';
	var width = 800;
	if(data=='produksi'){
		var height = 420;
	}else{
		var height = 300;	
	}
	var winl = (screen.width - width) / 2;
	var wint = (screen.height - height) / 2;
	var url = site_url + '/uploadnew/'+data;
	var popupname = 'uploadnew';
	popupWindow = window.open(url, popupname, 'left='+winl+',top='+wint+',width='+width+', height='+height+',scrollbars=yes,resizable=yes,statusbar=yes');
}
function viewbarang(kode,no){
	$("#tab-"+no).removeClass('tabnotaktif');
	$(".tabnotaktif").html('');
	$("#tab-"+no).html('<br><br><center><img src=\"'+base_url+'img/_ldg.gif\" alt=\"\" /></center><br><br>');
	$.ajax({
		type: 'POST',
		url: site_url+"/inventory/barang/"+kode,
		data: "ajax=1&view=1",
		success: function(data){
			$("#tab-"+no).html(data);	
			$("#tab-"+no).addClass('tabnotaktif');		
		}
	});
	return false;
}
function parsial(formaid){
	var controler = formaid.replace('f','');
	var NOMOR_AJU = $("#NOMOR_AJU").val();
	var KODE_DOKUMEN = $("#KODE_DOKUMEN").val();
	Dialog(site_url+'/'+controler+'/parsial/'+KODE_DOKUMEN+'/'+NOMOR_AJU, 'Divparsial','Parsial Detil Barang',890, 580);	
}
function parsial_finish(formid){	
	if(formid==""||typeof(formid)=="undefined") formid = "";	
	else formid = formid;	
	if(validasi('',formid)){					
		var Parsialchecked="";
		var ParsialNotchecked="";
		$(".parsialchk").each(function(index, element) {
			if($(this).attr("checked")==true){
				Parsialchecked = Parsialchecked+"Parsialchecked[]="+$(this).val()+'|'+$("#JUMLAH_B"+$(this).attr("no")).val()+"&";
			}else{
				ParsialNotchecked = ParsialNotchecked+"ParsialNotchecked[]="+$(this).val()+"&";	
			}
		});							
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: Parsialchecked+""+ParsialNotchecked+""+$(formid).serialize(),
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$(".msg_").css('color', 'green');
						$(".msg_").html(arrdata[2]);
						setTimeout(function(){closedialog("Divparsial");}, 2000);						
					}else{
						$(".msg_").css('color', 'red');
						$(".msg_").html(arrdata[2]);
					}				
				}else{
					$(".msg_").css('color', 'red');
					$(".msg_").html('Proses Gagal.');
				}
			}
		});
	}return false;
}
function ajaxproses(formid,msg){
	if(validasi(msg)){		
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			success: function(data){
				$("."+msg).html(data);
				Clearjloadings();
			}
		});	
	}return false;	
}
function proses_produksi(id){
	$.ajax({
		type: 'POST',
		url: site_url +'/produksi/proseskonversi',
		data: 'id='+id,
		success: function(data){
			$("#Tbldetilbahanbaku tbody tr").remove();					
			$("#Tbldetilbahanbaku tbody:first").append(data);
			$(".msg_").html('');
			closedialog('Dialog-dok');
		}
	});	
}

function upload(element,msg,tipefile,id,div,realisasi){
	if($('#'+element).val()==''){
		jAlert('Pilih file yang akan anda upload!','PLB Inventory')
	}else{
		jConfirm('Anda yakin akan meng-Upload File ini?', "PLB Inventory", 
		function(r){if(r==true){
			jloadings();
			var parameter = $('#upload_produksi').serialize().replace('realisasi=','');
			$.ajaxFileUpload({ 
				url: site_url+'/upload/proses_upload/'+element+'/'+tipefile+'/'+parameter,
				secureuri:false,
				fileElementId:element,
				dataType:'json',
				success:function(data, status){
					if(typeof(data.error)!='undefined'){
						if(data.error!=''){
							Clearjloadings();
							$("#"+div).html(data.error);
						}else{
							Clearjloadings();
							$("#"+div).html(data.msg);
						}
					}
				},
				error: function(data, status, e){
					$("."+div).html(data.error);
					/*console.log(status);
					console.log(e);
					console.log(data);*/
				}
			})
		}else{
			return false;
		}});		
	}
}

function updatesaldo(logid,saldo){
	jConfirm('Anda yakin Akan memproses data ini?', " PLB Inventory ", 
	function(r){if(r==true){	
	jloadings();
		$.ajax({
			type: 'POST',
			url: site_url+'/inventory/updatesaldo',
			data: 'proses=1&logid='+logid+'&saldo='+saldo,
			success: function(data){
				jAlert(data,"PLB Inventory");
				setTimeout(function() {location.href = site_url + '/inventory/rinci';}, 1000);
				return false;
			}
		});	
	}else{return false;}});		
}

function save_realisasi(formid, msg) {
    if (validasi(msg)) {
		jConfirm('Anda yakin Akan memproses data ini?', " PLB Inventory ", 
		function(r){
			if(r==true){
				$("." + msg).html('');
				jloadings();
				var data = $(formid).serialize();
				$.ajax({
					type: 'POST',
					url: $(formid).attr('action') + '/ajax',
					data: data,
					success: function(data) {
						if (data.search("MSG") >= 0) {
							arrdata = data.split('#');
							if (arrdata[1] == "OK") {
								$("." + msg).css('color', 'green');
								$("." + msg).html(arrdata[2]);
								
								if(formid=='#frealisasi_in'||formid=='#frealisasi_out'){
									$("#tblBarang tr.parent").remove();
									$("#span-msg").hide();
									$("#data_barang").hide();
									$("#tr-button").hide();
									location.href = arrdata[4];
								}
		
								cancel(formid.replace("#", ""));
								Clearjloadings();
							} else {
								$("." + msg).css('color', 'red');
								$("." + msg).html(arrdata[2]);
								Clearjloadings();
							}
						} else {
							$("." + msg).css('color', 'red');
							$("." + msg).html('Proses Gagal.');
							Clearjloadings();
						}
					}
				});
			}else{
				return false;
			}
		});
    }
    return false;
}

function parsial_proses(controller, id,tipe) {
    var arr = $("#breakchk" + id).val().split("|");
    var PARSIAL = ($("#PARSIAL").val()) ? $("#PARSIAL").val() : 0;
    var BREAK = ($("#BREAK").val()) ? $("#BREAK").val() : 0;
    var DOK = arr[0];
    var AJU = arr[1];
    var SERI = arr[2];
	if(tipe=="in"){
    	Dialog(site_url + '/' + controller + '/parsialin/' + DOK + '/' + AJU + '/' + PARSIAL  + '/' + BREAK + '/' + SERI, 'Divbreakdown', 'Proses Parsial Detil Barang', 900, 520);
	}else{
		Dialog(site_url + '/' + controller + '/parsialout/' + DOK + '/' + AJU + '/' + PARSIAL  + '/' + BREAK + '/' + SERI, 'Divbreakdown', 'Proses Parsial Detil Barang', 900, 520);
	}
}

function deltelusur(tipe,kdbrg,jnsbrng,seri,kondisi,kdgudang,kdrak,kdsubrak,aju,noproduk,noppbkb,kddok){
	jConfirm('Perhatian:<br>Menghapus data ini dapat mempengaruhi data laporan.<br>Anda yakin akan menghapus data ini?', " PLB Inventory ", 
	function(r){if(r==true){
		jloadings();
		$.ajax({
			type: 'POST',
			url: site_url+'/inventory/delinout',
			data: 'TIPE='+tipe+'&KODE_BARANG='+kdbrg+'&JNS_BARANG='+jnsbrng+'&SERI='+seri+'&KONDISI_BARANG='+kondisi+'&KODE_GUDANG='+kdgudang+'&KODE_RAK='+kdrak+'&KODE_SUB_RAK='+kdsubrak+'&AJU='+aju+'&NOPRODUK='+noproduk+'&NOPPBKB='+noppbkb+'&KDDOK='+kddok,
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						ajaxproses('#frminout','spanview')	
						Clearjloadings();
						if(data.search("Draft")>0){
							alert(arrdata[2]);return false;
						}	
					}else{
						jAlert(arrdata[2], " PLB Inventory ");
					}	
				}else{
					jAlert(arrdata[2], " PLB Inventory ");
				}
			}
		});	
	}else{return false;}});
}

function lap_pagging(action, divid, data, frmid){	
	var formdata = '';	
	formdata = "TANGGALAWAL="+$('#TANGGALAWAL').val();		
	formdata += "&TANGGALAKHIR="+$('#TANGGALAKHIR').val();			
	if(typeof($('#JENIS_DOKUMEN').val())!='undefined') formdata += "&JENIS_DOKUMEN="+$('#JENIS_DOKUMEN').val();	
	
	formdata = $("#"+frmid).serialize();
	
	if($('#all').attr('checked')=="checked"||$('#all').attr('checked')==true) var alls = 1;
	else var alls = 0;
	formdata += "&all="+alls;	
	$.ajax({
		type: 'POST',
		url: action,
		data: 'ajax=1&hal='+data+'&'+formdata,
		beforeSend: function(){jloadings();},
		complete: function(){Clearjloadings();},				
		success: function(html){
			$("#"+divid).html(html);
		}
	});	
}
function printDok_(url,id,jenisdokumen,dok,pages,cetak){
	if(typeof(jenisdokumen)=='undefined')jenisdokumen='';
	if(typeof(dok)=='undefined')dok='';
	if(jenisdokumen=="")jenisdokumen="!";
	if(dok=="")dok="!";
	var nexturl = "";
	var pag = pages.split('|');	
	nexturl = "/1/"+pag[0]+"/"+pag[1];
	window.open(url+'/'+id+'/'+jenisdokumen+'/'+dok + nexturl+'/'+cetak, '_blank', 'width=800, height=650,toolbar=0,location=0,menubar=0');
}
function changeDokumen(id, no) {
	var tipe = "";
	var div = "";
	var jenis = $(id).val();
	jenis = jenis.toLowerCase();
	if (id == "#DOK_PABEAN") {
		tipe = "pabean";
		div = "divapproved";
	} else if(id == "#TIPE_PRODUKSI") {
		tipe = "produksi";
		div = "div" + jenis;
	}
	$("#tab-"+no).html('<br><br><center><img src=\"'+base_url+'img/_ldg.gif\" alt=\"\" /></center><br><br>');
	$.ajax({
		type: 'post',
		url: site_url + '/tools/revisi/'+tipe+'/'+jenis,
		data: 'ajax=1',
		success: function(data) {
			$("#tab-"+no).html(data);
		}
	});
}