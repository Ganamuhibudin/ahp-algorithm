<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if($kode_harga==1){
	$readonly="readonly=readonly";
}elseif($kode_harga==3){
	$readonly="";	
}
?>
<span id="fbarang_form">
	<?php if(!$list){?>
	<h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
	<form id="fbarang_" action="<?= site_url()."/pemasukan/barang/bc33"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?=  site_url()."/pemasukan/detil/barang/bc33" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <table width="100%">
            <tr>
            	<td width="48%" valign="top">  
            		<table width="100%">
                        <tr>
                            <td width="108">Kode HS</td>
                            <td width="415"><input type="text" name="BARANG[KODE_HS]" id="KODE_HS" url="<?= site_url(); ?>/autocomplete/hs" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" onfocus="Autocomp(this.id);" urai="SERI_HS;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> <input type="hidden" name="SERI_HS" id="SERI_HS"/></td>
                        </tr>
                        <tr>
                            <td>Kode Barang</td>                
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="KODE_BARANG" id="KODE_BARANG1" value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" readonly urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG1;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan','Kode Barang','fbarang_',650,400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                                <input type="hidden" name="JNS_BARANG" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />                		
                                <input type="hidden" id="KD_SAT_BESAR" name="KD_SAT_BESAR" value="<?= $sess['KD_SAT_BESAR']; ?>"/> 
                                <input type="hidden" id="KD_SAT_KECIL" name="KD_SAT_KECIL" value="<?= $sess['KD_SAT_KECIL']; ?>"/>
                                <input type="hidden" id="KODE_BARANG_HIDE" name="KODE_BARANG_HIDE" value="<?= $sess['KODE_BARANG']; ?>" />
                            </td>
                        </tr>		         
                        <tr>
                            <td>Uraian Barang</td>
                            <td><input type="text" name="BARANG[URAIAN_BARANG]" id="URAIAN_BARANG" class="text" value="<?= $sess['URAIAN_BARANG']; ?>"  maxlength="40" /></td>
                        </tr>             
                        <tr>
                            <td>Merk</td>
                            <td><input type="text" name="BARANG[MERK]" id="MERK" class="text" value="<?= $sess['MERK']; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Tipe</td>
                            <td><input type="text" name="BARANG[TIPE]" id="TIPE" class="text" value="<?= $sess['TIPE']; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Ukuran</td>
                            <td><input type="text" name="BARANG[UKURAN]" id="UKURAN" class="text" value="<?= $sess['UKURAN']; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Spesifikasi Lain</td>
                            <td><input type="text" name="BARANG[SPF]" id="SPF" class="text" value="<?= $sess['SPF']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Negara Asal</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="BARANG[NEGARA_ASAL]" id="NEGARA_ASAL" url="<?= site_url(); ?>/autocomplete/negara" class="text date" value="<?= $sess['NEGARA_ASAL']; ?>"  urai="urngr_asl;" onfocus="Autocomp(this.id);"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','NEGARA_ASAL;urngr_asl','Kode Negara','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urngr_asl"><?= $sess['URAIAN_NEGARA']==''?$urngr_asl:$sess['URAIAN_NEGARA']; ?></span>
                            </td>
                        </tr> 
                        <tr>
                            <td>Fasilitas</td>
                            <td>
                                <div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_FAS]" id="KODE_FAS" value="<?= $sess['KODE_FAS']; ?>" onclick="tb_search('fasilitas','KODE_FAS','Fasilitas',this.form.id,650,400)" class="sstext" urai="urjenis_kemasan;"/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('fasilitas','KODE_FAS;ur_fas','Fasilitas','fbarang_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="ur_fas"><?=$sess["UR_FAS"]?></span>
                            </td>
                        </tr>
            		</table>          	
    			</td>
                <td width="52%" valign="top">  
                    <table width="100%">		
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA HARGA</b></h5></td>
                        </tr>
                        <tr style="display:none" id="taghargacif">
                            <td width="22%">Harga CIF</td>
                            <td width="78%">
                                <input type="text" name="INVO" id="INVO" wajib="yes" class="text" value="<?=$this->fungsi->FormatRupiah($sess['INVOICE'],4); ?>" onkeyup="this.value = ThausandSeperator('INVOICE',this.value,4);satuan()"  />
                                <input type="hidden" name="BARANG[INVOICE]" id="INVOICE" value="<?= $sess['INVOICE']?>" />   
                            </td>
                        </tr>
                        <tr>
                            <td>Harga FOB</td>
                            <td>
                                <input type="text" name="FOB_DTL" id="FOB_DTL" wajib="yes" class="text" <?php // $readonly;?> value="<?=$this->fungsi->FormatRupiah($sess['FOB_PER_BARANG'],4); ?>" onkeyup="this.value = ThausandSeperator('FOB_PER_BARANG',this.value,4);satuan()" />
                                <input type="hidden" name="BARANG[FOB_PER_BARANG]" id="FOB_PER_BARANG" value="<?= $sess['FOB_PER_BARANG']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td>
                                <input type="text" name="JUML_SAT" id="JUML_SAT" wajib="yes" class="text" value="<?=$this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'],4); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,4);satuan()"  />
                                <input type="hidden" name="JUMLAH_SATUAN" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Kode Satuan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="BARANG[KODE_SATUAN]" id="KODE_SATUAN" url="<?= site_url(); ?>/autocomplete/satuan" class="sstext" wajib="yes" value="<?= $sess['KODE_SATUAN']; ?>" urai="urjenis_satuan;" readonly />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan','KODE_SATUAN;urjenis_satuan','Kode Satuan','fbarang_',650,400,'KD_SAT_BESAR;KD_SAT_KECIL;')" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urjenis_satuan"><?= $sess['URAIAN_SATUAN']?$sess['URAIAN_SATUAN']:$urkd_stn; ?></span>
                            </td>            
                        </tr>
                        <tr>
                            <td>Volume</td>
                            <td>
                                <input type="text" name="VOLUME_BRG" id="VOLUME_BRG" wajib="yes" class="text" value="<?=$this->fungsi->FormatRupiah($sess['VOLUME'],4); ?>" onkeyup="this.value = ThausandSeperator('VOLUMES',this.value,4);"  />
                                <input type="hidden" name="BARANG[VOLUME]" id="VOLUMES" value="<?= $sess['VOLUME']?>" />&nbsp; (M3)
                            </td>
                        </tr>	
                        <tr>
                            <td>Netto</td>
                            <td>
                                <input type="text" name="NETTO_BRG" id="NETTO_BRG" wajib="yes" class="text" value="<?=$this->fungsi->FormatRupiah($sess['NETTO'],4); ?>" onkeyup="this.value = ThausandSeperator('NETTOS',this.value,4);"  />
                                <input type="hidden" name="BARANG[NETTO]" id="NETTOS" value="<?= $sess['NETTO']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>HE Barang</td>
                            <td>
                                <input type="text" name="HARGA_EKSPOR_UR" id="HARGA_EKSPOR_UR" wajib="yes" class="text" value="<?=$this->fungsi->FormatRupiah($sess['HARGA_EKSPOR'],4); ?>" onkeyup="this.value = ThausandSeperator('HARGA_EKSPOR',this.value,4);"  />
                                <input type="hidden" name="BARANG[HARGA_EKSPOR]" id="HARGA_EKSPOR" value="<?= $sess['HARGA_EKSPOR']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Bea Keluar</td>
                            <td>
                                <input type="text" name="BK_UR" id="BK_UR" wajib="yes" class="sstext" value="<?=$this->fungsi->FormatRupiah($sess['BEA_KELUAR'],4); ?>" onkeyup="this.value = ThausandSeperator('BEA_KELUAR',this.value,4);"  />&nbsp;%
                                <input type="hidden" name="BARANG[BEA_KELUAR]" id="BEA_KELUAR" value="<?= $sess['BEA_KELUAR']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>PPH</td>
                            <td>
                                <input type="text" name="PPH_UR" id="PPH_UR" wajib="yes" class="sstext" value="<?=$this->fungsi->FormatRupiah($sess['PPH'],4); ?>" onkeyup="this.value = ThausandSeperator('PPH',this.value,4);"  />&nbsp;%
                                <input type="hidden" name="BARANG[PPH]" id="PPH" value="<?= $sess['PPH']?>" />
                            </td>
                        </tr>
                    </table>            
                </td>
			</tr>
		</table> 
        <div class="ibutton" style="padding-top:2%; padding-left:10%;" >
            <a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fbarang_','msgbarang_');">
            	<i class="icon-save"></i>&nbsp;<?=ucwords($act); ?>
           	</a>
            <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbarang_');">
            	<i class="icon-undo"></i>&nbsp;Reset
          	</a>&nbsp;
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
<?php if(!$edit){ ?>
<div id="fbarang_list"><?= $list ?></div>
<?php } ?>

<script>
satuan();
$(function(){FormReady();})

$("#fbc33_").find("#KATEGORI_EKSPOR").bind('change keyup',function(){
    if($(this).val()=="33"){
            $("#PJT-TABLE").show();	
    }else{
            $("#PJT-TABLE").hide();	
    }
});

if($("#fbc33_").find("#KATEGORI_EKSPOR").val()=="33"){
    $("#PJT-TABLE").show();	
}else{
    $("#PJT-TABLE").hide();	
}


if($("#fbc33_").find("#KODE_HARGA").val()=="1"){
    $("#taghargacif").show();	
}else{	
    $("#taghargacif").hide();	
}
</script>

  
