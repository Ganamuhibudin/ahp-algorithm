<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$DOK_PABEAN = array_merge(array("" => "Silahkan Pilih Data"), $DOK_PABEAN);
?>
<div class="content_luar">
    <div class="content_dalam">
        <h4><span class="info_2">&nbsp;</span>Revisi Data <i style="color:#666666">(yang telah disetujui/realisasi)</i></h4>
        <form name="frevisi_" id="frevisi_" action="<?= site_url() . "/tools/revisi" ?>" method="post">
            <table width="100%" border="0">
                <tr>
                    <td width="34%"><table width="100%" border="0">
                            <tr>
                                <td width="37%" valign="top">Jenis Revisi</td>
                                <td width="63%">
                                    <?php
									//if($this->newsession->userdata("KODE_TRADER")=="EDICHEM00001"){
										echo form_dropdown('JENIS_REVISI', array("" => "Masukkan Pilihan Anda", "1" => "Dokumen Pabean", "4" => "Pengerjaan Sederhana", "5" => "Singkronisasi Stokc Akhir Barang Berdasarkan Seluruh Transaksi In/Out Barang"), '', 'id="JENIS_REVISI" class="text" wajib="yes"');
									//}else{
										//echo form_dropdown('JENIS_REVISI', array("" => "Masukkan Pilihan Anda", "1" => "Dokumen Pabean", "4" => "Pengerjaan Sederhana"), '', 'id="JENIS_REVISI" class="text" wajib="yes"');
									//}
                                    ?>
                                </td>
                            </tr>
                            <tr id="tr_tipe_sederhana" style="display: none;">
                                <td>Tipe</td>
                                <td>
                                    <?=
                                    form_dropdown('TIPE_PENGERJAAN_SEDERHANA', array("" => "Silahkan Pilih Data",
                                        "1" => "Barang yang diproses [input]",
                                        "2" => "Hasil Pengerjaan [output]",
                                        "3" => "Sisa Produksi/Scrap"), '', 'id="TIPE_PENGERJAAN_SEDERHANA" class="text" wajib="yes"');
                                    ?>
                                </td>
                            </tr>
                            <tr class="spacer" style="display: none;">
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr class="spacer" style="display: none;">
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr class="idpabean" style="display:none">
                                <td>Jenis Dokumen Pabean</td>
                                <td><?= form_dropdown('DOK_PABEAN', array("" => "Silahkan Pilih Data", "BC23" => "BC 2.3", "BC27" => "BC 2.7", "BC25" => "BC 2.5", "BC30" => "BC 3.0"), '', 'id="DOK_PABEAN" class="text" wajib="yes" onChange="bagian(this.value)"'); ?>

                                </td>
                            </tr>
                            <tr class="idpabean" style="display:none">
                                <td>Bagian</td>
                                <td><div id="divBagian">
                                        <select name="DOK_BAGIAN" id="DOK_BAGIAN" class="text" wajib="yes" onchange="dokbagian(this.value)">
                                            <option value="">Silahkan Pilih Data</option>
                                            <option value="header">Data Header</option>
                                            <option value="barang">Data Barang</option>
                                            <option value="kemasan">Data Kemasan</option>
                                            <option value="kontainer">Data Kontainer</option>
                                            <option value="dokumen">Data Dokumen</option>
                                            <option value="realisasi">Data Realisasi</option>
                                            <option value="noaju">Nomor Pengajuan</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr class="idpabean" style="display:none">
                                <td>Nomor Aju</td>
                                <td><input type="text" name="NOMOR_AJU" id="NOMOR_AJU" class="text" wajib="yes"/></td>
                            </tr>
                            <tr class="idaju" style="display:none">
                                <td>Nomor Aju Pengganti</td>
                                <td><input type="text" name="NOMOR_AJU_NEW" id="NOMOR_AJU_NEW" class="text" wajib="yes"/></td>
                            </tr>
                            <tr class="idproduksi" style="display:none">
                                <td>Nomor Transaksi</td>
                                <td><input type="text" name="NOMOR_TRANSAKSI" id="NOMOR_TRANSAKSI" class="text" wajib="yes"/></td>
                            </tr>
							<tr class="periodesinkron" style="display:none">
							  <td>Periode</td>   
							  <td>                    
								<input type="text" name="TANGGAL_AWAL" id="TANGGAL_AWAL" wajib="yes" class="stext date" onFocus="ShowDP('TANGGAL_AWAL');">&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;
								<input type="text" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" onFocus="ShowDP('TANGGAL_AKHIR');" wajib="yes" class="stext date"></td>
							 </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><div class="msg_">&nbsp;</div></td>
                            </tr>
                        </table>
                    </td>
                    <td width="66%" valign="top">
                        <span style="display:none" id="sinkron">
                            <a href="javascript:void(0);" class="button save" id="ok_" onclick="sinkron()">
                                <span><span class="icon"></span>Proses Sinkronisasi Barang</span></a>
                        </span>
                        <table width="100%" class="idalasan" style="display:none">
                            <tr>
                                <td width="13%" valign="top">Alasan Revisi</td>
                                <td width="87%"><textarea name="ALASAN" id="ALASAN" rows="5" cols="5" wajib="yes" class="text"></textarea>
                                    &nbsp;&nbsp;
                                    <input id="execRevisi" type="button" class="btn" value="Proses" style="padding:1px;width:80px" onclick="prosesrevisi('#frevisi_', 'msg_')" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="ViewProses" style="margin-top:3px"></div>
