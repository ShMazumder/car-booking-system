<?php
	include("header.php");
	getHeader("Wypożyczalnia samochodów - Lista samochodów", "mainCss.css;subpageCar.css");
	include("menu.php");
	require("adminPanel/displayInfo.php");
	if(isset($_GET['id']) && $_GET['id'] != ""){
		printOneCarInfo($_GET['id']);
	}

	include("footer.php");
?>
