<?php

	if($_POST['action'] == "localizations"){
		$json = array();
		require("displayInfo.php");
		$pdo = connectDatabase();
		foreach ($pdo->query("SELECT address, city, name FROM localizations WHERE type='Siedziba'") as $row) {
			$lozalizationArray = array(
        'address' => $row['address'],
				'city' => $row['city'],
				'name' => $row['name']
    	);
    	array_push($json, $lozalizationArray);
		}
		$pdo=null;
		$jsonstring = json_encode($json);
		echo $jsonstring;
		die();
	}else if($_POST['action'] == "car"){
		$json = array();
		require("displayInfo.php");
		$pdo = connectDatabase();
		$stmt = $pdo->prepare("SELECT cars.id, cars.name, price_class.five AS five , price_class.ten AS ten, price_class.fifteen AS price, manufacture_year, varnish_color, nr_of_seats, engine, engine_power, drive, gear_type, mileage, body_type.name AS body_type, price_class.name AS price_class, price_class.bail AS bailPrice FROM cars INNER JOIN price_class ON cars.price_class = price_class.id INNER JOIN body_type ON cars.body_type = body_type.id WHERE cars.id=:id_car");
		$stmt->bindValue(':id_car', $_POST['id'], PDO::PARAM_INT);
		if($stmt->execute()){
			for($i = 1; $row = $stmt->fetch(); $i++){
				$lozalizationArray = array(
	        'name' => $row['name'],
					'price' => $row['price'],
					'five' => $row['five'],
					'ten' => $row['ten'],
					'manufacture_year' => $row['manufacture_year'],
					'varnish_color' => $row['varnish_color'],
					'nr_of_seats' => $row['nr_of_seats'],
					'engine_power' => $row['engine_power'],
					'engine' => $row['engine'],
					'drive' => $row['drive'],
					'gear_type' => $row['gear_type'],
					'mileage' => $row['mileage'],
					'body_type' => $row['body_type'],
					'price_class' => $row['price_class'],
					'bailPrice' => $row['bailPrice']
	    	);
	    	array_push($json, $lozalizationArray);
			}
		}
		$stmt->closeCursor();
		$pdo=null;
		$jsonstring = json_encode($json);
		echo $jsonstring;
		die();
	}else if($_POST['action'] == "addReservation"){

			require_once("displayInfo.php");
			$pdo = connectDatabase();
			$obj = $_POST['data'];
			$obj = json_decode( stripslashes( $obj ) );
			if($obj->resNumber == 0){
				$idCilent = 0;
				$sql = 'SELECT id FROM drivers WHERE pesel = '.$obj->pesel;;
				foreach ($pdo->query($sql) as $row) {
					$idCilent = $row['id'];
				}

				$idRecitpLocation = 0;
				$sql = 'SELECT id FROM localizations WHERE name="'.$obj->receptionPlace.'"';
				foreach ($pdo->query($sql) as $row) {
					$idRecitpLocation = $row['id'];
				}

				$idReturnLocation = 0;
				$sql = 'SELECT id FROM localizations WHERE name = "'.$obj->returnPlace.'"';
				foreach ($pdo->query($sql) as $row) {
					$idReturnLocation = $row['id'];
				}

				$reservationNumer = date("dmY-Gis")."-".rand(10, 555);
				$email = "";
				if($obj->typeClient == "1"){
					$email = $obj->email;
				}else{
					$email = $obj->emailCompany;
				}

				$stmt = $pdo->prepare("INSERT INTO reservations VALUES (NULL, :reservation_nr, :company, :id_driver, :id_car, :start_date, :end_date, :id_location_recitpt, :id_location_return, :f_VAT, :price, :status)");
				$stmt->bindValue(':reservation_nr', $reservationNumer, PDO::PARAM_STR);
				$stmt->bindValue(':company', $obj->typeClient, PDO::PARAM_STR);
				$stmt->bindValue(':id_driver', $idCilent, PDO::PARAM_STR);
				$stmt->bindValue(':id_car', $obj->id, PDO::PARAM_STR);
				$stmt->bindValue(':start_date', $obj->receptionDate."T".$obj->receptionTime, PDO::PARAM_STR);
				$stmt->bindValue(':end_date', $obj->returnDate."T".$obj->returnTime, PDO::PARAM_STR);
				$stmt->bindValue(':id_location_recitpt', $idRecitpLocation, PDO::PARAM_STR);
				$stmt->bindValue(':id_location_return', $idReturnLocation, PDO::PARAM_STR);
				$stmt->bindValue(':f_VAT', $obj->fVat, PDO::PARAM_STR);
				$stmt->bindValue(':price', $obj->summaryPrice, PDO::PARAM_STR);
				$stmt->bindValue(':status', "Do zapłaty", PDO::PARAM_STR);
				if($stmt->execute()){

					foreach ($pdo->query('SELECT id FROM reservations WHERE reservation_nr="'.$reservationNumer.'"') as $row) {
						for($i = 0; $i < count($obj->additionItem); $i++){
							$stmt = $pdo->prepare("INSERT INTO additional_reservation VALUES(NULL, :additional_id, :reservation_id)");
							$stmt->bindValue(':additional_id', $obj->additionItem[$i], PDO::PARAM_STR);
							$stmt->bindValue(':reservation_id', $row['id'], PDO::PARAM_STR);
							$stmt->execute();
						}
					}

					$stmt = $pdo->prepare("UPDATE cars SET avaliable=1 WHERE id=:id");
					$stmt->bindValue(':id', $obj->id, PDO::PARAM_STR);
					if($stmt->execute()){
						$mailfrom    = 'rezerwacje@paula-car.pl';  //jeśli domena dla Joomla jola.pl to email np. info@jola.pl
						$fromname    = 'Rezerwacje - Paula Car';

						if($obj->typeClient == 2){
							$sql = 'SELECT companies.name, companies.address, companies.postcode, companies.city, companies.NIP, companies.phone, companies.email,
							drivers.name AS driverName, drivers.surname AS driverSurname, drivers.address AS driverAddress, drivers.postcode AS driverPostcode,
							drivers.city AS driverCity, drivers.phone AS driverPhone, drivers.email AS driverEmail FROM companies INNER JOIN drivers ON drivers.id_companies = companies.id WHERE companies.NIP = "'.$obj->nip.'"';
							foreach ($pdo->query($sql) as $row) {
								$message = '
									<html>
									<head>
										<title>Potwierdzenie przyjęcia zamówienia numer:'.$reservationNumer.' </title>
									</head>
									<body>
										<p>Zamówienie numer: <strong>'.$reservationNumer.'</strong> zostało wprowadzone do bazy.</p>
										<p>Obecny stan zamówienia to: <strong>Oczekuje na płatność</strong></p>

										<h3>Szczegóły zamówienia: </h3>
										<h4><strong>Zamawiający: </strong></h4>
										<p>'.$row['name'].'</p>
										<p>'.$row['address'].'</p>
										<p>'.$row['postcode'].' '.$row['city'].'</p>
										<p>'.$row['NIP'].'</p>
										<p>'.$row['phone'].'</p>
										<p>'.$row['email'].'</p>
										<br><br>
										<h4>Kierowca</h4>
										<p>'.$row['driverName'].' '.$row['driverSurname'].'</p>
										<p>'.$row['driverAddress'].'</p>
										<p>'.$row['driverPostcode'].' '.$row['driverCity'].'</p>
										<p>'.$row['driverPhone'].'</p>
										<p>'.$row['driverEmail'].'</p>
										<br><br>

										<p>Płatności można dokonać przez platformę DotPay, na naszej stronie internetowej lub poprzez przelew tradycyjny</p>
										<h3><strong>Dane do przelewu:</strong></h3>
										<p><strong>Numer konta: </strong></p>
										<p><strong>Nazwa odbiorcy: </strong></p>
										<p><strong>Bank: </strong></p>
										<p><strong>Kwota: </strong>'.$obj->summaryPrice.' zł</p>
										<p><strong>Tytuł przelewu: </strong>Opłata za rezerwację numer: '.$reservationNumer.'</p>
										<br><br>
										Pozdrawiamy<br>
										<strong>Ekipa PaulaRentCar!</strong>
									</body>
									</html>
								';
							}
						}else{
							$sql = 'SELECT * FROM drivers WHERE pesel = '.$obj->pesel;
							foreach ($pdo->query($sql) as $row) {
								$message = '
									<html>
									<head>
										<title>Potwierdzenie przyjęcia zamówienia numer:'.$reservationNumer.' </title>
									</head>
									<body>
										<p>Zamówienie numer: <strong>'.$reservationNumer.'</strong> zostało wprowadzone do bazy.</p>
										<p>Obecny stan zamówienia to: <strong>Oczekuje na płatność</strong></p>

										<h3>Szczegóły zamówienia: </h3>
										<h4><strong>Zamawiający: </strong></h4>
										<p>'.$row['name'].' '.$row['surname'].'</p>
										<p>'.$row['address'].'</p>
										<p>'.$row['postcode'].' '.$row['city'].'</p>
										<p>'.$row['phone'].'</p>
										<p>'.$row['email'].'</p>
										<br><br>

										<p>Płatności można dokonać przez platformę DotPay, na naszej stronie internetowej lub poprzez przelew tradycyjny</p>
										<h3><strong>Dane do przelewu:</strong></h3>
										<p><strong>Numer konta: </strong></p>
										<p><strong>Nazwa odbiorcy: </strong></p>
										<p><strong>Bank: </strong></p>
										<p><strong>Kwota: </strong>'.$obj->summaryPrice.' zł</p>
										<p><strong>Tytuł przelewu: </strong>Opłata za rezerwację numer: '.$reservationNumer.'</p>
										<br><br>
										Pozdrawiamy<br>
										<strong>Ekipa PaulaRentCar!</strong>
									</body>
									</html>
								';
							}
						}

						$subject = "PaulaRentCar - Rezerwacja numer: ".$reservationNumer;
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers  .= 'Content-type: text/html; charset=utf-8' . "\r\n";
						$headers  .= 'From: '.$fromname .'<'.$mailfrom.'>'. "\r\n";

					 @mail($email, $subject, $message, $headers, '-f '.$mailfrom);
					 echo $reservationNumer;
					}
			}
		}else{
			echo "false";
		}
	}

?>
