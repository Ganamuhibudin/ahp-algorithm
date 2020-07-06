<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<span id="DivHeaderForm">
    <table width="100%" border="0">
        <tr>
            <td width="45%" valign="top">	
                <table width="90%" border="0">
                    <tr>
                        <td class="social-list strong" width="35%">Nomor Aju</td>
                        <td class="social-list"><?=$this->fungsi->FormatAju($sess['NOMOR_AJU']);?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Kantor Pabean</td>
                        <td class="social-list"><?= $sess['KODE_KPBC']; ?> - <?= $sess['URAIAN_KPBC']?$sess['URAIAN_KPBC']:$URKANTOR_TUJUAN; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Jenis TPB</td>
                        <td class="social-list"><?= $sess['JENIS_TPB']." - ".$sess["UR_JENIS_TPB"] ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tujuan Pengiriman</td>
                        <td class="social-list"><?= $sess['TUJUAN_KIRIM']." - ".$sess["UR_TUJUAN_KIRIM"] ?></td>
                    </tr>
                </table>
            </td>
            <td width="55%">
                <table width="90%">
                	<tr>
                    	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="45%">Nomor Pendaftaran</td>
                        <td class="social-list"><?= $sess['NOMOR_PENDAFTARAN'];?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal Pendaftaran</td>
                        <td class="social-list"><? if($sess['TANGGAL_PENDAFTARAN']!= "" || $sess['TANGGAL_PENDAFTARAN']!= "0000-00-00") echo date('d F Y',strtotime($sess['TANGGAL_PENDAFTARAN'])); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">No. Persetujuan Pemasukan</td>
                        <td class="social-list"><?= $sess['NOMOR_DOK_PABEAN']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal Persetujuan Pemasukan</td>
                        <td class="social-list"><? if($sess['TANGGAL_DOK_PABEAN']!= "" || $sess['TANGGAL_DOK_PABEAN']!= "0000-00-00") echo date('d F Y',strtotime($sess['TANGGAL_DOK_PABEAN'])); ?></td>
                    </tr>
                     <tr>
                        <td class="social-list strong">Nama Pejabat BC</td>
                        <td class="social-list"><?= $sess['NAMA_PEJABAT_BC']; ?></td>
                    </tr>
                     <tr>
                        <td class="social-list strong">NIP Pejabat BC</td>
                        <td class="social-list"><?= $sess['NIP_PEJABAT_BC']; ?></td>
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
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>PENGUSAHA TPB</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="35%">Identitas</td>
                        <td class="social-list"><?= $sess['UR_KODE_ID_TRADER'] ?> - <?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?></td>
                    </tr> 
                    <tr>
                        <td class="social-list strong">Nama </td>
                        <td class="social-list"><?= $sess['NAMA_TRADER']; ?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="social-list strong">Alamat </td>
                        <td class="social-list"><?= $sess['ALAMAT_TRADER']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">No Ijin TPB </td>
                        <td class="social-list"><?= $sess['NOMOR_IZIN_TPB']?$sess['NOMOR_IZIN_TPB']:$sess['NOMOR_SKEP']; ?></td>
                    </tr>
                   <!-- <tr>
                        <td colspan="3" class="rowheight"><h5>Riwayat Barang</h5></td>
                    </tr>
                    <tr>			<td>Nomor BC 4.0 Asal</td>
                        <td><input type="text" name="HEADERX[NOMOR_BC]" id="nomor_bc" value="<?$sessX['NOMOR_BC']; ?>"  maxlength="20"class="mtext" /></td>
                    </tr>
                    <tr>
                        <td>Tanggal BC 4.0 Asal</td>
                        <td><input type="text" name="HEADERX[TANGGAL_BC]" id="tanggal_bc" value="<?$sessX['TANGGAL_BC']; ?>"  maxlength="20"class="sstext" onfocus="ShowDP('tanggal_bc');" /></td>
                    </tr>-->
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGANGKUT</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Jenis Sarana Pengangkut Darat </td>
                        <td class="social-list"><?= $sess['JENIS_SARANA_ANGKUT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nomor Polisi </td>
                        <td class="social-list"><?= $sess['NOMOR_POLISI']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Harga Penyerahan (Rp) </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN'],2); ?></td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td colspan="2">
                            <h5 class="smaller lighter red"><b>RIWAYAT BARANG ASAL BC 4.1</b></h5>
                            <table width="100%" border="0" id="TBLASAL">
                                <tbody>
                                    <? echo $dataasal; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="55%" valign="top">
                <table width="90%" border="0"> 
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Volume (M3) </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['VOLUME'],4); ?></td>
                    </tr>
                    <tr>
                        <td  class="social-list strong">Berat Kotor (Kg) </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'],4); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Berat Bersih (Kg) </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'],4); ?>&nbsp; Kilogram (KGM)</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>PENGIRIM BARANG</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Identitas</td>
                        <td class="social-list"><?= $sess['UR_KODE_ID_PENGIRIM']; ?> - <?php if($sess['KODE_ID_PENGIRIM']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PENGIRIM']);}else{ echo $sess['ID_PENGIRIM'];}?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama</td>
                        <td class="social-list"><?= $sess['NAMA_PENGIRIM']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Alamat</td>
                        <td class="social-list"><?= $sess['ALAMAT_PENGIRIM']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>TANDA TANGAN PENGUSAHA TPB</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama</td>
                        <td class="social-list"><?= $sess['NAMA_TTD']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tempat</td>
                        <td class="social-list"><?= $sess['KOTA_TTD']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal</td>
                        <td class="social-list"><?php if($sess['TANGGAL_TTD']!="" || $sess['TANGGAL_TTD']!= '0000-00-00') echo date('d F Y',strtotime($sess['TANGGAL_TTD'])); ?></td>
                    </tr>
                </table>
            </td>      
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
    </table>
</span>
<?php if($priview){
	echo '<h4 class="header smaller lighter green"><b>Detil Dokumen</b></h4>'.$DETILPRIVIEW;
}?>