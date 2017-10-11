/*
 Navicat Premium Data Transfer

 Source Server         : homestead_localhost
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : 127.0.0.1
 Source Database       : hong_cms

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : utf-8

 Date: 10/12/2017 02:38:53 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `loginlog`
-- ----------------------------
DROP TABLE IF EXISTS `loginlog`;
CREATE TABLE `loginlog` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(30) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `logtime` int(11) DEFAULT NULL,
  `get_param` varchar(512) DEFAULT NULL,
  `post_param` varchar(1024) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `message` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `loginlog`
-- ----------------------------
BEGIN;
INSERT INTO `loginlog` VALUES ('1', null, '192.168.10.1', '1', 'Chrome - 61.0.3163.100', '1507743168', '[]', '{\"account\":\"conna45\",\"password\":\"123456\",\"captcha\":\"dkls\"}', 'Macintosh', null), ('2', null, '192.168.10.1', '1', 'Chrome - 61.0.3163.100', '1507744360', '[]', '{\"account\":\"conna45\",\"password\":\"\",\"captcha\":\"dkls\"}', 'Macintosh', null), ('3', 'conna45', '192.168.10.1', '1', 'Chrome - 61.0.3163.100', '1507744429', '[]', '{\"account\":\"conna45\",\"password\":\"\",\"captcha\":\"dkls\"}', 'Macintosh', null), ('4', 'conna45', '192.168.10.1', '1', 'Chrome - 61.0.3163.100', '1507746056', '[]', '{\"account\":\"conna45\",\"password\":\"\",\"captcha\":\"dkls\"}', 'Macintosh', '非法访问'), ('5', 'conna45', '192.168.10.1', '1', 'Chrome - 61.0.3163.100', '1507746772', '[]', '{\"account\":\"conna45\",\"password\":\"\",\"captcha\":\"dkls\"}', 'Macintosh', '登录成功'), ('6', 'conna45', '192.168.10.1', '0', 'Chrome - 61.0.3163.100', '1507746783', '[]', '{\"account\":\"conna45\",\"password\":\"1234564\",\"captcha\":\"dkls\"}', 'Macintosh', '登录失败，账号或密码错误'), ('7', 'conna45', '192.168.10.1', '1', 'Chrome - 61.0.3163.100', '1507746794', '[]', '{\"account\":\"conna45\",\"password\":\"\",\"captcha\":\"dkls\"}', 'Macintosh', '登录成功'), ('8', null, '192.168.10.1', '0', 'Safari - 10.1', '1507746827', '[]', '[]', 'Macintosh', '非法访问'), ('9', null, '192.168.10.1', '0', 'Safari - 10.1', '1507746832', '[]', '[]', 'Macintosh', '非法访问');
COMMIT;

-- ----------------------------
--  Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(128) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `islog` int(11) DEFAULT NULL,
  `optype` varchar(1) DEFAULT NULL,
  `deep` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(128) DEFAULT NULL,
  `role_des` varchar(512) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `role_menu`
-- ----------------------------
DROP TABLE IF EXISTS `role_menu`;
CREATE TABLE `role_menu` (
  `rmid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `syslog`
-- ----------------------------
DROP TABLE IF EXISTS `syslog`;
CREATE TABLE `syslog` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(5000) DEFAULT NULL,
  `optype` int(11) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `account` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `get_param` varchar(512) DEFAULT NULL,
  `post_param` varchar(5000) DEFAULT NULL,
  `log_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sysuer_role`
-- ----------------------------
DROP TABLE IF EXISTS `sysuer_role`;
CREATE TABLE `sysuer_role` (
  `srid` int(11) NOT NULL AUTO_INCREMENT,
  `suid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  PRIMARY KEY (`srid`),
  UNIQUE KEY `unique_auth` (`suid`,`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sysuser`
-- ----------------------------
DROP TABLE IF EXISTS `sysuser`;
CREATE TABLE `sysuser` (
  `suid` int(11) NOT NULL AUTO_INCREMENT COMMENT '系统用户主键',
  `account` varchar(20) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `mobile_phone` varchar(11) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `last_loginip` varchar(15) DEFAULT NULL,
  `last_logintime` int(11) DEFAULT NULL,
  `login_count` int(11) DEFAULT NULL,
  `is_super_admin` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`suid`),
  UNIQUE KEY `unique_account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `sysuser`
-- ----------------------------
BEGIN;
INSERT INTO `sysuser` VALUES ('3', 'conna45', 'hong', '$2y$12$Q5jfjLiwMxzZY7Qx8jC4ZenlrRMtAINEL3A6peMM4y4zzb7rALDcm', null, null, '1506438516', '192.168.10.1', '1507746949', '69', '1', null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
