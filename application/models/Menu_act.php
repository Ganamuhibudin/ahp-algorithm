<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Class Menu_act untuk generate menu setiap user
*/
class Menu_act extends CI_Model{

  function createMenu() {
      $SQL = "SELECT A.KODE_MENU, A.KODE_MENU_PARENT, A.JUDUL, A.SUB_JUDUL, 
              A.URL, A.URL_TIPE, A.INDEX, A.TAMPIL_FLAG, A.CONTROLLER, B.AKSES , A.ICON_MENU
              FROM M_MENU A, M_MENU_USER B
              WHERE A.KODE_MENU = B.KODE_MENU AND A.TAMPIL_FLAG = 'Y'
              AND B.USER_ID = '" . $this->newsession->userdata("USER_ID") . "'
              ORDER BY A.KODE_MENU_PARENT, A.INDEX ASC";
      $rs = $this->db->query($SQL);
      if ($rs->num_rows() > 0) {
          foreach ($rs->result_array() as $row) {
              $data[$row["KODE_MENU_PARENT"]][] = array("KODE_MENU" => $row["KODE_MENU"],
                  "KODE_MENU_PARENT" => $row["KODE_MENU_PARENT"],
                  "JUDUL" => $row["JUDUL"],
                  "SUB_JUDUL" => $row["SUB_JUDUL"],
                  "URL" => $row["URL"],
                  "URL_TIPE" => $row["URL_TIPE"],
                  "INDEX" => $row["INDEX"],
                  "CONTROLLER" => $row["CONTROLLER"],
				          "ICON_MENU" => $row["ICON_MENU"]
              );
          }
          $uri = $this->uri->segment(1);
          $addClass = "";
          if ($uri == "" || $uri == "home") {
            $addClass = " class='active' ";
          }
          $menu = '<li '.$addClass.'><a href="'.site_url().'/home">Home</a></li>';
          $getmenu = $this->drawMenu($data);
          $menu = $menu.$getmenu;
      }
      return $menu;
  }

  function drawMenu($data, $parent = 1, $inc = 0) {
    error_reporting(E_ALL ^ E_NOTICE);
    static $i = 1;
    if ($data[$parent]) {
      if ($parent != 1) {
          $addClass = ' class="dropdown" ';
          if ($this->uri->segment(1) == $data[1][$inc]["CONTROLLER"]) {
            $addClass = ' class="active" ';
          }
          $html .= '<li '.$addClass.'>';
          $html .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$data[1][$inc]["JUDUL"].'<b class="caret"></b></a>';
          $html .= '<ul class="dropdown-menu">';
      }
      $i++;
      for ($c = 0; $c < count($data[$parent]); $c++) {
          $child = $this->drawMenu($data, $data[$parent][$c]["KODE_MENU"], $inc++);
          if ($parent != 1) {
              $html .= '<li>';
              if ($data[$parent][$c]["URL_TIPE"] == 'javascript') {
                  $html .= '<a href="javascript:void(0)" onClick="' . $data[$parent][$c]["URL"] . '">' . $data[$parent][$c]["JUDUL"] . '</a>';
              } elseif ($data[$parent][$c]["URL_TIPE"] == 'base_url') {
                  $html .= '<a href="' . base_url() . $data[$parent][$c]["URL"] . '">' . $data[$parent][$c]["JUDUL"] . '</a>';
              } else {
                  $html .= '<a href="' . site_url() . '/' . $data[$parent][$c]["URL"] . '">' . $data[$parent][$c]["JUDUL"] . '</a>';
              }
          }
          if ($child) {
              $i--;
              $html .= $child;
          }
          if ($parent == 1) {
              $html .= '</ul>';
          }
          $html .= '</li>';
      }
      return $html;
    } else {
      $html = "";
      return false;
    }
  }
  	function akses($kodemenu=""){		
		$func = get_instance();
		$func->load->model("main");
		$sql = "SELECT KODE_ROLE,KODE_MENU,USER_ID,AKSES FROM M_MENU_USER WHERE USER_ID='".$this->newsession->userdata('USER_ID')."'";
		if($func->main->get_result($sql)){
			foreach ($sql->result_array() as $row){
				$akses[$row['KODE_MENU']] = $row['AKSES'];
			}
			return $akses[$kodemenu];
		}
		return array();
	}

