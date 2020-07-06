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

<a href="javascript:void(0)" 
onclick="window.location.href='<?= site_url()."/master/daftar/draftMapping"?>'" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success btn-sm" id="ok_"><span><i class="fa fa-save"></i>&nbsp;Selesai&nbsp;</span></a>

<form name="fmapping" id="fmapping" action="<?= site_url()."/master/".$addUrl; ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<div class="header">
<h4><span class="info_2">&nbsp;</span><?= $judul;?></h4>
</div>
<div class="content">
<span id="divtmp"></span>
<div class="form-group">
        <label class="col-sm-2 control-label">Kode Perusahaan&nbsp;&nbsp;&nbsp;:</label>
        <div class="col-sm-3">
         <input type="text" name="MAPPING[KODE_PARTNER]" id="KODE_PARTNER" wajib="yes" value="<?php if($sess['KODE_PARTNER'] !=""){ echo $sess['KODE_PARTNER'];}else{echo $kodePart;}?>"  url="<?= site_url(); ?>/autocomplete/pemasokmaster" urai="namaPartner;" onfocus="Autocomp(this.id)" class="form-control date" <?=$disable;?> <?php if($act=="preview"){echo "disabled";}?> />
        </div>
        <label class="col-sm-2 control-label">Nama Perusahaan&nbsp;&nbsp;&nbsp;:</label>
         <div class="col-sm-3">
         <input type="text" name="MAPPING[NAMA_PARTNER]" id="NAMA_PARTNER" value="<?php if($sess['NAMA_PARTNER'] !=""){ echo $sess['NAMA_PARTNER'];}else{echo $namaPart;}?>"  class="form-control" <?=$disable;?> <?php if($act=="preview"){echo "disabled";}?> >			
         </div>
</div>
</div>
<div class="content">
	<div class="form-group">
     <span id="mappDetil"><?=$list;?></span>
    </div>    
     <?php if($act!="priview"){?>
    <div class="form-group">
    </div>
<?php }?>		
</div>
</form>


