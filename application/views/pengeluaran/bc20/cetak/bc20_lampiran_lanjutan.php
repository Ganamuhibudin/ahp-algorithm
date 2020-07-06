
<div align="center" style="font-size:11"><b>LEMBAR LANJUTAN<br>PEMBERITAHUAN IMPOR BARANG (PIB)</b></div>
<div align="right" style="font-size:10">BC 2.0</div>

<div class="border-tbrl">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-size:11" class="border-b">
    <table width="100%" border="0"  style="margin-top:-6px">
        <tr>
          <td style="font-size:11" width="13%">Kantor Pabean </td>
          <td style="font-size:11" width="42%">: <?=$DATA['URAIAN_KPBC'];?></td>
          <td style="font-size:11" width="32%" align="left" valign="top"><input type="text" name="kode_pabean" class="input50" value="<?=$DATA['KODE_KPBC'];?>"></td>
          <td style="font-size:11" width="13%" align="right"></td>
        </tr>
        <tr>
          <td style="font-size:11">Nomor Pengajuan </td>
          <td style="font-size:11" colspan="3">: <?=$this->fungsi->FormatAju($DATA['NOMOR_AJU']); ?></td>
        </tr>
        <tr>
          <td style="font-size:11">Nomor Pendaftaran</td>
          <td style="font-size:11" colspan="3">: <?=$DATA['NOMOR_PENDAFTARAN'].'/'.$this->fungsi->dateformat($DATA['TANGGAL_PENDAFTARAN']); ?></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td style="font-size:11">
    
	
    
 <table width="100%" cellpadding="5" cellspacing="0" style="position:absolute;">
  <tr>
    <td style="font-size:11" width="1%" valign="top" class="border-br">31.<br>No </td>
    <td style="font-size:11" width="22%" valign="top" class="border-br">32. - Pos Tarif/HS<br>
      - Uraian barang secara lengkap meliputi jenis, <br>jumlah, merk, tipe, ukuran, spesifikasi lain<br>
    -Jenis Fasilitas</td>
    <td style="font-size:11" width="15%" valign="top" class="border-br">33. Negara<br>Asal </td>
    <td style="font-size:11" width="17%" valign="top" class="border-br">34. Tarif dan Fasilitas<br>BM, PPN, PPnBM, Cukai, PPh</td>
    <td style="font-size:11" width="14%" valign="top" class="border-br">35. -Jumlah dan Jenis Satuan barang<br> - Berat Bersih (kg)<br>-Jumlah dan jenis kemasan</td>
    <td style="font-size:11" width="15%" valign="top" class="border-b">36. Jumlah Nilai CIF</td>
  </tr>   
  <tr>
    <td style="font-size:11" class="border-r" align="center" valign="top" height="560pt">&nbsp;</td>
    <td style="font-size:11" class="border-r" height="560pt">&nbsp;</td>
    <td style="font-size:11" class="border-r" valign="top" height="560pt">&nbsp;</td>
    <td style="font-size:11" class="border-r" valign="top" height="560pt">&nbsp;</td>
    <td style="font-size:11" class="border-r" valign="top" height="560pt">&nbsp;</td>
    <td style="font-size:11" valign="top" height="560pt">&nbsp;</td>
  </tr>               
</table></td>
  </tr>
</table>
			
</div>
<table align="right" width="30%">
<tr>
	<td style="font-size:11" width="10" align="center"><br>   
	<br><br><?=$DATA['KOTA_TTD'].', tgl '.$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?></td>
</tr>
<tr>
	<td style="font-size:11" align="center">Pemberitahu</td>
</tr>
<tr>
	<td style="font-size:11" align="center">&nbsp;</td>
</tr>
<tr>
	<td style="font-size:11" align="center">&nbsp;</td>
</tr>
<tr>
	<td style="font-size:11" align="center"><?=$DATA['NAMA_TTD'];?></td>
</tr>
</table>

  <!--DATANYA-->
  <?php $no=$loop+1;?>
  <div style="position: relative;margin-top:-80em">
  <table width="100%" cellpadding="5" cellspacing="0" border="1">
  <?php 
  $looping = $loop;  
  for($i=$looping;$i<count($BARANG);$i++){
  ?> 
  <tr>  
   <td  style="font-size:11" width="5%" align="center" valign="top"><?= $no;?></td>
   <td  style="font-size:11" width="30%" valign="top"><?=$this->fungsi->FormatHS($BARANG[$i]['KODE_HS']);?><br><?=$BARANG[$i]['URAIAN_BARANG'];?><br><?=$bar['MERK']?$bar['MERK']:'-'?> - <?=$bar['TIPE']?$bar['TIPE']:'-'?> - <?=$bar['SPF']?$bar['SPF']:'-'?><br><?=$this->fungsi->FormatRupiah($BARANG[$i]['JUMLAH_KEMASAN'],4).' '.$BARANG[$i]['KODE_KEMASAN'].' / '.$BARANG[$i]['URAIAN_KEMASAN']?><br>Kd Barang : <?=$BARANG[$i]['KODE_BARANG']?></td>
   <td  style="font-size:11" width="8%" valign="top"><?=$BARANG[$i]['URAIAN_NEGARA'];?></td>
   <td  style="font-size:11" width="19%" valign="top">                                                           
   BM <?=$BARANG[$i]['TARIF_BM']?$BARANG[$i]['TARIF_BM']."%":"-";?> 
   <?=$this->fungsi->getkodefas($BARANG[$i]['KODE_FAS_BM']) ?>:<?=$BARANG[$i]['FAS_BM']?>%<BR>
   
   PPN <?=$BARANG[$i]['TARIF_PPN']?$BARANG[$i]['TARIF_PPN']."%":"-";?> 
   <?=$this->fungsi->getkodefas($BARANG[$i]['KODE_FAS_PPN']) ?>:<?=$BARANG[$i]['FAS_PPN']?>%<BR>
   
   PPnBM <?=$BARANG[$i]['TARIF_PPNBM']?$BARANG[$i]['TARIF_PPNBM']."%":"-";?> 
   <?=$this->fungsi->getkodefas($BARANG[$i]['KODE_FAS_PPNBM']) ?>:<?=$BARANG[$i]['FAS_PPNBM']?>%<BR>
   
   Cukai <?=$BARANG[$i]['TARIF_CUKAI']?$BARANG[$i]['TARIF_CUKAI']."%":"-";?> 
   <?=$this->fungsi->getkodefas($BARANG[$i]['KODE_FAS_CUKAI']) ?>:<?=$BARANG[$i]['FAS_CUKAI']?>%<BR>
   
   PPh: <? $TARIF_PPH = ($DATA['NOMOR_API']=="")?"7,5":"2,5"; echo $TARIF_PPH?$TARIF_PPH."%":"-";?> 
   <?=$this->fungsi->getkodefas($BARANG[$i]['KODE_FAS_PPH']) ?>:<?=$BARANG[$i]['FAS_PPH']?>%
   </td>
   <td  style="font-size:11" width="14%" valign="top"><?=$this->fungsi->FormatRupiah($BARANG[$i]['JUMLAH_SATUAN'],4);?><br><?=$BARANG[$i]['URAIAN_SATUAN'];?><br>BB:<?=$BARANG[$i]['NETTO'];?> Kg</td>
   <td style="font-size:11" width="15%" valign="top" align="right"><?=$this->fungsi->FormatRupiah($BARANG[$i]['CIF'],4);?></td>     
  </tr>  
  <?php  $looping++; $no++; if($looping%10==0) break; }?>                  
  </table>       
  </div>
  <!--END-->

