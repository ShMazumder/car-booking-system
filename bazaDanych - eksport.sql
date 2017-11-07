-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Maj 2017, 15:09
-- Wersja serwera: 10.1.16-MariaDB
-- Wersja PHP: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `23387158_paula`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `additional_fees`
--

CREATE TABLE `additional_fees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `additional_fees`
--

INSERT INTO `additional_fees` (`id`, `name`, `price`) VALUES
(1, 'Fotelik - grupa A (0kg-9kg)', 10.00),
(2, 'Fotelik Isofix - grupa B (9kg-18kg)', 15.00),
(3, 'Fotelik Isofix - grupa C (15kg-36kg)', 15.00),
(4, 'Fotelik Podkładka - grupa D', 10.00),
(5, 'Nawigacja GPS', 15.00),
(6, 'Łańcuchy śnieżne', 10.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `additional_reservation`
--

CREATE TABLE `additional_reservation` (
  `id` int(11) NOT NULL,
  `additional_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `additional_reservation`
--

INSERT INTO `additional_reservation` (`id`, `additional_id`, `reservation_id`) VALUES
(1, 5, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `body_type`
--

CREATE TABLE `body_type` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `body_type`
--

INSERT INTO `body_type` (`id`, `name`) VALUES
(1, 'Sedan'),
(2, 'Coupe'),
(3, 'Hatchback'),
(4, 'Furgon'),
(5, 'Bus');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `manufacture_year` varchar(4) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `varnish_color` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `nr_of_seats` int(11) NOT NULL,
  `engine` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `engine_power` varchar(10) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `drive` varchar(10) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL,
  `gear_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `body_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `mileage` varchar(10) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(2000) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `id_localization` int(11) NOT NULL,
  `price_class` int(11) NOT NULL,
  `avaliable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `cars`
--

INSERT INTO `cars` (`id`, `name`, `type`, `manufacture_year`, `varnish_color`, `nr_of_seats`, `engine`, `engine_power`, `drive`, `gear_type`, `body_type`, `mileage`, `description`, `id_localization`, `price_class`, `avaliable`) VALUES
(1, 'Infiniti Q50H', 'Automat', '2014', 'Niebieski Metalic', 5, '3.5 Hybryda', '364', 'AWD', 'Automat', '1', '120000', 'INFINITI Q50, 3.5 Hybryda, 2014, 364 KM, Niebieski Metalic<br> Elektryczne wspomaganie kierownicy DAS<br> Elektrycznie podnoszone szyby<br> Klimatyzacja automatyczna dwustrefowa, klimatronic<br> Automatyczna skrzynia biegów, 7 biegowa<br> Elektrycznie sterowane i podgrzewane skórzane fotele<br> Wielofunkcyjna kierownica<br> Nagłośnienie BOSE Performance z 13 głośnikami<br> Tuner Fm/uss/co/Aux-RcA/Bluetooth<br> Reflektory Xenonowe plus LED<br> Podwójny ekran dotykowy<br> Czujniki parkowania<br> Kamera cofania<br> Moduł rozpoznawania znaków drogowych<br> Aktywny tempomat<br> Silnik Hybrydowy<br>', 1, 1, 0),
(2, 'Infiniti Q60', 'Automat', '2016', 'Czarny Metalic', 4, '2.0 Turbo', '211', 'RWD', 'Automat', '2', '5000', 'INFINITI Q60, 2.0 T Sport<br> Elektryczne wspomaganie układu elektrycznego DAS<br> Elektrycznie podnoszone szyby<br> Klimatyzacja elektrycznie sterowana dwustrefowa<br> Automatyczna skrzynia biegów, 7 biegowa<br> Elektrycznie sterowane i podgrzewane skórzane fotele<br> Wielofunkcyjna kierownica<br> Nagłośnienie BOSE Performance z 13 głośnikami<br> Tuner FM/USB/CD/AUX-RCA/Bluetooth<br> Reflektory Xenonowe plus LED<br> Podwójny ekran dotykowy<br> Czujniki parkowania<br> Kamera cofania<br>', 1, 1, 0),
(3, 'Infiniti Q30', 'Automat', '2016', 'Grafitowy Metalic', 5, '2.0 Turbo', '211', 'RWD', 'Automat', '3', '3000', 'INFINITI Q30, 2.0 T Sport, 2016, 211 KM, Grafit<br> Elektryczne wspomaganiekierownicy DAS<br> Elektrycznie podnoszone szyby<br> Klimatyzacja automatyczna dwustrefowa, klimatronic<br> Automatyczna skrzynia biegów, 7 biegowa<br> Elektrycznie sterowane i podgrzewane skórzane fotele<br> Wielofunkcyjna kierownica<br> Nagłośnienie BOSE Performance z 13 głośnikami<br> Tuner Fm/use/co/Aux-RcA/Bluetooth<br> Reflektory Xenonowe plus LED<br> Podwójny ekran dotykowy<br> Czujniki parkowania<br> Kamera cofania<br> Moduł rozpoznawania znaków drogowych<br> Aktywny tempomat<br> Panoramiczny dach<br>', 1, 2, 0),
(4, 'Mercedes C200', 'Automat', '2016', 'Biały', 5, '2.0 Turbo', '184', 'AWD', 'Automat', '1', '18500', 'Mercedes C200, 2016 rok<br> Automatyczna 8 biegowa skrzynia biegów<br> Nawigacja<br> Panel dotykowy<br> Tuner FM/USB/AUX/Bluetooth<br> Automatyczna klimatyzacja dwustrefowa<br> Elektrycznie sterowane podgrzewane skórzane fotele<br> Elektrycznie podnoszone szyby<br>', 1, 1, 0),
(5, 'Mercedes GLA 2015', 'Automat', '2015', 'Czerwony Metalic', 5, '1.6', '156', 'FWD', 'Automat', '3', '52000', 'Mercedes GLA AMG Pakiet, 1.6, 2015, 156 KM, Czerwony<br> Elektrycznie podnoszone szyby<br> Automatyczna skrzynia biegów<br> Elektrycznie sterowane i podgrzewane skórzane Pakiet AMG<br> Wielofunkcyjna kierownica<br> Klimatyzacja automatyczna dwustrefowa, klimatronic<br> Nagłośnienie premium<br> Tuner Fm/uss/co/Aux-RcA/Bluetooth<br> Reflektory Xenonowe plus LED<br> Panel dotykowy<br> Czujniki parkowania<br> Kamera cofania<br> Moduł rozpoznawania znaków drogowych<br> Aktywny tempomat<br> Nawigacja<br> Asystent zmeczenia 3 tryby pracy silnika: Tryb ECO, SPORT, STANDARD<br>', 1, 2, 1),
(6, 'Mercedes GLA 2016', 'Automat', '2016', 'Czerwony Metalic', 5, '2.0 Turbo', '211', 'FWD', 'Automat', '3', '10000', 'Mercedes GLA AMG Pakiet, 2.0 T, 2016, 211 KM, Czerwony<br> Elektrycznie podnoszone szyby<br> Automatyczna skrzynia biegów, 7, 4Matic<br> Elektrycznie sterowane i podgrzewane skórzane Pakiet AMG<br> Wielofunkcyjna kierownica<br> Klimatyzacja automatyczna dwustrefowa, klimatronic<br> Nagłośnienie premium<br> Tuner Fm/uss/co/Aux-RcA/Bluetooth<br> Reflektory Xenonowe plus LED<br> Panel dotykowy<br> Czujniki parkowania<br> Kamera cofania<br> Moduł rozpoznawania znaków drogowych<br> Aktywny tempomat<br> Nawigacja<br> Asystent zmeczenia 3 tryby pracy silnika: Tryb ECO, SPORT, STANDARD<br>', 1, 2, 1),
(7, 'BMW 5', 'Manual', '2008', 'Czarny Metalic', 5, '4.0 Pb + LPG', '306', 'RWD', 'Manual', '1', '350000', 'BMW 5, 4.0 [Pb-FLPG], 2008, 306 KM, Czarny<br> Elektrycznie podnoszone szyby<br> Manualna skrzynia biegów<br> Elektrycznie sterowane i podgrzewane skórzane<br> Aktywne zagłówki<br> Wielofunkcyjna kierownica<br> Klimatyzacja automatyczna dwustrefowa, klimatronic<br> Nagłośnienie premium<br> Tuner Fm/uss/co/Aux-RcA/Bluetooth<br> Aktywny tempomat<br> Nawigacja<br>', 1, 3, 0),
(8, 'Fiat Doblo', 'Manual', '2016', 'Biały', 5, '1.9 D', '110', 'FWD', 'Manual', '4', '1500', 'Fiat Doblo, Maxi, 1,9 D, 2016, 110 KM, Biały<br> Elektrycznie podnoszone szyby<br> Manualna skrzynia biegów<br> Wielofunkcyjna kierownica<br> Klimatyzacja automatyczna dwustrefowa, klimatronic<br> Tuner Fm/uss/co/Aux-RcA/Bluetooth<br> Składane lusterka<br> Składane fotele tylne 5 drzwi, boczne przesuwane<br> Powiększona powierzchnia bagażowa<br>', 1, 4, 1),
(9, 'Renault Traffic', 'Manual', '2008', 'Grafit', 9, 'Diesel', '100', 'FWD', 'Manual', '5', '50000', 'Renault Traf ic Passenger, 110 D, 2008, 110 KM, Grafit<br> Elektrycznie podnoszone szyby<br> Manualna skrzynia biegów<br> Wielofunkcyjna kierownica<br> Klimatyzacja automatyczna, klimatronic<br> Nawiewy indywidualne/pasażerskie<br> Tuner FM/USB/CD/AUX-RCA/Bluetooth<br> Tempomat<br> Nawigacja<br>', 1, 5, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `postcode` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(40) NOT NULL,
  `NIP` varchar(13) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `id_companies` int(11) DEFAULT NULL,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `ident_card` varchar(9) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `driving_licence` varchar(13) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL,
  `postcode` varchar(20) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL,
  `city` varchar(40) NOT NULL,
  `country` varchar(40) NOT NULL,
  `phone` varchar(11) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `drivers`
--

INSERT INTO `drivers` (`id`, `id_companies`, `name`, `surname`, `pesel`, `ident_card`, `driving_licence`, `address`, `postcode`, `city`, `country`, `phone`, `email`) VALUES
(1, NULL, 'Bartosz', 'Majdan', '98100304777', 'CBT 77888', '11111/11/1111', 'Dąbków 93a', '37-600', 'Kraków', 'Polska', '726410922', 'bjamk93@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `permissions` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `employees`
--

INSERT INTO `employees` (`id`, `name`, `surname`, `login`, `password`, `last_login`, `permissions`) VALUES
(1, 'Michał', 'Słoboda', 'm.sloboda', '$2y$10$Q/ETkUUc9v7wWe6RGmYdi.R4mzymAEGHgupcqDih307V3bimeenhC', '2017-05-03 16:05:42', 'Administrator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `nr_img` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `extension` varchar(6) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `images`
--

INSERT INTO `images` (`id`, `nr_img`, `id_car`, `extension`) VALUES
(1, 1, 1, 'png'),
(2, 1, 2, 'png'),
(3, 1, 3, 'png'),
(4, 1, 4, 'png'),
(5, 1, 5, 'png'),
(6, 1, 6, 'png'),
(7, 1, 7, 'png'),
(8, 1, 8, 'png'),
(9, 1, 9, 'png'),
(13, 2, 2, 'png'),
(14, 3, 2, 'png'),
(15, 4, 2, 'png'),
(16, 2, 3, 'png'),
(17, 3, 3, 'png'),
(18, 4, 3, 'png'),
(19, 5, 3, 'png'),
(20, 2, 4, 'png'),
(21, 3, 4, 'png'),
(22, 2, 1, 'png'),
(23, 3, 1, 'png'),
(24, 4, 1, 'png'),
(25, 2, 9, 'jpg'),
(26, 3, 9, 'jpg'),
(27, 4, 9, 'jpg'),
(28, 5, 9, 'jpg'),
(29, 6, 9, 'jpg'),
(30, 7, 9, 'jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `localizations`
--

CREATE TABLE `localizations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `postcode` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `localizations`
--

INSERT INTO `localizations` (`id`, `name`, `address`, `city`, `postcode`, `type`) VALUES
(1, 'Gładysz Motors', 'Łukanowice 239', 'Wojnicz', '32-830', 'Siedziba');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `nr_reservation` varchar(25) COLLATE utf8_polish_ci NOT NULL,
  `operation_number` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `operation_type` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `operation_status` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `operation_amount` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `operation_currency` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `operation_original_amount` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `operation_original_currency` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `operation_datetime` datetime NOT NULL,
  `control` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `p_info` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `p_email` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `channel` varchar(4) COLLATE utf8_polish_ci NOT NULL,
  `signature` varchar(300) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `price_class`
--

CREATE TABLE `price_class` (
  `id` int(11) NOT NULL,
  `name` varchar(3) COLLATE utf8_polish_ci NOT NULL,
  `five` int(11) NOT NULL,
  `ten` int(11) NOT NULL,
  `fifteen` int(11) NOT NULL,
  `bail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `price_class`
--

INSERT INTO `price_class` (`id`, `name`, `five`, `ten`, `fifteen`, `bail`) VALUES
(1, 'E', 250, 225, 200, 1000),
(2, 'D+', 220, 198, 176, 1000),
(3, 'D', 200, 180, 160, 650),
(4, 'M', 180, 162, 144, 650),
(5, 'P', 300, 270, 240, 650);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `reservation_nr` varchar(25) COLLATE utf8_polish_ci NOT NULL,
  `company/person` tinyint(1) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `id_location_receipt` int(11) NOT NULL,
  `id_location_return` int(11) NOT NULL,
  `f_VAT` tinyint(4) NOT NULL,
  `price` double(10,2) NOT NULL,
  `status` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_nr`, `company/person`, `id_driver`, `id_car`, `start_date`, `end_date`, `id_location_receipt`, `id_location_return`, `f_VAT`, `price`, `status`) VALUES
(1, '06052017-150052-262', 1, 1, 3, '2017-05-06 14:40:00', '2017-05-06 20:55:00', 1, 1, 0, 401.00, 'Do zapłaty');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `additional_fees`
--
ALTER TABLE `additional_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `additional_reservation`
--
ALTER TABLE `additional_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `body_type`
--
ALTER TABLE `body_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `localizations`
--
ALTER TABLE `localizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_class`
--
ALTER TABLE `price_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `additional_fees`
--
ALTER TABLE `additional_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `additional_reservation`
--
ALTER TABLE `additional_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `body_type`
--
ALTER TABLE `body_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT dla tabeli `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT dla tabeli `localizations`
--
ALTER TABLE `localizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `price_class`
--
ALTER TABLE `price_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
