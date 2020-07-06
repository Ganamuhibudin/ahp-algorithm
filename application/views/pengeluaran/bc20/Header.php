<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<span id="DivHeaderForm">
<form id="fbc20_" name="fbc20_" action="<?= site_url()."/pengeluaran/bc20"; ?>" method="post" class="form-horizontal">
  <input type="hidden" name="act" id="act" value="<?= $act;?>" />
  <input type="hidden" name="HEADER[NOMOR_AJU]" id="noaju" value="<?= $aju;?>" />
  <input type="hidden" name="STATUS_DOK" id="STATUS_DOK" value="<?= $sess["STATUS_DOK"];?>" />
  <input type="hidden" name="HEADERDOK[NOMOR_AJU]" id="noajudok" value="<?= $aju;?>" />
  <span id="divtmp"></span>
  <table width="100%" border="0">
    <tr>
      <td width="45%" valign="top"><table width="100%" border="0">
          <?php if($sess['NOMOR_AJU']){?>
          <tr>
            <td width="29%" height="25px;">Nomor Aju</td>
            <td width="69%"><b>
              <?= $sess['NOMOR_AJU']; ?>
              </b></td>
          </tr>
          <?php } ?>
          <tr>
            <td width="29%">KPBC Pendaftaran </td>
            <td width="69%"><input type="text"  name="HEADER[KODE_KPBC]" id="kpbc_daftar" value="<?= $sess['KODE_KPBC']; ?>" url="<?= site_url(); ?>/autocomplete/kpbc" urai="urkt;" wajib="yes" onfocus="Autocomp(this.id)" class="stext date" maxlength="6" format="angka"/>
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('kpbc','kpbc_daftar;urkt','Kode Kpbc',this.form.id,650,400)" value="...">&nbsp;
              <span id="urkt">
              <?= $sess['URAIAN_KPBC']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KPBC']; ?>
              </span></td>
          </tr>
          <tr>
            <td>Jenis PIB </td>
            <td><combo><?= form_dropdown('HEADER[JNPIB]', $jenis_pib, $sess['JNPIB'], 'wajib="yes" id="jenis_pib" class="mtext" '); ?></combo></td>
          </tr>
          <tr>
            <td>Jenis Impor</td>
            <td><combo><?= form_dropdown('HEADER[JNIMP]', $jenis_impor, $sess['JNIMP'], 'wajib="yes" id="jenis_impor" class="mtext"  onblur="jkwaktu()" onchange="jkwaktu()"'); ?></combo>
              &nbsp;<span id='jangkawaktu'> Jangka Waktu :
              <input type="text" name="HEADER[JKWAKTU]" id="JKWAKTU" value="<?= $sess['JKWAKTU']; ?>" class="ltext" style="width:30px;"  maxlength="4" />
              bulan</span></td>
          </tr>
          <tr>
            <td>Cara Bayar </td>
            <td><combo><?= form_dropdown('HEADER[CRBYR]', $cara_bayar, $sess['CRBYR'], 'wajib="yes" id="cara_bayar" class="mtext" '); ?></combo></td>
          </tr>
        </table>
      <td width="55%"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5>
        <table width="80%">
          <tr>
             <td width="28%">Nomor Pendaftaran</td>
            <td width="72%"><? if($sess['STATUS_DOK']=="LENGKAP"){?>
              <input type="text" name="HEADERDOK[NOMOR_PENDAFTARAN]" id="NOMOR_PENDAFTARAN" class="stext date" value="<?= $sess['NOMOR_PENDAFTARAN']; ?>" maxlength="6" />
              <? }else{?>
              <input type="text" disabled="disabled" class="stext date" maxlength="6" />
              <? }?></td>
          </tr>
          <tr>
            <td>Tanggal Pendaftaran</td>
            <td><? if($sess['STATUS_DOK']=="LENGKAP"){?>
              <input type="text" name="HEADERDOK[TANGGAL_PENDAFTARAN]" id="TANGGAL_PENDAFTARAN" onfocus="ShowDP('TANGGAL_PENDAFTARAN');" class="stext date" value="<?= $sess['TANGGAL_PENDAFTARAN']; ?>" />
              <? }else{?>
              <input type="text" disabled="disabled" class="stext date"/>
              <? }?>
              &nbsp;YYYY-MM-DD</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <h4 class="header smaller lighter green">DATA PEMBERITAHUAN</h4>
  <table width="100%" border="0">
    <tr>
      <td width="45%" valign="top"><table width="100%" border="0">
          <tr>
            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA PEMASOK</h5></td>
          </tr>
          <tr>
            <td width="29%">Nama </td>
            <td width="69%"><input type="text" name="HEADER[PASOKNAMA]" id="nama_partner" value="<?= $sess['PASOKNAMA']; ?>" url="<?= site_url(); ?>/autocomplete/pemasok" wajib="yes" onfocus="Autocomp(this.id)" urai="alamat_partner;negara_asal_partner;urnegara_asal_part;" class="mtext" />
            <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('pembeli','nama_partner;alamat_partner;negara_asal_partner','Pemasok','fbc20_',600,400)" value="..."></td>
          </tr>
          <tr>
            <td class="top">Alamat </td>
            <td><textarea name="HEADER[PASOKALMT]" id="alamat_partner" wajib="yes" class="mtext" onkeyup="limitChars(this.id, 70, 'limitAlamatPemasok')"><?= $sess['PASOKALMT']; ?>
