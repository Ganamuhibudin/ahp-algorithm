<?php
#PARAMETER
/*$kantor_pabean 		= "TANJUNG PERAK";
$kode_pabean		= "07100";
$no_pengajuan		= "990111 01/07/2004 1125";
$no_pendaftaran		= "00121";
$nama_petugas		= "ANGGUN PATRIANA";
$nip_petugas		= "021281015";
$tkt_pemeriksaan	= "................";
$nama_pejabat		= ".......................";
$nip_pejabat		= ".................";
$tmpt_periksa		= "..........";
$tgl_periksa		= "..............";
$ikhtisar_periksa	= "&nbsp;";
$nama_pemeriksa		= ".........................";
$nip_pemeriksa		= ".........................";*/
?>
	<style type="text/css">
			  .border-b {
						  border-bottom:thin solid #000000;
						  }
			  .border-tbrl {
						  border-top:thin solid #000000;
						  border-bottom:thin solid #000000;
						  border-right:thin solid #000000;
						  border-left:thin solid #000000;
						  }
			  .input50{
						  padding-left:10px;
						  padding-right:10px;
						  width:50px;
						  border-top:thin solid #000000;
						  border-bottom:thin solid #000000;
						  border-right:thin solid #000000;
						  border-left:thin solid #000000;
						  }
			  
				  </style>
					
				<div style="padding:30px 50px 30px 50px;">
					<table align="center" style="width:100%; padding-left:50px; padding-right:50px;">
						<tr>
							<td width="93%" align="center">LEMBAR LAMPIRAN IV<br>PEMBERITAHUAN IMPOR BARANG UNTUK DITIMBUN<br>DI TEMPAT PENIMBUNAN BERIKAT<br>UNTUK CATATAN PEMERIKSAAN FISIK BARANG</td>
							<td width="7%" align="right" valign="bottom">BC 2.3</td>
						</tr>
					</table>
				  <div class="border-tbrl">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td class="border-b"><table width="100%" border="0">
							<tr>
							  <td width="13%">Kantor Pabean </td>
							  <td width="42%">: <?=$DATA['URAIAN_KPBC'];?></td>
							  <td width="32%" align="left" valign="top"><input type="text" name="kode_pabean" class="input50" value="<?=$DATA['KODE_KPBC'];?>"></td>
							  <td width="13%" align="right">Halaman 1 dari ............... </td>
							</tr>
							<tr>
							  <td>Nomor Pengajuan </td>
							  <td colspan="3">: <?=$DATA['NOMOR_AJU']; ?></td>
							</tr>
							<tr>
							  <td>Nomor Pendaftaran</td>
							  <td colspan="3">: <?=$DATA['NOMOR_PENDAFTARAN']; ?></td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td colspan="3">&nbsp;</td>
							</tr>
						</table></td>
			  </tr>
			  <tr>
				<td><table width="100%" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="100%"><table align="left">
					  <tr>
						<td colspan="4" align="center">DIISI DALAM HAL DILAKUKAN PEMERIKSAAN FISIK BARANG</td>
					  </tr>
					  <tr>
						<td colspan="4" align="left">PETUGAS : </td>
					  </tr>
					  <tr>
						<td width="20" align="left">&nbsp;</td>
						<td width="53" align="left">NAMA</td>
						<td width="8" align="left">:</td>
						<td width="363" align="left"></td>
					  </tr>
					  <tr>
						<td align="left">&nbsp;</td>
						<td align="left">NIP</td>
						<td align="left">:</td>
						<td align="left"></td>
					  </tr>
					  <tr>
						<td colspan="4" align="left">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="4" align="left">TINGKAT PEMERIKSAAN :  </td>
					  </tr>
					</table></td>
				  </tr>
				  <tr><td height="167"><table align="center">
					<tr>
					  <td width="211" align="right">.................Tgl. ........................</td>
					  </tr>
					<tr>
					  <td align="center">Pejabat</td>
					  </tr>
					<tr>
					  <td align="left">Tanda tangan</td>
					  </tr>
					<tr>
					  <td align="left">&nbsp;</td>
					  </tr>
					<tr>
					  <td align="left">Nama </td>
					  </tr>
					<tr>
					  <td align="left">NIP </td>
					  </tr>
					<tr>
					  <td align="center">&nbsp;</td>
					  </tr>
				  </table></td></tr>
					<tr>
					<td><table width="100%" align="left">
					  <tr>
						<td width="363">TEMPAT PEMERIKSAAN FIFIK : </td>
						<td width="4">&nbsp;</td>
						<td width="478">TGL. DILAKUKAN PEMERIKSAAN FISIK BARANG : </td>
						<td width="105">&nbsp;</td>
					  </tr>
					  <tr>
						<td>IKHTISAR PEMERIKSAAN : </td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="4" height="100" valign="top"></td>
					  </tr>
					  </table></td>
				  </tr>
				  <tr>
					<td><table align="right" cellpadding="5">
					  <tr>
						<td align="right">.........................Tgl. ....................</td>
					  </tr>
					  <tr>
						<td align="left">Pemeriksa Bea dan Cukai</td>
					  </tr>
					  <tr>
						<td align="left">Tanda tangan</td>
					  </tr>
					  <tr>
						<td align="left">&nbsp;</td>
					  </tr>
					  <tr>
						<td align="left">Nama </td>
					  </tr>
					  <tr>
						<td align="left">NIP </td>
					  </tr>
					  <tr>
						<td align="center">&nbsp;</td>
					  </tr>
					  </table></td>
				  </tr>
				</table></td>
			  </tr>
			</table>
						</div>
				</div>
		