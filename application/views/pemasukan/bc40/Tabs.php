<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

$func = get_instance();
$dokumen = $dokumen;
$jns_barang = $jns_barang;
$aju = $aju;
$tipeproses = $tipeproses;
?>

<?php if($aju){ ?>
<a href="javascript:void(0)" onclick="Cekstatus('<?=site_url()."/pemasukan/cekstatus/".$aju."/bc40"?>');" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-warning"><i class="icon-info-sign"></i> Cek Status</a>    
<a href="javascript: window.history.go(-1)" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-success"><i class="icon-arrow-left"></i>Back</a>
<?php } ?>
<div class="header">
	<h3 class="orange"><i class="fa fa-file-text-o"></i>&nbsp;<strong><?=$judul?></strong></h3>
</div>
<div class="content">
  <div class="tabbable">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a data-toggle="tab" href="#tabHeader">Data Header</a></li>
      <li><a data-toggle="tab" href="#tabBarang">Data Barang</a></li>
      <li><a data-toggle="tab" href="#tabKemasan">Data Kemasan</a></li>
      <li><a data-toggle="tab" href="#tabDokumen">Data Dokumen</a></li>
    </ul>
    <div class="tab-content">
      <div id="tabHeader" class="tab-pane active">
        <?php 
			$func->load->model("bc40/header_act");
			$data = $func->header_act->get_header($aju);
			$this->load->view("pemasukan/bc40/Header",$data);	
		?>
      </div>
      <div id="tabBarang" class="tab-pane">
        <?php
			if ($aju) {
				$func->load->model("bc40/detil_act");
				$arrdata = $func->detil_act->detil('barang', $dokumen, $aju, 'edit');
				$list = $this->load->view('view', $arrdata, true);
			}
			$func->load->model("bc40/barang_act");
			$data = $func->barang_act->get_barang($aju);
			if ($aju) $data = array_merge($data, array('list' => $list));
        	$this->load->view("pemasukan/bc40/Barang",$data);
		?>
      </div>
      <div id="tabKemasan" class="tab-pane">
        <?php
			if ($aju) {
				$func->load->model("bc40/detil_act");
				$arrdata = $func->detil_act->detil('kemasan', $dokumen, $aju, 'edit');
				$list = $this->load->view('view', $arrdata, true);
			}
			$func->load->model("bc40/kemasan_act");
			$data = $func->kemasan_act->get_kemasan($aju, $seri);
			if ($aju) $data = array_merge($data, array('list' => $list));
        	$this->load->view("pemasukan/bc40/Kemasan",$data);
		?>
      </div>
      <div id="tabDokumen" class="tab-pane">
         <?php
		 	if ($aju) {
				$func->load->model("bc40/detil_act");
				$arrdata = $func->detil_act->detil('dokumen', $dokumen, $aju, 'edit');
				$list = $this->load->view('view', $arrdata, true);
			}
			$func->load->model("bc40/dokumen_act");
			$data = $func->dokumen_act->get_dokumen($aju, $seri);
			if ($aju)
            $data = array_merge($data, array('list' => $list));
        	$this->load->view("pemasukan/bc40/Dokumen",$data);
		?>
      </div>
    </div>
  </div>
</div>
<script>
<?php if(!$aju){?>
$(".tabbable ul.nav li a").addClass('disabled');
$(".nav-tabs a[data-toggle=tab]").on("click", function(e) { 
  if($(this).hasClass("disabled")) {
    e.preventDefault();
    return false;
  }
});
<?php } ?>
</script>