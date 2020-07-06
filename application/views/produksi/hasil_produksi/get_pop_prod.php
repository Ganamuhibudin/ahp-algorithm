<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th>No</th>
        <th>Nomor Proses</th>
        <th>Tanggal Masuk</th>
        <th>Waktu</th>
        <th>Tools</th>
    </tr>
    <?
    $banyakData=count($resultListProd);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListProd as $listDataProd){
	?>
    <tr>
    	<td><?= $no;?></td>
        <td><?= $listDataProd['NOMOR_PROSES'];?></td>
        <td><?= $listDataProd['TANGGAL'];?></td>
        <td><?= $listDataProd['WAKTU'];?></td>
        <? if($type=="hasil_produksi"){?>
        <td><a href="javascript:void(0);" class="button save" id="ok_" onclick="getPopupProd('<?= $listDataProd['NOMOR_PROSES'];?>');"><span><span class="icon"></span>&nbsp;pilih&nbsp;</span></a></td>
        <? }elseif($type=="hasil_sisa"){?>
        <td><a href="javascript:void(0);" class="button save" id="ok_" onclick="getPopupSisa('<?= $listDataProd['NOMOR_PROSES'];?>');"><span><span class="icon"></span>&nbsp;pilih&nbsp;</span></a></td>
        <? }?>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="5">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>
<?php
if(count($resultListProd)>0){
?><br />
<div align="center">
    	<a href="javascript:void(0)" onClick="get_next_data('1')">&laquo;</a>
        <a href="javascript:void(0)" onClick="get_next_data('<?php echo ($indexSekarang==1)?1:($indexSekarang-1); ?>')">&lsaquo;</a>
         <label>
            Page
                <input type="text" name="txtGoTo" size="3" id="txtGoTo" class="numtext" value="<?php echo $indexSekarang; ?>" />
                <input type="button" value="Go" class="button" onclick="goToPage()" />
            Of <?php echo number_format($banyakIndex,0,',','.'); ?>
        </label>
        <a href="javascript:void(0)" onClick="get_next_data('<?php echo ($indexSekarang+1); ?>')">&rsaquo;</a>
        <a href="javascript:void(0)" onClick="get_next_data('<?php echo $banyakIndex; ?>')">&raquo;</a>
</div>
<?php }?>