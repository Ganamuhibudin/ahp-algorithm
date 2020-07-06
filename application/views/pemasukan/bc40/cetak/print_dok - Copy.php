<?php
#PARAMETER 
$no_pengajuan	= $DATA['NOMOR_AJU'];
$kantor_pabean	= $DATA['URAIAN_KPBC'];
$jns_tpb		= $DATA['URJENIS_TPB'];
$no_pendaftaran	= $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar		= $DATA['TANGGAL_PENDAFTARAN'];
$tujuan_pengiriman	= $DATA['URTUJUAN_KIRIM'];
$npwp_pengusaha	= $DATA['ID_TRADER'];
$nama_pengusaha	= $DATA['NAMA_TRADER'];
$alamat_pengusaha= $DATA['ALAMAT_TRADER'];
$no_izintpb		= $DATA['NOMOR_IZIN_TPB'];
$npwp_pengirim	= $DATA['ID_PENGIRIM'];
$nama_pengirim	= $DATA['NAMA_PENGIRIM'];
$alamat_pengirim= $DATA['ALAMAT_PENGIRIM'];
$srt_keputusan 	= $DATADOK['NOMOR_SURAT_KEPUTUSAN'];
$tgl_keputusan 	= $DATADOK['TANGGAL_SURAT_KEPUTUSAN'];
$no_packing		= $DATADOK['NOMOR_PACKING_LIST'];
$tgl_packing	= $DATADOK['TANGGAL_PACKING_LIST'];
$no_kontrak		= $DATADOK['NOMOR_KONTRAK'];
$tgl_kontrak	= $DATADOK['TANGGAL_KONTRAK'];
$no_dokumen		= $DATADOK['NOMOR_LAINNYA'];
$tgl_dokumen	= $DATADOK['TANGGAL_LAINNYA'];	
$jns_pengangkut	= $DATA['JENIS_SARANA_ANGKUT'];
$no_polisi		= $DATA['NOMOR_POLISI'];
$harga_penyerahan= $DATA['HARGA_PENYERAHAN'];
$jns_kemasan	= $DATAKMS['URKODE_KEMASAN'];
$jml_kemasan	= $DATAKMS['JUMLAH'];
$merk_kemasan	= $DATAKMS['MERK_KEMASAN'];
$no_urut		= "10";
$uraian_brg		= "7318.15.12.00 BAUT UNTUK LOGAM DARI BESI UNTUK LEMARI DARI BESI MERKSCHAUM, UKURAN 2 INCH";
$kode_penggunaanbrg = "2";
$jml_satuan		= "2.000 PCS";	
$berat_bersihbrg= "25 KG";
$volume_brg		= "12m3";
$volume			= $DATA['VOLUME'];
$berat_kotor	= $DATA['BRUTO'];
$berat_bersih	= $DATA['NETTO'];
$nama_pejabatbea= $DATA['NAMA_PEJABAT_BC'];
$nip_pejabat	= $DATA['NIP_PEJABAT_BC'];
$nama_ttd		= $DATA['NAMA_TTD'];
$kota_ttd		= $DATA['KOTA_TTD'];
$tgl_ttd		= $DATA['TANGGAL_TTD'];

function FormatAju($var){
		if (!is_null($var)){
			$varresult = '';
			$varresult = substr($var,0,6)."-".substr($var,6,6)."-".substr($var,12,8)."-".substr($var,20,6);
			return $varresult;
		}
	}
