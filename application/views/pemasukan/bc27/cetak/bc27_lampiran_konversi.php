<?php
function headerLampKonv($NOMOR_AJU,$URTUJUAN_PENGIRIMAN,$URAIAN_KPBC_ASAL,$URAIAN_KPBC_TUJUAN,$URJENIS_TPB_ASAL,$NOMOR_PENDAFTARAN,$URJENIS_TPB_TUJUAN,$TANGGAL_PENDAFTARAN)
{
	$content ="<div class=\"border-tbrl\">";
	$content .='<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="8%" align="center" class="border-r border-b"><strong>BC 2.7</strong></td>
					<td width="92%" align="center" class="border-b" height="33pt"><strong>LEMBAR LAMPIRAN<br>KONVERSI PEMAKAIAN BAHAN (SUBKONTRAK) </strong></td>
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
	$content .="<td colspan=\"2\" class=\"border-b\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$content .="<tr>";
	$content .="<td><table width=\"100%\" height=\"121\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$content .="<tr>";
	$content .="<td colspan=\"2\">&nbsp;</td>";
	$content .="<td width=\"37%\">&nbsp;</td>";
	$content .="<td width=\"1%\">&nbsp;</td>";
	$content .="<td width=\"2%\">&nbsp;</td>";
	$content .="<td width=\"18%\">&nbsp;</td>";
	$content .="<td width=\"1%\">&nbsp;</td>";
	$content .="<td width=\"24%\" align=\"right\">&nbsp;</td>";
	$content .="</tr>";
	$content .="<tr>";
	$content .="<td colspan=\"2\">NO PENGAJUAN</td>";
	$content .="<td>: ".FormatAju($NOMOR_AJU)."</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>D.</td>";
	$content .="<td>TUJUAN PENGIRIMAN</td>";
	$content .="<td>: </td>";
	$content .="<td>".$URTUJUAN_PENGIRIMAN."</td>";
	$content .="</tr>";
	$content .="<tr>";
	$content .="<td width=\"1%\">A.</td>";
	$content .="<td width=\"5%\">KANTOR PABEAN </td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="</tr>";
	$content .="<tr>";
	$content .="<td width=\"2%\">&nbsp;</td>";
	$content .="<td>1. Kantor Asal</td>";
	$content .="<td>: ".$URAIAN_KPBC_ASAL."</td>";
	$content .="<td class=\"border-r\">&nbsp;</td>";
	$content .="<td class=\"border-t\">F.</td>";
	$content .="<td colspan=\"3\" class=\"border-t\">KOLOM KHUSUS BEA DAN CUKAI</td>";
	$content .="</tr>";
	$content .="<tr>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>2. Kantor Tujuan</td>";
	$content .="<td>: ".$URAIAN_KPBC_TUJUAN."</td>";
	$content .="<td class=\"border-r\">&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>Nomor Pendaftaran</td>";
	$content .="<td colspan=\"2\">: ".$NOMOR_PENDAFTARAN."</td>";
	$content .="</tr>";
	$content .="<tr>";
	$content .="<td>B.</td>";
	$content .="<td>JENIS TPB ASAL</td>";
	$content .="<td>: ".$URJENIS_TPB_ASAL."</td>";
	$content .="<td class=\"border-r\">&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>Tanggal</td>";
	$content .="<td colspan=\"2\">: ".$TANGGAL_PENDAFTARAN."</td>";
	$content .="</tr>";
	$content .="<tr>";
	$content .="<td>C.</td>";
	$content .="<td>JENIS TPB TUJUAN</td>";
	$content .="<td>: ".$URJENIS_TPB_TUJUAN."</td>";
	$content .="<td class=\"border-r\">&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td>&nbsp;</td>";
	$content .="<td colspan=\"2\">&nbsp;</td>";
	$content .="</tr>";
	$content .="</table></td>";
	$content .="</tr>";
	$content .="</table></td>";
	$content .="</tr>";
	$content .="</table>";
	
	$content .="<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
	$content .="<tr>";
	$content .="<td align=\"center\" colspan='4' class=\"border-br\" width=\"50%\">Barang Jadi</td>";
	$content .="<td align=\"center\" colspan='3' class=\"border-b\" width=\"50%\">Bahan Baku yang digunakan</td>";
	$content .="</tr>";
	$content .="<tr>";
	$content .="<td width=\"2%\" valign=\"top\" class=\"border-br\">No</td>";
	$content .="<td width=\"30%\" valign=\"top\" class=\"border-br\">Pos Tarif /HS uraian jumlah dan jenis barang secara <br>lengkap, kode barang,merek, tipe, ukuran dan spesifikasi<br> lain</td>";
	$content .="<td width=\"4%\" align=\"center\" valign=\"top\" class=\"border-br\">Jumlah</td>";
	$content .="<td width=\"4%\" align=\"center\" valign=\"top\" class=\"border-br\">Satuan</td>";
	$content .="<td width=\"30%\" valign=\"top\" class=\"border-br\">Pos Tarif /HS uraian jumlah dan jenis barang secara <br>lengkap, kode barang,merek, tipe, ukuran dan spesifikasi<br> lain</td>";
	$content .="<td width=\"4%\" align=\"center\" valign=\"top\" class=\"border-br\">Jumlah</td>";
	$content .="<td width=\"4%\" align=\"center\" valign=\"top\" class=\"border-b\">Satuan</td>";
	$content .="</tr>";
	return $content;	
}

