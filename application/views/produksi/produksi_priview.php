<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<div class="block-flat" style="margin:10px;background-color:#FFFFCC">
<h4 class="header smaller green"><i class="icon-th"></i>&nbsp;Detil Produksi</h4>
<table width="100%" class="tabelPopUp">
<tr>
    <td width="14%"><strong>Nomor Transaksi</strong></td>
    <td width="86%">: &nbsp; <?= $DATA["NOMOR_PROSES"]?></td>
</tr>
<tr>
    <td width="14%"><strong>Tanggal Masuk</strong></td>
    <td width="86%">: &nbsp; <?=$DATA["TANGGAL"].' '.$DATA["WAKTU"]?></td>
</tr>
<?php if($TIPE=="hsl_prod_view"||$TIPE=="hsl_sisa_view"){?>
 <tr>
    <td width="14%"><strong>Nomor Transaksi Masuk</strong></td>
    <td width="86%">: &nbsp<?=$DATA["NOMOR_PROSES_ASAL"]?> </td>
</tr>
<?php } ?>
<tr>
    <td width="14%"><strong>Keterangan</strong></td>
    <td width="86%">: &nbsp; <?=$DATA["KETERANGAN"]; ?></td>
</tr>
</table>

<h4 class="header smaller green"><i class="icon-th"></i>&nbsp;Data Barang</h4>
<?= $tabel; ?>
</div>