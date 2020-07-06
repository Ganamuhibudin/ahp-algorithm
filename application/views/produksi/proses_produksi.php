<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if ($this->uri->segment(2) == "revisi"){ ?>
<p id="warning" class="msg warn">
    <b>Perhatian: Proses ini akan mempengaruhi jumlah Stock Barang dan Pencatatan laporan mutasi</b>
</p>
<?php } ?>
<div class="header">  
    <?php if ($this->uri->segment(2) != "revisi"){ ?>
    <a href="javascript:void(0)" onclick="window.location.href='<?= site_url()."/produksi/daftar/".$type?>'" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-success btn-sm prev" id="ok_">
        <span><i class="icon-arrow-left"></i>&nbsp;Selesai&nbsp;</span>
    </a>
    <?php  if($type=="bahan_baku"){?>
    <a href="javascript:void(0)" onclick="popKonversi('poplist','konversi','<?= $NOMOR_PROSES;?>')" style="float:right;margin:-5px 5px 0px 0px" class="btn btn-primary btn-sm add konversi" id="ok_">
        <span><span class="icon-plus"></span>&nbsp;Tabel Konversi&nbsp;</span>
    </a>
    <?php } ?>
    <?php }else{ ?>
    <a href="javascript:void(0)" onclick="delPS()" style="float:right;margin:-5px 0px 0px 0px" class="btn btn-danger btn-sm" id="ok_">
        <span><i class="fa fa-times"></i>&nbsp;Delete&nbsp;</span>
    </a>
    <?php } ?>
    <h3>
       <?php if($type=="bahan_baku") echo "Barang Yang Diproses [Input]";elseif($type=="hasil_produksi") echo "Hasil Pengerjaan [Output]";else echo "Sisa Pengerjaan/Scrap";?>
    </h3>
