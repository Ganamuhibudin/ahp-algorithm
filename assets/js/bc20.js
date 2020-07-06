// JavaScript Document
/*tanda*/


// JavaScript Document
$(document).ready(function() {
    var JenisTarif = $('#KODE_TARIF_CUKAI').val();
    var JenisTarifBm = $('#KODE_TARIF_BM').val();
    if (JenisTarif == 2)
        tarif(JenisTarif);
    if (JenisTarifBm == 2) {
        $('#bmHidden').show();
        tarifBm(JenisTarifBm)
    }
});

function EditHarga(inputField, formName) { //alert('tes');
    var id = inputField.split(";");
    var data = "";
    for (var a = 0; a < id.length; a++) {
        data += ';'+id[a] +'|'+ $('#'+id[a]).val();
    }
    data = data.substr(1) ;
    Dialog(site_url + '/pengeluaran/hitungan/bc20/' + data, 'divHitung', 'FORM EDIT HARGA ', 670, 400);
}
function getHarga(form) { //alert();die();
    var HARGA_CIF = ($("#" + form + " #HARGA_CIF").val()) ? $("#" + form + " #HARGA_CIF").val() : 0;
    var KODE_VALUTA = ($("#" + form + " #KODE_VALUTA").val()) ? $("#" + form + " #KODE_VALUTA").val() : 0;
    var NDPBMHarga = ($("#" + form + " #NDPBMHarga").val()) ? $("#" + form + " #NDPBMHarga").val() : 0;
    var NDPBMUR = ($("#" + form + " #NDPBMUR").val()) ? $("#" + form + " #NDPBMUR").val() : 0;
    var FOBHarga = ($("#" + form + " #FOBHarga").val()) ? $("#" + form + " #FOBHarga").val() : 0;
    var FOBURHarga = ($("#" + form + " #FOBURHarga").val()) ? $("#" + form + " #FOBURHarga").val() : 0;
    var CIFHarga = ($("#" + form + " #CIFHarga").val()) ? $("#" + form + " #CIFHarga").val() : 0;
    var CIFRPHarga = ($("#" + form + " #CIFRPHarga").val()) ? $("#" + form + " #CIFRPHarga").val() : 0;
    var CIFURHarga = ($("#" + form + " #CIFURHarga").val()) ? $("#" + form + " #CIFURHarga").val() : 0;
    var NILAI_FREIGHT = ($("#" + form + " #NILAI_FREIGHT").val()) ? $("#" + form + " #NILAI_FREIGHT").val() : 0;
    var NILAI_FREIGHTUR = ($("#" + form + " #NILAI_FREIGHTUR").val()) ? $("#" + form + " #NILAI_FREIGHTUR").val() : 0;
    var BIAYAHarga = ($("#" + form + " #BIAYAHarga").val()) ? $("#" + form + " #BIAYAHarga").val() : 0;
    var DISCOUNTHarga = ($("#" + form + " #DISCOUNTHarga").val()) ? $("#" + form + " #DISCOUNTHarga").val() : 0;
    var ASURANSIHarga = ($("#" + form + " #KODE_ASURANSIHarga").val()) ? $("#" + form + " #KODE_ASURANSIHarga").val() : 0;
    var NILAI_ASURANSI = ($("#" + form + " #NILAI_ASURANSI").val()) ? $("#" + form + " #NILAI_ASURANSI").val() : 0;
    var NILAI_ASURANSIUR = ($("#" + form + " #NILAI_ASURANSIUR").val()) ? $("#" + form + " #NILAI_ASURANSIUR").val() : 0;
    var KODE_HARGA = ($("#" + form + " #KODE_HARGA").val()) ? $("#" + form + " #KODE_HARGA").val() : 0;
    if (KODE_HARGA != "") {
        document.getElementById('NILINV').value     = HARGA_CIF;
        document.getElementById('KDVAL').value      = KODE_VALUTA;
        document.getElementById('NDPBM').value      = NDPBMHarga;
        document.getElementById('nilai_ndpbm').value= NDPBMUR;
        document.getElementById('FOB').value        = FOBHarga;    
        document.getElementById('FOBUR').value      = FOBURHarga;
        document.getElementById('CIF').value        = CIFHarga;
        document.getElementById('CIFRPa').value      = CIFRPHarga;
        document.getElementById('CIFUR').value      = CIFURHarga;
        document.getElementById('FREIGHT').value    = NILAI_FREIGHT;
        document.getElementById('FREIGHTUR').value  = NILAI_FREIGHTUR;
        document.getElementById('BTAMBAHAN').value  = BIAYAHarga;
        document.getElementById('DISCOUNT').value   = DISCOUNTHarga;
        document.getElementById('KDASS').value = ASURANSIHarga;
        document.getElementById('ASURANSI').value   = NILAI_ASURANSI;
        document.getElementById('ASURANSIUR').value = NILAI_ASURANSIUR;
        document.getElementById('KDHRG').value = KODE_HARGA;
        if (KODE_HARGA == 2) {
            var span22 = "CNF";
        } else {
            var span22 = "FOB";
        }
        $("#22").html(span22);
    }
	//alert(document.getElementById('BTAMBAHAN').value);
    closedialog('divHitung');
    $("#BRUTOUR").focus();
}   
function kode(data) { //alert('tes');
    if (data == 1) {
        $("#harga").find("#NILAI_ASURANSI,#NILAI_FREIGHT").val('');
        $("#harga").find("#NILAI_ASURANSIUR,#NILAI_FREIGHTUR").val('0');
        $('#KODE_ASURANSIHarga').attr('disabled', "true");
        $('#NILAI_ASURANSI,#NILAI_ASURANSIUR').attr('disabled', "true");
        $('#NILAI_FREIGHT,#NILAI_FREIGHTUR').attr('disabled', "true");
        $('.hargacif').html('Harga CIF');
        $('.fob').html('FOB');
    } else if (data == 2) {
        $("#harga").find("#NILAI_FREIGHT").val('');
        $("#harga").find("#NILAI_FREIGHTUR").val('0');
        $('#KODE_ASURANSIHarga').removeAttr("disabled");
        $('#NILAI_ASURANSI,#NILAI_ASURANSIUR').removeAttr("disabled");
        $('#NILAI_FREIGHT,#NILAI_FREIGHTUR').attr('disabled', "true");
        $('.hargacif').html('Harga CNF');
        $('.fob').html('CNF');
    } else if (data == 3) {
        $('#KODE_ASURANSI').removeAttr("disabled");
        $('#NILAI_ASURANSI,#NILAI_ASURANSIUR').removeAttr("disabled");
        $('#NILAI_FREIGHT,#NILAI_FREIGHTUR').removeAttr("disabled");
        $('.hargacif').html('Harga FOB');
        $('.fob').html('FOB');
    }
    prosesHarga('harga');
}
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
function showBM() {
    jConfirm('Ini untuk melakukan pengisian tarif Spesifik misalnya beras gula dan tarif berdasarkan satuan lainnya.<br> Teruskan?', 'PLB Inventory',
            function(r) {
                if (r == true) {
                    Dialog(site_url + "/bc20/getBm", 'dialog-bm', 'Form Bea Masuk', 450, 300);
                } else {
                    return false;
                }
            });
}
function satuan(data) {   //alert('tes');
    var CIF = parseFloat($('#DNILINV').val()); 
    var BTDISKON = parseFloat($('#BTDISKON').val());
    var tot = (CIF + BTDISKON) / parseFloat(data);
    if (data != "")
        $('#HARGA_SATUAN').val(tot);
    $('#HARGA_SATUANUR').val(ThausandSeperator('', tot, 2));
    if (data == 0)
        $('#HARGA_SATUAN,#HARGA_SATUANUR').val(0);
}


