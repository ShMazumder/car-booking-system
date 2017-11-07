<?php
	include("header.php");
	getHeader("Wypożyczalnia samochodów - Samochody", "mainCss.css;subpageCars.css");
	include("menu.php");
	require("adminPanel/displayInfo.php");
?>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-xs-12 col-sm-12 checkCarModel">
			<h2>Wybierz rodzaj samochodu:</h2>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="checkCar" id="carTrue">Wszystkie</div>
			</div>
			<?php printBodyType();?>
		</div>

		<div class="col-md-6 col-xs-12 col-sm-12 checkCarModel">
			<h2>Wybierz klasę cenową:</h2>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="checkClass" id="classTrue">Wszystkie</div>
			</div>
			<?php printPriceClass(); ?>
		</div>
	</div>
</div>

<div class="container carsOffer">
		<?php printCars(); ?>
</div>

<?php
	include("footer.php");
?>
