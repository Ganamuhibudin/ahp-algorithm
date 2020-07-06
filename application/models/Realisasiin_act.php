<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Realisasiin_act extends CI_Model 
{
    function in($dokumen = "", $aju = "") {
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_role = $this->newsession->userdata('KODE_ROLE');
        $jenis = "in";
        $prosesnya = "";
        $title = "Daftar Realisasi Pemasukan";
        if (!in_array($kode_role,array("5","3"))){
			$FIELD = ",DATE_FORMAT(TANGGAL_REALISASI, '%d %M %Y %H:%m:%s') AS 'TANGGAL REALISASI/GATE'";
		}else{
			$FIELD = ",DATE_FORMAT(TANGGAL_REALISASI, '%d %M %Y %H:%m:%s') AS 'TANGGAL REALISASI/GATE'
						, f_trader(KODE_TRADER) 'NAMA ANGGOTA' ";
		}
        $WHERE = " WHERE STATUS = '19' AND TANGGAL_REALISASI!='NULL' AND KODE_TRADER='".$kode_trader."'";
        if (!in_array($kode_role,array("5","3"))){
            $prosesnya = array( 
								'Tambah' => array('GETREALISASI', site_url() . "/realisasi/in/save", '0', 'icon-plus'),
                				'Ubah' => array('EDITJS', site_url() . "/realisasi/in/update", '1', 'icon-pencil')
							  );
        }

        foreach ($this->input->post('CARI') as $a => $b) {
            $CARI[$a] = $b;
        }
        if ($CARI["NOMOR_DOK_INTERNAL"] != "") {
            $WHERE .= " AND NOMOR_DOK_INTERNAL LIKE '%" . $CARI["NOMOR_DOK_INTERNAL"] . "%'";
        }
		if ($CARI["LOKASI"] != "") {
            $WHERE .= " AND KODE_TRADER = '" . $CARI["LOKASI"] . "'";
        }
        if ($CARI["NOMOR_PENDAFTARAN"] != "") {
            $WHERE .= " AND NOMOR_PENDAFTARAN LIKE '%" . $CARI["NOMOR_PENDAFTARAN"] . "%'";
        }
        if ($CARI["PEMASOK"] != "") {
            if ($dokumen == "bc16" || $dokumen == "bc40") {
                $WHERE .= " AND NAMA_PENGIRIM LIKE '%" . $CARI["PEMASOK"] . "%'";
            } elseif ($dokumen == "bc27") {
                $WHERE .= " AND NAMA_TRADER_TUJUAN LIKE '%" . $CARI["PEMASOK"] . "%'";
            }elseif($dokumen == "ppb" || $dokumen == "bc30"){
				$WHERE .= " AND NAMA_TRADER LIKE '%" . $CARI["PEMASOK"] . "%'";
			}elseif($dokumen == "ppk"){
				$WHERE .= " AND NAMA_IMPORTIR LIKE '%" . $CARI["PEMASOK"] . "%'";
			}elseif($dokumen == "bc24"){
				$WHERE .= " AND NAMA_PEMASOK LIKE '%" . $CARI["PEMASOK"] . "%'";
			}
        }
        if ($CARI["TANGGAL_DOK_INTERNAL1"] != "" && $CARI["TANGGAL_DOK_INTERNAL2"] != "") {
            $WHERE .= " AND TANGGAL_DOK_INTERNAL BETWEEN '" . $CARI["TANGGAL_DOK_INTERNAL1"] . "' AND '" . $CARI["TANGGAL_DOK_INTERNAL2"] . "'";
        }
        if ($CARI["TANGGAL_PENDAFTARAN1"] != "" && $CARI["TANGGAL_PENDAFTARAN2"] != "") {
            $WHERE .= " AND TANGGAL_PENDAFTARAN BETWEEN '" . $CARI["TANGGAL_PENDAFTARAN1"] . "' AND '" . $CARI["TANGGAL_PENDAFTARAN2"] . "'";
        }
        if ($CARI["TANGGAL_REALISASI1"] != "" && $CARI["TANGGAL_REALISASI2"] != "") {
            $WHERE .= " AND DATE_FORMAT(TANGGAL_REALISASI, '%Y-%m-%d') BETWEEN '" . $CARI["TANGGAL_REALISASI1"] . "' AND '" . $CARI["TANGGAL_REALISASI2"] . "'";
        }
		
        if ($dokumen == "bc16") {
            $judul = "Dokumen BC 1.6";
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENERIMAAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC16' AS 'DOKUMEN', NAMA_PENGIRIM AS 'PEMASOK/PENGIRIM', 
					IFNULL(f_jumbrg_bc16(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC16_HDR";
            $SQL .= $WHERE;
        } elseif ($dokumen == "bc27") {
            $judul = "Dokumen BC 2.7";
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENERIMAAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC27' AS 'DOKUMEN', 
					NAMA_TRADER_TUJUAN AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc27(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC27_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='MASUK'";
        } elseif ($dokumen == "bc40") {
            $judul = "Dokumen BC 4.0";
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENERIMAAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC40' AS 'DOKUMEN', 
					NAMA_PENGIRIM AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc40(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC40_HDR";
            $SQL .= $WHERE;
        }  elseif ($dokumen == "bc33") {
            $judul = "Dokumen BC 3.3";
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENERIMAAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC33' AS 'DOKUMEN', 
					NAMA_TRADER AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc33(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC33_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='MASUK'";
        } elseif ($dokumen == "ppb"){
			$judul = "PPB-PLB";
			$SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','PPB-PLB' AS 'DOKUMEN', 
					NAMA_TRADER AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_ppb(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_PPB_HDR ";
            $SQL .= $WHERE . " AND TIPE_DOK='MASUK'";
		} elseif($dokumen == "ppk"){
			$SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','PPK-PLB' AS 'DOKUMEN', 
					NAMA_IMPORTIR AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_ppk(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_PPK_HDR";
            $SQL .= $WHERE;
		} elseif($dokumen=="bc24"){
			$SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC24' AS 'DOKUMEN', 
					NAMA_PEMASOK AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc24(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC24_HDR";
            $SQL .= $WHERE;
		} else {
            $POSTURI = $this->input->post("uri");
            $judul = "Semua Dokumen";
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENERIMAAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC16' AS 'DOKUMEN', NAMA_PENGIRIM AS 'PEMASOK/PENGIRIM', 
					IFNULL(f_jumbrg_bc16(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL FLAG' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC16_HDR";
            $SQL .= $WHERE;
            if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PENGIRIM LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
            $SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC27' AS 'DOKUMEN', 
					NAMA_TRADER_ASAL AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc27(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC27_HDR";
            $SQL .= $WHERE . " AND TIPE_DOK='MASUK'";
            if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_TRADER_ASAL LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC40' AS 'DOKUMEN', 
					NAMA_PENGIRIM AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc40(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC40_HDR";
            $SQL .= $WHERE;
            if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PENGIRIM LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENERIMAAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC33' AS 'DOKUMEN', 
					NAMA_TRADER AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc33(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC33_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='MASUK'";
            if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PEMBELI LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','PPB-PLB' AS 'DOKUMEN', 
					NAMA_TRADER AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_ppb(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_PPB_HDR";
            $SQL .= $WHERE . " AND TIPE_DOK='MASUK'";
            if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_TRADER LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','PPK-PLB' AS 'DOKUMEN', 
					NAMA_IMPORTIR AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_ppk(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_PPK_HDR";
            $SQL .= $WHERE;
            if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_IMPORTIR LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENERIMAAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'Tgl.Bukti Penerimaan',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC24' AS 'DOKUMEN', 
					NAMA_PEMASOK AS 'PEMASOK/PENGIRIM', IFNULL(f_jumbrg_bc24(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC24_HDR";
            $SQL .= $WHERE;
            if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PEMASOK LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
        }
        	#echo $SQL;die();
        $this->newtable->align(array("LEFT", "LEFT", "CENTER", "LEFT", "LEFT", "LEFT", "CENTER", "LEFT", "CENTER", "CENTER"));
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        if ($this->newsession->userdata('KODE_ROLE') == '5') $this->newtable->show_chk(FALSE);
        $this->newtable->action(site_url() . "/realisasi/in");
        $this->newtable->detail(site_url() . "/realisasi/detil_in");
        $this->newtable->detail_tipe("detil_priview_bottom");
        $this->newtable->hiddens(array("CREATED_TIME", "NOMOR AJU", "STATUS"));
        $this->newtable->keys(array("DOKUMEN", "NOMOR AJU"));
        $this->newtable->tipe_proses('button');
        $this->newtable->show_search(false);
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby(1, 2);
        $this->newtable->sortby("DESC");
        $this->newtable->set_formid("frealisasiin");
        $this->newtable->set_divid("divrealisasiin");
        $this->newtable->rowcount(20);
        $this->newtable->clear();
        $this->newtable->menu($prosesnya);
		if (in_array($kode_role,array("5","3")))
		{
			$this->newtable->show_chk(false);
		}
        if (!$this->input->post("ajax")) {
            $tabel .= '<form name="tblCari" id="tblCari" class="form-horizontal" method="post" action="realisasi/in" onsubmit="return frm_Cari(\'divrealisasiin\',\'tblCari\')">		
						<input type="hidden" name="PARSIAL" id="PARSIAL">
						<input type="hidden" name="BREAK" id="BREAK">
						<table border="0" cellpadding="1" cellspacing="0" width="100%" style="margin-bottom:10px">';
            $tabel .= '	<tr>
							<td width="12%"><strong>No.Bukti Penerimaan</strong></td>
							<td width="1%">:</td>
							<td width="1%">' . form_input('CARI[NOMOR_DOK_INTERNAL]', '', 'id="NOMOR_DOK_INTERNAL" class="text" style="width:220px;"') . '</td>
							<td>&nbsp;</td>
							<td width="10%"><strong>Nomor Daftar</strong></td>
							<td width="1%">:</td>
							<td width="1%">' . form_input('CARI[NOMOR_PENDAFTARAN]', '', 'id="NOMOR_PENDAFTARAN" class="text" style="width:220px;"') . '</td>
							<td>&nbsp;</td>
							<td width="10%"><strong>Pemasok/Pengirim</strong></td>
							<td width="1%">:</td>
							<td width="1%">' . form_input('CARI[PEMASOK]', '', 'id="PEMASOK" class="text" style="width:220px;"') . '</td>
						</tr>';
            $tabel .= '	<tr>
							<td width="10%"><strong>Tgl.Bukti Penerimaan</strong></td>
							<td width="1%">:</td>
							<td width="1%">
							' . form_input('CARI[TANGGAL_DOK_INTERNAL1]', '', 'id="TANGGAL_DOK_INTERNAL1" class="text date" onfocus="ShowDP(this.id)"') . '
							&nbsp;&nbsp;<b>s/d</b>&nbsp&nbsp;
							' . form_input('CARI[TANGGAL_DOK_INTERNAL2]', '', 'id="TANGGAL_DOK_INTERNAL2" class="text date" onfocus="ShowDP(this.id)"') . '
							</td>
							<td>&nbsp;</td>
							<td width="10%"><strong>Tanggal Daftar</strong></td>
							<td width="1%">:</td>
							<td width="1%">
							' . form_input('CARI[TANGGAL_PENDAFTARAN1]', '', 'id="TANGGAL_PENDAFTARAN1" class="text date" onfocus="ShowDP(this.id)"') . '
							&nbsp;&nbsp;<b>s/d</b>&nbsp&nbsp;
							' . form_input('CARI[TANGGAL_PENDAFTARAN2]', '', 'id="TANGGAL_PENDAFTARAN2" class="text date" onfocus="ShowDP(this.id)"') . '
							</td>
							<td>&nbsp;</td>
							<td width="10%"><strong>Tanggal Realisasi</strong></td>
							<td width="1%">:</td>
							<td width="1%">
							' . form_input('CARI[TANGGAL_REALISASI1]', '', 'id="TANGGAL_REALISASI1" class="text date" onfocus="ShowDP(this.id)"') . '
							&nbsp;&nbsp;<b>s/d</b>&nbsp&nbsp;
							' . form_input('CARI[TANGGAL_REALISASI2]', '', 'id="TANGGAL_REALISASI2" class="text date" onfocus="ShowDP(this.id)"') . '
							</td>
						</tr>';
			if(in_array($kode_role,array('3','5'))){
				$SQ = "SELECT KODE_TRADER, NAMA FROM M_TRADER WHERE INDUK_PLB='".$kode_trader."' ORDER BY NAMA";
				$ANGGOTA = $func->main->get_combobox($SQ, "KODE_TRADER", "NAMA", TRUE);
				$tabel .= '<tr>';
				$tabel .= '<td><strong>Anggota PLB</strong></td>';
				$tabel .= '<td>:</td>';
				$tabel .= '<td><combo>'.form_dropdown('CARI[LOKASI]', $ANGGOTA, '', 'id="LOKASI" class="text" style="width:220px;"').'</combo></td>';
				$tabel .= '</tr>';
			}
            $tabel .= '	<tr><td colspan="11">&nbsp;<input type="submit" style="display:none"></td></tr>';
            $tabel .= '	<tr>
							<td colspan="2">&nbsp;</td>
							<td colspan="9">';
            $tabel .= "     <a href=\"javascript:void(0);\" class=\"btn btn-primary btn-sm\" id=\"ok_\" onclick=\"frm_Cari('divrealisasiin','tblCari')\"><i class=\"icon-search\"></i>&nbsp;Search</a>";
            $tabel .= "		<a href=\"javascript:void(0);\" class=\"btn btn-danger btn-sm\" id=\"ok_\" onclick=\"cancel('tblCari')\"><i class=\"icon-undo\"></i>&nbsp;Clear</a>";
            $tabel .= '		</td>
						</tr>';
            $tabel .= '	 </table>
						</form>';
        }

        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $title,
            "tabel" => $tabel,
            "jenis" => $jenis,
            "judul" => $judul);
        if ($this->input->post("ajax"))
            return $tabel;
        else
            return $arrdata;
    }
	
	function get_realisasi(){	
		$func = get_instance();
		$func->load->model("main");;	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$dok = $this->input->post('id1');
		$aju = $this->input->post('id2');
		if($dok=="PPB-PLB") $dok = "PPB";
		switch($dok){
			case "BC16":
				$PEMASOK = "A.NAMA_PENGIRIM";
				$jumbrg = "IFNULL(f_jumbrg_bc16(A.NOMOR_AJU),0)";
				$dokumen = "BC16";
			break;
			case "PPB":
				$PEMASOK = "A.NAMA_TRADER";
				$jumbrg = "IFNULL(f_jumbrg_ppb(A.NOMOR_AJU,A.KODE_TRADER),0)";
				$dokumen = "PPB-PLB";
			break;
			case "BC40":
				$PEMASOK = "A.NAMA_TRADER";
				$jumbrg = "IFNULL(f_jumbrg_bc40(A.NOMOR_AJU,A.KODE_TRADER),0)";
				$dokumen = "BC40";
			break;
			case "BC27":
				$PEMASOK = "A.NAMA_TRADER_ASAL";
				$jumbrg = "IFNULL(f_jumbrg_bc27(A.NOMOR_AJU,A.KODE_TRADER),0)";
				$dokumen = "BC27";
			break;
			case "BC30":
				$PEMASOK = "A.NAMA_PEMBELI";
				$jumbrg = "IFNULL(f_jumbrg_bc30(A.NOMOR_AJU),0)";
				$dokumen = "BC30";
			break;
		}
		$SQL = "SELECT A.NOMOR_AJU,A.TANGGAL_DOK_INTERNAL,A.NOMOR_DOK_INTERNAL,A.NOMOR_PENDAFTARAN,A.TANGGAL_PENDAFTARAN,
					".$PEMASOK." AS 'PEMASOK/PENGIRIM',".$jumbrg." AS 'DETIL_BARANG','".$dokumen."' AS 'DOKUMEN',
					DATE_FORMAT(A.TANGGAL_REALISASI,'%Y-%m-%d') TANGGAL_REALISASI, DATE_FORMAT(A.TANGGAL_REALISASI,'%H:%i') WAKTU 
				FROM T_".$dok."_HDR A
					WHERE NOMOR_AJU='" . $aju . "'  AND KODE_TRADER = '".$KODE_TRADER."'";#echo $SQL;die();
		$hasil = $func->main->get_result($SQL);
		$DATA = array();
		if($hasil){
			foreach($SQL->result_array() as $row){
				$DATA = $row;
			}
		}	
		return $DATA;
	}
	
	function detil_in($tipe="",$data=""){
		$func = get_instance();
		$func->load->model("main");
		$this->load->library('newtable');	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$arrdata = explode("|",$tipe);		
		$SQL = "SELECT REALISASIID, NOMOR_AJU, NO_DOK_INTERNAL 'NO.BUKTI PENERIMAAN', TGL_DOK_INTERNAL 'TGL.BUKTI PENERIMAAN', 
				NAMA_TRADER 'PEMASOK/PENGIRIM', TGL_REALISASI 'TANGGAL REALISASI' 
		        FROM t_realisasi_parsial_hdr WHERE NOMOR_AJU='".$arrdata[1]."' AND JENIS_DOK='".$arrdata[0]."'
				AND KODE_TRADER='".$KODE_TRADER."'";
		$this->newtable->search(array(array('NO_DOK_INTERNAL','NO. BUKTI PENERIMAAN&nbsp;'), 
								array('NAMA_PEMASOK', 'PEMASOK/PENGIRIM'),
								array('TGL_REALISASI', 'TANGGAL REALISASI', 'tag-tanggal')));												
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
		$this->newtable->action(site_url()."/realisasi/detil_in/ajax/".$data);
		$this->newtable->hiddens(array('NOMOR_AJU','REALISASIID'));					
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->set_formid("fdetilrealisasi");
		$this->newtable->set_divid("divfdetilrealisasi");
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->rowcount(10);
		$this->newtable->show_chk(false);
		$this->newtable->header_bg("#82AF6F");	
		$this->newtable->clear(); 
		$this->newtable->menu($prosesnya);
		$generate .= $this->newtable->generate($SQL);		
		$table = '<div class="space-7"></div>
					<div class="profile-user-info">
					  <div class="widget-box transparent">
						<div class="widget-header widget-header-flat">
						  <h4 class="lighter"> <i class="icon-th orange"></i> Detil Realisasi Parsial/Berkala </h4>
						</div>
					  </div>'.$generate.'</div>
					<div class="space-7"></div>';
		if($tipe=="view") return $table;
		else return $generate;
	}
	
	function proses_realisasi(){
		$func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $NOMOR_AJU = $this->input->post('NOMOR_AJU');
        $KODE_DOKUMEN = $this->input->post('KODE_DOKUMEN');
        $TANGGAL_DAFTAR = $this->input->post("TANGGAL_DAFTAR");
        $NOMOR_DAFTAR = $this->input->post("NOMOR_DAFTAR");
        $TANGGAL_REALISASI = $this->input->post('TANGGAL_REALISASI');
        $WAKTU = $this->input->post('WAKTU');
        $BREAK = $this->input->post('BREAK');
        $PARSIAL = $this->input->post('PARSIAL');
		
		$barang = $this->input->post("BARANG");
		$jumlah_masuk = $this->input->post('jumlah');
		$gudang_tujuan = $this->input->post('gudang');
		$kondisi = $this->input->post('kondisi');
		$rak = $this->input->post('rak');
		$subrak = $this->input->post('subrak');
		$chkbreak = $this->input->post("chkbreak");
		
        foreach ($this->input->post('HEADER') as $a => $b) {
            $HEADER[$a] = $b;
        }
        if ($this->input->post('act') == "save") {
            if ($TANGGAL_REALISASI) {
                $HEADER["TANGGAL_REALISASI"] = $TANGGAL_REALISASI . ' ' . $WAKTU;
                $INOUT["TANGGAL"] = $TANGGAL_REALISASI . ' ' . $WAKTU;
                $HEADER["STATUS"] = "19";
            } else {
                $HEADER["TANGGAL_REALISASI"] = date("Y-m-d H:i:s");
                $INOUT["TANGGAL"] = date("Y-m-d H:i:s");
                $HEADER["STATUS"] = "19";
            }
            $INOUT["TIPE"] = "GATE-IN";
            $INOUT["KODE_TRADER"] = $KODE_TRADER;
            $INOUT["KODE_DOKUMEN"] = $KODE_DOKUMEN;
            $INOUT["TANGGAL_DOKUMEN"] = $TANGGAL_DAFTAR;
            $INOUT["NOMOR_AJU"] = $NOMOR_AJU;
            $INOUT["PROCESS_WITH"] = "FORM";

            $LOG["JENIS_DOK"] = $KODE_DOKUMEN;
            $LOG["NO_DOK"] = $NOMOR_DAFTAR;
            $LOG["TGL_DOK"] = $TANGGAL_DAFTAR;
            $LOG["TGL_MASUK"] = $INOUT["TANGGAL"];
            $LOG["KODE_TRADER"] = $KODE_TRADER;
            if (strtoupper($KODE_DOKUMEN) == "BC16") {
                $SQL = "SELECT A.SERI, A.URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.NILAI AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG AS JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG
					  FROM T_BC16_DTL A, T_BC16_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU='" . $NOMOR_AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' ORDER BY A.SERI ASC";
            } elseif (strtoupper($KODE_DOKUMEN) == "BC27") {
                $SQL = "SELECT A.SERI, A.URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.HARGA_PENYERAHAN AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG
					  FROM T_BC27_DTL A, T_BC27_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU='" . $NOMOR_AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' ORDER BY A.SERI ASC";
            } elseif (strtoupper($KODE_DOKUMEN) == "BC40") {
				$SQL = "SELECT A.SERI, A.URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.HARGA_PENYERAHAN AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG
					  FROM T_BC40_DTL A, T_BC40_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU='" . $NOMOR_AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' ORDER BY A.SERI ASC";
			} elseif (strtoupper($KODE_DOKUMEN) == "BC30") {
				$SQL = "SELECT A.SERI, A.URAIAN_BARANG1 AS URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.FOB_PER_BARANG AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG
					  FROM T_BC30_DTL A, T_BC30_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU='" . $NOMOR_AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' ORDER BY A.SERI ASC";
			} elseif (strtoupper($KODE_DOKUMEN) == "PPB-PLB") {
				$SQL = "SELECT A.SERI, A.URAIAN_BARANG AS URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, '0' AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG
					  FROM T_PPB_DTL A, T_PPB_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU='" . $NOMOR_AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' ORDER BY A.SERI ASC";
			} elseif (strtoupper($KODE_DOKUMEN) == "PPK-PLB") {
				$SQL = "SELECT A.SERI, A.URAIAN_BARANG AS URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, '0' AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG
					  FROM T_PPK_DTL A, T_PPK_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU='" . $NOMOR_AJU . "' AND B.KODE_TRADER='" . $KODE_TRADER . "' ORDER BY A.SERI ASC";
			}
            $HASIL = $func->main->get_result($SQL);
            if ($HASIL) { 
				#pengecekan realisasi biasa
				if(!$BREAK && !$PARSIAL && empty($chkbreak)){
					#CEK JUMLAH TOTAL BARANG
					$err = false;
					$i = 1;
					foreach ($barang as $barang) {
						$arrdata[$i]['KODE_BARANG'] = $barang['KODE_BARANG'];
						$arrdata[$i]['JNS_BARANG'] = $barang['JNS_BARANG'];
						$arrdata[$i]['KODE_SATUAN'] = $barang['KODE_SATUAN'];
						$arrdata[$i]['JUMLAH_SATUAN'] = $barang['JUMLAH_SATUAN'];
						$tempJumlah = 0;
						if(count($jumlah_masuk[$i])> 0){
							for ($k=0; $k < count($jumlah_masuk[$i]) ; $k++) { 
								$arrdata[$i]['data'][$k]['JUMLAH'] = $jumlah_masuk[$i][$k];
								$arrdata[$i]['data'][$k]['GUDANG'] = $gudang_tujuan[$i][$k];
								$arrdata[$i]['data'][$k]['KONDISI'] = $kondisi[$i][$k];
								$arrdata[$i]['data'][$k]['RAK'] = $rak[$i][$k];
								$arrdata[$i]['data'][$k]['SUBRAK'] = $subrak[$i][$k];
								$tempJumlah = $tempJumlah + $jumlah_masuk[$i][$k];
								$where = "";
								if($arrdata[$i]['data'][$k]['GUDANG'] != ""){
									$where .= " AND KODE_GUDANG = '".$gudang_tujuan[$i][$k]."'"; 
								}
								if($arrdata[$i]['data'][$k]['KONDISI'] != ""){
									$where .= " AND KONDISI_BARANG = '".$kondisi[$i][$k]."'"; 
								}
								if($arrdata[$i]['data'][$k]['RAK'] != ""){
									$where .= " AND KODE_RAK = '".$rak[$i][$k]."'"; 
								}
								if($arrdata[$i]['data'][$k]['SUBRAK'] != ""){
									$where .= " AND KODE_SUB_RAK = '".$subrak[$i][$k]."'"; 
								}
								$sqlValidasi = "SELECT ID FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."'
												AND KODE_BARANG = '".$barang['KODE_BARANG']."' 
												AND JNS_BARANG = '".$barang['JNS_BARANG']."'".$where;
								$doValidasi = $this->db->query($sqlValidasi);
								if ($doValidasi->num_rows() < 1) {
									$err = true;
									$msg = "MSG#ERR#Data tidak ditemukan yaitu : Kode Barang ".$barang['KODE_BARANG'].", Kode Gudang : ".$gudang_tujuan[$i][$k].", Kondisi Barang : ".$kondisi[$i][$k]." #edit#";
									echo $msg; die();
								}
							}
							if ($tempJumlah > $barang['JUMLAH_SATUAN']) {
								$err = true;
								$msg = "MSG#ERR#Total jumlah melebihi jumlah satuan pada Kode Barang : ".$barang['KODE_BARANG']."#edit#";
							} elseif ($tempJumlah < $barang['JUMLAH_SATUAN']) {
								$err = true;
								$msg = "MSG#ERR#Total jumlah kurang dari jumlah satuan pada Kode Barang : ".$barang['KODE_BARANG']."#edit#";
							}
							if ($err) {
								echo $msg; die();
							}
						}else{
							$arrdata[$i]['data'][0]['JUMLAH'] = $barang["JUMLAH_SATUAN"];
							$arrdata[$i]['data'][0]['GUDANG'] = $gudang_tujuan[$i][0];
							$arrdata[$i]['data'][0]['KONDISI'] = $kondisi[$i][0];
							$arrdata[$i]['data'][0]['RAK'] = $rak[$i][0];
							$arrdata[$i]['data'][0]['SUBRAK'] = $subrak[$i][0];
						}
						$i++;
					}
				}
				#end pengecekan realisasi biasa
				elseif(!empty($chkbreak)){
					#cek jumlah realisasi breakdown & biasa
					$err = false;
					$i = 1;
					foreach ($barang as $val) {
						$arrdata[$i]['KODE_BARANG'] = $val['KODE_BARANG'];
						$arrdata[$i]['JNS_BARANG'] = $val['JNS_BARANG'];
						$arrdata[$i]['KODE_SATUAN'] = $val['KODE_SATUAN'];
						$arrdata[$i]['JUMLAH_SATUAN'] = $val['JUMLAH_SATUAN'];
						$tempJumlah = 0;
						if(count($jumlah_masuk[$i])> 0){
							for ($k=0; $k < count($jumlah_masuk[$i]) ; $k++) { 
								$arrdata[$i]['data'][$k]['JUMLAH'] = $jumlah_masuk[$i][$k];
								$arrdata[$i]['data'][$k]['GUDANG'] = $gudang_tujuan[$i][$k];
								$arrdata[$i]['data'][$k]['KONDISI'] = $kondisi[$i][$k];
								$arrdata[$i]['data'][$k]['RAK'] = $rak[$i][$k];
								$arrdata[$i]['data'][$k]['SUBRAK'] = $subrak[$i][$k];
								$tempJumlah = $tempJumlah + $jumlah_masuk[$i][$k];
								$where = "";
								if($arrdata[$i]['data'][$k]['GUDANG'] != ""){
									$where .= " AND KODE_GUDANG = '".$gudang_tujuan[$i][$k]."'"; 
								}
								if($arrdata[$i]['data'][$k]['KONDISI'] != ""){
									$where .= " AND KONDISI_BARANG = '".$kondisi[$i][$k]."'"; 
								}
								if($arrdata[$i]['data'][$k]['RAK'] != ""){
									$where .= " AND KODE_RAK = '".$rak[$i][$k]."'"; 
								}
								if($arrdata[$i]['data'][$k]['SUBRAK'] != ""){
									$where .= " AND KODE_SUB_RAK = '".$subrak[$i][$k]."'"; 
								}
								$sqlValidasi = "SELECT ID FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."'
												AND KODE_BARANG = '".$val['KODE_BARANG']."' 
												AND JNS_BARANG = '".$val['JNS_BARANG']."'".$where;
								$doValidasi = $this->db->query($sqlValidasi);
								if ($doValidasi->num_rows() < 1) {
									$err = true;
									$msg = "MSG#ERR#Data tidak ditemukan yaitu : Kode Barang ".$val['KODE_BARANG'].", Kode Gudang : ".$gudang_tujuan[$i][$k].", Kondisi Barang : ".$kondisi[$i][$k]." #edit#";
									echo $msg; die();
								}
							}
							if (!in_array($i, array_keys($chkbreak))) {
								if ($tempJumlah > $val['JUMLAH_SATUAN']) {
									$err = true;
									$msg = "MSG#ERR#Total jumlah melebihi jumlah satuan pada Kode Barang : ".$val['KODE_BARANG']."#edit#";
								} elseif ($tempJumlah < $val['JUMLAH_SATUAN']) {
									$err = true;
									$msg = "MSG#ERR#Total jumlah kurang dari jumlah satuan pada Kode Barang : ".$val['KODE_BARANG'].$tempJumlah."#edit#";
								}
								if ($err) {
									echo $msg; die();
								}
							}
						}else{
							$arrdata[$i]['data'][0]['JUMLAH'] = $val["JUMLAH_SATUAN"];
							$arrdata[$i]['data'][0]['GUDANG'] = $gudang_tujuan[$i][0];
							$arrdata[$i]['data'][0]['KONDISI'] = $kondisi[$i][0];
							$arrdata[$i]['data'][0]['RAK'] = $rak[$i][0];
							$arrdata[$i]['data'][0]['SUBRAK'] = $subrak[$i][0];
						}
						$i++;
					}
				}
                foreach ($SQL->result_array() as $row) {
                    $val = $this->cekaddrealisasi($KODE_DOKUMEN, $row["KODE_BARANG"], $row["JNS_BARANG"]);
                    if ($val == "false")
                        $kode = $kode . '<b>' . $row["KODE_BARANG"] . '</b> dgn Jenis Barang <b>' . $row["JNS_BARANG"] . '</b>, ';
                }
                if ($kode) {
                    $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
                    $dtjuml = count(explode(",", $dtkode));
                    $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Barang yang Belum terdaftar, Yaitu : " . $dtkode . "";
                    echo "MSG#ERR#Realisasi Gagal" . $addWarning . "#edit#";
                    die();
                } else {
                    $PROSESPARSIAL = FALSE;
                    $STATUSJUMLAH = array();
					$idx = 0;
                    foreach ($SQL->result_array() as $row) {
                        if ($BREAK) {
							$x = $idx + 1;
                            if (strtoupper($row["BREAKDOWNFLAG"]) == 'Y') {
                                $exec = $this->proses_realisasi_break($KODE_DOKUMEN, $NOMOR_AJU, $row, $INOUT, $LOG);
                            } else {
                                $exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
                            }
                        }
                        if ($PARSIAL) {
							$x = $idx + 1;
                            if (strtoupper($row["PARSIALFLAG"]) == 'Y') {
                                $exec = $this->proses_realisasi_parsial($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG);
                                if ($exec) {
                                    if ($exec == "CEKKEBIASA") {
                                        $exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
                                    }
                                    $REALISASIID = $exec;
                                    $PROSESPARSIAL = TRUE;
                                    $SQLINOUT = $this->db->query("SELECT IFNULL(f_jum_inout('" . $NOMOR_AJU . "','" . $KODE_DOKUMEN . "','" . $KODE_TRADER . "','" . $row["KODE_BARANG"] . "','" . $row["JNS_BARANG"] . "','" . $row["KODE_SATUAN"] . "', '".$row["SERI"]."'),0) AS JUMLAH_INOUT FROM DUAL");
                                    $JUMLAH_INOUT = 0;
                                    if ($SQLINOUT->num_rows() > 0) {
                                        $RS = $SQLINOUT->row();
                                        $JUMLAH_INOUT = $RS->JUMLAH_INOUT;
                                    }
                                    if ($JUMLAH_INOUT == $row["JUMLAH_SATUAN"]) {
                                        $STATUSJUMLAH[] = "YES";
                                    } else {
                                        $STATUSJUMLAH[] = "NO";
                                    }
                                }
                            } else {
                                $exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
                            }
                        }
                        if ($BREAK == "" && $PARSIAL == "") {
							$x = $idx + 1;
                            $exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
                        }
						$idx++;
                    }
                    if ($PROSESPARSIAL) {
						if(strtoupper($KODE_DOKUMEN)=="PPB-PLB" || strtoupper($KODE_DOKUMEN)=="PPK-PLB"){
							if(strtoupper($KODE_DOKUMEN)=="PPB-PLB"){
								$tabel = "ppb";
							}else{
								$tabel = "ppk";
							}
						}else{
							$tabel = $KODE_DOKUMEN;
						}
                        $SQLCHECK = "SELECT NOMOR_AJU FROM T_REALISASI_PARSIAL_HDR WHERE NOMOR_AJU='" . $NOMOR_AJU . "'";
                        if ($func->main->get_result($SQLCHECK)) {
                            $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU));
                            $this->db->update('t_' . strtolower($tabel) . '_hdr', $HEADER);
                        }
                        if (!in_array("NO", $STATUSJUMLAH)) {
                            $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU));
                            $this->db->update('t_' . strtolower($tabel) . '_hdr', array("STATUS_REALISASI" => "1"));
							$this->proses_retur_bc281($NOMOR_AJU);
                        }
                        $this->db->where(array('HDR_REFF' => $REALISASIID));
                        $this->db->delete('t_temp_realisasi_parsial_gudang');
                        $this->db->where(array('HDR_REFF' => $REALISASIID));
                        $this->db->delete('t_temp_realisasi_parsial_dtl');
                        $this->db->where(array('REALISASIID' => $REALISASIID));
                        $exec = $this->db->delete('t_temp_realisasi_parsial_hdr');
                    } else {
						if(strtoupper($KODE_DOKUMEN)=="PPB-PLB" || strtoupper($KODE_DOKUMEN)=="PPK-PLB"){
							if(strtoupper($KODE_DOKUMEN)=="PPB-PLB"){
								$tabel = "ppb";
							}else{
								$tabel = "ppk";
							}
						}else{
							$tabel = $KODE_DOKUMEN;
						}
                        if ($exec) {
                            $HEADER["STATUS_REALISASI"] = "1";
                            $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, "KODE_TRADER"=>$KODE_TRADER));
                            $exec = $this->db->update('t_' . strtolower($tabel) . '_hdr', $HEADER);
							#$this->proses_retur_bc281($NOMOR_AJU);
                        }
                    }
                }
                if ($exec) {
                    $ADDREMARK = "";
                    if ($PROSESPARSIAL)
                        $ADDREMARK = "REALISASI PARSIAL, ";
                    $REMARK = $ADDREMARK . "NO. AJU=" . $NOMOR_AJU . ", NO.PENERIMAAN=" . $HEADER["NOMOR_DOK_INTERNAL"] . ", TGL.PENERIMAAN=" . $HEADER["TANGGAL_DOK_INTERNAL"];
                    $func->main->activity_log("REALISASI PEMASUKAN " . strtoupper($KODE_DOKUMEN), $REMARK);
                    echo "MSG#OK#Realisasi Berhasil, silahkan proses data lainnya.#edit#";
                }else {
                    echo "MSG#ERR#Realisasi Gagal, cek kembali data anda#edit#";
                }
            } else {
                echo "MSG#ERR#Realisasi Gagal, cek kembali data anda#edit#";
            }
        } else if ($this->input->post('act') == "update") {
            $NOMOR_AJU = $this->input->post("ajuEdit");
            $HEADER["NOMOR_AJU"] = $NOMOR_AJU;
            $HEADER["UPDATED_BY"] = $this->newsession->userdata('KODE_TRADER');
            $HEADER["UPDATED_TIME"] = date("Y-m-d H:i:s");
			$this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, "KODE_TRADER"=>$KODE_TRADER));
			$exec = $this->db->update('t_'.$KODE_DOKUMEN.'_hdr', $HEADER);
            if ($exec) {
                $REMARK = "NO. AJU=" . $NOMOR_AJU . ", NO.PENERIMAAN=" . $HEADER["NOMOR_DOK_INTERNAL"] . ", TGL.PENERIMAAN=" . $HEADER["TANGGAL_DOK_INTERNAL"];
                $func->main->activity_log("EDIT REALISASI PEMASUKAN " . $KODE_DOKUMEN, $REMARK);
                echo "MSG#OK#Ubah Realisasi Berhasil#edit#".site_url()."/realisasi/in#";
            } else {
                echo "MSG#ERR#Ubah Realisasi Gagal#edit#";
            }
        }
	}
	
	function proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $DETIL, $HEADER, $INOUT, $LOG, $x, $arrdata) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$count = count($arrdata[$x]['data']);
		if($this->input->post('PARSIAL')){
			$query = "SELECT NOMOR_AJU FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER = '".$KODE_TRADER."' 
						AND KODE_DOKUMEN = '".$KODE_DOKUMEN."' AND KODE_BARANG = '".$DETIL["KODE_BARANG"]."' 
						AND JNS_BARANG = '".$DETIL["JNS_BARANG"]."' AND SERI_DOKUMEN = '".$DETIL["SERI"]."' 
						AND (PARSIAL_FLAG = '' OR PARSIAL_FLAG IS NULL) AND NOMOR_AJU = '".$NOMOR_AJU."'";
			$check = $func->main->get_uraian($query,"NOMOR_AJU");
		}else{
			$check = false;	
		}
		if(!$check){
			for ($i=0; $i < $count; $i++) {
				$jumlah_proses = $arrdata[$x]['data'][$i]['JUMLAH'];
				if($arrdata[$x]['data'][$i]['SUBRAK']==NULL){
					$arrdata[$x]['data'][$i]['SUBRAK'] = "";
				}
				$SQL2 = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
					   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $DETIL["KODE_BARANG"] . "' 
					   AND JNS_BARANG='" . $DETIL["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
		
				if (strtoupper($DETIL["PARSIALFLAG"]) == 'Y') {
					$SQLINOUT = "SELECT IFNULL(f_jum_inout('" . $NOMOR_AJU . "','" . $KODE_DOKUMEN . "','" . $KODE_TRADER . "','" . $DETIL["KODE_BARANG"] . "','" . $DETIL["JNS_BARANG"] . "','" . $DETIL["KODE_SATUAN"] . "','".$INOUT["SERI_DOKUMEN"]."'),0) AS JUMLAH_INOUT FROM DUAL";
					$RSINOUT = $this->db->query($SQLINOUT);
					$JUMUDAHINOUT = 0;
					if ($RSINOUT->num_rows() > 0) {
						$VALINOUT = $RSINOUT->row();
						$JUMUDAHINOUT = $VALINOUT->JUMLAH_INOUT;
					}
					$jumlah1 = $DETIL["JUMLAH_SATUAN"] - $JUMUDAHINOUT;
				} else {
					$jumlah1 = $jumlah_proses;
				}
				$kdsatuan1 = $DETIL["KODE_SATUAN"];
				
				$VALBRG = $this->db->query($SQL2)->row();
				$jumlah2 = $VALBRG->STOCK_AKHIR;
				$kdsatuan2 = $VALBRG->KODE_SATUAN;
				$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
				$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
		
				if (empty($jmlsatuanKecil))
					$jmlsatuanKecil = 1;
				$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
		
				if ($kdsatuanKecil) {
					if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)) {
						$JUMLAH_BARANG = $jumlah1;
					} else {
						if (empty($jmlsatuanKecil))
							$jmlsatuanKecil = 1;
						$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
					}
				}else {
					$JUMLAH_BARANG = $jumlah1;
				}
				
				#insert data inout
				$INOUT["KODE_BARANG"] 		= $DETIL["KODE_BARANG"];
				$INOUT["JNS_BARANG"] 		= $DETIL["JNS_BARANG"];
				$INOUT["JUMLAH"] 			= $JUMLAH_BARANG;
				$INOUT["KODE_GUDANG"] 		= $arrdata[$x]['data'][$i]['GUDANG'];
				$INOUT["KONDISI_BARANG"] 	= $arrdata[$x]['data'][$i]['KONDISI'];
				$INOUT["KODE_RAK"] 			= $arrdata[$x]['data'][$i]['RAK'];
				$INOUT["KODE_SUB_RAK"] 		= $arrdata[$x]['data'][$i]['SUBRAK'];
				$INOUT["CREATED_TIME"] 		= date('Y-m-d H:i:s', time() - 60 * 60 * 1);
				$INOUT["SERI_DOKUMEN"] 		= $DETIL["SERI"];
				$exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
				if ($exec) {
					#update m_trader_barang_gudang
					$this->db->where(array(
											"KODE_BARANG" 		=> $DETIL["KODE_BARANG"],
											"JNS_BARANG"		=> $DETIL["JNS_BARANG"],
											"KODE_TRADER" 		=> $KODE_TRADER
										   )
									  );
					if($arrdata[$x]['data'][$i]['GUDANG'] != ""){
						$this->db->where("KODE_GUDANG = ", $arrdata[$x]['data'][$i]['GUDANG']); 
					}
					if($arrdata[$x]['data'][$i]['KONDISI'] != ""){
						$this->db->where("KONDISI_BARANG = ", $arrdata[$x]['data'][$i]['KONDISI']);
					}
					if($arrdata[$x]['data'][$i]['RAK'] != ""){
						$this->db->where("KODE_RAK = ", $arrdata[$x]['data'][$i]['RAK']);
					}
					if($arrdata[$x]['data'][$i]['SUBRAK'] != ""){
						$this->db->where("KODE_SUB_RAK = ", $arrdata[$x]['data'][$i]['SUBRAK']);
					}
					$this->db->set('JUMLAH', 'JUMLAH+'.(float)$JUMLAH_BARANG, FALSE);
					$this->db->update('m_trader_barang_gudang');
				}
			}
			$SQL2 = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
				   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $DETIL["KODE_BARANG"] . "' 
				   AND JNS_BARANG='" . $DETIL["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
	
			if (strtoupper($DETIL["PARSIALFLAG"]) == 'Y') {
				$SQLINOUT = "SELECT IFNULL(f_jum_inout('" . $NOMOR_AJU . "','" . $KODE_DOKUMEN . "','" . $KODE_TRADER . "','" . $DETIL["KODE_BARANG"] . "','" . $DETIL["JNS_BARANG"] . "','" . $DETIL["KODE_SATUAN"] . "','".$INOUT["SERI_DOKUMEN"]."'),0) AS JUMLAH_INOUT FROM DUAL";
				$RSINOUT = $this->db->query($SQLINOUT);
				$JUMUDAHINOUT = 0;
				if ($RSINOUT->num_rows() > 0) {
					$VALINOUT = $RSINOUT->row();
					$JUMUDAHINOUT = $VALINOUT->JUMLAH_INOUT;
				}
				$jumlah1 = $DETIL["JUMLAH_SATUAN"] - $JUMUDAHINOUT;
			} else {
				$jumlah1 = $DETIL["JUMLAH_SATUAN"];
			}
			$kdsatuan1 = $DETIL["KODE_SATUAN"];
	
			$VALBRG = $this->db->query($SQL2)->row();
			$jumlah2 = $VALBRG->STOCK_AKHIR;
			$kdsatuan2 = $VALBRG->KODE_SATUAN;
			$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
			$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
	
			if (empty($jmlsatuanKecil))
				$jmlsatuanKecil = 1;
			$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
	
			if ($kdsatuanKecil) {
				if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)) {
					$JUMLAH_BARANG = $jumlah1;
				} else {
					if (empty($jmlsatuanKecil))
						$jmlsatuanKecil = 1;
					$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
				}
			}else {
				$JUMLAH_BARANG = $jumlah1;
			}
	
			$LOG["KODE_BARANG"] 	= $DETIL["KODE_BARANG"];		
			$LOG["JNS_BARANG"] 		= $DETIL["JNS_BARANG"];
			$LOG["SERI_BARANG"] 	= $DETIL["SERI"];
			$LOG["NAMA_BARANG"] 	= $DETIL["URAIAN_BARANG"];
			$LOG["SATUAN"] 			= $kdsatuanKecil;
			$LOG["JUMLAH"] 			= $JUMLAH_BARANG;
			$LOG["SALDO"] 			= $JUMLAH_BARANG;
			$LOG["NILAI_PABEAN"] 	= $DETIL["CIF"];
			$LOG["NOMOR_AJU"] 		= $NOMOR_AJU;
	
			/*$this->db->where(array(
									"KODE_BARANG" 	=> $DETIL["KODE_BARANG"],
									"JNS_BARANG" 	=> $DETIL["JNS_BARANG"],
									"KODE_TRADER" 	=> $KODE_TRADER
									)
							);
			$this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMLAH_BARANG + $jumlah2));
			*/
			$exec = $this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);
			if ($exec){
				return true;
			}else{
				return false;
			}
		}else{
			return true;	
		}
    }
	
	function proses_realisasi_break($KODE_DOKUMEN, $NOMOR_AJU, $DETIL, $INOUT, $LOG) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $SQLB = "SELECT A.NOMOR_AJU,A.SERI,A.KODE_BARANG,A.JNS_BARANG,A.JUMLAH,A.KODE_SATUAN, 
			   f_barang(A.KODE_BARANG,A.JNS_BARANG,B.KODE_TRADER) URAIAN_BARANG, A.HARGA_SATUAN
			   FROM t_breakdown_pemasukan A, t_" . strtolower($KODE_DOKUMEN) . "_hdr B
			   WHERE A.KODE_TRADER = B.KODE_TRADER AND A.NOMOR_AJU=B.NOMOR_AJU AND A.NOMOR_AJU='" . $NOMOR_AJU . "' 
			   AND A.SERI='" . $DETIL["SERI"] . "' 
			   AND A.KODE_TRADER = '".$KODE_TRADER."'";
        $hsl = $func->main->get_result($SQLB);
        if ($hsl) {
            foreach ($SQLB->result_array() as $VALBREAK) {
                $kdsatuan1 = $VALBREAK["KODE_SATUAN"];
                $SQL2 = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
					   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $VALBREAK["KODE_BARANG"] . "' 
					   AND JNS_BARANG='" . $VALBREAK["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";

                $VALBRG = $this->db->query($SQL2)->row();
                $jumlah2 = $VALBRG->STOCK_AKHIR;
                $kdsatuan2 = $VALBRG->KODE_SATUAN;
                $kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
                $jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
				
				$QUERY = "SELECT KODE_GUDANG, KONDISI_BARANG,KODE_RAK, KODE_SUB_RAK, JUMLAH FROM t_breakdown_gudang WHERE 
						  KODE_TRADER = '".$KODE_TRADER."' AND NOMOR_AJU = '".$VALBREAK["NOMOR_AJU"]."'
						  AND SERI = '".$VALBREAK["SERI"]."' AND KODE_BARANG = '".$VALBREAK["KODE_BARANG"]."'
						  AND JNS_BARANG = '".$VALBREAK["JNS_BARANG"]."'";
				$rs = $func->main->get_result($QUERY);
				if($rs){
					foreach ($QUERY->result_array() as $VALBREAKDTL) {
						$jml1 = $VALBREAKDTL["JUMLAH"];
						if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
						$JUMLAH_BARANG_GUDANG = $jml1 * $jmlsatuanKecil;
		
						if ($kdsatuanKecil) {
							if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)) {
								$JUMLAH_BARANG_GUDANG = $jml1;
							} else {
								if (empty($jmlsatuanKecil))
									$jmlsatuanKecil = 1;
								$JUMLAH_BARANG_GUDANG = $jml1 * $jmlsatuanKecil;
							}
						}else {
							$JUMLAH_BARANG_GUDANG = $jml1;
						}
						#insrt inout
						$INOUT["KODE_BARANG"] 		= $VALBREAK["KODE_BARANG"];
						$INOUT["JNS_BARANG"] 		= $VALBREAK["JNS_BARANG"];
						$INOUT["KODE_GUDANG"] 		= $VALBREAKDTL["KODE_GUDANG"];
						$INOUT["KONDISI_BARANG"] 	= $VALBREAKDTL["KONDISI_BARANG"];
						$INOUT["KODE_RAK"] 			= $VALBREAKDTL["KODE_RAK"];
						$INOUT["KODE_SUB_RAK"] 		= $VALBREAKDTL["KODE_SUB_RAK"];
						$INOUT["JUMLAH"] 			= $JUMLAH_BARANG_GUDANG;
						$INOUT["CREATED_TIME"] 		= date('Y-m-d H:i:s', time() - 60 * 60 * 1);
						$INOUT["SERI_DOKUMEN"] 		= $DETIL["SERI"];
						$INOUT["BREAKDOWN_FLAG"] 	= "Y";
               			$this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
						
						#update gudang barang
						$this->db->set("JUMLAH","JUMLAH + ".(float)$JUMLAH_BARANG_GUDANG,FALSE);
						$this->db->where(array
											(
												"KODE_TRADER" 		=> $KODE_TRADER,
												"KODE_BARANG"		=> $VALBREAK["KODE_BARANG"],
												"JNS_BARANG"		=> $VALBREAK["JNS_BARANG"]
											)
										);
						if($arrdata[$x]['data'][$i]['GUDANG'] != ""){
							$this->db->where("KODE_GUDANG = ", $arrdata[$x]['data'][$i]['GUDANG']); 
						}
						if($arrdata[$x]['data'][$i]['KONDISI'] != ""){
							$this->db->where("KONDISI_BARANG = ", $arrdata[$x]['data'][$i]['KONDISI']);
						}
						if($arrdata[$x]['data'][$i]['RAK'] != ""){
							$this->db->where("KODE_RAK = ", $arrdata[$x]['data'][$i]['RAK']);
						}
						if($arrdata[$x]['data'][$i]['SUBRAK'] != ""){
							$this->db->where("KODE_SUB_RAK = ", $arrdata[$x]['data'][$i]['SUBRAK']);
						}
						$this->db->update("M_TRADER_BARANG_GUDANG");						
					}					
				}

                $jumlah1 = $VALBREAK["JUMLAH"];

                if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
                $JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;

                if ($kdsatuanKecil) {
                    if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)) {
                        $JUMLAH_BARANG = $jumlah1;
                    } else {
                        if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
                        $JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
                    }
                }else {
                    $JUMLAH_BARANG = $jumlah1;
                }

                $LOG["KODE_BARANG"] = $VALBREAK["KODE_BARANG"];
                $LOG["JNS_BARANG"] 	= $VALBREAK["JNS_BARANG"];
                $LOG["SERI_BARANG"] = $DETIL["SERI"];
                $LOG["NAMA_BARANG"] = $VALBREAK["URAIAN_BARANG"];
                $LOG["SATUAN"] 		= $kdsatuanKecil;
                $LOG["JUMLAH"] 		= $JUMLAH_BARANG;
                $LOG["SALDO"] 		= $JUMLAH_BARANG;
        		$LOG["NOMOR_AJU"] 	= $NOMOR_AJU;

                $NILAIPABEAN = $JUMLAH_BARANG * $VALBREAK["HARGA_SATUAN"];
                $LOG["NILAI_PABEAN"] = $NILAIPABEAN;
                $exec = $this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);
            }
            if ($exec)
                return true;
        }
        return false;
    }
	
	function proses_retur_bc281($NOMOR_AJU){
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$SQL = "SELECT NOMOR, TANGGAL, NOMOR_AJU_BC23 FROM T_BC27_DOK WHERE KODE_DOKUMEN='B23'
				AND KODE_TRADER='".$KODE_TRADER."' AND NOMOR_AJU='".$NOMOR_AJU."'";	
	 	$RS = $func->main->get_result($SQL);
        if($RS){
            foreach($SQL->result_array() as $VAL) {		
				$SQK = "SELECT * FROM T_LOGBOOK_PENGELUARAN WHERE KODE_TRADER='".$KODE_TRADER."' 
						AND NO_DOK_MASUK='".$VAL["NOMOR"]."' AND TGL_DOK_MASUK='".$VAL["TANGGAL"]."'"; 
				$RS = $func->main->get_result($SQK);
				if($RS){
					foreach($SQK->result_array() as $ROW) {	
						if($ROW["LOGID_MASUK"]){
							$SQLUPDATE = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO = SALDO + ".$ROW["JUMLAH"]." 
										  WHERE LOGID='".$ROW["LOGID_MASUK"]."' AND KODE_TRADER='".$KODE_TRADER."'"; 
						}
						else{
							$SQLUPDATE = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO = SALDO + ".$ROW["JUMLAH"]." 
										  WHERE KODE_BARANG='".$ROW["KODE_BARANG"]."' AND JNS_BARANG='".$ROW["JNS_BARANG"]."'
										  AND KODE_TRADER='".$KODE_TRADER."' AND NO_DOK='".$ROW["NO_DOK_MASUK"]."'
										  AND TGL_DOK='".$ROW["TGL_DOK_MASUK"]."'"; 
	
						}
						if($this->db->query($SQLUPDATE)){
							$SQL = "SELECT SALDO FROM T_LOGBOOK_PEMASUKAN WHERE LOGID = '".$ROW["LOGID_MASUK"]."'
									AND KODE_TRADER='".$KODE_TRADER."'";
							$GET = $this->db->query($SQL);
							if($GET->num_rows()>0){
								$DATA = $GET->row();
								if($DATA->SALDO > 0){
									$this->db->where(array('LOGID' => $ROW["LOGID_MASUK"]));
									$this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => NULL));
								}	
							}
						}                        
					}
				}
			}
		}
	}
	
	function proses_realisasi_parsial($KODE_DOKUMEN, $NOMOR_AJU, $DETIL, $HEADER, $INOUT, $LOG) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $SQLP = "SELECT A.REALISASIID, B.KODE_BARANG, B.JNS_BARANG, B.JUMLAH, B.SATUAN, B.NILAI_BARANG, B.REALISASIDTLID, B.SERI
				 FROM t_temp_realisasi_parsial_hdr A, t_temp_realisasi_parsial_dtl B 
				 WHERE A.REALISASIID = B.HDR_REFF AND
				 A.NOMOR_AJU='" . $NOMOR_AJU . "' 
				 AND A.KODE_TRADER='" . $KODE_TRADER . "' AND A.NO_DOK_INTERNAL IS NULL
				 AND B.KODE_BARANG='" . $DETIL["KODE_BARANG"] . "' AND B.JNS_BARANG='" . $DETIL["JNS_BARANG"] . "'
				 AND B.SERI='".$DETIL["SERI"]."'";
        $rs = $this->db->query($SQLP);
        if ($rs->num_rows() > 0) {
            $VALPARSIAL = $rs->row();
            $REALISASIID = $VALPARSIAL->REALISASIID;
            $REALISASIDTLID = $VALPARSIAL->REALISASIDTLID;
            $jumlah1 = $VALPARSIAL->JUMLAH;
            $kdsatuan1 = $VALPARSIAL->SATUAN;
            # jika jumlah = 0
            if ($jumlah1 == 0) {
            	return $REALISASIID;
            }
			
			$QUERY = "SELECT REALISASIID FROM t_realisasi_parsial_hdr
					  WHERE REALISASIID = '" . $VALPARSIAL->REALISASIID . "'";
            if (!$func->main->get_result($QUERY)) {
                $datahdr["REALISASIID"] 		= $VALPARSIAL->REALISASIID;
                $datahdr["KODE_TRADER"] 		= $KODE_TRADER;
                $datahdr["NOMOR_AJU"] 			= $NOMOR_AJU;
                $datahdr["JENIS_DOK"] 			= $KODE_DOKUMEN;
                $datahdr["NO_DOK_INTERNAL"] 	= $HEADER["NOMOR_DOK_INTERNAL"];
                $datahdr["TGL_DOK_INTERNAL"] 	= $HEADER["TANGGAL_DOK_INTERNAL"];
                $datahdr["TGL_REALISASI"] 		= $HEADER["TANGGAL_REALISASI"];
                $datahdr["TGL_TRANSAKSI"] 		= date("Y-m-d H:i:s");
                $this->db->insert('t_realisasi_parsial_hdr', $datahdr);
            }
            $datadtl["HDR_REFF"] 		= $VALPARSIAL->REALISASIID;
            $datadtl["KODE_BARANG"] 	= $VALPARSIAL->KODE_BARANG;
            $datadtl["JNS_BARANG"]		= $VALPARSIAL->JNS_BARANG;
            $datadtl["JUMLAH"] 			= $jumlah1;
            $datadtl["SATUAN"] 			= $kdsatuan1;
            $datadtl["SERI"] 			= $DETIL["SERI"];
            $datadtl["NILAI_BARANG"] 	= $VALPARSIAL->NILAI_BARANG;
            $this->db->insert('t_realisasi_parsial_dtl', $datadtl);
			$DTLID = $this->db->insert_id();
			
			$INOUT["KODE_BARANG"]	 = $VALPARSIAL->KODE_BARANG;
            $INOUT["JNS_BARANG"] 	= $VALPARSIAL->JNS_BARANG;
            $INOUT["CREATED_TIME"] 	= date('Y-m-d H:i:s', time() - 60 * 60 * 1);
			
			 $SQL2 = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL, URAIAN_BARANG
				   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $VALPARSIAL->KODE_BARANG . "' 
				   AND JNS_BARANG='" . $VALPARSIAL->JNS_BARANG . "' AND KODE_TRADER='" . $KODE_TRADER . "'";

            $VALBRG = $this->db->query($SQL2)->row();
            $jumlah2 = $VALBRG->STOCK_AKHIR;
            $kdsatuan2 = $VALBRG->KODE_SATUAN;
            $kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
            $jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
            $uraianbarang = $VALBRG->URAIAN_BARANG;
			
			$SQL = "SELECT KODE_BARANG, JNS_BARANG, SERI, KODE_GUDANG, KONDISI_BARANG, KODE_RAK,KODE_SUB_RAK, JUMLAH 
					FROM t_temp_realisasi_parsial_gudang
					WHERE REALISASIDTLID = ".$REALISASIDTLID." AND HDR_REFF = '".$REALISASIID."' AND SERI = '".$VALPARSIAL->SERI."'";
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row){
					$JML = $row["JUMLAH"];
					if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
					$JML_BRG = $JML * $jmlsatuanKecil;
		
					if ($kdsatuanKecil) {
						if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)) {
							$JML_BRG = $JML;
						} else {
							if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
							$JML_BRG = $JML * $jmlsatuanKecil;
						}
					}else {
						$JML_BRG = $JML;
					}
					
					$GUDANG["REALISASIDTLID"] 	= $DTLID;
					$GUDANG["HDR_REFF"] 		= $REALISASIID;
					$GUDANG["KODE_BARANG"] 		= $DETIL["KODE_BARANG"];
					$GUDANG["JNS_BARANG"] 		= $DETIL["JNS_BARANG"];
					$GUDANG["KODE_GUDANG"] 		= $row["KODE_GUDANG"];
					$GUDANG["KONDISI_BARANG"] 	= $row["KONDISI_BARANG"];
					$GUDANG["KODE_RAK"] 		= $row["KODE_RAK"];
					$GUDANG["KODE_SUB_RAK"] 	= $row["KODE_SUB_RAK"];
					$GUDANG["SERI"] 			= $DETIL["SERI"];
					$GUDANG["JUMLAH"] 			= $row["JUMLAH"];
					$this->db->insert("t_realisasi_parsial_gudang",$GUDANG);
					
					$this->db->set("JUMLAH", "JUMLAH + ".(float)$JML_BRG, FALSE);
					$this->db->where(array
										(
											"KODE_TRADER"		=> $KODE_TRADER,
											"KODE_BARANG"		=> $DETIL["KODE_BARANG"],
											"JNS_BARANG"		=> $DETIL["JNS_BARANG"]
										)
									);
					if($arrdata[$x]['data'][$i]['GUDANG'] != ""){
						$this->db->where("KODE_GUDANG = ", $arrdata[$x]['data'][$i]['GUDANG']); 
					}
					if($arrdata[$x]['data'][$i]['KONDISI'] != ""){
						$this->db->where("KONDISI_BARANG = ", $arrdata[$x]['data'][$i]['KONDISI']);
					}
					if($arrdata[$x]['data'][$i]['RAK'] != ""){
						$this->db->where("KODE_RAK = ", $arrdata[$x]['data'][$i]['RAK']);
					}
					if($arrdata[$x]['data'][$i]['SUBRAK'] != ""){
						$this->db->where("KODE_SUB_RAK = ", $arrdata[$x]['data'][$i]['SUBRAK']);
					}
					$this->db->update("M_TRADER_BARANG_GUDANG");
					// $sqlMax = "SELECT MAX(SERI) AS MAX FROM M_TRADER_BARANG_INOUT";
            		$INOUT["JUMLAH"] 			= $JML_BRG;
					$INOUT["PARSIAL_FLAG"] 		= "Y";
					$INOUT["KODE_GUDANG"] 		= $row["KODE_GUDANG"];
					$INOUT["KONDISI_BARANG"] 	= $row["KONDISI_BARANG"];
					$INOUT["KODE_RAK"] 			= $row["KODE_RAK"];
					$INOUT["KODE_SUB_RAK"] 		= $row["KODE_SUB_RAK"];
					$INOUT["SERI_DOKUMEN"] 		= $row["SERI"];
					// print_r($INOUT); die();
					$this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
				}
			}

            if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
            $JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;

            if ($kdsatuanKecil) {
                if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)) {
                    $JUMLAH_BARANG = $jumlah1;
                } else {
                    if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
                    $JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
                }
            }else {
                $JUMLAH_BARANG = $jumlah1;
            }

            $LOG["KODE_BARANG"] 	= $VALPARSIAL->KODE_BARANG;
            $LOG["JNS_BARANG"] 		= $VALPARSIAL->JNS_BARANG;
            $LOG["SERI_BARANG"] 	= $DETIL["SERI"];
            $LOG["JUMLAH"] 			= $JUMLAH_BARANG;
            $LOG["SALDO"] 			= $JUMLAH_BARANG;
            $LOG["SATUAN"] 			= $kdsatuanKecil;
            $LOG["NAMA_BARANG"] 	= $uraianbarang;
            $LOG["NOMOR_AJU"] 		= $NOMOR_AJU;
            $LOG["NILAI_PABEAN"] 	= $VALPARSIAL->NILAI_BARANG?$VALPARSIAL->NILAI_BARANG:$DETIL["CIF"];

            $exec = $this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);
            if ($exec){
                $RET = $REALISASIID;
            }else{
                $RET = FALSE;
			}
        }
        else {
            $RET = "CEKKEBIASA";
        }
        return $RET;
    }
	
	function breakdownDtlBarang($AJU="",$SERI="",$JUMLAH="",$DOKUMEN="",$DEL="") {
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
        $KODETRADER = $this->newsession->userdata('KODE_TRADER');
        $SQL = "SELECT  REPLACE(REPLACE(KODE_BARANG, '/', '^'), ' ', '~') AS 'KODE BARANG', 
				f_ref('ASAL_JENIS_BARANG',JNS_BARANG) 'JENIS BARANG', 
				f_barang(KODE_BARANG,JNS_BARANG,'" . $KODETRADER . "') URAIAN, JUMLAH, KODE_SATUAN 'SATUAN', 
				HARGA_SATUAN 'HARGA SATUAN', NOMOR_AJU, SERI,JNS_BARANG, '" . $DOKUMEN . "' AS DOKUMEN, 'in' as dok
				FROM t_breakdown_pemasukan 
				WHERE NOMOR_AJU='" . $AJU . "' AND SERI='" . $SERI . "' AND KODE_TRADER = '".$KODETRADER."'";

        $JML = (float) $func->main->get_uraian("SELECT IFNULL(SUM(JUMLAH),0) SUMJUMLAH FROM t_breakdown_pemasukan
									           WHERE NOMOR_AJU='" . $AJU . "' AND SERI='" . $SERI . "' 
											   AND KODE_TRADER = '".$KODETRADER."'
										       GROUP BY NOMOR_AJU, SERI", "SUMJUMLAH");
											   
		$HARGA_BARANG = (float) $func->main->get_uraian("SELECT IFNULL(SUM(HARGA_SATUAN),0) SUMJUMLAH FROM t_breakdown_pemasukan
													     WHERE NOMOR_AJU='" . $AJU . "' AND SERI='" . $SERI . "' 
													     AND KODE_TRADER = '".$KODETRADER."'
													     GROUP BY NOMOR_AJU, SERI", "SUMJUMLAH")*$JML;

        $process = array('Tambah' => array('GET2POP', site_url() . "/realisasi/breakdownin_prosesForm/save/$AJU/$SERI/$JUMLAH/$JML/$DOKUMEN/$HARGA_BARANG", '0','icon-plus'),
            			 'Ubah' => array('GET2POP', site_url() . "/realisasi/breakdownin_prosesForm/update/$AJU/$SERI/$JUMLAH/$JML/$DOKUMEN/$HARGA_BARANG", '1','icon-pencil'),
            			 'Hapus' => array('DELETE', site_url() . '/realisasi/breakdownin_prosesForm/' . $JUMLAH, 'fbreakdownbrg', 'icon-remove red'));

        $this->newtable->keys(array('KODE BARANG', 'JNS_BARANG', 'NOMOR_AJU', 'SERI', 'DOKUMEN','dok'));
        $this->newtable->hiddens(array('NOMOR_AJU', 'SERI', 'NOMOR_PROSES', 'JNS_BARANG', 'DOKUMEN','dok'));

        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->action(site_url() . "/realisasi/page_break/$AJU/$SERI/$JUMLAH/$DOKUMEN/in");
		$this->newtable->detail(site_url()."/realisasi/breakdown_proses_detil_in");
		$this->newtable->detail_tipe("detil_priview_bottom");			
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("fbreakdownbrg");
        $this->newtable->set_divid("divbreakdownbrg");
        $this->newtable->ciuri($ciuri);
        $this->newtable->show_search(false);
        $this->newtable->tipe_proses('button');
        $this->newtable->orderby(1);
        $this->newtable->sortby("DESC");
        $this->newtable->clear();
        $this->newtable->rowcount(100);
        $this->newtable->menu($process);
        $this->newtable->top_title('Detil Barang [ Total Jumlah Detil Barang : ' . $JML . ' ]');
        $tabel.= $this->newtable->generate($SQL);
		$arrdata = array("DETILBARANG" => $tabel);
		if ($this->input->post("ajax")){
            return $tabel;
		}else{
            return $tabel;
		}
    }
	
	function getBarang() {
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$aju = $this->input->post('nomor_aju');
		$dok = $this->input->post('kode_dokumen');
		$break = $this->input->post('breakdown');
		$parsial = $this->input->post('parsial');
		if($dok=="ppb-plb") $dok = "ppb";
		elseif($dok=="ppk-plb") $dok = "ppk";
		$jns_barang = "JNS_BARANG";
		$sql = "SELECT KODE_BARANG, f_ref('ASAL_JENIS_BARANG',".$jns_barang.") AS URAIAN, KODE_SATUAN, JUMLAH_SATUAN, 
				".$jns_barang." AS 'JNS_BARANG' ,SERI,BREAKDOWN_FLAG, PARSIAL_FLAG
				FROM t_".$dok."_dtl
				WHERE NOMOR_AJU = '".$aju."' AND KODE_TRADER = '".$kode_trader."'";
		$rs = $this->db->query($sql);
		$i = 1;
		$html = "";
		if($rs->num_rows()>0){
			$VALID = TRUE;
			$VALID_SATUAN = TRUE;
			foreach($rs->result_array() as $row){
				$checked = ""; $style = 'style="display:none"'; $class = 'class="parent"'; $disabled = "";
				if($row["BREAKDOWN_FLAG"]=="Y" && !$break){
					$query_update = "UPDATE t_".$dok."_dtl SET BREAKDOWN_FLAG = NULL 
									 WHERE KODE_TRADER = '".$kode_trader."'  AND NOMOR_AJU = '".$aju."' 
									 AND KODE_BARANG = '".$row["KODE_BARANG"]."'
									 AND ".$jns_barang." = '".$row["JNS_BARANG"]."' AND SERI = ".$row["SERI"];
					$this->db->query($query_update);
					$this->db->query("UPDATE t_".$dok."_hdr SET BREAKDOWN_FLAG = 'N' 
									 WHERE KODE_TRADER = '".$kode_trader."'  AND NOMOR_AJU = '".$aju."'");
				}
				if($row["PARSIAL_FLAG"]=="Y" && !$parsial){
					$query_update = "UPDATE t_".$dok."_dtl SET PARSIAL_FLAG = 'N' 
									 WHERE KODE_TRADER = '".$kode_trader."' AND NOMOR_AJU = '".$aju."' 
									 AND KODE_BARANG = '".$row["KODE_BARANG"]."'
									 AND ".$jns_barang." = '".$row["JNS_BARANG"]."' AND SERI = ".$row["SERI"];
					$this->db->query($query_update);
					$this->db->query("UPDATE t_".$dok."_hdr SET PARSIAL_FLAG = NULL 
									 WHERE KODE_TRADER = '".$kode_trader."'  AND NOMOR_AJU = '".$aju."'");
				}
				$wajib = ' wajib="yes" ';
				if(($row["BREAKDOWN_FLAG"]=="Y" && $break) || ($row["PARSIAL_FLAG"]=="Y" && $parsial)){
					$checked = 'checked="checked"';
					$style = '';
					$class = 'class="selected-break"';
					$disabled = 'disabled="disabled"';
					$wajib = '';
				}
				if($break) $onclick = 'onclick="breakdown_proses('.$i.',\'realisasi\',\'in\')"';
				if($parsial) $onclick = 'onclick="parsial_proses(\'realisasi\','.$i.',\'in\')"';
				#CEK GUDANG
				$SQG = "SELECT A.KODE_GUDANG, CONCAT(A.KODE_GUDANG,' - ',A.NAMA_GUDANG) NAMA_GUDANG 
						FROM M_TRADER_GUDANG A, M_TRADER_BARANG_GUDANG B 
						WHERE B.KODE_TRADER = '".$kode_trader."'
						AND A.KODE_TRADER = B.KODE_TRADER AND A.KODE_GUDANG = B.KODE_GUDANG
						AND B.KODE_BARANG='".$row["KODE_BARANG"]."' AND B.JNS_BARANG='".$row["JNS_BARANG"]."'
						ORDER BY A.KODE_GUDANG";
				$KODE_GUDANG = $func->main->get_combobox($SQG,"KODE_GUDANG", "NAMA_GUDANG", TRUE);
				if(count($KODE_GUDANG)==0){
					$KODE_GUDANG = array(''=>'Tidak Dikenal')	;
				}else{
					foreach($KODE_GUDANG as $a => $b){
						$KODE_GUDANG_FIRST = $a;
						break;
					}	
				}
				
				#CEK KONDISI
				$SQK = "SELECT KONDISI_BARANG FROM M_TRADER_BARANG_GUDANG
						WHERE KODE_TRADER='".$kode_trader."'
						AND KODE_BARANG='".$row["KODE_BARANG"]."' AND JNS_BARANG='".$row["JNS_BARANG"]."'";
				$KODE_KODISI = $func->main->get_combobox($SQK,"KONDISI_BARANG", "KONDISI_BARANG", FALSE);	
				if(count($KODE_KODISI)==0){
					$KODE_KODISI = array(''=>'Tidak Dikenal')	;
				}else{
					foreach($KODE_KODISI as $a => $b){
						$KODE_KODISI_FIRST = $a;
						break;
					}
				}
				
				#CEK RAK
				$SQR = "SELECT KODE_RAK FROM M_TRADER_BARANG_GUDANG
						WHERE KODE_TRADER='".$kode_trader."'
						AND KODE_BARANG='".$row["KODE_BARANG"]."' AND JNS_BARANG='".$row["JNS_BARANG"]."'";
				$KODE_RAK = $func->main->get_combobox($SQR,"KODE_RAK", "KODE_RAK", FALSE);	
				if(count($KODE_RAK)==0){
					$KODE_RAK = array(''=>'Tidak Dikenal')	;
				}else{
					foreach($KODE_RAK as $a => $b){
						$KODE_RAK_FIRST = $a;
						break;
					}
				}
				
				#CEK SUBRAK
				$SQSR = "SELECT KODE_SUB_RAK FROM M_TRADER_BARANG_GUDANG
						WHERE KODE_TRADER='".$kode_trader."'
						AND KODE_BARANG='".$row["KODE_BARANG"]."' AND JNS_BARANG='".$row["JNS_BARANG"]."'";
				$KODE_SUB_RAK = $func->main->get_combobox($SQSR,"KODE_SUB_RAK", "KODE_SUB_RAK", FALSE);	
				if(count($KODE_SUB_RAK)==0){
					$KODE_SUB_RAK = array(''=>'Tidak Dikenal')	;
				}else{
					foreach($KODE_SUB_RAK as $a => $b){
						$KODE_SUBRAK_FIRST = $a;
						break;
					}
				}
				
				#CEK SATUAN
				$SQB = "SELECT KODE_SATUAN, KODE_SATUAN_TERKECIL FROM M_TRADER_BARANG
						WHERE KODE_TRADER='".$kode_trader."'
						AND KODE_BARANG='".$row["KODE_BARANG"]."' AND JNS_BARANG='".$row["JNS_BARANG"]."'";
				$SQB = $this->db->query($SQB);	
				$SATUAN_ARRAY = array();
				if($SQB->num_rows()>0){	
					$SAT = $SQB->row();
					$SATUAN_ARRAY = array($SAT->KODE_SATUAN,$SAT->KODE_SATUAN_TERKECIL);					
				}
				$html .= '<tr id="tr_'.$i.'" '.$class.'>';
				$html .= '<td>'.$i.'</td>';
				$html .= '<td>'.$row['KODE_BARANG'].'<input type="hidden" name="BARANG['.$i.'][KODE_BARANG]" value="'.$row['KODE_BARANG'].'" /></td>';
				$html .= '<td>'.$row['URAIAN'].'<input type="hidden" name="BARANG['.$i.'][JNS_BARANG]" value="'.$row['JNS_BARANG'].'" /></td>';
				$html .= '<td>'.$row['KODE_SATUAN'].'<input type="hidden" name="BARANG['.$i.'][KODE_SATUAN]" value="'.$row['KODE_SATUAN'].'" />';
				if(!in_array($row["KODE_SATUAN"],$SATUAN_ARRAY,true)){
					$ERR_SAT = '<table width=100% class=tabelPopUp>';
					$ERR_SAT.= '<tr><th>Satuan Terbesar</th><th>Satuan Terkecil</th></tr>';
					$ERR_SAT.= '<tr><td>'.$SATUAN_ARRAY[0].'</td><td>'.$SATUAN_ARRAY[1].'</td></tr>';
					$ERR_SAT.= '</tr></table>';	
					$html .= '&nbsp;<a href="javascript:;" onclick="Dialog_view(\''.$ERR_SAT.'\',\'dialog-err\',\'Kode Satuan terdaftar \',250,100)"><span class="label label-important arrowed">tidak dikenal</span></a>';	
					$VALID_SATUAN = FALSE;
				}
				$html .= '</td>';
				$html .= '<td>'.$row['JUMLAH_SATUAN'].'<input type="hidden" id="JUMLAH_B'.$i.'" name="BARANG['.$i.'][JUMLAH_SATUAN]" value="'.$row['JUMLAH_SATUAN'].'" /></td>';
				$html .= '<td id="tdtujuan_'.$i.'">';
				$html .= '<combo>'.form_dropdown('gudang['.$i.'][]',$KODE_GUDANG, '', $wajib . ' id="gudang_'.$i.'"onChange="getKondisi(this.value,'.$i.','.$i.')" class="text" '.$disabled.' ')."</combo>&nbsp;";
				if((count($KODE_GUDANG)>1 || count($KODE_KODISI)>1) && ($row["BREAKDOWN_FLAG"]!="Y" && $row["PARSIAL_FLAG"]!="Y")){
					$html .= "<a id='btnAdd_".$i."' onclick='addGudang(".$i.");' href='javascript:void(0);' title=\"Tambah Gudang\">";
					$html .= "<i class=\"fa fa-plus-circle\"></i></a>";
				}
				$html .= "</td>";
				$html .= "<td id='tdkondisi_".$i."'><combo>".form_dropdown('kondisi['.$i.'][]', $KODE_KODISI, '', $wajib . ' id="kondisi_'.$i.'" class="stext" '.$disabled.'')."</combo></td>";
				$html .= '<td id="tdrak_'.$i.'"><combo>'.form_dropdown('rak['.$i.'][]', array_merge(array(""=>"--Pilih--"),$KODE_RAK), '', 'id="rak_'.$i.'" class="stext" '.$disabled.'').'</combo></td>';
				$html .= '<td id="tdsubrak_'.$i.'"><combo>'.form_dropdown('subrak['.$i.'][]', array_merge(array(""=>"--Pilih--"),$KODE_SUB_RAK), '', 'id="subrak_'.$i.'" class="stext" '.$disabled.'').'</combo></td>';
				if($break || $parsial){
					$html .= '<td id="action_'.$i.'"><center><input type="checkbox" no="'.$i.'" name="chkbreak['.$i.']" id="breakchk'.$i.'" onClick="showbuttonbreak('.$i.')" value="'.$dok.'|'.$aju.'|'.$row["SERI"].'|'.$row["KODE_BARANG"].'|'.$row["JNS_BARANG"].'" '.$checked.' />&nbsp;<input type="button" name="breaktbl'.$i.'" id="breaktbl'.$i.'" no="'.$i.'" class="btn btn-primary btn-sm"  value="..." '.$style.' '.$onclick.'></center></td>';
				}
				$html .= "</tr>";
				if($KODE_GUDANG_FIRST==''&&$KODE_KODISI_FIRST==''&&$KODE_RAK_FIRST==''&&$KODE_SUBRAK_FIRST==''){
					$VALID = FALSE;
				}
				$i++;
			}
			#jika tidak break maka hapus breakdown
			if(!$break){
				$this->db->where(array("KODE_TRADER"=>$kode_trader,"NOMOR_AJU"=>$aju));
				$this->db->delete("t_breakdown_pemasukan");
				$this->db->where(array("KODE_TRADER"=>$kode_trader,"NOMOR_AJU"=>$aju));
				$this->db->update("t_".$dok."_hdr",array("BREAKDOWN_FLAG"=>"N"));
			}
			if(!$parsial){
				$this->db->query("DELETE FROM t_temp_realisasi_parsial_gudang WHERE HDR_REFF IN(SELECT REALISASIID FROM t_temp_realisasi_parsial_hdr WHERE KODE_TRADER = '".$kode_trader."')");
				$this->db->query("DELETE FROM t_temp_realisasi_parsial_dtl WHERE HDR_REFF IN(SELECT REALISASIID FROM t_temp_realisasi_parsial_hdr WHERE KODE_TRADER = '".$kode_trader."')");
				$this->db->query("DELETE FROM t_temp_realisasi_parsial_hdr WHERE KODE_TRADER = '".$kode_trader."'");
			}
		}else{
			$html .= '<tr class="parent">';
			$html .= '<td colspan="7">Data tidak ditemukan.</td>';
			$html .= '</tr>';
		}
		if($VALID&&$VALID_SATUAN){
			return "OK#".$html;
		}else{
			return "ERR#".$html;
		}
	}
	
	function getKondisi(){
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_barang = $this->input->post("kode_barang");
		$jns_barang = $this->input->post("jns_barang");
		$kode_gudang = $this->input->post("kode_gudang");
		$id = $this->input->post("id");
		$no = $this->input->post("no");
		$tipe = $this->input->post("tipe");
		$SQL = "SELECT KONDISI_BARANG FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER='".$kode_trader."'
				AND KODE_BARANG='".$kode_barang."' AND JNS_BARANG='".$jns_barang."' AND KODE_GUDANG = '".$kode_gudang."'";
		$KODE_GUDANG = $func->main->get_combobox($SQL,"KONDISI_BARANG", "KONDISI_BARANG", FALSE);
		if(count($KODE_GUDANG)==0){
			$KODE_KODISI = array(''=>'TIdak Ada Kondisi Gudang');
		}else{
			$KODE_KODISI = $KODE_GUDANG;
		}
		if($no!=""){
			if($no=="parsial"){
				#JIKA PARSIAL
				if($tipe=="out"){
					return "<combo>".form_dropdown('DATAPARSIAL[KONDISI_BARANG][]', array_merge(array(""=>"-- Pilih --"),$KODE_KODISI), '', 'wajib="yes" id="kondisi-parsial-'.$id.'" class="stext" onChange="getRakParsial(\''.$kode_gudang.'\',this.value,'.$id.')"')."</combo>";
				}else{
					return "<combo>".form_dropdown('KONDISI[1][]', array_merge(array(""=>"-- Pilih --"),$KODE_KODISI), '', 'wajib="yes" id="kondisi-parsial-'.$id.'" class="stext" onChange="getRakParsial(\''.$kode_gudang.'\',this.value,'.$id.')"')."</combo>";
				}
			}else{
				#JIKA REALISASI BIASA
				return "<combo>".form_dropdown('kondisi['.$id.'][]', array_merge(array(""=>"-- Pilih --"),$KODE_KODISI), '', 'wajib="yes" id="kondisi_'.$no.'" class="stext" onChange="getRak(\''.$kode_gudang.'\',this.value,'.$id.','.$no.')"')."</combo>";
			}
		}else{
			#JIKA REALISASI BREAK
			return "<combo>".form_dropdown('DATABREAK[KONDISI_BARANG][]', array_merge(array(""=>"-- Pilih --"),$KODE_KODISI), '', 'wajib="yes" id="kondisi-break-'.$id.'" class="stext" onChange="getRakBreak(\''.$kode_gudang.'\',this.value,'.$id.')"')."</combo>";
		}
	}
	
	function getRak(){
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_barang = $this->input->post("kode_barang");
		$jns_barang = $this->input->post("jns_barang");
		$kode_gudang = $this->input->post("kode_gudang");
		$kondisi = $this->input->post('kondisi');
		$id = $this->input->post("id");
		$no = $this->input->post("no");
		$tipe = $this->input->post("tipe");
		$SQL = "SELECT KODE_RAK FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER='".$kode_trader."'
				AND KODE_BARANG='".$kode_barang."' AND JNS_BARANG='".$jns_barang."' AND KODE_GUDANG = '".$kode_gudang."' 
				AND KONDISI_BARANG = '".$kondisi."'";
		$RAK = $func->main->get_combobox($SQL,"KODE_RAK", "KODE_RAK", FALSE);
		if(count($RAK)==0){
			$RAK = array(''=>'TIdak Ada Kondisi Gudang');
		}else{
			$RAK = $RAK;
		}
		if($no){
			if($no=="parsial"){
				$val = $func->main->get_uraian($SQL,"KODE_RAK");
				if($val=="") $RAK = array();
				if(count($RAK)>0) $wajib = 'wajib="yes"';
				else $wajib = 'wajib="no"';
				#JIKA PARSIAL
				if($tipe=="out"){
					return "<combo>".form_dropdown('DATAPARSIAL[KODE_RAK][]', array_merge(array(""=>"-- Pilih --"),$RAK), '', $wajib.' id="rak-parsial-'.$no.'" class="stext" onChange="getSubRakParsial(\''.$kode_gudang.'\',\''.$kondisi.'\',this.value,'.$id.')"')."</combo>";
				}else{
					return "<combo>".form_dropdown('RAK[1][]', array_merge(array(""=>"-- Pilih --"),$RAK), '', $wajib.' id="rak-parsial-'.$no.'" class="stext" onChange="getSubRakParsial(\''.$kode_gudang.'\',\''.$kondisi.'\',this.value,'.$id.')"')."</combo>";
				}
			}else{
				$val = $func->main->get_uraian($SQL,"KODE_RAK");
				if($val=="") $RAK = array();
				#JIKA BIASA
				if($val!="") $wajib = 'wajib="yes"';
				else $wajib = 'wajib="no"';
				return "<combo>".form_dropdown('rak['.$id.'][]', array_merge(array(""=>"-- Pilih --"),$RAK), '', $wajib.' id="rak_'.$no.'" class="stext" onChange="getSubRak(\''.$kode_gudang.'\',\''.$kondisi.'\',this.value,'.$id.','.$no.')"')."</combo>";
			}
		}else{
			$val = $func->main->get_uraian($SQL,"KODE_RAK");
			if($val=="") $RAK = array();
			#JIKA BIASA
			if($val!="") $wajib = 'wajib="yes"';
			else $wajib = 'wajib="no"';
			#JIKA BREAKDOWN
			return "<combo>".form_dropdown('DATABREAK[KODE_RAK][]', array_merge(array(""=>"-- Pilih --"),$RAK), '', $wajib.' id="rak-break-'.$no.'" class="stext" onChange="getSubRakBreak(\''.$kode_gudang.'\',\''.$kondisi.'\',this.value,'.$id.')"')."</combo>";
		}
	}
	
	function getSubRak(){
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_barang = $this->input->post("kode_barang");
		$jns_barang = $this->input->post("jns_barang");
		$kode_gudang = $this->input->post("kode_gudang");
		$kondisi = $this->input->post('kondisi');
		$rak = $this->input->post('rak');
		$id = $this->input->post("id");
		$no = $this->input->post("no");
		$tipe = $this->input->post("tipe");
		$SQL = "SELECT KODE_SUB_RAK FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER='".$kode_trader."'
				AND KODE_BARANG='".$kode_barang."' AND JNS_BARANG='".$jns_barang."' AND KODE_GUDANG = '".$kode_gudang."' 
				AND KONDISI_BARANG = '".$kondisi."' AND KODE_RAK = '".$rak."'";
		$KODE_SUB_RAK = $func->main->get_combobox($SQL,"KODE_SUB_RAK", "KODE_SUB_RAK", FALSE);
		if(count(array_filter($KODE_SUB_RAK))<=0){
			$KODE_SUB_RAK = array(''=>'Tidak Ada Subrak');
			$wajib = '';
		}else{
			$KODE_SUB_RAK = $KODE_SUB_RAK;
			$wajib = 'wajib="yes" ';
		}
		if($no){
			if($no=="parsial"){
				#JIKA REALISASI PARSIAL
				if($tipe=="out"){
					return "<combo>".form_dropdown('DATAPARSIAL[KODE_SUB_RAK][]', array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), '', $wajib.' id="subrak-parsial-'.$id.'" class="stext"')."</combo>";
				}else{
					return "<combo>".form_dropdown('SUBRAK[1][]', array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), '', $wajib.' id="subrak-parsial-'.$id.'" class="stext"')."</combo>";
				}
			}else{
				#JIKA REALISASI BIASA
				return "<combo>".form_dropdown('subrak['.$id.'][]', array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), '', $wajib.' id="subrak_'.$no.'" class="stext"')."</combo>";
			}
		}else{
			#JIKA REALISASI BREAKDOWN
			return "<combo>".form_dropdown('DATABREAK[KODE_SUB_RAK][]', array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), '', $wajib.' id="subrak-break-'.$id.'" class="stext"')."</combo>";
		}
	}
	
	function cekaddrealisasi($dok, $kdbarang, $jnsbarang, $kdbarangpartner = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
        $SQL = " SELECT KODE_BARANG FROM M_TRADER_BARANG 
				WHERE KODE_BARANG='" . $kdbarang . "' AND JNS_BARANG='" . $jnsbarang . "' 
				AND KODE_TRADER='" . $kode_trader . "'";
        $hasil = $func->main->get_result($SQL);
        if ($hasil)
            return 'true';
        else
            return 'false';
    }
	
	function getGudang(){
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_barang = $this->input->post("kode_barang");
		$jns_barang = $this->input->post("jns_barang");
		$html = "";
		#GET GUDANG
		$SQL = "SELECT A.KODE_GUDANG, CONCAT(A.KODE_GUDANG,' - ',IFNULL(A.NAMA_GUDANG,'UTAMA')) NAMA_GUDANG 
				FROM M_TRADER_GUDANG A, M_TRADER_BARANG_GUDANG B 
				WHERE B.KODE_TRADER='".$kode_trader."' AND A.KODE_TRADER = B.KODE_TRADER AND A.KODE_GUDANG = B.KODE_GUDANG
				AND B.KODE_BARANG='".$kode_barang."' AND B.JNS_BARANG='".$jns_barang."'
				ORDER BY A.KODE_GUDANG";
		$KODE_GUDANG = $func->main->get_combobox($SQL,"KODE_GUDANG", "NAMA_GUDANG", TRUE);
		
		#GET KONDISI, RAK DAN SUBRAK
		$SQK = "SELECT KONDISI_BARANG, KODE_RAK, KODE_SUB_RAK FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER='".$kode_trader."'
				AND KODE_BARANG='".$kode_barang."' AND JNS_BARANG='".$jns_barang."'";
		$KODE_KODISI = $func->main->get_combobox($SQK,"KONDISI_BARANG", "KONDISI_BARANG", TRUE);
		$RAK = $func->main->get_combobox($SQK,"KODE_RAK", "KODE_RAK", TRUE);
		$SUBRAK = $func->main->get_combobox($SQK,"KODE_SUB_RAK", "KODE_SUB_RAK", TRUE);
		
		
		if(count($KODE_GUDANG)>1) $TBLTAMBAH = "<a href=\"javascript:void(0)\" onclick=\"addgudang_break('".count($KODE_GUDANG)."')\" title=\"Tambah Gudang\" class=\"btn btn-primary btn-sm\" id=\"button-add-1\">&nbsp;<i class='icon-plus'></i></a>";
		
		$html .= '<tr id="tr-break-1" class="parent">';
		$html .= '<td id="td-jumlah-break-1"><input type="text" name="DATABREAK[JUMLAH][]" id="JUMLAH-1" class="stext date" style="text-align:right; height:27px;" wajib="yes" onKeyPress="return intInput(event, /[.0-9]/)"  /></td>';
		$html .= '<td id="td-gudang-break-1"><combo>'.form_dropdown('DATABREAK[KODE_GUDANG][]', $KODE_GUDANG, '', 'class="text select" id="gudang-break-1" wajib="yes" style="margin-right:0px" onChange="getKondisiBreak(this.value,1)"').'</combo></td>';
		$html .= '<td id="td-kondisi-break-1"><combo>'.form_dropdown('DATABREAK[KONDISI_BARANG][]', $KODE_KODISI, '', 'class="stext select" id="kondisi-break-1" wajib="yes" style="margin-right:0px" onChange="getRakBreak(1)"').'</combo></td>';
		$html .= '<td id="td-rak-break-1"><combo>'.form_dropdown('DATABREAK[KODE_RAK][]', $RAK, '', 'class="stext select" id="rak-break-1" wajib="yes" style="margin-right:0px" onChange="getSubBreak(1)"').'</combo></td>';
		$html .= '<td id="td-subrak-break-1"><combo>'.form_dropdown('DATABREAK[KODE_SUB_RAK][]', $SUBRAK, '', 'class="stext select" id="subrak-break-1" wajib="yes" style="margin-right:0px"').'</combo></td>';
		$html .= '<td id="td-button-break-1" align="center">'.$TBLTAMBAH.'</td>';
		$html .= '</tr>';
		return $html;
	}
	
	function set_breakdown($act = "", $jumawal = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
		$kode_trader = $this->newsession->userdata("KODE_TRADER");
		$err = false;
        if ($act == "save" || $act == "update") {
            $JMLHEAD = $this->input->post("JMLHEAD");
            $DOKUMEN = $this->input->post("DOKUMEN");
            foreach ($this->input->post('DATA') as $a => $b) {
                $DATA[$a] = $b;
				$DATA["KODE_TRADER"] = $kode_trader;
            }
            if ($act == "save") {
				$SQL = "SELECT KODE_BARANG FROM t_breakdown_pemasukan 
						WHERE NOMOR_AJU='" . $DATA["NOMOR_AJU"] . "' AND SERI='" . $DATA["SERI"] . "' 
						AND KODE_BARANG='" . $DATA["KODE_BARANG"] . "' AND JNS_BARANG='" . $DATA["JNS_BARANG"] . "' 
						AND KODE_TRADER = '".$kode_trader."'";
				$data = $this->db->query($SQL);
				if ($data->num_rows() > 0) {
					echo "MSG#ERR#Proses Gagal, Barang yang anda masukan sudah ada !";
				} else {
					$arrdetil = $this->input->post('DATABREAK');
					$arrkeys = array_keys($arrdetil);
					$countdtl = count($arrdetil[$arrkeys[0]]);
					for($i=0;$i<$countdtl;$i++){
						for($j=0;$j<count($arrkeys);$j++){
							$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
						}
						$QUERY = "SELECT B.KODE_BARANG FROM M_TRADER_BARANG_GUDANG B LEFT JOIN 
								  M_TRADER_BARANG A ON A.KODE_TRADER = B.KODE_TRADER AND A.KODE_BARANG = B.KODE_BARANG
								  AND A.JNS_BARANG = B.JNS_BARANG WHERE A.KODE_TRADER = '".$kode_trader."' 
								  AND A.KODE_BARANG = '".$DATA["KODE_BARANG"]."' AND A.JNS_BARANG = '".$DATA["JNS_BARANG"]."' 
								  AND B.KODE_GUDANG = '".$DATADTL["KODE_GUDANG"]."' AND B.KONDISI_BARANG = '".$DATADTL["KONDISI_BARANG"]."' 
								  AND KODE_RAK = '".$DATADTL["KODE_RAK"]."' AND KODE_SUB_RAK = '".$DATADTL["KODE_SUB_RAK"]."'";#echo $QUERY;die();
						$rs = $this->db->query($QUERY);
						if($rs->num_rows() == 0){
							$err = true;
							$msg = "MSG#ERR#Kode Gudang, Kondisi Barang, Kode Rak dan Kode Subrak tidak dikenali, yaitu ".$DATADTL["KODE_GUDANG"].", ".$DATADTL["KONDISI_BARANG"].", ".$DATADTL["KODE_RAK"].", ".$DATADTL["KODE_SUB_RAK"];
						}
					}
					if($err){
						echo $msg;die();
					}else{
						$insert = $this->db->insert('t_breakdown_pemasukan', $DATA);
						$ID = $this->db->insert_id();
						if ($insert) {
							for($i=0;$i<$countdtl;$i++){
								for($j=0;$j<count($arrkeys);$j++){
									$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
								}
								$JML = $JML+$DATADTL["JUMLAH"];
								$DATABREAK["KODE_TRADER"] = $kode_trader;
								$DATABREAK["HDRID"] = $ID;
								$DATABREAK["NOMOR_AJU"] = $DATA["NOMOR_AJU"];
								$DATABREAK["KODE_BARANG"] = $DATA["KODE_BARANG"];
								$DATABREAK["JNS_BARANG"] = $DATA["JNS_BARANG"];
								$DATABREAK["KODE_GUDANG"] = $DATADTL["KODE_GUDANG"];
								$DATABREAK["KONDISI_BARANG"] = $DATADTL["KONDISI_BARANG"];
								$DATABREAK["KODE_RAK"] = $DATADTL["KODE_RAK"];
								$DATABREAK["KODE_SUB_RAK"] = $DATADTL["KODE_SUB_RAK"];
								$DATABREAK["JUMLAH"] = $DATADTL["JUMLAH"];
								$DATABREAK["SERI"] = $DATA["SERI"];
								$this->db->insert('T_BREAKDOWN_GUDANG', $DATABREAK);
							}
							$this->db->where(array( "NOMOR_AJU"=>$DATA["NOMOR_AJU"],"SERI"=>$DATA["SERI"],
													"KODE_BARANG"=>$DATA["KODE_BARANG"],"JNS_BARANG"=>$DATA["JNS_BARANG"],
													"KODE_TRADER"=>$kode_trader));
							$this->db->update('t_breakdown_pemasukan', array("JUMLAH"=>$JML));
							
							$this->db->where(array('NOMOR_AJU' => $DATA["NOMOR_AJU"], 'SERI' => $DATA["SERI"], "KODE_TRADER"=>$kode_trader));
							$this->db->update('t_' . $DOKUMEN . '_dtl', array("BREAKDOWN_FLAG" => "Y"));
							$this->db->where(array('NOMOR_AJU' => $DATA["NOMOR_AJU"], "KODE_TRADER"=>$kode_trader));
							$this->db->update('t_' . $DOKUMEN . '_hdr', array("BREAKDOWN_FLAG" => "Y"));
	
							$func->main->activity_log('ADD BREAKDOWN DETIL DOKUMEN ' . strtoupper($DOKUMEN), 'CAR=' . $DATA["NOMOR_AJU"] . ',SERI=' . $DATA["SERI"]);
							echo "MSG#OK#Simpan Data Berhasil#" . site_url() . "/realisasi/show_detilbarang/" . $DATA["NOMOR_AJU"] . "/" . $DATA["SERI"] . "/" . $JMLHEAD . "/" . $DOKUMEN;
						} else {
							echo "MSG#ERR#Simpan data Gagal";
						}
					}
				}
            } else {
                $KODE_BARANG = $this->input->post("KDBARANG_EDIT");
                $JNS_BARANG = $this->input->post("JNSBARANG_EDIT");
                $this->db->where(array("NOMOR_AJU" => $DATA["NOMOR_AJU"], "SERI" => $DATA["SERI"],"KODE_BARANG" => $KODE_BARANG, "JNS_BARANG" => $JNS_BARANG, "KODE_TRADER"=>$kode_trader));
                $exec = $this->db->update('t_breakdown_pemasukan', array("JUMLAH" => $DATA["JUMLAH"]));
                if ($exec) {
                    $func->main->activity_log('EDIT BREAKDOWN DETIL DOKUMEN ' . strtoupper($DOKUMEN), 'CAR=' . $DATA["NOMOR_AJU"] . ',SERI=' . $DATA["SERI"]);
                    echo "MSG#OK#Update Data Berhasil#" . site_url() . "/realisasi_in/show_detilbarang/" . $DATA["NOMOR_AJU"] . "/" . $DATA["SERI"] . "/" . $JMLHEAD . "/" . $DOKUMEN;
                } else {
                    echo "MSG#ERR#Update data Gagal";
                }
            }
        } else if ($act == "delete") {
            $func = get_instance();
            $func->load->model("main");
            foreach ($this->input->post('tb_chkfbreakdownbrg') as $chkitem) {
                $arrchk = explode("|", $chkitem);
                $KODE_BARANG = $arrchk[0];
                $JNS_BARANG = $arrchk[1];
                $NOMOR_AJU = $arrchk[2];
                $SERI = $arrchk[3];
                $DOKUMEN = $arrchk[4];
                $this->db->where(array("NOMOR_AJU" => $NOMOR_AJU, "SERI" => $SERI, "KODE_BARANG" => $KODE_BARANG, "JNS_BARANG" => $JNS_BARANG,"KODE_TRADER"=>$kode_trader));
                $this->db->delete('t_breakdown_pemasukan');
                $this->db->where(array("NOMOR_AJU" => $NOMOR_AJU, "SERI" => $SERI, "KODE_BARANG" => $KODE_BARANG, "JNS_BARANG" => $JNS_BARANG,"KODE_TRADER"=>$kode_trader));
                $exec = $this->db->delete('t_breakdown_gudang');
            }
            $JML = (float) $func->main->get_uraian("SELECT IFNULL(SUM(JUMLAH),0) SUMJUMLAH FROM t_breakdown_pemasukan
									        WHERE NOMOR_AJU='" . $NOMOR_AJU . "' AND SERI='" . $SERI . "' AND KODE_TRADER = '".$kode_trader."'
									        GROUP BY NOMOR_AJU, SERI", "SUMJUMLAH");
            if ($exec) {
                if ($JML == 0) {
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'SERI' => $SERI, "KODE_TRADER"=>$kode_trader));
                    $this->db->update('t_' . $DOKUMEN . '_dtl', array("BREAKDOWN_FLAG" => ""));
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU,"KODE_TRADER"=>$kode_trader));
                    $this->db->update('t_' . $DOKUMEN . '_hdr', array("BREAKDOWN_FLAG" => "N"));
                    $JML = $jumawal;
                }
                $func->main->activity_log('DELETE BREAKDOWN DETIL DOKUMEN ' . strtoupper($DOKUMEN), 'CAR=' . $NOMOR_AJU . ',SERI=' . $SERI);
                echo "MSG#OK#Hapus Data Berhasil#" . site_url() . "/realisasi/show_detilbarang/" . $NOMOR_AJU . "/" . $SERI . "/" . $JML . "/" . $DOKUMEN . "/DEL";
            } else {
                echo "MSG#ERR#Hapus data Gagal";
            }
        }
    }
	
	function breakdown_proses_detil($KEY=""){
		$func = get_instance();
		$func->load->model("main");	
		$this->load->library('newtable');
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$arr = explode("|",$KEY);
		$KODE_BARANG = str_replace("^","/",str_replace("~"," ",$arr[0]));
		$JNS_BARANG = $arr[1];
		$SQL = "SELECT A.KODE_GUDANG AS 'KODE GUDANG', A.KONDISI_BARANG AS 'KONDISI BARANG', A.KODE_RAK 'KODE RAK', 
				A.KODE_SUB_RAK AS 'KODE SUB RAK', A.JUMLAH
				FROM t_breakdown_gudang A INNER JOIN t_breakdown_pemasukan B ON A.NOMOR_AJU = B.NOMOR_AJU AND A.HDRID = B.HDRID 
				AND A.KODE_TRADER = B.KODE_TRADER AND A.SERI = B.SERI
				WHERE B.KODE_TRADER = '".$KODE_TRADER."' AND B.NOMOR_AJU = '".$arr[2]."'
				AND B.SERI = '".$arr[3]."' AND B.KODE_BARANG = '".$KODE_BARANG."' AND B.JNS_BARANG = '".$JNS_BARANG."'";
									  
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
		$this->newtable->action(site_url()."/realisasi/breakdown_proses_detil_in/".$KEY);	
		$this->newtable->orderby('A.KODE_BARANG');
		$this->newtable->sortby("ASC");
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($ciuri);
		$this->newtable->set_formid("fdtlbarang");
		$this->newtable->set_divid("divdtlbarang");
		$this->newtable->rowcount(10);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(false);
		$this->newtable->clear();
		$this->newtable->header_bg("rgb(98,155,88)");
		$table = $this->newtable->generate($SQL);	
		if($this->input->post("ajax")){
			echo $table;
		}else{
			$data ='<h4 class="header smaller lighter green"><i class="icon-info"></i>&nbsp;Data Gudang</h4>';
			$data.=$table;
			$data.="<br />";
			echo $data;
		}
	}
	
	function parsial() {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$NOMOR_AJU = $this->input->post("NOMOR_AJU");
		$DOKUMEN = $this->input->post("DOKUMEN");
		$SERI = $this->input->post("SERI");
		foreach($this->input->post("PARSIAL") as $a=>$b){
			$barang[$a] = $b;
		}
		$jumlah_masuk = $this->input->post('jumlah');
		$gudang_tujuan = $this->input->post('GUDANG');
		$kondisi = $this->input->post('KONDISI');
		$rak = $this->input->post('RAK');
		$subrak = $this->input->post('SUBRAK');
		
		$arrdata["KODE_BARANG"] = $barang["KODE_BARANG"];
		$arrdata["JNS_BARANG"] = $barang["JNS_BARANG"];
		$arrdata["JUMLAH_SATUAN"] = $barang["JUMLAH_SATUAN"];
		$arrdata["KODE_SATUAN"] = $barang["KODE_SATUAN"];
		$tempJumlah = 0;
		if(count($jumlah_masuk[1])>1){
			for ($k=0; $k < count($jumlah_masuk[1]) ; $k++) {
				$arrdata['data'][$k]['JUMLAH'] = $jumlah_masuk[1][$k];
				$arrdata['data'][$k]['KODE_GUDANG'] = $gudang_tujuan[1][$k];
				$arrdata['data'][$k]['KONDISI_BARANG'] = $kondisi[1][$k];
				$arrdata['data'][$k]['KODE_RAK'] = $rak[1][$k];
				$arrdata['data'][$k]['KODE_SUB_RAK'] = $subrak[1][$k];
				$tempJumlah = $tempJumlah + $jumlah_masuk[1][$k];
				$sqlValidasi = "SELECT ID FROM m_trader_barang_gudang A INNER JOIN M_TRADER_BARANG B ON A.KODE_TRADER = B.KODE_TRADER 
								AND A.KODE_BARANG = B.KODE_BARANG AND A.JNS_BARANG = B.JNS_BARANG
								WHERE B.KODE_TRADER = '".$KODE_TRADER."'
								AND B.KODE_BARANG = '".$barang['KODE_BARANG']."' 
								AND B.JNS_BARANG = '".$barang['JNS_BARANG']."'
								AND A.KODE_GUDANG = '".$gudang_tujuan[1][$k]."'
								AND A.KONDISI_BARANG = '".$kondisi[1][$k]."'
								AND A.KODE_RAK = '".$rak[1][$k]."'
								AND A.KODE_SUB_RAK = '".$subrak[1][$k]."'"; 
				$doValidasi = $this->db->query($sqlValidasi);
				if ($doValidasi->num_rows() < 1) {
					$err = true;
					$msg = "MSG#ERR#Data tidak ditemukan yaitu : Kode Barang ".$barang['KODE_BARANG'].", Kode Gudang : ".$gudang_tujuan[1][$k].", Kondisi Barang : ".$kondisi[1][$k].", Kode Rak : ".$rak[1][$k].", Kode Sub Rak : ".$subrak[1][$k]." #edit#";
				}
			}
			if ($tempJumlah > $barang['JUMLAH_SATUAN']) {
				$err = true;
				$msg = "MSG#ERR#Total jumlah melebihi jumlah satuan pada Kode Barang : ".$barang['KODE_BARANG']."#edit#";
			}
		}else{
			$arrdata['JUMLAH'] = $barang["JUMLAH"];
			$arrdata['KODE_GUDANG'] = $gudang_tujuan[1][0];
			$arrdata['KONDISI_BARANG'] = $kondisi[1][0];
			$arrdata['KODE_RAK'] = $rak[1][0];
			$arrdata['KODE_SUB_RAK'] = $subrak[1][0];
			$sqlValidasi = "SELECT A.ID FROM m_trader_barang_gudang A INNER JOIN m_trader_barang B ON A.KODE_TRADER = B.KODE_TRADER
							AND A.KODE_BARANG = B.KODE_BARANG AND A.JNS_BARANG = B.JNS_BARANG
							WHERE B.KODE_TRADER = '".$KODE_TRADER."'
							AND B.KODE_BARANG = '".$barang['KODE_BARANG']."' 
							AND B.JNS_BARANG = '".$barang['JNS_BARANG']."'
							AND A.KODE_GUDANG = '".$gudang_tujuan[1][0]."'
							AND A.KONDISI_BARANG = '".$kondisi[1][0]."' 
							AND A.KODE_RAK = '".$rak[1][0]."' 
							AND A.KODE_SUB_RAK = '".$subrak[1][0]."'";
			$doValidasi = $this->db->query($sqlValidasi);
			if ($doValidasi->num_rows() < 1) {
				$err = true;
				$msg = "MSG#ERR#Data tidak ditemukan yaitu : Kode Barang ".$barang['KODE_BARANG'].", Kode Gudang : ".$gudang_tujuan[1][0].", Kondisi Barang : ".$kondisi[1][0]." #edit#";
			}
			if ($tempJumlah > $barang['JUMLAH_SATUAN']) {
				$err = true;
				$msg = "MSG#ERR#Total jumlah melebihi jumlah satuan pada Kode Barang : ".$barang['KODE_BARANG']."#edit#";
			}
		}
		
		if($err){
			echo $msg;die();
		}else{
			$SQL = "SELECT REALISASIID FROM t_temp_realisasi_parsial_hdr WHERE NOMOR_AJU='" . $NOMOR_AJU . "' 
					AND KODE_TRADER='" . $KODE_TRADER . "' AND NO_DOK_INTERNAL IS NULL";
            $rs = $this->db->query($SQL);
			if ($rs->num_rows() > 0) {
				$data = $rs->row();
                $RELID = $data->REALISASIID;
				
                /*$this->db->where(array('HDR_REFF' => $RELID));
                $this->db->delete('t_temp_realisasi_parsial_dtl');
                $this->db->where(array('HDR_REFF' => $RELID));
                $this->db->delete('t_temp_realisasi_parsial_gudang');*/
				
				#insert ke t_temp_realisasi_parsial_dtl
				$BARANG["HDR_REFF"] = $RELID;
				$BARANG["KODE_BARANG"] = $barang["KODE_BARANG"];
				$BARANG["JNS_BARANG"] = $barang["JNS_BARANG"];
				$BARANG["JUMLAH"] = $barang["JUMLAH"];
				$BARANG["SATUAN"] = $barang["KODE_SATUAN"];
				$BARANG["SERI"] = $SERI;
				$BARANG["NILAI_BARANG"] = $barang["NILAI_BARANG"];
				$exec = $this->db->insert('t_temp_realisasi_parsial_dtl', $BARANG);
				$ID =  $this->db->insert_id();
				if($exec){
					$GUDANG["REALISASIDTLID"] = $ID;
					$GUDANG["HDR_REFF"] = $RELID;
					$GUDANG["KODE_BARANG"] = $arrdata["KODE_BARANG"];
					$GUDANG["JNS_BARANG"] = $arrdata["JNS_BARANG"];
					$GUDANG["SERI"] = $SERI;
					if($jumlah_masuk){
						for($i=0;$i < count($jumlah_masuk[1]);$i++){
							$GUDANG["JUMLAH"] = $arrdata['data'][$i]["JUMLAH"];
							$GUDANG["KODE_GUDANG"] = $arrdata['data'][$i]["KODE_GUDANG"];
							$GUDANG["KONDISI_BARANG"] = $arrdata['data'][$i]["KONDISI_BARANG"];
							$GUDANG["KODE_RAK"] = $arrdata['data'][$i]["KODE_RAK"];
							$GUDANG["KODE_SUB_RAK"] = $arrdata['data'][$i]["KODE_SUB_RAK"];
							$exec = $this->db->insert('t_temp_realisasi_parsial_gudang', $GUDANG);
						}
					}else{
						$GUDANG["JUMLAH"] = $arrdata["JUMLAH"];
						$GUDANG["KODE_GUDANG"] = $arrdata["KODE_GUDANG"];
						$GUDANG["KONDISI_BARANG"] = $arrdata["KONDISI_BARANG"];
						$GUDANG["KODE_RAK"] = $arrdata["KODE_RAK"];
						$GUDANG["KODE_SUB_RAK"] = $arrdata["KODE_SUB_RAK"];
						$exec = $this->db->insert('t_temp_realisasi_parsial_gudang', $GUDANG);
					}
					$this->db->where(array('KODE_TRADER'=>$KODE_TRADER,'NOMOR_AJU' => $NOMOR_AJU, 'SERI' => $SERI));
                    $exec = $this->db->update('t_' . $DOKUMEN . '_dtl', array("PARSIAL_FLAG" => "Y"));
				}
			}else{
				$RELID = $this->newsession->userdata('USER_ID') . date('ymdHis');
                $HEADER["REALISASIID"] = $RELID;
                $HEADER["KODE_TRADER"] = $KODE_TRADER;
                $HEADER["NOMOR_AJU"] = $NOMOR_AJU;
                $HEADER["JENIS_DOK"] = strtoupper($DOKUMEN);
				$insert = $this->db->insert('t_temp_realisasi_parsial_hdr', $HEADER);
				if ($insert) {
					$BARANG["HDR_REFF"] = $HEADER["REALISASIID"];
					$BARANG["KODE_BARANG"] = $barang["KODE_BARANG"];
					$BARANG["JNS_BARANG"] = $barang["JNS_BARANG"];
					$BARANG["JUMLAH"] = $barang["JUMLAH"];
					$BARANG["SATUAN"] = $barang["KODE_SATUAN"];
					$BARANG["SERI"] = $SERI;
					$BARANG["NILAI_BARANG"] = $barang["NILAI_BARANG"];
					$exec = $this->db->insert('t_temp_realisasi_parsial_dtl', $BARANG);
					if($exec){
						unset($arrdata["JUMLAH_SATUAN"]);
						unset($arrdata["KODE_SATUAN"]);
						$GUDANG["REALISASIDTLID"] = $this->db->insert_id();
						$GUDANG["HDR_REFF"] = $HEADER["REALISASIID"];
						$GUDANG["SERI"] = $SERI;
						$GUDANG["KODE_BARANG"] = $arrdata["KODE_BARANG"];
						$GUDANG["JNS_BARANG"] = $arrdata["JNS_BARANG"];
						if($jumlah_masuk){
							for($i=0;$i < count($jumlah_masuk[1]);$i++){
								$GUDANG["JUMLAH"] = $arrdata['data'][$i]["JUMLAH"];
								$GUDANG["KODE_GUDANG"] = $arrdata['data'][$i]["KODE_GUDANG"];
								$GUDANG["KONDISI_BARANG"] = $arrdata['data'][$i]["KONDISI_BARANG"];
								$GUDANG["KODE_RAK"] = $arrdata['data'][$i]["KODE_RAK"];
								$GUDANG["KODE_SUB_RAK"] = $arrdata['data'][$i]["KODE_SUB_RAK"];
								$exec = $this->db->insert('t_temp_realisasi_parsial_gudang', $GUDANG);
							}
						}else{
							$GUDANG["JUMLAH"] = $arrdata["JUMLAH"];
							$GUDANG["KODE_GUDANG"] = $arrdata["KODE_GUDANG"];
							$GUDANG["KONDISI_BARANG"] = $arrdata["KONDISI_BARANG"];
							$GUDANG["KODE_RAK"] = $arrdata["KODE_RAK"];
							$GUDANG["KODE_SUB_RAK"] = $arrdata["KODE_SUB_RAK"];
							$exec = $this->db->insert('t_temp_realisasi_parsial_gudang', $GUDANG);
						}
					}
				}
				if ($exec) {
					$this->db->where(array('KODE_TRADER'=>$KODE_TRADER,'NOMOR_AJU' => $NOMOR_AJU, 'SERI' => $SERI));
					$exec = $this->db->update('t_' . $DOKUMEN . '_dtl', array("PARSIAL_FLAG" => "Y"));
					$this->db->where(array('KODE_TRADER'=>$KODE_TRADER,'NOMOR_AJU' => $NOMOR_AJU));
					$exec = $this->db->update('t_' . $DOKUMEN . '_hdr', array("PARSIAL_FLAG" => "Y"));
				}
			}
		}
		if ($exec) {
            echo "MSG#OK#Proses Data Berhasil";
        } else {
            echo "MSG#ERR#Proses Data gagal";
        }
    }
}
?>