function tarif(id) {
    if (id == 2) {
        $('#tarf').show();
        $('#persens').html('');
    } else {
        $('#persens').html('%');
        $('#tarf').hide();
    }
}
function cekAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 35 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function tarifBm(id) {
    if (id == 2) {
        $('.judul').html('Spesifik(Satuan)');
        $('.dtl').show();
    } else {
        $('.judul').html('');
        $('.dtl').hide();
    }
}


function changeBM(id) {
    if (id == 2) {
        $("#Advolorum").hide();
        $("#Spesifik").show();
    } else {
        $("#Spesifik").hide();
        $("#Advolorum").show();
    }
}

function prosesHargaHeader(form) { //alert('tes');
    var NDPBM = ($("#" + form + " #NDPBM").val()) ? $("#" + form + " #NDPBM").val() : 0;
    var HARGA_FOB = ($("#" + form + " #fob").val()) ? $("#" + form + " #fob").val() : 0;
    var NILAI_ASURANSI = ($("#" + form + " #asuransi").val()) ? $("#" + form + " #asuransi").val() : 0;
    var NILAI_FREIGHT = ($("#" + form + " #freight").val()) ? $("#" + form + " #freight").val() : 0;
    
    $("#" + form + " #CIF").val(parseFloat(NILAI_ASURANSI) + parseFloat(HARGA_FOB) + parseFloat(NILAI_FREIGHT));
    $("#" + form + " #CIFRPa").val(ThausandSeperator('', parseFloat(NDPBM) * parseFloat($("#" + form + " #CIF").val()), 4));
}

function save_hitung(formid) { //alert('tes');
    //$('#msgbox').html('');
    var dataSend = $(formid).serialize();
    jConfirm('Anda yakin Akan memproses data ini?', site_name,
        function(r) {
            if (r == true) {
                jloadings();
                $.ajax({
                    type: 'POST',
                    url: $(formid).attr('action'),
                    data: dataSend,
                    error: function(){
                        Clearjloadings();
                    },
                    success: function(data) {
                        Clearjloadings();
                        if (data.search("MSG") >= 0) {
                            arrdata = data.split('#');
                            if (arrdata[1] == "OK") {
                                $("#tabs").tabs({disabled: []});
                                $("form").find("#CAR").val(arrdata[3]);
                                $(".msgheader_").css('color', 'green');
                                $(".msgheader_").html(arrdata[2]);
                                if (formid == "#fbc20_") {
                                    cekValidasi( arrdata[3]);
                                }
                                if (arrdata[4]) $("#DivHeaderForm").load(arrdata[4]);
                            } else {
                                $(".msgheader_").css('color', 'red');
                                $(".msgheader_").html(arrdata[2]);
                            }
                        } else {
                            $(".msgheader_").css('color', 'red');
                            if (formid == '#fpass')
                                $(".msgheader_").html(arrdata[2]);
                            $(".msgheader_").html('Proses Gagal.');
                        } 
                    }
                });
            } else {
                return false;
            }
        });
}

function cekValidasi(car){
    $(function() {
        $('#msgbox').html('');
        $("#msgbox").html('<div style="margin-left: 15px; margin-top: 15px;"><img src="' + base_url + 'img/_load.gif" /> loading...</div>');
        $("#msgbox").dialog({
            resizable: false,
            height: 500,
            modal: true,
            width: 600,
            title: 'Validasi Dokumen',
            open: function (){
                $.ajax({
                    type: 'POST',
                    url : site_url+'/bc20/alertcekstatus/'+car+'/t_bc20_hdr',
                    success: function(data) {
                        $("#msgbox").html(data);
                    }
                });
            },
            buttons: {
                Close: function() {
                    $(this).dialog("close");
                }
            }
        });
    });
}