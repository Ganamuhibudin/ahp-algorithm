<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<span id="DivHeaderForm">
    <table width="100%" border="0">
        <tr>
            <td width="45%" valign="top">
                <table width="90%" border="0">
                    <tr>
                        <td class="social-list strong">Kantor Pendaftaran</td>
                        <td class="social-list"><?= $sess['KODE_KPBC_PENDAFTARAN']; ?> - <?= $sess['UR_KPBC_PENDAFTARAN']==''?$URKANTOR_TUJUAN:$sess['UR_KPBC_PENDAFTARAN']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nomor Aju </td>
                        <td class="social-list"><?= $this->fungsi->FormatAju($aju); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal Aju</td>
                        <td class="social-list"><?= ($sess['TANGGAL_AJU']=='0000-00-00' || $sess['TANGGAL_AJU']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_AJU'])); ?></td>
                    </tr>
                </table>
            <td width="55%" valign="top">
                <table width="90%">
                	<tr>
                    	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="40%">Nomor Pendaftaran</td>
                        <td class="social-list"><?= $sess['NOMOR_PENDAFTARAN']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal Pendaftaran</td>
                        <td class="social-list"><?= ($sess['TANGGAL_PENDAFTARAN']=='0000-00-00' || $sess['TANGGAL_PENDAFTARAN']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_PENDAFTARAN'])); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <h5 class="header smaller lighter green"><b>IDENTITAS PENGUSAHA PUSAT LOGISTIK BERIKAT/ PDPLB</b></h5>
    <table width="100%">
    	<tr>
        	<td class="social-list strong" width="14%">Identitas</td>
            <td class="social-list"><?= $sess['UR_KODE_ID_TRADER']; ?> - <?=$sess["ID_TRADER"]?></td>
        </tr>
    	<tr>
        	<td class="social-list strong">Nama Perusahaan</td>
            <td class="social-list"><?=$sess["NAMA_TRADER"]?></td>
        </tr>
    	<tr>
        	<td class="social-list strong">Nomor Izin</td>
            <td class="social-list"><?=$sess["REGISTRASI"]?></td>
        </tr>
    	<tr>
        	<td class="social-list strong">Alamat</td>
            <td class="social-list"><?=$sess["ALAMAT_TRADER"]?></td>
        </tr>
    </table>
    <h5 class="header smaller lighter green"><b>ASAL LOKASI BARANG DAN TUJUAN PEMINDAHAN BARANG</b></h5>
    <table width="100%">
        <tr>
            <td class="social-list strong" width="14%">Kantor Asal Barang</td>
            <td class="social-list"><?=$sess["KODE_KPBC_ASAL"]?> - <?=$sess["UR_KODE_KPBC_ASAL"]?></td>
            <td class="social-list strong" width="14%">Kantor Tujuan Barang</td>
            <td class="social-list"><?=$sess["KODE_KPBC_TUJUAN"]?> - <?=$sess["UR_KODE_KPBC_TUJUAN"]?></td>
        </tr>
        <tr>
            <td class="social-list strong" width="14%">Lokasi Asal Barang</td>
            <td class="social-list"><?=$sess["LOKASI_ASAL_BARANG"]?></td>
            <td class="social-list strong" width="14%">Lokasi Tujuan Barang</td>
            <td class="social-list"><?=$sess["LOKASI_TUJUAN_BARANG"]?></td>
        </tr>
   	</table>
    <h5 class="header smaller lighter green"><b>PENANDATANGANAN</b></h5>
    <table width="100%">
    	<tr>
        	<td colspan="2" width="46%"><h5 class="smaller lighter blue"><b>Penanggungjawab</b></h5></td>
        	<td colspan="2" width="50%"><h5 class="smaller lighter blue"><b>Lembar Persetujuan Bea Cukai</b></h5></td>
        </tr>
        <tr>
            <td class="social-list strong" width="14%">Kota</td>
            <td class="social-list"><?=$sess["KOTA_TTD"]?></td>
            <td class="social-list strong" width="14%">Nama Petugas BC</td>
            <td class="social-list"><?=$sess["NAMA_PETUGAS_BC"]?></td>
        </tr>
        <tr>
            <td class="social-list strong" width="14%">Tanggal</td>
            <td class="social-list"><?=$sess["TANGGAL_TTD"]?></td>
            <td class="social-list strong" width="14%">NIP Petugas BC</td>
            <td class="social-list"><?=$sess["NIP_PETUGAS_BC"]?></td>
        </tr>
        <tr>
            <td width="14%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="14%"><h5 class="smaller lighter blue"><b>Catatan</b></h5>
        </tr>
        <tr>
            <td width="14%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="14%" class="social-list strong">Selesai dipindahkan pada tanggal : </h5>
            <td class="social-list"><?=$sess["TANGGAL_SELESAI"]?><br><?=$sess["WAKTU_SELESAI"]?></td>
        </tr>
        <tr>
          <td colspan="4"><h4 class="header smaller lighter red"><b>Detil Dokumen</b></h4>
            <?=$DETILPRIVIEW;?></td>
        </tr>
   	</table>
</span> 