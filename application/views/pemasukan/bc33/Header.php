<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
if($act=="save"){
	if ($this->uri->segment(1) == 'pemasukan') $tipe_dok = "MASUK";
	elseif ($this->uri->segment(1) == 'pengeluaran') $tipe_dok = "KELUAR";
}else{
	$tipe_dok = $sess["TIPE_DOK"];
}
?>
<span id="DivHeaderForm">
	<form name="fbc33_" id="fbc33_" action="<?= site_url() . "/pemasukan/bc33"; ?>" method="post" autocomplete="off">
        <input type="hidden" name="act" id="act" value="<?= $act; ?>" />
        <input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"]; ?>" />
        <input type="hidden" name="HEADERDOK[NOMOR_AJU]" id="noajudok" value="<?= $aju; ?>" />
        <input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju; ?>" />
        <input type="hidden" name="HEADER[TIPE_DOK]" id="noaju" value="<?= $tipe_dok; ?>" readonly="true" />
        <input type="hidden" name="DOKUMEN" value="<?= $dokumen ?>"/> 
        <span id="divtmp"></span>
		<table width="100%" border="0">
            <tr>
            	<td width="45%" valign="top">
                    <table width="100%" border="0">
                        <tr>
                            <td width="28%">Kantor Pengawas</td>
                            <td width="71%"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text"  name="HEADER[KODE_KPBC_AWAS]" id="kode_kpbc_awas" class="stext date" value="<?= $sess['KODE_KPBC_AWAS']; ?>" url="<?= site_url() ?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc', 'kode_kpbc_awas;urkt_awas', 'Kode Kpbc', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urkt_awas"><?= $sess['URAIAN_KPBC_AWAS'] == '' ? $URKANTOR_AWAS : $sess['URAIAN_KPBC_AWAS']; ?></span> </td>
                        </tr>
                        <tr>
                            <td width="28%">Kantor Pabean Pemuatan</td>
                            <td width="71%"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text"  name="HEADER[KODE_KPBC_MUAT]" id="kode_kpbc_muat" class="stext date" value="<?= $sess['KODE_KPBC_MUAT']; ?>" url="<?= site_url() ?>/autocomplete/kpbc" urai="urkt_muat;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc', 'kode_kpbc_muat;urkt_muat', 'Kode Kpbc', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urkt_muat"><?= $sess['URAIAN_KPBC_MUAT'] == '' ? $URKANTOR_MUAT : $sess['URAIAN_KPBC_MUAT']; ?></span> </td>
                        </tr>
                        <tr>
                            <td>Jenis Ekspor</td>
                            <td><combo><?= form_dropdown('HEADER[JENIS_EKSPOR]', $jenis_ekspor, $sess['JENIS_EKSPOR'], 'id="JENIS_EKSPOR" class="mtext" wajib="yes" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Kategori Ekspor</td>
                            <td><combo><?= form_dropdown('HEADER[KATEGORI_EKSPOR]', $kategori_ekspor, $sess['KATEGORI_EKSPOR'], 'id="KATEGORI_EKSPOR" class="mtext" wajib="yes" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Cara Perdagangan</td>
                            <td><combo><?= form_dropdown('HEADER[CARA_DAGANG]', $cara_dagang, $sess['CARA_DAGANG'], 'id="CARA_DAGANG" class="mtext" wajib="yes" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Cara Pembayaran</td>
                            <td><combo><?= form_dropdown('HEADER[CARA_BAYAR]', $cara_bayar, $sess['CARA_BAYAR'], 'id="CARA_BAYAR" class="mtext" wajib="yes" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Jenis BC 3.3</td>
                            <td><combo><?= form_dropdown('HEADER[JENIS_BC33]', $jenis_bc33, $sess['JENIS_BC33'], 'id="JENIS_BC33" class="mtext" wajib="yes" ' . $disabled); ?></combo></td>
                        </tr>
                    </table>
				</td>
                <td width="55%" valign="top">
                    <table width="100%" border="0">
                        <tr>
                        	<td colspan="4" valign="top">
                                <table width="80%">
                                	<tr>
                                    	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Pendaftaran</td>
                                        <td>
                                        <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                        <input type="hidden" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6" <?= $disabled ?>/>
                                        <input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN_EDIT]" id="NOMOR_PENDAFTARAN_EDIT" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6" <?= $disabled ?>/>
                                        <?php } else { ?>
                                        <input type="text" disabled="disabled" class="stext date" maxlength="6"  value="<?= $sess['NOMOR_PENDAFTARAN']; ?>"/>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pendaftaran</td>
                                        <td>
                                        <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                        <input type="hidden" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>" <?= $disabled ?>/>
                                        <div class="input-group" style="width:3em;float:left;margin-bottom:0px">
                                        <input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN_EDIT]" id="TANGGAL_PENDAFTARAN_EDIT" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="form-control" style="width:90px" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>" <?= $disabled ?>/>
                                        <?php } else { ?>
                                        <div class="input-group" style="width:3em;float:left;margin-bottom:0px">
                                        <input type="text" disabled="disabled" class="form-control" style="width:90px" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"/>
                                        <?php } ?><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>&nbsp; YYYY-MM-DD
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>No. Persetujuan Pemasukan</td>
                                        <td>
                                        <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                        <input type="text" name="HEADERDOK[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" maxlength="30"  <?= $disabled ?>/><?php } else { ?><input type="text" disabled="disabled" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>"/><?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Persetujuan Pemasukan</td>
                                        <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> 
                                        <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                            <input type="text" name="HEADERDOK[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="form-control" style="width:90px" value="<?= ($sess['TANGGAL_DOK_PABEAN'] == '0000-00-00') ? '' : $sess['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');"/> 
                                        
                                        <?php } else { ?><input type="text" disabled="disabled" class="stext date" value="<?= ($sess['TANGGAL_DOK_PABEAN'] == '0000-00-00') ? '' : $sess['TANGGAL_DOK_PABEAN']; ?>"/><?php } ?><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>&nbsp; YYYY-MM-DD
                                        </td>
                                    </tr>
                                </table>
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
                            <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>EKSPORTIR TPB</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td width="28%">Identitas </td>
                            <td  width="71%">
                            <combo><?= form_dropdown('HEADER[KODE_ID_TRADER]', $kode_id, $sess['KODE_ID_TRADER'], 'id="kode_id_trader" class="sstext" ' . $disabled); ?></combo>
                            <input type="hidden" name="HEADER[KODE_TRADER]" id="KODE_TRADER" value="<?= $sess['KODE_TRADER']; ?>" class="stext" wajib="yes" maxlength="15"  <?= $disabled ?>/>
                            <input type="text" name="HEADER[ID_TRADER]" id="ID_TRADER" value="<?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?>" class="ltext" wajib="yes" maxlength="15"  <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td class="top">Nama </td>
                            <td><input type="text" name="HEADER[NAMA_TRADER]" id="NAMA_TRADER" value="<?= $sess['NAMA_TRADER']; ?>" class="mtext" wajib="yes" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat </td>
                            <td>
                                <textarea name="HEADER[ALAMAT_TRADER]" id="ALAMAT_TRADER" class="mtext" wajib="yes"  onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')"  <?= $disabled ?>><?= $sess['ALAMAT_TRADER']; ?></textarea>
                                <div id="limitAlamatTrader"></div>
                        	</td>
                        </tr>
                        <tr>
                            <td class="top">NIPER </td>
                            <td><input type="text" name="HEADER[NIPER]" id="NIPER" value="<?= $sess['NIPER']; ?>" maxlength="4" class="mtext"  <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td class="top">Status </td>
                            <td><combo><?= form_dropdown('HEADER[STATUS_TRADER]', $status, $sess['STATUS_TRADER'], 'id="status" class="mtext" wajib="yes" ' . $disabled, FALSE); ?></combo></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                                <h5 class="smaller lighter blue"><b>PEMILIK BARANG</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td width="28%">Identitas </td>
                            <td  width="71%">
                            <combo><?= form_dropdown('HEADER[KODE_ID_PEMILIK]', $kode_id, $sess['KODE_ID_PEMILIK'], 'id="kode_id_pemilik" class="sstext" ' . $disabled); ?></combo>
                            <input type="text" name="HEADER[ID_PEMILIK]" id="ID_PEMILIK" value="<?= $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']); ?>" class="ltext" wajib="yes" maxlength="15"  <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td class="top">Nama </td>
                            <td><input type="text" name="HEADER[NAMA_PEMILIK]" id="NAMA_PEMILIK" value="<?= $sess['NAMA_PEMILIK']; ?>" class="mtext" wajib="yes" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat </td>
                            <td>
                                <textarea name="HEADER[ALAMAT_PEMILIK]" id="ALAMAT_PEMILIK" class="mtext" wajib="yes"  onkeyup="limitChars(this.id, 70, 'limitAlamatPemiliki')"  <?= $disabled ?>><?= $sess['ALAMAT_PEMILIK']; ?></textarea>
                                <div id="limitAlamatPemiliki"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="top">NIPER </td>
                            <td><input type="text" name="HEADER[NIPER_PEMILIK]" id="NIPER_PEMILIK" value="<?= $sess['NIPER_PEMILIK']; ?>" maxlength="4" class="mtext"  <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td class="top">Status </td>
                            <td><combo><?= form_dropdown('HEADER[STATUS_PEMILIK]', $status, $sess['STATUS_PEMILIK'], 'id="status_pemilik" class="mtext" wajib="yes" ' . $disabled, FALSE); ?></combo></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                                <h5 class="smaller lighter blue"><b>DATA PENERIMA</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td width="26%">Nama</td>
                            <td width="74%"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[NAMA_PENERIMA]" id="NAMA_PENERIMA" value="<?= $sess['NAMA_PENERIMA']; ?>" class="mtext" maxlength="15" wajib="yes" <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pembeli', 'NAMA_PENERIMA;ALAMAT_PENERIMA;NEGARA_PENERIMA', 'penerima', 'fbc33_', 600, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                                <textarea name="HEADER[ALAMAT_PENERIMA]" id="ALAMAT_PENERIMA" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPenerima')"  <?= $disabled ?>><?= $sess['ALAMAT_PENERIMA']; ?></textarea>
                                <div id="limitAlamatPenerima"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Negara</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[NEGARA_PENERIMA]" id="NEGARA_PENERIMA" value="<?= $sess['NEGARA_PENERIMA']; ?>" class="stext date" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" wajib="yes" urai="negPenerima;"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara', 'NEGARA_PENERIMA;negPenerima', 'Kode Negara', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="negPenerima"><?= $sess['URAIAN_BENDERA'] == '' ? $URAIAN_BENDERA : $sess['URAIAN_BENDERA']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                                <h5 class="smaller lighter blue"><b>DATA PEMBELI</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td width="26%">Nama</td>
                            <td width="74%"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[NAMA_PEMBELI]" id="NAMA_PEMBELI" value="<?= $sess['NAMA_PEMBELI']; ?>" class="mtext" maxlength="15" wajib="yes" <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pembeli', 'NAMA_PEMBELI;ALAMAT_PEMBELI;NEGARA_PEMBELI', 'penerima', 'fbc33_', 600, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                                <textarea name="HEADER[ALAMAT_PEMBELI]" id="ALAMAT_PEMBELI" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPembeli')"  <?= $disabled ?>><?= $sess['ALAMAT_PEMBELI']; ?></textarea>
                                <div id="limitAlamatPembeli"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Negara</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[NEGARA_PEMBELI]" id="NEGARA_PEMBELI" value="<?= $sess['NEGARA_PEMBELI']; ?>" class="stext date" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" wajib="yes" urai="negPembeli;"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara', 'NEGARA_PEMBELI;negPembeli', 'Kode Negara', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="negPembeli"><?= $sess['URAIAN_BENDERA_PEMBELI'] == '' ? $URAIAN_BENDERA : $sess['URAIAN_BENDERA_PEMBELI']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                                <h5 class="smaller lighter blue"><b>DATA PENGANGKUTAN</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="top">Cara Pengangkutan</td>
                            <td><combo><?= form_dropdown('HEADER[MODA]', $cara_angkut, $sess['MODA'], 'id="status" class="mtext" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Nama Angkut </td>
                            <td><input type="text" name="HEADER[NAMA_ANGKUT]" id="nama_angkut" value="<?= $sess['NAMA_ANGKUT']; ?>"  maxlength="20" class="mtext" wajib="yes" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td>Nomor Pengangkut </td>
                            <td><input type="text" name="HEADER[NOMOR_ANGKUT]" id="nomor_angkut" value="<?= $sess['NOMOR_ANGKUT']; ?>" class="stext date" maxlength="7" wajib="yes" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td class="top">Tanggal Perkiraan Pemuatan</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> 
                                     <input type="text" name="HEADER[TANGGAL_MUAT]" id="TANGGAL_MUAT" value="<?= $sess['TANGGAL_MUAT']; ?>" maxlength="20" class="form-control" style="width:90px" wajib="yes" onfocus="ShowDP('TANGGAL_MUAT');" <?= $disabled ?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>&nbsp; YYYY-MM-DD</td>
                        </tr>
					</table>
				</td>
				<td width="55%" valign="top">
                    <table width="100%" border="0">
                        <tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>DATA TRANSAKSI EKSPOR</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Bank Devisa Hasil Ekspor</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[KODE_BANK]" id="kd_bank" value="<?= $sess['KODE_BANK']; ?>" url="<?= site_url(); ?>/autocomplete/bank" onfocus="Autocomp(this.id)" urai="urbank;" class="stext date" wajib="yes"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('bank', 'kd_bank;urbank', 'Kode Bank', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urbank"><?= $sess['URAIAN_BANK']?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Jenis Valuta Asing</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[KODE_VALUTA]" id="valuta" value="<?= $sess['KODE_VALUTA']; ?>" url="<?= site_url(); ?>/autocomplete/valuta" onfocus="Autocomp(this.id)" urai="urvaluta;" class="stext date" wajib="yes"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('valuta', 'valuta;urvaluta', 'Kode Valuta', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urvaluta"><?= $sess['URAIAN_VALUTA'] == '' ? $urvaluta : $sess['URAIAN_VALUTA']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Nilai Kurs</td>
                            <td>
                                <input type="text" name="KURS_UR" id="KURS_UR" value="<?= $this->fungsi->FormatRupiah($sess['NDPBM'], 4); ?>" class="mtext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('NDPBM', this.value, 4);" <?= $disabled ?>/>
                                <input type="hidden" name="HEADER[NDPBM]" id="NDPBM" value="<?= $sess['NDPBM']; ?>" class="mtext" wajib="yes" format="angka" <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Nilai Barang</td>
                            <td>
                                <input type="text" name="NIALI_BARANG_UR" id="NIALI_BARANG_UR" value="<?= $this->fungsi->FormatRupiah($sess['NILAI_BARANG'], 4); ?>" class="mtext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('NILAI_BARANG', this.value, 4);" <?= $disabled ?>/>
                                <input type="hidden" name="HEADER[NILAI_BARANG]" id="NILAI_BARANG" value="<?= $sess['NILAI_BARANG']; ?>" class="mtext" wajib="yes" format="angka" <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">FOB</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="FOB_CONV" id="FOB_CONV" value="<?= $this->fungsi->FormatRupiah($sess['FOB'], 4); ?>" class="stext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('FOB', this.value, 4);" <?= $disabled ?>/>
                                <input type="hidden" name="HEADER[FOB]" id="FOB" value="<?= $sess['FOB']; ?>" class="text" wajib="yes" format="angka"<?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Nilai Maklon</td>
                            <td>
                                <input type="text" name="NILAI_MAKLON_UR" id="NILAI_MAKLON_UR" value="<?= $this->fungsi->FormatRupiah($sess['NILAI_MAKLON'], 4); ?>" class="mtext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('NILAI_MAKLON', this.value, 4);" <?= $disabled ?>/>
                                <input type="hidden" name="HEADER[NILAI_MAKLON]" id="NILAI_MAKLON" value="<?= $sess['NILAI_MAKLON']; ?>" class="mtext" wajib="yes" format="angka" <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>DATA BARANG</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Berat Kotor (Kg) </td>
                            <td>
                                <input type="text" name="BRUT" id="BRUT" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'], 4); ?>" onkeyup="this.value = ThausandSeperator('BRUTO', this.value, 4);" class="mtext" format="angka" wajib="yes"  <?= $disabled ?>><input type="hidden" name="HEADER[BRUTO]" id="BRUTO" class="text" value="<?= $sess['BRUTO']; ?>" maxlength="18" <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Berat Bersih (Kg) </td>
                            <td>
                            	<span id="NETT"><?= $this->fungsi->FormatRupiah($sess['NETTO'], 4); ?></span><input type="hidden" name="HEADER[NETTO]" id="NETTO" class="text" value="<?= $sess['NETTO']; ?>" maxlength="18" <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                                <h5 class="smaller lighter blue"><b>PUSAT LOGISTIK BERIKAT</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td width="26%">Nama PLB</td>
                            <td width="74%"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="HEADER[NAMA_PLB]" id="NAMA_PLB" value="<?= $sess['NAMA_PLB']; ?>" class="mtext" maxlength="15" wajib="yes" <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td width="26%">Lokasi / Kode Lokasi</td>
                            <td width="74%"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="HEADER[KODE_LOKASI_PLB]" id="KODE_LOKASI_PLB" value="<?= $sess['KODE_LOKASI_PLB']; ?>" class="mtext" maxlength="15" wajib="yes" <?= $disabled ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td width="26%">Cara Pengangkutan ke PLB</td>
                            <td width="74%">
                                <combo><?= form_dropdown('HEADER[CARA_PENGANGKUTAN_PLB]', $cara_angkut, $sess['CARA_PENGANGKUTAN_PLB'], 'id="status" class="mtext" ' . $disabled); ?></combo>
                            </td>
                        </tr>
                        <tr>
                            <td width="26%">Perkiraan Tanggal Pemasukan/Pengeluaran</td>
                            <td width="74%"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                            <input type="text" name="HEADER[PERKIRAAN_INOUT_PLB]" id="PERKIRAAN_INOUT_PLB" value="<?= $sess['PERKIRAAN_INOUT_PLB']; ?>" maxlength="20" class="form-control" style="width:90px" wajib="yes" onfocus="ShowDP('PERKIRAAN_INOUT_PLB');" <?= $disabled ?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                                <h5 class="smaller lighter blue"><b>DATA PENYERAHAN</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Daerah Asal Barang</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="HEADER[PROPINSI_BARANG]" id="PROPINSI_BARANG" value="<?= $sess['PROPINSI_BARANG']; ?>" class="stext date" url="<?= site_url(); ?>/autocomplete/daerah" onfocus="Autocomp(this.id)" wajib="yes" urai="urdaerah;"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('daerah', 'PROPINSI_BARANG;urdaerah', 'Kode Daerah', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urdaerah"><?= $sess['URAIAN_DAERAH_ASL'] == '' ? $URAIAN_DAERAH : $sess['URAIAN_DAERAH_ASL']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Cara Penyerahan Barang</td>
                            <td><combo><?= form_dropdown('HEADER[CARA_PENYERAHAN_BARANG]', $cara_penyerahan, $sess['CARA_PENYERAHAN_BARANG'], 'id="CARA_PENYERAHAN_BARANG" class="mtext" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>DATA PELABUHAN</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Pelabuhan Muat</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[PELABUHAN_MUAT]" id="PELABUHAN_MUAT" value="<?= $sess['PELABUHAN_MUAT']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan/dalam" onfocus="Autocomp(this.id)" urai="urpelabuhan_muat;" class="stext date" wajib="yes"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan', 'PELABUHAN_MUAT;urpelabuhan_muat', 'Kode Pelabuhan', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_muat"><?= $sess['URAIAN_MUAT'] == '' ? $urpelabuhan_muat : $sess['URAIAN_MUAT']; ?></span></td>
                        </tr>
                        <tr>
                            <td>Pelabuhan Bongkar</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[PELABUHAN_BONGKAR]" id="PELABUHAN_BONGKAR" value="<?= $sess['PELABUHAN_BONGKAR']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_bongkar;" class="stext date" wajib="yes"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan', 'PELABUHAN_BONGKAR;urpelabuhan_bongkar', 'Kode Pelabuhan', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_bongkar"><?= $sess['URAIAN_BONGKAR'] == '' ? $urpelabuhan_bongkar : $sess['URAIAN_BONGKAR']; ?></span></td>
                        </tr>
                        <tr>
                            <td>Pelabuhan Tujuan</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[PELABUHAN_TUJUAN]" id="PELABUHAN_TUJUAN" value="<?= $sess['PELABUHAN_TUJUAN']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_tujuan;" class="stext date" wajib="yes"  <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan', 'PELABUHAN_TUJUAN;urpelabuhan_tujuan', 'Kode Pelabuhan', 'fbc33_', 650, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_tujuan"><?= $sess['URAIAN_TUJUAN'] == '' ? $urpelabuhan_tujuan : $sess['URAIAN_TUJUAN']; ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                            	<h5 class="smaller lighter blue"><b>DATA KEMASAN</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Merk Kemasan </td>
                            <td>
                            	<input type="text" name="HEADER[MERK_KEMASAN]" id="MERK_KEMASAN" value="<?= $sess['MERK_KEMASAN']; ?>" class="mtext"  <?= $disabled ?>>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight">
                            <h5 class="smaller lighter blue"><b>TANDA TANGAN PENGUSAHA EKSPORTIR</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="HEADER[NAMA_TTD]" id="NAMA_TTD" value="<?= $sess['NAMA_TTD']; ?>" class="mtext"  <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td><input type="text" name="HEADER[KOTA_TTD]" id="KOTA_TTD" value="<?= $sess['KOTA_TTD']; ?>" class="mtext"  <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> 
                                    <input type="text" name="HEADER[TANGGAL_TTD]" id="TANGGAL_TTD" value="<?= $sess['TANGGAL_TTD'] ? $sess['TANGGAL_TTD'] : date('Y-m-d'); ?>"  onFocus="ShowDP('TANGGAL_TTD')" class="form-control" style="width:90px" <?= $disabled ?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                 </div>&nbsp; YYYY-MM-DD
                        	</td>
                        </tr>
					</table>
				</td>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <?php if (!$priview) { ?>
            <tr>
            	<td width="45%">
                	<table width="100%">
                    	<tr>
                        	<td  width="28%">&nbsp;</td>
                            <td  width="72%">
                            	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_header('#fbc33_');change_merk();">
                                    <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>
                                </a>
                                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbc33_');">
                                    <i class="icon-undo"></i>&nbsp;Reset
                                </a>
                                <span class="msgheader_" style="margin-left:20px">&nbsp;</span>
                            </td>
                        </tr>
                    </table>
            	</td>
                <td>&nbsp;</td>
            </tr>
            <?php } ?> 
     	</table>
	</form>
</span>
<?php
if ($priview) {
echo '<h4 class="header smaller lighter green"><b>Detil Dokumen</b></h4>'.$DETILPRIVIEW;
}
?>

