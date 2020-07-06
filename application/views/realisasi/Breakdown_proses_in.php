<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<div class="content_luar">
<div class="content_dalam">
<h4>Breakdown Detil Barang Dokumen <?=strtoupper($DOKUMEN)?><a href="javascript:void(0)" onclick="closedialog('Divbreakdownprs')" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success btn-sm" id="ok_"><i class="icon-backward"></i>&nbsp;Selesai&nbsp;</a></h4>
<table width="100%" class="tabelPopUp">
<tr>
    <td width="16%">Nomor Aju</td>
    <td width="41%">: &nbsp<?= $this->fungsi->FormatAju($AJU)?> </td>
    <td width="17%">Seri Barang</td>
    <td width="26%">: &nbsp<?= $SERI?> </td>
</tr>
<tr>
    <td>Kode Barang</td>
    <td>: &nbsp<?=$ROW["KODE_BARANG"]?> </td>
    <td>Jenis Barang</td>
    <td>: &nbsp<?=$ROW["JNSBARANG"]?> </td>
</tr>
<tr>
    <td>Jumlah</td>
    <td>: &nbsp <b> <?=$JUMLAH?$JUMLAH:$ROW["JUMLAH_SATUAN"]?> </b></td>
    <td>Satuan</td>
    <td>: &nbsp<?=$ROW["KODE_SATUAN"]?> </td>
</tr>
</table>
<br />
<div id="DETILBARANG"><?=$DETILBARANG;?></div>
</div></div>
