
<div class="border-tbrl">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="8%" align="center" class="border-r border-b"><strong>BC 2.7</strong></td>
	<td width="92%" align="center" class="border-b" height="33pt"><strong>LEMBAR LANJUTAN<br>DOKUMEN PELENGKAP PABEAN</strong></td>
</tr>
<tr>
	<td colspan="3" class="border-b"><b>HEADER</b></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">    
<tr>
<td colspan="2" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td colspan="2">&nbsp;</td>
        <td width="28%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td colspan="4" align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">NO PENGAJUAN</td>
        <td>: <?=$this->fungsi->FormatAju($DATA['NOMOR_AJU']);?></td>
        <td>&nbsp;</td>
        <td>D.</td>
        <td colspan="4">TUJUAN PENGIRIMAN: <?=$DATA['URTUJUAN_PENGIRIMAN'];?></td>
      </tr>
      <tr>
        <td width="1%">A.</td>
        <td colspan="2">KANTOR PABEAN </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
      </tr>
       <tr>
         <td>&nbsp;</td>
         <td width="5%">1. Kantor Asal</td>
        <td>: <?=$DATA['KODE_KPBC_ASAL'].' - '.$DATA['URAIAN_KPBC_ASAL'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
      </tr>
       <tr>
         <td>&nbsp;</td>
         <td>2. Kantor Tujuan</td>
        <td>: <?=$DATA['KODE_KPBC_TUJUAN'].' - '.$DATA['URAIAN_KPBC_TUJUAN'];?></td>
        <td class="border-r">&nbsp;</td>
        <td class="border-t">G.</td>
        <td colspan="4" class="border-t">KOLOM KHUSUS BEA DAN CUKAI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
       <tr>
         <td>B.</td>
         <td>JENIS TPB ASAL</td>
        <td>: <?=$DATA['JENIS_TPB_ASAL'].' - '.$DATA['URJENIS_TPB_ASAL'];?></td>
        <td class="border-r">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="14%">Nomor Pendaftaran</td>
        <td width="20%">: <?=$DATA['NOMOR_PENDAFTARAN'];?></td>
        <td width="1%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
      </tr>
       <tr>
         <td>C.</td>
         <td>JENIS TPB TUJUAN</td>
         <td>: <?=$DATA['JENIS_TPB_TUJUAN'].' - '.$DATA['URJENIS_TPB_TUJUAN'];?></td>
         <td class="border-r">&nbsp;</td>
         <td>&nbsp;</td>
         <td>Tanggal</td>
         <td>: <?=$DATA['TANGGAL_PENDAFTARAN'];?></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td class="border-br border-t" align="center">NO</td>
         <td colspan="2" class="border-b border-t" align="center">JENIS DOKUMEN</td>
         <td class="border-br border-t">&nbsp;</td>
         <td class="border-b border-t">&nbsp;</td>
         <td class="border-br border-t">NOMOR</td>
         <td class="border-b border-t" align="center">TANGGAL</td>
         <td class="border-b border-t">&nbsp;</td>
         <td class="border-b border-t">&nbsp;</td>
       </tr>        
       <tr>
         <td class="border-r" height="500pt">&nbsp;</td>
         <td colspan="2">&nbsp;</td>
         <td class="border-r">&nbsp;</td>
         <td>&nbsp;</td>
         <td class="border-r">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr> 
    </table></td>
  </tr>
</table></td>
</tr>
<tr>
<td colspan="2"><table width="100%" border="0">

</table></td>
</tr>
<tr>
<td width="42%" class="border-b">&nbsp;</td>
<td width="58%" class="border-b">E. TANDA TANGAN PENGUSAHA TPB</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center"><?=$DATA['KOTA_TTD'].",";?> Tgl. <?=$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?></td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">( <?=$DATA['NAMA_TTD'];?> )</td>
</tr>
</table>
</div>	

<?php if(count($DOKUMEN)>0){ ?>
<div style="position: relative;margin-top:-71em">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php $no=1;?>
<?php foreach( $DOKUMEN as $dok):?>
<tr>
<td style="font-size:11" width="3%" align="center"><?=$no;?></td>
<td style="font-size:11" width="56%"><?=$dok['JENIS_DOKUMEN'];?></td>
<td style="font-size:11" width="16%"><?=$dok['NOMOR_DOKUMEN'];?></td>
<td style="font-size:11" width="12%"><?=$dok['TANGGAL_DOKUMEN'];?></td>
</tr>
<?php  $no++; endforeach;?>
</table>
</div>
<?php }?>