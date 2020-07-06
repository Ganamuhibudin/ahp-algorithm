<?
if($sess['SERIBB']==""){
	$act="addBB";
	$button="save";	
}else{
	$act="editBB";
	$button="Update";
}
?>
<form name="Frm_BB27" id="Frm_BB27" action="<?= site_url()."/pemasukan/bahan_baku/bc27/".$act."/".$aju."/".$seri;?>" method="post">
    <input type="hidden" name="NOMOR_AJU" value="<?= $aju?>">
    <input type="hidden" name="SERI" value="<?= $seri?>">
    <input type="hidden" name="SERI_BB" value="<?= $sess['SERIBB']?>">
    <input type="hidden" name="actbutton" value="<?= $button?>"><br>
    <table border="0" width="100%">
    	<tr>
        	<td>
            	<table>
             		<tr>
                		<td width="145">Kode HS</td>
                        <td>
                        	<input type="text" name="BARANGBB[KODE_HS]" id="KODE_HS_BB" class="sstext" value="<?= $this->fungsi->FormatHS($sess['KODE_HS']); ?>" url="<?= site_url()?>/autocomplete/hs" urai="SERI_HS;" wajib="yes" onfocus="Autocomp(this.id)" maxlength="13" onblur="this.value = FormatHS(this.value)"/>               
                        	<input type="hidden" name="SERI_HS" id="SERI_HS" class="sstext" value="<?= $sess['SERI_HS']; ?>"  />
                      	</td>
                    </tr> 
                    <tr>
                        <td>Kode Barang</td>
                        <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                                <input type="text" name="KODE_BARANG" id="KODE_BARANG_BB" wajib="yes" class="sstext" value="<?= $sess['KODE_BARANG']; ?>" url="<?= site_url()?>/autocomplete/barang_ALL" urai="URAIAN_BARANG_BB;MERK_BB;TIPE_BB;UKURAN_BB;SPFF_BB;JNS_BARANG_BB;" onfocus="Autocomp(this.id)"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG_BB;URAIAN_BARANG_BB;MERK_BB;TIPE_BB;UKURAN_BB;SPFF_BB;JNS_BARANG_BB;KODE_HS_BB','Kode Barang','Frm_BB27',650,445)"><i style="color:#fff" class="fa fa-ellipsis-h"></i></a>
                                </span>
                            </div>
                        	<input type="hidden" name="JNS_BARANG" id="JNS_BARANG_BB" class="text" value="<?= $sess['JNS_BARANG']; ?>" maxlength="15" />
                        </td>
                    </tr> 	         
                    <tr>
                        <td>Uraian Barang </td>
                        <td><textarea  name="BARANGBB[URAIAN_BARANG]" id="URAIAN_BARANG_BB" class="text" wajib="yes"><?= $sess['URAIAN_BARANG'];?></textarea></td>
                    </tr>                        
                    <tr>
                        <td>Merk</td>
                        <td><input type="text" name="BARANGBB[MERK]" id="MERK_BB" class="text" value="<?= $sess['MERK']; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Tipe</td>
                        <td><input type="text" name="BARANGBB[TIPE]" id="TIPE_BB" class="text" value="<?= $sess['TIPE']; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Ukuran</td>
                        <td><input type="text" name="BARANGBB[UKURAN]" id="UKURAN_BB" class="text" value="<?= $sess['UKURAN']; ?>"  /></td>
                    </tr>
                    <tr>
                        <td>Spesifikasi</td>
                        <td><input type="text" name="BARANGBB[SPF]" id="SPFF_BB" class="text" value="<?= $sess['SPF']; ?>" /></td>
                    </tr>
                    <tr>
                        <td width="90px">Kode Satuan</td>
                        <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
                               <input type="text" name="BARANGBB[KODE_SATUAN]" id="KODE_SATUAN" class="stext date" value="<?= $sess['KODE_SATUAN']; ?>" wajib="yes" url="<?= site_url()?>/autocomplete/satuan" urai="ursatuanBB;" onfocus="Autocomp(this.id)"/>
                                <span class="input-group-btn">
                                    <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('satuan','KODE_SATUAN;ursatuanBB','Kode Satuan','Frm_BB27',650,445)"><i style="color:#fff" class="fa fa-ellipsis-h"></i></a>
                                </span>
                            </div>&nbsp;<span id="ursatuanBB"><?= $sess['URAIAN_SATUAN']==''?$URAIAN_SATUAN:$sess['URAIAN_SATUAN']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Jumlah Satuan</td>
                        <td>
                        	<input type="text" name="JUMLAH_SATUANBB" id="JUMLAH_SATUANBB" class="stext date" value="<?= $this->fungsi->FormatRupiah($sess['JUMLAH_SATUAN'],4); ?>"  onkeyup="this.value = ThausandSeperator('JUMLAH_SATUANX',this.value,4);"/>
                            <input type="hidden" name="BARANGBB[JUMLAH_SATUAN]" id="JUMLAH_SATUANX" value="<?= $sess['JUMLAH_SATUAN']?>" />
                        </td>
                    </tr>
            	</table>
        	</td>
    	</tr>
    	<tr>
    		<td>
            	<table border="0" width="100%">
                	<tr>
                    	<td colspan="2" ><hr style="margin-bottom:10px;margin-top:10px"><a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="save_BB('#Frm_BB27','msgbarangbaku_','dataBB','<?= base_url()."index.php/pemasukan/load_list_BB/bahan_baku/bc27/".$aju."/".$seri;?>','<?= $button;?>','divEditBahanBakuJD');">
                               <span style="color:#fff"> <i class="icon-save"></i>&nbsp;<?= ucwords($button);?>&nbsp;</span>
                            </a>
                            <a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('Frm_BB27');">
                                 <span style="color:#fff"><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span>
                            </a>
                            <span class="msgbarangbaku_" style="margin-left:20px">&nbsp;</span></p>
                        </td>
                    	
                    </tr>
                </table>
            </td>
    	</tr>
    </table>
</form>
<script>
$(function(){FormReady();})
</script>

