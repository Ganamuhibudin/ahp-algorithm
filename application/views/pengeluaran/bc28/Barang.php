<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fbarang_form">
	<?php if(!$list){?>
		<form id="fbarang_" action="<?= site_url()."/pengeluaran/barang/bc28"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?=  site_url()."/pengeluaran/detil/barang/bc28" ?>">
			<input type="hidden" name="act" id="act" value="<?= $act; ?>" />
            <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
            <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" /> 
            <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>            
            <table width="100%">
            	<tr>
            		<td width="40%;" valign="top">  
            			<table>
                            <tr>
                            	<td colspan="2" class="rowheight"><h5 class="smaler lighter blue"><b>DATA BARANG</b></h5></td>
                            </tr>
                            <tr>
                                <td width="145">Kode HS/Seri HS</td>
                                <td><input type="text" name="BARANG[KODE_HS]" id="KODE_HS" url="<?= site_url(); ?>/autocomplete/hs_n_tarif" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" onfocus="Autocomp(this.id, this.form.id);" urai="SERI_HS;TARIF_BM;TARIF_PPN;TARIF_PPNBM;TARIF_CUKAI;;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> / <input type="text" name="BARANG[SERI_HS]" id="SERI_HS" class="ssstext" wajib="yes" value="<?= $sess['SERI_HS'];?>"/> &nbsp;<input type="hidden" name="trf_serihs" id="trf_serihs" value="<?= $sess['SERI_HS']; ?>" /></td>
                            </tr>           
                            <tr>    
                            	<td>Kode Barang</td>          
                            	<td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                     <input type="text" name="KODE_BARANG" id="KODE_BARANG" readonly value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;" onfocus="kdBarangCek(this.value)"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan','Kode Barang','fbarang_',650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>
                                   
                                    
                                    <input type="hidden" name="JNS_BARANG" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />            		
                                    <input type="hidden" id="KD_SAT_BESAR" name="KD_SAT_BESAR" value="<?= $sess['KD_SAT_BESAR']; ?>"/> 
                                    <input type="hidden" id="KD_SAT_KECIL" name="KD_SAT_KECIL" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
                                    <input type="hidden" id="KODE_BARANG_HIDE" name="KODE_BARANG_HIDE" value="<?= $sess['KODE_BARANG']; ?>"/>
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
                                <td>Negara Asal</td>
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                    <input type="text" name="BARANG[NEGARA_ASAL]" id="NEGARA_ASAL" url="<?= site_url(); ?>/autocomplete/negara" class="sstext" value="<?= $sess['NEGARA_ASAL']; ?>"  urai="urngr_asl;" onfocus="Autocomp(this.id);"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','NEGARA_ASAL;urngr_asl','Kode Negara','fbarang_',650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>&nbsp;<span id="urngr_asl"><?= $urngr_asl; ?></span></td>
                            </tr>
                            <tr>
                            	<td>Barang Impor</td>
                                <td><input type="text" onkeyup="this.value = ThausandSeperator('JUMLAH_BARANG_IMPOR',this.value,4);" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_BARANG_IMPOR']); ?>" class="sstext" id="JUMLAH_BARANG_IMPORUR" name="JUMLAH_BARANG_IMPORUR" wajib="yes">&nbsp;%<input type="hidden" id="JUMLAH_BARANG_IMPOR" name="BARANG[JUMLAH_BARANG_IMPOR]" value="<?=$sess["JUMLAH_BARANG_IMPOR"]?>"></td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="rowheight"><h5 class="smaler lighter blue"><b>SATUAN DAN HARGA</b></h5></td>
                            </tr>
                            <tr>
                                <td>Jumlah Satuan</td>
                                <td><input type="text" wajib="yes" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="sstext" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN']); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,4);"/> <input type="hidden" name="JUMLAH_SATUAN" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN']?>" />      
                            </td>
                            </tr>
                            <tr>
                                <td>Jenis Satuan</td>           
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                    <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" url="<?= site_url(); ?>/autocomplete/satuan" class="sstext" wajib="yes" value="<?= $sess['KODE_SATUAN']; ?>" urai="urjenis_satuan;" readonly />
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan','KODE_SATUAN;urjenis_satuan','Kode Satuan','fbarang_',650,400,'KD_SAT_BESAR;KD_SAT_KECIL;')" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>&nbsp;<span id="urjenis_satuan"><?= $sess['URAIAN_SATUAN']?$sess['URAIAN_SATUAN']:$urkd_stn; ?></span>
                               	</td>
                            </tr>        
                            <tr>
                                <td>Jumlah Kemasan</td>
                                <td><input type="text" name="JUMLAH_KEMASANUR" id="JUMLAH_KEMASANUR" class="sstext" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_KEMASAN']); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_KEMASAN',this.value,2);"/><input type="hidden" name="BARANG[JUMLAH_KEMASAN]" id="JUMLAH_KEMASAN" value="<?= $sess['JUMLAH_KEMASAN']?>" /></td>
                            </tr>
                            <tr>
                                <td>Jenis Kemasan</td>
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                    <input type="text" name="BARANG[KODE_KEMASAN]" id="KODE_KEMASAN" value="<?= $sess['KODE_KEMASAN']; ?>" url="<?= site_url(); ?>/autocomplete/kemasan" class="sstext" urai="urjenis_kemasan;" onfocus="Autocomp(this.id);"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan','KODE_KEMASAN;urjenis_kemasan','Kode Kemasan','fbarang_',650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>&nbsp;<span id="urjenis_kemasan"><?= $sess['URAIAN_KEMASAN']; ?></span>
                              	</td>
                            </tr>
                            <tr>
                                <td>Netto</td>
                                <td><input type="text" name="NETTOUR" id="NETTOUR" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['NETTO']); ?>" onkeyup="this.value = ThausandSeperator('NETTO',this.value,4);"/>&nbsp; Kilogram (KGM)<input type="hidden" name="BARANG[NETTO]" id="NETTO" value="<?= $sess['NETTO']?>" /></td>
                            </tr>
                            <tr> 
                                <td>Nilai CIF</td>
                                <td>
                                    <input type="text" wajib="yes" name="CIF_NILAI" id="CIF_NILAI" class="sstext"  value="<?= $this->fungsi->FormatRupiah($sess['CIF']); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('ciff',this.value,4);ProsesCIF();"/>
                                    <input type="hidden" name="BARANG[CIF]" id="ciff" value="<?= $sess['CIF']?$sess['CIF']:0 ?>" />
                            	</td>
                            </tr> 
                            <tr> 
                            <td align="right">RP</td>
                            	<td><input type="text"  id="CIFRPBRG" class="text" readonly value="<?= $this->fungsi->FormatRupiah($sess['CIFRPBRG'],2)?>"/></td>
                            </tr>
                            <tr> 
                                <td>Jenis Nilai</td>
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                   <input type="text" name="BARANG[JENIS_NILAI]" id="JENIS_NILAI" value="<?= $sess['JENIS_NILAI']; ?>" onclick="tb_search('jenis_nilai','JENIS_NILAI','Jenis Nilai',this.form.id,650,400)" class="sstext" urai="urjenis_kemasan;"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('jenis_nilai','JENIS_NILAI','Jenis Nilai','fbarang_',650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>
                                	
                              	</td>
                            </tr>  
                            <tr>
                            	<td>Nilai Tambahan</td>
                                <td>
                                	<input type="text" wajib="yes" name="NILAI_TAMBAHAN_UR" id="NILAI_TAMBAHAN_UR" class="sstext"  value="<?= $this->fungsi->FormatRupiah($sess['NILAI_TAMBAHAN']); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('NILAI_TAMBAHAN',this.value,4);"/>
                                    <input type="hidden" name="BARANG[NILAI_TAMBAHAN]" id="NILAI_TAMBAHAN" value="<?= $sess['NILAI_TAMBAHAN']?$sess['NILAI_TAMBAHAN']:0 ?>" />
                                </td>
                            </tr>    
                            <tr>
                            	<td>Tanggal Jatuh Tempo</td>
                                <td><div class="input-group" style="width:3em;float:left"><input type="text" name="BARANG[TGL_JATUH_TEMPO]" id="TGL_JATUH_TEMPO" onfocus="ShowDP('TGL_JATUH_TEMPO');" value="<?php if($act=="save") echo date("Y-m-d"); else echo $sess['TGL_JATUH_TEMPO']; ?>" class="form-control" style="width:95px" <?=$disabled?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
                                &nbsp; YYYY-MM-DD</td>
                            </tr>        
            			</table>          	
            		</td>
            		<td> 
                        <table>
                            <tr>
                                <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>BEA MASUK</b></h5></td>
                            </tr>
                            <tr>		
                                <td >Jenis Tarif </td>
                                <td><combo><?= form_dropdown('TARIF[JENIS_TARIF_BM]', array("1"=>"BM- BEA MASUK","2"=>"BMKITE - BEA MASUK KITE"), $sess['JENIS_TARIF_BM'], 'id="JENIS_TARIF_BM" class="sstext"'); ?></combo>&nbsp;<combo><?= form_dropdown('TARIF[KODE_TARIF_BM]', $jenis_tarif_tarif, $sess['KODE_TARIF_BM'], 'id="KODE_TARIF_BM" class="text" onchange="tarifBm(this.value,\''.$sess['JUMLAH_SATUAN_BM'].'\')"'); ?></combo></td>
                            </tr>
                            <tr>
                                <td>Besar Tarif </td>
                                <td>
                                    <input type="text" name="TARIF_BM1" id="TARIF_BM1" value="<?=$sess['TARIF_BM'];?>" class="ssstext" onkeyup="BesarTarif(this.value,1)"/>
                                    <span class="persen">&nbsp;&nbsp;%=Rp&nbsp;</span>
                                    <span class="jml-sat"><input type="text" id="TARIF_BM1UR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['TARIF_BM1UR'],0);?>"/><input type="hidden" id="TARIF_BM1UR_hide" value="<?= $sess['TARIF_BM1UR'];?>"/></span>
                                </td>  
                            </tr>
                            <tr class="dtl" style="display:none;">
                                <td align="right">Per</td>
                                <td>
                                    <input type="text" name="TARIF[KODE_SATUAN_BM]" id="KODE_SATUAN_BM" value="<?=$sess['KODE_SATUAN_BM'];?>" class="ssstext" url="<?= site_url(); ?>/autocomplete/satuan" urai="" onfocus="Autocomp(this.id);" wajib="yes" onchange="$('#KODE_SATUAN_BM_BOTTOM').val(this.value.toUpperCase())" onkeyup="$('#KODE_SATUAN_BM_BOTTOM').val(this.value.toUpperCase())" onmouseout="$('#KODE_SATUAN_BM_BOTTOM').val(this.value.toUpperCase())"/>
                                    <span>&nbsp;&nbsp;=Rp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <input type="text" id="KD_SAT_BM" class="stext" readonly/>
                                    <input type="hidden" id="KD_SAT_BM_hide"/>
                                </td>
                            </tr> 
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>               
                            <tr>
                                <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>TAMBAHAN BEA MASUK</b></h5></td>
                            </tr>
                            
                            <tr>
                                <td>BM Anti Dumping</td>
                                <td>
                                    <input type="text" name="TAMBAHAN[BM_ANTI_DUMPING]" id="BM_ANTI_DUMPING" class="ssstext"  value="<?= $sess['BM_ANTI_DUMPING']; ?>" onkeyup="BTambahan(this.value,'BM_ANTI_DUMPINGUR')"/>
                                    <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                                    <input type="text" id="BM_ANTI_DUMPINGUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_ANTI_DUMPINGUR'],0); ?>"/><input type="hidden" id="BM_ANTI_DUMPINGUR_hide" value="<?= $sess['BM_ANTI_DUMPINGUR'];?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>BM Imbalan</td>
                                <td>
                                    <input type="text" name="TAMBAHAN[BM_IMBALAN]" id="BM_IMBALAN" class="ssstext"  value="<?= $sess['BM_IMBALAN']; ?>" onkeyup="BTambahan(this.value,'BM_IMBALANUR')"/>
                                    <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                                    <input type="text" id="BM_IMBALANUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_IMBALANUR'],0); ?>"/><input type="hidden" id="BM_IMBALANUR_hide" value="<?= $sess['BM_IMBALANUR'];?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>BM Tindakan Pengamanan</td>
                                <td>
                                    <input type="text" name="TAMBAHAN[BM_PENGAMANAN]" id="BM_PENGAMANAN" class="ssstext"  value="<?= $sess['BM_PENGAMANAN']; ?>" onkeyup="BTambahan(this.value,'BM_PENGAMANANUR')"/>
                                    <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                                    <input type="text"  id="BM_PENGAMANANUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_PENGAMANANUR'],0); ?>"/><input type="hidden" id="BM_PENGAMANANUR_hide" value="<?= $sess['BM_PENGAMANANUR'];?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>BM Pembalasan</td>
                                <td>
                                    <input type="text" name="TAMBAHAN[BM_PEMBALASAN]" id="BM_PEMBALASAN" class="ssstext"  value="<?= $sess['BM_PEMBALASAN']; ?>" onkeyup="BTambahan(this.value,'BM_PEMBALASANUR')"/>
                                    <span>&nbsp;&nbsp;%=Rp&nbsp;</span>
                                    <input type="text" id="BM_PEMBALASANUR" class="stext" readonly value="<?= $this->fungsi->FormatRupiah($sess['BM_PEMBALASANUR'],0); ?>"/><input type="hidden" id="BM_PEMBALASANUR_hide"  value="<?= $sess['BM_PEMBALASANUR'];?>"/>
                                </td>
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
                                <td><input type="text" name="TARIF[TARIF_BM]" id="TARIF_BM" class="ssstext" value="<?= $sess['TARIF_BM']; ?>" /><span class="persen2">&nbsp;%&nbsp;</span><combo><?= form_dropdown('FASILITAS[KODE_FAS_BM]', $kode2_tarif, $sess['KODE_FAS_BM'], 'id="KODE_FAS_BM" class="text" onchange="showklm(this.value,\'FAS_BM\')"'); ?></combo>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_BM]" id="FAS_BM" class="ssstext" value="<?= $sess['FAS_BM']; ?>" disabled="disabled"/>&nbsp;%
                                    <table class="dtl_bottom" style="display:none">
                                        <tr>
                                            <td align="right">/&nbsp;</td>
                                            <td>
                                                <input type="text" name="KODE_SATUAN_BM_BOTTOM" id="KODE_SATUAN_BM_BOTTOM" value="<?=$sess['KODE_SATUAN_BM'];?>" class="ssstext" readonly />
                                                <span>&nbsp;&nbsp;Jm Satuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input type="text" name="JUMLAH_SATUAN_BM_BOTTOM" id="JUMLAH_SATUAN_BM_BOTTOM" class="stext" readonly value="<?=$sess['JUMLAH_SATUAN_BM']?>"/>&nbsp;Spesifik
                                            </td>
                                        </tr> 
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>PPN</td>
                                <td><input type="text" name="TARIF[TARIF_PPN]" id="TARIF_PPN" class="ssstext" value="<?= $sess['TARIF_PPN']; ?>" />&nbsp;%&nbsp;<combo><?= form_dropdown('FASILITAS[KODE_FAS_PPN]', $kode2_tarif, $sess['KODE_FAS_PPN'], 'id="KODE_FAS_PPN" class="text" onchange="showklm(this.value,\'FAS_PPN\')"'); ?></combo>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_PPN]" id="FAS_PPN" class="ssstext" value="<?= $sess['FAS_PPN']; ?>" disabled="disabled"/>&nbsp;%</td>
                            </tr>
                            <tr>
                                <td>PPnBM</td>
                                <td><input type="text" name="TARIF[TARIF_PPNBM]" id="TARIF_PPNBM" class="ssstext" value="<?= $sess['TARIF_PPNBM']; ?>" />&nbsp;%&nbsp;<combo><?= form_dropdown('FASILITAS[KODE_FAS_PPNBM]', $kode2_tarif, $sess['KODE_FAS_PPNBM'], 'id="KODE_FAS_PPNBM" class="text" onchange="showklm(this.value,\'FAS_PPNBM\')"'); ?></combo>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_PPNBM]" id="FAS_PPNBM" class="ssstext" value="<?= $sess['FAS_PPNBM']; ?>" disabled="disabled"/>&nbsp;%</td>
                            </tr>
                            <tr>
                                <td>PPh</td>
                                <td><input type="text" name="FASILITAS[JUM_PPH]" wajib="yes" id="pph_" class="ssstext" value="<?= $tarif_pph; ?>" onKeyPress="return intInput(event, /[.0-9]/)" />&nbsp;%&nbsp;<combo><?= form_dropdown('FASILITAS[KODE_FAS_PPH]', $kode2_tarif, $sess['KODE_FAS_PPH'], 'id="KODE_FAS_PPH" class="text" onchange="showklm(this.value,\'FAS_PPH\')"'); ?></combo>&nbsp;&nbsp;<input type="text" name="FASILITAS[FAS_PPH]" id="FAS_PPH" class="ssstext" value="<?= $sess['FAS_PPH']; ?>" disabled="disabled"/>&nbsp;%</td>
                            </tr>
                            <tr>
                            	<td>Persyaratan</td>
                                <td><input type="checkbox" value="1" name="lartas" id="lartas" <?php if($sess["LARTAS"]=="1"){ echo 'checked="true"';} ?>>&nbsp;Bukan Lartas</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>CUKAI</b></h5></td>
                            </tr>
                            <tr>
                                <td>Komoditi</td>
                                <td><combo><?= form_dropdown('TARIF[KODE_CUKAI]', $komoditi_cukai, $sess['KODE_CUKAI'], 'id="KODE_CUKAI" class="text"'); ?></combo></td>
                            </tr>
                            <tr>
                                <td>Jenis Tarif</td>                  
                                <td><combo><?= form_dropdown('TARIF[KODE_TARIF_CUKAI]', $jenis_tarif, $sess['KODE_TARIF_CUKAI'], 'id="KODE_TARIF_CUKAI" class="text" onchange="tarif(this.value,\''.$sess['TARIF_CUKAI'].'\',\''.$sess['KODE_SATUAN_CUKAI'].'\',\''.$sess['KODE_SATUAN_CUKAIUR'].'\')"'); ?></combo>&nbsp;<span id="tarif"><input type="text" name="TARIF[TARIF_CUKAI]" id="TARIF_CUKAI" class="sstext" value="<?= $sess['TARIF_CUKAI']; ?>" />&nbsp;<span id="cukai">%</span></span></td>
                            </tr>
                            <tr>
                                <td><span id="jml-cukai"></span></td>
                                <td><span id="tarf" style="display:none;"><input type="sstext" class="sstext" name="BARANG[JUMLAH_SATUAN_CUKAI]" id="JUMLAH_SATUAN_CUKAI" value="<?= $sess['JUMLAH_SATUAN_CUKAI']; ?>" wajib="yes"/> </span><combo><?= form_dropdown('FASILITAS[KODE_FAS_CUKAI]', $kode_fas_cukai, $sess['KODE_FAS_CUKAI'], 'id="KODE_FAS_CUKAI" class="sstext"'); ?></combo>&nbsp;<input type="text" class="ssstext" name="FASILITAS[FAS_CUKAI]" id="FAS_CUKAI" value="<?= $sess['FAS_CUKAI']; ?>"/> &nbsp;%</td>
                            </tr>                
                            <tr>
                                 <td>Fasilitas</td>
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                   <input type="text" name="BARANG[KODE_FASILITAS]" id="KODE_FASILITAS" value="<?= $sess['KODE_FASILITAS']; ?>" onclick="tb_search('fasilitas','KODE_FASILITAS','Fasilitas',this.form.id,650,400)" class="sstext" urai="urjenis_kemasan;"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('fasilitas','KODE_FASILITAS;ur_fas','Fasilitas','fbarang_'.id,650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>&nbsp;<span id="ur_fas"><?=$sess["UR_FAS"]?></span>
                            </tr>
                            <tr> 
                                <td>Skema Tarif</td>
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="BARANG[SKEMA]" id="SKEMA" value="<?= $sess['SKEMA']; ?>" onclick="tb_search('skema','SKEMA','Skema Tarif',this.form.id,650,400)" class="sstext" urai="urjenis_kemasan;"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('skema','SKEMA;ur_skema','Skema Tarif','fbarang_',650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>&nbsp;<span id="ur_skema"><?=$sess["UR_SKEMA"]?></span>
                              	</td>
                            </tr>
            			</table>
            		</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr id="getBB" class="listBB" style="display:none;">
                    <td colspan="2" width="100%">
                        <div id="dataBB"><?= $tabel;?></div>
                    </td>
                </tr>
      		</table>      	      
            <div class="ibutton" >
                <a href="javascript:void(0);" class="btn btn-success btn-l" id="ok_" onclick="save_detil('#fbarang_','msgbarang_');">
                	<i class="icon-save"></i>&nbsp;<?=ucwords($act); ?>
              	</a>
                <a href="javascript:;" class="btn btn-warning btn-l" id="cancel_" onclick="cancel('fbarang_');">
                	<i class="icon-undo"></i>&nbsp;Reset
               	</a>
                &nbsp;<span class="msgbarang_" style="margin-left:20px">&nbsp;</span>        
            </div>		
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
<?php }
if($act=="update"){
?>    
<script>
	tarifBm('<?=$sess['KODE_TARIF_BM']?>','<?=$sess['JUMLAH_SATUAN_BM']?>');
	tarif('<?=$sess['KODE_TARIF_CUKAI']?>','<?=$sess['TARIF_CUKAI']?>','<?=$sess['KODE_SATUAN_CUKAI']?>','<?=$sess['KODE_SATUAN_CUKAIUR']?>');
	showklm('<?=$sess['KODE_FAS_BM']?>','FAS_BM');
	showklm('<?=$sess['KODE_FAS_PPN']?>','FAS_PPN');
	showklm('<?=$sess['KODE_FAS_PPNBM']?>','FAS_PPNBM');
	showklm('<?=$sess['KODE_FAS_PPH']?>','FAS_PPH');
</script>
<?php } ?>
<script>
function showklm(val,id){
if(val==""){
$('#'+id).attr("disabled",true);
$('#'+id).attr("wajib","");		
}else{		
$('#'+id).attr("disabled",false);	
$('#'+id).attr("wajib","yes");		
}
}
$(function(){FormReady();})
</script>
<script>
$(document).ready(function(){
var flagrevisi = $('#flagrevisi').val();
if(flagrevisi != "1"){
$('#revisiDtlBarang').remove();
}
});
</script>
<script>
function kdBarangCek(val){
var kdbarang = $('#kdBarangHide').val();
var no = ($('#tblPemasukan tr').length) - 1;
if(val != kdbarang){
for (var i=1; i <= no; i++){
$('#pemasukan'+i).remove();
}
}else{
for (var i=1; i <= no; i++){
$('#pemasukan'+i).remove();
}
var type = 'bc25';
var aju = $('#NOMOR_AJU').val();
$.ajax({
url: site_url + "/pengeluaran/getDokumenIn/"+Math.random(),
type: "post",
data: {type: type, aju: aju},
success: function(data){
$('#tblPemasukan').append(data);
}
});
}
}
function addRow(){
var no = ($('#tblPemasukan tr').length);
if(no < 2){
var last = no;
}else{
var last = no-1;
}
var lastNodaftar = $('#noDaftar'+last).val();
var tmpLogid = $('#tmpLogid').val();
var tblDone = $('#pemasukan'+last+' #rowDone'+last).val();
if(lastNodaftar == ""){
jAlert('Pilih Dokumen Pemasukan Terlebih Dahulu!', ':: GB INVENTORY ::');
return false;
}
if (tblDone == "Done"){
jAlert('Silahkan tekan tombol "Done" jika sudah selesai mengisikan data!', ':: GB INVENTORY ::');
return false;
}
$('#tblPemasukan').append('<tr id="pemasukan'+no+'">\n\
<td style="text-align: center;">\n\
<input type="hidden" id="logidIn'+no+'" style="border-style: none;background-color: transparent;width:100px;" readonly="readonly" name="DOKIN['+no+'][LOGID]" />\n\
<input type="text" id="noDaftar'+no+'" style="border-style: none;background-color: transparent;width:100px;" readonly="readonly" name="DOKIN['+no+'][NO_DOK]" />\n\
<td style="text-align: center;">\n\
<input type="text" id="tglDaftar'+no+'" style="border-style: none;background-color: transparent;width:80px;" readonly="readonly" name="DOKIN['+no+'][TGL_DOK]" />\n\
</td>\n\
<td style="text-align: center;">\n\
<input id="saldoIn'+no+'" class="stext" type="hidden" name="DOKIN['+no+'][SALDO]" />\n\
<input id="JUMLAHIN'+no+'" class="stext" type="text" wajib="yes" name="DOKIN['+no+'][JUMLAH]" onkeyup="cekJumlahIn('+no+',this.value)">\n\
</td>\n\
<td style="text-align: center;">\n\
<input type="text" id="satuanIn'+no+'" style="border-style: none;background-color: transparent;width:40px;" readonly="readonly" name="DOKIN['+no+'][SATUAN]" />\n\
</td>\n\
<td style="text-align: center;">\n\
<input type="text" id="dokumenIn'+no+'" style="border-style: none;background-color: transparent;width:50px;" readonly="readonly" name="DOKIN['+no+'][JENIS_DOK]" />\n\
<input type="hidden" name="DOKIN['+no+'][SERI_BARANG]"/>\n\
</td>\n\
<td style="text-align: center;" id="act'+no+'">\n\
<input class="button" id="rowFind'+no+'" type="button" value="Cari" onclick="tb_search(\'dok_masuk_revisi\',\'noDaftar'+no+';tglDaftar'+no+';saldoIn'+no+';satuanIn'+no+';dokumenIn'+no+';logidIn'+no+'\',\'DOKUMEN PEMASUKAN\',this.form.id,650,450,\'KODE_BARANG;tmpLogid;logidIn'+no+'\')">\n\
<input class="button" id="rowDone'+no+'" type="button" value="Done" onclick="doneRow('+no+')">\n\
<input class="button" id="rowDelete'+no+'" type="button" value="Delete" onclick="delRow('+no+')">\n\
</td>\n\
</tr>');
var myLogid = $('#logidIn'+last).val();
var cari = tmpLogid.search(myLogid);
if(tmpLogid == ""){
$('#tmpLogid').val($('#logidIn'+last).val());
}else{
if (cari < 0){
$('#tmpLogid').val(tmpLogid+','+myLogid);
}
}
}
function editRow(id){
var jml = $('#JUMLAHIN'+id).val();
$('#rowEdit'+id).hide();
$('#rowDelete'+id).hide();
$('#act'+id).append("<input class='button' id='rowCancel"+id+"' type='button' value='Cancel' onclick='cancelRow("+id+","+jml+")'>\n\
<input class='button' id='rowDone"+id+"' type='button' value='Done' onclick='doneRow("+id+")'>");
$('#JUMLAHIN'+id).attr('readonly', false).attr('wajib','yes').focus();
}
function delRow(id){
var isi = $('#noDaftar'+id).val();
if(isi == ""){
$('#pemasukan'+id).remove();
}else{
jConfirm('Anda yakin Akan menghapus data ini?', " GB Inventory ",
function(r) {
if (r == true) {
var logid = $('#logidIn'+id) .val();
var tmpLogid = $('#tmpLogid').val();
var jml = $('#tblPemasukan tr').length - 1;
if (id < jml) {
logid = logid + ",";
tmpLogid = tmpLogid.replace(logid, "");
} else if (id > jml && jml == "1") {
logid = logid;
tmpLogid = tmpLogid.replace(logid, "");
} else if (id == "2" && jml == "2") {
tmpLogid = tmpLogid.replace(logid, "").replace(",", "");
} else {
if (logid != "") {
if(id == "1" && jml == "1"){
tmpLogid = tmpLogid.replace(logid, "");
}else{
logid = "," + logid;
tmpLogid = tmpLogid.replace(logid, "");
}
}
}
$('#tmpLogid').val(tmpLogid);
$('#pemasukan'+id).remove();
}
});
}
}
function cancelRow(id, lastJml){
$('#rowEdit'+id).show();
$('#rowDelete'+id).show();
$('#rowCancel'+id).remove();
$('#rowDone'+id).remove();
$('#JUMLAHIN'+id).attr('readonly', true).removeAttr('wajib');
if(lastJml != ""){
$('#JUMLAHIN'+id).val(lastJml);
}
}
function doneRow(id){
var isi = $('#noDaftar'+id).val();
var jumlah = $('#JUMLAHIN'+id).val();
if(jumlah == "" || jumlah == "0"){
jAlert('Silahkan mengisi jumlah terlebih dahulu!', ':: GB INVENTORY ::');
$('#JUMLAHIN'+id).focus();
return false;
}
if(isi == ""){
jAlert('Pilih Dokumen Pemasukan Terlebih Dahulu!', ':: GB INVENTORY ::');
return false;
}
$('#rowFind'+id).remove();
$('#rowCancel'+id).remove();
$('#rowDone'+id).remove();
$('#rowEdit'+id).remove();
$('#rowDelete'+id).remove();
$('#JUMLAHIN'+id).attr('readonly', true).removeAttr('wajib');
$('#act'+id).append("<input class='button' id='rowEdit"+id+"' type='button' value='Edit' onclick='editRow("+id+")'>\n\
<input class='button' id='rowDelete"+id+"' type='button' value='Delete' onclick='delRow("+id+")'>");
}
function cekJumlahIn(id, val){
var dataIn = $('#tblPemasukan tr').length - 1;
var total = $('#JUMLAH_SATUANUR').val().replace(",", "");
var saldo = $('#saldoIn'+id).val();
var logid = $('#logidIn'+id).val();
if (logid != ""){
var picked = 0;
for (var i=1; i<=dataIn; i++){
picked = picked + parseFloat($('#JUMLAHIN'+i).val());
if ((parseFloat(total)-parseFloat(picked)) < 0){
jAlert('Total jumlah melebihi jumlah dokumen pengeluaran!', ':: GB INVENTORY ::');
$("#JUMLAHIN"+id).val(0);
}
}
if(parseFloat(val) > parseFloat(saldo)){
jAlert('Jumlah melebihi saldo yang tersedia pada dokumen pemasukan!', ':: GB INVENTORY ::');
$("#JUMLAHIN"+id).val(0);
}
}else{
jAlert('Silahkan memilih dokumen pemasukan terlebih dahulu!', ':: GB INVENTORY ::');
$("#JUMLAHIN"+id).val("");
return false;
}
}
</script>

