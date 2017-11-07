<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	if(isset($_SESSION['permissions']) && $_SESSION['permissions'] != "Administrator")
	{
		echo("<script>location.href = 'adminPanel.php';</script>");
		exit();
	}
	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("usersMngFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Użytkownicy</h3>
			</div>';
		echo '<a href="adminPanel.php?subpage=Users&action=add" class="btn btn-default action-btn">Dodaj użytkownika</a>
			<hr/>';

		displayUsers();
	}
	else if($_GET['action'] == "add")
	{

		echo '<div class="page-header">
			<h3>Dodawanie użytkownika</h3>
			</div>';
		echo '
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" action="adminPanel/action.php?subpage=Users&action=add" autocomplete="off">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Imię: </label>
					<input type="text" class="form-control" id="name_input" name="name">
				</div>
				<div class="form-group">
					<label for="login_input" class="tytul_input">Nazwisko: </label>
					<input type="text" class="form-control" id="surname_input" name="surname">
				</div>
				<div class="form-group">
					<label for="login_input" class="tytul_input">Login: </label>
					<input type="text" class="form-control" id="login_input" name="login">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="password_input">Hasło: </label>
					<input type="password" class="form-control" id="password_input" name="password">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="password2_input">Powtórz hasło: </label>
					<input type="password" class="form-control" id="password2_input" name="password2">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="group_input">Prawa: </label>
					<select class="form-control" id="group_input" name="permissions">
				      <option>Administrator</option>
				      <option>Moderator</option>
				    </select>
			    </div>
			    
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=Users" class="btn btn-default">Anuluj</a>
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
	else if($_GET['action'] == "edit" && isset($_GET['id']))
	{

		$user = getUser($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie użytkownika</h3>
			</div>';
		echo '
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" action="adminPanel/action.php?subpage=Users&action=edit&id='.$_GET['id'].'" autocomplete="off">
				<div class="form-group">
					<label for="login_input" class="tytul_input">Imię: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$user['name'].'">
				</div>
				<div class="form-group">
					<label for="login_input" class="tytul_input">Nazwisko: </label>
					<input type="text" class="form-control" id="surname_input" name="surname" value="'.$user['surname'].'">
				</div>
				<div class="form-group">
					<label for="login_input" class="tytul_input">Login: </label>
					<input type="text" class="form-control" id="login_input" name="login" value="'.$user['login'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="password_input">Hasło: </label>
					<input type="password" class="form-control" id="password_input" name="password">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="password2_input">Powtórz hasło: </label>
					<input type="password" class="form-control" id="password2_input" name="password2">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="group_input">Prawa: </label>
					<select class="form-control" id="group_input" name="permissions">
				      <option';
				      if($user['permissions'] == "Administrator") echo " selected";
				      echo '>Administrator</option>
				      	<option';
				      if($user['permissions'] == "Moderator") echo " selected";
				      echo '>Moderator</option>
				    </select>
			    </div>
			    
			    <div class="text-right">
			    	<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=Users" class="btn btn-default">Anuluj</a>
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
	else if($_GET['action'] == "delete" && isset($_GET['id']))
	{
		if(!isset($_GET['accept']) || $_GET['accept'] != "yes")
		{
			echo '<div class="page-header">
				<h3>Usuwanie użytkownika</h3>
				</div>';
			echo 'Czy na pewno chcesz usunąć użytkownika?<br/>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<a class="btn btn-default" href="adminPanel.php?subpage=Users&action=delete&id='.$_GET['id'].'&accept=yes">Tak</a> 
				<a class="btn btn-default" href="adminPanel.php?subpage=Users&action=delete&id='.$_GET['id'].'&accept=no">Nie</a>
				</div>';
		}
		else if($_GET['accept'] == "yes")
		{
			deleteUser($_GET['id']);
			echo("<script>location.href = 'adminPanel.php?subpage=Users';</script>");
			exit();
		}
	}

	echo '</div>
		</div>
		</div>
		</div>';
?>