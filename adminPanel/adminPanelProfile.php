<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));


	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';
	echo '<div class="page-header">
		<h3>Profil</h3>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<form method="POST" action="adminPanel/action.php?subpage=Profile" autocomplete="off">
				<div class="form-group">
					<label class="tytul_input" for="password_input">Hasło: </label>
					<input type="password" class="form-control" id="password_input" name="password">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="password2_input">Powtórz hasło: </label>
					<input type="password" class="form-control" id="password2_input" name="password2">
				</div>
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zmień hasło" id="submit">
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


	echo '</div>
		</div>
		</div>
		</div>';
?>