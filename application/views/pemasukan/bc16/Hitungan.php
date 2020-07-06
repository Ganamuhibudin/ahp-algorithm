<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$arr = explode(";",$data);
$a=0;
foreach($arr as $name => $isi){
	$val[$a] = $isi;
	$a++;
}
?>
<h5 class="header smaller lighter green"><b>Isi sesuai Invoice/Dokumen lain</b></h5>
<form method="post" name="harga" id="harga">
<table border="0">
	<tr>
    	<td width="120px;">Kode Harga</td>
        <td width="150px;">:&nbsp;<?= form_dropdown('HEADER[KODE_HARGA]', $kode_harga, $val[6], 'id="KODE_HARGA" class="sstext"  onchange="kode(this.value)" '); ?></td>
        <td class="hargacif" width="120px;">Harga CIF</td>
        <td>:&nbsp;<input type="text" name="HARGA_CIFUR" class="sstext" id="HARGA_CIFUR" onkeyup="this.value = ThausandSeperator('HARGA_CIF',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val[11],0);?>"/>
        	<input type="hidden"  name="HARGA_CIF" id="HARGA_CIF" value="<?= $val[11] ?>" />
        </td>
    </tr>
    <tr>
    	<td>Valuta</td>
        <td>:&nbsp;<input type="text" name="HEADER[KODE_VALUTA]" id="KODE_VALUTA" value="<?= $val[1] ?>" url="<?= site_url(); ?>/autocomplete/valuta" onfocus="Autocomp(this.id)" urai="urtvaluta;" class="sstext" wajib="yes" /> &nbsp;<span id="urtvaluta" style="display:none;"><?= $urtempat_timbun; ?></span></td>
         <td>Biaya Tambahan</td>
        <td>:&nbsp;<input type="text" name="BIAYAUR" class="sstext" id="BIAYAUR" onkeyup="this.value = ThausandSeperator('BIAYA',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val[7],2); ?>"/>
         <input type="hidden"  name="BIAYA" id="BIAYA" value="<?= $val[7] ?>" />
        </td>
    </tr>
    <tr>
    	<td>NDPBM</td>
        <td>:&nbsp;<input type="text" name="NDPBMUR" id="NDPBMUR" class="sstext" onkeyup="this.value = ThausandSeperator('NDPBM',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val[0],4); ?>"/>
          <input type="hidden"  name="NDPBM" id="NDPBM" value="<?= $val[0] ?>" />
        </td>
         <td>Discount</td>
        <td>:&nbsp;<input type="text" name="DISCOUNTUR" class="sstext" id="DISCOUNTUR" onkeyup="this.value = ThausandSeperator('DISCOUNT',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val[8],2); ?>"/>
         <input type="hidden"  name="DISCOUNT" id="DISCOUNT" value="<?= $val[8] ?>" /></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
<h5 class="header smaller lighter green"><b>Nilai ini yang akan tercantum di BC 2.3</b></h5>
<table border="0">
	<tr>
    	<td width="120px;">Asuransi Bayar di</td>
        <td width="150px;">:&nbsp;<?= form_dropdown('HEADER[KODE_ASURANSI]', $kode_asuransi, $val[9], 'id="KODE_ASURANSI" class="sstext" '); ?></td>
        <td class="fob" width="120px;">FOB</td>
        <td>:&nbsp;<input type="text" name="FOBUR" id="FOBUR" readonly class="sstext" style="text-align:right;" value="<?= $val[3]; ?>"/>
        <input type="hidden" name="FOB" id="FOB" readonly class="sstext" style="text-align:right;" value="<?= $val[3]; ?>"/></td>
    </tr>
    <tr>
    	<td>Nilai Asuransi</td>
        <td>:&nbsp;<input type="text" name="NILAI_ASURANSIUR" id="NILAI_ASURANSIUR" class="sstext" onkeyup="this.value = ThausandSeperator('NILAI_ASURANSI',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val[5],2); ?>"/>
         <input type="hidden"  name="NILAI_ASURANSI" id="NILAI_ASURANSI" value="<?= $val[5] ?>" /></td>
        <td>CIF</td>
        <td>:&nbsp;<input type="text" name="CIFUR" id="CIFUR" readonly class="sstext" style="text-align:right;" value="<?= $val[2]; ?>"/>
         <input type="hidden" name="CIF" id="CIF" readonly class="sstext" style="text-align:right;" value="<?= $val[2]; ?>"/></td>        
    </tr>
    <tr>
    	<td>Freight</td>
        <td>:&nbsp;<input type="text" name="NILAI_FREIGHTUR" id="NILAI_FREIGHTUR" class="sstext" onkeyup="this.value = ThausandSeperator('NILAI_FREIGHT',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val[4],2); ?>"/>
         <input type="hidden"  name="NILAI_FREIGHT" id="NILAI_FREIGHT" value="<?= $val[4] ?>" /></td>
        <td>CIF Rp</td>
        <td>:&nbsp;<input type="text" name="CIFRPUR" id="CIFRPUR" readonly class="sstext" style="text-align:right;" value="<?= $val[10]; ?>"/>
            <input type="hidden" readonly name="CIFRP" id="CIFRP" value="<?= $val[10]; ?>"/>
      	</td>
    </tr>   
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">   
        <a href="javascript:void(0);" class="btn btn-success btn sm" id="ok_" onclick="getHarga('harga')"><i class="icon-save"></i>&nbsp;Save</a>
        <a href="javascript:;" class="btn btn-warning btn sm" id="cancel_" onclick="cancel('harga');"><i class="icon-undo"></i>&nbsp;Reset</a>
        </td>
    </tr>        
</table>
</form>
<script>
var kdHarga = $("#fbc16 #kodeharga").val();
kode(kdHarga);
$(function(){FormReady();})
</script>
