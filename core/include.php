<?php
//include.php
include_once("constants.php");
include_once("errormessages.php");
include_once("func.php");
include_once("connect.php");
include_once("settings.php");

include_once("db_funcs.php");

include_once("seo.php");

//opsiyonel//
include_once("menu.php");

$MetaTitle = meta_title_info($contenID);
$CMSContent = get_content_end($contenID,$contentType);
$CMSCategoryMenu = get_sub_category();

?>
