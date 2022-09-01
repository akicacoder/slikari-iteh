/*
SQLyog Community
MySQL - 10.4.20-MariaDB : Database - slike
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `slike`;

/*Table structure for table `pravac` */

DROP TABLE IF EXISTS `pravac`;

CREATE TABLE `pravac` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pravac` */

insert  into `pravac`(`id`,`naziv`) values 
(1,'impresionizam'),
(2,'realizam');



/*Table structure for table `slikar` */

DROP TABLE IF EXISTS `slikar`;

CREATE TABLE `slikar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ime` varchar(200) DEFAULT NULL,
  `prezime` varchar(200) DEFAULT NULL,
  `godina_rodjenja` varchar(20) DEFAULT NULL,
  `godina_smrti` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `slikar` */

insert  into `slikar`(`id`,`ime`,`prezime`,`godina_rodjenja`,`godina_smrti`) values 
(2,'ime','prezime','1','2'),
(3,'afds','aesrdtasfddgf','1850','1940'),
(4,'ads','afd','2345','34');

/*Table structure for table `slika` */

DROP TABLE IF EXISTS `slika`;

CREATE TABLE `slika` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(200) DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `slikar` bigint(20) DEFAULT NULL,
  `pravac` bigint(20) DEFAULT NULL,
  `url` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slikar` (`slikar`),
  KEY `pravac` (`pravac`),
  CONSTRAINT `slika_ibfk_1` FOREIGN KEY (`slikar`) REFERENCES `slikar` (`id`),
  CONSTRAINT `slika_ibfk_2` FOREIGN KEY (`pravac`) REFERENCES `pravac` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `slika` */

insert  into `slika`(`id`,`naziv`,`opis`,`slikar`,`pravac`,`url`) values 
(1,'adfsd','adfsdg',3,2,'./img/270774619_2693029367672450_3974280042621720511_n.jpg'),
(3,'efsd','aefsdafs',4,2,'./img/pin_motor_yelow.png'),
(4,'efsd','aefsdafs',4,2,'./img/pin_motor_yelow.png'),
(5,'dafsd','asdfsafds',3,2,'./img/pin_bike_blue.png');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
