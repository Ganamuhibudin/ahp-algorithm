<?

if(empty($sess['SERI_BB'])){
	$URL=site_url()."/pengeluaran/bahan_baku/bc41/addBB/".$aju."/".$seri;
	$act="addBB";
	$button="save";	
}else{
	$URL=site_url()."/pengeluaran/bahan_baku/bc41/editBB/".$aju."/".$seri;
	$act="editBB";
	$button="edit";
}

?>
<form name="Frm_BB_41" id="Frm_BB_41" action="#" method="post">
<input type="hidden" name="NOMOR_AJU" id="aju" value="<?= $aju?>">
<input type="hidden" name="SERI" value="<?= $seri?>">
<input type="hidden" name="SERI_BB" value="<?= $sess['SERI_BB']?>">
<input type="hidden" name="NAMA_FORM" id="NAMA_FORM" value="Frm_BB_41_<?=$button?>">
<table border="0">
<tr>
	<td>
    	<table>
        <tr>
        	<td colspan="2"> <h5 class="header smaller lighter green"><b>Asal Barang</b></h5></td>
        </tr>
        <tr>
            <td>Dokumen Asal</td>
            <td><?= form_dropdown('BB[KODE_DOK_ASAL]', array('bc40'=>'BC 4.0'), $sess['KODE_DOK_ASAL'], 'id="KODE_DOK_ASAL_BB" class="stext"'); ?></td>
        </tr>
        <tr>
            <td>Nomor Aju Asal</td>
            <td><input type="text" name="BB[NOMOR_AJU_ASAL]" id="NOMOR_AJU_ASAL_BB" class="text" value="<?= $sess['NOMOR_AJU_ASAL']; ?>" maxlength="15" onclick="Showdokumen();" /></td>
        </tr>
        <tr>
            <td>Nomor Dokumen Asal</td>
            <td><input type="text" name="BB[NOMOR_DOK_ASAL]" id="NOMOR_DOK_ASAL_BB" class="text" value="<?= $sess['NOMOR_DOK_ASAL']; ?>" maxlength="15" /></td>
        </tr>
        <tr>
            <td>Tanggal Dokumen Asal</td>
            <td><input type="text" name="BB[TANGGAL_DOK_ASAL]" id="TANGGAL_DOK_ASAL_BB" class="stext date" value="<?= $sess['TANGGAL_DOK_ASAL']; ?>" maxlength="15" onfocus="ShowDP('TANGGAL_DOK_ASAL_BB')"/></td>
        </tr>
        <tr>
            <td>Urut ke</td>
            <td><input type="text" name="BB[SERI_ASAL]" id="SERI_ASAL" class="ssstext" value="<?= $sess['SERI_ASAL']; ?>" maxlength="15"/></td>
        </tr>
        <tr>
            <td colspan="2" class="rowheight"> <h5 class="header smaller lighter green"><b>Data Bahan Baku</b></h5></td>
        </tr>
        <tr>
            <td width="145">Kode HS</td>
            <td>
    <input type="text" name="BB[KODE_HS_BB]" id="KODE_HS_BB" url="<?= site_url(); ?>/autocomplete/hs" class="text" wajib="yes" value="<?= $sess['KODE_HS_BB']; ?>" onfocus="Autocomp(this.id);" urai="" maxlength="12"/></td>
        </tr>              
            <tr>
            <td>Kode Barang</td>
            <td><input type="text" name="KODE_BARANG_BB" id="KODE_BARANG_BB" wajib="yes" class="text" value="<?= $sess['KODE_BARANG_BB']; ?>" url="<?= site_url()?>/autocomplete/barang_262" urai="URAIAN_BARANG_BB;MERK_BB;TIPE_BB;UKURAN_BB;SPF_BB;" onfocus="Autocomp(this.id)"/>
            &nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('barang','KODE_BARANG_BB;URAIAN_BARANG_BB;MERK_BB;TIPE_BB;UKURAN_BB;SPF_BB;JNS_BARANG_BB;KODE_HS_BB;SERI_HS_BB','Kode Barang',this.form.id,650,400)" value="...">
            <input type="hidden" name="JNS_BARANG_BB" id="JNS_BARANG_BB"  class="text"  value=""/>
            <input type="hidden" name="SERI_HS_BB" id="SERI_HS_BB"  class="text"  value=""/>
            </td>
            </tr>	
            <tr>
                <td>Uraian Barang</td>
                <td><input type="text" name="BB[URAIAN_BARANG_BB]" id="URAIAN_BARANG_BB" url="<?= site_url(); ?>/autocomplete/barang" class="text" wajib="yes" value="<?= $sess['URAIAN_BARANG_BB']; ?>"/></td>
            </tr>
            <tr>
                <td>Merk</td>
                <td><input type="text" name="BB[MERK_BB]" id="MERK_BB" class="text" value="<?= $sess['MERK_BB']; ?>" maxlength="15" /></td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td><input type="text" name="BB[TIPE_BB]" id="TIPE_BB" class="text" value="<?= $sess['TIPE_BB']; ?>" maxlength="15" /></td>
            </tr>
            <tr>
                <td>Ukuran</td>
                <td><input type="text" name="BB[UKURAN_BB]" id="UKURAN_BB" class="text" value="<?= $sess['UKURAN_BB']; ?>" maxlength="15" /></td>
            </tr>
            <tr>
                <td>SPF</td>
                <td><input type="text" name="BB[SPF_BB]" id="SPF_BB" class="text" value="<?= $sess['SPF_BB']; ?>" maxlength="15" />					</td>
            </tr>
           
       	</table>
    </td>
    <td>&nbsp;</td>
    <td><br><br><br><br>
    	<table>
             	<tr>
                    <td colspan="2" class="rowheight"> <h5 class="header smaller lighter green"><b>Satuan dan Harga</b></h5></td>
                </tr>
                <tr>
                    <td width="145">Jumlah Satuan</td>
                    <td><input type="text" name="BB[JUMLAH_SATUAN_BB]" id="JUMLAH_SATUAN_BB" class="stext" value="<?= $sess['JUMLAH_SATUAN_BB']; ?>" /></td>
                </tr>
                <tr>
                    <td>Jenis Satuan</td>
                    <td><input type="text" name="BB[KODE_SATUAN_BB]" id="KODE_SATUAN_BB" value="<?= $sess['KODE_SATUAN_BB']; ?>" url="<?= site_url(); ?>/autocomplete/satuan" class="ssstext" urai="urjenis_satuanBB;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('satuan','KODE_SATUAN_BB;urjenis_satuanBB','Kode Satuan',this.form.id,650,400)" value="..."> &nbsp;<span id="urjenis_satuanBB"><?= $urjenis_satuan; ?></span></td>
                </tr>
                <tr>
                    <td width="145">Netto</td>
                    <td><input type="text" name="BB[NETTO_BB]" id="NETTO_BB" class="stext" value="<?= $sess['NETTO_BB']; ?>" /></td>
                </tr>
        </table>
    </td>
</tr>
		
</table>
<p><br>
<a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" 
onclick=
"save_BB_load('#Frm_BB_41','msgbarangbaku_','dataBB','<?= base_url()."index.php/pengeluaran/load_list_BB/bahan_baku/bc41/".$aju."/".$seri;?>','<?= $button;?>','divEditBahanBakuJD','<?=$URL?>');"><span style="color:#fff"> <i class="icon-save"></i>&nbsp;<?= ucwords($button);?>&nbsp;</span>
</a>&nbsp;&nbsp;<a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('Frm_BB_41');"> <span style="color:#fff"><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msgbarangbaku_" style="margin-left:20px">&nbsp;</span></p>
</form>

