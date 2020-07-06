<?php

$this->load->library('fpdf');
$this->load->library('fungsi');
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
		//HEADER//	
		$this->SetX(5.4);
		$this->Rect(5.4, 4, 3.6, 36, 3.5, 'F');
		$this->Rect(9, 4, 20, 5, 3.5, 'F');
		$this->Rect(9, 4, 194.4, 5, 3.5, 'F');
		$this->Rect(9, 9, 194.4, 31, 3.5, 'F');
		$this->Rect(118.4, 17, 85, 23, 3.5, 'F');
		$this->SetFont('times','B','8');
		$this->cell(19,2,'BC 3.0',0,0,'R',0);
		$this->SetFont('times','B','10');
		$this->cell(123,2,"PEMBERITAHUAN EKSPOR BARANG",0,0,'R',0);
		$this->SetFont('times','B','8');
		$this->writeRotie(8,30,"HEADER",90,0);
//		
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(190,7," Halaman 1 dari $nb",0,0,'R',0);//
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','B','8');
		$this->cell(5,2,'A.KANTOR PABEAN',0,0,'L',0);
		$this->Ln();
		$this->SetX(12);
		$this->SetFont('times','','8');
		$this->cell(33,4,'1.Kantor Pabean Pemuatan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['KODE_KPBC'].'   '.str_replace("KANTOR PELAYANAN BEA CUKAI ","KPU ",$this->row['URAIAN_KPBC']),0,0,'L',0);
		$this->Ln();
		$this->SetX(12);
		$this->cell(33,4,'2.Nomor Pengajuan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['NOMOR_AJU'],0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','B','8');
		$this->cell(36,3,'B.JENIS EKSPOR',0,0,'L',0);
		$this->SetFont('times','','8');
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['URJENIS_EKSPOR'],0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','B','8');
		$this->cell(36,3,'C.KATEGORI EKSPOR',0,0,'L',0);
		$this->SetFont('times','','8');
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['URKATEGORI_EKSPOR'],0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','B','8');
		$this->cell(36,3,'D.CARA PERDAGANGAN',0,0,'L',0);
		$this->SetFont('times','','8');
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['URCARA_DAGANG'],0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','B','8');
		$this->cell(36,3,'E.CARA PEMBAYARAN',0,0,'L',0);
		$this->SetFont('times','','8');
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['URCARA_BAYAR'],0,0,'L',0);
		$this->Ln();
		
		$this->SetXY(119,17);
		$this->SetFont('times','B','8');
		$this->cell(36,3,'H.KOLOM KHUSUS BEA DAN CUKAI',0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->SetFont('times','','8');
		$this->cell(27,3,'1.Nomor Pendaftaran',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['NOMOR_PENDAFTARAN'],0,0,'L',0);
		$this->Ln();
		$this->SetX(121);
		$this->SetFont('times','','8');
		$this->cell(25,3,'Tanggal',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,($this->row['TANGGAL_PENDAFTARAN']=='0000-00-00')?'':$this->row['TANGGAL_PENDAFTARAN'],0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->SetFont('times','','8');
		$this->cell(27,3,'2.Nomor BC 1.1',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->row['NOMOR_BC11'],0,0,'L',0);
		$this->Ln();
		$this->SetX(121);
		$this->SetFont('times','','8');
		$this->cell(25,3,'Tanggal',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,($this->row['TANGGAL_BC11']=='0000'),0,0,'L',0);
		$this->Ln();
		$this->SetX(121);
		$this->SetFont('times','','8');
		$this->cell(25,3,'Pos Sub Pos',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,'',0,0,'L',0);
		$this->Ln();
		
		//===DATA PEMBERITAHUAN==\\
		
		//EKSPORTIR
		$this->SetFont('times','B','8');
		$this->writeRotie(8,160,"F.DATA PEMBERITAHUAN",90,0);
		$this->Rect(5.4, 40, 198, 246, 3.5, 'F');
		$this->Rect(9, 40, 194.4, 5, 3.5, 'F');
		$this->Rect(9, 45, 194.4, 31, 3.5, 'F');
		$this->Rect(118.4, 40, 85, 20, 3.5, 'F');
		$this->Rect(118.4, 56, 85, 20, 3.5, 'F');
		
		$this->SetX(12);
		$this->SetFont('times','B','8');
		$this->cell(40,5,'EKSPORTIR',0,0,'L',0);
		$this->cell(86,5,'PENERIMA',0,0,'R',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(20,3,'1.Identitas',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$imppj = strlen(trim($this->expnpwp));
		if($imppj==15){
			$formatimpNPWP= substr($this->expnpwp,0,2) .".". substr($this->expnpwp,2,3) .".". substr($this->expnpwp,5,3) .".". substr($this->expnpwp,8,1) ."-". substr($this->expnpwp,9,3) .".". substr($this->expnpwp,12,3);
		} else {
			$formatimpNPWP= substr($this->expnpwp,0,2) .".". substr($this->expnpwp,2,3) .".". substr($this->expnpwp,5,3) .".". substr($this->expnpwp,8,1) ."-". substr($this->expnpwp,9,3);
		}		
		$this->cell(5,4,$this->urnpwp.' Digit      '.$formatimpNPWP,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(20,3,'2.Nama',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->expnama,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(20,3,'3.Alamat',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$almt = $this->trimstr($this->expalmt,75);
		$this->cell(5,4,$almt['str1'],0,0,'L',0);
		$this->Ln();
		$this->SetX(31);
		$this->cell(1,4,$almt['str2'],0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(20,3,'4.NIPER',0,0,'L',0);
		$this->SetFont('times','','8');
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->EXPNIPER,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(20,3,'5.Status',0,0,'L',0);
		$this->SetFont('times','','8');
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->expstatur,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(20,3,'No & Tgl.TDP',0,0,'L',0);
		$this->SetFont('times','','8');
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->EXPNOTDP,0,0,'L',0);
		$this->Ln();
		$this->SetX(31);
		$this->cell(20,3,$this->EXPTGTDP,0,0,'L',0);
		$this->Ln();
		
		$this->SetXY(119,45);
		$this->cell(27,3,'7.Nama',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->nmbeli,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(27,3,'8.Alamat',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$almt = $this->trimstr( $this->almbeli,32);
		$this->cell(5,4,$almt['str1'],0,0,'L',0);
		$this->Ln();
		$this->SetX(148);
		$this->cell(1,3,$almt['str2'],0,0,'L',0);
		$this->Ln();
		$this->SetX(121);
		$this->SetFont('times','B','8');
		$this->cell(36,4,'PPJK',0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->SetFont('times','','8');
		$eksppjk = strlen(trim($this->ppjknpwp));
			if($eksppjk==15){
				$formateksNPWP= substr($this->ppjknpwp,0,2) .".". substr($this->ppjknpwp,2,3) .".". substr($this->ppjknpwp,5,3) .".". substr($this->ppjknpwp,8,1) ."-". substr($this->ppjknpwp,9,3) .".". substr($this->ppjknpwp,12,3);
			} else {
				$formateksNPWP= substr($this->ppjknpwp,0,2) .".". substr($this->ppjknpwp,2,3) .".". substr($this->ppjknpwp,5,3) .".". substr($this->ppjknpwp,8,1) ."-". substr($this->ppjknpwp,9,3);
			}
		$this->cell(27,3,'9.NPWP',0,0,'L',0);
		$this->cell(2,3,':',0,0,'C',0);
		$this->cell(5,3,$formateksNPWP,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(27,3,'10.Nama',0,0,'L',0);
		$this->cell(2,3,':',0,0,'C',0);
		$this->cell(5,3,$this->ppjknama,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(27,3,'11.Alamat',0,0,'L',0);
		$this->cell(2,3,':',0,0,'C',0);
		$almt = $this->trimstr($this->ppjkalmt,50);
		$this->cell(5,3,$almt['str1'],0,0,'L',0);
		$this->Ln();
		$this->SetX(148);
		$this->cell(1,2,$almt['str2'],0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(27,6,'12.Nomor Pokok PPJK',0,0,'L',0);
		$this->cell(2,6,':',0,0,'C',0);
		$this->cell(5,6,$this->ppjkno,0,0,'L',0);
		$this->SetX(180);
		$this->cell(6,6,'Tgl',0,0,'L',0);
		$this->cell(2,6,':',0,0,'C',0);
		$this->cell(5,6,$this->ppjktg,0,0,'L',0);
		$this->Ln();
		
		
		//DATA PENGANGKUTAN
		$this->Rect(9, 76, 194.4, 5, 3.5, 'F');
		$this->Rect(9, 76, 194.4, 25, 3.5, 'F');
		$this->Rect(118.4, 76, 85, 25, 3.5, 'F');
		
		$this->SetX(12);
		$this->SetFont('times','B','8');
		$this->cell(40,4,'DATA PENGANGKUTAN',0,0,'L',0);
		$this->cell(96,4,'DATA PELABUHAN',0,0,'R',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(42,4,'13.Cara Pengangkutan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->modaur,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(42,4,'14.Nama Sarana Pengangkut',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->CARRIER,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(42,4,'15.Nomor Pengangkut (Voy/Flight)',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->VOY,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(42,4,'16.Bendera Sarana Pengangkut',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->BENDERA.'  '.$this->BENDERAur,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(109.4,4,'17.Tanggal Perkiraan Ekspor :    '.$this->tgeks,1,0,'L',0);
		$this->Ln();
		$this->SetXY(119,81);
		$this->cell(32,4,'18.Pelabuhan Muat Asal',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->PELMUAT.'   '.$this->PELMUATur,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(32,4,'19.Pelabuhan Muat Ekspor',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->PELMUAT.'   '.$this->PELMUATur,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(32,4,'20.Pelabuhan Transit LN',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->PELTRANSIT.'   '.$this->PELTRANSITur,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(32,4,'21.Pelabuhan Bongkar',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->PELBONGKAR.'   '.$this->PELBONGKARur,0,0,'L',0);
		$this->Ln();
		
		//DOKUMEN PELENGKAP PABEAN
		$this->Ln();
		$this->Rect(9, 101, 194.4, 5, 3.5, 'F');
		$this->Rect(9, 101, 194.4, 22, 3.5, 'F');
		$this->Rect(118.4, 101, 85, 22, 3.5, 'F');
		
		$this->SetX(12);
		$this->SetFont('times','B','8');
		$this->cell(40,5,'DOKUMEN PELENGKAP PABEAN',0,0,'L',0);
		$this->cell(112,5,'DATA TEMPAT PEMERIKSAAN',0,0,'R',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(42,4,'22.Nomor & Tgl Invoice',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(64,4,$this->invno[1],0,0,'R',0);
		$this->Ln();
		$this->cell(72,4,$this->invtgl[1],0,0,'R',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(42,4,'23.Jenis/Nomor/Tgl Dok Pelengkap Pabean  :',0,0,'L',0);
		$this->Ln();
		$this->SetX(12);
		$this->cell(40,4,$this->urdok[1],0,0,'L',0);
		$this->cell(45,4,$this->nodok[1],0,0,'L',0);
		$this->cell(20,4,$this->tgdok[1],0,0,'R',0);
		
		$this->SetXY(119,106);
		$this->cell(36,4,'24.Lokasi Pemeriksaan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->kdlokbrng.'.'.$this->KDLOKBRGur,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(36,4,'25.Kantor Pabean Pemeriksaan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->kpbcperiksa.' '.str_replace("KANTOR PELAYANAN BEA CUKAI ","KPU ",$this->kpbcperiksaur),0,0,'L',0);
		$this->Ln();
		$this->SetX(118.4);
		$this->SetFont('times','B','8');
		$this->cell(85	,3,'    Data Perdagangan',1,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->SetFont('times','','8');
		$this->cell(24,4,'26.Daerah Asal Brg',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->PROPBRG.'  '.$this->PROPBRGur,0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(42,2,'',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(109.4,4,'27.Negara Tujuan Ekspor  :  '.$this->negtuju.'    '.$this->negtujuur,1,0,'L',0);
		$this->cell(85,4,'28.Cara Penyerahan Barang  :  '.$this->serah.'     '.$this->serahur,1,0,'L',0);
		
		//DATA TRANSAKSI EKSPOR
		$this->Ln();
		$this->Rect(9, 127, 194.4, 5, 3.5, 'F');
		$this->Rect(9, 127, 194.4, 18, 3.5, 'F');
		$this->Rect(118.4, 127, 85, 18, 3.5, 'F');
		
		$this->SetX(12);
		$this->SetFont('times','B','8');
		$this->cell(40,5,'DATA TRANSAKSI EKSPOR',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(36,4,'29.Jenis Valuta Asing',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(20,4,$this->KDVAL,0,0,'L',0);
		$this->cell(50,4,$this->KDVALur,0,0,'R',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(36,4,'30.Freight',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$freight = number_format($this->freight, 2, '.', ',');
		$this->cell(70,4,$freight,0,0,'R',0);
		$this->Ln();
		$this->SetXY(119,132);
		$this->cell(28,4,'31.Asuransi (LN/DN)',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$asuransi = number_format($this->asuransi, 2, '.', ',');
		$this->cell(5,4,$asuransi,0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(28,4,'32.FOB',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$FOB = number_format($this->FOB, 2, '.', ',');
		$this->cell(5,4,$FOB,0,0,'L',0);
		$this->Ln();
		
		
		//DATA PETI KEMAS
		$this->Rect(9, 140, 194.4, 5, 3.5, 'F');
		$this->Rect(9, 140, 194.4, 21, 3.5, 'F');
		$this->Rect(118.4, 140, 85, 21, 3.5, 'F');
		
		$this->SetX(12);
		$this->SetFont('times','B','8');
		$this->cell(40,5,'DATA PETI KEMAS',0,0,'L',0);
		$this->cell(94,5,'DATA KEMASAN',0,0,'R',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(38,4,'33.Peti Kemas',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,'-',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(38,4,'34.Status Peti Kemas',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,'-',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(38,4,'35.Jumlah Peti Kemas',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->JMCONT.' '.$this->conttipeur[1],0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(38,4,'36.Merk dan Nomor Peti Kemas',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->contno[1],0,0,'L',0);
		$this->Ln();
		$this->SetXY(119,145);
		$this->cell(28,4,'37.Jenis Kemasan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->jnkemas[1].'  '.$this->jnkemas_nama[1],0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(28,4,'38.Jumlah Kemasan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,$this->jmkemas[1],0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(28,4,'39.Merk Kemasan',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$this->cell(5,4,'-',0,0,'L',0);
		$this->Ln();

		
		
		//DATA BARANG EKSPOR\\
		$this->Ln();
		$this->Rect(9, 161, 194.4, 5, 3.5, 'F');
		$this->Rect(118.4, 161, 85, 5, 3.5, 'F');
		$this->Rect(9, 166, 194.4, 5, 3.5, 'F');
		
		$this->SetX(12);
		$this->SetFont('times','B','8');
		$this->cell(40,5,'DATA BARANG EKSPOR',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(25,4,'40.Volume',0,0,'L',0);
		$VOLUME = number_format($this->VOLUME, 4, ',', '.');
		$this->cell(30,4,$VOLUME,0,0,'L',0);
		$this->cell(30,4,'41.Berat Kotor(Kg)',0,0,'L',0);
		$bruto = number_format($this->bruto, 4, '.', ',');
		$this->cell(30,4,$bruto,0,0,'L',0);
		$this->cell(30,4,'42.Berat Bersih (Kg)',0,0,'L',0);
		$netto = number_format($this->netto, 4, '.', ',');
		$this->cell(30,4,$netto,0,0,'L',0);
		//44 postarif
		$this->Ln();
		$this->Rect(9, 171, 10, 51.5, 3.5, 'F');
		$this->Rect(9, 171, 194.4, 12, 3.5, 'F');		
		$this->Rect(9, 183, 194.4, 39.5, 3.5, 'F');
		$this->Rect(83.4, 171, 35, 51.5, 3.5, 'F');
		$this->Rect(150, 171, 28, 51.5, 3.5, 'F');
		
		$this->SetXY(9,171);
		$this->cell(1,4,'43. No',0,0,'L',0);
		$this->cell(10,4,'',0,0,'L',0);
		$this->cell(1,4,'44. Pos Tarif/HS, Uraian jumlah dan jenis',0,0,'L',0);
		$this->cell(63,4,'',0,0,'L',0);
		$this->cell(1,4,'45. HE Barang dan',0,0,'L',0);
		$this->cell(35,4,'',0,0,'L',0);
		$this->cell(1,4,'46. Jumlah & Jenis Sat,',0,0,'L',0);
		$this->cell(30,4,'',0,0,'L',0);
		$this->cell(1,4,'47.-Perijinan Ekspor',0,0,'L',0);
		$this->cell(27,4,'',0,0,'L',0);
		$this->cell(1,4,'48.Jumlah Nilai',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(1,4,'',0,0,'L',0);
		$this->cell(13,4,'',0,0,'L',0);
		$this->cell(1,4,'barang secara lengkap, merk, tipe,',0,0,'L',0);
		$this->cell(63.5,4,'',0,0,'L',0);
		$this->cell(1,4,'Tarif BK pada',0,0,'L',0);
		$this->cell(35.5,4,'',0,0,'L',0);
		$this->cell(1,4,'Berat Bersih (Kg)',0,0,'L',0);
		$this->cell(29.5,4,'',0,0,'L',0);
		$this->cell(1,4,'-Negara Asal',0,0,'L',0);
		$this->cell(27,4,'',0,0,'L',0);
		$this->cell(1,4,'FOB',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(14,4,'',0,0,'L',0);
		$this->cell(1,4,'ukuran, spesifikasi lain dan kode barang',0,0,'L',0);
		$this->cell(64,4,'',0,0,'L',0);
		$this->cell(1,4,'tanggal pendaftaran',0,0,'L',0);
		$this->cell(35,4,'',0,0,'L',0);
		$this->cell(1,4,'Volume (m3)',0,0,'L',0);
		$this->cell(30,4,'',0,0,'L',0);
		$this->cell(1,4,'Barang',0,0,'L',0);
		$this->SetFont('times','','7');
		//Isi Detail
		if($this->jmbrg <=1){
			$this->Ln();
			$this->setX(10);
			$this->cell(10,4,'1',0,0,'L',0);
			$this->cell(75,4,$this->formaths($this->nohs),0,0,'L',0);
			$this->cell(15,4,'',0,0,'L',0);
			//$this->cell(40,4,$this->strip($this->peperbrg),0,0,'L',0);
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(29.4,4,number_format($this->jmlsat,4,'.',','),0,0,'L',0);
			$dnilinv = number_format($this->FOB , 4, '.', ',');
			$this->cell(54,4,$dnilinv,0,0,'R',0);
			$urai = $this->trimstr($this->brgurai,50);
			$this->Ln();
			$this->setX(10);
			$this->cell(10,4,'',0,0,'L',0);
			$kordinatx = $this->getx();
			$kordinaty = $this->gety();
			$this->MultiCell(60,4,substr($this->brgurai,0,95),0,'L');
			$kordinatyy = $this->gety();
			$this->setxy($kordinatx+75,$kordinaty);
			
			$this->cell(25,4,'',0,0,'L',0);
			$satuan = $this->trimstr($this->kdsat.'/'.$this->kdsat_nama, 20);
			$this->cell(29.4,4,$satuan['str1'],0,0,'L',0);
			$this->cell(29.8,4,'',0,0,'L',0);
			$this->Ln();
			
			$jn = number_format($this->kemasjm,4,'.',',');
			$this->Ln();
			$this->sety($kordinatyy);			
		
			$this->setX(10);
			
			$this->cell(10,4,'',0,0,'L',0);
			//$this->cell(75,4,$jn.' '.$this->kemasjn.' / '.$this->kemasjn_nama,0,0,'L',0);
			$this->cell(70,4,'Kemasan: '.$this->kemasjm.' '.$this->kemasjn.' / '.$this->kemasjn_nama,0,0,'L',0);
			$this->cell(20,4,'',0,0,'L',0);
			
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(29.4,4,number_format($this->nettodtl,4,'.',',').' Kg',0,0,'L',0);
			
			$this->Ln();
			
			$this->setX(10);
			
			$this->cell(10,4,'',0,0,'L',0);
			$this->cell(75,4,'',0,0,'L',0);
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
			$this->SetFont('times','','8');
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
			$this->cell(43,4,'',0,0,'L',0);
			$this->cell(100,4,'=='.$this->jmbrg.' Jenis barang. Lihat Lembar Lanjutan==',0,0,'R',0);
			$this->cell(29.4,4,'',0,0,'L',0);

			$this->cell(25,4,number_format($this->FOB, 4, '.', ','),0,0,'R',0);
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
		//end isi detil\\
		
		$this->Rect(118.4, 222.5, 85, 5, 3.5, 'F');
		$this->Rect(9, 222.5, 194.4, 13, 3.5, 'F');
		$this->Rect(118.4, 222.5, 85, 13, 3.5, 'F');
		$this->Ln();
		$this->SetXY(9,228);
		$this->cell(38,4,'49. Nilai Tukar mata uang',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$tukar = number_format('', 4, ',', '.');
		$this->cell(50,4,$tukar,0,0,'R',0);
		
		$this->SetXY(119,223.5);
		$this->SetFont('times','B','8');
		$this->cell(36,4,'DATA PENERIMAAN NEGARA',0,0,'L',0);
		$this->Ln();
		$this->SetX(119);
		$this->SetFont('times','','8');
		$this->cell(36,4,'50.Nilai BK dalam rupiah',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$valNILAIBK = number_format($this->NILAIBK, 2, ',', '.');
		$this->cell(46,4,$valNILAIBK,0,0,'R',0);
		$this->Ln();
		$this->SetX(119);
		$this->cell(36,4,'51.PNBP',0,0,'L',0);
		$this->cell(2,4,':',0,0,'C',0);
		$valpnbp = number_format($this->PNBP, 2, ',', '.');
		$this->cell(46,4,$valpnbp,0,0,'R',0);
		$this->Ln();
		
		
		//G DAN I 
		$this->Rect(118.4, 235.5, 85, 50.5, 3.5, 'F');
		$this->SetX(9);
		$this->SetFont('times','B','8');
		$this->cell(40,4,'G. TANDA TANGAN EKSPORTIR/PPJK',0,0,'L',0);
		$this->cell(104,4,'I. BUKTI PEMBAYARAN',0,0,'R',0);
		$this->Ln();
		$this->SetX(9);
		$this->SetFont('times','','8');
		$this->cell(38,4,'Dengan ini saya menyatakan bertangung jawab atas kebenaran hal-hal',0,0,'L',0);
		$this->Ln();
		$this->SetX(9);
		$this->cell(38,4,'yang diberitahukan dalam Pemberitahuan Ekspor Barang ini',0,0,'L',0);
		$this->Ln();
		$this->Ln();
		$this->SetX(30);
		$this->SetFont('times','','8');
		$this->cell(51,5,', '.date("d-m-Y"),0,0,'C',0);
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->SetX(30);
		$this->cell(51,5,'-'.$this->TTDPEB.'-',0,0,'C',0);
		
		
		$this->Rect(122, 244, 80, 8, 3.5, 'F');
		$this->Rect(122, 244, 15, 25, 3.5, 'F');
		$this->Rect(137, 244, 65, 4, 3.5, 'F');
		$this->Rect(137, 244, 32.5, 25, 3.5, 'F');
		$this->Rect(169.5, 244, 32.5, 25, 3.5, 'F');
		$this->Rect(137, 248, 16, 21, 3.5, 'F');
		$this->Rect(169.5, 248, 16, 21, 3.5, 'F');
		
		$this->SetXY(122,240);
		$this->SetFont('times','','8');
		$this->cell(36,4,'SSPCP :',0,0,'L',0);
		$this->Ln();
		$this->SetX(124);
		$this->cell(3,8,'Jen.Pen',0,0,'L',0);
		$this->Ln();
		$this->SetX(126);
		$this->cell(3,8,'BK',0,0,'L',0);
		$this->Ln();
		$this->SetX(125);
		$this->cell(3,8,'PNBP',0,0,'L',0);
		$this->Ln();
		$this->SetX(125);
		$this->cell(3,8,'Pejabat Penerima',0,0,'L',0);
		$this->SetX(170);
		$this->cell(100,8,'Nama/Stempel Instansi',0,0,'L',0);
		$this->Ln();
		$this->SetX(125);
		$this->cell(3,10,'............................',0,0,'L',0);
		
		$this->SetXY(140,249);
		$this->cell(36,2,'Nomor',0,0,'L',0);
		$this->SetXY(158,249);
		$this->cell(36,2,'Tgl',0,0,'L',0);
		$this->SetXY(173,249);
		$this->cell(36,2,'Nomor',0,0,'L',0);
		$this->SetXY(190,249);
		$this->cell(36,2,'Tgl',0,0,'L',0);
		$this->Ln();
		
		$this->SetXY(5.4,286);
		$this->SetFont('times','','8');
		$this->cell(100,5,'Sesuai Lampiran I P-41/BC/2008',0,0,'L',0);
		
		$this->SetFont('times','I','8');
		$this->cell(51,5,date("d/m/Y"),0,0,'L',0);
		
		$this->SetFont('times','','8');
		$this->cell(50,5,'Lembar ke-1/2/3 untuk KPBC / BPS / BI',0,0,'L',0);
		
		$this->SetXY(5.4,10);		
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
	$pdf->row = $DATA;
	$pdf->model_sesi = $this->model_sesi;
	$pdf->session = $this->session;
	//$pdf->countryLogin = $countryLogin;
	//$pdf->rowcase = $rowcase;
	//$pdf->publicFunction = $this->public_function;
	
	$pdf->Open();
	$pdf->SetDisplayMode('real');
	$pdf->SetTitle('BC 3.0');
	$pdf->SetAuthor('PT EDI Indonesia');
	$pdf->SetSubject('BC 3.0');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->fillForm($arrayDetail);
	$pdf->Output();
?>