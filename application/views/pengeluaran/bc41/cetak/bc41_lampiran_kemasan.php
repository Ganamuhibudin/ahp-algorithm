<div class="border-tbrl">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="8%" align="center" class="border-r border-b"><strong>BC 4.1</strong></td>
	<td width="92%" align="center" class="border-b" height="33pt"><strong>LEMBAR LANJUTAN<br>DATA KEMASAN</strong></td>
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
	<td colspan="10"><strong>NOMOR PENGAJUAN</strong> :<?=$this->fungsi->FormatAju($DATA['NOMOR_AJU'])?></td>
</tr>   
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="3%" valign="top"><strong>A</strong>.</td>
            <td width="26%" valign="top"><strong>KANTOR PABEAN</strong></td>
            <td width="2%" valign="top">:</td>
            <td width="69%" valign="top"><?=$DATA['KODE_KPBC'].' - '.ucwords(strtolower($DATA['URAIAN_KPBC']));?></td>
        </tr>
        <tr>
            <td><strong>B</strong>.</td>
            <td><strong>JENIS TPB</strong></td>
            <td>:</td>
            <td><?=$DATA['JENIS_TPB'].' - '.$DATA['URJENIS_TPB'];?></td>
        </tr>
        <tr>
            <td><strong>C</strong>.</td>
            <td><strong>TUJUAN PENGIRIMAN</strong></td>
            <td>:</td>
            <td><?=$DATA['TUJUAN_KIRIM'].' - '.ucwords(strtolower($DATA['URTUJUAN_KIRIM']));?></td>
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
            <td width="79%"><?=$DATA['NOMOR_PENDAFTARAN'];?></td>
        </tr>
        <tr>
            <td >&nbsp;</td>
            <td >Tanggal</td>
            <td>:</td>
            <td><?=$DATA['TANGGAL_PENDAFTARAN']?$this->fungsi->FormatDate($DATA['TANGGAL_PENDAFTARAN']):"";?></td>
        </tr>
        </table>      
    </td>        
</tr> 
<tr> 
    <td valign="top" colspan="2" class="border-t border-b">
    	<table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td width="10pt" align="center"  valign="top" class="border-r border-b">NO</td>
            <td width="230pt" align="center" valign="top" class="border-r border-b">JUMLAH</td>
            <td width="190pt" align="center"  valign="top" class="border-r border-b">KODE KEMASAN</td>
            <td width="110pt" align="center" valign="top" class="border-b">MERK KEMASAN</td>
        </tr>

<?php 	
	if(count($KEMASAN) > 0){ 
		$no=1;
		foreach($KEMASAN as $dok){
			$nomor = $nomor.$no."<br><br>";
			$JUMLAH = $JUMLAH.$dok['JUMLAH']."<br><br>";
			$KODE_KEMASAN = $KODE_KEMASAN.$dok['KODE_KEMASAN'].' '.$dok['URKODE_KEMASAN']."<br><br>";
			$MERK_KEMASAN = $MERK_KEMASAN.$dok['MERK_KEMASAN']."<br><br>";
			$no++;
		}
?>	
		<tr>
            <td valign="top" class="border-r" align="center" height="500pt"><?=$nomor?></td>
            <td valign="top" class="border-r" height="500pt"><?=$JUMLAH?></td>
            <td valign="top" class="border-r" height="500pt"><?=$KODE_KEMASAN?></td>
            <td valign="top" align="left" height="500pt"><?=$MERK_KEMASAN?></td>
        </tr>
<?php 	
	}else{	
?>
		<tr>
            <td valign="top" class="border-r" align="center" height="500pt">&nbsp;</td>
            <td valign="top" class="border-r" height="500pt">&nbsp;</td>
            <td valign="top" class="border-r" height="500pt">&nbsp;</td>
            <td valign="top" align="right" height="500pt">&nbsp;</td>
        </tr>
<?php 	
	}
?>    	        
                
        </table> 
    </td>
</tr>
<tr> 
    <td width="50%" valign="top" class="border-b"><strong>&nbsp;</strong></td>
    <td width="50%" valign="top" class="border-b"><strong>E. TANDA TANGAN PENGUSAHA TPB</strong></td>
</tr>
<tr> 
    <td width="50%" valign="bottom"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="11%">&nbsp;</td>
            <td width="10%" valign="top">&nbsp;</td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="77%" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
        </tr>
        </table>
    </td>    
    <td width="50%" valign="top">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td valign="top">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini.</td>
        </tr>
        <tr>
        	<td valign="top" align="center">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" align="center"><?=$DATA['KOTA_TTD'];?> tgl <?=$this->fungsi->FormatDate($DATA['TANGGAL_TTD']);?><br><br><br>(<?=$DATA['NAMA_TTD'];?>)</td>
        </tr>
        </table>      
    </td>        
</tr>
</table>
</div>