<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<form name="fnilaikriteria" id="fnilaikriteria" action="<?= site_url()."/qualitycontrol/edit/nilai_max" ?>" method="post" class="form-horizontal" autocomplete="off">
    <h5 class="header smaller lighter red"> <i class="icon-edit"></i> Ubah Nilai Maksimal Kriteria </h4>
    <input type="hidden" name="id" value="<?= $id; ?>">
    <table width="100%" border="0">
        <tr>
            <td width="40%">Nilai Maksimal</td>
            <td>
            	<input type="text" name="nilai_max" id="nilai_max" class="stext date" wajib="yes"/>
       		</td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="javascript:void(0)" class="btn btn-sm btn-success" style="color:#FFFFFF" onclick="save_popup('#fnilaikriteria','msgdetil_','divnilai')">
                	<i class="icon-save bigger-125"></i>&nbsp;Save
                </a>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning" style="color:#FFFFFF" onclick="cancel('fnilaikriteria');closedialog('dialog-tbl');">
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
