<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
$ftp_server = "10.1.5.77";
$ftp_user_name = "inkaber";
$ftp_user_pass = "1nk4b3r";*/
/*
$ftp_server = "192.168.5.2";
$ftp_user_name = "oppel";
$ftp_user_pass = "oppel123";
$file = "E:\htdocs\aikbci\\file\upload\email4masanton.txt";
$remote_file = "/einkaber/";					
$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);	
if ((!$conn_id) || (!$login_result)){
	echo "failed to connect: check hostname, username & password";
}
else{	
	echo "koneksi ok";	
	ftp_chdir($conn_id, '/home/inkaber/'); 			
	if(ftp_put($conn_id, 'email4masanton.txt', $file, FTP_BINARY)) {
		echo "successfully uploaded $file\n";
	} else {
		echo "There was a problem while uploading $file\n";
	}					
}
	ftp_close($conn_id);
*/
 ?>

<script type="text/javascript" src="<?= base_url(); ?>js/1.4.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/upload.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/alerts.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/alerts.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/table.css">

<div id="div1" >   
 <table class="tableA">
    <tr>
        <th colspan="2" align="center">Upload Data Dokumen B.C 30 <span style="float:right;"><b>e-inkaber</b>&nbsp;</span></th>
    </tr>
</table>
<table width="100%" class="tahapUpload">
</table>
<div style="padding-left:10px;">
<form method="post" name="frmUpload" enctype="multipart/form-data" id="frmUpload" action="<?php echo site_url('upload/konfirmasi_bc30'); ?>" onSubmit="return cekFileKirim(this.name); return false;">
<br /><br />
<!--Silahkan memilih file: <input class="csupload" type="file" name="filebc30" id="filebc30">&nbsp;<font color="#FF0000"><i>(Ukuran File Max. 3 MB)</i>-->
<?php if($confirm){ echo $confirm; }else{ ?>
Silahkan memilih file: <input class="csupload" type="file" name="fileUpload">&nbsp;<font color="#FF0000"><i>(Ukuran File Max. 3 MB)</i></font></font>
<?php } ?>
<br>
<br><br>
<table border="0" width="100%">
<tr><td>
<?php if($confirm){ ?>
<input type="button" class="button" value="  Tutup  " onClick="self.close();" style="height:32px;">
<?php }else{ ?>
<?php
$func = get_instance();
$func->load->model("menu_act");
if($func->menu_act->akses('57')=="w"){
?>
<span id="msgSuccess">
<input type="submit" class="button" value="Upload File" style="height:32px;">&nbsp;<input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">&nbsp;&nbsp;<span id="loadingUpload"></span>
<input type="hidden" name="id" value="<?php echo $this->newsession->userdata('KODE_TRADER').($this->newsession->userdata('USER_ID')+2); ?>">
</span>
<?php } } ?>
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
		$("#loadingUpload").html('<img src="<?=base_url()?>img/_indicator.gif">  Loading...');
		frm.submit();
	}
  }
}





function getUpload(){
	if($('#filebc30').val()==''){
		jAlert('Pilih File yang ingin di upload',':: e-INKABER ::')
	}else{
		jConfirm('Anda yakin akan meng-Upload File ini??', ":: e-INKABER ::", 
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