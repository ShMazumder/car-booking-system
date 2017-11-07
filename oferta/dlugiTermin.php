<?php
	if(isset($_GET['bad'])){
		displayFormInfo($_GET['bad']);
	}
?>
<div class='container'>
	<div class="page-header">
		<h1>Wypożyczenie długoterminowe</h1>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h3>Dlaczego warto?</h3>
			<ul class="ul_arrow">
				<li>w trakcie wynajmu, gdy okaże się, że zmieniłeś zdanie co do grupy auta bez kosztowo zamienimy samochód na inny</li>
				<li>stały czynsz wynajmu pozwoli na zaplanowanie własnego budżetu, a koszt samochodu w żaden sposób nie wpłynie na Twoją zdolność kredytową</li>
				<li>masz możliwość wykupu samochodu w bardzo atrakcyjnej cenie</li>
				<li>do czasu odbioru wybranego modelu otrzymasz samochód przed kontraktowy</li>
			</ul>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		    <img src="images/oferta/dlugiTermin/img1.jpeg" alt="image" class="img-responsive"/>
		</div>

	</div>
	<hr/>
	<div class="row margin">

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="form-group">
			<label class="label_form" for="grupa_cenowa">Grupa cenowa:</label>
		    <select class="form-control" data-width="auto" id="grupa_cenowa">
		    	<?php displayLongListCar(); ?>
			</select>

			<div id="miesiace_najmu_div">
				<label class="label_form" for="tygodnie_najmu">Liczba tygodni najmu:</label>
				<input type="range" name="tygodnie_najmu" id="tygodnie_najmu" min="1" max="9" value="1" step="1">
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_1">1</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_2">2</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_3">3</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_4">4</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_6">5</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_8">6</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_12">7</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_18">8</span>
				<span class="miesiace_najmu_numbers" id="miesiace_najmu_24">9</span>
			</div>
		</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		    <img src="images/samochody/modele/infinitiq50h.png" id="selectImage" alt="Infinity Q50H" class="img-responsive"/>
		    <h2 class="text-center"><span id="car_name">Infiniti Q50H</span></h2>
		    <h1 class="text-center">Cena od: <span id="price">????</span> zł netto</h1>
		</div>
		<div class="col-lg-12">
			<span class="infoRight">Przedstawiona oferta cenowa ma charakter informacyjny i nie stanowi oferty handlowej w rozumieniu Art.66 par.1 Kodeksu Cywilnego. W celu uzyskania szczegółowej informacji zadzwoń na jeden z podanych telefonów lub napisz do nas.
			<strong>Jesteśmy tutaj dla Ciebie!</strong></span>
		</div>

	</div>
	<hr/>
	<div class="margin"></div>
</div>

<div class="container-fluid" id="form2Cont">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 wrapper">
				<header class="ccheader">
						<h1>Zadaj pytanie o wybrany samochód!</h1>
				</header>
		    <form method="post" action="adminPanel/sendMessage.php?type=offer" class="ccform">
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1 col-md-1"><i class="fa fa-user fa-2x"></i></span>
			        <input class="ccformfield col-md-11 col-md-11" type="text" name="offerNameForm" placeholder="Imię i nazwisko" required>
			    </div>
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1"><i class="fa fa-envelope fa-2x"></i></span>
			        <input class="ccformfield col-md-11" type="text" name="offerEmailForm" placeholder="Email" required>
			    </div>
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1"><i class="fa fa-mobile-phone fa-2x"></i></span>
			        <input class="ccformfield col-md-11" type="text" name="offerMobileForm" placeholder="Numer telefonu" required>
			    </div>
			     <div class="ccfield-prepend col-md-offset-3 col-md-6">
						 <span class="ccform-addon"><i class="fa fa-car fa-2x"></i></span>
						 <input class="ccformfield" type="text" name="offerCountForm" placeholder="Ilość samochodów"  required>
			    </div>
					<div class="ccfield-prepend col-md-offset-3 col-md-6">
						<span class="ccform-addon"><i class="fa fa-dashboard fa-2x"></i></span>
		        <input class="ccformfield" type="text" name="offerLimitForm" placeholder="Limit kilometrów"  required>
				 </div>
			    <div class="ccfield-prepend col-md-offset-3 col-md-6">
			        <span class="ccform-addon col-md-1"><i class="fa fa-comment fa-2x"></i></span>
			        <textarea class="ccformfield col-md-11" name="offerTextForm" placeholder="Wiadomość" required></textarea>
			    </div>
			    <div class="col-md-offset-3 col-md-6 col-xs-12">
			        <input class="ccbtn" type="submit" value="Wyślij">
			    </div>
		    </form>
		</div>
	</div>
</div>
