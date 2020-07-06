<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
{_header_}<title>GB Inventory &bull; Bonded Warehouse Inventory Solution</title></head>
<body>
	<div class="topbg">
        <div class="meta">
            <div class="metalinks">
                <a href="<?= site_url()."/home/logout"; ?>" class="logout">
                <img src="<?= base_url(); ?>img/meta6.gif" alt="" align="absmiddle"/> Logout
                </a>
            </div>
            <p>{_welcome_}</p>            																																															
        </div>
    </div>	
	<div id="header">
		<a href="<?= site_url();?>" class="logo"><img src="<?= base_url(); ?>img/logo.png" alt="Logo GB" /></a>
		<span class="slogan">Bonded Warehouse Inventory</span>
		<ul id="menu" style="margin-left:50px">        
            <li><div class="menunya"><a href="<?= base_url(); ?>" class="topmenu">Home</a></div></li>
            <li><div class="menunya" t="95"><a href="#" class="topmenu">Approval</a>
                <div class="submenunya" style="position:absolute !important">
                  <div class="full">Daftar Perusahaan :</div>
                  <div class="half">&bull; <a href="<?= site_url(); ?>/admin/trader/lama" class="menu">Disetujui</a></div>
                  <div class="half">&bull; <a href="<?= site_url(); ?>/admin/trader/baru" class="menu">Baru</a></div>
                  <div class="full">&bull; <a href="<?= site_url(); ?>/admin/trader/reject" class="menu">Reject</a></div>
                </div>
              </div>
            </li>   
			<li><div class="menunya" t="125"><a href="#" class="topmenu">User</a>
                <div class="submenunya" style="position:absolute !important">
                  <div class="full">&bull; <a href="<?= site_url(); ?>/admin/form/add" class="menu">Buat User Baru</a></div>
                  <div class="full">&bull; <a href="<?= site_url(); ?>/admin/user" class="menu">Daftar User</a></div>
                  <div class="full">History Log :</div>
                  <div class="full">&bull; <a href="<?= site_url(); ?>/admin/activitylog" class="menu">Activity Log</a></div>
                </div>
              </div>
			</li>    
			<li class="last"><div class="menunya" t="70"><a href="#" class="topmenu">Profil</a>
                <div class="submenunya" style="position:absolute !important">
                  <div class="full">&bull; <a href="<?= site_url(); ?>/user/profil/lihat" class="menu">Profil User</a></div>
                  <div class="full">&bull; <a href="<?= site_url(); ?>/user/password" class="menu">Ubah Password</a></div>
                </div>
              </div>
			</li>    
		</ul>     
        <div id="interior_logo">
        <? if($this->newsession->userdata('LOGO')){?>
        <img src="<?= base_url(); ?>img/logo/<?= $this->newsession->userdata('LOGO'); ?>" alt="" style="max-width:181px;max-height:61px">
        <? } ?>
        </div>   
	</div>
	<div id="content" style="margin-bottom:50px">
		{_content_}   
	</div>    
	<div id="footer">
		&copy; 2012 - <?php echo date('Y');?> Electronic Data Interchange Indonesia, PT. &nbsp;&nbsp;&nbsp;Suitable View @ <a href="http://www.google.com/chrome" class="download" target="_blank">Chrome</a> &bull; <a href="http://www.mozilla.com/firefox/" class="download" target="_blank">Firefox4+</a> &bull; <a href="http://www.microsoft.com/windows/Internet-explorer/" class="download" target="_blank">IE8+</a> &bull; <a href="http://www.opera.com/download/" class="download" target="_blank">Opera</a> &bull; <a href="http://www.apple.com/safari/download/" class="download" target="_blank">Safari</a>
	</div>
</body>
</html>