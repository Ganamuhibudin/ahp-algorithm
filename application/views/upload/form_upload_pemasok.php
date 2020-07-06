<style>
.ui-button {font-size:13px;}
</style>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<div id="div1" >   
 <table class="tableA">
    <tr>
        <th colspan="2" align="center">Upload Data Pemasok <span style="float:right;"><b>PLB Inventory</b>&nbsp;</span></th>
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
<form method="post" name="frmUpload" enctype="multipart/form-data" id="frmUpload" action="<?php echo site_url('upload/konfirmasi_pemasok'); ?>" onSubmit="return cekFileKirim(this.name); return false;">
<br />
<a href="<?php echo base_url().'assets/file/UploadDataPemasok.xls';?>" style="text-decoration:none;"><img src='<?php echo base_url(); ?>img/tbl_xls.png' border="0" width="15">&nbsp;Contoh Format Data</a>
<br /><br />
Silahkan memilih file: <input class="csupload" type="file" name="fileUpload">&nbsp;<font color="#FF0000"><i>(Ukuran File Max. 4 MB)</i></font>
<br>
<i>Keterangan: Harap file excel ditutup terlebih dahulu</i>
<br><br>
<input type="submit" class="button" value="Upload File" style="height:32px;">&nbsp;<input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">&nbsp;&nbsp;<span id="loadingUpload"></span>
<input type="hidden" name="id" value="<?php echo $this->newsession->userdata('KODE_TRADER').($this->newsession->userdata('USER_ID')+2); ?>">
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
	if (fileext.toLowerCase() != 'xls')
	{
		alert ('Maaf, hanya file Excel yang dapat dikirim');
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
</script>