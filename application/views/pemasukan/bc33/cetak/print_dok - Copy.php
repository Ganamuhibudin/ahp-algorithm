<html>
<head></head>
<?php
#PARAMETER 
$no_pengajuan	= $this->fungsi->FormatAju($DATA['NOMOR_AJU']);
$kode_kantor_pabean	= $DATA['KODE_KPBC'];
$kantor_pabean	= $DATA['URAIAN_KPBC'];
$jenis_ekspor	= $DATA['URJENIS_EKSPOR'];
$no_pendaftaran	= $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar		= $DATA['TANGGAL_PENDAFTARAN'];
$kategori_ekspor= $DATA['URKATEGORI_EKSPOR'];
$cara_perdagangan = $DATA['URCARA_DAGANG'];
$cara_pembayaran	= $DATA['URCARA_BAYAR'];
$no_bc			= $DATA['NOMOR_BC11'];
$tgl_bc			= ($DATA['TANGGAL_BC11']=='0000-00-00')?'':$DATA['TANGGAL_BC11'];
$no_pos			= $DATA['NOMOR_POS'];
$no_subpos		= $DATA['SUB_POS'];

$tipeid_pengusaha= $DATA['KODE_ID_TRADERUR'];
$npwp_pengusaha	= $DATA['ID_TRADER'];
$nama_pengusaha	= $DATA['NAMA_TRADER'];
$alamat_pengusaha= $DATA['ALAMAT_TRADER'];
$niper			= $DATA['NIPER'];
$status			= $DATA['URSTATUS_TRADER'];
$no_tdp			= $DATA['NOMOR_TDP'];
$tgl_tdp		= $DATA['TANGGAL_TDP'];
$nama_penerima	= $DATA['NAMA_PEMBELI'];
$alamat_penerima= $DATA['ALAMAT_PEMBELI'];
$cara_angkut	= $DATA['URAIAN_MODA'];
$nama_angkut	= $DATA['NAMA_ANGKUT'];
$nomor_angkut	= $DATA['NOMOR_ANGKUT'];
$bendera_angkut	= $DATA['URAIAN_BENDERA'];
$tgl_perkiraan_ekspor 	= $DATA['TANGGAL_EKSPOR'];
$kode_pelab_muat_asal = $DATA['PELABUHAN_MUAT'];
$urkode_pelab_muat_asal = $DATA['URAIAN_MUAT'];
$kode_pelab_muat_ekspor = $DATA['PELABUHAN_MUAT_EKSPOR'];
$urkode_pelab_muat_ekspor = $DATA['URAIAN_MUAT_EKSPOR'];
$kode_pelab_transit = $DATA['PELABUHAN_TRANSIT'];
$urkode_pelab_transit = $DATA['URAIAN_TRANSIT'];
$kode_pelab_bongkar = $DATA['PELABUHAN_BONGKAR'];
$urkode_pelab_bongkar = $DATA['URAIAN_BONGKAR'];
$no_invoice		= $DATADOK['NOMOR_INVOICE'];
$tgl_invoice	= $DATADOK['TANGGAL_INVOICE'];
$no_packing		= $DATADOK['NOMOR_PACKING_LIST'];
$tgl_packing	= $DATADOK['TANGGAL_PACKING_LIST'];
$lokasi_pemeriksaan = $DATA['LOKASI_PERIKSA'];
$kantor_pabean_pemeriksa = $DATA['URAIAN_KPBC_PERIKSA'];
$kodenegara_tujuan_ekspor = $DATA['NEGARA_TUJUAN'];
$negara_tujuan_ekspor = $DATA['URAIAN_NEGARA_TUJUAN'];
$freight		= $DATA['FREIGHT'];
$asuransi		= $DATA['ASURANSI'];
$fob			= $DATA['FOB'];
$petikemas		= ($DATACNT['NOMOR']!="")?"Ya":"Tidak";
$stat_petikemas	= ($DATACNT['URTIPE'])?$DATACNT['URTIPE']:"-";
$jml_petikemas 	= ($DATACNT['JUMLAH_CNT'])?$DATACNT['JUMLAH_CNT']:"0";
$volume			= $DATA['VOLUME'];
$berat_kotor	= $DATA['BRUTO'];
$berat_bersih	= $DATA['NETTO'];
$no_petikemas	= $DATACNT['NOMOR'];
$kode_kemasan	= $DATAKMS['KODE_KEMASAN'];
$uraian_kemasan	= $DATAKMS['URAIAN_KEMASAN'];
$jml_kemasan	= $DATAKMS['JUMLAH'];
$merk_kemasan	= $DATA['MERK_KEMASAN'];
$nama_ttd		= $DATA['NAMA_TTD'];
$tgl_ttd		= $DATA['TANGGAL_TTD'];
$kota_ttd		= $DATA['KOTA_TTD'];
$pejabat_penerima = "...............";
$kode_valuta = $DATA['KODE_VALUTA'];
$uraian_valuta = $DATA['URAIAN_VALUTA'];
$pnbp = $this->fungsi->FormatRupiah($DATA['PNBP'],2);
$cara_penyerahan_barang = $DATA['CARA_PENYERAHAN_BARANG'];
$daerah_asal_barang = $DATA['PROPINSI_BARANG'];

