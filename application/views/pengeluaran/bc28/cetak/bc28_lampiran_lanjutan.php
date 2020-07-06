<span style="font-size:11;font-family:Arial, Helvetica, sans-serif">

  <table width="100%" cellpadding="0" border="0" cellspacing="0">
    <tr>
       <td width="92%" align="center" colspan="3" height="35pt"><strong>LEMBAR LANJUTAN<br>
        PEMBERITAHUAN IMPOR BARANG DARI PUSAT LOGISTIK BERIKAT</strong></td>
    </tr>
    <tr>
        <td colspan="3" align="right">BC 2.8</td>
    </tr>
  </table>
<div class="border-tbrl">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding-top:-3px">
     <tr>
      <td width="55%">
	      <table>
	      <tr>
		      <td width="26%"><strong>KANTOR PABEAN</strong></td>
		      <td width="1%">:</td>
		      <td width="73%"><?= ucwords(strtolower($DATA["KODE_KPBC"].' '.$DATA['URAIAN_KPBC']));?></td>
	      </tr>
	      <tr>
	      	  <td><strong>NOMOR PENGAJUAN</strong></td>
	      	  <td>:</td>
	      	  <td><?=$this->fungsi->FormatAju($DATA['NOMOR_AJU'])?></td>
	      </tr>
	       <tr>
            <td><strong>NOMOR PENDAFTARAN</strong></td>
 			<td>:</td>
            <td colspan="3"><?=$DATA['NOMOR_PENDAFTARAN'];?></td>
          </tr>
	      </table>
      </td>
      <td width="45%" valign="top">
	      <table>
		      <tr>
		      	<td colspan="3" style="padding-top:-2px" valign="top"><input type="text" class="input40" value="<?=$DATA["KODE_KANTOR_PABEAN"]?>" /></td>
		      </tr>
		      <tr>
		      	<td>Tanggal Pengajuan</td>
		      	<td>:</td>
		      	<td><?=$this->fungsi->dateformat($DATA["TANGGAL_AJU"])?></td>
		      </tr>
		      <tr>
		      	<td>Tanggal Pendaftaran</td>
		      	<td>:</td>
		      	<td><?=$this->fungsi->dateformat($DATA['TANGGAL_PENDAFTARAN']);?></td>
		      </tr>
	      </table>
      </td>
    </tr>
    <tr>
      <td valign="top" colspan="2" class="border-t"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-top:-2px;padding-left:-2px">
          <tr>
            <td valign="top" class="border-r border-b">35. <br>No.</td>
            <td valign="top" class="border-r border-b">36. - Pos Tarif/HS<br>
                                    - Uraian Jenis Barang (termasuk spesifikasi wajib)<br>
                                    - Persentase Barang Impor<br>
                                    - Negara Asal Barang</td>
            <td valign="top" class="border-r border-b">37. Keterangan<br>
                                    - Fasilitas & No. Urut<br>
                                    - Persyaratan & No. Urut</td></td>
            <td valign="top" class="border-r border-b">38. Tarif dan Fasilitas</td>
            <td valign="top" class="border-r border-b">39. - Jumlah & Jenis satuan barang<br>
                                    - Berat Bersih (Kg)<br>
                                    - Jumlah & Jenis Kemasan </td>
            <td valign="top" class="border-b">40. - Nilai CIF<br>
                                    - Jenis Nilai<br>
                                    - Nilai yang ditambahkan&nbsp;&nbsp;&nbsp;<br>
                                    - Jatuh Tempo</td>
          </tr>
          <tr>
            <td valign="top" class="border-r" align="center" height="490pt">&nbsp;</td>
            <td valign="top" class="border-r" height="490pt">&nbsp;</td>
            <td valign="top" class="border-r" height="490pt">&nbsp;</td>
            <td valign="top" class="border-r" height="490pt">&nbsp;</td>
            <td valign="top" class="border-r" height="490pt">&nbsp;</td>
            <td valign="top" height="490pt">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td valign="top" class="border-t" colspan="2">
      	<table>
      		<tr>
      			<td colspan="3"><strong>IMPORTIR</strong></td>
      		</tr>
      		<tr>
      			<td>Tempat, Tanggal</td>
      			<td>:</td>
      			<td><?=$DATA['KOTA_TTD'];?>, <?=$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?></td>
      		</tr>
      		<tr>
      			<td>Nama Lengkap</td>
      			<td>:</td>
      			<td><?=$DATA['PEMBERITAHU'];?></td>
      		</tr>
      		<tr>
      			<td>Jabatan</td>
      			<td>:</td>
      			<td><?=$DATA['JABATAN'];?></td>
      		</tr>
      		<tr>
      			<td colspan="3">Tanda tangan dan stempel Perusahaan :</td>
      		</tr>
      	</table>
      </td>
    </tr>
  
  </table>
</div>

<!--DATANYA-->
<?php $no=$loop;?>
<div style="position: relative;margin-top:-67em">
  <table width="100%" cellpadding="2" cellspacing="0" border="0">
    <?php 
$looping = $loop;  
for($i=0;$i<count($BARANG);$i++){
?>
    <tr>
        <td valign="top" >&nbsp;&nbsp;<?=$no;?>&nbsp; </td>
	    <td valign="top" style="padding-left:7px" width="30%">- <?= $BARANG[$i]['KODE_HS']?> / Kode Barang = <?= $BARANG[$i]['KODE_BARANG']?><br>
	    - <?= $BARANG[$i]['URAIAN_BARANG']?>, Merk : <?= $BARANG[$i]['MERK']?>, Tipe : <?= $BARANG[$i]['TIPE']?>, UKURAN : <?= $BARANG[$i]['UKURAN']?><br>
	    - <?= $BARANG[$i]['JUMLAH_BARANG_IMPOR']?>%<br>
	    - <?= strtoupper($BARANG[$i]['URIAN_NEGARA'])?>
	    </td>
	    <td valign="top" style="padding-left:25px" width="20%">- <?= $BARANG[$i]['KODE_FASILITAS']?><br>
	    </td>
	    <td valign="top" width="15%">asas/a<!-- 38. Tarif dan Fasilitas --></td>
	    <td valign="top" width="25%">- <?= $BARANG[$i]['JUMLAH_SATUAN']?> <?= $BARANG[$i]['KODE_SATUAN']?> (<?= $BARANG[$i]['URAIAN_SATUAN']?>)<br>
	    - <?= $BARANG[$i]['NETTO']?> Kg<br>
	    - <?= $BARANG[$i]['JUMLAH_KEMASAN']?> <?= $BARANG[$i]['KODE_KEMASAN']?></td>
	    <td valign="top" width="18%">- <?php echo $this->fungsi->FormatRupiah($BARANG[$i]['CIF'],2)?><br>
	    - <?= $BARANG[$i]['JENIS_NILAI']?><br>
	    - <?php echo $this->fungsi->FormatRupiah($BARANG[$i]['NILAI_TAMBAHAN'],2)?><br>
	    - <?= $BARANG[$i]['TGL_JATUH_TEMPO']?></td>
    </tr>
    <?php  $looping++; $no++; if($looping%8==0) break; }?>
  </table>
</div>
</span>