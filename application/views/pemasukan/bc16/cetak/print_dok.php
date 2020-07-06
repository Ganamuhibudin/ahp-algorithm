<style type="text/css">
.border-l {border-left:thin solid #000000;}
.border-t {border-top:thin solid #000000;}
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input50{padding-left:10px;padding-right:10px;width:50px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input10{padding-left:5px;padding-right:5px;width:10px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input40{padding-left:10px;padding-right:10px;width:40px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input100{padding-left:10px;padding-right:10px;width:100px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
</style>
			
<body style="font-size:11; font-family:Tahoma">
<div align="center" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
	<b>PEMBERITAHUAN PABEAN PENGELUARAN BARANG<br>DARI KAWASAN PABEAN UNTUK DITIMBUN DI PUSAT LOGISTIK BERIKAT</b>
</div>
<div align="right" style="font-size:10;font-family:Arial, Helvetica, sans-serif">BC 1.6</div>
<div class="border-tbrl" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
    	<tbody>
        	<tr>
            	<td  style="font-size:11" colspan="3" class="border-b">
                	<table width="100%" border="0"  style="margin-top:-7px">
                		<tbody>
                            <tr>
                              	<td  style="font-size:12" width="120pt">Kantor Pabean Pengawas</td>
                              	<td  style="font-size:12">: <?=$DATA['URAIAN_KPBC_AWAS'];?></td>
                              	<td  style="font-size:12" align="left" valign="top">
                                   	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="kode_pabean" class="input50" value="<?=$DATA['KODE_KPBC_AWAS'];?>">
                              </td>
                            </tr>
                            <tr>
                              	<td  style="font-size:12">Kantor Pabean Bongkar</td>
                              	<td  style="font-size:12">: <?=$DATA['URAIAN_KPBC_BONGKAR'];?></td>
                              	<td  style="font-size:12" align="left">
                                   	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="kode_pabean" class="input50" value="<?=$DATA['KODE_KPBC_BONGKAR'];?>">
                            	</td>
                            </tr>
                            <tr>
                              	<td  style="font-size:12">Nomor Pengajuan </td>
                              	<td  style="font-size:12" colspan="2">: 
									<?=$this->fungsi->FormatAju($DATA["NOMOR_AJU"]);?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Tanggal Pengajuan : <input type="text" name="kode_pabean" class="input50" value="<?=$DATA['TANGGAL_AJU'];?>">
                              	</td>
                            </tr>
            			</tbody>
            		</table>
            	</td>
          	</tr>
            <tr>
            	<td style="font-size:12" class="border-b" colspan="3"><b>A. DATA PEMBERITAHUAN</b></td>
            </tr>
          	<tr>
            	<td  style="font-size:11" width="50%" class="border-br" valign="top">
            		<table width="100%" border="0">
            			<tbody>
                			<tr>
                  				<td style="font-size:12" colspan="4"><b><u>PENGIRIM</u></b></td>
                			</tr>
                			<tr>
                            	<td style="font-size:12" width="1%" valign="top">1. </td>
                              	<td style="font-size:12" width="33%" valign="top">Nama</td>
                                <td style="font-size:12" width="1%" valign="top">:</td>
                                <td style="font-size:12"><?=$DATA["NAMA_PENGIRIM"]?></td>
                              	<td style="font-size:12" width="63%" align="right">
									<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["NEGARA_PENGIRIM"];?>">
                  				</td>
                			</tr>
                            <tr>
                              	<td style="font-size:12" valign="top">2. </td>
                              	<td style="font-size:12" valign="top">Alamat</td>
                                <td style="font-size:12" valign="top">:</td>
                                <td style="font-size:12" valign="top" colspan="2"><?=$DATA["ALAMAT_PENGIRIM"]?></td>
                            </tr>      
            			</tbody>
            		</table>   
            	</td>
            	<td  style="font-size:11" colspan="2" class="border-b" valign="top">
            		<table width="100%" border="0" cellpadding="0">
            			<tbody>
                			<tr>
                  				<td  style="font-size:12" colspan="4"><b>C. Nomor Dan Tanggal Pendaftaran </b></td>
                			</tr>                
                            <tr>
                              	<td style="font-size:12" width="100pt">Nomor</td>
                              	<td style="font-size:12" width="2pt">&nbsp;</td>
                              	<td style="font-size:12" align="right" width="170pt" colspan="2">
                              		<input name="no_daftar" type="text" class="input50" value="<?=$DATA["NOMOR_PENDAFTARAN"];?>">
                                </td>
                            </tr>
                            <tr>
                              	<td style="font-size:12">Tanggal</td>
                              	<td style="font-size:12">&nbsp;</td>
                              	<td style="font-size:12" align="right" colspan="2">
                              		<input name="no_daftar" type="text" class="input50" value="<?=$DATA["TANGGAL_PENDAFTARAN"];?>">
                                </td>
                            </tr>
                            <tr>
                            	<td style="font-size:12">15. Cara Pengangkutan</td>
                              	<td style="font-size:12">:</td>
                              	<td style="font-size:12">
                                	<?=$DATA["URAIAN_MODA"]?>
                                </td>
                                <td align="right" style="font-size:12">
                                	<input name="no_daftar" type="text" style="text-align:center" class="input10" value="<?=$DATA["MODA"];?>">
                                </td>
                            </tr>
                		</tbody>
            		</table>
            	</td>
          	</tr>
          	<tr>
            	<td style="font-size:11" class="border-br" valign="top">
            		<table width="100%" border="0" cellpadding="0">
            			<tbody>
                			<tr>
                  				<td style="font-size:12" colspan="5"><b><u>PENJUAL</u></b></td>
                			</tr>
                			<tr>
                            	<td style="font-size:12" width="1%" valign="top">3. </td>
                              	<td style="font-size:12" width="33%" valign="top">Nama</td>
                                <td style="font-size:12" width="1%" valign="top">:</td>
                                <td style="font-size:12"><?=$DATA["NAMA_PENJUAL"]?></td>
                              	<td style="font-size:12" width="63%" align="right">
									<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["NEGARA_PENJUAL"];?>" />
                  				</td>
                			</tr>
                            <tr>
                              	<td style="font-size:12" valign="top">4. </td>
                              	<td style="font-size:12" valign="top">Alamat</td>
                                <td style="font-size:12" valign="top">:</td>
                                <td style="font-size:12" valign="top" colspan="2"><?=$DATA["ALAMAT_PENJUAL"]?></td>
                            </tr>      
            			</tbody>
            		</table>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <tr>
                              	<td style="font-size:12" colspan="4" class="border-t"><b><u>PENGUSAHA PLB/PDPLB</u></b></td>
                            </tr>
                            <tr>
                              	<td style="font-size:12" width="1pt" valign="top">5.</td>
                              	<td style="font-size:12" width="40pt" valign="top">NPWP</td>
                              	<td style="font-size:12" width="3pt" valign="top">:</td>
                              	<td style="font-size:12" width="230pt" valign="top"><?=$this->fungsi->FormatNPWP($DATA["ID_TRADER"]);?></td>
                            </tr>
                            <tr>
                              	<td  style="font-size:12" valign="top">6.</td>
                              	<td  style="font-size:12" valign="top">Nama</td>
                              	<td  style="font-size:12" valign="top">:</td>
                              	<td  style="font-size:12" valign="top"><?=$DATA["NAMA_TRADER"];?></td>
                            </tr>
                            <tr>
                              	<td  style="font-size:12" valign="top">7.</td>
                              	<td  style="font-size:12" valign="top">Alamat</td>
                              	<td  style="font-size:12" valign="top">:</td>
                              	<td  style="font-size:12" valign="top"><?=$DATA["ALAMAT_TRADER"];?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <tr>
                              	<td style="font-size:12" colspan="5" class="border-t"><b><u>PEMILIK BARANG</u></b></td>
                            </tr>
                            <tr>
                              	<td style="font-size:12" width="1pt" valign="top">8.</td>
                              	<td style="font-size:12" width="40pt" valign="top">NPWP</td>
                              	<td style="font-size:12" width="3pt" valign="top">:</td>
                              	<td style="font-size:12" width="230pt" valign="top"><?=$this->fungsi->FormatNPWP($DATA["ID_PEMILIK"]);?></td>
                                <td style="font-size:12" align="right" valign="top">
                                	<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["NEGARA_PEMILIK"];?>">
                                </td>
                            </tr>
                            <tr>
                              	<td  style="font-size:12" valign="top">9.</td>
                              	<td  style="font-size:12" valign="top">Nama</td>
                              	<td  style="font-size:12" valign="top">:</td>
                              	<td  style="font-size:12" valign="top" colspan="2"><?=$DATA["NAMA_PEMILIK"];?></td>
                            </tr>
                            <tr>
                              	<td  style="font-size:12" valign="top">10.</td>
                              	<td  style="font-size:12" valign="top">Alamat</td>
                              	<td  style="font-size:12" valign="top">:</td>
                              	<td  style="font-size:12" valign="top" colspan="2"><?=$DATA["ALAMAT_PEMILIK"];?></td>
                            </tr>
                        </tbody>
                    </table>
            	</td>
            	<td  style="font-size:12" colspan="2" class="border-b" valign="top">
            		<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td  style="font-size:12" width="2pt">16.</td>
                            <td  style="font-size:12" width="225pt">Nama Sarana Pengangkut & No Voy/Flight & Bendera</td>
                            <td  style="font-size:12" align="right" width="75pt">
                            	<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["BENDERA"];?>">
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12" class="border-b">&nbsp;</td>
                            <td  style="font-size:12" class="border-b">
								<?=$DATA["NAMA_ANGKUT"]?>, <?=$DATA["NOMOR_ANGKUT"]?>, <?=$DATA["URAIAN_BENDERA"]?>
							</td>
                            <td  style="font-size:12" align="right" width="65pt" class="border-b">&nbsp;</td>
                        </tr>
                        <tr>
                            <td  style="font-size:12" class="border-b" colspan="3">
                            	17. Perkiraan Tanggal Tiba : <?=$DATA["PERKIRAAN_TGL_TIBA"]?>
                            </td>
                        </tr>                        
                        <tr>
                            <td  style="font-size:12" class="border-b">18.</td>
                            <td  style="font-size:12" class="border-b">
								Pelabuhan Muat : <?=$DATA["URAIAN_MUAT"]?>
							</td>
                            <td  style="font-size:12" align="right" class="border-b">
                            	<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["PELABUHAN_MUAT"];?>">
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12" class="border-b">19.</td>
                            <td  style="font-size:12" class="border-b">
								Pelabuhan Transit : <?=$DATA["URAIAN_TRANSIT"]?>
							</td>
                            <td  style="font-size:12" align="right" class="border-b">
                            	<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["PELABUHAN_TRANSIT"];?>">
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12" class="border-b">20.</td>
                            <td  style="font-size:12" class="border-b">
								Pelabuhan Bongkar : <?=$DATA["URAIAN_BONGKAR"]?>
							</td>
                            <td  style="font-size:12" align="right" class="border-b">
                            	<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["PELABUHAN_BONGKAR"];?>">
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12">21.</td>
                            <td  style="font-size:12">
                            	Invoice : <?=$no_inv?>
                           	</td>
                            <td  style="font-size:12">
                            	Tgl : <?=$tgl_inv?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12">22.</td>
                            <td  style="font-size:12">
                            	LC : <?=$no_lc?>
                           	</td>
                            <td  style="font-size:12">
                            	Tgl : <?=$tgl_lc?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12">23.</td>
                            <td  style="font-size:12">
                            	BL/AWB : <?=$no_mbl?>
                           	</td>
                            <td  style="font-size:12">
                            	Tgl : <?=$tgl_mbl?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12">&nbsp;</td>
                            <td  style="font-size:12">
                            	H-BL/AWB : <?=$no_hbl?>
                           	</td>
                            <td  style="font-size:12">
                            	Tgl : <?=$tgl_hbl?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12">24.</td>
                            <td  style="font-size:12">
                            	BC 1.1/1.2 : <?=$DATA["NOMOR_PENUTUP"]?>
                           	</td>
                            <td  style="font-size:12">
                            	Tgl : <?=$DATA["TANGGAL_PENUTUP"]?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12" class="border-b">&nbsp;</td>
                            <td  style="font-size:12" class="border-b">
                            	Pos : <?=$DATA["NOMOR_POS"]?>
                           	</td>
                            <td  style="font-size:12" class="border-b">
                            	Sub Pos : <?=$DATA["SUB_POS"]?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12">25.</td>
                            <td  style="font-size:12">
								Dokumen Lainnya : <?=$DATA["URAIAN_BONGKAR"]?>
							</td>
                            <td  style="font-size:12" align="right">
                            	<input type="text" name="kd_negara_pemasok" class="input40" value="<?=$DATA["PELABUHAN_BONGKAR"];?>">
                            </td>
                        </tr>
                        <tr>
                            <td  style="font-size:12">&nbsp;</td>
                            <td  style="font-size:12">
                            	No : <?=$no_inv?>
                           	</td>
                            <td  style="font-size:12">
                            	Tgl : <?=$tgl_inv?>
                            </td>
                        </tr>
            		</table>
             	</td>
          	</tr>
          	<tr>
           		<td  style="font-size:11" class="border-br">
                	<table width="100%" border="0">
                    	<tr>
                            <td  style="font-size:12" colspan="4"><b><u>PPJK</u></b></td>
                        </tr>
                		<tr>
                            <td  style="font-size:12" width="2pt">11.</td>
                            <td  style="font-size:12" width="50pt">NPWP</td>
                            <td  style="font-size:12" width="2%">:</td>
                            <td  style="font-size:12" width="60%"><?=$cara_angkut;?></td>
                    	</tr>
                        <tr>
                            <td  style="font-size:12">12.</td>
                            <td  style="font-size:12">Nama</td>
                            <td  style="font-size:12">:</td>
                            <td  style="font-size:12"><?=$cara_angkut;?></td>
                    	</tr>
                        <tr>
                            <td  style="font-size:12">13.</td>
                            <td  style="font-size:12">Alamat</td>
                            <td  style="font-size:12">:</td>
                            <td  style="font-size:12"><?=$cara_angkut;?></td>
                    	</tr>
                        <tr>
                            <td  style="font-size:12">14.</td>
                            <td  style="font-size:12">NP PPJK</td>
                            <td  style="font-size:12">:</td>
                            <td  style="font-size:12"><?=$cara_angkut;?></td>
                    	</tr>
            		</table>
				</td>
            	<td  style="font-size:12" colspan="2" class="border-b" valign="top">
                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	                	<tr>
                            <td  style="font-size:12" width="2pt" class="border-b">26.</td>
                            <td  style="font-size:12" width="90pt" class="border-b">Tempat Penimbunan </td>
                            <td  style="font-size:12" width="1pt" class="border-b">:</td>
                            <td  style="font-size:12" width="160pt" class="border-b"><?=$DATA["URAIAN_TIMBUN"];?></td>
                            <td  style="font-size:12" width="46pt" align="right" class="border-b">
                            	<input type="text" name="kode_penimbunan" class="input40" value="<?=$DATA["KODE_TIMBUN"];?>">
							</td>
    	            	</tr>
                        <tr>
                            <td  style="font-size:12" class="border-b">27.</td>
                            <td  style="font-size:12" class="border-b">Kode Valuta </td>
                            <td  style="font-size:12" class="border-b">:</td>
                            <td  style="font-size:12" class="border-b"><?=$DATA["URAIAN_VALUTA"];?></td>
                            <td  style="font-size:12" align="right" class="border-b">
                            	<input type="text" name="kode_penimbunan" class="input40" value="<?=$DATA["KODE_VALUTA"];?>">
							</td>
    	            	</tr>
                        <tr>
                            <td  style="font-size:12">28.</td>
                            <td  style="font-size:12">NILAI </td>
                            <td  style="font-size:12">:</td>
                            <td  style="font-size:12" colspan="2"><?=$DATA["UR_KODE_HARGA"];?> : <?=$this->fungsi->FormatRupiah($DATA["NILAI"],2)?></td>
    	            	</tr>
            		</table>
				</td>
          	</tr>
          	<tr>
            	<td  style="font-size:12" class="border-b" valign="top" width="100%" colspan="4">
            		<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td  style="font-size:12" width="30%" class="border-r">29. Nomor, Ukuran dan Tipe Peti Kemas</td>
                            <td  style="font-size:12" width="30%" class="border-r">30. Jumlah, Jenis dan Merk Kemasan</td>
                            <td  style="font-size:12" width="20%" class="border-r">31. Berat Kotor (Kg)</td>
                            <td  style="font-size:12" width="20%">32. Berat Bersih (Kg)</td>
                        </tr>
                        <tr>
                        	<?php if(count($dtkontainer)<=3){ ?>
                          		<td  style="font-size:12" class="border-r"><?=$KONTAINER;?></td>
                            <?php }else{ ?>
                            	<td style="font-size:12" class="border-r">=== <?=count($dtkontainer)?> Kontainer. Lihat lembar lanjutan ===</td>
                            <?php } ?>
							
							<?php if(count($dtkemasan)<=3){ ?>
                          		<td  style="font-size:12" class="border-r"><?=$KEMASAN;?></td>
                            <?php }else{ ?>
                            	<td style="font-size:12" class="border-r">=== <?=count($dtkemasan)?> Kontainer. Lihat lembar lanjutan ===</td>
                            <?php } ?>
                          	<td  style="font-size:12" class="border-r"><?=$this->fungsi->FormatRupiah($DATA["BRUTO"],2)?></td>
                          	<td  style="font-size:12"><?=$this->fungsi->FormatRupiah($DATA["NETTO"],2)?></td>
                        </tr>
                        <tr>
                            <td  style="font-size:12" class="border-r">&nbsp;</td>
                            <td  style="font-size:12" class="border-r">&nbsp;</td>
                            <td  style="font-size:12" class="border-r">&nbsp;</td>
                            <td  style="font-size:12">&nbsp;</td>
                        </tr>
            		</table>
            	</td>
          	</tr>
          	<tr>
            	<td style="font-size:12" colspan="8" class="border-b">
            		<table cellpadding="5" cellspacing="0" width="100%" border="0">
              			<tr>
                			<td width="3%" valign="top" class="border-br"  style="font-size:12">33. No </td>
                			<td width="29%" valign="top" class="border-br"  style="font-size:12">34. - Pos Tarif/HS<br>- Uraian Jenis Barang (termasuk Merk, Tipe, Spesifikasi Wajib)<br>- Negara Asal Barang</td>
                			<td width="20%" valign="top" class="border-br"  style="font-size:12">35. Keterangan<br>- Kategori Barang<br>- Fasilitas & No Urut</td>
                			<td width="9%" valign="top" class="border-br"  style="font-size:12">36. Tarif BM </td>
                			<td width="18%" valign="top" class="border-br"  style="font-size:12">37. Jumlah & Jenis Satuan Barang<br>- Berat Bersih (Kg)<br>- Jumlah & Jenis Kemasan</td>
                			<td width="11%" valign="top" class="border-b"  style="font-size:12">38. - Nilai<br>- Jenis Nilai</td>
              			</tr>             
					  <?php 			  
                      if (count($BARANG) > 1){ 			  
                          $no=1;
                          foreach( $BARANG as $bar):
                      ?> 
                          <tr>
                            <td  style="font-size:11" class="border-r" align="center" valign="top"><?= $no;?></td>
                            <td  style="font-size:11" class="border-r" valign="top">- <?=$this->fungsi->FormatHS($bar['KODE_HS']);?><br>- <?=$bar['URAIAN_BARANG'];?><br>&nbsp;&nbsp;<?=$bar['MERK']?> - <?=$bar['TIPE']?> - <?=$bar['SPF']?><br>- <?=$bar['URAIAN_NEGARA']?></td>
        
                            <td  style="font-size:11" class="border-r" valign="top">- <?=$bar['URAIAN_PENGGUNAAN'];?><br>- <?=$bar["KODE_FAS"]." & ".$bar["SERI"]?></td>
                            <td  style="font-size:11" class="border-r" valign="top">    
                           <? if($bar['KODE_TARIF_BM']=="1"){?>                                                       
                            BM <?=$bar['TARIF_BM']?$bar['TARIF_BM']."%":"-";?> <br>
                           <?=$this->fungsi->getkodefas($bar['KODE_FAS_BM']) ?>:<?=($bar['FAS_BM']=="" || $bar['FAS_BM']==0)?"-":$bar['FAS_BM']."%"?><BR>
                           <? }elseif($bar['KODE_TARIF_BM']=="2"){ ?>
                           BM <?=$bar['TARIF_BM'].'/'.$bar['KODE_SATUAN_BM'].'('.$bar['JUMLAH_BM'].')';?>
                            <?=$this->fungsi->getkodefas($bar['KODE_FAS_BM']) ?>:<?=($bar['FAS_BM']=="" || $bar['FAS_BM']==0)?"-":$bar['FAS_BM']."%"?><BR>
                           <? } ?>
                            </td>
                            <td  style="font-size:11" class="border-r" valign="top">- <?=$this->fungsi->FormatRupiah($bar['JUMLAH_SATUAN'],4);?>&nbsp;<?=$bar['URAIAN_SATUAN'];?><br>- <?=$this->fungsi->FormatRupiah($bar['NETTO'],2);?><br>- <?=$this->fungsi->FormatRupiah($bar['JUMLAH_KEMASAN'],4);?>&nbsp;<?=$bar['URAIAN_KEMASAN'];?></td>
                            <td style="font-size:11" valign="top">
                                - <?=$bar['JENIS_NILAI'];?>&nbsp;<?=$this->fungsi->FormatRupiah($bar['NILAI'],2);?><br>- <?=$bar['JENIS_NILAI'];?>
                            </td>
                          </tr>                         
                          <?php  
						  if($no==5) break;
						  $no++;
						  endforeach; 
						  ?>
                          
                          <?php }elseif(count($BARANG) <1){ ?>
                              <tr>               
                                <td  style="font-size:11"  align="center" colspan="6">=== Belum Terdapat Data Barang === </td>
                              </tr>
                      <?php }else{?>
                              <tr>               
                                <td style="font-size:11" align="center" colspan="6" >=== <?=count($BARANG)?> Jenis Barang. Lihat lembar lanjutan === </td>
                              </tr>
                      <?php }?>
            		</table>
            	</td>
          	</tr>
          	<tr>
                <td style="font-size:11" rowspan="4" valign="top" class="border-r">            
                	<table width="100%" cellspacing="0">
                    	<tr>
                        	<td colspan="3"><b>B. Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam dokumen ini dan keabsahan dokumen pelengkap pabean yang menjadi dasar pembuatan dokumen ini.</b></td>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr>
                        	<td colspan="3"><b>PENGUSAHA PLB/PDPLB/PPJK</b></td>
                        </tr>
                        <tr>
                        	<td width="70pt">Tempat, Tanggal</td>
                            <td width="5pt">:</td>
                            <td>
                            	<?=$DATA["KOTA_TTD"]?>, <?php echo date("d M Y", strtotime($DATA["TANGGAL_TTD"]));?>
                            </td>
                        </tr>
                        <tr>
                        	<td>Nama Lengkap</td>
                            <td>:</td>
                            <td><?=$DATA["PEMBERITAHU"]?></td>
                        </tr>
                        <tr>
                        	<td>Jabatan</td>
                            <td>:</td>
                            <td><?=$DATA["JABATAN"]?></td>
                        </tr>
                        <tr>
                        	<td colspan="3">Tanda Tangan dan Stempel Persahaan :</td>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                    </table>
                </td>
            	<td  style="font-size:11" height="53" colspan="2" valign="top">
                	<b>D. UNTUK PEJABAT BEA DAN CUKAI</b>
            	</td>
          	</tr>
		</tbody>
	</table>
</div>   
<div style="text-align:right; font-size:9">Rangkap ke 1,2,3,4 Untuk Pengusaha PLB/PDPLB/PPJK dan Kantor Pabean</div>
   
    <!--lampiran pertama-->
   <?php
   	$JUM_BARANG = count($BARANG) - 5;
	if($JUM_BARANG>=1){	
		echo "<pagebreak />";	
		$arrdata = array("loop"=>5);  	
		$this->load->view("pemasukan/bc16/cetak/bc16_lampiran_lanjutan",$arrdata);		
		$loop = round($JUM_BARANG/10);
		$x=16;
		if($JUM_BARANG>10){
			for($i=0;$i<$loop;$i++){	
				echo "<pagebreak />";
				$arrdata = array("loop"=>$x);  
				$this->load->view("pemasukan/bc16/cetak/bc16_lampiran_lanjutan",$arrdata);
				$x=$x+10;
			}
		}
	} 
   if (count($DOKUMEN) > 0){
	    echo "<pagebreak>";
  		$this->load->view("pemasukan/bc16/cetak/bc16_lampiran2"); 
   }
   if (count($dtkontainer) > 0){ 
   		echo "<pagebreak />";
   		$this->load->view("pemasukan/bc16/cetak/bc16_lampiran1");   
   }
   ?>
</body>
