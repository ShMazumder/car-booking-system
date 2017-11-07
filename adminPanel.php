<?php
	session_start();

	include("header.php");
	getHeader("Wypożyczalnia samochodów - Panel Administracyjny", "mainCss.css;adminPanel.css");
	require("adminPanel/displayInfo.php");

	include("adminPanel/menu.php");


	if(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true)
	{
		include('adminPanel/layout.php');

		if(isset($_GET['subpage']))
			include("adminPanel/adminPanel".$_GET['subpage'].".php");
		else
			include("adminPanel/adminPanelHome.php");
	}
	else
	{
		include("adminPanel/adminPanelLogin.php");
	}

	include("footer.php");
?>
