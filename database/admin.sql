/*
@zhoushuai
@Navicat MySQL Data Transfer
Date: 2014-07-22 10:25:37
@邻售后台--数据
*/
SET FOREIGN_KEY_CHECKS=0;

/*
-- ----------------------------
-- Table structure for bi_admin#管理员表
-- ----------------------------
DROP TABLE IF EXISTS `bi_admin`;
CREATE TABLE `bi_admin` (
  `id_admin` int(10) NOT NULL AUTO_INCREMENT,
  `id_profile` smallint(6) NOT NULL DEFAULT '0',
  `realname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL COMMENT '部门',
  `comment` varchar(500) NOT NULL COMMENT '备注',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_time` timestamp NULL DEFAULT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of bi_admin
-- ----------------------------
INSERT INTO `bi_admin` VALUES ('1', '1', '周帅', 'zhoushuai', 'eb44809a276a33e7eccfb2bfec24a4bc', '123456', '超级管理员', '2014-07-22 17:07:55', '2014-07-22 17:07:55');
*/



/*
-- ----------------------------
-- Table structure for bi_profile
-- ----------------------------
DROP TABLE IF EXISTS `bi_profile`;
CREATE TABLE `bi_profile` (
  `id_profile` int(10) NOT NULL AUTO_INCREMENT,
  `role` enum('admin','common') NOT NULL DEFAULT 'common',
  `name` varchar(128) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_profile`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bi_profile
-- ----------------------------
INSERT INTO `bi_profile` VALUES ('1', 'admin', '超级管理员', '2014-10-15 23:24:27');
*/





-- ----------------------------
-- Table structure for bi_profile_right
-- ----------------------------
DROP TABLE IF EXISTS `bi_profile_right`;
CREATE TABLE `bi_profile_right` (
  `id_profile_right` int(10) NOT NULL AUTO_INCREMENT,
  `id_profile` smallint(6) NOT NULL DEFAULT '0',
  `id_right` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_profile_right`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='管理员角色权限关系';
-- ----------------------------
-- Records of bi_profile_right
-- ----------------------------
INSERT INTO `bi_profile_right` VALUES ('1', '1', '7');
INSERT INTO `bi_profile_right` VALUES ('2', '1', '8');
INSERT INTO `bi_profile_right` VALUES ('3', '1', '9');
INSERT INTO `bi_profile_right` VALUES ('4', '1', '10');
INSERT INTO `bi_profile_right` VALUES ('5', '1', '11');
INSERT INTO `bi_profile_right` VALUES ('6', '1', '12');
INSERT INTO `bi_profile_right` VALUES ('7', '1', '13');
INSERT INTO `bi_profile_right` VALUES ('8', '1', '14');
INSERT INTO `bi_profile_right` VALUES ('9', '1', '15');
INSERT INTO `bi_profile_right` VALUES ('10', '1', '16');
INSERT INTO `bi_profile_right` VALUES ('11', '1', '18');
INSERT INTO `bi_profile_right` VALUES ('12', '1', '19');
INSERT INTO `bi_profile_right` VALUES ('13', '1', '20');

-- ----------------------------
-- Table structure for bi_right
-- ----------------------------
DROP TABLE IF EXISTS `bi_right`;
CREATE TABLE `bi_right` (
  `id_right` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` varchar(100) NOT NULL,
  `id_parent` smallint(6) NOT NULL,
  `id_roue` varchar(150) DEFAULT NULL,
  `roue_char` varchar(150) DEFAULT NULL,
  `orders` smallint(6) NOT NULL,
  `menu_url` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_right`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='后台权限';
-- ----------------------------
-- Records of bi_right
-- ----------------------------
INSERT INTO `bi_right` VALUES ('1', '商品管理', '0', '0:1', '商品管理', '1', null, 'icon-bookmark-empty');
INSERT INTO `bi_right` VALUES ('2', '商户管理', '0', '0:2', '商户管理', '2', null, 'icon-merchant');
INSERT INTO `bi_right` VALUES ('3', '订单管理', '0', '0:3', '订单管理', '3', null, 'icon-order');
INSERT INTO `bi_right` VALUES ('4', '财务管理', '0', '0:4', '财务管理', '4', null, 'icon-finance');
INSERT INTO `bi_right` VALUES ('5', 'APP管理', '0', '0:5', 'APP管理', '5', null, 'icon-gift');
INSERT INTO `bi_right` VALUES ('6', '权限管理', '0', '0:6', '权限管理', '6', null, 'icon-right');
INSERT INTO `bi_right` VALUES ('7', '商品审核', '1', '0:1:7', '商品管理|商品审核', '1', 'commodity', null);
INSERT INTO `bi_right` VALUES ('8', '商户查询', '2', '0:2:8', '商户管理|商户查询', '1', 'merchant', null);
INSERT INTO `bi_right` VALUES ('9', '版本管理', '5', '0:5:9', 'APP管理|版本管理', '1', 'app', null);
INSERT INTO `bi_right` VALUES ('10', '角色管理', '6', '0:6:10', '权限管理|角色管理', '1', 'profile', null);
INSERT INTO `bi_right` VALUES ('11', '账号管理', '6', '0:6:11', '权限管理|账号管理', '2', 'accounts', null);
INSERT INTO `bi_right` VALUES ('12', '订单处理', '3', '0:3:12', '订单管理|订单处理', '1', 'order', null);
INSERT INTO `bi_right` VALUES ('13', '订单审核', '3', '0:3:13', '订单管理|订单审核', '2', 'order/review', null);
INSERT INTO `bi_right` VALUES ('14', '财务处理', '4', '0:4:14', '财务管理|财务处理', '1', 'finance', null);
INSERT INTO `bi_right` VALUES ('15', '商户权限', '2', '0:2:15', '商户管理|商户权限', '2', 'permissions', null);
INSERT INTO `bi_right` VALUES ('16', '功能管理', '6', '0:6:16', '权限管理|功能管理', '3', 'right', '');
INSERT INTO `bi_right` VALUES ('17', '专题管理', '0', '0:17', '专题管理', '7', '', 'icon-theme');
INSERT INTO `bi_right` VALUES ('18', '专题列表', '17', '0:17:18', '专题管理|专题列表', '1', 'theme', '');
INSERT INTO `bi_right` VALUES ('19', '新增或修改专题', '17', '0:17:19', '专题管理|新增或修改专题', '2', 'theme/add', '');
INSERT INTO `bi_right` VALUES ('20', '标签管理', '1', '0:1:20', '商品管理|标签管理', '2', 'tag', '');



