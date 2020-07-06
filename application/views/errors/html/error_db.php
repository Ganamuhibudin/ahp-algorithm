<html>
    <head>
    	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
    	<link rel="shortcut icon" href="../../assets/images/favicon.png">
    
        <link rel="stylesheet" type="text/css" href="../../assets/js/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../../assets/fonts/font-awesome-4/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../../assets/css/style.css" />
        <title>EDII Marketing Tools [ERROR:DB]</title>
    </head>
    <body style="background-color:#272930">
    	<div id="cl-wrapper" class="error-container">
			<div class="page-error">
                <h1 class="number text-center">503</h1>
                <h2 class="description text-center"><?= $heading."\n"; ?><br ></h2>
                <h3 class="text-center"> Please contact your Administrator</h3>
                <h3 class="text-center"><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>" style="color:rgba(255,255,255,1.00)">Kembali Ke Halaman Utama</a></h3>
                <textarea hidden="hidden"><?php echo $message; ?></textarea>
			</div>
			<div class="text-center copy">&copy; 2018?>&nbsp;<a href="#">EDI Indonesia PT,</a></div>
		</div>
		<script type="text/javascript" src="../../assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="../../assets/js/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>