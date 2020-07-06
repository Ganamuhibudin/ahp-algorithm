<?php
#PARAMETER 
$no_pengajuan	= $this->fungsi->FormatAju($DATA['NOMOR_AJU']);
$kantor_pabean	= $DATA['URAIAN_KPBC'];
$kdjns_tpb		= $DATA['JENIS_TPB'];
$jns_tpb		= $DATA['URJENIS_TPB'];
$no_pendaftaran	= $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar		= $DATA['TANGGAL_PENDAFTARAN'];
$kdtujuan_pengiriman= $DATA['TUJUAN_KIRIM'];
$tujuan_pengiriman	= $DATA['URTUJUAN_KIRIM'];
$npwp_pengusaha	= $DATA['ID_TRADER'];
$nama_pengusaha	= $DATA['NAMA_TRADER'];
$alamat_pengusaha= $DATA['ALAMAT_TRADER'];
$no_izintpb		= $DATA['NOMOR_IZIN_TPB'];
$kode_pengirim	= $DATA['KODE_ID_PENGIRIM'];
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
$urjns_pengangkut	= $DATA['JENIS_SARANA_ANGKUT'];
$no_polisi		= $DATA['NOMOR_POLISI'];
$harga_penyerahan= $this->fungsi->FormatRupiah($DATA['HARGA_PENYERAHAN'],4);
$kd_kemasan	= $DATAKMS['KODE_KEMASAN'];
$jns_kemasan	= $DATAKMS['URKODE_KEMASAN'];
$jml_kemasan	= $DATAKMS['JUMLAH'];
$merk_kemasan	= $DATAKMS['MERK_KEMASAN'];
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
<style type="text/css">
.border-t {border-top:thin solid #000000;}
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-l {border-left:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
</style>	
<body style="font-size:11;font-family:Arial, Helvetica, sans-serif">
<div class="border-tbrl">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="8%" align="center" class="border-r border-b"><strong>BC 4.0</strong></td>
	<td width="92%" align="center" class="border-b" height="33pt"><strong>PEMBERITAHUAN PEMASUKAN BARANG ASAL TEMPAT LAIN DALAM DAERAH PABEAN KE<br>TEMPAT PENIMBUNAN BERIKAT</strong></td>
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
	<td colspan="10"><strong>NOMOR PENGAJUAN</strong> : <?=$no_pengajuan?></td>
</tr>   
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="3%" valign="top"><strong>A</strong>.</td>
            <td width="26%" valign="top"><strong>KANTOR PABEAN</strong></td>
            <td width="2%" valign="top">:</td>
            <td width="69%" valign="top"><?=$DATA['KODE_KPBC'].' - '.ucwords(strtolower($kantor_pabean));?></td>
        </tr>
        <tr>
            <td><strong>B</strong>.</td>
            <td><strong>JENIS TPB</strong></td>
            <td>:</td>
            <td><?= $kdjns_tpb.' - '.$jns_tpb;?></td>
        </tr>
        <tr>
            <td><strong>C</strong>.</td>
            <td><strong>TUJUAN PENGIRIMAN</strong></td>
            <td>:</td>
            <td><?= $kdtujuan_pengiriman.' - '.ucwords(strtolower($tujuan_pengiriman));?></td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top" class="border-t border-l">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td colspan="5"><strong>F. KOLOM KHUSUS BEA DAN CUKAI</strong></td>
        </tr>
        <tr>
            <td width="2%">&nbsp;</td>
            <td width="18%">Nomor Pendaftaran</td>
            <td width="1%">:</td>
            <td width="79%"><?=$no_pendaftaran;?></td>
        </tr>
        <tr>
            <td >&nbsp;</td>
            <td >Tanggal</td>
            <td>:</td>
            <td><?=$tgl_daftar?$this->fungsi->FormatDate($tgl_daftar):"";?></td>
        </tr>
        </table>      
    </td>        
</tr>       
<tr> 
    <td width="50%" valign="top" class="border-t border-b" colspan="2"><strong>D. DATA PEMBERITAHUAN
      <?
	$SQL = "SELECT NOMOR_DAFTAR, DATE_FORMAT(TANGGAL_DAFTAR,'%d-%m-%Y') TANGGAL_DAFTAR FROM t_bc40_dokasal WHERE NOMOR_AJU='".$AJU."'";	
	$rs = $this->db->query($SQL);		
	if($rs->num_rows()>0){
		echo "&nbsp;&nbsp;&nbsp;EX BC : ";
		foreach($rs->result_array() as $row){
			echo $row["NOMOR_DAFTAR"].'&nbsp;Tgl : '.$row["TANGGAL_DAFTAR"].'&nbsp;,';
		}	
	}
 ?>
    </strong></td>
</tr>   
<tr> 
    <td width="50%" valign="top" class="border-b"><strong>PENGUSAHA TPB</strong></td>
    <td width="50%" valign="top" class="border-l border-b"><strong>PENGIRIM BARANG</strong></td>
</tr>
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
            <td width="1%">1.</td>
            <td width="34%" valign="top">NPWP</td>
            <td width="1%" valign="top">:</td>
            <td width="62%" valign="top"><?= $this->fungsi->FORMATNPWP($npwp_pengusaha);?></td>
        </tr>
        <tr>
            <td valign="top">2.</td>
            <td valign="top">Nama</td>
            <td valign="top">:</td>
            <td valign="top"><?=$nama_pengusaha;?></td>
        </tr>
        <tr>
            <td valign="top">3.</td>
            <td valign="top">Alamat</td>
            <td valign="top">:</td>
            <td valign="top"><?=$alamat_pengusaha;?></td>
        </tr>
        <tr>
            <td valign="top">4.</td>
            <td valign="top">No Izin TPB</td>
            <td valign="top">:</td>
            <td valign="top"><?=$no_izintpb;?></td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top" class="border-l">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top" width="2%">5.</td>
            <td valign="top" width="18%" colspan="4">
            <?php 
			if($kode_pengirim=="0"||$kode_pengirim=="1"||$kode_pengirim=="5")echo "NPWP/<del>KTP</del>/<del>Passport</del>/<del>Lainnya</del> :";	
			elseif($kode_pengirim=="2")echo "<del>NPWP</del>/<del>KTP</del>/Passport/<del>Lainnya</del> :";	
			elseif($kode_pengirim=="3")echo "<del>NPWP</del>/KTP/<del>Passport</del>/<del>Lainnya</del> :";	
			else echo "<del>NPWP</del>/<del>KTP</del>/<del>Passport</del>/Lainnya :";				
			?>           
            </td>
        </tr>
        <tr>
            <td valign="top">&nbsp;</td>
            <td valign="top" colspan="4"><?= $this->fungsi->FORMATNPWP($npwp_pengirim);?></td>
        </tr>
        <tr>
            <td valign="top">6.</td>
            <td valign="top">Nama</td>
            <td valign="top" width="1%">:</td>
            <td valign="top" width="79%"><?= $nama_pengirim;?></td>
        </tr>
        <tr>
            <td valign="top">7.</td>
            <td valign="top">Alamat</td>
            <td valign="top">:</td>
            <td valign="top"><?=$alamat_pengirim;?></td>
        </tr>
        </table>      
    </td>        
</tr>
<tr> 
    <td width="50%" valign="top" class="border-t border-b"><strong>DOKUMEN PELENGKAP PABEAN</strong></td>
    <td width="50%" valign="top" class="border-t border-l border-b">&nbsp;</td>
</tr>  
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="2%">8.</td>
            <td width="15%" valign="top">Packing List</td>
            <td width="1%" valign="top">:</td>
            <td width="27%" valign="top"><?= $lihatlampiran?$lihatlampiran:$no_packing;?></td>
            <td width="50%" valign="top">Tgl. <?=$this->fungsi->FormatDate($tgl_packing);?></td>
        </tr>
        <tr>
            <td valign="top">9.</td>
            <td valign="top">Kontrak</td>
            <td valign="top">:</td>
            <td valign="top"><?= $lihatlampiran?$lihatlampiran:$no_kontrak;?></td>
            <td width="50%" valign="top">Tgl. <?=$this->fungsi->FormatDate($tgl_kontrak);?></td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top" width="4%">10.</td>
            <td valign="top" colspan="3">Surat Keputusan Persetujuan :</td>
        </tr>
        <tr>
            <td valign="top">&nbsp;</td>
            <td width="40%" valign="top"><?= $lihatlampiran?$lihatlampiran:$srt_keputusan;?></td>
            <td width="56%" valign="top">Tgl. <?=$tgl_keputusan?$this->fungsi->FormatDate($tgl_keputusan):"";?></td>
        </tr>
         <tr>
            <td valign="top" width="4%">11.</td>
            <td valign="top" colspan="3">Jenis/nomor/tanggal dokumen lainnya :</td>
        </tr>
        <tr>
            <td valign="top">&nbsp;</td>
            <td width="40%" valign="top"><?= $lihatlampiran?$lihatlampiran:$no_dokumen;?></td>
            <td width="56%" valign="top">Tgl. <?=$tgl_dokumen?$this->fungsi->FormatDate($tgl_dokumen):"";?></td>
        </tr>
        </table>      
    </td>        
</tr>
<tr> 
    <td width="50%" valign="top" class="border-b border-t"><strong>DATA PENGANGKUTAN</strong></td>
    <td width="50%" valign="top" class="border-b border-t">&nbsp;</td>
</tr>
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="3%">12.</td>
            <td width="27%" valign="top">Jenis sarana pengangkut darat</td>
            <td width="2%" valign="top">:</td>
            <td width="68%" valign="top"><?=$urjns_pengangkut;?></td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top" width="4%">13.</td>
            <td valign="top" width="13%">Nomor Polisi</td>
            <td valign="top" width="2%">:</td>
            <td valign="top" width="81%"><?= $no_polisi;?></td>
        </tr>
        </table>      
    </td>        
</tr>
<tr> 
    <td width="50%" valign="top" class="border-b border-t"><strong>DATA PERDAGANGAN</strong></td>
    <td width="50%" valign="top" class="border-b border-t">&nbsp;</td>
</tr>
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="3%">14.</td>
            <td width="18%" valign="top">Harga Penyerahan</td>
            <td width="2%" valign="top">:</td>
            <td width="77%" valign="top"><?=$harga_penyerahan;?></td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top">&nbsp; </td>        
</tr>
<tr> 
    <td width="50%" valign="top" class="border-b border-t"><strong>DATA PENGEMAS</strong></td>
    <td width="50%" valign="top" class="border-b border-t">&nbsp;</td>
</tr>
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<? if(count($KEMASAN)>1){ ?>
       <tr>
            <td width="3%">15.</td>
            <td width="18%" valign="top">Jenis Kemasan</td>
            <td width="2%" valign="top">:</td>
            <td width="77%" valign="top"> == lihat lampiran == </td>
        </tr>
        <tr>
            <td valign="top">16.</td>
            <td valign="top">Merek Kemasan</td>
            <td valign="top">:</td>
            <td valign="top">-</td>
        </tr>
	<? }else{ ?>	
       <tr>
            <td width="3%">15.</td>
            <td width="18%" valign="top">Jenis Kemasan</td>
            <td width="2%" valign="top">:</td>
            <td width="77%" valign="top"><?= $kd_kemasan.' '.$jns_kemasan;?></td>
        </tr>
        <tr>
            <td valign="top">16.</td>
            <td valign="top">Merek Kemasan</td>
            <td valign="top">:</td>
            <td valign="top"><?=$merk_kemasan;?></td>
        </tr>
	<? } ?>
        </table>
    </td>    
    <td width="50%" valign="top">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">     
	 <? if(count($KEMASAN)>1){ ?>   
        <tr>
            <td valign="top" width="4%">17.</td>
            <td valign="top" width="13%">Jumlah Kemasan</td>
            <td valign="top" width="2%">:</td>
            <td valign="top" width="81%">-</td>
        </tr>
	<? }else{ ?>	   
        <tr>
            <td valign="top" width="4%">17.</td>
            <td valign="top" width="13%">Jumlah Kemasan</td>
            <td valign="top" width="2%">:</td>
            <td valign="top" width="81%"><?= $jml_kemasan;?></td>
        </tr>
	<? } ?>	
        </table>      
    </td>        
</tr>
<tr> 
    <td width="50%" valign="top" class="border-t border-b"><strong>DATA BARANG</strong></td>
    <td width="50%" valign="top" class="border-t border-b">&nbsp;</td>
</tr> 
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="3%">18.</td>
            <td width="20%" valign="top">Volume (m3)</td>
            <td width="53%" valign="top">:  <?=$this->fungsi->FormatRupiah($volume,4);?></td>
            <td width="24%" valign="top">19.Berat Kotor (Kg)</td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top" width="41%">:  <?=$this->fungsi->FormatRupiah($berat_kotor,4);?></td>
            <td valign="top" width="18%">20.Berat Bersih (Kg)</td>
            <td valign="top" width="24%">: <?=$this->fungsi->FormatRupiah($berat_bersih,4);?></td>
            <td valign="top" width="17%" align="right">&nbsp;</td>
        </tr>
        </table>      
    </td>        
</tr>  
<tr> 
    <td valign="top" colspan="2" class="border-t border-b">
    	<table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td valign="top" class="border-r border-b">21.<br>No</td>
            <td valign="top" class="border-r border-b">22.<br>Uraian jumlah dan jenis barang secara lengkap, Kode Barang merk, tipe, ukuran, dan
spesifikasi lain</td>
            <td valign="top" class="border-r border-b">23.<br>- Jumlah & Jenis Satuan<br>- Berat Bersih (Kg)<br>- Volume (m3)</td>
            <td valign="top" class="border-b">24.<br>Harga Penyerahan (Rp)</td>
        </tr>
		<?php   
	    if(count($BARANG) <1){
		?>
          <tr>
            <td align="center" colspan="4" style="padding-bottom:120px;padding-top:120px">=== Belum Terdapat Data Barang === </td>
          </tr>
          <?php }else{ 
		$lopdata = 1;  
        foreach($BARANG as $bar):
		if($lopdata==count($BARANG)){
			if(count($BARANG)==1) $height = "350px";
			if(count($BARANG)==2) $height = "285px";
			if(count($BARANG)==3) $height = "215px";
			if(count($BARANG)==4) $height = "160px";
			if(count($BARANG)==5) $height = "100px";
		}
        ?>
          <tr>
            <td valign="top" class="border-r" align="center"  style="padding-bottom:<?=$height?>"><?=$lopdata?></td>
            <td valign="top" class="border-r"><?=substr($bar['KODE_HS'],0,4).'.'.substr($bar['KODE_HS'],4,2).'.'.substr($bar['KODE_HS'],6,2).'.'.substr($bar['KODE_HS'],8,2);?> 
            / 
              <?=$bar['KODE_BARANG'].' , '.$bar['URAIAN_BARANG']?>
              <br>
              <?=$bar['MERK']?> / <?=$bar['UKURAN']?> / <?=$bar['TIPE']?> / <?=$bar['SPF']?>
              <?=$bar['JUMLAH_KEMASAN'].' '.$bar['KODE_KEMASAN']?>
              /
              <?=$bar['URAIAN_KEMASAN']?></td>
            <td valign="top" class="border-r"><?=$bar['JUMLAH_SATUAN'];?> <?=$bar['URAIAN_SATUAN'];?>
              <br>
              <?=$this->fungsi->FormatRupiah($bar['NETTO'],4);?>
              Kgm<br>
              <?=$this->fungsi->FormatRupiah($bar['VOLUME'],4);?></td>
            <td valign="top" align="right"><?= $this->fungsi->FormatRupiah($bar['HARGA_PENYERAHAN'],4);?></td>
          </tr>
          <?php  
		if($lopdata==6) break;
		$lopdata++;
		endforeach; 
    	}?>				
        </table> 
    </td>
</tr>
<tr> 
    <td width="50%" valign="top" class="border-b"><strong>G. UNTUK PEJABAT BEA DAN CUKAI</strong></td>
    <td width="50%" valign="top" class="border-l border-b"><strong>E. TANDA TANGAN PENGUSAHA TPB</strong></td>
</tr>
<tr> 
    <td width="50%" valign="bottom"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="11%">&nbsp;</td>
            <td width="10%" valign="top">Nama</td>
            <td width="2%" valign="top">:</td>
            <td width="77%" valign="top"><?=$nama_pejabatbea?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td valign="top">NIP</td>
            <td valign="top">:</td>
            <td valign="top"><?=$nip_pejabat?></td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top" class="border-l">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td valign="top">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini.</td>
        </tr>
        <tr>
        	<td valign="top" align="center">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" align="center"><?=$kota_ttd;?> tgl <?=$this->fungsi->FormatDate($tgl_ttd);?><br><br><br>(<?=$nama_ttd;?>)</td>
        </tr>
        </table>      
    </td>        
</tr>
</table>
</div>
<?php
if(count($BARANG)>6){	
	echo "<pagebreak />";	
	$arrdata = array("loop"=>6);  	
	$this->load->view("pemasukan/bc40/cetak/bc40_lampiran_lanjutan",$arrdata);		
	$loop = floor(count($BARANG)/10);
	$x=16;
	if(count($BARANG)>10){
		for($i=0;$i<$loop;$i++){		
			echo "<pagebreak />";	
			$arrdata = array("loop"=>$x); 	
			$this->load->view("pemasukan/bc40/cetak/bc40_lampiran_lanjutan",$arrdata);	
			$x=$x+10;
		}
	}
}  
if(count($DOKUMEN)>0){ 	
	echo "<pagebreak>";
	$this->load->view("pemasukan/bc40/cetak/bc40_lampiran_dokumen");
}
if(count($KEMASAN)>1){ 	
	echo "<pagebreak>";
	$this->load->view("pemasukan/bc40/cetak/bc40_lampiran_kemasan");
}

?>
</body>