<?php
/**
  *
  *		Burada yapılan Url düzenlemeleri ile sitenin url'leri 
  *		"{BASE}/index.php?p=34" yerine seo uyumlu olan 
  * 	"{BASE}/index/page-title-or-whatever" şeklinde görünebilecek 
  *
  *
  */


$siteUrl_req = $siteUrl;

// URL'yi alıyoruz
$request_uri = $_SERVER['REQUEST_URI'];
$siteUrl_req = explode("/",$siteUrl_req);
$url = explode("/",$request_uri);
$i = 0;

foreach($url as $l){
	if (trim($l) == ""){ continue; }  
	if (in_array($l,$siteUrl_req)){ continue; }
	$seo_url[$i] = $l;
	$i++;
}

$seo_url_son = explode(".",$seo_url[0]);

if ($seo_url[0]=="style.css"){
	header('Content-type: text/css');
	echo file_get_contents($siteUrl."css/style.php");
	exit();
}


$_GET["type"] = $seo_url[0];
$_GET["id"] = $seo_url_son[0];

if (trim($_GET["id"])!=""){
		if(trim($_GET["type"])=="category"){
			if (trim(get_category_content($_GET["id"])) == ""){
				$_GET["id"] = "404";
				$_GET["type"] = "content";
			}
		}else{
			if (trim(get_content($_GET["id"])) == ""){
				$_GET["id"] = "404";
				$_GET["type"] = "content";
			}
		}
}

$contenID = ((trim($_GET["id"])=="")?("homepage"):($_GET["id"]));
$contentType = ((trim($_GET["type"])=="")?("content"):($_GET["type"]));

?>
