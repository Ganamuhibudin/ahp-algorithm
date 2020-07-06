<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fbarang_form">
	<?php if(!$list){?>
		<form id="fbarang_" action="<?= site_url()."/pengeluaran/barang/p3bet"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?=  site_url()."/pengeluaran/detil/barang/p3bet" ?>">
			<input type="hidden" name="act" id="act" value="<?= $act; ?>" />
            <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
            <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" /> 
            <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>            
            <table width="100%">
            	<tr>
            		<td width="50%;" valign="top">  
            			<table>
                            <tr>
                            	<td colspan="2" class="rowheight"><h5 class="smaler lighter blue"><b>DATA BARANG</b></h5></td>
                            </tr>         
                            <tr>    
                            	<td width="40%">Kode Barang</td>          
                            	<td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                     <input type="text" name="KODE_BARANG" id="KODE_BARANG" readonly value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;" />
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan','Kode Barang','fbarang_',650,400)" ><i class="fa fa-ellipsis-h"></i></a></span>
                                    </div>
                                   
                                    
                                    <input type="hidden" name="JNS_BARANG" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />            		
                                    <input type="hidden" id="KD_SAT_BESAR" name="KD_SAT_BESAR" value="<?= $sess['KD_SAT_BESAR']; ?>"/> 
                                    <input type="hidden" id="KD_SAT_KECIL" name="KD_SAT_KECIL" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
                                    <input type="hidden" id="KODE_HS" name="KODE_HS" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
                                    <input type="hidden" id="SERI_HS" name="SERI_HS" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
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
                                <td>Barang Parsial</td>
                                <td>
                                    <input type="radio" name="BARANG[BARANG_PARSIAL]" value="Y" id="BARANG_PARSIAL" <?php if($sess['BARANG_PARSIAL'] == 'Y') echo 'checked = "true"'; ?>> Ya
                                    <input type="radio" name="BARANG[BARANG_PARSIAL]" value="T" id="BARANG_PARSIAL" <?php if($sess['BARANG_PARSIAL'] == 'T') echo 'checked = "true"'; ?>> Tidak
                                </td>
                            </tr>
                                
            			</table>          	
            		</td>
            		<td width="50%;" valign="top"> 
                        <table>
                            <tr>
                                <td colspan="2" class="rowheight"><h5 class="smaler lighter blue"><b>SATUAN DAN HARGA</b></h5></td>
                            </tr>
                            <tr>
                                <td width="30%">Jumlah Satuan</td>
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
                                <td>Nialai Barang</td>
                                <td><input type="text" name="UR_HARGA_BARANG" id="UR_HARGA_BARANG" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_BARANG']); ?>" onkeyup="this.value = ThausandSeperator('HARGA_BARANG',this.value,4);"/><input type="hidden" name="BARANG[HARGA_BARANG]" id="HARGA_BARANG" value="<?= $sess['HARGA_BARANG']?>" /></td>
                            </tr> 
                            <tr>
                                <td>Netto</td>
                                <td><input type="text" name="NETTOUR" id="NETTOUR" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['NETTO']); ?>" onkeyup="this.value = ThausandSeperator('NETTO',this.value,4);"/>&nbsp; Kilogram (KGM)<input type="hidden" name="BARANG[NETTO]" id="NETTO" value="<?= $sess['NETTO']?>" /></td>
                            </tr> 
                            <tr>
                                <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BC 1.6</b></h5></td>
                            </tr>
                            <tr>		
                                <td>Nomor</td>
                                <td><input type="text" name="BARANG[NOMOR_BC16]" id="NOMOR_BC16" class="stext" wajib="yes" value="<?= $sess['NOMOR_BC16']; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>
                                    <input type="text" name="BARANG[TANGGAL_BC16]" id="TANGGAL_BC16" onfocus="ShowDP('TANGGAL_BC16');" value="<?php echo $sess['TANGGAL_BC16']; ?>" class="sstext"/>
                                </td>  
                            </tr>
            			</table>
            		</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
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