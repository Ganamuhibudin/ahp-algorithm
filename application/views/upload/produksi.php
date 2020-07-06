<script type="text/javascript" src="<?= base_url(); ?>assets/js/1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<div id="div1">
  <table class="tableA">
    <tr>
      <th colspan="2" align="center">Upload Produksi <span style="float:right;"><b>PLB Inventory</b>&nbsp;</span></th>
    </tr>
  </table>
  <table width="100%" class="tahapUpload">
    <tr>
      <td class="visited" style="font-style:italic;font-size:12px" align="right">*Silahkan download format template produksi yang terbaru</td>
    </tr>
  </table>
  <div style="padding:0 10px 0 10px;">
	<?php 
		if($proses){
			echo "<br>";
			if($proses=="error"){
				echo '<input type="button" class="button" value="Upload Ulang" style="height:32px;" onclick="location.href=\''.site_url().'/uploadnew/produksi\'">&nbsp;<input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">';
			}else{
				echo '<input type="button" class="button" value="Upload Lagi" style="height:32px;" onclick="location.href=\''.site_url().'/uploadnew/produksi\'">&nbsp;<input type="button" class="button" value="  Tutup  " onClick="self.close();" style="height:32px;">';	
			}
			echo $msg;
		}else{
    ?>
   <?php echo $this->session->flashdata('txtuploadexcel'); ?>
    <form method="post" name="frmUpload" enctype="multipart/form-data" id="frmUpload" action="<?php echo site_url('uploadnew/proses_produksi');  ?>" onSubmit="return cekFileKirim(this.name); return false;">
      <br />
      <a href="<?php echo base_url().'assets/file/UploadDokPengerjaanSederhana.xls';?>" style="text-decoration:none;"><img src='<?php echo base_url(); ?>img/tbl_xls.png' align="absmiddle">&nbsp;Contoh Format Data</a><br />
      <br />
      Silahkan memilih file:
      <input class="csupload" type="file" name="fileUpload">
      &nbsp;<font color="#FF0000"><i>(Ukuran File Max. 4 MB)</i></font> 
      <br>
      <fieldset>
          <legend>Nomor Transaksi</legend>
          <input type="radio" name="masuk" id="ya" value="ya" checked="checked"/>&nbsp;Mencantumkan Nomor Transaksi Masuk<br />
          <input type="radio" name="masuk" id="tidak" value="tidak"/>&nbsp;Tanpa mencantumkan Nomor Transaksi Masuk
      </fieldset>
      <br>
      <fieldset>
          <legend> Hasil upload</legend>
          <input type="radio" name="realisasi" id="draft" value="draft" checked="checked" title="Statusnya menjadi Draft setelah diupload"/>&nbsp;Draft<br />
          <input type="radio" name="realisasi" id="setujui" value="setujui" title="Data langsung disetujui/direalisasikan"/>&nbsp;Setujui/realisasi
	  </fieldset>
      <br>
      <input type="submit" class="button" value="Upload File" style="height:32px;">
      &nbsp;
      <input type="button" class="button" value="  Batal  " onClick="self.close();" style="height:32px;">
      &nbsp;&nbsp;<span id="loadingUpload" style="display:none"><img src="<?=base_url()?>img/_indicator.gif">  Loading...</span>
      <input type="hidden" name="id" value="<?php echo $this->newsession->userdata('KODE_TRADER').$this->newsession->userdata('USER_ID'); ?>">
    </form>
    <?php } ?>
      <span style="font-size:12px;font-style:italic;float:right;bottom:-10px">Keterangan: Harap file excel ditutup terlebih dahulu</span> 
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