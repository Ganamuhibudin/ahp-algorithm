<span id="DivHeaderForm">
    <?php
    if (!defined('BASEPATH'))  exit('No direct script access allowed');
    error_reporting(E_ERROR);
	if ($this->uri->segment(1) == 'pemasukan') $tipe_dok = "MASUK";
    elseif ($this->uri->segment(1) == 'pengeluaran') $tipe_dok = "KELUAR";
	?>
    <form id="fppb_" name="fppb_" action="<?= site_url() . "/pemasukan/ppb"; ?>" method="post" autocomplete="off">
        <input type="hidden" name="act" id="act" value="<?= $act; ?>" />
        <input type="hidden" name="HEADER[TIPE_DOK]" id="TIPE_DOK" value="<?= $tipe_dok; ?>" />
        <input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju; ?>" />
        <input type="hidden" name="HEADERDOK[NOMOR_AJU]" id="noajuDOK" value="<?= $aju; ?>" />
        <input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"]; ?>" /><span id="divtmp"></span>
        <table width="100%" border="0">
            <tr>
            	<td width="45%" valign="top">				
                	<table width="100%" border="0">   
                        <tr>
                            <td width="109" colspan="2"><h5 class="header smaller lighter green"><b>KANTOR PABEAN</b></h5></td>
                        </tr>
                        <tr>
                            <td width="109">Kantor Pendaftaran</td>
                            <td width="327"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                              <input type="text"  name="HEADER[KODE_KPBC_PENDAFTARAN]" id="kode_kpbc" class="stext date" value="<?= $sess['KODE_KPBC_PENDAFTARAN']; ?>" url="<?= site_url() ?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                              <span class="input-group-btn">
                                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc', 'kode_kpbc;urkt', 'Kode Kpbc', 'fppb_', 650, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                              </div>&nbsp;<span id="urkt"><?= $sess['UR_KPBC_PENDAFTARAN'] == '' ? $URKANTOR_TUJUAN : $sess['UR_KPBC_PENDAFTARAN']; ?></span> </td>
                        </tr>
                        <?php if($act=="update"){ ?>
                        <tr>
                        	<td>Nomor Aju</td>
                            <td><?=$this->fungsi->FormatAju($sess["NOMOR_AJU"]);?></td>
                        </tr>
                        <tr>
                        	<td>Tanggal Aju</td>
                            <td><?=$sess["TANGGAL_AJU"];?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </td>
                <td width="55%" valign="top">
                    <table width="80%" style="margin-left:20px">
                    	<tr>
                        	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                        </tr>
                        <tr>
                            <td width="30%">Nomor Pendaftaran</td>
                            <td width="70%">
                                <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                <input type="hidden" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="8" <?= $disabled ?>/>
                                <input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN_EDIT]" id="NOMOR_PENDAFTARAN_EDIT" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="8"  <?=$disabled?>/>
                                 <?php } else { ?>
                                <input type="text" disabled="disabled" class="text date" maxlength="6" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>"/>
                                 <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px">
                            <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                <input type="hidden" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="form-control" style="width:90px" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>" <?= $disabled ?>/>
                                <input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN_EDIT]" id="TANGGAL_PENDAFTARAN_EDIT" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="form-control" style="width:90px" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"  <?=$disabled?> />
                            <?php } else { ?>
                                <input type="text" disabled="disabled" class="form-control" style="width:90px;background:#fff" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"/>
                            <?php } ?><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <h5 class="header smaller lighter green"><b>IDENTITAS PENGUSAHA PUSAT LOGISTIK BERIKAT/PDPLB</b></h5>
        <table width="100%" border="0">
            <tr>
                <td width="45%" valign="top">		
                    <table width="100%" border="0">
                        <tr>
                            <td width="139">Identitas</td>
                            <td>
								<combo><?= form_dropdown('HEADER[KODE_ID_TRADER]', $kode_id_trader, $sess['KODE_ID_TRADER'], 'wajib="yes" id="kode_id_trader" class="sstext" '.$disabled); ?></combo> <input type="text" name="HEADER[ID_TRADER]" id="id_trader" value="<?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?>" class="ltext" size="20" maxlength="15" wajib="yes" <?=$readonly?>/>
                          	</td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_TRADER]" id="nama_trader" value="<?= $sess['NAMA_TRADER']; ?>" class="mtext" maxlength="50" wajib="yes" <?=$readonly?>/>
                           	</td>
                        </tr>
                        
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_TRADER]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')" <?=$disabled?>><?= $sess['ALAMAT_TRADER']; ?></textarea>
                            	<div id="limitAlamatTrader"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor Izin</td>
                            <td>
                            	<input type="text" name="HEADER[REGISTRASI]" id="registrasi" class="mtext" value="<?= $sess['REGISTRASI']; ?>" maxlength="30" <?=$readonly?>/>
                        	</td>
                        </tr>
                    </table>
                </td> 
           	</tr>
           	<tr>
                <td colspan="2">
                    <h5 class="header smaller lighter green"><b>ASAL LOKASI BARANG DAN TUJUAN PEMINDAHAN BARANG</b></h5>
                    <table width="100%" border="0">
                        <tr>
                            <td width="45%" valign="top">		
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="139">Kantor Asal</td>
                                        <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                              <input type="text"  name="HEADER[KODE_KPBC_ASAL]" id="kode_kpbc_asal" class="stext date" value="<?= $sess['KODE_KPBC_ASAL']; ?>" url="<?= site_url() ?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                                              <span class="input-group-btn">
                                                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc', 'kode_kpbc_asal;urkt_asal', 'Kode Kpbc', 'fppb_', 650, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                            </div> &nbsp;<span id="urkt_asal"><?= $sess['UR_KODE_KPBC_ASAL'] == '' ? $URAIAN_KPBC_ASAL : $sess['UR_KODE_KPBC_ASAL']; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td width="139" valign="top">Lokasi Asal Barang</td>
                                        <td>
                                        	<textarea class="mtext" name="HEADER[LOKASI_ASAL_BARANG]"><?php if($act=="save") echo $this->newsession->userdata("NAMA_TRADER"); else $sess["LOKASI_ASAL_BARANG"]?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="55%" valign="top">		
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="25%">Kantor Tujuan</td>
                                        <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                              <input type="text"  name="HEADER[KODE_KPBC_TUJUAN]" id="kode_kpbc_tujuan" class="stext date" value="<?= $sess['KODE_KPBC_TUJUAN']; ?>" url="<?= site_url() ?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                                              <span class="input-group-btn">
                                                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc', 'kode_kpbc_tujuan;urkt_tujuan', 'Kode Kpbc', 'fppb_', 650, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                            </div> &nbsp;<span id="urkt_tujuan"><?= $sess['UR_KODE_KPBC_TUJUAN'] == '' ? $URAIAN_KPBC_TUJUAN : $sess['UR_KODE_KPBC_TUJUAN']; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Lokasi Tujuan Barang</td>
                                        <td>
                                        	<textarea class="mtext" name="HEADER[LOKASI_TUJUAN_BARANG]"><?=$sess["LOKASI_TUJUAN_BARANG"]?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h5 class="header smaller lighter green"><b>PENANDATANGANAN</b></h5>
                    <table width="100%" border="0">
                        <tr>                      
                            <td width="37%" valign="top">		
                                <table width="100%" border="0">
                                	<h5 class="smaller lighter blue"><b>Penanggungjawab</b></h5> 
                                    <tr>
                                        <td width="139">Kota</td>
                                        <td><input type="text" name="HEADER[KOTA_TTD]" id="KOTA_TTD" value="<?= $sess['KOTA_TTD']; ?>" class="mtext"  <?= $disabled ?>/></td>
                                    </tr>
                                    <tr>
                                        <td width="139">Tanggal</td>
                                        <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> <input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" onfocus="ShowDP('tanggal_ttd');" onclick="ShowDP('tanggal_ttd');" value="<?php if($act=="save") echo date("Y-m-d"); else echo $sess['TANGGAL_TTD']; ?>" class="form-control" style="width:90px"  <?=$disabled?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;YYYY-MM-DD</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Nama Pemberitahu</td>
                                        <td><input type="text" name="HEADER[NAMA_PEMOHON]" id="NAMA_PEMOHON" value="<?= $sess['NAMA_PEMOHON']; ?>" class="mtext" <?= $disabled ?> /></td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan Pemberitahu</td>
                                        <td><input type="text" name="HEADER[JABATAN_PEMOHON]" id="JABATAN_PEMOHON" value="<?= $sess['JABATAN_PEMOHON']; ?>" class="mtext"  <?= $disabled ?>/></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="45%" valign="top">
                                <table width="100%" border="0">
 	                               	<h5 class="smaller lighter blue"><b>Lembar Persetujuan Bea Cukai</b></h5>
                                    <tr>
                                    	<td width="25%">Nama</td>
                                        <td><input type="text" name="HEADER[NAMA_PETUGAS_BC]" id="NAMA_PETUGAS_BC" value="<?= $sess['NAMA_PETUGAS_BC']; ?>" class="mtext"  <?= $disabled ?>/></td>
                                    </tr>
                                    <tr>
                                    	<td>NIP</td>
                                        <td><input type="text" name="HEADER[NIP_PETUGAS_BC]" id="NIP_PETUGAS_BC" value="<?= $sess['NIP_PETUGAS_BC']; ?>" class="mtext"  <?= $disabled ?>/></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2"><h5 class="smaller lighter blue"><b>Catatan</b></h5></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2">Selesai dipindahkan pada tanggal </td>
                                    </tr>
                                    <tr>
                                    	<td>Tanggal</td>
                                        <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px;margin-right:5px"><input type="text" name="HEADER[TANGGAL_SELESAI]" id="TANGGAL_SELESAI" onfocus="ShowDP('TANGGAL_SELESAI');" onclick="ShowDP('TANGGAL_SELESAI');" value="<?php if($act=="save") echo date("Y-m-d"); else echo $sess['TANGGAL_SELESAI']; ?>" class="form-control" style="width:90px"  <?=$disabled?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;<span style="float:left;margin-left:10px">Waktu</span>&nbsp;<div class="input-group" style="width:3em;float:left;margin-left:5px;margin-bottom:0px"><input id="WAKTU_SELESAI" class="form-control" style="width:50px" type="text" onfocus="ShowTime(this.id)" onclick="ShowTime(this.id)" name="HEADER[WAKTU_SELESAI]" value="<?php if($act=="save") echo date("H:i"); else echo $sess['WAKTU_SELESAI']; ?>" /><span class="input-group-addon"><i class="fa fa-clock-o"></i></span></div>
</td></td>
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
			<?php if (!$priview) { ?>
            <tr>
                <td>
                	<table>
                    	<tr>
                        	<td width="138">&nbsp;</td>
                        	<td>
                            	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_header('#fppb_');">
                                    <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;
                                </a>&nbsp;
                                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fppb_');">
                                    <i class="icon-undo"></i>&nbsp;Reset&nbsp;
                                </a>
                                <span class="msgheader_" style="margin-left:20px">&nbsp;</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			<?php }else{ ?>
            <tr>
              <td colspan="2"><h4 class="header smaller lighter green"><b>Detil Dokumen</b></h4>
                <?=$DETILPRIVIEW;?></td>
            </tr>
            <?php } ?>
        </table>
    </form>
</span>
<script>
	FormReady();
</script>