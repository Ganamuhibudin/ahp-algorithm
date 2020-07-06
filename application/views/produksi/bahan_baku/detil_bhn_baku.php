<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$func = get_instance();
$this->db->where('NOMOR_PROSES', $NOMOR_PROSES);
$this->db->from('m_trader_proses');
$JUMNOPROSES=$this->db->count_all_results();//echo $JUMNOPROSES;
if($act=="save new" && $getJENIS==""){
	// $NOMOR_PROSES.'-'.$KODE_TRADER;
	$div="addBBAKU";
	$addUrl="/add/bhn_baku_new";
	$event="onclick=popup('konversi','add')";	
	$readonly="readonly=readonly";
	$page="produksi/add/bhn_baku_list_new/".$NOMOR_PROSES."/".$KODE_TRADER;
	
	$TANGGAL = date("Y-m-d");
	$WAKTU = date("H:i");
	
}else{
	$addUrl="/edit/bhn_baku_detil";
	$readonly="readonly=readonly";
	$page="produksi/daftar/bahan_baku";
	$div="allKnv";	
	
	$TANGGAL = $sess['TANGGAL'];
	$WAKTU = $sess['WAKTU'];
}
?>
<div class="header">
	<?php if($list){?>
	<a href="javascript:void(0)" onclick="window.location.href='<?= site_url()."/produksi/daftar/bahan_baku"?>'" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success btn-sm prev" id="ok_"><span><i class="icon-backward"></i>&nbsp;Selesai&nbsp;</span></a>
	<?php
		}
	?>
    <h3>&nbsp;<?= $judul;?></h3>
</div>
<div class="content">
<span id="fKONV_form">
<?php if($list){
	if(($JUMNOPROSES > 0) && ($act!='view')){?><a href="javascript:void(0)" onclick="popKonversi('poplist','konversi','<?= $NOMOR_PROSES;?>')" style="float:right;margin:-5px 5px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Tabel Konversi&nbsp;</span></a><? }?>

<form name="fBahanBakuDet" id="fBahanBakuDet" action="<?= site_url()."/produksi".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="BBAKU[JENIS_BARANG]" id="JENIS_BARANG" value="masuk" />
<input type="hidden" name="KODE_TRADER" id="KODE_TRADER" value="<?= $KODE_TRADER;?>" />
<span id="divtmp"></span>
<table width="100%" border="0">
<tr><td width="45%" valign="top">	
<table width="100%" border="0">
<? if($act!='view'){?>
	<tr>
    	<td colspan="2" width="32%">Nomor Transaksi</td>
        <td><input type="text" name="NOMOR_PROSES" id="nomor_proses" value="<?=$NOMOR_PROSES;?>" readonly class="stext"></td>
    </tr>
    <tr>        
        <td colspan="2">Tanggal Pengerjaan</td>
        <td><input type="text" name="BBAKU[TANGGAL]" id="tanggal" value="<?= $TANGGAL; ?>" class="stext date" onfocus="ShowDP(this.id)">&nbsp; YYYY-MM-DD<span style="margin-left:34px"></span>Waktu : <input type="text" name="BBAKU[WAKTU]" id="waktu" value="<?= $WAKTU;?>" class="ssstext" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)"/>&nbsp;HH:MI
        <!--<input type="text" name="BBAKU[TANGGAL]" id="tanggal" value="<?$sess['TANGGAL']?>" onfocus="ShowDP('tanggal')" class="stext date">&nbsp; YYYY-MM-DD<span style="margin-left:34px"></span>Waktu : <input type="text" name="BBAKU[WAKTU]" id="waktu" value="<?$sess['WAKTU'];?>" class="ssstext" onclick="ShowTime(this.id)"/>--></td>
    </tr>
    <tr>
        <td colspan="2">Keterangan</td>
        <td><textarea name="BBAKU[KETERANGAN]" id="keterangan" class="mtext"><?=$sess['KETERANGAN'];?></textarea></td>
    </tr>
<? }elseif($act=='view'){?>
	<tr>
    	<td colspan="2" width="32%">Nomor Transaksi</td>
        <td>: <?=$NOMOR_PROSES;?></td>
    </tr>
    <tr>        
        <td colspan="2">Tanggal Pengerjaan</td>
        <td>: <?= $this->fungsi->FormatDate($sess['TANGGAL'])?><span style="margin-left:34px"></span>Waktu : <?=$sess['WAKTU'];?></td>
    </tr>
    <tr>
        <td colspan="2">Keterangan</td>
        <td>: <?=$sess['KETERANGAN'];?></td>
    </tr>
<? }?>
</table>
</td><td width="55%">&nbsp;</td></tr></table>
</tr>
<td width="55%" valign="top"></td>		
</table>
</form>

<?php } ?>
</span>
<div id="fprod_list" style="margin-top:10px;"><? if($act=="update" || $act=="view" || $JENIS_BARANG!="") echo $list;?></div>
<?php
//($act=="save new" && $JUMNOPROSES == 0) || 
if($act=="save new" || $act=="update new" || $act=="save" || $act=="update"){ ?>
<div><a href="javascript:void(0);" class="btn btn-success btn-sm save" id="ok_" onclick="save_Detil2('#fBahanBakuDet','msgdetilKonv_','<?= base_url()."index.php/".$page;?>','<?= $div;?>','<?= $DIRECT ?>');"><span><i class="fa fa-save"></i>&nbsp;<?= $act=='save new'?'save':$act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning btn-sm cancel" id="cancel_" onclick="cancel('fBahanBakuDet');"><span><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msgdetilKonv_" style="margin-left:20px">&nbsp;</span></div><? }?>
</div>
