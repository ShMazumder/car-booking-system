<?php
    function connectDatabase()
    {
        $mysql_host = 'localhost';
        $port = '3306';
        $username = 'root';
        $password = '';
        $database = 'car_rental_system_db';

        try {
            $pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$database.';port='.$port, $username, $password);
            $pdo -> query('SET NAMES utf8');
            $pdo -> query('SET CHARACTER_SET utf8_polish_ci');
            $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function printBodyType()
    {
        $pdo = connectDatabase();
        foreach ($pdo->query('SELECT * FROM body_type') as $row) {
            echo '
					<div class="col-md-3 col-sm-6 col-xs-6">
						<div class="checkCar checkDisabled" id="checkCar'.$row['id'].'">'.$row['name'].'</div>
					</div>
				';
        }
        $pdo = null;
    }

    function printPriceClass()
    {
        $pdo = connectDatabase();
        foreach ($pdo->query('SELECT * FROM price_class') as $row) {
            echo '
					<div class="col-md-3 col-sm-6 col-xs-6">
						<div class="checkClass checkClassDisabled" id="checkClass'.$row['id'].'">'.$row['name'].'</div>
					</div>
				';
        }
        $pdo = null;
    }

    function printCars()
    {
        $pdo = connectDatabase();
        foreach ($pdo->query('SELECT cars.id, cars.name, price_class.fifteen AS price, body_type.name AS body_type, price_class.name AS price_class, price_class.bail AS bailPrice FROM cars INNER JOIN price_class ON cars.price_class = price_class.id INNER JOIN body_type ON cars.body_type = body_type.id') as $row) {
            echo '
				<div class=" col-md-6 carRow" data-car-type="'.$row['body_type'].'" data-car-class="'.$row['price_class'].'">
					<div class="row">
						<div class="carInfoHeader col-md-8">
							<h3><a href="samochod.php?id='.$row['id'].'">'.$row['name'].'</a></h3>
						</div>
						<div class="carInfoPrice col-md-4">
							<h4><span class="priceColor">Od '.$row['price'].' zł</span><br>
							netto</h4>
						</div>
					</div>
					<div class="row">
						<div class="carInfoClass col-md-4">
							'.$row['body_type'].' - Klasa: '.$row['price_class'].'
						</div>
						<div class="carInfoAdd col-md-8">
							Kaucja zwrotna '.$row['bailPrice'].' zł brutto
						</div>
					</div>
					<div class="row">
						<div class="carInfoImage col-md-12">
							<a href="samochod.php?id='.$row['id'].'"> <img src="images/samochody/modele/'.str_replace(" ", "", strtolower($row['name'])).'.png" alt="'.$row['name'].'" class="img-responsive"></a>
						</div>
					</div>
					<div class="row">
						<a class="carInfoButton disabledButton" href="samochod.php?id='.$row['id'].'">Więcej</a>
					</div>
				</div>
			';
        }
        $pdo = null;
    }

    function loadSmallImage($id, $name)
    {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("SELECT id_car, nr_img, extension FROM images where id_car=:id_car");
        $stmt->bindValue(':id_car', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $count = 1;
            for ($i = 1; $row = $stmt->fetch(); $i++) {
                if ($count > 1) {
                    echo '
					<li data-slide-to="'.$count.'" data-target="#article-photo-carousel">
						<img alt="'.$name.'" src="images/samochody/'.$row['id_car'].'_'.$row['nr_img'].'.'.$row['extension'].'" class="img-responsive smallImageCar">
					</li>';
                }
                $count++;
            }
        }
        $pdo = null;
        $stmt->closeCursor();
    }

    function loadFirstImage($id)
    {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("SELECT id_car, nr_img, extension FROM images where id_car=:id_car LIMIT 0,1");
        $stmt->bindValue(':id_car', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            for ($i = 1; $row = $stmt->fetch(); $i++) {
                $returnTab = [$row['id_car'], $row['nr_img'], $row['extension']];
            }
        }
        $pdo = null;
        $stmt->closeCursor();
        return $returnTab;
    }

    function printOneCarInfo($id)
    {
        $pdo = connectDatabase();
        $stmt = $pdo->prepare("SELECT cars.id, cars.name, manufacture_year, varnish_color, nr_of_seats, engine, engine_power, drive, gear_type, mileage, description, start_date, end_date, body_type.name AS body_type, price_class.name AS price_class FROM cars LEFT JOIN reservations ON cars.id = reservations.id_car INNER JOIN price_class ON cars.price_class = price_class.id INNER JOIN body_type ON cars.body_type = body_type.id WHERE cars.id=:id_car");
        $stmt->bindValue(':id_car', $id, PDO::PARAM_INT);
        $count = 0;
        if ($stmt->execute()) {
            for ($i = 1; $row = $stmt->fetch(); $i++) {
                if ($count < 1) {
                    echo '
						<div class="container">
							<div class="page-header">
								<h1 id="carName" data-car-id="'.$row['id'].'">'.$row['name'].'</h1>
							</div>
							<div class="row">
								<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
									<div class="carousel slide article-slide" id="article-photo-carousel">
										<div class="carousel-inner cont-slider">';
                    $returnTab  = loadFirstImage($id);
                    echo '
											<div class="item active">
												<img id="mainCarImage" alt="'.$row['name'].'" src="images/samochody/'.$returnTab[0].'_'.$returnTab[1].'.'.$returnTab[2].'" class="img-responsive">
											</div>
										</div>
										<ol class="carousel-indicators">
											<li class="" data-slide-to="0" data-target="#article-photo-carousel">
												<img alt="'.$row['name'].'" src="images/samochody/'.$returnTab[0].'_'.$returnTab[1].'.'.$returnTab[2].'" class="img-responsive smallImageCar">
											</li>';
                    loadSmallImage($id, $row['name']);
                    echo '</ol>
									</div>
								</div>

								<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
									<h3><i class="fa fa-table" aria-hidden="true"></i> Dane techniczne</h3>
									<table class="table table-hover table-condensed table-responsive" id="dane_tech">
										<tr>
											<td>Rok produkcji</td>
											<td>'.$row['manufacture_year'].'</td>
										</tr>
										<tr>
											<td>Kolor lakieru</td>
											<td>'.$row['varnish_color'].'</td>
										</tr>
										<tr>
											<td>Liczba miejsc</td>
											<td>'.$row['nr_of_seats'].'</td>
										</tr>
										<tr>
											<td>Silnik</td>
											<td>'.$row['engine'].'</td>
										</tr>
										<tr>
											<td>Moc silnika</td>
											<td>'.$row['engine_power'].'</td>
										</tr>
										<tr>
											<td>Napęd</td>
											<td>'.$row['drive'].'</td>
										</tr>
										<tr>
											<td>Rodzaj skrzyni</td>
											<td>'.$row['gear_type'].'</td>
										</tr>
										<tr>
											<td>Rodzaj nadwozia</td>
											<td>'.$row['body_type'].'</td>
										</tr>
										<tr>
											<td>Przebieg</td>
											<td>'.$row['mileage'].'</td>
										</tr>
									</table>
									<input type="button" value="Zarezerwuj!" class="ccbtn" id="reserve"/>
								</div>
							</div>

							<hr/>

							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h3>Opis</h3>
									<p class="text-justify">'.$row['description'].'
									</p>
								</div>
							</div>
							<div class="margin"></div>
						</div>
					';
                    $count++;
                }
                echo "<input type='hidden' class='datas' value='".$row['start_date'].")".$row['end_date']."'/>";
            }
        }
        $pdo = null;
        $stmt->closeCursor();
    }

    function displayCarouselCar()
    {
        $pdo = connectDatabase();
        $i = 0;
        $k = 0;
        $l = 2;
        foreach ($pdo->query('SELECT id, name FROM cars') as $row) {
            if ($i == $k) {
                if ($i == 0) {
                    echo '<div class="active item">';
                } else {
                    echo '<div class="item">';
                }
                $k+=3;
            }

            echo
                '	<div class="col-md-4 col-xs-4 carSmallItem">
						<a href="samochod.php?id='.$row['id'].'"> <img src="images/samochody/modele/'.str_replace(" ", "", strtolower($row['name'])).'.png" alt="'.$row['name'].'" class="img-responsive"></a>
						<p>'.$row['name'].'</p>
					</div>
			';

            if ($i == $l) {
                echo "	</div>";
                $l += 3;
            }

            $i++;
        }
        $pdo = null;
    }

    function displayFormInfo($type)
    {
        switch ($type) {
                case 'bx066':
                    echo "<script>swal(
								'Wysłano!',
								'Wiadomość została wysłana!',
								'success'
							)</script>";
                    break;
                case 'bx068':
                    echo "<script>swal(
								'Oops...',
								'Wysyłanie nie powiodło się. Spróbuj ponownie później.',
								'error'
							)</script>";
                    break;
                case 'bx067':
                    echo "<script>swal(
								'Oops...',
								'Wprowadzone dane są błędne',
								'error'
							)</script>";
                    break;
            }
    }

    function displayLongListCar()
    {
        $pdo = connectDatabase();
        $count = 0;
        foreach ($pdo->query('SELECT id, name FROM cars') as $row) {
            if ($count == 0) {
                echo '
					<option selected value="'.str_replace(" ", "", strtolower($row['name'])).';'.$row['id'].'">'.$row['name'].'</option>
				';
            } else {
                echo '
					<option value="'.str_replace(" ", "", strtolower($row['name'])).';'.$row['id'].'">'.$row['name'].'</option>
				';
            }
            $count++;
        }
        $pdo=null;
    }

    function displayPlaces()
    {
        $pdo = connectDatabase();
        $count = 0;
        foreach ($pdo->query('SELECT name, city, address FROM localizations') as $row) {
            if ($count == 0) {
                echo '
					<option selected value="',$row['name'].'">'.$row['city'].', '.$row['address'].'</option>
				';
            } else {
                echo '
					<option value="',$row['name'].'">'.$row['city'].', '.$row['address'].'</option>
				';
            }
        }
        $pdo=null;
    }

    function displayAdditionItems()
    {
        $pdo = connectDatabase();
        foreach ($pdo->query('SELECT id, name, price FROM additional_fees') as $row) {
            echo '
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
						<input type="checkbox" data-price="'.$row['price'].'" data-id="'.$row['id'].'" class="additionCheckBox" id="checkBoxAddition_'.$row['id'].'" name="addition_'.$row['id'].'" />
						<label for="addition_'.$row['id'].'"><h5>'.$row['name'].'</h5></label>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><h5 class="price additionItemPrice">'.$row['price'].' zł</h5></div>
			';
        }
        $pdo=null;
    }
