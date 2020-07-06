<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>

<span id="DivHeaderForm">
	<form id="fbc24_" name="fbc24_" action="<?= site_url()."/pemasukan/bc24"; ?>" method="post" autocomplete="off" class="form-horizontal">
        <input type="hidden" name="act" id="act" value="<?= $act;?>" />
        <input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
        <input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"];?>" />
        <input type="hidden" name="HEADERDOK[NOMOR_AJU]" id="noajudok" value="<?= $aju;?>" />
        <table width="100%" border="0">
        	<tr>
                <td width="45%" valign="top">
                    <table width="100%" border="0">
                        <tr>
                            <td>Jenis Barang</td>
                            <td><combo><?= form_dropdown('HEADER[JNS_BARANG]', $jenis_barang, $sess['JNS_BARANG'], 'id="JNS_BARANG" class="text" '.$disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Kondisi </td>
                            <td>
                            	<input type="radio" name="HEADER[KONDISI]" value="1" <?php if($sess['KONDISI']==1) echo"checked=\"checked\""; ?> <?=$disabled?>/>
                                &nbsp;1.Baik   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="HEADER[KONDISI]" value="2" <?php if($sess['KONDISI']==2) echo"checked=\"checked\""; ?> <?=$disabled?>/>
                                &nbsp;2.Rusak
                        	</td>
                        </tr>
                        <tr>
                            <td>Tujuan </td>
                            <td><?= form_dropdown('HEADER[TUJUAN]', $tujuan_kirim, $sess['TUJUAN'], 'id="tujuan_kirim" class="text" wajib="yes" value="<?= $tujuan_kirim; ?>" '.$disabled); ?></td>
                        </tr>
                        <tr>
                            <td>Kriteria </td>
                            <td><?= form_dropdown('HEADER[KRITERIA]', $kriteria, $sess['KRITERIA'], 'id="KRITERIA" class="text" wajib="yes" value="<?= $kriteria; ?>" '.$disabled); ?></td>
                        </tr>
                    </table>
                </td>
                <td width="55%" valign="top">
                    <table width="100%">
                    	<tr>
                        	<td colspan="2" valign="top"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                        </tr>
                        <tr>
                            <td width="175">Nomor Pendaftaran*</td>
                            <td>
								<? if($sess['STATUS_DOK']=="LENGKAP"){?>
                        		<input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6" />
                        		<? }else{?>
                                <input type="text" disabled="disabled" class="stext date" maxlength="6" />
                                <? }?>
                        	</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran*</td>
                            <td>
								<? if($sess['STATUS_DOK']=="LENGKAP"){?>
                                <input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>" />
                                <? }else{?>
                                <input type="text" disabled="disabled" class="stext date"/>
                                <? }?>
                                &nbsp;YYYY-MM-DD 
                           	</td>
                        </tr>
                    </table>
            	</td>
            </tr>
     	</table>
		<h5 class="header smaller lighter green"><b>DATA PEMBERITAHUAN</b></h5>
        <table width="100%" border="0">
            <tr>
            	<td width="45%" valign="top">
            		<table width="100%" border="0">
            			<tr>
                        	<td colspan="3" class="rowheight" ><h5 class="smaller lighter blue"><b>DATA PEMASOK/PENGIRIM BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td><combo><?= form_dropdown('HEADER[KODE_NPWP_PEMASOK]', $kode_id_trader, $sess['KODE_NPWP_PEMASOK'], 'wajib="yes" id="kode_id_trader" class="sstext"'.$disabled); ?></combo>
                                <input type="text" name="HEADER[NPWP_PEMASOK]" id="id_trader" value="<?= $this->fungsi->FORMATNPWP($sess['NPWP_PEMASOK']); ?>" class="ltext" size="20" maxlength="15" wajib="yes" <?=$disabled?>/>
                                <input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" onclick="tb_search('pemasok','kode_id_trader;id_trader;nama_trader;alamat_trader','Pemasok','fbc24_',600,400)" value="...">
                    		</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="HEADER[NAMA_PEMASOK]" id="nama_trader" value="<?= $sess['NAMA_PEMASOK']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$disabled?>/></td>
                        </tr>
                        <tr>
                        	<td valign="top">Alamat</td>
                            <td>
                                <textarea name="HEADER[ALAMAT_PEMASOK]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')" <?=$disabled?>><?= $sess['ALAMAT_PEMASOK']; ?></textarea>
                                <div id="limitAlamatTrader"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Niper</td>
                            <td><input type="text" name="HEADER[NIPER_PEMASOK]" id="nama_trader" value="<?= $sess['NIPER_PEMASOK']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$disabled?>/></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><combo><?= form_dropdown('HEADER[STATUS_PEMASOK]', $status, $sess['STATUS_PEMASOK'], 'id="status" class="mtext" '.$disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>API / APIT / APIU</td>
                            <td><combo>
								<?= form_dropdown('HEADER[KODE_API]', $kode_api, $sess['KODE_API'], 'id="kode_api" class="sstext"'.$disabled); ?></combo>
                        		<input type="text" name="HEADER[NOMOR_API]" id="no_api" value="<?= $sess['NOMOR_API']?>" url="<?= site_url(); ?>/autocomplete/importir" class="ltext" maxlength="15" <?=$disabled?>/>
                       		</td>
                        </tr>
                            <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
        			</table>
           		</td>
				<td width="55%" valign="top">
                	<table width="100%" border="0">
                    	<tr>
                        	<td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>NDPBM (Kurs) </td>
                            <td>
                                <input type="text" name="NILAI_NDPBM" id="ndpbm_nilai" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['NDPBM'],4); ?>" maxlength="30" wajib="yes" onkeyup="this.value = ThausandSeperator('ndpbm',this.value,4);ProsesHeader()" <?=$disabled?>/>
                                <input type="hidden" name="HEADER[NDPBM]" id="ndpbm" value="<?= $sess['NDPBM']?>" />
                          	</td>
                        </tr>
                        <tr>
                            <td>Nilai CIF <span id="kdvaluta" style="padding-left:55px;"></span></td>
                            <td>
                            	<input type="text" name="CIF_TARIF" id="cifTarif" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['NILAI_CIF_BB']); ?>" maxlength="30" wajib="yes" onkeyup="this.value = ThausandSeperator('cif',this.value,2);ProsesHeader();" <?=$disabled?>/>
                            	<input type="hidden" name="HEADER[NILAI_CIF_BB]" id="cif" value="<?= $sess['NILAI_CIF_BB']?>" />
                        	</td>
                        </tr>
                        <tr>
                            <td align="right">Rp</td>
                            <td><input type="text"  id="CIFRP" class="mtext" readonly value="<?= $this->fungsi->FormatRupiah($sess['CIFRP'],4) ?>" ></td>
                        </tr>
                        <tr>
                            <td>Harga Penyerahan</td>
                            <td>
                                <input type="text" name="HARGA" id="harga" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN']); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('harga_penyerahan',this.value,2)" <?=$disabled?>/>
                                <input type="hidden" name="HEADER[HARGA_PENYERAHAN]" id="harga_penyerahan" value="<?= $sess['HARGA_PENYERAHAN']?>" />
                           	</td>
                        </tr>
                        <tr>
                        	<td colspan="3" class="rowheight" ><h5 class="smaller lighter blue"><b>DATA PENERIMA BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td><combo>
								<?= form_dropdown('HEADER[KODE_NPWP_PENERIMA]', $kode_id_trader, $sess['KODE_NPWP_PENERIMA'], 'wajib="yes" id="kode_id_penerima" class="sstext"'.$disabled); ?></combo>
                                <input type="text" name="HEADER[NPWP_PENERIMA]" id="id_penerima" value="<?= $this->fungsi->FORMATNPWP($sess['NPWP_PENERIMA']); ?>" class="ltext" size="20" maxlength="15" wajib="yes" <?=$disabled?>/>
                                <input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" onclick="tb_search('pemasok','kode_id_penerima;id_penerima;nama_penerima;alamat_penerima','Pemasok','fbc24_',600,400)" value="...">
                     		</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="HEADER[NAMA_PENERIMA]" id="nama_penerima" value="<?= $sess['NAMA_PENERIMA']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$disabled?>/></td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                                <textarea name="HEADER[ALAMAT_PENERIMA]" id="alamat_penerima" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')" <?=$disabled?>><?= $sess['ALAMAT_PENERIMA']; ?></textarea>
                                <div id="limitAlamatTrader"></div>
                          	</td>
                        </tr>
                	</table>
             	</td>
			</tr>
       	</table>
        <!--<h5 class="header smaller lighter green"><b>DATA PUNGUTAN :</b></h5>
        <table border="0" width="100%" cellpadding="7" cellspacing="0" class="table-striped table-bordered no-margin-bottom">
            <tr>
                <td width="15%" align="center" class="border-brlt">Jenis Pungutan</td>
                <td width="10%" align="center" class="border-brt">Dibayar (Rp) </td>
                <td width="10%" align="center" class="border-brt">Dibebaskan (Rp)</td>
                <td width="10%" align="center" class="border-brt">Ditangguhkan/Tidak<br/>Dipungut (Rp)</td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">BM</td>
                <td align="right" class="border" style="padding-right:10px;"><?=$A =($sess['PGT_BM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$AA =($sess['PGT_BM_DIB']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_DIB'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$AA =($sess['PGT_BM_DIT']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_DIT'],0):0;?></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">Cukai</td>
                <td align="right" class="border" style="padding-right:10px;"><?=$B =($sess['PGT_CUKAI']!="")?$this->fungsi->FormatRupiah($sess['PGT_CUKAI'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$BB =($sess['PGT_CUKAI_DIB']!="")?$this->fungsi->FormatRupiah($sess['PGT_CUKAI_DIB'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$BB =($sess['PGT_CUKAI_DIB']!="")?$this->fungsi->FormatRupiah($sess['PGT_CUKAI_DIT'],0):0;?></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">PPN</td>
                <td align="right" class="border" style="padding-right:10px;"><?=$C =($sess['PGT_PPN']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPN'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$CC =($sess['PGT_PPN_DIB']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPN_DIB'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$CC =($sess['PGT_PPN_DIT']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPN_DIT'],0):0;?></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">PPnBM</td>
                <td align="right" class="border" style="padding-right:10px;"><?=$D =($sess['PGT_PPNBM']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPNBM'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$DD =($sess['PGT_PPNBM_DIB']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPNBM_DIB'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$DD =($sess['PGT_PPNBM_DIT']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPNBM_DIT'],0):0;?></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">PPh</td>
                <td align="right" class="border" style="padding-right:10px;" ><?=$E =($sess['PGT_PPH']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPH'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$EE =($sess['PGT_PPH_DIB']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPH_DIB'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$EE =($sess['PGT_PPH_DIT']!="")?$this->fungsi->FormatRupiah($sess['PGT_PPH_DIT'],0):0;?></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">PNBP</td>
                <td align="right" class="border" style="padding-right:10px;"><?=$F =($sess['PGT_PNBP']!="")?$this->fungsi->FormatRupiah($sess['PGT_PNBP'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$FF =($sess['PGT_PNBP_DIB']!="")?$this->fungsi->FormatRupiah($sess['PGT_PNBP_DIB'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$FF =($sess['PGT_PNBP_DIT']!="")?$this->fungsi->FormatRupiah($sess['PGT_PNBP_DIT'],0):0;?></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">Denda/Bunga BM/Cukai(D/B)</td>
                <td align="right" class="border" style="padding-right:10px;"><?=$G =($sess['PGT_DENDA']!="")?$this->fungsi->FormatRupiah($sess['PGT_DENDA'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$GG =($sess['PGT_DENDA_STATUS']!="")?$this->fungsi->FormatRupiah($sess['PGT_DENDA_STATUS'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$GG =($sess['PGT_DENDA_STATUS']!="")?$this->fungsi->FormatRupiah($sess['PGT_DENDA_STATUS'],0):0;?></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl"><strong>TOTAL</strong></td>
                <td align="right" class="border" style="padding-right:10px;"><b>
                <?=$this->fungsi->FormatRupiah(str_replace(',','',$A)+str_replace(',','',$B)+str_replace(',','',$C)+str_replace(',','',$D)+str_replace(',','',$E)+str_replace(',','',$F)+str_replace(',','',$G)+str_replace(',','',$H),0)?>
                </b></td>
                <td  align="right" class="border" style="padding-right:10px;"><b>
                <?=$this->fungsi->FormatRupiah(str_replace(',','',$AA)+str_replace(',','',$BB)+str_replace(',','',$CC)+str_replace(',','',$DD)+str_replace(',','',$EE)+str_replace(',','',$FF)+str_replace(',','',$GG)+str_replace(',','',$HH),0)?>
                </b></td>
                <td  align="right" class="border" style="padding-right:10px;"><b>
                <?=$this->fungsi->FormatRupiah(str_replace(',','',$AAA)+str_replace(',','',$BBB)+str_replace(',','',$CCC)+str_replace(',','',$DDD)+str_replace(',','',$EEE)+str_replace(',','',$FFF)+str_replace(',','',$GGG)+str_replace(',','',$HHH),0)?>
                </b></td>
            </tr>
            <tr>
                <td style="padding-left:20px;" class="border-brl">Bunga PPN/PPnBM</td>
                <td align="right" class="border" style="padding-right:10px;"><?=$H =($sess['PGT_BUNGA']!="")?$this->fungsi->FormatRupiah($sess['PGT_BUNGA'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$HH =($sess['PGT_BUNGA_STATUS']!="")?$this->fungsi->FormatRupiah($sess['PGT_BUNGA_STATUS'],0):0;?></td>
                <td align="right" class="border" style="padding-right:10px;"><?=$HH =($sess['PGT_BUNGA_STATUS']!="")?$this->fungsi->FormatRupiah($sess['PGT_BUNGA_STATUS'],0):0;?></td>
            </tr>
        </table>-->
		<? if(!$priview){?>
        <div style="padding-top:2%;">
        	<a href="javascript:void(0);" class="btn btn-big btn-success" id="ok_" onclick="save_header('#fbc24_');">
                <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>
            </a>
            <a href="javascript:;" class="btn btn-big btn-warning" id="cancel_" onclick="cancel('fbc24_');">
                <i class="icon-undo"></i>&nbsp;Reset
            </a>
            <span class="msgheader_" style="margin-left:20px">&nbsp;</span>
        </div>
        <? } ?>
	</form>
</span>

<script>
	$(function(){FormReady();})
	<? if($priview){ ?>
			$('#fbc24_ input:visible, #fbc24_ select').attr('disabled',true);
	<? } ?>
</script>
