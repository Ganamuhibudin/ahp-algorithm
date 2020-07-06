<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
if($act=="view"){
	$disabled = ' disabled="disabled"';	
	$style = ' style="border:none;font-size:12px"';
	$background = ' style="background:#FFFFCC"';
	$class = ' class="tabelPopUp"';
}
?>

<div class="header">
		<h3 class="blue"><strong>Pemberitahuan Pemindahan Barang (PPB)</strong></h3>
</div>
  <div class="content" <?=$background?> >
    <form id="FPPBKB" method="post" action="<?= site_url()."/inventory/set_ppbkb/".$act; ?>" autocomplete="off">
      <input type="hidden" name="act" id="act" value="<?= $act;?>" />
      <input type="hidden" name="IDHDR" id="IDHDR" value="<?= $DATA['ID'];?>" />
      <table width="100%" border="0" <?=$class?>>
        <tr>
          <td width="45%" valign="top" <?=$style?>>
          	<table width="100%" border="0">
              <tr>
                <td width="35%" <?=$style?>>&nbsp;</td>
                <td width="65%" <?=$style?>>&nbsp;</td>
              </tr>
              <tr>
                <td width="35%" <?=$style?>>Nomor Surat </td>
                <td width="65%" <?=$style?>><input type="text" name="DATA[NOMOR_SURAT]" id="NOMOR_SURAT" value="<?= $DATA['NOMOR_SURAT'];?>" class="form-control" style="width:80%"  wajib="yes" <?=$disabled?>/></td>
              </tr>
              <tr>
                <td <?=$style?>>Tanggal Surat</td>
                <td <?=$style?>><input type="text" name="DATA[TGL_SURAT]" class="stext date" id="TGL_SURAT" value="<?= $DATA['TGL_SURAT'];?>" onFocus="ShowDP('TGL_SURAT')"  wajib="yes" <?=$disabled?>/>
                  &nbsp; YYYY-MM-DD</td>
              </tr>
              <tr>
                <td <?=$style?>>Asal Barang </td>
                <td <?=$style?>><?
	   			echo form_dropdown('DATA[LOKASI_ASAL]', $KODE_LOKASI, $DATA['LOKASI_ASAL'], 'id="LOKASI_ASAL" class="text" wajib="yes" '.$disabled);
				?></td>
              </tr>
              <tr>
                <td <?=$style?>>Tujuan</td>
                <td <?=$style?>><?
                echo form_dropdown('DATA[LOKASI_TUJUAN]', $KODE_LOKASI, $DATA['LOKASI_TUJUAN'], 'id="LOKASI_TUJUAN" class="text" wajib="yes" '.$disabled);
				?></td>
              </tr>
            </table></td>
          <td width="55%" valign="top" <?=$style?>><table width="90%" border="0" <?=$style?>>
              <tr>
                <td colspan="2" <?=$style?>><h5 class="header smaller lighter red"><i>&nbsp;Lembar Persetujuan Bea dan Cukai</i></h5></td>
              </tr>
              <tr>
                <td width="45%" <?=$style?>>Nomor Agenda</td>
                <td width="55%" <?=$style?>><input type="text" name="DATA[NO_AGENDA]" id="NO_AGENDA" value="<?= $DATA['NO_AGENDA'];?>" class="form-control" style="width:80%"  wajib="yes" <?=$disabled?>/></td>
              </tr>
              <tr>
                <td <?=$style?>>Tanggal Persetujuan</td>
                <td <?=$style?>><input type="text" name="DATA[TGL_PERSETUJUAN]" class="stext date" id="TGL_PERSETUJUAN" value="<?= $DATA['TGL_PERSETUJUAN'];?>" onFocus="ShowDP('TGL_PERSETUJUAN')"  wajib="yes" <?=$disabled?>/>
                  &nbsp; YYYY-MM-DD</td>
              </tr>
              <tr>
                <td <?=$style?>>Nama</td>
                <td <?=$style?>><input type="text" name="DATA[NAMA_PEJABAT]" id="NAMA_PEJABAT" value="<?= $DATA['NAMA_PEJABAT'];?>" class="form-control" style="width:80%"  wajib="yes" <?=$disabled?>/></td>
              </tr>
              <tr>
                <td <?=$style?>>NIP</td>
                <td <?=$style?>><input type="text" name="DATA[NIP_PEJABAT]" id="NIP_PEJABAT" value="<?= $DATA['NIP_PEJABAT'];?>" class="form-control" style="width:80%"  wajib="yes" <?=$disabled?>/></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="45%" valign="top" <?=$style?>><table width="100%" border="0" <?=$style?>>
              <tr>
                <td colspan="2" <?=$style?>><h5 class="smaller lighter blue"><b>PENANGGUNG JAWAB</b></h5></td>
              </tr>
              <tr>
                <td width="35%" <?=$style?>>Nama</td>
                <td width="65%" <?=$style?>><input type="text" name="DATA[NAMA_TTD]" id="NAMA_TTD" value="<?= $DATA['NAMA_TTD'];?>" class="form-control" style="width:80%"  wajib="yes" <?=$disabled?>/></td>
              </tr>
              <tr>
                <td width="22%" <?=$style?>>Tempat</td>
                <td width="78%" <?=$style?>><input type="text" name="DATA[TMP_TTD]" id="TMP_TTD" value="<?= $DATA['TMP_TTD'];?>" class="form-control" style="width:80%"  wajib="yes" <?=$disabled?>/></td>
              </tr>
              <tr>
                <td <?=$style?>>Tanggal</td>
                <td <?=$style?>><input type="text" name="DATA[TGL_TTD]" class="stext date" id="TGL_TTD" value="<?= $DATA['TGL_TTD'];?>" onFocus="ShowDP('TGL_TTD')"  wajib="yes" <?=$disabled?>/>
                  &nbsp; YYYY-MM-DD</td>
              </tr>
              <tr>
                <td width="22%" <?=$style?>>Jabatan</td>
                <td width="78%" <?=$style?>><input type="text" name="DATA[JABATAN_TTD]" id="JABATAN_TTD" value="<?= $DATA['JABATAN_TTD'];?>" class="form-control" style="width:80%"  wajib="yes" <?=$disabled?>/></td>
              </tr>
            </table></td>
          <td width="55%" valign="top" <?=$style?>><table width="90%" border="0" <?=$style?>>
              <tr>
                <td colspan="2" <?=$style?>><h5 class="smaller lighter blue"><b>&nbsp;CATATAN</b></h5></td>
              </tr>
              <tr>
                <td width="45%" <?=$style?>>Selesai dipindahkan pada</td>
                <td width="55%" <?=$style?>>&nbsp;</td>
              </tr>
              <tr>
                <td <?=$style?>>Tanggal</td>
                <td <?=$style?>><input type="text" name="DATA[TGL_SELESAI]" class="stext date" id="TGL_SELESAI" value="<?= $DATA['TGL_SELESAI'];?>" onFocus="ShowDP('TGL_SELESAI')"  wajib="yes" <?=$disabled?>/>
                  &nbsp; YYYY-MM-DD</td>
              </tr>
              <tr>
                <td <?=$style?>>Pukul</td>
                <td <?=$style?>><input type="text" name="DATA[WK_SELESAI]" id="WK_SELESAI" value="<?= substr($DATA['WK_SELESAI'],0,5); ?>" class="stext" style="width:15%" onclick="ShowTime(this.id)" onfocus="ShowTime(this.id)" <?=$disabled?>></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td <?=$style?>>&nbsp;</td>
          <td <?=$style?>><h5 class="smaller lighter blue"><b>REALISASIKAN DATA</b> &nbsp;
            <?php
			if($revisi==1){
				$check = array("name"=>"DATA[STATUS]",
							   "id"=>"STATUS",
							   "value"=>"1", 
							   "checked"=>set_value('STATUS', $DATA['STATUS']),
							   "onclick"=>"return false");
			}else{
				$check = array("name"=>"DATA[STATUS]",
							   "id"=>"STATUS",
							   "value"=>"1", 
							   "checked"=>set_value('STATUS', $DATA['STATUS']));
			}
	        echo form_checkbox($check);
			?>
            </h5>
            </td>
        </tr>
        <tr>
          <td colspan="2" <?=$style?>>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" <?=$style?>><h5 class="header smaller lighter green"><b>DETIL BARANG</b></h5>
            <?php if($act=="view"){?>
            <?php echo $DETILBARANG; ?>
            <?php }else{ ?>
            <table width="100%" id="tableBarang" border="1" bordercolor="#E4E3E3" cellspacing="3" cellpadding="3" style="text-align:center">  
            	<thead>         
                <tr>
                  <th class="header left" align="center" style="border-top: 1px solid #ABC3D7; text-align:center;" width="3%">No</th>
                  <th width="18%" class="header left" style="border-top: 1px solid #ABC3D7; text-align:center;">Kode Barang</th>
                  <th width="15%" class="header" style="border-top: 1px solid #ABC3D7; text-align:center;">Kode HS</th>
                  <th width="7%" class="header" style="border-top: 1px solid #ABC3D7; text-align:center;">Jenis Barang</th>
                  <th width="15%" class="header" style="border-top: 1px solid #ABC3D7; text-align:center;">Jumlah</th>
                  <th width="10%" class="header" style="border-top: 1px solid #ABC3D7; text-align:center;">Satuan</th>
                  <th width="29%" class="header" style="border-top: 1px solid #ABC3D7; text-align:center;">Dokumen Pemasukan</th>
                  <td width="3%" class="header right" style="border-top: 1px solid #ABC3D7;" align="center"> <a href="javascript:void(0)" onclick="addRowBarangppbkb('tableBarang','tr_barang')" title="Tambah Barang" class="add" style="color:#30AB12;font-size:22px;text-align:center"><span><i class="fa fa-plus-circle"></i>&nbsp;</span></a> </td>
                </tr> 
                </thead>
                <tbody>           
                <?php if($act=="save" || !$DETILBARANG){ ?>
                <tr id="tr_barang">
                  <td class="alt2 left bright">1</td>
                  <td class="alt2 left bright"><input type="text" name="DATADTL[KODE_BARANG][]" id="KODE_BARANG1" class="stext date ac_input" style="width:51%" wajib="yes" readonly/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('BARANGPPB','KODE_BARANG1;KODE_HS1;JNS_BARANG1;JNSBARANG1;SATUAN1;SATUANKECIL1','Kode Barang',this.form.id,600,400,'LOKASI_ASAL;')" value="..."></td>
                  <td class="alt2 bright"><input type="text" name="DATADTL[KODE_HS][]" id="KODE_HS1" class="sstext"  wajib="yes"/></td>
                  <td class="alt2 bright"><span id="JNSBARANG1"></span>
                    <input type="hidden" name="DATADTL[JNS_BARANG][]" id="JNS_BARANG1" class="stext" readonly/></td>
                  <td class="alt2 bright"><input type="text" name="JUMLAHBARANG1" id="JUMLAHBARANG1" class="stext" wajib="yes" onkeyup="this.value = ThausandSeperator('JUMLAH_BARANG1',this.value,2);" style="text-align:right"/>
                    <input type="hidden" name="DATADTL[JUMLAH][]" id="JUMLAH_BARANG1"/></td>
                  <td class="alt2 bright"><input type="text" name="DATADTL[SATUAN][]" id="SATUAN1" class="ssstext" wajib="yes" readonly/><input type="hidden" name="SATUANKECIL1" id="SATUANKECIL1" class="stext"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('satuan','SATUAN1','Kode Satuan',this.form.id,650,400,'SATUAN1;SATUANKECIL1;')" value="..."></td>
                  <td class="alt2 bright"><input type="text" name="DATADTL[KODE_DOKUMEN][]" id="KODE_DOKUMEN1" class="ssstext"/>
                    <input type="text" name="DATADTL[NO_DOKUMEN][]" id="NO_DOKUMEN1" class="sstext" maxlength="8"/>
                    <input type="text" name="DATADTL[TGL_DOKUMEN][]" id="TGL_DOKUMEN1" class="sstext" />
                    <input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search('DOKUMEN_PEMASUKAN','NO_DOKUMEN1;TGL_DOKUMEN1;KODE_DOKUMEN1','Dokumen Pemasukan',this.form.id,600,400,'KODE_BARANG1;')" value="..."></td>
                  <td class="alt2 right"><a href="javascript:void(0)" onclick="resetBarangPPBKB()" title="Hapus Barang" class="del" style="text-align:center;color:#DF4B33;font-size:22px"><span><i class="fa fa-minus-circle"></i>&nbsp;</span></a></td>
                </tr>
                
                <?php
		 }else{ 
		 	echo $DETILBARANG;
		 }
		?>
              </tbody>
            </table>
            <?php } ?>
            </td>
        </tr>
        <tr>
          <td colspan="2" <?=$style?>>&nbsp;</td>
        </tr>
        <?php if($act!="view"){?>
        <tr>
          <td colspan="2"><a href="javascript:void(0);" class="btn btn-success btn-sm" id="ok_" onclick="save_ppbkb('#FPPBKB');"><span><i class="fa fa-save"></i>&nbsp;
            Save
            &nbsp;</span></a>&nbsp;<a href="javascript:;" class="btn btn-warning btn-sm" id="cancel_" onclick="cancel('FPPBKB');"><span><i class="icon-undo"></i>&nbsp;Reset&nbsp;</span></a><span class="msg_" style="margin-left:20px">&nbsp;</span></td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <script>
  function addRowBarangppbkb(tableId,tbody_id){
	var content="";
	var nilai = $("#"+tableId+" tbody tr").size()+1;
	var Mathrandom = GetRandomMath();	
	content='<tr id="tr_'+Mathrandom+'"><td class="alt2 left bright">'+nilai+'</td><td class="alt2 left bright"><input type="stext" name="DATADTL[KODE_BARANG][]" id="KODE_BARANG'+Mathrandom+'" class="stext date ac_input" style="width:51%" wajib="yes" readonly="readonly"/>&nbsp;<input type="button" name="cari" id="cari'+Mathrandom+'" class="btn btn-primary btn-xs" onclick="tb_search(\'BARANGPPBKB\',\'KODE_BARANG'+Mathrandom+';KODE_HS'+Mathrandom+';JNS_BARANG'+Mathrandom+';JNSBARANG'+Mathrandom+';SATUAN'+Mathrandom+';SATUANKECIL'+Mathrandom+'\',\'Kode Barang\',this.form.id,600,400,\'LOKASI_ASAL;\')" value="..."></td><td class="alt2 bright"><input type="text" name="DATADTL[KODE_HS][]" id="KODE_HS'+Mathrandom+'" class="sstext"  wajib="yes"/></td><td class="alt2 bright"><span id="JNSBARANG'+Mathrandom+'"></span><input type="hidden" name="DATADTL[JNS_BARANG][]" id="JNS_BARANG'+Mathrandom+'" class="stext" readonly="readonly"/></td><td class="alt2 bright"><input type="text" name="JUMLAHBARANG'+Mathrandom+'" id="JUMLAHBARANG'+Mathrandom+'" class="stext" wajib="yes" onkeyup="this.value = ThausandSeperator(\'JUMLAH_BARANG'+Mathrandom+'\',this.value,2);" style="text-align:right"/><input type="hidden" name="DATADTL[JUMLAH][]" id="JUMLAH_BARANG'+Mathrandom+'"/></td><td class="alt2 bright"><input type="text" name="DATADTL[SATUAN][]" id="SATUAN'+Mathrandom+'" class="ssstext" wajib="yes"  readonly="readonly"/><input type="hidden" name="SATUANKECIL'+Mathrandom+'" id="SATUANKECIL'+Mathrandom+'" class="stext"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search(\'satuan\',\'SATUAN'+Mathrandom+'\',\'Kode Satuan\',this.form.id,650,400,\'SATUAN'+Mathrandom+';SATUANKECIL'+Mathrandom+';\')" value="..."></td><td class="alt2 bright"><input type="text" name="DATADTL[KODE_DOKUMEN][]" id="KODE_DOKUMEN'+Mathrandom+'" class="ssstext"  wajib="yes"/>&nbsp;<input type="text" name="DATADTL[NO_DOKUMEN][]" id="NO_DOKUMEN'+Mathrandom+'" class="sstext"  wajib="yes" maxlength="8"//>&nbsp;<input type="text" name="DATADTL[TGL_DOKUMEN][]" id="TGL_DOKUMEN'+Mathrandom+'" class="sstext" wajib="yes"/>&nbsp;<input type="button" name="cari" id="cari" class="btn btn-primary btn-xs" onclick="tb_search(\'DOKUMEN_PEMASUKAN\',\'NO_DOKUMEN'+Mathrandom+';TGL_DOKUMEN'+Mathrandom+';KODE_DOKUMEN'+Mathrandom+'\',\'Dokumen Pemasukan\',this.form.id,600,400,\'KODE_BARANG'+Mathrandom+';\')" value="..."></td><td class="alt2 right"><a href="javascript:void(0)" onclick="removeRowBarangppbkb(\''+tableId+'\',\''+tbody_id+'\',\''+Mathrandom+'\')" title="Hapus Barang" class="del" style="color:#DF4B33;font-size:22px"><span><i class="fa fa-minus-circle"></i>&nbsp;</span></a></td></tr>';
	$("#"+tableId+" tbody:first").append(content);
}
function removeRowBarangppbkb(tableId,tBodyId,id){ 
	$("#"+tableId+" tr[id=tr_"+id+"]").remove();	
}
function resetBarangPPBKB(){
	document.getElementById("KODE_BARANG1").value="";
	document.getElementById("KODE_HS1").value="";
	document.getElementById("JNSBARANG1").innerHTML="";
	document.getElementById("JNS_BARANG1").value="";
	document.getElementById("JUMLAHBARANG1").value="";
	document.getElementById("JUMLAH_BARANG1").value="";
	document.getElementById("SATUAN1").value="";
	document.getElementById("SATUANKECIL1").value="";
	document.getElementById("KODE_DOKUMEN1").value="";
	document.getElementById("NO_DOKUMEN1").value="";
	document.getElementById("TGL_DOKUMEN1").value="";
}
</script>