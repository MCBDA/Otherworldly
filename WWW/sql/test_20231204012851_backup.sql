-- MySQL dump 10.13  Distrib 5.7.26, for Win64 (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `map`
--

DROP TABLE IF EXISTS `map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地图ID',
  `map_name` varchar(255) NOT NULL DEFAULT '' COMMENT '地图名称',
  `description` text COMMENT '地图描述',
  `up_connection` int(11) DEFAULT NULL COMMENT '上面地图的ID',
  `down_connection` int(11) DEFAULT NULL COMMENT '下面地图ID',
  `left_connection` int(11) DEFAULT NULL COMMENT '左边地图ID',
  `right_connection` int(11) DEFAULT NULL COMMENT '右边地图ID',
  `monsters` text COMMENT '地图上的怪物信息，格式为JSON,例如：{"monster_id": 1, "name": "怪物1"}',
  `npcs` text COMMENT '地图上NPC信息，格式为JSON,例如：{"npc_id": 1, "name": "NPC1", "dialogue": "欢迎来到地点1！"}',
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map`
--

LOCK TABLES `map` WRITE;
/*!40000 ALTER TABLE `map` DISABLE KEYS */;
INSERT INTO `map` VALUES (1,'新手村','这里是新手村',NULL,NULL,NULL,NULL,'[{\"monster_id\":1,\"name\":\"怪物1\"},{\"monster_id\":2,\"name\":\"怪物2\"},{\"monster_id\":3,\"name\":\"怪物3\"},{\"monster_id\":4,\"name\":\"怪物4\"},{\"monster_id\":5,\"name\":\"怪物5\"}]','[{\"npc_id\":1,\"name\":\"东南校长\",\"dialogue\":\"欢迎来到东南学校！作为新生，你将扮演我们的“勇者”，勇敢地闯荡校园各个角落。准备好了吗？哈哈，你的热情很可爱。但在成为最强勇者之前，你需要通过一系列任务和挑战来磨练自己。准备好接受第一个任务了吗？\"},{\"npc_id\":2,\"name\":\" 王魔导师\",\"dialogue\":\"你好，新来的勇者同学！我是你的导师，负责帮助你了解和掌握数据库的奥秘。没错，精通数据库的知识就像拥有一把通向宝藏的钥匙。但首先，我们从掌握基础开始吧。准备好迎接数据库的精彩世界了吗？\"}]');
/*!40000 ALTER TABLE `map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `health_points` int(11) DEFAULT NULL,
  `mana_points` int(11) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  `inventory` text,
  `map_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,4,'琪亚娜',0,0,100,50,0,'',1),(2,3,'姬子',0,0,110,60,0,'',1),(3,4,'薛羽',NULL,NULL,NULL,NULL,NULL,NULL,1),(4,4,'雷神',NULL,NULL,NULL,NULL,NULL,NULL,1),(5,4,'钢铁侠',0,NULL,NULL,NULL,NULL,NULL,1),(6,4,'111',NULL,NULL,NULL,NULL,NULL,NULL,1),(7,4,'222',NULL,NULL,NULL,NULL,NULL,NULL,1),(8,4,'任韵',NULL,NULL,NULL,NULL,NULL,NULL,1),(9,4,'成蓓',NULL,NULL,NULL,NULL,NULL,NULL,1),(10,4,'樊钧',NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'mlgzs','woshiwei123'),(2,'www','$2y$10$A1SbiqVrdA4A8fGdBVS8H.BKjr9KG.jeCLxrJ8BiMEx41npYpVrQO'),(3,'test','$2y$10$uSzYciOXIGeXZeKKdbbTP.ub2kutTJ97xY1DgUgzJ2MvPmk.nOzfO'),(4,'lll','$2y$10$PWv9RCMcygg8LXoyfDlAj.jhG9veS/5sJFoLmfG38QJbKQMdep8IC'),(5,'hhh','$2y$10$.PXTgNW5dmEgn882BHxvEuy3VeRvpnkmShQhe6TFhYfwAiiWhqtI2'),(6,'a','$2y$10$BfGfxUymf3xWoT/cuxLew.P4BlKKCKgAFYERAFEBcCzzNCuVRazv.'),(7,'s','$2y$10$XFSvIKnoh44eytZeV25ssu2ZmdM7tILxNTvLdg8HJF0SRcm8RK1Ym'),(8,'aa','$2y$10$XhhxbGCh6aCdJdtCqP02BOdS5VYqDT16H1uELN2EENJrH7r4/meRW'),(9,'ss','$2y$10$gdX0OMXjX.2WW3gfQDiV5uwzzak.mVxiIishouSMHwTXgGmlbyu/a');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-04  1:28:52
