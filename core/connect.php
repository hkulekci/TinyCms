<?php
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
$lang = mysql_query("SET NAMES 'utf8'",$con);
if (!$lang){
	echo errormessage("Error : Character Set!",_DB_HATAMESAJI);
	exit();
}
?>