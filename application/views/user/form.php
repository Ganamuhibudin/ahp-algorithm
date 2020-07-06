<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);         
?>
<div class="header">
  <h3><strong><?=$judul?></strong></h3>
</div>
<div class="content">
  <?php
    if (strtolower($act) == "update") {
      $readonly = "readonly";
      $action = "edit";
    } else {
      $readonly = "";
      $action = "create";
    }
  ?>
  <form name="formuser" id="formuser" action="<?= site_url().'/user/' . $action ?>" method="post" class="form-horizontal" role="form">
    <input type="hidden" name="act" id="act" value="<?= $act;?>" />
    <input type="hidden" name="id_user" id="id_user" value="<?= $sess['id_user']?>" />
    <table width="100%">
      <tr>
        <td>
          <table width="50%">
            <tr>
              <td width="20%"">Nama</td>
              <td>
                <input type="text" name="data[nama]" id="nama" value="<?= $sess['nama']?>" class="mtext" wajib="yes">
              </td>
            </tr>
            <tr>
              <td>Nik</td>
              <td>
                <input type="text" name="data[nik]" id="nik" value="<?= $sess['nik']?>" class="mtext" wajib="yes">
              </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                <input type="email" name="data[email]" id="email" value="<?= $sess['email']?>" class="mtext" wajib="yes">
              </td>
            </tr>
            <tr>
                <td>Ext</td>
                <td>
                <input type="text" name="data[ext]" id="ext" value="<?= $sess['ext']?>" class="mtext" wajib="yes">
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table width="50%">
            <tr>
              <td width="20%">Password</td>
              <td>
                <input type="Password" name="data[password]" id="password" value="<?= $sess['password']?>" <?= $readonly ?> class="mtext" wajib="yes">
              </td>
            </tr>
            <tr>
              <td>Role</td>
              <td>
                <combo><?= form_dropdown('data[id_role]', $role, $sess['id_role'], 'id="role" class="mtext" wajib="yes"'); ?></combo>
              </td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>
                  <combo><?= form_dropdown('data[id_divisi]', $divisi, $sess['id_divisi'], 'id="divisi" class="mtext" wajib="yes"'); ?></combo>
                </td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br>
        <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#formuser')">
          <i class="fa fa-save"></i> <?php echo ucwords($act) ?>
        </a>
        <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="window.history.back()"><i class="fa icon-undo"></i>Cancel</a>
        <span class="msg_" id="msg_">&nbsp;</span>
  </form>
</div>
<script type="text/javascript">
  // FormReady();
</script>