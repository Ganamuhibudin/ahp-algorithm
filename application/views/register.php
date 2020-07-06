<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
$class1 = "";$class2 = "";
$link = $this->uri->segment(1);
if($link=="register") $class1 = 'class="active"';
if($link=="forgot") $class2 = 'class="active"';
?>
<!DOCTYPE html>
<html lang="en">
{_header_}
<body>
  <!-- Fixed navbar -->
  <div id="head-nav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      	<div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	          <span class="fa fa-gear"></span>
	        </button>
	      	<a class="navbar-brand" href="#"><span><b>&nbsp;</b></span></a>
      	</div>
      	<div class="navbar-collapse collapse">
        	<ul class="nav navbar-nav">
				<li><a href="<?= base_url(); ?>">Login</a></li>
        		<!--<li <?=$class1?>><a href="<?= site_url('register'); ?>">Registrasi</a></li>-->
        		<li <?=$class2?>><a href="<?= site_url('forgot'); ?>">Lupa Password</a></li>
        	</ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
	<div id="cl-wrapper">
		<div class="container-fluid">
		  <div class="cl-mcont">
			<div class="row dash-cols">
				<div class="col-sm-13 col-md-13">
					<div class="block-flat">
						{_content_}
					</div>
				</div>
		  </div>
		</div> 
	</div>
  </div>
  </body>
</html>
