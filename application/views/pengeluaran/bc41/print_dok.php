<?php
#PARAMETER 
$no_pengajuan	= "050300-000001-20061130-0000100";
$kantor_pabean	= "050300 KPPBC BOGOR";
$jns_tpb		= "KAWASAN BERIKAT";
$no_pendaftaran	= "..................";
$tgl_daftar		= "..................";
$tujuan_pengiriman	= "JAKARTA";
$npwp_pengusaha	= "01.061.747.0-092.000";
$nama_pengusaha	= "PT. INTERNASIONAL INDUSTRI";
$alamat_pengusaha1= "KAWASAN INDUSTRI JABABEKA";
$alamat_pengusaha2= "CIKARANG, BEKASI, JAWA BARAT";
$no_izintpb		= "999/KMK.04/2009";
$npwp_penerima	= "01.067.747.0-999.000";
$nama_penerima	= "PT. ZAHIRA MANUFACTUR";
$alamat_penerima= "JL.AHMAD YANI";
$srt_keputusan 	= "023/KM.4/2009";
$tgl_keputusan 	= "22/11/2009";
$no_packing		= "PL-00009-999999";
$tgl_packing	= "24/12/2009";
$no_kontrak		= "SK-050802";
$tgl_kontrak	= "24/12/2009";
$no_dokumen		= "99/DEPERIN/2009";
$tgl_dokumen	= "22/10/2011";	
$jns_pengangkut	= "TRUK BOX";
$no_polisi		= "B 111 LA";
$harga_penyerahan= "2.000.000";
$jns_kemasan	= "CT CARTON";
$jml_kemasan	= "100";
$merk_kemasan	= "HANSON BROTHERS";
$no_urut		= "10";
$uraian_brg		= "7318.15.12.00 BAUT UNTUK LOGAM DARI BESI UNTUK LEMARI DARI BESI MERKSCHAUM, UKURAN 2 INCH";
$kode_penggunaanbrg = "2";
$jml_satuan		= "2.000 PCS";	
$berat_bersihbrg= "25 KG";
$volume_brg		= "12m3";
$volume			= "100";
$berat_kotor	= "998,00";
$berat_bersih	= "550,00";
$nama_pejabatbea= "VERI BUTIR ANGGRIAWAN";
$nip_pejabat	= "021281015";
?>	
	<style type="text/css">
				.border-t {
						border-top:thin solid #000000;
						}
				.border-b {
							border-bottom:thin solid #000000;
							}
				.border-r {
							border-right:thin solid #000000;
							}
							
				.border-br {
							border-bottom:thin solid #000000;
							border-right:thin solid #000000;
							}
				.border-tbrl {
							border-top:thin solid #000000;
							border-bottom:thin solid #000000;
							border-right:thin solid #000000;
							border-left:thin solid #000000;
							}
				</style>
				
<body style="font-size:10px;">
	<div style="padding:30px 50px 30px 50px;">
