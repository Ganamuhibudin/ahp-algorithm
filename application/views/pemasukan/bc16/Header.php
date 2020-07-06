<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<span id="DivHeaderForm">
	<form id="fbc16" name="fbc16" action="<?= site_url()."/pemasukan/bc16"; ?>" method="post" class="form-horizontal" autocomplete="off">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
		<input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"];?>" />
		<input type="hidden" name="HEADERDOK[NOMOR_AJU]" id="noajudok" value="<?= $aju;?>" />
		<span id="divtmp"></span>
		<table width="100%" border="0">
			<tr>
            	<td width="45%" valign="top">
                	<h5 class="header smaller lighter blue"><i>Data KPBC</i></h5>
                	<table width="100%" border="0">
                        <tr>
                            <td width="29%">KPBC Bongkar </td>
                            <td width="69%">
                            	<div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[KODE_KPBC_BONGKAR]" id="kpbc_bongkar" value="<?= $sess['KODE_KPBC_BONGKAR']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" urai="urktbongkar;" wajib="yes" onfocus="Autocomp(this.id)" class="stext date" maxlength="6" format="angka" <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc','kpbc_bongkar;urktbongkar','Kode Kpbc','fbc16',650,470)"><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div> &nbsp;<span id="urktbongkar"><?= $sess['URAIAN_KPBC_BONGKAR']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KPBC_BONGKAR']; ?></span>
                          	</td>
                        </tr>
                        <tr>
                            <td>KPBC Pengawas </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[KODE_KPBC_AWAS]" id="kpbc_pengawas" value="<?= $sess['KODE_KPBC_AWAS']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" urai="urktawas;" wajib="yes" onfocus="Autocomp(this.id)" class="stext date" maxlength="6" format="angka" <?=$readonly?> />
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('kpbc','kpbc_pengawas;urktawas','Kode Kpbc','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>&nbsp;<span id="urktawas"><?= $sess['URAIAN_KPBC_AWAS']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KPBC_AWAS']; ?></span>
							</td>
                        </tr>
					</table>
				<td width="55%" valign="top">
					<h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5>
                    <table width="80%">
                        <tr>
                            <td>Nomor Pendaftaran</td>
                            <td>
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                                <input type="hidden" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6"  <?=$readonly?>/>
                                <input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN_EDIT]" id="NOMOR_PENDAFTARAN_EDIT" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6"  <?=$readonly?>/>
							<?php }else{?>
                            	<input type="text" disabled="disabled" class="stext date" maxlength="6" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>"/>
							<?php }?>
                         	</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px">
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                                <input type="hidden" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"  <?=$readonly?>/>
                            	<input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN_EDIT]" id="TANGGAL_PENDAFTARAN_EDIT" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="form-control" style="width:90px" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"  <?=$readonly?>/>
                            <?php }else{?>
                            	<input type="text" disabled="disabled" class="form-control" style="width:90px;background:#fff" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>"/><?php }?><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;YYYY-MM-DD
                        	</td>
                        </tr>
                        <tr>
                            <td>No. Persetujuan Pemasukan</td>
                            <td>
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                            	<input type="text" name="HEADERDOK[NOMOR_DOK_PABEAN]" id="NOMOR_DOK_PABEAN" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" maxlength="30"  <?=$readonly?>/>
							<?php }else{?>
                            	<input type="text" disabled="disabled" class="text" value="<?= $sess['NOMOR_DOK_PABEAN']; ?>" />
							<?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Persetujuan Pemasukan</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px">
                            <?php if($sess['STATUS_DOK']=="LENGKAP"){?>
                            	<input type="text" name="HEADERDOK[TANGGAL_DOK_PABEAN]" id="TANGGAL_DOK_PABEAN" class="form-control" style="width:90px" value="<?= ($sess['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$sess['TANGGAL_DOK_PABEAN']; ?>" onfocus="ShowDP('TANGGAL_DOK_PABEAN');"  <?=$readonly?>/>
                            <?php }else{?>
                            	<input type="text" disabled="disabled" class="form-control" style="width:90px;background:#fff" value="<?= ($sess['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$sess['TANGGAL_DOK_PABEAN']; ?>"/>
							<?php }?><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;YYYY-MM-DD
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
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGIRIM</b></h5></td>
                        </tr>
                        <tr>
                            <td width="29%">Nama </td>
                            <td width="69%">
                                <input type="text" name="HEADER[NAMA_PENGIRIM]" id="nama_partner" value="<?= $sess['NAMA_PENGIRIM']; ?>" class="mtext"  <?=$readonly?>/>
                           	</td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat </td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_PENGIRIM]" id="alamat_partner" class="mtext" onkeyup="limitChars(this.id, 70, 'limitAlamatPemasok')" <?=$disabled?>><?= $sess['ALAMAT_PENGIRIM']; ?></textarea>
                            	<div id="limitAlamatPemasok"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Negara Asal </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                              <input type="text" name="HEADER[NEGARA_PENGIRIM]" id="negara_asal_partner" value="<?= $sess['NEGARA_PENGIRIM']; ?>" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" class="ssstext" urai="urnegara_asal_partner;" <?=$readonly?> wajib="yes" />
                              <span class="input-group-btn">
                                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','negara_asal_partner;urnegara_asal_partner','Kode Negara','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                              </div>&nbsp;<span id="urnegara_asal_partner"><?= $sess['URAIAN_NEGARA_PENGIRIM']==''?$URAIAN_NEGARA:$sess['URAIAN_NEGARA_PENGIRIM']; ?></span>&nbsp;<span id="urnegara_asal_part"><?= $URAIAN_NEGARA; ?></span>
                          	</td>
                        </tr>
                        <tr>
                        	<td colspan="3" class="rowheight"  style="line-height:30px"><h5 class="smaller lighter blue"><b>DATA PENJUAL</b></h5></td>
                        </tr>
                        <tr>
                            <td width="29%">Nama </td>
                            <td width="69%">
                                <div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" wajib="yes" name="HEADER[NAMA_PENJUAL]" id="nama_penjual" value="<?= $sess['NAMA_PENJUAL']; ?>" class="mtext"  <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pembeli', 'nama_penjual;alamat_penjual;negara_asal_penjual', 'penerima', 'fbc16', 600, 400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>
                           	</td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat </td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_PENJUAL]" id="alamat_penjual" class="mtext" onkeyup="limitChars(this.id, 70, 'limitAlamatPenjual')" <?=$disabled?>><?= $sess['ALAMAT_PENJUAL']; ?></textarea>
                            	<div id="limitAlamatPenjual"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Negara Asal </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[NEGARA_PENJUAL]" id="negara_asal_penjual" value="<?= $sess['NEGARA_PENJUAL']; ?>" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" class="ssstext" urai="urnegara_asal_partner;" <?=$readonly?> wajib="yes" />
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','negara_asal_penjual;urnegara_asal_penjual','Kode Negara','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>&nbsp;<span id="urnegara_asal_penjual"><?= $sess['UR_NEGARA_PENJUAL']==''?$URAIAN_NEGARA:$sess['UR_NEGARA_PENJUAL']; ?></span>&nbsp;<span id="urnegara_asal_part"><?= $URAIAN_NEGARA; ?></span>
                          	</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"  style="line-height:30px"><h5 class="smaller lighter blue"><b>PENGUSAHA PLB/PDPLB</b></h5></td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td>
								<combo><?= form_dropdown('HEADER[KODE_ID_TRADER]', $kode_id_trader, $sess['KODE_ID_TRADER'], 'wajib="yes" id="kode_id_trader" class="sstext" readonly="readonly" '); ?></combo> <input type="text" name="HEADER[ID_TRADER]" id="id_trader" value="<?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?>" class="ltext" size="20" maxlength="15" wajib="yes" readonly/>
                          	</td>
                        </tr> 
                        <tr>
                            <td>Nama</td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_TRADER]" id="nama_trader" value="<?= $sess['NAMA_TRADER']; ?>" class="mtext" maxlength="50" wajib="yes" readonly/>
                           	</td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat</td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_TRADER]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')" readonly><?= $sess['ALAMAT_TRADER']; ?></textarea>
                            	<div id="limitAlamatTrader"></div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3" class="rowheight"  style="line-height:30px"><h5 class="smaller lighter blue"><b>DATA PEMILIK</b></h5></td>
                        </tr>
                        <tr>
                            <td>Identitas</td>
                            <td>
								<combo><?= form_dropdown('HEADER[KODE_ID_PEMILIK]', $kode_id_trader, $sess['KODE_ID_PEMILIK'], 'wajib="yes" id="kode_id_pemilik" class="sstext" readonly="readonly" '); ?></combo> <input type="text" name="HEADER[ID_PEMILIK]" id="id_pemilik" value="<?= $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']); ?>" class="ltext" size="20" maxlength="15" wajib="yes" readonly/>&nbsp;<a class="btn btn-sm btn-warning" style="height:19pt; vertical-align:top;" title="Copy dari PDPLB" onclick="copydataPDPLB();" href="javascript:void(0)"><i class="icon-copy"></i></a>
                          	</td>
                        </tr> 
                        <tr>
                            <td width="29%">Nama </td>
                            <td width="69%">
                                <input type="text" name="HEADER[NAMA_PEMILIK]" id="nama_pemilik" value="<?= $sess['NAMA_PEMILIK']; ?>" class="mtext"  <?=$readonly?>/>
                           	</td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat </td>
                            <td>
                            	<textarea name="HEADER[ALAMAT_PEMILIK]" id="alamat_pemilik" class="mtext" onkeyup="limitChars(this.id, 70, 'limitAlamatPemilik')" <?=$disabled?>><?= $sess['ALAMAT_PEMILIK']; ?></textarea>
                            	<div id="limitAlamatPemilik"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Negara</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                  <input type="text" name="HEADER[NEGARA_PEMILIK]" id="negara_asal_pemilik" value="<?= $sess['NEGARA_PEMILIK']; ?>" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" class="ssstext" urai="urnegara_asal_pemilik;" <?=$readonly?> wajib="yes" />
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','negara_asal_pemilik;urnegara_asal_pemilik','Kode Negara','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>&nbsp;<span id="urnegara_asal_pemilik"><?= $sess['URAIAN_NEGARA_PEMILIK']==''?$URAIAN_NEGARA:$sess['URAIAN_NEGARA_PEMILIK']; ?></span>&nbsp;<span id="urnegara_asal_part"><?= $URAIAN_NEGARA; ?></span>
                          	</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA SARANA ANGKUT</b></h5></td>
                        </tr>
                        <tr>
                            <td>Moda Transportasi</td>
                            <td>
								<combo><?= form_dropdown('HEADER[MODA]', $cara_angkut, $sess['MODA'], 'wajib="yes" id="cara_angkut" class="mtext" '.$disabled); ?></combo>
                           	</td>
                        </tr>
                        <tr>
                            <td>Nama Sarana Angkut </td>
                            <td>
                            	<input type="text" name="HEADER[NAMA_ANGKUT]" id="nama_angkut" value="<?= $sess['NAMA_ANGKUT']; ?>" wajib="yes" class="mtext"  <?=$readonly?>/>
                          	</td>
                        </tr>
                        <tr>
                            <td>No. Voy/Flight </td>
                            <td>
                            	<input type="text" name="HEADER[NOMOR_ANGKUT]" id="nomor_voy" value="<?= $sess['NOMOR_ANGKUT']; ?>" class="mtext" maxlength="7" wajib="yes" <?=$readonly?>/>
                          	</td>
                        </tr>
                        <tr>
                            <td>Bendera</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[BENDERA]" id="bendera" value="<?= $sess['BENDERA']; ?>" class="ssstext" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" urai="urbendera;"  <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('negara','bendera;urbendera','Kode Negara','fbc16',650,400)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                  </div>&nbsp;<span id="urbendera"><?= $sess['URAIAN_BENDERA']==''?$URAIAN_NEGARA:$sess['URAIAN_BENDERA']; ?></span>
                          	</td>
                        </tr>
                   	</table>
             	</td>
                <td width="55%" valign="top">
                    <table width="100%" border="0">
                    	<tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PELABUHAN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Muat </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[PELABUHAN_MUAT]" id="pelabuhan_muat" value="<?= $sess['PELABUHAN_MUAT']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_muat;" class="sstext date" wajib="yes" maxlength="5" <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan','pelabuhan_muat;urpelabuhan_muat','Kode Pelabuhan','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_muat"><?= $sess['URAIAN_MUAT']==''?$urpelabuhan_muat:$sess['URAIAN_MUAT']; ?></span>
                     		</td>
                        </tr>
                        <tr>
                            <td>Transit</td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[PELABUHAN_TRANSIT]" id="pelabuhan_transit" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_transit;" class="stext date" value="<?= $sess['PELABUHAN_TRANSIT']; ?>" maxlength="5" <?=$readonly?> wajib="yes" />
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan','pelabuhan_transit;urpelabuhan_transit','Kode Pelabuhan','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_transit"><?= $sess['URAIAN_TRANSIT']==''?$urpelabuhan_transit:$sess['URAIAN_TRANSIT']; ?></span>
                       		</td>
                        </tr>
                        <tr>
                            <td>Bongkar </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[PELABUHAN_BONGKAR]" id="pelabuhan_bongkar" value="<?= $sess['PELABUHAN_BONGKAR']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan/dalam" onfocus="Autocomp(this.id)" urai="urpelabuhan_bongkar;" class="stext date" wajib="yes" maxlength="5" <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('pelabuhan','pelabuhan_bongkar;urpelabuhan_bongkar','Kode Pelabuhan','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urpelabuhan_bongkar"><?= $sess['URAIAN_BONGKAR']==''?$urpelabuhan_bongkar:$sess['URAIAN_BONGKAR']; ?></span>
                       		</td>
                        </tr>
                        <tr>
                             <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>INFORMASI LAIN</b></h5></td>
                        </tr>
                        <tr>
                            <td width="117">Perkiraan Tanggal Tiba</td>
                            <td width="435"><div class="input-group" style="width:3em;float:left;margin-bottom:0px">
								<input type="text" name="HEADER[PERKIRAAN_TGL_TIBA]" id="perkiraan_tgl_tiba" value="<?=$sess["PERKIRAAN_TGL_TIBA"]?>" class="form-control" style="width:90px" onFocus="ShowDP('perkiraan_tgl_tiba')" <?=$disabled?> /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;YYYY-MM-DD
                          	</td>
                        </tr>
                        <tr>
                            <td width="117">Penutup</td>
                            <td width="435">
								<combo><?= form_dropdown('HEADER[KODE_PENUTUP]', $kode_penutup, $sess['KODE_PENUTUP'], 'id="kode_penutup" class="mtext date" '.$disabled); ?></combo>
                          	</td>
                        </tr>
                        <tr>
                            <td>Nomor&nbsp;</td>
                            <td>
                            	<input type="text" name="HEADER[NOMOR_PENUTUP]" id="nomor_penutup" value="<?= $sess['NOMOR_PENUTUP']?>" class="stext date" maxlength="6" format="angka" <?=$disabled?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal&nbsp;</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px">
                            	<input type="text" name="HEADER[TANGGAL_PENUTUP]" id="tanggal_penutup" value="<?= $sess['TANGGAL_PENUTUP']?>" onfocus="ShowDP('tanggal_penutup')" class="form-control" style="width:90px" <?=$disabled?>><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;YYYY-MM-DD
                      		</td>
                        </tr>
                        <tr>
                            <td>Nomor Pos&nbsp;</td>
                            <td>
                            	<input type="text" name="HEADER[NOMOR_POS]" id="nomor_pos" value="<?= $sess['NOMOR_POS']?>" class="ssstext" maxlength="4" format="angka" <?=$disabled?>>&nbsp;Subpos/Sub-subpos<input type="text" name="HEADER[SUB_POS]" id="sub_pos" value="<?= $sess['SUB_POS']?>" class="ssstext" maxlength="4" format="angka" <?=$disabled?>>&nbsp;/&nbsp;<input type="text" name="HEADER[SUB_SUB_POS]" id="sub_sub_pos" value="<?= $sess['SUB_SUB_POS']?>" class="ssstext" maxlength="4" format="angka" <?=$disabled?>>
                            </td>
                        </tr>
                        <tr>
                            <td>Tempat Timbun </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[KODE_TIMBUN]" id="tempat_timbun" value="<?= $sess['KODE_TIMBUN']; ?>" url="<?= site_url(); ?>/autocomplete/timbun" onfocus="Autocomp(this.id)" urai="urtempat_timbun;" class="stext date" wajib="yes" maxlength="4" <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('timbun','tempat_timbun;urtempat_timbun','Kode Timbun','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;<span id="urtempat_timbun"><?= $sess['URAIAN_TIMBUN']==''?$urtempat_timbun:$sess['URAIAN_TIMBUN']; ?></span>
                         	</td>
                        </tr>
                        <tr>
                            <td>Valuta </td>
                            <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[KODE_VALUTA]" id="valuta" value="<?= $sess['KODE_VALUTA']; ?>" url="<?= site_url(); ?>/autocomplete/valuta" onfocus="Autocomp(this.id)" urai="urvaluta;" class="stext date" wajib="yes"  <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('valuta','valuta;urvaluta','Kode Valuta','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>&nbsp;
                            	<span id="urvaluta"><?= $sess['URAIAN_VALUTA']==''?$urvaluta:$sess['URAIAN_VALUTA']; ?></span>
                          	</td>
                        </tr>
                        <tr>
                            <td>Kode Harga </td>
                            <td>
                            	<combo><?= form_dropdown('HEADER[KODE_HARGA]', $kode_harga, $sess['KODE_HARGA'], 'id="kode_harga" class="mtext date" '.$disabled); ?></combo>
                          	</td>
                        </tr>
                         <tr>
                            <td>Jenis Nilai </td>
                            <td>
                            	<div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                 <input type="text" name="HEADER[JENIS_NILAI]" id="JENIS_NILAI" value="<?= $sess['JENIS_NILAI']; ?>" url="<?= site_url(); ?>/autocomplete/jenis_nilai" onfocus="Autocomp(this.id)" class="stext date"  <?=$readonly?>/>
                                  <span class="input-group-btn">
                                      <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('jenis_nilai','JENIS_NILAI','Jenis Nilai','fbc16',650,470)" <?=$display?>><i class="fa fa-ellipsis-h"></i></a></span>
                                </div>
                          	</td>
                        </tr>
                        <tr>
                            <td>Nilai </td>
                            <td>
                            	<input type="text" name="cifur" id="cifur" value="<?= $this->fungsi->FormatRupiah($sess['NILAI'],2);?>" class="mtext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('cif',this.value,2);">
                              	<input type="hidden" name="HEADER[NILAI]" id="cif" value="<?= $sess['NILAI']?>" />
                         	</td>
                        </tr>
                        <tr>
                            <td>Bruto </td>
                            <td><input type="text" name="BRUTOUR" id="BRUTOUR" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'],2); ?>" class="mtext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('BRUTO',this.value,2);"  <?=$readonly?>/>&nbsp; Kilogram (KGM)
                            <input type="hidden" name="HEADER[BRUTO]" id="BRUTO" value="<?= $sess['BRUTO']?>" /></td>
                        </tr>
                        <tr>
                            <td class="rowheight">Netto</td>
                            <td><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'],4); ?>&nbsp; Kilogram (KGM)<input type="hidden" name="HEADER[NETTO]" value="<?= $sess['JUM_NETTO']; ?>" class="text"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Otomatis terisi dari jumlah total Netto Detil Barang</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENANDATANGAN DOKUMEN</b></h5></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="HEADER[PEMBERITAHU]" id="nama_ttd" value="<?= $sess['PEMBERITAHU']; ?>" class="mtext"  <?=$readonly?>/></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td><input type="text" name="HEADER[JABATAN]" id="nama_ttd" value="<?= $sess['JABATAN']; ?>" class="mtext"  <?=$readonly?>/></td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td><input type="text" name="HEADER[KOTA_TTD]" id="tempat_ttd" value="<?= $sess['KOTA_TTD']; ?>" class="mtext"  <?=$readonly?>/></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><div class="input-group" style="width:3em;float:left;margin-bottom:0px"><input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" onfocus="ShowDP('tanggal_ttd');" onclick="ShowDP('tanggal_ttd');" value="<?php if($act=="save") echo date("Y-m-d"); else echo $sess['TANGGAL_TTD']; ?>" class="form-control" style="width:90px"  <?=$disabled?>/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;YYYY-MM-DD</td>
                        </tr>
                    </table>
             	</td>
          	</tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php if(!$priview){?>
            <tr>
                <td colspan="2">
                	<a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="save_header('#fbc16');"><i class="icon-save"></i>&nbsp;<?=ucwords($act)?></a>&nbsp;
                    <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="cancel('fbc16');"><i class="icon-undo"></i>Reset</a>&nbsp;
                    <span class="msgheader_" style="margin-left:20px">&nbsp;</span>
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
	$(function(){FormReady();})
	$(document).ready(function(){
		jkwaktu();
	});
	function jkwaktu(){
		if($('#jenis_impor').val()=='2'){
			$('#jangkawaktu').show();
		}else{
			$('#jangkawaktu').hide();
		}
	}
	function copydataPDPLB(){
		$("#kode_id_pemilik").val($("#kode_id_trader").val());
		$("#id_pemilik").val($("#id_trader").val());
		$("#nama_pemilik").val($("#nama_trader").val());
		$("#alamat_pemilik").val($("#alamat_trader").val());
	}
	<? if($priview){ ?>
		$('#fbc16 input:visible, #281 select').attr('disabled',true);
	<? } ?>
</script>