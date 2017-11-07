<?php

	require_once("displayInfo.php");

	function displayUsers(){
		$pdo = connectDatabase();

		if($stmt = $pdo->query("SELECT * FROM employees"))
		{
			if($stmt_count = $pdo->query("SELECT COUNT(*) AS 'count' FROM employees WHERE permissions='Administrator'"))
			{
				$row = $stmt_count->fetch();
				$admin_count = $row['count'];

				echo '<div class="results_div">
					<table class="table table-bordered results_table">
					<tr><th class="narrow_col">Lp.</th>
					<th>Imię</th>
					<th>Nazwisko</th>
					<th>Login</th>
					<th>Ostatnie logowanie</th>
					<th>Grupa</th>
					<th class="narrow_col">Edytuj</th>
					<th class="narrow_col">Usuń</th></tr>';

				for($i = 1; $row = $stmt->fetch(); $i++)
				{
					echo '<tr class="results_row">';

					echo '<td>'.$i.'.</td>';
					echo '<td>'.$row['name'].'</td>';
					echo '<td>'.$row['surname'].'</td>';
					echo '<td>'.$row['login'].'</td>';
					echo '<td>'.$row['last_login'].'</td>';
					echo '<td>'.$row['permissions'].'</td>';
					echo '<td><a class="btn btn-default" href="adminPanel.php?subpage=Users&action=edit&id='.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>';
					echo '<td>';
					if(!($admin_count <= 1 && $row['permissions'] == "Administrator"))
						echo '<a class="btn btn-default" href="adminPanel.php?subpage=Users&action=delete&id='.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a>';
					echo '</td>';

					echo '</tr>';
				}

				echo '<tr><td><a href="adminPanel.php?subpage=Users&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>
						</a></td></tr>';

				echo '</table></div>';
				$stmt_count->closeCursor();
			}
			$stmt->closeCursor();
		}
		else
			throw new PDOException("SQL Error");
	}

	function getUser($id){
		$pdo = connectDatabase();

		$stmt = $pdo->prepare("SELECT id, name, surname, login, permissions FROM employees WHERE id=:id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		if($stmt->execute())
			return $stmt->fetch();
		else
			return false;
	}


	function addUser($name, $surname, $login, $password, $password2, $permissions){
		if(strlen($login) < 4 || strlen($login) > 20)
			$_SESSION['error'] = "Login musi mieć od 4 do 20 znaków";
		else
		{
			if(ctype_alnum($login) == false)
				$_SESSION['error'] = "Można używać tylko znaki alfanumeryczne";
			else
			{
				if(strlen($password) < 4)
					$_SESSION['error'] = "Haslo musi miec co najmiej 4 znaki";
				else
				{
					if($password2 != $password)
						$_SESSION['error'] = "Hasła nie są takie same";
					else
					{
						$pdo = connectDatabase();

						$stmt = $pdo->prepare("SELECT * FROM employees WHERE login=:login");
						$stmt->bindValue(':login', $login, PDO::PARAM_STR);
						if($stmt->execute())
						{
							if($stmt->rowCount() > 0)
							{
								$_SESSION['error'] = "Istnieje już użytkownik z takim loginem";
								$stmt->closeCursor();
							}
							else
							{
								$stmt->closeCursor();

								$hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

								$stmt = $pdo->prepare("INSERT INTO employees VALUES(NULL, :name, :surname, :login, :hash_password, NULL, :permissions)");
								$stmt->bindValue(':name', $name, PDO::PARAM_STR);
								$stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
								$stmt->bindValue(':login', $login, PDO::PARAM_STR);
								$stmt->bindValue(':hash_password', $hash_password, PDO::PARAM_STR);
								$stmt->bindValue(':permissions', $permissions, PDO::PARAM_STR);

								if($stmt->execute())
									return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	function deleteUser($id){
		$pdo = connectDatabase();

		$stmt = $pdo->prepare("DELETE FROM employees WHERE id=:id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		if($stmt->execute())
			return true;
		else
			return false;
	}

	function editUser($id, $name, $surname, $login, $password, $password2, $permissions){
		if(empty($id) && empty($login) && empty($permissions))
			$_SESSION['error'] = "Nie wypełniono wszystkich pól";
		else
		{
			if(strlen($login) < 4 || strlen($login) > 20)
				$_SESSION['error'] = "Login musi mieć od 4 do 20 znaków";
			else
			{
				if(ctype_alnum($login) == false)
					$_SESSION['error'] = "Można używać tylko znaki alfanumeryczne";
				else
				{
					if(strlen($password) < 4 && (!empty($password) || !empty($password2)))
						$_SESSION['error'] = "Haslo musi miec co najmiej 4 znaki";
					else
					{
						if($password2 != $password && (!empty($password) || !empty($password2)))
							$_SESSION['error'] = "Hasła nie są takie same";
						else
						{
							$pdo = connectDatabase();

							$stmt = $pdo->prepare("SELECT * FROM employees WHERE login=:login");
							$stmt->bindValue(':login', $login, PDO::PARAM_STR);
							if($stmt->execute())
							{
								if($stmt->rowCount() > 0)
								{
									$_SESSION['error'] = "Istnieje już użytkownik z takim loginem";
									$stmt->closeCursor();
								}
								else
								{
									$stmt->closeCursor();

									$hash_password = password_hash($password, PASSWORD_DEFAULT);

									$sql = "UPDATE employees SET name=:name, surname=:surname, login=:login, ";
									if(!empty($password))
										$sql .= "password=:hash_password, ";
									$sql .= "permissions=:permissions WHERE id=:id";

									$stmt = $pdo->prepare($sql);
									$stmt->bindValue(':name', $name, PDO::PARAM_STR);
									$stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
									$stmt->bindValue(':login', $login, PDO::PARAM_STR);
									if(!empty($password))
										$stmt->bindValue(':hash_password', $hash_password, PDO::PARAM_STR);
									$stmt->bindValue(':permissions', $permissions, PDO::PARAM_STR);
									$stmt->bindValue(':id', $id, PDO::PARAM_INT);

									if($stmt->execute())
										return true;
								}
							}
						}
					}
				}
			}
		}
		return false;
	}

	function changePassword($id, $password, $password2){
		if(strlen($password) < 4)
			$_SESSION['error'] = "Haslo musi miec co najmiej 4 znaki";
		else
		{
			if($password2 != $password)
				$_SESSION['error'] = "Hasła nie są takie same";
			else
			{
				$pdo = connectDatabase();

				$hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

				$stmt = $pdo->prepare("UPDATE employees SET password=:hash_password WHERE id=:id");
				$stmt->bindValue(':hash_password', $hash_password, PDO::PARAM_STR);
				$stmt->bindValue(':id', $id, PDO::PARAM_INT);

				if($stmt->execute())
					return true;
			}
		}
		return false;
	}

?>