</textarea>
              <div id="limitAlamatPemasok"></div></td>
          </tr>
          <tr>
            <td>Negara Asal </td>
            <td><input type="text" name="HEADER[PASOKNEG]" id="negara_asal_partner" value="<?= $sess['PASOKNEG']; ?>" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" class="ssstext" urai="urnegara_asal_partner;" wajib="yes"/>
         
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('negara','negara_asal_partner;urnegara_asal_partner','Kode Negara',this.form.id,650,400)" value="...">
              &nbsp;<span id="urnegara_asal_partner">
              <?= $sess['UR_PASOKNEG']==''?$URAIAN_NEGARA:$sess['UR_PASOKNEG']; ?>
              </span>&nbsp;<span id="urnegara_asal_part">
              <?= $URAIAN_NEGARA; ?>
              </span></td>
          </tr>
          <tr>
            <td colspan="3" class="rowheight"  style="line-height:30px"><h5 class="smaller lighter blue">DATA IMPORTIR</h5></td>
          </tr>
          <tr>
            <td width="25%">Identitas</td>
            <td width="75%"><combo><?= form_dropdown('HEADER[IMPID]', $kode_id_trader, $sess['IMPID'], 'wajib="yes" id="IMPID" class="sstext" style="width:130px;"'); ?></combo>
              <input type="text" name="HEADER[IMPNPWP]" id="id_trader" onfocus="unformatNPWP(this);" onblur="formatNPWP(this);" value="<?= $sess['IMPNPWP']=="" ? "" : $this->fungsi->FORMATNPWP($sess['IMPNPWP']); ?>" class="ltext" size="20" maxlength="15" wajib="yes" style="width:148px;" /></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td><input type="text" name="HEADER[IMPNAMA]" id="nama_trader" value="<?= $sess['IMPNAMA']; ?>" class="mtext" maxlength="50" wajib="yes" /></td>
          </tr>
          <tr>
            <td class="top">Alamat</td>
            <td><textarea name="HEADER[IMPALMT]" id="alamat_trader" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatTrader')" ><?= $sess['IMPALMT']; ?>
