<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="header">
	<h3><strong><span class="icon-file-text">&nbsp;</span>Laporan Pengeluaran Barang Per Dokumen Pabean</strong></h3>
</div>
<div class="content">
    <form name="frmLaporan" id="frmLaporan">
        <table class="normal" cellpadding="2" width="100%">
            <tr>
                <td width="8%">Periode </td>
                <td width="92%">: <combo><?=form_dropdown('TIPE_PERIODE',array('REALISASI'=>'Realisasi','DOKUMEN'=>'Dokumen'),'','id="TIPE_PERIODE" class="sstext"'); ?></combo>&nbsp;<input type="text" name="TANGGAL_AWAL" id="TANGGAL_AWAL" onFocus="ShowDP('TANGGAL_AWAL');" wajib="yes" class="stext date">&nbsp; s/d&nbsp;<input type="text" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" onFocus="ShowDP('TANGGAL_AKHIR');" wajib="yes" class="stext date">
                </td>
            </tr>
            <tr>
                <td>Jenis Dokumen </td>
                <td>:  <combo><?=form_dropdown('JENIS_DOKUMEN',array(''=>'','BC28'=>'BC 2.8','BC27'=>'BC 2.7','BC30'=>'BC 3.0','BC41'=>'BC 4.1'),'','id="JENIS_DOKUMEN" class="mtext" style="width:26%;"'); ?></combo></td>
            </tr>
            <tr>
                <td>Tampilkan</td>
                <td>: <combo><?=form_dropdown('JUMPAGES',array('100'=>'100','200'=>'200','300'=>'300', '400'=>'400', '500'=>'500'),'','id="JUMPAGES" class="sstext"'); ?></combo></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporan','msg_laporan','divLapMutasi','<?= base_url()."index.php/laporan/daftar_dok/pengeluaran";?>','laporan');"><span><i class="fa fa-check"></i>&nbsp;Proses&nbsp;</span></a></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><div id="divLapMutasi"><span class="msg_laporan" style="margin-left:110px"><?= $tabel; ?></span></div></td>
            </tr>
        </table>
    </form>
</div>
