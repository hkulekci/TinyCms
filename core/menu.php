<?
function get_sub_category($id="0"){
	global $siteUrl;
	$con = "";
	$ul_class = "ul_submenu";
	$li_class_ = "li_owner";
	$qq = mysql_query("SELECT*FROM `categories` WHERE `Parent`='".$id."' ORDER BY `Order` ASC;");
	if(mysql_num_rows($qq)==0)
		return;
	if ($id == "0"){
		$ul_class = "ul_menu";
	}
	$con .= "<ul class=\"".$ul_class."\">";
	$con .= "<li".(($k==0)?(""):(" class=\"".$li_class."\""))."><a href=\"".$siteUrl."\">Home Page</a>";
		while($t = mysql_fetch_array($qq)){
			$k = mysql_num_rows(mysql_query("SELECT*FROM `categories` WHERE `PARENT`='".$t["ID"]."';"));
			$con .= "<li".(($k==0)?(""):(" class=\"".$li_class."\""))."><a href=\"".$siteUrl."content/".$t["URL_TIPI"].".html\">".$t["Category"]."</a>";
			$con .= get_sub_category($t["Id"]);
			$con .= "</li>";
		}
	$con .= "</ul>";
	return $con;
}

?>
