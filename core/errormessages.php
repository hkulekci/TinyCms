<?php
function errormessage($con,$turu="0"){
	return '<div class="errormessage_'.$turu.'">'.$con.'</div>';
}

function infomessage($con,$turu="0"){
	return '<div class="infomessage_'.$turu.'">'.$con.'</div>';
}

?>
