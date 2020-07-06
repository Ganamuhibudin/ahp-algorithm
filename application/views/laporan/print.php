<? if($xls == "xls"){ ?>
<style>
.fnumber{mso-number-format:"0\.00"}
.ftext{mso-number-format:"\@"}
</style>	
<? } ?>
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
//==============================================================
//==============================================================
define("_JPGRAPH_PATH", 'jpgraph/');
$JpgUseSVGFormat = true;
define('_MPDF_URI', site_url() . "laporan/generatePdf");

//==============================================================
//==============================================================
function getKeterangan($jml) {
    if ((is_array($jml) && empty($jml)) || strlen($jml) === 0) {
        return "";
    } else {
        if ($jml < 0) {
            return "SELISIH KURANG";
        } elseif ($jml > 0) {
            return "SELISIH LEBIH";
        } elseif ($jml == 0) {
            return "SESUAI";
        }
    }
}
$THSTYLE = "style=\"border:solid 1px #ABC3D6;background:#DDD\"";
$TDSTYLE = "style=\"border:solid 1px #ABC3D6;\"";


function FormatDate($vardate) {
    $pecah1 = explode("-", $vardate);
    $tanggal = intval($pecah1[2]);
    $arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember");
    $bulan = $arrayBulan[intval($pecah1[1])];
    $tahun = intval($pecah1[0]);
    $balik = $tanggal . " " . $bulan . " " . $tahun;
    return $balik;
}

if ($tipe == 'pemasukan' || $tipe == 'pengeluaran') {

    function contentPemasukan($xls="",$tittle="",$tglAwal,$tglAkhir,$NAMA_TRADER="") {
        $content = "<thead>";
		$styleth = "";	
		if($xls=="xls") $styleth = "style=\"border:solid 1px #000;background:#DDD\""; 
		$content = "<thead>";
		if($xls=="xls"){
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
			$content .= "<tr><td colspan=\"12\">PUSAT LOGISTIK BERIKAT ".$NAMA_TRADER."</td></tr>";
			$content .= "<tr><td colspan=\"12\">".strtoupper($tittle)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">PERIODE ".FormatDate($tglAwal)." S.D ".FormatDate($tglAkhir)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
		}	
        $content .="<tr align=\"left\">";
        $content .="<th rowspan=\"2\" align=\"center\" ".$styleth.">No</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jenis Dokumen</th>";
        $content .="<th colspan=\"2\" ".$styleth.">Dokumen Pabean</th>";
        $content .="<th colspan=\"2\" ".$styleth.">Bukti/Dok. Penerimaan</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Pemasok/Pengirim</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Pemilik</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Kode Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Satuan</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jumlah</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nilai Barang</th>";
        $content .="</tr>";
        $content .="<tr align=\"center\">";
        $content .="<th ".$styleth.">Nomor</th>";
        $content .="<th ".$styleth.">Tanggal</th>";
        $content .="<th ".$styleth.">Nomor</th>";
        $content .="<th ".$styleth.">Tanggal</th>";
        $content .="</tr>";
        $content .="</thead>";
        return $content;
    }

    function contentPengeluaran($xls="",$tittle="",$tglAwal,$tglAkhir,$NAMA_TRADER="") {
        $content = "<thead>";
		$styleth = "";	
		if($xls=="xls") $styleth = "style=\"border:solid 1px #000;background:#DDD\""; 
		$content = "<thead>";
		if($xls=="xls"){
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
			$content .= "<tr><td colspan=\"12\">PUSAT LOGISTIK BERIKAT ".$NAMA_TRADER."</td></tr>";
			$content .= "<tr><td colspan=\"12\">".strtoupper($tittle)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">PERIODE ".FormatDate($tglAwal)." S.D ".FormatDate($tglAkhir)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
		}	
        $content .="<tr align=\"left\">";
        $content .="<th rowspan=\"2\" align=\"center\" ".$styleth.">No</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jenis Dokumen</th>";
        $content .="<th colspan=\"2\" ".$styleth.">Dokumen Pabean</th>";
        $content .="<th colspan=\"2\" ".$styleth.">Bukti/Dok. Pengeluaran</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Pembeli/Penerima</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Pemilik</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Kode Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Satuan</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jumlah</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nilai Barang</th>";
        $content .="</tr>";
        $content .="<tr align=\"center\">";
        $content .="<th ".$styleth.">Nomor</th>";
        $content .="<th ".$styleth.">Tanggal</th>";
        $content .="<th ".$styleth.">Nomor</th>";
        $content .="<th ".$styleth.">Tanggal</th>";
        $content .="</tr>";
        $content .="</thead>";
        return $content;
    }
    ?>
    <table class="tabelPopUp" width="100%"> 
        <?php
        if ($tipe == 'pemasukan') {
            echo contentPemasukan($xls,$title,$tglAwal,$tglAkhir,$nama);
        } else {
            echo contentPengeluaran($xls,$title,$tglAwal,$tglAkhir,$nama);
        }

        $banyakData = count($resultData);
        echo "<tbody>";
        if ($banyakData > 0) {
			#$no = 1;
			$styletd = "";
			$class = "";	
			if($xls=="xls") {
				$styletd = "style=\"border:solid 1px #000;\"";
			}
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td nowrap="nowrap" align="center" <?=$styletd?>><?= $no; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $listData['JENIS_DOKUMEN']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NOMOR_PENDAFTARAN']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $this->fungsi->FormatDate($listData['TANGGAL_PENDAFTARAN']); ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NOMOR_DOK_INTERNAL']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $this->fungsi->FormatDate($listData['TANGGAL_DOK_INTERNAL']); ?></td>
                    <?php if ($tipe == 'pemasukan') { ?>
                        <td nowrap="nowrap" <?=$styletd?>><?= $listData['PEMASOK/PENGIRIM']; ?></td>
            <?php } elseif ($tipe == 'pengeluaran') { ?>
                        <td nowrap="nowrap" <?=$styletd?>><?= $listData['PEMBELI/PENERIMA']; ?></td>
            <?php } ?>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NAMA_PEMILIK']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_BARANG']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['URAIAN_BARANG']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $listData['KODE_SATUAN']; ?></td>
                    <td nowrap="nowrap" align="right" <?=$styletd?> class="fnumber"><?=number_format($listData['JUMLAH_SATUAN'], 2,'.',',');?></td>
                    <td nowrap="nowrap" align="right" <?=$styletd?> class="fnumber"><?=number_format($listData['NILAI'], 2,'.',','); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center">Nihil</td>
            </tr>
    <?php } ?>
    </tbody>
    </table>
