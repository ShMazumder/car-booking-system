<?php

	if(isset($_GET['type'])){
		if($_GET['type'] == "home"){

			$homeNameForm = $_POST['homeNameForm'];
			$homeEmailForm = $_POST['homeEmailForm'];
			$homeMobileForm = $_POST['homeMobileForm'];
			$homeSubjectForm = $_POST['homeSubjectForm'];
			$homeTextForm = $_POST['homeTextForm'];

			if(trim($homeNameForm) == ' ') {
				header("Location: ../index.php?type=bx067");
			}else if(trim($homeEmailForm) == ' '){
				header("Location: ../index.php?type=bx067");
			}else if(trim($homeMobileForm) == ' '){
				header("Location: ../index.php?type=bx067");
			}else if(trim($homeSubjectForm) == ' '){
				header("Location: ../index.php?type=bx067");
			}else if(trim($homeTextForm) == ' '){
				header("Location: ../index.php?type=bx067");
			}

			$mailfrom    = 'formularz@paula-car.pl';  //jeśli domena dla Joomla jola.pl to email np. info@jola.pl
			$fromname    = 'Formularz Paula Car';
			$subject = "PaulaRentCar - Formularz Zapytanie";

			$message = '
			<html>
			<head>
			  <title>'.$homeSubjectForm.'</title>
			</head>
			<body>
			  <p><strong>Wiadomość od:</strong>'.$homeNameForm.'</p>
				<p><strong>Email:</strong>'.$homeEmailForm.'</p>
				<p><strong>Telefon:</strong>'.$homeMobileForm.'</p>
			  <p><strong>Tekst:</strong>'.$homeTextForm.'</p>
			</body>
			</html>
			';

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers  .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers  .= 'From: '.$fromname .'<'.$mailfrom.'>'. "\r\n";

			if(mail('michal.sloboda@paula-car.pl', $subject, $message, $headers, '-f '.$mailfrom)){
				header("Location: ../index.php?type=bx066");
			}else{
				header("Location: ../index.php?type=bx068");
			}
		}else if($_GET['type'] == "offer"){

						$offerNameForm = $_POST['offerNameForm'];
						$offerEmailForm = $_POST['offerEmailForm'];
						$offerMobileForm = $_POST['offerMobileForm'];
						$offerCountForm = $_POST['offerCountForm'];
						$offerLimitForm = $_POST['offerLimitForm'];
						$offerTextForm = $_POST['offerTextForm'];

						if(trim($offerNameForm) == ' ') {
							header("Location: ../oferta.php?type=dlugiTermin&bad=bx067");
						}else if(trim($offerEmailForm) == ' '){
							header("Location: ../oferta.php?type=dlugiTermin&bad=bx067");
						}else if(trim($offerMobileForm) == ' '){
							header("Location: ../oferta.php?type=dlugiTermin&bad=bx067");
						}else if(trim($offerCountForm) == ' '){
							header("Location: ../oferta.php?type=dlugiTermin&bad=bx067");
						}else if(trim($offerLimitForm) == ' '){
							header("Location: ../oferta.php?type=dlugiTermin&bad=bx067");
						}else if(trim($offerTextForm) == ' '){
							header("Location: ../oferta.php?type=dlugiTermin&bad=bx067");
						}

						$mailfrom    = 'formularz@paula-car.pl';  //jeśli domena dla Joomla jola.pl to email np. info@jola.pl
				    $fromname    = 'Formularz Paula Car';

						$subject = "PaulaRentCar - Formularz Oferta";
						$message = '
						<html>
						<head>
							<title>PaulaRentCar - Formularz Zapytanie o Ofertę</title>
						</head>
						<body>
							<p><strong>Wiadomość od: </strong>'.$offerNameForm.'</p>
							<p><strong>Email: </strong>'.$offerEmailForm.'</p>
							<p><strong>Telefon: </strong>'.$offerMobileForm.'</p>
							<p><strong>Ilość samochodów: </strong>'.$offerCountForm.'</p>
							<p><strong>Limit kilometrów: </strong>'.$offerLimitForm.'</p>
							<p><strong>Tekst: </strong>'.$offerTextForm.'</p>
						</body>
						</html>
						';

				    $headers  = 'MIME-Version: 1.0' . "\r\n";
				    $headers  .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				    $headers  .= 'From: '.$fromname .'<'.$mailfrom.'>'. "\r\n";

				   if(mail('michal.sloboda@paula-car.pl', $subject, $message, $headers, '-f '.$mailfrom)){
						 header("Location: ../oferta.php?type=dlugiTermin&bad=bx066");
					 }else{
						 header("Location: ../oferta.php?type=dlugiTermin&bad=bx068");
					 }
		}
	}

?>
