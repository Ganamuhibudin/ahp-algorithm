<!-- <div class="header">
	<h5 class="header smaller lighter green"><b><?= $judul;?></b></h5>
    <hr/>
</div> -->
<div class="content">
<form name="f_cariListPopUp" id="f_cariListPopUp" action="<?php echo site_url('popup/getListPopUp')?>" method="post">
<table class="tabelPopUp" width="100%" style="margin-top:20px">
<tr class="hilite" style="border-bottom:solid 2px #E8E8E8">	
    <td align="right">
	<span>   
    <combo><select name="TIPE_CARI" id="TIPE_CARI" style="width:120px">
    	<? if($jenis=='kemasan' || $jenis=="kemasanBrg"){?>
            <option value="KODE_KEMASAN">Kode Kemasan</option>
            <option value="URAIAN_KEMASAN">Uraian Kemasan</option>
        <? }elseif($jenis=="konversi"){?>
            <option value="NOMOR_KONVERSI">Nomor Konversi</option>
            <option value="KODE_BARANG">Kode Barang</option>
            <option value="URAIAN_BARANG">Uraian Barang</option>
        <? }elseif($jenis=="satuanBrg"){?>
            <option value="KODE_SATUAN">Kode Satuan</option>
            <option value="URAIAN_SATUAN">Uraian Satuan</option>
        <? }elseif(($jenis=='pemasokBC27') || ($jenis=="pemasokBC261") || ($jenis=="pemasokBC262") || ($jenis=="pemasokBC40") || ($jenis=="pemasokBC41")){?>
            <option value="ID_PARTNER">ID</option>
            <option value="NAMA_PARTNER">Nama</option>
            <option value="ALAMAT_PARTNER">Alamat</option>
        <? }elseif(($jenis=='barang_jadi') || ($jenis=='bhnBku27') ||($jenis=='bhnBku261')){?>
            <option value="KODE_BARANG">Kode Barang</option>
            <option value="URAIAN_BARANG">Uraian Barang</option>
        <? }elseif(($jenis=="zoning_bc30") || ($jenis=="jns_PKB") || ($jenis=="gdng_PKB")|| ($jenis=="cara_STUFF") || ($jenis=="jnpartof")){?>
            <option value="KODE">Kode</option>
            <option value="URAIAN">Uraian</option>
        <? }?>
    </select></combo>
    <input type="text" name="URAI_CARI" id="URAI_CARI" class="tb_cari">
    <input type="button" name="cari" id="cari" class="btn btn-primary" style="vertical-align:top;height:100%;width:6%" onclick="cariData('<?= $type?>','<?= $jenis?>')" value="Cari">
    </span>
    </td>
</tr>

