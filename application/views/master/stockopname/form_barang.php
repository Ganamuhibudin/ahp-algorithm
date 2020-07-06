<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
$event="tb_search('barang','id_barang;kode_barang;nama_barang;jenis_barang;satuan','Kode Barang','fstock-barang',680,445)";
$btn='<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="'.$event.'" value="...">';
if($act == "save"){
    $action = "add";
} else {
    $action = "edit";
}

?>  
<div class="header">
	<h4 class="header smaller green"><?= $judul;?></h4>
</div>
<div class="content" style="padding-left:10px">
	<form name="fstock-barang" id="fstock-barang" action="<?= site_url() . "/master/" . $action . "/so"; ?>" method="post" autocomplete="off">
        <input type="hidden" name="act" id="act" value="<?=$act;?>" />
        <input type="hidden" name="data[id]" id="id" value="<?=$sess['id'];?>">
        <input type="hidden" name="data[id_barang]" id="id_barang" value="<?=$sess['id_barang'];?>">
    	<input type="hidden" name="data[tanggal]" id="tanggal" value="<?=$sess['tanggal'];?>">
		<span id="divtmp"></span>
		<table width="100%" border="0">
			<tr>
    			<td>Kode Barang</td>
                <td>
                    <input type="text" name="kode_barang" id="kode_barang" onclick="<?=$event?>" readonly="" class="mtext" value="<?= $sess['kode_barang']; ?>" wajib="yes"/>&nbsp;<?=$btn?>
                </td>
            </tr>
            <tr>
                <td>Nama Barang</td>
                <td><textarea class="mtext" name="nama_barang" readonly id="nama_barang" wajib="yes"><?= $sess['nama_barang'];?></textarea></td>
            </tr>
             <tr>
                <td>Jenis Barang</td>
                <td><input type="text" name="jenis_barang" id="jenis_barang" readonly class="mtext" value="<?= $sess['jenis_barang']; ?>" wajib="yes"/></td>
            </tr>
            <tr>
                <td>Satuan</td>
                <td><input type="text" name="satuan" id="satuan" readonly class="stext"  value="<?= $sess['satuan']; ?>" wajib="yes" /></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>
                    <input type="text" name="jumlah_ur" id="jumlah_ur" class="stext"  value="<?= number_format($sess['jumlah']); ?>" wajib="yes" format="angka" onkeyup="this.value = ThausandSeperator('jumlah',this.value,2);"/>
                    <input type="hidden" id="jumlah" name="data[jumlah]" value="<?= $sess['jumlah']?>" />
                </td>
            </tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>           
			<tr>
            	<td colspan="2">
                	<a href="javascript:void(0);" class="btn btn-sm btn-success" onclick="save_popup('#fstock-barang','msgdtl_','divfstockdetil');" style="color:#fff"><i class="fa fa-save"></i>&nbsp;<?= ucwords($act); ?>&nbsp;</a>&nbsp;
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="cancel('fstock-barang');closedialog('dialog-produksi');" style="color:#fff"><i class="fa fa-times"></i>&nbsp;Cancel&nbsp;</a>
              </td>
			</tr>
            <tr>
				<td width="31%" valign="top" colspan="2"><span class="msgdtl_"></span></td>
            </tr>    
		</table>
	</form>
</div>
<script>
    $(function(){
    	$("#fstock-barang").find("#tanggal").val($("#fstock").find("#TANGGAL_STOCK").val());
    })
</script> 