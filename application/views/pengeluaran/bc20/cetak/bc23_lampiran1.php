	

<div align="center" style="font-size:11"><b>PEMBERITAHUAN IMPOR BARANG UNTUK DITIMBUN DI<br>TEMPAT PENIMBUNAN BERIKAT<br>PETI KEMAS</b></div>
<div align="right" style="font-size:10">BC 2.3</div>

<div style="height:650pt">	    
<div class="border-tbrl">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td  style="font-size:11" class="border-b" colspan="10">
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
<td  style="font-size:11" width="5%" valign="top" class="border-br" align="center">No<br>Urut</td>
<td  style="font-size:11" width="20%" valign="top" class="border-br" align="center">NOMOR</td>
<td  style="font-size:11" width="15%" valign="top" class="border-br" align="center">UKURAN</td>
<td  style="font-size:11" width="11%" valign="top" class="border-br" align="center">TIPE</td>
<td  style="font-size:11" width="5%" valign="top" class="border-br" align="center">No<br>Urut</td>
<td  style="font-size:11" width="19%" valign="top" class="border-br" align="center">NOMOR</td>
<td  style="font-size:11" width="14%" valign="top" class="border-br" align="center">UKURAN</td>
<td  style="font-size:11" width="11%" valign="top" class="border-b" align="center">TIPE</td>
</tr>
<?php if (count($dtkontainer) > 0){ ?>
<?php $no=1;?>
<?php foreach( $dtkontainer as $index => $kon):?> 
<tr>
<td  style="font-size:11" class="border-r" align="center"><?=$no?></td>
<td  style="font-size:11" class="border-r" align="center"><?=$kon['NOMOR'];?></td>
<td  style="font-size:11" class="border-r" align="center"><?=$kon['UKURAN_KON'];?></td>
<td  style="font-size:11" class="border-r" align="center"><?=$kon['TIPE_KON'];?></td>
<td  style="font-size:11" align="center" class="border-r">&nbsp;</td>
<td  style="font-size:11" class="border-r">&nbsp;</td>
<td  style="font-size:11" class="border-r">&nbsp;</td>
<td  style="font-size:11">&nbsp;</td>
</tr>
<?php $no++; endforeach;?>
<?php }else{?>
<tr>
<td  style="font-size:11" class="border-r" align="center">&nbsp;</td>
<td  style="font-size:11" class="border-r">&nbsp;</td>
<td  style="font-size:11" class="border-r">&nbsp;</td>
<td  style="font-size:11" class="border-r">&nbsp;</td>
<td  style="font-size:11" align="center" class="border-r">&nbsp;</td>
<td  style="font-size:11" class="border-r">&nbsp;</td>
<td  style="font-size:11" class="border-r">&nbsp;</td>
<td  style="font-size:11">&nbsp;</td>
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

		
