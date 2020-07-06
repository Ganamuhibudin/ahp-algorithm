<div class="border-tbrl">
	<table width="100%" cellpadding="0" cellspacing="0" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
        <tr>
            <td width="8%" align="center" class="border-r border-b"><strong>BC 4.0</strong></td>
            <td width="92%" align="center" class="border-b" height="33pt"><strong>LEMBAR LANJUTAN<br>DATA BARANG</strong></td>
        </tr>
        <tr>
            <td colspan="3" class="border-b"><b>HEADER</b></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
	</table>

	<table width="100%" cellpadding="0" cellspacing="0" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
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
    			<table width="550pt" border="0" cellpadding="5" cellspacing="0">
        			<tr>
                        <td width="21pt" valign="top" class="border-r border-b">21.<br>No</td>
                        <td width="290pt" valign="top" class="border-r border-b">22.<br>
                        Uraian jumlah dan jenis barang secara lengkap, Kode Barang merk, tipe, ukuran, dan spesifikasi lain</td>
                        <td width="150pt" valign="top" class="border-r border-b">23.<br>
                        - Jumlah & Jenis Satuan<br>- Berat Bersih (Kg)<br>- Volume (m3)</td>
                        <td width="89pt" valign="top" class="border-b">24.<br>
                        Harga Penyerahan (Rp)</td>
		        </tr>
        		<tr>
            		<td valign="top" class="border-r" align="center" height="500pt">&nbsp;</td>
                    <td valign="top" class="border-r" height="500pt">&nbsp;</td>
                    <td valign="top" class="border-r" height="500pt">&nbsp;</td>
                    <td valign="top" align="right" height="500pt">&nbsp;</td>
		        </tr>
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
<!--DATANYA-->
<?php $no=$loop+1;?>
<div style="position: relative;margin-top:-70em">
  <table width="550pt" cellpadding="2" cellspacing="0" border="0">
    <?php 
$looping = $loop;  
$Y=1;
for($i=$looping;$i<count($BARANG);$i++){
?>
    <tr>
      <td width="21pt" align="center" valign="top" style="padding-bottom:50px"><?= $no;?></td>
      <td width="290pt" valign="top"><?=substr($BARANG[$i]['KODE_HS'],0,4).'.'.substr($BARANG[$i]['KODE_HS'],4,2).'.'.substr($BARANG[$i]['KODE_HS'],6,2).'.'.substr($BARANG[$i]['KODE_HS'],8,2);?>
        <br>
        <?=$BARANG[$i]['KODE_BARANG'].' , '.$BARANG[$i]['URAIAN_BARANG']?>
        <br>
        <?=$BARANG[$i]['MERK']?>
        /
        <?=$BARANG[$i]['UKURAN']?>
        /
        <?=$BARANG[$i]['TIPE']?>
        /
        <?=$BARANG[$i]['SPF']?>
        <br>
        <?=$BARANG[$i]['JUMLAH_KEMASAN'].' '.$BARANG[$i]['KODE_KEMASAN']?>
        /
        <?=$BARANG[$i]['URAIAN_KEMASAN']?></td>
      <td width="150pt" valign="top"><?=$BARANG[$i]['JUMLAH_SATUAN'];?>
        <?=$BARANG[$i]['URAIAN_SATUAN'];?>
        <br>
        <?=$this->fungsi->FormatRupiah($BARANG[$i]['NETTO'],4);?> Kgm<br>
        <?=$this->fungsi->FormatRupiah($BARANG[$i]['VOLUME'],4);?></td>
      <td width="89pt" valign="top" align="right"><?= $this->fungsi->FormatRupiah($BARANG[$i]['HARGA_PENYERAHAN'],4);?></td>
    </tr>
    <?php  $looping++; $no++; /*if($looping%16==0) break;*/ 
		if($Y==10) break;
		$Y++;
	}
	?>
  </table>
</div>

