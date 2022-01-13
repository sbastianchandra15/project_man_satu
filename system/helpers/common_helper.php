<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

function test($x,$exit=0, $hide=false)
{
	echo ($hide) ? '<div style="display:none;">' : '';
	echo "<pre>";
	if(is_array($x) || is_object($x)){
		echo print_r($x);
	}elseif(is_string($x)){
		echo $x;
	}else{
		echo var_dump($x);
	}
	echo "</pre><hr />";
	echo ($hide) ? '</div>' : '';
	if($exit==1){ die(); }
}

function money($num = 0){
	return number_format($num,0,'.',',');
}

function GetDbVersion() {
	$ci=& get_instance();
	$ci->load->database(); 	
	$strSql  = "SELECT VERSION() dbVersion";
	$query = $ci->db->query($strSql)->row_array();
    return $query['dbVersion'];
}

function get_class_method($array = false){
	$route = get_instance()->router;
	if($array){
		return array('class' => $route->class, 'method' => $route->method);
	}else{
		return $route->class.'_'.$route->method;
	}
}
function is_class_method($class = false, $method = false){
	$route = get_instance()->router;
	return $route->class == $class && $route->method == $method;
}
function is_current_class($class = false){
	$route = get_instance()->router;
	return $route->class == $class;
}


function string_type($value){
	// remove spaces
	$value = str_replace(array(' ','-','_','.',','),'',$value);
	//
  $check = filter_var($value,FILTER_VALIDATE_EMAIL);
  if($check) return 'email';
  $check = ctype_digit($value);
  if($check) return 'number';
	$check = ctype_alpha($value);
	if($check) return 'char';
	return 'varchar';
}

// check and echoing (if true) an object property or a string variable
function _echo($obj, $prop = false, $echo = false){
	$any = '';

	if(is_string($obj) && !empty(trim($obj))){
		if(!$echo){ return $obj;
		}else{ echo $obj; return; }
	}

	if( (is_object($obj) && $prop) && property_exists($obj,$prop)){
		$any = !empty(trim($obj->$prop)) ? $obj->$prop : '';
		if(! $echo){ return $any;
		}else{ echo $any; return;	}
	}

	if(! $echo) return $any;
	echo $any;
}

function keyval($arr, $keyname = 'id', $valname = 'name', $switch = false)
{
	$new_arr = false;
	if(is_array($arr) && count($arr))
	{
		foreach ($arr as $key => $value) {
			if(isset($value->$keyname))
			{
				if(! $switch)
				{
					$new_arr[trim($value->$keyname)] = trim($value->$valname);
				}else{
					$new_arr[trim($value->$valname)] = trim($value->$keyname);
				}
			}else{
				if(! $switch)
				{
					$new_arr[trim($value[$keyname])] = isset($value[$valname]) ? trim($value[$valname]) : false;
				}else{
					$new_arr[trim($value[$valname])] = isset($value[$keyname]) ? trim($value[$keyname]) : false;
				}
			}
		}
	}
	return $new_arr;
}

function is_for($recs){
	return (bool) (is_array($recs) && count($recs));
}

function cleanstr($str){
	return str_replace(array('↵',"\t","\r\n","\n"),'', $str);
}

function dbnow($show_time = true)
{
	$format = 'Y-m-d';
	if($show_time) $format .= ' H:i:s';
	return date($format, time());
}

function jsout($param = false)
{
	$ci =& get_instance();
	header('Access-Control-Allow-Headers: Content-Type');
	header('Access-Control-Allow-Origin: http://localhost:9080');
	header('Content-type: application/json');
	$token_name = $ci->security->get_csrf_token_name();
  	$token_hash = $ci->security->get_csrf_hash();
	$param['csrf'] = array($token_name=>$token_hash);
	if($param === false){
		$param['result'] = false;
		$param['success'] = false;
	}
	$param['success'] = isset($param['success']) ? $param['success'] : false;
	exit( json_encode( $param ) );
}

function indonesian_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen ','Sel ','Rab ','Kam ','Jum ','Sab ','Min ',
        'Senin ','Selasa ','Rabu ','Kamis ','Jumat ','Sabtu ','Minggu ',
        'Jan ','Feb ','Mar ','Apr ','Mei ','Jun ','Jul ','Ags ','Sep ','Okt ','Nov ','Des ',
        'Januari ','Februari ','Maret ','April ','Juni ','Juli ','Agustus ','September ',
        'Oktober ','November ','Desember ',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
}

function tanggal($timestamp = '', $date_format = 'l, j F Y', $suffix = 'WIB') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen ','Sel ','Rab ','Kam ','Jum ','Sab ','Min ',
        'Senin ','Selasa ','Rabu ','Kamis ','Jumat ','Sabtu ','Minggu ',
        'Jan ','Feb ','Mar ','Apr ','Mei ','Jun ','Jul ','Ags ','Sep ','Okt ','Nov ','Des ',
        'Januari ','Februari ','Maret ','April ','Juni ','Juli ','Agustus ','September ',
        'Oktober ','November ','Desember ',
    );
    $date = date ($date_format, $timestamp);
    $date = "{$date}";
    return $date;
}

function tgl_singkat($timestamp = '', $date_format = 'd/m/Y', $suffix = 'WIB') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen ','Sel ','Rab ','Kam ','Jum ','Sab ','Min ',
        'Senin ','Selasa ','Rabu ','Kamis ','Jumat ','Sabtu ','Minggu ',
        'Jan ','Feb ','Mar ','Apr ','Mei ','Jun ','Jul ','Ags ','Sep ','Okt ','Nov ','Des ',
        'Januari ','Februari ','Maret ','April ','Juni ','Juli ','Agustus ','September ',
        'Oktober ','November ','Desember ',
    );
    $date = date ($date_format, $timestamp);
    $date = "{$date}";
    return $date;
}


if ( ! function_exists('ci_form_dropdown'))
{
	function ci_form_dropdown($name = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}

if ( ! function_exists('button'))
{
	function button($uri = '', $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
		}
		else
		{
			$site_url = site_url($uri);
		}

		if ($title == '')
		{
			$title = $site_url;
		}

		if ($attributes != '')
		{
			$attributes = _parse_attributes($attributes);
		}

		return '<button href="'.$site_url.'"'.$attributes.'>'.$title.'</button>';
	}
}