</textarea>
              <div id="limitAlamatTrader"></div></td>
          </tr>
          <tr>
            <td>Status </td>
            <td><?php $impstatus = explode("|", $sess['IMPSTATUS']);
                                    foreach ($impstatus as $val) { 
                                        $arr[$val] = 'checked';
                                    } //print_r($sessHEADER);die();
                                    ?>
              <table width="100%">
                <tr>
                  <td ><input type="checkbox" name="HEADER[IMPSTATUS][1]" id="IMPSTATUS[1]" value="1" <?= $arr[1] ?> />
                    &nbsp;Importir Umum
                    <label for="IMPSTATUS[1]"></label></td>
                  <td ><input type="checkbox" name="HEADER[IMPSTATUS][5]" id="IMPSTATUS[5]" value="5" <?= $arr[5] ?>/>
                    &nbsp;BULOG
                    <label for="IMPSTATUS[5]"></label></td>
                </tr>
                <tr>
                  <td ><input type="checkbox" name="HEADER[IMPSTATUS][2]" id="IMPSTATUS[2]" value="2" <?= $arr[2] ?>/>
                    &nbsp;Importir Produser
                    <label for="IMPSTATUS[2]"></label></td>
                  <td ><input type="checkbox" name="HEADER[IMPSTATUS][6]" id="IMPSTATUS[6]" value="6" <?= $arr[6] ?>/>
                    &nbsp;PERTAMINA
                    <label for="IMPSTATUS[6]"></label></td>
                </tr>
                <tr>
                  <td ><input type="checkbox" name="HEADER[IMPSTATUS][3]" id="IMPSTATUS[3]" value="3" <?= $arr[3] ?>/>
                    &nbsp;Importir Terdaftar
                    <label for="IMPSTATUS[3]"></label></td>
                  <td><input type="checkbox" name="HEADER[IMPSTATUS][7]" id="IMPSTATUS[7]" value="7" <?= $arr[7] ?>/>
                    &nbsp;DAHANA
                    <label for="IMPSTATUS[7]"></label></td>
                  <td >&nbsp;</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="HEADER[IMPSTATUS][4]" id="IMPSTATUS[4]" value="4" <?= $arr[4] ?>/>
                    &nbsp;Agen Tunggal
                    <label for="IMPSTATUS[4]"></label></td>
                  <td ><input type="checkbox" name="HEADER[IMPSTATUS][8]" id="IMPSTATUS[8]" value="8" <?= $arr[8] ?>/>
                    &nbsp;IPTN
                    <label for="IMPSTATUS[8]"></label></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>API / APIT / APIU</td>
            <td><combo><?= form_dropdown('HEADER[APIKD]', $kode_api, $sess['APIKD'], 'id="kode_api" class="sstext" '); ?></combo>
              <input type="text" name="HEADER[APINO]" id="no_api" value="<?= $sess['APINO']?>" url="<?= site_url(); ?>/autocomplete/importir" class="ltext" maxlength="15"/></td>
          </tr>
          <tr>
            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA PEMILIK BARANG</h5></td>
          </tr>
          <tr>
            <td>Identitas</td>
            <td><?= form_dropdown('HEADER[INDID]', $kode_id_trader, $sess['INDID'], 'wajib="yes" id="INDID" class="sstext" style="width:130px;"'); ?>
              <input type="text" name="HEADER[INDNPWP]" id="id_pemilik" onfocus="unformatNPWP(this);" onblur="formatNPWP(this);" value="<?= $sess['INDNPWP']; ?>" class="ltext" size="20" maxlength="15" wajib="yes" style="width:148px;"/></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td><input type="text" name="HEADER[INDNAMA]" id="nama_pemilik" value="<?= $sess['INDNAMA']; ?>" class="mtext" maxlength="50" wajib="yes"/></td>
          </tr>
          <tr>
            <td class="top">Alamat</td>
            <td><textarea name="HEADER[INDALMT]" id="alamat_pemilik" class="mtext" wajib="yes" onkeyup="limitChars(this.id, 70, 'limitAlamatPemilik')"><?= $sess['INDALMT']; ?>
