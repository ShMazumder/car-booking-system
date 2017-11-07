<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Lokacje</h3>
			</div>';
		echo '<a href="adminPanel.php?subpage=Locations&action=add" class="btn btn-default action-btn">Dodaj lokację</a>
			<hr/>';

		displayLocalizations();
	}
	else if($_GET['action'] == "add")
	{
		echo '<div class="page-header">
			<h3>Dodawanie lokacji</h3>
			</div>';
		echo '
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" action="adminPanel/action.php?subpage=Locations&action=add" autocomplete="off">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name">
				</div>
				<div class="form-group">
					<label for="city_input" class="tytul_input">Miasto: </label>
					<input type="text" class="form-control" id="city_input" name="city">
				</div>
				<div class="form-group">
					<label for="address_input" class="tytul_input">Adres: </label>
					<input type="text" class="form-control" id="address_input" name="address">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="postcode_input">Kod pocztowy: </label>
					<input type="text" class="form-control" id="postcode_input" name="postcode">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="type_input">Typ: </label>
					<input type="text" class="form-control" id="type_input" name="type">
				</div>
			    
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=Locations" class="btn btn-default">Anuluj</a>
				</div>
			</form>
			
		<div class="error_div">';	    
		if(isset($_SESSION['error']))
		{
			echo '<p class="error">'.$_SESSION['error'].'</p>';
			unset($_SESSION['error']);
		}
		echo '</div>
			</div>';
	}
	else if($_GET['action'] == "edit" && isset($_GET['id']))
	{

		$localization = getLocalization($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie lokacji</h3>
			</div>';
		echo '
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" action="adminPanel/action.php?subpage=Locations&action=edit&id='.$_GET['id'].'" autocomplete="off">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$localization['name'].'">
				</div>
				<div class="form-group">
					<label for="city_input" class="tytul_input">Miasto: </label>
					<input type="text" class="form-control" id="city_input" name="city" value="'.$localization['city'].'">
				</div>
				<div class="form-group">
					<label for="address_input" class="tytul_input">Adres: </label>
					<input type="text" class="form-control" id="address_input" name="address" value="'.$localization['address'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="postcode_input">Kod pocztowy: </label>
					<input type="text" class="form-control" id="postcode_input" name="postcode" value="'.$localization['postcode'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="type_input">Typ: </label>
					<input type="text" class="form-control" id="type_input" name="type" value="'.$localization['type'].'">
				</div>
			    
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=Locations" class="btn btn-default">Anuluj</a>
				</div>
			</form>
			
		<div class="error_div">';	    
		if(isset($_SESSION['error']))
		{
			echo '<p class="error">'.$_SESSION['error'].'</p>';
			unset($_SESSION['error']);
		}
		echo '</div>
			</div>';
	}

	echo '</div>
		</div>
		</div>
		</div>';

?>