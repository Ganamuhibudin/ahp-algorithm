<?php
function headerLampBarang($NOMOR_AJU,$URTUJUAN_PENGIRIMAN,$URAIAN_KPBC_ASAL,$URAIAN_KPBC_TUJUAN,$URJENIS_TPB_ASAL,$NOMOR_PENDAFTARAN,$URJENIS_TPB_TUJUAN,$TANGGAL_PENDAFTARAN)
{
$content ="<div class=\"border-tbrl\">";
$content .='<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="8%" align="center" class="border-r border-b"><strong>BC 2.7</strong></td>
				<td width="92%" align="center" class="border-b" height="33pt"><strong>LEMBAR LANJUTAN<br>DATA BARANG</strong></td>
			</tr>
			<tr>
				<td colspan="3" class="border-b"><b>HEADER</b></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			</table>'; 
$content .="<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
$content .="<tr>";
$content .="<td colspan=\"3\" class=\"border-b\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
$content .="<tr>";
$content .="<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
$content .="<tr>";
$content .="<td colspan=\"2\">&nbsp;</td>";
$content .="<td colspan=\"2\">&nbsp;</td>";
$content .="<td width=\"11%\">&nbsp;</td>";
$content .="<td width=\"2%\">&nbsp;</td>";
$content .="<td width=\"19%\" colspan=\"4\" align=\"right\">&nbsp;</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td colspan=\"2\">NO PENGAJUAN</td>";
$content .="<td colspan=\"2\">: ".FormatAju($NOMOR_AJU)."</td>";
$content .="<td>&nbsp;</td>";
$content .="<td>D.</td>";
$content .="<td colspan=\"4\">TUJUAN PENGIRIMAN: ".$URTUJUAN_PENGIRIMAN."</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td width=\"1%\">A.</td>";
$content .="<td width=\"5%\">KANTOR PABEAN </td>";
$content .="<td colspan=\"2\">&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td colspan=\"3\">&nbsp;</td>";
$content .="<td width=\"19%\">&nbsp;</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td>&nbsp;</td>";
$content .="<td>1. Kantor Asal</td>";
$content .="<td colspan=\"2\">: ".$URAIAN_KPBC_ASAL."</td>";
$content .="<td>&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td width=\"13%\">&nbsp;</td>";
$content .="<td colspan=\"2\">&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td>&nbsp;</td>";
$content .="<td>2. Kantor Tujuan</td>";
$content .="<td colspan=\"2\">: ".$URAIAN_KPBC_TUJUAN."</td>";
$content .="<td class=\"border-r\">&nbsp;</td>";
$content .="<td class=\"border-t\">G.</td>";
$content .="<td colspan=\"4\" class=\"border-t\">KOLOM KHUSUS BEA DAN CUKAI</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td>B.</td>";
$content .="<td>JENIS TPB ASAL</td>";
$content .="<td colspan=\"2\">: ".$URJENIS_TPB_ASAL."</td>";
$content .="<td class=\"border-r\">&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td>Nomor Pendaftaran</td>";
$content .="<td colspan=\"3\">: ".$NOMOR_PENDAFTARAN."</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td>C.</td>";
$content .="<td>JENIS TPB TUJUAN</td>";
$content .="<td colspan=\"2\">: ".$URJENIS_TPB_TUJUAN."</td>";
$content .="<td class=\"border-r\">&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td>Tanggal</td>";
$content .="<td colspan=\"3\">: ".$TANGGAL_PENDAFTARAN."</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td>&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td width=\"12%\">&nbsp;</td>";
$content .="<td width=\"9%\">&nbsp;</td>";
$content .="<td class=\"border-r\">&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td>&nbsp;</td>";
$content .="<td colspan=\"3\">&nbsp;</td>";
$content .="</tr>";
$content .="</table></td>";
$content .="</tr>";
$content .="</table></td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td colspan=\"3\" class=\"border-b\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
$content .="<tr>";
$content .="<td width=\"3%\" class=\"border-r\">29.</td>";
$content .="<td width=\"42%\" class=\"border-r\">30.</td>";
$content .="<td width=\"13%\" class=\"border-r\">31.</td>";
$content .="<td width=\"9%\">32.</td>";
$content .="</tr>";
$content .="<tr>";
$content .="<td valign=\"top\" class=\"border-br\">No</td>";
$content .="<td valign=\"top\" class=\"border-br\">Pos tarif/ HS, uraian jumlah dan jenis barang secara lengkap, kode  barang, merk, tipe,ukuran, dan spesifikasi lain </td>";
$content .="<td valign=\"top\" class=\"border-br\">- Jumlah &amp; Jenis<br>
Satuan<br>- Berat Bersih (kg)<br>- Volume (m3) </td>";
$content .="<td valign=\"top\" class=\"border-b\">- Nilai CIF<br>
- Harga Penyerahan </td>";
$content .="</tr>";
return $content;	
}

