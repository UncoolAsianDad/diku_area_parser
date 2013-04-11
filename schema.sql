/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : la

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2013-04-11 09:48:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `objs`
-- ----------------------------
DROP TABLE IF EXISTS `objs`;
CREATE TABLE `objs` (
`vnum`  int(11) NOT NULL ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`short_descr`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`action_desc`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`item_type`  enum('light','scroll','wand','staff','weapon','arrows','wcontainer','treasure','armor','potoin','item_11','furniture','trash','item_14','container','item_16','drink_con','key','food','money','item_21','boat','corpse_npc','corpse_pc','fountain','pill') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`extra_flags`  set('glow','hum','dark','lock','evil','invis','magic','nodrop','bless','anti_good','anti_evil','anti_neutral','noremove','inventory','poisoned','trap') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`wear_flag`  set('take','finger','neck','body','head','legs','feet','hands','arms','shield','about','waist','wrist','wield','hold') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`v0`  int(11) NULL DEFAULT NULL ,
`v1`  int(11) NULL DEFAULT NULL ,
`v2`  int(11) NULL DEFAULT NULL ,
`v3`  int(11) NULL DEFAULT NULL ,
`weight`  int(11) NOT NULL ,
`cost`  int(11) NOT NULL ,
PRIMARY KEY (`vnum`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `objs_affects`
-- ----------------------------
DROP TABLE IF EXISTS `objs_affects`;
CREATE TABLE `objs_affects` (
`obj_vnum`  int(11) NOT NULL ,
`flag`  enum('str','dex','int','wis','con','sex','class','level','age','height','weight','mana','hit','move','gold','exp','ac','hitroll','damroll','saving_para','saving_rod','saving_petri','saving_breath','saving_spell','round') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`modifier`  int(11) NOT NULL ,
FOREIGN KEY (`obj_vnum`) REFERENCES `objs` (`vnum`) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- View structure for `obj_view`
-- ----------------------------
DROP VIEW IF EXISTS `obj_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `obj_view` AS select `objs`.`vnum` AS `vnum`,`objs`.`name` AS `name`,`objs`.`short_descr` AS `short_descr`,`objs`.`description` AS `description`,`objs`.`action_desc` AS `action_desc`,`objs`.`item_type` AS `item_type`,`objs`.`extra_flags` AS `extra_flags`,`objs`.`wear_flag` AS `wear_flag`,`objs`.`v0` AS `v0`,`objs`.`v1` AS `v1`,`objs`.`v2` AS `v2`,`objs`.`v3` AS `v3`,`objs`.`weight` AS `weight`,`objs`.`cost` AS `cost`,`objs_affects`.`flag` AS `flag`,`objs_affects`.`modifier` AS `modifier` from (`objs` left join `objs_affects` on((`objs_affects`.`obj_vnum` = `objs`.`vnum`)));

-- ----------------------------
-- Indexes structure for table objs_affects
-- ----------------------------
CREATE INDEX `obj_vnum` ON `objs_affects`(`obj_vnum`) USING BTREE ;
