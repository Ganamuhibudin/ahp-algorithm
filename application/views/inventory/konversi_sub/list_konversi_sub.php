<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="content_luar">
<div class="content_dalam">
<div id="divFrmStok"></div>
<a href="javascript:void(0)" 
onclick="window.location.href='<?= site_url()."/inventory/daftar/konversi_sub"?>'" style="float:right;margin:-5px 0px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Selesai&nbsp;</span></a>

<h4><span class="info_2">&nbsp;</span><?= $judul; ?></h4>
<table class="normal" cellpadding="2" width="100%">
	<tr>
		<td><div id="divDataKonvSub"><?= $tabel; ?></div></td>
	</tr>
</table>
</div>
</div>