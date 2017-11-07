<?php

require_once("displayInfo.php");
require_once("otherFunctions.php");


$limit_amount = 20;
$links_block = 5;




// ================================================== RESERVATIONS

function showReservations($stmt, $client = false){
	echo '<div class="results_div">
		<table class="table table-bordered results_table">
		<tr><th class="narrow_col">Lp.</th>
		<th>Numer</th>';
	if(!$client)
	echo '<th>Osoba/ Firma</th>
		<th>Klient</th>';
	echo '
		<th>Samochód</th>
		<th>Odbiór</th>
		<th>Zwrot</th>
		<th>Cena (zł)</th>
		<th>Faktura</th>
		<th>Status</th>
		<th class="narrow_col">Info</th>
		<th class="narrow_col">Edytuj</th>
		<th class="narrow_col">Usuń</th></tr>';

	for($i = 1; $row = $stmt->fetch(); $i++)
	{
		echo '<tr class="results_row">';

		echo '<td>'.$i.'.</td>
			<td>'.$row['reservation_nr'].'</td>';
		if(!$client)
		{
			echo '<td>';
			if($row['company/person'] == 1)
				echo 'Osoba</td>
					<td><a href="adminPanel.php?subpage=ClientsPeople&action=info&id='.$row['id_driver'].'">'.$row['driver_name'].' '.$row['driver_surname'];
			else if($row['company/person'] == 2)
				echo 'Firma</td>
					<td><a href="adminPanel.php?subpage=ClientsCompanies&action=info&id='.$row['id_driver'].'">'.$row['company_name'];
			echo '</a></td>';
		}
		echo '<td><a href="adminPanel.php?subpage=Cars&action=info&id='.$row['id_car'].'">'.$row['car_name'].'</a></td>
			<td>'.$row['start_date'].'<br/>'.$row['id_location_receipt'].'</td>
			<td>'.$row['end_date'].'<br/>'.$row['id_location_return'].'</td>
			<td>'.$row['price'].'</td>
			<td>';
		if($row['f_VAT'] == 1)
			echo 'TAK';
		else if($row['f_VAT'] == 0)
			echo 'NIE';

		echo '
			<td>
			<form method="POST" action="adminPanel/action.php?subpage=Reservations&action=changeStatus&id='.$row['id'].'">
				<input type="hidden" name="reservation_nr" value="'.$row['reservation_nr'].'"/>
				<input type="hidden" name="prev_status" value="'.$row['status'].'"/>
				<select class="form-control" name="status" onchange="this.form.submit()">';

		displayOptionReservationStatus($row['status']);
		echo '</select>
			</form></td>';

		echo '
			<td>
				<a class="btn btn-default" href="adminPanel.php?subpage=Reservations&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
			</td>
			<td><a class="btn btn-default" href="adminPanel.php?subpage=Reservations&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
			<td><a class="btn btn-default" href="adminPanel/action.php?subpage=Reservations&action=delete&id='.$row['id'].'&id_car='.$row['id_car'].'"><i class="fa fa-times" aria-hidden="true"></i></a></td>';

		echo '</tr>';
	}

	if(!$client)
		echo '<tr><td><a href="adminPanel.php?subpage=Reservations&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>';

	echo '</a></td></tr>';

	echo '</table></div>';
}

function displayReservations(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM reservations"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT reservations.id, reservation_nr, `company/person`, reservations.id_driver, companies.name AS company_name, drivers.name AS driver_name, drivers.surname AS driver_surname, id_car, cars.name AS car_name, start_date, end_date, l1.name AS id_location_receipt, l2.name AS id_location_return, reservations.price, f_VAT, status 
				FROM reservations
				LEFT JOIN drivers ON reservations.id_driver = drivers.id
				LEFT JOIN companies ON reservations.id_driver = companies.id
				LEFT JOIN cars ON reservations.id_car = cars.id
				LEFT JOIN localizations l1 ON reservations.id_location_receipt = l1.id
				LEFT JOIN localizations l2 ON reservations.id_location_return = l2.id
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);
			if($stmt->execute())
			{
				showReservations($stmt);
				$stmt->closeCursor();

			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';;
	}
}

function addReservation($reservation_nr, $company_person, $id_driver, $id_car, $start_date, $end_date, $id_location_receipt, $id_location_return, $price, $f_VAT, $status){
	if($start_date > $end_date)
		$_SESSION['error'] = "Data rozpoczęcia późniejsza od daty zakończenia";
	else
	{
		$price = str_replace(",", ".", $price);
		if(!is_numeric($price))
			$_SESSION['error'] = "Cena nie jest liczbą";
		else
		{
			$pdo = connectDatabase();

			$stmt = $pdo->prepare("INSERT INTO reservations VALUES(NULL, :reservation_nr, :company_person, :id_driver, :id_car, :start_date, :end_date, :id_location_receipt, :id_location_return, :f_VAT, :price, :status)");
			$stmt->bindValue(':reservation_nr', $reservation_nr, PDO::PARAM_STR);
			$stmt->bindValue(':company_person', $company_person, PDO::PARAM_INT);
			$stmt->bindValue(':id_driver', $id_driver, PDO::PARAM_INT);
			$stmt->bindValue(':id_car', $id_car, PDO::PARAM_INT);
			$stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
			$stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
			$stmt->bindValue(':id_location_receipt', $id_location_receipt, PDO::PARAM_INT);
			$stmt->bindValue(':id_location_return', $id_location_return, PDO::PARAM_INT);
			$stmt->bindValue(':f_VAT', $f_VAT, PDO::PARAM_STR);
			$stmt->bindValue(':price', $price, PDO::PARAM_STR);
			$stmt->bindValue(':status', $status, PDO::PARAM_STR);

			if($stmt->execute())
			{
				$lastId = $pdo->lastInsertId();
				return $lastId;
			}
			else
				return false;
		}
	}
	return false;
}

function addReservationAdditionalFees($id, $additional_fees){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM additional_reservation WHERE reservation_id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
	{
		$stmt->closeCursor();
		foreach ($additional_fees as $fee) {
			$stmt = $pdo->prepare("INSERT INTO additional_reservation VALUES(NULL, :fee, :id)");
			$stmt->bindValue(':fee', $fee, PDO::PARAM_INT);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			if(!$stmt->execute())
				return false;
		}
	}
	return true;
}

