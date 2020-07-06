<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if(!$img) $img='_row.png';
?>
<div class="box">
<div class="header">
 <h3><i class="fa fa-list"></i>&nbsp;<strong><?php echo $judul;?></strong></h3>
</div>
 <div class="content"  id="divDataPeng"><?php echo $tabel;?></div>
</div>