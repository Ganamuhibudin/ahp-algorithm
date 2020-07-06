<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<span id="DivHeaderForm">
	<table width="100%" border="0">
		<tr>
			<td width="50%" valign="top">
            	<table width="90%" border="0">
                	<tr>
                    	<td colspan="2"><h5 class="header smaller lighter green"><b>Kantor Pabean</b></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="35%">Nomor Aju</td>
                        <td class="social-list"><?= $this->fungsi->FormatAju($sess['NOMOR_AJU']); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">KPBC Pendaftaran </td>
                        <td class="social-list"><?= $sess['KODE_KPBC']; ?> - <?= $sess['URAIAN_KPBC']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KPBC']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Jenis PIB </td>
                        <td class="social-list"><?= $sess['JNPIB']." - ".$sess["UR_JENIS_PIB"]?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Jenis Impor</td>
                        <td class="social-list"><?= $sess['JNIMP']." - ".$sess["UR_JNIMP"] ?></td>
                    </tr>
                    <?php if($sess["JNIMP"]=='2') { ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="social-list">Jangka Waktu : <?= $sess['JKWAKTU']?> Bulan</td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="social-list strong">Cara Bayar </td>
                        <td class="social-list"><?= $sess['CRBYR']." - ".$sess["UR_CRBYR"] ?></td>
                    </tr>
                </table>
       		</td>
            <td width="50%" valign="top">
                <table width="90%">
                    <tr>
                        <td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nomor Pendaftaran</td>
                        <td class="social-list">
							<?php 
								if($sess['STATUS_DOK']=="LENGKAP"){
									echo $sess['NOMOR_PENDAFTARAN'];
								}
                        	?>
                      	</td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tanggal Pendaftaran</td>
                        <td class="social-list">
							<?php 
								if($sess['STATUS_DOK']=="LENGKAP"){
									echo $sess['TANGGAL_PENDAFTARAN'];
								}
							?>
                     	</td>
                    </tr>
                </table>
          	</td>
		</tr>
	</table>
	<h4 class="header smaller lighter green">DATA PEMBERITAHUAN</h4>
	<table width="100%" border="0">
		<tr>
            <td width="50%" valign="top">
                <table width="90%" border="0">
                    <tr>
                    	<td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA PEMASOK</h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="35%">Nama </td>
                        <td class="social-list"><?= $sess['PASOKNAMA']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Alamat </td>
                        <td class="social-list"><?= $sess['PASOKALMT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Negara Asal </td>
                        <td class="social-list"><?= $sess['PASOKNEG']; ?> - <?= $sess['UR_PASOKNEG']==''?$URAIAN_NEGARA:$sess['UR_PASOKNEG']; ?></td>
                    </tr>
                    <tr>
                    	<td colspan="3" class="rowheight"  style="line-height:30px"><h5 class="smaller lighter blue">DATA IMPORTIR</h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Identitas</td>
                        <td class="social-list"><?= $sess['IMPID']." - ".$sess["UR_IMPID"] ?> - <?= $sess['IMPNPWP']=="" ? "" : $this->fungsi->FORMATNPWP($sess['IMPNPWP']); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama</td>
                        <td class="social-list"><?= $sess['IMPNAMA']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Alamat</td>
                        <td class="social-list"><?= $sess['IMPALMT']; ?></td>
                    </tr>
					<tr>
                        <td class="social-list strong">Status </td>
                        <td class="social-list"><?= $sess['UR_IMPSTATUS']; ?></td>
					</tr>
                    <tr>
                        <td class="social-list strong">API / APIT / APIU</td>
                        <td class="social-list"><?= $sess['APIKD']." - ".$sess["UR_API"] ?> - <?= $sess['APINO']?></td>
                    </tr>
                    <tr>
                    	<td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA PEMILIK BARANG</h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Identitas</td>
                        <td class="social-list"><?= $sess['INDID']." - ".$sess["UR_INDID"] ?> - <?= $sess['INDNPWP']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama</td>
                        <td class="social-list"><?= $sess['INDNAMA']; ?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="social-list strong">Alamat</td>
                        <td class="social-list"><?= $sess['INDALMT']; ?></td>
                    </tr>
                    <tr>
                    	<td colspan="2" class="rowheight"><h5 class="smaller lighter blue">DATA SARANA ANGKUT</h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Moda Transportasi</td>
                        <td class="social-list"><?= $sess['MODA']." - ".$sess["UR_MODA"] ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nama Sarana Angkut </td>
                        <td class="social-list"><?= $sess['ANGKUTNAMA']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">No. Voy/Flight </td>
                        <td class="social-list"><?= $sess['ANGKUTNO']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Bendera</td>
                        <td class="social-list"><?= $sess['ANGKUTFL']; ?> - <?= $sess['URANGKUTFL']==''?$URAIAN_NEGARA:$sess['URANGKUTFL']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Perkiraan Tgl Tiba&nbsp;</td>
                        <td class="social-list"><?= $sess['TGTIBA']?></td>
                    </tr>
                </table>
                <h5 class="smaller lighter blue">DATA PUNGUTAN :</h5>
                <table border="0" width="90%" cellpadding="7" cellspacing="0" class="table-striped table-bordered no-margin-bottom">
                    <tr>
                        <td width="18%" align="center" class="border-brlt strong">Jenis Pungutan</td>
                        <td width="18%" align="center" class="border-brt strong">Dibayar (Rp) </td>
                        <td width="19%" align="center" class="border-brt strong">Ditangguhkan (Rp)</td>
                        <td width="25%" align="center" class="border-brt strong">Ditangguhkan Pemerintah (Rp) </td>
                        <td width="20%" align="center" class="border-brt strong">Dibebaskan (Rp)</td>
                    </tr>
                    <?php /*?><tr>
                    <td style="padding-left:10px" class="border-brl">BM</td>
                    <td align="right"><?=$A =($sess['PGT_BM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM'],0):0;?>&nbsp;</td>
                    <td align="right"><?=$A =($sess['PGT_BM_DIT']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_DIT'],0):0;?></td>
                    <td align="right"><?=$A =($sess['PGT_BM_DIT_PEM']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_DIT_PEM'],0):0;?></td>
                    <td align="right"><?=$A =($sess['PGT_BM_STATUS']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_STATUS'],0):0;?></td>
                    </tr><?php */?>
                    <tr>
                        <td style="padding-left:10px" class="border-brl">BM</td>
                        <td align="right"><?= number_format($data_pgt[1][0]) ?>&nbsp;</td>
                        <td align="right"><?= number_format($data_pgt[1][1]) ?>&nbsp;</td>
                        <td align="right"><?= number_format($data_pgt[1][2]) ?>&nbsp;</td>
                        <td align="right"><?= number_format($data_pgt[1][4]) ?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px" class="border-brl">Cukai</td>
                        <td align="right" class="border"><?= number_format($data_pgt[5][0]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[5][1]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[5][2]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[5][4]) ?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px;" class="border-brl">PPN</td>
                        <td align="right" class="border"><?= number_format($data_pgt[2][0]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[2][1]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[2][2]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[2][4]) ?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px;" class="border-brl">PPnBM</td>
                        <td align="right" class="border"><?= number_format($data_pgt[3][0]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[3][1]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[3][2]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[3][4]) ?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px;" class="border-brl">PPh</td>
                        <td align="right" class="border"><?= number_format($data_pgt[4][0]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[4][1]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[4][2]) ?>&nbsp;</td>
                        <td align="right" class="border"><?= number_format($data_pgt[4][4]) ?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px;" class="border-brl strong">TOTAL</td>
                        <td align="right" class="border"><b><?= number_format($data_pgt['TOTAL'][0]) ?>&nbsp;</b></td>
                        <td align="right" class="border"><b><?= number_format($data_pgt['TOTAL'][1]) ?>&nbsp;</b></td>
                        <td align="right" class="border"><b><?= number_format($data_pgt['TOTAL'][2]) ?>&nbsp;</b></td>
                        <td align="right" class="border"><b><?= number_format($data_pgt['TOTAL'][4]) ?>&nbsp;</b></td>
                    </tr>
                </table>
			</td>
            <td width="50%" valign="top">
                <table width="100%" border="0">
                    <tr>
                    	<td colspan="2"><h5 class="smaller lighter blue">DATA PELABUHAN</h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong" width="25%">Muat </td>
                        <td class="social-list"><?= $sess['PELMUAT']; ?> - <?= $sess['UR_PELMUAT']==''?$urpelabuhan_muat:$sess['UR_PELMUAT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Transit</td>
                        <td class="social-list"><?= $sess['PELTRANSIT']; ?> - <?= $sess['UR_PELTRANSIT']==''?$urpelabuhan_transit:$sess['UR_PELTRANSIT']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Bongkar </td>
                        <td class="social-list"><?= $sess['PELBKR']; ?> - <?= $sess['UR_PELBKR']==''?$urpelabuhan_bongkar:$sess['UR_PELBKR']; ?></td>
                    </tr>
                    <tr>
                    	<td colspan="2"><h5 class="smaller lighter blue">INFORMASI LAIN</h5></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Dokumen Penutup </td>
                        <td class="social-list"><?= $sess['UR_DOKTUPKD'] ?> / <?= $sess['DOKTUPNO']?> / <?= $sess['DOKTUPTG']?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nomor Pos&nbsp;</td>
                        <td class="social-list">
							<?= $sess['POSNO']?>&nbsp; &nbsp;&nbsp;<span class="strong">Subpos/Sub-subpos</span> &nbsp;&nbsp;
                        	<?= $sess['POSSUB']?>&nbsp;/&nbsp;<?= $sess['POSSUBSUB']?>
                      	</td>
                    </tr>
                    <tr>
                        <td class="social-list strong">SKEP Fasilitas</td>
                        <td class="social-list"><?= $sess['KDFAS']; ?> - <?= $sess['UR_KDFAS']==''?$URKDFAS:$sess['UR_KDFAS']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Tempat Timbun </td>
                        <td class="social-list"><?= $sess['TMPTBN']; ?> - <?= $sess['UR_TIMBUN']==''?$urtempat_timbun:$sess['UR_TIMBUN']; ?></td>
                    </tr>
                    <tr>
                    	<td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA HARGA</h5></td>
                    <tr>
                        <td class="social-list strong">Valuta </td>
                        <td class="social-list"><?= $sess['KDVAL']; ?> - <?= $sess['UR_KDVAL']==''?$urvaluta:$sess['UR_KDVAL']; ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">NDPBM (Kurs) </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NDPBM'],4); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong"><span id="22">FOB</span></td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['FOB'], 2); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Freight</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['FREIGHT'], 2); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Asuransi</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['ASURANSI'], 2); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Nilai CIF </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['CIF'], 2); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">CIF (Rp)</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['CIFRP'], 2); ?></td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Bruto </td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'], 2); ?> Kilogram (KGM)</td>
                    </tr>
                    <tr>
                        <td class="social-list strong">Netto</td>
                        <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NETTO'], 2); ?>&nbsp; Kilogram (KGM)</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="social-list">Otomatis terisi dari jumlah total Netto Detil Barang</td>
                    </tr>
                    <tr>
                    	<td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA PENANDATANGAN DOKUMEN</h5></td>
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
                        <td class="social-list"><?=$sess['TANGGAL_TTD']; ?></td>
                    </tr>
			</table>
    	</td>
	</tr>
</table>
<? if($priview){ ?>
    <h4 class="header smaller lighter green"><i class="icon-list"></i>&nbsp;<b>Detil Dokumen</b></h4>
    <?=$DETILPRIVIEW;?>
<? } ?>