<?php
	include("header.php");
	getHeader("Wypożyczalnia samochodów - Podsumowanie zamówienia", "mainCss.css;reservationSummary.css");
	include("menu.php");
	require("adminPanel/displayInfo.php");
?>

<div id="reservationContError" class="container">
	<div class="row">
		<div class="col-md-12">
			<br><br>
			<h1>EROR 404 - PAGE NOT FOUND</h1>
			<br>
			<h2>This page is not available!</h2>
		</div>
	</div>
</div>

<div id="reservationCont" class="container">

	<div class="row">
		<div id="summaryImage" class="col-lg-12">
			<img src="images/podsumowanie/2.png" class="img-responsive">
		</div>
	</div>

	<div class="row">
		<div class="col-lg-5 col-md-5 carRow col-sm-12 col-xs-12">
			<div class="row">
				<div class="carInfoHeader col-md-8">
					<h3 id="carReservationName"></h3>
				</div>
				<div class="carInfoPrice col-md-4">
					<h4><span id="priceReservation" class="priceColor"></span><br>
					netto</h4>
				</div>
			</div>
			<div class="row">
				<div class="carInfoImage col-md-12">
					<img id="imageReservation" src="" alt="'" class="img-responsive">
				</div>
			</div>
		</div>

		<div class="col-md-offset-2 col-lg-offset-2 col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<h3><i class="fa fa-table" aria-hidden="true"></i> Dane techniczne</h3>
			<table class="table table-hover table-condensed table-responsive" id="dane_tech">
				<tr>
					<td>Rok produkcji</td>
					<td id="productionYearReservation"></td>
				</tr>
				<tr>
					<td>Kolor lakieru</td>
					<td id="colorReservation"></td>
				</tr>
				<tr>
					<td>Liczba miejsc</td>
					<td id="numberOfSeatsReservation"></td>
				</tr>
				<tr>
					<td>Silnik</td>
					<td id="engineReservation"></td>
				</tr>
				<tr>
					<td>Moc silnika</td>
					<td id="enginePoweReservation"></td>
				</tr>
				<tr>
					<td>Napęd</td>
					<td id="driveReservation"></td>
				</tr>
				<tr>
					<td>Rodzaj skrzyni</td>
					<td id="gearReservation"></td>
				</tr>
				<tr>
					<td>Rodzaj nadwozia</td>
					<td id="bodyReservation"></td>
				</tr>
				<tr>
					<td>Przebieg</td>
					<td id="mileageReservation"></td>
				</tr>
			</table>
		</div>
	</div>

	<div id="summaryInfo" class="row" >
		<h1>Informacje o rezerwacji:</h1><br>
		<div class="col-md-12" style="text-align: center">
			<div class="col-md-6">
				<h4><strong>Odbiór:</strong> <span id="receptionPlaceReservation"></span></h4>
			</div>
			<div class="col-md-6">
				<h4><strong>Data:</strong> <span id="receptionDateReservation"></span>  <span id="receptionTimeReservation"></span></h4>
			</div>
		</div>

		<div class="col-md-12" style="text-align: center">
			<div class="col-md-6">
				<h4><strong>Zwrot:</strong> <span id="returnPlaceReservation"></span></h4>
			</div>
			<div class="col-md-6">
				<h4><strong>Data:</strong> <span id="returnDateReservation"></span>  <span id="returnTimeReservation"></span></h4>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="rightCol col-lg-12 col-md-12">
			<h1>Podsumowanie kosztów:</h1>
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><h3>Wynajem auta</h3></div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><h3 class="price" id="carPriceSum"></h3></div>
			</div>
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><h3>Opłaty dodatkowe</h3></div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><h3 id="additionHourPriceSummary" class="price"><strike>0 zł</strike></h3></div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><h5>Opłata za wydanie poza godzinami</h5></div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><h5 id="additionHourPrice" class="price"></h5></div>
			</div>
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><h3>Opłaty dodatkowe na żądanie</h3></div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><h3 id="additionItemsPrice" class="price">0 zł</h3></div>
				<?php displayAdditionItems(); ?>
			</div>

			<div class="row">
				<div class="col-lg-9 col-md-9">
					<h3>Suma:</h3>
				</div>
				<div class="col-lg-3 col-md-3">
					<h3 class="price" id="lastPriceReservation"></h3>
				</div>
				<div class="col-lg-offset-4 col-lg-8 col-md-offset-4 col-md-8">
					<!--<h4 class="price" ><strike>Płacąc online zaoszczędzisz 0 zł brutto</strike></h4>-->
				</div>

				<div class="col-md-6" style="text-align: right">
					<input type="button" value="Powrót" class="price ccbtn" id="backSummary"/>
				</div>

				<div class="col-md-6">
					<input type="button" value="Rezerwuj" class="price ccbtn" id="reserveSummary"/>
				</div>
			</div>

		</div>
	</div>
</div>

<?php include("footer.php"); ?>
