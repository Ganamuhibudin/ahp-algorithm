<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
	{_header_}
    <?php
	$uri = $this->uri->segment(2);
	$active0 = "";
	$active1 = "";
	$active2 = "";
	$active3 = "";
          if (in_array($uri, array('trader'))) {
			  $active1 = "active";
          }else if(in_array($uri, array('form','user','activutylog'))){
			  $active2 = "active";	  
		  }else if(in_array($uri, array('profil','password'))){
			  $active3 = "active";
		  }else{
			  $active0 = "active";
		  }
	?>   
	<body>
		<!-- Fixed navbar -->
		<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    	<span class="fa fa-gear"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span><b>PLB</b> Inventory</span></a>
				</div>
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                    	<li class="<?= $active0; ?>"><a href="<?= base_url(); ?>">Home</a></li>
        				<li class="dropdown <?= $active1; ?>" >
                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Approval&nbsp;&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            	<li><a href="<?= site_url(); ?>/admin/trader/lama">Disetujui</a></li>
                                <li><a href="<?= site_url(); ?>/admin/trader/reject">Reject</a></li>
                                <li><a href="<?= site_url(); ?>/admin/trader/baru">Baru</a></li>
                            </ul>
                        </li>
                        <li class="dropdown <?= $active2; ?>">
                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">User&nbsp;&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            	<li><a href="<?= site_url(); ?>/admin/form/add">Buat User Baru</a></li>
                                <li><a href="<?= site_url(); ?>/admin/user">Daftar User</a></li>
                                <li><a href="<?= site_url(); ?>/admin/activitylog">Activity Log</a></li>
                            </ul>
                        </li>
                        <li class="dropdown <?= $active3; ?>">
                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Profil&nbsp;&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            	<li><a href="<?= site_url(); ?>/user/profil/lihat">Profil User</a></li>
                                <li><a href="<?= site_url(); ?>/user/password">Ubah Password</a></li>
                            </ul>
                        </li>
                    	<!--{_menu_}-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right user-nav">
                    	<li class="button dropdown">
                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            	<i class="fa fa-user"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">{_welcome_}</a></li>
                                <li><a href="#">{_role_}</a></li>
                                <li><a href="#">{_trader_}</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url() ?>/home/logout">Sign Out</a></li>
                            </ul>
                    	</li>
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
                                <!-- <div class="header">
                                <h2>Flow Diagram Pusat Logistik Berikat</h2>
                                </div>
                                <div class="content">
                                <center>
                                <img src="<?=base_url()?>assets/images/flow-gb.png">
                                </center>
                                </div> -->
							</div>
						</div>
					</div>
				</div> 
			</div>
    	</div>
	</body>
</html>
