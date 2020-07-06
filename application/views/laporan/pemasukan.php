<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="header">
	<h3><strong><span class="icon-file-text">&nbsp;</span>Laporan Pemasukan Barang Per Dokumen Pabean</strong></h3>
</div>
<div class="content">
    <form name="frmLaporan" id="frmLaporan">
        <table class="normal" cellpadding="2" width="100%">
            <tr>
                <td width="8%"><strong>Periode</strong></td>
                <td width="20%">
					: <combo><?=form_dropdown('TIPE_PERIODE',array('REALISASI'=>'Realisasi','DOKUMEN'=>'Dokumen'),'','id="TIPE_PERIODE" class="sstext"'); ?></combo>&nbsp;<input type="text" name="TANGGAL_AWAL" id="TANGGAL_AWAL" onFocus="ShowDP('TANGGAL_AWAL');" wajib="yes" class="stext date">&nbsp; s/d&nbsp;<input type="text" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" onFocus="ShowDP('TANGGAL_AKHIR');" wajib="yes" class="stext date">
                </td>
				<td width="1%">&nbsp;</td>
				<td width="6%"><strong>Kondisi Barang</strong></td>
				<td width="30%">
					: <combo><?=form_dropdown('KONDISI_BARANG',array(''=>'','BAIK'=>'BAIK','RUSAK'=>'RUSAK'),'','id="KONDISI_BARANG" class="sstext"'); ?></combo>
				</td>
            </tr>
            <tr>
                <td><strong>Jenis Dokumen</strong></td>
                <td colspan="5">:  <combo><?=form_dropdown('JENIS_DOKUMEN',array(''=>'','BC16'=>'BC 1.6','BC27'=>'BC 2.7', 'BC40'=>'BC 4.0', 'BC24'=>'BC 2.4','BC30'=>'BC 3.0'),'','id="JENIS_DOKUMEN" class="mtext" style="width:26%;"'); ?></combo></td>
            </tr>
            <tr>
                <td><strong>Tampilkan</strong></td>
                <td colspan="5">: <combo><?=form_dropdown('JUMPAGES',array('100'=>'100','200'=>'200','300'=>'300', '400'=>'400', '500'=>'500'),'','id="JUMPAGES" class="sstext"'); ?></combo></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td colspan="5">&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-success btn-l next" onclick="Laporan('frmLaporan','msg_laporan','divLapMutasi','<?= base_url()."index.php/laporan/daftar_dok/pemasukan";?>','laporan');"><span><i class="fa fa-check"></i>&nbsp;Proses&nbsp;</span></a></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6"><div id="divLapMutasi"><span class="msg_laporan" style="margin-left:110px"><?= $tabel; ?></span></div></td>
            </tr>
        </table>
    </form>
</div>
