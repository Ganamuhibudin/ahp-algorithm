<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/form.css">

<div id="div1" >   
 <table class="tableA">
    <tr>
        <th colspan="2" align="center">Upload Data Dokumen BC 3.0 <span style="float:right;"><b>PLB Inventory</b>&nbsp;</span></th>
    </tr>
</table>
<table width="100%" class="tahapUpload">
</table>
<div style="padding-left:10px;">
<form method="post" name="frmUpload" enctype="multipart/form-data" id="frmUpload" action="<?php echo site_url('upload/konfirmasi_bc30'); ?>" onSubmit="return cekFileKirim(this.name); return false;">
<br /><br />
<!--Silahkan memilih file: <input class="csupload" type="file" name="filebc30" id="filebc30">&nbsp;<font color="#FF0000"><i>(Ukuran File Max. 3 MB)</i>-->
<? if($confirm){ echo $confirm; }else{ ?>
Silahkan memilih file: <input class="btn btn-default btn-flat" type="file" name="fileUpload">&nbsp;<font color="#FF0000"><i>(Ukuran File Max. 3 MB)</i></font></font><br>
Tipe BC 3.0&nbsp;<input type="radio" value="MASUK" id="tipe" name="tipe">MASUK &nbsp;<input type="radio" id="tipe" value="KELUAR" name="tipe">KELUAR
<? } ?>
<br>
<br><br>
<table border="0" width="100%">
<tr><td>
<? if($confirm){ ?>
<input type="button" class="btn btn-default btn-flat" value="  Tutup  " onClick="self.close();" style="height:32px;">
<? }else{ ?>
<?php
$func = get_instance();
$func->load->model("menu_act");
//if($func->menu_act->akses('57')=="w"){
?>
<span id="msgSuccess">
<input type="submit" class="button" value="Upload File" style="height:32px;">&nbsp;<input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">&nbsp;&nbsp;<span id="loadingUpload"></span>
<input type="hidden" name="id" value="<?php echo $this->newsession->userdata('KODE_TRADER').($this->newsession->userdata('USER_ID')+2); ?>">
</span>
<? } //} ?>
</td></tr>
</table>
</form>
</div>
<br />
</div>
<script>
function cekFileKirim(namaForm){
	var namaInput = 'fileUpload';
	var cb = eval('document.'+namaForm+'.'+namaInput);
	var frm = eval('document.'+namaForm);
	var filename = cb.value;
	var filelength = parseInt(filename.length) - 3;
	var fileext = filename.substring(filelength,filelength + 3);
	if(filename==""){
		alert('File upload belum dipilih');
		cb.focus();
		return false;
	}else{
	if (fileext.toLowerCase() != 'bue')
	{
		alert ('Maaf, hanya file bue yang dapat dikirim');
		cb.focus();
		return false;
	}
	else
	{
		if($('input:radio:checked').length > 0){
			$("#loadingUpload").html('<img src="<?=base_url()?>img/_indicator.gif">  Loading...');
			frm.submit();
		}else{
			alert('Pilih Tipe BC 3.0 Terlebih Dahulu');
			return false;
		}
	}
  }
}

function getUpload(){
	if($('#filebc30').val()==''){
		jAlert('Pilih File yang ingin di upload','PLB Inventory')
	}else{
		jConfirm('Anda yakin akan meng-Upload File ini??', ":: GBInventory ::", 
		function(r){if(r==true){	
			var element = "filebc30";
			$("#loadingUpload").html('<img src=\"<?=base_url()?>img/_indicator.gif\" alt=\"loading\" /> Proses...');
			$.ajaxFileUpload({
				url:'<?=site_url()?>/upload/konfirmasi_bc30/'+element,
				secureuri:false,
				fileElementId:element,
				dataType:'json',
				success:function(data, status){
					alert(data.error);
							alert(data.msg);
					if(typeof(data.error)!='undefined'){
						if(data.error!=''){
							$("#loadingUpload").html('<span style="font-size:16px">&raquo;</span> '+data.error);
						}else{
							alert(data.msg);
							 prosesbc30(data.msg);
						}
					}
				},
				error: function(data, status, e){
					alert(data.error);
					alert(status);
					$("#loadingUpload").html(data.error);
				}
			})
		}else{return false;}});	
	}
}

//prosesbc30('file/upload/1420121008185102.BUE');
function prosesbc30(element){
	$.ajax({
			type: 'POST',
			url:'<?=site_url()?>/upload/prosesbc30/'+element,
			data: "element="+element,
			success: function(data){
				//alert(data);
				if(data!=""){
					var msg = data.split(';');	
					var pesan1="";var pesan2="";var pesan3="";
					for(var a=0;a<(msg.length)-1;a++){
						//alert(msg[a]);
						var isi = msg[a].split("#");
						if(parseInt(isi[0])==1){
							var oks = msg[a].split('|');
							pesan1 = '<span style="font-size:16px">&raquo;</span> '+((oks.length)-1)+' Nomor Aju Berhasil diupload.<br>';	
						}
						if(parseInt(isi[0])==2){
							var exist = msg[a].split('|');
							pesan2 = '<span style="font-size:16px">&raquo;</span> '+((exist.length)-1)+' '+multiReplace(isi[1],"|",", ")+'<br>';	
						}
						if(parseInt(isi[0])==3){
							var faild = msg[a].split('|');					
							pesan3 = '<span style="font-size:16px">&raquo;</span> '+((faild.length)-1)+' '+multiReplace(isi[1],"|",", ")+'<br>';
						}
					}
					var btn = '<input type="button" class="button" value="  Close  " onClick="self.close();" style="height:32px;">';
					$("#msgSuccess").html(btn+'<br>'+pesan1+''+pesan2+''+pesan3);										
				}
			}
		});		
}
function multiReplace(str, match, repl) {
    do {
        str = str.replace(match, repl);
    } while(str.indexOf(match) !== -1);
    return str;
}
</script>