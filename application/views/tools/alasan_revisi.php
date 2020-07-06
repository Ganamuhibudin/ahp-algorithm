<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<?php
if($act == "todraft")$tipe = 'revisidraft';
elseif($act == "delete")$tipe = 'revisidelete';
?>
<div class="content_luar">
<div class="content_dalam">
<h4><span class="info_">&nbsp;</span>Alasan Revisi</h4>
<form name="falasan_" id="falasan_" action="<?= site_url()."/tools/".$tipe ?>" method="post" autocomplete="off">
<textarea id="txtAlasan" class="mtext" onkeyup="valToUpper()" wajib="yes" name="alasan" style="height: 100px"></textarea>
&nbsp;
<br/>
<table width="100%">
<?php #foreach ($data as $datacheck){ ++$i;?>
<tr style="display:none;">
    <td>
        <input id="datarevisi" name="datarevisi" value="<?=$data?>" />
        <input id="act" name="act" value="<?=$act?>" />
    </td>
</tr>
<?php #} ?>
<tr>
    <td>
        <span id="showmsg" style="margin-left:20px">&nbsp;</span>
    </td>
</tr>
<tr>
	<td colspan="2">
        <a href="javascript:void(0);" class="btn btn-success btn-m" id="ok_" onclick="process('#falasan_')">
         	<span style="color:#fff">&nbsp;Save&nbsp;</span>
        </a>&nbsp;
        <a href="javascript:;" class="btn btn-warning btn-m" id="cancel_" onclick="closedialog('divAlasanRevisi');">
         	<span style="color:#fff">&nbsp;Cancel&nbsp;</span>
        </a>
    </td>
</tr>
</table>
</form>
</div></div>
<script type="text/javascript">
	function process(formid) {
        jConfirm('Aksi ini akan mempengaruhi stock barang dan mutasi. Apakah anda yakin untuk melanjutkannya??', " PLB Inventory ", 
        function(r){if(r==true){
    		var checkedval = $('#datarevisi').val();
            var arrval = checkedval.split("|");
            var datatype = arrval[0];
            var tipe = "";
            var urlpost = $(formid).attr('action');
            var arrdata = "";
            if(datatype.indexOf("BC") == 0) {
                tipe = "pabean";
            } else {
                tipe = "produksi";
            }
            $.ajax({
                type: 'post',
                url: urlpost + '/' + tipe,
                data: $(formid).serialize(),
                success: function(res) {
                    arrdata = res.split("#");
                    if (arrdata[1] == "OK") {
                        /*$(formid + ' #showmsg').css('color', 'green');
                        $(formid + ' #showmsg').html(arrdata[2]);*/
                        if (tipe == "pabean"){
                            $('#tab-1').load(arrdata[3]);
                        } else {
                            $('#divproduksi').load(arrdata[3]);
                        }
                        /*setTimeout(function(){*/
                          closedialog('divAlasanRevisi');
                        /*}, 2000);*/
                        jAlert(arrdata[2],'PLB Inventory');
                    } else {
                        jAlert(arrdata[2],"PLB Inventory");
                    }
                }
            });
        }else{return false;}});
	}

    function valToUpper() {
        $('#txtAlasan').val(($('#txtAlasan').val()).toUpperCase());
    }
</script>
