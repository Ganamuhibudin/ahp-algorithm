<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tools_act extends CI_Model {

    function revisi() {
        $func = get_instance();
        $func->load->model("main");
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $data = array("DOK_PABEAN" => $func->main->get_combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_DOKUMEN' AND KODE !='PPFTZ'
                                                                ORDER BY URAIAN", "KODE", "URAIAN", FALSE));
        return $data;
    }

    #PROSES MENAMPILKAN DATA YG MAU DIREVISI
    function tab($tipe = "") {
        #combobox pabean
        $sql = "SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_DOKUMEN' ORDER BY URAIAN";
        $do = $this->db->query($sql)->result_array();
        $array_dokumen = array('all' => 'Semua Dokumen');
        foreach ($do as $data_dokumen) {
            $array_dokumen[$data_dokumen['KODE']] = $data_dokumen['URAIAN'];
        }
        #combobox produksi
        $array_produksi = array('' => 'Pilih Tipe',
            'bahan_baku' => 'Bahan Untuk Diproses',
            'half' => 'Barang Setengah Jadi',
            'hasil_produksi' => 'Hasil Produksi',
            'hasil_sisa' => 'Sisa Produksi/Scrap');
        $data_tab = array('0' => 'Dokumen Pabean',
            /*'1' => 'Produksi'*/);
        if ($data_tab) {
            $tab = '<div id="tabbable"><ul class="nav nav-tabs" id="myTab">';
            $no = 1;
            foreach ($data_tab as $row) {
                if ($no == 1)
                    $tab .= '<li class="active">';
                else
                    $tab .= '<li>';
                $tab .= '<a data-toggle="tab" href="#tab-' . $no . '" onclick="viewrevisi(\'' . $no . '\')">';
                $tab .= $row;
                $tab .= '</a>';
                $tab .= '</li>';
                $no++;
            }
            $tab .= '</ul>';
            $nos = 1;
            $tab .= '<div class="tab-content" style="background-color:#FFFFFF;">';
            $tab .= '<div>';
            $tab .= '<combo>'.form_dropdown('search[DOK_PABEAN]', $array_dokumen, '', 'id="DOK_PABEAN" class="text" onchange="changeDokumen(\'#DOK_PABEAN\',\'1\')" ').'</combo>';
            $tab .= form_dropdown('search[TIPE_PRODUKSI]', $array_produksi, '', 'id="TIPE_PRODUKSI" class="text" onchange="changeDokumen(\'#TIPE_PRODUKSI\',\'2\')" style="display:none;" ');
            $tab .= '</div>';
            $tab .= '<br>';
            foreach ($data_tab as $row) {
                if ($nos == 1) {
                    /*$get = get_instance();
                    $get->load->model("pemasukan_act");*/
                    $data = $this->daftar_revisi("approved", "all", "", "1");
                    $tab .= '<div id="tab-' . $nos . '" class="tab-pane in active">' . $data['tabel'] . '</div>';
                    // $tab .= '<div id="tab-'.$nos.'" class="tab-pane in active">'."Data nya disini".$row.'</div>';
                } else {
                    $tab .= '<div id="tab-' . $nos . '" class="tab-pane"></div>';
                }
                $nos++;
            }
            $tab .= "</div>";
            $tab .= "</div>";
        }

        $arrdata = array("judul" => "Revisi Data (yang telah disetujui/realisasi)",
            "tabel" => $tab);
        return $arrdata;
    }

    function daftar_revisi($tipe="",$dokumen="",$aju="", $flagrevisi = "", $isajax = "")
    {
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $KODE_ROLE = $this->newsession->userdata('KODE_ROLE');
        $JNS_PLB = $this->newsession->userdata('JENIS_PLB');
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
        $jenis = "pemasukan";
        $addSql="";
        $TGLPENDAFTARAN = "NOMOR_PENDAFTARAN 'NOMOR DAFTAR',DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'Tanggal Daftar',"; 
        $FIELD = "DATE_FORMAT(TANGGAL_REALISASI, '%d %M %Y %H:%m:%s') AS 'Tanggal Realisasi', TANGGAL_REALISASI";
        $WHERE = " WHERE STATUS ='19' ";   
        if(!in_array($KODE_ROLE,array("3","5"))){
            $FIELD .= "";
            $WHERE .= " AND KODE_TRADER ='".$KODE_TRADER."' ";                  
        }else{
            #AND KODE_TRADER = '".$this->newsession->userdata("ANGGOTA_PLB")."'
            $FIELD .= ", f_trader(KODE_TRADER) 'NAMA ANGGOTA'";
            $WHERE .= " ";
        }
        
        $prosesnya = array(
                           'Edit to Draft' => array('PROMPT', site_url() . '/tools/revisidraft/pabean', '1', 'icon-reply'),
                            'Delete' => array('PROMPT', site_url() . '/tools/revisidelete/pabean', '1', 'red icon-trash'));
        $this->newtable->keys(array("DOKUMEN","NOMOR AJU","TANGGAL_REALISASI"));
        $this->newtable->hiddens(array("CREATED_TIME","TANGGAL_REALISASI","KODE_TRADER"));

        if(strtolower($dokumen)=="bc16"){           
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC16' AS 'DOKUMEN', ".$TGLPENDAFTARAN." 
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc16(NOMOR_AJU,2))) AS 'STATUS', KODE_TRADER 
                    FROM T_BC16_HDR";
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
        }elseif(strtolower($dokumen)=="bc24"){          
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC24' AS 'DOKUMEN', ".$TGLPENDAFTARAN." 
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc24(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC24_HDR";   
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
        }elseif(strtolower($dokumen)=="bc27"){      
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC27' AS 'DOKUMEN', ".$TGLPENDAFTARAN."
                   ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc27(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC27_HDR";
            $SQL .= $WHERE;   
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));                             
        }elseif(strtolower($dokumen)=="bc40"){              
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC40' AS 'DOKUMEN', ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc40(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC40_HDR";
            $SQL .= $WHERE;  
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
        }elseif(strtolower($dokumen)=="bc33"){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC33' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc33(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC33_HDR ";  
            $SQL .= $WHERE."";  
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
        }elseif(strtolower($dokumen)=="ppb"){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'PPB-PLB' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_ppb(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_PPB_HDR ";   
            $SQL .= $WHERE; 
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
        }elseif(strtolower($dokumen)=="ppk"){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'PPK-PLB' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_ppk(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_PPK_HDR ";   
            $SQL .= $WHERE; 
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
        }elseif($dokumen=='bc28'){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC28' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc28(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER FROM T_BC28_HDR ";  
            $SQL .= $WHERE; 
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));                                      
        }elseif($dokumen=="bc41"){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC41' AS DOKUMEN,".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc41(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC41_HDR ";  
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN")); 
        }else if($dokumen == "p3bet") {
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'P3BET' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_p3bet(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER FROM T_P3BET_HDR ";
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));   
        }else{
            $POSTURI = $this->input->post("uri");
            $judul = "Semua Dokumen";
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC16' AS 'DOKUMEN', ".$TGLPENDAFTARAN." 
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc16(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC16_HDR";
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
            $SQL .= " UNION ALL
                    SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC27' AS 'DOKUMEN', ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc27(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC27_HDR";
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
            $SQL .= " UNION ALL
                    SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC40' AS 'DOKUMEN', ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc40(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC40_HDR";
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
            /*$SQL .= " UNION ALL SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'PPB-PLB' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", KODE_TRADER 
                    FROM T_PPB_HDR ";   
            $SQL .= $WHERE; 
            
            $SQL .= " UNION ALL SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'PPK-PLB' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", KODE_TRADER 
                    FROM T_PPK_HDR ";   
            $SQL .= $WHERE; */
            
            $SQL .= " UNION ALL SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC33' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc33(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC33_HDR ";  
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
            $SQL .= "UNION ALL SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC28' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc28(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER 
                    FROM T_BC28_HDR ";
            $SQL .= $WHERE;      
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
            $SQL .= " UNION ALL
                    SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'BC41' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_bc41(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER FROM T_BC41_HDR ";
            $SQL .= $WHERE;
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));
            $SQL .= " UNION ALL
                    SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU', 'P3BET' AS DOKUMEN, ".$TGLPENDAFTARAN."
                    ".$FIELD.", IF(STATUS='07','DISETUJUI',IF(STATUS='19','REALISASI',f_status_p3bet(NOMOR_AJU,2))) AS 'STATUS',KODE_TRADER FROM T_P3BET_HDR ";
            $SQL .= $WHERE;  
            $SQL .= $func->main->getWhere($SQL, $POSTURI, array("NOMOR_AJU", "TANGGAL_PENDAFTARAN"));                          
        }   
        $this->newtable->search(array(array('NOMOR_AJU', 'NOMOR PENGAJUAN&nbsp;&nbsp;'), 
                                          array('TANGGAL_PENDAFTARAN', 'TANGGAL DOK', 'tag-tanggal')));

        $ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");
        $this->newtable->action(site_url() . "/tools/revisi/pabean/" . $dokumen . "");
        
        $this->newtable->tipe_proses('button');
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby(3,1,2);
        $this->newtable->sortby("DESC");
        $this->newtable->count_keys(array("CREATED_TIME"));
        $this->newtable->set_formid("f".$tipe);
        $this->newtable->set_divid("div".$tipe);
        $this->newtable->rowcount(20);
        $this->newtable->clear(); 
        $this->newtable->menu($prosesnya);
        $this->newtable->show_search(true);
        
        $generate = $this->newtable->generate($SQL);
        $tabel .= $generate;                    
        $arrdata = array("tabel" => $tabel,
                         "tipe" => $tipe);
        if($this->input->post("ajax") || $isajax) return $generate;
        else return $arrdata;
    }

    function prosesrevisi() {
        $func = get_instance();
        $func->load->model("main");
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $JENIS_REVISI = $this->input->post('JENIS_REVISI');
        $DOK_PABEAN = $this->input->post('DOK_PABEAN');
        $NOMOR_AJU = $this->input->post('NOMOR_AJU');
        $NOMOR_TRANSAKSI = $this->input->post('NOMOR_TRANSAKSI');
        $DOK_BAGIAN = $this->input->post('DOK_BAGIAN');
        $NOMOR_AJU_NEW = $this->input->post('NOMOR_AJU_NEW');
        $TIPE_PENGERJAAN = $this->input->post('TIPE_PENGERJAAN_SEDERHANA');

        if ($DOK_BAGIAN == "noaju") {
            $SQL = "SELECT NOMOR_AJU FROM T_" . $DOK_PABEAN . "_HDR WHERE NOMOR_AJU='" . $NOMOR_AJU . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
            $hasil = $func->main->get_result($SQL);
            if ($hasil) {
                $SQL = "SELECT NOMOR_AJU FROM T_" . $DOK_PABEAN . "_HDR WHERE NOMOR_AJU='" . $NOMOR_AJU_NEW . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                $hasil = $func->main->get_result($SQL);
                if (!$hasil) {
                    if ($DOK_PABEAN == "BC23") {
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_HDR", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DTL", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_CNT", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DOK", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_FAS", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_KMS", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_PERUBAHAN", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_PGT", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_TRF", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    } elseif ($DOK_PABEAN == "BC25") {
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_HDR", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DTL", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_BB", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_BMTAMBAHAN", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DOK", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_FAS", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_KMS", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_PGT", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_PPN_PENYERAHAN", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_TRF", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    } elseif ($DOK_PABEAN == "BC27") {
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_HDR", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DTL", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_BB", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_BJ", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_CNT", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DOK", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_KMS", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_PERUBAHAN", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    } elseif ($DOK_PABEAN == "BC30") {
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_HDR", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DTL", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_CNT", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_DOK", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_KMS", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_PJT", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                        $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->update("T_" . $DOK_PABEAN . "_PKB", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    }

                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                    $this->db->update("M_TRADER_PERMOHONAN", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                    $this->db->update("T_BREAKDOWN_PEMASUKAN", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                    $this->db->update("T_BREAKDOWN_PENGELUARAN", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                    $this->db->update("T_REALISASI_PARSIAL_HDR", array('NOMOR_AJU' => $NOMOR_AJU_NEW));
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'KODE_TRADER' => $KODE_TRADER));
                    $this->db->update("M_TRADER_BARANG_INOUT", array('NOMOR_AJU' => $NOMOR_AJU_NEW));

                    $func->main->activity_log('PERUBAHAN NOMOR AJU', 'REVISI DOKUMEN PABEAN ' . $DOK_PABEAN . ',DARI AJU=' . $NOMOR_AJU . ' MENJADI=' . $NOMOR_AJU_NEW);
                    echo "MSG#OK#Proses Perubahan Nomor Aju Berhasil!";
                } else {
                    echo "MSG#ERR#Nomor Aju Pengganti Sudah terpakai!";
                }
            } else {
                echo "MSG#ERR#Data tidak ditemukan!";
            }
            die();
        }

        if ($JENIS_REVISI == 1) {
            $SQL = "SELECT NOMOR_AJU FROM M_TRADER_BARANG_INOUT WHERE NOMOR_AJU='" . $NOMOR_AJU . "' 
                    AND KODE_TRADER='" . $KODE_TRADER . "'";
            if ($func->main->get_result($SQL)) {
                $SQL = "SELECT NOMOR_AJU FROM T_" . $DOK_PABEAN . "_HDR WHERE NOMOR_AJU='" . $NOMOR_AJU . "' 
						AND KODE_TRADER='".$KODE_TRADER . "'
                        AND STATUS='19' AND (TANGGAL_REALISASI IS NOT NULL OR TANGGAL_REALISASI!='')";
                $hasil = $func->main->get_result($SQL);
                if ($hasil) {
                    echo "MSG#OK#" . site_url() . "/tools/viewrevisidokumen/" . $DOK_PABEAN . "/" . $NOMOR_AJU . "/" . $DOK_BAGIAN;
                } else {
                    echo "MSG#ERR#Data tidak ditemukan!";
                }
            } else {
                echo "MSG#ERR#Data tidak ditemukan!!";
            }
        }elseif($JENIS_REVISI == 4){
            echo "MSG#OK#".site_url()."/produksi/revisi/".$TIPE_PENGERJAAN;
        } else {
            $SQL = "SELECT JENIS_BARANG FROM M_TRADER_PROSES WHERE NOMOR_PROSES='" . $NOMOR_TRANSAKSI . "' 
					AND KODE_TRADER='" . $KODE_TRADER . "' AND STATUS='1'";
            $rs = $this->db->query($SQL);
            if ($rs->num_rows() > 0) {
                $jns = $rs->row()->JENIS_BARANG;
                $tipe = array("masuk" => "bahan_baku", "keluar" => "hasil_produksi", "sisa" => "hasil_sisa");
                echo "MSG#OK#" . site_url() . "/tools/viewrevisiproduksi/" . $tipe[$jns] . "/" . $NOMOR_TRANSAKSI . "/revisi";
            } else {
                echo "MSG#ERR#Data tidak ditemukan!";
            }
        }
    }

    #MENAMPILKAN DOKUMEN PABEAN

    function viewrevisidokumen($dok, $aju, $bagian) {
		//echo $bagian;die();
        $func = get_instance();
        $func->load->model("main");
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $BC = array("BC23", "BC27");
        #VIEW FORM REALISASI
        if ($bagian == "realisasi") {
            $SQL = "SELECT NOMOR_DOK_INTERNAL, TANGGAL_DOK_INTERNAL, DATE_FORMAT(TANGGAL_REALISASI,'%Y-%m-%d') TANGGAL_REALISASI,
                   DATE_FORMAT(TANGGAL_REALISASI,'%H:%i') WAKTU FROM T_" . $dok . "_HDR 
                   WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $aju . "'";
            $rs = $this->db->query($SQL);
            foreach ($rs->result_array() as $a => $b) {
                $DATAREALISASI[$a] = $b;
            }
            if (in_array($dok, $BC)) {
                $data = array("judul" => "Revisi Bukti Penerimaan", "DATA" => $DATAREALISASI);
                echo $this->load->view('tools/realisasi_in', $data, true);
            } else {
                $data = array("judul" => "Revisi Bukti Pengeluaran", "DATA" => $DATAREALISASI);
                echo $this->load->view('tools/realisasi_out', $data, true);
            }
        }
        #VIEW DOKUMEN PABEAN
        else {
            if (in_array($dok, $BC))
                $controler = "pemasukan";
            else
                $controler = "pengeluaran";
            $func->load->model(strtolower($dok) . "/" . $bagian . "_act");
            switch ($bagian) {
                case "header":$data = $func->header_act->get_header($aju);
                    break;
                case "barang":$data = $func->barang_act->get_barang($aju);
                    break;
                case "kemasan":$data = $func->kemasan_act->get_kemasan($aju);
                    break;
                case "dokumen":$data = $func->dokumen_act->get_dokumen($aju);
                    break;
                case "kontainer":$data = $func->kontainer_act->get_kontainer($aju);
                    break;
                case "ppnpenyerahan":$data = $func->ppnpenyerahan_act->get_ppnpenyerahan($aju);
                    break;
                case "barang_jadi":$data = $func->barang_jadi_act->get_barang_jadi($aju);
                    break;
            }
            if (!in_array($bagian, array("header", "ppnpenyerahan"))) {
                if ($aju) {
                    $func->load->model(strtolower($dok) . "/detil_act");
                    $arrdata = $func->detil_act->detil($bagian, strtolower($dok), $aju, 'edit', '');
                    $list = $this->load->view('list', $arrdata, true);
                }
                if ($aju)
                    $data = array_merge(array('list' => $list));
                    //$data = array_merge($data, array('list' => $list));
            }
            switch ($dok) {
                case "BC23":$js = "bc23.js";
                    break;
                case "BC27":$js = "bc27.js";
                    break;
                case "BC25":$js = "bc25Barang.js";
                    break;
                case "BC30":$js = "bc30Barang.js";
                    break;
            }
            $data["sess"]["STATUS_DOK"] = "LENGKAP";
            $form = '<script type="text/javascript" src="' . base_url() . 'js/' . $js . '"></script>';
            $form.= '<div class="content_luar"><div class="content_dalam">';
            $form.= $this->load->view($controler . "/" . strtolower($dok) . "/" . $bagian, $data, true);
            $form.= '</div></div>';
            echo $form;
        }
    }

    #EKSEKUSI REVISI DOKUMEN PABEAN

    function eksekusirevisidokumen($ACT = "", $DOK = "", $AJU = "", $ALASAN = "", $POSTBARANG = "", $param="") {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        if (strtolower($_SERVER['REQUEST_METHOD']) == "post" && $ACT != "databarang") {
            $DOK = $this->input->post('DOK_PABEAN');
            $AJU = $this->input->post('NOMOR_AJU');
            $ALASAN = $this->input->post('ALASAN');
        }
        $ret = "MSG#ERR#Proses data Gagal";
        #REVISI REALISASI PENERIMAAN & PENGELUARAN PABEAN
        if ($ACT == "realisasi") {
            $TIPE = $this->input->post('TIPE');
            $pemasukan = array("BC23", "BC27MASUK");
            $pengeluaran = array("BC25", "BC27KELUAR", "BC30");
            if ($DOK == "BC27") {
                $SQL = "SELECT TIPE_DOK FROM T_BC27_HDR WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "'";
                $rs = $this->db->query($SQL);
                if ($rs->num_rows() > 0) {
                    $TIPE_DOK = $rs->row()->TIPE_DOK;
                }
                $TIPEDOKUMEN = $DOK . $TIPE_DOK;
            } else {
                $TIPEDOKUMEN = $DOK;
            }

            foreach ($this->input->post("REALISASI") as $a => $b) {
                $DATAREALISASI[$a] = $b;
            }
            $TGLREALIASASI         = $this->input->post("TANGGAL_REALISASI") . ' ' . $this->input->post("WAKTU");
            $TGLREALIASASIHIDDEN   = $this->input->post('TANGGAL_REALISASI_HIDDEN');
            $DATAREALISASI['TANGGAL_REALISASI'] = $TGLREALIASASI;
			unset($DATAREALISASI['TIPE_DOK']);

            $this->db->where(array(
                                'NOMOR_AJU'     => $AJU, 
                                'KODE_TRADER'   => $KODE_TRADER
                            ));
            if ($this->db->update('T_' . $DOK . '_HDR', $DATAREALISASI)) {
                if ($this->input->post("TANGGAL_REALISASI")) {
                    $this->db->where(array(
                                        'NOMOR_AJU'     => $AJU, 
                                        'KODE_TRADER'   => $KODE_TRADER, 
                                        'KODE_DOKUMEN'  => $DOK
                                    ));
                    $this->db->update('M_TRADER_BARANG_INOUT', array("TANGGAL" => $TGLREALIASASI));
                    if (in_array(strtoupper($TIPEDOKUMEN), $pemasukan)) {
                        $this->db->where(array(
                                            'JENIS_DOK'     => $DOK, 
                                            'KODE_TRADER'   => $KODE_TRADER, 
                                            'TGL_MASUK'     => $TGLREALIASASIHIDDEN
                                        ));
                        $this->db->update('t_logbook_pemasukan', array('TGL_MASUK' => $this->input->post('TANGGAL_REALISASI')));
                    } elseif (in_array(strtoupper($TIPEDOKUMEN), $pengeluaran)) {
                        $this->db->where(array(
                                            'JENIS_DOK'     => $DOK, 
                                            'KODE_TRADER'   => $KODE_TRADER, 
                                            'TGL_MASUK'     => $TGLREALIASASIHIDDEN
                                        ));
                        $this->db->update('t_logbook_pengeluaran', array('TGL_MASUK' => $this->input->post('TANGGAL_REALISASI')));
                    }
                    $this->db->where(array(
                                        'JENIS_DOK'         => $DOK, 
                                        'KODE_TRADER'       => $KODE_TRADER, 
                                        'NOMOR_AJU'         => $AJU,
                                        'NO_DOK_INTERNAL'   => $this->input->post('NO_DOK_INTERNAL_HIDDEN'),
                                        'TGL_DOK_INTERNAL'  => $this->input->post('TANGGAL_DOK_INTERNAL_HIDDEN'),
                                        'TGL_REALISASI'     => $TGLREALIASASIHIDDEN . " " . $this->input->post('WAKTU_HIDDEN')));
                    $this->db->update('t_realisasi_parsial_hdr', array(
                                                                    'NO_DOK_INTERNAL'   => $DATAREALISASI['NOMOR_DOK_INTERNAL'],
                                                                    'TGL_DOK_INTERNAL'  => $DATAREALISASI['TANGGAL_DOK_INTERNAL'],
                                                                    'TGL_REALISASI'     => $DATAREALISASI['TANGGAL_REALISASI']
                                                                ));
                }
                $ret = "MSG#OK#Proses Revisi Bukti Realisasi Berhasil";
            }
            echo $ret;
        }
        #REVISI UBAH KE DRAFT
        elseif ($ACT == "todraft") {
            $pemasukan = array('BC23', 'BC27MASUK');
            $pengeluaran = array('BC25', 'BC27KELUAR', 'BC30');
            if ($DOK == "BC27") {
                $SQL = "SELECT TIPE_DOK FROM T_BC27_HDR WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "'";
                $rs = $this->db->query($SQL);
                if ($rs->num_rows() > 0) {
                    $TIPE_DOK = $rs->row()->TIPE_DOK;
                }
                $TIPEDOKUMEN = $DOK . $TIPE_DOK;
            } else {
                $TIPEDOKUMEN = $DOK;
            }
            if (in_array(strtoupper(str_replace(" ","",$TIPEDOKUMEN)), $pemasukan)) {
                #CEK STOCK
                if (strtoupper($TIPEDOKUMEN) == "BC23") {
                    $SQL = "SELECT A.JUMLAH_SATUAN, A.KODE_BARANG, A.JENIS_BARANG 'JNS_BARANG' FROM T_" . $DOK . "_DTL A, T_" . $DOK . "_HDR B 
							WHERE B.NOMOR_AJU='" . $AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' 
							AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER";
                } elseif (strtoupper($TIPEDOKUMEN) == "BC27") {
                    $SQL = "SELECT A.JUMLAH_SATUAN, A.KODE_BARANG, A.JNS_BARANG FROM T_" . $DOK . "_DTL A, T_" . $DOK . "_HDR B
							WHERE B.NOMOR_AJU='" . $AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' 
							AND A.NOMOR_AJU = B.NOMOR_AJU AND A.KODE_TRADER = B.KODE_TRADER";
                }
                $hasil = $func->main->get_result($SQL);
                if ($hasil) {
                    $stk = "";
                    foreach ($SQL->result_array() as $row) {
                        $SQL = "SELECT STOCK_AKHIR FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $row["KODE_BARANG"] . "' 
								AND JNS_BARANG='" . $row["JNS_BARANG"] . "' 
								AND KODE_TRADER='" . $KODE_TRADER . "'";
                        $VAL = $this->db->query($SQL)->row();
                        $STOCK_AKHIR = $VAL->STOCK_AKHIR;
                        if ($row["JUMLAH_SATUAN"] > $STOCK_AKHIR) {
                            $stk = $stk . '' . $row["KODE_BARANG"] . ' stocknya: ' . $STOCK_AKHIR . ', ';
                        }
                    }
                }
                if ($stk) {
                    echo "MSG#ERR#Revisi Gagal.<br>Stock kode barang berikut kurang untuk direverse pengurangan:<br>" . $stk;
                    die();
                }
            }
            $SQL = "UPDATE T_" . $DOK . "_HDR SET STATUS='00', NOMOR_DOK_INTERNAL = NULL, TANGGAL_DOK_INTERNAL = NULL,
					TANGGAL_REALISASI = NULL, STATUS_REALISASI = 'N' WHERE NOMOR_AJU='" . $AJU . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
            $execheader = $this->db->query($SQL);
            if ($execheader) {
                $ret = "MSG#ERR#Proses data Gagal";
                if (in_array(strtoupper(str_replace(" ","",$TIPEDOKUMEN)), $pemasukan)) {
                    $SQL = "SELECT REALISASIID FROM t_realisasi_parsial_hdr WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "' 
							AND JENIS_DOK='" . strtoupper($DOK) . "'";
                    $hasil = $func->main->get_result($SQL);
                    if ($hasil) {
                        foreach ($SQL->result_array() as $row) {
                            $this->db->where(array('HDR_REFF' => $row["REALISASIID"]));
                            $parsialdtl = $this->db->delete('t_realisasi_parsial_dtl');
                            if ($parsialdtl) {
                                $this->db->where(array('REALISASIID' => $row["REALISASIID"]));
                                $this->db->delete('t_realisasi_parsial_hdr');
                            }
                        }
                    }

                    $SQL = "SELECT KODE_BARANG,JNS_BARANG,JUMLAH, NOMOR_AJU FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='" . $KODE_TRADER . "' 
							AND NOMOR_AJU='" . $AJU . "' AND KODE_DOKUMEN='" . $DOK . "' AND TIPE='GATE-IN'";
                    $hasil = $func->main->get_result($SQL);
                    if ($hasil) {
                        foreach ($SQL->result_array() as $row) {
							$this->db->set('STOCK_AKHIR','STOCK_AKHIR - '.$row["JUMLAH"],FALSE);
							$this->db->where(array(
													'KODE_TRADER'	=> $KODE_TRADER,
													'KODE_BARANG'	=> $row['KODE_BARANG'],
													'JNS_BARANG'	=> $row['JNS_BARANG']
							));
							$updatebrg = $this->db->update('M_TRADER_BARANG');
                            $DATAABRANG = $DATAABRANG . $row["KODE_BARANG"] . ':' . $row["JUMLAH"] . ', ';
                        }
                        if ($updatebrg) {
                            $SQL = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN, DATE_FORMAT(TANGGAL_REALISASI,'%Y-%m-%d') AS TGL_REALISASI 
									FROM t_" . $DOK . "_hdr WHERE NOMOR_AJU = '" . $AJU . "'
									AND KODE_TRADER = '" . $KODE_TRADER . "'";
                            $rs = $this->db->query($SQL);
                            if ($rs->num_rows() > 0) {
                                $TGLMASUK = $rs->row()->TGL_REALISASI;
                                $NODAF = $rs->row()->NOMOR_PENDAFTARAN;
                                $TGDAF = $rs->row()->TANGGAL_PENDAFTARAN;
                            }

                            $this->db->where(array(
													'KODE_TRADER' 	=> $KODE_TRADER, 
													'NO_DOK' 		=> $NODAF,
													'TGL_DOK' 		=> $TGDAF, 
													'JENIS_DOK' 	=> $DOK, 
													"NOMOR_AJU"		=> $row['NOMOR_AJU']
							));
                            $this->db->delete('T_LOGBOOK_PEMASUKAN');

                            $this->db->where(array(
													'KODE_TRADER' 	=> $KODE_TRADER, 
													'NOMOR_AJU' 	=> $AJU,
													'KODE_DOKUMEN' 	=> $DOK,
													'TIPE' 			=> 'GATE-IN'
							));
                            $this->db->delete('M_TRADER_BARANG_INOUT');
                        }
                    }
                    $func->main->activity_log('UBAH KE DRAFT ' . $DOK, 'REVISI DOKUMEN PABEAN ' . $DOK . ', CAR=' . $AJU);
                    $func->main->revisi_log('REVISI DOKUMEN PABEAN ' . $DOK, 'UBAH KE DRAFT ' . $DOK . ', CAR=' . $AJU . ', BARANG=' . $DATAABRANG, $ALASAN);
                    $ret = "MSG#OK#Proses Revisi Dokumen Pemasukan '" . $DOK . "' Berhasil";
                } 
				else if (in_array(strtoupper($TIPEDOKUMEN), $pengeluaran)) {
                    $SQL = "SELECT REALISASIID FROM t_realisasi_parsial_hdr WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "' 
							AND JENIS_DOK='" . strtoupper($DOK) . "'";
                    $hasil = $func->main->get_result($SQL);
                    if ($hasil) {
                        foreach ($SQL->result_array() as $row) {
                            $this->db->where(array('HDR_REFF' => $row["REALISASIID"]));
                            $parsialdtl = $this->db->delete('t_realisasi_parsial_dtl');
                            if ($parsialdtl) {
                                $this->db->where(array('REALISASIID' => $row["REALISASIID"]));
                                $this->db->delete('t_realisasi_parsial_hdr');
                            }
                        }
                    }

                    $SQL = "SELECT KODE_BARANG,JNS_BARANG,JUMLAH FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='" . $KODE_TRADER . "' 
							AND NOMOR_AJU='" . $AJU . "' AND KODE_DOKUMEN='" . $DOK . "' AND TIPE='GATE-OUT'";
                    $hasil = $func->main->get_result($SQL);
                    if ($hasil) {
                        foreach ($SQL->result_array() as $row) {
                            $SQL = "UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR + " . $row["JUMLAH"] . " 
									WHERE KODE_TRADER='" . $KODE_TRADER . "'
									AND KODE_BARANG='" . $row["KODE_BARANG"] . "' AND JNS_BARANG='" . $row["JNS_BARANG"] . "'";
                            $updatebrg = $this->db->query($SQL);
                            $DATAABRANG = $DATAABRANG . $row["KODE_BARANG"] . ':' . $row["JUMLAH"] . ', ';
                        }
                        if ($updatebrg) {
                            $SQL = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN, DATE_FORMAT(TANGGAL_REALISASI,'%Y-%m-%d') AS TGL_REALISASI 
									FROM t_" . $DOK . "_hdr WHERE NOMOR_AJU = '" . $AJU . "'
									AND KODE_TRADER = '" . $KODE_TRADER . "'";
                            $rs = $this->db->query($SQL);
                            if ($rs->num_rows() > 0) {
                                $TGLMASUK = $rs->row()->TGL_REALISASI;
                                $NODAF = $rs->row()->NOMOR_PENDAFTARAN;
                                $TGDAF = $rs->row()->TANGGAL_PENDAFTARAN;
                            }
							
							$SQIN = "SELECT LOGID, LOGID_MASUK, NO_DOK_MASUK, TGL_DOK_MASUK, JENIS_DOK_MASUK, KODE_BARANG, JUMLAH, JNS_BARANG
									FROM T_LOGBOOK_PENGELUARAN WHERE NO_DOK = '" . $NODAF . "' AND TGL_DOK = '".$TGDAF."'
									AND KODE_TRADER = '" . $KODE_TRADER . "'";
                            $rsIN = $this->db->query($SQIN);
                            if ($rsIN->num_rows() > 0) {
                                foreach ($rsIN->result() as $DATA){
                                    $SQL = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO = SALDO + ".$DATA->JUMLAH.", FLAG_TUTUP = NULL 
                                            WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$DATA->NO_DOK_MASUK."'
                                            AND TGL_DOK='".$DATA->TGL_DOK_MASUK."' 
                                            AND KODE_BARANG='".$DATA->KODE_BARANG."'
                                            AND JNS_BARANG='".$DATA->JNS_BARANG."'
                                            AND JENIS_DOK='".$DATA->JENIS_DOK_MASUK."' 
											AND LOGID = ".$DATA->LOGID_MASUK;
                                    if($this->db->query($SQL)){
                                        $this->db->where(array( 'KODE_TRADER' => $KODE_TRADER, 'NO_DOK' => $NODAF,
                                                                'TGL_DOK' => $TGDAF, 'JENIS_DOK' => $DOK,'KODE_BARANG'=>$DATA->KODE_BARANG,
                                                                'JNS_BARANG'=>$DATA->JNS_BARANG,'LOGID'=>$DATA->LOGID));
                                        $this->db->delete('T_LOGBOOK_PENGELUARAN'); 
                                    }
                                }
								
                            } 
                            $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'NOMOR_AJU' => $AJU,'KODE_DOKUMEN' => $DOK, 'TIPE' => 'GATE-OUT'));
                            $this->db->delete('M_TRADER_BARANG_INOUT');
                        }
                    }
                    $func->main->activity_log('UBAH KE DRAFT ' . $DOK, 'REVISI DOKUMEN PABEAN ' . $DOK . ', CAR=' . $AJU);
                    $func->main->revisi_log('REVISI DOKUMEN PABEAN ' . $DOK, 'UBAH KE DRAFT ' . strtoupper($DOK) . ', CAR=' . $AJU . ', BARANG=' . $DATAABRANG, $ALASAN);
                    $ret = "MSG#OK#Proses Revisi Dokumen Pengeluaran '" . $DOK . "' Berhasil";
                }
            }
            echo $ret;
        }
        #REVISI DATA BARANG
        elseif ($ACT == "databarang") {
            if ($DOK == "BC27") {
                $SQL = "SELECT TIPE_DOK FROM T_BC27_HDR WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "'";
                $rs = $this->db->query($SQL);
                if ($rs->num_rows() > 0) {
                    $TIPE_DOK = $rs->row()->TIPE_DOK;
                }
                $TIPEDOKUMEN = $DOK . $TIPE_DOK;
            } else {
                $TIPEDOKUMEN = $DOK;
            }
            $pemasukan = array('BC23', 'BC27MASUK');
            $pengeluaran = array('BC25', 'BC27KELUAR', 'BC30');

            $SQL = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN, TANGGAL_REALISASI, NDPBM, KODE_VALUTA
				   FROM T_" . $DOK . "_HDR WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "'";
            $RS = $this->db->query($SQL)->row();
            $NOMOR_PENDAFTARAN = $RS->NOMOR_PENDAFTARAN;
            $TANGGAL_PENDAFTARAN = $RS->TANGGAL_PENDAFTARAN;
            $TANGGAL_REALISASI = $RS->TANGGAL_REALISASI;
            $NDPBM = $RS->NDPBM;
            $KODE_VALUTA = $RS->KODE_VALUTA;
			
            $KODE_BARANG = $POSTBARANG["KODE_BARANG"];

            if ($DOK == "BC23")
                $JNS_BARANG = $POSTBARANG["JENIS_BARANG"];
            else
                $JNS_BARANG = $POSTBARANG["JNS_BARANG"];

            $JUMLAH_SATUAN = $POSTBARANG["JUMLAH_SATUAN"];
            $KODE_SATUAN = $POSTBARANG["KODE_SATUAN"];

            #$SERI = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM M_TRADER_BARANG_INOUT", "MAXSERI") + 1;
            $SQL = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
				   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $KODE_BARANG . "' 
				   AND JNS_BARANG='" . $JNS_BARANG . "' AND KODE_TRADER='" . $KODE_TRADER . "'";

            $VALBRG = $this->db->query($SQL)->row();
            $STOCK_AKHIR = $VALBRG->STOCK_AKHIR;
            $KODE_SATUAN_BESAR = $VALBRG->KODE_SATUAN;
            $KODE_SATUAN_TERKECIL = $VALBRG->KODE_SATUAN_TERKECIL;
            $JML_SATUAN_TERKECIL = $VALBRG->JML_SATUAN_TERKECIL;

            if (empty($JML_SATUAN_TERKECIL))
                $JML_SATUAN_TERKECIL = 1;
            $JUMLAH_BARANG = $JUMLAH_SATUAN * $JML_SATUAN_TERKECIL;

            if ($KODE_SATUAN_TERKECIL) {
                if (strtoupper($KODE_SATUAN) == strtoupper($KODE_SATUAN_TERKECIL)) {
                    $JUMLAH_BARANG = $JUMLAH_SATUAN;
                } elseif (strtoupper($KODE_SATUAN) == strtoupper($KODE_SATUAN_BESAR)) {
                    if (empty($JML_SATUAN_TERKECIL))
                        $JML_SATUAN_TERKECIL = 1;
                    $JUMLAH_BARANG = $JUMLAH_SATUAN * $JML_SATUAN_TERKECIL;
                }else {
                    $JUMLAH_BARANG = $JUMLAH_SATUAN;
                }
            } else {
                $JUMLAH_BARANG = $JUMLAH_SATUAN;
            }
            $INOUT["TANGGAL"] = $TANGGAL_REALISASI;
            $INOUT["TANGGAL_DOKUMEN"] = $TANGGAL_PENDAFTARAN;
            $INOUT["KODE_DOKUMEN"] = $DOK;
            $INOUT["NOMOR_AJU"] = $AJU;
            $INOUT["JUMLAH"] = $JUMLAH_BARANG;
            $INOUT["KODE_TRADER"] = $KODE_TRADER;
            $INOUT["KODE_BARANG"] = $KODE_BARANG;
            $INOUT["JNS_BARANG"] = $JNS_BARANG;
            $INOUT["CREATED_TIME"] = date("Y-m-d H:i:s");
			
			$LOG['JENIS_DOK'] 		= $DOK;
			$LOG['NO_DOK'] 			= $NOMOR_PENDAFTARAN;
			$LOG['TGL_DOK'] 		= $TANGGAL_PENDAFTARAN;
			$LOG['TGL_MASUK'] 		= $TANGGAL_REALISASI;
			$LOG['KODE_TRADER'] 	= $KODE_TRADER;
			$LOG['KODE_BARANG'] 	= $KODE_BARANG;
			$LOG['JNS_BARANG'] 		= $JNS_BARANG;
			$LOG['SERI_BARANG'] 	= $POSTBARANG["SERI"];
			$LOG['NAMA_BARANG'] 	= $POSTBARANG["URAIAN_BARANG"];
			$LOG['SATUAN'] 			= $KODE_SATUAN_TERKECIL;
			$LOG['JUMLAH'] 			= $JUMLAH_BARANG;
			$LOG['NILAI_PABEAN'] 	= $POSTBARANG["CIF"] * $NDPBM;
			$LOG['SALDO'] 			= $JUMLAH_BARANG;
			$LOG['NOMOR_AJU'] 		= $AJU;
			$LOG['KODE_VALUTA'] 	= $KODE_VALUTA;
			$LOG['NDPBM'] 			= $NDPBM;
            #REVISI BARANG PEMASUKAN	
            if (in_array(strtoupper($TIPEDOKUMEN), $pemasukan)) {
                if ($POSTBARANG["TIPE_REVISI"] == "ADD") {
                    $INOUT["TIPE"] = "GATE-IN";
					$this->db->where(array(
											"KODE_BARANG" => $KODE_BARANG, 
											"JNS_BARANG" => $JNS_BARANG,
											"KODE_TRADER" => $KODE_TRADER
					));
                    $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMLAH_BARANG + $STOCK_AKHIR));
                    $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                    $this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);
                } elseif ($POSTBARANG["TIPE_REVISI"] == "EDIT") {
                    $INOUT["TIPE"] = "GATE-IN";
                    $SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_INOUT WHERE KODE_BARANG='" . $KODE_BARANG . "'
							AND JNS_BARANG='" . $JNS_BARANG . "' AND NOMOR_AJU='" . $AJU . "' AND KODE_TRADER='" . $KODE_TRADER . "' 
							AND SERI_DOKUMEN = '".$POSTBARANG["SERI"]."'";
                    $hasil = $func->main->get_result($SQL);
                    if ($hasil) {
						#kurangi datangi barang
						$this->db->set("STOCK_AKHIR","STOCK_AKHIR - ".$POSTBARANG["JUMLAH_SATUAN_ASLI"],FALSE);
						$this->db->where(array(
												"KODE_BARANG"	=> $KODE_BARANG,
												"JNS_BARANG"	=> $JNS_BARANG,
												"KODE_TRADER"	=> $KODE_TRADER
						));
						#tambah data barang
						$this->db->set("STOCK_AKHIR","STOCK_AKHIR + ".$JUMLAH_BARANG,FALSE);
						$this->db->where(array(
												"KODE_BARANG"	=> $KODE_BARANG,
												"JNS_BARANG"	=> $JNS_BARANG,
												"KODE_TRADER"	=> $KODE_TRADER
						));
                        $this->db->update("M_TRADER_BARANG");
						#update inout
						$this->db->where(array(
												"KODE_BARANG" 	=> $KODE_BARANG, 
										  		"JNS_BARANG" 	=> $JNS_BARANG, 
												"KODE_TRADER" 	=> $KODE_TRADER,
                            					"NOMOR_AJU" 	=> $AJU,
												"SERI_DOKUMEN"	=> $POSTBARANG["SERI"]
						));
                        $this->db->update('M_TRADER_BARANG_INOUT', array('JUMLAH' => $JUMLAH_BARANG));
                    } else {
						#delete inout
						$this->db->where(array(
												"KODE_BARANG" 	=> $POSTBARANG["KODE_BARANG_ASLI"],
                            					"JNS_BARANG" 	=> $POSTBARANG["JENIS_BARANG_ASLI"],
                           						 "KODE_TRADER" 	=> $KODE_TRADER, 
												 "NOMOR_AJU" 	=> $AJU,
												 "SERI_DOKUMEN" => $POSTBARANG["SERI"]
						));
                        $DELEXEC = $this->db->delete('M_TRADER_BARANG_INOUT');
                        if ($DELEXEC) {
							#kurangi data barang
							$this->db->set("STOCK_AKHIR","STOCK_AKHIR - ".$POSTBARANG['JUMLAH_SATUAN_ASLI'],FALSE);
							$this->db->where(array(
													"KODE_BARANG"	=> $POSTBARANG["KODE_BARANG_ASLI"],
													"JNS_BARANG"	=> $POSTBARANG["JENIS_BARANG_ASLI"],
													"KODE_TRADER"	=> $KODE_TRADER
							));
							$this->db->update("M_TRADER_BARANG");
                        }
						#tambah data barang
						$this->db->set("STOCK_AKHIR","STOCK_AKHIR + ".$JUMLAH_BARANG,FALSE);
						$this->db->where(array(
												"KODE_BARANG"	=> $KODE_BARANG,
												"JNS_BARANG"	=> $JNS_BARANG,
												"KODE_TRADER"	=> $KODE_TRADER
						));
						$this->db->update("M_TRADER_BARANG");
                        $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                    }
                } elseif ($POSTBARANG["TIPE_REVISI"] == "DELETE") {
					$this->db->where(array(
												"KODE_BARANG"	=> $KODE_BARANG,
												"JNS_BARANG"	=> $JNS_BARANG,
												"KODE_TRADER"	=> $KODE_TRADER,
												"NOMOR_AJU"		=> $AJU,
												"SERI_DOKUMEN"	=> $POSTBARANG["SERI"]
											)
									);
                    $DELEXEC = $this->db->delete('M_TRADER_BARANG_INOUT');
                    if ($DELEXEC) {
                        $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR-" . $JUMLAH_SATUAN . "
										  WHERE KODE_BARANG='" . $KODE_BARANG . "' AND JNS_BARANG='" . $JNS_BARANG . "' 
										  AND KODE_TRADER='" . $KODE_TRADER . "'");
						$this->db->where(array(
												"KODE_TRADER"	=> $KODE_TRADER,
												"KODE_BARANG"	=> $KODE_BARANG,
												"JNS_BARANG"	=> $JNS_BARANG,
												"SERI_BARANG"	=> $param,
												"NO_DOK"		=> $NOMOR_PENDAFTARAN,
												"TGL_DOK"		=> $TANGGAL_PENDAFTARAN
											)
										);
						$this->db->delete("T_LOGBOOK_PEMASUKAN");
                    }
                }
                $func->main->activity_log($POSTBARANG["TIPE_REVISI"] . ' DETIL ' . $DOK, 'REVISI DOKUMEN PABEAN ' . $DOK . ', CAR=' . $AJU);
                $func->main->revisi_log('REVISI DOKUMEN PABEAN ' . $DOK, $POSTBARANG["TIPE_REVISI"] . ' DETIL' . $DOK . ', CAR=' . $AJU . ', BARANG=' . $KODE_BARANG . ' JNS BARANG=' . $JNS_BARANG . ' JUMLAH=' . $JUMLAH_BARANG, $ALASAN);
            }
            #REVISI BARANG PENGELUARAN
            else if (in_array(strtoupper($TIPEDOKUMEN), $pengeluaran)) {
                if ($POSTBARANG["TIPE_REVISI"] == "ADD") {
                    $INOUT["TIPE"] = "GATE-OUT";
                    $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $STOCK_AKHIR - $JUMLAH_BARANG), array("KODE_BARANG" => $KODE_BARANG, "JNS_BARANG" => $JNS_BARANG, "KODE_TRADER" => $KODE_TRADER));
                    $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                } elseif ($POSTBARANG["TIPE_REVISI"] == "EDIT") {
                    $INOUT["TIPE"] = "GATE-OUT";
                    $SQL = "SELECT KODE_BARANG FROM M_TRADER_BARANG_INOUT WHERE KODE_BARANG='" . $KODE_BARANG . "'
							AND JNS_BARANG='" . $JNS_BARANG . "' AND NOMOR_AJU='" . $AJU . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $hasil = $func->main->get_result($SQL);
                    if ($hasil) {
                        $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR+" . $POSTBARANG["JUMLAH_SATUAN_ASLI"] . "
										  WHERE KODE_BARANG='" . $KODE_BARANG . "' AND JNS_BARANG='" . $JNS_BARANG . "' 
										  AND KODE_TRADER='" . $KODE_TRADER . "'");

                        $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR-" . $JUMLAH_BARANG . "
										  WHERE KODE_BARANG='" . $KODE_BARANG . "' AND JNS_BARANG='" . $JNS_BARANG . "' 
										  AND KODE_TRADER='" . $KODE_TRADER . "'");
                        $this->db->update('M_TRADER_BARANG_INOUT', array(
																			'JUMLAH' => $JUMLAH_BARANG
																		), 
																	array(
																			"KODE_BARANG" => $KODE_BARANG, 
																			"JNS_BARANG" => $JNS_BARANG, 
																			"KODE_TRADER" => $KODE_TRADER,
																			"SERI_DOKUMEN"=>$POSTBARANG["SERI"],
																			"NOMOR_AJU" => $AJU
																		)
											);
                    } else {
                        $DELEXEC = $this->db->delete('M_TRADER_BARANG_INOUT', array("KODE_BARANG" => $POSTBARANG["KODE_BARANG_ASLI"],
                            "JNS_BARANG" => $POSTBARANG["JENIS_BARANG_ASLI"],
                            "KODE_TRADER" => $KODE_TRADER, "NOMOR_AJU" => $AJU));
                        if ($DELEXEC) {
                            $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR+" . $POSTBARANG["JUMLAH_SATUAN_ASLI"] . "
									WHERE KODE_BARANG='" . $POSTBARANG["KODE_BARANG_ASLI"] . "' AND JNS_BARANG='" . $POSTBARANG["JENIS_BARANG_ASLI"] . "' 
									AND KODE_TRADER='" . $KODE_TRADER . "'");
                        }

                        $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR-" . $JUMLAH_BARANG . "
										  WHERE KODE_BARANG='" . $KODE_BARANG . "' AND JNS_BARANG='" . $JNS_BARANG . "' 
										  AND KODE_TRADER='" . $KODE_TRADER . "'");
                        $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                    }
                } elseif ($POSTBARANG["TIPE_REVISI"] == "DELETE") {
					$this->db->where(array(
												"KODE_BARANG"	=> $KODE_BARANG,
												"JNS_BARANG"	=> $JNS_BARANG,
												"KODE_TRADER"	=> $KODE_TRADER,
												"NOMOR_AJU"		=> $NOMOR_AJU,
												"SERI_DOKUMEN"	=> $param
											)
									);
                    $DELEXEC = $this->db->delete('M_TRADER_BARANG_INOUT');
                    if ($DELEXEC) {
                        $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR+" . $JUMLAH_SATUAN . "
										  WHERE KODE_BARANG='" . $KODE_BARANG . "' AND JNS_BARANG='" . $JNS_BARANG . "' 
										  AND KODE_TRADER='" . $KODE_TRADER . "'");
						$sql = 'SELECT JUMLAH, LOGID_MASUK FROM t_logbook_pengeluaran WHERE KODE_TRADER="'.$KODE_TRADER.'" 
								AND NOMOR_AJU = "'.$AJU.'" AND SERI_BARANG = "'.$param.'"';
						$doSql = $this->db->query($sql);
						foreach($doSql->result_array() as $datas){
							$this->db->set("SALDO","SALDO + ".$datas["JUMLAH"],FALSE);
							$this->db->set("FLAG_TUTUP","(NULL)",FALSE);
							$this->db->where(array("LOGID"	=> $datas['LOGID_MASUK']));
							$this->db->update("t_logbook_pemasukan");
						}
						$this->db->where(array(
												"KODE_TRADER"	=> $KODE_TRADER,
												"KODE_BARANG"	=> $KODE_BARANG,
												"JNS_BARANG"	=> $JNS_BARANG,
												"SERI_BARANG"	=> $param,
												"NO_DOK"		=> $NOMOR_PENDAFTARAN,
												"TGL_DOK"		=> $TANGGAL_PENDAFTARAN
											)
										);
						$this->db->delete("T_LOGBOOK_PENGELUARAN");
                    }
                }
                $func->main->activity_log($POSTBARANG["TIPE_REVISI"] . ' DETIL ' . $DOK, 'REVISI DOKUMEN PABEAN ' . $DOK . ', CAR=' . $AJU);
                $func->main->revisi_log('REVISI DOKUMEN PABEAN ' . $DOK, $POSTBARANG["TIPE_REVISI"] . ' DETIL' . $DOK . ', CAR=' . $AJU . ', BARANG=' . $KODE_BARANG . ' JNS BARANG=' . $JNS_BARANG . ' JUMLAH=' . $JUMLAH_BARANG, $ALASAN);
            }
        }
    }

    //--------STARTPROSES REVISI DRAFT
    function revisidraft($dokumen="",$aju="",$alasan=""){#echo 's';die();
        $func = get_instance();
        $func->load->model("main");
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $SQL    = "SELECT SERI,SERI_DOKUMEN,KODE_BARANG,JNS_BARANG,KONDISI_BARANG,KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,JUMLAH,TIPE FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' AND NOMOR_AJU='".$aju."' AND KODE_DOKUMEN='".strtoupper($dokumen)."'";
        $hasil  = $this->db->query($SQL)->result_array();
        
        foreach ($hasil as $a => $value) {
            $data[$a] = $value;
        }
        $n = 0;
        $barang = "";
        $stk = "";
        if ($dokumen == "BC27") {
            $SQL = "SELECT TIPE_DOK FROM T_BC27_HDR WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $aju . "'";
            $rs = $this->db->query($SQL);
            $TIPE_DOK = "";
            if ($rs->num_rows() > 0) {
                $TIPE_DOK = $rs->row()->TIPE_DOK;
            }
            $TIPEDOKUMEN = $dokumen . $TIPE_DOK;
        } else {
            $TIPEDOKUMEN = $dokumen;
        }
        $pemasukan = array('BC16', 'BC27MASUK', 'BC33MASUK', 'BC40');
        $pengeluaran = array('BC28', 'BC27KELUAR', 'BC33KELUAR', 'BC41', 'P3BET');
        $logkeluar = "";
        if (in_array(strtoupper($TIPEDOKUMEN), $pemasukan)) {
            $SQL    = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN FROM T_".$dokumen."_HDR WHERE KODE_TRADER='".$KODE_TRADER."' AND NOMOR_AJU='".$aju."'";
            $hasil  = $this->db->query($SQL)->result_array();

            $SQLLOGBOOK   = "SELECT LOGID,NO_DOK,NOMOR_AJU FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$hasil[0]['NOMOR_PENDAFTARAN']."' AND TGL_DOK='".$hasil[0]['TANGGAL_PENDAFTARAN']."'";
            $hasilLogbook  = $this->db->query($SQLLOGBOOK)->result_array();
            if(count($hasilLogbook)>0){
                for($i=0;$i<count($hasilLogbook);$i++){
                    $SQLLOGKELUAR   = "SELECT NO_DOK,NOMOR_AJU FROM T_LOGBOOK_PENGELUARAN WHERE LOGID_MASUK='".$hasilLogbook[$i]['LOGID']."'";
                    $hasilLogKeluar  = $this->db->query($SQLLOGKELUAR)->result_array();
                    if(count($hasilLogKeluar)>0){
                        for($j=0;$j<count($hasilLogKeluar);$j++){
                            $logkeluar .= $hasilLogKeluar[$j]['NOMOR_AJU'].", ";
                        }
                    }
                }
                if($logkeluar != ""){
                    echo "MSG#ERR#Revisi Gagal.<br>Pemasukan ini sudah digunakan oleh pengeluaran berikut :<br>" . $logkeluar;
                    die();
                }
            }
            for($a=0;$a<count($data);$a++){
                $SQL = "SELECT JUMLAH FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='" . $data[$a]["KODE_BARANG"] . "' 
                        AND JNS_BARANG='" . $data[$a]["JNS_BARANG"] . "' AND KODE_GUDANG='" . $data[$a]["KODE_GUDANG"] . "' 
                        AND KODE_RAK='" . $data[$a]["KODE_RAK"] . "' AND KODE_SUB_RAK='" . $data[$a]["KODE_SUB_RAK"] . "'
                        AND KONDISI_BARANG='" . $data[$a]["KONDISI_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                $VAL = $this->db->query($SQL)->row();
                $STOCK_BARANG = $VAL->JUMLAH;
                if ($data[$a]["JUMLAH"] > $STOCK_BARANG) {
                    $stk = $stk . '' . $data[$a]["KODE_BARANG"] . ' stocknya: ' . $STOCK_BARANG . ', ';
                }
            }
        }
        
        if ($stk!="") {
            echo "MSG#ERR#Revisi Gagal.<br>Stock kode barang berikut kurang untuk direverse pengurangan:<br>" . $stk;
            die();
        }else{
            for($i=0;$i<count($data);$i++){
                #echo $data[$i]['KODE_BARANG']."<br>";
                if($data[$i]['TIPE']=="GATE-IN"){
                    $this->db->set('JUMLAH','JUMLAH - '.$data[$i]["JUMLAH"],FALSE);    
                }elseif($data[$i]['TIPE']=="GATE-OUT"){
                    $this->db->set('JUMLAH','JUMLAH + '.$data[$i]["JUMLAH"],FALSE);
                }
                
                $this->db->where(array(
                                        'KODE_TRADER'   => $KODE_TRADER,
                                        'KODE_BARANG'   => $data[$i]['KODE_BARANG'],
                                        'JNS_BARANG'    => $data[$i]['JNS_BARANG'],
                                        'KONDISI_BARANG'=> $data[$i]['KONDISI_BARANG'],
                                        'KODE_GUDANG'   => $data[$i]['KODE_GUDANG'],
                                        'KODE_RAK'      => $data[$i]['KODE_RAK'],
                                        'KODE_SUB_RAK'  => $data[$i]['KODE_SUB_RAK'],
                                    ));
                $updatebrg = $this->db->update('M_TRADER_BARANG_GUDANG');
                if($updatebrg){
                    $n++;
                    $this->db->where(array(
                                            'SERI' => $data[$i]['SERI']
                                    ));
                    $deletinout = $this->db->delete('M_TRADER_BARANG_INOUT');

                    if($deletinout){
                        if($data[$i]['TIPE']=="GATE-IN"){
                            $this->db->where(array(
                                                'SERI_BARANG'   => $data[$i]['SERI_DOKUMEN'],
                                                'NOMOR_AJU'     => $aju
                                        ));
                            $this->db->delete('T_LOGBOOK_PEMASUKAN');
                        }elseif($data[$i]['TIPE']=="GATE-OUT"){
                            $SQL = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN FROM T_" . $dokumen . "_HDR 
                                WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $aju . "'";
                            $rs = $this->db->query($SQL);
                            if ($rs->num_rows() > 0) {
                                $NODAF = $rs->row()->NOMOR_PENDAFTARAN;
                                $TGDAF = $rs->row()->TANGGAL_PENDAFTARAN;
                            }
                            
                            $SQL1 = "SELECT *, JUMLAH AS SALDO FROM T_LOGBOOK_PENGELUARAN 
                                    WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$NODAF."'
                                    AND TGL_DOK='".$TGDAF."' AND JUMLAH IS NOT NULL";
                                    // echo $SQL; die();
                            $hasil1 = $func->main->get_result($SQL1);
                            if ($hasil1) {
                                // echo $SQL; die();
                                foreach ($SQL1->result_array() as $row) {
                                    if ($row["LOGID_MASUK"] == "" || $row["LOGID_MASUK"] == NULL) {
                                        $this->db->set("SALDO","SALDO + ".$row["SALDO"], FALSE);
                                        $this->db->set("FLAG_TUTUP", NULL);
                                        $this->db->where(array(
                                                "NO_DOK"        => $row["NO_DOK_MASUK"],
                                                "TGL_DOK"       => $row["TGL_DOK_MASUK"],
                                                "KODE_BARANG"   => $row["KODE_BARANG"],
                                                "JNS_BARANG"    => $rw["JNS_BARANG"],
                                                "KODE_TRADER"   => $KODE_TRADER
                                        ));
                                        $this->db->update('T_LOGBOOK_PEMASUKAN');
                                    } else {
                                        $this->db->set("SALDO","SALDO + ".$row["SALDO"],FALSE);
                                        $this->db->set("FLAG_TUTUP", NULL);
                                        $this->db->where(array("LOGID"=>$row["LOGID_MASUK"]));
                                        $this->db->update('T_LOGBOOK_PEMASUKAN');
                                    }
                                }
                            }

                            $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'JENIS_DOK' => strtoupper($dokumen),
                                'NO_DOK' => $NODAF, 'TGL_DOK' => $TGDAF));
                            $this->db->delete('T_LOGBOOK_PENGELUARAN');

                        }
                    }
                }
                $barang .= ", BARANG=".$data[$i]['KODE_BARANG']."|".$data[$i]['JNS_BARANG'];
            }
            $SQL = "UPDATE T_".$dokumen."_HDR SET STATUS='00', NOMOR_DOK_INTERNAL = NULL, TANGGAL_DOK_INTERNAL = NULL,
                    TANGGAL_REALISASI = NULL, STATUS_REALISASI = '0' WHERE NOMOR_AJU='" . $aju . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
            $exe = $this->db->query($SQL);
            if($exe){
                $func->main->revisi_log("REVISI DOKUMEN PABEAN ".strtoupper($dokumen),"UBAH KE DRAFT ".strtoupper($dokumen).", CAR=".$aju.$barang,$alasan);
                $ret = "MSG#OK#Data berhasil di kembalikan ke draft, dan stock inventory barang sudah disesuaikan.#".site_url()."/tools/revisi/ajax/".$dokumen;  
                return $ret;  
            }
        }
        
    }
    //--------END REVISI DRAFT

    #REVISI HAPUS
    function deleterevisidokumen() {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $DATA_REVISI = explode('|', $this->input->post('datarevisi'));#echo $DATA_REVISI[0].'=='.$DATA_REVISI[1];die();
        $DOK = strtolower($DATA_REVISI[0]);
        $AJU = $DATA_REVISI[1];
        $ALASAN = $this->input->post('alasan');
        $KODE_LOKASI = $this->input->post('KODE_LOKASI');
        $SQL    = "SELECT SERI,SERI_DOKUMEN,KODE_BARANG,JNS_BARANG,KONDISI_BARANG,KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,JUMLAH,TIPE FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' AND NOMOR_AJU='".$AJU."' AND KODE_DOKUMEN='".strtoupper($DOK)."'";
        $hasil  = $this->db->query($SQL)->result_array();
        
        foreach ($hasil as $a => $value) {
            $data[$a] = $value;
        }
        if ($DOK == "bc27") {
            $SQL = "SELECT TIPE_DOK FROM T_BC27_HDR WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "'";
            $rs = $this->db->query($SQL);
            $TIPE_DOK = "";
            if ($rs->num_rows() > 0) {
                $TIPE_DOK = $rs->row()->TIPE_DOK;
            }
            $TIPEDOKUMEN = $DOK . $TIPE_DOK;
        } else {
            $TIPEDOKUMEN = $DOK;
        }
        $pemasukan = array('BC16', 'BC27MASUK', 'BC33MASUK', 'BC40');
        $pengeluaran = array('BC28', 'BC27KELUAR', 'BC33KELUAR', 'BC41', 'P3BET');
        $logkeluar = "";
        $ret = "MSG#ERR#Proses data Gagal";
        $stk = "";
        if (in_array(strtoupper($TIPEDOKUMEN), $pemasukan)) {
            $SQL    = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN FROM T_".$DOK."_HDR WHERE KODE_TRADER='".$KODE_TRADER."' AND NOMOR_AJU='".$AJU."'";
            $hasil  = $this->db->query($SQL)->result_array();

            $SQLLOGBOOK   = "SELECT LOGID,NO_DOK,NOMOR_AJU FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$hasil[0]['NOMOR_PENDAFTARAN']."' AND TGL_DOK='".$hasil[0]['TANGGAL_PENDAFTARAN']."'";
            $hasilLogbook  = $this->db->query($SQLLOGBOOK)->result_array();
            if(count($hasilLogbook)>0){
                for($i=0;$i<count($hasilLogbook);$i++){
                    $SQLLOGKELUAR   = "SELECT NO_DOK,NOMOR_AJU FROM T_LOGBOOK_PENGELUARAN WHERE LOGID_MASUK='".$hasilLogbook[$i]['LOGID']."'";
                    $hasilLogKeluar  = $this->db->query($SQLLOGKELUAR)->result_array();
                    if(count($hasilLogKeluar)>0){
                        for($j=0;$j<count($hasilLogKeluar);$j++){
                            $logkeluar .= $hasilLogKeluar[$j]['NOMOR_AJU'].", ";
                        }
                    }
                }
                if($logkeluar != ""){
                    echo "MSG#ERR#Revisi Gagal.<br>Pemasukan ini sudah digunakan oleh pengeluaran berikut :<br>" . $logkeluar;
                    die();
                }
            }
            for($a=0;$a<count($data);$a++){
                $SQL = "SELECT JUMLAH FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='" . $data[$a]["KODE_BARANG"] . "' 
                        AND JNS_BARANG='" . $data[$a]["JNS_BARANG"] . "' AND KODE_GUDANG='" . $data[$a]["KODE_GUDANG"] . "' 
                        AND KODE_RAK='" . $data[$a]["KODE_RAK"] . "' AND KODE_SUB_RAK='" . $data[$a]["KODE_SUB_RAK"] . "'
                        AND KONDISI_BARANG='" . $data[$a]["KONDISI_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                $VAL = $this->db->query($SQL)->row();
                $STOCK_BARANG = $VAL->JUMLAH;
                if ($data[$a]["JUMLAH"] > $STOCK_BARANG) {
                    $stk = $stk . '' . $data[$a]["KODE_BARANG"] . ' stocknya: ' . $STOCK_BARANG . ', ';
                }
            }
            if ($stk!="") {
                echo "MSG#ERR#Revisi Gagal.<br>Stock kode barang berikut kurang untuk direverse pengurangan:<br>" . $stk;
                die();
            }
            if ($DOK == "bc16") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc16_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc16_bmtambahan');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc16_cnt');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc16_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc16_fas');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc16_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc16_trf');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc16_dtl');
            } elseif ($DOK == "bc27") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc27_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_bb');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_bj');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_cnt');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_dokasal');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_perubahan');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc27_dtl');
            } elseif ($DOK == "bc33") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc33_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc33_cnt');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc33_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc33_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc33_dtl');
            } elseif ($DOK == "bc40") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc40_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_dokasal');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_perubahan');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc40_dtl');
            }

            if ($execheader) {
                $this->db->where(array('NOMOR_AJU' => $AJU));
                $this->db->delete('m_trader_permohonan');
                $this->db->where(array('NOMOR_AJU' => $AJU));
                $this->db->delete('m_trader_permohonan_barang');
                $this->db->where(array('NOMOR_AJU' => $AJU));
                $this->db->delete('t_breakdown_pemasukan');

                $SQL = "SELECT REALISASIID FROM t_realisasi_parsial_hdr WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "' 
                        AND JENIS_DOK='" . strtoupper($DOK) . "'";
                $hasil = $func->main->get_result($SQL);
                if ($hasil) {
                    foreach ($SQL->result_array() as $row) {
                        $this->db->where(array('HDR_REFF' => $row["REALISASIID"]));
                        $parsialdtl = $this->db->delete('t_realisasi_parsial_dtl');
                        if ($parsialdtl) {
                            $this->db->where(array('REALISASIID' => $row["REALISASIID"]));
                            $this->db->delete('t_realisasi_parsial_hdr');
                        }
                    }
                }

                $SQL = "SELECT KODE_BARANG,JNS_BARANG,KODE_GUDANG,KONDISI_BARANG,KODE_RAK,KODE_SUB_RAK,JUMLAH FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='" . $KODE_TRADER . "' 
                        AND NOMOR_AJU='" . $AJU . "' AND KODE_DOKUMEN='" . strtoupper($DOK) . "' AND TIPE='GATE-IN'";
                $hasil = $func->main->get_result($SQL);
                if ($hasil) {
                    foreach ($SQL->result_array() as $row) {
                        $SQL = "UPDATE M_TRADER_BARANG_GUDANG SET JUMLAH = JUMLAH - " . $row["JUMLAH"] . " 
                                WHERE KODE_TRADER='" . $KODE_TRADER . "'
                                AND KODE_BARANG='" . $row["KODE_BARANG"] . "' 
                                AND JNS_BARANG='" . $row["JNS_BARANG"] . "'
                                AND KODE_GUDANG='" . $row["KODE_GUDANG"] . "'
                                AND KODE_RAK='" . $row["KODE_RAK"] . "'
                                AND KODE_SUB_RAK='" . $row["KODE_SUB_RAK"] . "'
                                AND KONDISI_BARANG='" . $row["KONDISI_BARANG"] . "'";
                        $updatebrg = $this->db->query($SQL);
                        $DATAABRANG = $DATAABRANG . $row["KODE_BARANG"] . ':' . $row["JUMLAH"] . ', ';
                    }
                    if ($updatebrg) {
                        $SQL = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN FROM T_" . $DOK . "_HDR 
                                WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "'";
                        $rs = $this->db->query($SQL);
                        if ($rs->num_rows() > 0) {
                            $NODAF = $rs->row()->NOMOR_PENDAFTARAN;
                            $TGDAF = $rs->row()->TANGGAL_PENDAFTARAN;
                        }

                        $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'JENIS_DOK' => strtoupper($DOK),
                            'NO_DOK' => $NODAF, 'TGL_DOK' => $TGDAF));
                        $this->db->delete('T_LOGBOOK_PEMASUKAN');

                        $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'NOMOR_AJU' => $AJU,
                            'KODE_DOKUMEN' => strtoupper($DOK), 'TIPE' => 'GATE-IN'));
                        $this->db->delete('M_TRADER_BARANG_INOUT');

                        if ($DOK == 'bc16') {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_bc16_hdr');
                        } elseif ($DOK == 'bc27') {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_bc27_hdr');
                        } elseif ($DOK == 'bc33') {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_bc33_hdr');
                        } elseif ($DOK == 'bc40') {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_bc40_hdr');
                        }
                    }
                }
                $func->main->activity_log('DELETE ' . strtoupper($DOK), 'REVISI DOKUMEN PABEAN ' . strtoupper($DOK) . ', CAR=' . $AJU . ', JUM DETIL=' . $JUMDTL);
                $func->main->revisi_log('REVISI DOKUMEN PABEAN ' . strtoupper($DOK), 'DELETE ' . strtoupper($DOK) . ', CAR=' . $AJU . ', JUM DETIL=' . $JUMDTL . ', BARANG=' . $DATAABRANG, $ALASAN);
                $ret = "MSG#OK#Proses Revisi Dokumen Pemasukan '" . strtoupper($DOK) . "' Berhasil#".site_url()."/tools/revisi/ajax/".$DOK;
            }
            echo $ret;
        } else if (in_array(strtoupper($TIPEDOKUMEN), $pengeluaran)) {
            if ($DOK == "bc28") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc28_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_bmtambahan');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_cnt');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_fas');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_jaminan');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_pgt');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc28_trf');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc28_dtl');
            } elseif ($DOK == "bc27") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc27_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_bb');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_bj');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_cnt');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_dokasal');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc27_perubahan');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc27_dtl');
            } elseif ($DOK == "bc33") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc33_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc33_cnt');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc33_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc33_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc33_dtl');
            } elseif ($DOK == "bc41") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_bc40_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_dok');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_dokasal');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_bc40_perubahan');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_bc40_dtl');
            } elseif ($DOK == "p3bet") {
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->from('t_p3bet_dtl');
                $JUMDTL = $this->db->count_all_results();

                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('t_p3bet_kms');
                $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                $execheader = $this->db->delete('t_p3bet_dtl');
            }
            if ($execheader) {
                $this->db->where(array('NOMOR_AJU' => $AJU));
                $this->db->delete('m_trader_permohonan');
                $this->db->where(array('NOMOR_AJU' => $AJU));
                $this->db->delete('m_trader_permohonan_barang');
                $this->db->where(array('NOMOR_AJU' => $AJU));
                $this->db->delete('t_breakdown_pengeluaran_dok');

                $SQL = "SELECT REALISASIID FROM t_realisasi_parsial_hdr WHERE 
                        KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "' 
                        AND JENIS_DOK='" . strtoupper($DOK) . "'";
                $hasil = $func->main->get_result($SQL);
                if ($hasil) {
                    foreach ($SQL->result_array() as $row) {
                        $this->db->where(array('HDR_REFF' => $row["REALISASIID"]));
                        $parsialdtl = $this->db->delete('t_realisasi_parsial_dtl');
                        if ($parsialdtl) {
                            $this->db->where(array('REALISASIID' => $row["REALISASIID"]));
                            $this->db->delete('t_realisasi_parsial_hdr');
                        }
                    }
                }

                $SQL = "SELECT KODE_BARANG,JNS_BARANG,KODE_GUDANG,KONDISI_BARANG,KODE_RAK,KODE_SUB_RAK,JUMLAH FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' 
                        AND NOMOR_AJU='" . $AJU . "' AND KODE_DOKUMEN='" . strtoupper($DOK) . "' AND TIPE='GATE-OUT'";
                $hasil = $func->main->get_result($SQL);
                if ($hasil) {
                    foreach ($SQL->result_array() as $row) {
                        $SQL = "UPDATE M_TRADER_BARANG_GUDANG SET JUMLAH = JUMLAH + " . $row["JUMLAH"] . " 
                                WHERE KODE_TRADER='" . $KODE_TRADER . "'
                                AND KODE_BARANG='" . $row["KODE_BARANG"] . "' 
                                AND JNS_BARANG='" . $row["JNS_BARANG"] . "'
                                AND KODE_GUDANG='" . $row["KODE_GUDANG"] . "'
                                AND KODE_RAK='" . $row["KODE_RAK"] . "'
                                AND KODE_SUB_RAK='" . $row["KODE_SUB_RAK"] . "'
                                AND KONDISI_BARANG='" . $row["KONDISI_BARANG"] . "'";
                        $updatebrg = $this->db->query($SQL);
                        $DATAABRANG = $DATAABRANG . $row["KODE_BARANG"] . ':' . $row["JUMLAH"] . ', ';
                    }
                    if ($updatebrg) {
                        $SQL = "SELECT NOMOR_PENDAFTARAN, TANGGAL_PENDAFTARAN FROM T_" . $DOK . "_HDR 
                                WHERE KODE_TRADER='" . $KODE_TRADER . "' AND NOMOR_AJU='" . $AJU . "'";
                        $rs = $this->db->query($SQL);
                        if ($rs->num_rows() > 0) {
                            $NODAF = $rs->row()->NOMOR_PENDAFTARAN;
                            $TGDAF = $rs->row()->TANGGAL_PENDAFTARAN;
                        }
                        
                        $SQL1 = "SELECT *, JUMLAH AS SALDO FROM T_LOGBOOK_PENGELUARAN 
                                WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$NODAF."'
                                AND TGL_DOK='".$TGDAF."' AND JUMLAH IS NOT NULL";
                                // echo $SQL; die();
                        $hasil1 = $func->main->get_result($SQL1);
                        if ($hasil1) {
                            // echo $SQL; die();
                            foreach ($SQL1->result_array() as $row) {
                                if ($row["LOGID_MASUK"] == "" || $row["LOGID_MASUK"] == NULL) {
                                    $this->db->set("SALDO","SALDO + ".$row["SALDO"], FALSE);
                                    $this->db->set("FLAG_TUTUP", NULL);
                                    $this->db->where(array(
                                            "NO_DOK"        => $row["NO_DOK_MASUK"],
                                            "TGL_DOK"       => $row["TGL_DOK_MASUK"],
                                            "KODE_BARANG"   => $row["KODE_BARANG"],
                                            "JNS_BARANG"    => $rw["JNS_BARANG"],
                                            "KODE_TRADER"   => $KODE_TRADER
                                    ));
                                    $this->db->update('T_LOGBOOK_PEMASUKAN');
                                } else {
                                    $this->db->set("SALDO","SALDO + ".$row["SALDO"],FALSE);
                                    $this->db->set("FLAG_TUTUP", NULL);
                                    $this->db->where(array("LOGID"=>$row["LOGID_MASUK"]));
                                    $this->db->update('T_LOGBOOK_PEMASUKAN');
                                }
                            }
                        }

                        $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'JENIS_DOK' => strtoupper($DOK),
                            'NO_DOK' => $NODAF, 'TGL_DOK' => $TGDAF));
                        $this->db->delete('T_LOGBOOK_PENGELUARAN');

                        $this->db->where(array('KODE_TRADER' => $KODE_TRADER, 'NOMOR_AJU' => $AJU,
                            'KODE_DOKUMEN' => strtoupper($DOK), 'TIPE' => 'GATE-OUT'));
                        $this->db->delete('M_TRADER_BARANG_INOUT');
                        
                        if ($DOK == "bc28") {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_bc28_hdr');
                        } elseif ($DOK == "bc27") {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $this->newsession->userdata('KODE_TRADER')));
                            $this->db->delete('t_bc27_hdr');
                        } elseif ($DOK == "bc33") {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_bc33_hdr');
                        } elseif ($DOK == "bc41") {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_bc41_hdr');
                        } elseif ($DOK == "p3bet") {
                            $this->db->where(array('NOMOR_AJU' => $AJU, 'KODE_TRADER' => $KODE_TRADER));
                            $this->db->delete('t_p3bet_hdr');
                        }
                    }
                }
                $func->main->activity_log('DELETE ' . strtoupper($DOK), 'REVISI DOKUMEN PABEAN ' . strtoupper($DOK) . ', CAR=' . $AJU . ', JUM DETIL=' . $JUMDTL);
                $func->main->revisi_log('REVISI DOKUMEN PABEAN ' . strtoupper($DOK), 'DELETE ' . strtoupper($DOK) . ', CAR=' . $AJU . ', JUM DETIL=' . $JUMDTL . ', BARANG=' . $DATAABRANG, $ALASAN);
                $ret = "MSG#OK#Proses Revisi Dokumen Pengeluaran '" . strtoupper($DOK) . "' Berhasil#".site_url()."/tools/revisi/ajax/".$DOK;
            }
            echo $ret;
        }
    }

    function eksekusiproduksi() {
        $func = &get_instance();
        $func->load->model("main", "main", true);
        $func->load->model("produksi_act");
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        foreach ($this->input->post('HEADER') as $a => $b) {
            $HEADER[$a] = $b;
        }
        $HEADER["KODE_TRADER"] = $KODE_TRADER;
        $TYPE = $HEADER["JENIS_BARANG"];
        date_default_timezone_set('Asia/Jakarta');

        if (count($this->input->post('DETIL')) < 2) {
            echo "MSG#ERR#Proses Data Gagal. Masukan dahulu data detil penggunaan bahan baku";
            die();
        }

        if ($TYPE == "masuk") {
            $JENISPRODUKSI = "PROCESS_IN";
        } elseif ($TYPE == "keluar") {
            $JENISPRODUKSI = "PROCESS_OUT";
        } elseif ($TYPE == "sisa") {
            $JENISPRODUKSI = "SCRAP";
        }

        $arrdetil = $this->input->post('DETIL');
        $arrkeys = array_keys($arrdetil);
        for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
            for ($j = 0; $j < count($arrkeys); $j++) {
                $cekdata[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
            }
            $val = $func->produksi_act->cekbarang($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"]);
            if ($val == "false")
                $kode = $kode . '' . $cekdata["KODE_BARANG"] . ',';
        }
        if ($kode) {
            $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
            $dtjuml = count(explode(",", $dtkode));
            $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Barang yang Belum terdaftar, Yaitu : <b>" . $dtkode . "</b>";
            echo "MSG#ERR#Proses Data Gagal" . $addWarning;
            die();
        } else {
            $SQL = "SELECT A.TANGGAL, A.WAKTU, A.JENIS_BARANG, B.KODE_BARANG, B.JNS_BARANG, B.JUMLAH 
					FROM M_TRADER_PROSES A, M_TRADER_PROSES_DTL B WHERE A.NOMOR_PROSES=B.NOMOR_PROSES 
					AND A.KODE_TRADER='" . $KODE_TRADER . "' AND A.KODE_TRADER=B.KODE_TRADER AND A.NOMOR_PROSES='" . $HEADER['NOMOR_PROSES'] . "'";
            $hasil = $func->main->get_result($SQL);
            if ($hasil) {
                foreach ($SQL->result_array() as $row) {
                    if ($HEADER['NOMOR_PROSES'] != "") {
                        $this->db->where(array("KODE_TRADER" => $KODE_TRADER, "TIPE" => $JENISPRODUKSI, "TANGGAL" => $row["TANGGAL"] . ' ' . $row["WAKTU"],
                            "KODE_BARANG" => $row["KODE_BARANG"], "JNS_BARANG" => $row["JNS_BARANG"],
                            "NOMOR_PROSES" => $HEADER['NOMOR_PROSES']));
                    } else {
                        $this->db->where(array("KODE_TRADER" => $KODE_TRADER, "TIPE" => $JENISPRODUKSI, "TANGGAL" => $row["TANGGAL"] . ' ' . $row["WAKTU"],
                            "KODE_BARANG" => $row["KODE_BARANG"], "JNS_BARANG" => $row["JNS_BARANG"]));
                    }
                    if ($this->db->delete("M_TRADER_BARANG_INOUT")) {
                        $this->db->where(array('JENIS_DOK' => $JENISPRODUKSI, 'KODE_TRADER' => $KODE_TRADER, 'TGL_MASUK' => $row['TANGGAL'],
                            'KODE_BARANG' => $row['KODE_BARANG'], 'JNS_BARANG' => $row['JNS_BARANG']));
                        if ($TYPE == "masuk") {
                            $this->db->delete('t_logbook_pengeluaran');
                            $endexec = $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR+" . $row["JUMLAH"] . "
											  WHERE KODE_BARANG='" . $row["KODE_BARANG"] . "' AND JNS_BARANG='" . $row["JNS_BARANG"] . "' 
											  AND KODE_TRADER='" . $KODE_TRADER . "'");
                        } else {
                            $this->db->delete('t_logbook_pemasukan');
                            $endexec = $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR-" . $row["JUMLAH"] . "
											  WHERE KODE_BARANG='" . $row["KODE_BARANG"] . "' AND JNS_BARANG='" . $row["JNS_BARANG"] . "' 
											  AND KODE_TRADER='" . $KODE_TRADER . "'");
                        }
                    }
                }
            }
            if ($endexec) {
                $SERIINOUT = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM M_TRADER_BARANG_INOUT", "MAXSERI") + 1;
                $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES'], 'KODE_TRADER' => $KODE_TRADER));
                if ($this->db->update('m_trader_proses', $HEADER)) {
                    $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES'], 'KODE_TRADER' => $KODE_TRADER));
                    if ($this->db->delete('m_trader_proses_dtl')) {
                        $seriPross = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_proses_dtl 
																   WHERE KODE_TRADER='" . $KODE_TRADER . "' 
																   AND NOMOR_PROSES='" . $HEADER["NOMOR_PROSES"] . "'", "MAXSERI") + 1;

                        $arrkeys = array_keys($arrdetil);
                        for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
                            for ($j = 0; $j < count($arrkeys); $j++) {
                                $data[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
                            }
                            $datadtl = array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "SERI" => $seriPross,
                                "KODE_TRADER" => $KODE_TRADER, "KODE_BARANG" => $data["KODE_BARANG"],
                                "JNS_BARANG" => $data["JNS_BARANG"], "JUMLAH" => $data["JUMLAH"],
                                "KODE_SATUAN" => $data["KODE_SATUAN"], "KETERANGAN" => $data["KETERANGAN"]);

                            if ($this->db->insert('m_trader_proses_dtl', $datadtl)) {
                                if ($TYPE == "masuk") {
                                    $logbook = array('JENIS_DOK' => $JENISPRODUKSI, 'TGL_MASUK' => $HEADER["TANGGAL"], 'KODE_TRADER' => $KODE_TRADER,
                                        'KODE_BARANG' => $data['KODE_BARANG'], 'JNS_BARANG' => $data['JNS_BARANG'],
                                        'JUMLAH' => $data['JUMLAH'], 'SATUAN' => $data['KODE_SATUAN']);
                                    $this->db->insert('t_logbook_pengeluaran', $logbook);
                                    $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR-" . $data["JUMLAH"] . "
												  WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' AND JNS_BARANG='" . $data["JNS_BARANG"] . "' 
												  AND KODE_TRADER='" . $KODE_TRADER . "'");
                                } else {
                                    $logbook = array('JENIS_DOK' => $JENISPRODUKSI, 'TGL_MASUK' => $HEADER["TANGGAL"], 'KODE_TRADER' => $KODE_TRADER,
                                        'KODE_BARANG' => $data['KODE_BARANG'], 'JNS_BARANG' => $data['JNS_BARANG'],
                                        'JUMLAH' => $data['JUMLAH'],
                                        'SALDO' => $data['JUMLAH']);
                                    $this->db->insert('t_logbook_pemasukan', $logbook);
                                    $this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = STOCK_AKHIR+" . $data["JUMLAH"] . "
												  WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' AND JNS_BARANG='" . $data["JNS_BARANG"] . "' 
												  AND KODE_TRADER='" . $KODE_TRADER . "'");
                                }

                                $INOUT["NOMOR_PROSES"] = $HEADER["NOMOR_PROSES"];
                                $INOUT["TIPE"] = $JENISPRODUKSI;
                                $INOUT["TANGGAL"] = $HEADER["TANGGAL"] . ' ' . $HEADER["WAKTU"];
                                $INOUT["JUMLAH"] = $data["JUMLAH"];
                                $INOUT["KODE_TRADER"] = $KODE_TRADER;
                                $INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
                                $INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
                                $INOUT["CREATED_TIME"] = date("Y-m-d H:i:s");
                                $INOUT["SERI"] = $SERI;
                                $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                            }
                            $seriPross++;
                            $SERIINOUT++;
                        }
                        echo "MSG#OK#Proses Data Berhasil";
                    } else {
                        echo "MSG#ERR#Proses Data Gagal";
                    }
                } else {
                    echo "MSG#ERR#Proses Data Gagal";
                }
            } else {
                echo "MSG#ERR#Proses Data Gagal";
            }
        }
        exit();
    }

    /*function sinkron() {
        $func = &get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, KODE_HS, URAIAN_BARANG, MERK, TIPE, UKURAN,
  				SPFLAIN, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, STOCK_AKHIR 
				FROM M_TRADER_BARANG WHERE KODE_TRADER='" . $KODE_TRADER . "'";
        $hasil = $func->main->get_result($SQL);
        $ret = "Proses Gagal!";
        if ($hasil) {
            foreach ($SQL->result_array() as $row) {
                $SQLS = "SELECT JUMLAH, DATE_FORMAT(MIN(TANGGAL_STOCK),'%d-%m-%Y') TANGGAL_STOCK 
						 FROM M_TRADER_STOCKOPNAME 
						 WHERE KODE_TRADER='" . $KODE_TRADER . "' AND KODE_BARANG='" . $row["KODE_BARANG"] . "' 
						 GROUP BY KODE_BARANG, KODE_TRADER LIMIT 1";
                $RS = $this->db->query($SQLS);
                $SALDO_AWAL = 0;
                $TANGGAL_STOCK = 0;
                if ($RS->num_rows() > 0) {
                    $DT = $RS->row();
                    $SALDO_AWAL = $DT->JUMLAH;
                    $TANGGAL_STOCK = $DT->TANGGAL_STOCK;
                }
                $SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI, KODE_DOKUMEN,
						TANGGAL_DOKUMEN, NOMOR_AJU,TIPE, 						
						JUMLAH, DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') TANGGAL, PROCESS_WITH, 
						DATE_FORMAT(CREATED_TIME,'%d-%m-%Y %H:%i:%s') CREATED_TIME 
						FROM M_TRADER_BARANG_INOUT 
						WHERE KODE_BARANG='" . $row["KODE_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "' 
						AND DATE_FORMAT(TANGGAL, '%Y-%m-%d') BETWEEN '2011-01-01' AND '" . date('Y-m-d') . "'
						ORDER BY DATE_FORMAT(TANGGAL, '%Y-%m-%d') ASC, DATE_FORMAT(TANGGAL, '%H:%i-%s') ASC";
                $hasil = $func->main->get_result($SQL);
                if ($hasil) {
                    $no = 2;
                    $SALDO = 0;
                    $TOTAL_MASUK = 0;
                    $TOTAL_KELUAR = 0;
                    $TOTAL_SALDO = 0;
                    foreach ($SQL->result_array() as $row) {
                        if ($row['TIPE'] == "GATE-IN" || $row['TIPE'] == "PROCESS_OUT" || $row['TIPE'] == "SCRAP" || $row['TIPE'] == "MOVE-IN") {
                            if ($no == 2) {
                                $SALDO = (float) $SALDO_AWAL + (float) $row['JUMLAH'];
                            } else {
                                $SALDO = (float) $SALDO + (float) $row['JUMLAH'];
                            }
                            $TOTAL_MASUK = (float) $TOTAL_MASUK + (float) $row['JUMLAH'];
                        } else {
                            if ($no == 2) {
                                $SALDO = (float) $SALDO_AWAL - (float) $row['JUMLAH'];
                            } else {
                                $SALDO = (float) $SALDO - (float) $row['JUMLAH'];
                            }
                            $TOTAL_KELUAR = (float) $TOTAL_KELUAR + (float) $row['JUMLAH'];
                        }
                        $TOTAL_SALDO = (float) $TOTAL_SALDO + (float) $SALDO;
                        $no++;
                    }
                    $this->db->where(array('KODE_BARANG' => $row["KODE_BARANG"], 'JNS_BARANG' => $row["JNS_BARANG"],
                        'KODE_TRADER' => $KODE_TRADER));
                    if ($this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $SALDO))) {
                        $ret = "Proses Berhasil!";
                    }
                }
            }
        }
        echo $ret;
    }*/
	
	function sinkron(){					
		$func = &get_instance();
		$func->load->model("main","main", true);
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$TANGGAL_AWAL = $this->input->post('TANGGAL_AWAL');
		$TANGGAL_AKHIR = $this->input->post('TANGGAL_AKHIR');
				
		$SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, KODE_HS, URAIAN_BARANG, 
				MERK, TIPE, UKURAN, SPFLAIN, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, 
				STOCK_AKHIR 
				FROM M_TRADER_BARANG WHERE KODE_TRADER='".$KODE_TRADER."'";
		$hasil = $func->main->get_result($SQL);
		$ret = "Proses Gagal!";	
		if($hasil){			
			$tglAkhirInOut=date('Y-m-d',strtotime($TANGGAL_AWAL."-1 day"));		
			foreach($SQL->result_array() as $row){
				$KODE_BARANG = $row["KODE_BARANG"];
				$JNS_BARANG = $row["JNS_BARANG"];
				$sqlGetSaldoStock ="SELECT REPLACE(FORMAT(JUMLAH,2),',','') AS 'JUMLAH_STOCK', TANGGAL_STOCK
									FROM m_trader_stockopname
									WHERE KODE_TRADER ='".$KODE_TRADER."' AND TANGGAL_STOCK <= '".$TANGGAL_AWAL."'
									AND KODE_BARANG ='".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."'
									ORDER BY TANGGAL_STOCK DESC LIMIT 1";				
				$RSSTOCKOPNAME=$this->db->query($sqlGetSaldoStock)->row(); 
				$GETSALDOAWALSTOCK=$RSSTOCKOPNAME->JUMLAH_STOCK;				
				$TGLSTOCK = "";
				if($RSSTOCKOPNAME->TANGGAL_STOCK!=""){ 
					$TGLSTOCK = " BETWEEN '".date('Y-m-d',strtotime($RSSTOCKOPNAME->TANGGAL_STOCK."+1 day"))."' AND '".$tglAkhirInOut."'";
				}else{
					$TGLSTOCK = " <= '".$tglAkhirInOut."'";
				}							 
				$sqlGetSaldoIn = "SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_IN', 
								  STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_IN'
								  FROM m_trader_barang_inout
								  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
								  AND KODE_TRADER = '".$KODE_TRADER."'
								  AND KODE_BARANG ='".$KODE_BARANG."'
								  AND JNS_BARANG = '".$JNS_BARANG."'
								  AND TIPE IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN') 
								  GROUP BY KODE_BARANG, JNS_BARANG";
																  
				$sqlGetSaldoOut ="SELECT REPLACE(FORMAT(SUM(JUMLAH),2),',','') AS 'AWAL_SALDO_OUT', 
								  STR_TO_DATE(MAX(TANGGAL),'%Y-%m-%d') 'TGL_OUT'
								  FROM m_trader_barang_inout
								  WHERE STR_TO_DATE(TANGGAL,'%Y-%m-%d') ".$TGLSTOCK."
								  AND KODE_TRADER = '".$KODE_TRADER."'
								  AND KODE_BARANG ='".$KODE_BARANG."'
								  AND JNS_BARANG = '".$JNS_BARANG."'
								  AND TIPE IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK') 
								  GROUP BY KODE_BARANG, JNS_BARANG";
				
				$RSGETSALDOAWALIN=$this->db->query($sqlGetSaldoIn)->row();
				$GETSALDOAWALIN=$RSGETSALDOAWALIN->AWAL_SALDO_IN;
				$RSGETSALDOAWALOUT=$this->db->query($sqlGetSaldoOut)->row(); 
				$GETSALDOAWALOUT=$RSGETSALDOAWALOUT->AWAL_SALDO_OUT;
				
				if($GETSALDOAWALSTOCK==""){
					$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT;
				}else{
					if($RSSTOCKOPNAME->TANGGAL_STOCK==$tglAkhirInOut){
						$SALDOAWLGET = $GETSALDOAWALSTOCK;
					}else{
						if($RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALIN->TGL_IN||$RSSTOCKOPNAME->TANGGAL_STOCK==$RSGETSALDOAWALOUT->TGL_OUT){
							$SALDOAWLGET = $GETSALDOAWALSTOCK;
						}else{
							$SALDOAWLGET = $GETSALDOAWALSTOCK+$GETSALDOAWALIN-$GETSALDOAWALOUT;
						}	
					}
				}	
				$SALDO_AWAL = $SALDOAWLGET;
				$TANGGAL_STOCK = $TANGGAL_AWAL;
				#============================
				$SQL = "SELECT KODE_TRADER, KODE_BARANG, JNS_BARANG, KODE_DOKUMEN,
						TANGGAL_DOKUMEN, NOMOR_AJU,TIPE, 
						CASE TIPE
							WHEN 'GATE-IN' THEN CONCAT('REALISASI PEMASUKAN (GATE-IN)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
							WHEN 'GATE-OUT' THEN CONCAT('REALISASI PENGELUARAN (GATE-OUT)',' ',KODE_DOKUMEN,' ',NOMOR_AJU)
							WHEN 'PROCESS_IN' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI MASUK (-)',CONCAT('PRODUKSI MASUK (-)',' ',NOMOR_PROSES))
							WHEN 'PROCESS_OUT' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI KELUAR (+)',CONCAT('PRODUKSI KELUAR (+)',' ',NOMOR_PROSES))
							WHEN 'SCRAP' THEN IF(NOMOR_PROSES IS NULL,'PRODUKSI SISA (+)',CONCAT('PRODUKSI SISA (+)',' ',NOMOR_PROSES)) 
							WHEN 'RUSAK' THEN 'PENGERUSAKAN'
							WHEN 'MUSNAH' THEN 'PEMUSNAHAN'
						END TIPE_URAIAN,
						REPLACE(FORMAT(JUMLAH,2),',','') AS JUMLAH, DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') TANGGAL, PROCESS_WITH, 
						DATE_FORMAT(CREATED_TIME,'%d-%m-%Y %H:%i:%s') CREATED_TIME 
						FROM M_TRADER_BARANG_INOUT 
						WHERE KODE_BARANG='".$KODE_BARANG."' AND KODE_TRADER='".$KODE_TRADER."' 
						AND JNS_BARANG = '".$JNS_BARANG."'
						AND DATE_FORMAT(TANGGAL, '%Y-%m-%d') BETWEEN '".$TANGGAL_AWAL."' AND '".$TANGGAL_AKHIR."'
						ORDER BY DATE_FORMAT(TANGGAL, '%Y-%m-%d') ASC, DATE_FORMAT(TANGGAL, '%H:%i-%s') ASC";	
				$hasil = $func->main->get_result($SQL);					
				$no=2;
				$SALDO = 0;
				$TOTAL_MASUK = 0;
				$TOTAL_KELUAR = 0;
				$TOTAL_SALDO = 0;			
				if($hasil){
					foreach($SQL->result_array() as $row){
						if($row['TIPE']=="GATE-IN"||$row['TIPE']=="PROCESS_OUT"||$row['TIPE']=="SCRAP"||$row['TIPE']=="MOVE-IN"){
							if($no==2){
								$SALDO = (float)$SALDO_AWAL + (float)$row['JUMLAH'];
							}else{
								$SALDO = (float)$SALDO + (float)$row['JUMLAH'];	
							}
							$TOTAL_MASUK = (float)$TOTAL_MASUK+(float)$row['JUMLAH'];
						}else{
							if($no==2){ 
								$SALDO = (float)$SALDO_AWAL - (float)$row['JUMLAH'];
							}else{
								$SALDO = (float)$SALDO - (float)$row['JUMLAH'];
							}
							$TOTAL_KELUAR = (float)$TOTAL_KELUAR+(float)$row['JUMLAH'];
						}
						$hastak = ".";
						$x = strpos($SALDO,$hastak);
						if($x !== false){
							$explode = explode(".",$SALDO);
							if(strlen($explode[1]) == 1){
								$SALDO = $SALDO."0";
							}else{
								$SALDO = $SALDO;
							}
						}else{
							$SALDO = $SALDO.".00";
						}
						if(number_format($SALDO,2)=='-0.00'){
							$SALDO = '0.00';
						}
						$TOTAL_SALDO = (float)$TOTAL_SALDO+(float)$SALDO;
						$no++;
					}						
				}
				else{
					$SALDO = $SALDO_AWAL;
				}
				$this->db->where(array(
										'KODE_BARANG'	=>$KODE_BARANG,
										'JNS_BARANG'	=>$JNS_BARANG,
										'KODE_TRADER'	=>$KODE_TRADER
									)
								);
				if($this->db->update('M_TRADER_BARANG',array("STOCK_AKHIR"=>$SALDO))){
					$ret = "Proses Berhasil!";
				}	
			}
		}
		$func->main->activity_log('SINKRONISASI BARANG','REVISI STOCK BARANG, PERIODE='.$TANGGAL_AWAL.' S/D '.$TANGGAL_AKHIR);
		$func->main->revisi_log('SINKRONISASI BARANG','REVISI STOCK BARANG, PERIODE='.$TANGGAL_AWAL.' S/D '.$TANGGAL_AKHIR);
		echo $ret;
	}

    function cctv($tipe = "") {
        $func = get_instance();
        $func->load->model("menu_act");
        $this->load->library('newtable');
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');

        if ($this->newsession->userdata('KODE_ROLE') == '5') {
            $SQL = "SELECT NAME, IP 'IP Public', PORT, USERNAME, CCTVID, KODE_TRADER
					FROM m_trader_cctv	WHERE KODE_TRADER='" . $KODE_TRADER . "' AND BC_FLAG='1'";
        } else {
            $SQL = "SELECT NAME, IP 'IP Public', PORT, USERNAME, CCTVID, KODE_TRADER, 
					IF(BC_FLAG=1,'<img src=\"" . base_url() . "img/tbl_ok.png\">','<img src=\"" . base_url() . "img/tbl_delete.png\">')
					'Share User BC'
					FROM m_trader_cctv	WHERE KODE_TRADER='" . $KODE_TRADER . "'";
        }

        $this->newtable->search(array(array('NAME', 'NAMA PERANGKAT'),
            array('IP', 'IP PERANGKAT'),
            array('URL', 'URL PERANGKAT')
        ));
        $this->newtable->hiddens(array("KODE_TRADER", "CCTVID", "USERNAME"));
        $this->newtable->keys(array("CCTVID"));

        if ($this->newsession->userdata('KODE_ROLE') != '5') {
            if ($func->menu_act->akses('54') == "w") {
                $prosesnya = array(
                                'Tambah' => array('DIALOG-500;330', site_url() . "/tools/set_cctv/save", '0', 'icon-plus'),
                                'Ubah' => array('DIALOG-500;320', site_url() . "/tools/set_cctv/update", '1', 'icon-pencil'),
                                'Hapus&nbsp;' => array('DELETE', site_url() . '/tools/set_cctv/delete', 'cctv', 'icon-remove'),
                                'Lihat' => array('DIALOG-524;470;CCTV', site_url() . '/tools/showpop', '1', 'icon-eye-open'),
                                'Lihat Semua' => array('GET2', site_url() . '/tools/cctv/show', '0', 'icon-list'),
                                'Tampilkan melalui Frameset' => array('GET2', site_url() . '/tools/cctv/frame', '1', 'icon-list')
                            );
            } elseif ($func->menu_act->akses('54') == "r") {
                $prosesnya = array(
                                'Lihat' => array('DIALOG-524;470;CCTV', site_url() . '/tools/showpop', '1', 'icon-eye-open'),
                                'Lihat Semua' => array('GET2', site_url() . '/tools/cctv/show', '0', 'icon-list'),
                                'Tampilkan melalui Frameset' => array('GET2', site_url() . '/tools/cctv/frame', '1', 'icon-list')
                            );
            }
        } elseif ($this->newsession->userdata('KODE_ROLE') == '5') {
            $prosesnya = array(
                            'Lihat' => array('DIALOG-524;470;CCTV', site_url() . '/tools/showpop', '1', 'icon-eye-open'),
                            'Lihat Semua' => array('GET2', site_url() . '/tools/cctv/show', '0', 'icon-list'),
                            'Tampilkan melalui Frameset' => array('GET2', site_url() . '/tools/cctv/frame', '1', 'icon-list')
                        );
        }
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->action(site_url() . "/tools/cctv");
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby('1');
        $this->newtable->sortby("DESC");
        $this->newtable->set_formid("FCCTV");
        $this->newtable->set_divid("DIVCCTV");
        $this->newtable->tipe_proses('button');
        $this->newtable->rowcount(50);
        $this->newtable->menu($prosesnya);
        $this->newtable->clear();
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => "Pengaturan Kamera CCTV",
            "tabel" => $tabel);
        if ($this->input->post("ajax") || $tipe == "back")
            return $tabel;
        else
            return $arrdata;
    }

    function set_cctv($act = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $CCTV_ID = $this->input->post('CCTV_ID');
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        foreach ($this->input->post('DATA') as $a => $b) {
            $DATA[$a] = $b;
        }
        $ret = "MSG#ERR#Proses data gagal";
        if ($act == "save") {
            $DATA['KODE_TRADER'] = $KODE_TRADER;
            $DATA['CREATED_TIME'] = date('Y-m-d H:i:s');
            $exec = $this->db->insert('M_TRADER_CCTV', $DATA);
            if ($exec) {
                $func->main->activity_log('ADD KONFIGURASI CCTV', 'NAMA PERANGKAT=' . $DATA['NAMA']);
                $ret = "MSG#OK#Proses data Berhasil#" . site_url() . "/tools/cctv/back";
            }
        } elseif ($act == "update") {
            $this->db->where(array('CCTVID' => $CCTV_ID, 'KODE_TRADER' => $KODE_TRADER));
            $exec = $this->db->update('M_TRADER_CCTV', $DATA);
            if ($exec) {
                $func->main->activity_log('EDIT KONFIGURASI CCTV', 'NAMA PERANGKAT=' . $DATA['NAMA']);
                $ret = "MSG#OK#Proses data Berhasil#" . site_url() . "/tools/cctv/back";
            }
        } else {
            $dataCheck = $this->input->post('tb_chkFCCTV');
            foreach ($dataCheck as $chkitem) {
                $this->db->where(array('CCTVID' => $chkitem, 'KODE_TRADER' => $KODE_TRADER));
                $this->db->delete('M_TRADER_CCTV');
                $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/tools/cctv/back";
            }
        }
        echo $ret;
    }

    function show_cctv($tipe = "", $id = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        if ($tipe == "popup") {
            $SQL = "SELECT * FROM m_trader_cctv	WHERE CCTVID='" . $id . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
            if ($this->newsession->userdata('KODE_ROLE') == '5') {
                $SQL .= " AND BC_FLAG='1'";
            }
            $RS = $this->db->query($SQL);
            $OBJECT = "";
            if ($RS->num_rows() > 0) {
                $DATA = $RS->row();
                $PORT = "";
                if ($DATA->PORT)
                    $PORT = ":" . $DATA->PORT;
                $OBJECT .= '<div class="content_luar"><div class="content_dalam">';
                $OBJECT .= '<h4><span class="info_">&nbsp;</span>' . $DATA->NAME . '</h4><br>';
                $OBJECT .= '<div style="margin-top:-20px"><object width="500" height="380" ';
                $OBJECT .= 'data="rtsp://' . $DATA->USERNAME . ':' . $DATA->PASSWORD . '@' . $DATA->IP . $PORT . '" ';
                $OBJECT .= 'events="True" id="vlc_1" codebase="http://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab" ';
                $OBJECT .= 'classid="clsid:4AD27CDD-8C2B-455E-8E2A-463E550B718F">';
                $OBJECT .= '<param value="rtsp://' . $DATA->USERNAME . ':' . $DATA->PASSWORD . '@' . $DATA->IP . $PORT . '" name="Src">';
                $OBJECT .= '<param value="transparent" name="wmode">';
                $OBJECT .= '<param value="True" name="ShowDisplay">';
                $OBJECT .= '<param value="False" name="AutoLoop">';
                $OBJECT .= '<param value="True" name="AutoPlay">';
                $OBJECT .= '<embed width="500" height="380" target="rtsp://' . $DATA->USERNAME . ':' . $DATA->PASSWORD . '@' . $DATA->IP . $PORT . '" ';
                $OBJECT .= 'loop="no" autoplay="yes" version="VideoLAN.VLCPlugin.2" pluginspage="http://www.videolan.org" ';
                $OBJECT .= 'type="application/x-vlc-plugin" id="vlc_1_embed" wmode="transparent">';
                $OBJECT .= '</object>';
                $OBJECT .= '</div></div></div>';
            }
        }elseif ($tipe == "frame") {
            $SQL = "SELECT * FROM m_trader_cctv	WHERE CCTVID='" . $id . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
            if ($this->newsession->userdata('KODE_ROLE') == '5') {
                $SQL .= " AND BC_FLAG='1'";
            }
            $RS = $this->db->query($SQL);
            $OBJECT = "";
            if ($RS->num_rows() > 0) {
                $DATA = $RS->row();
                $PORT = "";
                if ($DATA->PORT)
                    $PORT = ":" . $DATA->PORT;
                $OBJECT = $DATA->IP . $PORT;
            }
        }
        else {
            $SQL = "SELECT * FROM m_trader_cctv	WHERE KODE_TRADER='" . $KODE_TRADER . "' ORDER BY NAME";
            if ($func->main->get_result($SQL)) {
                $OBJECT .= '<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">';
                $x = 1;
                foreach ($SQL->result_array() as $row) {
                    if ($x == 1 || ($x % 3) == 1) {
                        $OBJECT .= '<tr>';
                    }
                    $PORT = "";
                    if ($row["PORT"])
                        $PORT = ":" . $row["PORT"];
                    $OBJECT .= '<td align="center">';
                    $OBJECT .= '<div class="content_luar"><div class="content_dalam">';
                    $OBJECT .= '<h4><span class="info_">&nbsp;</span>' . $row["NAME"] . '</h4><br>';
                    $OBJECT .= '<div style="margin-top:-20px"><object width="401" height="300" ';
                    $OBJECT .= 'data="rtsp://' . $row["USERNAME"] . ':' . $row["PASSWORD"] . '@' . $row["IP"] . $PORT . '" ';
                    $OBJECT .= 'events="True" id="vlc_1" codebase="http://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab" ';
                    $OBJECT .= 'classid="clsid:4AD27CDD-8C2B-455E-8E2A-463E550B718F">';
                    $OBJECT .= '<param value="rtsp://' . $row["USERNAME"] . ':' . $row["PASSWORD"] . '@' . $row["IP"] . $PORT . '" name="Src">';
                    $OBJECT .= '<param value="transparent" name="wmode">';
                    $OBJECT .= '<param value="True" name="ShowDisplay">';
                    $OBJECT .= '<param value="False" name="AutoLoop">';
                    $OBJECT .= '<param value="True" name="AutoPlay">';
                    $OBJECT .= '<embed width="401" height="300" target="rtsp://' . $row["USERNAME"] . ':' . $row["PASSWORD"] . '@' . $row["IP"] . $PORT . '" ';
                    $OBJECT .= 'loop="no" autoplay="yes" version="VideoLAN.VLCPlugin.2" pluginspage="http://www.videolan.org" ';
                    $OBJECT .= 'type="application/x-vlc-plugin" id="vlc_1_embed" wmode="transparent">';
                    $OBJECT .= '</object>';
                    $OBJECT .= '</div></div></div>';
                    $OBJECT .= '</td>';
                    if ($x % 3 == 0) {
                        $OBJECT .= '</tr>';
                    }
                    $x++;
                }
                $OBJECT .= '<table>';
            }
        }
        return $OBJECT;
    }

    function revisinull($aju="",$kode_barang="",$seri_barang=""){
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $UPDATE = array();
        $FLAG_TUTUP = "";
        $SQL    = "SELECT JUMLAH FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='".$KODE_TRADER."' AND NOMOR_AJU='".$aju."' AND KODE_BARANG='".$kode_barang."' AND SERI_DOKUMEN='".$seri_barang."'";
        $hasil  = $this->db->query($SQL)->row();
        $UPDATE['JUMLAH'] = $hasil->JUMLAH;
        $SQL1    = "SELECT NO_DOK_MASUK FROM T_LOGBOOK_PENGELUARAN WHERE KODE_TRADER='".$KODE_TRADER."' AND NOMOR_AJU='".$aju."' AND KODE_BARANG='".$kode_barang."' AND SERI_BARANG='".$seri_barang."' AND JUMLAH IS NULL";
        $hasil1  = $this->db->query($SQL1)->row();
        $NO_DOK_MASUK = $hasil1->NO_DOK_MASUK;
        $SQL2    = "SELECT LOGID,SERI_BARANG,JUMLAH FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$NO_DOK_MASUK."' AND KODE_BARANG='".$kode_barang."'";
        $hasil2  = $this->db->query($SQL2)->row();
        $UPDATE['SERI_BARANG_MASUK'] = $hasil2->SERI_BARANG;
        $UPDATE['LOGID_MASUK'] = $hasil2->LOGID;

        $this->db->where(array('KODE_TRADER'=>$KODE_TRADER, 'NOMOR_AJU'=>$aju, 'KODE_BARANG'=>$kode_barang, 'SERI_BARANG'=>$seri_barang, 'JUMLAH'=>NULL));
        $update = $this->db->update('T_LOGBOOK_PENGELUARAN',$UPDATE);

        if($update){
            $SQLSALDO   = "SELECT SUM(JUMLAH) AS JUMLAH FROM T_LOGBOOK_PENGELUARAN WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK_MASUK='".$NO_DOK_MASUK."' AND SERI_BARANG_MASUK='".$UPDATE['SERI_BARANG_MASUK']."' AND LOGID_MASUK='".$UPDATE['LOGID_MASUK']."' AND KODE_BARANG='".$kode_barang."'";
            $hasilsaldo     = $this->db->query($SQLSALDO)->row();
            $jml_masuk      = $hasil2->JUMLAH;
            $jml_keluar     = $hasilsaldo->JUMLAH;
            $SALDO_AKHIR    = $jml_masuk - $jml_keluar;
            if($SALDO_AKHIR<=0){
                $FLAG_TUTUP = ", FLAG_TUTUP='1'";
            }
            $QUERY_SALDO    = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO='".$SALDO_AKHIR."' ".$FLAG_TUTUP." WHERE KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$NO_DOK_MASUK."' AND SERI_BARANG='".$UPDATE['SERI_BARANG_MASUK']."' AND LOGID='".$UPDATE['LOGID_MASUK']."' AND KODE_BARANG='".$kode_barang."'";
            $update_saldo   = $this->db->query($QUERY_SALDO);
            if($update_saldo){
                $sukses = "SUKSES";
            }   
        }else{
            $sukses = "GAGAL";
        }
        return $sukses;
    }

}

?>
