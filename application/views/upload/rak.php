<script type="text/javascript" src="<?= base_url(); ?>assets/js/1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<div id="div1">
  <table class="tableA">
    <tr>
      <th colspan="2" align="center">Upload Data Rak<span style="float:right;"><b>PLBInventory</b>&nbsp;</span></th>
    </tr>
  </table>
  <table width="100%" class="tahapUpload">
    <tr>
      <td class="visited">&nbsp;</td>
    </tr>
  </table>
  <div style="padding:0 10px 0 10px;">
	<?php 	
		if($proses){
			echo "<br>";
			if($proses=="error"){
				echo '<input type="button" class="button" value="Upload Ulang" style="height:32px;" onclick="location.href=\''.site_url().'/uploadnew/rak\'">&nbsp;<input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">';
			}else{
				echo '<input type="button" class="button" value="Upload Lagi" style="height:32px;" onclick="location.href=\''.site_url().'/uploadnew/rak\'">&nbsp;<input type="button" class="button" value="  Tutup  " onClick="self.close();" style="height:32px;">';	
			}
			echo $msg;
		}else{
    ?>
   <?php echo $this->session->flashdata('txtuploadexcel'); ?>
    <form method="post" name="frmUpload" enctype="multipart/form-data" id="frmUpload" action="<?php echo site_url('uploadnew/proses_rak');  ?>" onSubmit="return cekFileKirim(this.name); return false;">
      <br />
      <a href="<?php echo base_url().'assets/file/UploadDokRak.xls';?>" style="text-decoration:none;"><img src='<?php echo base_url(); ?>img/tbl_xls.png' align="absmiddle">&nbsp;Contoh Format Data</a>
      <br />
      <br />
      Silahkan memilih file:
      <input class="csupload" type="file" name="fileUpload">
      &nbsp;<font color="#FF0000"><i>(Ukuran File Max. 4 MB)</i></font>      
      <br>
      <br>
      <input type="submit" class="button" value="Upload File" style="height:32px;">
      &nbsp;
      <input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">
      <br />
      &nbsp;&nbsp;<span id="loadingUpload" style="display:none"><img src="<?=base_url()?>img/_indicator.gif">  Loading...</span>
      <input type="hidden" name="id" value="<?php echo $this->newsession->userdata('KODE_TRADER').($this->newsession->userdata('USER_ID')+2); ?>">
    </form>
    <?php } if(!$proses){ ?>
    
      <span >
      Keterangan:<br> 
      -Harap file excel ditutup terlebih dahulu.<br>
      -Periksa kembali data anda sebelum diupload.<br>
      </span>
     <?php } ?> 
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
		var konfirmasi = confirm('Anda yakin akan memproses file ini?');
		if (konfirmasi){
			$("#loadingUpload").show();
			frm.submit();
		}else{
			return false;
		}
  }
}
</script>