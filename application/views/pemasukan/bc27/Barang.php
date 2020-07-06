<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fbarang_form">
<?php if (!$list) { ?>
	 <form id="fbarang_" action="<?= site_url() . "/pemasukan/barang/bc27"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?= site_url() . "/pemasukan/detil/barang/bc27" ?>">
     	<input type="hidden" readonly name="act" value="<?= $act; ?>" />
        <input type="hidden" readonly name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" readonly name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
        <table width="100%" border="0">
        	<tr>
            	<td width="45%" valign="top">		
                	<table width="100%" border="0">
                    	<tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td>Kode HS/Seri HS</td>
                            <td>
                                <input type="text" name="BARANG[KODE_HS]" id="KODE_HS" url="<?= site_url(); ?>/autocomplete/hs" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" onfocus="Autocomp(this.id);" urai="SERI_HS;" maxlength="13" onblur="this.value = FormatHS(this.value)"/> /&nbsp;<input type="text" name="BARANG[SERI_HS]" id="SERI_HS" class="ssstext" value="<?= $sess['SERI_HS']; ?>" wajib="yes"/><input type="hidden" name="trf_serihs" id="trf_serihs" value="<?= $sess['SERI_HS']; ?>" /> 
                            </td>
                        </tr> 
                        <tr>            
                            <td>Kode Barang</td>          
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_BARANG]" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text" readonly  wajib="yes" />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang', 'KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan', 'Kode Barang', 'fbarang_', 650, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                               
                                <input type="hidden" name="BARANG[JNS_BARANG]" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />             		
                                <input type="hidden" id="KD_SAT_BESAR" name="KD_SAT_BESAR" value="<?= $sess['KD_SAT_BESAR']; ?>"/> 
                                <input type="hidden" id="KD_SAT_KECIL" name="KD_SAT_KECIL" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
                                <input type="hidden" name="KODE_BARANG_HIDE" id="KODE_BARANG_HIDE" value="<?= $sess['KODE_BARANG'] ?>" />
                            </td>   
                        </tr>        
                        <tr>
                            <td>Uraian Barang </td>
                            <td><textarea  name="BARANG[URAIAN_BARANG]" id="URAIAN_BARANG" class="text" wajib="yes"><?= $sess['URAIAN_BARANG']; ?></textarea></td>
                        </tr>                        
                        <tr>
                            <td>Merk</td>
                            <td><input type="text" name="BARANG[MERK]" id="MERK" class="text" value="<?= $sess['MERK']; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Tipe</td>
                            <td><input type="text" name="BARANG[TIPE]" id="TIPE" class="text" value="<?= $sess['TIPE']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Ukuran</td>
                            <td><input type="text" name="BARANG[UKURAN]" id="UKURAN" class="text" value="<?= $sess['UKURAN']; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Spesifikasi</td>
                            <td><input type="text" name="BARANG[SPF]" id="SPF" class="text" value="<?= $sess['SPF']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Penggunaan Barang </td>
                            <td><combo><?= form_dropdown('BARANG[PENGGUNAAN]', $penggunaan, $sess['PENGGUNAAN'], 'id="PENGGUNAAN" class="text" wajib="yes" value="<?= $penggunaan; ?>" '); ?></combo></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA KEMASAN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Jenis Kemasan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_KEMASAN]" id="KODE_KEMASAN" wajib="yes" class="stext date" value="<?= $sess['KODE_KEMASAN']; ?>" url="<?= site_url() ?>/autocomplete/kemasan" urai="urjenis_kemasan;" onfocus="Autocomp(this.id)"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan', 'KODE_KEMASAN;urjenis_kemasan', 'Kode Kemasan', 'fbarang_', 650, 470)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urjenis_kemasan"><?= $sess['URAIAN_KEMASAN'] == '' ? $URAIAN_KEMASAN : $sess['URAIAN_KEMASAN']; ?></span></td>
                        </tr> 
                        <tr>
                            <td>Jumlah Kemasan</td>
                            <td><input type="text" name="JUM_KMS" id="JUM_KMS" wajib="yes" class="text" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_KEMASAN'], 4); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_KEMASAN', this.value, 4);"  />
                                <input type="hidden" name="BARANG[JUMLAH_KEMASAN]" id="JUMLAH_KEMASAN" value="<?= $sess['JUMLAH_KEMASAN'] ?>" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="55%" valign="top">
                    <table width="100%" border="0">                   
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA SATUAN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Kode Satuan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" url="<?= site_url(); ?>/autocomplete/satuan" class="stext date" wajib="yes" value="<?= $sess['KODE_SATUAN']; ?>" urai="urjenis_satuan;" readonly />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan', 'KODE_SATUAN;urjenis_satuan', 'Kode Satuan', 'fbarang_', 650, 470, 'KD_SAT_BESAR;KD_SAT_KECIL;')"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urjenis_satuan"><?= $sess['URAIAN_SATUAN'] ? $sess['URAIAN_SATUAN'] : $urkd_stn; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan </td>
                            <td><input type="text" name="JUM_SAT" id="JUM_SAT" class="text" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'], 4); ?>" wajib="yes" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN', this.value, 4);
                    satuan($('#JUMLAH_SATUAN').val())" />
                                <input type="hidden" name="BARANG[JUMLAH_SATUAN]" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Harga Satuan</td>
                            <td><input type="text"  id="HARGA_SATUAN" class="text" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_SATUAN'], 4);
