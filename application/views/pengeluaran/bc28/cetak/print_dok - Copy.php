<?php
#PARAMETER 
$no_pengajuan	= $DATA['NOMOR_AJU'];
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
$tgl_invoce		= $DATADOK['TANGGAL_INVOIVE'];
$srt_keputusan 	= $DATADOK['NOMOR_SURAT_KEPUTUSAN'];
$tgl_keputusan 	= $DATADOK['TANGGAL_SURAT_KEPUTUSAN'];
$no_packing		= $DATADOK['NOMOR_PACKING_LIST'];
$tgl_packing	= $DATADOK['TANGGAL_PACKING_LIST'];
$no_kontrak		= $DATADOK['NOMOR_KONTRAK'];
$tgl_kontrak	= $DATADOK['TANGGAL_KONTRAK'];
$no_dokumen		= $DATADOK['NOMOR_LAINNYA'];
$tgl_dokumen	= $DATADOK['TANGGAL_LAINNYA'];	
$jns_valuta		= $DATA['URAIAN_VALUTA'];
$cif			= $DATA['CIF'];
$nilai_cif		= $DATA['SNRF'];
$ndpbm			= $DATA['NDPBM'];
$hrg_penyerahan	= $DATA['HARGA_PENYERAHAN'];
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
$bm_bebas		= ($DATAPGT['PGT_BM_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM_STATUS'],0):0;
$cukai_bayar	= ($DATAPGT['PGT_CUKAI']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI'],0):0;
$cukai_bebas	= ($DATAPGT['PGT_CUKAI_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI_STATUS'],0):0;
$ppn_bayar		= ($DATAPGT['PGT_PPN']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN'],0):0;
$ppn_bebas		= ($DATAPGT['PGT_PPN_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN_STATUS'],0):0;
$ppnbm_bayar	= ($DATAPGT['PGT_PPNBM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM'],0):0;
$ppnbm_bebas	= ($DATAPGT['PGT_PPNBM_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM_STATUS'],0):0;
$pph_bayar		= ($DATAPGT['PGT_PPH']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH'],0):0;
$pph_bebas		= ($DATAPGT['PGT_PPH_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH_STATUS'],0):0;
$pnbp_bayar		= ($DATAPGT['PGT_PNBP']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PNBP'],0):0;
$pnbp_bebas		= ($DATAPGT['PGT_PNBP_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PNBP_STATUS'],0):0;
$denda_bayar	= ($DATAPGT['PGT_DENDA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_DENDA'],0):0;
$denda_bebas	= ($DATAPGT['PGT_DENDA_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_DENDA_STATUS'],0):0;
$bunga_bayar	= ($DATAPGT['PGT_BUNGA']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BUNGA'],0):0;
$bunga_bebas	= ($DATAPGT['PGT_BUNGA_STATUS']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BUNGA_STATUS'],0):0;
$total_bayar	= $this->fungsi->FormatRupiah(str_replace(',','',$bm_bayar)+str_replace(',','',$cukai_bayar)+str_replace(',','',$ppn_bayar)+str_replace(',','',$ppnbm_bayar)+str_replace(',','',$pph_bayar)+str_replace(',','',$pnbp_bayar)+str_replace(',','',$denda_bayar)+str_replace(',','',$bunga_bayar),0);
$total_bebas	= $this->fungsi->FormatRupiah(str_replace(',','',$bm_bebas)+str_replace(',','',$cukai_bebas)+str_replace(',','',$ppn_bebas)+str_replace(',','',$ppnbm_bebas)+str_replace(',','',$pph_bebas)+str_replace(',','',$pnbp_bebas)+str_replace(',','',$denda_bebas)+str_replace(',','',$bunga_bebas),0);
$volume			= $DATA['VOLUME'];
$berat_kotor	= $DATA['BRUTO'];
$berat_bersih	= $DATA['NETTO'];
$nama_ttd		= $DATA['NAMA_TTD'];
$kota_ttd		= $DATA['KOTA_TTD'];
$tgl_ttd		= $DATA['TANGGAL_TTD'];
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
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tl {border-top:thin solid #000000;border-left:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tb {border-top:thin solid #000000;border-bottom:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input10{padding-left:5px;padding-right:5px;width:10px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
</style>
				
<body style="font-size:11;">
<?php 
if($SURAT['NOMOR_AJU']){
	$this->load->view("surat/surat");
	$this->load->view("surat/lampiran");
	}
?>
	<div style="padding:30px 50px 30px 50px;">
		<!--<table align="center" style="width:100%; padding-left:50px; padding-right:50px;">
          <tr>
            
          </tr>
        </table>-->
		<div class="border-tbrl">
	    <table width="100%" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center">
                <td width="16%" align="center" class="border-r" height="50"><strong>BC 2.5</strong> </td>
                <td width="84%" align="center" height="50"><strong>PEMBERITAHUAN IMPOR BARANG DARI TEMPAT PENIMBUNAN BERIKAT</strong> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0">
                <tr>
                  <td>HEADER </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2">NO PENGAJUAN</td>
                    <td colspan="3">: <?=$no_pengajuan;?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right">Halaman 1 dari............</td>
                  </tr>
                   <tr>
                     <td>A.</td>
                     <td>KANTOR PABEAN </td>
                    <td colspan="3">: <?=$kantor_pabean;?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                   <tr>
                     <td>B.</td>
                     <td>JENIS TPB </td>
                    <td colspan="3">: <?=$jns_tpb;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td class="border-t">H.</td>
                    <td colspan="3" class="border-t">KOLOM KHUSUS BEA DAN CUKAI</td>
                  </tr>
                   <tr>
                     <td>C.</td>
                     <td>JENIS BC 2.5 </td>
                    <td width="7%">:1. Biasa</td>
                    <td width="8%">2. Berkala </td>
                    <td><input type="text" name="jns_bc" class="input10" value="<?=$jns_bc;?>"></td>
                    <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Nomor Pendaftaran</td>
                    <td colspan="2">: <?=$no_pendaftaran;?></td>
                  </tr>
                   <tr>
                     <td>D.</td>
                     <td>KONDISI BARANG </td>
                     <td>:1. Baik </td>
                     <td>2. Rusak </td>
                     <td><input type="text" name="kondisi_brg" class="input10" value="<?=$kondisi_brg;?>"></td>
                     <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Tanggal</td>
                    <td colspan="2">: <?=$tgl_daftar;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">E. DATA PEMBERITAHUAN </td>
                  </tr>
                  <tr>
                    <td colspan="6" class="border-br">PENGUSAHA TPB </td>
                    <td colspan="4" class="border-b">PENERIMA BARANG</td>
                  </tr>
                  <tr>
                    <td width="3%">1.</td>
                    <td width="16%">NPWP</td>
                    <td colspan="3">: <?=npwp_pengusaha;?></td>
                    <td width="6%" class="border-r">&nbsp;</td>
                    <td width="3%">5.</td>
                    <td width="15%">NPWP</td>
                    <td colspan="2">: <?=$npwp_penerima;?></td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td>Nama</td>
                    <td colspan="3">: <?=$nama_pengusaha;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>6.</td>
                    <td>Nama</td>
                    <td colspan="2">: <?=$nama_penerima;?></td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td>Alamat</td>
                    <td colspan="3">: <?=$alamat_pengusaha;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>7.</td>
                    <td>Alamat</td>
                    <td colspan="2">: <?=$alamat_penerima;?></td>
                  </tr>
                  
                  <tr>
                    <td>4.</td>
                    <td>No. Izin TPB </td>
                    <td colspan="3">: <?=$no_izintpb;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>8.</td>
                    <td>NIPER</td>
                    <td colspan="2">: <?=$niper;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DOKUMEN PELENGKAP PABEAN </td>
                  </tr>
                  <tr>
                    <td width="3%">9.</td>
                    <td width="16%">Invoice</td>
                    <td colspan="2">: <?=$invoce;?></td>
                    <td width="13%">tgl <?=$tgl_invoce;?></td>
                    <td>&nbsp;</td>
                    <td>12.</td>
                    <td colspan="3">Surat Keputusan Persetujuan : </td>
                  </tr>
                  <tr>
                    <td>10.</td>
                    <td>Packing List </td>
                    <td colspan="2">: <?=$no_packing;?></td>
                    <td>tgl <?=$tgl_packing;?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3"><?=$srt_keputusan;?>tgl <?=$tgl_keputusan;?></td>
                  </tr>
                  <tr>
                    <td>11.</td>
                    <td>Kontrak</td>
                    <td colspan="2">: <?=$no_kontrak;?></td>
                    <td>tgl <?=$tgl_kontrak?></td>
                    <td>&nbsp;</td>
                    <td>13.</td>
                    <td colspan="3">Jenis/ nomor/ tanggal dokumen lainnya : </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3"><?=$no_dokumen;?> tgl <?=$tgl_dokumen;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA PERDAGANGAN </td>
                  </tr>
                  <tr>
                    <td>14.</td>
                    <td>Jenis Valuta Asing </td>
                    <td colspan="3">: <?=$jns_valuta;?></td>
                    <td>&nbsp;</td>
                    <td>16.</td>
                    <td>Nilai CIF</td>
                    <td width="3%" align="right">:</td>
                    <td width="26%"><?=$cif;?></td>
                  </tr>
                  <tr>
                    <td>15.</td>
                    <td>NDPBM</td>
                    <td colspan="3">: <?=$ndpbm;?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Rp:</td>
                    <td><?=$nilai_cif;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>17.</td>
                    <td>Harga Penyerahan </td>
                    <td>Rp:</td>
                    <td><?=$hrg_penyerahan;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA PENGEMAS</td>
                  </tr>
                  <tr>
                    <td>18.</td>
                    <td>Jenis Kemasan </td>
                    <td colspan="3">: <?=$jns_kemasan;?></td>
                    <td>&nbsp;</td>
                    <td>20.</td>
                    <td>Jumlah Kemasan </td>
                    <td colspan="2">: <?=$jml_kemasan;?></td>
                  </tr>
                  <tr>
                    <td>19.</td>
                    <td>Merk Kemasan </td>
                    <td colspan="3">: <?=$merk_kemasan;?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA BARANG</td>
                  </tr>
                  <tr>
                    <td>21.</td>
                    <td>Volume(m3)</td>
                    <td colspan="2">: <?=$volume;?></td>
                    <td>&nbsp;</td>
                    <td colspan="3">22. Berat Kotor(Kg) : <?=$berat_kotor;?></td>
                    <td colspan="2">23.Berat Bersih (Kg) : <?=$berat_bersih;?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
		    <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="3%" class="border-r">24.</td>
                <td width="42%" class="border-r">25.</td>
                <td width="14%" class="border-r">26.</td>
                <td width="9%" class="border-r">27.</td>
                <td width="10%" class="border-r">28.</td>
                <td width="13%" class="border-r">29.</td>
                <td width="9%">30.</td>
              </tr>
              <tr>
                <td valign="top" class="border-br">No</td>
                <td valign="top" class="border-br">Pos tarif/ HS, uraian jumlah dan jenis barang secara lengkap, kode                barang, merk, tipe, ukuran, dan spesifikasi lain </td>
                <td valign="top" class="border-br">Kode Penggunaan Barang </td>
                <td valign="top" class="border-br">Negara Asal Barang </td>
                <td valign="top" class="border-br">- Skema Tarif<br>
                - Tarif </td>
                <td valign="top" class="border-br">- Jumlah &amp; Jenis<br>
                Satuan<br>
                - Berat Bersih kg)<br>- Volume (m3) </td>
                <td valign="top" class="border-b">- Nilai CIF<br>
                - Harga Penyerahan </td>
              </tr>
              <?php if (count($BARANG) <= 1){ ?>
               <?php $no=1;?>
              <?php foreach( $BARANG as $bar):?>
              <tr>
                <td class="border-r"><?= $no;?></td>
                <td  valign="top" class="border-r"><?=$bar['KODE_HS'];?><br><?=$bar['URAIAN_BARANG'];?>, <?=$bar['MERK']?>, <?=$bar['TIPE']?></td>
                <td class="border-r"><?=$bar['URAIAN_PENGGUNAAN'];?></td>
                <td class="border-r"><?=$bar['URAIAN_NEGARA'];?></td>
                <td class="border-r"><?="BM ".$bar['TRF_BM']."%, "?><?="PPN ".$bar['TRF_PPN']."%, "?><br><?="PPnBM ".$bar['TRF_PPNBM']."%, "?><?="PPh "."2,5%,"?></td>
                <td class="border-r"><?=$bar['JUMLAH_BM'];?><br><?=$bar['URAIAN_SATUAN'];?><br><?=$bar['NETTO'];?><br><?=$bar['VOLUME'];?></td>
                <td><?=$bar['CIF'];?><br><?=$bar['HARGA_PENYERAHAN'];?></td>
              </tr>
              <?php  endforeach;?>
              <?php }else{ ?>
			  <tr>
                <td class="border-r">&nbsp;</td>
                <td class="border-r">&nbsp;</td>
                <td class="border-r">&nbsp;</td>
                <td class="border-r">&nbsp;</td>
                <td class="border-r">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <?php } ?>
			  
              <tr>
                <td colspan="2" align="center" class="border-tr">DATA PENERIMAAN NEGARA </td>
                <td colspan="5" align="center" class="border-t" >BUKTI PEMBAYARAN </td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="3" class="border-b"><table width="100%" border="0">
              <tr>
                <td width="69%"  class="border-r"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2" align="center" class="border-br">Jenis Pungutan </td>
                    <td width="18%" align="center" class="border-br">Dibayar(Rp)</td>
                    <td width="18%" align="center" class="border-b">Dibebaskan (Rp) </td>
                  </tr>
                  <tr>
                    <td width="4%" align="right" class="border-b">31.</td>
                    <td width="60%" class="border-br">BM</td>
                    <td class="border-br"  align="right"><?=$bm_bayar;?></td>
                    <td class="border-b"  align="right"><?=$bm_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right" class="border-b">32.</td>
                    <td class="border-br">Cukai</td>
                    <td class="border-br"  align="right"><?=$cukai_bayar;?></td>
                    <td class="border-b"  align="right"><?=$cukai_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right" class="border-b">33.</td>
                    <td class="border-br">PPN</td>
                    <td class="border-br"  align="right"><?=$ppn_bayar;?></td>
                    <td class="border-b"  align="right"><?=$ppn_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right" class="border-b">34.</td>
                    <td class="border-br" >PPnBm</td>
                    <td class="border-br"  align="right"><?=$ppnbm_bayar;?></td>
                    <td class="border-b"  align="right"><?=$ppnbm_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right"class="border-b">35.</td>
                    <td class="border-br">PPh</td>
                    <td class="border-br"  align="right"><?=$pph_bayar;?></td>
                    <td class="border-b"  align="right"><?=$pph_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right" class="border-b">36.</td>
                    <td class="border-br">PNBP</td>
                    <td class="border-br"  align="right"><?=$pnbp_bayar;?></td>
                    <td class="border-b"  align="right"><?=$pnbp_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right" class="border-b">37.</td>
                    <td class="border-br">Denda / bunga BM dan cukai (D/B) </td>
                    <td class="border-br"  align="right"><?=$denda_bayar;?></td>
                    <td class="border-b"  align="right"><?=$denda_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right" class="border-b">38.</td>
                    <td class="border-br">Bunga PPN dan PPnBM </td>
                    <td class="border-br"  align="right"><?=$bunga_bayar;?></td>
                    <td class="border-b"  align="right"><?=$bunga_bebas;?></td>
                  </tr>
                  <tr>
                    <td align="right">39.</td>
                    <td class="border-r">Total</td>
                    <td class="border-r"  align="right"><?=$total_bayar;?></td>
                    <td  align="right"><?=$total_bebas;?></td>
                  </tr>
                </table></td>
                <td width="31%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="15%">SSCP</td>
                    <td width="2%">&nbsp;</td>
                    <td width="12%">No : </td>
                    <td width="44%"><?=$no_sscp;?></td>
                    <td width="5%">tgl</td>
                    <td width="22%"><?=$tgl_sscp;?></td>
                  </tr>
                  <tr>
                    <td style="padding-left:20px;">NTB</td>
                    <td>&nbsp;</td>
                    <td>No : </td>
                    <td><?=$no_ntbsscp;?></td>
                    <td>tgl</td>
                    <td><?=$tgl_ntbsscp;?></td>
                  </tr>
                  <tr>
                    <td style="padding-left:20px;">NTPN</td>
                    <td>&nbsp;</td>
                    <td>No : </td>
                    <td><?=$no_ntpnsscp;?></td>
                    <td>tgl</td>
                    <td><?=$tgl_ntpnsscp;?></td>
                  </tr>
                  <tr>
                    <td>SSP</td>
                    <td>&nbsp;</td>
                    <td>No : </td>
                    <td><?=$no_ssp;?></td>
                    <td>tgl</td>
                    <td><?=$tgl_ssp;?></td>
                  </tr>
                  <tr>
                    <td style="padding-left:20px;">NTB</td>
                    <td>&nbsp;</td>
                    <td>No : </td>
                    <td><?=$no_ntbssp;?></td>
                    <td>tgl</td>
                    <td><?=$tgl_ntbssp;?></td>
                  </tr>
                  <tr>
                    <td style="padding-left:20px;">NTPN</td>
                    <td>&nbsp;</td>
                    <td>No : </td>
                    <td><?=$no_ntpnssp;?></td>
                    <td>tgl</td>
                    <td><?=$tgl_ntpnssp;?></td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" align="center">Nama / Stempel Instansi </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" align="center">ttd</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" align="center">(.....................)</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" align="center">Pejabat Penerima </td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td width="36%" class="border-br">I. CATATAN PEJABAT BEA DAN CUKAI </td>
	        <td width="42%" class="border-br">F. TANDA TANGAN PENGUSAHA TPB </td>
	        <td width="22%" class="border-b">G. PENERIMA BARANG </td>
		  </tr>
		  <tr>
		    <td class="border-r">&nbsp;</td>
		    <td class="border-r">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>
		    <td align="center">......................tgl......................</td>
	      </tr>
		  <tr>
		    <td class="border-r">&nbsp;</td>
		    <td align="center" class="border-r"><?=$kota_ttd;?>, tgl <?=$tgl_ttd;?></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td class="border-r">&nbsp;</td>
		    <td align="center" class="border-r">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td class="border-r">&nbsp;</td>
		    <td align="center" class="border-r">(<?=$nama_ttd;?>)</td>
		    <td align="center">(<?=$nama_penerima;?>)</td>
	      </tr>
        </table>
	  </div>
</div>
<pagebreak />
 <?php
   if (count($BARANG) > 1){ 
   $this->load->view("pengeluaran/bc25/cetak/bc25_lampiran_lanjutan");
   }
   $this->load->view("pengeluaran/bc25/cetak/bc25_lampiran_dokumen");
   $this->load->view("pengeluaran/bc25/cetak/bc25_lampiran_penggunaan");
 ?>
   
</body>
