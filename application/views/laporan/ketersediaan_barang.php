<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
date_default_timezone_set('Asia/Jakarta');
?>
<div class="header">
	<h3><strong><?= $judul; ?></strong></h3>
</div>
<div class="content">
<form name="frmLaporaninout" id="frmLaporaninout">
<table class="normal" cellpadding="2" width="100%">
    <tr>
        <td width="9%">Periode</td>
    	<td width="91%">
            <input type="text" name="periode" id="periode" readonly="" wajib="yes" class="sstext date" value="<?=date('Y-m-d')?>">
        </td>
    </tr>
    <tr>
        <td colspan="">
            <a href="<?= site_url() . '/report/ketersediaan' ?>" target="_blank" title="Cetak" style="margin-right:12px"><i class="red icon-print"></i> Cetak</a>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="tabelajax">
                <thead>
                    <tr>
                        <th width="1px">No</th>
                        <th width="15%">Kode Barang</th>
                        <th width="10%">Jenis Barang</th>
                        <th width="20%">Nama Barang</th>
                        <th>Merk</th>
                        <th width="5%">Satuan</th>
                        <th width="10%">Stock</th>
                        <th width="10%">Stock Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;
                        foreach($barang as $brg) { 
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $brg['kode_barang']; ?></td>
                        <td><?= $brg['jenis_barang']; ?></td>
                        <td><?= $brg['nama_barang']; ?></td>
                        <td><?= $brg['merk']; ?></td>
                        <td><?= $brg['satuan']; ?></td>
                        <td><?= number_format($brg['stock']); ?></td>
                        <td><?= number_format($brg['stock_minimum']); ?></td>
                    </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</form>
</div>