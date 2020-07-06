<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fbarang_jadi_form">
<?php if(!$list){ ?>
	<form id="fbarang_jadi_" action="<?= site_url()."/pemasukan/barang_jadi/bc27"; ?>" method="post" autocomplete="off" list="<?= site_url()."/pemasukan/detil/barang_jadi/bc27" ?>">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="SERIBJ" id="SERIBJ" value="<?= $sess['SERIBJ']; ?>" />
        <input type="hidden" name="NOMOR_AJUNYA" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <input type="hidden" name="JNS_BARANG" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>" />
        <input type="hidden" name="SERI_HS" id="SERI_HS" class="sstext" value="<?= $sess['SERI_HS']; ?>"  />
        <h5 class="header smaller lighter green"><b>DETIL BARANG JADI</b></h5>
		<table width="100%">
            <tr>
                <td width="50%">
                	<table width="100%">
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td width="127">Kode HS</td>
                            <td><input type="text" name="BARANGJD[KODE_HS]" id="KODE_HS" class="text" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" url="<?= site_url()?>/autocomplete/hs" urai="SERI_HS;" wajib="yes" onfocus="Autocomp(this.id)" maxlength="13" onblur="this.value = FormatHS(this.value)"/></td>
                        </tr> 
                        <tr>
                            <td>Kode Barang</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="KODE_BARANG" id="KODE_BARANG" wajib="yes" class="text" value="<?= $sess['KODE_BARANG']; ?>" url="<?= site_url()?>/autocomplete/barang_ALL" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPFF;JNS_BARANG;" onfocus="Autocomp(this.id)" />
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPFF;JNS_BARANG;KODE_HS','Kode Barang','fbarang_jadi_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                         	</td>
                        </tr> 	         
                        <tr>
                            <td valign="top">Uraian Barang </td>
                            <td><textarea name="BARANGJD[URAIAN_BARANG]" id="URAIAN_BARANG" class="text" onkeyup="limitChars(this.id, 95, 'limitURGBRGJD')"><?= $sess['URAIAN_BARANG'];?></textarea>
                            <div id="limitURGBRGJD"></div>
                            </td>
                        </tr>                        
                        <tr>
                            <td>Merk</td>
                            <td><input type="text" name="BARANGJD[MERK]" id="MERK" class="text" value="<?= $sess['MERK']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Tipe</td>
                            <td><input type="text" name="BARANGJD[TIPE]" id="TIPE" class="text" value="<?= $sess['TIPE']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Ukuran</td>
                            <td><input type="text" name="BARANGJD[UKURAN]" id="UKURAN" class="text" value="<?= $sess['UKURAN']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Spesifikasi</td>
                            <td><input type="text" name="BARANGJD[SPF]" id="SPFF" class="text" value="<?= $sess['SPF']; ?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>	        
                	</table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="rowheight"><h5 class="smaller lighter blue"><b>DATA SATUAN</b></h5></td>
                        </tr>
                        <tr>
                            <td width="142">Kode Satuan *</td>
                            <td width="532"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="BARANGJD[KODE_SATUAN]" id="KODE_SATUAN" class="stext date" value="<?= $sess['KODE_SATUAN']; ?>" wajib="yes" url="<?= site_url()?>/autocomplete/satuan" urai="ursatuan;" onfocus="Autocomp(this.id)"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan','KODE_SATUAN;ursatuan','Kode Satuan','fbarang_jadi_',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="ursatuan"><?= $sess['URAIAN_SATUAN']==''?$URAIAN_SATUAN:$sess['URAIAN_SATUAN']; ?></span></td>
                        </tr>
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td><input type="text" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="stext" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'],4); ?>"  onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN',this.value,4);"/>
                             <input type="hidden" name="BARANGJD[JUMLAH_SATUAN]" id="JUMLAH_SATUAN" value="<?= $sess['JUMLAH_SATUAN']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Bahan Baku</td>
                            <td>
                                <input type="text" name="BARANGJD[JUMLAH_BB]" id="JUMLAH_BB" readonly value="<?= $sess['JUM_BB']?$sess['JUM_BB']:"0";?>" size="1" class="numtext"/>
                                 <? if($seri){?>
                                    <span onclick="ListBahanBaku('<?= site_url()."/pemasukan/list_BB/bahan_baku/bc27/".$aju."/".$seriBJ;?>','dataBB','listBB','getBB','msg_load');" style="color:#2283C5;cursor:pointer"><strong>LIST BAHAN BAKU</strong></span>
                                <? }else{?>
                                    &nbsp;
                                <? }?>
                            </td>
                        </tr>             
                    </table>
                </td>
            </tr>
            <tr id="getBB" class="listBB" style="display:none;">
                <td colspan="2" width="100%">
                    <div id="dataBB"><?= $tabel;?></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<table width="100%">
                    	<tr>
                        	<td  width="127" colspan="2"><br><br><a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_detil('#fbarang_jadi_','msgbarangjadi_');">
                                    <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;
                                </a>
                                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbarang_jadi_');">
                                    <i class="icon-undo"></i>&nbsp;Reset&nbsp;
                                </a>&nbsp;
                                <span class="msgbarangjadi_" style="margin-left:20px">&nbsp;</span></td>
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
<?php if(!$edit){ ?>
<div id="fbarang_jadi_list"><?= $list ?></div>
<?php }
if($act=="update"){
?>    
<script>
	ListBahanBaku('<?= site_url()."/pemasukan/list_BB/bahan_baku/bc27/".$aju."/".$seri;?>','dataBB','listBB','getBB','msg_load');
</script>
<?php } ?>
<script>
$(function(){FormReady();})
</script>
