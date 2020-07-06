<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="content_luar">
  <div class="content_dalam">
    <h4><span class="info_2">&nbsp;</span>Reset Data Perusahaan</h4>
    <form name="freset_" id="freset_" action="<?= site_url()."/admin/resettrader"; ?>" method="post" autocomplete="off">
      <input type="hidden" name="KODE_TRADER" id="KODE_TRADER"  />
      <table width="100%" border="0">
        <tr>
          <td width="12%">Nama Perusahaan</td>
          <td width="88%"><input type="text" name="NAMA_TRADER" id="NAMA_TRADER"  class="mtext" url="<?= site_url(); ?>/autocomplete/perusahaan"  wajib="yes" urai="KODE_TRADER;" onfocus="Autocomp(this.id, this.form.id);"/>
            <input type="hidden" name="KODE_TRADER" id="KODE_TRADER" class="text" />
            &nbsp;
            <input type="button" name="cari" id="cari" class="button" onclick="tb_search('trader','KODE_TRADER;NAMA_TRADER','PERUSAHAAN',this.form.id,730,460)" value="..."></td>
        </tr>
         <tr>
          <td width="12%">Kode Perusahaan</td>
          <td width="88%"><input type="text" name="KODE_TRADER" id="KODE_TRADER" wajib="yes" class="stext" readonly="readonly"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><a href="javascript:void(0);" class="button save" id="ok_" onclick="reset_proses();"><span><span class="icon"></span>&nbsp;Proses&nbsp;</span></a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><span class="msg_">&nbsp;</span></td>
        </tr>
        <tr>
          <td colspan="2"><h4><?=$judul;?></h4>
            <?=$tabel;?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
