<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<span id="fbarang_form">
<?php if (!$list) { ?>
	<form id="fbarang_" name="fbarang_" action="<?= site_url() . "/pemasukan/barang/ppb"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?= site_url() . "/pemasukan/detil/barang/ppb" ?>">
    	<input type="hidden" name="act" readonly value="<?= $act; ?>" />
        <input type="hidden" name="seri" readonly id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="NOMOR_AJU" readonly id="NOMOR_AJU" value="<?= $aju; ?>" />
        <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
        <table width="100%">
        	<tr>
        		<td width="50%" valign="top">
                	<table width="100%">
                        <tr>
                            <td width="145">Kode HS/Seri HS</td>
                            <td><input type="text" name="BARANG[KODE_HS]" id="KODE_HS" url="<?= site_url(); ?>/autocomplete/hs_n_tarif" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" onfocus="Autocomp(this.id);" urai="SERI_HS;TARIF_BM;TARIF_PPN;TARIF_PPNBM;TARIF_CUKAI;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> / <input type="text" name="BARANG[SERI_HS]" id="SERI_HS" class="ssstext" wajib="yes" value="<?= $sess['SERI_HS']; ?>"/></td>
                        </tr>
                        <tr>
                            <td>Kode Barang</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                              <input type="text" readonly name="BARANG[KODE_BARANG]" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JENIS_BARANG;KODE_HS;SERI_HS;KD_SAT_BESAR;KD_SAT_KECIL;KODE_SATUAN;urjenis_satuan;" onfocus="Autocomp(this.id, this.form.id);"/>
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
                	</table>
                </td>
                <td valign="top">
                    <table width="100%">
                        <tr>
                            <td>Jumlah Satuan</td>
                            <td><input type="text" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'], 2); ?>" onkeyup="this.value = ThausandSeperator('JUMLAH_SATUAN', this.value, 2);"/>
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
                        	<td colspan="2"><h5 class="smaller lighter blue"><b>Dokumen Pemasukan</b></h5></td>
                        </tr>
                    	<tr>
                            <td>Kode Dokumen</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                              <input type="text" name="BARANG[KODE_DOKUMEN]" id="KODE_DOKUMEN" class="sstext" wajib="yes" value="<?= $sess['KODE_DOKUMEN']; ?>" readonly/>
                              <span class="input-group-btn">
                                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('DOKUMEN_PEMASUKAN', 'NO_DOKUMEN;TGL_DOKUMEN;KODE_DOKUMEN', 'Dokumen Pemasukan', 'fbarang_', 650, 400,'KODE_BARANG;')"><i class="fa fa-ellipsis-h"></i></a></span>
                              </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor Dokumen</td>
                            <td><input type="text" name="BARANG[NO_DOKUMEN]" id="NO_DOKUMEN" class="text" wajib="yes" value="<?=$sess['NO_DOKUMEN']; ?>" readonly/>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Dokumen</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> <input type="text" name="BARANG[TGL_DOKUMEN]" id="TGL_DOKUMEN" wajib="yes" value="<?=$sess['TGL_DOKUMEN']; ?>" class="form-control" style="width:90px;background:#fff" readonly /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
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