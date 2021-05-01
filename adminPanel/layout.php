<div class='container'>
	<div class="margin"></div>
	<div id="panel" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="header">
				<img src="images/logo.png" alt="Wypozyczalnia Samochodów - Logo"/>
				<span>Panel administracyjny</span>
			</div>
		</div>

		<div class="row is-flex">
			<!-- nav -->
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 nav-side-menu">
				<div class="brand"><?php
						if(isset($_GET['subpage']))
						{
							switch($_GET['subpage']){
								case "Home":
									echo '<i class="fa fa-dashboard fa-lg"></i> Strona główna';
									break;
								case "Reservations":
									echo '<i class="fa fa-pencil-square-o fa-lg"></i> Rezerwacje';
									break;
								case "Cars":
									echo '<i class="fa fa-car fa-lg"></i> Fleet';
									break;
								case "Payments":
									echo '<i class="fa fa-credit-card"></i> Płatności';
									break;
								case "PriceClass":
									echo '<i class="fa fa-money"></i></i> Klasy cenowe';
									break;
								case "AdditionalFees":
									echo '<i class="fa fa-cart-plus"></i> Dodatkowe opłaty';
									break;
								case "ClientsPeople":
								case "ClientsCompanies":
									echo '<i class="fa fa-suitcase"></i> Klienci';
									break;
								case "Locations":
									echo '<i class="fa fa-location-arrow fa-lg"></i> Lokacje';
									break;
								case "Profile":
									echo '<i class="fa fa-user fa-lg"></i> Profil';
									break;
								case "Users":
									echo '<i class="fa fa-users fa-lg"></i> Użytkownicy';
									break;
							}
						}
						else
							echo '<i class="fa fa-dashboard fa-lg"></i> Strona główna';
					?></div>
				<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
				<div class="menu-list">

					<ul id="menu-content" class="menu-content collapse">
						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "Home" || !isset($_GET['subpage'])) echo ' class="active"';?>>
							<a href="adminPanel.php?subpage=Home"><i class="fa fa-dashboard fa-lg"></i> Strona główna</a>
						</li>
						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "Reservations") echo ' class="active"';?> class="collapsed">
							<a href="adminPanel.php?subpage=Reservations"><i class="fa fa-pencil-square-o fa-lg"></i> Rezerwacje</a>
						</li>
						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "Cars") echo ' class="active"';?> class="collapsed">
							<a href="adminPanel.php?subpage=Cars"><i class="fa fa-car fa-lg"></i> Fleet</a>
						</li>
						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "Payments") echo ' class="active"';?> class="collapsed">
							<a href="adminPanel.php?subpage=Payments"><i class="fa fa-credit-card" aria-hidden="true"></i> Płatności</a>
						</li>
						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "PriceClass") echo ' class="active"';?> class="collapsed">
							<a href="adminPanel.php?subpage=PriceClass"><i class="fa fa-money" aria-hidden="true"></i> Klasy cenowe</a>
						</li>
						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "AdditionalFees") echo ' class="active"';?> class="collapsed">
							<a href="adminPanel.php?subpage=AdditionalFees"><i class="fa fa-cart-plus" aria-hidden="true"></i> Dodatkowe opłaty</a>
						</li>

						<li<?php if(isset($_GET['subpage']) && ($_GET['subpage'] == "ClientsPeople" || $_GET['subpage'] == "ClientsCompanies")) echo ' class="active"';?> data-toggle="collapse" data-target="#clients" class="collapsed">
							<a><i class="fa fa-suitcase" aria-hidden="true"></i> Klienci <span class="arrow"></span></a>
						</li>
						<ul class="sub-menu collapse" id="clients">
							<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "ClientsPeople") echo ' class="active"';?> ><a href="adminPanel.php?subpage=ClientsPeople"><i class="fa fa-angle-right arrow_right" aria-hidden="true"></i><i class="fa fa-id-card-o" aria-hidden="true"></i> Osoby</a></li>
							<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "ClientsCompanies") echo ' class="active"';?> ><a href="adminPanel.php?subpage=ClientsCompanies"><i class="fa fa-angle-right arrow_right" aria-hidden="true"></i><i class="fa fa-building-o" aria-hidden="true"></i> Firmy</a></li>
						</ul>

						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "Locations") echo ' class="active"';?>>
							<a href="adminPanel.php?subpage=Locations"><i class="fa fa-location-arrow fa-lg"></i> Lokacje</a>
						</li>

						<li<?php if(isset($_GET['subpage']) && $_GET['subpage'] == "Profile") echo ' class="active"';?>>
							<a href="adminPanel.php?subpage=Profile"><i class="fa fa-user fa-lg"></i> Profil</a>
						</li>
						<?php
							if(isset($_SESSION['permissions']) && $_SESSION['permissions'] == "Administrator")
							{
								echo '<li';
								if(isset($_GET['subpage']) && $_GET['subpage'] == "Users")
									echo ' class="active"';
								echo '><a href="adminPanel.php?subpage=Users"><i class="fa fa-users fa-lg"></i> Użytkownicy</a></li>';
							}
						?>
					</ul>
				</div>
			</div>
			<!-- nav end -->
