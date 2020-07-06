<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="header">
<h3><strong><?= $judul; ?></strong></h3>
</div>
<div class="content">
<form name="frmLaporanOut" id="frmLaporanOut">
<table class="normal" cellpadding="2" width="100%">
<tr>
    <td colspan="2"><h4 class="blue">Laporan Pemusnahan Barang</h4></td>
</tr>
<tr>
     <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td width="11%">Periode </td>
    <td width="89%"><input type="text" name="TANGGAL_AWAL" id="TANGGAL_AWAL" onFocus="ShowDP('TANGGAL_AWAL');" wajib="yes" class="stext date">&nbsp; s/d&nbsp;<input type="text" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" onFocus="ShowDP('TANGGAL_AKHIR');" wajib="yes" class="stext date">
    </td>
</tr>
<tr>
    <td>Kode Barang </td>
    <td><input type="text" name="KODE_BARANG" id="KODE_BARANG" class="dtext" url="<?= site_url(); ?>/autocomplete/kodebarang" urai="URAIAN_BARANG;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-sm" onclick="tb_search('kodebarang','KODE_BARANG;URAIAN_BARANG','Kode Barang',this.form.id,600,400)" style="vertical-align:top" value="...">&nbsp;&nbsp;
   <a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="Laporan('frmLaporanOut','msg_laporan','divLapKeluar','<?= site_url()."/laporan/daftar_dok/pemusnahan";?>','laporan');"><span><i class="fa fa-arrow-right"></i>&nbsp;OK&nbsp;</span></a>       
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;<span id="URAIAN_BARANG"></span></td>
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
<script>
$('#KODE_BARANG').bind('change keyup focus',function(){
	if($(this).val()=="")
	$("#URAIAN_BARANG").html('');
});
</script>

