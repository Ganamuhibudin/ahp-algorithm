<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    error_reporting(E_ERROR);
    $event = "tb_search('qc','id_pemasukan;nomor_pengadaan','Data Pengadaan','frmLaporanQc',680,445);"
?>
<div class="header">
	<h3><strong><?= $judul; ?></strong></h3>
</div>
<div class="content">
<form name="frmLaporanQc" id="frmLaporanQc">
<table class="normal" cellpadding="2" width="100%">
    <tr>
        <td width="10%">Nomor Pengadaan</td>
        <td>
            <input type="hidden" name="qc[id_pemasukan]" id="id_pemasukan">
            <input type="text" name="qc[nomor_pengadaan]" id="nomor_pengadaan" class="text" wajib="yes" readonly="">
            <button type="button" class="btn btn-warning btn-sm" onclick="<?=$event?>"><i class="fa fa-edit"></i></button>
    	</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporanQc','msg_laporan','divLapinout','<?= base_url()."index.php/report/type/qc";?>','laporan');"><span><i class="fa fa-arrow-right"></i>&nbsp;OK&nbsp;</span></a>
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