<span id="DivHeaderForm">
    <?php
    if (!defined('BASEPATH'))  exit('No direct script access allowed');
    error_reporting(E_ERROR);
    if ($act == 'update')  $readonly = "readonly=readonly";
    else $readonly = "";

    if ($this->uri->segment(1) == 'pemasukan') $tipe_dok_bc27 = "MASUK";
    elseif ($this->uri->segment(1) == 'pengeluaran') $tipe_dok_bc27 = "KELUAR";
	elseif ($this->uri->segment(1) == 'tools') $tipe_dok_bc27 = $sess["TIPE_DOK"];

    if ($act == "save" && $this->uri->segment(1) == 'pengeluaran') {
        $sess['KODE_ID_TRADER_TUJUAN'] = $partner["KODE_ID_PARTNER"];
        $sess['ID_TRADER_TUJUAN'] = $partner["ID_PARTNER"];
        $sess['NAMA_TRADER_TUJUAN'] = $partner["NAMA_PARTNER"];
        $sess['ALAMAT_TRADER_TUJUAN'] = $partner["ALAMAT_PARTNER"];
    }
    ?>	
    <form id="fbc27_" name="fbc27_" action="<?= site_url() . "/pemasukan/bc27"; ?>" method="post" autocomplete="off">
        <input type="hidden" name="act" id="act" value="<?= $act; ?>" />
        <input type="hidden" name="HEADER[TIPE_DOK]" id="TIPE_DOK" value="<?= $tipe_dok_bc27; ?>" />
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
                    	<?php if ($act == "save") { ?>
                        <tr>
                        	<td width="109">Nomor Aju</td>
                            <td width="327">
                            	<input type="text" maxlength="26" class="mtext" name="NOMOR_AJU" id="noajuIn" onkeyup="this.value=this.value.replace(/[^\d]/,'')" aju="isi" format="angka" value="<?= $aju; ?>" <?= $readonly; ?>  />
                            </td>
                      	</tr>
                        <?php }else{ ?>
                        <tr>
                        	<td>Nomor Aju</td>
                            <td><?=$this->fungsi->FormatAju($sess["NOMOR_AJU"])?></td>
                        </tr>
                        <?php } ?> 
                        <tr>
                            <td width="109">Kantor Asal</td>
                            <td width="327"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text"  name="HEADER[KODE_KPBC_ASAL]" id="kode_kpbc" class="stext date" value="<?= $sess['KODE_KPBC_ASAL']; ?>" url="<?= site_url() ?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc', 'kode_kpbc;urkt', 'Kode Kpbc', 'fbc27_', 650, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urkt"><?= $sess['URAIAN_KPBC'] == '' ? $URKANTOR_TUJUAN : $sess['URAIAN_KPBC']; ?></span> </td>
                        </tr>
                        <tr>
                            <td width="109">Kantor Tujuan</td>
                            <td width="327"><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text"  name="HEADER[KODE_KPBC_TUJUAN]" id="kode_kpbc_bongkar" class="stext date" value="<?= $sess['KODE_KPBC_TUJUAN']; ?>" url="<?= site_url() ?>/autocomplete/kpbc" urai="urktbongkar;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc', 'kode_kpbc_bongkar;urktbongkar', 'Kode Kpbc', 'fbc27_', 650, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div> &nbsp; <span id="urktbongkar"><?= $sess['URAIAN_KPBC_BONGKAR'] == '' ? $URKANTOR_TUJUAN : $sess['URAIAN_KPBC_BONGKAR']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis TPB ASAL</td>
                            <td><combo><?= form_dropdown('HEADER[JENIS_TPB_ASAL]', $tpb_asal, $sess['JENIS_TPB_ASAL'], 'id="tempat_asal" class="mtext" wajib="yes" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Jenis TPB TUJUAN</td>
                            <td><combo><?= form_dropdown('HEADER[JENIS_TPB_TUJUAN]', $tpb_asal, $sess['JENIS_TPB_TUJUAN'], 'id="tempat_tujuan" class="mtext" wajib="yes" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td>Tujuan Pengiriman</td>
                            <td><combo><?= form_dropdown('HEADER[TUJUAN_KIRIM]', $tujuan_kirim, $sess['TUJUAN_KIRIM'], 'id="tujuan_kirim" class="mtext" wajib="yes" value="<?= $tujuan_kirim; ?>"  ' . $disabled); ?></combo></td>
                        </tr>
                    </table>
                </td>
                <td width="55%" valign="top">
                    <table width="80%">
                    	<tr>
                        	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                        </tr>
                        <tr>
                            <td>Nomor Pendaftaran</td>
                            <td>
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
                            <td>
                            <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                <input type="hidden" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>" <?= $disabled ?>/>
                                <input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN_EDIT]" id="TANGGAL_PENDAFTARAN_EDIT" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"  <?=$disabled?> />
                            <?php } else { ?>
                                <input type="text" disabled="disabled" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"/>
                            <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Persetujuan Pemasukan</td>
                            <td>
                                <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                    <input type="text" name="HEADERDOK[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="mtext" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" maxlength="30"  <?= $disabled ?>/><?php } else { ?><input type="text" disabled="disabled" class="mtext" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" /><?php } ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Persetujuan Pemasukan</td>
                            <td>
                                <?php if ($sess['STATUS_DOK'] == "LENGKAP") { ?>
                                    <input type="text" name="HEADERDOK[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="stext date" value="<?= ($sess['TANGGAL_DOK_PABEAN'] == '0000-00-00') ? '' : $sess['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');" <?= $disabled ?>/>
                                <?php } else { ?><input type="text" disabled="disabled" class="stext date" value="<?= ($sess['TANGGAL_DOK_PABEAN'] == '0000-00-00') ? '' : $sess['TANGGAL_DOK_PABEAN']; ?>" /><?php } ?>
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
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>TPB ASAL BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td>
                                <combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_TRADER_ASAL]', $kode_id, $sess['KODE_ID_TRADER_ASAL'], 'id="kode_trader_asal" class="sstext" ' . $disabled); ?></combo> 
                                <input type="hidden" name="HEADER[KODE_TRADER]" id="kode_trader" value="<?= $sess['KODE_TRADER']; ?>" class="stext date" size="20" maxlength="15" <?= $disabled ?>/>
                                <div class="input-group" style="width:3em; margin-bottom:0px">
                                    <input type="text" name="HEADER[ID_TRADER_ASAL]" id="id_trader" value="<?php if ($this->uri->segment(1) == 'pemasukan') echo $sess['ID_TRADER_ASAL'];
                                       else echo $this->fungsi->FORMATNPWP($sess['ID_TRADER_ASAL']); ?>" url="<?= site_url() ?>/autocomplete/trader" urai="nama_trader;alamat_trader;" wajib="yes" class="ltext" maxlength="20" <?= $disabled ?>/>
                                <?php if ($this->uri->segment(1) == 'pemasukan') { ?>
                                    <span class="input-group-btn">
                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pemasok', 'kode_trader_asal;id_trader;nama_trader;alamat_trader', 'Asal Barang', 'fbc27_', 600, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                   

<?php } ?>                       </div>
                            </td>
                        </tr> 
                        <tr>
                            <td class="top">Nama </td>
                            <td><input type="text" name="HEADER[NAMA_TRADER_ASAL]" id="nama_trader" value="<?= $sess['NAMA_TRADER_ASAL']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" class="mtext" wajib="yes" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat </td>
                            <td><textarea name="HEADER[ALAMAT_TRADER_ASAL]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTraderAs')" <?= $disabled ?>><?= $sess['ALAMAT_TRADER_ASAL']; ?></textarea>
                                <div id="limitAlamatTraderAs"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="top">No Ijin TPB </td>
                            <td>
                                <input type="text" name="HEADER[NOMOR_IZIN_TPB_ASAL]" id="registrasi" value="<?php if ($this->uri->segment(1) == 'pemasukan') {
                                    echo $sess['NOMOR_IZIN_TPB_ASAL'];
                                } else {
                                    echo $sess['NOMOR_IZIN_TPB_ASAL'] ? $sess['NOMOR_IZIN_TPB_ASAL'] : $sess['NOMOR_SKEP'];
                                } ?>" maxlength="30" class="mtext" wajib="yes" <?= $disabled ?>/>
                        	</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>RIWAYAT BARANG</b></h5></td>
                        </tr>
        				<tr>
          					<td colspan="2">
          						<fieldset style="width:81%">
              						<table width="100%" border="0" id="TBLASAL">
              							<tbody>
              								<? if($act=="update"){ echo $dataasal; ?>         	
              								<? }else{ ?>
                                          	<tr id="trnomor">
                                                <td width="29%">Nomor BC27 Asal</td>
                                                <td width="71%" id="tdnomor">
                                                	<div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                                     <input type="text" name="ASAL[NOMOR_DAFTAR][]" id="NOMOR_DAFTAR" value="<?= $sess['NOMOR_DAFTAR']; ?>"  maxlength="8" class="text" />
                                                    <span class="input-group-btn">
                                                        <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('BC27ASAL','NOMOR_DAFTAR;TANGGAL_DAFTAR','Dokumen BC 2.7 Asal','fbc27_',650,470,'TIPE_DOK;')" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                                    </div>
                                                </td>
                                          	</tr>
                                         	<tr id="trtanggal">
                                            	<td width="29%">Tanggal BC27 Asal</td>
                                            	<td width="71%" id="tdtanggal"><div class="input-group" style="width:3em;float:left;margin-bottom:0px"> 
                                                <input type="text" name="ASAL[TANGGAL_DAFTAR][]" id="TANGGAL_DAFTAR" maxlength="10" onFocus="ShowDP(this.id);" class="form-control" style="width:100px" value="<?= $sess['TANGGAL_BC261']; ?>" />
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>&nbsp;&nbsp;YYYY-MM-DD</td>
                                          	</tr>
                                          <? } ?>
              							</tbody>
              						</table>
              						<input type="button" name="Tambah" id="Tambah" class="btn btn-success btn-sm" onclick="tambahasal()" value="Tambah" />
              					</fieldset>
          					</td>
          				</tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGANGKUT</b></h5></td>
                        </tr>
                        <tr>
                            <td>Jenis Angkutan Darat </td>
                            <td><input type="text" name="HEADER[JENIS_SARANA_ANGKUT]" id="JENIS_SARANA_ANGKUT" value="<?= $sess['JENIS_SARANA_ANGKUT']; ?>"  maxlength="20"class="mtext"  <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td>Nomor Polisi </td>
                            <td><input type="text" name="HEADER[NOMOR_POLISI]" id="nomor_angkut" value="<?= $sess['NOMOR_POLISI']; ?>" class="mtext" maxlength="10" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td width="139">Volume (m3) </td>
                            <td>
                                <input type="text" name="VOLUM" id="VOLUM" value="<?= $this->fungsi->FormatRupiah($sess['VOLUME'], 4); ?>" class="mtext" wajib="yes" onkeyup="this.value = ThausandSeperator('VOLUME', this.value, 4);" <?= $disabled ?>/>
                                <input type="hidden" name="HEADER[VOLUME]" id="VOLUME" value="<?= $sess['VOLUME'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Berat Kotor (Kg) </td>
                            <td><input type="text" name="BRT" id="BRT" onkeyup="this.value = ThausandSeperator('BRUTO', this.value, 4);" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'], 4); ?>" class="mtext" wajib="yes" <?= $disabled ?>/>
                                <input type="hidden" name="HEADER[BRUTO]" id="BRUTO" value="<?= $sess['BRUTO'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="139">Berat Bersih (Kg) </td>
                            <td><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'], 2); ?>&nbsp; Kilogram (KGM)<input type="hidden" name="HEADER[NETTO]" value="<?= $sess['JUM_NETTO']; ?>" class="text"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Otomatis terisi dari jumlah total Netto Detil Barang</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td width="55%" valign="top">
                    <table width="100%" border="0"> 
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>TPB TUJUAN BARANG</b></h5></td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td><combo style="float:left;margin-right:3px"><?= form_dropdown('HEADER[KODE_ID_TRADER_TUJUAN]', $kode_id, $sess['KODE_ID_TRADER_TUJUAN'], 'id="KODE_ID_TRADER_TUJUAN" class="sstext"  ' . $disabled); ?> </combo>
                                <div class="input-group" style="width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[ID_TRADER_TUJUAN]" id="ID_TRADER_TUJUAN" value="<?php
                                       if ($sess['ID_TRADER_TUJUAN'] == 5) {
                                           echo $this->fungsi->FORMATNPWP($sess['ID_TRADER_TUJUAN']);
                                       } else {
                                           echo $sess['ID_TRADER_TUJUAN'];
                                       }
