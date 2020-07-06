<div style="height:650pt">					
<div class="border-tbrl">
<div align="center" style="font-size:11" class="border-b"><b>LEMBAR LANJUTAN DOKUMEN PELENGKAP PABEAN<br>PEMBERITAHUAN EKSPOR BARANG MELALUI/DARI PUSAT LOGISTIK BERIKAT</strong><br><br>&nbsp;</b></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="2" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:-1pt">
            <tr>
                <td valign="top" width="5%" style="padding-bottom:-15px">1. Kantor Pabean Pengawas</td>
                <td valign="top" width="1%">:</td>
                <td valign="top" width="10%"><?= $DATA['URAIAN_KPBC']; ?></td>
                <td valign="top" width="4%" class="border-b border-r border-l" align="center"><?= $DATA['KODE_KPBC']; ?></td>
                <td valign="top" width="80%"></td>
            </tr>
            <tr>
                <td valign="top">2. Nomor Pengajuan</td>
                <td valign="top">:</td>
                <td valign="top" colspan="3"><?= $this->fungsi->formatAju($DATA['NOMOR_AJU']) ?></td>
            </tr>
            <tr>
              <td valign="top">3. Nomor Pendaftaran</td>
              <td valign="top">:</td>
              <td valign="top" colspan="3"><?= $DATA['NOMOR_PENDAFTARAN'].'/'.$DATA['TANGGAL_PENDAFTARAN'] ?></td>
            </tr>
        </table>
      </td>
  </tr>
  <tr>
      <td width="5%" class="border-r border-t" style="text-rotate:90deg;text-align:center;padding:10px"><strong>DOKUMEN PELENGKAP PABEAN</strong></td>
      <td width="95%" valign="top" class="border-t">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
            <tr>
                <td valign="middle" width="5%" align="center" class="border-r border-b">No.</td>
                <td valign="middle" width="20%" align="center" class="border-b border-r">Jenis Dokumen</td>
                <td valign="middle" width="25%" align="center" class="border-r border-b">Nomor Dokumen</td>
                <td valign="middle" width="25%" align="center" class="border-r border-b">Tanggal</td>
                <td valign="middle" width="25%" align="center" class="border-b">Kantor Pendaftaran CK-5<br><span style="font-size:9">(Khusus Ekspor BKC yang belum dilunasi Cukainya)</span></td>
            </tr>
            <?php $no=1;?>
            <?php foreach( $DOKUMEN as $dok): if($dok['JENIS_DOKUMEN']!="INVOICE"){?> 
            <tr>
                <td valign="top" style="font-size:11" class="border-r" align="center"><?=$no;?>.</td>
                <td valign="top" style="font-size:11" class="border-r"><?=$dok['JENIS_DOKUMEN'];?></td>
                <td valign="top" style="font-size:11" class="border-r"><?=$dok['NOMOR_DOKUMEN'];?></td>
                <td valign="top" style="font-size:11" class="border-r"><?=$dok['TANGGAL_DOKUMEN'];?></td>
                <td valign="top">&nbsp;</td>
            </tr>
            
            <tr>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <?php }$no++; endforeach;?>
            
            <?php 

            for($a=0;$a<40-(count($DOKUMEN)*2);$a++){?>
            <tr>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top" class="border-r">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <?php }?>
        </table>
    </td>
  </tr>
  <tr>
      <td align="right" class="border-t" colspan="2">
          <table border="0" cellpadding="0" cellspacing="0" style="margin-right:50px">
              <tr>
                  <td align="center">
                      <br><?=$DATA['KOTA_TTD']?>, Tgl. <?=$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?><br>Eksportir/PPJK<br><br><br><br>( <?=$DATA['NAMA_TTD'];?> )<br>&nbsp;
                  </td>
              </tr>
          </table>
      </td>
  </tr>
</table>
</div>
</div>



