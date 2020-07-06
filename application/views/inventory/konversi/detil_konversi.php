<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$func = get_instance();
if($act=="save new" && $IDBJ==""){
	$div="addKnv";
	$addUrl="/add/detilkonversi";
	$event="tb_search('barang_popup','KODE_BARANG;URAIAN_BARANG;JNS_BARANG;JENIS_BARANG;MERK;TIPE;UKURAN;SPF;KODE_SATUAN','Kode Barang',this.form.id,650,445)";
	$readonly="readonly=readonly";
	$page="inventory/add/konversi_list_new/".$IDBJ."/".$KODE;
}else{
	$addUrl="/edit/detilkonversi/".$sess['IDBJ'];
	$readonly="readonly=readonly";
	$page="inventory/daftar/konversi";
	$div="allKnv";	
}
?>

<div class="content_luar">
<div class="content_dalam">
<span id="fKONV_form">
<?php if($list){?>
<a href="javascript:void(0)" onclick="window.location.href='<?= site_url()."/inventory/daftar/konversi"?>'" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success btn-sm" id="ok_"><span><i class="icon-arrow-left"></i>&nbsp;Selesai&nbsp;</span></a>
<div class="header"><h4><?= $judul;?></h4></div><br>
<form name="fkonvdet" id="fkonvdet" action="<?= site_url()."/inventory".$addUrl?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="IDBJ" id="IDBJ" value="<?= $sess['IDBJ'];?>" />
<input type="hidden" name="KODE_TRADER" id="KODE_TRADER" value="<?= $sess['KODE_TRADER']?$sess['KODE_TRADER']:$resultTrader['KODE_TRADER'];?>">
<input type="hidden" name="JNS_BARANG" id="JNS_BARANG" value="<?= $sess['JNS_BARANG']?$sess['JNS_BARANG']:"";?>">
<input type="hidden" name="KONV[KODE_SATUAN]" id="KODE_SATUAN" value="<?= $sess['KODE_SATUAN']?>">
<span id="divtmp"></span>
<? if($act!='view'){?>
<table width="100%" border="0">
<tr><td width="36%" valign="top">	
<table width="100%" border="0">
<tr>
    <td width="30%">Nomor Konversi</td>
    <td width="70%">
    <input type="text" name="KONV[NOMOR_KONVERSI]" id="NOMOR_KONVERSI" class="text" value="<?= $sess['NOMOR_KONVERSI']; ?>" wajib="yes" maxlength="20"/>
    </td>
</tr>
<tr>
    <td>Kode Barang</td>
    <td>
    <input type="text" name="KODE_BARANG" id="KODE_BARANG" <?= $readonly;?> onclick="<?= $event;?>" class="stext" value="<?= $sess['KODE_BARANG']; ?>" wajib="yes"/>&nbsp;<input type="button" name="cari" class="btn btn-primary btn-xs" id="cari" class="button" onclick="<?= $event;?>" value="...">
    </td>
</tr> 
<tr>
    <td valign="top">Uraian Barang </td>
    <td>
    <textarea name="URAIAN_BARANG" id="URAIAN_BARANG" wajib="no" <?= $readonly;?> class="text"><?= $sess['URAIAN_BARANG']; ?></textarea>
    </td>
    </tr>
<tr>
    <td>Jenis Barang</td>
    <td>
    <input type="text" name="JENIS_BARANG" id="JENIS_BARANG" <?= $readonly;?> class="text" value="<?= $sess['JENIS BARANG']; ?>" wajib="yes"/>
    </td>
</tr> 
 <!--<tr>
    <td>Jumlah</td>
    <td>
    <input type="text" name="KONV[JUMLAH]" id="JUMLAH"  class="stext date" value="<?= $sess['JUMLAH']; ?>" wajib="yes" format="angka"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" <?= $readonly;?> name="URAIAN_SATUAN" class="stext date" value="<?= $sess['SATUAN']; ?>" /><span id="uraisatdet"><?= $sess['SATUAN']; ?></span>
    </td>
</tr>  -->
</table>
</td><td width="64%">
<table width="100%" border="0">
	<tr>
        <td width="15%">Merk Barang</td>
        <td width="85%">
        <input type="text" name="MERK" id="MERK" <?= $readonly;?> class="text" value="<?= $sess['MERK']; ?>" wajib="no"/>
        </td>
    </tr> 
    <tr>
        <td>Tipe Barang</td>
    	<td>
        <input name="TIPE" id="TIPE" wajib="no" <?= $readonly;?> class="text" value="<?= $sess['TIPE'];?>">
        </td>
    <tr>
        <td>Ukuran Barang</td>
    	<td>
        <input type="text" name="UKURAN" id="UKURAN" <?= $readonly;?> class="text" value="<?= $sess['UKURAN']; ?>" wajib="no"/>
        </td>
    </tr> 
     <tr>
        <td>Spesifikasi Lain</td>
    	<td>
        <input type="text" name="SPF" id="SPF" <?= $readonly;?> class="text" value="<?= $sess['SPFLAIN']; ?>" wajib="no"/>
        </td>
    </tr> 
    <tr>
        <td valign="top">Keterangan</td>
        <td>
        <textarea name="KONV[KETERANGAN]" id="KETERANGAN" wajib="no" class="text"><?= $sess['KETERANGAN']; ?></textarea>
        </td>
</table>
</td></tr></table>
<? }elseif($act=='view'){?>
<table width="100%" border="0">
<tr><td width="36%" valign="top">	
<table width="100%" border="0">
<tr>
    <td width="26%"><strong>Nomor Konversi </strong></td>
    <td width="74%">:
    <?= $sess['NOMOR_KONVERSI']; ?>
    </td>
</tr>
<tr>
    <td><strong>Kode Barang</strong></td>
    <td>:
    <?= $sess['KODE_BARANG']; ?>
    </td>
</tr> 
<tr>
    <td><strong>Uraian Barang </strong></td>
    <td>:
    <?= $sess['URAIAN_BARANG']; ?>
    </td>
    </tr>
<tr>
    <td><strong>Jenis Barang</strong></td>
    <td>:
    <?= $sess['JENIS BARANG']; ?>
    </td>
</tr> 
 <tr>
    <td><strong>Jumlah</strong></td>
    <td>:
   <?= $sess['JUMLAH']; ?>&nbsp;&nbsp;&nbsp;<span id="uraisatdet"><?= $sess['SATUAN']; ?></span>
    </td>
</tr>  
</table>
</td><td width="64%" valign="top">
<table width="100%" border="0">
	<tr>
        <td width="15%"><strong>Merk Barang</strong></td>
        <td width="85%">:
       <?= $sess['MERK']; ?>
        </td>
    </tr> 
    <tr>
        <td><strong>Tipe Barang</strong></td>
        <td>:
        <?= $sess['TIPE'];?>
        </td>
    <tr>
        <td><strong>Ukuran Barang</strong></td>
        <td>:
        <?= $sess['UKURAN']; ?>
        </td>
    </tr> 
     <tr>
        <td><strong>Spesifikasi Lain</strong></td>
        <td>:
        <?= $sess['SPFLAIN']; ?>
        </td>
    </tr> 
    <tr>
        <td><strong>Keterangan</strong></td>
        <td><span style="vertical-align:top">:</span>
        <?= $sess['KETERANGAN']; ?>
        </td>
</table>
</td></tr></table>

<? }?>
</form>

<?php } ?>
</span>
<?php //echo $IDBJ;//if(!$edit){ ?>
<div id="fkonv_list" style="margin-top:10px;"><? if($act=="update" || $IDBJ!="" ||$act=="view") echo $list;?></div>
<?php if($IDBJ!=""){?>
<div><a href="<?= site_url()."/inventory/daftar/konversi"?>" class="btn btn-success" id="ok_"><span><i class="fa fa-save"></i>&nbsp;<?= $act=='save new'?'Save':ucfirst($act); ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('fkonvdet');"><span><i class="fa fa-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msgdetilKonv_" style="margin-left:20px">&nbsp;</span></div>

<?php }if($act!="view" && $IDBJ==""){ ?>
<div><a href="javascript:void(0);" class="btn btn-success" id="ok_" onclick="save_Detil2('#fkonvdet','msgdetilKonv_','<?= base_url()."index.php/".$page;?>','<?= $div;?>');"><i class="fa fa-save"></i>&nbsp;<?= $act=='save new'?'Save':ucfirst($act); ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning" id="cancel_" onclick="cancel('fkonvdet');"><span><i class="fa fa-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msgdetilKonv_" style="margin-left:20px">&nbsp;</span></div><? }?>
</div>
</div>
