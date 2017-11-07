<?php
	session_start();

	if(!isset($_SESSION['is_logged']))
		exit(header("Location: ../adminPanel.php"));
	

	if(isset($_GET['action'], $_GET['subpage'], $_POST))
	{
		require_once("adminPanelFunctions.php");

		switch($_GET['subpage']){
			// ================================================== HOME
			case "Home":


				break;
			case "Reservations":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['reservation_nr']))
					{
						$added_id = addReservation($_POST['reservation_nr'], $_POST['company/person'], $_POST['id_driver'], $_POST['id_car'], $_POST['start_date'], $_POST['end_date'], $_POST['id_location_receipt'], $_POST['id_location_return'], $_POST['price'], $_POST['fVat'], $_POST['status']);
						if($added_id)
						{
							if(addReservationAdditionalFees($added_id, $_POST['additional_fees']))
							{
								unset($_SESSION['error']);
								exit(header("Location: ../adminPanel.php?subpage=Reservations"));
							}
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola numer";

					exit(header("Location: ../adminPanel.php?subpage=Reservations&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(!empty($_POST['reservation_nr']))
					{
						$id_car = 0;
						if(!isset($_POST['id_car']))
							$id_car = $_POST['def_id_car'];
						else
						{
							$id_car = $_POST['id_car'];
							setCarAvaliable($_POST['def_id_car']);
							setCarNotAvaliable($id_car);
						}
						if(editReservation($_GET['id'], $_POST['reservation_nr'], $_POST['company/person'], $_POST['id_driver'], $id_car, $_POST['start_date'], $_POST['end_date'], $_POST['id_location_receipt'], $_POST['id_location_return'], $_POST['price'], $_POST['fVat'], $_POST['status']))
						{
							if(addReservationAdditionalFees($_GET['id'], $_POST['additional_fees']))
							{
								if($_POST['status'] != $_POST['prev_status'])
								{
									$mailto = getMailFromReservation($_GET['id']);
									mailStatus($mailto, $_POST['reservation_nr'], $_POST['status'], $_POST['prev_status']);
								}
								if($_POST['status'] == "Zakończone")
									setCarAvaliable($id_car);
								unset($_SESSION['error']);
								exit(header("Location: ../adminPanel.php?subpage=Reservations"));
							}
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola numer";
						
					exit(header("Location: ../adminPanel.php?subpage=Reservations&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					setCarAvaliable(getCarIdFromReservation($_GET['id']));
					if(deleteReservation($_GET['id']))
					{
						exit(header("Location: ../adminPanel.php?subpage=Reservations"));
					}
				}
				else if($_GET['action'] == "changeStatus" && isset($_GET['id']))
				{
					if(changeStatus($_POST['status'], $_GET['id']))
					{
						if($_POST['status'] == "Zakończone")
							setCarAvaliable(getCarIdFromReservation($_GET['id']));
						if($_POST['status'] == "W trakcie przygotowania")
							setCarNotAvaliable(getCarIdFromReservation($_GET['id']));

						$mailto = getMailFromReservation($_GET['id']);
						mailStatus($mailto, $_POST['reservation_nr'], $_POST['status'], $_POST['prev_status']);
						exit(header("Location: ../adminPanel.php?subpage=Reservations"));
					}
				}

				break;
			// ================================================== CARS
			case "Cars":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['name']))
					{
						$added_id = addCar($_POST['name'], $_POST['type'], $_POST['manufacture_year'], $_POST['id_localization'], $_POST['varnish_color'], $_POST['nr_of_seats'], $_POST['engine'], $_POST['engine_power'], $_POST['drive'], $_POST['gear_type'], $_POST['body_type'], $_POST['mileage'], $_POST['price_class'], $_POST['avaliable'], $_POST['description']);
						if($added_id)
						{
							if(isset($_FILES['image_model']) && addImageModel($_FILES['image_model'], $_POST['name']))
							{
								if(isset($_FILES['files']) && addImages($_FILES['files'], $added_id))
								{
									unset($_SESSION['error']);
									exit(header("Location: ../adminPanel.php?subpage=Cars"));
								}
							}
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";

					exit(header("Location: ../adminPanel.php?subpage=Cars&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(!empty($_POST['name']))
					{
						if(editCar($_GET['id'], $_POST['name'], $_POST['type'], $_POST['manufacture_year'], $_POST['id_localization'], $_POST['varnish_color'], $_POST['nr_of_seats'], $_POST['engine'], $_POST['engine_power'], $_POST['drive'], $_POST['gear_type'], $_POST['body_type'], $_POST['mileage'], $_POST['price_class'], $_POST['avaliable'], $_POST['description']))
							if(isset($_POST['delete_files']) && deleteImages($_POST['delete_files']) || !isset($_POST['delete_files']))
								if(isset($_FILES['image_model']) && addImageModel($_FILES['image_model'], $_POST['name']))
									if(isset($_FILES['files']) && addImages($_FILES['files'], $_GET['id']))
									{
										unset($_SESSION['error']);
										exit(header("Location: ../adminPanel.php?subpage=Cars"));
									}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";
						
					exit(header("Location: ../adminPanel.php?subpage=Cars&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					if(deleteCar($_GET['id']))
						exit(header("Location: ../adminPanel.php?subpage=Cars"));
				}

				break;
			case "Payments":
				if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					if(deletePayment($_GET['id']))
						exit(header("Location: ../adminPanel.php?subpage=Payments"));
				}
				break;
			// ================================================== PRICECLASS
			case "PriceClass":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['name']))
					{
						if(addPriceClass($_POST['name'], $_POST['five'], $_POST['ten'], $_POST['fifteen'], $_POST['bail']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=PriceClass"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";

					exit(header("Location: ../adminPanel.php?subpage=PriceClass&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(!empty($_POST['name']))
					{
						if(editPriceClass($_GET['id'], $_POST['name'], $_POST['five'], $_POST['ten'], $_POST['fifteen'], $_POST['bail']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=PriceClass"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";
						
					exit(header("Location: ../adminPanel.php?subpage=PriceClass&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					if(deletePriceClass($_GET['id']))
						exit(header("Location: ../adminPanel.php?subpage=PriceClass"));
				}

				break;
			// ================================================== ADDITIONALFEES
			case "AdditionalFees":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['name']))
					{
						if(addAdditionalFee($_POST['name'], $_POST['price']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=AdditionalFees"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";

					exit(header("Location: ../adminPanel.php?subpage=AdditionalFees&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(!empty($_POST['name']))
					{
						if(editAdditionalFee($_GET['id'], $_POST['name'],$_POST['price']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=AdditionalFees"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";
						
					exit(header("Location: ../adminPanel.php?subpage=AdditionalFees&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					if(deleteAdditionalFee($_GET['id']))
						exit(header("Location: ../adminPanel.php?subpage=AdditionalFees"));
				}

				break;
			// ================================================== CLIENTSPEOPLE
			case "ClientsPeople":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['name']))
					{
						if(addClientPeople($_POST['name'], $_POST['surname'], $_POST['pesel'], $_POST['ident_card'], $_POST['driving_licence'], $_POST['address'], $_POST['postcode'], $_POST['city'], $_POST['country'], $_POST['phone'], $_POST['email']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=ClientsPeople"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";

					exit(header("Location: ../adminPanel.php?subpage=ClientsPeople&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(!empty($_POST['name']))
					{
						if(editClientPeople($_GET['id'], $_POST['name'], $_POST['surname'], $_POST['pesel'], $_POST['ident_card'], $_POST['driving_licence'], $_POST['address'], $_POST['postcode'], $_POST['city'], $_POST['country'], $_POST['phone'], $_POST['email']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=ClientsPeople"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";
						
					exit(header("Location: ../adminPanel.php?subpage=ClientsPeople&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					if(deleteClientPeople($_GET['id']))
						exit(header("Location: ../adminPanel.php?subpage=ClientsPeople"));
				}

				break;
			// ================================================== CLIENTSCOMPANIES
			case "ClientsCompanies":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['name']))
					{
						if(addClientCompanies($_POST['name'], $_POST['id_driver'], $_POST['address'], $_POST['postcode'], $_POST['city'], $_POST['nip'], $_POST['phone'], $_POST['email']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=ClientsCompanies"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";
						
					exit(header("Location: ../adminPanel.php?subpage=ClientsCompanies&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(!empty($_POST['name']))
					{
						if(editClientCompanies($_GET['id'], $_POST['name'], $_POST['id_driver'], $_POST['address'], $_POST['postcode'], $_POST['city'], $_POST['nip'], $_POST['phone'], $_POST['email']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=ClientsCompanies"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";
						
					exit(header("Location: ../adminPanel.php?subpage=ClientsCompanies&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					if(deleteClientCompanies($_GET['id']))
						exit(header("Location: ../adminPanel.php?subpage=ClientsCompanies"));
				}

				break;
			// ================================================== LOCATIONS
			case "Locations":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['name']))
					{
						if(addLocalization($_POST['name'], $_POST['address'], $_POST['city'], $_POST['postcode'], $_POST['type']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=Locations"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";
						
					exit(header("Location: ../adminPanel.php?subpage=Locations&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(!empty($_POST['name']))
					{
						if(editLocalization($_GET['id'], $_POST['name'], $_POST['address'], $_POST['city'], $_POST['postcode'], $_POST['type']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=Locations"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono pola nazwa";

					exit(header("Location: ../adminPanel.php?subpage=Locations&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					if(deleteLocalization($_GET['id']))
						exit(header("Location: ../adminPanel.php?subpage=Locations"));
				}

				break;
			// ================================================== PROFILE
			case "Profile":
				if(!empty($_POST['password']) && !empty($_POST['password2']))
				{
					if(changePassword($_SESSION['id'], $_POST['password'], $_POST['password2']))
					{
						unset($_SESSION['error']);
						exit(header("Location: ../adminPanel.php?subpage=Profile"));
					}
				}
				else
					$_SESSION['error'] = "Nie wypełniono wszystkich pól";

				exit(header("Location: ../adminPanel.php?subpage=Profile"));

				break;
			// ================================================== USERS
			case "Users":
				if($_GET['action'] == "add")
				{
					if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['permissions']))
					{
						if(addUser($_POST['name'], $_POST['surname'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['permissions']))
						{
							unset($_SESSION['error']);
							exit(header("Location: ../adminPanel.php?subpage=Users"));
						}
					}
					else
						$_SESSION['error'] = "Nie wypełniono wszystkich pól";
						
					exit(header("Location: ../adminPanel.php?subpage=Users&action=add"));
				}
				else if($_GET['action'] == "edit" && isset($_GET['id']))
				{
					if(editUser($_GET['id'], $_POST['name'], $_POST['surname'], $_POST['login'], $_POST['password'], $_POST['password2'], $_POST['permissions']))
					{
						unset($_SESSION['error']);
						exit(header("Location: ../adminPanel.php?subpage=Users"));
					}
						
					exit(header("Location: ../adminPanel.php?subpage=Users&action=edit&id=".$_GET['id']));
				}
				else if($_GET['action'] == "delete" && isset($_GET['id']))
				{
					exit(header("Location: ../adminPanel.php"));
				}

				break;
		}
	}
	else if(isset($_POST['action']))
	{
		require_once("adminPanelFunctions.php");

		if($_POST['action'] == "displayClientPeople")
			displayOptionDrivers("");
		else if($_POST['action'] == "displayClientCompanies")
			displayOptionCompanies("");

		exit();
	}

	exit(header("Location: ../adminPanel.php"));

?>