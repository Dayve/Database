-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Cze 2016, 13:52
-- Wersja serwera: 10.1.13-MariaDB
-- Wersja PHP: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt`
--

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `dodajOceneKoncowa` (IN `pWartosc` FLOAT(4,2), IN `pNumerAlbumu` INT(6), IN `pNazwaPrzedmiotu` VARCHAR(50) CHARSET latin1, IN `pSemestr` INT(1))  begin
if ((select count(*) from przedmiot where przedmiot.nazwa = pNazwaPrzedmiotu and przedmiot.semestr = pSemestr) = 0) then
select 'Brak przedmiotu o podanych parametrach';
end if;
set @id_przedmiotu = (select przedmiot.id_przedmiotu from przedmiot where przedmiot.nazwa = pNazwaPrzedmiotu and przedmiot.semestr = pSemestr limit 1);
insert into ocenakoncowa values(pWartosc, CURDATE(), pNumerAlbumu, @id_przedmiotu);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dodajProwadzacego` (IN `pImie` VARCHAR(20), IN `pNazwisko` VARCHAR(30), IN `pTytul` VARCHAR(30))  begin
set @id = 100000;
if ((select count(*) from prowadzacy) > 0) then
set @id = ((select max(prowadzacy.id_prowadzacego) from prowadzacy) + 1);
end if;
insert into prowadzacy values(@id, pNazwisko, pImie, pTytul);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dodajPrzedmiot` (IN `pNazwa` VARCHAR(50), IN `pECTS` INT(2), IN `pSposobZaliczenia` ENUM('Egzamin','Zaliczenie'), IN `pSemestr` INT(1), IN `pTyp` ENUM('Obieralny','Podstawowy','Kierunkowy'), IN `pIloscGodzin` INT(2))  begin set @idTypu = 100000; set @idPrzed = 100000; if ((select count(*) from typprzedmiotu) > 0) then set @idTypu = ((select max(typprzedmiotu.id_typuprzedmiotu) from typprzedmiotu) + 1); end if; if ((select count(*) from przedmiot) > 0) then
set @idPrzed = ((select max(przedmiot.id_przedmiotu) from przedmiot) + 1);
end if;
insert into typprzedmiotu values(@idTypu, pTyp, pIloscGodzin);
insert into przedmiot values(@idPrzed, pNazwa, pECTS, pSposobZaliczenia, pSemestr, @idTypu);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dodajStudenta` (IN `pPESEL` VARCHAR(11), IN `pImie` VARCHAR(20), IN `pNazwisko` VARCHAR(30), IN `pKierunek` VARCHAR(50), IN `pGrupa` VARCHAR(3), IN `pStatus` ENUM('zawieszony','skreslony','studiuje','dlug kredytowy','urlop'))  begin set @numer = 100000; if ((select count(*) from student) > 0) then set @numer = ((select max(student.numeralbumu) from student) + 1); end if; insert into student values(@numer, pPESEL, pImie, pNazwisko, pKierunek, pStatus, pGrupa); end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dodajZajecia` (`pGodzina` TIME, `pNumerSali` VARCHAR(5), `pDzienTygodnia` ENUM('pon','wt','sr','czw','pt','sob','nd'), `pID_TypuZajec` INT(6), `pID_Prowadzacego` INT(6), `pID_Przedmiotu` INT(6))  begin
set @id = 100000;
if ((select count(*) from zajecia) > 0) then
set @id = ((select max(zajecia.ID_Zajec) from zajecia) + 1);
end if;
insert into zajecia values(@id, pGodzina, pNumerSali, pDzienTygodnia, pID_TypuZajec, pID_Prowadzacego, pID_Przedmiotu);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `srednia` (`pNumerAlbumu` INT(6))  begin
set @srednia = (select avg(ocenakoncowa.wartosc) from ocenakoncowa where ocenakoncowa.numeralbumu = pNumerAlbumu); 
select @srednia;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ocenakoncowa`
--

