<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header pull-left">
			<a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Wypozyczalnia Samochodów - Logo"></a>
		</div>
		<div id="navbar" class="navbar-header pull-right">
			<?php
				if(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true)
					echo '
						<ul class="nav navbar-nav">
						<li><a href="adminPanel.php?subpage=Profile"><i class="fa fa-user fa-lg"></i> '.$_SESSION['user'].'</a></li>
				      	<li><a href="adminPanel/logout.php"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> Wyloguj się</a></li>
				    	</ul>';
			?>
		</div>
	</div>
</nav>

