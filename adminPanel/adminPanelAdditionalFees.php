<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Dodatkowe opłaty</h3>
			</div>';
		echo '<a href="adminPanel.php?subpage=AdditionalFees&action=add" class="btn btn-default action-btn">Dodaj dodatkowe opłaty</a>
			<hr/>';

		displayAdditionalFees();
	}
	else if($_GET['action'] == "add")
	{
		echo '<div class="page-header">
			<h3>Dodawanie dodatkowych opłat</h3>
			</div>';
		echo '
			<form method="POST" action="adminPanel/action.php?subpage=AdditionalFees&action=add" autocomplete="off">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="price_input" class="tytul_input">Cena (zł): </label>
					<input type="text" class="form-control" id="price_input" name="price">
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=AdditionalFees" class="btn btn-default">Anuluj</a>
				</div>
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

		$additionalFee = getAdditionalFee($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie dodatkowych opłat</h3>
			</div>';
		echo '
			<form method="POST" action="adminPanel/action.php?subpage=AdditionalFees&action=edit&id='.$_GET['id'].'" autocomplete="off">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$additionalFee['name'].'">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="price_input" class="tytul_input">Cena (zł): </label>
					<input type="text" class="form-control" id="price_input" name="price" value="'.$additionalFee['price'].'">
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=AdditionalFees" class="btn btn-default">Anuluj</a>
				</div>
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