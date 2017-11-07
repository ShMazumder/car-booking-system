<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Klienci - firmy</h3>
			</div>';
		echo '<a href="adminPanel.php?subpage=ClientsCompanies&action=add" class="btn btn-default action-btn">Dodaj klienta</a>
			<hr/>';

		displayClientsCompanies();
	}
	else if($_GET['action'] == "add")
	{
		echo '<div class="page-header">
			<h3>Dodawanie klienta - firma</h3>
			</div>';
		echo '
			<form method="POST" action="adminPanel/action.php?subpage=ClientsCompanies&action=add" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa firmy: </label>
					<input type="text" class="form-control" id="name_input" name="name">
				</div>
				<div class="form-group" id="drivers">
					<label for="login_input" class="tytul_input">Kierowca: </label>
					<div class="input-group">
						<select class="form-control drivers_select" id="id_driver_input" name="id_driver[]">
						<option selected></option>';
		displayOptionDrivers();

		echo '
						</select>
						<span class="input-group-btn">
							<a href="adminPanel.php?subpage=ClientsPeople&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></a>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="nip_input">NIP: </label>
					<input type="text" class="form-control" id="nip_input" name="nip">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="phone_input">Telefon: </label>
					<input type="text" class="form-control" id="phone_input" name="phone">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
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
					<label for="email_input" class="tytul_input">E-mail: </label>
					<input type="text" class="form-control" id="email_input" name="email">
				</div>
			</div>
			
			<div class="clearfix visible-lg-block"></div>
		    <div class="col-lg-8 col-md-12 col-sm-8 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=ClientsCompanies" class="btn btn-default">Anuluj</a>
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
	else if($_GET['action'] == "info" && isset($_GET['id']))
	{
		$client = getClientCompanies($_GET['id']);

		echo '<div class="page-header">
			<h3>Informacje o kliencie - firma</h3>
			</div>';
		echo '
			<form method="POST" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa firmy: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$client['name'].'" readOnly>
				</div>
				
				<div class="form-group">
					<label class="tytul_input" for="nip_input">NIP: </label>
					<input type="text" class="form-control" id="nip_input" name="nip" value="'.$client['nip'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="phone_input">Telefon: </label>
					<input type="text" class="form-control" id="phone_input" name="phone" value="'.$client['phone'].'" readOnly>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="city_input" class="tytul_input">Miasto: </label>
					<input type="text" class="form-control" id="city_input" name="city" value="'.$client['city'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="address_input" class="tytul_input">Adres: </label>
					<input type="text" class="form-control" id="address_input" name="address" value="'.$client['address'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="postcode_input">Kod pocztowy: </label>
					<input type="text" class="form-control" id="postcode_input" name="postcode" value="'.$client['postcode'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="email_input" class="tytul_input">E-mail: </label>
					<input type="text" class="form-control" id="email_input" name="email" value="'.$client['email'].'" readOnly>
				</div>
			</div>
			    
			<div class="clearfix visible-lg-block"></div>
		    <div class="col-lg-8 col-md-12 col-sm-8 col-xs-12">
			    <div class="text-right">
					<a href="adminPanel.php?subpage=ClientsCompanies&action=edit&id='.$_GET['id'].'" class="btn btn-default">Edytuj</a>
				</div>
			</div>
			</form>';

		echo '<hr/><h3>Kierowcy</h3>';

		displayCompanyDrivers($_GET['id']);

		echo '<hr/><h3>Rezerwacje</h3>';

		displayClientReservations($_GET['id'], 2);


		echo '</div>
			</div>';
	}
	else if($_GET['action'] == "edit" && isset($_GET['id']))
	{

		$client = getClientCompanies($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie klienta - firma</h3>
			</div>';
		echo '
			<form method="POST" action="adminPanel/action.php?subpage=ClientsCompanies&action=edit&id='.$_GET['id'].'" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa firmy: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$client['name'].'">
				</div>
				<div class="form-group" id="drivers">
					<label for="login_input" class="tytul_input">Kierowca: </label>
					<div class="input-group">
						<select class="form-control" id="id_driver_input" name="id_driver[]">';

		$company_drivers = getCompanyDrivers($_GET['id']);
		displayOptionDrivers($company_drivers[0]['id']);

		echo '
						</select>
						<span class="input-group-btn">
							<a href="adminPanel.php?subpage=ClientsPeople&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></a>
						</span>
						
					</div>';

		for($i=1; $i<count($company_drivers); ++$i)
		{
			echo '<select class="form-control" id="id_driver_input" name="id_driver[]">
					<option selected></option>';
		displayOptionDrivers($company_drivers[$i]['id']);
			echo '</select>';
		}

		echo '
					<select class="form-control drivers_select" id="id_driver_input" name="id_driver[]">
					<option selected></option>';

		displayOptionDrivers();

		echo '		</select>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="nip_input">NIP: </label>
					<input type="text" class="form-control" id="nip_input" name="nip" value="'.$client['nip'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="phone_input">Telefon: </label>
					<input type="text" class="form-control" id="phone_input" name="phone" value="'.$client['phone'].'">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="city_input" class="tytul_input">Miasto: </label>
					<input type="text" class="form-control" id="city_input" name="city" value="'.$client['city'].'">
				</div>
				<div class="form-group">
					<label for="address_input" class="tytul_input">Adres: </label>
					<input type="text" class="form-control" id="address_input" name="address" value="'.$client['address'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="postcode_input">Kod pocztowy: </label>
					<input type="text" class="form-control" id="postcode_input" name="postcode" value="'.$client['postcode'].'">
				</div>
				<div class="form-group">
					<label for="email_input" class="tytul_input">E-mail: </label>
					<input type="text" class="form-control" id="email_input" name="email" value="'.$client['email'].'">
				</div>
			</div>
			    
			<div class="clearfix visible-lg-block"></div>
		    <div class="col-lg-8 col-md-12 col-sm-8 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=ClientsCompanies" class="btn btn-default">Anuluj</a>
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