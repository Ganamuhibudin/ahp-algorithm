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
        <? if($type=="stock"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupRealInv('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>');"></td>
		<? }elseif($type=="konversi"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupRealKnv('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['MERK'];?>','<?= $listDataInv['TIPE'];?>','<?= $listDataInv['UKURAN'];?>','<?= $listDataInv['SPFLAIN'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"><span><span class="icon"></span>&nbsp;pilih&nbsp;</span></a></td>
        <? }elseif($type=="konversi_sub"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupRealKnvSub('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['MERK'];?>','<?= $listDataInv['TIPE'];?>','<?= $listDataInv['UKURAN'];?>','<?= $listDataInv['SPFLAIN'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"></td>
        <? }elseif($type=="konversiBB"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupKnv('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['MERK'];?>','<?= $listDataInv['TIPE'];?>','<?= $listDataInv['UKURAN'];?>','<?= $listDataInv['SPFLAIN'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"></td>
       <? }elseif($type=="bahanBaku"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupBB('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"></td>
        <? }elseif($type=="proses_produksi"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupProd('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"></td>
        <? }elseif($type=="proses_sisa"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupSisa('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>');"></td>
        <? }elseif($type=="pengrusakan"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupPengrusakan('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>');"></td>
        <? }elseif($type=="pemusnahan"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupPemusnahan('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>');"></td>
        <? }elseif($type=="mappingBB"){?>
        <td><input type="button" class="button" value="pilih" onclick="getPopupMapping('<?= $listDataInv['KODE_BARANG'];?>','<?= $listDataInv['URAIAN_BARANG'];?>','<?= $listDataInv['KODE_SATUAN'];?>','<?= $listDataInv['URAIAN_SATUAN'];?>','<?= $listDataInv['JENIS_BARANG'];?>','<?= $listDataInv['JNS_BARANG'];?>','<?= $listDataInv['MERK'];?>');"></td>
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
                <input type="text" name="txtGoTo" size="3" class="numtext" id="txtGoTo" value="<?php echo $indexSekarang; ?>" />
                <input type="button" value="Go" class="button" onclick="goToPage()" />
            Of <?php echo number_format($banyakIndex,0,',','.'); ?>
        </label>
        <a href="javascript:void(0)" onClick="get_next_data('<?php echo ($indexSekarang+1); ?>')">&rsaquo;</a>
        <a href="javascript:void(0)" onClick="get_next_data('<?php echo $banyakIndex; ?>')">&raquo;</a>
</div>
<?php }?>