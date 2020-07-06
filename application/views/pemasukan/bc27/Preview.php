<?php
    if (!defined('BASEPATH'))  exit('No direct script access allowed');
    error_reporting(E_ERROR);
    if ($act == 'update')  $readonly = "readonly=readonly";
    else $readonly = "";

    if ($this->uri->segment(1) == 'pemasukan') $tipe_dok_bc27 = "MASUK";
    elseif ($this->uri->segment(1) == 'pengeluaran') $tipe_dok_bc27 = "KELUAR";
	elseif ($this->uri->segment(1) == 'tools') $tipe_dok_bc27 = $sess["TIPE_DOK"];

    if ($act == "save" && $this->uri->segment(1) == 'pengeluaran') {
        $sess['KODE_ID_TRADER_TUJUAN'] = $partner["KODE_ID_PARTNER"];
        $sess['ID_TRADER_TUJUAN'] = $partner["ID_PARTNER"];
        $sess['NAMA_TRADER_TUJUAN'] = $partner["NAMA_PARTNER"];
        $sess['ALAMAT_TRADER_TUJUAN'] = $partner["ALAMAT_PARTNER"];
    }
?>
<table width="100%" border="0">
    <tr>
        <td width="45%" valign="top">				
            <table width="90%" border="0">
                <tr>
                    <td colspan="2"><h5 class="header smaller lighter green"><b>KANTOR PABEAN</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong" width="35%">Nomor Aju</td>
                    <td class="social-list"><?= $this->fungsi->FormatAju($aju); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Kantor Asal</td>
                    <td class="social-list"><?= $sess['KODE_KPBC_ASAL']; ?> - <?= $sess['URAIAN_KPBC'] == '' ? $URKANTOR_TUJUAN : $sess['URAIAN_KPBC']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Kantor Tujuan</td>
                    <td class="social-list"><?= $sess['KODE_KPBC_TUJUAN']; ?> - <?= $sess['URAIAN_KPBC_BONGKAR'] == '' ? $URKANTOR_TUJUAN : $sess['URAIAN_KPBC_BONGKAR']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis TPB ASAL</td>
                    <td class="social-list"><?= $sess['JENIS_TPB_ASAL'] ?> - <?=$sess["UR_JENIS_TPB_ASAL"]?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis TPB TUJUAN</td>
                    <td class="social-list"><?= $sess['JENIS_TPB_TUJUAN'] ?> - <?=$sess["UR_JENIS_TPB_TUJUAN"]?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tujuan Pengiriman</td>
                    <td class="social-list"><?= $sess['TUJUAN_KIRIM'] ?> - <?=$sess["UR_TUJUAN_KIRIM"]?></td>
                </tr>
            </table>
        </td>
        <td width="55%" valign="top">
            <table width="90%">
            	<tr>
                	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong" style="width:45%;">Nomor Pendaftaran</td>
                    <td class="social-list"><?php  echo $sess['NOMOR_PENDAFTARAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Pendaftaran</td>
                    <td class="social-list"><?php if ($sess['TANGGAL_PENDAFTARAN']) echo date('d F Y',strtotime($sess['TANGGAL_PENDAFTARAN'])); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">No. Persetujuan Pemasukan</td>
                    <td class="social-list"><?php  echo $sess['NOMOR_DOK_PABEAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Persetujuan Pemasukan</td>
                    <td class="social-list"><?php if($sess['TANGGAL_DOK_PABEAN']) echo date('d F Y',strtotime($sess['TANGGAL_DOK_PABEAN'])); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<h5 class="header smaller lighter green"><b>DATA PEMBERITAHUAN</b></h5>
<table width="100%" border="0">
    <tr>
        <td width="45%" valign="top">		
            <table width="90%" border="0">
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>TPB ASAL BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong" width="35%">Identitas</td>
                    <td class="social-list"><?=$sess["UR_KODE_ID_TRADER_ASAL"]?> - <?= $sess['ID_TRADER_ASAL']; ?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama </td>
                    <td class="social-list"><?= $sess['NAMA_TRADER_ASAL']; ?></td>
                </tr>
                <tr>
                    <td valign="top" class="social-list strong">Alamat </td>
                    <td class="social-list"><?= $sess['ALAMAT_TRADER_ASAL']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">No Ijin TPB </td>
                    <td class="social-list">
						<?php 
							if ($this->uri->segment(1) == 'pemasukan') {
                            	echo $sess['NOMOR_IZIN_TPB_ASAL'];
                        	} else {
                            	echo $sess['NOMOR_IZIN_TPB_ASAL'] ? $sess['NOMOR_IZIN_TPB_ASAL'] : $sess['NOMOR_SKEP'];
                        	} 
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>RIWAYAT BARANG</b></h5></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $dataasal; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGANGKUT</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list  strong">Jenis Angkutan Darat </td>
                    <td class="social-list"><?= $sess['JENIS_SARANA_ANGKUT']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nomor Polisi </td>
                    <td class="social-list"><?= $sess['NOMOR_POLISI']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Volume (m3) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['VOLUME'], 4); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Berat Kotor (Kg) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'], 4); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Berat Bersih (Kg) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'], 2); ?>&nbsp; Kilogram (KGM)</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="social-list">Otomatis terisi dari jumlah total Netto Detil Barang</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td width="55%" valign="top">
            <table width="90%" border="0"> 
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>TPB TUJUAN BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong" width="35%">Identitas</td>
                    <td class="social-list"><?=$sess["UR_KODE_ID_TRADER_TUJUAN"]?> - 
						<?php 
							if ($sess['KODE_ID_TRADER_TUJUAN'] == 5) {
                                echo $this->fungsi->FORMATNPWP($sess['ID_TRADER_TUJUAN']);
                            } else {
                            	echo $sess['ID_TRADER_TUJUAN'];
                            }
						?>
                    </td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_TRADER_TUJUAN']; ?></td>
                </tr>
                <tr>
                    <td valign="top" class="social-list strong">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_TRADER_TUJUAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">No Izin TPB</td>
                    <td class="social-list">
						<?php 
							if ($this->uri->segment(1) == 'pemasukan') {
								echo $sess['NOMOR_IZIN_TPB_TUJUAN'] ? $sess['NOMOR_IZIN_TPB_TUJUAN'] : $sess['NOMOR_SKEP'];
							} else {
								echo $sess['NOMOR_IZIN_TPB_TUJUAN'];
							} 
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis Valuta Asing </td>
                    <td class="social-list"><?= $sess['KODE_VALUTA']; ?> - <?= $sess['URAIAN_VALUTA'] == '' ? $URAIAN_VALUTA : $sess['URAIAN_VALUTA']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">CIF <span id="cifkurs"><?= $sess['KODE_VALUTA'] == '' ? '' : '(' . $sess['KODE_VALUTA'] . ')'; ?></span></td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['CIF']); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Harga Penyerahan (Rp) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN']); ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>SEGEL</b><i class="red"> (Diisi Oleh Bea dan Cukai)</i></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">No. Segel</td>
                    <td class="social-list"><?= $sess['NOMOR_SEGEL_BC']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis</td>
                    <td class="social-list"><?= $sess['JENIS_SEGEL_BC'] ?> - <?=$sess["UR_JENIS_SEGEL_BC"]?></td>
                </tr>
                <tr>
                    <td valign="top" class="social-list strong">Catatan BC Tujuan</td>
                    <td class="social-list"><?= $sess['CATATAN_BC_TUJUAN']; ?></td>
                </tr>

            </table>
        </td> 
    <tr>
        <td colspan="2">
            <h5 class="header smaller lighter green"><b>TANDA TANGAN PENGUSAHA TPB</b></h5>		
            <table width="100%" border="0">
                <tr>
                    <td class="social-list strong" width="14%">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_TTD']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tempat</td>
                    <td class="social-list"><?= $sess['KOTA_TTD']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal</td>
                    <td class="social-list"><?php if ($act == "save") echo date("d F Y");else echo date('d F Y',strtotime($sess['TANGGAL_TTD']));?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h5 class="header smaller lighter green"><b>UNTUK BEA DAN CUKAI</b></h5>
            <table width="100%" border="0">
                <tr>
                    <td width="45%" valign="top">		
                        <table width="90%" border="0">
                            <tr>
                                <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>Kantor Pabean Asal</b></h5></td>
                            </tr>
                            <tr>
                                <td class="social-list strong" width="35%">Nama</td>
                                <td class="social-list"><?= $sess['NAMA_PEJABAT_BC_ASAL']; ?></td>
                            </tr>
                            <tr>
                                <td class="social-list strong">NIP</td>
                                <td class="social-list"><?= $sess['NIP_PEJABAT_BC_ASAL']; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td width="55%" valign="top">		
                        <table width="90%" border="0">
                            <tr>
                                <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>Kantor Pabean Tujuan</b></h5></td>
                            </tr>
                            <tr>
                                <td class="social-list strong" width="35%">Nama</td>
                                <td class="social-list"><?= $sess['NAMA_PEJABAT_BC_TUJUAN']; ?></td>
                            </tr>
                            <tr>
                                <td class="social-list strong">NIP</td>
                                <td class="social-list"><?= $sess['NIP_PEJABAT_BC_TUJUAN']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><h4 class="header smaller lighter green"><b>Detil Dokumen</b></h4>
        <?=$DETILPRIVIEW;?></td>
    </tr>
