<h5 class="header smaller lighter green"><b>Isi sesuai Invoice/ Dokumen Lain</b></h5>
<form method="post" action="#" name="harga" id="harga">
    <table border="0">
        <tr>
            <td width="120px;">Kode Harga</td>
            <td width="150px;">:
          <combo><select name="KODE_HARGA" id="KODE_HARGA" class="sstext">
          <?php if($kode_harga=='1'){?>
                <option value=""></option>
                <option value="3">1.FOB</option>
                <option value="1" selected>2.CIF</option>
          <?php }elseif($kode_harga=='3'){?>
                <option value=""></option>
                <option value="3" selected>1.FOB</option>
                <option value="1">2.CIF</option>
          <?php }else{?>
                <option value=""></option>
                <option value="3">1.FOB</option>
                <option value="1">2.CIF</option>
          <?php }?>   
         </select></combo>
            </td>
            <td class="hargacif" width="120px;">Harga Invoice</td>
            <td>:&nbsp;<input type="text" name="INVOICEVAL" class="stext date" id="INVOICEVAL" onkeyup="this.value = ThausandSeperator('NILAI_INVOICE_HRG',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?=$this->fungsi->FormatRupiah($invoice,4);?>"/>
            <input type="hidden" name="INVOICE" class="stext date" id="NILAI_INVOICE_HRG" value="<?=$invoice;?>" style="text-align:right;"/></td>
        </tr>
        <tr>
            <td>Nilai Asuransi</td>
            <td>:&nbsp;<input type="text" name="ASURANSIVAL" class="stext date" id="ASURANSIVAL" onkeyup="this.value = ThausandSeperator('NILAI_ASURANSI',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?=$this->fungsi->FormatRupiah($asuransi,4);?>"/>
            <input type="hidden" name="ASURANSI" class="stext date" id="NILAI_ASURANSI" style="text-align:right;" value="<?=$asuransi?>"/></td>
             <td>Harga FOB</td>
            <td>:&nbsp;<input type="text" name="FOB_CON" class="stext date" id="FOB_CON" readonly style="text-align:right;" value="<?=$this->fungsi->FormatRupiah($fob,4);?>"/>
            <input type="hidden" name="FOB" class="stext date" id="FOB" value="<?=$fob;?>" readonly style="text-align:right;"/>
            </td>
        </tr>
        <tr>
            <td>Freight</td>
            <td>:&nbsp;<input type="text" name="FREIGHTVAL" class="stext date" id="FREIGHTVAL" onkeyup="this.value = ThausandSeperator('NILAI_FREIGHT',this.value,4);prosesHarga1('harga')" style="text-align:right;" value="<?=$this->fungsi->FormatRupiah($freight,4);?>">
            <input type="hidden" name="FREIGHT" class="stext date" id="NILAI_FREIGHT" style="text-align:right;" value="<?= $freight?>"/></td>
             <td>Harga CIF</td>
            <td>:&nbsp;<input type="text" name="CIF_CON" class="stext date" id="CIF_CON" readonly style="text-align:right;" value="<?=$this->fungsi->FormatRupiah($cif,4);?>"/>
            <input type="hidden" name="CIF" class="stext date" id="CIF" value="<?=$cif;?>"readonly style="text-align:right;"/></td>
        </tr>
        <tr>
        	<td colspan="4">
            <hr>&nbsp;
            	<a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="getHarga('harga')" style="color:#fff">
                    <i class="icon-save"></i>&nbsp;Save
                </a>
                <a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('harga');" style="color:#fff">
                    <i class="icon-undo"></i>&nbsp;Reset
                </a>
            </td>
        </tr>
    </table>
</form>
