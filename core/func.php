<?php

//@header("Content-Type: text/html;charset=utf-8");
//******* General Functions *******//
define("_OCAK","Ocak");
define("_SUBAT","Şubat");
define("_MART","Mart");
define("_NISAN","Nisan");
define("_MAYIS","Mayıs");
define("_HAZIRAN","Haziran");
define("_TEMMUZ","Temmuz");
define("_AGUSTOS","Ağustos");
define("_EYLUL","Eylül");
define("_EKIM","Ekim");
define("_KASIM","Kasım");
define("_ARALIK","Aralık");
function transdate($coming,$turu = "kisa"){
	$datearray = array (
		"00" => "00",
		"01" => _OCAK,
		"02" => _SUBAT,
		"03" => _MART,
		"04" => _NISAN,
		"05" => _MAYIS,
		"06" => _HAZIRAN,
		"07" => _TEMMUZ,
		"08" => _AGUSTOS,
		"09" => _EYLUL,
		"10" => _EKIM,
		"11" => _KASIM,
		"12" => _ARALIK
	);
	if (!ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $coming, $regs)) {
	   return "Invalid date format: $coming";
	}
	if ($coming == "0000-00-00 00:00:00")//2008-07-04 00:00:00
		return $coming;
	$truncate = explode(" ",$coming);
	$date = explode("-",$truncate[0]);
	$time = $truncate[1];// buradaki style css dosyasına alınacak
	//session_start();
	return $date[2]." ".$datearray[$date[1]]." ".$date[0].(($turu=="uzun")?(" - ".$time.""):(""));
}
function convert_url($gelen){
	$degistir = array("!","'","^","#","+","%","&","/","{","}","[","]","(",")","=","?","*","\\","-"," - " ,"_","é","\"","~","š","`","Z",",",";",".",":","|","<",">","? ","?"," ? ","ö","ü","ç","ş"," ","?","ı");
	$bunlarla = array("","","","","","","","","","","","","","","","","","","" ,"","","","","","","","","","","","","","","","","","","o","u","c","s","-","g","i");
	
	return str_replace($degistir, $bunlarla, strtolower($gelen));
}



function utf8_urldecode($str) {
	$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	return html_entity_decode($str,null,'UTF-8');
}

function unhtmlentities($string)
{
	// to replace htmlentity character
    // replace numeric entities
    $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
    $string = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $string);
    // replace literal entities
    $trans_tbl = get_html_translation_table(HTML_ENTITIES);
    $trans_tbl = array_flip($trans_tbl);
    return strtr($string, $trans_tbl);
}


function un_escape($string)
{
	$string = preg_replace("/%u0130/", "İ", $string);
	$string = preg_replace("/%u0131/", "ı", $string);
	$string = preg_replace("/%u011F/", "ğ", $string);
	$string = preg_replace("/%u011E/", "Ğ", $string);
	$string = preg_replace("/%u015F/", "ş", $string);
	$string = preg_replace("/%u015E/", "Ş", $string);
	
	$string = preg_replace("/%F6/", "ö", $string);
	$string = preg_replace("/%FC/", "ü", $string);
	$string = preg_replace("/%E7/", "ç", $string);
	//$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
	$string = str_replace("%u015F","ö",$string);
	$string = str_replace("&ouml;","ş",$string);
	$string = str_replace("&euro;","€",$string);
	$string = str_replace("&frac12;","½",$string);
	$string = str_replace("&pound;","£",$string);
	$string = str_replace("&aelig;","æ",$string);
	$string = str_replace("&szlig;","ß",$string);
	$string = str_replace("&uuml;","ü",$string);

	$string = str_replace("&gt;",">",$string);
	$string = str_replace("&lt;","<",$string);

	$string = str_replace("&amp;","&",$string);
	$string = str_replace("&ccedil;","ç",$string);

	return $string;
}

function cut_string($string, $length_t, $tags="disable"){
	/*
	* @string -> text
	* @length_t -> length of text
	* @tags['enable','disable'] -> strip_tags is enable/disable
	*/
	$length=strlen($string);
	$string = substr(strip_tags($string),0,$length_t);
	return $string.(($length_t >= $length)?(""):("[...]"));
}


