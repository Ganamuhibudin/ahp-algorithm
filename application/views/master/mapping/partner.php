<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);			  	
?>
<div class="block-flat" style="margin:10px;background-color:#F6F6F6">
<h4 class="header smaller green">Form partner perusahaan</h4>
	<form name="formdraftMapping" id="formdraftMapping" action="<?= site_url()."/master/partner"?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
        <!--<input type="hidden" name="KODE_PARTNER" id="KODE_PARTNER_HIDE" value="<?php //$sess["KODE_PARTNER"];?>">-->
        <table width="100%">
        	<tr>
				<td width="30%">Kode Perusahaan</td>
				<td width="70%"><input name="DATA[KODE_PARTNER]" id="KODE_PARTNER" class="stext date ac_input" style="width:30%" type="text">
			<button class="btn btn-primary btn-sm" type="button" onclick="tb_search('partner','KODE_PARTNER;NAMA_PARTNER','Kode Perusahaan',this.form.id,650,400)">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
            	</td>
            </tr>
            <tr>              
				<td>Nama Perusahaan</td>
				<td><input name="DATA[NAMA_PARTNER]" id="NAMA_PARTNER" class="stext date ac_input" style="width:70%" type="text" readonly wajib="yes"> </td>
           	</tr>
			<tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="2"><a href="javascript:void(0)" class="btn btn-success btn-sm" style="color:#FFFFFF" id="ok_" onclick="mapCekpartner('#formdraftMapping')">
					<i class="fa fa-save"></i>Save
				</a>
				<a href="javascript:void(0)" class="btn btn-warning btn-sm" style="color:#FFFFFF" id="cancel_" onclick="cancel('formdraftMapping')"><i class="icon-undo"></i> Cancel</a>
				<span class="msg_" id="msg_">&nbsp;</span>
				</td>
           </tr>
        </table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>