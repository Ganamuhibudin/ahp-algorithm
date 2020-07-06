<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Pengeluaran_act extends CI_Model 
{
	function list_distribusi($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        $id_role = $this->newsession->userdata('id_role');
        $id_divisi = $this->newsession->userdata('id_divisi');
        if ($tipe) {
            $title = "Daftar Permohonan Marketing Tools";
            if ($id_role == '2') {
                $prosesnya = array(
                    'Approve' => array('EDITJS', site_url()."/pengeluaran/review/distribusi", 'approve','green icon-check'),
                    'Delivery' => array('DIALOG', site_url()."/pengeluaran/delivery", '1','fa fa-shopping-cart', '400,200'),
                    'Reject' => array('PROCESS', site_url()."/pengeluaran/reject/distribusi", '1','red fa fa-times-circle'),
                );
            } elseif ($id_role == '3') {
                $prosesnya = array(
                    'Ubah'   => array('EDITJS', site_url().'/pengeluaran/edit/distribusi', 'distribusi','icon-edit'),
                    'Approve' => array('PROCESS', site_url()."/pengeluaran/approve/distribusi/divisi", '1','green icon-check'),
                    'To Draft' => array('PROCESS', site_url()."/pengeluaran/toDraft/distribusi/divisi", '1','red icon-refresh'),
                );
            } elseif ($id_role == '4') {
                $prosesnya = array(
                    'Tambah' => array('GET',site_url().'/pengeluaran/add/distribusi', '0','icon-plus'),
                    'Ubah'   => array('EDITJS', site_url().'/pengeluaran/edit/distribusi', 'distribusi','icon-edit'),
                    'Hapus'  => array('DELETE', site_url().'/pengeluaran/delete/distribusi', 'distribusi','red icon-remove'
                ));
            }
            if ($id_role == '1' || $id_role == '2') {
                $where = " AND status IN('1','2','3','4') ";
            } else {
                $where = " AND a.id_divisi = '" . $id_divisi . "' ";
            }
            $SQL = "SELECT a.id_pengeluaran, b.divisi 'Divisi', a.nomor_transaksi 'Nomor Permohonan', a.tanggal 'Tanggal Permohonan', 
                    a.tanggal_serah_terima 'Tanggal Serah Terima', a.keterangan 'Keperluan',
                    CASE a.status
                        WHEN '0'
                            THEN '<span class=\"label label-warning\">Waiting Approval</span>'
                        WHEN '1'
                            THEN '<span class=\"label label-primary\">Approved By Sales</span>'
                        WHEN '2'
                            THEN '<span class=\"label label-success\">Approved By Marketing</span>'
                        WHEN '3'
                            THEN '<span class=\"label label-info\">Delivered</span>'
                        WHEN '4'
                            THEN '<span class=\"label label-danger\">Rejected</span>'
                        ELSE NULL
                    END AS 'Status', a.status 'status_hide'
            		FROM tbl_pengeluaran a
                    LEFT JOIN tbl_divisi b ON a.id_divisi = b.id_divisi
                    WHERE a.tipe = 'DISTRIBUSI' " . $where;
            // echo $SQL; die();
            $this->newtable->search(array(
                array('nomor_transaksi', 'Nomor Permohonan'),
                array('divisi', 'Divisi'),
                array('status', 'Status', 'tag-select', 
                    array(
                        "0" => "Waiting Approval", 
                        "1" => "Approved By Sales",
                        "2" => "Approved By Marketing",
                        "3" => "Delivered",
                        "4" => "Rejected",
                ))
            ));
            $this->newtable->action(site_url() . "/pengeluaran/distribusi/list");
            $this->newtable->hiddens(array('id_pengeluaran','status_hide'));
            $this->newtable->keys(array('id_pengeluaran', 'status_hide'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("fdistribusi");
            $this->newtable->set_divid("divdistribusi");
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "tipe" => "distribusi"
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

    function list_retur($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        $id_role = $this->newsession->userdata('id_role');
        $id_divisi = $this->newsession->userdata('id_divisi');
        if ($tipe) {
            $title = "Daftar Retur Barang";
            if ($id_role == '1') {
                $prosesnya = array(
                    'Ubah'   => array('EDITJS', site_url().'/pengeluaran/edit/retur', 'retur','icon-edit'),
                    'Approve' => array('PROCESS', site_url()."/pengeluaran/approve/retur/marketing", '1','green icon-check'),
                    'To Draft' => array('PROCESS', site_url()."/pengeluaran/toDraft/retur/marketing", '1','red icon-refresh'),
                );
            } elseif ($id_role == '2') {
                $prosesnya = array(
                    'Tambah' => array('GET',site_url().'/pengeluaran/add/retur', '0','icon-plus'),
                    'Ubah'   => array('EDITJS', site_url().'/pengeluaran/edit/retur', 'retur','icon-edit'),
                    'Hapus'  => array('DELETE', site_url().'/pengeluaran/delete/retur', 'retur','red icon-remove'
                ));
            }
            $SQL = "SELECT id_pengeluaran, nomor_transaksi 'Nomor Transaksi', tanggal 'Tanggal', 
                    vendor 'Nama Vendor', keterangan 'Keterangan',
                    CASE a.status
                        WHEN '0'
                            THEN '<span class=\"label label-warning\">Waiting Approval</span>'
                        WHEN '1'
                            THEN '<span class=\"label label-primary\">Approved</span>'
                        ELSE NULL
                    END AS 'Status', a.status 'status_hide'
                    FROM tbl_pengeluaran a
                    WHERE a.tipe = 'RETUR'";
            $this->newtable->search(array(
                array('nomor_transaksi', 'Nomor Permohonan'),
                array('vendor', 'Nama Vendor'),
                array('status', 'Status', 'tag-select', 
                    array(
                        "0" => "Waiting Approval", 
                        "1" => "Approved",
                ))
            ));
            $this->newtable->action(site_url() . "/pengeluaran/retur/list");
            $this->newtable->hiddens(array('id_pengeluaran','status_hide'));
            $this->newtable->keys(array('id_pengeluaran', 'status_hide'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("fretur");
            $this->newtable->set_divid("divretur");
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "tipe" => "retur"
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
        $id_divisi = $this->newsession->userdata('id_divisi');
        if ($tipe == "distribusi") {
            $act = $this->input->post('act');
            $id = $this->input->post('id_pengeluaran');
            foreach ($this->input->post('data') as $a => $b){
                $distribusi[$a] = $b;
            }
            $details = $this->input->post('detail');
            if ($act == "save") {
                # validasi nomor pengadaan
                $sql = "SELECT id_pengeluaran FROM tbl_pengeluaran WHERE nomor_transaksi = '" . $distribusi['nomor_transaksi'] . "'";
                $doCheck = $this->db->query($sql);
                if ($doCheck->num_rows() > 0) {
                    $nomorPermohonan = "DIST/" . date("Y") . "/" . date("m") . "/" . date("d") . "/" . date('His');
                    $distribusi['nomor_transaksi'] = $nomorPermohonan;
                }
                # insert distribusi into tbl_pengeluaran
                $distribusi['tipe']       = "DISTRIBUSI";
                $distribusi['id_divisi']  = $id_divisi;
                $distribusi['created_by'] = $id_user;
                $distribusi['created_at'] = date('Y-m-d H:i:s');
                $exec = $this->db->insert('tbl_pengeluaran', $distribusi);
                $id_pengeluaran = $this->db->insert_id();
                if ($exec) {
                    # insert detail into tbl_pengeluaran_detail
                    for ($i=0; $i < count($details['id_barang']); $i++) { 
                        $detail['id_pengeluaran'] = $id_pengeluaran;
                        $detail['id_barang'] = $details['id_barang'][$i];
                        $detail['jumlah'] = $details['jumlah'][$i];
                        $this->db->insert('tbl_pengeluaran_detail', $detail);
                    }
                    $conn->main->activity_log('ADD DISTRIBUSI', $distribusi['nomor_transaksi']);
                    echo "MSG#OK#Simpan data Berhasil#".site_url()."/pengeluaran/distribusi/list#";
                } else {
                    echo "MSG#ERR#Simpan data Gagal.";
                }
            } elseif ($act == "update") {
                # update tbl_pengeluaran
                $distribusi['updated_at'] = date('Y-m-d H:i:s');
                $this->db->where(array('id_pengeluaran' => $id));
                $exec = $this->db->update('tbl_pengeluaran', $distribusi);
                $exec = true;
                if ($exec) {
                    # delete then insert detail into tbl_pengeluaran_detail
                    $this->db->where(array('id_pengeluaran' => $id));
                    $this->db->delete('tbl_pengeluaran_detail');
                    for ($i=0; $i < count($details['id_barang']); $i++) { 
                        $detail['id_pengeluaran'] = $id;
                        $detail['id_barang'] = $details['id_barang'][$i];
                        $detail['jumlah'] = $details['jumlah'][$i];
                        $this->db->insert('tbl_pengeluaran_detail', $detail);
                    }
                    $conn->main->activity_log('EDIT DISTRIBUSI', $distribusi['nomor_transaksi']);
                    echo "MSG#OK#Simpan data Berhasil#".site_url()."/pengeluaran/distribusi/list#";
                } else {
                    echo "MSG#ERR#Simpan data Gagal.";
                }
            } else {
                $response = "MSG#ERR#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfdistribusi');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $id = $arrchk[0];
                    $status = $arrchk[1];
                    if ($status != '0') {
                        $response = "MSG#ERR#Maaf, Data yang bisa dihapus hanya yang berstatus Waiting Approval.\nPeriksa kembali data pilihan anda";
                    } else {
                        $distribusi = $this->getData($tipe, $id);
                        # delete data from tbl_pengeluaran
                        $this->db->where(array('id_pengeluaran' => $id));
                        $this->db->delete('tbl_pengeluaran');
                        # delete data from tbl_pengeluaran_detail
                        $this->db->where(array('id_pengeluaran' => $id));
                        $this->db->delete('tbl_pengeluaran_detail');
                        # write log
                        $conn->main->activity_log('DELETE DISTRIBUSI', 'NOMOR PERMOHONAN=' . $distribusi['nomor_transaksi']);
                        $response = "MSG#OK#Hapus data Berhasil#" . site_url() . "/pengeluaran/distribusi/list/ajax";
                    }
                }
                return $response;
            }
        } elseif ($tipe == "approve_distribusi_divisi") {
            $response = "MSG#ERR#Approve data gagal";
            $dataCheck = $this->input->post('tb_chkfdistribusi');
            foreach ($dataCheck as $chkitem) {
                $expKey = explode("|", $chkitem);
                $id = $expKey[0];
                $status = $expKey[1];
                if ($status == "0") {
                    $distribusi = $this->getData('distribusi', $id);
                    # update status distribusi
                    $this->db->where('id_pengeluaran', $id);
                    $this->db->update('tbl_pengeluaran', array('status' => '1'));
                    # write log
                    $conn->main->activity_log('APPROVE DISTRIBUSI OLEH ATASAN', $distribusi['nomor_transaksi']);
                    $response = "MSG#OK#Approve data Berhasil#".site_url()."/pengeluaran/distribusi/list/ajax";
                    return $response;
                } else {
                    $response = "MSG#ERR#Approve data gagal. Data yang dapat di Approve hanya yang berstatus Waiting Approval";
                    return $response;
                }
            }
        } elseif ($tipe == "todraft_distribusi_divisi") {
            $response = "MSG#ERR#Draft data gagal";
            $dataCheck = $this->input->post('tb_chkfdistribusi');
            foreach ($dataCheck as $chkitem) {
                $expKey = explode("|", $chkitem);
                $id = $expKey[0];
                $status = $expKey[1];
                if ($status == "1") {
                    $distribusi = $this->getData('distribusi', $id);
                    # update status tbl_pengeluaran
                    $this->db->where('id_pengeluaran', $id);
                    $this->db->update('tbl_pengeluaran', array('status' => '0'));
                    # write log
                    $conn->main->activity_log('TO DRAFT DISTRIBUSI', $distribusi['nomor_transaksi']);
                    $response = "MSG#OK#Proses data Berhasil#".site_url()."/pengeluaran/distribusi/list/ajax";
                    return $response;
                } else {
                    $response = "MSG#ERR#Draft data gagal. Data yang dapat diubah ke draft hanya yang berstatus Approved";
                    return $response;
                }
            }
        } elseif ($tipe == "approve_marketing") {
            $id_pengeluaran = $this->input->post('id_pengeluaran');
            $distribusi = $this->input->post('data');
            $details = $this->input->post('detail');
            
            # validasi stock barang
            for ($i=0; $i < count($details['id_barang']); $i++) {
                $sqlGetBarang = "SELECT id_barang, kode_barang, stock FROM tbl_barang 
                                WHERE id_barang = '" . $details['id_barang'][$i] . "'";
                $objBarang = $this->db->query($sqlGetBarang)->row_array();
                $sisa = $objBarang['stock'] - $details['jumlah_setujui'][$i];
                if ($sisa < 0) {
                    $response = "MSG#ERR#Apparove data gagal. Stock barang dengan kode <b>".$objBarang['kode_barang']."</b> tidak mencukupi";
                    return $response;
                }
            }

            # update status tbl_pengeluaran
            $this->db->where('id_pengeluaran', $id_pengeluaran);
            $this->db->update('tbl_pengeluaran', array('status' => '2'));
            for ($i=0; $i < count($details['id_barang']); $i++) {
                # insert into tbl_inout
                $inout['id_header']       = $id_pengeluaran;
                $inout['id_detail']       = $details['id_pengeluaran_detail'][$i];
                $inout['nomor_transaksi'] = $distribusi['nomor_transaksi'];
                $inout['tipe']            = "DISTRIBUSI";
                $inout['id_barang']       = $details['id_barang'][$i];
                $inout['jumlah']          = $details['jumlah_setujui'][$i];
                $inout['created_at']      = date('Y-m-d H:i:s');
                $this->db->insert('tbl_inout', $inout);

                # update tbl_pengeluaran_detail
                $detail['jumlah_setujui'] = $details['jumlah_setujui'][$i];
                $detail['keterangan'] = $details['keterangan'][$i];
                $this->db->where('id_pengeluaran_detail', $details['id_pengeluaran_detail'][$i]);
                $this->db->update('tbl_pengeluaran_detail', $detail);

                # update stock tbl_barang
                $this->db->where('id_barang', $details['id_barang'][$i]);
                $this->db->set('stock', 'stock-'.(float)$detail['jumlah_setujui'], FALSE);
                $this->db->update('tbl_barang');
                
            }
            # write log
            $conn->main->activity_log('APPROVE DISTRIBUSI OLEH MARKETING', 'NOMOR PERMOHONAN=' . $distribusi['nomor_transaksi']);
            echo "MSG#OK#Approve data Berhasil#".site_url()."/pengeluaran/distribusi/list#";
        } elseif ($tipe == "delivery") {
            $key = $this->input->post('key');
            $expKey = explode(",", $key);
            $tanggal = $this->input->post('tanggal');
            $id_pengeluaran = $expKey[0];

            $distribusi = $this->getData('distribusi', $id_pengeluaran);
            # update tbl_pengeluaran
            $data['tanggal_serah_terima'] = $tanggal;
            $data['status'] = '3';
            $this->db->where('id_pengeluaran', $id_pengeluaran);
            $update = $this->db->update('tbl_pengeluaran', $data);
            if ($update) {
                # write log
                $conn->main->activity_log('DELIVERY DISTRIBUSI', $distribusi['nomor_transaksi']);
                $response = "MSG#OK#Proses data Berhasil#".site_url()."/pengeluaran/distribusi/list/ajax";
                return $response;
            }
        } elseif ($tipe == "reject_distribusi") {
            $response = "MSG#ERR#Approve data gagal";
            $dataCheck = $this->input->post('tb_chkfdistribusi');
            foreach ($dataCheck as $chkitem) {
                $expKey = explode("|", $chkitem);
                $id = $expKey[0];
                $status = $expKey[1];
                if ($status == "1") {
                    $distribusi = $this->getData('distribusi', $id);
                    # update status distribusi
                    $this->db->where('id_pengeluaran', $id);
                    $this->db->update('tbl_pengeluaran', array('status' => '4'));
                    # write log
                    $conn->main->activity_log('REJECT DISTRIBUSI', $distribusi['nomor_transaksi']);
                    $response = "MSG#OK#Approve data Berhasil#".site_url()."/pengeluaran/distribusi/list/ajax";
                    return $response;
                } else {
                    $response = "MSG#ERR#Reject data gagal. Data yang dapat di Reject hanya yang berstatus Approved";
                    return $response;
                }
            }
        } elseif ($tipe == "retur") {
            $act = $this->input->post('act');
            $id = $this->input->post('id_pengeluaran');
            foreach ($this->input->post('data') as $a => $b){
                $retur[$a] = $b;
            }
            $details = $this->input->post('detail');
            if ($act == "save") {
                # validasi nomor transaksi
                $sql = "SELECT id_pengeluaran FROM tbl_pengeluaran WHERE nomor_transaksi = '" . $retur['nomor_transaksi'] . "'";
                $doCheck = $this->db->query($sql);
                if ($doCheck->num_rows() > 0) {
                    $nomorTransaksi = "DIST/" . date("Y/m/d") . "/" . date('His');
                    $retur['nomor_transaksi'] = $nomorTransaksi;
                }
                # insert retur into tbl_pengeluaran
                $retur['tipe']       = "RETUR";
                $retur['id_divisi']  = $id_divisi;
                $retur['created_by'] = $id_user;
                $retur['created_at'] = date('Y-m-d H:i:s');
                $exec = $this->db->insert('tbl_pengeluaran', $retur);
                $id_pengeluaran = $this->db->insert_id();
                if ($exec) {
                    # insert detail into tbl_pengeluaran_detail
                    for ($i=0; $i < count($details['id_barang']); $i++) { 
                        $detail['id_pengeluaran'] = $id_pengeluaran;
                        $detail['id_barang'] = $details['id_barang'][$i];
                        $detail['jumlah'] = $details['jumlah'][$i];
                        $this->db->insert('tbl_pengeluaran_detail', $detail);
                    }
                    $conn->main->activity_log('ADD RETUR', $retur['nomor_transaksi']);
                    echo "MSG#OK#Simpan data Berhasil#".site_url()."/pengeluaran/retur/list#";
                } else {
                    echo "MSG#ERR#Simpan data Gagal.";
                }
            } elseif ($act == "update") {
                # update tbl_pengeluaran
                $retur['updated_at'] = date('Y-m-d H:i:s');
                $this->db->where(array('id_pengeluaran' => $id));
                $exec = $this->db->update('tbl_pengeluaran', $retur);
                $exec = true;
                if ($exec) {
                    # delete then insert detail into tbl_pengeluaran_detail
                    $this->db->where(array('id_pengeluaran' => $id));
                    $this->db->delete('tbl_pengeluaran_detail');
                    for ($i=0; $i < count($details['id_barang']); $i++) { 
                        $detail['id_pengeluaran'] = $id;
                        $detail['id_barang'] = $details['id_barang'][$i];
                        $detail['jumlah'] = $details['jumlah'][$i];
                        $this->db->insert('tbl_pengeluaran_detail', $detail);
                    }
                    $conn->main->activity_log('EDIT RETUR', $retur['nomor_transaksi']);
                    echo "MSG#OK#Simpan data Berhasil#".site_url()."/pengeluaran/retur/list#";
                } else {
                    echo "MSG#ERR#Simpan data Gagal.";
                }
            } else {
                $response = "MSG#ERR#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfretur');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $id = $arrchk[0];
                    $status = $arrchk[1];
                    if ($status != '0') {
                        $response = "MSG#ERR#Maaf, Data yang bisa dihapus hanya yang berstatus Waiting Approval.\nPeriksa kembali data pilihan anda";
                    } else {
                        $retur = $this->getData($tipe, $id);
                        # delete data from tbl_pengeluaran
                        $this->db->where(array('id_pengeluaran' => $id));
                        $this->db->delete('tbl_pengeluaran');
                        # delete data from tbl_pengeluaran_detail
                        $this->db->where(array('id_pengeluaran' => $id));
                        $this->db->delete('tbl_pengeluaran_detail');
                        # write log
                        $conn->main->activity_log('DELETE RETUR', 'NOMOR TRANSAKSI=' . $retur['nomor_transaksi']);
                        $response = "MSG#OK#Hapus data Berhasil#" . site_url() . "/pengeluaran/retur/list/ajax";
                    }
                }
                return $response;
            }
        } elseif ($tipe == "approve_retur_marketing") {
            $response = "MSG#ERR#Approve data gagal";
            $dataCheck = $this->input->post('tb_chkfretur');
            foreach ($dataCheck as $chkitem) {
                $expKey = explode("|", $chkitem);
                $id = $expKey[0];
                $status = $expKey[1];
                if ($status == "0") {
                    $retur = $this->getData('retur', $id);
                    $details = $this->getData('retur_detail', $id);
                    foreach ($details as $detail) {
                        $inout['id_header']       = $id;
                        $inout['id_detail']       = $detail['id_pengeluaran_detail'];
                        $inout['nomor_transaksi'] = $retur['nomor_transaksi'];
                        $inout['tipe']            = "RETUR";
                        $inout['id_barang']       = $detail['id_barang'];
                        $inout['jumlah']          = $detail['jumlah'];
                        $inout['created_at']      = date('Y-m-d H:i:s');
                        $this->db->insert('tbl_inout', $inout);

                        # update stock tbl_barang
                        $this->db->where('id_barang', $detail['id_barang']);
                        $this->db->set('stock', 'stock-'.(float)$detail['jumlah'], FALSE);
                        $this->db->update('tbl_barang');
                        
                    }
                    # update status tbl_pengeluaran
                    $this->db->where('id_pengeluaran', $id);
                    $this->db->update('tbl_pengeluaran', array('status' => '1'));
                    # write log
                    $conn->main->activity_log('APPROVE RETUR', 'NOMOR TRANSAKSI=' . $retur['nomor_transaksi']);
                    $response = "MSG#OK#Approve data Berhasil#".site_url()."/pengeluaran/retur/list/ajax";
                    return $response;
                } else {
                    $response = "MSG#ERR#Approve data gagal. Data yang dapat di Approve hanya yang berstatus Waiting Approval";
                    return $response;
                }
            }
        }
    }

    function getData($tipe, $id) {
        $conn = get_instance();
        $conn->load->model("main");
        if ($tipe == "distribusi" || $tipe == "retur") {
            if ($tipe == "distribusi") {
                $query = "SELECT a.*, b.nik, b.nama, c.divisi FROM tbl_pengeluaran a 
                    LEFT JOIN tbl_user b ON b.id_user = a.created_by
                    LEFT JOIN tbl_divisi c ON c.id_divisi = a.id_divisi
                    WHERE a.id_pengeluaran = '" . $id . "'";
            } else {
                $query = "SELECT * FROM tbl_pengeluaran
                        WHERE id_pengeluaran = '" . $id . "'";
            }
            $hasil = $conn->main->get_result($query);
            if ($hasil) {
                foreach ($query->result_array() as $row) {
                    $dataarray = $row;
                }
            }
        } elseif ($tipe == "distribusi_detail" || $tipe == "retur_detail") {
            $query = "SELECT a.*, b.kode_barang, c.jenis_barang, b.nama_barang, b.uraian, b.satuan
                     FROM tbl_pengeluaran_detail a
                     LEFT JOIN tbl_barang b ON b.id_barang = a.id_barang
                     LEFT JOIN tbl_jenis_barang c ON c.id_jenis_barang = b.jenis_barang
                     WHERE a.id_pengeluaran = '" . $id . "'";
            $hasil = $conn->main->get_result($query);
            if ($hasil) {
                $dataarray = $query->result_array();
            }
        } elseif ($tipe == "stock_barang") {
            $query = "SELECT kode_barang, stock FROM tbl_barang WHERE id_barang = '" . $id . "'";
            $hasil = $conn->main->get_result($query);
            if ($hasil) {
                $dataarray = $query->row_array();
            }
        }
        
        return $dataarray;
    }
}