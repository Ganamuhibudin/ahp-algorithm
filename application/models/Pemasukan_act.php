<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Pemasukan_act extends CI_Model 
{
	function list_pengadaan($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        $id_role = $this->newsession->userdata('id_role');
        if ($tipe) {
            $title = "List Data Pemasukan";
            if ($id_role == '1') {
                $prosesnya = array(
                    'Approve' => array('PROCESS', site_url()."/pemasukan/approve/pengadaan", '1','green icon-check'),
                    'To Draft' => array('PROCESS', site_url()."/pemasukan/toDraft/pengadaan", '1','red icon-refresh'),
                );
            } else {
                $prosesnya = array(
                    'Tambah' => array('GET',site_url().'/pemasukan/add/pengadaan', '0','icon-plus'),
                    'Ubah'   => array('EDITJS', site_url().'/pemasukan/edit/pengadaan', 'pengadaan','icon-edit'),
                    'Hapus'  => array('DELETE', site_url().'/pemasukan/delete/pengadaan', 'pengadaan','red icon-remove'
                ));
            }
            
            $SQL = "SELECT id_pemasukan, nomor_pengadaan 'Nomor Pengadaan', tanggal 'Tanggal', nomor_invoice 'Nomor Invoice',
            		vendor 'Nama Vendor',
                    IF(status='0', '<span class=\"label label-warning\">Waiting Approval</span>', '<span class=\"label label-primary\">Approved</span>') AS 'Status', status 'status_hide'
            		FROM tbl_pemasukan";
            $this->newtable->search(array(
                array('nomor_pengadaan', 'Nomor Pengadaan'),
                array('nomor_invoice', 'Nomor Invoice'),
                array('vendor', 'Nama Vendor'),
                array('status', 'Status', 'tag-select', array("0" => "Waiting Approval", "1" => "Approved"))
            ));
            $this->newtable->action(site_url() . "/pemasukan/pengadaan/list");
            $this->newtable->hiddens(array('id_pemasukan','status_hide'));
            $this->newtable->keys(array('id_pemasukan', 'status_hide'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("fpengadaan");
            $this->newtable->set_divid("divpengadaan");
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "tipe" => "pengadaan"
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

    function proses_form($tipe) {
        $conn = get_instance();
        $conn->load->model("main");
        $id_user = $this->newsession->userdata('id_user');
        if ($tipe == "pengadaan") {
            $act = $this->input->post('act');
            $id = $this->input->post('id_pemasukan');
            foreach ($this->input->post('data') as $a => $b){
                $pemasukan[$a] = $b;
            }
            $details = $this->input->post('detail');
            if ($act == "save") {
                # validasi nomor pengadaan
                $sql = "SELECT id_pemasukan FROM tbl_pemasukan WHERE nomor_pengadaan = '" . $pemasukan['nomor_pengadaan'] . "'";
                $doCheck = $this->db->query($sql);
                if ($doCheck->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Nomor Pengadaan sudah ada.";
                } else {
                    # insert pemasukan into tbl_pemasukan
                    $pemasukan['created_by'] = $id_user;
                    $pemasukan['created_at'] = date('Y-m-d H:i:s');
                    $exec = $this->db->insert('tbl_pemasukan', $pemasukan);
                    $id_pemasukan = $this->db->insert_id();
                    if ($exec) {
                        # insert detail into tbl_pemasukan_detail
                        for ($i=0; $i < count($details['id_barang']); $i++) { 
                            $detail['id_pemasukan'] = $id_pemasukan;
                            $detail['id_barang'] = $details['id_barang'][$i];
                            $detail['jumlah'] = $details['jumlah'][$i];
                            $this->db->insert('tbl_pemasukan_detail', $detail);
                        }
                        $conn->main->activity_log('ADD PEMASUKAN', $pemasukan['nomor_pengadaan']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/pemasukan/pengadaan/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal.";
                    }
                }
            } elseif ($act == "update") {
                # validasi nomor pengadaan
                $sql = "SELECT id_pemasukan FROM tbl_pemasukan WHERE nomor_pengadaan = '" . $pemasukan['nomor_pengadaan'] . "'
                        AND id_pemasukan <> '".$id."'";
                $doCheck = $this->db->query($sql);
                if ($doCheck->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Nomor Pengadaan sudah ada.";
                } else {
                    # insert pemasukan into tbl_pemasukan
                    $pemasukan['updated_at'] = date('Y-m-d H:i:s');
                    $this->db->where(array('id_pemasukan' => $id));
                    $exec = $this->db->update('tbl_pemasukan', $pemasukan);
                    if ($exec) {
                        # dekete then insert detail into tbl_pemasukan_detail
                        $this->db->where(array('id_pemasukan' => $id));
                        $this->db->delete('tbl_pemasukan_detail');
                        for ($i=0; $i < count($details['id_barang']); $i++) { 
                            $detail['id_pemasukan'] = $id;
                            $detail['id_barang'] = $details['id_barang'][$i];
                            $detail['jumlah'] = $details['jumlah'][$i];
                            $this->db->insert('tbl_pemasukan_detail', $detail);
                        }
                        $conn->main->activity_log('EDIT PEMASUKAN', $pemasukan['nomor_pengadaan']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/pemasukan/pengadaan/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal.";
                    }
                }
            } else {
                $response = "MSG#ERR#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfpengadaan');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $id = $arrchk[0];
                    $status = $arrchk[1];
                    // echo $status; die();
                    if ($status != '0') {
                        $response = "MSG#ERR#Maaf, Data yang bisa dihapus hanya yang berstatus Waiting Approval.\nPeriksa kembali data pilihan anda";
                    } else {
                        $pengadaan = $this->getData($tipe, $id);
                        # delete data from tbl_pemasukan
                        $this->db->where(array('id_pemasukan' => $id));
                        $this->db->delete('tbl_pemasukan');
                        # delete data from tbl_pemasukan_detail
                        $this->db->where(array('id_pemasukan' => $id));
                        $this->db->delete('tbl_pemasukan_detail');

                        $conn->main->activity_log('DELETE DIVISI', 'NOMOR PENGADAAN=' . $pengadaan['nomor_pengadaan']);
                        $response = "MSG#OK#Hapus data Berhasil#" . site_url() . "/pemasukan/pengadaan/list/ajax";
                    }
                }
                return $response;
            }
        } elseif ($tipe == "approve_pengadaan") {
            $response = "MSG#ERR#Approve data gagal";
            $dataCheck = $this->input->post('tb_chkfpengadaan');
            foreach ($dataCheck as $chkitem) {
                $expKey = explode("|", $chkitem);
                $id_pemasukan = $expKey[0];
                $status = $expKey[1];
                if ($status == "0") {
                    $sqlGet = "SELECT a.*, b.nomor_pengadaan FROM tbl_pemasukan_detail a
                              LEFT JOIN tbl_pemasukan b ON b.id_pemasukan = a.id_pemasukan
                              WHERE a.id_pemasukan = '" . $id_pemasukan . "'";
                    $objPengadaan = $this->db->query($sqlGet)->result_array();
                    foreach ($objPengadaan as $pengadaan) {
                        # insert data inout into table tbl_inout
                        $inout['id_header']       = $pengadaan['id_pemasukan'];
                        $inout['id_detail']       = $pengadaan['id_pemasukan_detail'];
                        $inout['nomor_transaksi'] = $pengadaan['nomor_pengadaan'];
                        $inout['tipe']            = "PENGADAAN";
                        $inout['id_barang']       = $pengadaan['id_barang'];
                        $inout['jumlah']          = $pengadaan['jumlah'];
                        $inout['created_at']      = date('Y-m-d H:i:s');
                        $exec = $this->db->insert('tbl_inout', $inout);
                        if ($exec) {
                            # update stock tbl_barang
                            $this->db->where('id_barang', $pengadaan['id_barang']);
                            $this->db->set('stock', 'stock+'.(float)$pengadaan['jumlah'], FALSE);
                            $this->db->update('tbl_barang');
                            $response = "MSG#OK#Approve data Berhasil#".site_url()."/pemasukan/pengadaan/list/ajax";
                        }
                    }
                    # update status tbl_pemasukan
                    $this->db->where('id_pemasukan', $id_pemasukan);
                    $this->db->update('tbl_pemasukan', array('status' => '1'));
                    # write log
                    $conn->main->activity_log('APPROVE PEMASUKAN', $pengadaan['nomor_pengadaan']);
                    return $response;
                } else {
                    $response = "MSG#ERR#Approve data gagal. Data yang dapat di Approve hanya yang berstatus Waiting Approval";
                    return $response;
                }
            }
        } elseif ($tipe == "todraft") {
            $response = "MSG#ERR#Draft data gagal";
            $dataCheck = $this->input->post('tb_chkfpengadaan');
            foreach ($dataCheck as $chkitem) {
                $expKey = explode("|", $chkitem);
                $id_pemasukan = $expKey[0];
                $status = $expKey[1];
                if ($status == "1") {
                    $sqlGet = "SELECT a.*, b.nomor_pengadaan FROM tbl_pemasukan_detail a
                              LEFT JOIN tbl_pemasukan b ON b.id_pemasukan = a.id_pemasukan
                              WHERE a.id_pemasukan = '" . $id_pemasukan . "'";
                    $objPengadaan = $this->db->query($sqlGet)->result_array();
                    foreach ($objPengadaan as $pengadaan) {
                        # delete data from table tbl_inout
                        $this->db->where('id_header', $id_pemasukan);
                        $delete = $this->db->delete('tbl_inout');
                        if ($delete) {
                            # update stock tbl_barang
                            $this->db->where('id_barang', $pengadaan['id_barang']);
                            $this->db->set('stock', 'stock-'.(float)$pengadaan['jumlah'], FALSE);
                            $this->db->update('tbl_barang');
                            $response = "MSG#OK#Proses data Berhasil#".site_url()."/pemasukan/pengadaan/list/ajax";
                        }
                    }
                    # update status tbl_pemasukan
                    $this->db->where('id_pemasukan', $id_pemasukan);
                    $this->db->update('tbl_pemasukan', array('status' => '0'));
                    # write log
                    $conn->main->activity_log('TO DRAFT PEMASUKAN', $pengadaan['nomor_pengadaan']);
                    return $response;
                } else {
                    $response = "MSG#ERR#To Draft data gagal. Data yang dapat diubah ke draft hanya yang berstatus Approved";
                    return $response;
                }
            }
        }
    }

    function getData($tipe, $id) {
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
        } elseif ($tipe == "pengadaan_detail") {
            $query = "SELECT a.*, b.kode_barang, c.jenis_barang, b.nama_barang, b.uraian, b.satuan
                     FROM tbl_pemasukan_detail a
                     LEFT JOIN tbl_barang b ON b.id_barang = a.id_barang
                     LEFT JOIN tbl_jenis_barang c ON c.id_jenis_barang = b.jenis_barang
                     WHERE a.id_pemasukan = '" . $id . "'";
            $hasil = $conn->main->get_result($query);
            if ($hasil) {
                $dataarray = $query->result_array();
            }
        }
        
        return $dataarray;
    }
}