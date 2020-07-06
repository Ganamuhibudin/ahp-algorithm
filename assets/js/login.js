/* Delete Unnecessary Script! */
$(document).ready(function(){
	$('#frmLogin .input' ).each(function(n,element){
		$(this).keypress(function(){
		$("#"+element.id).css("background","#ffffff");
		$("#notify").fadeOut('slow');
		});		
	});
	$("input, textarea, select").focus(function(){
		if($(this).attr('wajib')=="yes"){
			$(".msg_").fadeOut('slow');
			$(this).removeClass('wajib');
		}
	});
	document.getElementById('captcha').src=site_url+"/main/generateCaptcha/" + Math.random();
});
function ShowErrorBox(DivID,message){
	$(DivID).css({"color":"red"});
	$(DivID).hide();
	$(DivID).html(message);
	$(DivID).fadeIn('slow');
}	
function ExecFormLogin(DivID,formId){
	$.ajax({
		type: 'POST',
		url: $(formId).attr('action') + '/ajax',
		data: $(formId).serialize(),
		dataType: 'html',
		beforeSend: function(){			
			ShowErrorBox(DivID,'<img src=\"'+base_url+'img/_ldg.gif\" alt=\"loading\" border=\"0\" />');
		},
		success: function(data){
			if(typeof(data) != 'undefined'){
				var arrayDataTemp = data.split("|");
				if(arrayDataTemp[0] == 0){
					$(DivID).css({"color":"red"});
					ShowErrorBox(DivID,arrayDataTemp[1]);	
				}
				else if(arrayDataTemp[0] == 1){
					$(DivID).css({"color":"green"});
					ShowErrorBox(DivID,arrayDataTemp[1]);	
					window.location.reload(true);
				}
				else if(arrayDataTemp[0] == 2){
					$(DivID).css({"color":"green"});
					ShowErrorBox(DivID,arrayDataTemp[1]);	
					setTimeout(function(){window.location.reload(true)}, 2000);
				}
			}
		}
	});			
}
function login(){
	var a=0;	
	$('#frmLogin .form-control' ).each(function(n,element){
		if ($(element).val()==''){  
			a = a+1;
			$("#"+element.id).css("background","#FFECFF");
		}else{
			$("#"+element.id).css("background","");
		}  
	});  	
	if(a>0){
		if($("#_usr").val()==""){
			ShowErrorBox("#notify",'&nbsp;Isi Username Terlebih Dahulu');
			$("#_usr").focus();
		}
		else if($("#_pass").val()==""){
			ShowErrorBox("#notify",'&nbsp;Isi Password Terlebih Dahulu');
			$("#_pass").focus();
		}
		else if($("#_code").val()==""){
			ShowErrorBox("#notify",'&nbsp;Isi Kode Terlebih Dahulu');
			$("#_code").focus();
		}
		return false;
	}
	else{
		ExecFormLogin('#notify','#frmLogin');
	}
	return false;
}
function change_captcha(){
	document.getElementById('captcha').src=site_url+"/main/generateCaptcha/" + Math.random();
}	
function c_div(id, inner){
	div = document.createElement("div");	
	div.innerHTML = '<div id="'+id+'" style="display: none;">'+inner+'</div>';
	document.body.appendChild(div);
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
		show:{ effect: 'fade', direction: "up" },
		hide:{ effect: 'fade', direction: "up" }  
		// effect: drop,explode,slide,Fade,Fold,highlight,Pulsate,Scale,Shake,Transfer,Blind,Bounce,Clip
	});
}	
function Dialog(url,Divid,title,width,height){
	c_dialog(Divid, ':: '+title+' ::', '<div id="idv_popup"></div>', width, height, "run-in", true, false);
	$("#"+Divid).html('<center><img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...</center>');
	$('#'+Divid).load(url);				
}
function closedialog(id){$("#"+id).dialog('close');}
function cancel(formid){document.getElementById(formid).reset();return false;};
function validasi(divid){
	if(divid==""||typeof(divid)=="undefined"){var divid = "msg_";}else{var divid = divid;}
	$("."+divid).hide();
	$("."+divid).css('color', '');
	$("."+divid).html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />loading...');
	$("."+divid).fadeIn('slow');
 	var notvalid = 0;
	var notnumber = 0;
	var regNumber =/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
	$.each($("input:visible, select:visible, textarea:visible, input:checkbox, input:radio"), function(){
		if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
			$(this).addClass('wajib');
			notvalid++;
		}
		if($(this).attr('format')=="angka" && (!regNumber.test($(this).val()) && $(this).val()!="")){
			$(this).addClass('format');
			notnumber++;
		}
	});
	if(notvalid>0 || notnumber >0){
		var val1="";var val2="";var pisah="";
		if(notvalid>0){	val1 ='Ada ' + notvalid + ' Kolom Yang Harus Diisi'; }
		if(notnumber>0){ val2 ='Ada '+notnumber+' Kolom Yang Harus Diisi Dengan Angka';	}
		if(notvalid>0 && notnumber>0){ pisah =' Dan '; }
		$("."+divid).css('color', 'red');
		$("."+divid).html(val1+pisah+val2);
		$("."+divid).fadeIn('slow');
		return false;
	}else{
		return true;	
	}		
	return false;
}
function savepos(formid,divid){
	if(validasi(divid)){		
	$.ajax({
		type: 'POST',
		url: $(formid).attr('action')+"/ajax",
		data: $(formid).serialize(),
		success: function(data){ 
			if(typeof(data) != 'undefined'){
				var arrayDataTemp = data.split("|");
				if(arrayDataTemp[0]==0){
					$("."+divid).css('color', 'red');
					$("."+divid).html(arrayDataTemp[1]);
				}
				else if(arrayDataTemp[0]==1){
					closedialog('dialog-lpass');
					jAlert('Password anda telah diubah.<br>Silahkan Cek email anda.'," KITE Inventory");	
				}
			}	
		}
	});	
}return false;	
}
function pas_(){
	Dialog(site_url+"/login/lostpassword/view", 'dialog-lpass','Form Lupa Password',560, 300);	
}
function showberita(id){
	Dialog(site_url+"/admin/showberita/"+id, 'dialog-berita','Update Perubahan KITE Inventory',700, 450);	
}
