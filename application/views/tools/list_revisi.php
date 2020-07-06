<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>
<div class="content_luar">
<div class="content_dalam">
<h4><span class="info_">&nbsp;</span><?= $judul; ?></h4>
<div id="divDataRevisi"><?= $tabel; ?></div>
</div>
</div>
<script type="text/javascript">
	function searchRevisi(formid, tipe) {
		alert(formid+'|'+tipe); return false;
		// if ($('#tanggalAkhir').attr('wajib') == "yes") {
		// 	if ($('#tanggalAkhir').val() == "") {
		// 		$(".msg_").css('color', 'red');
		// 		$(".msg_").html("Terdapat data yang belum di isi.");
		// 		return false;
		// 	}
		// }
		$.ajax({
			type: 'post',
			url: site_url + '/tools/list_revisi/' + tipe,
			data: 'ajax=1&'+$(formid).serialize(),
			success: function(data) {
				$('#divRevisi'+tipe).html(data);
			}
		});
	}
</script>