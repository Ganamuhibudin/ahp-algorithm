<div class="border-tbrl">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
        	<td align="center" class="border-b" colspan="2"><strong>LEMBAR LANJUTAN DATA BARANG EKSPOR<br>PEMBERITAHUAN EKSPOR BARANG MELALUI/DARI PUSAT LOGISTIK BERIKAT</strong><br><br>&nbsp;</td>
        </tr>
        <tr>
            <td></td>
        	<td valign="top" >
            	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:-1pt">
                    <tr>
                    	<td width="5%">1. Kantor Pabean Pengawas</td>
                        <td width="1%">:</td>
                        <td width="10%"><?= $DATA['URAIAN_KPBC'] ?></td>
                        <td width="4%" class="border-b border-r border-l" align="center"><?= $DATA['KODE_KPBC'] ?></td>
                        <td width="80%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td>2. Nomor Pengajuan</td>
                        <td>:</td>
                        <td colspan="3"><?= $this->fungsi->formatAju($DATA['NOMOR_AJU']) ?></td>
                    </tr>
                    <tr>
                    	<td>3. Nomor Pendaftaran</td>
                        <td>:</td>
                        <td colspan="3"><?= $DATA['NOMOR_PENDAFTARAN'].'/'.$DATA['TANGGAL_PENDAFTARAN'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="10%" class="border-r border-t" style="text-rotate:90deg;text-align:center;padding:10px"><strong>DATA BARANG EKSPOR</strong></td>
        	<td valign="top" class="border-t">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top" class="border-r border-b">48.<br>No.</td>
                        <td valign="top" class="border-b">49.</td>
                        <td valign="top" class="border-r border-b">- Pos Tarif/HS, <br>- Uraian jumlah dan jenis barang (termasuk merk, tipe, dan spesifikasi wajib)<br>- Negara Asal Barang</td>
                        <td valign="top" class="border-b">50.</td>
                        <td valign="top" class="border-r border-b">Keterangan<br>- Kode Barang<br>- Persyaratan & No.Urut<br>- Fasilitas & No.Urut<br>- Pemilik & No. Urut</td>
                        <td valign="top" class="border-b">51.</td>
                        <td valign="top" class="border-r border-b">- HE Barang<br>- BK<br>- PPh</td>
                        <td valign="top" class="border-b">52.</td>
                        <td valign="top" class="border-r border-b">- Jumlah & Jenis Satuan<br>- Berat Bersih (Kg)<br>- Volume (m3) </td>
                        <td valign="top" class="border-b">53.</td>
                        <td valign="top" class="border-b">- Nilai Barang<br>- FOB</td>
                    </tr>
                    <?php 
                    $no=$loop+1;
                    $looping = $loop;  
                    for($i=$looping;$i<count($BARANG);$i++){
                    ?> 
                    <tr>
                        <td class="border-r" align="center" valign="top"><?= $no;?></td>
                        <td class="border-r" colspan="2" valign="top" style="padding-left:10px;"><?=substr($BARANG[$i]['KODE_HS'],0,4).'.'.substr($BARANG[$i]['KODE_HS'],4,2).'.'.substr($BARANG[$i]['KODE_HS'],6,2).'.'.substr($BARANG[$i]['KODE_HS'],8,2);?><br><?=$BARANG[$i]['URAIAN_BARANG1'].' '.$BARANG[$i]['URAIAN_BARANG2'].' '.$BARANG[$i]['URAIAN_BARANG3'].' '.$BARANG[$i]['URAIAN_BARANG4'];?><br> <?=$BARANG[$i]['MERK']?> / <?=$BARANG[$i]['UKURAN']?> / <?=$BARANG[$i]['TIPE']?> / <?=$BARANG[$i]['SPF']?></td>
                        <td class="border-r" colspan="2" valign="top">&nbsp;</td>
                        <td class="border-r" colspan="2" valign="top" style="padding-left:13px;"><?=$this->fungsi->FormatRupiah($BARANG[$i]['JUMLAH_SATUAN'],4);?> <?=$BARANG[$i]['KODE_SATUAN'];?>/<?=ucwords(strtolower($BARANG[$i]['URAIAN_SATUAN']));?><br><?=$this->fungsi->FormatRupiah($BARANG[$i]['NETTO'],4);?> Kg<br>Kemasan: <?=$BARANG[$i]['JUMLAH_KEMASAN']?> <?=$BARANG[$i]['URAIAN_KEMASAN']?> (<?=$BARANG[$i]['KODE_KEMASAN']?>)</td>
                        <td class="border-r" colspan="2" valign="top" style="padding-left:10px;"><?=$BARANG[$i]['NOMOR_IZIN']?>/<?=($BARANG[$i]['TANGGAL_IZIN']=='0000-00-00')?'':$BARANG[$i]['TANGGAL_IZIN'];?><br><?=$BARANG[$i]['NEGARA_ASAL'].' '.$BARANG[$i]['URAIAN_NEGARA'];?></td>
                        <td colspan="2" valign="top" align="right"><?= $this->fungsi->FormatRupiah($BARANG[$i]['FOB_PER_BARANG'],4);?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="border-r" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" colspan="2" >&nbsp;</td>
                    </tr>
                    <?php  $looping++; $no++; if($looping%10==0) break; }?>  
                    <?php 

                    for($a=0;$a<48-(count($BARANG)*4);$a++){?>
                    <tr>
                        <td valign="top" class="border-r" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" class="border-r" colspan="2" >&nbsp;</td>
                        <td valign="top" colspan="2" >&nbsp;</td>
                    </tr>
                    <?php }?>
                </table>
            </td>
        </tr>
        <tr>
            <td align="right" class="border-t" colspan="2">
                <table border="0" cellpadding="0" cellspacing="0" style="margin-right:50px">
                    <tr>
                        <td align="center">
                            <?=$DATA['KOTA_TTD']?>, Tgl. <?=$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?><br>Eksportir/PPJK<br><br><br><br>( <?=$DATA['NAMA_TTD'];?> )
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
