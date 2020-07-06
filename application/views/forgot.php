<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="header">
	<h3><i class="fa fa-lock"></i>&nbsp;<strong>Form Lupa Password</strong></h3>
</div>
<div class="content">
	<form name="fpenyelenggara" id="fpenyelenggara" action="<?=site_url();?>/forgot/setdata" method="post" autocomplete="off" role="form">
		<table width="34%" align="center">
			<tr>
				<td width="7%"><strong>Username</strong></td>
				<td width="2%">:</td>
				<td width="25%"><input type="text" name="USERNAME" id="USERNAME" class="form-control" wajib="yes" /></td>
			</tr>
			<tr>
				<td><strong>Email</strong></td>
				<td>:</td>
				<td><input type="text" name="EMAIL" id="EMAIL" class="form-control" wajib="yes" /></td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					<img src="" alt="" id="captcha"  height="" onclick="change_captcha()" style="cursor:pointer;height:40px;" title="Click to change a code"/>
				</td>
			</tr>
			<tr>
				<td><strong>Code</strong></td>
				<td>:</td>
				<td><input type="text" name="CODE" id="CODE" class="form-control" wajib="yes" /></td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
				<td colspan="3" align="center">
					<a href="javascript:void(0)" class="btn btn-success btn-l" onclick="save_post('#fpenyelenggara')">
						<i class="fa fa-check"></i> <?php echo ucwords('proses') ?>
					</a>&nbsp; &nbsp;
					<a href="javascript:void(0)" class="btn btn-warning btn-l" onclick="cancel('fpenyelenggara')">
						<i class="fa icon-undo"></i>Reset&nbsp;
					</a>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					<span class="msg_" id="msg_" align="left"  style="margin-left:20px">&nbsp;</span>
				</td>
			</tr>
		</table>   
	</form>
</div>
<script src="<?=base_url()?>assets/js/jquery.js"></script>
<script src="<?=base_url()?>assets/js/login.js"></script>