<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<style>
.tabelPopUp tbody tr td,.tabelPopUp thead tr th {cursor: default;padding: .3em 1.5em;}
.tabelPopUp span {background-position: center left;background-repeat: no-repeat; padding: .2em 0 .2em 1.5em;}
.tabelPopUp span.file {background-image: url(../../img/minusbottom.gif);}
.tabelPopUp span.folder {background-image: url(../../img/nolines_plus.gif);}
.klik{font-style:italic;font-size:11px;float:right;font-weight:normal}
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/treeview.css" />
<script type="text/javascript" src="<?= base_url(); ?>assets/js/treeview.js"></script>
<div class="content_luar">
<div class="content_dalam">
<h5 class="header smaller lighter green"><b>Detil Barang Breakdown</b> <span class="klik">* Klik expand pada Kode Barang untuk melihat detil</span></h5>
<?php echo $detilbarang;?>
</div></div>
<script type="text/javascript">
$(document).ready(function()  {
  $("#treeView").treeTable();
});
</script>
