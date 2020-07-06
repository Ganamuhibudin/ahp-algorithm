<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR); ?>

<div class="content_luar">
  <div class="content_dalam">
    <form name="fcctv" id="fcctv" action="<?= site_url()."/tools/set_cctv/".$act?>" method="post" autocomplete="off">
      <input type="hidden" name="CCTV_ID" id="CCTV_ID" value="<?=$DATA['CCTVID']?>" />
      <h4><span class="info_2">&nbsp;</span>Informasi Perangkat CCTV</h4>
      <table width="100%" border="0">
        <tr>
          <td width="24%">Nama Perangkat</td>
          <td width="76%"><input type="text" name="DATA[NAME]" id="NAME" class="mtext" value="<?= $DATA['NAME']; ?>"  wajib="yes" /></td>
        </tr>
        <tr>
          <td>IP Perangkat</td>
          <td><input type="text" name="DATA[IP]" id="IP" class="mtext" value="<?= $DATA['IP']; ?>"  wajib="yes" /></td>
        </tr>
        <tr>
          <td>Port</td>
          <td><input type="text" name="DATA[PORT]" id="PORT" class="stext" value="<?= $DATA['PORT']; ?>" /></td>
        </tr>
        <tr>
          <td>Username</td>
          <td><input type="text" name="DATA[USERNAME]" id="USERNAME" class="mtext" value="<?= $DATA['USERNAME']; ?>"  wajib="yes" /></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="DATA[PASSWORD]" id="PASSWORD" class="mtext" value="<?= $DATA['PASSWORD']; ?>"  wajib="yes" /></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>Share User BC</td>
          <td><input type="radio" name="DATA[BC_FLAG]" id="BC_FLAG_YA" value="1" <?php if($DATA['BC_FLAG']==1) echo"checked=\"checked\""; ?>/> Ya
          &nbsp;&nbsp;&nbsp;<input type="radio" name="DATA[BC_FLAG]" id="BC_FLAG_NO" value="0" <?php if($DATA['BC_FLAG']==0) echo"checked=\"checked\""; ?>/> Tidak&nbsp;
          
          </td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
            <a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="save_popup('#fcctv','msg_','DIVCCTV')">
              <span><span class="fa fa-save"></span>&nbsp;<?=ucwords($act)?>&nbsp;</span>
            </a>&nbsp;
            <a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('fcctv');">
              <span><span class="fa icon-undo"></span>&nbsp;Reset&nbsp;</span>
            </a><span class="msg_" style="margin-left:20px">&nbsp;</span>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
$("input, textarea, select").focus(function(){
	if($(this).attr('wajib')=="yes"){
		$(".msg_").fadeOut('slow');
		$(this).removeClass('wajib');
	}
});
</script> 
