<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="content_luar">
<div class="content_dalam">
<div class="header">
	<h3><strong><?= $judul; ?></strong></h3>
</div><br>
<a href="javascript:void(0)" onclick="Dialog('<?= site_url()."/inventory/popupcetak_inout"?>','dialog-tbl','PLB INVENTORY',500,350)" style="float:right;margin:-52px 0px 0px 0px" class="btn btn-sm btn-primary"><i class="icon-print"></i>&nbsp;Cetak&nbsp;</a>

<!--<a href="javascript:void(0)" title="Menyesuaikan Stock Akhir Barang Inventory Berdasarkan Mutasi yang sudah terjadi tersebut" onclick="update_stock('msgUpdateStock','<?= site_url()."/inventory/edit/singkronmutasi"?>','update_stock')" style="float:right;margin:-42px 100px 0px 0px" class="button next" id="ok_" ><span><span class="icon"></span>&nbsp;Sesuaikan Stock Akhir Barang&nbsp;</span></a><span class="msgUpdateStock" style=" float:right;margin-left:5px">&nbsp;</span>-->
 	
<?=$content?>
</div>
</div>