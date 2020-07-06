<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div class="header">
	<h3><i class="fa fa-list"></i>&nbsp;<strong>List Barang Yang Lebih Dari 1 Tahun</strong></h3>
</div>
    <div class="content">
      <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a data-toggle="tab" href="#tab-hampir">Barang Mendekati 1 Tahun</a></li>
                <li><a data-toggle="tab" href="#tab-kadaluarsa">Barang Lebih Dari 1 Tahun</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-hampir" class="tab-pane active" style="border:none">
                    
                    <?= $hampir ?>
                </div>	
                <div id="tab-kadaluarsa" class="tab-pane">
                    <?= $kadaluarsa; ?>
                </div>
            </div>
      </div>
    </div>

<script>
    $(function() {
        $("#tab-hampir").tabs();
    });
</script>