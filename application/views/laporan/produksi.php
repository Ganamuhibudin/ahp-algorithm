<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="header">
	<h3><strong><?= $judul; ?></strong></h3>
</div>
<div class="content">
<form name="frmLaporanPros" id="frmLaporanPros">
<table class="normal" cellpadding="2" width="100%">
<tr>
    <td colspan="2"><h5 class="smaller lighter blue"><b>LAPORAN PENGERJAAN SEDERHANA</b></h5></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td width="8%">Periode</td>
	<td width="92%">
	  <input type="text" name="TANGGAL_AWAL" id="TANGGAL_AWAL" onFocus="ShowDP('TANGGAL_AWAL');" wajib="yes" class="stext date">&nbsp;s/d&nbsp;<input type="text" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" onFocus="ShowDP('TANGGAL_AKHIR');" wajib="yes" class="stext date">
    </td>
</tr>
<tr>
    <td>Jenis</td>
    <td><combo><?= form_dropdown('JENIS', array(""=>"","PROCESS_IN"=>"Barang yang diproses [Input]","PROCESS_OUT"=>"Hasil Pengerjaan [Output]","SCRAP"=>"Sisa Pengerjaan/Scrap"), '', 'id="JENIS" class="dtext" wajib="yes"'); ?></combo>
		 &nbsp; <a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporanPros','msg_laporan','divLapProses','<?= base_url()."index.php/laporan/daftar_dok/produksi";?>','laporan');"><span><i class="fa fa-arrow-right"></i>&nbsp;OK&nbsp;</span></a>
	</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td colspan="2"><div id="divLapProses"><span class="msg_laporan" style="margin-left:70px"><?= $tabel; ?></span></div></td>
</tr>
</table>
</form>
</div>
