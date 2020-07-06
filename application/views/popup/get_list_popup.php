<?  if($jenis=='kemasan' || $jenis=="kemasanBrg"){?>
<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th>No</th>
        <th>Kode Kemasan</th>
        <th>Uraian Kemasan</th>
        <th>Tools</th>
    </tr>
    <?
    $banyakData=count($resultListPopUp);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListPopUp as $listDataPopUp){
	?>
    <tr>
    	<td><?= $no;?></td>
        <td><?= $listDataPopUp['KODE_KEMASAN'];?></td>
        <td><?= $listDataPopUp['URAIAN_KEMASAN'];?></td>
        <? if(($jenis=="kemasan") || ($jenis=="kemasanBrg")){?>
        <td width="10px">
         <input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" style="font-size:12px" onclick="getPopupKms('<?= $listDataPopUp['KODE_KEMASAN'];?>','<?= $listDataPopUp['URAIAN_KEMASAN'];?>','<?= $jenis;?>');" value="Pilih">
        </td>
		<? }?>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="5">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>
<? }elseif($jenis=="satuanBrg"){//die('sini');?>
<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th>No</th>
        <th>Kode Satuan</th>
        <th>Uraian Satuan</th>
        <th>Tools</th>
    </tr>
    <?
    $banyakData=count($resultListPopUp);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListPopUp as $listDataPopUp){
	?>
    <tr>
    	<td><?= $no;?></td>
        <td><?= $listDataPopUp['KODE_SATUAN'];?></td>
        <td><?= $listDataPopUp['URAIAN_SATUAN'];?></td>
        <? if(($jenis=="satuanBrg")){?>
        <td width="10px">
         <input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" style="font-size:12px" onclick="getPopupSat('<?= $listDataPopUp['KODE_SATUAN'];?>','<?= $listDataPopUp['URAIAN_SATUAN'];?>','<?= $jenis;?>');" value="Pilih">
        </td>
		<? }?>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="5">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>

<? }elseif($jenis=="konversi"){//echo $idValue;//die('sini');?>
<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th width="20">No</th>
        <th width="255">Nomor Konversi</th>
        <th width="185">Kode Barang</th>
        <th width="338">Uraian Barang</th>
        <th width="137">Jumlah Item Bahan Baku</th>
        <th>&nbsp;</th>
    </tr>
    <?
    $banyakData=count($resultListPopUp);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListPopUp as $listDataPopUp){
			if($no%2==0)$class="odd";
			else $class="alt";
	?>
    <!--<tr style="cursor:pointer" title="Detil Data" onclick="lihatDetKonversi('<?$no;?>','<?base_url()."index.php/produksi/getDetilKonversi/".$listDataPopUp['IDBJ']."/".$listDataPopUp['KODE_TRADER'];?>')">-->
    <tr onmouseout="$(this).removeClass('hilite');" onmouseover="$(this).addClass('hilite');">
    	<td class="<?= $class;?>"><?= $no;?></td>
        <td class="<?= $class;?>"><?= $listDataPopUp['NOMOR_KONVERSI'];?></td>
        <td class="<?= $class;?>"><?= $listDataPopUp['KODE_BARANG'];?></td>
        <td class="<?= $class;?>"><?= $listDataPopUp['URAIAN_BARANG'];?></td>
        <td class="<?= $class;?>" align="center"><?= $listDataPopUp['JUMLAH_BB'];?></td>
        <? if(($jenis=="konversi")){
		$idTrader=$this->newsession->userdata("KODE_TRADER");	
		?>
        <td width="119" class="<?= $class;?>" align="center">
         <!--<input type="button" name="cari" id="cari" class="button" onclick="getPopupKonversi('<?= base_url()."index.php/produksi/getKonversi/".$idValue."/".$listDataPopUp['IDBJ'];?>','fprod_list','<?= base_url()."index.php/produksi/edit/bhn_baku_list_detil_get/".$idValue."/".$idTrader;?>');" value="Pilih">-->
         <input type="button" name="cari" id="cari" class="btn btn-primary"  style="width:60%;font-size:12px;letter-spacing:1px"onclick="getPopupKonversi('<?= base_url()."index.php/produksi/prosesproduksikonversi/".$listDataPopUp['IDBJ'];?>','','');" value="Pilih">
		</td>
		<? }?>
    </tr>
    <tr id="hideDetilKonversi_<?php echo $no; ?>" style="display:none;" class="csDetilKonversi">
        	<td colspan="6"><div id="detilDataKonversi_<?php echo $no; ?>"></div></td>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="6" align="center">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>
<? }elseif(($jenis=="zoning_bc30") || ($jenis=="jns_PKB") || ($jenis=="gdng_PKB")|| ($jenis=="cara_STUFF") || ($jenis=="jnpartof")){?>
<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th>No</th>
        <th>Kode</th>
        <th>Uraian</th>
        <th>Tools</th>
    </tr>
    <?
    $banyakData=count($resultListPopUp);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListPopUp as $listDataPopUp){
	?>
    <tr>
    	<td><?= $no;?></td>
        <td><?= $listDataPopUp['KODE'];?></td>
        <td><?= $listDataPopUp['URAIAN'];?></td>
        <? if(($jenis=="zoning_bc30") || ($jenis=="jns_PKB") || ($jenis=="gdng_PKB")|| ($jenis=="cara_STUFF") || ($jenis=="jnpartof")){?>
        <td width="10px">
         <input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" style="font-size:12px" onclick="getPopupMTabel('<?= $listDataPopUp['KODE'];?>','<?= $listDataPopUp['URAIAN'];?>','<?= $jenis;?>');" value="Pilih">
        </td>
		<? }?>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="5">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>
<? }elseif(($jenis=='pemasokBC27') || ($jenis=="pemasokBC261") || ($jenis=='pemasokBC262') || ($jenis=='pemasokBC40') || ($jenis=='pemasokBC41')){?>
<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th>No</th>
        <th>ID Partner</th>
        <th>Nama Partner</th>
        <th>Alamat Partner</th>
        <th>Tools</th>
    </tr>
    <?
    $banyakData=count($resultListPopUp);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListPopUp as $listDataPopUp){
	?>
    <tr>
    	<td><?= $no;?></td>
        <td><?= $listDataPopUp['ID_PARTNER'];?></td>
        <td><?= $listDataPopUp['NAMA_PARTNER'];?></td>
        <td><?= $listDataPopUp['ALAMAT_PARTNER'];?></td>
        <? if(($jenis=="pemasokBC27") || ($jenis=="pemasokBC261") || ($jenis=='pemasokBC262') || ($jenis=='pemasokBC40') || ($jenis=='pemasokBC41')){?>
        <td width="10px">
         <input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" style="font-size:12px" onclick="getPopupPmsok('<?= $listDataPopUp['KODE_ID_PARTNER'];?>','<?= $listDataPopUp['ID_PARTNER'];?>','<?= $listDataPopUp['NAMA_PARTNER'];?>','<?= $listDataPopUp['ALAMAT_PARTNER'];?>','<?= $jenis;?>');" value="Pilih">
        </td>
		<? }?>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="5">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>
<? }elseif(($jenis=='barang_jadi') || ($jenis=='bhnBku27') ||($jenis=='bhnBku261')){?>
<table class="tabelPopUp" width="100%">
	<tr align="left">
    	<th>No</th>
        <th>Kode Barang</th>
        <th>Uraian</th>
        <th>Jenis Barang</th>
        <th>Tools</th>
    </tr>
    <?
    $banyakData=count($resultListPopUp);//echo $banyakData;
	if($banyakData>0){
		$no=$mulai_nomor;
		foreach($resultListPopUp as $listDataPopUp){
	?>
    <tr>
    	<td><?= $no;?></td>
        <td><?= $listDataPopUp['KODE_BARANG'];?></td>
        <td><?= $listDataPopUp['URAIAN_BARANG'];?></td>
        <td><?= $listDataPopUp['JENIS_BARANG'];?></td>
        <? if($jenis=="barang_jadi" || $jenis=="bhnBku27" ||($jenis=='bhnBku261')){?>
        <td><input type="button" name="cari" id="cari" class="btn btn-xs btn-primary" style="font-size:12px" onclick="getPopupBarang('<?= $listDataPopUp['KODE_BARANG'];?>','<?= $listDataPopUp['URAIAN_BARANG'];?>','<?= $listDataPopUp['MERK'];?>','<?= $listDataPopUp['TIPE'];?>','<?= $listDataPopUp['UKURAN'];?>','<?= $listDataPopUp['SPFLAIN'];?>','<?= $listDataPopUp['JNS_BARANG'];?>','<?= $jenis;?>');" value="pilih"></td>
		<? }?>
    </tr>
    <? $no++;}}else{?>
    <tr>
    	<td colspan="5">Maaf Belum Terdapat Data</td>
    </tr>
    <? }?>
</table>
<?php

}if((count($resultListPopUp)) >0){
?>
<div align="right">
<table class="tabelPopUp" width="100%">
<tr class="hilite">
<th class="odd" style="border-top:solid 1px #E8E8E8; text-align:right">
		<!--<span style=" float:left"><?echo DATA_PER_PAGE.' Data Per Halaman. Menampilkan '.$indexSekarang.' - '.DATA_PER_PAGE.' Dari '.count($resultListPopUp);?></span>
		<span>-->
    	<a class="paging" href="javascript:void(0)" onClick="get_next_data('1','<?= $type?>','<?= $jenis?>')">&laquo;</a>
        <a class="paging" href="javascript:void(0)" onClick="get_next_data('<?php echo ($indexSekarang==1)?1:($indexSekarang-1); ?>','<?= $type?>','<?= $jenis?>')">&lsaquo;</a>
         <label style="text-align:center;width:20%">
            Halaman
                <input type="text" name="txtGoTo" size="3" style="text-align:right" class="tb_text" id="txtGoTo" value="<?php echo $indexSekarang; ?>" />
                <input type="button" value="Go" class="btn btn-primary" style="width:15%;font-size:12px" onclick="goToPage('<?= $type?>','<?= $jenis?>')" />
            dari <?php echo number_format($banyakIndex,0,',','.'); ?>
        </label>
        <a class="paging" href="javascript:void(0)" onClick="get_next_data('<?php echo ($indexSekarang+1); ?>','<?= $type?>','<?= $jenis?>')">&rsaquo;</a>
        <a class="paging" href="javascript:void(0)" onClick="get_next_data('<?php echo $banyakIndex; ?>','<?= $type?>','<?= $jenis?>')">&raquo;</a>
        </span>
</th>
</tr>


</table>
</div>
<?php }?>