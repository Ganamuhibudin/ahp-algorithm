<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Qualitycontrol_act extends CI_Model 
{
	function list_nilai($tipe = "", $ajax = "") {
		$this->load->library('newtable');
        $id_role = $this->newsession->userdata('id_role');
        if ($tipe) {
            $title = "Nilai Maksimal kriteria";
            $prosesnya = array(
                'Ubah'   => array('DIALOG', site_url().'/qualitycontrol/edit/nilai_max', '1','green icon-edit', '400,200'),
            );
            
            $SQL = "SELECT id,
            		CASE id
            			WHEN 'k1' THEN 'Kesesuaian Produk'
            			WHEN 'k2' THEN 'Harga'
            			WHEN 'k3' THEN 'Fungsi Produk'
            			WHEN 'k4' THEN 'Kesesuaian Jumlah'
            			WHEN 'k5' THEN 'Kesesuaian Bahan'
            			ELSE NULL
            		END AS 'Nama Kriteria', nilai_max 'Nilai Max'
            		FROM tbl_nilai_max_kriteria";
            $this->newtable->action(site_url() . "/qualitycontrol/nilai/list");
            $this->newtable->hiddens(array('id'));
            $this->newtable->keys(array('id'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("ASC");
            $this->newtable->set_formid("fnilai");
            $this->newtable->set_divid("divnilai");
            $this->newtable->rowcount(10);
            $this->newtable->show_search(false);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "tipe" => "nilai"
            );
            if ($this->input->post("ajax")||$ajax=="ajax"){
                return $tabel;
            } else {
                return $arrdata;
            }
        } else {
            redirect(base_url());
            exit();
        }
	}

    function list_qc($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        $id_role = $this->newsession->userdata('id_role');
        if ($tipe) {
            $title = "List Data QC";
            $prosesnya = array(
                'QC Barang' => array('EDITJS',site_url().'/qualitycontrol/edit/qc_barang', '1','green icon-check'),
                'Lihat Nilai'   => array('EDITJS', site_url().'/qualitycontrol/edit/show_qc_barang', '1','icon-eye-open'),
                // 'Cetak'  => array('DELETE', site_url().'/master/delete/divisi', 'divisi','red icon-print')
            );
            $SQL = "SELECT id_pemasukan, nomor_pengadaan AS 'Nomor Pengadaan', tanggal AS 'Tanggal',
                    IF(status_qc = '0', 'Belum di QC', 'Sudah di QC') AS 'Status'
                    FROM tbl_pemasukan";
            $this->newtable->search(array(
                array('divisi', 'Nama Divisi')
            ));
            $this->newtable->action(site_url() . "/qualitycontrol/qc/list");
            $this->newtable->hiddens(array('id_pemasukan'));
            $this->newtable->keys(array('id_pemasukan'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("fqc");
            $this->newtable->set_divid("divqc");
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "jenis" => $jenis,
                "tipe" => "divisi"
            );
            if ($this->input->post("ajax")||$ajax=="ajax"){
                return $tabel;
            } else {
                return $arrdata;
            }
        } else {
            redirect(base_url());
            exit();
        }
    }

	function getData($tipe, $id="") {
        $conn = get_instance();
        $conn->load->model("main");
        if ($tipe == "pengadaan") {
            $query = "SELECT * FROM tbl_pemasukan WHERE id_pemasukan = '" . $id . "'";
            $hasil = $conn->main->get_result($query);
            if ($hasil) {
                foreach ($query->result_array() as $row) {
                    $dataarray = $row;
                }
            }
        } elseif ($tipe == "nilai" || $tipe == "kriteria" || $tipe == "pemasukan_detail" || $tipe == "nilai_max" || $tipe == "eigen_vector") {
        	if ($tipe == "nilai") {
        		$query = "SELECT id, CONCAT(id, ' - ', nilai) AS nilai FROM tbl_nilai_kriteria";
        	} elseif ($tipe == "kriteria") {
        		$query = "SELECT id, k1, k2, k3, k4, k5 FROM tbl_kriteria";
        	} elseif ($tipe == "pemasukan_detail") {
                $query = "SELECT a.*, b.kode_barang, b.nama_barang, c.jenis_barang FROM tbl_pemasukan_detail a
                        LEFT JOIN tbl_barang b ON b.id_barang = a.id_barang
                        LEFT JOIN tbl_jenis_barang c ON c.id_jenis_barang = b.jenis_barang
                        WHERE a.id_pemasukan = '" . $id . "'";
            } elseif ($tipe == "nilai_max") {
                $query = "SELECT id, nilai_max FROM tbl_nilai_max_kriteria";
            } elseif ($tipe == "eigen_vector") {
                $query = "SELECT id, eigen_vector FROM tbl_kriteria";
            }
            
            $hasil = $conn->main->get_result($query);
            if ($hasil) {
                $dataarray = $query->result_array();
            }
        }
        
        return $dataarray;
    }

    function proses_form($tipe) {
    	$conn = get_instance();
        $conn->load->model("main");
        $id_user = $this->newsession->userdata('id_user');
        $nama = $this->newsession->userdata('nama');
        if ($tipe == "pembobotan") {
        	$nilai = $this->input->post('nilai');
        	for ($i=0; $i < count($nilai); $i++) { 
        		if ($i == 0 || $i == 1 || $i == 2 || $i == 3) {
        			$k1[] = $nilai[$i];
        		}
        		if ($i == 4 || $i == 5 || $i == 6) {
        			$k2[] = $nilai[$i];
        		}
        		if ($i == 7 || $i == 8) {
        			$k3[] = $nilai[$i];
        		}
        		if ($i == 9) {
        			$k4[] = $nilai[$i];
        		}
        	}
        	# update nilai kriteria k1
        	$valK1['k2'] = $k1[0];
        	$valK1['k3'] = $k1[1];
        	$valK1['k4'] = $k1[2];
        	$valK1['k5'] = $k1[3];
        	$valK1['id_user'] = $id_user;
        	$valK1['updated_at'] = date('Y-m-d H:i:s');
        	$this->db->where('id', 'k1');
        	$this->db->update('tbl_kriteria', $valK1);
        	# update nilai kriteria k2
        	$valK2['k1'] = round(1/$valK1['k2'], 4);
        	$valK2['k3'] = $k2[0];
        	$valK2['k4'] = $k2[1];
        	$valK2['k5'] = $k2[2];
        	$valK2['id_user'] = $id_user;
        	$valK2['updated_at'] = date('Y-m-d H:i:s');
        	$this->db->where('id', 'k2');
        	$this->db->update('tbl_kriteria', $valK2);
        	# update nilai kriteria k3
        	$valK3['k1'] = round(1/$valK1['k3'], 4);
        	$valK3['k2'] = round(1/$valK2['k3'], 4);
        	$valK3['k4'] = $k3[0];
        	$valK3['k5'] = $k3[1];
        	$valK3['id_user'] = $id_user;
        	$valK3['updated_at'] = date('Y-m-d H:i:s');
        	$this->db->where('id', 'k3');
        	$this->db->update('tbl_kriteria', $valK3);
        	# update nilai kriteria k4
        	$valK4['k1'] = round(1/$valK1['k4'], 4);
        	$valK4['k2'] = round(1/$valK2['k4'], 4);
        	$valK4['k3'] = round(1/$valK3['k4'], 4);
        	$valK4['k5'] = $k4[0];
        	$valK4['id_user'] = $id_user;
        	$valK4['updated_at'] = date('Y-m-d H:i:s');
        	$this->db->where('id', 'k4');
        	$this->db->update('tbl_kriteria', $valK4);
        	# update nilai kriteria k5
        	$valK5['k1'] = round(1/$valK1['k5'], 4);
        	$valK5['k2'] = round(1/$valK2['k5'], 4);
        	$valK5['k3'] = round(1/$valK3['k5'], 4);
        	$valK5['k4'] = round(1/$valK4['k5'], 4);
        	$valK5['id_user'] = $id_user;
        	$valK5['updated_at'] = date('Y-m-d H:i:s');
        	$this->db->where('id', 'k5');
        	$this->db->update('tbl_kriteria', $valK5);

            # hitung eigen vector
            $hitung = $this->hitungEigenVector();

        	$conn->main->activity_log('UPDATE NILAI KRITERIA', $nama);
        	$response = "MSG#OK#Update data berhasil";
        	return $response;
        } elseif ($tipe == "update_nilai") {
        	$id = $this->input->post('id');
        	$nilai_max = $this->input->post('nilai_max');
            # update tbl_kriteria
            $data['nilai_max'] = $nilai_max;
            $this->db->where('id', $id);
            $update = $this->db->update('tbl_nilai_max_kriteria', $data);
            if ($update) {
                # write log
                $conn->main->activity_log('UPDATE NILAI MAKSIMAL', $id);
                $response = "MSG#OK#Proses data Berhasil#".site_url()."/qualitycontrol/nilai/list/ajax";
                return $response;
            }
        } elseif ($tipe == "qc_barang") {
            # data post
            $id_pemasukan = $this->input->post('id_pemasukan');
            $nomor_pengadaan = $this->input->post('nomor_pengadaan');
            $qc = $this->input->post('qc');

            # get data nilai max
            $nilai_max = $this->getData('nilai_max');
            $max = array();
            foreach ($nilai_max as $nm) {
                $max[$nm['id']] = $nm['nilai_max'];
            }

            # get data eigen vector
            $eigen_vector = $this->getData('eigen_vector');
            $ev = array();
            foreach ($eigen_vector as $valEv) {
                $ev[$valEv['id']] = $valEv['eigen_vector'];
            }
            
            # hitung nilai qc barang
            for ($i=0; $i < count($qc['id_pemasukan_detail']); $i++) { 
                $id_pemasukan_detail = $qc['id_pemasukan_detail'][$i];
                $nilai_k1 = $qc['nilai_k1'][$i];
                $nilai_k2 = $qc['nilai_k2'][$i];
                $nilai_k3 = $qc['nilai_k3'][$i];
                $nilai_k4 = $qc['nilai_k4'][$i];
                $nilai_k5 = $qc['nilai_k5'][$i];

                $nilai_qc = round((($nilai_k1/$max['k1']) * $ev['k1']) + (($nilai_k2/$max['k2']) * $ev['k2']) + (($nilai_k3/$max['k3']) * $ev['k3']) + (($nilai_k4/$max['k4']) * $ev['k4']) + (($nilai_k5/$max['k5']) * $ev['k5']), 2);
                
                # update nilai qc tbl_pemasukan_detail
                $data = [
                    'nilai_k1' => $nilai_k1,
                    'nilai_k2' => $nilai_k2,
                    'nilai_k3' => $nilai_k3,
                    'nilai_k4' => $nilai_k4,
                    'nilai_k5' => $nilai_k5,
                    'nilai_qc' => $nilai_qc
                ];
                $this->db->where('id_pemasukan_detail', $id_pemasukan_detail);
                $this->db->update('tbl_pemasukan_detail', $data);
            }
            
            # update qc status tbl_pemasukan
            $this->db->where('id_pemasukan', $id_pemasukan);
            $this->db->update('tbl_pemasukan', array(
                'status_qc' => '1',
                'qc_at' => date('Y-m-d H:i:s')
            ));

            # write log
            $conn->main->activity_log('QC BARANG', 'NOMOR PENGADAAN = ' . $nomor_pengadaan);
            $response = "MSG#OK#QC Barang Berhasil#".site_url()."/qualitycontrol/qc/list#";
            return $response;
        }
    }

    function hitungEigenVector() {
        # create matriks
        $sqlGetMatrix = "SELECT * FROM tbl_kriteria";
        $objMatrix = $this->db->query($sqlGetMatrix);
        $i = 0;
        $matriks = array();
        foreach ($objMatrix->result_array() as $value) {
            $matriks[$i][0] = $value['k1'];
            $matriks[$i][1] = $value['k2'];
            $matriks[$i][2] = $value['k3'];
            $matriks[$i][3] = $value['k4'];
            $matriks[$i][4] = $value['k5'];
            $i++;
        }

        # hitung eigen vector
        $status = false;
        $ev = array();
        $evPrev = array();
        while ($status == false) {
            # hitung kuadrat matriks
            $hasil = $this->kuadratMatriks($matriks);

            # hitung eigen vector
            $ev[0] = round(($hasil['kuadratMatriks'][0][0] + $hasil['kuadratMatriks'][0][1] + $hasil['kuadratMatriks'][0][2] + $hasil['kuadratMatriks'][0][3] + $hasil['kuadratMatriks'][0][4]) / $hasil['totalkuadratmatriks'], 4);
            $ev[1] = round(($hasil['kuadratMatriks'][1][0] + $hasil['kuadratMatriks'][1][1] + $hasil['kuadratMatriks'][1][2] + $hasil['kuadratMatriks'][1][3] + $hasil['kuadratMatriks'][1][4]) / $hasil['totalkuadratmatriks'], 4);
            $ev[2] = round(($hasil['kuadratMatriks'][2][0] + $hasil['kuadratMatriks'][2][1] + $hasil['kuadratMatriks'][2][2] + $hasil['kuadratMatriks'][2][3] + $hasil['kuadratMatriks'][2][4]) / $hasil['totalkuadratmatriks'], 4);
            $ev[3] = round(($hasil['kuadratMatriks'][3][0] + $hasil['kuadratMatriks'][3][1] + $hasil['kuadratMatriks'][3][2] + $hasil['kuadratMatriks'][3][3] + $hasil['kuadratMatriks'][3][4]) / $hasil['totalkuadratmatriks'], 4);
            $ev[4] = round(($hasil['kuadratMatriks'][4][0] + $hasil['kuadratMatriks'][4][1] + $hasil['kuadratMatriks'][4][2] + $hasil['kuadratMatriks'][4][3] + $hasil['kuadratMatriks'][4][4]) / $hasil['totalkuadratmatriks'], 4);

            # ulangi langkah perhitungan eigen vector hingga eigen vector yang terakhir dihitung sama dengan eigen vector sebelumnya
            if($evPrev[0]==$ev[0] && $evPrev[1]==$ev[1] && $evPrev[2]==$ev[2] && $evPrev[3]==$ev[3] && $evPrev[4]==$ev[4]) {
                $status = true;
            } else {
                $evPrev[0] = $ev[0];
                $evPrev[1] = $ev[1];
                $evPrev[2] = $ev[2];
                $evPrev[3] = $ev[3];
                $evPrev[4] = $ev[4];
                $matriks = $hasil['kuadratMatriks'];
            }
        }

        # update nilai eigen vector pada tbl_kriteria
        $this->db->where('id', 'k1');
        $this->db->update('tbl_kriteria', array('eigen_vector' => $ev[0]));
        $this->db->where('id', 'k2');
        $this->db->update('tbl_kriteria', array('eigen_vector' => $ev[1]));
        $this->db->where('id', 'k3');
        $this->db->update('tbl_kriteria', array('eigen_vector' => $ev[2]));
        $this->db->where('id', 'k4');
        $this->db->update('tbl_kriteria', array('eigen_vector' => $ev[3]));
        $this->db->where('id', 'k5');
        $this->db->update('tbl_kriteria', array('eigen_vector' => $ev[4]));

        return $ev;
    }

    function kuadratMatriks($matriks) {
        $kuadratMatriks = array();
        $totalkuadratmatriks = 0;
        for ($i=0; $i < 5; $i++) { 
            for ($j=0; $j < 5; $j++) { 
                $kuadratMatriks[$i][$j] = round(($matriks[0][$j] * $matriks[$i][0]) + ($matriks[1][$j] * $matriks[$i][1]) + ($matriks[2][$j] * $matriks[$i][2]) + ($matriks[3][$j] * $matriks[$i][3]) + ($matriks[4][$j] * $matriks[$i][4]), 4);
                $totalkuadratmatriks = $totalkuadratmatriks + $kuadratMatriks[$i][$j];
            }
        }

        $return = array(
            'kuadratMatriks'     => $kuadratMatriks,
            'totalkuadratmatriks' => $totalkuadratmatriks
        );
        return $return;
    }
}