<table style="padding-left:50px; padding-right:50px;" align="right">
			<tr>
				<td>Lampiran I <br>
			  Peraturan Direktur Jendral Bea dan<br>Cukai Nomor : P-22/BC/2009 tentang<br>
			  Pemberitahuan Pabean Dakam Rangka Pemasukan Barang Dari Tempat Lain<br>Dalam Daerah Pabean Ke Tempat Yang Berada<br>Dibawah Pengawasan Direktorat Jenderal Bea Dan<br>Cukai</td>
			</tr>
	  </table>
     
		<table align="center" style="width:100%; padding-left:50px; padding-right:50px;">
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
        </table>
		<div class="border-tbrl">
	    <table width="100%" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr align="center">
                <td width="16%" align="center" class="border-r" height="50"><strong>BC 4.0</strong> </td>
                <td width="84%" align="center" height="50"><strong>PEMBERITAHUAN PEMASUKAN BARANG ASAL TEMPAT LAIN DALAM DAERAH PABEAN KE<br>TEMPAT PENIMBUNAN BERIKAT</strong> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3" class="border-b">HEADER</td>
          </tr>
          <tr>
            <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2">NO PENGAJUAN</td>
                    <td colspan="3">: <?=$DATA['NOMOR_AJU'];?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="8%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right">Halaman 1 dari............</td>
                  </tr>
                   <tr>
                     <td>A.</td>
                     <td>KANTOR PABEAN </td>
                    <td colspan="3">: <?=$DATA['URAIAN_KPBC'];?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                   <tr>
                     <td>B.</td>
                     <td>JENIS TPB </td>
                    <td colspan="3">: <?=$DATA['URKODE_TPB'];?></td>
                    <td class="border-r">&nbsp;</td>
                    <td class="border-t">F.</td>
                    <td colspan="3" class="border-t">KOLOM KHUSUS BEA DAN CUKAI</td>
                  </tr>
                   <tr>
                     <td>C.</td>
                     <td>TUJUAN PENGIRIMAN</td>
                    <td colspan="3">: <?=$DATA['URTUJUAN_KIRIM'];?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Nomor Pendaftaran</td>
                    <td colspan="2">: <?=$no_pendaftaran;?></td>
                  </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td width="19%">&nbsp;</td>
                     <td width="1%">&nbsp;</td>
                     <td>&nbsp;</td>
                     <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Tanggal</td>
                    <td colspan="2">: <?=$tgl_daftar;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">D. DATA PEMBERITAHUAN </td>
                  </tr>
                  <tr>
                    <td colspan="6" class="border-br">PENGUSAHA TPB </td>
                    <td colspan="4" class="border-b">PENERIMA BARANG</td>
                  </tr>
                  <tr>
                    <td width="2%">1.</td>
                    <td width="16%">NPWP</td>
                    <td colspan="3">: <?=$this->fungsi->FORMATNPWP($DATA['ID_PARTNER']);?></td>
                    <td width="4%" class="border-r">&nbsp;</td>
                    <td width="2%">5.</td>
                    <td colspan="3">NPWP/KTP/Passport/Lainnya:</td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td>Nama</td>
                    <td colspan="3">: <?=$DATA['NAMA_PARTNER'];?></td>
                    <td class="border-r">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2"><?=$this->fungsi->FORMATNPWP($DATA['ID_TRADER']);?></td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td>Alamat</td>
                    <td colspan="3">: <?=$DATA['ALAMAT_PARTNER'];?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>6.</td>
                    <td>Nama</td>
                    <td colspan="2">: <?=$DATA['NAMA_TRADER'];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;&nbsp;</td>
                    <td class="border-r">&nbsp;</td>
                    <td>7.</td>
                    <td>Alamat</td>
                    <td colspan="2">: <?=$DATA['ALAMAT_TRADER'];?></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>No. Izin TPB </td>
                    <td colspan="3">: <?=$no_izintpb;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DOKUMEN PELENGKAP PABEAN </td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>Packing List </td>
                    <td colspan="2">: <?=$DATADOK['NOMOR_PACK'];?></td>
                    <td width="23%">tgl <?=$this->fungsi->FormatDate($DATADOK['TANGGAL_PACK']);?></td>
                    <td>&nbsp;</td>
                    <td>10.</td>
                    <td colspan="3">Surat Keputusan Persetujuan :</td>
                  </tr>
                  <tr>
                    <td>9.</td>
                    <td>Kontrak</td>
                    <td colspan="2">: <?=$DATADOK['NOMOR_KONTRAK'];?></td>
                    <td>tgl <?=$this->fungsi->FormatDate($DATADOK['TANGGAL_KONTRAK']);?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3"><?=$srt_keputusan.'tgl '.$tgl_keputusan;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>11.</td>
                    <td colspan="3">Jenis/ nomor/ tanggal dokumen lainnya :</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3"><?=$no_dokumen.'tgl '.$tgl_dokumen;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA PENGANGKUTAN </td>
                  </tr>
                  <tr>
                    <td>12.</td>
                    <td colspan="4">Jenis sarana pengangkut darat : <?=$DATA['JENIS_SARANA_ANGKUT'];?></td>
                    <td>&nbsp;</td>
                    <td>13.</td>
                    <td colspan="3">Nomor Polisi : <?=$DATA['NOMOR_ANGKUT'];?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA PERDAGANGAN </td>
                  </tr>
                  <tr>
                    <td>14.</td>
                    <td>Harga Penyerahan </td>
                    <td colspan="3">: <?=$this->fungsi->FormatRupiah($DATA['HARGA']);?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="6%" align="right">&nbsp;</td>
                    <td width="19%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA PENGEMAS</td>
                  </tr>
                  <tr>
                    <td>15.</td>
                    <td>Jenis Kemasan </td>
                    <td colspan="3">: <?=$DATAKMS['URAIAN_KEMASAN'];?></td>
                    <td>&nbsp;</td>
                    <td>17.</td>
                    <td colspan="3">Jumlah Kemasan : <?=$DATAKMS['JUMLAH'];?></td>
                  </tr>
                  <tr>
                    <td>16.</td>
                    <td>Merk Kemasan </td>
                    <td colspan="3">: <?=$DATAKMS['MERK'];?></td>
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
                    <td>18.</td>
                    <td>Volume(m3)</td>
                    <td colspan="2">: <?=$DATA['VOLUME'];?></td>
                    <td>&nbsp;</td>
                    <td colspan="3">19. Berat Kotor(Kg) : <?=$DATA['BRUTO'];?></td>
                    <td colspan="2">20.Berat Bersih (Kg) : <?=$DATA['NETTO'];?></td>
                  </tr>
                </table></td>
          </tr>
          
		  <tr>
		    <td colspan="3"><table width="100%" border="0" cellpadding="2" cellspacing="0">
		      <tr>
		        <td width="7%" class="border-r">21.</td>
		        <td width="73%" class="border-r">22.</td>
		        <td width="11%" class="border-r">23.</td>
		        <td width="9%">28.</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-br">No</td>
		        <td valign="top" class="border-br">Uraian jumlah dan jenis barang secara lengkap, Kode Barang merk, tipe, ukuran, dan spesifikasi lainya. </td>
		        <td valign="top" class="border-br">- Jumlah &amp; Jenis<br>
		          Satuan<br>
		          - Berat Bersih (kg)<br>
		          - Volume (m3) </td>
		        <td valign="top" class="border-b">Harga Penyerahan<br></td>
	          </tr>
		      <tr>
		        <td rowspan="3" valign="top" class="border-r"><?=$no_urut;?></td>
		        <td rowspan="3" valign="top" class="border-r"><?=$DATABRG['URAIAN_BARANG'];?></td>
		        <td class="border-r"><?=$DATABRG['JUMLAH_SATUAN'];?></td>
		        <td><?=$DATABRG['HARGA_PENYERAHAN'];?></td>
	          </tr>
		      <tr>
		        <td class="border-r"><?=$DATABRG['NETTO'];?></td>
		        <td>&nbsp;</td>s
	          </tr>
		      <tr>
		        <td height="23" class="border-r"><?=$DATA['VOLUME'];?></td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td valign="top" class="border-r">&nbsp;</td>
		        <td height="23" class="border-r">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
	        </table></td>
         </tr>
		  <tr>
		    <td colspan="2" class="border-br border-t">G. UNTUK PEJABAT BEA DAN CUKAI</td>
		    <td width="358" class="border-b border-t">E.TANDA TANGAN PENGUSAHA TPB</td>
		  </tr>
		  <tr>
		    <td width="399">&nbsp;</td>
		    <td width="110"  class="border-r">&nbsp;</td>
		    <td>Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini.</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td  class="border-r">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td align="center"  class="border-r">&nbsp;</td>
		    <td align="center"><?=$DATA['KOTA_TTD'].', tgl '.$DATA['TANGGAL_TTD'];?></td>
	      </tr>
		  <tr>
		    <td rowspan="2" align="right"><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
		      <tr>
		        <td width="37">Nama</td>
		        <td width="10">:</td>
		        <td width="279"><?=$nama_pejabatbea;?></td>
	          </tr>
		      <tr>
		        <td>NIP</td>
		        <td>:</td>
		        <td><?=$nip_pejabat;?></td>
	          </tr>
	        </table></td>
		    <td  class="border-r">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td align="center"  class="border-r">&nbsp;</td>
		    <td align="center">(<?=$DATA['NAMA_TTD'];?>)</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td  class="border-r">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
        </table>
	  </div>
	
</div>
</body>