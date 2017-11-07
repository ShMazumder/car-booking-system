<?php
	include("header.php");
	getHeader("Wypożyczalnia samochodów - Kontakt", "mainCss.css;subpageContact.css");
	include("menu.php");
	//include("footer.php");
 ?>

<script src="js/gmap3.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc8_OqHcGAxef8qIwX6J_e9EclF1rJQrM&region=PL"></script>
<script src="js/map.js"></script>


<div class='container'>
	<div class="page-header">
		<h1>Kontakt</h1>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

			<address>
				<div class="contact-info">
					<span class="contact-addon"><i class="fa fa-user fa-2x"></i></span>
					<span class="contact-info-text"><strong>Osoba: </strong>Michał Słoboda</span>
				</div>
				<div class="contact-info">
					<span class="contact-addon"><i class="fa fa-phone fa-2x"></i></span>
					<span class="contact-info-text"><strong>Telefon: </strong>732 152 960</span>
				</div>
				<div class="contact-info">
					<span class="contact-addon"><i class="fa fa-at fa-2x"></i></span>
					<span class="contact-info-text"><strong>E-mail: </strong>michal.sloboda@paula-car.pl</span>
				</div>
				<div class="contact-info">
					<span class="contact-addon"><i class="fa fa-map-marker fa-2x"></i></span>
					<span class="contact-info-text"><br><strong>Gładysz Motors</strong><br>Łukanowice 239 k/Tarnowa<br>32-830 Wojnicz</span>
				</div>
			</address>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<img src="images/kontakt/img1.jpg" alt="image" class="img-responsive"/>
		</div>

	</div>
	<hr/>
</div>

<div class="map">
	<div id="map-container"></div>
</div>

<?php
	include("footer.php");
 ?>
