$(document).ready(function(){

	$.datetimepicker.setLocale('pl');

	$('#receptionTime').datetimepicker({
		datepicker:false,
		format:'H:i',
		step:5
	});

	$('#receptionDate').datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		minDate:0,
	});

	$('#returnTime').datetimepicker({
		datepicker:false,
		format:'H:i',
		step:5
	});

	$('#returnDate').datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		minDate:0,
	});

	$(".datetime").datetimepicker({
		format:'Y-m-d H:i',
		step:5,
		minDate:0
	})

	$("#buttonCheckOffer").on("click", function(){

			var receptionDate = $('#receptionDate').val();
			var receptionTime = $('#receptionTime').val();
			var returnDate = $('#returnDate').val();
			var returnTime = $('#returnTime').val();
			var receptionPlace = $("#receptionPlace").val();
			var returnPlace = $("#returnPlace").val();

			if(receptionPlace.length > 3 && returnPlace.length > 3){
				if(receptionTime.length == 5 && returnTime.length == 5 && returnDate.length == 10 && receptionDate.length == 10){
					if( receptionDate == returnDate){
						var recMin = parseInt(receptionTime.split(":")[0]) * 60 + parseInt(receptionTime.split(":")[1]);
						var retMin = parseInt(returnTime.split(":")[0]) * 60 + parseInt(returnTime.split(":")[1]);
						if(retMin - recMin >= 180){
							sessionStorage.clear();
							var data = {
								'receptionDate': receptionDate,
								'receptionDate': receptionDate,
								'receptionTime': receptionTime,
								'returnDate': returnDate,
								'returnTime': returnTime,
								'receptionPlace': receptionPlace,
								'returnPlace': returnPlace,
								'carCheck': true,
								'car': undefined
							}
							sessionStorage.setItem('data', JSON.stringify(data));
							setTimeout(function(){
							  window.location.href = "samochody.php";
							},500);
						}else{
							swal({
							  title: 'Uwaga..',
							  type: 'info',
							  html:
							    'Możliwość rezerwacji jedynie powyżej 3 godzin!',
							  showCloseButton: true
							})
						}
					}else{
						var data = {
							'receptionDate': receptionDate,
							'receptionDate': receptionDate,
							'receptionTime': receptionTime,
							'returnDate': returnDate,
							'returnTime': returnTime,
							'receptionPlace': receptionPlace,
							'returnPlace': returnPlace,
							'carCheck': true,
							'car': undefined
						}
						sessionStorage.setItem('data', JSON.stringify(data));
						setTimeout(function(){
							window.location.href = "samochody.php";
						},500);
					}
				}else{
					swal(
					  'Oops...',
					  'Zostały podane błędne dane!',
					  'error'
					)
				}
			}else{
				swal(
					'Oops...',
					'Zostały podane błędne dane adresowe!',
					'error'
				)
			}
	})

	$(".smallImageCar").on("click", function(){
		$("#mainCarImage").attr("src", $(this).attr("src"))
	})

	var basicPrice = 0;
	function loadCar(id){
		var car;
		$.ajax({
				url: "adminPanel/getData.php",
				data: { action: "car", id: id},
				type: "POST",
				success: function (data) {
						car = JSON.parse(data);
						basicPrice = car[0].price * 7;
						$("#price").html(basicPrice * $("#tygodnie_najmu").val());
						$("#car_name").html(car[0].name);
				},
				error: function (xhr, status, error) {
						console.log('Error: ' + error.message);
				},
		});
	}

	$("#grupa_cenowa").on("change", function(){
		$("#selectImage").attr("src", "images/samochody/modele/" + $(this).val().split(";")[0] + ".png")
		loadCar($(this).val().split(";")[1]);
	})

	$("#tygodnie_najmu").on("change", function(){
		$("#price").html(basicPrice * $(this).val());
	})

	$(".checkCar").on("click", function(){
		$(".checkCar").attr("class", "checkCar checkDisabled")
		$(".checkCar").attr("id", "")
		$(this).attr("class", "checkCar")
		$(this).attr("id", "carTrue")

		for(var i = 0; i < $(".carRow").length; i++){
			var car = $(".carRow")[i];
			if(car.getAttribute("data-car-type") != $(this).html()){
				if($(this).html() == "Wszystkie"){
					if(car.getAttribute("data-car-class") == $("#classTrue").html()){
						car.style.display = "block"
					}else{
						if($("#classTrue").html() == "Wszystkie"){
							car.style.display = "block"
						}else{
							car.style.display = "none"
						}
					}
				}else{
					car.style.display = "none"
				}
			}else{
				if(car.getAttribute("data-car-class") == $("#classTrue").html()){
					car.style.display = "block"
				}else{
					if($("#classTrue").html() == "Wszystkie"){
						car.style.display = "block"
					}else{
						car.style.display = "none"
					}
				}
			}
		}
	})

	$(".checkClass").on("click", function(){
		$(".checkClass").attr("class", "checkClass checkDisabled")
		$(".checkClass").attr("id", "")
		$(this).attr("class", "checkClass trueClass")
		$(this).attr("id", "classTrue")

		for(var i = 0; i < $(".carRow").length; i++){
			var car = $(".carRow")[i];
			if(car.getAttribute("data-car-class") != $(this).html()){
				if($(this).html() == "Wszystkie"){
					if(car.getAttribute("data-car-type") == $("#carTrue").html()){
						car.style.display = "block"
					}else{
						if($("#carTrue").html() == "Wszystkie"){
							car.style.display = "block"
						}else{
							car.style.display = "none"
						}
					}
				}else{
					car.style.display = "none"
				}
			}else{
				if(car.getAttribute("data-car-type") == $("#carTrue").html()){
					car.style.display = "block"
				}else{
					if($("#carTrue").html() == "Wszystkie"){
						car.style.display = "block"
					}else{
						car.style.display = "none"
					}
				}
			}
		}
	})

	function buttonReserve(){
		if(JSON.parse(sessionStorage.getItem('data')) != null){
			var obj = JSON.parse(sessionStorage.getItem('data'));
			if(obj.carCheck == true){
				$("#reservationCont").attr("style", "display: block")
				$("#reservationContError").attr("style", "display: none")
				$("#reserve").on("click", function(){

					var retTime = (new Date((obj.returnDate).split("-")[0], (obj.returnDate).split("-")[1], (obj.returnDate).split("-")[2])).getTime()
					var recTime =  (new Date((obj.receptionDate).split("-")[0], (obj.receptionDate).split("-")[1], (obj.receptionDate).split("-")[2])).getTime()

					var infoElements = $(".datas")
					var dataTab = [];
					for(var i = 0; i < infoElements.length; i++){
						for(var j = 0; j < infoElements[i].value.split(")").length; j++){
							dataTab.push(infoElements[i].value.split(")")[j].split(" ")[0])
						}
					}

					for(var i = 0; i < dataTab.length; i++){
						dataTab[i] = (new Date((dataTab[i]).split("-")[0], (dataTab[i]).split("-")[1], (dataTab[i]).split("-")[2])).getTime()
					}

					var tempBool = []
					var checkTrue = false;

					for(var i = 0; i < dataTab.length; i+= 2){
						if((recTime - dataTab[i]) < 0 && (retTime - dataTab[i]) < 0){
							tempBool.push(true)
						}else if((recTime - dataTab[i + 1]) > 0 && (retTime - dataTab[i + 1]) > 0){
							tempBool.push(true)
						}else{
							tempBool.push(false)
						}
					}

					for(var i = 0; i < tempBool.length; i++){
						if(tempBool[i] == false){
							swal({
									title: "Termin niedostępny!",
									text: "Samochód w tym terminie jest niedostępny.",
									type: "warning"
								})
						}else{
							checkTrue = true;
						}
					}

					setTimeout(function(){
						if(checkTrue){
							obj.car = $("#carName").html();
							obj.id = $("#carName").attr("data-car-id");
							sessionStorage.setItem('data', JSON.stringify(obj));
							window.location.href = "reservationSummary.php";
						}
					},500);
				})
			}else{
				$("#reservationContError").attr("style", "display: block")
				$("#reserve").on("click", function(){
					setTimeout(function(){
						//window.location.href = "index.php";
					},500);
				})
			}
		}else{
			$("#reserve").on("click", function(){
				setTimeout(function(){
					window.location.href = "index.php";
				},500);
			})
		}
	}

	function easter_date(year) {
    year = isNaN(year) ? new Date().getFullYear() : +year;
    var a = year % 19,
        b = year / 100 | 0,
        c = year % 100,
        h = (19 * a + b - (b / 4 | 0) - ((b - ((b + 8) / 25 | 0) + 1) / 3 | 0) + 15) % 30,
        l = (32 + 2 * (b % 4) + 2 * (c / 4 | 0) - h - c % 4) % 7,
        m = Math.floor((a + 11 * h + 22 * l) / 451);
    return new Date(year, Math.floor((h + l - 7 * m + 114) / 31) - 1, (h + l - 7 * m + 114) % 31 + 1);
	}

	function jestDniemRoboczym(date) {
    if ((date.getDay() || 7) >= 6) {
        return false;
    }

    var str = date.getDate() + "." + (date.getMonth() + 1);
    var swietaStale = ["1.1", "6.1", "1.5", "3.5", "15.8", "1.11", "11.11", "25.12", "26.12"];

    if (swietaStale.indexOf(str) >= 0) {
        return false;
    }

    var swietoRuchome = easter_date(date.getFullYear()); // Wielkanoc
    var przyrostyDni = [
        0, // Wielkanoc
        1, // Poniedzialek Wielkanocny
        48, // 49 dni po Wielkanocy mamy Zielone Swiatki
        11 // 60 dni po Wielkanocy jest Boze Cialo
    ];
    var i = 0;

    do {
        swietoRuchome.setDate(swietoRuchome.getDate() + przyrostyDni[i]);
        if (swietoRuchome.getDate() + "." + (swietoRuchome.getMonth() + 1) === str) {
            return false;
        }
        i++;
    } while (i < przyrostyDni.length);
    return true;
	}

	function loadCarReservationData(){
		if(JSON.parse(sessionStorage.getItem('data')) != null){
			var obj = JSON.parse(sessionStorage.getItem('data'));
			if(obj.id == undefined){obj.id = 1}
			$.ajax({
					url: "adminPanel/getData.php",
					data: { action: "car", id: obj.id},
					type: "POST",
					success: function (data) {
							var weekendPrice = 0;
							var summaryAdd = 0;
							var priceCar = 0;
							car = JSON.parse(data);
							$("#carReservationName").html(car[0].name)
							$("#imageReservation").attr("src", "images/samochody/modele/" + car[0].name.toString().replace(" ", "").replace(" ", "") + ".png")
							$("#productionYearReservation").html(car[0].manufacture_year)
							$("#colorReservation").html(car[0].varnish_color)
							$("#numberOfSeatsReservation").html(car[0].nr_of_seats)
							$("#engineReservation").html(car[0].engine)
							$("#enginePoweReservation").html(car[0].engine_power)
							$("#driveReservation").html(car[0].drive)
							$("#gearReservation").html(car[0].gear_type)
							$("#bodyReservation").html(car[0].body_type)
							$("#mileageReservation").html(car[0].mileage)
							$("#receptionPlaceReservation").html(obj.receptionPlace)
							$("#receptionDateReservation").html(obj.receptionDate)
							$("#receptionTimeReservation").html(obj.receptionTime)
							$("#returnPlaceReservation").html(obj.returnPlace)
							$("#returnDateReservation").html(obj.returnDate)
							$("#returnTimeReservation").html(obj.returnTime)

							var oneDay=1000*60*60*24;
							var fromDate = new Date(obj.receptionDate.toString().split("-")[0], obj.receptionDate.toString().split("-")[1] - 1, obj.receptionDate.toString().split("-")[2]);
							var toDate = new Date(obj.returnDate.toString().split("-")[0], obj.returnDate.toString().split("-")[1] - 1, obj.returnDate.toString().split("-")[2]);
							var countDay = (parseInt(toDate.getTime()) - parseInt(fromDate.getTime())) / oneDay

							var receptionTime = parseInt(obj.receptionTime.toString().split(":")[0]) * 60 + parseInt(obj.receptionTime.toString().split(":")[1])
							var returnTime = parseInt(obj.returnTime.toString().split(":")[0]) * 60 + parseInt(obj.returnTime.toString().split(":")[1])

							if(countDay <= 0){
								countDay = 1
							}

							if(countDay < 5){
								priceCar = parseInt(car[0].five)
							}else if(countDay < 10){
								priceCar = parseInt(car[0].ten)
							}else if(countDay < 15){
								priceCar = parseInt(car[0].price)
							}else{
								swal(
								  'Wycena',
								  'W celu wyceny na tak długi okres skontaktuj się z naszą obsługą poprzez formularz zgłoszeniowy lub telefonicznie.',
								  'question'
								)
							}

							var checkAddTime = false;

							if((receptionTime > 1020 || receptionTime < 540) && (returnTime > 1020 || returnTime < 540)){
								weekendPrice = 200
								summaryAdd+= weekendPrice
								checkAddTime = true
							}else if((receptionTime > 1020 || receptionTime < 540) || (returnTime > 1020 || returnTime < 540)){
								weekendPrice = 100
								summaryAdd+= weekendPrice
								checkAddTime = true
							}

							if(!jestDniemRoboczym(fromDate) && !jestDniemRoboczym(toDate)){
								weekendPrice = 200
								if(!checkAddTime)
									summaryAdd+= weekendPrice
							}else if(!jestDniemRoboczym(fromDate) || !jestDniemRoboczym(toDate)){
								weekendPrice = 100
								if(!checkAddTime)
									summaryAdd+= weekendPrice
							}

							var sumSummary = summaryAdd + Math.round(countDay * priceCar * 1.23)
							$("#lastPriceReservation").html(sumSummary + " zł brutto")

							var additionTab = [];
							var additionPrice = 0;
							$(".additionCheckBox").on("click", function(){
								if($(this).is(':checked')){
									sumSummary += parseInt($(this).attr("data-price"))
									additionPrice+=parseInt($(this).attr("data-price"))
									additionTab.push(parseInt($(this).attr("data-id")))
								}else{
									sumSummary -= parseInt($(this).attr("data-price"))
									additionPrice-=parseInt($(this).attr("data-price"))
									for(var i = 0; i < additionTab.length; i++){
										if(additionTab[i] == parseInt($(this).attr("data-id"))){
											additionTab.splice(i, 1)
										}
									}
								}

								obj.additionItem = additionTab;
								obj.summaryPrice = sumSummary;
								$("#lastPriceReservation").html(sumSummary + " zł brutto")
								$("#additionItemsPrice").html(additionPrice + " zł")
								console.log(obj.additionItem)
								console.log(obj.summaryPrice)
								sessionStorage.setItem('data', JSON.stringify(obj));

							})

							$("#additionHourPrice").html(summaryAdd + "zł")
							$("#additionHourPriceSummary").html(summaryAdd + "zł")
							$("#priceReservation").html((countDay * priceCar) + " zł")
							$("#carPriceSum").html((countDay * priceCar) + " zł netto")

							$("#reserveSummary").on("click", function(){
								obj.summaryPrice = sumSummary;
								obj.resNumber = 0;
								sessionStorage.setItem('data', JSON.stringify(obj));
								window.location.href = "reservationClient.php";
							})

							$("#dotPayButton").on("click", function(){
									obj.typeClient = $("#identTypeClient").attr("type-client")
									obj.pesel = $("#peselNumberGet").html()
									obj.fVat = 0
									obj.email = $("#emailAddress").html()

									if($("#identTypeClient").attr("type-client") == "2"){
										obj.emailCompany = $("#emailCompanyAddress").html()
										obj.nip = $("#nipNumberGet").html()
									}

									if($("#faktura").is(':checked')){
										obj.fVat = 1
									}
									$.ajax({
											url: "adminPanel/getData.php",
											data: { action: "addReservation", data: JSON.stringify(obj)},
											type: "POST",
											success: function (data) {
												if(data != "false"){
													obj.resNumber = data;
													sessionStorage.setItem('data', JSON.stringify(obj));
												}
												window.location.href = 'https://ssl.dotpay.pl/test_payment/?id=765790&bylaw=1&control='+ obj.resNumber + '&typ=3&url=http://paularentcar.pl&URLC=http://paularentcar.pl/dotpaypaymentsdatabase.php&amount='+obj.summaryPrice+'&opis=Opłata za zamówienie numer: '+obj.resNumber
											},
											error: function (xhr, status, error) {
													console.log('Error: ' + error.message);
											},
										});
							})
					},
					error: function (xhr, status, error) {
							console.log('Error: ' + error.message);
					},
			})
		}
	}

	$("#privateCheckbox").on("change", function(){
		if($(this).is(':checked')){
			$("#businessForm").attr("style", "display: none")
			$("#privateForm").attr("style", "display: block")
		}
	})

	$("#businessCheckbox").on("change", function(){
		if($(this).is(':checked')){
			$("#businessForm").attr("style", "display: block")
			$("#privateForm").attr("style", "display: none")
		}
	})


	$("#backSummary").on("click", function(){
		window.location.href = "samochody.php";
	})

	buttonReserve();
	loadCar(1);
	loadCarReservationData()





	$(".file_input").on("change", function(){
		newFileInput()
		$(this).off("change")
	});

	function newFileInput(){
		var input = document.createElement("input")
		input.type = "file"
		input.name = "files[]"
		input.className = "file_input"

		input.onchange = function(){
			newFileInput()
			this.onchange = null
		}

		$("#files_div").append(input)
	}


	$(".drivers_select").on("change", function(){
		newSelectDrivers()
		$(this).off("change")
	})

	function newSelectDrivers(){
		var select = document.createElement("select")
		select.name = "id_driver[]"
		select.className = "form-control drivers_select"

		select.onchange = function(){
			newSelectDrivers()
			this.onchange = null
		}

		$.ajax({
			url: "adminPanel/action.php",
			data: { action: "displayClientPeople"},
			type: "POST",
			success: function (data) {
					select.innerHTML = "<option selected></option>" + data
			},
			error: function (xhr, status, error) {
					console.log('Error: ' + error.message);
			},
		});

		$("#drivers").append(select)
	}



	$("#company_person_input").on("change", function(){
		var action, href;
		if(this.value == "1")
		{
			action = "displayClientPeople"
			href = "adminPanel.php?subpage=ClientsPeople&action=add"
		}
		else if(this.value == "2")
		{
			action = "displayClientCompanies"
			href = "adminPanel.php?subpage=ClientsCompanies&action=add"
		}

		$.ajax({
			url: "adminPanel/action.php",
			data: { action: action},
			type: "POST",
			success: function (data) {
					$("#id_driver_input").html(data)
					$("#id_driver_plus").attr("href", href)
			},
			error: function (xhr, status, error) {
					console.log('Error: ' + error.message);
			},
		});
	})
})
