<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

function getKeterangan($jml){
	if($jml<0) return "SELISIH KURANG";
	if($jml>0) return "SELISIH LEBIH";
	if($jml==0) return "SESUAI";
}
$kodeTrader = $this->newsession->userdata('KODE_TRADER');

$no=1;	
if(count($resultData)>0 && !$cetak){			
?>  
    <div style="margin-bottom:5px";>
    <a href="javascript:void(0);" 
    onclick="print_('<?= base_url();?>index.php/laporan/daftar_dok/posisi/<?= $tglAwal;?>/<?= $tglAkhir;?>','<?= $nama;?>','','','<?=$ALL;?>','<?=$TIPE_PERIODE;?>','<?=$ALL_SALDO?$ALL_SALDO:0;?>','pdf');"><img src="<?= base_url();?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;Cetak PDF</a>&nbsp;&nbsp;&nbsp;
            <a href="<?= site_url();?>/laporan/daftar_dok/posisi/<?=$tglAwal;?>/<?=$tglAkhir;?>/<?=$nama;?>/!/!/<?=$ALL?$ALL:'FALSE';?>/<?=$TIPE_PERIODE;?>/<?=$ALL_SALDO?$ALL_SALDO:0;?>/xls"><img src="<?= base_url();?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;Cetak Excel</a>
    </div>
<? 	} ?>
<table class="tabelPopUp" width="100%">
	<thead>
	<tr>
    	<th rowspan="2" align="center">No</th>
        <th colspan="10">Dokumen Pemasukan</th>
        <th colspan="8">Dokumen Pengeluaran</th>
        <th colspan="3">Saldo Barang</th>
    </tr>    
    <tr>    
        <th>Jenis</th>
        <th>NO</th>
        <th>Tgl</th>
        <th>Tgl<br>Masuk</th>
        <th>Kode<br>Barang</th>
        <th>Seri<br>Barang</th>
        <th>Nama<br>Barang</th>
        <th>Sat</th>
        <th>Jmlh</th>
        <th>Nilai<br>Pabean</th>
        <th>Jenis</th>
        <th>NO</th>
        <th>Tgl</th>
        <th>Tgl<br>Keluar</th>
        <th>Nama<br>Barang</th>
        <th>Sat</th>
        <th>Jmlh</th>
        <th>Nilai<br>Pabean</th>
        <th>Jmlh</th>
        <th>Sat</th>
        <th>Nilai<br>Pabean</th>
    </tr>   
    </thead>
    <tbody>
   <?php
    $banyakData=count($resultData);	
    if($banyakData>0){
		$no=1; 		
		$TOT_KELUAR = 0;
		$ROWSPAN = 0;
		
		#BUAR SORT ORDER------------------------------------------
		$sort = array();
		foreach($resultData as $k=>$v) 
		{ 
			$sort['TGL_DOK_IN'][$k] = $v['TGL_DOK_IN'];
			$sort['NO_DOK_IN'][$k] = $v['NO_DOK_IN'];
			$sort['SERI_BARANG_IN'][$k] = $v['SERI_BARANG_IN'];
			$sort['TGL_MASUK_IN'][$k] = $v['TGL_MASUK_IN'];
			$sort['KODE_BARANG_IN'][$k] = $v['KODE_BARANG_IN'];
			$sort['TGL_MASUK_OUT'][$k] = $v['TGL_MASUK_OUT'];
		}
		array_multisort($sort['TGL_DOK_IN'], SORT_ASC, 
						$sort['NO_DOK_IN'], SORT_ASC, 
						$sort['SERI_BARANG_IN'], SORT_ASC,
						$sort['TGL_MASUK_IN'], SORT_ASC,
						$sort['KODE_BARANG_IN'], SORT_ASC,
						$sort['TGL_MASUK_OUT'], SORT_ASC,
						$resultData);
		#---------------------------------------------------------		
		
		foreach($resultData as $row_in)
		{				
			#KOLOM PEMASUKAN					
   ?>	
            <tr>    
                <td align="center"><?= $no;?></td>
                <td><?=$row_in["JENIS_DOK_IN"]?></td>
                <td><?=$row_in["NO_DOK_IN"]?></td>
                <td><?=$this->fungsi->dateFormat($row_in["TGL_DOK_IN"])?></td>
                <td><?=$this->fungsi->dateFormat($row_in["TGL_MASUK_IN"])?></td>
                <td><?=$row_in["KODE_BARANG_IN"]?></td>
                <td><?=$row_in["SERI_BARANG_IN"]?></td>
                <td><?=$row_in["NAMA_BARANG_IN"]?></td>
                <td><?=$row_in["SATUAN_IN"]?></td>
               	            
    <?php  
			#KOLOM PENGELUAAN			
			#QUERY UNTUK NGITUNG JUMLAH PENGELUARAN SEBELUMNYA
			if($TIPE_PERIODE != "IN"){
				$SQLOUT ="SELECT IFNULL(SUM(JUMLAH),0) AS JUMKELUAR_SEBELUMNYA, 
						  IFNULL(SUM(NILAI_PABEAN),0) NILAI_PABEAN_SEBELUMNYA
						  FROM t_logbook_pengeluaran
						  WHERE LOGID_MASUK = '".$row_in["LOGID_IN"]."' AND TGL_DOK < '".$tglAwal."' "; 					
				$RSS = $this->db->query($SQLOUT)->row();
				$JUMKELUAR_SEBELUMNYA = $RSS->JUMKELUAR_SEBELUMNYA;
				$NILAI_PABEAN_SEBELUMNYA = $RSS->NILAI_PABEAN_SEBELUMNYA;	
								
				if($JUMKELUAR_SEBELUMNYA>0) $row_in["JUMLAH_IN"] = $row_in["JUMLAH_IN"]-$JUMKELUAR_SEBELUMNYA;
				if($NILAI_PABEAN_SEBELUMNYA>0) $row_in["NILAI_PABEAN_IN"] = $row_in["NILAI_PABEAN_IN"]-$NILAI_PABEAN_SEBELUMNYA;
				
			}
			
			$TOT_JML = $row_in["JUMLAH_IN"];
			$TOT_SAT = $row_in["SATUAN_IN"];
			$TOT_PBN = $row_in["NILAI_PABEAN_IN"];
			
			#BUAT CEK SALDO DILUAR PERIODE [PERIODE PEMASUKAN]--------------------------------------------
			if($TIPE_PERIODE == 'IN')
			{
				echo '<td align="right">'.$this->fungsi->FormatRupiah($row_in["JUMLAH_IN"],2).'</td>';
				echo '<td align="right">'.$this->fungsi->FormatRupiah($row_in["NILAI_PABEAN_IN"],2).'</td>';
			}
			#BUAT CEK SALDO DILUAR PERIODE [PERIODE PENGELUARAN]------------------------------------------
			elseif($TIPE_PERIODE == 'OUT' || $TIPE_PERIODE == 'INOUT')
			{
				$curDate = '';				
				$TOT_JML_TMP_1 = 0;
				$TOT_PBN_TMP_1 = 0;
				foreach($row_in['KELUAR'] as $key => $row_out)
				{				
					$DILUAR_PERIODE = FALSE;					
					if($ALL_SALDO)
					{
						#jika tanggal dokumen keluar ga ada di range pencarian							
						$curDate = strtotime($row_out["TGL_DOK_OUT"]);
						if($curDate < strtotime($tglAwal) || $curDate > strtotime($tglAkhir))
						{
							/*$TOT_JML_TMP_1 = $TOT_JML_TMP_1 + $row_out["JUMLAH_OUT"];
							$TOT_PBN_TMP_1 = $TOT_PBN_TMP_1 + $row_out["NILAI_PABEAN_OUT"];*/
							
							unset($row_in['KELUAR'][$key]);
							//$DILUAR_PERIODE = TRUE;
						}   
					}
				}	
				/*if($DILUAR_PERIODE)
				{						
					//if($row_in["LOGID_IN"]=='41511') echo $row_in["JUMLAH_IN"].'-'.$TOT_JML_TMP_1;			
					
					$TOT_JML = $row_in["JUMLAH_IN"] - $TOT_JML_TMP_1;
					$TOT_PBN = $row_in["NILAI_PABEAN_IN"] - $TOT_PBN_TMP_1;
					
					echo '<td align="right">'.$this->fungsi->FormatRupiah($TOT_JML,2).'</td>';
					echo '<td align="right">'.$this->fungsi->FormatRupiah($TOT_PBN,2).'</td>';
				}
				else{*/
					echo '<td align="right">'.$this->fungsi->FormatRupiah($row_in["JUMLAH_IN"],2).'</td>';
					echo '<td align="right">'.$this->fungsi->FormatRupiah($row_in["NILAI_PABEAN_IN"],2).'</td>';		
				//}
			}
			#-----------------------------------------------------------------------------------------------	
				
			$TOT_KELUAR = count($row_in['KELUAR']);
			
			if($TOT_KELUAR > 0)
			{				
				$TOT_JML_TMP = 0;
				$TOT_PBN_TMP = 0;
				$LOP = 0;	
				
				#AMBIL TOTAL PENGELUARAN UNTUK KOLOM TOTAL SALDO BARANG	
				$curDate = '';		
				foreach($row_in['KELUAR'] as $key => $row_out)
				{					
					$TOT_JML_TMP = $TOT_JML_TMP + $row_out["JUMLAH_OUT"];
					$TOT_PBN_TMP = $TOT_PBN_TMP + $row_out["NILAI_PABEAN_OUT"];
				}		
				$TOT_JML = $row_in["JUMLAH_IN"] - $TOT_JML_TMP;
				$TOT_SAT = $row_out["SATUAN_OUT"];
				$TOT_PBN = $row_in["NILAI_PABEAN_IN"] - $TOT_PBN_TMP;
				
				#VIEW KOLOM PENGELUARAN
				foreach($row_in['KELUAR'] as $row_out)
				{
					if($LOP > 0){
	?>					
                        <tr>    
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
                        <td>&nbsp;</td>	
    <?php                    
					}
	?>			
                    <td><?=$row_out["JENIS_DOK_OUT"]?></td>
                    <td><?=$row_out["NO_DOK_OUT"]?></td>
                    <td><?=$this->fungsi->dateFormat($row_out["TGL_DOK_OUT"])?></td>
                    <td><?=$this->fungsi->dateFormat($row_out["TGL_MASUK_OUT"])?></td>
                    <td><?=$row_out["NAMA_BARANG_OUT"]?></td>
                    <td><?=$row_out["SATUAN_OUT"]?></td>
                    <td align="right"><?=$row_out["JUMLAH_OUT"]?$this->fungsi->FormatRupiah($row_out["JUMLAH_OUT"],2):''?></td>
                    <td align="right"><?=$row_out["NILAI_PABEAN_OUT"]?$this->fungsi->FormatRupiah($row_out["NILAI_PABEAN_OUT"],2):''?></td>
     <?php
	 				if($LOP == 0){
	 ?>               
                        <td align="right"><?=$this->fungsi->FormatRupiah($TOT_JML,2)?></td>
                        <td><?=$TOT_SAT?></td>
                        <td align="right"><?=$this->fungsi->FormatRupiah($TOT_PBN,2)?></td>  
                    </tr> 
    <?php 
					}else{	
	?>									
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>	
                    </tr> 
    <?php                
					}							
					$LOP++;
				}		
			}else{
	?>			
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>	
					<td>&nbsp;</td>   
                    <td align="right"><?=$this->fungsi->FormatRupiah($TOT_JML,2)?></td>
                    <td><?=$TOT_SAT?></td>
                    <td align="right"><?=$this->fungsi->FormatRupiah($TOT_PBN,2)?></td>  
                </tr>  	
    <?php                
			}
			$no++;  
		}
	}else{?>
	<tr>
		<td colspan="23" align="center">Nihil</td>
	</tr>
    <? } ?> 
</table>