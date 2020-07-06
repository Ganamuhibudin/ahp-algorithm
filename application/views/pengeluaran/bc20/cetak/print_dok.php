<?php
#print_r($DATA);die();
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
$tgl_pnbp			= "";
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
			
<body style="font-size:11;">
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
        <table width="100%" height="1028" border="0" cellpadding="0" cellspacing="0" style="font-size:11">
        <tbody>
          <tr>
            <td  style="font-size:11" colspan="3" class="border-b">
                <table width="100%" border="0"  style="margin-top:-7px">
                <tbody>
                <tr>
                  <td  style="font-size:11" width="19%">Kantor Pelayanan Bea dan Cukai</td>
                  <td  style="font-size:11" width="45%">: <?=$DATA['URAIAN_KPBC'];?></td>
                  <td  style="font-size:11" width="21%"  align="left"><input type="text" name="kode_pabean" class="input50" value="<?=$DATA["KODE_KPBC"];?>"></td>
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
                        <td  style="font-size:11" width="24"><input type="text" name="jns_brg" class="input10" value="<?=$DATA["JNPIB"];?>"></td>
                        <td  style="font-size:11" width="115">1. Biasa</td>
                        <td  style="font-size:11" width="115">2. Berkala</td>
                        <td  style="font-size:11" width="115">3. Penyelesaian</td>
                        <td  style="font-size:11" width="115">&nbsp;</td>
                        <td  style="font-size:11" width="115">&nbsp;</td>
                        <td  style="font-size:11" width="115">&nbsp;</td>
                      </tr>
                      <tr>
                        <td  style="font-size:11" valign="top">B.</td>
                        <td  style="font-size:11" valign="top">Jenis Impor</td>
                        <td  style="font-size:11" valign="top" width="24">
                        <input type="text" name="jenis_impor" class="input10" value="<?=$DATA["JNIMP"];?>"></td>
                        <td  style="font-size:11">1. Untuk Dipakai</td>
                        <td  style="font-size:11">2. Sementara</td>
                        <td  style="font-size:11">3.Reimpor</td>
                        <td  style="font-size:11">5.Pelayanan Segera</td>
                        <td  style="font-size:11">6. Vooruitslag</td>
                        <td  style="font-size:11">&nbsp;</td>
                  	</tr>
   					<tr>
                        <td  style="font-size:11" valign="top">C.</td>
                        <td  style="font-size:11" valign="top">Cara Pembayaran</td>
                        <td  style="font-size:11" valign="top" width="24">
                        <input type="text" name="tujuan" class="input10" value="<?=$DATA["CRBYR"];?>"></td>
                        <td  style="font-size:11">1. Biasa/Tunai</td>
                        <td  style="font-size:11">2. Berkala</td>
                        <td  style="font-size:11">3. Dengan Jaminan</td>
                        <td  style="font-size:11">9. Lainnya</td>
                        <td  style="font-size:11">&nbsp;</td>
                        <td  style="font-size:11">&nbsp;</td>
               		</tr> 
                  </table></td>
                </tr>
            </tbody>
            </table>
            </td>
          </tr>
          <tr>
          	<td colspan="3" class="border-b">
          		<table width="100%">   
                	<tbody>   
                    <tr>      
              		<td width="7%" style="font-size:11" ><b>D.</b></td>
                	<td style="font-size:11"><b><u>DATA PEMBERITAHUAN :</u></b></td>
                    </tr>
                    </tbody>
                </table>
             </td>
          </tr>
          <tr>
            <td  style="font-size:11" width="33%" class="border-br">
            <table width="100%" border="0">
            <tbody>
              <tr>
                <td  style="font-size:11" colspan="3"><b><u>PEMASOK :</u></b></td>
              </tr>
                <tr>
                  <td  style="font-size:11" width="7%" valign="top">1. </td>
                  <td  style="font-size:11" width="93%">Nama, Alamat, Negara :</td>
                </tr>
                <tr>
                	<td style="font-size:11">&nbsp;</td>
                    <td style="font-size:11" colspan="3"><?=$nama_pemasok;?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3"><?=$alamat_pemasok;?>, <?=$neg_pemasok;?></td>
                </tr>
            </tbody>
            </table>   
            </td>
            <td  style="font-size:11" colspan="2" class="border-b" valign="top">
            	<table width="100%" border="0">
                    <tbody>
                        <tr>
                            <td  style="font-size:11" colspan="3"><b>F. <u>DIISI OLEH BEA DAN CUKAI</u> </b></td>
                        </tr>                
                        <tr>
                          <td width="24%" height="28"  style="font-size:11">No. &amp; Tgl. Pendaftaran : </td>
                            <td width="76%" colspan="2" align="right"  style="font-size:11"><input name="no_daftar" type="text" class="input50" value="<?=$no_daftar;?>">
                        &nbsp;
                            <input type="text" name="tgl_daftar" class="input50" value="<?= $this->fungsi->dateformat($tgl_daftar);?>"></td>
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
                  <td  style="font-size:10" colspan="8"><b><u>IMPORTIR</u></b></td>
                </tr>
                <tr>
                  <td width="2%"  style="font-size:11">2. </td>
                  <td  style="font-size:11" width="15%">Identitas</td>
                  <td colspan="6"  style="font-size:11">: <?=$DATA["UR_IMP"]." / ".$DATA["IMPID"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$this->fungsi->FormatNPWP($DATA["IMPNPWP"]);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">3. </td>
                  <td  style="font-size:11">Nama, Alamat</td>
                  <td  style="font-size:11" colspan="6">: <?=$DATA["IMPNAMA"]." , ".$DATA["IMPALMT"];?></td>
                </tr>
                <tr>
                  <td  style="font-size:11" colspan="8">&nbsp;</td>
                </tr>
                <tr>
                  <td  style="font-size:11">4. </td>
                  <td  style="font-size:11" width="15%">STATUS</td>
                  <td  style="font-size:11" width="19%" colspan="2"> : <?=$DATA["IMPSTS"];?></td>
                 <td width="3%"  style="font-size:11">5. </td>
                  <td  style="font-size:11" width="20%"><?=$DATA["UR_API"]?></td>
                  <td  style="font-size:11" width="3%" align="right">:
                  </td>
                  <td  style="font-size:11" width="17%"> <?=$DATA["APIKD"];?>/&nbsp;<?=$no_api;?></td>
                </tr> 
                
            </tbody>
            </table>
            <td  style="font-size:11" colspan="2" rowspan="2"  class="border-b" valign="top">
            <table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="2%">15.</td>
                  <td  style="font-size:11" width="20%">Invoice :</td>                  
                  <td width="10%"  style="font-size:11">No. </td>
                  <td  style="font-size:11" colspan="3" width="34%"><?=$no_keputusan;?></td>
                  <td width="17%"  style="font-size:11">Tgl.</td>
                  <td width="17%"  style="font-size:11"><?=$this->fungsi->dateformat($tgl_invoice);?></td>
                </tr>
                <tr>
               		<td  style="font-size:11"></td>
                	<td  style="font-size:11"></td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
        </tr>
        <tr>
                  <td  style="font-size:11">16.</td>
                  <td  style="font-size:11">LC :</td>                  
                  <td style="font-size:11">No. </td>
                  <td  style="font-size:11" colspan="3"><?=$no_keputusan;?></td>
                  <td style="font-size:11">Tgl.</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($tgl_invoice);?></td>
              </tr>
                <tr>
               		<td  style="font-size:11"></td>
                	<td  style="font-size:11"></td>
                  <td style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3">&nbsp;</td>
                  <td style="font-size:11">&nbsp;</td>
                  <td style="font-size:11">&nbsp;</td>
        </tr> 
        <tr>
                  <td  style="font-size:11">17.</td>
                  <td  style="font-size:11" >BL/AWB :</td>                  
                  <td  style="font-size:11">No. </td>
                  <td  style="font-size:11" colspan="3"><?=$no_keputusan;?></td>
                  <td  style="font-size:11">Tgl.</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($tgl_invoice);?></td>
              </tr>
                <tr>
               <td  style="font-size:11"></td>
                <td  style="font-size:11"></td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" colspan="3" >&nbsp;</td>
                  <td style="font-size:11">&nbsp;</td>
                  <td style="font-size:11">&nbsp;</td>
        </tr> 
        <tr>
                  <td  style="font-size:11" >18.</td>
                  <td  style="font-size:11" >BC 1.1 :</td>                  
                  <td   style="font-size:11">No. </td>
                  <td  style="font-size:11" colspan="3" ><?=$no_keputusan;?></td>
                  <td  style="font-size:11">Tgl.</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($tgl_invoice);?></td>
              </tr>
                <tr>
               <td  style="font-size:11"></td>
                <td  style="font-size:11"></td>
                  <td  style="font-size:11">Pos.</td>
                  <td  style="font-size:11" colspan="3" >&nbsp;</td>
                  <td  style="font-size:11">Sub Pos</td>
                  <td  style="font-size:11">&nbsp;</td>
        </tr>
                       <!-- <tr>
                      <td  style="font-size:11">15.</td>
                  <td  style="font-size:11">Tgl.Jatuh Tempo :</td>
                  <td  style="font-size:11"><?=$this->fungsi->dateformat($DATA['TANGGAL_PENUTUP']);?></td>
                  <td  style="font-size:11" width="12%"></td>
                  <td  style="font-size:11" width="9%"></td>
                  <td  style="font-size:11" width="1%"></td>
                  </tr>-->
            </table>
            </td>
          </tr>
           <?php /*?><?php */?>
           <tr>
            <td  style="font-size:11" class="border-br" valign="top">
            	<table width="100%" border="0" >
            <tbody>
                <tr>
                  <td  style="font-size:10" colspan="8"><b><u>PEMILIK BARANG</u></b></td>
                </tr>
                <tr>
                  <td width="5%"  style="font-size:11">2a. </td>
                  <td  style="font-size:11" width="30%">Identitas</td>
                  <td colspan="6" width="65%"  style="font-size:11">: <?=$DATA["UR_IMP"]." / ".$DATA["IMPID"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$this->fungsi->FormatNPWP($DATA["IMPNPWP"]);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">3a. </td>
                  <td  style="font-size:11">Nama, Alamat</td>
                  <td  style="font-size:11" colspan="6">: <?=$DATA["IMPNAMA"]." , ".$DATA["IMPALMT"];?></td>
                </tr>
                <tr>
                  <td  style="font-size:11" colspan="8">&nbsp;</td>
                </tr>
                <!--<tr>
                  <td  style="font-size:11">4. </td>
                  <td  style="font-size:11" width="18%">STATUS</td>
                  <td  style="font-size:11" width="19%" colspan="2"> : <?=$DATA["IMPSTS"];?></td>
                 <td width="6%"  style="font-size:11">5. </td>
                  <td  style="font-size:11" width="20%"><?=$DATA["UR_API"]?></td>
                  <td  style="font-size:11" width="3%" align="right">:
                  </td>
                  <td  style="font-size:11" width="17%"> <?=$DATA["APIKD"];?>/&nbsp;<?=$no_api;?></td>
                </tr>--> 
                
            </tbody>
            </table>
            </td>
           </tr>
           <tr>
            <td  style="font-size:11" class="border-br" valign="top">
            <table width="160%" border="0" >
            <tbody>
                <tr>
                  <td  style="font-size:11" colspan="6" ><b><u>PPJK :</u></b></td>
                </tr>
                <tr>
                  <td  style="font-size:11" width="40%">6.</td>
                  <td  style="font-size:11" width="160%" colspan="2">NPWP :</td>
                </tr>
                <tr>
                  <td  style="font-size:11">7.</td>
                  <td  style="font-size:11" colspan="2">Nama, Alamat :</td>
                </tr>
                <tr>
                  <td  style="font-size:11" colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td  style="font-size:11">8.</td>
                  <td  style="font-size:11" width="40%">No. & Tgl Surat Izin PPJK : </td>
               <td  style="font-size:11" width="120%" align="right">  
           <input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>">     
          <input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                </tr>
            <tr>
                  <td width="3%"  style="font-size:11"></td>
                  <td  style="font-size:11" width="60%"> </td>
                  <td  style="font-size:11" width="37%" align="right">
                  </td>
                </tr>                
            </tbody>
            </table>
             <td  style="font-size:11" colspan="2"  class="border-b" valign="top">
            <table width="100%" border="0">
               <tr>
                  <td  style="font-size:11" width="2%">19.</td>
                  <td  style="font-size:11" width="20%">Pemenuhan persyaratan/Fasilitas Impor :</td>
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
                <tr>
                  <td  style="font-size:11" colspan="5"><table width="100%" border="0">
                    <tbody>
                      <tr>
                        <td width="15%">&nbsp;</td>
                        <td width="15%">No.Skep</td>
                        <td width="20%">&nbsp;</td>
                        <td width="15%">Tgl.</td>
                        <td width="20%">&nbsp;</td>
                        <td width="15%">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
            </table>
            </td> 
           <?php /*?><?php */?>         
          </tr>           
           
           <tr>
            <td  style="font-size:11" class="border-br" valign="top">
            	<table width="100%" border="0" >
                    <tbody>
                        <tr>
                          <td width="3%"  style="font-size:11">9. </td>
                          <td  style="font-size:11" width="37%">Cara Pengangkutan :</td>
                          <td colspan="6" width="70%" align="right"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                        </tr>                        
                    </tbody>
                 </table>
            </td>
            <td  style="font-size:11" colspan="2"  class="border-b" valign="top">
            	<table width="100%" border="0" >
                    <tbody>
                        <tr>
                          <td width="3%"  style="font-size:11">20. </td>
                          <td  style="font-size:11" width="29%">Tempat Penimbunan</td>
                          <td colspan="6" width="70%" align="right"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
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
                          <td width="2%"  style="font-size:11">10. </td>
                          <td  style="font-size:11" width="34%">Nama Sarana Pengangkut &amp; No.Voy/Flight dan Bendahara</td>
                          <td colspan="6" width="64%" align="right"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                        </tr>                        
                    </tbody>
                 </table>
            </td>
            <td  style="font-size:11" colspan="2"  class="border-b" valign="top">
            	<table width="100%" border="0" >
                    <tbody>
                        <tr>
                          <td width="2%"  style="font-size:11">21. </td>
                          <td  style="font-size:11" width="30%">Valuta :</td>
                          <td colspan="6" width="28%" align="center"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                          <td width="2%"  style="font-size:11">22. </td>
                          <td  style="font-size:11" width="30%">NDPBM :</td>
                          <td colspan="6" width="28%" align="right"  style="font-size:11">&nbsp;</td>
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
                          <td width="3%"  style="font-size:11">11. </td>
                          <td  style="font-size:11" width="33%">Perkiraan Tgl.Tiba :</td>
                          <td colspan="6" width="60%" align="right"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                        </tr>                        
                    </tbody>
                 </table>
            </td>
            <td  style="font-size:11" colspan="2"  class="border-b" valign="top">
            	<table width="100%" border="0" >
                    <tbody>
                        <tr>
                          <td width="20%"  style="font-size:11">23. </td>
                          <td  style="font-size:11" width="23%">FOB</td>
                          <td colspan="6" width="60%" align="right"  style="font-size:11">&nbsp;</td>
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
                          <td width="3%"  style="font-size:11">12. </td>
                          <td  style="font-size:11" width="33%">Pelabuhan Muat </td>
                          <td colspan="6" width="60%" align="right"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                        </tr>   
                        <tr>
                          <td  style="font-size:11">13. </td>
                          <td  style="font-size:11">Pelabuhan Transit :</td>
                          <td colspan="6" align="right"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                        </tr>
                        <tr>
                          <td style="font-size:11">15. </td>
                          <td  style="font-size:11">Pelabuhan Bongkar :</td>
                          <td colspan="6" align="right"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                        </tr>                     
                </tbody>
                 </table>
            </td>
            <td  style="font-size:11" colspan="2"  class="border-b" valign="top">
            	<table width="100%" border="0" >
                    <tbody>
                        <tr>
                          <td width="2%"  style="font-size:11">24. </td>
                          <td  style="font-size:11" width="20%">Freight :</td>
                          <td colspan="6" width="23%" align="center"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                          <td width="2%"  style="font-size:11">26. </td>
                          <td  style="font-size:11" width="20%">Nilai CIF:</td>
                          <td colspan="6" width="23%" align="center"  style="font-size:11">&nbsp;</td>
                        </tr> 
                        <tr>
                          <td  style="font-size:11">25. </td>
                          <td  style="font-size:11" >Asuransi LN/DN:</td>
                          <td colspan="6"  align="center"  style="font-size:11"><input type="text" name="no_voyage" class="input40" value="<?=$BENDERA;?>"></td>
                          <td   style="font-size:11">&nbsp;</td>
                          <td  style="font-size:11" >&nbsp;</td>
                          <td colspan="6" align="right"  style="font-size:11">&nbsp;</td>
                        </tr> 
                        <tr>
                          <td  style="font-size:11">&nbsp;</td>
                          <td  style="font-size:11" >&nbsp;</td>
                          <td colspan="6"  align="center"  style="font-size:11">&nbsp;</td>
                          <td   style="font-size:11">Rp.</td>
                          <td  style="font-size:11" >&nbsp;</td>
                          <td colspan="6" align="right"  style="font-size:11">&nbsp;</td>
                        </tr>                      
                    </tbody>
                 </table>
            </td>            
          </tr>           
          <tr>
            <td  style="font-size:11" colspan="2" class="border-br" valign="top"><table width="100%" border="0">
              <tr>
                <td  style="font-size:11"><table width="100%" border="0">
                  <tr>
                    <td  style="font-size:11" width="2%" valign="top">27.</td>
                    <td  style="font-size:11" width="44%" valign="top">Nomer,Ukuran, dan Tipe Peti Kemas :</td>
                    <td  style="font-size:11" width="1%" valign="top">&nbsp;</td>
                    <td  style="font-size:11" width="2%" valign="top">28.</td>
                    <td  style="font-size:11" width="29%" valign="top">Jumlah,  Jenis dan Merek Kemasan : </td>
                    <td  style="font-size:11" width="16%" valign="top">&nbsp;</td>
                    <td  style="font-size:11" width="6%" valign="top" align="right"><input type="text" name="jns_kemasan" class="input40" value="<?=$jns_kemasan;?>"></td>
                  </tr>
                  <tr>
                    <td  style="font-size:11">&nbsp;</td>
                    <td  style="font-size:11"><?=$KONTAINER;?></td>
                    <td  style="font-size:11">&nbsp;</td>
                    <td  style="font-size:11">&nbsp;</td>
                    <td  style="font-size:11"><?=$jml_kemasan;?>
                      <?=$URAIAN_KEMASAN;?></td>
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
              </tr>
            </table></td>
            <td width="24%" class="border-b"  style="font-size:11">
            <table width="100%" border="0">
                <tr>
                  <td  style="font-size:11" width="12%">22.</td>
                  <td  style="font-size:11" width="54%">Berat Kotor (kg) </td>
                  <td  style="font-size:11" width="34%">:</td>
                </tr>
                <tr>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11">&nbsp;</td>
                  <td  style="font-size:11" align="right"><?=$this->fungsi->FormatRupiah($berat_kotor,4);?></td>
                </tr>
                <tr>
                  <td  style="font-size:11">23.</td>
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
            <td style="font-size:11" colspan="3" class="border-b">
            <table cellpadding="5" cellspacing="0" width="100%" border="0">
              <tr>
                <td width="15%" valign="top" class="border-br"  style="font-size:11">31.<br><br>No </td>
                <td width="36%" valign="top" class="border-br"  style="font-size:11">32. &nbsp;- Pos Tarif/HS<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Uraian barang secara lengkap meliputi <br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;jenis, jumlah, merk, tipe, ukuran,spesifikasi<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lain nya<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Jenis fasilitas</td>
                <td width="15%" valign="top" class="border-br"  style="font-size:11">33. &nbsp;Negara Asal</td>
                <td width="19%" valign="top" class="border-br"  style="font-size:11">34. &nbsp;Tarif & Fasilitas,<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- BM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- PPN <br> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Cukai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- PPnBM<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- PPH</td>
                <td width="15%" valign="top" class="border-br"  style="font-size:11">35. &nbsp;
                  - Jumlah & Jenis Satuan <br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;barang<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Berat Bersih (kg)<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Jumlah & Jenis Kemasan</td>
                <td width="15%" valign="top" class="border-b"  style="font-size:11">36. Jumlah Nilai CIF</td>
              </tr>      
              <tr>
                <td width="15%" valign="top" class="border-br"  style="font-size:11">31.</td>
                <td width="36%" valign="top" class="border-br"  style="font-size:11">32.</td>
                <td width="19%" valign="top" class="border-br"  style="font-size:11">33.</td>
                <td width="19%" valign="top" class="border-br"  style="font-size:11">34.</td>
                <td width="15%" valign="top" class="border-br"  style="font-size:11">35.</td>
                <td width="15%" valign="top" class="border-b"  style="font-size:11">36.</td>
              </tr>            
			 
            </table>
          <table cellpadding="0" cellspacing="0" width="100%" border="0">
               <tr>
                <td  style="font-size:11" colspan="2" align="center" class="border-br">Jenis Pungutan </td>
                <td  style="font-size:11" width="60%" align="center" class="border-br">Dibayar<br>(Rp.)</td>
               	<td  style="font-size:11" width="38%" align="center" class="border-br">Ditanggung Pemerintah<br>(Rp.)</td>
                <td  style="font-size:11" width="60%" align="center" class="border-br">Ditangguhkan<br>(Rp.)</td>
                <td  style="font-size:11" width="20%" align="center" class="border-b">Dibebaskan<br>(Rp.)</td>
                
              </tr>
              <tr>
                <td  style="font-size:11" width="2%" class="border-br">37.</td>
                <td  style="font-size:11" width="20%" class="border-br">BM</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$bm_bayar;?></td>
                <td  style="font-size:11" class="border-br">&nbsp;</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$bm_tangguh;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$bm_bebas;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">38.</td>
                <td  style="font-size:11" class="border-br">Cukai</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$cukai_bayar;?></td>
                <td  style="font-size:11" class="border-br">&nbsp;</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$cukai_tangguh;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$bm_bebas;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">39.</td>
                <td  style="font-size:11" class="border-br">PPN</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppn_bayar;?></td>
                <td  style="font-size:11" class="border-br">&nbsp;</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppn_tangguh;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$bm_bebas;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">40.</td>
                <td  style="font-size:11" class="border-br">PPnBM</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppnbm_bayar;?></td>
                <td  style="font-size:11" class="border-br">&nbsp;</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppnbm_tangguh;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$bm_bebas;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-br">41.</td>
                <td  style="font-size:11" class="border-br">PPh</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppnbm_bayar;?></td>
                <td  style="font-size:11" class="border-br">&nbsp;</td>
                <td  style="font-size:11" align="right" class="border-br"><?=$ppnbm_tangguh;?></td>
                <td  style="font-size:11" align="right" class="border-b"><?=$bm_bebas;?></td>
              </tr>
              <tr>
                <td  style="font-size:11" class="border-r">42.</td>
                <td  style="font-size:11" class="border-r">TOTAL</td>
                <td  style="font-size:11" align="right" class="border-r"><?=$total_bayar;?></td>
                <td  style="font-size:11" class="border-r">&nbsp;</td>
                 <td align="right" class="border-r"  style="font-size:11"><?=$total_tangguh;?></td>
                 <td  style="font-size:11" align="right"><?=$bm_bebas;?></td>
              </tr>             
              </table>
            </td>
            </tr>
            <tr>
            <td width="33%" valign="top" class="border-br" rowspan="3"  style="font-size:11">
                <table width="180%" border="0" >            
                   <tr>
                    <td colspan="3" align="center" style="font-size:11" ><strong>E. </strong>Dengan ini saya menyatakan bertanggung jawab atas kebenaran </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center"  style="font-size:11">hal-hal yang diberitahukan dalam dokumen ini. </td>
                  </tr>
                  <tr>
                    <td width="70%"  style="font-size:11">&nbsp;</td>
                    <td width="80%"  style="font-size:11">&nbsp;</td>
                    <td width="70%"  style="font-size:11">&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="font-size:11" colspan="3" align="center"><?=$DATA['KOTA_TTD'].', tgl '.$this->fungsi->dateformat($DATA['TANGGAL_TTD']);?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center"  style="font-size:11">Importir/ PPJK</td>
                  </tr>
                  <tr>
                    <td style="font-size:11">&nbsp;</td>
                    <td style="font-size:11">&nbsp;</td>
                    <td style="font-size:11">&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="font-size:11">&nbsp;</td>
                    <td style="font-size:11">&nbsp;</td>
                    <td style="font-size:11">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center"  style="font-size:11">(....................)</td>             
                  </tr>
                  <tr>
                    <td  style="font-size:11" colspan="3" align="center"><?=$DATA['NAMA_TTD'];?></td>
                  </tr>
                </table> 
            <!--<table>
            <tr>
              	<td style="font-size:11" ><b>G.</b></td>
                <td style="font-size:11" colspan="2"><b><u>UNTUK PEJAJABAT BC</u></b></td>
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
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11">&nbsp;</td>
              </tr>
              
              <tr>
                <td  style="font-size:11">&nbsp;</td>
                <td  style="font-size:11" colspan="2">Tanggal Pemusnahan :</td>
              </tr>
   </table>-->      
   		</td>     
          <td  style="font-size:11" colspan="2" class="border-b" valign="top">
              <table width="100%" border="0">
                <tbody>
                   <tr>
                    <td  style="font-size:11" colspan="4"><b>G. <u>UNTUK PEMBAYARAN / JAMINAN</u></b></td>
                  </tr>
                  <tr>
                    <td  style="font-size:11" width="2%">a.</td>
                    <td  style="font-size:11" width="10%">Pembayaran</td>
                    <td width="5%" align="right"  style="font-size:11"><input type="text" name="no_voyage2" class="input10" value="<?=$BENDERA;?>"></td>
                    <td  style="font-size:11" width="83%">1.Bank &nbsp; 2.Pos; &nbsp; 3.Kantor Pabean; &nbsp; </td>
                  </tr>
                 <tr>
                    <td  style="font-size:11">b.</td>
                   <td  style="font-size:11">Jaminan</td>
                    <td  align="right"  style="font-size:11"><input type="text" name="no_voyage3" class="input10" value="<?=$BENDERA;?>"></td>
                    <td  style="font-size:11">1.Tunai; &nbsp; 2.Bank Garansi; &nbsp; 3.Customs Bond; &nbsp; 4.Lainnya &nbsp; </td>
                  </tr> 
                </table>
          </td>
         </tr>
         <tr>
           <td  style="font-size:11" colspan="2" class="" valign="top">
            <table width="100%" border="0"  cellpadding="2" cellspacing="0">
              <tr>
              	<td width="10%" class="border-b">&nbsp;</td>
                <td  style="font-size:11" width="30%" align="center" class="border-br">&nbsp;</td>
                <td  style="font-size:11" width="35%" align="center" class="border-br">Nomor </td>
                <td  style="font-size:11" width="60%" align="center" class="border-b">Tgl</td>
              </tr>
             
              <tr>
              	<td width="10%" class="border-b">&nbsp;</td>
                <td  style="font-size:11" class="border-br">Pembayaran</td>
                <td  style="font-size:11" align="center" class="border-br"><?=$kode_bm;?></td>
                <td  style="font-size:11" align="center" class="border-b"><?=$tgl_bm;?></td>
              </tr>
              <tr>
              <td width="10%" class="border-b">&nbsp;</td>
                <td  style="font-size:11" class="border-br">Jaminan</td>
                <td  style="font-size:11" align="center" class="border-br"><?=$kode_cukai;?></td>
                <td  style="font-size:11" align="center" class="border-b"><?=$tgl_cukai;?></td>
              </tr>
            </table>
            </td>
          </tr>  
          <tr>
           <td valign="top" style="font-size:11" colspan="2" class="border-b">
           	<table width="100%">
            	<tr>
                	<td style="font-size:11" width="70%" valign="top">
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
            	<td  style="font-size:11"  width="70%" valign="top" >
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
           </table>
         </td>
        </tr>
          
          
          
          
          
                 </table> 
            
                      
        </table>
</div>   
   
<!--lampiran pertama-->
   <?php
   if(count($BARANG)>1){		
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
   }
   ?>
</body>