</table>



























<!--<table width="100%">
	<tr>
    	<td width="50%">
        	<ul class="list-unstyled social-list">
                <li><i class="fa fa-twitter"></i> <a href="#">twitter.com/eileensideways</a></li>
                <li><i class="fa fa-facebook"></i> <a href="#">facebook.com/eileen</a></li>
                <li><i class="fa fa-youtube"></i> <a href="#">youtube.com/eileen22</a></li>
                <li><i class="fa fa-linkedin"></i> <a href="#">linkedin.com/4ever-eileen</a></li>
                <li><i class="fa fa-pinterest"></i> <a href="#">pinterest.com/eileen</a></li>
                <li><i class="fa fa-instagram"></i> <a href="#">instagram.com/eiside</a></li>
            </ul>
        </td>
        <td width="50%">
        	<ul class="list-unstyled social-list">
                <li><i class="fa fa-twitter"></i> <a href="#">twitter.com/eileensideways</a></li>
                <li><i class="fa fa-facebook"></i> <a href="#">facebook.com/eileen</a></li>
                <li><i class="fa fa-youtube"></i> <a href="#">youtube.com/eileen22</a></li>
                <li><i class="fa fa-linkedin"></i> <a href="#">linkedin.com/4ever-eileen</a></li>
                <li><i class="fa fa-pinterest"></i> <a href="#">pinterest.com/eileen</a></li>
                <li><i class="fa fa-instagram"></i> <a href="#">instagram.com/eiside</a></li>
            </ul>
        </td>
    </tr>
</table>-->