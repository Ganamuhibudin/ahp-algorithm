<?php
#PARAMETER 
$no_pengajuan	= $this->fungsi->FormatAju($DATA['NOMOR_AJU']);
$kode_kantor_daftar = $DATA['KODE_KPBC_PENDAFTARAN'];
$ur_kode_kantor_daftar = $DATA["UR_KODE_KPBC_PENDAFTARAN"];
$tgl_aju = $DATA["TANGGAL_AJU"];
$nama_trader = $DATA["NAMA_TRADER"];
$no_izin = $DATA["REGISTRASI"];
$alamat_trader = $DATA["ALAMAT_TRADER"];
$kantor_asal_barang = $DATA["KODE_KPBC_ASAL"];
$ur_kantor_asal_barang = $DATA["UR_KODE_KPBC_ASAL"];
$kantor_tujuan_barang = $DATA["KODE_KPBC_TUJUAN"];
$ur_kantor_tujuan_barang = $DATA["UR_KODE_KPBC_TUJUAN"];
$lokasi_asal = $DATA["LOKASI_ASAL_BARANG"];
$lokasi_tujuan = $DATA["LOKASI_TUJUAN_BARANG"];
$nama_pejabatbea = $DATA["NAMA_PETUGAS_BC"];
$nip_pejabatbea = $DATA["NIP_PETUGAS_BC"];
$kota_ttd = $DATA["KOTA_TTD"];
$tgl_ttd = $DATA["TANGGAL_TTD"];
$nama_ttd = $DATA["NAMA_PEMOHON"];
$jabatan_ttd = $DATA["JABATAN_PEMOHON"];
$nomor_pendaftaran = $DATA["NOMOR_PENDAFTARAN"];
$tanggal_daftar = $DATA["TANGGAL_PENDAFTARAN"];
$tanggal_selesai = $DATA["TANGGAL_SELESAI"];
$waktu_selesai = $DATA["WAKTU_SELESAI"];
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
	<td width="8%" align="center" class="border-r border-b"><strong>PPB-PLB</strong></td>
	<td width="92%" align="center" class="border-b" height="33pt"><strong>PEMBERITAHUAN PEMINDAHAN BARANG<br>
	    DALAM SATU PUSAT LOGISTIK BERIKAT</strong></td>
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
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            	<td width="18%" valign="top"><strong>Kantor Pendaftaran</strong></td>
                <td width="1%" valign="top">:</td>
                <td width="81%" valign="top"><?=$kode_kantor_daftar?> - <?=$ur_kode_kantor_daftar?></td>
            </tr>
        	<tr>
                <td width="18%" valign="top"><strong>Nomor AJu</strong></td>
                <td width="1%" valign="top">:</td>
                <td width="81%" valign="top"><?=$no_pengajuan?></td>
        	</tr>
        	<tr>
                <td><strong>Tanggal Aju</strong><strong></strong></td>
                <td>:</td>
                <td><?= $this->fungsi->FormatDate($tgl_aju);?></td>
        	</tr>
        </table>
    </td>    
    <td width="50%" valign="top" class="border-t border-l">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5"><strong>KOLOM KHUSUS BEA DAN CUKAI</strong></td>
            </tr>
            <tr>
                <td width="2%">&nbsp;</td>
                <td width="18%">Nomor Pendaftaran</td>
                <td width="1%">:</td>
                <td width="79%"><?=$nomor_pendaftaran;?></td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td >Tanggal</td>
                <td>:</td>
                <td><?=$tanggal_daftar?$this->fungsi->FormatDate($tanggal_daftar):"";?></td>
            </tr>
        </table>      
    </td>        
</tr>       
<tr> 
    <td width="50%" valign="top" class="border-t border-b" colspan="2">
    	<table width="100%">
        	<tr>
            	<td colspan="3"><strong>Idntitas Pengusaha Logistik Berikat/PDPLB</strong></td>
            </tr>
            <tr>
            	<td>Nama Perusahaan</td>
                <td>:</td>
                <td><?=$nama_trader?></td>
            </tr>
            <tr>
            	<td>Nomor Izin</td>
                <td>:</td>
                <td><?=$no_izin?></td>
            </tr>
            <tr>
            	<td>Alamat Perusahaan</td>
                <td>:</td>
                <td><?=$alamat_trader?></td>
            </tr>
        </table>
    </td>
