<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div class="content_luar">
  <div class="content_dalam">
    <h4><span class="info_2">&nbsp;</span>
      <?= $judul;?>
    </h4>
    <form name="frealisasi" id="frealisasi" action="<?= site_url()."/tools/revisidokumenpabean" ?>" method="post" autocomplete="off">
	  <input type="hidden" name="TIPE" id="TIPE" value="GATE-IN" />
      <input type="hidden" name="TANGGAL_REALISASI_HIDDEN" id="TANGGAL_REALISASI_HIDDEN" value="<?= $DATA[0]['TANGGAL_REALISASI']; ?>" />
      <input type="hidden" name="WAKTU_HIDDEN" id="WAKTU_HIDDEN" value="<?= $DATA[0]['WAKTU']; ?>" />
      <input type="hidden" name="NO_DOK_INTERNAL_HIDDEN" id="NO_DOK_INTERNAL_HIDDEN" value="<?= $DATA[0]['NOMOR_DOK_INTERNAL']; ?>" />
      <input type="hidden" name="TANGGAL_DOK_INTERNAL_HIDDEN" id="TANGGAL_DOK_INTERNAL_HIDDEN" value="<?= $DATA[0]['TANGGAL_DOK_INTERNAL']; ?>" />
      <table width="100%" border="0">
        <tr>
          <td width="15%">Nomor Bukti Penerimaan </td>
          <td width="85%"><input type="text"  name="REALISASI[NOMOR_DOK_INTERNAL]" id="NOMOR_DOK_INTERNAL" class="text" value="<?= $DATA[0]['NOMOR_DOK_INTERNAL']; ?>" wajib="yes"/>
            &nbsp;</td>
        </tr>
        <tr>
          <td>Tanggal Bukti Penerimaan </td>
          <td><input type="text"  name="REALISASI[TANGGAL_DOK_INTERNAL]" id="TANGGAL_DOK_INTERNAL" class="stext date" value="<?= $DATA[0]['TANGGAL_DOK_INTERNAL']; ?>" onfocus="ShowDP('TANGGAL_DOK_INTERNAL')" wajib="yes"/>
            &nbsp;YYYY-MM-DD</td>
        </tr>
        <tr>
          <td>Tanggal Realisasi</td>
          <td><input type="text" name="TANGGAL_REALISASI" id="TANGGAL_REALISASI" value="<?= $DATA[0]['TANGGAL_REALISASI']; ?>" class="stext date" onfocus="ShowDP(this.id)" wajib="yes">
            &nbsp;
            <input type="text" name="WAKTU" id="WAKTU" value="<?= $DATA[0]['WAKTU']; ?>" class="ssstext" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)"/>
            &nbsp;&nbsp; YYYY-MM-DD HH:MI</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><a href="javascript:void(0);" class="button save" id="ok_" onclick="eksekusirevisi('realisasi');"><span><span class="icon"></span>&nbsp;Save
          &nbsp;</span></a>&nbsp;<a href="javascript:;" class="button cancel" id="cancel_" onclick="cancel('frealisasi');"><span><span class="icon"></span>&nbsp;reset&nbsp;</span></a><span class="msgrealisasi" style="margin-left:45px">&nbsp;</span> </td>
      </tr>
      </table>
    </form>
  </div>
</div>
