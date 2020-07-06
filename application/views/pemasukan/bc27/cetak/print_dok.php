<?php
$no_pengajuan		= $DATA['NOMOR_AJU'];
$kantor_asal		= $DATA['URAIAN_KPBC_ASAL'];
$kantor_tujuan		= $DATA['URAIAN_KPBC_TUJUAN'];
$no_pendaftaran		= $DATA['NOMOR_PENDAFTARAN'];
$tgl_daftar			= $DATA['TANGGAL_PENDAFTARAN'];
$npwp_tpbasal		= $DATA['ID_TRADER_ASAL'];
$nama_tpbasal		= $DATA['NAMA_TRADER_ASAL'];
$alamat_tpbasal		= $DATA['ALAMAT_TRADER_ASAL'];
$no_izintpbasal		= $DATA['NOMOR_IZIN_TPB_ASAL'];
$npwp_tpbtujuan		= $DATA['ID_TRADER_TUJUAN'];
$nama_tpbtujuan		= $DATA['NAMA_TRADER_TUJUAN'];
$alamat_tpbtujuan	= $DATA['ALAMAT_TRADER_TUJUAN'];
$no_izintpbtujuan	= $DATA['NOMOR_IZIN_TPB_TUJUAN'];
$invoce				= $DATADOK['NOMOR_INVOICE'];
$tgl_invoce			= $DATADOK['TANGGAL_INVOICE'];
$srt_keputusan 		= $DATADOK['NOMOR_SURAT_KEPUTUSAN'];
$tgl_keputusan 		= $DATADOK['TANGGAL_SURAT_KEPUTUSAN'];
$no_packing			= $DATADOK['NOMOR_PACKING_LIST'];
$tgl_packing		= $DATADOK['TANGGAL_PACKING_LIST'];
$no_kontrak			= $DATADOK['NOMOR_KONTRAK'];
$tgl_kontrak		= $DATADOK['TANGGAL_KONTRAK'];
$no_lainnya		    = $DATADOK['NOMOR_LAINNYA'];
$kd_valuta		= $DATA['KODE_VALUTA'];
$jenis_valuta		= $DATA['URAIAN_VALUTA'];
$cif				= $DATA['CIF'];
$hrg_penyerahan		= $DATA['HARGA_PENYERAHAN'];
$berat_bersih   	= $DATA['JUM_NETTO'];
$berat_kotor		= $DATA['BRUTO'];
$volume  			= $DATA['VOLUME'];
$tujuan_pengiriman	= $DATA['URTUJUAN_PENGIRIMAN'];
$tpb_asal			= $DATA['URJENIS_TPB_ASAL'];
$tpb_tujuan			= $DATA['URJENIS_TPB_TUJUAN'];
$surat_jalan		= $DATADOK['NOMOR_SURAT_JALAN'];
$tgl_surat_jalan	= $DATADOK['TANGGAL_SURAT_JALAN'];
$no_barang			= $DATA['NOMOR_BC27_ASAL'];
$tgl_barang			= $DATA['TANGGAL_BC27_ASAL'];
$jenis_angkut		= $DATA['URJENIS_SARANA_ANGKUT'];
$no_polisi			= $DATA['NOMOR_POLISI'];
$merk_kemasan		= $DATAKMS['MERK_KEMASAN'];
$jns_kemasan		= $DATAKMS['URKODE_KEMASAN'];
$jml_kemasan		= $DATAKMS['JUMLAH'];
$nama_pejabat_asal	= $DATA['NAMA_PEJABAT_BC_ASAL'];
$nama_pejabat_tujuan= $DATA['NAMA_PEJABAT_BC_TUJUAN'];
$nip_pejabat_asal	= $DATA['NIP_PEJABAT_BC_ASAL'];
$nip_pejabat_tujuan	= $DATA['NIP_PEJABAT_BC_TUJUAN'];
$no_segel			= $DATA['NOMOR_SEGEL_BC'];
$jns_bcasal			= $DATA['JENIS_SEGEL_BC'];
$jns_bcasal_ur		= $DATA['JENIS_SEGEL_BC_UR'];
$catatan_bctujuan	= $DATA['CATATAN_BC_TUJUAN'];
$nama_ttd			= $DATA['NAMA_TTD'];
$kota_ttd			= $DATA['KOTA_TTD'];
$tanggal_ttd		= $DATA['TANGGAL_TTD'];
function FormatAju($var){
if (!is_null($var)){
$varresult = '';
$varresult = substr($var,0,6)."-".substr($var,6,6)."-".substr($var,12,8)."-".substr($var,20,6);
return $varresult;
}
}
?>
<style type="text/css">
.border-t {
border-top:thin solid #000000;
}
.border-b {
border-bottom:thin solid #000000;
}
.border-r {
border-right:thin solid #000000;
}
.border-l {
border-left:thin solid #000000;
}
.border-br {
border-bottom:thin solid #000000;
border-right:thin solid #000000;
}
.border-tr {
border-top:thin solid #000000;
border-right:thin solid #000000;
}
.border-tb {
border-top:thin solid #000000;
border-bottom:thin solid #000000;
}
.border-tbrl {
border-top:thin solid #000000;
border-bottom:thin solid #000000;
border-right:thin solid #000000;
border-left:thin solid #000000;
}
.bold{
    font-weight: bold;
}
.nobold{
    font-weight: 100;
}
table {border-collapse:collapse; table-layout:fixed; width:100%;}
table td {word-wrap: break-word;}
sup {
    vertical-align: super;
    font-size: smaller;
}
</style>

