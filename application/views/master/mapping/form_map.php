<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="save"){
	$disable ="";
	$readonly="";
	$addUrl="add/mapping_new";
}elseif($act=="Save"){
	$disable ="disabled=disabled";
}
?>	
<div class="content_luar">
<div class="content_dalam">
<a href="javascript:void(0)" 
onclick="window.location.href='<?= site_url()."/master/mapping/draftMapping"?>'" style="float:right;margin:-5px 0px 0px 0px" class="button prev" id="ok_"><span><span class="icon"></span>&nbsp;Selesai&nbsp;</span></a>

<form name="fmapping" id="fmapping" action="<?= site_url()."/master/".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<h4><span class="info_2">&nbsp;</span><?= $judul;?></h4>
<span id="divtmp"></span>
<table width="100%" border="0">
    <tr>
        <td width="100%" valign="top">	
            <table width="80%" border="0">
                <tr>
                    <td width="113">Kode Perusahaan </td>
                    <td width="214">
                    <input type="text" name="MAPPING[KODE_PARTNER]" id="KODE_PARTNER" wajib="yes" value="<?php if($sess['KODE_PARTNER'] !=""){ echo $sess['KODE_PARTNER'];}else{echo $kodePart;}?>"  url="<?= site_url(); ?>/autocomplete/pemasokmaster" urai="namaPartner;" onfocus="Autocomp(this.id)" class="stext date" <?=$disable;?> <?php if($act=="preview"){echo "disabled";}?> /></td>
                    <td width="116">Nama Perusahaan</td>
                    <td width="413">
                    <input type="text" name="MAPPING[NAMA_PARTNER]" id="namaPartner" value="<?php if($sess['NAMA_PARTNER'] !=""){ echo $sess['NAMA_PARTNER'];}else{echo $namaPart;}?>"  class="mtext" <?=$disable;?> <?php if($act=="preview"){echo "disabled";}?> ></td>
                </tr>  
            </table>
        </td>
    </tr>
</table><br>
<table width="100%" >
    <tr>
        <td><span id="mappDetil"><?=$list;?></span></td>
    </tr>
     <? if($act!="priview"){?>
    <tr>
        <td >
        </td>
    </tr>
<? }?>		
</table>
</form>

</div></div>
