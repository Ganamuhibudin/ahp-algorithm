<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<table width="100%" border="0">
	<tr>
		<td width="50%" valign="top">
			<table width="90%" border="0">
            	<tr>
                	<td class="social-list strong">Nomor Aju</td>
                	<td class="social-list"><?=$this->fungsi->FormatAju($sess["NOMOR_AJU"]);?></td>
                </tr>
                <tr>
                	<td class="social-list strong">Tanggal Aju</td>
                	<td class="social-list"><?= ($sess['TANGGAL_AJU']=='0000-00-00' || $sess['TANGGAL_AJU']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_AJU'])); ?></td>
                </tr>
                <tr>
                	<td class="social-list strong">Kantor Pabean Pengawasan </td>
                	<td class="social-list"><?= $sess['KPBC_PENGAWAS']; ?> - <?= $sess['URAIAN_KPBC_AWAS']; ?></td>
                </tr>
                <tr>
                    <td width="40%" class="social-list strong">Kantor Pabean Pemuatan</td>
                    <td width="60%" class="social-list"><?=$sess['KPBC_MUAT']." - ".$sess["URAIAN_KPBC_MUAT"]?></combo>
                    </td>
                </tr>
                <tr>
                    <td class="social-list strong">Tempat Stuffing</td>
                    <td class="social-list"><?=$sess['LOKASI_STUFFING']?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Struffing</td>
                    <td class="social-list"><?=$sess['TANGGAL_STUFFING']?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Perkiraan Muat</td>
                    <td class="social-list"><?=$sess['TANGGAL_PERKIRAAN_MUAT']?></td>
                </tr>
			</table>
      	</td>
		<td width="50%" valign="top">
            <table width="90%">
            	<tr>
                	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                </tr>
                <tr>
                    <td width="40%" class="social-list strong">Nomor Pendaftaran</td>
                    <td width="50%" class="social-list"><?= $sess['NOMOR_PENDAFTARAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Pendaftaran</td>
                    <td class="social-list"><?= ($sess['TANGGAL_PENDAFTARAN']=='0000-00-00' || $sess['TANGGAL_PENDAFTARAN']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_PENDAFTARAN'])); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">No. Persetujuan Pengeluaran</td>
                    <td class="social-list"><?= $sess['NOMOR_DOK_PABEAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Persetujuan Pengeluaran</td>
                    <td class="social-list"><?= ($sess['TANGGL_DOK_PABEAN']=='0000-00-00' || $sess['TANGGL_DOK_PABEAN']=='')?' - ':date('d F Y', strtotime($sess['TANGGL_DOK_PABEAN'])); ?></td>
                </tr>
            </table>
		</td>
	</tr>
</table>
<h5 class="header smaller lighter green"><b>DATA PEMBERITAHUAN</b></h5>
<table width="100%" border="0">
    <tr>
        <td width="50%" valign="top">
            <table width="90%" border="0">
                <tr>
                	<td colspan="2"><h5 class="smaller lighter blue"><b>PENGUSAHA PLB/PDPLB</b></h5></td>
                </tr>
                <tr>
                    <td width="40%" class="social-list strong">Identitas</td>
                    <td width="60%" class="social-list"><?=$sess['UR_KODE_ID_TRADER']?> - <?php if($sess['KODE_ID_TRADER']==5){echo $this->fungsi->FORMATNPWP($sess['ID_TRADER']);}else{ echo $sess['ID_TRADER'];}?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_TRADER']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" valign="top">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_TRADER']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" ><h5 class="smaller lighter blue"><b>PENERIMA BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_PENERIMA']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_PENERIMA']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" ><h5 class="smaller lighter blue"><b>PEMILIK BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Identitas</td>
                    <td class="social-list"><?=$sess['UR_KODE_ID_PEMILIK']?> - <?php if($sess['KODE_ID_PEMILIK']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']);}else{ echo $sess['ID_PEMILIK'];}?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_PEMILIK']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_PEMILIK']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" ><h5 class="smaller lighter blue"><b>DATA SARANA PENGANGKUT</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Moda Trasportase</td>
                    <td class="social-list"><?=$sess['UR_MODA']?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama Sarana Angkut</td>
                    <td class="social-list"><?= $sess['NAMA_ANGKUT']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">No Voy/Fligt</td>
                    <td class="social-list"><?= $sess['NOMOR_ANGKUT']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">Call Sign</td>
                    <td class="social-list"><?= $sess['CALL_SIGN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">Negara Tujuan</td>
                    <td class="social-list"><?= $sess['NEGARA_TUJUAN']." - ".$sess["URAIAN_NEGARA_TUJUAN"]; ?></td>
                </tr>
            </table>
		</td>
		<td width="50%" valign="top">
			<table width="100%" border="0">
                <tr>
                    <td colspan="2"><h5 class="smaller lighter blue"><b>DATA PELABUHAN</b></h5></td>
                </tr>
                <tr>
                    <td width="40%" class="social-list strong">Muat </td>
                    <td width="60%" class="social-list"><?= $sess['KODE_PEL_MUAT']?> - <?= $sess['UR_PELABUHAN_MUAT'] ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Bongkar </td>
                    <td class="social-list"><?= $sess['KODE_PEL_BONGKAR']?> - <?= $sess['UR_PELABUHAN_BONGKAR'] ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tujuan </td>
                    <td class="social-list"><?= $sess['KODE_PEL_TUJUAN']?> - <?= $sess['UR_PELABUHAN_TUJUAN'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><h5 class="smaller lighter blue"><b>INFORMASI LAIN</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nomor BC 1.1</td>
                    <td class="social-list"><?= $sess['NOMOR_BC11'] ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal BC 1.1</td>
                    <td class="social-list"><?= $sess['TANGGAL_BC11']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nomor Pos</td>
                    <td class="social-list"><?= $sess['NOMOR_POS']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nomor Sub Pos</td>
                    <td class="social-list"><?= $sess['NOMOR_SUB_POS']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Bruto </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'],2); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jumlah Tanda Pengaman</td>
                    <td class="social-list"><?= $sess['JUMLAH_TANDA_PENGAMAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis Tanda Pengaman</td>
                    <td class="social-list"><?= $sess['JENIS_TANDA_PENGAMAN']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><h5 class="smaller lighter blue"><b>PENANDATANGANAN</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['PEMBERITAHU']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jabatan</td>
                    <td class="social-list"><?= $sess['JABATAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tempat</td>
                    <td class="social-list"><?= $sess['KOTA_TTD']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal</td>
                    <td class="social-list"><?=$sess['TANGGAL_TTD']; ?></td>
                </tr>
            </table>
		</td>
	</tr>
</table>
<?php  
if($priview){
	echo '<h4 class="header smaller lighter green"><i class="icon-list"></i>&nbsp;<b>Detil Dokumen</b></h4>'.$DETILPRIVIEW;
} 