<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Report_act extends CI_Model {

	function generate($type) {
		if ($type == 'inout') {
			$params = [
				'tanggalAwal' => $this->input->post('tanggal_awal'),
				'tanggalAkhir' => $this->input->post('tanggal_akhir'),
				'jenis' => $this->input->post('jenis')
			];
			if ($params['jenis'] == 'in') {
				$function = 'pemasukan';
				$kolTransaksi = 'Nomor Pengadaan';
			} else {
				$function = 'pengeluaran';
				$kolTransaksi = 'Nomor Transaksi';
			}
			
			# get data
			$data = $this->getData($type, $params);

			# generate laporan
			$url = site_url() . '/report/' . $function . '/' . $params['tanggalAwal'] . '/' . $params['tanggalAkhir'];
			$html .= '<a href="'.$url.'" target="_blank" title="Cetak" style="margin-right:12px"><i class="red icon-print"></i> Cetak</a>';
			$html .= '<table class="tabelajax">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th width="1px">No</th>';
			if ($params['jenis'] == 'out') {
				$html .= '<th>Tipe</th>';
			}
			$html .= '<th>'.$kolTransaksi.'</th>';
			$html .= '<th>Tanggal</th>';
			$html .= '<th>Kode Barang</th>';
			$html .= '<th>Jenis Barang</th>';
			$html .= '<th>Satauan</th>';
			$html .= '<th>Jumlah</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$no = 1;
			foreach ($data as $value) {
				$html .= '<tr>';
				$html .= '<td>'.$no.'</td>';
				if ($params['jenis'] == 'out') {
					$html .= '<td>'.$value['tipe'].'</td>';
				}
				$html .= '<td>'.$value['nomor_transaksi'].'</td>';
				$html .= '<td>'.$value['tanggal'].'</td>';
				$html .= '<td>'.$value['kode_barang'].'</td>';
				$html .= '<td>'.$value['jenis_barang'].'</td>';
				$html .= '<td>'.$value['satuan'].'</td>';
				$html .= '<td>'.number_format($value['jumlah']).'</td>';
				$html .= '</tr>';
				$no++;
			}
			$html .= '</tbody>';	
			$html .= '</table>';
		} elseif ($type == 'inout_barang') {
			$barang = $this->input->post('barang');
			$params = [
				'tanggalAwal' => $this->input->post('tanggal_awal'),
				'tanggalAkhir' => $this->input->post('tanggal_akhir'),
				'id_barang' => $barang['id_barang']
			];
			
			# get data
			$dataIn = $this->getData($type.'_in', $params);
			$dataOut = $this->getData($type.'_out', $params);
			$data = array();
			foreach ($dataIn as $in) {
				$data[$in['id']]['id'] = $in['id'];
				$data[$in['id']]['tipe'] = $in['tipe'];
				$data[$in['id']]['tanggal'] = $in['tanggal'];
				$data[$in['id']]['nomor_transaksi'] = $in['nomor_transaksi'];
				$data[$in['id']]['jumlah'] = $in['jumlah'];
			}
			foreach ($dataOut as $out) {
				$data[$out['id']]['id'] = $out['id'];
				$data[$out['id']]['tipe'] = $out['tipe'];
				$data[$out['id']]['tanggal'] = $out['tanggal'];
				$data[$out['id']]['nomor_transaksi'] = $out['nomor_transaksi'];
				$data[$out['id']]['jumlah'] = $out['jumlah'];
			}
			ksort($data);

			# generate laporan
			$url = site_url() . '/report/keluarMasuk/' . $params['tanggalAwal'] . '/' . $params['tanggalAkhir'] . '/' . $params['id_barang'];
			$html .= '<a href="'.$url.'" target="_blank" title="Cetak" style="margin-right:12px"><i class="red icon-print"></i> Cetak</a>';
			$html .= '<table class="tabelajax">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th width="1px">No</th>';
			$html .= '<th>Tanggal</th>';
			$html .= '<th>Nomor Pemasukan / Pengeluaran</th>';
			$html .= '<th>Jumlah Pemasukan</th>';
			$html .= '<th>Jumlah Pengeluaran</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$no = 1;
			foreach ($data as $value) {
				$html .= '<tr>';
				$html .= '<td>'.$no.'</td>';
				$html .= '<td>'.$value['tanggal'].'</td>';
				$html .= '<td>'.$value['nomor_transaksi'].'</td>';
				if ($value['tipe'] == 'PENGADAAN') {
					$html .= '<td>'.number_format($value['jumlah']).'</td>';
					$html .= '<td></td>';
				} else {
					$html .= '<td></td>';
					$html .= '<td>'.number_format($value['jumlah']).'</td>';
				}
				$html .= '</tr>';
				$no++;
			}
			$html .= '</tbody>';	
			$html .= '</table>';
		} elseif ($type == 'qc') {
			# get data
			$qc = $this->input->post('qc');
			$data = $this->getData($type, $qc['id_pemasukan']);

			# generate laporan
			$url = site_url() . '/report/qc/' . $qc['id_pemasukan'];
			$html .= '<a href="'.$url.'" target="_blank" title="Cetak" style="margin-right:12px"><i class="red icon-print"></i> Cetak</a>';
			$html .= '<table class="tabelajax">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th width="1px">No</th>';
			$html .= '<th>Kode Barang</th>';
			$html .= '<th>Jenis Barang</th>';
			$html .= '<th width="10%">Kesesuaian Produk</th>';
			$html .= '<th width="10%">Harga</th>';
			$html .= '<th width="10%">Kesesuaian Fungsi</th>';
			$html .= '<th width="10%">Kesesuaian Jumlah</th>';
			$html .= '<th width="10%">Kesesuaian Bahan</th>';
			$html .= '<th width="10%">Nilai QC</th>';
			$html .= '<th width="10%">Kesimpulan</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$no = 1;
			foreach ($data as $value) {
				if ($value['nilai_qc'] < 0.6) {
					$kesimpulan = "Kurang";
				} elseif ($value['nilai_qc'] < 0.7) {
					$kesimpulan = "Cukup";
				} elseif ($value['nilai_qc'] < 0.8) {
					$kesimpulan = "Baik";
				} else {
					$kesimpulan = "Sangat Baik";
				}
				$html .= '<tr>';
				$html .= '<td>'.$no.'</td>';
				$html .= '<td>'.$value['kode_barang'].'</td>';
				$html .= '<td>'.$value['jenis_barang'].'</td>';
				$html .= '<td>'.$value['nilai_k1'].'</td>';
				$html .= '<td>'.$value['nilai_k2'].'</td>';
				$html .= '<td>'.$value['nilai_k3'].'</td>';
				$html .= '<td>'.$value['nilai_k4'].'</td>';
				$html .= '<td>'.$value['nilai_k5'].'</td>';
				$html .= '<td>'.$value['nilai_qc'].'</td>';
				$html .= '<td>'.$kesimpulan.'</td>';
				$html .= '</tr>';
				$no++;
			}
			$html .= '</tbody>';
			$html .= '</table>';
		} elseif ($type == 'mutasi') {
			$params = [
				'tanggalAwal' => $this->input->post('tanggal_awal'),
				'tanggalAkhir' => $this->input->post('tanggal_akhir')
			];
			# generate laporan
			$url = site_url() . '/report/mutasi/' . $params['tanggalAwal'] . '/' . $params['tanggalAkhir'];
			$html .= '<a href="'.$url.'" target="_blank" title="Cetak" style="margin-right:12px"><i class="red icon-print"></i> Cetak</a>';
			$html .= '<table class="tabelajax">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th width="1px">No</th>';
			$html .= '<th>Kode Barang</th>';
			$html .= '<th>Jenis Barang</th>';
			$html .= '<th>Nama Barang</th>';
			$html .= '<th width="5%">Satuan</th>';
			$html .= '<th width="10%">Saldo Awal</th>';
			$html .= '<th width="10%">Pemasukan</th>';
			$html .= '<th width="10%">Pengeluaran</th>';
			$html .= '<th width="10%">Saldo Akhir</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$no = 1;
			# hitung mutasi
			$dBarang = $this->getData('ketersediaan');
			foreach ($dBarang as $brg) {
				# get saldo awal
				$paramSaldoAwal = [
					'id_barang' => $brg['id_barang'],
					'tanggal' => $params['tanggalAwal']
				];
				$dStockAwal = $this->getData('saldo_awal', $paramSaldoAwal);
				if (empty($dStockAwal)) {
					$dStockAwal = $this->getData('saldo_awal_null', $paramSaldoAwal);
					
					$jmlStockAwal = $dStockAwal[0]['jumlah'];
					$tglStockAwal = $dStockAwal[0]['tanggal'];
				} else {
					$jmlStockAwal = $dStockAwal[0]['jumlah'];
					$tglStockAwal = $dStockAwal[0]['tanggal'];
				}

				# hitung pemasukan
				$paramInoutIn = [
					'id_barang' => $brg['id_barang'],
					'tanggalAwal' => $tglStockAwal,
					'tanggalAkhir' => $params['tanggalAkhir']
				];
				$dInoutIn = $this->getData('inout_barang_in', $paramInoutIn);
				$jmlPemasukan = 0;
				foreach ($dInoutIn as $inoutIn) {
					$jmlPemasukan = $jmlPemasukan + $inoutIn['jumlah'];
				}

				# hitung pengeluaran
				$paramInoutOut = [
					'id_barang' => $brg['id_barang'],
					'tanggalAwal' => $tglStockAwal,
					'tanggalAkhir' => $params['tanggalAkhir']
				];
				$dInoutOut = $this->getData('inout_barang_out', $paramInoutOut);
				$jmlPengeluaran = 0;
				foreach ($dInoutOut as $inoutOut) {
					$jmlPengeluaran = $jmlPengeluaran + $inoutOut['jumlah'];
				}

				# hitung saldo akhir
				$saldoAkhir = $jmlStockAwal + $jmlPemasukan - $jmlPengeluaran;

				# generate html
				$html .= '<tr>';
				$html .= '<td>'.$no.'</td>';
				$html .= '<td>'.$brg['kode_barang'].'</td>';
				$html .= '<td>'.$brg['jenis_barang'].'</td>';
				$html .= '<td>'.$brg['nama_barang'].'</td>';
				$html .= '<td>'.$brg['satuan'].'</td>';
				$html .= '<td>'.number_format($jmlStockAwal).'</td>';
				$html .= '<td>'.number_format($jmlPemasukan).'</td>';
				$html .= '<td>'.number_format($jmlPengeluaran).'</td>';
				$html .= '<td>'.number_format($saldoAkhir).'</td>';
				$html .= '</tr>';
				$no++;
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}
		$response = $html;
		return $response;
	}

	function getData($type, $params) {
		if ($type == 'data_barang') {
			$sql = "SELECT a.id_barang, a.kode_barang, a.satuan, b.jenis_barang
					FROM tbl_barang a
					LEFT JOIN tbl_jenis_barang b ON b.id_jenis_barang = a.jenis_barang
					WHERE id_barang = '" . $params . "'";
			$response = $this->db->query($sql)->row_array();
			return $response;
		} elseif ($type == 'inout') {
			if ($params['jenis'] == 'in') {
				$sql = "SELECT a.id, a.id_header, a.id_detail, a.nomor_transaksi, a.id_barang, a.jumlah,
						b.tanggal, c.kode_barang, c.satuan, d.jenis_barang
						FROM tbl_inout a
						LEFT JOIN tbl_pemasukan b ON b.id_pemasukan = a.id_header
						LEFT JOIN tbl_barang c ON c.id_barang = a.id_barang
						LEFT JOIN tbl_jenis_barang d ON d.id_jenis_barang = c.jenis_barang
						WHERE a.tipe = 'PENGADAAN' AND b.tanggal BETWEEN '" . $params['tanggalAwal'] . "' AND '" . $params['tanggalAkhir'] . "'";
			} else {
				$sql = "SELECT a.id, a.id_header, a.id_detail, a.nomor_transaksi, a.id_barang, a.jumlah,
						b.tipe, b.tanggal, c.kode_barang, c.satuan, d.jenis_barang
						FROM tbl_inout a
						LEFT JOIN tbl_pengeluaran b ON b.id_pengeluaran = a.id_header
						LEFT JOIN tbl_barang c ON c.id_barang = a.id_barang
						LEFT JOIN tbl_jenis_barang d ON d.id_jenis_barang = c.jenis_barang
						WHERE a.tipe <> 'PENGADAAN' AND b.tanggal BETWEEN '" . $params['tanggalAwal'] . "' AND '" . $params['tanggalAkhir'] . "'";
			}
		} elseif ($type == 'inout_barang_in') {
			# sql inout pemasukan
			$sql = "SELECT a.id, a.id_header, a.id_detail, a.nomor_transaksi, a.tipe, a.jumlah,
					b.tanggal
					FROM tbl_inout a
					LEFT JOIN tbl_pemasukan b ON b.id_pemasukan = a.id_header
					WHERE a.tipe = 'PENGADAAN' 
					AND a.id_barang = '".$params['id_barang']."'
					AND b.tanggal BETWEEN '" . $params['tanggalAwal'] . "' AND '" . $params['tanggalAkhir'] . "'";
		} elseif ($type == 'inout_barang_out') {
			# sql inout pengeluaran
			$sql = "SELECT a.id, a.id_header, a.id_detail, a.nomor_transaksi, a.tipe, a.jumlah,
					b.tanggal
					FROM tbl_inout a
					LEFT JOIN tbl_pengeluaran b ON b.id_pengeluaran = a.id_header
					WHERE a.tipe <> 'PENGADAAN' 
					AND a.id_barang = '".$params['id_barang']."'
					AND b.tanggal BETWEEN '" . $params['tanggalAwal'] . "' AND '" . $params['tanggalAkhir'] . "'";
		} elseif ($type == 'ketersediaan') {
			$sql = "SELECT a.id_barang, a.kode_barang, b.jenis_barang, a.nama_barang, a.merk, a.satuan, a.stock, a.stock_minimum
					FROM tbl_barang a
					LEFT JOIN tbl_jenis_barang b ON b.id_jenis_barang = a.jenis_barang";
		} elseif ($type == 'qc') {
			$sql = "SELECT b.nomor_pengadaan, b.tanggal, b.nomor_invoice, b.vendor, b.keterangan,
					a.nilai_k1, a.nilai_k2, a.nilai_k3, a.nilai_k4, a.nilai_k5, a.nilai_qc,
					c.kode_barang, d.jenis_barang
					FROM tbl_pemasukan_detail a
					LEFT JOIN tbl_pemasukan b ON b.id_pemasukan = a.id_pemasukan
					LEFT JOIN tbl_barang c ON c.id_barang = a.id_barang
					LEFT JOIN tbl_jenis_barang d ON d.id_jenis_barang = c.jenis_barang
					WHERE a.id_pemasukan = '" . $params . "'";
		} elseif ($type == 'saldo_awal') {
			$sql = "SELECT id, tanggal, id_barang, jumlah FROM tbl_stockopname
					WHERE id_barang = '" . $params['id_barang'] . "'
					AND tanggal <= '" . $params['tanggal'] . "'
					ORDER BY tanggal DESC limit 1";
		} elseif ($type == 'saldo_awal_null') {
			$sql = "SELECT id, tanggal, id_barang, jumlah FROM tbl_stockopname
					WHERE id_barang = '" . $params['id_barang'] . "'
					ORDER BY tanggal ASC limit 1";
		}
		$response = $this->db->query($sql)->result_array();
		return $response;
	}
}