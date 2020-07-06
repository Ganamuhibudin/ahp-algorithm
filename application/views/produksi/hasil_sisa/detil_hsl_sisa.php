<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$func = get_instance();
if($act=="save new" && $getJENIS==""){
	// $NOMOR_PROSES.'-'.$KODE_TRADER;
	$div="addHSLSISA";
	$addUrl="/add/hsl_sisa_new";
	//$event="onclick=popup('hasil_sisa','add')";	
	$event="tb_search('nomor_proses','NOMOR_PROSES_ASAL','Nomor Proses',this.form.id,650,445)";
	$readonly="readonly=readonly";
	$page="produksi/add/hsl_sisa_list_new/".$NOMOR_PROSES."/".$KODE_TRADER;
	$TANGGAL = date("Y-m-d");
	$WAKTU = date("H:i");
}else{
	$addUrl="/edit/hsl_sisa_detil";
	$readonly="readonly=readonly";
	$page="produksi/daftar/hasil_sisa";
	$div="allKnv";	
	$TANGGAL = $sess['TANGGAL'];
	$WAKTU = $sess['WAKTU'];
}
?>
<div class="header">
	<?php if($list){?>
	<a href="javascript:void(0)" onclick="window.location.href='<?= site_url()."/produksi/daftar/hasil_sisa"?>'" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success btn-sm prev" id="ok_"><span><span class="icon-arrow-left">		</span>&nbsp;Selesai&nbsp;</span></a>
	<h3><?= $judul;?></h3>
    <?php
	}
	?>
</div>
<div class="content">
<span id="fKONV_form">
<?php if($list){?>
<form name="fHasilSisaDet" id="fHasilSisaDet" action="<?= site_url()."/produksi".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="HSISA[JENIS_BARANG]" id="JENIS_BARANG" value="sisa" />
<input type="hidden" name="KODE_TRADER" id="KODE_TRADER" value="<?= $KODE_TRADER;?>" />
<span id="divtmp"></span>
<table width="100%" border="0">
<tr><td width="45%" valign="top">	
<table width="100%" border="0">
<? if($act!='view'){?>
	<tr>
    	<td colspan="2" width="32%">Nomor Transaksi</td>
        <td ><input type="text" name="NOMOR_PROSES" id="NOMOR_PROSES" value="<?=$NOMOR_PROSES;?>" <?= $readonly;?> class="stext"></td>
    </tr>
    <tr>        
        <td colspan="2">Tanggal Pengerjaan</td>
        <td><input type="text" name="HSISA[TANGGAL]" id="tanggal" value="<?= $TANGGAL; ?>" onfocus="ShowDP(this.id)" class="stext date">&nbsp; YYYY-MM-DD<span style="margin-left:34px"></span>Waktu : <input type="text" name="HSISA[WAKTU]" id="waktu" value="<?= $WAKTU;?>" class="ssstext" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)"/>
        <!--<input type="text" name="HSISA[TANGGAL]" id="tanggal" value="<?$sess['TANGGAL']?>" onfocus="ShowDP('tanggal')" class="stext date">&nbsp; YYYY-MM-DD<span style="margin-left:34px"></span>Waktu : <input type="text" name="HSISA[WAKTU]" id="waktu" value="<?$sess['WAKTU'];?>" class="ssstext" onclick="ShowTime(this.id)"/>--></td>
    </tr>
   <!-- <tr>
    	<td colspan="2" width="32%">Nomor Proses Masuk</td>
        <td ><input type="text" name="HSISA[NOMOR_PROSES_ASAL]" id="NOMOR_PROSES_ASAL" value="<?$sess['NOMOR_PROSES_ASAL'];?>" <?readonly;?> onclick="<?$event;?>" class="stext"></td>
    </tr>-->
    <tr>
        <td colspan="2">Keterangan</td>
        <td><textarea name="HSISA[KETERANGAN]" id="keterangan" class="mtext"><?=$sess['KETERANGAN'];?></textarea></td>
    </tr>
<? }elseif($act=='view'){?>
	<tr>
    	<td colspan="2" width="32%">Nomor Entry</td>
        <td>: <?=$NOMOR_PROSES;?></td>
    </tr>
    <tr>        
        <td colspan="2">Tanggal Pengerjaan</td>
        <td>: <?= $this->fungsi->FormatDate($sess['TANGGAL'])?><span style="margin-left:34px"></span>Waktu : <?=$sess['WAKTU'];?></td>
    </tr>
    <tr>
    	<td colspan="2" width="32%">Nomor Proses Masuk</td>
        <td>: <?= $sess['NOMOR_PROSES_ASAL'];?></td>
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
<?php //if(!$edit){
$this->db->where('NOMOR_PROSES', $NOMOR_PROSES);
$this->db->from('m_trader_proses');
$JUMNOPROSES=$this->db->count_all_results();	

?>
<div id="fprod_list" style="margin-top:10px;"><?php if($act=="update" || $act=="view" || $JENIS_BARANG!="") echo $list;?></div>
<?php 
if($act=="save new"  || $act=="update new" || $act=="save" || $act=="update"){ ?>
<div><a href="javascript:void(0);" class="button save" id="ok_" onclick="save_Detil2('#fHasilSisaDet','msgdetilKonv_','<?= base_url()."index.php/".$page;?>','<?= $div;?>','<?= $DIRECT ?>');"><span><span class="icon"></span>&nbsp;<?= $act=='save new'?'save':$act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="button cancel" id="cancel_" onclick="cancel('fHasilSisaDet');"><span><span class="icon"></span>&nbsp;reset&nbsp;</span></a><span class="msgdetilKonv_" style="margin-left:20px">&nbsp;</span></div><?php }?>
</div>