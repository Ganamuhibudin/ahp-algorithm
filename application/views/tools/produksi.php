<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="content_luar">
  <div class="content_dalam"> <a href="javascript:void(0)" onclick="eksekusirevisi('deleteproduksi')" style="float:right;" class="button del" id="ok_"><span><span class="icon"></span>&nbsp;Hapus&nbsp;</span></a><a href="javascript:void(0)" onclick="eksekusirevisi('todraftproduksi')" style="float:right;margin-right:10px" class="button next" id="ok_"><span><span class="icon"></span>&nbsp;Ubah ke Draft&nbsp;</span></a>
    <h4><span class="info_2">&nbsp;</span>Revisi Data
      <?php if($type=="bahan_baku") echo "Bahan Untuk diproses"; else echo $judul; ?>
    </h4>
    <form name="fprdbahanbaku_" id="fprdbahanbaku_" action="<?= site_url()."/produksi/prosesproduksi/".$type; ?>" method="post" autocomplete="off" popup="<?= site_url()."/produksi/prosesproduksipopup/".$type; ?>">
      <input type="hidden" name="HEADER[JENIS_BARANG]" id="JENIS_BARANG" value="<?php echo $jenis; ?>" />
      <input type="hidden" name="ACT" id="ACT" value="<?php echo $action; ?>" />
      <table width="100%" border="0">
        <tr>
          <td width="12%">Nomor Transaksi</td>	
          <td width="88%"><input type="text" name="HEADER[NOMOR_PROSES]" id="NOMOR_PROSES" value="<?=$NOMOR_PROSES;?>" readonly="readonly" class="stext"></td>
        </tr>
        <tr>
          <td>Tanggal Masuk</td>
          <td><input type="text" name="HEADER[TANGGAL]" id="TANGGAL" value="<?php echo $TANGGAL; ?>" class="stext date" onfocus="ShowDP(this.id)">
            &nbsp; YYYY-MM-DD<span style="margin-left:34px"></span>Waktu :
            <input type="text" name="HEADER[WAKTU]" id="WAKTU" value="<?php echo $WAKTU; ?>" class="ssstext" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)"/>
            &nbsp;HH:MI </td>
        </tr>
        <?php if($type=="hasil_produksi"||$type=="hasil_sisa"){?>
        <tr>
          <td>Nomor Transaksi Masuk</td>
          <td><textarea name="HEADER[NOMOR_PROSES_ASAL]" id="NOMOR_PROSES_ASAL" readonly="readonly" onclick="pilihprosesmasuk();" class="mtext"><?=$NOMOR_PROSES_ASAL?>
</textarea>
            &nbsp;
            <input type="button" name="cari" id="cari" class="button" value="..." style="vertical-align:top" onclick="pilihprosesmasuk();"></td>
        </tr>
        <?php } ?>
        <tr>
          <td>Keterangan</td>
          <td><textarea name="HEADER[KETERANGAN]" id="keterangan" class="mtext"><?php echo $KETERANGAN; ?></textarea></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><h5><span class="info_2">&nbsp;</span>Detil <?php echo $judul; ?> :</h5>
            <table class="tabelajax" id="Tbldetilbahanbaku">
              <thead>
                <tr class="head">
                  <th colspan="8"> <a href="javascript:void(0)" onclick="prosesproduksi('#fprdbahanbaku_','save','')" title="Tambah Detil" class="button add" style="float:right"><span><span class="icon" style="margin-left:5px"></span>Tambah</span></a> </th>
                  <?php if($HEADER) echo $HEADER; ?>
                </tr>
              </thead>
              <tbody>
                <tr id="tr_detil">
                  <?php if($DETIL){ echo $DETIL; }else{ ?>
                  <td align="center" style="background:#FFFFFF" colspan="8">Data Tidak Ditemukan</td>
                  <?php } ?>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><a href="javascript:void(0);" class="button save" id="ok_" onclick="eksekusirevisi('eksekusiproduksi');"><span><span class="icon"></span>&nbsp;
            <?=$action?>
            &nbsp;</span></a>&nbsp;<a href="javascript:;" class="button cancel" id="cancel_" onclick="cancel('fprdbahanbaku_');"><span><span class="icon"></span>&nbsp;cancel&nbsp;</span></a><span class="msg_" style="margin-left:20px">&nbsp;</span> </td>
        </tr>
      </table>
      </table>
    </form>
  </div>
</div>