function getReservation($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT reservations.id, reservation_nr, `company/person`, reservations.id_driver, companies.name AS company_name, drivers.name AS driver_name, drivers.surname AS driver_surname, id_car, cars.name AS car_name, start_date, end_date, id_location_receipt, l1.name AS location_receipt_name, id_location_return, l2.name AS location_return_name, reservations.price, f_VAT, status 
		FROM reservations
		LEFT JOIN drivers ON reservations.id_driver = drivers.id
		LEFT JOIN companies ON reservations.id_driver = companies.id
		LEFT JOIN cars ON reservations.id_car = cars.id
		LEFT JOIN localizations l1 ON reservations.id_location_receipt = l1.id
		LEFT JOIN localizations l2 ON reservations.id_location_return = l2.id
		WHERE reservations.id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}
function editReservation($id, $reservation_nr, $company_person, $id_driver, $id_car, $start_date, $end_date, $id_location_receipt, $id_location_return, $price, $f_VAT, $status){

	if($start_date > $end_date)
		$_SESSION['error'] = "Data rozpoczęcia późniejsza od daty zakończenia";
	else
	{
		$price = str_replace(",", ".", $price);
		if(!is_numeric($price))
			$_SESSION['error'] = "Cena nie jest liczbą";
		else
		{
			$pdo = connectDatabase();

			$stmt = $pdo->prepare("UPDATE reservations SET reservation_nr=:reservation_nr, `company/person`=:company_person, id_driver=:id_driver, id_car=:id_car, start_date=:start_date, end_date=:end_date, id_location_receipt=:id_location_receipt, id_location_return=:id_location_return, price=:price, f_VAT=:f_VAT, status=:status WHERE id=:id");
			$stmt->bindValue(':reservation_nr', $reservation_nr, PDO::PARAM_STR);
			$stmt->bindValue(':company_person', $company_person, PDO::PARAM_INT);
			$stmt->bindValue(':id_driver', $id_driver, PDO::PARAM_INT);
			$stmt->bindValue(':id_car', $id_car, PDO::PARAM_INT);
			$stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
			$stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
			$stmt->bindValue(':id_location_receipt', $id_location_receipt, PDO::PARAM_INT);
			$stmt->bindValue(':id_location_return', $id_location_return, PDO::PARAM_INT);
			$stmt->bindValue(':price', $price, PDO::PARAM_STR);
			$stmt->bindValue(':f_VAT', $f_VAT, PDO::PARAM_STR);
			$stmt->bindValue(':status', $status, PDO::PARAM_STR);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			if($stmt->execute())
				return true;
			else
				return false;
		}
	}
	return false;
}

function deleteReservation($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM reservations WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}

function displayOptionReservationStatus($selected){
	echo '<option';
	if($selected == "Do zapłaty")
		echo ' selected';
	echo '>Do zapłaty</option><option';
	if($selected == "Zapłacone")
		echo ' selected';
	echo '>Zapłacone</option><option';
	if($selected == "W trakcie przygotowania")
		echo ' selected';
	echo '>W trakcie przygotowania</option><option';
	if($selected == "Gotowe do odbioru")
		echo ' selected';
	echo '>Gotowe do odbioru</option><option';
	if($selected == "Odebrane")
		echo ' selected';
	echo '>Odebrane</option><option';
	if($selected == "Zakończone")
		echo ' selected';
	echo '>Zakończone</option>';
}

function setCarAvaliable($car_id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("UPDATE cars SET avaliable=1 WHERE id=:id");
	$stmt->bindValue(':id', $car_id, PDO::PARAM_INT);
	$stmt->execute();
}
function getCarIdFromReservation($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT id_car FROM reservations WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$id_car = $stmt->fetch()['id_car'];
	return $id_car;

}
function setCarNotAvaliable($car_id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("UPDATE cars SET avaliable=0 WHERE id=:id");
	$stmt->bindValue(':id', $car_id, PDO::PARAM_INT);
	$stmt->execute();
}

function changeStatus($status, $id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("UPDATE reservations SET status=:status WHERE id=:id");
	$stmt->bindValue(':status', $status, PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}

function displayReservationsWithStatus($status){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT COUNT(*) AS 'count' FROM reservations WHERE status=:status");
	$stmt->bindValue(':status', $status, PDO::PARAM_STR);
	if($stmt->execute())
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT reservations.id, reservation_nr, `company/person`, reservations.id_driver, companies.name AS company_name, drivers.name AS driver_name, drivers.surname AS driver_surname, id_car, cars.name AS car_name, start_date, end_date, l1.name AS id_location_receipt, l2.name AS id_location_return, reservations.price, f_VAT, status 
				FROM reservations
				LEFT JOIN drivers ON reservations.id_driver = drivers.id
				LEFT JOIN companies ON reservations.id_driver = companies.id
				LEFT JOIN cars ON reservations.id_car = cars.id
				LEFT JOIN localizations l1 ON reservations.id_location_receipt = l1.id
				LEFT JOIN localizations l2 ON reservations.id_location_return = l2.id
				WHERE status=:status
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':status', $status, PDO::PARAM_STR);
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);
			if($stmt->execute())
			{
				showReservations($stmt);
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';;
	}
}

function getMailFromReservation($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT `company/person`, id_driver FROM reservations WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
	{
		$row = $stmt->fetch();
		$company_person = $row['company/person'];
		$id_driver = $row['id_driver'];
		if($company_person == 1)
		{
			$stmt = $pdo->prepare("SELECT email FROM drivers WHERE id=:id");
			$stmt->bindValue(':id', $id_driver, PDO::PARAM_INT);
			if($stmt->execute())
				return $stmt->fetch()['email'];
		}
		else if($company_person == 2)
		{
			$stmt = $pdo->prepare("SELECT email FROM companies WHERE id=:id");
			$stmt->bindValue(':id', $id_driver, PDO::PARAM_INT);
			if($stmt->execute())
				return $stmt->fetch()['email'];
		}
	}
}




// ================================================== CARS

