<?php
/**
*	veritabanına kayıtlı settings tablosundaki verileri geri döndürüyor.
*	Bu sayede bazı verileri yapabileceğimiz web arayüzünden değiştirebiliriz.
*
*/
function get_setting($get){
	$q = mysql_query("SELECT*FROM `settings` WHERE `Define`='".sqlcleaner($get)."';");
	if (mysql_num_rows($q)==0)
		return false;
	$t = mysql_fetch_array($q);
	return $t["Value"];
}

$siteTitle = get_setting("SITE_TITLE");
$siteUrl = get_setting("SITE_URL");
$siiteImagesPath = get_setting("GORSEL_URL");
$siteInfo = get_setting("SITE_ACIKLAMA");
$siteMetaTags = get_setting("ANAHTAR_KELIMELER");


?>
