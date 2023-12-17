-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.30 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных re-books
CREATE DATABASE IF NOT EXISTS `re-books` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `re-books`;

-- Дамп структуры для таблица re-books.books
CREATE TABLE IF NOT EXISTS `books` (
  `bookID` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `clicks` bigint DEFAULT NULL,
  PRIMARY KEY (`bookID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы re-books.books: ~2 rows (приблизительно)
INSERT INTO `books` (`bookID`, `title`, `author`, `description`, `image`, `category`, `date`, `clicks`) VALUES
	(29, 'FOOL MAN', 'Robert Rodriques', 'nav', 'uploads/1674072153cover1__w220.jpg', 'Fantastika', '2023-01-04', 16),
	(30, 'f', 'f', 'f', 'uploads/16740731001003w-4he1eqkeAQg.webp', 'Fantāzija', '2023-01-04', 1),
	(31, 'asdas', 'dasdasd', 'asdasd', 'uploads/1674306985Обложка_книги_Александра_Ворошилова_Первая_победа.jpg', 'Mīlas romāni', '2023-01-07', 5);

-- Дамп структуры для таблица re-books.category
CREATE TABLE IF NOT EXISTS `category` (
  `categoryID` int NOT NULL AUTO_INCREMENT,
  `CategName` varchar(100) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы re-books.category: 10 rows
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`categoryID`, `CategName`) VALUES
	(1, 'Fantāzija'),
	(2, 'Fantastika'),
	(3, 'Detektīvi'),
	(4, 'Mīlas romāni'),
	(5, 'Biznesa literatūra'),
	(6, 'Datorliteratūra'),
	(7, 'Psiholoģija'),
	(8, 'Vēsture'),
	(9, 'Skolas mācību grāmatas'),
	(10, 'Ārpusskolas lasīšana');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Дамп структуры для таблица re-books.favourites
CREATE TABLE IF NOT EXISTS `favourites` (
  `favouritesID` int NOT NULL AUTO_INCREMENT,
  `FK_booksID` int DEFAULT NULL,
  `FK_userID` int DEFAULT NULL,
  PRIMARY KEY (`favouritesID`) USING BTREE,
  KEY `favourites_ibfk_1` (`FK_userID`) USING BTREE,
  KEY `books_ID` (`FK_booksID`) USING BTREE,
  CONSTRAINT `FK_favourites_books` FOREIGN KEY (`FK_booksID`) REFERENCES `books` (`bookID`),
  CONSTRAINT `FK_favourites_users` FOREIGN KEY (`FK_userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы re-books.favourites: ~3 rows (приблизительно)
INSERT INTO `favourites` (`favouritesID`, `FK_booksID`, `FK_userID`) VALUES
	(42, 29, 13),
	(45, 29, 14),
	(46, 30, 14);

-- Дамп структуры для таблица re-books.ratingsystem
CREATE TABLE IF NOT EXISTS `ratingsystem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rateIndex` tinyint DEFAULT NULL,
  `FK_userID` int DEFAULT NULL,
  `FK_bookID` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ratingsystem_users` (`FK_userID`),
  KEY `FK_ratingsystem_books` (`FK_bookID`),
  CONSTRAINT `FK_ratingsystem_books` FOREIGN KEY (`FK_bookID`) REFERENCES `books` (`bookID`),
  CONSTRAINT `FK_ratingsystem_users` FOREIGN KEY (`FK_userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы re-books.ratingsystem: ~3 rows (приблизительно)
INSERT INTO `ratingsystem` (`id`, `rateIndex`, `FK_userID`, `FK_bookID`) VALUES
	(176, 1, 13, 29),
	(177, 5, 14, 30),
	(178, 2, 13, 30),
	(179, 2, 14, 29);

-- Дамп структуры для таблица re-books.users
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы re-books.users: ~4 rows (приблизительно)
INSERT INTO `users` (`userID`, `email`, `username`, `password`, `admin`) VALUES
	(13, 'ilarimsa937@gmail.com', 'fowik', '202cb962ac59075b964b07152d234b70', 1),
	(14, 'cheaterrrrr123@gmail.com', 'zerlog', '202cb962ac59075b964b07152d234b70', 0),
	(26, 'test@test.com', 'test', '202cb962ac59075b964b07152d234b70', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
