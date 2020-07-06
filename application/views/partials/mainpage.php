<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  error_reporting(E_ERROR);
  $id_role = $this->newsession->userdata('id_role');
?>
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
          	<!-- <li class="active" ><a href="#">Home</a></li> -->
            <li><a href="<?= site_url(); ?>">Home</a></li>
            <?php if ($id_role == 1 || $id_role == 2) { ?>
            <li class="dropdown" >
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pemasukan<b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li><a href="<?= site_url() . '/pemasukan/pengadaan/list'; ?>">Pengadaan</a></li>
               </ul>
            </li>
            <li class="dropdown" >
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengeluaran<b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li><a href="<?= site_url('/pengeluaran/distribusi/list'); ?>">Distribusi</a></li>
                  <li><a href="<?= site_url('/pengeluaran/retur/list'); ?>">Retur Barang</a></li>
               </ul>
            </li>
            <li class="dropdown" >
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quality Control<b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li><a href="<?= site_url('/qualitycontrol/pembobotan'); ?>">Nilai Perbandingan Kriteria</a></li>
                  <li><a href="<?= site_url('/qualitycontrol/nilai/list'); ?>">Nilai Maksimal Kriteria</a></li>
                  <li><a href="<?= site_url('/qualitycontrol/qc/list'); ?>">Daftar QC</a></li>
               </ul>
            </li>
            <li class="dropdown" >
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master Data<b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li><a href="<?= site_url('/master/barang/list'); ?>">Data Barang</a></li>
                  <li><a href="<?= site_url('/master/so/list'); ?>">Stock Opname</a></li>
                  <li><a href="<?= site_url('/master/jenis_barang/list'); ?>">Jenis Barang</a></li>
                  <li><a href="<?= site_url('/master/divisi/list'); ?>">Divisi</a></li>
               </ul>
            </li>
            <li class="dropdown" >
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan<b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li><a href="<?= site_url('/report/type/inout'); ?>">Pemasukan / Pengeluaran</a></li>
                  <li><a href="<?= site_url('/report/type/inout_barang'); ?>">Keluar Masuk Barang</a></li>
                  <li><a href="<?= site_url('/report/type/mutasi'); ?>">Mutasi Barang</a></li>
                  <li><a href="<?= site_url('/report/type/ketersediaan'); ?>">Ketersediaan Barang</a></li>
                  <li><a href="<?= site_url('/report/type/qc'); ?>">Quality Control</a></li>
               </ul>
            </li>
            <li class="dropdown" >
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">User<b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li><a href="<?= site_url('/user/userlist'); ?>">Daftar User</a></li>
                  <li><a href="<?= site_url('/user/logs'); ?>">Log Activity</a></li>
               </ul>
            </li>
            <?php } else { ?>
              <li class="dropdown" >
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Permohonan<b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li><a href="<?= site_url('/pengeluaran/distribusi/list'); ?>">Daftar Permohonan</a></li>
               </ul>
            </li>
            <?php } ?>
          </ul>
          <ul class="nav navbar-nav navbar-right user-nav">
              <!-- {_notif_} -->
            <!-- <li class="button dropdown">
            	<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
              	<i class="fa fa-globe"></i><span class="bubble">2</span>
             	</a>
              <ul class="dropdown-menu">
                <li>
                  <div class="nano nscroller has-scrollbar">
                  	<div class="content" tabindex="0" style="right: -17px;">
                  		<ul>
                        <li><a href="#"><i class="fa fa-cloud-upload info"></i><b>Daniel</b> is now following you <span class="date">2 minutes ago.</span></a></li>
                        <li><a href="#"><i class="fa fa-male success"></i> <b>Michael</b> is now following you <span class="date">15 minutes ago.</span></a></li>
                        <li><a href="#"><i class="fa fa-bug warning"></i> <b>Mia</b> commented on post <span class="date">30 minutes ago.</span></a></li>
                        <li><a href="#"><i class="fa fa-credit-card danger"></i> <b>Andrew</b> killed someone <span class="date">1 hour ago.</span></a></li>
                      </ul>
                  	</div>
                  	<div class="pane" style="display: none;">
                    	<div class="slider" style="height: 20px; top: 0px;"></div>
                    </div>
              	 </div>
                    <ul class="foot"><li><a href="#">View all activity </a></li></ul>           
                </li>
              </ul>
            </li> -->
          	<li class="button dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                	<i class="fa fa-user"></i>
              </a>
              <ul class="dropdown-menu">
                  <li><a href="<?= site_url('/user/profile'); ?>"><strong>{_welcome_}</strong></a></li>
                  <li><a href="#">{_role_}</a></li>
                  <li><a href="#">{_divisi_}</a></li>
                  <li class="divider"></li>
                  <li><a href="<?php echo site_url() ?>/home/logout" style="color:red"><strong>Sign Out</strong></a></li>
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
						<div class="col-sm-14 col-md-14">
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
<style type="text/css">
    .back-to-top {
        position: fixed;
        bottom: 0;
        right: 0;
        text-decoration: none;
        color: #FFF;
        background-color: rgba(39,41,48,0.8);
        font-size: 12px;
        padding: 9px 12px;
        display: none;
    }
</style>
