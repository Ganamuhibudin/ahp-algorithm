<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
$func = get_instance();
$dokumen = $dokumen;
$tmp_asal = $tmp_asal;
$jns_barang = $jns_barang;
$aju = $aju;
$tipeproses = $tipeproses;
?>	
<?php if($aju){ ?>
<a href="javascript:void(0)" onclick="Cekstatus('<?=site_url()."/pengeluaran/cekstatus/".$aju."/bc41"?>');" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-warning"><i class="icon-info-sign"></i> Cek Status</a>    
<a href="javascript: window.history.go(-1)" style="float:right;margin:4px 4px 0px 0px" class="btn btn-sm btn-success"><i class="icon-arrow-left"></i>Back</a>
<?php }else{ ?>
<span id="SpanStatus"></span>
<?php } ?>
<div class="header">
	<h3 class="blue"><strong><i class="fa fa-file-text-o"></i>&nbsp;<?=$judul?></strong></h3>
</div>
<div class="content">
	<div class="tabbable">
    	<ul class="nav nav-tabs" id="myTab">
    		<?php if($surat){ ?>
			<li><a data-toggle="tab" href="#tabsurat">Surat Permohonan </a></li>	
			<?php } ?>
        	<li class="active"><a data-toggle="tab" href="#tabHeader">Data Header</a></li>
        	<li><a data-toggle="tab" href="#tabBarang">Data Barang</a></li>
        	<li><a data-toggle="tab" href="#tabKemasan">Data Kemasan</a></li>
        	<li><a data-toggle="tab" href="#tabDokumen">Data Dokumen</a></li>
        	<?php if($flagrevisi){ ?>
			<li><a data-toggle="tab" href="#tabRealisasi">Data Realisasi</a></li>	
			<?php } ?>
    	</ul>		
        <div class="tab-content">
        	<?php if($surat){ ?>
        	<div id="tabsurat" class="tab-pane">
            	<?php 
                $func->load->model("pengeluaran_act");
                $data = $func->pengeluaran_act->get_pengeluaran($tipeproses,$dokumen,$tmp_asal,$jns_barang,$aju); 
                $this->load->view('pengeluaran/surat', $data);	
            	?>
        	</div>	
    		<?php } ?>
    		<div id="tabHeader" class="tab-pane active">
			<?php 
				$func->load->model("bc41/header_act");
				$data = $func->header_act->get_header($aju);
				$this->load->view("pengeluaran/bc41/Header", $data);
			?>
    		</div>
    		<div id="tabBarang" class="tab-pane">
    		<?php 		
				if($aju){			
					$func->load->model("bc41/detil_act");	
					$arrdata = $func->detil_act->detil('barang',$dokumen,$aju,'edit',$PERBAIKAN);
	 				$list = $this->load->view('view', $arrdata, true); 
				}
				$func->load->model("bc41/barang_act");
				$data = $func->barang_act->get_barang($aju);	
				if($aju)$data = array_merge($data,array('list' => $list));
				$this->load->view("pengeluaran/bc41/Barang", $data);
			?>
    		</div>
   			<div id="tabKemasan" class="tab-pane">
            <?php 
				if($aju){			
					$func->load->model("bc41/detil_act");	
					$arrdata = $func->detil_act->detil('kemasan',$dokumen,$aju,'edit');
	 				$list = $this->load->view('view', $arrdata, true); 
				}
				$func->load->model("bc41/kemasan_act");
				$data = $func->kemasan_act->get_kemasan($aju, $seri); 
				if($aju)$data = array_merge($data,array('list' => $list)); 	
				$this->load->view("pengeluaran/bc41/Kemasan", $data);
			?>
    		</div>
    		<div id="tabDokumen" class="tab-pane">
    		<?php 
				if($aju){			
					$func->load->model("bc41/detil_act");	
					$arrdata = $func->detil_act->detil('dokumen',$dokumen,$aju,'edit');
	 				$list = $this->load->view('view', $arrdata, true); 
				}
				$func->load->model("bc41/dokumen_act");
				$data = $func->dokumen_act->get_dokumen($aju, $seri); 
				if($aju)$data = array_merge($data,array('list' => $list)); 	
				$this->load->view("pengeluaran/bc41/Dokumen", $data);
			?>
    		</div>
    		<?php if($flagrevisi){ ?>
    		<div id="tabRealisasi" class="tab-pane">
    			<input type="hidden" id="xDokPabean" name="DOK_PABEAN" value="BC41" />
    			<input type="hidden" id="xNomorAju" name="NOMOR_AJU" value="<?=$aju?>" />
    			<?php
    			/*$func->load->model("revisi_act");
    			$data = $func->revisi_act->get_realisasi('bc41', $aju);
    			$this->load->view('tools/realisasi_out', $data);*/
    			?>
    		</div>
   		 <?php } ?>
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
<?php 
/*if($editapproved){
	if($surat) $aktiftab=2; else $aktiftab=1;
?>	
<script>
var $tabs = $('#tabs').tabs({disabled: [0, 1, 2, 3, 4, 5, 6]});
 $tabs.tabs('enable', <?=$aktiftab?>)
            .tabs('select', <?=$aktiftab?>)
            .tabs("option","disabled", [0, 1, 2, 3, 4, 5, 6]);
</script>	
<?php 
}else{
	if($aju){ 
		echo '<script>$(function(){$("#tabs").tabs();})</script>';
	}else{
		echo '<script>$(function(){$("#tabs").tabs({disabled:[1,2,3,4,5]});})</script>';	
	}
}*/
?>