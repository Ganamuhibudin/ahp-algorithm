<?php
function headerLamp($NOMOR_AJU,$URAIAN_KPBC,$URJENIS_TPB,$URTUJUAN_KIRIM,$NOMOR_PENDAFTARAN,$TANGGAL_PENDAFTARAN){
$content  ='<div class="border-tbrl">';
$content .='<table width="100%" cellpadding="0" cellspacing="0">';
$content .='<tr>'; 
$content .='<td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="5" cellspacing="0">';
$content .='<tr align="center">';
$content .='<td width="16%" align="center" class="border-r" height="50" style="font-size:9pt"><strong>BC 4.0 </strong> </td>';
$content .='<td width="84%" align="center" height="50" style="font-size:9pt"><strong>LEMBAR LANJUTAN <br>DATA BARANG </strong> </td>';
$content .='</tr>';
$content .='</table></td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td colspan="3" class="border-b" style="font-size:9pt">HEADER</td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">';
$content .='<tr>';
$content .='<td colspan="2">&nbsp;</td>';
$content .='<td colspan="3">&nbsp;</td>';
$content .='<td width="1%">&nbsp;</td>';
$content .='<td width="1%">&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td width="6%">&nbsp;</td>';
$content .='<td width="19%" align="right">&nbsp;</td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td colspan="2" style="font-size:9pt">NO PENGAJUAN</td>';
$content .='<td colspan="3" style="font-size:9pt">: '.FormatAju($NOMOR_AJU).'</td>';
$content .='<td>&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td width="14%">&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td align="right"></td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td width="2%" style="font-size:9pt">A.</td>';
$content .='<td width="16%" style="font-size:9pt">KANTOR PABEAN </td>';
$content .='<td colspan="3" style="font-size:9pt">: '.$URAIAN_KPBC.'</td>';
$content .='<td>&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td style="font-size:9pt">B.</td>';
$content .='<td style="font-size:9pt">JENIS TPB </td>';
$content .='<td colspan="3" style="font-size:9pt">: '.$URJENIS_TPB.'</td>';
$content .='<td class="border-r">&nbsp;</td>';
$content .='<td class="border-t" style="font-size:9pt">F.</td>';
$content .='<td colspan="3" class="border-t" style="font-size:9pt">KOLOM KHUSUS BEA DAN CUKAI</td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td style="font-size:9pt">C.</td>';
$content .='<td style="font-size:9pt">TUJUAN PENGIRIMAN</td>';
$content .='<td colspan="3" style="font-size:9pt">: '.$URTUJUAN_KIRIM.'</td>';
$content .='<td class="border-r">&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td style="font-size:9pt">Nomor Pendaftaran</td>';
$content .='<td colspan="2" style="font-size:9pt">:'.$NOMOR_PENDAFTARAN.'</td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td>&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td width="19%">&nbsp;</td>';
$content .='<td width="1%">&nbsp;</td>';
$content .='<td width="21%">&nbsp;</td>';
$content .='<td class="border-r">&nbsp;</td>';
$content .='<td>&nbsp;</td>';
$content .='<td style="font-size:9pt">Tanggal</td>';
$content .='<td colspan="2" style="font-size:9pt">:'.$TANGGAL_PENDAFTARAN.'</td>';
$content .='</tr>';
$content .='</table></td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td colspan="3"><table width="100%" border="0" cellpadding="2" cellspacing="0">';
$content .='<tr>';
$content .='<td width="7%" class="border-r" style="font-size:9pt">21.</td>';
$content .='<td width="73%" class="border-r" style="font-size:9pt">22.</td>';
$content .='<td width="11%" class="border-r" style="font-size:9pt">23.</td>';
$content .='<td width="9%" style="font-size:9pt">28.</td>';
$content .='</tr>';
$content .='<tr>';
$content .='<td valign="top" class="border-br" style="font-size:9pt">No</td>';
$content .='<td valign="top" class="border-br" style="font-size:9pt">Uraian jumlah dan jenis barang secara lengkap, Kode Barang merk, tipe, ukuran, dan spesifikasi lainya. </td>';
$content .='<td valign="top" class="border-br" style="font-size:9pt">- Jumlah &amp; Jenis<br>
Satuan<br>
- Berat Bersih (kg)<br>
- Volume (m<sup>3</sup>) </td>';
$content .='<td valign="top" class="border-b" style="font-size:9pt">Harga Penyerahan<br></td>';
$content .='</tr>';
return $content;
}
function footerLamp($KOTA_TTD,$TANGGAL_TTD,$NAMA_TTD){
$footer ='</table></td>';
$footer .='</tr>';
$footer .='<tr>';
$footer .='<td width="110" colspan="2" class="border-b border-t">&nbsp;</td>';
$footer .='<td width="358" class="border-b border-t" style="font-size:9pt">E.TANDA TANGAN PENGUSAHA TPB</td>';
$footer .='</tr>';
$footer .='<tr>';
$footer .='<td width="110" colspan="2" rowspan="6">&nbsp;</td>';
$footer .='<td style="font-size:9pt">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini.</td>';
$footer .='</tr>';
$footer .='<tr>';
$footer .='<td>&nbsp;</td>';
$footer .='</tr>';
$footer .='<tr>';
$footer .='<td align="center" style="font-size:9pt">'.$KOTA_TTD.' tgl '.$TANGGAL_TTD.'</td>';
$footer .='</tr>';
$footer .='<tr>';
$footer .='<td>&nbsp;</td>';
$footer .='</tr>';
$footer .='<tr>';
$footer .='<td align="center" style="font-size:9pt">('.$NAMA_TTD.')</td>';
$footer .='</tr>';
$footer .='<tr>';
$footer .='<td>&nbsp;</td>';
$footer .='</tr>';
$footer .='</table>';
$footer .='</div>';
return $footer;	
}

