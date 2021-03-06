<?php

/*
	Config file ./constants.php

	Araştırılması gereken bazı konular:
		mysql_connect, mysql_select_db, mysql_query, define(), include()

	errormessage() fonksiyonu ./errormessages.php dosyasından çekiliyor. 
	Hata mesajlarını bir standart'a oturtmak için bu şekilde düşünüldü.
	

*/

$con = mysql_connect(_DB_LOCALHOST,_DB_USERNAME,_DB_PASSWORD);
if (!$con){
	echo errormessage("Error : Server Connention.",_DB_HATAMESAJI);
	exit();
}
$db = mysql_select_db(_DB_DATABASENAME,$con);
if (!$db){
	echo errormessage("Error : Database Table.",_DB_HATAMESAJI);
	exit();
}

// Veritabanına kayıt ederken utf8, latin5, ... vs. 
//	encoding hatalarını bertaraf etmek için kullandık.
$lang = mysql_query("SET NAMES 'utf8'",$con);
if (!$lang){
	echo errormessage("Error : Character Set!",_DB_HATAMESAJI);
	exit();
}
?>