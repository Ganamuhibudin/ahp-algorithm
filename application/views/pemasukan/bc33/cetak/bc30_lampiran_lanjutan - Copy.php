
		  
  <div class="border-tbrl" style="font-size:8pt">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr> 
      <td colspan="20" align="center" style="font-size:8pt">
     	<strong>LEMBAR LANJUTAN<br>PEMBERITAHUAN EKSPOR BARANG (PEB)</strong>
      </td>
    </tr>
    <tr>
      <td width="3%" rowspan="200" class="border-t">&nbsp;</td>
      <td width="97%" colspan="10" class="border-t">
      	<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:-2px">
        	<tr>
            	<td width="17%" height="5" style="font-size:8pt">Kantor Pelayanan Bea dan Cukai</td>
                <td width="1%" style="font-size:8pt">:</td>
                <td width="25%" style="font-size:8pt"><?= $DATA['URAIAN_KPBC'] ?></td>
                <td width="4%" style="border:1px solid #000; font-size:8pt" ><?= $DATA['KODE_KPBC'] ?></td>
                <td width="53%">&nbsp;</td>
            </tr>
            <tr>
            	<td style="font-size:8pt">Nomor Pengajuan</td>
                <td style="font-size:8pt">:</td>
                <td colspan="5" style="font-size:8pt"><?= $this->fungsi->formatAju($DATA['NOMOR_AJU']) ?></td>
            </tr>
            <tr>
            	<td style="font-size:8pt">Nomor Pendaftaran</td>
                <td style="font-size:8pt">:</td>
                <td colspan="5" style="font-size:8pt"><?= $DATA['NOMOR_PENDAFTARAN'] ?></td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="10" class="border-t border-l">
      <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td width="3%" class="border-r" style="font-size:8pt">43.</td>
          <td width="42%" class="border-r" style="font-size:8pt">44.</td>
          <td width="14%" class="border-r" style="font-size:8pt">45.</td>
          <td width="9%" class="border-r" style="font-size:8pt">46.</td>
          <td width="10%" class="border-r" style="font-size:8pt">47.</td>
          <td width="13%" style="font-size:8pt">48.</td>
        </tr>
        <tr>
          <td valign="top" class="border-br" style="font-size:8pt">No</td>
          <td valign="top" class="border-br" style="font-size:8pt">Pos Tarif/HS, Uraian jumlah dan jenis barang secara lengkap, merk, tipe,<br> ukuran, spesifikasi lain dan kode barang </td>
          <td valign="top" class="border-br" style="font-size:8pt">HE barang dan Tarif BK pada tanggal pendaftaran</td>
          <td valign="top" class="border-br" style="font-size:8pt">Jumlah & jenis Berat Bersih(kg), Volume(m3) </td>
          <td valign="top" class="border-br" style="font-size:8pt">-Perizinan Ekspor<br>&nbsp; -Negara Asal Barang</td>
          <td valign="top" class="border-b" style="font-size:8pt">Jumlah Nilai FOB</td>
        </tr>
        <?php if (count($BARANG) > 1){ ?>
           <?php $no=1;?>
          <?php foreach( $BARANG as $bar):?>
          <tr>
            <td class="border-r" valign="top" align="center" style="font-size:8pt"><?=$no;?></td>
            <td class="border-r" valign="top" style="font-size:8pt"><?=$bar['KODE_HS'];?><br><?=$bar['URAIAN_BARANG1'];?>, <?=$bar['MERK']?>, <?=$bar['TIPE']?></td>
            <td class="border-r" valign="top">&nbsp;</td>
            <td class="border-r" valign="top" style="font-size:8pt"><?=$bar['JUMLAH_SATUAN'];?><br><?=$bar['URAIAN_SATUAN'];?><br><?=$bar['NETTO'];?></td>
            <td class="border-r" valign="top" style="font-size:8pt"><?=$bar['URAIAN_NEGARA'];?></td>
            <td valign="top" style="font-size:8pt"><?=$bar['FOB_PER_SATUAN'];?></td>
          </tr>
          <?php $no++; endforeach;?>
          <?php }else{ ?>
          <tr>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		<?php } ?>
      </table>
      </td>
    </tr>
  </table>
</div>
<table style="padding-left:50px; padding-right:50px;" align="right" border="0">
<tr>
    <td width="150" align="center" style="font-size:8pt"><br>   
  <br><br>
 <?=$DATA['KOTA_TTD'];?> tgl <?=$DATA['TANGGAL_TTD'];?></td>
</tr>
<tr>
  <td align="center" style="font-size:8pt">Pemberitahu</td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center" style="font-size:8pt"><?=$DATA['NAMA_TTD']?></td>
</tr>
</table>
<pagebreak  />