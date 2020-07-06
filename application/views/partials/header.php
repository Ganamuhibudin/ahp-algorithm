<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/KBN.ico">

    <title>EDII Marketing Tools</title>
	
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/main.js"></script>
	
	<?php if($addHeader["upload"]){?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/upload.js"></script>
	<?php }?>
	

    <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/js/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href='<?= base_url()?>assets/css/font.css'>
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/fonts/font-awesome-4/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/font-awesome.min.css" />
  	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/style.css" />
	<script type="text/javascript" src="<?= base_url()?>assets/js/bootstrap/dist/js/bootstrap.min.js"></script>
  
	<?php if($addHeader["theme"]){?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/theme-elements.min.js"></script>
	<?php }?>

	
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/jquery-ui.css" />
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.ui.timepicker.js"></script>
	<?php
	/*<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>*/
    ?>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/alerts.css" />
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/alerts.js"></script>
	
	
	<?php if($addHeader["newtable"]){?>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/newtable.css" />
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/newtable.js"></script>
	<?php }?>
	
	<?php if($addHeader["autocomplete"]){?>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/autocomplete.js"></script>
	<?php }?>
	
	<?php if($addHeader["masked"]){?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
	<?php }?>
	
    <?php if($dokumen=="bc16"){?>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/bc16.js"></script>
    <?php }elseif($dokumen=="bc27"){ ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bc27.js"></script>
    <?php }elseif($dokumen=="bc40"){ ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bc40.js"></script>
    <?php }elseif($dokumen=="bc30"){ ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bc30Barang.js"></script>
    <?php }elseif($dokumen=="bc33"){ ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bc33Barang.js"></script>
    <?php }elseif($dokumen=="bc41"){ ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bc41.js"></script>
    <?php }elseif($dokumen=="bc28"){ ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bc28Barang.js"></script>
    <?php }elseif($dokumen=="bc20"){ ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bc20.js"></script>
    <?php } ?>
    <script type="text/javascript">
      var base_url = "<?= base_url(); ?>";
      var site_url = "<?= site_url(); ?>";
    </script>
  
</head>