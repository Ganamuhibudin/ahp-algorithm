<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(E_ERROR);
?>

<div class="content_luar">
  <div class="content_dalam"> 
   <div class="header">
	<h3><i class="fa fa-list"></i>&nbsp;<strong>Penelusuran Keluar Masuk Barang</strong></h3>
</div><br>
    <form name="frminout" id="frminout" method="post" action="<?php echo site_url()?>/inventory/inout">
    <input type="hidden" name="JNS_BARANG" id="JNS_BARANG" />
    <input type="hidden" name="MERK" id="MERK" />
    <input type="hidden" name="TIPE" id="TIPE" />
    <input type="hidden" name="SPF" id="SPF" />
    <input type="hidden" name="UKURAN" id="UKURAN" />
      <table class="normal" cellpadding="2" width="100%">
      	 <tr>
          <td width="8%"> Periode</td>          
          <td width="1%">:</td>
          <td>
            <div class="input-group" style="width:3em;float:left;margin-bottom:0px"><input type="text" name="TANGGAL_AWAL" id="TANGGAL_AWAL" onfocus="ShowDP(this.id)" wajib="yes" class="form-control" style="width:90px" value="<?=$TANGGAL_AWAL?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>&nbsp;<span style="float:left;margin-left:5px;margin-right:5px">s/d</span>&nbsp;
            <div class="input-group" style="width:3em;float:left;margin-bottom:0px"><input type="text" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" onfocus="ShowDP(this.id)" wajib="yes" class="form-control" style="width:90px" value="<?=$TANGGAL_AKHIR?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></td>
        </tr>
        <tr>
          <td width="8%">Kode Barang</td>
          <td width="1%">:</td>
          <td><div class="input-group" style="float:left; width:3em; margin-bottom:0px">
              <input type="text" name="KODE_BARANG" id="KODE_BARANG" wajib="yes" class="text" readonly="readonly" onclick="tb_search('barang','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JENIS_BARANG','Kode Barang','frminout',650,400)" style="width:245px">
              <span class="input-group-btn">
                  <a href="javascript:void(0)" name="cari" id="cari" class="btn btn-primary btn-xs" style="vertical-align:top;height:27px " onclick="tb_search('barang','KODE_BARANG;URAIAN_BARANG;MERK;TIPE;UKURAN;SPF;JENIS_BARANG','Kode Barang','frminout',650,400)"><i class="fa fa-ellipsis-h"></i></a></span>
              </div>&nbsp;<input type="hidden" name="URAIAN_BARANG" id="URAIAN_BARANG" /></td>
        </tr>
        <tr>
          <td width="8%">Jenis Barang</td>
          <td width="1%">:</td>
          <td><combo><?= form_dropdown('JENIS_BARANG', array(""=>"","1"=>"BARANG IMPOR","2"=>"BARANG HASIL PENGERJAAN SEDERHANA","3"=>"SISA POTONGAN","4"=>"SCRAP","5"=>"BARANG BUSUK/BANTUK TERTENTU"), '', 'id="JENIS_BARANG" class="text" wajib ="yes" style="width:245px"');?></combo></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><a href="javascript:void(0);" class="btn btn-success btn-sm next" onclick="ajaxproses('#frminout','spanview')"><span><span class="icon"><i class="fa fa-arrow-right"></i></span>&nbsp;Proses&nbsp;</span></a></td>
        </tr>
        <tr>
          <td colspan="3"><div class="spanview"></div></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
function updateinout(){
	jConfirm('Perhatian:<br>Proses berikut akan merubah jumlah stock akhir barang sejumlah Total saldo dibawah.<br>Anda yakin Akan memproses data ini?', " PLB Inventory ", 
	function(r){if(r==true){		
		var kode_barang = $("#KODE_BARANG").val();
		var jns_barang = $("#JENIS_BARANG").val();
    var tgl_awal = $("#TANGGAL_AWAL").val();
    var tgl_akhir = $("#TANGGAL_AKHIR").val();
		var saldo =  parseFloat($("#JUMSALDO").val());
    //alert('On Progress');return false;
		jloadings();
		$.ajax({
			type: 'POST',
			url: site_url+'/inventory/updatestock',
			data: 'kode_barang='+kode_barang+'&jns_barang='+jns_barang+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir,
			success: function(data){			
				jAlert(data);
			}
		});
		return false;
	}else{return false;}});
}
</script>