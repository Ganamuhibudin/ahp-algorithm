<?php
$no_pengajuan		= $DATA['NOMOR_AJU'];
$kantor_asal		= $DATA['URAIAN_KPBC_ASAL'];
$kantor_tujuan		= $DATA['URAIAN_KPBC_TUJUAN'];
$no_pendaftaran		= $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar			= $DATA['TANGGAL_PENDAFTARAN'];
$npwp_tpbasal		= $DATA['ID_TRADER_ASAL'];
$nama_tpbasal		= $DATA['NAMA_TRADER_ASAL'];
$alamat_tpbasal		= $DATA['ALAMAT_TRADER_ASAL'];
$no_izintpbasal		= $DATA['NOMOR_IZIN_TPB_ASAL'];
$npwp_tpbtujuan		= $DATA['ID_TRADER_TUJUAN'];
$nama_tpbtujuan		= $DATA['NAMA_TRADER_TUJUAN'];
$alamat_tpbtujuan	= $DATA['ALAMAT_TRADER_TUJUAN'];
$no_izintpbtujuan	= $DATA['NOMOR_IZIN_TPB_TUJUAN'];
$invoce				= $DATADOK['NOMOR_INVOICE'];
$tgl_invoce			= $DATADOK['TANGGAL_INVOICE'];
$srt_keputusan 		= $DATADOK['NOMOR_SURAT_KEPUTUSAN'];
$tgl_keputusan 		= $DATADOK['TANGGAL_SURAT_KEPUTUSAN'];
$no_packing			= $DATADOK['NOMOR_PACKING_LIST'];
$tgl_packing		= $DATADOK['TANGGAL_PACKING_LIST'];
$no_kontrak			= $DATADOK['NOMOR_KONTRAK'];
$tgl_kontrak		= $DATADOK['TANGGAL_KONTRAK'];
$no_lainnya		    = $DATADOK['NOMOR_LAINNYA'];
$kd_valuta		= $DATA['KODE_VALUTA'];
$jenis_valuta		= $DATA['URAIAN_VALUTA'];
$cif				= $DATA['CIF'];
$hrg_penyerahan		= $DATA['HARGA_PENYERAHAN'];
$berat_bersih   	= $DATA['NETTO'];
$berat_kotor		= $DATA['BRUTO'];
$volume  			= $DATA['VOLUME'];
$tujuan_pengiriman	= $DATA['URTUJUAN_PENGIRIMAN'];
$tpb_asal			= $DATA['URJENIS_TPB_ASAL'];
$tpb_tujuan			= $DATA['URJENIS_TPB_TUJUAN'];
$surat_jalan		= $DATADOK['NOMOR_SURAT_JALAN'];
$tgl_surat_jalan	= $DATADOK['TANGGAL_SURAT_JALAN'];
$no_barang			= $DATA['NOMOR_BC27_ASAL'];
$tgl_barang			= $DATA['TANGGAL_BC27_ASAL'];
$jenis_angkut		= $DATA['JENIS_SARANA_ANGKUT'];
$no_polisi			= $DATA['NOMOR_POLISI'];
$merk_kemasan		= $DATAKMS['MERK_KEMASAN'];
$jns_kemasan		= $DATAKMS['URKODE_KEMASAN'];
$jml_kemasan		= $DATAKMS['JUMLAH'];
$nama_pejabat_asal	= $DATA['NAMA_PEJABAT_BC_ASAL'];
$nama_pejabat_tujuan= $DATA['NAMA_PEJABAT_BC_TUJUAN'];
$nip_pejabat_asal	= $DATA['NIP_PEJABAT_BC_ASAL'];
$nip_pejabat_tujuan	= $DATA['NIP_PEJABAT_BC_TUJUAN'];
$no_segel			= $DATA['NOMOR_SEGEL_BC'];
$jns_bcasal			= $DATA['JENIS_SEGEL_BC'];
$catatan_bctujuan	= $DATA['CATATAN_BC_TUJUAN'];
$nama_ttd			= $DATA['NAMA_TTD'];
$kota_ttd			= $DATA['KOTA_TTD'];
$tanggal_ttd		= $DATA['TANGGAL_TTD'];
function FormatAju($var){
	if (!is_null($var)){
		$varresult = '';
		$varresult = substr($var,0,6)."-".substr($var,6,6)."-".substr($var,12,8)."-".substr($var,20,6);
		return $varresult;
	}
}
?>
<style type="text/css">
.border-t {border-top:thin solid #000000;}
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-l {border-left:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tb {border-top:thin solid #000000;border-bottom:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
</style>		
		
<body style="font-size:11;">
<?php 
if($SURAT['NOMOR_AJU']){
	$this->load->view("surat/surat");	
	if($hasilTotLampiran>0){
		$this->load->view("surat/lampiran");
	}
}
?>  
	
<div class="border-tbrl">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="8%" align="center" class="border-r border-b"><strong>BC 2.7</strong></td>
	<td width="92%" align="center" class="border-b" height="33pt"><strong>PEMBERITAHUAN PENGELUARAN BARANG UNTUK DIANGKUT DARI TEMPAT<br>PENIMBUNAN BERIKAT KE TEMPAT PENIMBUNAN BERIKAT LAINNYA</strong></td>
</tr>
<tr>
	<td colspan="3" class="border-b"><b>HEADER</b></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">  
  <tr>
    <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td width="150PX">&nbsp;</td>
            <td width="5%">&nbsp;</td>
            <td colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">NO PENGAJUAN</td>
            <td colspan="3">: <?=$this->fungsi->FormatAju($no_pengajuan);?></td>

            <td>D.</td>
            <td colspan="4">TUJUAN PENGIRIMAN: <?=$tujuan_pengiriman;?></td>
          </tr>
          <tr>
            <td>A.</td>
            <td>KANTOR PABEAN </td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td width="22%">&nbsp;</td>
          </tr>
           <tr>
             <td>&nbsp;</td>
             <td>1. Kantor Asal</td>
            <td colspan="3">: <?=$DATA['KODE_KPBC_ASAL'].' - '.$kantor_asal;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
           <tr>
             <td>&nbsp;</td>
             <td>2. Kantor Tujuan</td>
            <td colspan="3" class="border-r">: <?=$DATA['KODE_KPBC_TUJUAN'].' - '.$kantor_tujuan;?></td>
            <td class="border-t">G.</td>
            <td colspan="4" class="border-t">KOLOM KHUSUS BEA DAN CUKAI</td>
          </tr>
           <tr>
             <td>B.</td>
             <td>JENIS TPB ASAL</td>
            <td colspan="3" class="border-r">: <?=$DATA['JENIS_TPB_ASAL'].' - '.$tpb_asal;?></td>
            <td>&nbsp;</td>
            <td>Nomor Pendaftaran</td>
            <td colspan="3">: <?=$no_pendaftaran;?></td>
          </tr>
           <tr>
             <td>C.</td>
             <td>JENIS TPB TUJUAN</td>
             <td colspan="3" class="border-r">: <?=$DATA['JENIS_TPB_TUJUAN'].' - '.$tpb_tujuan;?></td>
            <td>&nbsp;</td>
            <td>Tanggal</td>
            <td colspan="3">: <?=$tgl_daftar;?></td>
          </tr>
          <tr>
            <td colspan="10" class="border-b border-t">E. DATA PEMBERITAHUAN </td>
          </tr>
          <tr>
            <td colspan="5" class="border-br">TPB ASAL BARANG </td>
            <td colspan="5" class="border-b">TPB TUJUAN BARANG</td>
          </tr>
          <tr>
            <td width="2%">1.</td>
            <td width="17%">NPWP</td>
            <td colspan="3" class="border-r">: <?=$this->fungsi->FORMATNPWP($npwp_tpbasal);?></td>
            <td width="2%">5.</td>
            <td width="13%">NPWP</td>
            <td colspan="3">: <?=$this->fungsi->FORMATNPWP($npwp_tpbtujuan	);?></td>
          </tr>
          <tr>
            <td>2.</td>
            <td>Nama</td>
            <td colspan="3" class="border-r">: <?=$nama_tpbasal;?></td>
            <td>6.</td>
            <td>Nama</td>
            <td colspan="3">: <?=$nama_tpbtujuan;?></td>
          </tr>
          <tr>
            <td>3.</td>
            <td>Alamat</td>
            <td colspan="3" class="border-r" rowspan="2" valign="top">: <?=$alamat_tpbasal;?></td>
            <td>7.</td>
            <td>Alamat</td>
            <td colspan="3" rowspan="2" valign="top">: <?=$alamat_tpbtujuan;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td>4.</td>
            <td>No. Izin TPB </td>
            <td colspan="3" class="border-r">: <?=$no_izintpbasal;?></td>
            <td>8.</td>
            <td>No. Izin TPB </td>
            <td colspan="3">: <?=$no_izintpbtujuan;?></td>
          </tr>
          <tr>
            <td colspan="10" class="border-b border-t">DOKUMEN PELENGKAP PABEAN </td>
          </tr>
          <tr>
            <td width="2%">9.</td>
            <td width="17%">Invoice</td>
            <td width="5%">: <?=$lihatlampiran?$lihatlampiran:$invoce;?></td>
            <td colspan="2">Tgl. <?=$this->fungsi->dateformat($tgl_invoce);?></td>
            <td>12.</td>
            <td>Surat Jalan</td>
            <td width="17%">: <?=$lihatlampiranj?$lihatlampiranj:$surat_jalan;?></td>
            <td colspan="2">Tgl. <?=$this->fungsi->dateformat($tgl_surat_jalan);?></td>
          </tr>
          <tr>
            <td>10.</td>
            <td>Packing List </td>
            <td >: <?=$lihatlampiran?$lihatlampiran:$no_packing;?></td>
            <td colspan="2">Tgl. <?=$this->fungsi->dateformat($tgl_packing);?></td>
            <td>13.</td>
            <td colspan="4">Surat Keputusan Persetujuan :</td>
          </tr>
          <tr>
            <td>11.</td>
            <td>Kontrak</td>
            <td>: <?=$lihatlampirank?$lihatlampirank:$no_kontrak;?></td>
            <td colspan="2">Tgl. <?=$this->fungsi->dateformat($tgl_kontrak);?></td>
            <td>&nbsp;</td>
            <td colspan="1"><?=$lihatlampiransk?$lihatlampiransk:$srt_keputusan;?></td>
            <td colspan="3">Tgl. <?=$this->fungsi->dateformat($tgl_keputusan);?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="15%">&nbsp;</td>
            <td>&nbsp;</td>
            <td>14</td>
            <td colspan="1">Lainnya</td>
            <td colspan="3">:</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4"><?=$no_lainnya?></td>
          </tr>
          <tr>
            <td colspan="10" class="border-tb">RIWAYAT BARANG</td>
          </tr>
          <tr>
            <td>15.</td>
            <td colspan="9">Nomor dan tanggal BC 2.7 asal: <?= ($lihatlampiran_dokasal)?$lihatlampiran_dokasal: ($no_barang.' Tgl. '.$tgl_barang);?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="10" class="border-b border-t">DATA PERDAGANGAN </td>
          </tr>
          <tr>
            <td>16.</td>
            <td>Jenis Valuta Asing </td>
            <td colspan="2">: <?=$kd_valuta.' - '.$jenis_valuta;?></td>
            <td>&nbsp;</td>
            <td>18.</td>
            <td>Harga Penyerahan </td>
            <td colspan="2">:&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>17.</td>
            <td>CIF</td>
            <td colspan="2">: <?=number_format($cif,2,'.',',');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4"><?=number_format($hrg_penyerahan,2,'.',',');?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="7" class="border-tr">DATA PENGANGKUTAN</td>
            <td colspan="3" align="center" class="border-t"> SEGEL ( DIISI OLEH BEA DAN CUKAI)</td>
          </tr>
          <tr>
            <td class="border-t">19.</td>
            <td colspan="2" class="border-t">Jenis Sarana Pengangkut Darat</td>
            <td class="border-t">&nbsp;</td>
            <td class="border-t">&nbsp;</td>
            <td class="border-t">20.</td>
            <td class="border-tr">No Polisi</td>
            <td colspan="2" align="center" class="border-tr">BC Asal</td>
            <td rowspan="2" class="border-t">23. Catatan BC Tujuan</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><?=$jenis_angkut;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="border-r"><?=$no_polisi;?></td>
            <td width="10%" class="border-tr">21. No Segel</td>
            <td width="7%" class="border-tr">22. Jenis</td>
          </tr>
          <tr>
            <td colspan="7" class="border-tr">DATA PETI KEMAS DAN PENGEMAS</td>
            <td class="border-tr"><?=$no_segel;?></td>
            <td class="border-tr"><?=$jns_bcasal;?></td>
            <td class="border-t"><?=$catatan_bctujuan;?></td>
          </tr>
          <tr>
            <td class="border-t">24.</td>
            <td colspan="4" class="border-t">Merk dan No Kemasan/ Peti Kemas dan Jumlah Peti Kemas</td>
            <td class="border-t">25</td>
            <td class="border-tr">Jumlah dan jenis Kemasan</td>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="border-t">&nbsp;</td>
            <td colspan="4" class="border-t"><?=$merk_kemasan;?></td>                 
            <td class="border-t">&nbsp;</td>
            <td class="border-tr"><?=number_format($jml_kemasan,2,'.',',').' &nbsp; '.$jns_kemasan;?></td>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="10" class="border-b border-t">DATA BARANG</td>
          </tr>
          <tr>
            <td>26.</td>
            <td>Volume(m3)</td>
            <td>: <?=$volume;?></td>
            <td>&nbsp;</td>
            <td colspan="3">27. Berat Kotor(Kg) : <?=$berat_kotor;?></td>
            <td colspan="3">28.Berat Bersih (Kg) : <?=$berat_bersih;?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="3%" class="border-r">29.</td>
        <td width="42%" class="border-r">30.</td>
        <td width="13%" class="border-r">31.</td>
        <td width="9%">32.</td>
      </tr>
      <tr>
        <td valign="top" class="border-br">No</td>
        <td valign="top" class="border-br">Pos tarif/ HS, uraian jumlah dan jenis barang secara lengkap, kode barang, merk, tipe, ukuran, dan spesifikasi lain </td>
        <td valign="top" class="border-br">- Jumlah &amp; Jenis<br>
        Satuan<br>- Berat Bersih (kg)<br>- Volume (m3) </td>
        <td valign="top" class="border-b">- Nilai CIF<br>
        - Harga Penyerahan </td>
      </tr>
      <?php if (count($BARANG) ==1){ ?>
      <?php $no=1;?>
      <?php foreach( $BARANG as $bar):?> 
      <tr>
        <td class="border-r" valign="top"><?=$no;?></td>
        <td rowspan="3" valign="top" class="border-r"><?=$bar['KODE_HS'];?><br><?=$bar['KODE_BARANG'].', '.$bar['URAIAN_BARANG'];?>, <?=$bar['MERK']?>, <?=$bar['TIPE']?></td>
        <td class="border-r" valign="top"><?=number_format($bar['JUMLAH_SATUAN'],2,'.',',').' '.$bar['KODE_SATUAN'];?><br><?=$bar['URKODE_SATUAN'];?><br><?=number_format($bar['NETTO'],2,'.',',').' Kg';?><br><?=number_format($bar['VOLUME'],2,'.',',').' m3';?></td>
        <td><?=number_format($bar['CIF'],2,'.',',');?><br><?=number_format($bar['HARGA_PENYERAHAN'],2,'.',',')?></td>
      </tr>
      
      <?php  endforeach;?>
      <?php }elseif((count($BARANG) < 1)){ ?>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>                 
      </tr>
      <tr>
        <td colspan="4" align="center">=== Belum Terdapat Data Barang === </td>                 
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>                 
      </tr>
      <?php }else{ ?>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>                 
      </tr>
      <tr>
        <td class="border" colspan="4" align="center">=== <?=count($BARANG)?> Jenis Barang. Lihat lembar lanjutan === </td>                 
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>                 
      </tr>

      
       <?php }?>
      
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0">
    
    </table></td>
  </tr>
  <tr>
    <td width="36%" class="border-br">F. TANDA TANGAN PENGUSAHA TPB</td>
    <td colspan="2" class="border-b">H. UNTUK PEJABAT BEA DAN CUKAI </td>
  </tr>
  <tr>
    <td class="border-r">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>
    <td width="42%" class="border-br" align="center">Kantor Pabean Asal</td>
    <td width="22%" align="center" class="border-b">Kantor Pabean Tujuan</td>
  </tr>
  <tr>
    <td class="border-r">&nbsp;</td>
    <td class="border-r">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="border-r"><?=$kota_ttd.', Tgl. '.$this->fungsi->dateformat($tanggal_ttd);?></td>
    <td align="center" class="border-r">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="border-r">&nbsp;</td>
    <td class="border-r">Nama : <?=$nama_pejabat_asal;?></td>
    <td>Nama : <?=$nama_pejabat_tujuan;?></td>
  </tr>
  <tr>
    <td align="center" class="border-r">(<?=$nama_ttd;?>)</td>
    <td class="border-r">Nip : <?=$nip_pejabat_asal;?></td>
    <td>Nip : <?=$nip_pejabat_tujuan;?></td>
  </tr>
  <tr>
    <td class="border-r">&nbsp;</td>
    <td align="center" class="border-r">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php
	if (count($BARANG) > 1){ 
		echo "<pagebreak>";
		$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_lanjutan");
	}
	if(count($DOKUMEN)>0){
		echo "<pagebreak>";
		foreach($DOKUMEN as $dok){
			$INVOICE = $dok['JENIS_DOKUMEN'];	   
		}
		$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_dokumen");		
	}
	if(count($DATACNT)>0){
		echo "<pagebreak>";
		$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_container");
	}
	if(count($BARANGJD)>1){
		echo "<pagebreak>";
		$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_konversi");
	}
 ?>
</body>