function displayCars(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM cars"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT cars.id, cars.name, cars.type, manufacture_year, mileage, localizations.name AS id_localization, price_class.name AS price_class, avaliable
				FROM cars
				LEFT JOIN localizations ON cars.id_localization = localizations.id
				LEFT JOIN body_type ON cars.body_type = body_type.id
				LEFT JOIN price_class ON cars.price_class = price_class.id
				ORDER BY id ASC
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
					<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Nazwa</th>
					<th>Typ</th>
					<th>Rok produkcji</th>
					<th>Przebieg</th>
					<th>Lokalizacja</th>
					<th>Klasa cenowa</th>
					<th>Dostępny</th>
					<th class="narrow_col">Info</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = $limit_start + 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
					<td>'.$row['name'].'</td>
					<td>'.$row['type'].'</td>
					<td>'.$row['manufacture_year'].'</td>
					<td>'.$row['mileage'].'</td>
					<td>'.$row['id_localization'].'</td>
					<td>'.$row['price_class'].'</td>';

					echo '<td>';
					if($row['avaliable'])
						echo 'TAK';
					else
						echo 'NIE';

					echo '</td>
					<td>
						<a class="btn btn-default" href="adminPanel.php?subpage=Cars&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
					</td>
					<td>
						<a class="btn btn-default" href="adminPanel.php?subpage=Cars&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					</td>
					<td>
						<a class="btn btn-default" href="adminPanel/action.php?subpage=Cars&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
					</td>';

					echo '</tr>';
				}

				echo '<tr><td><a href="adminPanel.php?subpage=Cars&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>
					</a></td></tr>';

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}


function checkBodyType($body_type){
	$pdo = connectDatabase();

	$id_body_type = 0;

	$stmt = $pdo->prepare("SELECT id FROM body_type WHERE name = :body_type");
	$stmt->bindValue(':body_type', $body_type, PDO::PARAM_STR);
	if($stmt->execute())
	{
		if($stmt->rowCount() > 0)
		{
			$id_body_type = $stmt->fetch()['id'];
			$stmt->closeCursor();
		}
		else
		{
			$stmt = $pdo->prepare("INSERT INTO body_type VALUES(NULL, :body_type)");
			$stmt->bindValue(':body_type', $body_type, PDO::PARAM_STR);
			if($stmt->execute())
				$id_body_type = $pdo->lastInsertId();
		}
	}
	return $id_body_type;
}

function addCar($name, $type, $manufacture_year, $id_localization, $varnish_color, $nr_of_seats, $engine, $engine_power, $drive, $gear_type, $body_type, $mileage, $price_class, $avaliable, $description){

	if(!is_numeric($manufacture_year))
		$_SESSION['error'] = "Rok produkcji musi być liczbą";
	else
	{
		if(!is_numeric($nr_of_seats))
			$_SESSION['error'] = "Liczba miejsc musi być liczbą";
		else
		{
			if(!is_numeric($mileage))
				$_SESSION['error'] = "Przebieg musi być liczbą";
			else
			{
				if($id_body_type = checkBodyType($body_type))
				{
					$pdo = connectDatabase();

					$stmt = $pdo->prepare("INSERT INTO cars VALUES(NULL, :name, :type, :manufacture_year, :varnish_color, :nr_of_seats, :engine, :engine_power, :drive, :gear_type, :body_type, :mileage, :description, :id_localization, :price_class, :avaliable)");
					$stmt->bindValue(':name', $name, PDO::PARAM_STR);
					$stmt->bindValue(':type', $type, PDO::PARAM_STR);
					$stmt->bindValue(':manufacture_year', $manufacture_year, PDO::PARAM_STR);
					$stmt->bindValue(':varnish_color', $varnish_color, PDO::PARAM_STR);
					$stmt->bindValue(':nr_of_seats', $nr_of_seats, PDO::PARAM_INT);
					$stmt->bindValue(':engine', $engine, PDO::PARAM_STR);
					$stmt->bindValue(':engine_power', $engine_power, PDO::PARAM_STR);
					$stmt->bindValue(':drive', $drive, PDO::PARAM_STR);
					$stmt->bindValue(':gear_type', $gear_type, PDO::PARAM_STR);
					$stmt->bindValue(':body_type', $id_body_type, PDO::PARAM_INT);
					$stmt->bindValue(':mileage', $mileage, PDO::PARAM_STR);
					$stmt->bindValue(':description', $description, PDO::PARAM_STR);
					$stmt->bindValue(':id_localization', $id_localization, PDO::PARAM_INT);
					$stmt->bindValue(':price_class', $price_class, PDO::PARAM_STR);
					$stmt->bindValue(':avaliable', $avaliable, PDO::PARAM_INT);

					if($stmt->execute())
						return $pdo->lastInsertId();
				}
			}
		}
	}
	return false;
}


function displayCarImages($id){
	$pdo = connectDatabase();
	$stmt = $pdo->prepare("SELECT * FROM images WHERE id_car=:car_id");
	$stmt->bindValue(':car_id', $id, PDO::PARAM_STR);
	if($stmt->execute())
	{
		if($stmt->rowCount() > 0)
		{
			for($i = 1; $row = $stmt->fetch(); ++$i)
			{
				$filename = $id.'_'.$row['nr_img'].'.'.$row['extension'];
				$path = "images/samochody/".$filename;
				echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="car_images_div">
						<img class="car_images img-responsive" src="'.$path.'" alt="'.$id.'_'.$row['nr_img'].'"/>
					</div>
					</div>';
				if($i % 2 == 0)
					echo '<div class="clearfix visible-sm-block"></div>';
				if($i % 3 == 0)
					echo '<div class="clearfix visible-lg-block visible-md-block"></div>';
			}
		}
		else
			echo '<p>Brak zdjęć</p>';

		$stmt->closeCursor();
	}
}

