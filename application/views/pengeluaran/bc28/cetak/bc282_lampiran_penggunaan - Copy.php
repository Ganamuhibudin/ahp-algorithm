
  <div class="border-tbrl">
  <table width="100%" cellpadding="5" cellspacing="0">
    <tr height="30"> 
      <td colspan="2" align="center" class="border-br">BC.2.8.2</td>
      <td colspan="8" align="center" class="border-b">LEMBAR LAMPIRAN<br>
      DATA PENGGUNAAN BARANG DAN/ATAU BAHAN IMPOR</td>
    </tr>
    <tr>
      <td colspan="10" class="border-b">HEADER</td>
    </tr>
    <tr>
      <td height="31" colspan="2">NO PENGAJUAN</td>
      <td height="31" colspan="4">: <?=$DATA['NOMOR_AJU'];?></td>
      <td height="31" colspan="4" align="center">Halaman 1 dari............</td>
    </tr>
    <tr>
      <td colspan="2">A. KANTOR PABEAN </td>
      <td colspan="8">: <?=$DATA['URAIAN_KPBC'];?></td>
    </tr>
    <tr>
      <td colspan="2">B.  JENIS TPB </td>
      <td colspan="3" class="border-r">: <?=$DATA['URJENIS_TPB'];?></td>
      <td width="3%" class="border-t">H.</td>
      <td colspan="4" class="border-t">KOLOM KHUSUS BEA DAN CUKAI</td>
    </tr>
    <tr>
      <td colspan="2">C. JENIS BC 2.5 </td>
      <td width="9%">: 1. Biasa</td>
      <td width="9%">2. Berkala </td>
      <td width="22%" class="border-r"><input type="text" name="jns_bc" class="input10" value="<?=$DATA['JENIS_BC25'];?>"></td>
      <td>&nbsp;</td>
      <td colspan="2">Nomor Pendaftaran</td>
      <td colspan="2">: <?=$DATA['NOMOR_PENDAFTARAN'];?></td>
    </tr>
    <tr>
      <td colspan="2" class="border-b">D. KONDISI BARANG </td>
      <td class="border-b">: 1. Baik </td>
      <td class="border-b">2. Rusak </td>
      <td class="border-br"><input type="text" name="kondisi_brg" class="input10" value="<?=$DATA['KONDISI_BARANG'];?>"></td>
      <td class="border-b">&nbsp;</td>
      <td colspan="2" class="border-b">Tanggal</td>
      <td colspan="2" class="border-b">: <?=$DATA['TANGGAL_PENDAFTARAN'];?></td>
    </tr>
    <tr>
      <td width="7%" valign="top" class="border-br">No.Urut<br>Barang</td>
      <td width="14%" valign="top" class="border-br">- No/Tgl Aju<br>- No/Tgl Daftar<br> - Kantor Pabean *)<br> BC 2.3<br> BC 2.4 *)<br> BC 2.7</td>
      <td colspan="2" valign="top" class="border-br">No.Urut<br>Dlm<br>-BC 2.3<br>-BC 2.4<br>-BC 2.7</td>
      <td colspan="3" valign="top" class="border-br">- HS<br>- Uraian barang secara lengkap</td>
      <td width="9%" valign="top" class="border-br">- Jumlah<br>- Satuan</td>
      <td width="7%" valign="top" class="border-br">Nilai<br>- CIF<br>- (Rp)</td>
      <td width="11%" valign="top" class="border-b">Nilai (RP)<br>- BM, Cukai<br>- PPN, PPnBM</td>
    </tr>
    <tr>
      <td align="center" class="border-br">1</td>
      <td align="center" class="border-br">2</td>
      <td colspan="2" align="center" class="border-br">3</td>
      <td colspan="3" align="center" class="border-br">4</td>
      <td align="center" class="border-br">5</td>
      <td align="center" class="border-br">6</td>
      <td align="center" class="border-b">7</td>
    </tr>
    


    <tr>
      <td class="border-r">'.$no_urut.'</td>
      <td class="border-r">'.$no_aju.'/'.$tgl_aju.'</td>
      <td colspan="2" class="border-r">'.$no_urut_brgimpor.'</td>

      <td colspan="3" class="border-r">'.$no_hs.'</td>
      <td class="border-r">'.$jml_brg.'</td>
      <td class="border-r">'.$cif.'</td>
      <td>'.$bm_bayar.'</td>
    </tr>
    <tr>
      <td class="border-r">&nbsp;</td>
      <td class="border-r">'.$no_daftar.'/'.$tgl_daftar.'</td>
      <td colspan="2" class="border-r">&nbsp;</td>
      <td colspan="3" class="border-r">'.$uraian_brg.'</td>
      <td class="border-r">'.$jns_satuan.'</td>
      <td class="border-r">'.$jml_cif.'</td>
      <td>'.$cukai_bayar.'</td>
    </tr>
    <tr>
      <td class="border-r">&nbsp;</td>
      <td class="border-r">'.$kantor_pabean.'</td>
      <td colspan="2" class="border-r">&nbsp;</td>
      <td colspan="3" class="border-r">&nbsp;</td>
      <td class="border-r">&nbsp;</td>
      <td class="border-r">&nbsp;</td>
      <td>'.$pph_bayar.'</td>
    </tr>
    <tr>
      <td class="border-br">&nbsp;</td>
      <td class="border-br">&nbsp;</td>
      <td colspan="2" class="border-br">&nbsp;</td>
      <td colspan="3" class="border-br">&nbsp;</td>
      <td class="border-br">&nbsp;</td>
      <td class="border-br">&nbsp;</td>
      <td class="border-b">'.$ppnbm_bayar.'</td>
    </tr>
    <tr>
      <td colspan="10" class="border-b">*) Diisi khusus untuk barang berasal dari perusahaan dengan fasilitas KITE</td>
    </tr>
    <tr>
      <td colspan="10" class="border-b">F. TANDA TANGAN PENGUSAHA TPB </td>
    </tr>
    <tr>
      <td colspan="10">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>
    </tr>
    <tr>
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="10" align="center"><?=$DATA['KOTA_TTD'].",";?> tgl <?=$DATA['TANGGAL_TTD'];?></td>
    </tr>
    <tr>
      <td colspan="10" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="10" align="center">(<?=$DATA['NAMA_TTD'];?>)</td>
    </tr>
    <tr>
      <td colspan="10" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="10" align="center">&nbsp;</td>
    </tr>
  </table>
</div>
