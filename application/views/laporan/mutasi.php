<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="header">
  <h3><strong><?= $judul; ?></strong></h3>
</div>
<div class="content">
  <form name="frmLaporanMutasi" id="frmLaporanMutasi">
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
            <td>&nbsp;</td>
            <td>
                <a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporanMutasi','msg_laporan','divLapMutasi','<?= base_url()."index.php/report/type/mutasi";?>','laporan');"><span><i class="fa fa-arrow-right"></i>&nbsp;Proses&nbsp;</span></a>
          </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"><div id="divLapMutasi"><span class="msg_laporan" style="margin-left:9em"></span></div></td>
        </tr>
    </table>
  </form>
</div>