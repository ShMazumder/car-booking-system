<?php

function sendMail($email){

	$mailfrom    = 'rezerwacje@paula-car.pl';  //jeśli domena dla Joomla jola.pl to email np. info@jola.pl
	$fromname    = 'Rezerwacje - Paula Car';


	$subject = "PaulaRentCar - Zamówienie numer: ".$_POST['control']." zostało opłacone!";
	$message = '
		<html>
		<head>
			<title>Zamówienie numer:"'.$_POST['control'].'" zmieniło status na Zapłacone"</title>
		</head>
		<body>
			<p>Zamówienie numer: <strong>'.$_POST['control'].'</strong></p>
			<p>Zmieniono status zamówienia z <strong>Do zapłaty</strong> na <strong>Zapłacone</strong></p>
			<p>Obecny status zamówienia to: <strong>Zapłacone</strong></p>
			<br/><br/>
			Pozdrawiamy<br>
			<strong>Ekipa PaulaRentCar!</strong>
		</body>
		</html>';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers  .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers  .= 'From: '.$fromname .'<'.$mailfrom.'>'. "\r\n";

	mail($email, $subject, $message, $headers, '-f '.$mailfrom);
}

if(isset($_POST)){
	if(isset($_POST['control'])){
		require_once("adminPanel/displayInfo.php");
		$pdo = connectDatabase();

		$paymentID = 0;
		foreach ($pdo->query('SELECT id FROM payments WHERE operation_number="'.$_POST['operation_number'].'"') as $row) {
			$paymentID = $row['id'];
		}

		//if($paymentID == 0){
			$stmt = $pdo->prepare("INSERT INTO payments VALUES (NULL, :nr_reservation, :operation_number, :operation_type, :operation_status,
				:operation_amount, :operation_currency, :operation_original_amount, :operation_original_currency,
				:operation_datetime, :control, :description, :email, :p_info, :p_email, :channel, :signature)");

				$stmt->bindValue(':nr_reservation', $_POST['control'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_number', $_POST['operation_number'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_type', $_POST['operation_type'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_status', $_POST['operation_status'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_amount', $_POST['operation_amount'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_currency', $_POST['operation_currency'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_original_amount', $_POST['operation_original_amount'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_original_currency', $_POST['operation_original_currency'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_datetime', $_POST['operation_datetime'], PDO::PARAM_STR);
				$stmt->bindValue(':control', $_POST['control'], PDO::PARAM_STR);
				$stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
				$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
				$stmt->bindValue(':p_info', $_POST['p_info'], PDO::PARAM_STR);
				$stmt->bindValue(':p_email', $_POST['p_email'], PDO::PARAM_STR);
				$stmt->bindValue(':channel', $_POST['channel'], PDO::PARAM_STR);
				$stmt->bindValue(':signature', $_POST['signature'], PDO::PARAM_STR);

				if($stmt->execute()){
					echo "OK";
					$stmt = $pdo->prepare("UPDATE reservations SET status='Zapłacone' WHERE reservation_nr='".$_POST['control']."'");
					if($stmt->execute()){
						foreach ($pdo->query('SELECT `company/person` AS type, id_driver FROM reservations WHERE reservation_nr="'.$_POST['control'].'"') as $row) {
							if($row['type'] == 1){
								foreach ($pdo->query('SELECT email FROM drivers WHERE id='.$row['id_driver']) as $row) {
									sendMail($row['email']);
								}
							}else if($row['type'] == 2){
								foreach ($pdo->query('SELECT companies.email AS email FROM companies INNER JOIN drivers ON drivers.id_copmanies = companies.id WHERE drivers.id='.$row['id_driver']) as $row) {
									echo $row['email'];
									sendMail($row['email']);
								}
							}
						}
					}
				}
		/*}else{
			$stmt = $pdo->prepare("UPDATE payments SET nr_reservation=:nr_reservation, operation_number=:operation_number, operation_type=:operation_type,
				operation_status=:operation_status, operation_amount=:operation_amount, operation_currency=:operation_currency, operation_original_amount=:operation_original_amount,
				operation_original_currency=:operation_original_currency, operation_datetime=:operation_datetime,
				control=:control, description=:description, email=:email, p_info=:p_info, p_email=:p_email, channel=:channel, signature=:signature WHERE nr_reservation='".$_POST['control']."'");
				$stmt->bindValue(':nr_reservation', $_POST['control'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_number', $_POST['operation_number'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_type', $_POST['operation_type'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_status', $_POST['operation_status'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_amount', $_POST['operation_amount'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_currency', $_POST['operation_currency'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_original_amount', $_POST['operation_original_amount'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_original_currency', $_POST['operation_original_currency'], PDO::PARAM_STR);
				$stmt->bindValue(':operation_datetime', $_POST['operation_datetime'], PDO::PARAM_STR);
				$stmt->bindValue(':control', $_POST['control'], PDO::PARAM_STR);
				$stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
				$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
				$stmt->bindValue(':p_info', $_POST['p_info'], PDO::PARAM_STR);
				$stmt->bindValue(':p_email', $_POST['p_email'], PDO::PARAM_STR);
				$stmt->bindValue(':channel', $_POST['channel'], PDO::PARAM_STR);
				$stmt->bindValue(':signature', $_POST['signature'], PDO::PARAM_STR);

				if($stmt->execute()){
					echo "OK";
				}
		}*/
	}
}

?>
