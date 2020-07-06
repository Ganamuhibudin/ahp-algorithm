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
					<div class="border-tbrl" style="font-size:11pt">
					<table width="100%" cellpadding="0" cellspacing="0">
					  <tr> 
						<td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="5" cellspacing="0">
						  <tr align="center">
							<td width="16%" align="center" class="border-r" height="50" style="font-size:9pt"><strong>BC 4.0 </strong> </td>
							<td width="84%" align="center" height="50" style="font-size:9pt"><strong>LEMBAR LANJUTAN <br>
								DOKUMEN PELENGKAP PABEAN</strong> </td>
						  </tr>
						</table></td>
					  </tr>
					  <tr>
						<td colspan="3" class="border-b" style="font-size:9pt">HEADER</td>
					  </tr>
					  <tr>
						<td colspan="3" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
							  <tr>
								<td colspan="2">&nbsp;</td>
								<td colspan="3">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td>&nbsp;</td>
								<td width="6%">&nbsp;</td>
								<td width="19%" align="right">&nbsp;</td>
							  </tr>
							  <tr>
								<td colspan="2" style="font-size:9pt">NO PENGAJUAN</td>
								<td colspan="3" style="font-size:9pt">: <?= $this->fungsi->FormatAju($DATA['NOMOR_AJU']);?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td width="14%">&nbsp;</td>
								<td>&nbsp;</td>
								<td align="right"></td>
							  </tr>
							   <tr>
								 <td width="2%" style="font-size:9pt">A.</td>
								 <td width="16%" style="font-size:9pt">KANTOR PABEAN </td>
								<td colspan="3" style="font-size:9pt">: <?=$DATA['URAIAN_KPBC'];?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							  </tr>
							   <tr>
								 <td style="font-size:9pt">B.</td>
								 <td style="font-size:9pt">JENIS TPB </td>
								<td colspan="3" style="font-size:9pt">: <?=$DATA['URJENIS_TPB'];?></td>
								<td class="border-r">&nbsp;</td>
								<td class="border-t" style="font-size:9pt">F.</td>
								<td colspan="3" class="border-t" style="font-size:9pt">KOLOM KHUSUS BEA DAN CUKAI</td>
							  </tr>
							   <tr>
								 <td style="font-size:9pt">C.</td>
								 <td style="font-size:9pt">TUJUAN PENGIRIMAN</td>
								<td colspan="3" style="font-size:9pt">: <?=$DATA['URTUJUAN_KIRIM'];?></td>
								<td class="border-r">&nbsp;</td>
								<td>&nbsp;</td>
								<td style="font-size:9pt">Nomor Pendaftaran</td>
								<td colspan="2" style="font-size:9pt">: <?=$DATA['NOMOR_PENDAFTARAN'];?></td>
							  </tr>
							   <tr>
								 <td>&nbsp;</td>
								 <td>&nbsp;</td>
								 <td width="19%">&nbsp;</td>
								 <td width="1%">&nbsp;</td>
								 <td width="21%">&nbsp;</td>
								 <td class="border-r">&nbsp;</td>
								<td>&nbsp;</td>
								<td  style="font-size:9pt">Tanggal</td>
								<td colspan="2" style="font-size:9pt">: <?=$DATA['TANGGAL_PENDAFTARAN'];?></td>
							  </tr>
							</table></td>
					  </tr>
					  
					  <tr>
						<td colspan="3"><table width="100%" border="0" cellpadding="2" cellspacing="0">
						  <tr>
							<td width="3%" align="center" class="border-br" style="font-size:9pt">NO</td>
							<td width="70%" align="center" class="border-br" style="font-size:9pt">JENIS DOKUMEN </td>
							<td width="112%" align="center" class="border-br" style="font-size:9pt">NOMOR</td>
							<td width="10%" align="center" class="border-b" style="font-size:9pt">TANGGAL</td>
						  </tr>
						  <?php if (count($DOKUMEN) > 0){ ?>
						  <?php $no=1;?>
                          <?php foreach( $DOKUMEN as $dok):?> 
                          <tr>
                            <td class="border-r" style="font-size:9pt"><?=$no;?></td>
                            <td valign="top" class="border-r" style="font-size:9pt"><?=$dok['JENIS_DOKUMEN'];?></td>
                            <td class="border-r" style="font-size:9pt"><?=$dok['NOMOR_DOKUMEN'];?></td>
                            <td style="font-size:9pt"><?=$dok['TANGGAL_DOKUMEN'];?></td>
                          </tr>
                          <?php $no++; endforeach;?>
                          <?php }else{ ?>
                          <tr>
                            <td height="32" class="border-r">&nbsp;</td>
                            <td valign="top" class="border-r">&nbsp;</td>
                            <td class="border-r">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php } ?>
						</table></td>
								 </tr>
					  <tr>
						<td width="110" colspan="2" class="border-b border-t">&nbsp;</td>
						<td width="358" class="border-b border-t" style="font-size:9pt">E.TANDA TANGAN PENGUSAHA TPB</td>
					  </tr>
					  <tr>
						<td width="110" colspan="2" rowspan="6">&nbsp;</td>
						<td style="font-size:9pt">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini.</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td align="center" style="font-size:9pt"><?=$DATA['KOTA_TTD'];?> tgl <?=$DATA['TANGGAL_TTD'];?></td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td align="center" style="font-size:9pt">(<?=$DATA['NAMA_TTD'];?>)</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					</table>
				  </div>