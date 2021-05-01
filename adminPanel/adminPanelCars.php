<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Fleet</h3>
			</div>';
		echo '<a href="adminPanel.php?subpage=Cars&action=add" class="btn btn-default action-btn">Dodaj samochód</a>
			<hr/>';

		displayCars();
	}
	else if($_GET['action'] == "add")
	{
		echo '<div class="page-header">
			<h3>Dodawanie samochodu</h3>
			</div>';
		echo '
		
			<form method="POST" action="adminPanel/action.php?subpage=Cars&action=add" enctype="multipart/form-data" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name">
				</div>
				<div class="form-group">
					<label for="type_input" class="tytul_input">Typ: </label>
					<select class="form-control" id="type_input" name="type">
				      <option>Automat</option>
				      <option>Manual</option>
				    </select>
				</div>
				<div class="form-group">
					<label for="manufacture_year_input" class="tytul_input">Rok produkcji: </label>
					<input type="number" min="0" value="0" class="form-control" id="manufacture_year_input" name="manufacture_year">
					<script>
						var d = new Date();
						document.getElementById("manufacture_year_input").value = d.getFullYear();
					</script>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="varnish_color_input">Kolor lakieru: </label>
					<input type="text" class="form-control" id="varnish_color_input" name="varnish_color">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="nr_of_seats_input">Liczba miejsc: </label>
					<input type="number" min="0" value="0" class="form-control" id="nr_of_seats_input" name="nr_of_seats">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="engine_input">Silnik: </label>
			    	<input type="text" class="form-control" id="engine_input" name="engine">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="engine_power_input">Moc silnika (KM): </label>
			    	<input type="number" min="0" value="0" class="form-control" id="engine_power_input" name="engine_power">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="drive_input">Napęd: </label>
			    	<input type="text" class="form-control" id="drive_input" name="drive">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="gear_type_input">Rodzaj skrzyni: </label>
			    	<input type="text" class="form-control" id="gear_type_input" name="gear_type">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="body_type_input">Rodzaj nadwozia: </label>
			    	<input type="text" class="form-control" id="body_type_input" name="body_type" list="body_type_list">
			    	<datalist id="body_type_list">';

		displayOptionBodyType();

		echo '
			    	</datalist>
			    </div>
			</div>
		    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			    <div class="form-group">
					<label class="tytul_input" for="mileage_input">Przebieg (km): </label>
			    	<input type="number" min="0" value="0" class="form-control" id="mileage_input" name="mileage">
			    </div>
			    <div class="form-group">
					<label class="gear_type_input" for="id_localization_input">Lokalizacja: </label>
				    <select class="form-control" id="id_localization_input" name="id_localization">';

		displayOptionLocalizations();

		echo '
				    </select>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="price_class_input">Klasa cenowa: </label>
					<div class="input-group">
						<select class="form-control" id="price_class_input" name="price_class">';

		displayOptionPriceClass();

		echo '
						</select>
						<span class="input-group-btn">
							<a href="adminPanel.php?subpage=PriceClass&action=add" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></a>
						</span>
					</div>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="avaliable_input">Dostępny: </label>
					<select class="form-control" id="avaliable_input" name="avaliable">
						<option value="1">TAK</option>
						<option value="0">NIE</option>
				    </select>
			    </div>
			</div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="description_input">Opis: </label>
			    	<textarea rows="6" class="form-control" id="description_input" name="description"></textarea>
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="file_model_input">Zdjęcie modelu: </label>
					<input type="file" accept="image/png" class="file_model_input" id="file_model_input" name="image_model"/>
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group" id="files_div">
					<label class="tytul_input" for="file_input">Zdjęcia: </label>
					<input type="file" accept="image/*" class="file_input" id="file_input" name="files[]"/>
			    </div>
			</div>
			
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Dodaj" id="submit">
					<a href="adminPanel.php?subpage=Cars" class="btn btn-default">Anuluj</a>
				</div>
			</div>
			</form>
			
		<div class="error_div">';	    
		if(isset($_SESSION['error']))
		{
			echo '<p class="error">'.$_SESSION['error'].'</p>';
			unset($_SESSION['error']);
		}
		echo '</div>';
	}
	else if($_GET['action'] == "info" && isset($_GET['id']))
	{
		$car = getCar($_GET['id']);

		echo '<div class="page-header">
			<h3>Informacje o samochododzie</h3>
			</div>';

		echo '
			<form method="POST" enctype="multipart/form-data" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$car['name'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="type_input" class="tytul_input">Typ: </label>
					<input type="text" class="form-control" id="type_input" name="type" value="'.$car['type'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="manufacture_year_input" class="tytul_input">Rok produkcji: </label>
					<input type="text" class="form-control" id="manufacture_year_input" name="manufacture_year" value="'.$car['manufacture_year'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="varnish_color_input">Kolor lakieru: </label>
					<input type="text" class="form-control" id="varnish_color_input" name="varnish_color" value="'.$car['varnish_color'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="nr_of_seats_input">Liczba miejsc: </label>
					<input type="text" class="form-control" id="nr_of_seats_input" name="nr_of_seats" value="'.$car['nr_of_seats'].'" readOnly>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="engine_input">Silnik: </label>
			    	<input type="text" class="form-control" id="engine_input" name="engine" value="'.$car['engine'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="engine_power_input">Moc silnika (KM): </label>
			    	<input type="text" class="form-control" id="engine_power_input" name="engine_power" value="'.$car['engine_power'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="drive_input">Napęd: </label>
			    	<input type="text" class="form-control" id="drive_input" name="drive" value="'.$car['drive'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="gear_type_input">Rodzaj skrzyni: </label>
			    	<input type="text" class="form-control" id="gear_type_input" name="gear_type" value="'.$car['gear_type'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="body_type_input">Rodzaj nadwozia: </label>
			    	<input type="text" class="form-control" id="body_type_input" name="body_type" value="'.$car['body_type'].'"  readOnly>
			    </div>
			</div>
		    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			    <div class="form-group">
					<label class="tytul_input" for="mileage_input">Przebieg (km): </label>
			    	<input type="text" class="form-control" id="mileage_input" name="mileage" value="'.$car['mileage'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="gear_type_input" for="id_localization_input">Lokalizacja: </label>
			    	<input type="text" class="form-control" id="id_localization_input" name="id_localization" value="'.$car['localization_name'].'" readOnly>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="price_class_input">Klasa cenowa: </label>
					<div class="input-group">
						<input type="text" class="form-control" id="price_class_input" name="price_class" value="'.$car['price_class_name'].'" readOnly>
						<span class="input-group-btn">
							<a class="btn btn-default" href="adminPanel.php?subpage=PriceClass&action=info&id='.$car['price_class'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
						</span>
					</div>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="avaliable_input">Dostępny: </label>
					<input type="text" class="form-control" id="avaliable_input" name="avaliable" value="';

		if($car['avaliable'])
			echo 'TAK';
		else
			echo 'NIE';

		echo '" readOnly>
			    </div>
			</div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="description_input">Opis: </label>
			    	<textarea rows="6" class="form-control" id="description_input" name="description" readOnly>'.$car['description'].'</textarea>
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input">Zdjęcie modelu: </label><br/>';

		displayCarImageModel($_GET['id']);

		echo '
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input">Zdjęcia: </label><br/>';

		displayCarImages($_GET['id']);

		echo '
			    </div>
			</div>
			
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    <div class="text-right">
					<a href="adminPanel.php?subpage=Cars&action=edit&id='.$_GET['id'].'" class="btn btn-default">Edytuj</a>
				</div>
			</div>
			</form>';

	}
	else if($_GET['action'] == "edit" && isset($_GET['id']))
	{

		$car = getCar($_GET['id']);

		echo '<div class="page-header">
			<h3>Edytowanie samochodu</h3>
			</div>';
		echo '
		
			<form method="POST" action="adminPanel/action.php?subpage=Cars&action=edit&id='.$_GET['id'].'" enctype="multipart/form-data" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="name_input" class="tytul_input">Nazwa: </label>
					<input type="text" class="form-control" id="name_input" name="name" value="'.$car['name'].'">
				</div>
				<div class="form-group">
					<label for="type_input" class="tytul_input">Typ: </label>
					<select class="form-control" id="type_input" name="type">
						<option ';
		if($car['type'] == "Automat")
			echo "selected";
		echo '>Automat</option><option ';
		if($car['type'] == "Manual")
			echo 'selected';
		echo '>Manual</option>
				    </select>
				</div>
				<div class="form-group">
					<label for="manufacture_year_input" class="tytul_input">Rok produkcji: </label>
					<input type="number" min="0" class="form-control" id="manufacture_year_input" name="manufacture_year" value="'.$car['manufacture_year'].'">
					<script>
						var d = new Date();
						document.getElementById("manufacture_year_input").value = d.getFullYear();
					</script>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="varnish_color_input">Kolor lakieru: </label>
					<input type="text" class="form-control" id="varnish_color_input" name="varnish_color" value="'.$car['varnish_color'].'">
				</div>
				<div class="form-group">
					<label class="tytul_input" for="nr_of_seats_input">Liczba miejsc: </label>
					<input type="number" min="0" class="form-control" id="nr_of_seats_input" name="nr_of_seats" value="'.$car['nr_of_seats'].'">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="engine_input">Silnik: </label>
			    	<input type="text" class="form-control" id="engine_input" name="engine" value="'.$car['engine'].'">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="engine_power_input">Moc silnika (KM): </label>
			    	<input type="number" min="0" class="form-control" id="engine_power_input" name="engine_power" value="'.$car['engine_power'].'">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="drive_input">Napęd: </label>
			    	<input type="text" class="form-control" id="drive_input" name="drive" value="'.$car['drive'].'">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="gear_type_input">Rodzaj skrzyni: </label>
			    	<input type="text" class="form-control" id="gear_type_input" name="gear_type" value="'.$car['gear_type'].'">
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="body_type_input">Rodzaj nadwozia: </label>
			    	<input type="text" class="form-control" id="body_type_input" name="body_type" value="'.$car['body_type'].'" list="body_type_list">
			    	<datalist id="body_type_list">';

		displayOptionBodyType();

		echo '
			    	</datalist>
			    </div>
			</div>
		    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			    <div class="form-group">
					<label class="tytul_input" for="mileage_input">Przebieg (km): </label>
			    	<input type="number" min="0" class="form-control" id="mileage_input" name="mileage" value="'.$car['mileage'].'">
			    </div>
			    <div class="form-group">
					<label class="gear_type_input" for="id_localization_input">Lokalizacja: </label>
			    	<select class="form-control" id="id_localization_input" name="id_localization">
				    	';

		displayOptionLocalizations($car['id_localization']);

		echo '
				    </select>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="price_class_input">Klasa cenowa: </label>
					<select class="form-control" id="price_class_input" name="price_class">';

		displayOptionPriceClass($car['price_class']);

		echo '
					</select>
			    </div>
			    <div class="form-group">
					<label class="tytul_input" for="avaliable_input">Dostępny: </label>
					<select class="form-control" id="avaliable_input" name="avaliable">
						<option value="1" ';
		if($car['avaliable'] == "1")
			echo "selected";
		echo '>TAK</option><option value="0" ';
		if($car['avaliable'] == "0")
			echo 'selected';
		echo '>NIE</option>
				    </select>
			    </div>
			</div>
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="description_input">Opis: </label>
			    	<textarea rows="6" class="form-control" id="description_input" name="description">'.$car['description'].'</textarea>
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="image_model_input">Ustawianie zdjęcia modelu: </label>
					<input type="file" accept="image/png" class="image_model_input" id="image_model_input" name="image_model"/>
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<br/>
				<div class="form-group delete_files_div">
					<label class="tytul_input">Usuwanie zdjęć: </label>
					<div>';

		displayCarImagesForDelete($_GET['id']);

		echo '
					</div>
				</div>
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<br/>
				<div class="form-group" id="files_div">
					<label class="tytul_input" for="file_input">Dodawanie zdjęć: </label>
					<input type="file" accept="image/*" class="file_input" id="file_input" name="files[]"/>
			    </div>
			</div>
			
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    <div class="text-right">
					<input type="submit" class="btn btn-default" value="Zapisz" id="submit">
					<a href="adminPanel.php?subpage=Cars" class="btn btn-default">Anuluj</a>
				</div>
			</div>
			</form>

			<div class="error_div">';	    
		if(isset($_SESSION['error']))
		{
			echo '<p class="error">'.$_SESSION['error'].'</p>';
			unset($_SESSION['error']);
		}
		echo '</div>';
			
	}


	echo '</div>
		</div>
		</div>
		</div>';
?>