function displayCarImageModel($id){
	$pdo = connectDatabase();
	$stmt = $pdo->prepare("SELECT name FROM cars WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
	if($stmt->execute())
	{
		if($stmt->rowCount() > 0)
		{
			$row = $stmt->fetch();
			$name = str_replace(" ", "", strtolower($row['name'])).'.png';
			$path = "images/samochody/modele/".$name;
			if(file_exists($path))
				echo '<img class="img-responsive" src="'.$path.'" alt="'.$row['name'].'"/>';
		}
		else
			echo '<p>Brak zdjęcia</p>';
		$stmt->closeCursor();
	}
}

function displayCarImagesForDelete($id){
	$pdo = connectDatabase();
	$stmt = $pdo->prepare("SELECT * FROM images WHERE id_car=:car_id");
	$stmt->bindValue(':car_id', $id, PDO::PARAM_STR);
	if($stmt->execute())
	{
		if($stmt->rowCount() > 0)
		{
			for($i = 1; $row = $stmt->fetch(); ++$i)
			{
				$filename = $id.'_'.$row['nr_img'].'.'.$row['extension'];
				$path = "images/samochody/".$filename;

				echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="car_images_div">
						<input type="checkbox" class="form-control" id="'.$filename.'" name="delete_files[]" value="'.$filename.'"/>
						<label for="'.$filename.'">
							<img class="car_images img-responsive" src="'.$path.'" alt="'.$id.'_'.$row['nr_img'].'"/>
						</label>
					</div>
					</div>';
				if($i % 2 == 0)
					echo '<div class="clearfix visible-sm-block"></div>';
				if($i % 3 == 0)
					echo '<div class="clearfix visible-lg-block visible-md-block"></div>';
			}
		}
		else
			echo '<p>Brak zdjęć</p>';
		$stmt->closeCursor();
	}
}

function addImages($files, $car_id){
	$max_rozmiar = 1024*1024;

	$pdo = connectDatabase();
	$stmt_last = $pdo->prepare("SELECT nr_img FROM images WHERE id_car=:car_id ORDER BY nr_img DESC LIMIT 1");
	$stmt_last->bindValue(':car_id', $car_id, PDO::PARAM_INT);

	$image_count = 1;

	if($stmt_last->execute())
	{
		if($stmt_last->rowCount() > 0)
			$image_count = $stmt_last->fetch()['nr_img'] + 1;
		$stmt_last->closeCursor();


		for($i = 0; $i < count($files['name']); ++$i)
		{
			$files['name'] = str_replace(' ', '_', $files['name']);
			if(!empty($files['name'][$i]))
			{
				if (is_uploaded_file($files['tmp_name'][$i]))
				{
					if ($files['size'][$i] > $max_rozmiar)
					{
						$_SESSION['error'] = 'Plik "'.$files['name'][$i].'" jest za duży';
						return false;
					}
					else
					{
						if (isset($files['type']) && startsWith($files['type'][$i], "image/"))
						{
								$extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
								$filename = $car_id."_".$image_count.'.'.$extension;

								move_uploaded_file($files['tmp_name'][$i], '../images/samochody/'.$filename);

								$stmt = $pdo->prepare("INSERT INTO images VALUES(NULL, :image_count, :car_id, :extension)");
								$stmt->bindValue(':image_count', $image_count, PDO::PARAM_INT);
								$stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
								$stmt->bindValue(':extension', $extension, PDO::PARAM_STR);

								if(!$stmt->execute())
									return false;

								++$image_count;
						}
						else
						{
							$_SESSION['error'] = 'Zły format pliku "'.$files['name'][$i].'" (poprawne: pliki obrazów)';
							return false;
						}
					}
				}
				else
				{
					$_SESSION['error'] = 'Błąd przy przesyłaniu pliku "'.$files['name'][$i].'"';
					return false;
				}
			}
		}
		return true;
	}
	else
		return false;
}

function addImageModel($file, $name){
	$max_rozmiar = 1024*1024;

	$file['name'] = str_replace(' ', '_', $file['name']);
	if(!empty($file['name']))
	{
		if (is_uploaded_file($file['tmp_name']))
		{
			if ($file['size'] > $max_rozmiar)
			{
				$_SESSION['error'] = 'Plik "'.$file['name'].'" jest za duży';
				return false;
			}
			else
			{
				if (isset($file['type']) && $file['type'] == 'image/png')
				{
					$name = str_replace(" ", "", strtolower($name)).'.png';
					$path = "../images/samochody/modele/".$name;
					if(file_exists($path))
						unlink($path);

					move_uploaded_file($file['tmp_name'], $path);
				}
				else
				{
					$_SESSION['error'] = 'Zły format pliku "'.$file['name'].'" (poprawne: png)';
					return false;
				}
			}
		}
		else
		{
			$_SESSION['error'] = 'Błąd przy przesyłaniu pliku "'.$file['name'].'"';
			return false;
		}
	}
	return true;
}

function deleteImages($files){
	$path_to_folder = "folder/";
	foreach ($files as $file) {

		$filename_pieces = explode("_", $file);
		$filename_pieces2 = explode(".", $filename_pieces[1]);

		$pdo = connectDatabase();

		$stmt = $pdo->prepare("SELECT id FROM images WHERE nr_img=:nr_img AND id_car=:id_car AND extension=:extension");
		$stmt->bindValue(':nr_img', $filename_pieces2[0], PDO::PARAM_INT);
		$stmt->bindValue(':id_car', $filename_pieces[0], PDO::PARAM_INT);
		$stmt->bindValue(':extension', $filename_pieces2[1], PDO::PARAM_STR);

		if($stmt->execute())
		{
			if($stmt->rowCount() > 0)
			{
				$id = $stmt->fetch()['id'];
			    $stmt->closeCursor();

			    $stmt = $pdo->prepare("DELETE FROM images WHERE id=:id");
			    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
			    if($stmt->execute())
			    {
			    	$path = "images/samochody/".$file;
					if(file_exists($path))
					{
						unlink($path);
					}
				    else
				    {
				    	$_SESSION['error'] = 'Plik "'.$file.'" nie istnieje';
						return false;
				    }
			    }
			}
			else
			{
				$_SESSION['error'] = 'Plik "'.$file.'" nie istnieje';
				return false;
			}
		}
	}
	return true;
}


function getCar($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT cars.id, cars.name, cars.type, manufacture_year, varnish_color, nr_of_seats, engine, engine_power, drive, gear_type, body_type.name AS body_type, mileage, description, id_localization, localizations.name AS localization_name, price_class, price_class.name AS price_class_name, avaliable
		FROM cars
		LEFT JOIN localizations ON cars.id_localization = localizations.id
		LEFT JOIN body_type ON cars.body_type = body_type.id
		LEFT JOIN price_class ON cars.price_class = price_class.id
		WHERE cars.id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}

function editCar($id, $name, $type, $manufacture_year, $id_localization, $varnish_color, $nr_of_seats, $engine, $engine_power, $drive, $gear_type, $body_type, $mileage, $price_class, $avaliable, $description){

	if($id_body_type = checkBodyType($body_type))
	{
		$pdo = connectDatabase();

		$stmt = $pdo->prepare("UPDATE cars SET name=:name, type=:type, manufacture_year=:manufacture_year, id_localization=:id_localization, varnish_color=:varnish_color, nr_of_seats=:nr_of_seats, engine=:engine, engine_power=:engine_power, drive=:drive, gear_type=:gear_type, body_type=:body_type, mileage=:mileage, price_class=:price_class, avaliable=:avaliable, description=:description WHERE id=:id");
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':type', $type, PDO::PARAM_STR);
		$stmt->bindValue(':manufacture_year', $manufacture_year, PDO::PARAM_STR);
		$stmt->bindValue(':varnish_color', $varnish_color, PDO::PARAM_STR);
		$stmt->bindValue(':nr_of_seats', $nr_of_seats, PDO::PARAM_INT);
		$stmt->bindValue(':engine', $engine, PDO::PARAM_STR);
		$stmt->bindValue(':engine_power', $engine_power, PDO::PARAM_STR);
		$stmt->bindValue(':drive', $drive, PDO::PARAM_STR);
		$stmt->bindValue(':gear_type', $gear_type, PDO::PARAM_STR);
		$stmt->bindValue(':body_type', $id_body_type, PDO::PARAM_INT);
		$stmt->bindValue(':mileage', $mileage, PDO::PARAM_STR);
		$stmt->bindValue(':description', $description, PDO::PARAM_STR);
		$stmt->bindValue(':id_localization', $id_localization, PDO::PARAM_INT);
		$stmt->bindValue(':price_class', $price_class, PDO::PARAM_STR);
		$stmt->bindValue(':avaliable', $avaliable, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

		if($stmt->execute())
			return true;
		else
			return false;
	}
	return false;
}

function deleteCar($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM cars WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
	{
		$stmt = $pdo->prepare("DELETE FROM images WHERE id_car=:id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		if($stmt->execute())
			return true;
		else
			return false;
	}
	else
		return false;
}

function displayOptionCars($selected){
	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT id, name, avaliable FROM cars"))
	{
		for($i = 1; $row = $stmt->fetch(); $i++)
		{
			echo '<option value="'.$row['id'].'"';
			if(isset($selected) && $selected == $row['id'])
				echo ' selected';
			if($row['avaliable'] == 0)
				echo ' disabled';
			echo '>'.$row['name'].'</option>';
		}

		$stmt->closeCursor();
	}
	else
		throw new PDOException("SQL Error");
}

function displayOptionPriceClass($selected){
	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT id, name FROM price_class"))
	{
		for($i = 1; $row = $stmt->fetch(); $i++)
		{
			echo '<option value="'.$row['id'].'"';
			if(isset($selected) && $selected == $row['id'])
				echo ' selected';
			echo '>'.$row['name'].'</option>';
		}

		$stmt->closeCursor();
	}
	else
		throw new PDOException("SQL Error");
}

function displayOptionBodyType(){
	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT id, name FROM body_type"))
	{
		for($i = 1; $row = $stmt->fetch(); $i++)
			echo '<option value="'.$row['name'].'" data-id="'.$row['id'].'">';

		$stmt->closeCursor();
	}
	else
		throw new PDOException("SQL Error");
}




// ================================================== PAYMENTS

function displayPayments(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM payments"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT payments.id, nr_reservation, operation_number, operation_type, operation_status, operation_amount, operation_currency, operation_datetime, reservations.id AS reservation_id FROM payments
				LEFT JOIN reservations ON payments.nr_reservation = reservations.reservation_nr
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
					<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Nr. rezerwacji</th>
					<th>Nr. operacji</th>
					<th>Typ operacji</th>
					<th>Status</th>
					<th>Ilość</th>
					<th>Waluta</th>
					<th>Data operacji</th>
					<th class="narrow_col">Info</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = $limit_start + 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
					<td><a href="adminPanel.php?subpage=Reservations&action=info&id='.$row['reservation_id'].'">'.$row['nr_reservation'].'</a></td>
					<td>'.$row['operation_number'].'</td>
					<td>'.$row['operation_type'].'</td>
					<td>'.$row['operation_status'].'</td>
					<td>'.$row['operation_amount'].'</td>
					<td>'.$row['operation_currency'].'</td>
					<td>'.$row['operation_datetime'].'</td>';

					echo '<td>
						<a class="btn btn-default" href="adminPanel.php?subpage=Payments&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
					</td>
					<td>
						<a class="btn btn-default" href="adminPanel/action.php?subpage=Payments&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
					</td>';

					echo '</tr>';
				}

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}

function getPayment($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT *, reservations.id AS reservation_id FROM payments
		LEFT JOIN reservations ON payments.nr_reservation = reservations.reservation_nr
		WHERE payments.id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}

function deletePayment($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM payments WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}





// ================================================== PRICECLASS

function displayPriceClass(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM price_class"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT * FROM price_class
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
				<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Nazwa</th>
					<th>Do 5 dni (zł)</th>
					<th>Do 10 dni (zł)</th>
					<th>Do 15 dni (zł)</th>
					<th>Kaucja</th>
					<th class="narrow_col">Info</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['five'].'</td>
						<td>'.$row['ten'].'</td>
						<td>'.$row['fifteen'].'</td>
						<td>'.$row['bail'].'</td>';

					echo '
						<td><a class="btn btn-default" href="adminPanel.php?subpage=PriceClass&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel.php?subpage=PriceClass&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel/action.php?subpage=PriceClass&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '<tr><td><a href="adminPanel.php?subpage=PriceClass&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>
					</a></td></tr>';

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}

function addPriceClass($name, $five, $ten, $fifteen, $bail){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("INSERT INTO price_class VALUES(NULL, :name, :five, :ten, :fifteen, :bail)");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':five', $five, PDO::PARAM_INT);
	$stmt->bindValue(':ten', $ten, PDO::PARAM_INT);
	$stmt->bindValue(':fifteen', $fifteen, PDO::PARAM_INT);
	$stmt->bindValue(':bail', $bail, PDO::PARAM_INT);

	if($stmt->execute())
		return true;
	else
		return false;
}