<?php 
}elseif($tipe=="pembelian"){
	function contentPembelian($xls="",$tittle="",$tglAwal,$tglAkhir,$NAMA_TRADER="") {
        $content = "<thead>";
		$styleth = "";	
		if($xls=="xls") $styleth = "style=\"border:solid 1px #000;background:#DDD\""; 
		$content = "<thead>";
		if($xls=="xls"){
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
			$content .= "<tr><td colspan=\"12\">PUSAT LOGISTIK BERIKAT ".$NAMA_TRADER."</td></tr>";
			$content .= "<tr><td colspan=\"12\">".strtoupper($tittle)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">PERIODE ".FormatDate($tglAwal)." S.D ".FormatDate($tglAkhir)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
		}	
        $content .="<tr align=\"left\">";
        $content .="<th rowspan=\"2\" align=\"center\" ".$styleth.">No</th>";
        $content .="<th colspan=\"3\" ".$styleth.">Jenis Dokumen</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Pemasok/Pengirim Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Pemilik</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Kode Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Satuan</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jumlah</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Kode Harga</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jenis Nilai</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Mata Uang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Total Harga Barang</th>";
        $content .="</tr>";
        $content .="<tr align=\"center\">";
        $content .="<th ".$styleth.">Dokumen</th>";
        $content .="<th ".$styleth.">Nomor</th>";
        $content .="<th ".$styleth.">Tanggal</th>";
        $content .="</tr>";
        $content .="</thead>";
        return $content;
    }
	?>
	<table class="tabelPopUp" width="100%"> 
        <?php
        echo contentPembelian($xls,$title,$tglAwal,$tglAkhir,$nama);

        $banyakData = count($resultData);
        echo "<tbody>";
        if ($banyakData > 0) {
			#$no = 1;
			$styletd = "";
			$class = "";	
			if($xls=="xls") {
				$styletd = "style=\"border:solid 1px #000;\"";
			}
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td nowrap="nowrap" align="center" <?=$styletd?>><?= $no; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $listData['JENIS_DOKUMEN']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NO_DOK']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $this->fungsi->FormatDate($listData['TGL_DOK']); ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NAMA_PENGIRIM']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NAMA_PEMILIK']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_BARANG']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['URAIAN_BARANG']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_SATUAN']; ?></td>
                    <td nowrap="nowrap" align="right" <?=$styletd?> class="fnumber"><?=number_format($listData['JUMLAH'], 2,'.',',');?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_HARGA']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['JENIS_NILAI']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_VALUTA']; ?></td>
                    <td nowrap="nowrap" align="right" <?=$styletd?> class="fnumber"><?=number_format($listData['NILAI'], 2,'.',','); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center">Nihil</td>
            </tr>
    <?php } ?>
    </tbody>
    </table>
	<?php
}elseif($tipe=="penjualan"){
	function contentPembelian($xls="",$tittle="",$tglAwal,$tglAkhir,$NAMA_TRADER="") {
        $content = "<thead>";
		$styleth = "";	
		if($xls=="xls") $styleth = "style=\"border:solid 1px #000;background:#DDD\""; 
		$content = "<thead>";
		if($xls=="xls"){
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
			$content .= "<tr><td colspan=\"12\">PUSAT LOGISTIK BERIKAT ".$NAMA_TRADER."</td></tr>";
			$content .= "<tr><td colspan=\"12\">".strtoupper($tittle)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">PERIODE ".FormatDate($tglAwal)." S.D ".FormatDate($tglAkhir)."</td></tr>";
			$content .= "<tr><td colspan=\"12\">&nbsp;</td></tr>";	
		}	
        $content .="<tr align=\"left\">";
        $content .="<th rowspan=\"2\" align=\"center\" ".$styleth.">No</th>";
        $content .="<th colspan=\"3\" ".$styleth.">Jenis Dokumen</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Pembeli/Penerima Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Pemilik</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Kode Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Nama Barang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Satuan</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jumlah</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Kode Harga</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Jenis Nilai</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Mata Uang</th>";
        $content .="<th rowspan=\"2\" ".$styleth.">Total Harga Barang</th>";
        $content .="</tr>";
        $content .="<tr align=\"center\">";
        $content .="<th ".$styleth.">Dokumen</th>";
        $content .="<th ".$styleth.">Nomor</th>";
        $content .="<th ".$styleth.">Tanggal</th>";
        $content .="</tr>";
        $content .="</thead>";
        return $content;
    }
	?>
	<table class="tabelPopUp" width="100%"> 
        <?php
        echo contentPembelian($xls,$title,$tglAwal,$tglAkhir,$nama);

        $banyakData = count($resultData);
        echo "<tbody>";
        if ($banyakData > 0) {
			#$no = 1;
			$styletd = "";
			$class = "";	
			if($xls=="xls") {
				$styletd = "style=\"border:solid 1px #000;\"";
			}
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td nowrap="nowrap" align="center" <?=$styletd?>><?= $no; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $listData['JENIS_DOKUMEN']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NO_DOK']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?>><?= $this->fungsi->FormatDate($listData['TGL_DOK']); ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NAMA_PENGUSAHA']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NAMA_PEMILIK']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_BARANG']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['URAIAN_BARANG']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_SATUAN']; ?></td>
                    <td nowrap="nowrap" align="right" <?=$styletd?> class="fnumber"><?=number_format($listData['JUMLAH'], 2,'.',',');?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['NILAI']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['JENIS_NILAI']; ?></td>
                    <td nowrap="nowrap" <?=$styletd?> class="ftext"><?= $listData['KODE_VALUTA']; ?></td>
                    <td nowrap="nowrap" align="right" <?=$styletd?> class="fnumber"><?=number_format($listData['CIF'], 2,'.',','); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center">Nihil</td>
            </tr>
    <?php } ?>
    </tbody>
    </table>
	<?php
}elseif($tipe=="produksi"){  
        function content(){
            $content  ="<thead>";
            $content .="<tr align=\"left\">";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\" width=\"10px\">No</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">NOMOR TRANSAKSI</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">TANGGAL</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">TIPE</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">STATUS</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">KODE BARANG</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">URAIAN BARANG</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">JENIS BARANG</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">JUMLAH</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">SATUAN</th>";
            $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">KETERANGAN</th>";
            $content .="</tr>";
            $content .="</thead>";
            return $content;    
        }   
        ?>
        <table class="tabelPopUp" width="100%" border="0">
            <?
            echo content();
            $banyakData=count($resultData);
            echo "<tbody>";
            if($banyakData>0){
                $no=1;
                $jm=21;
                foreach($resultData as $listData){
                if(($no/$jm)==1){
                     $jm=$jm+20;
                }
            ?>
            <tr>
                <td nowrap="nowrap" <?=$TDSTYLE;?> align="center"><?= $no;?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['NOMOR_PROSES'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['TANGGAL'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= strtoupper($listData['TIPE']);?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['STATUS'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?> class="ftext"><?= $listData['KODE_BARANG'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['URAIAN_BARANG'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['JNS_BARANG'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?> align="right" class="fnumber"><?= $listData['JUMLAH'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['KODE_SATUAN'];?></td>
                <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['KETERANGAN'];?></td>
            </tr>
            <? $no++;}}else{?>
            <tr>
                <td colspan="12" align="center">Tidak ada data</td>
            </tr>
            <? }?>
            </tbody>
        </table>
 <? }elseif($tipe=="barang"){
function content(){
    $content  ="<thead ".$THSTYLE.">";
    $content .="<tr align=\"left\" >";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">No</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">KODE PERUSAHAAN</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">KODE BARANG</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">NAMA BARANG</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">JENIS BARANG</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">KODE HS</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">MERK</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">TIPE</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">UKURAN</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">SATUAN TERBESAR</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">SATUAN TERKECIL</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">KONVERSI SATUAN</th>";
    $content .="<th style=\"border:solid 1px #ABC3D6;background:#DDD\">STOCK GUDANG</th>";
    $content .="</tr>";
    $content .="</thead>";
    return $content;    
}   
?>
<table class="tabelPopUp" width="100%" border="0">
    <?
    if($xls=="xls"){
            $content1 = "<tr><td colspan=\"12\" style=\"font-size:21px\">PUSAT LOGISTIK BERIKAT ".$this->newsession->userdata('NAMA_TRADER')."</td></tr>";
            $content1 .= "<tr><td colspan=\"12\" style=\"font-size:21px\">LAPORAN DATA BARANG</td></tr>";
            $content1 .= "<tr><td colspan=\"12\">&nbsp;</td></tr>"; 
            echo $content1; 
    }
    echo content();
    $banyakData=count($resultData);
    echo "<tbody>";
    if($banyakData>0){
        $no=1;
        $jm=21;
        foreach($resultData as $listData){
        if(($no/$jm)==1){
             $jm=$jm+20;
        }
    ?>
    <tr>
        <td nowrap="nowrap" <?=$TDSTYLE;?> align="center"><?= $no;?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['KODE_PARTNER'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?> class="ftext"><?= $listData['KODE_BARANG'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?> class="ftext"><?= $listData['URAIAN_BARANG'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['JNS_BARANG'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['KODE_HS'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['MERK'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['TIPE'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['UKURAN'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['KODE_SATUAN'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?>><?= $listData['KODE_SATUAN_TERKECIL'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?> align="center" class="fnumber"><?= $listData['JML_SATUAN_TERKECIL'];?></td>
        <td nowrap="nowrap" <?=$TDSTYLE;?> align="right" class="fnumber" ><?= $listData['STOCK_AKHIR'];?></td>
    </tr>
    <? $no++;}
    }else{?>
    <tr>
        <td colspan="12" align="center">Tidak ada data</td>
    </tr>
    <? }?>
    </tbody>
</table>
<? }elseif($tipe=="stock_opname"){ ?>
<table class="tabelPopUp" width="100%" border="0">
        <?php
        if($xls=="xls"){
            $content1 = "<tr><td colspan=\"12\" style=\"font-size:21px\">PUSAT LOGISTIK BERIKAT ".$this->newsession->userdata('NAMA_TRADER')."</td></tr>";
            $content1 .= "<tr><td colspan=\"12\" style=\"font-size:21px\">DATA STOCKOPNAME TANGGAL ".$tglstok."</td></tr>";
            $content1 .= "<tr><td colspan=\"12\">&nbsp;</td></tr>"; 
            echo $content1; 
        } ?>
        <thead>
        <tr>    
            <th style="border:solid 1px #ABC3D6;background:#DDD">No</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Kode Perusahaan</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Kode Barang</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Jenis Barang</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Nama Barang</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Kode Satuan</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Jumlah Stock Opname</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Kode Dok. Masuk</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Nomor Dok. Masuk</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Tanggal Dok. Masuk</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Jumlah</th>
            <th style="border:solid 1px #ABC3D6;background:#DDD">Keterangan</th>
        </tr>   
        </thead>
        <tbody>
        <?  $banyakData=count($list['header']);
            if($banyakData>0){
                $no=1;
                $s=0;
                foreach($list['header'] as $data){
                    $SQL = "SELECT IDHDR, JENIS_DOK_MASUK, NO_DOK_MASUK, TGL_DOK_MASUK, JUMLAH 
                            FROM M_TRADER_STOCKOPNAME_DTL WHERE IDHDR = '".$data['ID']."'
                            ORDER BY TGL_DOK_MASUK";
                    $rs = $this->db->query($SQL);
                    $s = $rs->num_rows();
                    $rowspan="";
                    if($s!=0) $rowspan =  'rowspan="'.$s.'"';
                ?>
                    <tr>    
                        <td <?=$TDSTYLE;?> align="center" <?=$rowspan;?>><?= $no;?></td>
                        <td <?=$TDSTYLE;?> <?=$rowspan;?>><?=$data["KODE_PARTNER"]?></td>
                        <td <?=$TDSTYLE;?> <?=$rowspan;?> class="ftext"><?=$data["KODE_BARANG"]?></td>
                        <td <?=$TDSTYLE;?> <?=$rowspan;?>><?=$data["JENIS_BARANG"]?></td>
                        <td <?=$TDSTYLE;?> <?=$rowspan;?>><?=$data["URAIAN_BARANG"]?></td>
                        <td <?=$TDSTYLE;?> <?=$rowspan;?>><?=$data["KODE_SATUAN"]?></td>
                        <td <?=$TDSTYLE;?> <?=$rowspan;?> class="fnumber"><?=$data["JUMLAH"]?></td>
                <?
                    $no++;                                          
                    if($rs->num_rows()>0){
                        $x=1;
                        foreach($rs->result_array() as $dataDetil){
                            if($x>1){
                                echo '<tr>';
                                echo '<td '.$TDSTYLE.'>'.$dataDetil["JENIS_DOK_MASUK"].'</td>
                                      <td '.$TDSTYLE.' class="ftext">'.$dataDetil["NO_DOK_MASUK"].'</td>
                                      <td '.$TDSTYLE.'>'.$dataDetil["TGL_DOK_MASUK"].'</td>
                                      <td '.$TDSTYLE.' class="fnumber">'.$dataDetil["JUMLAH"].'</td>';
                            }else{
                                echo '<td '.$TDSTYLE.'>'.$dataDetil["JENIS_DOK_MASUK"].'</td>
                                      <td '.$TDSTYLE.' class="ftext">'.$dataDetil["NO_DOK_MASUK"].'</td>
                                      <td '.$TDSTYLE.'>'.$dataDetil["TGL_DOK_MASUK"].'</td>
                                      <td '.$TDSTYLE.' class="fnumber">'.$dataDetil["JUMLAH"].'</td>
                                      <td '.$TDSTYLE.' '.$rowspan.'>'.$data["KETERANGAN"].'</td>';
                            }     
                            $x++;     
                        }   
                    }else{
                        echo '<td '.$TDSTYLE.'>&nbsp;</td>
                              <td '.$TDSTYLE.'>&nbsp;</td>
                              <td '.$TDSTYLE.'>&nbsp;</td>
                              <td '.$TDSTYLE.'>&nbsp;</td>
                              <td '.$TDSTYLE.'>'.$data["KETERANGAN"].'</td>';
                    }                   
                }            
            }else{?>
        <tr>
            <td colspan="12" <?=$TDSTYLE?>>Tidak ada data</td>
        </tr>
        <? }?>
        
        </tbody>
    </table>
<? }
?>