<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<table width="100%" border="0">
	<tr>
		<td width="50%" valign="top">
			<table width="90%" border="0">
            	<tr>
                	<td class="social-list strong">Nomor Aju</td>
                	<td class="social-list"><?=$this->fungsi->FormatAju($sess["NOMOR_AJU"]);?></td>
                </tr>
                <tr>
                	<td class="social-list strong">Tanggal Aju</td>
                	<td class="social-list"><?= ($sess['TANGGAL_AJU']=='0000-00-00' || $sess['TANGGAL_AJU']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_AJU'])); ?></td>
                </tr>
                <tr>
                	<td class="social-list strong">Kantor Pabean </td>
                	<td class="social-list"><?= $sess['KODE_KANTOR_PABEAN']; ?> - <?= $sess['URAIAN_KODE_KANTOR_PABEAN']==''?$URKANTOR_TUJUAN:$sess['URAIAN_KODE_KANTOR_PABEAN']; ?></td>
                </tr>
                <tr>
                    <td width="30%" class="social-list strong">Jenis BC28</td>
                    <td width="69%" class="social-list"><?=$sess['JENIS_BC28']." - ".$sess["UR_JENIS_BC28"]?></combo>
                    </td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis Impor</td>
                    <td class="social-list"><?=$sess['JENIS_IMPOR']?> - <?= $sess['UR_JENIS_IMPOR']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Cara Pembayaran</td>
                    <td class="social-list"><?=$sess['CARA_PEMBAYARAN']?> - <?= $sess['UR_CARA_PEMBAYARAN']; ?></td>
                </tr>
			</table>
      	</td>
		<td width="50%" valign="top">
            <table width="90%">
            	<tr>
                	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                </tr>
                <tr>
                    <td width="40%" class="social-list strong">Nomor Pendaftaran</td>
                    <td width="50%" class="social-list"><?= $sess['NOMOR_PENDAFTARAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Pendaftaran</td>
                    <td class="social-list"><?= ($sess['TANGGAL_PENDAFTARAN']=='0000-00-00' || $sess['TANGGAL_PENDAFTARAN']=='')?' - ':date('d F Y', strtotime($sess['TANGGAL_PENDAFTARAN'])); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">No. Persetujuan Pengeluaran</td>
                    <td class="social-list"><?= $sess['NOMOR_DOK_PABEAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal Persetujuan Pengeluaran</td>
                    <td class="social-list"><?= ($sess['TANGGL_DOK_PABEAN']=='0000-00-00' || $sess['TANGGL_DOK_PABEAN']=='')?' - ':date('d F Y', strtotime($sess['TANGGL_DOK_PABEAN'])); ?></td>
                </tr>
            </table>
		</td>
	</tr>
</table>
<h5 class="header smaller lighter green"><b>DATA PEMBERITAHUAN</b></h5>
<table width="100%" border="0">
    <tr>
        <td width="50%" valign="top">
            <table width="90%" border="0">
                <tr>
                	<td colspan="2"><h5 class="smaller lighter blue"><b>PENGUSAHA PLB/PDPLB</b></h5></td>
                </tr>
                <tr>
                    <td width="30%" class="social-list strong">Identitas</td>
                    <td width="69%" class="social-list"><?=$sess['UR_KODE_ID_PENGUSAHA']?> - <?php if($sess['KODE_ID_PENGUSAHA']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PENGUSAHA']);}else{ echo $sess['ID_PENGUSAHA'];}?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_PENGUSAHA']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" valign="top">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_PENGUSAHA']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" ><h5 class="smaller lighter blue"><b>PENJUAL</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Identitas</td>
                    <td class="social-list"><?=$sess['UR_KODE_ID_PENJUAL']?> - <?php if($sess['KODE_ID_PENJUAL']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PENJUAL']);}else{ echo $sess['ID_PENJUAL'];}?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_PENJUAL']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_PENJUAL']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Negara Penjual</td>
                    <td class="social-list"><?= $sess['NEGARA_PENJUAL']." - ".$sess["URAIAN_NEGARA_PENJUAL"]; ?></td>
                </tr>
                <tr>
                    <td colspan="2" ><h5 class="smaller lighter blue"><b>IMPORTIR</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Identitas</td>
                    <td class="social-list"><?=$sess['UR_KODE_ID_IMPORTIR']?> - <?php if($sess['KODE_ID_IMPORTIR']==5){echo $this->fungsi->FORMATNPWP($sess['ID_IMPORTIR']);}else{ echo $sess['ID_IMPORTIR'];}?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_IMPORTIR']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_IMPORTIR']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Status</td>
                    <td class="social-list"><?= "(".$sess['STATUS_IMPORTIR']." - ".$sess["UR_STATUS_IMPORTIR"].") - ".$sess["NIK_IMPORTIR"]; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">APIU/P</td>
                    <td class="social-list"><?= "(".$sess["KODE_API"].$sess["UR_API"].") - ".$sess["NOMOR_API"]; ?></td>
                </tr>
                 <tr>
                    <td colspan="2" ><h5 class="smaller lighter blue"><b>PEMILIK BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Identitas</td>
                    <td class="social-list"><?=$sess['UR_KODE_ID_PEMILIK']?> - <?php if($sess['KODE_ID_PEMILIK']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PEMILIK']);}else{ echo $sess['ID_PEMILIK'];}?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_PEMILIK']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" align="top">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_PEMILIK']; ?></td>
                </tr>
            </table>
		</td>
		<td width="50%" valign="top">
			<table width="100%" border="0">
            	<tr>
                    <td width="40%" class="social-list strong">Tempat Timbun </td>
                    <td width="60%" class="social-list"><?= $sess['KODE_TIMBUN']?> - <?= $sess['URAIAN_TIMBUN'] ?></td>
                </tr>
            	<tr>
                    <td class="social-list strong">Moda Tranportasi </td>
                    <td class="social-list"><?= $sess['MODA']?> - <?= $sess['UR_MODA'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis Valuta Asing </td>
                    <td class="social-list"><?= $sess['KODE_VALUTA']?> - <?= $sess['URAIAN_VALUTA'] ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">NDPBM (Kurs) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NDPBM'],4); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jenis Nilai</td>
                    <td class="social-list"><?= $sess['JENIS_NILAI']."-".$sess["UR_JENIS_NILAI"] ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nilai</td>
                    <td class="social-list"><?= $sess['UR_NILAI'] ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nilai CIF</td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['NILAI_CIF'],2); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong"><span style="float:right">Rp&nbsp;&nbsp;&nbsp;</span></td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['CIFRP'],4) ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Bruto </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'],2); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Netto</td>
                    <td class="social-list"><?= $sess['JUM_NETTO']; ?>&nbsp; Kilogram (KGM)</td>
                </tr>
                <tr>
                    <td class="social-list strong">Pembayaran</td>
                    <td class="social-list"><?= $sess['KODE_PEMBAYARAN']." - ".$sess['UR_KODE_PEMBAYARAN']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><h5 class="smaller lighter blue"><b>PENANDATANGANAN</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['PEMBERITAHU']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Jabatan</td>
                    <td class="social-list"><?= $sess['JABATAN']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tempat</td>
                    <td class="social-list"><?= $sess['KOTA_TTD']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal</td>
                    <td class="social-list"><?=$sess['TANGGAL_TTD']; ?></td>
                </tr>
            </table>
		</td>
	</tr>
    <tr>
    	<td colspan="2">
        	<h5 class="smaller lighter blue"><b>DATA PUNGUTAN :</b></h5>
        	<table border="0" width="100%" cellpadding="5" cellspacing="0" class="table-striped table-bordered no-margin-bottom">
                <tr>
                    <td width="10%"  align="center" class="border-brlt">Jenis Pungutan</td>
                    <td width="15%" align="center" class="border-brt">Dibayar (Rp) </td>
                    <td width="15%" align="center" class="border-brt">Ditanggung (Rp)</td>
                    <td width="15%" align="center" class="border-brt">Ditunda (Rp)</td>
                    <td width="15%" align="center" class="border-brt">Tdk Dpgt (Rp)</td>
                    <td width="15%" align="center" class="border-brt">Dibebaskan (Rp)</td>
                    <td width="15%" align="center" class="border-brt">Sudah Dilunasi (Rp)</td>
                </tr>
                <tr>
                    <td style="padding-left:20px;" class="border-brl">BM</td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$A =($sess['PGT_BM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$AA =($sess['PGT_BM_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_DIT_PEM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$AAA =($sess['PGT_BM_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_DITUNDA'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$AAAA =($sess['PGT_BM_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_TDK_DIPUNGUT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$AAAAA =($sess['PGT_BM_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_BEBAS'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$AAAAAA =($sess['PGT_BM_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BM_LUNAS'],0):0;?></td>
                </tr>                        
                <tr>
                    <td style="padding-left:20px;" class="border-brl">BM KITE</td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$B =($sess['PGT_BMKITE']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$BB =($sess['PGT_BMKITE_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_DIT_PEM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$BBB =($sess['PGT_BMKITE_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_DITUNDA'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$BBBB =($sess['PGT_BMKITE_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_TDK_DIPUNGUT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$BBBBB =($sess['PGT_BMKITE_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_BEBAS'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$BBBBBB =($sess['PGT_BMKITE_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMKITE_LUNAS'],0):0;?></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;" class="border-brl">BMT</td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$C =($sess['PGT_BMT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$CC =($sess['PGT_BMT_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_DIT_PEM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$CCC =($sess['PGT_BMT_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_DITUNDA'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$CCCC =($sess['PGT_BMT_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_TDK_DIPUNGUT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$CCCCC =($sess['PGT_BMT_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_BEBAS'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$CCCCCC =($sess['PGT_BMT_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_BMT_LUNAS'],0):0;?></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;" class="border-brl">Cukai</td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$D =($sess['PGT_CUKAI']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$DD =($sess['PGT_CUKAI_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_DIT_PEM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$DDD =($sess['PGT_CUKAI_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_DITUNDA'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$DDDD =($sess['PGT_CUKAI_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_TDK_DIPUNGUT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$DDDDD =($sess['PGT_CUKAI_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_BEBAS'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$DDDDDD =($sess['PGT_CUKAI_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_CUKAI_LUNAS'],0):0;?></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;" class="border-brl">PPN</td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$E =($sess['PGT_PPN']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$EE =($sess['PGT_PPN_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_DIT_PEM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$EEE =($sess['PGT_PPN_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_DITUNDA'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$EEEE =($sess['PGT_PPN_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_TDK_DIPUNGUT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$EEEEE =($sess['PGT_PPN_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_BEBAS'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$EEEEEE =($sess['PGT_PPN_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPN_LUNAS'],0):0;?></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;" class="border-brl">PPnBM</td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$F =($sess['PGT_PPNBM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$FF =($sess['PGT_PPNBM_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_DIT_PEM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$FFF =($sess['PGT_PPNBM_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_DITUNDA'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$FFFF =($sess['PGT_PPNBM_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_TDK_DIPUNGUT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$FFFFF =($sess['PGT_PPNBM_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_BEBAS'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$FFFFFF =($sess['PGT_PPNBM_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPNBM_LUNAS'],0):0;?></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;" class="border-brl">PPh</td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$G =($sess['PGT_PPH']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$GG =($sess['PGT_PPH_DIT_PEM']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_DIT_PEM'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$GGG =($sess['PGT_PPH_DITUNDA']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_DITUNDA'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$GGGG =($sess['PGT_PPH_TDK_DIPUNGUT']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_TDK_DIPUNGUT'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$GGGGG =($sess['PGT_PPH_BEBAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_BEBAS'],0):0;?></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><?=$GGGGGG =($sess['PGT_PPH_LUNAS']!="")? $this->fungsi->FormatRupiah($sess['PGT_PPH_LUNAS'],0):0;?></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;" class="border-brl"><strong>TOTAL</strong></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$A)+str_replace(',','',$B)+str_replace(',','',$C)+str_replace(',','',$D)+str_replace(',','',$E)+str_replace(',','',$F)+str_replace(',','',$G),0)?></b></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AA)+str_replace(',','',$BB)+str_replace(',','',$CC)+str_replace(',','',$DD)+str_replace(',','',$EE)+str_replace(',','',$FF)+str_replace(',','',$GG),0)?></b></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAA)+str_replace(',','',$BBB)+str_replace(',','',$CCC)+str_replace(',','',$DDD)+str_replace(',','',$EEE)+str_replace(',','',$FFF)+str_replace(',','',$GGG),0)?></b></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAAA)+str_replace(',','',$BBBB)+str_replace(',','',$CCCC)+str_replace(',','',$DDDD)+str_replace(',','',$EEEE)+str_replace(',','',$FFFF)+str_replace(',','',$GGGG),0)?></b></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAAAA)+str_replace(',','',$BBBBB)+str_replace(',','',$CCCCC)+str_replace(',','',$DDDDD)+str_replace(',','',$EEEEE)+str_replace(',','',$FFFFF)+str_replace(',','',$GGGGG),0)?></b></td>
                    <td align="right" class="border-br" style="padding-right:10px;"><b><?=$this->fungsi->FormatRupiah(str_replace(',','',$AAAAAA)+str_replace(',','',$BBBBBB)+str_replace(',','',$CCCCCC)+str_replace(',','',$DDDDDD)+str_replace(',','',$EEEEEE)+str_replace(',','',$FFFFFF)+str_replace(',','',$GGGGGG),0)?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php  
if($priview){
	echo '<h4 class="header smaller lighter green"><i class="icon-list"></i>&nbsp;<b>Detil Dokumen</b></h4>'.$DETILPRIVIEW;
} 