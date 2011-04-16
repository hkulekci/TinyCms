<?php
function get_info($table,$url,$info){
	$qq = mysql_query("SELECT `".sqlcleaner($info)."` FROM `".sqlcleaner($table)."` WHERE `Url`='".sqlcleaner($url)."';");
	$t = mysql_fetch_array($qq);
	return $t[$info];
}

function content_changing($icerik){
	global $siteUrl;
	// bu fonskiyon sonuc olarak {{SITE_URL}} gibi ?eyleri de?i?tiriyor
	$icerik = str_replace("{{SITE_URL}}",$siteUrl,$icerik);
	return $icerik;
}

function get_content($urlTipi){
	global $siteUrl;
	$qq = mysql_query("SELECT Online,Content_Type,Content,Id,Hit FROM `contents` WHERE `Url`='".sqlcleaner($urlTipi)."';");
	if (mysql_num_rows($qq)==0){
		return "";
	}
	$t = mysql_fetch_array($qq);
	if ($t["Online"]=="0"){
		$con = "";
	}else{
		if ($t["Content_Type"]=="application"){
			$con = file_get_contents($siteUrl.(strip_tags($t["Content"])));
		}else{
			$con = content_changing($t["Content"]);
		}
		$qq_hit = mysql_query("UPDATE `contents` SET `Hit`='".($t["Hit"]+1)."' WHERE `Id`='".$t["Id"]."'");
	}
	return $con;
}

function get_category_content($urlTipi){
	$con = content_accordingto_category_with_image(get_info("categories",$urlTipi,"Id"))."<br><br>";
	return $con;
}

function get_content_end($urlTipi, $turu="content"){
	if ($turu=="content"){
		$con = "<h1>".get_info("categories",$urlTipi,"Category")."</h1>\n";
		$con .= get_category_content($urlTipi)."\n";
	}else{
		$con = "<h1>".get_info("contents",$urlTipi,"Title")."</h1>\n";
		$con .= get_content($urlTipi)."\n";
	}
	return $con;
}

function meta_title_info($urlType=""){
	global $siteTitle;
	global $siteMetaTags;
	global $siteInfo;
	$qq = mysql_query("SELECT*FROM `contents` WHERE `Url`='".sqlcleaner($urlType)."';");
	$con = "";
	$con .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset="._PAGE_CHARSET."\" />\n";
	if (($urlType=="")||(mysql_num_rows($qq)==0)){
		$con .= "<title>".$siteTitle."</title>\n";
		$con .= "<meta name=\"description\" content=\"".$siteInfo."\" />\n";
		$con .= "<meta name=\"keywords\" content=\"".$siteMetaTags."\" />\n";
	}else{
		while ($result=mysql_fetch_array($qq)){
			$con .= "<title>".((trim($sonuc["BASLIK"])!="")?($result["Title"]." - "):("")).$siteTitle."</title>\n";
			$con .= "<meta name=\"description\" content=\"".$result["Title"]."\" />\n";
			$con .= "<meta name=\"keywords\" content=\"".$result["Tags"]."\" />\n\r";
			
		}
	}
	return $con;
	
}




/***********************

other functions from CMS 

************************/


function get_category_id($url){
	return get_info("categories",$url,"Id");
}


function get_category_contents_id($url){
	$qq = mysql_query("SELECT `Id` FROM `categories`,`contents` WHERE `categories`.`Url`='".sqlcleaner($url)."' AND `contents`.`Category`=`categories`.`Id`");
	$i = 0;
	while($t = mysql_fetch_array($qq)){
		$array[$i] = $t["Id"];
	}
	return $array;
}


function content_short_info_with_images($resim_kat,$id,$baslik){//urun_kisa_bilgi($resim_kat,$id,$baslik){
	global $siteUrl;
	$con = "";
	$resimlerA = explode("|",$resim_kat);
	$resimler = (($resimlerA[1]=="")?($resimlerA[0]):($resimlerA[1]));
	$resimlerB = explode(",",$resimler);
	$con .= '<a href="javascript:void(0)" onclick="getHTML(\'post\',\'../icerik/urunler.php\',\'sayfa=urun&id='.$id.'\',\'basicModalContent\');$(\'#basicModalContent\').modal();" class="basic">';
	if (trim($resimlerB[0])!=""){ 
		$tf = mysql_fetch_array(mysql_query("SELECT*FROM `images` WHERE `Id`='".$resimlerB[0]."'"));
		$con .= '<div align="center" style="background-image:url(\''.$siteUrl."userfiles/image/"."small_".$tf["SOURCE"].'\');" class="urun_resmi"></div>';
	}else{
		$con .= '<div align="center" class="urun_resmi"></div>';
	}
	$con .= '<br>'.$baslik.'<br>';
	$con .= '</a>';
	return  $con;
}


function content_accordingto_category_with_image($id){
	global $siteUrl;
	define("_KACTANEBIRSIRADA",5);
	$con = '<!-- Import jQuery and SimpleModal source files-->';
	$con .= '<!--[if !IE 6]><!-->';
	$con .= '<script src="'.$siteUrl.'icerik/Scripts/js/jquery.js" type="text/javascript"></script>';
	$con .= '<!--<![endif]-->';
	$con .= '<script src="'.$siteUrl.'icerik/Scripts/js/jquery.simplemodal.js" type="text/javascript"></script>';

	$con .= '<!-- Contact Form JS and CSS files -->';
	$con .= '<link type="text/css" href="'.$siteUrl.'icerik/Scripts/css/basic.css" rel="stylesheet" media="screen" />';

	$con .= '<!-- IE 6 hacks -->';
	$con .= '<!--[if lt IE 7]>';
	$con .= '<link type="text/css" href="'.$siteUrl.'css/basic_ie.css" rel="stylesheet" media="screen" />';
	$con .= '<![endif]-->';
	$con .= '<script type="text/javascript">';
	$con .= 'function getHTML(methodcum, urle, pars, katman){';
	$con .= '	$.ajaxSetup({';
	$con .= '		global: false,';
	$con .= '		type: methodcum,';
	$con .= '		url: urle,';
	$con .= '		cache: false ';
	$con .= '	});';
	$con .= '	$.ajax({';
	$con .= '		data: pars,';
	$con .= '		success: function(ajaxCevap) {$(\'#\'+katman).html(ajaxCevap);}';
	$con .= '	}); ';
	$con .= '}';
	$con .= '</script>';
	$con .= '<div id="basicModalContent" style=\'display:none;\'>Sayfa Yükleniyor...</div>';
	$con .= '<table celpadding="0" cellspacing="0">';
	$urunlerQuery = mysql_query("SELECT * FROM `contents` WHERE contents.Category = '".sqlcleaner($id)."'");
	while($tt = mysql_fetch_array($urunlerQuery)){
		if ($i == 0) {$con .= '<tr>';}		
		$con .= '<td class="td_urunler_listesi">';
		$con .= content_short_info_with_images($tt["Image_Category"],$tt["Id"],$tt["Title"]);
		$con .= '</td>';
		if ($i == _KACTANEBIRSIRADA) {$con .= '</tr>';}
		$i++;
		if ($i == _KACTANEBIRSIRADA) {$i = 0;}
		
	}
	$con .= '</table>';
	$con .= '<a href="javascript:history.back(-1)">geri <img height="23" width="35" src="'.$siteUrl.'userfiles/image/devam.jpg" alt="" border=0/></a>';
	return $con;
}

?>