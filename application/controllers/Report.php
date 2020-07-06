<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Report extends CI_Controller {

    var $content = "";
    var $dokumen = "";
    var $addHeader = array();
    function index($dok = "") {
        if($this->newsession->userdata('logged')){
			$this->load->model('main');
			$this->dokumen = $dok;
			$this->main->get_index($dok,$this->addHeader);	
		}else{
			$this->newsession->sess_destroy();		
			redirect(base_url());
		}
    }

    function type($param) {
    	$func = get_instance();
        $func->load->model("main", "main", true);
        $this->load->model("report_act");
        $this->addHeader["newtable"] = 1;
        $this->addHeader["ui"] = 1;
        $this->addHeader["alert"]    = 1;
        $this->addHeader["autocomplete"] = 1;
    	if ($param == "inout") {
    		if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->report_act->generate($param);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Laporan Pemasukan / Pengeluaran',
                'act' => 'save'
            );
            $this->content = $this->load->view('laporan/inout', $data, true);
            $this->index($tipe);
    	} elseif ($param == "inout_barang") {
    		if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->report_act->generate($param);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Laporan Keluar / Masuk Barang',
                'act' => 'save'
            );
            $this->content = $this->load->view('laporan/inout_barang', $data, true);
            $this->index($tipe);
    	} elseif ($param == "ketersediaan") {
    		$barang = $this->report_act->getData($param);
            $data = array(
                'judul' => 'Laporan Ketersediaan Barang',
                'barang' => $barang
            );
            $this->content = $this->load->view('laporan/ketersediaan_barang', $data, true);
            $this->index($tipe);
    	} elseif ($param == "qc") {
    		if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->report_act->generate($param);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Laporan Quality Control',
            );
            $this->content = $this->load->view('laporan/qc', $data, true);
            $this->index($tipe);
    	} elseif ($param == "mutasi") {
    		if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $data = $this->report_act->generate($param);
                echo $data;
                die();
            }
            $data = array(
                'judul' => 'Laporan Mutasi Barang'
            );
            $this->content = $this->load->view('laporan/mutasi', $data, true);
            $this->index($tipe);
    	}
    }

    function keluarMasuk($tglAwal, $tglAkhir, $id_barang) {
    	$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"] = 1;
		$this->addHeader["autocomplete"] = 1;
    	if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        # get data inout
        $this->load->model("report_act");
        $params = [
			'tanggalAwal' => $tglAwal,
			'tanggalAkhir' => $tglAkhir,
			'id_barang' => $id_barang
		];
		$dataBarang = $this->report_act->getData('data_barang', $params['id_barang']);
        $dataIn = $this->report_act->getData('inout_barang_in', $params);
        $dataOut = $this->report_act->getData('inout_barang_out', $params);
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
		
		$this->load->library('mpdf');
		$this->mpdf = new mPDF('UTF-8','A4','','',8,8,42,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetTitle('LAPORAN KELUAR MASUK BARANG.pdf');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML('<style>@page{odd-header-name: html_myHeader1;even-header-name: html_myHeader2; 
										odd-footer-name: html_myFooter1;
										even-footer-name: html_myFooter2;}</style>
										<htmlpageheader name="myHeader1" style="display:none">
										<div style="text-align:left;font-size:9pt;">
										LAPORAN KELUAR MASUK BARANG <br />
										<br /><br />
										PERIODE '.$tglAwal.' S.D '.$tglAkhir.' <br />
										KODE BARANG   : '.$dataBarang['kode_barang'].'<br/>
										JENIS BARANG  : '.$dataBarang['jenis_barang'].'<br/>
										SATUAN        : '.$dataBarang['satuan'].'
										</div>
										</htmlpageheader>
										<htmlpagefooter name="myFooter1" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>
										</tr></table>
										</htmlpagefooter>');
		$html .= '<span class="btn"></span>';	
		$html .= '<table class="tabelajax">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th width="1px">No</th>';
		$html .= '<th>Tanggal</th>';
		$html .= '<th>Nomor Pemasukan/Pengeluaran</th>';
		$html .= '<th>Jumlah Pemasukan</th>';
		$html .= '<th>Jumlah Pengeluaran</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$no = 1;
		foreach($data as $detail) {
			$html .= '<tr>';
			$html .= '<td>'.$no.'</td>';
			$html .= '<td>'.$detail['tanggal'].'</td>';
			$html .= '<td>'.$detail['nomor_transaksi'].'</td>';
			if ($detail['tipe'] == 'PENGADAAN') {
				$html .= '<td>'.number_format($detail['jumlah']).'</td>';
				$html .= '<td></td>';
			} else {
				$html .= '<td></td>';
				$html .= '<td>'.number_format($detail['jumlah']).'</td>';
			}
			$html .= '</tr>';
			$no++;
		}
		
		$html .= '</tbody>';	
		$html .= '</table>';

		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		$this->mpdf->Output('LAPORAN KELUAR MASUK BARANG.pdf','D');
    }

    function mutasi($tglAwal, $tglAkhir) {
    	$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
    	if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        $this->load->model("report_act");
		$this->load->library('mpdf');
		$this->mpdf = new mPDF('UTF-8','A4','','',8,8,30,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetTitle('mutasi.pdf');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML('<style>@page{odd-header-name: html_myHeader1;even-header-name: html_myHeader2; 
										odd-footer-name: html_myFooter1;
										even-footer-name: html_myFooter2;}</style>
										<htmlpageheader name="myHeader1" style="display:none">
										<div style="text-align:left;font-size:9pt;">
										LAPORAN MUTASI BARANG <br />
										<br /><br />
										PERIODE '.$tglAwal.' S.D '.$tglAkhir.' <br />
										</div>
										</htmlpageheader>						
										<htmlpagefooter name="myFooter1" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>
										</tr></table>
										</htmlpagefooter>');
		$html .= '<span class="btn"></span>';	
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
		# hitung mutasi
		$dBarang = $this->report_act->getData('ketersediaan');
		foreach ($dBarang as $brg) {
			# get saldo awal
			$paramSaldoAwal = [
				'id_barang' => $brg['id_barang'],
				'tanggal' => $tglAwal
			];
			$dStockAwal = $this->report_act->getData('saldo_awal', $paramSaldoAwal);
			if (empty($dStockAwal)) {
				$jmlStockAwal = 0;
				$tglStockAwal = $tglAwal;
			} else {
				$jmlStockAwal = $dStockAwal[0]['jumlah'];
				$tglStockAwal = $dStockAwal[0]['tanggal'];
			}

			# hitung pemasukan
			$paramInoutIn = [
				'id_barang' => $brg['id_barang'],
				'tanggalAwal' => $tglStockAwal,
				'tanggalAkhir' => $tglAkhir
			];
			$dInoutIn = $this->report_act->getData('inout_barang_in', $paramInoutIn);
			$jmlPemasukan = 0;
			foreach ($dInoutIn as $inoutIn) {
				$jmlPemasukan = $jmlPemasukan + $inoutIn['jumlah'];
			}

			# hitung pengeluaran
			$paramInoutOut = [
				'id_barang' => $brg['id_barang'],
				'tanggalAwal' => $tglStockAwal,
				'tanggalAkhir' => $tglAkhir
			];
			$dInoutOut = $this->report_act->getData('inout_barang_out', $paramInoutOut);
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

		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		$this->mpdf->Output('LAPORAN MUTASI.pdf','D');
    }

    function pemasukan($tglAwal, $tglAkhir) {
    	$this->addHeader["newtable"] = 1;
		$this->addHeader["ui"] = 1;
		$this->addHeader["alert"] = 1;
		$this->addHeader["autocomplete"] = 1;
    	if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
       	# get data inout
        $this->load->model("report_act");
        $params = [
			'tanggalAwal' => $tglAwal,
			'tanggalAkhir' => $tglAkhir,
			'jenis' => 'in'
		];
        $data = $this->report_act->getData('inout', $params);
       	# generate pdf
		$this->load->library('mpdf');
		$this->mpdf = new mPDF('UTF-8','A4','','',8,8,30,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetTitle('pemasukan.pdf');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML('<style>@page{odd-header-name: html_myHeader1;even-header-name: html_myHeader2; 
										odd-footer-name: html_myFooter1;
										even-footer-name: html_myFooter2;}</style>
										<htmlpageheader name="myHeader1" style="display:none">
										<div style="text-align:left;font-size:9pt;">
										LAPORAN PEMASUKAN BARANG <br />
										<br /><br />
										PERIODE '.$tglAwal.' S.D '.$tglAkhir.' <br />
										</div>
										</htmlpageheader>						
										<htmlpagefooter name="myFooter1" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>
										</tr></table>
										</htmlpagefooter>');
		$html .= '<span class="btn"></span>';	
		$html .= '<table class="tabelajax">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th width="1px">No</th>';
		$html .= '<th>Nomor Pengadaan</th>';
		$html .= '<th>Tanggal</th>';
		$html .= '<th>Kode Barang</th>';
		$html .= '<th>Jenis Barang</th>';
		$html .= '<th>Satauan</th>';
		$html .= '<th>Jumlah</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$no = 1;
		foreach ($data as $detail) {
			$html .= '<tr>';
			$html .= '<td>'.$no.'</td>';
			$html .= '<td>'.$detail['nomor_transaksi'].'</td>';
			$html .= '<td>'.$detail['tanggal'].'</td>';
			$html .= '<td>'.$detail['kode_barang'].'</td>';
			$html .= '<td>'.$detail['jenis_barang'].'</td>';
			$html .= '<td>'.$detail['satuan'].'</td>';
			$html .= '<td>'.number_format($detail['jumlah']).'</td>';
			$html .= '</tr>';
			$no++;
		}
		
		$html .= '</tbody>';	
		$html .= '</table>';

		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		$this->mpdf->Output('LAPORAN PEMASUKAN.pdf','D');
    }

    function pengeluaran($tglAwal, $tglAkhir) {
    	$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
    	if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        # get data inout
        $this->load->model("report_act");
        $params = [
			'tanggalAwal' => $tglAwal,
			'tanggalAkhir' => $tglAkhir,
			'jenis' => 'out'
		];
        $data = $this->report_act->getData('inout', $params);
        
       	# generate pdf
		$this->load->library('mpdf');
		$this->mpdf = new mPDF('UTF-8','A4','','',8,8,30,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetTitle('pengeluaran.pdf');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML('<style>@page{odd-header-name: html_myHeader1;even-header-name: html_myHeader2; 
										odd-footer-name: html_myFooter1;
										even-footer-name: html_myFooter2;}</style>
										<htmlpageheader name="myHeader1" style="display:none">
										<div style="text-align:left;font-size:9pt;">
										LAPORAN PENGELUARAN BARANG <br />
										<br /><br />
										PERIODE '.$tglAwal.' S.D '.$tglAkhir.' <br />
										</div>
										</htmlpageheader>						
										<htmlpagefooter name="myFooter1" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>
										</tr></table>
										</htmlpagefooter>');
		$html .= '<span class="btn"></span>';	
		$html .= '<table class="tabelajax">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th width="1px">No</th>';
		$html .= '<th>Tipe</th>';
		$html .= '<th>Nomor Transaksi</th>';
		$html .= '<th>Tanggal</th>';
		$html .= '<th>Kode Barang</th>';
		$html .= '<th>Jenis Barang</th>';
		$html .= '<th>Satauan</th>';
		$html .= '<th>Jumlah</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$no = 1;
		foreach ($data as $detail) {
			$html .= '<tr>';
			$html .= '<td>'.$no.'</td>';
			$html .= '<td>'.$detail['tipe'].'</td>';
			$html .= '<td>'.$detail['nomor_transaksi'].'</td>';
			$html .= '<td>'.$detail['tanggal'].'</td>';
			$html .= '<td>'.$detail['kode_barang'].'</td>';
			$html .= '<td>'.$detail['jenis_barang'].'</td>';
			$html .= '<td>'.$detail['satuan'].'</td>';
			$html .= '<td>'.number_format($detail['jumlah']).'</td>';
			$html .= '</tr>';
			$no++;
		}
		$html .= '</tbody>';	
		$html .= '</table>';

		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		$this->mpdf->Output('LAPORAN PENGELUARAN.pdf','D');
    }

    function qc($id) {
    	$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
    	if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        # get data inout
        $this->load->model("report_act");
		$data = $this->report_act->getData('qc', $id);
		// print_r($data); die();

		# generate pdf
		$this->load->library('mpdf');
		$this->mpdf = new mPDF('UTF-8','A4','','',8,8,30,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetTitle('laporan_qc.pdf');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML('<style>@page{odd-header-name: html_myHeader1;even-header-name: html_myHeader2; 
										odd-footer-name: html_myFooter1;
										even-footer-name: html_myFooter2;}</style>
										<htmlpageheader name="myHeader1" style="display:none">
										<div style="text-align:left;font-size:9pt;">
										LAPORAN QUALITY CONTROL <br />
										</div>
										</htmlpageheader>						
										<htmlpagefooter name="myFooter1" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>
										</tr></table>
										</htmlpagefooter>');
		$html .= '<span class="btn"></span>';
		$html .= '<table width="100%" style="font-size:9pt;">
			<tr>
				<td>
					<table>
						<tr>
							<td>Nomor Pengadaan</td>
							<td>:</td>
							<td>'.$data[0]['nomor_pengadaan'].'</td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td>:</td>
							<td>'.$data[0]['tanggal'].'</td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
							<td>Nomor Invoice</td>
							<td>:</td>
							<td>'.$data[0]['nomor_invoice'].'</td>
						</tr>
						<tr>
							<td>Nama Vendor</td>
							<td>:</td>
							<td>'.$data[0]['vendor'].'</td>
						</tr>
						<tr>
							<td>Keterangan</td>
							<td>:</td>
							<td>'.$data[0]['keterangan'].'</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><br>';
		$html .= '<table class="tabelajax">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th width="1px">No</th>';
		$html .= '<th>Kode Barang</th>';
		$html .= '<th>Jenis Barang</th>';
		$html .= '<th>Kesesuaian Produk</th>';
		$html .= '<th>Harga</th>';
		$html .= '<th>Kesesuaian Fungsi</th>';
		$html .= '<th>Kesesuaian Jumlah</th>';
		$html .= '<th>Kesesuaian Bahan</th>';
		$html .= '<th>Nilai QC</th>';
		$html .= '<th>Kesimpulan</th>';
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

		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		$this->mpdf->Output('LAPORAN QC.pdf','D');
    }

    function ketersediaan() {
    	$this->addHeader["newtable"]    = 1;
		$this->addHeader["ui"]    		= 1;
		$this->addHeader["alert"]    	= 1;
		$this->addHeader["autocomplete"]    	= 1;
    	if (!$this->newsession->userdata('logged')) {
            $this->index();
            return;
        }
        # get data inout
        $this->load->model("report_act");
        $barang = $this->report_act->getData('ketersediaan');
       	# generate pdf
		$this->load->library('mpdf');
		$this->mpdf = new mPDF('UTF-8','A4','','',8,8,30,25,10,13); 
		$this->mpdf->useOnlyCoreFonts = true;
		$this->mpdf->SetProtection(array('print'));
		$this->mpdf->list_indent_first_level = 0; 
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetTitle('ketersediaan.pdf');
		$page=$this->mpdf->AliasNbPages('[pagetotal]');
		$stylesheet = file_get_contents('assets/css/newtable.css');
		$this->mpdf->WriteHTML('<style>@page{odd-header-name: html_myHeader1;even-header-name: html_myHeader2; 
										odd-footer-name: html_myFooter1;
										even-footer-name: html_myFooter2;}</style>
										<htmlpageheader name="myHeader1" style="display:none">
										<div style="text-align:left;font-size:9pt;">
										LAPORAN KETERSEDIAAN BARANG <br />
										<br /><br />
										PERIODE '.date('Y-m-d').'<br/>
										</div>
										</htmlpageheader>						
										<htmlpagefooter name="myFooter1" style="display:none">
										<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
										color: #000000; font-weight: bold; font-style: italic;"><tr>
										<td width="50%" align="left">
										<span style="font-weight: bold; font-style: italic;">Tgl.Cetak {DATE d-m-Y}</span></td>
										<td width="50%" align="right">
										<span style="font-weight: bold; font-style: italic;">Halaman {PAGENO} dari [pagetotal]</span></td>
										</tr></table>
										</htmlpagefooter>');
		$html .= '<span class="btn"></span>';	
		$html .= '<table class="tabelajax">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th width="1px">No</th>';
		$html .= '<th width="15%">Kode Barang</th>';
		$html .= '<th width="10%">Jenis Barang</th>';
		$html .= '<th width="20%">Nama Barang</th>';
		$html .= '<th>Merk</th>';
		$html .= '<th width="5%">Satuan</th>';
		$html .= '<th width="10%">Stock</th>';
		$html .= '<th width="10%">Stock Minimum</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';	
		$no = 1;
		foreach ($barang as $brg) {
			$html .= '<tr>';
			$html .= '<td>'.$no.'</td>';
			$html .= '<td>'.$brg['kode_barang'].'</td>';
			$html .= '<td>'.$brg['jenis_barang'].'</td>';
			$html .= '<td>'.$brg['nama_barang'].'</td>';
			$html .= '<td>'.$brg['merk'].'</td>';
			$html .= '<td>'.$brg['satuan'].'</td>';
			$html .= '<td>'.number_format($brg['stock']).'</td>';
			$html .= '<td>'.number_format($brg['stock_minimum']).'</td>';
			$html .= '</tr>';
			$no++;
		}
		$html .= '</tbody>';	
		$html .= '</table>';

		$this->mpdf->WriteHTML($stylesheet,1);
		$this->mpdf->WriteHTML($html,2);
		$this->mpdf->Output('LAPORAN KETERSEDIAAN.pdf','D');
    }
}