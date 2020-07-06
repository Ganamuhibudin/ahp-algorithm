<span style="font-size:11;font-family:Arial, Helvetica, sans-serif">
<div class="border-tbrl">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="8%" align="center" class="border-r border-b" height="35pt"><strong>BC 2.8</strong></td>
	<td width="92%" align="center" class="border-b" height="35pt"><strong>LEMBAR LANJUTAN<br>DATA PENGGUNAAN BARANG DAN/ATAU BAHAN IMPOR</strong></td>
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
	<td colspan="10"><strong>NOMOR PENGAJUAN</strong>: <?=$this->fungsi->FormatAju($DATA['NOMOR_AJU'])?></td>
</tr>
<tr>
	<td colspan="10"><strong>KANTOR PABEAN</strong>: <?= ucwords(strtolower($DATA["KODE_KPBC"].' '.$DATA['URAIAN_KPBC']));?></td>
</tr>
<tr> 
    <td width="55%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="3%"><strong>A.</strong></td>
            <td width="23%"><strong>JENIS TPB</strong></td>
            <td width="1%">:</td>
            <td width="73%" colspan="3"><?=$DATA['URJENIS_TPB'];?></td>
        </tr>
        <tr>
            <td><strong>B.</strong></td>
            <td><strong>JENIS BC 2.8</strong></td>
            <td>:</td>
            <td>1.Biasa</td>  
            <td>2.Berkala</td>
            <td><input type="text" name="jns_bc" class="input10" value="<?=$DATA['JENIS_BC28'];?>"></td>
        </tr>
        <tr>
            <td><strong>C.</strong></td>
            <td><strong>KONDISI BARANG</strong></td>
            <td>:</td>
            <td>1.Baik</td>  
            <td>2.Rusak</td>
            <td><input type="text" name="kondisi_brg" class="input10" value="<?=$DATA['KONDISI_BARANG'];?>"></td>
        </tr>
        </table>
    </td>    
    <td width="45%" valign="top" class="border-t border-l">      
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td colspan="5"><strong>KOLOM KHUSUS BEA DAN CUKAI</strong></td>
        </tr>
        <tr>
            <td width="2%">1.</td>
            <td width="18%">Nomor Pendaftaran</td>
            <td width="1%">:</td>
            <td width="79%"><?=$DATA['NOMOR_PENDAFTARAN'];?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Tanggal</td>
            <td>:</td>
            <td><?=$this->fungsi->dateformat($DATA['TANGGAL_PENDAFTARAN']);?></td>
        </tr>
        </table>      
    </td>        
</tr>   
<tr> 
    <td valign="top" colspan="2" class="border-t" width="100%">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%" valign="top" class="border-r border-b">No.Urut<br>Barang</td>
            <td width="23%" valign="top" class="border-r border-b">- No/Tgl Aju<br>- No/Tgl Daftar<br> - Kantor Pabean *)<br> BC 2.3, BC 2.4, BC 2.7</td>
            <td width="6%" valign="top" class="border-r border-b">No.Urut<br>Dlm<br>-BC 2.3<br>-BC 2.4<br>-BC 2.7</td>
            <td width="31%" valign="top" class="border-r border-b">- HS<br>- Uraian barang secara lengkap</td>
            <td width="11%" valign="top" class="border-r border-b">- Jumlah<br>- Satuan</td>
            <td width="14%" valign="top" class="border-r border-b">Nilai&nbsp;&nbsp;<br>- CIF<br>- (Rp)</td>
            <td width="10%" valign="top" class="border-b">Nilai (RP)<br>-BM<br>-Cukai<br>-PPN<br>-PPnBM<br>-PPh</td>
        </tr>
        <tr>
            <td valign="top" class="border-r border-b" align="center">1</td>
            <td valign="top" class="border-r border-b" align="center">2</td>
            <td valign="top" class="border-r border-b" align="center">3</td>
            <td valign="top" class="border-r border-b" align="center">4</td>
            <td valign="top" class="border-r border-b" align="center">5</td>
            <td valign="top" class="border-r border-b" align="center">6</td>
            <td valign="top" align="center" class="border-b">7</td>
        </tr>

        <tr>
            <td valign="top" class="border-r" align="center" height="470pt">&nbsp;</td>
            <td valign="top" class="border-r" height="470pt">&nbsp;</td>
            <td valign="top" class="border-r" height="470pt">&nbsp;</td>
            <td valign="top" class="border-r" height="470pt">&nbsp;</td>
            <td valign="top" class="border-r" height="470pt">&nbsp;</td>
            <td valign="top" class="border-r" height="470pt">&nbsp;</td>
            <td valign="top" height="470pt">&nbsp;</td>
        </tr>
        </table> 
    </td>
