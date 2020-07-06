<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Newtable {
	var $rows				= array();
	var $columns			= array();
	var $hiderows			= array();
	var $keys				= array();
	var $proses				= array();
	var $keycari			= array();
	var $heading			= array();
	var $alignrows			= array();
	var $auto_heading		= TRUE;
	var $show_chk			= TRUE;
	var $show_menu  		= FALSE;
	var $show_no			= TRUE;
	var $caption			= NULL;	
	var $template 			= NULL;
	var $newline			= "\n";
	var $empty_cells		= "";
	var $actions			= "";
	var $detils				= "";
	var $detils_tipe		= "";
	var $td_click			= "";
	var $baris				= "AUTO";
	var $db 				= "";
	var $hal 				= "AUTO";
	var $uri				= "";
	var $show_search		= TRUE;
	var $orderby			= 1;
	var $sortby				= "ASC";
	var $formid				= "tb_form";
	var $divid				= "div_id";
	var $row_process		= "";
	var $indexField			= "";
	var $formField			= "";
	var $get_where			= "";
	var $tipe_proses		= "";
	var $check		        = "checkbox";
	var $show_paging		= TRUE;
	var $field_order		= TRUE;
	var $top_title		    = "";
	var $header_bg			= "";
    var $tb_order 			= "";
    var $set_title			= "";
    var $tblcount 			= "";
    var $count_keys	 		= array();
    var $show_action 		= FALSE;
    var $background			= "";
	
	function table_count($sqlcount) {
        $this->tblcount = $sqlcount;
        return;
    }

    function set_title($show) {
        $this->set_title = $show;
        return;
    }

    function background($color) {
        $this->background = 'background:'.$color;
        return;
    }
	
	function header_bg($color)
	{
		$this->header_bg = 'background:'.$color;
		return;
	}
	
	function Newtable()
	{
		$this->hiderows[] = 'HAL';
	}
	
	function top_title($title)
	{
		$this->top_title = $title;
		return;
	}
	
	function show_search($show)
	{
		$this->show_search = $show;
		return;
	}
	
	function show_paging($show)
	{
		$this->show_paging = $show;
		return;
	}
	
	function field_order($show)
	{
		$this->field_order = $show;
		return;
	}	
	
	function show_chk($show)
	{
		$this->show_chk = $show;
		return;
	}
	
	function show_menu($show)
	{
		$this->show_menu = $show;
		return;
	}
	
	function tipe_proses($show)
	{
		$this->tipe_proses = $show;
		return;
	}
	
	function show_no($show)
	{
		$this->show_no = $show;
		return;
	}
	
	function show_action($show) {
        $this->show_action = $show;
        return;
    }
	
	function columns($col)
	{
		$this->columns = $col;
		return;
	}
	
	function orderby($order)
	{
		$this->orderby = $order;
		return;
	}
	
	function sortby($sort)
	{
		$this->sortby = $sort;
		return;
	}
	
	function topage($to)
	{
		$this->hal = (int)$to;
		return;
	}
	
	function cidb($db)
	{
		$this->db = $db;
		return;
	}
	
	function rowcount($row)
	{
		$this->baris = $row;
		return;
	}
	
	function ciuri($uri)
	{
		$this->uri = $uri;
		return;
	}
	
	function action($act)
	{
		$this->actions = $act;
		return;
	}
	
	function detail($act)
	{
		$this->detils = $act;
		return;
	}
	
	function detail_tipe($act)
	{
		$this->detils_tipe = $act;
		$this->td_click = '';
		return;
	}	
	
	function detail_proses($act)
	{
		$this->detail_proses = $act;
		return;
	}
	
	function formField($act)
	{
		$this->formField = $act;
		return;
	}
		
	function indexField($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->indexField)) $this->indexField[] = $a;
		}
		return;
	}
		
	function hiddens($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->hiderows)) $this->hiderows[] = $a;
		}
		return;
	}
	
	function align($row)
	{
		$this->alignrows = $row;
		return;
	}
	
	function keys($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->keys)) $this->keys[] = $a;
		}
		return;
	}
	
	function group($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->group)) $this->group[] = $a;
		}
		return;
	}
	
	function count_keys($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->count_keys)) $this->count_keys[] = $a;
		}
		return;
	}
	
	function menu($row)
	{
		if ( ! is_array($row))
		{
			return FALSE;
		}
		$this->proses = $row;
		return;
	}
	
	function tombol_action($row) {
        if (!is_array($row)) {
            return FALSE;
        }
        $this->proses_action = $row;
        return;
    }
	
	function search($row)
	{
		if ( ! is_array($row))
		{
			return FALSE;
		}
		$this->keycari = $row;
		return;
	}
	
	function tipe_check($type)
	{
		if($type=="radio"){
			$this->check = "radio";
		}else{
			$this->check = "checkbox";	
		}
		return;
	}
	
	function set_template($template)
	{
		if ( ! is_array($template)) return FALSE;
		$this->template = $template;
	}
	
	function set_heading()
	{
		$args = func_get_args();
		$this->heading = (is_array($args[0])) ? $args[0] : $args;
	}
	
	function make_columns($array = array(), $col_limit = 0)
	{
		if ( ! is_array($array) OR count($array) == 0) return FALSE;
		$this->auto_heading = FALSE;
		if ($col_limit == 0) return $array;
		$new = array();
		while(count($array) > 0)
		{	
			$temp = array_splice($array, 0, $col_limit);
			if (count($temp) < $col_limit)
			{
				for ($i = count($temp); $i < $col_limit; $i++)
				{
					$temp[] = '&nbsp;';
				}
			}
			$new[] = $temp;
		}
		return $new;
	}

	function set_empty($value)
	{
		$this->empty_cells = $value;
	}
	
	function add_row()
	{
		$args = func_get_args();
		$this->rows[] = (is_array($args[0])) ? $args[0] : $args;
	}

	function set_caption($caption)
	{
		$this->caption = $caption;
	}	
	
	function set_formid($formid)
	{
		if($formid)
			$this->formid = $formid;
		else
			$this->formid = 'tb_form';		
	}	
	
	function set_divid($divid)
	{
		if($divid)
			$this->divid = $divid;
		else
			$this->divid = 'div_id';		
	}	

	function generate($table_data = NULL)
	{
        $sql_count = $this->tblcount;
		if ( ! is_null($table_data))
		{
			if (is_object($table_data))
			{
				$this->_set_from_object($table_data);
			}
			elseif (is_array($table_data))
			{
				$set_heading = (count($this->heading) == 0 AND $this->auto_heading == FALSE) ? FALSE : TRUE;
				$this->_set_from_array($table_data, $set_heading);
			}
			elseif ($table_data!="")
			{ 
				if(!is_array($this->uri)){
					$this->uri = explode("|",$this->uri);					
				}
				if ($this->db == "" || !is_array($this->uri)) return 'Missing required params';
				$kunci = "";
				$terkunci = "";
				$cari = "";
				$tercari = "";
				if($key = array_search('search', $this->uri))
				{
					$kunci = (int)$this->uri[$key+1];
					if ( array_key_exists($kunci, $this->keycari))
					{
						#print_r($this->keycari);
						$terkunci = $this->keycari[$kunci];
						$terkunci = $terkunci[0];
						$cari = $this->uri[$key+2];
						if ($cari != "")
						{		
							if (strpos(strtolower($cari), "tag-tanggal") === false ){	
								if (strpos(strtolower($cari), "tag-select") === false ){																		
									$cari = str_replace("'", "''", $cari);
									$tercari = "$terkunci LIKE '%$cari%'";	
									$tipcari = "tag-input";
								}else{								
									$cari = str_replace("tag-select;","",strtolower($cari));	
									$cari = str_replace("'", "''", $cari);
									$tercari = "$terkunci = '$cari'";
									$tipcari = "tag-select";
								}
							}else{
								if (strpos(strtolower($cari), "tag-tanggal-2field") === false ){										
									$cari = str_replace("tag-tanggal;","",strtolower($cari));
									$arrayCari = explode(";",$cari);
									$tanggal1  = $arrayCari[0];
									$tanggal2  = $arrayCari[1];
									#for mysql
									$tercari = "STR_TO_DATE(".$terkunci.",'%Y-%m-%d') BETWEEN '".$tanggal1."' AND '".$tanggal2."'";	
									#---------
									$tipcari = "tag-tanggal";
								}else{									
									$cari = str_replace("tag-tanggal-2field;","",strtolower($cari));
									$arrayCari = explode(";",$cari);
									$tanggal1  = $arrayCari[0];
									$tanggal2  = $arrayCari[1];
									$terkunci = explode(";",$terkunci);
									#for mysql
									$tercari = "STR_TO_DATE(".$terkunci[0].",'%Y-%m-%d') > '".$tanggal1."' AND STR_TO_DATE(".$terkunci[1].",'%Y-%m-%d') < '".$tanggal2."'";	
									#---------
									$tipcari = "tag-tanggal-2field";
								}
							}
						}
					}
				}
				if ( $this->baris == "AUTO")
				{
					if($key = array_search('row', $this->uri)) $this->baris = (int)$this->uri[$key+1];
					if($this->baris<1) $this->baris = 10;
				}
				if ( $this->baris != "ALL")
				{
					if ( $this->baris > 100) $this->baris = 100;
				}	
				if ($tercari != "") {
                    $ada = strpos(strtolower($table_data), "where");
                    if ($ada === false) {
                        $table_data .= " WHERE $tercari";
                        if (trim($sql_count) != "") {
                            $sql_count .= " WHERE $tercari";
                        }
                    } else {
                        $table_data .= " AND $tercari";
                        if (trim($sql_count) != "") {
                            $sql_count .= " AND $tercari";
                        }
                    }
                } 
				#echo $table_data;
				
				if($this->group){				
					$komax="";
					$group="";
					foreach ($this->group as $a)
					{
						$group .= $komax.$a;
						$komax = ",";
					}				
					$table_data = $table_data." GROUP BY ".$group;
					if (trim($sql_count) != "") {
                        $sql_count = $sql_count . " GROUP BY " . $group;
                    }
				}
				#echo $table_data;
				$total_record = 0;
				if($this->count_keys){
					$xx="";
					$zz="";
					foreach($this->count_keys as $c){
						$z .= $xx.$c;
						$xx = ",";
					}
					$table_count = $this->db->query("SELECT COUNT($z) AS JML FROM ($table_data) AS TBL");
				}else{
					$table_count = $this->db->query("SELECT COUNT(*) AS JML FROM ($table_data) AS TBL");
				}			
				if($table_count){
					$table_count = $table_count->row();
					$total_record = $table_count = $table_count->JML;
				}else{
					$total_record = 0;
				}
				
				#print($total_record); die();
				if ( $this->baris != "ALL")
				{ //echo  $this->hal."->";
                    $table_count = ceil($table_count / $this->baris);
                    //if ( $this->hal == "AUTO") {
                    if ($key = array_search('page', $this->uri)) {
                        $this->hal = (int) $this->uri[$key + 1];
                    }
                    //}
                    if ($this->hal < 1) {
                        $this->hal = 1;
                    }
                    if ($this->hal > $table_count) {
                        $this->hal = $table_count;
                    }
                    if ($this->hal <= 1) {
                        $dari = 0;
                        $sampai = $this->baris;
                    } else {
                        $dari = ($this->hal - 1) * $this->baris;
                        $sampai = $this->baris;
                    }
                    if ($key = array_search('order', $this->uri)) {
                        $this->orderby = $this->uri[$key + 1];
                        $this->sortby = $this->uri[$key + 2];
                        $orderby = "$this->orderby $this->sortby";
                    } else {
                        $orderby = "$this->orderby $this->sortby";
                    }
                    $table_data .= " ORDER BY $orderby LIMIT $dari, $sampai";
                }
				//print ($table_data);
				$table_data = $this->db->query($table_data);
				$this->_set_from_object($table_data);
				#print($table_data); //die();
			}
		}
	
		if (count($this->heading) == 0 AND count($this->rows) == 0)
		{
			return 'Undefined table data';
		}
	
		$this->_compile_template();
		$out = "<span id=\"".$this->divid."\">";			
		if($this->top_title){
			$out .= ' <h4 class="smaller lighter blue">'.$this->top_title."</h4>";
		}
		if ($this->show_search || $this->show_chk || $this->show_no || $this->show_menu  || $this->show_action)
		{
			if ($this->detils_tipe == "pilih" || $this->detils_tipe == "detil_priview_bottom" || $this->detils_tipe == "pilih_n_save"){
				$colspan = count($this->heading)+1;
			}else{
				$colspan = count($this->heading);
			}
			if($this->background){
				$this->background = "style=\"".$this->background."\"";
			}	

			$out .= $this->template['table_open'].'<form id="'.$this->formid.'" name="'.$this->formid.'"  action="'.$this->actions.'">';
			$out .= '<tr class="head"><th colspan="'.$colspan.'" align="left" '.$this->background.'>&nbsp;';
		}
		else
		{
			$out .= $this->template['table_open'].'<form id="'.$this->formid.'" name="'.$this->formid.'" action="'.$this->actions.'">';
			$out .= "<div id=\"".$this->divid."\">";
		}
		$out .= '<input type="hidden" id="orderby" value="'.$this->orderby.'"><input type="hidden" id="sortby" value="'.$this->sortby.'">';
		if (count($this->proses) > 0 && ($this->show_chk || $this->show_menu)  )
		{
			if($this->tipe_proses=="button"){
				$m = 0;
				foreach ($this->proses as $a => $b){
					if($b[5]=="btn-group"){		
						
						$out.='<div class="btn-group">';
										
						$out.="<a href=\"javascript:void(0)\" data-toggle=\"dropdown\" class=\"dropdown-toggle\" 
							   id=\"tb_menu".$this->formid.$m."\" formid=\"".$this->formid."\" title=\"".$a."\" style=\"margin-right:12px\"> ";							
						$out.= '<i class="'.$b[3].' "></i> '.$a;					
						$out.="</a>";
						
						$out.='<ul class="dropdown-menu dropdown-yellow">';	
						$n = 0;			
						foreach ($b[6] as $x => $y){
							$out.="<li>";
							$out.="<a href=\"javascript:void(0)\" onclick=\"button_menu('".$this->formid."',this.id)\" 
							   id=\"tb_menu".$this->formid.$m.$n."\" formid=\"".$this->formid."\" title=\"".$x."\"  ";							
							$out.= 'met="'.$y[0].'" url="'.$y[1].'" jml="'.$y[2].'" div="'.$this->divid.'" wnh="'.$y[4].'"><i class="'.$y[3].'"></i> '.$x;					
							$out.="</li>";
							$n++;
						}
						$out.="</ul>";
						$out.='</div>';
					}
					else{
						$out.="<a href=\"javascript:void(0)\" onclick=\"button_menu('".$this->formid."',this.id)\" id=\"tb_menu".$this->formid.$m."\"
								formid=\"".$this->formid."\" title=\"".$a."\" style=\"margin-right:12px\" ";							
						$out.= 'met="'.$b[0].'" url="'.$b[1].'" jml="'.$b[2].'" div="'.$this->divid.'" wnh="'.$b[4].'"><i class="'.$b[3].'"></i> '.$a;					
						$out.="</a>";
					}
					$m++;
				}
				
			}
			else if($this->tipe_proses=="both"){
				
				foreach ($this->proses as $a => $b){
					
					if(strtolower($a)=="select"){
						
						$out .= "<select id=\"tb_menu".$this->formid."\" title=\"Pilih proses yang akan dijalankan\" formid=\"".$this->formid."\" onChange=\"tb_menu('".$this->formid."')\" class=\"tb_menu\"><option url=\"\">Pilih Proses &nbsp;&nbsp;</option>";
						foreach ($b as $x => $z)
						{
							$out .= '<option met="';
							$out .= $z[0];
							$out .= '" jml="';
							$out .= $z[2];
							$out .= '" url="';
							$out .= $z[1];
							$out .= '" div="';
							$out .= $this->divid;
							$out .= '">';
							$out .= "- $x";
							$out .= '</option>';
						}
						$out .= '</select>&nbsp;&nbsp;&nbsp;';
						
					}else{
						
						$s = 0;
						foreach ($b as $m => $n){
							$out.="<a href=\"javascript:void(0)\" onclick=\"button_menu('".$this->formid."',this.id)\" id=\"tb_menu".$this->formid.$s."\"
									formid=\"".$this->formid."\" title=\"".$m."\" ";							
							$out.= 'met="'.$n[0].'" url="'.$n[1].'" jml="'.$n[2].'" div="'.$this->divid.'" wnh="'.$n[4].'">';					
							$out.="<img src=\"".base_url()."img/".$n[3]."\" alt=\"\" title=\"".$m."\" 
												 align=\"texttop\" width='16px' height='16px' style=\"border:none\"/>&nbsp;".$m."
									   </a>&nbsp;";
							$s++;
						}
				
					}
				}
				
			}else{
			
				$out .= "<select id=\"tb_menu".$this->formid."\" title=\"Pilih proses yang akan dijalankan\" formid=\"".$this->formid."\" onChange=\"tb_menu('".$this->formid."')\" class=\"tb_menu\"><option url=\"\">Pilih Proses &nbsp;&nbsp;</option>";
				foreach ($this->proses as $a => $b)
				{
					$out .= '<option met="';
					$out .= $b[0];
					$out .= '" jml="';
					$out .= $b[2];
					$out .= '" url="';
					$out .= $b[1];
					$out .= '" div="';
					$out .= $this->divid;
					$out .= '">';
					$out .= "- $a";
					$out .= '</option>';
				}
				$out .= '</select>';
			}
			$out .= '&nbsp;<label id="labelload'.$this->formid.'" class="labelload">Loading...</label>';
		}
		
		if (count($this->rows) == 0){
			$disabled = "";	
		}
		
		if ($this->show_search)
		{
			//print_r($this->keycari);
			$out .= '<span>Cari&nbsp;&nbsp;<combo><select id="tb_keycari'.$this->formid.'" title="Pilih kategori yang akan dicari" '.$disabled.' onChange="TagChange(this.id)" style="height:23px;margin:0px;min-width:3px;padding-right:10px">';
			foreach ($this->keycari as $a => $b)
			{
				if($kunci==$a)
					$out .= '<option selected value="';
				else
					$out .= '<option value="';
				$out .= $a;
				$out .= '"';
				$out .= ' tag="'.strtolower($b[2]).'">';
				$out .= $b[1];
				$out .= '</option>';
			}
			$out .= '</select></combo>'; 
			
			$tag="";
			foreach ($this->keycari as $a => $b){
				foreach ($b as $c => $d){
					if($d=="tag-select"){
						#$tagselect = form_dropdown('',$b[3],$cari,'id="tb_cari'.$this->formid.'" class="text" style="height:23px;margin:0px;min-width:3px;padding:2px"');
						$tagselect = '<select id="tb_cari'.$this->formid.'" class="text" style="height:23px;margin:0px;min-width:3px;padding:2px">';
						foreach($b[3] as $s => $teh){
							$tagselect.= '<option value="'.$s.'">'.$teh.'</option>';
						}
						$tagselect.= '</select>';
					}
					else if($d=="tag-tanggal"){
						$tagtanggal .= '<input type="text" class="text date" id="tb_cari'.$this->formid.'_tgl1" title="Masukkan tanggal" onfocus="ShowDP(this.id);" onmouseover="ShowDP(this.id);" value="'.$tanggal1.'" style="height:22px;margin:0px;min-width:3px"/>';
						$tagtanggal .= '&nbsp;s/d&nbsp;<input type="text" class="text date" id="tb_cari'.$this->formid.'_tgl2" title="Masukkan tanggal" onfocus="ShowDP(this.id);" onmouseover="ShowDP(this.id);" value="'.$tanggal2.'" style="height:22px;margin:0px;min-width:3px"/>';
					}
					else if($d=="tag-tanggal-2field"){
						$tagtanggal .= '<input type="text" class="text date" id="tb_cari'.$this->formid.'_tgl1" title="Masukkan tanggal" onfocus="ShowDP(this.id);" onmouseover="ShowDP(this.id);" value="'.$tanggal1.'" style="height:22px;margin:0px;min-width:3px"/>';
						$tagtanggal .= '&nbsp;s/d&nbsp;<input type="text" class="text date" id="tb_cari'.$this->formid.'_tgl2" title="Masukkan tanggal" onfocus="ShowDP(this.id);" onmouseover="ShowDP(this.id);" value="'.$tanggal2.'" style="height:22px;margin:0px;min-width:3px"/>';
					}
					else{
						$taginput = '<input type="text" class="tb_text" id="tb_cari'.$this->formid.'" title="Masukkan kata kunci yang ingin dicari" '.$disabled.' value="'.$cari.'" style="height:22px;margin:0px;min-width:3px"/>';
					}
				}	
			}
			if($tipcari=="tag-tanggal"){
				$inputcari = $tagtanggal;
			}else if($tipcari=="tag-tanggal-2field"){
				$inputcari = $tagtanggal;
			}else if($tipcari=="tag-select"){
				$inputcari = $tagselect;
			}else{
				$inputcari = $taginput;
			}
			
			$out .= '&nbsp;<b id="TagChange'.$this->formid.'">'.$inputcari.'</b>';
			$out .="&nbsp;<button type=\"button\" class=\"btn btn-xs btn-primary\" OnClick=\"tb_cari('".$this->actions."', '".$this->divid."', '".$this->baris."','".$this->orderby."', '".$this->sortby."','tb_hal".$this->formid."','tb_cari".$this->formid."','tb_keycari".$this->formid."');\" style=\"font-size:12px;height:22.5px;\"><i class=\"icon-search\" style=\"font-size:12px\"></i>Cari</button>";
			
			$out .= '</span>';
			
			$out .= "<script> 
						if($('#tb_keycari'+'".$this->formid."').find('option:selected').attr('tag')=='tag-tanggal'){
							$('#TagChange".$this->formid."').html('".$tagtanggal."');
						}else if($('#tb_keycari'+'".$this->formid."').find('option:selected').attr('tag')=='tag-select'){
							$('#TagChange".$this->formid."').html('".$tagselect."');	
						}else if($('#tb_keycari'+'".$this->formid."').find('option:selected').attr('tag')=='tag-tanggal-2field'){
							$('#TagChange".$this->formid."').html('".$tagtanggal."');
						}else{
							$('#TagChange".$this->formid."').html('".$taginput."');
						}
						function TagChange(id){
							if($('#'+id).find('option:selected').attr('tag')=='tag-select'){
								$('#TagChange".$this->formid."').html('".$tagselect."');
							}else if($('#'+id).find('option:selected').attr('tag')=='tag-tanggal'){
								$('#TagChange".$this->formid."').html('".$tagtanggal."');
							}else if($('#'+id).find('option:selected').attr('tag')=='tag-tanggal-2field'){
								$('#TagChange".$this->formid."').html('".$tagtanggal."');
							}else{
								$('#TagChange".$this->formid."').html('".$taginput."');
							}
						}
					</script>";
			
		}else{
			$out .= '<input type="hidden" id="tb_keycari'.$this->formid.'">';	
			$out .= '<input type="hidden" id="tb_cari'.$this->formid.'">';	
		}
		if ($this->show_search || $this->show_chk || $this->show_no ||  $this->show_menu || $this->show_action)
		{
			$out .= '</th></tr>';
		}
		if ($this->caption)
		{
			$out .= $this->newline;
			$out .= '<caption>' . $this->caption . '</caption>';
			$out .= $this->newline;
		}
		
		if (count($this->rows) > 0){
			if (count($this->heading) > 0)
			{
				$out .= $this->template['heading_row_start'];
				$out .= $this->newline;
				$h=0;
				foreach($this->heading as $z => $heading)
				{
					$z;
					if ( ! in_array($heading, $this->hiderows))
					{
						if ( $z == 0 && $this->show_no){
							$out .= '<th width="1" align="left" '.$this->header_bg.' style="border-left:solid 1px #DDDDDD">';
							$out .= $heading;$h--;
						}
						elseif ( $z == 1 && $this->show_chk ){
							$out .= '<th width="1" align="left" '.$this->header_bg.'>';
							$out .= $heading;$h--;
						}else{
							$z--;
							
							if(count($this->alignrows) > 0){
								$out .= str_replace("<th>","<th align=\"".$this->alignrows[$h]."\">",$this->template['heading_cell_start']);		
							}else{
								if ($heading == "ACTION") {
									$out .= '<th width="6%">';
								} else {
									$out .= $this->template['heading_cell_start'];
								}
							}														
							if ( $this->baris != "ALL")
							{
								if($z==$this->orderby){
									if($this->sortby=="ASC"){									
										$indexData = 'row|'.$this->baris.'|page|'.$this->hal.'|order|'.$z.'|DESC|';		
										if($this->field_order){
											$this->tb_order = "onclick=\"tb_order('".$this->formid."','".$this->divid."','".$indexData."','tb_keycari".$this->formid."', 'tb_cari".$this->formid."')\"";
										}		
										$out .= "<span ".$this->tb_order." class=\"order\" title=\"Urutkan Data berdasarkan ".$heading." (Z-A)\" orderby=\"$z\" sortby=\"DESC\">".ucwords(strtolower($heading))."</span>";
									}else{
										$indexData = 'row|'.$this->baris.'|page|'.$this->hal.'|order|'.$z.'|ASC|';	
										if($this->field_order){
											$this->tb_order = "onclick=\"tb_order('".$this->formid."','".$this->divid."','".$indexData."','tb_keycari".$this->formid."', 'tb_cari".$this->formid."')\"";
										}			
										$out .= "<span ".$this->tb_order." class=\"order\" title=\"Urutkan Data berdasarkan ".$heading." (A-Z)\" orderby=\"$z\" sortby=\"ASC\">".ucwords(strtolower($heading))."</span>";
									}
								}else{
									$indexData = 'row|'.$this->baris.'|page|'.$this->hal.'|order|'.$z.'|ASC|';	
									if($this->field_order){
										$this->tb_order = "onclick=\"tb_order('".$this->formid."','".$this->divid."','".$indexData."','tb_keycari".$this->formid."', 'tb_cari".$this->formid."')\"";
									}
									$out .= "<span ".$this->tb_order." class=\"order\" title=\"Urutkan Data berdasarkan ".$heading." (A-Z)\" orderby=\"$z\" sortby=\"ASC\">".ucwords(strtolower($heading))."</span>";
								}
							}
							else
							{
								$out .= "<span class=\"order\" orderby=\"$z\" sortby=\"ASC\">".$heading."</span>";
							}
						}
						$out .= $this->template['heading_cell_end'];
						$h++;
					}
				}
				
				if ($this->detils_tipe == "pilih" || $this->detils_tipe == "detil_priview_bottom" || $this->detils_tipe == "pilih_n_save") {
					$out .= '<th width="22" '.$this->header_bg.'>&nbsp;</th>';
				}
	
				$out .= $this->template['heading_row_end'];
				$out .= $this->newline;	
							
			}
		}else{
			$out .="";
		}

		if (count($this->rows) > 0)
		{
			
			if ( $this->hal<=1)
				$x = 1;			
			else
				$x = ($this->hal - 1) * $this->baris + 1;
			
			$i = 1;
			$cls="odd";
			foreach($this->rows as $row)
			{
				if ( ! is_array($row))
				{
					break;
				}
				
				$keyz = "";
				$koma = "";
				$keypilih = "";
				$batas = "";
				foreach ($this->keys as $a)
				{
					$keyz .= $koma.$row[$a];
					$koma = "|";
					$keypilih .= $batas.$row[$a];
					$batas = ";";
				}
				$name = (fmod($i++, 2)) ? '' : 'alt_';
				
				$field = "";
				foreach ($this->indexField as $b)
				{
					$field .= $b.";";
				}
			
				//$out .= $this->template['row_'.$name.'start'];
				
				if ($this->detils==""){
					if($this->detils_tipe=="pilih"){			
						$out .= "<tr title=\"Klik untuk memilih data\" id=\"pilih\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"td_pilih('".$this->formField."|".$keypilih."|".$field."')\" class=\"pointer\">";
					}
					elseif($this->detils_tipe=="detil_priview"){			
						$out .= "<tr title=\"Klik untuk priview\" id=\"pilih\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"td_detil_priview('".$this->divid."|".$keypilih."')\" class=\"pointer\">";
					}
					elseif($this->detils_tipe=="pilih_proses"){			
						$out .= "<tr title=\"Klik untuk memilih data\" id=\"pilih\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"".$this->detail_proses."('".$keypilih."')\" class=\"pointer\">";
					}
					else{
						$out .= "<tr urldetil=\"\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\">";
					}
				}else{
					if($this->detils_tipe=="bawah"){	
						$out .= "<tr title=\"Klik untuk menampilkan detil data\" id=\"bawah\" urldetil=\"".$this->detils."\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"td_click('".$keyz."')\" style=\"cursor:pointer\">";
					}
					else if($this->detils_tipe=="pilih"){			
						$out .= "<tr title=\"Klik untuk memilih data\" id=\"pilih\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"td_pilih('".$this->formField."|".$keypilih."|".$field."')>";
					}
					else if($this->detils_tipe=="popStock"){			
						$out .= "<tr title=\"Klik untuk memilih data\" id=\"popStock\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"td_pilih('".$this->formField."|".$keypilih."|".$field."')\">";
					}
					elseif($this->detils_tipe=="detil_priview"){			
						$out .= "<tr title=\"Double Klik untuk priview\" urldetil=\"".$this->detils."/".$keyz."\" id=\"detil_priview\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" ondblclick=\"td_detil_priview('".$this->divid."|".$keypilih."',this)\" style=\"cursor:pointer\">";
					}
					elseif($this->detils_tipe=="detil_priview_bottom"){			
						$out .= "<tr title=\"Double Klik untuk priview\" urldetil=\"".$this->detils."/".$keyz."\" id=\"detil_priview".$i."\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" ondblclick=\"td_detil_priview_bottom('".$this->divid."|".$keypilih."',this)\" style=\"cursor:pointer\">";
					}
					elseif($this->detils_tipe=="detil_priview_blank"){			
						$out .= "<tr title=\"Double Klik untuk priview\" urldetil=\"".$this->detils."\" keyz=\"".$keyz."\" id=\"detil_priview\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" ondblclick=\"td_detil_priview_blank('".$this->divid."|".$keypilih."',this)\" style=\"cursor:pointer\">";
					}
					elseif($this->detils_tipe=="detil_priview_kanan"){	
						$out .= "<tr class=\"klikkanan\" title=\"Klik Kanan untuk menampilkan detil data\" urldetil=\"".$this->detils."/".$keyz."\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" >";
					}
					else if($this->detils_tipe=="pilih_proses"){			
						$out .= "<tr title=\"Klik untuk memilih data\" id=\"pilih\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"".$this->detail_proses."('".$keypilih."')\" class=\"pointer\">";
					}
				}
				$out .= $this->newline;
								
				if($cls=="odd"){
					$cels = $this->template['cell_alt'];	
				}else{
					$cels = $this->template['cell_odd'];	
				}
				$out .= $cels.$x.'</td>';
				if ($this->show_chk) $out .= $cels."<input type=\"".$this->check."\" name=\"tb_chk".$this->formid."[]\" id=\"tb_chk".$this->formid."\" class=\"tb_chk\" value=\"".$keyz."\" onclick=\"tb_chk()\"/></td>";
				
				$h=0;
				foreach($row as $rowz => $cell)
				{
					if ( !in_array($rowz, $this->hiderows))
					{
						if(count($this->alignrows) > 0){	
							if($cls=="odd"){					
								$out .= str_replace('class="alt"',' class="alt" align="'.$this->alignrows[$h].'"',$cels);
							}else{
								$out .= str_replace('class="odd"',' class="odd" align="'.$this->alignrows[$h].'"',$cels);
							}
						}else{
							$out .= $cels;
						}
						//$out .= $cels;
						if ($cell === "")
						{
							$out .= $this->empty_cells;
						}
						else
						{
							$out .= $cell;
						}
						
						$out .= $this->template['cell_'.$name.'end'];
						$h++;
					}
				}
				if($this->detils_tipe=="pilih"){ 
					$out .= $cels."<button type=\"button\" name=\"pilih".$this->formid."\" id=\"pilih".$this->formid."\" class=\"btn btn-info btn-xs\" style=\"font-size:12px;letter-spacing:1px\" onclick=\"td_pilih('".$this->formField."|".$keypilih."|".$field."');\">Pilih</button></td>";
				}
				elseif($this->detils_tipe=="popStock"){ 
					$out .= $cels."<input type=\"button\" name=\"popStock".$this->formid."\" id=\"popStock".$this->formid."\" class=\"button\" onclick=\"td_pop_stock('".$keypilih."');\" value=\"Pilih Detil\"></td>";
				}
				elseif($this->detils_tipe=="detil_priview_bottom"){ 
					$out .= $cels."<img urldetil=\"".$this->detils."/".$keyz."\" onclick=\"td_detil_priview_bottom('".$this->divid."|".$keypilih."',this);\" src=\"".base_url()."img/nolines_plus.gif\" alt=\"\" title=\"Expand\" btnname=\"expand\" class=\"expand\"></td>";
				}
				elseif($this->detils_tipe=="pilih_proses"){ 
					$out .= $cels."<button type=\"button\" name=\"pilih".$this->formid."\" id=\"pilih".$this->formid."\" class=\"btn btn-info btn-sm\" onclick=\"".$this->detail_proses."('".$keypilih."');\">Pilih</button></td>";
				}
				
				#========

                if ($this->show_action) {
                    $out .= $cels;

                    $mx = 0;
                    foreach ($this->proses_action as $a => $b) {
                        $out.="<a href=\"javascript:void(0)\" style=\"margin-top:15px;\" class=\"btn btn-danger btn-sm\" onclick=\"button_action('" . $this->formid . "',this.id,'" . $keyz . "')\" id=\"tb_menu" . $this->formid . $mx . "\"
								formid=\"" . $this->formid . "\" title=\"" . $a . "\" ";
                        $out.= 'met="' . $b[0] . '" url="' . $b[1] . '" jml="' . $b[2] . '" div="' . $this->divid . '" >';
                        $out.="<i class=\"icon-trash\"></i>" . $a . "</a>&nbsp;";
                        $mx++;
                    }

                    $out .= "</td>";
                }

                #========
				
				
				$out .= $this->template['row_'.$name.'end'];
				$out .= $this->newline;	
				$x++;
				if($cls=="alt"){$cls="odd";}elseif($cls=="odd"){$cls="alt";}
			}
		}
		else
		{	
			if($this->header_bg){
				$out .= '<tr><td colspan="'.count($this->heading).'" align="center" '.str_replace("background","color:#FFFFFF;background",$this->header_bg).'>Data Tidak Ditemukan</td></tr>';
			}else{
				$out .= '<tr><td colspan="'.count($this->heading).'" align="center" style="background:#438EB9;color:#FFFFFF;font-weight:bold;border:none">Data Tidak Ditemukan</td></tr>';
			}
		}
		if ( $this->baris != "ALL" && $this->show_paging)
		{ 
			$datast = ($this->hal - 1);
			if($datast<1) $datast = 1;
			else $datast = $datast * $this->baris + 1;
			$dataen = $datast + $this->baris - 1;
			if($total_record < $dataen) $dataen = $total_record;
			if($total_record==0) $datast = 0;
			
			if( $this->detils_tipe )
				$colspan = count($this->heading)+1;
			else
				$colspan = count($this->heading);
			
			$out .='<tr class="head">
						<th colspan="'.$colspan.'" align="left" '.$this->background.'>
						<input type="hidden" class="tb_text" id="tb_view" title="Masukkan jumlah data yang ingin ditampilkan kemudian tekan Enter" value="'.$this->baris.'" readonly/>'.$this->baris.' Data Per Halaman. Menampilkan '.$datast.' - '.$dataen.' Dari '.$total_record.' Data.';
			
			if($total_record > $this->baris){ 
				$prev = $this->hal-1;
				$next = $this->hal+1;
				$firsAjax = 'row|'.$this->baris.'|page|1|order|'.$this->orderby.'|'.$this->sortby.'|';
				$prevAjax = 'row|'.$this->baris.'|page|'.$prev.'|order|'.$this->orderby.'|'.$this->sortby.'|';
				$nextAjax = 'row|'.$this->baris.'|page|'.$next.'|order|'.$this->orderby.'|'.$this->sortby.'|';
				$lastAjax = 'row|'.$this->baris.'|page|'.$total_record.'|order|'.$this->orderby.'|'.$this->sortby.'|';
				$firsExec = "tb_pagging('".$this->actions."', '".$this->divid."', '".$firsAjax."', 'tb_keycari".$this->formid."', 'tb_cari".$this->formid."');";
				$prevExec = "tb_pagging('".$this->actions."', '".$this->divid."', '".$prevAjax."', 'tb_keycari".$this->formid."', 'tb_cari".$this->formid."');";
				$nextExec = "tb_pagging('".$this->actions."', '".$this->divid."', '".$nextAjax."', 'tb_keycari".$this->formid."', 'tb_cari".$this->formid."');";
				$lastExec = "tb_pagging('".$this->actions."', '".$this->divid."', '".$lastAjax."', 'tb_keycari".$this->formid."', 'tb_cari".$this->formid."');";
				$out .="<span>";
				if ($this->hal != "1"){
					$out .="<a href=\"javascript:void(0)\" onclick=\"".$firsExec."\" title=\"First\" class=\"paging\">&laquo;</a>&nbsp;";
					$out .="<a href=\"javascript:void(0)\" onclick=\"".$prevExec."\" title=\"Prev\" class=\"paging\">&lsaquo;&nbsp;</a>&nbsp;";
				}else{
					$out .="<font class=\"pdisabled\">&laquo;</font>&nbsp;";
					$out .="<font class=\"pdisabled\">&lsaquo;&nbsp;</font>&nbsp;";
				}
				
				$out .="Halaman <input type=\"text\" class=\"tb_text\" id=\"tb_hal".$this->formid."\" title=\"Masukkan nomor halaman yang diinginkan kemudian klik Go\" value=\"".$this->hal."\" ".$disabled."  ondblclick=\"".$nextExec."\" style=\"width:30px;height:18px;font-size:11px;text-align:right;\"/>"; 
				
				$out .="&nbsp;<input type=\"button\" class=\"btn btn-primary btn-xs\" style=\"font-size:11px;margin-top:2.5%;\" OnClick=\"tb_go('".$this->actions."', '".$this->divid."', '".$this->baris."','".$this->orderby."', '".$this->sortby."','tb_hal".$this->formid."', 'tb_keycari".$this->formid."', 'tb_cari".$this->formid."');\" value=\"&nbsp;Go&nbsp;\">";
				$out .=" Dari ".$table_count;
				
				if ($this->hal != ($table_count)){
					$out .="<a href=\"javascript:void(0)\" onclick=\"".$nextExec."\" title=\"Next\" class=\"paging\">&nbsp;&rsaquo;</a>&nbsp;";
					$out .="<a href=\"javascript:void(0)\" onclick=\"".$lastExec."\" title=\"Last\" class=\"paging\">&raquo;</a>";	
				}else{
					$out .="<font class=\"pdisabled\">&nbsp;&rsaquo;</font>&nbsp;";
					$out .="<font class=\"pdisabled\">&raquo;</font>";
				}
				$out .="</span>";
			}else{
				$out .="<input type=\"hidden\" class=\"tb_text\" id=\"tb_hal".$this->formid."\" value=\"".$this->hal."\" ".$disabled."  ondblclick=\"".$nextExec."\" style=\"width:30px;text-align:right;\"/>"; 	
			}
				
			$out .='</th></tr></form>';
		}
		else
		{	
							
			$out .= '<tr class="head">
				<th colspan="'.count($this->heading).'" '.$this->background.'>
					Total '.$total_record.' Data.
				</th>
			</tr></form>';
		}
		$out .= $this->template['table_close'];
				
		$out .='</span>';
		
		if($this->detils_tipe=="bawah")		
		$out .='<span id="detils_bawah"></span>';
		
		return $out;
	}
	
	function clear()
	{
		$this->rows				= array();
		$this->heading			= array();
		$this->auto_heading		= TRUE;	
		$this->template 		= NULL;
	}
	
	function _set_from_object($query)
	{
		if ( ! is_object($query))
		{
			return FALSE;
		}
		
		if (count($this->heading) == 0)
		{
			if ( ! method_exists($query, 'list_fields'))
			{
				return FALSE;
			}
			empty($this->heading);
			if( $this->show_no ) $this->heading[] = 'No';
			if( $this->show_chk ){
				if($this->check != "radio"){
					$this->heading[] .= "<input type=\"checkbox\" id=\"tb_chkall".$this->formid."\" onclick=\"tb_chkall('".$this->formid."')\" class=\"tb_chkall\"/>";
				}else{
					$this->heading[] .= "&nbsp;";	
				}
			}
			foreach ($query->list_fields() as $a)
			{
				//if ( ! in_array($a, $this->hiderows)) $this->heading[] = $a;
				$this->heading[] = $a;
			}
			
			if ($this->show_action)
                $this->heading[] = 'ACTION';
			//print_r($this->heading);
		}
		
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$this->rows[] = $row;
			}
		}
	}

	function _set_from_array($data, $set_heading = TRUE)
	{
		if ( ! is_array($data) OR count($data) == 0)
		{
			return FALSE;
		}
		
		$i = 0;
		foreach ($data as $row)
		{
			if ( ! is_array($row))
			{
				$this->rows[] = $data;
				break;
			}
						
			if ($i == 0 AND count($data) > 1 AND count($this->heading) == 0 AND $set_heading == TRUE)
			{
				$this->heading = $row;
			}
			else
			{
				$this->rows[] = $row;
			}
			
			$i++;
		}
	}

 	function _compile_template()
 	{ 	
 		if ($this->template == NULL)
 		{	
 			$this->template = $this->_default_template();
 			return;
 		}
		
			
		$this->temp = $this->_default_template();
		foreach (array('table_open','heading_row_start', 'heading_row_end', 'heading_cell_start', 'heading_cell_end', 'row_start', 'row_end', 'cell_start','cell_alt','cell_odd', 'cell_end', 'row_alt_start', 'row_alt_end', 'cell_alt_start', 'cell_alt_end', 'table_close') as $val)
		{
			if ( ! isset($this->template[$val]))
			{
				$this->template[$val] = $this->temp[$val];
			}
		} 	
 	}
	
	function _size(){
		
	}
	
	function _default_template()
	{
		
		if($this->header_bg) $this->header_bg = 'style="'.$this->header_bg.'"';
		
		
		return  array (
						'table_open' 			=> '<table class="tabelajax" id="'.$this->formid.'">',

						'heading_row_start' 	=> '<tr>',
						'heading_row_end' 		=> '</tr>',
						'heading_cell_start'	=> '<th '.$this->header_bg.'>',
						'heading_cell_end'		=> '</th>',

						'row_start' 			=> '<tr>',
						'row_end' 				=> '</tr>',
						'cell_start'			=> '<td '.$this->td_click.'>',
						'cell_alt'				=> '<td '.$this->td_click.' class="alt">',
						'cell_odd'				=> '<td '.$this->td_click.' class="odd">',
						'cell_end'				=> '</td>',

						'row_alt_start' 		=> '<tr>',
						'row_alt_end' 			=> '</tr>',
						'cell_alt_start'		=> '<td '.$this->td_click.'>',
						'cell_alt_end'			=> '</td>',

						'table_close' 			=> '</table>'
					);	
	}
}