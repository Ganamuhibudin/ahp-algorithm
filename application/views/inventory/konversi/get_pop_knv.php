<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th>No</th>
        <th>Kode Barang</th>
        <th>Uraian</th>
        <th>Jenis Barang</th>
        <th>Tools</th>
    </tr>
    <?
    $banyakData=count($resultListInv);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListInv as $listDataInv){
	?>
    <tr>
    	<td><?= $no;?></td>
        <td><?= $listDataInv['KODE_BARANG'];?></td>
        <td><?= $listDataInv['URAIAN_BARANG'];?></td>
        <td><?= $listDataInv['JENIS_BARANG'];?></td>
       	<? if($type=="konversi_subBB"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupSubKnv('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['MERK'];?>','<?= $listDataInv['TIPE'];?>','<?= $listDataInv['UKURAN'];?>','<?= $listDataInv['SPFLAIN'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"></td>
        <? }else{?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupKnv('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['MERK'];?>','<?= $listDataInv['TIPE'];?>','<?= $listDataInv['UKURAN'];?>','<?= $listDataInv['SPFLAIN'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"></td>
        <? }?>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="5">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>
<?php
if(count($resultListInv)>0){
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