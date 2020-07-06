<?php

class cetakPEB{
	var $CAR;
	
	function cetakPEB($CAR){
		$this->CAR = $CAR;
	}
	
	function strip($strstrip){
		if (trim($strstrip) != 0){
			$hasile = $strstrip.'%';
		}
		else
		{
			$hasile = ' - ';
		}
		
		return $hasile;	
	}
	
	function formaths($hs){
		$formaths = substr($hs,0,4).'.'.substr($hs,4,2).'.'.substr($hs,6,2).'.'.substr($hs,8,2);
		return $formaths;
	}
	
	
	function setnocont($nocont){
		if (count($nocont) != 0){ 
			$hasile = substr($nocont,0,4).'-'.substr($nocont,4,11);
		}
		return $hasile;
	}
	
	function trimstr($strpotong,$panjang){
		if(strlen($strpotong)>$panjang){
		
			for($i=$panjang;$i>0;$i--){
				$sub = substr($strpotong,$i,1);
				if($sub == " "){
					$potong = $i;
					break;
				}
		}
		
			return array ("str1" => substr($strpotong,0,$potong), "str2" => substr($strpotong,$potong+1,$panjang),"str3" => substr($strpotong,$potong+$panjang,$panjang),"str4" => substr($strpotong,$potong+3,$panjang));
		}else{
			return array ("str1" => $strpotong, "str2" => "","str3" => "","str4" => "");
		}		
	}
	
	function displayPDF(){
		
		$this->pdf = new PdfMcTable('P','mm','A4');
		$this->pdf->Open();
		$this->page += 1;
		$this->pdf->SetTitle('Print Perijinan');
		$this->pdf->SetAuthor('Indonesia National Single Window');
		$this->pdf->SetLineWidth(0.1);
		$this->pdf->SetFillColor(255);		
		$nb="{nb$i}";
		$this->PrintPEB($nb);
		$this->pdf->Output();	
		
	}
	
	function PrintPEB(&$nb) {
		$this->pdf->AddPage();
		$this->getDataDokPEB();
		$this->draw_HeaderPEB();
		if ($this->jmbrg>1){
			$this->lembar_lanjutBrg();
		}
		if($this->jmldok>1){
			$this->lembar_lanjutDok();
		}
	
	}
	