</div>
<div class="content">     
    <form name="fprdbahanbaku_" id="fprdbahanbaku_" action="<?= site_url()."/produksi/prosesproduksi/".$type; ?>" method="post" autocomplete="off" popup="<?= site_url()."/produksi/prosesproduksipopup/".$type; ?>">
      <input type="hidden" name="HEADER[JENIS_BARANG]" id="JENIS_BARANG" value="<?php echo $jenis; ?>" />
      <input type="hidden" name="ACT" id="ACT" value="<?php echo $action; ?>" />
      <table width="100%" border="0">
        <tr>
          <td width="12%">Nomor Transaksi</td>
          <td width="88%"><input type="text" name="HEADER[NOMOR_PROSES]" id="NOMOR_PROSES" value="<?=$NOMOR_PROSES;?>" style="width:15%" wajib="yes" class="stext"></td>
        </tr>
        <tr>
          <td>Tanggal Masuk</td>
          <td><input type="text" name="HEADER[TANGGAL]" id="TANGGAL" value="<?php echo $TANGGAL; ?>" class="stext date" onfocus="ShowDP(this.id)">
            &nbsp; YYYY-MM-DD<span style="margin-left:34px"></span>Waktu :
            <input type="text" name="HEADER[WAKTU]" id="WAKTU" value="<?php echo $WAKTU; ?>" class="sstext" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)" style="width:5%"/>
            &nbsp;HH:MI </td>
        </tr>
        <?php if($type=="hasil_produksi"||$type=="hasil_sisa"){?>
        <tr>
          <td>Nomor Transaksi Masuk</td>
          <td><textarea name="HEADER[NOMOR_PROSES_ASAL]" id="NOMOR_PROSES_ASAL"  onclick="pilihprosesmasuk();" class="stext date ac_input" style="width:30%" readonly="true"><?=$NOMOR_PROSES_ASAL?>
</textarea>
           
            <button type="button" name="cari" id="cari" class="btn btn-primary btn-xs" value="..." style="vertical-align:top" onclick="pilihprosesmasuk();"> ... </button></td>
        </tr>
        <?php } ?>
        <tr>
          <td>Keterangan</td>
          <td><textarea name="HEADER[KETERANGAN]" id="keterangan" class="form-control" style="width:30%"><?php echo $KETERANGAN; ?></textarea></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div style="float:right">
             <?php if($HEADER){ 
          ?>
                  <a href="javascript:void(0)" onclick="prosesproduksi('#fprdbahanbaku_','save','')" title="Tambah Detil" class="btn btn-primary btn-sm" style="float:right;"><span><i class="icon-plus" style="margin-left:5px"></i>&nbsp;Tambah</span></a>
                  <?
          
          }else{ ?>
                <a href="javascript:void(0)" onclick="prosesproduksi('#fprdbahanbaku_','save','')" title="Tambah Detil" class="btn btn-primary btn-sm" style="float:right;"><span><i class="icon-plus" style="margin-left:5px"></i>&nbsp;Tambah</span></a>
                  <?php
            }
          ?> </div><h5 class="header smaller lighter green"><b>Detil <?php echo $judul; ?> :</b></h5>
            
          	<!--<table width="100%" align="center" cellpadding="2px">
            	<thead>
            	<tr>
                	<td>
                    <?php if($HEADER){ ?>
                	<a href="javascript:void(0)" onclick="prosesproduksi('#fprdbahanbaku_','save','')" title="Tambah Detil" class="btn btn-primary btn-sm" style="padding-bottom:5px;float:right;"><span><i class="icon-plus" style="margin-left:5px"></i>&nbsp;Tambah</span></a>
                   <?php
				  }
					?>
                    </td>
                </tr>
                </thead>
            </table>-->
            <table class="tabelajax" id="Tbldetilbahanbaku">  
              <?php
                if($HEADER){
                  echo $HEADER; 
                }
              ?>    
              <tbody>
                        
                  <?php if($DETIL){ echo "<tr id=\"dtl\"></tr>".$DETIL; }else{ ?>  
                  <tr id="dtl"></tr>
                  	<tr id="tr_detil">                
                  	<td align="center" style="background:#438EB9" colspan="11"><h6 style="color:#FFF"><b>Data Tidak Ditemukan</b></h6></td></tr>    
                  <?php } ?> 
                  
                                
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
              <?php if ($this->uri->segment(2) == "revisi"){ ?>
              <a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="save_revisi('#fprdbahanbaku_', '.ViewProses');">
              <?php }else{ ?>
              <a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="save_post('#fprdbahanbaku_');">
              <?php } ?>
                  <span><span class="fa fa-save"></span>&nbsp;<?=ucfirst($action)?>&nbsp;</span>
              </a>&nbsp;
              <a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('fprdbahanbaku_');">
                  <span><span class="icon-undo"></span>&nbsp;Reset&nbsp;</span>
              </a>
              &nbsp;<input name="REALISASI" id="REALISASI" type="checkbox" value="Y" width="100px" />&nbsp;Realisasi
              <span class="msg_" style="margin-left:20px">&nbsp;</span>
          </td>
        </tr>
      </table>
      </table>
    </form>
  </div>
</div>
<script>
    $(document).ready(function(){
        var url = '<?= $this->uri->segment(2) ?>';
        if(url == "revisi"){
            $('#NOMOR_PROSES').attr('readonly', false);
        }
    });

function save_revisi(formid,div) {
    if (validasi()) {
        $.ajax({
            type: 'POST',
            url: $(formid).attr('action'),
            data: $(formid).serialize(),
            success: function(data) {
                if (data.search("MSG") >= 0) {
                    arrdata = data.split('#');
                    if (arrdata[1] == "OK") {
                        $(div).html(arrdata[2]);
                    } else {
                        $(div).html(arrdata[2]);
                    }
                    $('.msg_').html('');
                } else {
                    $(div).html('Proses Gagal.');
                    $('.msg_').html('');
                }
            }
        });
    }
    return false;
}	
</script>