function cut_string_word($string,$num){
	$string = strip_tags($string);
	$stringa = explode(" ",$string);
	if (sizeof($stringa)>$num){
		$con = "";
		for($i=0;$i<$num;$i++){
			$con .= $stringa[$i]." ";
		}
		return $con." [...]";
	}else{
		return $string;
	}
}

//********** SQL Fonksiyonları *************//

function turkish_sql(){
	return @mysql_query("SET NAMES latin5");
}

function sqlcleaner($id){
	//echo sqlcleaner("deemmkdksndkf''323r2fw e ?/? / \ aasdaas+^%% ? *");
	$id = get_magic_quotes_gpc() ? stripslashes($id) : $id;
	$id= function_exists("mysql_real_escape_string") ? mysql_real_escape_string($id) : mysql_escape_string($id);
	return $id;
}




function insert_sql($tablename,$fields){
	//insert_sql("access","isim#soyad#tel","haydar","kulekci","5435895455");
	 $numargs = func_num_args();
	 $fields = explode("#",$fields);
	 $con = "";
	 if (count($fields)==$numargs-3){
		 for ($i=2;$i<$numargs;$i++)
			$con .= "'".transsql(func_get_arg($i))."',";
		 return "INSERT INTO `".sqlcleaner($tablename)."` (`".implode("`,`,",$fields)."`) VALUES (".substr($con,0,-1).");";
	 }else
		 return false;
}

function edit_sql($tablename,$where,$fields){
	 $numargs = func_num_args();
	 $fields = explode("#",$fields);
	 $where = explode("#",$where);
	 if (count($fields)==$numargs-3){
		 $con = "";
		 for ($i=3;$i<$numargs;$i++){
			 $con .= "`".$fields[$i-3]."`='".sqlcleaner(func_get_arg($i))."',";
		 }
		 return "UPDATE SET `".sqlcleaner($tablename)."` ".substr($con,0,-1)." WHERE `".$where[0]."`=".$where[1].";";
	 }else{
		return false;
	 }
}


// Other Functions //


function CreateHTMLName2($name) {
  $replace_values = array(" ", "'", "\"", "\\", "/", "?", "|", "@", "#", "~", "!", "£", "$", "%", "^", "&", "*", "(", ")", "[", "]", "{", "}", "+", "=", "-");
  $name = str_replace($replace_values, "_", $name);
  $name = str_replace(".", "", $name);
  $name = str_replace(",", "", $name);
  return strtolower($name);
}


function CreateHTMLName($bilgi,$tip = 0)
{
	//tip | 1: kucuk harf, 0: orijinal
	$degistir = array("ı","ğ","ü","ş","ç","ö","Ğ","Ü","İ","Ş","Ç","Ö","é","â","à","ê","ë","è","ï","î","É","ô","û","ù","á","í","ó","ú","é","ñ","í","ä","Ä","ß","-"," ","â");
	$bunlarla = array("i","g","u","s","c","o","G","U","I","S","C","O","e","a","a","e","e","e","i","i","E","o","u","u","a","i","o","u","e","n","i","a","A","B","_","-","a");
	$bilgi = str_replace($degistir,$bunlarla,$bilgi);
	$sonuc = preg_replace("/[^A-Za-z0-9_)(-]+/i","",$bilgi);
	if($tip == 1)
		return str_replace("I","i",strtolower(trim($sonuc)));
	if($tip == 0)
		return $sonuc;
}



function count_photos($folder) {
  global $storage_location;
  $dir_handle = @opendir($storage_location.$folder);
  $total = 0;
  while ($file = readdir($dir_handle)) {
	  if(($file != ".") && ($file != "..")) {
	    $exp   = explode(".", $file);
		$where = COUNT($exp)-1;
		$ext   = $exp[$where];
		if(($ext == "jpg") || ($ext == "jpeg") || ($ext == "pjpg") || ($ext == "png") || ($ext == "gif")) $total++;
	  }
  }
  closedir($dir_handle);
  return $total;
}

function getelement($gelen){
	if (sizeof($_POST[$gelen])!=0){
		return $_POST[$gelen];
	}else if (sizeof($_GET[$gelen])!=0){
		return $_GET[$gelen];
	}else{
		return errormessage("Form Sending Error!",5);
	}
}

?>