echo headerLamp($DATA['NOMOR_AJU'],$DATA['URAIAN_KPBC'],$DATA['URJENIS_TPB'],$DATA['URTUJUAN_KIRIM'],$DATA['NOMOR_PENDAFTARAN'],$DATA['TANGGAL_PENDAFTARAN']);
if (count($BARANG) > 1){
$no=1;
foreach( $BARANG as $bar):

	if($no%9==0){
		echo "<pagebreak>";
		echo headerLamp($DATA['NOMOR_AJU'],$DATA['URAIAN_KPBC'],$DATA['URJENIS_TPB'],$DATA['URTUJUAN_KIRIM'],$DATA['NOMOR_PENDAFTARAN'],$DATA['TANGGAL_PENDAFTARAN']); 
	}
?>
    <tr>
        <td valign="top" class="border-r"  style="font-size:9pt"><?=$no;?></td>
        <td valign="top" class="border-r" style="font-size:9pt"><?=$bar['JENIS_BARANG'];?>, <?=$bar['URAIAN_BARANG'];?>, <?=$bar['MERK']?>, <?=$bar['TIPE']?>, <?=$bar['UKURAN']?>, <?=$bar['SPF']?></td>
        <td class="border-r" style="font-size:9pt"><?=$bar['JUMLAH_SATUAN'];?>&nbsp;<?=$bar['URAIAN_SATUAN'];?><br><?=$bar['NETTO'];?> Kg<br><?=$bar['VOLUME'];?>&nbsp;m<sup>3</sup></td>
        <td valign="top" style="font-size:9pt"><?=$bar['HARGA_PENYERAHAN'];?></td>
    </tr>
<?php $no++; 
	if($no%9==0){
		echo footerLamp($DATA['KOTA_TTD'],$DATA['TANGGAL_TTD'],$DATA['NAMA_TTD']);
	}
endforeach;?>
<?php }else{ ?>
    <tr>
    	<td colspan="4" class="border-r">&nbsp;</td>
    </tr>
<?php }
	echo footerLamp($DATA['KOTA_TTD'],$DATA['TANGGAL_TTD'],$DATA['NAMA_TTD']);
?>			
<pagebreak  />