function getPriceClass($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT * FROM price_class WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}

function editPriceClass($id, $name, $five, $ten, $fifteen, $bail){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("UPDATE price_class SET name=:name, five=:five, ten=:ten, fifteen=:fifteen, bail=:bail WHERE id=:id");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':five', $five, PDO::PARAM_INT);
	$stmt->bindValue(':ten', $ten, PDO::PARAM_INT);
	$stmt->bindValue(':fifteen', $fifteen, PDO::PARAM_INT);
	$stmt->bindValue(':bail', $bail, PDO::PARAM_INT);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return true;
	else
		return false;
}

function deletePriceClass($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM price_class WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}




// ================================================== ADDITIONALFEES

function displayAdditionalFees(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM additional_fees"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT * FROM additional_fees
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
				<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Nazwa</th>
					<th>Cena (zł)</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['price'].'</td>';

					echo '
						<td><a class="btn btn-default" href="adminPanel.php?subpage=AdditionalFees&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel/action.php?subpage=AdditionalFees&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '<tr><td><a href="adminPanel.php?subpage=AdditionalFees&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>
					</a></td></tr>';

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}

function addAdditionalFee($name, $price){
	$price = str_replace(",", ".", $price);
	if(!is_numeric($price))
		$_SESSION['error'] = "Cena nie jest liczbą";
	else
	{
		$pdo = connectDatabase();

		$stmt = $pdo->prepare("INSERT INTO additional_fees VALUES(NULL, :name, :price)");
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':price', $price, PDO::PARAM_STR);

		if($stmt->execute())
			return true;
		else
			return false;
	}
	return false;
}

