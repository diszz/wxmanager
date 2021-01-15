/*
Navicat MySQL Data Transfer

Source Server         : 123.56.74.123
Source Server Version : 50547
Source Host           : 123.56.74.123:3306
Source Database       : wxmanager

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-10-18 18:04:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `password` varchar(30) NOT NULL,
  `is_superadmin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '超级管理员,0非1是',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0',
  `last_login_ip` char(15) NOT NULL DEFAULT '',
  `last_login_device` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin@admin.com', '111111', '1', '1476774557', '124.205.25.38', '', '0');
INSERT INTO `admin` VALUES ('2', 'test@test.com', '123456', '0', '1458373777', '', '', '0');

-- ----------------------------
-- Table structure for admin_site
-- ----------------------------
DROP TABLE IF EXISTS `admin_site`;
CREATE TABLE `admin_site` (
  `admin_site_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_site
-- ----------------------------
INSERT INTO `admin_site` VALUES ('7', '2', '1');
INSERT INTO `admin_site` VALUES ('8', '2', '2');
INSERT INTO `admin_site` VALUES ('9', '2', '6');
INSERT INTO `admin_site` VALUES ('10', '2', '8');
INSERT INTO `admin_site` VALUES ('11', '2', '9');

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章表',
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `post_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '外部帖子id,如discuz',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '态状,0正常',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `is_redirect` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否跳转链接,0非,1是,值放到url中',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `favorite_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢数',
  `author` varchar(60) NOT NULL DEFAULT '' COMMENT '作者',
  `author_avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '作者头像',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`article_id`),
  KEY `post_id` (`site_id`,`post_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '1', '1', '0', '1111111111111111111111', '', '0', '0', '', '', '0', '0', '0', '0', '', '', '2014', '2014');
INSERT INTO `article` VALUES ('2', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('3', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('4', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('5', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('6', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('7', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('8', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('9', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('10', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('11', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('12', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('13', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('14', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('15', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('16', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('17', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('18', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('19', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('20', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('21', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('22', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('23', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('24', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('25', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('26', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('27', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('28', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('29', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('30', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('31', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('32', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('33', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('34', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('35', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('36', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('37', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('38', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('39', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('40', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('41', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('42', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('43', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('44', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('45', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('46', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('47', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('48', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('49', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('50', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('51', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('52', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('53', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('54', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('55', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('56', '1', '6', '1277491', '【英雄】《我叫MT全3D》V0.5.0版本——治疗篇（沐丝）', 'http://bbs.locojoy.com/data/attachment/block/8e/8e96c5b5137f5020d7cd8193ab3f9979.jpg', '0', '0', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277491&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('57', '1', '6', '1282277', '《我叫MT全3D》新手攻略大全终极篇', 'http://bbs.locojoy.com/data/attachment/block/ba/ba3c73f0da3761dedf3ec5f4e3453ef6.jpg', '0', '0', '发现有些小伙伴有些地方不明白，浪费了很多资源。为了更好的引导各位新手楼主整合分析', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1282277&from=portal', '0', '0', '0', '0', '死神LEE', '', '0', '0');
INSERT INTO `article` VALUES ('58', '1', '6', '1265207', '【心得】《我叫MT全3D》关于属性取舍（宝石插法），金币，浮', 'http://bbs.locojoy.com/data/attachment/block/03/035c365ed2201b4c808d4a871ff7f294.jpg', '0', '0', '一.金币金币=战力，这个没有任何异议，楼主地下城没断过，还是严重缺金币中。来源', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1265207&from=portal', '0', '0', '0', '0', 'cosaqp', '', '0', '0');
INSERT INTO `article` VALUES ('59', '1', '6', '1265502', '【英雄本】《我叫MT全3D》完整版英雄本攻略', 'http://bbs.locojoy.com/data/attachment/block/6f/6f2eafab476273123fc391cee934eec0.jpg', '0', '0', '还有问题可以加群讨论，群号在图片水印里', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1265502&from=portal', '0', '0', '0', '0', 'lchope', '', '0', '0');
INSERT INTO `article` VALUES ('60', '1', '6', '1265749', '【英雄本】《我叫MT全3D》英雄本 最详细攻略（精）', 'http://bbs.locojoy.com/data/attachment/block/d4/d4ccfb37c2d57f13a16ec5ecbda49231.jpg', '0', '0', '荣耀 守护荣耀 王城QQ群：495283416欢迎进群讨论', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1265749&from=portal', '0', '0', '0', '0', 'gboy3370226', '', '0', '0');
INSERT INTO `article` VALUES ('61', '1', '6', '1279438', '【竞猜】猜猜我的首字母 到底是什么？（已开奖）', 'http://bbs.locojoy.com/data/attachment/block/91/9128cab96b336aaf2f2b498129ee8066.jpg', '0', '0', '中国汉语博大精深，小小的几个首字母即可表达不同的意思哦！【活动时间】2月24日~', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1279438&from=portal', '0', '0', '0', '0', 'wscn312', '', '0', '0');
INSERT INTO `article` VALUES ('62', '1', '6', '1259850', '【称号】《我叫MT全3D》称号大全', 'http://bbs.locojoy.com/data/attachment/block/c5/c54e020b99326628bbe26256fd61d806.jpg', '0', '0', '', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1259850&from=portal', '0', '0', '0', '0', '死神LEE', '', '0', '0');
INSERT INTO `article` VALUES ('63', '1', '6', '1265510', '【百科】《我叫MT全3D》游戏攻略数据库', 'http://bbs.locojoy.com/data/attachment/block/96/96845a5673339b333675e22c6ad5b0e3.jpg', '0', '0', '[/td][/tr][/table][/td][/tr][/table][/td][/tr][/table][/td', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1265510&from=portal', '0', '0', '0', '0', '死神LEE', '', '0', '0');
INSERT INTO `article` VALUES ('64', '1', '6', '1271170', '[世界杯] 《我叫MT全3D》0.4.0版本世界杯的防守技巧', 'http://bbs.locojoy.com/data/attachment/block/30/30ae6b5a421ee5b3fb44142a82cdc532.jpg', '0', '0', '首先0.4.0版本的竞技场出手BUG还没有修复，看到很多同学们都还不明白怎么对付这个BUG', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1271170&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('65', '1', '6', '1282594', '未来版本工会阵容，属性大亮点，全员大暴走', 'http://bbs.locojoy.com/data/attachment/block/ec/ec890be40029519a42ebbdcb049bc421.jpg', '0', '0', '前言:这篇才是经过修改过的。之前发的那篇是春节那会写的，资料很不完善。 [/backcolo', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1282594&from=portal', '0', '0', '0', '0', 'wx_HQg8ZKBq', '', '0', '0');
INSERT INTO `article` VALUES ('66', '1', '6', '1282047', '【女神节】春暖花开，爱要大声说出来', 'http://bbs.locojoy.com/data/attachment/block/c6/c6325026c3c4f0c1fa375e8824e9347a.jpg', '0', '0', '女神虐我千百遍，我待女神如初恋！MT的女神们陪我们一年又一年，春暖花开，爱要大声说', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1282047&from=portal', '0', '0', '0', '0', '天堂灬陨落', '', '0', '0');
INSERT INTO `article` VALUES ('67', '1', '6', '1280596', '【心得】《我叫MT全3D》后期玩法篇（附推测预算准备方案）', 'http://bbs.locojoy.com/data/attachment/block/06/068fed770f6a7ad59ef34c7b8ff2b2d4.jpg', '0', '0', '副本的开荒只是后期游戏的一小部分，后期发展更多的是在于思路上，如何才能做到先人一', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1280596&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('68', '1', '6', '1281541', '【英雄】《我叫MT全3D》V0.5.0版本——群体输出篇（羞', 'http://bbs.locojoy.com/data/attachment/block/8f/8fa71af7828bfab3d3b8dc89df2ebe61.jpg', '0', '0', '今天介绍的是四暗影中的大美眉，全能攻击手——羞花。羞花是个人认为目前两位四暗', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1281541&from=portal', '0', '0', '0', '0', '啪啪酱', '', '0', '0');
INSERT INTO `article` VALUES ('69', '1', '6', '1266300', '【通关】《我叫MT全3D》新版 1-150塔攻略篇', 'http://bbs.locojoy.com/data/attachment/block/31/3140b0003957eed989c5150fa8d2f271.jpg', '0', '0', '荣耀 守护荣耀 王城QQ群：495283416塔我早过了，这只是我写出来的大概，以前写', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1266300&from=portal', '0', '0', '0', '0', 'gboy3370226', '', '0', '0');
INSERT INTO `article` VALUES ('70', '1', '6', '1267826', '[英雄本] 《我叫MT全3D》英雄本攻略（遗迹~灰塔上）', 'http://bbs.locojoy.com/data/attachment/block/65/65514f54dff71b82b114ecde5b5c9c71.jpg', '0', '0', '今天刚打到灰塔上，除了将军还没过，全部3星。现整理攻略如下，希望版主能够加精。D', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1267826&from=portal', '1', '0', '0', '0', '龙腾九霄', '', '0', '0');
INSERT INTO `article` VALUES ('71', '1', '1', '0', '222222222', '', '0', '0', '66666666666', 'http://wx.locojoy.com/wap/article/detail/71', '0', '0', '0', '0', '', '', '0', '0');
INSERT INTO `article` VALUES ('72', '1', '6', '1253598', '【心得】《我叫MT全3D》平民最佳副本阵容配置 普通精英3星', 'http://bbs.locojoy.com/data/attachment/block/7a/7ade5813efb1c3e78211dfdac9a27eed.jpg', '0', '0', '我叫MT3D英雄选择多种多样，自然可以搭配出各种不同的阵容，一个绝佳的阵容配置可以', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1253598&from=portal', '1', '0', '0', '0', '死神LEE', '', '0', '0');
INSERT INTO `article` VALUES ('73', '1', '6', '1277560', '【英雄本】《我叫MT全3D》哇啦攻略-新三本地狱之路（无年兽', 'http://bbs.locojoy.com/data/attachment/block/ec/ecd8e44dde6f93c6e7efe0d1401e5a54.jpg', '0', '0', '', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1277560&from=portal', '1', '0', '0', '0', '哇啦哇啦3887', '', '0', '0');
INSERT INTO `article` VALUES ('74', '1', '6', '1367378', '【文字】奇葩队名展创意，才华盖过宋仲基', 'http://bbs.locojoy.com/data/attachment/forum/201603/18/085654c1pmnipppwqncm1v.png', '0', '0', '评审规则：创意奖：由官方评选最有创意的回帖获得幸运奖：由官方随机抽取获得', 'http://bbs.locojoy.com/forum.php?mod=viewthread&tid=1367378&from=portal', '1', '0', '0', '0', 'wscn312', '', '0', '0');

-- ----------------------------
-- Table structure for article_attribute
-- ----------------------------
DROP TABLE IF EXISTS `article_attribute`;
CREATE TABLE `article_attribute` (
  `article_attribute_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动ID',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`article_attribute_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article_attribute
-- ----------------------------
INSERT INTO `article_attribute` VALUES ('4', '1', '他走了，只留下一双鞋子。一双残旧的鞋子，鞋面皱巴巴的，充满沧桑感，像极了老人的脸······\r\n\r\n这是她送给他的第一份礼物。\r\n\r\n在郊外一个景色优美的小商店里，她邂逅了这双鞋子。小商店有一位美丽的老板娘，小巧的嘴微微地向上弯着，似在笑，却给人一种忧郁的心疼。\r\n\r\n在买这双鞋子的时候，老板娘随意地对她说：“送鞋子给他，是要他离开你。”她想起传言，男女朋友之间送鞋子，最后一定会分开。她是个唯物主义者，从不相信这类传言，也从不关注星座与命运的联系。她对老板娘笑了笑，说：“他的鞋子坏了。”\r\n\r\n递给了她鞋子。老板娘盯着她，两只眼睛如巨大的漩涡，似要把她吸进去。一股寒意袭向她，身上的毛孔慢慢地闭紧了嘴巴，使她忍不住打了个冷战。她赶紧转身离开。穿过玻璃门的时候，她听到了一句话，“你会后悔的······”这句话似乎是从遥远的地方传来的，如水滴渗入泥土般进入她的耳膜。一道光射到玻璃门上，门口的一切，如梦如幻······\r\n\r\n这双鞋子，带着他，和她，穿梭于城市的每一个角落。走过的地方，留下了他们欢快的笑声，还有甜蜜的回忆。快乐让他们忘记了一切，包括时间。鞋底，在大街小巷平地陡坡上一点点磨损消失，鞋面上的皱纹一天天明显······\r\n\r\n那个傍晚，残阳如血，那么红，那么烫，她觉得那是从她的心中流出来的。她抱着那双鞋子，坐在柔软的草地上，心在滴血。\r\n\r\n他走了，留下这双鞋子，留给她无尽的沧桑。\r\n\r\n“后悔了吧？”微风轻轻吹过，一声悠远的叹息渗进她的心中。她抱起鞋子飞奔起来，风在她的耳边哭泣，晚霞更红了······\r\n   又一次来到那个郊外，眼前的一切却让她迷惘。“大叔，这里的鞋店呢？哪里去了？”她抱着鞋子，微微地喘着气，问坐在一棵大树下的白发叔叔。白发叔叔惊讶地抬起头，说：“奇怪啊！这哪来的鞋店啊？我都在这附近住了几十年了，没见过这儿有鞋店啊。你们发生啥事啦？你已经是第十六个来这儿找鞋店的姑娘了······”');
INSERT INTO `article_attribute` VALUES ('5', '2', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('6', '3', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('7', '4', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('8', '5', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('9', '6', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('10', '7', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('11', '8', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('12', '9', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('13', '10', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('14', '11', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('15', '12', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('16', '13', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('17', '14', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('18', '15', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('19', '16', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('20', '17', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('21', '18', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('22', '19', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('23', '20', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('24', '21', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('25', '22', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('26', '23', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('27', '24', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('28', '25', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('29', '26', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('30', '27', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('31', '28', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('32', '29', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('33', '30', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('34', '31', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('35', '32', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('36', '33', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('37', '34', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('38', '35', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('39', '36', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('40', '37', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('41', '38', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('42', '39', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('43', '40', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('44', '41', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('45', '42', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('46', '43', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('47', '44', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('48', '45', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('49', '46', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('50', '47', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('51', '48', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('52', '49', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('53', '50', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('54', '51', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('55', '52', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('56', '53', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('57', '54', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('58', '55', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('59', '56', '今天说的是我最喜欢的软妹子——沐丝永远都跟在MT的身后，温柔的喊道：哀');
INSERT INTO `article_attribute` VALUES ('60', '57', '发现有些小伙伴有些地方不明白，浪费了很多资源。为了更好的引导各位新手楼主整合分析');
INSERT INTO `article_attribute` VALUES ('61', '58', '一.金币金币=战力，这个没有任何异议，楼主地下城没断过，还是严重缺金币中。来源');
INSERT INTO `article_attribute` VALUES ('62', '59', '还有问题可以加群讨论，群号在图片水印里');
INSERT INTO `article_attribute` VALUES ('63', '60', '荣耀 守护荣耀 王城QQ群：495283416欢迎进群讨论');
INSERT INTO `article_attribute` VALUES ('64', '61', '中国汉语博大精深，小小的几个首字母即可表达不同的意思哦！【活动时间】2月24日~');
INSERT INTO `article_attribute` VALUES ('65', '62', '');
INSERT INTO `article_attribute` VALUES ('66', '63', '[/td][/tr][/table][/td][/tr][/table][/td][/tr][/table][/td');
INSERT INTO `article_attribute` VALUES ('67', '64', '首先0.4.0版本的竞技场出手BUG还没有修复，看到很多同学们都还不明白怎么对付这个BUG');
INSERT INTO `article_attribute` VALUES ('68', '65', '前言:这篇才是经过修改过的。之前发的那篇是春节那会写的，资料很不完善。 [/backcolo');
INSERT INTO `article_attribute` VALUES ('69', '66', '女神虐我千百遍，我待女神如初恋！MT的女神们陪我们一年又一年，春暖花开，爱要大声说');
INSERT INTO `article_attribute` VALUES ('70', '67', '副本的开荒只是后期游戏的一小部分，后期发展更多的是在于思路上，如何才能做到先人一');
INSERT INTO `article_attribute` VALUES ('71', '68', '今天介绍的是四暗影中的大美眉，全能攻击手——羞花。羞花是个人认为目前两位四暗');
INSERT INTO `article_attribute` VALUES ('72', '69', '荣耀 守护荣耀 王城QQ群：495283416塔我早过了，这只是我写出来的大概，以前写');
INSERT INTO `article_attribute` VALUES ('73', '70', '今天刚打到灰塔上，除了将军还没过，全部3星。现整理攻略如下，希望版主能够加精。D');
INSERT INTO `article_attribute` VALUES ('74', '71', '22222222222');
INSERT INTO `article_attribute` VALUES ('75', '72', '我叫MT3D英雄选择多种多样，自然可以搭配出各种不同的阵容，一个绝佳的阵容配置可以');
INSERT INTO `article_attribute` VALUES ('76', '73', '');
INSERT INTO `article_attribute` VALUES ('77', '74', '评审规则：创意奖：由官方评选最有创意的回帖获得幸运奖：由官方随机抽取获得');

-- ----------------------------
-- Table structure for article_category
-- ----------------------------
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章分类表',
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `article_count` int(11) unsigned NOT NULL DEFAULT '0',
  `bbs_source_url` varchar(255) NOT NULL DEFAULT '' COMMENT '对应discuz地址',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article_category
-- ----------------------------
INSERT INTO `article_category` VALUES ('1', '1', '分类1', '0', '0', '0', '0', '', '0');
INSERT INTO `article_category` VALUES ('2', '1', '1111', '0', '0', '1', '0', '', '2014');
INSERT INTO `article_category` VALUES ('3', '1', 'HammerHead', '0', '0', '0', '0', '', '2015');
INSERT INTO `article_category` VALUES ('4', '1', 'Carpenter', '0', '0', '0', '0', '', '2015');
INSERT INTO `article_category` VALUES ('5', '1', 'McWorks', '0', '0', '0', '0', '', '2015');
INSERT INTO `article_category` VALUES ('6', '1', '来自discuz', '0', '0', '0', '0', 'http://bbs.locojoy.com/api.php?mod=js&bid=102', '2015');

-- ----------------------------
-- Table structure for article_column
-- ----------------------------
DROP TABLE IF EXISTS `article_column`;
CREATE TABLE `article_column` (
  `article_column_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `article_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '栏目下文章统计数',
  PRIMARY KEY (`article_column_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章标志位表';

-- ----------------------------
-- Records of article_column
-- ----------------------------
INSERT INTO `article_column` VALUES ('1', '置顶', '0');

-- ----------------------------
-- Table structure for article_comment
-- ----------------------------
DROP TABLE IF EXISTS `article_comment`;
CREATE TABLE `article_comment` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论表',
  `article_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `reply_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复ID',
  `reply_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复数',
  `favorite_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点赞',
  `content` text NOT NULL COMMENT '内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article_comment
-- ----------------------------
INSERT INTO `article_comment` VALUES ('1', '1', '1', '0', '0', '0', '1111111', '2014', '0');
INSERT INTO `article_comment` VALUES ('2', '1', '1', '0', '0', '0', '', '2014', '0');

-- ----------------------------
-- Table structure for article_to_column
-- ----------------------------
DROP TABLE IF EXISTS `article_to_column`;
CREATE TABLE `article_to_column` (
  `article_to_column_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) unsigned NOT NULL DEFAULT '0',
  `article_column_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_to_column_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章-标志位-关系表';

-- ----------------------------
-- Records of article_to_column
-- ----------------------------

-- ----------------------------
-- Table structure for client_record
-- ----------------------------
DROP TABLE IF EXISTS `client_record`;
CREATE TABLE `client_record` (
  `client_record_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(60) NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT '',
  `keyword` varchar(60) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`client_record_id`),
  KEY `site_id` (`site_id`,`create_time`,`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='客户端记录表';

-- ----------------------------
-- Records of client_record
-- ----------------------------
INSERT INTO `client_record` VALUES ('1', '1', '0', 'text', '人', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1458376920\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"人\";s:5:\"MsgId\";s:19:\"6263681177046453000\";}', '1458376920');
INSERT INTO `client_record` VALUES ('2', '1', '0', 'text', '1', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1458376925\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"1\";s:5:\"MsgId\";s:19:\"6263681198521289482\";}', '1458376925');
INSERT INTO `client_record` VALUES ('3', '1', '0', 'text', '1', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1458377035\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"1\";s:5:\"MsgId\";s:19:\"6263681670967692067\";}', '1458377035');
INSERT INTO `client_record` VALUES ('4', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '1', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1458377117\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"1\";s:5:\"MsgId\";s:19:\"6263682023155010356\";}', '1458377117');
INSERT INTO `client_record` VALUES ('5', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '去', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1472716840\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"去\";s:5:\"MsgId\";s:19:\"6325270664486726409\";}', '1472716840');
INSERT INTO `client_record` VALUES ('6', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '额', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1472717148\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"额\";s:5:\"MsgId\";s:19:\"6325271987336653648\";}', '1472717148');
INSERT INTO `client_record` VALUES ('7', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '额', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1474598801\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"额\";s:5:\"MsgId\";s:19:\"6333353625434413554\";}', '1474598802');
INSERT INTO `client_record` VALUES ('8', '1', 'o2j3wjpD7tp94TUtz81Ld57f5tuA', 'event', '', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjpD7tp94TUtz81Ld57f5tuA\";s:10:\"CreateTime\";s:10:\"1475588331\";s:7:\"MsgType\";s:5:\"event\";s:5:\"Event\";s:11:\"unsubscribe\";s:8:\"EventKey\";s:0:\"\";}', '1475588331');
INSERT INTO `client_record` VALUES ('9', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '去', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476779668\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"去\";s:5:\"MsgId\";s:19:\"6342720377876669502\";}', '1476779669');
INSERT INTO `client_record` VALUES ('10', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '去', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476779794\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"去\";s:5:\"MsgId\";s:19:\"6342720919042548833\";}', '1476779794');
INSERT INTO `client_record` VALUES ('11', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '1', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476779809\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"1\";s:5:\"MsgId\";s:19:\"6342720983467058279\";}', '1476779809');
INSERT INTO `client_record` VALUES ('12', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476779818\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342721022121763945\";}', '1476779818');
INSERT INTO `client_record` VALUES ('13', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780207\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342722692864042185\";}', '1476780207');
INSERT INTO `client_record` VALUES ('14', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '我去', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780214\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:6:\"我去\";s:5:\"MsgId\";s:19:\"6342722722928813259\";}', '1476780214');
INSERT INTO `client_record` VALUES ('15', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '我去', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780295\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:6:\"我去\";s:5:\"MsgId\";s:19:\"6342723070821164258\";}', '1476780295');
INSERT INTO `client_record` VALUES ('16', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780309\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342723130950706411\";}', '1476780309');
INSERT INTO `client_record` VALUES ('17', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780731\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342724943426905427\";}', '1476780731');
INSERT INTO `client_record` VALUES ('18', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780741\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342724986376578389\";}', '1476780741');
INSERT INTO `client_record` VALUES ('19', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780908\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342725703636116885\";}', '1476780908');
INSERT INTO `client_record` VALUES ('20', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476780911\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342725716521018775\";}', '1476780911');
INSERT INTO `client_record` VALUES ('21', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781238\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342727120975324704\";}', '1476781239');
INSERT INTO `client_record` VALUES ('22', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781423\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342727915544274566\";}', '1476781423');
INSERT INTO `client_record` VALUES ('23', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781425\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342727924134209162\";}', '1476781426');
INSERT INTO `client_record` VALUES ('24', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '菜单', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781431\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:6:\"菜单\";s:5:\"MsgId\";s:19:\"6342727949904012942\";}', '1476781432');
INSERT INTO `client_record` VALUES ('25', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '3', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781492\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"3\";s:5:\"MsgId\";s:19:\"6342728211897018056\";}', '1476781492');
INSERT INTO `client_record` VALUES ('26', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781500\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342728246256756426\";}', '1476781500');
INSERT INTO `client_record` VALUES ('27', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '3', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781502\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"3\";s:5:\"MsgId\";s:19:\"6342728254846691020\";}', '1476781502');
INSERT INTO `client_record` VALUES ('28', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '鸡丁', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476781947\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:6:\"鸡丁\";s:5:\"MsgId\";s:19:\"6342730166107137976\";}', '1476781947');
INSERT INTO `client_record` VALUES ('29', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '额', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476782114\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"额\";s:5:\"MsgId\";s:19:\"6342730883366676454\";}', '1476782114');
INSERT INTO `client_record` VALUES ('30', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476782118\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342730900546545644\";}', '1476782118');
INSERT INTO `client_record` VALUES ('31', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '1', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476782120\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"1\";s:5:\"MsgId\";s:19:\"6342730909136480239\";}', '1476782120');
INSERT INTO `client_record` VALUES ('32', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476782123\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342730922021382129\";}', '1476782123');
INSERT INTO `client_record` VALUES ('33', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '3', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476782126\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"3\";s:5:\"MsgId\";s:19:\"6342730934906284020\";}', '1476782126');
INSERT INTO `client_record` VALUES ('34', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476782137\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342730982150924281\";}', '1476782137');
INSERT INTO `client_record` VALUES ('35', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '我', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783625\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:3:\"我\";s:5:\"MsgId\";s:19:\"6342737373062261228\";}', '1476783625');
INSERT INTO `client_record` VALUES ('36', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783632\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342737403127032303\";}', '1476783632');
INSERT INTO `client_record` VALUES ('37', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783641\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342737441781737969\";}', '1476783641');
INSERT INTO `client_record` VALUES ('38', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783734\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342737841213696526\";}', '1476783735');
INSERT INTO `client_record` VALUES ('39', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783737\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342737854098598416\";}', '1476783737');
INSERT INTO `client_record` VALUES ('40', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783739\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342737862688533011\";}', '1476783739');
INSERT INTO `client_record` VALUES ('41', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783931\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342738687322253893\";}', '1476783931');
INSERT INTO `client_record` VALUES ('42', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '3', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783936\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"3\";s:5:\"MsgId\";s:19:\"6342738708797090376\";}', '1476783936');
INSERT INTO `client_record` VALUES ('43', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '4', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783938\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"4\";s:5:\"MsgId\";s:19:\"6342738717387024971\";}', '1476783939');
INSERT INTO `client_record` VALUES ('44', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '1', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783942\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"1\";s:5:\"MsgId\";s:19:\"6342738734566894160\";}', '1476783943');
INSERT INTO `client_record` VALUES ('45', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783945\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342738747451796051\";}', '1476783945');
INSERT INTO `client_record` VALUES ('46', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '2', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783949\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"2\";s:5:\"MsgId\";s:19:\"6342738764631665237\";}', '1476783949');
INSERT INTO `client_record` VALUES ('47', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '3', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783951\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"3\";s:5:\"MsgId\";s:19:\"6342738773221599831\";}', '1476783951');
INSERT INTO `client_record` VALUES ('48', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '1', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476783953\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:1:\"1\";s:5:\"MsgId\";s:19:\"6342738781811534426\";}', '1476783954');
INSERT INTO `client_record` VALUES ('49', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '鸡丁', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476784817\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:6:\"鸡丁\";s:5:\"MsgId\";s:19:\"6342742492663278438\";}', '1476784817');
INSERT INTO `client_record` VALUES ('50', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', 'text', '鸡丁', 'a:6:{s:10:\"ToUserName\";s:15:\"gh_60da4b4a2a07\";s:12:\"FromUserName\";s:28:\"o2j3wjlsOyxHlLYsRDHVE4_jY1L8\";s:10:\"CreateTime\";s:10:\"1476784932\";s:7:\"MsgType\";s:4:\"text\";s:7:\"Content\";s:6:\"鸡丁\";s:5:\"MsgId\";s:19:\"6342742986584517516\";}', '1476784932');

-- ----------------------------
-- Table structure for code
-- ----------------------------
DROP TABLE IF EXISTS `code`;
CREATE TABLE `code` (
  `code_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `total_count` int(11) unsigned NOT NULL DEFAULT '0',
  `send_count` int(11) unsigned NOT NULL DEFAULT '0',
  `cycle_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '周期',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='活动码表';

-- ----------------------------
-- Records of code
-- ----------------------------
INSERT INTO `code` VALUES ('3', '1', '1111', '102', '3', '0', '0');
INSERT INTO `code` VALUES ('4', '1', '222', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for code_item
-- ----------------------------
DROP TABLE IF EXISTS `code_item`;
CREATE TABLE `code_item` (
  `code_item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code_id` int(11) unsigned NOT NULL DEFAULT '0',
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `content` varchar(60) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态,0未使用,1已使用',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`code_item_id`),
  KEY `site_id` (`site_id`,`status`,`code_id`),
  KEY `site_id_2` (`site_id`,`code_id`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COMMENT='活动码子项表';

-- ----------------------------
-- Records of code_item
-- ----------------------------
INSERT INTO `code_item` VALUES ('9', '3', '1', 'Szh3HZEf9', '0', '1458450968');
INSERT INTO `code_item` VALUES ('10', '3', '1', 'gyoO0NZGZ', '0', '1458450968');
INSERT INTO `code_item` VALUES ('11', '3', '1', 'kdzp7pB9H', '0', '1458450968');
INSERT INTO `code_item` VALUES ('12', '3', '1', 'YwqcodzZc', '0', '1458450969');
INSERT INTO `code_item` VALUES ('13', '3', '1', 'nSJRm70RU', '0', '1458450969');
INSERT INTO `code_item` VALUES ('14', '3', '1', 'N4wj7xYPA', '0', '1458450969');
INSERT INTO `code_item` VALUES ('15', '3', '1', 'YYORfYd0j', '0', '1458450970');
INSERT INTO `code_item` VALUES ('16', '3', '1', 'NZjsUWcB1', '0', '1458450970');
INSERT INTO `code_item` VALUES ('17', '3', '1', 'GcA5yyP55', '0', '1458450970');
INSERT INTO `code_item` VALUES ('18', '3', '1', 'nSJLzcugg', '0', '1458450971');
INSERT INTO `code_item` VALUES ('19', '3', '1', 'WGQ6Hh3Go', '0', '1458450971');
INSERT INTO `code_item` VALUES ('20', '3', '1', 'Kk8XRdM8w', '0', '1458450971');
INSERT INTO `code_item` VALUES ('21', '3', '1', 'cTeu95f9D', '0', '1458450972');
INSERT INTO `code_item` VALUES ('22', '3', '1', 'jLaNCY2HD', '0', '1458450972');
INSERT INTO `code_item` VALUES ('23', '3', '1', 'YYORWrYrT', '0', '1458450972');
INSERT INTO `code_item` VALUES ('24', '3', '1', 'htc2IhE38', '0', '1458450972');
INSERT INTO `code_item` VALUES ('25', '3', '1', 'URfQqc2X8', '0', '1458450973');
INSERT INTO `code_item` VALUES ('26', '3', '1', 'pfVwuaTgK', '0', '1458450973');
INSERT INTO `code_item` VALUES ('27', '3', '1', 'X9eFeLQjF', '0', '1458450973');
INSERT INTO `code_item` VALUES ('28', '3', '1', 'LHkFRkdNp', '0', '1458450974');
INSERT INTO `code_item` VALUES ('29', '3', '1', 'kFXUBijCs', '0', '1458450974');
INSERT INTO `code_item` VALUES ('30', '3', '1', 'pfVvqTWLa', '0', '1458450974');
INSERT INTO `code_item` VALUES ('31', '3', '1', 'uKG9f81AN', '0', '1458450974');
INSERT INTO `code_item` VALUES ('32', '3', '1', 'jLaQEcPLf', '0', '1458450974');
INSERT INTO `code_item` VALUES ('33', '3', '1', 'WerpY4E9g', '0', '1458450974');
INSERT INTO `code_item` VALUES ('34', '3', '1', 'JplY2SGXY', '0', '1458450974');
INSERT INTO `code_item` VALUES ('35', '3', '1', 'tnupg7pmv', '0', '1458450974');
INSERT INTO `code_item` VALUES ('36', '3', '1', 'dO1v8L0bJ', '0', '1458450974');
INSERT INTO `code_item` VALUES ('37', '3', '1', 'w7RNn2oco', '0', '1458450974');
INSERT INTO `code_item` VALUES ('38', '3', '1', 'dlD1dRqve', '0', '1458450974');
INSERT INTO `code_item` VALUES ('39', '3', '1', 'VjEoifGo0', '0', '1458450974');
INSERT INTO `code_item` VALUES ('40', '3', '1', 'qaIyoZFjH', '0', '1458450974');
INSERT INTO `code_item` VALUES ('41', '3', '1', 'FKbq9rcem', '0', '1458450974');
INSERT INTO `code_item` VALUES ('42', '3', '1', 'NZjpbIuRA', '0', '1458450974');
INSERT INTO `code_item` VALUES ('43', '3', '1', 'QhijzgsP9', '0', '1458450974');
INSERT INTO `code_item` VALUES ('44', '3', '1', 'X9ezkJ4m7', '0', '1458450974');
INSERT INTO `code_item` VALUES ('45', '3', '1', 'sV5ShJjLK', '0', '1458450974');
INSERT INTO `code_item` VALUES ('46', '3', '1', 'GEYBDpL8g', '0', '1458450974');
INSERT INTO `code_item` VALUES ('47', '3', '1', 'Szh3DHcZT', '0', '1458450974');
INSERT INTO `code_item` VALUES ('48', '3', '1', 'EmZIL5DQF', '0', '1458450974');
INSERT INTO `code_item` VALUES ('49', '3', '1', 'H7na3Oou2', '0', '1458450974');
INSERT INTO `code_item` VALUES ('50', '3', '1', 'Rc5qTHXlI', '0', '1458450974');
INSERT INTO `code_item` VALUES ('51', '3', '1', 'egq5rEsjJ', '0', '1458450974');
INSERT INTO `code_item` VALUES ('52', '3', '1', 'QhidENfWD', '0', '1458450974');
INSERT INTO `code_item` VALUES ('53', '3', '1', 'UoRcTLpiM', '0', '1458450974');
INSERT INTO `code_item` VALUES ('54', '3', '1', 'POTKQToMx', '0', '1458450974');
INSERT INTO `code_item` VALUES ('55', '3', '1', 'zkDEoKN2V', '0', '1458450974');
INSERT INTO `code_item` VALUES ('56', '3', '1', 'T1FC35kb8', '0', '1458450974');
INSERT INTO `code_item` VALUES ('57', '3', '1', 'OrI2wfUVk', '0', '1458450974');
INSERT INTO `code_item` VALUES ('58', '3', '1', 'sV5Pofnpp', '0', '1458450974');
INSERT INTO `code_item` VALUES ('59', '3', '1', 'bYrosK6qn', '0', '1458450974');
INSERT INTO `code_item` VALUES ('60', '3', '1', 'POTGZOY9e', '0', '1458450974');
INSERT INTO `code_item` VALUES ('61', '3', '1', 'tnusX8KmN', '0', '1458450974');
INSERT INTO `code_item` VALUES ('62', '3', '1', 'iQnDC1nLo', '0', '1458450974');
INSERT INTO `code_item` VALUES ('63', '3', '1', 'ol8igGrtc', '0', '1458450974');
INSERT INTO `code_item` VALUES ('64', '3', '1', 'YwqefW95R', '0', '1458450974');
INSERT INTO `code_item` VALUES ('65', '3', '1', 'vd4Iu23FB', '0', '1458450974');
INSERT INTO `code_item` VALUES ('66', '3', '1', 'Szh49LE2s', '0', '1458450974');
INSERT INTO `code_item` VALUES ('67', '3', '1', 'AHPjcL0gF', '0', '1458450974');
INSERT INTO `code_item` VALUES ('68', '3', '1', 'IWXjNl4cO', '0', '1458450974');
INSERT INTO `code_item` VALUES ('69', '3', '1', 'LHkJTICOe', '0', '1458450974');
INSERT INTO `code_item` VALUES ('70', '3', '1', 'jiMb2W2Lp', '0', '1458450974');
INSERT INTO `code_item` VALUES ('71', '3', '1', 'CZO7VAzgo', '0', '1458450974');
INSERT INTO `code_item` VALUES ('72', '3', '1', 'EmZPOhyYc', '0', '1458450974');
INSERT INTO `code_item` VALUES ('73', '3', '1', 'TWsG83D0N', '0', '1458450974');
INSERT INTO `code_item` VALUES ('74', '3', '1', 'rxUikzyaq', '0', '1458450974');
INSERT INTO `code_item` VALUES ('75', '3', '1', 's0iL0V94y', '0', '1458450974');
INSERT INTO `code_item` VALUES ('76', '3', '1', 'LHkHGWind', '0', '1458450974');
INSERT INTO `code_item` VALUES ('77', '3', '1', 'lAKXFod6w', '0', '1458450974');
INSERT INTO `code_item` VALUES ('78', '3', '1', 'T1FEKlueB', '0', '1458450974');
INSERT INTO `code_item` VALUES ('79', '3', '1', 'tnuoV1XYt', '0', '1458450974');
INSERT INTO `code_item` VALUES ('80', '3', '1', 'qD79uUCYW', '0', '1458450974');
INSERT INTO `code_item` VALUES ('81', '3', '1', 'XBDarc1cv', '0', '1458450974');
INSERT INTO `code_item` VALUES ('82', '3', '1', 'dO1CbCMC7', '0', '1458450974');
INSERT INTO `code_item` VALUES ('83', '3', '1', 'kdzn9CEZS', '0', '1458450974');
INSERT INTO `code_item` VALUES ('84', '3', '1', 'N4wlLzzVH', '0', '1458450974');
INSERT INTO `code_item` VALUES ('85', '3', '1', 'LHkCCXQv4', '0', '1458450974');
INSERT INTO `code_item` VALUES ('86', '3', '1', 'rxUfJh2X4', '0', '1458450974');
INSERT INTO `code_item` VALUES ('87', '3', '1', 'ZrdqwU7sr', '0', '1458450974');
INSERT INTO `code_item` VALUES ('88', '3', '1', 'ySfaZplhC', '0', '1458450974');
INSERT INTO `code_item` VALUES ('89', '3', '1', 'LeWcwdRaF', '0', '1458450974');
INSERT INTO `code_item` VALUES ('90', '3', '1', 'POTHgQeNc', '0', '1458450974');
INSERT INTO `code_item` VALUES ('91', '3', '1', 'cqPURmf19', '0', '1458450974');
INSERT INTO `code_item` VALUES ('92', '3', '1', 'YYOKq7ICU', '0', '1458450974');
INSERT INTO `code_item` VALUES ('93', '3', '1', 'aBfDSyga8', '0', '1458450974');
INSERT INTO `code_item` VALUES ('94', '3', '1', 'KMxzh40Hb', '0', '1458450974');
INSERT INTO `code_item` VALUES ('95', '3', '1', 'XBDbs4Qzs', '0', '1458450974');
INSERT INTO `code_item` VALUES ('96', '3', '1', 'DscEuH4r5', '0', '1458450974');
INSERT INTO `code_item` VALUES ('97', '3', '1', 'fbddNqtba', '0', '1458450974');
INSERT INTO `code_item` VALUES ('98', '3', '1', 'Tu46YwKvL', '0', '1458450974');
INSERT INTO `code_item` VALUES ('99', '3', '1', 'ol8jeVDaa', '0', '1458450974');
INSERT INTO `code_item` VALUES ('100', '3', '1', 'qaIuF8WeL', '0', '1458450974');
INSERT INTO `code_item` VALUES ('101', '3', '1', 'Kk91pCyAI', '0', '1458450974');
INSERT INTO `code_item` VALUES ('102', '3', '1', 'MC7QRnMiV', '0', '1458450974');
INSERT INTO `code_item` VALUES ('103', '3', '1', 'm39z6eXPn', '0', '1458450974');
INSERT INTO `code_item` VALUES ('104', '3', '1', 'GEYy1pKX4', '0', '1458450974');
INSERT INTO `code_item` VALUES ('105', '3', '1', 'BCCr1UaTB', '0', '1458450974');
INSERT INTO `code_item` VALUES ('106', '3', '1', 'IuyJ5hzVe', '0', '1458450974');
INSERT INTO `code_item` VALUES ('107', '3', '1', 'mvya20XEl', '0', '1458450974');
INSERT INTO `code_item` VALUES ('108', '3', '1', 'xv3nRRchs', '0', '1458450974');
INSERT INTO `code_item` VALUES ('109', '3', '1', 'vDjB7IIjx', '0', '1458451725');
INSERT INTO `code_item` VALUES ('110', '3', '1', 'wP2mLAcFX', '0', '1458451725');
INSERT INTO `code_item` VALUES ('111', '3', '1', 'tfVuuMATI', '0', '1458451725');
INSERT INTO `code_item` VALUES ('112', '3', '1', 's5gKDGrfT', '0', '1458451725');
INSERT INTO `code_item` VALUES ('113', '3', '1', 'Ar5eA8EWt', '0', '1458451725');

-- ----------------------------
-- Table structure for code_record
-- ----------------------------
DROP TABLE IF EXISTS `code_record`;
CREATE TABLE `code_record` (
  `code_record_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(30) NOT NULL DEFAULT '',
  `code_id` int(11) unsigned NOT NULL DEFAULT '0',
  `code_item_id` int(11) unsigned NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL DEFAULT '',
  `code_send_result` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `code_send_reason` text NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`code_record_id`),
  KEY `soc` (`site_id`,`openid`,`code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='活动码记录表';

-- ----------------------------
-- Records of code_record
-- ----------------------------
INSERT INTO `code_record` VALUES ('1', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', '3', '3', '252542', '1', '3', '140.207.54.78', '1458263524');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品表',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(60) NOT NULL COMMENT '商品名',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '商品状态',
  `price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `amount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '剩余量',
  `amount_sell` int(11) unsigned NOT NULL COMMENT '售出量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问量',
  `online_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上架时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods
-- ----------------------------

-- ----------------------------
-- Table structure for goods_attribute
-- ----------------------------
DROP TABLE IF EXISTS `goods_attribute`;
CREATE TABLE `goods_attribute` (
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods_attribute
-- ----------------------------
INSERT INTO `goods_attribute` VALUES ('1', '他走了，只留下一双鞋子。一双残旧的鞋子，鞋面皱巴巴的，充满沧桑感，像极了老人的脸······\r\n\r\n这是她送给他的第一份礼物。\r\n\r\n在郊外一个景色优美的小商店里，她邂逅了这双鞋子。小商店有一位美丽的老板娘，小巧的嘴微微地向上弯着，似在笑，却给人一种忧郁的心疼。\r\n\r\n在买这双鞋子的时候，老板娘随意地对她说：“送鞋子给他，是要他离开你。”她想起传言，男女朋友之间送鞋子，最后一定会分开。她是个唯物主义者，从不相信这类传言，也从不关注星座与命运的联系。她对老板娘笑了笑，说：“他的鞋子坏了。”\r\n\r\n递给了她鞋子。老板娘盯着她，两只眼睛如巨大的漩涡，似要把她吸进去。一股寒意袭向她，身上的毛孔慢慢地闭紧了嘴巴，使她忍不住打了个冷战。她赶紧转身离开。穿过玻璃门的时候，她听到了一句话，“你会后悔的······”这句话似乎是从遥远的地方传来的，如水滴渗入泥土般进入她的耳膜。一道光射到玻璃门上，门口的一切，如梦如幻······\r\n\r\n这双鞋子，带着他，和她，穿梭于城市的每一个角落。走过的地方，留下了他们欢快的笑声，还有甜蜜的回忆。快乐让他们忘记了一切，包括时间。鞋底，在大街小巷平地陡坡上一点点磨损消失，鞋面上的皱纹一天天明显······\r\n\r\n那个傍晚，残阳如血，那么红，那么烫，她觉得那是从她的心中流出来的。她抱着那双鞋子，坐在柔软的草地上，心在滴血。\r\n\r\n他走了，留下这双鞋子，留给她无尽的沧桑。\r\n\r\n“后悔了吧？”微风轻轻吹过，一声悠远的叹息渗进她的心中。她抱起鞋子飞奔起来，风在她的耳边哭泣，晚霞更红了······\r\n   又一次来到那个郊外，眼前的一切却让她迷惘。“大叔，这里的鞋店呢？哪里去了？”她抱着鞋子，微微地喘着气，问坐在一棵大树下的白发叔叔。白发叔叔惊讶地抬起头，说：“奇怪啊！这哪来的鞋店啊？我都在这附近住了几十年了，没见过这儿有鞋店啊。你们发生啥事啦？你已经是第十六个来这儿找鞋店的姑娘了······”');

-- ----------------------------
-- Table structure for goods_category
-- ----------------------------
DROP TABLE IF EXISTS `goods_category`;
CREATE TABLE `goods_category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品分类表',
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `article_count` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods_category
-- ----------------------------
INSERT INTO `goods_category` VALUES ('1', '1', '分类1', '0', '0', '0', '0', '0');
INSERT INTO `goods_category` VALUES ('2', '3', '1111', '0', '0', '1', '0', '2014');

-- ----------------------------
-- Table structure for goods_comment
-- ----------------------------
DROP TABLE IF EXISTS `goods_comment`;
CREATE TABLE `goods_comment` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论表',
  `article_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `reply_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复ID',
  `reply_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复数',
  `favorite_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点赞',
  `content` text NOT NULL COMMENT '内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods_comment
-- ----------------------------
INSERT INTO `goods_comment` VALUES ('1', '1', '1', '0', '0', '0', '1111111', '2014', '0');
INSERT INTO `goods_comment` VALUES ('2', '1', '1', '0', '0', '0', '', '2014', '0');

-- ----------------------------
-- Table structure for keyword
-- ----------------------------
DROP TABLE IF EXISTS `keyword`;
CREATE TABLE `keyword` (
  `keyword_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '关键词',
  `type` enum('text','image','voice','video','music','news') NOT NULL DEFAULT 'text',
  `content` varchar(255) NOT NULL DEFAULT '',
  `object` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '挂载对象,0word,1relation,2code,3signin,4lottery,5article,6文章分类',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '挂载对象ID',
  `object_config` text NOT NULL COMMENT '配置',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `relation_count` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword_id`),
  KEY `word` (`site_id`,`content`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='关键词表';

-- ----------------------------
-- Records of keyword
-- ----------------------------
INSERT INTO `keyword` VALUES ('1', '1', '网站', 'text', '您好, 我们的网站是{url}.', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('9', '1', '红烧茄子', 'text', '红烧茄子红烧茄子', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('12', '1', 'hi', 'text', '您好, 使用愉快', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('13', '0', '扫描关注', 'text', '感谢您的关注', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('14', '0', '欢迎语', 'text', '您好, 我们是xxx,祝您身体健康.', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('15', '2', 'qq', 'text', 'qqqqqqqq', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('16', '2', 'ww', 'text', 'hello{code|1011}', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('18', '2', '22', 'text', '22', '3', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('20', '2', '22', 'text', '22222', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('21', '2', '222', 'text', '22', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('22', '2', '222', 'text', '222', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('28', '1', '宫保鸡丁 鸡丁', 'text', '宫保鸡丁是汉族传统经典的名菜，鲁菜和川菜都有该道菜的做法，但是用料有所差别。创始人为贵州织金人丁宝桢，在任山东巡抚时创制该菜，后任四川总督时加以改良，流传至今。此道菜也被归纳为北京宫廷菜。', '0', '0', 'a:1:{s:5:\"count\";s:1:\"5\";}', '0', '0', '0');
INSERT INTO `keyword` VALUES ('29', '1', '红烧排骨', 'text', '红烧排骨，家常菜。此菜味道香咸，排骨酥烂，色泽金红。一般人都可食用。适宜于 气血不足，阴虚纳差者；湿热痰滞内蕴者慎服；肥胖、血脂较高者不宜多食', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('30', '2', '景区', 'text', '北京的景区', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('31', '2', '圆明园', 'text', '圆明园圆明园圆明园', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('32', '2', '颐和园', 'text', '颐和园颐和园颐和园颐和园', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('34', '9', '11', 'text', '1111', '1', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('35', '9', '22', 'text', '222', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('36', '9', '22', 'text', '222', '2', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('37', '9', '21', 'text', '222', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('38', '9', '21', 'text', '222', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('39', '9', '44', 'text', '44', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('40', '9', '1212礼包', 'text', '礼包码是:', '3', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('41', '1', '红包', 'text', '红包11111111222', '7', '1', 'a:1:{s:5:\"count\";s:1:\"5\";}', '0', '1', '0');
INSERT INTO `keyword` VALUES ('45', '1', '礼包 礼包码是{},哈哈哈', 'text', '礼包 礼包码是{},哈哈哈', '0', '0', '', '0', '0', '0');
INSERT INTO `keyword` VALUES ('46', '1', '礼包', 'text', '您的礼包码是{},哈哈哈哈哈!@!@!', '2', '3', 'a:1:{s:5:\"count\";s:1:\"5\";}', '0', '0', '0');
INSERT INTO `keyword` VALUES ('47', '1', '签到1 签名二', 'text', '', '3', '1', 'a:1:{s:5:\"count\";s:1:\"5\";}', '0', '0', '1458281772');

-- ----------------------------
-- Table structure for keyword_alias
-- ----------------------------
DROP TABLE IF EXISTS `keyword_alias`;
CREATE TABLE `keyword_alias` (
  `keyword_alias_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '关键词',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword_alias_id`),
  KEY `word` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 COMMENT='关键词别名表';

-- ----------------------------
-- Records of keyword_alias
-- ----------------------------
INSERT INTO `keyword_alias` VALUES ('48', '1', '1', '网站', '0');
INSERT INTO `keyword_alias` VALUES ('51', '9', '1', '红烧茄子', '0');
INSERT INTO `keyword_alias` VALUES ('53', '12', '1', 'hi', '0');
INSERT INTO `keyword_alias` VALUES ('54', '13', '0', '扫描关注', '0');
INSERT INTO `keyword_alias` VALUES ('55', '14', '0', '欢迎语', '0');
INSERT INTO `keyword_alias` VALUES ('64', '29', '1', '红烧排骨', '0');
INSERT INTO `keyword_alias` VALUES ('65', '30', '2', '景区', '0');
INSERT INTO `keyword_alias` VALUES ('66', '31', '2', '圆明园', '0');
INSERT INTO `keyword_alias` VALUES ('67', '32', '2', '颐和园', '0');
INSERT INTO `keyword_alias` VALUES ('74', '40', '9', '1212礼包', '0');
INSERT INTO `keyword_alias` VALUES ('75', '41', '1', '红包', '0');
INSERT INTO `keyword_alias` VALUES ('79', '45', '1', '礼包 礼包码是{},哈哈哈', '0');
INSERT INTO `keyword_alias` VALUES ('80', '46', '1', '礼包', '0');
INSERT INTO `keyword_alias` VALUES ('97', '48', '1', '景区', '0');
INSERT INTO `keyword_alias` VALUES ('103', '5', '1', '菜单', '5');
INSERT INTO `keyword_alias` VALUES ('106', '47', '1', '签到1', '0');
INSERT INTO `keyword_alias` VALUES ('107', '47', '1', '签名二', '0');
INSERT INTO `keyword_alias` VALUES ('108', '28', '1', '宫保鸡丁', '0');
INSERT INTO `keyword_alias` VALUES ('109', '28', '1', '鸡丁', '0');
INSERT INTO `keyword_alias` VALUES ('110', '3', '1', '资讯', '9');

-- ----------------------------
-- Table structure for keyword_relation
-- ----------------------------
DROP TABLE IF EXISTS `keyword_relation`;
CREATE TABLE `keyword_relation` (
  `keyword_relation_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword_id` int(11) unsigned NOT NULL DEFAULT '0',
  `child_keyword_id` int(11) unsigned NOT NULL,
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword_relation_id`),
  KEY `keyword_id` (`keyword_id`,`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COMMENT='关键词关系表';

-- ----------------------------
-- Records of keyword_relation
-- ----------------------------
INSERT INTO `keyword_relation` VALUES ('2', '19', '21', '0');
INSERT INTO `keyword_relation` VALUES ('3', '19', '22', '0');
INSERT INTO `keyword_relation` VALUES ('9', '30', '31', '0');
INSERT INTO `keyword_relation` VALUES ('10', '30', '32', '0');
INSERT INTO `keyword_relation` VALUES ('11', '36', '38', '1');
INSERT INTO `keyword_relation` VALUES ('12', '36', '39', '4');
INSERT INTO `keyword_relation` VALUES ('13', '36', '40', '4');
INSERT INTO `keyword_relation` VALUES ('35', '41', '10', '0');
INSERT INTO `keyword_relation` VALUES ('66', '5', '28', '0');
INSERT INTO `keyword_relation` VALUES ('67', '5', '29', '0');
INSERT INTO `keyword_relation` VALUES ('68', '5', '9', '0');

-- ----------------------------
-- Table structure for location
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `location_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `openid` varchar(60) NOT NULL DEFAULT '',
  `latitude` varchar(30) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  `precision` varchar(30) NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of location
-- ----------------------------

-- ----------------------------
-- Table structure for lottery
-- ----------------------------
DROP TABLE IF EXISTS `lottery`;
CREATE TABLE `lottery` (
  `lottery_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL DEFAULT '',
  `odds` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '中奖概率,0-100',
  `code_id` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lottery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖表';

-- ----------------------------
-- Records of lottery
-- ----------------------------

-- ----------------------------
-- Table structure for lottery_user
-- ----------------------------
DROP TABLE IF EXISTS `lottery_user`;
CREATE TABLE `lottery_user` (
  `lottery_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lottery_id` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(30) NOT NULL DEFAULT '',
  `total_count` int(11) unsigned NOT NULL DEFAULT '0',
  `keep_count` int(11) unsigned NOT NULL DEFAULT '0',
  `last_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lottery_user_id`),
  KEY `wco` (`site_id`,`lottery_id`,`openid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖用户表';

-- ----------------------------
-- Records of lottery_user
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` enum('click','link') NOT NULL DEFAULT 'click',
  `child_count` int(11) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='微信菜单表';

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '1', '微官网', 'http://company.weifans.diszz.com/wap/oauth/1', '0', 'link', '0', '0', '0');
INSERT INTO `menu` VALUES ('2', '1', '功能', 'q', '0', 'click', '1', '0', '0');
INSERT INTO `menu` VALUES ('14', '1', '123', '12313123123', '1', 'link', '0', '0', '0');
INSERT INTO `menu` VALUES ('10', '1', '地址', '地址', '2', 'click', '0', '0', '0');
INSERT INTO `menu` VALUES ('11', '1', '1111', 'http://www.baidu.com/111111111', '2', 'link', '0', '0', '0');
INSERT INTO `menu` VALUES ('13', '2', '11111', 'qq', '0', 'click', '0', '0', '0');
INSERT INTO `menu` VALUES ('15', '11', '123', '123123', '0', 'link', '0', '0', '0');

-- ----------------------------
-- Table structure for money
-- ----------------------------
DROP TABLE IF EXISTS `money`;
CREATE TABLE `money` (
  `money_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户资金表',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `balance` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`money_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of money
-- ----------------------------

-- ----------------------------
-- Table structure for money_record
-- ----------------------------
DROP TABLE IF EXISTS `money_record`;
CREATE TABLE `money_record` (
  `money_record_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金额表',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `balance` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `money` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '流动的金额,充值为正值,消费为负值',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`money_record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of money_record
-- ----------------------------

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `money` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态,未生成,已生成,已取消,已完成,已删除',
  `money_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '资金状态,未支付,已支付,已退款',
  `message` varchar(255) NOT NULL DEFAULT '' COMMENT '标注,留言',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `express_company` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '快递公司,顺风,圆通,申通,邮政,京东,其他快递',
  `express_number` varchar(60) NOT NULL DEFAULT '' COMMENT '快递号',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for order_item
-- ----------------------------
DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item` (
  `order_item_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单产品表',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价格',
  `money` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总价',
  `amount` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '产品数',
  `deal_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '处理状态',
  `deal_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`order_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_item
-- ----------------------------

-- ----------------------------
-- Table structure for place
-- ----------------------------
DROP TABLE IF EXISTS `place`;
CREATE TABLE `place` (
  `place_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '省市表',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `child` varchar(255) NOT NULL,
  `level` int(5) unsigned NOT NULL DEFAULT '1' COMMENT '层级',
  `sort` int(5) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`place_id`),
  KEY `psl` (`parent_id`,`sort`,`level`)
) ENGINE=MyISAM AUTO_INCREMENT=733 DEFAULT CHARSET=utf8 COMMENT='省市数据库';

-- ----------------------------
-- Records of place
-- ----------------------------
INSERT INTO `place` VALUES ('1', '北京市', '0', '0', '1', '1', '1');
INSERT INTO `place` VALUES ('2', '天津市', '0', '0', '1', '2', '1');
INSERT INTO `place` VALUES ('3', '上海市', '0', '0', '1', '3', '1');
INSERT INTO `place` VALUES ('4', '重庆市', '0', '0', '1', '4', '1');
INSERT INTO `place` VALUES ('5', '河北省', '0', '0', '1', '5', '1');
INSERT INTO `place` VALUES ('6', '山西省', '0', '0', '1', '6', '1');
INSERT INTO `place` VALUES ('7', '台湾省', '0', '0', '1', '7', '1');
INSERT INTO `place` VALUES ('8', '辽宁省', '0', '0', '1', '8', '1');
INSERT INTO `place` VALUES ('9', '吉林省', '0', '0', '1', '9', '1');
INSERT INTO `place` VALUES ('10', '黑龙江省', '0', '0', '1', '10', '1');
INSERT INTO `place` VALUES ('11', '江苏省', '0', '0', '1', '11', '1');
INSERT INTO `place` VALUES ('12', '浙江省', '0', '0', '1', '12', '1');
INSERT INTO `place` VALUES ('13', '安徽省', '0', '0', '1', '13', '1');
INSERT INTO `place` VALUES ('14', '福建省', '0', '0', '1', '14', '1');
INSERT INTO `place` VALUES ('15', '江西省', '0', '0', '1', '15', '1');
INSERT INTO `place` VALUES ('16', '山东省', '0', '0', '1', '16', '1');
INSERT INTO `place` VALUES ('17', '河南省', '0', '0', '1', '17', '1');
INSERT INTO `place` VALUES ('18', '湖北省', '0', '0', '1', '18', '1');
INSERT INTO `place` VALUES ('19', '湖南省', '0', '0', '1', '19', '1');
INSERT INTO `place` VALUES ('20', '广东省', '0', '0', '1', '20', '1');
INSERT INTO `place` VALUES ('21', '甘肃省', '0', '0', '1', '21', '1');
INSERT INTO `place` VALUES ('22', '四川省', '0', '0', '1', '22', '1');
INSERT INTO `place` VALUES ('23', '贵州省', '0', '0', '1', '23', '1');
INSERT INTO `place` VALUES ('24', '海南省', '0', '0', '1', '24', '1');
INSERT INTO `place` VALUES ('25', '云南省', '0', '0', '1', '25', '1');
INSERT INTO `place` VALUES ('26', '青海省', '0', '0', '1', '26', '1');
INSERT INTO `place` VALUES ('27', '陕西省', '0', '0', '1', '27', '1');
INSERT INTO `place` VALUES ('28', '广西壮族自治区', '0', '0', '1', '28', '1');
INSERT INTO `place` VALUES ('29', '西藏自治区', '0', '0', '1', '29', '1');
INSERT INTO `place` VALUES ('30', '宁夏回族自治区', '0', '0', '1', '30', '1');
INSERT INTO `place` VALUES ('31', '新疆维吾尔自治区', '0', '0', '1', '31', '1');
INSERT INTO `place` VALUES ('32', '内蒙古自治区', '0', '0', '1', '32', '1');
INSERT INTO `place` VALUES ('33', '澳门特别行政区', '0', '0', '1', '33', '1');
INSERT INTO `place` VALUES ('34', '香港特别行政区', '0', '0', '1', '34', '1');
INSERT INTO `place` VALUES ('61', '东城区', '1', '0', '2', '1', '0');
INSERT INTO `place` VALUES ('62', '西城区', '1', '0', '2', '2', '0');
INSERT INTO `place` VALUES ('63', '崇文区', '1', '0', '2', '3', '0');
INSERT INTO `place` VALUES ('64', '宣武区', '1', '0', '2', '4', '0');
INSERT INTO `place` VALUES ('65', '朝阳区', '1', '0', '2', '5', '0');
INSERT INTO `place` VALUES ('66', '丰台区', '1', '0', '2', '6', '0');
INSERT INTO `place` VALUES ('67', '石景山区', '1', '0', '2', '7', '0');
INSERT INTO `place` VALUES ('68', '海淀区', '1', '0', '2', '8', '0');
INSERT INTO `place` VALUES ('69', '门头沟区', '1', '0', '2', '9', '0');
INSERT INTO `place` VALUES ('70', '房山区', '1', '0', '2', '10', '0');
INSERT INTO `place` VALUES ('71', '通州区', '1', '0', '2', '11', '0');
INSERT INTO `place` VALUES ('72', '顺义区', '1', '0', '2', '12', '0');
INSERT INTO `place` VALUES ('73', '昌平区', '1', '0', '2', '13', '0');
INSERT INTO `place` VALUES ('74', '大兴区', '1', '0', '2', '14', '0');
INSERT INTO `place` VALUES ('75', '怀柔区', '1', '0', '2', '15', '0');
INSERT INTO `place` VALUES ('76', '平谷区', '1', '0', '2', '16', '0');
INSERT INTO `place` VALUES ('77', '延庆县', '1', '0', '2', '17', '0');
INSERT INTO `place` VALUES ('78', '密云县', '1', '0', '2', '18', '0');
INSERT INTO `place` VALUES ('101', '石家庄市', '5', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('102', '唐山市', '5', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('103', '秦皇岛市', '5', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('104', '邯郸市', '5', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('105', '邢台市', '5', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('106', '保定市', '5', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('107', '张家口市', '5', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('108', '承德市', '5', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('109', '沧州市', '5', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('110', '廊坊市', '5', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('111', '衡水市', '5', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('121', '太原市', '6', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('122', '大同市', '6', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('123', '阳泉市', '6', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('124', '长治市', '6', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('125', '晋城市', '6', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('126', '朔州市', '6', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('127', '晋中市', '6', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('128', '运城市', '6', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('129', '忻州市', '6', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('130', '临汾市', '6', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('131', '吕梁市', '6', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('141', '台北市', '7', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('142', '高雄市', '7', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('143', '基隆市', '7', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('144', '台中市', '7', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('145', '台南市', '7', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('146', '新竹市', '7', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('147', '嘉义市', '7', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('148', '台北县', '7', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('149', '宜兰县', '7', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('150', '桃园县', '7', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('151', '新竹县', '7', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('152', '苗栗县', '7', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('153', '台中县', '7', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('154', '彰化县', '7', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('155', '南投县', '7', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('156', '云林县', '7', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('157', '嘉义县', '7', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('158', '台南县', '7', '0', '2', '18', '1');
INSERT INTO `place` VALUES ('159', '高雄县', '7', '0', '2', '19', '1');
INSERT INTO `place` VALUES ('160', '屏东县', '7', '0', '2', '20', '1');
INSERT INTO `place` VALUES ('161', '澎湖县', '7', '0', '2', '21', '1');
INSERT INTO `place` VALUES ('162', '台东县', '7', '0', '2', '22', '1');
INSERT INTO `place` VALUES ('163', '花莲县', '7', '0', '2', '23', '1');
INSERT INTO `place` VALUES ('181', '沈阳市', '8', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('182', '大连市', '8', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('183', '鞍山市', '8', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('184', '抚顺市', '8', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('185', '本溪市', '8', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('186', '丹东市', '8', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('187', '锦州市', '8', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('188', '营口市', '8', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('189', '阜新市', '8', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('190', '辽阳市', '8', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('191', '盘锦市', '8', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('192', '铁岭市', '8', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('193', '朝阳市', '8', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('194', '葫芦岛市', '8', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('201', '长春市', '9', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('202', '吉林市', '9', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('203', '四平市', '9', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('204', '辽源市', '9', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('205', '通化市', '9', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('206', '白山市', '9', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('207', '松原市', '9', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('208', '白城市', '9', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('209', '延边朝鲜族自治州', '9', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('221', '哈尔滨市', '10', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('222', '齐齐哈尔市', '10', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('223', '鹤 岗 市', '10', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('224', '双鸭山市', '10', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('225', '鸡 西 市', '10', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('226', '大 庆 市', '10', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('227', '伊 春 市', '10', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('228', '牡丹江市', '10', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('229', '佳木斯市', '10', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('230', '七台河市', '10', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('231', '黑 河 市', '10', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('232', '绥 化 市', '10', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('233', '大兴安岭地区', '10', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('241', '南京市', '11', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('242', '无锡市', '11', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('243', '徐州市', '11', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('244', '常州市', '11', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('245', '苏州市', '11', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('246', '南通市', '11', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('247', '连云港市', '11', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('248', '淮安市', '11', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('249', '盐城市', '11', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('250', '扬州市', '11', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('251', '镇江市', '11', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('252', '泰州市', '11', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('253', '宿迁市', '11', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('281', '杭州市', '12', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('282', '宁波市', '12', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('283', '温州市', '12', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('284', '嘉兴市', '12', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('285', '湖州市', '12', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('286', '绍兴市', '12', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('287', '金华市', '12', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('288', '衢州市', '12', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('289', '舟山市', '12', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('290', '台州市', '12', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('291', '丽水市', '12', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('301', '合肥市', '13', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('302', '芜湖市', '13', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('303', '蚌埠市', '13', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('304', '淮南市', '13', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('305', '马鞍山市', '13', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('306', '淮北市', '13', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('307', '铜陵市', '13', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('308', '安庆市', '13', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('309', '黄山市', '13', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('310', '滁州市', '13', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('311', '阜阳市', '13', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('312', '宿州市', '13', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('313', '巢湖市', '13', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('314', '六安市', '13', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('315', '亳州市', '13', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('316', '池州市', '13', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('317', '宣城市', '13', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('321', '福州市', '14', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('322', '厦门市', '14', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('323', '莆田市', '14', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('324', '三明市', '14', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('325', '泉州市', '14', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('326', '漳州市', '14', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('327', '南平市', '14', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('328', '龙岩市', '14', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('329', '宁德市', '14', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('341', '南昌市', '15', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('342', '景德镇市', '15', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('343', '萍乡市', '15', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('344', '九江市', '15', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('345', '新余市', '15', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('346', '鹰潭市', '15', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('347', '赣州市', '15', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('348', '吉安市', '15', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('349', '宜春市', '15', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('350', '抚州市', '15', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('351', '上饶市', '15', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('361', '济南市', '16', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('362', '青岛市', '16', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('363', '淄博市', '16', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('364', '枣庄市', '16', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('365', '东营市', '16', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('366', '烟台市', '16', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('367', '潍坊市', '16', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('368', '济宁市', '16', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('369', '泰安市', '16', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('370', '威海市', '16', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('371', '日照市', '16', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('372', '莱芜市', '16', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('373', '临沂市', '16', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('374', '德州市', '16', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('375', '聊城市', '16', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('376', '滨州市', '16', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('377', '菏泽市', '16', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('401', '郑州市', '17', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('402', '开封市', '17', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('403', '洛阳市', '17', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('404', '平顶山市', '17', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('405', '安阳市', '17', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('406', '鹤壁市', '17', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('407', '新乡市', '17', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('408', '焦作市', '17', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('409', '濮阳市', '17', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('410', '许昌市', '17', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('411', '漯河市', '17', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('412', '三门峡市', '17', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('413', '南阳市', '17', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('414', '商丘市', '17', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('415', '信阳市', '17', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('416', '周口市', '17', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('417', '驻马店市', '17', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('418', '济源市', '17', '0', '2', '18', '1');
INSERT INTO `place` VALUES ('421', '武汉市', '18', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('422', '黄石市', '18', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('423', '十堰市', '18', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('424', '荆州市', '18', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('425', '宜昌市', '18', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('426', '襄樊市', '18', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('427', '鄂州市', '18', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('428', '荆门市', '18', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('429', '孝感市', '18', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('430', '黄冈市', '18', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('431', '咸宁市', '18', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('432', '随州市', '18', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('433', '仙桃市', '18', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('434', '天门市', '18', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('435', '潜江市', '18', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('436', '神农架林区', '18', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('437', '恩施土家族苗族自治州', '18', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('441', '长沙市', '19', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('442', '株洲市', '19', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('443', '湘潭市', '19', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('444', '衡阳市', '19', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('445', '邵阳市', '19', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('446', '岳阳市', '19', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('447', '常德市', '19', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('448', '张家界市', '19', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('449', '益阳市', '19', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('450', '郴州市', '19', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('451', '永州市', '19', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('452', '怀化市', '19', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('453', '娄底市', '19', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('454', '湘西土家族苗族自治州', '19', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('455', '广州市', '20', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('456', '深圳市', '20', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('457', '珠海市', '20', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('458', '汕头市', '20', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('459', '韶关市', '20', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('460', '佛山市', '20', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('461', '江门市', '20', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('462', '湛江市', '20', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('463', '茂名市', '20', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('464', '肇庆市', '20', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('465', '惠州市', '20', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('466', '梅州市', '20', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('467', '汕尾市', '20', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('468', '河源市', '20', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('469', '阳江市', '20', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('470', '清远市', '20', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('485', '东莞市', '20', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('486', '中山市', '20', '0', '2', '18', '1');
INSERT INTO `place` VALUES ('487', '潮州市', '20', '0', '2', '19', '1');
INSERT INTO `place` VALUES ('488', '揭阳市', '20', '0', '2', '20', '1');
INSERT INTO `place` VALUES ('489', '云浮市', '20', '0', '2', '21', '1');
INSERT INTO `place` VALUES ('471', '兰州市', '21', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('472', '金昌市', '21', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('473', '白银市', '21', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('474', '天水市', '21', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('475', '嘉峪关市', '21', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('476', '武威市', '21', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('477', '张掖市', '21', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('478', '平凉市', '21', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('479', '酒泉市', '21', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('480', '庆阳市', '21', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('481', '定西市', '21', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('482', '陇南市', '21', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('483', '临夏回族自治州', '21', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('484', '甘南藏族自治州', '21', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('491', '成都市', '22', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('492', '自贡市', '22', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('493', '攀枝花市', '22', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('494', '泸州市', '22', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('495', '德阳市', '22', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('496', '绵阳市', '22', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('497', '广元市', '22', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('498', '遂宁市', '22', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('499', '内江市', '22', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('500', '乐山市', '22', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('501', '南充市', '22', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('502', '眉山市', '22', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('503', '宜宾市', '22', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('504', '广安市', '22', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('505', '达州市', '22', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('506', '雅安市', '22', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('507', '巴中市', '22', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('508', '资阳市', '22', '0', '2', '18', '1');
INSERT INTO `place` VALUES ('509', '阿坝藏族羌族自治州', '22', '0', '2', '19', '1');
INSERT INTO `place` VALUES ('510', '甘孜藏族自治州', '22', '0', '2', '20', '1');
INSERT INTO `place` VALUES ('511', '凉山彝族自治州', '22', '0', '2', '21', '1');
INSERT INTO `place` VALUES ('521', '贵阳市', '23', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('522', '六盘水市', '23', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('523', '遵义市', '23', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('524', '安顺市', '23', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('525', '铜仁地区', '23', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('526', '毕节地区', '23', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('527', '黔西南布依族苗族自治州', '23', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('528', '黔东南苗族侗族自治州', '23', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('529', '黔南布依族苗族自治州', '23', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('541', '海口市', '24', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('542', '三亚市', '24', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('543', '五指山市', '24', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('544', '琼海市', '24', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('545', '儋州市', '24', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('546', '文昌市', '24', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('547', '万宁市', '24', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('548', '东方市', '24', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('549', '澄迈县', '24', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('550', '定安县', '24', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('551', '屯昌县', '24', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('552', '临高县', '24', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('553', '白沙黎族自治县', '24', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('554', '昌江黎族自治县', '24', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('555', '乐东黎族自治县', '24', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('556', '陵水黎族自治县', '24', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('557', '保亭黎族苗族自治县', '24', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('558', '琼中黎族苗族自治县', '24', '0', '2', '18', '1');
INSERT INTO `place` VALUES ('571', '昆明市', '25', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('572', '曲靖市', '25', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('573', '玉溪市', '25', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('574', '保山市', '25', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('575', '昭通市', '25', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('576', '丽江市', '25', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('577', '思茅市', '25', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('578', '临沧市', '25', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('579', '文山壮族苗族自治州', '25', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('580', '红河哈尼族彝族自治州', '25', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('581', '西双版纳傣族自治州', '25', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('582', '楚雄彝族自治州', '25', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('583', '大理白族自治州', '25', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('584', '德宏傣族景颇族自治州', '25', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('585', '怒江傈傈族自治州', '25', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('586', '迪庆藏族自治州', '25', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('601', '西宁市', '26', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('602', '海东地区', '26', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('603', '海北藏族自治州', '26', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('604', '黄南藏族自治州', '26', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('605', '海南藏族自治州', '26', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('606', '果洛藏族自治州', '26', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('607', '玉树藏族自治州', '26', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('608', '海西蒙古族藏族自治州', '26', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('621', '西安市', '27', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('622', '铜川市', '27', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('623', '宝鸡市', '27', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('624', '咸阳市', '27', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('625', '渭南市', '27', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('626', '延安市', '27', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('627', '汉中市', '27', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('628', '榆林市', '27', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('629', '安康市', '27', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('630', '商洛市', '27', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('641', '南宁市', '28', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('642', '柳州市', '28', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('643', '桂林市', '28', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('644', '梧州市', '28', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('645', '北海市', '28', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('646', '防城港市', '28', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('647', '钦州市', '28', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('648', '贵港市', '28', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('649', '玉林市', '28', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('650', '百色市', '28', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('651', '贺州市', '28', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('652', '河池市', '28', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('653', '来宾市', '28', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('654', '崇左市', '28', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('671', '拉萨市', '29', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('672', '那曲地区', '29', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('673', '昌都地区', '29', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('674', '山南地区', '29', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('675', '日喀则地区', '29', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('676', '阿里地区', '29', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('677', '林芝地区', '29', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('681', '银川市', '30', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('682', '石嘴山市', '30', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('683', '吴忠市', '30', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('684', '固原市', '30', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('685', '中卫市', '30', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('691', '乌鲁木齐市', '31', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('692', '克拉玛依市', '31', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('693', '石河子市　', '31', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('694', '阿拉尔市', '31', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('695', '图木舒克市', '31', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('696', '五家渠市', '31', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('697', '吐鲁番市', '31', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('698', '阿克苏市', '31', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('699', '喀什市', '31', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('700', '哈密市', '31', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('701', '和田市', '31', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('702', '阿图什市', '31', '0', '2', '12', '1');
INSERT INTO `place` VALUES ('703', '库尔勒市', '31', '0', '2', '13', '1');
INSERT INTO `place` VALUES ('704', '昌吉市　', '31', '0', '2', '14', '1');
INSERT INTO `place` VALUES ('705', '阜康市', '31', '0', '2', '15', '1');
INSERT INTO `place` VALUES ('706', '米泉市', '31', '0', '2', '16', '1');
INSERT INTO `place` VALUES ('707', '博乐市', '31', '0', '2', '17', '1');
INSERT INTO `place` VALUES ('708', '伊宁市', '31', '0', '2', '18', '1');
INSERT INTO `place` VALUES ('709', '奎屯市', '31', '0', '2', '19', '1');
INSERT INTO `place` VALUES ('710', '塔城市', '31', '0', '2', '20', '1');
INSERT INTO `place` VALUES ('711', '乌苏市', '31', '0', '2', '21', '1');
INSERT INTO `place` VALUES ('712', '阿勒泰市', '31', '0', '2', '22', '1');
INSERT INTO `place` VALUES ('721', '呼和浩特市', '32', '0', '2', '1', '1');
INSERT INTO `place` VALUES ('722', '包头市', '32', '0', '2', '2', '1');
INSERT INTO `place` VALUES ('723', '乌海市', '32', '0', '2', '3', '1');
INSERT INTO `place` VALUES ('724', '赤峰市', '32', '0', '2', '4', '1');
INSERT INTO `place` VALUES ('725', '通辽市', '32', '0', '2', '5', '1');
INSERT INTO `place` VALUES ('726', '鄂尔多斯市', '32', '0', '2', '6', '1');
INSERT INTO `place` VALUES ('727', '呼伦贝尔市', '32', '0', '2', '7', '1');
INSERT INTO `place` VALUES ('728', '巴彦淖尔市', '32', '0', '2', '8', '1');
INSERT INTO `place` VALUES ('729', '乌兰察布市', '32', '0', '2', '9', '1');
INSERT INTO `place` VALUES ('730', '锡林郭勒盟', '32', '0', '2', '10', '1');
INSERT INTO `place` VALUES ('731', '兴安盟', '32', '0', '2', '11', '1');
INSERT INTO `place` VALUES ('732', '阿拉善盟', '32', '0', '2', '12', '1');

-- ----------------------------
-- Table structure for redpack
-- ----------------------------
DROP TABLE IF EXISTS `redpack`;
CREATE TABLE `redpack` (
  `redpack_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `key` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态,0正常,1停用',
  `send_name` varchar(60) NOT NULL DEFAULT '' COMMENT '发放者名称',
  `wishing` varchar(60) NOT NULL DEFAULT '' COMMENT '祝福语',
  `remark` varchar(60) NOT NULL DEFAULT '' COMMENT '备注信息',
  `logo_imgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '图标地址',
  `min_value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最小金额,单位分',
  `max_value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最大金额,单位分',
  `total_people` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '总人数',
  `total_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '总金额',
  `send_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发放金额',
  `send_people` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发放人数',
  `fetch_people` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换人数',
  `fetch_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '换兑金额',
  `make_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生成金额数',
  `make_code` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生成码数',
  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `send_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发放方式,0本道渠发放,1其他渠道发放',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`redpack_id`),
  KEY `sks` (`site_id`,`key`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='红包表';

-- ----------------------------
-- Records of redpack
-- ----------------------------
INSERT INTO `redpack` VALUES ('1', '1', '11', '11111', '0', '11111', '1111', '11111', '111111111111111', '100', '200', '150', '20000', '0', '0', '0', '0', '20800', '155', '1458489600', '1458576000', '0', '0');

-- ----------------------------
-- Table structure for redpack_code
-- ----------------------------
DROP TABLE IF EXISTS `redpack_code`;
CREATE TABLE `redpack_code` (
  `redpack_code_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `redpack_id` int(11) unsigned NOT NULL DEFAULT '0',
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `content` varchar(60) NOT NULL DEFAULT '' COMMENT '码',
  `money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态,0未使用未领取,1已领取,2已使用',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`redpack_code_id`),
  KEY `srs` (`site_id`,`redpack_id`,`status`) USING BTREE,
  KEY `sc` (`site_id`,`content`)
) ENGINE=InnoDB AUTO_INCREMENT=494 DEFAULT CHARSET=utf8 COMMENT='包红码表';

-- ----------------------------
-- Records of redpack_code
-- ----------------------------
INSERT INTO `redpack_code` VALUES ('9', '3', '1', 'Szh3HZEf9', '0', '0', '1458450968');
INSERT INTO `redpack_code` VALUES ('10', '3', '1', 'gyoO0NZGZ', '0', '0', '1458450968');
INSERT INTO `redpack_code` VALUES ('11', '3', '1', 'kdzp7pB9H', '0', '0', '1458450968');
INSERT INTO `redpack_code` VALUES ('12', '3', '1', 'YwqcodzZc', '0', '0', '1458450969');
INSERT INTO `redpack_code` VALUES ('13', '3', '1', 'nSJRm70RU', '0', '0', '1458450969');
INSERT INTO `redpack_code` VALUES ('14', '3', '1', 'N4wj7xYPA', '0', '0', '1458450969');
INSERT INTO `redpack_code` VALUES ('15', '3', '1', 'YYORfYd0j', '0', '0', '1458450970');
INSERT INTO `redpack_code` VALUES ('16', '3', '1', 'NZjsUWcB1', '0', '0', '1458450970');
INSERT INTO `redpack_code` VALUES ('17', '3', '1', 'GcA5yyP55', '0', '0', '1458450970');
INSERT INTO `redpack_code` VALUES ('18', '3', '1', 'nSJLzcugg', '0', '0', '1458450971');
INSERT INTO `redpack_code` VALUES ('19', '3', '1', 'WGQ6Hh3Go', '0', '0', '1458450971');
INSERT INTO `redpack_code` VALUES ('20', '3', '1', 'Kk8XRdM8w', '0', '0', '1458450971');
INSERT INTO `redpack_code` VALUES ('21', '3', '1', 'cTeu95f9D', '0', '0', '1458450972');
INSERT INTO `redpack_code` VALUES ('22', '3', '1', 'jLaNCY2HD', '0', '0', '1458450972');
INSERT INTO `redpack_code` VALUES ('23', '3', '1', 'YYORWrYrT', '0', '0', '1458450972');
INSERT INTO `redpack_code` VALUES ('24', '3', '1', 'htc2IhE38', '0', '0', '1458450972');
INSERT INTO `redpack_code` VALUES ('25', '3', '1', 'URfQqc2X8', '0', '0', '1458450973');
INSERT INTO `redpack_code` VALUES ('26', '3', '1', 'pfVwuaTgK', '0', '0', '1458450973');
INSERT INTO `redpack_code` VALUES ('27', '3', '1', 'X9eFeLQjF', '0', '0', '1458450973');
INSERT INTO `redpack_code` VALUES ('28', '3', '1', 'LHkFRkdNp', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('29', '3', '1', 'kFXUBijCs', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('30', '3', '1', 'pfVvqTWLa', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('31', '3', '1', 'uKG9f81AN', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('32', '3', '1', 'jLaQEcPLf', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('33', '3', '1', 'WerpY4E9g', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('34', '3', '1', 'JplY2SGXY', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('35', '3', '1', 'tnupg7pmv', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('36', '3', '1', 'dO1v8L0bJ', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('37', '3', '1', 'w7RNn2oco', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('38', '3', '1', 'dlD1dRqve', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('39', '3', '1', 'VjEoifGo0', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('40', '3', '1', 'qaIyoZFjH', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('41', '3', '1', 'FKbq9rcem', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('42', '3', '1', 'NZjpbIuRA', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('43', '3', '1', 'QhijzgsP9', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('44', '3', '1', 'X9ezkJ4m7', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('45', '3', '1', 'sV5ShJjLK', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('46', '3', '1', 'GEYBDpL8g', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('47', '3', '1', 'Szh3DHcZT', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('48', '3', '1', 'EmZIL5DQF', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('49', '3', '1', 'H7na3Oou2', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('50', '3', '1', 'Rc5qTHXlI', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('51', '3', '1', 'egq5rEsjJ', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('52', '3', '1', 'QhidENfWD', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('53', '3', '1', 'UoRcTLpiM', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('54', '3', '1', 'POTKQToMx', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('55', '3', '1', 'zkDEoKN2V', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('56', '3', '1', 'T1FC35kb8', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('57', '3', '1', 'OrI2wfUVk', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('58', '3', '1', 'sV5Pofnpp', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('59', '3', '1', 'bYrosK6qn', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('60', '3', '1', 'POTGZOY9e', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('61', '3', '1', 'tnusX8KmN', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('62', '3', '1', 'iQnDC1nLo', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('63', '3', '1', 'ol8igGrtc', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('64', '3', '1', 'YwqefW95R', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('65', '3', '1', 'vd4Iu23FB', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('66', '3', '1', 'Szh49LE2s', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('67', '3', '1', 'AHPjcL0gF', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('68', '3', '1', 'IWXjNl4cO', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('69', '3', '1', 'LHkJTICOe', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('70', '3', '1', 'jiMb2W2Lp', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('71', '3', '1', 'CZO7VAzgo', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('72', '3', '1', 'EmZPOhyYc', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('73', '3', '1', 'TWsG83D0N', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('74', '3', '1', 'rxUikzyaq', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('75', '3', '1', 's0iL0V94y', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('76', '3', '1', 'LHkHGWind', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('77', '3', '1', 'lAKXFod6w', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('78', '3', '1', 'T1FEKlueB', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('79', '3', '1', 'tnuoV1XYt', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('80', '3', '1', 'qD79uUCYW', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('81', '3', '1', 'XBDarc1cv', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('82', '3', '1', 'dO1CbCMC7', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('83', '3', '1', 'kdzn9CEZS', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('84', '3', '1', 'N4wlLzzVH', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('85', '3', '1', 'LHkCCXQv4', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('86', '3', '1', 'rxUfJh2X4', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('87', '3', '1', 'ZrdqwU7sr', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('88', '3', '1', 'ySfaZplhC', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('89', '3', '1', 'LeWcwdRaF', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('90', '3', '1', 'POTHgQeNc', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('91', '3', '1', 'cqPURmf19', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('92', '3', '1', 'YYOKq7ICU', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('93', '3', '1', 'aBfDSyga8', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('94', '3', '1', 'KMxzh40Hb', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('95', '3', '1', 'XBDbs4Qzs', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('96', '3', '1', 'DscEuH4r5', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('97', '3', '1', 'fbddNqtba', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('98', '3', '1', 'Tu46YwKvL', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('99', '3', '1', 'ol8jeVDaa', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('100', '3', '1', 'qaIuF8WeL', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('101', '3', '1', 'Kk91pCyAI', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('102', '3', '1', 'MC7QRnMiV', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('103', '3', '1', 'm39z6eXPn', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('104', '3', '1', 'GEYy1pKX4', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('105', '3', '1', 'BCCr1UaTB', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('106', '3', '1', 'IuyJ5hzVe', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('107', '3', '1', 'mvya20XEl', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('108', '3', '1', 'xv3nRRchs', '0', '0', '1458450974');
INSERT INTO `redpack_code` VALUES ('109', '3', '1', 'vDjB7IIjx', '0', '0', '1458451725');
INSERT INTO `redpack_code` VALUES ('110', '3', '1', 'wP2mLAcFX', '0', '0', '1458451725');
INSERT INTO `redpack_code` VALUES ('111', '3', '1', 'tfVuuMATI', '0', '0', '1458451725');
INSERT INTO `redpack_code` VALUES ('112', '3', '1', 's5gKDGrfT', '0', '0', '1458451725');
INSERT INTO `redpack_code` VALUES ('113', '3', '1', 'Ar5eA8EWt', '0', '0', '1458451725');
INSERT INTO `redpack_code` VALUES ('339', '1', '1', 'wEAKUW5D8G', '162', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('340', '1', '1', 'kFf3wxLu3H', '103', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('341', '1', '1', 'PH3nUntweb', '105', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('342', '1', '1', 'GcRaVLaPhn', '142', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('343', '1', '1', 'M49ei2gIfy', '118', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('344', '1', '1', 'pjUvJXGQUh', '148', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('345', '1', '1', 'mUvHuJtUKD', '121', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('346', '1', '1', 'P6pxEtxSVE', '158', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('347', '1', '1', 'T8wMz7HTzJ', '154', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('348', '1', '1', 'cEyy9uMP3J', '107', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('349', '1', '1', 'g3EBdAfnsW', '177', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('350', '1', '1', 'fJ9GR9zXdL', '109', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('351', '1', '1', 'KsVgWXfufb', '128', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('352', '1', '1', 'DEa7DICzaD', '142', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('353', '1', '1', 'rXNELkLwiN', '130', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('354', '1', '1', 'VRcGXkLtdp', '116', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('355', '1', '1', 'Vx6JCgDCdP', '143', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('356', '1', '1', 'RWexWuQrAJ', '159', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('357', '1', '1', 'vQqtsCJhb9', '131', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('358', '1', '1', 'SFD8DUUqBe', '175', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('359', '1', '1', 'SgV8MdmVeL', '127', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('360', '1', '1', 'GFadMgPqcw', '131', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('361', '1', '1', 'zq5Xv6Niff', '112', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('362', '1', '1', 'JXQSyLKqmC', '129', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('363', '1', '1', 'pt7BJ5wC76', '156', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('364', '1', '1', 'xXswrenQDy', '126', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('365', '1', '1', 'su7HNqS9pT', '107', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('366', '1', '1', 'r6EU3Fbkmc', '182', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('367', '1', '1', 'tPkNsPHkmd', '120', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('368', '1', '1', 'iX6EhVvxp3', '133', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('369', '1', '1', 'WaHB75EuUV', '113', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('370', '1', '1', 'CejV76hSvQ', '115', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('371', '1', '1', 'QigQ87Bq85', '133', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('372', '1', '1', 'XyaptHygLL', '167', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('373', '1', '1', 'He2jFHL3fm', '176', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('374', '1', '1', 'dKtsfCygLM', '113', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('375', '1', '1', 'P9WAxJ8Xrn', '177', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('376', '1', '1', 'jBHvEiPmHh', '170', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('377', '1', '1', 'dGRpjXjT4u', '118', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('378', '1', '1', 'Cd9gh4dSRp', '121', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('379', '1', '1', 'MkPM2UXQFV', '152', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('380', '1', '1', 'AzyUFusud9', '139', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('381', '1', '1', 'nWNyIcrVuB', '148', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('382', '1', '1', 'aSN8z2qfua', '130', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('383', '1', '1', 'CnFInLqHHm', '136', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('384', '1', '1', 'shmyNWILws', '133', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('385', '1', '1', 'k6Xyrqdvat', '157', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('386', '1', '1', 'JKU5kq2Sw2', '132', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('387', '1', '1', 'XVPptRSbgq', '139', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('388', '1', '1', 'teSEU3fWHR', '150', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('389', '1', '1', 'DMvSeK3miG', '116', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('390', '1', '1', 'WtsbKI5JVb', '115', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('391', '1', '1', 'C9ydxRPEQD', '105', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('392', '1', '1', 'THVWc3CtLA', '129', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('393', '1', '1', 'rQEyWWiStQ', '102', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('394', '1', '1', 'I6KFQ2JT6W', '130', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('395', '1', '1', 'tFX492kNtr', '105', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('396', '1', '1', 'eTJGRVHkab', '115', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('397', '1', '1', 'Lu6rP8VbWc', '152', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('398', '1', '1', 'cfQxSqDMWc', '125', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('399', '1', '1', 'Ukq8LDCcvK', '161', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('400', '1', '1', 'zzCtyEqASB', '156', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('401', '1', '1', 'kiUpH4rbHD', '117', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('402', '1', '1', 'nBwTTRjsrI', '134', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('403', '1', '1', 'PB4VRvynp3', '185', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('404', '1', '1', 'JudusyM4Qq', '119', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('405', '1', '1', 'QXuJgt6ykK', '136', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('406', '1', '1', 'RRsMgpMR85', '108', '0', '1458532052');
INSERT INTO `redpack_code` VALUES ('407', '1', '1', 'niMm2hdEQS', '179', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('408', '1', '1', 'wEAKKm4jBM', '133', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('409', '1', '1', 'm6U3zpLc9t', '107', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('410', '1', '1', 'STKDGU3ehE', '108', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('411', '1', '1', 'uEHNAR2qsK', '101', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('412', '1', '1', 'pJNcBII7TF', '143', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('413', '1', '1', 'fmDpp72ICL', '122', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('414', '1', '1', 'xyyNImt2yg', '101', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('415', '1', '1', 'MpfbmTHrIi', '162', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('416', '1', '1', 'hD4eSJ9U6P', '130', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('417', '1', '1', 'HMfLAa4FsQ', '147', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('418', '1', '1', 'ubg6T8n8xR', '113', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('419', '1', '1', 'jqWm4AiiCr', '123', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('420', '1', '1', 'dmKsiiaWUH', '113', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('421', '1', '1', 'tXGC9jrU4D', '133', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('422', '1', '1', 'iEbpGpGkBz', '121', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('423', '1', '1', 'kbKhVHw6Wz', '159', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('424', '1', '1', 'MpfbqdDmmv', '161', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('425', '1', '1', 'ASudhiMR8k', '161', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('426', '1', '1', 'hADQAw2K6y', '153', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('427', '1', '1', 'ipPc9bRSBd', '120', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('428', '1', '1', 'c8GsgWmbuq', '160', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('429', '1', '1', 'iNHQMcM3NV', '120', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('430', '1', '1', 'nNtKr5fN5f', '111', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('431', '1', '1', 'pnjQX5hPCC', '122', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('432', '1', '1', 'ajzDvsQDpt', '133', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('433', '1', '1', 'gfBsBIkSBh', '113', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('434', '1', '1', 'MJxLWwFCWJ', '165', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('435', '1', '1', 'AvWS4zhbPV', '126', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('436', '1', '1', 'dcdWhVSDiW', '113', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('437', '1', '1', 'UTDB5tTDu6', '112', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('438', '1', '1', 'U7gAJKhCsh', '106', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('439', '1', '1', 'c8Gs3Xqt5p', '117', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('440', '1', '1', 'jR4HdR6nrQ', '108', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('441', '1', '1', 'QSH2WMXyyF', '151', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('442', '1', '1', 'rVsimx6VfR', '112', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('443', '1', '1', 'frestKxyWs', '171', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('444', '1', '1', 'eDeMyHwsBt', '128', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('445', '1', '1', 'tRIcRc8bcJ', '129', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('446', '1', '1', 'r6EUf2Kaxq', '127', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('447', '1', '1', 'EGtVgDBaGw', '120', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('448', '1', '1', 'Dznnm6yX5X', '167', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('449', '1', '1', 'SRphzT5ngT', '180', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('450', '1', '1', 'jeecfkuS63', '124', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('451', '1', '1', 'Cj7FBKKPm4', '122', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('452', '1', '1', 'kFf3AsWLdj', '183', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('453', '1', '1', 'miQQTTXEyr', '166', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('454', '1', '1', 'CFqj9SPKRb', '103', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('455', '1', '1', 'WeiDWn9Qby', '132', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('456', '1', '1', 'ngqWWIAN7U', '111', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('457', '1', '1', 'Nhdefru6DV', '155', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('458', '1', '1', 'rrKRkrWC8r', '128', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('459', '1', '1', 'qm5EEnecMC', '169', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('460', '1', '1', 'xmMF2TbEmc', '151', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('461', '1', '1', 'PIe5DvQg8u', '121', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('462', '1', '1', 'XuzkMxkeCF', '117', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('463', '1', '1', 'GgtdQN6cIa', '134', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('464', '1', '1', 'qBpR9DrG4s', '131', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('465', '1', '1', 'AGI4uiHc87', '166', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('466', '1', '1', 'AesXNNUkGQ', '125', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('467', '1', '1', 't5mcPMw6Xk', '118', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('468', '1', '1', 'atUs768Lvx', '133', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('469', '1', '1', 'dTNeF5QdPF', '137', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('470', '1', '1', 'UjdspS8sSR', '140', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('471', '1', '1', 'kGrHcsENmS', '125', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('472', '1', '1', 'GUurkGFqAE', '130', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('473', '1', '1', 'HjWIIt5CIQ', '133', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('474', '1', '1', 'WABhRPNPPL', '116', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('475', '1', '1', 'piIN8I6Btt', '143', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('476', '1', '1', 'bId8R5UKRF', '117', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('477', '1', '1', 'C3zLjygqHB', '120', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('478', '1', '1', 'EBGdJBDxhX', '122', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('479', '1', '1', 'CD2UWeRQWh', '104', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('480', '1', '1', 'RuVuXne4yz', '116', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('481', '1', '1', 'nfeiiFMSXF', '177', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('482', '1', '1', 'yXnXByb7nb', '100', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('483', '1', '1', 'TFzB4Rfvwp', '105', '0', '1458532053');
INSERT INTO `redpack_code` VALUES ('484', '1', '1', 'g64WrV9HxK', '130', '0', '1458532054');
INSERT INTO `redpack_code` VALUES ('485', '1', '1', 'CUIwPj7RiB', '102', '0', '1458532054');
INSERT INTO `redpack_code` VALUES ('486', '1', '1', 'xuWL5LGAFy', '124', '0', '1458532054');
INSERT INTO `redpack_code` VALUES ('487', '1', '1', 'Vr8kFXpXfU', '140', '0', '1458532054');
INSERT INTO `redpack_code` VALUES ('488', '1', '1', 'kbKiaX4TGv', '169', '0', '1458532054');
INSERT INTO `redpack_code` VALUES ('489', '1', '1', 'qQAcPFgTV', '100', '0', '1458532936');
INSERT INTO `redpack_code` VALUES ('490', '1', '1', 'Ar5jCz6sF', '100', '0', '1458533066');
INSERT INTO `redpack_code` VALUES ('491', '1', '1', 'fj83gQc9g', '100', '0', '1458533086');
INSERT INTO `redpack_code` VALUES ('492', '1', '1', 'MmSqFCDRx', '100', '0', '1458533093');
INSERT INTO `redpack_code` VALUES ('493', '1', '1', 'axnpasuqF', '100', '0', '1458533149');

-- ----------------------------
-- Table structure for redpack_record
-- ----------------------------
DROP TABLE IF EXISTS `redpack_record`;
CREATE TABLE `redpack_record` (
  `redpack_record_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(30) NOT NULL DEFAULT '',
  `key` varchar(30) NOT NULL DEFAULT '',
  `redpack_id` int(11) unsigned NOT NULL DEFAULT '0',
  `mch_billno` varchar(60) NOT NULL DEFAULT '' COMMENT '支付号',
  `mch_id` varchar(60) NOT NULL DEFAULT '' COMMENT '支付id',
  `money` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '金额',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态,0正常,1异常',
  `errno` varchar(30) NOT NULL DEFAULT '' COMMENT '错误号',
  `error` varchar(255) NOT NULL DEFAULT '' COMMENT '错误信息',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`redpack_record_id`),
  KEY `ssr` (`site_id`,`status`,`redpack_id`) USING BTREE,
  KEY `sors` (`site_id`,`openid`,`redpack_id`,`status`) USING BTREE,
  KEY `soks` (`site_id`,`openid`,`key`,`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='包红兑换记录表';

-- ----------------------------
-- Records of redpack_record
-- ----------------------------
INSERT INTO `redpack_record` VALUES ('1', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', '', '3', '3', '252542', '1', '3', '255', '', '', '1458263524');

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `setting_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(60) NOT NULL,
  `name` varchar(30) NOT NULL,
  `value` varchar(60) NOT NULL,
  `is_require` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必须,0否,1是',
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='配置表';

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES ('2', 'site_domain', '站点地址', 'http://demo.weifans.cn/', '1');
INSERT INTO `setting` VALUES ('3', 'site_name', '站点名称', '', '1');
INSERT INTO `setting` VALUES ('4', 'site_title', '站点标题', '', '1');
INSERT INTO `setting` VALUES ('6', 'site_keywords', '站点关键词', '', '1');
INSERT INTO `setting` VALUES ('7', 'site_description', '站点描述', '', '1');
INSERT INTO `setting` VALUES ('8', 'site_mail', '站点邮箱', '', '1');
INSERT INTO `setting` VALUES ('9', 'site_logo', '站点logo', '/resource/images/logo.jpg', '1');
INSERT INTO `setting` VALUES ('10', 'site_icon', '站点icon', '/resource/images/logo.jpg', '1');
INSERT INTO `setting` VALUES ('11', 'code_digit', '礼包码位数', '9', '1');
INSERT INTO `setting` VALUES ('12', 'redpack_digit', '红包码位数', '10', '1');
INSERT INTO `setting` VALUES ('13', 'site_ip', '站点ip', '', '1');

-- ----------------------------
-- Table structure for shoppingcart
-- ----------------------------
DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE `shoppingcart` (
  `shoppingcart_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车表',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0',
  `price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价格',
  `money` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总价',
  `amount` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '产品数',
  `deal_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '处理状态',
  `deal_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`shoppingcart_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shoppingcart
-- ----------------------------
INSERT INTO `shoppingcart` VALUES ('1', '8', '148', '45.55', '45.55', '1', '0', '0', '2014');
INSERT INTO `shoppingcart` VALUES ('2', '8', '148', '45.55', '45.55', '1', '0', '0', '2014');

-- ----------------------------
-- Table structure for signin
-- ----------------------------
DROP TABLE IF EXISTS `signin`;
CREATE TABLE `signin` (
  `signin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '签到名称',
  `count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '签到次数',
  `cycle` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '周期',
  `is_continue` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否连续签到,0不连续,1连续',
  `is_loop` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否循环签到,0不循环,1循环',
  `has_code` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有礼包码',
  `item_count` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '子项数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`signin_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='签到表';

-- ----------------------------
-- Records of signin
-- ----------------------------
INSERT INTO `signin` VALUES ('1', '1', '121签到', '0', '300', '0', '1', '0', '2', '1457918031');

-- ----------------------------
-- Table structure for signin_item
-- ----------------------------
DROP TABLE IF EXISTS `signin_item`;
CREATE TABLE `signin_item` (
  `signin_item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `signin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `code_id` int(11) unsigned NOT NULL DEFAULT '0',
  `success_word` text NOT NULL COMMENT '说明',
  `repeat_word` text NOT NULL COMMENT '重复文字',
  `times` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`signin_item_id`),
  KEY `signin_id` (`signin_id`,`times`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='签到子项表';

-- ----------------------------
-- Records of signin_item
-- ----------------------------
INSERT INTO `signin_item` VALUES ('64', '1', '0', '第一次签到,您获得的礼包码是{code}.哈哈哈', '第一次签到,您签到重复了.距离下次签到时间{time}', '1', '0');
INSERT INTO `signin_item` VALUES ('65', '1', '0', '第二次签到,您获得的礼包码是{code}.哈哈哈', '第二次签到,您签到重复了,距离下次签到时间{time}', '2', '0');

-- ----------------------------
-- Table structure for signin_record
-- ----------------------------
DROP TABLE IF EXISTS `signin_record`;
CREATE TABLE `signin_record` (
  `signin_record_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `signin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(30) NOT NULL DEFAULT '',
  `code_id` int(11) unsigned NOT NULL DEFAULT '0',
  `code_item_id` int(11) unsigned NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL DEFAULT '',
  `code_send_result` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发码结果,0未知,1正确,2失败',
  `code_send_reason` text NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '发码描述',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`signin_record_id`),
  KEY `site_id` (`site_id`,`signin_id`),
  KEY `site_id_2` (`site_id`,`openid`,`signin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='签到记录表';

-- ----------------------------
-- Records of signin_record
-- ----------------------------
INSERT INTO `signin_record` VALUES ('1', '1', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', '3', '0', '签到第1次, 获得礼包码', '2', '签到1', '', '1458294280');
INSERT INTO `signin_record` VALUES ('2', '1', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', '4', '0', '签到第2次, 获得礼包码', '2', '签到1', '', '1458294767');
INSERT INTO `signin_record` VALUES ('3', '1', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', '0', '0', '签到第1次, 获得礼包码', '0', '', '', '1458376926');

-- ----------------------------
-- Table structure for signin_user
-- ----------------------------
DROP TABLE IF EXISTS `signin_user`;
CREATE TABLE `signin_user` (
  `signin_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID,做统计用',
  `signin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(30) NOT NULL DEFAULT '',
  `total_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '总签到数',
  `keep_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '连续签到数',
  `last_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次签到时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`signin_user_id`),
  KEY `site_id` (`site_id`,`signin_id`,`openid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户与每个签到状态统计表';

-- ----------------------------
-- Records of signin_user
-- ----------------------------
INSERT INTO `signin_user` VALUES ('1', '1', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', '5', '1', '1458376926', '1458283085');

-- ----------------------------
-- Table structure for site
-- ----------------------------
DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
  `site_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '站点表',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL DEFAULT '',
  `token` varchar(60) NOT NULL DEFAULT '',
  `appid` varchar(60) NOT NULL,
  `appsecret` varchar(60) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型,0订阅号,1服务号',
  `verify` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '认证状态,0未认证,1已认证',
  `connect_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '通信状态',
  `connect_last_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '通信时间(一天记一次)',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态,0未开通,1已开通',
  `pay_api_key` varchar(60) NOT NULL DEFAULT '' COMMENT '支付key',
  `pay_mch_id` varchar(60) NOT NULL DEFAULT '' COMMENT '支付id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='微信站点表';

-- ----------------------------
-- Records of site
-- ----------------------------
INSERT INTO `site` VALUES ('1', '1', '87257302测试', '123456', 'wx8df4eabe2fdcf037', 'e8c7aabb7e43eb3db4996f17db234ecf', 'http://www.weifans.cn/client/1', '0', '0', '1', '1476779668', '0', '', '', '0');
INSERT INTO `site` VALUES ('11', '1', '123', '123', '123', '123', '', '1', '1', '0', '0', '0', '', '', '1460626157');

-- ----------------------------
-- Table structure for site_shop
-- ----------------------------
DROP TABLE IF EXISTS `site_shop`;
CREATE TABLE `site_shop` (
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `title` varchar(60) NOT NULL,
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '模板',
  `keywords` varchar(150) NOT NULL,
  `description` varchar(150) NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='站点shop站';

-- ----------------------------
-- Records of site_shop
-- ----------------------------
INSERT INTO `site_shop` VALUES ('3', '测试微信号', '', '', '', '', '0');
INSERT INTO `site_shop` VALUES ('1', '87257302测试', '', '', '', '', '0');

-- ----------------------------
-- Table structure for site_wap
-- ----------------------------
DROP TABLE IF EXISTS `site_wap`;
CREATE TABLE `site_wap` (
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `title` varchar(60) NOT NULL,
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '模板',
  `keywords` varchar(150) NOT NULL,
  `description` varchar(150) NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='站点wap表';

-- ----------------------------
-- Records of site_wap
-- ----------------------------
INSERT INTO `site_wap` VALUES ('3', '测试微信号', '', '', '', '', '0');
INSERT INTO `site_wap` VALUES ('1', '87257302测试', '', '', '', '', '0');
INSERT INTO `site_wap` VALUES ('2', '清风徐来', '', '', '', '', '0');
INSERT INTO `site_wap` VALUES ('5', 'jiggingshop', '', '', '', '', '0');

-- ----------------------------
-- Table structure for trade
-- ----------------------------
DROP TABLE IF EXISTS `trade`;
CREATE TABLE `trade` (
  `trade_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '交易表',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `money` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `deal_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '处理状态',
  `deal_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `pay_type` enum('online','balance','agent','cod') NOT NULL DEFAULT 'online' COMMENT '支付方式,在线支付,余额支付,代付,货到付款',
  `pay_platform` varchar(30) NOT NULL DEFAULT '' COMMENT '支付平台,如支付宝',
  `pay_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态',
  `pay_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '用户附加说明',
  PRIMARY KEY (`trade_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trade
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(30) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(60) NOT NULL,
  `sex` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `province` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `headimgurl` varchar(255) NOT NULL,
  `subscribe_time` varchar(30) NOT NULL COMMENT '关注用户表',
  `unionid` varchar(60) NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`user_id`),
  KEY `so` (`site_id`,`openid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户(微信)表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '0', 'o5pIYuHOynalhTIXN7ACK5G5gc3M', '', '', '清风徐来', '1', ' 	海淀', '北京', '中国', 'http://wx.qlogo.cn/mmopen/KXQKkAstPia7ZfUZXLu0MJGq8WiaU6iadTX2riaWSU4ek8VC3duTXpT6qPuxwEQv4rDIdjW6qibSMTXWEAguKkqc7cKoh1jURuzNic/0', '', '', '0');
INSERT INTO `user` VALUES ('2', '1', 'o2j3wjlsOyxHlLYsRDHVE4_jY1L8', '', '', '', '', '', '', '', '', '', '', '0');

-- ----------------------------
-- Table structure for user_attribute
-- ----------------------------
DROP TABLE IF EXISTS `user_attribute`;
CREATE TABLE `user_attribute` (
  `user_id` int(11) unsigned NOT NULL,
  `balance` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '资金余额',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论总数',
  `signin_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '签到总数',
  `code_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '礼包码总数',
  `redpack_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '红包总数',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户属性表';

-- ----------------------------
-- Records of user_attribute
-- ----------------------------

-- ----------------------------
-- Table structure for user_record
-- ----------------------------
DROP TABLE IF EXISTS `user_record`;
CREATE TABLE `user_record` (
  `record_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户登录记录表',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `event` varchar(255) NOT NULL DEFAULT '' COMMENT '事件',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=238 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_record
-- ----------------------------
