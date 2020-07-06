<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div class="content_luar">
    <div class="content_dalam">
        <h4><span class="info_">&nbsp;</span>List Barang Yang Lebih Dari 1 Tahun</h4>
        <div id="tabs_barang">
            <ul>
                <li><a href="#tab-hampir">Barang Mendekati 1 Tahun</a></li>
                <li><a href="#tab-kadaluarsa">Barang Lebih Dari 1 Tahun</a></li>
            </ul>
            <div id="tab-hampir" style="background-color: #E3E8F4;">
                <?= $hampir ?>
            </div>	
            <div id="tab-kadaluarsa" style="background-color: #E3E8F4;">
                <?= $kadaluarsa; ?>
            </div>	
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabs_barang").tabs();
    });
</script>