function getAdditionalFee($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT * FROM additional_fees WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}

function editAdditionalFee($id, $name, $price){
	$price = str_replace(",", ".", $price);
	if(!is_numeric($price))
		$_SESSION['error'] = "Cena nie jest liczbą";
	else
	{
		$pdo = connectDatabase();

		$stmt = $pdo->prepare("UPDATE additional_fees SET name=:name, price=:price WHERE id=:id");
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':price', $price, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

		if($stmt->execute())
			return true;
		else
			return false;
	}
	return false;
}

function deleteAdditionalFee($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM additional_fees WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}


function displayCheckboxAdditionalFees($id = false, $disabled = false){
	$pdo = connectDatabase();

	$array_checked = array();

	if($id != false)
	{
		$stmt = $pdo->prepare("SELECT additional_id FROM additional_reservation WHERE reservation_id=:id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		if($stmt->execute())
		{
			while($row = $stmt->fetch())
				array_push($array_checked, $row['additional_id']);
		}

		$stmt->closeCursor();
	}

	$stmt = $pdo->prepare("SELECT * FROM additional_fees");
	if($stmt->execute())
	{
		for($i = 1; $row = $stmt->fetch(); $i++)
		{
			echo '<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
				<label class="checkbox-inline">
				<input type="checkbox" value="'.$row['id'].'" name="additional_fees[]"';

			if($id != false && in_array($row['id'], $array_checked))
				echo ' checked';
			if($disabled != false)
				echo ' disabled';

			echo'>'.$row['name'].'</label>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<p>'.$row['price'].' zł</p>
				</div>';
		}

		$stmt->closeCursor();
		return true;
	}
	else
		return false;
}




// ================================================== CLIENTS

function displayClientsPeople(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM drivers"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT * FROM drivers
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
				<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Imię</th>
					<th>Nazwisko</th>
					<th>PESEL</th>
					<th>Adres</th>
					<th>Telefon</th>
					<th>E-mail</th>
					<th class="narrow_col">Info</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['surname'].'</td>
						<td>'.$row['pesel'].'</td>
						<td>'.$row['address'].'</td>
						<td>'.$row['phone'].'</td>
						<td>'.$row['email'].'</td>';

					echo '
						<td><a class="btn btn-default" href="adminPanel.php?subpage=ClientsPeople&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel.php?subpage=ClientsPeople&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel/action.php?subpage=ClientsPeople&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '<tr><td><a href="adminPanel.php?subpage=ClientsPeople&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>
					</a></td></tr>';

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}

function addClientPeople($name, $surname, $pesel, $ident_card, $driving_licence, $address, $postcode, $city, $country, $phone, $email){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("INSERT INTO drivers VALUES(NULL, NULL, :name, :surname, :pesel, :ident_card, :driving_licence, :address, :postcode, :city, :country, :phone, :email)");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
	$stmt->bindValue(':pesel', $pesel, PDO::PARAM_STR);
	$stmt->bindValue(':ident_card', $ident_card, PDO::PARAM_STR);
	$stmt->bindValue(':driving_licence', $driving_licence, PDO::PARAM_STR);
	$stmt->bindValue(':address', $address, PDO::PARAM_STR);
	$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
	$stmt->bindValue(':city', $city, PDO::PARAM_STR);
	$stmt->bindValue(':country', $country, PDO::PARAM_STR);
	$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
	$stmt->bindValue(':email', $email, PDO::PARAM_STR);

	if($stmt->execute())
		return true;
	else
		return false;
}

function getClientPeople($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT * FROM drivers WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}

function editClientPeople($id, $name, $surname, $pesel, $ident_card, $driving_licence, $address, $postcode, $city, $country, $phone, $email){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("UPDATE drivers SET name=:name, surname=:surname, pesel=:pesel, ident_card=:ident_card, driving_licence=:driving_licence, address=:address, postcode=:postcode, city=:city, country=:country, phone=:phone, email=:email WHERE id=:id");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
	$stmt->bindValue(':pesel', $pesel, PDO::PARAM_STR);
	$stmt->bindValue(':ident_card', $ident_card, PDO::PARAM_STR);
	$stmt->bindValue(':driving_licence', $driving_licence, PDO::PARAM_STR);
	$stmt->bindValue(':address', $address, PDO::PARAM_STR);
	$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
	$stmt->bindValue(':city', $city, PDO::PARAM_STR);
	$stmt->bindValue(':country', $country, PDO::PARAM_STR);
	$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return true;
	else
		return false;
}

function deleteClientPeople($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM drivers WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}



function displayClientsCompanies(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM companies"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT companies.id, companies.name, companies.address, companies.postcode, nip, companies.phone
				FROM companies
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
				<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Nazwa</th>
					<th>Adres</th>
					<th>NIP</th>
					<th>Telefon</th>
					<th class="narrow_col">Info</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['address'].'</td>
						<td>'.$row['nip'].'</td>
						<td>'.$row['phone'].'</td>';

					echo '
						<td><a class="btn btn-default" href="adminPanel.php?subpage=ClientsCompanies&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel.php?subpage=ClientsCompanies&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel/action.php?subpage=ClientsCompanies&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '<tr><td><a href="adminPanel.php?subpage=ClientsCompanies&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>
					</a></td></tr>';

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}

function addClientCompanies($name, $id_driver, $address, $postcode, $city, $nip, $phone, $email){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("INSERT INTO companies VALUES(NULL, :name, :address, :postcode, :city, :nip, :phone, :email)");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':address', $address, PDO::PARAM_STR);
	$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
	$stmt->bindValue(':city', $city, PDO::PARAM_STR);
	$stmt->bindValue(':nip', $nip, PDO::PARAM_STR);
	$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
	$stmt->bindValue(':email', $email, PDO::PARAM_STR);

	if($stmt->execute())
	{
		$id = $pdo->lastInsertId();
		for($i=0; $i<count($id_driver); ++$i)
		{
			if($id_driver[$i] != "")
			{
				$stmt = $pdo->prepare("UPDATE drivers SET id_companies=:id WHERE id=:id_driver");
				$stmt->bindValue(':id', $id, PDO::PARAM_INT);
				$stmt->bindValue(':id_driver', $id_driver[$i], PDO::PARAM_INT);
				$stmt->execute();
			}
		}
		return true;
	}
	else
		return false;
}

