
<div align="center" style="font-size:11"><b>LEMBAR LAMPIRANN II<br>PEMBERITAHUAN IMPOR BARANG UNTUK DITIMBUN DI<br>TEMPAT PENIMBUNAN BERIKAT<br>UNTUK DOKUMEN DAN SKEP/PERSETUJUAN</b></div>
<div align="right" style="font-size:10;margin-top:-11px">BC 2.3</div>	

<div style="height:650pt">					
<div class="border-tbrl">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td style="font-size:11" class="border-b" colspan="12">
    <table width="100%" border="0" style="margin-top:-6px">
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
          <td style="font-size:11" colspan="3">:  <?=$DATA['NOMOR_PENDAFTARAN'].'/'.$this->fungsi->dateformat($DATA['TANGGAL_PENDAFTARAN']); ?></td>
        </tr>
    </table>
    </td>
</tr>
<tr>
    <td style="font-size:11" width="48%" valign="top" class="border-br" align="center">Jenis Dokumen</td>
    <td style="font-size:11" width="35%" valign="top" class="border-br" align="center">Nomor Dokumen</td>
    <td style="font-size:11" width="17%" valign="top" class="border-b" align="center">Tanggal Dokumen</td>
  </tr>
 <?php if (count($DOKUMEN) > 0){ ?>
 <?php $no=1;?>
 <?php foreach( $DOKUMEN as $dok): if($dok['JENIS_DOKUMEN']!="INVOICE"){?> 
  <tr>
    <td style="font-size:11" class="border-r"><?=$dok['JENIS_DOKUMEN'];?></td>
    <td style="font-size:11" class="border-r"><?=$dok['NOMOR_DOKUMEN'];?></td>
    <td style="font-size:11"><?=$dok['TANGGAL_DOKUMEN'];?></td>
  </tr>
  <?php }$no++; endforeach;?>
  <?php }else{?>
   <tr>
    <td style="font-size:11" class="border-r">&nbsp;</td>
    <td style="font-size:11" class="border-r">&nbsp;</td>
    <td style="font-size:11">&nbsp;</td>
  </tr>
  <?php }?>
</table>
</div>
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