?>	
	
 <body style="font-size:11pt;">
		<div class="border-tbrl">
	    <table width="100%" cellpadding="0" cellspacing="0"  border="0">
          <tr> 
            <td colspan="8" class="border-b">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="6%" align="center" class="border-r" height="20"><strong>BC 4.0</strong> </td>
                <td width="85%" align="center" height="50"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PEMBERITAHUAN PEMASUKAN BARANG ASAL TEMPAT LAIN DALAM DAERAH PABEAN KE<br>TEMPAT PENIMBUNAN BERIKAT</strong> 
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td colspan="3" class="border-b">HEADER</td>
          </tr>
          <tr>
            <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2">NO PENGAJUAN</td>
                    <td colspan="5">: <?=$this->fungsi->FormatAju($no_pengajuan);?></td>
                    <td width="8%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                  </tr>
                   <tr>
                     <td>A.</td>
                     <td>KANTOR PABEAN </td>
                    <td colspan="4">: <?=$kantor_pabean;?></td>
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
                    <td class="border-t">F.</td>
                    <td colspan="3" class="border-t">KOLOM KHUSUS BEA DAN CUKAI</td>
                  </tr>
                   <tr>
                     <td>C.</td>
                     <td>TUJUAN PENGIRIMAN</td>
                    <td colspan="3">: <?=$tujuan_pengiriman;?></td>
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
                    <td colspan="4" class="border-b">PENGIRIM BARANG</td>
                  </tr>
                  <tr>
                    <td width="2%">1.</td>
                    <td width="16%">NPWP</td>
                    <td colspan="3">: <?=$this->fungsi->FormatNPWP($npwp_pengusaha);?></td>
                    <td width="4%" class="border-r">&nbsp;</td>
                    <td width="1%">5.</td>
                    <td colspan="3">NPWP/KTP/Passport/Lainnya:</td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td>Nama</td>
                    <td colspan="3">: <?=$nama_pengusaha;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td colspan="3"><?=$this->fungsi->FormatNPWP($npwp_pengirim);?></td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td>Alamat</td>
                    <td colspan="3">: <?=$alamat_pengusaha;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>6.</td>
                    <td>Nama</td>
                    <td colspan="2">: <?=$nama_pengirim;?></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>No. Izin TPB</td>
                    <td colspan="3">:&nbsp;&nbsp;<?=$no_izintpb;?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>7.</td>
                    <td>Alamat</td>
                    <td colspan="2">: <?=$alamat_pengirim;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DOKUMEN PELENGKAP PABEAN </td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>Packing List </td>
                    <td colspan="2">: <?=$no_packing;?></td>
                    <td width="23%">tgl <?=$tgl_packing;?></td>
                    <td>&nbsp;</td>
                    <td>10.</td>
                    <td colspan="3">Surat Keputusan Persetujuan :</td>
                  </tr>
                  <tr>
                    <td>9.</td>
                    <td>Kontrak</td>
                    <td colspan="2">:&nbsp;<?=$no_kontrak;?></td>
                    <td>tgl <?=$tgl_kontrak;?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3"><?=$srt_keputusan;?> tgl <?=$tgl_keputusan;?></td>
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
                    <td colspan="3"><?=$no_dokumen;?> tgl <?=$tgl_dokumen;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA PENGANGKUTAN </td>
                  </tr>
                  <tr>
                    <td>12.</td>
                    <td colspan="4">Jenis sarana pengangkut darat : <?=$jns_pengangkut;?></td>
                    <td>&nbsp;</td>
                    <td>13.</td>
                    <td colspan="3">Nomor Polisi : <?=$no_polisi;?></td>
                  </tr>
                  <tr>
                    <td colspan="10" class="border-b border-t">DATA PERDAGANGAN </td>
                  </tr>
                  <tr>
                    <td>14.</td>
                    <td>Harga Penyerahan </td>
                    <td colspan="3">: <?=$harga_penyerahan;?></td>
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
                    <td colspan="3">: <?=$jns_kemasan;?></td>
                    <td>&nbsp;</td>
                    <td>17.</td>
                    <td colspan="3">Jumlah Kemasan : <?=$jml_kemasan;?></td>
                  </tr>
                  <tr>
                    <td>16.</td>
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
                    <td>18.</td>
                    <td>Volume(m3)</td>
                    <td colspan="2">: <?=$volume;?></td>
                    <td>&nbsp;</td>
                    <td colspan="3">19. Berat Kotor(Kg) : <?=$berat_kotor;?></td>
                    <td colspan="2">20.Berat Bersih (Kg) : <?=$berat_bersih;?></td>
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
              <?php if (count($BARANG) <= 1){ ?>
              <?php $no=1;?>
              <?php foreach( $BARANG as $bar):?>
		      <tr>
		        <td valign="top" class="border-r"><?=$no;?></td>
		        <td valign="top" class="border-r"><?=$bar['JENIS_BARANG'];?>, <?=$bar['URAIAN_BARANG'];?>, <?=$bar['MERK']?>, <?=$bar['TIPE']?>, <?=$bar['UKURAN']?>, <?=$bar['SPF']?></td>
		        <td class="border-r"><?=$bar['JUMLAH_SATUAN'];?><br><?=$bar['URAIAN_SATUAN'];?><br><?=$bar['NETTO'];?><br><?=$bar['VOLUME'];?></td>
		        <td valign="top"><?=$bar['HARGA_PENYERAHAN'];?></td>
	          </tr>
              <?php  endforeach;?>
              <?php }elseif(count($BARANG) < 1){ ?>
		      <tr>
		        <td class="border-r" height="23" colspan="4" align="center" > === Belum Terdapat data Barang === </td>
	          </tr>
              <?php }else{ ?>
		      <tr>
		        <td height="23" class="border-r" colspan="4"  align="center"> === <?=count($BARANG)?> Jenis Barang. Lihat lembar lanjutan ===</td>
	          </tr>
              <?php } ?>
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
		    <td align="center"><?=$kota_ttd;?> tgl <?=$tgl_ttd;?></td>
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
		    <td align="center">(<?=$nama_ttd;?>)</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td  class="border-r">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
        </table>
</div>
<pagebreak  />
   <?php
   if (count($BARANG) > 1){ 
   $this->load->view("pemasukan/bc40/cetak/bc40_lampiran_lanjutan");
   }
   $this->load->view("pemasukan/bc40/cetak/bc40_lampiran_dokumen");
   ?>

</body>