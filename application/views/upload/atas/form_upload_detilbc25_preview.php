<style>
.ui-button {font-size:13px;}
</style>
<script type="text/javascript" src="<?= base_url(); ?>js/1.4.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style_popup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/table.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/newtable.css">
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
		alert('Tidak dapat diproses.\nTerdapat Nomor Aju yang sudah ada dalam database.\nPeriksa kembali data anda');
		return false;	
	}
	
	if(banyakData==0){
		alert('Tidak dapat diproses.\nData tidak ditemukan.');
		return false;	
	}
	var konfirmasi = confirm('Anda ingin menambah data ini?');
	if (konfirmasi)
	{
		$('#divLoading').html('<img src="' + base_url + 'img/_indicator.gif">  Loading...');
		var url = site_url + '/upload/insert_upload_detilbc25/<?=$aju?>/'+Math.random();
		$.ajaxSetup({async:false});
		$.post(url, {id: $('#id').val(),rowsAwal:$('#rowsAwal').val(),rowsAkhir:$('#rowsAkhir').val(),colsAwal:$('#colsAwal').val(),colsAkhir:$('#colsAkhir').val(),banyakData:$('#banyakData').val()},
			function(data){
				arrdata = data.split(' ');
				$('#divLoading').html('');				
				if(arrdata[1]=="Berhasil"){
					alert(data);
					$('#divLoading').attr('style','color:#0C0');
					$(window.opener.document.getElementById("DivHeaderForm")).load(site_url+"/pengeluaran/LoadHeader/bc25/<?=$aju?>");
					$(window.opener.document.getElementById("labelloadfbarang")).show();
	 				$(window.opener.document.getElementById("fbarang_list")).load(site_url+"/pengeluaran/detil/barang/bc25/<?=$aju?>");
            		self.close();
				}else{
					$('#divLoading').attr('style','color:#FF0000');
				}
				$('#divLoading').html('&nbsp; &nbsp; &nbsp; '+data);
		}, "json");
		return false;
	}
	else
	{
		return false;
	}
}
</script>
<div id="div1" >   
 <table class="tableA">
    <tr>
        <th colspan="2" align="center">Upload Data<span style="float:right;"><b>e-inkaber</b>&nbsp;</span></th>
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
	<td align="center" style="background:#F0F0F0"><b>Penggunaan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Kode<br />HS</b></td>
    <td align="center" style="background:#F0F0F0"><b>Kode<br />Barang</b></td>
    <td align="center" style="background:#F0F0F0"><b>Jenis<br />Barang</b></td>
    <td align="center" style="background:#F0F0F0"><b>Uraian<br />Barang</b></td>
    <td align="center" style="background:#F0F0F0"><b>Merk</b></td>
    <td align="center" style="background:#F0F0F0"><b>Tipe</b></td>
    <td align="center" style="background:#F0F0F0"><b>Ukuran</b></td>
    <td align="center" style="background:#F0F0F0"><b>Spesifikasi<br>Lain</b></td>
    <td align="center" style="background:#F0F0F0"><b>Negara<br>Asal</b></td>
    <td align="center" style="background:#F0F0F0"><b>Jumlah<br>satuan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Jenis Satuan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Jumlah<br>Kemasan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Jenis<br>Kemasan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Netto</b></td>
    <td align="center" style="background:#F0F0F0"><b>Volume</b></td>
    <td align="center" style="background:#F0F0F0"><b>Nilai<br>CIF</b></td>
    <td align="center" style="background:#F0F0F0"><b>Harga<br>Penyerahan</b></td>
    <td align="center" style="background:#F0F0F0"><b>Kode<br>Fasilitas</b></td>
    <td align="center" style="background:#F0F0F0"><b>No Urut<br>BB</b></td>
    <td align="center" style="background:#F0F0F0"><b>Dok.Asal</b></td>
    <td align="center" style="background:#F0F0F0"><b>No. Dok. Asal </b></td>
    <td align="center" style="background:#F0F0F0"><b>Tanggal&nbsp;Dok. Asal </b></td>
    <td align="center" style="background:#F0F0F0"><b>No. Urut Detil Ke </b></td>
    <td align="center" style="background:#F0F0F0"><b>Kode HS </b></td>
    <td align="center" style="background:#F0F0F0"><b>Kode Barang </b></td>
    <td align="center" style="background:#F0F0F0"><b>Jenis Barang </b></td>
    <td align="center" style="background:#F0F0F0"><b>Uraian&nbsp;Barang </b></td>
    <td align="center" style="background:#F0F0F0"><b>Merk </b></td>
    <td align="center" style="background:#F0F0F0"><b>Tipe </b></td>
    <td align="center" style="background:#F0F0F0"><b>Ukuran </b></td>
    <td align="center" style="background:#F0F0F0"><b>Spesifikasi Lain </b></td>
    <td align="center" style="background:#F0F0F0"><b>Jumlah Satuan </b></td>
    <td align="center" style="background:#F0F0F0"><b>Jenis Satuan </b></td>
    <td align="center" style="background:#F0F0F0"><b>Netto </b></td>
    <td align="center" style="background:#F0F0F0"><b>Nilai CIF </b></td>
    <td align="center" style="background:#F0F0F0"><b>Tarif BM </b></td>
    <td align="center" style="background:#F0F0F0"><b>Tarif PPN </b></td>
    <td align="center" style="background:#F0F0F0"><b>Tarif PPnBM </b></td>
    <td align="center" style="background:#F0F0F0"><b>Tarif PPh </b></td>
    																		

</tr>
<?php if ($banyakData > 0) { ?>
<?php $nomorExcel=1; for ($r=$rowsAwal; $r<=$rowsAkhir; $r++) { ?>

<tr>
    <td align="center" valign="top">
	<?php echo ($arrayData[$r][$colsAwal]['isi']=="")?"&nbsp;":$nomorExcel; ?></td>
	<?php
		$array_printed = array('Not Printed FOB','Print FOB in USD','Print FOB in Other Currency');
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
    2.Format Pengisian atau<br>
    3.Terdapat Kode Barang yang Kosong. Kode Barang HARUS diisi.<br><br>
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