<script>
    $(function() {
        $(".ViewProses").ajaxComplete(function() {
            if ($("#DOK_BAGIAN").val() != "header") {
                $('form:not(#frevisi_)').append('<input type="hidden" name="flagrevisi" id="flagrevisi" value="1">');
            }
        })
        $('#JENIS_REVISI').change(function() {
            $(".ViewProses").html('');
            if ($(this).val() == 1) {
                $('.idpabean,.idalasan').show();
                $('.idproduksi').hide();
                $('#sinkron').hide();
                $('#tr_tipe_sederhana').hide();
                $('.spacer').hide();
				$('.periodesinkron').hide();
            } else if ($(this).val() == 2) {
                $('.idpabean').hide();
                $('.idproduksi,.idalasan').show();
                $('#sinkron').hide();
                $('#tr_tipe_sederhana').hide();
                $('.spacer').hide();
				$('.periodesinkron').hide();
            }
            else if ($(this).val() == 3) {
                $('#sinkron').show();
                $('input,select').removeClass('wajib');
                $('.idpabean,.idproduksi,.idalasan').hide();
                $('#tr_tipe_sederhana').hide();
                $('.spacer').hide();
				$('.periodesinkron').hide();
            } else if ($(this).val() == 4) {
                $('#tr_tipe_sederhana').show();
                $('.idpabean').hide();
                $('.idproduksi').hide();
                $('.idalasan').show();
                $('.spacer').show();
				$('.periodesinkron').hide();
            }else if($(this).val() == 5){
				$('#sinkron').show();
				$('.periodesinkron').show();
				$('input,select').removeClass('wajib');
				$('.idpabean,.idproduksi,.idalasan').hide();
                $('#tr_tipe_sederhana').hide();
			}
            else {
                $('input,select').removeClass('wajib');
                $('.idpabean,.idproduksi,.idalasan').hide();
                $('#sinkron').hide();
				$('.periodesinkron').hide();
                $('#tr_tipe_sederhana').hide();
                $('.spacer').hide();
            }
        });
    })
    function dokbagian(val) {
        if (val == "noaju") {
            $('.idaju').show();
        } else {
            $('.idaju').hide();
        }
    }
    function bagian(value) {
        var html = "";
        switch (value) {
            case "BC23":
            case "BC30":
                html = ' <select onchange="dokbagian(this.value)" name="DOK_BAGIAN" id="DOK_BAGIAN" class="text" wajib="yes"><option value="">Silahkan Pilih Data</option><option value="header">Data Header</option><option value="barang">Data Barang</option><option value="kemasan">Data Kemasan</option><option value="kontainer">Data Kontainer</option><option value="dokumen">Data Dokumen</option><option value="realisasi">Data Realisasi</option><option value="noaju">Nomor Pengajuan</option></select>';
                break;
            case "BC40":
            case "BC41":
            case "BC262":
                html = ' <select onchange="dokbagian(this.value)" name="DOK_BAGIAN" id="DOK_BAGIAN" class="text" wajib="yes"><option value="">Silahkan Pilih Data</option><option value="header">Data Header</option><option value="barang">Data Barang</option><option value="kemasan">Data Kemasan</option><option value="dokumen">Data Dokumen</option><option value="realisasi">Data Realisasi</option><option value="noaju">Nomor Pengajuan</option></select>';
                break;
            case "BC27":
                html = ' <select onchange="dokbagian(this.value)" name="DOK_BAGIAN" id="DOK_BAGIAN" class="text" wajib="yes"><option value="">Silahkan Pilih Data</option><option value="header">Data Header</option><option value="barang">Data Barang</option><option value="barang_jadi">Data Barang Jadi</option><option value="kemasan">Data Kemasan</option><option value="kontainer">Data Kontainer</option><option value="dokumen">Data Dokumen</option><option value="realisasi">Data Realisasi</option><option value="noaju">Nomor Pengajuan</option></select>';
                break;
            case "BC25":
                html = ' <select onchange="dokbagian(this.value)" name="DOK_BAGIAN" id="DOK_BAGIAN" class="text" wajib="yes"><option value="">Silahkan Pilih Data</option><option value="header">Data Header</option><option value="barang">Data Barang</option><option value="kemasan">Data Kemasan</option><option value="dokumen">Data Dokumen</option><option value="ppnpenyerahan">PPN Penyerahan</option><option value="realisasi">Data Realisasi</option><option value="noaju">Nomor Pengajuan</option></select>';
                break;
            case "BC261":
                html = ' <select onchange="dokbagian(this.value)" name="DOK_BAGIAN" id="DOK_BAGIAN" class="text" wajib="yes"><option value="">Silahkan Pilih Data</option><option value="header">Data Header</option><option value="barang">Data Barang</option><option value="barang_jadi">Data Barang Jadi</option><option value="kemasan">Data Kemasan</option><option value="dokumen">Data Dokumen</option><option value="realisasi">Data Realisasi</option><option value="noaju">Nomor Pengajuan</option></select>';
                break;
            case "":
                html = ' <select onchange="dokbagian(this.value)" name="DOK_BAGIAN" id="DOK_BAGIAN" class="text" wajib="yes"><option value="header">Silahkan Isi Jenis Dokumen Terlebih Dahulu</option></select>';
                break;
        }
        $("#divBagian").html(html);
        $('.idaju').hide();
        return false;
    }

    function sinkron() {
        jConfirm('Perhatian:<br>Proses berikut akan merubah seluruh jumlah stock akhir barang anda sesuai Keseluruhan Mutasi yang telah terjadi!.<br>Anda yakin Akan memproses data ini?', " GB Inventory ",
                function(r) {
                    if (r == true) {
                        jloadings();
                        $.ajax({
                            type: 'POST',
                            url: site_url + '/tools/sinkron',
                            data: 'proses=1',
                            success: function(data) {
                                jAlert(data, "e-INKABER");
                                return false;
                            }
                        });
                    } else {
                        return false;
                    }
                });
    }
</script> 
