
	<table width="100%" cellpadding="0" cellspacing="0" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
		 <tr>
       <td width="92%" align="center" colspan="3" height="35pt"><strong>LEMBAR LANJUTAN<br>
        DOKUMEN PELENGKAP PABEAN</strong></td>
    </tr>
    <tr>
        <td colspan="3" align="right">BC 2.8</td>
    </tr>
	</table>
<div class="border-tbrl">
	<table width="100%" cellpadding="0" cellspacing="0" style="font-size:11;font-family:Arial, Helvetica, sans-serif">
        <tr> 
		    <td width="55%" valign="top"> 
        		<table>
                  <tr>
                      <td width="26%"><strong>KANTOR PABEAN</strong></td>
                      <td width="1%">:</td>
                      <td width="73%"><?= ucwords(strtolower($DATA["KODE_KPBC"].' '.$DATA['URAIAN_KPBC']));?></td>
                  </tr>
                  <tr>
                      <td><strong>NOMOR PENGAJUAN</strong></td>
                      <td>:</td>
                      <td><?=$this->fungsi->FormatAju($DATA['NOMOR_AJU'])?></td>
                  </tr>
                   <tr>
                    <td><strong>NOMOR PENDAFTARAN</strong></td>
                    <td>:</td>
                    <td colspan="3"><?=$DATA['NOMOR_PENDAFTARAN'];?></td>
                  </tr>
                </table>
    		</td>    
            <td width="45%" valign="top">      
	           <table>
                  <tr>
                    <td colspan="3" style="padding-top:-5px" valign="top"><input type="text" class="input40" value="<?=$DATA["KODE_KANTOR_PABEAN"]?>" /></td>
                  </tr>
                  <tr>
                    <td>Tanggal Pengajuan</td>
                    <td>:</td>
                    <td><?=$this->fungsi->dateformat($DATA["TANGGAL_AJU"])?></td>
                  </tr>
                  <tr>
                    <td>Tanggal Pendaftaran</td>
                    <td>:</td>
                    <td><?=$this->fungsi->dateformat($DATA['TANGGAL_PENDAFTARAN']);?></td>
                  </tr>
              </table> 
            </td>        
		</tr>       
	</table>
 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:11;font-family:Arial, Helvetica, sans-serif">    
        <tr>
            <td width="7%" align="center" valign="top" class="border-br border-t">No</td>
            <td width="43%" align="center" valign="top" class="border-br border-t">Jenis Dokumen</td>
            <td width="31%" align="center" valign="top" class="border-br border-t">Nomor</td>
            <td width="19%" align="center" valign="top" class="border-b border-t">Tanggal</td>
        </tr>

<?php 	
	if(count($DOKUMEN) > 0){ 
		$no=1;
		foreach($DOKUMEN as $dok){
			$nomor = $nomor.$no."<br><br>";
			$JENIS_DOKUMEN = $JENIS_DOKUMEN.$dok['JENIS_DOKUMEN']."<br><br>";
			$NOMOR_DOKUMEN = $NOMOR_DOKUMEN.$dok['NOMOR_DOKUMEN']."<br><br>";
			$TANGGAL_DOKUMEN = $TANGGAL_DOKUMEN.$dok['TANGGAL_DOKUMEN']."<br><br>";
			$no++;
		}
?>		
		<tr>
			<td class="border-r" height="510pt" valign="top" align="center"><?=$nomor?></td>
			<td class="border-r" height="510pt" valign="top"><?=$JENIS_DOKUMEN?></td>
			<td class="border-r" height="510pt" valign="top"><?=$NOMOR_DOKUMEN?></td>
			<td height="510" valign="top"><?=$TANGGAL_DOKUMEN?></td>
		</tr>
<?php 	
	}else{	
?>
		<tr>
			<td class="border-r" height="510pt" valign="top" align="center">&nbsp;</td>
			<td class="border-r" height="510pt" valign="top">&nbsp;</td>
			<td class="border-r" height="510pt" valign="top">&nbsp;</td>
			<td height="510" valign="top">&nbsp;</td>
		</tr>
<?php 	
	}
?>       

        <tr> 
            <td colspan="4" valign="top" class="border-t border-r border-b"><strong> F.TANDA TANGAN PENGUSAHA TPB</strong></td>
        </tr>
        <tr> 
            <td valign="top" colspan="2">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal<br>yang diberitahukan dalam pemberitahuan pabean ini.</td>
            <td rowspan="2" colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr> 
            <td valign="top" align="center" colspan="2"><?=$DATA['KOTA_TTD'];?>, tgl <?=$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?><br><br><br><br>(<?=$DATA['PEMBERITAHU'];?>)</td>
        </tr>
	</table>
</div>