function footerLampBarang($KOTA_TTD,$TANGGAL_TTD,$NAMA_PEJABAT_BC_ASAL,$NAMA_PEJABAT_BC_TUJUAN,$NAMA_TTD,$NIP_PEJABAT_BC_ASAL,$NIP_PEJABAT_BC_TUJUAN)
{
$footer  ="</table></td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td colspan=\"3\"><table width=\"100%\" border=\"0\">";
$footer .="</table></td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td width=\"36%\" class=\"border-br\">F. TANDA TANGAN PENGUSAHA TPB</td>";
$footer .="<td colspan=\"2\" class=\"border-b\">H. UNTUK PEJABAT BEA DAN CUKAI </td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td class=\"border-r\">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>";
$footer .="<td width=\"42%\" class=\"border-br\" align=\"center\">Kantor Pabean Asal</td>";
$footer .="<td width=\"22%\" align=\"center\" class=\"border-b\">Kantor Pabean Tujuan</td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td class=\"border-r\">&nbsp;</td>";
$footer .="<td class=\"border-r\">&nbsp;</td>";
$footer .="<td>&nbsp;</td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td align=\"center\" class=\"border-r\">".$KOTA_TTD.", Tgl. ".$TANGGAL_TTD."</td>";
$footer .="<td align=\"center\" class=\"border-r\">&nbsp;</td>";
$footer .="<td>&nbsp;</td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td align=\"center\" class=\"border-r\">&nbsp;</td>";
$footer .="<td class=\"border-r\">Nama : ".$NAMA_PEJABAT_BC_ASAL."</td>";
$footer .="<td>Nama : ".$NAMA_PEJABAT_BC_TUJUAN."</td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td align=\"center\" class=\"border-r\">(".$NAMA_TTD.")</td>";
$footer .="<td class=\"border-r\">Nip : ".$NIP_PEJABAT_BC_ASAL."</td>";
$footer .="<td>Nip : ".$NIP_PEJABAT_BC_TUJUAN."</td>";
$footer .="</tr>";
$footer .="<tr>";
$footer .="<td class=\"border-r\">&nbsp;</td>";
$footer .="<td align=\"center\" class=\"border-r\">&nbsp;</td>";
$footer .="<td>&nbsp;</td>";
$footer .="</tr>";
$footer .="</table>";
$footer .="</div>";
return $footer;	
}

		  echo headerLampBarang($DATA['NOMOR_AJU'],$DATA['URTUJUAN_PENGIRIMAN'],$DATA['KODE_KPBC_ASAL'].'-'.$DATA['URAIAN_KPBC_ASAL'],$DATA['KODE_KPBC_TUJUAN'].'-'.$DATA['URAIAN_KPBC_TUJUAN'],$DATA['JENIS_TPB_ASAL'].'-'.$DATA['URJENIS_TPB_ASAL'],$DATA['NOMOR_PENDAFTARAN'],$DATA['JENIS_TPB_TUJUAN'].'-'.$DATA['URJENIS_TPB_TUJUAN'],$DATA['TANGGAL_PENDAFTARAN']);
		  if (count($BARANG) > 1){ ?>
          <?php $no=1;?>
          <?php foreach( $BARANG as $bar):
		  if($no%11==0){
			  echo "<pagebreak>";
			   echo headerLampBarang($DATA['NOMOR_AJU'],$DATA['URTUJUAN_PENGIRIMAN'],$DATA['KODE_KPBC_ASAL'].'-'.$DATA['URAIAN_KPBC_ASAL'],$DATA['KODE_KPBC_TUJUAN'].'-'.$DATA['URAIAN_KPBC_TUJUAN'],$DATA['JENIS_TPB_ASAL'].'-'.$DATA['URJENIS_TPB_ASAL'],$DATA['NOMOR_PENDAFTARAN'],$DATA['JENIS_TPB_TUJUAN'].'-'.$DATA['URJENIS_TPB_TUJUAN'],$DATA['TANGGAL_PENDAFTARAN']);
			}
		  ?>
          
          <tr>
            <td class="border-r" valign="top"><?=$no;?></td>
            <td  valign="top" class="border-r"><?=$bar['KODE_HS'];?><br><?=$bar['KODE_BARANG'].', '.$bar['URAIAN_BARANG'];?>, <?=$bar['MERK']?>, <?=$bar['TIPE']?></td>
            <td class="border-r" valign="top"><?=number_format($bar['JUMLAH_SATUAN'],2,'.',',').' '.$bar['KODE_SATUAN'];?><br><?=$bar['URKODE_SATUAN'];?><br><?=number_format($bar['NETTO'],2,'.',',').' Kg';?><br><?=number_format($bar['VOLUME'],2,'.',',').' m3';?></td>
            <td><?=number_format($bar['CIF'],2,'.',',');?><br><?=number_format($bar['HARGA_PENYERAHAN'],2,'.',',')?></td>
          </tr>
           <?php $no++;
		   if($no%11==0){
			 echo footerLampBarang($DATA['KOTA_TTD'],$DATA['TANGGAL_TTD'],$DATA['NAMA_PEJABAT_BC_ASAL'],$DATA['NAMA_PEJABAT_BC_TUJUAN'],$DATA['NAMA_TTD'],$DATA['NIP_PEJABAT_BC_ASAL'],$DATA['NIP_PEJABAT_BC_TUJUAN']);
			}
		    endforeach;?>
           <?php }else{ ?>
          <tr>
            <td class="border-r">&nbsp;</td>
            <td class="border-r">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php } 
		  if(count($BARANG)!=32){
          	echo footerLampBarang($DATA['KOTA_TTD'],$this->fungsi->dateformat($DATA['TANGGAL_TTD']),$DATA['NAMA_PEJABAT_BC_ASAL'],$DATA['NAMA_PEJABAT_BC_TUJUAN'],$DATA['NAMA_TTD'],$DATA['NIP_PEJABAT_BC_ASAL'],$DATA['NIP_PEJABAT_BC_TUJUAN']); 
		  }
		  ?>   