<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<table width="100%" border="0">
	<tr>
		<td width="45%" valign="top">	
			<table width="90%" border="0">
            	<tr>
                	<td colspan="2"><h5 class="header smaller lighter green"><strong>Kantor Pabean</strong></h5></td>
                </tr>
            	<tr>
                	<td class="social-list strong" width="35%">Nomor Aju</td>
                    <td class="social-list"><?=$this->fungsi->FormatAju($sess["NOMOR_AJU"])?></td>
                </tr>
    			<tr>
        			<td class="social-list strong">Kantor Pabean</td>
        			<td class="social-list"><?= $sess['KODE_KPBC']; ?> - <?= $sess['URAIAN_KPBC']?$sess['URAIAN_KPBC']:$URKANTOR_TUJUAN; ?></td>
    			</tr>
    			<tr>
        			<td class="social-list strong">Jenis TPB</td>
        			<td class="social-list"><?= $sess['JENIS_TPB']." - ".$sess["UR_JENIS_TPB"]?></td>
    			</tr>
    			<tr>
        			<td class="social-list strong">Tujuan Pengiriman</td>
        			<td class="social-list"><?= $sess['TUJUAN_KIRIM']." - ".$sess["UR_TUJUAN_KIRIM"]?></td>
   				</tr>
			</table>
		</td>
        <td width="55%">
    		<table width="90%">
            	<tr>
                	<td colspan="2"><h5 class="header smaller lighter red"><i>Informasi Bea dan Cukai</i></h5></td>
                </tr>
        		<tr>
            		<td class="social-list strong">Nomor Pendaftaran</td>
            		<td class="social-list">
						<?php 
							if($sess['NOMOR_PENDAFTARAN']){
								echo $sess['NOMOR_PENDAFTARAN'];
							}
						?>
                 	</td>
        		</tr>
       			<tr>
            		<td class="social-list strong">Tanggal Pendaftaran</td>
            		<td class="social-list">
            			<?php 
							if($sess['TANGGAL_PENDAFTARAN']){
								echo $sess['TANGGAL_PENDAFTARAN'];
							}
						?>
					</td>
        		</tr>
        		<tr>
            		<td class="social-list strong">No. Persetujuan Pengeluaran</td>
            		<td class="social-list">
            			<?php 
							if($sess['STATUS_DOK']=="LENGKAP"){
								echo $sess['NOMOR_DOK_PABEAN'];
							}
						?>
                  	</td>
        		</tr>
        		<tr>
            		<td class="social-list strong">Tanggal Persetujuan Pengeluaran</td>
            		<td class="social-list">
            			<?php 
							if($sess['STATUS_DOK']=="LENGKAP"){
								($sess['TANGGAL_DOK_PABEAN']=='0000-00-00')?'':$sess['TANGGAL_DOK_PABEAN'];
							}
						?>
                 	</td>
        		</tr>
         		<tr>
            		<td class="social-list strong">Nama Pejabat BC</td>
            		<td class="social-list">
            			<?php 
							if($sess['STATUS_DOK']=="LENGKAP"){
								echo $sess['NAMA_PEJABAT_BC'];
							}
						?>
                    </td>
        		</tr>
         		<tr>
            		<td class="social-list strong">NIP Pejabat BC</td>
            		<td class="social-list">
            			<?php 
							if($sess['STATUS_DOK']=="LENGKAP"){
								echo $sess['NIP_PEJABAT_BC'];
							}
						?>
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
        	<table width="90%" border="0">
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>PENGUSAHA TPB</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong" width="35%">Identitas</td>
                    <td class="social-list"><?= $sess['KODE_ID_TRADER']." - ".$sess["UR_KODE_ID_TRADER"] ?> - <?= $this->fungsi->FORMATNPWP($sess['ID_TRADER']); ?></td>
                </tr> 
                <tr>
                    <td class="social-list strong">Nama </td>
                    <td class="social-list"><?= $sess['NAMA_TRADER']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Alamat </td>
                    <td class="social-list"><?= $sess['ALAMAT_TRADER']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong" >No Ijin TPB </td>
                    <td class="social-list" ><?= $sess['NOMOR_IZIN_TPB']?$sess['NOMOR_IZIN_TPB']:$sess['NOMOR_SKEP']; ?></td>
                </tr>
    			<tr>
					<td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PENGANGKUTAN</b></h5></td>
				</tr>
    			<tr>
                    <td class="social-list strong">Jenis Sarana Pengangkut Darat</td>
                    <td class="social-list"><?= $sess['JENIS_SARANA_ANGKUT']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nomor Polisi </td>
                    <td class="social-list"><?= $sess['NOMOR_POLISI']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA PERDAGANGAN</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Harga Penyerahan (Rp) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['HARGA_PENYERAHAN'],2); ?></td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                	<td colspan="2">
                  		<h5 class="smaller lighter blue"><b>Riwayat Barang Asal BC 4.0</b></h5>
                      	<table width="100%" border="0" id="TBLASAL">
                      		<tbody>
                      			<?php echo $dataasal; ?>
                      		</tbody>
                      	</table>
                  	</td>
				</tr>
			</table>
		</td>
		<td width="55%" valign="top">
            <table width="90%" border="0">
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>DATA BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Volume (M3) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['VOLUME'],4); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Berat Kotor (Kg) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['BRUTO'],4); ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Berat Bersih (Kg) </td>
                    <td class="social-list"><?= $this->fungsi->FormatRupiah($sess['JUM_NETTO'],2); ?>&nbsp; Kilogram (KGM)</td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>PENERIMA BARANG</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Identitas</td>
                    <td class="social-list"><?= $sess['KODE_ID_PENERIMA']." - ".$sess["UR_KODE_ID_PENERIMA"]?> - <?php if($sess['KODE_ID_PENERIMA']==5){echo $this->fungsi->FORMATNPWP($sess['ID_PENERIMA']);}else{ echo $sess['ID_PENERIMA'];}?></td>
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_PENERIMA']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Alamat</td>
                    <td class="social-list"><?= $sess['ALAMAT_PENERIMA']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="rowheight"><h5 class="smaller lighter blue"><b>TANDA TANGAN PENGUSAHA TPB</b></h5></td>
                </tr>
                <tr>
                    <td class="social-list strong">Nama</td>
                    <td class="social-list"><?= $sess['NAMA_TTD']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tempat</td>
                    <td class="social-list"><?= $sess['KOTA_TTD']; ?></td>
                </tr>
                <tr>
                    <td class="social-list strong">Tanggal</td>
                    <td class="social-list"><?= ($sess['TANGGAL_TTD'])?$sess['TANGGAL_TTD']:date("Y-m-d"); ?></td>
                </tr>
        	</table>
		</td>
    </tr>
	<tr>
 		<td colspan="2">&nbsp;</td>
	</tr>
</table>

<?php  
if($priview){
	echo '<h4 class="header smaller lighter green"><i class="icon-list"></i>&nbsp;<b>Detil Dokumen</b></h4>'.$DETILPRIVIEW;
} 