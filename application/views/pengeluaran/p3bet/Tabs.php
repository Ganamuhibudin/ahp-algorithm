<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);

$func = get_instance();
$dokumen = $dokumen;
$aju = $aju;
?>

<?php if($aju){ ?>
<a href="javascript:void(0)" onclick="Cekstatus('<?=site_url()."/pengeluaran/cekstatus/".$aju."/p3bet"?>');" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-warning"><i class="icon-info-sign"></i> Cek Status</a>    
<a href="javascript: window.history.go(-1)" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-success"><i class="icon-arrow-left"></i>Back</a>
<?php }else{ ?>
<span id="SpanStatus"></span>
<?php } ?>
<div class="header">
	<h3 class="blue"><strong><?=$judul?></strong></h3>
</div>
<div class="content">
  <div class="tabbable">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a data-toggle="tab" href="#tabHeader">Data Header</a></li>
      <li><a data-toggle="tab" href="#tabBarang">Data Barang</a></li>
      <li><a data-toggle="tab" href="#tabKemasan">Data Kemasan</a></li>
    </ul>
    <div class="tab-content">
      <div id="tabHeader" class="tab-pane active">
        <?php 
          $func->load->model("p3bet/header_act");
          $data = $func->header_act->get_header($aju);
          $this->load->view("pengeluaran/p3bet/Header",$data); 
        ?>
      </div>
      <div id="tabBarang" class="tab-pane">
       <?php
          if ($aju) {
             $func->load->model("p3bet/detil_act");
             $arrdata = $func->detil_act->detil('barang', $dokumen, $aju, 'edit');
             $list = $this->load->view('view', $arrdata, true);
           }
           $func->load->model("bc28/barang_act");
           $data = $func->barang_act->get_barang($aju);
           if ($aju) $data = array_merge($data, array('list' => $list));
           $this->load->view("pengeluaran/p3bet/Barang",$data);
        ?>
      </div>
      <div id="tabKemasan" class="tab-pane">
        <?php 
			if($aju){			
				$func->load->model("bc28/detil_act");	
				$arrdata = $func->detil_act->detil('kemasan',$dokumen,$aju,'edit');
	 			$list = $this->load->view('view', $arrdata, true); 
			}
			$func->load->model("bc28/kemasan_act");
			$data = $func->kemasan_act->get_kemasan($aju, $seri); 
			if($aju)$data = array_merge($data,array('list' => $list)); 	
			$this->load->view("pengeluaran/p3bet/Kemasan", $data);
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