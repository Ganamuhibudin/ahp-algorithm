<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

if($tipe=="GATE-IN"||$tipe=="GATE-OUT"){ ?>

<table class="tabelPopUp" width="100%" border="0">
  <thead>
    <tr align="left">
      <th>No</th>
      <th>KODE BARANG</th>
      <th>JENIS BARANG</th>
      <th>DOKUMEN PABEAN</th>
      <th>TANGGAL DOKUMEN</th>
      <th>NOMOR AJU</th>
      <th>JUMLAH</th>
      <th>TANGGAL REALISASI</th>
    </tr>
  </thead>
  <?	
    $banyakData=count($resultData);
	echo "<tbody>";
	if($banyakData>0){
		$no=1;
		foreach($resultData as $listData){
	?>
  <tr>
    <td nowrap="nowrap" align="center"><?= $no;?></td>
    <td nowrap="nowrap"><?= $listData['KODE_BARANG'];?></td>
    <td nowrap="nowrap"><?= $listData['JNS_BARANG'];?></td>
    <td nowrap="nowrap"><?= $listData['KODE_DOKUMEN'];?></td>
    <td nowrap="nowrap"><?= $listData['TANGGAL_DOKUMEN'];?></td>
    <td nowrap="nowrap"><?= $listData['NOMOR_AJU'];?></td>
    <td nowrap="nowrap" align="right"><?= $listData['JUMLAH'];?></td>
    <td nowrap="nowrap"><?= $listData['TANGGAL_REALISASI'];?></td>
  </tr>
  <? $no++;}}else{?>
  <tr>
    <td colspan="12" align="center">Maaf Belum Terdapat Data</td>
  </tr>
  <? }?>
  </tbody>  
</table>
<? }else{ ?>
<table class="tabelPopUp" width="100%" border="0">
  <thead>
    <tr align="left">
      <th>No</th>
      <th>KODE BARANG</th>
      <th>JENIS BARANG</th>
      <th>JUMLAH</th>
      <th>TANGGAL REALISASI</th>
    </tr>
  </thead>
  <?	
    $banyakData=count($resultData);
	echo "<tbody>";
	if($banyakData>0){
		$no=1;
		foreach($resultData as $listData){
	?>
  <tr>
    <td nowrap="nowrap" align="center"><?= $no;?></td>
    <td nowrap="nowrap"><?= $listData['KODE_BARANG'];?></td>
    <td nowrap="nowrap"><?= $listData['JNS_BARANG'];?></td>
    <td nowrap="nowrap" align="right"><?= $listData['JUMLAH'];?></td>
    <td nowrap="nowrap"><?= $listData['TANGGAL_REALISASI'];?></td>
  </tr>
  <? $no++;}}else{?>
  <tr>
    <td colspan="12" align="center">Maaf Belum Terdapat Data</td>
  </tr>
  <? }?>
  </tbody>  
</table>
<? } ?>
