<?php

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));

	echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="panel_content">';

	require_once("adminPanelFunctions.php");

	if(!isset($_GET['action']))
	{
		echo '<div class="page-header">
			<h3>Płatności</h3>
			</div>';

		displayPayments();
	}
	else if($_GET['action'] == "info" && isset($_GET['id']))
	{
		$payment = getPayment($_GET['id']);

		echo '<div class="page-header">
			<h3>Informacje o płatności</h3>
			</div>';
		echo '
			<form method="POST" autocomplete="off">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="nr_reservation_input" class="tytul_input">Nr. rezerwacji: </label>
					<div class="input-group">
					<input type="text" class="form-control" id="nr_reservation_input" name="nr_reservation" value="'.$payment['nr_reservation'].'" readOnly>
					<span class="input-group-btn">
						<a class="btn btn-default" href="adminPanel.php?subpage=Reservations&action=info&id='.$payment['reservation_id'].'"><i class="fa fa-info" aria-hidden="true"></i></a>
					</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="tytul_input" for="operation_number_input">Nr. operacji: </label>
					<input type="text" class="form-control" id="operation_number_input" name="operation_number" value="'.$payment['operation_number'].'" readOnly>
				</div>
				<div class="form-group">
					<label class="tytul_input" for="operation_type_input">Typ operacji: </label>
					<input type="text" class="form-control" id="operation_type_input" name="operation_type" value="'.$payment['operation_type'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="operation_status_input" class="tytul_input">Status: </label>
					<input type="text" class="form-control" id="operation_status_input" name="operation_status" value="'.$payment['operation_status'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="operation_amount_input" class="tytul_input">Ilość: </label>
					<input type="text" class="form-control" id="operation_amount_input" name="operation_amount" value="'.$payment['operation_amount'].'" readOnly>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="operation_currency_input">Waluta: </label>
					<input type="text" class="form-control" id="operation_currency_input" name="operation_currency" value="'.$payment['operation_currency'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="operation_original_amount_input" class="tytul_input">Oryg. ilość: </label>
					<input type="text" class="form-control" id="operation_original_amount_input" name="operation_original_amount" value="'.$payment['operation_original_amount'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="operation_original_currency_input" class="tytul_input">Oryg. waluta: </label>
					<input type="text" class="form-control" id="operation_original_currency_input" name="operation_original_currency" value="'.$payment['operation_original_currency'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="operation_datetime_input" class="tytul_input">Data operacji: </label>
					<input type="text" class="form-control" id="operation_datetime_input" name="operation_datetime" value="'.$payment['operation_datetime'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="control_input" class="tytul_input">Nadzór: </label>
					<input type="text" class="form-control" id="control_input" name="control" value="'.$payment['control'].'" readOnly>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<div class="form-group">
					<label for="email_input" class="tytul_input">E-mail: </label>
					<input type="text" class="form-control" id="email_input" name="email" value="'.$payment['email'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="p_info_input" class="tytul_input">Informacje: </label>
					<input type="text" class="form-control" id="p_info_input" name="p_info" value="'.$payment['p_info'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="p_email_input" class="tytul_input">E-mail: </label>
					<input type="text" class="form-control" id="p_email_input" name="p_email" value="'.$payment['p_email'].'" readOnly>
				</div>
				<div class="form-group">
					<label for="channel_input" class="tytul_input">Kanał: </label>
					<input type="text" class="form-control" id="channel_input" name="channel" value="'.$payment['channel'].'" readOnly>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="description_input">Opis: </label>
			    	<textarea rows="6" class="form-control" id="description_input" name="description" readOnly>'.$payment['description'].'</textarea>
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="tytul_input" for="signature_input">Sygnatura: </label>
			    	<textarea rows="6" class="form-control" id="signature_input" name="signature" readOnly>'.$payment['signature'].'</textarea>
			    </div>
			</div>
			</form>';
		echo '</div>
			</div>';
	}

	echo '</div>
		</div>
		</div>
		</div>';





?>