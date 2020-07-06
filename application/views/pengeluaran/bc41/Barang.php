<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<span id="fbarang_form">
	<?php if(!$list){?>
        <form id="fbarang_" action="<?= site_url()."/pengeluaran/barang/bc41"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?=  site_url()."/pengeluaran/detil/barang/bc41" ?>">
            <input type="hidden" name="act" value="<?= $act; ?>" readonly />
            <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" readonly />
            <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" readonly />
            <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
            <table width="100%">
                <tr>
                    <td width="45%" valign="top">  
                        <table width="100%" >
                            <tr>
                                <td width="145">Kode HS/Seri HS</td>
                                <td><input type="text" name="BARANG[KODE_HS]" id="KODE_HS" url="<?= site_url(); ?>/autocomplete/hs" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" onfocus="Autocomp(this.id);" urai="SERI_HS;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> / <input type="text" name="BARANG[SERI_HS]" id="SERI_HS" class="ssstext" wajib="yes" value="<?= $sess['SERI_HS'];?>"/> &nbsp;<input type="hidden" name="trf_serihs" id="trf_serihs" value="<?= $sess['SERI_HS']; ?>" /></td>
                            </tr>
                            <!-- <tr>
                                <td>Penggunaan Barang*</td>
                                <td><?form_dropdown('BARANG[PENGGUNAAN]', $penggunaan, $sess['PENGGUNAAN'], 'id="PENGGUNAAN" class="text" wajib="yes" value="<?$penggunaan; ?>" '); ?></td>
                            </tr>-->
                            <tr>
                                <td>Kode Barang</td>           
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                   <input type="text" name="KODE_BARANG" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;" onfocus="Autocomp(this.id, this.form.id);"/>
                                   <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan','Kode Barang','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>
                                    <input type="hidden" name="JNS_BARANG" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />             		
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
                                <td>
                                	<input type="text" onkeyup="this.value = ThausandSeperator('JUMLAH_KEMASAN',this.value,4);" id="UR_JUMLAH_KEMASAN" class="text" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_KEMASAN'],4); ?>" />
                                    <input type="hidden" name="BARANG[JUMLAH_KEMASAN]" id="JUMLAH_KEMASAN" class="text" value="<?=$sess["JUMLAH_KEMASAN"]?>" />
                               	</td>
                            </tr>
                            <tr>
                                <td>Jenis Kemasan</td>
                                <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                   <input type="text" name="BARANG[KODE_KEMASAN]" id="KODE_KEMASAN" value="<?= $sess['KODE_KEMASAN']; ?>" url="<?= site_url(); ?>/autocomplete/kemasan" class="sstext" urai="urjenis_kemasan;" onfocus="Autocomp(this.id);"/>
                                   <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kemasan','KODE_KEMASAN;urjenis_kemasan','Kode Kemasan','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>&nbsp;
                                    <span id="urjenis_kemasan"><?= $sess['URKODE_KEMASAN']; ?></span>
                                </td>
                            </tr>
                        </table>          	
                    </td>
                    <td width="65%" valign="top">       
                        <table width="100%" >			
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA HARGA</b></h5></td>
                        </tr>
                        <!--<tr>
                            <td>Bruto</td>
                            <td><input type="text" name="BRT_BRG" id="BRT_BRG" value="<?$this->fungsi->FormatRupiah($sess['BRUTO'],4); ?>" onkeyup="this.value = ThausandSeperator('BRUTO',this.value,4);" class="text" format="angka" wajib="yes"><input type="hidden" name="BARANG[BRUTO]" id="BRUTO" class="text" value="<?$sess['BRUTO']; ?>" maxlength="18"/>
                        </tr>-->
                        <tr>
                            <td>Netto</td>
                            <td><input type="text" name="NET_BRG" id="NET_BRG" value="<?= $this->fungsi->FormatRupiah($sess['NETTO'],4); ?>" onkeyup="this.value = ThausandSeperator('NETTO',this.value,4);" class="text" format="angka" wajib="yes"><input type="hidden" name="BARANG[NETTO]" id="NETTO" class="text" value="<?= $sess['NETTO']; ?>" maxlength="18"/>
                        </tr>
                        <tr>
                            <td>Volume</td>
                            <td><input type="text" name="VOL_BRG" id="VOL_BRG" value="<?= $this->fungsi->FormatRupiah($sess['VOLUME'],4); ?>" onkeyup="this.value = ThausandSeperator('VOLUME_DTL',this.value,4);" class="text" format="angka" wajib="yes"><input type="hidden" name="BARANG[VOLUME]" id="VOLUME_DTL" class="text" value="<?= $sess['VOLUME']; ?>" maxlength="18"/>
                        </tr>
                        <tr>
                            <td>Harga Penyerahan (Rp)</td>
                            <td><input type="text" name="HRG_PENY_BRG" id="HRG_PENY_BRG" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN'],4); ?>" onkeyup="this.value = ThausandSeperator('HARGA_PENYERAHAN_DTL',this.value,4);" class="text" format="angka" wajib="yes"><input type="hidden" name="BARANG[HARGA_PENYERAHAN]" id="HARGA_PENYERAHAN_DTL" class="text" value="<?= $sess['HARGA_PENYERAHAN']; ?>" maxlength="18"/>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td><input type="text" name="JUM_SAT_BRG" id="JUM_SAT_BRG" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'],4); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,4);satuan(this.value);" class="text" format="angka" wajib="yes"><input type="hidden" name="JUMLAH_SATUAN" id="JUMLAH_SATUAN" class="text" value="<?= $sess['JUMLAH_SATUAN']; ?>" maxlength="18"/>
                        </td>
                        </tr>
                        <tr>
                            <td>Kode Satuan</td>                       
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                    <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" url="<?= site_url(); ?>/autocomplete/satuan" class="sstext" wajib="yes" value="<?= $sess['KODE_SATUAN']; ?>" urai="urjenis_satuan;" readonly />
                                   <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan','KODE_SATUAN;urjenis_satuan','Kode Satuan','fbarang_',650,400,'KD_SAT_BESAR;KD_SAT_KECIL;')"><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>&nbsp;
                                <span id="urjenis_satuan"><?= $sess['URAIAN_SATUAN']?$sess['URAIAN_SATUAN']:$urkd_stn; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Bahan Baku</td>
                            <td>
                                <input type="text" name="BARANG[JUMLAH_BB]" id="JUMLAH_BHNBKU" readonly value="<?= $sess['JUM_BB']?$sess['JUM_BB']:"0";?>" size="1" class="ssstext"/>
                                <? if($seri){?>
                                <span class="fontBlueColor" onclick="ListBahanBaku('<?= site_url()."/pengeluaran/list_BB/bahan_baku/bc41/".$aju."/".$seri;?>','dataBB','listBB','getBB','msg_load');">LIST BAHAN BAKU</span>
                                <? }else{?>
                                &nbsp;
                                <? }?>
                            </td>
                        </tr>
                        </table>            
                    </td>
				</tr>
                <tr>
                	<td colspan="2" width="100%">&nbsp;</td>
                </tr>
                <tr id="getBB" class="listBB" style="display:none;">
                    <td colspan="2" width="100%">
                    	<div id="dataBB"><?= $tabel;?></div>
                    </td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
           	</table>      	      
            <div class="ibutton" >
            	<a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_detil('#fbarang_','msgbarang_');">
                	<i class="fa fa-save"></i>&nbsp;<?=ucwords($act); ?>
               	</a>
                <a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('fbarang_');">
                	<i class="icon-undo"></i>&nbsp;Reset
               	</a>
                <span class="msgbarang_" style="margin-left:20px">&nbsp;</span>
            </div>		
		</form> 
	<?php } ?>
