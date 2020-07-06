<?php
#PARAMETER 
$no_pengajuan   = $this->fungsi->FormatAju($DATA['NOMOR_AJU']);
$kode_kantor_pabean = $DATA['KODE_KPBC'];
$kantor_pabean  = $DATA['URAIAN_KPBC'];
$jenis_ekspor   = $DATA['URJENIS_EKSPOR'];
$no_pendaftaran = $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar     = $DATA['TANGGAL_PENDAFTARAN'];
$kategori_ekspor= $DATA['URKATEGORI_EKSPOR'];
$cara_perdagangan = $DATA['URCARA_DAGANG'];
$cara_pembayaran    = $DATA['URCARA_BAYAR'];
$no_bc          = $DATA['NOMOR_BC11'];
$tgl_bc         = ($DATA['TANGGAL_BC11']=='0000-00-00')?'':$DATA['TANGGAL_BC11'];
$no_pos         = $DATA['NOMOR_POS'];
$no_subpos      = $DATA['SUB_POS'];

$tipeid_pengusaha= $DATA['KODE_ID_TRADERUR'];
$npwp_pengusaha = $DATA['ID_TRADER'];
$nama_pengusaha = $DATA['NAMA_TRADER'];
$alamat_pengusaha= $DATA['ALAMAT_TRADER'];
$niper          = $DATA['NIPER'];
$status         = $DATA['STATUS_TRADER']." - ".$DATA['URSTATUS_TRADER'];
$no_tdp         = $DATA['NOMOR_TDP'];
$tgl_tdp        = $DATA['TANGGAL_TDP'];
$nama_penerima  = $DATA['NAMA_PENERIMA'];
$alamat_penerima= $DATA['ALAMAT_PENERIMA'];
$cara_angkut    = $DATA['URAIAN_MODA'];
$nama_angkut    = $DATA['NAMA_ANGKUT'];
$nomor_angkut   = $DATA['NOMOR_ANGKUT'];
$bendera_angkut = $DATA['URAIAN_BENDERA'];
$tgl_perkiraan_ekspor   = $DATA['TANGGAL_EKSPOR'];
$kode_pelab_muat_asal = $DATA['PELABUHAN_MUAT'];
$urkode_pelab_muat_asal = $DATA['URAIAN_MUAT'];
$kode_pelab_muat_ekspor = $DATA['PELABUHAN_MUAT_EKSPOR'];
$urkode_pelab_muat_ekspor = $DATA['URAIAN_MUAT_EKSPOR'];
$kode_pelab_transit = $DATA['PELABUHAN_TRANSIT'];
$urkode_pelab_transit = $DATA['URAIAN_TRANSIT'];
$kode_pelab_bongkar = $DATA['PELABUHAN_BONGKAR'];
$urkode_pelab_bongkar = $DATA['URAIAN_BONGKAR'];
$no_invoice     = $DATADOK['NOMOR_INVOICE'];
$tgl_invoice    = $DATADOK['TANGGAL_INVOICE'];
$no_packing     = $DATADOK['NOMOR_PACKING_LIST'];
$tgl_packing    = $DATADOK['TANGGAL_PACKING_LIST'];
$lokasi_pemeriksaan = $DATA['LOKASI_PERIKSA'];
$kantor_pabean_pemeriksa = $DATA['URAIAN_KPBC_PERIKSA'];
$kodenegara_tujuan_ekspor = $DATA['NEGARA_TUJUAN'];
$negara_tujuan_ekspor = $DATA['URAIAN_NEGARA_TUJUAN'];
$freight        = $DATA['FREIGHT'];
$asuransi       = $DATA['ASURANSI'];
$fob            = $DATA['FOB'];

if($DATACNT['JUMLAH']!=''){
    $jml_petikemas = $DATACNT['JUM20']." X 20 Feet; ".$DATACNT['JUM40']." X 40 Feet;";
    if($DATACNT['JUMLAH']>1){
        $no_petikemas = " ==Lihat Lembar Lanjutan==";
        $stat_petikemas = "-";
    }else{  
        $stat_petikemas = $DATACNT['URTIPE'];
        $no_petikemas   = substr($DATACNT['NOMOR'],0,4).'-'.substr($DATACNT['NOMOR'],4,trim(strlen($DATACNT['NOMOR']))).', '.$DATACNT['NOMOR_SEGEL'];   }
}else{
    $jml_petikemas  = "1 Peti Kemas/Kontainer"; 
    $no_petikemas = "-";
    $stat_petikemas = "-";
}

