<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Produksi_act extends CI_Model
{
	function daftar_produksi($tipe = "") {
        $func = get_instance();
        $this->load->library('newtable');
		$kode_trader = $this->newsession->userdata('KODE_TRADER');
		$kode_role = $this->newsession->userdata('KODE_ROLE');
        if ($tipe == "bahan_baku") {
            $title = "Barang yang Diproses [input]";
			if(in_array($kode_role,array("3","5"))){
				$FIELD = " ,f_trader(A.KODE_TRADER) AS 'NAMA ANGGOTA' ";
				$WHERE .= " AND KODE_TRADER = '".$this->newsession->userdata("ANGGOTA_PLB")."'";
			}else{
				$FIELD = " ";
				$WHERE = "  AND A.KODE_TRADER='" . $kode_trader . "'";
			}
            $SQL = "SELECT A.JENIS_BARANG AS 'JENIS BARANG', A.NOMOR_PROSES AS 'NOMOR TRANSAKSI', A.KODE_TRADER, 
					DATE_FORMAT(A.TANGGAL, '%d %M %Y') AS 'TANGGAL MASUK', A.WAKTU AS 'WAKTU MASUK', 
					(SELECT COUNT(B.NOMOR_PROSES) FROM M_TRADER_PROSES_DTL B 
					WHERE B.NOMOR_PROSES=A.NOMOR_PROSES AND B.KODE_TRADER=A.KODE_TRADER) 
					AS 'JUMLAH ITEM BARANG',KETERANGAN, if(STATUS=1,'DISETUJUI','DRAFT') STATUS, STATUS AS IDSTATUS ".$FIELD."
					FROM M_TRADER_PROSES A 
					WHERE A.JENIS_BARANG='masuk'".$WHERE;
            if (!in_array($kode_role,array("3","5"))) {#ROLE BUKAN BC DAN BUKAN ADMIN PNYELENGGARA
                $prosesnya = array(
									'Add' 						=> array('GET2', site_url() . "/produksi/prosesproduksi/bahan_baku", '0', 'icon-plus'),
									'Edit' 						=> array('EDITJS', site_url() . "/produksi/prosesproduksi/bahan_baku", '3', 'icon-edit'),
									'Delete' 					=> array('DELETE', site_url() . '/produksi/set_produksi/' . $tipe, 'produksi', 'red icon-trash'),
									'Preview' 					=> array('EDITJS', site_url() . "/produksi/add/bhn_baku_view", '1', 'icon-eye-open'),
									'Approve' 					=> array('PROCESS', site_url() . '/produksi/set_produksi/' . $tipe, 'produksi', 'green icon-check'),
									'Print XLS(Per Periode)' 	=> array('DIALOG-400;250', site_url() . "/produksi/popupcetak/Masuk", '0', 'green icon-print')
								);
            } elseif (in_array($kode_role,array("3","5"))) {#ROLE BC DAN ADMIN PNYELENGGARA
                $prosesnya = array(
									'Print XLS' => array('DIALOG-400;250', site_url() . "/produksi/popupcetak/Masuk", '0', 'green icon-print'),
									'Preview' 	=> array('EDITJS', site_url() . "/produksi/add/bhn_baku_view", '1', 'icon-eye-open')
								  );
            }
            $this->newtable->hiddens(array("KODE_TRADER", "JENIS BARANG", "IDSTATUS"));
            $this->newtable->keys(array("NOMOR TRANSAKSI", "KODE_TRADER", "JUMLAH ITEM BARANG", "IDSTATUS"));
            $this->newtable->search(array(
											array('A.NOMOR_PROSES', 'NOMOR TRANSAKSI&nbsp;'),
                							array('A.TANGGAL', 'TANGGAL MASUK', 'tag-tanggal'),
                							array('A.STATUS', 'STATUS', 'tag-select', array("0" => "DRAFT", "1" => "DISETUJUI")
										)));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->action(site_url() . "/produksi/daftar/" . $tipe);
            $this->newtable->detail(site_url() . "/produksi/priviewproduksi/bhn_baku_view");
            $this->newtable->detail_tipe("detil_priview_bottom");
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby('A.TANGGAL DESC, A.WAKTU');
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("f" . $tipe);
            $this->newtable->set_divid("div" . $tipe);
            $this->newtable->rowcount(25);
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel .= $this->newtable->generate($SQL);
            $arrdata = array(
								"title" => $title,
								"judul" => $judul,
								"tabel" => $tabel,
								"jenis" => $jenis,
								"tipe" => $tipe
							);
            if ($this->input->post("ajax")){
                return $tabel;
			}else{
                return $arrdata;
			}
        }elseif ($tipe == "hasil_produksi") {
			if(in_array($kode_role,array("3","5"))){
				$FIELD = " ,f_trader(A.KODE_TRADER) AS 'NAMA ANGGOTA' ";
				$WHERE .= " AND KODE_TRADER = '".$this->newsession->userdata("ANGGOTA_PLB")."'";
			}else{
				$FIELD = " ";
				$WHERE = "  AND A.KODE_TRADER='" . $kode_trader . "'";
			}
            $title = "Hasil Pengerjaan [output]";
            $SQL = "SELECT A.JENIS_BARANG AS 'JENIS BARANG', A.NOMOR_PROSES AS 'NOMOR TRANSAKSI',A.KODE_TRADER, 
					DATE_FORMAT(A.TANGGAL, '%d %M %Y') AS 'TANGGAL KELUAR', A.WAKTU AS 'WAKTU KELUAR', 
					(SELECT COUNT(B.NOMOR_PROSES) FROM M_TRADER_PROSES_DTL B 
					WHERE B.NOMOR_PROSES=A.NOMOR_PROSES AND B.KODE_TRADER=A.KODE_TRADER) 
					AS 'JUMLAH ITEM BARANG',KETERANGAN, if(STATUS=1,'DISETUJUI','DRAFT') STATUS, STATUS AS IDSTATUS ".$FIELD."
					FROM M_TRADER_PROSES A 
					WHERE A.JENIS_BARANG='keluar' ".$WHERE;
            if (!in_array($kode_role,array("3","5"))) {#ROLE BUKAN BC
                $prosesnya = array('Add' => array('GET2', site_url() . "/produksi/prosesproduksi/hasil_produksi", '0', 'icon-plus'),
                    'Edit' => array('EDITJS', site_url() . "/produksi/prosesproduksi/hasil_produksi", '3', 'icon-edit'),
                    'Delete' => array('DELETE', site_url() . '/produksi/set_produksi/' . $tipe, 'produksi', 'red icon-trash'),
					'Preview' => array('EDITJS', site_url() . "/produksi/add/hsl_prod_view", '1', 'icon-eye-open'),
                    'Approve' => array('PROCESS', site_url() . '/produksi/set_produksi/' . $tipe, 'produksi', 'green icon-check'),
                    'Print XLS(Per Periode)' => array('DIALOG-400;250', site_url() . "/produksi/popupcetak/Keluar", '0', 'green icon-print'));
            }  elseif (in_array($kode_role,array("3","5"))) {#ROLE BC
                $prosesnya = array(
									'Print XLS' => array('DIALOG-400;250', site_url() . "/produksi/popupcetak/Keluar", '0', 'green icon-print'),
									'Preview' => array('GET2', site_url() . "/produksi/add/hsl_prod_view", '1')
								);
            }

            $this->newtable->hiddens(array("KODE_TRADER", "JENIS BARANG", "IDSTATUS"));
            $this->newtable->keys(array("NOMOR TRANSAKSI", "KODE_TRADER", "JUMLAH ITEM BARANG", "IDSTATUS"));
            $this->newtable->search(array(array('A.NOMOR_PROSES', 'NOMOR TRANSAKSI&nbsp;'),
                array('A.TANGGAL', 'TANGGAL KELUAR', 'tag-tanggal'),
                array('A.STATUS', 'STATUS', 'tag-select', array("0" => "DRAFT", "1" => "DISETUJUI"))
            ));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->action(site_url() . "/produksi/daftar/" . $tipe);
            $this->newtable->detail(site_url() . "/produksi/priviewproduksi/hsl_prod_view");
            $this->newtable->detail_tipe("detil_priview_bottom");
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby("A.TANGGAL DESC,A.WAKTU");
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("f" . $tipe);
            $this->newtable->set_divid("div" . $tipe);
            $this->newtable->rowcount(25);
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel .= $this->newtable->generate($SQL);
            $arrdata = array("title" => $title,
                "judul" => $judul,
                "tabel" => $tabel,
                "jenis" => $jenis,
                "tipe" => $tipe);
            if ($this->input->post("ajax"))
                return $tabel;
            else
                return $arrdata;
        }elseif ($tipe == "hasil_sisa") {
			if(in_array($kode_role,array("3","5"))){
				$FIELD = " ,f_trader(A.KODE_TRADER) AS 'NAMA ANGGOTA' ";
				$WHERE .= " AND KODE_TRADER = '".$this->newsession->userdata("ANGGOTA_PLB")."'";
			}else{
				$FIELD = " ";
				$WHERE = "  AND A.KODE_TRADER='" . $kode_trader . "'";
			}
            $title = "Sisa Pengerjaan/Scrap";
            $SQL = "SELECT A.JENIS_BARANG AS 'JENIS BARANG', A.NOMOR_PROSES AS 'NOMOR TRANSAKSI',A.KODE_TRADER, 
					DATE_FORMAT(A.TANGGAL, '%d %M %Y') AS 'TANGGAL', A.WAKTU AS 'WAKTU', 
					(SELECT COUNT(B.NOMOR_PROSES) FROM M_TRADER_PROSES_DTL B 
					WHERE B.NOMOR_PROSES=A.NOMOR_PROSES AND B.KODE_TRADER=A.KODE_TRADER)
				    AS 'JUMLAH ITEM BARANG',KETERANGAN, if(STATUS=1,'DISETUJUI','DRAFT') STATUS, STATUS AS IDSTATUS ".$FIELD."
					FROM M_TRADER_PROSES A 
					WHERE A.JENIS_BARANG='sisa' ".$WHERE;
            if (!in_array($kode_role,array("3","5"))) {#ROLE BUKAN BC
                $prosesnya = array('Add' => array('GET2', site_url() . "/produksi/prosesproduksi/hasil_sisa", '0', 'icon-plus'),
                    'Edit' => array('EDITJS', site_url() . "/produksi/prosesproduksi/hasil_sisa", '3', 'icon-edit'),
                    'Delete' => array('DELETE', site_url() . '/produksi/set_produksi/' . $tipe, 'produksi', 'red icon-trash'),
					'Preview' => array('EDITJS', site_url() . "/produksi/add/hsl_sisa_view", '1', 'icon-eye-open'),
                    'Approve' => array('PROCESS', site_url() . '/produksi/set_produksi/' . $tipe, 'produksi', 'green icon-check'),
                    'Print XLS(Per Periode)' => array('DIALOG-400;250', site_url() . "/produksi/popupcetak/Sisa", '0', 'green icon-print'));
            }  elseif (in_array($kode_role,array("3","5"))) {#ROLE BC
                $prosesnya = array(
									'Print XLS' => array('DIALOG-400;250', site_url() . "/produksi/popupcetak/Sisa", '0', 'green icon-print'),
									'Preview' => array('GET2', site_url() . "/produksi/add/hsl_sisa_view", '1')
								);
            }
            $this->newtable->hiddens(array("KODE_TRADER", "JENIS BARANG", "IDSTATUS"));
            $this->newtable->keys(array("NOMOR TRANSAKSI", "KODE_TRADER", "JUMLAH ITEM BARANG", "IDSTATUS"));
            $this->newtable->search(array(array('A.NOMOR_PROSES', 'NOMOR TRANSAKSI&nbsp;'),
                array('A.TANGGAL', 'TANGGAL', 'tag-tanggal'),
                array('A.STATUS', 'STATUS', 'tag-select', array("0" => "DRAFT", "1" => "DISETUJUI"))
            ));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->action(site_url() . "/produksi/daftar/" . $tipe);
            $this->newtable->detail(site_url() . "/produksi/priviewproduksi/hsl_sisa_view");
            $this->newtable->detail_tipe("detil_priview_bottom");
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby("A.TANGGAL DESC,A.WAKTU");
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("f" . $tipe);
            $this->newtable->set_divid("div" . $tipe);
            $this->newtable->rowcount(25);
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel .= $this->newtable->generate($SQL);
            $arrdata = array("title" => $title,
                "judul" => $judul,
                "tabel" => $tabel,
                "jenis" => $jenis,
                "tipe" => $tipe);
            if ($this->input->post("ajax"))
                return $tabel;
            else
                return $arrdata;
        }
    }
	
	function getGudangBarang(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		
		$SQL = "SELECT KODE_GUDANG, KONDISI_BARANG, IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA') AS NAMA_GUDANG 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' ORDER BY KODE_GUDANG DESC";
		//echo $SQL;
		//die();
		$GUDANG = $func->main->get_combobox($SQL,"KODE_GUDANG","NAMA_GUDANG",FALSE);
		$KONDISI = $func->main->get_combobox($SQL,"KONDISI_BARANG","KONDISI_BARANG",FALSE);
		return form_dropdown('KODE_GUDANG', array_merge(array(""=>"-- Pilih --"),$GUDANG), $sess['KODE_GUDANG'], 'id="KODE_GUDANG" class="text" wajib="yes" onChange="getRak()" style="width:62%" ')."#".form_dropdown('KONDISI_BARANG', array_merge(array(""=>"-- Pilih --"),$KONDISI), $sess['KONDISI_BARANG'], 'id="KONDISI_BARANG" class="text" wajib="yes" style="width:62%" ');
	}
	
	function getRak(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_GUDANG = $this->input->post("kode_gudang");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		
		$SQL = "SELECT KODE_RAK, IFNULL(f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER),'NULL') AS NAMA_RAK 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' AND KODE_GUDANG='".$KODE_GUDANG."' ORDER BY KODE_RAK DESC";				
		$RAK = $func->main->get_combobox($SQL,"KODE_RAK","NAMA_RAK",FALSE);
		return form_dropdown('KODE_RAK', array_merge(array(""=>"-- Pilih --"),$RAK), $sess['KODE_RAK'], 'id="KODE_RAK" class="mtext" wajib="yes" onChange="getSubRak()"')."#"."";
	}
	function getSubRak(){
		$func = &get_instance();
		$func->load->model("main");
		$KODE_BARANG = $this->input->post("kode_barang");
		$JNS_BARANG = $this->input->post("jns_barang");
		$KODE_GUDANG = $this->input->post("kode_gudang");
		$KODE_RAK = $this->input->post("kode_rak");
		$KODE_TRADER = $this->newsession->userdata("KODE_TRADER");
		
		$SQL = "SELECT KODE_SUB_RAK, IFNULL(f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER),'NULL') AS NAMA_SUB_RAK 
				FROM m_trader_barang_gudang WHERE KODE_TRADER = '".$KODE_TRADER."' 
				AND KODE_BARANG = '".$KODE_BARANG."' AND JNS_BARANG = '".$JNS_BARANG."' AND KODE_GUDANG='".$KODE_GUDANG."' 
				AND KODE_RAK = '".$KODE_RAK."' ORDER BY KODE_SUB_RAK DESC";
		//echo $SQL;
		//die();				
		$SUB_RAK = $func->main->get_combobox($SQL,"KODE_SUB_RAK","NAMA_SUB_RAK",FALSE);
		return form_dropdown('KODE_SUB_RAK', array_merge(array(""=>"-- Pilih --"),$SUB_RAK), $sess['KODE_SUB_RAK'], 'id="KODE_SUB_RAK" class="mtext" wajib="yes"')."#"."";
	}
	
	
    function revisi_produksi($tipe = "", $ajax="") {
        $func = get_instance();
        $this->load->library('newtable');
        if ($tipe == "1") {
            $type = "revisi_bb";
            $title = "Barang yang Diproses [input]";
            $SQL = "SELECT A.JENIS_BARANG AS 'JENIS BARANG', A.NOMOR_PROSES AS 'NOMOR TRANSAKSI', A.KODE_TRADER, 
					DATE_FORMAT(A.TANGGAL, '%d %M %Y') AS 'TANGGAL MASUK', A.WAKTU AS 'WAKTU MASUK', 
					(SELECT COUNT(B.NOMOR_PROSES) FROM M_TRADER_PROSES_DTL B 
					WHERE B.NOMOR_PROSES=A.NOMOR_PROSES AND B.KODE_TRADER=A.KODE_TRADER) 
					AS 'JUMLAH ITEM BARANG',KETERANGAN, if(STATUS=1,'DISETUJUI','DRAFT') STATUS, STATUS AS IDSTATUS
					FROM M_TRADER_PROSES A 
					WHERE A.JENIS_BARANG='masuk' AND A.STATUS = '1'
                                        AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";

            $prosesnya = array('Ubah' => array('EDIT', site_url() . "/produksi/revisi/ubah/bahan_baku", '1', 'tbl_edit.png'),
                'Hapus' => array('DELETE', site_url() . '/produksi/set_produksi/' . $tipe . "/revisi", 'N', 'tbl_delete.png'));
            $this->newtable->hiddens(array("KODE_TRADER", "JENIS BARANG", "IDSTATUS"));
            $this->newtable->keys(array("NOMOR TRANSAKSI", "KODE_TRADER", "JUMLAH ITEM BARANG", "IDSTATUS"));
            $this->newtable->search(array(array('A.NOMOR_PROSES', 'NOMOR TRANSAKSI&nbsp;'),
                array('A.TANGGAL', 'TANGGAL MASUK', 'tag-tanggal')));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->action(site_url() . "/produksi/revisi/" . $tipe."/ajax");
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby('A.TANGGAL DESC, A.WAKTU');
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("f" . $type);
            $this->newtable->set_divid("div" . $type);
            $this->newtable->rowcount(15);
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $generate = $this->newtable->generate($SQL);
            $tabel .= $generate;
            $arrdata = array("title" => $title,"tabel" => $tabel);
            if ($this->input->post("ajax") || $ajax=="ajax")  return $generate;
            else return $arrdata;
        }elseif ($tipe == "2") {
            $type = "revisi_hp";
            $title = "Hasil Pengerjaan [output]";
            $SQL = "SELECT A.JENIS_BARANG AS 'JENIS BARANG', A.NOMOR_PROSES AS 'NOMOR TRANSAKSI',A.KODE_TRADER, 
					DATE_FORMAT(A.TANGGAL, '%d %M %Y') AS 'TANGGAL KELUAR', A.WAKTU AS 'WAKTU KELUAR', 
					(SELECT COUNT(B.NOMOR_PROSES) FROM M_TRADER_PROSES_DTL B 
					WHERE B.NOMOR_PROSES=A.NOMOR_PROSES AND B.KODE_TRADER=A.KODE_TRADER) 
					AS 'JUMLAH ITEM BARANG',KETERANGAN, if(STATUS=1,'DISETUJUI','DRAFT') STATUS, STATUS AS IDSTATUS
					FROM M_TRADER_PROSES A 
					WHERE A.JENIS_BARANG='keluar' AND A.STATUS = '1'
                                        AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";

            $prosesnya = array('Ubah' => array('EDIT', site_url() . "/produksi/revisi/ubah/hasil_produksi", '1', 'tbl_edit.png'),
                'Hapus' => array('DELETE', site_url() . '/produksi/set_produksi/' . $tipe . "/revisi", 'N', 'tbl_delete.png'));
            $this->newtable->hiddens(array("KODE_TRADER", "JENIS BARANG", "IDSTATUS"));
            $this->newtable->keys(array("NOMOR TRANSAKSI", "KODE_TRADER", "JUMLAH ITEM BARANG", "IDSTATUS"));
            $this->newtable->search(array(array('A.NOMOR_PROSES', 'NOMOR TRANSAKSI&nbsp;'),
                array('A.TANGGAL', 'TANGGAL KELUAR', 'tag-tanggal')));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->action(site_url() . "/produksi/revisi/" . $tipe."/ajax");
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby("A.TANGGAL DESC,A.WAKTU");
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("f" . $type);
            $this->newtable->set_divid("div" . $type);
            $this->newtable->rowcount(15);
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel .= $this->newtable->generate($SQL);
            $arrdata = array("title" => $title,
                "tabel" => $tabel);
            if ($this->input->post("ajax") || $ajax=="ajax")
                return $tabel;
            else
                return $arrdata;
        }elseif ($tipe == "3") {
            $type = "revisi_ss";
            $title = "Sisa Pengerjaan/Scrap";
            $SQL = "SELECT A.JENIS_BARANG AS 'JENIS BARANG', A.NOMOR_PROSES AS 'NOMOR TRANSAKSI',A.KODE_TRADER, 
					DATE_FORMAT(A.TANGGAL, '%d %M %Y') AS 'TANGGAL', A.WAKTU AS 'WAKTU', 
					(SELECT COUNT(B.NOMOR_PROSES) FROM M_TRADER_PROSES_DTL B 
					WHERE B.NOMOR_PROSES=A.NOMOR_PROSES AND B.KODE_TRADER=A.KODE_TRADER)
				    AS 'JUMLAH ITEM BARANG',KETERANGAN, if(STATUS=1,'DISETUJUI','DRAFT') STATUS, STATUS AS IDSTATUS
					FROM M_TRADER_PROSES A 
					WHERE A.JENIS_BARANG='sisa' AND A.STATUS = '1'
                                        AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";

            $prosesnya = array('Ubah' => array('EDIT', site_url() . "/produksi/revisi/ubah/hasil_sisa", '1', 'tbl_edit.png'),
                'Hapus' => array('DELETE', site_url() . '/produksi/set_produksi/' . $tipe . "/revisi", 'N', 'tbl_delete.png'));
            $this->newtable->hiddens(array("KODE_TRADER", "JENIS BARANG", "IDSTATUS"));
            $this->newtable->keys(array("NOMOR TRANSAKSI", "KODE_TRADER", "JUMLAH ITEM BARANG", "IDSTATUS"));
            $this->newtable->search(array(array('A.NOMOR_PROSES', 'NOMOR TRANSAKSI&nbsp;'),
                array('A.TANGGAL', 'TANGGAL', 'tag-tanggal')));
            $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
            $this->newtable->action(site_url() . "/produksi/revisi/" . $tipe);
            $this->newtable->tipe_proses('button');
            $this->newtable->orderby("A.TANGGAL DESC,A.WAKTU");
            $this->newtable->sortby("DESC");
            $this->newtable->set_formid("f" . $type);
            $this->newtable->set_divid("div" . $type);
            $this->newtable->rowcount(15);
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($ciuri);
            $this->newtable->clear();
            $this->newtable->menu($prosesnya);
            $tabel .= $this->newtable->generate($SQL);
            $arrdata = array("title" => $title,
                "tabel" => $tabel);
            if ($this->input->post("ajax") || $ajax=="ajax")
                return $tabel;
            else
                return $arrdata;
        }
    }

    function cekbarang($kdbarang, $jnsbarang) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $SQL = " SELECT KODE_BARANG FROM M_TRADER_BARANG 
				WHERE KODE_BARANG='" . $kdbarang . "' AND JNS_BARANG='" . $jnsbarang . "' 
				AND KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";
        $hasil = $func->main->get_result($SQL);
        if ($hasil){
            return 'true';
		}else{
            return 'false';
		}
    }
	function cekgudang_tiga_level($kdbarang, $jnsbarang, $kdgudang='UTAMA', $kdrak="", $kdsubrak=""){
		$func = get_instance();
		$func->load->model("main","main",true);
		$rak = "";
		$subrak = "";
		if($kdrak != ""){
			$rak = "AND b.KODE_RAK = '".$kdrak."' ";
		}
		if($kdsubrak != ""){
			$subrak = "AND b.KODE_SUB_RAK = '".$kdsubrak."' ";			
		}		
		$SQL = "SELECT b.KODE_GUDANG FROM M_TRADER_BARANG a INNER JOIN M_TRADER_BARANG_GUDANG b ON a.KODE_TRADER = b.KODE_TRADER 
				AND a.KODE_BARANG = b.KODE_BARANG AND b.KODE_BARANG = '".$kdbarang."' AND a.JNS_BARANG = b.JNS_BARANG 
				AND b.JNS_BARANG = '".$jnsbarang."' AND b.KODE_GUDANG = '".$kdgudang."' ".$rak." ".$subrak." 
				AND a.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";
		//echo $SQL; die();
		$hasil = $func->main->get_result($SQL);
		if($hasil){
			return 'true';
		}else{
			return 'false';
		}
	}
	
	function cekstok($kdbarang, $jnsbarang, $kdgudang, $kdrak, $kdsubrak, $stok, $kondisi) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $SQL = "SELECT b.JUMLAH FROM M_TRADER_BARANG a INNER JOIN M_TRADER_BARANG_GUDANG b ON a.KODE_TRADER = B.KODE_TRADER 
				AND a.KODE_BARANG = b.KODE_BARANG AND b.KODE_BARANG = '".$kdbarang."' AND a.JNS_BARANG = b.JNS_BARANG 
				AND b.JNS_BARANG = '" . $jnsbarang . "' AND b.KODE_GUDANG = '" . $kdgudang . "' AND b.KODE_RAK = '".$kdrak."' 
				AND b.KODE_SUB_RAK = '" . $kdsubrak. "' AND b.KONDISI_BARANG = '".$kondisi."' AND 
				a.KODE_TRADER = '" . $this->newsession->userdata('KODE_TRADER') . "' ";
        $VAL = $this->db->query($SQL)->row();
        $STOCK_AKHIR = $VAL->JUMLAH;
        if ($stok > $STOCK_AKHIR){
            return $STOCK_AKHIR;
		}else{
            return 'false';
		}
    }

    /*function cekstok($kdbarang, $jnsbarang, $stok) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $SQL = " SELECT STOCK_AKHIR FROM M_TRADER_BARANG 
				WHERE KODE_BARANG='" . $kdbarang . "' AND JNS_BARANG='" . $jnsbarang . "' 
				AND KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";
        $VAL = $this->db->query($SQL)->row();
        $STOCK_AKHIR = $VAL->STOCK_AKHIR;
        if ($stok > $STOCK_AKHIR){
            return $STOCK_AKHIR;
		}else{
            return 'false';
		}
    }*/

    function cekstokopname($kdbarang, $jnsbarang) {
        $SQL = " SELECT A.TANGGAL_STOCK FROM M_TRADER_STOCKOPNAME A, M_TRADER_STOCKOPNAME_DTL B
				WHERE A.ID=B.IDHDR AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "' 
				AND A.KODE_BARANG='" . $kdbarang . "' AND A.JNS_BARANG='" . $jnsbarang . "' 
				ORDER BY A.TANGGAL_STOCK DESC LIMIT 1";
        $VAL = $this->db->query($SQL);
        if ($VAL->num_rows() > 0)
            return 'false';
        else
            return 'true';
    }

    function set_produksi($action = "", $tipe = "", $revisi = "") {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        #PROSES SETUJUI DATA PRODUKSI
        if ($action == "process") {
            date_default_timezone_set('Asia/Jakarta');
            if ($tipe == "bahan_baku") {
                $dataCheck = $this->input->post('tb_chkfbahan_baku');
                #VALIDASI DATA DULU
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $NOMOR_PROSES = $arrchk[0];
                    $query = "SELECT KODE_BARANG, JNS_BARANG, KODE_GUDANG, KODE_RAK, KODE_SUB_RAK, JUMLAH, KONDISI_BARANG 
							FROM M_TRADER_PROSES_DTL 
							WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $hasil = $func->main->get_result($query);
                    if ($hasil) {
                        foreach ($query->result_array() as $cekdata) {
                            $val = $this->cekbarang($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"]);
                            if ($val == "false"){
                                $kode = $kode . '' . $cekdata["KODE_BARANG"] . ',';
							}
                            $hsl = $this->cekstok($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"], 
										$cekdata["KODE_RAK"], $cekdata["KODE_SUB_RAK"], $cekdata["JUMLAH"], $cekdata["KONDISI_BARANG"]);
                            if ($hsl != "false"){
                                $stk = $stk . '' . $cekdata["KODE_BARANG"] . ' stocknya: ' . $hsl . ',';
							}
                            /*$rss = $this->cekstokopname($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"]);
                            if ($rss != "false")
                                $opn = $opn . '' . $cekdata["KODE_BARANG"] . ',';*/
                        }
                        if ($kode) {
                            $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
                            $dtjuml = count(explode(",", $dtkode));
                            $warnCode = $warnCode . '' . $NOMOR_PROSES . '|' . $dtjuml . '|' . $dtkode . ';';
                        }
                        if ($stk) {
                            $dtstk = str_replace(",", ", ", substr($stk, 0, strlen($stk) - 1));
                            $dtjumlstk = count(explode(",", $dtstk));
                            $warnStock = $warnStock . '' . $NOMOR_PROSES . '|' . $dtjumlstk . '|' . $dtstk . ';';
                        }
                        if ($opn) {
                            $dtopn = str_replace(",", ", ", substr($opn, 0, strlen($opn) - 1));
                            $dtjumlopn = count(explode(",", $dtopn));
                            $warnOpn = $warnOpn . '' . $NOMOR_PROSES . '|' . $dtjumlopn . '|' . $dtopn . ';';
                        }
                    } else {
                        $warnDetil = $warnDetil . '' . $NOMOR_PROSES . ', ';
                    }
                }
                if ($warnDetil) {
                    echo "MSG#ERR#Proses Data Gagal. Masukan dahulu data barang pada Nomor Transaksi : " . $warnDetil;
                    die();
                }
                if ($warnCode) {
                    $split = explode(';', $warnCode);
                    $ret = "Terdapat Kode Barang yang Belum terdaftar :\n";
                    for ($x = 0; $x < count($split) - 1; $x++) {
                        $splitdata = explode('|', $split[$x]);
                        $ret.= "Nomor Transaksi <b>" . $splitdata[0] . "</b> ada <b>" . $splitdata[1] . "</b> Barang yaitu <b>" . $splitdata[2] . "</b>";
                    }
                    echo "MSG#ERR#" . $ret;
                    die();
                }
                if ($warnStock) {
                    $split = explode(';', $warnStock);
                    $ret = "Kode Barang stoknya tidak mencukupi :\n";
                    for ($x = 0; $x < count($split) - 1; $x++) {
                        $splitdata = explode('|', $split[$x]);
                        $ret.= "Nomor Transaksi <b>" . $splitdata[0] . "</b> ada <b>" . $splitdata[1] . "</b> Barang yaitu <b>" . $splitdata[2] . "</b>";
                    }
                    echo "MSG#ERR#" . $ret;
                    die();
                }
                if ($warnOpn) {
                    $split = explode(';', $warnOpn);
                    $ret = "Kode barang berikut belum terdaftar/lengkap pada Data Stockopname :\n";
                    for ($x = 0; $x < count($split) - 1; $x++) {
                        $splitdata = explode('|', $split[$x]);
                        $ret.= "Nomor Transaksi <b>" . $splitdata[0] . "</b> ada <b>" . $splitdata[1] . "</b> Barang yaitu <b>" . $splitdata[2] . "</b>";
                    }
                    $ret.="<br>Silahkan buat data Stockopname [Header dan Detil] terlebih dahulu.";
                    echo "MSG#ERR#" . $ret;
                    die();
                }
                #JIKA OK PROSES DEH
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $NOMOR_PROSES = $arrchk[0];
                    $sqlhd = "SELECT TANGGAL, WAKTU FROM M_TRADER_PROSES 
                             WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $HEADER = $this->db->query($sqlhd)->row();

                    $query = "SELECT KODE_BARANG,JNS_BARANG,JUMLAH,KODE_SATUAN,SERI,KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG 
							 FROM M_TRADER_PROSES_DTL 
                             WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $hasil = $func->main->get_result($query);
                    if ($hasil) {
                        $TIPE = "PROCESS_IN";
                        $TANGGAL = date("Y-m-d H:i:s");
                        //$SERIINOUT = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_barang_inout WHERE KODE_TRADER='" . $KODE_TRADER . "'", "MAX") + 1;
                        $DETILLOG = "";
                        foreach ($query->result_array() as $data) {
                            #AMBIL JUMLAH STOCKOPNAME TERAKHIR	
                            /*$SQSTOK = "SELECT ID,JUMLAH,TANGGAL_STOCK FROM M_TRADER_STOCKOPNAME WHERE KODE_TRADER='" . $KODE_TRADER . "' 
                                        AND KODE_BARANG='" . $data["KODE_BARANG"] . "' AND JNS_BARANG='" . $data["JNS_BARANG"] . "' 
                                        ORDER BY TANGGAL_STOCK DESC LIMIT 1";
                            $RSSTOCK = $this->db->query($SQSTOK);
                            $JUMSTOCK = 0;
                            if ($RSSTOCK->num_rows() > 0) {
                                $VALSTOCK = $RSSTOCK->row();
                                $IDSTOCK = $VALSTOCK->ID;
                                $TGLSTOCK = $VALSTOCK->TANGGAL_STOCK;

                                $SQLS = "SELECT JUMLAH, JUMLAH_SISA FROM M_TRADER_STOCKOPNAME_DTL
                                        WHERE IDHDR='" . $IDSTOCK . "' ORDER BY TGL_DOK_MASUK ASC";
                                $VALSTKDTL = $this->db->query($SQLS);
                                $JUMSTOCK = 0;
                                if ($VALSTKDTL->num_rows() > 0) {
                                    foreach ($VALSTKDTL->result_array() as $rows) {
                                        $JUMSTOCK = $JUMSTOCK + $rows["JUMLAH_SISA"] == 0 ? $rows["JUMLAH"] : $rows["JUMLAH_SISA"];
                                    }
                                }
                            } else {
                                $ret = "MSG#ERR#Proses data Bahan Baku Gagal";
                            }*/
                            #AMBIL JUMLAH BARANG OUT > TGL.STOCOPNAME
                           /* $SQLOUT = "SELECT JUMLAH, TANGGAL FROM M_TRADER_BARANG_INOUT WHERE KODE_TRADER='" . $KODE_TRADER . "' 
                                        AND KODE_BARANG='" . $data["KODE_BARANG"] . "' AND JNS_BARANG='" . $data["JNS_BARANG"] . "' 
                                        AND TIPE IN ('GATE-OUT','PROCESS_IN') 
                                        AND DATE_FORMAT(TANGGAL,'%Y-%m-%d') BETWEEN '" . $TGLSTOCK . "' AND NOW() LIMIT 1";
                            $RSOUT = $this->db->query($SQLOUT);
                            $JUMOUT = 0;
                            if ($RSOUT->num_rows() > 0) {
                                $JUMOUT = $RSOUT->row()->JUMLAH;
                            }*/
                            #BANDINGKAN JUM STOCK VS OUT
                           /* if ($JUMSTOCK > $JUMOUT) {
                                $SELISIHLEBIH = $JUMSTOCK - $JUMOUT;
                                #BANDINGKAN SELISIH LEBIH DGN JMLH BRG
                                if ($SELISIHLEBIH >= $data["JUMLAH"]) {
                                    $JUMLAHREALISASI = $SELISIHLEBIH;
                                    #EKSEKUSI PENGELUARAN
                                    $SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
                                                FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
                                                AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                                    $VALBRG = $this->db->query($SQLBRG)->row();
                                    $JUMBRG = $VALBRG->STOCK_AKHIR;
                                    $URABRG = $VALBRG->URAIAN_BARANG;
                                    $JUMLAH_BARANG = $data["JUMLAH"];

                                    $LOG["KODE_BARANG"] = $data["KODE_BARANG"];
                                    $LOG["JNS_BARANG"] = $data["JNS_BARANG"];
                                    $LOG["SERI_BARANG"] = $SERIINOUT;
                                    $LOG["NAMA_BARANG"] = $URABRG;
                                    $LOG["SATUAN"] = $data["KODE_SATUAN"];

                                    $INOUT["NOMOR_PROSES"] = $NOMOR_PROSES;
                                    $INOUT["CREATED_TIME"] = $TANGGAL;
                                    $INOUT["TIPE"] = $TIPE;
                                    $INOUT["KODE_TRADER"] = $KODE_TRADER;
                                    $INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
                                    $INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
                                    $INOUT["SERI"] = $SERIINOUT;
                                    $INOUT["JUMLAH"] = $JUMLAH_BARANG;
                                    $INOUT["TANGGAL"] = $HEADER->TANGGAL . " " . $HEADER->WAKTU . ":00";
                                    $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                                    $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG - $JUMLAH_BARANG));
                                    $exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                                    if ($exec) {
                                        $this->db->where(array("NOMOR_PROSES" => $NOMOR_PROSES, "KODE_TRADER" => $KODE_TRADER));
                                        $exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
                                    }
                                    if ($exec) {
                                        $SQLDTLSTOCK = "SELECT IDDTL, IDHDR, JENIS_DOK_MASUK, NO_DOK_MASUK, TGL_DOK_MASUK, JUMLAH, JUMLAH_SISA 
														FROM M_TRADER_STOCKOPNAME_DTL WHERE IDHDR='" . $IDSTOCK . "' ORDER BY TGL_DOK_MASUK ASC";
                                        $RSDTLSTOCK = $this->db->query($SQLDTLSTOCK);
                                        if ($RSDTLSTOCK->num_rows() > 0) {
                                            $JUMDTL = 0;
                                            $BREAK = FALSE;
                                            foreach ($RSDTLSTOCK->result_array() as $ROWSTOCKDTL) {
                                                if ($ROWSTOCKDTL["JUMLAH_SISA"] > 0) {
                                                    $JUMSTOCKDTL = $ROWSTOCKDTL["JUMLAH_SISA"];
                                                } else {
                                                    $JUMSTOCKDTL = $ROWSTOCKDTL["JUMLAH"];
                                                }
                                                if ($JUMLAH_BARANG <= $JUMSTOCKDTL) {
                                                    $LOG["JUMLAH"] = $JUMLAH_BARANG;
                                                    $SISASTOCK = $ROWSTOCKDTL["JUMLAH"] - $JUMLAH_BARANG;
                                                    $BREAK = TRUE;
                                                } else if ($JUMLAH_BARANG > $ROWSTOCKDTL["JUMLAH"]) {
                                                    $LOG["JUMLAH"] = $ROWSTOCKDTL["JUMLAH"];
                                                    $SISASTOCK = 0;
                                                }
                                                $LOG["JENIS_DOK"] = $TIPE;
                                                $LOG["TGL_MASUK"] = $INOUT["TANGGAL"];
                                                $LOG["KODE_TRADER"] = $KODE_TRADER;
                                                $LOG["NO_DOK_MASUK"] = $ROWSTOCKDTL["NO_DOK_MASUK"];
                                                $LOG["TGL_DOK_MASUK"] = $ROWSTOCKDTL["TGL_DOK_MASUK"];
                                                $LOG["JENIS_DOK_MASUK"] = $ROWSTOCKDTL["JENIS_DOK_MASUK"];
                                                $exec = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
                                                if ($exec) {
                                                    $this->db->where(array("IDDTL" => $ROWSTOCKDTL["IDDTL"]));
                                                    $this->db->update('M_TRADER_STOCKOPNAME_DTL', array("JUMLAH_SISA" => $SISASTOCK));
                                                }
                                                if ($BREAK)
                                                    break;
                                            }
                                        }
                                    }
                                }else {
                                    $HSLLOOP = $this->proses_saldo($JUMSTOCK, $data["JUMLAH"], $data["KODE_BARANG"], $data["JNS_BARANG"]);
                                    if ($HSLLOOP == "FALSE") {
                                        return false;
                                    } else {
                                        #=================		
                                        #EKSEKUSI PENGELUARAN
                                        $SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
												   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
												   AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                                        $VALBRG = $this->db->query($SQLBRG)->row();
                                        $JUMBRG = $VALBRG->STOCK_AKHIR;
                                        $URABRG = $VALBRG->URAIAN_BARANG;
                                        $JUMLAH_BARANG = $data["JUMLAH"];

                                        $LOG["KODE_BARANG"] = $data["KODE_BARANG"];
                                        $LOG["JNS_BARANG"] = $data["JNS_BARANG"];
                                        $LOG["SERI_BARANG"] = $SERIINOUT;
                                        $LOG["NAMA_BARANG"] = $URABRG;
                                        $LOG["SATUAN"] = $data["KODE_SATUAN"];

                                        $INOUT["NOMOR_PROSES"] = $NOMOR_PROSES;
                                        $INOUT["CREATED_TIME"] = $TANGGAL;
                                        $INOUT["TIPE"] = $TIPE;
                                        $INOUT["KODE_TRADER"] = $KODE_TRADER;
                                        $INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
                                        $INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
                                        $INOUT["SERI"] = $SERIINOUT;
                                        $INOUT["JUMLAH"] = $JUMLAH_BARANG;
                                        $INOUT["TANGGAL"] = $HEADER->TANGGAL . " " . $HEADER->WAKTU . ":00";
                                        $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                            "JNS_BARANG" => $data["JNS_BARANG"],
                                            "KODE_TRADER" => $KODE_TRADER));
                                        $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG - $JUMLAH_BARANG));
                                        $exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                                        if ($exec) {
                                            $this->db->where(array("NOMOR_PROSES" => $NOMOR_PROSES, "KODE_TRADER" => $KODE_TRADER));
                                            $exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
                                        }
                                        if ($HSLLOOP) {
                                            for ($z = 0; $z < count($HSLLOOP); $z++) {
                                                $LOG["NO_DOK_MASUK"] = $HSLLOOP[$z]["NO_DOK"];
                                                $LOG["TGL_DOK_MASUK"] = $HSLLOOP[$z]["TGL_DOK"];
                                                $LOG["JENIS_DOK_MASUK"] = $HSLLOOP[$z]["JENIS_DOK"];
                                                $exec = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
                                            }
                                        }

                                        #=================
                                    }
                                }
                            } */
							//else {
                               /* $HSLLOOP = $this->proses_saldo(0, $data["JUMLAH"], $data["KODE_BARANG"], $data["JNS_BARANG"]);
                                if ($HSLLOOP == "FALSE") {
                                    return false;
                                } else {*/
                                    #=================		
                                    #EKSEKUSI PENGELUARAN
                                    $SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
											   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
											   AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                                    $VALBRG = $this->db->query($SQLBRG)->row();
                                    $JUMBRG = $VALBRG->STOCK_AKHIR;
                                    $URABRG = $VALBRG->URAIAN_BARANG;
                                    $JUMLAH_BARANG = $data["JUMLAH"];

                                    $LOG["KODE_BARANG"] = $data["KODE_BARANG"];
                                    $LOG["JNS_BARANG"] = $data["JNS_BARANG"];
                                    $LOG["SERI_BARANG"] = $SERIINOUT;
                                    $LOG["NAMA_BARANG"] = $URABRG;
                                    $LOG["SATUAN"] = $data["KODE_SATUAN"];

                                    $INOUT["NOMOR_PROSES"] = $NOMOR_PROSES;
                                    $INOUT["CREATED_TIME"] = $TANGGAL;
                                    $INOUT["TIPE"] = $TIPE;
                                    $INOUT["KODE_TRADER"] = $KODE_TRADER;
                                    $INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
                                    $INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
                                    //$INOUT["SERI"] = $SERIINOUT;
                                    $INOUT["JUMLAH"] = $JUMLAH_BARANG;
                                    $INOUT["TANGGAL"] = $HEADER->TANGGAL . " " . $HEADER->WAKTU . ":00";
                                    $INOUT["KODE_GUDANG"] = $data["KODE_GUDANG"];
									$INOUT["KODE_RAK"]	  = $data["KODE_RAK"];
									$INOUT["KODE_SUB_RAK"] = $data["KODE_SUB_RAK"];
                                    $INOUT["KONDISI_BARANG"] = $data["KONDISI_BARANG"];
                                    $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                                    $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG - $JUMLAH_BARANG));
                                    //-------------------------
                                    $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "KODE_GUDANG" => $data["KODE_GUDANG"],
										"KODE_RAK" => $data["KODE_RAK"],
										"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
                                        "KONDISI_BARANG" => $data["KONDISI_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                                    $this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $JUMBRG - $JUMLAH_BARANG));
                                    //-------------------------
                                    $exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                                    if ($exec) {
                                        $this->db->where(array("NOMOR_PROSES" => $NOMOR_PROSES, "KODE_TRADER" => $KODE_TRADER));
                                        $exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
                                    }
                                    /*if ($HSLLOOP) {
                                        for ($z = 0; $z < count($HSLLOOP); $z++) {
                                            $LOG["NO_DOK_MASUK"] = $HSLLOOP[$z]["NO_DOK"];
                                            $LOG["TGL_DOK_MASUK"] = $HSLLOOP[$z]["TGL_DOK"];
                                            $LOG["JENIS_DOK_MASUK"] = $HSLLOOP[$z]["JENIS_DOK"];
                                            $exec = $this->db->insert('T_LOGBOOK_PENGELUARAN', $LOG);
                                        }
                                    }*/

                                    #=================
                               // }
                           // }
                            #===================================================================================================											

                            //$SERIINOUT++;
                            $STKLOG = "";
                            $STKLOG = $JUMBRG - $JUMLAH_BARANG;
                            $DETILLOG = $DETILLOG . '- KODE BRG=' . $data['KODE_BARANG'] . ', JNS BRG=' . $data['JNS_BARANG'] . ', JML MASUK=' . $JUMLAH_BARANG . ', JML SEBELUM=' . $JUMBRG . ', STOCK AKHIR=' . $STKLOG . ";<br>";
                        }
                        if ($exec) {
                            $func->main->activity_log('SETUJUI DATA BARANG YANG DIPROSES [INPUT]', 'NOMOR TRANSAKSI=' . $NOMOR_PROSES . "<br>" . $DETILLOG);

                            $ret = "MSG#OK#Proses data Bahan Baku Berhasil#" . site_url() . "/produksi/daftar_dok/bahan_baku";
                        } else {
                            $ret = "MSG#ERR#Proses data Bahan Baku Gagal";
                        }
                    } else {
                        $ret = "MSG#ERR#Proses data Bahan Baku Gagal";
                    }
                }
                echo $ret;
                die();
            } elseif ($tipe == "hasil_produksi") {
                $dataCheck = $this->input->post('tb_chkfhasil_produksi');
                #VALIDASI DATA DULU
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $NOMOR_PROSES = $arrchk[0];
                    $query = "SELECT KODE_BARANG, JNS_BARANG, JUMLAH, KODE_GUDANG, KODE_RAK, KODE_SUB_RAK, KONDISI_BARANG 
							FROM M_TRADER_PROSES_DTL WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
							//echo $query; die();
                    $hasil = $func->main->get_result($query);
                    if ($hasil) {
                        foreach ($query->result_array() as $cekdata) {
                            $val = $this->cekbarang($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"]);
                            if ($val == "false")
                                $kode = $kode . '' . $cekdata["KODE_BARANG"] . ',';
                        }
                        if ($kode) {
                            $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
                            $dtjuml = count(explode(",", $dtkode));
                            $warnCode = $warnCode . '' . $NOMOR_PROSES . '|' . $dtjuml . '|' . $dtkode . ';';
                        }
                    } else {
                        $warnDetil = $warnDetil . '' . $NOMOR_PROSES . ', ';
                    }
                }
                if ($warnDetil) {
                    echo "MSG#ERR#Proses Data Gagal. Masukan dahulu data barangnya pada Nomor Transaksi : " . $warnDetil;
                    die();
                }
                if ($warnCode) {
                    $split = explode(';', $warnCode);
                    $ret = "Terdapat Kode Barang yang Belum terdaftar :\n";
                    for ($x = 0; $x < count($split) - 1; $x++) {
                        $splitdata = explode('|', $split[$x]);
                        $ret.= "Nomor Transaksi <b>" . $splitdata[0] . "</b> ada <b>" . $splitdata[1] . "</b> Barang yaitu <b>" . $splitdata[2] . "</b>";
                    }
                    echo "MSG#ERR#" . $ret;
                    die();
                }
                #JIKA OK PROSES DEH
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $NOMOR_PROSES = $arrchk[0];
                    $sqlhd = "SELECT TANGGAL,WAKTU,NOMOR_PROSES_ASAL FROM M_TRADER_PROSES 
							WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $HEADER = $this->db->query($sqlhd)->row();

                    $query = "SELECT KODE_BARANG, JNS_BARANG, JUMLAH,f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG,
							KODE_SATUAN,SERI,KODE_GUDANG, KODE_RAK, KODE_SUB_RAK, KONDISI_BARANG FROM M_TRADER_PROSES_DTL 
							WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $hasil = $func->main->get_result($query);
                    if ($hasil) {
                        $TIPE = "PROCESS_OUT";
                        $TANGGAL = date("Y-m-d H:i:s");
                        
                        $DETILLOG = "";
                        foreach ($query->result_array() as $data) {
                            $SQL1 = "SELECT STOCK_AKHIR FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
								   AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                            $jumlah1 = $this->db->query($SQL1)->row();
                            $jumlah1 = $jumlah1->STOCK_AKHIR;

                            $SQLINOUT = "INSERT INTO M_TRADER_BARANG_INOUT(KODE_TRADER,KODE_BARANG,JNS_BARANG,TIPE,JUMLAH,TANGGAL, 
										NOMOR_PROSES,CREATED_TIME,KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG) 
									    VALUES('" . $KODE_TRADER . "','" . $data["KODE_BARANG"] . "','" . $data["JNS_BARANG"] . "','" 
										. $TIPE . "','" . $data["JUMLAH"] . "','" . $HEADER->TANGGAL . " " . $HEADER->WAKTU . ":00','"
										 . $NOMOR_PROSES . "','" . $TANGGAL . "','".$data["KODE_GUDANG"]."','". $data["KODE_RAK"] ."','"
										 . $data["KODE_SUB_RAK"] ."','". $data["KONDISI_BARANG"]."')";
										 

                            $this->db->query($SQLINOUT);
                            $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"], "JNS_BARANG" => $data["JNS_BARANG"],
                                "KODE_TRADER" => $KODE_TRADER));
                            $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $jumlah1 + $data["JUMLAH"]));
                            $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "KODE_GUDANG" => $data["KODE_GUDANG"],
										"KODE_RAK" => $data["KODE_RAK"],
										"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
                                        "KONDISI_BARANG" => $data["KONDISI_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                            $this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $jumlah1 + $data["JUMLAH"]));
                            $this->db->where(array("NOMOR_PROSES" => $NOMOR_PROSES, "KODE_TRADER" => $KODE_TRADER));
                            $exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));

                            $LOG["JENIS_DOK"] = $TIPE;
                            $LOG["TGL_MASUK"] = $HEADER->TANGGAL . " " . $HEADER->WAKTU . ":00";
                            $LOG["KODE_TRADER"] = $KODE_TRADER;
                            $LOG["KODE_BARANG"] = $data["KODE_BARANG"];
							
                            $LOG["JNS_BARANG"] = $data["JNS_BARANG"];
                            $LOG["NAMA_BARANG"] = $data["URAIAN_BARANG"];
                            $LOG["SATUAN"] = $data["KODE_SATUAN"];
                            $LOG["JUMLAH"] =  $data["JUMLAH"];
                            $LOG["SALDO"] =  $data["JUMLAH"];
                           // $this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);

                            

                            $STKLOG = "";
                            $STKLOG = $jumlah1 + $data["JUMLAH"];
                            $DETILLOG = $DETILLOG . '- KODE BRG=' . $data['KODE_BARANG'] . ', JNS BRG=' . $data['JNS_BARANG'] . ', JML MASUK=' . $data["JUMLAH"] . ', JML SEBELUM=' . $jumlah1 . ', STOCK AKHIR=' . $STKLOG . ";<br>";
                        }
                        if ($exec) {
                            if ($HEADER->NOMOR_PROSES_ASAL != "") {
                                $PROSESMASUK = explode(";", $HEADER->NOMOR_PROSES_ASAL);
                                for ($i = 0; $i < count($PROSESMASUK) - 1; $i++) {
                                    $this->db->where(array("NOMOR_PROSES" => $PROSESMASUK[$i]));
                                    $this->db->update('M_TRADER_PROSES', array("FLAG_PENUTUP" => "1"));
                                }
                            }
                            $func->main->activity_log('SETUJUI DATA HASIL PENGERJAAN [OUTPUT]', 'NOMOR TRANSAKSI=' . $NOMOR_PROSES . '<br>' . $DETILLOG);
                            $ret = "MSG#OK#Proses data Hasil Produksi Berhasil#" . site_url() . "/produksi/daftar_dok/hasil_produksi";
                        } else {
                            $ret = "MSG#ERR#Proses data Hasil Produksi Gagal";
                        }
                    } else {
                        $ret = "MSG#ERR#Proses data Hasil Produksi Gagal";
                    }
                }
                echo $ret;
                die();
            } elseif ($tipe == "hasil_sisa") {
                $dataCheck = $this->input->post('tb_chkfhasil_sisa');
                #VALIDASI DATA DULU
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $NOMOR_PROSES = $arrchk[0];
                    $query = "SELECT KODE_BARANG,JNS_BARANG,JUMLAH, KODE_GUDANG, KODE_RAK, KODE_SUB_RAK, KONDISI_BARANG FROM M_TRADER_PROSES_DTL 
							WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
					//echo $query; die();
                    $hasil = $func->main->get_result($query);
					
                    if ($hasil) {
                        foreach ($query->result_array() as $cekdata) {
                            $val = $this->cekbarang($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"]);
                            if ($val == "false")
                                $kode = $kode . '' . $cekdata["KODE_BARANG"] . ',';
                        }
                        if ($kode) {
                            $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
                            $dtjuml = count(explode(",", $dtkode));
                            $warnCode = $warnCode . '' . $NOMOR_PROSES . '|' . $dtjuml . '|' . $dtkode . ';';
                        }
                    } else {
                        $warnDetil = $warnDetil . '' . $NOMOR_PROSES . ', ';
                    }
                }
                if ($warnDetil) {
                    echo "MSG#ERR#Proses Data Gagal. Masukan dahulu data barangnya pada Nomor Transaksi : " . $warnDetil;
                    die();
                }
                if ($warnCode) {
                    $split = explode(';', $warnCode);
                    $ret = "Terdapat Kode Barang yang Belum terdaftar :\n";
                    for ($x = 0; $x < count($split) - 1; $x++) {
                        $splitdata = explode('|', $split[$x]);
                        $ret.= "Nomor Transaksi <b>" . $splitdata[0] . "</b> ada <b>" . $splitdata[1] . "</b> Barang yaitu <b>" . $splitdata[2] . "</b>";
                    }
                    echo "MSG#ERR#" . $ret;
                    die();
                }
                #JIKA OK PROSES DEH
                foreach ($dataCheck as $chkitem) {
                    $arrchk = explode("|", $chkitem);
                    $NOMOR_PROSES = $arrchk[0];
                    $sqlhd = "SELECT TANGGAL,WAKTU,NOMOR_PROSES_ASAL FROM M_TRADER_PROSES 
							WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $HEADER = $this->db->query($sqlhd)->row();

                    $query = "SELECT KODE_BARANG,JNS_BARANG,JUMLAH,SERI,KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG FROM M_TRADER_PROSES_DTL 
							WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                    $hasil = $func->main->get_result($query);
                    if ($hasil) {
                        $TIPE = "SCRAP";
                        $TANGGAL = date("Y-m-d H:i:s");
                        
                        $DETILLOG = "";
                        foreach ($query->result_array() as $data) {
                            $SQL1 = "SELECT STOCK_AKHIR FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
								   AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                            $jumlah1 = $this->db->query($SQL1)->row();
                            $jumlah1 = $jumlah1->STOCK_AKHIR;

                            $SQLINOUT = "INSERT INTO M_TRADER_BARANG_INOUT(KODE_TRADER,KODE_BARANG,JNS_BARANG,TIPE,JUMLAH,
							TANGGAL,NOMOR_PROSES,CREATED_TIME,KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KONDISI_BARANG) 
									   VALUES('" . $KODE_TRADER . "','" . $data["KODE_BARANG"] . "','" . $data["JNS_BARANG"] . "','" .
									   $TIPE . "','" . $data["JUMLAH"] . "','" . $HEADER->TANGGAL . " " . $HEADER->WAKTU . ":00','" . 
									   $NOMOR_PROSES . "','" . $TANGGAL . "','".$data["KODE_GUDANG"]."','". $data["KODE_RAK"] ."','"
									   . $data["KODE_SUB_RAK"] . "','". $data["KONDISI_BARANG"] ."')";

                            $this->db->query($SQLINOUT);
                            $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"], "JNS_BARANG" => $data["JNS_BARANG"],
                                "KODE_TRADER" => $KODE_TRADER));
                            $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $jumlah1 + $data["JUMLAH"]));
                             $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "KODE_GUDANG" => $data["KODE_GUDANG"],
										"KODE_RAK" => $data["KODE_RAK"],
										"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
                                        "KONDISI_BARANG" => $data["KONDISI_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                            $this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $jumlah1 + $data["JUMLAH"]));
                            $this->db->where(array("NOMOR_PROSES" => $NOMOR_PROSES, "KODE_TRADER" => $KODE_TRADER));
                            $exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));

                            $LOG["JENIS_DOK"] = $TIPE;
                            $LOG["TGL_MASUK"] = $HEADER->TANGGAL . " " . $HEADER->WAKTU . ":00";
                            $LOG["KODE_TRADER"] = $KODE_TRADER;
                            $LOG["KODE_BARANG"] = $data["KODE_BARANG"];
                            $LOG["JNS_BARANG"] = $data["JNS_BARANG"];
                            $LOG["SERI_BARANG"] = $seriInOut;
                            $LOG["NAMA_BARANG"] = $data["URAIAN_BARANG"];
                            $LOG["SATUAN"] = $data["KODE_SATUAN"];
                            $LOG["JUMLAH"] =  $data["JUMLAH"];
                            $LOG["SALDO"] =  $data["JUMLAH"];
                            //$this->db->insert('T_LOGBOOK_PEMASUKAN', $LOG);

                            $seriInOut++;

                            $STKLOG = "";
                            $STKLOG = $jumlah1 + $data["JUMLAH"];
                            $DETILLOG = $DETILLOG . '- KODE BRG=' . $data['KODE_BARANG'] . ', JNS BRG=' . $data['JNS_BARANG'] . ', JML MASUK=' . $data["JUMLAH"] . ', JML SEBELUM=' . $jumlah1 . ', STOCK AKHIR=' . $STKLOG . ";<br>";
                        }
                        if ($exec) {
                            if ($HEADER->NOMOR_PROSES_ASAL != "") {
                                $PROSESMASUK = explode(";", $HEADER->NOMOR_PROSES_ASAL);
                                for ($i = 0; $i < count($PROSESMASUK) - 1; $i++) {
                                    $this->db->where(array("NOMOR_PROSES" => $PROSESMASUK[$i]));
                                    $this->db->update('M_TRADER_PROSES', array("FLAG_PENUTUP" => "1"));
                                }
                            }
                            $func->main->activity_log('SETUJUI DATA SISA PRODUKSI/SCRAP', 'NOMOR TRANSAKSI=' . $NOMOR_PROSES . '<br>' . $DETILLOG);

                            $ret = "MSG#OK#Proses data Sisa Produksi/Scrap Berhasil#" . site_url() . "/produksi/daftar_dok/hasil_sisa";
                        } else {
                            $ret = "MSG#ERR#Proses data Sisa Produksi/Scrap Gagal";
                        }
                    } else {
                        $ret = "MSG#ERR#Proses data Sisa Produksi/Scrap Gagal";
                    }
                }
            }
            echo $ret;
            die();
        }
        #PROSES DELETE DATA TRANSAKSI
        elseif ($action == "delete") {
            if ($tipe == "bahan_baku" || $tipe == "1") {
                if($revisi != "revisi"){
                    $dataCheck = $this->input->post('tb_chkfbahan_baku');
                    foreach ($dataCheck as $chkitem) {
                        $arrchk = explode("|", $chkitem);
                        $NOMOR_PROSES = $arrchk[0];
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses_dtl');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses');
                        $ret = "MSG#OK#Hapus data Bahan Baku Berhasil#" . site_url() . "/produksi/daftar_dok/bahan_baku#";
                    }
                    echo $ret;
                }else{
                    $dataCheck = $this->input->post('tb_chkfrevisi_bb');
                    foreach ($dataCheck as $chkitem){
                        $arrchk = explode(".", $chkitem);
                        $NOMOR_PROSES = $arrchk[0];
                        $sql = "SELECT JUMLAH, KODE_BARANG, JNS_BARANG FROM m_trader_barang_inout
                                WHERE NOMOR_PROSES = '" . $NOMOR_PROSES . "' AND KODE_TRADER = '" . $KODE_TRADER . "'";
                        $result = $this->db->query($sql);
                        if ($result->num_rows() > 0) {
                            foreach ($result->result_array() as $rows) {
                                $sqlBarang = "UPDATE m_trader_barang SET STOCK_AKHIR = (STOCK_AKHIR + " . $rows['JUMLAH'] . ")
                                               WHERE KODE_BARANG = '" . $rows['KODE_BARANG'] . "' AND JNS_BARANG = '" . $rows['JNS_BARANG'] . "'
                                               AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                $updateStock = $this->db->query($sqlBarang);
                            }
                        }
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses_dtl');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_barang_inout');
                        $ret = "MSG#OK#Hapus data Bahan Baku Berhasil#" . site_url() . "/produksi/revisi/1/ajax";
                        echo $ret;
                    }
                }
            } elseif ($tipe == "hasil_produksi" || $tipe == "2") {
                if($revisi != "revisi"){
                    $dataCheck = $this->input->post('tb_chkfhasil_produksi');
                    foreach ($dataCheck as $chkitem) {
                        $arrchk = explode("|", $chkitem);
                        $NOMOR_PROSES = $arrchk[0];
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses_dtl');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses');
                        $ret = "MSG#OK#Hapus data Hasil Produksi Berhasil#" . site_url() . "/produksi/daftar_dok/hasil_produksi#";
                    }
                    echo $ret;
                }else{
                    $dataCheck = $this->input->post('tb_chkfrevisi_hp');
                    foreach ($dataCheck as $chkitem){
                        $arrchk = explode(".", $chkitem);
                        $NOMOR_PROSES = $arrchk[0];
                        $sql = "SELECT JUMLAH, KODE_BARANG, JNS_BARANG FROM m_trader_barang_inout
                                WHERE NOMOR_PROSES = '" . $NOMOR_PROSES . "' AND KODE_TRADER = '" . $KODE_TRADER . "'";
                        $result = $this->db->query($sql);
                        if ($result->num_rows() > 0) {
                            foreach ($result->result_array() as $rows) {
                                $sqlBarang = "UPDATE m_trader_barang SET STOCK_AKHIR = (STOCK_AKHIR + " . $rows['JUMLAH'] . ")
                                               WHERE KODE_BARANG = '" . $rows['KODE_BARANG'] . "' AND JNS_BARANG = '" . $rows['JNS_BARANG'] . "'
                                               AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                $updateStock = $this->db->query($sqlBarang);
                            }
                        }
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses_dtl');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_barang_inout');
                        $ret = "MSG#OK#Hapus data Hasil Produksi Berhasil#" . site_url() . "/produksi/revisi/2/ajax";
                        echo $ret;
                    }
                }
            } elseif ($tipe == "hasil_sisa" || $tipe == "3") {
                if($revisi != "revisi"){
                    $dataCheck = $this->input->post('tb_chkfhasil_sisa');
                    foreach ($dataCheck as $chkitem) {
                        $arrchk = explode("|", $chkitem);
                        $NOMOR_PROSES = $arrchk[0];
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses_dtl');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses');
                        $ret = "MSG#OK#Hapus data Scrap Berhasil#" . site_url() . "/produksi/daftar_dok/hasil_sisa#";
                    }
                    echo $ret;
                }else{
                    $dataCheck = $this->input->post('tb_chkfrevisi_ss');
                    foreach ($dataCheck as $chkitem){
                        $arrchk = explode(".", $chkitem);
                        $NOMOR_PROSES = $arrchk[0];
                        $sql = "SELECT JUMLAH, KODE_BARANG, JNS_BARANG FROM m_trader_barang_inout
                                WHERE NOMOR_PROSES = '" . $NOMOR_PROSES . "' AND KODE_TRADER = '" . $KODE_TRADER . "'";
                        $result = $this->db->query($sql);
                        if ($result->num_rows() > 0) {
                            foreach ($result->result_array() as $rows) {
                                $sqlBarang = "UPDATE m_trader_barang SET STOCK_AKHIR = (STOCK_AKHIR + " . $rows['JUMLAH'] . ")
                                               WHERE KODE_BARANG = '" . $rows['KODE_BARANG'] . "' AND JNS_BARANG = '" . $rows['JNS_BARANG'] . "'
                                               AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                $updateStock = $this->db->query($sqlBarang);
                            }
                        }
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses_dtl');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_proses');
                        $this->db->where(array('NOMOR_PROSES' => $NOMOR_PROSES, 'KODE_TRADER' => $KODE_TRADER));
                        $this->db->delete('m_trader_barang_inout');
                        $ret = "MSG#OK#Hapus data Hasil Produksi Berhasil#" . site_url() . "/produksi/revisi/3/ajax";
                        echo $ret;
                    }
                }
            }
        }
    }

    function prosesproduksi($type = "") {
        $func = &get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        foreach ($this->input->post('HEADER') as $a => $b) {
            $HEADER[$a] = $b;
        }
        $HEADER["KODE_TRADER"] = $KODE_TRADER;
        $HEADER["STATUS"] = '0';
        date_default_timezone_set('Asia/Jakarta');

        if (count($this->input->post('DETIL')) < 2) {//DETIL KOSONG
            echo "MSG#ERR#Proses Data Gagal. Masukan dahulu data detil penggunaan bahan baku";
            die();
        }
        //PROSES BAHAN BAKU
        if (strtolower($type) == "bahan_baku") {
            $arrdetil = $this->input->post('DETIL');
            $arrkeys = array_keys($arrdetil);
			//print_r($arrdetil); die();
            for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
                for ($j = 0; $j < count($arrkeys); $j++) {
                    $cekdata[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
                }
                $val = $this->cekbarang($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"]);
                if ($val == "false"){
                    $kode = $kode . '' . $cekdata["KODE_BARANG"] . ',';
				}
				$valgud = $this->cekgudang_tiga_level($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"]);
				if($valgud == "false"){
					$gudang = $gudang . '' . $cekdata["KODE_GUDANG"] . ',';
				}
				$valrak = $this->cekgudang_tiga_level($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"], $cekdata["KODE_RAK"]);
				if($valrak == "false"){
					$rak = $rak . '' . $cekdata["KODE_RAK"] . ',';
				}
				$valsubrak = $this->cekgudang_tiga_level($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"], $cekdata["KODE_RAK"], $cekdata["KODE_SUB_RAK"]);
				if($valsubrak == "false"){
					$subrak = $subrak . '' . $cekdata["KODE_SUB_RAK"] . ',';
				}
				
                $hsl = $this->cekstok($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"], $cekdata["KODE_RAK"], $cekdata["KODE_SUB_RAK"], $cekdata["JUMLAH"], $cekdata["KONDISI_BARANG"]);
                if ($hsl != "false"){
                    $stk = $stk . '' . $cekdata["KODE_BARANG"] . ' stocknya: ' . $hsl . ',';
				}
            }

            if ($val == 'false') {
                $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
                $dtjuml = count(explode(",", $dtkode));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Barang yang Belum terdaftar, Yaitu : <b>" . $dtkode . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
			} elseif($valgud == 'false') {
				$dtgud = str_replace(",", ", ", substr($gudang, 0, strlen($gudang) - 1));
                $dtjuml = count(explode(",", $dtgud));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Gudang yang Belum terdaftar, Yaitu : <b>" . $dtgud . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
            } elseif($valrak == "false") {
				$dtrak = str_replace(",", ", ", substr($rak, 0, strlen($rak) - 1));
                $dtjuml = count(explode(",", $dtrak));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Rak yang Belum terdaftar, Yaitu : <b>" . $dtrak . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
			} elseif($valsubrak == "false") {
				$dtsubrak = str_replace(",", ", ", substr($subrak, 0, strlen($subrak) - 1));
                $dtjuml = count(explode(",", $dtsubrak));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Sub Rak yang Belum terdaftar, Yaitu : <b>" . $dtsubrak . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
			} elseif($hsl != "false") {
				$dtstok = str_replace(",", ", ", substr($stk, 0, strlen($stk) - 1));
                $dtjuml = count(explode(",", $dtstok));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Stok barang yang tidak mencukupi, Yaitu : <b>" . $dtstok . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();				
			} else {
                if ($this->input->post('ACT') == 'save') {
                    $TIPE = "PROCESS_IN";
                    $TANGGAL = date("Y-m-d H:i:s");
                    if ($this->db->insert('m_trader_proses', $HEADER)) {
                        $seriPross = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_proses_dtl 
                                                                    WHERE KODE_TRADER='" . $KODE_TRADER . "' 
                                                                    AND NOMOR_PROSES='" . $HEADER["NOMOR_PROSES"] . "'", "MAXSERI") + 1;

                        $arrkeys = array_keys($arrdetil);
                        for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
                            for ($j = 0; $j < count($arrkeys); $j++) {
                                $data[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
                            }
                  
                            $this->db->insert('m_trader_proses_dtl', array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "SERI" => $seriPross,
                                "KODE_TRADER" => $KODE_TRADER, "KODE_BARANG" => $data["KODE_BARANG"],
                                "JNS_BARANG" => $data["JNS_BARANG"], "JUMLAH" => $data["JUMLAH"],
                                "KODE_SATUAN" => $data["KODE_SATUAN"], "KODE_GUDANG" => $data["KODE_GUDANG"], 
								"KODE_RAK" => $data["KODE_RAK"], "KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
								"KONDISI_BARANG" =>$data["KONDISI_BARANG"], "KETERANGAN" => $data["KETERANGAN"]));
                            if ($this->input->post('REALISASI') == 'Y') {                                  
                                    $DETILLOG = "";
                                    $SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
                                               FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
                                               AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                                    $VALBRG = $this->db->query($SQLBRG)->row();
                                    $JUMBRG = $VALBRG->STOCK_AKHIR;

                                    $SQLBRGGDG = "SELECT JUMLAH FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '" . $data["KODE_BARANG"] . "' 
                                               AND JNS_BARANG = '" . $data["JNS_BARANG"] . "' AND KODE_GUDANG = '" . $data["KODE_GUDANG"] . "' 
											   AND KODE_RAK = '" . $data["KODE_RAK"] . "' AND KODE_SUB_RAK = '" . $data["KODE_SUB_RAK"] . "' 
											   AND KONDISI_BARANG = '".$data["KONDISI_BARANG"]."' AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                    $TMP = $this->db->query($SQLBRGGDG)->row();
                                    $JMLBG = $TMP->JUMLAH;
									
                                    $INOUT["NOMOR_PROSES"] = $HEADER["NOMOR_PROSES"];
                                    $INOUT["CREATED_TIME"] = $TANGGAL;
                                    $INOUT["TIPE"] = $TIPE;
                                    $INOUT["KODE_TRADER"] = $KODE_TRADER;
                                    $INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
                                    $INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
                                    $INOUT["JUMLAH"] = $data["JUMLAH"];
                                    $INOUT["TANGGAL"] = $HEADER["TANGGAL"] . " " . $HEADER["WAKTU"] . ":00";
                                    $INOUT["KODE_GUDANG"] = $data["KODE_GUDANG"];
									$INOUT["KODE_RAK"] = $data["KODE_RAK"];
									$INOUT["KODE_SUB_RAK"] = $data["KODE_SUB_RAK"];
                                    $INOUT["KONDISI_BARANG"] = $data["KONDISI_BARANG"];

                                    $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                                    $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG - $data["JUMLAH"]));
                                    //-------------------------
                                    $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "KODE_GUDANG" => $data["KODE_GUDANG"],
										"KODE_RAK" => $data["KODE_RAK"],
										"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
                                        "KONDISI_BARANG" => $data["KONDISI_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                                    $this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $JMLBG - $data["JUMLAH"]));
                                    //-------------------------
                                    $exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                                    if ($exec) {
                                        $this->db->where(array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "KODE_TRADER" => $KODE_TRADER));
                                        $exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
                                    }

                                    $SERIINOUT++;
                                    $STKLOG = "";
                                    $STKLOG = $JUMBRG + $data["JUMLAH"];
                                    $DETILLOG = $DETILLOG . '- KODE BRG=' . $data['KODE_BARANG'] . ', JNS BRG=' . $data['JNS_BARANG'] . ', JML MASUK=' . $data["JUMLAH"] . ', JML SEBELUM=' . $JUMBRG . ', STOCK AKHIR=' . $STKLOG . ";<br>";
                                
                                if ($exec) {
                                    $func->main->activity_log('SETUJUI DATA BARANG YANG DIPROSES [INPUT]', 'NOMOR TRANSAKSI=' . $HEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
                                }

                            }

                            $seriPross++;
                        }
                        $func->main->set_lastProses();
                        echo "MSG#OK#Proses Data Berhasil#" . site_url() . "/produksi/daftar/bahan_baku";
                    } else {
                        echo "MSG#ERR#Proses Data Gagal";
                    }
                }  else {
                    if ($this->input->post('flagrevisi') == "1") {
                        $HEADER['STATUS'] = 1;
                        $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
                        if ($this->db->update('m_trader_proses', $HEADER)) {
                            $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
                            if ($this->db->delete('m_trader_proses_dtl')) {
                                $sql = "SELECT JUMLAH, KODE_BARANG, JNS_BARANG FROM m_trader_barang_inout
                                        WHERE NOMOR_PROSES = '" . $HEADER['NOMOR_PROSES'] . "' AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                $result = $this->db->query($sql);
                                if ($result->num_rows() > 0) {
                                    foreach ($result->result_array() as $rows) {
                                        $sqlBarang = "UPDATE m_trader_barang SET STOCK_AKHIR = (STOCK_AKHIR + " . $rows['JUMLAH'] . ")
                                                       WHERE KODE_BARANG = '" . $rows['KODE_BARANG'] . "' AND JNS_BARANG = '" . $rows['JNS_BARANG'] . "'
                                                       AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                        $updateStock = $this->db->query($sqlBarang);
                                    }
                                }
                                $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES'], 'KODE_TRADER' => $KODE_TRADER));
                                $this->db->delete('m_trader_barang_inout');
                                $seriPross = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_proses_dtl 
                                                                            WHERE KODE_TRADER='" . $KODE_TRADER . "' 
                                                                            AND NOMOR_PROSES='" . $HEADER["NOMOR_PROSES"] . "'", "MAXSERI") + 1;
                                $seriInOut = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_barang_inout", "MAX") + 1;

                                $arrkeys = array_keys($arrdetil);
                                for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
                                    for ($j = 0; $j < count($arrkeys); $j++) {
                                        $data[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
                                    }
                                    $datadtl = array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "SERI" => $seriPross,
                                        "KODE_TRADER" => $KODE_TRADER, "KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"], "JUMLAH" => $data["JUMLAH"],
                                        "KODE_SATUAN" => $data["KODE_SATUAN"], "KETERANGAN" => $data["KETERANGAN"]);
                                    $this->db->insert('m_trader_proses_dtl', $datadtl);
                                    $inout = array("KODE_TRADER" => $KODE_TRADER, "KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"], "SERI" => $seriInOut,
                                        "NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "TIPE" => "PROCESS_IN",
                                        "JUMLAH" => $data["JUMLAH"], "TANGGAL" => $HEADER["TANGGAL"] . " " . $HEADER["WAKTU"] . ":00",
                                        "CREATED_TIME" => date("Y-m-d H:i:s"));
                                    $insertInout = $this->db->insert('m_trader_barang_inout', $inout);
                                    if ($insertInout) {
                                        $sqlBarang = "UPDATE m_trader_barang SET STOCK_AKHIR = (STOCK_AKHIR - " . $data['JUMLAH'] . ")
                                                       WHERE KODE_BARANG = '" . $data['KODE_BARANG'] . "' AND JNS_BARANG = '" . $data['JNS_BARANG'] . "'
                                                       AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                        $updateStock = $this->db->query($sqlBarang);
                                    }
                                    $seriPross++;
                                    $seriInOut++;
                                }
                                echo "MSG#OK#<p id='warning' class='msg warn' style='color:green;'><b>Proses Data Berhasil</b></p>";
                            } else {
                                echo "MSG#ERR#Proses Data Gagal";
                            }
                        } else {
                            echo "MSG#ERR#Proses Data Gagal";
                        }
                    } else {
						$TIPE = "PROCESS_IN";
						$TANGGAL = date("Y-m-d H:i:s");
                        $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
                        if ($this->db->update('m_trader_proses', $HEADER)) {
                            $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
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
                                        "KODE_SATUAN" => $data["KODE_SATUAN"], "KETERANGAN" => $data["KETERANGAN"],
										"KODE_GUDANG"=>$data["KODE_GUDANG"], "KODE_RAK" => $data["KODE_RAK"],
										"KODE_SUB_RAK" => $data["KODE_SUB_RAK"], "KONDISI_BARANG"=>$data["KONDISI_BARANG"]);
                                    $this->db->insert('m_trader_proses_dtl', $datadtl);
									if ($this->input->post('REALISASI') == 'Y') {
										$DETILLOG = "";
										$SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
												   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
												   AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
										$VALBRG = $this->db->query($SQLBRG)->row();
										$JUMBRG = $VALBRG->STOCK_AKHIR;
	
										$SQLBRGGDG = "SELECT JUMLAH FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG = '" . $data["KODE_BARANG"] . "' 												   AND JNS_BARANG = '" . $data["JNS_BARANG"] . "' AND KODE_GUDANG = '" . $data["KODE_GUDANG"] . "' 												   AND KODE_RAK = '" . $data["KODE_RAK"] . "' AND KODE_SUB_RAK = '" . $data["KODE_SUB_RAK"] . "' 
												   AND KONDISI_BARANG = '" .$data["KONDISI_BARANG"]. "' AND KODE_TRADER = '" . $KODE_TRADER . "'";
										$TMP = $this->db->query($SQLBRGGDG)->row();
										$JMLBG = $TMP->JUMLAH;
										
										$INOUT["NOMOR_PROSES"] = $HEADER["NOMOR_PROSES"];
										$INOUT["CREATED_TIME"] = $TANGGAL;
										$INOUT["TIPE"] = $TIPE;
										$INOUT["KODE_TRADER"] = $KODE_TRADER;
										$INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
										$INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
										$INOUT["JUMLAH"] = $data["JUMLAH"];
										$INOUT["TANGGAL"] = $HEADER["TANGGAL"] . " " . $HEADER["WAKTU"] . ":00";
										$INOUT["KODE_GUDANG"] = $data["KODE_GUDANG"];
										$INOUT["KODE_RAK"] = $data["KODE_RAK"];
										$INOUT["KODE_SUB_RAK"] = $data["KODE_SUB_RAK"];
										$INOUT["KONDISI_BARANG"] = $data["KONDISI_BARANG"];
	
										$this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
											"JNS_BARANG" => $data["JNS_BARANG"],
											"KODE_TRADER" => $KODE_TRADER));
										$this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG - $data["JUMLAH"]));
										//-------------------------
										$this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
											"KODE_GUDANG" => $data["KODE_GUDANG"],
											"KODE_RAK" => $data["KODE_RAK"],
											"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
											"KONDISI_BARANG" => $data["KONDISI_BARANG"],
											"KODE_TRADER" => $KODE_TRADER));
										$this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $JMLBG - $data["JUMLAH"]));
										//-------------------------
										$exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
										if ($exec) {
											$this->db->where(array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "KODE_TRADER" => $KODE_TRADER));
											$exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
										}
	
										$SERIINOUT++;
										$STKLOG = "";
										$STKLOG = $JUMBRG + $data["JUMLAH"];
										$DETILLOG = $DETILLOG . '- KODE BRG=' . $data['KODE_BARANG'] . ', JNS BRG=' . $data['JNS_BARANG'] . ', JML MASUK=' . $data["JUMLAH"] . ', JML SEBELUM=' . $JUMBRG . ', STOCK AKHIR=' . $STKLOG . ";<br>";
									
										if ($exec) {
											$func->main->activity_log('SETUJUI DATA BARANG YANG DIPROSES [INPUT]', 'NOMOR TRANSAKSI=' . $HEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
										}
	
									}									
                                    $seriPross++;
                                }
                                echo "MSG#OK#Proses Data Berhasil#" . site_url() . "/produksi/daftar/bahan_baku";
                            } else {
                                echo "MSG#ERR#Proses Data Gagal";
                            }
                        } else {
                            echo "MSG#ERR#Proses Data Gagal";
                        }
                    }
                }
            }
            exit();
        }
        //HASIL PRODUKSI ATAU SCRAP
        else if (strtolower($type) == "hasil_produksi" || strtolower($type) == "hasil_sisa") {
            $arrdetil = $this->input->post('DETIL');
            $arrkeys = array_keys($arrdetil);
            for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
                for ($j = 0; $j < count($arrkeys); $j++) {
                    $cekdata[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
                }
                $val = $this->cekbarang($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"]);
                if ($val == "false"){
                    $kode = $kode . '' . $cekdata["KODE_BARANG"] . ',';
				}
				$valgud = $this->cekgudang_tiga_level($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"]);
				if($valgud == "false"){
					$gudang = $gudang . '' . $cekdata["KODE_GUDANG"] . ',';
				}
				$valrak = $this->cekgudang_tiga_level($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"], $cekdata["KODE_RAK"]);
				if($valrak == "false"){
					$rak = $rak . '' . $cekdata["KODE_RAK"] . ',';
				}
				$valsubrak = $this->cekgudang_tiga_level($cekdata["KODE_BARANG"], $cekdata["JNS_BARANG"], $cekdata["KODE_GUDANG"], $cekdata["KODE_RAK"], $cekdata["KODE_SUB_RAK"]);
				if($valsubrak == "false"){
					$subrak = $subrak . '' . $cekdata["KODE_SUB_RAK"] . ',';
				}
				
            }

            if ($val == "false") {
                $dtkode = str_replace(",", ", ", substr($kode, 0, strlen($kode) - 1));
                $dtjuml = count(explode(",", $dtkode));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Barang yang Belum terdaftar, Yaitu : <b>" . $dtkode . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
			} elseif($valgud == "false") {
				$dtgud = str_replace(",", ", ", substr($gudang, 0, strlen($gudang) - 1));
                $dtjuml = count(explode(",", $dtgud));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Gudang yang Belum terdaftar, Yaitu : <b>" . $dtgud . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
            } elseif($valrak == "false") {
				$dtrak = str_replace(",", ", ", substr($rak, 0, strlen($rak) - 1));
                $dtjuml = count(explode(",", $dtrak));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Rak yang Belum terdaftar, Yaitu : <b>" . $dtrak . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
			} elseif($valsubrak == "false") {
				$dtsubrak = str_replace(",", ", ", substr($subrak, 0, strlen($subrak) - 1));
                $dtjuml = count(explode(",", $dtsubrak));
                $addWarning = ", terdapat <b>" . $dtjuml . "</b> Kode Sub Rak yang Belum terdaftar, Yaitu : <b>" . $dtsubrak . "</b>";
                echo "MSG#ERR#Proses Data Gagal" . $addWarning;
                die();
            } else {
                if ($this->input->post('ACT') == 'save') {
                    if (strtolower($type) == "hasil_produksi")
                        $TIPE = "PROCESS_OUT";
                    else
                        $TIPE = "SCRAP";
                    $TANGGAL = date("Y-m-d H:i:s");
                    if ($this->db->insert('m_trader_proses', $HEADER)) {                      
                        $seriPross = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_proses_dtl 
                                                                    WHERE KODE_TRADER='" . $KODE_TRADER . "' 
                                                                    AND NOMOR_PROSES='" . $HEADER["NOMOR_PROSES"] . "'", "MAXSERI") + 1;

                        $arrkeys = array_keys($arrdetil);
                        for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
                            for ($j = 0; $j < count($arrkeys); $j++) {
                                $data[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
                            }
                            $this->db->insert('m_trader_proses_dtl', array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "SERI" => $seriPross,
                                "KODE_TRADER" => $KODE_TRADER, "KODE_BARANG" => $data["KODE_BARANG"],
                                "JNS_BARANG" => $data["JNS_BARANG"], "JUMLAH" => $data["JUMLAH"],
                                "KODE_SATUAN" => $data["KODE_SATUAN"], "KETERANGAN" => $data["KETERANGAN"],
								"KONDISI_BARANG" => $data["KONDISI_BARANG"],
								"KODE_GUDANG" => $data["KODE_GUDANG"], "KODE_RAK" => $data["KODE_RAK"],
								 "KODE_SUB_RAK" => $data["KODE_SUB_RAK"]
								));
                            
                             if ($this->input->post('REALISASI') == 'Y') {
                                    $DETILLOG = "";
                                    $SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
                                               FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
                                               AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
                                    $VALBRG = $this->db->query($SQLBRG)->row();
                                    $JUMBRG = $VALBRG->STOCK_AKHIR;

                                    $SQLBRGGDG = "SELECT JUMLAH FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
                                               AND KODE_GUDANG='" . $data["KODE_GUDANG"] . "' AND JNS_BARANG='" . $data["JNS_BARANG"] . "' 
											   AND KODE_RAK = '" . $data["KODE_RAK"] . "' AND KODE_SUB_RAK = '" . $data["KODE_SUB_RAK"] . "' 
											   AND KONDISI_BARANG = '".$data["KONDISI_BARANG"]."' AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                    $TMP = $this->db->query($SQLBRGGDG)->row();
                                    $JMLBG = $TMP->JUMLAH;

                                    $INOUT["NOMOR_PROSES"] = $HEADER["NOMOR_PROSES"];
                                    $INOUT["CREATED_TIME"] = $TANGGAL;
                                    $INOUT["TIPE"] = $TIPE;
                                    $INOUT["KODE_TRADER"] = $KODE_TRADER;
                                    $INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
                                    $INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
                                    $INOUT["JUMLAH"] = $data["JUMLAH"];
                                    $INOUT["TANGGAL"] = $HEADER["TANGGAL"] . " " . $HEADER["WAKTU"] . ":00";
                                    $INOUT["KODE_GUDANG"] = $data["KODE_GUDANG"];
                                    $INOUT["KONDISI_BARANG"] = $data["KONDISI_BARANG"];
									$INOUT["KODE_RAK"] = $data["KODE_RAK"];
									$INOUT["KODE_SUB_RAK"] = $data["KODE_SUB_RAK"];

                                    $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                                    $this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG + $data["JUMLAH"]));
                                    //-------------------------
                                    $this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
                                        "KODE_GUDANG" => $data["KODE_GUDANG"],
										"KODE_RAK" => $data["KODE_RAK"],
										"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
                                        "KONDISI_BARANG" => $data["KONDISI_BARANG"],
                                        "KODE_TRADER" => $KODE_TRADER));
                                    $this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $JMLBG + $data["JUMLAH"]));
                                    //-------------------------
                                    $exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
                                    if ($exec) {
                                        $this->db->where(array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "KODE_TRADER" => $KODE_TRADER));
                                        $exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
                                    }

                                    $SERIINOUT++;
                                    $STKLOG = "";
                                    $STKLOG = $JUMBRG - $data["JUMLAH"];
                                    $DETILLOG = $DETILLOG . '- KODE BRG=' . $data['KODE_BARANG'] . ', JNS BRG=' . $data['JNS_BARANG'] . ', JML MASUK=' . $data["JUMLAH"] . ', JML SEBELUM=' . $JUMBRG . ', STOCK AKHIR=' . $STKLOG . ";<br>";
                                
                                if ($exec) {
                                    if(strtolower($type) == "hasil_produksi"){
                                    $func->main->activity_log('SETUJUI DATA BARANG HASIL PENGERJAAN [OUTPUT]', 'NOMOR TRANSAKSI=' . $HEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
                                    }
                                    else{
                                    $func->main->activity_log('SETUJUI DATA BARANG SISA PENGERJAAN/SCRAP', 'NOMOR TRANSAKSI=' . $HEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
                                    }
                                }

                            }
                            $seriPross++;
                        }
                        $func->main->set_lastProses();
                        echo "MSG#OK#Proses Data Berhasil#" . site_url() . "/produksi/daftar/" . $type;
                    } else {
                        echo "MSG#ERR#Proses Data Gagal";
                    }
                } else {
                    if ($this->input->post('flagrevisi') == "1") {
                        $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
                        if ($this->db->update('m_trader_proses', $HEADER)) {
                            $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
                            if ($this->db->delete('m_trader_proses_dtl')) {
                                $sql = "SELECT JUMLAH, KODE_BARANG, JNS_BARANG FROM m_trader_barang_inout
                                        WHERE NOMOR_PROSES = '" . $HEADER['NOMOR_PROSES'] . "' AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                $result = $this->db->query($sql);
                                if ($result->num_rows() > 0) {
                                    foreach ($result->result_array() as $rows) {
                                        $sqlBarang = "UPDATE m_trader_barang SET STOCK_AKHIR = (STOCK_AKHIR + " . $rows['JUMLAH'] . ")
                                                       WHERE KODE_BARANG = '" . $rows['KODE_BARANG'] . "' AND JNS_BARANG = '" . $rows['JNS_BARANG'] . "'
                                                       AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                        $updateStock = $this->db->query($sqlBarang);
                                    }
                                }
                                $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES'], 'KODE_TRADER' => $KODE_TRADER));
                                $this->db->delete('m_trader_barang_inout');
                                $seriPross = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_proses_dtl 
                                                                            WHERE KODE_TRADER='" . $KODE_TRADER . "' 
                                                                            AND NOMOR_PROSES='" . $HEADER["NOMOR_PROSES"] . "'", "MAXSERI") + 1;
                                $seriInOut = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAX FROM m_trader_barang_inout", "MAX") + 1;

                                $arrkeys = array_keys($arrdetil);
                                for ($i = 0; $i < count($arrdetil[$arrkeys[0]]); $i++) {
                                    for ($j = 0; $j < count($arrkeys); $j++) {
                                        $data[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
                                    }
                                    $datadtl = array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "SERI" => $seriPross,
                                        "KODE_TRADER" => $KODE_TRADER, "KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"], "JUMLAH" => $data["JUMLAH"],
                                        "KODE_SATUAN" => $data["KODE_SATUAN"], "KETERANGAN" => $data["KETERANGAN"]);
                                    $this->db->insert('m_trader_proses_dtl', $datadtl);
                                    $inout = array("KODE_TRADER" => $KODE_TRADER, "KODE_BARANG" => $data["KODE_BARANG"],
                                        "JNS_BARANG" => $data["JNS_BARANG"], "SERI" => $seriInOut,
                                        "NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "TIPE" => "PROCESS_IN",
                                        "JUMLAH" => $data["JUMLAH"], "TANGGAL" => $HEADER["TANGGAL"] . " " . $HEADER["WAKTU"] . ":00",
                                        "CREATED_TIME" => date("Y-m-d H:i:s"));
                                    $insertInout = $this->db->insert('m_trader_barang_inout', $inout);
                                    if ($insertInout) {
                                        $sqlBarang = "UPDATE m_trader_barang SET STOCK_AKHIR = (STOCK_AKHIR - " . $data['JUMLAH'] . ")
                                                       WHERE KODE_BARANG = '" . $data['KODE_BARANG'] . "' AND JNS_BARANG = '" . $data['JNS_BARANG'] . "'
                                                       AND KODE_TRADER = '" . $KODE_TRADER . "'";
                                        $updateStock = $this->db->query($sqlBarang);
                                    }
                                    $seriPross++;
                                    $seriInOut++;
                                }
                                echo "MSG#OK#<p id='warning' class='msg warn' style='color:green;'><b>Proses Data Berhasil</b></p>";
                            } else {
                                echo "MSG#ERR#Proses Data Gagal";
                            }
                        } else {
                            echo "MSG#ERR#Proses Data Gagal";
                        }
                    }else{
						if (strtolower($type) == "hasil_produksi"){
                       	 	$TIPE = "PROCESS_OUT";
						}else{
                        	$TIPE = "SCRAP";
						}
                    	$TANGGAL = date("Y-m-d H:i:s");
                        $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
                        if ($this->db->update('m_trader_proses', $HEADER)) {
                            $this->db->where(array('NOMOR_PROSES' => $HEADER['NOMOR_PROSES']));
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
										"KODE_SATUAN" => $data["KODE_SATUAN"], "KODE_GUDANG" => $data["KODE_GUDANG"],
										"KODE_RAK" => $data["KODE_RAK"],	"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
										"KONDISI_BARANG" => $data["KONDISI_BARANG"], "KETERANGAN" => $data["KETERANGAN"]);
                                    $this->db->insert('m_trader_proses_dtl', $datadtl);
									if ($this->input->post('REALISASI') == 'Y') {
										$DETILLOG = "";
										$SQLBRG = "SELECT STOCK_AKHIR, f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URAIAN_BARANG
												   FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
												   AND JNS_BARANG='" . $data["JNS_BARANG"] . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
										$VALBRG = $this->db->query($SQLBRG)->row();
										$JUMBRG = $VALBRG->STOCK_AKHIR;
	
										$SQLBRGGDG = "SELECT JUMLAH FROM M_TRADER_BARANG_GUDANG WHERE KODE_BARANG='" . $data["KODE_BARANG"] . "' 
												   AND KODE_GUDANG='" . $data["KODE_GUDANG"] . "' AND JNS_BARANG='" . $data["JNS_BARANG"] . "' 
												   AND KODE_RAK = '" . $data["KODE_RAK"] . "' AND KODE_SUB_RAK = '" . $data["KODE_SUB_RAK"] . "' 
												   AND KONDISI_BARANG = '".$data["KONDISI_BARANG"]."' AND KODE_TRADER = '" . $KODE_TRADER . "'";
										$TMP = $this->db->query($SQLBRGGDG)->row();
										$JMLBG = $TMP->JUMLAH;
	
										$INOUT["NOMOR_PROSES"] = $HEADER["NOMOR_PROSES"];
										$INOUT["CREATED_TIME"] = $TANGGAL;
										$INOUT["TIPE"] = $TIPE;
										$INOUT["KODE_TRADER"] = $KODE_TRADER;
										$INOUT["KODE_BARANG"] = $data["KODE_BARANG"];
										$INOUT["JNS_BARANG"] = $data["JNS_BARANG"];
										$INOUT["JUMLAH"] = $data["JUMLAH"];
										$INOUT["TANGGAL"] = $HEADER["TANGGAL"] . " " . $HEADER["WAKTU"] . ":00";
										$INOUT["KODE_GUDANG"] = $data["KODE_GUDANG"];
										$INOUT["KONDISI_BARANG"] = $data["KONDISI_BARANG"];
										$INOUT["KODE_RAK"] = $data["KODE_RAK"];
										$INOUT["KODE_SUB_RAK"] = $data["KODE_SUB_RAK"];
	
										$this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
											"JNS_BARANG" => $data["JNS_BARANG"],
											"KODE_TRADER" => $KODE_TRADER));
										$this->db->update('M_TRADER_BARANG', array("STOCK_AKHIR" => $JUMBRG + $data["JUMLAH"]));
										//-------------------------
										$this->db->where(array("KODE_BARANG" => $data["KODE_BARANG"],
											"KODE_GUDANG" => $data["KODE_GUDANG"],
											"KODE_RAK" => $data["KODE_RAK"],
											"KODE_SUB_RAK" => $data["KODE_SUB_RAK"],
											"KONDISI_BARANG" => $data["KONDISI_BARANG"],
											"KODE_TRADER" => $KODE_TRADER));
										$this->db->update('M_TRADER_BARANG_GUDANG', array("JUMLAH" => $JMLBG + $data["JUMLAH"]));
										//-------------------------
										$exec = $this->db->insert('M_TRADER_BARANG_INOUT', $INOUT);
										if ($exec) {
											$this->db->where(array("NOMOR_PROSES" => $HEADER["NOMOR_PROSES"], "KODE_TRADER" => $KODE_TRADER));
											$exec = $this->db->update('M_TRADER_PROSES', array("STATUS" => "1"));
										}
	
										$SERIINOUT++;
										$STKLOG = "";
										$STKLOG = $JUMBRG - $data["JUMLAH"];
										$DETILLOG = $DETILLOG . '- KODE BRG=' . $data['KODE_BARANG'] . ', JNS BRG=' . $data['JNS_BARANG'] . ', JML MASUK=' . $data["JUMLAH"] . ', JML SEBELUM=' . $JUMBRG . ', STOCK AKHIR=' . $STKLOG . ";<br>";
									
										if ($exec) {
											if(strtolower($type) == "hasil_produksi"){
											$func->main->activity_log('SETUJUI DATA BARANG HASIL PENGERJAAN [OUTPUT]', 'NOMOR TRANSAKSI=' . $HEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
											}
											else{
											$func->main->activity_log('SETUJUI DATA BARANG SISA PENGERJAAN/SCRAP', 'NOMOR TRANSAKSI=' . $HEADER["NOMOR_PROSES"] . "<br>" . $DETILLOG);
											}
										}	
									}
                                    $seriPross++;
                                }
                                echo "MSG#OK#Proses Data Berhasil#" . site_url() . "/produksi/daftar/" . $type;
                            } else {
                                echo "MSG#ERR#Proses Data Gagal";
                            }
                        } else {
                            echo "MSG#ERR#Proses Data Gagal";
                        }
                    }
                }
            }
            exit();
        }
    }

    function get_dataproduksi($NOMOR_PROSES) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $SQLH = "SELECT TANGGAL,WAKTU,KETERANGAN,NOMOR_PROSES_ASAL FROM M_TRADER_PROSES 
				 WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND KODE_TRADER='" . $KODE_TRADER . "'";
        $HEADER = $this->db->query($SQLH)->row();

        $SQLD = "SELECT KODE_BARANG,f_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) URKODE_BARANG, 
				 JNS_BARANG,f_ref('ASAL_JENIS_BARANG',JNS_BARANG) URJNS_BARANG,JUMLAH,KODE_SATUAN,
				 f_satuan(KODE_SATUAN) URSATUAN, KETERANGAN,
			     f_stockakhir_barang(KODE_BARANG,JNS_BARANG,KODE_TRADER) STOCKAKHIR,
				 CONCAT(IFNULL(f_gudang(KODE_GUDANG,KODE_TRADER),'UTAMA')) AS GUDANG, KONDISI_BARANG, KODE_GUDANG 
				 , f_rak(KODE_GUDANG,KODE_RAK,KODE_TRADER) AS RAK, f_sub_rak(KODE_GUDANG,KODE_RAK,KODE_SUB_RAK,KODE_TRADER) AS SUB_RAK, KODE_RAK,
				  KODE_SUB_RAK FROM M_TRADER_PROSES_DTL WHERE NOMOR_PROSES='" . $NOMOR_PROSES . "' AND 
				 KODE_TRADER='" . $KODE_TRADER . "'";
        $hasil = $func->main->get_result($SQLD);
        if ($hasil) {
            $no = 1;
            $htmlheader = "<tr id=\"tr_hdr\">
                            <th width=\"2%\">No</th>
                            <th width=\"10%\">Kode Barang</th>
                            <th width=\"15%\">Uraian Barang</th>
                            <th width=\"9%\">Jenis Barang</th>
                            <th width=\"9%\">Gudang</th>
                            <th width=\"9%\">Rak</th>
                            <th width=\"9%\">Sub Rak</th>
                            <th width=\"9%\">Jumlah</th>
                            <th width=\"9%\">Satuan</th>
                            <th width=\"10%\">Keterangan</th>
                            <th width=\"8%\">&nbsp;</th></tr>"; 
            foreach ($SQLD->result_array() as $data) {
                $detil.="<tr id=\"tr_dtl" . $no . "\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\">
						<td class=\"alt\"><span class=\"nop\">" . $no . "</span></td>
						<td class=\"alt\">" . $data['KODE_BARANG'] . "</td>
						<td class=\"alt\">" . $data['URJNS_BARANG'] . "</td>
						<td class=\"alt\">" . $data['URKODE_BARANG'] . "</td>
						<td class=\"alt\">" . $data['GUDANG'] . "</td>
						<td class=\"alt\">" . $data['RAK'] . "</td>
						<td class=\"alt\">" . $data['SUB_RAK'] . "</td>
						<td class=\"alt\">" . $data['JUMLAH'] . "</td>
						<td class=\"alt\">" . $data['URSATUAN'] . "</td>
						<td class=\"alt\">" . $data['KETERANGAN'] . "</td>
						<td align=\"center\" class=\"alt\" width=\"115\">
						<a href=\"javascript:void(0)\" class=\"btn btn-sm btn-info\" onclick=\"prosesproduksi('#fprdbahanbaku_','update','". $no ."')\"><i class=\"icon-edit bigger-120\"></i></a>&nbsp;<a href=\"javascript:void(0)\" class=\"btn btn-sm btn-danger\" onclick=\"remove_produksi(".$no.")\"><i class=\"icon-trash bigger-120\"></i></a>
						<input type=\"hidden\" name=\"DETIL[KODE_BARANG][]\" id=\"KODE_BARANG" . $no . "\" value=\"" . $data['KODE_BARANG'] . "\" class=\"kdbarang\"/><input type=\"hidden\" name=\"DETIL[JNS_BARANG][]\" id=\"JNS_BARANG" . $no . "\" value=\"" . $data['JNS_BARANG'] . "\"  class=\"jnsbarang\"/><input type=\"hidden\" name=\"DETIL[JUMLAH][]\" id=\"JUMLAH" . $no . "\" value=\"" . $data['JUMLAH'] . "\" /><input type=\"hidden\" name=\"DETIL[KODE_SATUAN][]\" id=\"KODE_SATUAN" . $no . "\" value=\"" . $data['KODE_SATUAN'] . "\" /><input type=\"hidden\" name=\"DETIL[KETERANGAN][]\" id=\"KETERANGAN" . $no . "\" value=\"" . $data['KETERANGAN'] . "\"/><input type=\"hidden\" name=\"STOCKAKHIR\" id=\"STOCKAKHIR" . $no . "\" value=\"" . $data['STOCKAKHIR'] . "\" /><input type=\"hidden\" name=\"DETIL[KODE_GUDANG][]\" id=\"KODE_GUDANG" . $no . "\" value=\"" . $data['KODE_GUDANG'] . "\" class=\"kdgudang\"/><input type=\"hidden\" name=\"DETIL[KONDISI_BARANG][]\" id=\"KONDISI_BARANG" . $no . "\" value=\"" . $data['KONDISI_BARANG'] . "\" class=\"kondisibrg\"/>
						<input type=\"hidden\" name=\"DETIL[KODE_RAK][]\" id=\"KODE_RAK" . $no . "\" value=\"" . $data['KODE_RAK'] . "\" class=\"kdrak\"/>
						<input type=\"hidden\" name=\"DETIL[KODE_SUB_RAK][]\" id=\"KODE_SUB_RAK" . $no . "\" value=\"" . $data['KODE_SUB_RAK'] . "\" class=\"kdsubrak\"/>						
						</td></tr>";
                $no++;
            }
        }
        $arrdata['TANGGAL'] = $HEADER->TANGGAL;
        $arrdata['WAKTU'] = $HEADER->WAKTU;
        $arrdata['KETERANGAN'] = $HEADER->KETERANGAN;
        $arrdata['NOMOR_PROSES_ASAL'] = $HEADER->NOMOR_PROSES_ASAL;
        $arrdata['HEADER'] = $htmlheader;
        $arrdata['DETIL'] = $detil;
        $arrdata['action'] = "update";
        return $arrdata;
    }

    function prosesmasuk() {
        $this->load->library('newtable');
        $SQL = "SELECT NOMOR_PROSES 'Nomor Transaksi',DATE_FORMAT(TANGGAL,'%d %M %Y') 'TANGGAL MASUK',WAKTU, KETERANGAN
			    FROM m_trader_proses WHERE JENIS_BARANG='masuk' AND KODE_TRADER ='" . $this->newsession->userdata('KODE_TRADER') . "'";
        $this->newtable->search(array(array('NOMOR_PROSES', 'NOMOR TRANSAKSI&nbsp;'),
            array('TANGGAL', 'TANGGAL MASUK', 'tag-tanggal')));
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->action(site_url() . "/produksi/prosesmasuk");
        $this->newtable->keys(array("Nomor Transaksi"));
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->show_chk(true);
        $this->newtable->orderby(1);
        $this->newtable->sortby("DESC");
        $this->newtable->set_formid("frmprosesmasuk");
        $this->newtable->set_divid("divprosesmasuk");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        
        $tabel = "<a href=\"javascript:void(0);\" class=\"btn btn-success save\" id=\"ok_\" onclick=\"prosesmasuk('frmprosesmasuk');\" style=\"color:#fff;position:absolute;left:0;top:2.5em;margin:-3px 30px 5px 7px;height:25px;font-size:12px\"><span><i class=\"icon-plus\" style=\"font-size:12px\"></i>&nbsp;Pilih&nbsp;</span></a>";
		$tabel .= $this->newtable->generate($SQL);
        $judul = "Pilih Nomor Proses Penggunaan Bahan Baku :";
        $arrdata = array("judul" => $judul,
            "tabel" => $tabel);
        if ($this->input->post("ajax"))
            return $tabel;
        else
            return $arrdata;
    }

    function get_lastProses() {
        $sql = "SELECT LAST_PROSES FROM M_SETTING WHERE KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";
        $result = $this->db->query($sql);
        $row = $result->row();
        $lastNumber = $row->LAST_PROSES;
        $lastProses = date('dmY') . str_pad($lastNumber, 6, 0, STR_PAD_LEFT);
        return $lastProses;
    }

    #========================================================================================================================================#

    function getData($tipe, $key1, $key2) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $idTrader = $this->newsession->userdata("KODE_TRADER");
        if ($tipe == "bhn_baku_new" || $tipe == "bhn_baku_detil" || $tipe == "bahanBakuPOPget" || $tipe == "bhn_baku_view" || $tipe == "hsl_prod_new" || $tipe == "hasil_prodPOPN" || $tipe == "hasil_prodPOP" || $tipe == "hsl_prod_detil" || $tipe == "hsl_prod_view" || $tipe == "hsl_sisa_new" || $tipe == "hasil_sisaPOPN" || $tipe == "hasil_sisaPOP" || $tipe == "hsl_sisa_detil" || $tipe == "hsl_sisa_view") {
            if ($tipe == "bahanBakuPOPget") {
                $SERI = $this->uri->segment(6);
                $query = "SELECT A.NOMOR_PROSES,A.KODE_SATUAN,A.KODE_TRADER,A.KODE_BARANG, A.SERI,B.URAIAN_BARANG 
						AS 'URAIAN BARANG',A.JNS_BARANG,f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS BARANG', A.JUMLAH, 
						f_satuan(A.KODE_SATUAN) 'URAIAN SATUAN',A.KETERANGAN FROM M_TRADER_PROSES_DTL A LEFT JOIN M_TRADER_BARANG B 
						ON B.KODE_BARANG=A.KODE_BARANG WHERE A.NOMOR_PROSES='" . $key1 . "' AND B.KODE_TRADER='" . $idTrader . "' AND A.SERI='" . $SERI . "'";
            } elseif ($key1) {
                $query = "SELECT * FROM M_TRADER_PROSES WHERE NOMOR_PROSES='" . $key1 . "' AND KODE_TRADER='" . $idTrader . "'";
            } else {
                $query = "SELECT A.KODE_TRADER, A.KODE_ID 'KODE_ID_TRADER', A.ID, A.NAMA 'NAMA_TRADER', A.ALAMAT 'ALAMAT_TRADER', A.TELEPON, 
						  A.KODE_API, A.NOMOR_API,
						  C.NAMA 'NAMA_CP', C.TELEPON 'TELP_CP', C.EMAIL 'EMAIL_CP',ID AS 'ID_TRADER',
						  0 AS 'FOB', 0 AS 'FREIGHT', 0 AS 'ASURANSI', 0 AS 'CIF', 0 AS 'CIFRP', 0 AS 'BRUTO', 0 AS 'NETTO', 0 AS 'TAMBAHAN',
						  0 AS 'DISKON', 0 AS 'NILAI_INVOICE', 0 AS 'NDPBM'
						  FROM M_TRADER A, M_TRADER_SKEP B, T_USER C WHERE A.KODE_TRADER=B.KODE_TRADER AND A.KODE_TRADER=C.KODE_TRADER
						  AND A.KODE_TRADER='" . $idTrader . "'";
            }
            $hasil = $func->main->get_result($query);
            if ($hasil) {
                foreach ($query->result_array() as $row) {
                    $dataarray = $row;
                }
            }
            return $dataarray;
        }
    }

    function detil($type = "", $key1 = "", $key2 = "") {
        $tipe = "barang";
        $this->load->library('newtable');
        if ($type == "bhn_baku_detil" || $type == "detil_konversiBB") {
            $SQL = "SELECT A.NOMOR_PROSES,A.KODE_TRADER,A.KODE_BARANG AS 'KODE BARANG', A.SERI,
					f_barang(A.KODE_BARANG,A.JNS_BARANG,A.KODE_TRADER) AS 'URAIAN BARANG',
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS BARANG',A.JNS_BARANG, A.JUMLAH, 
					f_satuan(A.KODE_SATUAN) 'URAIAN SATUAN', KETERANGAN			
					FROM M_TRADER_PROSES_DTL A 
					WHERE A.NOMOR_PROSES='" . $key1 . "' AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";

            $process = array('Tambah ' . $tipe => array('GET2POP', site_url() . "/produksi/add/bahan_bakuPOP/" . $key1 . "/" . $key2, '0'),
                'Ubah ' . $tipe => array('GET2POP', site_url() . "/produksi/edit/bahan_bakuPOP", '1'),
                'Hapus ' . $tipe => array('DELETE', site_url() . '/produksi/set_produksi/' . $type, 'bahan_baku_detil'));

            $this->newtable->action(site_url() . "/produksi/edit/bhn_baku_list_detil/" . $key1 . "/" . $key2);
            $this->newtable->search(array(array('A.KODE_BARANG', 'KODE BARANG'), array('B.URAIAN_BARANG', 'URAIAN BARANG')));
            $this->newtable->keys(array('NOMOR_PROSES', 'KODE_TRADER', 'SERI', 'KODE BARANG', 'JNS_BARANG', 'JUMLAH'));
            $this->newtable->hiddens(array('SERI', 'KODE_TRADER', 'NOMOR_PROSES', 'JNS_BARANG'));
        } elseif ($type == "bhn_baku_view") {
            $SQL = "SELECT A.NOMOR_PROSES,A.KODE_TRADER,A.KODE_BARANG AS 'KODE BARANG', A.SERI,
					f_barang(A.KODE_BARANG,A.JNS_BARANG,A.KODE_TRADER) AS 'URAIAN BARANG',
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS BARANG',A.JNS_BARANG, A.JUMLAH, 
					f_satuan(A.KODE_SATUAN) 'URAIAN SATUAN',A.KODE_GUDANG AS 'GUDANG', A.KONDISI_BARANG AS 'KONDISI',KETERANGAN			
					FROM M_TRADER_PROSES_DTL A
					WHERE A.NOMOR_PROSES='" . $key1 . "' AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";
            $process = "";
            $this->newtable->action(site_url() . "/produksi/edit/bhn_baku_list_view/" . $key1 . "/" . $key2);
            $this->newtable->hiddens(array('SERI', 'KODE_TRADER', 'NOMOR_PROSES', 'JNS_BARANG'));
            $this->newtable->show_chk(FALSE);
            $this->newtable->search(array(array('A.KODE_BARANG', 'KODE BARANG'), array('B.URAIAN_BARANG', 'URAIAN BARANG')));
        } elseif ($type == "hsl_prod_view") {
            $SQL = "SELECT A.NOMOR_PROSES,A.KODE_TRADER,A.KODE_BARANG AS 'KODE BARANG', A.SERI,
					f_barang(A.KODE_BARANG,A.JNS_BARANG,A.KODE_TRADER) AS 'URAIAN BARANG',
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS BARANG',A.JNS_BARANG, A.JUMLAH, 
					f_satuan(A.KODE_SATUAN) 'URAIAN SATUAN',KETERANGAN			
					FROM M_TRADER_PROSES_DTL A 
					WHERE A.NOMOR_PROSES='" . $key1 . "' AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";
            $process = "";
            $this->newtable->show_chk(FALSE);
            $this->newtable->action(site_url() . "/produksi/edit/hsl_prod_list_view/" . $key1 . "/" . $key2);
            $this->newtable->search(array(array('A.KODE_BARANG', 'KODE BARANG'), array('B.URAIAN_BARANG', 'URAIAN BARANG')));
            $this->newtable->hiddens(array('SERI', 'KODE_TRADER', 'NOMOR_PROSES', 'JNS_BARANG'));
        } elseif ($type == "hsl_sisa_view") {
            $SQL = "SELECT A.NOMOR_PROSES,A.KODE_TRADER,A.KODE_BARANG AS 'KODE BARANG', A.SERI,
					f_barang(A.KODE_BARANG,A.JNS_BARANG,A.KODE_TRADER) AS 'URAIAN BARANG',
					f_ref('ASAL_JENIS_BARANG',A.JNS_BARANG) 'JENIS BARANG',A.JNS_BARANG, A.JUMLAH, 
					f_satuan(A.KODE_SATUAN) 'URAIAN SATUAN'	,KETERANGAN		
					FROM M_TRADER_PROSES_DTL A 
					WHERE A.NOMOR_PROSES='" . $key1 . "' AND A.KODE_TRADER='" . $this->newsession->userdata('KODE_TRADER') . "'";
            $process = "";
            $this->newtable->show_chk(FALSE);
            $this->newtable->action(site_url() . "/produksi/edit/hsl_sisa_list_view/" . $key1 . "/" . $key2);
            $this->newtable->search(array(array('A.KODE_BARANG', 'KODE BARANG'), array('B.URAIAN_BARANG', 'URAIAN BARANG')));
            $this->newtable->hiddens(array('SERI', 'KODE_TRADER', 'NOMOR_PROSES', 'JNS_BARANG'));
        }


        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("f" . $type);
        $this->newtable->set_divid("div" . $type);
        $this->newtable->ciuri($ciuri);
        $this->newtable->orderby(1);
        $this->newtable->sortby("DESC");
        $this->newtable->clear();
        $this->newtable->rowcount(10);
        $this->newtable->menu($process);
        $this->newtable->header_bg('#3C00A1');
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("judul" => $judul,
            "tabel" => $tabel);
        if ($this->input->post("ajax"))
            return $tabel;
        else
            return $arrdata;
    }

    function get_prevProses() {
        $kodeTrader = $this->newsession->userdata('KODE_TRADER');
        $sql = "SELECT STATUS_TRADER from m_trader WHERE KODE_TRADER='" . $kodeTrader . "'";
        $result = $this->db->query($sql);
        $row = $result->row();
        $lastNumber = $row->STATUS_TRADER - 1;
        $lastProses = date('dmY') . str_pad($lastNumber, 6, 0, STR_PAD_LEFT);
        return $lastProses;
    }

    function getDataKonversi($nomorProses, $idBJ) {
        $func = get_instance();
        $func->load->model("main", "main", true);
        $seriInOut = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM m_trader_barang_inout", "MAXSERI") + 1;
        $seriProsDet = (int) $func->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM m_trader_proses_dtl WHERE NOMOR_PROSES = '" . $nomorProses . "'", "MAXSERI") + 1;
        $SQLKONV = "SELECT KODE_TRADER,KODE_BARANG,JNS_BARANG,JUMLAH,KODE_SATUAN,KETERANGAN FROM M_TRADER_KONVERSI_BB WHERE IDBJ='" . $idBJ . "'";
        $hasil = $func->main->get_result($SQLKONV);
        if ($hasil) {
            foreach ($SQLKONV->result_array() as $row) {
                $TIPE = "PROCESS_IN";
                $TANGGAL = date("Y-m-d H:i:s");
                $KODE_TRADER = $row['KODE_TRADER'];
                $KODE_BARANG = $row['KODE_BARANG'];
                $JNS_BARANG = $row['JNS_BARANG'];
                $JUMLAH = $row['JUMLAH'];
                $KODE_SATUAN = $row['KODE_SATUAN'];
                $KETERANGAN = $row['KETERANGAN'];
                $SQL1 = "SELECT STOCK_AKHIR FROM M_TRADER_BARANG WHERE KODE_BARANG='" . $KODE_BARANG . "' 
					   AND JNS_BARANG='" . $JNS_BARANG . "'";
                $jumlah1 = $this->db->query($SQL1)->row();
                $jumlah1 = $jumlah1->STOCK_AKHIR;
                $SQLPROSDET = "INSERT INTO M_TRADER_PROSES_DTL(NOMOR_PROSES,SERI,KODE_TRADER,KODE_BARANG,JNS_BARANG,JUMLAH,KODE_SATUAN,KETERANGAN) 
							 VALUES(" . $this->db->escape($nomorProses) . "," . $this->db->escape($seriProsDet) . ",
									" . $this->db->escape($KODE_TRADER) . "," . $this->db->escape($KODE_BARANG) . ",
									" . $this->db->escape($JNS_BARANG) . "," . $this->db->escape($JUMLAH) . "," . $this->db->escape($KODE_SATUAN) . ",
									" . $this->db->escape($KETERANGAN) . ")"; //echo $sql;
                $SQLINOUT = "INSERT INTO M_TRADER_BARANG_INOUT(KODE_TRADER,KODE_BARANG,JNS_BARANG,SERI,TIPE,JUMLAH,TANGGAL) 
						   VALUES(" . $this->db->escape($KODE_TRADER) . "," . $this->db->escape($KODE_BARANG) . "," . $this->db->escape($JNS_BARANG) . ",
								  " . $this->db->escape($seriInOut) . "," . $this->db->escape($TIPE) . "," . $this->db->escape($JUMLAH) . ",
								  " . $this->db->escape($TANGGAL) . ")";
                $this->db->query($SQLPROSDET);
                $this->db->query($SQLINOUT);
                $seriProsDet++;
                $seriInOut++;
            }
        }
    }

    function getDataDetilKonversi($IDBJ) {
        $SQL = "SELECT * FROM M_TRADER_KONVERSI_BB WHERE IDBJ='" . $IDBJ . "'";
        $result = $this->db->query($SQL);
        return $result->result_array();
    }

    #===========================================================================================================================================	

    function proses_saldo($JUMSTOCK, $JUMLAH_SATUAN, $KODE_BARANG, $JNS_BARANG) {
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $RET = "FALSE";
        $SQLSALDO = "SELECT LOGID, JENIS_DOK, NO_DOK, TGL_DOK, TGL_MASUK, KODE_TRADER, KODE_BARANG, JNS_BARANG, SERI_BARANG, NAMA_BARANG,
  					 SATUAN, JUMLAH, NILAI_PABEAN, FLAG_TUTUP, SALDO FROM T_LOGBOOK_PEMASUKAN WHERE KODE_TRADER='" . $KODE_TRADER . "' 
					 AND KODE_BARANG='" . $KODE_BARANG . "' AND JNS_BARANG='" . $JNS_BARANG . "' 
					 AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') ORDER BY TGL_DOK,NO_DOK,SERI_BARANG ASC";
        $RSSALDO = $this->db->query($SQLSALDO);
        if ($RSSALDO->num_rows() > 0) {
            $JUMSALDO = 0;
            $DATAMASUK = array();
            foreach ($RSSALDO->result_array() as $DATA) {
                $JUMSALDO = $DATA["SALDO"];
                $LOGID = $DATA["LOGID"];
                $DATAMASUK[] = array("JENIS_DOK" => $DATA["JENIS_DOK"], "NO_DOK" => $DATA["NO_DOK"], "TGL_DOK" => $DATA["TGL_DOK"]);
                $JUMSTOCKNSALDO = $JUMSTOCKNSALDO + ($JUMSTOCK + $JUMSALDO);
                if ($JUMSTOCKNSALDO >= $JUMLAH_SATUAN) {
                    $SALDOAKHIR = $JUMSTOCKNSALDO - $JUMLAH_SATUAN;
                    $this->db->where("LOGID", $LOGID);
                    if ($SALDOAKHIR > 0) {
                        $exec = $this->db->update('T_LOGBOOK_PEMASUKAN', array('SALDO' => $SALDOAKHIR));
                    } else {
                        $exec = $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => '1', 'SALDO' => $SALDOAKHIR));
                    }
                    if ($exec) {
                        $RET = $DATAMASUK;
                        break;
                    }
                } else {
                    $this->db->where("LOGID", $LOGID);
                    $this->db->update('T_LOGBOOK_PEMASUKAN', array('FLAG_TUTUP' => '1', 'SALDO' => 0));
                }
            }
        }
        return $RET;
    }

}

?>
