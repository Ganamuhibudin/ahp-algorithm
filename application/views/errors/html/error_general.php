<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
    	<link rel="shortcut icon" href="<?=base_url();?>assets/images/favicon.png">
    
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/js/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/fonts/font-awesome-4/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/style.css" />
        <title>PLB Inventory [ERROR:GENERAL]</title>
    </head>
    <body style="background-color:#272930">
    	<div id="cl-wrapper" class="error-container">
			<div class="page-error">
                <h1 class="number text-center">404</h1>
                <h2 class="description text-center"><?= $heading."\n"; ?><br ></h2>
                <h3 class="text-center"> Please contact your Administrator</h3>
                <h3 class="text-center"><i class="fa fa-home"></i>&nbsp;<a href="<?php echo base_url();?>" style="color:rgba(255,255,255,1.00)">Kembali Ke Halaman Utama</a></h3>
                <textarea hidden="hidden"><?php echo $message; ?></textarea>
			</div>
			<div class="text-center copy">&copy; 2015 - <?php echo date('Y');?>&nbsp;<a href="#">EDI Indonesia PT,</a></div>
		</div>
		<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>