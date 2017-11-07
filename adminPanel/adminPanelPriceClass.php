<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Klasy cenowe</h3>
			</div>';
		echo '<a href="adminPanel.php?subpage=PriceClass&action=add" class="btn btn-default action-btn">Dodaj klasę cenową</a>
			<hr/>';

		displayPriceClass();
	}
	else if($_GET['action'] == "add")
	{
		echo '<div class="page-header">
			<h3>Dodawanie klasy cenowej</h3>
			</div>';
		echo '
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" action="adminPanel/action.php?subpage=PriceClass&action=add" autocomplete="off">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name">
				</div>
				<div class="form-group">
					<label for="five_input" class="tytul_input">Do 5 dni (zł): </label>
					<input type="text" class="form-control" id="five_input" name="five">
				</div>
				<div class="form-group">
					<label for="ten_input" class="tytul_input">Do 10 dni (zł): </label>
					<input type="text" class="form-control" id="ten_input" name="ten">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="fifteen_input">Do 15 dni (zł): </label>
					<input type="text" class="form-control" id="fifteen_input" name="fifteen">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="bail_input">Kaucja: </label>
					<input type="text" class="form-control" id="bail_input" name="bail">
				</div>
			    
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=PriceClass" class="btn btn-default">Anuluj</a>
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
	else if($_GET['action'] == "info" && isset($_GET['id']))
	{
		$priceClass = getPriceClass($_GET['id']);

		echo '<div class="page-header">
			<h3>Informacje o klasie cenowej</h3>
			</div>';
		echo '
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" autocomplete="off">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$priceClass['name'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="five_input" class="tytul_input">Do 5 dni (zł): </label>
					<input type="text" class="form-control" id="five_input" name="five" value="'.$priceClass['five'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="ten_input" class="tytul_input">Do 10 dni (zł): </label>
					<input type="text" class="form-control" id="ten_input" name="ten" value="'.$priceClass['ten'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="fifteen_input">Do 15 dni (zł): </label>
					<input type="text" class="form-control" id="fifteen_input" name="fifteen" value="'.$priceClass['fifteen'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="bail_input">Kaucja: </label>
					<input type="text" class="form-control" id="bail_input" name="bail" value="'.$priceClass['bail'].'" readOnly>
				</div>
			    
			    <div class="text-right">
					<a href="adminPanel.php?subpage=PriceClass&action=edit&id='.$_GET['id'].'" class="btn btn-default">Edytuj</a>
				</div>
			</form>
		</div>';
	}
	else if($_GET['action'] == "edit" && isset($_GET['id']))
	{

		$priceClass = getPriceClass($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie klasy cenowej</h3>
			</div>';
		echo '
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" action="adminPanel/action.php?subpage=PriceClass&action=edit&id='.$_GET['id'].'" autocomplete="off">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$priceClass['name'].'">
				</div>
				<div class="form-group">
					<label for="five_input" class="tytul_input">Do 5 dni (zł): </label>
					<input type="text" class="form-control" id="five_input" name="five" value="'.$priceClass['five'].'">
				</div>
				<div class="form-group">
					<label for="ten_input" class="tytul_input">Do 10 dni (zł): </label>
					<input type="text" class="form-control" id="ten_input" name="ten" value="'.$priceClass['ten'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="fifteen_input">Do 15 dni (zł): </label>
					<input type="text" class="form-control" id="fifteen_input" name="fifteen" value="'.$priceClass['fifteen'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="bail_input">Kaucja: </label>
					<input type="text" class="form-control" id="bail_input" name="bail" value="'.$priceClass['bail'].'">
				</div>
			    
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=PriceClass" class="btn btn-default">Anuluj</a>
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