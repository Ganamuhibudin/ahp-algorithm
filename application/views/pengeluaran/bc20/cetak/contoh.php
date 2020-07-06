<?php
/*#print_r($DATA);die();
#PARAMETER
//$KODE_ID_TRADER 		= $DATA['KODE_ID_TRADER'];
//$URSTATUS_TRADER 		= $DATA['URSTATUS_TRADER'];
//$KODE_API 				= $DATA['KODE_API'];
$BENDERA 				= $DATA['BENDERA'];
$BENDERAUR 				= $DATA['BENDERAUR'];
//$CIFRP 					= $DATA['CIFRP'];

//header/
$kode_npwp_pemasok 	= $DATA['KODE_NPWP_PEMASOK'];
$kode_npwp_penerima = $DATA['KODE_NPWP_PENERIMA'];
$kantor_pabean 		= $DATA['URAIAN_KPBC'];
$kode_pabean		= $DATA['KD_KPBC'];
$no_pengajuan		= $DATA['NOMOR_AJU'];
$tujuan 			= $DATA['TUJUAN'];
$kondisi 			= $DATA['KONDISI'];
$kriteria 			= $DATA['KRITERIA'];
$jns_brg			= substr($DATA['JNS_BARANG'],1,1);
$tujuan_pengiriman	= substr($DATA['TUJUAN_KIRIM'],1,1); 
$npwp_pemasok		= $DATA['NPWP_PEMASOK'];
$npwp_penerima		= $DATA['NPWP_PENERIMA'];
$niper_pemasok		= $DATA['NIPER_PEMASOK'];
$nama_pemasok		= $DATA['PASOKNAMA'];
$alamat_pemasok		= $DATA['PASOKALMT'];
$neg_pemasok		= $DATA["NEGARA_PEMASOK"];
$nama_penerima		= $DATA['NAMA_PENERIMA'];
$alamat_penerima	= $DATA['ALAMAT_PENERIMA'];
$status_pemasok	    = $DATA['STATUS_PEMASOK'];
$kode_api 			= $DATA['KODE_API'];
$no_api 			= $DATA['APINO'];






$negara_pemasok		= $DATA['URAIAN_NEGARA_PEMASOK'];
$kd_negara_pemasok	= $DATA['NEGARA_PEMASOK'];
$identitas_importir	= $DATA['ID_TRADER'];
//$nama_importir		= $DATA['NAMA_TRADER'];
//$alamat_importir	= $DATA['ALAMAT_TRADER'];
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


$ndpbm				= $DATA['NDPBM'];
$nilai_cif_bb	    = $DATA['NILAI_CIF_BB'];
$cifrp			    = $DATA['CIFRP'];
$harga_penyerahan	= $DATA['HARGA_PENYERAHAN'];
$jml_kemas		= $DATAKMS['JUMLAH_KEMAS'];
$jns_kemasan		= $DATAKMS['KODE_KEMASAN'];
$merk_kemas			= $DATAKMS['MERK_KEMAS'];


$cif				= $DATA['CIF'];
$nama_penimbunan	= $DATA['URAIAN_TIMBUN'];
$kode_penimbunan	= $DATA['KODE_TIMBUN'];
$jns_valuta			= $DATA['URAIAN_VALUTA'];
$kode_valuta		= $DATA['KODE_VALUTA'];
$fob				= $DATA['FOB'];
$freight			= $DATA['FREIGHT'];
$kode_asuransi		= $DATA['KODE_ASURANSI'];
$asuransi			= $DATA['ASURANSI'];
//$jml_kemasan		= $DATAKMS['JUMLAH'];
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
$tgl_pnbp			= "";*/
/*$query1 = $this->db->query("SELECT TIPE_TRADER FROM M_TRADER WHERE ID='".$identitas_importir."'");
$rowQuery1 = $query1->row();
$tipeTrader=$rowQuery1->TIPE_TRADER;
$query1->free_result();
$query2 = $this->db->query("SELECT URAIAN FROM M_TABEL WHERE JENIS in('JENIS_IMPORTIR','JENIS_EKSPORTIR') and KODE='".$tipeTrader."'");
$rowQuery2 = $query2->row();
$uraian=$rowQuery2->URAIAN;
$query2->free_result();*/
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
			
