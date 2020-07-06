<?php
#print_r($DATA);die();
$no_pengajuan	= $this->fungsi->FormatAju($DATA['NOMOR_AJU']);
$kantor_pabean	= $DATA['URAIAN_KPBC'];
$jns_tpb		= $DATA['URJENIS_TPB'];
$no_pendaftaran	= $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar		= $DATA['TANGGAL_PENDAFTARAN'];
$jns_bc			= $DATA['JENIS_BC25'];
$kondisi_brg	= $DATA['KONDISI_BARANG'];
$npwp_pengusaha	= $DATA['ID_TRADER'];
$nama_pengusaha	= $DATA['NAMA_TRADER'];
$alamat_pengusaha= $DATA['ALAMAT_TRADER'];
$no_izintpb		= $DATA['NOMOR_IZIN_TPB'];
$npwp_penerima	= $DATA['ID_PENERIMA'];
$nama_penerima	= $DATA['NAMA_PENERIMA'];
$alamat_penerima= $DATA['ALAMAT_PENERIMA'];
$niper			= $DATA['NIPER_PENERIMA'];
$invoce			= $DATADOK['NOMOR_INVOICE'];
$tgl_invoce		= $DATADOK['TANGGAL_INVOICE'];
$srt_keputusan 	= $DATADOK['NOMOR_SURAT_KEPUTUSAN'];
$tgl_keputusan 	= $DATADOK['TANGGAL_SURAT_KEPUTUSAN'];
$no_packing		= $DATADOK['NOMOR_PACKING_LIST'];
$tgl_packing	= $DATADOK['TANGGAL_PACKING_LIST'];
$no_kontrak		= $DATADOK['NOMOR_KONTRAK'];
$tgl_kontrak	= $DATADOK['TANGGAL_KONTRAK'];
$no_dokumen		= $DATADOK['NOMOR_LAINNYA'];
$tgl_dokumen	= $DATADOK['TANGGAL_LAINNYA'];		
$kode_valuta	= $DATA['KODE_VALUTA'];
$uraian_valuta	= $DATA['URAIAN_VALUTA'];
$cif			= $DATA['CIF'];
//$nilai_cif		= $DATA['CIFRP'];
$nilai_cif      = $DATA["CIF"] * $DATA['NDPBM'];
$ndpbm			= $DATA['NDPBM'];
$hrg_penyerahan	= $DATA['HARGA_PENYERAHAN'];
$kd_kemasan	    = $DATAKMS['KODE_KEMASAN'];
$jns_kemasan	= $DATAKMS['URKODE_KEMASAN'];
$jml_kemasan	= $DATAKMS['JUMLAH'];
$merk_kemasan	= $DATAKMS['MERK_KEMASAN'];
$no_urut		= "10";
$uraian_brg		= "BAUT UNTUK LOGAM DARI BESI UNTUK LEMARI DARI BESI MERKSCHAUM, UKURAN 2 INCH";
$kode_penggunaanbrg = "2";
$negara_asalbrg	= "THAILAND";
$skema_tarif	= "CEPT";
$tarif			= "BM 5%, PPN 10%, PPnBM 0%";
$jml_satuan		= "2.000 PCS";	
$berat_bersihbrg= "25 KG";
$volume_brg		= "12m3";
$bm_bayar		= ($DATAPGT['PGT_BM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM'],0):0;
$bm_dit_pem 	= ($DATAPGT['PGT_BM_DIT_PEM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM_DIT_PEM'],0):0;
$bm_bebas		= ($DATAPGT['PGT_BM_BEBAS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM_BEBAS'],0):0;
$bm_tdk_dipungut= ($DATAPGT['PGT_BM_TDK_DIPUNGUT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM_TDK_DIPUNGUT'],0):0;
$bm_ditunda 	= ($DATAPGT['PGT_BM_DITUNDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM_DITUNDA'],0):0;
$cukai_bayar	= ($DATAPGT['PGT_CUKAI']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI'],0):0;
$cukai_dit_pem 	= ($DATAPGT['PGT_CUKAI_DIT_PEM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI_DIT_PEM'],0):0;
$cukai_bebas	= ($DATAPGT['PGT_CUKAI_BEBAS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI_BEBAS'],0):0;
$cukai_tdk_dipungut= ($DATAPGT['PGT_CUKAI_TDK_DIPUNGUT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI_TDK_DIPUNGUT'],0):0;
$cukai_ditunda 	= ($DATAPGT['PGT_CUKAI_DITUNDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI_DITUNDA'],0):0;
$bmkite_bayar	= ($DATAPGT['PGT_BMKITE']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BMKITE'],0):0;
$bmkite_dit_pem	= ($DATAPGT['PGT_BMKITE_DIT_PEM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BMKITE_DIT_PEM'],0):0;
$bmkite_bebas	= ($DATAPGT['PGT_BMKITE_BEBAS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BMKITE_BEBAS'],0):0;
$bmkite_tdk_dipungut= ($DATAPGT['PGT_BMKITE_TDK_DIPUNGUT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BMKITE_TDK_DIPUNGUT'],0):0;
$bmkite_ditunda	= ($DATAPGT['PGT_BMKITE_DITUNDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BMKITE_DITUNDA'],0):0;
$ppn_bayar		= ($DATAPGT['PGT_PPN']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN'],0):0;
$ppn_dit_pem	= ($DATAPGT['PGT_PPN_DIT_PEM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN_DIT_PEM'],0):0;
$ppn_bebas		= ($DATAPGT['PGT_PPN_BEBAS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN_BEBAS'],0):0;
$ppn_tdk_dipungut	= ($DATAPGT['PGT_PPN_TDK_DIPUNGUT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN_TDK_DIPUNGUT'],0):0;
$ppn_ditunda	= ($DATAPGT['PGT_PPN_DITUNDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN_DITUNDA'],0):0;
$ppnbm_bayar	= ($DATAPGT['PGT_PPNBM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM'],0):0;
$ppnbm_dit_pem	= ($DATAPGT['PGT_PPNBM_DIT_PEM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM_DIT_PEM'],0):0;
$ppnbm_bebas	= ($DATAPGT['PGT_PPNBM_BEBAS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM_BEBAS'],0):0;
$ppnbm_tdk_dipungut	= ($DATAPGT['PGT_PPNBM_TDK_DIPUNGUT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM_TDK_DIPUNGUT'],0):0;
$ppnbm_ditunda	= ($DATAPGT['PGT_PPNBM_DITUNDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM_DITUNDA'],0):0;
$pph_bayar		= ($DATAPGT['PGT_PPH']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH'],0):0;
$pph_dit_pem	= ($DATAPGT['PGT_PPH_DIT_PEM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH_DIT_PEM'],0):0;
$pph_bebas		= ($DATAPGT['PGT_PPH_BEBAS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH_BEBAS'],0):0;
$pph_tdk_dipungut	= ($DATAPGT['PGT_PPH_TDK_DIPUNGUT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH_TDK_DIPUNGUT'],0):0;
$pph_ditunda	= ($DATAPGT['PGT_PPH_DITUNDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH_DITUNDA'],0):0;
$pnbp_bayar		= ($DATAPGT['PGT_PNBP']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PNBP'],0):0;
$pnbp_bebas		= ($DATAPGT['PGT_PNBP_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PNBP_STATUS'],0):0;
$denda_bayar	= ($DATAPGT['PGT_DENDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_DENDA'],0):0;
$denda_bebas	= ($DATAPGT['PGT_DENDA_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_DENDA_STATUS'],0):0;
$bunga_bayar	= ($DATAPGT['PGT_BUNGA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BUNGA'],0):0;
$bunga_bebas	= ($DATAPGT['PGT_BUNGA_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BUNGA_STATUS'],0):0;
$total_bayar	= $this->fungsi->FormatRupiah($DATAPGT['PGT_BM']+$DATAPGT['PGT_CUKAI']+$DATAPGT['PGT_BMKITE']+$DATAPGT['PGT_PPN']+$DATAPGT['PGT_PPNBM']+$DATAPGT['PGT_PPH'],0);
$total_dit_pem	= $this->fungsi->FormatRupiah($DATAPGT['PGT_BM_DIT_PEM']+$DATAPGT['PGT_CUKAI_DIT_PEM']+$DATAPGT['PGT_BMKITE_DIT_PEM']+$DATAPGT['PGT_PPN_DIT_PEM']+$DATAPGT['PGT_PPNBM_DIT_PEM']+$DATAPGT['PGT_PPH_DIT_PEM'],0);
$total_bebas	= $this->fungsi->FormatRupiah($DATAPGT['PGT_BM_BEBAS']+$DATAPGT['PGT_CUKAI_BEBAS']+$DATAPGT['PGT_BMKITE_BEBAS']+$DATAPGT['PGT_PPN_BEBAS']+$DATAPGT['PGT_PPNBM_BEBAS']+$DATAPGT['PGT_PPH_BEBAS'],0);
$total_tdk_dipungut	= $this->fungsi->FormatRupiah($DATAPGT['PGT_BM_TDK_DIPUNGUT']+$DATAPGT['PGT_CUKAI_TDK_DIPUNGUT']+$DATAPGT['PGT_BMKITE_TDK_DIPUNGUT']+$DATAPGT['PGT_PPN_TDK_DIPUNGUT']+$DATAPGT['PGT_PPNBM_TDK_DIPUNGUT']+$DATAPGT['PGT_PPH_TDK_DIPUNGUT'],0);
$total_ditunda	= $this->fungsi->FormatRupiah($DATAPGT['PGT_BM_DITUNDA']+$DATAPGT['PGT_CUKAI_DITUNDA']+$DATAPGT['PGT_BMKITE_DITUNDA']+$DATAPGT['PGT_PPN_DITUNDA']+$DATAPGT['PGT_PPNBM_DITUNDA']+$DATAPGT['PGT_PPH_DITUNDA'],0);
$volume			= $DATA['VOLUME'];
$berat_kotor	= $DATA['BRUTO'];
$berat_bersih	= $DATA['NETTO'];
$nama_ttd		= $DATA['NAMA_TTD'];
$kota_ttd		= $DATA['KOTA_TTD'];
$tgl_ttd		= $DATA['TANGGAL_TTD'];
$KOTA_TTD_PENERIMA		= $DATA['KOTA_TTD_PENERIMA'];
$NAMA_TTD_PENERIMA		= $DATA['NAMA_TTD_PENERIMA'];
$TGL_TTD_PENERIMA		= $DATA['TANGGAL_TTD_PENERIMA'];
$no_sscp		= "................................";
$tgl_sscp		= ".......................";
$no_ntbsscp		= "................................";
$tgl_ntbsscp	= ".......................";
$no_ntpnsscp	= "................................";
$tgl_ntpnsscp	= ".......................";
$no_ssp			= "................................";
$tgl_ssp		= ".......................";
$no_ntbssp		= "................................";
$tgl_ntbssp		= ".......................";
$no_ntpnssp		= "................................";
$tgl_ntpnssp	= ".......................";
?>
<style type="text/css">
.border-t {border-top:thin solid #000000;}
.border-l {border-left:thin solid #000000;}
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tl {border-top:thin solid #000000;border-left:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tb {border-top:thin solid #000000;border-bottom:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input10{padding-left:5px;padding-right:5px;width:10px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input20{text-align:center;padding-left:5px;padding-right:5px;width:25px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.pr{padding-right: 3px;};
</style>
				
<body style="font-size:11;">
<div align="center" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
	<b>PEMBERITAHUAN IMPOR BARANG<br>DARI PUSAT LOGISTIK BERIKAT</b>
</div>
<div align="right" style="font-size:10;font-family:Arial, Helvetica, sans-serif">BC 2.8</div>
<div class="border-tbrl" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%"><strong>Kantor Pabean</strong></td>
            <td width="1%">:</td>
            <td width="35%"><?=$DATA["URAIAN_KPBC"]?></td>
            <td width="49%" style="padding-top:-2px"><input type="text" class="input40" value="<?=$DATA["KODE_KANTOR_PABEAN"]?>" /></td>
		</tr> 
        <tr>
        	<td><strong>Nomor Pengajuan</strong></td>
            <td>:</td>
            <td><?=$DATA["NOMOR_AJU"]?></td>
            <td>Tanggal Pengajuan : <?=$this->fungsi->dateformat($DATA["TANGGAL_AJU"])?></td>
        </tr> 
        <tr>
        	<td><strong>A. Jenis BC 2.8</strong></td>
            <td>:</td>
            <td colspan="2"><table width="400px"><tr><td width="5%"><input type="text" class="input10" value="<?=$DATA["JENIS_BC28"]?>" /></td><td width="25%">1. Biasa;</td><td width="20%">2. Berkala;</td><td width="30%">3. Pelayanan Segera.</td><td width="20%"></td></tr></table></td>
        </tr> 
        <tr>
        	<td><strong>B. Jenis Impor</strong></td>
            <td>:</td>
            <td colspan="2"><table width="400px"><tr><td width="5%"><input type="text" class="input10" value="<?=$DATA["JENIS_IMPOR"]?>" /></td><td width="25%">1. Untuk Dipakai;</td><td width="20%">2. Sementara;</td><td width="30%">5. Pelayanan Segera;</td><td width="20%">9. Gabungan.</td></tr></table></td>
        </tr> 
        <tr>
        	<td><strong>C. Cara Pembayaran</strong></td>
            <td>:</td>
            <td colspan="2"><table width="400px"><tr><td width="5%"><input type="text" class="input10" value="<?=$DATA["CARA_PEMBAYARAN"]?>" /></td><td width="25%">1. Biasa/Tunai;</td><td width="20%">2. Berkala;</td><td width="30%">3. Dengan Jaminan;</td><td width="20%">9. Gabungan.</td></tr></table></td>
        </tr>
        <tr>
        	<td style="font-size:12; background-color:#ddd;" class="border-tb" colspan="4"><b>D. DATA PEMBERITAHUAN</b></td>
        </tr>
        <tr>
        	<td colspan="4" class="">
            	<table width="100%" cellpadding="0" cellspacing="0" style="margin:-2px">
                	<tr>
                        <td width="50%" class="border-br" valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-right:-2px">
                            	<tr>
                                	<td colspan="3" width="100%"><b><u>PENYELENGGARA PLB/PENGUSAHA PLB/PDPLB</u></b></td>
                                </tr>
                                <tr>
                                    <td valign="top" width="10%">1. NPWP</td>
                                    <td valign="top" width="1%">:</td>
                                    <td width="89%"><?php if($DATA["KODE_ID_PENGUSAHA"]==5){ echo $this->fungsi->FormatNPWP($DATA["ID_PENGUSAHA"]); }else{ echo $DATA["ID_PENGUSAHA"]; }?></td>
                                </tr>
                                <tr>
                                    <td valign="top">2. Nama</td>
                                    <td valign="top">:</td>
                                    <td><?=$DATA["NAMA_PENGUSAHA"]?></td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-b">3. Alamat</td>
                                    <td valign="top" class="border-b">:</td>
                                    <td class="border-b"><?=$DATA["ALAMAT_PENGUSAHA"]?></td>
                                </tr>
                                <tr>
                                	<td colspan="2" width="100%"><b><u>PENJUAL</u></b></td>
                                    <td style="padding-right:-1px;padding-top:-2px" align="right" valign="top"><input type="text" class="input20" value="<?=$DATA["NEGARA_PENJUAL"]?>" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" width="10%">4. Identitas</td>
                                    <td valign="top" width="1%">:</td>
                                    <td  width="89%"><?php if($DATA["KODE_ID_PENJUAL"]==5){ echo $this->fungsi->FormatNWP($DATA["ID_PENJUAL"]); }else{ echo $DATA["ID_PENJUAL"]; }?></td>
                                </tr>
                                <tr>
                                    <td valign="top">5. Nama</td>
                                    <td valign="top">:</td>
                                    <td><?=$DATA["NAMA_PENJUAL"]?></td>
                                </tr>
                                <tr>
                                    <td valign="top">6. Alamat</td>
                                    <td valign="top">:</td>
                                    <td><?=$DATA["ALAMAT_PENJUAL"]?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" class="border-b">
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:-2px">
                            	<tr>
                                	<td style="padding-left:2px" colspan="4"><strong>G. No & Tgl.Pendaftaran</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">Nomor Pendaftaran</td>
                                    <td valign="top">:</td>
                                    <td colspan="2"><?=$DATA["NOMOR_RPENDAFTARAN"]?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top" class="border-b">Tanggal Pendaftaran</td>
                                    <td valign="top" class="border-b">:</td>
                                    <td class="border-b" colspan="2"><?=$this->fungsi->dateformat($DATA["TANGGAL_RPENDAFTARAN"])?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top" width="10%">19. Invoice</td>
                                    <td valign="top" width="1%">:</td>
                                    <td width="89%" colspan="2">No. <div>Tgl. </div></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">20. Paking List</td>
                                    <td valign="top">:</td>
                                    <td colspan="2">No. <div>Tgl. </div></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top" colspan="4">21. Dokomuen Pengeluaran Barang</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. <?=$DATA["NO"]?></td>
                                    <td valign="top" class="border-b" colspan="3">Tgl. <?=$DATA['TANGGAL']?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">22. Dokumen Lainnya</td>
                                    <td valign="top">:</td>
                                    <td valign="top">&nbsp;</td>
                                    <td style="padding-right:-2px;padding-top:-2px" align="right"><input type="text" class="input20" value="" /></td> <!-- $DATA["NEGARA_PENJUAL"] -->
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top" class="border-b">No. <?=$DATA["NO"]?></td>
                                    <td style="padding-left:2px" valign="top" class="border-b" colspan="3">Tgl. <?=$this->fungsi->dateformat($DATA['TANGGAL'])?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">23. Tempat Penimbunan</td>
                                    <td valign="top">:</td>
                                    <td valign="top"><?=$DATA["URAI_TIMBUN"]?></td>
                                    <td style="padding-right:-2px;padding-top:-2px" align="right"><input type="text" class="input20" value="<?=$DATA["KODE_TIMBUN"]?>" /></td>
                                </tr>
                            </table>
                        </td>
                	</tr>
                    <tr>
                    	<td width="50%" valign="top" class="border-br">
                        	<table width="100%" cellpadding="0" cellspacing="0" style="padding:-2px">
                            	<tr>
                                	<td style="padding-left:4px" colspan="3" width="100%"><b><u>IMPORTIR</u></b></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:4px" valign="top" width="10%">7. Identitas</td>
                                    <td  valign="top" width="1%">:</td>
                                    <td   width="89%">
										<?=$DATA["UR_KODE_ID_IMPORTIR"]?> - 
										<?php 
											if($DATA["KODE_ID_IMPORTIR"]==5){ 
												echo $this->fungsi->FormatNPWP($DATA["ID_IMPORTIR"]); 
											}else{ 
												echo $DATA["ID_IMPORTIR"]; 
											}
										?>
                                  	</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:4px" valign="top">8. Nama</td>
                                    <td valign="top">:</td>
                                    <td><?=$DATA["NAMA_IMPORTIR"]?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:4px" valign="top">9. Alamat</td>
                                    <td valign="top">:</td>
                                    <td><?=$DATA["ALAMAT_IMPORTIR"]?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top" class="border-b">10. Status</td>
                                    <td valign="top" class="border-b">:</td>
                                    <td class="border-b"><?=$DATA["NIK_IMPORTIR"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11. APIU/APIP : <?=$DATA["NOMOR_API"]?></td>
                                </tr>
                                <tr>
                                	<td style="padding-left:2px" colspan="3"><b><u>PEMILIK BARANG</u></b></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">12. Identitas</td>
                                    <td valign="top">:</td>
                                    <td>
										<?php 
											if($DATA["KODE_ID_PEMILIK"]==5){ 
												echo $this->fungsi->FormatNPWP($DATA["ID_PEMILIK"]); 
											}else{ 
												echo $DATA["ID_PEMILIK"]; 
											}
										?>
                                  	</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">13. Nama</td>
                                    <td valign="top">:</td>
                                    <td><?=$DATA["NAMA_PEMILIK"]?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">14. Alamat</td>
                                    <td valign="top">:</td>
                                    <td><?=$DATA["ALAMAT_PEMILIK"]?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" class="border-b">
                        	<table width="100%" cellpadding="0" cellspacing="0" style="padding-left:-2px" >
                                <tr>
                                    <td style="padding-left:2px" valign="top" width="20%">24. Jenis Sarana Pengangkut</td>
                                    <td valign="top" width="78%" colspan="2">: <?=$DATA["URAIAN_MODA"]?></td>
                                    <td style="padding-right:-2px;padding-top:-3px" align="right" width="2%" valign="top"><input type="text" class="input20" value="<?=$DATA["MODA"]?>" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-b" colspan="4"></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">25. Valuta</td>
                                    <td valign="top" colspan="2">: <?=$DATA["URAIAN_VALUTA"]?></td>
                                    <td style="padding-right:-2px;padding-top:-2px" valign="top" align="right"><input type="text" class="input20" value="<?=$DATA["KODE_VALUTA"]?>" /></td>
                                </tr>
                                 <tr>
                                    <td style="padding-left:2px" valign="top">26. NDPBM</td>
                                    <td valign="top" colspan="2">: <?php echo $this->fungsi->FormatRupiah($DATA["NDPBM"],2);?></td>
                                    <td valign="top"></td>
                                </tr>
                                 <tr>
                                    <td valign="top" class="border-b" colspan="4"></td>                                   
                                </tr>
                                 <tr>
                                    <td style="padding-left:2px" valign="top" >27. Jenis Nilai</td>
                                    <td valign="top">:&nbsp;&nbsp;<?=$DATA["URAIAN_NILAI"]?></td>
                                    <td valign="top"></td>
                                    <td style="padding-right:-2px;padding-top:-2px" valign="top" align="right"><input type="text" class="input20" value="<?=$DATA["JENIS_NILAI"]?>" /></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top">28. Nilai</td>
                                    <td valign="top">:&nbsp;&nbsp;<?php echo $this->fungsi->FormatRupiah($DATA["NILAI"],2);?></td>
                                    <td valign="top"></td>
                                    <td align="right"></td>
                                </tr>
                                 <tr>
                                    <td style="padding-left:2px" valign="top">29. Nilai Pabean</td>
                                    <td valign="top">:&nbsp;&nbsp;<?php echo $this->fungsi->FormatRupiah($DATA["NILAI_CIF"],2);?></td>
                                    <td valign="top" colspan="2"></td>
                                </tr>
                                 <tr>
                                    <td style="padding-left:2px" valign="top">30. Rp. <?php echo $this->fungsi->FormatRupiah($DATA["CIF_RP"],2);?></td>
                                    <td valign="top"></td>
                                    <td valign="top" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-b" colspan="4"></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:2px" valign="top" colspan="4">31. Nomor, Ukuran, dan Tipe Peti Kemas :</td>
                                </tr>
                                 <tr>
                                    <td valign="top" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "".$DATACNT['NOMOR_KON'].", ".$DATACNT['UKURAN_KON'].", ".$DATACNT['TIPE_KON']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" valign="top" class="border-br">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="3" width="100%"><b><u>PPJK</u></b></td>
                                </tr>
                                <tr>
                                    <td valign="top" width="10%">15. Identitas</td>
                                    <td valign="top" width="1%">:</td>
                                    <td  width="89%"></td>
                                </tr>
                                <tr>
                                    <td valign="top" width="10%">16. Nama</td>
                                    <td valign="top" width="1%">:</td>
                                    <td  width="89%"></td>
                                </tr>
                                <tr>
                                    <td valign="top" width="10%">17. Alamat</td>
                                    <td valign="top" width="1%">:</td>
                                    <td  width="89%" height="30px"></td>
                                </tr>
                                <tr>
                                    <td valign="top" width="10%">18. NP-PPJK</td>
                                    <td valign="top" width="1%">:</td>
                                    <td  width="89%"></td>
                                </tr>
                               
                            </table>
                        </td>
                        <td width="50%" valign="top" class="border-b">
                            <table width="200%" cellpadding="0" cellspacing="0" style="padding-left:-2px">
                                 <tr>
                                    <td style="padding-left:4px" valign="top" colspan="4" width="100%">32. Jumlah, Jenis, dan Merk Kemasan :</td>
                                </tr>
                                 <tr>
                                    <td valign="top" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "".$jml_kemasan.", ".$jns_kemasan.", ".$merk_kemasan; ?></td>
                                </tr>
                                 <tr>
                                    <td valign="top" colspan="4" class="border-b">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="49%">33. Berat Kotor (Kg) :</td>
                                    <td width="1%" class="border-r">&nbsp;</td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="49%">34. Berat Bersih (Kg) :</td>
                                </tr>
                                 <tr>
                                    <td width="49%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->fungsi->FormatRupiah($DATA['BRUTO'],2);?></td>
                                    <td width="1%" class="border-r">&nbsp;</td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="49%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->fungsi->FormatRupiah($DATA['NETTO'],2);?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-r">&nbsp;</td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0" style="padding-top:-2px;padding-bottom:-2px">
                                <tr>
                                    <td valign="top" width="5%" class="border-r">35. <br>No. </td>
                                    <td valign="top" width="25%" class="border-r">36. - Pos Tarif/HS<br>
                                    - Uraian Jenis Barang (termasuk spesifikasi wajib)<br>
                                    - Persentase Barang Impor<br>
                                    - Negara Asal Barang
                                    </td>
                                    <td valign="top" width="15%" class="border-r">37. Keterangan<br>
                                    - Fasilitas & No. Urut<br>
                                    - Persyaratan & No. Urut</td>
                                    <td valign="top" width="10%" class="border-r">38. Tarif dan Fasilitas</td>
                                    <td valign="top" width="22%" class="border-r">39. - Jumlah & Jenis satuan barang<br>
                                    - Berat Bersih (Kg)<br>
                                    - Jumlah & Jenis Kemasan</td>
                                    <td valign="top" width="23%">40. - Nilai CIF<br>
                                    - Jenis Nilai<br>
                                    - Nilai yang ditambahkan<br>
                                    - Jatuh Tempo</td>
                                </tr>
                                <tr>
                                <?php if(count($BARANG)>1){ ?>
                                	<td colspan="6" class="border-t" align="center"><br><br>------------------- <?=count($BARANG)?> Jenis barang. Lihat lembar lanjutan --------------------<br>&nbsp;<br>&nbsp;</td>
                                <?php }else{?>    
                                    <td valign="top" width="5%" class="border-tr">&nbsp;&nbsp;1.&nbsp; </td>
                                    <td valign="top" width="25%" class="border-tr">- <?= $BARANG[0]['KODE_HS']?> / Kode Barang = <?= $BARANG[0]['KODE_BARANG']?><br>
                                    - <?= $BARANG[0]['URAIAN_BARANG']?>, Merk : <?= $BARANG[0]['MERK']?>, Tipe : <?= $BARANG[0]['TIPE']?>, UKURAN : <?= $BARANG[0]['UKURAN']?><br>
                                    - <?= $BARANG[0]['JUMLAH_BARANG_IMPOR']?>%<br>
                                    - <?= strtoupper($BARANG[0]['URIAN_NEGARA'])?>
                                    </td>
                                    <td valign="top" width="15%" class="border-tr">- <?= $BARANG[0]['KODE_FASILITAS']?><br>
                                    </td>
                                    <td valign="top" width="10%" class="border-tr"><!-- 38. Tarif dan Fasilitas --></td>
                                    <td valign="top" width="22%" class="border-tr">- <?= $BARANG[0]['JUMLAH_SATUAN']?> <?= $BARANG[0]['KODE_SATUAN']?> (<?= $BARANG[0]['URAIAN_SATUAN']?>)<br>
                                    - <?= $BARANG[0]['NETTO']?> Kg<br>
                                    - <?= $BARANG[0]['JUMLAH_KEMASAN']?> <?= $BARANG[0]['KODE_KEMASAN']?></td>
                                    <td valign="top" class="border-t" width="23%">- <?php echo $this->fungsi->FormatRupiah($BARANG[0]['CIF'],2)?><br>
                                    - <?= $BARANG[0]['JENIS_NILAI']?><br>
                                    - <?php echo $this->fungsi->FormatRupiah($BARANG[0]['NILAI_TAMBAHAN'],2)?><br>
                                    - <?= $BARANG[0]['TGL_JATUH_TEMPO']?></td>
                                <?php }?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" valign="top">
                            <table width="100%" cellspacing="0">
                                 <tr>
                                    <td valign="top" width="15%" align="center" class="border-tr">Jenis Pungutan</td>
                                    <td valign="top" width="25%" align="center" class="border-tr">Dibayar</td>
                                    <td valign="top" width="20%" align="center" class="border-tr">Ditanggung Pemerintah</td>
                                    <td valign="top" width="20%" align="center" class="border-tr">Ditunda</td>
                                    <td valign="top" width="25%" align="center" class="border-tr">Tidak Dipungut</td>
                                    <td valign="top" width="20%" align="center" class="border-tr">Dibebaskan</td>
                                    <td valign="top" width="25%" align="center" class="border-t">Telah Dilunasi</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr">41. BM</td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bm_bayar?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bm_dit_pem?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bm_ditunda?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bm_tdk_dipungut?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bm_bebas?></td>
                                    <td valign="top" align="right" class="border-t pr">0</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr">42. BM KITE</td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bmkite_bayar?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bmkite_dit_pem?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bmkite_ditunda?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bmkite_tdk_dipungut?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $bmkite_bebas?></td>
                                    <td valign="top" align="right" class="border-t pr">0</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr">43. BMT</td>
                                    <td valign="top" align="right" class="border-tr pr">0</td>
                                    <td valign="top" align="right" class="border-tr pr">0</td>
                                    <td valign="top" align="right" class="border-tr pr">0</td>
                                    <td valign="top" align="right" class="border-tr pr">0</td>
                                    <td valign="top" align="right" class="border-tr pr">0</td>
                                    <td valign="top" align="right" class="border-t pr">0</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr">44. Cukai</td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $cukai_bayar?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $cukai_dit_pem?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $cukai_ditunda?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $cukai_tdk_dipungut?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $cukai_bebas?></td>
                                    <td valign="top" align="right" class="border-t pr">0</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr">45. PPN</td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppn_bayar?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppn_dit_pem?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppn_ditunda?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppn_tdk_dipungut?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppn_bebas?></td>
                                    <td valign="top" align="right" class="border-t pr">0</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr">46. PPnBM</td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppnbm_bayar?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppnbm_dit_pem?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppnbm_ditunda?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppnbm_tdk_dipungut?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $ppnbm_bebas?></td>
                                    <td valign="top" align="right" class="border-t pr">0</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr">47. PPh</td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $pph_bayar?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $pph_dit_pem?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $pph_ditunda?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $pph_tdk_dipungut?></td>
                                    <td valign="top" align="right" class="border-tr pr"><?= $pph_bebas?></td>
                                    <td valign="top" align="right" class="border-t pr">0</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="border-tr border-b">48. Total</td>
                                    <td valign="top" align="right" class="border-tr border-b pr"><?= $total_bayar?></td>
                                    <td valign="top" align="right" class="border-tr border-b pr"><?= $total_dit_pem?></td>
                                    <td valign="top" align="right" class="border-tr border-b pr"><?= $total_ditunda?></td>
                                    <td valign="top" align="right" class="border-tr border-b pr"><?= $total_tdk_dipungut?></td>
                                    <td valign="top" align="right" class="border-tr border-b pr"><?= $total_bebas?></td>
                                    <td valign="top" align="right" class="border-t border-b pr">0</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-r"><strong style="font-size:10px">F. Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam dokumen ini dan keabsahan dokumen pelengkap pabean yang menjadi dasar pembuatan dokumen ini.</strong><br>
                            <table width="100%" align="center" cellpadding="0" cellspacing="0" >
                            <tr><td align="center" style="font-size:10px"><?= $DATA['KOTA_TTD'].', '.$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?></td></tr>
                            <tr><td align="center" style="font-size:10px">Importir/PPJK</td></tr>
                            <tr><td align="center" style="font-size:10px">&nbsp;<br>&nbsp;</td></tr>
                            <tr><td align="center" style="font-size:10px"><?=$DATA['PEMBERITAHU'];?></td></tr>
                            </table>
                        </td>
                        <td valign="top"><strong><u>E. UNTUK PEMBAYARAN DAN JAMINAN :</u></strong>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>a. Pembayaran</td>
                                    <td><input type="text" class="input10" value="<?=$DATA["KODE_PEMBAYARAN"]?>" /></td>
                                    <td>1. Bank&nbsp;&nbsp;&nbsp;2. Pos&nbsp;&nbsp;&nbsp;3. Kantor Pabean</td>
                                </tr>
                                <tr>
                                    <td>b. Jaminan</td>
                                    <td><input type="text" class="input10" value="" /></td>
                                    <td>1. Tunai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Bank Garansi<br>3. Customs Bond&nbsp;&nbsp;&nbsp;4. Lainnya</td>
                                </tr>
                            </table>
                            <table width="500px" cellspacing="0" cellpadding="0" style="padding-left:-2px">
                                <tr>
                                    <td class="border-tr"></td>
                                    <td class="border-tr" align="center">Nomor</td>
                                    <td class="border-t" align="center">Tanggal</td>
                                </tr>
                                <tr>
                                    <td class="border-tr" align="center">a.</td>
                                    <td class="border-tr" align="center"></td>
                                    <td class="border-t" align="center"></td>
                                </tr>
                                <tr>
                                    <td class="border-tr border-b" align="center">b.</td>
                                    <td class="border-tr border-b" align="center"></td>
                                    <td class="border-t border-b" align="center"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
	</table>
</div>	
<!-- 
$bm_bayar	
$bm_bebas	
$cukai_bayar
$cukai_bebas
$ppn_bayar	
$ppn_bebas	
$ppnbm_bayar
$ppnbm_bebas
$pph_bayar	
$pph_bebas	
$pnbp_bayar	
$pnbp_bebas	
$denda_bayar
$denda_bebas
$bunga_bayar
$bunga_bebas
$total_bayar
$total_bebas 
-->
<?php
$JUM_BARANG = count($BARANG) - 1;
if(count($BARANG)>1){	
	echo "<pagebreak />";	
	$arrdata = array("loop"=>1);  	
	$this->load->view("pengeluaran/bc28/cetak/bc28_lampiran_lanjutan",$arrdata);		
	$loop = round(count($BARANG)/8);
	$x=8;
	if(count($BARANG)>8){
		for($i=0;$i<$loop;$i++){
			$arrdata = array("loop"=>$x); 			
			echo "<pagebreak />";	
			$this->load->view("pengeluaran/bc28/cetak/bc28_lampiran_lanjutan",$arrdata);	
			$x=$x+8;
		}
	}
}  
if(count($DOKUMEN) > 0){ 
	echo "<pagebreak />";	
	$this->load->view("pengeluaran/bc28/cetak/bc28_lampiran_dokumen");
}
if(count($bahanbaku)>0){	
	echo "<pagebreak />";
	$arrdata = array("loop"=>0);  	
	$this->load->view("pengeluaran/bc28/cetak/bc28_lampiran_penggunaan",$arrdata);		
	$loop = floor(count($bahanbaku)/7);
	$x=7;
	if(count($bahanbaku)>7){
		for($i=0;$i<$loop;$i++){
			$arrdata = array("loop"=>$x); 
			echo "<pagebreak />";
			$this->load->view("pengeluaran/bc28/cetak/bc28_lampiran_penggunaan",$arrdata);	
			$x=$x+7;
		}
	}	
}
?>

</body>