</tr>   
<tr> 
    <td colspan="2" valign="top" class="border-b"><strong>A. ASAL LOKASI BARANG DAN TUJUAN PEMINDAHAN BARANG</strong><strong></strong></td>
    </tr>
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top">Kantor Asal Barang</td>
                <td valign="top">:</td>
                <td valign="top"><?= $kantor_asal_barang." - ".$ur_kantor_asal_barang;?></td>
            </tr>
            <tr>
                <td valign="top">Lokasi Asal Barang</td>
                <td valign="top">:</td>
                <td valign="top"><?=$lokasi_asal;?></td>
            </tr>
        </table>
    </td>    
    <td width="50%" valign="top" class="border-l">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top">Kantor Tujuan Barang</td>
                <td valign="top">:</td>
                <td valign="top"><?= $kantor_tujuan_barang." - ".$ur_kantor_tujuan_barang;?></td>
            </tr>
            <tr>
                <td valign="top">Lokasi Tujuan Pemindahan Barang</td>
                <td valign="top">:</td>
                <td valign="top"><?= $lokasi_tujuan;?></td>
            </tr>
        </table>      
    </td>        
</tr>
<tr> 
    <td width="50%" valign="top" class="border-t"><strong>B. URAIAN BARANG YANG DIPINDAHKAN</strong></td>
    <td width="50%" valign="top" class="border-t">&nbsp;</td>
</tr>
<tr> 
    <td valign="top" colspan="2" class="border-t border-b">
    	<table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td valign="top" class="border-r border-b" width="2%">No</td>
            <td valign="top" class="border-r border-b" width="30%">- Kode Barang<br />- Kode HS<br />- Uraian Jenis Barang</td>
            <td valign="top" class="border-r border-b" width="10%">- Jumlah<br>- Satuan</td>
            <td valign="top" class="border-b" width="20%">- Dokumen Pemasukan<br>- Nomor<br />- Tanggal</td>
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
            <td valign="top" class="border-r">
            <?=$bar["KODE_BARANG"]?><br / ><?=substr($bar['KODE_HS'],0,4).'.'.substr($bar['KODE_HS'],4,2).'.'.substr($bar['KODE_HS'],6,2).'.'.substr($bar['KODE_HS'],8,2);?><br /><?=$bar['URAIAN_JENIS']?></td>
            <td valign="top" class="border-r"><?=$bar['JUMLAH_SATUAN'];?> <?=$bar['URAIAN_SATUAN'];?><br><?=$bar["KODE_SATUAN"]?></td>
            <td valign="top"><?= $bar["KODE_DOKUMEN"];?><br /><?=$bar["NO_DOKUMEN"]?><br /><?=$bar["TGL_DOKUMEN"]?$this->fungsi->FormatDate($bar["TGL_DOKUMEN"]):"";?></td>
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
    <td valign="top" class="border-b" colspan="2">
    	Jumlah Kemasan/peti kemas : 
        <br >
        Jenis Kemasan/peti kema : 
        <br >
        Merek dan Nomor Kemasan/peti kemas : 
   	</td>
</tr>
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top" colspan="3">Lembar Persetujuan Pejabat Bea dan Cukai</td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td valign="top" width="3%">Nama</td>
                <td valign="top" width="1%">:</td>
                <td valign="top"><?=$nama_pejabatbea?></td>
            </tr>
            <tr>
                <td valign="top">NIP</td>
                <td valign="top">:</td>
                <td valign="top"><?=$nip_pejabatbea?></td>
            </tr>
        </table>
    </td>    
    <td width="50%" valign="top" class="border-l">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top"><?=$kota_ttd.", ".$this->fungsi->FormatDate($tgl_ttd);?></td>
            </tr>
            <tr>
                <td valign="top">Penanggung Jawab Pengusaha PLB/PDPLB</td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3"><?=$nama_ttd;?></td></tr>
            <tr><td>Jabatan : <?=$jabatan_ttd;?></td></tr>
        </table>      
    </td>        
	</tr>
    <tr> 
    	<td width="50%" valign="top" colspan="2" class="border-t" > 
            Catatan :<br>
            Selesai dipindahkan pada tanggal : <?=$this->fungsi->FormatDate($tanggal_selesai)?> <br />Pukul : <?=$waktu_selesai?>
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