</table>
<input type="hidden" name="KEY" id="KEY" class="tb_cari" value="<?= $idValue;?>">
</form>
<div id="dataListPopup_<?=$jenis;?>" style="display:none;text-align:center"></div>
</div>
<script type="text/javascript">
loadData('<?= $type?>','<?= $jenis?>');
function cariData(type,jenis)
{
	var key=$("#KEY").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();//alert('sini');
    $.ajax({
      url: site_url+"/popup/getListPopUp",
      type: "POST",
      data: {index:1,type:type,jenis:jenis,typeCari:typeCari,uraiCari:uraiCari,key:key},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
	  success:function(data)
	  {
		$('#dataListPopup_'+jenis).show();
		$('#dataListPopup_'+jenis).html(data);
	  }
    });

}
function loadData(type,jenis)
{
	var key=$("#KEY").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
	$('#dataListPopup_'+jenis).show();
	$('#dataListPopup_'+jenis).html('<img src=\"'+base_url+'img/_ldg.gif\" alt=\"\" />');
    $.ajax({
      url: site_url+"/popup/getListPopUp",
      type: "POST",
      data: {index:1,type:type,jenis:jenis,typeCari:typeCari,uraiCari:uraiCari,key:key},
	  success:function(data)
	  {
		$(this).addClass('hilite');
		$('#dataListPopup_'+jenis).show();
		$('#dataListPopup_'+jenis).html(data);
	  }
    });
}
function get_next_data(index,type,jenis)
{
	var key=$("#KEY").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
    $.ajax({
      url: site_url+"/popup/getListPopUp",
      type: "POST",
      data: {index:index,type:type,jenis:jenis,typeCari:typeCari,uraiCari:uraiCari,key:key},
	  beforeSend: function(){jloadings();},
	  complete: function(){Clearjloadings();},
	  success:function(data)
		{
			$('#dataListPopup_'+jenis).show();
			$('#dataListPopup_'+jenis).html(data);
		}
    });

}
function goToPage(type,jenis)
{
	var key=$("#KEY").val();
	var typeCari=$("#TIPE_CARI").val();
	var uraiCari=$("#URAI_CARI").val();
	var index =  $("input#txtGoTo").val();
	index = parseInt(index);
	$.ajax({
	 url: site_url+"/popup/getListPopUp",
	type: "POST",
	data: {index:index,type:type,jenis:jenis,typeCari:typeCari,uraiCari:uraiCari,key:key},
	beforeSend: function(){jloadings();},
	complete: function(){Clearjloadings();},
	success:function(data)
		{
			$('#dataListPopup_'+jenis).show();
			$('#dataListPopup_'+jenis).html(data);
		}
	});

}
function getPopupKms(kodeKms,UrKms,jenis){
	var form;
	if(jenis=='kemasan') form="fkemasan_";
	else if(jenis=='kemasanBrg') form="fbarang_";
	//alert(form);
	var KodeKemasan=($("#"+form+" #KODE_KEMASAN").val());
	if(KodeKemasan==""){
		$("#"+form+" #urjenis_kemasan").append(UrKms);
	}else{
		$("#"+form+" #urjenis_kemasan").empty().append(UrKms);
	}
	 document.getElementById(form).KODE_KEMASAN.value = kodeKms;
	closedialog('divKemasan');
	$("#KODE_KEMASAN").focus();
}
function lihatDetKonversi(nomor,pageLoad)
{	
	if ($('#hideDetilKonversi_'+nomor).css('display') == "none")
	{
		$('.csDetilKonversi').hide();
		$('#hideDetilKonversi_'+nomor).show();	
		$('#detilDataKonversi_'+nomor).show();
		$('#detilDataKonversi_'+nomor).load(pageLoad);		
	}
	else
	{
		$('.csDetilKonversi').hide();
		$('#hideDetilKonversi_'+nomor).hide();
		$('#detilDataKonversi_'+nomor).hide();
	}
}
function getPopupKonversi(pageProses,divLoad,pageLoad){
		$.ajax({
			url: pageProses,
			success: function(data){
				$("#Tbldetilbahanbaku tbody tr").remove();					
				$("#Tbldetilbahanbaku tbody:first").append(data);
				$(".msg_").html('');
				closedialog('divKonversi');
			}
		});	
	return false;	
}
function getPopupSat(kodeSat,UrSat,jenis){
	var form;
	if(jenis=='satuanBrg') form="fbarang_";
	//alert(form);
	var KodeSatuan=($("#"+form+" #KODE_SATUAN").val());
	if(KodeSatuan==""){
		$("#"+form+" #urjenis_satuan").append(UrSat);
	}else{
		$("#"+form+" #urjenis_satuan").empty().append(UrSat);
	}
	 document.getElementById(form).KODE_SATUAN.value = kodeSat;
	closedialog('divSatuan');
	$("#KODE_SATUAN").focus();
}