<body style="font-size:10;">
<?php 
if($SURAT['NOMOR_AJU']){
	$this->load->view("surat/surat");	
	if($hasilTotLampiran>0){
		$this->load->view("surat/lampiran");
	}
}
?>  
<div align="center" style="font-size:11"><b>PEMBERITAHUAN BARANG IMPOR ( PIB )</b></div>
<br>
<div align="right" style="font-size:10">BC 2.0</div>
<div class="border-tbrl">
<table  width="100%" height="1028" border="0" cellpadding="0" cellspacing="0" style="font-size:11">
	<tr>
    	<td>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td>
                  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td style="font-size:11" width="21%">Kantor Pabean</td>
                          <td style="font-size:11" width="2%">:</td>
                          <td width="1%">&nbsp;</td>
                          <td width="12%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="11%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="13%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="15%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11">Nomor Pengajuan</td>
                          <td style="font-size:11">:</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11">A. JENIS PIB</td>
                          <td style="font-size:11"><input type="text" name="jns_brg" class="input10" value=""></td>
                          <td style="font-size:11">1.</td>
                          <td style="font-size:11">Biasa</td>
                          <td style="font-size:11">2.</td>
                          <td style="font-size:11">Berkala</td>
                          <td style="font-size:11">3.</td>
                          <td style="font-size:11">Penyelesaian</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11">B. JENIS IMPOR</td>
                          <td style="font-size:11"><input type="text" name="jenis_impor" class="input10" value=""></td>
                          <td style="font-size:11">1.</td>
                          <td style="font-size:11">Untuk Dipakai</td>
                          <td style="font-size:11">2.</td>
                          <td style="font-size:11">Sementara</td>
                          <td style="font-size:11">3.</td>
                          <td style="font-size:11">Reimpor</td>
                          <td style="font-size:11">5.</td>
                          <td style="font-size:11">Pelayanan Segera</td>
                          <td style="font-size:11">6.</td>
                          <td style="font-size:11">Vooruitslag</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" class="border-b">C. CARA PEMBAYARAN</td>
                          <td style="font-size:11" class="border-b"><input type="text" name="tujuan" class="input10" value=""></td>
                          <td style="font-size:11" class="border-b">1.</td>
                          <td style="font-size:11" class="border-b">Biasa/Tunai</td>
                          <td style="font-size:11" class="border-b">2.</td>
                          <td style="font-size:11" class="border-b">Berkala</td>
                          <td style="font-size:11" class="border-b">3.</td>
                          <td style="font-size:11" class="border-b">Dengan Jaminan</td>
                          <td style="font-size:11" class="border-b">9.</td>
                          <td style="font-size:11" class="border-b">Lainya</td>
                          <td class="border-b">&nbsp;</td>
                          <td class="border-b">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td class="border-b">
                  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td  width="100%" colspan="2" class="border-b"><strong>D. DATA PEMBERITAHUAN</strong></td>
                        </tr>
                        <tr>
                          <td width="30%" class="border-r" valign="top">
                          	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="4"><strong>PEMASOK</strong></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" width="%">1.</td>
                                      <td style="font-size:11" width="20%">Nama,Alamat,Negara</td>
                                      <td style="font-size:11" width="2%">&nbsp;</td>
                                      <td style="font-size:11" width="20%"><input type="text" name=""></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" colspan="4"><strong>IMPORTIR</strong></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">2.</td>
                                      <td style="font-size:11">Identitas </td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11">NPWP/Paspor/KTP/Lainnya</td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">3.</td>
                                      <td style="font-size:11">Nama, Alamat</td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">4.</td>
                                      <td style="font-size:11">Status </td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" class="border-b">5.</td>
                                      <td style="font-size:11" class="border-b">API/APIT </td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td colspan="4"><strong>PEMILIK BARANG :</strong></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">2.a</td>
                                      <td style="font-size:11">Identitas</td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11">  NPWP/Paspor/KTP/Lainnya</td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" class="border-b">3.a</td>
                                      <td style="font-size:11" class="border-b">Nama, Alamat</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td colspan="4"><strong>PPJK</strong></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">6.</td>
                                      <td style="font-size:11">NPWP</td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">7.</td>
                                      <td style="font-size:11">Nama,Alamat</td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" class="border-b">8.</td>
                                      <td style="font-size:11" class="border-b">No. &amp; Tgl. NP-PPJK</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b"><input name="input" type="text" size="5">
                                      <input name="input2" type="text" size="10"></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" class="border-b">9.</td>
                                      <td style="font-size:11" class="border-b">Cara Pengangangkutan</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b"><input type="text" name="input3"></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" class="border-b">10.</td>
                                      <td style="font-size:11" class="border-b">Nama Sarana Pengangkut&amp;No.voy/Flght dan Bendera </td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b"><input type="text" name="input4"></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11" class="border-b">11.</td>
                                      <td style="font-size:11" class="border-b">Perkiraan Tgl.Tiba :</td>
                                      <td style="font-size:11" class="border-b">&nbsp;</td>
                                      <td style="font-size:11" class="border-b"><input type="text" name="input5"></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">12.</td>
                                      <td style="font-size:11">Pelabuhan Muat </td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11"><input type="text" name="input6"></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">13.</td>
                                      <td style="font-size:11">Pelabuhan Transit</td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11"><input type="text" name="input7"></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11">14.</td>
                                      <td style="font-size:11">Pelabuhan Bongkar</td>
                                      <td style="font-size:11">&nbsp;</td>
                                      <td style="font-size:11"><input type="text" name="input8"></td>
                                    </tr>
                                  </tbody>
                                </table>
                          </td>
                          <td width="70%">
                          	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                              <tr>
                                <td colspan="10"><strong>F.DI ISI OLEH BEA CUKAI</strong></td>
                              </tr>
                              <tr>
                                <td style="font-size:11" colspan="4">No.&amp;Tgl. Pendaftaran</td>
                                <td style="font-size:11" width="6%">&nbsp;</td>
                                <td style="font-size:11" colspan="5"><input name="input9" type="text" size="16">
                                <input type="text" name="input10"></td>
                              </tr>
                              <tr>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11" width="5%">15.</td>
                                <td style="font-size:11" width="14%">Invoice</td>
                                <td style="font-size:11" width="6%">No.</td>
                                <td style="font-size:11" width="15%">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11" width="10%">&nbsp;</td>
                                <td style="font-size:11" width="7%">&nbsp;</td>
                                <td style="font-size:11" width="10%">&nbsp;</td>
                                <td style="font-size:11" width="14%">Tgl.</td>
                                <td style="font-size:11" width="13%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11">16.</td>
                                <td style="font-size:11">LC</td>
                                <td style="font-size:11">No.</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">Tgl.</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11">17.</td>
                                <td style="font-size:11">BL/AWB</td>
                                <td style="font-size:11">No.</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">Tgl.</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11">18.</td>
                                <td style="font-size:11">BC 1.1.</td>
                                <td style="font-size:11">No.</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">Tgl.</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">Pos.</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">Sub Pos.</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11">19.</td>
                                <td style="font-size:11" colspan="6">Pemenuhan Persyaratan Fasilitas/ Impor</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11" colspan="2"><input name="input11" type="text"></td>
                              </tr>
                              <tr>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">No.Skep.</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11" colspan="2">&nbsp;</td>
                                <td style="font-size:11">Tgl.</td>
                                <td style="font-size:11"><input name="input12" type="text" size="10"></td>
                              </tr>
                              <tr>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size:11" class="border-b">20.</td>
                                <td style="font-size:11" colspan="8" class="border-b">Tempat Penimbuanan </td>
                                <td style="font-size:11" class="border-b"><input name="input13" type="text" size="10"></td>
                              </tr>
                            </tbody>
                          </table>
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td style="font-size:11" width="5%">21.</td>
                              <td style="font-size:11" width="22%">Valuta</td>
                              <td style="font-size:11" width="3%">&nbsp;</td>
                              <td style="font-size:11" width="21%"><input name="input14" type="text" size="10"></td>
                              <td style="font-size:11" width="7%">22.</td>
                              <td style="font-size:11" width="17%">NDPBM</td>
                              <td style="font-size:11" width="4%">&nbsp;</td>
                              <td style="font-size:11" width="21%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                              </tr>
                            <tr>
                              <td style="font-size:11">23.</td>
                              <td style="font-size:11">FOB</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11" colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11" class="border-b">&nbsp;</td>
                                <td style="font-size:11">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="font-size:11">24.</td>
                              <td style="font-size:11">Freight</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">26</td>
                              <td style="font-size:11">Nilai CIF</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="font-size:11">25.</td>
                              <td style="font-size:11">Asuransi LN/DN</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">&nbsp;</td>
                              <td style="font-size:11">Rp.</td>
                              <td style="font-size:11" colspan="2">&nbsp;</td>
                            </tr>
                          </tbody>
                        </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr valign="top">
                  <td valign="top">
                  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td style="font-size:11" width="2%">27.</td>
                          <td style="font-size:11" width="22%">Nomor,Ukuran,dan Tipe Peti Kemas</td>
                          <td style="font-size:11" width="2%">&nbsp;</td>
                          <td style="font-size:11" width="11%">&nbsp;</td>
                          <td style="font-size:11" width="3%">28.</td>
                          <td style="font-size:11" width="23%">Jumlah, Jenis dan Merek kemasan</td>
                          <td style="font-size:11" width="2%">&nbsp;</td>
                          <td style="font-size:11" width="8%" class="border-r">&nbsp;</td>
                          <td style="font-size:11" width="3%">29.</td>
                          <td style="font-size:11" width="15%">Berat Kotor(Kg)</td>
                          <td style="font-size:11" width="9%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" height="21" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">30.</td>
                          <td style="font-size:11" class="border-b">Bearat Bersih(Kg)</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>

                  </td>
                </tr>
                <tr>
                  <td>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr valign="top">
                          <td style="font-size:11" width="2%" class="border-b" valign="top">31.</td>
                          <td style="font-size:11" width="10%" class="border-br" valign="top">No</td>
                          <td style="font-size:11" width="2%" class="border-b" valign="top">32.</td>
                          <td style="font-size:11" width="23%" class="border-br" valign="top">-Pos Tarif/Hs<br>
                          -Uraian barang secara lengkap meliputi jenis,jumlah, merek,tipe, ukuran, dan spesifikasi lainnya <br>
                         - jenis fasilitas
                          </td>
                          <td style="font-size:11" width="2%" class="border-b" valign="top">33.</td>
                          <td style="font-size:11" width="12%" class="border-br" valign="top">Negara Asal</td>
                          <td style="font-size:11" width="2%" class="border-b" valign="top">34.</td>
                          <td style="font-size:11" width="15%" class="border-br" valign="top">Tarif & Fasilitas,<br>Denda/Bunga,<br> -BM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-PPN <br> -Cukai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-PPnBM
                          </td>
                          <td style="font-size:11" width="2%" class="border-b" valign="top">35.</td>
                          <td style="font-size:11" width="15%" class="border-br" valign="top">                          
                          	- Jumlah & Jenis satuan barang<br>
                            - Berat Bersih(Kg)<br>
                            - Jumlah & Jenis Kemasan<br>
                          </ul>
                          </td>
                          <td style="font-size:11" width="2%" class="border-b" valign="top">36.</td>
                          <td style="font-size:11" width="13%" class="border-b" valign="top">Jumlah Nilai CIF</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" height="21" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
               	  <td>
                  	<table cellpadding="0" cellspacing="0" width="100%" border="0">
                      <tbody>
                        <tr>
                          <td align="center" style="font-size:11" width="13%" colspan="2" class="border-br">Jenis Pungutan</td>
                          <td align="center" style="font-size:11" width="24%" class="border-br">Dibayar (Rp)</td>
                          <td align="center" style="font-size:11" width="24%" class="border-br">Ditanggung Pemerintah (Rp)</td>
                          <td align="center" style="font-size:11" width="22%" class="border-br">Ditangguhkan (Rp)</td>
                          <td align="center" style="font-size:11" width="17%" class="border-b">Dibebaskan (Rp)</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" class="border-br">37.</td>
                          <td style="font-size:11" class="border-br">BM</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" class="border-br">38.</td>
                          <td style="font-size:11" class="border-br">Cukai</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" class="border-br">39.</td>
                          <td style="font-size:11" class="border-br">PPN</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" class="border-br">40.</td>
                          <td style="font-size:11" class="border-br">PPnBM</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" class="border-br">41.</td>
                          <td style="font-size:11" class="border-br">PPh</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-size:11" class="border-br">42.</td>
                          <td style="font-size:11" class="border-br">TOTAL</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-br">&nbsp;</td>
                          <td style="font-size:11" class="border-b">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>               
                </tr>
                <tr valign="top">
                   <td>
                  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr valign="top">
                          <td style="font-size:11" width="50%" align="center" class="border-r">
                            <p>E.Dengan ini saya Menyatakan bertanggung jawab atas kebenaran<br>
                          Hal-hal yang di beritahukan dalam dokumen ini.<br>
                          ......,Tgl......., 20..<br>
                          Importir/PPJK<BR>
                          </p>
                          <br>
                          <br>
                            <br>
                          (.....................)                          </p></td>
                          <td style="font-size:11" width="50%">
                          	<table width="100%" border="1" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td>
                          				<strong>G. UNTUK PEMBAYARAN/JAMINAN</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table align="center" width="70%" border="0" cellpadding="0" cellspacing="0">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:11" width="4%">a.</td>
                                              <td style="font-size:11" width="17%">Pembayaran</td>
                                              <td style="font-size:11" width="13%"><input name="input15" type="text" size="10"></td>
                                              <td style="font-size:11" width="66%">1.Bank ; 2.Pos; 3.Kantor Pabean</td>
                                            </tr>
                                            <tr>
                                              <td style="font-size:11" height="24">b.</td>
                                              <td style="font-size:11" >Jaminan</td>
                                              <td style="font-size:11"><input name="input16" type="text" size="10"></td>
                                              <td style="font-size:11">1.Tuani; 2.Bank Garansi; 3.Customs Bond; 4.Lainnya</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                 </tr>
                                 <tr>
                                 	<td>
                                    	 <table width="100%" border="1" cellpadding="2" cellspacing="2">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:11" width="40%" class="border-br border-t">&nbsp;</td>
                                              <td style="font-size:11" width="40%" class="border-br border-t" >Nomor</td>
                                              <td style="font-size:11" width="20%" class="border-b border-t">Tgl</td>
                                            </tr>
                                            <tr>
                                              <td style="font-size:11" class="border-br">Pembayaran</td>
                                              <td style="font-size:11" class="border-br">&nbsp;</td>
                                              <td style="font-size:11" class="border-b">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td style="font-size:11" class="border-br">Jaminan</td>
                                              <td style="font-size:11" class="border-br">&nbsp;</td>
                                              <td style="font-size:11" class="border-b">&nbsp;</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </td>
                                 </tr>
                                 <tr>
                                 	<td>
                                    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                          <tbody>
                                            <tr align="center" valign="top">
                                              <td style="font-size:11" width="45%" align="center">Penjabat Penerima
                                              <br>
                                              <br>
                                              <br>
                                              (.....................) </p></td>
                                              <td style="font-size:11" width="55%" align="center"> Nama/Stempel Instansi</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </td>
                                 </tr>
                              </table>                            
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
    		</table>
        </td>
    </tr>
</table>
</div>
<!--lampiran pertama-->
   <?php
  /* if(count($BARANG)>1){		
   		echo "<pagebreak>";
		$arrdata = array("loop"=>0);  	
		$this->load->view("pengeluaran/bc20/cetak/bc20_lampiran_lanjutan",$arrdata);		
		$loop = floor(count($BARANG)/10);
		$x=10;
		if(count($BARANG)>10){
			echo "<pagebreak>";
			for($i=0;$i<$loop;$i++){
				$arrdata = array("loop"=>$x); 
				$this->load->view("pengeluaran/bc20/cetak/bc20_lampiran_lanjutan",$arrdata);		
				$x=$x+10;
			}
		}
   } 
   if (count($DOKUMEN) > 0){
	    echo "<pagebreak>";
  		$this->load->view("pengeluaran/bc20/cetak/bc23_lampiran2"); 
   }
   if (count($dtkontainer) > 0){ 
   		echo "<pagebreak />";
   		$this->load->view("pengeluaran/bc20/cetak/bc23_lampiran1");   
   }*/
   ?>
</body>