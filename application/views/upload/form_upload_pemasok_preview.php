<style>
.ui-button {font-size:13px;}
</style>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/newtable.css">
<script>
	var base_url = '<?php echo base_url(); ?>';
	var site_url = '<?php echo site_url(); ?>';

function konfirmasiData(banyakError,banyakData,banyakAda)
{
	if(banyakError>0){
		alert('Tidak dapat diproses.\nTerdapat data yang tidak dikenali.\nPeriksa kembali data anda.');
		return false;	
	}	
	
	if(banyakAda>0){
		if(confirm('Hanya Kode Perusahaan yang belum terdaftar yang dapat diproses.Tambahkan ?')){
			proses(banyakData);		
		}else{		
			return false;	
		}
		return false;	
	}
	
	if(banyakData==0){
		alert('Tidak dapat diproses.\nData tidak ditemukan.');
		return false;	
	}
	var konfirmasi = confirm('Anda ingin menambah data ini?');
	if (konfirmasi)
	{
		proses(banyakData);
	}
	else
	{
		return false;
	}
}

function proses(banyakData){
	$('#divLoading').html('<img src="' + base_url + 'img/_indicator.gif">  Loading...');
	var url = site_url + '/upload/insert_upload_pemasok/'+Math.random();
	$.ajaxSetup({async:false});
	$.post(url, {id: $('#id').val(),rowsAwal:$('#rowsAwal').val(),rowsAkhir:$('#rowsAkhir').val(),colsAwal:$('#colsAwal').val(),colsAkhir:$('#colsAkhir').val(),banyakData:$('#banyakData').val()},
		function(data){
			arrdata = data.split(' ');
			$('#divLoading').html('');				
			if(arrdata[1]=="Berhasil"){
				alert(data);
				$('#divLoading').attr('style','color:#0C0');
				window.opener.location.href=site_url +'/master/daftar/pemasok';
				self.close();
			}else{
				$('#divLoading').attr('style','color:#FF0000');
			}
			$('#divLoading').html('&nbsp; &nbsp; &nbsp; '+data);
	}, "json");
	return false;
}
</script>
<div id="div1" >   
 <table class="tableA">
    <tr>
        <th colspan="2" align="center">Upload Data<span style="float:right;"><b>PLB Inventory</b>&nbsp;</span></th>
    </tr>
</table>
<table width="100%" class="tahapUpload">
<tr>
	<td class="visited" width="50%" align="center" valign="center">Tahap 1: Pilih dan Upload File</td>
	<td class="visited" width="50%" align="center" valign="center">Tahap 2: Konfirmasi Data</td>
</tr>
</table>
<br />
<div style="padding:0 5px 0 5px;">
<form method="post" name="frmUploadKonfirm" action="javascript:void(0)" onsubmit="return konfirmasiData('<?= $banyakError ?>','<?= $banyakData ?>','<?= $banyakAda ?>');  return false;">
<input type="submit" value="Simpan" class="button" style="height:32px;">&nbsp;<input type="button" class="button" value="Tutup" onClick="self.close();" style="height:32px;">&nbsp;&nbsp;<span id="divLoading"></span>


<div style="margin-top:10px">
<b>Total Data: <?php echo $banyakData; ?> data</b>
<div style="float:right;"><div style="background-color:#FF0000;width:15px;height:12px;float:left;border:1px solid #000">
</div>&nbsp;Data tidak dikenali.</div>
<div style="float:right;"><div style="background-color:#39F;width:15px;height:12px;float:left;border:1px solid #000">
</div>&nbsp;Data sudah ada.&nbsp;&nbsp;&nbsp;</div>
</div>


<div style="overflow:auto">
<table width="100%" align="center" cellpadding="2" border="0" class="tabelajax" cellspacing="0">
<tr>
	<td align="center" width="1%" style="background:#F0F0F0"><b>No.</b></td>
	<td align="center" style="background:#F0F0F0"><b>Kode Perusahaan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Kode Identitas</b></td>
    <td align="center" style="background:#F0F0F0"><b>Nomor Identitas</b></td>
    <td align="center" style="background:#F0F0F0"><b>Nama Perusahaan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Alamat Perusahaan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Jenis Perusahaan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Status Perusahaan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Negara</b></td>  												
																
</tr>
<?php if ($banyakData > 0) { ?>
<?php $nomorExcel=1; for ($r=$rowsAwal; $r<=$rowsAkhir; $r++) { ?>

<tr>
    <td align="center" valign="top">
	<?php echo ($arrayData[$r][$colsAwal]['isi']=="")?"&nbsp;":$nomorExcel; ?></td>
	<?php
		$array_yes_no = array('No','Yes');
		for ($c=$colsAwal; $c<=$colsAkhir; $c++) 
		{
			echo '<td align="'.$arrayAlign[$c].'" valign="top" class="'.$arrayData[$r][$c]['class'].'" title="'.$arrayData[$r][$c]['title'].'" ';
			echo '>'.$arrayData[$r][$c]['isi'].'&nbsp;</td>';
		}
		if (trim($arrayData[$r][$colsAwal]['isi'])!="")
		{
			$nomorExcel++;
		}
	?> 
</tr>
<?php  } ?>
<?php } else { ?>
<tr>
	<td colspan="23" align="center" valign="top">
     Tidak ada data yang terbaca.<br><br>
    Kesalahan ini dapat terjadi karena:<br>
    1.Data Kosong pada file Excel<br>
    2.Format Pengisian yang salah atau<br>
   <br>
    Mohon periksa kembali data anda
    </td>
</tr>
<?php } ?>
</table>
<br />
</div>
<br /><br /><br />
<input type="hidden" name="rowsAwal" id="rowsAwal" value="<?php echo $rowsAwal; ?>" />
<input type="hidden" name="rowsAkhir" id="rowsAkhir" value="<?php echo $rowsAkhir; ?>" />
<input type="hidden" name="colsAwal" id="colsAwal" value="<?php echo $colsAwal; ?>" />
<input type="hidden" name="colsAkhir" id="colsAkhir" value="<?php echo $colsAkhir; ?>" />
<input type="hidden" name="banyakData" id="banyakData" value="<?php echo $banyakData; ?>" />
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
</form>
</div>
</div>