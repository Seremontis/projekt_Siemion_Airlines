-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Cze 2018, 21:12
-- Wersja serwera: 10.1.31-MariaDB
-- Wersja PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `siemionairlines`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `Imie` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Nazwisko` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PESEL` varchar(11) NOT NULL,
  `mail` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `login` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id_pracownika` int(11) NOT NULL,
  `Imie` varchar(15) NOT NULL,
  `Nazwisko` varchar(20) NOT NULL,
  `PESEL` varchar(15) NOT NULL,
  `mail` varchar(20) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `adres_zamieszkania` varchar(50) NOT NULL,
  `login` varchar(15) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `Uprawnienia` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id_pracownika`, `Imie`, `Nazwisko`, `PESEL`, `mail`, `telefon`, `adres_zamieszkania`, `login`, `haslo`, `Uprawnienia`) VALUES
(1, '', '', '', '', '', '', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `id_rezerwacji` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `id_rozklad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rozklad`
--

CREATE TABLE `rozklad` (
  `id_rozkladu` int(11) NOT NULL,
  `Data` date NOT NULL,
  `godzina` time NOT NULL,
  `id_trasy` int(11) NOT NULL,
  `id_samolotu` int(11) NOT NULL,
  `ilosc_rezerwacji` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samolot`
--

CREATE TABLE `samolot` (
  `id_samolotu` int(11) NOT NULL,
  `model` varchar(50) NOT NULL,
  `marka` varchar(50) NOT NULL,
  `nr_taborowy` varchar(5) NOT NULL,
  `ilosc_miejsc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `trasa`
--

CREATE TABLE `trasa` (
  `id_trasy` int(11) NOT NULL,
  `Skad` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Dokad` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `zalecana_pojemnosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id_pracownika`);

--
-- Indeksy dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id_rezerwacji`),
  ADD KEY `rezerwacje_ibfk_1` (`id_klienta`),
  ADD KEY `rezerwacje_ibfk_2` (`id_rozklad`);

--
-- Indeksy dla tabeli `rozklad`
--
ALTER TABLE `rozklad`
  ADD PRIMARY KEY (`id_rozkladu`),
  ADD KEY `rozklad_ibfk_1` (`id_samolotu`),
  ADD KEY `rozklad_ibfk_2` (`id_trasy`);

--
-- Indeksy dla tabeli `samolot`
--
ALTER TABLE `samolot`
  ADD PRIMARY KEY (`id_samolotu`);

--
-- Indeksy dla tabeli `trasa`
--
ALTER TABLE `trasa`
  ADD PRIMARY KEY (`id_trasy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id_pracownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id_rezerwacji` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `rozklad`
--
ALTER TABLE `rozklad`
  MODIFY `id_rozkladu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `samolot`
--
ALTER TABLE `samolot`
  MODIFY `id_samolotu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `trasa`
--
ALTER TABLE `trasa`
  MODIFY `id_trasy` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `rezerwacje_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE,
  ADD CONSTRAINT `rezerwacje_ibfk_2` FOREIGN KEY (`id_rozklad`) REFERENCES `rozklad` (`id_rozkladu`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `rozklad`
--
ALTER TABLE `rozklad`
  ADD CONSTRAINT `rozklad_ibfk_1` FOREIGN KEY (`id_samolotu`) REFERENCES `samolot` (`id_samolotu`) ON DELETE CASCADE,
  ADD CONSTRAINT `rozklad_ibfk_2` FOREIGN KEY (`id_trasy`) REFERENCES `trasa` (`id_trasy`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