</tr>
<tr> 
    <td colspan="2" valign="top" class="border-t">*) Diisi khusus untuk barang berasal dari perusahaan dengan fasilitas KITE</td>
</tr>
<tr> 
    <td width="56%" valign="top" class="border-t border-b"><strong> F.TANDA TANGAN PENGUSAHA TPB</strong></td>
    <td width="44%" valign="top" class="border-t border-b">&nbsp;</td>
</tr>
<tr> 
    <td valign="top">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang<br>diberitahukan dalam pemberitahuan pabean ini.</td>
    <td rowspan="2" align="center">&nbsp;</td>
</tr>
<tr> 
    <td valign="top" align="center"><?=$DATA['KOTA_TTD'];?>, tgl <?=$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?><br><br><br><br>(<?=$DATA['PEMBERITAHU'];?>)</td>
</tr>
</table>
</div>

<!--DATANYA-->
<?php $no=$loop+1;?>
<div style="position: relative;margin-top:-68em">
<table cellpadding="1" cellspacing="0" border="0">
<?php 
$looping = $loop;  
for($i=$looping;$i<count($bahanbaku);$i++){
?> 
<tr>
    <td width="31pt" align="center" valign="top"><?= $bahanbaku[$i]['SERI'].'.'.$bahanbaku[$i]['SERI_BB'];?></td>
    <td width="132pt" valign="top"><?=$bahanbaku[$i]['NOMOR_AJU_ASAL']?$this->fungsi->FormatAju($bahanbaku[$i]['NOMOR_AJU_ASAL']).'<br>':'';echo strtoupper($bahanbaku[$i]['KODE_DOK_ASAL']).' No. '.$bahanbaku[$i]['NOMOR_DOK_ASAL'].'/'.$this->fungsi->dateformat($bahanbaku[$i]['TANGGAL_DOK_ASAL'])?></td>
    <td width="35pt" valign="top" align="center">0</td>
    <td width="158pt" valign="top"><?=substr($bahanbaku[$i]['KODE_HS_BB'],0,4).'.'.substr($bahanbaku[$i]['KODE_HS_BB'],4,2).'.'.substr($bahanbaku[$i]['KODE_HS_BB'],6,2).'.'.substr($bahanbaku[$i]['KODE_HS_BB'],8,2);?><br><?=$bahanbaku[$i]['URAIAN_BARANG_BB'];?><br><?=$bahanbaku[$i]['MERK_BB']?> / <?=$bahanbaku[$i]['UKURAN_BB']?> / <?=$bahanbaku[$i]['TIPE_BB']?> / <?=$bahanbaku[$i]['SPF_BB']?></td>
    <td width="75pt" valign="top"><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['JUMLAH_SATUAN_BB'],4);?><br><?=$bahanbaku[$i]['KODE_SATUAN_BB'].'/'.$bahanbaku[$i]['URAIAN_SATUAN'];?></td>
    <td width="60pt" valign="top">CIF<br><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['CIF_BB'],2)?><br>Rp<br><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['CIFRP'],2)?></td>
    <td valign="top"  width="60pt" align="right"><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['TARIF_BM_BB'],2);?><br><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['TARIF_CUKAI_BB'],2);?><br><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['TARIF_PPN_BB'],2);?><br><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['TARIF_PPNBM_BB'],2);?><br><?=$this->fungsi->FormatRupiah($bahanbaku[$i]['TARIF_PPH_BB'],2);?><br /><br /><br /></td>
</tr>
<?php  $looping++; $no++; if($looping%7==0) break; }?>        
</table>
</div>
</span>