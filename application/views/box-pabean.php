<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
	if(in_array($jenis,array('pemasukan','breakdown_pemasukan','in'))){
		if($jenis == "in") $url = site_url()."/realisasi/daftar_dok/realisasiin_act/".$jenis;
		else $url = site_url()."/".$jenis."/daftar_dok/".$tipe;

    $pilih_dok_msk = "<ul class=\"dropdown-menu dropdown-warning pull-right\">
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc16','dataDivin','".$url."')\">BC 1.6</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc27','dataDivin','".$url."')\">BC 2.7</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc40','dataDivin','".$url."')\">BC 4.0</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc24','dataDivin','".$url."')\">BC 2.4</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc33','dataDivin','".$url."')\">BC 3.3</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('ppb','dataDivin','".$url."')\">PPB-PLB</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('ppk','dataDivin','".$url."')\">PPK-PLB</a></li>
        <li class=\"divider\"></li>
        <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('all','dataDivin','".$url."')\">Semua Dokumen</a></li>
    </ul>";
?>
<div class="btn-group" style="float:right">
	<button data-toggle="dropdown" class="btn btn-sm btn-warning dropdown-toggle">Pilih Dokumen</button>
  	<?=$pilih_dok_msk?>
    <button data-toggle="dropdown" class="btn btn-sm btn-warning dropdown-toggle"> <i class="icon-angle-down"></i> </button>
  	<?=$pilih_dok_msk?>
</div>
<?php }elseif(in_array($jenis,array('pengeluaran','breakdown_pengeluaran','out'))){
			if($jenis == "out"){
				$url = site_url()."/realisasi/daftar_dok/realisasiout_act/".$jenis;
			}elseif($jenis == "breakdown_pengeluaran"){
				$url = site_url()."/pengeluaran/daftar_dok/".$tipe;
			}else{
				$url = site_url()."/".$jenis."/daftar_dok/".$tipe; 
			}

       $pilih_dok_klr = "<ul class=\"dropdown-menu dropdown-warning pull-right\">
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc28','dataDivin','".$url."')\">BC 2.8</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc27','dataDivin','".$url."')\">BC 2.7</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc33','dataDivin','".$url."')\">BC 3.3</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('bc41','dataDivin','".$url."')\">BC 4.1</a></li>
            <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('ppb','dataDivin','".$url."')\">PPB-PLB</a></li>
        <li class=\"divider\"></li>
        <li><a href=\"javascript:void(0)\" onclick=\"list_tbl('all','dataDivin','".$url."')\">Semua Dokumen</a></li>
    </ul>";
	?>
        <div class="btn-group" style="float:right">
          <button data-toggle="dropdown" class="btn btn-sm btn-warning dropdown-toggle">Pilih Dokumen</button>
          <?=$pilih_dok_klr?>
          <button data-toggle="dropdown" class="btn btn-sm btn-warning dropdown-toggle"> <i class="icon-angle-down"></i> </button>
         <?=$pilih_dok_klr?>
        </div>
    <? } ?>
<div class="header">
	<h3><?php
		echo '<strong><i class="icon-list"></i>&nbsp;'.$title.'</strong>';
		if($subjudul){ ?>
        <small> <i class="icon-double-angle-right"></i>
        <?=$subjudul?>
        </small>
        <?php } ?>
     </h3>
</div>
<div class="content" id="dataDivin">
	<center>
		<?=$tabel?>
	</center>
</div>