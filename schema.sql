/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : la

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2013-04-12 16:43:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `mob`
-- ----------------------------
DROP TABLE IF EXISTS `mob`;
CREATE TABLE `mob` (
`vnum`  int(11) NOT NULL ,
`player_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`short_descr`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`long_descr`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`act`  set('is_npc','sentinel','scavenger','halt','fightscr','aggressive','stay_area','wimpy','pet','train','practice','gamble','join','undead','wind','learn','scramble','trackscr','tracking','angry','immortal','blacksmith','assist','backstab','inn_keeper','mountable') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`affected_by`  set('blind','invis','detect_evil','detect_invis','detect_magic','detect_hidden','hold','sanctuary','faerie_fire','infrared','curse','flaming','poison','protect','paralysis','sneak','hide','sleep','charm','flying','pass_door','waterwalk','summoned','mute','gills','berserk','stealth','hasteslash','d_protect','berserker') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`alignment`  int(11) NOT NULL ,
`level`  int(11) NOT NULL ,
`hitroll`  int(11) NOT NULL ,
`ac`  int(11) NOT NULL ,
`gold`  int(11) NOT NULL ,
`script`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`vnum`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `object`
-- ----------------------------
DROP TABLE IF EXISTS `object`;
CREATE TABLE `object` (
`vnum`  int(11) NOT NULL ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`short_descr`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`item_type`  enum('light','scroll','wand','staff','weapon','arrows','wcontainer','treasure','armor','potoin','item_11','furniture','trash','item_14','container','item_16','drink_con','key','food','money','item_21','boat','corpse_npc','corpse_pc','fountain','pill') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`extra_flags`  set('glow','hum','dark','lock','evil','invis','magic','nodrop','bless','anti_good','anti_evil','anti_neutral','noremove','inventory','poisoned','trap') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`wear_flag`  set('take','finger','neck','body','head','legs','feet','hands','arms','shield','about','waist','wrist','wield','hold') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`v0`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`v1`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`v2`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`v3`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`weight`  int(11) NOT NULL ,
`cost`  int(11) NOT NULL ,
PRIMARY KEY (`vnum`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `object_affects`
-- ----------------------------
DROP TABLE IF EXISTS `object_affects`;
CREATE TABLE `object_affects` (
`obj_vnum`  int(11) NOT NULL ,
`flag`  enum('str','dex','int','wis','con','sex','class','level','age','height','weight','mana','hit','move','gold','exp','ac','hitroll','damroll','saving_para','saving_rod','saving_petri','saving_breath','saving_spell','round') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`modifier`  int(11) NOT NULL ,
FOREIGN KEY (`obj_vnum`) REFERENCES `object` (`vnum`) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `object_ed`
-- ----------------------------
DROP TABLE IF EXISTS `object_ed`;
CREATE TABLE `object_ed` (
`obj_vnum`  int(11) NOT NULL ,
`keyword`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
FOREIGN KEY (`obj_vnum`) REFERENCES `object` (`vnum`) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `room`
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
`vnum`  int(11) NOT NULL ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`desc`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`flags`  int(11) NOT NULL ,
`sector_type`  enum('city','field','forest','hills','mountain','water_swim','water_noswim','underwater','air','desert') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`light`  int(11) NOT NULL ,
PRIMARY KEY (`vnum`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `room_exits`
-- ----------------------------
DROP TABLE IF EXISTS `room_exits`;
CREATE TABLE `room_exits` (
`room_vnum`  int(11) NOT NULL ,
`to_room`  int(11) NOT NULL ,
`direction`  int(11) NOT NULL ,
`description`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`keyword`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`lock_vnum`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- View structure for `v_objects`
-- ----------------------------
DROP VIEW IF EXISTS `v_objects`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_objects` AS select `la`.`objs`.`vnum` AS `vnum`,`la`.`objs`.`name` AS `name`,`la`.`objs`.`short_descr` AS `short_descr`,`la`.`objs`.`description` AS `description`,`la`.`objs`.`item_type` AS `item_type`,`la`.`objs`.`extra_flags` AS `extra_flags`,`la`.`objs`.`wear_flag` AS `wear_flag`,`la`.`objs`.`v0` AS `v0`,`la`.`objs`.`v1` AS `v1`,`la`.`objs`.`v2` AS `v2`,`la`.`objs`.`v3` AS `v3`,`la`.`objs`.`weight` AS `weight`,`la`.`objs`.`cost` AS `cost`,`la`.`objs_affects`.`flag` AS `flag`,`la`.`objs_affects`.`modifier` AS `modifier` from (`objs` left join `objs_affects` on((`la`.`objs_affects`.`obj_vnum` = `la`.`objs`.`vnum`)));

-- ----------------------------
-- Indexes structure for table object_affects
-- ----------------------------
CREATE INDEX `obj_vnum` ON `object_affects`(`obj_vnum`) USING BTREE ;

-- ----------------------------
-- Indexes structure for table object_ed
-- ----------------------------
CREATE INDEX `obj_vnum` ON `object_ed`(`obj_vnum`) USING BTREE ;

-- ----------------------------
-- Indexes structure for table room_exits
-- ----------------------------
CREATE INDEX `room_vnum` ON `room_exits`(`room_vnum`) USING BTREE ;
