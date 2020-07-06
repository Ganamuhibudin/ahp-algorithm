<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$arr = explode(";",$data);
foreach($arr as $name){
	$x = explode('|',$name);
	$val[$x[0]] = $x[1];
}

//ndpbm;valuta;cif;fob;freight;asuransi;kodeharga;tambahan;diskon;kode_asuransi;cifrp
?>
<div class="block-flat" style="margin:10px;background-color:#F6F6F6">
<h4 class="header smaller green">Isi sesuai Invoice/ Dokumen Lain</h4>
<form method="post" action="#" name="harga" id="harga" class="form-horizontal">
<table border="0">
	<tr>
    	<td width="120px;">Kode Harga</td>
        <td width="150px;"><?= form_dropdown('HEADER[KDHRG]', $kode_harga, $val['KDHRG'], 'id="KODE_HARGA" class="sstext"  onchange="kode(this.value)" '); ?></td>
        <td class="hargacif" width="120px;">Harga CIF</td>
        <td>
          <input type="text" name="HARGA_CIFUR" class="stext" id="HARGA_CIFUR" onkeyup="this.value = ThausandSeperator('HARGA_CIF', this.value, 4); prosesHarga('harga');" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val['NILINV'], 2); ?>"/>
                        <input type="hidden"  name="HARGA_CIF" id="HARGA_CIF" value="<?= $val['NILINV'] ?>" />
        </td>
    </tr>
    <tr>
    	<td>Valuta</td>
        <td><input type="text" name="HEADER[KODE_VALUTA]" id="KODE_VALUTA" value="<?= $val['KDVAL'] ?>" url="<?= site_url(); ?>/autocomplete/valuta" onfocus="Autocomp(this.id)" urai="KODE_VALUTA" class="stext date" wajib="yes" /> &nbsp;<span id="urtvaluta" style="display:none;"><?= $urtempat_timbun; ?></span></td>
         <td>Biaya Tambahan</td>
        <td><input type="text" name="BIAYAUR" class="stext" id="BIAYAUR" onkeyup="this.value = ThausandSeperator('BIAYAHarga', this.value, 4); prosesHarga('harga');" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val['BTAMBAHAN'], 2); ?>"/>
                        <input type="hidden" name="BIAYAHarga" id="BIAYAHarga" value="<?= $val['BTAMBAHAN'] ?>" />        </td>
    </tr>
   <tr>
                    <td>NDPBM</td>
                    <td><input type="text" name="NDPBMUR" id="NDPBMUR" class="stext" onkeyup="this.value = ThausandSeperator('NDPBMHarga', this.value, 4); prosesHarga('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val['NDPBM'], 4); ?>"/>
                        <input type="hidden"  name="NDPBMHarga" id="NDPBMHarga" value="<?= $val['NDPBM'] ?>" />
                    </td>
                    <td>Discount</td>
                    <td><input type="text" name="DISCOUNTUR" class="stext" id="DISCOUNTUR" onkeyup="this.value = ThausandSeperator('DISCOUNTHarga', this.value, 4); prosesHarga('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val['DISCOUNT'], 2); ?>"/>
                        <input type="hidden"  name="DISCOUNTHarga" id="DISCOUNTHarga" value="<?= $val['DISCOUNT'] ?>" />
                    </td>
                </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
