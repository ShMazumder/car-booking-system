<?php
	if(isset($_GET['type'])){
		displayFormInfo($_GET['type']);
	}
?>

<div id="frontBanner" class="container-fluid">
	<div class="row">
		<img src="images/bannerCar.jpg" alt="Wypożyczalnia samochodów - Baner" class="img-responsive hidden-sm hidden-xs">
		<div id="formCont" class="col-md-12">
			<div id="bannerForm" class="col-md-offset-1 col-md-5 col-lg-offset-1 col-lg-5 col-sm-offset-0">
				<h3>Sprawdź dostępne samochody:</h3>
				<div class="row">
					<div class="col-md-6 col-xs-12 col-xs-12 col-sm-6">
						Odbiór:
						<select id="receptionPlace" class="editInput">
							<?php displayPlaces(); ?>
							<option value="otherPlace" disabled>Inna lokalizacja - 732 152 960</option>
						</select>
					</div>
					<div class="col-md-6 col-xs-12 col-sm-6">
						<div class="col-md-6 col-xs-6 col-sm-6 noPadding">
							<i class="fa fa-calendar" aria-hidden="true"></i> Data:
							<input type="text" id="receptionDate" class="editInput leftSelectCol" placeholder="Data odbioru">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6 noPadding">
							<i class="fa fa-clock-o" aria-hidden="true"></i> Czas:
							<input type="text" id="receptionTime" class="editInput rightSelectCol" placeholder="Czas odbioru">
						</div>
					</div>
				</div>

				<div class="row">
					<div id="rightRowSelect" class="col-md-6 col-xs-12 col-sm-6">
						Zwrot:
						<select id="returnPlace" class="editInput">
							<?php displayPlaces(); ?>
							<option value="otherPlace" disabled>Inna lokalizacja - 732 152 960</option>
						</select>
					</div>
					<div class="col-md-6 col-xs-12 col-sm-6">
						<div class="col-md-6 col-xs-6 col-sm-6 noPadding">
							<i class="fa fa-calendar" aria-hidden="true"></i> Data:
							<input type="text" id="returnDate" class="editInput leftSelectCol" placeholder="Data zwrotu">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6 noPadding">
							<i class="fa fa-clock-o" aria-hidden="true"></i> Czas:
							<input type="text" id="returnTime" class="editInput rightSelectCol" placeholder="Czas zwrotu">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div id="buttonCheckOffer"><i class="fa fa-car" aria-hidden="true"></i> Szukaj pojazdu!</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 hidden-xs hidden-sm" id="bigInfo">
				<h2>Zarezerwuj samochód u nas!</h2>
				<h3><i class="fa fa-car" aria-hidden="true"></i> Zapoznaj się z naszą ofertą.</h3>
				<h3><i class="fa fa-calendar-o" aria-hidden="true"></i> Wybierz dogodny termin.</h3>
				<h3><i class="fa fa-handshake-o" aria-hidden="true"></i> Odbierz samochód w wybranej lokalizacji.</h3>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid carouselCars hidden-xs">
	<div class="row">

		<h2>Wybrane modele samochodów: </h2>

		<div id="firstCarousel" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators hidden-xs">
		    <li data-target="#firstCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#firstCarousel" data-slide-to="1"></li>
		    <li data-target="#firstCarousel" data-slide-to="2"></li>
		  </ol>
		  <div class="carousel-inner" role="listbox">
		    <?php displayCarouselCar(); ?>
		  </div>

		  <a class="left carousel-control" href="#firstCarousel" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left fa fa-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#firstCarousel" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right fa fa-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
</div>

<div class="container-fluid" id="form2Cont">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 wrapper">
				<header class="ccheader">
						<h1>Stontaktuj się z nami!</h1>
						<h3>Wypełnij formularz kontaktowy</h3>
				</header>
		    <form method="post" action="adminPanel/sendMessage.php?type=home" class="ccform">
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1 col-md-1"><i class="fa fa-user fa-2x"></i></span>
			        <input class="ccformfield col-md-11 col-md-11" type="text" name="homeNameForm" placeholder="Imię i nazwisko" required>
			    </div>
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1"><i class="fa fa-envelope fa-2x"></i></span>
			        <input class="ccformfield col-md-11" type="text" name="homeEmailForm" placeholder="Email" required>
			    </div>
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1"><i class="fa fa-mobile-phone fa-2x"></i></span>
			        <input class="ccformfield col-md-11" type="text" name="homeMobileForm" placeholder="Numer telefonu" required>
			    </div>
			     <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1"><i class="fa fa-info fa-2x"></i></span>
			        <input class="ccformfield col-md-11" type="text" name="homeSubjectForm" placeholder="Temat zapytania" required>
			    </div>
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1"><i class="fa fa-comment fa-2x"></i></span>
			        <textarea class="ccformfield col-md-11" name="homeTextForm" placeholder="Wiadomość" required></textarea>
			    </div>
			    <div class="col-md-offset-3 col-md-6 col-xs-12">
			        <input class="ccbtn" type="submit" value="Wyślij">
			    </div>
		    </form>
		</div>
	</div>
</div>