function getPopupMTabel(kode,Ur,jenis){
	var form;
	if(jenis=='zoning_bc30' || jenis=='jns_PKB' || jenis=='gdng_PKB' || jenis=='jnpartof' || jenis=='cara_STUFF') form="Frm_PKB";	
	if(jenis=='zoning_bc30'){
		var ZONING_KITE=($("#"+form+" #ZONING_KITEE").val());//alert(kode);
		if(ZONING_KITE==""){
			$("#"+form+" #urZoning").append(Ur);
		}else{
			$("#"+form+" #urZoning").empty().append(Ur);
		}
		document.getElementById(form).ZONING_KITE.value = kode;
	}else if(jenis=='jns_PKB'){
		var JNS_BARANG=($("#"+form+" #JNS_BARANG").val());//alert(kode);
		if(JNS_BARANG==""){
			$("#"+form+" #urJnsBrg").append(Ur);
		}else{
			$("#"+form+" #urJnsBrg").empty().append(Ur);
		}
		document.getElementById(form).JNS_BARANG.value = kode;
	}else if(jenis=='gdng_PKB'){
		var GUDANG=($("#"+form+" #GUDANG").val());//alert(kode);
		if(GUDANG==""){
			$("#"+form+" #urGudang").append(Ur);
		}else{
			$("#"+form+" #urGudang").empty().append(Ur);
		}
		document.getElementById(form).GUDANG.value = kode;
	}else if(jenis=='cara_STUFF'){
		var CARA_STUFFING=($("#"+form+" #CARA_STUFFING").val());//alert(kode);
		if(CARA_STUFFING==""){
			$("#"+form+" #urStuff").append(Ur);
		}else{
			$("#"+form+" #urStuff").empty().append(Ur);
		}
		document.getElementById(form).CARA_STUFFING.value = kode;
	}else if(jenis=='jnpartof'){
		var JNPARTOF=($("#"+form+" #JNPARTOF").val());//alert(kode);
		if(JNPARTOF==""){
			$("#"+form+" #urPartOf").append(Ur);
		}else{
			$("#"+form+" #urPartOf").empty().append(Ur);
		}
		document.getElementById(form).JNPARTOF.value = kode;
	}
	closedialog('divMTabel');
}
/*function getPopupPmsok(kodeId1,IdPmsk,NmPmsk,AlmtPmsk,jenis){
	var form;
	if(jenis=='pemasokBC27') form="fbc27_";
	else if(jenis=='pemasokBC261') form="fbc261_";
	else if(jenis=='pemasokBC262') form="fbc262_";
	else if(jenis=='pemasokBC41') form="fbc41_";
	else if(jenis=='pemasokBC40') form="fbc40_";
	//alert(form);
	if(jenis=='pemasokBC27'){
	 document.getElementById(form).KODE_ID_TRADER_TUJUAN.value = kodeId1;
	 document.getElementById(form).KODE_ID_TUJUAN.value = kodeId1;
	 document.getElementById(form).ID_TRADER_TUJUAN.value = IdPmsk;
	 document.getElementById(form).NAMA_TRADER_TUJUAN.value = NmPmsk;
	 document.getElementById(form).ALAMAT_TRADER_TUJUAN.value = AlmtPmsk;
	}else if(jenis=='pemasokBC261' || jenis=='pemasokBC41' ){//alert('sini');
	 document.getElementById(form).KODE_ID_PENERIMA.value = kodeId1;
	 document.getElementById(form).KODE_PENERIMA.value = kodeId1;
	 document.getElementById(form).ID_PENERIMA.value = IdPmsk;
	 document.getElementById(form).NAMA_PENERIMA.value = NmPmsk;
	 document.getElementById(form).ALAMAT_PENERIMA.value = AlmtPmsk;
	}else if(jenis=='pemasokBC262' || jenis=='pemasokBC40'){
	 document.getElementById(form).KODE_ID_PENGIRIM.value = kodeId1;
	 document.getElementById(form).KODE_ID_TUJUAN.value = kodeId1;
	 document.getElementById(form).ID_PENGIRIM.value = IdPmsk;
	 document.getElementById(form).NAMA_PENGIRIM.value = NmPmsk;
	 document.getElementById(form).ALAMAT_PENGIRIM.value = AlmtPmsk;
	}
	closedialog('divPemasok');
}*/
function getPopupBarang(KodeBrg,UraiBrg,Merk,Tipe,Ukrn,SpfLain,JnsBrg,jenis){
	var form;
	if(jenis=='barang_jadi') form="fbarang_jadi_";
	else if(jenis=='bhnBku27') form="Frm_BB27";
	else if(jenis=='bhnBku261') form="Frm_BB261";
	if(jenis=='barang_jadi'){
	 document.getElementById(form).KODE_BARANG.value = KodeBrg;
	 document.getElementById(form).URAIAN_BARANG.value = UraiBrg;
	 document.getElementById(form).MERK.value = Merk;
	 document.getElementById(form).TIPE.value = Tipe;
	 document.getElementById(form).UKURAN.value = Ukrn;
	 document.getElementById(form).SPFF.value = SpfLain;
	 document.getElementById(form).JNS_BARANG.value = JnsBrg;	
	}else if(jenis=='bhnBku27' || jenis=='bhnBku261'){
	 document.getElementById(form).KODE_BARANG_BB.value = KodeBrg;
	 document.getElementById(form).URAIAN_BARANG_BB.value = UraiBrg;
	 document.getElementById(form).MERK_BB.value = Merk;
	 document.getElementById(form).TIPE_BB.value = Tipe;
	 document.getElementById(form).UKURAN_BB.value = Ukrn;
	 document.getElementById(form).SPFF_BB.value = SpfLain;
	 document.getElementById(form).JNS_BARANG_BB.value = JnsBrg;	
	}
	closedialog('divBarang');
}
</script>