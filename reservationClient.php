<?php
	include("header.php");
	getHeader("Wypożyczalnia samochodów - Dane klienta", "mainCss.css;reservationSummary.css");
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
			<img src="images/podsumowanie/3.png" class="img-responsive">
		</div>
	</div>

	<div class="row">
		<div class="col-lg-5 col-md-5 carRow col-sm-12 col-xs-12 hidden-sm hidden-xs">
			<div class="row">
				<div class="carInfoHeader col-md-8">
					<h3 id="carReservationName"></h3>
				</div>
			</div>
			<div class="row">
				<div class="carInfoImage col-md-12">
					<img id="imageReservation" src="" alt="'" class="img-responsive">
				</div>
			</div>
			<div id="fullPrice" class="row">
				<h2>Koszt całkowity: </h2>
				<h3 class="price" id="lastPriceReservation"></h3>
			</div>
		</div>


		<div class="col-lg-offset-1 col-md-offset-1 col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<label class="radio-inline"><input type="radio" name="radioCheck" id="privateCheckbox" value="private" checked>Osoba prywatna</label>
			<label class="radio-inline"><input type="radio" name="radioCheck" id="businessCheckbox" value="business">Firma</label>
		</div>

		<div class="margin"></div>
		<form id="privateForm" method="POST" action="addClientDatabase.php">
			<input type="hidden" value="private" name="typeForm">
			<div class="col-lg-offset-1 col-md-offset-1 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<h3>Dane kierowcy:</h3>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="name">Imię:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" pattern="[A-Za-ząęźżśóćńłĄĘŹŻŚÓĆŃŁ]{2,}" type="text" name="reservationFormName">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormSurname">Nazwisko:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" pattern="[A-Za-ząęźżśóćńłĄĘŹŻŚÓĆŃŁ]{2,}"  type="text" name="reservationFormSurname">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormPesel">Numer Pesel:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[0-9]{11}" name="reservationFormPesel">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormIDCard">Numer i seria dowodu osobistego:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="ABC 123456" pattern="[A-Z0-9\s]{10}" name="reservationFormIDCard">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormDriveLicense">Numer prawa jazdy:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="00000/00/0000" pattern="[0-9/]{13}" name="reservationFormDriveLicense">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormAddress">Adres:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁ0-9A-Za-z/\s]{5,}" name="reservationFormAddress">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormPost">Kod pocztowy:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="00-000" pattern="[0-9]{2}-[0-9]{3}" name="reservationFormPost">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormCity">Miasto:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁA-Za-z]{3,}" name="reservationFormCity">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormCountry">Kraj:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁA-Za-z]{6,}" name="reservationFormCountry">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormTelephone">Telefon:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" placeholder="000-000-000" pattern="[0-9+\s]{9,15}" type="text" name="reservationFormTelephone">
				</div>
				<div class="small-margin"></div>
				<div class="row">
						<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormemail">Adres e-mail:</label>
						<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="email"pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="reservationFormEmail">
				</div>
			</div>

			<div class="col-lg-12 col-md-12">
				<div class="margin"></div>
				<div id="ruleFormReservation">
					<div class="checkbox col-lg-12">
							<label class="col-lg-12"><input type="checkbox" required value="firstReg"><p>Akceptuję <a href="regulamin.pdf" target="_blank">regulamin</a> internetowej rezerwacji wynajmu samochodów</p></label>
					</div>
					<div class="checkbox col-lg-12">
							<label class="col-lg-12"><input type="checkbox" required value="secondReg"><p>Wyrażam zgodę na przetwarzanie swoich danych osobowych w celach marketingowych
										przez <strong>PaulaRentCar</strong> zgodnie z ustawą z dnia 29 sierpnia 1997 r. o ochronie danych osobowych (tekst jednolity: Dz.U. z 2016 r. poz.922 z późn. zm.) oraz na
										otrzymywanie od <strong>PaulaRentCar</strong> informacji handlowych drogą elektroniczną zgodnie z ustawą z dnia
										18 lipca 2002 r. (tekst jednolity: Dz.U. Dz.U. z 2016 r. poz. 1030 z późn. zm.) o świadczeniu usług drogą elektroniczną.
										Dane zostały podane przeze mnie dobrowolnie. Zostałem poinformowany (-a) o prawie dostępu do moich danych i możliwości
										ich poprawiania.</p></label>
					</div>
				</div>

				<div class="col-md-6" style="text-align: right">
					<input type="button" value="Powrót" class="price ccbtn" id="backSummary"/>
				</div>

				<div class="col-md-6">
						<input type="submit" value="Wyślij" class="price ccbtn" id="payButton"/>
				</div>
			</div>
		</form>

				<form id="businessForm" method="POST" action="addClientDatabase.php">
					<input type="hidden" value="business" name="typeForm">
					<div class="col-lg-offset-1 col-md-offset-1 col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<h3>Dane firmy: </h3>
						<div class="small-margin"></div>
						<div class="row">
						  <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormBusinessName">Nazwa firmy:</label>
						  <input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" pattern="[A-Za-ząęźżśóćńłĄĘŹŻŚÓĆŃŁ\s.,-]{2,}" type="text" name="reservationFormBusinessName">
						</div>
						<div class="small-margin"></div>
						<div class="row">
						  <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormBusinessAddress">Adres firmy:</label>
						  <input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁ0-9A-Za-z/\s]{5,}" type="text" name="reservationFormBusinessAddress">
						</div>
						<div class="small-margin"></div>
						<div class="row">
						  <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormBusinessPost">Kod pocztowy:</label>
						  <input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" placeholder="00-000" pattern="[0-9]{2}\-[0-9]{3}" type="text" name="reservationFormBusinessPost">
						</div>
						<div class="small-margin"></div>
						<div class="row">
						  <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormBusinessCity">Miasto:</label>
						  <input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁA-Za-z]{3,}" type="text" name="reservationFormBusinessCity">
						</div>
						<div class="small-margin"></div>
						<div class="row">
						  <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormBusinessNIP">NIP:</label>
						  <input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="000-000-00-00" pattern="[0-9-\s]{13}" name="reservationFormBusinessNIP">
						</div>
						<div class="small-margin"></div>
						<div class="row">
						  <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormBusinessTelephone">Telefon:</label>
						  <input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="000-000-000" pattern="[0-9+\s]{9,15}" name="reservationFormBusinessTelephone">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormemail">Adres e-mail:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="email"pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="reservationFormBusinessEmail">
						</div
						<hr>
						<h3>Dane kierowcy:</h3>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="name">Imię:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" pattern="[A-Za-ząęźżśóćńłĄĘŹŻŚÓĆŃŁ]{2,}" type="text" name="reservationFormName">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormSurname">Nazwisko:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" pattern="[A-Za-ząęźżśóćńłĄĘŹŻŚÓĆŃŁ]{2,}"  type="text" name="reservationFormSurname">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormPesel">Numer Pesel:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[0-9]{11}" name="reservationFormPesel">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormIDCard">Numer i seria dowodu osobistego:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="ABC 123456" pattern="[A-Z0-9\s]{10}" name="reservationFormIDCard">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormDriveLicense">Numer prawa jazdy:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="00000/00/0000" pattern="[0-9/]{13}" name="reservationFormDriveLicense">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormAddress">Adres:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁ0-9A-Za-z/\s]{5,}" name="reservationFormAddress">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormPost">Kod pocztowy:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" placeholder="00-000" pattern="[0-9]{2}\-[0-9]{3}" name="reservationFormPost">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormCity">Miasto:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁA-Za-z]{3,}" name="reservationFormCity">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormCountry">Kraj:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="text" pattern="[ząęźżśóćńłĄĘŹŻŚÓĆŃŁA-Za-z]{6,}" name="reservationFormCountry">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormTelephone">Telefon:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" placeholder="000-000-000" pattern="[0-9+\s]{9,15}" type="text" name="reservationFormTelephone">
						</div>
						<div class="small-margin"></div>
						<div class="row">
								<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6" for="reservationFormemail">Adres e-mail:</label>
								<input required class="col-lg-6 col-md-6 col-sm-6 col-xs-6" type="email"pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="reservationFormEmail">
						</div>
					</div>

				<div class="col-lg-12 col-md-12">
					<div class="margin"></div>
					<div id="ruleFormReservation">
						<div class="checkbox col-lg-12">
							 <label class="col-lg-12"><input type="checkbox" required value="firstReg"><p>Akceptuję <a href="regulamin.pdf" target="_blank">regulamin</a> internetowej rezerwacji wynajmu samochodów</p></label>
						</div>
						<div class="checkbox col-lg-12">
							 <label class="col-lg-12"><input type="checkbox" required value="secondReg"><p>Wyrażam zgodę na przetwarzanie swoich danych osobowych w celach marketingowych
									przez <strong>PaulaRentCar</strong> zgodnie z ustawą z dnia 29 sierpnia 1997 r. o ochronie danych osobowych (tekst jednolity: Dz.U. z 2016 r. poz.922 z późn. zm.) oraz na
									otrzymywanie od <strong>PaulaRentCar</strong> informacji handlowych drogą elektroniczną zgodnie z ustawą z dnia
									18 lipca 2002 r. (tekst jednolity: Dz.U. Dz.U. z 2016 r. poz. 1030 z późn. zm.) o świadczeniu usług drogą elektroniczną.
									Dane zostały podane przeze mnie dobrowolnie. Zostałem poinformowany (-a) o prawie dostępu do moich danych i możliwości
									ich poprawiania.</p></label>
						</div>
					</div>

					<div class="col-md-6" style="text-align: right">
						<input type="button" value="Powrót" class="price ccbtn" id="backSummary"/>
					</div>

					<div class="col-md-6">
							<input type="submit" value="Wyślij" class="price ccbtn" id="payButton"/>
					</div>
				</div>
			</form>
	</div>
</div>

<?php include("footer.php"); ?>