<h4 class="header smaller green">Nilai ini yang akan tercantum di BC 2.0</h4>
<table border="0">
	<tr>
    	<td width="120px;">Asuransi Bayar di</td>
        <td width="150px;"><?= form_dropdown('HEADER[KDASS]', $kode_asuransi, $val['KDASS'], 'id="KODE_ASURANSIHarga" class="sstext" '); ?></td>
        <td class="fob" width="120px;">FOB</td>
        <td><input type="text" name="FOBURHarga" id="FOBURHarga" readonly class="stext" style="text-align:right;" value="<?= $val['FOB']; ?>"/>
                        <input type="hidden" name="FOBHarga" id="FOBHarga" readonly class="stext" style="text-align:right;" value="<?= $val['FOB']; ?>"/></td>
    </tr>
    <tr>
    	<td>Nilai Asuransi</td>
        <td><input type="text" name="NILAI_ASURANSIUR" id="NILAI_ASURANSIUR" class="stext" onkeyup="this.value = ThausandSeperator('NILAI_ASURANSI', this.value, 4);prosesHarga('harga')" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val['ASURANSI'], 2); ?>"/>
                        <input type="hidden"  name="NILAI_ASURANSI" id="NILAI_ASURANSI" value="<?= $val['ASURANSI'] ?>" />
         <input type="hidden"  name="NILAI_ASURANSI" id="NILAI_ASURANSI" value="<?= $val['ASURANSI'] ?>" /></td>
        <td>CIF</td>
        <td><input type="text" name="CIFURHarga" id="CIFURHarga" readonly class="stext" style="text-align:right;" value="<?= $val['CIF']; ?>"/>
                        <input type="hidden" name="CIFHarga" id="CIFHarga" readonly class="stext" style="text-align:right;" value="<?= $val['CIF']; ?>"/></td>        
    </tr>
    <tr>
    	<td>Freight</td>
        <td><input type="text" name="NILAI_FREIGHTUR" id="NILAI_FREIGHTUR" class="stext" onkeyup="this.value = ThausandSeperator('NILAI_FREIGHT', this.value, 4);prosesHarga('harga');" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($val['FREIGHT'], 2); ?>"/>
                        <input type="hidden"  name="NILAI_FREIGHT" id="NILAI_FREIGHT" value="<?= $val['FREIGHT'] ?>" /></td>
        <td>CIF Rp</td>
        <td><input type="text" name="CIFRPHarga" id="CIFRPHarga" readonly class="stext" style="text-align:right;" value="<?= $val['CIFRP']; ?>"/></td>        
    </tr>   
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">   
        <a href="javascript:void(0);" class="btn btn-sm btn-success" id="ok_" style="color:#FCFCFC;"  onclick="getHarga('harga');"><span><i class="icon-save"></i>&nbsp;save&nbsp;</span></a>&nbsp;&nbsp;<a href="javascript:;" class="btn btn-sm btn-warning" style="color:#FCFCFC;" id="cancel_" onclick="cancel('harga');"><span><i class="icon-undo"></i>&nbsp;reset&nbsp;</span></a>
        </td>
    </tr>        
</table>
</form>
</div>
</div>
</div>
<script>
    var kd_Harga = $("#harga #KODE_HARGA").val();
    kode(kd_Harga);
    
function prosesHarga(form) {
    var KDHARGA = $("#" + form + " #KODE_HARGA").val();
    if (KDHARGA != "") {
        var NDPBM       = parseFloat($("#"+form+" #NDPBMHarga").val()?$("#"+form+" #NDPBMHarga").val():0);
        var HARGA_CIF   = parseFloat($("#"+form+" #HARGA_CIF").val()?$("#"+form+" #HARGA_CIF").val():0);
        var BIAYA       = parseFloat($("#"+form+" #BIAYAHarga").val()?$("#"+form+" #BIAYAHarga").val():0);
        var DISCOUNT    = parseFloat($("#"+form+" #DISCOUNTHarga").val()?$("#"+form+" #DISCOUNTHarga").val():0);
        var NILAI_ASURANSI= parseFloat($("#"+form+" #NILAI_ASURANSI").val()?$("#"+form+" #NILAI_ASURANSI").val():0);
        var NILAI_FREIGHT = parseFloat($("#"+form+" #NILAI_FREIGHT").val()?$("#"+form+" #NILAI_FREIGHT").val():0);
        if (KDHARGA != 1){ //khusus harga CIF
            $("#"+form+" #FOBHarga").val(HARGA_CIF + BIAYA - DISCOUNT);
            $("#"+form+" #FOBURHarga").val(ThausandSeperator('', HARGA_CIF + BIAYA - DISCOUNT, 4));
        }else{
            $("#"+form+" #FOBHarga").val('0');
            $("#"+form+" #FOBURHarga").val('0');
        }
        $("#"+form+" #CIFHarga").val(NILAI_ASURANSI + HARGA_CIF + NILAI_FREIGHT + BIAYA - DISCOUNT);
        var CIF = parseFloat($("#"+form+" #CIFHarga").val()?$("#"+form+" #CIFHarga").val():0);
        $("#"+form+" #CIFURHarga").val(ThausandSeperator('', CIF, 4));
        $("#"+form+" #CIFRPHarga").val(ThausandSeperator('', NDPBM * CIF, 4));
        //alert("#"+form+" #CIFRPHarga");
    }
}
</script>