$volume         = $DATA['VOLUME'];
$berat_kotor    = $DATA['BRUTO'];
$berat_bersih   = $DATA['NETTO'];
$kode_kemasan   = $DATAKMS['KODE_KEMASAN'];
$uraian_kemasan = $DATAKMS['URAIAN_KEMASAN'];
$jml_kemasan    = $DATAKMS['JUMLAH'];
$merk_kemasan   = $DATA['MERK_KEMASAN'];
$nama_ttd       = $DATA['NAMA_TTD'];
$tgl_ttd        = $DATA['TANGGAL_TTD'];
$kota_ttd       = $DATA['KOTA_TTD'];
$pejabat_penerima = "...............";
$kode_valuta = $DATA['KODE_VALUTA'];
$uraian_valuta = $DATA['URAIAN_VALUTA'];
$pnbp = $this->fungsi->FormatRupiah($DATA['PNBP'],2);
$cara_penyerahan_barang = $DATA['CARA_PENYERAHAN_BARANG'];
$daerah_asal_barang = $DATA['PROPINSI_BARANG'];

?>
<!DOCTYPE html>
<html>
<head>  
<style type="text/css">
.border-t {border-top:thin solid #000000;}
.border-b {border-bottom:thin solid #000000;}
.border-r {border-right:thin solid #000000;}
.border-l {border-left:thin solid #000000;}
.border-br {border-bottom:thin solid #000000;border-right:thin solid #000000;}
.border-tr {border-top:thin solid #000000;border-right:thin solid #000000;}
.border-tbrl {border-top:thin solid #000000;border-bottom:thin solid #000000;border-right:thin solid #000000;border-left:thin solid #000000;}

</style>
</head>
<body style="font-size:11;font-family:Arial, Helvetica, sans-serif">                
<?php 
if($SURAT['NOMOR_AJU']){
    $this->load->view("surat/surat");   
    if($hasilTotLampiran>0){
        $this->load->view("surat/lampiran");
    }
}
?>
 
<div class="border-tbrl">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="10%" class="border-r" rowspan="4" style="text-rotate:90deg;text-align:center;padding:10px"><strong>HEADER</strong></td>
            <td width="90%" colspan="2">
                <table width="100%" cellpadding="10px" cellspacing="0" style="margin:-2px">
                    <tr>
                       <td width="10%" align="center" class="border-r border-b"><strong>BC 3.3</strong></td>
                       <td width="150%" align="center" class="border-b"><strong>PEMBERITAHUAN EKSPOR BARANG MELALUI/DARI PUSAT LOGISTIK BERIKAT&nbsp;&nbsp;</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">    
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="14%">Nomor Pengajuan</td>
                        <td width="1%">:</td>
                        <td width="45%"><?=$no_pengajuan;?></td>
                        <td width="40%">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">    
                <table>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="55%" valign="top"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="word-wrap:break-word" valign="top"><strong>A.</strong></td>
                        <td style="word-wrap:break-word" valign="top"><strong>Kantor Pengawas</strong></td>
                        <td style="word-wrap:break-word" valign="top">:</td>
                        <td style="word-wrap:break-word" valign="top"><?php echo $DATA['KODE_KPBC_AWAS']; ?> - <?= ucwords(strtolower($kantor_pabean));?></td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top"><strong>B.</strong></td>
                        <td style="word-wrap:break-word" valign="top"><strong>Kantor Pabean Pemuatan</strong></td>
                        <td style="word-wrap:break-word" valign="top">:</td>
                        <td style="word-wrap:break-word" valign="top"><?php echo $DATA['KODE_KPBC_MUAT']; ?> - <?= ucwords(strtolower($DATA['URAIAN_KPBC_MUAT']));?></td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top"><strong>C</strong>.</td>
                        <td style="word-wrap:break-word" valign="top"><strong>Jenis Ekspor</strong></td>
                        <td style="word-wrap:break-word" valign="top">:</td>
                        <td style="word-wrap:break-word" valign="top"><?= ucwords(strtolower($jenis_ekspor));?></td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top"><strong>D</strong>.</td>
                        <td style="word-wrap:break-word" valign="top"><strong>Kategori Ekspor</strong></td>
                        <td style="word-wrap:break-word" valign="top">:</td>
                        <td style="word-wrap:break-word" valign="top"><?= ucwords(strtolower($kategori_ekspor));?></td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top"><strong>E.</strong></td>
                        <td style="word-wrap:break-word" valign="top"><strong>Cara Perdagangan</strong></td>
                        <td style="word-wrap:break-word" valign="top">:</td>
                        <td style="word-wrap:break-word" valign="top"><?= ucwords(strtolower($cara_perdagangan));?></td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top"><strong>F.</strong></td>
                        <td style="word-wrap:break-word" valign="top"><strong>Cara Pembayaran</strong></td>
                        <td style="word-wrap:break-word" valign="top">:</td>
                        <td style="word-wrap:break-word" valign="top"><?= ucwords(strtolower($cara_pembayaran));?></td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top"><strong>G.</strong></td>
                        <td style="word-wrap:break-word" valign="top"><strong>Jenis BC 3.3</strong></td>
                        <td style="word-wrap:break-word" valign="top">:</td>
                        <td style="word-wrap:break-word" valign="top"><?= ucwords(strtolower($DATA['URJENIS_BC33']));?></td>
                    </tr>
                </table>
            </td>    
            <td width="45%" valign="top" class="border-t border-l">      
                <table width="100%" cellpadding="0" cellspacing="0" style="table-layout:fixed">
                    <tr>
                        <td colspan="2"><strong>J. PENDAFTARAN DAN PEMBAYARAN</strong></td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2">Pendaftaran</td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top" width="60%">Nomor :</td>
                        <td style="word-wrap:break-word" valign="top" width="40%">Tanggal :</td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2">Bukti Pembayaran</td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top">Nomor :</td>
                        <td style="word-wrap:break-word" valign="top">Tanggal :</td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2">P3BET</td>
                    </tr>
                    <tr>
                        <td style="word-wrap:break-word" valign="top">Nomor :</td>
                        <td style="word-wrap:break-word" valign="top">Tanggal :</td>
                    </tr>
                </table>      
            </td>  
        </tr>
        <tr>
            <td rowspan="10" class="border-r border-t" style="text-rotate:90deg;text-align:center">
                <strong>H. DATA PERDAGANGAN</strong>
            </td>   
            <td width="55%" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                <strong>EKSPORTIR</strong>
            </td>
            <td width="45%" valign="top" class="border-t border-l border-b" style="background-color:#EEEEEE">
                <strong>DOKUMEN PELENGKAP PABEAN</strong>
            </td>
        </tr>
        <tr>
            <td width="55%" valign="top"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td width="1%">1.</td>
                        <td width="34%" valign="top">Identitas</td>
                        <td width="1%" valign="top">:</td>
                        <td width="62%" valign="top"><?= $tipeid_pengusaha.' '.$this->fungsi->FORMATNPWP($npwp_pengusaha);?></td>
                    </tr>
                    <tr>
                        <td valign="top">2.</td>
                        <td valign="top">Nama</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$nama_pengusaha;?></td>
                    </tr>
                    <tr>
                        <td valign="top">3.</td>
                        <td valign="top">Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$alamat_pengusaha;?></td>
                    </tr>
                    <tr>
                        <td valign="top">4.</td>
                        <td valign="top">NIPER</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$niper;?></td>
                    </tr>
                    <tr>
                        <td valign="top">5.</td>
                        <td valign="top">Status</td>
                        <td valign="top">:</td>
                        <td valign="top"><?= ucwords(strtolower($status));?></td>
                    </tr>
                    <tr>
                        <td colspan="4" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                            <strong>PEMILIK BARANG</strong>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">6.</td>
                        <td valign="top">Identitas</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['UR_KODE_ID_PEMILIK'].' - '.$this->fungsi->FORMATNPWP($DATA['ID_PEMILIK'])?></td>
                    </tr>
                    <tr>
                        <td valign="top">7.</td>
                        <td valign="top">Nama</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NAMA_PEMILIK'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">8.</td>
                        <td valign="top">Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['ALAMAT_PEMILIK'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">9.</td>
                        <td valign="top">NIPER</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NIPER_PEMILIK'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">10.</td>
                        <td valign="top">Status</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['STATUS_PEMILIK']." - ".$DATA['URSTATUS_PEMILIK'];?></td>
                    </tr>
                    <tr>
                        <td colspan="4" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                            <strong>PPJK</strong>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">11.</td>
                        <td valign="top">NPWP</td>
                        <td valign="top">:</td>
                        <td valign="top"></td>
                    </tr>
                    <tr>
                        <td valign="top">12.</td>
                        <td valign="top">Nama</td>
                        <td valign="top">:</td>
                        <td valign="top"></td>
                    </tr>
                    <tr>
                        <td valign="top">13.</td>
                        <td valign="top">Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top"></td>
                    </tr>
                     <tr>
                        <td colspan="4" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                            <strong>PENERIMA</strong>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">14.</td>
                        <td valign="top">Nama</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NAMA_PENERIMA'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">15.</td>
                        <td valign="top">Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['ALAMAT_PENERIMA'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">16.</td>
                        <td valign="top">Negara</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NEGARA_PENERIMA']." - ".$DATA['UR_NEGARA_PENERIMA'];?></td>
                    </tr>
                     <tr>
                        <td colspan="4" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                            <strong>PEMBELI</strong>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">17.</td>
                        <td valign="top">Nama</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NAMA_PEMBELI'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">18.</td>
                        <td valign="top">Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['ALAMAT_PEMBELI'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">19.</td>
                        <td valign="top">Negara</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NEGARA_PEMBELI']." - ".$DATA['UR_NEGARA_PEMBELI'];?></td>
                    </tr>
                </table>
            </td>    
            <td width="45%" valign="top" class="border-l">      
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td colspan="2">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                                <tr>
                                    <td valign="top" width="2%">20.</td>
                                    <td valign="top" width="20%">Invoice : </td>
                                    <td valign="top" width="78%">Tgl.</td>
                                </tr>
                                <tr>
                                    <td valign="top">21.</td>
                                    <td valign="top">Packing List : </td>
                                    <td valign="top">Tgl.</td>
                                </tr>
                                <tr>
                                    <td valign="top">22.</td>
                                    <td valign="top" colspan="2">Dokumen Persyaratan Ekspor</td>
                                </tr>
                                <tr>
                                    <td valign="top"></td>
                                    <td valign="top">Jenis : </td>
                                    <td valign="top"></td>
                                </tr>
                                <tr>
                                    <td valign="top"></td>
                                    <td valign="top">Nomor : </td>
                                    <td valign="top">Tgl.</td>
                                </tr>
                                <tr>
                                    <td valign="top">23.</td>
                                    <td valign="top" colspan="2">Dokumen Fasilitas Fiskal di Bidang Ekspor</td>
                                </tr>
                                <tr>
                                    <td valign="top"></td>
                                    <td valign="top">Jenis : </td>
                                    <td valign="top"></td>
                                </tr>
                                <tr>
                                    <td valign="top"></td>
                                    <td valign="top">Nomor : </td>
                                    <td valign="top">Tgl.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                            <strong>PUSAT LOGISTIK BERIKAT</strong>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="20%">24. Nama PLB : </td>
                        <td valign="top" width="80%"><?=$DATA['NAMA_PLB']?></td>
                    </tr>
                    <tr>
                        <td valign="top">25. Lokasi/Kode Lokasi :</td>
                        <td valign="top"><?=$DATA['KODE_LOKASI_PLB']?></td>
                    </tr>
                    <tr>
                        <td valign="top">26. Cara Pengangkutan ke PLB :</td>
                        <td valign="top"><?=$DATA['CARA_PENGANGKUTAN_PLB']." - ".$DATA['URAIAN_CARA_ANGKUT_PLB']?></td>
                    </tr>
                    <tr>
                        <td valign="top">27. Perkiraan Tanggal IN/OUT :</td>
                        <td valign="top"><?=$DATA['PERKIRAAN_INOUT_PLB']?></td>
                    </tr>
                    <tr>
                        <td colspan="2" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                            <strong>DATA PENYERAHAN</strong>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">28. Daerah Asal Barang :</td>
                        <td valign="top"><?=$DATA['PROPINSI_BARANG']?></td>
                    </tr>
                    <tr>
                        <td valign="top">29. Cara Penyerahan Barang :</td>
                        <td valign="top"><?=$DATA['CARA_PENYERAHAN_BARANG']?></td>
                    </tr>
                    <tr>
                        <td colspan="2" valign="top" class="border-t border-b" style="background-color:#EEEEEE">
                            <strong>DATA TRANSAKSI</strong>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">30. Bank Devisa Hasil Ekspor :</td>
                        <td valign="top"><?=$DATA['KODE_BANK']." - ".$DATA['URAIAN_BANK']?></td>
                    </tr>
                    <tr>
                        <td valign="top">31. Jenis Valuta :</td>
                        <td valign="top"><?=$DATA['KODE_VALUTA']." - ".$DATA['URAIAN_VALUTA']?></td>
                    </tr>
                    <tr>
                        <td valign="top">32. Nilai Tukar :</td>
                        <td valign="top"><?=$this->fungsi->FormatRupiah($DATA['NDPBM'],4)?></td>
                    </tr>
                    <tr>
                        <td valign="top">33. Nilai Barang :</td>
                        <td valign="top"><?=$this->fungsi->FormatRupiah($DATA['NILAI_BARANG'],4)?></td>
                    </tr>
                    <tr>
                        <td valign="top">34. FOB :</td>
                        <td valign="top"><?=$this->fungsi->FormatRupiah($DATA['FOB'],4)?></td>
                    </tr>
                    <tr>
                        <td valign="top">35. Nilai Maklon :</td>
                        <td valign="top"><?=$this->fungsi->FormatRupiah($DATA['NILAI_MAKLON'],4)?></td>
                    </tr>
                </table>
            </td> 
        </tr>
        <tr> 
            <td colspan="2" valign="top" class="border-b border-t" style="background-color:#EEEEEE"><strong>DATA PENGANGKUTAN</strong></td>                
        </tr>
        <tr> 
            <td width="55%" valign="top"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top">36.</td>
                        <td valign="top">Cara Pengangkutan</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['MODA']." - ".$DATA['URAIAN_MODA']?></td>
                    </tr>
                    <tr>
                        <td valign="top">37.</td>
                        <td valign="top">Sarana Pengangkutan</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NAMA_ANGKUT'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">38.</td>
                        <td valign="top">No. Pengangkutan</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['NOMOR_ANGKUT'];?></td>
                    </tr>
                    <tr>
                        <td valign="top">39.</td>
                        <td valign="top">Perkiraan Tgl Pemuatan</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$DATA['TANGGAL_MUAT'];?></td>
                    </tr>
                </table>
            </td>    
            <td width="45%" valign="top" class="border-l">      
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top">40.</td>
                        <td valign="top">Pelabuhan/Tempat Muat :</td>
                        <td valign="top"><?=$DATA['URAIAN_MUAT']?></td>
                    </tr>
                    <tr>
                        <td valign="top">41.</td>
                        <td valign="top">Pelabuhan Bongkar :</td>
                        <td valign="top"><?=$DATA['URAIAN_BONGKAR']?></td>
                    </tr>
                    <tr>
                        <td valign="top">42.</td>
                        <td valign="top">Pelabuhan Tujuan :</td>
                        <td valign="top"><?=$DATA['URAIAN_TUJUAN']?></td>
                    </tr>
                </table>
            </td>      
        </tr>
        <tr> 
            <td width="55%" valign="top" class="border-b border-t" style="background-color:#EEEEEE"><strong>DATA PETI KEMAS</strong></td>  
            <td width="45%" valign="top" class="border-b border-t border-l" style="background-color:#EEEEEE"><strong>DATA KEMASAN</strong></td>              
        </tr>    
        <tr> 
            <td width="55%" valign="top"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top">43.</td>
                        <td valign="top">Jumlah Peti Kemas</td>
                        <td valign="top">:</td>
                        <td valign="top"></td>
                    </tr>
                    <tr>
                        <td valign="top">44.</td>
                        <td valign="top">Nomor, Ukuran dan Status Peti Kemas</td>
                        <td valign="top">:</td>
                        <td valign="top"></td>
                    </tr>
                </table>
            </td>    
            <td width="45%" valign="top" class="border-l">      
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top">45.</td>
                        <td valign="top">Jenis, Jumlah dan Merek Kemasan :</td>
                        <td valign="top"></td>
                    </tr>
                </table>
            </td>        
        </tr>
        <tr> 
            <td colspan="2" valign="top" class="border-b border-t" style="background-color:#EEEEEE"><strong>DATA BARANG EKSPOR</strong></td>                
        </tr>
        <tr> 
            <td width="55%" valign="top"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top">46.</td>
                        <td valign="top">Berat Kotor (Kg)</td>
                        <td valign="top">:</td>
                        <td valign="top"></td>
                    </tr>
                </table>
            </td>    
            <td width="45%" valign="top" class="border-l">      
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top">47.</td>
                        <td valign="top">Berat Bersih (Kg) :</td>
                        <td valign="top"></td>
                    </tr>
                </table>
            </td>        
        </tr>   
        <tr> 
            <td valign="top" colspan="2" class="border-t">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px">
                    <tr>
                        <td valign="top" class="border-r border-b">48.<br>No.</td>
                        <td valign="top" class="border-b">49.</td>
                        <td valign="top" class="border-r border-b">- Pos Tarif/HS, <br>- Uraian jumlah dan jenis barang (termasuk merk, tipe, dan spesifikasi wajib)<br>- Negara Asal Barang</td>
                        <td valign="top" class="border-b">50.</td>
                        <td valign="top" class="border-r border-b">Keterangan<br>- Kode Barang<br>- Persyaratan & No.Urut<br>- Fasilitas & No.Urut<br>- Pemilik & No. Urut</td>
                        <td valign="top" class="border-b">51.</td>
                        <td valign="top" class="border-r border-b">- HE Barang<br>- BK<br>- PPh</td>
                        <td valign="top" class="border-b">52.</td>
                        <td valign="top" class="border-r border-b">- Jumlah & Jenis Satuan<br>- Berat Bersih (Kg)<br>- Volume (m3) </td>
                        <td valign="top" class="border-b">53.</td>
                        <td valign="top" class="border-b">- Nilai Barang<br>- FOB</td>
                    </tr>
                    <?php             
                    if(count($BARANG)==1){            
                      foreach( $BARANG as $bar):
                    ?> 
                    <tr>
                        <td valign="top" class="border-r" align="center">1</td>
                        <td valign="top" class="border-r" colspan="2"><?=substr($bar['KODE_HS'],0,4).'.'.substr($bar['KODE_HS'],4,2).'.'.substr($bar['KODE_HS'],6,2).'.'.substr($bar['KODE_HS'],8,2);?><br><?=$bar['URAIAN_BARANG'];?> / <?=$bar['JENIS_BARANG'];?> / <?=$bar['MERK']?> / <?=$bar['UKURAN']?> / <?=$bar['TIPE']?> / <?=$bar['SPF']?><br><?=$bar['NEGARA_ASAL']." - ".$bar['URAIAN_NEGARA'];?>
                        </td>
                        <td valign="top" class="border-r" colspan="2"><?=$bar['KODE_BARANG']?><br>-<br><?=$bar['KODE_FAS']." - ".$bar['URAIAN_FAS']?></td>
                        <td valign="top" class="border-r" colspan="2"><?=$this->fungsi->FormatRupiah($bar['HARGA_EKSPOR'],2);?><br><?=$bar['BEA_KELUAR'];?><br><?=$bar['PPH'];?></td>
                        <td valign="top" class="border-r" colspan="2"><?=$bar['JUMLAH_SATUAN']?> <?=$bar['KODE_SATUAN'];?><br><?=$bar['NETTO'];?> Kgm<br><?=$bar['VOLUME'];?></td>
                        <td valign="top" colspan="2"><?= $this->fungsi->FormatRupiah($bar['FOB_PER_BARANG'],4);?></td>
                    </tr>
                    <?php  
                    endforeach; 
                    }elseif(count($BARANG) <1){
                    ?>          
                    <tr>               
                        <td colspan="11">&nbsp;</td>
                    </tr>
                    <tr>               
                        <td align="center" colspan="11">=== Belum Terdapat Data Barang === </td>
                    </tr>
                    <tr>               
                        <td colspan="11">&nbsp;</td>
                    </tr>
                    <?php }else{?>                 
                    <tr>               
                        <td colspan="11">&nbsp;</td>
                    </tr>
                    <tr>               
                        <td align="center" colspan="11">=== <?=count($BARANG)?> Jenis Barang. Lihat lembar lanjutan ===</td>
                    </tr>
                    <tr>               
                        <td colspan="11">&nbsp;</td>
                    </tr>             
                  <?php }?>
                </table> 
            </td>
        </tr> 
        <tr> 
            <td colspan="2" valign="top" class="border-t">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:-1px;table-layout:fixed">
                    <tr>
                        <td valign="top" width="50%" class="border-b" colspan="2" style="background-color:#EEEEEE"><strong>DATA PENERIMAAN NEGARA</strong></td>
                        <td valign="top" width="50%" class="border-l border-b" colspan="2" style="background-color:#EEEEEE"><strong>PEMBERITAHUAN PABEAN IMPOR (dalam hal Ekspor kembali)</strong></td>
                    </tr>
                    <tr>
                        <td valign="top" class="border-b" width="15%">54. Bea Keluar</td>
                        <td valign="top" class="border-l border-b" width="35%"></td>
                        <td valign="top" class="border-l border-b" width="15%">58. Jenis Dokumen</td>
                        <td valign="top" class="border-l border-b" width="35%"></td>
                    </tr>
                    <tr>
                        <td valign="top" class="border-b" width="15%">55. PPh</td>
                        <td valign="top" class="border-l border-b" width="35%"></td>
                        <td valign="top" class="border-l border-b" width="15%">59. Nomor Pendaftaran</td>
                        <td valign="top" class="border-l border-b" width="35%"></td>
                    </tr>
                    <tr>
                        <td valign="top" class="border-b" width="15%">56. lainnya</td>
                        <td valign="top" class="border-l border-b" width="35%"></td>
                        <td valign="top" class="border-l border-b" width="15%">60. Tanggal Pendaftaran</td>
                        <td valign="top" class="border-l border-b" width="35%"></td>
                    </tr>
                    <tr>
                        <td valign="top" width="15%">57. Jumlah</td>
                        <td valign="top" class="border-l" width="35%"></td>
                        <td valign="top" class="border-l" colspan="2"></td>
                    </tr>
                </table>
            </td>                
        </tr>
    </table> 
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
            <td colspan="2" valign="top" class="border-t"><strong>I. TANDA TANGAN EKSPORTIR/PPJK</strong></td>
        </tr> 
        <tr>
            <td valign="top" align="left" width="60%">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam dokumen ini dan keabsahan dokumen pelengkap pabean yang menjadi dasar pembuatan dokumen ini.</td>
            <td valign="top" align="right" width="40%">
                <table border="0" cellpadding="0" cellspacing="0" style="margin-right:50px">
                    <tr>
                        <td align="center">
                            <?=$kota_ttd?>, Tgl. <?=$this->fungsi->dateformat($tgl_ttd);?><br>Eksportir<br><br><br><br><?=$nama_ttd;?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>      
</div>
<?php
if(count($BARANG)>1){   
    echo "<pagebreak>"; 
    $arrdata = array("loop"=>0);    
    $this->load->view("pemasukan/bc33/cetak/bc33_lampiran_lanjutan",$arrdata);        
    $loop = floor(count($BARANG)/10);
    $x=10;
    if(count($BARANG)>10){
        for($i=0;$i<$loop;$i++){
            echo "<pagebreak>"; 
            $arrdata = array("loop"=>$x); 
            $this->load->view("pemasukan/bc33/cetak/bc33_lampiran_lanjutan",$arrdata);        
            $x=$x+10;
        }
    }
}  
if (count($DOKUMEN) > 0){
    echo "<pagebreak>"; 
    $this->load->view("pemasukan/bc33/cetak/bc33_lampiran_dokumen");
}
if (count($DATAKMS) > 0){
    echo "<pagebreak>"; 
    $this->load->view("pemasukan/bc33/cetak/bc33_lampiran_kemasan");
}
?>
</body>
</html>