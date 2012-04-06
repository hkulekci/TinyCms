<?php

/*

Sayfa içerisindeki değişkenler 

	$MetaTitle	// Sayfanın meta bilgilerinin düzenlendiği ve aktarıldığı değişken.
	$siteUrl	// Sitenin base adresi
	$CMSCategoryMenu 	// sol menü. 
	$CMSContents	// değişken içerik için oluşturulmuştur. Her sayfanın içeriği bu değişken vasıtasıyla ekranda gösterilir.


	include("core/include.php");

	mysql_close($con);

*/



?>

<?php include("core/include.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $MetaTitle;?>

<link href="<?php echo $siteUrl;?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $siteUrl;?>js/jquery.js"></script> 

<meta name="Copyright" content="(c) 2010 kulekci.net" />
<meta name="Rating" content="General" />
<meta name="Robots" content="index,follow" />
<meta name="Author" content="kulekci.net" />
<meta name="Classification" content="cms, site" />
<meta name="Distribution" content="Global" />
<meta name="Resource-type" content="Document" />
<meta http-equiv="Reply-to" content="bilgi@cms" />

<script type="text/javascript">
	var siteUrl = '<?php echo $siteUrl;?>';
</script>
	
</head>
<body>
	<div id="header">
	Example Site
	</div>
	<div id="menu">
	  <?php echo $CMSCategoryMenu ?>
	
	</div>
	
	<div id="content">
	  <?php echo $CMSContents ?>
	</div>

	<div id="footer"></div>

</body>
</html>
<?php mysql_close($con); ?>