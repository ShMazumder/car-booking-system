<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Klienci - osoby</h3>
			</div>';
		echo '<a href="adminPanel.php?subpage=ClientsPeople&action=add" class="btn btn-default action-btn">Dodaj klienta</a>
			<hr/>';

		displayClientsPeople();
	}
	else if($_GET['action'] == "add")
	{

		echo '<div class="page-header">
			<h3>Dodawanie klienta - osoba</h3>
			</div>';
		echo '
			<form method="POST" action="adminPanel/action.php?subpage=ClientsPeople&action=add" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Imię: </label>
					<input type="text" class="form-control" id="name_input" name="name">
				</div>
				<div class="form-group">
					<label for="surname_input" class="tytul_input">Nazwisko: </label>
					<input type="text" class="form-control" id="surname_input" name="surname">
				</div>
				<div class="form-group">
					<label for="pesel_input" class="tytul_input">PESEL: </label>
					<input type="text" class="form-control" id="pesel_input" name="pesel">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="ident_card_input">Nr. dowodu osobistego: </label>
					<input type="text" class="form-control" id="ident_card_input" name="ident_card">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="driving_licence_input">Nr. prawa jazdy: </label>
					<input type="text" class="form-control" id="driving_licence_input" name="driving_licence">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="phone_input">Telefon: </label>
					<input type="text" class="form-control" id="phone_input" name="phone">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="country_input">Kraj: </label>
					<input type="text" class="form-control" id="country_input" name="country">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="city_input">Miasto: </label>
					<input type="text" class="form-control" id="city_input" name="city">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="address_input">Adres: </label>
					<input type="text" class="form-control" id="address_input" name="address">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="postcode_input">Kod pocztowy: </label>
					<input type="text" class="form-control" id="postcode_input" name="postcode">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="email_input">E-mail: </label>
					<input type="text" class="form-control" id="email_input" name="email">
				</div>
			</div>

		    <div class="clearfix visible-lg-block"></div>
		    <div class="col-lg-8 col-md-12 col-sm-8 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=ClientsPeople" class="btn btn-default">Anuluj</a>
				</div>
			</div>
			</form>
			
		<div class="error_div">';	    
		if(isset($_SESSION['error']))
		{
			echo '<p class="error">'.$_SESSION['error'].'</p>';
			unset($_SESSION['error']);
		}
		echo '</div>';
	}
	else if($_GET['action'] == "info" && isset($_GET['id']))
	{
		$client = getClientPeople($_GET['id']);

		echo '<div class="page-header">
			<h3>Informacje o kliencie - osoba</h3>
			</div>';
		echo '
			<form method="POST" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Imię: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$client['name'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="surname_input" class="tytul_input">Nazwisko: </label>
					<input type="text" class="form-control" id="surname_input" name="surname" value="'.$client['surname'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="pesel_input" class="tytul_input">PESEL: </label>
					<input type="text" class="form-control" id="pesel_input" name="pesel" value="'.$client['pesel'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="ident_card_input">Nr. dowodu osobistego: </label>
					<input type="text" class="form-control" id="ident_card_input" name="ident_card" value="'.$client['ident_card'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="driving_licence_input">Nr. prawa jazdy: </label>
					<input type="text" class="form-control" id="driving_license_input" name="driving_licence" value="'.$client['driving_licence'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="phone_input">Telefon: </label>
					<input type="text" class="form-control" id="phone_input" name="phone" value="'.$client['phone'].'" readOnly>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="country_input">Kraj: </label>
					<input type="text" class="form-control" id="country_input" name="country" value="'.$client['country'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="city_input">Miasto: </label>
					<input type="text" class="form-control" id="city_input" name="city" value="'.$client['city'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="address_input">Adres: </label>
					<input type="text" class="form-control" id="address_input" name="address" value="'.$client['address'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="postcode_input">Kod pocztowy: </label>
					<input type="text" class="form-control" id="postcode_input" name="postcode" value="'.$client['postcode'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="email_input">E-mail: </label>
					<input type="text" class="form-control" id="email_input" name="email" value="'.$client['email'].'" readOnly>
				</div>
			</div>

			<div class="clearfix visible-lg-block"></div>
		    <div class="col-lg-8 col-md-12 col-sm-8 col-xs-12">
			    <div class="text-right">
					<a class="btn btn-default" href="adminPanel.php?subpage=ClientsPeople&action=edit&id='.$_GET['id'].'">Edytuj</a>
				</div>
			</div>
			</form>';

		echo '<hr/><h3>Rezerwacje</h3>';

		displayClientReservations($_GET['id'], 1);

		echo '</div>
			</div>';
	}
	else if($_GET['action'] == "edit" && isset($_GET['id']))
	{

		$client = getClientPeople($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie klienta - osoba</h3>
			</div>';
		echo '
			<form method="POST" action="adminPanel/action.php?subpage=ClientsPeople&action=edit&id='.$_GET['id'].'" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Imię: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$client['name'].'">
				</div>
				<div class="form-group">
					<label for="surname_input" class="tytul_input">Nazwisko: </label>
					<input type="text" class="form-control" id="surname_input" name="surname" value="'.$client['surname'].'">
				</div>
				<div class="form-group">
					<label for="pesel_input" class="tytul_input">PESEL: </label>
					<input type="text" class="form-control" id="pesel_input" name="pesel" value="'.$client['pesel'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="ident_card_input">Nr. dowodu osobistego: </label>
					<input type="text" class="form-control" id="ident_card_input" name="ident_card" value="'.$client['ident_card'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="driving_licence_input">Nr. prawa jazdy: </label>
					<input type="text" class="form-control" id="driving_license_input" name="driving_licence" value="'.$client['driving_licence'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="phone_input">Telefon: </label>
					<input type="text" class="form-control" id="phone_input" name="phone" value="'.$client['phone'].'">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="country_input">Kraj: </label>
					<input type="text" class="form-control" id="country_input" name="country" value="'.$client['country'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="city_input">Miasto: </label>
					<input type="text" class="form-control" id="city_input" name="city" value="'.$client['city'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="address_input">Adres: </label>
					<input type="text" class="form-control" id="address_input" name="address" value="'.$client['address'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="postcode_input">Kod pocztowy: </label>
					<input type="text" class="form-control" id="postcode_input" name="postcode" value="'.$client['postcode'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="email_input">E-mail: </label>
					<input type="text" class="form-control" id="email_input" name="email" value="'.$client['email'].'">
				</div>
			</div>
			
			<div class="clearfix visible-lg-block"></div>
		    <div class="col-lg-8 col-md-12 col-sm-8 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=ClientsPeople" class="btn btn-default">Anuluj</a>
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