	function draw_HeaderPEB(){	
	
		
		//HEADER//	
		$this->pdf->SetX(5.4);
		$this->pdf->Rect(5.4, 4, 3.6, 36, 3.5, 'F');
		$this->pdf->Rect(9, 4, 20, 5, 3.5, 'F');
		$this->pdf->Rect(9, 4, 194.4, 5, 3.5, 'F');
		$this->pdf->Rect(9, 9, 194.4, 31, 3.5, 'F');
		$this->pdf->Rect(118.4, 17, 85, 23, 3.5, 'F');
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(19,2,'BC 3.0',0,0,'R',0);
		$this->pdf->SetFont('times','B','10');
		$this->pdf->cell(123,2,"PEMBERITAHUAN EKSPOR BARANG",0,0,'R',0);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->writeRotie(8,30,"HEADER",90,0);
//		
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(190,7," Halaman 1 dari $nb",0,0,'R',0);//
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(5,2,'A.KANTOR PABEAN',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(12);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(33,4,'1.Kantor Pabean Pemuatan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->kdkpbc.'   '.str_replace("KANTOR PELAYANAN BEA CUKAI ","KPU ",$this->kpbc),0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(12);
		$this->pdf->cell(33,4,'2.Nomor Pengajuan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->noaju,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(36,3,'B.JENIS EKSPOR',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->jnspeb,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(36,3,'C.KATEGORI EKSPOR',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->jnseks,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(36,3,'D.CARA PERDAGANGAN',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->jnsdag,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(36,3,'E.CARA PEMBAYARAN',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->jnsbyr,0,0,'L',0);
		$this->pdf->Ln();
		
		$this->pdf->SetXY(119,17);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(36,3,'H.KOLOM KHUSUS BEA DAN CUKAI',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(27,3,'1.Nomor Pendaftaran',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->nodaft,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(121);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(25,3,'Tanggal',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->tgdaft,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(27,3,'2.Nomor BC 1.1',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->NOBCF,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(121);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(25,3,'Tanggal',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->TGBCF,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(121);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(25,3,'Pos Sub Pos',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,'',0,0,'L',0);
		$this->pdf->Ln();
		
		//===DATA PEMBERITAHUAN==\\
		
		//EKSPORTIR
		$this->pdf->SetFont('times','B','8');
		$this->pdf->writeRotie(8,160,"F.DATA PEMBERITAHUAN",90,0);
		$this->pdf->Rect(5.4, 40, 198, 246, 3.5, 'F');
		$this->pdf->Rect(9, 40, 194.4, 5, 3.5, 'F');
		$this->pdf->Rect(9, 45, 194.4, 31, 3.5, 'F');
		$this->pdf->Rect(118.4, 40, 85, 20, 3.5, 'F');
		$this->pdf->Rect(118.4, 56, 85, 20, 3.5, 'F');
		
		$this->pdf->SetX(12);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(40,5,'EKSPORTIR',0,0,'L',0);
		$this->pdf->cell(86,5,'PENERIMA',0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(20,3,'1.Identitas',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$imppj = strlen(trim($this->expnpwp));
		if($imppj==15){
			$formatimpNPWP= substr($this->expnpwp,0,2) .".". substr($this->expnpwp,2,3) .".". substr($this->expnpwp,5,3) .".". substr($this->expnpwp,8,1) ."-". substr($this->expnpwp,9,3) .".". substr($this->expnpwp,12,3);
		} else {
			$formatimpNPWP= substr($this->expnpwp,0,2) .".". substr($this->expnpwp,2,3) .".". substr($this->expnpwp,5,3) .".". substr($this->expnpwp,8,1) ."-". substr($this->expnpwp,9,3);
		}		
		$this->pdf->cell(5,4,$this->urnpwp.' Digit      '.$formatimpNPWP,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(20,3,'2.Nama',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->expnama,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(20,3,'3.Alamat',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$almt = $this->trimstr($this->expalmt,75);
		$this->pdf->cell(5,4,$almt['str1'],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(31);
		$this->pdf->cell(1,4,$almt['str2'],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(20,3,'4.NIPER',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->EXPNIPER,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(20,3,'5.Status',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->expstatur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(20,3,'No & Tgl.TDP',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->EXPNOTDP,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(31);
		$this->pdf->cell(20,3,$this->EXPTGTDP,0,0,'L',0);
		$this->pdf->Ln();
		
		$this->pdf->SetXY(119,45);
		$this->pdf->cell(27,3,'7.Nama',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->nmbeli,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(27,3,'8.Alamat',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$almt = $this->trimstr( $this->almbeli,32);
		$this->pdf->cell(5,4,$almt['str1'],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(148);
		$this->pdf->cell(1,3,$almt['str2'],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(121);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(36,4,'PPJK',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->SetFont('times','','8');
		$eksppjk = strlen(trim($this->ppjknpwp));
			if($eksppjk==15){
				$formateksNPWP= substr($this->ppjknpwp,0,2) .".". substr($this->ppjknpwp,2,3) .".". substr($this->ppjknpwp,5,3) .".". substr($this->ppjknpwp,8,1) ."-". substr($this->ppjknpwp,9,3) .".". substr($this->ppjknpwp,12,3);
			} else {
				$formateksNPWP= substr($this->ppjknpwp,0,2) .".". substr($this->ppjknpwp,2,3) .".". substr($this->ppjknpwp,5,3) .".". substr($this->ppjknpwp,8,1) ."-". substr($this->ppjknpwp,9,3);
			}
		$this->pdf->cell(27,3,'9.NPWP',0,0,'L',0);
		$this->pdf->cell(2,3,':',0,0,'C',0);
		$this->pdf->cell(5,3,$formateksNPWP,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(27,3,'10.Nama',0,0,'L',0);
		$this->pdf->cell(2,3,':',0,0,'C',0);
		$this->pdf->cell(5,3,$this->ppjknama,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(27,3,'11.Alamat',0,0,'L',0);
		$this->pdf->cell(2,3,':',0,0,'C',0);
		$almt = $this->trimstr($this->ppjkalmt,50);
		$this->pdf->cell(5,3,$almt['str1'],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(148);
		$this->pdf->cell(1,2,$almt['str2'],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(27,6,'12.Nomor Pokok PPJK',0,0,'L',0);
		$this->pdf->cell(2,6,':',0,0,'C',0);
		$this->pdf->cell(5,6,$this->ppjkno,0,0,'L',0);
		$this->pdf->SetX(180);
		$this->pdf->cell(6,6,'Tgl',0,0,'L',0);
		$this->pdf->cell(2,6,':',0,0,'C',0);
		$this->pdf->cell(5,6,$this->ppjktg,0,0,'L',0);
		$this->pdf->Ln();
		
		
		//DATA PENGANGKUTAN
		$this->pdf->Rect(9, 76, 194.4, 5, 3.5, 'F');
		$this->pdf->Rect(9, 76, 194.4, 25, 3.5, 'F');
		$this->pdf->Rect(118.4, 76, 85, 25, 3.5, 'F');
		
		$this->pdf->SetX(12);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(40,4,'DATA PENGANGKUTAN',0,0,'L',0);
		$this->pdf->cell(96,4,'DATA PELABUHAN',0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(42,4,'13.Cara Pengangkutan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->modaur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(42,4,'14.Nama Sarana Pengangkut',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->CARRIER,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(42,4,'15.Nomor Pengangkut (Voy/Flight)',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->VOY,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(42,4,'16.Bendera Sarana Pengangkut',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->BENDERA.'  '.$this->BENDERAur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(109.4,4,'17.Tanggal Perkiraan Ekspor :    '.$this->tgeks,1,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetXY(119,81);
		$this->pdf->cell(32,4,'18.Pelabuhan Muat Asal',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->PELMUAT.'   '.$this->PELMUATur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(32,4,'19.Pelabuhan Muat Ekspor',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->PELMUAT.'   '.$this->PELMUATur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(32,4,'20.Pelabuhan Transit LN',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->PELTRANSIT.'   '.$this->PELTRANSITur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(32,4,'21.Pelabuhan Bongkar',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->PELBONGKAR.'   '.$this->PELBONGKARur,0,0,'L',0);
		$this->pdf->Ln();
		
		//DOKUMEN PELENGKAP PABEAN
		$this->pdf->Ln();
		$this->pdf->Rect(9, 101, 194.4, 5, 3.5, 'F');
		$this->pdf->Rect(9, 101, 194.4, 22, 3.5, 'F');
		$this->pdf->Rect(118.4, 101, 85, 22, 3.5, 'F');
		
		$this->pdf->SetX(12);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(40,5,'DOKUMEN PELENGKAP PABEAN',0,0,'L',0);
		$this->pdf->cell(112,5,'DATA TEMPAT PEMERIKSAAN',0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(42,4,'22.Nomor & Tgl Invoice',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(64,4,$this->invno[1],0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->cell(72,4,$this->invtgl[1],0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(42,4,'23.Jenis/Nomor/Tgl Dok Pelengkap Pabean  :',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(12);
		$this->pdf->cell(40,4,$this->urdok[1],0,0,'L',0);
		$this->pdf->cell(45,4,$this->nodok[1],0,0,'L',0);
		$this->pdf->cell(20,4,$this->tgdok[1],0,0,'R',0);
		
		$this->pdf->SetXY(119,106);
		$this->pdf->cell(36,4,'24.Lokasi Pemeriksaan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->kdlokbrng.'.'.$this->KDLOKBRGur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(36,4,'25.Kantor Pabean Pemeriksaan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->kpbcperiksa.' '.str_replace("KANTOR PELAYANAN BEA CUKAI ","KPU ",$this->kpbcperiksaur),0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(118.4);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(85	,3,'    Data Perdagangan',1,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(24,4,'26.Daerah Asal Brg',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->PROPBRG.'  '.$this->PROPBRGur,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(42,2,'',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(109.4,4,'27.Negara Tujuan Ekspor  :  '.$this->negtuju.'    '.$this->negtujuur,1,0,'L',0);
		$this->pdf->cell(85,4,'28.Cara Penyerahan Barang  :  '.$this->serah.'     '.$this->serahur,1,0,'L',0);
		
		//DATA TRANSAKSI EKSPOR
		$this->pdf->Ln();
		$this->pdf->Rect(9, 127, 194.4, 5, 3.5, 'F');
		$this->pdf->Rect(9, 127, 194.4, 18, 3.5, 'F');
		$this->pdf->Rect(118.4, 127, 85, 18, 3.5, 'F');
		
		$this->pdf->SetX(12);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(40,5,'DATA TRANSAKSI EKSPOR',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(36,4,'29.Jenis Valuta Asing',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(20,4,$this->KDVAL,0,0,'L',0);
		$this->pdf->cell(50,4,$this->KDVALur,0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(36,4,'30.Freight',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$freight = number_format($this->freight, 2, '.', ',');
		$this->pdf->cell(70,4,$freight,0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetXY(119,132);
		$this->pdf->cell(28,4,'31.Asuransi (LN/DN)',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$asuransi = number_format($this->asuransi, 2, '.', ',');
		$this->pdf->cell(5,4,$asuransi,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(28,4,'32.FOB',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$FOB = number_format($this->FOB, 2, '.', ',');
		$this->pdf->cell(5,4,$FOB,0,0,'L',0);
		$this->pdf->Ln();
		
		
		//DATA PETI KEMAS
		$this->pdf->Rect(9, 140, 194.4, 5, 3.5, 'F');
		$this->pdf->Rect(9, 140, 194.4, 21, 3.5, 'F');
		$this->pdf->Rect(118.4, 140, 85, 21, 3.5, 'F');
		
		$this->pdf->SetX(12);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(40,5,'DATA PETI KEMAS',0,0,'L',0);
		$this->pdf->cell(94,5,'DATA KEMASAN',0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(38,4,'33.Peti Kemas',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,'-',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(38,4,'34.Status Peti Kemas',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,'-',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(38,4,'35.Jumlah Peti Kemas',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->JMCONT.' '.$this->conttipeur[1],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(38,4,'36.Merk dan Nomor Peti Kemas',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->contno[1],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetXY(119,145);
		$this->pdf->cell(28,4,'37.Jenis Kemasan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->jnkemas[1].'  '.$this->jnkemas_nama[1],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(28,4,'38.Jumlah Kemasan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,$this->jmkemas[1],0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(28,4,'39.Merk Kemasan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(5,4,'-',0,0,'L',0);
		$this->pdf->Ln();
		
		
		//DATA BARANG EKSPOR\\
		$this->pdf->Ln();
		$this->pdf->Rect(9, 161, 194.4, 5, 3.5, 'F');
		$this->pdf->Rect(118.4, 161, 85, 5, 3.5, 'F');
		$this->pdf->Rect(9, 166, 194.4, 5, 3.5, 'F');
		
		$this->pdf->SetX(12);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(40,5,'DATA BARANG EKSPOR',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(25,4,'40.Volume',0,0,'L',0);
		$VOLUME = number_format($this->VOLUME, 4, ',', '.');
		$this->pdf->cell(30,4,$VOLUME,0,0,'L',0);
		$this->pdf->cell(30,4,'41.Berat Kotor(Kg)',0,0,'L',0);
		$bruto = number_format($this->bruto, 4, '.', ',');
		$this->pdf->cell(30,4,$bruto,0,0,'L',0);
		$this->pdf->cell(30,4,'42.Berat Bersih (Kg)',0,0,'L',0);
		$netto = number_format($this->netto, 4, '.', ',');
		$this->pdf->cell(30,4,$netto,0,0,'L',0);
		//44 postarif
		$this->pdf->Ln();
		$this->pdf->Rect(9, 171, 10, 51.5, 3.5, 'F');
		$this->pdf->Rect(9, 171, 194.4, 12, 3.5, 'F');		
		$this->pdf->Rect(9, 183, 194.4, 39.5, 3.5, 'F');
		$this->pdf->Rect(83.4, 171, 35, 51.5, 3.5, 'F');
		$this->pdf->Rect(150, 171, 28, 51.5, 3.5, 'F');
		
		$this->pdf->SetXY(9,171);
		$this->pdf->cell(1,4,'43. No',0,0,'L',0);
		$this->pdf->cell(10,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'44. Pos Tarif/HS, Uraian jumlah dan jenis',0,0,'L',0);
		$this->pdf->cell(63,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'45. HE Barang dan',0,0,'L',0);
		$this->pdf->cell(35,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'46. Jumlah & Jenis Sat,',0,0,'L',0);
		$this->pdf->cell(30,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'47.-Perijinan Ekspor',0,0,'L',0);
		$this->pdf->cell(27,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'48.Jumlah Nilai',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(1,4,'',0,0,'L',0);
		$this->pdf->cell(13,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'barang secara lengkap, merk, tipe,',0,0,'L',0);
		$this->pdf->cell(63.5,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Tarif BK pada',0,0,'L',0);
		$this->pdf->cell(35.5,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Berat Bersih (Kg)',0,0,'L',0);
		$this->pdf->cell(29.5,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'-Negara Asal',0,0,'L',0);
		$this->pdf->cell(27,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'FOB',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(14,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'ukuran, spesifikasi lain dan kode barang',0,0,'L',0);
		$this->pdf->cell(64,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'tanggal pendaftaran',0,0,'L',0);
		$this->pdf->cell(35,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Volume (m3)',0,0,'L',0);
		$this->pdf->cell(30,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Barang',0,0,'L',0);
		$this->pdf->SetFont('times','','7');
		//Isi Detail
		if($this->jmbrg <=1){
			$this->pdf->Ln();
			$this->pdf->setX(10);
			$this->pdf->cell(10,4,'1',0,0,'L',0);
			$this->pdf->cell(75,4,$this->formaths($this->nohs),0,0,'L',0);
			$this->pdf->cell(15,4,'',0,0,'L',0);
			//$this->pdf->cell(40,4,$this->strip($this->peperbrg),0,0,'L',0);
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,number_format($this->jmlsat,4,'.',','),0,0,'L',0);
			$dnilinv = number_format($this->FOB , 4, '.', ',');
			$this->pdf->cell(54,4,$dnilinv,0,0,'R',0);
			$urai = $this->trimstr($this->brgurai,50);
			$this->pdf->Ln();
			$this->pdf->setX(10);
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$kordinatx = $this->pdf->getx();
			$kordinaty = $this->pdf->gety();
			$this->pdf->MultiCell(60,4,substr($this->brgurai,0,95),0,'L');
			$kordinatyy = $this->pdf->gety();
			$this->pdf->setxy($kordinatx+75,$kordinaty);
			
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$satuan = $this->trimstr($this->kdsat.'/'.$this->kdsat_nama, 20);
			$this->pdf->cell(29.4,4,$satuan['str1'],0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			
			$jn = number_format($this->kemasjm,4,'.',',');
			$this->pdf->Ln();
			$this->pdf->sety($kordinatyy);			
		
			$this->pdf->setX(10);
			
			$this->pdf->cell(10,4,'',0,0,'L',0);
			//$this->pdf->cell(75,4,$jn.' '.$this->kemasjn.' / '.$this->kemasjn_nama,0,0,'L',0);
			$this->pdf->cell(70,4,'Kemasan: '.$this->kemasjm.' '.$this->kemasjn.' / '.$this->kemasjn_nama,0,0,'L',0);
			$this->pdf->cell(20,4,'',0,0,'L',0);
			
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,number_format($this->nettodtl,4,'.',',').' Kg',0,0,'L',0);
			
			$this->pdf->Ln();
			
			$this->pdf->setX(10);
			
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->kdfasdtl_nama = "";
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
		}else{
			$this->pdf->SetFont('times','','8');
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(43,4,'',0,0,'L',0);
			$this->pdf->cell(100,4,'=='.$this->jmbrg.' Jenis barang. Lihat Lembar Lanjutan==',0,0,'R',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);

			$this->pdf->cell(25,4,number_format($this->FOB, 4, '.', ','),0,0,'R',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->cell(10,4,'',0,0,'L',0);
			$this->pdf->cell(75,4,'',0,0,'L',0);
			$this->pdf->cell(25,4,'',0,0,'L',0);
			$this->pdf->cell(30,4,'',0,0,'L',0);
			$this->pdf->cell(29.4,4,'',0,0,'L',0);
			$this->pdf->cell(29.8,4,'',0,0,'L',0);
		}
		//end isi detil\\
		
		$this->pdf->Rect(118.4, 222.5, 85, 5, 3.5, 'F');
		$this->pdf->Rect(9, 222.5, 194.4, 13, 3.5, 'F');
		$this->pdf->Rect(118.4, 222.5, 85, 13, 3.5, 'F');
		$this->pdf->Ln();
		$this->pdf->SetXY(9,228);
		$this->pdf->cell(38,4,'49. Nilai Tukar mata uang',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$tukar = number_format('', 4, ',', '.');
		$this->pdf->cell(50,4,$tukar,0,0,'R',0);
		
		$this->pdf->SetXY(119,223.5);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(36,4,'DATA PENERIMAAN NEGARA',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(36,4,'50.Nilai BK dalam rupiah',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$valNILAIBK = number_format($this->NILAIBK, 2, ',', '.');
		$this->pdf->cell(46,4,$valNILAIBK,0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(119);
		$this->pdf->cell(36,4,'51.PNBP',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$valpnbp = number_format($this->PNBP, 2, ',', '.');
		$this->pdf->cell(46,4,$valpnbp,0,0,'R',0);
		$this->pdf->Ln();
		
		
		//G DAN I 
		$this->pdf->Rect(118.4, 235.5, 85, 50.5, 3.5, 'F');
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','B','8');
		$this->pdf->cell(40,4,'G. TANDA TANGAN EKSPORTIR/PPJK',0,0,'L',0);
		$this->pdf->cell(104,4,'I. BUKTI PEMBAYARAN',0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(38,4,'Dengan ini saya menyatakan bertangung jawab atas kebenaran hal-hal',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(38,4,'yang diberitahukan dalam Pemberitahuan Ekspor Barang ini',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->SetX(30);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(51,5,', '.date("d-m-Y"),0,0,'C',0);
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->SetX(30);
		$this->pdf->cell(51,5,'-'.$this->TTDPEB.'-',0,0,'C',0);
		
		
		$this->pdf->Rect(122, 244, 80, 8, 3.5, 'F');
		$this->pdf->Rect(122, 244, 15, 25, 3.5, 'F');
		$this->pdf->Rect(137, 244, 65, 4, 3.5, 'F');
		$this->pdf->Rect(137, 244, 32.5, 25, 3.5, 'F');
		$this->pdf->Rect(169.5, 244, 32.5, 25, 3.5, 'F');
		$this->pdf->Rect(137, 248, 16, 21, 3.5, 'F');
		$this->pdf->Rect(169.5, 248, 16, 21, 3.5, 'F');
		
		$this->pdf->SetXY(122,240);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(36,4,'SSPCP :',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(124);
		$this->pdf->cell(3,8,'Jen.Pen',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(126);
		$this->pdf->cell(3,8,'BK',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(125);
		$this->pdf->cell(3,8,'PNBP',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(125);
		$this->pdf->cell(3,8,'Pejabat Penerima',0,0,'L',0);
		$this->pdf->SetX(170);
		$this->pdf->cell(100,8,'Nama/Stempel Instansi',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(125);
		$this->pdf->cell(3,10,'............................',0,0,'L',0);
		
		$this->pdf->SetXY(140,249);
		$this->pdf->cell(36,2,'Nomor',0,0,'L',0);
		$this->pdf->SetXY(158,249);
		$this->pdf->cell(36,2,'Tgl',0,0,'L',0);
		$this->pdf->SetXY(173,249);
		$this->pdf->cell(36,2,'Nomor',0,0,'L',0);
		$this->pdf->SetXY(190,249);
		$this->pdf->cell(36,2,'Tgl',0,0,'L',0);
		$this->pdf->Ln();
		
		$this->pdf->SetXY(5.4,286);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(100,5,'Sesuai Lampiran I P-41/BC/2008',0,0,'L',0);
		
		$this->pdf->SetFont('times','I','8');
		$this->pdf->cell(51,5,date("d/m/Y"),0,0,'L',0);
		
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(50,5,'Lembar ke-1/2/3 untuk KPBC / BPS / BI',0,0,'L',0);
		
		$this->pdf->SetXY(5.4,10);
		
}
	
	
	
	function lembar_lanjutBrg(){
		
		$this->db->connect();
		$JUM = $this->db->query("SELECT COUNT(*) FROM TEP_TRACKINGHDR");
		$JUM->next();
		/*if($JUM->get(0)>500){
			$tbl = "TED_PEB_HDR";
			$tbldok = "TED_PEB_DOK";
			$tblbrg = "TED_PEB_BARANG";
			$tblcont = "TED_PEB_CONTAINER";
			$tblkemas = "TED_PEB_KEMASAN";
		}else{*/
			$tbl = "TET_PEB_HDR";
			$tbldok = "TET_PEB_DOK";
			$tblbrg = "TET_PEB_BARANG";
			$tblcont = "TET_PEB_CONTAINER";
			$tblkemas = "TET_PEB_KEMASAN";
		//}
		
		//Lembar lanjutan
		$this->pdf->AddPage();
		$this->pdf->SetX(5.4);
		$this->pdf->SetFont('times','B','10');
		$this->pdf->cell(121,4,'LEMBAR LANJUTAN',0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->cell(65,4,'',0,0,'C',0);
		$this->pdf->cell(110,4,'PEMBERITAHUAN EKSPOR BARANG (PEB)',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(20,4," Halaman 2 dari $nb",0,0,'R',0);//
		
		$this->pdf->Rect(5.4, 5, 198, 8.4, 3.5, 'F');
		$this->pdf->Rect(5.4, 13.4, 198, 263.6, 3.5, 'F');
		
		$this->pdf->Rect(9, 27, 10, 250, 3.5, 'F');
		$this->pdf->Rect(9, 27, 194.4, 12, 3.5, 'F');		
		$this->pdf->Rect(83.4, 27, 35,250, 3.5, 'F');
		$this->pdf->Rect(150, 27, 28,250, 3.5, 'F');
		
		
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(45,4,'Kantor Pelayanan Bea dan Cukai',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(103,4,$this->kpbc,0,0,'L',0);
		$this->pdf->cell(15,4,$this->kdkpbc,1,0,'C',0);
		
		$this->pdf->AliasNbPages();
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(45,4,'Nomor Pengajuan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(80,4,$this->noaju,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(45,4,'Nomor Pendaftaran',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(80,4,$this->noaju,0,0,'L',0);
		$this->pdf->cell(5,6,'',0,0,'L',0);
		$this->pdf->Ln();
		
		
		$this->pdf->SetX(9);
		$this->pdf->cell(1,4,'43. No',0,0,'L',0);
		$this->pdf->cell(10,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'44. Pos Tarif/HS, Uraian jumlah dan jenis',0,0,'L',0);
		$this->pdf->cell(63,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'45. HE Barang dan',0,0,'L',0);
		$this->pdf->cell(35,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'46. Jumlah & Jenis Sat,',0,0,'L',0);
		$this->pdf->cell(30,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'47.-Perijinan Ekspor',0,0,'L',0);
		$this->pdf->cell(27,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'48.Jumlah Nilai',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(1,4,'',0,0,'L',0);
		$this->pdf->cell(13,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'barang secara lengkap, merk, tipe,',0,0,'L',0);
		$this->pdf->cell(63.5,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Tarif BK pada',0,0,'L',0);
		$this->pdf->cell(35.5,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Berat Bersih (Kg)',0,0,'L',0);
		$this->pdf->cell(29.5,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'-Negara Asal',0,0,'L',0);
		$this->pdf->cell(27,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'FOB',0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(14,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'ukuran, spesifikasi lain dan kode barang',0,0,'L',0);
		$this->pdf->cell(64,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'tanggal pendaftaran',0,0,'L',0);
		$this->pdf->cell(35,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Volume (m3)',0,0,'L',0);
		$this->pdf->cell(30,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Barang',0,0,'L',0);
		$this->pdf->SetFont('times','','7');
		
		
	
		
		//sini
		/*data awal*/
		
		$maksimal_data = 14;
		$awal_data = 1;
		$no_row = 1;
		// get barang - fasilitas
		// get barang 
			$SQL10 = "SELECT 
					SEQ_BRG, SEQPEB, HS_CODE, 
					   UR_BRG, MERK, UKURAN_BRG, 
					   TIPE_BRG, KD_BRG, JML_KOLI, 
					   JNS_KOLI,pe_get.f_kemasan(JNS_KOLI) jnskoliur, FOB_BRG, FOB_PER_SAT, 
					   JML_SAT, JNS_SAT, pe_get.f_satuan(jns_sat) JNSSATur, NETTO, 
					   KD_PE, TARIP_PE, HRG_PATOK, 
					   KD_VAL, NILAI_VALUTA, JML_SAT_PE, 
					   JNS_SAT_PE, PE_PER_BRG, NCV, 
					   KD_IZIN, NO_IZIN, TGL_IZIN
					FROM ".$tblbrg." WHERE seqpeb = '".$this->seqpeb."'";
			
			$data10 = $this->db->query($SQL10);
			while($data10->next()){
				$this->nohs = $data10->get("HS_CODE");
				$this->brgurai = $data10->get("UR_BRG");
				$this->merk = $data10->get("MERK");
				$this->tipe = $data10->get("TIPE_BRG");
				$this->kemasjm = $data10->get("JML_KOLI");
				$this->nettodtl = $data10->get("NETTO");
				$this->kemasjn = $data10->get("JNS_KOLI");
				$this->kemasjn_nama = $data10->get("jnskoliur");
				$this->FOB = $data10->get("FOB_BRG");
				$this->jmlsat = $data10->get("JML_SAT");
				$this->kdsat = $data10->get("JNS_SAT");
				$this->kdsat_nama = $data10->get("JNSSATur");
				$this->peperbrg = $data10->get("PE_PER_BRG");
				$this->tarifpe = $data10->get("TARIP_PE");
		
				
				$this->pdf->Ln();
				$this->pdf->setX(10);
				$this->pdf->cell(10,4,$no_row,0,0,'L',0);
				$this->pdf->cell(75,4,$this->formaths($this->nohs),0,0,'L',0);
				
				$this->pdf->cell(15,4,'',0,0,'L',0);
//				//$this->pdf->cell(40,4,$this->strip($this->peperbrg),0,0,'L',0);
				$this->pdf->cell(10,4,'',0,0,'L',0);
				$satuan = $this->trimstr($this->kdsat.'/'.$this->kdsat_nama, 20);
				$this->pdf->cell(29.4,4,number_format($this->jmlsat,4,'.',',').' '.$satuan['str1'],0,0,'L',0);
				
				
				$dnilinv = number_format($this->FOB , 4, '.', ',');
				$this->pdf->cell(54,4,$dnilinv,0,0,'R',0);
				$urai = $this->trimstr($this->brgurai,50);
				$this->pdf->Ln();
				$this->pdf->setX(10);
				$this->pdf->cell(10,4,'',0,0,'L',0);
				//$kordinatx = $this->pdf->getx();
				//$kordinaty = $this->pdf->gety();
				//$this->pdf->MultiCell(60,4,substr($this->brgurai,0,95),0,'L');
				$almt = $this->trimstr( $this->brgurai,45);
				$this->pdf->cell(5,4,$almt['str1'],0,0,'L',0);
				$this->pdf->cell(95,4,'',0,0,'L',0);
				$this->pdf->cell(20,4,number_format($this->nettodtl,4,'.',',').' Kg',0,0,'L',0);
				$this->pdf->Ln();
				$this->pdf->setX(20);
				$this->pdf->cell(5,4,$almt['str2'],0,0,'L',0);
				$this->pdf->cell(95,4,'',0,0,'L',0);
				$this->pdf->cell(70,4,'Kemasan: '.$this->kemasjm.' '.$this->kemasjn.' / '.$this->kemasjn_nama,0,0,'L',0);
				$this->pdf->Ln();
				$this->pdf->setX(20);
				$this->pdf->cell(5,4,$almt['str3'],0,0,'L',0);
				
				
				//$this->pdf->cell(25,4,'',0,0,'L',0);
				//$this->pdf->cell(5,4,'BB: '.number_format($this->nettodtl,4,'.',',').' Kg',0,0,'L',0);
				//$this->pdf->Ln();
//				$kordinatyy = $this->pdf->gety();
//				$this->pdf->setxy($kordinatx+75,$kordinaty);
//				
				//$this->pdf->cell(25,4,'',0,0,'L',0);
				//$this->pdf->cell(45,4,'',0,0,'L',0);
//				$this->pdf->Ln();
//				
//				$jn = number_format($this->kemasjm,4,'.',',');
//				$this->pdf->Ln();
//				$this->pdf->sety($kordinatyy);			
//			
//				$this->pdf->setX(10);
//				
//				$this->pdf->cell(10,4,'',0,0,'L',0);
				//$this->pdf->cell(70,4,'Kemasan: '.$this->kemasjm.' '.$this->kemasjn.' / '.$this->kemasjn_nama,0,0,'L',0);
//				$this->pdf->cell(20,4,'',0,0,'L',0);
//				
//				$this->pdf->cell(5,4,'',0,0,'L',0);
			//	$this->pdf->cell(5,4,'BB: '.number_format($this->nettodtl,4,'.',',').' Kg',0,0,'L',0);
				//$this->pdf->Ln();
				
				
			if ($awal_data == $maksimal_data){
				$awal_data = 0;
				$this->pdf->AddPage();
				
			
				/*$this->pdf->SetX(5.4);
				$this->pdf->Rect(5.4, 9.4, 10, 12, 3.5, 'F');
				$this->pdf->Rect(15.4, 9.4, 75, 12, 3.5, 'F');
				$this->pdf->Rect(90.4, 9.4, 25, 12, 3.5, 'F');
				$this->pdf->Rect(115.4, 9.4, 30, 12, 3.5, 'F');
				$this->pdf->Rect(145.4, 9.4, 29.4, 12, 3.5, 'F');
				$this->pdf->Rect(174.8, 9.4, 29.8, 12, 3.5, 'F');
				
				$this->pdf->Rect(5.4, 21.4, 10, 250, 3.5, 'F');
				$this->pdf->Rect(15.4, 21.4, 75, 250, 3.5, 'F');
				$this->pdf->Rect(90.4, 21.4, 25, 250, 3.5, 'F');
				$this->pdf->Rect(115.4, 21.4, 30, 250, 3.5, 'F');
				$this->pdf->Rect(145.4, 21.4, 29.4, 250, 3.5, 'F');
				$this->pdf->Rect(174.8, 21.4, 29.8, 250, 3.5, 'F');
				$this->pdf->cell(10,4,'43. No',0,0,'L',0);
				$this->pdf->cell(75,4,'44. Pos Tarif/HS, Uraian jumlah dan jenis',0,0,'L',0);
				$this->pdf->cell(25,4,'45. HE Barang dan',0,0,'L',0);
				$this->pdf->cell(30,4,'46. Jumlah & Jenis Sat',0,0,'L',0);
				$this->pdf->cell(29.4,4,'47.-Perijinan Ekspor',0,0,'L',0);
				$this->pdf->cell(29.8,4,'48.Jumlah Nilai',0,0,'L',0);
				$this->pdf->Ln();
				$this->pdf->SetX(5.4);
				$this->pdf->cell(12,4,'',0,0,'L',0);
				$this->pdf->cell(75,4,'barang secara lengkap, merk, tipe,',0,0,'L',0);
				$this->pdf->cell(25,4,'Tarif BK pada',0,0,'L',0);
				$this->pdf->cell(30,4,'Berat Bersih (Kg),',0,0,'L',0);
				$this->pdf->cell(29.4,4,'-Negara Asal',0,0,'L',0);
				$this->pdf->cell(29.8,4,'FOB',0,0,'L',0);
				$this->pdf->Ln();
				$this->pdf->SetX(5.4);
				$this->pdf->cell(12,4,'',0,0,'L',0);
				$this->pdf->cell(75,4,'ukuran, spesifikasi lain dan kode barang',0,0,'L',0);
				$this->pdf->cell(25,4,'pendaftaran',0,0,'L',0);
				$this->pdf->cell(30,4,'Volume (m3)',0,0,'L',0);
				$this->pdf->cell(29.4,4,' Barang',0,0,'L',0);
				$this->pdf->cell(29.8,4,'',0,0,'L',0);
				$this->pdf->SetFont('times','','7');*/
				
				/*$this->pdf->SetXY(5.4,263);
				$this->pdf->SetFont('times','I','9');
				$this->pdf->cell(24.6,5,'Tgl. Cetak '.date("d-m-Y"),0,0,'L',0);
				
				$this->pdf->SetXY(150,250);
				$this->pdf->SetFont('times','I','9');
				$this->pdf->cell(24.6,5,date("d-m-Y"),0,0,'L',0);*/
				
				$this->pdf->SetX(5.4);
				$this->pdf->SetFont('times','B','10');
				$this->pdf->cell(121,4,'LEMBAR LANJUTAN',0,0,'R',0);
				$this->pdf->Ln();
				$this->pdf->cell(65,4,'',0,0,'C',0);
				$this->pdf->cell(110,4,'PEMBERITAHUAN EKSPOR BARANG (PEB)',0,0,'L',0);
				$this->pdf->SetFont('times','','8');
				$this->pdf->cell(20,4," Halaman 2 dari $nb",0,0,'R',0);//
				
				$this->pdf->Rect(5.4, 5, 198, 8.4, 3.5, 'F');
				$this->pdf->Rect(5.4, 13.4, 198, 263.6, 3.5, 'F');
				
				$this->pdf->Rect(9, 27, 10, 250, 3.5, 'F');
				$this->pdf->Rect(9, 27, 194.4, 12, 3.5, 'F');		
				$this->pdf->Rect(83.4, 27, 35,250, 3.5, 'F');
				$this->pdf->Rect(150, 27, 28,250, 3.5, 'F');
				
				
				$this->pdf->Ln();
				$this->pdf->SetX(9);
				$this->pdf->cell(45,4,'Kantor Pelayanan Bea dan Cukai',0,0,'L',0);
				$this->pdf->cell(2,4,':',0,0,'C',0);
				$this->pdf->cell(103,4,$this->kpbc,0,0,'L',0);
				$this->pdf->cell(15,4,$this->kdkpbc,1,0,'C',0);
				
				$this->pdf->AliasNbPages();
				$this->pdf->Ln();
				$this->pdf->SetX(9);
				$this->pdf->cell(45,4,'Nomor Pengajuan',0,0,'L',0);
				$this->pdf->cell(2,4,':',0,0,'C',0);
				$this->pdf->cell(80,4,$this->noaju,0,0,'L',0);
				$this->pdf->Ln();
				$this->pdf->SetX(9);
				$this->pdf->cell(45,4,'Nomor Pendaftaran',0,0,'L',0);
				$this->pdf->cell(2,4,':',0,0,'C',0);
				$this->pdf->cell(80,4,$this->noaju,0,0,'L',0);
				$this->pdf->cell(5,6,'',0,0,'L',0);
				$this->pdf->Ln();
				
				
				$this->pdf->SetX(9);
				$this->pdf->cell(1,4,'43. No',0,0,'L',0);
				$this->pdf->cell(10,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'44. Pos Tarif/HS, Uraian jumlah dan jenis',0,0,'L',0);
				$this->pdf->cell(63,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'45. HE Barang dan',0,0,'L',0);
				$this->pdf->cell(35,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'46. Jumlah & Jenis Sat,',0,0,'L',0);
				$this->pdf->cell(30,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'47.-Perijinan Ekspor',0,0,'L',0);
				$this->pdf->cell(27,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'48.Jumlah Nilai',0,0,'L',0);
				$this->pdf->Ln();
				$this->pdf->SetX(9);
				$this->pdf->cell(1,4,'',0,0,'L',0);
				$this->pdf->cell(13,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'barang secara lengkap, merk, tipe,',0,0,'L',0);
				$this->pdf->cell(63.5,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'Tarif BK pada',0,0,'L',0);
				$this->pdf->cell(35.5,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'Berat Bersih (Kg)',0,0,'L',0);
				$this->pdf->cell(29.5,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'-Negara Asal',0,0,'L',0);
				$this->pdf->cell(27,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'FOB',0,0,'L',0);
				$this->pdf->Ln();
				$this->pdf->SetX(9);
				$this->pdf->cell(14,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'ukuran, spesifikasi lain dan kode barang',0,0,'L',0);
				$this->pdf->cell(64,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'tanggal pendaftaran',0,0,'L',0);
				$this->pdf->cell(35,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'Volume (m3)',0,0,'L',0);
				$this->pdf->cell(30,4,'',0,0,'L',0);
				$this->pdf->cell(1,4,'Barang',0,0,'L',0);
				$this->pdf->SetFont('times','','7');
				
				
				
			}
			$awal_data++;
			$no_row++;
		}
		
			$this->pdf->SetXY(5.4,288);
			$this->pdf->SetFont('times','I','8');
			$this->pdf->cell(24.6,5,'Tgl. Cetak '.date("d-m-Y"),0,0,'L',0);
			
			$this->pdf->SetXY(150,280);
			$this->pdf->SetFont('times','','8');
			$this->pdf->cell(24.6,5,'-'.date("d-m-Y"),0,0,'L',0);
	}
	
	
	
	function lembar_lanjutDok(){
		
		$this->pdf->AddPage();
		$this->pdf->SetX(5.4);
		$this->pdf->SetFont('times','B','10');
		$this->pdf->cell(150,4,'LEMBAR LANJUTAN DOKUMEN PELENGKAP PABEAN',0,0,'R',0);
		$this->pdf->Ln();
		$this->pdf->cell(65,4,'',0,0,'C',0);
		$this->pdf->cell(110,4,'PEMBERITAHUAN EKSPOR BARANG (PEB)',0,0,'L',0);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(20,4," Halaman $nb dari $nb",0,0,'R',0);//
		
		$this->pdf->Rect(5.4, 5, 198, 8.4, 3.5, 'F');
		$this->pdf->Rect(5.4, 13.4, 198, 250.5, 3.5, 'F');
		
		$this->pdf->Rect(14, 27, 6, 236.9, 3.5, 'F');
		$this->pdf->Rect(5.4, 27, 198, 4, 3.5, 'F');		
		$this->pdf->Rect(83.4, 27, 60,236.9, 3.5, 'F');
		
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(45,4,'Kantor Pelayanan Bea dan Cukai',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(103,4,$this->kpbc,0,0,'L',0);
		$this->pdf->cell(15,4,$this->kdkpbc,1,0,'C',0);
		
		$this->pdf->AliasNbPages();
		$this->pdf->Ln();
		$this->pdf->SetX(9);
		$this->pdf->cell(45,4,'Nomor Pengajuan',0,0,'L',0);
		$this->pdf->cell(2,4,':',0,0,'C',0);
		$this->pdf->cell(80,4,$this->noaju,0,0,'L',0);
		$this->pdf->Ln();
		$this->pdf->cell(5,6,'',0,0,'L',0);
		$this->pdf->Ln();
		
		
		$this->pdf->SetX(14.5);
		$this->pdf->cell(1,4,'No',0,0,'L',0);
		$this->pdf->cell(6,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Jenis Dokumen',0,0,'L',0);
		$this->pdf->cell(83,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Nomor Dokumen',0,0,'L',0);
		$this->pdf->cell(55,4,'',0,0,'L',0);
		$this->pdf->cell(1,4,'Tanggal Dokumen',0,0,'L',0);
		$this->pdf->Ln();
		
		for($a=2;$a<=$this->jmldok;$a++){
			$this->pdf->SetX(15);
			$this->pdf->cell(8,4,$a,0,0,'L',0);
			$this->pdf->cell(63,4,$this->urdok[$a],0,0,'L',0);
			$this->pdf->cell(55,4,$this->nodok[$a],0,0,'L',0);
			$this->pdf->cell(20,4,$this->tgdok[$a],0,0,'R',0);
			$this->pdf->Ln();
		}
		
		$this->pdf->SetXY(5.4,288);
		$this->pdf->SetFont('times','I','8');
		$this->pdf->cell(24.6,5,'Tgl. Cetak '.date("d-m-Y"),0,0,'L',0);
		
		$this->pdf->SetXY(150,268);
		$this->pdf->SetFont('times','','8');
		$this->pdf->cell(24.6,5,'-'.date("d-m-Y"),0,0,'L',0);
	
	}

	
	function getDataDokPEB(){
		$func = get_instance();
		$func->load->model("main","main", true);
		/*$tbl = "TET_PEB_HDR";
		$tbldok = "TET_PEB_DOK";
		$tblbrg = "TET_PEB_BARANG";
		$tblcont = "TET_PEB_CONTAINER";
		$tblkemas = "TET_PEB_KEMASAN";*/
	
		$SQLHEADER= "Select *,f_kpbc(KODE_KPBC) URAIAN_KPBC,
					f_valuta(KODE_VALUTA) URAIAN_VALUTA,
					f_ref('JENIS_EKSPOR',JENIS_EKSPOR) URJENIS_EKSPOR,
					f_ref('KATEGORI_EKSPOR',KATEGORI_EKSPOR) URKATEGORI_EKSPOR,
					f_ref('CARA_DAGANG',CARA_DAGANG) URCARA_DAGANG,
					f_ref('CARA_BAYAR',CARA_BAYAR) URCARA_BAYAR,
					f_ref('JENIS_EKSPORTIR',STATUS_TRADER) URSTATUS_TRADER,
					f_ref('MODA', MODA) URAIAN_MODA,
					f_ref('LOKASI_PERIKSA', LOKASI_PERIKSA) URLOKASI_PERIKSA,
					CONCAT(BENDERA,' ',f_negara(BENDERA)) URAIAN_BENDERA,
					f_pelab(PELABUHAN_MUAT) URAIAN_MUAT,
					f_pelab(PELABUHAN_MUAT_EKSPOR) URAIAN_MUAT_EKSPOR,
					f_pelab(PELABUHAN_TRANSIT) URAIAN_TRANSIT,
					CONCAT(KPBC_PERIKSA,' ',f_kpbc(KPBC_PERIKSA)) URAIAN_KPBC_PERIKSA,
					f_negara(NEGARA_TUJUAN) URAIAN_NEGARA_TUJUAN,
					f_pelab(PELABUHAN_BONGKAR) URAIAN_BONGKAR,
					f_ref('KODE_ID',KODE_ID_TRADER) KODE_ID_TRADERUR,
					CONCAT(PROPINSI_BARANG,' ',f_daerah(PROPINSI_BARANG)) PROPINSI_BARANG,
					CONCAT(LOKASI_PERIKSA,'.',f_ref('LOKASI_PEMERIKSAAN',LOKASI_PERIKSA)) LOKASI_PERIKSA,
					CONCAT(CARA_PENYERAHAN_BARANG,' ',f_ref('PENYERAHAN_BARANG',CARA_PENYERAHAN_BARANG)) CARA_PENYERAHAN_BARANG
					FROM t_bc30_hdr WHERE NOMOR_AJU = '".$this->CAR."'";			
		
		$hasilHeader = $func->main->get_result($SQLHEADER);
		if($hasilHeader){
			foreach($SQLHEADER->result_array() as $row){
				$DATA = $row;
			}
		}
				
		$this->noaju = $DATA['NOMOR_AJU'];
		$this->kdkpbc = $DATA['KODE_KPBC'];
		$this->kpbc =  $DATA['URAIAN_KPBC'];
		$this->jnspeb = $DATA['URJENIS_EKSPOR'];
		$this->jnseks = $DATA['URKATEGORI_EKSPOR'];
		$this->jnsdag = '';
		$this->jnsbyr = '';
		$this->expnpwp = '';
		$this->urnpwp = '';
		$this->nodaft = '';
		$this->tgdaft= '';
		$this->expnama= '';
		$this->expalmt= '';
		$this->nosiup= '';
		$this->tgsiup= '';
		$this->expstat= '';
		$this->expstatur= '';
		$this->seqpeb= '';
		$this->nmbeli= '';
		$this->almbeli= '';
		$this->negbeli= '';
		$this->negur= '';
		$this->kdlokbrng= '';
		$this->KDLOKBRGur= '';
		$this->tgsiap= '';
		$this->kpbcperiksa= '';
		$this->kpbcperiksaur= '';
		$this->negtuju= '';
		$this->negtujuur= '';
		$this->drhaslbrg= '';
		$this->ppjknpwp= '';
		$this->ppjknama='';
		$this->ppjkalmt= '';
		$this->ppjkno= '';
		$this->ppjktg= '';
		//QQ
		$this->QQID= '';
		$this->QQNPWP= '';
		$this->QQNAMA= '';
		$this->QQALMT= '';
		$this->QQNIPER = '';
		$this->moda = '';
		$this->modaur = '';
		$this->serah = '';
		$this->serahur = '';
		$this->tgeks = '';
		$this->CARRIER = '';
		$this->VOY = '';
		$this->PELMUAT = '';
		$this->PELMUATur = '';
		$this->KDVAL = '';
		$this->KDVALur = '';
		$this->freight = '';
		$this->PELBONGKAR = '';
		$this->PELBONGKARur = '';
		$this->PELTRANSIT = '';
		$this->PELTRANSITur = '';
		$this->asuransi = '';
		$this->FOB = '';
		$this->netto = '';
		$this->bruto = '';
		$this->NOBCF = '';
		$this->TGBCF = '';
		$this->EXPNIPER = '';
		$this->EXPNOTDP = '';
		$this->EXPTGTDP = '';
		$this->BENDERA = '';
		$this->BENDERAur = '';
		$this->PROPBRG='';
		$this->PROPBRGur= '';
		$this->VOLUME='';
		$this->NILAIBK= '';
		$this->PNBP= '';
		$this->JMCONT= '';
		$this->TTDPEB= '';
		 
		
		
		$this->kdfas = '';
		$this->lengkap = '';
		$this->cusdecid = '';
		$this->impid_ur = '';
		$this->moda_nama =  '';
		$this->angkut_negara = '';
			
		$this->fasilitas =  '';
		$this->pelmuat_nama =  '';	
		$this->peltransit_nama = '';	
		$this->pelbkr_nama =  '';
			
			
		$SQLDOK = "SELECT NOMOR,TANGGAL  
				FROM t_bc30_dok
				WHERE kd_dok = '380' AND 
				NOMOR_AJU = '".$this->CAR."'";
		$hasilDok = $func->main->get_result($SQLDOK);
		if($hasilDok){
			$i = 1;
			$this->invno="";
			$this->invtgl="";
			foreach($SQLDOK->result_array() as $rowDok){
				$dataDok = $rowDok;
				$i = $i + 1;
			}
		}
			
		$data2 = $this->db->query($SQL);
		$i = 1;
		$this->invno="";
		$this->invtgl="";
		while($data2->next()){
			$this->invno[$i]="";
			$this->invno[$i] = $data2->get("no_dok");
			$this->invtgl[$i] = $data2->get("tgldok");
		$i = $i + 1;
		}		
			
		if($i >3){
			$this->invno = '';
			$this->invtgl = '';
			$this->invno[1] = '==lihat lampiran==';
		}				
			
			
			///dok
			$SQL11 = "SELECT no_dok, to_char(tgl_dok,'DD-MM-RRRR') as tgldok, pe_get.f_ur_dok(KD_DOK) Urdok  
					FROM ".$tbldok." 
					WHERE seqpeb = '".$this->seqpeb."'";
			$data11 = $this->db->query($SQL11);			
			$i = 1;
			$jmldok = $data11->size();
			$this->nodok="";
			$this->tgdok="";
			$this->urdok="";
			$this->jmldok = $jmldok;
			while($data11->next()){
				$this->nodok[$i]="";
				$this->nodok[$i] = $data11->get("no_dok");
				$this->tgdok[$i] = $data11->get("tgldok");
				$this->urdok[$i] = $data11->get("Urdok");
			$i = $i + 1;
			}	
			
			
			// izin khusus
			//sie
			$SQL3 = "SELECT no_dok, to_char(tgl_dok,'DD-MM-RRRR') as tgldok
					FROM ".$tbldok." 
					WHERE kd_dok = '811' and 
						seqpeb = '".$this->seqpeb."'";
			$data3 = $this->db->query($SQL3);			
			$i = 1;
			$this->nosie="";
			$this->tgsie="";
			while($data3->next()){
				$this->nosie[$i]="";
				$this->nosie[$i] = $data3->get("no_dok");
				$this->tgsie[$i] = $data3->get("tgldok");
			$i = $i + 1;
			}	
			
			//karantina
			$SQL4 = "SELECT no_dok, to_char(tgl_dok,'DD/MM/RRRR') as tgldok  
					FROM ".$tbldok." 
					WHERE kd_dok in (851,853) and 
						seqpeb = '".$this->seqpeb."'";
			$data4 = $this->db->query($SQL4);			
			$i = 1;
			$this->nokrt="";
			$this->tgkrt="";
			while($data4->next()){
				$this->nokrt[$i]="";
				$this->nokrt[$i] = $data4->get("no_dok");
				$this->tgkrt[$i] = $data4->get("tgldok");
			$i = $i + 1;
			}	
			
			// sm/spm
			$SQL5 = "SELECT no_dok, to_char(tgl_dok,'DD/MM/RRRR') as tgldok  
					FROM ".$tbldok." 
					WHERE kd_dok = '810' and 
						seqpeb = '".$this->seqpeb."'";
			$data5 = $this->db->query($SQL5);			
			$i = 1;
			$this->nosmpm="";
			$this->tgsmpm="";
			while($data5->next()){
				$this->nosmpm[$i]="";
				$this->nosmpm[$i] = $data5->get("no_dok");
				$this->tgsmpm[$i] = $data5->get("tgldok");
			$i = $i + 1;
			}	
			
			
			// lainnya
			$SQL6 = "SELECT no_dok, to_char(tgl_dok,'DD/MM/RRRR') as tgldok  
					FROM ".$tbldok." 
					WHERE kd_dok = '999' and 
						seqpeb = '".$this->seqpeb."'";
			$data6 = $this->db->query($SQL6);			
			$i = 1;
			$this->nolain="";
			$this->tglain="";
			while($data6->next()){
				$this->nolain[$i]="";
				$this->nolain[$i] = $data6->get("no_dok");
				$this->tglain[$i] = $data6->get("tgldok");
			$i = $i + 1;
			}	
			
			// Peti Kemas
			$SQL7 = "SELECT 
					SEQPEB, SERI_CONT, NO_CONT, 
					   NO_SEGEL, UKURAN,TIPE, PE_GET.F_UR_TAB('TIPE_CON',TIPE) TIPEUR , 
					   STUFF, JNPARTOF
					FROM ".$tblcont."	WHERE seqpeb = '".$this->seqpeb."'";
			//echo "<br> $SQL";
			$data7 = $this->db->query($SQL7);
			$i = 1;
			$this->contno="";
			$this->contukur="";
			$this->conttipe="";
			$this->conttipeur="";
			while($data7->next()){
				$this->contno[$i] = $data7->get("NO_CONT");
				$this->contukur[$i] = $data7->get("UKURAN");
				$this->conttipe[$i] = $data7->get("TIPE");
				$this->conttipeur[$i] = $data7->get("TIPEUR");
			$i = $i + 1;	
			}	
			
			
			// Jenis Kemasan
			$SQL8 = "SELECT 
					SERI_KMS, SEQPEB, JML_KMS, 
					   JNS_KMS, NO_SEGEL, pe_get.f_kemasan(jns_kms) kmsur
					FROM ".$tblkemas." WHERE seqpeb = '".$this->seqpeb."'";
			//echo "<br> $SQL";
			$data8 = $this->db->query($SQL8);
			$i = 1;
			while($data8->next()){
				$this->jnkemas[$i] = $data8->get("JNS_KMS");
				$this->jmkemas[$i] = $data8->get("JML_KMS");
				$this->jnkemas_nama[$i]  = $data8->get("kmsur");
				$jeniskms = $this->jnkemas[$i];
			$i = $i + 1;
			}
			
			
			$SQL9 = "SELECT COUNT(*) as JUMLAH FROM ".$tblbrg." WHERE seqpeb = '".$this->seqpeb."'";
			$data9 = $this->db->query($SQL9);
			$data9->next();
			$this->jmbrg = $data9->get("JUMLAH");
			
			// get barang 
			$SQL10 = "SELECT 
					SEQ_BRG, SEQPEB, HS_CODE, 
					   UR_BRG, MERK, UKURAN_BRG, 
					   TIPE_BRG, KD_BRG, JML_KOLI, 
					   JNS_KOLI,pe_get.f_kemasan(JNS_KOLI) jnskoliur, FOB_BRG, FOB_PER_SAT, 
					   JML_SAT, JNS_SAT, pe_get.f_satuan(jns_sat) JNSSATur, NETTO, 
					   KD_PE, TARIP_PE, HRG_PATOK, 
					   KD_VAL, NILAI_VALUTA, JML_SAT_PE, 
					   JNS_SAT_PE, PE_PER_BRG, NCV, 
					   KD_IZIN, NO_IZIN, TGL_IZIN
					FROM ".$tblbrg." WHERE seqpeb = '".$this->seqpeb."'";
			
			$data10 = $this->db->query($SQL10);
			if($data10->next()){
				$this->nohs = $data10->get("HS_CODE");
				$this->brgurai = $data10->get("UR_BRG");
				$this->merk = $data10->get("MERK");
				$this->tipe = $data10->get("TIPE_BRG");
				$this->kemasjm = $data10->get("JML_KOLI");
				$this->nettodtl = $data10->get("NETTO");
				$this->kemasjn = $data10->get("JNS_KOLI");
				$this->kemasjn_nama = $data10->get("jnskoliur");
				$this->FOB = $data10->get("FOB_BRG");
				$this->jmlsat = $data10->get("JML_SAT");
				$this->kdsat = $data10->get("JNS_SAT");
				$this->kdsat_nama = $data10->get("JNSSATur");
				$this->peperbrg = $data10->get("PE_PER_BRG");
				$this->tarifpe = $data10->get("TARIP_PE");
				
			}			
				
		
	
	}
}

$print = new cetakPEB($CAR);
$print->displayPDF();

?>