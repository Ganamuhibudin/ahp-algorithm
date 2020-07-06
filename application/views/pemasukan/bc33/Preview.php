<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<span id="DivHeaderForm">
    <table width="100%" border="0">
        <tr>
            <td width="45%" valign="top">
                <table width="100%" border="0">
                	<tr>
                    	<td class="social-list">Nomor Aju</td>
                        <td class="social-list"><?=$sess["NOMOR_AJU"]?></td>
                    </tr>
                    <tr>
                        <td width="28%" class="social-list">Kantor Pengawasan</td>
                        <td width="71%" class="social-list"><?= $sess['KODE_KPBC_AWAS']; ?> - <?= $sess['URAIAN_KPBC_AWAS']; ?></td>
                    </tr>
                    <tr>
                        <td width="28%" class="social-list">Kantor Pemuatan</td>
                        <td width="71%" class="social-list"><?= $sess['KODE_KPBC_MUAT']; ?> - <?= $sess['URAIAN_KPBC_MUAT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Jenis Ekspor</td>
                        <td class="social-list"><?= $sess['JENIS_EKSPOR'] ?> - <?=$sess["UR_JENIS_EKSPOR"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Kategori Ekspor</td>
                        <td class="social-list"><?= $sess['KATEGORI_EKSPOR'] ?> - <?=$sess["UR_KATEGORI_EKSPOR_BC33"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Cara Perdagangan</td>
                        <td class="social-list"><?= $sess['CARA_DAGANG']?> - <?=$sess["UR_CARA_DAGANG"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Cara Pembayaran</td>
                        <td class="social-list"><?= $sess['CARA_BAYAR'] ?> - <?=$sess["UR_CARA_BAYAR"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Jenis BC 3.3</td>
                        <td class="social-list"><?= $sess['JENIS_BC33']." - ".$sess["UR_JENIS_BC33"]; ?></td>
                    </tr>
                </table>
            </td>
            <td width="55%" valign="top">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" valign="top">
                            <h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5>
                            <table width="80%">
                                <tr>
                                    <td class="social-list" width="45%">Nomor Pendaftaran</td>
                                    <td class="social-list"><?php $sess['NOMOR_PENDAFTARAN'];?></td>
                                </tr>
                                <tr>
                                    <td class="social-list">Tanggal Pendaftaran</td>
                                    <td class="social-list">
										<?php 
                                            if ($sess['TANGGAL_PENDAFTARAN']) {
                                                echo date('d F Y',strtotime($sess['TANGGAL_PENDAFTARAN']));
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="social-list">No. Persetujuan Pemasukan</td>
                                    <td class="social-list"><?php $sess['NOMOR_DOK_PABEAN'];?></td>
                                </tr>
                                <tr>
                                    <td class="social-list">Tanggal Persetujuan Pemasukan</td>
                                    <td class="social-list"><?php if ($sess['TANGGAL_DOK_PABEAN']) {
											echo date('d F Y',strtotime($sess['TANGGAL_DOK_PABEAN']));
                                    	}?></td>
                                </tr>
                            </table>
                        </td>
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
                        <td colspan="3" class="rowheight">
                        <h5 class="smaller lighter blue"><b>EKSPORTIR TPB</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" class="social-list">Identitas </td>
                        <td width="60%" class="social-list"><?=$sess["UR_KODE_ID_TRADER"]?> - <?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Nama </td>
                        <td class="social-list"><?= $sess['NAMA_TRADER']; ?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="social-list">Alamat </td>
                        <td class="social-list"><?= $sess['ALAMAT_TRADER']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">NIPER </td>
                        <td class="social-list"><?= $sess['NIPER']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Status </td>
                        <td class="social-list"><?= $sess['STATUS_TRADER']?> - <?=$sess["UR_STATUS_TRADER"]?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                        <h5 class="smaller lighter blue"><b>PEMILIK BARANG</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="28%" class="social-list">Identitas </td>
                        <td width="71%" class="social-list"><?=$sess["UR_KODE_ID_PEMILIK"]?> - <?= $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Nama </td>
                        <td class="social-list"><?= $sess['NAMA_PEMILIK']; ?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="social-list">Alamat </td>
                        <td class="social-list"><?= $sess['ALAMAT_PEMILIK']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">NIPER </td>
                        <td class="social-list"><?= $sess['NIPER_PEMILIK']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Status </td>
                        <td class="social-list"><?= $sess['STATUS_PEMILIK']?> - <?=$sess["UR_STATUS_PEMILIK"]?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>DATA PENERIMA</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td class="social-list">Nama</td>
                        <td class="social-list"><?= $sess['NAMA_PENERIMA']; ?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="social-list">Alamat</td>
                        <td class="social-list"><?= $sess['ALAMAT_PENERIMA']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Negara</td>
                        <td class="social-list"><?= $sess['NEGARA_PENERIMA']; ?> - <?= $sess['URAIAN_BENDERA'] == '' ? $URAIAN_BENDERA : $sess['URAIAN_BENDERA']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>DATA PEMBELI</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td class="social-list">Nama</td>
                        <td class="social-list"><?= $sess['NAMA_PEMBELI']; ?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="social-list">Alamat</td>
                        <td class="social-list"><?= $sess['ALAMAT_PEMBELI']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Negara</td>
                        <td class="social-list"><?= $sess['NEGARA_PEMBELI']; ?> - <?= $sess['URAIAN_BENDERA_PEMBELI'] == '' ? $URAIAN_BENDERA : $sess['URAIAN_BENDERA_PEMBELI']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>DATA PENGANGKUTAN</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td class="social-list">Cara Pengangkutan</td>
                        <td class="social-list"><?= $sess['MODA']." - ".$sess["UR_MODA"] ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Nama Angkut </td>
                        <td class="social-list"><?= $sess['NAMA_ANGKUT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Nomor Pengangkut </td>
                        <td class="social-list"><?= $sess['NOMOR_ANGKUT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Tanggal Perkiraan Muat</td>
                        <td class="social-list"><?= date('d F Y',strtotime($sess['TANGGAL_EKSPOR'])); ?></td>
                    </tr>
                </table>
            </td>
            <td width="55%" valign="top">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>DATA TRANSAKSI EKSPOR</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Bank Devisa Hasil Ekspor</td>
                        <td class="social-list"><?= $sess['KODE_BANK']; ?> - <?= $sess['URAIAN_BANK']?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Jenis Valuta Asing</td>
                        <td class="social-list"><?= $sess['KODE_VALUTA']; ?> - <?= $sess['URAIAN_VALUTA'] == '' ? $urvaluta : $sess['URAIAN_VALUTA']; ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Nilai Kurs</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NDPBM'], 4); ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Nilai Barang</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NILAI_BARANG'], 4); ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">FOB</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['FOB'], 4); ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Nilai Maklon</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NILAI_MAKLON'], 4); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>DATA BARANG</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Berat Kotor (Kg) </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'], 4); ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Berat Bersih (Kg) </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NETTO'], 4); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>PUSAT LOGISTIK BERIKAT</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Nama PLB</td>
                        <td class="social-list"><?= $sess['NAMA_PLB']; ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Lokasi / Kode Lokasi</td>
                        <td class="social-list"><?= $sess['KODE_LOKASI_PLB']; ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Cara Pengangkutan ke PLB</td>
                        <td class="social-list"><?= $sess['CARA_ANGKUT_PLB']; ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Perkiraan Tanggan IN/OUT</td>
                        <td class="social-list"><?= $sess['PERKIRAAN_INOUT_PLB']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>DATA PENYERAHAN</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Daerah Asal Barang</td>
                        <td class="social-list"><?= $sess['PROPINSI_BARANG']; ?> - <?= $sess['URAIAN_DAERAH_ASL'] == '' ? $URAIAN_DAERAH : $sess['URAIAN_DAERAH_ASL']; ?></td>
                    </tr>
                    <tr>
                        <td width="139" class="social-list">Cara Penyerahan Barang</td>
                        <td class="social-list"><?= $sess['CARA_PENYERAHAN_BARANG']." - ".$sess["UR_CARA_PENYERAHAN_BARANG"]?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>DATA PELABUHAN</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td width="26%" class="social-list">Pelabuhan Muat</td>
                        <td width="74%" class="social-list"><?= $sess['PELABUHAN_MUAT']; ?> - <?= $sess['URAIAN_MUAT'] == '' ? $urpelabuhan_muat : $sess['URAIAN_MUAT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Pelabuhan Bongkar</td>
                        <td class="social-list"><?= $sess['PELABUHAN_BONGKAR']; ?> - <?= $sess['URAIAN_BONGKAR'] == '' ? $urpelabuhan_muat_eks : $sess['URAIAN_BONGKAR']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Pelabuhan Tujuan</td>
                        <td class="social-list"><?= $sess['PELABUHAN_TUJUAN']; ?> - <?= $sess['URAIAN_TUJUAN'] == '' ? $urpelabuhan_bongkar : $sess['URAIAN_TUJUAN']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight">
                        <h5 class="smaller lighter blue"><b>TANDA TANGAN PENGUSAHA EKSPORTIR</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td class="social-list">Nama</td>
                        <td class="social-list"><?= $sess['NAMA_TTD']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Tempat</td>
                        <td class="social-list"><?= $sess['KOTA_TTD']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list">Tanggal</td>
                        <td class="social-list"><?= $sess['TANGGAL_TTD'] ? date('d F Y',strtotime($sess['TANGGAL_TTD'])) : date('d F Y'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
</span>
<?php
if ($priview) {
echo '<h4 class="header smaller lighter green"><b>Detil Dokumen</b></h4>'.$DETILPRIVIEW;
}
?>

