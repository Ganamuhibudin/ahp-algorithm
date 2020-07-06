<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?=base_url()?>assets/images/logo.png">

	<title>EDII Marketing Tools</title>
	<!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'> -->
	<link href='<?=base_url()?>assets/css/font.css' rel='stylesheet' type='text/css'>

	<!-- Bootstrap core CSS -->
	<link href="<?=base_url()?>assets/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

	<link rel="stylesheet" href="<?=base_url()?>assets/fonts/font-awesome-4/css/font-awesome.min.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="../../assets/js/html5shiv.js"></script>
	  <script src="../../assets/js/respond.min.js"></script>
	<![endif]-->

	<!-- Custom styles for this template -->
	<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />

</head>

<body class="texture">
<div id="cl-wrapper" class="login-container">
	<div class="middle-login">
		<div class="block-flat">
			<div class="header">
				<center>
					<div class="text-center">
                		<img class="logo-img" src="<?=base_url()?>assets/images/logo.png" alt="logo" style="width: 100px; height: 47px !important;"/>
                	</div>
             	</center>
			</div>
			<div>
				<form style="margin-bottom: 0px !important;" class="form-horizontal" name="frmLogin" id="frmLogin" onsubmit="javascript:return login()" autocomplete=off action="<?=site_url()?>/login/ceklogin" method="post">
					<div class="content">
						<center><h3 class="title">EDII Marketing Tools</h3></center>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input type="text" placeholder="Username" name="_usr" id="_usr" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" placeholder="Password" name="_pass" id="_pass" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon">
										<!-- <img src="<?= base_url(); ?>application/libraries/captcha/captcha.php" alt="" id="captcha"  height="" onclick="change_captcha()" style="cursor:pointer;height:20px;" title="Click to change a code"/> -->
										<img src="" alt="" id="captcha"  height="" onclick="change_captcha()" style="cursor:pointer;height:20px;" title="Click to change a code"/>
									</span>
									<input class="form-control" type="text" placeholder="Code" name="_code" id="_code">
								</div>
							</div>
						</div>
					</div>
					<center><p id="notify" class="notify"></p></center>
					<div class="foot">
						<!-- <p style="float:left;" class="color-primary"><a href="<?= site_url('/forgot'); ?>">Forgot Password</a></p> -->
						<button class="btn btn-default" data-dismiss="modal" type="button">Reset</button>
						<button class="btn btn-primary" data-dismiss="modal" type="submit" onclick="javascript:return login()">Login</button>
						<!-- <p style="float:left;" class="color-primary">This is an emphasis primary color text</p> -->
					</div>
				</form>
			</div>
		</div>
	</div> 
</div>
<script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";
	var site_url = "<?php echo site_url(); ?>";
</script>
<script src="<?=base_url()?>assets/js/jquery.js"></script>
<script src="<?=base_url()?>assets/js/login.js"></script>
</body>
</html>
