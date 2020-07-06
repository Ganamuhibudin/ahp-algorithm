<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR)
?>

<div class="header">
	<h3 class="green"><strong>Pilihan Pemasukan</strong></h3>
</div>
<div class="content red" style="min-height:400px;">
	<div class="span11 infobox-container">
        <div onclick="shortcut('bc16')" class="infobox infobox-orange2 btn btn-primary">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 1.6</span>
            	<div class="infobox-content white">Impor dari LDP</div>
          	</div>
        </div>
        <div onclick="shortcut('bc27')" class="infobox infobox-blue btn btn-success">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 2.7</span>
            	<div class="infobox-content white">TPB Lain</div>
          	</div>
        </div>
        <div onclick="shortcut('bc40')" class="infobox infobox-pink btn btn-warning">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 4.0</span>
            	<div class="infobox-content white">TLDDP/UKM (Non KITE)</div>
          	</div>
        </div>
        <div onclick="shortcut('bc33')" class="infobox infobox-red btn btn-success">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 3.3</span>
            	<div class="infobox-content white">Export Melalui PLB</div>
          	</div>
        </div>
        <div onclick="shortcut('ppb')" class="infobox infobox-green btn btn-danger">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">PPB-PLB</span>
            	<div class="infobox-content white">Satu Badan Hukum</div>
          	</div>
        </div>
        <div onclick="shortcut('ppk')" class="infobox infobox-red btn btn-primary">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">PPK-PLB</span>
            	<div class="infobox-content white">TLDDP (Master List)</div>
          	</div>
        </div>
        <!-- <div onclick="shortcut('bc33')" class="infobox infobox-green btn btn-primary">
            <div class="infobox-icon"> <i class="icon-edit"></i> </div>
            <div class="infobox-data white">
              <span class="infobox-data-number">BC 3.3</span>
              <div class="infobox-content white">TLDDP (Master List)</div>
            </div>
        </div> -->
	</div>
    <div><br></div>
</div>
<script>
function shortcut(tipe){
	location.href = site_url+"/pemasukan/create/"+tipe;
}
</script> 
