<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>	
<div class="header">
    <a href="javascript:void(0)" 
    onclick="window.location.href='<?= site_url()."/admin/user"?>'" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success btn-sm retry" id="ok_"><span><i class="icon-arrow-left"></i>&nbsp;Selesai&nbsp;</span></a>
	<h3><strong><?= $judul;?></strong></h3>
</div>
<div class="content">
<form name="fuser" id="fuser" action="<?= site_url()."/admin/setuser" ?>" method="post" autocomplete="off">
<input type="hidden" name="act" id="act" value="<?= $act;?>" />
<input type="hidden" name="USER[USER_ID]" id="USER_ID" value="<?= $userid;?>" />

<span id="divtmp"></span>
<table width="100%" border="0">
<tr><td width="39%">
    <table width="100%" border="0">	
        <tr>
            <td>Nama Lengkap</td>
            <td><input type="text" name="USER[NAMA]" id="NAMA" value="<?= $sess['NAMA']; ?>" class="mtext"  wajib="yes"/></td>
        </tr>
         <tr>
            <td>Alamat</td>
            <td><textarea name="USER[ALAMAT]" id="ALAMAT" class="mtext"><?=$sess['ALAMAT']?></textarea>
            </td>
        </tr>
         <tr>
            <td>No. Telepon</td>
            <td><input type="text" name="USER[TELEPON]" id="TELEPON" value="<?= $sess['TELEPON']; ?>" class="mtext"   /></td>
        </tr> 
         <tr>
            <td>Email</td>
            <td><input type="text" name="USER[EMAIL]" id="EMAIL" value="<?= $sess['EMAIL']; ?>" class="mtext"  wajib="yes" /></td>
        </tr> 
         <tr>
            <td>Jabatan</td>
            <td><input type="text" name="USER[JABATAN]" id="JABATAN" value="<?= $sess['JABATAN']; ?>" class="mtext" /></td>
        </tr> 
    </table>
    
</td><td width="61%" valign="top">
    <table width="100%" border="0">
        <tr>
            <td width="22%">Username </td>
            <td width="78%"><input type="text" name="USER[USERNAME]" id="USERNAME" value="<?= $sess['USERNAME']?>"  class="mtext"  wajib="yes" <?= $readonly ?>></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="USER[PASSWORD]" id="PASSWORD" value="<?= $sess['PASSWORD']; ?>" class="mtext"  wajib="yes" <?= $readonly ?>/></td>
        </tr>
        <tr>
            <td>Konfirmasi Password</td>
            <td><input type="password" name="KONPASSWORD" id="KONPASSWORD" value="<?= $sess['PASSWORD']; ?>" class="mtext"  wajib="yes" <?= $readonly ?>/></td>
        </tr>
         <tr>
            <td>Group User</td>
            <td><?= form_dropdown('KODEROLE', $KODEROLE, $sess['KODE_ROLE'], 'id="KODEROLE" class="mtext" wajib="yes"'); ?></td>
        </tr>         
        <tr id="idtrader" style="display:none">
            <td>Perusahaan</td>
            <td><input type="text" name="NAMA_TRADER" id="NAMA_TRADER" value="<?= $sess['NAMA_TRADER']; ?>" class="mtext" url="<?= site_url(); ?>/autocomplete/perusahaan"  wajib="yes" urai="KODE_TRADER;" onfocus="Autocomp(this.id, this.form.id);"/><input type="hidden" name="KODE_TRADER" id="KODE_TRADER" class="text" value="<?= $sess['KODE_TRADER']; ?>"  />&nbsp;
            	  <input type="button" name="cari" style="vertical-align:top" id="cari" class="btn btn-primary btn-sm" onclick="tb_search('trader','KODE_TRADER;NAMA_TRADER','PERUSAHAAN',this.form.id,650,400)" value="...">
            </td>
        </tr> 
    </table>
 
</td>
</tr> 
<tr>
	<td colspan="6">&nbsp;</td> 
</tr>    
<tr>
	<td colspan="6" >
   <a href="javascript:void(0);" class="btn btn-success btn-sm save" id="ok_" onclick="savereg('#fuser');"><span><i class="fa fa-save"></i>&nbsp;<?= $act; ?>&nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning btn-sm cancel" id="cancel_" onclick="cancel('fuser');"><span><i class="icon-undo"></i>&nbsp;reset&nbsp;</span></a><span class="msg_" style="margin-left:20px">&nbsp;</span>
	</td>
</tr>  
</table>
</form>
</div>

<?php if($act=="Update"){?>
<script>
var id = $('#KODEROLE').val(); 
if(id==1||id==2)$('#idtrader').hide(); else $('#idtrader').show();
</script>
<?php } ?>

<script>
$('#KODEROLE').bind('change keyup',function(){
	var id = $(this).val(); 
	if(id==0) return false;
	if(id==1||id==2)$('#idtrader').hide(); else $('#idtrader').show();
});
</script>
