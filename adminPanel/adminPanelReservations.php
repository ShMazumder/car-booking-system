<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Rezerwacje</h3>
			</div>';
		echo '
			<form class="form-inline">
				<a href="adminPanel.php?subpage=Reservations&action=add" class="btn btn-default action-btn">Dodaj rezerwację</a>
				<input type="hidden" name="subpage" value="Reservations">
				<select class="right-control form-control" name="status" onchange="this.form.submit()">';
		if(!isset($_GET['status']))
		{
			echo '<option selected disabled hidden>Status</option>';
			displayOptionReservationStatus("");
		}
		else
			displayOptionReservationStatus($_GET['status']);

		echo '
				</select>
			</form>
			<hr/>';

		if(!isset($_GET['status']))
			displayReservations();
		else
			displayReservationsWithStatus($_GET['status']);
	}
	else if($_GET['action'] == "add")
	{
		echo '<div class="page-header">
			<h3>Dodawanie rezerwacji</h3>
			</div>';
		echo '		
			<form method="POST" action="adminPanel/action.php?subpage=Reservations&action=add" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="reservation_nr_input" class="tytul_input">Numer: </label>
					<input type="text" class="form-control" id="reservation_nr_input" name="reservation_nr">
				</div>
				<div class="form-group">
					<label for="company_person_input" class="tytul_input">Osoba/Firma: </label>
					<select class="form-control" id="company_person_input" name="company/person">
						<option value="1">Osoba</option>
						<option value="2">Firma</option>
					</select>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="id_driver_input">Klient: </label>
					<div class="input-group">
						<select class="form-control" id="id_driver_input" name="id_driver">';

		displayOptionDrivers();

		echo '
						</select>
						<span class="input-group-btn">
							<a id="id_driver_plus" href="adminPanel.php?subpage=ClientsPeople&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></a>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="id_car_input">Samochód: </label>
					<select class="form-control" id="id_car_input" name="id_car">';

		displayOptionCars();

		echo '
					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="start_date_input">Data rozpoczęcia: </label>
	                <input type="text" class="form-control datetime" id="start_date_input" name="start_date">
            	</div>
            	<div class="form-group">
					<label class="tytul_input" for="end_date_input">Data zakończenia: </label>
	                <input type="text" class="form-control datetime" id="end_date_input" name="end_date">
            	</div>
			    <div class="form-group">
					<label class="tytul_input" for="id_location_receipt_input">Lokacja odbioru: </label>
			    	<select class="form-control" id="id_location_receipt_input" name="id_location_receipt">';

		displayOptionLocalizations();

		echo '
					</select>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="id_location_return_input">Lokacja zwrotu: </label>
			    	<select class="form-control" id="id_location_return_input" name="id_location_return">';

		displayOptionLocalizations();

		echo '
					</select>
			    </div>
			</div>
		    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			    <div class="form-group">
					<label class="tytul_input" for="price_input">Cena (zł): </label>
			    	<input type="text" class="form-control" id="price_input" name="price">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="fVat_input">Faktura: </label>
			    	<select class="form-control" id="fVat_input" name="fVat">
			    		<option value="0">NIE</option>
			    		<option value="1">TAK</option>
			    	</select>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="status_input">Status: </label>
			    	<select class="form-control" id="status_input" name="status">
			    		<option>Do zapłaty</option>
			    		<option>Zapłacone</option>
			    		<option>W trakcie przygotowania</option>
			    		<option>Gotowe do odbioru</option>
			    		<option>Odebrane</option>
			    		<option>Zakończone</option>
			    	</select>
			    </div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Dodatkowe opłaty</h3>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

		displayCheckboxAdditionalFees();

		echo '
			</div>
			
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    	<br/>
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=Reservations" class="btn btn-default">Anuluj</a>
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

		$reservation = getReservation($_GET['id']);

		echo '<div class="page-header">
			<h3>Informacje o rezerwacji</h3>
			</div>';
		echo '
			<form method="POST" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="reservation_nr_input" class="tytul_input">Numer: </label>
					<input type="text" class="form-control" id="reservation_nr_input" name="reservation_nr". value="'.$reservation['reservation_nr'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="company_person_input" class="tytul_input">Osoba/Firma: </label>
					<input type="text" class="form-control" id="company_person_input" name="company/person" value="';
		if($reservation['company/person'] == 1)
			echo "Osoba";
		else if($reservation['company/person'] == 2)
			echo 'Firma';
		echo '" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="id_driver_input">Klient: </label>
					<div class="input-group">
						<input type="text" class="form-control" id="id_driver_input" name="id_driver" value="';

		if($reservation['company/person'] == 1)
			echo $reservation['driver_name'].' '.$reservation['driver_surname'].'" readOnly>
				<span class="input-group-btn">
					<a href="adminPanel.php?subpage=ClientsPeople&action=info&id='.$reservation['id_driver'].'" class="btn btn-default"><i class="fa fa-info" aria-hidden="true"></i></a>
				</span>';
		else if($reservation['company/person'] == 2)
			echo $reservation['company_name'].'" readOnly>
				<span class="input-group-btn">
					<a href="adminPanel.php?subpage=ClientsCompanies&action=info&id='.$reservation['id_driver'].'" class="btn btn-default"><i class="fa fa-info" aria-hidden="true"></i></a>
				</span>';

		echo '
					</div>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="id_car_input">Samochód: </label>
					<input class="form-control" id="id_car_input" name="id_car" value="'.$reservation['car_name'].'" readOnly>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="start_date_input">Data rozpoczęcia: </label>
	                <input type="text" class="form-control" id="start_date_input" name="start_date" value="'.$reservation['start_date'].'" readOnly>
            	</div>
            	<div class="form-group">
					<label class="tytul_input" for="end_date_input">Data zakończenia: </label>
	                <input type="text" class="form-control" id="end_date_input" name="end_date" value="'.$reservation['end_date'].'" readOnly>
            	</div>
			    <div class="form-group">
					<label class="tytul_input" for="id_location_receipt_input">Lokacja odbioru: </label>
			    	<input type="text" class="form-control" id="id_location_receipt_input" name="id_location_receipt" value="'.$reservation['location_receipt_name'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="id_location_return_input">Lokacja zwrotu: </label>
			    	<input type="text" class="form-control" id="id_location_return_input" name="id_location_return" value="'.$reservation['location_return_name'].'" readOnly>
			    </div>
			</div>
		    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			    <div class="form-group">
					<label class="tytul_input" for="price_input">Cena (zł): </label>
			    	<input type="text" class="form-control" id="price_input" name="price" value="'.$reservation['price'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="fVat_input">Faktura: </label>
			    	<input type="text" class="form-control" id="fVat_input" name="fVat" value="';
		if($reservation['f_VAT'] == 0)
			echo 'NIE';
		if($reservation['f_VAT'] == 1)
			echo 'TAK';

		echo '" readOnly>
			    </div>
			    
			    <div class="form-group">
					<label class="tytul_input" for="status_input">Status: </label>
			    	<input type="text" class="form-control" id="status_input" name="status" value="'.$reservation['status'].'" readOnly>
			    </div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Dodatkowe opłaty</h3>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

		displayCheckboxAdditionalFees($_GET['id'], true);

		echo '
			</div>

		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    	<br/>
			    <div class="text-right">
					<a href="adminPanel.php?subpage=Reservations&action=edit&id='.$_GET['id'].'" class="btn btn-default">Edytuj</a>
				</div>
			</div>
			</form>';
	}
	else if($_GET['action'] == "edit" && isset($_GET['id']))
	{

		$reservation = getReservation($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie rezerwacji</h3>
			</div>';
		echo '
			<form method="POST" action="adminPanel/action.php?subpage=Reservations&action=edit&id='.$_GET['id'].'" autocomplete="off">
			<input type="hidden" name="prev_status" value="'.$reservation['status'].'"/>
			<input type="hidden" name="def_id_car" value="'.$reservation['id_car'].'" />
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="reservation_nr_input" class="tytul_input">Numer: </label>
					<input type="text" class="form-control" id="reservation_nr_input" name="reservation_nr". value="'.$reservation['reservation_nr'].'">
				</div>
				<div class="form-group">
					<label for="company_person_input" class="tytul_input">Osoba/Firma: </label>
					<select class="form-control" id="company_person_input" name="company/person">
					<option value="1" ';
		if($reservation['company/person'] == 1)
			echo "selected";
		echo '>Osoba</option><option value="2" ';
		if($reservation['company/person'] == 2)
			echo 'selected';
		echo '>Firma</option>
				    </select>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="id_driver_input">Klient: </label>
					<select class="form-control" id="id_driver_input" name="id_driver">';

		if($reservation['company/person'] == 1)
			displayOptionDrivers($reservation['id_driver']);
		else if($reservation['company/person'] == 2)
			displayOptionCompanies($reservation['id_driver']);

		echo '
					</select>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="id_car_input">Samochód: </label>
					<select class="form-control" id="id_car_input" name="id_car">';

		displayOptionCars($reservation['id_car']);

		echo '
					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="start_date_input">Data rozpoczęcia: </label>
	                <input type="text" class="form-control datetime" id="start_date_input" name="start_date" value="'.$reservation['start_date'].'">
            	</div>
            	<div class="form-group">
					<label class="tytul_input" for="end_date_input">Data zakończenia: </label>
	                <input type="text" class="form-control datetime" id="end_date_input" name="end_date" value="'.$reservation['end_date'].'">
            	</div>
			    <div class="form-group">
					<label class="tytul_input" for="id_location_receipt_input">Lokacja odbioru: </label>
			    	<select class="form-control" id="id_location_receipt_input" name="id_location_receipt">';

		displayOptionLocalizations($reservation['id_location_receipt']);

		echo '
					</select>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="id_location_return_input">Lokacja zwrotu: </label>
			    	<select class="form-control" id="id_location_return_input" name="id_location_return">';

		displayOptionLocalizations($reservation['id_location_return']);

		echo '
					</select>
			    </div>
			</div>
		    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			    <div class="form-group">
					<label class="tytul_input" for="price_input">Cena (zł): </label>
			    	<input type="text" class="form-control" id="price_input" name="price" value="'.$reservation['price'].'">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="fVat_input">Faktura: </label>
			    	<select class="form-control" id="fVat_input" name="fVat">
			    		<option value="0"';
		if($reservation['f_VAT'] == 0)
			echo ' selected';
		echo '>NIE</option><option value="1"';
		if($reservation['f_VAT'] == 1)
			echo ' selected';

		echo '
						>TAK</option>
						</option>
			    	</select>
			    </div>
			    
			    <div class="form-group">
					<label class="tytul_input" for="status_input">Status: </label>
			    	<select class="form-control" id="status_input" name="status">
			    		<option';
		if($reservation['status'] == "Do zapłaty")
			echo ' selected';
		echo '>Do zapłaty</option><option';
		if($reservation['status'] == "Zapłacone")
			echo ' selected';
		echo '>Zapłacone</option><option';
		if($reservation['status'] == "W trakcie przygotowania")
			echo ' selected';
		echo '>W trakcie przygotowania</option><option';
		if($reservation['status'] == "Gotowe do odbioru")
			echo ' selected';
		echo '>Gotowe do odbioru</option><option';
		if($reservation['status'] == "Odebrane")
			echo ' selected';
		echo '>Odebrane</option><option';
		if($reservation['status'] == "Zakończone")
			echo ' selected';
		echo '>Zakończone</option>
			    	</select>
			    </div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Dodatkowe opłaty</h3>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

		displayCheckboxAdditionalFees($_GET['id']);

		echo '
			</div>

		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    	<br/>
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=Reservations" class="btn btn-default">Anuluj</a>
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






	echo '</div>
		</div>
		</div>
		</div>';
?>