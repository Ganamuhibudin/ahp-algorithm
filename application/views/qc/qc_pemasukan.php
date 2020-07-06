<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	error_reporting(E_ERROR);
	if ($act == "show") {
		$readonly = "readonly";
	} else {
		$readonly = "";
	}
?>
<div class="header">
	<h3><strong><?=$judul?></strong></h3>
</div>
<div class="content">
	<form name="fqc" id="fqc" action="<?= site_url().'/qualitycontrol/edit/qc_barang'?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="id_pemasukan" id="id_pemasukan" value="<?= $sess['id_pemasukan']?>" />
		<input type="hidden" name="nomor_pengadaan" id="nomor_pengadaan" value="<?= $sess['nomor_pengadaan']?>" />
		<table width="100%">
			<tr>
				<td width="50%">
					<table>
						<tr>
			            	<td><b>Nomor Pengadaan</b></td>
			            	<td>:</td>
							<td width="70%">
								<?= $sess['nomor_pengadaan'] ?>
							</td>
						</tr>
						<tr>
			            	<td><b>Tanggal</b></td>
			            	<td>:</td>
							<td width="70%">
								<?= $sess['tanggal']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
			            	<td><b>Nomor Invoice</b></td>
			            	<td>:</td>
							<td width="70%">
								<?= $sess['nomor_invoice']?>
							</td>
						</tr>
						<tr>
			            	<td><b>Nama Vendor</b></td>
			            	<td>:</td>
							<td width="70%">
								<?= $sess['vendor']?>
							</td>
						</tr>
						<tr>
			            	<td><b>Keterangan</b></td>
			            	<td>:</td>
							<td width="70%">
								<?= $sess['keterangan']?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
        	<tr>
        		<td colspan="2">
					<h5 class="header smaller lighter green">
						<strong>Data Barang</strong>
					</h5>
					<div id="data-barang" style="padding-top: 1%;">
						<table id="tabel-barang" class="tabelajax">
							<thead>
								<tr>
									<th>Kode Barang</th>
									<th>Jenis Barang</th>
									<?php if ($act != "show") { ?>
									<th>Nama Barang</th>
									<?php } ?>
									<th>Kesesuaian Produk</th>
									<th>Harga</th>
									<th>Fungsi Produk</th>
									<th>Kesesuaian Jumlah</th>
									<th>Kesesuaian Bahan</th>
									<?php if ($act == "show") { ?>
									<th>Nilai QC</th>
									<th>Kesimpulan</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach ($details as $detail) { 
										if ($detail['nilai_qc'] < 0.6) {
											$kesimpulan = "Kurang";
										} elseif ($detail['nilai_qc'] < 0.7) {
											$kesimpulan = "Cukup";
										} elseif ($detail['nilai_qc'] < 0.8) {
											$kesimpulan = "Baik";
										} else {
											$kesimpulan = "Sangat Baik";
										}
								?>
								<tr>
									<td>
										<input type="hidden" name="qc[id_pemasukan_detail][]" value="<?= $detail['id_pemasukan_detail'] ?>"/>
										<input type="text" name="kode_barang" readonly="" class="stext" value="<?= $detail['kode_barang'] ?>"/>
									</td>
									<td>
										<input type="text" name="jenis_barang" readonly="" class="stext" value="<?= $detail['jenis_barang'] ?>"/>
									</td>
									<?php if ($act != "show") { ?>
									<td>
										<input type="text" name="nama_barang" readonly="" class="text" value="<?= $detail['nama_barang'] ?>" />
									</td>
									<?php } ?>
									<td>
										<input type="text" name="qc[nilai_k1][]" <?= $readonly ?> class="stext" wajib="yes" value="<?= $detail['nilai_k1'] ?>"/>
									</td>
									<td>
										<input type="text" name="qc[nilai_k2][]" <?= $readonly ?> class="stext" wajib="yes" value="<?= $detail['nilai_k2'] ?>"/>
									</td>
									<td>
										<input type="text" name="qc[nilai_k3][]" <?= $readonly ?> class="stext" wajib="yes" value="<?= $detail['nilai_k3'] ?>"/>
									</td>
									<td>
										<input type="text" name="qc[nilai_k4][]" <?= $readonly ?> class="stext" wajib="yes" value="<?= $detail['nilai_k4'] ?>"/>
									</td>
									<td>
										<input type="text" name="qc[nilai_k5][]" <?= $readonly ?> class="stext" wajib="yes" value="<?= $detail['nilai_k5'] ?>"/>
									</td>
									<?php if ($act == "show") { ?>
									<td>
										<input type="text" name="nilai_qc" <?= $readonly ?> class="stext" wajib="yes" value="<?= $detail['nilai_qc'] ?>"/>
									</td>
									<td>
										<strong><?= $kesimpulan; ?></strong>
									</td>
									<?php } ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
        		</td>
        	</tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
			<tr>
				<td colspan="2">
					<?php if ($act != "show") { ?>
					<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#fqc')">
						<i class="fa fa-save"></i> Simpan
					</a>
					<?php } ?>
					<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="window.history.back()"><i class="fa icon-undo"></i>Kembali</a>
					<span class="msg_" id="msg_">&nbsp;</span>
				</td>
			</tr>
        </table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
</script>