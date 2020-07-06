<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	

<a href="javascript: window.history.go(-1)" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-success">
	<i class="icon-arrow-left"></i>Back
</a>
<div class="header">
	<h3 class="blue"><i class="fa fa-file-text-o"></i>&nbsp;<strong><?=$judul?></strong></h3>
</div>
<div class="content">
    <form name="fstock" id="fstock" action="<?= site_url()."/master/so/update_tanggal"; ?>" method="post" autocomplete="off">
        <span id="divtmp"><br></span>
        <input type="hidden" name="UPDATE_TANGGAL" id="UPDATE_TANGGAL" value="1" />
        <input type="hidden" name="TANGGAL_HIDE" id="TANGGAL_HIDE" value="<?=$TANGGAL_STOCK; ?>" />
        <input type="hidden" name="act" id="act" value="update_tanggal" />
        <table width="100%" border="0">
            <tr>
                <td width="17%"><strong>Tanggal Stock Opname</strong></td>
                <td width="83%"><input type="text" name="DATA[TANGGAL_STOCK]" id="TANGGAL_STOCK" class="stext date" value="<?=$TANGGAL_STOCK; ?>" wajib="yes" onfocus="ShowDP('TANGGAL_STOCK');"/>
              &nbsp;YYYY-MM-DD&nbsp; 
              <?php if($act=="edit"){ ?>
              <a href="javascript:void(0);" class="btn btn-xs btn-success" onclick="save_post('#fstock','msg_')" style="font-size:12px;padding:3px"><i class="fa fa-edit"></i>&nbsp;Update Tanggal Stock&nbsp;</a>
              &nbsp;<span class="msg_"></span>
              <?php } ?>
                </td>          
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
        <h4 class="header smaller lighter green"><strong>Data Barang</strong></h4>
        <?=$DETIL?>
    </form>
</div>