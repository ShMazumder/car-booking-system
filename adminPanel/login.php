<?php
	session_start();

	require_once("displayInfo.php");

	$pdo = connectDatabase();

	$login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
	$password = $_POST['password'];

	$stmt = $pdo->prepare("SELECT * FROM employees WHERE login = :login");
	$stmt->bindValue(':login', $login, PDO::PARAM_STR);

	if($stmt->execute())
	{
		if($stmt->rowCount() > 0)
		{
			$row = $stmt->fetch();

			if(password_verify($password, $row['password']))
			{
				$_SESSION['user'] = $row['login'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['permissions'] = $row['permissions'];
				$_SESSION['last_login'] = $row['last_login'];
				$_SESSION['is_logged'] = true;

				unset($_SESSION['error']);

				$pdo->query("UPDATE employees SET last_login=now()");
			}
			else
			{
				$_SESSION['error'] = "Nieprawidłowy login lub hasło";
			}
			$stmt->closeCursor();
		}
		else
		{
			$_SESSION['error'] = "Nieprawidłowy login lub hasło";
		}
	}

	exit(header('Location: ../adminPanel.php'));

?>