/*
Navicat MySQL Data Transfer

Source Server         : Localhost PHP 7
Source Server Version : 100137
Source Host           : localhost:3307
Source Database       : db_apotek_build

Target Server Type    : MYSQL
Target Server Version : 100137
File Encoding         : 65001

Date: 2021-04-11 20:26:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for alus_la
-- ----------------------------
DROP TABLE IF EXISTS `alus_la`;
CREATE TABLE `alus_la` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of alus_la
-- ----------------------------
