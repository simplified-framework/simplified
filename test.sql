-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Jan 2016 um 07:07
-- Server-Version: 5.6.26
-- PHP-Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `test`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(3, 'Smart Home', 'smart-home', '2015-11-22 17:59:15', '2015-11-26 14:33:06'),
(4, 'Category 2', 'category-2', '2015-11-22 17:59:48', '2015-11-22 17:59:48'),
(5, 'Category 3', 'category-3', '2015-11-22 17:59:59', '2015-11-22 18:20:54'),
(6, 'Uncategorized', 'uncategorized', '2015-11-22 18:00:14', '2015-11-22 18:00:14');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories_relations`
--

CREATE TABLE IF NOT EXISTS `categories_relations` (
  `id` int(10) unsigned NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `categories_relations`
--

INSERT INTO `categories_relations` (`id`, `category_id`, `post_id`, `created_at`, `updated_at`) VALUES
(7, '4', 5, '2015-11-26 12:24:39', '2015-11-26 12:24:39'),
(8, '6', 5, '2015-11-26 12:24:39', '2015-11-26 12:24:39'),
(10, '4', 6, '2015-11-26 12:49:01', '2015-11-26 12:49:01'),
(11, '5', 6, '2015-11-26 12:49:01', '2015-11-26 12:49:01'),
(12, '4', 8, '2015-11-26 13:07:36', '2015-11-26 13:07:36'),
(13, '5', 8, '2015-11-26 13:07:36', '2015-11-26 13:07:36'),
(14, '6', 9, '2015-11-26 14:14:10', '2015-11-26 14:14:10'),
(18, '3', 4, '2015-11-27 13:46:19', '2015-11-27 13:46:19');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL,
  `on_post` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` int(10) unsigned NOT NULL DEFAULT '0',
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_11_15_082500_comments', 1),
('2015_11_22_171932_tags', 5),
('2015_11_22_185510_categories', 6),
('2015_11_22_192548_posts', 7),
('2015_11_23_221732_posts_alter', 8),
('2015_11_24_112415_alter_posts', 9),
('2015_11_25_161052_later_posts', 10),
('2015_11_25_194209_alter_tags', 11),
('2015_11_26_095741_categories_relations', 12),
('2015_11_26_111908_alter_posts', 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `teasertext` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `slug`, `body`, `active`, `created_at`, `updated_at`, `teasertext`) VALUES
(4, 2, 'Sicherheitslücken im Zigbee-Protokoll demonstriert', 'sicherheitsluecken-im-zigbee-protokoll-demonstriert', '<p>Smart-Home-Anwendungen sollen den Nutzern das Leben erleichtern. Doch massive Sicherheitsl&uuml;cken k&ouml;nnten das Gegenteil bewirken. Die Sicherheitsforscher Tobias Zillner und Florian Eichelberger haben auf der Sicherheitskonferenz Deepsec in Wien einen praktischen Angriff auf das Smart-Home-Vernetzungsprotokoll vorgestellt. Mit Hilfe eines Software-Defined-Radio, eines Raspberry Pi und einer selbstgeschriebenen Software gelang es ihnen, ein smartes T&uuml;rschloss zu &ouml;ffnen und zu schlie&szlig;en. Unter dem Zigbee-Label produzieren zahlreiche Hersteller verschiedene Ger&auml;te - nicht alle weisen die im Folgenden beschriebenen L&uuml;cken auf.</p>\r\n<p>Eigentlich verf&uuml;gt das auf dem Funkstandard IEEE 802.15.4 basierende Zigbee-Home-Automation-Protokoll in Version 1.2 &uuml;ber einigerma&szlig;en solide Grundlagen - die Ger&auml;te kommunizieren auf dem Netzwerk-Layer mit einer 128-Bit-AES-CCM-Verschl&uuml;sselung - zumindest theoretisch. Denn wer als Hersteller eine Zigbee-Zertifizierung erhalten will, muss nach Angaben von Zillner einen sogenannten R&uuml;ckfallmodus einbauen: Es gibt weiterhin eine Verschl&uuml;sselung, aber der Schl&uuml;sselaustausch wird mit einem &ouml;ffentlich bekannten Schl&uuml;ssel abgesichert und kann daher mitgelesen werden.</p>\r\n<p>Zillner und Eichelberger setzen f&uuml;r ihren Angriff ein Software Defined Radio zum Mith&ouml;ren des Funkverkehrs und ein Raspberry Pi mit dem Funkmodul Raspbee ein, um Befehle zu versenden. Au&szlig;erdem nutzen sie einen handels&uuml;blichen Zigbee-Router. Das im Test verwendete Routermodell geben Zillner und Eichelberger noch nicht bekannt:&nbsp;"Wir haben den Hersteller &uuml;ber die Probleme informiert und wollen ihm die Chance geben, die Probleme zu fixen", sagte Zillner Golem.de.</p>\r\n<p id="gfpop">Im Test belauschen die Sicherheitsforscher den Netzwerk-Traffic zun&auml;chst passiv. Die Ger&auml;te senden in regelm&auml;&szlig;igen Abst&auml;nden (im Normalfall alle f&uuml;nf Sekunden) eine Anfrage an den Zigbee-Router, um Zustands&auml;nderungen abzufragen. Dabei senden die Ger&auml;te auch ihre eigene ID mit - die mit Tools wie Wireshark abgefangen werden kann. Eine Verschl&uuml;sselung auf Anwendungsebene hatten die von den Sicherheitsforschern getestete Ger&auml;ten nicht - auch sicherheitsrelevante Ger&auml;te wie T&uuml;rschl&ouml;sser h&auml;tten eigentlich einen Application Link Key verwenden m&uuml;ssen.</p>', 0, '2015-11-23 09:57:27', '2015-11-27 13:46:19', 'Deepsec 2015 Sicherheitsforscher haben auf der Sicherheitskonferenz Deepsec in Wien eklatante Mängel in der Sicherheit von Zigbee-Smart-Home-Geräten demonstriert. Es gelang ihnen, ein Türschloss zu übernehmen und zu öffnen.'),
(5, 1, 'Ein neuer Post', 'ein-neuer-post', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 0, '2015-11-24 15:09:30', '2015-11-25 16:32:39', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.'),
(9, 1, 'Post without tags', 'post-without-tags', '<p>Post body</p>', 0, '2015-11-26 13:09:33', '2015-11-26 13:09:33', 'Post intro');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `posts_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tags`
--

INSERT INTO `tags` (`id`, `slug`, `created_at`, `updated_at`, `posts_id`) VALUES
(38, 'Created1', '2015-11-26 12:49:01', '2015-11-26 12:49:01', 6),
(39, 'Created2', '2015-11-26 12:49:01', '2015-11-26 12:49:01', 6),
(40, 'Tag1', '2015-11-26 13:07:36', '2015-11-26 13:07:36', 8),
(42, 'Tag', '2015-11-26 14:14:10', '2015-11-26 14:14:10', 9),
(46, 'smarthome', '2015-11-27 13:46:19', '2015-11-27 13:46:19', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('admin','author','subscriber') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'author',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '', '', 'author', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Testuser', 'testmail@test-domain.tld', '', 'author', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_title_unique` (`title`);

--
-- Indizes für die Tabelle `categories_relations`
--
ALTER TABLE `categories_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_on_post_foreign` (`on_post`),
  ADD KEY `comments_from_user_foreign` (`from_user`);

--
-- Indizes für die Tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_title_unique` (`title`);

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `categories_relations`
--
ALTER TABLE `categories_relations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT für Tabelle `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_from_user_foreign` FOREIGN KEY (`from_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_on_post_foreign` FOREIGN KEY (`on_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
