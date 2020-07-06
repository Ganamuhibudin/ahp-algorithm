<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<span id="fbarang_form">
    <?php if(!$list){?>
   	<h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
    <form id="fbarang_" name="fbarang_" action="<?= site_url()."/pengeluaran/barang/bc24"; ?>" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" list="<?=  site_url()."/pengeluaran/detil/barang/bc24" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="KDBRG" id="KDBRG" value="<?= $sess["KODE_BARANG"]; ?>" />
        <input type="hidden" name="JNBRG" id="JNBRG" value="<?= $sess["JNS_BARANG"]; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <table width="100%">
        	<tr>
                <td width="50%" valign="top">  
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td width="145">No HS/Serial HS</td>
                            <td><input type="text" name="BARANG[NOHS]" id="NOHS" url="<?= site_url(); ?>/autocomplete/hs_n_tarif" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['NOHS']); ?>" onfocus="Autocomp(this.id);" urai="SERITRP;TARIF_BM;TARIF_PPN;TARIF_PPNBM;TARIF_CUKAI;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> / <input type="text" name="BARANG[SERITRP]" id="SERITRP" class="ssstext" wajib="yes" value="<?= $sess['SERITRP'];?>"/> &nbsp;<input type="hidden" name="trf_serihs" id="trf_serihs" value="<?= $sess['SERITRP']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Kode Barang</td>
                            <td>
                                <input type="text" name="BARANG[KODE_BARANG]" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;NOHS;SERITRP;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;" onfocus="Autocomp(this.id, this.form.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" onclick="tb_search('barangnew','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;NOHS;SERITRP;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;SATUAN;KONDISI_BARANG','Kode Barang',this.form.id,650,400)" value="...">
                                <input type="hidden" name="BARANG[JNS_BARANG]" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />             		
                                <input type="hidden" id="KD_SAT_BESAR" name="KD_SAT_BESAR" value="<?= $sess['KD_SAT_BESAR']; ?>"/> 
                                <input type="hidden" id="KD_SAT_KECIL" name="KD_SAT_KECIL" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
                                <input type="hidden" id="UKURAN" name="UKURAN" />        
                                <input type="hidden" id="SATUAN" name="SATUAN" /> 
                                <input type="hidden" id="KONDISI_BARANG" name="BARANG[KONDISI_BARANG]" value="<?= $sess['KONDISI_BARANG']; ?>" />             
                            </td>
                        </tr>        
                        <tr>
                            <td>Uraian Barang</td>
                            <td><input type="text" name="BARANG[URAIAN_BARANG]" id="URAIAN_BARANG" class="text" wajib="yes" value="<?= $sess['URAIAN_BARANG']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Merk</td>
                            <td><input type="text" name="BARANG[MERK]" id="MERK" class="text" value="<?= $sess['MERK']; ?>" maxlength="15" /></td>
                        </tr>
                        <tr>
                            <td>Tipe</td>
                            <td><input type="text" name="BARANG[TIPE]" id="TIPE" class="text" value="<?= $sess['TIPE']; ?>" maxlength="15" /></td>
                        </tr>
                        <tr>
                            <td>Ukuran</td>
                            <td><input type="text" name="BARANG[UKURAN]" id="UKURAN" class="text" value="<?= $sess['UKURAN']; ?>" maxlength="15" /></td>
                        </tr>    
                        <tr>
                            <td>Spesifikasi Lain</td>
                            <td><input type="text" name="BARANG[SPFLAIN]" id="SPF" class="text" value="<?= $sess['SPFLAIN']; ?>" maxlength="15" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA KEMASAN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>
                                <input type="text" name="JUMLAH_KEMASANUR" id="JUMLAH_KEMASANUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_KEMASAN'],0); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_KEMASAN',this.value,2);"/>
                                <input type="hidden" name="BARANG[JUMLAH_KEMASAN]" id="JUMLAH_KEMASAN" value="<?= $sess['JUMLAH_KEMASAN']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kemasan</td>
                            <td>
                                <input type="text" name="BARANG[KODE_KEMASAN]" id="KODE_KEMASAN" value="<?= $sess['KODE_KEMASAN']; ?>" url="<?= site_url(); ?>/autocomplete/kemasan" class="sstext" urai="urjenis_kemasan;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" onclick="tb_search('kemasan','KODE_KEMASAN;urjenis_kemasan','Kode Kemasan',this.form.id,650,400)" value="...">
                                <span id="urjenis_kemasan"><?= $sess['KODE_KEMASANUR']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Netto</td>
                            <td>
                                <input type="text" name="NETTOUR" id="NETTOUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['NETTO_DTL'],0); ?>" onkeyup="this.value = ThausandSeperator('NETTO',this.value,2);"/>&nbsp; Kilogram (KGM)
                                <input type="hidden" name="BARANG[NETTO_DTL]" id="NETTO" value="<?= $sess['NETTO_DTL']?>" />
                            </td>
                        </tr>		
                    </table>          	
                </td>
                <td valign="top">       
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue">DATA HARGA</h5></td>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td>
                                <input type="text" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'],2); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,2);satuan($('#JUMLAH_SATUAN').val());"/>
                                <input type="hidden" name="BARANG[JUMLAH_SATUAN]" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN']?>" />
                            </td>
                        </tr>   
                        
                        <tr>
                            <td>Kode Satuan</td>
                            <td>
                                <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" value="<?= $sess['KODE_SATUAN']; ?>" url="<?= site_url(); ?>/autocomplete/satuan" class="sstext" urai="urjenis_satuan;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" onclick="tb_search('satuan','KODE_SATUAN;urjenis_satuan','Kode Satuan',this.form.id,650,400)" value="...">
                                <span id="urjenis_satuan"><?= $sess['KODE_SATUANUR']; ?></span>
                            </td>
                        </tr>
                        <tr> 
                            <td>Nilai CIF</td>
                            <td>
                                <input type="text" name="CIF_NILAI" id="CIF_NILAI" class="sstext"  value="<?= $this->fungsi->FormatRupiah($sess['HARGA_CIF_BB_DTL']); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('ciff',this.value,4);ProsesCIF();"/>
                                <input type="hidden" name="BARANG[HARGA_CIF_BB_DTL]" id="ciff" value="<?= $sess['HARGA_CIF_BB_DTL']?>" />
                            </td>
                        </tr> 
                        <tr> 
                            <td align="right">RP</td>
                            <td><input type="text"  id="CIFRPBRG" class="text" readonly value="<?= $this->fungsi->FormatRupiah($sess['CIFRPBRG'],2)?>"/></td>
                        </tr> 
                        <tr> 
                            <td>Harga Penyerahan</td>
                            <td>
                                <input type="text" name="HARGA" id="HARGA" class="text" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN_DTL']); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('HARGAB',this.value,2);"/>
                                <input type="hidden" name="BARANG[HARGA_PENYERAHAN_DTL]" id="HARGAB" value="<?= $sess['HARGA_PENYERAHAN_DTL']?>" />
                            </td>
                        </tr>
                        <!--<tr>
                            <td>Total/Detil (CIF)</td>
                            <td>
                                <input type="text" name="INVOICEUR" id="INVOICEUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['INVOICE'],2); ?>" onkeyup="this.value = ThausandSeperator('INVOICE',this.value,2);total($('#INVOICE').val());satuan($('#JUMLAH_SATUAN').val());"/>
                                <input type="hidden" name="BARANG[INVOICE]" id="INVOICE" value="<?= $sess['INVOICE']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td>
                                <input type="text" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'],2); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,2);satuan($('#JUMLAH_SATUAN').val());"/>
                                <input type="hidden" name="BARANG[JUMLAH_SATUAN]" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Kode Satuan</td>
                            <td>
                                <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" url="<?= site_url(); ?>/autocomplete/satuan" class="sstext" wajib="yes" value="<?= $sess['KODE_SATUAN']; ?>" urai="urjenis_satuan;" maxlength="3" readonly="readonly"/>&nbsp;
                                <input type="button" name="cari" id="cari" class="button" onclick="tb_search('satuan','KODE_SATUAN;urjenis_satuan','Kode Satuan',this.form.id,650,400,'KD_SAT_BESAR;KD_SAT_KECIL;')" value="...">
                                <span id="urjenis_satuan"><?= $sess['KODE_SATUANUR']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Harga Satuan</td>
                            <td>
                                <input type="text" name="HARGA_SATUANUR" id="HARGA_SATUANUR" class="text" value="<?=  $this->fungsi->FormatRupiah($sess['INVOICE']/$sess['JUMLAH_SATUAN'],2); ?>" readonly="readonly"/>
                                <input type="hidden" name="BARANG3[HARGA_SATUAN]" id="HARGA_SATUAN"  value="<?=  $sess['INVOICE']/$sess['JUMLAH_SATUAN']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Harga CIF</td>
                            <td>
                                <input type="text" name="CIFUR" id="CIFUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['CIF'],2); ?>" readonly="readonly"/>
                                <input type="hidden" name="BARANG[CIF]" id="CIF" value="<?= $sess['CIF']; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td>CIF Rp</td>
                            <td>
                            <input type="text" name="CIFRPUR" id="CIFRPUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['CIFRP'],2); ?>" readonly="readonly"/>
                            <input type="hidden" name="BARANG[CIFRP]" id="CIFRP" value="<?= $sess['CIFRP']; ?>"/>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2" class="rowheight"><h5>TARIF DAN FASILITAS</h5></td>
                        </tr>
                        <tr>
                            <td><span onclick="showBM()" class="fontBlueColor">BM</span></td>
                            <td>
                            	<input type="text" name="TARIF[TARIF_BM]" id="TARIF_BM" value="<?= $sess['TARIF_BM']; ?>" onkeyup="$('#TARIF_BM2').val(this.value)" maxlength="3" class="ssstext"/>&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KODE_FAS_BM]', $kode_bm, $sess['KODE_FAS_BM'], 'id="KODE_FAS_BM" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_BM]" id="FAS_BM" value="<?= $sess['FAS_BM']; ?>" maxlength="3" class="ssstext"/>&nbsp;% <span id="tipebm"></span>         
                        	</td>
                        </tr>     
                       	<tr>
                        	<td></td><td><span id="tipespesifik"></span></td>
                       	</tr>        
                        <tr>
                            <td>PPN</td>
                            <td><input type="text" name="TARIF[TARIF_PPN]" id="TARIF_PPN" maxlength="3" class="ssstext" value="<?= $sess['TARIF_PPN']; ?>" />&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KODE_FAS_PPN]', $kode_ppn, $sess['KODE_FAS_PPN'], 'id="KODE_FAS_PPN" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_PPN]" id="FAS_PPN" maxlength="3" class="ssstext" value="<?= $sess['FAS_PPN']; ?>" />&nbsp;%</td>
                        </tr>
                        <tr>
                            <td>PPnBM</td>
                            <td><input type="text" name="TARIF[TARIF_PPNBM]" id="TARIF_PPNBM" maxlength="3" class="ssstext" value="<?= $sess['TARIF_PPNBM']; ?>" />&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KODE_FAS_PPNBM]', $kode_ppnbm, $sess['KODE_FAS_PPNBM'], 'id="KODE_FAS_PPNBM" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_PPNBM]" id="FAS_PPNBM" maxlength="3" class="ssstext" value="<?= $sess['FAS_PPNBM']; ?>" />&nbsp;%</td>
                        </tr>
                        <tr>
                            <td>PPh</td>
                            <td><input type="text" name="pph_" id="pph_" maxlength="3" class="ssstext" value="<?=($sess['NOMOR_API']=="")?"7,5":"2,5"?>" />&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KODE_FAS_PPH]', $kode_ppnbm, $sess['KODE_FAS_PPH'], 'id="KODE_FAS_PPH" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_PPH]" id="FAS_PPH" maxlength="3" class="ssstext" value="<?= $sess['FAS_PPH']; ?>" />&nbsp;%</td>
                        </tr>
                        <tr>
                        	<td colspan="2" class="rowheight"><h5>DATA CUKAI</h5></td>
                        </tr>
                        <tr>
                            <td>Komoditi</td>
                            <td><?= form_dropdown('TARIF[KODE_CUKAI]', $komoditi_cukai, $sess['KODE_CUKAI'], 'id="KODE_CUKAI" class="text" '); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Tarif</td>
                            <td><?= form_dropdown('TARIF[KODE_TARIF_CUKAI]', $jenis_tarif, $sess['KODE_TARIF_CUKAI'], 'id="KODE_TARIF_CUKAI" class="text" onchange="tarif(this.value)"'); ?>&nbsp;&nbsp;<input type="text" name="TARIF[TARIF_CUKAI]" id="TARIF_CUKAI" maxlength="3" class="ssstext" value="<?= $sess['TARIF_CUKAI']; ?>" /><span id="persens">%</span></td>
                        </tr>
                        <tr id="tarf" style="display:none;">
                            <td colspan="2" style="padding-left:90px;"> 
                                <fieldset style="padding-left:10px;padding-bottom:10px;">
                                	<legend>Jenis Tarif : Spesifik</legend>
                                    <table > 
                                        <tr>		
                                        	<td >Per : &nbsp;<input type="text" class="ssstext" name="TARIF[KODE_SATUAN_CUKAI]" id="KODE_SATUAN_CUKAI" value="<?= $sess['KODE_SATUAN_CUKAI']; ?>" maxlength="3"/>&nbsp;Jumlah : &nbsp;<input type="text" class="sstext" name="BARANG[JUMLAH_CUKAI]" id="JUMLAH_CUKAI" value="<?= $sess['JUMLAH_CUKAI']; ?>"/></td>
                                        </tr>
                                    </table>
                        		</fieldset>
                        	</td> 	            	
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><?= form_dropdown('FASILITAS[KODE_FAS_CUKAI]', $kode_cukai, $sess['KODE_FAS_CUKAI'], 'id="KODE_FAS_CUKAI" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_CUKAI]" id="FAS_CUKAI" maxlength="3" class="ssstext" value="<?= $sess['FAS_CUKAI']; ?>"  />&nbsp;%</td>
                        </tr>-->
                    </table>            
                </td>
 			</tr>
            <tr>
            	<table>
                	<tr><td colspan="2">&nbsp;</td></tr>
                	<tr>
                    	<td width="145">&nbsp;</td>
                        <td>
                        	<a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="save_detil('#fbarang_', 'msgbarang_');"><i class="icon-save"></i>&nbsp;<?=ucwords($act)?></a>&nbsp;
                            <a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('fbarang_');"><i class="icon-remove"></i>&nbsp;Reset</a></a>&nbsp;
                            <span class="msgbarang_" style="margin-left:20px">&nbsp;</span>
                        </td>
                    </tr>
                </table>
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
<?php if(!$edit){ ?>
<div id="fbarang_list"><?= $list ?></div>
<?php } 
if($act=="update"){ 
	if($sess['KODE_TARIF_BM']=='2'){
?>
	<script>
    $("#tipespesifik").html('<table><tr><td align="right">Per</td><td><input type="text" name="TARIF[KODE_SATUAN_BM]" id="KODE_SATUAN_BM" class="ssstext" value="<?= $sess["KODE_SATUAN_BM"]?>"/>&nbsp;&nbsp;Jumlah Satuan&nbsp;<input type="text" name="BARANG[JUMLAH_BM]" id="JUMLAH_BM" class="stext" value="<?= $sess["JUMLAH_BM"]?>"/></td></tr></table>');	
	$("#tipebm").html('Spesifik<input type="hidden" name="TARIF[KODE_TARIF_BM]" id="KODE_TARIF_BM" value="<?= $sess["KODE_TARIF_BM"]?>">');
    </script>
<?php	}else{ ?>
	<script>
    $("#tipespesifik").html('');	
	$("#tipebm").html('Advolorum<input type="hidden" name="TARIF[KODE_TARIF_BM]" id="KODE_TARIF_BM" value="<?= $sess["KODE_TARIF_BM"]?>">');	
    </script>
<?php }
	if($sess['KODE_TARIF_CUKAI']=='2'){
	?>
	<script>
    $("#tarf").show();	
    </script>	
<?php } }?>
<script>
$(function(){FormReady();})
</script>




  
