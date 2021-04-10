/*
Navicat MySQL Data Transfer

Source Server         : Localhost PHP 7
Source Server Version : 100137
Source Host           : localhost:3307
Source Database       : db_apotek_build

Target Server Type    : MYSQL
Target Server Version : 100137
File Encoding         : 65001

Date: 2021-04-10 21:55:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for alus_g
-- ----------------------------
DROP TABLE IF EXISTS `alus_g`;
CREATE TABLE `alus_g` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of alus_g
-- ----------------------------
INSERT INTO `alus_g` VALUES ('1', 'admin', 'testaa');
INSERT INTO `alus_g` VALUES ('2', 'Kasir', '');
INSERT INTO `alus_g` VALUES ('3', 'Manajer', '');

-- ----------------------------
-- Table structure for alus_mg
-- ----------------------------
DROP TABLE IF EXISTS `alus_mg`;
CREATE TABLE `alus_mg` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_parent` int(11) NOT NULL,
  `menu_nama` varchar(255) NOT NULL,
  `menu_uri` varchar(255) NOT NULL,
  `menu_target` varchar(255) DEFAULT NULL,
  `menu_icon` varchar(25) DEFAULT NULL,
  `order_num` int(5) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of alus_mg
-- ----------------------------
INSERT INTO `alus_mg` VALUES ('11', '30', 'Menus', 'menus', '', 'fas fa-bars fa-fw', '1');
INSERT INTO `alus_mg` VALUES ('12', '30', 'Group', 'group', '', 'fa fa-book fa-fw', '2');
INSERT INTO `alus_mg` VALUES ('13', '30', 'User', 'users', '', 'fa fa-book fa-fw', '3');
INSERT INTO `alus_mg` VALUES ('30', '0', 'Manajemen App', '#', '', 'fas fa-cogs fa-fw', '1');
INSERT INTO `alus_mg` VALUES ('31', '0', 'Master', '#', '', 'fas fa-book fa-fw', '1');
INSERT INTO `alus_mg` VALUES ('32', '31', 'Obat', 'obat', '', 'fas fa-cubes fa-fw', '1');
INSERT INTO `alus_mg` VALUES ('33', '31', 'Alkes (Alat Kesehatan)', '#', '', 'fas fa-cubes fa-fw', '2');
INSERT INTO `alus_mg` VALUES ('34', '31', 'Kategori Obat', 'kategori_obat', '', 'fas fa-cubes fa-fw', '3');
INSERT INTO `alus_mg` VALUES ('35', '31', 'Unit / Satuan', 'unit', '', 'fas fa-cubes fa-fw', '4');
INSERT INTO `alus_mg` VALUES ('36', '31', 'Suppliers', 'suppliers', '', 'fas fa-building fa-fw', '5');

-- ----------------------------
-- Table structure for alus_mga
-- ----------------------------
DROP TABLE IF EXISTS `alus_mga`;
CREATE TABLE `alus_mga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` mediumint(8) unsigned NOT NULL,
  `id_menu` int(11) NOT NULL,
  `can_view` int(1) DEFAULT NULL,
  `can_edit` int(1) NOT NULL DEFAULT '0',
  `can_add` int(1) NOT NULL DEFAULT '0',
  `can_delete` int(1) NOT NULL DEFAULT '0',
  `psv` datetime DEFAULT NULL,
  `pev` datetime DEFAULT NULL,
  `psed` datetime DEFAULT NULL,
  `peed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_groups_deleted` (`id_group`) USING BTREE,
  KEY `fk_menu_deleted` (`id_menu`),
  CONSTRAINT `alus_mga_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `alus_mg` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3863 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of alus_mga
-- ----------------------------
INSERT INTO `alus_mga` VALUES ('3853', '1', '30', '1', '1', '1', '1', '2016-09-06 10:55:00', '2016-09-06 10:55:00', '2016-08-08 12:06:00', '2016-08-09 13:50:00');
INSERT INTO `alus_mga` VALUES ('3854', '1', '11', '1', '1', '1', '1', '2016-09-06 10:55:00', '2016-09-06 10:55:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3855', '1', '12', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3856', '1', '13', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3857', '1', '31', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3858', '1', '32', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3859', '1', '33', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3860', '1', '34', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3861', '1', '35', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');
INSERT INTO `alus_mga` VALUES ('3862', '1', '36', '1', '1', '1', '1', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00', '1970-01-01 01:00:00');

-- ----------------------------
-- Table structure for alus_u
-- ----------------------------
DROP TABLE IF EXISTS `alus_u`;
CREATE TABLE `alus_u` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `job_title` varchar(50) DEFAULT NULL,
  `abc` varchar(100) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `ghi` varchar(255) NOT NULL,
  `def` varchar(255) DEFAULT NULL,
  `mno` varchar(40) DEFAULT NULL,
  `jkl` varchar(40) DEFAULT NULL,
  `stu` int(11) unsigned DEFAULT NULL,
  `pqr` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `ht` int(1) DEFAULT '0',
  `picture` varchar(255) DEFAULT NULL,
  `mdo_id` int(11) DEFAULT NULL,
  `mos_id` int(11) DEFAULT NULL,
  `grup_type` int(11) DEFAULT NULL,
  `bpd_id` int(11) DEFAULT NULL,
  `bpd_id_2` int(11) DEFAULT NULL,
  `staff_pmk_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sys_users_idx1` (`id`) USING BTREE,
  KEY `sys_users_idx2` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of alus_u
-- ----------------------------
INSERT INTO `alus_u` VALUES ('64', 'admins', 'admins', 'MTIzNDU2Nzg5MDEyMzQ1Nvqvv5U+5Kixew57njDPeg==', '::1', '$2y$08$.sbsuXatbF/d4/RvUy77GeeX/Nw48XoXXS/3Xurj7O/ujoQu3KGzK', 'xEfWFClsAdO4BnNm', '', '', null, '', '1469523580', '1579833925', '1', 'User', '', '', '11', '0', '1496118042.jpg', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for alus_ug
-- ----------------------------
DROP TABLE IF EXISTS `alus_ug`;
CREATE TABLE `alus_ug` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`) USING BTREE,
  KEY `fk_users_groups_users1_idx` (`user_id`) USING BTREE,
  KEY `fk_users_groups_groups1_idx` (`group_id`) USING BTREE,
  CONSTRAINT `alus_ug_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `alus_g` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `alus_ug_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `alus_u` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of alus_ug
-- ----------------------------
INSERT INTO `alus_ug` VALUES ('1', '64', '1');

-- ----------------------------
-- Table structure for m_kategori
-- ----------------------------
DROP TABLE IF EXISTS `m_kategori`;
CREATE TABLE `m_kategori` (
  `mk_id` int(25) NOT NULL AUTO_INCREMENT,
  `mk_nama` varchar(255) DEFAULT NULL,
  `mk_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mk_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_kategori
-- ----------------------------
INSERT INTO `m_kategori` VALUES ('1', 'Antioksidan', '2021-04-07 22:33:30', '2021-04-07 22:33:45');
INSERT INTO `m_kategori` VALUES ('2', 'Anti Radang', '2021-04-07 22:33:42', null);
INSERT INTO `m_kategori` VALUES ('3', 'Alkes', '2021-04-07 22:38:24', null);

-- ----------------------------
-- Table structure for m_obat
-- ----------------------------
DROP TABLE IF EXISTS `m_obat`;
CREATE TABLE `m_obat` (
  `mo_id` int(25) NOT NULL AUTO_INCREMENT,
  `mo_nama` varchar(255) NOT NULL,
  `mo_barcode` varchar(255) NOT NULL,
  `mo_penyimpanan` varchar(255) DEFAULT NULL,
  `mo_mu_id` int(25) DEFAULT NULL,
  `mo_mk_id` int(25) DEFAULT NULL,
  `mo_deskripsi` longtext,
  `mo_picture` longtext,
  `mo_resep` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Non Resep, 1 = Perlu Resep',
  `mo_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mo_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mo_id`),
  KEY `m_unit` (`mo_mu_id`),
  KEY `m_kategori` (`mo_mk_id`),
  CONSTRAINT `m_kategori` FOREIGN KEY (`mo_mk_id`) REFERENCES `m_kategori` (`mk_id`),
  CONSTRAINT `m_unit` FOREIGN KEY (`mo_mu_id`) REFERENCES `m_unit` (`mu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_obat
-- ----------------------------
INSERT INTO `m_obat` VALUES ('1', 'Paramex', '1', 'Laci', '2', '2', 'Paramex', null, '0', '2021-04-07 22:39:51', null);
INSERT INTO `m_obat` VALUES ('2', 'Paramex', '1', 'Laci', '4', '2', 'Paramex', null, '0', '2021-04-07 22:40:11', null);

-- ----------------------------
-- Table structure for m_supplier
-- ----------------------------
DROP TABLE IF EXISTS `m_supplier`;
CREATE TABLE `m_supplier` (
  `ms_id` int(25) NOT NULL AUTO_INCREMENT,
  `ms_nama` varchar(255) DEFAULT NULL,
  `ms_alamat` longtext,
  `ms_telp` varchar(255) DEFAULT NULL,
  `ms_kodepos` varchar(255) DEFAULT NULL,
  `ms_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ms_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_supplier
-- ----------------------------
INSERT INTO `m_supplier` VALUES ('1', 'asd', 'asd', '123', '123', '2021-04-07 22:38:52', null);

-- ----------------------------
-- Table structure for m_unit
-- ----------------------------
DROP TABLE IF EXISTS `m_unit`;
CREATE TABLE `m_unit` (
  `mu_id` int(25) NOT NULL AUTO_INCREMENT,
  `mu_nama` varchar(255) DEFAULT NULL,
  `mu_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mu_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_unit
-- ----------------------------
INSERT INTO `m_unit` VALUES ('1', 'Kapsul', '2021-04-07 22:38:35', null);
INSERT INTO `m_unit` VALUES ('2', 'Tablet', '2021-04-07 22:38:39', null);
INSERT INTO `m_unit` VALUES ('3', 'Sirup', '2021-04-07 22:38:43', null);
INSERT INTO `m_unit` VALUES ('4', 'Box', '2021-04-07 22:39:35', null);

-- ----------------------------
-- Table structure for sys_codes
-- ----------------------------
DROP TABLE IF EXISTS `sys_codes`;
CREATE TABLE `sys_codes` (
  `srn_id` int(11) NOT NULL AUTO_INCREMENT,
  `srn_code` varchar(50) DEFAULT NULL,
  `srn_value` int(11) DEFAULT NULL,
  `srn_length` int(11) DEFAULT '5',
  `srn_format` varchar(50) DEFAULT NULL,
  `srn_year` int(11) DEFAULT NULL,
  `srn_month` int(11) DEFAULT NULL,
  `srn_reset_by` varchar(20) DEFAULT 'NONE',
  PRIMARY KEY (`srn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_codes
-- ----------------------------
INSERT INTO `sys_codes` VALUES ('1', 'SN-IDTOKO', '52', '5', '{VALUE}', '2017', '1', 'YEAR');

-- ----------------------------
-- Table structure for t_batch
-- ----------------------------
DROP TABLE IF EXISTS `t_batch`;
CREATE TABLE `t_batch` (
  `tb_id` int(25) NOT NULL AUTO_INCREMENT,
  `tb_tgl_masuk` date DEFAULT NULL,
  `tb_tgl_kadaluarsa` date DEFAULT NULL,
  `tb_mo_id` int(25) DEFAULT NULL,
  `tb_ms_id` int(25) DEFAULT NULL,
  `tb_harga_beli` double DEFAULT NULL,
  `tb_harga_jual` double DEFAULT NULL,
  `tb_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tb_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tb_id`),
  KEY `m_obat` (`tb_mo_id`),
  KEY `m_supplier` (`tb_ms_id`),
  CONSTRAINT `m_obat` FOREIGN KEY (`tb_mo_id`) REFERENCES `m_obat` (`mo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `m_supplier` FOREIGN KEY (`tb_ms_id`) REFERENCES `m_supplier` (`ms_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_batch
-- ----------------------------
INSERT INTO `t_batch` VALUES ('1', '2021-04-07', '2021-04-30', '1', '1', '1000', '2000', '2021-04-07 22:42:08', null);
INSERT INTO `t_batch` VALUES ('2', '2021-04-09', '2021-05-20', '1', '1', '1100', '2000', '2021-04-07 22:42:45', null);

-- ----------------------------
-- Table structure for t_invoice
-- ----------------------------
DROP TABLE IF EXISTS `t_invoice`;
CREATE TABLE `t_invoice` (
  `ti_id` int(25) NOT NULL AUTO_INCREMENT,
  `ti_nomor_inv` varchar(255) NOT NULL,
  `ti_user_id` int(11) unsigned DEFAULT NULL,
  `ti_tgl` datetime DEFAULT NULL,
  `ti_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ti_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ti_total_barang` varchar(255) DEFAULT '0',
  `ti_subtotal` double DEFAULT '0',
  `ti_ppn_nilai` double DEFAULT '0',
  `ti_grandtotal` double DEFAULT '0',
  `ti_nominal_bayar` double DEFAULT '0',
  `ti_nominal_kembalian` double DEFAULT '0',
  PRIMARY KEY (`ti_id`),
  KEY `user_id` (`ti_user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`ti_user_id`) REFERENCES `alus_u` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for t_invoice_detail
-- ----------------------------
DROP TABLE IF EXISTS `t_invoice_detail`;
CREATE TABLE `t_invoice_detail` (
  `tid_id` int(25) NOT NULL AUTO_INCREMENT,
  `tid_mo_id` int(25) DEFAULT NULL,
  `tid_tb_id` int(25) DEFAULT NULL,
  `tid_qty` int(25) DEFAULT NULL,
  `tid_harga_satuan` double DEFAULT NULL,
  `tid_total` double DEFAULT NULL,
  `tid_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tid_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tid_id`),
  KEY `tid_mo_id` (`tid_mo_id`),
  KEY `tid_tb_id` (`tid_tb_id`),
  CONSTRAINT `tid_mo_id` FOREIGN KEY (`tid_mo_id`) REFERENCES `m_obat` (`mo_id`) ON UPDATE NO ACTION,
  CONSTRAINT `tid_tb_id` FOREIGN KEY (`tid_tb_id`) REFERENCES `t_batch` (`tb_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_invoice_detail
-- ----------------------------

-- ----------------------------
-- Table structure for t_jurnal
-- ----------------------------
DROP TABLE IF EXISTS `t_jurnal`;
CREATE TABLE `t_jurnal` (
  `tj_id` int(25) NOT NULL AUTO_INCREMENT,
  `tj_ti_id` int(25) DEFAULT NULL,
  `tj_mo_id` int(25) DEFAULT NULL,
  `tj_tb_id` int(11) DEFAULT NULL,
  `tj_masuk` int(11) DEFAULT '0',
  `tj_keluar` int(11) DEFAULT '0',
  `tj_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tj_id`),
  KEY `tj_m_obat` (`tj_mo_id`),
  KEY `tj_t_batch` (`tj_tb_id`),
  CONSTRAINT `tj_m_obat` FOREIGN KEY (`tj_mo_id`) REFERENCES `m_obat` (`mo_id`) ON UPDATE NO ACTION,
  CONSTRAINT `tj_t_batch` FOREIGN KEY (`tj_tb_id`) REFERENCES `t_batch` (`tb_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_jurnal
-- ----------------------------
INSERT INTO `t_jurnal` VALUES ('1', null, '1', '2', '200', '0', '2021-04-07 22:43:09');
INSERT INTO `t_jurnal` VALUES ('2', null, '1', '1', '100', '0', '2021-04-07 22:43:01');
INSERT INTO `t_jurnal` VALUES ('4', null, '1', '1', '0', '10', '2021-04-07 22:48:20');
INSERT INTO `t_jurnal` VALUES ('5', null, '1', '1', '0', '10', '2021-04-07 22:48:31');
INSERT INTO `t_jurnal` VALUES ('6', null, '1', '1', '1', '0', '2021-04-07 22:48:49');

-- ----------------------------
-- Table structure for t_jurnal_keuangan
-- ----------------------------
DROP TABLE IF EXISTS `t_jurnal_keuangan`;
CREATE TABLE `t_jurnal_keuangan` (
  `tjk_id` int(25) NOT NULL AUTO_INCREMENT,
  `tjk_ti_id` int(25) DEFAULT NULL,
  `tjk_masuk` double(25,2) DEFAULT '0.00',
  `tjk_keluar` double(25,2) DEFAULT '0.00',
  `tjk_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tjk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_jurnal_keuangan
-- ----------------------------
INSERT INTO `t_jurnal_keuangan` VALUES ('1', null, '200.00', '0.00', '2021-04-07 22:43:09');
INSERT INTO `t_jurnal_keuangan` VALUES ('2', null, '100.00', '0.00', '2021-04-07 22:43:01');
INSERT INTO `t_jurnal_keuangan` VALUES ('4', null, '0.00', '10.00', '2021-04-07 22:48:20');
INSERT INTO `t_jurnal_keuangan` VALUES ('5', null, '0.00', '10.00', '2021-04-07 22:48:31');
INSERT INTO `t_jurnal_keuangan` VALUES ('6', null, '1.00', '0.00', '2021-04-07 22:48:49');

-- ----------------------------
-- Table structure for t_user_endpoint
-- ----------------------------
DROP TABLE IF EXISTS `t_user_endpoint`;
CREATE TABLE `t_user_endpoint` (
  `tue_id` int(22) NOT NULL AUTO_INCREMENT,
  `tue_ip` varchar(75) NOT NULL,
  `tue_id_login` varchar(11) DEFAULT '0',
  `tue_endpoint` longtext,
  PRIMARY KEY (`tue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_user_endpoint
-- ----------------------------
INSERT INTO `t_user_endpoint` VALUES ('9', '8926d376-9656-4942-82a0-145ce3262eb9', '0', '{\"endpoint\":\"https://fcm.googleapis.com/fcm/send/dlrfzTlwERY:APA91bHBfq0S9QwFgXC_7BbSi3c61PtOb687tAEAlHi5k39XexEwTZtDsSnmuYM5OTex2WL7MNcm7LKPCEzIdV4AIaagAKnf-jQWZbw6Zi_aVm1suY3vwWdBpGUEKB5-kjgWkKlpJ5bF\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BCJdHlOxkhZjXXXQJZ1EprYpw-rP9Kb6y5p4glVB6ZB51UN3Uol-_w5KtpXv82ZkNKgX5EU6WrVyjeDRKKlaMUs\",\"auth\":\"xWQ87COB5PLiIsoR1ZNw7g\"}}');
INSERT INTO `t_user_endpoint` VALUES ('10', 'fb386e80-c20f-4c14-9c05-16c069ea9390', '0', '{\"endpoint\":\"https://fcm.googleapis.com/fcm/send/dSi3LVhVJSM:APA91bHNM7kEvSEU6eF7li5S5MovvZWG0MBanArphrYd26GYSwYgrTCRIhXTXDYCUVl9-DofgFrsxrB-dYftB3lWNuhfwBLRkQrrV1hI7lsEvVam1aDHp9ws_l4ZUbnqWzwJDHaJhOho\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BOd6G9SlnGqrMILGFHWut1RD6JV5jIFXoXFz8RliC2R8PjNg3g-z0p9TN5KrIT5tqh9ZD4YN_HsFDWNo1brgfAw\",\"auth\":\"0ndzI8m_3dD3RGJ_EiCJOw\"}}');
INSERT INTO `t_user_endpoint` VALUES ('11', 'e90c474e-d70b-4975-953f-873940e77272', '0', '{\"endpoint\":\"https://fcm.googleapis.com/fcm/send/cREzv9WlkS0:APA91bHOh9n19JSIICbYGaX53ZmO4wCyXqLdk7zODJ4bCtQ6MKBLzgCdYzYnln2TZ1Cp-E9EHmNqw2-XF0Iif398FmZx1fjQWRcB89O0qed8gB2ETPaUxy0LLaHrXpmsa5IsfB2SauSo\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BDs4453C_Nt4pHCT4mRP0ZNWq3m7EfF3D2wDlzVOx9fnzbt3j-QVWA8iPyXDeAg-ntRVJkA98rE7lX3Dzg2bOdU\",\"auth\":\"OBCLF2E1iZPlMwdMn4sEWw\"}}');
INSERT INTO `t_user_endpoint` VALUES ('12', 'e90c474e-d70b-4975-953f-873940e77272', '0', '{\"endpoint\":\"https://fcm.googleapis.com/fcm/send/cREzv9WlkS0:APA91bHOh9n19JSIICbYGaX53ZmO4wCyXqLdk7zODJ4bCtQ6MKBLzgCdYzYnln2TZ1Cp-E9EHmNqw2-XF0Iif398FmZx1fjQWRcB89O0qed8gB2ETPaUxy0LLaHrXpmsa5IsfB2SauSo\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BDs4453C_Nt4pHCT4mRP0ZNWq3m7EfF3D2wDlzVOx9fnzbt3j-QVWA8iPyXDeAg-ntRVJkA98rE7lX3Dzg2bOdU\",\"auth\":\"OBCLF2E1iZPlMwdMn4sEWw\"}}');
