-- MySQL dump 10.13  Distrib 8.0.24, for Win64 (x86_64)
--
-- Host: localhost    Database: reserveit
-- ------------------------------------------------------
-- Server version	8.0.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bilet_rodzaj`
--

DROP TABLE IF EXISTS `bilet_rodzaj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bilet_rodzaj` (
  `id_bilet_rodzaj` int NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(100) NOT NULL,
  PRIMARY KEY (`id_bilet_rodzaj`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bilet_rodzaj`
--

LOCK TABLES `bilet_rodzaj` WRITE;
/*!40000 ALTER TABLE `bilet_rodzaj` DISABLE KEYS */;
INSERT INTO `bilet_rodzaj` VALUES (1,'normalny'),(2,'ulgowy');
/*!40000 ALTER TABLE `bilet_rodzaj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dislikes_reviews`
--

DROP TABLE IF EXISTS `dislikes_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dislikes_reviews` (
  `id_review` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_review`,`id_user`),
  KEY `fk_user_id_idx` (`id_user`),
  CONSTRAINT `fk_review_id` FOREIGN KEY (`id_review`) REFERENCES `review` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `uzytkownicy` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dislikes_reviews`
--

LOCK TABLES `dislikes_reviews` WRITE;
/*!40000 ALTER TABLE `dislikes_reviews` DISABLE KEYS */;
INSERT INTO `dislikes_reviews` VALUES (18,20);
/*!40000 ALTER TABLE `dislikes_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filmy`
--

DROP TABLE IF EXISTS `filmy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filmy` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `tytul` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `opis` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `data_seansu` datetime NOT NULL,
  `gatunek_filmu` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rezyser` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `produkcja` varchar(250) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `obrazek` varchar(250) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `sala` int NOT NULL,
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_film`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filmy`
--

LOCK TABLES `filmy` WRITE;
/*!40000 ALTER TABLE `filmy` DISABLE KEYS */;
INSERT INTO `filmy` VALUES (1,'ROME','Gajusz Juliusz Cezar po ośmioletniej wojnie, podczas której dokonał mistrzowskiego podboju Galii, przygotowuje się do powrotu. Kieruje się w stronę Rzymu wraz z tysiącami lojalnych i zaprawionych w boju żołnierzy, dużym łupem w postaci złota i niewolników, oraz radykalnymi planami zmian.','2022-03-30 15:00:00','dramat','Jan Kowalski','2021 PL','./images/filmy/film1dramat.jpg',12,'aktywny'),(2,'The Bulldog II','Oparty luźno na autentycznych wydarzeniach film przedstawia historię o chłopcu i jego wiernym psie rasy bulldog, który dzięki swoim walecznym sercu i odwadze nie raz uchroni przed tarapatami swojego przyjaciela.','2022-08-15 14:30:00','animowane','Tadeusz Baryka','2021 PL','./images/filmy/film2animowane.jpg',3,'aktywny'),(3,'Your Squad','Perypetie dorosłego mężczyzny i jego przyjaciół, którzy zachowują się beztrosko pomimo upływających lat. Przez swoje zachowanie wpadają w tarapaty.','2022-08-10 00:00:00','komedie','Mateusz Mazur','2021 USA','./images/filmy/film3komedie.jpg',0,'aktywny'),(4,'Mr Darkness','Członkowie ekipy badawczej trafiają  na grobowiec, który stopniowo odkrywa przed nimi coraz to bardziej mroczne tajemnice. ','2022-09-15 00:00:00','scifi','Paulina Gąstoł','2022 PL','./images/filmy/film4scifi.jpg',0,'aktywny'),(5,'Memorial Day','Dokument ukazuje odzyskanie niepodległości w oparciu o archiwalne, kolorowe, a przede wszystkim autentyczne zdjęcia z tamtego okresu.','2022-07-14 00:00:00','edukacyjne','Sebastian Lolek','2021 USA','./images/filmy/film5edukacyjne.jpg',0,'aktywny'),(6,'GASMASK','Grupa młodych ludzi, szukających ekstremalnych wrażeń, wynajmuje przewodnika. Ten, mimo surowych zakazów, zabiera ich do owianego tajemnicą miasta-widmo.','2022-07-01 00:00:00','dramat','Jan Nowak','2021 USA','./images/filmy/film6dramat.jpg',0,'aktywny'),(7,'Indie Week on Rodeo','Łowca nagród i jego przyjaciel wyruszają w podróż, aby odbić żonę jednego z boahaterów z rąk bezlitosnego Karla Pompo.','2022-08-26 00:00:00','akcja','Jerzy Jeż','2021 PL','./images/filmy/film7akcja.jpg',0,'aktywny'),(8,'The Black Summer','W trakcie ostatnich wakacji przed rozpoczęciem zajęć na uczelni stojąca u progu dorosłości grupa przyjaciół próbuje szczęścia w dotychczasowych i całkiem nowych związkach.','2022-11-05 00:00:00','akcja','Jan Kowalski','2022 USA','./images/filmy/film8akcja.jpg',0,'aktywny'),(9,'Galaktyka 2','Grupa zaprzyjaźnionych studentów wyrusza w daleką podróż aby odnaleźć zaginionego wykładowce.','2022-09-08 00:00:00','scifi','Jakub Ładyga','2021 PL','./images/filmy/film9scifi.jpg',0,'aktywny'),(10,'Test','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris dapibus metus in elementum consequat. Etiam suscipit quam fringilla, maximus neque vel, semper elit. Sed porta ullamcorper libero in eleifend. Fusce sit amet sodales magna. Fusce semper eros ac ipsum ultricies, ut faucibus lorem ornare. Ut non aliquam purus. Sed sagittis leo leo, non sagittis mi luctus id. Pellentesque facilisis, neque vel tincidunt lobortis, metus erat sollicitudin elit, fermentum aliquam nunc erat vel arcu. Phasellus blandit felis enim, vel egestas est elementum eu. Nam orci nunc, commodo sed nibh sed, venenatis sodales leo. Vivamus interdum, mauris eget dictum mollis, velit lectus suscipit eros, non rutrum libero justo sit amet dui.','2022-04-09 13:00:00','Test Test','Test','2021 PL','images/filmy/image.jpg',15,'aktywny'),(11,'Nowa kziążka','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris dapibus metus in elementum consequat. Etiam suscipit quam fringilla, maximus neque vel, semper elit. Sed porta ullamcorper libero in eleifend. Fusce sit amet sodales magna. Fusce semper eros ac ipsum ultricies, ut faucibus lorem ornare. Ut non aliquam purus. Sed sagittis leo leo, non sagittis mi luctus id. Pellentesque facilisis, neque vel tincidunt lobortis, metus erat sollicitudin elit, fermentum aliquam nunc erat vel arcu. Phasellus blandit felis enim, vel egestas est elementum eu. Nam orci nunc, commodo sed nibh sed, venenatis sodales leo. Vivamus interdum, mauris eget dictum mollis, velit lectus suscipit eros, non rutrum libero justo sit amet dui.','2022-04-09 21:41:00','Test Test','Test','2021 PL','./images/filmy/moonlight-ver2-xlg.jpg',15,'aktywny'),(12,'qwdqwd','s;lwkfj piwoqejf iowqjefi jweio jgwoejgopwje gopwje [goeg','2022-04-16 15:00:00','qwdqwdqwd','qwdqwd','qwdqwdqwd','./images/filmy/image.jpg',12,'aktywny');
/*!40000 ALTER TABLE `filmy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followed_films`
--

DROP TABLE IF EXISTS `followed_films`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `followed_films` (
  `film_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`film_id`,`user_id`),
  KEY `user_id_key_idx` (`user_id`),
  CONSTRAINT `film_id_key` FOREIGN KEY (`film_id`) REFERENCES `filmy` (`id_film`),
  CONSTRAINT `user_id_key` FOREIGN KEY (`user_id`) REFERENCES `uzytkownicy` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followed_films`
--

LOCK TABLES `followed_films` WRITE;
/*!40000 ALTER TABLE `followed_films` DISABLE KEYS */;
INSERT INTO `followed_films` VALUES (1,20),(2,20),(1,21);
/*!40000 ALTER TABLE `followed_films` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes_reviews`
--

DROP TABLE IF EXISTS `likes_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes_reviews` (
  `id_review` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_review`,`id_user`),
  KEY `user_like_id_key_idx` (`id_user`),
  CONSTRAINT `review_id_key` FOREIGN KEY (`id_review`) REFERENCES `review` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_like_id_key` FOREIGN KEY (`id_user`) REFERENCES `uzytkownicy` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes_reviews`
--

LOCK TABLES `likes_reviews` WRITE;
/*!40000 ALTER TABLE `likes_reviews` DISABLE KEYS */;
INSERT INTO `likes_reviews` VALUES (21,20),(18,21);
/*!40000 ALTER TABLE `likes_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `miejsce_film`
--

DROP TABLE IF EXISTS `miejsce_film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `miejsce_film` (
  `id_miejsce_film` int NOT NULL AUTO_INCREMENT,
  `id_rezerwacja_film` int NOT NULL,
  `numer` int NOT NULL,
  `rzad` int NOT NULL,
  PRIMARY KEY (`id_miejsce_film`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `miejsce_film`
--

LOCK TABLES `miejsce_film` WRITE;
/*!40000 ALTER TABLE `miejsce_film` DISABLE KEYS */;
INSERT INTO `miejsce_film` VALUES (27,10,1,1),(30,12,1,1),(31,13,2,1),(34,15,2,3),(35,15,1,3),(36,15,4,3),(37,15,5,3),(38,15,6,3),(39,15,8,3),(40,15,1,5),(41,16,5,5),(42,16,6,5),(43,17,3,8),(44,18,3,6),(45,19,1,1),(46,19,2,1),(47,19,3,1),(48,19,4,1),(49,19,5,1),(50,19,6,1),(51,19,7,1),(52,19,8,1),(53,19,9,1),(54,19,10,1),(55,19,10,2),(56,19,9,2),(57,19,8,2),(58,19,7,2),(59,19,6,2),(60,20,4,3),(61,20,5,3),(62,21,4,1),(63,22,5,1),(64,23,10,1),(65,24,6,3),(66,25,9,6),(67,21,10,1),(68,26,5,5);
/*!40000 ALTER TABLE `miejsce_film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` longtext NOT NULL,
  `rating` int NOT NULL,
  `date` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `film_id` int DEFAULT NULL,
  `visibility` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_review_idx` (`user_id`),
  KEY `film_id_review_idx` (`film_id`),
  CONSTRAINT `film_id_review` FOREIGN KEY (`film_id`) REFERENCES `filmy` (`id_film`),
  CONSTRAINT `user_id_review` FOREIGN KEY (`user_id`) REFERENCES `uzytkownicy` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (8,'Super film! ',5,'2022-03-25 10:09:00',17,9,1),(13,'kwsdnn f;iwei gjwioej giwej giowje gopwjeopg kwke[p g[e g',3,'2022-03-26 12:55:00',19,10,1),(14,'w egw eg we he hwe hwehw  rj',5,'2022-03-26 12:55:00',19,10,1),(18,'ewf wegf we gwe gwe gwe g',5,'2022-03-28 07:53:00',17,1,1),(20,'qwd qwf qw fqw fqw fqwf qwf',5,'2022-03-28 08:05:00',20,2,0),(21,'qweqweqweqwe',5,'2022-03-28 09:07:00',21,1,1);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rezerwacja_film`
--

DROP TABLE IF EXISTS `rezerwacja_film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rezerwacja_film` (
  `id_rezerwacja_film` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_film` int NOT NULL,
  `normalne` int NOT NULL,
  `ulgowe` int NOT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`id_rezerwacja_film`),
  KEY `status_reservation_id_idx` (`status`),
  CONSTRAINT `status_reservation_id` FOREIGN KEY (`status`) REFERENCES `status_rodzaj` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rezerwacja_film`
--

LOCK TABLES `rezerwacja_film` WRITE;
/*!40000 ALTER TABLE `rezerwacja_film` DISABLE KEYS */;
INSERT INTO `rezerwacja_film` VALUES (10,13,1,1,0,3),(12,14,2,1,0,2),(13,14,1,1,0,3),(15,17,3,2,4,2),(16,18,5,1,1,2),(17,18,4,1,0,3),(18,18,6,0,1,3),(19,17,4,5,10,2),(20,18,2,2,0,2),(21,19,5,1,1,3),(22,19,10,1,0,2),(23,18,3,1,0,2),(24,18,9,1,0,2),(25,19,2,1,0,2),(26,19,4,1,0,2);
/*!40000 ALTER TABLE `rezerwacja_film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_rodzaj`
--

DROP TABLE IF EXISTS `status_rodzaj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_rodzaj` (
  `status_id` int NOT NULL AUTO_INCREMENT,
  `status_nazwa` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_rodzaj`
--

LOCK TABLES `status_rodzaj` WRITE;
/*!40000 ALTER TABLE `status_rodzaj` DISABLE KEYS */;
INSERT INTO `status_rodzaj` VALUES (1,'do opłacenia'),(2,'opłacona'),(3,'porzucona');
/*!40000 ALTER TABLE `status_rodzaj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uzytkownicy`
--

DROP TABLE IF EXISTS `uzytkownicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uzytkownicy` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `imie` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(65) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(65) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rola` varchar(45) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uzytkownicy`
--

LOCK TABLES `uzytkownicy` WRITE;
/*!40000 ALTER TABLE `uzytkownicy` DISABLE KEYS */;
INSERT INTO `uzytkownicy` VALUES (4,'Dominika','GÄ…stoÅ‚','dominika@gmail.com','$2y$10$Ds8SV9fYy7nz44iZYAzOQe/cKnQwxCJMKbWTWsWE59MGkACPWCeuK','user'),(13,'Joanna','Nowak','nowak@gmail.com','$2y$10$oeRTLKQVvbdTdCrNtZJHe.ysqiu0XaAsXH13aDBuJYqQtSxCIk9MS','user'),(14,'Muflon','Mazur','muflon@gmail.com','$2y$10$x2XwoGr1c0m6kWhN0trT1uLxL2NS.8tLJQ3cvU7znYWNVBSJc3rKi','user'),(15,'Dymitr','Kozak','d.dragalow@gmail.com','$2y$10$N84Aj0nuF7dNUN0rkbcQf.kmfw7uheYMX/PAb9qgSKBzYHl6nfPn2','user'),(17,'Admin','Admin','admin@admin.pl','$2y$10$OhgQhNCQ8hKnLLrC9MOcTOVgHnVIE1x05DuZD7FLKNDYo./6OM2B6','admin'),(18,'Kasjer','Kasjer','kasjer@reserveit.pl','$2y$10$qqMdaY2BFySNEn1Dw8Sf6.A2f4.LKRe/C4SUf/5/hSgaqQVRbEukq','cashier'),(19,'Dymitr','Kozak','email@gmail.com','$2y$10$jNnGh8p6GqVCynozrIwu7u1JwmCCxaizOm4Vy5F99RiS0Qzw58/Aq','user'),(20,'user1','user1','user1@gmail.com','$2y$10$xY3Ljb1BYcVS4kZQRiepoOA2B3X5tTCgya0Z0JK3hNUBCwH8O6yZG','user'),(21,'user2','user2','user2@gmail.com','$2y$10$sNs31GoJ3wrLZ3gzyX8Cv..GSkVjP1rBHneYVjo40jTercZYuGZvG','user');
/*!40000 ALTER TABLE `uzytkownicy` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-28 19:45:55
