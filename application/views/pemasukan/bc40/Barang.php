<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fbarang_form">
	<?php if(!$list){?>
	<form id="fbarang_" action="<?= site_url()."/pemasukan/barang/bc40"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?=  site_url()."/pemasukan/detil/barang/bc40" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
        <table width="100%">
  			<tr>
    			<td width="50%;">  
    				<table >			
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                        </tr>
                        
                         <tr>
                            <td width="145">Kode HS/Seri HS</td>
                            <td><input type="text" name="BARANG[KODE_HS]" id="KODE_HS" class="sstext" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" urai="SERI_HS;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> / <input type="text" name="BARANG[SERI_HS]" id="SERI_HS" class="ssstext"  value="<?= $sess['SERI_HS'];?>"/> &nbsp;<input type="hidden" name="trf_serihs" id="trf_serihs" value="<?= $sess['SERI_HS']; ?>" /></td>
                        </tr>
                
                        <tr>            
                            <td>Kode Barang</td>          
                            <td> <div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="BARANG[KODE_BARANG]" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;" onfocus="Autocomp(this.id, this.form.id);"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan','Kode Barang','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                                <input type="hidden" name="BARANG[JNS_BARANG]" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />             		
                                <input type="hidden" id="KD_SAT_BESAR" name="KD_SAT_BESAR" value="<?= $sess['KD_SAT_BESAR']; ?>"/> 
                                <input type="hidden" id="KD_SAT_KECIL" name="KD_SAT_KECIL" value="<?= $sess['KD_SAT_KECIL']; ?>"/>     
                            </td>               
                        </tr>	
                        <tr>
                            <td>Uraian Barang</td>
                            <td><input type="text" name="BARANG[URAIAN_BARANG]" id="URAIAN_BARANG" url="<?= site_url(); ?>/autocomplete/barang" class="text" wajib="yes" value="<?= $sess['URAIAN_BARANG']; ?>"/></td>
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
                            <td><input type="text" name="BARANG[SPF]" id="SPF" class="text" value="<?= $sess['SPF']; ?>" maxlength="15" /></td>
                        </tr>        
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA KEMASAN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td><input type="text" name="JUMLAH_KEMASANUR" id="JUMLAH_KEMASANUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_KEMASAN']); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_KEMASAN',this.value,4);"/><input type="hidden" name="BARANG[JUMLAH_KEMASAN]" id="JUMLAH_KEMASAN" value="<?= $sess['JUMLAH_KEMASAN']?>" /></td>
                        </tr>
                        <tr>
                            <td>Jenis Kemasan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="BARANG[KODE_KEMASAN]" id="KODE_KEMASAN" value="<?= $sess['KODE_KEMASAN']; ?>" url="<?= site_url(); ?>/autocomplete/kemasan" class="stext date" urai="urjenis_kemasan;" onfocus="Autocomp(this.id);"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan','KODE_KEMASAN;urjenis_kemasan','Kode Kemasan','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                            <span id="urjenis_kemasan"><?= $sess['URKODE_KEMASAN']; ?></span></td>
                        </tr>
    				</table>          	
    			</td>
    			<td valign="top">       
    				<table>			
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA HARGA</b></h5></td>
                        </tr>
                        <tr>
                            <td>Netto</td>
                            <td><input type="text" name="NETTOUR" id="NETTOUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['NETTO']); ?>" onkeyup="this.value = ThausandSeperator('NETTO',this.value,4);"/><input type="hidden" name="BARANG[NETTO]" id="NETTO" value="<?= $sess['NETTO']?>" /></td>
                        </tr>
                        <tr>
                            <td>Volume</td>
                            <td><input type="text" name="VOLUMEUR" id="VOLUMEUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['VOLUME']); ?>"  onkeyup="this.value = ThausandSeperator('BRGVOLUME',this.value,4);"/><input type="hidden" name="BARANG[VOLUME]" id="BRGVOLUME" value="<?= $sess['VOLUME']?>" /></td>
                        </tr>
                        <tr>
                            <td>Harga Penyerahan (Rp)</td>
                            <td><input type="text" name="HARGA_PENYERAHANUR" id="HARGA_PENYERAHANUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN']); ?>"  onkeyup="this.value = ThausandSeperator('BRGHARGA_PENYERAHAN',this.value,4);"/><input type="hidden" name="BARANG[HARGA_PENYERAHAN]" id="BRGHARGA_PENYERAHAN" value="<?= $sess['HARGA_PENYERAHAN']?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"></td>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td><input type="text" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN']); ?>" onkeyup="satuan(this.value);this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,4);"/><input type="hidden" name="BARANG[JUMLAH_SATUAN]" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN']?>" /></td>
                        </tr>
                        <tr>            
                            <td>Kode Satuan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" url="<?= site_url(); ?>/autocomplete/satuan" class="stext date" wajib="yes" value="<?= $sess['KODE_SATUAN']; ?>" urai="urjenis_satuan;" readonly />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan','KODE_SATUAN;urjenis_satuan','Kode Satuan','fbarang_',650,400,'KD_SAT_BESAR;KD_SAT_KECIL;')"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                            	 &nbsp;<span id="urjenis_satuan"><?= $sess['URAIAN_SATUAN']?$sess['URAIAN_SATUAN']:$urkd_stn; ?></span></td>
                        </tr>
                        <!--<tr>
                            <td>Harga Satuan</td>
                            <td><input type="text" name="BARANG3[HARGA_SATUAN]" id="HARGA_SATUAN" class="text" value="<?$harga_satuan; ?>" readonly="readonly"/></td>
                        </tr>
                         <tr>
                            <td>Harga FOB</td>
                            <td><input type="text" name="BARANG3[FOB]" id="FOB" class="text" value="<?$fob; ?>" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td>Freight</td>
                            <td><input type="text" name="BARANG3[FREIGHT]" id="FREIGHT" class="text" value="<?$freight; ?>" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td>Asuransi</td>
                            <td><input type="text" name="BARANG3[ASURANSI]" id="ASURANSI" class="text" value="<?$asuransi; ?>" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td>Harga CIF</td>
                            <td><input type="text" name="BARANG[CIF]" id="CIF" class="text" value="<?$sess['CIF']; ?>" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td>CIF Rp</td>
                            <td><input type="text" name="BARANG[CIFRP]" id="CIFRP" class="text" value="<?$sess['CIFRP']; ?>" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"><h5>Tarif dan Fasilitas</h5></td>
                        </tr>
                        <tr>
                            <td>BM</td>
                            <td><input type="text" name="BARANG2[TRF_BM]" id="TRF_BM" class="sstext" value="<?$sess['TRF_BM']; ?>" />&nbsp;%&nbsp;<?form_dropdown('BARANG1[KODE_BM]', $kode_bm, $sess['KODE_BM'], 'id="KODE_BM" class="text" value="<?$kode_bm; ?>" '); ?>&nbsp;&nbsp;<input type="text" name="BARANG1[BM]" id="BM" class="sstext" value="<?$sess['BM']; ?>" />          
                        <input type="button" id="<?"/".$this->uri->segment(1, "")."/bm/".$this->uri->segment(3, ""); ?>" value="..." onclick="popup(this.id)"/></td>
                        </tr>
                        <tr id="bmHidden" style="display:none;">
                            <td colspan=2 style="padding-left:90px;"> 
                                <fieldset style="padding-left:10px;padding-bottom:10px;">
                                    <legend>Jenis Tarif : Spesifik</legend>
                                    <table >
                                        <tr>		
                                            <td >Jenis Tarif </td><td>: &nbsp;<?form_dropdown('BARANG2[KD_TRF_BM]', $jenis_tarif, $sess['KD_TRF_BM'], 'id="KD_TRF_BM" class="text" value="<?$jenis_tarif; ?>" onchange="tarifBm(this.value)"'); ?></td>
                                        </tr>   
                                        <tr>
                                            <td>Tarif Spesifik(Satuan)</td>
                                        </tr>
                                        <tr>
                                            <td>Besar Tarif </td><td>: &nbsp;<input type="text" name="BARANG2[TRF_BM]" id="TRF_BM" value="<?$sess['TRF_BM'];?>" class="sstext"/>&nbsp;Per : &nbsp;<input type="text" name="BARANG2[KD_SAT_BM]" id="KD_SAT_BM" value="<?$sess['KD_SAT_BM'];?>" class="sstext"/></td>  
                                        </tr>
                                        <tr class="dtl" style="display:none;">
                                            <td>Jumlah </td><td>: &nbsp;<input type="text" name="BARANG[JUMLAH_BM]" id="JUMLAH_BM" value="<?$sess['JUMLAH_BM'];?>" class="sstext" /></td>
                                        </tr>                               
                                    </table>
                                </fieldset>
                            </td> 	            	
                        </tr>
                        <tr>
                            <td>PPN</td>
                            <td><input type="text" name="BARANG2[TRF_PPN]" id="TRF_PPN" class="sstext" value="<?$sess['TRF_PPN']; ?>" />&nbsp;%&nbsp;<?form_dropdown('BARANG1[KODE_PPN]', $kode_ppn, $sess['KODE_PPN'], 'id="KODE_PPN" class="text" value="<?$kode_ppn; ?>" '); ?>&nbsp;&nbsp;<input type="text" name="BARANG1[PPN]" id="PPN" class="sstext" value="<?$sess['PPN']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>PPnBM</td>
                            <td><input type="text" name="BARANG2[TRF_PPNBM]" id="TRF_PPNBM" class="sstext" value="<?$sess['TRF_PPNBM']; ?>" />&nbsp;%&nbsp;<?form_dropdown('BARANG1[KODE_PPNBM]', $kode_ppnbm, $sess['KODE_PPNBM'], 'id="KODE_PPNBM" class="text" value="<?$kode_ppnbm; ?>" '); ?>&nbsp;&nbsp;<input type="text" name="BARANG1[PPNBM]" id="PPNBM" class="sstext" value="<?$sess['PPNBM']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>PPh</td>
                            <td><input type="text" name="pph_" id="pph_" class="sstext" value="2.5" />&nbsp;%&nbsp;<?form_dropdown('BARANG1[KODE_PPH]', $kode_ppnbm, $sess['KODE_PPH'], 'id="KODE_PPH" class="text" value="<?$kode_pph; ?>" '); ?>&nbsp;&nbsp;<input type="text" name="BARANG1[PPH]" id="PPH" class="sstext" value="<?$sess['PPH']; ?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"><h5>Cukai</h5></td>
                        </tr>
                        <tr>
                            <td>Komoditi</td>
                            <td><?form_dropdown('BARANG2[KD_CUKAI]', $komoditi_cukai, $sess['KD_CUKAI'], 'id="KD_CUKAI" class="text" value="<?$komoditi_cukai; ?>" '); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Tarif</td>
                            <td><?form_dropdown('BARANG2[KD_TRF_CUKAI]', $jenis_tarif, $sess['KD_TRF_CUKAI'], 'id="KD_TRF_CUKAI" class="text" value="<?$jenis_tarif; ?>" onchange="tarif(this.value)"'); ?>&nbsp;&nbsp;<input type="text" name="BARANG2[TRF_CUKAI]" id="TRF_CUKAI" class="text" value="<?$sess['TRF_CUKAI']; ?>" /></td>
                        </tr>
                        <tr id="tarf" style="display:none;">
                            <td colspan=2 style="padding-left:90px;"> 
                                <fieldset style="padding-left:10px;padding-bottom:10px;">
                                <legend>Jenis Tarif : Spesifik</legend>
                                    <table > 
                                        <tr>		
                                            <td >Per : &nbsp;<input type="text" class="sstext" name="BARANG2[KD_SAT_CUKAI]" id="KD_SAT_CUKAI" value="<?$sess['KD_SAT_CUKAI']; ?>"/>&nbsp;Jumlah : &nbsp;<input type="text" class="sstext" name="BARANG[JUMLAH_CUKAI]" id="JUMLAH_CUKAI" value="<?$sess['JUMLAH_CUKAI']; ?>"/></td>
                                        </tr>
                                      </table>
                                </fieldset>
                            </td> 	            	
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td><?form_dropdown('BARANG1[KODE_CUKAI]', $kode_cukai, $sess['KODE_CUKAI'], 'id="KODE_CUKAI" class="text" value="<?$kode_cukai; ?>" '); ?>&nbsp;&nbsp;<input type="text" name="BARANG1[CUKAI]" id="CUKAI" class="text" value="<?$sess['CUKAI']; ?>"  />&nbsp;%</td>
                        </tr>-->
  					</table>            
				</td>
			</tr>
			<tr>
    			<td colspan="7">&nbsp;</td>
			</tr>
		</table>      	      
        <div style="margin-left:11.5%;">
            <a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fbarang_','msgbarang_');">
            	<i class="icon-save"></i>&nbsp;<?=ucwords($act); ?>&nbsp;
           	</a>
            <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbarang_');">
            	<i class="icon-undo"></i>&nbsp;Reset&nbsp;
          	</a>&nbsp;
            <span class="msgbarang_" style="margin-left:20px">&nbsp;</span>
        </div>		
	</form> 
<?php } ?>
</span>
<?php
	if($edit) echo '<h5 class="header smaller lighter green"><b>&nbsp;</b></h5>';
?>
<?php if(!$edit){ ?>
<div id="fbarang_list"><?= $list ?></div>
<?php } ?>
<script>
$(function(){FormReady();})
</script>

  