CREATE TABLE `ocenakoncowa` (
  `Wartosc` float(4,2) NOT NULL,
  `DataWystawienia` date NOT NULL,
  `NumerAlbumu` int(6) NOT NULL,
  `ID_Przedmiotu` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `ocenakoncowa`
--

INSERT INTO `ocenakoncowa` (`Wartosc`, `DataWystawienia`, `NumerAlbumu`, `ID_Przedmiotu`) VALUES
(5.00, '2016-06-07', 1234, 222004),
(4.00, '2016-06-20', 5436, 222008),
(3.00, '2016-06-20', 5436, 222008),
(2.00, '2016-06-20', 1234, 222008),
(5.00, '2016-06-20', 1234, 222011);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prowadzacy`
--

CREATE TABLE `prowadzacy` (
  `ID_Prowadzacego` int(6) NOT NULL,
  `Nazwisko` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Imie` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Tytul` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `prowadzacy`
--

INSERT INTO `prowadzacy` (`ID_Prowadzacego`, `Nazwisko`, `Imie`, `Tytul`) VALUES
(287117, 'Maleńczuk ', 'Marek', 'mgr inż.'),
(323111, 'Skiba', 'Krzysztof', 'mgr inż.'),
(337974, 'Piaseczny', 'Andrzej', 'mgr'),
(436222, 'Kowalski', 'Sławomir', 'dr inż.'),
(547892, 'Podsiadło', 'Dawid', 'dr hab. inż.'),
(562917, 'Rabczewska', 'Dorota', 'prof. dr hab. inż.'),
(666865, 'Krawczyk', 'Krzysztof', 'dr hab. inż.'),
(753868, 'Rodowicz', 'Maryla', 'dr inż.'),
(753869, 'Schiff', 'Krzysztof', 'dr');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmiot`
--

CREATE TABLE `przedmiot` (
  `ID_Przedmiotu` int(6) NOT NULL,
  `Nazwa` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ECTS` int(2) NOT NULL,
  `SposobZaliczenia` enum('Egzamin','Zaliczenie') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Semestr` int(1) NOT NULL,
  `ID_TypuPrzedmiotu` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `przedmiot`
--

INSERT INTO `przedmiot` (`ID_Przedmiotu`, `Nazwa`, `ECTS`, `SposobZaliczenia`, `Semestr`, `ID_TypuPrzedmiotu`) VALUES
(222000, 'Wychowanie Fizyczne', 2, 'Zaliczenie', 1, 111000),
(222001, 'Wychowanie Fizyczne', 2, 'Zaliczenie', 2, 111000),
(222002, 'Język Angielski', 4, 'Zaliczenie', 1, 111000),
(222003, 'Język Angielski', 4, 'Zaliczenie', 2, 111000),
(222004, 'Język Angielski', 4, 'Zaliczenie', 3, 111000),
(222005, 'Łacina', 5, 'Egzamin', 4, 111001),
(222006, 'Muzyczny Kanon Informatyka', 1, 'Egzamin', 7, 111002),
(222007, 'Matematyka Dyskretna', 8, 'Egzamin', 4, 111002),
(222008, 'Sieci Komputerowe', 6, 'Egzamin', 5, 111004),
(222009, 'Plastyka', 4, 'Egzamin', 6, 111003),
(222010, 'Architektura Systemów Komputerowych ', 1, 'Zaliczenie', 4, 111005),
(222011, 'Matematyka Niedyskretna i Hazard', 4, 'Egzamin', 3, 111001),
(222012, 'Nowy Testowy', 14, 'Egzamin', 6, 111006);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `student`
--

CREATE TABLE `student` (
  `NumerAlbumu` int(6) NOT NULL,
  `PESEL` varchar(11) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Imie` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Kierunek` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Status` enum('zawieszony','skreslony','studiuje','dlug kredytowy','urlop') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Grupa` varchar(3) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `student`
--

INSERT INTO `student` (`NumerAlbumu`, `PESEL`, `Imie`, `Nazwisko`, `Kierunek`, `Status`, `Grupa`) VALUES
(1234, '95112912345', 'Konrad', 'Maroszek', 'Towaroznawstwo', 'dlug kredytowy', '22t'),
(5434, '95120309875', 'Jakub', 'Młocek', 'Matematyka Teoretyczna', 'skreslony', '1kp'),
(5435, '93110365342', 'Jan', 'Maj', 'Mechanika', 'studiuje', '34f'),
(5436, '83627548', 'Kazimierz', 'Ulam', 'Turystyka', 'urlop', '54g');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typprzedmiotu`
--

CREATE TABLE `typprzedmiotu` (
  `ID_TypuPrzedmiotu` int(6) NOT NULL,
  `NazwaTypu` enum('Obieralny','Podstawowy','Kierunkowy') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `IloscGodzin` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `typprzedmiotu`
--

INSERT INTO `typprzedmiotu` (`ID_TypuPrzedmiotu`, `NazwaTypu`, `IloscGodzin`) VALUES
(111000, 'Podstawowy', 30),
(111001, 'Podstawowy', 45),
(111002, 'Kierunkowy', 60),
(111003, 'Obieralny', 120),
(111004, 'Obieralny', 150),
(111005, 'Kierunkowy', 90),
(111006, 'Podstawowy', 60);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typzajec`
--

CREATE TABLE `typzajec` (
  `ID_TypuZajec` int(6) NOT NULL,
  `NazwaTypuZajec` enum('Laboratorium','Projekt','Wyklad','Cwiczenia') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `IloscGodzin` int(3) NOT NULL,
  `MaxLiczbaMiejsc` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `typzajec`
--

INSERT INTO `typzajec` (`ID_TypuZajec`, `NazwaTypuZajec`, `IloscGodzin`, `MaxLiczbaMiejsc`) VALUES
(333000, 'Laboratorium', 30, 15),
(333001, 'Laboratorium', 15, 30),
(333002, 'Laboratorium', 30, 30),
(333003, 'Projekt', 45, 20),
(333004, 'Wykład', 30, 120),
(333005, 'Wykład', 45, 240),
(333006, 'Wykład', 15, 30),
(333007, 'Wykład', 30, 15);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zajecia`
--

CREATE TABLE `zajecia` (
  `ID_Zajec` int(6) NOT NULL,
  `Godzina` time NOT NULL,
  `NumerSali` varchar(5) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `DzienTygodnia` enum('pon','wt','sr','czw','pt','sob','nd') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ID_TypuZajec` int(6) NOT NULL,
  `ID_Prowadzacego` int(6) NOT NULL,
  `ID_Przedmiotu` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `zajecia`
--

INSERT INTO `zajecia` (`ID_Zajec`, `Godzina`, `NumerSali`, `DzienTygodnia`, `ID_TypuZajec`, `ID_Prowadzacego`, `ID_Przedmiotu`) VALUES
(444001, '07:15:00', '12', 'pon', 333006, 287117, 222000),
(444002, '07:15:00', '6', 'wt', 333006, 323111, 222000),
(444003, '14:30:00', '13', 'czw', 333003, 337974, 222001);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zajeciastudenta`
--

CREATE TABLE `zajeciastudenta` (
  `NumerAlbumu` int(6) NOT NULL,
  `ID_Zajec` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `ocenakoncowa`
--
ALTER TABLE `ocenakoncowa`
  ADD KEY `NumerAlbumu` (`NumerAlbumu`),
  ADD KEY `ID_Przedmiotu` (`ID_Przedmiotu`);

--
-- Indexes for table `prowadzacy`
--
ALTER TABLE `prowadzacy`
  ADD PRIMARY KEY (`ID_Prowadzacego`);

--
-- Indexes for table `przedmiot`
--
ALTER TABLE `przedmiot`
  ADD PRIMARY KEY (`ID_Przedmiotu`),
  ADD KEY `ID_TypuPrzedmiotu` (`ID_TypuPrzedmiotu`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`NumerAlbumu`);

--
-- Indexes for table `typprzedmiotu`
--
ALTER TABLE `typprzedmiotu`
  ADD PRIMARY KEY (`ID_TypuPrzedmiotu`);

--
-- Indexes for table `typzajec`
--
ALTER TABLE `typzajec`
  ADD PRIMARY KEY (`ID_TypuZajec`);

--
-- Indexes for table `zajecia`
--
ALTER TABLE `zajecia`
  ADD PRIMARY KEY (`ID_Zajec`),
  ADD KEY `ID_TypuZajęć` (`ID_TypuZajec`),
  ADD KEY `ID_Prowadzącego` (`ID_Prowadzacego`),
  ADD KEY `ID_Przedmiotu` (`ID_Przedmiotu`);

--
-- Indexes for table `zajeciastudenta`
--
ALTER TABLE `zajeciastudenta`
  ADD KEY `ID_Zajęć` (`ID_Zajec`),
  ADD KEY `NumerAlbumu` (`NumerAlbumu`);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `ocenakoncowa`
--
ALTER TABLE `ocenakoncowa`
  ADD CONSTRAINT `ocenakoncowa_ibfk_1` FOREIGN KEY (`NumerAlbumu`) REFERENCES `student` (`NumerAlbumu`),
  ADD CONSTRAINT `ocenakoncowa_ibfk_2` FOREIGN KEY (`ID_Przedmiotu`) REFERENCES `przedmiot` (`ID_Przedmiotu`);

--
-- Ograniczenia dla tabeli `przedmiot`
--
ALTER TABLE `przedmiot`
  ADD CONSTRAINT `przedmiot_ibfk_1` FOREIGN KEY (`ID_TypuPrzedmiotu`) REFERENCES `typprzedmiotu` (`ID_TypuPrzedmiotu`);

--
-- Ograniczenia dla tabeli `zajecia`
--
ALTER TABLE `zajecia`
  ADD CONSTRAINT `zajecia_ibfk_1` FOREIGN KEY (`ID_Prowadzacego`) REFERENCES `prowadzacy` (`ID_Prowadzacego`),
  ADD CONSTRAINT `zajecia_ibfk_2` FOREIGN KEY (`ID_TypuZajec`) REFERENCES `typzajec` (`ID_TypuZajec`),
  ADD CONSTRAINT `zajecia_ibfk_3` FOREIGN KEY (`ID_Przedmiotu`) REFERENCES `przedmiot` (`ID_Przedmiotu`);

--
-- Ograniczenia dla tabeli `zajeciastudenta`
--
ALTER TABLE `zajeciastudenta`
  ADD CONSTRAINT `zajeciastudenta_ibfk_1` FOREIGN KEY (`NumerAlbumu`) REFERENCES `student` (`NumerAlbumu`),
  ADD CONSTRAINT `zajeciastudenta_ibfk_2` FOREIGN KEY (`ID_Zajec`) REFERENCES `zajecia` (`ID_Zajec`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
