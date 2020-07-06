<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>

<div class="header">
	<h3><strong>Ubah Password</strong></h3>
</div>
  <div class="content">    
    <form id="fpass" action="<?= "updatePass" ?>" method="post" autocomplete="off">
      <table width="100%" border="0">
        <tr>
          <td width="14%">Password Lama </td>
          <td width="86%" colspan="2"><input type="password" name="oldPass" id="oldPass" class="text" wajib="yes"/></td>
        </tr>
        <tr>
          <td>Password Baru </td>
          <td colspan="2"><input type="password" name="newPass" id="newPass" class="text" wajib="yes"/></td>
        </tr>
        <tr>
          <td>Ulang Password Baru </td>
          <td colspan="2"><input type="password" name="renewPass" id="renewPass" class="text" wajib="yes"/></td>
        </tr>
      </table>
      <table width="100%" border="0" >
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="15%"><a href="javascript:void(0);" class="btn btn-success btn-sm save" id="ok_" onclick="save_header('#fpass');"><span><i class="fa fa-save"></i>&nbsp;Submit&nbsp;</span></a>&nbsp; &nbsp;<a href="javascript:void(0);" class="btn btn-warning btn-sm cancel" id="ok_" onclick="cancel('fpass');"><span><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span></a>&nbsp;</td>
          <td  width="85%"  align="left" ><div class="msgheader_">&nbsp;</div></td>
        </tr>
      </table>
    </form>
</div>	