function getClientCompanies($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT companies.id, companies.name, companies.address, companies.postcode, companies.city, nip, companies.phone, companies.email
		FROM companies
		WHERE companies.id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}

function editClientCompanies($id, $name, $id_driver, $address, $postcode, $city, $nip, $phone, $email){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("UPDATE companies SET name=:name, address=:address, postcode=:postcode, city=:city, nip=:nip, phone=:phone, email=:email WHERE id=:id");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':address', $address, PDO::PARAM_STR);
	$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
	$stmt->bindValue(':city', $city, PDO::PARAM_STR);
	$stmt->bindValue(':nip', $nip, PDO::PARAM_STR);
	$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
	{
		$stmt = $pdo->prepare("UPDATE drivers SET id_companies=NULL WHERE id_companies=:id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		if($stmt->execute())
		{
			for($i=0; $i<count($id_driver); ++$i)
			{
				if($id_driver[$i] != "")
				{
					$stmt = $pdo->prepare("UPDATE drivers SET id_companies=:id WHERE id=:id_driver");
					$stmt->bindValue(':id', $id, PDO::PARAM_INT);
					$stmt->bindValue(':id_driver', $id_driver[$i], PDO::PARAM_INT);
					$stmt->execute();
				}
			}
		}
		return true;
	}
	else
		return false;
}
function deleteClientCompanies($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM companies WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}

function getCompanyDrivers($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT id FROM drivers
		WHERE id_companies=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return $stmt->fetchAll();
	else
		return false;
}

function displayCompanyDrivers($id){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT COUNT(*) AS 'count' FROM drivers WHERE id_companies=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT * FROM drivers
				WHERE id_companies=:id
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
				<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Imię</th>
					<th>Nazwisko</th>
					<th>PESEL</th>
					<th>Adres</th>
					<th>Telefon</th>
					<th>E-mail</th>
					<th class="narrow_col">Info</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['surname'].'</td>
						<td>'.$row['pesel'].'</td>
						<td>'.$row['address'].'</td>
						<td>'.$row['phone'].'</td>
						<td>'.$row['email'].'</td>';

					echo '
						<td><a class="btn btn-default" href="adminPanel.php?subpage=ClientsPeople&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel.php?subpage=ClientsPeople&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						</td>
						<td><a class="btn btn-default" href="adminPanel/action.php?subpage=ClientsPeople&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '</a></td></tr>';

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}


function displayOptionCompanies($selected){
	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT id, name FROM companies"))
	{
		for($i = 1; $row = $stmt->fetch(); $i++)
		{
			echo '<option value="'.$row['id'].'"';
			if(isset($selected) && $selected == $row['id'])
				echo ' selected';
			echo '>'.$row['name'].'</option>';
		}

		$stmt->closeCursor();
	}
	else
		throw new PDOException("SQL Error");
}

function displayOptionDrivers($selected){
	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT id, name, surname FROM drivers"))
	{
		for($i = 1; $row = $stmt->fetch(); $i++)
		{
			echo '<option value="'.$row['id'].'"';
			if(isset($selected) && $selected == $row['id'])
				echo ' selected';
			echo '>'.$row['name'].' '.$row['surname'].'</option>';
		}

		$stmt->closeCursor();
	}
	else
		throw new PDOException("SQL Error");
}

function displayClientReservations($id, $company_person){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT COUNT(*) AS 'count' FROM reservations WHERE `company/person`=:company_person AND reservations.id_driver=:id");
	$stmt->bindValue(':company_person', $company_person, PDO::PARAM_INT);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT reservations.id, reservation_nr, `company/person`, reservations.id_driver, companies.name AS company_name, drivers.name AS driver_name, drivers.surname AS driver_surname, id_car, cars.name AS car_name, start_date, end_date, l1.name AS id_location_receipt, l2.name AS id_location_return, reservations.price, f_VAT, status 
				FROM reservations
				LEFT JOIN drivers ON reservations.id_driver = drivers.id
				LEFT JOIN companies ON reservations.id_driver = companies.id
				LEFT JOIN cars ON reservations.id_car = cars.id
				LEFT JOIN localizations l1 ON reservations.id_location_receipt = l1.id
				LEFT JOIN localizations l2 ON reservations.id_location_return = l2.id
				WHERE `company/person`=:company_person AND reservations.id_driver=:id
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);
			$stmt->bindValue(':company_person', $company_person, PDO::PARAM_INT);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			if($stmt->execute())
			{
				showReservations($stmt, true);
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';;
	}
}





// ================================================== LOCALIZATIONS

function displayLocalizations(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM localizations"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT * FROM localizations
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);

			if($stmt->execute())
			{
				echo '<div class="results_div">
				<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Nazwa</th>
					<th>Miasto</th>
					<th>Kod pocztowy</th>
					<th>Adres</th>
					<th>Typ</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['city'].'</td>
						<td>'.$row['postcode'].'</td>
						<td>'.$row['address'].'</td>
						<td>'.$row['type'].'</td>';

					echo '<td><a class="btn btn-default" href="adminPanel.php?subpage=Locations&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
						<td>
						<a class="btn btn-default" href="adminPanel/action.php?subpage=Locations&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '<tr><td><a href="adminPanel.php?subpage=Locations&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>
					</a></td></tr>';

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';
	}
}

function addLocalization($name, $address, $city, $postcode, $type){
	$pdo = connectDatabase();

	/*if(preg_match('/^[0-9]{2}-[0-9]{3}$/', $postcode))
	{*/

	$stmt = $pdo->prepare("INSERT INTO localizations VALUES(NULL, :name, :address, :city, :postcode, :type)");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':address', $address, PDO::PARAM_STR);
	$stmt->bindValue(':city', $city, PDO::PARAM_STR);
	$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
	$stmt->bindValue(':type', $type, PDO::PARAM_STR);

	if($stmt->execute())
		return true;
	else
		return false;
	/*}
	else
		$_SESSION['error'] = "Błędny kod pocztowy";*/
}

