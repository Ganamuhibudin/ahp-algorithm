<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    error_reporting(E_ERROR);
    $event = "tb_search('barang','id_barang;kode_barang;nama_barang;jenis_barang;satuan','Kode Barang','frmLaporaninout',680,445);"
?>
<div class="header">
	<h3><strong><?= $judul; ?></strong></h3>
</div>
<div class="content">
<form name="frmLaporaninout" id="frmLaporaninout">
<table class="normal" cellpadding="2" width="100%">
    <tr>
        <td width="9%">Periode</td>
    	<td width="91%">
            <input type="text" name="tanggal_awal" id="TANGGAL_AWAL" onFocus="ShowDP('TANGGAL_AWAL');" wajib="yes" class="sstext date">
            &nbsp;s/d&nbsp;
            <input type="text" name="tanggal_akhir" id="TANGGAL_AKHIR" onFocus="ShowDP('TANGGAL_AKHIR');" wajib="yes" class="sstext date">
        </td>
    </tr>
    <tr>
        <td>Kode Barang</td>
        <td>
            <input type="hidden" name="barang[id_barang]" id="id_barang">
            <input type="hidden" name="barang[jenis_barang]" id="jenis_barang">
            <input type="hidden" name="nama_barang" id="nama_barang">
            <input type="hidden" name="barang[satuan]" id="satuan">
            <input type="text" name="barang[kode_barang]" id="kode_barang" class="text" wajib="yes" readonly="">
            <button type="button" class="btn btn-warning btn-sm" onclick="<?=$event?>"><i class="fa fa-edit"></i></button>
    	</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporaninout','msg_laporan','divLapinout','<?= base_url()."index.php/report/type/inout_barang";?>','laporan');"><span><i class="fa fa-arrow-right"></i>&nbsp;OK&nbsp;</span></a>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><div id="divLapinout"><span class="msg_laporan" style="margin-left:9em"><?= $tabel; ?></span></div></td>
    </tr>
</table>
</form>
</div>