?>	
<style type="text/css">
.border-t {border-top:thin solid #000000;}
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-l {border-left:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
</style>

<body style="font-size:11;">				
<?php 
if($SURAT['NOMOR_AJU']){
$this->load->view("surat/surat");
$this->load->view("surat/lampiran");
}
?>
 <div class="border-tbrl">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="8%" align="center" class="border-r border-b"><strong>BC 3.0</strong></td>
	<td width="92%" align="center" class="border-b"><strong>PEMBERITAHUAN EKSPOR BARANG&nbsp;&nbsp;</strong></td>
</tr>
<tr>
	<td colspan="3" class="border-b"><b>HEADER</b></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr> 
    <td colspan="5">
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3" class="border-b">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="10">A. KANTOR PABEAN</td>
              </tr>
               <tr>
                 <td width="3%">&nbsp;</td>
                 <td width="30%">1. Kantor Pabean Pemuatan</td>
                 <td width="1%">:</td>
                <td colspan="3" >: <?=$kode_kantor_pabean;?> &nbsp; <?=$kantor_pabean;?></td>
                <td width="2%" class="border-t border-l"><strong>H.</strong></td>
                <td colspan="3" class="border-t" ><strong>KOLOM KHUSUS BEA DAN CUKAI</strong></td>
              </tr>
              <tr>
                 <td>&nbsp;</td>
                 <td >2. Nomor Pengajuan</td>
                 <td>:</td>
                <td colspan="3" >: <?=$no_pengajuan;?></td>
               <td style="pt" class="border-l">1.</td>
                <td width="15%" style="pt">Nomor Pendaftaran</td>
                 <td width="1%">:</td>
                <td width="24%" colspan="2" style="pt">: <?=$no_pendaftaran;?></td>
              </tr>
               <tr>
                 <td style="font-weight:bold; pt" >B.</td>
                 <td style="font-weight:bold; pt">JENIS EKSPOR</td>
                 <td>:</td>
                <td colspan="3" style="pt">: <?=$jenis_ekspor;?></td>
                <td class="border-l">&nbsp;</td>
                <td style="pt">Tanggal</td>
                 <td>:</td>
                <td colspan="2" style="pt">: <?=$tgl_daftar;?></td>
              </tr>
               <tr>
                 <td style="font-weight:bold; pt">C.</td>
                 <td>KATEGORI EKSPOR</td>
                 <td>:</td>
                <td colspan="3" >: <?=$kategori_ekspor;?></td>
                <td class="border-l">2</td>
                <td >Nomor BC 1.1</td>
                 <td>:</td>
                <td colspan="2" >: <?=$no_bc;?></td>
              </tr>
               <tr>
                 <td ><strong>D.</strong></td>
                 <td>CARA PERDAGANGAN</td>
                 <td>:</td>
                 <td colspan="3" style=";">: <?=$cara_perdagangan;?></td>
                 <td class="border-l">&nbsp;</td>                     
                <td >Tanggal</td>
                 <td>:</td>
                <td colspan="2" >: <?=$tgl_bc;?></td>
              </tr>
              <tr>
                 <td ><strong>E.</strong></td>
                 <td>CARA PEMBAYARAN</td>
                 <td>:</td>
                 <td colspan="3" >: <?=$cara_pembayaran;?></td>
                 <td class="border-l">&nbsp;</td>                     
                <td >Pos/Sub Pos</td>
                 <td>:</td>
                <td colspan="2" >: <?=$no_pos?> / <?=$no_subpos;?></td>
              </tr>
              <tr>
                <td colspan="10" class="border-b border-t" >F. DATA PEMBERITAHUAN </td>
              </tr>
              <tr>
                <td colspan="6" class="border-l border-b">EKSPORTIR </td>
                <td colspan="4" class="border-b border-l">PENERIMA</td>
              </tr>
              <tr>
                <td >1.</td>
                <td >Identitas</td>
                 <td>:</td>
                <td colspan="3" >: <?= $tipeid_pengusaha.' '.$this->fungsi->FORMATNPWP($npwp_pengusaha);?></td>
                <td class="border-l">7.</td>
                <td >Nama</td>
                 <td>:</td>
                <td colspan="2" >: <?=$nama_penerima;?></td>
              </tr>
              <tr>
                <td >2.</td>
                <td >Nama</td>
                 <td>:</td>
                <td colspan="3" >: <?=$nama_pengusaha;?></td>
                <td class="border-l">8.</td>
                <td >Alamat</td>
                 <td>:</td>
                <td colspan="2" >: <?=$alamat_penerima;?></td>
              </tr>
              <tr>
                <td >3.</td>
                <td >Alamat</td>
                 <td>:</td>
                <td colspan="3" >: <?=$alamat_pengusaha;?></td>
                <td class="border-l border-b">&nbsp;</td>
                <td colspan="3" class="border-b">&nbsp;</td>
              </tr>
              <tr>
                <td >4.</td>
                <td >NIPER</td>
                 <td>:</td>
                <td colspan="3">: <?=$niper;?></td>
                <td colspan="4" class="border-l">PPJK</td>
              </tr>
              <tr>
                <td >5.</td>
                <td >Status </td>
                 <td>:</td>
                <td colspan="3" >: <?=$status;?></td>
                <td class="border-l">9.</td>
                <td>NPWP</td>
                <td>: </td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td >6.</td>
                <td >No. & Tgl. TDP </td>
                 <td>:</td>
                <td colspan="3" >: <?=$no_tdp;?><br>&nbsp; <?=$tgl_tdp;?></td>
                <td class="border-l">10.</td>
                <td>Nama</td>
                <td>: </td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
              	<td colspan="6">&nbsp;</td>
              	<td class="border-l">11.</td>
              	<td>Alamat</td>
                <td>: </td>
              	<td>&nbsp;</td>
              </tr>
              <tr>
              	<td colspan="6">&nbsp;</td>
              	<td class="border-l">12.</td>
              	<td>Nomor Pokok PPJK</td>
                <td>: </td>
              	<td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6" class="border-b border-t">DATA PENGANGKUTAN </td>
                <td colspan="4" class="border-b border-l border-t">DATA PELABUHAN</td>
              </tr>
              <tr>
                <td valign="top" >13.</td>
                <td >Cara Pengangkutan</td>
                 <td>:</td>
                <td colspan="3" >: <?=$cara_angkut;?></td>
                <td class="border-l">18.</td>
                <td >Pelabuhan Muat Asal</td>
                <td>: </td>
                <td colspan="2" >: <?=$kode_pelab_muat_asal;?> &nbsp; <?=$urkode_pelab_muat_asal;?></td>
              </tr>
              <tr>
                <td valign="top" >14.</td>
                <td >Nama Sarana Pengangkut</td>
                 <td>:</td>
                <td colspan="3" >: <?=$nama_angkut;?></td>
                <td class="border-l">19.</td>
                <td valign="top" >Pelabuhan Muat Ekspor</td>
                <td>: </td>
                <td colspan="2" >: <?=$kode_pelab_muat_ekspor;?> &nbsp; <?=$urkode_pelab_muat_ekspor;?></td>
              </tr>
              <tr>
                <td valign="top" >15.</td>
                <td >Nomor Pengangkut(Voy/Flight)</td>
                 <td>:</td>
                <td colspan="3" >: <?=$nomor_angkut;?></td>
                <td  class="border-l" >20.</td>
                <td >Pelabuhan Transit LN</td>
                <td>: </td>
                <td colspan="2" >: <?=$kode_pelab_transit;?> &nbsp; <?=$urkode_pelab_transit;?></td>
              </tr>
              <tr>
                <td valign="top" class="border-b" >16.</td>
                <td class="border-b" >Bendera Sarana Pengangkut</td>
                 <td>:</td>
                <td colspan="3" class="border-b" >: <?=$bendera_angkut;?></td>
                <td class="border-l" >21.</td>
                <td >Pelabuhan Bongkar</td>
                <td>: </td>
                <td colspan="2" >: <?=$kode_pelab_bongkar;?> &nbsp; <?=$urkode_pelab_bongkar;?></td>
              </tr>
              <tr>
                <td valign="top" >17.</td>
                <td >Tanggal Perkiraan Ekspor</td>
                 <td>:</td>
                <td colspan="3" >: <?=$this->fungsi->dateformat($tgl_perkiraan_ekspor);?></td>
                <td class="border-l">&nbsp;</td>
                <td >&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6" class="border-l border-t border-b" ><strong>DOKUMEN PELENGKAP PABEAN </strong></td>
                <td colspan="4" class="border-b border-t border-l" ><strong>DATA TEMPAT PEMERIKSAAN</strong></td>
              </tr>
              <tr>
                <td >22.</td>
                <td >Nomor & Tgl Invoice </td>
                <td>:</td>
                <td colspan="3"> <?=$no_invoice;?> tgl <?=$this->fungsi->FormatDate($tgl_invoice);?></td>
                <td class="border-l">24.</td>
                <td>Lokasi Pemeriksaan</td>
                <td>: </td>
                <td >: <?=$lokasi_pemeriksaan;?></td>
              </tr>
              <tr>
                <td >23.</td>
                <td >Jenis/Nomor/Tgl Dok Pelengkap Pabean</td>
                <td>: </td>
                
                <td colspan="3">&nbsp;</td>
                <td class="border-l">25.</td>
                <td>Kantor Pabean Pemeriksa</td>
                <td>: </td>
                <td > :<?=$kantor_pabean_pemeriksa?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Packing List</td>
                <td>: </td>
                <td colspan="3" ><?=$no_packing;?> Tgl <?=$tgl_packing;?></td>   
                <td colspan="4" class="border-b border-t border-l" ><strong>DATA PERDAGANGAN</strong></td>
                
              </tr>
              <tr>
                <td colspan="6">&nbsp;</td>
                <td class="border-l">26.</td>
                <td>Daerah Asal Brg.</td>
                <td>: </td>
                <td >: <?=$daerah_asal_barang;?></td>
              </tr>
              <tr>
                <td class="border-t" >27.</td>
                <td class="border-t" >Negara Tujuan Ekspor</td>
                <td>: </td>
                <td colspan="3" class="border-t" >: <?=$kodenegara_tujuan_ekspor?> &nbsp; <?=$negara_tujuan_ekspor?></td>
                <td class="border-t border-l" >28.</td>
                <td class="border-t" >Cara Penyerahan Barang</td>
                <td>: </td>
                <td class="border-t" ><?=$cara_penyerahan_barang;?></td>
              </tr>
              <tr>
                <td colspan="6" class="border-l border-t border-b" ><strong>DATA TRANSAKSI EKSPOR </strong></td>
                <td colspan="4" class="border-b border-t" >&nbsp;</td>
              </tr>
              <tr>
                <td >29.</td>
                <td >Jenis Valuta Asing</td>
                <td>: </td>
                <td colspan="3" >: <?=$kode_valuta;?> &nbsp; <?=$uraian_valuta;?></td>
                <td class="border-l">31.</td>
                <td >Asuransi(LN/DN)</td>
                <td>: </td>
                <td >: &nbsp; <?=$asuransi;?></td>
              </tr>
              <tr>
                <td >30.</td>
                <td >Freight</td>
                <td>: </td>
                <td colspan="3" >: <?= $this->fungsi->FormatRupiah($freight,2);?></td>
                <td class="border-l">32.</td>
                <td >FOB</td>
                <td>: </td>
                <td>: <?=$fob;?></td>
              </tr>
              <tr>
                <td colspan="6" class="border-b border-t" ><strong>DATA PETI KEMAS</strong></td>
                <td colspan="4" class="border-b border-t" ><strong>DATA KEMASAN</strong></td>
              </tr>
              <tr>
                <td >33.</td>
                <td >Peti Kemas</td>
                <td>: </td>
                <td colspan="3" >: <?=$petikemas;?></td>
                <td >37.</td>
                <td >Jenis Kemasan</td>
                <td>: </td>
                <td>: <?=$kode_kemasan;?> &nbsp; <?=$uraian_kemasan;?></td>
              </tr>
              <tr>
                <td >34.</td>
                <td >Status Peti Kemas</td>
                <td>: </td>
                <td colspan="3" >: <?=$stat_petikemas;?></td>
                <td >38.</td>
                <td >Jumlah Kemasan</td>
                <td>: </td>
                <td >: <?=$jml_kemasan;?></td>
              </tr>
              <tr>
                <td >35.</td>
                <td >Jumlah Peti Kemas</td>
                <td>: </td>
                <td colspan="3" >: <?=$jml_petikemas;?> Peti Kemas/Kontainer</td>
                <td >39.</td>
                <td >Merek Kemasan</td>
                <td>: </td>
                <td>: <?=$merk_kemasan;?></td>
              </tr>
              <tr>
                <td >36.</td>
                <td >Merk dan Nomor Peti Kemas</td>
                <td>: </td>
                <td colspan="3" >: <?=$no_petikemas;?></td>
                <td colspan="4">&nbsp;</td>
              </tr>
             
              <tr>
                <td colspan="10" class="border-b border-t" ><strong>DATA BARANG EKSPOR</strong></td>
              </tr>
              <tr>
                <td >40.</td>
                <td >Volume(m3)</td>
                <td colspan="3" >: <?=$volume;?></td>
                <td colspan="3" >41. Berat Kotor(Kg) : <?=$berat_kotor;?></td>
               
                <td colspan="2" >42. Berat Bersih (Kg) : <?=$berat_bersih;?></td>
              </tr>
            </table>
                </td>
          </tr>
          
          <tr>
            <td colspan="3">
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td width="4%" class="border-br" >43. No</td>
                <td width="30%" class="border-br" >44. Pos Tarif/HS, Uraian jumlah dan jenis barang secara lengkap, merk, tipe,<br> ukuran, spesifikasi lain dan kode barang</td>
                <td width="16%" class="border-br" >45. HE barang dan Tarif BK pada tanggal pendaftaran</td>
                <td width="10%" class="border-br" >46. Jumlah & jenis Berat Bersih(kg), Volume(m3)</td>
                <td width="10%" class="border-br" >47. -Perizinan Ekspor<br>&nbsp; -Negara Asal Barang</td>
                <td width="10%" class="border-b" >48. Jumlah Nilai FOB</td>
              </tr>
              <?php if (count($BARANG) == 1){ ?>	      
              <?php foreach( $BARANG as $bar):?>
              <tr>
                <td class="border-r" valign="top" >1</td>
                <td class="border-r" valign="top" ><?=substr($bar['KODE_HS'],0,4).'.'.substr($bar['KODE_HS'],4,2).'.'.substr($bar['KODE_HS'],6,2).'.'.substr($bar['KODE_HS'],8,2);?><br><?=$bar['URAIAN_BARANG1'].' '.$bar['URAIAN_BARANG2'].' '.$bar['URAIAN_BARANG3'].' '.$bar['URAIAN_BARANG4'];?><br> <?=$bar['MERK']?> / <?=$bar['UKURAN']?> / <?=$bar['TIPE']?> / <?=$bar['SPF']?><br><?=$bar['JUMLAH_KEMASAN'].' '.$bar['KODE_KEMASAN']?>/<?=$bar['URAIAN_KEMASAN']?></td>
                <td class="border-r" valign="top">&nbsp;</td>
                <td class="border-r" valign="top" ><?=$bar['JUMLAH_SATUAN'];?><br><?=$bar['URAIAN_SATUAN'];?><br><?=$this->fungsi->FormatRupiah($bar['NETTO'],4);?> Kgm</td>
                <td class="border-r" valign="top" ><?=$bar['NOMOR_IZIN']?>/<?=($bar['TANGGAL_IZIN']=='0000-00-00')?'':$bar['TANGGAL_IZIN'];?><br><?=$bar['URAIAN_NEGARA'];?></td>
                <td valign="top" ><?= $this->fungsi->FormatRupiah($bar['FOB_PER_BARANG'],4);?></td>
              </tr>
              <?php  
			  
			  $nilai_bk = $this->fungsi->FormatRupiah($bar['NILAI_PE'],2);
			  endforeach;
			  
			  ?>
              <?php }elseif(count($BARANG) < 1){ $nilai_bk = $this->fungsi->FormatRupiah($bar['NILAI_PE'],2); ?>
              <tr>
                <td colspan="6" align="center" height="20px;" > === Belum Terdapat Data Barang ===</td>
              </tr>
              <?php }else{?>
              <tr>
                <td colspan="6" align="center" height="20px;" >=== <?=count($BARANG)?> item barang. Lihat lembar lanjutan ===</td>
              </tr>
              <?php }?>
            </table>
            </td>
         </tr>
         <tr>
            <td colspan="2" class="border-r border-t">&nbsp;</td>
            <td width="358" class="border-b border-t" ><strong>DATA PENERIMAAN NEGARA</strong></td>
          </tr>
          <tr>
            <td colspan="2" rowspan="2" class="border-r" >49. Nilai Tukar Mata Uang &nbsp; : <?=$nilai_tukar;?></td>            
            <td >50. Nilai BK dalam Rupiah : <font style="text-align:right"><?=$nilai_bk;?></font></td>            
          </tr>
          <tr>
            <td >51. PNBP : <?=$pnbp;?></td>
          </tr>
          <tr>
            <td colspan="2" class="border-r border-t" ><strong>G. TANDA TANGAN EKSPORTIR</strong></td>
            <td width="358" class="border-t" ><strong>I.BUKTI PEMBAYARAN</strong></td>
          </tr>
          <tr>
            <td >Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal<br>yang diberitahukan dalam pemberitahuan pabean ini.</td>
            <td width="110"  class="border-r">&nbsp;</td>
            <td >SSPCP :</td>
          </tr>
          <tr>
            <td  align="center" ><?=$kota_ttd?>, Tgl <?=$tgl_ttd;?><br>Eksportir</td>
            <td class="border-r">&nbsp;</td>
            <td align="center">
                <table cellpadding="2" cellspacing="0" width="100%">
                    <tr>
                        <td rowspan="2" align="center" class="border-tbrl" width="20%" >Jen.Pen</td>
                        <td colspan="2" class="border-br border-t" >NTBP</td>
                        <td colspan="2" class="border-br border-t" >NTPN</td>
                    </tr>
                    <tr>
                        <td class="border-br" width="40%" >Nomor</td>
                        <td class="border-br" width="20%" >Tgl</td>
                        <td class="border-br" width="40%" >Nomor</td>
                        <td class="border-br" width="20%" >Tgl</td>
                    </tr>
                    <tr>
                        <td class="border-l border-r" >BK</td>
                        <td class="border-r">&nbsp;</td>
                        <td class="border-r">&nbsp;</td>
                        <td class="border-r">&nbsp;</td>
                        <td class="border-r">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="border-l border-br" >PNBP</td>
                        <td class="border-br">&nbsp;</td>
                        <td class="border-br">&nbsp;</td>
                        <td class="border-br">&nbsp;</td>
                        <td class="border-br">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" > Pejabat Penerima</td>
                        <td >&nbsp;</td>
                        <td colspan="2" >Nama/Stempel Instansi</td>
                    </tr>
                </table>
            </td>
          </tr>
          <tr>
            <td align="center" ><?=$nama_ttd;?></td>
            <td class="border-r" >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td  align="right">
            <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="37">&nbsp;</td>
                <td width="10">&nbsp;</td>
                <td width="279">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            </td>
            <td  class="border-r">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
          <td>&nbsp;</td>          
          <td align="center"  class="border-r">&nbsp;</td>
          <td >(<?=$pejabat_penerima;?>)</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td  class="border-r">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>

</td>
</tr>    
</table>
</div>

<?php
if(count($BARANG) > 1){ 
	$this->load->view("pengeluaran/bc30/cetak/bc30_lampiran_lanjutan");
}   
$this->load->view("pengeluaran/bc30/cetak/bc30_lampiran_dokumen");
?>
</body>
</html>