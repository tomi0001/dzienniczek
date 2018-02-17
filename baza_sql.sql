-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Lut 2018, 13:55
-- Wersja serwera: 10.1.25-MariaDB
-- Wersja PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `laravel`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dni_nastrojow`
--s

CREATE TABLE `dni_nastrojow` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `id_dnia` int(11) DEFAULT NULL,
  `nastroj` int(11) NOT NULL,
  `liczba_sekund` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `dni_nastrojow`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dziennik`
--

CREATE TABLE `dziennik` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_nastroj` int(11) NOT NULL,
  `id_sen` int(11) NOT NULL,
  `data_dodania` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `leki`
--

CREATE TABLE `leki` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `dawka` float NOT NULL,
  `data_spozycia` datetime NOT NULL,
  `id_users` int(11) NOT NULL,
  `porcja` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `leki`
--



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nastroj`
--

CREATE TABLE `nastroj` (
  `id` int(11) NOT NULL,
  `id_dziennik` int(11) DEFAULT NULL,
  `godzina_zaczecia` datetime NOT NULL,
  `godzina_zakonczenia` datetime NOT NULL,
  `id_users` int(11) NOT NULL,
  `poziom_nastroju` smallint(6) NOT NULL,
  `co_robilem` text COLLATE utf8mb4_unicode_ci,
  `id_lekow` int(11) DEFAULT NULL,
  `poziom_leku` smallint(6) NOT NULL,
  `poziom_zdenerwania` smallint(6) NOT NULL,
  `epizod_psychotyczne` smallint(6) NOT NULL,
  `pobudzenie` smallint(6) NOT NULL,
  `id_dnia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `nastroj`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przekierowanie_lekow`
--

CREATE TABLE `przekierowanie_lekow` (
  `id` int(11) NOT NULL,
  `id_leku` int(11) NOT NULL,
  `id_nastroj` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `przekierowanie_lekow`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sen`
--

CREATE TABLE `sen` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_dziennik` int(11) DEFAULT NULL,
  `data_rozpoczecia` datetime NOT NULL,
  `data_zakonczenia` datetime NOT NULL,
  `ilosc_wybudzen` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `sen`
--



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `poczatek_dnia` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `users`
--


--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `dni_nastrojow`
--
ALTER TABLE `dni_nastrojow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dziennik`
--
ALTER TABLE `dziennik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leki`
--
ALTER TABLE `leki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nastroj`
--
ALTER TABLE `nastroj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `przekierowanie_lekow`
--
ALTER TABLE `przekierowanie_lekow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sen`
--
ALTER TABLE `sen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dni_nastrojow`
--
ALTER TABLE `dni_nastrojow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT dla tabeli `dziennik`
--
ALTER TABLE `dziennik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `leki`
--
ALTER TABLE `leki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;
--
-- AUTO_INCREMENT dla tabeli `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `nastroj`
--
ALTER TABLE `nastroj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;
--
-- AUTO_INCREMENT dla tabeli `przekierowanie_lekow`
--
ALTER TABLE `przekierowanie_lekow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;
--
-- AUTO_INCREMENT dla tabeli `sen`
--
ALTER TABLE `sen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
