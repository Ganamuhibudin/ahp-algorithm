<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	error_reporting(E_ERROR);
?>
<div class="header">
	<h3><strong><?=$judul?></strong></h3>
</div>
<div class="content">
	<form name="fnilaikategori" id="fnilaikategori" action="<?= site_url().'/qualitycontrol/pembobotan' ?>" method="post" class="form-horizontal" role="form">
		<table id="tabel_nilai_kriteria" class="tabelajax">
			<tr>
				<th><center>Nama Kriteria</center></th>
				<th><center>Nilai Perbandingan</center></th>
				<th><center>Nama Kriteria</center></th>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Kesesuaian Produk" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[0], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Harga" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Kesesuaian Produk" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[1], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Fungsi Produk" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Kesesuaian Produk" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[2], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Kesesuaian Jumlah" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Kesesuaian Produk" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[3], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Kesesuaian Bahan" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Harga" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[4], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Fungsi Produk" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Harga" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[5], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Kesesuaian Jumlah" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Harga" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[6], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Kesesuaian Bahan" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Fungsi Produk" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[7], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Kesesuaian Jumlah" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Fungsi Produk" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[8], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Kesesuaian Bahan" class="mtext" wajib="yes"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" value="Kesesuaian Jumlah" readonly="" class="mtext" wajib="yes"/>
				</td>
				<td>
					<combo><?= form_dropdown('nilai[]', $nilai, $nilaiKriteria[9], 'class="mtext" wajib="yes"'); ?></combo>
				</td>
				<td>
					<input type="text" readonly="" value="Kesesuaian Bahan" class="mtext" wajib="yes"/>
				</td>
			</tr>
        </table>
        <br>
        <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#fnilaikategori')">
			<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
		</a>
		<!-- <a href="<?= site_url() . '/pengeluaran/retur/list';?>" class="btn btn-danger btn-sm"><i class="fa icon-undo"></i>Cancel</a> -->
		<span class="msg_" id="msg_">&nbsp;</span>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>