<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>

<div class="header">
	<h3><i class="icon-file-text"></i>&nbsp;<strong>LAPORAN POSISI BARANG PER DOKUMEN PABEAN</strong></h3>
</div>
<div class="content">   
	<form name="frmLaporanPros" id="frmLaporanPros">
		<table class="normal" cellpadding="2" width="100%">
        	<tr>
                <td width="8%"> Periode </td>
                <td width="92%">
                    <combo><?=form_dropdown('TIPE_PERIODE',array('IN'=>'PEMASUKAN','OUT'=>'PENGELUARAN','INOUT'=>'PEMASUKAN DAN PENGELUARAN'),'','id="TIPE_PERIODE" class="text"'); ?></combo>
                    <input type="text" name="TANGGAL_AWAL" id="TANGGAL_AWAL" onFocus="ShowDP('TANGGAL_AWAL');" wajib="yes" class="stext date">
                    &nbsp;s/d&nbsp;
                    <input type="text" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" onFocus="ShowDP('TANGGAL_AKHIR');" wajib="yes" class="stext date">
                    &nbsp; <a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporanPros','msg_laporan','divLapProses','<?= base_url()."index.php/laporan/daftar_dok/posisi";?>','laporan');"><span><i class="fa fa-arrow-right"></i>&nbsp;OK&nbsp;</span></a></td>
        	</tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="checkbox" name="ALL_SALDO" id="ALL_SALDO" value="1" />
            Tampilkan pemasukan yang masih memiliki saldo
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="2"><div id="divLapProses"><?= $tabel; ?></div></td>
        </tr>
	</table>
</form>
</div>
