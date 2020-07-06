<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="content_luar">
<div class="content_dalam">
<h4><span class="info_">&nbsp;</span><?= $judul; ?></h4>
<form name="frmLaporanOut" id="frmLaporanOut">
<table class="normal" cellpadding="2" width="100%">
<tr>
    <td colspan="2"><b>Laporan Data Barang</b></td>
</tr>
<tr>
     <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td>Kode Barang </td>
    <td>:  <input type="text" name="KODE_BARANG" id="KODE_BARANG" class="dtext" url="<?= site_url(); ?>/autocomplete/kodebarang" urai="URAIAN_BARANG;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="button" onclick="tb_search('kodebarang','KODE_BARANG;URAIAN_BARANG','Kode Barang',this.form.id,600,400)" value="...">&nbsp;&nbsp;
   <a href="javascript:void(0);" class="button next" onclick="Laporan('frmLaporanOut','msg_laporan','divLapKeluar','<?= site_url()."/laporan/daftar_dok/pengeluaran";?>','laporan');"><span><span class="icon"></span>&nbsp;OK&nbsp;</span></a>       
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;<span id="URAIAN_BARANG"><?= $tabledata; ?></span></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td colspan="2"><div id="divLapKeluar"><span class="msg_laporan" style="margin-left:110px"><?= $tabel; ?></span></div></td>
</tr>
</table>
</form>
</div>
</div>

<script>
$('#KODE_BARANG').bind('change keyup focus',function(){
	if($(this).val()=="")
	$("#URAIAN_BARANG").html('');
});
</script>