</span>
<?php 
	if($edit){
		echo '<h5 class="header smaller lighter green"><b>&nbsp;</b></h5>';
	}
?>
<?php 
	if(!$edit){
		echo '<div id="fbarang_list">'.$list.'</div>';
	}
	if($act=="update"){
?>    
	<script>
        ListBahanBaku('<?= site_url()."/pengeluaran/list_BB/bahan_baku/bc41/".$aju."/".$seri;?>','dataBB','listBB','getBB','msg_load');
    </script>
<?php } ?>
<script>
$(function(){
	FormReady();
	$('#divAddBahanBakuJD,#divEditBahanBakuJD').live("dialogclose", function(){//alert('XXx');
//window.location.reload();
//$("#tabs").tabs({selected:[1]});

/*var tabs = $('#tabs').tabs();
tabs.tabs( 'url', 1,'<?site_url()."/pengeluaran/barang_loadTab/bc41/".$aju."/".$seri;?>');
tabs.tabs('load', 1);*/
	});
})
</script>
<script type="text/javascript">
$(document).ready(function(){
	if ($('#revisi').length > 0) {
		$('#labelRevisi').show();
		$('#inputRevisi').show();
		$('#tdrevisi').html('<input type="text" name="flagrevisi" value="1" />');
	}
});
</script>
<?php if($act=="update" && $sess["TANGGAL_REALISASI"]!="" && $sess["BREAKDOWN_FLAG"]=="Y"){ ?>
<script type="text/javascript">
	RevisiBreakdown('<?= site_url()."/realisasi_out/breakdown_proses/bc41/".$aju."/".$seri."/revisi"?>','dataBreakdown','listBreakdown','getBreakdown','msg_load');
</script>
<?php } ?>