<?php //$this->load->view('header_popup'); ?>

<style>
.ui-button {font-size:13px;}
</style>
<script type="text/javascript" src="<?= base_url(); ?>js/1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/table.css">

<div id="div1" >   
 <table class="tableA">
    <tr>
        <th colspan="2" align="center">Upload Data Pabean<span style="float:right;"><b>GB Inventory</b>&nbsp;</span></th>
    </tr>
</table>
<table width="100%" class="tahapUpload">
<tr>
	<td class="visited" width="50%" align="center" valign="center">Tahap 1: Pilih dan Upload File</td>
	<td width="50%" align="center" valign="center">Tahap 2: Konfirmasi Data</td>
</tr>
</table>
<div style="padding-left:10px;">
<?php echo $this->session->flashdata('txtuploadexcel'); ?>
<form method="post" name="frmUpload" enctype="multipart/form-data" id="frmUpload" action="<?php echo site_url('upload/konfirmasi_data'); ?>" onSubmit="return cekFileKirim(this.name); return false;">
<br />
<a href="<?php echo base_url().'/file/UploadDokPabean.xls';?>" style="text-decoration:none;"><img src='<?php echo base_url(); ?>img/tbl_download.png' border="0" width="15">&nbsp;Contoh Format Data</a>&nbsp;&nbsp;<font color="#FF0000"><i><b>(Last Update 11 Jan 2012)</b></i></font>
<br /><br />
Silahkan memilih file: <input class="csupload" type="file" name="fileUpload">&nbsp;<font color="#FF0000"><i>(Ukuran File Max. 3 MB)</i></font>
<br>
<i>Keterangan: Harap file excel ditutup terlebih dahulu</i>
<br><br>
<input type="submit" class="button" value="Upload File" style="height:32px;">&nbsp;<input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">&nbsp;&nbsp;<span id="loadingUpload"></span>
<input type="hidden" name="id" class="id" value="<?php echo $this->newsession->userdata('KODE_TRADER').$this->newsession->userdata('USER_ID'); ?>">
</form>
</div>
<br />
</div>
<script>
function upload(namaForm){
	document.forms[namaForm].submit();
	cekFileKirim(namaForm);
}

function cekFileKirim(namaForm)
{
	//alert(base_url);
	var namaInput = 'fileUpload';
	var cb = eval('document.'+namaForm+'.'+namaInput);
	var frm = eval('document.'+namaForm);
	var filename = cb.value;
	var filelength = parseInt(filename.length) - 3;
	var fileext = filename.substring(filelength,filelength + 3);
	if(filename==""){
		alert ('File upload belum dipilih');
		cb.focus();
		return false;
	}else{
	if (fileext.toLowerCase() != 'xls')
	{
		alert ('Maaf, hanya file Excel yang dapat dikirim');
		cb.focus();
		return false;
	}
	else
	{
		
	/*	
	$.ajax({
			type: 'POST',
			url: $('#frmUpload').attr('action'),
			data: $('#frmUpload').serialize(),
			success: function(data){
				if(data){
					$('#divListIn').html(data);
					}else{
					$(".msg_").css('color', 'red');
					$(".msg_").html('Proses Gagal.');
				}
			}
		});*/
			
		$("#loadingUpload").html('<img src="<?=base_url()?>img/_indicator.gif">  Loading...');
		//document.getElementById('loadingUpload').style.display = 'block';
		frm.submit();
	}
  }
}
</script>
<?php //$this->load->view('footer_popup'); ?>