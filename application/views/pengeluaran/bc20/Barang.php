<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<span id="fbarang_form">
	<?php if(!$list){?>
    <form id="fbarang_" name="fbarang_" action="<?= site_url()."/pengeluaran/barang/bc20"; ?>" method="post" autocomplete="off" enctype="multipart/form-data" list="<?=  site_url()."/pengeluaran/detil/barang/bc20" ?>" class="form-horizontal">
        <input type="hidden" name="act" value="<?= $act; ?>" />
        <input type="hidden" name="seri" id="seri" value="<?= $seri; ?>" />
        <input type="hidden" name="NOMOR_AJU" id="NOMOR_AJU" value="<?= $aju; ?>" />
        <input type="hidden" name="KDBRG" id="KDBRG" value="<?= $sess['KODE_BARANG']; ?>" />
        <input type="hidden" name="JNBRG" id="JNBRG" value="<?= $sess['JNS_BARANG']; ?>" />
        <input type="hidden" name="KDHRG" id="KDHRG" value="<?= $sess['KDHRG'] ?>">
        <input type="hidden" name="FREIGHT" id="FREIGHT" value="<?= $sess['FREIGHT'] ?>">
        <input type="hidden" name="NILINV" id="NILINV" value="<?= $sess['NILINV'] ?>">
        <input type="hidden" name="ASURANSI" id="ASURANSI" value="<?= $sess['ASURANSI'] ?>">
        <input type="hidden" name="DISCOUNT" id="DISCOUNT" value="<?= $sess['DISCOUNT'] ?>">
        <input type="hidden" name="NDPBM" id="NDPBM" value="<?= $sess['NDPBM'] ?>">
        <input type="hidden" name="BTAMBAHAN" id="BTAMBAHAN" value="<?= $sess['BTAMBAHAN']; ?>" />
        <input type="hidden" name="BARANG[KONDISI_BARANG]" id="KONDISI_BARANG" value="<?= $sess['KONDISI_BARANG'] ?>">
        <input type="hidden" name="KODE_SATUAN_TERKECIL" id="KODE_SATUAN_TERKECIL" value="">
        <input type="hidden" name="KODE_SATUANNYA" id="KODE_SATUANNYA" value="">
        <input type="hidden" name="URAIAN_KD_SATUAN" id="URAIAN_KD_SATUAN" value="">
        <input type="hidden" name="SATUAN" id="SATUAN" value="">
        <h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>            
        <table width="100%">
          <tr>
            <td width="50%" valign="top">  
            <table width="100%">
                <tr>
                <tr>
                    <td colspan="2" class="rowheight"><h5 class="smaller lighter blue">DATA BARANG</h5></td>
                </tr>
                
                <tr>
                    <td width="145">No HS/Serial HS</td>
                    <td><input type="text" name="BARANG[NOHS]" id="NOHS"  class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['NOHS']); ?>"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> / <input type="text" name="BARANG[SERITRP]" id="SERITRP" class="ssstext" wajib="yes" value="<?= $sess['SERITRP'];?>"/> &nbsp;<input type="hidden" name="trf_serihs" id="trf_serihs" value="<?= $sess['SERITRP']; ?>" /></td>
                </tr>
        
              <tr>
                    <td>Kode Barang</td>
                    <td><input type="text" name="BARANG[KODE_BARANG]" id="KODE_BARANG" value="<?= $sess['KODE_BARANG']; ?>" class="text" url="<?= site_url(); ?>/autocomplete/bc_barang"  wajib="yes" urai="URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;NOHS;SERITRP;SATUAN;SATUAN_TERKECIL;KDSAT;urjenis_satuan;" onfocus="Autocomp(this.id, this.form.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('barangpib','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JNS_BARANG;NOHS;SERITRP;SATUAN;SATUAN_TERKECIL;KDSAT;urjenis_satuan','Kode Barang',this.form.id,650,400)" value="...">
                    <input type="hidden" name="BARANG[JNS_BARANG]" id="JNS_BARANG" class="text" value="<?= $sess['JNS_BARANG']; ?>"  />             		
                    <input type="hidden"  id="SATUAN" name="SATUAN" value="<?= $sess['SATUAN']; ?>"/> 
                    <input type="hidden"  id="SATUAN_TERKECIL" name="SATUAN_TERKECIL" value="<?= $sess['SATUAN_TERKECIL']; ?>"/>
                    <input type="hidden" id="UKURAN" name="UKURAN" />            </td>
                </tr>       
                <tr>
                    <td>Uraian Barang</td>
                    <td><input type="text" name="BARANG[URAIAN_BARANG]" id="URAIAN_BARANG" class="text" wajib="yes" value="<?= $sess['URAIAN_BARANG']; ?>" /></td>
                </tr>
                
                <?php /*?><tr>
                    <td width="145">Kode HS/Seri HS</td>
                    <td><input type="text" name="BARANG[NOHS]" id="NOHS" url="<?= site_url(); ?>/autocomplete/hs_n_tarif" class="sstext" wajib="yes" value="<?= $this->fungsi->FormatHS($sess['NOHS']); ?>" onfocus="Autocomp(this.id);" urai="SERITRP;TARIF_BM;TARIF_PPN;TARIF_PPNBM;TARIF_CUKAI;"  maxlength="13" onblur="this.value = FormatHS(this.value)"/> / <input type="text" name="BARANG[SERITRP]" id="SERITRP" class="ssstext" wajib="yes" value="<?= $sess['SERIAL'];?>"/> &nbsp;<input type="hidden" name="trf_serihs" id="trf_serihs" value="<?= $sess['SERITRP']; ?>" /></td>
                </tr>       
                <tr>
                    <td>Uraian Barang</td>
                    <td><input type="text" name="BARANG[BRGURAI]" id="BRGURAI" class="text" wajib="yes" value="<?= $sess['BRGURAI']; ?>" />&nbsp;<input type="button" name="cari" id="cari" class="button" onclick="tb_search('barang','BRGURAI;MERK;TIPE;SPF;NOHS;SERITRP','Kode Barang',this.form.id,650,400,'NOHS;SERITRP;')" value="..."></td>
                </tr><?php */?>
               
                <tr>
                    <td>Merk</td>
                    <td><input type="text" name="BARANG[MERK]" id="MERK" class="text" value="<?= $sess['MERK']; ?>" maxlength="15" /></td>
                </tr>
                <tr>
                    <td>Tipe</td>
                    <td><input type="text" name="BARANG[TIPE]" id="TIPE" class="text" value="<?= $sess['TIPE']; ?>" maxlength="15" /></td>
                </tr>
                <tr>
                    <td>SPF</td>
                    <td><input type="text" name="BARANG[SPFLAIN]" id="SPF" class="text" value="<?= $sess['SPFLAIN']; ?>" maxlength="15" /></td>
                </tr>
                
                <tr>
                    <td colspan="2" class="rowheight"><h5 class="smaller lighter blue">DATA KEMASAN</h5></td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td><input type="text" name="JUMLAH_KEMASANUR" id="JUMLAH_KEMASANUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['KEMASJM'],0); ?>" onkeyup="this.value = ThausandSeperator('KEMASJM',this.value,2);"/>
                     <input type="hidden" name="BARANG[KEMASJM]" id="KEMASJM" value="<?= $sess['KEMASJM']?>" />
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kemasan</td>
                    <td><input type="text" name="BARANG[KEMASJN]" id="KEMASJN" value="<?= $sess['KEMASJN']; ?>" url="<?= site_url(); ?>/autocomplete/kemasan" class="sstext" urai="urjenis_kemasan;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('kemasan','KEMASJN;urjenis_kemasan','Kode Kemasan',this.form.id,650,400)" value="...">
                    <span id="urjenis_kemasan"><?= $sess['KODE_KEMASANUR']; ?></span></td>
                </tr>
                <tr>
                    <td>Netto</td>
                    <td><input type="text" name="NETTOUR" id="NETTOUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['NETTODTL'],0); ?>" onkeyup="this.value = ThausandSeperator('NETTODTL',this.value,2);"/>&nbsp; Kilogram (KGM)
                    <input type="hidden" name="BARANG[NETTODTL]" id="NETTODTL" value="<?= $sess['NETTODTL']?>" />
                    </td>
                </tr>		
                <tr>
                    <td>Negara Asal</td>
                    <td><input type="text" name="BARANG[BRGASAL]" id="BRGASAL" url="<?= site_url(); ?>/autocomplete/negara" class="sstext" value="<?= $sess['BRGASAL']; ?>"  urai="urngr_asl;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('negara','BRGASAL;urngr_asl','Kode Negara',this.form.id,650,400)" value="...">&nbsp;<span id="urngr_asl"><?= $sess['NEGARA_ASALUR']; ?></span></td>
                </tr>
                <tr>
                    <td colspan="2" class="rowheight"><h5 class="smaller lighter blue">TARIF DAN FASILITAS</h5></td>
                </tr>
                <tr>
                    <td><span onclick="showBM()" class="fontBlueColor">BM</span></td>
                        <td><input type="text" name="TARIF[TRPBM]" id="TARIF_BM" value="<?= $sess['TRPBM']; ?>" onkeyup="$('#TARIF_BM2').val(this.value)" maxlength="3" class="ssstext"/>&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KDFASBM]', $kode_bm, $sess['KDFASBM'], 'id="KODE_FAS_BM" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FASBM]" id="FAS_BM" value="<?= $sess['FASBM']; ?>" maxlength="3" class="ssstext"/>&nbsp;% <span id="tipebm"></span>         
                    </td>
                </tr>
                <tr>        
                <tr><td></td><td><span id="tipespesifik"></span></td></tr>        
                <tr>
                    <td>PPN</td>
                    <td><input type="text" name="TARIF[TRPPPN]" id="TARIF_PPN" maxlength="3" class="ssstext" value="<?= $sess['TRPPPN']; ?>" />&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KDFASPPN]', $kode_ppn, $sess['KDFASPPN'], 'id="KODE_FAS_PPN" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FASPPN]" id="FAS_PPN" maxlength="3" class="ssstext" value="<?= $sess['FASPPN']; ?>" />&nbsp;%</td>
                </tr>
                <tr>
                    <td>PPnBM</td>
                    <td><input type="text" name="TARIF[TRPPBM]" id="TARIF_PPNBM" maxlength="3" class="ssstext" value="<?= $sess['TRPPBM']; ?>" />&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KDFASPBM]', $kode_ppnbm, $sess['KDFASPBM'], 'id="KODE_FAS_PPNBM" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FASPBM]" id="FAS_PPNBM" maxlength="3" class="ssstext" value="<?= $sess['FASPBM']; ?>" />&nbsp;%</td>
                </tr>
                <tr>
                    <td>PPh</td>
                    <td><input type="text" name="FASILITAS[JUM_PPH]" id="pph_" maxlength="3" class="ssstext" wajib="yes" value="<?=$tarif_pph?>" />&nbsp;%&nbsp;<?= form_dropdown('FASILITAS[KDFASPPH]', $kode_ppnbm, $sess['KDFASPPH'], 'id="KODE_FAS_PPH" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FASPPH]" id="FAS_PPH" maxlength="3" class="ssstext" value="<?= $sess['FASPPH']; ?>" />&nbsp;%</td>
                </tr>
            </table>          	
            </td>
            <td valign="top">       
            <table width="100%">
                <tr>
                    <td colspan="2" class="rowheight"><h5 class="smaller lighter blue">DATA HARGA</h5></td>
                </tr>
                <tr>
                    <td>Total/Detil (CIF)</td>
                    <td>
                    <input type="text" name="INVOICEUR" id="INVOICEUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['DNILINV'],2); ?>" onkeyup="this.value = ThausandSeperator('DNILINV',this.value,2);total();satuan($('#JMLSAT').val());"/>
                     <input type="hidden" name="BARANG[DNILINV]" id="DNILINV" value="<?= $sess['DNILINV']?>" />
                    </td>
                </tr>
                <tr>
                    <td>BT-Diskon</td>
                    <td><input type="text" name="BTDISKONUR" id="BTDISKONUR" class="text" value="<?=  $this->fungsi->FormatRupiah($sess['BTDISKON'],2); ?>" readonly/>
                     <input type="hidden" name="BARANG3[DISKON]" id="BTDISKON"  value="<?=  $sess['BTDISKON']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Satuan</td>
                    <td><input type="text" name="JUMLAH_SATUANUR" id="JUMLAH_SATUANUR" class="text" wajib="yes" value="<?= $this->fungsi->FormatRupiah($sess['JMLSAT'],2); ?>" onkeyup="this.value = ThausandSeperator('JMLSAT',this.value,2);satuan($('#JMLSAT').val());"/>
                     <input type="hidden" name="BARANG[JMLSAT]" id="JMLSAT" value="<?= $sess['JMLSAT']?>" />
                    </td>
                </tr>
               <tr>
                    <td>Kode Satuan</td>
                    <td><input type="text" name="BARANG[KDSAT]" id="KDSAT" url="<?= site_url(); ?>/autocomplete/satuan" class="sstext" wajib="yes" value="<?= $sess['KDSAT']; ?>" urai="urjenis_satuan;" maxlength="3" readonly/>
                      <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('satuan','KDSAT;urjenis_satuan','Kode Satuan',this.form.id,650,400,'SATUAN;SATUAN_TERKECIL;')" value="...">
                    <span id="urjenis_satuan"><?= $sess['KODE_SATUANUR']; ?></span></td>
                </tr>   
                <tr>
                    <td>Harga Satuan</td>
                    <td><input type="text" name="HARGA_SATUANUR" id="HARGA_SATUANUR" class="text" value="" readonly/><input type="hidden" name="BARANG3[HARGA_SATUAN]" id="HARGA_SATUAN"  value="" />
                    </td>
                </tr>
                <tr>
                    <td>Harga FOB</td>
                    <td><input type="text" name="HARGAFOBUR" id="HARGAFOBUR" class="text" value="" readonly/><input type="hidden" name="BARANG3[HARGAFOB]" id="HARGAFOB"  value="" />
                    </td>
                </tr>
                <tr>
                    <td>Freight</td>
                    <td><input type="text" name="DFREIGHTUR" id="DFREIGHTUR" class="text"  readonly="readonly"/><input type="hidden" name="BARANG3[DFREIGHT]" id="DFREIGHT"  value="" />
                    </td>
                </tr>
                <tr>
                    <td>Asuransi</td>
                    <td> <input type="text" name="dasuransiur" id="DASURANSIUR" class="text" value="" readonly/><input type="hidden" name="BARANG3[DASURANSI]" id="DASURANSI"  value="" />
                    </td>
                </tr>
                <tr>
                    <td>Harga CIF</td>
                    <td><input type="text" name="CIFUR" id="DCIFUR" class="text" value="<?= $this->fungsi->FormatRupiah($sess['DCIF'], 2); ?>" readonly/>
                                                <input type="hidden" name="BARANG[DCIF]" id="DCIF" value="<?= $sess['DCIF']; ?>"/>
                    </td>
                </tr>
              <tr>
                    <td>CIF Rp</td>
                    <td> <input type="text" name="CIFRPUR" id="CIFRPUR" class="text" style="text-align:right;" value="<?= $this->fungsi->FormatRupiah($sess['CIFRP'], 2); ?>" readonly/>
        <input type="hidden" name="BARANG[CIFRP]" id="CIFRP" value="<?= $sess['CIFRP']; ?>"/>
                    </td>
                </tr>        
                <tr>
                    <td colspan="2" class="rowheight"><h5 class="smaller lighter blue">DATA CUKAI</h5></td>
                </tr>
                <tr>
                    <td>Komoditi</td>
                    <td><?= form_dropdown('TARIF[KDCUK]', $komoditi_cukai, $sess['KDCUK'], 'id="KODE_CUKAI" class="text" '); ?></td>
                </tr>
                <tr>
                    <td>Jenis Tarif</td>
                    <td><?= form_dropdown('TARIF[KDTRPCUK]', $jenis_tarif, $sess['KDTRPCUK'], 'id="KODE_TARIF_CUKAI" class="text" onchange="tarif(this.value)"'); ?>&nbsp;&nbsp;<input type="text" name="TARIF[TRPCUK]" id="TARIF_CUKAI" maxlength="3" class="ssstext" value="<?= $sess['TRPCUK']; ?>" /><span id="persens">%</span></td>
                </tr>
                <tr id="tarf" style="display:none;">
                    <td colspan="2" style="padding-left:90px;"> 
                        <fieldset style="padding-left:10px;padding-bottom:10px;">
                        <legend>Jenis Tarif : Spesifik</legend>
                            <table > 
                                <tr>		
                                    <td >Per : &nbsp;<input type="text" class="ssstext" name="TARIF[KDSATCUK]" id="KODE_SATUAN_CUKAI" value="<?= $sess['KDSATCUK']; ?>" maxlength="3" url="<?= site_url(); ?>/autocomplete/satuan" onfocus="Autocomp(this.id);" urai="" />&nbsp;Jumlah : &nbsp;<input type="text" class="sstext" name="BARANG[SATCUKJM]" id="JUMLAH_CUKAI" value="<?= $sess['SATCUKJM']; ?>"/></td>
                                </tr>
                              </table>
                        </fieldset>
                    </td> 	            	
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?= form_dropdown('FASILITAS[KDFASCUK]', $kode_cukai, $sess['KDFASCUK'], 'id="KODE_FAS_CUKAI" class="text" '); ?>&nbsp;&nbsp;<input type="text" name="FASILITAS[FASCUK]" id="FAS_CUKAI" maxlength="3" class="ssstext" value="<?= $sess['FASCUK']; ?>"  />&nbsp;%</td>
                </tr>
                <tr>
                    <td colspan="2" class="rowheight"><h5 class="smaller lighter blue">FASILITAS</h5></td>
                </tr>
                <tr>
                    <td>Fasilitas</td>
                    <td><input type="text" name="BARANG[KDFASDTL]" id="KDFASDTL" url="<?= site_url(); ?>/autocomplete/fasilitas" class="ssstext" value="<?= $sess['KDFASDTL']; ?>"  urai="urfasil;" onfocus="Autocomp(this.id);"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top" onclick="tb_search('skep','KDFASDTL;urfasil','Kode Fasilitas',this.form.id,650,400)" value="...">
                      &nbsp;<span id="urfasil">
                      <?= $sess['KDFASDTLUR']==''?$URKDFAS:$sess['KDFASDTLUR']; ?>
                      </span></td>
                      
                </tr>
          </table>            
        </td>
        </tr>
        </table>  
        <br>    	      
        <div class="ibutton"> <a href="javascript:void(0);" class="btn btn-sm btn-success" id="ok_" onclick="save_detil('#fbarang_','msgbarang_');"><i class="icon-save"></i>&nbsp;<?=$act; ?></a>&nbsp;<a href="javascript:;" class="btn btn-sm btn-warning" id="cancel_" onclick="cancel('fbarang_');"><i class="icon-undo"></i>&nbsp;reset</a></a>&nbsp;<span class="msgbarang_" style="margin-left:20px">&nbsp;</span> </div>	
    </form> 
<?php } ?>
</span>
<?php 
	if($edit){
		echo '<h5 class="header smaller lighter green"><b>&nbsp;</b></h5>';
	}
