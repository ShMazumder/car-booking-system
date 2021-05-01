<?php

    function createDriver($checkS)
    {
        require_once("adminPanel/displayInfo.php");
        $pdo = connectDatabase();

        $id_driver = "";
        $stmt = $pdo->prepare('SELECT id FROM drivers WHERE pesel=:pesel');
        $stmt->bindValue(':pesel', $_POST['reservationFormPesel'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            for ($i = 1; $row = $stmt->fetch(); $i++) {
                $id_driver = $row['id'];
            }
        }

        $id_comp = null;
        if (isset($_POST['reservationFormBusinessNIP'])) {
            $stmt = $pdo->prepare('SELECT id FROM companies WHERE NIP=:nip');
            $stmt->bindValue(':nip', $_POST['reservationFormBusinessNIP'], PDO::PARAM_INT);
            if ($stmt->execute()) {
                for ($i = 1; $row = $stmt->fetch(); $i++) {
                    $id_comp = $row['id'];
                }
            }
        }

        if ($id_driver != "") {
            $stmt = $pdo->prepare("UPDATE drivers SET name=:name, id_companies=:id_companies, surname=:surname, pesel=:pesel, ident_card=:ident_card, driving_licence=:driving_licence, address=:address, postcode=:postcode, city=:city, country=:country, phone=:phone, email=:email WHERE id=:id_driver");
            $stmt->bindValue(':name', $_POST['reservationFormName'], PDO::PARAM_STR);
            $stmt->bindValue(':id_companies', $id_comp, PDO::PARAM_STR);
            $stmt->bindValue(':surname', $_POST['reservationFormSurname'], PDO::PARAM_STR);
            $stmt->bindValue(':pesel', $_POST['reservationFormPesel'], PDO::PARAM_STR);
            $stmt->bindValue(':ident_card', $_POST['reservationFormIDCard'], PDO::PARAM_STR);
            $stmt->bindValue(':driving_licence', $_POST['reservationFormDriveLicense'], PDO::PARAM_STR);
            $stmt->bindValue(':address', $_POST['reservationFormAddress'], PDO::PARAM_STR);
            $stmt->bindValue(':postcode', $_POST['reservationFormPost'], PDO::PARAM_STR);
            $stmt->bindValue(':city', $_POST['reservationFormCity'], PDO::PARAM_STR);
            $stmt->bindValue(':country', $_POST['reservationFormCountry'], PDO::PARAM_STR);
            $stmt->bindValue(':phone', $_POST['reservationFormTelephone'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $_POST['reservationFormEmail'], PDO::PARAM_STR);
            $stmt->bindValue(':id_driver', $id_driver, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return true;
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO drivers VALUES (NULL, :id_companies, :name, :surname, :pesel, :ident_card, :driving_licence, :address, :postcode, :city, :country, :phone, :email)");
            $stmt->bindValue(':id_companies', $id_comp, PDO::PARAM_STR);
            $stmt->bindValue(':name', $_POST['reservationFormName'], PDO::PARAM_STR);
            $stmt->bindValue(':surname', $_POST['reservationFormSurname'], PDO::PARAM_STR);
            $stmt->bindValue(':pesel', $_POST['reservationFormPesel'], PDO::PARAM_STR);
            $stmt->bindValue(':ident_card', $_POST['reservationFormIDCard'], PDO::PARAM_STR);
            $stmt->bindValue(':driving_licence', $_POST['reservationFormDriveLicense'], PDO::PARAM_STR);
            $stmt->bindValue(':address', $_POST['reservationFormAddress'], PDO::PARAM_STR);
            $stmt->bindValue(':postcode', $_POST['reservationFormPost'], PDO::PARAM_STR);
            $stmt->bindValue(':city', $_POST['reservationFormCity'], PDO::PARAM_STR);
            $stmt->bindValue(':country', $_POST['reservationFormCountry'], PDO::PARAM_STR);
            $stmt->bindValue(':phone', $_POST['reservationFormTelephone'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $_POST['reservationFormEmail'], PDO::PARAM_STR);
            if ($stmt->execute()) {
                return true;
            }
        }
    }

    function createBusiness()
    {
        require_once("adminPanel/displayInfo.php");
        $pdo = connectDatabase();
        $id_companies = "";

        $stmt = $pdo->prepare('SELECT id FROM companies WHERE NIP=:nip');
        $stmt->bindValue(':nip', $_POST['reservationFormBusinessNIP'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            for ($i = 1; $row = $stmt->fetch(); $i++) {
                $id_companies = $row['id'];
            }
        }

        if ($id_companies != "") {
            $stmt = $pdo->prepare("UPDATE companies SET name=:name, address=:address, postcode=:postcode, city=:city, NIP=:nip, phone=:phone, email=:email WHERE id=:id_companies");
            $stmt->bindValue(':name', $_POST['reservationFormBusinessName'], PDO::PARAM_STR);
            $stmt->bindValue(':address', $_POST['reservationFormBusinessAddress'], PDO::PARAM_STR);
            $stmt->bindValue(':postcode', $_POST['reservationFormBusinessPost'], PDO::PARAM_STR);
            $stmt->bindValue(':city', $_POST['reservationFormBusinessCity'], PDO::PARAM_STR);
            $stmt->bindValue(':nip', $_POST['reservationFormBusinessNIP'], PDO::PARAM_STR);
            $stmt->bindValue(':phone', $_POST['reservationFormBusinessTelephone'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $_POST['reservationFormBusinessEmail'], PDO::PARAM_STR);
            $stmt->bindValue(':id_companies', $id_companies, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return true;
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO companies VALUES (NULL, :name, :address, :postcode, :city, :nip, :phone, :email)");
            $stmt->bindValue(':name', $_POST['reservationFormBusinessName'], PDO::PARAM_STR);
            $stmt->bindValue(':address', $_POST['reservationFormBusinessAddress'], PDO::PARAM_STR);
            $stmt->bindValue(':postcode', $_POST['reservationFormBusinessPost'], PDO::PARAM_STR);
            $stmt->bindValue(':city', $_POST['reservationFormBusinessCity'], PDO::PARAM_STR);
            $stmt->bindValue(':nip', $_POST['reservationFormBusinessNIP'], PDO::PARAM_STR);
            $stmt->bindValue(':phone', $_POST['reservationFormBusinessTelephone'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $_POST['reservationFormBusinessEmail'], PDO::PARAM_STR);
            if ($stmt->execute()) {
                return true;
            }
        }
    }

    function displaySite()
    {
        include("header.php");
        getHeader("Car rental - Payment", "mainCss.css;reservationSummary.css");
        include("menu.php");

        echo "
		<div id='reservationContError' class='container'>
			<div class='row'>
				<div class='col-md-12'>
					<br><br>
					<h1>EROR 404 - PAGE NOT FOUND</h1>
					<br>
					<h2>This page is not available!</h2>
				</div>
			</div>
		</div>

		<div id='reservationCont' class='container'>
			<div class='row'>
				<div id='summaryImage' class='col-lg-12'>
					<img src='images/podsumowanie/4.png' class='img-responsive'>
				</div>
			</div>

				<div class='row'>
					<h1>Booking information:</h1><br>
					<div class='col-md-12' style='text-align: center'>
						<div class='col-md-6'>
							<h4><strong>Reception:</strong> <span id='receptionPlaceReservation'></span></h4>
						</div>
						<div class='col-md-6'>
							<h4><strong>Data:</strong> <span id='receptionDateReservation'></span>  <span id='receptionTimeReservation'></span></h4>
						</div>
					</div>

					<div class='col-md-12' style='text-align: center'>
						<div class='col-md-6'>
							<h4><strong>Return:</strong> <span id='returnPlaceReservation'></span></h4>
						</div>
						<div class='col-md-6'>
							<h4><strong>Data:</strong> <span id='returnDateReservation'></span>  <span id='returnTimeReservation'></span></h4>
						</div>
					</div>
				</div>
				<br><br><br>
			<div class='row'>
				<div class='col-lg-5 col-md-5 carRow col-sm-12 col-xs-12 hidden-sm hidden-xs'>
					<div class='row'>
						<div class='carInfoHeader col-md-8'>
							<h3 id='carReservationName'></h3>
						</div>
					</div>
					<div class='row'>
						<div class='carInfoImage col-md-12'>
							<img id='imageReservation' src='' alt='' class='img-responsive'>
						</div>
					</div>
					<div id='fullPrice' class='row'>
						<h2>Total cost: </h2>
						<h3 class='price' id='lastPriceReservation'></h3>
					</div>
				</div>";


        if ($_POST['typeForm'] == "private") {
            echo "
						<div class='col-md-offset-1 col-lg-offset-1 col-lg-5 col-md-5 col-sm-12 col-xs-12'>
							<h3><i class='fa fa-table' aria-hidden='true'></i> Ordering party's data: </h3>
							<br><p id='identTypeClient' type-client='1'><strong>Type: </strong><span>Private person</span></p>
							<p><strong>First name and last name: </strong><span>".$_POST['reservationFormName']." ".$_POST['reservationFormSurname']."</span></p>
							<p><strong>Pesel number: </strong> <span id='peselNumberGet'>".$_POST['reservationFormPesel']."</span></p>
							<p><strong>ID number and series: </strong> <span>".$_POST['reservationFormIDCard']."</span></p>
							<p><strong>Driver's license number: </strong> <span>".$_POST['reservationFormDriveLicense']."</span></p>
							<p><strong>Address: </strong> <span>".$_POST['reservationFormAddress']."</span></p>
							<p><strong>Post Office: </strong> <span>".$_POST['reservationFormPost']." ".$_POST['reservationFormCity']."</span></p>
							<p><strong>Region: </strong> <span>".$_POST['reservationFormCountry']."</span></p>
							<p><strong>Telephone: </strong> <span>".$_POST['reservationFormTelephone']."</span></p>
							<p><strong>Email: </strong> <span id='emailAddress'>".$_POST['reservationFormEmail']."</span></p><br>
							<br><br>
						</div>

						<div class='col-lg-12 col-md-12' id='dotpayDiv'>
							<input type='button' value='Pay for the booking!' class='price ccbtn payBut' id='dotPayButton'/>
							<br><br>
							<img src='images/dotpay.png' alt='' class='img-responsive'>
						</div>
					</div>
				</div>";
        } elseif ($_POST['typeForm'] == "business") {
            echo "
					<div class='col-md-offset-1 col-lg-offset-1 col-lg-5 col-md-5 col-sm-12 col-xs-12'>
						<h3><i class='fa fa-table' aria-hidden='true'></i> Dane zamawiającego: </h3>
						<br><p id='identTypeClient' type-client='2' ><strong><span>Rodzaj: </strong>Firma</span></p>
						<p><strong>Nazwa: </strong><span>".$_POST['reservationFormBusinessName']."</span></p>
						<p><strong>Adres: </strong><span>".$_POST['reservationFormBusinessAddress']."</span></p>
						<p><strong>Poczta: </strong><span>".$_POST['reservationFormBusinessPost']." ".$_POST['reservationFormBusinessCity']."</span></p>
						<p><strong>NIP: </strong><span id='nipNumberGet'>".$_POST['reservationFormBusinessNIP']."</span></p>
						<p><strong>Telefon: </strong><span>".$_POST['reservationFormBusinessTelephone']."</span></p>
						<p><strong>Adres e-mail: </strong><span id='emailCompanyAddress'>".$_POST['reservationFormBusinessEmail']."</span></p>

						<br><br><h4>Dane kierowcy:</h4>
						<p><strong>Imię i nazwisko: </strong><span>".$_POST['reservationFormName']." ".$_POST['reservationFormSurname']."</span></p>
						<p><strong>Numer Pesel: </strong><span id='peselNumberGet'>".$_POST['reservationFormPesel']."</span></p>
						<p><strong>Numer i seria dowodu osobistego: </strong><span>".$_POST['reservationFormIDCard']."</span></p>
						<p><strong>Numer prawa jazdy: </strong><span>".$_POST['reservationFormDriveLicense']."</span></p>
						<p><strong>Adres: </strong><span>".$_POST['reservationFormAddress']."</span></p>
						<p><strong>Poczta: </strong><span>".$_POST['reservationFormPost']." ".$_POST['reservationFormCity']."</span></p>
						<p><strong>Kraj: </strong><span>".$_POST['reservationFormCountry']."</span></p>
						<p><strong>Telefon: </strong><span>".$_POST['reservationFormTelephone']."</span></p>
						<p><strong>Adres e-mail: </strong><span id='emailAddress'>".$_POST['reservationFormEmail']."</span></p><br>
						<p><input type='checkbox' name='faktura' value='true' id='faktura'> <label for='faktura'><strong>Proszę o wystawienie faktury VAT </strong></label></p>
						<br><br>
					</div>

					<div class='col-lg-12 col-md-12' id='dotpayDiv'>
						<input type='button' value='Pay for the booking!' class='price ccbtn payBut' id='dotPayButton'/>
						<br><br>
						<img src='images/dotpay.png' alt='' class='img-responsive'>
					</div>
				</div>
			</div>";
        }


        include("footer.php");
    }

    if (isset($_POST)) {
        if ($_POST['typeForm'] == "private") {
            if (createDriver(0)) {
                displaySite();
            }
        } elseif ($_POST['typeForm'] == "business") {
            if (createBusiness()) {
                if (createDriver(1)) {
                    displaySite();
                }
            }
        }
    }