<body style="font-size:11;">
<?php 
/*if($SURAT['NOMOR_AJU']){
$this->load->view("surat/surat");	
if($hasilTotLampiran>0){
$this->load->view("surat/lampiran");
}
}*/
?>
<div class="border-tbrl">
	<table width="100%" cellpadding="2" cellspacing="0" style="table-layout: fixed;font-size:11;font-family:Arial, Helvetica, sans-serif">
		<tr>
            <td width="10%" align="center" class="border-r border-b"><strong>BC 2.7</strong></td>
            <td width="90%" colspan="2" align="center" class="border-b" height="33pt">
                <strong>
                    PEMBERITAHUAN
                    <?=strtoupper($this->uri->segment(1))?>
                    BARANG UNTUK DIANGKUT DARI TEMPAT<br>
                    PENIMBUNAN BERIKAT KE TEMPAT PENIMBUNAN BERIKAT LAINNYA
                </strong>
            </td>
            
		</tr>
        <tr>
        	<td colspan="3" class="border-b"><b>HEADER</b></td>
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
        </tr>
	</table>
    <table width="100%" cellpadding="2" cellspacing="0" style="table-layout: fixed;font-size:10;font-family:Arial, Helvetica, sans-serif">
         <tr>
            <td width="60%" colspan="2">
                <table>
                    <tr>
                        <td class="bold">NOMOR PENGAJUAN</td>
                        <td>:</td>
                        <td><?=$this->fungsi->FormatAju($no_pengajuan);?></td>
                    </tr>
                </table>
            </td>
            <td width="40%">
            </td>
        </tr>
        <tr>
            <td class="bold" colspan="2">A. KANTOR PABEAN</td>
            <td><table>
                    <tr>
                        <td class="bold">D. TUJUAN PENGIRIMAN</td>
                        <td>: <?=$tujuan_pengiriman;?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="bold" colspan="2">
                <table cellpadding="2" style="table-layout: fixed; width: 100%;" >
                    <tr>
                        <td width="20%" style="padding-left:15px">1. Kantor Asal</td>
                        <td width="1%">:</td>
                        <td width="79%"><?=$DATA['KODE_KPBC_ASAL'].' - '.$kantor_asal;?></td>
                    </tr>
                    <tr>
                        <td style="padding-left:15px">2. Kantor Tujuan</td>
                        <td>:</td>
                        <td><?=$DATA['KODE_KPBC_TUJUAN'].' - '.$kantor_tujuan;?></td>
                    </tr>
                    <tr>
                        <td class="bold">B. JENIS TPB ASAL</td>
                        <td>:</td>
                        <td><?=$DATA['JENIS_TPB_ASAL'].' - '.$tpb_asal;?></td>
                    </tr>
                    <tr>
                        <td class="bold">C. JENIS TPB TUJUAN</td>
                        <td>:</td>
                        <td><?=$DATA['JENIS_TPB_TUJUAN'].' - '.$tpb_tujuan;?></td>
                    </tr>
                </table>
            </td>
            <td class="bold border-l border-t" valign="top" style="padding:3px">
                G. KOLOM KHUSUS BEA DAN CUKAI
                <table cellpadding="2" style="table-layout: fixed; width: 100%; margin-left:12px">
                    <tr>
                        <td class="nobold">Nomor Pendaftaran</td>
                        <td >:</td>
                        <td><?=$no_pendaftaran;?></td>
                    </tr>
                    <tr>
                        <td class="nobold">Tanggal</td>
                        <td >:</td>
                        <td><?=$tgl_daftar;?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="border-b border-t bold">E. DATA PEMBERITAHUAN</td>
        </tr>
        <tr>
            <td colspan="2" class="border-b border-r bold">TPB ASAL BARANG</td>
            <td class="border-b bold">TPB TUJUAN BARANG</td>
        </tr>
        <tr>
            <td colspan="2" valign="top">
                <table cellpadding="2" style="table-layout: fixed; width: 100%;">
                    <tr>
                        <td style="width:35%">1. NPWP</td>
                        <td style="width:5%">:</td>
                        <td style="width:60%"><?=$this->fungsi->FORMATNPWP($npwp_tpbasal);?></td>
                    </tr>
                    <tr>
                        <td>2. Nama</td>
                        <td >:</td>
                        <td><?=$nama_tpbasal;?></td>
                    </tr>
                    <tr>
                        <td valign="top">3. Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$alamat_tpbasal;?></td>
                    </tr>
                    <tr>
                        <td>4. No Izin TPB</td>
                        <td>:</td>
                        <td><?=$no_izintpbasal;?></td>
                    </tr>
                </table>
            </td>
            <td>
                <table cellpadding="2" style="table-layout: fixed; width: 100%;">
                    <tr>
                        <td style="width:35%">5. NPWP</td>
                        <td style="width:5%">:</td>
                        <td style="width:60%"><?=$this->fungsi->FORMATNPWP($npwp_tpbtujuan);?></td>
                    </tr>
                    <tr>
                        <td>6. Nama</td>
                        <td >:</td>
                        <td><?=$nama_tpbtujuan;?></td>
                    </tr>
                    <tr>
                        <td valign="top">7. Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top"><?=$alamat_tpbtujuan;?></td>
                    </tr>
                    <tr>
                        <td>8. No Izin TPB</td>
                        <td>:</td>
                        <td><?=$no_izintpbtujuan;?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="3" class="border-t border-b bold">DOKUMEN PELENGKAP PABEAN</td>
        </tr>
        <tr>
        	<td colspan="2" valign="top">
        		<table cellpadding="2" style="table-layout: fixed; width: 100%;">
                    <tr>
                        <td style="width:35%">9. Invoice</td>
                        <td style="width:5%">:</td>
                        <? if($lihatlampiran){ ?>
                        <td style="width:60%"><?= $lihatlampiran?></td>
                        <? }else{ ?>
                        <td width="60%"><?= $invoce;?>&nbsp;&nbsp;&nbsp;tgl. <?=$this->fungsi->FormatDate($tgl_invoce);?></td>
                        <? } ?>
                    </tr>
                    <tr>
                        <td>10. Packing List</td>
                        <td >:</td>
                        <? if($lihatlampiran){ ?>
                        <td style="width:60%"><?= $lihatlampiran?></td>
                        <? }else{ ?>
                        <td width="60%"><?= $no_packing;?>&nbsp;&nbsp;&nbsp;tgl. <?=$this->fungsi->FormatDate($tgl_packing);?></td>
                        <? } ?>
                    </tr>
                    <tr>
                        <td valign="top">11. Kontrak</td>
                        <td valign="top">:</td>
                         <? if($lihatlampiran){ ?>
                        <td style="width:60%"><?= $lihatlampiran?></td>
                        <? }else{ ?>
                        <td width="60%"><?= $no_kontrak;?>&nbsp;&nbsp;&nbsp;tgl. <?=$this->fungsi->FormatDate($tgl_kontrak);?></td>
                        <? } ?>
                    </tr>
                </table>
        	</td>
        	<td>
        		<table cellpadding="2" style="table-layout: fixed; width: 100%;">
                    <tr>
                        <td style="width:35%">12. Surat Jalan</td>
                        <td style="width:5%">:</td>
                        <? if($lihatlampiran){ ?>
                        <td style="width:60%"><?= $lihatlampiran?></td>
                        <? }else{ ?>
                        <td width="60%"><?= $surat_jalan;?>&nbsp;&nbsp;&nbsp;tgl. <?=$this->fungsi->FormatDate($tgl_surat_jalan);?></td>
                        <? } ?>
                    </tr>
                    <tr>
                        <td>13. Surat Keputusan/Persetujuan</td>
                        <td colspan="2">:</td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= $srt_keputusan;?></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tgl. <?=$this->fungsi->FormatDate($tgl_packing);?></td>
                    </tr>
                    <tr>
                        <td valign="top">14. Lainnya</td>
                        <td valign="top">:</td>
                        <td width="60%"><?=$lihatlampiran?$lihatlampiran:$no_lainnya?></td>
                    </tr>
                </table>
        	</td>
        </tr>
        <tr>
        	<td colspan="3" class="border-t border-b bold">RIWAYAT BARANG</td>
        </tr>
        <tr>
        	<td>
        		<table cellpadding="2" style="table-layout: fixed; width: 100%;">
                    <tr>
                    	<td>15. Nomor dan tanggal BC 2.7 Asal</td>
                    	<td>:</td>
                    	<td><?
                        	$SQL = "SELECT NOMOR_DAFTAR, DATE_FORMAT(TANGGAL_DAFTAR,'%d-%m-%Y') TANGGAL_DAFTAR FROM t_bc27_dokasal 
									WHERE NOMOR_AJU='".$AJU."'";	
							$rs = $this->db->query($SQL);		
							if($rs->num_rows()>0){
								foreach($rs->result_array() as $row){
									echo $row["NOMOR_DAFTAR"].'&nbsp;Tgl : '.$row["TANGGAL_DAFTAR"].'&nbsp;,';
								}	
							}
                        ?></td>
                    </tr>
            	</table>
        	</td>
        </tr>
        <tr>
        	<td colspan="3" class="border-t border-b bold">DATA PERDAGANGAN</td>
        </tr>
        <tr>
        	<td colspan="2" valign="top">
        		<table cellpadding="2" style="table-layout: fixed; width: 100%;">
                    <tr>
                    	<td>16. Jenis Valuta Asing</td>
                    	<td>:</td>
                    	<td><?=$kd_valuta.' - '.$jenis_valuta;?></td>
                    </tr>
                    <tr>
                    	<td>17. CIF</td>
                    	<td>:</td>
                    	<td><?=$this->fungsi->FormatRupiah($cif,4);?></td>
                    </tr>
                </table>
        	</td>
        	<td valign="top">
        		<table cellpadding="2" style="table-layout: fixed; width: 100%;">
                    <tr>
                    	<td>18. Harga Penyerahan</td>
                    	<td>:</td>
                    	<td><?=$this->fungsi->FormatRupiah($hrg_penyerahan,2);?></td>
                    </tr>
                </table>
        	</td>
        </tr>
        <tr>
        	<td colspan="2" class="border-t border-b border-r bold">DATA PENGANGKUTAN</td>
        	<td class="border-t border-b bold" align="center">SEGEL (DIISI OLEH BEA DAN CUKAI)</td>
        </tr>
        <tr>
        	<td colspan="2" class="border-r" valign="top">
        		<table cellpadding="2" width="100%" style="margin-left:-2px;margin-right:-2px;table-layout: fixed;">
                    <tr>
                    	<td width="69%">19. Jenis Sarana Pengangkut Darat :</td>
                    	<td width="0%">&nbsp;</td>
                    	<td width="30%">20. No. Polisi :</td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$jenis_angkut;?></td>
                    	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$no_polisi;?></td>
                    </tr>
                    <tr>
                    	<td colspan="3" class="border-t border-b bold">DATA PETI KEMAS DAN PENGEMAS</td>
                    </tr>
                    <tr>
                    	<td colspan="2">24. Merk dan No Kemasan/Peti Kemas dan jumlah petikemas</td>
                    	<td>25. Jumlah dan Jenis Kemasan</td>
                    </tr>
                     <? if(count($KEMASAN)>1){ ?>
                     <?php foreach($KEMASAN as $kms):?>
                     	<tr>
	                     	<td colspan="2"><?=$kms["MERK_KEMASAN"];?></td>
	                     	<td><?=$kms["JUMLAH"].' &nbsp; '.$kms["URKODE_KEMASAN"];?></td>
	                    </tr>
                    <?php  endforeach;?>
                    <? }else{ ?>
                    	<tr>
	                     	<td colspan="2"><?=$merk_kemasan;?></td>
	                     	<td><?=$jml_kemasan.' &nbsp; '.$jns_kemasan;?></td>
	                    </tr>
	                <? } ?>
                </table>
            </td>
            <td valign="top" style="padding:0px">
            	<table cellpadding="2" width="300px" style="table-layout: fixed;">
                    <tr>
                    	<td colspan="2" class="border-b border-r" align="center">BC Asal</td>
                    	<td align="center">23. Catatan BC</td>
                    </tr>
                    <tr>
                    	<td width="30%" class="border-b border-r" align="center">21. No Segel</td>
                    	<td width="30%" class="border-b border-r" align="center">22. Jenis</td>
                    	<td width="40%" class="border-b" align="center">Tujuan</td>
                    </tr>
                    <tr>
                    	<td class="border-r"><?=$no_segel;?></td>
                        <td class="border-r"><?=$jns_bcasal_ur;?></td>
                        <td><?=$catatan_bctujuan;?></td>
                    </tr>
                    <tr>
                    	<td class="border-r">&nbsp;</td>
                        <td class="border-r">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    	<td class="border-r">&nbsp;</td>
                        <td class="border-r">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <? if(count($KEMASAN)>1){ ?>
                     <?php foreach($KEMASAN as $kms):?>
                     <tr>
                    	<td class="border-r">&nbsp;</td>
                        <td class="border-r">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                	<?php  endforeach;}?>
                    <tr>
                    	<td class="border-r">&nbsp;</td>
                        <td class="border-r">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="3" class="border-t border-b bold">DATA BARANG</td>
        </tr>
        <tr>
        	<td colspan="3" class="border-b">
        		<table cellpadding="2" width="100%" style="table-layout: fixed;">
                    <tr>
                    	<td width="34%">26. Volume (m<sup>3</sup>) : <?=$volume;?></td>
                    	<td width="1%">&nbsp;</td>
                    	<td width="35%">27. Berat Kotor (Kg) : <?=$this->fungsi->FormatRupiah($berat_kotor,4);?></td>
                    	<td width="30%">28. Berat Bersih (Kg) : <?=$this->fungsi->FormatRupiah($berat_bersih,4);?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="3" valign="top" style="padding:0px">
        		<table cellpadding="2" width="100%" style="table-layout: fixed;">
                    <tr>
                    	<td valign="top" class="border-br" width="10%">29.<br>No</td>
                    	<td valign="top" class="border-b" width="39%">30.<br>Pos tarif/HS, uraian jumlah dan jenis barang secara lengkap, kode barang, merk, tipe, ukuran, dan spesifikasi lain</td>
                    	<td width="1%" class="border-br"></td>
                    	<td valign="top" class="border-br" width="30%">31.<br>- Jumlah & Jenis Satuan<br>
                    			   - Berat Bersih (Kg)<br>
                    			   - Volume (m<sup>3</sup>)</td>
                    	<td valign="top" class="border-b" width="30%">32.<br>- Nilai CIF<br>
                    			   - Harga Penyerahan</td>
                    </tr>
                    <?php if (count($BARANG) ==1){ ?>
					<?php $no=1;?>
					<?php foreach( $BARANG as $bar):?>
					<tr>
						<td class="border-r" valign="top"><?=$no;?></td>
						<td rowspan="3" colspan="2" valign="top" class="border-r"><?=$bar['KODE_HS'].', '.$bar['KODE_BARANG'];?>
						<br>
						<?=$bar['URAIAN_BARANG'];?>
						,
						<?=$bar['MERK']?>
						,
						<?=$bar['TIPE']?>
						,
						<?=$bar['UKURAN']?>
						,
						<?=$bar['SPFLAIN']?></td>
						<td class="border-r" valign="top">- <?=$this->fungsi->FormatRupiah($bar['JUMLAH_SATUAN'],2);?>
						<br>
						- <?=$bar['URKODE_SATUAN'];?>
						<br>
						- <?=$this->fungsi->FormatRupiah($bar['NETTO'],4);?></td>
						<td valign="top">- <?=$this->fungsi->FormatRupiah($bar['CIF'],2);?>
						<br>
						- <?=$this->fungsi->FormatRupiah($bar['HARGA_PENYERAHAN'],2)?></td>
					</tr>
					<?php  endforeach;?>
					<?php }elseif((count($BARANG) < 1)){ ?>
					<tr>
						<td colspan="5" align="center">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5" align="center">--- Belum Terdapat Data Barang --- </td>
					</tr>
					<tr>
						<td colspan="5" align="center">&nbsp;</td>
					</tr>
					<?php }else{ ?>
					<tr>
						<td colspan="5" align="center">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5" align="center">--- <?=count($BARANG)?> Jenis Barang. Lihat lembar lanjutan --- </td>
					</tr>
					<tr>
						<td colspan="5" align="center">&nbsp;</td>
					</tr>
					<?php }?>
					<tr>
			        	<td colspan="3" class="border-t border-b border-r bold">F. TANDA TANGAN PENGUSAHA TPB</td>
			        	<td colspan="2" class="border-t border-b bold">H. UNTUK PEJABAT BEA DAN CUKAI</td>
			        </tr>
			        <tr>
			        	<td class="border-r" colspan="3" valign="top">Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini.</td>
			        	<td class="border-br" align="center" valign="middle">Kantor Pabean Asal</td>
			        	<td class="border-b" align="center" valign="middle">Kantor Pabean Tujuan</td>
			        </tr>
			        <tr>
			        	<td class="border-r" colspan="3" valign="top" align="center"><?=$kota_ttd.', Tgl. '.$tanggal_ttd; ?></td>
			        	<td class="border-r" align="center" valign="middle">&nbsp;</td>
			        	<td align="center" valign="middle">&nbsp;</td>
			        </tr>
			        <tr>
			        	<td class="border-r" colspan="3">&nbsp;</td>
			        	<td class="border-r">&nbsp;</td>
			        	<td>&nbsp;</td>
			        </tr>
			        <tr>
			        	<td class="border-r" colspan="3">&nbsp;</td>
			        	<td class="border-r">Nama : <?=$nama_pejabat_asal;?></td>
			        	<td>Nama : <?=$nama_pejabat_tujuan;?></td>
			        </tr>
			        <tr>
			        	<td class="border-r" colspan="3" align="center">( <?=$nama_ttd;?> )</td>
			        	<td class="border-r">NIP : <?=$nip_pejabat_asal;?></td>
			        	<td>NIP : <?=$nip_pejabat_tujuan;?></td>
			        </tr>
                </table>
        	</td>
        </tr>
    </table>
	
</div>
<?php
if (count($BARANG) > 1){ 
echo "<pagebreak>";
$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_lanjutan");
}
if(count($DOKUMEN)>0){
echo "<pagebreak>";
foreach($DOKUMEN as $dok){
$INVOICE = $dok['JENIS_DOKUMEN'];	   
}
$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_dokumen");		
}
if(count($DATACNT)>0){
echo "<pagebreak>";
$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_container");
}
if(count($BARANGJD)>1){
echo "<pagebreak>";
$this->load->view("pemasukan/bc27/cetak/bc27_lampiran_konversi");
}
?>
</body>
