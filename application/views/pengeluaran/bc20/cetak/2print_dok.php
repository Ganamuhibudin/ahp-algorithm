<?
#PARAMETER
$KODE_ID_TRADER 		= $DATA['KODE_ID_TRADER'];
$URSTATUS_TRADER 		= $DATA['URSTATUS_TRADER'];
$KODE_API 				= $DATA['KODE_API'];
$BENDERA 				= $DATA['BENDERA'];
$BENDERAUR 				= $DATA['BENDERAUR'];
$CIFRP 					= $DATA['CIFRP'];

$kantor_pabean 		= $DATA['URAIAN_KPBC'];
$kode_pabean		= $DATA['KODE_KPBC'];
$no_pengajuan		= $DATA['NOMOR_AJU'];
$tujuan 			= $DATA['TUJUAN'];
$jns_brg			= substr($DATA['JENIS_BARANG'],1,1);
$tujuan_pengiriman	= substr($DATA['TUJUAN_KIRIM'],1,1); 
$nama_pemasok		= $DATA['NAMA_PEMASOK'];
$alamat_pemasok		= $DATA['ALAMAT_PEMASOK'];
$negara_pemasok		= $DATA['URAIAN_NEGARA_PEMASOK'];
$kd_negara_pemasok	= $DATA['NEGARA_PEMASOK'];
$identitas_importir	= $DATA['ID_TRADER'];
$nama_importir		= $DATA['NAMA_TRADER'];
$alamat_importir	= $DATA['ALAMAT_TRADER'];
$status				= $DATA['STATUS'];
$apit				= $DATA['NOMOR_API'];
$cara_angkut		= $DATA['URAIAN_MODA'];
$kode_pengangkutan	= $DATA['MODA'];
$nama_pengangkut	= $DATA['NAMA_ANGKUT'];
$no_voyage			= $DATA['NOMOR_ANGKUT'];
$pel_muat			= $DATA['URAIAN_MUAT'];
$kode_pelmuat		= $DATA['PELABUHAN_MUAT'];
$pel_transit		= $DATA['URAIAN_TRANSIT'];
$kode_peltransit	= $DATA['PELABUHAN_TRANSIT'];
$pel_bongkar		= $DATA['URAIAN_BONGKAR'];
$kode_pelbongkar	= $DATA['PELABUHAN_BONGKAR'];
$no_invoice			= $DATADOK['NOMOR_INVOICE'];
$tgl_invoice		= $DATADOK['TANGGAL_INVOICE'];
$no_keputusan		= $DATADOK['NOMOR_KEPUTUSAN'];
$tgl_keputusan		= $DATADOK['TANGGAL_KEPUTUSAN'];
$no_lc				= $DATADOK['NOMOR_LC'];
$tgl_lc				= $DATADOK['TANGGAL_LC'];
if($DATADOK['NOMOR_AWB']!="" || $DATADOK['NOMOR_AWB_MST']!=""){
	if($DATADOK['NOMOR_AWB']!=""){
		$no_awb = $DATADOK['NOMOR_AWB'];
	}else{
		$no_awb = $DATADOK['NOMOR_AWB_MST'];
	}
}elseif($DATADOK['NOMOR_BL']!="" || $DATADOK['NOMOR_BL_MST']!=""){
	if($DATADOK['NOMOR_BL']!=""){
		$no_awb = $DATADOK['NOMOR_BL'];
	}else{
		$no_awb = $DATADOK['NOMOR_BL_MST'];
	}
}
if($DATADOK['TANGGAL_AWB']!="" || $DATADOK['TANGGAL_AWB_MST']!=""){
	if($DATADOK['TANGGAL_AWB']!=""){
		$tgl_awb = $DATADOK['TANGGAL_AWB'];
	}else{
		$tgl_awb = $DATADOK['TANGGAL_AWB_MST'];
	}
}elseif($DATADOK['TANGGAL_BL']!="" || $DATADOK['TANGGAL_BL_MST']!=""){
	if($DATADOK['TANGGAL_BL']!=""){
		$tgl_awb = $DATADOK['TANGGAL_BL'];
	}else{
		$tgl_awb = $DATADOK['TANGGAL_BL_MST'];
	}
}
$nama_penimbunan	= $DATA['URAIAN_TIMBUN'];
$kode_penimbunan	= $DATA['KODE_TIMBUN'];
$jns_valuta			= $DATA['URAIAN_VALUTA'];
$kode_valuta		= $DATA['KODE_VALUTA'];
$ndpbm				= $DATA['NDPBM'];
$fob				= $DATA['FOB'];
$freight			= $DATA['FREIGHT'];
$kode_asuransi		= $DATA['KODE_ASURANSI'];
$asuransi			= $DATA['ASURANSI'];
$cif				= $DATA['CIF'];
$jml_kemasan		= $DATAKMS['JUMLAH'];
$jns_kemasan		= $DATAKMS['KODE_KEMASAN'];
$URAIAN_KEMASAN		= $DATAKMS['URAIAN_KEMASAN'];
$berat_kotor		= $DATA['BRUTO'];
$berat_bersih		= $DATA['NETTO'];
$bm_bayar			= ($DATAPGT['PGT_BM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM'],0):0;
$bm_tangguh			= ($DATAPGT['PGT_BM_DIT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_BM_DIT'],0):0;
$cukai_bayar		= ($DATAPGT['PGT_CUKAI']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI'],0):0;
$cukai_tangguh		= ($DATAPGT['PGT_CUKAI_DIT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_CUKAI_DIT'],0):0;
$ppn_bayar			= ($DATAPGT['PGT_PPN']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN'],0):0;
$ppn_tangguh		= ($DATAPGT['PGT_PPN_DIT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPN_DIT'],0):0;
$ppnbm_bayar		= ($DATAPGT['PGT_PPNBM']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM'],0):0;
$ppnbm_tangguh		= ($DATAPGT['PGT_PPNBM_DIT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPNBM_DIT'],0):0;
$pph_bayar			= ($DATAPGT['PGT_PPH']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH'],0):0;
$pph_tangguh		= ($DATAPGT['PGT_PPH_DIT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PPH_DIT'],0):0;
$pnbp_bayar			= ($DATAPGT['PGT_PNBP']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PNBP'],0):0;
$pnbp_tangguh		= ($DATAPGT['PGT_PNBP_DIT']!="")?$this->fungsi->FormatRupiah($DATAPGT['PGT_PNBP_DIT'],0):0;
$total_bayar		= $this->fungsi->FormatRupiah(str_replace(',','',$bm_bayar)+str_replace(',','',$cukai_bayar)+str_replace(',','',$ppn_bayar)+str_replace(',','',$ppnbm_bayar)+str_replace(',','',$pph_bayar)+str_replace(',','',$pnbp_bayar),0);	
$total_tangguh		= $this->fungsi->FormatRupiah(str_replace(',','',$bm_tangguh)+str_replace(',','',$cukai_tangguh)+str_replace(',','',$ppn_tangguh)+str_replace(',','',$ppnbm_tangguh)+str_replace(',','',$pph_tangguh)+str_replace(',','',$pnbp_tangguh),0);
$tempat_bongkar		= "DIISI OLEH PEJABAT KPBC TEMPAT BONGKAR BRG IMPOR";
$no_daftar			= $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar			= $DATA['TANGGAL_PENDAFTARAN'];
$kpbc_bongkar		= $DATA['URAIAN_KPBC_BONGKAR'];
$kode_kpbc_bongkar	= $DATA['KODE_KPBC_BONGKAR'];
$kbpc_pengawas		= $DATA['URAIAN_KPBC_AWAS'];
$kode_kbpc_pengawas	= $DATA['KODE_KPBC_AWAS'];
$trf_bm			    = $DATATRF['TARIF_BM'];
$trf_cukai			= $DATATRF['TARIF_CUKAI'];
$trf_ppn			= $DATATRF['FAS_PPN'];
$trf_ppnbp		    = $DATATRF['FAS_PPNBM'];

$KODE_FAS_BM		= $DATAFAS['KODE_FAS_BM'];
$FAS_BM		    	= $DATAFAS['FAS_BM'];
$KODE_FAS_CUKAI		= $DATAFAS['KODE_FAS_CUKAI'];
$FAS_CUKAI		    = $DATAFAS['FAS_CUKAI'];
$KODE_FAS_PPN		= $DATAFAS['KODE_FAS_PPN'];
$FAS_PPN		    = $DATAFAS['FAS_PPN'];
$KODE_FAS_PPH		= $DATAFAS['KODE_FAS_PPH'];
$FAS_PPH		    = $DATAFAS['FAS_PPH'];
$KODE_FAS_PPNBM		= $DATAFAS['KODE_FAS_PPNBM'];
$FAS_PPNBM		    = $DATAFAS['FAS_PPNBM'];


$trf_pph			= "2.5";
$kode_bm			= "";
$kode_cukai			= "";
$kode_ppn			= "";
$kode_ppnbm			= "";
$kode_pph			= "";
$kode_pnbp			= "";
$no_tndabm			= "";
$no_tndacukai		= "";
$no_tndappn			= "";
$no_tndappnbm		= "";
$no_tndapph			= "";
$no_tndapnbp		= "";
$tgl_bm				= "";
$tgl_cukai			= "";
$tgl_ppn			= "";
$tgl_ppnbm			= "";
$tgl_pph			= "";
$tgl_pnbp			= "";
$query1 = $this->db->query("SELECT TIPE_TRADER FROM M_TRADER WHERE ID='".$identitas_importir."'");
$rowQuery1 = $query1->row();
$tipeTrader=$rowQuery1->TIPE_TRADER;
$query1->free_result();
$query2 = $this->db->query("SELECT URAIAN FROM M_TABEL WHERE JENIS in('JENIS_IMPORTIR','JENIS_EKSPORTIR') and KODE='".$tipeTrader."'");
$rowQuery2 = $query2->row();
$uraian=$rowQuery2->URAIAN;
$query2->free_result();
?>	
<style type="text/css">
.border-t {border-top:thin solid #000000;}
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input50{padding-left:10px;padding-right:10px;width:50px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input10{padding-left:5px;padding-right:5px;width:10px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input40{padding-left:10px;padding-right:10px;width:40px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
.input100{padding-left:10px;padding-right:10px;width:100px;border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}
</style>
			
<body style="font-size:11;">
<?php 
if($SURAT['NOMOR_AJU']){
	$this->load->view("surat/surat");	
	if($hasilTotLampiran>0){
		$this->load->view("surat/lampiran");
	}
}
?>   
<div align="center" style="font-size:11"><b>PEMBERITAHUAN IMPOR BARANG UNTUK DITIMBUN DI<br>TEMPAT PENIMBUNAN BERIKAT</b></div>
<div align="right" style="font-size:10">BC 2.3</div>

      <div class="border-tbrl">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:11">
        <tbody>
          <tr>
            <td  style="font-size:11" colspan="3" class="border-b">
                <table width="100%" border="0"  style="margin-top:-7px">
                <tbody>
                <tr>
                  <td  style="font-size:11" width="19%">Kantor Pabean</td>
                  <td  style="font-size:11" width="45%">: <?=$DATA['URAIAN_KPBC'];?></td>
                  <td  style="font-size:11" width="21%"  align="left"><input type="text" name="kode_pabean" class="input50" value="<?=$kode_pabean;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">Nomor Pengajuan </td>
                  <td  style="font-size:11" colspan="3">: <?=$this->fungsi->FormatAju($no_pengajuan);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11" colspan="4"><table width="100%" border="0">
                      <tr>
                        <td  style="font-size:11" width="19">A.</td>
                        <td  style="font-size:11" width="106">Jenis PIB</td>
                        <td  style="font-size:11" width="24"><input type="text" name="tujuan" class="input10" value="<?= $jenis_pib;?>"></td>
                        <td  style="font-size:11" width="690">
                        <table width="100%" border="0">
                        <tbody>
                            <tr>
                              <td  style="font-size:11" width="19%">1. Biasa</td>
                              <td  style="font-size:11" width="21%">2. Berkala</td>
                              <td  style="font-size:11" width="10%">3. Penyelesaian</td>
                               </tr>
                            </tbody>
                        </table>
                        </td>
                      </tr>
                      <tr>
                        <td  style="font-size:11" valign="top">B.</td>
                        <td  style="font-size:11" valign="top">Jenis Impor</td>
                        <td  style="font-size:11" valign="top" width="24">
                        <input type="text" name="jns_brg" class="input10" value="<?=$jenis_impor;?>"></td>
                        <td  style="font-size:11"><table width="100%" border="0">
                            <tr>
                              <td  style="font-size:11" width="20%" align="left">1. Untuk Dipakai</td>
                              <td  style="font-size:11" width="21%">2. Sementara</td>
                              <td  style="font-size:11" width="18%">3. Reimpor</td>
                              <td  style="font-size:11" width="20%">5. Pelayanan Segera</td>
                              <td  style="font-size:11" width="21%">6. Vooruitslag</td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td  style="font-size:11" valign="top">C.</td>
                        <td  style="font-size:11" valign="top">Cara pembayaran</td>
                        <td  style="font-size:11" valign="top" width="24"><input type="text" name="tujuan_pengiriman" class="input10" value="<?=$tujuan_pengiriman;?>"></td>
                        <td  style="font-size:11">
                        <table width="100%" border="0">
                         <tbody>
                            <tr>
                              <td  style="font-size:11" width="17%">1. Biasa/tunai </td>
                              <td  style="font-size:11" width="12%">2. Berkala </td>
                              <td  style="font-size:11" width="27%">3. Dengan Jaminan </td>
                              <td  style="font-size:11" width="26%">4. Lainnya </td>
                              </tr>
                            </tbody>
                        </table>
                        </td>
                      </tr>
                  </table></td>
                </tr>
            </tbody>
            </table>
            </td>
          </tr>
          <tr>
            <td  style="font-size:11" width="50%" class="border-br">
            <table width="100%" border="0">
            <tbody>
                <tr>
                  <td  style="font-size:11" width="1%"><b>D.</b></td>
                  <td  style="font-size:11" colspan="2"><b>DATA PEMBERITAHUAN</b></td>
                </tr>
                <tr>
                  <td  style="font-size:11" colspan="3"><b>PEMASOK</b></td>
                </tr>
                <tr>
                  <td  style="font-size:11">1. </td>
                  <td  style="font-size:11" width="33%">Nama, Alamat, Negara:</td>
                  <td  style="font-size:11" width="63%" align="right">
				<input type="text" name="kd_negara_pemasok" class="input50" value="<?=$kd_negara_pemasok;?>">
                  </td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="2"><?=$nama_pemasok?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="2"><?= $alamat_pemasok?></td>
                </tr>         
            </tbody>
            </table>   
            </td>
            <td  style="font-size:11" colspan="2" class="border-b" valign="top">
            <table width="100%" border="0">
            <tbody>
                <tr>
                  <td  style="font-size:11" colspan="4"><b>F. DIISI OLEH BEA DAN CUKAI </b></td>
                </tr>                
                <tr>
                  <td  style="font-size:11" width="54%">No. &amp; Tgl. Pendaftaran </td>
                  <td  style="font-size:11" width="2%">:</td>
                  <td  style="font-size:11" colspan="2" align="right"><input name="no_daftar" type="text" class="input50" value="<?=$no_daftar;?>">
                    &nbsp;
                  <input type="text" name="tgl_daftar" class="input50" value="<?= $this->fungsi->dateformat($tgl_daftar);?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">Kantor Pabean Bongkar </td>
                  <td  style="font-size:11">:</td>
                  <td  style="font-size:11" width="25%"><?=$kpbc_bongkar;?></td>
                  <td  style="font-size:11" width="19%" align="right"><input name="kode_kpbc_bongkar" type="text" class="input40" value="<?=$kode_kpbc_bongkar;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">Kantor Pabean Pengawas </td>
                  <td  style="font-size:11">:</td>
                  <td  style="font-size:11"><?=$kbpc_pengawas;?></td>
                  <td  style="font-size:11" align="right"><input name="kode_kbpc_pengawas" type="text" class="input40" value="<?=$kode_kbpc_pengawas;?>"></td>
                </tr>
                </tbody>
            </table>
            </td>
          </tr>
          <tr>
            <td  style="font-size:11" class="border-br" valign="top">
            <table width="100%" border="0" >
            <tbody>
                <tr>
                  <td  style="font-size:11" colspan="6"><b>IMPORTIR</b></td>
                </tr>
                <tr>
                  <td  style="font-size:11" width="1">2.</td>
                  <td  style="font-size:11" width="21%">Identitas</td>
                  <td  style="font-size:11" width="1%" align="right">:</td>
                  <td  style="font-size:11" colspan="3"><?=$KODE_ID_TRADER?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="5"><?=$this->fungsi->FormatNPWP($identitas_importir);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">3.</td>
                  <td  style="font-size:11">Nama, Alamat </td>
                  <td  style="font-size:11" align="right">:</td>
                  <td  style="font-size:11" colspan="3"><?=$nama_importir;?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="5"><?=$alamat_importir;?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">4.</td>
                  <td  style="font-size:11">Status  </td>
                  <td  style="font-size:11" align="right">:</td>
                  <td  style="font-size:11" width="34%"><?=$URSTATUS_TRADER;?></td>
                  <td  style="font-size:11" width="1%">5.</td>
                  <td  style="font-size:11" width="38%"> <?=$KODE_API;?> :&nbsp;<?=$apit;?></td>
                </tr>
            </tbody>
            </table>
            <table width="100%" border="0" cellspacing="0">
            <tbody>
                <tr>
                  <td  style="font-size:11" colspan="6" class="border-t"><b>PPJK</b></td>
                </tr>
                <tr>
                  <td  style="font-size:11" width="1%">6.</td>
                  <td  style="font-size:11" width="99%">NPWP :</td>
                </tr>
                <tr>
                  <td  style="font-size:11">7.</td>
                  <td  style="font-size:11">Nama, Alamat :</td>
                </tr>
                <tr>
                  <td  style="font-size:11">8.</td>
                  <td  style="font-size:11">No. & Tgl Surat Izin :</td>
                </tr>
            </tbody>
            </table>
            </td>
            <td  style="font-size:11" colspan="2"  class="border-b" valign="top">
            <table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="6%">14.</td>
                  <td  style="font-size:11" width="20%">Invoice</td>
                  <td  style="font-size:11" width="2%">:</td>
                  <td  style="font-size:11" colspan="3"><?=$no_invoice;?></td>
                  <td  style="font-size:11" width="6%">Tgl.</td>
                  <td  style="font-size:11" width="16%"><?=$this->fungsi->dateformat($tgl_invoice);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">15</td>
                  <td  style="font-size:11">Surat Keputusan/ </td>
                  <td  style="font-size:11">:</td>
                  <td  style="font-size:11" colspan="3"><?=$no_keputusan;?></td>
                  <td  style="font-size:11">Tgl.</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($tgl_keputusan);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">Persetujuan</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">Dokumen Terkait </td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3">&nbsp;</td>
                  <td  style="font-size:11">Tgl.</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($tgl_dokterkait);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">(BC3.0)</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                </tr>

                <tr>
                  <td  style="font-size:11">16.</td>
                  <td  style="font-size:11">LC</td>
                  <td  style="font-size:11">:</td>
                  <td  style="font-size:11" colspan="3"><?=$no_lc;?></td>
                  <td  style="font-size:11">Tgl.</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($tgl_lc);?></td>
                </tr>

                <tr>
                  <td  style="font-size:11" valign="top">17.</td>
                  <td  style="font-size:11" valign="top">BL/AWB</td>
                  <td  style="font-size:11" valign="top">:</td>
                  <td  style="font-size:11" colspan="3"><?=$nomorbl;?></td>
                  <td  style="font-size:11" valign="top">Tgl.</td>
                  <td  style="font-size:11"><?=$tglbl;?></td>
                </tr>
                
                <tr>
                  <td  style="font-size:11">18.</td>
                  <td  style="font-size:11">BC 1.1 </td>
                  <td  style="font-size:11">:</td>
                  <td  style="font-size:11" width="11%"><?=$DATA['NOMOR_PENUTUP'];?></td>
                  <td  style="font-size:11" width="19%">Pos : &nbsp;<?=$DATA['NOMOR_POS'];?></td>
                  <td  style="font-size:11" width="20%">Sub : &nbsp;<?=$DATA['SUB_POS'];?></td>
                  <td  style="font-size:11">Tgl.</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($DATA['TANGGAL_PENUTUP']);?></td>
                </tr>
            </table></td>
          </tr>
         
          <tr>
            <td  style="font-size:11" class="border-br"><table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="3%">9.</td>
                  <td  style="font-size:11" width="26%">Cara Pengangkutan</td>
                  <td  style="font-size:11" width="2%"> :</td>
                  <td  style="font-size:11" width="60%"><?=$cara_angkut;?></td>
                  <td  style="font-size:11" width="9%" align="right"><input type="text" name="kode_pengangkutan" class="input10" value="<?=$kode_pengangkutan;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" align="right">&nbsp;</td>
                </tr>
            </table></td>
            <td  style="font-size:11" colspan="2" class="border-b"><table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="5%">19.</td>
                  <td  style="font-size:11" width="24%">Tempat Penimbunan </td>
                  <td  style="font-size:11" width="3%"> :</td>
                  <td  style="font-size:11" width="48%"><?=$nama_penimbunan;?></td>
                  <td  style="font-size:11" width="20%" align="right"><input type="text" name="kode_penimbunan" class="input40" value="<?=$kode_penimbunan;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" align="right">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td  style="font-size:11" class="border-br"><table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="1%">10.</td>
                  <td  style="font-size:11" width="86%">Nama Sarana Pengangkut &amp; No. Voy/Flight dan Bendera :</td>
                  <td  style="font-size:11" width="9%" align="right"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11"><?=$nama_pengangkut;?> <?=$no_voyage;?></td>
                  <td  style="font-size:11"><?=$BENDERAUR;?></td>
                </tr>
            </table></td>
            <td  style="font-size:11" width="26%" class="border-br"><table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="1%">20.</td>
                  <td  style="font-size:11" width="20%">Valuta :</td>
                  <td  style="font-size:11" width="5%"></td>
                  <td  style="font-size:11" width="46%" valign="top"></td>
                  <td  style="font-size:11" width="18%" align="right">
                  <input type="text" name="kode_valuta" class="input40" value="<?=$kode_valuta;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" align="right" colspan="2"><?=$jns_valuta;?></td>
                </tr>
            </table></td>
            <td  style="font-size:11" width="24%" class="border-b"><table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="5%">21.</td>
                  <td  style="font-size:11" width="24%">NDPBM</td>
                  <td  style="font-size:11" width="3%"> :</td>
                  <td  style="font-size:11" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="2" align="right"><?=$this->fungsi->FormatRupiah($ndpbm,4);?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td  style="font-size:11" class="border-br">
            <table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="5%">11.</td>
                  <td  style="font-size:11" width="17%">Pelabuhan Muat </td>
                  <td  style="font-size:11" width="2%" align="right">:</td>
                  <td  style="font-size:11" width="67%"><?=$pel_muat;?></td>
                  <td  style="font-size:11" width="9%" align="right"><input type="text" name="kode_pelmuat" class="input40" value="<?=$kode_pelmuat;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">12.</td>
                  <td  style="font-size:11">Pelabuhan Transit </td>
                  <td  style="font-size:11" align="right">:</td>
                  <td  style="font-size:11"><?=$pel_transit;?></td>
                  <td  style="font-size:11" align="right"><input type="text" name="kode_peltransit" class="input40" value="<?=$kode_peltransit;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">13.</td>
                  <td  style="font-size:11">Pelabuhan Bongkar </td>
                  <td  style="font-size:11" align="right">:</td>
                  <td  style="font-size:11"><?=$pel_bongkar;?></td>
                  <td  style="font-size:11" align="right"><input type="text" name="kode_pelbongkar" class="input40" value="<?=$kode_pelbongkar;?>"></td>
                </tr>
            </table></td>
            <td style="font-size:11" class="border-br">
            	<table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="1%">22.</td>
                  <td  style="font-size:11" width="20%">FOB</td>
                  <td width="4%"  style="font-size:11">:</td>
                  <td  style="font-size:11" width="85%" align="right"><?=$this->fungsi->formatRupiah($fob,2);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">23.</td>
                  <td  style="font-size:11">Freight</td>
                  <td  style="font-size:11">:</td>
                  <td  style="font-size:11" align="right"><?=$this->fungsi->formatRupiah($freight,2);?></td>
                </tr>
                <?PHP
                  if($kode_asuransi=='1' || $kode_asuransi==""){
					 $kdass = "Asuransi LN/<del>DN</del>"; 
				  }elseif($kode_asuransi=='2'){	 
				     $kdass = "Asuransi <del>LN</del>/DN"; 
				  }else{
					 $kdass = "Asuransi LN/DN";   
				  }	 
				  ?>
                <tr>
                  <td  style="font-size:11">24.</td>
                  <td  style="font-size:11"><?=$kdass?></td>
                  <td  style="font-size:11">:</td>
                  <td  style="font-size:11" align="right"><?=$this->fungsi->formatRupiah($asuransi,2);?></td>
                </tr>
            </table></td>
            <td  style="font-size:11" class="border-b"><table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" colspan="2">25.Nilai CIF </td>
                </tr>
                <tr>
                  <td  style="font-size:11" colspan="2" align="right"><?=$cif;?></td>
                </tr>
                <tr>
                  <td  style="font-size:11" width="5%">Rp.</td>
                  <td  style="font-size:11" width="95%" align="right"><?=$this->fungsi->FormatRupiah($CIFRP,2);?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td  style="font-size:11" colspan="2" class="border-br" valign="top">
            <table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="1%">26.</td>
                  <td  style="font-size:11" width="40%">Merk dan nomor kemasan/peti kemas :</td>
                  <td  style="font-size:11" width="4%">&nbsp;</td>
                  <td  style="font-size:11" width="4%">27.</td>
                  <td  style="font-size:11" width="27%">Jumlah dan Jenis kemasan : </td>
                  <td  style="font-size:11" width="16%">&nbsp;</td>
                  <td  style="font-size:11" width="6%" align="right"><input type="text" name="jns_kemasan" class="input40" value="<?=$jns_kemasan;?>"></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11"><?=$KONTAINER;?></td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11"><?=$jml_kemasan;?>  <?=$URAIAN_KEMASAN;?></td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11"><?=$DATAKMS['SERI'];?></td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                </tr>
            </table></td>
            <td  style="font-size:11" class="border-b">
            <table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="12%">28.</td>
                  <td  style="font-size:11" width="54%">Berat Kotor (kg) </td>
                  <td  style="font-size:11" width="34%">:</td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" align="right"><?=$this->fungsi->FormatRupiah($berat_kotor,4);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">29.</td>
                  <td  style="font-size:11">Berat Bersih (kg) </td>
                  <td  style="font-size:11">:</td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" align="right"><?=$this->fungsi->FormatRupiah($DATA['NETTO'],4);?></td>
                </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td style="font-size:11" colspan="8" class="border-b">
            <table cellpadding="5" cellspacing="0" width="100%" border="0">
              <tr>
                <td width="3%" valign="top" class="border-br"  style="font-size:11">30. No </td>
                <td width="29%" valign="top" class="border-br"  style="font-size:11">31. - Pos Tarif/HS<br>- Uraian jenis dan jumlah barang secara lengkap,merk, type, ukuran, spesifikasi lain<br>- Kode barang</td>
                <td width="22%" valign="top" class="border-br"  style="font-size:11">32. Kode Penggunaan Barang</td>
                <td width="9%" valign="top" class="border-br"  style="font-size:11">33. Negara Asal </td>
                <td width="18%" valign="top" class="border-br"  style="font-size:11">34. Tarif BM, Cukai, PPN, PPnBM, PPh</td>
                <td width="9%" valign="top" class="border-br"  style="font-size:11">35. - Jumlah<br>- Jenis Satuan <br> - Berat Bersih (kg)</td>
                <td width="10%" valign="top" class="border-b"  style="font-size:11">36. Jumlah Nilai CIF</td>
              </tr>             
			  <?php 			  
			  if (count($BARANG) == 1){ 			  
				  $no=1;
				  foreach( $BARANG as $bar):
			  ?> 
                  <tr>
                    <td  style="font-size:11" class="border-r" align="center" valign="top"><?= $no;?></td>
                    <td  style="font-size:11" class="border-r" valign="top"><?=$bar['KODE_HS'];?><br><?=$bar['URAIAN_BARANG'];?><br><?=$bar['MERK']?> - <?=$bar['TIPE']?> - <?=$bar['SPF']?><br><?=$this->fungsi->FormatRupiah($bar['JUMLAH_KEMASAN'],4).' '.$bar['KODE_KEMASAN'].' / '.$bar['URAIAN_KEMASAN']?><br>Kd Barang : <?=$bar['KODE_BARANG']?></td>
                    <td  style="font-size:11" class="border-r" valign="top"><?=$bar['URAIAN_PENGGUNAAN'];?></td>
                    <td  style="font-size:11" class="border-r" valign="top"><?=$bar['URAIAN_NEGARA'];?></td>
                    <td  style="font-size:11" class="border-r" valign="top">                                                           
                    BM <?=$bar['TARIF_BM']?$bar['TARIF_BM']."%":"-";?> 
				   <?=$this->fungsi->getkodefas($bar['KODE_FAS_BM']) ?>:<?=$bar['FAS_BM']?>%<BR>
                   
                   Cukai <?=$bar['TARIF_CUKAI']?$bar['TARIF_CUKAI']."%":"-";?> 
                   <?=$this->fungsi->getkodefas($bar['KODE_FAS_CUKAI']) ?>:<?=$bar['FAS_CUKAI']?>%<BR>
                   
                   PPN <?=$bar['TARIF_PPN']?$bar['TARIF_PPN']."%":"-";?> 
                   <?=$this->fungsi->getkodefas($bar['KODE_FAS_PPN']) ?>:<?=$bar['FAS_PPN']?>%<BR>
                   
                   PPnBM <?=$bar['TARIF_PPNBM']?$bar['TARIF_PPNBM']."%":"-";?> 
                   <?=$this->fungsi->getkodefas($bar['KODE_FAS_PPNBM']) ?>:<?=$bar['FAS_PPNBM']?>%<BR>
                   
                   PPh: <? $TARIF_PPH = ($DATA['NOMOR_API']=="")?"7,5":"2,5"; echo $TARIF_PPH?$TARIF_PPH."%":"-";?> 
				   <?=$this->fungsi->getkodefas($bar['KODE_FAS_PPH']) ?>:<?=$bar['FAS_PPH']?>%
                    </td>
                    <td  style="font-size:11" class="border-r" valign="top"><?=$this->fungsi->FormatRupiah($bar['JUMLAH_SATUAN'],4);?><br><?=$bar['URAIAN_SATUAN'];?><br>BB:<?=$bar['NETTO'];?></td>
                    <td style="font-size:11" valign="top" align="right"><?=$bar['CIF'];?></td>
                  </tr>                         
                  <?php  endforeach; ?>
                  
                  <?php }elseif(count($BARANG) <1){ ?>
                      <tr>               
                        <td>&nbsp;</td>
                      </tr>
                      <tr>               
                        <td  style="font-size:11"  align="center" colspan="7">=== Belum Terdapat Data Barang === </td>
                      </tr>
                      <tr>               
                        <td>&nbsp;</td>
                      </tr>
              <?php }else{?>
                      <tr>               
                        <td colspan="6" class="border-r">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>               
                        <td width="85%" style="font-size:11" align="center" colspan="6" class="border-r">=== <?=count($BARANG)?> Jenis Barang. Lihat lembar lanjutan === </td>
                   		<td width="15%" style="font-size:11;" valign="top" align="right"><?=$this->fungsi->FormatRupiah($DATA['CIF'],4);?></td>
                      </tr>
                      <tr>               
                        <td colspan="6" class="border-r">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
              <?php }?>
            </table>
            </td>
          </tr>
          <tr>
            <td style="font-size:11" rowspan="4" valign="top" class="border-r">
            
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td  style="font-size:11" colspan="2" align="center" class="border-br">Jenis Pungutan </td>
                <td  style="font-size:11" width="56%" align="center" class="border-br">Dibayar (Rp.)</td>
                <td  style="font-size:11" width="22%" align="center" class="border-b">Ditangguhkan</td>
              </tr>
              <tr>
                <td  style="font-size:11" width="6%" class="border-br">37.</td>
                <td  style="font-size:11" width="16%" class="border-br">BM</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$bm_bayar;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$bm_tangguh;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">38.</td>
                <td  style="font-size:11" class="border-br">Cukai</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$cukai_bayar;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$cukai_tangguh;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">39.</td>
                <td  style="font-size:11" class="border-br">PPN</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppn_bayar;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$ppn_tangguh;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">40.</td>
                <td  style="font-size:11" class="border-br">PPnBM</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppnbm_bayar;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$ppnbm_tangguh;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">41.</td>
                <td  style="font-size:11" class="border-br">PPh</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$pph_bayar;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$pph_tangguh;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">42.</td>
                <td  style="font-size:11" class="border-br">PNBP</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$pnbp_bayar;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$pnbp_tangguh;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-r">43.</td>
                <td  style="font-size:11" class="border-r">TOTAL</td>
                <td  style="font-size:11" align="right" class="border-r"><?=$total_bayar;?></td>
                <td  style="font-size:11" align="right"><?=$total_tangguh;?></td>
              </tr>
              <tr>
              	<td style="font-size:11" class="border-t">E.</td>
                <td style="font-size:11" colspan="3" class="border-t">Dengan ini saya menyatakan bertanggung jawab atas kebenaran </td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11" colspan="3">hal-hal yang diberitahukan dalam dokumen ini. </td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11" colspan="2" align="center"><?=$DATA['KOTA_TTD'].', tgl '.$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?></td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11" colspan="2" align="center">Pemberitahu</td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
              </tr>
              <tr>
                <td  style="font-size:11" height="29">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11" colspan="2" align="center"><?=$DATA['NAMA_TTD'];?></td>
              </tr>
            </table>

            </td>
            <td  style="font-size:11" height="53" colspan="2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td  style="font-size:11">G. UNTUK PEJABAT KANTOR PABEAN BONGKAR </td>
              </tr>
              <tr>
                <td  style="font-size:11" height="24"><?=$DATA['URAIAN_KPBC_BONGKAR'];?></td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td  style="font-size:11" colspan="2" class="border-b">
            <table width="100%" border="0">
              <tr>
                <td  style="font-size:11" colspan="2" class="border-t">H. UNTUK PEMBAYARAN KE BANK/KANTOR PABEAN </td>
              </tr>
              <tr>
                <td  style="font-size:11" width="24%" height="27">No. Penerimaan </td>
                <td  style="font-size:11" width="76%">: </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td  style="font-size:11" colspan="2" valign="top">
            <table width="100%" border="0"  cellpadding="2" cellspacing="0">
              <tr>
                <td  style="font-size:11" width="20%" align="center" class="border-br">Jns. Pens </td>
                <td  style="font-size:11" width="30%" align="center" class="border-br">Kode Akun </td>
                <td  style="font-size:11" width="41%" align="center" class="border-br">No Tanda Pembayaran </td>
                <td  style="font-size:11" width="38%" align="center" class="border-b">Tgl</td>
              </tr>
             
              <tr>
                <td  style="font-size:11" class="border-br">BM</td>
                <td  style="font-size:11" align="center" class="border-br"><?=$kode_bm;?></td>
                <td  style="font-size:11" align="center" class="border-br"><?=$no_tndabm;?></td>
                <td  style="font-size:11" align="center" class="border-b"><?=$tgl_bm;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">Cukai</td>
                <td  style="font-size:11" align="center" class="border-br"><?=$kode_cukai;?></td>
                <td  style="font-size:11" align="center" class="border-br"><?=$no_tndacukai;?></td>
                <td  style="font-size:11" align="center" class="border-b"><?=$tgl_cukai;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">PPN</td>
                <td  style="font-size:11" align="center" class="border-br"><?=$kode_ppn;?></td>
                <td  style="font-size:11" align="center" class="border-br"><?=$no_tndappn;?></td>
                <td  style="font-size:11" align="center" class="border-b"><?=$tgl_ppn;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">PPnBM</td>
                <td  style="font-size:11" align="center" class="border-br"><?=$kode_ppnbm;?></td>
                <td  style="font-size:11" align="center" class="border-br"><?=$no_tndappnbm;?></td>
                <td  style="font-size:11" align="center" class="border-b"><?=$tgl_ppnbm;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">PPh</td>
                <td  style="font-size:11" align="center" class="border-br"><?=$kode_pph;?></td>
                <td  style="font-size:11" align="center" class="border-br"><?=$no_tndapph;?></td>
                <td  style="font-size:11" align="center" class="border-b"><?=$tgl_pph;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-r">PNBP</td>
                <td  style="font-size:11" align="center" class="border-r"><?=$kode_pnbp;?></td>
                <td  style="font-size:11" align="center" class="border-r"><?=$no_tndapnbp;?></td>
                <td  style="font-size:11" align="center"><?=$tgl_pnbp;?></td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td  style="font-size:11" valign="top" class="border-tr">
            <table width="100%" border="0" align="center">
              <tr>
                <td  style="font-size:11" align="center">Pejabat Penerima </td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
              </tr>
              <tr>
                <td  style="font-size:11" align="center">(....................)</td>
              </tr>
            </table>
            </td>
            <td  style="font-size:11" valign="top" class="border-t">
            <table width="100%" border="0" align="center">
              <tr>
                <td  style="font-size:11" align="center">Nama/Stempel Instansi</td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
              </tr>
              <tr>
                <td  style="font-size:11">&nbsp;</td>
              </tr>
            </table>
            </td>
          </tr>
          </tbody>
        </table>
      </div>   
   
    <!--lampiran pertama-->
   <?php
   if(count($BARANG)>1){		
   		echo "<pagebreak>";
		$arrdata = array("loop"=>0);  	
		$this->load->view("pemasukan/bc20/cetak/bc20_lampiran_lanjutan",$arrdata);		
		$loop = floor(count($BARANG)/10);
		$x=10;
		if(count($BARANG)>10){
			echo "<pagebreak>";
			for($i=0;$i<$loop;$i++){
				$arrdata = array("loop"=>$x); 
				$this->load->view("pemasukan/bc20/cetak/bc20_lampiran_lanjutan",$arrdata);		
				$x=$x+10;
			}
		}
   } 
   if (count($DOKUMEN) > 0){
	    echo "<pagebreak>";
  		$this->load->view("pemasukan/bc20/cetak/bc23_lampiran2"); 
   }
   if (count($dtkontainer) > 0){ 
   		echo "<pagebreak />";
   		$this->load->view("pemasukan/bc20/cetak/bc23_lampiran1");   
   }
   ?>
</body>
