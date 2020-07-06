<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	error_reporting(E_ERROR);
	$eventButton = "tb_search('barang','id_barang_1;kode_barang_1;jenis_barang_1;nama_barang_1;uraian_1;satuan_1','Kode Barang','fdistribusi',680,445)";
	if (strtolower($act) == "save") {
		$action = "add";
		$disabled = "";
	} elseif (strtolower($act) == "update") {
		$action = "edit";
		$disabled = "";
	} elseif (strtolower($act) == "approve") {
		$action = "approve";
		$disabled = 'disabled';
	}
?>
<div class="header">
	<h3><strong><?=$judul?></strong></h3>
</div>
<div class="content">
	<form name="fdistribusi" id="fdistribusi" action="<?= site_url().'/pengeluaran/'.$action.'/distribusi' ?>" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="act" id="act" value="<?= $act;?>" />
		<input type="hidden" name="id_pengeluaran" id="id_pengeluaran" value="<?= $sess['id_pengeluaran']?>" />
		<table width="100%">
			<tr>
				<td width="50%">
					<table>
						<tr>
			            	<td width="35%">Nomor Permohonan</td>
							<td width="70%">
								<input type="text" readonly="" name="data[nomor_transaksi]" id="nomor_transaksi" value="<?= $sess['nomor_transaksi']; ?>" class="mtext" wajib="yes"/>
							</td>
						</tr>
						<tr>
			            	<td>Tanggal Permohonan</td>
							<td>
								<input type="text" name="data[tanggal]" id="tanggal" class="stext date" value="<?= $sess['tanggal']; ?>" onfocus="ShowDP('tanggal')" wajib="yes" <?=$disabled?>/>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
			            	<td width="30%">Nama Pemohon</td>
							<td width="70%">
								<input type="text" name="nama" id="nama" value="<?= $sess['nama']; ?>" readonly="" class="mtext" wajib="yes">
							</td>
						</tr>
						<tr>
			            	<td width="25%">NIK</td>
							<td width="75%">
								<input type="text" name="nik" id="nik" value="<?= $sess['nik']; ?>" readonly="" class="stext date" wajib="yes">
							</td>
						</tr>
						<tr>
			            	<td>Divisi</td>
							<td>
								<input type="text" name="divisi" id="divisi" value="<?= $sess['divisi']; ?>" readonly="" class="mtext" wajib="yes">
							</td>
						</tr>
						<tr>
			            	<td>Keperluan</td>
							<td>
								<textarea type="text" name="data[keterangan]" id="keterangan" class="mtext" <?=$disabled?>><?= $sess['keterangan']?></textarea>
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
					<?php if($act != "approve") { ?>
					<button type="button" class="btn btn-primary btn-sm" onclick="addRow()"><i class="fa fa-plus"></i> Tambah</button>
					<?php } ?>
					<div id="data-barang" style="padding-top: 1%;">
						<table id="tabel-barang" class="tabelajax">
							<thead>
								<tr>
									<th width="15%">Kode Barang</th>
									<th width="5%">Jenis Barang</th>
									<th width="5%">Nama Barang</th>
									<?php if($act != "approve") { ?>
									<th width="5%">Uraian Barang</th>
									<?php } ?>
									<th width="3%">Satuan</th>
									<th width="5%">Jumlah</th>
									<?php if($act == "approve") { ?>
									<th width="11%">Jumlah Disetujui</th>
									<th width="10%">Keterangan</th>
									<?php } else { ?>
									<th width="8%">Action</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php if ($act == "save"){ ?>
									<tr id="tr_1">
										<td>
											<input type="hidden" name="detail[id_barang][]" id="id_barang_1"/>
											<input type="text" name="kode_barang[]" id="kode_barang_1" readonly="" class="mtext" wajib="yes"/>
										</td>
										<td>
											<input type="text" name="jenis_barang[]" id="jenis_barang_1" readonly="" class="stext" wajib="yes"/>
										</td>
										<td>
											<input type="text" name="nama_barang[]" id="nama_barang_1" readonly="" class="mtext" wajib="yes"/>
										</td>
										<td>
											<input type="text" name="uraian[]" id="uraian_1" readonly="" class="mtext" wajib="yes"/>
										</td>
										<td>
											<input type="text" name="satuan[]" id="satuan_1" readonly="" class="stext date" wajib="yes"/>
										</td>
										<td>
											<input type="text" name="detail[jumlah][]" id="jumlah_1" class="stext" wajib="yes"/>
										</td>
										<td>
											<center>
												<button type="button" class="btn btn-warning btn-sm" onclick="searchBarang(1)"><i class="fa fa-edit"></i></button>
												<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(1)"><i class="fa fa-trash-o"></i></button>
											</center>
										</td>
									</tr>
								<?php
									} else {
										for ($i=0; $i < count(array_keys($barang)); $i++) { 
								?>
									<tr id="tr_<?=$i?>">
											<td>
												<input type="hidden" name="detail[id_barang][]" id="id_barang_<?=$i?>" value="<?= $barang[$i]['id_barang'] ?>"/>
												<input type="text" name="kode_barang[]" id="kode_barang_<?=$i?>" readonly="" class="mtext" wajib="yes"value="<?= $barang[$i]['kode_barang'] ?>"/>
											</td>
											<td>
												<input type="text" name="jenis_barang[]" id="jenis_barang_<?=$i?>" readonly="" class="stext" wajib="yes" value="<?= $barang[$i]['jenis_barang'] ?>"/>
											</td>
											<td>
												<input type="text" name="nama_barang[]" id="nama_barang_<?=$i?>" readonly="" class="mtext" wajib="yes"value="<?= $barang[$i]['nama_barang'] ?>" />
											</td>
											<?php if($act != "approve") { ?>
											<td>
												<input type="text" name="uraian[]" id="uraian_<?=$i?>" readonly="" class="mtext" wajib="yes" value="<?= $barang[$i]['uraian'] ?>"/>
											</td>
											<?php } ?>
											<td>
												<input type="text" name="satuan[]" id="satuan_<?=$i?>" readonly="" class="stext date" wajib="yes" value="<?= $barang[$i]['satuan'] ?>"/>
											</td>
											<td>
												<input type="text" name="detail[jumlah][]" id="jumlah_<?=$i?>" class="stext" wajib="yes" value="<?= $barang[$i]['jumlah'] ?>" <?=$disabled;?>/>
											</td>
											<?php if($act != "approve") { ?>
											<td>
												<center>
													<button type="button" class="btn btn-warning btn-sm" onclick="searchBarang(<?=$i?>)"><i class="fa fa-edit"></i></button>
													<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(<?=$i?>)"><i class="fa fa-trash-o"></i></button>
												</center>
											</td>
											<?php } else { ?>
											<td>
												<input type="hidden" name="detail[id_pengeluaran_detail][]" value="<?= $barang[$i]['id_pengeluaran_detail'] ?>">
												<input type="text" name="detail[jumlah_setujui][]" id="jumlah_<?=$i?>" class="stext" wajib="yes"/>
												<button type="button" class="btn btn-warning btn-sm" onclick="checkStock('<?= $barang[$i]['id_barang'] ?>', '<?= $barang[$i]['jumlah'] ?>')"><i class="fa fa-check-square-o"></i></button>
											</td>
											<td>
												<input type="text" name="detail[keterangan][]" id="jumlah_<?=$i?>" class="stext" />
											</td>
											<?php } ?>
										</tr>
								<?php } } ?>
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
				<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="save_post('#fdistribusi')">
					<i class="fa fa-save"></i> <?php echo ucwords($act) ?>
				</a>
				<a href="<?= site_url() . '/pengeluaran/distribusi/list';?>" class="btn btn-danger btn-sm"><i class="fa icon-undo"></i>Cancel</a>
				<span class="msg_" id="msg_">&nbsp;</span>
				</td>
			</tr>
        </table>
	</form>
</div>
<script type="text/javascript">
	FormReady();
	function addRow() {
		var number = Math.floor(Math.random() * 1001);
		var row = '<tr id="tr_'+number+'"><td>';
		row += '<input type="hidden" name="detail[id_barang][]" id="id_barang_'+number+'"/>';
		row += '<input type="text" name="kode_barang[]" id="kode_barang_'+number+'" readonly="" class="mtext" wajib="yes"/>';
		row += '</td><td>';
		row += '<input type="text" name="jenis_barang[]" id="jenis_barang_'+number+'" readonly="" class="stext" wajib="yes"/>';
		row += '</td><td>';
		row += '<input type="text" name="nama_barang[]" id="nama_barang_'+number+'" readonly="" class="mtext" wajib="yes"/>';
		row += '</td><td>';
		row += '<input type="text" name="uraian[]" id="uraian_'+number+'" readonly="" class="mtext" wajib="yes"/>';
		row += '</td><td>';
		row += '<input type="text" name="satuan[]" id="satuan_'+number+'" readonly="" class="stext date" wajib="yes"/>';
		row += '</td><td>';
		row += '<input type="text" name="detail[jumlah][]" id="jumlah_'+number+'" class="stext" wajib="yes"/>';
		row += '</td><td>';
		row += '<center><button type="button" class="btn btn-warning btn-sm" onclick="searchBarang('+number+')"><i class="fa fa-edit"></i></button>&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow('+number+')"><i class="fa fa-trash-o"></i></button></center>';
		row += '</td></tr>';
		$('#tabel-barang tbody').append(row);
	}

	function searchBarang(id) {
		tb_search('barang','id_barang_'+id+';kode_barang_'+id+';jenis_barang_'+id+';nama_barang_'+id+';uraian_'+id+';satuan_'+id+'','Kode Barang','fdistribusi',680,445);
	}

	function checkStock(id_barang, jumlah) {
		$.ajax({
		    type: 'POST',
		    url: site_url + "/pengeluaran/checkStock/" + id_barang + "/" + jumlah,
	        success: function(msg) {
	        	jAlert(msg,"Marketing Tools");
				return false;
	        }
		});
	}

	function deleteRow(id) {
		$('#tr_'+id).remove();
	}
</script>