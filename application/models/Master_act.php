<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_act extends CI_Model 
{
    function list_divisi($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        if ($tipe) {
            $title = "List Data Divisi";
            $prosesnya = array(
                'Tambah' => array('GET',site_url().'/master/add/divisi', '0','icon-plus'),
                'Ubah'   => array('EDITJS', site_url().'/master/edit/divisi', '1','icon-edit'),
                'Hapus'  => array('DELETE', site_url().'/master/delete/divisi', 'divisi','red icon-remove'
            ));
            $SQL = "SELECT id_divisi, divisi AS 'Nama Divisi' FROM tbl_divisi WHERE id_divisi <> 1";
            $this->newtable->search(array(
                array('divisi', 'Nama Divisi')
            ));
            $this->newtable->action(site_url() . "/master/divisi/list");
            $this->newtable->hiddens(array('id_divisi'));
            $this->newtable->keys(array('id_divisi'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("ASC");
            $this->newtable->set_formid("fdivisi");
            $this->newtable->set_divid("divdivisi");
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

    function list_jenis($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        if ($tipe) {
            $title = "List Data Jenis Barang";
            $prosesnya = array(
                'Tambah' => array('GET',site_url().'/master/add/jenis_barang', '0','icon-plus'),
                'Ubah'   => array('EDITJS', site_url().'/master/edit/jenis_barang', '1','icon-edit'),
                'Hapus'  => array('DELETE', site_url().'/master/delete/jenis_barang', 'jenis_barang','red icon-remove'
            ));
            $SQL = "SELECT id_jenis_barang, jenis_barang AS 'Jenis Barang' FROM tbl_jenis_barang";
            $this->newtable->search(array(
                array('jenis_barang', 'Jenis Barang')
            ));
            $this->newtable->action(site_url() . "/master/jenis_barang/list");
            $this->newtable->hiddens(array('id_jenis_barang'));
            $this->newtable->keys(array('id_jenis_barang'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("ASC");
            $this->newtable->set_formid("fjenis_barang");
            $this->newtable->set_divid("divjenis_barang");
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "jenis" => $jenis,
                "tipe" => "jenis_barang"
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

    function list_barang($tipe = "", $ajax = "") {
        $this->load->library('newtable');
        if ($tipe) {
            $title = "List Data Barang";
            $prosesnya = array(
                'Tambah' => array('GET',site_url().'/master/add/barang', '0','icon-plus'),
                'Ubah'   => array('EDITJS', site_url().'/master/edit/barang', '1','icon-edit'),
                'Hapus'  => array('DELETE', site_url().'/master/delete/barang', 'barang','red icon-remove'
            ));
            $SQL = "SELECT a.id_barang, a.kode_barang AS 'Kode Barang', b.jenis_barang AS 'Jenis Barang',
                    a.nama_barang AS 'Nama Barang', a.uraian AS 'Uraian', a.merk AS 'Merk',
                    a.satuan AS 'Satuan', FORMAT(a.stock, 0) AS 'Stock', FORMAT(a.stock_minimum, 0) AS 'Stock Minimum'
                    FROM tbl_barang a
                    LEFT JOIN tbl_jenis_barang b ON b.id_jenis_barang = a.jenis_barang";
            $this->newtable->search(array(
                array('kode_barang', 'Kode Barang'),
                array('nama_barang', 'Nama Barang')
            ));
            $this->newtable->action(site_url() . "/master/barang/list");
            $this->newtable->hiddens(array('id_barang'));
            $this->newtable->keys(array('id_barang'));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby(1);
            $this->newtable->sortby("ASC");
            $this->newtable->set_formid("fbarang");
            $this->newtable->set_divid("divbarang");
            $this->newtable->rowcount(15);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel = $this->newtable->generate($SQL);
            $arrdata = array(
                "title" => $title,
                "tabel" => $tabel,
                "jenis" => $jenis,
                "tipe" => "barang"
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

    function list_so($tipe = "", $ajax = "") {
        $func = &get_instance();
        $func->load->model("main","main", true);
        $this->load->library('newtable');
        $SQL = "SELECT id,DATE_FORMAT(tanggal, '%d %M %Y') AS 'TANGGAL STOCK OPNAME',
                COUNT(*) AS 'JUMLAH ITEM BARANG',tanggal  
                FROM tbl_stockopname";
        foreach($this->input->post('CARI') as $a=>$b){
            $CARI[$a] = $b;
        }   
        if($CARI["TGL_DOK1"]!=""&&$CARI["TGL_DOK2"]!=""){
            $SQL .= $func->main->cekWhere($SQL);
            $SQL .= "tanggal BETWEEN '".$CARI["TGL_DOK1"]."' AND '".$CARI["TGL_DOK2"]."'";
        }
        $SQL .= " GROUP BY tanggal";
            $prosesnya = array( 
                'Tambah' => array('GET2', site_url()."/master/add/so", '0','fa fa-plus'),                          
                'Ubah' => array('EDITJS', site_url()."/master/edit/so", '1','fa fa-edit'),
                'Update Stock' => array('PROCESS', site_url()."/master/so/update_stock", 'so','fa fa-refresh'),
                'Hapus' => array('DELETE', site_url().'/master/delete/so', 'so','fa fa-trash-o red'),
            );
        $title = "List Data Stock Opname";
        $this->newtable->search(array(array('tanggal', 'TANGGAL STOCK&nbsp;', 'tag-tanggal')));
        $this->newtable->show_search(false);
        $ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");       
        $this->newtable->action(site_url()."/master/so/list");
        $this->newtable->detail(site_url()."/master/so/load_barang/view");
        $this->newtable->detail_tipe("detil_priview_bottom");
        $this->newtable->hiddens(array("id","tanggal"));
        $this->newtable->keys(array("tanggal"));
        $this->newtable->tipe_proses('button');
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby("id");
        $this->newtable->sortby("DESC");
        $this->newtable->set_formid("fstockopaname");
        $this->newtable->set_divid("divstockopaname");
        $this->newtable->rowcount(10);
        $this->newtable->clear(); 
        $this->newtable->menu($prosesnya);
        if(!($this->input->post("ajax")||$ajax=="ajax")){
            $tabel .= '<form name="tblCari" id="tblCari" method="post" action="master/so/list" onsubmit="return frm_Cari(\'divstockopaname\',\'tblCari\')">      
                        <table border="0" cellpadding="0" cellspacing="2" width="100%" style="margin-bottom:10px">';
            $tabel .= ' <tr>
                            <td width="14%"><strong>Tanggal Stock Opname</strong></td>
                            <td>:</td>
                            <td>'.form_input('CARI[TGL_DOK1]','','id="TGL_DOK1" class="text date" onfocus="ShowDP(this.id)"').' s/d 
                                '.form_input('CARI[TGL_DOK2]','','id="TGL_DOK2" class="text date" onfocus="ShowDP(this.id)"').' </td>
                        </tr>';
            $tabel .= ' <tr><td colspan="3">&nbsp;<input type="submit" style="display:none"></td></tr>';                        
            $tabel .= ' <tr>
                            <td colspan="3">';
            $tabel .= "     <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-primary\" id=\"ok_\" onclick=\"frm_Cari('divstockopaname','tblCari')\"><i class=\"icon-search\"></i>&nbsp;Search</a>&nbsp;";
            $tabel .= "     <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-danger\" id=\"ok_\" onclick=\"cancel('tblCari')\"><span><i class=\"icon-remove\"></i>&nbsp;Clear</a>";
            $tabel .= '     </td>
                        </tr>';                         
            $tabel .= '  </table>
                        </form>';                   
        }
        $tabel .= $this->newtable->generate($SQL); 
        $arrdata = array("title" => $title,
                         "tabel" => $tabel);
        if($this->input->post("ajax")||$ajax=="ajax") return $tabel;                 
        else return $arrdata;
    }

    function brgstockopname($id = "", $act = "") {
        $func = &get_instance();
        $func->load->model("main","main", true);
        $this->load->library('newtable');   
        $SQL = "SELECT a.id, b.kode_barang 'KODE BARANG', c.jenis_barang 'JENIS BARANG', 
                b.nama_barang 'NAMA BARANG', b.satuan 'SATUAN', FORMAT(a.jumlah, 0) 'JUMLAH', tanggal
                FROM tbl_stockopname a
                LEFT JOIN tbl_barang b ON b.id_barang = a.id_barang
                LEFT JOIN tbl_jenis_barang c ON c.id_jenis_barang = b.jenis_barang
                WHERE a.tanggal = '" . $id . "'";
        if($act!="view"){                   
            $prosesnya = array( 'Tambah'=>array('DIALOGPINDAH-550;320',site_url().'/master/so/detil_so/save', '0','fa fa-plus','brgstock'),                                    
                                'Ubah'=>array('DIALOGPINDAH-550;320', site_url().'/master/so/detil_so/update', '1','fa fa-edit'),
                                'Hapus'=>array('DELETE', site_url().'/master/delete/detil_so', 'brgstockopname','fa fa-trash-o red'));    
        }else{          
            $this->newtable->show_chk(false);
        }
        $ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
        $this->newtable->action(site_url()."/master/so/load_barang/load/".$id);                  
        $this->newtable->search(array(
            array('kode_barang', 'KODE BARANG'), 
            array('nama_barang', 'NAMA BARANG')
        ));
        $this->newtable->count_keys(array("id"));
        $this->newtable->hiddens(array("id","tanggal"));
        $this->newtable->keys(array("id","tanggal"));
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby("id");
        $this->newtable->sortby("ASC");
        $this->newtable->set_formid("fstockdetil");
        $this->newtable->set_divid("divfstockdetil");
        $this->newtable->rowcount(10);
        $this->newtable->tipe_proses('button');
        $this->newtable->count_keys(array("id"));
        $this->newtable->header_bg("#3f51b5");
        $this->newtable->menu($prosesnya);
        $this->newtable->clear();

        $generate = $this->newtable->generate($SQL);
        $table = '<div class="header">
                        <div class="widget-header widget-header-flat">
                          <h4 class="lighter"> <i class="icon-th" style="color:orange;"></i>&nbsp;Detil Barang</span></h4>
                        </div>
                  </div>'.$generate.'</div>
                <div class="space-7"></div>';
        if($act=="view") return $table;
        else return $generate;
    }

    function proses_form($tipe, $id = "") {
        $conn = get_instance();
        $conn->load->model("main");
        if ($tipe == "divisi") {
            $act = $this->input->post('act');
            $id_divisi = $this->input->post('id_divisi');
            foreach ($this->input->post('data') as $a => $b){
                $divisi[$a] = $b;
            }
            if ($act == "save") {
                $sqlValidasi = "SELECT id_divisi FROM tbl_divisi WHERE divisi = '" . $divisi['divisi'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Nama divisi sudah ada.";
                } else {
                    $exec = $this->db->insert('tbl_divisi', $divisi);
                    if ($exec) {
                        $conn->main->activity_log('ADD DIVISI', $divisi['divisi']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/divisi/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal#".site_url()."/master/divisi/list#";
                    }
                }
            } else if ($act == "update") {
                $sqlValidasi = "SELECT id_divisi, divisi FROM tbl_divisi 
                                WHERE id_divisi <> '" . $id_divisi . "'
                                AND divisi = '" . $divisi['divisi'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Nama divisi sudah ada.";
                } else {
                    $this->db->where(array(
                        'id_divisi' => $id_divisi
                    ));
                    $exec = $this->db->update('tbl_divisi', $divisi);
                    if ($exec) {
                        $conn->main->activity_log('EDIT DIVISI', $divisi['divisi']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/divisi/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal#".site_url()."/master/divisi/list#";
                    }
                }
            } else {
                $ret = "MSG#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfdivisi');
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode(".", $chkitem);
                    $id = $arrchk[0];
                    $getDivisi = $this->getData($tipe, $id);
                    $this->db->where(array('id_divisi' => $id));
                    $this->db->delete('tbl_divisi');
                    $conn->main->activity_log('DELETE DIVISI', 'DIVISI=' . $getDivisi['divisi']);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/divisi/list/ajax";
                echo $ret;
            }
        } elseif ($tipe == "jenis_barang") {
            $act = $this->input->post('act');
            $id_jenis_barang = $this->input->post('id_jenis_barang');
            foreach ($this->input->post('data') as $a => $b){
                $jenis_barang[$a] = $b;
            }
            if ($act == "save") {
                $sqlValidasi = "SELECT id_jenis_barang FROM tbl_jenis_barang 
                                WHERE jenis_barang = '" . $jenis_barang['jenis_barang'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Nama Jenis Barang sudah ada.";
                } else {
                    $exec = $this->db->insert('tbl_jenis_barang', $jenis_barang);
                    if ($exec) {
                        $conn->main->activity_log('ADD JENIS BARANG', $jenis_barang['jenis_barang']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/jenis_barang/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal#".site_url()."/master/jenis_barang/list#";
                    }
                }
            } else if ($act == "update") {
                # validasi jenis barang sudah digunakan
                $sqlCheck = "SELECT id_barang FROM tbl_barang 
                            WHERE jenis_barang = '" . $id_jenis_barang . "'";
                $doCheck = $this->db->query($sqlCheck);
                if ($doCheck->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Jenis barang sudah digunakan pada Data Barang.";
                    die();
                }
                # validasi jenis barang available
                $sqlValidasi = "SELECT id_jenis_barang, jenis_barang FROM tbl_jenis_barang 
                                WHERE id_jenis_barang <> '" . $id_jenis_barang . "'
                                AND jenis_barang = '" . $jenis_barang['jenis_barang'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Jenis barang sudah ada.";
                } else {
                    $this->db->where(array(
                        'id_jenis_barang' => $id_jenis_barang
                    ));
                    $exec = $this->db->update('tbl_jenis_barang', $jenis_barang);
                    if ($exec) {
                        $conn->main->activity_log('EDIT JENIS BARANG', $jenis_barang['jenis_barang']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/jenis_barang/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal#".site_url()."/master/jenis_barang/list#";
                    }
                }
            } else {
                $ret = "MSG#ERR#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfjenis_barang');
                foreach ($dataCheck as $chkitem) {
                    $id = $chkitem;
                    # validasi jenis barang sudah digunakan
                    $sqlCheck = "SELECT id_barang FROM tbl_barang 
                                WHERE jenis_barang = '" . $id . "'";
                    $doCheck = $this->db->query($sqlCheck);
                    if ($doCheck->num_rows() > 0) {
                        echo "MSG#ERR#Hapus data Gagal. Jenis barang sudah digunakan pada Data Barang.";
                        die();
                    }
                    $getJenisBarang = $this->getData($tipe, $id);
                    $this->db->where(array('id_jenis_barang' => $id));
                    $this->db->delete('tbl_jenis_barang');
                    $conn->main->activity_log('DELETE JENIS BARANG', 'JENIS BARAN=' . $getJenisBarang['jenis_barang']);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/jenis_barang/list/ajax";
                echo $ret;
            }
        } elseif ($tipe == "barang") {
            $act = $this->input->post('act');
            $id_barang = $this->input->post('id_barang');
            foreach ($this->input->post('data') as $a => $b){
                $barang[$a] = $b;
            }
            if ($act == "save") {
                $sqlValidasi = "SELECT id_barang FROM tbl_barang 
                                WHERE kode_barang = '" . $barang['kode_barang'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Kode Barang sudah ada.";
                    die();
                } else {
                    $exec = $this->db->insert('tbl_barang', $barang);
                    if ($exec) {
                        $conn->main->activity_log('ADD BARANG', $barang['kode_barang']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/barang/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal#".site_url()."/master/barang/list#";
                    }
                }
            } else if ($act == "update") {
                # validasi perubahan kode barang
                $objBarang = $this->getData($tipe, $id_barang);
                if ($objBarang['kode_barang'] != $barang['kode_barang'] || $objBarang['jenis_barang'] != $barang['jenis_barang']) {
                    $sqlCheck = "SELECT id, id_barang FROM tbl_transaksi 
                                WHERE id_barang = '" . $id_barang . "'";
                    $doCheck = $this->db->query($sqlCheck);
                    if ($doCheck->num_rows() > 0) {
                        echo "MSG#ERR#Simpan data Gagal. Data Barang sudah ada mutasi.";
                        die();
                    }
                }
                # validasi kode barang
                $sqlValidasi = "SELECT id_barang, kode_barang FROM tbl_barang 
                                WHERE id_barang <> '" . $id_barang . "'
                                AND kode_barang = '" . $barang['kode_barang'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Kode barang sudah ada.";
                } else {
                    $this->db->where(array(
                        'id_barang' => $id_barang
                    ));
                    $exec = $this->db->update('tbl_barang', $barang);
                    if ($exec) {
                        // $objBarang = $doValidasi->row_array();
                        $conn->main->activity_log('EDIT DATA BARANG', $barang['kode_barang']);
                        echo "MSG#OK#Simpan data Berhasil#".site_url()."/master/barang/list#";
                    } else {
                        echo "MSG#ERR#Simpan data Gagal#".site_url()."/master/barang/list#";
                    }
                }
            } else {
                $ret = "MSG#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfbarang');
                foreach ($dataCheck as $chkitem) {
                    $id = $chkitem;
                    # validasi data mutasi
                    $sqlCheck = "SELECT id, id_barang FROM tbl_transaksi 
                                WHERE id_barang = '" . $id_barang . "'";
                    $doCheck = $this->db->query($sqlCheck);
                    if ($doCheck->num_rows() > 0) {
                        echo "MSG#ERR#Simpan data Gagal. Data Barang sudah ada mutasi.";
                        die();
                    }
                    $objBarang = $this->getData($tipe, $id);
                    $this->db->where(array('id_barang' => $id));
                    $this->db->delete('tbl_barang');
                    $conn->main->activity_log('DELETE DATA BARANG', 'KODE BARANG=' . $objBarang['kode_barang']);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/barang/list/ajax";
                echo $ret;
            }
        } elseif ($tipe == "so") {
            $id_user = $this->newsession->userdata('id_user');
            $act = $this->input->post('act');
            foreach ($this->input->post('data') as $a => $b){
                $so[$a] = $b;
            }
            if ($act == "save") {
                $sqlValidasi = "SELECT id_barang FROM tbl_stockopname 
                                WHERE id_barang = '" . $so['id_barang'] . "'
                                AND tanggal = '" . $so['tanggal'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Kode Barang tersebut sudah ada.";
                    die();
                } else {
                    unset($so['id']);
                    $so['id_user'] = $id_user;
                    $exec = $this->db->insert('tbl_stockopname', $so);
                    if ($exec) {
                        $conn->main->activity_log('ADD STOCK OPNAME', $so['tanggal']);
                        echo "MSG#OK#Simpan data Berhasil#" . site_url() . "/master/so/load_barang/load/" . $so['tanggal'];
                    } else {
                        echo "MSG#ERR#Simpan data Gagal#";
                    }
                }
            } else if ($act == "update") {
                $sqlValidasi = "SELECT id_barang FROM tbl_stockopname 
                                WHERE id <> '" . $so['id'] . "'
                                AND id_barang = '" . $so['id_barang'] . "'
                                AND tanggal = '" . $so['tanggal'] . "'";
                $doValidasi = $this->db->query($sqlValidasi);
                if ($doValidasi->num_rows() > 0) {
                    echo "MSG#ERR#Simpan data Gagal. Kode Barang tersebut sudah ada.";
                    die();
                }
                $this->db->where(array(
                    'id' => $so['id']
                ));
                $exec = $this->db->update('tbl_stockopname', $so);
                if ($exec) {
                    $conn->main->activity_log('EDIT STOCK OPNAME', $so['id_barang']);
                    echo "MSG#OK#Simpan data Berhasil#" . site_url() . "/master/so/load_barang/load/" . $so['tanggal'];
                } else {
                    echo "MSG#ERR#Simpan data Gagal#";
                }
            } else {
                $ret = "MSG#ERR#Hapus data Gagal";
                $dataCheck = $this->input->post('tb_chkfstockopaname');
                foreach ($dataCheck as $chkitem) {
                    $id = $chkitem;
                    $this->db->where(array('tanggal' => $id));
                    $this->db->delete('tbl_stockopname');
                    $conn->main->activity_log('DELETE STOCK OPNAME', 'TANGGAL=' . $id);
                }
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/so/list/ajax";
                echo $ret;
            }
        } elseif ($tipe == "detil_so") {
            $ret = "MSG#ERR#Hapus data Gagal";
            $dataCheck = $this->input->post('tb_chkfstockdetil');
            foreach ($dataCheck as $chkitem) {
                $expKey = explode("|", $chkitem);
                $id = $expKey[0];
                $this->db->where(array('id' => $id));
                $this->db->delete('tbl_stockopname');
                $conn->main->activity_log('DELETE STOCK OPNAME', 'ID=' . $id);
            }
            echo "MSG#OK#Hapus data Berhasil#" . site_url() . "/master/so/load_barang/load/" . $expKey[1];
        } elseif ($tipe == "update_tanggal") {
            $data = $this->input->post('DATA');
            $this->db->where(array(
                'tanggal' => $this->input->post('TANGGAL_HIDE')
            ));
            $exec = $this->db->update('tbl_stockopname', array('tanggal' => $data['TANGGAL_STOCK']));  
            $response = "MSG#OK#Proses Update Data Berhasil";
            return $response;
        } elseif ($tipe == "update_stock") {
            $response = "MSG#ERR#Proses Update Stock Gagal";
            $data = $this->input->post('tb_chkfstockopaname');
            $countData = count($data);
            if ($countData > 1) {
                $response = "MSG#ERR#Hanya 1(satu) data yang dapat dipilih.";
                return $response;
            } else {
                $dataCheck = $this->input->post('tb_chkfstockopaname');
                foreach ($dataCheck as $key) {
                    $sql = "SELECT id, tanggal, id_barang, jumlah FROM tbl_stockopname
                            WHERE tanggal = '" . $key . "'";
                    $doSql = $this->db->query($sql)->result_array();
                    foreach ($doSql as $value) {
                        $this->db->where(array('id_barang' => $value['id_barang']));
                        $this->db->update('tbl_barang', array('stock' => $value['jumlah']));

                    }
                    $conn->main->activity_log('UPDATE STOCK BY STOCK OPNAME', 'TANGGAL=' . $key);
                    $response = "MSG#OK#Proses update stock barang berhasil";
                    return $response;
                }
            }
        }
    }

    function getData($tipe, $id) {
        $conn = get_instance();
        $conn->load->model("main");
        if ($tipe == "divisi") {
            $query = "SELECT * FROM tbl_divisi WHERE id_divisi = '" . $id . "'";
        } elseif ($tipe == "jenis_barang") {
            $query = "SELECT * FROM tbl_jenis_barang WHERE id_jenis_barang = '" . $id . "'";
        } elseif ($tipe == "all_jenis_barang") {
            $query = "SELECT * FROM tbl_jenis_barang";
        } elseif ($tipe == "barang") {
            $query = "SELECT * FROM tbl_barang WHERE id_barang = '" . $id . "'";
        } elseif ($tipe == "detil_so") {
            $expId = explode("|", $id);
            $query = "SELECT a.id, a.id_barang, b.kode_barang, b.nama_barang, b.satuan,
                     c.jenis_barang, a.jumlah
                     FROM tbl_stockopname a
                     LEFT JOIN tbl_barang b ON b.id_barang = a.id_barang
                     LEFT JOIN tbl_jenis_barang c ON c.id_jenis_barang = b.jenis_barang
                     WHERE id = '" . $expId[0] . "'";
        }
        $hasil = $conn->main->get_result($query);
        if ($hasil) {
            if ($id) {
                foreach ($query->result_array() as $row) {
                    $dataarray = $row;
                }
            } else {
                $dataarray = $query->result_array();
            }
            
        }
        return $dataarray;
    }

}

?>