<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 16/10/2018
 * Time: 00:09
 */

/**
 * SCRIPT DE CRIAÇÃO DE TABELAS E INSERÇÃO DE DADOS INICIAIS MYSQL
 */
?>

<!-- MySQL Workbench Forward Engineering

-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: erp
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agenda_manutencao`
--

DROP TABLE IF EXISTS `agenda_manutencao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda_manutencao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `data_hora_inicio` datetime NOT NULL,
  `data_hora_fim` datetime NOT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL COMMENT 'Data hora de exclusão.',
  `observacao` varchar(100) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_agenda_manutencao_usuario_idx` (`id_usuario`),
  KEY `fk_agenda_manutencao_agenda_manutencao_status_idx` (`id_status`),
  CONSTRAINT `fk_agenda_manutencao_agenda_manutencao_status` FOREIGN KEY (`id_status`) REFERENCES `agenda_manutencao_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_manutencao_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_manutencao`
--

LOCK TABLES `agenda_manutencao` WRITE;
/*!40000 ALTER TABLE `agenda_manutencao` DISABLE KEYS */;
INSERT INTO `agenda_manutencao` VALUES (2,2,'2018-11-08 00:07:15','2018-11-10 03:07:15','2018-11-08 00:07:15',NULL,'teste',1),(3,2,'2018-11-22 00:07:15','2018-11-23 00:07:15','2018-11-08 01:46:18','2018-11-08 07:38:58','Agendamento Testes',2),(4,2,'2018-11-05 00:07:15','2018-11-07 00:07:15','2018-11-08 01:55:57','2018-11-08 05:15:39','sadf',2),(5,2,'2018-11-06 00:07:15','2018-11-09 00:07:15','2018-11-08 01:56:30','2018-11-08 05:14:28','safsdsf',1),(6,2,'2018-11-09 00:07:15','2018-11-10 00:07:15','2018-11-08 02:03:33','2018-11-08 05:14:22','asdf',3),(7,2,'2018-10-26 05:02:16','2018-11-21 05:02:19','2018-11-08 05:02:24','2018-11-08 05:15:39','aaadssssss',1),(8,2,'2018-11-13 16:00:00','2018-11-14 00:00:00','2018-11-13 20:52:53','2018-11-13 20:55:07','Teste ',1),(9,2,'1970-01-01 01:00:00','1970-01-01 01:00:00','2018-11-25 14:08:34','2018-11-25 14:38:54','Teste',2),(10,2,'2018-10-30 00:00:00','2018-10-31 00:00:00','2018-11-25 14:36:57',NULL,'',1),(11,2,'2018-10-31 00:00:00','2018-11-01 00:00:00','2018-11-27 21:26:03',NULL,'Troca de òleo.',3),(12,2,'2018-10-30 00:00:00','2018-10-31 00:00:00','2018-12-03 20:27:10',NULL,'asfdfadf',2),(13,2,'2018-10-30 00:00:00','2018-10-31 00:00:00','2018-12-03 20:29:11',NULL,'',2),(14,2,'2018-11-25 00:00:00','2018-11-26 00:00:00','2018-12-06 17:17:46',NULL,'asdf',1);
/*!40000 ALTER TABLE `agenda_manutencao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda_manutencao_cliente_veiculo`
--

DROP TABLE IF EXISTS `agenda_manutencao_cliente_veiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda_manutencao_cliente_veiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agenda_manutencao` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_veiculo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_agenda_agenda_manutencao_idx` (`id_agenda_manutencao`),
  KEY `fk_agenda_cliente_idx` (`id_cliente`),
  KEY `fk_agenda_veiculo_idx` (`id_veiculo`),
  CONSTRAINT `fk_agenda_agenda_manutencao` FOREIGN KEY (`id_agenda_manutencao`) REFERENCES `agenda_manutencao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_veiculo` FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_manutencao_cliente_veiculo`
--

LOCK TABLES `agenda_manutencao_cliente_veiculo` WRITE;
/*!40000 ALTER TABLE `agenda_manutencao_cliente_veiculo` DISABLE KEYS */;
INSERT INTO `agenda_manutencao_cliente_veiculo` VALUES (1,3,30,42),(2,4,30,42),(3,5,24,38),(4,6,15,18),(5,7,30,42),(6,8,30,42),(7,9,9,10),(8,10,15,18),(9,11,35,44),(10,12,9,10),(11,13,15,18),(12,14,36,49);
/*!40000 ALTER TABLE `agenda_manutencao_cliente_veiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda_manutencao_status`
--

DROP TABLE IF EXISTS `agenda_manutencao_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda_manutencao_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_manutencao_status`
--

LOCK TABLES `agenda_manutencao_status` WRITE;
/*!40000 ALTER TABLE `agenda_manutencao_status` DISABLE KEYS */;
INSERT INTO `agenda_manutencao_status` VALUES (1,'Confirmado'),(2,'Aguardando Confirmação'),(3,'Cancelado');
/*!40000 ALTER TABLE `agenda_manutencao_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `rotulo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Produtos'),(2,'Tributos'),(3,'Fretes'),(4,'Salários'),(5,'Financiamentos'),(6,'Manutenções');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cpf` varchar(45) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` char(2) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `cep` varchar(15) DEFAULT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL COMMENT 'Data e hora da exclusão do cliente.',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_usuario_idx` (`id_usuario`),
  KEY `fk_cliente_status_idx` (`id_status`),
  CONSTRAINT `fk_cliente_status` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (8,2,2,'sdhf','dsjf@jdhfs.cin','105.530.909-84','(41) 3366-4277','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148',NULL,'2018-10-25 01:02:32',NULL),(9,2,2,'Everton','evertoncrispimmartins@gmail.com','105.530.909-84','(41) 99669-066','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-10-25 01:15:36',NULL),(10,2,1,'jhsad','','105.530.909-84','(21) 83912-382','sdjf','sdfkj','ks','dsjfk','98412','','2018-10-25 01:16:19',NULL),(11,2,1,'dfhs',NULL,'105.530.909-84','(82) 17438-127','jhdsa','jhsfd','jd','hjgh','767687',NULL,'2018-10-25 01:17:59','2018-10-28 12:35:22'),(13,2,1,'agora vai','sdfj2@sjfkd.com','105.530.909-84','(45) 46546-545','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148',NULL,'2018-10-25 02:47:15','2018-10-25 21:54:06'),(14,2,1,'aaa','ksdjf@SDJFK.COMsd','105.530.909-84','(41) 24124-124','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148',NULL,'2018-10-25 02:51:09','2018-10-25 21:54:02'),(15,2,2,'dsjf','kdjs@dskfj.com','105.530.909-84','(12) 41241-241','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-10-25 02:57:29',NULL),(19,2,1,'sdfsdf','sdf@dsjkf.com','105.530.909-84','(64) 65456-546','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148',NULL,'2018-10-25 18:56:38','2018-10-28 12:35:22'),(22,2,1,'asdf',NULL,'105.530.909-84','(41) 24124-124','sdfsdf','sdjk','pr','sadf','14124',NULL,'2018-10-25 21:42:06','2018-10-25 21:54:06'),(23,2,2,'zzzzzzzz',NULL,'105.530.909-84','(32) 41651-213','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-10-25 21:43:38',NULL),(24,2,1,'Jéssica Martins','jessicamm.martins@hotmail.com','070.604.649-80','(41) 9958-7499','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-10-28 12:33:09',NULL),(25,2,2,'Everton','evertoncrispimmartins@gmail.com','105.530.909-84','(41) 33642-779','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-10-29 20:32:55',NULL),(26,2,2,'dsjf',NULL,'105.530.909-84','(49) 12849-824','asdf','asdfklj','pr','kjsdf','1984',NULL,'2018-10-29 21:33:18',NULL),(27,2,2,'dsjf',NULL,'105.530.909-84','(49) 12849-824','asdf','asdfklj','pr','kjsdf','1984',NULL,'2018-10-29 21:33:19',NULL),(28,2,1,'dsjf',NULL,'105.530.909-84','(49) 1284-9824','asdf','asdfklj','pr','kjsdf','1984',NULL,'2018-10-29 21:33:26',NULL),(29,2,1,'dsjf',NULL,'105.530.909-84','(49) 12849-824','asdf','asdfklj','pr','kjsdf','1984',NULL,'2018-10-29 21:33:34','2018-12-05 22:13:56'),(30,2,1,'Everton Crispim Martins','evertonmartins000@hotmail.com','105.530.909-84','(41) 33642-779','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-10-31 22:10:52','2018-11-27 01:34:00'),(31,2,2,'kjko',NULL,'105.530.909-84','(41) 54654-654','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-11-04 21:49:44',NULL),(35,2,2,'Everton Crispim Martins','evertoncrispimmartins@gmail.com','105.530.909-84','(41) 3364-2779','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','148','81.590-337','2018-11-27 01:32:13',NULL),(36,2,2,'asdf','asdf@kjdshf.com','105.530.909-84','(84) 6546-5465','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','124','81.590-337','2018-12-06 17:17:02',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contas_pagar`
--

DROP TABLE IF EXISTS `contas_pagar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contas_pagar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_status` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_hora_pagamento` datetime DEFAULT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contas_pagar_usuario_idx` (`id_usuario`),
  KEY `fk_contas_pagar_categoria_idx` (`id_categoria`),
  KEY `fk_contas_pagar_contas_pagar_status_idx` (`id_status`),
  CONSTRAINT `fk_contas_pagar_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_contas_pagar_status` FOREIGN KEY (`id_status`) REFERENCES `contas_pagar_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contas_pagar`
--

LOCK TABLES `contas_pagar` WRITE;
/*!40000 ALTER TABLE `contas_pagar` DISABLE KEYS */;
INSERT INTO `contas_pagar` VALUES (1,1,6,2,250.00,'2018-11-27 23:57:27','2018-11-27 23:57:27',NULL,'Compra de materiais','2018-12-22'),(2,2,2,2,500.00,NULL,'2018-11-28 00:51:32','2018-12-05 19:18:30','Teste','2018-12-14'),(3,1,2,2,20.00,'2018-12-03 18:41:00','2018-12-03 18:41:25',NULL,'teste beta','2018-12-01'),(4,4,4,2,1200.00,NULL,'2018-12-03 18:42:51',NULL,'Pagamento de Funcionário','2018-12-31'),(5,1,1,2,2600.00,'2018-12-05 00:00:00','2018-12-05 19:18:24',NULL,'Reposição de produto','2019-01-01'),(6,1,3,2,1000.00,'2019-01-15 22:47:00','2019-01-15 22:48:01',NULL,'teste','2019-01-15');
/*!40000 ALTER TABLE `contas_pagar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contas_pagar_status`
--

DROP TABLE IF EXISTS `contas_pagar_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contas_pagar_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contas_pagar_status`
--

LOCK TABLES `contas_pagar_status` WRITE;
/*!40000 ALTER TABLE `contas_pagar_status` DISABLE KEYS */;
INSERT INTO `contas_pagar_status` VALUES (1,'Pago'),(2,'Em atraso'),(3,'Cancelado'),(4,'A pagar');
/*!40000 ALTER TABLE `contas_pagar_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contas_receber`
--

DROP TABLE IF EXISTS `contas_receber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contas_receber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_forma_pagamento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero_fatura` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recebimento_forma_pagamento_idx` (`id_forma_pagamento`),
  KEY `fk_contas_receber_usuario_idx` (`id_usuario`),
  CONSTRAINT `fk_contas_receber_forma_pagamento` FOREIGN KEY (`id_forma_pagamento`) REFERENCES `forma_pagamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_receber_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contas_receber`
--

LOCK TABLES `contas_receber` WRITE;
/*!40000 ALTER TABLE `contas_receber` DISABLE KEYS */;
INSERT INTO `contas_receber` VALUES (24,6,2,1,240.00,'2018-11-08 06:33:31',NULL),(25,4,2,2,430.00,'2018-11-08 06:40:15','2018-12-05 21:29:25'),(26,5,2,3,1.00,'2018-11-13 00:12:24','2018-12-05 21:31:32'),(27,5,2,4,2.00,'2018-11-13 00:16:30','2018-12-05 21:31:29'),(28,4,2,5,5.00,'2018-11-13 00:23:39','2018-12-05 21:31:57'),(29,6,2,6,60.00,'2018-11-13 00:26:43','2018-11-27 23:25:26'),(30,4,2,7,260.00,'2018-11-13 20:59:49','2018-12-05 21:31:46'),(31,5,2,8,650.00,'2018-11-20 00:16:25','2018-12-06 14:12:25'),(32,7,2,9,200.00,'2018-11-27 01:35:37',NULL),(33,5,2,10,310.00,'2018-12-03 19:16:16',NULL),(34,7,2,11,250.00,'2018-12-03 19:18:16','2018-12-05 20:58:21'),(35,4,2,12,595.00,'2018-12-05 11:40:45',NULL),(36,4,2,13,180.00,'2018-12-06 17:20:06',NULL);
/*!40000 ALTER TABLE `contas_receber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contas_receber_ocorrencia`
--

DROP TABLE IF EXISTS `contas_receber_ocorrencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contas_receber_ocorrencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contas_receber` int(11) NOT NULL,
  `id_contas_receber_status` int(11) NOT NULL,
  `valor` varchar(45) NOT NULL,
  `numero_ocorrencia` int(11) NOT NULL COMMENT 'Número da ocorrência da conta',
  `data_hora_pagamento` datetime DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `envio_email_cobranca` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_idx` (`id_contas_receber`),
  KEY `fk_contas_receber_ocorrencia_contas_receber_status_idx` (`id_contas_receber_status`),
  CONSTRAINT `fk_contas_receber_ocorrencia_contas_receber` FOREIGN KEY (`id_contas_receber`) REFERENCES `contas_receber` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_receber_ocorrencia_contas_receber_status` FOREIGN KEY (`id_contas_receber_status`) REFERENCES `contas_receber_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contas_receber_ocorrencia`
--

LOCK TABLES `contas_receber_ocorrencia` WRITE;
/*!40000 ALTER TABLE `contas_receber_ocorrencia` DISABLE KEYS */;
INSERT INTO `contas_receber_ocorrencia` VALUES (110,24,1,'48.00',0,'2018-11-13 01:14:37','2018-11-21',0),(111,24,1,'48.00',0,'2018-11-13 01:14:40','2018-11-21',0),(112,24,1,'48.00',0,'2018-11-13 01:14:31','2018-11-21',0),(113,24,1,'48.00',0,'2018-11-13 01:14:34','2018-11-21',0),(114,24,1,'48.00',0,'2018-11-13 01:13:33','2018-11-21',0),(127,25,1,'43.00',1,'2018-11-13 20:38:09','2018-12-14',0),(128,25,1,'43.00',2,'2018-12-03 18:35:31','2019-01-14',0),(129,25,2,'43.00',3,NULL,'2019-02-14',0),(130,25,2,'43.00',4,NULL,'2019-03-14',0),(131,25,1,'43.00',5,'2018-11-13 01:15:23','2019-04-14',0),(132,25,2,'43.00',6,NULL,'2019-05-14',0),(133,25,2,'43.00',7,NULL,'2019-06-14',0),(134,25,2,'43.00',8,NULL,'2019-07-14',0),(135,25,2,'43.00',9,NULL,'2019-08-14',0),(136,25,2,'43.00',10,NULL,'2019-09-14',0),(137,26,2,'66,67',1,NULL,'2018-11-15',1),(138,26,1,'66,67',2,'2018-12-03 18:34:11','2018-12-15',0),(139,26,2,'66,67',3,NULL,'2019-01-15',0),(140,27,2,'66,67',1,NULL,'2018-11-15',1),(141,27,1,'66,67',2,'2018-12-03 18:37:59','2018-12-15',0),(142,27,2,'66,67',3,NULL,'2019-01-15',0),(143,28,1,'1,67',1,'2018-11-25 20:12:58','1970-01-01',0),(144,28,1,'1,67',2,'2018-11-29 00:00:22','1970-02-01',0),(145,28,2,'1,67',3,NULL,'1970-03-01',1),(146,29,2,'20,00',1,NULL,'2018-11-15',0),(147,29,2,'20,00',2,NULL,'2018-12-15',0),(148,29,2,'20,00',3,NULL,'2019-01-15',0),(149,30,2,'65,00',1,NULL,'2018-11-15',1),(150,30,1,'65,00',2,'2018-12-03 18:34:14','2018-12-15',0),(151,30,2,'65,00',3,NULL,'2019-01-15',0),(152,30,2,'65,00',4,NULL,'2019-02-15',0),(156,31,2,'216.67',1,NULL,'2018-11-28',1),(157,31,2,'216.67',2,NULL,'2018-11-28',1),(158,31,2,'216.67',3,NULL,'2018-11-28',1),(159,32,1,'200.00',1,'2018-11-27 22:53:34','2018-11-26',0),(160,33,1,'310.00',1,'2018-12-03 19:17:22','2019-01-08',0),(161,34,2,'250.00',1,NULL,'2018-12-31',0),(162,35,1,'99.17',1,'2018-12-05 22:47:09','2019-01-10',0),(163,35,1,'99.17',2,'2018-12-05 22:47:12','2019-02-10',0),(164,35,1,'99.17',3,'2018-12-05 22:47:15','2019-03-10',0),(165,35,1,'99.17',4,'2018-12-05 11:42:57','2019-04-10',0),(166,35,1,'99.17',5,'2018-12-05 22:47:17','2019-05-10',0),(167,35,1,'99.17',6,'2018-12-05 22:47:20','2019-06-10',0),(168,36,1,'90.00',1,'2018-12-06 17:25:04','2018-12-06',0),(169,36,1,'90.00',2,'2018-12-06 17:25:06','2019-01-06',0);
/*!40000 ALTER TABLE `contas_receber_ocorrencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contas_receber_status`
--

DROP TABLE IF EXISTS `contas_receber_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contas_receber_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contas_receber_status`
--

LOCK TABLES `contas_receber_status` WRITE;
/*!40000 ALTER TABLE `contas_receber_status` DISABLE KEYS */;
INSERT INTO `contas_receber_status` VALUES (1,'Pago'),(2,'A pagar');
/*!40000 ALTER TABLE `contas_receber_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_pagamento`
--

DROP TABLE IF EXISTS `forma_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forma_pagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_pagamento`
--

LOCK TABLES `forma_pagamento` WRITE;
/*!40000 ALTER TABLE `forma_pagamento` DISABLE KEYS */;
INSERT INTO `forma_pagamento` VALUES (4,'Cartão de Crédito'),(5,'Cartão de Débito'),(6,'Cheque'),(7,'Boleto');
/*!40000 ALTER TABLE `forma_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cnpj` varchar(45) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` char(2) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `cep` char(15) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `telefone` char(15) NOT NULL,
  `email` char(100) NOT NULL,
  `site` varchar(100) DEFAULT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL COMMENT 'Data e hora da exclusão do fornecedor.',
  PRIMARY KEY (`id`),
  KEY `fk_fornecedor_usuario_idx` (`id_usuario`),
  KEY `fk_fornecedor_status_idx` (`id_status`),
  CONSTRAINT `fk_fornecedor_status` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedor_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
INSERT INTO `fornecedor` VALUES (1,2,2,'darley','000000','teste','teste','te','','0000',123,'7894656','teste@gamil.com',NULL,'2018-10-18 04:41:45',NULL),(2,2,2,'Renault','49.687.860/0001-34','Avenida Renault','São José dos Pinhais','PR','Roseira de São Sebastião','83070-900',1300,'(41) 41458-8888','fornecedor@renault.com.br','www.renault.com','2018-11-25 16:53:40',NULL),(3,2,1,'asdf','53.910.349/0001-27','Rua Hipólito César Sobrinho','Curitiba','PR','Uberaba','81.590-337',3434,'(12) 42141-2222','asdfds@dskf.com','asdjkfkoasjd','2018-12-05 22:27:56','2018-12-05 22:28:02');
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimentacao_estoque`
--

DROP TABLE IF EXISTS `movimentacao_estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimentacao_estoque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` char(1) NOT NULL COMMENT 'Tipo de movimentação,\nPodendo ser Entrada ou Saída.',
  `id_produto_estoque` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_hora_movimentacao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimentacao_estoque`
--

LOCK TABLES `movimentacao_estoque` WRITE;
/*!40000 ALTER TABLE `movimentacao_estoque` DISABLE KEYS */;
INSERT INTO `movimentacao_estoque` VALUES (1,'E',12,2,2,'2018-11-19 23:51:21'),(2,'E',12,1,2,'2018-11-19 23:51:46'),(3,'E',12,1,2,'2018-11-19 23:55:52'),(5,'S',12,1,2,'2018-11-19 23:59:02'),(6,'S',10,2,2,'2018-11-19 23:59:25'),(7,'E',12,2,2,'2018-11-19 23:59:36'),(8,'S',11,1,2,'2018-11-20 00:16:26'),(9,'S',11,1,2,'2018-11-20 00:16:26'),(10,'S',1,1,2,'2018-11-20 00:16:57'),(11,'E',11,1,2,'2018-11-20 00:19:43'),(12,'S',11,1,2,'2018-11-20 00:20:38'),(13,'S',11,1,2,'2018-11-20 00:21:08'),(14,'E',11,1,2,'2018-11-20 00:21:20'),(15,'S',9,1,2,'2018-11-20 00:22:03'),(16,'S',9,1,2,'2018-11-20 00:22:04'),(17,'S',2,1,2,'2018-11-20 00:32:23'),(18,'S',2,1,2,'2018-11-20 00:32:42'),(19,'S',2,1,2,'2018-11-20 00:52:30'),(20,'E',2,1,2,'2018-11-20 00:52:44'),(21,'E',2,3,2,'2018-11-20 00:55:23'),(22,'E',8,2,2,'2018-11-20 02:03:15'),(23,'S',8,1,2,'2018-11-20 02:03:19'),(24,'S',8,2,2,'2018-11-20 02:03:22'),(25,'S',8,2,2,'2018-11-20 02:03:23'),(26,'S',8,1,2,'2018-11-20 02:03:28'),(27,'S',8,1,2,'2018-11-20 02:03:31'),(28,'S',8,1,2,'2018-11-20 02:03:34'),(29,'E',8,1,2,'2018-11-20 02:03:37'),(30,'E',8,1,2,'2018-11-20 02:03:39'),(31,'E',8,1,2,'2018-11-20 02:03:43'),(32,'E',8,1,2,'2018-11-20 02:03:45'),(33,'E',8,1,2,'2018-11-20 02:03:49'),(34,'E',8,1,2,'2018-11-20 02:03:51'),(35,'E',8,1,2,'2018-11-20 02:03:55'),(36,'E',8,1,2,'2018-11-20 02:03:58'),(37,'S',2,1,2,'2018-11-20 02:06:32'),(38,'S',2,1,2,'2018-11-20 02:06:32'),(39,'S',2,1,2,'2018-11-20 02:06:32'),(40,'S',2,1,2,'2018-11-20 02:06:32'),(41,'S',2,1,2,'2018-11-20 02:06:32'),(42,'S',2,1,2,'2018-11-20 02:06:32'),(43,'S',12,1,2,'2018-11-20 02:06:32'),(44,'S',12,1,2,'2018-11-20 02:06:32'),(45,'S',12,1,2,'2018-11-20 02:06:32'),(46,'S',9,1,2,'2018-11-20 02:06:32'),(47,'S',9,1,2,'2018-11-20 02:06:32'),(48,'S',9,1,2,'2018-11-20 02:06:32'),(49,'S',9,1,2,'2018-11-20 02:06:32'),(50,'S',9,1,2,'2018-11-20 02:06:32'),(51,'S',9,1,2,'2018-11-20 02:06:32'),(52,'S',9,1,2,'2018-11-20 02:06:32'),(53,'S',11,1,2,'2018-11-20 02:06:32'),(54,'S',11,1,2,'2018-11-20 02:06:32'),(55,'E',2,6,2,'2018-11-20 02:07:23'),(56,'E',9,7,2,'2018-11-20 02:07:23'),(57,'E',11,2,2,'2018-11-20 02:07:23'),(58,'E',12,3,2,'2018-11-20 02:07:23'),(59,'S',2,1,2,'2018-11-20 02:07:56'),(60,'S',2,1,2,'2018-11-20 02:07:57'),(61,'S',2,1,2,'2018-11-20 02:07:57'),(62,'S',2,1,2,'2018-11-20 02:07:57'),(63,'S',2,1,2,'2018-11-20 02:07:57'),(64,'S',2,1,2,'2018-11-20 02:07:57'),(65,'S',9,1,2,'2018-11-20 02:16:02'),(66,'S',9,1,2,'2018-11-20 02:16:02'),(67,'S',9,1,2,'2018-11-20 02:16:02'),(68,'S',9,1,2,'2018-11-20 02:16:02'),(69,'S',9,1,2,'2018-11-20 02:16:02'),(70,'S',9,1,2,'2018-11-20 02:16:02'),(71,'S',9,1,2,'2018-11-20 02:16:26'),(72,'E',2,1,2,'2018-11-20 02:16:42'),(73,'S',2,1,2,'2018-11-20 02:16:57'),(74,'E',2,1,2,'2018-11-20 02:17:14'),(75,'E',9,7,2,'2018-11-25 20:46:16'),(76,'S',2,2,2,'2018-11-25 20:46:27'),(77,'S',11,1,2,'2018-11-27 01:35:38'),(78,'S',11,1,2,'2018-11-27 01:35:38'),(79,'S',9,1,2,'2018-12-03 19:16:16'),(80,'S',9,1,2,'2018-12-03 19:16:16'),(81,'S',9,1,2,'2018-12-03 19:16:16'),(82,'S',9,1,2,'2018-12-03 19:16:16'),(83,'S',9,1,2,'2018-12-05 11:40:46'),(84,'S',12,1,2,'2018-12-05 11:40:46'),(85,'E',13,3,2,'2018-12-05 14:46:06'),(86,'S',8,1,2,'2018-12-06 17:20:06'),(87,'S',9,1,2,'2018-12-06 17:20:06'),(88,'E',14,2,2,'2018-12-06 17:25:19');
/*!40000 ALTER TABLE `movimentacao_estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordem_servico`
--

DROP TABLE IF EXISTS `ordem_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordem_servico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conta_receber` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_ordem_servico_status` int(11) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `quilometragem` varchar(10) NOT NULL,
  `data_hora_inicio` datetime NOT NULL,
  `data_hora_fim` datetime DEFAULT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL COMMENT 'Data e hora de exclusão da ordem de serviço.',
  `data_garantia` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ordem_servico_usuario_idx` (`id_usuario`),
  KEY `fk_ordem_servico_ordem_servico_status_idx` (`id_ordem_servico_status`),
  KEY `fk_ordem_servico_conta_receber_idx` (`id_conta_receber`),
  CONSTRAINT `fk_ordem_servico_conta_receber` FOREIGN KEY (`id_conta_receber`) REFERENCES `contas_receber` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordem_servico_ordem_servico_status` FOREIGN KEY (`id_ordem_servico_status`) REFERENCES `ordem_servico_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordem_servico_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_servico`
--

LOCK TABLES `ordem_servico` WRITE;
/*!40000 ALTER TABLE `ordem_servico` DISABLE KEYS */;
INSERT INTO `ordem_servico` VALUES (37,24,2,3,'teste','500.000','2020-11-20 08:30:00','2020-11-20 06:25:00','2018-11-08 06:33:31',NULL,'2020-11-20'),(38,25,2,1,'adsfsdfd','122.222','2020-11-20 06:38:58','2020-11-20 06:39:01','2018-11-08 06:40:15',NULL,'2020-11-20'),(39,26,2,2,'Manutenção geral','250.000','2018-11-12 22:09:09','2018-11-15 00:09:11','2018-11-13 00:12:26',NULL,'2018-11-15'),(40,27,2,2,'Manutenção geral','250.000','2018-11-12 22:09:09','2018-11-15 00:09:11','2018-11-13 00:16:31',NULL,'2018-11-15'),(41,28,2,2,NULL,'768.768','2013-11-20 00:18:00','2013-11-20 00:18:00','2018-11-13 00:23:39','2018-12-05 21:31:57','2013-11-20'),(42,29,2,1,NULL,'111.111','2013-11-20 00:26:18','2022-11-20 00:26:20','2018-11-13 00:26:43','2018-11-27 23:25:26','2022-11-20'),(43,30,2,2,NULL,'150.000','2018-11-13 20:56:15','2018-11-14 20:56:20','2018-11-13 20:59:50','2018-12-05 21:31:46','2018-11-14'),(44,31,2,2,'asdfas','50.000','2018-11-25 00:15:00','2018-11-26 14:49:00','2018-11-20 00:16:25','2018-12-06 14:14:32','2018-11-26'),(45,32,2,2,'Teste Envio de E-mail','130.000','2018-11-27 01:34:00','2018-11-28 01:34:00','2018-11-27 01:35:37',NULL,'2018-11-28'),(46,33,2,2,'Manutenção mensal','250.000','2018-12-03 19:14:00','2018-12-04 18:14:00','2018-12-03 19:16:16','2018-12-06 14:41:26','2018-12-04'),(47,34,2,1,NULL,'120.000','2018-12-03 19:17:00','2018-12-03 19:17:00','2018-12-03 19:18:16','2018-12-05 20:58:21','2018-12-03'),(48,35,2,2,NULL,'64.545','2018-12-05 11:39:00','2018-12-05 11:39:00','2018-12-05 11:40:45','2018-12-06 14:40:35','2018-12-05'),(49,36,2,2,NULL,'324.324','2018-12-06 17:19:00','2018-12-06 17:19:00','2018-12-06 17:20:06',NULL,'2018-12-06');
/*!40000 ALTER TABLE `ordem_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordem_servico_cliente_veiculo`
--

DROP TABLE IF EXISTS `ordem_servico_cliente_veiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordem_servico_cliente_veiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordem_servico` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_veiculo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ordem_servico_cliente_veiculo_cliente_idx` (`id_cliente`),
  KEY `fk_ordem_servico_cliente_veiculo_veiculo_idx` (`id_veiculo`),
  KEY `fk_ordem_servico_cliente_veiculo_ordem_servico_idx` (`id_ordem_servico`),
  CONSTRAINT `fk_ordem_servico_cliente_veiculo_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordem_servico_cliente_veiculo_ordem_servico` FOREIGN KEY (`id_ordem_servico`) REFERENCES `ordem_servico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordem_servico_cliente_veiculo_veiculo` FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_servico_cliente_veiculo`
--

LOCK TABLES `ordem_servico_cliente_veiculo` WRITE;
/*!40000 ALTER TABLE `ordem_servico_cliente_veiculo` DISABLE KEYS */;
INSERT INTO `ordem_servico_cliente_veiculo` VALUES (7,37,30,42),(8,38,24,38),(9,39,30,42),(10,40,30,42),(11,41,30,42),(12,42,31,43),(13,43,30,42),(14,44,9,10),(15,45,35,44),(16,46,24,38),(17,47,35,44),(18,48,24,38),(19,49,36,50);
/*!40000 ALTER TABLE `ordem_servico_cliente_veiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordem_servico_produto`
--

DROP TABLE IF EXISTS `ordem_servico_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordem_servico_produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto_estoque` int(11) NOT NULL,
  `id_ordem_servico` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ordem_servico_produto_estoque_idx` (`id_produto_estoque`),
  KEY `fk_ordem_servico_produto_ordem_servico_idx` (`id_ordem_servico`),
  CONSTRAINT `fk_ordem_servico_produto_estoque` FOREIGN KEY (`id_produto_estoque`) REFERENCES `produto_estoque` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordem_servico_produto_ordem_servico` FOREIGN KEY (`id_ordem_servico`) REFERENCES `ordem_servico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_servico_produto`
--

LOCK TABLES `ordem_servico_produto` WRITE;
/*!40000 ALTER TABLE `ordem_servico_produto` DISABLE KEYS */;
INSERT INTO `ordem_servico_produto` VALUES (61,3,38,40.00),(62,3,38,40.00),(63,2,38,50.00),(64,3,39,50.00),(65,3,39,50.00),(66,3,40,50.00),(67,3,40,50.00),(141,2,44,50.00),(142,2,44,50.00),(143,2,44,50.00),(144,2,44,50.00),(145,2,44,50.00),(146,2,44,50.00),(147,2,44,50.00),(148,11,45,50.00),(149,11,45,50.00),(150,9,46,40.00),(151,9,46,40.00),(152,9,46,40.00),(153,9,46,40.00),(154,9,48,40.00),(155,12,48,5.00),(156,8,49,50.00),(157,9,49,40.00);
/*!40000 ALTER TABLE `ordem_servico_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordem_servico_status`
--

DROP TABLE IF EXISTS `ordem_servico_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordem_servico_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_servico_status`
--

LOCK TABLES `ordem_servico_status` WRITE;
/*!40000 ALTER TABLE `ordem_servico_status` DISABLE KEYS */;
INSERT INTO `ordem_servico_status` VALUES (1,'Finalizado'),(2,'Em Andamento'),(3,'Cancelado');
/*!40000 ALTER TABLE `ordem_servico_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `rotulo` varchar(45) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produto_fornecedor_idx` (`id_fornecedor`),
  CONSTRAINT `fk_produto_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (2,2,1,'Bico',50.00,NULL),(4,2,2,'Vela',40.00,NULL),(5,2,1,'asdf',5.00,'2018-12-06 17:12:33'),(7,2,1,'Teste',250.00,'2018-12-06 17:10:20');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto_estoque`
--

DROP TABLE IF EXISTS `produto_estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto_estoque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `quantidade_cadastro` int(11) NOT NULL,
  `quantidade_disponivel` int(11) NOT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL COMMENT 'Data e hora de exclusão do produto do estoque.',
  PRIMARY KEY (`id`),
  KEY `fk_produto_estoque_usuario_idx` (`id_usuario`),
  KEY `fk_produto_estoque_produto_idx` (`id_produto`),
  KEY `fk_produto_estoque_produto_estoque_status_idx` (`id_status`),
  CONSTRAINT `fk_produto_estoque_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_estoque_produto_estoque_status` FOREIGN KEY (`id_status`) REFERENCES `produto_estoque_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_estoque_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto_estoque`
--

LOCK TABLES `produto_estoque` WRITE;
/*!40000 ALTER TABLE `produto_estoque` DISABLE KEYS */;
INSERT INTO `produto_estoque` VALUES (2,2,1,2,5,0,'2018-11-01 01:46:51','2018-11-17 23:35:10'),(3,4,2,2,8,-2,'2018-11-01 01:47:04','2018-11-17 23:35:10'),(8,2,1,2,9,8,'0000-00-00 00:00:00',NULL),(9,4,1,2,7,6,'2018-11-17 23:17:20',NULL),(10,2,1,2,8,8,'2018-11-17 23:58:10',NULL),(11,7,2,2,2,2,'2018-11-19 23:50:11',NULL),(12,5,1,2,3,3,'2018-11-19 23:51:21','2018-12-06 14:54:47'),(13,2,1,2,3,3,'2018-12-05 14:46:06','2018-12-06 12:31:26'),(14,4,1,2,2,2,'2018-12-06 17:25:19','2018-12-06 17:25:26');
/*!40000 ALTER TABLE `produto_estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto_estoque_status`
--

DROP TABLE IF EXISTS `produto_estoque_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto_estoque_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto_estoque_status`
--

LOCK TABLES `produto_estoque_status` WRITE;
/*!40000 ALTER TABLE `produto_estoque_status` DISABLE KEYS */;
INSERT INTO `produto_estoque_status` VALUES (1,'Disponível'),(2,'Vendido'),(3,'Com Defeito');
/*!40000 ALTER TABLE `produto_estoque_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico`
--

DROP TABLE IF EXISTS `servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico`
--

LOCK TABLES `servico` WRITE;
/*!40000 ALTER TABLE `servico` DISABLE KEYS */;
INSERT INTO `servico` VALUES (1,'Troca de Òleo',90.00),(2,'Limpeza de bicos',150.00),(6,'Balanceamento',60.00);
/*!40000 ALTER TABLE `servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico_ordem_servico`
--

DROP TABLE IF EXISTS `servico_ordem_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servico_ordem_servico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordem_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_servico_ordem_servico_servico_idx` (`id_servico`),
  KEY `fk_servico_ordem_servico_ordem_servico_idx` (`id_ordem_servico`),
  CONSTRAINT `fk_servico_ordem_servico_ordem_servico` FOREIGN KEY (`id_ordem_servico`) REFERENCES `ordem_servico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordem_servico_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico_ordem_servico`
--

LOCK TABLES `servico_ordem_servico` WRITE;
/*!40000 ALTER TABLE `servico_ordem_servico` DISABLE KEYS */;
INSERT INTO `servico_ordem_servico` VALUES (42,38,1,100.00),(43,39,1,100.00),(44,40,1,100.00),(45,41,1,90.00),(46,42,6,60.00),(47,43,1,100.00),(48,43,6,60.00),(51,44,2,150.00),(53,37,6,60.00),(54,44,1,90.00),(55,44,6,60.00),(56,37,2,150.00),(57,45,1,100.00),(58,46,2,150.00),(59,47,6,250.00),(60,48,2,150.00),(61,48,1,90.00),(62,49,1,90.00);
/*!40000 ALTER TABLE `servico_ordem_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'inativo'),(2,'ativo');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_status` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `master` tinyint(1) NOT NULL,
  `pergunta_senha` varchar(50) DEFAULT NULL,
  `resposta_senha` varchar(50) DEFAULT NULL,
  `data_hora_cadastro` datetime NOT NULL COMMENT 'Data e hora do cadastro.',
  `data_hora_exclusao` datetime DEFAULT NULL COMMENT 'Data e hora da exclusão do usuário.',
  PRIMARY KEY (`id`),
  KEY `fk_usuario_status_idx` (`id_status`),
  CONSTRAINT `fk_usuario_status` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,2,'Admin','admin','21232f297a57a5a743894a0e4a801fc3','admin@gmail.com',1,'nada','nada','2018-10-16 00:14:48',NULL),(2,2,'Everton','everton','db372bc1c7d3f09d7427b8d4605af201','everton@gmail.com',1,'nada','nada','2018-10-17 21:41:21',NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `veiculo`
--

DROP TABLE IF EXISTS `veiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `veiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `placa` varchar(9) NOT NULL,
  `chassis` varchar(10) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL,
  `cor` varchar(15) NOT NULL,
  `kilometragem` varchar(10) DEFAULT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_exclusao` datetime DEFAULT NULL COMMENT 'Data e hora da exclusão do veículo.',
  `data_ultima_manutencao` date DEFAULT NULL,
  `email_manutencao` tinyint(1) DEFAULT '0',
  `data_ultimo_email` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_veiculo_cliente_idx` (`id_cliente`),
  KEY `fk_veiculo_usuario_idx` (`id_usuario`),
  KEY `fk_veiculo_status_idx` (`id_status`),
  CONSTRAINT `fk_veiculo_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_veiculo_status` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_veiculo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `veiculo`
--

LOCK TABLES `veiculo` WRITE;
/*!40000 ALTER TABLE `veiculo` DISABLE KEYS */;
INSERT INTO `veiculo` VALUES (8,8,2,1,'sdh2387','sdjfh','jsadfh','',8723,'hdsj','823.747','2018-10-25 01:02:32','2018-10-29 22:21:21','2016-10-29',0,NULL),(9,8,2,1,'654dss','sdjkf','dteste','s',9841,'sjdkf','982.412','2018-10-25 01:02:33','2018-10-25 20:43:53','2016-10-29',0,NULL),(10,9,2,2,'9412JDS','sdfjk','sdfj','s',9234,'sdfsd','9.384','2018-10-25 01:15:36',NULL,'2016-10-29',1,'2018-12-05'),(11,10,2,2,'dsj9879','sdfjk','jfsd','s',3248,'sdfjk','23.847','2018-10-25 01:16:19',NULL,'2016-10-29',1,'2018-12-05'),(12,11,2,2,'jds8237','sdnjk','hjsdf','k',7823,'sdfh','8.293.748','2018-10-25 01:17:59',NULL,'2016-10-29',0,NULL),(13,13,2,1,'jdf9349','dsjfkj','testem1','t',2394,'sdkfj','92.428','2018-10-25 02:47:15','2018-10-25 20:37:49','2016-10-29',0,NULL),(14,13,2,2,'sdu9889','dskfk','testem2','',8439,'jdsfk','98.898','2018-10-25 02:47:15',NULL,'2016-10-29',0,NULL),(15,14,2,1,'4219kds','dksfj','kdsjfds','funcionaaaa',9834,'sdkjf','841.912','2018-10-25 02:51:09','2018-10-25 06:42:38','2016-10-29',0,NULL),(16,14,2,1,'1934djf','sdkfj','dsjkfj','inativo',9823,'kjdsf','93.284','2018-10-25 02:51:09','2018-10-25 07:01:43','2016-10-29',0,NULL),(17,15,2,1,'jds','23487','11111','testee',324,'dskjf','412.421','2018-10-25 02:57:29','2018-10-25 20:44:24','2016-10-29',0,NULL),(18,15,2,1,'jfs9343','sdfj','222222','sdfj',234,'dfsj','324.234','2018-10-25 02:57:29',NULL,'2016-10-29',1,'2018-12-05'),(19,14,2,1,'jkf8723','jsdfh','jdfh8234','sdhf',8723,'dfs','878','2018-10-25 05:09:28','2018-10-25 06:37:39','2016-10-29',0,NULL),(20,8,2,1,'sdk2348','sjfd','jksfdj','jshfd',7823,'jksdf','82.374','2018-10-25 06:40:26','2018-10-25 06:40:26','0000-00-00',0,NULL),(21,8,2,1,'ksd2348','sdfkj','kjfsd','sdkfj',8723,'jsfd','7.283.482','2018-10-25 06:40:47','2018-10-25 06:40:47','2016-10-29',0,NULL),(22,14,2,1,'sfd','sdfkj','jsdf','jdsf',3498,'jfdsk','983.249','2018-10-25 06:42:52','2018-10-25 06:42:52','2016-10-29',0,NULL),(23,14,2,1,'dsf8897','jhdfs','hjsfd','dsf',8237,'sdf','283.478.32','2018-10-25 06:43:30','2018-10-25 20:33:19','2016-10-29',0,NULL),(24,14,2,1,'fsd2347','kjdf','kjsdkfj','sdkf',8723,'dsf','82.734.874','2018-10-25 06:45:11','2018-10-25 06:45:11','2016-10-29',0,NULL),(25,14,2,1,'jds1241','sdf','dskj','',8787,'dfs','421.124','2018-10-25 06:47:59','2018-10-25 20:37:28','2016-10-29',0,NULL),(26,14,2,1,'dsf9878','kjfds','skdjf','dsfj',8787,'fdsjk','878.787','2018-10-25 06:50:44','2018-10-25 06:50:44','2016-10-29',0,NULL),(27,14,2,1,'fds234','dskfj','dfsjk','ksdfj',8712,'kdsjf','87.324','2018-10-25 07:01:31','2018-10-25 07:01:31','2016-10-29',0,NULL),(28,19,2,2,'sas1241','asdf','asdf','sdkfj412',2015,'ksjdf','234.234','2018-10-25 18:56:38',NULL,'2016-10-29',0,NULL),(29,14,2,1,'jsk8742','ksdjf','sdfjh2384','',8273,'ksdjf','82.347','2018-10-25 19:33:36','2018-10-25 21:52:02','2016-10-29',0,NULL),(30,14,2,1,'jkf8237','kdsfj','fsdk23948','aaaaaaa',7324,'sdjfk','23.874','2018-10-25 20:53:27','2018-10-25 20:53:34','2016-10-29',0,NULL),(31,14,2,1,'kjs8732','kdjsfk','jfsadkf324988','bbbbbbb',4832,'jijsfdsd','883.274.83','2018-10-25 20:53:27','2018-10-25 20:53:34','2016-10-29',0,NULL),(32,22,2,1,'4124','sdfsdf','sdfh','sdfdsf',2341,'sdfsdf','124.423','2018-10-25 21:42:06',NULL,'2016-10-29',0,NULL),(33,22,2,1,'kjh8234','sdfdsf','sdfj28347','sdfsad',2342,'dsfsdf','82.374','2018-10-25 21:42:06',NULL,'2016-10-29',0,NULL),(34,23,2,1,'1241sdf','sdfsdf','sdfsdf','bbbb',4124,'sdfasdf','23.423.432','2018-10-25 21:43:38','2018-10-29 22:21:43','2016-10-29',0,NULL),(35,23,2,1,'sda3242','kjhsdfjkj','asdfsd','ddddddd',2387,'hedfsd','78.274.382','2018-10-25 21:43:38','2018-10-29 22:21:43','2016-10-29',0,NULL),(36,14,2,1,'kls2342','sdfasd','klsdfju2','asdf',1412,'sdfsdf','324.234','2018-10-25 21:44:22','2018-10-25 21:51:55','2016-10-29',0,NULL),(37,14,2,2,'2332fd','sdafs','sdf','ccccc',1324,'sdfasdf','283.947','2018-10-25 21:45:09',NULL,'2016-10-29',0,NULL),(38,24,2,2,'GFE5456','dsfrd','dwsfdew','dsdsw',3232,'dcsd','545.454','2018-10-28 12:33:09',NULL,'2018-12-05',0,NULL),(39,25,2,2,'3DDF324','aksdjf','aksdjf','kfjsa',2091,'skdjf','923.849','2018-10-29 20:32:56',NULL,'2016-10-29',1,'2018-12-05'),(40,29,2,2,'KSJ3242','sdjfk','sdkfj','ksjdf',9834,'fjdsk','9.823','2018-10-29 21:33:34',NULL,'2016-10-29',1,'2018-12-05'),(41,28,2,1,'JFD2394','sdjfk','kjdsf','sdfkj',9832,'sdjk','29.384','2018-10-30 01:58:35',NULL,'2016-10-29',1,'2018-12-05'),(42,30,2,2,'aaa9898','aksdfjasd','Chevrolet','Corsa Max 1.4',2009,'Preto','110.000','2018-10-31 22:10:53',NULL,'2016-10-29',0,NULL),(43,31,2,2,'fju0909','sdfsd4','jds902348','dsjf',5646,'sdfsdd','154.654','2018-11-04 21:49:44',NULL,'2016-10-29',1,'2018-12-05'),(44,35,2,2,'JSA3432','salkdjfdf','Chevrolet','Corsa Max 1.4',2009,'Preto','125.000','2018-11-27 01:32:13',NULL,'2018-12-03',0,NULL),(45,28,2,2,'RF234F2','asdfsdf','asdfasd','asdf',1241,'sdafsdf','2.141.241','2018-11-28 09:04:47',NULL,'2016-10-29',1,'2018-12-05'),(46,28,2,2,'RF234F2','asdfsdf','asdfasd','asdf',1241,'sdafsdf','2.141.241','2018-11-28 09:04:59',NULL,'2016-10-29',1,'2018-12-05'),(47,28,2,2,'RF234F2','asdfsdf','asdfasd','asdf',1241,'sdafsdf','2.141.241','2018-11-28 09:05:23',NULL,'2016-10-29',1,'2018-12-05'),(48,36,2,1,'32D43SD','asdfasdf','asdfad','asdf',1243,'sdfasdf','32.423','2018-12-06 17:17:02','2018-12-06 17:17:11',NULL,0,NULL),(49,36,2,1,'ASD2423','asdfsad','134234sdf','asdfasdf',2342,'sdafasdf','1.243.243','2018-12-06 17:17:02',NULL,NULL,0,NULL),(50,36,2,1,'1432SDF','sadfs','1241dsf','asadfas',3423,'fsdsdf','124.124.12','2018-12-06 17:17:24',NULL,'2018-12-06',0,NULL);
/*!40000 ALTER TABLE `veiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'erp'
--

--
-- Dumping routines for database 'erp'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-15 23:01:24

-->