; ?>"  readonly="readonly" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA HARGA</b></h5></td>
                        </tr>
                        <tr>
                            <td width="23%">CIF</td>
                            <td width="77%"><input type="text"  id="INVOICE" class="text" value="<?= $this->fungsi->FormatRupiah($sess['CIF'], 4); ?>" wajib="yes" onkeyup="this.value = ThausandSeperator('CIF', this.value, 4);
                    satuan($('#JUMLAH_SATUAN').val())" />
                                <input type="hidden" name="BARANG[CIF]" id="CIF" value="<?= $sess['CIF'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Harga Penyerahan</td>
                            <td><input type="text" name="HRG_PENY" id="HRG_PENY" class="text" value="<?= ($sess['HARGA_PENYERAHAN']) ? $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN'], 4) : $this->fungsi->FormatRupiah($sess['HARGA'], 4); ?>" onkeyup="this.value = ThausandSeperator('HARGA_PENYERAHAN', this.value, 4);" wajib="yes" />
                                <input type="hidden" name="BARANG[HARGA_PENYERAHAN]" id="HARGA_PENYERAHAN" value="<?= $sess['HARGA_PENYERAHAN'] ? $sess['HARGA_PENYERAHAN'] : $sess['HARGA'] ?>" />	
                            </td>
                        </tr> 
                        <tr>
                            <td>Volume</td>
                            <td>
                                <input type="text" name="VOL" id="VOL" class="text" value="<?= $this->fungsi->FormatRupiah($sess['VOLUME'], 4); ?>" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('VOLUMEBRG', this.value, 4);"/>
                                <input type="hidden" name="BARANG[VOLUME]" id="VOLUMEBRG" value="<?= $sess['VOLUME'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Netto</td>
                            <td>
                                <input type="text" name="NET" id="NET" class="text" value="<?= $this->fungsi->FormatRupiah($sess['NETTO'], 4); ?>" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('NETTOBRG', this.value, 4);"/>
                                <input type="hidden" name="BARANG[NETTO]" id="NETTOBRG" class="text" value="<?= $sess['NETTO']; ?>" wajib="yes" format="angka"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td colspan="2"  width="100%">
                	<table width="100%">
                    	<tr><td colspan="2">&nbsp;</td></tr>
                    	<tr>
                        	<td width="170">&nbsp;</td>
                        	<td>
                            	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fbarang_', 'msgbarang_');">
                                    <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>
                                </a>&nbsp;
                                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbarang_');">
                                    <i class="icon-undo"></i>&nbsp;Reset
                                </a>&nbsp;
                                <span class="msgbarang_" style="margin-left:20px">&nbsp;</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
    	</table>
     </form>
<?php } ?>
</span>
<?php 
if($edit){
	echo '<h5 class="header smaller lighter green"><b>&nbsp;</b></h5>';
}
?>
<?php if (!$edit) { ?>
    <div id="fbarang_list"><?= $list ?></div>
<?php } ?>
<script>
    $(function() {
        FormReady();
    })
</script>