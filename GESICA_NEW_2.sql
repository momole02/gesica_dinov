-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.21 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour gesica
CREATE DATABASE IF NOT EXISTS `gesica` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gesica`;

-- Export de la structure de la table gesica. article
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_ent` char(20) NOT NULL,
  `code_article` char(20) NOT NULL,
  `nom_article` char(20) NOT NULL,
  `type_article` char(15) NOT NULL,
  `pv_article` int(10) NOT NULL,
  `qte_article` int(10) NOT NULL DEFAULT '0',
  `tva_article` int(11) NOT NULL DEFAULT '0',
  `remise_article` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`code_article`),
  UNIQUE KEY `id` (`id`),
  KEY `pk_code_ent_art` (`code_ent`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.article : ~19 rows (environ)
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` (`id`, `code_ent`, `code_article`, `nom_article`, `type_article`, `pv_article`, `qte_article`, `tva_article`, `remise_article`) VALUES
	(9, 'Test123456789', '', '', '', 0, 0, 0, 0),
	(54, 'Test123456789', '140218164031_Omo', 'Omo', 'Droguerie', 150, 96, 4, 6),
	(56, 'Test123456789', '140218164032_Dino', 'Dinor', 'Cuisine', 500, 142, 0, 0),
	(58, 'Test123456789', '140218201722_Oran', 'Oranges', 'Fruit', 300, 8, 0, 0),
	(3, 'Test123456789', '150218155404_Awa', 'Awa', 'Autre', 1000, 36, 0, 0),
	(4, 'Test123456789', '150218155404_Dino', 'Dinor', 'Cuisine', 500, 28, 0, 0),
	(2, 'Test123456789', '150218155404_Omo', 'Omo', 'Droguerie', 30, 5, 0, 0),
	(7, 'Test123456789', '150218155456_Awa', 'Awa', 'Autre', 1000, 22, 0, 0),
	(8, 'Test123456789', '150218155456_Dino', 'Dinor', 'Cuisine', 500, 40, 0, 0),
	(6, 'Test123456789', '150218155456_Omo', 'Omo', 'Droguerie', 30, 10, 0, 0),
	(61, 'Test123456789', '150218205206_Awa', 'Awa', 'Autre', 1000, 111, 0, 0),
	(62, 'Test123456789', '150218205206_Dino', 'Dinor', 'Cuisine', 500, 90, 0, 0),
	(60, 'Test123456789', '150218205206_Omo', 'Omo', 'Droguerie', 30, 90, 0, 0),
	(73, 'Test123456789', '190318180057_AAA', 'AAA', 'AAA', 500, 0, 0, 0),
	(63, 'Test123456789', '200218133455_Tass', 'Tasse', 'Ustensile', 300, 65, 0, 0),
	(70, 'Test123456789', '210218184507_Awa', 'Awa', 'Autre', 4, 100, 0, 0),
	(71, 'Test123456789', '210218184507_Dino', 'Dinor', 'Cuisine', 4, 76, 0, 0),
	(69, 'Test123456789', '210218184507_Omo', 'Omo', 'Droguerie', 4, 120, 0, 0),
	(72, 'Test123456789', '220218202850_Test', 'Test', 'Test', 1000, 100, 0, 0);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;

-- Export de la structure de la table gesica. caisse
CREATE TABLE IF NOT EXISTS `caisse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_caisse` char(20) NOT NULL,
  `num_caisse` char(10) NOT NULL,
  `code_ent` char(20) NOT NULL,
  `nom_caisse` char(20) NOT NULL,
  `pnom_caisse` char(30) NOT NULL,
  `pseudo_caisse` char(10) NOT NULL,
  `mdp_caisse` varchar(255) NOT NULL,
  PRIMARY KEY (`code_caisse`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_code_ent2` (`code_ent`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.caisse : 10 rows
/*!40000 ALTER TABLE `caisse` DISABLE KEYS */;
INSERT INTO `caisse` (`id`, `code_caisse`, `num_caisse`, `code_ent`, `nom_caisse`, `pnom_caisse`, `pseudo_caisse`, `mdp_caisse`) VALUES
	(1, '130218163528_KOUA', '1', '130218162338_SOAX', 'KOUASSI', 'Germain', 'germain', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4'),
	(2, '150218080710_SAMY', '01', '150218080554_SADI', 'SAMY', 'SAMY', 'SADII', '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454'),
	(3, '150218160121_ZOUN', '1', '130218163008_SOAX', 'ZOUNON', 'Yao', 'zouzou', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4'),
	(4, '150218173900_BORO', '2', '130218163008_SOAX', 'BOROGONE', 'GUY SAMUEL', 'samy', '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454'),
	(5, '070318170456_KOUA', '2', '130218162338_SOAX', 'KOUASSI', 'Germain', 'kgermain', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4'),
	(6, '070318184612_BORO', '3', '130218163008_SOAX', 'BOROGONE', 'GUY', 'guysamy', '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454'),
	(10, '110218214719_AYEN', '1', '110218201806_SOAX', 'AYENON', 'Marco', 'momole', 'c53546cdfa0b592132efc3b81631cae5e4c17f8bb8d2ba8f7612e3dac572d1f0d50922f6e91e3392be12407c7973ed51'),
	(13, '120218192303_GUEL', '1', '110218165332_SOAX', 'GUELADE', 'Kevin', 'encrypted', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4'),
	(19, '230218102700_KOUA', '1', '230218102139_Marc', 'KOUASSI', 'Germain', 'kgermain', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4'),
	(20, '150618085011_KOUA', '1', 'Test123456789', 'KOUASSI', 'ghislaine', 'kginny', 'eb455d56d2c1a69de64e832011f3393d45f3fa31d6842f21af92d2fe469c499da5e3179847334a18479c8d1dedea1be3'),
	(21, '100818122626_Test', '12', 'Test123456789', 'Test', 'Test', 'test', '17fb807934849ea439dd0f17a4ba00123b9e71f4a23154b17a6b4810aa9cc84a3d2bfdc9e89f108f1ebccb44eda7305f');
/*!40000 ALTER TABLE `caisse` ENABLE KEYS */;

-- Export de la structure de la table gesica. echeance
CREATE TABLE IF NOT EXISTS `echeance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_ent` char(20) NOT NULL,
  `debut_ech` date NOT NULL,
  `fin_ech` date NOT NULL,
  `prix_ech` int(10) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `fk_code_ent_ech` (`code_ent`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.echeance : 3 rows
/*!40000 ALTER TABLE `echeance` DISABLE KEYS */;
INSERT INTO `echeance` (`id`, `code_ent`, `debut_ech`, `fin_ech`, `prix_ech`) VALUES
	(1, '110218201806_SOAX', '2018-03-17', '2018-05-17', 20000),
	(2, '130218162338_SOAX', '2018-03-19', '2018-05-19', 20000),
	(3, 'Test123456789', '2018-03-27', '2026-07-27', 1000000);
/*!40000 ALTER TABLE `echeance` ENABLE KEYS */;

-- Export de la structure de la table gesica. entreprise
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_ent` char(20) NOT NULL,
  `nom_pro_ent` char(20) NOT NULL,
  `pnom_pro_ent` char(30) NOT NULL,
  `nom_ent` char(30) NOT NULL,
  `desc_ent` varchar(255) NOT NULL,
  `sexe_pro_ent` char(1) NOT NULL,
  `logo_ent` varchar(255) NOT NULL,
  `mdp_adm_ent` varchar(255) NOT NULL,
  `pseudo_adm_ent` char(10) NOT NULL,
  `tel_pro_ent` char(15) NOT NULL,
  `tel_ent` char(15) NOT NULL,
  `config_ent` text,
  `adresse` text,
  `message_bas` text,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL,
  PRIMARY KEY (`code_ent`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.entreprise : 21 rows
/*!40000 ALTER TABLE `entreprise` DISABLE KEYS */;
INSERT INTO `entreprise` (`id`, `code_ent`, `nom_pro_ent`, `pnom_pro_ent`, `nom_ent`, `desc_ent`, `sexe_pro_ent`, `logo_ent`, `mdp_adm_ent`, `pseudo_adm_ent`, `tel_pro_ent`, `tel_ent`, `config_ent`, `adresse`, `message_bas`, `heure_ouverture`, `heure_fermeture`) VALUES
	(1, '130218162338_SOAX', 'AYENON', 'Marc arnaud', 'SOA Industries', 'Entreprise', 'M', 'logo_dinov1.png', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', 'a:2:{s:11:"page_format";s:2:"a4";s:9:"mark_text";s:20:"Merci d\'être passé";}', NULL, NULL, NULL, NULL),
	(2, '130218162805_SOAX', 'AYENON', 'Marc arnaud', 'SOA Industries', 'Entreprise en ligne', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', NULL, NULL, NULL, NULL, NULL),
	(3, '130218162910_SOAX', 'AYENON', 'Marc arnaud', 'SOA Industries', 'Entreprise en ligne', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', NULL, NULL, NULL, NULL, NULL),
	(4, '130218163008_SOAX', 'AYENON', 'Marc arnaud', 'SOA Industries', 'Entreprise en ligne', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562426', NULL, NULL, NULL, NULL, NULL),
	(5, '130218163113_SADI', 'BOROGONE', 'Guy Samuel', 'SADII', 'Entreprise en ligne', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole', '54562425', '54562425', NULL, NULL, NULL, NULL, NULL),
	(6, '130218163147_SADI', 'BOROGONE', 'Guy Samuel', 'SADII', 'Entreprise en ligne', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole', '54562425', '54562425', NULL, NULL, NULL, NULL, NULL),
	(7, '140218153856_SADI', 'BROGONE', 'SAMUEL', 'SADII', 'VENTE DE MECHES', 'M', '', '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454', 'SAMY', '48174037', '48174037', NULL, NULL, NULL, NULL, NULL),
	(8, '150218080554_SADI', 'BROGONE', 'SAMUEL', 'SADII', 'VENTE DE MECHES', 'M', '', '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454', 'SAMY', '48174037', '48174037', NULL, NULL, NULL, NULL, NULL),
	(9, '150218171141_SADI', 'SAMY', 'SAMUEL', 'SADII', 'VENTE DE MECHES', 'M', '', '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454', 'SAMY', '48174037', '48174037', NULL, NULL, NULL, NULL, NULL),
	(38, '110218165332_SOAX', 'AYENON', 'Marc Arnaud', 'SOA Industries', 'Entreprise de vente de mèches', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(39, '110218201806_SOAX', 'AYENON', 'Marc arnaud', 'SOA Industries', '', 'M', 'Logo22.png', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', 'a:2:{s:11:"page_format";s:2:"a7";s:9:"mark_text";s:9:"Test Test";}', NULL, NULL, NULL, NULL),
	(44, '120318144948_SOAX', 'AYENON', 'Marc arnaud', 'SOA Industries', '', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(45, '120318145024_SADI', 'BOROGONE', 'Guy Samuel', 'SADII', '', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(46, '120318145040_SADI', 'BOROGONE', 'Guy Samuel', 'SADII', '', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(47, '120318145054_SADI', 'BOROGONE', 'Guy Samuel', 'SADII', '', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(48, '120318145106_SADI', 'BOROGONE', 'Guy Samuel', 'SADII', '', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(40, '130218160122_SADI', 'GOGO', 'Médard', 'SADII', '', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'momole02', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(41, '230218101854_Marc', 'AYENON', 'Marc arnaud', 'Marco Entreprises', '', 'M', '', '4131c511b564856d32a1a35c28890467b138a68110d507480f2da5796abcb3428201c9fc4abd0e6ca9525085916fe0e0', 'zazou', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(42, '230218102110_Marc', 'AYENON', 'Marc arnaud', 'Marco Entreprises', '', 'M', '', '4131c511b564856d32a1a35c28890467b138a68110d507480f2da5796abcb3428201c9fc4abd0e6ca9525085916fe0e0', 'zazou', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(43, '230218102139_Marc', 'AYENON', 'Marc arnaud', 'Marco Entreprises', '', 'M', '', 'cfeeea4d9e077be491320c5727b42620dc8922df0417938d5f2813c0e89b5a1a5c75a8935c7bc059918bb08354349cb4', 'zazou', '54562425', '54562425', '', NULL, NULL, NULL, NULL),
	(49, 'Test123456789', 'AYENON', 'Marc Arnaud', 'Marco Entreprises', '', 'M', '', '17fb807934849ea439dd0f17a4ba00123b9e71f4a23154b17a6b4810aa9cc84a3d2bfdc9e89f108f1ebccb44eda7305f', 'admin', '54562425', '54562425', NULL, 'Cocody Angré', NULL, '08:00:00', '20:00:00');
/*!40000 ALTER TABLE `entreprise` ENABLE KEYS */;

-- Export de la structure de la table gesica. operationentr
CREATE TABLE IF NOT EXISTS `operationentr` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_op` char(20) NOT NULL,
  `desc_op` text,
  `code_caisse` char(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_op` datetime NOT NULL,
  PRIMARY KEY (`code_op`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.operationentr : 5 rows
/*!40000 ALTER TABLE `operationentr` DISABLE KEYS */;
INSERT INTO `operationentr` (`id`, `code_op`, `desc_op`, `code_caisse`, `date_op`) VALUES
	(1, '150318154542_Nouv', 'Nouvelle vente réalisée par le gestionnaire : AYENON', '110218214719_AYEN', '2018-03-15 15:45:00'),
	(2, '150318164659_Nouv', 'Nouvelle vente réalisée par le gestionnaire : AYENON', '110218214719_AYEN', '2018-03-15 16:46:00'),
	(3, '150318165603_Nouv', 'Nouvelle vente réalisée par le gestionnaire : ', '070318170456_KOUA', '2018-03-15 16:56:00'),
	(4, '190318180057_Inse', 'Insertion d\'un nouvel article nom=AAAPar le gestionnaire KOUASSI', '070318170456_KOUA', '2018-03-19 18:00:57'),
	(5, '190318180213_Nouv', 'Nouvelle vente réalisée par le gestionnaire : KOUASSI', '070318170456_KOUA', '2018-03-19 18:02:13'),
	(6, '100818122921_Nouv', 'Nouvelle vente réalisée par le gestionnaire : Test', '100818122626_Test', '2018-08-10 12:29:21');
/*!40000 ALTER TABLE `operationentr` ENABLE KEYS */;

-- Export de la structure de la table gesica. operation_caisse
CREATE TABLE IF NOT EXISTS `operation_caisse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_op` char(20) NOT NULL,
  `code_caisse` char(20) NOT NULL,
  `date_op` datetime NOT NULL,
  `type_op` char(15) NOT NULL,
  PRIMARY KEY (`code_op`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_code_caisse2` (`code_caisse`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.operation_caisse : 30 rows
/*!40000 ALTER TABLE `operation_caisse` DISABLE KEYS */;
INSERT INTO `operation_caisse` (`id`, `code_op`, `code_caisse`, `date_op`, `type_op`) VALUES
	(1, '070318170857_FERM', '070318170456_KOUA', '2018-03-07 17:08:57', 'FERMETURE'),
	(2, '070318184624_OUVE', '070318184612_BORO', '2018-03-07 18:46:24', 'OUVERTURE'),
	(3, '080318141201_OUVE', '070318184612_BORO', '2018-03-08 14:12:01', 'OUVERTURE'),
	(4, '080318142925_FERM', '070318184612_BORO', '2018-03-08 14:29:25', 'FERMETURE'),
	(5, '120318153538_OUVE', '070318170456_KOUA', '2018-03-12 15:35:38', 'OUVERTURE'),
	(6, '120318153613_FERM', '070318170456_KOUA', '2018-03-12 15:36:13', 'FERMETURE'),
	(7, '120318155411_OUVE', '070318170456_KOUA', '2018-03-12 15:54:11', 'OUVERTURE'),
	(8, '120318155511_FERM', '070318170456_KOUA', '2018-03-12 15:55:11', 'FERMETURE'),
	(9, '150318153033_OUVE', '070318170456_KOUA', '2018-03-15 15:30:33', 'OUVERTURE'),
	(10, '150318153050_FERM', '070318170456_KOUA', '2018-03-15 15:30:50', 'FERMETURE'),
	(11, '150318153433_OUVE', '070318170456_KOUA', '2018-03-15 15:34:33', 'OUVERTURE'),
	(12, '150318153441_FERM', '070318170456_KOUA', '2018-03-15 15:34:41', 'FERMETURE'),
	(13, '150318153645_OUVE', '070318170456_KOUA', '2018-03-15 15:36:45', 'OUVERTURE'),
	(14, '150318153822_FERM', '070318170456_KOUA', '2018-03-15 15:38:22', 'FERMETURE'),
	(15, '150318153837_OUVE', '070318170456_KOUA', '2018-03-15 15:38:37', 'OUVERTURE'),
	(16, '150318154224_OUVE', '110218214719_AYEN', '2018-03-15 15:42:24', 'OUVERTURE'),
	(17, '150318154615_FERM', '110218214719_AYEN', '2018-03-15 15:46:15', 'FERMETURE'),
	(18, '150318155615_OUVE', '110218214719_AYEN', '2018-03-15 15:56:15', 'OUVERTURE'),
	(19, '150318160222_FERM', '110218214719_AYEN', '2018-03-15 16:02:22', 'FERMETURE'),
	(20, '150318164431_OUVE', '070318170456_KOUA', '2018-03-15 16:44:31', 'OUVERTURE'),
	(21, '150318164603_OUVE', '110218214719_AYEN', '2018-03-15 16:46:03', 'OUVERTURE'),
	(22, '150318164704_FERM', '110218214719_AYEN', '2018-03-15 16:47:04', 'FERMETURE'),
	(23, '150318171231_FERM', '070318170456_KOUA', '2018-03-15 17:12:31', 'FERMETURE'),
	(24, '150318171843_OUVE', '070318170456_KOUA', '2018-03-15 17:18:43', 'OUVERTURE'),
	(25, '190318160201_OUVE', '070318170456_KOUA', '2018-03-19 16:02:01', 'OUVERTURE'),
	(26, '190318160206_FERM', '070318170456_KOUA', '2018-03-19 16:02:06', 'FERMETURE'),
	(27, '190318160457_OUVE', '070318170456_KOUA', '2018-03-19 16:04:57', 'OUVERTURE'),
	(28, '190318175648_FERM', '070318170456_KOUA', '2018-03-19 17:56:48', 'FERMETURE'),
	(29, '190318175857_OUVE', '070318170456_KOUA', '2018-03-19 17:58:57', 'OUVERTURE'),
	(30, '190318180514_FERM', '070318170456_KOUA', '2018-03-19 18:05:14', 'FERMETURE'),
	(31, '100818122637_OUVE', '100818122626_Test', '2018-08-10 12:26:37', 'OUVERTURE'),
	(32, '100818122807_FERM', '100818122626_Test', '2018-08-10 12:28:07', 'FERMETURE'),
	(33, '100818122828_OUVE', '100818122626_Test', '2018-08-10 12:28:28', 'OUVERTURE'),
	(34, '100818123013_FERM', '100818122626_Test', '2018-08-10 12:30:13', 'FERMETURE');
/*!40000 ALTER TABLE `operation_caisse` ENABLE KEYS */;

-- Export de la structure de la table gesica. rel_appro
CREATE TABLE IF NOT EXISTS `rel_appro` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_caisse` char(20) NOT NULL,
  `code_article` char(20) NOT NULL,
  `comment` text NOT NULL,
  `date_hr` datetime NOT NULL,
  `qte_ajout` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_code_caisse_appro` (`code_caisse`),
  KEY `fk_code_article_appro` (`code_article`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.rel_appro : 0 rows
/*!40000 ALTER TABLE `rel_appro` DISABLE KEYS */;
/*!40000 ALTER TABLE `rel_appro` ENABLE KEYS */;

-- Export de la structure de la table gesica. rel_paye
CREATE TABLE IF NOT EXISTS `rel_paye` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_ent` char(20) NOT NULL,
  `code_ech` char(20) NOT NULL,
  `date_hr_paiement` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_code_ent_pay` (`code_ent`),
  KEY `fk_code_ech_pay` (`code_ech`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.rel_paye : 0 rows
/*!40000 ALTER TABLE `rel_paye` DISABLE KEYS */;
/*!40000 ALTER TABLE `rel_paye` ENABLE KEYS */;

-- Export de la structure de la table gesica. rel_vendre
CREATE TABLE IF NOT EXISTS `rel_vendre` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_caisse` char(20) NOT NULL,
  `date_hr_vente` datetime NOT NULL,
  `lien_fac_vente` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_code_caisse_ven` (`code_caisse`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Export de données de la table gesica.rel_vendre : 9 rows
/*!40000 ALTER TABLE `rel_vendre` DISABLE KEYS */;
INSERT INTO `rel_vendre` (`id`, `code_caisse`, `date_hr_vente`, `lien_fac_vente`) VALUES
	(1, '070318184612_BORO', '2018-03-07 18:56:00', 'http://gesicaci.epizy.com/uploads/bills/070318185616_BILL.pdf'),
	(2, '070318184612_BORO', '2018-03-07 18:56:00', 'http://gesicaci.epizy.com/uploads/bills/070318185626_BILL.pdf'),
	(3, '070318184612_BORO', '2018-03-08 14:15:00', 'http://gesicaci.epizy.com/uploads/bills/080318141521_BILL.pdf'),
	(4, '070318184612_BORO', '2018-03-08 14:16:00', 'http://gesicaci.epizy.com/uploads/bills/080318141622_BILL.pdf'),
	(5, '110218214719_AYEN', '2018-03-15 15:45:00', 'http://gesicaci.epizy.com/uploads/bills/150318154542_BILL.pdf'),
	(6, '110218214719_AYEN', '2018-03-15 16:46:00', 'http://gesicaci.epizy.com/uploads/bills/150318164659_BILL.pdf'),
	(7, '070318170456_KOUA', '2018-03-15 16:56:00', 'http://gesicaci.epizy.com/uploads/bills/150318165603_BILL.pdf'),
	(8, '070318170456_KOUA', '2018-03-19 18:02:00', 'http://gesicaci.epizy.com/uploads/bills/190318180213_BILL.pdf'),
	(9, '070318184612_BORO', '2018-03-07 18:56:00', 'http://gesicaci.epizy.com/uploads/bills/070318185616_BILL.pdf'),
	(10, '100818122626_Test', '2018-08-10 12:29:00', 'http://[::1]/gesica_repo/uploads/bills/100818122921_BILL.pdf');
/*!40000 ALTER TABLE `rel_vendre` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
