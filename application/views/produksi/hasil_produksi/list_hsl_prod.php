<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="header">
	<a href="javascript:void(0)" 
onclick="window.location.href='<?= site_url()."/inventory/daftar/konversi"?>'" style="float:right;margin:-5px 0px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Selesai&nbsp;</span></a>
	<h3><?= $judul; ?></h3>
</div>
<div class="content">
<div id="divFrmStok"></div>
<table class="normal" cellpadding="2" width="100%">
	<tr>
		<td><div id="divDataKonv"><?= $tabel; ?></div></td>
	</tr>
</table>
</div>
