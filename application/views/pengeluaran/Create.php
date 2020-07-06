<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR)
?>

<div class="header">
	<h3 class="green"><strong>Pilihan Pengeluaran</strong></h3>
</div>
<div class="content red" style="min-height:400px;">
	<div class="span11 infobox-container">
    	<div onclick="shortcut('bc28')" class="infobox infobox-green btn btn-primary">
        	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 2.8</span>
            	<div class="infobox-content white">Impor Dari LDP</div>
          	</div>
        </div>
        <div onclick="shortcut('bc27')" class="infobox infobox-blue btn btn-success">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 2.7</span>
            	<div class="infobox-content white">TPB Lain</div>
          	</div>
        </div>
        <div onclick="shortcut('bc33')" class="infobox infobox-pink btn btn-warning">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 3.3</span>
            	<div class="infobox-content white">Import Ke PLB</div>
          	</div>
        </div>
        <div onclick="shortcut('bc41')" class="infobox infobox-orange2 btn btn-purple">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 4.1</span></span>
            	<div class="infobox-content white">TLDDP (FAS KITE)</div>
          	</div>
        </div>
        <!--<div onclick="shortcut('bc20')" class="infobox infobox-blue2 btn btn-danger">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">BC 2.0</span></span>
            	<div class="infobox-content white">TLDDP (FAS KITE)</div>
          	</div>
        </div>-->
        <div onclick="shortcut('ppb')" class="infobox infobox-green btn btn-danger">
          	<div class="infobox-icon"> <i class="icon-edit"></i> </div>
          	<div class="infobox-data white">
            	<span class="infobox-data-number">PPB-PLB</span>
            	<div class="infobox-content white">Satu Badan Hukum</div>
          	</div>
        </div>        
        <div onclick="shortcut('p3bet')" class="infobox infobox-red btn btn-primary">
            <div class="infobox-icon"> <i class="icon-edit"></i> </div>
            <div class="infobox-data white">
              <span class="infobox-data-number">P3BET</span>
              <div class="infobox-content white" style="margin-top: -10px">Pemecahan Barang Ekspor <br>& Transhipment</div>
            </div>
        </div>
	</div>
    <div><br></div>
</div>
<script>
function shortcut(tipe){
	location.href = site_url+"/pengeluaran/create/"+tipe;
}
</script>
