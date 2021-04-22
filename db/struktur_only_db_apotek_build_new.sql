/*
Navicat MySQL Data Transfer

Source Server         : Localhost PHP 7
Source Server Version : 100137
Source Host           : localhost:3307
Source Database       : db_apotek_build

Target Server Type    : MYSQL
Target Server Version : 100137
File Encoding         : 65001

Date: 2021-04-22 13:03:02
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
) ENGINE=InnoDB AUTO_INCREMENT=3883 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
  `tb_status_kadaluarsa` int(11) DEFAULT '0' COMMENT '0 = Tidak kadaluarsa , 1 = Kadaluarsa',
  PRIMARY KEY (`tb_id`),
  KEY `m_obat` (`tb_mo_id`),
  KEY `m_supplier` (`tb_ms_id`),
  CONSTRAINT `m_obat` FOREIGN KEY (`tb_mo_id`) REFERENCES `m_obat` (`mo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `m_supplier` FOREIGN KEY (`tb_ms_id`) REFERENCES `m_supplier` (`ms_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
  `tj_keterangan` varchar(255) DEFAULT NULL,
  `tj_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tj_id`),
  KEY `tj_m_obat` (`tj_mo_id`),
  KEY `tj_t_batch` (`tj_tb_id`),
  CONSTRAINT `tj_m_obat` FOREIGN KEY (`tj_mo_id`) REFERENCES `m_obat` (`mo_id`) ON UPDATE NO ACTION,
  CONSTRAINT `tj_t_batch` FOREIGN KEY (`tj_tb_id`) REFERENCES `t_batch` (`tb_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
