<?php

$this->load->library('fpdf');
//define('FPDF_FONTPATH',$this->config->item('fonts_path'));

class printForm extends FPDF
{
	var $visibility='all';
	var $n_ocg_print;
	var $n_ocg_view;
	var $widths;
	var $aligns;
	var $db;
	var $publicFunction;
	var $row;
	var $countryLogin;
	var $rowcase;
	var $model_sesi;
	var $session;
	
	function SetVisibility($v)
	{
		if($this->visibility!='all')
			$this->_out('EMC');
		if($v=='print')
			$this->_out('/OC /OC1 BDC');
		elseif($v=='screen')
			$this->_out('/OC /OC2 BDC');
		elseif($v!='all')
			$this->Error('Incorrect visibility: '.$v);
		$this->visibility=$v;
	}
	
	function _endpage()
	{
		$this->SetVisibility('all');
		parent::_endpage();
	}
	
	function _enddoc()
	{
		if($this->PDFVersion<'1.5')
			$this->PDFVersion='1.5';
		parent::_enddoc();
	}
	
	function _putocg()
	{
		$this->_newobj();
		$this->n_ocg_print=$this->n;
		$this->_out('<</Type /OCG /Name '.$this->_textstring('print'));
		$this->_out('/Usage <</Print <</PrintState /ON>> /View <</ViewState /OFF>>>>>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->n_ocg_view=$this->n;
		$this->_out('<</Type /OCG /Name '.$this->_textstring('view'));
		$this->_out('/Usage <</Print <</PrintState /OFF>> /View <</ViewState /ON>>>>>>');
		$this->_out('endobj');
	}
	
	function _putresources()
	{
		$this->_putocg();
		parent::_putresources();
	}
	
	function _putresourcedict()
	{
		parent::_putresourcedict();
		$this->_out('/Properties <</OC1 '.$this->n_ocg_print.' 0 R /OC2 '.$this->n_ocg_view.' 0 R>>');
	}
	
	function _putcatalog()
	{
		parent::_putcatalog();
		$p=$this->n_ocg_print.' 0 R';
		$v=$this->n_ocg_view.' 0 R';
		$as="<</Event /Print /OCGs [$p $v] /Category [/Print]>> <</Event /View /OCGs [$p $v] /Category [/View]>>";
		$this->_out("/OCProperties <</OCGs [$p $v] /D <</ON [$p] /OFF [$v] /AS [$as]>>>>");
	}
	
	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
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
		
			return array ("str1" => substr($strpotong,0,$potong), "str2" => substr($strpotong,$potong+1,$panjang));
		}else{
			return array ("str1" => $strpotong, "str2" => "");
			//$terbilang[0]	= $rupiah;
		}		
	}
	function gettbltabel($dicari1,$dicari2){
		/*$this->db->connect();
		$SQL = "Select uraian from tbltab where kdtab = '$dicari2' and kdnsw = '$dicari1'";
		$data = $this->db->query($SQL);
		if($data->next()){
			$gettbltabel = $data->get("uraian");
			return $gettbltabel;
		$this->db->disconnect();
		}
		else
		{
			$gettbltabel = "";
			return $gettbltabel;
		}*/
	}
	function setnocont($nocont){
		if (count($nocont) != 0){ 
			$hasile = substr($nocont,0,4).'-'.substr($nocont,4,11);
		}
		return $hasile;
	}
	function formaths($hs){
		//$formaths = substr($hs,0,4).'.'.substr($hs,4,2).'.'.substr($hs,6,2).'.'.substr($hs,8,2);
		$formaths = substr($hs,0,4).'.'.substr($hs,4,2).'.'.substr($hs,6,4);
		return $formaths;
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
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
	
	function Row($data,$heightMultiCell=5, $showBorder=true, $halaman=1, $indexData=1, $banyakData=1, $showNumber=true, $writeTag=false)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++){
			$dataTemp = str_replace("<vb>","",$data[$i]);
			$dataTemp = str_replace("</vb>","",$data[$i]);
			
			$nb=max($nb,$this->NbLines($this->widths[$i],$dataTemp));
		}
		$h=$heightMultiCell*$nb;
		$selisihNomor = $banyakData - $indexData;
		
		//Issue a page break first if needed
		//$this->CheckPageBreak($h);
		$this->CheckPageBreak($h, $showNumber, $halaman, $selisihNomor);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			
			$this->SetFont('arial','',7);
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			if ($showBorder)
				$this->Rect($x,$y,$w,$h);
			//Print the text
			//$this->MultiCell($w,$heightMultiCell,$data[$i],0,$a);
			if ($writeTag)
			{
				$this->WriteTag($w,$heightMultiCell,$data[$i],0,$a,0,0);
				//$this->Ln(0);
			}
			else
			{
				$this->MultiCell($w,$heightMultiCell,$data[$i],0,$a);
			}
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	
	function CheckPageBreak($h, $showNumber, $halaman, $selisihNomor)
	{
		if ($showNumber)
		{
			$tambahBaris = ($selisihNomor == 0)?60:0;
			$batasAman = 225;
			if(($this->GetY()+$h+$tambahBaris)>$batasAman)
			{
				$this->AddPage($this->CurOrientation);
				$this->SetXY(12,133);
				
			}
		}
		else
		{
			if($this->GetY()+$h>$this->PageBreakTrigger)
				$this->AddPage($this->CurOrientation);
		}
	}
	
	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}

	function Header()
	{
		$this->SetVisibility('screen');
		
		$this->SetX(5.4);
		$this->SetFont('times','B','12');
		$this->cell(156,4,'PEMBERITAHUAN IMPOR BARANG UNTUK DITIMBUN DI',0,0,'R',0);
		$this->SetFont('times','','9');
		
		$this->SetX(5.4);
		$this->SetFont('times','B','12');
		$this->cell(131.6,13,'TEMPAT PENIMBUNAN BERIKAT',0,0,'R',0);
		$this->SetFont('times','','9');
		$this->cell(67.6,4,'BC 2.3',0,0,'R',0);
		
		//KPBC
		$this->Rect(5.4, 15.4, 199.2, 20, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(45,4,'Kantor Pelayanan Bea dan Cukai',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(103,4,$this->kpbc,0,0,'L',0);
		$this->cell(15,4,$this->kdkpbc,1,0,'C',0);
		//$this->cell(30,4,' Halaman 1 dari {nb}',0,0,'R',0);	
		//$hapus = strlen($this->pages[$this->page]);	
		$this->cell(30,4," Halaman 1 dari $nb",0,0,'R',0);//
		//$this->tes[] = substr($this->pages[$this->page],$hapus);
		$this->AliasNbPages();
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(45,4,'Nomor Pengajuan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(80,4,$this->noaju,0,0,'L',0);
		$this->Ln();
		
		// Section A
		$this->SetX(5.4);
		$this->cell(40,4,'A . Jenis PIB',0,0,'L',0);
		$this->cell(5,4,'',0,0,'C',0);
		$this->cell(5,3,$this->jnpib,1,0,'C',0);
		$this->cell(30,4,'1. Biasa',0,0,'L',0);
		$this->cell(30,4,'2. Berkala',0,0,'L',0);
		$this->cell(89.2,4,'3. Penyelesaian',0,0,'L',0);
		$this->Ln();
		
		// Section B
		$this->SetX(5.4);
		$this->cell(40,4,'B . Jenis Import',0,0,'L',0);
		$this->cell(5,4,'',0,0,'C',0);
		$this->cell(5,3,$this->jnimp,1,0,'C',0);
		$this->cell(30,4,'1. Untuk Dipakai',0,0,'L',0);
		$this->cell(30,4,'2. Sementara',0,0,'L',0);
		$this->cell(30,4,'3. Reimpor',0,0,'L',0);
		$this->cell(30.2,4,'5. Pelayanan Segera',0,0,'L',0); 
		$this->cell(30.2,4,'6. Vooruitslag',0,0,'L',0); 
		$this->Ln();
		
		// Section C
		$this->SetX(5.4);
		$this->cell(40,4,'C . Jenis Pembayaran',0,0,'L',0);
		$this->cell(5,4,'',0,0,'C',0);
		$this->cell(5,3,$this->crbyr,1,0,'C',0);
		$this->cell(30,4,'1. Biasa/Tunai',0,0,'L',0);
		$this->cell(30,4,'2. Berkala',0,0,'L',0);
		$this->cell(30,4,'3. Dengan Jaminan',0,0,'L',0);
		$this->cell(59.2,4,'9. Lainnya',0,0,'L',0); 
		
		// Section D
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(40,4,'D. DATA PEMBERITAHUAN',0,0,'L',0);

		//PEMASOK
		$this->Rect(5.4, 33.4, 99.6, 16, 3.5, 'F');
		$this->Rect(105, 33.4, 99.6, 16, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(79.6,4,'PEMASOK',0,0,'L',0);
		$this->cell(20,4,$this->pasokneg,1,0,'C',0);
		$this->cell(99.6,4,'F. DIISI OLEH BEA DAN CUKAI',0,0,'L',0);
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(99.6,4,'1. Nama, Alamat, Negara',0,0,'L',0);
		$this->cell(54.6,4,'No. & Tgl Pendaftaran',0,0,'L',0);
		$this->cell(20,4,$this->pibno,1,0,'L',0);
		$this->cell(5,4,'',0,0,'L',0);
		$this->cell(20,4,$this->pibtg,1,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		
		$this->cell(3,4,'',0,0,'L',0);
		$this->cell(96.6,4,$this->pasoknama,0,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(3,4,'',0,0,'L',0);
		$pskalmt = $this->trimstr($this->pasokalmt,50);
		$this->cell(96.6,4,$pskalmt['str1'],0,0,'L',0);

		
		//IMPORTIR 
		if (($this->indid != "") or ($this->indid != NULL) or ($this->indid != '')) {
			$this->Rect(5.4, 49.4, 99.6, 32, 3.5, 'F');
			$this->Rect(105, 49.4, 99.6, 32, 3.5, 'F');
			$this->Ln();
			$this->cell(99.6,4,'IMPORTIR',0,0,'L',0);
			$this->cell(20,4,'15. Invoice',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(50,4,$this->invno[1],0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->invtgl[1],0,0,'L',0);
			$this->Ln();
			$this->cell(25,4,'2. Identitas',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(69.6,4,$this->impid_nama.' / '.$this->impid,0,0,'L',0);
			if (trim($this->invno[2] != "") || trim($this->invtgl[2] != "")){
			$this->cell(20,4,'',0,0,'L',0);
			$this->cell(5,4,'',0,0,'C',0);
			$this->cell(50,4,$this->invno[2],0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->invtgl[2],0,0,'L',0);
			}
	
			$imppj = strlen(trim($this->impnpwp));
			if($imppj==15){
				$npwpppjknya = $this->formatNPWP15($this->impnpwp);
			} else {
				$npwpppjknya = $this->formatNPWP12($this->impnpwp);
			}
			/*
			$indpwp = strlen(trim($this->indnpwp));
			if($indpwp!=""){
				if($indpwp==15){
					$npwpindknya = " QQ ".$this->formatNPWP15($this->indnpwp);
				} else {
					$npwpindknya = " QQ ".$this->formatNPWP12($this->indnpwp);
				}
				$namaindknya = $this->impnama." QQ ".$this->indnama;
				$almtindknya = $this->impalmt." QQ ".$this->indalmt;
			} else {*/
			$npwpindknya = "";
			$namaindknya = $this->impnama;
			//}
			
			$npwpnyaitu = $npwpppjknya.$npwpindknya;
			$namanyaitu = $namaindknya;
			
			$this->Ln();
			$this->cell(3,4,'',0,0,'L',0);
			$this->cell(96.6,4,$npwpnyaitu,0,0,'L',0);
			if (trim($this->invno[3] != "") || trim($this->invtgl[3] != "")){
				$this->cell(20,4,'',0,0,'L',0);
				$this->cell(5,4,'',0,0,'C',0);
				$this->cell(50,4,$this->invno[3],0,0,'L',0);
				$this->cell(24,4,'Tgl. '.$this->invtgl[3],0,0,'L',0);
			}
			$this->Ln();
			$this->cell(25,4,'3. Nama, Alamat',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(69.6,4,'',0,0,'L',0);
			$this->cell(20,4,'16. LC',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(50,4,$this->lcno,0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->lctgl,0,0,'L',0);
			$this->Ln();
			$this->cell(3,4,'',0,0,'L',0);
			$this->cell(96.6,4,$namanyaitu,0,0,'L',0);
			$this->Ln();
			$this->cell(3,4,'',0,0,'L',0);
			$imalmt = $this->trimstr($this->impalmt,50);
			//$indalmt = $this->trimstr($this->indalmt,50);
			$this->cell(96.6,4,$imalmt['str1'],0,0,'L',0);
			$this->cell(20,4,'17. BL/AWB',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(50,4,$this->blawbno[1],0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->blawbtgl[1],0,0,'L',0);
			$this->Ln();
			$this->cell(3,4,'',0,0,'L',0);
			//$this->cell(96.6,4,$indalmt['str1'],0,0,'L',0);
		} else {
			$this->Rect(5.4, 49.4, 99.6, 32, 3.5, 'F');
			$this->Rect(105, 49.4, 99.6, 32, 3.5, 'F');
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			
			$this->cell(99.6,4,'IMPORTIR',0,0,'L',0);
			$this->cell(20,4,'15. Invoice',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(50,4,$this->invno[1],0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->invtgl[1],0,0,'L',0);
			$this->Ln();
			
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			
			$this->cell(25,4,'2. Identitas',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(40.6,4,$this->impid_ur.' / '.$this->impid,0,0,'L',0);
			if (trim($this->invno[2] != "") || trim($this->invtgl[2] != "")){
				$this->setX(105.5);
				$this->cell(20,4,'',0,0,'L',0);
				$this->cell(5,4,'',0,0,'C',0);
				$this->cell(50,4,$this->invno[2],0,0,'L',0);
				$this->cell(24,4,'Tgl. '.$this->invtgl[2],0,0,'L',0);
			}
	
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$imppj = strlen(trim($this->impnpwp));
			if($imppj==15){
				$formatimpNPWP= substr($this->impnpwp,0,2) .".". substr($this->impnpwp,2,3) .".". substr($this->impnpwp,5,3) .".". substr($this->impnpwp,8,1) ."-". substr($this->impnpwp,9,3) .".". substr($this->impnpwp,12,3);
			} else {
				$formatimpNPWP= substr($this->impnpwp,0,2) .".". substr($this->impnpwp,2,3) .".". substr($this->impnpwp,5,3) .".". substr($this->impnpwp,8,1) ."-". substr($this->impnpwp,9,3);
			}
			
			
			$this->Ln();
			$this->cell(3,4,'',0,0,'L',0);
			$this->cell(96.6,4,$formatimpNPWP."",0,0,'L',0);
			if (trim($this->invno[3] != "") || trim($this->invtgl[3] != "")){
			$this->cell(20,4,'',0,0,'L',0);
			$this->cell(5,4,'',0,0,'C',0);
			$this->cell(50,4,$this->invno[3],0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->invtgl[3],0,0,'L',0);
			}
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$this->cell(25,4,'3. Nama, Alamat',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(69.6,4,$this->impnama,0,0,'L',0);
			
			
			$this->cell(20,4,'16. LC',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(50,4,$this->lcno,0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->lctgl,0,0,'L',0);
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			
			$imalmt = $this->trimstr($this->impalmt,50);
			
			$this->cell(3,4,'',0,0,'L',0);
			$this->cell(96.6,4,$imalmt['str1'],0,0,'L',0);
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$this->cell(3,4,'',0,0,'L',0);
			
			$this->cell(96.6,4,'',0,0,'L',0);
			$this->cell(20,4,'17. BL/AWB',0,0,'L',0);
			$this->cell(5,4,':',0,0,'C',0);
			$this->cell(50,4,$this->blawbno[1],0,0,'L',0);
			$this->cell(24,4,'Tgl. '.$this->blawbtgl[1],0,0,'L',0);
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$this->cell(3,4,'',0,0,'L',0);
			$this->cell(96.6,4,$imalmt['str2'],0,0,'L',0);
		}
		//IMPORTIR
		$impstatus_a=substr($this->impstatus,0,1);
		switch ($impstatus_a){
		 case 1:
			$impstatus_a_nama = "IU";
			break;
		 case 2:
			$impstatus_a_nama = "IP";
			break;
		 case 3:
			$impstatus_a_nama = "IT";
			break;
		 case 4:
			$impstatus_a_nama = "AT";
			break;
		 case 5:
			$impstatus_a_nama = "BULOG";
			break;
		 case 6:
			$impstatus_a_nama = "PERTAMINA";
			break;
		 case 7:
			$impstatus_a_nama = "DAHANA";
			break;
		 case 8:
			$impstatus_a_nama = "IPTN";
			break;
		}
		$impstatus_b=substr($this->impstatus,1,1);
		switch ($impstatus_b){
		 case 1:
			$impstatus_b_nama = "IU";
			break;
		 case 2:
			$impstatus_b_nama = "IP";
			break;
		 case 3:
			$impstatus_b_nama = "IT";
			break;
		 case 4:
			$impstatus_b_nama = "AT";
			break;
		 case 5:
			$impstatus_b_nama = "BULOG";
			break;
		 case 6:
			$impstatus_b_nama = "PERTAMINA";
			break;
		 case 7:
			$impstatus_b_nama = "DAHANA";
			break;
		 case 8:
			$impstatus_b_nama = "IPTN";
			break;
		}
		$impstatus_c=substr($this->impstatus,2,1);
		switch ($impstatus_c){
		 case 1:
			$impstatus_c_nama = "IU";
			break;
		 case 2:
			$impstatus_c_nama = "IP";
			break;
		 case 3:
			$impstatus_c_nama = "IT";
			break;
		 case 4:
			$impstatus_c_nama = "AT";
			break;
		 case 5:
			$impstatus_c_nama = "BULOG";
			break;
		 case 6:
			$impstatus_c_nama = "PERTAMINA";
			break;
		 case 7:
			$impstatus_c_nama = "DAHANA";
			break;
		 case 8:
			$impstatus_c_nama = "IPTN";
			break;
		}
		if (trim($this->blawbno[2] != "") || trim($this->blawbtgl[2] != "")){
		$this->cell(62,4,'',0,0,'C',0);
		$this->cell(60,4,'',0,0,'C',0);
		$this->cell(50,4,$this->blawbno[2],0,0,'L',0);
		$this->cell(24,4,'Tgl. '.$this->blawbtgl[2],0,0,'L',0);
		}
		$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(15,4,'4. Status :',0,0,'L',0);
		$this->cell(34.6,4,$impstatus_a_nama.' '.$impstatus_b_nama.' '.$impstatus_c_nama,0,0,'L',0);
		$this->cell(20,4,'5. API/APIT :',0,0,'L',0);
		$this->cell(30,4,$this->apino,0,0,'L',0);
		if ($this->doktupkd == "1") {
			$tglDoktub = $this->doktuptg;
			$kodeDokTub = "BC1.1";
		} else if ($this->doktupkd == "2") {
			$kodeDokTub = "BC1.2";
		} else if ($this->doktupkd == "3") {
			$kodeDokTub = "BC1.3";
		} else if ($this->doktupkd == "4") {
			$kodeDokTub = "Lainnya";
		} else {
			$tglDoktub = "";
			$kodeDokTub = "BC1.1";
		}
		$this->cell(20,4,'18. '.$kodeDokTub,0,0,'L',0);
		$this->cell(5,4,':',0,0,'C',0);
		$this->cell(15,4,$this->doktupno,0,0,'L',0);
		$this->cell(7.5,4,'Pos :',0,0,'L',0);
		$this->cell(10,4,$this->posno,0,0,'L',0);
		$this->cell(7.5,4,'Sub :',0,0,'L',0);
		$this->cell(10,4,$this->possub,0,0,'L',0);
		$this->cell(24.6,4,'Tgl. '.$tglDoktub,0,0,'L',0);

		//PPJK
		$this->Rect(5.4, 81.4, 99.6, 20, 3.5, 'F');
		$this->Rect(105, 81.4, 99.6, 20, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(99.6,4,'PPJK',0,0,'L',0);
		$this->cell(79.6,4,'19. Skep Fasilitas Pemenuhan Persyaratan Impor :',0,0,'L',0);
		$this->cell(20,4,$this->kdfas,1,0,'C',0);

		$ppjkpj = strlen(trim($this->ppjknpwp));
		if($ppjkpj==15){
			$formatppjkNPWP= substr($this->ppjknpwp,0,2) .".". substr($this->ppjknpwp,2,3) .".". substr($this->ppjknpwp,5,3) .".". substr($this->ppjknpwp,8,1) ."-". substr($this->ppjknpwp,9,3) .".". substr($this->ppjknpwp,12,3);
		} else {
			$formatppjkNPWP= substr($this->ppjknpwp,0,2) .".". substr($this->ppjknpwp,2,3) .".". substr($this->ppjknpwp,5,3) .".". substr($this->ppjknpwp,8,1) ."-". substr($this->ppjknpwp,9,3);
		}

		$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(25,4,'6. NPWP',0,0,'L',0);
		$this->cell(5,4,':',0,0,'C',0);
		$this->cell(69.6,4,$formatppjkNPWP,0,0,'L',0);
		$this->cell(3,4,'',0,0,'C',0);
		$this->cell(96.6,4,$this->gettbltabel($this->kdfas,'75'),0,0,'L',0);
		$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(25,4,'7. Nama, Alamat',0,0,'L',0);
		$this->cell(5,4,':',0,0,'C',0);
		$this->cell(64.6,4,$this->ppjknama,0,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(3,4,'',0,0,'L',0);
		$pjkalmt = $this->trimstr($this->ppjkalmt,50);
		$this->cell(96.6,4,$pjkalmt['str1'],0,0,'L',0);
		$this->Ln();
		$this->SetX(5.4);
		//$this->cell(25,4,'8. No. & Surat Izin :',0,0,'L',0);
		//$this->cell(34.6,4,' ',0,0,'C',0);
		//$this->cell(20,4,$this->ppjkno,1,0,'C',0);
		//$this->cell(20,4,$this->ppjktg,1,0,'R',0);
		$this->cell(25,4,'8. No. & Tgl Surat Izin :',0,0,'L',0);
		$this->cell(34.6,4,' ',0,0,'C',0);
		$this->cell(20,4,$this->ppjkno,1,0,'C',0);
		$this->cell(20,4,$this->ppjktg,1,0,'L',0);
		if (trim($this->kdfas) == '') {
			if ($this->skepkd == '911') {
				$this->cell(30,4,'Nomor/Tanggal',0,0,'C',0);
				$this->cell(30.6,4,$this->skepno,0,0,'L',0);
				$this->cell(30,4,'Tgl. '.$this->skeptgl,0,0,'C',0);
			} else {
				$this->cell(30,4,'Nomor/Tanggal',0,0,'C',0);
				$this->cell(30.6,4,"",0,0,'L',0);
				$this->cell(30,4,'Tgl. ',0,0,'C',0);
			}
		} else {
			$this->cell(30,4,'Nomor/Tanggal',0,0,'C',0);
			$this->cell(30.6,4,$this->skepno,0,0,'L',0);
			$this->cell(30,4,'Tgl. '.$this->skeptgl,0,0,'C',0);
		}		 
		//MODA
		$this->Rect(5.4, 101.4, 99.6, 8, 3.5, 'F');
		$this->Rect(105, 101.4, 99.6, 8, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(79.6,4,'9. Cara Pengangkutan',0,0,'L',0);
		$this->cell(20,4,$this->moda,1,0,'C',0);
		$this->cell(79.6,4,'20. Tempat Penimbunan',0,0,'L',0);
		$this->cell(20,4,$this->tmptbn,1,0,'C',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(99.2,4,$this->moda_nama,0,0,'C',0);
		$this->cell(99.2,4,$this->tmptbn_nama,0,0,'C',0);

		//Nama Sarana
		$this->Rect(5.4, 109.4, 99.6, 8, 3.5, 'F');
		$this->Rect(105, 109.4, 49.8, 8, 3.5, 'F');
		$this->Rect(154.8, 109.4, 49.8, 8, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(79.6,4,'10. Nama Sarana Pengangkut & No. Voy/Flight dan Bendera',0,0,'L',0);
		$this->cell(20,4,$this->angkutfl,1,0,'C',0);
   		$this->cell(29.8,4,'21. Valuta',0,0,'L',0);
		$this->cell(20,4,$this->kdval,1,0,'C',0);
		$this->cell(49.8,4,'22. NDPBM',0,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(3,4,'',0,0,'L',0);
		$this->cell(46.6,4,$this->angkutnama,0,0,'L',0);
		$this->cell(20,4,$this->angkutno,0,0,'L',0);
		$this->cell(20,4,$this->angkut_negara,0,0,'L',0);
		
		$this->cell(49.8,4,$this->valuta,0,0,'R',0);
/*		if($this->kdval == "USD"){
			$this->cell(49.8,4,'US Dollar',0,0,'R',0);
		}elseif($this->kdval == "EUR"){
			$this->cell(49.8,4,'EURO',0,0,'R',0);
		}elseif($this->kdval == "IDR"){
			$this->cell(49.8,4,'Indonesian Rupiah',0,0,'R',0);
		}*/
		$ndpbm = number_format($this->ndpbm, 4, '.', ',');
		$this->cell(49.8,4,$ndpbm,0,0,'R',0);

		//Tanggal Tiba
		$this->Rect(5.4, 117.4, 99.6, 4, 3.5, 'F');
		$this->Rect(105, 117.4, 99.6, 4, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(35,4,'11. Perkiraan Tgl Tiba :',0,0,'L',0);
		$this->cell(64.6,4,$this->tgtiba,0,0,'L',0);
		if ($this->kdhrg == "1") {
			$FOB = "CIF";
		} else if ($this->kdhrg == "2") {
			$FOB = "CNF";
		} else if ($this->kdhrg == "3") {
			$FOB = "FOB";
		} else {
			$FOB = "FOB";
		}
		$this->cell(25,4,'23. '.$FOB.' :',0,0,'L',0);
		$fob = number_format($this->fob, 4, '.', ',');
		$this->cell(74.9,4,$fob,0,0,'R',0);

		//Pelabuhan
		$this->Rect(5.4, 121.4, 99.6, 12, 3.5, 'F');
		$this->Rect(105, 121.4, 49.8, 12, 3.5, 'F');
		$this->Rect(154.8, 121.4, 49.8, 12, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(30,4,'12. Pelabuhan Muat',0,0,'L',0);
		$this->cell(5,4,':',0,0,'C',0);
		$this->cell(44.6,4,substr($this->pelmuat_nama,0,22),0,0,'L',0);
		$this->cell(20,4,$this->pelmuat,1,0,'C',0);
		$this->cell(49.8,4,'24. Freight :',0,0,'L',0);
		$this->cell(49.8,4,'26. Nilai CIF :',0,0,'L',0);
		$this->Ln();
		$this->SetX(5.4);

		$this->cell(30,4,'13. Pelabuhan Transit',0,0,'L',0);
		$this->cell(5,4,':',0,0,'C',0);
		$this->cell(44.6,4,substr($this->peltransit_nama,0,22),0,0,'L',0);
		$this->cell(20,4,$this->peltransit,1,0,'C',0);
		$freight = number_format($this->freight, 2, '.', ',');
		$this->cell(49.8,4,$freight,0,0,'R',0);
		$cif = number_format($this->cif, 2, '.', ',');
		$this->cell(49.8,4,$cif,0,0,'R',0);

		$this->Ln();
		$this->SetX(5.4);
		$this->cell(30,4,'14. Pelabuhan Bongkar',0,0,'L',0);
		$this->cell(5,4,':',0,0,'C',0);
		$this->cell(44.6,4,substr($this->pelbkr_nama,0,22),0,0,'L',0);
		$this->cell(20,4,$this->pelbkr,1,0,'C',0);
		if ($this->asuransi > 0) {
			$this->cell(29.8,4,'25. Asuransi LN/DN :',0,0,'L',0);
			$this->setx(127);
			$this->cell(2,4,'==',0,0,'L',0);
		} else {
			$this->cell(29.8,4,'25. Asuransi LN/DN :',0,0,'L',0);
			$this->setx(122);
			$this->cell(13,4,'==',0,0,'L',0);
		}
		$asuransi = number_format($this->asuransi, 2, '.', ',');
		$this->cell(20,4,$asuransi,0,0,'R',0);
		$this->cell(29.8,4,'Rp.',0,0,'L',0);
		$cifrp = floor($this->cif * $this->ndpbm); 
		$this->cell(20,4,number_format($cifrp,2,'.',','),0,0,'R',0);

		//Merk n No Peti Kemas
		$this->Rect(5.4, 133.4, 169.4, 24, 3.5, 'F');
		$this->Rect(174.8, 133.4, 29.8, 24, 3.5, 'F');
		$this->Ln();
		$this->SetX(5.4);
		$this->cell(99.6,4,'27. Merek dan nomor kemasan/peti kemas :',0,0,'L',0);
		$this->cell(49.8,4,'28. Jumlah dan Jenis kemasan :',0,0,'L',0);
		$this->cell(20,4,'',1,0,'C',0);
		$this->cell(29.8,4,'29. Berat Kotor (kg) :',0,0,'L',0);
		$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		for ($i=1;$i<=10;$i++){
			if($this->conttipe[$i]){
			$conttipe_nama[$i] = $this->conttipe[$i]."CL";
			}
		}		
		for ($i=1;$i<=10;$i++){
			if($this->contukur[$i]){
			$contukur_nama[$i] = $this->contukur[$i]." Feet";
			}
		}		
		$this->cell(49.8,4,$this->setnocont($this->contno[1]).' '.$contukur_nama[1].' '.$conttipe_nama[1],0,0,'L',0); // Apa ini, array??
		$this->cell(49.8,4,$this->setnocont($this->contno[6]).' '.$contukur_nama[6].' '.$conttipe_nama[6],0,0,'L',0); // Apa ini, array??
		//$this->cell(69.8,4,$this->jmkemas[1].' '.$this->jnkemas[1].'/'.$this->jnkemas_nama[1].' Merk: '.$this->merkkemas[1],0,0,'L',0);
		$bruto = number_format($this->bruto, 4, '.', ',');
		$this->cell(99.5,4,$bruto,0,0,'R',0);
		$this->Ln();
		
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		
		$this->cell(49.8,4,$this->setnocont($this->contno[2]).' '.$contukur_nama[2].' '.$conttipe_nama[2],0,0,'L',0); // Apa ini, array??
		$this->cell(49.8,4,$this->setnocont($this->contno[7]).' '.$contukur_nama[7].' '.$conttipe_nama[7],0,0,'L',0); // Apa ini, array??
		$this->cell(69.8,4,'',0,0,'L',0);
		$this->cell(29.8,4,'30. Berat Bersih (kg) :',0,0,'R',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(49.8,4,$this->setnocont($this->contno[3]).' '.$contukur_nama[3].' '.$conttipe_nama[3],0,0,'L',0); // Apa ini, array??
		$this->cell(49.8,4,$this->setnocont($this->contno[8]).' '.$contukur_nama[8].' '.$conttipe_nama[8],0,0,'L',0); // Apa ini, array??
		$this->cell(69.8,4,'',0,0,'L',0);
		$netto = number_format($this->netto, 4, '.', ',');
		$this->cell(29.8,4,$netto,0,0,'R',0);
		$this->Ln();
		
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			
		$this->cell(49.8,4,$this->setnocont($this->contno[4]).' '.$contukur_nama[4].' '.$conttipe_nama[4],0,0,'L',0); // Apa ini, array??
		$this->cell(49.8,4,$this->setnocont($this->contno[9]).' '.$contukur_nama[9].' '.$conttipe_nama[9],0,0,'L',0); // Apa ini, array??
		$this->cell(69.8,4,'',0,0,'L',0);
		$this->cell(29.8,4,'',0,0,'R',0);

		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(49.8,4,$this->setnocont($this->contno[5]).' '.$contukur_nama[5].' '.$conttipe_nama[5],0,0,'L',0); // Apa ini, array??
		$this->cell(49.8,4,$this->setnocont($this->contno[10]).' '.$contukur_nama[10].' '.$conttipe_nama[10],0,0,'L',0); // Apa ini, array??
		$this->cell(69.8,4,'',0,0,'L',0);
		$this->cell(29.8,4,'',0,0,'R',0);

		//merk
		//$this->cell(69.8,4,$this->jmkemas[1].' '.$this->jnkemas[1].'/'.$this->jnkemas_nama[1].' Merk: '.$this->merkkemas[1],0,0,'L',0);
		
		$this->setxy(105,137.5);
		$this->cell(49.8,4,$this->jmkemas[1].' '.$this->jnkemas[1].'/'.$this->jnkemas_nama[1],0,0,'L',0);
		$this->setxy(105,141.5);
		$this->cell(69.8,4,'Merk: '.$this->merkkemas[1],0,0,'L',0);
		
		//Pos Tarif
		$this->setxy(105,153.5);
		$this->Rect(5.4, 157.4, 10, 12, 3.5, 'F');
		$this->Rect(15.4, 157.4, 75, 12, 3.5, 'F');
		$this->Rect(90.4, 157.4, 25, 12, 3.5, 'F');
		$this->Rect(115.4, 157.4, 30, 12, 3.5, 'F');
		$this->Rect(145.4, 157.4, 29.4, 12, 3.5, 'F');
		$this->Rect(174.8, 157.4, 29.8, 12, 3.5, 'F');
		$this->Rect(5.4, 169.4, 10, 32, 3.5, 'F');
		$this->Rect(15.4, 169.4, 75, 32, 3.5, 'F');
		$this->Rect(90.4, 169.4, 25, 32, 3.5, 'F');
		$this->Rect(115.4, 169.4, 30, 32, 3.5, 'F');
		$this->Rect(145.4, 169.4, 29.4, 32, 3.5, 'F');
		$this->Rect(174.8, 169.4, 29.8, 32, 3.5, 'F');
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(10,4,'31.',0,0,'L',0);
		$this->cell(75,4,'32. - Pos tarif /HS',0,0,'L',0);
		$this->cell(25,4,'33. Negara',0,0,'L',0);
		$this->cell(30,4,'34. Tarif & Fasilitas',0,0,'L',0);
		$this->cell(29.4,4,'35. Jumlah &',0,0,'L',0);
		$this->cell(29.8,4,'36. Jumlah Nilai CIF',0,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(10,4,'No.',0,0,'L',0);
		$this->cell(75,4,' - Uraian jenis dan jumlah barang secara lengkap,',0,0,'L',0);
		$this->cell(25,4,' Asal',0,0,'L',0);
		$this->cell(30,4,' - BM -PPN - PPnBM',0,0,'L',0);
		$this->cell(29.4,4,' Jenis Satuan',0,0,'L',0);
		$this->cell(29.8,4,'',0,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(10,4,'',0,0,'L',0);
		$this->cell(75,4,' merk, type, ukuran, spesifikasi lain',0,0,'L',0);
		$this->cell(25,4,'',0,0,'L',0);
		$this->cell(30,4,' - Cukai       - PPh',0,0,'L',0);
		$this->cell(29.4,4,' Berat Bersih (kg)',0,0,'L',0);
		$this->cell(29.8,4,'',0,0,'L',0);
		$this->SetFont('times','','7');
		//Isi Detail
		if($this->jmbrg <= 1){
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$this->cell(10,4,'1',0,0,'L',0);
			$this->cell(75,4,$this->formaths($this->nohs),0,0,'L',0);
			$this->cell(25,4,$this->brgasal.'/'.$this->brgasal_nama,0,0,'L',0);
			
			if ($this->fasbm != 0){
				$BMNYA = $this->fasbm / 100;
				$strfasbm = $this->getfas($this->kdfasbm).' : '.$BMNYA.' %';		
			}	
			
			$this->cell(30,4,'BM:'.$this->strip($this->trpbm).' '.$strfasbm,0,0,'L',0);
			
			$this->cell(29.4,4,number_format($this->jmlsat,4,'.',','),0,0,'L',0);
			$dnilinv = number_format($this->cif , 4, '.', ',');
			$this->cell(29.8,4,$dnilinv,0,0,'R',0);
			$urai = $this->trimstr($this->brgurai,50);
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$this->cell(10,4,'',0,0,'L',0);
			$kordinatx = $this->getx();
			$kordinaty = $this->gety();
			$this->MultiCell(75,4,substr($this->brgurai,0,95),0,'L');
			$kordinatyy = $this->gety();
			$this->setxy($kordinatx+75,$kordinaty);
			//$this->MultiCell(75,4,$this->brgurai);
			//$this->SetY(150);
			$this->cell(25,4,'',0,0,'L',0);
			
			if ($this->fascuk != 0){
				$CUKNYA = $this->fascuk / 100;
				$strfascuk = $this->getfas($this->kdfascuk).' : '.$CUKNYA.' %';		
			}
			$kordinatx = $this->getx();
			$this->cell(30,4,'Cukai:'.$this->strip($this->trpcuk).' '.$strfascuk,0,0,'L',0);
			$satuan = $this->trimstr($this->kdsat.'/'.$this->kdsat_nama, 20);
			$this->cell(29.4,4,$satuan['str1'],0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->setx($kordinatx);
			if ($this->fasppn != 0){
				$BBSNYA = $this->fasppn / 100;
				$strfasppn = $this->getfas($this->kdfasppn).' : '.$BBSNYA.' %';		
			}
			$this->cell(30,4,'PPN:'.$this->strip($this->trpppn).' '.$strfasppn,0,0,'L',0);
			$this->cell(29.4,4,$satuan['str2'],0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->setx($kordinatx);
			if ($this->faspbm != 0){
				$PBMNYA = $this->faspbm / 100;
				$strfaspbm = $this->getfas($this->kdfaspbm).' : '.$PBMNYA.' %';		
			}
			
			$this->cell(30,4,'PPnBM:'.$this->strip($this->trppbm).' '.$strfaspbm,0,0,'L',0);
			$this->cell(29.4,4,'BB: '.number_format($this->nettodtl,4,'.',',').' Kg',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->setx($kordinatx);
			
			if ($this->apino != ' '){
				$trppph = '2.5';
			}else{
				$trppph = '7.5';
			}
			
			if ($this->faspph != 0){
				$PPHNYA = $this->faspph / 100;
				$strfaspph = $this->getfas($this->kdfaspph).' : '.$PPHNYA.' %';		
			}
			
			$this->cell(30,4,'PPh:'.$this->strip($trppph).' '.$strfaspph,0,0,'L',0);
			/* $this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,$this->merk.'-'.$this->tipe.'-'.$this->spflain,0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0); */
			$jn = number_format($this->kemasjm,4,'.',',');
			$this->Ln();
			$this->sety($kordinatyy);			
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,$jn.' '.$this->kemasjn.' / '.$this->kemasjn_nama,0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			
			$this->Ln();
			/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'Fas: '.$this->kdfasdtl.'/'.$this->kdfasdtl_nama,0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->kdfasdtl_nama = "";
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
		}else{
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(140,4,'=='.$this->jmbrg.'Jenis barang. Lihat Lembar Lanjutan==',0,0,'R',0);
			$this->cell(29.4,4,'',0,0,'L',0);
//			$this->cell(29.8,4,'',0,0,'L',0);
			$this->cell(29.4,4,number_format($this->cif, 4, '.', ','),0,0,'R',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
			$this->cell(25,4,'',0,0,'L',0);
			$this->cell(30,4,'',0,0,'L',0);
			$this->cell(29.4,4,'',0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
		}
		//Pungutan
		
//		$kordinatx = $this->getx();
//		$kordinaty = $this->gety();
//		$this->setxy(5,5);
//		$this->cell(29.8,4,"$kordinaty",0,0,'L',0);
		$this->sety(197.41513888889);
		$this->Rect(5.4, 201.4, 39.2, 4, 3.5, 'F');
		$this->Rect(44.6, 201.4, 40, 4, 3.5, 'F');
		$this->Rect(84.6, 201.4, 40, 4, 3.5, 'F');
		$this->Rect(124.6, 201.4, 40.2, 4, 3.5, 'F');
		$this->Rect(164.8, 201.4, 39.85, 4, 3.5, 'F');

		$this->SetFont('times','','9');
		$this->Ln();
		$this->cell(39.2,4,'Jenis Pungutan',0,0,'C',0);
		$this->cell(40,4,'Dibayar (Rp)',0,0,'C',0);
		$this->cell(40,4,'Ditanggung Pemerintah (Rp)',0,0,'C',0);
		$this->cell(40,4,'Ditangguhkan (Rp.)',0,0,'C',0);
		$this->cell(40,4,'Dibebaskan (Rp.)',0,0,'C',0);
		$this->Ln();
		$this->setx(5.4);
		$this->cell(5,4,'37.',1,0,'L',0);
		$this->cell(34.2,4,'BM',1,0,'L',0);
		$JmlBM = floor($this->nPungutan[1][0] + $this->nPungutan[1][3]); 
		//echo $JmlBM; exit;
		$this->cell(40,4,number_format(floor($this->nPungutan[1][0] + $this->nPungutan[1][3]),0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[1][1],0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[1][2],0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[1][4],0,'.',','),1,0,'R',0);
		$this->Ln();
		$this->setx(5.4);
		$this->cell(5,4,'38.',1,0,'L',0);
		$this->cell(34.2,4,'Cukai',1,0,'L',0);
		$JmlCukai = floor($this->nPungutan[5][0] + $this->nPungutan[5][3]);
		$this->cell(40,4,number_format(floor($this->nPungutan[5][0] + $this->nPungutan[5][3]),0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[5][1],0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[5][2],0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[5][4],0,'.',','),1,0,'R',0);
		$this->Ln();
		$this->setx(5.4);
		$this->cell(5,4,'39.',1,0,'L',0);
		$this->cell(34.2,4,'PPN',1,0,'L',0);
		$JmlPPN = floor($this->nPungutan[2][0] + $this->nPungutan[2][3]);
		$this->cell(40,4,number_format(floor($this->nPungutan[2][0] + $this->nPungutan[2][3]),0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[2][1],0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[2][2],0,'.',','),1,0,'R',0);
		$this->cell(40,4,number_format($this->nPungutan[2][4],0,'.',','),1,0,'R',0);
		$this->Ln();
		$this->setx(5.4);
		$this->cell(5,5,'40.',1,0,'L',0);
		$this->cell(34.2,5,'PPnBM',1,0,'L',0);
		$JmlPPnBM = floor($this->nPungutan[3][0] + $this->nPungutan[3][3]);
		$this->cell(40,5,number_format(floor($this->nPungutan[3][0] + $this->nPungutan[3][3]),0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($this->nPungutan[3][1],0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($this->nPungutan[3][2],0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($this->nPungutan[3][4],0,'.',','),1,0,'R',0);
		$this->Ln();
		$this->setx(5.4);
		$this->cell(5,5,'41.',1,0,'L',0);
		$this->cell(34.2,5,'PPh',1,0,'L',0);
		$JmlPPh = floor($this->nPungutan[4][0] + $this->nPungutan[4][3]);
		$this->cell(40,5,number_format(floor($this->nPungutan[4][0] + $this->nPungutan[4][3]),0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($this->nPungutan[4][1],0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($this->nPungutan[4][2],0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($this->nPungutan[4][4],0,'.',','),1,0,'R',0);
		$nDibayar = $this->nPungutan[1][0] + $this->nPungutan[1][3] + $this->nPungutan[2][0] + $this->nPungutan[2][3] + $this->nPungutan[3][0] + $this->nPungutan[3][3] + $this->nPungutan[4][0] + $this->nPungutan[4][3] + $this->nPungutan[5][0] + $this->nPungutan[5][3];
		$nDTP = $this->nPungutan[1][1] + $this->nPungutan[2][1] + $this->nPungutan[3][1] + $this->nPungutan[4][1] + $this->nPungutan[5][1];
		$nDTG = $this->nPungutan[1][2] + $this->nPungutan[2][2] + $this->nPungutan[3][2] + $this->nPungutan[4][2] + $this->nPungutan[5][2];
		$nDibebaskan = $this->nPungutan[1][4] + $this->nPungutan[2][4] + $this->nPungutan[3][4] + $this->nPungutan[4][4] + $this->nPungutan[5][4];
		$this->Ln();
		$this->setx(5.4);
		$this->cell(5,5,'42.',1,0,'L',0);
		$this->cell(34.2,5,'TOTAL',1,0,'L',0);
		$this->cell(40,5,number_format($nDibayar,0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($nDTP,0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($nDTG,0,'.',','),1,0,'R',0);
		$this->cell(40,5,number_format($nDibebaskan,0,'.',','),1,0,'R',0);

		// Section E - H
		$this->Rect(5.4, 232.4, 99.6, 58, 3.5, 'F');
		//$this->Rect(5.4, 267.4, 99.6, 23, 3.5, 'F');
		$this->Rect(105, 232.4, 99.6, 58, 3.5, 'F');
		$this->Ln();
		
		//return false;
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(99.6,5,'E. Dengan ini saya menyatakan bertanggungjawab atas kebenaran hal-hal',0,0,'L',0);
		$this->cell(99.6,5,'G. UNTUK PEMBAYARAN/JAMINAN',0,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(99.6,5,'yang diberitahukan dalam dokumen ini',0,0,'L',0);
		$this->cell(9.6,5,'',0,0,'L',0);
		$this->cell(20,5,'a. Pembayaran',0,0,'L',0);
		$this->cell(5,4,'',1,0,'C',0);
		$this->cell(65,5,' 1. Bank 2. Pos 3. Kantor Pabean',0,0,'L',0);
		$this->Ln();
		/*editan rizky awal*/
			$this->setX(5.6);
			/*editan rizky akhir*/
		$this->cell(24.6,5,'',0,0,'L',0);
//		$this->cell(75,5,$this->kota.', '.$this->tanggal_ttd,0,0,'C',0);
		$this->cell(75,5,'',0,0,'C',0);
		$this->cell(9.6,5,'',0,0,'L',0);
		$this->cell(20,5,'b. Jaminan',0,0,'L',0);
		$this->cell(5,4,'',1,0,'C',0);
		$this->cell(65,5,' 1. Tunai 2. Bank Garansi 3. Customs Bond',0,0,'L',0);
		$this->Ln();
		$this->cell(24.6,5,'',0,0,'L',0);

		/** try to get edinum **/
		if ($this->kdprsh=="P"){
			$ppjk="PPJK";
		}elseif ($this->kdprsh=="I"){
			$ppjk="IMPORTIR";
		}

		$this->cell(75,5,$ppjk,0,0,'C',0);
		$this->cell(5,5,'',0,0,'L',0);
		$this->cell(20,5,'',0,0,'L',0);
		$this->cell(5,4,'',0,0,'C',0);
		$this->cell(65,5,' 4. Lainnya',0,0,'L',0);
		
		
		$this->Ln();
		$this->setx(5);
		$this->cell(99.6,5,'',0,0,'C',0);
		$this->cell(9.6,5,'',0,0,'L',0);
		$this->cell(20,5,'',1,0,'C',0);
		$this->cell(50,5,'Nomor',1,0,'C',0);
		$this->cell(20.4,5,'Tanggal',1,0,'C',0);
		$this->Ln();
		$this->setx(5);
		$this->cell(99.6,5,'',0,0,'C',0);
		$this->cell(9.6,5,'',0,0,'L',0);
		$this->cell(20,5,'Pembayaran',1,0,'L',0);
		$this->cell(50,5,'',1,0,'C',0);
		$this->cell(20.4,5,'',1,0,'C',0);
		$this->Ln();
		$this->setx(5);
		$this->cell(99.6,5,'',0,0,'C',0);
		$this->cell(9.6,5,'',0,0,'L',0);
		$this->cell(20,5,'Jaminan',1,0,'L',0);
		$this->cell(50,5,'',1,0,'C',0);
		$this->cell(20.4,5,'',1,0,'C',0);	
		
		$this->Ln();
		/*editan rizky awal*/
		$this->setX(5.6);
		/*editan rizky akhir*/
		$this->cell(99.6,4,'',0,0,'C',0);
		$this->cell(49.8,4,'Pejabat Penerima',0,0,'C',0);
		$this->cell(49.8,4,'Nama/Stempel Instansi',0,0,'C',0);
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->setX(5.6);
		$this->cell(99.6,4,'Tgl. Cetak '.date("d-m-Y"),0,0,'L',0);
		/*$this->cell(49.8,4,$this->petugasbankPIB."asdasdasdasdadsasd",0,0,'C',0);
		$this->cell(49.8,4,'asdsadasdasd',0,0,'C',0);*/
		$this->cell(49.8,4,'(.........................................................)',0,0,'C',0);
		$this->cell(49.8,4,'(.........................................................)',0,0,'C',0);
		
		
		/*$this->Ln();
		$this->setX(5.6);
		$this->cell(99.6,4,'',0,0,'L',0);
		$this->cell(49.8,4,'(.........................................................)',0,0,'C',0);
		$this->cell(49.8,4,'(.........................................................)',0,0,'C',0);*/
		
		//return false;
		// Footer
		$this->Ln();
		$this->Ln();
		/*editan rizky awal*/
		$this->setX(5.6);
		/*editan rizky akhir*/
		$this->cell(99.8,4,'PERDIRJEN BC No. P-22/BC/2009 Tanggal 8 Mei 2009',0,0,'L',0);
		$this->cell(75,4,'Rangkap ke-1 / 2 / 3 untuk Kantor Pabean / BPS / BI',0,0,'L',0);
		$this->cell(24.6,4,'Ver. 5.0.3',0,0,'R',0);
	
		$this->setXY(5.5,245);
		$this->cell(99.5,4,$this->kota.', '.$this->tglsspcp,0,0,'C',0);	
		$this->Ln();
		$this->setX(5.5);
		$this->cell(99.5,4,'PPJK',0,0,'C',0);		
		$this->Ln();	
		$this->Ln();	
		$this->Ln();	
		$this->Ln();
		$this->setX(5.5);
		$this->cell(99.5,4,'(.........................................................)',0,0,'C',0);	
			
		
	}
	
	
	function fillForm($arrayDetail)
	{
		$this->SetVisibility('all');	
		$this->SetFont('Arial','',7);
		$this->SetXY(11,133);
		//$this->SetWidths(array(8,4,20,4,62,4,33,4,18,4,20));
		$this->SetWidths(array(11.5,1.5,23,0,78,0,23,1.5,23.5,0,23.5));
		$this->SetAligns(array('C','L','L','L','L','L','C','L','L','L','L'));
		$banyakData = count($arrayDetail);
		for ($a=0;$a<$banyakData;$a++)
		{	
			$this->SetX(11);
			$desc1 = "";
			$desc2 = "";
			$bruto = "";
			$invoices = "";
			if ($arrayDetail[$a]['mark'] != "")
				$desc1 .= $arrayDetail[$a]['mark'].chr(10);
			if ($arrayDetail[$a]['packNumber'] != "")
				$desc1 .= $arrayDetail[$a]['packNumber'];

			if ($arrayDetail[$a]['packQty'] != "")
				$desc2 .= $arrayDetail[$a]['packQty']." ".$arrayDetail[$a]['packType_id'].chr(10);
			if ($arrayDetail[$a]['goodsDesc'] != "")
				$desc2 .= $arrayDetail[$a]['goodsDesc'].chr(10);
			if ($arrayDetail[$a]['goodsQty'] != "")
				$desc2 .= $arrayDetail[$a]['goodsQty']." ".$arrayDetail[$a]['qtyUnit'].chr(10);
			if ($arrayDetail[$a]['hsNumber'] != "")
				$desc2 .= "HS: ".$this->model_sesi->format_hs($arrayDetail[$a]['hsNumber']);
			
			if ($arrayDetail[$a]['grossWeight'] != "")
				$bruto .= $arrayDetail[$a]['grossWeight']." ".$arrayDetail[$a]['weightUnit'].chr(10);
			/*if ($arrayDetail[$a]['fobCurrency'] != "")
				$bruto .= $arrayDetail[$a]['fobCurrency']." ".$arrayDetail[$a]['fobValue'];*/
			
			$fob = "";
			if ($arrayDetail[$a]['fobPrinted'] == "1")
			{
				$fob .= "USD ".$arrayDetail[$a]['fobUsd'];
			}
			else if ($arrayDetail[$a]['fobPrinted'] == "2")
			{
				$fob .= $arrayDetail[$a]['fobCurrency']." ".$arrayDetail[$a]['fobValue'];
			}
			
			/*if ($arrayDetail[$a]['invoiceNumber'] != "")
				$invoices .= $arrayDetail[$a]['invoiceNumber'].chr(10);
			if (($arrayDetail[$a]['invoiceDate'] != "") or ($arrayDetail[$a]['invoiceDate'] != "0000-00-00"))
				$invoices .= $this->model_sesi->format_date($arrayDetail[$a]['invoiceDate']);*/

			$halaman = $this->pageNo();
			if ($a == 0)
			{
				$this->Row(array(($a+1),'',$desc1,'',$desc2,'',$arrayDetail[$a]['originCriterion'],'',$bruto.$fob,'',strtoupper($this->row[0]['invoiceNumber'])."\n".strtoupper($this->row[0]['invoiceDate'])),3,false,$halaman,$a,$banyakData,1,0);
			}
			else
			{
				$this->Row(array(($a+1),'',$desc1,'',$desc2,'',$arrayDetail[$a]['originCriterion'],'',$bruto.$fob,'',''),3,false,$halaman,$a,$banyakData,1,0);
			}

			/*$this->Row(array(($a+1),'',strtoupper($desc1),'',strtoupper($desc2),'',strtoupper($arrayDetail[$a]['originCriterion']),'',strtoupper($bruto).strtoupper($fob),'',strtoupper($this->row[0]['invoiceNumber'])."\n".strtoupper($this->row[0]['invoiceDate'])),3,false,$halaman,$a,$banyakData,1,0);*/
			
			$this->ln(3);
		}
	}
	
}

	$pdf = new printForm('P','mm',array(207,298));
	$pdf->db = $this->db;
	$pdf->row = $arrayHeader;
	$pdf->model_sesi = $this->model_sesi;
	$pdf->session = $this->session;
	//$pdf->countryLogin = $countryLogin;
	//$pdf->rowcase = $rowcase;
	//$pdf->publicFunction = $this->public_function;
	
	$pdf->Open();
	$pdf->SetDisplayMode('real');
	$pdf->SetTitle('Form A');
	$pdf->SetAuthor('PT EDI Indonesia');
	$pdf->SetSubject('Formulir A');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->fillForm($arrayDetail);
	$pdf->Output();
?>