?>
<?php if(!$edit){ ?>
<div id="fbarang_list"><?= $list ?></div>
<?php } 
if($act=="update"){ 
	if($sess['KDTRPBM']=='2'){
?>
	<script>
    $("#tipespesifik").html('<table><tr><td align="right">Per</td><td><input type="text" name="TARIF[KDSATBM]" id="KODE_SATUAN_BM" class="ssstext" value="<?= $sess["KDSATBM"]?>" url="<?= site_url(); ?>/autocomplete/satuan" onfocus="Autocomp(this.id,this.form.id);" urai="" />&nbsp;&nbsp;Jumlah Satuan&nbsp;<input type="text" name="BARANG[SATBMJM]" id="JUMLAH_BM" class="stext" value="<?= $sess["SATBMJM"]?>"/></td></tr></table>');	
	$("#tipebm").html('Spesifik<input type="hidden" name="TARIF[KDTRPBM]" id="KODE_TARIF_BM" value="2">');
    </script>
<?php	}else{ ?>
	<script>
    $("#tipespesifik").html('');	
	$("#tipebm").html('Advolorum<input type="hidden" name="TARIF[KDTRPBM]" id="KODE_TARIF_BM" value="1">');	
    </script>
<?php }
	if($sess['KDTRPCUK']=='2'){
	?>
	<script>
    $("#tarf").show();	
    </script>	
<?php } }?>
<script>
$(function(){FormReady();})
$('document').ready(function() {
  //  total($('#INVOICE').val());
});