  function notif($tipe = "") {
        $func = get_instance();
        $func->load->model("main");
        $this->load->library('newtable');
        $KODE_TRADER = $this->newsession->userdata('KODE_TRADER');
        $ciuri = (!$this->input->post("ajax")) ? $this->uri->segment_array() : $this->input->post("uri");
        $sqlBarang = "SELECT LOGID, TGL_DOK FROM t_logbook_pemasukan WHERE SALDO > '0' AND KODE_TRADER = '" . $KODE_TRADER . "'";
        $res = $this->db->query($sqlBarang);
        $hampir = 0;
        $kadaluarsa = 0;
        if ($res->num_rows() > 0) {
            $now = date("Y-m-d");
            foreach ($res->result_array() as $row) {
                $tgl = $row['TGL_DOK'];
                $thn = substr($tgl, 0, 4) + 1;
                    $bln = substr($tgl, 5, 2);
                    $blnNow = substr($now, 5, 2) + 1;
                    $blnNow = "0" . $blnNow;
                    $tgl_banding = substr_replace($tgl, $thn, 0, 4);
                    #echo $thn.",".date("Y").",".$bln.",".$blnNow;die();
                    if (($thn == date("Y")) && ($bln == $blnNow)) {
                        $logid = $logid . $row['LOGID'] . ",";
                        $hampir++;
                    }
                    if ($tgl_banding <= $now) {
                        $logid = $logid . $row['LOGID'] . ",";
                        $kadaluarsa++;
                    }else{ 
                      $logid = $logid."0,";
                    }
            }
            $logid = rtrim($logid, ",");
            $ID = "AND LOGID IN(" . $logid . ")";
        }
        /*if(empty($logid)){
            return "<center><b>Data tidak ditemukan</b></center>";
            die();
        }*/
        $SQL = "SELECT count(LOGID) AS COUNT FROM t_logbook_pemasukan WHERE SALDO > '0' ".$ID." AND KODE_TRADER = '" . $KODE_TRADER . "'";
        $count = $func->main->get_uraian($SQL,"COUNT");
        $html = " <li class=\"button dropdown\">
                    <a data-toggle=\"dropdown\" class=\"dropdown-toggle\" href=\"javascript:;\">
                        <i class=\"fa fa-globe\"></i>";
        if($count>0){
          $html.= "<span class=\"bubble\">".$count."</span>";
        }
        $html .= "        </a>
                      <ul class=\"dropdown-menu\">
                         
                              
                                <div class=\"content\" tabindex=\"0\" style=\"height:8em\">
                                  <ul>";
         if($hampir>0 || $kadaluarsa>0){
         	if($hampir>0){
	          $html .= "<li style=\"background-color:RGBA(255, 225, 2, 0.1)\"><a href=\"".site_url()."/inventory/outOfDate#tab-hampir\"><table width=\"100%\">
	                                        <tr><td valign=\"top\"><span style=\"color:#ffb752;font-size:15px;padding-right:5px\"><i class=\"icon-info-sign\"></i></span></td>
	                                        <td><span style=\"color:#2494f2\"><b>Terdapat <strong>".$hampir."</strong> dokumen pemasukan yang<br> hampir 1 Tahun dan saldo masih ada.</b></span></td>
	                                        </tr></table></a></li>";
	        }
	        if($kadaluarsa>0){
	          $html .= "<li style=\"background-color:RGBA(254, 0, 0, 0.1)\"><a href=\"".site_url()."/inventory/outOfDate#tab-kadaluarsa\"><table width=\"100%\">
	                                        <tr><td valign=\"top\"><span style=\"color:#e44c34;font-size:15px;padding-right:5px\"><i class=\"icon-info-sign\"></i></span></td>
	                                        <td><span style=\"color:#2494f2\"><b>Terdapat <strong>".$kadaluarsa."</strong> dokumen pemasukan yang<br> lebih dari 1 Tahun dan saldo masih ada.</b></span></td>
	                                        </tr></table></a></li>";
	         }
         }else{
          $html .= "<li><table width=\"100%\">
                        <tr><td align=\"center\"><span style=\"color:#2494f2\"><br><b>Tidak ada Notifikasi</b></span></td>
                        </tr></table></li>";
         }                          

        $html .= "                </ul>
                                </div>
                                <div class=\"pane\" style=\"display: none;\">
                                    <div class=\"slider\" style=\"height: 20px; top: 0px;\"></div>
                                  </div>
                      </ul>
                  </li>";

        return $html;
    }
}