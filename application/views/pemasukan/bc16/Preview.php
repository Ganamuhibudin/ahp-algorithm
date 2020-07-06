<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<span id="DivHeaderForm">
    <table width="100%" border="0">
        <tr>
            <td width="50%" valign="top">
                <table width="90%" border="0">
                    <tr>
                        <td class="social-list strong">Nomor Aju</td>
                        <td class="social-list"><?= $this->fungsi->FormatAju($aju); ?></td>
                    </tr>
                    <tr>
                        <td width="30%" class="social-list strong">Tanggal Aju</td>
                        <td width="69%" class="social-list"><?= ($sess['TANGGAL_AJU']=='0000-00-00' || $sess['TANGGAL_AJU']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_AJU'])); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">KPBC Bongkar </td>
                        <td class="social-list"><?= $sess['KODE_KPBC_BONGKAR']; ?> - <?= $sess['URAIAN_KPBC_BONGKAR']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KPBC_BONGKAR']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">KPBC Pengawas </td>
                        <td class="social-list"><?= $sess['KODE_KPBC_AWAS']; ?> - <?= $sess['URAIAN_KPBC_AWAS']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KPBC_AWAS']; ?></td>
                    </tr>
                </table>
            <td width="50%" valign="top">
                <table width="100%">
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
                    <tr>
                        <td class="social-list strong">No. Persetujuan Pemasukan</td>
                        <td class="social-list"><?= $sess['NOMOR_DOK_PABEAN']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal Persetujuan Pemasukan</td>
                        <td class="social-list"><?= ($sess['TANGGAL_DOK_PABEAN']=='0000-00-00' || $sess['TANGGAL_DOK_PABEAN']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_DOK_PABEAN'])); ?></td>
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
                	
                    <!-- START TR PENGIRIM -->
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGIRIM</b></h5></td>
                    </tr>
                    <tr>
                        <td width="29%" class="social-list strong">Nama </td>
                        <td width="69%" class="social-list"><?= $sess['NAMA_PENGIRIM']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" valign="top">Alamat </td>
                        <td class="social-list"><?= $sess['ALAMAT_PENGIRIM']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Negara </td>
                        <td class="social-list"><?=$sess["NEGARA_PENGIRIM"]?> - <?= $sess['URAIAN_NEGARA_PENGIRIM']==''?$URAIAN_NEGARA:$sess['URAIAN_NEGARA_PENGIRIM']; ?></td>
                    </tr>
                    <!-- END TR PENGIRIM -->
                    
                    <!-- START TR PENJUAL -->
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENJUAL</b></h5></td>
                    </tr>
                    <tr>
                        <td width="29%" class="social-list strong">Nama </td>
                        <td width="69%" class="social-list"><?= $sess['NAMA_PENJUAL']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" valign="top">Alamat </td>
                        <td class="social-list"><?= $sess['ALAMAT_PENJUAL']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Negara </td>
                        <td class="social-list"><?=$sess["NEGARA_PENJUAL"]?> - <?= $sess['UR_NEGARA_PENJUAL']==''?$URAIAN_NEGARA:$sess['UR_NEGARA_PENJUAL']; ?></td>
                    </tr>
                    <!-- END TR PENJUAL -->
                    
                    <!-- START TR PENGUSAHA PLB/PDPLB -->
                    <tr>
                        <td colspan="3" class="rowheight"  style="line-height:30px"><h5 class="smaller lighter blue"><b>DATA PENGUSAHA PLB/PDPLB</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Identitas</td>
                        <td class="social-list"><?= $sess['UR_KODE_ID_TRADER'] ?> - <?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?></td>
                    </tr> 
                    <tr>
                        <td class="social-list strong">Nama</td>
                        <td class="social-list"><?= $sess['NAMA_TRADER']; ?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top" class="social-list strong">Alamat</td>
                        <td class="social-list"><?= $sess['ALAMAT_TRADER']; ?></td>
                    </tr>
                    <!-- END TR PENGUSAHA PLB/PDPLB -->
                    
                    <!-- START TR PEMILIK -->
                    <tr>
                        <td colspan="3" class="rowheight"  style="line-height:30px"><h5 class="smaller lighter blue"><b>DATA PEMILIK</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Identitas</td>
                        <td class="social-list"><?= $sess['UR_KODE_ID_PEMILIK'] ?> - <?= $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']); ?></td>
                    </tr> 
                    <tr>
                        <td class="social-list strong">Nama</td>
                        <td class="social-list"><?= $sess['NAMA_PEMILIK']; ?></td>
                    </tr>
                    
                    <tr>
                        <td valign="top" class="social-list strong">Alamat</td>
                        <td class="social-list"><?= $sess['ALAMAT_PEMILIK']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Negara </td>
                        <td class="social-list"><?=$sess["NEGARA_PEMILIK"]?> - <?= $sess['URAIAN_NEGARA_PEMILIK']==''?$URAIAN_NEGARA:$sess['URAIAN_NEGARA_PEMILIK']; ?></td>
                    </tr>
                    <!-- END TR PEMILIK -->
                    
                    <!-- STATRT TR DATA SARANA ANGKUT -->
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA SARANA ANGKUT</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Moda Transportasi</td>
                        <td class="social-list"><?= $sess['MODA']." - ".$sess["UR_MODA"] ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama Sarana Angkut </td>
                        <td class="social-list"><?= $sess['NAMA_ANGKUT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">No. Voy/Flight </td>
                        <td class="social-list"><?= $sess['NOMOR_ANGKUT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Bendera</td>
                        <td class="social-list"><?= $sess['BENDERA']; ?> - <?= $sess['URAIAN_BENDERA']==''?$URAIAN_NEGARA:$sess['URAIAN_BENDERA']; ?></td>
                    </tr>
                    <!-- END TR DATA SARANA ANGKUT -->
                </table>
            </td>
            <td width="50%" valign="top">
                <table width="100%" border="0">
                     
                	<!-- STATRT TR DATA PELABUHAN -->           
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PELABUHAN</b></h5></td>
                    </tr>
                    <tr>
                        <td width="29%" class="social-list strong">Muat </td>
                        <td width="69%" class="social-list"><?= $sess['PELABUHAN_MUAT']; ?> - <?= $sess['URAIAN_MUAT']==''?$urpelabuhan_muat:$sess['URAIAN_MUAT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Transit</td>
                        <td class="social-list"><?= $sess['PELABUHAN_TRANSIT']; ?> - <?= $sess['URAIAN_TRANSIT']==''?$urpelabuhan_transit:$sess['URAIAN_TRANSIT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Bongkar </td>
                        <td class="social-list"><?= $sess['PELABUHAN_BONGKAR']; ?> - <?= $sess['URAIAN_BONGKAR']==''?$urpelabuhan_bongkar:$sess['URAIAN_BONGKAR']; ?></td>
                    </tr>
                    <!-- END TR DATA PELABUHAN -->
                    
                    <tr>
                         <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>INFORMASI LAIN</b></h5></td>
                    </tr>
                    <tr>
                        <td width="117" class="social-list strong">Perkiraan Tanggal Tiba</td>
                        <td width="435" class="social-list"><?= ($sess['PERKIRAAN_TGL_TIBA']=='0000-00-00' || $sess['PERKIRAAN_TGL_TIBA']=='')?' - ':date('d F Y', strtotime($sess['PERKIRAAN_TGL_TIBA'])); ?></td>
                    </tr>
                    <tr>
                        <td width="117" class="social-list strong">Penutup</td>
                        <td width="435" class="social-list"><?= $sess['KODE_PENUTUP']." - ".$sess["UR_KODE_PENUTUP"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nomor&nbsp;</td>
                        <td class="social-list"><?= $sess['NOMOR_PENUTUP']?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal&nbsp;</td>
                        <td class="social-list"><?= date('d F Y',strtotime($sess['TANGGAL_PENUTUP']))?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nomor Pos&nbsp;</td>
                        <td class="social-list"><?= $sess['NOMOR_POS']?>&nbsp;<span class="strong">Subpos/Sub-subpos : </span><?= $sess['SUB_POS']?>&nbsp;/&nbsp;<?= $sess['SUB_SUB_POS']?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tempat Timbun </td>
                        <td class="social-list"><?= $sess['KODE_TIMBUN']; ?><?= $sess['URAIAN_TIMBUN']==''?$urtempat_timbun:$sess['URAIAN_TIMBUN']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Valuta </td>
                        <td class="social-list"><?= $sess['KODE_VALUTA']; ?> - <?= $sess['URAIAN_VALUTA']==''?$urvaluta:$sess['URAIAN_VALUTA']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Kode Harga </td>
                        <td class="social-list"><?= $sess['UR_KODE_HARGA']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Jenis Nilai </td>
                        <td class="social-list"><?= $sess['JENIS_NILAI']; ?> - <?=$sess["UR_JENIS_NILAI"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nilai </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NILAI'],2); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Bruto </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'],2); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Netto</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'],4); ?>&nbsp; Kilogram (KGM)</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="social-list">Otomatis terisi dari jumlah total Netto Detil Barang</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENANDATANGAN DOKUMEN</b></h5></td>
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
                        <td class="social-list"><?= date('d F Y',strtotime($sess['TANGGAL_TTD'])); ?></td>
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
</span> 