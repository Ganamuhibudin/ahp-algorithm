<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<form name="fserahterima" id="fserahterima" action="<?= site_url()."/pengeluaran/delivery" ?>" method="post" class="form-horizontal" autocomplete="off">
    <h5 class="header smaller lighter red"> <i class="icon-edit"></i> Serah Terima Barang </h4>
    <input type="hidden" name="key" value="<?= $key; ?>">
    <table width="100%" border="0">
        <tr>
            <td width="40%">Tanggal Serah Terima</td>
            <td>
            	<input type="text" name="tanggal" id="tanggal" onfocus="ShowDP('tanggal');" class="stext date" wajib="yes"/>
        		&nbsp;YYYY-MM-DD
       		</td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="javascript:void(0)" class="btn btn-sm btn-success" style="color:#FFFFFF" onclick="save_popup('#fserahterima','msgdetil_','divdistribusi')">
                	<i class="icon-save bigger-125"></i>&nbsp;Save
                </a>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning" style="color:#FFFFFF" onclick="cancel('fserahterima');closedialog('dialog-tbl');">
                	<i class="icon-remove bigger-125"></i>&nbsp;Cancel 
                </a>
                &nbsp;<span class="msgdetil_" id="msg_">&nbsp;</span>
            </td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
    </table>
</form>