</textarea>
              <div id="limitAlamatPemilik"></div></td>
          </tr>
          <tr>
            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA SARANA ANGKUT</h5></td>
          </tr>
          <tr>
            <td>Moda Transportasi</td>
            <td><combo><?= form_dropdown('HEADER[MODA]', $cara_angkut, $sess['MODA'], 'wajib="yes" id="cara_angkut" class="mtext" '); ?></combo></td>
          </tr>
          <tr>
            <td>Nama Sarana Angkut </td>
            <td><input type="text" name="HEADER[ANGKUTNAMA]" id="nama_angkut" value="<?= $sess['ANGKUTNAMA']; ?>"  wajib="yes" class="mtext" /></td>
          </tr>
          <tr>
            <td>No. Voy/Flight </td>
            <td><input type="text" name="HEADER[ANGKUTNO]" id="nomor_voy" value="<?= $sess['ANGKUTNO']; ?>" class="mtext" maxlength="7" wajib="yes"/></td>
          </tr>
          <tr>
            <td>Bendera</td>
            <td><input type="text" name="HEADER[ANGKUTFL]" id="bendera" value="<?= $sess['ANGKUTFL']; ?>" class="ssstext" url="<?= site_url(); ?>/autocomplete/negara" onfocus="Autocomp(this.id)" urai="urbendera;" />
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('negara','bendera;urbendera','Kode Negara',this.form.id,650,400)" value="...">
              &nbsp;<span id="urbendera">
              <?= $sess['URANGKUTFL']==''?$URAIAN_NEGARA:$sess['URANGKUTFL']; ?>
              </span></td>
          </tr>
          <tr>
            <td>Perkiraan Tgl Tiba&nbsp;</td>
            <td><input type="text" name="HEADER[TGTIBA]" id="tanggal_tiba" value="<?= $sess['TGTIBA']?>" onfocus="ShowDP('tanggal_tiba')" class="stext date">
              &nbsp;YYYY-MM-DD</td>
          </tr>
        </table>
        <h5 class="smaller lighter blue">DATA PUNGUTAN :</h5>
        <table border="0" width="87%" cellpadding="7" cellspacing="0" class="table-striped table-bordered no-margin-bottom">
          <tr>
            <td width="18%" align="center" class="border-brlt">Jenis Pungutan</td>
            <td width="18%" align="center" class="border-brt">Dibayar (Rp) </td>
            <td width="19%" align="center" class="border-brt">Ditangguhkan (Rp)</td>
            <td width="25%" align="center" class="border-brt">Ditangguhkan Pemerintah (Rp) </td>
            <td width="20%" align="center" class="border-brt">Dibebaskan (Rp)</td>
          </tr>
          <?php /*?><tr>
                            <td style="padding-left:10px" class="border-brl">BM</td>
                            <td align="right"><?=$A =($sess['PGT_BM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM'],0):0;?>&nbsp;</td>
                            <td align="right"><?=$A =($sess['PGT_BM_DIT']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_DIT'],0):0;?></td>
                            <td align="right"><?=$A =($sess['PGT_BM_DIT_PEM']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_DIT_PEM'],0):0;?></td>
                            <td align="right"><?=$A =($sess['PGT_BM_STATUS']!="")?$this->fungsi->FormatRupiah($sess['PGT_BM_STATUS'],0):0;?></td>
                        </tr><?php */?>
          <tr>
            <td style="padding-left:10px" class="border-brl">BM</td>
            <td align="right"><?= number_format($data_pgt[1][0]) ?>
              &nbsp;</td>
            <td align="right"><?= number_format($data_pgt[1][1]) ?>
              &nbsp;</td>
            <td align="right"><?= number_format($data_pgt[1][2]) ?>
              &nbsp;</td>
            <td align="right"><?= number_format($data_pgt[1][4]) ?>
              &nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:10px" class="border-brl">Cukai</td>
            <td align="right" class="border"><?= number_format($data_pgt[5][0]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[5][1]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[5][2]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[5][4]) ?>
              &nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:10px;" class="border-brl">PPN</td>
            <td align="right" class="border"><?= number_format($data_pgt[2][0]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[2][1]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[2][2]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[2][4]) ?>
              &nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:10px;" class="border-brl">PPnBM</td>
            <td align="right" class="border"><?= number_format($data_pgt[3][0]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[3][1]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[3][2]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[3][4]) ?>
              &nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:10px;" class="border-brl">PPh</td>
            <td align="right" class="border"><?= number_format($data_pgt[4][0]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[4][1]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[4][2]) ?>
              &nbsp;</td>
            <td align="right" class="border"><?= number_format($data_pgt[4][4]) ?>
              &nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:10px;" class="border-brl"><b>TOTAL</b></td>
            <td align="right" class="border"><b>
              <?= number_format($data_pgt['TOTAL'][0]) ?>
              &nbsp;</b></td>
            <td align="right" class="border"><b>
              <?= number_format($data_pgt['TOTAL'][1]) ?>
              &nbsp;</b></td>
            <td align="right" class="border"><b>
              <?= number_format($data_pgt['TOTAL'][2]) ?>
              &nbsp;</b></td>
            <td align="right" class="border"><b>
              <?= number_format($data_pgt['TOTAL'][4]) ?>
              &nbsp;</b></td>
          </tr>
        </table></td>
      <td width="55%" valign="top"><table width="100%" border="0">
          <tr>
            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA PELABUHAN</h5></td>
          </tr>
          <tr>
            <td width="25%">Muat </td>
            <td width="75%"><input type="text" name="HEADER[PELMUAT]" id="pelabuhan_muat" value="<?= $sess['PELMUAT']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_muat;" class="ssstext" wajib="yes" maxlength="5"/>
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('pelabuhan','pelabuhan_muat;urpelabuhan_muat','Kode Pelabuhan',this.form.id,650,400)" value="...">
              &nbsp;<span id="urpelabuhan_muat">
              <?= $sess['URPELMUAT']==''?$urpelabuhan_muat:$sess['URPELMUAT']; ?>
              </span></td>
          </tr>
          <tr>
            <td>Transit</td>
            <td><input type="text" name="HEADER[PELTRANSIT]" id="pelabuhan_transit" url="<?= site_url(); ?>/autocomplete/pelabuhan" onfocus="Autocomp(this.id)" urai="urpelabuhan_transit;" class="ssstext" value="<?= $sess['PELTRANSIT']; ?>" maxlength="5"/>
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('pelabuhan','pelabuhan_transit;urpelabuhan_transit','Kode Pelabuhan',this.form.id,650,400)" value="...">
              &nbsp;<span id="urpelabuhan_transit">
              <?= $sess['PELTRANSITUR']==''?$urpelabuhan_transit:$sess['PELTRANSITUR']; ?>
              </span></td>
          </tr>
          <tr>
            <td>Bongkar </td>
            <td><input type="text" name="HEADER[PELBKR]" id="pelabuhan_bongkar" value="<?= $sess['PELBKR']; ?>" url="<?= site_url(); ?>/autocomplete/pelabuhan/dalam" onfocus="Autocomp(this.id)" urai="urpelabuhan_bongkar;" class="ssstext" wajib="yes" maxlength="5"/>
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('pelabuhan','pelabuhan_bongkar;urpelabuhan_bongkar','Kode Pelabuhan',this.form.id,650,400)" value="...">
              &nbsp;<span id="urpelabuhan_bongkar">
              <?= $sess['PELBKRUR']==''?$urpelabuhan_bongkar:$sess['PELBKRUR']; ?>
              </span></td>
          </tr>
          <tr>
            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue">INFORMASI LAIN</h5></td>
          </tr>
          <tr>
            <td width="25%">Dokumen Penutup </td>
            <td width="75%"><?= form_dropdown('HEADER[DOKTUPKD]', $kode_penutup, $sess['DOKTUPKD'], 'id="kode_penutup" class="stext" style="width:100px"'); ?>
              <input type="text" name="HEADER[DOKTUPNO]" id="nomor_penutup" value="<?= $sess['DOKTUPNO']?>" class="stext date" style="width:97px" maxlength="6" format="angka"/>
              <input type="text" name="HEADER[DOKTUPTG]" id="tanggal_penutup" value="<?= $sess['DOKTUPTG']?>" onfocus="ShowDP('tanggal_penutup')" class="stext date">
              &nbsp;YYYY-MM-DD</td>
          </tr>
          <tr>
            <td>Nomor Pos&nbsp;</td>
            <td><input type="text" name="HEADER[POSNO]" id="nomor_pos" value="<?= $sess['POSNO']?>" class="ssstext" maxlength="4" format="angka" >
              &nbsp; &nbsp;&nbsp;Subpos/Sub-subpos &nbsp;&nbsp;
              <input type="text" name="HEADER[POSSUB]" id="sub_pos" value="<?= $sess['POSSUB']?>" class="ssstext" maxlength="4" format="angka">
              &nbsp;/&nbsp;
              <input type="text" name="HEADER[POSSUBSUB]" id="sub_sub_pos" value="<?= $sess['POSSUBSUB']?>" class="ssstext" maxlength="4" format="angka"></td>
          </tr>
          <tr>
            <td>SKEP Fasilitas</td>
            <td><input type="text" name="HEADER[KDFAS]" id="KDFAS" value="<?= $sess['KDFAS']; ?>" url="<?= site_url(); ?>/autocomplete/skep" onfocus="Autocomp(this.id)" class="stext date" urai="URKDFAS;" wajib="yes"/>
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('skep','KDFAS;URKDFAS','Kode Fasilitas',this.form.id,650,400)" value="...">
              &nbsp;<span id="URKDFAS">
              <?= $sess['URKDFAS']==''?$URKDFAS:$sess['URKDFAS']; ?>
              </span></td>
          </tr>
          <tr>
            <td>Tempat Timbun </td>
            <td><input type="text" name="HEADER[TMPTBN]" id="tempat_timbun" value="<?= $sess['TMPTBN']; ?>" url="<?= site_url(); ?>/autocomplete/timbun" onfocus="Autocomp(this.id,this.form.id,'kpbc_daftar')" urai="urtempat_timbun;" class="stext date" wajib="yes" maxlength="4"/>
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('timbun','tempat_timbun;urtempat_timbun','Kode Timbun',this.form.id,650,400,'kpbc_daftar;')" value="...">
              &nbsp;<span id="urtempat_timbun">
              <?= $sess['URAIAN_TIMBUN']==''?$urtempat_timbun:$sess['URAIAN_TIMBUN']; ?>
              </span></td>
          </tr>
          <tr>
            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA HARGA</h5></td>
          <tr>
            <td width="16%">Valuta </td>
            <td width="84%"><input type="text" name="HEADER[KDVAL]" id="KDVAL" value="<?= $sess['KDVAL']; ?>" url="<?= site_url(); ?>/autocomplete/valuta" onfocus="Autocomp(this.id)" urai="urvaluta;" class="stext date" wajib="yes" />
              <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('valuta','KDVAL;urvaluta','Kode Valuta',this.form.id,650,400)" value="...">
              &nbsp;<span id="urvaluta">
              <?= $sess['URAIAN_VALUTA']==''?$urvaluta:$sess['URAIAN_VALUTA']; ?>
              </span></td>
          </tr>
          <tr>
            <td>NDPBM (Kurs) </td>
            <td><input type="text" name="nilai_ndpbm" id="nilai_ndpbm" class="stext" align="right" value="<?= $this->fungsi->FormatRupiah($sess['NDPBM'],4); ?>" wajib="yes" onkeyup="this.value = ThausandSeperator('ndpbm',this.value,4);prosesHargaHeader('fbc20_')" style="text-align:right;width:100px;"/>
              <input type="hidden" name="HEADER[NDPBM]" id="NDPBM" value="<?= $sess['NDPBM']?>" />
              <input type="button" class="btn btn-primary btn-xs" style="vertical-align:top" value="Edit Harga" onclick="EditHarga('NDPBM;KDVAL;CIF;FOB;FREIGHT;ASURANSI;KDHRG;BTAMBAHAN;DISCOUNT;KDASS;CIFRP;NILINV', this.form.id,800,800)" /></td>
          </tr>
          <tr>
            <td><span id="22">FOB</span></td>
            <td><input type="text" name="FOBUR" id="FOBUR" value="<?= $this->fungsi->FormatRupiah($sess['FOB'], 2); ?>" class="stext" style="text-align:right;width:100px;" readonly>
              <input type="hidden" name="HEADER[FOB]" id="FOB" value="<?= $sess['FOB'] ?>" /></td>
          </tr>
          <tr>
            <td>Freight</td>
            <td><input type="text" name="FREIGHTUR" id="FREIGHTUR" value="<?= $this->fungsi->FormatRupiah($sess['FREIGHT'], 2); ?>" class="stext" style="text-align:right;width:100px;" readonly />
              <input type="hidden" name="HEADER[FREIGHT]" id="FREIGHT" value="<?= $sess['FREIGHT'] ?>" /></td>
          </tr>
          <tr>
            <td>Asuransi</td>
            <td><input type="text" name="ASURANSIUR" id="ASURANSIUR" value="<?= $this->fungsi->FormatRupiah($sess['ASURANSI'], 2); ?>" class="stext" style="text-align:right;width:100px;" readonly/>
              <input type="hidden" name="HEADER[ASURANSI]" id="ASURANSI" value="<?= $sess['ASURANSI'] ?>" /></td>
          </tr>
          <tr>
            <td>Nilai CIF </td>
            <td><input type="text" name="CIFUR" id="CIFUR" value="<?= $this->fungsi->FormatRupiah($sess['CIF'], 2); ?>" class="stext" style="text-align:right;width:100px;" readonly>
              <input type="hidden" name="HEADER[CIF]" id="CIF" value="<?= $sess['CIF'] ?>" /></td>
          </tr>
          <tr>
            <td>CIF (Rp)</td>
            <td><input type="text" name="HEADER[CIFRP]" id="CIFRPa" value="<?= $this->fungsi->FormatRupiah($sess['CIFRP'], 2); ?>" class="stext" style="text-align:right;width:100px;" readonly ></td>
          </tr>
          <tr>
            <td colspan="4" ><input type="hidden" name="HEADER[KDASS]" id="KDASS" value="<?= $sess["KDASS"]; ?>" />
              <input type="hidden" name="HEADER[BTAMBAHAN]" id="BTAMBAHAN" value="<?= $sess["BTAMBAHAN"]; ?>" />
              <input type="hidden" name="HEADER[DISCOUNT]" id="DISCOUNT" value="<?= $sess["DISCOUNT"]; ?>" />
              <input type="hidden" name="HEADER[KDHRG]" id="KDHRG" value="<?= $sess["KDHRG"]; ?>" />
              <input type="hidden" name="HEADER[NILINV]" id="NILINV" value="<?= $sess["NILINV"]; ?>" /></td>
          </tr>
          <tr>
            <td>Bruto </td>
            <td><input type="text" name="BRUTOUR" id="BRUTOUR" value="<?= $this->fungsi->FormatRupiah($sess['BRUTO'], 2); ?>" class="sstext" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('BRUTO', this.value, 2);" style="text-align:right;"/>
              Kilogram (KGM)
              <input type="hidden" name="HEADER[BRUTO]" id="BRUTO" value="<?= $sess['BRUTO'] ?>" /></td>
          </tr>
          <tr>
            <td class="rowheight">Netto</td>
            <td><?= $this->fungsi->FormatRupiah($sess['NETTO'], 2); ?>
              &nbsp; Kilogram (KGM)
              <input type="hidden" name="HEADER[NETTO]" value="<?= $sess['NETTO']; ?>" class="stext"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Otomatis terisi dari jumlah total Netto Detil Barang</td>
          </tr>
          <tr>
            <td colspan="3" class="rowheight"><h5 class="smaller lighter blue">DATA PENANDATANGAN DOKUMEN</h5></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td><input type="text" name="HEADER[NAMA_TTD]" id="nama_ttd" value="<?= $sess['NAMA_TTD']; ?>" class="mtext" /></td>
          </tr>
          <tr>
            <td>Tempat</td>
            <td><input type="text" name="HEADER[KOTA_TTD]" id="tempat_ttd" value="<?= $sess['KOTA_TTD']; ?>" class="mtext" /></td>
          </tr>
          <tr>
            <td>Tanggal</td>
            <td><input type="text" name="HEADER[TANGGAL_TTD]" id="tanggal_ttd" onfocus="ShowDP('tanggal_ttd');" onclick="ShowDP('tanggal_ttd');" value="<?php if($act=="save") echo date("Y/m/d"); else echo $sess['TANGGAL_TTD']; ?>" class="stext date" />
              &nbsp;YYYY-MM-DD</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <? if(!$priview){?>
    <tr>
      <td colspan="2"><a href="javascript:void(0);" class="btn btn-sm btn-success" id="ok_" onclick="save_header('#fbc20_');"><i class="icon-save"></i>&nbsp;<?= $act; ?></a>&nbsp;<a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('fbc20_');"><i class="icon-undo"></i>&nbsp;reset</a><span class="msgheader_" style="margin-left:20px">&nbsp;</span></td>
    </tr>
  </table>
  <? } ?>  
  </table>
</form>
<? if($priview){ ?>
<h4 class="header smaller lighter green">Detil Barang</h4>
      <?=$DETILPRIVIEW;?>
  <? } ?>
</span> 
<script>
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
<? if($priview){ ?>
$('#fbc20_ input:visible, #fbc20_ select').attr('disabled',true);
<? } ?>
</script>