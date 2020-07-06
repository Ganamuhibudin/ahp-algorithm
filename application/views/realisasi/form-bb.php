<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<h5 class="header smaller lighter green"><strong>Dokumen <?=strtoupper($DOKUMEN)?></strong></h5>
<form name="fbb_" id="fbb_" action="<?= site_url()."/realisasi/getBB" ?>" method="post" autocomplete="off">
	<input type="hidden" name="SERI_BARANG_DOK" id="SERI_BARANG_DOK" value="<?=$SERI?>" readonly />
	<input type="hidden" name="NOMOR_AJU_DOK" id="NOMOR_AJU_DOK" value="<?=$AJU?>" readonly />
	<input type="hidden" name="DOKUMEN" id="DOKUMEN" value="<?=$DOKUMEN?>" readonly />
	<input type="hidden" name="act" id="act" value="save" readonly />
    <table width="100%" class="tabelPopUp">
        <tr>
            <td width="21%">Nomor Aju</td>
            <td width="79%">: <?= $this->fungsi->FormatAju($AJU)?></td>
        </tr>
        <tr>
            <td width="21%">Kode Barang</td>
            <td width="79%">: <?=$KODE_BARANG?></td>
        </tr>
        <tr>
            <td width="21%">Jenis Barang</td>
            <td width="79%">: <?=$JENIS_BARANG?></td>
        </tr>
        <tr>
            <td width="21%">Seri Barang</td>
            <td width="79%">: <?=$SERI?></td>
        </tr>
        <tr>
            <td width="21%">Jumlah Satuan</td>
            <td width="79%">: <?=number_format($JUMLAH_SATUAN,2)?></td>
        </tr>
    </table><br />
    <table id="tblbb" class="tabelajax" width="70%">      
        <tbody>
            <tr class="thead">
            	<th align="center">Kode Dok Asal</th>
            	<th align="center">No Dok Asal</th>
                <th align="center">Tgl Dok Asal</th>
                <th align="center">Seri Dokumen Asal</th>
                <th align="center">Kode Barang Bahan Baku</th>
                <th align="center">Satuan</th>
                <th align="center">Jumlah</th>
            </tr>
            <?php
			if($resultData){
				$no = 1; 
				foreach($resultData as $data){
					echo '<tr  class="child">';
					echo '<td>'.strtoupper($data["KODE_DOK_ASAL"]).'</td>';
					echo '<td>'.$data["NOMOR_DOK_ASAL"].'</td>';
					echo '<td>'.$data["TANGGAL_DOK_ASAL"].'</td>';
					echo '<td>'.$data["SERI_ASAL"].'</td>';
					echo '<td>'.$data["KODE_BARANG_BB"].'</td>';
					echo '<td>'.$data["KODE_SATUAN_BB"].'</td>';
					echo '<td>'.$data["JUMLAH_SATUAN_BB"].'</td>';
					echo '</tr>';
					$no++;
				}
			}else{
				echo "<tr><td colspan=\"7\" align=\"center\">Data Not Found.</td></tr>";
			}
			?>
        </tbody>
    </table>
    <?php if($resultData){ ?>
    <div class="button" style="padding-top:10px;">
    	<a href="javascript:void(0);" class="btn btn-success btn-m" onClick="save_bb('#fbb_','msgbb_','y');"><i class="icon-ok"></i>&nbsp;Ok</a>
        <a href="javascript:void(0);" class="btn btn-danger btn-m" onClick="save_bb('#fbb_','msgbb_','n');"><i class="icon-remove"></i>&nbsp;No</a>
        <span class="msgbb_"></span>
    </div>
    <div style="margin-top:10px;">
    	* Note : Click OK untuk memilih methode dari Bahan Baku.
    </div>
    <?php } ?>
</form>
<script>
	function save_bb(formid,msg,val){
		var dok 	= $("#DOKUMEN").val();
		var aju 	= $("#NOMOR_AJU_DOK").val();
		var seri 	= $("#SERI_BARANG_DOK").val();
		var act 	= $("#act").val();
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: {DOKUMEN:dok,AJU:aju,SERI:seri,act:act,val:val},
			beforeSend: function() {
            	$("."+msg).html('<img src=\"'+base_url+'img/_load.gif\" alt=\"\" />Loading...');
           	},
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$("."+msg).css('color', 'green');
						$("."+msg).html(arrdata[2]);
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});
	}
</script>