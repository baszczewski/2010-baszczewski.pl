-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2010 at 04:32 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `baszczewski`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_blogroll`
--

CREATE TABLE IF NOT EXISTS `blog_blogroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `url` varchar(512) NOT NULL,
  `order` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blog_blogroll`
--

INSERT INTO `blog_blogroll` (`id`, `title`, `url`, `order`, `visible`) VALUES
(1, 'Marcin Baszczewski', 'http://baszczewski.pl/', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `order`, `title`, `visible`, `name`) VALUES
(1, 1, 'Brak', 1, 'brak');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `user` varchar(256) NOT NULL,
  `note_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `system` int(11) NOT NULL,
  `website` varchar(1024) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `text`, `user`, `note_id`, `date`, `system`, `website`, `active`) VALUES
(1, 'Komentarze działają.', 'Ktoś', 1, '2010-05-14 00:00:00', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_files`
--

CREATE TABLE IF NOT EXISTS `blog_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `note_id` int(11) NOT NULL,
  `url` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `blog_files`
--


-- --------------------------------------------------------

--
-- Table structure for table `blog_notes`
--

CREATE TABLE IF NOT EXISTS `blog_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `rating` int(11) NOT NULL,
  `rating_count` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `blog_notes`
--

INSERT INTO `blog_notes` (`id`, `title`, `text`, `date`, `rating`, `rating_count`, `visible`, `name`, `description`) VALUES
(1, 'Hello World', '##True##\nZazwyczaj zaczyna się od takiego wpisu.', '2010-05-14 00:00:00', 3, 1, 1, 'hello-world', 'wypis'),
(2, 'Dokumentacja', '## Ups ##\nNiestety skrypt nie posiada dokumentacji. Jego analiza będzie tym bardziej utrudniona. Jeśli jednak masz jakieś pytania pamiętaj, że możesz się do mnie zgłosić :)\n\nBaner:  \n\n![baner](baner.gif)  \n\nJeśli dziwi Cię sposób zapisania wpisów w panelu administracyjnym zerknij na dokumentację [Markdown](http://daringfireball.net/projects/markdown/syntax).\n', '2010-05-14 12:00:00', 0, 0, 1, 'dokumentacja', 'opis notatki\n');

-- --------------------------------------------------------

--
-- Table structure for table `blog_notes_categories`
--

CREATE TABLE IF NOT EXISTS `blog_notes_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `blog_notes_categories`
--

INSERT INTO `blog_notes_categories` (`id`, `note_id`, `category_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_notes_tags`
--

CREATE TABLE IF NOT EXISTS `blog_notes_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `blog_notes_tags`
--

INSERT INTO `blog_notes_tags` (`id`, `note_id`, `tag_id`) VALUES
(4, 2, 1),
(3, 1, 3),
(2, 1, 2),
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_photos`
--

CREATE TABLE IF NOT EXISTS `blog_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `note_id` int(11) NOT NULL,
  `url` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blog_photos`
--

INSERT INTO `blog_photos` (`id`, `title`, `note_id`, `url`) VALUES
(1, 'test', 1, 'data/upload/2010-05-14/admin.jpg	');

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE IF NOT EXISTS `blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) CHARACTER SET latin2 NOT NULL,
  `name` varchar(32) CHARACTER SET latin2 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `blog_tags`
--

INSERT INTO `blog_tags` (`id`, `title`, `name`) VALUES
(3, 'test', 'test'),
(2, 'hello', 'hello'),
(1, 'tag1', 'tag1');

-- --------------------------------------------------------

--
-- Table structure for table `cms_categories`
--

CREATE TABLE IF NOT EXISTS `cms_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cms_categories`
--

INSERT INTO `cms_categories` (`id`, `name`, `title`, `order`) VALUES
(2, 'menu', 'Menu', 2),
(1, 'strona', 'Strona', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_files`
--

CREATE TABLE IF NOT EXISTS `cms_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `date` date NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `cms_files`
--

INSERT INTO `cms_files` (`id`, `name`, `date`, `type`) VALUES
(71, 'admin.jpg', '2010-05-14', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE IF NOT EXISTS `cms_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `text` text,
  `order` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `name` varchar(256) NOT NULL,
  `background` varchar(256) NOT NULL,
  `date` datetime NOT NULL,
  `url` tinyint(1) NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `category_id`, `title`, `text`, `order`, `visible`, `name`, `background`, `date`, `url`, `keywords`, `description`) VALUES
(1, 1, '', '## Cześć ##\nJeśli czytasz ten tekst to zapewne udało Ci się uruchomić skrypt, który udostępniłem. **Gratuluję!**\n\nZdaję sobie sprawę, że jego analiza nie musi należeć do najprzyjemniejszych. **Skrypt nie jest ani kompletny, ani idealny.** Są tu jednak elementy warte uwagi (skrypty JS, buforowanie, sitemap, kolorowanie składni kodu). \n\nJesze jedno. Zmieniłem oprawę graficzną witryny w porównaniu z oryginałem. Wybacz ale niektóre z grafik zostały zakupione. Sam szablon jest niemal identyczny. Przepraszam za bałagan jaki pojawił się w między czasie w stylach kaskadowych.\n\nMasz jakieś wątpliwości? [Napisz do mnie](http://baszczewski.pl/kontakt).\n\nPozdrawiam. Hej :)', 1, 1, 'welcome', 'data/upload/2009-06-01/body.jpg', '2010-04-20 10:51:01', 0, 'witam', ''),
(2, 2, 'Kontakt', '', 4, 1, 'kontakt', 'data/upload/2009-06-01/body.jpg', '2009-09-08 13:20:44', 1, 'formularz', ''),
(3, 2, 'Blog', '', 3, 1, 'blog', '', '2009-07-25 21:32:09', 1, '', ''),
(4, 2, 'Podstrona', '## Nagłówek ##\nTa podstrona wyświetla treść z bazy danych. Zwróć uwagę na kategorię strony (*category_id*) oraz parametr *url*.\n\nProjektując witrynę zależało mi na tym by niektóre strony miały własne kontrolery oraz widoki (np. kontakt). Dany skrypt to uwzględnia. Fajnie?  \n\n[Panel administracyjny](admin).  \nLogin: admin  \nHasło: admin  \n', 2, 1, 'podstrona', 'data/upload/2009-06-01/body.jpg', '2009-07-25 21:32:09', 0, 'dodatkowe, słowa, kluczowe', 'własny opis podstrony');
