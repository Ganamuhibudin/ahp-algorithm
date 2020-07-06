<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Realisasiout_act extends CI_Model 
{
    function out($dokumen = "", $aju = ""){
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_role = $this->newsession->userdata('KODE_ROLE');
        $jenis = "out";
		$prosesnya = "";
        $title = "Daftar Realisasi Pengeluaran";
        if (!in_array($kode_role,array("5","3"))){
			$FIELD = ",DATE_FORMAT(TANGGAL_REALISASI, '%d %M %Y %H:%m:%s') AS 'TANGGAL REALISASI/GATE'";
		}else{
			$FIELD = ",DATE_FORMAT(TANGGAL_REALISASI, '%d %M %Y %H:%m:%s') AS 'TANGGAL REALISASI/GATE'
						, f_trader(KODE_TRADER) 'NAMA ANGGOTA' ";
		}
        $WHERE = " WHERE STATUS = '19' AND TANGGAL_REALISASI<>'NULL' AND KODE_TRADER='".$kode_trader."'";
        if (!in_array($kode_role,array("5","3"))){
            $prosesnya = array( 'Tambah' => array('GETREALISASI', site_url() . "/realisasi/out/save", '0', 'icon-plus'),
                				'Ubah' => array('EDITJS', site_url() . "/realisasi/out/update", '1', 'icon-pencil'));
        }

        foreach ($this->input->post('CARI') as $a => $b){
            $CARI[$a] = $b;
        }
		
        if ($CARI["NOMOR_DOK_INTERNAL"] != ""){
            $WHERE .= " AND NOMOR_DOK_INTERNAL LIKE '%" . $CARI["NOMOR_DOK_INTERNAL"] . "%'";
        }
		
        if ($CARI["NOMOR_PENDAFTARAN"] != ""){
            $WHERE .= " AND NOMOR_PENDAFTARAN LIKE '%" . $CARI["NOMOR_PENDAFTARAN"] . "%'";
        }
		
        if ($CARI["PEMASOK"] != "") {
            if ($dokumen == "bc28"){
                $WHERE .= " AND NAMA_PENERIMA LIKE '%" . $CARI["PEMASOK"] . "%'";
            }elseif ($dokumen == "bc27"){
                $WHERE .= " AND NAMA_TRADER_TUJUAN LIKE '%" . $CARI["PEMASOK"] . "%'";
            }elseif ($dokumen == "bc30"){
                $WHERE .= " AND NAMA_PEMBELI LIKE '%" . $CARI["PEMASOK"] . "%'";
            }elseif($dokumen == "bc41"){
				 $WHERE .= " AND NAMA_PENERIMA LIKE '%" . $CARI["PEMASOK"] . "%'";
			}elseif($dokumen == "ppb"){
				 $WHERE .= " AND NAMA_TRADER LIKE '%" . $CARI["PEMASOK"] . "%'";
			}
        }
		
        if ($CARI["TANGGAL_DOK_INTERNAL1"] != "" && $CARI["TANGGAL_DOK_INTERNAL2"] != ""){
            $WHERE .= " AND TANGGAL_DOK_INTERNAL BETWEEN '" . $CARI["TANGGAL_DOK_INTERNAL1"] . "' AND '" . $CARI["TANGGAL_DOK_INTERNAL2"] . "'";
        }
        
		if ($CARI["TANGGAL_PENDAFTARAN1"] != "" && $CARI["TANGGAL_PENDAFTARAN2"] != ""){
            $WHERE .= " AND TANGGAL_PENDAFTARAN BETWEEN '" . $CARI["TANGGAL_PENDAFTARAN1"] . "' AND '" . $CARI["TANGGAL_PENDAFTARAN2"] . "'";
        }
        
		if ($CARI["TANGGAL_REALISASI1"] != "" && $CARI["TANGGAL_REALISASI2"] != ""){
            $WHERE .= " AND DATE_FORMAT(TANGGAL_REALISASI, '%Y-%m-%d') BETWEEN '" . $CARI["TANGGAL_REALISASI1"] . "' AND '" . $CARI["TANGGAL_REALISASI2"] . "'";
        }

        if ($dokumen == "bc28"){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC28' AS 'DOKUMEN', NAMA_IMPORTIR AS 'PEMBELI/PENERIMA', 
					IFNULL(f_jumbrg_bc28(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC28_HDR";
            $SQL .= $WHERE;
        }elseif ($dokumen == "bc27"){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC27' AS 'DOKUMEN', 
					NAMA_TRADER_TUJUAN AS 'PEMBELI/PENERIMA', IFNULL(f_jumbrg_bc27(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . " , 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC27_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='KELUAR'";
        }elseif ($dokumen == "bc33"){
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC33' AS 'DOKUMEN', NAMA_PEMBELI AS 'PEMBELI/PENERIMA', 
					IFNULL(f_jumbrg_bc33(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC33_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='KELUAR'";
        }elseif($dokumen == "bc41"){
			$SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC41' AS 'DOKUMEN', NAMA_PENERIMA AS 'PEMBELI/PENERIMA', 
					IFNULL(f_jumbrg_bc41(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC41_HDR";
            $SQL .= $WHERE;
		}elseif($dokumen == "ppb"){
			$SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','PPB-PLB' AS 'DOKUMEN', 
					NAMA_TRADER AS 'PEMBELI/PENERIMA', IFNULL(f_jumbrg_ppb(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' , IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_PPB_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='KELUAR'";
		}elseif($dokumen == "p3bet"){
			$SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','P3BET' AS 'DOKUMEN', 
					NAMA_PENERIMA AS 'PEMBELI/PENERIMA', IFNULL(f_jumbrg_p3bet(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' , IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_P3BET_HDR";
            $SQL .= $WHERE;
		}else{
            $POSTURI = $this->input->post("uri");
			
            $SQL = "SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC28' AS 'DOKUMEN', NAMA_IMPORTIR AS 'PEMBELI/PENERIMA', 
					IFNULL(f_jumbrg_bc28(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC28_HDR";
            $SQL .= $WHERE;
			if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PENGUSAHA LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
           $SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC27' AS 'DOKUMEN', 
					NAMA_TRADER_TUJUAN AS 'PEMBELI/PENERIMA', IFNULL(f_jumbrg_bc27(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC27_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='KELUAR'";
			if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_TRADER_TUJUAN LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC33' AS 'DOKUMEN', NAMA_PEMBELI AS 'PEMBELI/PENERIMA', 
					IFNULL(f_jumbrg_bc33(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC33_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='KELUAR'";
			if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PEMBELI LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','BC41' AS 'DOKUMEN', NAMA_PENERIMA AS 'PEMBELI/PENERIMA', 
					IFNULL(f_jumbrg_bc41(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_BC41_HDR";
            $SQL .= $WHERE;
			if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PENERIMA LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
			
			$SQL .= " UNION ALL SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','PPB-PLB' AS 'DOKUMEN', 
					NAMA_TRADER AS 'PEMBELI/PENERIMA', IFNULL(f_jumbrg_ppb(NOMOR_AJU,KODE_TRADER),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' , IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_PPB_HDR";
            $SQL .= $WHERE . "AND TIPE_DOK='KELUAR'";
			if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_TRADER LIKE '%" . $CARI["PEMASOK"] . "%'";
            }

            $SQL .= " UNION ALL
					SELECT CREATED_TIME, NOMOR_AJU AS 'NOMOR AJU',NOMOR_DOK_INTERNAL AS 'NO.BUKTI PENGELUARAN',
					DATE_FORMAT(TANGGAL_DOK_INTERNAL, '%d %M %Y') AS 'TGL.BUKTI PENGELUARAN',NOMOR_PENDAFTARAN AS 'NOMOR DAFTAR',
					DATE_FORMAT(TANGGAL_PENDAFTARAN, '%d %M %Y') AS 'TANGGAL DAFTAR','P3BET' AS 'DOKUMEN', NAMA_PENERIMA AS 'PEMBELI/PENERIMA', 
					IFNULL(f_jumbrg_p3bet(NOMOR_AJU),0) AS 'DETIL BARANG' " . $FIELD . ", 
					IF(PARSIAL_FLAG='Y','&radic;','') 'PARSIAL' ,
					IF(BREAKDOWN_FLAG='Y','&radic;','') 'BREAKDOWN' FROM T_P3BET_HDR";
            $SQL .= $WHERE ;
			if ($CARI["PEMASOK"] != "") {
                $SQL .= " AND NAMA_PENERIMA LIKE '%" . $CARI["PEMASOK"] . "%'";
            }
        }
        	#echo $SQL;die();
        $this->newtable->align(array("LEFT", "LEFT", "CENTER", "LEFT", "LEFT", "LEFT", "CENTER", "LEFT", "CENTER", "CENTER"));
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        if ($this->newsession->userdata('KODE_ROLE') == '5') $this->newtable->show_chk(FALSE);
        $this->newtable->action(site_url() . "/realisasi/out");
        $this->newtable->detail(site_url() . "/realisasi/detil_out");
        $this->newtable->detail_tipe("detil_priview_bottom");
        $this->newtable->hiddens(array("CREATED_TIME", "NOMOR AJU", "STATUS"));
        $this->newtable->keys(array("DOKUMEN", "NOMOR AJU"));
        $this->newtable->tipe_proses('button');
        $this->newtable->show_search(false);
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby(1, 2);
        $this->newtable->sortby("DESC");
        $this->newtable->set_formid("frealisasiout");
        $this->newtable->set_divid("divrealisasiout");
        $this->newtable->rowcount(20);
        $this->newtable->clear();
        $this->newtable->menu($prosesnya);
		if (in_array($kode_role,array("5","3")))
		{
			$this->newtable->show_chk(false);
		}
        if (!$this->input->post("ajax")) 
		{
            $tabel .= '<form name="tblCari" id="tblCari" class="form-horizontal" method="post" action="realisasi/out" onsubmit="return frm_Cari(\'divrealisasiout\',\'tblCari\')">		
						<input type="hidden" name="PARSIAL" id="PARSIAL">
						<input type="hidden" name="BREAK" id="BREAK">
						<table border="0" cellpadding="1" cellspacing="0" width="100%" style="margin-bottom:10px">';
            $tabel .= '	<tr>
							<td width="12%"><strong>No.Bukti Pengeluaran</strong></td>
							<td width="1%">:</td>
							<td width="1%">' . form_input('CARI[NOMOR_DOK_INTERNAL]', '', 'id="NOMOR_DOK_INTERNAL" class="text" style="width:220px;"') . '</td>
							<td>&nbsp;</td>
							<td width="10%"><strong>Nomor Daftar</strong></td>
							<td width="1%">:</td>
							<td width="1%">' . form_input('CARI[NOMOR_PENDAFTARAN]', '', 'id="NOMOR_PENDAFTARAN" class="text" style="width:220px;"') . '</td>
							<td>&nbsp;</td>
							<td width="10%"><strong>Pembeli/Penerima</strong></td>
							<td width="1%">:</td>
							<td width="1%">' . form_input('CARI[PEMASOK]', '', 'id="PEMASOK" class="text" style="width:220px;"') . '</td>
						</tr>';
            $tabel .= '	<tr>
							<td width="10%"><strong>Tgl.Bukti Pengeluaran</strong></td>
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
			if(in_array($kode_role,array('3','5')))
			{
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
            $tabel .= "     <a href=\"javascript:void(0);\" class=\"btn btn-primary btn-sm\" id=\"ok_\" onclick=\"frm_Cari('divrealisasiout','tblCari')\"><i class=\"icon-search\"></i>&nbsp;Search</a>";
            $tabel .= "		<a href=\"javascript:void(0);\" class=\"btn btn-danger btn-sm\" id=\"ok_\" onclick=\"cancel('tblCari')\"><i class=\"icon-undo\"></i>&nbsp;Clear</a>";
            $tabel .= '		</td>
						</tr>';
            $tabel .= '	 </table>
						</form>';
        }

        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $title,
						 "tabel" => $tabel,
						 "jenis" => $jenis
						 );
        if ($this->input->post("ajax")) return $tabel;
        else return $arrdata;
	}
	
	function get_realisasi(){	
		$func = get_instance();
		$func->load->model("main");;	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$dok = $this->input->post('id1');
		$aju = $this->input->post('id2');
		if($dok=="BC27"){
			$penerima = "A.NAMA_TRADER_TUJUAN";
		}elseif($dok=="BC28"){
			$penerima = "A.NAMA_PENGUSAHA";
		}else{
			$penerima = "A.NAMA_PENERIMA";
		}
		$SQL = "SELECT A.NOMOR_AJU,A.TANGGAL_DOK_INTERNAL,A.NOMOR_DOK_INTERNAL,A.NOMOR_PENDAFTARAN,A.TANGGAL_PENDAFTARAN,
					".$penerima." AS 'PENERIMA',IFNULL(f_jumbrg_".$dok."(A.NOMOR_AJU,A.KODE_TRADER),0) AS 'DETIL_BARANG',
					'".strtoupper($dok)."' AS 'DOKUMEN',
					DATE_FORMAT(A.TANGGAL_REALISASI,'%Y-%m-%d') TANGGAL_REALISASI, DATE_FORMAT(A.TANGGAL_REALISASI,'%H:%i') WAKTU 
				FROM T_".strtoupper($dok)."_HDR A
					WHERE NOMOR_AJU=".$this->db->escape($aju)."  AND KODE_TRADER = ".$this->db->escape($KODE_TRADER)."";
		$hasil = $func->main->get_result($SQL);
		$DATA = array();
		if($hasil){
			foreach($SQL->result_array() as $row){
				$DATA = $row;
			}
		}	
		return $DATA;
	}
	
	function getDokIn($act)
	{
		$func = get_instance();
        $func->load->model("main", "main", true);
		$kode_trader = $this->newsession->userdata("KODE_TRADER");
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			if($act=="save"){
				$arrdetil = $this->input->post('DOKIN');
				$KODE_BARANG = $this->input->post("KODE_BARANG_DOK");
				$JNS_BARANG = $this->input->post("JNS_BARANG_DOK");
				$SERI_BARANG = $this->input->post("SERI_BARANG_DOK");
				$DOKUMEN = $this->input->post("DOKUMEN");
				$AJU = $this->input->post("NOMOR_AJU_DOK");
				$JUMALAH_SATUAN = $this->input->post("JUM_SAT");
				$arrkeys = array_keys($arrdetil);
				$countdtl = count($arrdetil[$arrkeys[0]]);
				for($i=0;$i<$countdtl;$i++){
					for($j=0;$j<count($arrkeys);$j++){
						$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
					}
					$JUM = $JUM + $DATADTL["JUMLAH_MASUK"];
				}
				
				if($JUM > $JUMALAH_SATUAN){
					$ret = "MSG#ERR#Total Jumlah melebihi Jumlah Satuan yang ada.";
				}elseif($JUM < $JUMALAH_SATUAN){
					$ret = "MSG#ERR#Total Jumlah kurang dari Jumlah Satuan yang ada.";
				}else{
					$this->db->where(array(
											"KODE_TRADER"	=>$kode_trader,
											"NOMOR_AJU"		=>$AJU,
											"SERI"			=>$SERI_BARANG
									));
					$this->db->delete("T_TEMP_REALISASI_DOK");
					for($i=0;$i<$countdtl;$i++){
						for($j=0;$j<count($arrkeys);$j++){
							$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
						}
						$DATA["KODE_TRADER"] 		= $kode_trader;
						$DATA["NOMOR_AJU"]	 		= $AJU;
						$DATA["JENIS_DOK"]	 		= strtoupper($DOKUMEN);
						$DATA["KODE_BARANG"] 		= trim($KODE_BARANG);
						$DATA["JNS_BARANG"] 		= $JNS_BARANG;
						$DATA["SERI"]		 		= $SERI_BARANG;
						$DATA["LOGID_MASUK"] 		= $DATADTL["LOGID_MASUK"];
						$DATA["NO_DOK_MASUK"] 		= $DATADTL["NO_DOK_MASUK"];
						$DATA["TGL_DOK_MASUK"] 		= $DATADTL["TGL_DOK_MASUK"];
						$DATA["JENIS_DOK_MASUK"]	= $DATADTL["JENIS_DOK_MASUK"];
						$DATA["SERI_BARANG_MASUK"]	= $DATADTL["SERI_BARANG_MASUK"];
						$DATA["JUMLAH_MASUK"]		= $DATADTL["JUMLAH_MASUK"];
						$exec = $this->db->insert('T_TEMP_REALISASI_DOK', $DATA);
					}
					if($exec){
						$this->db->where(array(
												"KODE_TRADER"	=>$kode_trader,
												"NOMOR_AJU"		=>$AJU,
												"SERI"			=>$SERI_BARANG
										));
						$this->db->update("T_".$DOKUMEN."_DTL",array("METHODE"=>"DOK-IN"));
						$ret = "MSG#OK#Data Berhasil Disimpan.";
					}else{
						$ret = "MSG#OK#Data Gagal Disimpan.";
					}
				}
			}else{			
				$data = $this->input->post("id");
				$param = explode("~",$data);
				$SQL = "SELECT A.LOGID_MASUK, A.NO_DOK_MASUK, A.TGL_DOK_MASUK, A.JENIS_DOK_MASUK, A.SERI_BARANG_MASUK, A.JUMLAH_MASUK, 
						B.JUMLAH AS SALDO_AWAL, B.SALDO AS SISA_SALDO FROM t_temp_realisasi_dok A 
						LEFT JOIN t_logbook_pemasukan B ON A.KODE_TRADER = B.KODE_TRADER AND A.LOGID_MASUK  = B.LOGID
						WHERE A.KODE_TRADER = ".$this->db->escape($kode_trader)." AND A.NOMOR_AJU = ".$this->db->escape($param[1])." 
						AND A.SERI = ".$this->db->escape($param[2])." AND A.KODE_BARANG = ".$this->db->escape($param[3])." 
						AND A.JNS_BARANG = ".$this->db->escape($param[4])." AND A.JENIS_DOK = ".$this->db->escape($param[0])."";
				$ret = $this->db->query($SQL)->result_array();
			}
			return $ret;
		}
    }
	
	function getBB($act,$aju,$seri,$dok){
		$func = get_instance();
        $func->load->model("main", "main", true);
		$kode_trader = $this->newsession->userdata("KODE_TRADER");
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			if($act=="save"){
				if($this->input->post("val")=="y") $DATA["METHODE"] = "BB";
				else $DATA["METHODE"] = "";
				$this->db->where(array(
										"KODE_TRADER"	=>$kode_trader,
										"NOMOR_AJU" 	=> $aju,
										"SERI" 			=> $seri
									));
				$this->db->update("t_".$dok."_dtl",$DATA);
				$ret = "MSG#OK#Proses Berhasil";
			}else{
				$SQL = "SELECT NOMOR_DOK_ASAL, TANGGAL_DOK_ASAL, KODE_BARANG_BB, KODE_SATUAN_BB, JUMLAH_SATUAN_BB, KODE_DOK_ASAL, SERI_ASAL 
						FROM t_".$dok."_bb WHERE KODE_TRADER = '".$kode_trader."' AND NOMOR_AJU = '".$aju."' AND SERI = '".$seri."'";
				$ret = $this->db->query($SQL)->result_array();
			}
		}
		return $ret;
	}
	
	function cekaddrealisasi($dok, $kdbarang, $jnsbarang, $kdbarangpartner = "") 
	{
        $func = get_instance();
        $func->load->model("main", "main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
        $SQL = " SELECT KODE_BARANG FROM M_TRADER_BARANG 
				WHERE KODE_BARANG = ".$this->db->escape($kdbarang)." AND JNS_BARANG = ".$this->db->escape($jnsbarang)." 
				AND KODE_TRADER = ".$this->db->escape($kode_trader)."";
        $hasil = $func->main->get_result($SQL);
        if ($hasil)
		{
            return 'true';
		}
        else
		{
            return 'false';
		}
    }
	
	function cekdatastock($KODE_BARANG, $JNS_BARANG, $JUMLAHSATUAN, $SERIBRG, $NOAJU, $KODEDOK)
	{
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
        $SQL = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
				FROM M_TRADER_BARANG 
				WHERE KODE_BARANG = ".$this->db->escape($KODE_BARANG)." AND JNS_BARANG= ".$this->db->escape($JNS_BARANG)."
				AND KODE_TRADER = ".$this->db->escape($kode_trader)."";
        $stock = $this->db->query($SQL)->row();
        $JMLSTOCK = $stock->STOCK_AKHIR;
        $KODE_SATUAN = $stock->KODE_SATUAN;
        $KODE_SATUAN_TERKECIL = $stock->KODE_SATUAN_TERKECIL;
        $JML_SATUAN_TERKECIL = $stock->JML_SATUAN_TERKECIL;

        $SQL1 = "SELECT JUMLAH_SATUAN, KODE_SATUAN, PARSIAL_FLAG, BREAKDOWN_FLAG
			   FROM T_" . $KODEDOK . "_DTL WHERE NOMOR_AJU = ".$this->db->escape($NOAJU)." 
			   AND KODE_BARANG = ".$this->db->escape($KODE_BARANG)." AND JNS_BARANG = ".$this->db->escape($JNS_BARANG)." 
			   AND SERI = ".$this->db->escape($SERIBRG)."";
        $VALDTL = $this->db->query($SQL1)->row();
        $jumlah1 = $VALDTL->JUMLAH_SATUAN;
        $kdsatuan1 = $VALDTL->KODE_SATUAN;
        $PARSIAL_FLAG = $VALDTL->PARSIAL_FLAG;
        $BREAKDOWN_FLAG = $VALDTL->BREAKDOWN_FLAG;

        #================================================================================================
        if (strtoupper($PARSIAL_FLAG) == 'Y') 
		{
            $SQLP = "SELECT A.REALISASIID, B.KODE_BARANG, B.JNS_BARANG, B.JUMLAH, B.SATUAN, A.NAMA_TRADER
					 FROM t_temp_realisasi_parsial_hdr A, t_temp_realisasi_parsial_dtl B 
					 WHERE A.REALISASIID = B.HDR_REFF AND
					 A.NOMOR_AJU = ".$this->db->escape($NOAJU)." 
					 AND A.KODE_TRADER = ".$this->db->escape($kode_trader)." AND A.NO_DOK_INTERNAL IS NULL
					 AND B.KODE_BARANG = ".$this->db->escape($KODE_BARANG)." AND B.JNS_BARANG = ".$this->db->escape($JNS_BARANG)."";

            $rs = $this->db->query($SQLP);
            if ($rs->num_rows() > 0)
			{
                $VALPARSIAL = $rs->row();
                $JUMPARSIAL = $VALPARSIAL->JUMLAH;
            }
            $JUMLAHSATUAN = $JUMPARSIAL;
        } 
		else if (strtoupper($BREAKDOWN_FLAG) == 'Y') 
		{
            $SQLB = "SELECT NOMOR_AJU,SERI,KODE_BARANG,JNS_BARANG,JUMLAH,KODE_SATUAN 
						FROM t_breakdown_pengeluaran_dok 
		             WHERE NOMOR_AJU = ".$this->db->escape($NOAJU)." AND SERI = ".$this->db->escape($SERIBRG)."";

            $rs = $this->db->query($SQLB);
            if ($rs->num_rows() > 0) 
			{
                $VALBREAK = $rs->row();
                $JUMLAHSATUAN = $VALBREAK->JUMLAH;
            }
        }
        #================================================================================================

        if ($KODE_SATUAN_TERKECIL) 
		{
            if (strtoupper($kdsatuan1) == strtoupper($KODE_SATUAN_TERKECIL)) 
			{
                $JUMSSATS = $JUMLAHSATUAN;
            } 
			else 
			{
                if (empty($JML_SATUAN_TERKECIL))
				{
                    $JML_SATUAN_TERKECIL = 1;
				}
                $JUMSSATS = $JUMLAHSATUAN * $JML_SATUAN_TERKECIL;
            }
        }
		else
		{
            $JUMSSATS = $JUMLAHSATUAN;
        }

        if ($JMLSTOCK < $JUMSSATS)
		{
            return $JMLSTOCK . ' ' . $KODE_SATUAN_TERKECIL;
		}
        else
		{
            return 'true';
		}
    }

    function ceksaldo($JUMLAH_SATUAN, $KODE_BARANG, $JNS_BARANG)
	{
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $JUMLAH_OK = TRUE;
        $SQLSALDO = "SELECT SALDO, TGL_MASUK, LOGID FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
					 AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') 
					 AND (KODE_BARANG = ".$this->db->escape($KODE_BARANG)." OR KODE_BARANG IN 
					      (SELECT A.KODE_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
						   AND (B.KODE_BARANG = ".$this->db->escape($KODE_BARANG)." OR A.KODE_BARANG = ".$this->db->escape($KODE_BARANG)."))
						 ) 					 
					 AND (JNS_BARANG=".$this->db->escape($JNS_BARANG)." OR JNS_BARANG IN 
					 	  (SELECT A.JNS_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
						   AND (B.JNS_BARANG=".$this->db->escape($JNS_BARANG)." OR A.JNS_BARANG=".$this->db->escape($JNS_BARANG)."))
						 ) ORDER BY TGL_MASUK ASC";
					 
        $RSSALDO = $this->db->query($SQLSALDO);
        if ($RSSALDO->num_rows() > 0) 
		{
            foreach ($RSSALDO->result_array() as $DATA) 
			{
                $JUMSALDO = $DATA["SALDO"];
                $JUMSTOCKNSALDO_TEMP = $JUMSTOCKNSALDO_TEMP + $JUMSALDO;
                if ($JUMSTOCKNSALDO_TEMP >= $JUMLAH_SATUAN) 
				{
                    $JUMLAH_OK = FALSE;
                    break;
                }
            }
        }
        return $JUMLAH_OK;
    }
	
	function getBarang(){
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$aju = $this->input->post('nomor_aju');
		$dok = $this->input->post('kode_dokumen');
		$break = $this->input->post('breakdown');
		$parsial = $this->input->post('parsial');
		if($dok=="ppb-plb") $dok = "ppb";
		$jns_barang = "JNS_BARANG";
		$sql = "SELECT KODE_BARANG, f_ref('ASAL_JENIS_BARANG',".$jns_barang.") AS URAIAN, KODE_SATUAN, JUMLAH_SATUAN, 
				".$jns_barang." AS 'JNS_BARANG' ,SERI, BREAKDOWN_FLAG, PARSIAL_FLAG, METHODE
				FROM t_".$dok."_dtl
				WHERE NOMOR_AJU = ".$this->db->escape($aju)." AND KODE_TRADER = ".$this->db->escape($kode_trader)."";
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
									 WHERE KODE_TRADER = ".$this->db->escape($kode_trader)."  AND NOMOR_AJU = ".$this->db->escape($aju)." 
									 AND KODE_BARANG = ".$this->db->escape($row["KODE_BARANG"])."
									 AND ".$jns_barang." = ".$this->db->escape($row["JNS_BARANG"])." AND SERI = ".$row["SERI"];
					$this->db->query($query_update);
					$this->db->query("UPDATE t_".$dok."_hdr SET BREAKDOWN_FLAG = 'N' 
									 WHERE KODE_TRADER = ".$this->db->escape($kode_trader)."  AND NOMOR_AJU = ".$this->db->escape($aju)."");
				}
				
				if($row["PARSIAL_FLAG"]=="Y" && !$parsial){
					$query_update = "UPDATE t_".$dok."_dtl SET PARSIAL_FLAG = 'N' 
									 WHERE KODE_TRADER = ".$this->db->escape($kode_trader)." AND NOMOR_AJU = ".$this->db->escape($aju)." 
									 AND KODE_BARANG = ".$this->db->escape($row["KODE_BARANG"])."
									 AND ".$jns_barang." = ".$this->db->escape($row["JNS_BARANG"])." AND SERI = ".$row["SERI"];
					$this->db->query($query_update);
					$this->db->query("UPDATE t_".$dok."_hdr SET PARSIAL_FLAG = NULL 
									 WHERE KODE_TRADER = ".$this->db->escape($kode_trader)."  AND NOMOR_AJU = ".$this->db->escape($aju)."");
				}
				$wajib = ' wajib="yes" ';
				if(($row["BREAKDOWN_FLAG"]=="Y" && $break) || ($row["PARSIAL_FLAG"]=="Y" && $parsial)){
					$checked = 'checked="checked"';
					$style = '';
					$class = 'class="selected-break"';
					$disabled = 'disabled="disabled"';
					$wajib = '';
				}
				
				if($break) $onclick = 'onclick="breakdown_proses('.$i.',\'realisasi\',\'out\')"';
				if($parsial) $onclick = 'onclick="parsial_proses(\'realisasi\','.$i.',\'out\')"';
				#CEK GUDANG
				$SQG = "SELECT A.KODE_GUDANG, CONCAT(A.KODE_GUDANG,' - ',A.NAMA_GUDANG) NAMA_GUDANG 
						FROM M_TRADER_GUDANG A, M_TRADER_BARANG_GUDANG B 
						WHERE B.KODE_TRADER = ".$this->db->escape($kode_trader)."
						AND A.KODE_TRADER = B.KODE_TRADER AND A.KODE_GUDANG = B.KODE_GUDANG
						AND B.KODE_BARANG = ".$this->db->escape($row["KODE_BARANG"])." 
						AND B.JNS_BARANG = ".$this->db->escape($row["JNS_BARANG"])." ORDER BY A.KODE_GUDANG";
				$KODE_GUDANG = $func->main->get_combobox($SQG,"KODE_GUDANG", "NAMA_GUDANG", TRUE);
				if(count($KODE_GUDANG)==0){
					$KODE_GUDANG = array(''=>'Tidak Dikenal')	;
				}else{
					foreach($KODE_GUDANG as $a => $b){
						$KODE_GUDANG_FIRST = $a;
						break;
					}	
				}
				
				$QUERY = "SELECT KONDISI_BARANG, KODE_RAK, KODE_SUB_RAK 
						FROM M_TRADER_BARANG_GUDANG
						WHERE KODE_TRADER = ".$this->db->escape($kode_trader)."
						AND KODE_BARANG = ".$this->db->escape($row["KODE_BARANG"])." AND JNS_BARANG=".$this->db->escape($row["JNS_BARANG"])."";
				
				#CEK KONDISI
				$KODE_KODISI = $func->main->get_combobox($QUERY,"KONDISI_BARANG", "KONDISI_BARANG", TRUE);	
				if(count($KODE_KODISI)==0){
					$KODE_KODISI = array(''=>'Tidak Dikenal')	;
				}else{
					foreach($KODE_KODISI as $a => $b){
						$KODE_KODISI_FIRST = $a;
						break;
					}
				}
				
				#CEK RAK
				$KODE_RAK = $func->main->get_combobox($QUERY,"KODE_RAK", "KODE_RAK", TRUE);	
				if(count($KODE_RAK)==0){
					$KODE_RAK = array(''=>'Tidak Dikenal')	;
				}else{
					foreach($KODE_RAK as $a => $b){
						$KODE_RAK_FIRST = $a;
						break;
					}
				}
				
				#CEK SUBRAK
				$KODE_SUB_RAK = $func->main->get_combobox($QUERY,"KODE_SUB_RAK", "KODE_SUB_RAK", TRUE);	
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
						WHERE KODE_TRADER = ".$this->db->escape($kode_trader)."
						AND KODE_BARANG = ".$this->db->escape($row["KODE_BARANG"])." 
						AND JNS_BARANG = ".$this->db->escape($row["JNS_BARANG"])."";
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
				if((count($KODE_GUDANG)>1 || count($KONDISI_BARANG)>1) && ($row["BREAKDOWN_FLAG"]!="Y" && $row["PARSIAL_FLAG"]!="Y")){
					$html .= "<a id='btnAdd_".$i."' onclick='addGudang(".$i.");' href='javascript:void(0);' title=\"Tambah Gudang\">";
					$html .= "<i class=\"fa fa-plus-circle\"></i></a>";
				}
				$html .= "</td>";
				$html .= "<td id='tdkondisi_".$i."'><combo>".form_dropdown('kondisi['.$i.'][]', $KODE_KODISI, '', $wajib . ' id="kondisi_'.$i.'" class="stext" '.$disabled.'')."</combo></td>";
				$html .= '<td id="tdrak_'.$i.'"><combo>'.form_dropdown('rak['.$i.'][]', $KODE_RAK, '', 'id="rak_'.$i.'" class="stext" '.$disabled.'').'</combo></td>';
				$html .= '<td id="tdsubrak_'.$i.'"><combo>'.form_dropdown('subrak['.$i.'][]', $KODE_SUB_RAK, '', 'id="subrak_'.$i.'" class="stext" '.$disabled.'').'</combo></td>';
				
				#if(!$parsial || !$break)
				#{
					$html .= '<td align="center" id="tdmethode_'.$i.'"><input style="cursor:pointer;" value="dok" type="radio" onClick="getDokIn(\''.$dok.'\',\''.$aju.'\',\''.$row["SERI"].'\',\''.$row["KODE_BARANG"].'\',\''.$row["JNS_BARANG"].'\',\''.$row["JUMLAH_SATUAN"].'\');" title="Pilih Dokumen Pemasukan" name="BARANG['.$i.'][METHODE]" id="m_dok_'.$i.'" '.$disabled.'>&nbsp;';
					if(in_array($dok,array("bc282","bc41","bc20"))){
						$html .= '<input type="radio" value="bb" title="Bahan Baku" name="BARANG['.$i.'][METHODE]"  style="cursor:pointer;" title="Pilih Dokumen Pemasukan" onClick="getBB(\''.$dok.'\',\''.$aju.'\',\''.$row["SERI"].'\',\''.$row["KODE_BARANG"].'\',\''.$row["JNS_BARANG"].'\',\''.$row["JUMLAH_SATUAN"].'\');" id="m_bb_'.$i.'">';
					}
					$html .= '</td>';
				#}
				
				if($break || $parsial){
					$html .= '<td id="action_'.$i.'"><center><input type="checkbox" no="'.$i.'" name="chkbreak['.$i.']" id="breakchk'.$i.'" onClick="showbuttonbreak('.$i.')" value="'.$dok.'|'.$aju.'|'.$row["SERI"].'|'.$row["KODE_BARANG"].'|'.$row["JNS_BARANG"].'" '.$checked.' />&nbsp;<input type="button" name="breaktbl'.$i.'" id="breaktbl'.$i.'" no="'.$i.'" class="btn btn-primary btn-sm"  value="..." '.$style.' '.$onclick.'></center></td>';
				}
				$html .= "</tr>";
				//if($KODE_GUDANG_FIRST==''&&$KODE_KODISI_FIRST==''&&$KODE_RAK_FIRST==''&&$KODE_SUBRAK_FIRST==''){
					//$VALID = FALSE;
				//}
				$i++;
			}
			#jika tidak break maka hapus breakdown
			if(!$break){
				$this->db->where(array("KODE_TRADER"=>$kode_trader,"NOMOR_AJU"=>$aju));
				$this->db->delete("t_breakdown_pengeluaran_dok");
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
		if($VALID_SATUAN){
			return "OK#".$html;
		}else{
			return "ERR#".$html;
		}
	}
	
	function getKondisi()
	{
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_barang = $this->input->post("kode_barang");
		$jns_barang = $this->input->post("jns_barang");
		$kode_gudang = $this->input->post("kode_gudang");
		$id = $this->input->post("id");
		$no = $this->input->post("no");
		$SQL = "SELECT KONDISI_BARANG FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER = ".$this->db->escape($kode_trader)."
				AND KODE_BARANG=".$this->db->escape($kode_barang)." AND JNS_BARANG=".$this->db->escape($jns_barang)." 
				AND KODE_GUDANG = ".$this->db->escape($kode_gudang)."";
		$KODE_GUDANG = $func->main->get_combobox($SQL,"KONDISI_BARANG", "KONDISI_BARANG", FALSE);
		if(count($KODE_GUDANG)==0)
		{
			$KODE_KODISI = array(''=>'TIdak Ada Kondisi Gudang');
		}
		else
		{
			$KODE_KODISI = $KODE_GUDANG;
		}
		if($no!="")
		{
			if($no=="parsial")
			{
				#JIKA PARSIAL
				return "<combo>".form_dropdown('KONDISI[1][]', array_merge(array(""=>"-- Pilih --"),$KODE_KODISI), '', 'wajib="yes" id="kondisi-parsial-'.$id.'" class="stext" onChange="getRakParsial(\''.$kode_gudang.'\',this.value,'.$id.')"')."</combo>";
			}
			else
			{
				#JIKA REALISASI BIASA
				return "<combo>".form_dropdown('kondisi['.$id.'][]', array_merge(array(""=>"-- Pilih --"),$KODE_KODISI), '', 'wajib="yes" id="kondisi_'.$no.'" class="stext" onChange="getRak(\''.$kode_gudang.'\',this.value,'.$id.','.$no.')"')."</combo>";
			}
		}
		else
		{
			#JIKA REALISASI BREAK ATAU PARSIAL
			return "<combo>".form_dropdown('DATABREAK[KONDISI_BARANG][]', array_merge(array(""=>"-- Pilih --"),$KODE_KODISI), '', 'wajib="yes" id="kondisi-break-'.$id.'" class="stext" onChange="getRakBreak(\''.$kode_gudang.'\',this.value,'.$id.')"')."</combo>";
		}
	}
	
	function getRak()
	{
		$func = get_instance();
		$func->load->model("main","main", true);
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_barang = $this->input->post("kode_barang");
		$jns_barang = $this->input->post("jns_barang");
		$kode_gudang = $this->input->post("kode_gudang");
		$kondisi = $this->input->post('kondisi');
		$id = $this->input->post("id");
		$no = $this->input->post("no");
		$SQL = "SELECT KODE_RAK FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER=".$this->db->escape($kode_trader)."
				AND KODE_BARANG=".$this->db->escape($kode_barang)." AND JNS_BARANG=".$this->db->escape($jns_barang)." 
				AND KODE_GUDANG = ".$this->db->escape($kode_gudang)." 
				AND KONDISI_BARANG = ".$this->db->escape($kondisi)."";
		$RAK = $func->main->get_combobox($SQL,"KODE_RAK", "KODE_RAK", FALSE);
		if(count($RAK)==0)
		{
			$RAK = array(''=>'TIdak Ada Kondisi Gudang');
		}
		else
		{
			$RAK = $RAK;
		}
		if($no)
		{
			if($no=="parsial")
			{
				#JIKA PARSIAL
				return "<combo>".form_dropdown('RAK[1][]', array_merge(array(""=>"-- Pilih --"),$RAK), '', 'wajib="yes" id="rak-parsial-'.$no.'" class="stext" onChange="getSubRakParsial(\''.$kode_gudang.'\',\''.$kondisi.'\',this.value,'.$id.')"')."</combo>";
			}
			else
			{
				$val = $func->main->get_uraian($SQL,"KODE_RAK");
				if($val=="") $RAK = array();
				if($val!="") $wajib = 'wajib="yes"';
				else $wajib = 'wajib="no"';
				#JIKA BIASA
				return "<combo>".form_dropdown('rak['.$id.'][]', array_merge(array(""=>"-- Pilih --"),$RAK), '', $wajib.' id="rak_'.$no.'" class="stext" onChange="getSubRak(\''.$kode_gudang.'\',\''.$kondisi.'\',this.value,'.$id.','.$no.')"')."</combo>";
			}
		}
		else
		{
			#JIKA BREAKDOWN
			return "<combo>".form_dropdown('DATABREAK[KODE_RAK][]', array_merge(array(""=>"-- Pilih --"),$RAK), '', 'wajib="yes" id="rak-break-'.$no.'" class="stext" onChange="getSubRakBreak(\''.$kode_gudang.'\',\''.$kondisi.'\',this.value,'.$id.')"')."</combo>";
		}
	}
	
	function getSubRak()
	{
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
		$SQL = "SELECT KODE_SUB_RAK FROM M_TRADER_BARANG_GUDANG
				WHERE KODE_TRADER=".$this->db->escape($kode_trader)."
				AND KODE_BARANG=".$this->db->escape($kode_barang)." 
				AND JNS_BARANG=".$this->db->escape($jns_barang)." 
				AND KODE_GUDANG = ".$this->db->escape($kode_gudang)." 
				AND KONDISI_BARANG = ".$this->db->escape($kondisi)." 
				AND KODE_RAK = ".$this->db->escape($rak)."";
		$KODE_SUB_RAK = $func->main->get_combobox($SQL,"KODE_SUB_RAK", "KODE_SUB_RAK", FALSE);
		if(count($KODE_SUB_RAK)==0)
		{
			$KODE_SUB_RAK = array(''=>'TIdak Ada Kondisi Gudang');
		}
		else
		{
			$KODE_SUB_RAK = $KODE_SUB_RAK;
		}
		if($no)
		{
			if($no=="parsial")
			{
				#JIKA REALISASI PARSIAL
				return "<combo>".form_dropdown('SUBRAK[1][]', array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), '', 'wajib="yes" id="subrak-parsial-'.$id.'" class="stext"')."</combo>";
			}
			else
			{
				#JIKA REALISASI BIASA
				return "<combo>".form_dropdown('subrak['.$id.'][]', array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), '', 'wajib="yes" id="subrak_'.$no.'" class="stext"')."</combo>";
			}
		}
		else
		{
			#JIKA REALISASI BREAKDOWN
			return "<combo>".form_dropdown('DATABREAK[KODE_SUB_RAK][]', array_merge(array(""=>"-- Pilih --"),$KODE_SUB_RAK), '', 'wajib="yes" id="subrak-break-'.$id.'" class="stext"')."</combo>";
		}
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
		$TOTALPARSIAL = $this->input->post('TOTALPARSIAL');
		$barang = $this->input->post("BARANG");
		$jumlah_masuk = $this->input->post('jumlah');
		$gudang_tujuan = $this->input->post('gudang');
		$kondisi = $this->input->post('kondisi');
		$rak = $this->input->post('rak');
		$subrak = $this->input->post('subrak');
		$chkbreak = $this->input->post("chkbreak");
        
		if(strtolower($KODE_DOKUMEN)=="ppb-plb"){
			$KODE_DOKUMEN = "ppb";
		}
		
		foreach ($this->input->post('HEADER') as $a => $b){
            $HEADER[$a] = $b;
        }
        
		if ($this->input->post('act') == "save"){
            if ($TANGGAL_REALISASI) {
                $HEADER["TANGGAL_REALISASI"] 	= $TANGGAL_REALISASI . ' ' . $WAKTU;
                $INOUT["TANGGAL"] 				= $TANGGAL_REALISASI . ' ' . $WAKTU;
           		$LOG["TGL_MASUK"] 				= $TANGGAL_REALISASI;
                $HEADER["STATUS"] 				= "19";
            }else{
                $HEADER["TANGGAL_REALISASI"] 	= date("Y-m-d H:i:s");
                $INOUT["TANGGAL"] 				= date("Y-m-d H:i:s");
           		$LOG["TGL_MASUK"] 				= date("Y-m-d");
                $HEADER["STATUS"] 				= "19";
            }
            
			$INOUT["TIPE"] 				= "GATE-OUT";
            $INOUT["KODE_TRADER"] 		= $KODE_TRADER;
            $INOUT["KODE_DOKUMEN"] 		= $KODE_DOKUMEN;
            $INOUT["TANGGAL_DOKUMEN"] 	= $TANGGAL_DAFTAR;
            $INOUT["NOMOR_AJU"] 		= $NOMOR_AJU;
            $INOUT["PROCESS_WITH"] 		= "FORM";
            $INOUT["CREATED_TIME"] 		= date("Y-m-d H:i:s");

            $LOG["JENIS_DOK"] 		= $KODE_DOKUMEN;
            $LOG["NO_DOK"] 			= $NOMOR_DAFTAR;
            $LOG["TGL_DOK"] 		= $TANGGAL_DAFTAR;
            $LOG["KODE_TRADER"]		= $KODE_TRADER;

            if(strtoupper($KODE_DOKUMEN) == "BC28"){
                $SQL = "SELECT A.SERI, A.URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG, A.METHODE
					  FROM T_BC28_DTL A, T_BC28_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." 
					  AND B.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." ORDER BY A.SERI ASC";
            }elseif(strtoupper($KODE_DOKUMEN) == "BC27"){
                $SQL = "SELECT A.SERI, A.URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.HARGA_PENYERAHAN AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG, A.METHODE
					  FROM T_BC27_DTL A, T_BC27_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." AND B.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
					  ORDER BY A.SERI ASC";
            }elseif(strtoupper($KODE_DOKUMEN) == "BC30"){
                $SQL = "SELECT A.SERI, A.URAIAN_BARANG1 URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.FOB_PER_BARANG AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG, A.METHODE
					  FROM T_BC30_DTL A, T_BC30_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." AND B.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
					  ORDER BY A.SERI ASC";
            }elseif(strtoupper($KODE_DOKUMEN) == "BC41"){
                $SQL = "SELECT A.SERI, A.URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, A.HARGA_PENYERAHAN AS CIF, A.KODE_BARANG,
					  A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG, A.METHODE
					  FROM T_BC41_DTL A, T_BC41_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
					  AND B.NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." AND B.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
					  ORDER BY A.SERI ASC";
            }elseif(strtoupper($KODE_DOKUMEN)=="PPB"){
				$SQL = "SELECT A.SERI, A.URAIAN_BARANG, A.KODE_SATUAN, A.JUMLAH_SATUAN, '0' AS CIF, A.KODE_BARANG,
					    A.JNS_BARANG, A.BREAKDOWN_FLAG AS BREAKDOWNFLAG, A.PARSIAL_FLAG AS PARSIALFLAG, A.METHODE
							FROM T_PPB_DTL A, T_PPB_HDR B WHERE A.NOMOR_AJU=B.NOMOR_AJU 
						AND B.NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." AND B.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
						ORDER BY A.SERI ASC";
			}
            $HASIL = $func->main->get_result($SQL);
            if ($HASIL) 
			{
				foreach ($SQL->result_array() as $row) 
				{
					#cek kode barang
					$val = $this->cekaddrealisasi($KODE_DOKUMEN, $row["KODE_BARANG"], $row["JNS_BARANG"]);
					if ($val == "false") 
					{
                    	$kode = $kode . '<b>' . $row["KODE_BARANG"] . '</b> dgn Jenis Barang <b>' . $row["JNS_BARANG"] . '</b>, ';
					}
					
					#cek data stock master barang
					$jstock = $this->cekdatastock($row["KODE_BARANG"], $row["JNS_BARANG"], $row["JUMLAH_SATUAN"], $row["SERI"], $NOMOR_AJU, $KODE_DOKUMEN);
                    if ($jstock != 'true')
					{
                        $outstock = $outstock . '' . $row["KODE_BARANG"] . ' = ' . $jstock . ',';
					}
					
					if($row["BREAKDOWNFLAG"]=="" || $row["PARSIALFLAG"]==""){
						#cek jumlah pemasukan
						$jsaldo = $this->ceksaldo($row["JUMLAH_SATUAN"], $row["KODE_BARANG"], $row["JNS_BARANG"]);
						if ($jsaldo)
						{
							$csaldo = $csaldo . '<strong>' . $row["KODE_BARANG"] . '</strong>,';
						}
					}
				}
				
				#end pengecekan realisasi biasa
				if(!$BREAK && !$PARSIAL && empty($chkbreak))
				{
					$i = 1;
					$method = "";
					foreach($barang as $barang)
					{
						$method = $barang['METHODE'];
						$arrdata[$i]['KODE_BARANG'] 	= $barang['KODE_BARANG'];
						$arrdata[$i]['JNS_BARANG'] 		= $barang['JNS_BARANG'];
						$arrdata[$i]['KODE_SATUAN'] 	= $barang['KODE_SATUAN'];
						$arrdata[$i]['JUMLAH_SATUAN'] 	= $barang['JUMLAH_SATUAN'];
						$arrdata[$i]['METHODE'] 		= $barang['METHODE'];
						
						#methode fifo & dok-in
						$tempJumlah = 0;
						if(count($jumlah_masuk[$i])> 0)
						{
							for ($k=0; $k < count($jumlah_masuk[$i]) ; $k++)
							{
								$arrdata[$i]['data'][$k]['JUMLAH'] 	= $jumlah_masuk[$i][$k];
								$arrdata[$i]['data'][$k]['GUDANG'] 	= $gudang_tujuan[$i][$k];
								$arrdata[$i]['data'][$k]['KONDISI'] = $kondisi[$i][$k];
								$arrdata[$i]['data'][$k]['RAK'] 	= $rak[$i][$k];
								$arrdata[$i]['data'][$k]['SUBRAK'] 	= $subrak[$i][$k];
								$tempJumlah = $tempJumlah + $jumlah_masuk[$i][$k];
								$sqlValidasi = "SELECT JUMLAH FROM m_trader_barang_gudang 
												WHERE KODE_TRADER = ".$this->db->escape($KODE_TRADER)."
												AND KODE_BARANG = ".$this->db->escape($barang['KODE_BARANG'])." 
												AND JNS_BARANG = ".$this->db->escape($barang['JNS_BARANG'])."
												AND KODE_GUDANG = ".$this->db->escape($gudang_tujuan[$i][$k])."
												AND KONDISI_BARANG = ".$this->db->escape($kondisi[$i][$k])." 
												AND KODE_RAK = ".$this->db->escape($rak[$i][$k])." 
												AND KODE_SUB_RAK = ".$this->db->escape($subrak[$i][$k])."";
								$doValidasi = $this->db->query($sqlValidasi);
								if ($doValidasi->num_rows() < 0) 
								{
									$gudang = $gudang." <b>Kode Barang ".$barang['KODE_BARANG']." dengan Kode Gudang ".$gudang_tujuan[$i][$k]." dan Kondisi Barang ".$kondisi[$i][$k]."</b>, ";
								}
								else
								{
									$DATA = $doValidasi->row();
									$JUMLAH = $DATA->JUMLAH;
									if($arrdata[$i]['data'][$k]['JUMLAH'] > $JUMLAH)
									{
										$saldogudang = $saldogudang."<strong>Kode Barang ".$barang["KODE_BARANG"]." dengan Gudang ".$arrdata[$i]["data"][$k]["Gudang"].". Stock yang tersedia : ".$JUMLAH."</strong>, ";
									}
								}
							}
							if ($tempJumlah > $barang['JUMLAH_SATUAN'])
							{
								$jumlahlebih = $jumlahlebih ."<strong> Kode Barang : ".$barang['KODE_BARANG']."</strong>, ";
							} 
							elseif ($tempJumlah < $barang['JUMLAH_SATUAN']) 
							{
								$jumlahkurang = $jumlahkurang."<strong> Kode Barang : ".$barang['KODE_BARANG']."</strong>, ";
							}
						}
						else
						{
							$arrdata[$i]['data'][0]['JUMLAH'] 	= $barang["JUMLAH_SATUAN"];
							$arrdata[$i]['data'][0]['GUDANG'] 	= $gudang_tujuan[$i][0];
							$arrdata[$i]['data'][0]['KONDISI'] 	= $kondisi[$i][0];
							$arrdata[$i]['data'][0]['RAK'] 		= $rak[$i][0];
							$arrdata[$i]['data'][0]['SUBRAK'] 	= $subrak[$i][0];
							$sqlValidasi1 = "SELECT JUMLAH FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."'
											AND KODE_BARANG = '".$barang['KODE_BARANG']."' 
											AND JNS_BARANG = '".$barang['JNS_BARANG']."'
											AND KODE_GUDANG = '".$gudang_tujuan[$i][0]."'
											AND KONDISI_BARANG = '".$kondisi[$i][0]."' 
											AND KODE_RAK = '".$rak[$i][0]."' 
											AND KODE_SUB_RAK = '".$subrak[$i][0]."'";
							$doValidasi1 = $this->db->query($sqlValidasi1);
							if ($doValidasi1->num_rows() < 0) 
							{
								$gudang = $gudang." <b>Kode Barang ".$barang['KODE_BARANG']." dengan Kode Gudang ".$arrdata[$i]["data"][0]["GUDANG"]." dan Kondisi Barang ".$arrdata[$i]["data"][0]["KONDISI"]."</b>, ";
							}
							else
							{
								$DATA1 = $doValidasi1->row();
								$JUMLAH1 = $DATA1->JUMLAH;
								if($barang["JUMLAH_SATUAN"] > $JUMLAH1)
								{
									$saldogudang = $saldogudang."<strong>Kode Barang ".$barang["KODE_BARANG"]." dengan Gudang ".$arrdata[$i]["data"][0]["GUDANG"].". Stock yang tersedia : ".$JUMLAH1."</strong>, ";
								}
							}
						}#end methode fifo
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
								$sqlValidasi = "SELECT ID FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."'
												AND KODE_BARANG = '".$val['KODE_BARANG']."' 
												AND JNS_BARANG = '".$val['JNS_BARANG']."'
												AND KODE_GUDANG = '".$gudang_tujuan[$i][$k]."'
												AND KONDISI_BARANG = '".$kondisi[$i][$k]."'
												AND KODE_RAK = '".$rak[$i][$k]."' 
												AND KODE_SUB_RAK = '".$subrak[$i][$k]."'";
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
				if ($kode){
                    $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
                    $dtjuml = count(explode(",", $dtkode));
                    $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Barang yang Belum terdaftar, Yaitu : " . $dtkode . "";
                    echo "MSG#ERR#Realisasi Gagal" . $addWarning . "#edit#"; die();
                }else if ($outstock){
                    $dtstock = str_replace(",", ", ", substr($outstock, 0, strlen($outstock) - 1));
                    $dtjumlstock = count(explode(",", $dtstock));
                    $addWarning = ", terdapat <b>" . $dtjumlstock . "</b> Barang dengan Jumlah Stock tidak mencukupi.";
                    $addWarning.= "<p style=\"margin-left:166px;\">Jumlah Stock yang ada adalah : " . $dtstock . "</p>";
                    echo "MSG#ERR#Realisasi Gagal" . $addWarning . "#edit#"; die();
                }else if ($csaldo){
                    $dtsaldo = str_replace(",", ", ", substr($csaldo, 0, strlen($csaldo) - 1));
                    $dtjumlsaldo = count(explode(",", $dtsaldo));
                    $addWarning = ",  terdapat <b>" . $dtjumlsaldo . "</b> Barang dengan Jumlah Saldo Pemasukan tidak mencukupi, Yaitu : " . $dtsaldo . "";
                    echo "MSG#ERR#Realisasi Gagal" . $addWarning . "#edit#"; die();
                }else if($gudang){
					$dtgudang = str_replace(",", ", ", substr($gudang, 0, strlen($gudang) - 1));
                    $dtjumlgudang = count(explode(",", $dtgudang));
                    $addWarning = ", terdapat <b>" . $dtjumlgudang . "</b> Kode Gudang yang tidak dikenali, Yaitu : " . $dtgudang . "";
                    echo "MSG#ERR#Realisasi Gagal" . $addWarning . "#edit#"; die();
				}else if($saldogudang){
					$dtsaldogudang = str_replace(",", ", ", substr($saldogudang, 0, strlen($saldogudang) - 1));
					$addWarning = "terdapat stock gudang tidak mencukupi, yaitu: ".$dtsaldogudang;
                    echo "MSG#ERR#Realisasi Gagal, " . $addWarning . "#edit#"; die();
				}else if ($jumlahlebih){
					$dtlebih = str_replace(",", ", ", substr($jumlahlebih, 0, strlen($jumlahlebih) - 1));
					$addWarning = "Total jumlah melebihi jumlah satuan pada Kode Barang, Yaitu : " . $dtlebih . "";
                    echo "MSG#ERR#Realisasi Gagal, " . $addWarning . "#edit#"; die();
				}else if ($jumlahkurang){
					$dtkurang = str_replace(",", ", ", substr($jumlahkurang, 0, strlen($jumlahkurang) - 1));
					$addWarning = "Total jumlah kurang dari jumlah satuan pada Kode Barang, Yaitu : " . $dtkurang . "";
                    echo "MSG#ERR#Realisasi Gagal, " . $addWarning . "#edit#"; die();
				}else{
					$PROSESPARSIAL = FALSE;
                    $STATUSJUMLAH = array();
					$idx = 0;
                    foreach ($SQL->result_array() as $row){
						$x = $idx + 1;
						if($BREAK){
							if (strtoupper($row["BREAKDOWNFLAG"]) == 'Y') {
                                $exec = $this->proses_realisasi_break($KODE_DOKUMEN, $NOMOR_AJU, $row, $INOUT, $LOG);
								if($exec==false){
									$exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
								}
                            } else {
                                $exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
                            }
						}
						if ($PARSIAL) {
							if (strtoupper($row["PARSIALFLAG"]) == 'Y') {
								$exec = $this->proses_realisasi_parsial($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG);
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
									if($TOTALPARSIAL!=""){
										if($TOTALPARSIAL==0){
											$STATUSJUMLAH[] = "YES";
										}else{
											$STATUSJUMLAH[] = "NO";	
										}
									}else{
										$STATUSJUMLAH[] = "YES";	
									}
								}else{
									$STATUSJUMLAH[] = "NO";
								}
							}else{
								$exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
							}
						}
						if ($BREAK == "" && $PARSIAL == ""){
                            $exec = $this->proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $row, $HEADER, $INOUT, $LOG, $x, $arrdata);
                        }
						$idx++;
					}
					if ($PROSESPARSIAL) {
					
						print_r($STATUSJUMLAH); die();
                        $SQLCHECK = "SELECT NOMOR_AJU FROM T_REALISASI_PARSIAL_HDR WHERE 
									 NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." AND KODE_TRADER = ".$this->db->escape($KODE_TRADER)."";
                        if ($func->main->get_result($SQLCHECK)) {
                            $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU,"KODE_TRADER"=>$KODE_TRADER));
                            $this->db->update('t_' . strtolower($KODE_DOKUMEN) . '_hdr', $HEADER);
                            #delete temp dok
                            $sql = "SELECT REALISASIDTLID FROM t_temp_realisasi_parsial_dtl WHERE HDR_REFF='" . $REALISASIID . "'";
                            $get_id_dok = $this->db->query($sql)->result_array();
                            foreach ($get_id_dok as $rows) {
                                $id_dok = $rows;
                            }
                            $this->db->where(array('REALISASIDTLID' => $id_dok['REALISASIDTLID']));
                            $this->db->delete('t_temp_realisasi_parsial_gudang');
							$this->db->where(array('REALISASIDTLID' => $id_dok['REALISASIDTLID']));
                            $this->db->delete('t_temp_realisasi_parsial_dok');
                        }
                        if (!in_array("NO", $STATUSJUMLAH)) {
                            $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU));
                            $this->db->update('t_' . strtolower($KODE_DOKUMEN) . '_hdr', array("STATUS_REALISASI" => "1"));
                        }
                        $this->db->where(array('HDR_REFF' => $REALISASIID));
                        $this->db->delete('t_temp_realisasi_parsial_dtl');
                        $this->db->where(array('REALISASIID' => $REALISASIID));
                        $exec = $this->db->delete('t_temp_realisasi_parsial_hdr');
                    }else{
                        if ($exec) {
                            $HEADER["STATUS_REALISASI"] = "1";
                            $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, "KODE_TRADER"=>$KODE_TRADER));
                            $exec = $this->db->update('t_' . strtolower($KODE_DOKUMEN) . '_hdr', $HEADER);
                        }
                    }
					if ($exec) {
						$ADDREMARK = "";
						if ($PROSESPARSIAL){
							$ADDREMARK = "REALISASI PARSIAL, ";
						}
						$REMARK = $ADDREMARK . "NO. AJU=" . $NOMOR_AJU . ", NO.PENERIMAAN=" . $HEADER["NOMOR_DOK_INTERNAL"] . ", TGL.PENERIMAAN=" . $HEADER["TANGGAL_DOK_INTERNAL"];
						$func->main->activity_log("REALISASI PENGELUARAN " . strtoupper($KODE_DOKUMEN), $REMARK);
						echo "MSG#OK#Realisasi Berhasil, silahkan proses data lainnya.#edit#";
					}else{
						echo "MSG#ERR#Realisasi Gagal, cek kembali data anda#edit#";
					}
				}
			}else{
				echo "MSG#ERR#Realisasi Gagal, cek kembali data anda#edit#";
			}
        } 
		else if ($this->input->post('act') == "update") 
		{
            $NOMOR_AJU = $this->input->post("ajuEdit");
            $HEADER["NOMOR_AJU"] = $NOMOR_AJU;
            $HEADER["UPDATED_BY"] = $this->newsession->userdata('USER_ID');
            $HEADER["UPDATED_TIME"] = date("Y_m-d H:i:s");
			$this->db->where(array('NOMOR_AJU' => $NOMOR_AJU,"KODE_TRADER"=>$KODE_TRADER));
			$exec = $this->db->update('t_'.strtolower($KODE_DOKUMEN).'_hdr', $HEADER);
			
            if ($exec) 
			{
                $REMARK = "NO. AJU=" . $NOMOR_AJU . ", NO.PENERIMAAN=" . $HEADER["NOMOR_DOK_INTERNAL"] . ", TGL.PENERIMAAN=" . $HEADER["TANGGAL_DOK_INTERNAL"];
                $func->main->activity_log("EDIT REALISASI PENGELUARAN " . $KODE_DOKUMEN, $REMARK);
                echo "MSG#OK#Ubah Realisasi Berhasil#edit#";
            } 
			else 
			{
                echo "MSG#ERR#Ubah Realisasi Gagal#edit#";
            }
        }
    }
	
	function proses_realisasi_biasa($KODE_DOKUMEN, $NOMOR_AJU, $DETIL, $HEADER, $INOUT, $LOG, $x, $arrdata){
		$func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$count = count($arrdata[$x]['data']);
		$TOTJUMBARANG = 0;
		for ($i=0; $i < $count; $i++){
			$jumlah_proses = $arrdata[$x]['data'][$i]['JUMLAH'];
			$SQL2 = "SELECT STOCK_AKHIR, KODE_SATUAN, KODE_SATUAN_TERKECIL, JML_SATUAN_TERKECIL 
				   FROM M_TRADER_BARANG WHERE KODE_BARANG=".$this->db->escape($DETIL["KODE_BARANG"])." 
				   AND JNS_BARANG=".$this->db->escape($DETIL["JNS_BARANG"])." 
				   AND KODE_TRADER=".$this->db->escape($KODE_TRADER)."";
	
			if (strtoupper($DETIL["PARSIALFLAG"]) == 'Y'){
				$SQLINOUT = "SELECT IFNULL(f_jum_inout('" . $NOMOR_AJU . "','" . $KODE_DOKUMEN . "','" . $KODE_TRADER . "','" . $DETIL["KODE_BARANG"] . "','" . $DETIL["JNS_BARANG"] . "','" . $DETIL["KODE_SATUAN"] . "','".$INOUT["SERI_DOKUMEN"]."'),0) AS JUMLAH_INOUT FROM DUAL";
				$RSINOUT = $this->db->query($SQLINOUT);
				$JUMUDAHINOUT = 0;
				if ($RSINOUT->num_rows() > 0){
					$VALINOUT = $RSINOUT->row();
					$JUMUDAHINOUT = $VALINOUT->JUMLAH_INOUT;
				}
				$jumlah1 = $DETIL["JUMLAH_SATUAN"] - $JUMUDAHINOUT;
			}else{
				$jumlah1 = $jumlah_proses;
			}
			$kdsatuan1 = $DETIL["KODE_SATUAN"];
			
			$VALBRG = $this->db->query($SQL2)->row();
			$jumlah2 = $VALBRG->STOCK_AKHIR;
			$kdsatuan2 = $VALBRG->KODE_SATUAN;
			$kdsatuanKecil = $VALBRG->KODE_SATUAN_TERKECIL;
			$jmlsatuanKecil = $VALBRG->JML_SATUAN_TERKECIL;
	
			if (empty($jmlsatuanKecil)){
				$jmlsatuanKecil = 1;
			}
			$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
	
			if ($kdsatuanKecil){
				if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)){
					$JUMLAH_BARANG = $jumlah1;
				}else{
					if (empty($jmlsatuanKecil)){
						$jmlsatuanKecil = 1;
					}
					$JUMLAH_BARANG = $jumlah1 * $jmlsatuanKecil;
				}
			}else{
				$JUMLAH_BARANG = $jumlah1;
			}
			
			#start insert data inout
			$INOUT["KODE_BARANG"] 		= $DETIL["KODE_BARANG"];
			$INOUT["JNS_BARANG"] 		= $DETIL["JNS_BARANG"];
			$INOUT["JUMLAH"] 			= $JUMLAH_BARANG;
			$INOUT["KODE_GUDANG"] 		= $arrdata[$x]['data'][$i]['GUDANG'];
			$INOUT["KONDISI_BARANG"]	= $arrdata[$x]['data'][$i]['KONDISI'];
			$INOUT["KODE_RAK"] 			= $arrdata[$x]['data'][$i]['RAK'];
			$INOUT["KODE_SUB_RAK"] 		= $arrdata[$x]['data'][$i]['SUBRAK'];
			$INOUT["CREATED_TIME"] 		= date('Y-m-d H:i:s', time() - 60 * 60 * 1);
			$INOUT["SERI_DOKUMEN"] 		= $DETIL["SERI"];
			$exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
			#end insert data inout
			if ($exec) {
				#start update m_trader_barang_gudang
				$this->db->where(array(
										"KODE_BARANG" 		=> $DETIL["KODE_BARANG"],
										"JNS_BARANG"  		=> $DETIL["JNS_BARANG"],
										"KODE_TRADER" 		=> $KODE_TRADER,
										"KODE_GUDANG" 		=> $arrdata[$x]['data'][$i]['GUDANG'],
										"KONDISI_BARANG" 	=> $arrdata[$x]['data'][$i]['KONDISI'],
										"KODE_RAK" 			=> $arrdata[$x]["data"][$i]['RAK'],
										"KODE_SUB_RAK" 		=> $arrdata[$x]["data"][$i]['SUBRAK']
									   )
								  );
				$this->db->set('JUMLAH', 'JUMLAH - '.(float)$JUMLAH_BARANG, FALSE);
				$this->db->update('m_trader_barang_gudang');
				#end update m_trader_barang_gudang
			}
			$TOTJUMBARANG = $TOTJUMBARANG + $JUMLAH_BARANG;
		}
		
		$LOG["KODE_BARANG"] 	= $DETIL["KODE_BARANG"];
		$LOG["JNS_BARANG"] 		= $DETIL["JNS_BARANG"];
		$LOG["NAMA_BARANG"] 	= $DETIL["URAIAN_BARANG"];
		$LOG["SERI_BARANG"] 	= $DETIL["SERI"];
		$LOG["SATUAN"] 			= $kdsatuanKecil;
		$LOG["NILAI_PABEAN"] 	= (float)$DETIL["CIF"];
		$LOG["NOMOR_AJU"] 		= $NOMOR_AJU;
		
		if($DETIL["METHODE"]==""){
			#start cari pemasukan yg masih memiliki saldo dengan method fifo
			$sql = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, SALDO, SERI_BARANG FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='" . $KODE_TRADER . "' 
					 AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') 
					 AND (KODE_BARANG=".$this->db->escape($DETIL["KODE_BARANG"])." OR KODE_BARANG IN 
						  (SELECT A.KODE_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
						   AND (B.KODE_BARANG=".$this->db->escape($DETIL["KODE_BARANG"])." 
						   		OR A.KODE_BARANG=".$this->db->escape($DETIL["KODE_BARANG"])."))
						 ) 					 
					 AND (JNS_BARANG=".$this->db->escape($DETIL["JNS_BARANG"])." OR JNS_BARANG IN 
						  (SELECT A.JNS_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=".$this->db->escape($KODE_TRADER)." 
						   AND (B.JNS_BARANG=".$this->db->escape($DETIL["JNS_BARANG"])." 
						   		OR A.JNS_BARANG=".$this->db->escape($DETIL["JNS_BARANG"])."))
						 ) ORDER BY TGL_DOK ASC";
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				$JUMSALDO = 0;
				$jumlah = $TOTJUMBARANG;
				foreach ($result->result_array() as $rows){
					$LOGID = $rows['LOGID'];
					$JUMSALDO = $rows["SALDO"];
					$JUMSTOCKNSALDO = $JUMSTOCKNSALDO + $JUMSALDO;
					if ($JUMSTOCKNSALDO >= $TOTJUMBARANG){
						$stokahir = $JUMSTOCKNSALDO - $TOTJUMBARANG;
						if ($stokahir > 0){
							$SQL = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO=" . $stokahir . " WHERE LOGID='" . $LOGID . "'";
							$update_pemasukan = $this->db->query($SQL);
							$JUMLAH_BARANG_PAKAI = $jumlah;
						}else{
							$pakai = $JUMSTOCKNSALDO - $JUMSALDO;
							if($stokahir == 0) 
							{
								$pakai = $jumlah;
							}
							$this->db->where("LOGID", $LOGID);
							$update_pemasukan = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP'=>'1','SALDO'=>$stokahir));
							$JUMLAH_BARANG_PAKAI = $pakai;
						}
						if ($update_pemasukan){
							$LOG["NO_DOK_MASUK"] 		= $rows['NO_DOK'];
							$LOG["TGL_DOK_MASUK"] 		= $rows['TGL_DOK'];
							$LOG["JENIS_DOK_MASUK"] 	= $rows['JENIS_DOK'];
							$LOG["SERI_BARANG_MASUK"] 	= $rows['SERI_BARANG'];
							$LOG["LOGID_MASUK"] 		= $LOGID;
							$LOG["JUMLAH"] 				= $JUMLAH_BARANG_PAKAI;
							$LOG["METHOD"] 				= "FIFO";
							$insert_pengeluaran 		= $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
							break;
						}
					}else{
						if($result->num_rows() > 1){
							$this->db->where("LOGID", $LOGID);
							$update_pemasukan = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => '1', 'SALDO' => 0));
							$jumlah = ((float) $jumlah - $rows['SALDO']);
							$JUMLAH_BARANG_PAKAI = $JUMSTOCKNSALDO;
							if($JUMSALDO <= $JUMSTOCKNSALDO){
								$JUMLAH_BARANG_PAKAI = $JUMSALDO;
							}
							if ($update_pemasukan){
								$LOG["NO_DOK_MASUK"] 		= $rows['NO_DOK'];
								$LOG["TGL_DOK_MASUK"] 		= $rows['TGL_DOK'];
								$LOG["JENIS_DOK_MASUK"] 	= $rows['JENIS_DOK'];
								$LOG["SERI_BARANG_MASUK"] 	= $rows['SERI_BARANG'];
								$LOG["LOGID_MASUK"] 		= $LOGID;
								$LOG["JUMLAH"] 				= $JUMLAH_BARANG_PAKAI;
								$LOG["METHOD"] 				= "FIFO";
								$insert_pengeluaran = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
							}
						}
					}
				}
			}#end pencarian saldo & methode fifo
		}elseif($DETIL["METHODE"]=="DOK-IN"){
			#jika memilih dokumen pemasukan
			$SQL = "SELECT LOGID_MASUK, NO_DOK_MASUK, TGL_DOK_MASUK, JENIS_DOK_MASUK, SERI_BARANG_MASUK, JUMLAH_MASUK 
					FROM t_temp_realisasi_dok WHERE NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." 
					AND KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
					AND SERI = ".$this->db->escape($DETIL["SERI"])." 
					AND JENIS_DOK = ".strtoupper($this->db->escape($KODE_DOKUMEN));
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $data){
					$SALDO = $func->main->get_uraian("SELECT SALDO FROM t_logbook_pemasukan WHERE LOGID = '".$data["LOGID_MASUK"]."' AND KODE_TRADER = '".$KODE_TRADER."'","SALDO");
					$LOG["NO_DOK_MASUK"]		= $data["NO_DOK_MASUK"];
					$LOG["JENIS_DOK_MASUK"]		= $data["JENIS_DOK_MASUK"];
					$LOG["SERI_BARANG_MASUK"]	= $data["SERI_BARANG_MASUK"];
					$LOG["LOGID_MASUK"]			= $data["LOGID_MASUK"];
					$LOG["METHOD"]				= "DOK-IN";
					$LOG["JUMLAH"]				= $data["JUMLAH_MASUK"];
					$LOG["TGL_DOK_MASUK"]		= $data['TGL_DOK_MASUK'];
					if($SALDO==$data["JUMLAH_MASUK"]){
						$this->db->set("SALDO", "SALDO - ".(float)$data["JUMLAH_MASUK"], FALSE);
						$this->db->set("FLAG_TUTUP", "1", FALSE);
						$this->db->where(array
											(
												"LOGID"			=> $data["LOGID_MASUK"],
												"KODE_TRADER"	=> $KODE_TRADER
											)
										);
						$exec = $this->db->update("T_LOGBOOK_PEMASUKAN");
					}else{
						$this->db->set("SALDO", "SALDO - ".(float)$data["JUMLAH_MASUK"], FALSE);
						$this->db->where(array
											(
												"LOGID"			=> $data["LOGID_MASUK"],
												"KODE_TRADER"	=> $KODE_TRADER
											)
										);
						$exec = $this->db->update("T_LOGBOOK_PEMASUKAN");
					}
					
					#jika selesai update saldo pemasukan insert ke table logbook_pengeluaran
					if($exec){
						$exec = $this->db->insert("t_logbook_pengeluaran",$LOG);
					}
				}
			}else{
				#methode fifo
				$sql = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, SALDO, SERI_BARANG 
						FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER=".$this->db->escape($KODE_TRADER)." 
						AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') 
						AND (KODE_BARANG=".$this->db->escape($DETIL["KODE_BARANG"])." OR KODE_BARANG IN 
						  (SELECT A.KODE_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=".$this->db->escape($KODE_TRADER)." 
						   AND (B.KODE_BARANG=".$this->db->escape($DETIL["KODE_BARANG"])." 
						   	OR A.KODE_BARANG=".$this->db->escape($DETIL["KODE_BARANG"])."))
						 ) 					 
						AND (JNS_BARANG=".$this->db->escape($DETIL["JNS_BARANG"])." OR JNS_BARANG IN 
						  (SELECT A.JNS_BARANG FROM M_TRADER_KONVERSI_BB A, M_TRADER_KONVERSI_BJ B WHERE A.IDBJ=B.IDBJ 
						   AND A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=".$this->db->escape($KODE_TRADER)." 
						   AND (B.JNS_BARANG=".$this->db->escape($DETIL["JNS_BARANG"])." 
						   	OR A.JNS_BARANG=".$this->db->escape($DETIL["JNS_BARANG"])."))
						 ) ORDER BY TGL_DOK ASC";
				$result = $this->db->query($sql);
				if($result->num_rows() > 0){
					$JUMSALDO = 0;
					$jumlah = $TOTJUMBARANG;
					foreach ($result->result_array() as $rows){
						$LOGID = $rows['LOGID'];
						$JUMSALDO = $rows["SALDO"];
						$JUMSTOCKNSALDO = $JUMSTOCKNSALDO + $JUMSALDO;
						if ($JUMSTOCKNSALDO >= $TOTJUMBARANG){
							$stokahir = $JUMSTOCKNSALDO - $TOTJUMBARANG;
							if ($stokahir > 0){
								$SQL = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO=" . $stokahir . " WHERE LOGID='" . $LOGID . "'";
								$update_pemasukan = $this->db->query($SQL);
								$JUMLAH_BARANG_PAKAI = $jumlah;
							}else{
								$pakai = $JUMSTOCKNSALDO - $JUMSALDO;
								if($stokahir == 0) 
								{
									$pakai = $jumlah;
								}
								$this->db->where("LOGID", $LOGID);
								$update_pemasukan = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP'=>'1','SALDO'=>$stokahir));
								$JUMLAH_BARANG_PAKAI = $pakai;
							}
							if ($update_pemasukan){
								$LOG["NO_DOK_MASUK"] 		= $rows['NO_DOK'];
								$LOG["TGL_DOK_MASUK"] 		= $rows['TGL_DOK'];
								$LOG["JENIS_DOK_MASUK"] 	= $rows['JENIS_DOK'];
								$LOG["SERI_BARANG_MASUK"] 	= $rows['SERI_BARANG'];
								$LOG["LOGID_MASUK"] 		= $LOGID;
								$LOG["JUMLAH"] 				= $JUMLAH_BARANG_PAKAI;
								$LOG["METHOD"] 				= "FIFO";
								$insert_pengeluaran 		= $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
								break;
							}
						}else{
							if($result->num_rows() > 1){
								$this->db->where("LOGID", $LOGID);
								$update_pemasukan = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => '1', 'SALDO' => 0));
								$jumlah = ((float) $jumlah - $rows['SALDO']);
								$JUMLAH_BARANG_PAKAI = $JUMSTOCKNSALDO;
								if($JUMSALDO <= $JUMSTOCKNSALDO){
									$JUMLAH_BARANG_PAKAI = $JUMSALDO;
								}
								if ($update_pemasukan){
									$LOG["NO_DOK_MASUK"] 		= $rows['NO_DOK'];
									$LOG["TGL_DOK_MASUK"] 		= $rows['TGL_DOK'];
									$LOG["JENIS_DOK_MASUK"] 	= $rows['JENIS_DOK'];
									$LOG["SERI_BARANG_MASUK"] 	= $rows['SERI_BARANG'];
									$LOG["LOGID_MASUK"] 		= $LOGID;
									$LOG["JUMLAH"] 				= $JUMLAH_BARANG_PAKAI;
									$LOG["METHOD"] 				= "FIFO";
									$insert_pengeluaran = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
								}
							}
						}
					}
				}
				#end fifo
			}
		}elseif($DETIL["METHODE"]=="BB"){
			#methode pengambilan Bahan Baku
			$sqlBb = "SELECT NOMOR_DOK_ASAL, TANGGAL_DOK_ASAL, KODE_BARANG_BB, SERI_ASAL FROM t_".strtolower($KODE_DOKUMEN)."_bb 
					  WHERE NOMOR_AJU = ".$this->db->escape($NOMOR_AJU)." AND KODE_TRADER = " . $this->db->escape($KODE_TRADER) . " 
					  AND SERI = ".$this->db->escape($DETIL["SERI"])."";
			$bb = $this->db->query($sqlBb);
			$logid = "";
			foreach ($bb->result_array() as $rowBb) {
				$sqlIn = "SELECT LOGID, SALDO 
							FROM t_logbook_pemasukan 
						  WHERE NO_DOK = " . $this->db->escape($rowBb['NOMOR_DOK_ASAL']) . "
						  AND TGL_DOK = " . $this->db->escape($rowBb['TANGGAL_DOK_ASAL']) . "
						  AND KODE_BARANG = " . $this->db->escape($rowBb['KODE_BARANG_BB']) . " 
						  AND SERI_BARANG = ".$this->db->escape($rowBb["SERI_ASAL"])." 
						  AND KODE_TRADER = " . $this->db->escape($KODE_TRADER) . "";
				$in = $this->db->query($sqlIn);
				foreach ($in->result_array() as $rowIn) {
					$logid = $logid . $rowIn['LOGID'] . ",";
				}
			}
			$logid = rtrim($logid, ",");
			$sql = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, SALDO, SERI_BARANG 
					FROM t_logbook_pemasukan WHERE LOGID IN (" . $logid . ")
					AND KODE_TRADER = ".$this->db->escape($KODE_TRADER)." 
					AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '')";
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				$jumlah = $TOTJUMBARANG;
				$stokahir = $jumlah;
				foreach ($result->result_array() as $rows) {
					$LOGID = $rows['LOGID'];
					if ($jumlah < $rows['SALDO']) {
						$stokahir = ($rows['SALDO'] - (float) $jumlah);
						if ($stokahir > 0) {
							$SQL = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO = ".$stokahir." WHERE LOGID = ".$LOGID."";
							$update_pemasukan = $this->db->query($SQL);
						} else {
							$this->db->where("LOGID", $LOGID);
							$update_pemasukan = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => '1', 'SALDO' => $stokahir));
						}
						if ($update_pemasukan) {
							$LOG["NO_DOK_MASUK"] = $rows['NO_DOK'];
							$LOG["TGL_DOK_MASUK"] = $rows['TGL_DOK'];
							$LOG["JENIS_DOK_MASUK"] = $rows['JENIS_DOK'];
							$LOG["SERI_BARANG_MASUK"] = $rows['SERI_BARANG'];
							$LOG["LOGID_MASUK"] = $LOGID;
							$LOG["JUMLAH"] = $jumlah;
							$LOG["METHOD"] = "BB";
							$insert = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
							break;
						}
					} else {
						$stokahir = ($rows['SALDO'] - (float) $jumlah);
						$this->db->where("LOGID", $LOGID);
						$update_pemasukan = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => '1', 'SALDO' => 0));
						$jumlah = ($jumlah - $rows['SALDO']);

						if ($update_pemasukan) {
							$LOG["NO_DOK_MASUK"] = $rows['NO_DOK'];
							$LOG["TGL_DOK_MASUK"] = $rows['TGL_DOK'];
							$LOG["JENIS_DOK_MASUK"] = $rows['JENIS_DOK'];
							$LOG["SERI_BARANG_MASUK"] = $rows['SERI_BARANG'];
							$LOG["LOGID_MASUK"] = $LOGID;
							$LOG["JUMLAH"] = $rows['SALDO'];
							$LOG["METHOD"] = "BB";
							$insert = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
						}
					}
				}
			}
		}
		
		if ($exec){
			return true;
		}else{
			return false;
		}
    }
	
	function proses_realisasi_break($KODE_DOKUMEN, $NOMOR_AJU, $DETIL, $INOUT, $LOG) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $SQLB = "SELECT A.NOMOR_AJU,A.SERI,A.KODE_BARANG,A.JNS_BARANG,A.JUMLAH,A.KODE_SATUAN, 
			   f_barang(A.KODE_BARANG,A.JNS_BARANG,B.KODE_TRADER) URAIAN_BARANG, A.ID
			   FROM t_breakdown_pengeluaran_dok A, t_" . strtolower($KODE_DOKUMEN) . "_hdr B
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
				
				$QUERY = "SELECT KODE_GUDANG, KONDISI_BARANG,KODE_RAK, KODE_SUB_RAK, JUMLAH FROM t_breakdown_gudang_out WHERE 
						  HDRID = '".$VALBREAK["ID"]."' AND KODE_TRADER = '".$KODE_TRADER."' AND NOMOR_AJU = '".$VALBREAK["NOMOR_AJU"]."'
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
						$INOUT["KODE_BARANG"] = $VALBREAK["KODE_BARANG"];
						$INOUT["JNS_BARANG"] = $VALBREAK["JNS_BARANG"];
						$INOUT["KODE_GUDANG"] = $VALBREAKDTL["KODE_GUDANG"];
						$INOUT["KONDISI_BARANG"] = $VALBREAKDTL["KONDISI_BARANG"];
						$INOUT["KODE_RAK"] = $VALBREAKDTL["KODE_RAK"];
						$INOUT["KODE_SUB_RAK"] = $VALBREAKDTL["KODE_SUB_RAK"];
						$INOUT["JUMLAH"] = $JUMLAH_BARANG_GUDANG;
						$INOUT["CREATED_TIME"] = date('Y-m-d H:i:s', time() - 60 * 60 * 1);
						$INOUT["SERI_DOKUMEN"] = $DETIL["SERI"];
						$INOUT["BREAKDOWN_FLAG"] = "Y";
               			$this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
						
						$this->db->query("UPDATE M_TRADER_BARANG_GUDANG SET JUMLAH = (JUMLAH - ".(float)$JUMLAH_BARANG_GUDANG.") WHERE KODE_TRADER = '".$KODE_TRADER."' AND KODE_BARANG = '".$VALBREAK["KODE_BARANG"]."' AND JNS_BARANG = '".$VALBREAK["JNS_BARANG"]."' AND KODE_GUDANG = '".$VALBREAKDTL["KODE_GUDANG"]."' AND KONDISI_BARANG = '".$VALBREAKDTL["KONDISI_BARANG"]."' AND KODE_RAK = '".$VALBREAKDTL["KODE_RAK"]."' AND KODE_SUB_RAK = '".$VALBREAKDTL["KODE_SUB_RAK"]."'");
						
						$this->db->query("UPDATE M_TRADER_BARANG SET STOCK_AKHIR = (STOCK_AKHIR - ".(float)$JUMLAH_BARANG_GUDANG.") WHERE KODE_TRADER = '".$KODE_TRADER."' AND KODE_BARANG = '".$VALBREAK["KODE_BARANG"]."' AND JNS_BARANG = '".$VALBREAK["JNS_BARANG"]."'");
						
					}
					
				}
				
				$QUERYLOGBOOK = "SELECT LOGID, NO_DAFTAR, TGL_DAFTAR, JUMLAH, SATUAN, DOKUMEN, SERI_BARANG 
								 FROM t_breakdown_pengeluaran_dok WHERE BREAKDOWNID = '".$VALBREAK["ID"]."' 
								 AND KODE_TRADER = '".$KODE_TRADER."' AND NOMOR_AJU = '".$NOMOR_AJU."'";
				$rsLogBook = $func->main->get_result($QUERYLOGBOOK);
				if($rsLogBook){
					foreach($QUERYLOGBOOK->result_array() as $data){
						$SALDO = $func->main->get_uraian("SELECT SALDO FROM t_logbook_pemasukan WHERE LOGID = '".$data["LOGID"]."'","SALDO");
						$stokahir = (float)($SALDO - $data['JUMLAH']);
						if($stokahir > 0){
							$SQL = "UPDATE T_LOGBOOK_PEMASUKAN SET SALDO = ".$stokahir." WHERE LOGID='".$data["LOGID"]."'";
							$update_pemasukan = $this->db->query($SQL);
						}else{
							$this->db->where("LOGID", $data["LOGID"]);
							$update_pemasukan = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => '1', 'SALDO' => $stokahir));
						}
						if($update_pemasukan){
							$LOG["KODE_BARANG"] = $VALBREAK["KODE_BARANG"];
							$LOG["JNS_BARANG"] = $VALBREAK["JNS_BARANG"];
							$LOG["SERI_BARANG"] = $VALBREAK["SERI"];
							$LOG["NAMA_BARANG"] = $VALBREAK["URAIAN_BARANG"];
							$LOG["SATUAN"] = $VALBREAK["KODE_SATUAN"];
							$LOG["JUMLAH"] = $data["JUMLAH"];
							$LOG["NILAI_PABEAN"] = $DETIL["CIF"];
							$LOG["NO_DOK_MASUK"] = $data["NO_DAFTAR"];
							$LOG["TGL_DOK_MASUK"] = $data["TGL_DAFTAR"];
							$LOG["JENIS_DOK_MASUK"] = $data["DOKUMEN"];
							$LOG["SERI_BARANG_MASUK"] = $data["SERI_BARANG"];
							$LOG["LOGID_MASUK"] = $data["LOGID"];
							$LOG["NOMOR_AJU"] = $NOMOR_AJU;
							$LOG["METHOD"] = "BREAKDOWN";
							$LOG["CREATED_TIME"] = date('Y-m-d H:i:s');
							$exec =  $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
						}
					}
				}
            }
            if ($exec) return true;
        }
        return false;
    }
	
	function proses_realisasi_parsial($KODE_DOKUMEN, $NOMOR_AJU, $DETIL, $HEADER, $INOUT, $LOG) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $SQLP = "SELECT A.REALISASIID, B.KODE_BARANG, B.JNS_BARANG, B.JUMLAH, B.SATUAN, B.NILAI_BARANG, B.REALISASIDTLID, B.SERI
				 FROM t_temp_realisasi_parsial_hdr A, t_temp_realisasi_parsial_dtl B 
				 WHERE A.REALISASIID = B.HDR_REFF AND
				 A.NOMOR_AJU='" . $NOMOR_AJU . "' AND A.KODE_TRADER='" . $KODE_TRADER . "' AND A.NO_DOK_INTERNAL IS NULL
				 AND B.KODE_BARANG='" . $DETIL["KODE_BARANG"] . "' AND B.JNS_BARANG='" . $DETIL["JNS_BARANG"] . "'
				 AND B.SERI='".$DETIL["SERI"]."'"; 
        $rs = $this->db->query($SQLP);
        if ($rs->num_rows() > 0) {
            $VALPARSIAL = $rs->row();
            $REALISASIID = $VALPARSIAL->REALISASIID;
            $REALISASIDTLID = $VALPARSIAL->REALISASIDTLID;
            $jumlah1 = $VALPARSIAL->JUMLAH;
            $kdsatuan1 = $VALPARSIAL->SATUAN;
			
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
					WHERE REALISASIDTLID = ".$REALISASIDTLID." AND HDR_REFF = '".$REALISASIID."' AND SERI = '".$VALPARSIAL->SERI."' 
					AND KODE_TRADER = '".$KODE_TRADER."' AND NOMOR_AJU = '".$NOMOR_AJU."'";
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
					
					$GUDANG["KODE_TRADER"] 		= $KODE_TRADER;
					$GUDANG["NOMOR_AJU"] 		= $NOMOR_AJU;
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
					
					$this->db->set("JUMLAH", "JUMLAH - ".(float)$JML_BRG, FALSE);
					$this->db->where(array
										(
											"KODE_TRADER"		=> $KODE_TRADER,
											"KODE_BARANG"		=> $DETIL["KODE_BARANG"],
											"JNS_BARANG"		=> $DETIL["JNS_BARANG"],
											"KODE_GUDANG"		=> $row["KODE_GUDANG"],
											"KONDISI_BARANG"	=> $row["KONDISI_BARANG"],
											"KODE_RAK"			=> $row["KODE_RAK"],
											"KODE_SUB_RAK"		=> $row["KODE_SUB_RAK"]
										)
									);
					$this->db->update("M_TRADER_BARANG_GUDANG");
					
            		$INOUT["JUMLAH"] 			= $JML_BRG;
					$INOUT["PARSIAL_FLAG"] 		= "Y";
					$INOUT["KODE_GUDANG"] 		= $row["KODE_GUDANG"];
					$INOUT["KONDISI_BARANG"] 	= $row["KONDISI_BARANG"];
					$INOUT["KODE_RAK"] 			= $row["KODE_RAK"];
					$INOUT["KODE_SUB_RAK"] 		= $row["KODE_SUB_RAK"];
					$INOUT["SERI_DOKUMEN"] 		= $row["SERI"];
					$this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
				}
			}
			
			$SQL_LOG = "SELECT LOGID, NO_DAFTAR, TGL_DAFTAR, JUMLAH, SATUAN, DOKUMEN, SERI_BARANG 
						FROM t_temp_realisasi_parsial_dok WHERE REALISASIDTLID = '".$REALISASIDTLID."' 
						AND NOMOR_AJU = '".$NOMOR_AJU."' AND KODE_TRADER = '".$KODE_TRADER."'";
			$res = $func->main->get_result($SQL_LOG);
			if($res){
				foreach($SQL_LOG->result_array() as $DATA){
					if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
					$JUMLAH_BARANG = $DATA["JUMLAH"] * $jmlsatuanKecil;

					if ($kdsatuanKecil) {
						if (strtoupper($kdsatuan1) == strtoupper($kdsatuanKecil)) {
							$JUMLAH_BARANG = $DATA["JUMLAH"];
						} else {
							if (empty($jmlsatuanKecil)) $jmlsatuanKecil = 1;
							$JUMLAH_BARANG = $DATA["JUMLAH"] * $jmlsatuanKecil;
						}
					}else {
						$JUMLAH_BARANG = $DATA["JUMLAH"];
					}
					
					$SALDO = $func->main->get_uraian("SELECT SALDO FROM t_logbook_pemasukan WHERE LOGID = '".$DATA["LOGID"]."' AND KODE_TRADER = '".$KODE_TRADER."'","SALDO");
					$LOGKELUAR["NO_DOK"]			= $LOG["NO_DOK"];
					$LOGKELUAR["JENIS_DOK"]			= $LOG["JENIS_DOK"];
					$LOGKELUAR["NO_DOK"]			= $LOG["NO_DOK"];
					$LOGKELUAR["TGL_DOK"]			= $LOG["TGL_DOK"];
					$LOGKELUAR["TGL_MASUK"]			= $LOG["TGL_MASUK"];
					$LOGKELUAR["KODE_TRADER"]		= $KODE_TRADER;
					$LOGKELUAR["KODE_BARANG"]		= $DETIL["KODE_BARANG"];
					$LOGKELUAR["JNS_BARANG"]		= $DETIL["JNS_BARANG"];
					$LOGKELUAR["SERI_BARANG"]		= $DETIL["SERI"];
					$LOGKELUAR["NAMA_BARANG"]		= $DETIL["URAIAN_BARANG"];
					$LOGKELUAR["SATUAN"]			= $DETIL["KODE_SATUAN"];
					$LOGKELUAR["NO_DOK_MASUK"]		= $DATA["NO_DAFTAR"];
					$LOGKELUAR["JENIS_DOK_MASUK"]	= $DATA["DOKUMEN"];
					$LOGKELUAR["SERI_BARANG_MASUK"]	= $DATA["SERI_BARANG"];
					$LOGKELUAR["LOGID_MASUK"]		= $DATA["LOGID"];
					$LOGKELUAR["METHOD"]			= "DOK-IN";
					$LOGKELUAR["JUMLAH"]			= $JUMLAH_BARANG;
					$LOGKELUAR["TGL_DOK_MASUK"]		= $DATA['TGL_DAFTAR'];
					$LOGKELUAR["NILAI_PABEAN"]		= $VALPARSIAL->NILAI_BARANG?$VALPARSIAL->NILAI_BARANG:$DETIL["CIF"];
					$LOGKELUAR["NOMOR_AJU"]			= $NOMOR_AJU;
					if($SALDO==$JUMLAH_BARANG){
						$this->db->set("SALDO", "SALDO - ".(float)$JUMLAH_BARANG, FALSE);
						$this->db->set("FLAG_TUTUP", "1", FALSE);
						$this->db->where(array
											(
												"LOGID"			=> $DATA["LOGID"],
												"KODE_TRADER"	=> $KODE_TRADER
											)
										);
						$exec = $this->db->update("T_LOGBOOK_PEMASUKAN");
					}else{
						$this->db->set("SALDO", "SALDO - ".(float)$JUMLAH_BARANG, FALSE);
						$this->db->where(array
											(
												"LOGID"			=> $DATA["LOGID"],
												"KODE_TRADER"	=> $KODE_TRADER
											)
										);
						$exec = $this->db->update("T_LOGBOOK_PEMASUKAN");
					}
					
					#jika selesai update saldo pemasukan insert ke table logbook_pengeluaran
					if($exec){
						$DOK_LOG["KODE_TRADER"] 	= $KODE_TRADER;
						$DOK_LOG["NOMOR_AJU"] 		= $NOMOR_AJU;
						$DOK_LOG["REALISASIDTLID"] 	= $DTLID;
						$DOK_LOG["LOGID"] 			= $DATA["LOGID"];
						$DOK_LOG["NO_DAFTAR"] 		= $DATA["NO_DAFTAR"];
						$DOK_LOG["TGL_DAFTAR"] 		= $DATA["TGL_DAFTAR"];
						$DOK_LOG["JUMLAH"] 			= $DATA["JUMLAH"];
						$DOK_LOG["SATUAN"] 			= $DATA["SATUAN"];
						$DOK_LOG["DOKUMEN"] 		= $DATA["DOKUMEN"];
						$DOK_LOG["SERI_BARANG"] 	= $DATA["SERI_BARANG"];
						$this->db->insert("t_realisasi_parsial_dok",$DOK_LOG);
						
						$exec = $this->db->insert("t_logbook_pengeluaran",$LOGKELUAR);
					}
				}
			}
            if ($exec){
                $RET = $REALISASIID;
            }else{
                $RET = FALSE;
			}
        }else{
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
				NOMOR_AJU, SERI,JNS_BARANG, '" . $DOKUMEN . "' AS DOKUMEN, 'out' as dok, ID
				FROM t_breakdown_pengeluaran_dok
				WHERE NOMOR_AJU='" . $AJU . "' AND SERI='" . $SERI . "' AND KODE_TRADER = '".$KODETRADER."'";

        $JML = (float) $func->main->get_uraian("SELECT IFNULL(SUM(JUMLAH),0) SUMJUMLAH FROM t_breakdown_pengeluaran_dok
									           WHERE NOMOR_AJU='" . $AJU . "' AND SERI='" . $SERI . "' 
											   AND KODE_TRADER = '".$KODETRADER."'
										       GROUP BY NOMOR_AJU, SERI", "SUMJUMLAH");
											   
		// $HARGA_BARANG = (float) $func->main->get_uraian("SELECT IFNULL(SUM(HARGA_SATUAN),0) SUMJUMLAH FROM t_breakdown_pengeluaran
		// 											     WHERE NOMOR_AJU='" . $AJU . "' AND SERI='" . $SERI . "' 
		// 											     AND KODE_TRADER = '".$KODETRADER."'
		// 											     GROUP BY NOMOR_AJU, SERI", "SUMJUMLAH")*$JML;
		$post = 'save~'.$AJU.'~'.$SERI.'~'.$JUMLAH.'~'.$JML.'~'.$DOKUMEN;
        $process = array('Tambah' => array('GET2POP', site_url() . "/realisasi/breakdownout_prosesForm/save/$AJU/$SERI/$JUMLAH/$JML/$DOKUMEN", '0','icon-plus'),
            			 'View' => array('GET2POP', site_url() . "/realisasi/breakdownout_prosesForm/update/$AJU/$SERI/$JUMLAH/$JML/$DOKUMEN", '1','icon-pencil'),
            			 'Hapus' => array('DELETE', site_url() . '/realisasi/breakdownout_prosesForm/' . $JUMLAH, 'fbreakdownbrg', 'icon-remove red'));

        $this->newtable->keys(array('KODE BARANG', 'JNS_BARANG', 'NOMOR_AJU', 'SERI', 'DOKUMEN','dok','ID'));
        $this->newtable->hiddens(array('NOMOR_AJU', 'SERI', 'NOMOR_PROSES', 'JNS_BARANG', 'DOKUMEN','dok','ID'));

        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->action(site_url() . "/realisasi/page_break/$AJU/$SERI/$JUMLAH/$DOKUMEN/out");
		$this->newtable->detail(site_url()."/realisasi/breakdown_proses_detil_out");
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
        $this->newtable->rowcount(20);
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

    function detil_out($tipe="",$data=""){
		$func = get_instance();
		$func->load->model("main");
		$this->load->library('newtable');	
		$KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$arrdata = explode("|",$tipe);		
		$SQL = "SELECT REALISASIID, NOMOR_AJU, NO_DOK_INTERNAL 'NO.BUKTI PENGELUARAN', TGL_DOK_INTERNAL 'TGL.BUKTI PENGELUARAN', 
				NAMA_TRADER 'PEMASOK/PENGIRIM', TGL_REALISASI 'TANGGAL REALISASI' 
		        FROM t_realisasi_parsial_hdr WHERE NOMOR_AJU='".$arrdata[1]."' AND JENIS_DOK='".$arrdata[0]."'
				AND KODE_TRADER='".$KODE_TRADER."'";
		$this->newtable->search(array(array('NO_DOK_INTERNAL','NO. BUKTI PENGELUARAN&nbsp;'), 
								array('NAMA_PEMASOK', 'PEMASOK/PENGIRIM'),
								array('TGL_REALISASI', 'TANGGAL REALISASI', 'tag-tanggal')));												
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
		$this->newtable->action(site_url()."/realisasi/detil_out/ajax/".$data);
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
				FROM t_breakdown_gudang_out A 
				INNER JOIN t_breakdown_pengeluaran_dok B ON A.NOMOR_AJU = B.NOMOR_AJU AND A.HDRID = B.ID 
				AND A.KODE_TRADER = B.KODE_TRADER AND A.SERI = B.SERI
				WHERE B.KODE_TRADER = '".$KODE_TRADER."' AND B.NOMOR_AJU = '".$arr[2]."'
				AND B.SERI = '".$arr[3]."' AND B.KODE_BARANG = '".$KODE_BARANG."' AND B.JNS_BARANG = '".$JNS_BARANG."'";
									  
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
		$this->newtable->action(site_url()."/realisasi/breakdown_proses_detil_out/".$KEY);	
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

    function set_breakdown($act = "", $jumawal = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
		$kode_trader = $this->newsession->userdata("KODE_TRADER");
		$err = false;
        if ($act == "save" || $act == "update") {
            $JMLHEAD = $this->input->post("JMLHEAD");
            $DOKUMEN = $this->input->post("DOKUMEN");
            $DOK_PEMASUKAN = $this->input->post("DOKIN");
            foreach ($this->input->post('DATA') as $a => $b) {
                $DATA[$a] = $b;
				$DATA["KODE_TRADER"] = $kode_trader;
            }
            if ($act == "save") {
				$SQL = "SELECT KODE_BARANG FROM t_breakdown_pengeluaran_dok 
						WHERE NOMOR_AJU = '" . $DATA["NOMOR_AJU"] . "' 
						AND SERI = '" . $DATA["SERI"] . "' 
						AND KODE_BARANG = '" . $DATA["KODE_BARANG"] . "' 
						AND JNS_BARANG = '" . $DATA["JNS_BARANG"] . "' 
						AND KODE_TRADER = '" . $kode_trader . "'";
				$data = $this->db->query($SQL);
				if ($data->num_rows() > 0) {
					echo "MSG#ERR#Proses Gagal, Barang yang anda masukan sudah ada !";
				} else {
					$arrdetil = $this->input->post('DATABREAK');
					$arrkeys = array_keys($arrdetil);
					$countdtl = count($arrdetil[$arrkeys[0]]);
					$countDok = count($DOK_PEMASUKAN['NO_DOK']);
					#validasi dokumen pemasukan
					if ($countDok < 1) {
						echo "MSG#ERR#Silahkan memilih Dokumen Pemasukan terlebih dahulu !";
						die();
					}
					$jumOnGudang = 0;
					$arrTemp = array();
					for($i=0;$i<$countdtl;$i++){
						for($j=0;$j<count($arrkeys);$j++){
							$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
						}
						$addSqlRak = "";
						if ($DATADTL["KODE_RAK"] != "") {
							$addSqlRak = " AND KODE_RAK = '" . $DATADTL["KODE_RAK"] . "' ";
						}
						$addSqlSubRak = "";
						if ($DATADTL["KODE_SUB_RAK"] != "") {
							$addSqlSubRak = " AND KODE_SUB_RAK = '" . $DATADTL["KODE_SUB_RAK"] . "' ";
						}
						$QUERY = "SELECT B.KODE_BARANG, B.JUMLAH FROM M_TRADER_BARANG_GUDANG B 
								  LEFT JOIN M_TRADER_BARANG A ON A.KODE_TRADER = B.KODE_TRADER 
								  AND A.KODE_BARANG = B.KODE_BARANG
								  AND A.JNS_BARANG = B.JNS_BARANG WHERE A.KODE_TRADER = '" . $kode_trader . "' 
								  AND A.KODE_BARANG = '" . $DATA["KODE_BARANG"] . "' 
								  AND A.JNS_BARANG = '" . $DATA["JNS_BARANG"] . "' 
								  AND B.KODE_GUDANG = '" . $DATADTL["KODE_GUDANG"] . "' 
								  AND B.KONDISI_BARANG = '" . $DATADTL["KONDISI_BARANG"] . "' " . $addSqlRak . $addSqlSubRak;
						$rs = $this->db->query($QUERY);
						if($rs->num_rows() == 0){
							$err = true;
							$msg = "MSG#ERR#Kode Gudang, Kondisi Barang, Kode Rak dan Kode Subrak tidak dikenali, yaitu ".$DATADTL["KODE_GUDANG"].", ".$DATADTL["KONDISI_BARANG"].", ".$DATADTL["KODE_RAK"].", ".$DATADTL["KODE_SUB_RAK"].". ";
						}
						$jumOnGudang = $jumOnGudang + $DATADTL["JUMLAH"];
						if ($DATADTL["KODE_RAK"] != "" && $DATADTL["KODE_SUB_RAK"] != "") {
							$arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' .$DATADTL["KONDISI_BARANG"] . '|#|' . $DATADTL["KODE_RAK"] . '|#|' . $DATADTL["KODE_SUB_RAK"]][] = $DATADTL["JUMLAH"];
							$sumJumlah = array_sum($arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' .$DATADTL["KONDISI_BARANG"] . '|#|' . $DATADTL["KODE_RAK"] . '|#|' .$DATADTL["KODE_SUB_RAK"]]);
						} elseif ($DATADTL["KODE_RAK"] != "") {
							$arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' .$DATADTL["KONDISI_BARANG"] . '|#|' . $DATADTL["KODE_RAK"]][] = $DATADTL["JUMLAH"];
							$sumJumlah = array_sum($arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' . $DATADTL["KONDISI_BARANG"] . '|#|' . $DATADTL["KODE_RAK"]]);
						} else {
							$arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' .$DATADTL["KONDISI_BARANG"]][] = $DATADTL["JUMLAH"];
							$sumJumlah = array_sum($arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' .$DATADTL["KONDISI_BARANG"]]);
						}
						#validasi stock barang di gudang
						if (! $err) {
							$objBarang = $rs->row();
							$stockAkhir = $objBarang->JUMLAH;
							if ($sumJumlah > $stockAkhir) {
								$err = true;
								$msg = "MSG#ERR#Stock Barang Tidak mencukupi untuk Kode Barang : " . $DATA["KODE_BARANG"] . ", dengan Kode Gudang " . $DATADTL["KODE_GUDANG"]. ", Kondisi " . $DATADTL["KONDISI_BARANG"] . ", Rak " . $DATADTL["KODE_RAK"] . ", Sub Rak " . $DATADTL["KODE_SUB_RAK"] . ", Stock yang tersisa " . $stockAkhir . ". ";
							}
						}
					}
					#validasi total jumlah barang
					$jumOnDok =  array_sum($DOK_PEMASUKAN['JUMLAH']);
					if ($jumOnGudang > $jumOnDok) {
						$errMsg = "Total Jumlah Pada Dokumen Pemasukan Kurang Dari Total Jumlah yang Akan Diambil dari Gudang.";
						if ($err) {
							$msg = $msg . $errMsg;
						} else {
							$msg = "MSG#ERR#" . $errMsg;
						}
						$err = true;
					} elseif ($jumOnGudang < $jumOnDok) {
						$errMsg = "Total Jumlah Pada Dokumen Pemasukan Lebih Dari Total Jumlah yang Akan Diambil dari Gudang.";
						if ($err) {
							$msg = $msg . $errMsg;
						} else {
							$msg = "MSG#ERR#" . $errMsg;
						}
						$err = true;
					}
					if($err){
						echo $msg;die();
					}else{
						#insert breakdown header
						$insert = $this->db->insert('t_breakdown_pengeluaran_dok', $DATA);
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
								// print_r($DATABREAK); die();
								$this->db->insert('t_breakdown_gudang_out', $DATABREAK);
							}
							$keysDokumen = array_keys($DOK_PEMASUKAN);
							for ($x=0; $x < $countDok; $x++) { 
								for ($y=0; $y < count($keysDokumen); $y++) { 
									$postDokumen[$keysDokumen[$y]] = $DOK_PEMASUKAN[$keysDokumen[$y]][$x];
								}
								$arrDokumen['KODE_TRADER'] = $kode_trader;
								$arrDokumen['BREAKDOWNID'] = $ID;
								$arrDokumen['LOGID'] = $postDokumen['LOGID'];
								$arrDokumen['NO_DAFTAR'] = $postDokumen['NO_DOK'];
								$arrDokumen['TGL_DAFTAR'] = $postDokumen['TGL_DOK'];
								$arrDokumen['JUMLAH'] = $postDokumen['JUMLAH'];
								$arrDokumen['SATUAN'] = $postDokumen['SATUAN'];
								$arrDokumen['DOKUMEN'] = $postDokumen['DOKUMEN'];
								$arrDokumen['SERI_BARANG'] = $postDokumen['SERI_BARANG'];
								$arrDokumen['NOMOR_AJU'] = $DATA['NOMOR_AJU'];
								$this->db->insert('t_breakdown_pengeluaran_dok', $arrDokumen);
							}
							#update jumlah pada table t_breakdown_pengeluaran
							$this->db->where(array( "NOMOR_AJU" => $DATA["NOMOR_AJU"],
													"SERI" => $DATA["SERI"],
													"KODE_BARANG" => $DATA["KODE_BARANG"],
													"JNS_BARANG" => $DATA["JNS_BARANG"],
													"KODE_TRADER" => $kode_trader));
							$this->db->update('t_breakdown_pengeluaran_dok', array("JUMLAH" => $JML));
							#update flag breakdown pada table dok pabean detail
							$this->db->where(array('NOMOR_AJU' => $DATA["NOMOR_AJU"], 
													'SERI' => $DATA["SERI"], 
													'KODE_TRADER' => $kode_trader));
							$this->db->update('t_' . $DOKUMEN . '_dtl', array("BREAKDOWN_FLAG" => "Y"));
							#update flag breakdown pada table dok pabean header
							$this->db->where(array('NOMOR_AJU' => $DATA["NOMOR_AJU"], 
													'KODE_TRADER' => $kode_trader));
							$this->db->update('t_' . $DOKUMEN . '_hdr', array("BREAKDOWN_FLAG" => "Y"));
	
							$func->main->activity_log('ADD BREAKDOWN DETIL DOKUMEN ' . strtoupper($DOKUMEN), 'CAR=' . $DATA["NOMOR_AJU"] . ',SERI=' . $DATA["SERI"]);
							echo "MSG#OK#Simpan Data Berhasil#" . site_url() . "/realisasi/show_detilbarang_out/" . $DATA["NOMOR_AJU"] . "/" . $DATA["SERI"] . "/" . $JMLHEAD . "/" . $DOKUMEN;
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
                $BREAKDOWNID = $arrchk[6];
                #hapus data header t_breakdown_pengeluaran
                $this->db->where(array("NOMOR_AJU" => $NOMOR_AJU, "SERI" => $SERI, 
                						"KODE_BARANG" => $KODE_BARANG, "JNS_BARANG" => $JNS_BARANG,
                						"KODE_TRADER" => $kode_trader));
                $this->db->delete('t_breakdown_pengeluaran_dok');
                #hapus data detail t_breakdown_gudang_out
                $this->db->where(array("NOMOR_AJU" => $NOMOR_AJU, "SERI" => $SERI, 
                						"KODE_BARANG" => $KODE_BARANG, "JNS_BARANG" => $JNS_BARANG,
                						"KODE_TRADER" => $kode_trader));
                $exec = $this->db->delete('t_breakdown_gudang_out');
                #hapus data dokumen pemasukan t_breakdown_pengeluaran_dok
                $this->db->where(array("KODE_TRADER" => $kode_trader, "BREAKDOWNID" => $BREAKDOWNID));
                $exec = $this->db->delete('t_breakdown_pengeluaran_dok');
            }
            $JML = (float) $func->main->get_uraian("SELECT IFNULL(SUM(JUMLAH),0) SUMJUMLAH FROM t_breakdown_pemasukan
									        		WHERE NOMOR_AJU='" . $NOMOR_AJU . "' AND SERI='" . $SERI . "' 
									        		AND KODE_TRADER = '" . $kode_trader . "'
									        		GROUP BY NOMOR_AJU, SERI", "SUMJUMLAH");
            if ($exec) {
                if ($JML == 0) {
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, 'SERI' => $SERI, "KODE_TRADER" => $kode_trader));
                    $this->db->update('t_' . $DOKUMEN . '_dtl', array("BREAKDOWN_FLAG" => ""));
                    $this->db->where(array('NOMOR_AJU' => $NOMOR_AJU, "KODE_TRADER" => $kode_trader));
                    $this->db->update('t_' . $DOKUMEN . '_hdr', array("BREAKDOWN_FLAG" => "N"));
                    $JML = $jumawal;
                }
                $func->main->activity_log('DELETE BREAKDOWN DETIL DOKUMEN ' . strtoupper($DOKUMEN), 'CAR=' . $NOMOR_AJU . ',SERI=' . $SERI);
                echo "MSG#OK#Hapus Data Berhasil#" . site_url() . "/realisasi/show_detilbarang_out/" . $NOMOR_AJU . "/" . $SERI . "/" . $JML . "/" . $DOKUMEN . "/DEL";
            } else {
                echo "MSG#ERR#Hapus data Gagal";
            }
        }
    }
	
	function parsial() {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
		$NOMOR_AJU = $this->input->post("NOMOR_AJU");
		$DOKUMEN = $this->input->post("DOKUMEN");
		$SERI = $this->input->post("SERI");
        $DOK_PEMASUKAN = $this->input->post("DOKIN");
		foreach($this->input->post("PARSIAL") as $a=>$b){
			$DATA[$a] = $b;
		}
		$arrdetil = $this->input->post('DATAPARSIAL');
		$arrkeys = array_keys($arrdetil);
		$countdtl = count($arrdetil[$arrkeys[0]]);
		$countDok = count($DOK_PEMASUKAN['NO_DOK']);
		# jika jumlah parsial 0
		if ($DATA['JUMLAH'] == 0 && count($DOK_PEMASUKAN['NO_DOK']) == 0) {
			$countDok = 1;
		}
		#validasi dokumen pemasukan
		if ($countDok < 1) {
			echo "MSG#ERR#Silahkan memilih Dokumen Pemasukan terlebih dahulu !";die();
		}else{
			# jika jumlah parsial 0
			if ($DATA['JUMLAH'] == 0 && count($DOK_PEMASUKAN['NO_DOK']) == 0) {
				$countDok = 0;
			}
			$jumOnGudang = 0;
			$arrTemp = array();
			for($i=0;$i<$countdtl;$i++){
				for($j=0;$j<count($arrkeys);$j++){
					$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
					if(!$DATADTL["JUMLAH"]) $DATADTL["JUMLAH"] = $DATA["JUMLAH"];
				}
				$QUERY = "SELECT B.KODE_BARANG, B.JUMLAH FROM M_TRADER_BARANG_GUDANG B 
						  LEFT JOIN M_TRADER_BARANG A 
						  ON A.KODE_TRADER = B.KODE_TRADER 
						  AND A.KODE_BARANG = B.KODE_BARANG
						  AND A.JNS_BARANG = B.JNS_BARANG WHERE A.KODE_TRADER = '" . $KODE_TRADER . "' 
						  AND A.KODE_BARANG = '" . $DATA["KODE_BARANG"] . "' 
						  AND A.JNS_BARANG = '" . $DATA["JNS_BARANG"] . "' 
						  AND B.KODE_GUDANG = '" . $DATADTL["KODE_GUDANG"] . "' 
						  AND B.KONDISI_BARANG = '" . $DATADTL["KONDISI_BARANG"] . "' 
						  AND KODE_RAK = '" . $DATADTL["KODE_RAK"] . "' 
						  AND KODE_SUB_RAK = '" . $DATADTL["KODE_SUB_RAK"] . "'";
				$rs = $this->db->query($QUERY);
				if($rs->num_rows() == 0){
					$err = true;
					$msg = "MSG#ERR#Kode Gudang, Kondisi Barang, Kode Rak dan Kode Subrak tidak dikenali, yaitu ".$DATADTL["KODE_GUDANG"].", ".$DATADTL["KONDISI_BARANG"].", ".$DATADTL["KODE_RAK"].", ".$DATADTL["KODE_SUB_RAK"].". ";
				}
				$jumOnGudang = $jumOnGudang + $DATADTL["JUMLAH"];
				
				$arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' .$DATADTL["KONDISI_BARANG"] . '|#|' . $DATADTL["KODE_RAK"] . '|#|' . $DATADTL["KODE_SUB_RAK"]][] = $DATADTL["JUMLAH"];
				$sumJumlah = array_sum($arrTemp[$DATA["KODE_BARANG"] . '|#|' . $DATA["JNS_BARANG"] . '|#|' . $DATADTL["KODE_GUDANG"] . '|#|' .$DATADTL["KONDISI_BARANG"] . '|#|' . $DATADTL["KODE_RAK"] . '|#|' .$DATADTL["KODE_SUB_RAK"]]);
				
				#validasi stock barang di gudang
				if (! $err) {
					$objBarang = $rs->row();
					$stockAkhir = $objBarang->JUMLAH;
					if ($sumJumlah > $stockAkhir) {
						$err = true;
						$msg = "MSG#ERR#Stock Barang Tidak mencukupi untuk Kode Barang : " . $DATA["KODE_BARANG"] . ", dengan Kode Gudang " . $DATADTL["KODE_GUDANG"]. ", Kondisi " . $DATADTL["KONDISI_BARANG"] . ", Rak " . $DATADTL["KODE_RAK"] . ", Sub Rak " . $DATADTL["KODE_SUB_RAK"] . ", Stock yang tersisa " . $stockAkhir . ". ";
					}
				}
			}
			#validasi total jumlah barang
			$jumOnDok =  array_sum($DOK_PEMASUKAN['JUMLAH']);
			if ($jumOnGudang > $jumOnDok) {
				$errMsg = "Total Jumlah Pada Dokumen Pemasukan Kurang Dari Total Jumlah yang Akan Diambil dari Gudang.";
				if ($err) {
					$msg = $msg . $errMsg;
				} else {
					$msg = "MSG#ERR#" . $errMsg;
				}
				$err = true;
			} elseif ($jumOnGudang < $jumOnDok) {
				$errMsg = "Total Jumlah Pada Dokumen Pemasukan Lebih Dari Total Jumlah yang Akan Diambil dari Gudang.";
				if ($err) {
					$msg = $msg . $errMsg;
				} else {
					$msg = "MSG#ERR#" . $errMsg;
				}
				$err = true;
			}
			if($err){
				echo $msg;die();
			}else{
				$RELID = $this->newsession->userdata('USER_ID') . date('ymdHis');
                $HEADER["REALISASIID"] 	= $RELID;
                $HEADER["KODE_TRADER"] 	= $KODE_TRADER;
                $HEADER["NOMOR_AJU"] 	= $NOMOR_AJU;
                $HEADER["JENIS_DOK"] 	= strtoupper($DOKUMEN);
				$insert = $this->db->insert('t_temp_realisasi_parsial_hdr', $HEADER);
				if ($insert) {
					$BARANG["HDR_REFF"] 	= $HEADER["REALISASIID"];
					$BARANG["KODE_BARANG"] 	= $DATA["KODE_BARANG"];
					$BARANG["JNS_BARANG"] 	= $DATA["JNS_BARANG"];
					$BARANG["JUMLAH"] 		= $DATA["JUMLAH"];
					$BARANG["SATUAN"] 		= $DATA["KODE_SATUAN"];
					$BARANG["SERI"] 		= $SERI;
					$BARANG["NILAI_BARANG"] = $DATA["NILAI_BARANG"];
					$exec = $this->db->insert('t_temp_realisasi_parsial_dtl', $BARANG);
					$ID = $this->db->insert_id();
					if($exec){
						for($i=0;$i<$countdtl;$i++){
							for($j=0;$j<count($arrkeys);$j++){
								$DATADTL[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
								if(!$DATADTL["JUMLAH"]) $DATADTL["JUMLAH"] = $DATA["JUMLAH"];
							}
							// $DATAPARSIALGUDANG["KODE_TRADER"] = $KODE_TRADER;
							// $DATAPARSIALGUDANG["NOMOR_AJU"] = $NOMOR_AJU;
							$DATAPARSIALGUDANG["REALISASIDTLID"] = $ID;
							$DATAPARSIALGUDANG["HDR_REFF"] = $HEADER["REALISASIID"];
							$DATAPARSIALGUDANG["KODE_BARANG"] = $DATA["KODE_BARANG"];
							$DATAPARSIALGUDANG["JNS_BARANG"] = $DATA["JNS_BARANG"];
							$DATAPARSIALGUDANG["KODE_GUDANG"] = $DATADTL["KODE_GUDANG"];
							$DATAPARSIALGUDANG["KONDISI_BARANG"] = $DATADTL["KONDISI_BARANG"];
							$DATAPARSIALGUDANG["KODE_RAK"] = $DATADTL["KODE_RAK"];
							$DATAPARSIALGUDANG["KODE_SUB_RAK"] = $DATADTL["KODE_SUB_RAK"];
							$DATAPARSIALGUDANG["JUMLAH"] = $DATADTL["JUMLAH"];
							$DATAPARSIALGUDANG["SERI"] = $SERI;
							$this->db->insert('t_temp_realisasi_parsial_gudang', $DATAPARSIALGUDANG);
						}
						$keysDokumen = array_keys($DOK_PEMASUKAN);
						for ($x=0; $x < $countDok; $x++) { 
							for ($y=0; $y < count($keysDokumen); $y++) { 
								$postDokumen[$keysDokumen[$y]] = $DOK_PEMASUKAN[$keysDokumen[$y]][$x];
							}
							$arrDokumen['KODE_TRADER'] = $KODE_TRADER;
							$arrDokumen['REALISASIDTLID'] = $ID;
							$arrDokumen['LOGID'] = $postDokumen['LOGID'];
							$arrDokumen['NO_DAFTAR'] = $postDokumen['NO_DOK'];
							$arrDokumen['TGL_DAFTAR'] = $postDokumen['TGL_DOK'];
							$arrDokumen['JUMLAH'] = $postDokumen['JUMLAH'];
							$arrDokumen['SATUAN'] = $postDokumen['SATUAN'];
							$arrDokumen['DOKUMEN'] = $postDokumen['DOKUMEN'];
							$arrDokumen['SERI_BARANG'] = $postDokumen['SERI_BARANG'];
							$arrDokumen['NOMOR_AJU'] = $NOMOR_AJU;
							$this->db->insert('t_temp_realisasi_parsial_dok', $arrDokumen);
						}
						if ($exec) {
							$this->db->where(array('KODE_TRADER'=>$KODE_TRADER,'NOMOR_AJU' => $NOMOR_AJU, 'SERI' => $SERI));
							$exec = $this->db->update('t_' . $DOKUMEN . '_dtl', array("PARSIAL_FLAG" => "Y"));
							$this->db->where(array('KODE_TRADER'=>$KODE_TRADER,'NOMOR_AJU' => $NOMOR_AJU));
							$exec = $this->db->update('t_' . $DOKUMEN . '_hdr', array("PARSIAL_FLAG" => "Y"));
						}
						$msg = "MSG#OK#Data Berhasil Disimpan";
					}else{
						$msg = "MSG#ERR#Insert Data Gagal";
						$this->db->where(array
												(
													"KODE_TRADER" => $KODE_TRADER,
													"REALISASIID" => $HEADER["REALISASI"]
												)
										);
					}
				}else{
					$msg = "MSG#ERR#Insert Data Gagal";
				}
				echo $msg;
			}
		}
    }
}
?>