/*
@邻售V2.0
@zhoushuai
Date: 2014-11-12 11:02:37
Source Database       : bb
@Navicat MySQL Data Transfer
Target Server Type    : MYSQL
*/

SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `bi_cowry_info` ADD COLUMN `like`  int(10) NOT NULL DEFAULT 0 AFTER `created`;

-- ----------------------------
-- Table structure for bi_cowry_zan
-- ----------------------------
DROP TABLE IF EXISTS `bi_cowry_zan`;
CREATE TABLE `bi_cowry_zan` (
  `id_zan` int(10) NOT NULL AUTO_INCREMENT,
  `id_cowry` int(10) NOT NULL,
  `id_2buser` int(10) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_zan`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



