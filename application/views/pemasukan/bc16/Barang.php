<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fbarang_form">
<?php if (!$list) {
    $jns_tarif = array('BM'=>"Bea Masuk",'BMKITE'=>"BM KITE");
 ?>
	<form id="fbarang_" name="fbarang_" action="<?= site_url() . "/pemasukan/barang/bc16"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?= site_url() . "/pemasukan/detil/barang/bc16" ?>">
    	<input type="hidden" name="act" readonly value="<?= $act; ?>" />
        <input type="hidden" name="seri" readonly id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="NOMOR_AJU" readonly id="NOMOR_AJU" value="<?= $aju; ?>" />
        <input type="hidden" name="SERI_HS" readonly id="SERI_HS" />
        <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
        <table width="100%">
        	<tr>
        		<td width="50%" valign="top">
                	<table width="100%">
                        <tr>
                            <td colspan="2" class="rowheight" ><h5 class="smaller lighter blue">DATA BARANG</h5></td>
                        </tr>
                        <tr>
                            <td>Kode Barang</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_BARANG]" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JENIS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;" onfocus="Autocomp(this.id, this.form.id);"/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang', 'KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JENIS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan', 'Kode Barang', 'fbarang_', 650, 400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                                <input type="hidden" name="BARANG[JNS_BARANG]" id="JENIS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />             		
                                <input type="hidden" id="KD_SAT_BESAR" name="KD_SAT_BESAR" value="<?= $sess['KD_SAT_BESAR']; ?>"/> 
                                <input type="hidden" id="KD_SAT_KECIL" name="KD_SAT_KECIL" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
                                <input type="hidden" id="UKURAN" name="UKURAN" />             
                            </td>
                        </tr>
                        <tr>
                            <td width="145">Kode HS/Seri HS</td>
                            <td><input type="text" name="BARANG[KODE_HS]" id="KODE_HS" url="<?= site_url(); ?>/autocomplete/hs_n_tarif" class="text" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" onfocus="Autocomp(this.id);" urai="SERI_HS;TARIF_BM;TARIF_PPN;TARIF_PPNBM;TARIF_CUKAI;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/></td>
                        </tr>
                        <tr>
                            <td>Kategori Barang</td>
                            <td><combo><?= form_dropdown('BARANG[PENGGUNAAN]', array(""=>"","01"=>"01 - BARANG UNTUK DITIMBUN","02"=>"02 - BARANG UNTUK KEPERLUAN PENGUSAHAAN"), $sess['PENGGUNAAN'], 'id="PENGGUNAAN" class="text" wajib="yes" '); ?></combo></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="hidden" value="<?= $sess['KODE_BARANG']?>" name="BARANG[KODE_BARANG_HIDE]" /></td>
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
                            <td>SPF</td>
                            <td><input type="text" name="BARANG[SPF]" id="SPF" class="text" value="<?= $sess['SPF']; ?>" maxlength="15" /></td>
                        </tr>
                        <tr>
                            <td>Ukuran</td>
                            <td><input type="text" name="BARANG[UKURAN]" id="UKURAN" class="text" value="<?= $sess['UKURAN']; ?>" maxlength="15" /></td>
                        </tr>	
                        <tr>
                            <td>Negara Asal</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[NEGARA_ASAL]" id="NEGARA_ASAL" url="<?= site_url(); ?>/autocomplete/negara" class="sstext" value="<?= $sess['NEGARA_ASAL']; ?>"  urai="urngr_asl;" onfocus="Autocomp(this.id);"/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara', 'NEGARA_ASAL;urngr_asl', 'Kode Negara', 'fbarang_', 650, 400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urngr_asl"><?= $sess['NEGARA_ASALUR']; ?></span></td>
                        </tr>
    
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>KEMASAN DAN SATUAN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td><input type="text" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'], 2); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN', this.value, 2);
                                    satuan($('#JUMLAH_SATUAN').val());"/>
                                <input type="hidden" name="BARANG[JUMLAH_SATUAN]" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Kode Satuan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" url="<?= site_url(); ?>/autocomplete/satuan" class="sstext" wajib="yes" value="<?= $sess['KODE_SATUAN']; ?>" urai="urjenis_satuan;" maxlength="3" readonly/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan', 'KODE_SATUAN;urjenis_satuan', 'Kode Satuan', 'fbarang_', 650, 400, 'KD_SAT_BESAR;KD_SAT_KECIL;')"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urjenis_satuan"><?= $sess['KODE_SATUANUR']; ?></span></td>
                        </tr>
                        <tr>
                            <td>Jumlah Kemasan</td>
                            <td><input type="text" name="JUMLAH_KEMASANUR" id="JUMLAH_KEMASANUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_KEMASAN'], 0); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_KEMASAN', this.value, 2);"/>
                                <input type="hidden" name="BARANG[JUMLAH_KEMASAN]" id="JUMLAH_KEMASAN" value="<?= $sess['JUMLAH_KEMASAN'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kemasan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_KEMASAN]" id="KODE_KEMASAN" value="<?= $sess['KODE_KEMASAN']; ?>" url="<?= site_url(); ?>/autocomplete/kemasan" class="sstext" urai="urjenis_kemasan;" onfocus="Autocomp(this.id);"/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan', 'KODE_KEMASAN;urjenis_kemasan', 'Kode Kemasan', 'fbarang_', 650, 400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urjenis_kemasan"><?= $sess['KODE_KEMASANUR']; ?></span></td>
                        </tr>
                        <tr>
                            <td>Netto</td>
                            <td><input type="text" name="NETTOUR" id="NETTOUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['NETTO'], 0); ?>" onkeyup="this.value = ThausandSeperator('NETTO', this.value, 2);"/>&nbsp; Kilogram (KGM)
                                <input type="hidden" name="BARANG[NETTO]" id="NETTO" value="<?= $sess['NETTO'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>FASILITAS</b></h5></td>
                        </tr>
                        <tr>
                                 <td>Fasilitas</td>
                                <td>
                                    <div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                     <input type="text" name="BARANG[KODE_FAS]" id="KODE_FASILITAS" value="<?= $sess['KODE_FASILITAS']; ?>" onclick="tb_search('fasilitas','KODE_FASILITAS','Fasilitas',this.form.id,650,400)" class="sstext" urai="urjenis_kemasan;"/>
                                      <span class="input-group-btn">
                                          <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('fasilitas','KODE_FASILITAS;ur_fas','Fasilitas','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>&nbsp;<span id="ur_fas"><?=$sess["UR_FAS"]?></span>
                                </td>
                        </tr>
                       <!--  <tr>
                            <td><span onclick="Dialog('<?=site_url();?>/pengeluaran/fasskema', 'dialog-fas','Fasilitas / Skema',700, 450);" class="red" style="cursor:pointer">FASILITAS/SKEMA</span></td>   
                            <td><span id="divfaskema"></span><input type="hidden" value="" id="KODE_FASILITAS" name="BARANG[KODE_FAS]"></td>
                        </tr> -->
                	</table>
                </td>
                <td valign="top">
                    <table width="100%">
                    	<tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA HARGA</b></h5></td>
                        </tr>
                        <tr>
                        	<td>Jenis Nilai</td>
                            <td>
                            	<div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[JENIS_NILAI]" id="JENIS_NILAI" value="<?= $sess['JENIS_NILAI']; ?>" url="<?= site_url(); ?>/autocomplete/jenis_nilai" onfocus="Autocomp(this.id)" class="stext date"  <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('jenis_nilai','JENIS_NILAI','Jenis Nilai','fbarang_',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        	<td>Nilai</td>
                            <td>
                            	<input type="text" name="NILAIUR" id="NILAIUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['NILAI'], 2); ?>" onkeyup="this.value = ThausandSeperator('NILAI', this.value, 2)"/>
                                <input type="hidden" name="BARANG[NILAI]" id="NILAI" value="<?= $sess['NILAI'] ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td>Harga CIF</td>
                            <td>
                            	<input type="text" name="HARGA_CIF_IUR" id="HARGA_CIF_IUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_CIF'], 2); ?>" onkeyup="this.value = ThausandSeperator('HARGA_CIF', this.value, 2)"/>
                                <input type="hidden" name="BARANG[HARGA_CIF]" id="HARGA_CIF" value="<?= $sess['HARGA_CIF'] ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td>CIF Rp.</td>
                            <td>
                            	<input type="text" name="CIF_RP_UR" id="CIF_RP_UR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['CIF_RP'], 2); ?>" onkeyup="this.value = ThausandSeperator('CIF_RP', this.value, 2)"/>
                                <input type="hidden" name="BARANG[CIF_RP]" id="CIF_RP" value="<?= $sess['CIF_RP'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>BEA MASUK</b></h5></td>
                        </tr>
                        <tr>		
                             <td >Jenis Tarif </td>
                             <td><combo><?= form_dropdown('TARIF[JENIS_TARIF]', $jns_tarif, $sess['JENIS_TARIF'], 'id="JENIS_TARIF" class="stext"'); ?></combo></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><combo><?= form_dropdown('TARIF[KODE_TARIF_BM]', $jenis_tarif, $sess['KODE_TARIF_BM'], 'id="KODE_TARIF_BM" class="text" onchange="tarifBm(this.value,\''.$sess['JUMLAH_SATUAN_BM'].'\')"'); ?></combo></td>
                        </tr>
        				<tr>
                             <td>Besar Tarif </td>
                             <td><input type="text" name="TARIF_BM1" id="TARIF_BM1" value="<?=$sess['TARIF_BM'];?>" class="ssstext" onkeyup="BesarTarif(this.value,1)"/>
                             <span class="persen">&nbsp;&nbsp;%=Rp&nbsp;</span>
                             <span class="jml-sat"><input type="text" id="TARIF_BM1UR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['TARIF_BM1UR'],0);?>"/><input type="hidden" id="TARIF_BM1UR_hide" value="<?= $sess['TARIF_BM1UR'];?>"/></span>
                             </td>  
                        </tr>
                        <tr class="dtl" style="display:none;">
                            <td align="right">Per</td>
                            <td><input type="text" name="TARIF[KODE_SATUAN_BM]" id="KODE_SATUAN_BM" value="<?=$sess['KODE_SATUAN_BM'];?>" class="ssstext" url="<?= site_url(); ?>/autocomplete/satuan" urai="" onfocus="Autocomp(this.id);" wajib="yes" onchange="$('#KODE_SATUAN_BM_BOTTOM').val(this.value.toUpperCase())" onkeyup="$('#KODE_SATUAN_BM_BOTTOM').val(this.value.toUpperCase())" onmouseout="$('#KODE_SATUAN_BM_BOTTOM').val(this.value.toUpperCase())"/>
                             <span>&nbsp;&nbsp;=Rp&nbsp;&nbsp;&nbsp;&nbsp;</span>
                             <input type="text" id="KD_SAT_BM" class="stext" readonly/><input type="hidden" id="KD_SAT_BM_hide"/></td>
                        </tr>  
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>TAMBAHAN BEA MASUK</b></h5></td>
                        </tr>
                        
                        <tr>
                            <td>BM Anti Dumping</td>
                            <td><input type="text" name="TAMBAHAN[BM_ANTI_DUMPING]" id="BM_ANTI_DUMPING" class="ssstext"  value="<?= $sess['BM_ANTI_DUMPING']; ?>" onkeyup="BTambahan(this.value,'BM_ANTI_DUMPINGUR')"/>
                            <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                            <input type="text" id="BM_ANTI_DUMPINGUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_ANTI_DUMPINGUR'],0); ?>"/><input type="hidden" id="BM_ANTI_DUMPINGUR_hide" value="<?= $sess['BM_ANTI_DUMPINGUR'];?>"/></td>
                        </tr>
                        <tr>
                            <td>BM Imbalan</td>
                            <td><input type="text" name="TAMBAHAN[BM_IMBALAN]" id="BM_IMBALAN" class="ssstext"  value="<?= $sess['BM_IMBALAN']; ?>" onkeyup="BTambahan(this.value,'BM_IMBALANUR')"/>
                            <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                            <input type="text" id="BM_IMBALANUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_IMBALANUR'],0); ?>"/><input type="hidden" id="BM_IMBALANUR_hide" value="<?= $sess['BM_IMBALANUR'];?>"/></td>
                        </tr>
                        <tr>
                            <td>BM Tindakan Pengamanan</td>
                            <td><input type="text" name="TAMBAHAN[BM_PENGAMANAN]" id="BM_PENGAMANAN" class="ssstext"  value="<?= $sess['BM_PENGAMANAN']; ?>" onkeyup="BTambahan(this.value,'BM_PENGAMANANUR')"/>
                            <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                            <input type="text"  id="BM_PENGAMANANUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_PENGAMANANUR'],0); ?>"/><input type="hidden" id="BM_PENGAMANANUR_hide" value="<?= $sess['BM_PENGAMANANUR'];?>"/></td>
                        </tr>
                        <tr>
                            <td>BM Pembalasan</td>
                            <td><input type="text" name="TAMBAHAN[BM_PEMBALASAN]" id="BM_PEMBALASAN" class="ssstext"  value="<?= $sess['BM_PEMBALASAN']; ?>" onkeyup="BTambahan(this.value,'BM_PEMBALASANUR')"/>
                            <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                            <input type="text" id="BM_PEMBALASANUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_PEMBALASANUR'],0); ?>"/><input type="hidden" id="BM_PEMBALASANUR_hide"  value="<?= $sess['BM_PEMBALASANUR'];?>"/></td>
                        </tr> 
                        <tr>
                            <td></td>
                            <td>___________________________________________+</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><span>Total Bea Masuk</span>&nbsp;&nbsp;<input type="text" name="TOTBM" id="TOTBM" class="stext" value="<?= $TOTBM; ?>" readonly/></td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>TARIF DAN FASILITAS</b></h5></td>
                        </tr>
                        <tr>
                            <td>BM</td>
                            <td><input type="text" name="TARIF[TARIF_BM]" id="TARIF_BM" class="ssstext" value="<?= $sess['TARIF_BM']; ?>" /><span class="persen2">&nbsp;%&nbsp;</span><combo><?= form_dropdown('FASILITAS[KODE_FAS_BM]', $kode2_tarif, $sess['KODE_FAS_BM'], 'id="KODE_FAS_BM" class="text" onchange="showklm(this.value,\'FAS_BM\')"'); ?></combo>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_BM]" id="FAS_BM" class="ssstext" value="<?= $sess['FAS_BM']; ?>" readonly/>&nbsp;%
                            <table class="dtl_bottom" style="display:none">
                             <tr>
                                <td align="right">/&nbsp;</td>
                                <td><input type="text" name="KODE_SATUAN_BM_BOTTOM" id="KODE_SATUAN_BM_BOTTOM" value="<?=$sess['KODE_SATUAN_BM'];?>" class="ssstext" readonly />
                                 <span>&nbsp;&nbsp;Jm Satuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                 <input type="text" name="JUMLAH_SATUAN_BM_BOTTOM" id="JUMLAH_SATUAN_BM_BOTTOM" class="stext" readonly value="<?=$sess['JUMLAH_SATUAN_BM']?>"/>&nbsp;Spesifik</td>
                            </tr> 
                            </table>
                            
                            </td>
                        </tr> 
                    </table> 
                </td>
          	</tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="2">
                	<table>
                    	<tr>
                        	<td  width="145">&nbsp;</td>
                            <td>
                            	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fbarang_', 'msgbarang_');"><i class="icon-save"></i>&nbsp;<?=ucwords($act)?></a>&nbsp;
                                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbarang_');"><i class="icon-undo"></i>&nbsp;Reset</a></a>&nbsp;
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
<script>
	function showklm(val,id){
		if(val==""){
			$('#'+id).attr("readonly",true);
			$('#'+id).attr("wajib","");
			$('#'+id).val('0');		
		}else{		
			$('#'+id).attr("readonly",false);	
			$('#'+id).attr("wajib","yes");
		}
	}
	$(function() {
        FormReady();
    })
</script>
<?php 
if($edit){
	echo '<h5 class="header smaller lighter green"><b>&nbsp;</b></h5>';
}
if (!$edit) {
    echo '<div id="fbarang_list">'.$list.'</div>';
} 
if($act=="update"){
?>    
<script>
	tarifBm('<?=$sess['KODE_TARIF_BM']?>','<?=$sess['JUMLAH_SATUAN_BM']?>');
	showklm('<?=$sess['KODE_FAS_BM']?>','FAS_BM');
</script>
<?php } ?>