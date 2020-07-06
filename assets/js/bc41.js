// JavaScript Document
function Showdokumen(){
	var dokumen = $("#KODE_DOK_ASAL_BB").val();
	var aju = $("#aju").val();//alert(aju);
	var namaForm = $("#NAMA_FORM").val();
	Dialog(site_url+"/pengeluaran/dokpabean/"+dokumen, 'Dialog-dok','FORM DOKUMEN PABEAN',800, 510);
	//Dialog(site_url+"/pengeluaran/dokpabean/"+dokumen+"/"+aju+"/"+namaForm, 'Dialog-dok','FORM DOKUMEN PABEAN',800, 510);	
	return false;
}