</script>


<script>
    $('document').ready(function() { 
        total();
        satuan($('#JMLSAT').val());
        switch($('#KDHRG').val()){
            case '1': 
                $('#URKDHRG').html('CIF');
            break;
            case '2': 
                $('#URKDHRG').html('CNF');
            break;
            case '3': 
                $('#URKDHRG').html('CIF');
            break;
        }
    });
    
    function total() {
        var HKDHRG    = $('#KDHRG').val();
		var BTAMBAHAN= parseFloat($('#BTAMBAHAN').val());
        //alert(BTAMBAHAN);return false;
		var DISCOUNT   = parseFloat($('#DISCOUNT').val());
        var FREIGHT  = parseFloat($('#FREIGHT').val());
		var ASURANSI = parseFloat($('#ASURANSI').val());
        var NDPBM    = parseFloat($('#NDPBM').val());
/*tanda*/var NILINV  = parseFloat($('#NILINV').val());
		//alert(NILINV);return false;
        var DFreight  = 0;
        var DAsuransi = 0;
        var BTDiskon = Math.ceil((BTAMBAHAN - DISCOUNT) * parseFloat($('#DNILINV').val()) / NILINV * 100 ) / 100;
		//alert(BTDiskon);
		$('#BTDISKON').val(BTDiskon);
       	$('#BTDISKONUR').val(ThausandSeperator('', BTDiskon, 2));
        if(parseFloat($('#DNILINV').val()) > 0){
            DFreight = Math.ceil(FREIGHT  * (parseFloat($('#DNILINV').val()) / NILINV) * 100) / 100 ; 
            DAsuransi= Math.ceil(ASURANSI * (parseFloat($('#DNILINV').val()) / NILINV) * 100) / 100 ;
        }else{
            DFreight = 0;
            DAsuransi= 0;
        }
        $('#DFREIGHT').val(DFreight);
        $('#DFREIGHTUR').val(ThausandSeperator('', DFreight, 2));
        $('#DASURANSI').val(DAsuransi);
        $('#DASURANSIUR').val(ThausandSeperator('', DAsuransi, 2));
        var DCif = 0;
        var DCnf = 0;
        var DFob = 0;
        switch (HKDHRG) {
            case '1':
                DCif = parseFloat($('#DNILINV').val()) + BTDiskon;
                DFob = parseFloat(DCif - DFreight - DAsuransi);
                break;
            case '2':
                DCnf = parseFloat($('#DNILINV').val()) + BTDiskon;
                DFob = parseFloat(DCnf - DFreight);
                DCif = parseFloat(DCnf + DAsuransi);
                break;
            case '3':
                DFob = parseFloat($('#DNILINV').val()) + BTDiskon;
                DCif = parseFloat(DFob + DFreight + DAsuransi);
            break;
        }
        var Dcifrp = (NDPBM * DCif);

        $('#DCIFUR').val(ThausandSeperator('', DCif, 2));
        $('#DCIF').val(DCif);
        $('#HARGAFOBUR').val(ThausandSeperator('', DFob, 2));
        $('#HARGAFOB').val(DFob);
        $('#CIFRPUR').val(ThausandSeperator('', Dcifrp, 2));
        $('#CIFRP').val(Dcifrp);    
    }
    /*function save_detil(formid, msg) {
        var dataSend = $(formid).serialize();
        $.ajax({
            type: 'POST',
            url: $(formid).attr('action'),
            data: dataSend,
            success: function(data) {
                if (data.search("MSG") >= 0) {
                    arrdata = data.split('#');
                    if (arrdata[1] == "OK") {
                        $("." + msg).css('color', 'green');
                        $("." + msg).html(arrdata[2]);
                        $(formid + "list").load($(formid).attr('list'),
                            function() {
                                $(formid + "form").html('');
                            });
                    } else {
                        $("." + msg).css('color', 'red');
                        $("." + msg).html(arrdata[2]);
                    }
                } else {
                    $("." + msg).css('color', 'red');
                    $("." + msg).html('Proses Gagal.');
                }
            }

        });
        return false;
    }*/
</script>




  