function footerLampKonv($KOTA_TTD,$TANGGAL_TTD,$NAMA_TTD){
	$footer .="<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";	
	$footer .="<tr>";
	$footer .="	<td class=\"border-b\" width=\"55%\">&nbsp;&nbsp;</td>";
	$footer .="	<td class=\"border-b\" width=\"45%\">E TANDA TANGAN PENGUSAHA TPB</td>";
	$footer .="</tr>";
	$footer .="<tr>";
	$footer .="	<td rowspan='7'>&nbsp;&nbsp;</td>";
	$footer .="	<td>Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>";
	$footer .="</tr>";
	$footer .="<tr>";
	$footer .="	<td align=\"center\" >&nbsp;</td>";
	$footer .="</tr>";
	$footer .="<tr>";
	$footer .="	<td align=\"center\" >".$KOTA_TTD.", Tgl. ".$this->fungsi->dateformat($TANGGAL_TTD)."</td>";
	$footer .="</tr>";
	$footer .="<tr>";
	$footer .="	<td align=\"center\" >&nbsp;</td>";
	$footer .="</tr>";
	$footer .="<tr>";
	$footer .="	<td align=\"center\" >&nbsp;</td>";
	$footer .="</tr>";
	$footer .="<tr>";
	$footer .="	<td align=\"center\">(".$NAMA_TTD.")</td>";
	$footer .="</tr>";
	$footer .="</table>";
	$footer .="</div>";
	return $footer;
}


	$this->db->where(array('NOMOR_AJU' => $DATA['NOMOR_AJU']));
	$this->db->from('T_BC27_BB');
	$jumTotBB= $this->db->count_all_results();
	//echo 'Total Bahan Baku :'.$jumTotBB;
	
	echo headerLampKonv($DATA['NOMOR_AJU'],$DATA['URTUJUAN_PENGIRIMAN'],$DATA['URAIAN_KPBC_ASAL'],$DATA['URAIAN_KPBC_TUJUAN'],$DATA['URJENIS_TPB_ASAL'],$DATA['NOMOR_PENDAFTARAN'],$DATA['URJENIS_TPB_TUJUAN'],$DATA['TANGGAL_PENDAFTARAN']);
	if(count($BARANGJD)>1){
	  $no=1; $nm=1;
      foreach($BARANGJD as $barJd):	 	  
		if($no%11==0){
			echo "<pagebreak>";
			echo headerLampKonv($DATA['NOMOR_AJU'],$DATA['URTUJUAN_PENGIRIMAN'],$DATA['URAIAN_KPBC_ASAL'],$DATA['URAIAN_KPBC_TUJUAN'],$DATA['URJENIS_TPB_ASAL'],$DATA['NOMOR_PENDAFTARAN'],$DATA['URJENIS_TPB_TUJUAN'],$DATA['TANGGAL_PENDAFTARAN']);
		}
	  
		$query = $this->db->get_where('T_BC27_BB', array('NOMOR_AJU' => $barJd['NOMOR_AJU'],'SERIBJ' => $barJd['SERIBJ']), '', '');
		
		$this->db->where(array('NOMOR_AJU' => $barJd['NOMOR_AJU'],'SERIBJ' => $barJd['SERIBJ']));
		$this->db->from('T_BC27_BB');
		$jumBB= $this->db->count_all_results();
		$jumArrBB[]=$jumBB;
		$rowspan="";
		if($jumBB>11) $rowspan=11;		
		else $rowspan=$jumBB;
		?>
        <tr>
            <td class="border-br" valign="top" rowspan="<?=$rowspan?>"><?=$no?></td>
            <td class="border-br" valign="top" rowspan="<?=$rowspan?>">
            <?= 
                $barJd['KODE_HS'].'<br>'.ucwords(strtolower($barJd['URAIAN_BARANG'])).'<br>'.$barJd['MERK'].',
                '.$barJd['TIPE'].','.$barJd['UKURAN'].','.$barJd['SPF'];
            ?>
            </td>
            <td class="border-br" align="right" rowspan="<?=$rowspan?>"  valign="top"><?=$barJd['JUMLAH_SATUAN'];?></td>
            <td class="border-br" rowspan="<?=$rowspan?>"  valign="top"><?=$barJd['KODE_SATUAN'];?></td>
            
        
	  <?
		if($jumBB > 0){
			$x=1; $rowspan="";					
			foreach ($query->result() as $row):
				if($nm%(11-($nexjumBB?$nexjumBB:0))==0){
					$rowspan = $jumBB-($x-1);
					//$nexjumBB = $rowspan+1;
					echo "</table>";
					echo footerLampKonv($DATA['KOTA_TTD'],$DATA['TANGGAL_TTD'],$DATA['NAMA_TTD']);
					echo "<pagebreak />";
					echo headerLampKonv($DATA['NOMOR_AJU'],$DATA['URTUJUAN_PENGIRIMAN'],$DATA['URAIAN_KPBC_ASAL'],$DATA['URAIAN_KPBC_TUJUAN'],$DATA['URJENIS_TPB_ASAL'],$DATA['NOMOR_PENDAFTARAN'],$DATA['URJENIS_TPB_TUJUAN'],$DATA['TANGGAL_PENDAFTARAN']);
					echo '<tr>
							<td class="border-br" valign="top" rowspan="'.$rowspan.'">&nbsp;</td>
							<td class="border-br" valign="top" rowspan="'.$rowspan.'">&nbsp;</td>
							<td class="border-br" align="right" rowspan="'.$rowspan.'" valign="top">&nbsp;</td>
							<td class="border-br" rowspan="'.$rowspan.'" valign="top">&nbsp;</td>';
				}
				
			?>
            
            <? if($x!=1 && ($nm%(11-($nexjumBB?$nexjumBB:0))!=0)){?>
             <tr>
            <? } ?>            
				<td class="border-br" valign="top">
				<?= //11+($nexjumBB?$nexjumBB:0).'<-'.$x.'<>'.$nexjumBB.'<='.
					$row->KODE_HS.'<br>'.$row->URAIAN_BARANG.'<br>'.$row->KODE_BARANG.',
					'.$row->MERK.','.$row->TIPE.','.$row->UKURAN.',<br>'.$row->SPF;
				?>
				</td>
				<td class="border-br"  valign="top"><?=$row->JUMLAH_SATUAN;?></td>
				<td class="border-b"  valign="top"><?=$row->KODE_SATUAN;?></td>
			</tr>
			
			<? $x++; $nm++; endforeach; ?>   
            
			<? }else{
		?>
		
		<tr>
			<td colspan="3" height="-20px" align="center">Belum Terdapat Data</td>
		</tr>
		
		<? }?>
        
<?php $no++; endforeach;?>         

</table>

<?php }else{ ?>
<tr>
<td class="border-br" colspan="7" align="center">Belum Terdapat Data</td>
</tr>
<?php }
echo footerLampKonv($DATA['KOTA_TTD'],$DATA['TANGGAL_TTD'],$DATA['NAMA_TTD']);
?>

