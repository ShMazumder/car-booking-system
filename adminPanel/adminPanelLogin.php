<div class='container-fluid'>
	<div class="margin"></div>
	<div class="col-lg-offset-4 col-md-offset-3 col-sm-offset-2 col-lg-4 col-md-6 col-sm-8 col-xs-12" id="login_panel">
		<div id="header">
			<img src="images/logo.png" alt="Wypozyczalnia Samochodów - Logo"/>
			<span>Panel administracyjny</span>
		</div>
		<form method="POST" action="adminPanel/login.php" id="login">
			<label for="input_login">Login: </label>
			<input type="text" name="login" id="input_login" class="input_text"/><br/>
			<label for="input_text">Hasło: </label>
			<input type="password" name="password" class="input_text"/><br/>
			
			<div class="error_div">
			<?php
				if(isset($_SESSION['error']))
				{
					echo '<p class="error">'.$_SESSION['error'].'</p>';
					unset($_SESSION['error']);
				}
			?>
			</div>

			<input type="submit" value="Zaloguj się" class="input_submit"/>
		</form>
	</div>

</div>