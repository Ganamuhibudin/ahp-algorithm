<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

function getKeterangan($jml){
	if($jml<0) return "SELISIH KURANG";
	if($jml>0) return "SELISIH LEBIH";
	if($jml==0) return "SESUAI";
}
$kodeTrader = $this->newsession->userdata('KODE_TRADER');
if ($tipe == "mutasi") {
    $addUrl = "";
    if ($dataRec == '0')
        $addUrl = "/add/mutasi";
    else
        $addUrl = "/edit/mutasi";

    //if (count($resultData) > 0) {
        ?>  
       
        <div style="margin-bottom:5px";>
            <a href="javascript:void(0);" 
               onclick="print_('<?= base_url(); ?>index.php/laporan/print_dok/mutasi_bb/<?= $tglAwal; ?>/<?= $tglAkhir; ?>', '<?= $nama; ?>', '', '', '<?= $ALL; ?>', '<?= $showpage?>', '<?= $halaman.'|'.$JUMPAGES; ?>');"><img src="<?= base_url(); ?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;
            <a href="<?= site_url(); ?>/laporan/print_dok/mutasi_bb/<?= $tglAwal; ?>/<?= $tglAkhir; ?>/<?= $nama; ?>/!/!/<?= $ALL ? $ALL : 0; ?>/excel/<?= $showpage ? $showpage : 0; ?>/<?= $halaman; ?>/<?= $JUMPAGES; ?>"><img src="<?= base_url(); ?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;  <strong>Cetak Excel</strong></a>
        </div>
    <?php //} ?>

    <input type="hidden" name="PERIODE_SALDO_AWAL" value="<?= $tglAwal; ?>" />
    <input type="hidden" name="PERIODE_SALDO_AKHIR" value="<?= $tglAkhir; ?>" />
    <table class="tabelPopUp" width="100%">
    <?=$PAGING_TOP;?>
        <tr>
            <th rowspan="2" align="center" width="1%">No</th>
            <th rowspan="2" width="7%">Kode&nbsp;Barang</th>
            <th rowspan="2" width="22%">Nama&nbsp;Barang</th>
            <th rowspan="2" width="4%">Satuan</th>
            <th width="8%">Saldo&nbsp;Awal</th>
            <th rowspan="2" width="8%">Pemasukan</th>
            <th rowspan="2" width="8%">Pengeluaran</th>
            <th rowspan="2" width="8%">Penyesuaian (Adjusment)</th>
            <th width="8%">Saldo&nbsp;Akhir</th>
            <th width="8%">Stock&nbsp;Opname</th>
            <th rowspan="2" width="8%">Selisih</th>
            <th rowspan="2" width="10%">Keterangan</th>
        </tr>
        <tr>
            <th><?= $this->fungsi->FormatDate($tglAwal); ?><input type="hidden" name="TANGGAL_AWAL" value="<?= $tglAwal; ?>" /></th>
            <th><?= $this->fungsi->FormatDate($tglAkhir); ?><input type="hidden" name="TANGGAL_AKHIR" value="<?= $tglAkhir; ?>" /></th>
            <th><?= $TGLSTOCK ? $this->fungsi->FormatDate($TGLSTOCK) : "-"; ?><input type="hidden" name="PERIODE_STOCK_OPNAME" value="<?= $TGLSTOCK; ?>" /></th>
        </tr>
        <?php $banyakData = count($resultData); ?>

        <input type="hidden" name="BANYAKDATA" value="<?= $banyakData; ?>" />

        <?php
        if ($banyakData > 0) {
            //$no = 1;
            $SaldoAwl = 0;
            foreach ($resultData as $listData) {
                #KOLOM PEMASUKAN
                if ($listData['PEMASUKAN'] == '') {
                    $sqlGetMasuk = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS PEMASUKAN
						   FROM m_trader_barang_inout
						   WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "' 
						   AND KODE_TRADER = '" . $kodeTrader . "'
						   AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' 
						   AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
						   AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";
                    if ($KODE_LOKASI) {
                        $sqlGetMasuk .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                    }
                    $sqlGetMasuk .= " GROUP BY KODE_BARANG, JNS_BARANG";

                    $MASUK = $this->db->query($sqlGetMasuk)->row();
                    $MASUK = $MASUK->PEMASUKAN;
                } else {
                    $MASUK = $listData['PEMASUKAN'];
                }
                //CEK DARI DATA MUTASI YG DISIMPAN
                $sqlGetSaldoAwl = "SELECT JUMLAH_SALDO_AKHIR
							 FROM r_trader_mutasi
							 WHERE TANGGAL_AWAL > '1999-01-01'
							 AND TANGGAL_AKHIR = DATE_SUB('" . $tglAwal . "',INTERVAL 1 DAY) 
							 AND KODE_BARANG = '" . $listData['KODE_BARANG'] . "' 
							 AND JNS_BARANG = '" . $listData['JNS_BARANG'] . "'
							 AND KODE_TRADER = '" . $kodeTrader . "'";
                if ($KODE_LOKASI) {
                    $sqlGetSaldoAwl .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                }
                $sqlGetSaldoAwl .= " ORDER BY TANGGAL_AKHIR DESC";
                $query = $this->db->query($sqlGetSaldoAwl);
				$JUM_TERSIMPAN = $query->num_rows();
                $SALDOAWLGET = 0;
                if ($JUM_TERSIMPAN== 0) {
                    //KOLOM SALDO AWAL
                    if ($listData['JUMLAH_SALDO_AKHIR'] == '') {
                        $tglAwalInOut = date('Y-m-d', strtotime($TGLSTOCK . "+1 day"));
                        $tglAkhirInOut = date('Y-m-d', strtotime($tglAwal . "-1 day"));
                        $sqlGetSaldoStock = "SELECT JUMLAH AS 'JUMLAH_STOCK', TANGGAL_STOCK
										FROM m_trader_stockopname
										WHERE KODE_TRADER ='" . $kodeTrader . "' 
										AND TANGGAL_STOCK <= '" . $tglAwal . "'
										AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' 
										AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'";
                        if ($KODE_LOKASI) {
                            $sqlGetSaldoStock .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                        }
                        $sqlGetSaldoStock .= " ORDER BY TANGGAL_STOCK DESC LIMIT 1";

                        $RSSTOCKOPNAME = $this->db->query($sqlGetSaldoStock)->row();
                        $GETSALDOAWALSTOCK = $RSSTOCKOPNAME->JUMLAH_STOCK;

                        $TGSTK = "";
                        if ($RSSTOCKOPNAME->TANGGAL_STOCK != "") {
                            $TGSTK = " BETWEEN '" . date('Y-m-d', strtotime($RSSTOCKOPNAME->TANGGAL_STOCK.'+1 day')) . "' AND '" . $tglAkhirInOut . "'";
                        } else {
                            $TGSTK = " <= '" . $tglAkhirInOut . "'";
                        }

                        $sqlGetSaldoIn = "SELECT SUM(JUMLAH) AS 'AWAL_SALDO_IN', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_IN'
									  FROM m_trader_barang_inout
									  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') " . $TGSTK . "
									  AND KODE_TRADER = '" . $kodeTrader . "'
									  AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'				  
									  AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";
                        if ($KODE_LOKASI) {
                            $sqlGetSaldoIn .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                        }
                        $sqlGetSaldoIn .= " GROUP BY KODE_BARANG, JNS_BARANG";

                        $sqlGetSaldoOut = "SELECT SUM(JUMLAH) AS 'AWAL_SALDO_OUT', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_OUT'
									  FROM m_trader_barang_inout
									  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') " . $TGSTK . "
									  AND KODE_TRADER = '" . $kodeTrader . "'								  
									  AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
									  AND TIPE IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";
                        if ($KODE_LOKASI) {
                            $sqlGetSaldoOut .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                        }
                        $sqlGetSaldoOut .= " GROUP BY KODE_BARANG, JNS_BARANG";


                        //if($listData['KODE_BARANG']=="105098400") echo $sqlGetSaldoIn;
                        $RSGETSALDOAWALIN = $this->db->query($sqlGetSaldoIn)->row();
                        $GETSALDOAWALIN = $RSGETSALDOAWALIN->AWAL_SALDO_IN;
                        $RSGETSALDOAWALOUT = $this->db->query($sqlGetSaldoOut)->row();
                        $GETSALDOAWALOUT = $RSGETSALDOAWALOUT->AWAL_SALDO_OUT;

                        if ($GETSALDOAWALSTOCK == "") { //if($listData['KODE_BARANG']=="105098400") echo $RSGETSALDOAWALIN->AWAL_SALDO_IN;;
                            $SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT;
                        } else {
                            if ($RSSTOCKOPNAME->TANGGAL_STOCK == $tglAkhirInOut) {
                                //if($listData['KODE_BARANG']=="105098400") echo "-";
                                $SALDOAWLGET = $GETSALDOAWALSTOCK;
                            } else {
                                if ($RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALIN->TGL_IN || $RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALOUT->TGL_OUT) { //if($listData['KODE_BARANG']=="105098400") echo "- -";
                                    $SALDOAWLGET = $GETSALDOAWALSTOCK;
                                } else {
                                    // if($listData['KODE_BARANG']=="105098400") echo "- - -";
                                    $SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT;
                                }
                            }
                        }
                        $SALDOAWL = $SALDOAWLGET;
                    } else {
                        $SALDOAWL = $listData['JUMLAH_SALDO_AWAL'];
                    }
                } else {
                    $tglAkhirInOut = date('Y-m-d', strtotime($tglAwal . "-1 day"));
                    $sqlGetSaldoStock = "SELECT JUMLAH AS 'JUMLAH_STOCK', TANGGAL_STOCK
									FROM m_trader_stockopname
									WHERE TANGGAL_STOCK <= '" . $tglAwal . "'
									AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' 
									AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
									AND KODE_TRADER ='" . $kodeTrader . "'";
                    if ($KODE_LOKASI) {
                        $sqlGetSaldoStock .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                    }
                    $sqlGetSaldoStock .= " ORDER BY TANGGAL_STOCK DESC LIMIT 1";

                    $RSSTOCKOPNAME = $this->db->query($sqlGetSaldoStock)->row();
                    $GETSALDOAWALSTOCK = $RSSTOCKOPNAME->JUMLAH_STOCK;
                    if ($GETSALDOAWALSTOCK != "") {
                        if ($RSSTOCKOPNAME->TANGGAL_STOCK == $tglAkhirInOut) {
                            $SALDOAWL = $GETSALDOAWALSTOCK;
                        } else {
                            if ($listData['JUMLAH_SALDO_AKHIR'] == '') {
                                $SALDOAWL = $query->row();
                                $SALDOAWL = $SALDOAWL->JUMLAH_SALDO_AKHIR ? $SALDOAWL->JUMLAH_SALDO_AKHIR : $SALDOAWLGET;
                            } else {
                                $SALDOAWL = $listData['JUMLAH_SALDO_AWAL'];
                            }
                        }
                    } else {
                        if ($listData['JUMLAH_SALDO_AKHIR'] == '') {
                            $SALDOAWL = $query->row();
                            $SALDOAWL = $SALDOAWL->JUMLAH_SALDO_AKHIR ? $SALDOAWL->JUMLAH_SALDO_AKHIR : $SALDOAWLGET;
                        } else {
                            $SALDOAWL = $listData['JUMLAH_SALDO_AWAL'];
                        }
                    }
                }

                #KOLOM PENGELUARAN		  
                if ($listData['PENGELUARAN'] == '') {
                    $sqlGetKeluar = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS PENGELUARAN
						FROM m_trader_barang_inout
						WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'
						AND KODE_TRADER = '" . $kodeTrader . "'
						AND KODE_BARANG = '" . $listData['KODE_BARANG'] . "' AND JNS_BARANG = '" . $listData['JNS_BARANG'] . "'
						AND TIPE IN ('GATE-OUT','MUSNAH','RUSAK','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";
                    if ($KODE_LOKASI) {
                        $sqlGetKeluar .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                    }
                    $sqlGetKeluar .= " GROUP BY KODE_BARANG, JNS_BARANG";

                    $KELUAR = $this->db->query($sqlGetKeluar)->row();
                    $KELUAR = $KELUAR->PENGELUARAN;
                } else {
                    $KELUAR = $listData['PENGELUARAN'];
                }
                #KOLOM PENYESUAIAN
                if ($listData['PENYESUAIAN'] == '') {
                    $PENYESUAIAN = 0;
                } else {
                    $PENYESUAIAN = $listData['PENYESUAIAN'];
                }
                #KOLOM SALDO AKHIR
                if ($listData['JUMLAH_SALDO_AKHIR'] == '') {
                    $SALDOAKHR = $SALDOAWL + $MASUK - $KELUAR + $PENYESUAIAN;
                } else {
                    $SALDOAKHR = $listData['JUMLAH_SALDO_AKHIR'];
                }
                #KOLOM STOCKOPNAME
                if ($listData['STOCK_OPNAME'] == '') {
                    $sqlGetStock = "SELECT JUMLAH
								FROM m_trader_stockopname
								WHERE TANGGAL_STOCK='" . $TGLSTOCK . "' 
								AND KODE_BARANG = '" . $listData['KODE_BARANG'] . "' 
								AND JNS_BARANG = '" . $listData['JNS_BARANG'] . "'
								AND KODE_TRADER = '" . $kodeTrader . "'";
                    if ($KODE_LOKASI) {
                        $sqlGetStock .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                    }
                    $STOCK = $this->db->query($sqlGetStock);
                    if ($STOCK->num_rows() > 0) {
                        $STOCK = $STOCK->row();
                        $STOCK = $STOCK->JUMLAH;
                    } else {
                        $STOCK = "";
                    }
                } else {
                    $STOCK = $listData['STOCK_OPNAME'];
                }
                #UNTUK MENAMPILKAN SEMUA BARANG BAIK YG DIMUTASI ATAU TIDAK
                if ($ALL) {
                    if (!in_array($listData['KODE_BARANG'], $INARRAY)) {
						if($JUM_TERSIMPAN == 0){
							if ($listData['JUMLAH_SALDO_AKHIR'] == '') {
								$tglAkhirInOut = date('Y-m-d', strtotime($tglAwal . "-1 day"));
								$sqlGetSaldoStock = "SELECT JUMLAH AS 'JUMLAH_STOCK', TANGGAL_STOCK
											FROM m_trader_stockopname
											WHERE TANGGAL_STOCK <= '" . $tglAwal . "'
											AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' 
											AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
											AND KODE_TRADER ='" . $kodeTrader . "'";
								if ($KODE_LOKASI) {
									$sqlGetSaldoStock .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
								}
								$sqlGetSaldoStock .= " ORDER BY TANGGAL_STOCK DESC LIMIT 1";
		
								$RSSTOCKOPNAME = $this->db->query($sqlGetSaldoStock)->row();
								$GETSALDOAWALSTOCK = $RSSTOCKOPNAME->JUMLAH_STOCK;
		
								$TGSTK = "";
								if ($RSSTOCKOPNAME->TANGGAL_STOCK != "") {
									$TGSTK = " BETWEEN '" . date('Y-m-d', strtotime($RSSTOCKOPNAME->TANGGAL_STOCK.'+1 day')) . "' AND '" . $tglAkhirInOut . "'";
								} else {
									$TGSTK = " <= '" . $tglAkhirInOut . "'";
								}
		
								$sqlGetSaldoIn = "SELECT SUM(JUMLAH) AS 'AWAL_SALDO_IN', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_IN'
											  FROM m_trader_barang_inout
											  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') " . $TGSTK . "
											  AND KODE_TRADER = '" . $kodeTrader . "'
											  AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
											  AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";
								if ($KODE_LOKASI) {
									$sqlGetSaldoIn .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
								}
								$sqlGetSaldoIn .= " GROUP BY KODE_BARANG, JNS_BARANG";
		
								$sqlGetSaldoOut = "SELECT SUM(JUMLAH) AS 'AWAL_SALDO_OUT', STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_OUT'
											  FROM m_trader_barang_inout
											  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') " . $TGSTK . "
											  AND KODE_TRADER = '" . $kodeTrader . "'
											  AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
											  AND TIPE IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";
								if ($KODE_LOKASI) {
									$sqlGetSaldoOut .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
								}
								$sqlGetSaldoOut .= " GROUP BY KODE_BARANG, JNS_BARANG";
		
								$RSGETSALDOAWALIN = $this->db->query($sqlGetSaldoIn)->row();
								$GETSALDOAWALIN = $RSGETSALDOAWALIN->AWAL_SALDO_IN;
								$RSGETSALDOAWALOUT = $this->db->query($sqlGetSaldoOut)->row();
								$GETSALDOAWALOUT = $RSGETSALDOAWALOUT->AWAL_SALDO_OUT;
		
								if ($GETSALDOAWALSTOCK == "") {
									$SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT;
								} else {
									if ($RSSTOCKOPNAME->TANGGAL_STOCK == $tglAkhirInOut) {
										$SALDOAWLGET = $GETSALDOAWALSTOCK;
									} else {
										if ($RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALIN->TGL_IN || $RSSTOCKOPNAME->TANGGAL_STOCK == $RSGETSALDOAWALOUT->TGL_OUT) {
											$SALDOAWLGET = $GETSALDOAWALSTOCK;
										} else {
											$SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT;
										}
									}
								}
							}else{
								$SALDOAWLGET = $listData['JUMLAH_SALDO_AKHIR'];
							}
						}else{
							$tglAkhirInOut = date('Y-m-d', strtotime($tglAwal . "-1 day"));
							$sqlGetSaldoStock = "SELECT JUMLAH AS 'JUMLAH_STOCK', TANGGAL_STOCK
											FROM m_trader_stockopname
											WHERE TANGGAL_STOCK <= '" . $tglAwal . "'
											AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' 
											AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
											AND KODE_TRADER ='" . $kodeTrader . "'";
							if ($KODE_LOKASI) {
								$sqlGetSaldoStock .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
							}
							$sqlGetSaldoStock .= " ORDER BY TANGGAL_STOCK DESC LIMIT 1";
		
							$RSSTOCKOPNAME = $this->db->query($sqlGetSaldoStock)->row();
							$GETSALDOAWALSTOCK = $RSSTOCKOPNAME->JUMLAH_STOCK;
							if ($GETSALDOAWALSTOCK != "") {
								if ($RSSTOCKOPNAME->TANGGAL_STOCK == $tglAkhirInOut) {
									$SALDOAWL = $GETSALDOAWALSTOCK;
								} else {
									if ($listData['JUMLAH_SALDO_AKHIR'] == '') {
										$SALDOAWL = $query->row();
										$SALDOAWL = $SALDOAWL->JUMLAH_SALDO_AKHIR ? $SALDOAWL->JUMLAH_SALDO_AKHIR : $SALDOAWLGET;
									} else {
										$SALDOAWL = $listData['JUMLAH_SALDO_AWAL'];
									}
								}
							} else {
								if ($listData['JUMLAH_SALDO_AKHIR'] == '') {
									$SALDOAWL = $query->row();
									$SALDOAWL = $SALDOAWL->JUMLAH_SALDO_AKHIR ? $SALDOAWL->JUMLAH_SALDO_AKHIR : $SALDOAWLGET;
								} else {
									$SALDOAWL = $listData['JUMLAH_SALDO_AWAL'];
								}
							}
                			$SALDOAWLGET = $SALDOAWL;
						}

                        $sqlGetMasuk = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS PEMASUKAN
						        FROM m_trader_barang_inout
						        WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'
						        AND KODE_TRADER = '" . $kodeTrader . "'
						        AND KODE_BARANG ='" . $listData['KODE_BARANG'] . "' 
						        AND JNS_BARANG ='" . $listData['JNS_BARANG'] . "'
						        AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')";

                        if ($KODE_LOKASI) {
                            $sqlGetMasuk .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                        }
                        $sqlGetMasuk .= " GROUP BY KODE_BARANG, JNS_BARANG";

                        $MASUK = $this->db->query($sqlGetMasuk)->row();
                        $MASUK = $MASUK->PEMASUKAN;

                        #KOLOM PENGELUARAN
                        if ($listData['PENGELUARAN'] == '') {
                            $sqlGetKeluar = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS PENGELUARAN
								   FROM m_trader_barang_inout
								   WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'
								   AND KODE_TRADER = '" . $kodeTrader . "'
								   AND KODE_BARANG = '" . $listData['KODE_BARANG'] . "' AND JNS_BARANG = '" . $listData['JNS_BARANG'] . "'
								   AND TIPE IN ('GATE-OUT','MUSNAH','RUSAK','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK')";

                            if ($KODE_LOKASI) {
                                $sqlGetKeluar .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                            }
                            $sqlGetKeluar .= " GROUP BY KODE_BARANG, JNS_BARANG";

                            $KELUAR = $this->db->query($sqlGetKeluar)->row();
                            $KELUAR = $KELUAR->PENGELUARAN;
                        } else {
                            $KELUAR = $listData['PENGELUARAN'];
                        }
                        $SALDOAWL = $SALDOAWLGET;
                        $SALDOAKHR = $SALDOAWL + $MASUK - $KELUAR + 0;

                        #KOLOM STOCKOPNAME
                        if ($listData['STOCK_OPNAME'] == '') {
                            $sqlGetStock = "SELECT JUMLAH
								FROM m_trader_stockopname
								WHERE TANGGAL_STOCK='" . $TGLSTOCK . "'
								AND KODE_BARANG = '" . $listData['KODE_BARANG'] . "' 
								AND JNS_BARANG = '" . $listData['JNS_BARANG'] . "'
								AND KODE_TRADER = '" . $kodeTrader . "'";
                            if ($KODE_LOKASI) {
                                $sqlGetStock .= " AND KODE_LOKASI = '" . $KODE_LOKASI . "'";
                            }
                            $STOCK = $this->db->query($sqlGetStock);
                            if ($STOCK->num_rows() > 0) {
                                $STOCK = $STOCK->row();
                                $STOCK = $STOCK->JUMLAH;
                            } else {
                                $STOCK = "";
                            }
                        } else {
                            $STOCK = $listData['STOCK_OPNAME'];
                        }
                    }
                }

                #KOLOM SELISIH
                $SELISIH = "";
                if ($listData['SELISIH'] == '') {
                    if ((is_array($STOCK) && empty($STOCK)) || strlen($STOCK) === 0) {
                        $SELISIH = "";
                    } else {
                        $SELISIH = ($STOCK - $SALDOAKHR) + $PENYESUAIAN;
                    }
                } else {
                    $SELISIH = $listData['SELISIH'];
                }

                if ($SELISIH) {
                    if (number_format($SELISIH, 2) == '-0.00') {
                        $SELISIH = 0;
                    }
                }

                if ($SALDOAKHR) {
                    if (number_format($SALDOAKHR, 2) == '-0.00') {
                        $SALDOAKHR = 0;
                    }
                }

                if ($SALDOAWL) {
                    if (number_format($SALDOAWL, 2) == '-0.00') {
                        $SALDOAWL = 0;
                    }
                }
                ?>
                <tr>
                    <td align="center"><?= $no; ?></td>
                    <td><?= $listData['KODE_BARANG']; ?><input type="hidden" name="KODE_BARANG_<?= $no; ?>" value="<?= $listData['KODE_BARANG']; ?>" /></td>
                    <td><?= $listData['URAIAN_BARANG']; ?><input type="hidden" name="JNS_BARANG_<?= $no; ?>" value="<?= $listData['JNS_BARANG']; ?>" /></td>
                    <td><?= $listData['KODE_SATUAN']; ?></td>
                    <td>
                        <input type="text" onblur="HitungMutasi('frmLaporan',<?= $no; ?>, 'mutasiBB');" name="JUMLAH_SALDO_AWAL_<?= $no; ?>" id="JUMLAH_SALDO_AWAL_<?= $no; ?>" class="stext date" value="<?= number_format($SALDOAWL, 2); ?>" onkeyup="this.value = ThausandSeperator('', this.value, 2);" style="width:100%;text-align:right"/>
                    </td>
                    <td>
                        <input type="text" onblur="HitungMutasi('frmLaporan',<?= $no; ?>, 'mutasiBB');" name="PEMASUKAN_<?= $no; ?>" id="PEMASUKAN_<?= $no; ?>" class="stext date" readonly value="<?= $MASUK ? number_format($MASUK, 2) : 0; ?>"  style="width:100%;text-align:right"/>
                    </td>
                    <td>
                        <input type="text" onblur="HitungMutasi('frmLaporan',<?= $no; ?>, 'mutasiBB');" name="PENGELUARAN_<?= $no; ?>" id="PENGELUARAN_<?= $no; ?>" class="stext date" readonly value="<?= $KELUAR ? number_format($KELUAR, 2) : 0; ?>" style="width:100%;text-align:right" />
                    </td>
                    <td>
                        <input type="text" onblur="HitungMutasi('frmLaporan',<?= $no; ?>, 'mutasiBB');" name="PENYESUAIAN_<?= $no; ?>" id="PENYESUAIAN_<?= $no; ?>" class="stext date" value="<?= number_format($PENYESUAIAN, 2); ?>"  style="width:100%;text-align:right"/>
                    </td>
                    <td>
                        <input type="text" onblur="HitungMutasi('frmLaporan',<?= $no; ?>, 'mutasiBB');" name="JUMLAH_SALDO_AKHIR_<?= $no; ?>" id="JUMLAH_SALDO_AKHIR_<?= $no; ?>" class="stext date" readonly value="<?= number_format($SALDOAKHR, 2); ?>"  style="width:100%;text-align:right"/>
                    </td>
                    <td>
                        <input type="text" onblur="HitungMutasi('frmLaporan',<?= $no; ?>, 'mutasiBB');" name="STOCKOPNAME_<?= $no; ?>" id="STOCKOPNAME_<?= $no; ?>" class="stext date" value="<?= $STOCK ? number_format($STOCK, 2) : ""; ?>" onkeyup="this.value = ThausandSeperator('', this.value, 2);" style="width:100%;text-align:right"/>
                    </td>
                    <td>
                        <input type="text" onblur="HitungMutasi('frmLaporan',<?= $no; ?>, 'mutasiBB');" name="SELISIH_<?= $no; ?>" id="SELISIH_<?= $no; ?>" class="stext date" readonly value="<?= number_format($SELISIH, 2); ?>" style="width:100%;text-align:right"/>
                    </td>
                    <td>
                        <input type="text" name="KETERANGAN_<?= $no; ?>" id="KETERANGAN_<?= $no; ?>" class="stext" value="<?= $listData['KETERANGAN'] ? $listData['KETERANGAN'] : getKeterangan($SELISIH) ?>" style="width:100%"/>
                    </td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="12" align="center">Nihil</td>
            </tr>
        <?php } ?>
    <?php
	if(!$showpage){
    if (!in_array($this->newsession->userdata('KODE_ROLE'), array('5', '6'))) {#ROLE BUKAN BC
        #$func = get_instance();
        #$func->load->model('menu_act');
        #if ($func->menu_act->akses('33') == "w") {
            ?>
                <tr>
                    <td colspan="12">
                <?php if ($dataRec == '0') {
                    $act = 'Save';
                } else {
                    $act = 'Update';
                } ?>
                        <a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="save_laporan('#frmLaporan', 'msgMutasiBB_', '<?= site_url() . "/laporan" . $addUrl; ?>');"><i class="icon-save"></i>&nbsp;<?= $act ?>&nbsp;</a>           
                        <span class="msgMutasiBB_" style="margin-left:20px">&nbsp;</span>

                    </td>
                </tr>
        <?php #}
    } }?>
     <?=$PAGING_BOT;?>
    </table>
<?php }elseif($tipe=="pemusnahan"){ ?>
    <div style="margin-bottom:5px";>
    <a href="javascript:void(0);" 
    onclick="print_('<?= site_url();?>/laporan/print_dok/<?= $tipe ?>/<?= $tglAwal;?>/<?= $tglAkhir;?>','<?= $nama;?>','<?= $kodebarang;?>');"><img src="<?= base_url();?>/img/pdf.png" width="16px" height="16px" title="cetak dokumen" />&nbsp;Cetak Dokumen</a></div>
    <table class="tabelPopUp" width="100%">
	<tr>
    	<th align="center">No</th>
        <th>Tanggal <?= ucwords(strtolower($tipe))?></th>
        <th>Kode Barang</th>
        <th>Uraian Barang</th>
        <th>Uraian Jenis</th>
        <th>Jumlah</th>
        <th>Uraian Satuan</th>
        <th>Keterangan</th>
    </tr>
    <?
    $banyakData=count($resultData);
	if($banyakData>0){
		$no=1;
		foreach($resultData as $listData){
	?>
    <tr>
    	<td align="center"><?= $no;?></td>
        <td><?= $listData['TGL'];?></td>
        <td><?= $listData['KDBARANG'];?></td>
        <td><?= $listData['URAIBARANG'];?></td>
        <td><?= $listData['URAIJENIS'];?></td>
        <td align="right"><?= $listData['JUMLAH'];?></td>
        <td><?= $listData['SATUAN'];?></td>
        <td><?= $listData['KETERANGAN'];?></td>
  	</tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="8" align="center">Nihil</td>
    </tr>
    <? }?>
</table>
<? }
elseif($tipe=="produksi"){?>
<div style="margin-bottom:5px";>
<a href="javascript:void(0);" 
onclick="print_('<?= base_url();?>index.php/laporan/print_dok/produksi/<?= $tglAwal;?>/<?= $tglAkhir;?>','<?= $nama;?>','<?= $kodebarang;?>','<?= $jenis;?>');"><img src="<?= base_url();?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;
		<a href="<?= site_url();?>/laporan/print_dok/produksi/<?=$tglAwal;?>/<?=$tglAkhir;?>/<?=$nama;?>/!/<?= $jenis;?>/<?=$ALL?$ALL:0;?>/excel"><img src="<?= base_url();?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;<strong>Cetak Excel</strong></a>
</div>
	
<table class="tabelPopUp" width="100%">
	<tr>
    	<th align="center">No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Jenis Barang</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Tanggal</th>
    </tr>
    <?
    $banyakData=count($resultData);
	if($banyakData>0){
		$no=1;
		foreach($resultData as $listData){
	?>
    <tr>
    	<td align="center" width="10px"><?= $no;?></td>
        <td><?= $listData['KODE_BARANG'];?></td>
        <td><?= $listData['URAIAN_BARANG'];?></td>
        <td><?= $listData['JNS_BARANG'];?></td>
        <td align="right"><?= $listData['JUMLAH'];?></td>
        <td><?= $listData['SATUAN'];?></td>
        <td><?= $listData['TANGGAL'];?></td>
  	</tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="6" align="center">Nihil</td>
    </tr>
    <? }?>
</table>
<? }
elseif($tipe=="inout"){
	$no=1;
if(count($resultData)>0){			
?>  
    <div style="margin-bottom:5px";>
   <a href="javascript:void(0);" 
onclick="print_('<?= base_url();?>index.php/laporan/print_dok/inout/<?= $tglAwal;?>/<?= $tglAkhir;?>','<?= $nama;?>','<?= $kodebarang;?>','<?= $jenis;?>','<?= $TIPE_TANGGAL;?>','');"><img src="<?= base_url();?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;<a href="<?= site_url();?>/laporan/print_dok/inout/<?=$tglAwal;?>/<?=$tglAkhir;?>/<?=$nama;?>/!/<?= $jenis;?>/<?=$TIPE_TANGGAL;?>/excel"><img src="<?= base_url();?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;<strong>Cetak Excel</strong></a>
    </div>
<? 	} ?>
<table class="tabelPopUp" width="100%" border="0">
	<thead>
	<tr>
    	<th rowspan="2" align="center">No</th>
        <th colspan="10">Dokumen <?=($jenis=="MASUK")?"Pemasukan":"Pengeluaran"?></th>
    </tr>    
    <tr>    
        <th>Jenis</th>
        <th>No. Dokumen</th>
        <th>Tgl. Dokumen</th>
        <th>Tgl. <?=ucwords(strtolower($jenis))?></th>
        <th>Kode Barang</th>
        <th>Seri Barang</th>
        <th>Nama Barang</th>
        <th>Satuan</th>
        <th>Jumlah</th>
        <th>Nilai Pabean</th>
    </tr>   
    </thead>
    <tbody>
    <? $banyakData=count($resultData);	
	   if($banyakData>0){
		$no=1; 	
		foreach($resultData as $rowmasuk){ 	
	?>
			<tr>    
				<td align="center"><?= $no;?></td>
				<td><?=$rowmasuk["JENIS_DOK"]?></td>
				<td><?=$rowmasuk["NO_DOK"]?></td>
				<td><?=$this->fungsi->dateFormat($rowmasuk["TGL_DOK"])?></td>
				<td><?=$this->fungsi->dateFormat($rowmasuk["TGL_MASUK"])?></td>
				<td><?=$rowmasuk["KODE_BARANG"]?></td>
				<td><?=$rowmasuk["SERI_BARANG"]?></td>
				<td><?=$rowmasuk["NAMA_BARANG"]?></td>
				<td><?=$rowmasuk["SATUAN"]?></td>
				<td align="right"><?=$this->fungsi->FormatRupiah($rowmasuk["JUMLAH"],2)?></td>
				<td align="right"><?=$this->fungsi->FormatRupiah($rowmasuk["NILAI_PABEAN"],2)?></td>
			</tr>    
    <? $no++; } ?>                  	 
    </tbody>
	<? }else{?>
    <tr>
    	<td colspan="23" align="center">Nihil</td>
    </tr>
    <? }?>
</table>
<? }
elseif($tipe=="posisiharian"){
	$no=1; 
if(count($resultData)>0){			
?>  
    <div style="margin-bottom:5px">
    <a href="javascript:void(0);" 
    onclick="print_('<?= base_url();?>index.php/laporan/print_dok/posisiharian/<?= $tglAwal;?>/<?= $tglAkhir;?>','<?= $nama;?>','<?= $kodebarang;?>','','<?=$ALL;?>');"><img src="<?= base_url();?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;
            <a href="<?= site_url();?>/laporan/print_dok/posisiharian/<?=$tglAwal;?>/<?=$tglAkhir;?>/<?=$nama;?>/<?= $kodebarang;?>/!/<?=$ALL?$ALL:0;?>/excel"><img src="<?= base_url();?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;<strong>Cetak Excel</strong></a>
    </div>
<? 	} ?>
<table class="tabelPopUp" width="100%" border="1">
	<thead>
	<tr>
    	<th rowspan="2" align="center">No</th>
        <th colspan="4"><?=$resultData[0]["JNS_DOK_MASUK"]?></th>
        <th colspan="4"><?=$resultData[0]["JNS_DOK_KELUAR"]?></th>
        <th colspan="3">Pengeluaran Harian</th>
        <th rowspan="2">Saldo</th>
    </tr>    
    <tr>    
        <th>No.Pendaftaran</th>
        <th>Tanggal</th>
        <th>Kode<br>Barang</th>
        <th>Jmlh</th>
        
        <th>No.Pendaftaran</th>
        <th>Tanggal</th>
        <th>Kode<br>Barang</th>
        <th>Jmlh</th>
        
        <th>Tanggal</th>
        <th>Kode<br>Barang</th>
        <th>Jmlh</th>
    </tr>   
    </thead>
    <tbody>
    <? $banyakData=count($resultData);	
	   if($banyakData>0){
			   $no=1;
		   foreach($resultData as $row){
			   $SQL ="SELECT A.NOMOR_AJU, B.TGL_REALISASI, C.KODE_BARANG, C.JUMLAH 
					   FROM T_".$row["JNS_DOK_KELUAR"]."_HDR A, T_REALISASI_PARSIAL_HDR B, T_REALISASI_PARSIAL_DTL C
					   WHERE A.NOMOR_AJU=B.NOMOR_AJU  AND B.REALISASIID=C.HDR_REFF
					   AND A.NOMOR_PENDAFTARAN='".$row["NO_DOK_KELUAR"]."' AND A.TANGGAL_PENDAFTARAN='".$row["TGL_DOK_KELUAR"]."'
					   AND A.KODE_TRADER='".$kodeTrader."' ORDER BY B.TGL_REALISASI "; 
				$rskeluar = $this->db->query($SQL);
				$banyakData = $rskeluar->num_rows();
				if($banyakData>0) $rowspan = 'rowspan="'.$banyakData.'"';
	?>    	
            <tr>    
                <td align="center" <?=$rowspan?>><?= $no;?></td>
                <td <?=$rowspan?>><?=$row["NO_DOK_MASUK"]?></td>
                <td <?=$rowspan?>><?=$row["TGL_DOK_MASUK"]?></td>
                <td <?=$rowspan?>><?=$row["KODE_BARANG_MASUK"]?></td>
                <td <?=$rowspan?>><?=$row["JUMLAH_MASUK"]?></td>
    
                <td <?=$rowspan?>><?=$row["NO_DOK_KELUAR"]?></td>
                <td <?=$rowspan?>><?=$row["TGL_DOK_KELUAR"]?></td>
                <td <?=$rowspan?>><?=$row["KODE_BARANG_KELUAR"]?></td>
                <td <?=$rowspan?>><?=$row["JUMLAH_KELUAR"]?></td>
    <?					
			
			if($rskeluar->num_rows()>0){								
				foreach($rskeluar->result_array() as $rowkeluar){
					$SALDO = $SALDO + $rowkeluar["JUMLAH"];
	?> 				
					<td><?=$rowkeluar["TGL_REALISASI"]?></td>
					<td><?=$rowkeluar["KODE_BARANG"]?></td>
					<td><?=$rowkeluar["JUMLAH"]?></td>
                    
					<td><?=$row["JUMLAH_KELUAR"]-$SALDO?></td>
                <tr>
    <?									
				}
			}else{
	?>			
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                <tr>
   <?             
			}
			$no++;
		   }
		}else{?>
    <tr>
    	<td colspan="23" align="center">Nihil</td>
    </tr>
    <? }?>
</table>
<? }elseif ($tipe == 'pemasukan' || $tipe == 'pengeluaran') {?>                
        <div style="margin-bottom:5px";>
            <?php if ($tipe == 'pemasukan') { ?>
                <a href="javascript:void(0);" onclick="printDok_('<?= base_url(); ?>index.php/laporan/print_dok/pemasukan/<?= $tglAwal; ?>/<?= $tglAkhir; ?>', '<?= $nama; ?>', '<?= $jenisdokumen; ?>', '<?= $dokumen; ?>', '<?= $halaman.'|'.$JUMPAGES; ?>','pdf');"><img src="<?= base_url(); ?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;
                <a href="<?= site_url(); ?>/laporan/print_dok/pemasukan/<?= $tglAwal; ?>/<?= $tglAkhir; ?>/<?= $nama; ?>/<?= $jenisdokumen ? $jenisdokumen : '!'; ?>/<?= $dokumen?$dokumen:'!'; ?>/1/<?= $halaman; ?>/<?= $JUMPAGES; ?>/xls"><img src="<?= base_url(); ?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;<strong>Cetak Excel</strong></a>
            <?php } elseif ($tipe == 'pengeluaran') { ?>
                <a href="javascript:void(0);" onclick="printDok_('<?= base_url(); ?>index.php/laporan/print_dok/pengeluaran/<?= $tglAwal; ?>/<?= $tglAkhir; ?>', '<?= $nama; ?>', '<?= $jenisdokumen; ?>', '<?= $dokumen ?>', '<?= $halaman.'|'.$JUMPAGES; ?>','pdf');"><img src="<?= base_url(); ?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;
                <a href="<?= site_url(); ?>/laporan/print_dok/pengeluaran/<?= $tglAwal; ?>/<?= $tglAkhir; ?>/<?= $nama; ?>/<?= $jenisdokumen ? $jenisdokumen : '!'; ?>/<?= $dokumen?$dokumen:'!'; ?>/1/<?= $halaman; ?>/<?= $JUMPAGES; ?>/xls"><img src="<?= base_url(); ?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;<strong>Cetak Excel</strong></a>
            <?php } ?>
        </div>          
    <table class="tabelPopUp" width="100%">
<?=$PAGING_TOP;?>
        <tr align="left">
            <th rowspan="2" align="center">No</th>
            <th rowspan="2">Jenis Dokumen</th>
            <th colspan="2">Dokumen Pabean</th>
            <?php if ($tipe == 'pemasukan') { ?>            
                <th colspan="2">Bukti/Dok. Penerimaan</th>
            <?php }if ($tipe == 'pengeluaran') { ?>
                <th colspan="2">Bukti/Dok. Pengeluaran</th>
            <?php }if ($tipe == 'pemasukan') { ?>            
                <th rowspan="2">Pemasok/Pengirim</th>
            <?php }if ($tipe == 'pengeluaran') { ?>
                <th rowspan="2">Pembeli/Penerima</th>
            <?php } ?>
            <th rowspan="2">Pemilik Barang</th>
            <th rowspan="2">Kode Barang</th>
            <th rowspan="2">Nama Barang</th>
            <th rowspan="2">Satuan</th>
            <th rowspan="2">Jumlah</th>
            <th rowspan="2">Nilai Barang</th>
			<th rowspan="2">Kondisi Barang</th>
        </tr>
        <tr align="center">
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Nomor</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
           // $no = 1;
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center"><?= $no; ?></td>
                    <td><?= $listData['JENIS_DOKUMEN']; ?></td>
                    <td><?= $listData['NOMOR_PENDAFTARAN']; ?></td>
                    <td><?= $this->fungsi->FormatDate($listData['TANGGAL_PENDAFTARAN']); ?></td>
                    <td><?= $listData['NOMOR_DOK_INTERNAL']; ?></td>
                    <td><?= $this->fungsi->FormatDate($listData['TANGGAL_DOK_INTERNAL']); ?></td>
                    <?php if ($tipe == 'pemasukan') { ?>
                        <td><?= $listData['PEMASOK/PENGIRIM']; ?></td>
                    <?php } elseif ($tipe == 'pengeluaran') { ?>
                        <td><?= $listData['PEMBELI/PENERIMA']; ?></td>
                    <?php } ?>
                    <td><?= $listData['NAMA_PEMILIK']; ?></td>
                    <td><?= $listData['KODE_BARANG']; ?></td>
                    <td><?= $listData['URAIAN_BARANG']; ?></td>
                    <td><?= $listData['KODE_SATUAN']; ?></td>
                    <td align="right"><?= number_format($listData['JUMLAH_SATUAN'], 2); ?></td>
                    <td align="right"><?= number_format($listData['NILAI'], 2); ?></td>
                    <td><?= $listData['KONDISI_BARANG']; ?></td>
                    <!--<td><?$listData['NOMOR_AJU'];?></td>-->
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center">Nihil</td>
            </tr>
    <?php } ?>
<?=$PAGING_BOT;?>
    </table>
<?php
}elseif ($tipe == 'pembelian') {?>
        <div style="margin-bottom:5px";>
			<a href="javascript:void(0);" onclick="printDok_('<?= base_url(); ?>index.php/laporan/print_dok/pembelian/<?= $tglAwal; ?>/<?= $tglAkhir; ?>', '<?= $nama; ?>', '', '<?= $dokumen; ?>', '<?= $halaman.'|'.$JUMPAGES; ?>','pdf');"><img src="<?= base_url(); ?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;
			<a href="<?= site_url(); ?>/laporan/print_dok/pembelian/<?= $tglAwal; ?>/<?= $tglAkhir; ?>/<?= $nama; ?>/<?= $jenisdokumen ? $jenisdokumen : '!'; ?>/<?= $dokumen?$dokumen:'!'; ?>/1/<?= $halaman; ?>/<?= $JUMPAGES; ?>/xls"><img src="<?= base_url(); ?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;<strong>Cetak Excel</strong></a>
        </div>          
    <table class="tabelPopUp" width="100%">
	<?=$PAGING_TOP;?>
        <tr align="left">
            <th rowspan="2" align="center">No</th>
            <th colspan="3">Jenis Dokumen</th>
            <th rowspan="2">Pemasok/ Pengirim Barang</th>
            <th rowspan="2">Nama Pemilik</th>
            <th rowspan="2">Kode Barang</th>
            <th rowspan="2">Nama Barang</th>
            <th rowspan="2">Satuan</th>
            <th rowspan="2">Jumlah</th>
			<th rowspan="2">Kode Harga</th>
			<th rowspan="2">Jenis Nilai</th>
			<th rowspan="2">Mata Uang</th>
			<th rowspan="2">Total Harga Barang</th>
        </tr>
        <tr align="center">
            <th>Dokumen</th>
            <th>Nomor</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center"><?= $no; ?></td>
                    <td><?= $listData['JENIS_DOKUMEN']; ?></td>
                    <td><?= $listData['NO_DOK']; ?></td>
                    <td><?= $this->fungsi->FormatDate($listData['TGL_DOK']); ?></td>
                    <td><?= $listData['NAMA_PENGIRIM']; ?></td>
                    <td><?= $listData['NAMA_PEMILIK']; ?></td>
					<td><?= $listData['KODE_BARANG']; ?></td>
					<td><?= $listData['URAIAN_BARANG']; ?></td>
                    <td><?= $listData['KODE_SATUAN']; ?></td>
                    <td><?= $listData['JUMLAH']; ?></td>
                    <td><?= $listData['KODE_HARGA']; ?></td>
                    <td><?= $listData['JENIS_NILAI']; ?></td>
                    <td><?= $listData['KODE_VALUTA']; ?></td>
                    <td align="right"><?= number_format($listData['NILAI'], 2); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center">Nihil</td>
            </tr>
    <?php } ?>
<?=$PAGING_BOT;?>
    </table>
<?php
}elseif ($tipe == 'penjualan') {?>
        <div style="margin-bottom:5px";>
			<a href="javascript:void(0);" onclick="printDok_('<?= base_url(); ?>index.php/laporan/print_dok/penjualan/<?= $tglAwal; ?>/<?= $tglAkhir; ?>', '<?= $nama; ?>', '', '<?= $dokumen; ?>', '<?= $halaman.'|'.$JUMPAGES; ?>','pdf');"><img src="<?= base_url(); ?>/img/tbl_pdf.png" width="16px" height="16px" title="cetak dokumen" align="absmiddle"/>&nbsp;<strong>Cetak PDF</strong></a>&nbsp;&nbsp;&nbsp;
			<a href="<?= site_url(); ?>/laporan/print_dok/penjualan/<?= $tglAwal; ?>/<?= $tglAkhir; ?>/<?= $nama; ?>/<?= $jenisdokumen ? $jenisdokumen : '!'; ?>/<?= $dokumen?$dokumen:'!'; ?>/1/<?= $halaman; ?>/<?= $JUMPAGES; ?>/xls"><img src="<?= base_url(); ?>/img/tbl_xls.png" width="16px" height="16px" title="cetak dokumen"  align="absmiddle"/>&nbsp;<strong>Cetak Excel</strong></a>
        </div>          
    <table class="tabelPopUp" width="100%">
	<?=$PAGING_TOP;?>
        <tr align="left">
            <th rowspan="2" align="center">No</th>
            <th colspan="3">Jenis Dokumen</th>
            <th rowspan="2">Pembeli/Penerima Barang</th>
            <th rowspan="2">Nama Pemilik</th>
            <th rowspan="2">Kode Barang</th>
            <th rowspan="2">Nama Barang</th>
            <th rowspan="2">Satuan</th>
            <th rowspan="2">Jumlah</th>
			<th rowspan="2">Kode Harga</th>
			<th rowspan="2">Jenis Nilai</th>
			<th rowspan="2">Mata Uang</th>
			<th rowspan="2">Total Harga Barang</th>
        </tr>
        <tr align="center">
            <th>Dokumen</th>
            <th>Nomor</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $banyakData = count($resultData);
        if ($banyakData > 0) {
            foreach ($resultData as $listData) {
                ?>
                <tr>
                    <td align="center"><?= $no; ?></td>
                    <td><?= $listData['JENIS_DOKUMEN']; ?></td>
                    <td><?= $listData['NO_DOK']; ?></td>
                    <td><?= $this->fungsi->FormatDate($listData['TGL_DOK']); ?></td>
                    <td><?= $listData['NAMA_PENGUSAHA']; ?></td>
                    <td><?= $listData['NAMA_PEMILIK']; ?></td>
					<td><?= $listData['KODE_BARANG']; ?></td>
					<td><?= $listData['URAIAN_BARANG']; ?></td>
                    <td><?= $listData['KODE_SATUAN']; ?></td>
                    <td><?= $listData['JUMLAH']; ?></td>
                    <td><?= $listData['NILAI']; ?></td>
                    <td><?= $listData['JENIS_NILAI']; ?></td>
                    <td><?= $listData['KODE_VALUTA']; ?></td>
                    <td align="right"><?= number_format($listData['CIF'], 2); ?></td>
                </tr>
                <?php $no++;
            }
        } else { ?>
            <tr>
                <td colspan="13" align="center">Nihil</td>
            </tr>
    <?php } ?>
<?=$PAGING_BOT;?>
    </table>
<?php
}?>