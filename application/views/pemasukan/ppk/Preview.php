<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<span id="DivHeaderForm">
    <table width="100%" border="0">
        <tr>
            <td width="45%" valign="top">
                <table width="90%" border="0">
                    <tr>
                        <td class="social-list strong" width="35%">Kantor Pendaftaran</td>
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
                <table width="100%">
                	<tr>
                    	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="35%">Nomor Pendaftaran</td>
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
    <h5 class="header smaller lighter green"><b>IDENTITAS PENGUSAHA</b></h5>
    <table width="100%">
    	<tr>
        	<td width="45%" valign="top">
            	<table width="90%">
                	<tr>
                        <td colspan="2"><h5 class="smaller lighter red"><b>Pengusaha Pusat Logistik Berikat / PDPLB</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="35%">Identitas</td>
                        <td class="social-list"><?= $sess['UR_KODE_ID_PENGUSAHA']; ?> - <?=$sess["ID_PENGUSAHA"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama Perusahaan</td>
                        <td class="social-list"><?=$sess["NAMA_PENGUSAHA"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nomor Izin</td>
                        <td class="social-list"><?=$sess["NO_IZIN_PENGUSAHA"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Alamat</td>
                        <td class="social-list"><?=$sess["ALAMAT_PENGUSAHA"]?></td>
                    </tr>
                </table>
            </td>
            <td width="55%" valign="top">
            	<table width="100%">
                	<tr>
                        <td colspan="2"><h5 class="smaller lighter red"><b>Importir yang Mengembalikan Barang ke PLB</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="25%">Identitas</td>
                        <td class="social-list"><?= $sess['UR_KODE_ID_IMPORTIR']; ?> - <?=$sess["ID_IMPORTIR"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama Perusahaan</td>
                        <td class="social-list"><?=$sess["NAMA_IMPORTIR"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Alamat</td>
                        <td class="social-list"><?=$sess["ALAMAT_IMPORTIR"]?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <h5 class="header smaller lighter green"><b>PENANDATANGANAN</b></h5>
    <table width="100%">
    	<tr>
        	<td width="45%" valign="top">
            	<table width="90%">
                	<tr>
                    	<td colspan="2"><h5 class="smaller lighter blue"><b>Penanggungjawab</b></h5></td>
                    </tr>
                    <tr>
                    	<td class="social-list strong" width="35%">Kota</td>
                        <td class="social-list"><?=$sess["KOTA_PENANDATANGANAN"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal</td>
                        <td class="social-list"><?=$this->fungsi->FormatDateIndo($sess["TANGGAL_TTD"])?></td>
                    </tr>
                </table>
            </td>
            <td width="55%" valign="top">
            	<table width="100%">
                	<tr>
                    	<td colspan="2"><h5 class="smaller lighter blue"><b>Lembar Persetujuan Bea Cukai</b></h5></td>
                    </tr>
                    <tr>
            			<td class="social-list strong"  width="25%">Nama Petugas BC</td>
            			<td class="social-list"><?=$sess["NAMA_PETUGAS_BC"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">NIP Petugas BC</td>
                        <td class="social-list"><?=$sess["NIP_PETUGAS_BC"]?></td>
                    </tr>
                    <tr>
                    	<td colspan="2"><h5 class="smaller lighter blue"><b>Catatan : </b></h5>Selesai dipindahkan pada: </td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal & Waktu</td>
                        <td class="social-list"><?=$this->fungsi->FormatDateIndo($sess["TANGGAL_SELESAI"])." ".$sess["WAKTU_SELESAI"]?></td>
                    </tr>
                </table>
            </td>
        </tr>
   	</table>
    <table width="100%">
        <tr>
          <td colspan="4"><h4 class="header smaller lighter red"><b>Detil Dokumen</b></h4>
            <?=$DETILPRIVIEW;?></td>
        </tr>
   	</table>
</span> 