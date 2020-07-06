<style type="text/css">	
	.border-brt {
				border-bottom:thin solid #000000;
				border-right:thin solid #000000;
				border-top:thin solid #000000;
				}
	.border-br {
				border-bottom:thin solid #000000;
				border-right:thin solid #000000;
				
				}
	.border-brlt {
				border-top:thin solid #000000;
				border-bottom:thin solid #000000;
				border-left:thin solid #000000;
				border-right:thin solid #000000;
				}
	.border-brl {
				
				border-bottom:thin solid #000000;
				border-left:thin solid #000000;
				border-right:thin solid #000000;
				}
</style>

<table width="100%" cellpadding="0" cellspacing="2">
<tr>
	<td align="center" style="font-size:14px;text-transform:uppercase;font-weight:bold">
    <?= $TRADER["NAMA_TRADER"] ?>
    </td>
</tr>
<tr>
	<td align="center" style="text-transform:uppercase;">
    <div style="width:350px">
    <?= $TRADER["ALAMAT_TRADER"] ?>
    </div>
    </td>
</tr>
<tr>
	<td align="center" style="text-transform:uppercase;">
    <div style="width:350px">   
    TELP.  <?= $TRADER["TELEPON"] ?>, FAX.  <?= $TRADER["FAX"] ?>
    </div>
    </td>
</tr>
<tr>
	<td align="center" style="border-bottom:3px solid #000;border-bottom-style:ridge">&nbsp;</td>
</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="2">
    <tr>
        <td width="10%">Nomor</td>
        <td width="1%">:</td>
        <td width="60%"><?= $SURAT["NO_PERMOHONAN"] ?></td>
        <td width="38%" align="right">Tanggal : <?= $TGL ?></td>           
    </tr>
    <tr>
        <td>Lampiran 1</td>
        <td>:</td>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
   		<td colspan="7" align="center" >
        <table border="0" width="80%" cellpadding="5" cellspacing="0">
            <tr >
                <td width="3%" height="50px;" class="border-brlt">No</td>
                <td width="47%" class="border-brt">Kode dan Uraian Barang</td>
                <td width="15%" class="border-brt">Kondisi Barang</td>
                <td width="15%" class="border-brt">Jumlah Barang</td>
            </tr>
        	<?php $no=1;?>
   			<?php foreach( $LAMPIRANBARANG as $lambar):?>
   			<tr>
        		<td class="border-brl"><?=$no;?></td>
                <td class="border-br"><?=$lambar['KODE_BARANG'];?> &nbsp;-&nbsp; <?=$lambar['URAIAN_BARANG'];?></td>
                <td class="border-br" align="center"><?=$lambar['URKONDISI'];?></td>
                <td class="border-br"><?=$lambar['JUMLAH'];?></td>
           </tr>
           <?php $no++; endforeach; ?>
        </table>
        </td>
   </tr>
   <tr>
        <td colspan="7" height="200px;">&nbsp;</td>
   </tr>
   <tr>
        <td colspan="7" align="right">
        <table>
        	<tr>
            	<td align="center">                
        		Pemohon<br><br><br>M Yusuf Nurrohman
                </td>
            </tr>
        </table>
        </td>
   </tr>     
</table>
<pagebreak  />