<?php
#PARAMETER 
/*$no_pengajuan		= "050300-000001";
$kantor_asal		= "KPPBC BOGOR";
$kantor_tujuan		= "JAKARTA";
$tujuan_pengiriman	= "BANDUNG";
$no_pendaftaran		= "..................";
$tgl_daftar			= "..................";
$no_urut			= "1";
$jns_dokumen		= "PAPER";
$nomor				= "2495950";	
$tanggal			= "12/12/2012";*/
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
						  
			  .border-br {
						  border-bottom:thin solid #000000;
						  border-right:thin solid #000000;
						  }
			  .border-tbrl {
						  border-top:thin solid #000000;
						  border-bottom:thin solid #000000;
						  border-right:thin solid #000000;
						  border-left:thin solid #000000;
						  }
			  </style>
	<div class="border-tbrl">
	    <table width="100%" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center">
                <td width="16%" align="center" class="border-r" height="50"><strong>BC 2.7</strong> </td>
                <td width="84%" align="center" height="50"><strong>LEMBAR LANJUTAN<br>
                  DATA PETI KEMAS / CONTAINER</strong></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2" class="border-b"><table width="100%" border="0" cellpadding="5">
                <tr>
                  <td>HEADER </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="2" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    <td width="25%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td colspan="4" align="right">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">NO PENGAJUAN</td>
                    <td>: <?=$this->fungsi->FormatAju($DATA['NOMOR_AJU']);?></td>
                    <td>&nbsp;</td>
                    <td>D.</td>
                    <td colspan="4">TUJUAN PENGIRIMAN: <?=$DATA['URTUJUAN_PENGIRIMAN'];?></td>
                  </tr>
                  <tr>
                    <td width="3%">A.</td>
                    <td colspan="2">KANTOR PABEAN </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="4">&nbsp;</td>
                  </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td width="18%">1. Kantor Asal</td>
                    <td>: <?=$DATA['URAIAN_KPBC_ASAL'];?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="4">&nbsp;</td>
                  </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td>2. Kantor Tujuan</td>
                    <td>: <?=$DATA['URAIAN_KPBC_TUJUAN'];?></td>
                    <td class="border-r">&nbsp;</td>
                    <td class="border-t">G.</td>
                    <td colspan="4" class="border-t">KOLOM KHUSUS BEA DAN CUKAI</td>
                  </tr>
                   <tr>
                     <td>B.</td>
                     <td>JENIS TPB ASAL</td>
                    <td>: <?=$DATA['URJENIS_TPB_ASAL'];?></td>
                    <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="14%">Nomor Pendaftaran</td>
                    <td width="20%">: <?=$DATA['NOMOR_PENDAFTARAN'];?></td>
                    <td width="1%">&nbsp;</td>
                    <td width="7%">&nbsp;</td>
                  </tr>
                   <tr>
                     <td>C.</td>
                     <td>JENIS TPB TUJUAN</td>
                     <td>: <?=$DATA['URJENIS_TPB_TUJUAN'];?></td>
                     <td class="border-r">&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>Tanggal</td>
                     <td>: <?=$DATA['TANGGAL_PENDAFTARAN'];?></td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                   </tr>
                   <tr>
                     <td class="border-br border-t">NO</td>
                     <td colspan="2" class="border-b border-t">NOMOR</td>
                     <td class="border-br border-t">&nbsp;</td>
                     <td class="border-b border-t">&nbsp;</td>
                     <td class="border-br border-t">UKURAN</td>
                     <td class="border-b border-t">TIPE</td>
                     <td class="border-b border-t">&nbsp;</td>
                     <td class="border-b border-t">&nbsp;</td>
                   </tr>
                    <?php if (count($DATACNT) > 0){//print_r($DATACNT);//exit; ?>
              	    <?php $no=1;
					$query = $this->db->query("SELECT NOMOR AS NOMOR_KON ,f_ref('UKURAN_CNT',UKURAN) AS UKURAN_KON,	f_ref('JENIS_STUFF',TIPE) AS TIPE_KON	
						FROM t_bc27_cnt WHERE NOMOR_AJU= $DATA[NOMOR_AJU]");
					foreach ($query->result() as $row){?>
                   <tr>
                     <td class="border-r"><?=$no;?></td>
                     <td colspan="2"> &nbsp;<?= $row->NOMOR_KON;?></td>
                     <td class="border-r">&nbsp;</td>
                     <td>&nbsp;</td>
                     <td class="border-r"><?= $row->UKURAN_KON;?></td>
                     <td align="center"><?= $row->TIPE_KON;?></td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                   </tr>
                    <?php $no++; };?>
                    <?php }else{?>
                   <tr>
                     <td class="border-r">&nbsp;</td>
                     <td colspan="2">&nbsp;</td>
                     <td class="border-r">&nbsp;</td>
                     <td>&nbsp;</td>
                     <td class="border-r">&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                   </tr>
                   <?php } ?>  
                </table></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
		    <td colspan="2"><table width="100%" border="0">
            
            </table></td>
	      </tr>
		  <tr>
		    <td width="42%" class="border-b">&nbsp;</td>
	        <td width="58%" class="border-b">E. TANDA TANGAN PENGUSAHA TPB</td>
          </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td align="center">&nbsp;</td>
		    <td align="center"><?=$DATA['KOTA_TTD'].",";?> tgl <?=$DATA['TANGGAL_TTD'];?></td>
	      </tr>
		  <tr>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
	      </tr>
		  <tr>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td align="center">(<?=$DATA['NAMA_TTD'];?>)</td>
	      </tr>
        </table>
	  </div>

<pagebreak />