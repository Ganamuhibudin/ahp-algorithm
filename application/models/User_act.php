<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_act extends CI_Model
{
    function verify($uid_, $pwd_, $adm = FALSE) {
        $query = "SELECT A.USER_ID, A.KODE_TRADER, A.USERNAME, A.PASSWORD, A.NAMA, A.ALAMAT, A.TELEPON, A.JABATAN, 
				A.EMAIL, A.STATUS,C.KODE_ROLE, C.NAMA AS NAMA_ROLE, D.NAMA 'NAMA_TRADER',D.LOGO 
				FROM t_user A, t_user_role B, m_role C , m_trader D
				WHERE A.USER_ID = B.USER_ID AND B.KODE_ROLE = C.KODE_ROLE 
				AND A.KODE_TRADER=D.KODE_TRADER AND A.USERNAME=" . $this->db->escape($id_) . " AND A.PASSWORD='$pwd_' AND STATUS='1'";
        $data = $this->db->query($query);
        if ($data->num_rows() > 0) {
            $role = array();
            $klasifikasi = array();
            $rs = $data->row();
            foreach ($data->result_array() as $row) {
                $datses['LOGGED'] = true;
                $datses['IP'] = $_SERVER['REMOTE_ADDR'];
                $datses['USER_ID'] = $row['USER_ID'];
                $datses['USER_NAME'] = $uid_;
                $datses['PASSWORD'] = $pwd_;
                $datses['NAMA'] = $row['NAMA'];
                $datses['EMAIL'] = $row['EMAIL'];
                $datses['ALAMAT'] = $row['ALAMAT'];
                $datses['KODE_TRADER'] = $row['KODE_TRADER'];
                $datses['NAMA_TRADER'] = $row['NAMA_TRADER'];
                $datses['LOGO'] = $row['LOGO'];
                $datses['KODE_ROLE'] = $row['KODE_ROLE'];
                $datses['NAMA_ROLE'] = $row['NAMA_ROLE'];
                $datses['JABATAN'] = $row['JABATAN'];
            }
            date_default_timezone_set('Asia/Jakarta');
            $data = array('LAST_LOGIN' => date('Y-m-d H:i:s'));
            $this->db->where('USER_ID', $rs->USER_ID);
            $this->db->update('t_user', $data);
            $this->newsession->set_userdata($datses);
            return 1;
        } else {
            return 0;
        }
    }

    function login($uid_, $pwd_, $adm = FALSE) {
        $query = "SELECT a.id_user, a.id_role, c.role, a.id_divisi, b.divisi, a.email, 
                a.nik, a.nama, c.role, a.ext, a.status
				FROM tbl_user a
                LEFT JOIN tbl_divisi b ON b.id_divisi = a.id_divisi
                LEFT JOIN tbl_role c ON c.id_role = a.id_role
				WHERE a.email = " . $this->db->escape($uid_) . " 
				AND a.password = '" . $pwd_ . "' 
                AND a.status = '1'";
        $data = $this->db->query($query);
        if ($data->num_rows() > 0) {
            $rs = $data->row();
            if ($rs->status == "0") {
                return "3";
                die();
            }
            foreach ($data->result_array() as $row) {
                $datses['logged']   = true;
                $datses['id_user']  = $row['id_user'];
                $datses['email']    = $uid_;
                $datses['password'] = $pwd_;
                $datses['nama']     = $row['nama'];
                $datses['nik']      = $row['nik'];
                $datses['email']    = $row['email'];
                $datses['id_role']  = $row['id_role'];
                $datses['role']     = $row['role'];
                $datses['id_divisi']= $row['id_divisi'];
                $datses['divisi']   = $row['divisi'];
                $datses['ext']      = $row['ext'];
                $datses['status']   = $row['status'];
            }
            date_default_timezone_set('Asia/Jakarta');
            $data = array('last_login' => date('Y-m-d H:i:s'));
            $this->db->where('id_user', $rs->id_user);
            $this->db->update('tbl_user', $data);
            $this->newsession->set_userdata($datses);

            return 1;
        } else {
            return 0;
        }
    }

    function daftar($ajax = "") {
        $this->load->library('newtable');
        $id_user = $this->newsession->userdata('id_role');
        $title = "List Data User";
        if ($id_user == 2) {
            $addSql = " WHERE a.id_role <> 1";
        } else {
            $addSql = "";
        }
        $SQL = "SELECT a.id_user, a.id_role, a.id_divisi, a.nama, a.email, a.nik, b.role, c.divisi
                FROM tbl_user a
                LEFT JOIN tbl_role b ON b.id_role = a.id_role 
                LEFT JOIN tbl_divisi c ON c.id_divisi = a.id_divisi " . $addSql;
        $prosesnya = array(
            'Tambahx' => array('GET',site_url().'/user/create', '0','icon-plus'),
            'Ubah'   => array('EDITJS', site_url().'/user/edit', '1','icon-edit'),
            'Hapus'  => array('DELETE', site_url().'/user/delete', 'divisi','red icon-remove'),
            'Reset Password' => array('PROCESS', site_url()."/user/resetPassword", 'user','fa fa-refresh'),
        );
        $this->newtable->search(array(
            array('a.nama', 'Nama'),
            array('a.email', 'Email'),
            array('a.nik', 'Nik'),
            array('b.role', 'Role'),
            array('c.divisi', 'Divisi'),
        ));
        $this->newtable->action(site_url() . "/user/userlist");
        $this->newtable->hiddens(array('id_user', 'id_role', 'id_divisi'));
        $this->newtable->keys(array('id_user'));
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->tipe_proses('button');
        $this->newtable->orderby(1);
        $this->newtable->sortby("ASC");
        $this->newtable->set_formid("fuser");
        $this->newtable->set_divid("divuser");
        $this->newtable->rowcount(15);
        $this->newtable->clear();
        $this->newtable->menu($prosesnya);
        $tabel = $this->newtable->generate($SQL);
        $arrdata = array(
            "title" => $title,
            "tabel" => $tabel,
            "jenis" => $jenis,
            "tipe" => "user"
        );
        if ($this->input->post("ajax")||$ajax=="ajax"){
            return $tabel;
        } else {
            return $arrdata;
        }
    }

    function getData($tipe = "", $id = "") {
        if ($tipe == 'divisi') {
            $sql = "SELECT id_divisi, divisi FROM tbl_divisi";
            $doSql = $this->db->query($sql)->result_array();
            $response = array();
            foreach ($doSql as $value) {
                $response[$value['id_divisi']] = $value['divisi'];
            }
        } elseif ($tipe == 'role') {
            $sql = "SELECT id_role, role FROM tbl_role";
            $doSql = $this->db->query($sql)->result_array();
            $response = array();
            foreach ($doSql as $value) {
                $response[$value['id_role']] = $value['role'];
            }
        } elseif ($tipe == 'user') {
            $sql = "SELECT a.*, b.role, c.divisi
                    FROM tbl_user a
                    LEFT JOIN tbl_role b ON b.id_role = a.id_role
                    LEFT JOIN tbl_divisi c ON c.id_divisi = a.id_divisi
                    WHERE a.id_user = '".$id."'";
            $doSql = $this->db->query($sql)->row_array();
            $response = $doSql;
        }
        return $response;
    }

    function proses_form($id="") {
        $conn = get_instance();
        $conn->load->model("main");
        $act = $this->input->post('act');
        $id_user = $this->input->post('id_user');
        foreach ($this->input->post('data') as $a => $b){
            $user[$a] = $b;
        }
        if ($act == "save") {
            $sqlValidasi = "SELECT id_user FROM tbl_user WHERE email = '" . $user['email'] . "'";
            $doValidasi = $this->db->query($sqlValidasi);
            if ($doValidasi->num_rows() > 0) {
                echo "MSG#ERR#Simpan data Gagal. Data user sudah ada.";
            } else {
                $user['status'] = '1';
                $user['password'] = md5($user['password']);
                $exec = $this->db->insert('tbl_user', $user);
                if ($exec) {
                    $conn->main->activity_log('ADD USER', $user['nama']);
                    echo "MSG#OK#Simpan data Berhasil#".site_url()."/user/userlist";
                } else {
                    echo "MSG#ERR#Simpan data Gagal#".site_url()."/user/userlist";
                }
            }
        } else if ($act == "update") {
            $sqlValidasi = "SELECT id_user FROM tbl_user 
                            WHERE id_user <> '" . $id_user . "'
                            AND email = '" . $user['email'] . "'";
            $doValidasi = $this->db->query($sqlValidasi);
            if ($doValidasi->num_rows() > 0) {
                echo "MSG#ERR#Simpan data Gagal. Data user sudah ada.";
            } else {
                unset($user['password']);
                $this->db->where(array(
                    'id_user' => $id_user
                ));
                $exec = $this->db->update('tbl_user', $user);
                if ($exec) {
                    $conn->main->activity_log('EDIT USER', $user['nama']);
                    echo "MSG#OK#Simpan data Berhasil#".site_url()."/user/userlist";
                } else {
                    echo "MSG#ERR#Simpan data Gagal#".site_url()."/user/userlist";
                }
            }
        } elseif ($act == "process") {
            # reset password
            $data = $this->input->post('tb_chkfuser');
            if (count($data) > 1) {
                $ret = "MSG#ERR#Data yang dapat diproses hanya satu (1).";
                return $ret;
            } else {
                $id_user = $data[0];
                $sql = "SELECT nik FROM tbl_user WHERE id_user = '".$id_user."'";
                $doSql = $this->db->query($sql)->row_array();
                $this->db->where(array('id_user' => $id_user));
                $update = $this->db->update('tbl_user', array(
                    'password' => md5($doSql['nik'])
                ));
                if ($update) {
                    $ret = "MSG#OK#Password user berhasil di reset#" . site_url() . "/user/userlist/ajax";
                } else {
                    $ret = "MSG#ERR#Reset password gagal!";
                }
                return $ret;
            }
        } else {
            $ret = "MSG#Hapus data Gagal";
            $dataCheck = $this->input->post('tb_chkfuser');
            foreach ($dataCheck as $chkitem) {
                $id_user = $chkitem;
                $user = $this->getData('user', $id_user);
                $this->db->where(array('id_user' => $id_user));
                $this->db->delete('tbl_user');
                $conn->main->activity_log('DELETE USER', 'USER=' . $user['nama']);
            }
            $ret = "MSG#OK#Hapus data Berhasil#" . site_url() . "/user/userlist/ajax";
            echo $ret;
        }
    }

    function cekEkspiredDate($date = "") {
        if (date('Y-m-d') >= $date)
            return true;
        else
            return false;
    }

    function forgot() {
        $conn = get_instance();
        $conn->load->model("main", "main", true);
        $usr 	= $this->input->post('USERNAME');
        $email 	= $this->input->post('EMAIL');
        $kode 	= $this->input->post('CODE');
        
		$this->load->helper('email');
        if (!valid_email($email)) {
            return "MSG#ERR#Email tidak valid, periksa kembali email anda.";die();
        }
		if(strtolower($kode)===$_SESSION['captkodex']){
			$SQLUser = "SELECT USERNAME FROM t_user WHERE USERNAME = '".$usr."'";
			$dtUser = $this->db->query($SQLUser);
			if ($dtUser->num_rows() > 0) {
				$SQLEmail = "SELECT EMAIL FROM t_user WHERE EMAIL = '".$email."'";
				$dtemail = $this->db->query($SQLEmail);
				if ($dtemail->num_rows() > 0) {
					$SQL = "SELECT A.USER_ID,A.EMAIL,A.NAMA,A.USERNAME FROM t_user A, m_trader B WHERE A.KODE_TRADER=B.KODE_TRADER 
							AND A.USERNAME='".$usr."' AND A.EMAIL='".$email."'";
					$data = $conn->main->get_result($SQL);
					if ($data) {
						foreach ($SQL->result() as $row) {
							$email = $row->EMAIL;
							$nama = $row->NAMA;
							$userid = $row->USER_ID;
							$username = $row->USERNAME;
							$pwd = str_shuffle("0123456789");
							$pwd = substr($pwd, 3, 6);
							$subject = "Lupa Password";
							$isi = 'Password Akun Anda di ' . base_url() . ' telah diubah oleh sistem. Silahkan login dengan:<table style="margin: 4px 4px 12px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">Username</td><td>: <b>' . $username . '</b></td></tr><tr><td>Password</td><td>: <b>' . $pwd . '</b></td></tr></table>Terima kasih.';
							if ($conn->main->send_mail($email, $nama, $subject, $isi)) {
								$this->db->where('USER_ID', $userid);
								if ($this->db->update('T_USER', array("STATUS" => "1", "PASSWORD" => md5($pwd)))) {
									$conn->main->activity_log('RESET PASSWORD');
									return "MSG#OK#Password Anda berhasil di reset. Silahkan cek email Anda.";
								}
							} else {
								return "MSG#ERR#Send Mail Error.";
							}
						}
					} else {
						return "MSG#ERR#Data yang anda masukan salah.";
					}
				} else {
					return "MSG#ERR#Email belum terdaftar.";
				}
			} else {
				return "MSG#ERR#Username belum terdaftar.";
			}
		}else{
			return "MSG#ERR#Kode Captcha salah.";
		}
    }

    function ubahpassword($isajax) {
        if ($this->newsession->userdata('LOGGED')) {
            $conn = get_instance();
            $conn->load->model("main", "main", true);
            if (md5($this->input->post('oldpwd')) == $this->newsession->userdata('PASSWORD')) {
                $arrpwd = array('PASSWORD' => md5($this->input->post('pwd')));
                $this->db->where('USER_ID', $this->newsession->userdata('USER_ID'));
                $id = $this->newsession->userdata('USER_ID');
                $pwd = $this->input->post('pwd');
                if ($this->db->update('T_USER', $arrpwd)) {
                    $this->newsession->set_userdata('PASSWORD', md5($this->input->post('pwd')));
                    if ($isajax != "ajax") {
                        redirect(base_url());
                        exit();
                    }
                    $query = "SELECT NAMA, EMAIL, USER_NAME FROM t_user WHERE USER_ID = '$id'";
                    $dt = $conn->main->get_result($query);
                    if ($dt) {
                        foreach ($query->result() as $row) {
                            $email = $row->EMAIL;
                            $nama = $row->NAMA;
                            $userid = $row->USER_NAME;
                            $subject = "Ubah Password";
                            $isi = 'Password Akun Anda di ' . base_url() . ' telah diubah. Silahkan login dengan:<table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">Username</td><td>: <b>' . $userid . '</b></td></tr><tr><td>Password</td><td>: <b>' . $pwd . '</b></td></tr></table>Terima kasih.';
                            $conn->main->send_mail($email, $nama, $subject, $isi);
                        }
                    }
                    $conn->main->activity_log('UBAH PASSWORD');
                    return "MSG#OK#Ubah Password Berhasil#" . site_url();
                }
            }
            if ($isajax != "ajax") {
                redirect(base_url());
                exit();
            }
            return "MSG#ERR#Ubah Password Gagal";
        } else {
            redirect(base_url());
            exit();
        }
    }

    function ubahprofil($isajax) {
        if ($this->newsession->userdata('LOGGED')) {
            $conn = get_instance();
            $conn->load->model("main", "main", true);
            $arrdata = array('NAMA' => $this->input->post('nama'),
                'JABATAN' => $this->input->post('jabatan'),
                'EMAIL' => $this->input->post('email'));
            if ($this->newsession->userdata('TRADER_ID') == 0)
                $arrdata['NIP'] = $this->input->post('nip');
            $this->db->where('USER_ID', $this->newsession->userdata('USER_ID'));
            if ($this->db->update('T_USER', $arrdata)) {
                $this->newsession->set_userdata($arrdata);
                if ($isajax != "ajax") {
                    redirect(base_url());
                    exit();
                }
                $conn->main->activity_log('UBAH PROFIL');
                return "MSG#OK#Ubah Profil Berhasil#" . site_url();
            }
            if ($isajax != "ajax") {
                redirect(base_url());
                exit();
            }
            return "MSG#ERR#Ubah Profil Gagal";
        } else {
            redirect(base_url());
            exit();
        }
    }

    function kontak($nama, $email, $pertanyaan) {
        $conn = get_instance();
        $conn->load->model("main", "main", true);
        $to = "juniuszega18@gmail.com;ratna.febianita@yahoo.com";
        $nma = "Administrator GB Inventory";
        $nm = $nama;
        $from = $email;
        $tanya = $pertanyaan;
        $subject = "Kontak Kami";
        $isi = '<table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">Nama</td><td>: ' . $nm . '</td></tr><tr><td>Email</td><td>: ' . $from . '</td></tr><tr><td valign="top">Pertanyaan</td><td valign="top">: ' . $tanya . '</td></tr></table>';
        if ($conn->main->send_mail($to, $nma, $subject, $isi)) {
            $ret = "MAIL";
        } else {
            $ret = "ERRMAIL";
        }

        return $ret;
    }

    function activitylog() {
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");

        if (!is_array($ciuri)) {
            $url = explode("|", $ciuri);
        }

        if ($key = array_search('search', $url)) {
            $cari = $url[$key + 2];
            if ($cari != "") {
                $ADDSQL = "";
            } else {
                $ADDSQL = "AND ACTIVITY_DATE > DATE_SUB(SYSDATE(),INTERVAL 30 DAY)";
            }
        } else {
            $ADDSQL = "AND ACTIVITY_DATE > DATE_SUB(SYSDATE(),INTERVAL 30 DAY)";
        }

        $SQL = "SELECT LOGID, USER_ID, f_username(USER_ID) USERNAME, IP_ADDRESS 'IP&nbsp;ADDRESS', ACTIVITY_DATE 'ACTIVITY DATE', 
		        ACTION, REMARK, TIPE FROM T_LOG_ACTIVITY
		        WHERE KODE_TRADER='" . $KODE_TRADER . "' " . $ADDSQL;

        $combo = $func->main->get_combobox("SELECT USER_ID,USERNAME FROM T_USER WHERE KODE_TRADER='" . $KODE_TRADER . "'", "USER_ID", "USERNAME", TRUE);

        $this->newtable->search(array(array('ACTION', 'ACTION'),
            array('REMARK', 'REMARK'),
            array('ACTIVITY_DATE', 'ACTIVITY DATE&nbsp;', 'tag-tanggal'),
            array('USER_ID', 'USERNAME', 'tag-select', $combo)
        ));


        $this->newtable->action(site_url() . "/user/activitylog");
        $this->newtable->hiddens(array('LOGID', 'TIPE', 'USER_ID'));
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->set_formid("flog");
        $this->newtable->set_divid("divflog");
        $this->newtable->orderby(5);
        $this->newtable->sortby("DESC");
        $this->newtable->rowcount(25);
        $this->newtable->show_chk(false);
        $this->newtable->clear();
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => 'Activity Log',
            "tabel" => $tabel);
        if ($this->input->post("ajax"))
            return $tabel;
        else
            return $arrdata;
    }

    function revisilog() {
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");

        if (!is_array($ciuri)) {
            $url = explode("|", $ciuri);
        }

        if ($key = array_search('search', $url)) {
            $cari = $url[$key + 2];
            if ($cari != "") {
                $ADDSQL = "";
            } else {
                $ADDSQL = "AND ACTIVITY_DATE > DATE_SUB(SYSDATE(),INTERVAL 30 DAY)";
            }
        } else {
            $ADDSQL = "AND ACTIVITY_DATE > DATE_SUB(SYSDATE(),INTERVAL 30 DAY)";
        }

        $SQL = "SELECT LOGID, USER_ID, f_username(USER_ID) USERNAME, IP_ADDRESS 'IP ADDRESS', ACTIVITY_DATE 'ACTIVITY DATE', 
		        ACTION, REMARK, TIPE, KETERANGAN FROM T_LOG_REVISI
		        WHERE KODE_TRADER='" . $KODE_TRADER . "' " . $ADDSQL;
        $combo = $func->main->get_combobox("SELECT USER_ID,USERNAME FROM T_USER WHERE KODE_TRADER='" . $KODE_TRADER . "'", "USER_ID", "USERNAME", TRUE);

        $this->newtable->search(array(array('ACTION', 'ACTION'),
            array('REMARK', 'REMARK'),
            array('ACTIVITY_DATE', 'ACTIVITY DATE&nbsp;', 'tag-tanggal'),
            array('USER_ID', 'USERNAME', 'tag-select', $combo)
        ));


        $this->newtable->action(site_url() . "/user/revisilog");
        $this->newtable->hiddens(array('LOGID', 'TIPE', 'USER_ID'));
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->set_formid("flogrevisi");
        $this->newtable->set_divid("divflogrevisi");
        $this->newtable->orderby(5);
        $this->newtable->sortby("DESC");
        $this->newtable->rowcount(25);
        $this->newtable->show_chk(false);
        $this->newtable->clear();
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => 'Revisi Log',
            "tabel" => $tabel);
        if ($this->input->post("ajax"))
            return $tabel;
        else
            return $arrdata;
    }

    function barangKadaluarsa($kd_trader) {
        $sql = "SELECT LOGID, TGL_DOK FROM t_logbook_pemasukan WHERE SALDO > '0' AND KODE_TRADER = '" . $kd_trader . "'";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $now = date("Y-m-d");
            $jml = array();
            foreach ($res->result_array() as $row) {
                $tgl = $row['TGL_DOK'];
                $thn = substr($tgl, 0, 4) + 1;
                $bln = substr($tgl, 5, 2);
                $blnNow = substr($now, 5, 2) - 1;
                if (count($blnNow) <= 1)
                    $blnNow = "0" . $blnNow;
                if (($thn == date("Y")) && ($bln == $blnNow)) {
                    $jml[] = $row['LOGID'];
                }
            }
            $jml = count($jml);
            if ($jml > 0) {
                $rtn = "<p><b>Anda memiliki (" . $jml . ") dokumen pemasukan yang hampir 1 tahun tetapi saldo belum habis.";
                $rtn .= " Klik tombol dibawah ini untuk melihat lebih detail.</b></p>";
                $rtn .= '<center><a id="ok_" class="button search" onclick="showBarang()" href="javascript:void(0);">
                        <span><span class="icon"></span>Details</span></a></center>';
            } else {
                $rtn = "false";
            }
            return $rtn;
        }
    }

    function outOfDate($tipe = "") {
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $sqlBarang = "SELECT LOGID, TGL_DOK FROM t_logbook_pemasukan WHERE SALDO > '0' AND KODE_TRADER = '" . $KODE_TRADER . "'";
        $res = $this->db->query($sqlBarang);
        if ($res->num_rows() > 0) {
            $now = date("Y-m-d");
            foreach ($res->result_array() as $row) {
                $tgl = $row['TGL_DOK'];
                $thn = substr($tgl, 0, 4) + 1;
                if ($tipe == "hampir") {
                    $bln = substr($tgl, 5, 2);
                    $blnNow = substr($now, 5, 2) - 1;
                    if (count($blnNow) <= 1)
                        $blnNow = "0" . $blnNow;
                    if (($thn == date("Y")) && ($bln == $blnNow)) {
                        $logid = $logid . $row['LOGID'] . ",";
                    }
                } else {
                    $tgl_banding = substr_replace($tgl, $thn, 0, 4);
                    if ($tgl_banding <= $now) {
                        $logid = $logid . $row['LOGID'] . ",";
                    }
                }
            }
            $logid = rtrim($logid, ",");
        }
        if(empty($logid)){
            return "<center><b>Data tidak ditemukan</b></center>";
            die();
        }
        $SQL = "SELECT LOGID, JENIS_DOK 'Dokumen', NO_DOK 'Nomor Pendaftaran', TGL_DOK 'Tanggal Pendaftaran', KODE_BARANG 'Kode Barang', 
                NAMA_BARANG 'Nama Barang', SATUAN 'Satuan', SALDO 'Saldo'
                FROM t_logbook_pemasukan WHERE SALDO > '0' AND LOGID IN(" . $logid . ") AND KODE_TRADER = '" . $KODE_TRADER . "'";

        $this->newtable->search(array(array('NO_DOK', 'NOMOR PENDAFTARAN'), array('KODE_BARANG', 'KODE BARANG'),
            array('JENIS_DOK', 'DOKUMEN')));
        $this->newtable->action(site_url() . "/user/list_kadaluarsa/".$tipe);
        $this->newtable->hiddens(array('LOGID'));
        $this->newtable->cidb($this->db);
        $this->newtable->ciuri($ciuri);
        $this->newtable->set_formid("f".$tipe);
        $this->newtable->set_divid("div".$tipe);
        $this->newtable->orderby(5);
        $this->newtable->sortby("DESC");
        $this->newtable->rowcount(25);
        $this->newtable->show_chk(false);
        $this->newtable->clear();
        $tabel .= $this->newtable->generate($SQL);
        return $tabel;
    }

    function detil_tab() {
        $data = array('hampir' => $this->outOfDate("hampir"), 'kadaluarsa' => $this->outOfDate("kadaluarsa"));
        return $data;
    }

}

?>