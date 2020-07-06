<div class="border-tbrl">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="8%" align="center" class="border-r border-b"><strong>BC 4.1</strong></td>
	<td width="92%" align="center" class="border-b" height="33pt"><strong>LEMBAR LANJUTAN<br>DOKUMEN PELENGKAP PABEAN</strong></td>
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
	<td colspan="10"><strong>NOMOR PENGAJUAN</strong> :<?=$this->fungsi->FormatAju($DATA['NOMOR_AJU'])?></td>
</tr>   
<tr> 
    <td width="50%" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="3%" valign="top"><strong>A</strong>.</td>
            <td width="26%" valign="top"><strong>KANTOR PABEAN</strong></td>
            <td width="2%" valign="top">:</td>
            <td width="69%" valign="top"><?=$DATA['KODE_KPBC'].' '.ucwords(strtolower($DATA['URAIAN_KPBC']));?></td>
        </tr>
        <tr>
            <td><strong>B</strong>.</td>
            <td><strong>JENIS TPB</strong></td>
            <td>:</td>
            <td><?= $DATA['URJENIS_TPB'];?></td>
        </tr>
        <tr>
            <td><strong>C</strong>.</td>
            <td><strong>TUJUAN PENGIRIMAN</strong></td>
            <td>:</td>
            <td><?= ucwords(strtolower($DATA['URTUJUAN_KIRIM']));?></td>
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
            <td><?=$this->fungsi->FormatDate($DATA['TANGGAL_PENDAFTARAN']);?></td>
        </tr>
        </table>      
    </td>        
</tr> 
<tr> 
    <td valign="top" colspan="2" class="border-t border-b">
    	<table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td width="3%" valign="top" class="border-r border-b" align="center">NO</td>
            <td width="54%" valign="top" class="border-r border-b" align="center">JENIS DOKUMEN</td>
            <td width="26%" valign="top" class="border-r border-b" align="center">NOMOR</td>
            <td width="17%" valign="top" class="border-b" align="center">TANGGAL</td>
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
<?php if (count($DOKUMEN) > 0){ ?>
<div style="position: relative;margin-top:-71em">
<table width="100%" border="0" cellpadding="0" cellspacing="5">
<?php $no=1;?>
<?php foreach( $DOKUMEN as $dok):?> 
<tr>
<td style="font-size:11" width="3%" align="center"><?=$no;?></td>
<td style="font-size:11" width="42%"><?=$dok['JENIS_DOKUMEN'];?></td>
<td style="font-size:11" width="26%"><?=$dok['NOMOR_DOKUMEN'];?></td>
<td style="font-size:11" width="10%"><?=$dok['TANGGAL_DOKUMEN'];?></td>
</tr>
<?php $no++; endforeach;?>
</table>
</div>
<?php }?>