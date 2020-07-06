<div align="center" style="font-size:11"><b>LEMBAR LANJUTAN DOKUMEN PELENGKAP PABEAN<br>PEMBERITAHUAN PABEAN<br>PENIMBUNAN BARANG IMPOR DI PUSAT LOGISTIK BERIKAT</b></div>
<div align="right" style="font-size:10;margin-top:-11px">BC 1.6</div>
<div class="border-tbrl">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="font-size:11" class="border-b" colspan="12">
                <table width="100%" border="0" style="margin-top:-6px">
                    <tr>
                      <td style="font-size:11" width="13%">Kantor Pabean </td>
                      <td style="font-size:11" width="42%">: <?=$DATA['URAIAN_KPBC_BONGKAR'];?></td>
                      <td style="font-size:11" width="32%" align="left" valign="top"><input type="text" name="kode_pabean" class="input50" value="<?=$DATA['KODE_KPBC_BONGKAR'];?>"></td>
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
         <tr>
            <td style="font-size:11" height="530pt" valign="top" class="border-r" align="center">&nbsp;</td>
            <td style="font-size:11" height="530pt" valign="top" class="border-r" align="center">&nbsp;</td>
            <td style="font-size:11" height="530pt" valign="top" align="center">&nbsp;</td>
         </tr>
	</table>
</div>
<table align="right" width="100%" class="border-br border-l" style="font-size:12">
	<tr>
    	<td colspan="3"><b>PENGUSAHA PLB/PDPLB/PPJK</b></td>
    </tr>
    <tr>
        <td width="75pt">Tempat, Tanggal</td>
        <td width="5pt">:</td>
        <td>
            <?=$DATA["KOTA_TTD"]?>, <?php echo date("d M Y", strtotime($DATA["TANGGAL_TTD"]));?>
        </td>
    </tr>
    <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><?=$DATA["PEMBERITAHU"]?></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?=$DATA["JABATAN"]?></td>
    </tr>
    <tr>
        <td colspan="3">Tanda Tangan dan Stempel Persahaan :</td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr><td colspan="3">&nbsp;</td></tr>
</table>
<div style="text-align:right; font-size:9">Rangkap ke 1,2,3,4 Untuk Pengusaha PLB/PDPLB/PPJK dan Kantor Pabean</div>
<div style="position: relative;margin-top:-78em">
	<table width="100%" cellpadding="5" cellspacing="0" border="0">
		<?php if (count($DOKUMEN) > 0){ ?>
        <?php $no=1;?>
        <?php foreach( $DOKUMEN as $dok): {?> 
        <tr>
            <td style="font-size:11" width="48%"><?=$dok['JENIS_DOKUMEN'];?></td>
            <td style="font-size:11" width="35%"><?=$dok['NOMOR_DOKUMEN'];?></td>
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