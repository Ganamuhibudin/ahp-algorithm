<h4 class="header smaller green">Dokumen Pabean</h4>
        <form name="fsetnomor_" id="fsetnomor_" action="<?= site_url() . "/master/setnomor" ?>" method="post" autocomplete="off" class="form-horizontal">
        <table width="100%">            	
                <?php
                if (count($DATA) > 0) {
                    foreach ($DATA as $row) {
                        ?>
                        <tr>
                            <td width="20%"><?php echo substr($row["DOKNAME"], 0, 2) . ' ' . substr($row["DOKNAME"], 2, 1) . '.' . substr($row["DOKNAME"], 3, 1); 
							if(strlen($row["DOKNAME"])>4){
								 echo '.'.substr($row["DOKNAME"], 4, 1); 
							}
							?>
                            </td>
                            <td width="20%"><input type="text" style="text-align:center" name="DATA[<?= $row["DOKNAME"] ?>][SEGMEN1]" id="SEGMEN1" class="form-control" wajib="yes" onKeyPress="return intInput(event, /[0-9]/)" value="<?= $row["SEGMEN1"] ?>" maxlength="6"/></td>
                            <td width="20%"><input type="text" style="text-align:center" name="DATA[<?= $row["DOKNAME"] ?>][SEGMEN2]" id="SEGMEN2" class="form-control" wajib="yes" onKeyPress="return intInput(event, /[0-9]/)" value="<?= $row["SEGMEN2"] ?>" maxlength="6" /></td>
                            <td width="20%"><input type="text" style="text-align:center" class="form-control" wajib="yes" value="<?= date('Y-m-d') ?>" readonly /></td>
                            <td width="20%"><input type="text" style="text-align:center" name="DATA[<?= $row["DOKNAME"] ?>][NO_URUT]" id="<?= $row["DOKNAME"] ?>" class="form-control" wajib="yes" onKeyPress="return intInput(event, /[0-9]/)" value="<?= $row["NO_URUT"] ?>" maxlength="6"/>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                	<td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="5"><a href="javascript:void(0);" class="btn btn-success btn-sm" style="color:#fff" id="ok_" onclick="save_post('#fsetnomor_'), cekrespon();">
                <span>
                    <i class="fa fa-save"></i>&nbsp;Save&nbsp;
                </span>
            		</a>
            <a href="javascript:void(0);" id="cancel_" class="btn btn-danger btn-sm" style="color:#fff" onclick="closedialog('DivSetNomor');">
                <span>
                    <i class="fa fa-times"></i>
                    <text class="res_">Cancel </text>
                </span>
            </a>
            <span class="msg_"></span>
            		</td>
            	</tr>
           </table>
        </form>
<script>
    function cekrespon() {
        setTimeout(function() {
            $('.res_').html('Close');
        }, 300);
    }
</script>