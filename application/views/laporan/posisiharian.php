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
    <td colspan="3"><h5 class="smaller lighter blue"><b>LAPORAN POSISI BARANG PER DOKUMEN PABEAN HARIAN</b></h5></td>
</tr>
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<tr>
    <td width="10%">Jenis Dokumen</td>
    <td width="1%">&nbsp;</td>
    <td width="89%"><combo><?= form_dropdown('KODE_DOKUMEN', array("BC23"=>"BC 2.3","BC27"=>"BC 2.7"),'', 'id="KODE_DOKUMEN" class="text"'); ?></combo></td>
</tr>
<tr>
    <td>Nomor Pendaftaran</td>
    <td>&nbsp;</td>
    <td><input type="text" name="NOMOR_DAFTAR" id="NOMOR_DAFTAR" wajib="yes" class="text">&nbsp;
    <input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" style="vertical-align:top" onclick="tb_search('after_realisasi_in','NOMOR_DAFTAR;TANGGAL_DAFTAR;KODE_DOKUMEN','DOKUMEN PEMASUKAN',this.form.id,650,445)" value="..."></td>
</tr>
<tr>
    <td>Tanggal Pendaftaran</td>
    <td>&nbsp;</td>
    <td><input type="text" name="TANGGAL_DAFTAR" id="TANGGAL_DAFTAR" onFocus="ShowDP('TANGGAL_DAFTAR');" wajib="yes" class="stext date">&nbsp; <a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporanPros','msg_laporan','divLapProses','<?= site_url()."/laporan/daftar_dok/posisiharian";?>','laporan');"><span><i class="fa fa-arrow-right"></i>&nbsp;OK&nbsp;</span></a></td>
</tr>
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<tr>
    <td  colspan="3"><div id="divLapProses"><span class="msg_laporan" style="margin-left:50px"><?= $tabel; ?></span></div></td>
</tr>
</table>
</form>
</div>
</div>
