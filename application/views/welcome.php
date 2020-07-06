<?php if ($this->newsession->userdata('id_role') == '1' || $this->newsession->userdata('id_role') == '2') { ?>
<div class="header">
	<h2><strong>Dashboard</strong></h2>
</div>
<div class="stats_bar">
	<div class="butpro butstyle">
		<div class="sub">
			<h2>TOTAL PERMOHONAN</h2>
			<span><?= $totalPermohonan ?></span>
		</div>
		<div class="stat">
			<i class="fa fa-bar-chart-o fa-lg"></i>
		</div>
	</div>
	<div class="butpro butstyle">
		<div class="sub">
			<h2>TOTAL DISTRIBUSI</h2>
			<span><?= $totalDistribusi ?></span>
		</div>
		<div class="stat">
			<i class="fa fa-share-square-o fa-lg"></i>
		</div>
	</div>
	<div class="butpro butstyle">
		<div class="sub">
			<h2>PERMOHONAN BELUM DIPROSES</h2>
			<span><?= $belumDiproses ?></span>
		</div>
		<div class="stat">
			<i class="fa fa-warning fa-lg"></i>
		</div>
	</div>
	<div class="butpro butstyle">
		<div class="sub">
			<h2>TOTAL RETUR</h2>
			<span><?= $totalRetur ?></span>
		</div>
		<div class="stat">
			<i class="fa fa-thumbs-down fa-lg"></i>
		</div>
	</div>
</div>
<div class="block-flat">
	<div class="header">
		<h3 style="color: red;"><strong>Stock Warning</strong></h3>
	</div>
	<div class="content">
		<table class="table no-border">
			<thead class="no-border">
				<tr>
					<th width="1%">No</th>
					<th>Kode Barang</th>
					<th>Jenis Barang</th>
					<th>Nama Barang</th>
					<th>Satuan</th>
					<th>Stock</th>
					<th>Stock Minimum</th>
				</tr>
			</thead>
			<tbody class="no-border-y">
				<?php
					if (count($barangWarning) > 0) {
						$no = 1;
						foreach ($barangWarning as $barang) {
							echo "<tr>";
							echo "<td>" . $no . "</td>";
							echo "<td>" . $barang['kode_barang'] . "</td>";
							echo "<td>" . $barang['jenis_barang'] . "</td>";
							echo "<td>" . $barang['nama_barang'] . "</td>";
							echo "<td>" . $barang['satuan'] . "</td>";
							echo "<td>" . number_format($barang['stock']) . "</td>";
							echo "<td>" . number_format($barang['stock_minimum']) . "</td>";
							echo "</tr>";
							$no++;
						}
					} else {
						echo "<tr><td colspan='7'>No Data Available</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
<div class="header">
	<h2><strong>Selamat Datang Di Aplikasi Marketing Tools</strong></h2>
</div>
<div class="block-flat">
	<div class="header">
		<h3 style="color: green;"><strong>Daftar Barang</strong></h3>
	</div>
	<div class="content">
		<table class="table no-border">
			<thead class="no-border">
				<tr>
					<th width="1%">No</th>
					<th>Kode Barang</th>
					<th>Jenis Barang</th>
					<th>Nama Barang</th>
					<th>Satuan</th>
				</tr>
			</thead>
			<tbody class="no-border-y">
				<?php
					if (count($barang) > 0) {
						$no = 1;
						foreach ($barang as $brg) {
							echo "<tr>";
							echo "<td>" . $no . "</td>";
							echo "<td>" . $brg['kode_barang'] . "</td>";
							echo "<td>" . $brg['jenis_barang'] . "</td>";
							echo "<td>" . $brg['nama_barang'] . "</td>";
							echo "<td>" . $brg['satuan'] . "</td>";
							echo "</tr>";
							$no++;
						}
					} else {
						echo "<tr><td colspan='7'>No Data Available</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>