<div align="center" style="font-size:12"><b>LEMBAR LANJUTAN<br>PEMBERITAHUAN PABEAN<br>PENIMBUNAN BARANG IMPOR DI PUSAT LOGISTIK BERIKAT</b></div>
<div align="right" style="font-size:10">BC 1.6</div>
<div class="border-tbrl">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  		<tr>
    		<td style="font-size:12" class="border-b">
    			<table width="100%" border="0"  style="margin-top:-6px">
        			<tr>
          				<td style="font-size:12" width="13%">Kantor Pabean </td>
          				<td style="font-size:12" width="42%">: <?=$DATA['URAIAN_KPBC_BONGKAR'];?></td>
          				<td style="font-size:12" width="32%" align="left" valign="top">
                        	<input type="text" name="kode_pabean" class="input50" value="<?=$DATA['KODE_KPBC_BONGKAR'];?>">
						</td>
          				<td style="font-size:12" width="13%" align="right"></td>
        			</tr>
        			<tr>
          				<td style="font-size:12">Nomor Pengajuan </td>
          				<td style="font-size:12" colspan="3">: <?=$this->fungsi->FormatAju($DATA['NOMOR_AJU']); ?></td>
        			</tr>
        			<tr>
          				<td style="font-size:12">Nomor Pendaftaran</td>
          				<td style="font-size:12" colspan="3">: 
							<?=$DATA['NOMOR_PENDAFTARAN'].'/'.$this->fungsi->dateformat($DATA['TANGGAL_PENDAFTARAN']); ?>
						</td>
        			</tr>
    			</table>
    		</td>
  		</tr>
  		<tr>
    		<td style="font-size:11">
            	<table width="100%" cellpadding="5" cellspacing="0" style="position:absolute;">
  					<tr>
    					<td style="font-size:12" width="1%" valign="top" class="border-br">33.<br>No </td>
                        <td style="font-size:12" width="22%" valign="top" class="border-br">
                            34. - Pos Tarif/HS<br />
                            - Uraian Jenis Barang (termasuk Merk, Tipe, Spesifikasi Wajib)<br>
                            - Negara Asal Barang
                        </td>
                        <td style="font-size:12" width="14%" valign="top" class="border-br">
                            35. Keterangan<br />
                            - Kategori Barang<br />
                            - Fasilitas & No Urut
                        </td>
                        <td style="font-size:12" width="15%" valign="top" class="border-br">
                            36. Tarif BM
                        </td>
                        <td style="font-size:12" width="17%" valign="top" class="border-br">
                            37. Jumlah & Jenis Satuan Barang<br >
                            - Berat Bersih (Kg)<br>
                            - Jumlah & Jenis Kemasan
                        </td>
                        <td style="font-size:12" width="14%" valign="top" class="border-b">
                            38. - Nilai<br >
                            - Jenis Nilai
                        </td>
                    </tr>   
                    <tr>
                        <td style="font-size:12" class="border-r" align="center" valign="top" height="530pt">&nbsp;</td>
                        <td style="font-size:12" class="border-r" height="530pt">&nbsp;</td>
                        <td style="font-size:12" class="border-r" valign="top" height="530pt">&nbsp;</td>
                        <td style="font-size:12" class="border-r" valign="top" height="530pt">&nbsp;</td>
                        <td style="font-size:12" class="border-r" valign="top" height="530pt">&nbsp;</td>
                        <td style="font-size:12" valign="top" height="530pt">&nbsp;</td>
                    </tr>               
                </table>
			</td>
		</tr>
	</table>
</div>
<table align="right" width="100%" class="border-br border-l" style="font-size:12">
	<tr>
    	<td colspan="3"><b>PENGUSAHA PLB/PDPLB/PPJK</b></td>
    </tr>
    <tr>
        <td width="75pt">Tempat, Tanggal</td>
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
<div style="text-align:right; font-size:9">Rangkap ke 1,2,3,4 Untuk Pengusaha PLB/PDPLB/PPJK dan Kantor Pabean</div>

  <!--DATANYA-->
  <?php $no=$loop+1;?>
  <div style="position: relative;margin-top:-78em">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
  <?php 
  $looping = $loop;
  $Y=1;
  for($i=$looping;$i<count($BARANG);$i++){
  ?> 
  <tr>  
   <td  style="font-size:12" width="4%" align="center" valign="top"><?= $no;?></td>
   <td  style="font-size:11" width="34%" valign="top">- <?=$this->fungsi->FormatHS($BARANG[$i]['KODE_HS']);?><br>- <?=$BARANG[$i]['URAIAN_BARANG'];?><br>&nbsp;&nbsp;<?=$BARANG[$i]['MERK']?$BARANG[$i]['MERK']:'-'?> - <?=$BARANG[$i]['TIPE']?$BARANG[$i]['TIPE']:'-'?> - <?=$BARANG[$i]['SPF']?$BARANG[$i]['SPF']:'-'?><br>- <?=$BARANG[$i]['URAIAN_NEGARA']?$BARANG[$i]['URAIAN_NEGARA']:'-'?></td>
   <td  style="font-size:12" width="19%" valign="top">- <?=$BARANG[$i]['URAIAN_PENGGUNAAN'];?><br />- <?=$BARANG[$i]['KODE_FAS'];?> & <?=$BARANG[$i]['SERI'];?></td>
   <td  style="font-size:12;" width="12%" valign="top">                                                           
   <? if($BARANG[$i]['KODE_TARIF_BM']=="1"){?>                                                       
   BM <?=$BARANG[$i]['TARIF_BM']?$BARANG[$i]['TARIF_BM']."%":"-";?> <br>
   <?=$this->fungsi->getkodefas($BARANG[$i]['KODE_FAS_BM']) ?>:<?=($BARANG[$i]['FAS_BM']=="" || $BARANG[$i]['FAS_BM']==0)?"-":$BARANG[$i]['FAS_BM']."%"?><BR>
   <? }elseif($BARANG[$i]['KODE_TARIF_BM']=="2"){ ?>
   BM <?=$BARANG[$i]['TARIF_BM'].'/'.$BARANG[$i]['KODE_SATUAN_BM'].'('.$BARANG[$i]['JUMLAH_BM'].')';?>
    <?=$this->fungsi->getkodefas($BARANG[$i]['KODE_FAS_BM']) ?>:<?=($BARANG[$i]['FAS_BM']=="" || $BARANG[$i]['FAS_BM']==0)?"-":$BARANG[$i]['FAS_BM']."%"?><BR>
   <? } ?>
   </td>
   <td  style="font-size:12" width="22%" valign="top">- <?=$this->fungsi->FormatRupiah($BARANG[$i]['JUMLAH_SATUAN'],4);?>&nbsp;<?=$BARANG[$i]['URAIAN_SATUAN'];?><br>- <?=$this->fungsi->FormatRupiah($BARANG[$i]['NETTO'],2);?><br>- <?=$this->fungsi->FormatRupiah($BARANG[$i]['JUMLAH_KEMASAN'],4);?>&nbsp;<?=$BARANG[$i]['URAIAN_KEMASAN'];?></td>
   <td style="font-size:12" valign="top" width="10%">- <?=$BARANG[$i]['JENIS_NILAI'];?>&nbsp;<?=$this->fungsi->FormatRupiah($BARANG[$i]['NILAI'],2);?><br>- <?=$BARANG[$i]['JENIS_NILAI'];?></td>     
  </tr>  
  <?php  $looping++; $no++; //if($looping%16==0) break; 
		if($Y==10) break;
		$Y++; }?>                  
  </table>       
  </div>
  <!--END-->