?>" class="ltext" size="20" wajib="yes" maxlength="20" <?= $disabled ?>/>
<?php if ($this->uri->segment(1) != 'pemasukan') { ?>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pemasok', 'KODE_ID_TRADER_TUJUAN;ID_TRADER_TUJUAN;NAMA_TRADER_TUJUAN;ALAMAT_TRADER_TUJUAN', 'penerima', 'fbc27_', 600, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
<?php } ?>                       </div>
                            </td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="HEADER[NAMA_TRADER_TUJUAN]" id="NAMA_TRADER_TUJUAN" value="<?= $sess['NAMA_TRADER_TUJUAN']; ?>" class="mtext" maxlength="50" url="<?= site_url() ?>/autocomplete/pemasok" urai="ALAMAT_TRADER_TUJUAN;" onfocus="Autocomp(this.id)" wajib="yes" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat</td>
                            <td><textarea name="HEADER[ALAMAT_TRADER_TUJUAN]" id="ALAMAT_TRADER_TUJUAN" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTraderTuj')" <?= $disabled ?>><?= $sess['ALAMAT_TRADER_TUJUAN']; ?></textarea>
                                <div id="limitAlamatTraderTuj"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="top">No Izin TPB</td>
                            <td>
                            	<input type="text" name="HEADER[NOMOR_IZIN_TPB_TUJUAN]" id="registrasi_partner" class="mtext" wajib="yes" maxlength="20" value="<?php if ($this->uri->segment(1) == 'pemasukan') {
									echo $sess['NOMOR_IZIN_TPB_TUJUAN'] ? $sess['NOMOR_IZIN_TPB_TUJUAN'] : $sess['NOMOR_SKEP'];
								} else {
									echo $sess['NOMOR_IZIN_TPB_TUJUAN'];
								} ?>" <?= $disabled ?>>
                           	</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5></td>
                        </tr>
                        <tr>
                            <td width="139">Jenis Valuta Asing </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="HEADER[KODE_VALUTA]" id="kode_valuta" value="<?= $sess['KODE_VALUTA']; ?>" class="stext date" url="<?= site_url() ?>/autocomplete/valuta" urai="urval;" wajib="yes" onfocus="Autocomp(this.id)" <?= $disabled ?>/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('valuta', 'kode_valuta;urval', 'Kode Valuta', 'fbc27_', 650, 470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                                <span id="urval"><?= $sess['URAIAN_VALUTA'] == '' ? $URAIAN_VALUTA : $sess['URAIAN_VALUTA']; ?></span> </td>
                        </tr>
                        <tr>
                            <td width="139">CIF <span id="cifkurs"><?= $sess['KODE_VALUTA'] == '' ? '' : '(' . $sess['KODE_VALUTA'] . ')'; ?></span></td>
                            <td><input type="text" name="CIF_TARIF" id="cifTarif" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['CIF']); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('cif', this.value, 4);" <?= $disabled ?>/> 
                                <input type="hidden" name="HEADER[CIF]" id="cif" value="<?= $sess['CIF'] ?>" /></td>
                        </tr>
                        <tr>
                            <td width="139">Harga Penyerahan (Rp) </td>
                            <td><input type="text" name="HARGA" id="harga" class="mtext" value="<?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN']); ?>" maxlength="30"  onkeyup="this.value = ThausandSeperator('harga_penyerahan', this.value, 4);" wajib="yes" <?= $disabled ?>/>
                                <input type="hidden" name="HEADER[HARGA_PENYERAHAN]" id="harga_penyerahan" value="<?= $sess['HARGA_PENYERAHAN'] ?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>SEGEL</b><i class="red"> (Diisi Oleh Bea dan Cukai)</i></h5></td>
                        </tr>
                        <tr>
                            <td>No. Segel</td>
                            <td><input type="text" name="HEADER[NOMOR_SEGEL_BC]" id="NOMOR_SEGEL_BC" value="<?= $sess['NOMOR_SEGEL_BC']; ?>" class="mtext" <?= $disabled ?>/></td>
                        </tr>
                        <tr>
                            <td>Jenis</td>
                            <td><combo><?= form_dropdown('HEADER[JENIS_SEGEL_BC]', $jenis_segel, $sess['JENIS_SEGEL_BC'], 'id="JENIS_SEGEL_BC" class="mtext" ' . $disabled); ?></combo></td>
                        </tr>
                        <tr>
                            <td valign="top">Catatan BC Tujuan</td>
                            <td><textarea name="HEADER[CATATAN_BC_TUJUAN]" id="CATATAN_BC_TUJUAN" class="mtext"  <?= $disabled ?>><?= $sess['CATATAN_BC_TUJUAN']; ?></textarea></td>
                        </tr>

                    </table>
                </td> 
            <tr>
                <td colspan="2">
                    <h5 class="header smaller lighter green"><b>TANDA TANGAN PENGUSAHA TPB</b></h5>
                    <table width="100%" border="0">
                        <tr>
                            <td width="45%" valign="top">		
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="139">Nama</td>
                                        <td><input type="text" name="HEADER[NAMA_TTD]" id="nama_ttd" value="<?= $sess['NAMA_TTD']; ?>" class="mtext" wajib="yes" <?= $disabled ?>/></td>
                                    </tr>
                                    <tr>
                                        <td width="139">Tempat</td>
                                        <td><input type="text" name="HEADER[KOTA_TTD]" id="tempat_ttd" value="<?= $sess['KOTA_TTD']; ?>" class="mtext" wajib="yes" <?= $disabled ?>/></td>
                                    </tr>
                                    <tr>
                                        <td width="139">Tanggal</td>
                                        <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px">
                                        	<input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" value="<?php if ($act == "save") echo date("Y-m-d");else echo $sess['TANGGAL_TTD'];?>"  wajib="yes" onFocus="ShowDP('tanggal_ttd')" class="form-control" style="width:100px" <?= $disabled ?>/>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp; YYYY-MM-DD
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
                    <h5 class="header smaller lighter green"><b>UNTUK BEA DAN CUKAI</b></h5>
                    <table width="100%" border="0">
                        <tr>
                            <td width="37%" valign="top">		
                                <table width="100%" border="0">
                                    <tr>
                                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>Kantor Pabean Asal</b></h5></td>
                                    </tr>
                                    <tr>
                                        <td width="139">Nama</td>
                                        <td><input type="text" name="HEADER[NAMA_PEJABAT_BC_ASAL]" id="NAMA_PEJABAT_BC_ASAL" value="<?= $sess['NAMA_PEJABAT_BC_ASAL']; ?>" class="mtext"  <?= $disabled ?>/></td>
                                    </tr>
                                    <tr>
                                        <td width="139">NIP</td>
                                        <td><input type="text" name="HEADER[NIP_PEJABAT_BC_ASAL]" id="NIP_PEJABAT_BC_ASAL" value="<?= $sess['NIP_PEJABAT_BC_ASAL']; ?>" class="mtext"  <?= $disabled ?>/></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="45%" valign="top">		
                                <table width="100%" border="0">
                                    <tr>
                                        <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>Kantor Pabean Tujuan</b></h5></td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Nama</td>
                                        <td><input type="text" name="HEADER[NAMA_PEJABAT_BC_TUJUAN]" id="NAMA_PEJABAT_BC_TUJUAN" value="<?= $sess['NAMA_PEJABAT_BC_TUJUAN']; ?>" class="mtext" <?= $disabled ?> /></td>
                                    </tr>
                                    <tr>
                                        <td>NIP</td>
                                        <td><input type="text" name="HEADER[NIP_PEJABAT_BC_TUJUAN]" id="NIP_PEJABAT_BC_TUJUAN" value="<?= $sess['NIP_PEJABAT_BC_TUJUAN']; ?>" class="mtext"  <?= $disabled ?>/></td>
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
                            	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_header('#fbc27_');">
                                    <i class="icon-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;
                                </a>&nbsp;
                                <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbc27_');">
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
    $('#kode_valuta').bind('focus keyup', function() {
        $("#cifkurs").html('(' + $(this).val() + ')');
    });

	function tambahasal(){
		var rand = GetRandomMath();		
		var html = '<tr id="trnomor'+rand+'"><td>Nomor BC27 Asal</td><td><div class="input-group" style="float:left; width:3em; margin-bottom:0px"><input type="text" name="ASAL[NOMOR_DAFTAR][]" id="NOMOR_DAFTAR'+rand+'" maxlength="8" class="text"/><span class="input-group-btn"><a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search(\'BC27ASAL\',\'NOMOR_DAFTAR'+rand+';TANGGAL_DAFTAR'+rand+'\',\'Dokumen BC 2.7 Asal\',\'fbc27_\',650,470,\'TIPE_DOK;\')"><i class="fa fa-ellipsis-h"></i></a></span></div></td></tr><tr id="trtanggal'+rand+'"><td>Tanggal BC27 Asal</td><td><div class="input-group" style="width:3em;float:left"> <input type="text" name="ASAL[TANGGAL_DAFTAR][]" id="TANGGAL_DAFTAR'+rand+'" maxlength="10" onFocus="ShowDP(this.id);" class="form-control" style="width:100px" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;&nbsp;YYYY-MM-DD&nbsp;<a href="javascript:void(0)" onClick="hapusasal('+rand+')" title="Hapus">&nbsp;&nbsp;<i class="fa fa-times red" style="font-size:18px"></i></a></td></tr>';	
		$("#TBLASAL tbody:last").append(html);
	}
	function hapusasal(id){ 
		$("#TBLASAL tr[id=trnomor"+id+"]").remove();
		$("#TBLASAL tr[id=trtanggal"+id+"]").remove();
	}		
</script>