function getLocalization($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("SELECT * FROM localizations WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return $stmt->fetch();
	else
		return false;
}

function editLocalization($id, $name, $address, $city, $postcode, $type){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("UPDATE localizations SET name=:name, address=:address, city=:city, postcode=:postcode, type=:type WHERE id=:id");
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':address', $address, PDO::PARAM_STR);
	$stmt->bindValue(':city', $city, PDO::PARAM_STR);
	$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
	$stmt->bindValue(':type', $type, PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	if($stmt->execute())
		return true;
	else
		return false;
}

function deleteLocalization($id){
	$pdo = connectDatabase();

	$stmt = $pdo->prepare("DELETE FROM localizations WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	if($stmt->execute())
		return true;
	else
		return false;
}


function displayOptionLocalizations($selected){
	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT id, name FROM localizations"))
	{
		for($i = 1; $row = $stmt->fetch(); $i++)
		{
			echo '<option value="'.$row['id'].'"';
			if(isset($selected) && $selected == $row['id'])
				echo ' selected';
			echo '>'.$row['name'].'</option>';
		}

		$stmt->closeCursor();
	}
	else
		throw new PDOException("SQL Error");
}


// ========================================================== HOME

function displayTodayPickups(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM reservations
		WHERE DATE_FORMAT(start_date, '%Y-%m-%d') = CURDATE()"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT reservations.id, reservation_nr, `company/person`, reservations.id_driver, companies.name AS company_name, drivers.name AS driver_name, drivers.surname AS driver_surname, id_car, cars.name AS car_name, start_date, l1.name AS id_location_receipt, reservations.price, status
				FROM reservations
				LEFT JOIN drivers ON reservations.id_driver = drivers.id
				LEFT JOIN companies ON reservations.id_driver = companies.id
				LEFT JOIN cars ON reservations.id_car = cars.id
				LEFT JOIN localizations l1 ON reservations.id_location_receipt = l1.id
				WHERE DATE_FORMAT(start_date, '%Y-%m-%d') = CURDATE()
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);
			if($stmt->execute())
			{
				echo '<div class="results_div">
					<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Numer</th>
					<th>Osoba/ Firma</th>
					<th>Klient</th>
					<th>Samochód</th>
					<th>Odbiór</th>
					<th>Cena (zł)</th>
					<th>Status</th>
					<th class="narrow_col">Info</th>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['reservation_nr'].'</td><td>';
					if($row['company/person'] == 1)
						echo 'Osoba</td>
							<td><a href="adminPanel.php?subpage=ClientsPeople&action=info&id='.$row['id_driver'].'">'.$row['driver_name'].' '.$row['driver_surname'];
					else if($row['company/person'] == 2)
						echo 'Firma</td>
							<td><a href="adminPanel.php?subpage=ClientsCompanies&action=info&id='.$row['id_driver'].'">'.$row['company_name'];
					echo '</a></td>';
					echo '<td><a href="adminPanel.php?subpage=Cars&action=info&id='.$row['id_car'].'">'.$row['car_name'].'</a></td>
						<td>'.$row['start_date'].'<br/>'.$row['id_location_receipt'].'</td>
						<td>'.$row['price'].'</td>
						<td>'.$row['status'].'</td>
						<td>
						<a class="btn btn-default" href="adminPanel.php?subpage=Reservations&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';;
	}
}

function displayTodayReturns(){
	global $limit_amount, $links_block;

	$pdo = connectDatabase();

	if($stmt = $pdo->query("SELECT COUNT(*) AS 'count' FROM reservations
		WHERE DATE_FORMAT(end_date, '%Y-%m-%d') = CURDATE()"))
	{
		$result_count = $stmt->fetch()['count'];
		$page = 1;

		if($result_count > 0)
		{
			$pages_amount = ceil($result_count / $limit_amount);
			if($pages_amount > 1)
			{
				if(!isset($_GET['page']) || $_GET['page'] < 1)
					$_GET['page'] = 1;
				else if($_GET['page'] > $pages_amount)
					$_GET['page'] = $pages_amount;
				$page = intval($_GET['page']);

				pagination($pages_amount, $page, $links_block);
			}

			$stmt->closeCursor();

			$limit_start = ($page-1)*$limit_amount;



			$stmt = $pdo->prepare("SELECT reservations.id, reservation_nr, `company/person`, reservations.id_driver, companies.name AS company_name, drivers.name AS driver_name, drivers.surname AS driver_surname, id_car, cars.name AS car_name, end_date, l2.name AS id_location_return, reservations.price, status
				FROM reservations
				LEFT JOIN drivers ON reservations.id_driver = drivers.id
				LEFT JOIN companies ON reservations.id_driver = companies.id
				LEFT JOIN cars ON reservations.id_car = cars.id
				LEFT JOIN localizations l2 ON reservations.id_location_return = l2.id
				WHERE DATE_FORMAT(end_date, '%Y-%m-%d') = CURDATE()
				LIMIT :limit_start, :limit_amount");
			$stmt->bindValue(':limit_start', $limit_start, PDO::PARAM_INT);
			$stmt->bindValue(':limit_amount', $limit_amount, PDO::PARAM_INT);
			if($stmt->execute())
			{
				echo '<div class="results_div">
					<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Numer</th>
					<th>Osoba/ Firma</th>
					<th>Klient</th>
					<th>Samochód</th>
					<th>Zwrot</th>
					<th>Cena (zł)</th>
					<th>Status</th>
					<th class="narrow_col">Info</th>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>
						<td>'.$row['reservation_nr'].'</td><td>';
					if($row['company/person'] == 1)
						echo 'Osoba</td>
							<td><a href="adminPanel.php?subpage=ClientsPeople&action=info&id='.$row['id_driver'].'">'.$row['driver_name'].' '.$row['driver_surname'];
					else if($row['company/person'] == 2)
						echo 'Firma</td>
							<td><a href="adminPanel.php?subpage=ClientsCompanies&action=info&id='.$row['id_driver'].'">'.$row['company_name'];
					echo '</a></td>';
					echo '<td><a href="adminPanel.php?subpage=Cars&action=info&id='.$row['id_car'].'">'.$row['car_name'].'</a></td>
						<td>'.$row['end_date'].'<br/>'.$row['id_location_return'].'</td>
						<td>'.$row['price'].'</td>
						<td>'.$row['status'].'</td>
						<td>
						<a class="btn btn-default" href="adminPanel.php?subpage=Reservations&action=info&id='.$row['id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
						</td>';

					echo '</tr>';
				}

				echo '</table></div>';
				$stmt->closeCursor();
			}
			else
				throw new PDOException("SQL Error");
		}
		else
			echo '<h4>Brak wyników</h4>';;
	}
}


?>
