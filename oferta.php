<?php
	include("header.php");
	getHeader("Wypożyczalnia samochodów - Oferta Firmy", "mainCss.css;subpageOffer.css;range.css");
	include("menu.php");
	require("adminPanel/displayInfo.php");
	if(isset($_GET['type']))
	{
		include("oferta/".$_GET['type'].".php");
	}
	include("footer.php");
 ?>
