	
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
			  </style>';
				
	
	<div style="padding:30px 50px 30px 50px;">
   
		<table align="center" style="width:100%; padding-left:50px; padding-right:50px;">
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
        </table>
		<div class="border-tbrl">
	    <table width="100%" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2" class="border-b"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center">
                <td width="16%" align="center" class="border-r" height="50"><strong>BC 2.7</strong> </td>
                <td width="84%" align="center" height="50"><strong>LEMBAR LAMPIRAN</strong><BR>
                  <strong>KONVERSI PEMAKAIAN BAHAN (SUBKONTRAK) </strong></td>
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
                <td><table width="100%" height="121" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    <td width="37%">&nbsp;</td>
                    <td width="1%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td width="18%">&nbsp;</td>
                    <td width="1%">&nbsp;</td>
                    <td width="24%" align="right">Halaman 1 dari............</td>
                  </tr>
                   <tr>
                     <td colspan="2">&nbsp; NO PENGAJUAN</td>
                     <td>: <?=$DATA['NOMOR_AJU'];?></td>
                     <td>&nbsp;</td>
                     <td>D.</td>
                     <td>TUJUAN PENGIRIMAN</td>
                     <td>: </td>
                     <td><?=$DATA['URTUJUAN_PENGIRIMAN'];?></td>
                   </tr>
                   <tr>
                     <td>&nbsp; A.</td>
                     <td width="15%">KANTOR PABEAN </td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                   <tr>
                     <td width="2%">&nbsp;</td>
                     <td>1. Kantor Asal</td>
                     <td>: <?=$DATA['URAIAN_KPBC_ASAL'];?></td>
                     <td class="border-r">&nbsp;</td>
                    <td class="border-t">F.</td>
                    <td colspan="3" class="border-t">KOLOM KHUSUS BEA DAN CUKAI</td>
                  </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td>2. Kantor Tujuan</td>
                     <td>: <?=$DATA['URAIAN_KPBC_TUJUAN'];?></td>
                     <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Nomor Pendaftaran</td>
                    <td colspan="2">: <?=$DATA['NOMOR_PENDAFTARAN'];?></td>
                  </tr>
                   <tr>
                     <td>B.</td>
                     <td>JENIS TPB ASAL</td>
                     <td>: <?=$DATA['URJENIS_TPB_ASAL'];?></td>
                     <td class="border-r">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Tanggal</td>
                    <td colspan="2">: <?=$DATA['TANGGAL_PENDAFTARAN'];?></td>
                  </tr>
                   <tr>
                     <td>C.</td>
                     <td>JENIS TPB TUJUAN</td>
                     <td>: <?=$DATA['URJENIS_TPB_TUJUAN'];?></td>
                     <td class="border-r">&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td colspan="2">&nbsp;</td>
                   </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
		    <td colspan="2" class="border-b" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="4" align="center"  class="border-br">Barang Jadi</td>
                <td colspan="3" align="center"  class="border-b">Bahan Baku yang digunakan</td>
              </tr>
			  <tr>
                <td width="3%" valign="top" class="border-br">No</td>
                <td width="37%" valign="top" class="border-br">&nbsp; Pos Tarif /HS uraian jumlah dan jenis barang secara lengkap, kode barang , merek, tipe, ukuran dan spesifikasi lain</td>
                <td width="6%" align="center" valign="top" class="border-br">Jumlah</td>
                <td width="6%" align="center" valign="top" class="border-br">Satuan</td>
                <td width="44%" valign="top" class="border-br"> Pos Tarif /HS uraian jumlah dan jenis barang secara lengkap, kode barang , merek, tipe, ukuran dan spesifikasi lain &nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="5%" align="center" valign="top" class="border-br">Jumlah</td>
                <td width="7%" align="center" valign="top" class="border-b">Satuan</td>
              </tr>
              <?php if (count($BARANG) > 1){;?>
              <?php $no=1;?>
              <?php foreach( $BARANG as $bar):
			  $query = $this->db->get_where('T_BC41_BB', array('NOMOR_AJU' => $bar['NOMOR_AJU'],'SERI' => $bar['SERI']), '', '');
			  ?>
              <tr>
                <td class="border-br"><?=$no;?></td>
                <td class="border-br"><?=$bar['KODE_HS'];?><br><?=$bar['URAIAN_BARANG'];?>, <?=$bar['MERK']?>, <?=$bar['TIPE']?></td>
                <td class="border-br"><?=$bar['JUMLAH_SATUAN'];?></td>
                <td class="border-br"><?=$bar['URAIAN_SATUAN'];?></td>
                <td colspan="3">
           	 		 <table class="border-tbrl" width="100%" border="0">
                     	<? foreach ($query->result() as $row){?>
              			<tr>
                            <td width="40%"  class="">
							<?= 
								$row->KODE_HS_BB.'<br>'.$row->URAIAN_BARANG_BB.'<br>'.$row->KODE_BARANG_BB.','.$row->MERK_BB.','.$row->TIPE_BB.','.$row->UKURAN_BB.'<br> Dan '.$row->SPF_BB;
							?>
                            </td>
                            <td width="23%"  class=""><?=$row->JUMLAH_SATUAN_BB;?></td>
                            <td width="20%" valign="" class="border-b"><?=$row->KODE_SATUAN_BB;?></td>
						</tr>
                        <? }?>
                    </table>
                </td>
              </tr>	
              <?php $no++; endforeach;?>
              <?php }else{ ?>
              <tr>
              	<td class="border-br"></td>
                <td class="border-br"></td>
                <td class="border-br"></td>
                <td class="border-br"></td>
                <td class="border-br"></td>
                <td class="border-br"></td>
                <td class="border-br"></td>
               </tr>
              <?php }?>
            </table></td>
	      </tr>
		  <tr>
		    <td class="border-b">&nbsp;</td>
		    <td class="border-b">E TANDA TANGAN PENGUSAHA TPB</td>
	      </tr>
		  
		  <tr>
		    <td width="39%" rowspan="7">&nbsp;</td>
		    <td width="61%">&nbsp;</td>
	      </tr>
		  <tr>
		    <td>Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal yang diberitahukan dalam pemberitahuan pabean ini</td>
	      </tr>
		  <tr>

		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td align="center" ><?=$DATA['KOTA_TTD'].",";?> tgl <?=$DATA['TANGGAL_TTD'];?></td>
	      </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
	      </tr>
		  <tr>
		    <td align="center" >(<?=$DATA['NAMA_TTD'];?>)</td>
	      </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
	      </tr>
        </table>
	  </div>
</div>
